<?php

namespace App\Http\Controllers\Selldo;

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
    
    public function store(StoreLeadRequest $request)
    {
        $input = $request->except(['_method', '_token', 'redirect_to']);
        $selldo = Lead::where('sell_do_lead_id', $request->sell_do_lead_id)->first();

        if ($selldo) {
            return redirect()->route('selldo.form')->with('success', 'Lead created successfully.');
        }
        $input['lead_details'] = $this->getLeadDetailsKeyValuePair($input['lead_details'] ?? []);
        $input['created_by'] = auth('selldo')->user()->id;
    
        $project_ids = $this->util->getUserProjects(auth()->user());
        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
    
        if (auth('web')->check() && auth()->user()->is_channel_partner && !empty($subsource)) {
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
    
            $lead = Lead::create($input);
            $lead->ref_num = $this->util->generateLeadRefNum($lead);
            $lead->save();
            // dd($lead->project->outgoing_apis);
            if (!empty($lead->project->outgoing_apis)) {
                $sell_do_response = json_decode($lead->sell_do_response, true);
                $this->util->sendApiWebhook($lead->id);
            }
    
            return redirect()->route('selldo.form')->with('success', 'Lead created successfully.');
        }

        return redirect()->route('selldo.form')->with('error', 'Subsource not found or missing related data.');
    }
}
