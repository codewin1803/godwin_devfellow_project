@php
    $isMine = $message->sender_id === auth()->id();
@endphp

<div class="mb-3 {{ $isMine ? 'text-end' : 'text-start' }}">
    <div>
        <strong>{{ $message->sender->name }}</strong>
        <span class="text-muted small"> • {{ $message->created_at->diffForHumans() }}</span>
        @if($message->isUnreadFor(auth()->id()))
            <span class="badge bg-warning text-dark">New</span>
        @endif
    </div>

    <div class="border rounded p-2 mt-1" style="display:inline-block; max-width:80%;">
        {!! nl2br(e($message->body)) !!}
        @if($message->attachment_path)
            <div class="mt-2">
                <a href="{{ route('messages.attachment', $message->id) }}" class="small">Download attachment</a>
            </div>
        @endif
    </div>
</div>
