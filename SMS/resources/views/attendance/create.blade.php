@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Record Attendance</h2>

    <form method="POST" action="{{ route('attendance.store') }}">
        @csrf
        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>
                        <select name="attendance[{{ $student->id }}]" class="form-select">
                            <option value="PRESENT">Present</option>
                            <option value="ABSENT">Absent</option>
                            <option value="LATE">Late</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Submit Attendance</button>
    </form>
</div>
@endsection
