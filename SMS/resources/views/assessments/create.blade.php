@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($assessmentType) ? 'Edit' : 'Add' }} Assessment for {{ $subject->name }}</h2>

    <form action="{{ isset($assessmentType) ? route('assessments.update', [$subject->id, $assessmentType->id]) : route('assessments.store', $subject->id) }}" method="POST">
        @csrf
        @if(isset($assessmentType))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Assessment Name</label>
            <input type="text" class="form-control" name="name" value="{{ $assessmentType->name ?? old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="weight" class="form-label">Weight (%)</label>
            <input type="number" class="form-control" name="weight" value="{{ $assessmentType->weight ?? old('weight') }}" required min="1" max="100">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
