@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('announcements.create') }}" class="btn btn-primary mb-3">
        New Announcement
    </a>

    @foreach($announcements as $announcement)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $announcement->title }}</h5>
                <p>{{ $announcement->body }}</p>

                <small>
                    Publish: {{ $announcement->publish_at }}
                    | Expire: {{ $announcement->expires_at ?? 'Never' }}
                </small>

                <form method="POST" action="{{ route('announcements.destroy', $announcement) }}" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    @endforeach

    {{ $announcements->links() }}

</div>
@endsection
