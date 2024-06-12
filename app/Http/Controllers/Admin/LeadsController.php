<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LeadsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLeadRequest;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Campaign;
use App\Models\Document;
use App\Models\Lead;
use App\Models\LeadEvents;
use App\Models\Project;
use App\Models\ProjectCampaign;
use App\Models\ProjectSource;
use App\Models\ProjectSubSource;
use App\Models\Source;
use App\Models\SubSource;
use App\Notifications\LeadDocumentShare;
use App\Utils\Util;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class LeadsController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $util;
    protected $lead_view;
    /**
     * Constructor
     *
     */
    public function __construct(Util $util)
    {
        $this->util = $util;
        $this->lead_view = ['list', 'kanban'];
    }

    public function index(Request $request)
    {
        $lead_view = Lead::all();
        $projects = Project::all();

        return view('admin.leads.index', compact('projects', 'lead_view'));
    }

    public function store(StoreLeadRequest $request)
    {
        $input = $request->except(['_method', '_token', 'redirect_to']);
        $input['lead_details'] = $this->getLeadDetailsKeyValuePair($input['lead_details'] ?? []);
        $input['created_by'] = auth()->user()->id;
    
        $project_ids = $this->util->getUserProjects(auth()->user());
        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
    
        if (auth()->user()->is_channel_partner && !empty($subsource)) {
            $input['subsource_id'] = $subsource->id;
        }
    
        $systemFields = $request->input('system_fields', []);
        $essentialFields = $request->input('essential_fields', []);
        $sellDoFields = $request->input('sell_do_fields', []);
        $salesFields = $request->input('sales_fields', []);
        $inboxFields = $request->input('inbox_fields', []);
    
        $subsourceId = $request->input('system_fields.Sub Source');
        $subsource = SubSource::with('source.campaign', 'source.project')->find($subsourceId);
        if ($subsource) {
            $project = $subsource->project;
            $campaign = $subsource->source->campaign;
            $source = $subsource->source;
    
            $systemFields = array_merge([
                'Project Id' => $project->id ?? null,
                'Project' => $project->name ?? null,
                'Campaign Name' => $campaign->campaign_name ?? null,
                'Source Name' => $source->name ?? null,
                'Sub Source' => $subsource->name ?? null,
                'Lead Date' => date('Y-m-d H:i:s'),
                'Lead Time' => date('Y-m-d H:i:s'),
                'Form id' => null,
                'Form Name' => null,
                'Form Url' => null,
            ], $systemFields);
    
            $essentialFields = array_merge([
                'Full Name' => null,
                'Phone Number' => null,
                'Email' => null,
                'Addl Email' => null,
                'Addl Number' => null,
                'Gender' => null,
            ], $essentialFields);
    
            $sellDoFields = array_merge([
                'Sell Do Id' => null,
                'Sell Do Stage' => null,
                'Sell Do Status' => null,
                'Sell Do Date' => null,
                'Sell Do Time' => null,
                'Notes' => null,
                'Tags' => null,
                'Funding Source' => null,
                'Site Visit Status' => null,
                'Site Visit Scheduled On' => null,
                'Hotness' => null,
                'Min Budget' => null,
                'Max Budget' => null,
                'Medium Type' => null,
                'Medium Value' => null,
                'Medium Id' => null,
            ], $sellDoFields);

            $salesFields = array_merge([
                'Sales Id' => null,
                'Team Id' => null,
                'Team Name' => null,
                'Lead Pickup date' => null,
                'Lead Pickup Time' => null,
                'Sales Name' => null,
            ], $salesFields);
    
            $inboxFields = [
                'Inbox User Id' => null,
                'Data Id' => null,
            ];
    
            $input['system_fields'] = json_encode($systemFields);
            $input['essential_fields'] = json_encode($essentialFields);
            $input['sales_fields'] = json_encode($salesFields);
            $input['inbox_fields'] = json_encode($inboxFields);
            $input['sell_do_fields'] = json_encode($sellDoFields);
            
            $subsource = SubSource::where('id', $input['sub_source_id'])->first();
            $campaign = Source::where('project_id', $source->source_id)->first();
            $lead = Lead::create($input);
            $lead->sub_source_id = $input['sub_source_id'];
            $lead->source_id = @$campaign->id;
            $lead->campaign_id = @$campaign->campaign_id;
            $lead->ref_num = $this->util->generateLeadRefNum($lead);
            $lead->save();
            // dd($lead->project->outgoing_apis);
            if (!empty($lead->project->outgoing_apis)) {
                $sell_do_response = json_decode($lead->sell_do_response, true);
                $this->util->sendApiWebhook($lead->id);
            }
    
            return redirect()->route('admin.leads.index')->with('success', 'Lead created successfully.');
        }

        return redirect()->route('admin.leads.index')->with('error', 'Subsource not found or missing related data.');
    }
    
  
    
    
    public function create()
    {
        // $campaigns = Campaign::whereIn('id', $campaign_ids)
        //     ->pluck('campaign_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $project_ids = $this->util->getUserProjects(auth()->user());
        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $project_id = request()->get('project_id', null);
        $phone = request()->get('phone', null);
        $action = request()->get('action', null);
        $sources = ProjectSource::all();
        $campaigns = ProjectCampaign::all();
        $subSources = SubSource::whereHas('source.project', function ($query) use ($project_id) {
            $query->where('id', $project_id);
        })->get();
        return view('admin.leads.create', compact('campaigns', 'project_id', 'phone', 'action', 'sources', 'subSources'));
    }
    public function edit(Lead $lead)
    {
        if (!auth()->user()->checkPermission('lead_edit')) {
            abort(403, 'Unauthorized.');
        }

        $project_ids = $this->util->getUserProjects(auth()->user());
        $campaign_ids = $this->util->getCampaigns(auth()->user(), $project_ids);

        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $campaigns = Campaign::whereIn('id', $campaign_ids)
            ->pluck('campaign_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lead->load('project', 'campaign');

        return view('admin.leads.edit', compact('campaigns', 'lead', 'projects'));
    }

    public function leadIndex(Request $request, $newProjectId)
    {
        if (!auth()->user()->checkPermission('lead_view')) {
            abort(403, 'Unauthorized.');
        }

        $lead_view = empty($request->view) ? 'list' : (in_array($request->view, $this->lead_view) ? $request->view : 'list');
        $__global_clients_filter = $this->util->getGlobalClientsFilter();
        $query = $this->util->getFilteredLeads($request);
        if (!empty($__global_clients_filter)) {
            $project_ids = $this->util->getClientsProjects($__global_clients_filter);
            $campaign_ids = $this->util->getClientsCampaigns($__global_clients_filter);
        } else {
            $project_ids = $this->util->getUserProjects(auth()->user());
            $campaign_ids = $this->util->getCampaigns(auth()->user(), $project_ids);
        }

        $project = Project::findOrFail($newProjectId);
        $projects = Project::whereIn('id', $project_ids)->get();
        $campaigns = Campaign::whereIn('id', $campaign_ids)->get();
        $sources = Source::whereIn('project_id', $project_ids)->whereIn('campaign_id', $campaign_ids)->get();
        $leads = Lead::where('project_id', $project->id)->get();
        $fields=Lead::all();
        if (in_array($lead_view, ['list'])) {
            return view('admin.leads.leads', compact('projects', 'campaigns', 'sources', 'lead_view', 'leads', 'project','fields'));
        } elseif ($lead_view === 'kanban') {
            $stage_wise_leads = Lead::where('project_id', $project->id)
                ->whereNotNull('sell_do_fields')
                ->get()
                ->groupBy(function ($lead) {
                    return isset(json_decode($lead->sell_do_fields, true)['Sell Do Stage'])
                    ? json_decode($lead->sell_do_fields, true)['Sell Do Stage']
                    : 'no_stage';
                });

            $lead_stages = Lead::getStages($project->id);
            $filters = $request->except(['view']);

            return view('admin.leads.kanban_index', compact('projects', 'campaigns', 'sources', 'lead_view', 'stage_wise_leads', 'lead_stages', 'filters', 'project'));
        }
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $input = $request->except(['_method', '_token']);
        $input['lead_details'] = $this->getLeadDetailsKeyValuePair($input['lead_details'] ?? []);

        $lead->update($input);
        $this->util->storeUniqueWebhookFields($lead);

        return redirect()->route('admin.leads.index');
    }

    public function show(Lead $lead)
    {
        if (
            !auth()->user()->checkPermission('lead_view') ||
            (
                in_array(auth()->user()->user_type, ['lead_view_own_only', 'CRMHead']) &&
                auth()->user()->checkPermission('lead_view_own_only') &&
                ($lead->created_by != auth()->user()->id)
            )
        ) {
            abort(403, 'Unauthorized.');
        }

        $lead->load('project', 'campaign', 'source', 'createdBy');

        $lead_events = LeadEvents::where('lead_id', $lead->id)
            ->select('event_type', 'webhook_data', 'created_at as added_at', 'source')
            ->orderBy('added_at', 'desc')
            ->get();

        $project_ids = $this->util->getUserProjects(auth()->user());
        $projects_list = Project::whereIn('id', $project_ids)->pluck('name', 'id')
            ->toArray();

        return view('admin.leads.show', compact('lead', 'lead_events', 'projects_list'));
    }

    public function destroy(Lead $lead)
    {
        if (!auth()->user()->checkPermission('lead_delete')) {
            abort(403, 'Unauthorized.');
        }

        $lead->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeadRequest $request)
    {
        if (!auth()->user()->checkPermission('lead_delete')) {
            abort(403, 'Unauthorized.');
        }

        $leads = Lead::find(request('ids'));

        foreach ($leads as $lead) {
            $lead->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getLeadDetailHtml(Request $request)
    {
        if ($request->ajax()) {
            $index = $request->get('index') + 1;
            if (empty($request->get('project_id'))) {
                return view('admin.leads.partials.lead_detail')
                    ->with(compact('index'));
            } else {
                $project = Project::findOrFail($request->get('project_id'));
                $webhook_fields = $project->webhook_fields ?? [];
                return view('admin.leads.partials.lead_detail')
                    ->with(compact('index', 'webhook_fields'));
            }
        }
    }

    public function getLeadDetailsKeyValuePair($lead_details_arr)
    {
        if (!empty($lead_details_arr)) {
            $lead_details = [];
            foreach ($lead_details_arr as $lead_detail) {
                if (isset($lead_detail['key']) && !empty($lead_detail['key'])) {
                    $lead_details[$lead_detail['key']] = $lead_detail['value'] ?? '';
                }
            }
            return $lead_details;
        }
        return [];
    }

    public function getLeadDetailsRows(Request $request)
    {
        if ($request->ajax()) {

            $lead_details = [];
            $project_id = $request->input('project_id');
            $lead_id = $request->input('lead_id');
            $project = Project::findOrFail($project_id);
            $webhook_fields = $project->webhook_fields ?? [];

            if (!empty($lead_id)) {
                $lead = Lead::findOrFail($lead_id);
                $lead_details = $lead->lead_info;
            }

            $html = View::make('admin.leads.partials.lead_details_rows')
                ->with(compact('webhook_fields', 'lead_details'))
                ->render();

            return [
                'html' => $html,
                'count' => !empty($webhook_fields) ? count($webhook_fields) - 1 : 0,
            ];
        }
    }

    public function sendMassWebhook(Request $request)
    {
        if ($request->ajax()) {
            $lead_ids = $request->input('lead_ids');
            if (!empty($lead_ids)) {
                $response = [];
                foreach ($lead_ids as $id) {
                    $response = $this->util->sendApiWebhook($id);
                }
                return $response;
            }
        }
    }

    public function export(Request $request)
    {
        if (!auth()->user()->is_superadmin) {
            abort(403, 'Unauthorized.');
        }

        return Excel::download(new LeadsExport($request), 'leads.xlsx');
    }

    public function shareDocument(Request $request, $lead_id, $doc_id)
    {
        $lead = Lead::findOrFail($lead_id);
        $document = Document::findOrFail($doc_id);
        $note = $request->input('note');
        try {
            $mails = [];
            if (!empty($lead->email)) {
                $mails[$lead->email] = $lead->name ?? $lead->ref_num;
            }

            if (!empty($lead->additional_email)) {
                $mails[$lead->additional_email] = $lead->name ?? $lead->ref_num;
            }

            if (!empty($mails)) {
                Notification::route('mail', $mails)->notify(new LeadDocumentShare($lead, $document, auth()->user(), $note));
                $this->util->logActivity($lead, 'document_sent', ['sent_by' => auth()->user()->id, 'document_id' => $doc_id, 'status' => 'sent', 'datetime' => Carbon::now()->toDateTimeString(), 'note' => $note]);
            }
            $output = ['success' => true, 'msg' => __('messages.success')];
        } catch (Exception $e) {
            $this->util->logActivity($lead, 'document_sent', ['sent_by' => auth()->user()->id, 'document_id' => $doc_id, 'status' => 'failed', 'datetime' => Carbon::now()->toDateTimeString(), 'note' => $note]);
            $output = ['success' => false, 'msg' => __('messages.something_went_wrong')];
        }
        return $output;
    }
    public function selldoform(Request $request)
    {
        $campaigns = ProjectCampaign::all(['id', 'campaign_name']);
        $sources = collect(); // Empty collection for sources
        $project_ids = $this->util->getUserProjects(auth('selldo')->user());

        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $project_id = request()->get('project_id', null);      
          return view('selldo.layouts.form', compact('campaigns', 'sources','projects','project_id'));
    }

//     public function handleCampaignSelection(Request $request)
//     {
//         $campaigns = ProjectCampaign::all(['id', 'campaign_name']);
//         $sources = ProjectSource::where('campaign_id', $request->campaign_id)->get(['id', 'name']);
// $subsource=ProjectSubSource::where('source_id',$request->source_id)->get(['id','name']);
//         return view('selldo.layouts.form', compact('campaigns', 'sources', 'request'));
//     }
    
//     public function getSubSources($source_id)
// {
//     $subSources = SubSource::where('source_id', $source_id)->get();
//     return response()->json($subSources);
// }
}
