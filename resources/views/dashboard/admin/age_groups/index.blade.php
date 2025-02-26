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
                        <h3>Age Groups</h3>
                        <div class="add-category">
                            <a href="{{ route('age-groups.create') }}" class="btn btn-primary">Add New Age Group</a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Min Age</th>
                                    <th>Max Age</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($age_groups as $key=> $val)
                                    <tr>
                                      
                                        <td>{{ $val->id }}</td>
                                        <td>{{ $val->name }}</td>
                                        <td>{{ $val->min_age }}</td>
                                        <td>{{ $val->max_age }}</td>
                                        <td>
                                            <a href="{{ route('age-groups.edit', $val->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <!-- Delete button with confirmation -->
                                            <form action="{{ route('age-groups.destroy', $val->id) }}" method="POST"
                                                style="display:inline;" id="delete-form-{{ $val->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $val->id }})">Delete</button>
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
            if (confirm("Are you sure you want to delete this age group?")) {
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
