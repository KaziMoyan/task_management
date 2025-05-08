@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f6f9;">
  <div class="row justify-content-center gx-0"><  {{-- gx-0 removes column gutters --}}
    <div class="col-12 px-0" style="max-width: 1200px; margin: auto;">  {{-- px-0 removes horizontal padding --}}
      <div class="card shadow-lg" style="border-radius: 12px; overflow: hidden;">
        {{-- Header --}}
        <div class="card-header d-flex justify-content-between align-items-center" style="
            background-color: #007bff;
            color: #fff;
            padding: 16px 24px;
          ">
         <h4 class="mb-0" style="display: flex; align-items: center; gap: 8px; font-weight: 500;">
            <a href="{{ route('tasks.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 8px;">
              <i class="fas fa-tasks"></i> All Tasks
            </a>
          </h4>
          <div style="display: flex; gap: 12px; align-items: center;">
            {{-- Search --}}
            <form method="GET" action="{{ route('tasks.index') }}" style="display: flex; gap: 8px;">
                <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search tasks..."
                style="
                  color: #000;                /* input text color */
                  border-radius: 20px;
                  border: none;
                  padding: 8px 16px;
                  width: 220px;
                  box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
                "
              >
              
              <button type="submit" style="
              background-color: #fff;
              color: #000;            /* make text black */
              border: none;
              border-radius: 20px;
              padding: 8px 16px;
              font-weight: 600;
          ">
            <i class="fas fa-search" style="margin-right: 6px; color: #000;"></i> Search
          </button>
       {{-- Group Filter Dropdown --}}
<form method="GET" action="{{ route('tasks.index') }}" style="display: flex; gap: 8px; align-items: center;">
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

            </form>
            {{-- Create --}}
            <a href="{{ route('tasks.create') }}" style="
                background-color: #fff;
                color: #28a745;
                border-radius: 20px;
                padding: 8px 16px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 6px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.1);
              ">
              <i class="fas fa-plus-circle"></i>Create Task
            </a>
          </div>
        </div>

        {{-- Body --}}
        <div class="card-body p-0">
          @if(session('success'))
            <div class="alert alert-success text-center m-0 p-3">
              {{ session('success') }}
            </div>
          @endif

          <div class="table-responsive" style="padding: 24px;">
            <table class="table mb-0" style="
                background-color: #fff;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                width: 100%;
              ">
              <thead style="background-color: #007bff; color: #fff;">
                <tr>
                  <th style="padding: 12px 16px;">Task Name</th>
                  <th style="padding: 12px 16px;">Description</th>
                  <th style="padding: 12px 16px;">Group</th> <!-- New -->
                  <th style="padding: 12px 16px;">Minutes</th>
                  <th style="padding: 12px 16px;">Date</th>
                  <th style="padding: 12px 16px;">Start</th>
                  <th style="padding: 12px 16px;">End</th>
                  <th style="padding: 12px 16px;">Status</th>
                  <th style="padding: 12px 16px; text-align:center;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($tasks as $task)
                  <tr onmouseover="this.style.backgroundColor='#f9f9f9';" onmouseout="this.style.backgroundColor='';" style="transition: background-color 0.2s;">
                    <td style="padding: 12px 16px;">{{ $task->name }}</td>
                    <td style="padding: 12px 16px;">{{ $task->short_description }}</td>
                    <td style="padding: 12px 16px;">{{ $task->group->name ?? 'N/A' }}</td> <!-- New -->
                    <td style="padding: 12px 16px;">{{ $task->minutes }}m</td>
                    <td style="padding: 12px 16px;">{{ $task->date }}</td>
                    <td style="padding: 12px 16px;">{{ $task->time_start }}</td>
                    <td style="padding: 12px 16px;">{{ $task->time_end }}</td>
                    <td style="padding: 12px 16px;">
                      @switch($task->status)
                        @case('pending')
                          <span style="background:#ffc107;color:#212529;padding:4px 8px;border-radius:12px;font-size:12px;">Pending</span>
                          @break
                        @case('in_progress')
                          <span style="background:#17a2b8;color:#fff;padding:4px 8px;border-radius:12px;font-size:12px;">In Progress</span>
                          @break
                        @case('completed')
                          <span style="background:#28a745;color:#fff;padding:4px 8px;border-radius:12px;font-size:12px;">Completed</span>
                          @break
                        @default
                          <span style="background:#6c757d;color:#fff;padding:4px 8px;border-radius:12px;font-size:12px;">Unknown</span>
                      @endswitch
                    </td>
                    <td style="padding: 12px 16px; text-align:center;">
                      <div style="display:inline-flex; gap:8px; justify-content:center;">
                        <a href="{{ route('tasks.edit',$task->id) }}" style="
                            background:#007bff;color:#fff;padding:6px 12px;border-radius:6px;font-size:14px;
                          ">
                          <i class="fas fa-edit" style="margin-right:4px;"></i>Edit
                        </a>
                        <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" style="display:inline;">
                          @csrf @method('DELETE')
                          <button type="submit" style="
                              background:#dc3545;color:#fff;padding:6px 12px;border:none;border-radius:6px;font-size:14px;
                            " onclick="return confirm('Delete this task?');">
                            <i class="fas fa-trash-alt" style="margin-right:4px;"></i>Delete
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          <div class="d-flex justify-content-center p-3">
            {{ $tasks->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
