@extends('dashboard.admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Edit Cms</h1>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form action="{{ route('cms_pages.update', $cms_pages->page_id) }}" method="POST" class="">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="page_type">Type</label>
                                <select name="page_type" id="page_type" class="form-control">
                                    <option value="{{ $cms_pages->page_type }}"
                                        @if ($cms_pages->page_type == "age_group") selected @endif>
                                        {{ $cms_pages->page_type }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="page_title">Title</label>
                                <input type="text" name="page_title" id="page_title" class="form-control"
                                    value="{{ $cms_pages->page_title }}" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update Cms</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
