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
                        <h3>Quizzes</h3>
                        <div class="add-category">
                            <a href="{{ route('quizzes.create') }}" class="btn btn-primary">Add New Quiz</a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                   
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Duration (Minutes)</th>
                                    <th>Random Questions Count</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($quizzes as $quiz)
                                    <tr>
                                      
                                        <td>{{ $quiz->id }}</td>
                                        <td>{{ $quiz->title }}</td>
                                        <td>{{ $quiz->duration }}</td>
                                        <td>{{ $quiz->random_questions_count }}</td>
                                        <td>{{ $quiz->category->cat_title }}</td>
                                        <td>{{ $quiz->subcategory->subcat_title }}</td>
                                        <td><img src="{{ asset($quiz->image) }}" alt="Current File" width="50" height="50"></td>
                                        <td>
                                            <a href="{{ route('quizzes.edit', $quiz->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <!-- Delete button with confirmation -->
                                            <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST"
                                                style="display:inline;" id="delete-form-{{ $quiz->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $quiz->id }})">Delete</button>
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
