@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f6f9;">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg" style="border-radius: 12px; background-color: #ffffff; border: 1px solid #dee2e6;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #28a745; color: white; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h4 class="mb-0"><i class="fas fa-user-check"></i> My Tasks</h4>

                 
                    <form method="GET" action="{{ route('tasks.my') }}" class="d-flex align-items-center gap-2">
                        <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control" placeholder="Search my tasks..." style="border-radius: 6px; padding: 8px 16px; width: 250px;">
                        <button type="submit" class="btn btn-light" style="font-weight: bold; border-radius: 5px; padding: 8px 16px;">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success text-center" style="border-radius: 5px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle" style="border-radius: 12px; background-color: #f8f9fa; border: 1px solid #dee2e6; width: 100%;">
                            <thead class="table-success" style="background-color: #28a745; color: white; font-weight: bold; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                <tr>
                                    <th style="padding: 12px 15px;">Task Name</th>
                                    <th style="padding: 12px 15px;">Short Description</th>
                                    <th style="padding: 12px 15px;">Estimated Minutes</th>
                                    <th style="padding: 12px 15px;">Task Date</th>
                                    <th style="padding: 12px 15px;">Start Time</th>
                                    <th style="padding: 12px 15px;">End Time</th>
                                    <th style="padding: 12px 15px;">Status</th>
                                    <th style="width: 150px; padding: 12px 15px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                    <tr style="background-color: #ffffff; border-bottom: 2px solid #dee2e6; vertical-align: middle;">
                                        <td style="padding: 12px 15px;">{{ $task->name }}</td>
                                        <td style="padding: 12px 15px;">{{ $task->short_description }}</td>
                                        <td style="padding: 12px 15px;">{{ $task->minutes }} mins</td>
                                        <td style="padding: 12px 15px;">{{ $task->date }}</td>
                                        <td style="padding: 12px 15px;">{{ $task->time_start }}</td>
                                        <td style="padding: 12px 15px;">{{ $task->time_end }}</td>
                                        <td style="padding: 12px 15px;">
                                            @switch($task->status)
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                    @break
                                                @case('in_progress')
                                                    <span class="badge bg-info text-dark">In Progress</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-success text-white">Completed</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary text-white">Unknown</span>
                                            @endswitch
                                        </td>
                                        <td style="padding: 12px 15px;">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary" style="border-radius: 6px;">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="margin-bottom: 0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 6px;" onclick="return confirm('Are you sure you want to delete this task?')">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No tasks found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
