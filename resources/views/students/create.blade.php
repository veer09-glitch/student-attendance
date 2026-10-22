@extends('layouts.main')

@section('content')
<h3>Add Student</h3>
<form action="{{ route('students.store') }}" method="POST" class="card card-body">
    @csrf
    <div class="mb-3">
        <label class="form-label">Roll No</label>
        <input type="text" name="roll_no" value="{{ old('roll_no') }}" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Class</label>
        <input type="text" name="class" value="{{ old('class') }}" class="form-control">
    </div>
    <div>
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection