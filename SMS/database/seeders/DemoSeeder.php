<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\School;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create School
        $school = School::factory()->create([
            'name' => 'Axia Demo School'
        ]);

        // Create Roles if not exist
        $roles = ['SuperAdmin','SchoolAdmin','Teacher','Student','Parent','Bursar'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@demo.com',
            'password' => Hash::make('password'),
            'school_id' => $school->id
        ]);
        $superAdmin->assignRole('SuperAdmin');

        // School Admin
        $admin = User::create([
            'name' => 'School Admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'school_id' => $school->id
        ]);
        $admin->assignRole('SchoolAdmin');

        // Bulk Teachers
        User::factory(5)->create([
            'school_id' => $school->id
        ])->each(function ($user) {
            $user->assignRole('Teacher');
        });

        // Bulk Students
        User::factory(20)->create([
            'school_id' => $school->id
        ])->each(function ($user) {
            $user->assignRole('Student');
        });
    }
}
