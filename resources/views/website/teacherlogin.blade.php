<?php
session_start();

// Connect to DB
$servername = "localhost";
$username = "root";
$password = "";
$database = "login";   // change this to your database name

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check teacher in DB
    $sql = "INSERT INTO teacher_login (email,password) VALUES ('$email','$password')";
    
    if(mysqli_query($conn,$sql)){
    echo "<script>alert('Teacher login data inserted successfully');</script>";
    }
    else
    {
        echo "Error : ".$sql."<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
 <style>
        body,html{
            background-color : rgb(226 232 240);
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
        gap: 2px;
        justify-content: center;
       }

      .nav a{
        text-decoration : none;      
        color : #082567;
       }

       .navbar-nav{
            justify-self : right;
            margin : -8em 2em 0em 0em;
        }

        .topbar img{
            margin : -2em 0em 0em 0em;
        }

        /* .topbar h2{
            margin : -0.4em 19em 0em -4em;
            font-size : 1.7em;
            color :rgba(0,120,111,1);
        }

      .elliptical-text{
            font-size : 1.5em;
            border-radius : 10% / 25%;
            border : 1px solid rgba(0,120,111,1);
            width : 2em;
            color : white;
            text-align : center;
            background-color : rgba(0,120,111,1);
        } */

        .bottom-part{
            margin-top : 8em;
        }
      
        .footer ul,a{
            margin-left : 2em;
        }

        .bottom-list a{
           color : rgba(74,85,101,1);
        }

        .bottom-list{
            text-align : center;
            margin : 4em 0em 0em -2em;
        }

        .card{
             border : 1px solid white;
            width : 28%;
            background-color : #ffffff;
            justify-self : center;
            margin-top : 5em;
            height : 22em;
            border-radius : 7px 7px 7px 7px;
        }

        .card h2{
            color : rgba(110,17,176,1);
            font-weight : bold;
            font-size : 1.5em;
            margin-left : 1em;
            margin-top : 1em;
            margin-bottom : 1em;
        }
        
        .button1{
            text-align : center;
            border : 1px solid rgba(15,23,42,1); 
            background-color : rgba(15,23,42,1);
            color : #ffffff;
            width : 43.6%;
        }

        .box-1 {
            width : 98%;
            height : 2em;
            margin : 2em 0em 2em 1em;
        }

        .box-2 {
            width : 109%;
            height : 2em;
            margin : 0em 0em 2em 0.9em;
        }

        .button1{
            width : 90%;
            border-radius : 6px 6px 6px 6px;
            margin : 1em 0em 0em 0.9em;
            height : 14%;
        }

        .button1:hover{
             background-color : rgba(59,69,93,1);
            border : 1px solid rgba(59,69,93,1); 
        }

        footer {
            flex-shrink: 0;
            text-align: center;
            /* background-color: rgba(255, 255, 255, 0.9); */
            margin-bottom: 30px;
            padding: 15px 0;
            color: #082567;
        }

        footer a {
            margin: 0 40px;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
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

    <section class="card">
        <h2>Teacher Login</h2>
        <form method="POST" action="teacher_login.php">
       <div class="mb-3 row">
            <div class="col-sm-10">
            <input type="text" class="form-control box-2" name="email" placeholder = "Official Email ID">
            </div>
       </div>
       <div class="mb-3 row">
            <div class="col-sm-10">
           <input type="password" class="form-control box-2" name="password" placeholder = "Password">
            </div>
        </div>
         <button type="submit" class="button1" name="login">Login</button>
    </form>
    </section>   

<footer>
    <ul class="bottom-list">
        <a>About Us</a>
        <a>Contact Us</a>
        <a>Privacy</a>
        <a>Search</a>
        <a>Terms of Service</a>
    </ul>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>