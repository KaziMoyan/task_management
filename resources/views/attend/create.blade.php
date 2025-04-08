@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <h3 class="text-center mb-4">Mark Attendance</h3>

    <form action="{{ route('attend.store') }}" method="POST">
        @csrf

        <!-- These are just display inputs -->
        <div class="mb-3">
            <label class="form-label">User ID</label>
            <input type="text" class="form-control" value="{{ auth()->id() }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Today's Date</label>
            <input type="text" class="form-control" value="{{ now()->toDateString() }}" disabled>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit Attendance</button>
    </form>
</div>
@endsection
