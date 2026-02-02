@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Class Level</h3>

    <form action="{{ route('class_levels.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Level name</label>
            <input id="name" name="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Create</button>
        <a href="{{ route('class_levels.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
