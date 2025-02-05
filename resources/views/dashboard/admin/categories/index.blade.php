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
                        <h3>Categories</h3>
                        <div class="add-category">
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                   
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key=> $category)
                                    <tr>
                                      
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->cat_title }}</td>
                                        <td>{{ $category->cat_slug }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <!-- Delete button with confirmation -->
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                                style="display:inline;" id="delete-form-{{ $category->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $category->id }})">Delete</button>
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
        function confirmDelete(categoryId) {
            // Display confirmation dialog
            if (confirm("Are you sure you want to delete this category?")) {
                // If confirmed, submit the form
                document.getElementById('delete-form-' + categoryId).submit();
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
