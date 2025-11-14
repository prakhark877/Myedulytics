@extends('dashboard.admin.layout.template')

@section('content')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1 class="m-0 text-dark">
             Welcome, {{ $user->name ?? 'Admin' }}!
           </h1>
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

   <!-- Main content -->
   <section class="content">
     <div class="container-fluid">
       <div class="row">
         <div class="col-12">
           <div class="card">
             <div class="card-header">
               <h3 class="card-title">Dashboard Overview</h3>
             </div>
             <div class="card-body">
               <p>Welcome to the Admin Dashboard. Here you can manage users, quizzes, and results.</p>
               <a href="/admin/quiz-list" class="btn btn-primary">Manage Quizzes</a>
               <a href="/admin/users" class="btn btn-success">Manage Users</a>
               <a href="/admin/results" class="btn btn-info">View Results</a>
             </div>
           </div>
         </div>
       </div>
     </div>
   </section>
</div>
@endsection
