@extends('layouts.admin')
@section('content')
    <div class="row mb-2">
        <div class="col-sm-12">
            <h2>
                {{ trans('cruds.project.title') }} <span class="text-primary">{{ $project->name }}</span>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <a class="btn btn-default float-right" href="{{ route('admin.projects.index') }}">
                        <i class="fas fa-chevron-left"></i>
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $project->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.start_date') }}
                                    </th>
                                    <td>
                                        {{ $project->start_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.end_date') }}
                                    </th>
                                    <td>
                                        {{ $project->end_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.created_by') }}
                                    </th>
                                    <td>
                                        {{ $project->created_by->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.client') }}
                                    </th>
                                    <td>
                                        {{ $project->client->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.location') }}
                                    </th>
                                    <td>
                                        {{ $project->location }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.project.fields.description') }}
                                    </th>
                                    <td>
                                        {!! $project->description !!}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ trans('global.relatedData') }}
                    </h3>
                </div>
                <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
                    <li class="nav-item">
                        <a class="nav-link active show" href="#project_leads" role="tab" data-toggle="tab">
                            {{ trans('cruds.lead.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#project_campaigns" role="tab" data-toggle="tab">
                            {{ trans('cruds.campaign.title') }}
                        </a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#project_source" role="tab" data-toggle="tab">
                            Source </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#project_sub_source" role="tab" data-toggle="tab">
                            SubSource </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#project_plcs" role="tab" data-toggle="tab">
                            Plc
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#project_prices" role="tab" data-toggle="tab">
                            Prices
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#project_plots" role="tab" data-toggle="tab">
                            Plots
                        </a>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" role="tabpanel" id="project_leads">
                        @includeIf('admin.projects.relationships.projectLeads', [
                            'leads' => $project->projectLeads,
                        ])
                    </div>
                    <div class="tab-pane" role="tabpanel" id="project_campaigns">
                        @includeIf('admin.projects.relationships.projectCampaigns', [
                            'campaigns' => $project->projectCampaigns,
                        ])
                    </div>
                    <div class="tab-pane" role="tabpanel" id="project_plcs">
                        @includeIf('admin.plcs.index', ['plcs' => $project->plcs])
                    </div>
                    <div class="tab-pane" role="tabpanel" id="project_prices">
                        @includeIf('admin.price.index', ['price' => $project->price])
                    </div>
                    <div class="tab-pane" role="tabpanel" id="project_plots">
                        @includeIf('admin.plotdetails.index', [
                            'plotdetail' => $project->plots,
                            'plcs' => $project->plcs,
                        ])
                    </div>  
                    <div class="tab-pane" role="tabpanel" id="project_source">
                        @includeIf('admin.projects.relationships.projectSource', [
                            'source' => $project->projectSource,
                        ])
                    </div>
                    <div class="tab-pane" role="tabpanel" id="project_sub_source">
                        @includeIf('admin.projects.relationships.projectSubSource', [
                            'subsource' => $project->projectSubSource,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
