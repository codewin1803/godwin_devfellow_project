@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Parent</h3>

    <form action="{{ route('parent_profiles.store') }}" method="POST">
        @csrf
        <div class="mb-3"><label class="form-label">Full name</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Relation</label><input name="relation" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Phone</label><input name="phone" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Address</label><textarea name="address" class="form-control"></textarea></div>

        <button class="btn btn-success">Create</button>
        <a class="btn btn-secondary" href="{{ route('parent_profiles.index') }}">Cancel</a>
    </form>
</div>
@endsection
