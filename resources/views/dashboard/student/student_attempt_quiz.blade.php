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
                <i class="fa-solid fa-file-circle-check"></i> Attempted Quizzes
            </h1>

            <button onclick="location.reload();" 
                class="btn btn-light btn-sm shadow-sm">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>

        <ol class="breadcrumb mt-2">
            <li class="breadcrumb-item">
                <a href="/dashboard" class="text-white">Dashboard</a>
            </li>
            <li class="breadcrumb-item active text-white">Attempted Quizzes</li>
        </ol>
    </section>

    <style>
        /* Hide default pagination but keep table responsive */
        #example2_paginate, #example2_info {
            display: none !important;
        }

        .custom-card {
            border-radius: 12px;
            background: #ffffff;
            color: #1e293b;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .custom-card .card-header {
            background: #f1f5f9;
            border-bottom: 1px solid #e2e8f0;
        }

        thead th {
            background: #e2e8f0 !important;
            color: #1e293b !important;
            font-weight: 600;
        }

        tbody tr:hover {
            background-color: #f8fafc !important;
        }
    </style>

    <!-- MAIN CONTENT -->
    <section class="content">

        <div class="custom-card mt-3">

            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="fa-solid fa-clock-rotate-left"></i> Quiz Attempt History Hello
                </h3>
            </div>

            <div class="card-body table-responsive">
                
                <table id="example2" class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Quiz Title</th>
                            <th>Total Questions</th>
                            <th>Attempted</th>
                            <th>Correct Answers</th>
                            <th>Score (%)</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($QuizAttemptAnswer as $key => $val)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $val->quiz->title ?? 'N/A' }}</td>
                            <td>{{ $val->total_questions ?? '-' }}</td>
                            <td>{{ $val->total_attempt_question ?? '-' }}</td>
                            <td>{{ $val->total_correct_answer ?? '-' }}</td>

                            <td>
                                @if($val->total_questions > 0)
                                    <span class="badge bg-success px-3 py-2">
                                        {{ round(($val->total_correct_answer / $val->total_questions) * 100, 2) }}%
                                    </span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">0%</span>
                                @endif
                            </td>

                            <td>{{ \Carbon\Carbon::parse($val->created_at)->format('d M Y, h:i A') }}</td>
                        </tr>
                        @endforeach
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
