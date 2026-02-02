@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Record Payment</h4>

    <p><strong>Invoice Total:</strong> ₦{{ number_format($invoice->total_amount,2) }}</p>
    <p><strong>Outstanding:</strong> ₦{{ number_format($invoice->balance,2) }}</p>

    <form method="POST" action="{{ route('payments.store', $invoice) }}">
        @csrf

        <div class="mb-3">
            <label>Amount Paid</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Payment Method</label>
            <select name="method" class="form-control">
                <option>Cash</option>
                <option>Transfer</option>
                <option>POS</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Reference</label>
            <input type="text" name="reference" class="form-control">
        </div>

        <div class="mb-3">
            <label>Date Paid</label>
            <input type="date" name="paid_at" class="form-control" required>
        </div>

        <button class="btn btn-success">Save Payment</button>
    </form>
</div>
@endsection
