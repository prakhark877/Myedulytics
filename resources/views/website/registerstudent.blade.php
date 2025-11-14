<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Student Registration</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background-color: rgb(226 232 240);
  font-family: Arial, sans-serif;
}

  .header {
       display: flex;
       justify-content: space-between;
       align-items: center;
       padding: 15px 30px;
       flex-wrap: wrap;
        }

       .nav {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
       }

       .text{
        font-weight : normal;
       }

       .nav a{
           text-decoration : none;      
           color : #082567;
        }

     .nav img{
       max-width : 150px;
       height : auto;
       display : block;
       margin-left : -19em;
       margin-right : auto;
     }

.image{
  margin-top : -6em;
}

.flex{
  display : flex;
  flex-direction : row;
  gap : 13px;
}


#registration-form {
  width: 95%;
  max-width: 800px;
  padding: -2em;
  align-self : flex-start;
  border-radius: 10px;
  margin : 0 auto;
  /* box-shadow: 0px 2px 8px rgba(0,0,0,0.1); */
}

/* Tabs */
.tabs {
  display: flex;
  flex-wrap: wrap;
  justify-content: left;
  gap: .5em;
  margin-bottom: 1em;
}

.tab-button {
  border: 1px solid #ccc;
  color : rgba(100,116,139,1);
  padding: .6em 1.2em;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s ease;
  outline : none;
}

.tab-button.active {
  background-color: #ffffff;
  color: black;
  font-weight: 600;
  outline : none;
}

/* Hide all tabs initially */
.tab-content {
  display: none;
  font-weight : bold;
}

.tab-content.active {
  display: block;
}

/* Layout */
.form-row {
  display: flex;
  flex-wrap: wrap;
  gap: 1em;
  margin-bottom: 1em;
}

.form-group {
  flex: 1;
  min-width: 15.625rem;
  font-weight : bold;
}

.form-group1{
  font-weight : normal;
  display : flex;
  flex-direction : row;
  gap : 0.625rem;
}

input, select, textarea {
  width: 100%;
  padding: .5em;
  border: 1px solid #ccc;
  border-radius: 5px;
  outline : none;
  transition : 0.3s;
}

input:focus{
  outline-style : solid;
  color : #ccc;
}

.submit-btn, .submit-btn1 {
  background-color: black;
  color: white;
  border: none;
  padding: .6em 1.2em;
  border-radius: 5px;
  cursor: pointer;
}

.cohortbox{
  height : 4em;
  border-radius : 35px;
  margin-top : 2em;
}

.cohortbox1{
  width : 103%;
}

.submit-btn1 { background-color: pink; color : black; }

/* Responsive */
@media (max-width: 768px) {
  .form-row { flex-direction: column; }
  .tab-button { flex: 1 1 45%; }

  .nav img{
    margin : 0 auto;
  }
  
}
</style>
</head>
<body>
    <div class="header">
    <div class="logo">
      <img src="https://d2vmtwtvjnckox.cloudfront.net/uploads/1753968358102.png" alt="Logo">
    </div>
    <div class="nav">
      <a href="/home">Home</a>
      <a href="/dashboard">Dashboards</a>
      <a href="/assessment">Assessments</a>
      <a href="/mentoring">Mentoring</a>
      <a href="/admissions">Admissions</a>
    </div>
  </div>
  
  
<div id="registration-form">
  <h2 class="text-left" style="color:#1c398e;font-weight:700;">New Student Registration</h2>
  <p class="text-left text-muted">Fill the details below. Your public StudentID will be generated to help securely link school and parent records.</p>

  <!-- Tabs -->
  <div class="tabs">
    <button class="tab-button active" data-tab="identity">Identity</button>
    <button class="tab-button" data-tab="school">School</button>
    <button class="tab-button" data-tab="profile">Profile</button>
    <button class="tab-button" data-tab="consent">Consent</button>
    <!-- <button class="tab-button" data-tab="wizard">Setup Wizard</button> -->
  </div>

  <form id="mainForm" action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Identity -->
    <div id="identity" class="tab-content active">
      <div class="form-row">
        <div class="form-group">
          <label>First Name*</label>
          <input type="text" name="fname" required>
        </div>
        <div class="form-group">
          <label>Last Name*</label>
          <input type="text" name="lname" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Preferred Name</label>
          <input type="text" name="pname">
        </div>
        <div class="form-group">
          <label>Date of Birth*</label>
          <input type="date" name="dob" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Student Email*</label>
          <input type="email" name="smail" required>
        </div>
        <div class="form-group">
          <label>Student Password*</label>
          <input type="password" name="spassword" required>
        </div>
      
        <div class="form-group">
          <label>Parent Email*</label>
          <input type="email" name="pmail" required>
        </div>
        <div class="form-group">
          <label>Parent Password*</label>
          <input type="password" name="ppassword" required>
        </div>
      </div>
       <div class="form-row">
        <div class="form-group">
          <label>Country*</label>
          <input type="text" name="country"  required>
        </div>
        <div class="form-group">
          <label>Region/State*</label>
          <input type="text" name="region" required>
        </div>
      </div>
      <div class="form-group">
          <label>City</label>
          <input type="text" name="city" required>
          </div>

         <div class="bg-white p-1 rounded lg-4 shadow cohortbox">
          <p>STUDENTID (PREVIEW)</p>
          <p class="text-right" style="justify-self : right; margin-top : -2.6em;">COHORT</p>
          <p style="font-weight : bold; margin-top : -1em;">_</p>
          <p style="font-weight : bold; justify-self : right; margin-top : -2em;">2028</p>
        </div>
    </div>

    <!-- School -->
    <div id="school" class="tab-content">
      <div class="form-row">
        <div class="form-group">
          <label>School (choose a preset)</label>
          <select name="school-preset">
            <option value="1">GEMS-DXB</option>
            <option value="2">DPS-DEL</option>
            <option value="3">PS-CA</option>
          </select>
        </div>
        <div class="form-group">
          <label>Curriculum</label>
          <select name="curriculum">
            <option value="1">CBSE</option>
            <option value="2">ICSE</option>
            <option value="3">IB</option>
            <option value="4">Cambridge (IGCSE)</option>
            <option value="5">US (AP)</option>
            <option value="6">Other</option>
          </select>
        </div>
        <div class="form-group">
          <label>Grade</label>
          <select name="grade">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
        </div>
        <div class="form-group">
          <label>Languages (comma separated)</label>
          <input type="text" name="languages" required>
        </div>
        <div class="bg-white p-1 rounded lg-4 shadow cohortbox1">
          <p>STUDENTID (PREVIEW)</p>
          <p class="text-right" style="justify-self : right; margin-top : -2.6em;">COHORT</p>
          <p style="font-weight : bold; margin-top : -1em;">_</p>
          <p style="font-weight : bold; justify-self : right; margin-top : -2em;">2028</p>
        </div>
      </div>
    </div>

    <!-- Profile -->
    <div id="profile" class="tab-content">
      <div class="form-row">
        <div class="form-group">
          <label>Academic Interests (comma separated)</label>
          <textarea cols="15" name="academic"></textarea>
        </div>
        <div class="flex">
          <div class="form-group">
            <label>Activities and Achievements (comma separated)</label>
            <textarea  name="activities"></textarea>
          </div>
          <div class="form-group">
            <label>Study Hours / week</label>
            <textarea  name="study_hours"></textarea>
          </div>
        </div>
       <div class="form-group1">
  <label>Learning Preferences</label>

  @foreach(['Visual', 'Auditory', 'Kinesthetic', 'Project-based', 'Group study', 'Self-paced'] as $preference)
    <div class="form-check">
      <input class="form-check-input" type="checkbox" 
             id="pref_{{ $loop->index }}" 
             name="learningpreferences[]" 
             value="{{ $preference }}">
      <label class="form-check-label" for="pref_{{ $loop->index }}">
        {{ $preference }}
      </label>
    </div>
  @endforeach

</div>

      </div>
    </div>

    <!-- Consent -->
    <div id="consent" class="tab-content">
      <div class="text">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="consent1" name="consent[]" value="Share data with   teachers">
      <label class="form-check-label" for="consent1">
        Share my data with teachers
      </label>
    </div>

    <div class="form-check mt-2">
      <input class="form-check-input" type="checkbox" id="consent2" name="consent[]" value="Share data  with   parents">
      <label class="form-check-label" for="consent2">
        Share my data with parents
      </label>
    </div>

    <div class="form-check mt-2">
      <input class="form-check-input" type="checkbox" id="consent3" name="consent[]" value="Allow         anonymized data for research">
      <label class="form-check-label" for="consent3">
        Allow anonymized data for research/benchmarking
      </label>
    </div>
  </div>
    </div>

    <!-- Wizard -->
    <!-- <div id="wizard" class="tab-content">
      <h4>Setup Wizard</h4>
      <p class="text-muted">Complete your setup to personalize your experience.</p>
      <div class="mb-3">
        <label>Upload Previous Report Card</label>
        <input type="file" class="form-control" name="report_card" required>
      </div>
      <div class="mb-3">
        <label>Preferred Subjects / Interests</label>
        <input type="text" class="form-control" name="preferred_subjects" placeholder="e.g. Math, Science, Art">
      </div>
      <div class="mb-3">
        <label>Assessment Preference</label>
        <select class="form-control" name="assessment_preference">
          <option>Standard Assessment</option>
          <option>Diagnostic Test</option>
          <option>Skill-Based Survey</option>
        </select>     
      </div>
    </div> -->

    <div class="text-left mt-3">
      <button type="submit" class="submit-btn" name="action" value="create">Create Account</button>
      <button type="submit" class="submit-btn1" name="action" value="draft">Save Draft</button>
    </div>
  </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const tabButtons = document.querySelectorAll(".tab-button");
  const tabs = document.querySelectorAll(".tab-content");

  tabButtons.forEach(button => {
    button.addEventListener("click", () => {
      const target = button.getAttribute("data-tab");

      tabButtons.forEach(btn => btn.classList.remove("active"));
      tabs.forEach(tab => tab.classList.remove("active"));

      button.classList.add("active");
      document.getElementById(target).classList.add("active");
    });
  });
});
</script>
</body>
</html>
