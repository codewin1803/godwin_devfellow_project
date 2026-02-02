namespace App\Http\Controllers\Portal;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Invoice;


class StudentDashboardController extends Controller
{
public function index()
{
$student = Auth::user()->studentProfile;


$attendanceSummary = Attendance::where('student_id', $student->id)
->selectRaw('status, COUNT(*) as total')
->groupBy('status')
->pluck('total', 'status');


$grades = Grade::where('student_id', $student->id)->get();


$invoices = Invoice::where('student_id', $student->id)
->withSum('payments', 'amount')
->get();


return view('portal.student.dashboard', compact('attendanceSummary', 'grades', 'invoices'));
}
}
