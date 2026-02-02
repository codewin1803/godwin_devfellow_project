<?php

namespace App\Http\Controllers;

use App\Models\ParentProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParentProfileController extends Controller
{
    public function index()
    {
        $parents = ParentProfile::with('user')->get();
        return view('parent_profiles.index', compact('parents'));
    }

    public function create()
    {
        return view('parent_profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'relation'=>'nullable|string',
            'phone'=>'nullable|string',
        ]);

        $password = Str::random(8);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($password),
            'school_id'=>session('active_school'),
        ]);

        if (method_exists($user,'assignRole')) {
            $user->assignRole('Parent');
        }

        ParentProfile::create([
            'user_id'=>$user->id,
            'relation'=>$request->relation,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'school_id'=>session('active_school'),
        ]);

        return redirect()->route('parent_profiles.index')->with('success','Parent created');
    }

    public function edit(ParentProfile $parentProfile)
    {
        return view('parent_profiles.edit', ['parent'=>$parentProfile]);
    }

    public function update(Request $request, ParentProfile $parentProfile)
    {
        $request->validate([
            'relation'=>'nullable|string',
            'phone'=>'nullable|string',
        ]);

        $parentProfile->update($request->only(['relation','phone','address']));

        if ($request->filled('name')) {
            $parentProfile->user->update(['name'=>$request->name]);
        }

        return redirect()->route('parent_profiles.index')->with('success','Parent updated');
    }

    public function destroy(ParentProfile $parentProfile)
    {
        $parentProfile->user->delete();
        return back()->with('success','Parent deleted');
    }
}
