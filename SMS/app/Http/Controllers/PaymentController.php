<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request, $invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);

        $request->validate([
            'amount' => 'required|numeric|min:0'
        ]);

        $invoice->amount_paid += $request->amount;
        $invoice->balance = $invoice->total_amount - $invoice->amount_paid;

        if ($invoice->balance <= 0) {
            $invoice->status = 'paid';
        } elseif ($invoice->amount_paid > 0) {
            $invoice->status = 'partial';
        }

        $invoice->save();

        return back()->with('success', 'Payment recorded successfully.');
    }
}
