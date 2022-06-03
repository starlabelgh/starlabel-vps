<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::find(1);
        if (!blank($role)) {
            $role->givePermissionTo(Permission::all());
        }

        $employeePermission[]['name'] = 'dashboard';
        $employeePermission[]['name'] = 'profile';
        $employeePermission[]['name'] = 'visitors';
        $employeePermission[]['name'] = 'visitors_show';
        $employeePermission[]['name'] = 'pre-registers';
        $employeePermission[]['name'] = 'pre-registers_create';
        $employeePermission[]['name'] = 'pre-registers_edit';
        $employeePermission[]['name'] = 'pre-registers_delete';
        $employeePermission[]['name'] = 'pre-registers_show';

        $permissions = Permission::whereIn('name', $employeePermission)->get();

        $role = Role::find(2);
        $role->givePermissionTo($permissions);


        $receptionPermission[]['name'] = 'dashboard';
        $receptionPermission[]['name'] = 'profile';
        $receptionPermission[]['name'] = 'employees';
        $receptionPermission[]['name'] = 'employees_show';
        $receptionPermission[]['name'] = 'visitors';
        $receptionPermission[]['name'] = 'visitors_create';
        $receptionPermission[]['name'] = 'visitors_edit';
        $receptionPermission[]['name'] = 'visitors_show';
        $receptionPermission[]['name'] = 'pre-registers';
        $receptionPermission[]['name'] = 'pre-registers_create';
        $receptionPermission[]['name'] = 'pre-registers_edit';
        $receptionPermission[]['name'] = 'pre-registers_show';

        $receptionPermissions = Permission::whereIn('name', $receptionPermission)->get();

        $role = Role::find(3);
        if (!blank($role)) {
            $role->givePermissionTo($receptionPermissions);
        }
    }
}
