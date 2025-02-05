@extends('website.layout.template')

@section('content')
<div class="container mt-5" style="min-height: 80vh;">

    <div class="row justify-content-center">
        <div class="col-md-6">
    <h1 style="text-align: center;">Student Registration</h1>

    <!-- Display any success or error messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Registration Form -->
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <!-- Name Field -->
        <div class="form-group">
            <label for="name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
        </div>
        <div class="form-group">
            <label for="name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
        </div>


        <!-- Email Field -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <!-- Password Field -->
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <!-- Confirm Password Field -->
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary mt-3">Register</button>
    </form>
</div>
</div>
</div>
@stop
