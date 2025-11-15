<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; padding: 20px; }
        .title { text-align: center; font-size: 22px; font-weight: bold; margin-bottom: 20px; }
        .info { font-size: 16px; line-height: 1.6; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; font-size: 14px; }
        .footer { margin-top: 30px; font-size: 16px; }
    </style>
</head>

<body>

<div class="title">STUDENT REPORT CARD</div>

<div class="info">
    <strong>Name:</strong> {{ $student->full_name }} <br>
    <strong>Class:</strong> {{ $student->classroom->name }} <br>
    <strong>Session:</strong> {{ now()->format('Y') }}
</div>

<table>
    <thead>
        <tr>
            <th>Subject</th>
            <th>Score</th>
            <th>Grade</th>
        </tr>
    </thead>

    <tbody>
        @foreach($grades as $grade)
        <tr>
            <td>{{ $grade->subject->title }}</td>
            <td>{{ $grade->score }}</td>
            <td>
                @if ($grade->score >= 75) A
                @elseif ($grade->score >= 60) B
                @elseif ($grade->score >= 50) C
                @elseif ($grade->score >= 40) D
                @else F
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <strong>Average Score:</strong> {{ $average }} <br>
    <strong>Overall Remark:</strong> {{ $remark }}
</div>

</body>
</html>
