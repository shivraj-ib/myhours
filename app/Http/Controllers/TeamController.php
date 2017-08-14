<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Team as Team;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        return view('layouts.teams.main',['teams' => $teams]);
    }
    
    public function listTeams()
    {
        $teams = Team::all();
        return view('layouts.teams.list',['teams' => $teams]);
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
        return view('layouts.teams.edit',['team' => $team]);
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
