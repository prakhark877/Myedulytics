@extends('dashboard.student.layout.contentsection')

@section('content')
<div class="container" style="background : linear-gradient(135deg, #064e3b, #065f46); 
margin : 6em 0em 0em 8em; width : 70%; min-height : 60vh; border-radius: 15px;">
    <h2 class="text-white">My Profile</h2>
    <!-- <div class="box" style="background-color : pink;">Profile updated successfully!</div> -->
    <div class="firow" style="display : flex; gap : 15em;">
    <div class="elementone" style="display : block;">
    <h6 class="text-white">Name</h6>
    <input type="text" name="name" id="name" placeholder="Enter your name" style="width : 14em; outline : none;"  />
    </div>
    <div class="elementtwo" style="display : block;">
    <h6 class="text-white">Email (Read only)</h6>
    <input type="email" name="email" id="email" placeholder="Enter your email-id" style="width : 14em; outline : none;" />
    </div>
    </div>
    <div class="srow" style="display : flex; gap : 15em;">
    <div class="elementthree mt-4" style="display : block;">
    <h6 class="text-white">Mobile</h6>
    <input type="number" id="quantity" name="quantity" style="width : 14em; outline : none;" />
    </div>
     <div class="elementfour" style="display : block;">
    <h6 class="text-white mt-4">Address</h6>
    <input type="text" id="address" name="address" style="width : 14em; outline : none;" />
    </div>
    </div>
    <input class="file-uploader mt-4" type="file" onchange="upload()"accept="image/*" />
    <h6 class="text-white" style="border-radius : 3em;">Upload Profile Photo</h6>
    <button type="submit" class="submit-button mt-4" name="profilebutton" style="outline : none; border : 1px solid blue;">Update Profile</button> 
</div>
@endsection
