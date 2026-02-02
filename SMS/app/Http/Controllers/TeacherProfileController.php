<?php

namespace App\Http\Controllers;

use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeacherProfileController extends Controller
{
    public function index()
    {
        $teachers = TeacherProfile::with('user')->get();
        return view('teacher_profiles.index', compact('teachers'));
    }

    public function create()
    {
        return view('teacher_profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'employee_number'=>'nullable|string|unique:teacher_profiles,employee_number',
            'phone'=>'nullable|string',
        ]);

        // create user
        $password = Str::random(10);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($password),
            'school_id'=>session('active_school'),
        ]);

        // assign role if Spatie is installed (optional)
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('Teacher');
        }

        // create teacher profile
        TeacherProfile::create([
            'user_id'=>$user->id,
            'employee_number'=>$request->employee_number,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'school_id'=>session('active_school'),
        ]);

        return redirect()->route('teacher_profiles.index')->with('success','Teacher created');
    }

    public function edit(TeacherProfile $teacherProfile)
    {
        return view('teacher_profiles.edit', ['teacher'=>$teacherProfile]);
    }

    public function update(Request $request, TeacherProfile $teacherProfile)
    {
        $request->validate([
            'employee_number'=>'nullable|string|unique:teacher_profiles,employee_number,'.$teacherProfile->id,
            'phone'=>'nullable|string',
        ]);

        $teacherProfile->update($request->only(['employee_number','phone','address']));

        // optionally update user's name/email
        if ($request->filled('name')) {
            $teacherProfile->user->update(['name'=>$request->name]);
        }

        return redirect()->route('teacher_profiles.index')->with('success','Teacher updated');
    }

    public function destroy(TeacherProfile $teacherProfile)
    {
        // deletes profile and cascades to user via foreign key
        $teacherProfile->user->delete();
        return back()->with('success','Teacher deleted');
    }
}
