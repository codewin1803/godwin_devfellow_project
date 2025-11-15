@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Record Payment for {{ $invoice->student->user->name }}</h2>

    <form action="{{ route('payments.store', $invoice->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" value="{{ $invoice->balance }}" required>
        </div>

        <div class="form-group">
            <label>Payment Method</label>
            <select name="method" class="form-control" required>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Mobile Payment">Mobile Payment</option>
            </select>
        </div>

        <div class="form-group">
            <label>Reference (Optional)</label>
            <input type="text" name="reference" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-2">Record Payment</button>
    </form>
</div>
@endsection
