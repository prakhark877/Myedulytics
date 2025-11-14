@extends('dashboard.student.layout.contentsection')

@section('content')
<!-- 
    <div class="content-wrapper" style="background-color : #006400; width : 62em; height : 30em; margin : -32em 0em 0em 20em; border-radius : 1em 1em 1em 1em;">
        <section class="content">
            <div class="position1">
            <div class="container-fluid">
                 <h1 class="text-white">Add Marksheet</h1>

<!-- YEAR & MONTH DROPDOWNS -->
<!-- <select id="yearSelect">
    <option value="">Select Year</option>
    <script>
        const currentYear = new Date().getFullYear();
        for (let y = currentYear; y >= currentYear - 10; y--) {
            document.write(`<option value="${y}">${y}</option>`);
        }
    </script>
</select>

<select id="monthSelect">
    <option value="">Select Month</option>
    <script>
        const months = [
            "January","February","March","April","May","June",
            "July","August","September","October","November","December"
        ];
        months.forEach((m, index) => {
            document.write(`<option value="${index}">${m}</option>`);
        });
    </script>
</select>

<hr>

<!-- UPLOAD SECTION (ONE ONLY!) -->
<!-- <div id="uploadArea"></div>

<script>
// Generate one upload box only
function showUploadBox() {
    const year = document.getElementById("yearSelect").value;
    const month = document.getElementById("monthSelect").value;
    const container = document.getElementById("uploadArea");

    // Validate
    if (!year || month === "") {
        container.innerHTML = "<p>Please select year and month.</p>";
        return;
    }

    // Show upload field only for selected year+month
    container.innerHTML = `
        <h3>Upload Marksheet for ${months[month]} ${year}</h3>
        
        <input type="file" id="marksheetUpload" onchange="uploadSuccess()"><br><br>

        <div id="uploadStatus" style="font-weight:bold; color:gray;">Pending</div>
    `;
}

// Listen for selection changes
document.getElementById("yearSelect").addEventListener("change", showUploadBox);
document.getElementById("monthSelect").addEventListener("change", showUploadBox);

// Success handling
function uploadSuccess() {
    document.getElementById("uploadStatus").innerHTML =
        "<span style='color: green;'>✔ Uploaded Successfully!</span>";
}
</script>


            <div class="content-wrapper p-4"
     style="background: linear-gradient(135deg, #064e3b, #065f46);
            border-radius: 15px;
            min-height: 80vh;
            margin-left: 260px;
            margin-top: 20px;
            color: white;">

    <section class="content-header mb-4">
        <h1 class="text-white">
            <i class="fa-solid fa-file-circle-plus"></i> Add Marksheet
        </h1>
    </section>

    <div class="row d-flex justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">

            <div class="shadow-lg p-4"
                 style="background:#ffffff; border-radius:12px; color:#1e293b;">

                <!-- SAME FORM (NOTHING CHANGED INSIDE) -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('marksheets.store') }}" 
                      method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group mb-3">
                        <label for="description" class="fw-semibold">Description*</label>
                        <input type="text" name="description" id="description"
                               class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image" class="fw-semibold">Choose Image*</label>
                        <input class="upload form-control" id="image" name="image"
                               type="file" required>
                    </div>

                    <button type="submit"
                            class="btn"
                            style="background:#065f46; color:white; width:100%; font-weight:600;">
                        Add Marksheet
                    </button>

                </form>
                <!-- FORM ENDS -->

            </div>

        </div>
    </div>

</div>

<style>
@media(max-width: 992px) {
    .content-wrapper {
        margin-left: 0 !important;
        border-radius: 0 !important;
    }
}
</style>

@stop
