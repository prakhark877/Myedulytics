@extends('dashboard.student.layout.contentsection')

@section('content')
<div class="container" style="background : linear-gradient(135deg, #064e3b, #065f46);; width : 80%; min-height : 65vh; border-radius: 15px;">
    <h3 class="text-white mt-4">Feedback</h3>   
    <h5 class="text-white mt-4">Subject*</h5>
    <input type="text" name="subject" id="subject" placeholder="Enter your Subject" style=
    "outline : none;" />
    <h5 class="text-white mt-4">Message*</h5>
    <textarea name="message" id="message" placeholder="Enter the message here" style=
    "outline : none; width : 18em; min-height : 20vh;" /></textarea>
    <button type="submit" class="submit-button mt-4" name="feedbackbutton" style="display : block; outline : none; border : 1px solid blue;">Submit</button> 
</div>
@endsection
