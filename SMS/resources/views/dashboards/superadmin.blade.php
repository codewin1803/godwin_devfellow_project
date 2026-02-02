@extends('layouts.dashboard')

@section('title', 'Super Admin Dashboard')

@section('dashboard-content')

<div class="row">
    <x-kpi title="Schools" :value="$schools" />
    <x-kpi title="Students" :value="$students" />
    <x-kpi title="Teachers" :value="$teachers" />
    <x-kpi title="Total Revenue" :value="'₦'.number_format($revenue)" />
</div>

<div class="card mt-4">
    <div class="card-header">Monthly Revenue</div>
    <div class="card-body">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyRevenue->keys()) !!},
        datasets: [{
            label: 'Revenue',
            data: {!! json_encode($monthlyRevenue->values()) !!}
        }]
    }
});
</script>
@endpush
