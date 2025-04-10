@extends('dashboard.admin.layout.template')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6" style="margin: auto;">
                        <h1>Add Marksheet</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('marksheets.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="description">Description*</label>
                                <input type="text" name="description" id="description" class="form-control" required>
                            </div>


                            <div class="form-group">
                                <label for="image" class="form-label">Choose Image*</label>
                                <input class="upload form-control" id="fz_image" name="fz_image" onchange="uploadS3File(this.id)" type="file">
                                <input id="image" name="image" type="hidden" value="">
                            </div>

                            <button type="submit" class="btn btn-success">Add Marksheet</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
