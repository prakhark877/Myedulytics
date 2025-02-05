@extends('dashboard.admin.layout.template')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1 class="m-0 text-dark">Welcome, {{ $user->name }}!</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
           <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="/admin-dashboard">Home</a></li>
             <li class="breadcrumb-item active">Admin Dashboard</li>
             {{-- <li class="breadcrumb-item"><a href="/dashboard">Change Password</a></li> --}}
           </ol>
         </div><!-- /.col -->
       </div><!-- /.row -->
     </div><!-- /.container-fluid -->
   </div> 
 </div>

@stop
