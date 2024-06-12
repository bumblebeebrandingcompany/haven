<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Campaign;

use App\Models\Lead;

use App\Utils\Util;
use App\Models\Note;


use Illuminate\Http\Request;


class NoteController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    public function __construct(Util $util)
    {
        $this->util = $util;

    }

    public function store(Request $request)
    {
        $lead = Lead::find($request->lead_id);
        if ($lead) {
            $input = $request->except(['_method', '_token', 'redirect_to']);
            
            // Create the note
            $notes = new Note();
            $notes->lead_id = $lead->id;
            $notes->sell_do_lead_id = $request->sell_do_lead_id ?? null; // Adjust as needed
            $notes->notes = $input['notes'] ?? null; // Adjust the key based on your form input
            $notes->event_type = $input['event_type'] ?? null; // Adjust the key based on your form input
            $notes->save();
            return redirect()->back()->with('success', 'Form submitted successfully!');
        } else {
            // Handle the case where the lead is not found
            return redirect()->back()->with('error', 'Lead not found!');
        }
    }
    
}

