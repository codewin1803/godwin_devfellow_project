@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $subject->name }} - Assessment Types</h2>
    <a href="{{ route('assessments.create', $subject->id) }}" class="btn btn-primary mb-3">Add Assessment</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Weight (%)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assessments as $a)
            <tr>
                <td>{{ $a->name }}</td>
                <td>{{ $a->weight }}</td>
                <td>
                    <a href="{{ route('assessments.edit', [$subject->id, $a->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('assessments.destroy', [$subject->id, $a->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
