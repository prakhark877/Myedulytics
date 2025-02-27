@extends('dashboard.admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Edit Quiz</h1>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST" class="" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Quiz Title*</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ $quiz->title }}" required>
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration (Minutes)*</label>
                                <input type="number" name="duration" id="duration" value="{{ $quiz->duration }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="random_questions_count">Random Questions Count*</label>
                                <input type="number" name="random_questions_count" id="random_questions_count" value="{{ $quiz->random_questions_count }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="age_group_id">Age Group*</label>
                                <select name="age_group_id" id="age_group_id" class="form-control" required>
                                    @foreach ($age_group as $age)
                                    <option value="{{ $age['id'] }}" @if ($age['id'] == $quiz->age_group_id) selected @endif>{{ $age['name'] }}</option>
                                    @endforeach
                                       
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category*</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($category->id == $quiz->category_id) selected @endif>
                                            {{ $category->cat_title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subcategory_id">Subcategory*</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                    <option value="">Select Subcategory</option>
                                    @foreach ($categories as $category)
                                        @foreach ($category->subcategories as $subcategory)
                                        @if ($category->id == $quiz->category_id) 
                                            <option value="{{ $subcategory->id }}" @if ($subcategory->id == $quiz->subcategory_id) selected @endif>
                                                {{ $subcategory->subcat_title }}
                                            </option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ $quiz->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="image" class="form-label">Choose File:</label>
                                <div style="display:flex">
                                       
                                        <input class=" upload form-control" style="width: 50%" id="fz_image" name="fz_image" onchange="uploadS3File(this.id)" type="file">
                                        <input id="image" name="image" type="hidden" value="{{$quiz->image}}">
                                    
                                
                                <a target="_blank" href="{{ config('constants.AWS_CREDENTIALS.CLOUDFRONTURL') . $quiz->image }}"> <img src="{{ config('constants.AWS_CREDENTIALS.CLOUDFRONTURL') . $quiz->image }}" alt="Current File" width="50" height="50"></a>
                            </div> </div>
                            <button type="submit" class="btn btn-success">Update</button>
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
