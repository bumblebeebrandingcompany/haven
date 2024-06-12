@extends('layouts.admin')
@section('content')
    <div class="row mb-2">
        <div class="col-sm-12">
            <h2>Booking List</h2>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <a class="btn btn-success float-right" href="{{ route('admin.booking.create') }}">
                {{ trans('global.add') }}
            </a>
        </div>
        <div class="card-body">
            <div class="card-body table-responsive p-0" style="height: 300px;">
                <table
                    class="table table-bordered table-striped table-hover table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Remarks</th>
                            <th>Per sqft Based Price</th>
                            <th>Plot No</th>
                            <th>Advance amount</th>
                            <th>Pending amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking as $bookings)
                            <tr>
                                <td></td>
                                <td>{{ $bookings->name }}</td>
                                <td>{{ $bookings->phone }}</td>
                                <td>{{ $bookings->email }}</td>
                                <td>{{ $bookings->user_type }}</td>
                                <td>{{ $bookings->remarks }}</td>
                                <td>{{ $bookings->per_sqft_based_price }}</td>
                                <td>{{ $bookings->plot->plot_no ?? '' }}</td>
                                <td>
                                    <?php
                                    // Convert the string representation of an array to an actual array
                                    $advance_amounts = json_decode($bookings->advance_amount, true);
                                    
                                    // Check if $advance_amounts is an array
                                    if (is_array($advance_amounts)) {
                                        // Calculate the sum of the array values
                                        $total_advance_amount = array_sum($advance_amounts);
                                        echo $total_advance_amount;
                                    } else {
                                        echo 'Invalid data'; // Error message if $bookings->advance_amount is not a valid array
                                    }
                                    ?>
                                </td>
                                <td>{{ $bookings->pending_amount }}</td>
                                <td>
                                    <a href="{{ route('admin.booking.bookedit', $bookings->id) }}"
                                        class="btn btn-info btn-sm">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
