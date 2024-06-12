<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadEvents;
use App\Models\Note;
use App\Models\Source;
use App\Models\SubSource;
use App\Models\User;
use App\Utils\Util;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebhookReceiverController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $util;

    /**
     * Constructor
     *
     */
    public function __construct(Util $util)
    {
        $this->util = $util;
    }

    /**
     * webhook coming during
     * form submission
     */
    public function processor(Request $request, $secret)
    {
        $subsource = SubSource::where('webhook_secret', $secret)
            ->firstOrFail();

        if (!empty($subsource) && !empty($request->all())) {
            $response = $this->util->createLead($subsource, $request->all());
            return response()->json($response['msg']);
        }

    }
    public function getNewLeadWebhookLog(Request $request)
    {
        if (!auth()->user()->checkPermission('webhook')) {
            abort(403, 'Unauthorized.');
        }

        $search_text = $request->get('search', '');
        $new_leads_history = $this->__getNewLeadActivityHistory($request);
        $eventTypes = LeadEvents::select('event_type')->distinct()->pluck('event_type');
        $selectedEventType = $request->get('event_type', '');
        $selectedDateRange = $request->get('date_range', '');

        // Debugging line to check data
        // dd($new_leads_history);

        return view('admin.webhook.new_lead_log')
            ->with(compact('new_leads_history', 'search_text', 'eventTypes', 'selectedDateRange', 'selectedEventType'));
    }

    public function getLeadActivitiesWebhookLog(Request $request)
    {
        if (!auth()->user()->checkPermission('webhook')) {
            abort(403, 'Unauthorized.');
        }

        // Fetch distinct event types
        $eventTypes = LeadEvents::select('event_type')->distinct()->pluck('event_type');

        // Fetch lead activities based on filters
        $leads_activities_history = $this->__getLeadActivityHistory($request);
        $search_text = $request->get('search', '');
        $selectedEventType = $request->get('event_type', ''); // Add this line to get the selected event type

        // Determine the selected date range
        $selectedDateRange = $request->get('date_range', '');
        return view('admin.webhook.lead_activities_log', compact('leads_activities_history', 'search_text', 'eventTypes', 'selectedEventType', 'selectedDateRange'));
    }

    /**
     * new lead coming
     * from sell.do
     */
    public function storeNewLead(Request $request)
    {
        try {
            $req_data = $request->json()->all();
            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            if (isset($req_data['lead_id']) && !empty($req_data['lead_id'])) {
                $lead = $this->util->getLeadBySellDoLeadId($req_data['lead_id']);
                $existing_system_fields = json_decode($lead->system_fields, true);

                $date = @$system_fields[0]['Lead Date'];
                $exist_an_hour = false;
                if ($date) {
                    $hourdiff = (strtotime(date('Y-m-d H:i:s')) - strtotime($date))/3600;
                    if ($hourdiff > 1) {
                        $exist_an_hour = true;
                    }
                }
                
                if (!empty($lead) && $exist_an_hour) {
                    return response()->json(['message' => 'Lead is already present.'], 200);
                }

            }

            $leadFirstName = $req_data['lead']['first_name'] ?? '';
            $leadLastName = $req_data['lead']['last_name'] ?? '';
            $leadFullName = trim($leadFirstName . ' ' . $leadLastName) ?? [];

            $details['name'] = $leadFullName;
            $details['email'] = $req_data['lead']['email'] ?? null;
            $details['phone'] = $req_data['lead']['phone'] ?? null;
            $details['additional_email'] = $req_data['payload']['secondary_emails'][0] ?? null;
            $details['secondary_phone'] = $req_data['payload']['secondary_phones'][0] ?? null;

            $campaign_data = $req_data['payload']['campaign_responses'][0] ?? [];
            $project = $this->util->getProjectBySellDoProjectId($campaign_data);
            $details['project_id'] = !empty($project) ? $project->id : null;

            if (!empty($campaign_data['s']) && !empty($project)) {
                $source = Source::where('project_id', $project->id);

                if (in_array($campaign_data['s'], ['channel_partner'])) {
                    $source = $source->where('is_cp_source', 1);
                } else {
                    $source = $source->where('is_cp_source', 0)
                        ->where('source_name', 'like', '%' . $campaign_data['s'] . '%');
                }

                $source = $source->first();

                $details['source_id'] = $source->id ?? null;
            }
            $subsource = $this->util->getSubSourceBySrd($campaign_data);

            $details['campaign_id'] = null;

            $details['lead_details'] = [
                "age" => $req_data['payload']['age'] ?? '',
                "gender" => $req_data['payload']['gender'] ?? '',
                "married" => $req_data['payload']['married'] ?? '',
            ];

            $essentialFields = [
                'Full Name' => $leadFullName,
                'Phone Number' => $req_data['lead']['phone'] ?? null,
                'Email' => $req_data['lead']['email'] ?? null,
                'Addl Email' => $req_data['payload']['secondary_emails'],
                'Addl Number' => $req_data['payload']['secondary_phones'] ?? null,
                'Gender' => $req_data['payload']['gender'] ?? null,
            ];

            $salesFields = [
                'Sales Id' => $req_data['payload']['sales_id'] ?? null,
                'Team Id' => $req_data['payload']['team_id'] ?? null,
                'Team Name' => $req_data['payload']['team_name'] ?? null,
                'Lead Pickup date' => $req_data['payload']['recieved_on'] ?? null,
                'Lead Pickup Time' => $req_data['payload']['recieved_on'] ?? null,
                'Sales Name' => $req_data['payload']['sales_name'] ?? null,
            ];

            $systemFields = [
                'Project Id' =>  $req_data['payload']['campaign_responses'][0]['project_id']?? null,
                'Project' => $req_data['payload']['interested_properties_name'] ?? null,
                'Campaign Name' => $req_data['payload']['campaign_responses'][0]['campaign_name'] ?? null,
                'Source Name' => $req_data['payload']['s'][0]['s']?? null,
                'Sub Source' => $req_data['payload']['campaign_responses'][0]['ss']?? null,
                'Lead Date' => $req_data['payload']['recieved_on'] ?? null,
                'Lead Time' => $req_data['payload']['recieved_on'] ?? null,
                'Form id' => null,
                'Form Name' => null,
                'Form Url' => null,
            ];

            $sellDoFields = [
                'Sell Do Id' => $req_data['lead_id'] ?? null,
                'Sell Do Stage' => $req_data['payload']['stage'] ?? null,
                'Sell Do Status' => $req_data['payload']['status'] ?? null,
                'Sell Do Date' => $req_data['payload']['recieved_on'] ?? null,
                'Sell Do Time' => $req_data['payload']['recieved_on'] ?? null,
                'Notes' => $req_data['payload']['note_info']['last_note_by_pre_sales'] ?? null,
                'Tags' => $req_data['payload']['tags'] ?? null,
                'Funding Source' => null,
                'Site Visit Status' => null,
                'Site Visit Scheduled On' => null,
                'Hotness' => $req_data['payload']['hotness'] ?? null,
                'Min Budget' => null,
                'Max Budget' => null,
                'Medium Type' => $req_data['payload']['campaign_responses'][0]['m_t'] ?? null,
                'Medium Value' => $req_data['payload']['campaign_responses'][0]['m_v'] ?? null,
                'Medium Id' => $req_data['payload']['campaign_responses'][0]['mcid'] ?? null,
            ];

            $details['essential_fields'] = json_encode($essentialFields);
            $details['sales_fields'] = json_encode($salesFields);
            $details['system_fields'] = json_encode($systemFields);
            $details['sell_do_fields'] = json_encode($sellDoFields);
            $details['sell_do_stage'] = $req_data['payload']['stage'] ?? null;
            $details['sell_do_status'] = $req_data['payload']['status'] ?? null;
            $details['lead_event_webhook_response'] = $req_data;

            if (!empty($campaign_data['ss'])) {
                $user = User::where('name', 'like', '%' . $campaign_data['ss'] . '%')
                    ->first();

                $details['created_by'] = $user->id ?? null;
            }

            // $notes['lead_id'] = !empty($lead) ? $lead->id : null;
            // $notes['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            // $notes['notes'] = $req_data['payload']['notes_info'] ?? null;
            // $notes['event_type'] = $req_data['event'] ?? null;
            if (!$lead) {
                $lead = Lead::create($details);
                $lead->ref_num = $this->util->generateLeadRefNum($lead);
                $lead->save();
            } else {
                $input['lead_details'] = $details['lead_details'];
                $lead->update($input);
                $lead->system_fields = !empty($lead->system_fields) ? array_merge($lead->system_fields, $systemFields) : $systemFields;
                $lead->sell_do_fields = !empty($lead->sell_do_fields) ? array_merge($lead->sell_do_fields, $systemFields) : $sellDoFields;
                $lead->sales_fields = !empty($lead->sales_fields) ? array_merge($lead->sales_fields, $systemFields) : $salesFields;
                $lead->save();
                $this->util->storeUniqueWebhookFields($lead);
            }
            $notes = new Note();
            $notes->lead_id = $lead->id;
            $notes->sell_do_lead_id = $req_data['lead_id'] ?? null;
            $notes->notes = $req_data['payload']['note_info']['last_note_by_pre_sales'] ?? null;
            $notes->event_type = $req_data['event'] ?? null;
            $notes->save();

            $data = $this->util->storeUniqueWebhookFields($lead);
            $sell_do_response = json_decode($lead->sell_do_response, true);
            if (@$lead->sell_do_lead_id) {
                $this->util->createautomation($lead);
                $sales_fields = json_decode($lead->sales_fields, true);
                if($sales_fields['Team Id']) {
                    $this->util->sendInstaMsg($lead);
                    $this->sendGoogleSheet($lead);
                }
            }

            // return response()->json(['message' => 'Lead stored successfully', 'lead' => $lead], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store new lead:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }

    /**
     * lead activity coming from
     * sel.do
     */
    public function storeLeadActivity(Request $request)
    {
        try {
            $req_data = $request->all();

            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            $lead = $this->__updateLead($req_data);
            $activity['lead_id'] = !empty($lead) ? $lead->id : null;
            $activity['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            $activity['event_type'] = $req_data['event'] ?? null;
            $activity['webhook_data'] = $req_data;

            if (empty($activity['event_type'])) {
                return response()->json(['message' => 'Event is required.'], 404);
            }

            $event = LeadEvents::create($activity);

            //return response()->json(['message' => __('messages.success'), 'event' => $event], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store lead activity:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }

    public function updateLead(Request $request)
    {
        try {
            $req_data = $request->all();

            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            $lead = $this->__updateLead($req_data);
            $activity['lead_id'] = !empty($lead) ? $lead->id : null;
            $activity['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            $activity['event_type'] = $req_data['event'] ?? null;
            $activity['webhook_data'] = $req_data;

            if (empty($activity['event_type'])) {
                return response()->json(['message' => 'Event is required.'], 404);
            }

            $event = LeadEvents::create($activity);

            //return response()->json(['message' => __('messages.success'), 'event' => $event], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store lead activity:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }
    public function updateProfile(Request $request)
    {
        try {
            $req_data = $request->all();

            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            $lead = $this->__updateLead($req_data);
            $activity['lead_id'] = !empty($lead) ? $lead->id : null;
            $activity['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            $activity['event_type'] = $req_data['event'] ?? null;
            $activity['webhook_data'] = $req_data;

            if (empty($activity['event_type'])) {
                return response()->json(['message' => 'Event is required.'], 404);
            }

            $event = LeadEvents::create($activity);

            //return response()->json(['message' => __('messages.success'), 'event' => $event], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store lead activity:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }

    public function updateRequirement(Request $request)
    {
        try {
            $req_data = $request->all();

            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            $lead = $this->__updateLead($req_data);
            $activity['lead_id'] = !empty($lead) ? $lead->id : null;
            $activity['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            $activity['event_type'] = $req_data['event'] ?? null;
            $activity['webhook_data'] = $req_data;

            if (empty($activity['event_type'])) {
                return response()->json(['message' => 'Event is required.'], 404);
            }

            $event = LeadEvents::create($activity);

            //return response()->json(['message' => __('messages.success'), 'event' => $event], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store lead activity:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }
    public function updateStage(Request $request)
    {
        try {
            $req_data = $request->all();

            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            $lead = $this->__updateLead($req_data);
            $activity['lead_id'] = !empty($lead) ? $lead->id : null;
            $activity['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            $activity['event_type'] = $req_data['event'] ?? null;
            $activity['webhook_data'] = $req_data;

            if (empty($activity['event_type'])) {
                return response()->json(['message' => 'Event is required.'], 404);
            }

            $event = LeadEvents::create($activity);

            //return response()->json(['message' => __('messages.success'), 'event' => $event], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store lead activity:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $req_data = $request->all();

            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            $lead = $this->__updateLead($req_data);
            $activity['lead_id'] = !empty($lead) ? $lead->id : null;
            $activity['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            $activity['event_type'] = $req_data['event'] ?? null;
            $activity['webhook_data'] = $req_data;

            if (empty($activity['event_type'])) {
                return response()->json(['message' => 'Event is required.'], 404);
            }

            $event = LeadEvents::create($activity);

            //return response()->json(['message' => __('messages.success'), 'event' => $event], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store lead activity:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }

    public function noteAdded(Request $request)
    {
        try {
            $req_data = $request->all();

            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            $lead = $this->__updateLead($req_data);
            $activity['lead_id'] = !empty($lead) ? $lead->id : null;
            $activity['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            $activity['event_type'] = $req_data['event'] ?? null;
            $activity['webhook_data'] = $req_data;

            if (empty($activity['event_type'])) {
                return response()->json(['message' => 'Event is required.'], 404);
            }

            $event = LeadEvents::create($activity);

            //return response()->json(['message' => __('messages.success'), 'event' => $event], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store lead activity:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }

    public function leadReassigned(Request $request)
    {
        try {
            $req_data = $request->all();
            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            $lead = $this->__updateLead($req_data);
            $activity['lead_id'] = !empty($lead) ? $lead->id : null;
            $activity['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            $activity['event_type'] = $req_data['event'] ?? null;
            $activity['webhook_data'] = $req_data;

            if (empty($activity['event_type'])) {
                return response()->json(['message' => 'Event is required.'], 404);
            }

            $event = LeadEvents::create($activity);

            //return response()->json(['message' => __('messages.success'), 'event' => $event], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store lead activity:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }
    public function hotnessUpdated(Request $request)
    {
        try {
            $req_data = $request->all();

            if (empty($req_data)) {
                return response()->json(['message' => 'Request data is empty.'], 200);
            }

            $lead = $this->__updateLead($req_data);
            $activity['lead_id'] = !empty($lead) ? $lead->id : null;
            $activity['sell_do_lead_id'] = $req_data['lead_id'] ?? null;
            $activity['event_type'] = $req_data['event'] ?? null;
            $activity['webhook_data'] = $req_data;

            if (empty($activity['event_type'])) {
                return response()->json(['message' => 'Event is required.'], 404);
            }

            $event = LeadEvents::create($activity);
            $this->util->updateCustomField($lead, 531446, $req_data['payload']['hotness']);
            //return response()->json(['message' => __('messages.success'), 'event' => $event], 201);
        } catch (Exception $e) {
            $msg = 'File:' . $e->getFile() . ' | Line:' . $e->getLine() . ' | Message:' . $e->getMessage();
            \Log::info('store lead activity:- ' . $msg);
            //return response()->json(['message' => __('messages.something_went_wrong')], 404);
        }
    }
    
    protected function __getNewLeadActivityHistory($request)
    {
        $search_text = $request->get('search', '');
        $selectedDateRange = $request->get('date_range', '');
        $startDate = $request->get('start_date', '');
        $endDate = $request->get('end_date', '');
        $eventType = $request->get('event_type', '');

        // $query = LeadEvents::whereNotIn('event_type', ['document_sent']);

        // Filter by event type if selected
        // if (!empty($eventType)) {
        //     $query->where('event_type', $eventType);
        // }
        // Query to fetch leads
        $leadQuery = Lead::select('created_at', 'lead_event_webhook_response')
            ->whereNotNull('lead_event_webhook_response');

        // Date range filtering for leads
        switch ($selectedDateRange) {
            case 'today':
                $leadQuery->whereDate('created_at', Carbon::today());
                break;
            case 'yesterday':
                $leadQuery->whereDate('created_at', Carbon::yesterday());
                break;
            case 'last_month':
                $leadQuery->whereMonth('created_at', Carbon::now()->subMonth()->month);
                break;
            case 'this_month':
                $leadQuery->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'last_year':
                $leadQuery->whereYear('created_at', Carbon::now()->subYear()->year);
                break;
            case 'this_year':
                $leadQuery->whereYear('created_at', Carbon::now()->year);
                break;
            case 'custom_range':
                if (!empty($startDate) && !empty($endDate)) {
                    $leadQuery->whereBetween('created_at', [$startDate, $endDate]);
                }
                break;
        }

        // Fetch leads
        $leads = $leadQuery->orderBy('created_at', 'desc')->simplePaginate(30);

        // Decode the JSON and add the event field for leads
        $leads->each(function ($lead) {
            if (is_string($lead->lead_event_webhook_response)) {
                $response = json_decode($lead->lead_event_webhook_response, true);
                // Check if 'event' field exists in the decoded array
                $lead->event = isset($response['event']) ? $response['event'] : null;
            } else {
                $lead->event = null; // or handle as needed if it's not a string
            }
        });

        if (!empty($search_text)) {
            $leads->appends(['search' => $search_text]);
        }
        if (!empty($selectedDateRange)) {
            $leads->appends(['date_range' => $selectedDateRange]);
        }
        if (!empty($startDate)) {
            $leads->appends(['start_date' => $startDate]);
        }
        if (!empty($endDate)) {
            $leads->appends(['end_date' => $endDate]);
        }

        return $leads;
    }
    protected function __getLeadActivityHistory($request)
    {
        $search_text = $request->get('search', '');
        $eventType = $request->get('event_type', '');
        $dateRange = $request->get('date_range');

        $query = LeadEvents::whereNotIn('event_type', ['document_sent']);

        // Filter by event type if selected
        if (!empty($eventType)) {
            $query->where('event_type', $eventType);
        }

        // Add search functionality
        if (!empty($search_text)) {
            $query->where('webhook_data', 'like', '%' . $search_text . '%');
        }

        // Apply date range filtering based on 'created_at'
        if (!empty($dateRange)) {
            switch ($dateRange) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', today()->subDay());
                    break;
                case 'last_month':
                    $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                    break;
                case 'this_month':
                    $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
                case 'last_year':
                    $query->whereYear('created_at', now()->subYear()->year);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', now()->year);
                    break;
                case 'custom_range':
                    $startDate = $request->get('start_date');
                    $endDate = $request->get('end_date');
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                    break;
                default:
                    // Handle invalid date range
                    break;
            }
        }

        $activities = $query->orderBy('created_at', 'desc')
            ->simplePaginate(30);

        // Append search parameter if provided
        if (!empty($search_text)) {
            $activities->appends(['search' => $search_text]);
        }

        return $activities;
    }

    protected function __updateLead($req_data)
    {
        if (isset($req_data['lead_id']) && !empty($req_data['lead_id'])) {
            $lead = $this->util->getLeadBySellDoLeadId($req_data['lead_id']);

            if (
                !empty($lead) &&
                !empty($req_data['event']) & in_array($req_data['event'], [
                    'stage_changed', 'lead_updated', 'lead_requirement_updated',
                    'lead_profile_updated', 'lead_hotness_updated', 'lead_reassigned',
                ])
            ) {
                $lead_details = [
                    "age" => $req_data['payload']['age'] ?? '',
                    "gender" => $req_data['payload']['gender'] ?? '',
                    "married" => $req_data['payload']['married'] ?? '',
                ];
                $lead_details = !empty($lead->lead_info) ? array_merge($lead->lead_info, $lead_details) : $lead_details;

                $leadFirstName = $req_data['lead']['first_name'] ?? '';
                $leadLastName = $req_data['lead']['last_name'] ?? '';
                $leadFullName = trim($leadFirstName . ' ' . $leadLastName) ?? [];

                $essentialFields = [
                    'Full Name' => $leadFullName,
                    'Phone Number' => $req_data['lead']['phone'] ?? null,
                    'Email' => $req_data['lead']['email'] ?? null,
                    'Addl Email' => $req_data['payload']['secondary_emails'] ?? null,
                    'Addl Number' => $req_data['payload']['secondary_phones'] ?? null,
                    'Gender' => $req_data['payload']['gender'] ?? null,
                ];
                // foreach ($req_data['payload']['Sales Id'] as $response) {
                    $salesFields = [
                        'Sales Id' => $req_data['payload']['Sales Id'] ?? null,
                        'Team Id' => $req_data['payload']['team_id'] ?? null,
                        'Team Name' => $req_data['payload']['team_name'] ?? null,
                        'Lead Pickup date' => $req_data['payload']['recieved_on'] ?? null,
                        'Lead Pickup Time' => $req_data['payload']['recieved_on'] ?? null,
                        'Sales Name' => $req_data['sales_name'] ?? null,
                    ];
                // }
                $systemFields = [];

                foreach ($req_data['payload']['campaign_responses'] as $response) {
                    $systemFields[] = [
                        'Project Id' => $response['project_id'] ?? null,
                        'Project' => $response['project_name'] ?? null,
                        'Lead Date' => $req_data['payload']['recieved_on'] ?? null,
                        'Lead Time' => $req_data['payload']['recieved_on'] ?? null,
                        'Campaign Name' => $response['campaign_name'] ?? null,
                        'Source Name' => $response['s'] ?? null,
                        'Sub Source' => $response['ss'] ?? null,
                        'Form id' => $response['form_id'] ?? null,
                        'Form Name' => $response['form_name'] ?? null,
                        'Form Url' => $response['form_url'] ?? null,
                    ];
                }

                // Check for updated sales_id and update campaign_responses accordingly
                // $updatedSalesId = $req_data['payload']['Sales Id'] ?? null;
                // if ($updatedSalesId) {
                //     foreach ($req_data['payload']['campaign_responses'] as &$response) {
                //         $response['Sales Id'] = $updatedSalesId;
                //     }
                // }

                $sellDoFields = [
                    'Sell Do Id' => $req_data['lead_id'] ?? null,
                    'Sell Do Stage' => $req_data['payload']['stage'] ?? null,
                    'Sell Do Status' => $req_data['payload']['status'] ?? null,
                    'Sell Do Date' => $req_data['payload']['recieved_on'] ?? null,
                    'Sell Do Time' => $req_data['payload']['recieved_on'] ?? null,
                    'Notes' => $req_data['payload']['note_info'] ?? null,
                    'Tags' => null,
                    'Funding Source' => null,
                    'Site Visit Status' => null,
                    'Site Visit Scheduled On' => null,
                    'Hotness' => $req_data['payload']['hotness'] ?? null,
                    'Min Budget' => null,
                    'Max Budget' => null,
                    'Medium Type' => $req_data['payload']['campaign_responses']['m_t'] ?? null,
                    'Medium Value' => $req_data['payload']['campaign_responses']['m_v'] ?? null,
                    'Medium Id' => $req_data['payload']['campaign_responses']['mcid'] ?? null,
                ];

                // $inboxFields = [
                //     'Inbox User Id' => null,
                //     'Data Id' => null,
                // ];

                $lead['essential_fields'] = json_encode($essentialFields);
                $lead['sales_fields'] = json_encode($salesFields);
                $lead['system_fields'] = json_encode($systemFields);
                $lead['sell_do_fields'] = json_encode($sellDoFields);
                $lead['inbox_fields'] = json_encode($inboxFields);

                $lead->lead_details = $lead_details;
                $lead->save();
                $this->sendInstaMsg($lead);
                $this->sendGoogleSheet($lead);
            }

            return !empty($lead) ? $lead : null;
        }

        return null;
    }

}
