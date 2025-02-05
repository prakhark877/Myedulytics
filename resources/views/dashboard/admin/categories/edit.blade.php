@extends('dashboard.admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Edit Category</h1>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="cat_title">Category Name</label>
                                <input type="text" name="cat_title" id="cat_title" class="form-control"
                                    value="{{ $category->cat_title }}" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
