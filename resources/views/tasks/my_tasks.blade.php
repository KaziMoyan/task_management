@extends('layouts.app') 
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f6f9;">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0 p-5" style="border-radius: 30px; background-color: #0f90bf;">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center"
                     style="background: linear-gradient(to right, #00bfff, #1e90ff); color: white; border-radius: 16px 16px 0 0; box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1); padding: 1.25rem 1.5rem;">
                    
                    <h4 class="mb-2 mb-md-0 d-flex align-items-center gap-2" style="font-size: 1.6rem; font-weight: 700;">
                        <i class="fas fa-tasks" style="font-size: 1.3rem;"></i> My Tasks
                    </h4>
            
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('tasks.my') }}" class="d-flex flex-wrap gap-2 align-items-center">
                        <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control"
                               placeholder="Search my tasks..."
                               style="border-radius: 50px; padding: 10px 20px; width: 250px; background-color: #ffffff; border: 1px solid #ccc; color: #333; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);">
                        
                        <button type="submit" class="btn btn-outline-light"
                                style="font-weight: 600; border-radius: 50px; padding: 10px 20px; color: #fff; background-color: #28a745; border: none; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
            
                        <a href="{{ route('tasks.exportPdf') }}" class="btn btn-danger"
                           style="border-radius: 50px; padding: 10px 20px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </a>
                    <a>
                            {{-- Group Filter Dropdown --}}
                            <form method="GET" action="{{ route('tasks.my') }}" style="display: flex; gap: 8px; align-items: center;">
                              {{-- Retain search query --}}
                            <input type="hidden" name="search" value="{{ request('search') }}">
  
                               <select name="group_id" onchange="this.form.submit()" style="
                                border-radius: 20px;
                                padding: 8px 12px;
                                  border: none;
                                background-color: #fff;
                                color: #007bff;
                                 font-weight: 600;
                                  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
                                    ">
                                   <option value="">All Groups</option>
                                    @foreach($groups as $group)
                                   <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                                  {{ $group->name }}
                               </option>
                               @endforeach
                             </select>
                           </form>
                    </a>
                    </form>
                
  
                {{-- </div>
            </div>
             --}}
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success text-center" style="border-radius: 5px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle" 
                               style="border-radius: 12px; background-color: #f8f9fa; border: 3px solid #dee2e6; width: 100%;">
                            <thead class="table-success" style="background-color: #00bfff; color: white; font-weight: bold; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                <tr>
                                    <th style="padding: 12px 15px;">Task Name</th>
                                    <th style="padding: 12px 15px;">Short Description</th>
                                    <th style="padding: 12px 16px;">Group</th> <!-- New -->
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
                                        <td style="padding: 12px 16px;">{{ $task->group->name ?? 'N/A' }}</td> <!-- New -->
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
                                                <!-- Edit button -->
                                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-success" 
                                                   style="border-radius: 6px; padding: 8px 16px;">
                                                    <i class="fas fa-pen"></i> Edit
                                                </a>
                                                 <!-- View button -->
                                                <button type="button" class="btn btn-sm btn-outline-info view-task" data-task-id="{{ $task->id }}" 
                                                        style="border-radius: 6px; padding: 8px 16px;" title="View Task">
                                                    <i class="fas fa-eye"></i> View
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
    document.addEventListener('DOMContentLoaded', function () {
        // Hover effect for card-header
        const cardHeader = document.querySelector('.card-header');
        cardHeader.addEventListener('mouseenter', function() {
            cardHeader.style.background = 'linear-gradient(to right, #00bfff, #1e90ff)';
            cardHeader.style.boxShadow = '0 6px 12px rgba(0, 0, 0, 0.2)';
        });
        cardHeader.addEventListener('mouseleave', function() {
            cardHeader.style.background = 'linear-gradient(to right, #00bfff, #87cefa)';
            cardHeader.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        });

        // Focus effect for input fields
        const inputField = document.querySelector('.card-header .form-control');
        inputField.addEventListener('focus', function() {
            inputField.style.borderColor = '#28a745';
            inputField.style.boxShadow = '0 0 8px rgba(40, 167, 69, 0.2)';
        });
        inputField.addEventListener('blur', function() {
            inputField.style.borderColor = '#ddd';
            inputField.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
        });

        // Button hover effects
        const buttons = document.querySelectorAll('.card-header .btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                button.style.transform = 'translateY(-2px)';
                if (button.classList.contains('btn-danger')) {
                    button.style.backgroundColor = '#c82333';
                } else {
                    button.style.backgroundColor = '#218838';
                    button.style.color = 'white';
                }
            });
            button.addEventListener('mouseleave', function() {
                button.style.transform = 'translateY(0)';
                if (button.classList.contains('btn-danger')) {
                    button.style.backgroundColor = '';
                } else {
                    button.style.backgroundColor = '#f8f9fa';
                    button.style.color = '#28a745';
                }
            });
        });
    });
</script>

@endsection
