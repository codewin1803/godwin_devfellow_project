@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Announcements</h2>

    <a href="{{ route('announcements.create') }}" class="btn btn-primary mb-3">New Announcement</a>

    @foreach($announcements as $announcement)
        <div class="card mb-2 p-3">
            <h5>{{ $announcement->title }}</h5>
            <p>{{ $announcement->content }}</p>
            <p><strong>Target:</strong> {{ ucfirst($announcement->target_role) }}</p>
            <p><small>Publish: {{ $announcement->publish_at ?? 'Immediately' }} | Expires: {{ $announcement->expires_at ?? 'Never' }}</small></p>

            <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm mt-2">Delete</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
