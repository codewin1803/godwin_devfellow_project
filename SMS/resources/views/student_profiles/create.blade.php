@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Student</h3>

    <form action="{{ route('student_profiles.store') }}" method="POST">
        @csrf
        <div class="mb-3"><label class="form-label">Full name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Admission No.</label><input name="admission_no" class="form-control"></div>
        <div class="mb-3"><label class="form-label">DOB</label><input name="date_of_birth" type="date" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Gender</label>
            <select name="gender" class="form-control">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Class Level</label>
            <select name="class_level_id" class="form-control">
                <option value="">Select</option>
                @foreach($classLevels as $cl)
                    <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Section</label>
            <select name="section_id" class="form-control">
                <option value="">Select</option>
                @foreach($sections as $sec)
                    <option value="{{ $sec->id }}">{{ $sec->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Create</button>
        <a class="btn btn-secondary" href="{{ route('student_profiles.index') }}">Cancel</a>
    </form>
</div>
@endsection
