@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card shadow" style="border-radius: 16px;">
            <!-- Updated Card Header -->
            <div class="card-header" style="
            background-color: #007bff;
            color: white;
            font-size: 20px;
            padding: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
        ">
            <i class="fas fa-tasks" style="margin-right: 8px;"></i>
            Edit Task
        </div>
        

            <!-- Card Body -->
            <div class="card-body" style="background-color: #f8f9fa;">
                @if ($errors->any())
                    <div class="alert alert-danger text-start">
                        <strong>Whoops!</strong> Please fix the following:
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form to Update Task -->
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @php
                        $inputStyle = 'width: 100%; border-radius: 10px; padding: 10px; font-size: 15px;';
                        $wrapperStyle = 'width: 60%; margin: 10px auto;';
                        $labelStyle = 'font-weight: 600; margin-bottom: 6px; display: block; text-align: left;';
                    @endphp

                    <!-- Task Name -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="name" style="{{ $labelStyle }}">Task Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $task->name) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="short_description" style="{{ $labelStyle }}">Short Description</label>
                        <input type="text" name="short_description" class="form-control" value="{{ old('short_description', $task->short_description) }}" style="{{ $inputStyle }}" required>
                    </div>
                    <!-- Group -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="group_id" style="{{ $labelStyle }}">Group</label>
                        <select name="group_id" class="form-select" style="{{ $inputStyle }}" required>
                        <option value="" disabled selected>Select Group</option>
                        @foreach ($groups as $group)
                        <option value="{{ $group->id }}" {{ $task->group_id == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                        </option>
                        @endforeach
                        </select>
                    </div>


                    <!-- Explanation -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="description" style="{{ $labelStyle }}">Explanation (Optional)</label>
                        <textarea name="description" rows="2" class="form-control" style="{{ $inputStyle }}">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <!-- Note -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="note" style="{{ $labelStyle }}">Note (Optional)</label>
                        <textarea name="note" rows="2" class="form-control" style="{{ $inputStyle }}">{{ old('note', $task->note) }}</textarea>
                    </div>

                    <!-- Link -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="link" style="{{ $labelStyle }}">Link (Optional)</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link', $task->link) }}" style="{{ $inputStyle }}">
                    </div>

                    <!-- Estimated Minutes -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="minutes" style="{{ $labelStyle }}">Estimated Minutes</label>
                        <input type="number" name="minutes" class="form-control" value="{{ old('minutes', $task->minutes) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <!-- Task Date -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="date" style="{{ $labelStyle }}">Task Date</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $task->date) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <!-- Start Time -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="time_start" style="{{ $labelStyle }}">Start Time</label>
                        <input type="time" name="time_start" class="form-control" value="{{ old('time_start', $task->time_start) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <!-- End Time -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="time_end" style="{{ $labelStyle }}">End Time</label>
                        <input type="time" name="time_end" class="form-control" value="{{ old('time_end', $task->time_end) }}" style="{{ $inputStyle }}" required>
                    </div>

                    <!-- Status -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <label for="status" style="{{ $labelStyle }}">Status</label>
                        <select name="status" class="form-select" style="{{ $inputStyle }}" required>
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3" style="{{ $wrapperStyle }}">
                        <button type="submit" class="btn btn-primary" 
                            style="border-radius: 10px; padding: 10px 30px; font-size: 16px; background-color: #007bff; border: none; transition: background-color 0.3s;">
                            Update Task
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
