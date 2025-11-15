<h2>Import Students</h2>
<form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Import</button>
</form>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('errors'))
    <h4>Errors:</h4>
    <ul>
        @foreach (session('errors') as $error)
            <li>Row {{ $error['row'] }}: {{ implode(', ', $error['errors']) }}</li>
        @endforeach
    </ul>
@endif

<hr>

<h2>Export Students</h2>
<a href="{{ route('students.export') }}">Download Excel</a>
