@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Teacher</h3>

    <form action="{{ route('teacher_profiles.update', $teacher) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Full name</label>
            <input name="name" value="{{ old('name', $teacher->user->name) }}" class="form-control"></div>

        <div class="mb-3"><label class="form-label">Employee number</label>
            <input name="employee_number" value="{{ old('employee_number', $teacher->employee_number) }}" class="form-control"></div>

        <div class="mb-3"><label class="form-label">Phone</label>
            <input name="phone" value="{{ old('phone', $teacher->phone) }}" class="form-control"></div>

        <div class="mb-3"><label class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $teacher->address) }}</textarea></div>

        <button class="btn btn-primary">Update</button>
        <a class="btn btn-secondary" href="{{ route('teacher_profiles.index') }}">Cancel</a>
    </form>
</div>
@endsection
