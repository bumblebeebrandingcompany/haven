{{-- @extends('layouts.admin')
@section('content')
<div class="row mb-2">
   <div class="col-sm-6">
        <h2>
         Booking
        </h2>
   </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form method="POST" action="{{ route("admin.bookings.update", ["booking" => $lead_event->lead_id]) }}" enctype="multipart/form-data" id="bookings">
            @csrf
            @method('PUT')
            @includeIf('admin.bookings.partials.form', ['lead' => $lead_event->lead, 'event' => $lead_event])
            <div class="row float-right">
                <div class="col-md-12">
             <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.update') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
       @includeIf('admin.bookings.partials.common_js')
    });
</script>
@endsection --}}
@extends('layouts.admin')
@section('content')
    {{-- <form id="BookingFormId" method="POST" enctype="multipart/form-data"
        action="{{ route('admin.booking.update', $booking->id) }}">
        @csrf --}}
    <div id="showfollowup" class="myDiv">
        <div class="modal-body">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <label for="name">Name</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', $booking->name) }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text"
                            name="phone" id="phone" value="{{ old('phone', $booking->phone) }}">
                        @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="secondary_phone">Secondary Phone</label>
                        <input class="form-control {{ $errors->has('secondary_phone') ? 'is-invalid' : '' }}" type="text"
                            name="secondary_phone" id="secondary_phone"
                            value="{{ old('secondary_phone', $booking->secondary_phone) }}">
                        @if ($errors->has('secondary_phone'))
                            <span class="text-danger">{{ $errors->first('secondary_phone') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text"
                            name="email" id="email" value="{{ old('email', $booking->email) }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>

                    </div>
                    <div class="form-group">
                        <label for="secondary_email">Secondary email</label>
                        <input class="form-control {{ $errors->has('secondary_email') ? 'is-invalid' : '' }}"
                            type="text" name="secondary_email" id="secondary_email"
                            value="{{ old('secondary_email', $booking->secondary_email) }}">
                        @if ($errors->has('secondary_email'))
                            <span class="text-danger">{{ $errors->first('secondary_email') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <select name="remarks" id="remarks" class="form-control">
                                <option value="">@lang('messages.please_select')</option>
                                <option value="Loan">Loan</option>
                                <option value="Own Funding">Own Funding</option>
                            </select>
                        </div>
                        <label for="user_type">User Type</label>
                        <select
                            class="form-control user_type_input select2 {{ $errors->has('user_type') ? 'is-invalid' : '' }}"
                            name="user_type" id="user_type" required>
                            @foreach (App\Models\User::USER_TYPE_RADIO as $key => $label)
                                @if (!auth()->user()->is_channel_partner_manager)
                                    <option value="{{ $key }}"
                                        {{ old('user_type', '') === (string) $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @elsex
                                    @if ($key == 'ChannelPartner')
                                        <option value="{{ $key }}" selected>
                                            {{ $label }}
                                        </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="base_price">Per Sqft Base Price</label>
                        <input class="form-control {{ $errors->has('base_price') ? 'is-invalid' : '' }}" type="text"
                            name="per_sqft_based_price" id="base_price" oninput="calculateTotal()"
                            value="{{ old('phone', $booking->per_sqft_based_price) }}">
                        @if ($errors->has('base_price'))
                            <span class="text-danger">{{ $errors->first('base_price') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="overall_sqft">Overall Sqft</label>
                        <input class="form-control {{ $errors->has('overall_sqft') ? 'is-invalid' : '' }}" type="text"
                            name="overall_sqft" id="overall_sqft" value=" {{ $booking->plot->total_sqfts }}"
                            oninput="calculateTotal()" readonly>
                        @if ($errors->has('overall_sqft'))
                            <span class="text-danger">{{ $errors->first('overall_sqft') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="total">Total Amount</label>
                        <input class="form-control" type="text" name="total" id="total" readonly>
                    </div>
                </div>
            </div>

            <button type="button" id="add-custom-field" class="btn btn-primary">Add</button>
            <div id="custom-fields-container">
                <div class="parent-container">
                    <div class="payment-container">
                        <div class="row">
                            <div class="col-md-4">
                                <div id="advance_amount_container">
                                    <label for="advance_amount">Advance Amount</label>
                                    <input class="form-control advance_amount_input" type="text"
                                        name="advance_amount[][advance_amount]" id="advance_amount"
                                        value=" {{ $booking->plot->total_sqfts }}" oninput="calculateTotal()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="payment_mode">Mode of Payment</label>
                                <select name="advance_amount[][payment_mode]" id="payment_mode" class="form-control">
                                    <option value="">@lang('messages.please_select')</option>
                                    <option value="1">Card</option>
                                    <option value="2">Cash</option>
                                    <option value="3">UPI</option>
                                    <option value="4">Cheque</option>
                                    <option value="5">Demand Draft(DD)</option>
                                    <option value="6">NEFT</option>
                                    <option value="7">RTGS</option>
                                    <option value="8">UPI</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div id="chequeDetails" style="display: none;">
                                    <div class="form-group">
                                        <label for="advance_amount">Cheque No</label>
                                        <input class="form-control {{ $errors->has('cheque_no') ? 'is-invalid' : '' }}"
                                            type="text" name="advance_amount[][cheque_no]" id="cheque_no"
                                            value="{{ old('cheque_no', '') }}">
                                        @if ($errors->has('cheque_no'))
                                            <span class="text-danger">{{ $errors->first('cheque_no') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="advance_amount"> Select Cheque Date </label>
                                        <input type="date"
                                            class="form-control datepicker {{ $errors->has('form-control datepicker') ? 'is-invalid' : '' }}"
                                            name="advance_amount[][cheque_date]" id="cheque_date"
                                            rows="3">{{ old('cheque_date') }}
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group">
                                        <label for="advance_amount">Account No</label>
                                        <input class="form-control {{ $errors->has('account_no') ? 'is-invalid' : '' }}"
                                            type="text" name="advance_amount[][account_no]" id="account_no"
                                            value="{{ old('account_no', '') }}">
                                        @if ($errors->has('account_no'))
                                            <span class="text-danger">{{ $errors->first('account_no') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                                    </div>
                                </div>
                                <div id="ddDetails" style="display: none;">
                                    <div class="form-group">
                                        <label for="advance_amount">DD name</label>
                                        <input class="form-control {{ $errors->has('dd_name') ? 'is-invalid' : '' }}"
                                            type="text" name="advance_amount[][dd_name]" id="dd_name">

                                        @if ($errors->has('dd_name'))
                                            <span class="text-danger">{{ $errors->first('dd_name') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="advance_amount">DD Bank</label>
                                        <input class="form-control {{ $errors->has('dd_bank') ? 'is-invalid' : '' }}"
                                            type="text" name="advance_amount[][advance_amount]" id="advance_amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="dd_no">DD No</label>
                                        <input class="form-control {{ $errors->has('dd_no') ? 'is-invalid' : '' }}"
                                            type="text" name="advance_amount[][dd_no]" id="dd_no">
                                    </div>
                                    <div class="form-group">
                                        <label for="account_no">Account No</label>
                                        <input class="form-control {{ $errors->has('account_no') ? 'is-invalid' : '' }}"
                                            type="text" name="advance_amount[][account_no]" id="account_no">
                                        @if ($errors->has('account_no'))
                                            <span class="text-danger">{{ $errors->first('account_no') }}</span>
                                        @endif
                                        <span
                                            class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="Credited/Not_Credited">Credited/Not Credited</label>
                                    <select name="advance_amount[][credit_not_credit]" id="credit_not_credit"
                                        class="form-control">
                                        <option value="">@lang('messages.please_select')</option>
                                        <option value="1">Credited</option>
                                        <option value="2">Not Credited</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <script>
                            // Get the select element
                            var selectElement = document.getElementById('credit_not_credit');

                            // Add event listener to listen for changes
                            selectElement.addEventListener('change', function() {
                                var selectedValue = this.value;
                                var statusIdInput = document.getElementById('status_id');

                                // Update the value of status_id based on the selected option
                                if (selectedValue === '1') {
                                    statusIdInput.value = '1'; // Set status_id to 1 if "Credited" is selected
                                } else if (selectedValue === '2') {
                                    statusIdInput.value = '2'; // Set status_id to 2 if "Not Credited" is selected
                                } else {
                                    statusIdInput.value = ''; // Set status_id to empty if no option is selected
                                }
                            });
                        </script>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="pending_amount">Pending Amount</label>
                        <input class="form-control" type="text" name="pending_amount" id="pending_amount" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <label for="status_id">Status</label>
                    <select name="status_id" id="status_id" class="form-control">
                        <option value="">@lang('messages.please_select')</option>
                        <option value="1">Booked</option>
                        <option value="2">Blocked</option>
                        <option value="3">Registered</option>
                        <option value="4">Available</option>

                    </select>
                </div>
            </div>
            {{-- <div class="form-group">
                <input type="hidden" name="plot_id" class="form-control" value="{{ $plotdetail->id }}">
            </div> --}}
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- </form> --}}
@endsection
@section('scripts')
    @parent
    <script>
        function calculateTotal() {
            var perSqft = parseFloat(document.getElementById('base_price').value);
            var overallSqft = parseFloat(document.getElementById('overall_sqft').value);
            // var discount = parseFloat(document.getElementById('discount').value);
            var total = perSqft * overallSqft;
            // var discountAmount = (total * discount) / 100;
            // var totalAfterDiscount = total - discountAmount;
            var totalAdvanceAmount = 0;
            // Sum up all advance amounts
            var advanceAmountInputs = document.getElementsByClassName('advance_amount_input');
            for (var i = 0; i < advanceAmountInputs.length; i++) {
                totalAdvanceAmount += parseFloat(advanceAmountInputs[i].value) || 0;
            }
            var pendingAmount = total - totalAdvanceAmount;
            // Update total amount, discount amount, total after discount, and pending amount fields
            document.getElementById('total').value = isNaN(total) ? '' : total.toFixed(2);
            // document.getElementById('discountAmount').value = isNaN(discountAmount) ? '' : discountAmount.toFixed(2);
            document.getElementById('total').value = isNaN(total) ? '' : total
                .toFixed(2);
            document.getElementById('pending_amount').value = isNaN(pendingAmount) ? '' : pendingAmount.toFixed(2);
        }
        window.onload = function() {
            calculateTotal();
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initial setup for existing elements
            setupEventListeners();

            // Trigger change event initially to show/hide details based on default selection
            var paymentMode = document.querySelectorAll(
                '.payment-container select[name^="advance_amount["][name$="][payment_mode]"]');
            paymentMode.forEach(function(select) {
                select.dispatchEvent(new Event('change'));
            });

            // Event listener for the add button
            var addButton = document.querySelector('.btn.btn-primary');
            addButton.addEventListener('click', addAdvanceAmountField);
        });

        // Function to set up event listeners for payment mode and display details
        function setupEventListeners() {
            var paymentMode = document.querySelectorAll(
                '.payment-container select[name^="advance_amount["][name$="][payment_mode]"]');
            var chequeDetails = document.querySelectorAll('.payment-container #chequeDetails');
            var ddDetails = document.querySelectorAll('.payment-container #ddDetails');

            // Loop through each select element
            paymentMode.forEach(function(select, index) {
                // Update the visibility when the select value changes
                select.onchange = function() {
                    chequeDetails[index].style.display = (this.value === '4') ? 'block' : 'none';
                    ddDetails[index].style.display = (this.value === '5') ? 'block' : 'none';
                };

                // Set initial visibility based on the initial select value
                chequeDetails[index].style.display = (select.value === '4') ? 'block' : 'none';
                ddDetails[index].style.display = (select.value === '5') ? 'block' : 'none';
            });
        }
        $(document).ready(function() {
            var fieldCounter = 0;

            $('#add-custom-field').on('click', function() {
                fieldCounter++;

                const customFieldInput = `
              
            <div class="payment-container">
                <div class="row">
                    <div class="col-md-4">
                        <div id="advance_amount_container">
                            <label for="advance_amount">Advance Amount</label>
                            <input class="form-control advance_amount_input" type="text"
                                name="advance_amount[][advance_amount]" id="advance_amount" oninput="calculateTotal()">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="payment_mode">Mode of Payment</label>
                        <select name="advance_amount[][payment_mode]" id="payment_mode" class="form-control">
                            <option value="">@lang('messages.please_select')</option>
                            <option value="1">Card</option>
                            <option value="2">Cash</option>
                            <option value="3">UPI</option>
                            <option value="4">Cheque</option>
                            <option value="5">Demand Draft(DD)</option>
                            <option value="6">NEFT</option>
                            <option value="7">RTGS</option>
                            <option value="8">UPI</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div id="chequeDetails" style="display: none;">
                            <div class="form-group">
                                <label for="advance_amount">Cheque No</label>
                                <input class="form-control {{ $errors->has('cheque_no') ? 'is-invalid' : '' }}"
                                    type="text" name="advance_amount[][cheque_no]" id="cheque_no"
                                    value="{{ old('cheque_no', '') }}">
                                @if ($errors->has('cheque_no'))
                                    <span class="text-danger">{{ $errors->first('cheque_no') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                            </div>
                            <div class="col-sm-12">
                                <label for="advance_amount"> Select Cheque Date </label>
                                <input type="date"
                                    class="form-control datepicker {{ $errors->has('form-control datepicker') ? 'is-invalid' : '' }}"
                                    name="advance_amount[][cheque_date]" id="cheque_date"
                                    rows="3">{{ old('cheque_date') }}
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label for="advance_amount">Account No</label>
                                <input class="form-control {{ $errors->has('account_no') ? 'is-invalid' : '' }}"
                                    type="text" name="advance_amount[][account_no]" id="account_no"
                                    value="{{ old('account_no', '') }}">
                                @if ($errors->has('account_no'))
                                    <span class="text-danger">{{ $errors->first('account_no') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                            </div>
                        </div>
                        <div id="ddDetails" style="display: none;">
                            <div class="form-group">
                                <label for="advance_amount">DD name</label>
                                <input class="form-control {{ $errors->has('dd_name') ? 'is-invalid' : '' }}"
                                    type="text" name="advance_amount[][dd_name]" id="dd_name">

                                @if ($errors->has('dd_name'))
                                    <span class="text-danger">{{ $errors->first('dd_name') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="advance_amount">DD Bank</label>
                                <input class="form-control {{ $errors->has('dd_bank') ? 'is-invalid' : '' }}"
                                    type="text" name="advance_amount[][advance_amount]" id="advance_amount">


                            </div>
                            <div class="form-group">
                                <label for="dd_no">DD No</label>
                                <input class="form-control {{ $errors->has('dd_no') ? 'is-invalid' : '' }}"
                                    type="text" name="advance_amount[][dd_no]" id="dd_no">

                            </div>
                            <div class="form-group">
                                <label for="account_no">Account No</label>
                                <input class="form-control {{ $errors->has('account_no') ? 'is-invalid' : '' }}"
                                    type="text" name="advance_amount[][account_no]" id="account_no">
                                @if ($errors->has('account_no'))
                                    <span class="text-danger">{{ $errors->first('account_no') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.project.fields.location_helper') }}</span>
                            </div>



                        </div>
                        <div>
                            <label for="Credited/Not_Credited">Credited/Not Credited</label>
                            <select name="advance_amount[][credit_not_credit]" id="credit_not_credit"
                                class="form-control">
                                <option value="">@lang('messages.please_select')</option>
                                <option value="1">Credited</option>
                                <option value="2">Not Credited</option>
                            </select>
                        </div>
                    </div>


                </div>
             

           
                       

    </div>`;
                $('#custom-fields-container').append(customFieldInput);
                setupEventListeners();
            });

            // Remove Field button click event
            $('#custom-fields-container').on('click', '.remove-field', function() {
                $(this).parent().parent().remove();
            });

            // Form submission event

        });
    </script>
@endsection
