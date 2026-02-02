@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Weekly Timetable</h3>

    <button onclick="window.print()" class="btn btn-secondary mb-3">
        Print Timetable
    </button>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Day</th>
                <th>Time</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Teacher</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
                <tr>
                    <td>{{ $entry->weekday }}</td>
                    <td>
                        {{ $entry->start_time }} - {{ $entry->end_time }}
                    </td>
                    <td>
                        {{ $entry->classLevel->name }} {{ $entry->section->name }}
                    </td>
                    <td>{{ $entry->subject->name }}</td>
                    <td>{{ $entry->teacher->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
