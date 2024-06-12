@extends('layouts.admin')
@section('content')
    <div class="row mb-2">
        <div class="col-sm-12">
            <h2>Sell Do User</h2>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <a class="btn btn-success float-right" href="{{ route('admin.selldoUser.create') }}">
                {{ trans('global.add') }}
            </a>
        </div>
        <div class="card-body">
            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>Ref_num</th>
                            <th>Name</th>
                            <th>Representative Name</th>
                            <th>Email </th>
                            <th>User type</th>
                            <th>Phone</th>
                            <th>Additional Phone</th>
                            <th>Sell Do User Id </th>
                            <th>Sell Do Team Id</th>
                            <th>Sell Do Department</th>
                            <th>Created At </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selldouser as $selldousers)
                            <tr>
                                <td></td>
                                <td>{{ $selldousers->ref_num }}</td>
                                <td>{{ $selldousers->name }}</td>
                                <td>{{ $selldousers->representative_name }}</td>
                                <td>{{ $selldousers->email }}</td>
                                <td>{{ $selldousers->user_type }}</td>
                                <td>{{ $selldousers->contact_number_1 }}</td>
                                <td>{{ $selldousers->contact_number_2 }}</td>
                                <td>{{ $selldousers->sell_do_user_id }}</td>
                                <td>{{ $selldousers->sell_do_team_id }}</td>
                                <td>{{ $selldousers->sell_do_department }}</td>
                                <td>{{ $selldousers->created_at }}</td>
                                <td>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <a href="{{ route('admin.selldoUser.edit', $selldousers->id) }}"
                                                class="btn btn-info btn-sm">
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <a href="{{ route('admin.selldoUser.edit', $selldousers->id) }}"
                                                class="btn btn-info btn-sm">
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
