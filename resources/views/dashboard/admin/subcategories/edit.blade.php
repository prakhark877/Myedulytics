@extends('dashboard.admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Edit Subcategory</h1>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST" class="">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->cat_title }}
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cat_title">Subcategory Title</label>
                                    <input type="text" name="subcat_title" id="subcat_title"  required class="form-control" value="{{ $subcategory->subcat_title }}">
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
