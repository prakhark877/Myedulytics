@extends('dashboard.student.layout.template')
@section('content')
    
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student Quiz<a href="/student-filter-quiz" class="btn btn-primary"><span class="glyphicon glyphicon-refresh"></span>Page Refresh</a></h1>
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
              <h5 style="margin-left: 20px;margin-top: 10px;"> <b>Student Age:</b> {{$age}} Year</h5>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Age Group</th>
                    <th>Quiz Title</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($quizzes as $key=> $val)
                  @php
                  $ageGroups = config('constants.AGE_GROUP'); 
                  $selectedAgeGroup = collect($ageGroups)->firstWhere('value', $val->age_group_id);
              @endphp
                  <tr>
                    
                    <td>{{$selectedAgeGroup['name'] ?? 'N/A'}}</td>
                    <td><a target="_blank" href="/continue-quiz/{{$val->slug}}"> {{$val->title}}</a></td>
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