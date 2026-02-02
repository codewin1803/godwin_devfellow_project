@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create New Academic Session</h3>

    <form method="POST" action="{{ route('sessions.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Session Name (2024/2025)</label>
            <input type="text" name="name" required class="form-control">
        </div>

        <button class="btn btn-success">Create Session</button>
    </form>
</div>
@endsection
