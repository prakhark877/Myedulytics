<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Page</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            background-color: rgb(226 232 240);
            margin: 0;
            padding: 0;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            flex-wrap: wrap;
            background: white;
        }

        .logo img {
            max-width: 180px;
            height: auto;
        }

        .nav {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .nav a {
            text-decoration: none;
            color: #082567;
            font-size: 16px;
            font-weight: 500;
        }

        /* DASHBOARD HEADING */
        .dashboard {
            color: rgba(28,5,142,1);
            font-weight: bold;
            margin: 3em 0em -2em 7.2em;
        }

        /* CARDS SECTION */
        .card-boxes {
            display: flex;
            flex-wrap: wrap;
            gap: 2em;
            width: 90%;
            padding: 12%;
            margin: auto;
            justify-content: center;
        }

        .card {
            width: 280px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
        }

        .heading {
            color: black;
            font-weight: 500;
            font-size: 18px;
        }

        /* FOOTER */
        footer {
            text-align: center;
            margin-bottom: 30px;
            padding: 15px 0;
            color: #082567;
        }

        footer a {
            margin: 0 20px;
            text-decoration: none;
            font-size: 14px;
            color: rgba(74,85,101,1);
        }

        /* ----------- RESPONSIVE FIXES ----------- */

        @media (max-width: 992px) {
            .dashboard {
                margin-left: 1.5em;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .header {
                text-align: center;
                justify-content: center;
            }

            .nav {
                justify-content: center;
                margin-top: 10px;
            }

            .dashboard {
                margin-left: 0;
                margin-top: 2em;
                text-align: center;
            }

            .card-boxes {
                padding: 5%;
            }

            .card {
                width: 100%;
                max-width: 350px;
            }

            footer a {
                display: inline-block;
                margin: 8px;
            }
        }

        @media (max-width: 480px) {
            .logo img {
                max-width: 140px;
            }

            .nav a {
                font-size: 14px;
            }

            .card {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<!-- HEADER -->
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

<!-- DASHBOARD SECTION -->
<section>
    <h2 class="dashboard">Dashboards</h2>

    <div class="card-boxes">
        <div class="card" onclick="window.location='{{ route('dashboard') }}';">
            <div class="card-header bg-white border-0">
                <p class="heading">Student</p>
            </div>
            <div class="card-body">
                <p>Performance, mastery, roadmap, recommendations.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white border-0">
                <p class="heading">Parent</p>
            </div>
            <div class="card-body">
                <p>Overview of all children, alerts, guidance.</p>
            </div>
        </div>     

        <div class="card">
            <div class="card-header bg-white border-0">
                <p class="heading">Teacher</p>
            </div>
            <div class="card-body">
                <p>Class analytics, student reports, attention list.</p>
            </div>
        </div>    
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="bottom-list">
        <a>About Us</a>
        <a>Contact Us</a>
        <a>Privacy</a>
        <a>Search</a>
        <a>Terms of Service</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
