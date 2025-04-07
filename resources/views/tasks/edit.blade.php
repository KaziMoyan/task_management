@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card shadow" style="border-radius: 12px;">
            <div class="card-header text-center" style="background-color: #007bff; color: white; font-size: 24px;">
                <i class="fas fa-edit"></i> Edit Task
            </div>

            <div class="card-body" style="background-color: #f8f9fa;">
                @if ($errors->any())
                    <div class="alert alert-danger text-start">
                        <strong>Whoops!</strong> Please correct the following errors:
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @php
                        $inputStyle = 'width: 100%; border-radius: 8px; padding: 10px;';
                        $wrapperStyle = 'width: 80%; margin: 0 auto;';
                        $labelStyle = 'font-weight: bold; margin-bottom: 5px; display: block; text-align: center;';
                    @endphp

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="name" style="{{ $labelStyle }}">Task Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $task->name) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="short_description" style="{{ $labelStyle }}">Short Description</label>
                        <input type="text" name="short_description" class="form-control" value="{{ old('short_description', $task->short_description) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="description" style="{{ $labelStyle }}">Explanation (Optional)</label>
                        <textarea name="description" rows="3" class="form-control" style="{{ $inputStyle }}">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="note" style="{{ $labelStyle }}">Note (Optional)</label>
                        <textarea name="note" rows="3" class="form-control" style="{{ $inputStyle }}">{{ old('note', $task->note) }}</textarea>
                    </div>

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="link" style="{{ $labelStyle }}">Link (Optional)</label>
                        <input type="url" name="link" value="{{ old('link', $task->link) }}" class="form-control" style="{{ $inputStyle }}">
                    </div>

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="minutes" style="{{ $labelStyle }}">Estimated Minutes</label>
                        <input type="number" name="minutes" class="form-control" value="{{ old('minutes', $task->minutes) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="date" style="{{ $labelStyle }}">Task Date</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $task->date) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="time_start" style="{{ $labelStyle }}">Start Time</label>
                        <input type="time" name="time_start" class="form-control" value="{{ old('time_start', $task->time_start) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="time_end" style="{{ $labelStyle }}">End Time</label>
                        <input type="time" name="time_end" class="form-control" value="{{ old('time_end', $task->time_end) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="status" style="{{ $labelStyle }}">Status</label>
                        <select name="status" class="form-select" style="{{ $inputStyle }}" required>
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3" style="width: 80%; padding: 12px; font-size: 18px; border-radius: 8px;">
                            <i class="fas fa-save"></i> Update Task
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
