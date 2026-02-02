<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'target_roles' => 'required|array',
            'publish_at' => 'required|date',
            'expires_at' => 'nullable|date|after:publish_at',
        ]);

        Announcement::create([
            'school_id' => session('active_school'),
            'title' => $request->title,
            'body' => $request->body,
            'target_roles' => $request->target_roles,
            'publish_at' => $request->publish_at,
            'expires_at' => $request->expires_at,
            'created_by' => auth()->id,
        ]);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return back()->with('success', 'Announcement deleted.');
    }
}
