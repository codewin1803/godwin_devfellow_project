@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Timetable Entry</h3>

    <form method="POST" action="{{ route('timetable.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Class Level</label>
                <select name="class_level_id" class="form-control" required>
                    @foreach($classLevels as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Section</label>
                <select name="section_id" class="form-control" required>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Subject</label>
                <select name="subject_id" class="form-control" required>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Teacher</label>
                <select name="teacher_profile_id" class="form-control" required>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Day</label>
                <select name="weekday" class="form-control" required>
                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Start Time</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>End Time</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>
        </div>

        <button class="btn btn-success">Save Timetable</button>
    </form>
</div>
@endsection
