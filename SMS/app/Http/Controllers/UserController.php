<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                          ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            })

            ->when($request->role, function ($q) use ($request) {
                $q->whereHas('roles', function ($r) use ($request) {
                    $r->where('name', $request->role);
                });
            })

            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }
}
