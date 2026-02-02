<?php
namespace App\Http\Controllers\Portal;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Invoice;


class ParentDashboardController extends Controller
{
public function index()
{
$parent = Auth::user()->parentProfile;
$students = $parent->students;


$studentIds = $students->pluck('id');


$attendance = Attendance::whereIn('student_id', $studentIds)->get();
$grades = Grade::whereIn('student_id', $studentIds)->get();
$invoices = Invoice::whereIn('student_id', $studentIds)
->withSum('payments', 'amount')
->get();


return view('portal.parent.dashboard', compact(
'students', 'attendance', 'grades', 'invoices'
));
}
}
