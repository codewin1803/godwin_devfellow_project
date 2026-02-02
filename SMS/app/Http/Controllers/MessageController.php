<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageThread;



class MessageController extends Controller
{
    public function index()
    {
        $threads = MessageThread::whereHas('messages', function ($q) {
            $q->where('sender_id', auth()->id)
              ->orWhere('receiver_id', auth()->id);
        })->latest()->get();

        return view('messages.index', compact('threads'));
    }

    public function show(MessageThread $thread)
    {
        abort_if(
            !$thread->messages()
                ->where('sender_id', auth()->id)
                ->orWhere('receiver_id', auth()->id)
                ->exists(),
            403
        );

        $thread->messages()
            ->where('receiver_id', auth()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.show', compact('thread'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $thread = MessageThread::create([
            'subject' => $request->subject,
            'created_by' => auth()->id,
        ]);

        $path = $request->file('attachment')
            ? $request->file('attachment')->store('messages', 'public')
            : null;

        Message::create([
            'thread_id' => $thread->id,
            'sender_id' => auth()->id,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
            'attachment' => $path,
        ]);

        return redirect()->route('messages.index');
    }

    public function reply(Request $request, MessageThread $thread)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $lastMessage = $thread->messages()->latest()->first();

        Message::create([
            'thread_id' => $thread->id,
            'sender_id' => auth()->id,
            'receiver_id' => $lastMessage->sender_id === auth()->id
                ? $lastMessage->receiver_id
                : $lastMessage->sender_id,
            'body' => $request->body,
        ]);

        return back();
    }
}
