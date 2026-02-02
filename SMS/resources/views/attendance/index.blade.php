@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Attendance Records</h4>

    @can('create', App\Models\Attendance::class)
        <a href="{{ route('attendance.create') }}" class="btn btn-primary mb-3">
            Add Attendance
        </a>
    @endcan

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->student->name }}</td>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->status }}</td>
                    <td>
                        @can('update', $attendance)
                            <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endcan

                        @can('delete', $attendance)
                            <form action="{{ route('attendance.destroy', $attendance) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
