@extends('layouts.app')

@section('content')

<h2 class="mb-4">Report Cards – {{ $classroom->name }}</h2>

<a href="{{ route('report_cards.batch', $classroom->id) }}" class="btn btn-primary mb-3">
    Download All Report Cards (ZIP)
</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($classroom->students as $student)
            <tr>
                <td>{{ $student->full_name }}</td>
                <td>
                    <a href="{{ route('report_cards.download', $student->id) }}" class="btn btn-success btn-sm">
                        Download PDF
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
