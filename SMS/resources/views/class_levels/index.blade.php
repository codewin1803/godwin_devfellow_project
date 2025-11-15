@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h4 class="mb-3">Class Levels</h4>

  {{-- Flash messages --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Add button --}}
  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addClassLevelModal">Add Class Level</button>

  {{-- Table --}}
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Code</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($classLevels as $index => $level)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $level->name }}</td>
            <td>{{ $level->code }}</td>
            <td>
              <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                      data-bs-target="#editClassLevelModal{{ $level->id }}">Edit</button>
              <form action="{{ route('class-levels.destroy', $level->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this class level?')">Delete</button>
              </form>
            </td>
          </tr>

          {{-- Edit Modal --}}
          <div class="modal fade" id="editClassLevelModal{{ $level->id }}" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="POST" action="{{ route('class-levels.update', $level->id) }}">
                  @csrf @method('PUT')
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Class Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input type="text" name="name" class="form-control" value="{{ $level->name }}" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Code</label>
                      <input type="text" name="code" class="form-control" value="{{ $level->code }}" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        @empty
          <tr><td colspan="4" class="text-center">No class levels yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addClassLevelModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('class-levels.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Class Level</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Code</label>
            <input type="text" name="code" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
