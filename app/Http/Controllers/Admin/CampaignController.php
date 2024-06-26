<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCampaignRequest;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Agency;
use App\Models\Campaign;
use App\Models\Project;
use Gate;
use App\Models\Lead;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Utils\Util;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
class CampaignController extends Controller
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
        if(!auth()->user()->checkPermission('campaign_view')){
            abort(403, 'Unauthorized.');
        }

        $__global_clients_filter = $this->util->getGlobalClientsFilter();
        $project_ids = $this->util->getUserProjects(auth()->user());
        if(!empty($__global_clients_filter)) {
            $campaign_ids = $this->util->getClientsCampaigns($__global_clients_filter);
        } else {
            $campaign_ids = $this->util->getCampaigns(auth()->user(), $project_ids);
        }

        if ($request->ajax()) {

            $user = auth()->user();

            $query = Campaign::whereIn('campaigns.id', $campaign_ids)
                        ->with(['project', 'agency'])->select(sprintf('%s.*', (new Campaign)->table));
                        
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use($user) {
                $viewGate      = $user->checkPermission('campaign_view');
                $editGate      = $user->checkPermission('campaign_edit');
                $deleteGate    = $user->checkPermission('campaign_delete');
                $crudRoutePart = 'campaigns';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });
            $table->editColumn('campaign_name', function ($row) {
                return $row->campaign_name ? $row->campaign_name : '';
            });
            $table->addColumn('project_name', function ($row) {
                return $row->project ? $row->project->name : '';
            });

            $table->addColumn('agency_name', function ($row) {
                return $row->agency ? $row->agency->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'project', 'agency']);

            return $table->make(true);
        }

        $projects = Project::whereIn('id', $project_ids)
                        ->get();
        $agencies = Agency::get();

        return view('admin.campaigns.index', compact('projects', 'agencies'));
    }

    public function create()
    {
        if(!auth()->user()->checkPermission('campaign_create')){
            abort(403, 'Unauthorized.');
        }

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $agencies = Agency::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project_id = request()->get('project_id', null);

        return view('admin.campaigns.create', compact('agencies', 'projects', 'project_id'));
    }

    public function store(StoreCampaignRequest $request)
    {
        if(!auth()->user()->checkPermission('campaign_create')){
            abort(403, 'Unauthorized.');
        }

        $campaign_details = $request->except('_token');
        $campaign = Campaign::create($campaign_details);

        return redirect()->route('admin.campaigns.index');
    }

    public function edit(Campaign $campaign)
    {
        if(!auth()->user()->checkPermission('campaign_edit')){
            abort(403, 'Unauthorized.');
        }

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $agencies = Agency::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $campaign->load('project', 'agency');

        return view('admin.campaigns.edit', compact('agencies', 'campaign', 'projects'));
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign)
    {
        if(!auth()->user()->checkPermission('campaign_edit')){
            abort(403, 'Unauthorized.');
        }

        $campaign->update($request->all());

        return redirect()->route('admin.campaigns.index');
    }

    public function show(Campaign $campaign)
    {
        if(!auth()->user()->checkPermission('campaign_view')){
            abort(403, 'Unauthorized.');
        }

        $campaign->load('project', 'agency', 'campaignLeads', 'campaignSources');

        return view('admin.campaigns.show', compact('campaign'));
    }

    public function destroy($id)
    {
        $source = Campaign::findOrFail($id);
        $source->delete();
        return redirect()->back()->with('success', 'campaign deleted successfully');
    }

    public function massDestroy(MassDestroyCampaignRequest $request)
    {
        $campaigns = Campaign::find(request('ids'));

        foreach ($campaigns as $campaign) {
            $campaign->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getCampaigns(Request $request)
    {
        if($request->ajax()) {

            $project_ids = $this->util->getUserProjects(auth()->user());
            $campaign_ids = $this->util->getCampaigns(auth()->user(), $project_ids);

            $campaigns = Campaign::whereIn('id', $campaign_ids)
                            ->where('project_id', $request->input('project_id'))
                            ->pluck('campaign_name', 'id')
                            ->toArray();

            $campaigns_arr = [['id' => '', 'text' => __('messages.please_select')]];
            if(!empty($campaigns)) {
                foreach ($campaigns as $id => $text) {
                    $campaigns_arr[] = [
                        'id' => $id,
                        'text' =>$text
                    ];
                }
            }
            return $campaigns_arr;
        }
    }
}
