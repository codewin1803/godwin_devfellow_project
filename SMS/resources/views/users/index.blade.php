@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-3">Users</h4>

    <form method="GET" action="{{ route('users.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search name or email"
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                @foreach(['SuperAdmin','SchoolAdmin','Teacher','Student','Parent','Bursar'] as $role)
                    <option value="{{ $role }}" @selected(request('role') == $role)>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" @selected(request('status')=='active')>Active</option>
                <option value="inactive" @selected(request('status')=='inactive')>Inactive</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Roles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->status) }}</td>
                    <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

</div>
@endsection
