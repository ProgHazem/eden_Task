<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Http\Enums\UserRoles;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoles();
        $this->createUsers();
    }

    private function createRoles()
    {
        $manager = Role::findOrCreate(UserRoles::ROLE_MANGER);
        $regular = Role::findOrCreate(UserRoles::ROLE_REGULAR);
        $create_job = Permission::findOrCreate("create job");
        $update_job = Permission::findOrCreate("update job");
        $show_jobs = Permission::findOrCreate("show all jobs");
        $manager->givePermissionTo($show_jobs);
        $regular->givePermissionTo($create_job);
        $regular->givePermissionTo($update_job);
    }

    private function createUsers()
    {
        $this->createManagerUser();
        $this->createRegularUser();
    }

    private function createManagerUser()
    {
        $user = User::create([
            'name' => 'Manager',
            'email' => 'manager@eden.com',
            'email_verified_at' => now(),
            'password' => Hash::make("123456"),
        ]);
        $user->assignRole(UserRoles::ROLE_MANGER);
    }

    private function createRegularUser()
    {
        $user = User::create([
            'name' => 'Hazem',
            'email' => 'hazem@eden.com',
            'email_verified_at' => now(),
            'password' => Hash::make("123456"),
        ]);
        $user->assignRole(UserRoles::ROLE_REGULAR);
    }
}
