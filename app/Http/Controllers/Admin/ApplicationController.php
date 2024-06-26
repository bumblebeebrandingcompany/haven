<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\Application;
use App\Utils\Util;
use Illuminate\Http\Request;


class ApplicationController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $util;
    use MediaUploadingTrait, CsvImportTrait;
    public function __construct(Util $util)
    {
        $this->util = $util;
    }

    public function index(Request $request)
    {
        $lead = Lead::all();
        $agencies = User::all();
        // Alternatively, if you want to get the IDs in a loop
        $applications = Application::all();

        return view('admin.applicationpurchased.index', compact('lead', 'applications', 'agencies'));
    }
    public function store(Request $request)
    {
        $lead = Lead::find($request->lead_id);

        if ($lead) {
            $parentStageId = $request->input('stage_id');
            $applicationpurchased = new Application();
            $applicationpurchased->lead_id = $lead->id;
            $applicationpurchased->who_assigned = auth()->user()->id;
            $applicationpurchased->for_whom = $request->input('user_id');
            $applicationpurchased->application_no = $request->input('application_no');
            $applicationpurchased->application_date = $request->input('follow_up_date');
            $applicationpurchased->notes = $request->input('notes');
            $applicationpurchased->application_time = $request->input('follow_up_time');
            $applicationpurchased->stage_id = $parentStageId;
            $applicationpurchased->lead->update(['user_id' => $applicationpurchased->for_whom]);
            $applicationpurchased->save();
            if ($applicationpurchased->lead) {
                $applicationpurchased->lead->update(['stage_id' => $applicationpurchased->stage_id]);
                $latestSiteVisit = $applicationpurchased->lead->siteVisits()->latest()->first();
                if ($latestSiteVisit) {
                    $latestSiteVisit->update(['stage_id' => $applicationpurchased->stage_id]);
                }
            }

            return redirect()->back()->with('success', 'Form submitted successfully!');
        } else {
            return redirect()->back()->with('error', 'Lead not found!');
        }
    }


}

