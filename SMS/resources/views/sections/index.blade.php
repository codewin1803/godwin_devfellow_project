@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h4 class="mb-3">Sections</h4>

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

  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSectionModal">Add Section</button>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Section Name</th>
          <th>Class Level</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sections as $index => $section)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $section->name }}</td>
            <td>{{ $section->classLevel->name ?? 'N/A' }}</td>
            <td>
              <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                      data-bs-target="#editSectionModal{{ $section->id }}">Edit</button>
              <form action="{{ route('sections.destroy', $section->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this section?')">Delete</button>
              </form>
            </td>
          </tr>

          {{-- Edit Modal --}}
          <div class="modal fade" id="editSectionModal{{ $section->id }}" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="POST" action="{{ route('sections.update', $section->id) }}">
                  @csrf @method('PUT')
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input type="text" name="name" class="form-control" value="{{ $section->name }}" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Class Level</label>
                      <select name="class_level_id" class="form-select" required>
                        @foreach($classLevels as $level)
                          <option value="{{ $level->id }}" @if($section->class_level_id == $level->id) selected @endif>
                            {{ $level->name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        @empty
          <tr><td colspan="4" class="text-center">No sections yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addSectionModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('sections.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Section</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Section Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Class Level</label>
            <select name="class_level_id" class="form-select" required>
              @foreach($classLevels as $level)
                <option value="{{ $level->id }}">{{ $level->name }}</option>
              @endforeach
            </select>
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
