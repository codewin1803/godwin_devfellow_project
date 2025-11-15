@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Announcement</h2>

    <form action="{{ route('announcements.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label>Target Role</label>
            <select name="target_role" class="form-control" required>
                <option value="all">All</option>
                <option value="admin">Admin</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
            </select>
        </div>

        <div class="form-group">
            <label>Publish At (optional)</label>
            <input type="datetime-local" name="publish_at" class="form-control">
        </div>

        <div class="form-group">
            <label>Expires At (optional)</label>
            <input type="datetime-local" name="expires_at" class="form-control">
        </div>

        <button type="submit" class="btn btn-success mt-2">Create Announcement</button>
    </form>
</div>
@endsection
