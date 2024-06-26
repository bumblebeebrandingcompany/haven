<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SiteVisitRequest;
use App\Models\Campaign;
use App\Models\Clients;
use App\Models\Lead;
use App\Models\LeadTimeline;
use App\Models\SiteVisit;
use App\Models\ParentStage;
use App\Models\Application;
use App\Models\StageNotes;
use App\Models\Tag;
use App\Models\User;
use App\Utils\Util;
use Illuminate\Http\Request;

class SiteVisitController extends Controller
{
    /**
     * All Utils instance.
     *
     */

    protected $util;
    protected $lead_view;
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
        $lead = Lead::all();
        $client = Clients::all();
        $agencies = User::all();
        $campaigns = Campaign::all();
        $sitevisits = SiteVisit::all(); // Fixed variable name to $sitevisits
        $ids = $sitevisits->pluck('id'); // Get an array of all sitevisit IDs
        $parentStages = ParentStage::all();
        $tags = Tag::all();
        $sitevisitId = SiteVisit::all();
        $ids = [];
        foreach ($sitevisits as $sitevisit) {
            $ids[] = $sitevisit->id;
        }
        // $itemsPerPage = request('perPage', 10);
        // $sitevisits = SiteVisit::paginate($itemsPerPage);
        return view('admin.sitevisit.index', compact('campaigns', 'agencies', 'lead', 'sitevisits', 'ids', 'client', 'parentStages', 'tags'));
    }
    public function store(SiteVisitRequest $request)
    {
        $input = $request->validated();

        $lead = Lead::findOrFail($input['lead_id']);
        $parentStageId = $request->input('stage_id');
        $sitevisit = new SiteVisit();
        $sitevisit->lead_id = $lead->id;
        $sitevisit->visit_date = $input['visit_date']; // Assign the date
        $sitevisit->visit_time = $input['visit_time']; // Assign the time
        $sitevisit->notes = $input['notes'];
        $sitevisit->created_by = auth()->user()->id;
        $sitevisit->stage_id = $parentStageId;
        $sitevisit->save();
        $sitevisit->lead->update(['stage_id' => $sitevisit->stage_id]);
        $this->logTimeline($lead, $sitevisit, 'Site Visit created', 'sitevisit_created');
        return redirect()->back()->with('success', 'Form submitted successfully!');
    }

    private function logTimeline(Lead $lead, $sitevisit, $type, $description)
    {
        $timeline = new LeadTimeline;
        $timeline->activity_type = $type;
        $timeline->lead_id = $lead->id;

        // Combine lead and site visit data into payload
        $payload = [
            'lead' => $lead->toArray(),
            'sitevisit' => $sitevisit->toArray()
        ];

        $timeline->payload = json_encode($payload); // Convert array to JSON
        // $timeline->description = $description;
        $timeline->save();
    }
    public function rescheduleSiteVisit(Request $request)
    {
        // Validate the request data
        $request->validate([
            'lead_id' => 'required|integer',
            'follow_up_date' => 'required|date',
            'follow_up_time' => 'required',
            'notes' => 'required|string',
            'stage_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        // Get the stage_id from the request
        $parentStageId = $request->input('stage_id');

        // Find all existing site visits with the same lead_id and stage_id
        $siteVisitsToUpdate = SiteVisit::where('lead_id', $request->lead_id)
            ->where('stage_id', $parentStageId)
            ->get();

        // Update each existing site visit to mark as 'rescheduled'
        foreach ($siteVisitsToUpdate as $siteVisit) {
            $siteVisit->update(['stage_id' => 19]);
        }

        // Create a new SiteVisit
        $newSiteVisit = new SiteVisit();
        $newSiteVisit->follow_up_date = $request->follow_up_date;
        $newSiteVisit->follow_up_time = $request->follow_up_time;
        $newSiteVisit->lead_id = $request->lead_id;
        $newSiteVisit->user_id = $request->user_id;

        $newSiteVisit->notes = $request->notes;
        $newSiteVisit->stage_id = $parentStageId; // Set stage_id directly
        $newSiteVisit->save();

        $lead = Lead::find($request->lead_id);
        if ($lead) {
            $lead->update(['stage_id' => 19]);
        }
        $this->logTimeline($lead, $newSiteVisit, 'Rescheduled', 'sitevisit_rescheduled');
        return redirect()->back()->with('success', 'Site visits rescheduled successfully.');
    }
    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'follow_up_date' => 'date',
            'follow_up_time' => 'date_format:H:i',
            'deleted_at' => 'date',
            'lead_id' => [
                'required',
                'integer',
            ],
            'notes' => 'nullable|string',
        ]);

        // Find the original SiteVisit record by ID
        $originalSiteVisit = SiteVisit::find($id);
        if (!$originalSiteVisit) {
            return redirect()->back()->with('error', 'Site visit not found.');
        }

        $parentStageId = $request->input('stage_id');

        // Update the old schedule's stage_id to 19
        $originalSiteVisit->update(['stage_id' => 19]);

        // Create a new SiteVisit
        $newSiteVisit = new SiteVisit();
        $newSiteVisit->follow_up_date = $request->follow_up_date;
        $newSiteVisit->follow_up_time = $request->follow_up_time;
        $newSiteVisit->lead_id = $request->lead_id;
        // $newSiteVisit->user_id = $request->user_id;
        $newSiteVisit->notes = $request->notes;
        $newSiteVisit->stage_id = $parentStageId;
        $newSiteVisit->save();

        $lead = Lead::find($request->lead_id);
        if ($lead) {
            $lead->update(['stage_id' => 19]);
        }
        $this->logTimeline($lead, $newSiteVisit, 'Rescheduled', 'sitevisit_rescheduled');
        return redirect()->back()->with('success', 'Site visit rescheduled successfully.');
    }

    public function cancelSiteVisit(Request $request, $sitevisitId)
    {
        $sitevisit = SiteVisit::findOrFail($sitevisitId);
        $lead = Lead::find($sitevisit->lead_id);

        if ($lead) {
            $parentStageId = $request->input('stage_id');
            $sitevisit->update(['stage_id' => $parentStageId]);

            $lead->update(['stage_id' => $parentStageId]);

            $note = new StageNotes();
            $note->lead_id = $sitevisit->lead_id;
            $note->stage_id = $parentStageId;
            $note->notes = $request->input('notes');
            $note->stage = $request->input('stage');
            $note->save();

            // Call logTimeline with lead instance
            $this->logTimeline($lead, $note, 'Stage Changed', "Stage was updated to {$parentStageId}");

            return redirect()->back()->with('success', 'Site visit cancelled successfully!');
        }

        // Handle case where lead is not found
        // You might want to return a response indicating that the lead was not found.
    }


    public function conductedstage(Request $request)
    {
        $parentStageId = $request->input('stage_id');
        $lead = Lead::find($request->lead_id);

        if ($lead) {
            $parentStageId = $request->input('stage_id');

            $note = new StageNotes();
            $note->lead_id = $lead->id;
            $note->stage_id = $parentStageId;
            $note->notes = $request->input('notes');
            $note->stage = $request->input('stage');
            $note->save();

            // Update the stage_id of the latest SiteVisit
            $latestSiteVisit = $lead->siteVisits()->latest()->first();
            if ($latestSiteVisit) {
                $latestSiteVisit->update(['stage_id' => $parentStageId, 'user_id' => auth()->user()->id]);
            }

            $lead->stage_id = $parentStageId;
            $lead->save();

            $this->logTimeline($lead, $note, 'Stage Changed', "Stage was updated to {$parentStageId}");

            return redirect()->back()->with('success', 'Site visit conducted successfully!');
        }
    }

    public function notvisitedstage(Request $request)
    {
        $parentStageId = $request->input('stage_id');
        $lead = Lead::find($request->lead_id);

        if ($lead) {
            $parentStageId = $request->input('stage_id');

            $note = new StageNotes();
            $note->lead_id = $lead->id;
            $note->stage_id = $parentStageId;
            $note->notes = $request->input('notes');
            $note->stage = $request->input('stage');
            $note->save();

            // Update the stage_id of the latest SiteVisit
            $latestSiteVisit = $lead->siteVisits()->latest()->first();
            if ($latestSiteVisit) {
                $latestSiteVisit->update(['stage_id' => $parentStageId]);
            }

            $lead->stage_id = $parentStageId;
            $lead->save();

            $this->logTimeline($lead, $note, 'Stage Changed', "Stage was updated to {$parentStageId}");

            return redirect()->back()->with('success', 'Site visit conducted successfully!');
        }
    }
    public function cancelstage(Request $request)
    {
        $parentStageId = $request->input('stage_id');
        $lead = Lead::find($request->lead_id);

        if ($lead) {
            $parentStageId = $request->input('stage_id');

            $note = new StageNotes();
            $note->lead_id = $lead->id;
            $note->stage_id = $parentStageId;
            $note->notes = $request->input('notes');
            $note->stage = $request->input('stage');
            $note->save();

            // Update the stage_id of the latest SiteVisit
            $latestSiteVisit = $lead->siteVisits()->latest()->first();
            if ($latestSiteVisit) {
                $latestSiteVisit->update(['stage_id' => $parentStageId]);
            }

            $lead->stage_id = $parentStageId;
            $lead->save();

            $this->logTimeline($lead, $note, 'Stage Changed', "Stage was updated to {$parentStageId}");

            return redirect()->back()->with('success', 'Site visit conducted successfully!');
        }
    }
    public function conducted(Request $request, $sitevisitId)
    {
        $sitevisit = SiteVisit::findOrFail($sitevisitId);
        $lead = Lead::find($sitevisit->lead_id);
        if ($lead) {
            $parentStageId = $request->input('stage_id');
            $sitevisit->update([
                'stage_id' => $parentStageId,
                'created_by' => $request->input('created_by'),
            ]);
            $lead->update([
                'stage_id' => $parentStageId,

            ]);

            $note = new StageNotes();
            $note->lead_id = $sitevisit->lead_id;
            $note->stage_id = $parentStageId;
            $note->notes = $request->input('notes');
            $note->stage = $request->input('stage');
            $note->save();

            // Call logTimeline with lead instance
            $this->logTimeline($lead, $note, 'Stage Changed', "Stage was updated to {$parentStageId}");

            return redirect()->back()->with('success', 'Site visit cancelled successfully!');
        }

        // Handle case where lead is not found
        // You might want to return a response indicating that the lead was not found.
    }

    public function applicationpurchased(Request $request, $sitevisitId)
    {

        $sitevisit = SiteVisit::findOrFail($sitevisitId);

        $sitevisit->update([
            'stage_id' => $request->input('stage_id'),
            'notes' => $request->input('notes'),
            'user_id' => $request->input('user_id'),
            'application_no' => $request->input('application_no'),

        ]);
        if ($sitevisit->lead) {
            $sitevisit->lead->update([
                'stage_id' => $sitevisit->stage_id,
                'user_id' => $request->input('user_id'),
                'application_no' => $sitevisit->application_no,
                'notes' => $sitevisit->notes,
            ]);
            $parentStageId = $request->input('stage_id');
            $applicationpurchased = new Application();
            $applicationpurchased->lead_id = $sitevisit->lead_id;
            $applicationpurchased->who_assigned = auth()->user()->id; // Store current user_id
            $applicationpurchased->for_whom = $request->input('user_id');
            $applicationpurchased->application_no = $request->input('application_no');
            $applicationpurchased->follow_up_date = $request->input('follow_up_date');
            $applicationpurchased->notes = $request->input('notes');
            $applicationpurchased->follow_up_time = $request->input('follow_up_time');
            $applicationpurchased->stage_id = $parentStageId;
            $applicationpurchased->lead->update(['user_id' => $applicationpurchased->for_whom]);
            $applicationpurchased->save();
        }
        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'application purchased successfully!');
    }



    public function notvisited(Request $request, $sitevisitId)
    {
        $sitevisit = SiteVisit::findOrFail($sitevisitId);
        $lead = Lead::find($sitevisit->lead_id);

        if ($lead) {
            $parentStageId = $request->input('stage_id');
            $sitevisit->update(['stage_id' => $parentStageId]);

            $lead->update(['stage_id' => $parentStageId]);

            $note = new StageNotes();
            $note->lead_id = $sitevisit->lead_id;
            $note->stage_id = $parentStageId;
            $note->notes = $request->input('notes');
            $note->stage = $request->input('stage');
            $note->save();

            // Call logTimeline with lead instance
            $this->logTimeline($lead, $note, 'Stage Changed', "Stage was updated to {$parentStageId}");

            return redirect()->back()->with('success', 'Site visit cancelled successfully!');
        }


    }

}
