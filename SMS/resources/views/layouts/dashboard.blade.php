@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">@yield('title')</h4>
    @yield('dashboard-content')
</div>
@endsection
