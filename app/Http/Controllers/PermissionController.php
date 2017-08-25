<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission as Permission;

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
        $links = array('edit' => 'edit_permission', 'delete' => 'delete_permission');
        return view('layouts.teams.main', ['columns' => $columns, 'teams' => $teams, 'formDetails' => $formDetails, 'fields' => $this->fields, 'links' => $links]);
    }

    public function listPermissions() {
        $teams = Permission::all();
        $columns = ['id' => 'ID', 'perm_name' => 'Permission Name', 'active' => 'Status', 'updated_at' => 'Last Updated'];
        $links = array('edit' => 'edit_permission', 'delete' => 'delete_permission');
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

}