@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Term</h3>

    <form method="POST" action="{{ route('terms.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Academic Session</label>
            <select name="academic_session_id" class="form-control" required>
                @foreach($sessions as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Term Name (e.g. First Term)</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <button class="btn btn-success">Create Term</button>
    </form>
</div>
@endsection
