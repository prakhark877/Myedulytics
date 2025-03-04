@extends('dashboard.admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Add Quiz Result</h1>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('quizzes-answer.update', $questions->id) }}" method="POST"
                            enctype="multipart/form-data" id="questionForm">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="quiz_id">Quiz*</label>
                                <input type="hidden" name="quiz_id" id="quiz_id" class="form-control mb-2" value="{{$quizzes->id}}" required>
                                <input type="text" name="quiz_title" id="quiz_title" disabled class="form-control mb-2" value="{{$quizzes->title}}" required>
                             </div>
                            
                            
                            <div id="optionsContainer">
                                @php
                                    $options = json_decode($questions->options, true);
                                    $optionCount = 0;
                                @endphp
                        @foreach($options as $index => $option)
                        @php 
                            $optionCount++;
                            // Matching quizzes_answer record from the collection/array
                            $matchedAnswer = collect($quizzes_answer)->firstWhere('options_id', $option['options_id']);
                        @endphp
                        <div class="option-group mb-3 d-flex align-items-center">
                            <div class="w-100">
                                <label class="form-label option-label">Options {{ $optionCount }} Result</label>
                                <input type="hidden" name="options_id[]" value="{{ $option['options_id'] }}">
                                <input type="text" name="options_result[]" class="form-control mb-2" placeholder="Title"
                                    value="{{ $matchedAnswer ? $matchedAnswer['options_result'] : '' }}" required>
                                  
                                    <textarea name="options_description[]" id="options_description" cols="60" rows="2">{{ $matchedAnswer ? $matchedAnswer['options_description'] : '' }}</textarea>  
                            </div>
                        </div>
                    @endforeach
                            </div>
                           

                   <input type="hidden" name="options_result_json" id="options_result_json">

                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>


   <!-- JavaScript to toggle inputs dynamically based on type -->
<script>
   $(document).ready(function () {

        // Before Form Submit: Convert to JSON
        $("#questionForm").submit(function (e) {
            let optionsArray = [];

            $(".option-group").each(function () {
                let optionData = {
                    options_id: $(this).find("input[name='options_id[]']").val(),
                    options_result: $(this).find("input[name='options_result[]']").val(),
                    options_description: $(this).find("textarea[name='options_description[]']").val()
                };
                optionsArray.push(optionData);
            });

            let jsonData = JSON.stringify(optionsArray);
            $("#options_result_json").val(jsonData);
        });
    });

</script>
@stop
