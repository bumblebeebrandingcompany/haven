<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Agency;
use App\Models\Campaign;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Project;
use App\Models\ProjectCampaign;
use App\Models\ProjectSource;
use App\Models\ProjectSubSource;
use App\Models\SellDo;
use App\Models\Source;
use App\Models\SubSource;
use App\Models\User;
use App\Utils\Util;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Google\Client as googleClient;
use Google\Service\Sheets;

class ProjectController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

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

    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user->checkPermission('project_view')) {
            abort(403, 'Unauthorized.');
        }

        if ($request->ajax()) {

            $__global_clients_filter = $this->util->getGlobalClientsFilter();

            $query = Project::with(['created_by', 'client'])->select(sprintf('%s.*', (new Project)->table));

            if ($user->is_channel_partner || $user->is_client || $user->is_agency) {
                $project_ids = $this->util->getUserProjects(auth()->user());
                $query = $query->where(function ($q) use ($user, $project_ids) {
                    $q->whereIn('projects.id', $project_ids)
                        ->orWhere('projects.created_by_id', $user->id)
                        ->orWhere('projects.client_id', $user->client_id);
                });
            }

            if (!empty($__global_clients_filter)) {
                $query->whereIn('projects.client_id', $__global_clients_filter);
            }

            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($user) {
                $viewGate = $user->checkPermission('project_show');
                $editGate = $user->checkPermission('project_edit');
                $deleteGate = $user->checkPermission('project_delete');
                $sourceGate = $user->checkPermission('project_source');

                $outgoingWebhookGate = $user->is_superadmin;
                $outgoingAutomationWebhookGate = $user->is_superadmin;
                $sourceGate = $user->is_superadmin;
                $crudRoutePart = 'projects';

                return view(
                    'partials.datatablesActions',
                    compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'outgoingWebhookGate',
                        'outgoingAutomationWebhookGate',
                        'crudRoutePart',
                        'row',
                        'sourceGate'
                    )
                );
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->addColumn('created_by_name', function ($row) {
                return $row->created_by ? $row->created_by->name : '';
            });

            $table->addColumn('client_name', function ($row) {
                return $row->client ? $row->client->name : '';
            });

            $table->editColumn('client.email', function ($row) {
                return $row->client ? (is_string($row->client) ? $row->client : $row->client->email) : '';
            });
            $table->editColumn('location', function ($row) {
                return $row->location ? $row->location : '';
            });
            $table->editColumn('overall_sqfts', function ($row) {
                return $row->overall_sqfts ? $row->overall_sqfts : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'created_by', 'client']);

            return $table->make(true);
        }

        $users = User::get();
        $clients = Client::get();

        return view('admin.projects.index', compact('users', 'clients'));
    }

    public function create()
    {
        if (!auth()->user()->checkPermission('project_create')) {
            abort(403, 'Unauthorized.');
        }
        $projectsubsource = new ProjectSubSource();
        // Define a default project
        $projects = new Project();
        // $project_subsource_id = new ProjectSubSource();
        $sources = ProjectSource::all();
        $campaigns = ProjectCampaign::all();
        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $subSources = ProjectSubSource::all();
        $clients = Client::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $projectsubsource = SubSource::all();
        return view('admin.projects.create', compact('clients', 'created_bies', 'sources', 'campaigns', 'subSources', 'projects','projectsubsource'));
    }

    public function store(StoreProjectRequest $request)
    {
        if (!auth()->user()->checkPermission('project_create')) {
            abort(403, 'Unauthorized.');
        }

        $project_details = $request->except('_token');
        $essentialFields = $request->input('essential_fields', []);
        $project_details['essential_fields'] = array_merge($essentialFields);

        $customFields = $request->input('custom_fields', []);
        $project_details['custom_fields'] = array_merge($customFields);

        $salesFields = $request->input('sales_fields', []);
        $project_details['sales_fields'] = array_merge($salesFields);

        $systemFields = $request->input('system_fields', []);
        $project_details['system_fields'] = array_merge($systemFields);

        $inboxFields = $request->input('inbox_fields', []);
        $project_details['inbox_fields'] = array_merge($inboxFields);

        $project_details['created_by_id'] = auth()->user()->id;
        // $projectsubsource = Project::create($project_details);

        $project = Project::create($project_details);
        $selectedCampaigns = $request->input('campaign_id', []);
        $selectedSources = $request->input('source_id', []);
        $selectedSubsourceIds = $request->input('Subsource');

        foreach ($selectedSubsourceIds as $subsourceId) {
            $subsource = ProjectSubSource::find($subsourceId);
            if ($subsource) {
                // Access associated source and campaign records
                $source = $subsource->source;
                $campaign = $source->campaign;
                $newCampaign = Campaign::create([
                    'campaign_name' => $campaign->campaign_name,
                    'project_id' => $project->id,
                    'agency_id' => $campaign->agency_id,
                ]);

                // Create a new source record associated with the new campaign
                $newSource = Source::create([
                    'name' => $source->name,
                    'project_id' => $project->id,
                    'campaign_id' => $newCampaign->id,
                    
                    'is_cp_source' => 1,
                    'essential_fields' => [],
                    'custom_fields' => [],
                    'system_fields' => [],
                    'sell_do_fields' => [],
                    'sales_fields' => [],
                    'inbox_fields' => [],
                ]);

                // Create a new sub-source record associated with the new source
                Subsource::create([
                    'name' => $subsource->name,
                    'source_id' => $newSource->id,
                    'srd' => $subsource->srd,
                    'webhook_secret' => $this->util->generateWebhookSecret(),
                    'virtual_number' => $subsource->virtual_number,
                    'project_id'=>$project->id,
                ]);
            }
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $project->id]);
        }

        return redirect()->route('admin.projects.index');
    }

    public function edit(Project $project, Request $request)
    {
        if (!auth()->user()->checkPermission('project_edit')) {
            abort(403, 'Unauthorized.');
        }
        $projects = Project::all();
        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $clients = Client::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $project->load('created_by', 'client');
        $campaigns = ProjectCampaign::all();
        $sources = ProjectSource::all();
        $selectedSubSources = $project->subSources->pluck('id')->toArray();
         $subSources =SubSource::all();
         $projectsubsource=SubSource::all();
        // dd($selectedSubSources);
        return view('admin.projects.edit', compact('clients', 'created_bies', 'project', 'projects', 'campaigns', 'sources', 'subSources', 'selectedSubSources','projectsubsource'));
    }
        public function update(UpdateProjectRequest $request, Project $project)
    {
        if (!auth()->user()->checkPermission('project_edit')) {
            abort(403, 'Unauthorized.');
        }
    
        $project_details = $request->except(['_method', '_token', 'sub_sources']);
        $project->update($project_details);
    
        $subSources = $request->input('sub_sources', []);
    
        // Iterate through the submitted sub-sources
        foreach ($subSources as $subsourceId) {
            // Find the existing sub-source or create a new one
            $subsource = ProjectSubSource::find($subsourceId);
            if ($subsource) {
                if ($subsource->project_id == $project->id) {
                    // If it does, update its details if necessary
                    $subsource->update([
                        'name' => $request->input('subsource_name_'.$subsourceId),
                        // Update other fields as needed
                    ]);
                } else {
                    $newSubsource = ProjectSubSource::create([
                        'name' => $request->input('subsource_name_'.$subsourceId),
                        'project_id' => $project->id,
                    ]);
                }
            }
        }
        return redirect()->route('admin.projects.index');
    }
    public function show(Project $project, Request $request)
    {
        if (!auth()->user()->checkPermission('project_view')) {
            abort(403, 'Unauthorized.');
        }
    
        $projectId = $request->input('projectId', $project->id);
    
        $projects = Project::all();
        $campaigns = Campaign::all();
        $sources = Source::where('project_id', $projectId)->get();
        $agencies = Agency::all();
        
        $subSources = SubSource::all(); // Renamed variable to $subSources
        $project->load('created_by', 'client', 'projectLeads', 'projectCampaigns', 'plcs', 'price', 'projectSource', 'projectSubSource');
        return view('admin.projects.show', compact('project', 'projects', 'campaigns', 'sources', 'agencies', 'subSources'));
    }
    

    public function destroy(Project $project)
    {
        if (!auth()->user()->checkPermission('project_delete')) {
            abort(403, 'Unauthorized.');
        }

        $project->delete();

        return back();
    }

    public function massDestroy(MassDestroyProjectRequest $request)
    {
        if (!auth()->user()->checkPermission('project_delete')) {
            abort(403, 'Unauthorized.');
        }

        $projects = Project::find(request('ids'));

        foreach ($projects as $project) {
            $project->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        if (!(auth()->user()->checkPermission('project_create') || auth()->user()->checkPermission('project_edit'))) {
            abort(403, 'Unauthorized.');
        }

        $model = new Project();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function getWebhookDetails($id, Request $request)
    {
        if (!auth()->user()->is_superadmin) {
            abort(403, 'Unauthorized.');
        }

        // $subsource = SubSource::with(['project'])
        //     ->findOrFail($id);

        $lead = Lead::where('subsource_id', $id)
            ->latest()
            ->first();

        $webhook_key = $request->get('webhook_key');
        $rb_key = $request->get('rb_key');
        $project = Project::findOrFail($id);
        // Set default values if $lead is null
        $lead_info = $lead ? $lead->lead_details : [];
        $existing_keys_and_values = $lead ? $this->util->getNestedKeysAndValues($lead_info) : [];
        $selldo=SellDo::all();
        return view('admin.projects.webhook', compact('lead', 'webhook_key', 'rb_key', 'existing_keys_and_values','project','selldo'));
    }
    public function saveOutgoingWebhookInfo(Request $request)
    {
        $id = $request->input('project_id');
        $api = $request->input('api');

        $project = Project::findOrFail($id);
        $project->outgoing_apis = $api;
        $project->save();

        $this->util->storeUniqueWebhookFieldsWhenCreatingWebhook($project);

        return redirect()->route('admin.projects.webhook', $project->id);
    }

    public function getWebhookHtml(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $key = $request->get('key');
            $project_id = $request->input('project_id');
            if ($type == 'api') {
                $tags = $this->util->getWebhookFieldsTags($project_id);
                return view('admin.projects.partials.api_card')
                    ->with(compact('key', 'tags'));
            } else {
                return view('admin.projects.partials.webhook_card')
                    ->with(compact('key'));
            }
        }
    }

    public function getRequestBodyRow(Request $request)
    {
        if ($request->ajax()) {
            $project_id = $request->input('project_id');
            $webhook_key = $request->get('webhook_key');
            $rb_key = $request->get('rb_key');
            $tags = $this->util->getWebhookFieldsTags($project_id);
           
            return view('admin.projects.partials.request_body_input')
                ->with(compact('webhook_key', 'rb_key', 'tags'));
        }
    }

    public function postTestWebhook(Request $request)
    {
        try {
            $api = $request->input('api');
            $response = null;
            foreach ($api as $api_detail) {
                if (
                    !empty($api_detail['url'])
                ) {
                    $body = $this->getDummyDataForApi($api_detail);
                    $constants = $this->util->getApiConstants($api_detail);
                    $body = array_merge($body, $constants);
                    $headers['secret-key'] = $api_detail['secret_key'] ?? '';

                    //merge query parameter into request body
                    $queryString = parse_url($api_detail['url'], PHP_URL_QUERY);
                    parse_str($queryString, $queryArray);
                    $body = array_merge($body, $queryArray);

                    $response = $this->util->postWebhook($api_detail['url'], $api_detail['method'], $headers, $body);
                } else {
                    return ['success' => false, 'msg' => __('messages.url_is_required')];
                }
            }
            $output = ['success' => true, 'msg' => __('messages.success'), 'response' => $response];
        } catch (RequestException $e) {
            $msg = $e->getMessage() ?? __('messages.something_went_wrong');
            $output = ['success' => false, 'msg' => $msg];
        }
        return $output;
    }

    public function getDummyDataForApi($api)
    {
        $request_body = $api['request_body'] ?? [];
        if (empty($request_body)) {
            return [];
        }

        $dummy_data = [];
        foreach ($request_body as $value) {
            if (!empty($value['key'])) {
                $dummy_data[$value['key']] = 'test data';
            }
        }

        return $dummy_data;
    }
    public function getApiConstantRow(Request $request)
    {
        if ($request->ajax()) {
            $webhook_key = $request->get('webhook_key');
            $constant_key = $request->get('constant_key');
            return view('admin.projects.partials.constants')
                ->with(compact('webhook_key', 'constant_key'));
        }
    }

    public function getCampaignsDropdown(Request $request)
    {
        if ($request->ajax()) {
            $campaigns = Campaign::where('project_id', $request->input('project_id'))
                ->pluck('campaign_name', 'id')
                ->toArray();

            return view('admin.projects.partials.campaigns_dropdown')
                ->with(compact('campaigns'));
        }
    }

    public function getSourceDropdown(Request $request)
    {
        if ($request->ajax()) {
            $sources = Source::where('project_id', $request->input('project_id'))
                ->where('campaign_id', $request->input('campaign_id'))
                ->pluck('name', 'id')
                ->toArray();

            return view('admin.projects.partials.sources_dropdown')
                ->with(compact('sources'));
        }
    }

    public function getAdditionalFieldsDropdown(Request $request)
    {
        if ($request->ajax()) {
            $project = Project::where('id', $request->input('project_id'))
                ->firstOrFail();

            return view('admin.projects.partials.additional_fields_dropdown')
                ->with(compact('project'));
        }
    }
    public function source(Request $request, $id)
    {
        // Find the project with the given ID
        $project = Project::findOrFail($id);

        // Get the projectId from the request
        $projectId = $request->input('projectId');

        // If projectId is not set, use the ID of the current project
        if (!$projectId) {
            $projectId = $id;
        }
        $campaigns = Campaign::all();
        $sources = Source::where('project_id', $projectId)->get();

        // Pass the project and sources data to the view
        return view('admin.sources.index', compact('projects', 'sources', 'campaigns', 'project'));
    }
}
