<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission as Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller {
    
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
        'perm_name' => ['type' => 'text', 'class' => '', 'id' => 'perm_name', 'lable' => 'Permission Name', 'value' => ''],
        'active' => ['type' => 'checkbox', 'class' => '', 'id' => 'active', 'lable' => 'Activiate Now', 'def_value' => 1, 'value' => ''],
        'action' => ['type' => 'hidden', 'class' => '', 'id' => 'action', 'lable' => '', 'value' => '']
    ];
    
    /**
     * public list actions
     */
    public $list_actions = [
            'edit' => ['title' => 'Edit Permission', 'icons' => 'fa fa-pencil-square-o' , 'class' => 'edit-item btn' , 'route_name' => 'edit_permission','active' => 1,
                'permissions' => ['all','permission_edit']],
            'delete' => ['title' => 'Delete Permission', 'icons' => 'fa fa-trash-o' , 'class' => 'delete-item btn', 'route_name' => 'delete_permission','active' => 1,
                'permissions' => ['all','permission_delete']]            
        ];
    
    /**
     * public allowed permissions to add new record
     */
    public $add_new_permissions = ['all','permission_add'];
    
    /**
     * allow current user to add new record
     */
    public $allow_new = true;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $teams = Permission::all();
        $listRoute = route('permission-list');
        $formDetails = ['type' => 'add', 'title' => 'Add New Permission', 'list-route' => $listRoute];
        $this->fields['action']['value'] = route('add_permission');
        $this->fields['active']['value'] = 1;
        $columns = ['id' => 'ID', 'perm_name' => 'Permission Name', 'active' => 'Status', 'updated_at' => 'Last Updated'];
        $links = $this->getActionLinks();
        return view('layouts.teams.main', ['add_new' => $this->allow_new,'columns' => $columns, 'teams' => $teams, 'formDetails' => $formDetails, 'fields' => $this->fields, 'links' => $links]);
    }

    public function listPermissions() {
        $teams = Permission::all();
        $columns = ['id' => 'ID', 'perm_name' => 'Permission Name', 'active' => 'Status', 'updated_at' => 'Last Updated'];
        $links = $this->getActionLinks();
        return view('layouts.teams.list', ['columns' => $columns, 'teams' => $teams, 'links' => $links]);
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
            'perm_name' => 'required|unique:permissions|max:255',
            'active' => 'boolean',
        ]);

        $team = new Permission;
        $team->perm_name = $request->perm_name;
        $team->active = is_null($request->active) ? 0 : $request->active;
        $team->save();
        return response(['success' => 'Permission added !!!'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $team = Permission::findOrFail($id);
        $this->fields['perm_name']['value'] = $team->perm_name;
        $this->fields['active']['value'] = $team->active;
        $this->fields['action']['value'] = route('update_permission', $id);
        $formDetails = ['type' => 'edit', 'title' => 'Edit Permission'];
        return view('layouts.teams.edit', ['formDetails' => $formDetails, 'fields' => $this->fields]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //validate requests
        $this->validate($request, [
            'perm_name' => 'required|unique:permissions,perm_name,'.$id.'|max:255',
            'active' => 'boolean',
        ]);

        $team = Permission::find($id);
        $team->perm_name = $request->perm_name;
        $team->active = is_null($request->active) ? 0 : $request->active;
        $team->save();
        return response(['success' => 'Permission updated !!!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $team = Permission::find($id);
        $team = $team->roles()->detach();
        Permission::destroy($id);        
        return response(['success' => 'Permisson deleted !!!'], 200);
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