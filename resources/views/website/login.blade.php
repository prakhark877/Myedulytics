@extends('website.layout.template')

@section('content')
<div class="container mt-5" style="min-height: 80vh;">
   <div class="row justify-content-center">
       <div class="col-md-6">
           <h3 class="text-center">Login</h3>
           @if(session('success'))
           <div class="alert alert-success">{{ session('success') }}</div>
       @elseif(session('error'))
           <div class="alert alert-danger">{{ session('error') }}</div>
       @endif
   
           <form id="login-form" method="POST" action="{{ url('login') }}">
               @csrf
               <div class="mb-3">
                   <label for="email" class="form-label">Email</label>
                   <input type="email" id="email" name="email" class="form-control" required>
               </div>
               <div class="mb-3">
                   <label for="password" class="form-label">Password</label>
                   <input type="password" id="password" name="password" class="form-control" required>
               </div>
               <button type="submit" class="btn btn-primary w-100">Login</button>
           </form>
       </div>
   </div>
</div>
@stop
