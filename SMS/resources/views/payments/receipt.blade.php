@extends('layouts.app')

@section('content')
<div class="container border p-4">
    <h4 class="text-center">Payment Receipt</h4>
    <hr>

    <p><strong>Student:</strong> {{ $payment->invoice->student->user->name }}</p>
    <p><strong>Invoice #:</strong> {{ $payment->invoice->id }}</p>
    <p><strong>Amount Paid:</strong> ₦{{ number_format($payment->amount,2) }}</p>
    <p><strong>Method:</strong> {{ $payment->method }}</p>
    <p><strong>Reference:</strong> {{ $payment->reference }}</p>
    <p><strong>Date:</strong> {{ $payment->paid_at }}</p>

    <button onclick="window.print()" class="btn btn-primary mt-3">Print Receipt</button>
</div>
@endsection
