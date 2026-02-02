@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Assessment Types</h3>
    <a href="{{ route('assessments.create') }}" class="btn btn-primary mb-3">Add</a>

    <table class="table table-bordered">
        <tr>
            <th>Subject</th>
            <th>Name</th>
            <th>Weight (%)</th>
        </tr>
        @foreach($types as $type)
        <tr>
            <td>{{ $type->subject->name }}</td>
            <td>{{ $type->name }}</td>
            <td>{{ $type->weight }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
