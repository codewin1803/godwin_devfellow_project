@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Subject</h3>

    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Subject name</label>
            <input name="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Code (optional)</label>
            <input name="code" value="{{ old('code') }}" class="form-control">
        </div>

        <button class="btn btn-success">Create</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
