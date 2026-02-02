@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Assign Teacher to Class/Subject</h3>

    <form action="{{ route('classroom_assignments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Teacher</label>
            <select name="teacher_profile_id" class="form-control" required>
                <option value="">Select</option>
                @foreach($teachers as $t)
                    <option value="{{ $t->id }}">{{ $t->user->name }} ({{ $t->employee_number }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Class Level</label>
            <select name="class_level_id" class="form-control" required>
                <option value="">Select</option>
                @foreach($classLevels as $cl)
                    <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Section (optional)</label>
            <select name="section_id" class="form-control">
                <option value="">Any</option>
                @foreach($sections as $s)
                    <option value="{{ $s->id }}">{{ $s->name }} ({{ optional($s->classLevel)->name }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Subject</label>
            <select name="subject_id" class="form-control" required>
                <option value="">Select</option>
                @foreach($subjects as $sub)
                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Assign</button>
        <a class="btn btn-secondary" href="{{ route('classroom_assignments.index') }}">Cancel</a>
    </form>
</div>
@endsection
