@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment Receipt</h2>

    <div class="card p-3">
        <p><strong>Student:</strong> {{ $payment->invoice->student->user->name }}</p>
        <p><strong>Invoice ID:</strong> {{ $payment->invoice->id }}</p>
        <p><strong>Term:</strong> {{ $payment->invoice->term->name }}</p>
        <p><strong>Amount Paid:</strong> {{ number_format($payment->amount, 2) }}</p>
        <p><strong>Payment Method:</strong> {{ $payment->method }}</p>
        <p><strong>Reference:</strong> {{ $payment->reference ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ $payment->created_at->format('d M, Y') }}</p>
        <p><strong>Balance:</strong> {{ number_format($payment->invoice->balance, 2) }}</p>
    </div>

    <a href="{{ route('invoices.show', $payment->invoice->id) }}" class="btn btn-secondary mt-3">Back to Invoice</a>
</div>
@endsection
