@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('messages.index') }}" class="btn btn-link">&larr; Back to messages</a>

    <h4>{{ $thread->subject ?? 'Conversation' }}</h4>
    <div class="mb-3 text-muted">Started by {{ $thread->creator->name ?? 'unknown' }} • Last: {{ $thread->last_message_at ? $thread->last_message_at->diffForHumans() : '' }}</div>

    <div class="card mb-3 p-3">
        @foreach($thread->messages as $message)
            @include('messages._message', ['message' => $message])
        @endforeach
    </div>

    <div class="card p-3">
        <form action="{{ route('messages.send', $thread->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- You can optionally provide receiver id if you want precise control --}}
            <input type="hidden" name="receiver_id" value="{{ $thread->messages->last()->sender_id === auth()->id() ? $thread->messages->last()->receiver_id : $thread->messages->last()->sender_id }}">

            <div class="mb-3">
                <label for="body" class="form-label">Message</label>
                <textarea name="body" id="body" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="attachment" class="form-label">Attachment (optional)</label>
                <input type="file" name="attachment" id="attachment" class="form-control">
            </div>

            <button class="btn btn-primary">Send</button>
        </form>
    </div>
</div>
@endsection
