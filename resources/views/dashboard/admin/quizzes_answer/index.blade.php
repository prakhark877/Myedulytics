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
                            <a href="{{ route('quizzes-answer.create') }}" class="btn btn-primary">Add New Questions</a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Quiz Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quizzes_answer as $index => $answer)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $answer->title }}</td>
                                        <td>
                                            <a href="{{ route('quizzes-answer.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            
                                            <!-- Delete Form -->
                                            <form action="{{ route('quizzes-answer.destroy', $question->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Quizzes Answer?')">Delete</button>
                                            </form>
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
