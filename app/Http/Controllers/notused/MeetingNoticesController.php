<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MeetingNotice;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class MeetingNoticesController extends Controller
{
    public function index()
    {
        $notices = MeetingNotice::orderByRaw('YEAR(`creation_date`) DESC, MONTH(`creation_date`) ASC')
        ->get();
        return view('meetingnotices.index', compact('notices'));
    }
    public function show($notice_uuid)
    {     
        if($mn = MeetingNotice::where('notice_uuid', $notice_uuid)->first())
        {   
            $mn->creation_date = Carbon::parse($mn->creation_date)->format('F d, Y');
            $mn->meeting_date = Carbon::parse($mn->meeting_date)->format('F d, Y h:iA');
            //dd($mn);
            return view('meetingnotices.show', compact('mn'));

        }
        else
            abort(404);
    }
    public function edit($notice_uuid)
    {
        if($mn = MeetingNotice::where('notice_uuid', $notice_uuid)->first())
        {   
            $mn->meeting_date = Carbon::parse($mn->meeting_date)->format('Y-m-d\TH:i');
            return view('meetingnotices.edit', compact('mn'));
        }
         else
            abort(404);
    }
    public function update($notice_uuid)
    {
        if($mn = MeetingNotice::where('notice_uuid', $notice_uuid)->first())
        {    
            $data = request()->validate([
            'for' => 'required',
            'from' => 'required',
            'creation_date' => 'required|date',
            'meeting_date' => 'required|date',
            'venue' => 'required',
            'objectives' => 'required',
            ]); 
            $mn->update([
            'for' => $data['for'],
            'from' => $data['from'],
            'creation_date' => $data['creation_date'],
            'meeting_date' => $data['meeting_date'],
            'venue' => $data['venue'],
            'objectives' => $data['objectives'],
            ]);
            return redirect()->route('meetingNotice.show', $notice_uuid);
        }
        else
            abort(404);

    }
    public function destroy($id)
    {
        if ($mn = MeetingNotice::where('meetingnotice_id', $id)->first())
        {
            if ($mn->delete())
            return redirect()->route('meetingnotices.index', compact('mn'));
    }
            else
               abort(404); 
    }
    public function create()
    {
    	return view('meetingnotices.create');
    }

    public function store()
    {

        $data = request()->validate([
            'for' => 'required',
            'from' => 'required',
            'creation_date' => 'required|date',
            'meeting_date' => 'required|date',
            'venue' => 'required',
            'objectives' => 'required',
        ]);	

        $meetingnotice_id = MeetingNotice::create([
            'notice_uuid' => Str::uuid(),
            'for' => $data['for'],
            'from' => $data['from'],
            'creation_date' => $data['creation_date'],
            'meeting_date' => $data['meeting_date'],
            'venue' => $data['venue'],
            'objectives' => $data['objectives'],

        ])->meetingnotice_id;
    	 return redirect()->route('show', compact('notices'));
    }
}

