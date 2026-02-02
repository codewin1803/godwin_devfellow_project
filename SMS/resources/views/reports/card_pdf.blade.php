<!DOCTYPE html>
<html>
<head>
    <title>Report Card PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width:100%; border-collapse: collapse; margin-top:20px; }
        th, td { border:1px solid #000; padding:8px; }
        .header { text-align:center; margin-bottom:20px; }
    </style>
</head>
<body>

<div class="header">
    <h2>Student Report Card</h2>
    <p>Name: {{ $student->user->name }}</p>
</div>

<table>
    <tr>
        <th>Assessment</th>
        <th>Score</th>
    </tr>

    @foreach($grades as $grade)
        <tr>
            <td>{{ $grade->assessmentType->name }}</td>
            <td>{{ $grade->score }}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
