@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>Parents</h3>
        <a href="{{ route('parent_profiles.create') }}" class="btn btn-primary">Add Parent</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <table class="table table-bordered">
        <thead><tr><th>Name</th><th>Relation</th><th>Phone</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($parents as $p)
            <tr>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->relation }}</td>
                <td>{{ $p->phone }}</td>
                <td>
                    <a href="{{ route('parent_profiles.edit', $p) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('parent_profiles.destroy', $p) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete parent?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
