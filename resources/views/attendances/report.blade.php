@extends('layouts.main')

@section('content')
<h3>Attendance Report</h3>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-6">
        <select name="subject_id" class="form-select">
            <option value="">All Subjects</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 d-flex gap-2">
        <button class="btn btn-secondary">Show Report</button>
        <a href="{{ route('attendances.report') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr>
            <th>Roll No</th><th>Name</th><th>Total Lectures</th>
            <th>Present</th><th>Absent</th><th>Percentage</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($students as $student)
            @php
                $row = $totals[$student->id] ?? null;
                $total = $row ? $row->total : 0;
                $present = $row ? $row->present : 0;
                $percent = $total > 0 ? round(($present / $total) * 100, 1) : 0;
            @endphp
            <tr>
                <td>{{ $student->roll_no }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $total }}</td>
                <td>{{ $present }}</td>
                <td>{{ $total - $present }}</td>
                <td>
                    @if ($total == 0)
                        <span class="badge bg-secondary">No data</span>
                    @elseif ($percent >= 75)
                        <span class="badge bg-success">{{ $percent }}%</span>
                    @else
                        <span class="badge bg-danger">{{ $percent }}%</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No students found.</td></tr>
        @endforelse
    </tbody>
</table>
<p class="text-muted">Red means attendance is below 75%.</p>
@endsection