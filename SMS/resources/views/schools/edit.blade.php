@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit School</h2>
    <form action="{{ route('schools.update', $school->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">School Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $school->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $school->address) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $school->email) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('schools.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
