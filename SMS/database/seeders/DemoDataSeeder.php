<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\School;
use App\Models\ClassLevel;
use App\Models\Section;
use App\Models\Subject;
use App\Models\TeacherProfile;
use App\Models\StudentProfile;
use App\Models\ParentProfile;
use App\Models\ClassroomAssignment;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // create a school (if none)
        $school = School::first() ?? School::create([
            'name'=>'Demo School',
            'address'=>'Demo Address',
            'email'=>'demo@school.test',
            'phone'=>'000',
        ]);

        // create a SchoolAdmin user if none
        $admin = User::where('email','admin@demo.test')->first();
        if (!$admin) {
            $admin = User::create([
                'name'=>'Demo Admin',
                'email'=>'admin@demo.test',
                'password'=>bcrypt('password'),
                'school_id'=>$school->id,
            ]);
            if (method_exists($admin,'assignRole')) $admin->assignRole('SchoolAdmin');
        }

        // class levels
        $cl1 = ClassLevel::firstOrCreate(['name'=>'Primary 1','school_id'=>$school->id]);
        $cl2 = ClassLevel::firstOrCreate(['name'=>'Primary 2','school_id'=>$school->id]);

        // sections
        $sA = Section::firstOrCreate(['name'=>'A','class_level_id'=>$cl1->id, 'school_id'=>$school->id]);
        $sB = Section::firstOrCreate(['name'=>'B','class_level_id'=>$cl2->id, 'school_id'=>$school->id]);

        // subjects
        $math = Subject::firstOrCreate(['name'=>'Mathematics','code'=>'MATH','school_id'=>$school->id]);
        $eng  = Subject::firstOrCreate(['name'=>'English','code'=>'ENG','school_id'=>$school->id]);

        // teacher
        $teacherUser = User::firstOrCreate(['email'=>'teacher@demo.test'], [
            'name'=>'Demo Teacher',
            'password'=>bcrypt('password'),
            'school_id'=>$school->id,
        ]);
        if (method_exists($teacherUser,'assignRole')) $teacherUser->assignRole('Teacher');

        $teacherProfile = TeacherProfile::firstOrCreate(['user_id'=>$teacherUser->id], [
            'employee_number'=>'T-001',
            'phone'=>'111',
            'address'=>'',
            'school_id'=>$school->id,
        ]);

        // student
        $studentUser = User::firstOrCreate(['email'=>'student@demo.test'], [
            'name'=>'Demo Student',
            'password'=>bcrypt('password'),
            'school_id'=>$school->id,
        ]);
        if (method_exists($studentUser,'assignRole')) $studentUser->assignRole('Student');

        $studentProfile = StudentProfile::firstOrCreate(['user_id'=>$studentUser->id], [
            'admission_no'=>'S-001',
            'date_of_birth'=>now()->subYears(10)->format('Y-m-d'),
            'gender'=>'Male',
            'class_level_id'=>$cl1->id,
            'section_id'=>$sA->id,
            'school_id'=>$school->id,
        ]);

        // parent
        $parentUser = User::firstOrCreate(['email'=>'parent@demo.test'], [
            'name'=>'Demo Parent',
            'password'=>bcrypt('password'),
            'school_id'=>$school->id,
        ]);
        if (method_exists($parentUser,'assignRole')) $parentUser->assignRole('Parent');

        $parentProfile = ParentProfile::firstOrCreate(['user_id'=>$parentUser->id], [
            'relation'=>'Father',
            'phone'=>'222',
            'address'=>'',
            'school_id'=>$school->id,
        ]);

        // parent_student pivot
        $parentProfile->children()->syncWithoutDetaching([$studentProfile->id]);

        // classroom assignment
        ClassroomAssignment::firstOrCreate([
            'teacher_profile_id'=>$teacherProfile->id,
            'class_level_id'=>$cl1->id,
            'section_id'=>$sA->id,
            'subject_id'=>$math->id,
            'school_id'=>$school->id,
        ]);
    }
}
