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
                        <h3>Subcategories</h3>
                        <div class="add-category">
                            <a href="{{ route('subcategories.create') }}" class="btn btn-primary">Add New Subcategory</a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                   
                                <th>ID</th>
                                <th>Category</th>
                                <th>Subcategory Title</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subcategories as $key=> $subcategory)
                                    <tr>
                                      
                                        <td>{{ $subcategory->id }}</td>
                                        <td>{{ $subcategory->category->cat_title }}</td>
                                        <td>{{ $subcategory->subcat_title }}</td>
                    
                                        <td>
                                            <a href="{{ route('subcategories.edit', $subcategory->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <!-- Delete button with confirmation -->
                                            <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST"
                                                style="display:inline;" id="delete-form-{{ $subcategory->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $subcategory->id }})">Delete</button>
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
        function confirmDelete(subcategoryId) {
            // Display confirmation dialog
            if (confirm("Are you sure you want to delete this subcategory?")) {
                // If confirmed, submit the form
                document.getElementById('delete-form-' + subcategoryId).submit();
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
