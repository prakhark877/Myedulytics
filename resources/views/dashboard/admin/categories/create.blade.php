@extends('dashboard.admin.layout.template')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Add Category</h1>
                        <!-- Display general error messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="cat_title">Category Name</label>
                                <input type="text" name="cat_title" id="cat_title"
                                    class="form-control @error('cat_title') is-invalid @enderror" value="{{ old('cat_title') }}"
                                    required>

                                @error('cat_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
