@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Finance Report</h2>

    <div class="mb-3">
        <p><strong>Total Collected:</strong> {{ number_format($totalCollected, 2) }}</p>
        <p><strong>Total Outstanding:</strong> {{ number_format($totalOutstanding, 2) }}</p>
        <a href="{{ route('finance.export') }}" class="btn btn-success">Export Excel</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Student</th>
                <th>Total Amount</th>
                <th>Paid</th>
                <th>Outstanding</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->student->user->name ?? 'N/A' }}</td>
                <td>{{ number_format($invoice->amount, 2) }}</td>
                <td>{{ number_format($invoice->payments_sum_amount ?? 0, 2) }}</td>
                <td>{{ number_format($invoice->amount - ($invoice->payments_sum_amount ?? 0), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
