<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Utils\Util;
use App\Models\Project;
use App\Models\Lead;




class EnquiryController extends Controller
{

    protected $util;

    /**
     * Constructor
     *
     */
    public function __construct(Util $util)
    {
        $this->util = $util;
    }
    public function index()
    {

        $enquires = Enquiry::all();
        $projects = Project::pluck('name', 'id');

        return view('admin.enquires.index', compact('enquires'));
    }

    public function show(Enquiry $enquiry)
    {
        return view('admin.enquires.show', compact('enquiry'));
    }


    public function create()
    {

        $project_ids = $this->util->getUserProjects(auth()->user());
        $projects = Project::whereIn('id', $project_ids)
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            $project_id = request()->get('project_id', null);
            $phone = request()->get('phone', null);
            $action = request()->get('action', null);
        return view('admin.enquires.create', compact('projects', 'project_id', 'phone', 'action'));
    }


    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'phone' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'referred_by' => 'required|string|max:255',

        ]);

        $enquiry = Enquiry::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'project_id' => $request->input('project_id'),
            'phone' => $request->input('phone'),
            'city' => $request->input('city'),
            'referred_by' => $request->input('referred_by'),
        ]);
        // $lead_exist = Lead::where(function ($query) {
        //     $query->where('phone', $enquiry['phone'])
        //           ->orWhere('secondary_phone', $enquiry['secondary_phone'])
        //           ->orWhere('email', $enquiry['email'])
        //           ->orWhere('additional_email', $enquiry['additional_email']);
        // })->first();
        // if (!$lead_exist) {
        //     $lead=Lead::create([
        //         'enquiry_id'=>$enquiry->id,
        //         'name' => $enquiry->name,
        //         'email' => $enquiry->email,
        //         'project_id' => $enquiry->project_id,
        //         'phone' => $enquiry->phone,
        //         'comments'=>$request->input('comments'),
        //         'cp_comments'=>$request->input('cp_comments'),
        //         'additional_email'=>$request->input('additional_email'),
        //         'secondary_phone'=>$request->input('secondary_phone'),

        //     ]);
        //     $lead->ref_num = $this->util->generateLeadRefNum($lead);
        //     $lead->save();
        // } else {
        //     $phone_arr = [$lead_exist['phone'], $lead_exist['secondary_phone']];
        //     if (!in_array($details['phone'], $phone_arr)) {
        //         if (!$lead->phone) {
        //             $lead->phone = $details['phone'];
        //         } else if (!$lead->secondary_phone) {
        //             $lead->secondary_phone = $details['phone'];
        //         } else {
        //             $p_arr = ['phone'=> $details['phone']];
        //             $arr = json_decode($lead->contact_notes, true);
        //             $lead->contact_notes = json_encode(array_push($arr, $p_arr));
        //         }
        //         $lead->save();
        //     }
        //     if (!in_array($details['secondary_phone'], $phone_arr)) {
        //         if (!$lead->phone) {
        //             $lead->phone = $details['secondary_phone'];
        //         } else if (!$lead->secondary_phone) {
        //             $lead->secondary_phone = $details['secondary_phone'];
        //         } else {
        //             $p_arr = ['phone'=> $details['secondary_phone']];
        //             $arr = json_decode($lead->contact_notes, true);
        //             $lead->contact_notes = json_encode(array_push($arr, $p_arr));
        //         }
        //         $lead->save();
        //     }
        //     // for email
            
        //     $email_arr = [$lead_exist['email'], $lead_exist['additional_email']];
        //     if (!in_array($details['email'], $email_arr)) {
        //         if (!$lead->phone) {
        //             $lead->phone = $details['email'];
        //         } else if (!$lead->additional_email) {
        //             $lead->additional_email = $details['email'];
        //         } else {
        //             $p_arr = ['email'=> $details['email']];
        //             $arr = json_decode($lead->contact_notes, true);
        //             $lead->contact_notes = json_encode(array_push($arr, $p_arr));
        //         }
        //         $lead->save();
        //     }
        //     if (!in_array($details['additional_email'], $email_arr)) {
        //         if (!$lead->phone) {
        //             $lead->phone = $details['additional_email'];
        //         } else if (!$lead->additional_email) {
        //             $lead->additional_email = $details['additional_email'];
        //         } else {
        //             $p_arr = ['email'=> $details['additional_email']];
        //             $arr = json_decode($lead->contact_notes, true);
        //             $lead->contact_notes = json_encode(array_push($arr, $p_arr));
        //         }
        //         $lead->save();
        //     }
        // }
        // $this->util->storeUniqueWebhookFields($lead);
        // if(!empty($lead->project->outgoing_apis)) {
        //     $this->util->sendApiWebhook($lead->id);
        // }

        if(!empty($request->get('redirect_to')) && $request->get('redirect_to') == 'ceoi') {
            return redirect()->route('admin.eoi.create', ['phone' => $lead->phone]);
        }
        return redirect()->route('admin.aztec.index')->with('success', 'Form created successfully');
    }
    public function edit(Enquiry $enquiry)
    {
        return view('admin.enquires.edit', compact('enquiry'));
    }

    public function update(Request $request, Enquiry $enquiry)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string',
        'project_id' => 'required|exists:projects,id',
        'phone' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'referred_by' => 'required|string|max:255',
    ]);

    // Update the Enquiry attributes
    $enquiry->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'project_id' => $request->input('project_id'),
        'phone' => $request->input('phone'),
        'city' => $request->input('city'),
        'referred_by' => $request->input('referred_by'),
    ]);

    // Retrieve the associated Lead using the relationship
    $lead = $enquiry->leads()->first();

    // Update the associated Lead attributes
    $lead->update([
        'name' => $enquiry->name,
        'email' => $enquiry->email,
        
        'project_id' => $enquiry->project_id,
        'phone' => $enquiry->phone,
        'comments'=>$request->input('comments'),
        'cp_comments'=>$request->input('cp_comments'),
        'additional_email'=>$request->input('additional_email'),
        'secondary_phone'=>$request->input('secondary_phone'),

    ]);

    $this->util->storeUniqueWebhookFields($lead);
    return redirect()->route('admin.aztec.index')->with('success', 'Form updated successfully');
}


    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return redirect()->route('admin.aztec.index')->with('success', 'Enquiry deleted successfully');
    }




}
