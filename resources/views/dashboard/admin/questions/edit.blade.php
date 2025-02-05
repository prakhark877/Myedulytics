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
                        <form action="{{ route('questions.update', $questions->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="quiz_id">Quiz*</label>
                                <select name="quiz_id" id="quiz_id" class="form-control" required>
                                    <option value="">Select Quiz</option>
                                    @foreach ($quizzes as $quiz)
                                        <option value="{{ $quiz->id }}"
                                            @if ($questions->quiz_id == $quiz->id) selected @endif>
                                            {{ $quiz->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="question" class="form-label">Question</label>
                                <input type="text" name="question" id="question" class="form-control"
                                    value="{{ $questions->question }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <div class="form-check">
                                    <input type="radio" name="type" value="radio" id="type_radio"
                                        class="form-check-input type-selector"
                                        @if ($questions->type == 'radio') checked @endif required>
                                    <label for="type_radio" class="form-check-label">Single Choice (Radio)</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="type" value="checkbox" id="type_checkbox"
                                        class="form-check-input type-selector"
                                        @if ($questions->type == 'checkbox') checked @endif required>
                                    <label for="type_checkbox" class="form-check-label">Multiple Choice (Checkbox)</label>
                                </div>
                            </div>

                            <div id="options-container">
                                @php
                                    $options = json_decode($questions->options, true);
                                    $correctOptions = json_decode($questions->correct_options, true);
                                @endphp
                            
                                @foreach ($options as $index => $option)
                                    <div class="mb-3 d-flex align-items-center">
                                        <!-- Correct option radio for single choice -->
                                        <input type="radio" 
                                            name="correct_option[]" 
                                            value="{{ $option }}" 
                                            class="form-check-input me-2 type-radio {{ $questions->type === 'radio' ? '' : 'd-none' }}"
                                            @if (in_array($option, $correctOptions)) checked @endif>
                            
                                        <!-- Correct option checkbox for multiple choice -->
                                        <input type="checkbox" 
                                            name="correct_option[]" 
                                            value="{{ $option }}" 
                                            class="form-check-input me-2 type-checkbox {{ $questions->type === 'checkbox' ? '' : 'd-none' }}"
                                            @if (in_array($option, $correctOptions)) checked @endif>
                            
                                        <!-- Option text field -->
                                        <input type="text" 
                                            name="options[]" 
                                            placeholder="Option {{ $index + 1 }}" 
                                            class="form-control" 
                                            value="{{ $option }}" 
                                            required>
                                    </div>
                                @endforeach
                            </div>
                            
                            

                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>


   <!-- JavaScript to toggle inputs dynamically based on type -->
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const typeSelectors = document.querySelectorAll('.type-selector'); // Radio buttons for type selection
    const typeRadioInputs = document.querySelectorAll('.type-radio'); // Correct option radios
    const typeCheckboxInputs = document.querySelectorAll('.type-checkbox'); // Correct option checkboxes

    // Function to toggle inputs based on question type
    function toggleInputs(questionType) {
        // Reset correct options
        resetCorrectOptions();

        // Toggle visibility of radio and checkbox inputs
        if (questionType === 'radio') {
            typeRadioInputs.forEach(input => input.classList.remove('d-none'));
            typeCheckboxInputs.forEach(input => input.classList.add('d-none'));
        } else if (questionType === 'checkbox') {
            typeRadioInputs.forEach(input => input.classList.add('d-none'));
            typeCheckboxInputs.forEach(input => input.classList.remove('d-none'));
        }
    }

    // Function to reset all correct options
    function resetCorrectOptions() {
        // Uncheck all radio buttons
        typeRadioInputs.forEach(input => {
            input.checked = false;
        });

        // Uncheck all checkboxes
        typeCheckboxInputs.forEach(input => {
            input.checked = false;
        });
    }

    // Function to initialize selected options on page render
    function initializeInputs(questionType) {
        if (questionType === 'radio') {
            typeRadioInputs.forEach(input => {
                input.classList.remove('d-none');
            });
            typeCheckboxInputs.forEach(input => {
                input.classList.add('d-none');
                input.checked = false; // Ensure checkboxes are unchecked
            });
        } else if (questionType === 'checkbox') {
            typeCheckboxInputs.forEach(input => {
                input.classList.remove('d-none');
            });
            typeRadioInputs.forEach(input => {
                input.classList.add('d-none');
                input.checked = false; // Ensure radio buttons are unchecked
            });
        }
    }

    // Initialize input visibility and selection based on the current question type
    const initialQuestionType = '{{ $questions->type }}';
    initializeInputs(initialQuestionType);

    // Add event listeners for change on type selector inputs
    typeSelectors.forEach(selector => {
        selector.addEventListener('change', function () {
            const selectedType = this.value; // Get the currently selected type
            toggleInputs(selectedType);
        });
    });
});

</script>
@stop
