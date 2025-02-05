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

                        <form action="{{ route('questions.store') }}" method="POST">
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
                                    <input type="radio" name="type" value="radio" id="type_radio" class="form-check-input type-selector" required>
                                    <label for="type_radio" class="form-check-label">Single Choice (Radio)</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="type" value="checkbox" id="type_checkbox" class="form-check-input type-selector" required>
                                    <label for="type_checkbox" class="form-check-label">Multiple Choice (Checkbox)</label>
                                </div>
                            </div>
                    
                            <div id="options-container">
                                @for ($i = 0; $i < 4; $i++) <!-- Updated to zero-based index -->
                                    <div class="mb-3 d-flex align-items-center">
                                        <!-- Correct option radio for single choice -->
                                        <input type="radio" name="correct_option[]" value="{{ $i }}" class="form-check-input me-2 type-radio">
                                        <!-- Correct option checkbox for multiple choice -->
                                        <input type="checkbox" name="correct_option[]" value="{{ $i }}" class="form-check-input me-2 type-checkbox d-none">
                                        <!-- Option text field -->
                                        <input type="text" name="options[{{ $i }}]" placeholder="Option {{ $i + 1 }}" class="form-control" required>
                                    </div>
                                @endfor
                            </div>
                            
                    
                            <button type="submit" class="btn btn-success">Save Question</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.querySelectorAll('.type-selector').forEach((input) => {
    input.addEventListener('change', (e) => {
        const isRadio = e.target.value === 'radio';
        document.querySelectorAll('.type-radio').forEach(el => el.classList.toggle('d-none', !isRadio));
        document.querySelectorAll('.type-checkbox').forEach(el => el.classList.toggle('d-none', isRadio));
    });
});

    </script>

@stop
