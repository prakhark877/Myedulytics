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
                        <h3>Questions</h3>
                        <div class="add-category">
                            <a href="{{ route('questions.create') }}" class="btn btn-primary">Add New Questions</a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                   
                                    <th>#</th>
                                    <th>Quiz Name</th>
                                    <th>Question</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($questions as $index => $question)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $question->title }}</td>
                                        <td>{{ $question->question }}</td>
                                        <td>{{ ucfirst($question->type) }}</td>
                                        <td>
                                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            
                                            <!-- Delete Form -->
                                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this question?')">Delete</button>
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
            if (confirm("Are you sure you want to delete this Quiz?")) {
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
