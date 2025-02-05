@extends('dashboard.student.layout.template')
@section('content')
    
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student <a href="/student-profile" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Page Refresh</a></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Student Detail</li>
              
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<style type="text/css">
      div#example2_paginate {
    display: none !important;
}
div#example2_info {
    display: none !important;
}
    </style>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <form action="">
                <div class="row">
                    <div class="col-3">
                      <input type="text" name="search" id="search" placeholder="Search.. " class="form-control" value="{{ (isset($search)) ? $search : ''}}">
                    </div>
                    
                    <div class="col-3">
                      <label>From Date:</label>
                      <input type="date" name="fromdt" id="fromdt" value="{{ (isset($fromdt)) ? $fromdt : ''}}">
                    </div>
                    <div class="col-3">
                        <label>To Date:</label>
                        <input type="date" name="todt" id="todt" value="{{ (isset($todt)) ? $todt : ''}}">
                    </div>
                    <div class="col-3">
                      <input type="submit" class="btn btn-primary" value="Search"/>
                    </div>
                </div>
              </div>
            </form>
              <div class="row">
                <div class="col-md-3">
                  <form action="/usersdata" method="post">
                    <input type="hidden" name="tdt" id="tdt">
                    <input type="hidden" name="fdt" id="fdt">
                    <input type="hidden" name="srch" id="srch">
                    <input type="submit" class="btn btn-primary" id="expdata" disabled value="Download data"/>
                  </form>
                </div>
              </div>
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Stdent ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Dob</th>
                    <th>Phone</th>
                    <th>Created at</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($users as $key=> $user)
                  <tr>
                    <td>{{ $key+1}}</td>
                    <td>{{$user->student_id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->gender}}</td>
                    <td>{{$user->dob}}</td>
                    <td>{{$user->phone}}</td>
                    <td><?php echo date('Y-m-d h:i A', strtotime($user->created_at)); ?></td>
                  </tr>
                  @endforeach
                </tbody>
                </table>
                {!! $users->links() !!}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script>
    $(function () {
        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
        });
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        }); 
    
   });

   $('#expdata').click(function(){
      // alert('export data clicked.');
      var from =  $('#fromdt').val();
      var to =  $('#todt').val();
      var srch = $('#search').val();
      
      $('#tdt').val(to);
      $('#fdt').val(from);
      $('#srch').val(srch);
      
   });
   
  </script>


@endsection