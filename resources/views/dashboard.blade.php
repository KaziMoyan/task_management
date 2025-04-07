@extends('layouts.app')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 d-flex justify-content-center">
            <div class="content" style="padding: 40px; width: 80%; text-align: center;">
                <h2 style="font-size: 30px; color: #343a40;">
                    <i class="fas fa-home" style="color: #007bff;"></i> Welcome to your Dashboard!
                </h2>
                <p class="lead" style="font-size: 18px; color: #6c757d;">Manage your tasks and see your progress right here!</p>
            </div>
        </div>
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar" style="background-color: #f8f9fa; border-right: 2px solid #ddd; padding: 20px;">
                <h4 class="text-center mb-4" style="font-size: 24px; color: #343a40;">
                    <i class="fas fa-tasks" style="color: #007bff;"></i> Dashboard Menu
                </h4>
                <div class="list-group">
                    <a href="{{ route('tasks.create') }}" class="list-group-item list-group-item-action" 
                       style="border: none; background-color: #e9ecef; padding: 12px 20px; font-size: 16px; text-align: left; color: #007bff;">
                       <i class="fas fa-plus-circle" style="color: #28a745;"></i> Create Task
                    </a>
                    <a href="{{ route('tasks.index') }}" class="list-group-item list-group-item-action"
                       style="border: none; background-color: #e9ecef; padding: 12px 20px; font-size: 16px; text-align: left; color: #007bff;">
                       <i class="fas fa-list-ul" style="color: #ffc107;"></i> All Tasks
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area centered in the middle -->
       
    </div>
</div>
@endsection
