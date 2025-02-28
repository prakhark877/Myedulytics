@extends('dashboard.admin.layout.template')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 sm-12 col-lg-6 " style="margin: auto;">
                        <h1>Add Questions</h1>
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

                        <form action="{{ route('questions.store') }}" method="POST" id="questionForm">
                            @csrf
                            <div class="form-group">
                                <label for="quiz_id">Quiz*</label>
                                <select name="quiz_id" id="quiz_id" class="form-control" required>
                                    <option value="">Select Quiz</option>
                                    @foreach ($quizzes as $quiz)
                                        <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="mb-3">
                                <label for="question" class="form-label">Question</label>
                                <input type="text" name="question" id="question" class="form-control" required>
                            </div>
                        
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <div class="form-check">
                                    <input type="radio" name="type" value="radio" id="type_radio" checked class="form-check-input type-selector" required>
                                    <label for="type_radio" class="form-check-label">Single Choice (Radio)</label>
                                </div>
                            </div>
                        
                            <div id="optionsContainer">
                                <div class="option-group mb-3 d-flex align-items-center">
                                    <div class="w-100">
                                        <label class="form-label option-label">Options 1</label>
                                        <input type="hidden" name="options_id[]" value="1">
                                        <input type="text" name="options_question[]" class="form-control mb-2" required>
                                    </div>
                                    <button type="button" class="btn btn-success me-2 addMore">➕</button>
                                </div>
                            </div>
                        
                            <!-- Hidden input to store JSON data -->
                            <input type="hidden" name="options_json" id="options_json">
                        
                            <button type="submit" class="btn btn-success">Save Question</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
       $(document).ready(function () {
        let optionCount = 1;

        // Add More Options
        $(document).on("click", ".addMore", function () {
            optionCount++;
            let newOption = `<div class="option-group mb-3 d-flex align-items-center">
                <div class="w-100">
                    <label class="form-label option-label">Options ${optionCount}</label>
                    <input type="hidden" name="options_id[]" value="${optionCount}">
                    <input type="text" name="options_question[]" class="form-control mb-2" required>
                </div>
                <button type="button" class="btn btn-danger ms-2 remove-option">❌</button>
            </div>`;

            $("#optionsContainer").append(newOption);
            updateRemoveButton();
        });

        // Remove Option (Only Last)
        $(document).on("click", ".remove-option", function () {
            $(this).closest(".option-group").remove();
            optionCount--;
            updateRemoveButton();
        });

        // Ensure Only Last Option Has Remove Button
        function updateRemoveButton() {
            $(".remove-option").remove(); // Remove all remove buttons
            if ($(".option-group").length > 1) {
                $(".option-group:last").append('<button type="button" class="btn btn-danger ms-2 remove-option">❌</button>');
            }
        }

        // Before Form Submit: Convert to JSON
        $("#questionForm").submit(function (e) {
            let optionsArray = [];

            $(".option-group").each(function () {
                let optionData = {
                    options_id: $(this).find("input[name='options_id[]']").val(),
                    options_question: $(this).find("input[name='options_question[]']").val()
                };
                optionsArray.push(optionData);
            });

            let jsonData = JSON.stringify(optionsArray);
            $("#options_json").val(jsonData);
        });
    });
    </script>

   

@stop
