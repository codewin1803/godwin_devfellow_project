@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Academic Sessions</h3>

    <a href="{{ route('sessions.create') }}" class="btn btn-primary mb-3">Add Session</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Session</th>
                <th>Status</th>
                <th>Activate</th>
            </tr>
        </thead>

        <tbody>
            @foreach($sessions as $s)
            <tr>
                <td>{{ $s->name }}</td>
                <td>
                    @if($s->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    @if(!$s->is_active)
                    <a href="{{ route('sessions.activate', $s) }}" class="btn btn-sm btn-success">
                        Activate
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
