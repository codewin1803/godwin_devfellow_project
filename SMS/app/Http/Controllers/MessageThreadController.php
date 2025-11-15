<?php

namespace App\Http\Controllers;

use App\Models\MessageThread;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageThreadController extends Controller
{
    // List all threads for the current user (inbox + sent)
    public function index()
    {
        $user = Auth::user();

        // threads where user participated (sender or receiver)
        $threads = MessageThread::where('school_id', $user->school_id)
            ->where(function($q) use ($user) {
                $q->whereHas('messages', function($m) use ($user) {
                    $m->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
                });
            })
            ->withCount(['messages as unread_count' => function($q) use ($user) {
                $q->where('receiver_id', $user->id)->whereNull('read_at');
            }])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('messages.index', compact('threads'));
    }

    // Show a single thread and its messages
    public function show($threadId)
    {
        $user = Auth::user();

        $thread = MessageThread::with(['messages.sender', 'messages.receiver'])
            ->where('id', $threadId)
            ->where('school_id', $user->school_id)
            ->firstOrFail();

        // mark messages in this thread as read where receiver is current user
        Message::where('thread_id', $thread->id)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => Carbon::now()]);

        return view('messages.show', compact('thread'));
    }

    // Create a new thread - show form
    public function create()
    {
        // For teachers/parents select user to message; here we list other users in the same school.
        $users = User::where('school_id', Auth::user()->school_id)
            ->where('id', '!=', Auth::id())
            ->get();

        return view('messages.create', compact('users'));
    }

    // Store a new thread with first message
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'nullable|string|max:255',
            'receiver_id' => 'required|exists:users,id',
            'body' => 'nullable|string',
            'attachment' => 'nullable|file|max:5120' // 5MB
        ]);

        $user = Auth::user();

        // create thread
        $thread = MessageThread::create([
            'subject' => $request->subject,
            'created_by' => $user->id,
            'school_id' => $user->school_id,
            'last_message_at' => now(),
        ]);

        // store attachment if present
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store("private/messages/{$thread->id}", 'local');
        }

        // create first message
        $message = Message::create([
            'thread_id' => $thread->id,
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
            'attachment_path' => $attachmentPath,
        ]);

        $thread->update(['last_message_at' => $message->created_at]);

        return redirect()->route('messages.show', $thread->id)
            ->with('success', 'Thread created and message sent.');
    }
}
