<?php

namespace App\Http\Controllers;

use App\Models\PaymentRecord;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import Auth facade

class PaymentRecordController extends Controller
{
    public function index()
    {
        $payments = PaymentRecord::with(['invoice', 'invoice.student.user'])
            ->where('school_id', Auth::user()->school_id) // <-- replaced
            ->get();

        return view('payments.index', compact('payments'));
    }

    public function create($invoiceId)
    {
        $invoice = Invoice::where('school_id', Auth::user()->school_id) // <-- replaced
            ->findOrFail($invoiceId);

        return view('payments.create', compact('invoice'));
    }

    public function store(Request $request, $invoiceId)
    {
        $invoice = Invoice::where('school_id', Auth::user()->school_id) // <-- replaced
            ->findOrFail($invoiceId);

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string',
            'reference' => 'nullable|string',
        ]);

        PaymentRecord::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'method' => $request->method,
            'reference' => $request->reference,
            'school_id' => Auth::user()->school_id, // <-- replaced
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment recorded.');
    }

    public function show($id)
    {
        $payment = PaymentRecord::with(['invoice', 'invoice.student.user'])
            ->where('school_id', Auth::user()->school_id) // <-- replaced
            ->findOrFail($id);

        return view('payments.show', compact('payment'));
    }
}
