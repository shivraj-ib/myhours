<?php

use Illuminate\Database\Seeder;

class InstallInit extends Seeder {

    private $roles = [
            ['role_name' => 'Admin', 'active' => 1, 'role_slug' => 'admin'],
            ['role_name' => 'Manager', 'active' => 1, 'role_slug' => 'manager'],
            ['role_name' => 'Team Leader', 'active' => 1, 'role_slug' => 'team_leader'],
            ['role_name' => 'Team Member', 'active' => 1, 'role_slug' => 'team_member']
    ];
    private $permissions = [
            ['perm_name' => 'role_view', 'active' => 1, 'perm_slug' => 'role_view'],
            ['perm_name' => 'role_add', 'active' => 1, 'perm_slug' => 'role_add'],
            ['perm_name' => 'role_edit', 'active' => 1, 'perm_slug' => 'role_edit'],
            ['perm_name' => 'role_delete', 'active' => 1, 'perm_slug' => 'role_delete'],
            ['perm_name' => 'permission_view', 'active' => 1, 'perm_slug' => 'permission_view'],
            ['perm_name' => 'permission_edit', 'active' => 1, 'perm_slug' => 'permission_edit'],
            ['perm_name' => 'permission_delete', 'active' => 1, 'perm_slug' => 'permission_delete'],
            ['perm_name' => 'permission_add', 'active' => 1, 'perm_slug' => 'permission_add'],
            ['perm_name' => 'team_view', 'active' => 1, 'perm_slug' => 'team_view'],
            ['perm_name' => 'team_edit', 'active' => 1, 'perm_slug' => 'team_edit'],
            ['perm_name' => 'team_delete', 'active' => 1, 'perm_slug' => 'team_delete'],
            ['perm_name' => 'team_add', 'active' => 1, 'perm_slug' => 'team_add'],
            ['perm_name' => 'user_add', 'active' => 1, 'perm_slug' => 'user_add'],
            ['perm_name' => 'user_edit', 'active' => 1, 'perm_slug' => 'user_edit'],
            ['perm_name' => 'user_view', 'active' => 1, 'perm_slug' => 'user_view'],
            ['perm_name' => 'user_delete', 'active' => 1, 'perm_slug' => 'user_delete'],
            ['perm_name' => 'hour_view', 'active' => 1, 'perm_slug' => 'hour_view'],
            ['perm_name' => 'hour_edit', 'active' => 1, 'perm_slug' => 'hour_edit'],
            ['perm_name' => 'hour_delete', 'active' => 1, 'perm_slug' => 'hour_delete'],
            ['perm_name' => 'hour_add', 'active' => 1, 'perm_slug' => 'hour_add'],
            ['perm_name' => 'team_view_own', 'active' => 1, 'perm_slug' => 'team_view_own'],
            ['perm_name' => 'hour_view_own', 'active' => 1, 'perm_slug' => 'hour_view_own'],
            ['perm_name' => 'hour_view_team', 'active' => 1, 'perm_slug' => 'hour_view_team'],
            ['perm_name' => 'all', 'active' => 1, 'perm_slug' => 'all'],
            ['perm_name' => 'hour_add_own', 'active' => 1, 'perm_slug' => 'hour_add_own'],
            ['perm_name' => 'hour_edit_own', 'active' => 1, 'perm_slug' => 'hour_edit_own'],
            ['perm_name' => 'hour_delete_own', 'active' => 1, 'perm_slug' => 'hour_delete_own'],
            ['perm_name' => 'manage_own_profile', 'active' => 1, 'perm_slug' => 'manage_own_profile'],
            ['perm_name' => 'view_member_profile', 'active' => 1, 'perm_slug' => 'view_member_profile'],
            ['perm_name' => 'export_own_hour', 'active' => 1, 'perm_slug' => 'export_own_hour'],
            ['perm_name' => 'hour_export', 'active' => 1, 'perm_slug' => 'hour_export'],
            ['perm_name' => 'export_team_hour', 'active' => 1, 'perm_slug' => 'export_team_hour'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //insert default roles
        foreach($this->roles as $role){
            DB::table('roles')->insert($role);
        }
        
        //insert default permissions
        foreach($this->permissions as $permission){
            DB::table('permissions')->insert($permission);
        }
        
        //assign admin all the permissions
        $admin_id = DB::select('select id from roles where role_slug = ?', ['admin']);
        $permission_id = DB::select('select id from permissions where perm_slug = ?', ['all']);       

        
        DB::table('role_permission')->insert([
            'role_id' => $admin_id[0]->id,            
            'permission_id' => $permission_id[0]->id
        ]);
        
        //insert the default admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@myhours.com',
            'password' => bcrypt('admin123'),
            'role_id' => $admin_id[0]->id,
            'active' => 1
        ]);
    }

}
