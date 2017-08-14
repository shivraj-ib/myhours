<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Team as Team;

class TeamController extends Controller
{
    /**
     * public array of form fields
     * @return array
     */
    public $fields = [
        'team_name' => ['type' => 'text', 'class' => '', 'id' => 'team_name', 'lable' => 'Team Name','value'=>''],
        'active' => ['type' => 'checkbox', 'class' => '', 'id' => 'active', 'lable' => 'Activiate Now','def_value'=>1,'value'=>''],
        'action' => ['type' => 'hidden', 'class' => '', 'id' => 'action', 'lable' => '','value' => '']
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        $formDetails = ['type' => 'add','title'=>'Add New Team'];
        $this->fields['action']['value'] = route('add_team');
        $this->fields['active']['value'] = 1;
        $columns = ['id' => 'ID', 'team_name' => 'Team Name','active' => 'Status','updated_at' => 'Last Updated' ];
        return view('layouts.teams.main',['columns' => $columns,'teams' => $teams,'formDetails' => $formDetails,'fields' => $this->fields]);
    }
    
    public function listTeams()
    {
        $teams = Team::all();
        $columns = ['id' => 'ID', 'team_name' => 'Team Name','active' => 'Status','updated_at' => 'Last Updated' ];
        return view('layouts.teams.list',['columns' => $columns,'teams' => $teams]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //validate requests
        $this->validate($request, [
            'team_name' => 'required|max:255',
            'active' => 'boolean',
        ]);
        
        $team = new Team;
        $team->team_name = $request->team_name;
        $team->active = is_null($request->active) ? 0:$request->active;
        $team->save();
        return response(['success' => 'Team added !!!'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);        
        $this->fields['team_name']['value'] = $team->team_name;
        $this->fields['active']['value'] = $team->active;
        $this->fields['action']['value'] = route('update_team',$id);
        $formDetails = ['type' => 'edit','title'=>'Edit Team'];
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
            'team_name' => 'required|max:255',
            'active' => 'boolean',
        ]);
        
        $team = Team::find($id);
        $team->team_name = $request->team_name;
        $team->active = is_null($request->active) ? 0:$request->active;
        $team->save();
        return response(['success' => 'Team updated !!!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Team::destroy($id);
        return response(['success' => 'Team deleted !!!'], 200);
    }
}
