@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Students</h3>
        <a href="{{ route('student_profiles.create') }}" class="btn btn-primary">Add Student</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead><tr><th>Name</th><th>Admission No.</th><th>Class</th><th>Section</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($students as $s)
            <tr>
                <td>{{ $s->user->name }}</td>
                <td>{{ $s->admission_no }}</td>
                <td>{{ optional($s->classLevel)->name }}</td>
                <td>{{ optional($s->section)->name }}</td>
                <td>
                    <a href="{{ route('student_profiles.edit', $s) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('student_profiles.destroy', $s) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete student?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
