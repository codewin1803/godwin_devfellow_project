<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    // Send a reply or message in an existing thread
    public function store(Request $request, $threadId)
    {
        $request->validate([
            'body' => 'nullable|string',
            'attachment' => 'nullable|file|max:5120' // 5MB
        ]);

        $user = Auth::user();

        $thread = MessageThread::where('id', $threadId)
            ->where('school_id', $user->school_id)
            ->firstOrFail();

        // determine receiver: if current user is last sender, swap; we require receiver_id input for clarity
        $receiverId = $request->input('receiver_id');
        if (!$receiverId) {
            // fallback: find the other participant from last message
            $lastMsg = $thread->messages()->latest()->first();
            $receiverId = $lastMsg && $lastMsg->sender_id === $user->id ? $lastMsg->receiver_id : ($lastMsg->sender_id ?? null);
        }

        if (!$receiverId) {
            return back()->withErrors('No receiver specified for this message.');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store("private/messages/{$thread->id}", 'local');
        }

        $message = Message::create([
            'thread_id' => $thread->id,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'body' => $request->body,
            'attachment_path' => $attachmentPath,
        ]);

        $thread->update(['last_message_at' => $message->created_at]);

        return redirect()->route('messages.show', $thread->id)->with('success', 'Message sent.');
    }

    // Download attachment (secure)
    public function attachmentDownload($messageId)
    {
        $user = Auth::user();

        $message = Message::where('id', $messageId)
            ->where(function($q) use ($user) {
                $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
            })->firstOrFail();

        if (!$message->attachment_path || !Storage::disk('local')->exists($message->attachment_path)) {
            abort(404);
        }

        return Storage::disk('local')->download($message->attachment_path);
    }

    // Mark a message as read (could be used via ajax)
    public function markRead($messageId)
    {
        $user = Auth::user();

        $message = Message::where('id', $messageId)
            ->where('receiver_id', $user->id)
            ->firstOrFail();

        $message->update(['read_at' => now()]);

        return response()->json(['status' => 'ok']);
    }
}
