@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Subjects</h3>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">Add Subject</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($subjects->isEmpty())
        <div class="alert alert-info">No subjects found.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Created</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->code }}</td>
                    <td>{{ $subject->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this subject?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
