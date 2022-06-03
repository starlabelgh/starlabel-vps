<?php

use App\Models\Employee;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name'     => 'Alexandra',
            'last_name'      => 'Doe',
            'username'       => 'employee',
            'email'          => 'employee@example.com',
            'phone'          => '+15005550007',
            'address'        => 'Dhaka, Bangladesh',
            'password'       => bcrypt('123456'),
            'remember_token' => Str::random(10),
        ]);
        $role = Role::find(2);
        $user->assignRole($role->name);
        Employee::create([
            'first_name'        => 'Alexandra',
            'last_name'         => 'Doe',
            'user_id'           => 3,
            'phone'             => '+15005550007',
            'gender'            => 5,
            'department_id'     => 1,
            'designation_id'    => 1,
            'date_of_joining'   => '2020-01-12',
            'about'             =>  '',
            'status'            => 5,
            'creator_type'    => 'App\User',
            'creator_id'      => 1,
            'editor_type'     => 'App\User',
            'editor_id'       => 1,
        ]);
    }
}
