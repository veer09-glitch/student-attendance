@extends('layouts.main')

@section('content')
<h3>Mark Attendance</h3>

<form method="GET" action="{{ route('attendances.create') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <select name="subject_id" class="form-select" required>
            <option value="">Select Subject</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ $subjectId == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <input type="date" name="date" value="{{ $date }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <button class="btn btn-secondary">Load Students</button>
    </div>
</form>

@if ($subjectId)
    @if ($students->isEmpty())
        <div class="alert alert-warning">No students found. Please add students first.</div>
    @else
        <form action="{{ route('attendances.store') }}" method="POST">
            @csrf
            <input type="hidden" name="subject_id" value="{{ $subjectId }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <table class="table table-bordered bg-white">
                <thead class="table-dark">
                    <tr><th>Roll No</th><th>Name</th><th>Class</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        @php $current = $existing[$student->id] ?? 'present'; @endphp
                        <tr>
                            <td>{{ $student->roll_no }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->class }}</td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status[{{ $student->id }}]"
                                           id="p{{ $student->id }}" value="present" {{ $current == 'present' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="p{{ $student->id }}">Present</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status[{{ $student->id }}]"
                                           id="a{{ $student->id }}" value="absent" {{ $current == 'absent' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="a{{ $student->id }}">Absent</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button class="btn btn-primary">Save Attendance</button>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    @endif
@endif
@endsection