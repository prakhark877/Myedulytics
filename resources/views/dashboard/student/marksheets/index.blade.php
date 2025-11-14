@extends('dashboard.student.layout.contentsection')

@section('content')
    <div class="content-wrapper">
        <br><br>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h3>Marksheets</h3>
                        <div class="add-category">
                            <a href="{{ route('marksheets.create') }}" class="btn btn-primary">Add New Marksheet</a>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th> Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($marksheets as $marksheet)
                                    <tr>
                                        <td>{{ $marksheet->id }}</td>
                                        <td>
                                            @if($marksheet->image)
                                                <img src="{{ config('constants.AWS_CREDENTIALS.CLOUDFRONTURL') . $marksheet->image }}" alt="Image" width="50" height="50">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $marksheet->description }}</td>
                                        <td>
                                            {{-- <a href="{{ route('marksheets.edit', $marksheet->id) }}" class="btn btn-warning">Edit</a> --}}
                                            <form action="{{ route('marksheets.destroy', $marksheet->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $marksheet->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $marksheet->id }})">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No marksheets found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this Marksheet?")) {
                document.getElementById('delete-form-' + id).submit();
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
