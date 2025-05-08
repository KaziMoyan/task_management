@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; margin: 0;">
    <div class="col-md-6">
        <div class="card shadow" style="border-radius: 12px;">
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
            Create Task
        </div>
        
            <div class="card-body" style="background-color: #f8f9fa; padding: 20px;">
                @if ($errors->any())
                    <div class="alert alert-danger text-start" style="margin-bottom: 10px;">
                        <strong>Whoops!</strong> Please correct the following errors:
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    @php 
                        $inputStyle = 'width: 100%; border-radius: 8px; padding: 12px; margin-bottom: 15px; font-size: 14px;';
                        $labelStyle = 'font-weight: bold; margin-bottom: 10px; display: block; text-align: left;';
                    @endphp

                    <div class="mb-3">
                        <label for="name" style="{{ $labelStyle }}">Task Name</label>
                        <input type="text" name="name" class="form-control" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="user_id" style="{{ $labelStyle }}">Assign to User</label>
                        <select name="user_id" id="user_id" class="form-select" style="{{ $inputStyle }}" required>
                            <option value="" disabled selected>Select a user</option>
                            @foreach($users as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="group_id" style="{{ $labelStyle }}">Group</label>
                        <select name="group_id" id="group_id" class="form-select" style="{{ $inputStyle }}" required>
                            <option value="">-- Select Group --</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" style="{{ $labelStyle }}">Short Description</label>
                        <input type="text" name="short_description" class="form-control" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" style="{{ $labelStyle }}">Explanation (Optional)</label>
                        <textarea name="description" rows="2" class="form-control" style="{{ $inputStyle }}"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="note" style="{{ $labelStyle }}">Note (Optional)</label>
                        <textarea name="note" rows="2" class="form-control" style="{{ $inputStyle }}"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="link" style="{{ $labelStyle }}">Link (Optional)</label>
                        <input type="url" name="link" class="form-control" style="{{ $inputStyle }}">
                    </div>

                    <div class="mb-3">
                        <label for="minutes" style="{{ $labelStyle }}">Estimated Minutes</label>
                        <input type="number" name="minutes" class="form-control" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="date" style="{{ $labelStyle }}">Task Date</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="time_start" style="{{ $labelStyle }}">Start Time</label>
                        <input type="time" name="time_start" class="form-control" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="time_end" style="{{ $labelStyle }}">End Time</label>
                        <input type="time" name="time_end" class="form-control" style="{{ $inputStyle }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" style="{{ $labelStyle }}">Status</label>
                        <select name="status" class="form-select" style="{{ $inputStyle }}" required>
                            <option value="pending" selected>Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success mt-3" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 8px; transition: background-color 0.3s;">
                            <i class="fas fa-check-circle"></i> Submit Task
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
    .btn-success:hover {
        background-color: #28a745;
        color: rgb(255, 255, 255);
    }

    /* Adjust the card padding */
    .card-body {
        padding: 20px;
    }

    /* Ensure the form container takes up half the page and is centered */
    .container {
        padding: 0;
    }

    .col-md-6 {
        max-width: 50%;
        margin: auto;
    }
</style>
