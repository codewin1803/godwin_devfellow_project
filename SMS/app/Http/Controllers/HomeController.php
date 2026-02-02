<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

$announcements = Announcement::active()
    ->whereJsonContains(
        'target_roles',
        auth()->user->getRoleNames()->first()
    )
    ->latest()
    ->get();


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
        return view('home');
    }
}
