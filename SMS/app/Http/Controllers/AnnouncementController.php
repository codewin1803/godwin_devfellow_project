<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import Auth facade
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $announcements = Announcement::where('school_id', Auth::user()->school_id) // <-- replaced
            ->where(function($q) use ($now) {
                $q->whereNull('publish_at')->orWhere('publish_at', '<=', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', $now);
            })
            ->orderBy('publish_at', 'desc')
            ->get();

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'target_role' => 'required|string',
            'publish_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:publish_at',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'target_role' => $request->target_role,
            'publish_at' => $request->publish_at,
            'expires_at' => $request->expires_at,
            'school_id' => Auth::user()->school_id, // <-- replaced
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement created.');
    }

    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return back()->with('success', 'Announcement deleted.');
    }
}
