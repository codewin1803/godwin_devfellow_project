@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Schools Management</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('schools.create') }}" class="btn btn-primary mb-3">+ Add New School</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schools as $school)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $school->name }}</td>
                    <td>{{ $school->address }}</td>
                    <td>{{ $school->email }}</td>
                    <td>
                        <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('schools.destroy', $school->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this school?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No schools found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
