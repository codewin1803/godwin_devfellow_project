@extends('layouts.app')

@section('content')
<div class="container">
    <h1>SuperAdmin Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}</p>

    <hr>
    <h3>Actions</h3>
    <ul>
        <li><a href="{{ route('schools.index') }}">Manage Schools</a></li>
    </ul>
</div>
@endsection
