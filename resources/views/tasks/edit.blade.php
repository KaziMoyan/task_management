@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Task</h1>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Task Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $task->name) }}" required>
            </div>

            <div class="form-group">
                <label for="short_description">Short Description</label>
                <input type="text" id="short_description" name="short_description" class="form-control" value="{{ old('short_description', $task->short_description) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="minutes">Time (minutes)</label>
                <input type="number" id="minutes" name="minutes" class="form-control" value="{{ old('minutes', $task->minutes) }}" required>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $task->date) }}" required>
            </div>

            <div class="form-group">
                <label for="time_start">Start Time</label>
                <input type="time" id="time_start" name="time_start" class="form-control" value="{{ old('time_start', $task->time_start) }}" required>
            </div>

            <div class="form-group">
                <label for="time_end">End Time</label>
                <input type="time" id="time_end" name="time_end" class="form-control" value="{{ old('time_end', $task->time_end) }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
@endsection
