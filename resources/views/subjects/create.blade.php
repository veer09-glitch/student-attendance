@extends('layouts.main')

@section('content')
<h3>Add Subject</h3>
<form action="{{ route('subjects.store') }}" method="POST" class="card card-body">
    @csrf
    <div class="mb-3">
        <label class="form-label">Subject Code</label>
        <input type="text" name="code" value="{{ old('code') }}" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Subject Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
    </div>
    <div>
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection