@extends('dashboard.student.layout.contentsection')
@section('content')
    
  <div class="content-wrapper p-4"
     style="background: linear-gradient(135deg, #064e3b, #065f46);
            border-radius: 15px;
            min-height: 80vh;
            margin-left: 260px;
            margin-top: 20px;
            color: white;">

    <!-- HEADER -->
    <section class="content-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <h1 class="text-white mb-2">
                <i class="fa-solid fa-graduation-cap"></i> Student Quiz List
            </h1>

            <a href="/student-filter-quiz" class="btn btn-light btn-sm shadow-sm">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>

        <ol class="breadcrumb mt-2">
            <li class="breadcrumb-item">
                <a href="/dashboard" class="text-white">Dashboard</a>
            </li>
            <li class="breadcrumb-item active text-white">Student Quiz</li>
        </ol>
    </section>

    <style>
        #example2_paginate,
        #example2_info {
            display: none !important;
        }

        .quiz-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
            overflow: hidden;
            color: #1e293b;
        }

        .quiz-card-header {
            background: #f1f5f9;
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .quiz-card-header h5 {
            margin: 0;
            font-weight: 600;
        }

        thead th {
            background: #e2e8f0 !important;
            color: #1e293b !important;
            font-weight: 600;
            text-align: center;
        }

        tbody tr:hover {
            background-color: #f8fafc !important;
        }

        td a {
            font-weight: 600;
            color: #065f46;
            text-decoration: none;
        }

        td a:hover {
            color: #0a7b5a;
            text-decoration: underline;
        }
    </style>

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="quiz-card">

            <!-- HEADER TITLE INSIDE CARD -->
            <div class="quiz-card-header">
                <h5><i class="fa-solid fa-user-clock"></i> Available Quizzes by Age</h5>
            </div>

            <!-- TABLE -->
            <div class="card-body table-responsive">

                <table id="example2" class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>Quiz Title</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(isset($quizzes) && count($quizzes) > 0)
                            @foreach($quizzes as $key => $val)
                                <tr>
                                    <td>
                                        <a target="_blank" href="/continue-quiz/{{ $val->slug }}">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            {{ $val->title }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="1" class="text-center text-muted py-3">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    No quizzes found.
                                </td>
                            </tr>
                        @endif
                    </tbody>

                </table>

            </div>

        </div>
    </section>
</div>

<script>
$(function () {
    $('#example2').DataTable({
        paging: true,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true
    });
});
</script>

@endsection