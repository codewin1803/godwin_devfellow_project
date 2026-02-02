@extends('layouts.app')

@section('content')
<div class="container">

<form method="POST" action="{{ route('announcements.store') }}">
@csrf

<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
    <label>Message</label>
    <textarea name="body" class="form-control" rows="5" required></textarea>
</div>

<div class="mb-3">
    <label>Target Roles</label>
    <select name="target_roles[]" class="form-control" multiple required>
        <option value="SuperAdmin">SuperAdmin</option>
        <option value="SchoolAdmin">SchoolAdmin</option>
        <option value="Teacher">Teacher</option>
        <option value="Student">Student</option>
        <option value="Parent">Parent</option>
        <option value="Bursar">Bursar</option>
    </select>
</div>

<div class="mb-3">
    <label>Publish At</label>
    <input type="datetime-local" name="publish_at" class="form-control" required>
</div>

<div class="mb-3">
    <label>Expire At</label>
    <input type="datetime-local" name="expires_at" class="form-control">
</div>

<button class="btn btn-success">Publish</button>

</form>

</div>
@endsection
