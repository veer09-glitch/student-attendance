@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Attendance Records</h3>
    <a href="{{ route('attendances.create') }}" class="btn btn-primary">+ Mark Attendance</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <select name="subject_id" class="form-select">
            <option value="">All Subjects</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <input type="date" name="date" value="{{ request('date') }}" class="form-control">
    </div>
    <div class="col-md-4 d-flex gap-2">
        <button class="btn btn-secondary">Filter</button>
        <a href="{{ route('attendances.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr><th>Date</th><th>Roll No</th><th>Student</th><th>Subject</th><th>Status</th><th width="100">Action</th></tr>
    </thead>
    <tbody>
        @forelse ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->student->roll_no }}</td>
                <td>{{ $attendance->student->name }}</td>
                <td>{{ $attendance->subject->name }}</td>
                <td>
                    @if ($attendance->status == 'present')
                        <span class="badge bg-success">Present</span>
                    @else
                        <span class="badge bg-danger">Absent</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('attendances.destroy', $attendance) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No attendance records found.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $attendances->links() }}
@endsection