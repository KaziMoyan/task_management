@extends('layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f6f9;">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg" style="border-radius: 12px; background-color: #ffffff; border: 1px solid #dee2e6;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #28a745; color: white; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h4 class="mb-0"><i class="fas fa-user-check"></i> My Tasks</h4>             
                    <form method="GET" action="{{ route('tasks.my') }}" class="d-flex align-items-center gap-2">
                        <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control" placeholder="Search my tasks..." style="border-radius: 6px; padding: 8px 16px; width: 250px; color: black;">
                        <button type="submit" class="btn btn-light" style="font-weight: bold; border-radius: 5px; padding: 8px 16px; color: black;">
                            <i class="fas fa-search" style="color: black;"></i> Search
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
                                                    <span class="badge bg-warning text-black">Pending</span>
                                                    @break
                                                @case('in_progress')
                                                    <span class="badge bg-info text-black">In Progress</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-success text-black">Completed</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary text-black">Unknown</span>
                                            @endswitch
                                        </td>
                                        
                                        <td style="padding: 12px 15px;">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Pen icon for editing -->
                                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-success" style="border-radius: 6px;">
                                                    <i class="fas fa-pen"></i> <!-- Pen icon -->
                                                </a>
                                                
                                                <button type="button" 
                                                    class="btn btn-sm btn-outline-info view-task" 
                                                    data-task-id="{{ $task->id }}" 
                                                    style="border-radius: 6px;" 
                                                    title="View Task">
                                                    <i class="fas fa-eye"></i>
                                                </button>
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

                    <div class="d-flex justify-content-center mt-3">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="taskModalLabel"><i class="fas fa-eye"></i> Task Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="taskDetails">
                    <!-- Content will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $('.view-task').click(function () {
            const taskId = $(this).data('task-id');

            $.ajax({
                url: '/tasks/' + taskId,
                method: 'GET',
                success: function (response) {
                    // Assuming 'response' contains HTML for the task details
                    $('#taskDetails').html(response);
                    $('#taskModal').modal('show');
                },
                error: function () {
                    $('#taskDetails').html('<div class="alert alert-danger">Failed to load task details.</div>');
                    $('#taskModal').modal('show');
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function () {
        $('.view-task').on('click', function () {
            var taskId = $(this).data('task-id');

            // Show the modal first (with a loader while content loads)
            $('#taskDetails').html('<div class="text-center p-4">Loading...</div>');
            $('#taskModal').modal('show');

            // Load content via AJAX from the full blade view
            $.ajax({
                url: '/tasks/' + taskId,
                type: 'GET',
                success: function (response) {
                    $('#taskDetails').html(response);
                },
                error: function () {
                    $('#taskDetails').html('<div class="alert alert-danger">Failed to load task details.</div>');
                }
            });
        });
    });
</script>

@endsection
