<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Hour as Hour;
use App\User as User;
use Illuminate\Support\Facades\Redirect;

class HourController extends Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role_permission');
    }

    /**
     * public array of form fields
     * @return array
     */
    public $fields = [
        'title' => ['type' => 'text', 'class' => '', 'id' => 'title', 'lable' => 'Title', 'value' => ''],
        'content' => ['type' => 'text-area', 'class' => 'form-control', 'id' => 'content', 'lable' => 'Description', 'value' => ''],
        'time' => ['type' => 'text', 'class' => '', 'id' => 'time', 'lable' => 'Hours (eq. 30 minute = 0.5 hour)', 'value' => ''],
        'activity_date' => ['type' => 'text', 'class' => 'datepicker', 'id' => '', 'lable' => 'Activity Date', 'value' => ''],
        'action' => ['type' => 'hidden', 'class' => '', 'id' => 'action', 'lable' => '', 'value' => '']
    ];

    /**
     * public list actions
     */
    public $list_actions = [
        'edit' => ['title' => 'Edit Hour', 'icons' => 'fa fa-pencil-square-o', 'class' => 'edit-item btn', 'route_name' => 'edit_hour', 'active' => 1,
            'permissions' => ['all', 'hour_edit_own', 'hour_edit']],
        'delete' => ['title' => 'Delete Hour', 'icons' => 'fa fa-trash-o', 'class' => 'delete-item btn', 'route_name' => 'delete_hour', 'active' => 1,
            'permissions' => ['all', 'hour_delete_own', 'hour_delete']]
    ];

    /**
     * public allowed permissions to add new record
     */
    public $add_new_permissions = ['all', 'hour_add', 'hour_add_own'];

    /**
     * allow current user to add new record
     */
    public $allow_new = true;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $teams = Hour::where('user_id', $id)
                ->orderBy('activity_date', 'asc')
                ->get();
        $listRoute = route('hours-list', $id);
        $formDetails = ['type' => 'add', 'title' => 'Add New Activity', 'list-route' => $listRoute];
        $this->fields['action']['value'] = route('add_hour', $id);
        $links = $this->getActionLinks($id);
        $columns = ['id' => 'ID', 'title' => 'Tital', 'activity_date' => 'Activity Date', 'time' => 'Hour','content' => 'Description'];
        return view('layouts.teams.main', ['add_new' => $this->allow_new, 'columns' => $columns, 'teams' => $teams, 'formDetails' => $formDetails, 'fields' => $this->fields, 'links' => $links, 'user_id' => $id]);
    }

    public function listHours($id = 0) {
        $id = ($id == 0) ? Auth::id() : $id;
        $teams = Hour::where('user_id', $id)
                ->orderBy('activity_date', 'asc')
                ->get();
        $links = $this->getActionLinks($id);
        $columns = ['id' => 'ID', 'title' => 'Tital', 'activity_date' => 'Activity Date', 'time' => 'Hour','content' => 'Description'];
        return view('layouts.teams.list', ['columns' => $columns, 'teams' => $teams, 'links' => $links, 'user_id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = 0) {
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
    public function edit($id) {
        $team = Hour::findOrFail($id);
        $this->fields['title']['value'] = $team->title;
        $this->fields['content']['value'] = $team->content;
        $this->fields['activity_date']['value'] = $team->activity_date;
        $this->fields['time']['value'] = $team->time;
        $this->fields['action']['value'] = route('update_hour', $id);
        $formDetails = ['type' => 'edit', 'title' => 'Edit Activity'];
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
    public function destroy($id) {
        Hour::destroy($id);
        return response(['success' => 'Activity deleted !!!'], 200);
    }

    private function getActionLinks($id) {
        $user_permissions = [];
        foreach (Auth::User()->role->permissions as $permission) {
            $user_permissions[] = $permission->perm_slug;
        }

        
        $add_permissions = array_intersect($this->add_new_permissions, $user_permissions);
        if (empty($add_permissions)) {        
            $this->allow_new = false;
        }else{
            //check if user can add hours for team member
            if($id != Auth::id() && count(array_intersect(['all','hour_add'], $user_permissions)) == 0){
                $this->allow_new = false;
            }
        }

        //check for action buttons permission on list page
        foreach ($this->list_actions as $key => $action) {
            $result = array_intersect($action['permissions'], $user_permissions);
            if (empty($result)) {
                $this->list_actions[$key]['active'] = 0;
            }else{
                //check if user can manage team members hours
                if($key == 'edit' && ($id != Auth::id() && count(array_intersect(['all','hour_edit'], $user_permissions)) == 0)){
                    $this->list_actions[$key]['active'] = 0;
                }
                if($key == 'delete' && ($id != Auth::id() && count(array_intersect(['all','hour_delete'], $user_permissions)) == 0)){
                    $this->list_actions[$key]['active'] = 0;
                }
            }
        }
        return $this->list_actions;
    }

    /*
     * public function export user hours details
     */

    public function exportData(Request $request, $id) {
        //validate requests
        $this->validate($request, [
            'date_from' => 'required|date',
            'date_to' => 'required|date'
        ]);
        
        $request->date_from = date("Y-m-d", strtotime($request->date_from));
        $request->date_to = date("Y-m-d", strtotime($request->date_to));
        
        $hours = Hour::where('user_id', $id)
                ->whereDate('activity_date', '>=', $request->date_from)
                ->whereDate('activity_date', '<=', $request->date_to)
                ->orderBy('activity_date')
                ->get();
        
        $user_details = User::find($id);

        if (!$hours->isEmpty()) {
            
            $total_hours = Hour::where('user_id', $id)
                ->whereDate('activity_date', '>=', $request->date_from)
                ->whereDate('activity_date', '<=', $request->date_to)
                ->sum('time');
            
            $total_hours = number_format($total_hours, 2, '.', '');
            
            $teams = '';
            foreach ($user_details->teams as $team) {
                if (is_null($team->team_name))
                    continue;
                $teams .= $team->team_name . ', ';
            }
            $teams = trim($teams, ', ');

            $headers = [
                    ['','','Name', $user_details->name],
                    ['','','Email', $user_details->email],
                    ['','','Team', $teams],
                    ['','','Duration', $request->date_from . ' to ' . $request->date_to],
                    ['','','Total Hours', $total_hours]
            ];

            $fp = fopen('php://output', 'w');

            if ($fp) {
                foreach ($headers as $header) {
                    fputcsv($fp, $header);
                }
                fputcsv($fp, ['ID','Title','Activity Date','Description','Hours Logged']);
                foreach ($hours as $hour) {
                    fputcsv($fp, [$hour->id,$hour->title,$hour->activity_date,$hour->content,$hour->time]);
                }
                
                $file_name = empty($user_details->name) ? $user_details->id : $user_details->name;
                
                $file_name .= '_hours.csv';
                
                $file_name = str_replace(" ","_",$file_name);
                
                return response('')->header('Content-Type', 'text/csv')
                                ->header('Content-Disposition', 'attachment; filename='.$file_name)
                                ->header('Pragma', 'no-cache')
                                ->header('Expires', 0);
            }         
        }

        return Redirect::back()->withErrors(['msg' => 'No record found, Please select another date !!!']);
    }

}
