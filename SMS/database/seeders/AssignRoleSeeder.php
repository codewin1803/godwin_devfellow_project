<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignRoleSeeder extends Seeder
{
    public function run(): void
    {
        
        $admin = User::where('email', 'admin@example.com')->first();
        $teacher = User::where('email', 'teacher@example.com')->first();

        if ($admin) {
            $admin->assignRole('SuperAdmin');
        }

        if ($teacher) {
            $teacher->assignRole('Teacher');
        }
    }
}
