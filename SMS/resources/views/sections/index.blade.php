@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Sections</h3>
        <a href="{{ route('sections.create') }}" class="btn btn-primary">Add Section</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($sections->isEmpty())
        <div class="alert alert-info">No sections found.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Class Level</th>
                    <th>Created</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sections as $section)
                <tr>
                    <td>{{ $section->name }}</td>
                    <td>{{ optional($section->classLevel)->name }}</td>
                    <td>{{ $section->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('sections.edit', $section) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('sections.destroy', $section) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this section?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
