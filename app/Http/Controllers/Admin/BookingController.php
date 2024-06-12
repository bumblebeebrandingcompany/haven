<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFOIRequest;
use App\Models\Booking;
use App\Models\Campaign;
use App\Models\Lead;
use App\Models\LeadEvents;
use App\Models\PlotDetail;
use App\Models\Project;
use App\Models\Source;
use App\Utils\Util;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use View;

class BookingController extends Controller
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

    /*
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if (!auth()->user()->checkPermission('booking_view')) {
        //     abort(403, 'Unauthorized.');
        // }

        $booking = Booking::all();
        $plotdetail = PlotDetail::all();
        return view('admin.booking_new.index', compact('booking', 'plotdetail'));
    }

    /*
     * Show the form for creating a new resource.
     */

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $booking = new Booking();
        $booking->name = $request->name;
        $booking->aadhar_no = $request->aadhar_no;
        $booking->pan = $request->pan;
        $booking->phone = $request->phone;
        $booking->secondary_phone = $request->secondary_phone;
        $booking->email = $request->email;
        $booking->secondary_email = $request->secondary_email;
        // $booking->plc_values= $request->plc_values;
        $booking->total_amount = $request->total_amount;
        $booking->pending_amount = $request->pending_amount;
        $booking->discount_value_sqft_based = $request->discount_value_sqft_based;
        $booking->discount_amount_sqft_based = $request->discount_amount_sqft_based;
        // $booking->discount_value_including_plc= $request->discount_value_including_plc;
        // $booking->discount_amount_including_plc= $request->discount_amount_including_plc;
        $booking->advance_amount = json_encode($request->advance_amount);
        $booking->{'credit/not_credit'} = $request->{'credit/not_credit'};
        $booking->status_id = $request->status_id;
        $booking->plot_id = $request->plot_id;
        $booking->remarks = $request->remarks;
        $booking->user_type = $request->user_type;
        $booking->per_sqft_based_price = $request->per_sqft_based_price;

        // $booking->plot_id = json_encode($request->plot_id);

        $booking->save();
        $plot = PlotDetail::find($request->plot_id);

        if ($plot) {
            // Update the status_id of the plot
            $plot->status_id = $request->status_id;
            $plot->save();
        } else {
            // Handle the case where the plot is not found
            // You might want to return an error message or handle it in a different way based on your application's logic
        }
        return redirect()->back()->with('success', 'Form submitted successfully!');

    }

    /*
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // if (!auth()->user()->checkPermission('bookings_view')) {
        //     abort(403, 'Unauthorized.');
        // }

        $query = LeadEvents::with('lead', 'project');

        if (!auth()->user()->is_superadmin) {
            $query->where('lead_events.created_by', auth()->user()->id);
        }

        $event = $query->findOrFail($id);

        return view('admin.bookings.show')
            ->with(compact('event'));
    }

    /*
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // if (!auth()->user()->checkPermission('bookings_edit')) {
        //     abort(403, 'Unauthorized.');
        // }

        $lead_event = LeadEvents::with('lead')->findOrFail($id);

        $project_ids = $this->util->getUserProjects(auth()->user());
        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')
            ->toArray();

        $campaigns = Campaign::where('project_id', 1)
            ->pluck('campaign_name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $sources = Source::where('project_id', 1)
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bookings.edit')
            ->with(compact('lead_event', 'projects', 'campaigns', 'sources'));
    }
    public function bookedit(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $plotdetail = PlotDetail::all();
        return view('admin.booking_new.edit', compact('booking', 'plotdetail'));
    }
    /*
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $booking = Booking::findOrFail($id);
        $booking->payment_mode = $request->payment_mode;
        $booking->cheque_no = $request->cheque_no;
        $booking->bank_name = $request->bank_name;
        $booking->account_no = $request->account_no;
        $booking->cheque_date = $request->cheque_date;
        $booking->dd_name = $request->dd_name;
        $booking->dd_no = $request->dd_no;
        $booking->dd_date = $request->dd_date;
        $booking->dd_bank = $request->dd_bank;
        $booking->status_id = $request->status_id;
        $booking->remarks = $request->remarks;
        $booking->user_type = $request->user_type;
        $booking->per_sqft_based_price = $request->per_sqft_based_price;
        $booking->created_at = $request->created_at;

        $booking->{'credit/not_credit'} = $request->{'credit/not_credit'};
        \Log::info('Request Data: ' . json_encode($request->all()));
        $booking->update(); // Save the changes to the database
        try {
            $booking->update($request->all());
        } catch (\Exception $e) {
            \Log::error('Error updating booking: ' . $e->getMessage());
            // Handle the error appropriately, such as showing an error message to the user
        }
        return view('admin.booking_new.form', compact('booking'));
    }
    public function create(Request $request)
    {
        $project_ids = $this->util->getUserProjects(auth()->user());
        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')
            ->toArray();

        $phone = $request->get('phone', null);
        $project_id = request()->get('project_id', null);

        $projectId = $request->input('projectId');
        $plotdetails = PlotDetail::where('project_id', $projectId)->get();
        $project = Project::all();

        return view('admin.booking_new.create')
            ->with(compact('projects', 'phone', 'plotdetails', 'project','project_id'));
    }
    public function book(Request $request)
    {
        $projectId = $request->input('projectId');

        $plotNo = $request->input('plot_no');

        // Retrieve the plot detail where plot_no matches
        $plotdetail = PlotDetail::where('plot_no', $plotNo)->first();

        // Get all plot details for the specified project
        $plotdetails = PlotDetail::where('project_id', $projectId)->get();
        $plots = PlotDetail::where('project_id', $projectId)->pluck('plot_no', 'id')->toArray();

        $booking = Booking::all();
        $difference = 100000;
        $bookingblocked = Booking::select('plot_details.plot_no')->join('plot_details', 'plot_details.id', 'booking.plot_id')->where('booking.status_id', 1)->where('plot_details.project_id', $projectId)->selectRaw('ABS(booking.total_amount - booking.pending_amount) as amount_difference')->havingRaw('amount_difference < ?', [$difference])->pluck('plot_details.plot_no')->toArray();
        $bookingbooked = Booking::select('plot_details.plot_no')->join('plot_details', 'plot_details.id', 'booking.plot_id')->where('booking.status_id', 1)->where('plot_details.project_id', $projectId)->selectRaw('ABS(booking.total_amount - booking.pending_amount) as amount_difference')->havingRaw('amount_difference > ?', [$difference])->pluck('plot_details.plot_no')->toArray();
        $bookingreg = Booking::select('plot_details.plot_no')->join('plot_details', 'plot_details.id', 'booking.plot_id')->where('booking.status_id', 4)->where('plot_details.project_id', $projectId)->selectRaw('ABS(booking.total_amount - booking.pending_amount) as amount_difference')->havingRaw('amount_difference > ?', [$difference])->pluck('plot_details.plot_no')->toArray();
        // Extract status IDs from bookings
        $status_ids = $booking->pluck('status_id')->toArray();

        return view('admin.booking_new.booking', compact('booking', 'status_ids', 'plotdetail', 'bookingblocked', 'bookingbooked', 'bookingreg', 'plotdetails', 'plots', ));
    }

    public function booking($id)
    {
        $project_id = request()->get('project_id', null);

        $project_ids = $this->util->getUserProjects(auth()->user());
        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')
            ->toArray();
        $plotdetail = PlotDetail::findOrFail($id);
        $booking = Booking::where('plot_id', $id)->first();
        return view('admin.booking_new.view', compact('plotdetail', 'booking', 'projects','project_id'));
    }

    public function destroy(string $id)
    {
        // if (!auth()->user()->checkPermission('bookings_delete')) {
        //     abort(403, 'Unauthorized.');
        // }

        $event = LeadEvents::findOrFail($id);

        $event->delete();

        return back();
    }

    public function massDestroy(MassDestroyFOIRequest $request)
    {
        // if (!auth()->user()->checkPermission('bookings_delete')) {
        //     abort(403, 'Unauthorized.');
        // }

        $events = LeadEvents::find(request('ids'));

        foreach ($events as $event) {
            $event->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getLeadDetails(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->input('search_term');
            // $projectId = $request->input('project_id');
            $plotdetailId = $request->input('plot_id');
            $leadsQuery = Lead::where(function ($query) use ($searchTerm) {
                $query->whereJsonContains('essential_fields->Phone Number', $searchTerm)
                    ->orWhereJsonContains('essential_fields->Addl Number', $searchTerm);
            });

            $lead = $leadsQuery->first();
            $msg = "Lead is not found with this number. Please create a new lead";
            $redirectUrl = route('admin.leads.create', ['phone' => $searchTerm, 'plotdetailId' => $plotdetailId, 'action' => 'default_action']);

            if (!$lead) {
                return [
                    'msg' => $msg,
                    'success' => false,
                    'redirect_url' => $redirectUrl,
                ];
            }

            $projectIds = $this->util->getUserProjects(auth()->user());
            $projects = Project::whereIn('id', $projectIds)
                ->pluck('name', 'id')
                ->toArray();

            $plotdetail = PlotDetail::findOrFail($plotdetailId);


            $html = View::make('admin.booking_new.partials.sell_do_and_lead_info', [
                'lead' => $lead,
                'projects' => $projects,
                // 'campaigns' => $campaigns,
                // 'sources' => $sources,
                'plotdetail' => $plotdetail,
            ])->render();
            return [
                'success' => true,
                'html' => $html, // Optionally return HTML if needed
            ];
        }
    }

}
