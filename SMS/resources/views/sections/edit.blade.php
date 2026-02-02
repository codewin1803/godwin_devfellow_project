@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Section</h3>

    <form action="{{ route('sections.update', $section) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Section name</label>
            <input name="name" value="{{ old('name', $section->name) }}" class="form-control" required>
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Class Level</label>
            <select name="class_level_id" class="form-control" required>
                <option value="">Select</option>
                @foreach($classLevels as $level)
                    <option value="{{ $level->id }}" @if(old('class_level_id', $section->class_level_id) == $level->id) selected @endif>
                        {{ $level->name }}
                    </option>
                @endforeach
            </select>
            @error('class_level_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('sections.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
