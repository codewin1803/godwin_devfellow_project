@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Import & Export Students</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('failures'))
        <div class="alert alert-danger">
            <h5>Import Failed Rows</h5>
            <ul>
                @foreach(session('failures') as $failure)
                    <li>Row {{ $failure->row() }} — {{ implode(', ', $failure->errors()) }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-3 mb-3">
        <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="form-label">Upload Excel/CSV File</label>
            <input type="file" name="file" class="form-control mb-2" required>

            <button class="btn btn-primary">Import Students</button>
        </form>
    </div>

    <div class="card p-3">
        <a href="{{ route('students.export') }}" class="btn btn-success">Download Students Excel</a>
    </div>
</div>
@endsection
