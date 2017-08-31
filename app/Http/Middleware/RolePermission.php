<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use App\User as User;
use App\Team as Team;
use App\Hour as Hour;

class RolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_permissions = [];
        foreach(Auth::User()->role->permissions as $permission){
            $user_permissions[] = $permission->perm_slug;           
        }
        
        if($this->hasPermission($request->route()->getName(), $user_permissions,Auth::User()->id,$request->route()->parameter('id'))){             
            return $next($request);
        }
        if($request->ajax()){
        return response(['error' => 'Permission deniend !!!'], 200);
        }
        return response(['error' => 'Permission deniend !!!'], 200);
    }

    /**
     * Check user permission against requested route
     * @param type $route_name
     * @param type $user_permissions
     * @return bool
     */
    public function hasPermission($route_name, $user_permissions,$user_id,$record_id = 0) {
        if (in_array('all', $user_permissions)) {
            return true;
        }

        switch ($route_name) {
            case 'profile':
                if((in_array('manage_own_profile', $user_permissions) && $user_id == $record_id) || 
                    in_array('user_view', $user_permissions) || 
                    (in_array('view_member_profile', $user_permissions) && $this->isMyTeamMember($record_id)))
                return true;        
                break;
            case 'edit-profile':
                if((in_array('manage_own_profile', $user_permissions) && $user_id == $record_id) || in_array('user_edit', $user_permissions))
                return true;        
                break;
            case 'delete-user':
                if((in_array('manage_own_profile', $user_permissions) && $user_id == $record_id) || in_array('user_delete', $user_permissions))
                break;
            case 'update-profile':
                if((in_array('manage_own_profile', $user_permissions) && $user_id == $record_id) || in_array('user_edit', $user_permissions))
                return true;
                break;
            case 'users':
                if(in_array('user_view', $user_permissions) || in_array('team_view_own', $user_permissions))
                return true;
                break;
            case 'users-list':
                if(in_array('user_view', $user_permissions) || in_array('team_view_own', $user_permissions))
                return true;        
                break;
            case 'add-user':
                if(in_array('user_add', $user_permissions))
                return true;        
                break;
            case 'add-profile-pic':
                if((in_array('manage_own_profile', $user_permissions) && $user_id == $record_id) || in_array('user_edit', $user_permissions))
                return true;        
                break;
            case 'del-profile-pic':
                if((in_array('manage_own_profile', $user_permissions) && $user_id == $record_id) || in_array('user_edit', $user_permissions))
                return true;
                break;
            case 'profile-details':
                if((in_array('manage_own_profile', $user_permissions) && $user_id == $record_id) 
                        || in_array('user_view', $user_permissions) 
                        || (in_array('view_member_profile', $user_permissions) && $this->isMyTeamMember($record_id)))
                return true;
                break;
            case 'hours':
                if((in_array('hour_view_own', $user_permissions) && $user_id == $record_id) ||
                   (in_array('hour_view', $user_permissions)) ||
                   (in_array('hour_view_team', $user_permissions) && $this->isMyTeamMember($record_id))     
                  )
                return true;        
                break;
            case 'hours-list':
                if((in_array('hour_view_own', $user_permissions) && $user_id == $record_id) ||
                   (in_array('hour_view', $user_permissions)) ||
                   (in_array('hour_view_team', $user_permissions) && $this->isMyTeamMember($record_id))     
                  )
                return true;
                break;
            case 'add_hour':
                if((in_array('hour_add', $user_permissions)) ||
                   (in_array('hour_add_own', $user_permissions) && $user_id == $record_id)
                   )
                return true;        
                break;
            case 'delete_hour':
                if((in_array('hour_delete', $user_permissions)) ||
                   (in_array('hour_delete_own', $user_permissions) && $this->isMyHour($record_id))
                   )
                return true;                
                break;
            case 'edit_hour':
                if((in_array('hour_edit', $user_permissions)) ||
                   (in_array('hour_edit_own', $user_permissions) && $this->isMyHour($record_id))
                   )
                return true;
                break;
            case 'update_hour':
                if((in_array('hour_edit', $user_permissions)) ||
                   (in_array('hour_edit_own', $user_permissions) && $this->isMyHour($record_id))
                   )
                return true;        
                break;
            case 'teams':
                if(in_array('team_view', $user_permissions))
                return true;
                break;
            case 'teams-list':
                if(in_array('team_view', $user_permissions))
                return true;
                break;
            case 'add_team':
                if(in_array('team_add', $user_permissions))
                return true;
                break;
            case 'delete_team':
                if(in_array('team_delete', $user_permissions))
                return true;
                break;            
            case 'edit_team':
                if(in_array('team_edit', $user_permissions))
                return true;
                break;
            case 'update_team':
                if(in_array('team_edit', $user_permissions))
                return true;
                break;
            case 'roles':
                if(in_array('role_view', $user_permissions))
                return true;
                break;
            case 'roles-list':
                if(in_array('role_view', $user_permissions))
                return true;
                break;
            case 'add_role':
                if(in_array('role_add', $user_permissions))
                return true;
                break;
            case 'delete_role':
                if(in_array('role_delete', $user_permissions))
                return true;
                break;
            case 'edit_role':
                if(in_array('role_edit', $user_permissions))
                return true;
                break;
            case 'update_role':
                if(in_array('role_edit', $user_permissions))
                return true;
                break;
            case 'permissions':
                if(in_array('permission_view', $user_permissions))
                return true;
                break;
            case 'permission-list':
                if(in_array('permission_view', $user_permissions))
                return true;
                break;
            case 'add_permission':
                if(in_array('permission_add', $user_permissions))
                return true;
                break;
            case 'delete_permission':
                if(in_array('permission_delete', $user_permissions))
                return true;
                break;
            case 'edit_permission':
                if(in_array('permission_edit', $user_permissions))
                return true;
                break;
            case 'update_permission':
                if(in_array('permission_edit', $user_permissions))
                return true;
                break;
            case 'export_hour':
                if((in_array('export_own_hour', $user_permissions) && $user_id == $record_id) ||
                   (in_array('hour_export', $user_permissions)) ||
                   (in_array('export_team_hour', $user_permissions) && $this->isMyTeamMember($record_id))
                )
                return true;
                break;
            default:
                return false;
                break;
        }

        return false;
    }
    
    public function isMyTeamMember($user_id) {
        $lead_teams = [];
        foreach (Auth::user()->teams as $team) {
            $lead_teams[] = $team->id;
        }
        $user = User::with(['teams'])->whereHas('teams', function($query) use ($lead_teams) {
                    $query->whereIn('team_id', $lead_teams);
                })->where('id', '=', $user_id)->get();
        
        if(count($user) > 0) return true;
                
        return false;
    }
    
    public function isMyHour($record_id){
        $count = Hour::where('id',$record_id)->where('user_id',Auth::id())->count();
        return ($count > 0) ? true:false;
    }
}
