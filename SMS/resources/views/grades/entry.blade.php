@extends('layouts.app')

@section('content')
<h2>Grade Entry – {{ $subject->name }}</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('grades.store', $subject->id) }}" method="POST">
    @csrf
    <table border="1" cellpadding="5" cellspacing="0" id="gradesTable">
        <thead>
            <tr>
                <th>Student</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->full_name }}</td>
                <td>
                    <input type="number" class="score-input" name="grades[{{ $student->id }}]"
                           value="{{ $grades[$student->id] ?? '' }}" min="0" max="100"
                           {{ isset($grades[$student->id]) && $grades[$student->id]->is_locked ? 'readonly' : '' }}>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit">Save Grades</button>
</form>

<form action="{{ route('grades.lock', $subject->id) }}" method="POST" style="margin-top:10px;">
    @csrf
    @method('PATCH')
    <button type="submit">Lock Grades</button>
</form>

<h3>Total: <span id="totalScore">0</span></h3>
<h3>Average: <span id="averageScore">0</span></h3>

<script>
function calculateTotals() {
    let total = 0;
    let count = 0;

    document.querySelectorAll('.score-input').forEach(input => {
        const value = parseInt(input.value);
        if (!isNaN(value)) {
            total += value;
            count++;
        }
    });

    document.getElementById('totalScore').textContent = total;
    document.getElementById('averageScore').textContent = count ? (total / count).toFixed(2) : 0;
}

// Initialize totals on page load
calculateTotals();

// Update totals whenever an input changes
document.querySelectorAll('.score-input').forEach(input => {
    input.addEventListener('input', calculateTotals);
});
</script>
@endsection
