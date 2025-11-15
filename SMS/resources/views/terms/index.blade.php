<h2>Terms</h2>

@if(!$activeSession)
<p style="color:red">No active academic session!</p>
@else
<p>Active Session: <strong>{{ $activeSession->name }}</strong></p>
@endif

<form method="POST" action="/terms/store">
    @csrf
    <input type="text" name="name" placeholder="First Term" required>

    <select name="academic_session_id">
        <option value="{{ $activeSession->id }}">{{ $activeSession->name }}</option>
    </select>

    <button type="submit">Add Term</button>
</form>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Session</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach ($terms as $t)
    <tr>
        <td>{{ $t->name }}</td>
        <td>{{ $t->session->name }}</td>
        <td>{{ $t->is_active ? 'Active' : 'Inactive' }}</td>
        <td>
            @if(!$t->is_active)
            <a href="/terms/{{ $t->id }}/activate">Activate</a>
            @endif
        </td>
    </tr>
    @endforeach
</table>
