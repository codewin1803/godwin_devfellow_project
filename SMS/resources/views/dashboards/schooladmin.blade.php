@extends('layouts.dashboard')

@section('title', 'School Admin Dashboard')

@section('dashboard-content')

<div class="row">
    <x-kpi title="Students" :value="$students" />
    <x-kpi title="Teachers" :value="$teachers" />
    <x-kpi title="Invoices" :value="$invoices" />
    <x-kpi title="Revenue" :value="'₦'.number_format($revenue)" />
</div>

@endsection
