@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Teachers</h3>
        <a href="{{ route('teacher_profiles.create') }}" class="btn btn-primary">Add Teacher</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead><tr><th>Name</th><th>Employee No.</th><th>Phone</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($teachers as $t)
            <tr>
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->employee_number }}</td>
                <td>{{ $t->phone }}</td>
                <td>
                    <a href="{{ route('teacher_profiles.edit', $t) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('teacher_profiles.destroy', $t) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete teacher?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
