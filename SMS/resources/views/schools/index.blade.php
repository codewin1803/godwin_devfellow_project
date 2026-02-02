@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Schools</h2>

    <a href="{{ route('schools.create') }}" class="btn btn-primary mb-3">Add School</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($schools as $school)
            <tr>
                <td>{{ $school->name }}</td>
                <td>{{ $school->email }}</td>
                <td>{{ $school->phone }}</td>
                <td>{{ $school->address }}</td>
                <td>
                    <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('schools.destroy', $school->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete school?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
</div>
@endsection
