@extends('website.layout.template')

@section('content')
    <style>
        h1.form-heading {
            color: #32325d;
            font-weight: 600;
            font-size: 20px;
        }

        h3.custom-form-duration.custom-form-heding {
            color: rgb(50, 50, 93);
            font-size: 15px;
            font-weight: 600;
        }

        p.custom-form-description.custom-form-heding {
            color: #32325d;
            font-size: 13px;
            font-weight: 600;
        }

        div#tab-description p {
            color: rgb(82, 95, 127);
            font-size: 16px;
            line-height: 27.2px;
        }


        .main-cont {
            position: relative;
        }

        button#start_quiz {
            background-color: rgb(250, 244, 244);
            border: none;
            font-size: 15px;
            font-weight: 600;
            padding: 13px;
            position: absolute;
            top: 0px;
            cursor: pointer;
        }

        button#start_quiz:hover {
            box-shadow: 0 7px 14px rgba(50, 50, 93, .1), 0 3px 6px rgba(0, 0, 0, .08) !important;
            transform: translateY(-1px);
        }

        .startbtn {
            display: flex;
            justify-content: flex-end;
        }

        #custom_form_645e11af4aff1161856c90d2 label {
            color: rgb(50, 50, 93);
            font-size: 20px;
            font-weight: 600;
            line-height: 30px;
        }

        label.form-check-label.redio-label {
            color: rgb(82, 95, 127) !important;
            font-size: 15px !important;
            font-weight: 400 !important;
            padding: 7px;
        }

        .count-down-timer {
            position: absolute;
            top: -30px;
            right: -1px;
            color: rgb(50, 50, 93);
            font-size: 15px;
            font-weight: 600;
        }

        a#quiz-prev-btn {
            background-color: rgb(250, 244, 244);
            border: none;
            font-size: 17px;
            font-weight: 600;
            padding: 9px 20px;
            cursor: pointer;
            text-align: center;
            margin: 10px;
        }

        a#quiz-prev-btn:hover {
            box-shadow: 0 7px 14px rgba(50, 50, 93, .1), 0 3px 6px rgba(0, 0, 0, .08) !important;
            transform: translateY(-1px);
        }

        .quizNextBtn {
            display: flex;
            gap: 20px;
        }

        a#quiz-next-btn {
            background-color: rgb(250, 244, 244);
            border: none;
            font-size: 17px;
            font-weight: 600;
            padding: 9px 20px;
            cursor: pointer;
            text-align: center;
            margin: 10px;
        }

        a#quiz-next-btn:hover {
            box-shadow: 0 7px 14px rgba(50, 50, 93, .1), 0 3px 6px rgba(0, 0, 0, .08);
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            .count-down-timer {
                margin-right: 10px;
            }

            .quizFormSaveBtn {
                padding-left: 128px;
                margin-top: -56px;
            }

            #start_quiz {
                display: block;
                margin-top: -56px;
            }
        }

        p.MsoNormal {
            color: #32325d !important;
        }

        label.form-check-label.checkbox-label {
            color: rgb(82, 95, 127);
            font-size: 15px !important;
            font-weight: 400 !important;
            padding: 7px;
        }

        form#custom_form_649c0f5d87e5234ee76850aa label {
            color: rgb(50, 50, 93) !important;
            font-size: 20px;
            font-weight: 600;
            line-height: 30px;
        }

        input#submitBTN {
            background-color: rgb(250, 244, 244);
            border: none;
            font-size: 17px;
            font-weight: 600;
            padding: 12px 30px;
            cursor: pointer;
            color: rgb(33, 37, 41);
            margin: 0 10px;
        }

        /*.form-grou.quizFormSaveBtn{
        display:block!important;
        }*/

        .result-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .result-box {
            background-color: rgb(250, 244, 244);
            border-radius: 18px;
            padding: 20px 10px;
            width: 260px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .result-box h2 {
            margin: 24px 0;
            font-size: 45px;
            color: rgb(8, 8, 8);
            font-weight: 500;
        }

        .result-box p {
            font-size: 19px;
            color: rgb(8, 8, 8);
        }

        .continue-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: rgb(250, 244, 244);
            font-weight: 500;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .continue-button:hover {
            box-shadow: 0 7px 14px rgba(50, 50, 93, .1), 0 3px 6px rgba(0, 0, 0, .08) !important;
            transform: translateY(-1px);
        }

        /*testing css*/
        .quizFormSaveBtn {
            padding-left: 137px;
            margin-top: -56px;
        }

        .continue-btn {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        /*hide-hover effect on mobile device*/
        @media (hover: none) {

            a#quiz-prev-btn:hover,
            a#quiz-next-btn:hover,
            button#start_quiz:hover,
            .continue-button:hover {
                box-shadow: none;
                transform: none;
            }
        }
    </style>

<br><br><br><br><br>
    <div class="container main-cont">
        <div class="currentSlideHeading" style="text-align:center"><span class="dotSlides"></span></div>
        <div class="slideshow-container">
            <div class="mySlides">
                <div class="custom-form-heading">
                    <h1 class="form-heading">{!! html_entity_decode(@$quizzes->title) !!}</h1>
                    <h3 class="custom-form-duration custom-form-heding"> Quiz Duration: {{ @$quizzes->duration }} Minutes
                    </h3>
                    <p class="custom-form-description custom-form-heding"> {{ @$quizzes->title }}</p>
                    <div class="custom-form-content custom-form-heding">
                        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--description panel entry-content wc-tab"
                            id="tab-description" role="tabpanel" aria-labelledby="tab-title-description">
                            <p>{!! html_entity_decode(@$quizzes->description) !!}</p>
                        </div>
                    </div>
                </div>
                <form action="javascript:;" id="custom_form_{{ @$quizzes->id }}" method="POST"
                    name="custom_form_{{ @$quizzes->id }}" class="quizcustomforms " style="display: none;">
                    
                    <input type="hidden" name="user_id" id="user_id" value="{{ @$user->id }}">
                    <input type="hidden" name="quiz_duration" id="quiz_duration" value="{{ @$quizzes->duration }}">


                    <input type="hidden" name="formid_{{ @$quizzes->id }}" id="formid_{{ @$quizzes->id }}"
                        value="{{ @$quizzes->id }}">
                    <input type="hidden" name="quiz_id" id="quiz_id" value="{{ @$quizzes->id }}">


                    @foreach ($questions as $question)
                        <?php
                        $correct_answer = json_decode($question['correct_options'], true);
                        $correct_answer11 = json_encode(@$correct_answer);
                        $escaped_correct_answer_data = urlencode($correct_answer11);
                        ?>
                        <div class="form-grou-quiz form-grou" id="quiz_{{ $question['id'] }}">
                            {{-- <input type="hidden" id="correct_answer_{{ $question['id'] }}"
                                name="correct_answer_{{ $question['id'] }}" value="{{ $escaped_correct_answer_data }}"
                                class="quiz-answer-inputs"> --}}

                            <label>{{ $question['question'] }}</label>

                            @php
                                $options = json_decode($question['options'], true);
                            @endphp

                            @if ($question['type'] === 'checkbox')
                                @foreach ($options as $index => $option)
                                    <div class="checkbox-div">
                                        <input type="checkbox" id="{{ $question['id'] }}_{{ $index }}"
                                            name="{{ $question['id'] }}" value="{{ $option }}" class="quiz-inputs">
                                        <label class="form-check-label checkbox-label"
                                            for="{{ $question['id'] }}_{{ $index }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            @elseif ($question['type'] === 'radio')
                                @foreach ($options as $index => $option)
                                    <div class="redio-div">
                                        <input type="radio" id="{{ @$question['id'] }}_{{ @$option['options_id'] }}"
                                            name="{{ @$question['id'] }}" value="{{ @$option['options_id'] }}" class="quiz-inputs">
                                        <label class="form-check-label redio-label" for="{{ @$question['id'] }}_{{ @$option['options_id'] }}">
                                            {{ $option['options_question'] }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    @endforeach

                    <div class="quizNextBtn"><a id="quiz-prev-btn" disabled="" style="display: none;">Previous</a> <a
                            id="quiz-next-btn">Next</a></div>
                    <div class="form-grou quizFormSaveBtn" style="display:none">
                        <div id="loaderCustomFormSaveBtn" class="loaderCustomFormSaveBtn" style="display: none;"></div>
                        <input class="download-btn customFormSaveBtn"
                            onclick="customFormSave('custom_form_{{ @$quizzes->id }}')" id="submitBTN" name="submit"
                            type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>

        <div class="count-down-timer" style="display:none;">
            <span>Time Remaining: </span><span id="timer_display">Loading timer...</span><span> Minutes</span>
        </div>
        <div class="startbtn">
            <button id="start_quiz">Start Quiz</button>
        </div>
        <!-- result-section -->
        <div class="result-container mt-5" style="display:none;">
            <div class="result-grid">

                <div id="result_section" style="width: 80%; "></div>
                {{-- <div class="result-box">
                    <p>Total Questions</p>
                    <h2><span id="quiz_total_questions"></span></h2>
                </div>
                <div class="result-box">
                    <p>Attempted Questions</p>
                    <h2><span id="quiz_total_attempted_questions"></span></h2>
                </div>
                <div class="result-box">
                    <p>Correct Answers</p>
                    <h2><span id="quiz_total_correct_answers"></span></h2>
                </div>
                <div class="result-box">
                    <p>Result (%)</p>
                    <h2><span id="quiz_total_result"></span>%</h2>
                </div> --}}
            </div>
            <div class="continue-btn">
                <a href="/quiz-list" class="btn continue-button">Continue</a>
            </div>
        </div>


    </div>
    <input type="hidden" id="max_selected_option" name="max_selected_option">
    <br><br><br><br><br><br><br>

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>

$(document).ready(function () {
    let optionCounts = {}; // Empty object for dynamic options
    let previousSelections = {}; // Har question ki previous selection track karne ke liye

    // Sabhi radio buttons ki unique values ko fetch karke initialize karein
    $(".quiz-inputs").each(function () {
        let optionValue = $(this).val();
        if (!optionCounts[optionValue]) {
            optionCounts[optionValue] = 0;
        }
    });

    $(".quiz-inputs").on("change", function () {
        let questionId = $(this).attr("name"); // Question ka unique name
        let selectedValue = $(this).val(); // Selected option ka value

        // Pehle wale selection ko count se kam karein
        if (previousSelections[questionId]) {
            let prevValue = previousSelections[questionId];
            if (optionCounts[prevValue] > 0) {
                optionCounts[prevValue]--;
            }
        }

        // Naye selection ko update karein
        previousSelections[questionId] = selectedValue;

        // Count ko increase karein
        optionCounts[selectedValue]++;

        // Object ko array mein convert karein
        let optionList = Object.keys(optionCounts).map(key => ({
            option: key,
            count: optionCounts[key]
        }));

        // Sabse zyada count wale option ko dhundhein
        let maxOption = optionList.reduce((max, current) => (current.count > max.count ? current : max), { option: "", count: 0 });

        // Hidden field me sabse zyada selected option ka value set karein
        $("#max_selected_option").val(maxOption.option);

        console.log(optionList); // Debugging ke liye console pe dikhana
        console.log("Max Selected Option:", maxOption.option);
    });
});



$(document).ready(function () {
    $("#submitBTN").on("click", function () {
        let maxSelectedOptionId = $("#max_selected_option").val(); // Hidden field se max option ID lein

        if (!maxSelectedOptionId) {
            alert("No option selected yet.");
            return;
        }

        $.ajax({
            url: "/get-quiz-answer", // Server-side route
            type: "GET",
            data: { options_id: maxSelectedOptionId }, // Send selected option ID
            success: function (response) {
                if (response.success) {
                    let data = response.data;
                    $("#result_section").html(`
                        <h3>${data.options_result}</h3>
                        <p>${data.options_description}</p>
                    `);
                } else {
                    alert("No matching record found.");
                }
            },
            error: function () {
                alert("Error fetching data.");
            }
        });
    });
});







        $(document).ready(function() {
            customFormSave("dd");
        });
        window.addEventListener('pageshow', function(event) {
            // If the page is loaded from the cache, reload it
            if (event.persisted) {
                location.reload();
            }
        });

        var vrArray = [];
        
        // function customFormSave(formId) {
        //     if (formId) {
        //         $("#" + formId).validate({
        //             ignore: ":hidden",
        //             rules: {
        //                 phone: {
        //                     required: true,
        //                     maxlength: 10,
        //                     minlength: 10
        //                 },
        //             },
        //             submitHandler: function(form) {

        //                 $(".loaderCustomFormSaveBtn").show();

        //                 var inputs = $("#" + formId + " :input");
        //                 //console.log(inputs);
        //                 // geeting all request for these file custom_form_json_payload.js
        //                 let JSONData = {};

        //                 var custom_form_id = formId.split('custom_form_')[1];
        //                 //var redirect_url = $("#" + formId + " #redirect_url").val();

        //                 JSONData['quiz_id'] = $("#" + formId + " #quiz_id").val();
        //                 JSONData['user_id'] = $('input[name=user_id]').val();
        //                 // Constructing answer array
        //                 let JSONAnserData = [];

        //                 // Initialize variables for calculations
        //                 let totalQuestions = 0;
        //                 let attemptedQuestions = 0;
        //                 let correctAnswers = 0;

        //                 // Iterate over each quiz group in the form
        //                 $("#" + formId + " .form-grou-quiz").each(function() {
        //                     totalQuestions++; // Increment total questions count

        //                     // Extract the question name (assuming it's the unique identifier for the question)
        //                     let question_name = $(this).find(".quiz-inputs").attr("name");

        //                     // Handle checkbox and radio inputs
        //                     let selectedOptions = $(this).find(".quiz-inputs:checked").map(function() {
        //                         return $(this).val(); // Get the value of each selected input
        //                     }).get(); // Convert to a plain array

        //                     // Retrieve the correct answer data using the question_name
        //                     let correctAnswerString = document.getElementById('correct_answer_' +
        //                         question_name)?.value;

        //                     let correctAnswerArray = [];
        //                     if (correctAnswerString) {
        //                         // Decode the URL-encoded string and parse as JSON
        //                         correctAnswerString = decodeURIComponent(correctAnswerString).replace(
        //                             /\+/g, ' ');
        //                         try {
        //                             correctAnswerArray = JSON.parse(correctAnswerString);
        //                         } catch (e) {
        //                             console.error(`Error parsing JSON for question: ${question_name}`,
        //                                 e);
        //                         }
        //                     }

        //                     // Check if the question was attempted
        //                     if (selectedOptions.length > 0) {
        //                         attemptedQuestions++; // Increment attempted questions count

        //                         // Check if the selected options match the correct answers
        //                         let isCorrect = JSON.stringify(selectedOptions.sort()) === JSON
        //                             .stringify(correctAnswerArray.sort());
        //                         if (isCorrect) {
        //                             correctAnswers++; // Increment correct answers count
        //                         }
        //                     }

        //                     // Push the data to the JSONAnserData array
        //                     JSONAnserData.push({
        //                         correct_answer: correctAnswerArray, // Array of correct answers
        //                         option_answer: selectedOptions, // Array of the selected options
        //                         question_id: question_name // The unique question identifier
        //                     });
        //                 });

        //                 // Calculate Result Percentage
        //                 let resultPercentage = (correctAnswers / totalQuestions) * 100;

        //                 // Add the answers and results to the JSONData object
        //                 JSONData['answer'] = JSONAnserData;


        //                 $('#quiz_total_questions').html(totalQuestions);
        //                 $('#quiz_total_result').html(resultPercentage.toFixed(2));
        //                 $('#quiz_total_correct_answers').html(correctAnswers);
        //                 $('#quiz_total_attempted_questions').html(attemptedQuestions);

        //                 JSONData['total_correct_answer'] = correctAnswers;
        //                 JSONData['total_attempt_question'] = attemptedQuestions;
        //                 JSONData['total_attempt_time'] = $("#total_attempt_time").val();
        //                 JSONData['total_questions'] = totalQuestions;

        //                 console.log(JSONData);
        //                 $.ajaxSetup({
        //                     headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Set the CSRF token header
        //                     }
        //                 });

        //                 $.ajax({
        //                     type: "POST", // define the type of HTTP verb we want to use (POST for our form)
        //                     contentType: "application/json",
        //                     url: vrApiUrl + "/quizesAttemptAnswer",
        //                     data: JSON.stringify(JSONData), // our data object
        //                     dataType: "json", // what type of data do we expect back from the server                                        
        //                 })

        //                     .done(function (data) {
        //                         if (data.success) {
        //                           $(".loaderCustomFormSaveBtn").hide();
        //                             $(".dvMessage").html(data.message);
        //                         } else {
        //                            $(".loaderCustomFormSaveBtn").hide();
        //                             $(".dvMessage").html(data.message);
        //                         }
        //                     });


        //                 event.preventDefault();
        //                 return false; // required to block normal submit since you used ajax
        //             }

        //         });


        //     }
        // }


        /// Function for get formId js
        function onlyGetFormId(formId) {
            const inputString = formId;
            const prefix = "custom_form_";
            const key = inputString.replace(prefix, "");
            return key;

        }



        // Function to start the timer
        function startTimer() {
            // Get the quiz duration in minutes from the hidden input
            const quizDurationInput = document.getElementById("quiz_duration");
            let timeInMinutes = parseInt(quizDurationInput.value, 10); // Convert to integer

            // Convert minutes to seconds for the countdown
            let timeInSeconds = timeInMinutes * 60;

            // Function to format the time as MM:SS
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
            }

            // Function to update the timer display
            function updateTimerDisplay() {
                const timerDisplay = document.getElementById("timer_display");
                timerDisplay.textContent = formatTime(timeInSeconds);
            }

            // Start the countdown
            updateTimerDisplay(); // Display the initial time
            const timerInterval = setInterval(() => {
                timeInSeconds -= 1; // Decrease time by 1 second

                if (timeInSeconds <= 0) {
                    clearInterval(timerInterval); // Stop the timer when it reaches 0
                    document.getElementById("timer_display").textContent = "Time's up!";

                    document.querySelector('.quizFormSaveBtn').style.display = 'block';

                    // Step 2: Trigger the button click
                    document.querySelector('#submitBTN').click();

                    //var current_quiz_id = $("#quiz_id").val();
                    // customFormSave('custom_form_'+current_quiz_id);


                } else {
                    updateTimerDisplay(); // Update the timer display
                }
            }, 1000); // Repeat every second
        }

        // Add click event listener to the "Start Quiz" button
        document.getElementById("start_quiz").addEventListener("click", () => {
            startTimer(); // Start the timer
            document.getElementById("start_quiz").disabled = true; // Disable the button to prevent multiple starts
        });


        $(document).ready(function() {
            let currentIndex = 0;
            const quizzes = $(".form-grou-quiz");

            // Update button states
            function updateButtons() {
                // Hide "Previous" button on the first question
                $("#quiz-prev-btn").toggle(currentIndex > 0);

                // Show or hide "Next" and "Save" buttons based on currentIndex
                if (currentIndex < quizzes.length - 1) {
                    $("#quiz-next-btn").show(); // Show "Next" button
                    $(".quizFormSaveBtn").hide(); // Hide "Save" button
                } else {
                    $("#quiz-next-btn").hide(); // Hide "Next" button
                    $(".quizFormSaveBtn").show(); // Show "Save" button
                }
            }

            // Show the current quiz
            function showQuiz() {
                quizzes.hide(); // Hide all quizzes
                quizzes.eq(currentIndex).show(); // Show the current one
                updateButtons();
            }

            // Next button click
            $("#quiz-next-btn").click(function() {
                if (currentIndex < quizzes.length - 1) {
                    currentIndex++;
                    showQuiz();
                }
            });

            // Previous button click
            $("#quiz-prev-btn").click(function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    showQuiz();
                }
            });

            // Initialize
            showQuiz();
        });





        // JavaScript to hide the section
        $(document).ready(function() {
            $("#start_quiz").click(function() {
                $(".custom-form-heading").hide();
                $("#start_quiz").hide();
                $(".quizcustomforms").show();
                $(".count-down-timer").show();
                $(".result-container").hide();
            });

            $(".quizcustomforms").hide();
            $(".count-down-timer").hide();
            $(".result-container").hide();



            $("#submitBTN").click(function() {
                $(".custom-form-heading").show();
                $(".quizcustomforms").hide();
                $(".result-container").show();
                $(".count-down-timer").hide();
                $(".custom-form-duration").hide();
            });

        });
    </script>







@stop
