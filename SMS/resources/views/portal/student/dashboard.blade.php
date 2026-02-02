@extends('portal.layouts.portal')


@section('content')
<h4>Student Dashboard</h4>


<div class="row">
<div class="col-md-4">
<div class="card">
<div class="card-body">
<h6>Attendance</h6>
<p>Present: {{ $attendanceSummary['PRESENT'] ?? 0 }}</p>
<p>Absent: {{ $attendanceSummary['ABSENT'] ?? 0 }}</p>
</div>
</div>
</div>


<div class="col-md-4">
<div class="card">
<div class="card-body">
<h6>Grades</h6>
<p>Total Subjects: {{ $grades->count() }}</p>
</div>
</div>
</div>


<div class="col-md-4">
<div class="card">
<div class="card-body">
<h6>Outstanding Fees</h6>
<p>
    {{ $invoices->sum(fn($i) => $i->total - $i->payments_sum_amount) }}
</p>

      </div>
    </div>
  </div>
 </div>
 @endsection
