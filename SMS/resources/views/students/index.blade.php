@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-3">Students</h4>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search"
                   class="form-control"
                   placeholder="Search student name"
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="class_id" class="form-select">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected(request('class_id')==$class->id)>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Class</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $student->classLevel->name }}</td>
                    <td>{{ ucfirst($student->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $students->links() }}

</div>
@endsection
