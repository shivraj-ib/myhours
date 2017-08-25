<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role as Role;
use App\Permission as Permission;

class RoleController extends Controller
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
        'role_name' => ['type' => 'text', 'class' => '', 'id' => 'role_name', 'lable' => 'Role Name','value'=>''],
        'permissions' => ['type' => 'checkbox-group', 'class' => '', 'id' => 'permissions', 'lable' => 'Permissions','def_value'=>''],
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
        $teams = Role::with('permissions')->get();
        
        $permissionArray = [];
        
        $permissions = Permission::where('active', 1)
               ->orderBy('perm_name', 'asc')               
               ->get();
        foreach($permissions as $permission){
            $permissionArray[] = ['value' => $permission->id, 'lable' => $permission->perm_name];
        }
        
        
        $listRoute = route('roles-list');
        $formDetails = ['type' => 'add','title'=>'Add New Role','list-route'=>$listRoute];
        $this->fields['action']['value'] = route('add_role');
        $this->fields['active']['value'] = 1;
        $this->fields['permissions']['def_value'] = $permissionArray;
        $columns = ['id' => 'ID', 'role_name' => 'Role Name','permission' => 'Permissions','active' => 'Status','updated_at' => 'Last Updated'];
        $links = array('edit' => 'edit_role', 'delete' => 'delete_role');
        
        foreach($teams as $team){
            foreach($team->permissions as $permission){
                if(is_null($permission->perm_name)) continue;
                $team->permission .= $permission->perm_name.', ';
            }
            $team->permission = trim($team->permission,', ');
        }
        
        return view('layouts.teams.main',['columns' => $columns,'teams' => $teams,'formDetails' => $formDetails,'fields' => $this->fields ,'links' => $links]);
    }
    
    public function listRoles()
    {
        $teams = Role::with('permissions')->get();
        $columns = ['id' => 'ID', 'role_name' => 'Role Name','permission' => 'Permissions','active' => 'Status','updated_at' => 'Last Updated' ];
        $links = array('edit' => 'edit_role', 'delete' => 'delete_role');
        
        foreach($teams as $team){
            foreach($team->permissions as $permission){
                if(is_null($permission->perm_name)) continue;
                $team->permission .= $permission->perm_name.', ';
            }
            $team->permission = trim($team->permission,', ');
        }
        
        return view('layouts.teams.list',['columns' => $columns,'teams' => $teams,'links' => $links]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //dd($request->permissions);
        //validate requests
        $this->validate($request, [
            'role_name' => 'required|max:255',
            'active' => 'boolean',
        ]);
        
        $team = new Role;
        $team->role_name = $request->role_name;
        $team->active = is_null($request->active) ? 0:$request->active;
        $team->save();
        $team->permissions()->attach($request->permissions);        
        return response(['success' => 'Role added !!!'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Role::findOrFail($id);        
        $this->fields['role_name']['value'] = $team->role_name;
        $this->fields['active']['value'] = $team->active;
        $this->fields['action']['value'] = route('update_role',$id);
        $formDetails = ['type' => 'edit','title'=>'Edit Role'];
        
        $permissionArray = [];
        
        $permissions = Permission::where('active', 1)
               ->orderBy('perm_name', 'asc')               
               ->get();
        foreach($permissions as $permission){
            $permissionArray[] = ['value' => $permission->id, 'lable' => $permission->perm_name];
        }
        $this->fields['permissions']['def_value'] = $permissionArray;        
        
        foreach($team->permissions as $selected){
            $this->fields['permissions']['value'][] = $selected->id;
        }
        
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
            'role_name' => 'required|max:255',
            'active' => 'boolean',
        ]);
        
        $team = Role::find($id);
        $team->role_name = $request->role_name;
        $team->active = is_null($request->active) ? 0:$request->active;
        $team->permissions()->sync($request->permissions);
        $team->save();
        return response(['success' => 'Role updated !!!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Role::find($id);
        $team = $team->permissions()->detach();
        Role::destroy($id);
        return response(['success' => 'Role deleted !!!'], 200);
    }
}
