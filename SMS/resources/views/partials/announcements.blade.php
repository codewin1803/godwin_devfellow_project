@if($announcements->count())
<div class="mb-4">
    <h4>Announcements</h4>

    @foreach($announcements as $announcement)
        <div class="alert alert-info">
            <strong>{{ $announcement->title }}</strong>
            <p>{{ $announcement->body }}</p>
            <small>Posted {{ $announcement->publish_at->diffForHumans() }}</small>
        </div>
    @endforeach
</div>
@endif
