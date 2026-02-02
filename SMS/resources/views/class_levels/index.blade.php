@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Class Levels</h3>
        <a href="{{ route('class_levels.create') }}" class="btn btn-primary">Add Class Level</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($classLevels->isEmpty())
        <div class="alert alert-info">No class levels found.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Created</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classLevels as $level)
                <tr>
                    <td>{{ $level->name }}</td>
                    <td>{{ $level->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('class_levels.edit', $level) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('class_levels.destroy', $level) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this class level?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
