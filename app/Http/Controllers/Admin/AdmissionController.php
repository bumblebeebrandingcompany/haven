<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\Lead;
use App\Models\Application;
use App\Models\Admission;
use App\Utils\Util;
use Illuminate\Http\Request;



class AdmissionController extends Controller
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
        $admissions=Admission::all();

        $application=Application::all();
        return view('admin.admission.index', compact( 'lead','admissions','application',));
    }
    public function store(Request $request)
    {
        $lead = Lead::find($request->lead_id);
        if ($lead) {
            $parentStageId = $request->input('stage_id');
            $admission = new Admission();
            $admission->lead_id = $lead->id;
            $admission->application_id =$lead->application->id;
            $admission->follow_up_date = $request->input('follow_up_date');
            $admission->notes = $request->input('notes');
            $admission->follow_up_time = $request->input('follow_up_time');
            $admission->stage_id = $parentStageId;

            $admission->save();
            $lead->stage_id = $parentStageId;
            if ($admission->lead) {
                $admission->lead->update(['stage_id' => $admission->stage_id]);
            }
            return redirect()->back()->with('success', 'Form submitted successfully!');
        } else {
            return redirect()->back()->with('error', 'Lead not found!');
        }
    }

}
