<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceApiController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Invoice::with(['student', 'items', 'payments'])->get()
        );
    }
}
