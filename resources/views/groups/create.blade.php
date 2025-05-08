@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    html, body {
        height: 100%;
        margin: 0;
        background: linear-gradient(to right, #e0f7fa, #e1f5fe);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container-fluid {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-custom {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        width: 100%;
    }

    .card-custom:hover {
        transform: scale(1.01);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .icon-wrapper {
        background: linear-gradient(to right, #3f51b5, #2196f3);
        padding: 15px;
        border-radius: 50%;
        display: inline-block;
        color: #fff;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(63, 81, 181, 0.4);
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 12px;
        padding: 14px;
        font-size: 16px;
    }

    .form-control:focus {
        border-color: #2196f3;
        box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
    }

    .btn-custom {
        background: linear-gradient(to right, #2196f3, #21cbf3);
        color: #fff;
        border: none;
        font-weight: 600;
        padding: 12px;
        font-size: 18px;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: linear-gradient(to right, #1976d2, #00bcd4);
        box-shadow: 0 8px 20px rgba(33, 150, 243, 0.3);
        transform: translateY(-2px);
    }

    .alert-success {
        font-weight: 500;
        border-radius: 30px;
        background: #e0f7e9;
        color: #388e3c;
        border: 1px solid #a5d6a7;
    }

    .title {
        font-weight: 700;
        font-size: 24px;
        color: #2c3e50;
    }

    .subtitle {
        color: #7f8c8d;
        font-size: 14px;
    }

    .group-benefits {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .group-benefits h4 {
        font-weight: 700;
        color: #34495e;
    }

    .group-benefits ul {
        list-style: none;
        padding-left: 0;
        margin-top: 20px;
    }

    .group-benefits li {
        margin-bottom: 15px;
        font-size: 16px;
        color: #444;
    }

    .group-benefits li i {
        color: #2196f3;
        margin-right: 10px;
    }
</style>

<div class="container-fluid">
    <div class="row w-100">
        <!-- Left Side: Form -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="card card-custom w-75">
                <div class="text-center">
                    <div class="icon-wrapper">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h2 class="title">Create a New Group</h2>
                    <p class="subtitle">Organize your members by creating a new group</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success text-center mt-4">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('groups.store') }}" method="POST" class="mt-4">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag me-2 text-primary"></i>Group Name
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="Enter group name..." required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom">
                            <i class="fas fa-plus me-2"></i> Create Group
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: Extra Content -->
        <div class="col-md-6 d-flex align-items-center">
            <div class="group-benefits w-100">
                <h4><i class="fas fa-info-circle me-2 text-primary"></i>Why Create Groups?</h4>
                <ul>
                    <li><i class="fas fa-check-circle"></i> Organize users for better communication</li>
                    <li><i class="fas fa-check-circle"></i> Easily assign roles and permissions</li>
                    <li><i class="fas fa-check-circle"></i> Track activities per group</li>
                    <li><i class="fas fa-check-circle"></i> Send group announcements</li>
                    <li><i class="fas fa-check-circle"></i> Custom settings for each group</li>
                    <li><i class="fas fa-check-circle"></i> Streamlined collaboration and management</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
