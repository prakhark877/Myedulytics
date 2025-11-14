@extends('dashboard.admin.layout.template')

@section('content')
<div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">Welcome, {{ $user->name ?? 'Admin' }}!</h1>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/admin-dashboard">Home</a></li>
                  <li class="breadcrumb-item active">Admin Dashboard</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
