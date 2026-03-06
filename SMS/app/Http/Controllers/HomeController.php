<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only logged-in users can access the dashboard
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard after login.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Get the current user's first role (requires Spatie Permission package)
        $userRole = $user->getRoleNames()->first();

        // 2. Fetch announcements targeted at this specific role
        $announcements = Announcement::active()
            ->whereJsonContains('target_roles', $userRole)
            ->latest()
            ->get();

        // 3. Return the view with the announcements data
        return view('home', compact('announcements'));
    }
}
