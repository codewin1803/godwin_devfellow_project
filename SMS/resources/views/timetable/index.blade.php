@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Weekly Timetable</h2>

    <!-- Filters -->
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <select name="class_level_id" class="form-select">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_level_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="teacher_id" class="form-select">
                <option value="">All Teachers</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="button" class="btn btn-success" onclick="window.print()">Print</button>
            <a href="{{ route('timetable.export', request()->all()) }}" class="btn btn-secondary">Export CSV</a>
        </div>
    </form>

    <!-- Timetable Grid -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Class</th>
                <th>Teacher</th>
                <th>Subject</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timetables as $t)
                <tr>
                    <td>{{ $t->classLevel->name ?? '' }}</td>
                    <td>{{ $t->teacher->name ?? '' }}</td>
                    <td>{{ $t->subject->name ?? '' }}</td>
                    <td>{{ $t->weekday == 'Monday' ? $t->start_time.'-'.$t->end_time : '' }}</td>
                    <td>{{ $t->weekday == 'Tuesday' ? $t->start_time.'-'.$t->end_time : '' }}</td>
                    <td>{{ $t->weekday == 'Wednesday' ? $t->start_time.'-'.$t->end_time : '' }}</td>
                    <td>{{ $t->weekday == 'Thursday' ? $t->start_time.'-'.$t->end_time : '' }}</td>
                    <td>{{ $t->weekday == 'Friday' ? $t->start_time.'-'.$t->end_time : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
