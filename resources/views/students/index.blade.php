@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Students</h3>
    <a href="{{ route('students.create') }}" class="btn btn-primary">+ Add Student</a>
</div>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name or roll no">
    <button class="btn btn-secondary">Search</button>
</form>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr><th>Roll No</th><th>Name</th><th>Class</th><th width="180">Action</th></tr>
    </thead>
    <tbody>
        @forelse ($students as $student)
            <tr>
                <td>{{ $student->roll_no }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->class }}</td>
                <td>
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this student?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">No students found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $students->links() }}
@endsection