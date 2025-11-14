@extends('dashboard.admin.layout.contentsection')

@section('content')
<div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
         <h2>Student List</h2>

         <table class="table table-bordered table-striped mt-3">
            <thead class="thead-dark">
               <tr>
                  <th>#</th>
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Gender</th>
                  <th>Dob</th>
                  <th>Phone</th>
                  <th>Created At</th>
               </tr>
            </thead>
            <tbody>
               @if(isset($users) && count($users) > 0)
                  @foreach($users as $key => $user)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->student_id ?? '-' }}</td>
                        <td>{{ $user->name ?? '-' }}</td>
                        <td>{{ $user->email ?? '-' }}</td>
                        <td>{{ $user->gender ?? '-' }}</td>
                        <td>{{ $user->dob ?? '-' }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d h:i A') }}</td>
                     </tr>
                  @endforeach
               @else
                  <tr>
                     <td colspan="8" class="text-center">No students found.</td>
                  </tr>
               @endif
            </tbody>
         </table>

         <div class="d-flex justify-content-center mt-3">
             {{ $users->links() }}
         </div>
      </div>
   </div>
</div>
@endsection
