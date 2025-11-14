<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login Page</title>

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

        /* LOGIN CARD */
        .login-card {
            width: 380px;
            max-width: 90%;
            margin: 60px auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 35px 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            text-align: left;
        }

        .login-card h2 {
            color: rgba(28,57,142,1);
            font-size: 1.6em;
            font-weight: bold;
            margin: 10px 0 25px 0;
        }

        .login-card i {
            color: rgba(28,57,142,1);
        }

        .login-btn {
            width: 100%;
            background-color: rgba(15,23,42,1);
            border-color: rgba(15,23,42,1);
        }

        .login-btn:hover {
            background-color: rgba(59,69,93,1);
            border-color: rgba(59,69,93,1);
        }

        .register-user a {
            text-decoration: none;
            color: rgba(28,57,142,1);
            font-weight: bold;
        }

        /* FOOTER */
        footer {
            text-align: center;
            margin: 40px 0;
            padding: 10px 0;
        }

        footer a {
            margin: 0 20px;
            text-decoration: none;
            font-size: 14px;
            color: rgba(74,85,101,1);
        }

        /* MOBILE RESPONSIVE FIXES */
        @media (max-width: 768px) {

            .header {
                justify-content: center;
                text-align: center;
            }

            .nav {
                margin-top: 10px;
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

            .login-card {
                padding: 25px 18px;
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

    <!-- LOGIN CARD -->
    <section class="login-card">

        <i class="fa-solid fa-user" style="font-size:20px;"></i>
        <h2>Student Login</h2>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Student Email" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-primary login-btn">Login</button>
        </form>

        <p class="register-user mt-3">
            New user?
            <a href="{{ route('register.create') }}">Register</a>
        </p>

    </section>

    <!-- FOOTER -->
    <footer>
        <a>About Us</a>
        <a>Contact Us</a>
        <a>Privacy</a>
        <a>Search</a>
        <a>Terms of Service</a>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
