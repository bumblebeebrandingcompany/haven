<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPromoRequest;
use App\Http\Requests\StoreSubSourceRequest;
use App\Http\Requests\UpdateSubSourceRequest;
use App\Models\Campaign;
use App\Models\Lead;
use App\Models\Project;
use App\Models\ProjectSubSource;
use App\Models\Source;
use App\Models\SubSource;
use App\Utils\Util;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubSourceController extends Controller
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

    public function index(Request $request)
    {
        if (!auth()->user()->is_superadmin && !auth()->user()->is_client) {
            abort(403, 'Unauthorized.');
        }

        if ($request->ajax()) {
            $query = SubSource::with(['project', 'campaign', 'source'])->select(sprintf('%s.*', (new SubSource)->table));
            $__global_clients_filter = $this->util->getGlobalClientsFilter();
            if (!empty($__global_clients_filter)) {
                $project_ids = $this->util->getClientsProjects($__global_clients_filter);
                $campaign_ids = $this->util->getClientsCampaigns($__global_clients_filter);
                $source_ids = $this->util->getClientsSources($__global_clients_filter);

                $query->where(function ($q) use ($project_ids, $campaign_ids, $source_ids) {
                    $q->whereIn('subsource.project_id', $project_ids)
                        ->orWhereIn('subsource.campaign_id', $campaign_ids)
                        ->orWhereIn('subsource.source_id', $source_ids)
                    ;
                })->groupBy('subsource.id');
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'promo_show';
                $user = auth()->user();
                $editGate = 'promo_edit' && $user->is_superadmin;
                $deleteGate = 'promo_delete' && $user->is_superadmin;
                $crudRoutePart = 'subsource';
                return view(
                    'admin.subsource.datatableActions',
                    compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',

                        'crudRoutePart',
                        'row'
                    )
                );
            });
            $table->addColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('project_name', function ($row) {
                return $row->project ? $row->project->name : '';
            });

            $table->addColumn('campaign_name', function ($row) {
                return $row->campaign ? $row->campaign->name : '';
            });

            $table->addColumn('source_name', function ($row) {
                return $row->source ? $row->source->name : '';
            });

            // $table->editColumn('name', function ($row) {
            //     $html =  $row->name ? $row->name : '';
            //     if($row->is_cp_source) {
            //         $html .= "<br>".'<span class="badge badge-pill badge-info">'.__('messages.cp_source').'</span>';
            //     }
            //     return $html;
            // });

            $table->rawColumns(['actions', 'placeholder', 'project', 'campaign', 'name']);
            $subsources = SubSource::all();
            return $table->make(true);
        }

        $project_ids = $this->util->getUserProjects(auth()->user());
        $campaign_ids = $this->util->getCampaigns(auth()->user(), $project_ids);
        $source_ids = $this->util->getSource(auth()->user(), $project_ids, $campaign_ids);

        $projects = Project::whereIn('id', $project_ids)
            ->get();

        $campaigns = Campaign::whereIn('id', $campaign_ids)
            ->get();
        $sources = Source::whereIn('id', $source_ids)
            ->get();

        return view('admin.subsource.index', compact('projects', 'campaigns', 'sources'));
    }

    public function create()
    {
        if (!auth()->user()->is_superadmin) {
            abort(403, 'Unauthorized.');
        }

        $project_ids = $this->util->getUserProjects(auth()->user());
        $campaign_ids = $this->util->getCampaigns(auth()->user(), $project_ids);

        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $project_id = request()->get('project_id', null);

        $campaigns = Campaign::whereIn('id', $campaign_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $sources = Source::all();
        return view('admin.subsource.create', compact('campaigns', 'projects', 'sources', 'project_id'));
    }

    public function store(StoreSubSourceRequest $request)
    {
        $subsource = SubSource::all();
        if (!auth()->user()->is_superadmin) {
            abort(403, 'Unauthorized.');
        }
        $input = $request->validated();

        $project_ids = $this->util->getUserProjects(auth()->user());
        $campaign_ids = $this->util->getCampaigns(auth()->user(), $project_ids);
        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $subsource_details = $request->except('_token');

        $subsource_details['webhook_secret'] = $this->util->generateWebhookSecret();

        $optVerifiedOrNot = $request->input('otp_verified_or_not');

        $campaigns = Campaign::whereIn('id', $campaign_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $promo_details = $request->except('_token');
        $subsource = ProjectSubSource::create($input);
        $subsource = SubSource::create($subsource_details);

        return redirect()->route('admin.subsource.index', compact('campaigns', 'projects', 'subsource'));
    }
    public function edit(SubSource $subsource)
    {
        if (!auth()->user()->is_superadmin) {
            abort(403, 'Unauthorized.');
        }

        $project_ids = $this->util->getUserProjects(auth()->user());
        $campaign_ids = $this->util->getCampaigns(auth()->user(), $project_ids);

        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $project_id = request()->get('project_id', null);
        $campaigns = Campaign::whereIn('id', $campaign_ids)
            ->pluck('campaign_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $sources = Source::all();
        // $subsource->load('project', 'campaign', 'sources');
        return view('admin.subsource.edit', compact('campaigns', 'projects', 'sources', 'subsource', 'project_id'));
    }

    public function update(UpdateSubSourceRequest $request, SubSource $subsource)
    {
        if (!auth()->user()->is_superadmin) {
            abort(403, 'Unauthorized.');
        }

        $promo_details = $request->except(['_method', '_token']);
        $subsource->update($promo_details);

        return redirect()->route('admin.subsource.index');
    }

    public function show(SubSource $subsource)
    {
        if (!auth()->user()->is_superadmin && !auth()->user()->is_client) {
            abort(403, 'Unauthorized.');
        }
        $source = Source::all();
        $project = Project::all();
        $campaign = Campaign::all();
        $subsource->load('project', 'campaign', 'source');

        return view('admin.subsource.show', compact('source', 'project', 'source', 'subsource'));
    }

    public function destroy(SubSource $subsource)
    {
        abort_if(!auth()->user()->is_superadmin, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subsource->delete();

        return back();
    }

    public function massDestroy(MassDestroyPromoRequest $request)
    {
        if (!auth()->user()->is_superadmin) {
            abort(403, 'Unauthorized.');
        }
        $subsources = SubSource::find(request('ids'));
        foreach ($subsources as $subsource) {
            $subsource->delete();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function getWebhookDetails($id, Request $request)
    {
        if (!auth()->user()->is_superadmin) {
            abort(403, 'Unauthorized.');
        }

        $subsource = SubSource::with(['project'])
            ->findOrFail($id);

        $lead = Lead::where('subsource_id', $id)
            ->latest()
            ->first();

        // Determine if otp_verified_or_not should be checked
        $checked = $subsource->otp_verified_or_not == 1;

        $webhook_key = $request->get('webhook_key');
        $rb_key = $request->get('rb_key');

        $lead_info = $lead ? $lead->lead_details : [];
        $existing_keys_and_values = $lead ? $this->util->getNestedKeysAndValues($lead_info) : [];
        $existing_keys = $lead ? $this->util->getNestedKeysAndValues($lead_info) : [];

        return view('admin.subsource.webhook', compact('subsource', 'lead', 'webhook_key', 'rb_key', 'existing_keys_and_values', 'existing_keys', 'checked'));
    }

    public function getSubSources(Request $request)
    {
        if ($request->ajax()) {
            $projectId = $request->input('project_id');
            $sourceId = $request->input('source_id');
    
            // Log input data
            \Log::info("Fetching sub-sources for project_id: $projectId and source_id: $sourceId");
    
            // Fetch sub-sources based on project_id and source_id
            $subSources = SubSource::where('project_id', $projectId)
                ->where('source_id', $sourceId)
                ->pluck('name', 'id')
                ->toArray();
    
            $subSourcesArr = [['id' => '', 'text' => __('messages.please_select')]];
            if (!empty($subSources)) {
                foreach ($subSources as $id => $text) {
                    $subSourcesArr[] = [
                        'id' => $id,
                        'text' => $text
                    ];
                }
            }
    
            // Log fetched sub-sources
            \Log::info("Sub-sources found: ", $subSourcesArr);
    
            return response()->json($subSourcesArr);
        }
    }
    




    public function updatePhoneAndEmailKey(Request $request)
    {
        $subsource = SubSource::findOrFail($request->input('subsource_id'));

        // Handle essential fields
        $essentialFields = $request->input('essential_fields', []);
        $subsource['essential_fields'] = $essentialFields;

        // Handle inbox fields
        $inboxFields = $request->input('inbox_fields', []);
        $subsource['inbox_fields'] = $inboxFields;

        // Handle custom fields
        $customFields = $request->input('custom_fields', []);
        $subsource['custom_fields'] = $customFields;

        // Handle sales fields
        $salesFields = $request->input('sales_fields', []);
        $subsource['sales_fields'] = $salesFields;

        // Handle system fields
        $systemFields = $request->input('system_fields', []);
        $subsource['system_fields'] = $systemFields;

        // Handle sell do fields
        $sellDoFields = $request->input('sell_do_fields', []);
        $subsource['sell_do_fields'] = $sellDoFields;

        // Handle the otp_verified_or_not checkbox
        $subsource['otp_verified_or_not'] = $request->input('otp_verified_or_not', 0);

        // Save the updated subsource
        $subsource->save();

        return redirect()->route('admin.subsource.webhook', $subsource->id);
    }

}
