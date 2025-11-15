@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Invoice #{{ $invoice->id }} for {{ $invoice->student->user->name }}</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fee Category</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total:</strong> {{ number_format($invoice->total_amount, 2) }}</p>
    <p><strong>Paid:</strong> {{ number_format($invoice->amount_paid, 2) }}</p>
    <p><strong>Balance:</strong> {{ number_format($invoice->balance, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>

    @if($invoice->balance > 0)
        <a href="{{ route('payments.create', $invoice->id) }}" class="btn btn-success mt-2">Record Payment</a>
    @endif

    <a href="{{ route('invoices.index') }}" class="btn btn-secondary mt-2">Back to Invoices</a>
</div>
@endsection
