@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Attendance Reports</h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Student</th>
                <th>Class</th>
                <th>Section</th>
                <th>Status</th>
                <th>Note</th>
            </tr>
        </thead>

        <tbody>
            @foreach($records as $r)
            <tr>
                <td>{{ $r->date }}</td>
                <td>{{ $r->student->user->name }}</td>
                <td>{{ $r->classLevel->name }}</td>
                <td>{{ optional($r->section)->name }}</td>
                <td>
                    @if($r->status == 'Present')
                        <span class="badge bg-success">Present</span>
                    @elseif($r->status == 'Absent')
                        <span class="badge bg-danger">Absent</span>
                    @elseif($r->status == 'Late')
                        <span class="badge bg-warning">Late</span>
                    @else
                        <span class="badge bg-info">Excused</span>
                    @endif
                </td>
                <td>{{ $r->note }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
