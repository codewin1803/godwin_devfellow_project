@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Classroom Assignments</h3>
        <a href="{{ route('classroom_assignments.create') }}" class="btn btn-primary">Add Assignment</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead><tr><th>Teacher</th><th>Class Level</th><th>Section</th><th>Subject</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($assignments as $a)
            <tr>
                <td>{{ optional($a->teacher->user)->name }}</td>
                <td>{{ optional($a->classLevel)->name }}</td>
                <td>{{ optional($a->section)->name }}</td>
                <td>{{ optional($a->subject)->name }}</td>
                <td>
                    <form action="{{ route('classroom_assignments.destroy', $a) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Remove assignment?')">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
