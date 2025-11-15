<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinanceReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Invoice::withSum('payments', 'amount')->get()->map(function($invoice){
            return [
                'Invoice #' => $invoice->id,
                'Student' => $invoice->student->user->name ?? 'N/A',
                'Total Amount' => $invoice->amount,
                'Paid' => $invoice->payments_sum_amount ?? 0,
                'Outstanding' => $invoice->amount - ($invoice->payments_sum_amount ?? 0),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Invoice #', 'Student', 'Total Amount', 'Paid', 'Outstanding',
        ];
    }
}
