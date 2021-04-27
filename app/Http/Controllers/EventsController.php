<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }
    public function create()
    {
    	return view('events.create');
    }
    public function store()
    {
    	$data = request()->validate([
    		'title' => 'required',
    		'description' => 'required',
    		'objective' => 'required',
    		'date' => 'required|date',
    		'start_time' => 'date_format:H:i',
    		'end_time' => 'date_format:H:i|after:start_time',
    		'venue' => 'required',
    		'activity_type' => 'required',
    		'beneficiaries' => 'required',
    		'sponsors' => 'required',
    		'budget' => '',
    		'poster' => '',
    		'poster_caption' => '',
    		'evidence' => '',
    		'evidence_caption' => '',
    	]);
    	auth()->user()->events()->create([
    		'title' => $data['title'],
    		'description' => $data['description'],
    		'objective' => $data['objective'],
    		'date' => $data['date'],
    		'start_time' => $data['start_time'],
    		'end_time' => $data['end_time'],
    		'venue' => $data['venue'],
    		'activity_type' => $data['activity_type'],
    		'beneficiaries' => $data['beneficiaries'],
    		'sponsors' => $data['sponsors'],
    		'budget' => $data['budget'],
    	]);
    	return redirect('home');
    	//dd($data);
    	// $imagePath = request('image')->store('uploads', 'public');

     //    $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
     //    $image->save();

    	// auth()->user()->posts()->create([
    	// 	'caption' => $data['caption'],
    	// 	'image' => $imagePath,
    	// ]);
    	// return redirect('/profile/'.auth()->user()->id);
    	// dd(request()->all());
    }
}
