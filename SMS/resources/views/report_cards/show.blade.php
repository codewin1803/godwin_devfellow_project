@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-3">Report Card – {{ $student->user->name }}</h2>
    <p><strong>Class:</strong> {{ $student->classLevel->name }}</p>
    <p><strong>Section:</strong> {{ $student->section->name }}</p>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grades as $grade)
                <tr>
                    <td>{{ $grade->subject->name ?? 'N/A' }}</td>
                    <td>{{ $grade->score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Average: {{ number_format($average, 2) }}</h4>

    <a href="{{ route('report.download', $student->id) }}" class="btn btn-primary mt-3">
        Download PDF
    </a>

</div>
@endsection
