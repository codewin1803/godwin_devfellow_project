@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Student</h3>

    <form action="{{ route('student_profiles.update', $studentProfile) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Full name</label>
            <input name="name" value="{{ old('name', $studentProfile->user->name) }}" class="form-control"></div>

        <div class="mb-3"><label class="form-label">Admission No.</label>
            <input name="admission_no" value="{{ old('admission_no', $studentProfile->admission_no) }}" class="form-control"></div>

        <div class="mb-3"><label class="form-label">DOB</label>
            <input name="date_of_birth" type="date" value="{{ old('date_of_birth', optional($studentProfile->date_of_birth)->format('Y-m-d')) }}" class="form-control"></div>

        <div class="mb-3"><label class="form-label">Class Level</label>
            <select name="class_level_id" class="form-control">
                <option value="">Select</option>
                @foreach($classLevels as $cl)
                    <option value="{{ $cl->id }}" @if(old('class_level_id', $studentProfile->class_level_id) == $cl->id) selected @endif>{{ $cl->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3"><label class="form-label">Section</label>
            <select name="section_id" class="form-control">
                <option value="">Select</option>
                @foreach($sections as $sec)
                    <option value="{{ $sec->id }}" @if(old('section_id', $studentProfile->section_id) == $sec->id) selected @endif>{{ $sec->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a class="btn btn-secondary" href="{{ route('student_profiles.index') }}">Cancel</a>
    </form>
</div>
@endsection
