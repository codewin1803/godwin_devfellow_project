<h2>Academic Sessions</h2>

<form method="POST" action="/sessions/store">
    @csrf
    <input type="text" name="name" placeholder="2024/2025" required>
    <button type="submit">Add Session</button>
</form>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach ($sessions as $s)
    <tr>
        <td>{{ $s->name }}</td>
        <td>{{ $s->is_active ? 'Active' : 'Inactive' }}</td>
        <td>
            @if(!$s->is_active)
            <a href="/sessions/{{ $s->id }}/activate">Activate</a>
            @else
            Active
            @endif
        </td>
    </tr>
    @endforeach
</table>
