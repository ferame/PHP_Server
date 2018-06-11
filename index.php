<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
</style>
</head>
<body>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($_POST['uname'] === 'justin' && $_POST['psw'] === 'pass'){
    //echo 'show all the data';
    echo <<<EOF
<head>
  <title>Database Web View</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">DATABASE</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Structure</a></li>
        <li><a href="tableData.php?table=personal_tutors">Personal Tutors</a></li>
        <li><a href="tableData.php?table=students">Students</a></li>
        <li><a href="tableData.php?table=tutorials">Tutorials</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
    </div>
    <div class="col-sm-8 text-left"> 
      <h2>Structure of our database tables</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <hr>
      <h3>Personal Tutors</h3>
<!--
      <p>Lorem ipsum...</p>
-->
      <div class="table-responsive">          
      <table class="table">
      <col width="15%">
      <col width="15%">
      <col width="45%">
      <col width="25%">
        <thead>
          <tr>
            <th>Column</th>
            <th>Variable Type</th>
            <th>Data description</th>
            <th>Example format</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>pt_email</td>
            <td>TEXT</td>
            <td>Personal tutor E-mail (Links to Students table)</td>
            <td>john@doe.co.uk</td>
          </tr>
          <tr>
            <td>name</td>
            <td>TEXT</td>
            <td>Personal tutor name</td>
            <td>John</td>
          </tr>
          <tr>
            <td>surname</td>
            <td>TEXT</td>
            <td>Personal tutor surname</td>
            <td>Doe</td>
          </tr>
          <tr>
            <td>phone_number</td>
            <td>TEXT</td>
            <td>Personal tutor contact number</td>
            <td>07547244555</td>
          </tr>
        </tbody>
      </table>
      </div>
      <hr>
      <h3>Students</h3>
<!--
      <p>Lorem ipsum...</p>
-->
      <div class="table-responsive">          
      <table class="table">
      <col width="15%">
      <col width="15%">
      <col width="45%">
      <col width="25%">
        <thead>
          <tr>
            <th>Column</th>
            <th>Variable Type</th>
            <th>Data description</th>
            <th>Example format</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>uniid</td>
            <td>INTEGER</td>
            <td>Student ID ("1234567" for "s1234567")</td>
            <td>1234567</td>
          </tr>
          <tr>
            <td>rfid</td>
            <td>TEXT</td>
            <td>Student card unique RFID address</td>
            <td>1F 20 09</td>
          </tr>
          <tr>
            <td>name</td>
            <td>TEXT</td>
            <td>Student name</td>
            <td>Phil</td>
          </tr>
          <tr>
            <td>surname</td>
            <td>TEXT</td>
            <td>Student surname</td>
            <td>Collins</td>
          </tr>
          <tr>
            <td>pt_email</td>
            <td>TEXT</td>
            <td>E-mail address of students Personal Tutor (Links to Personal Tutor table)</td>
            <td>john@doe.co.uk</td>
          </tr>
        </tbody>
      </table>
      </div>
      <hr>
      <h3>Tutorials</h3>
<!--
      <p>Lorem ipsum...</p>
-->
      <div class="table-responsive">          
      <table class="table">
        <col width="15%">
        <col width="15%">
        <col width="45%">
        <col width="25%">
        <thead>
          <tr>
            <th>Column</th>
            <th>Variable Type</th>
            <th>Data description</th>
            <th>Example format</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>course</td>
            <td>TEXT</td>
            <td>Course shorthand name ("CS" for "Computer Systems")</td>
            <td>CS</td>
          </tr>
          <tr>
            <td>tutorial_id</td>
            <td>TEXT</td>
            <td>Tutorial ID for specific day and time</td>
            <td>CS_3</td>
          </tr>
          <tr>
            <td>start_time</td>
            <td>TEXT</td>
            <td>Start time of tutorial</td>
            <td>MON 14:00</td>
          </tr>
          <tr>
            <td>end_time</td>
            <td>TEXT</td>
            <td>End time of tutorial</td>
            <td>MON 14:50</td>
          </tr>
          <tr>
            <td>device_id</td>
            <td>TEXT</td>
            <td>ID of Prototype device assigned for this tutorial</td>
            <td>Device_3</td>
          </tr>
          <tr>
            <td>uniid</td>
            <td>INTEGER</td>
            <td>ID of a Student who is registered to tutorial (Links to Students table)</td>
            <td>1234567</td>
          </tr>
          <tr>
            <td>location</td>
            <td>TEXT</td>
            <td>Short tutorial location description</td>
            <td>AT Lecture Theatre 2</td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>
    <div class="col-sm-2 sidenav">
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Project: <b>"Smart Offices and Event Participation Tracking with Internet of Things"</b></p>
</footer>

</body>
EOF;

  }else{
    echo 'bad details';
  }
} else {

  echo <<<EOF
<h2>Login Form</h2>

<form action="/index.php" method="POST">
  <div class="imgcontainer">
    <img src="avatar.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit">Login</button>
<!--
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
-->
</form>
EOF;
}

?>
</body>
</html>
