<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Hour as Hour;

class HourController extends Controller
{
    
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role_permission');
    }

    /**
     * public array of form fields
     * @return array
     */
    public $fields = [
        'title' => ['type' => 'text', 'class' => '', 'id' => 'title', 'lable' => 'Title','value'=>''],
        'content' => ['type' => 'text-area', 'class' => 'form-control', 'id' => 'content', 'lable' => 'Description','value'=>''],
        'time' => ['type' => 'text', 'class' => '', 'id' => 'time', 'lable' => 'Hours (eq. 30 minute = 0.5 hour)','value'=>''],
        'activity_date' => ['type' => 'text', 'class' => 'datepicker', 'id' => '', 'lable' => 'Activity Date','value'=>''],
        'action' => ['type' => 'hidden', 'class' => '', 'id' => 'action', 'lable' => '','value' => '']
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $teams = Hour::where('user_id', $id)
               ->orderBy('activity_date', 'asc')               
               ->get();
        $listRoute = route('hours-list',$id);       
        $formDetails = ['type' => 'add','title'=>'Add New Activity','list-route'=>$listRoute];
        $this->fields['action']['value'] = route('add_hour',$id);
        $links = array('edit' => 'edit_hour', 'delete' => 'delete_hour');
        $columns = ['id' => 'ID', 'title' => 'Tital','activity_date' => 'Activity Date','time' => 'Hour','updated_at' => 'Last Updated' ];
        return view('layouts.teams.main',['columns' => $columns,'teams' => $teams,'formDetails' => $formDetails,'fields' => $this->fields,'links' => $links]);
    }
    
    public function listHours($id = 0)
    {
        $id = ($id == 0) ? Auth::id() : $id;
        $teams = Hour::where('user_id', $id)
               ->orderBy('activity_date', 'asc')               
               ->get();
        $links = array('edit' => 'edit_hour', 'delete' => 'delete_hour');
        $columns = ['id' => 'ID', 'title' => 'Tital','activity_date' => 'Activity Date','time' => 'Hour','updated_at' => 'Last Updated' ];
        return view('layouts.teams.list',['columns' => $columns,'teams' => $teams,'links' => $links]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id = 0) {
        //validate requests
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
            'activity_date' => 'required|date',
            'time' => 'required|numeric'
        ]);
        
        $team = new Hour;
        $team->title = $request->title;
        $team->content = $request->content;
        $team->activity_date = $request->activity_date;
        $team->time = $request->time;
        $team->user_id = ($id != 0) ? $id : Auth::id();
        $team->save();
        return response(['success' => 'Activity added !!!'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Hour::findOrFail($id);        
        $this->fields['title']['value'] = $team->title;
        $this->fields['content']['value'] = $team->content;
        $this->fields['activity_date']['value'] = $team->activity_date;
        $this->fields['time']['value'] = $team->time;
        $this->fields['action']['value'] = route('update_hour',$id);
        $formDetails = ['type' => 'edit','title'=>'Edit Activity'];
        return view('layouts.teams.edit',['formDetails' => $formDetails,'fields' => $this->fields]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate requests
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
            'activity_date' => 'required|date',
            'time' => 'required|numeric'
        ]);
        
        $team = Hour::find($id);
        $team->title = $request->title;
        $team->content = $request->content;
        $team->activity_date = $request->activity_date;
        $team->time = $request->time;
        $team->save();
        return response(['success' => 'Activity updated !!!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Hour::destroy($id);
        return response(['success' => 'Activity deleted !!!'], 200);
    }
}

