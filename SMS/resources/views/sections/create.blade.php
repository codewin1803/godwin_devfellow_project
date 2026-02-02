@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Section</h3>

    <form action="{{ route('sections.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Section name</label>
            <input name="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Class Level</label>
            <select name="class_level_id" class="form-control" required>
                <option value="">Select</option>
                @foreach($classLevels as $level)
                    <option value="{{ $level->id }}" @if(old('class_level_id') == $level->id) selected @endif>
                        {{ $level->name }}
                    </option>
                @endforeach
            </select>
            @error('class_level_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-success">Create</button>
        <a href="{{ route('sections.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
