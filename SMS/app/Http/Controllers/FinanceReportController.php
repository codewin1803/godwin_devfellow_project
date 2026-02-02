<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class FinanceReportController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::withSum('payments', 'amount')
            ->with('student')
            ->get()
            ->map(function ($invoice) {
                $paid = $invoice->payments_sum_amount ?? 0;
                $total = $invoice->total_amount;

                return [
                    'invoice_number' => $invoice->invoice_number,
                    'student' => $invoice->student->user->name ?? 'N/A',
                    'total' => $total,
                    'paid' => $paid,
                    'balance' => $total - $paid,
                    'status' => ($total - $paid) <= 0 ? 'PAID' : 'PENDING',
                ];
            });

        $totalCollected = $invoices->sum('paid');
        $totalOutstanding = $invoices->sum('balance');

        return view('finance.reports.index', compact(
            'invoices',
            'totalCollected',
            'totalOutstanding'
        ));
    }

    public function export()
    {
        // Placeholder for CSV/PDF export (implemented next)
        return back()->with('success', 'Export feature coming next.');
    }
}
