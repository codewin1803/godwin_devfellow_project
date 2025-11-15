<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinanceReportExport;

class FinanceController extends Controller
{
    // Display finance summary
    public function index()
    {
        // Get all invoices with total payments
        $invoices = Invoice::withSum('payments', 'amount')->get();

        // Calculate total collected and total outstanding
        $totalCollected = $invoices->sum('payments_sum_amount');
        $totalOutstanding = $invoices->sum(function($invoice) {
            return $invoice->amount - ($invoice->payments_sum_amount ?? 0);
        });

        return view('finance.index', compact('invoices', 'totalCollected', 'totalOutstanding'));
    }

    // Export finance report to Excel
    public function export()
    {
        return Excel::download(new FinanceReportExport, 'finance_report.xlsx');
    }
}
