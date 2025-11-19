@extends('dashboard.student.layout.contentsection')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <h2><span class="extra-bold">Dashboard</span></h2>
    <div class="bottomsection" style="display : flex; gap : 3em;">
    <div class="card" style="width : 13rem; height : 8rem;">
        <div class="card-body">
           <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
  <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z"/>
  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1"/>
</svg>
            <h6>View Assessments</h6>
        </div>
    </div>  

    <div class="card" style="width : 13rem; height : 8rem;">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
  <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
  <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
</svg>
            <h6>View Certificates</h6>
        </div>
    </div>      

    <div class="card" style="width : 13rem; height : 8rem;">
        <div class="card-body">
             <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
  <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z"/>
  <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1"/>
</svg>
            <h6>View Reports</h6>
        </div>
    </div>  

    <div class="card" style="width : 13rem; height : 8rem;">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 128C83.1 128 71.4 135.8 66.4 147.8C61.4 159.8 64.2 173.5 73.4 182.6L256 365.3L256 480C256 488.5 259.4 496.6 265.4 502.6L329.4 566.6C338.6 575.8 352.3 578.5 364.3 573.5C376.3 568.5 384 556.9 384 544L384 365.3L566.6 182.7C575.8 173.5 578.5 159.8 573.5 147.8C568.5 135.8 556.9 128 544 128L96 128z"/></svg>
            <h6>Filter Quiz</h6>
        </div>
    </div>  

    <div class="card" style="width : 13rem; height : 8rem;">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 224C224 171 267 128 320 128C373 128 416 171 416 224C416 266.7 388.1 302.9 349.5 315.4C321.1 324.6 288 350.7 288 392L288 416C288 433.7 302.3 448 320 448C337.7 448 352 433.7 352 416L352 392C352 390.3 352.6 387.9 355.5 384.7C358.5 381.4 363.4 378.2 369.2 376.3C433.5 355.6 480 295.3 480 224C480 135.6 408.4 64 320 64C231.6 64 160 135.6 160 224C160 241.7 174.3 256 192 256C209.7 256 224 241.7 224 224zM320 576C342.1 576 360 558.1 360 536C360 513.9 342.1 496 320 496C297.9 496 280 513.9 280 536C280 558.1 297.9 576 320 576z"/></svg>
            <h6>Related Questions</h6>
        </div>
    </div>  
    </div>
@endsection