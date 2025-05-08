@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    .search-input {
    padding: 10px 15px;
    font-size: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    width: 300px;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #2196f3;
    box-shadow: 0 0 5px rgba(33, 150, 243, 0.5);
}

.btn-search {
    background: linear-gradient(to right, #2196f3, #00c6ff);
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-search:hover {
    background: linear-gradient(to right, #1976d2, #00acc1);
}

    body {
        background: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        display: flex;
        justify-content: center;
        padding: 40px 15px;
    }

    .card-box {
        width: 100%;
        max-width: 1200px;
        background: #ffffff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
    }

    .page-title {
        font-size: 26px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 30px;
        text-align: center;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px; /* ensures the layout holds even on smaller screens */
    }

    .table th {
        background: linear-gradient(to right, #2196f3, #00c6ff);
        color: #fff;
        padding: 15px;
        font-size: 16px;
        border: none;
        text-align: center;
    }

    .table td {
        padding: 14px;
        font-size: 15px;
        text-align: center;
        border-top: 1px solid #f0f0f0;
        background-color: #fff;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 14px;
        transition: background 0.3s;
    }

    .btn-edit:hover {
        background-color: #e0a800;
    }

    .btn-delete {
        background-color: #dc3545;
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 14px;
        transition: background 0.3s;
    }

    .btn-delete:hover {
        background-color: #bd2130;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-radius: 8px;
        padding: 12px 20px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: 500;
    }
</style>

<div class="container">
    <div class="card-box">
        <h2 class="page-title">
            <a href="{{ route('groups.index') }}" style="text-decoration: none; color: inherit;">
                <i class="fas fa-layer-group text-primary me-2"></i> All Groups
            </a>
        </h2>
        

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('groups.index') }}" method="GET" style="display: flex; justify-content: center; gap: 10px; margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Search groups..." value="{{ request('search') }}" class="search-input">
            <button type="submit" class="btn-search"><i class="fas fa-search"></i> Search</button>
        </form>
        

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Group Name</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($groups as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->user->name ?? 'N/A' }}</td>
                            <td>{{ $group->created_at->format('M d, Y') }}</td>
                            <td>
                                <div style="display: flex; justify-content: center; gap: 10px;">
                                    <a href="{{ route('groups.edit', $group->id) }}" class="btn-edit">✏️ Edit</a>
                            
                                    <form action="{{ route('groups.destroy', $group->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">🗑️ Delete</button>
                                    </form>
                                </div>
                            </td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No groups found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-4">
    {{ $groups->withQueryString()->links() }}
</div>

    </div>
</div>
@endsection
