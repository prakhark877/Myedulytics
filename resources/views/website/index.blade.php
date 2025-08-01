<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MyEdulytics</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Load Carlito font (Calibri-compatible) -->
  <link href="https://fonts.googleapis.com/css2?family=Carlito&display=swap" rel="stylesheet">
  <!-- <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@1,700&display=swap" rel="stylesheet"> -->
  <style>
    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Calibri', 'Carlito', 'Arial', sans-serif;
      color: #082567;
      background-image: url(https://d2vmtwtvjnckox.cloudfront.net/uploads/1753968315619.jpeg);
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      flex-wrap: wrap;
    }

    .logo img {
      width: 160px;
      height: auto;
    }

    .nav {
      display: flex;
      flex-wrap: wrap;
      gap: 80px;
      justify-content: center;
    }

    .nav a {
      text-decoration: none;
      font-size: 18px;
      color: #082567;
      padding: 8px 12px;
    }

    .main-content {
      flex: 1 0 auto;
      text-align: center;
      padding: 0px 20px;
    }

    h1 {
      font-size: 42px;
      margin: 20px 0 10px;
    }

    h2 {
      font-size: 24px;
      margin-bottom: 40px;
    }

    .login-buttons {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 100px;
      margin-bottom: 60px;
    }

    .login-buttons a {
      text-decoration: none;
      padding: 15px 40px;
      background-color: white;
      border: 2px solid #082567;
      border-radius: 20px;
      box-shadow: 5px 5px 0 #1b8c82;
      font-size: 18px;
      color: #082567;
      font-weight: bold;
      min-width: 180px;
      text-align: center;
    }

    footer {
      flex-shrink: 0;
      text-align: center;
      /* background-color: rgba(255, 255, 255, 0.9); */
      margin-bottom: 30px;
      padding: 15px 0;
    }

    footer a {
      margin: 0 40px;
      text-decoration: none;
      color: #082567;
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .header {
        flex-direction: column;
        align-items: center;
        gap: 10px;
      }

          .nav {
        justify-content: center;
        gap: 10px;
        text-align: center;
        flex-direction: column;
    }

      h1 {
        font-size: 30px;
      }

      h2 {
        font-size: 18px;
      }

      .login-buttons {
        flex-direction: column;
        gap: 20px;
      }

      .login-buttons a {
        font-size: 16px;
        padding: 12px 30px;
      }

      footer a {
        display: inline-block;
        margin: 5px 10px;
        font-size: 13px;
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
      <a href="#">Home</a>
      <a href="#">Dashboards</a>
      <a href="#">Assessments</a>
      <a href="#">Mentoring</a>
      <a href="#">Admissions</a>
    </div>
  </div>

  <div class="main-content">
    <h1>MyEdulytics</h1>
    <h2>Analytics for Education and Careers</h2>

    <div class="login-buttons">
      <a href="/login">Parent Login</a>
      <a href="/login">Student Login</a>
      <a href="#">Teacher Login</a>
    </div>
  </div>

  <footer>
    <a href="#">About Us</a>
    <a href="#">Contact Us</a>
    <a href="#">Privacy</a>
    <a href="#">Search</a>
    <a href="#">Terms of Service</a>
  </footer>

</body>
</html>
