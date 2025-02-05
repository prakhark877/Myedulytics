@extends('dashboard.admin.layout.template')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Add Subcategory</h1>
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

                        <form action="{{ route('subcategories.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->cat_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subcat_title">Subcategory Name</label>
                                <input type="text" name="subcat_title" id="subcat_title"
                                    class="form-control @error('subcat_title') is-invalid @enderror" value="{{ old('subcat_title') }}"
                                    required>

                                @error('subcat_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Add Subcategory</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
