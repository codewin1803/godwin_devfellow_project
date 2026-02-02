@extends('portal.layouts.portal')


@section('content')
<h4>Parent Dashboard</h4>


@foreach($students as $student)
<div class="card mb-3">
<div class="card-body">
<h6>{{ $student->user->name }}</h6>


<p>
Outstanding Fees:
{{ $invoices->where('student_id', $student->id)
->sum(fn($i) => $i->total - $i->payments_sum_amount) }}
</p>
</div>
</div>
@endforeach
@endsection
