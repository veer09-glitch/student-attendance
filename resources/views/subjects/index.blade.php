@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Subjects</h3>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ Add Subject</a>
</div>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name or code">
    <button class="btn btn-secondary">Search</button>
</form>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr><th>Code</th><th>Name</th><th width="180">Action</th></tr>
    </thead>
    <tbody>
        @forelse ($subjects as $subject)
            <tr>
                <td>{{ $subject->code }}</td>
                <td>{{ $subject->name }}</td>
                <td>
                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this subject?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center">No subjects found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $subjects->links() }}
@endsection