@extends('dashboard.admin.layout.template')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Add Age Groups</h1>
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

                        <form action="{{ route('age-groups.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required>

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="min_age">Min Age</label>
                                <input type="number" name="min_age" id="min_age"
                                    class="form-control @error('min_age') is-invalid @enderror" value="{{ old('min_age') }}"
                                    required>

                                @error('min_age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="max_age">Max Age</label>
                                <input type="number" name="max_age" id="max_age"
                                    class="form-control @error('max_age') is-invalid @enderror" value="{{ old('max_age') }}"
                                    required>

                                @error('max_age')
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
