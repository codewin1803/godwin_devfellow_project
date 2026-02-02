@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Finance Reports</h3>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Total Collected</h5>
                    <h3>₦{{ number_format($totalCollected, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5>Total Outstanding</h5>
                    <h3>₦{{ number_format($totalOutstanding, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Invoice</th>
                <th>Student</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice['invoice_number'] }}</td>
                <td>{{ $invoice['student'] }}</td>
                <td>₦{{ number_format($invoice['total'], 2) }}</td>
                <td>₦{{ number_format($invoice['paid'], 2) }}</td>
                <td>₦{{ number_format($invoice['balance'], 2) }}</td>
                <td>
                    <span class="badge bg-{{ $invoice['status'] === 'PAID' ? 'success' : 'warning' }}">
                        {{ $invoice['status'] }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
