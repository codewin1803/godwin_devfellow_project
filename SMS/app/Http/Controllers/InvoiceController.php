<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import Auth facade

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['student.user', 'items'])
            ->where('school_id', Auth::user()->school_id) // <-- replaced
            ->get();

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $students = StudentProfile::where('school_id', Auth::user()->school_id)->get(); // <-- replaced
        return view('invoices.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:student_profiles,id',
            'items' => 'required|array',
        ]);

        $invoice = Invoice::create([
            'student_id' => $request->student_id,
            'school_id' => Auth::user()->school_id, // <-- replaced
        ]);

        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'fee_category_id' => $item['fee_category_id'],
                'amount' => $item['amount'],
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created.');
    }

    public function show($id)
    {
        $invoice = Invoice::with(['items.category', 'student.user'])
            ->where('school_id', Auth::user()->school_id) // <-- replaced
            ->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }

    public function destroy($id)
    {
        Invoice::findOrFail($id)->delete();
        return back()->with('success', 'Invoice deleted.');
    }
}
