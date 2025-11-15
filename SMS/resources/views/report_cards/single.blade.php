<!DOCTYPE html>
<html>
<head>
    <title>Report Card - {{ $student->full_name }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Report Card</h2>
    <p><strong>Student:</strong> {{ $student->full_name }}</p>
    <p><strong>Class:</strong> {{ $student->classLevel->name ?? 'N/A' }}</p>

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->subject->title ?? 'N/A' }}</td>
                    <td>{{ $grade->score }}</td>
                </tr>
            @endforeach
            <tr>
                <th>Average</th>
                <th>{{ number_format($average, 2) }}</th>
            </tr>
        </tbody>
    </table>
</body>
</html>
