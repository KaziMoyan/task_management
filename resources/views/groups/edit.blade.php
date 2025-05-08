@extends('layouts.app')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    body {
        background: #f4f6f9;
    }

    .edit-wrapper {
        background: #fff;
        border-radius: 15px;
        padding: 40px;
        max-width: 600px;
        margin: 50px auto;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .page-title {
        font-size: 26px;
        font-weight: bold;
        color: #2c3e50;
    }

    .form-control {
        border-radius: 10px;
        height: 45px;
        font-size: 16px;
    }

    .btn-primary {
        background: #2196f3;
        border: none;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: bold;
        font-size: 16px;
    }

    .btn-primary:hover {
        background: #1e88e5;
    }
</style>

<div class="edit-wrapper">
    <h2 class="text-center page-title mb-4">
        <i class="fas fa-pen-to-square me-2 text-primary"></i>Edit Group
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('groups.update', $group->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">
                <i class="fas fa-tag me-1 text-info"></i>Group Name
            </label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $group->name }}" required>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Update Group
            </button>
        </div>
    </form>
</div>
@endsection
