@extends('dashboard.admin.layout.template')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Add Quiz</h1>
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

                        <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Quiz Title*</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration (Minutes)*</label>
                                <input type="number" name="duration" id="duration" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="random_questions_count">Random Questions Count*</label>
                                <input type="number" name="random_questions_count" id="random_questions_count" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="age_group_id">Age Group*</label>
                                <select name="age_group_id" id="age_group_id" class="form-control" required>
                                    <option value="">Select Age Group</option>
                                    @foreach ($age_group as $age)
                                    <option value="{{ $age['id'] }}">{{ $age['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category*</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->cat_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subcategory_id">Subcategory*</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                    <option value="">Select Subcategory</option>
                                    @foreach ($categories as $category)
                                        @foreach ($category->subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->subcat_title }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description*</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image" class="form-label">Choose File:</label>
                                <input class=" upload form-control" id="fz_image" name="fz_image" onchange="uploadS3File(this.id)" type="file">
                                <input id="image" name="image" type="hidden" value="">
                            </div>

                            <button type="submit" class="btn btn-success">Add Quiz</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function () {
            $('#category_id').on('change', function () {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: "{{ route('get.subcategories') }}",
                        type: "POST",
                        data: {
                            category_id: categoryId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (data) {
                            $('#subcategory_id').empty().append('<option value="">Select Subcategory</option>');
                            $.each(data, function (key, value) {
                                $('#subcategory_id').append('<option value="' + value.id + '">' + value.subcat_title + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subcategory_id').empty().append('<option value=""> Select Subcategory </option>');
                }
            });
        });
    </script>

@stop
