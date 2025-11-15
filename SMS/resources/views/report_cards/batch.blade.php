<!DOCTYPE html>
<html>
<head>
    <title>All Report Cards</title>
    <style>
        body { font-family: sans-serif; }
        .report-card { page-break-after: always; margin-bottom: 50px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>
    @foreach($students as $student)
        <div class="report-card">
            <h3>Report Card: {{ $student->full_name }}</h3>
            <p><strong>Class:</strong> {{ $student->classLevel->name ?? 'N/A' }}</p>

            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grades = $student->grades;
                        $average = $grades->avg('score');
                    @endphp
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
        </div>
    @endforeach
</body>
</html>
