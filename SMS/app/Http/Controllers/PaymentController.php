<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Invoice $invoice)
    {
        return view('payments.create', compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Invoice $invoice)
    {
         $request->validate([
            'amount' => 'required|numeric|min:1',
            'method' => 'required|string',
            'paid_at' => 'required|date']);

             Payment::create([
            'invoice_id' => $invoice->getKey(),
            'amount' => $request->amount,
            'method' => $request->method,
            'reference' => $request->reference,
            'paid_at' => $request->paid_at,
            'created_by' => auth()->id,
            'school_id' => session('active_school')
        ]);

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Payment recorded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }


     public function receipt(Payment $payment)
    {
        return view('payments.receipt', compact('payment'));
    }
}
