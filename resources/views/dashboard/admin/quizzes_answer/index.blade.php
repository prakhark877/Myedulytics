@extends('dashboard.admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <br><br>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h3>Quizzes Answer</h3>
                        <div class="add-category">
                            {{-- <a href="{{ route('quizzes-answer.create') }}" class="btn btn-primary">Add New Questions</a> --}}
                        </div>
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Quiz Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quizzes as $index => $answer)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $answer->title }}</td>
                                        <td>
                                            <a href="{{ route('quizzes-answer.edit', $answer->id) }}" class="btn btn-warning btn-sm">Add Result</a>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function confirmDelete(quizzesId) {
            // Display confirmation dialog
            if (confirm("Are you sure you want to delete this Quizzes Answer?")) {
                // If confirmed, submit the form
                document.getElementById('delete-form-' + quizzesId).submit();
            }
        }
    </script>

<style>
    .add-category {
        justify-content: end;
        display: flex;
        margin: 10px;
    }
</style>
@stop
