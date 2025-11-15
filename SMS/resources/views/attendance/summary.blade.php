@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Attendance Summary</h2>

    <a href="{{ route('attendance.export', $attendances->first()->student->class_level_id ?? 0) }}" class="btn btn-secondary mb-3">Export CSV</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $a)
            <tr>
                <td>{{ $a->student->name ?? '' }}</td>
                <td>{{ $a->date }}</td>
                <td>{{ $a->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
