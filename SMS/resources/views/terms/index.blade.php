@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Terms</h3>

    <a href="{{ route('terms.create') }}" class="btn btn-primary mb-3">Add Term</a>

    @foreach($sessions as $session)
        <h4 class="mt-3">{{ $session->name }}</h4>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Term</th>
                <th>Status</th>
                <th>Activate</th>
            </tr>
            </thead>

            <tbody>
            @foreach($session->terms as $term)
                <tr>
                    <td>{{ $term->name }}</td>
                    <td>
                        @if($term->is_active)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        @if(!$term->is_active)
                        <a href="{{ route('terms.activate', $term) }}" class="btn btn-sm btn-success">
                            Activate
                        </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
</div>
@endsection
