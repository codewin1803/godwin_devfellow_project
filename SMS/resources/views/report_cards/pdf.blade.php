<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        h2 { text-align: center; }
    </style>
</head>
<body>

    <h2>Student Report Card</h2>

    <p><strong>Name:</strong> {{ $student->user->name }}</p>
    <p><strong>Admission No:</strong> {{ $student->admission_no }}</p>
    <p><strong>Class:</strong> {{ $student->classLevel->name }}</p>
    <p><strong>Section:</strong> {{ $student->section->name }}</p>

    <table>
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

    <h3>Average: {{ number_format($average, 2) }}</h3>

    <h4>Remarks:
        @if ($average >= 70)
            Excellent Performance
        @elseif ($average >= 50)
            Good Performance
        @else
            Needs Improvement
        @endif
    </h4>

</body>
</html>
