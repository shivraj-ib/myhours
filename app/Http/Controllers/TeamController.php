<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Team as Team;

class TeamController extends Controller
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
        'team_name' => ['type' => 'text', 'class' => '', 'id' => 'team_name', 'lable' => 'Team Name','value'=>''],
        'active' => ['type' => 'checkbox', 'class' => '', 'id' => 'active', 'lable' => 'Activiate Now','def_value'=>1,'value'=>''],
        'action' => ['type' => 'hidden', 'class' => '', 'id' => 'action', 'lable' => '','value' => '']
    ];
    
    
    /**
     * public list actions
     */
    public $list_actions = [
            'edit' => ['title' => 'Edit Team', 'icons' => 'fa fa-pencil-square-o' , 'class' => 'edit-item btn' , 'route_name' => 'edit_team','active' => 1,
                'permissions' => ['all','team_edit']],
            'delete' => ['title' => 'Delete Team', 'icons' => 'fa fa-trash-o' , 'class' => 'delete-item btn', 'route_name' => 'delete_team','active' => 1,
                'permissions' => ['all','team_delete']]            
        ];
    
    /**
     * public allowed permissions to add new record
     */
    public $add_new_permissions = ['all','team_add'];
    
    /**
     * allow current user to add new record
     */
    public $allow_new = true;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        $listRoute = route('teams-list');       
        $formDetails = ['type' => 'add','title'=>'Add New Team','list-route'=>$listRoute];
        $this->fields['action']['value'] = route('add_team');
        $this->fields['active']['value'] = 1;
        $links = $this->getActionLinks();
        $columns = ['id' => 'ID', 'team_name' => 'Team Name','active' => 'Status','updated_at' => 'Last Updated' ];
        return view('layouts.teams.main',['add_new' => $this->allow_new,'columns' => $columns,'teams' => $teams,'formDetails' => $formDetails,'fields' => $this->fields,'links' => $links]);
    }
    
    public function listTeams()
    {
        $teams = Team::all();
        $links = $this->getActionLinks();
        $columns = ['id' => 'ID', 'team_name' => 'Team Name','active' => 'Status','updated_at' => 'Last Updated' ];
        return view('layouts.teams.list',['columns' => $columns,'teams' => $teams,'links' => $links]);
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
    
    private function getActionLinks(){
        $user_permissions = [];
        foreach(Auth::User()->role->permissions as $permission){
            $user_permissions[] = $permission->perm_slug;           
        }
        
        //check if add new record allowed
        $add_permissions = array_intersect($this->add_new_permissions,$user_permissions);        
        if(empty($add_permissions)){
            $this->allow_new = false;
        }
        
        //check for action buttons permission on list page
        foreach($this->list_actions as $key => $action){
            $result=array_intersect($action['permissions'],$user_permissions);            
            if(empty($result)){
               $this->list_actions[$key]['active'] = 0;
            }
        }
        return $this->list_actions;
    }
}
