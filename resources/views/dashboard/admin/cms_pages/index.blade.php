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
                        <h3>cms Content</h3>
                        <div class="add-category">
                            <a href="{{ route('cms_pages.create') }}" class="btn btn-primary">Add New Cms</a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cms_pages as $key=> $val)
                                    <tr>
                                      
                                        <td>{{ $val->page_id }}</td>
                                        <td>{{ $val->page_title }}</td>
                                        <td>{{ $val->page_slug }}</td>
                                        <td>{{ $val->page_type }}</td>
                                        <td>
                                            <a href="{{ route('cms_pages.edit', $val->page_id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <!-- Delete button with confirmation -->
                                            <form action="{{ route('cms_pages.destroy', $val->page_id) }}" method="POST"
                                                style="display:inline;" id="delete-form-{{ $val->page_id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $val->page_id }})">Delete</button>
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
            if (confirm("Are you sure you want to delete this cms?")) {
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
