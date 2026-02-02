@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Parent</h3>

    <form action="{{ route('parent_profiles.update', $parent) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Full name</label>
            <input name="name" value="{{ old('name', $parent->user->name) }}" class="form-control"></div>

        <div class="mb-3"><label class="form-label">Relation</label>
            <input name="relation" value="{{ old('relation', $parent->relation) }}" class="form-control"></div>

        <div class="mb-3"><label class="form-label">Phone</label>
            <input name="phone" value="{{ old('phone', $parent->phone) }}" class="form-control"></div>

        <div class="mb-3"><label class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $parent->address) }}</textarea></div>

        <button class="btn btn-primary">Update</button>
        <a class="btn btn-secondary" href="{{ route('parent_profiles.index') }}">Cancel</a>
    </form>
</div>
@endsection
