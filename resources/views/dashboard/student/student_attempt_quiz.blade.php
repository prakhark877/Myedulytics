@extends('dashboard.student.layout.template')
@section('content')
    
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student Attempt Quiz<a href="/student-attempt-quiz" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Page Refresh</a></h1>
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
                    <th>Result Id</th>
                    <th>Result</th>
                    <th>Quiz Name</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($QuizAttemptAnswer as $key=> $val)
                  <tr>
                    <td>{{$val->options_id}}</td>
                    <td>{{$val->options_result}}</td>
                    <td>{{$val->title}}</td>
                    <td>{{$val->created_at}}</td>
                  </tr>
                  @endforeach
                </tbody>
                </table>
              
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