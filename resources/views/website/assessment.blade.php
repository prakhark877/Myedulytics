<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Page</title>

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

        /* CARDS */
        .card-boxes {
            display: flex;
            flex-wrap: wrap;
            gap: 45px;
            justify-content: center;
            padding: 40px;
            margin-top: 50px;
        }

        .card {
            width: 22rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
        }

        .button1 {
            display: block;
            width: 100%;
            border: 1px solid rgba(15,23,42,1);
            background-color: rgba(15,23,42,1);
            color: white;
            padding: 10px;
            border-radius: 7px;
            text-align: center;
        }

        .button1:hover {
            background-color: rgba(59,69,93,1);
            border: 1px solid rgba(59,69,93,1);
        }

        /* FOOTER */
        footer {
            text-align: center;
            margin: 40px 0;
            padding: 10px 0;
        }

        footer a {
            margin: 0 20px;
            font-size: 14px;
            text-decoration: none;
            color: rgba(74,85,101,1);
        }

        /* ---------- RESPONSIVE FIXES ---------- */

        @media (max-width: 992px) {
            .nav {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .header {
                justify-content: center;
                text-align: center;
            }

            .nav {
                margin-top: 10px;
                justify-content: center;
            }

            .card {
                width: 90%;
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

    <!-- CARDS SECTION -->
    <section>
        <div class="card-boxes">

            <div class="card">
                <div class="card-header bg-white border-0">
                    Personality
                </div>
                <div class="card-body">
                    <p>Understand your traits to choose study strategies and careers.</p>
                    <button type="button" class="button1">Login</button>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white border-0">
                    Career Interests
                </div>
                <div class="card-body">
                    <p>Discover career clusters aligned with your interests.</p>
                    <button type="button" class="button1">Login</button>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white border-0">
                    Skills & Aptitude
                </div>
                <div class="card-body">
                    <p>Measure core skills to track mastery and gaps.</p>
                    <button type="button" class="button1">Login</button>
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
