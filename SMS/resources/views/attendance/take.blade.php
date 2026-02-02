@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">
        Attendance - {{ $classLevel->name }}
        @if($section)
            (Section {{ $section->name }})
        @endif
    </h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('attendance.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" required class="form-control" value="{{ date('Y-m-d') }}">
        </div>

        <div class="row">
            @foreach($students as $student)
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">

                        <h5>{{ $student->user->name }}</h5>
                        <p class="text-muted">Admission No: {{ $student->admission_no }}</p>

                        <input type="hidden" name="attendance[{{ $student->id }}][class_level_id]" value="{{ $classLevel->id }}">
                        <input type="hidden" name="attendance[{{ $student->id }}][section_id]" value="{{ $student->section_id }}">

                        <div class="mb-3">
                            <label>Status</label>
                            <select name="attendance[{{ $student->id }}][status]" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Present">Present</option>
                                <option value="Absent">Absent</option>
                                <option value="Late">Late</option>
                                <option value="Excused">Excused</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label>Note (optional)</label>
                            <input type="text" name="attendance[{{ $student->id }}][note]" class="form-control">
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <button class="btn btn-success">Save Attendance</button>
    </form>

</div>
@endsection
