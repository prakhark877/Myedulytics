@extends('dashboard.admin.layout.template')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Add CMS Pages</h1>
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

                        <form action="{{ route('cms_pages.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="page_type">Type</label>
                                <select name="page_type" id="page_type" class="form-control">
                                    <option value="age_group">Age Group</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="page_title">Title</label>
                                <input type="text" name="page_title" id="page_title"
                                    class="form-control @error('page_title') is-invalid @enderror" value="{{ old('page_title') }}"
                                    required>

                                @error('page_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
