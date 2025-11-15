@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Timetable</h3>

    <form method="POST" action="{{ route('timetable.store') }}">
        @csrf

        <div class="row mb-3">
            <div class="col">
                <label>Class Level</label>
                <select name="class_level_id" class="form-control">
                    @foreach(Auth::user()->school->classLevels as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label>Subject</label>
                <select name="subject_id" class="form-control">
                    @foreach(Auth::user()->school->subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label>Teacher</label>
                <select name="teacher_id" class="form-control">
                    @foreach($teachers as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Weekday</label>
                <select name="weekday" class="form-control">
                    <option value="1">Monday</option>
                    <option value="2">Tuesday</option>
                    <option value="3">Wednesday</option>
                    <option value="4">Thursday</option>
                    <option value="5">Friday</option>
                </select>
            </div>

            <div class="col">
                <label>Start Time</label>
                <input type="time" name="start_time" class="form-control">
            </div>

            <div class="col">
                <label>End Time</label>
                <input type="time" name="end_time" class="form-control">
            </div>
        </div>

        <button class="btn btn-primary">Add to Timetable</button>
    </form>

    <hr>

    <h4>Current Timetable</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Class</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Day</th>
                <th>Time</th>
            </tr>
        </thead>

        <tbody>
            @foreach($timetables as $t)
                <tr>
                    <td>{{ $t->classLevel->name }}</td>
                    <td>{{ $t->subject->name }}</td>
                    <td>{{ $t->teacher->name }}</td>
                    <td>{{ ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'][$t->weekday-1] }}</td>
                    <td>{{ $t->start_time }} - {{ $t->end_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
