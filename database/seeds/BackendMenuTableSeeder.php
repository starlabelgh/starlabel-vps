<?php

use App\Models\BackendMenu;
use Illuminate\Database\Seeder;

class BackendMenuTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $parent = [
            'report'         => 9,
            'administrators' => 13,
        ];

        $menus = [
            [
                'name'      => 'dashboard',
                'link'      => 'dashboard',
                'icon'      => 'fas fa-laptop',
                'parent_id' => 0,
                'priority'  => 9000,
                'status'    => 1,
            ],
            [
                'name'      => 'profile',
                'link'      => 'profile',
                'icon'      => 'far fa-user',
                'parent_id' => 0,
                'priority'  => 8900,
                'status'    => 1,
            ],
            [
                'name'      => 'departments',
                'link'      => 'departments',
                'icon'      => 'fas fa-building',
                'parent_id' => 0,
                'priority'  => 8800,
                'status'    => 1,
            ],
            [
                'name'      => 'designations',
                'link'      => 'designations',
                'icon'      => 'fas fa-layer-group',
                'parent_id' => 0,
                'priority'  => 8700,
                'status'    => 1,
            ],
            [
                'name'      => 'employees',
                'link'      => 'employees',
                'icon'      => 'fas fa-user-secret',
                'parent_id' => 0,
                'priority'  => 8600,
                'status'    => 1,
            ],
            [
                'name'      => 'visitors',
                'link'      => 'visitors',
                'icon'      => 'fas fa-walking',
                'parent_id' => 0,
                'priority'  => 8600,
                'status'    => 1,
            ],
            [
                'name'      => 'pre_registers',
                'link'      => 'pre-registers',
                'icon'      => 'fas fa-user-friends',
                'parent_id' => 0,
                'priority'  => 8600,
                'status'    => 1,
            ],
            [
                'name'      => 'attendance',
                'link'      => 'attendance',
                'icon'      => 'fas fa-clock',
                'parent_id' => 0,
                'priority'  => 8600,
                'status'    => 1,
            ],
            [
                'name'      => 'report',
                'link'      => '#',
                'icon'      => 'fas fa-archive',
                'parent_id' => 0,
                'priority'  => 8500,
                'status'    => 1,
            ],
            [
                'name'      => 'visitor_report',
                'link'      => 'admin-visitor-report',
                'icon'      => 'fas fa-list-alt',
                'parent_id' => $parent['report'],
                'priority'  => 74,
                'status'    => 1,
            ],
            [
                'name'      => 'pre_registers_report',
                'link'      => 'admin-pre-registers-report',
                'icon'      => 'fas fa-list-alt',
                'parent_id' => $parent['report'],
                'priority'  => 74,
                'status'    => 1,
            ],
            [
                'name'      => 'attendance_report',
                'link'      => 'attendance-report',
                'icon'      => 'fas fa-clock',
                'parent_id' => $parent['report'],
                'priority'  => 74,
                'status'    => 1,
            ],
            [
                'name'      => 'administrators',
                'link'      => '#',
                'icon'      => 'fas fa-id-card ',
                'parent_id' => 0,
                'priority'  => 81,
                'status'    => 1,
            ],
            [
                'name'      => 'users',
                'link'      => 'adminusers',
                'icon'      => 'fas fa-users',
                'parent_id' => $parent['administrators'],
                'priority'  => 8400,
                'status'    => 1,
            ],
            [
                'name'      => 'role',
                'link'      => 'role',
                'icon'      => 'fa fa-star',
                'parent_id' => $parent['administrators'],
                'priority'  => 2400,
                'status'    => 1,
            ],
            [
                'name'      => 'language',
                'link'      => 'language',
                'icon'      => 'fas fa-globe',
                'parent_id' => 0,
                'priority'  => 9000,
                'status'    => 1,
            ],
            [
                'name'      => 'settings',
                'link'      => 'setting',
                'icon'      => 'fas fa-cogs',
                'parent_id' => 0,
                'priority'  => 2400,
                'status'    => 1,
            ],
          
            [
                'name'      => 'addons',
                'link'      => 'addons',
                'icon'      => 'fa fa-crosshairs',
                'parent_id' => $parent['administrators'],
                'priority'  => 3000,
                'status'    => 1,
            ]

        ];

        BackendMenu::insert($menus);
    }
}
