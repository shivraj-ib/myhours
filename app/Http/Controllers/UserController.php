<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
use App\Team as Team;
use App\Role as Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    /**
     * public array of form fields
     * @return array
     */
    public $fields = [
        'name' => ['type' => 'text', 'class' => '', 'id' => 'name', 'lable' => 'Full Name', 'value' => ''],
        'email' => ['type' => 'text', 'class' => '', 'id' => 'email', 'lable' => 'Email', 'value' => ''],
        'phone' => ['type' => 'text', 'class' => '', 'id' => 'phone', 'lable' => 'Phone', 'value' => ''],
        'password' => ['type' => 'strictly-hidden', 'class' => '', 'id' => 'password', 'name' => 'password', 'lable' => 'Password', 'value' => ''],
        'password_confirmation' => ['type' => 'strictly-hidden', 'class' => '', 'id' => 'password-confirm', 'name' => 'password-confirm', 'lable' => 'Password Confirm', 'value' => ''],
        'active' => ['type' => 'checkbox', 'class' => '', 'id' => 'active', 'lable' => 'Is Active ?', 'def_value' => 1, 'value' => ''],
        /* 'thumb' => [], */
        'role_id' => ['type' => 'select', 'class' => '', 'name' => 'role_id', 'id' => 'role_id', 'lable' => 'Role'],
        'teams' => ['type' => 'checkbox-group', 'class' => '', 'name' => 'teams', 'id' => 'teams', 'lable' => 'Teams'],
        'action' => ['type' => 'hidden', 'class' => '', 'id' => 'action', 'lable' => '', 'value' => '']
    ];
    
    /**
     * public list actions
     */
    public $list_actions = [
            'edit' => ['title' => 'Edit User', 'icons' => 'fa fa-pencil-square-o' , 'class' => 'edit-item btn' , 'route_name' => 'edit-profile','active' => 1,
                'permissions' => ['all','user_edit']],
            'delete' => ['title' => 'Delete User', 'icons' => 'fa fa-trash-o' , 'class' => 'delete-item btn', 'route_name' => 'delete-user','active' => 1,
                'permissions' => ['all','user_delete']],
            'profile' => ['title' => 'View Profile', 'icons' => 'fa fa-user' ,'class' => 'btn', 'route_name' => 'profile','active' => 1,
                'permissions' => ['all','user_view','view_member_profile']],
            'hours' => ['title' => 'View Hours', 'icons' => 'fa fa-clock-o' ,'class' => 'btn', 'route_name' => 'hours','active' => 1,
                'permissions' => ['all','hour_view','hour_view_team']]
        ];
    
    /**
     * public allowed permissions to add new record
     */
    public $add_new_permissions = ['all','user_add'];


    /**
     * allow current user to add new record
     */
    public $allow_new = true;


    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role_permission');        
    }

    public function viewProfile($id) {

        $user = User::with('teams', 'role')->find($id);
        
        $user_permissions = [];
        foreach(Auth::User()->role->permissions as $permission){
            $user_permissions[] = $permission->perm_slug;           
        }
        
        $can_edit = ['edit_profile' => false,'add_profile_pic' => false, 'del_profile_pic' => false];
        
        if (in_array('all', $user_permissions) || in_array('edit_profile', $user_permissions) || (in_array('manage_own_profile', $user_permissions) && $id == Auth::User()->id)) {
            $can_edit = ['edit_profile' => true, 'add_profile_pic' => true, 'del_profile_pic' => true];
        }

        return view('auth.profile', ['user' => $user,'can_edit' => $can_edit]);
    }

    public function edit($id) {
        $formDetails = ['type' => 'edit', 'title' => 'Edit Profile'];

        $user = User::with('teams', 'role')->find($id);

        $this->fields['name']['value'] = $user->name;
        $this->fields['email']['value'] = $user->email;
        $this->fields['phone']['value'] = $user->phone;
        $this->fields['active']['value'] = $user->active;
        $this->fields['name']['value'] = $user->name;
        $this->fields['action']['value'] = route('update-profile', $id);


        $teamOptions = [];
        $roleOptions = [];
        $teamsSelected = [];

        $teams = Team::where('active', 1)
                ->orderBy('team_name', 'asc')
                ->get();

        $roles = Role::where('active', 1)
                ->orderBy('role_name', 'asc')
                ->get();

        foreach ($teams as $team) {
            $teamOptions[] = ['value' => $team->id, 'lable' => $team->team_name];
        }

        foreach ($roles as $role) {
            $roleOptions[] = ['value' => $role->id, 'lable' => $role->role_name];
        }

        foreach ($user->teams as $team) {
            $teamsSelected[] = $team->id;
        }

        $this->fields['teams']['def_value'] = $teamOptions;
        $this->fields['role_id']['def_value'] = $roleOptions;

        $this->fields['teams']['value'] = $teamsSelected;
        $this->fields['role_id']['value'] = $user->role_id;

        //only admin can set these options other wise disabled
        if (Auth::user()->role->role_slug != 'admin') {
            $this->fields['active']['disabled'] = true;
            $this->fields['teams']['disabled'] = true;
            $this->fields['role_id']['disabled'] = true;
        }

        return view('layouts.teams.edit', ['user' => $user, 'formDetails' => $formDetails, 'fields' => $this->fields]);
    }

    public function update(Request $request, $id) {
        //validate requests
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|digits:10',
            'active' => 'boolean',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        //only admin can set these options
        if (Auth::user()->role->role_slug == 'admin') {
            $user->active = $request->active;
            $user->role()->associate($request->role_id);
            $user->teams()->sync($request->teams);
        }

        $user->save();
        return response(['success' => 'Profile updated !!!'], 200);
    }

    public function index() {
        //get all users under team lead id
        $user_role = Auth::user()->role->role_slug;
        if ($user_role == 'team_leader' || $user_role == 'manager') {
            $lead_teams = [];
            foreach (Auth::user()->teams as $team) {
                $lead_teams[] = $team->id;
            }
            $users = User::with(['role', 'teams'])->whereHas('teams', function($query) use ($lead_teams) {
                        $query->whereIn('team_id', $lead_teams);
                    })->where('id', '!=', Auth::user()->id)->get();
        } else {
            $users = User::with('role', 'teams')->get();
        }

        $listRoute = route('users-list');
        $formDetails = ['type' => 'add', 'title' => 'Add New User', 'list-route' => $listRoute];
        $this->fields['action']['value'] = route('add-user');
        $this->fields['active']['value'] = 1;

        $teams = Team::where('active', 1)
                ->orderBy('team_name', 'asc')
                ->get();

        $roles = Role::where('active', 1)
                ->orderBy('role_name', 'asc')
                ->get();

        $teamOptions = [];
        foreach ($teams as $team) {
            $teamOptions[] = ['value' => $team->id, 'lable' => $team->team_name];
        }

        foreach ($roles as $role) {
            $roleOptions[] = ['value' => $role->id, 'lable' => $role->role_name];
        }

        $this->fields['teams']['def_value'] = $teamOptions;
        $this->fields['role_id']['def_value'] = $roleOptions;

        $this->fields['password']['type'] = 'password';
        $this->fields['password_confirmation']['type'] = 'password';

        $columns = ['id' => 'ID', 'name' => 'Name', 'email' => 'Email', 'active' => 'Status','role' => 'Role', 'team' => 'Team'];
        $links = $this->getActionLinks();

        foreach ($users as $user) {
            foreach ($user->teams as $team) {
                if (is_null($team->team_name))
                    continue;
                $user->team .= $team->team_name . ', ';
            }
            $user->team = trim($user->team, ', ');
        }
        foreach ($users as $user) {         
            
                $user->role = $user->role->role_name;               

        }
        $this->getActionLinks();
        return view('layouts.teams.main', ['add_new' => $this->allow_new,'columns' => $columns,'test' => $this->list_actions ,'teams' => $users, 'formDetails' => $formDetails, 'fields' => $this->fields, 'links' => $links]);
    }

    public function listUsers() {
        $columns = ['id' => 'ID', 'name' => 'Name', 'email' => 'Email', 'active' => 'Status', 'team' => 'Team'];
        $links = $this->getActionLinks();

        //get all users under team lead id
        $user_role = Auth::user()->role->role_slug;
        if ($user_role == 'team_leader' || $user_role == 'manager') {
            $lead_teams = [];
            foreach (Auth::user()->teams as $team) {
                $lead_teams[] = $team->id;
            }
            $users = User::with(['role', 'teams'])->whereHas('teams', function($query) use ($lead_teams) {
                        $query->whereIn('team_id', $lead_teams);
                    })->where('id', '!=', Auth::user()->id)->get();
        } else {
            $users = User::with('role', 'teams')->get();
        }

        foreach ($users as $user) {
            foreach ($user->teams as $team) {
                if (is_null($team->team_name))
                    continue;
                $user->team .= $team->team_name . ', ';
            }
            $user->team = trim($user->team, ', ');
        }

        return view('layouts.teams.list', ['columns' => $columns, 'teams' => $users, 'links' => $links]);
    }

    public function addUsers(Request $request) {
        //validate requests
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'phone' => 'nullable|digits:10',
            'active' => 'boolean',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->active = is_null($request->active) ? 0 : $request->active;
        
        if (!is_null($request->role_id)) {
            $user->role_id = $request->role_id;
        }

        if (Hash::needsRehash($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        
        if (!is_null($request->teams)) {
            $user->teams()->sync($request->teams);
        }

        return response(['success' => 'User Added !!!'], 200);
    }

    public function delete($id) {
        $user = User::find($id);
        $user->teams()->detach();
        if (!is_null($user->thumb)) {
            Storage::delete('public' + $user->thumb);
        }
        User::destroy($id);
        return response(['success' => 'User deleted !!!'], 200);
    }

    public function addProfilePic(Request $request, $id) {
        //validate requests
        $this->validate($request, [
            'thumb' => 'required|image|max:2000',
        ]);


        $user = User::find($id);
        if (!is_null($user->thumb)) {
            Storage::delete('public' + $user->thumb);
        }
        $path = $request->file('thumb')->store('public/profile_pic');
        $user->thumb = trim($path, 'public');
        $user->save();
        return response(['success' => 'Image Uploaded !!!'], 200);
    }

    public function delProfilePic($id) {
        $user = User::find($id);
        if (!is_null($user->thumb)) {
            Storage::delete('public' + $user->thumb);
        }
        $user->thumb = null;
        $user->save();
        return response(['success' => 'Image Removed !!!'], 200);
    }

    public function getProfileDetails($id) {
        $user = User::find($id);        
        
        foreach($user->role->permissions as $permission){
            $user_permissions[] = $permission->perm_slug;           
        }
        
        $can_edit = ['edit_profile' => false,'add_profile_pic' => false, 'del_profile_pic' => false];
        
        if (in_array('all', $user_permissions) || in_array('edit_profile', $user_permissions) || (in_array('manage_own_profile', $user_permissions) && $id == Auth::User()->id)) {
            $can_edit = ['edit_profile' => true, 'add_profile_pic' => true, 'del_profile_pic' => true];
        }
        
        return view('auth.profile-details', ['user' => $user,'can_edit' => $can_edit]);
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
