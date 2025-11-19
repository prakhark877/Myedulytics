<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            background-color: #F1F5F9;
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* ----------------------------------------------
           TOP HEADER NAVBAR
        ------------------------------------------------*/
        .top-navbar {
            background-color: #ffffff;
            padding: 12px 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-navbar img {
            height: 70px;
        }

        .top-navbar .user-section {
            font-size: 18px;
            color: #0F172A;
            font-weight: bold;
        }

        /* ----------------------------------------------
           SIDEBAR
        ------------------------------------------------*/
        .sidebar {
            width: 250px;
            background-color: #1E293B;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding-top: 110px;
            color: white;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar h4 {
            padding-left: 20px;
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: 600;
            color: #F8FAFC;
        }

        .sidebar .nav-link {
            color: #CBD5E1;
            padding: 12px 25px;
            font-size: 15px;
            display: block;
            border-left: 4px solid transparent;
            transition: 0.2s;
        }

        .sidebar .nav-link:hover {
            background-color: #334155;
            color: white;
            border-left: 4px solid #38BDF8;
        }

        .dropdown-container {
            display: none;
            margin-left: 10px;
        }

        /* ----------------------------------------------
           MAIN CONTENT
        ------------------------------------------------*/
        .main-content {
            margin-left: 250px;
            padding: 30px;
            transition: 0.3s ease;
            min-height: 100vh;
        }

        /* ----------------------------------------------
           MOBILE RESPONSIVENESS
        ------------------------------------------------*/
        @media (max-width: 992px) {
            .sidebar.open {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle-btn {
                display: block;
            }
        } 

        .menu-toggle-btn {
            display: none;
            font-size: 26px;
            cursor: pointer;
            color: #0F172A;
        }

        /* Smooth arrow rotation */
        .arrow-rotate {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }

    </style>
</head>

<body>

<!-- ⭐ TOP NAVBAR -->
<div class="top-navbar">
    <span class="menu-toggle-btn" id="menuToggle"><i class="fa-solid fa-bars"></i></span>
    <img src="images/myedulytics_logo.png" alt="">
    <div class="user-section">
        <a href="/home" style="text-decoration:none; color : black;" class="mx-3">Home</a>
        <i class="fa-solid fa-circle-user"></i> Student Portal
    </div>
</div>

<!-- ⭐ SIDEBAR -->
<nav class="sidebar" id="sidebarMenu">
    <img src="images/myedulytics_logo.png" alt="Logo" style="margin-top : -7em;">
    <h4><i class="fa-solid fa-user"></i>  Student Portal</h4>

    <a href="/studentdashboard" class="nav-link"><i class="fa-solid fa-house"></i> Dashboard</a>

    <!-- Student Dropdown -->
    <a href="#" class="nav-link dropdown-btn">
        <i class="fa-regular fa-user"></i> Student  
        <i class="fa-solid fa-angle-down float-end arrow"></i>
    </a>
    <div class="dropdown-container">
        <a href="/studentprofile" class="nav-link">– Profile</a>
        <a href="/studentattemptquiz" class="nav-link">– Attempt Quiz</a>
    </div>

    <!-- Reports Dropdown -->
    <a href="#" class="nav-link dropdown-btn">
        <i class="fa-regular fa-file"></i> My Reports 
        <i class="fa-solid fa-angle-down float-end arrow"></i>
    </a>
    <div class="dropdown-container">
        <a href="/marksheets/create" class="nav-link">– Report Card</a>
        <a href="/studentcertificates" class="nav-link">– Certificates</a>
        <a href="/studentassessments" class="nav-link">– Assessments</a>
    </div>

    <a href="/studentfilterquiz" class="nav-link"><i class="fa-solid fa-filter"></i> Student Filter Quiz</a>

    <a href="/studentquestions" class="nav-link"><i class="fa-solid fa-pencil"></i> Related Questions</a>

    <a href="/studentfeedback" class="nav-link"><i class="fa-regular fa-comment"></i> Feedback</a>
</nav>

<!-- ⭐ MAIN CONTENT -->
<div class="main-content">
    @yield('content')
</div>

<!-- ⭐ JAVASCRIPT -->
<script>
    // Sidebar Toggle (Mobile)
    document.getElementById("menuToggle").onclick = function () {
        document.getElementById("sidebarMenu").classList.toggle("open");
    };

    // Dropdown Logic
    let dropdowns = document.getElementsByClassName("dropdown-btn");

    for (let i = 0; i < dropdowns.length; i++) {
        dropdowns[i].addEventListener("click", function () {
            let content = this.nextElementSibling;
            let arrow = this.querySelector(".arrow");

            if (content.style.display === "block") {
                content.style.display = "none";
                arrow.classList.remove("arrow-rotate");
            } else {
                content.style.display = "block";
                arrow.classList.add("arrow-rotate");
            }
        });
    }
</script>

</body>
</html>
