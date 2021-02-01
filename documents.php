<?php
  ob_start();
  session_start();
  //error reporting
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  require '/home/teamdesi/db.php';

  if(!isset($_SESSION['user_email']))
  {
    ob_end_clean();
    header("Location: index.php");//go to login page
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>Documents</title>
</head>
<body>

<header class="clearfix" style="height: 10vh; background-color:#0080ff;  background-size: cover;">
    <a href="index.php"><img style="width: 80px;" src="images/iGrad Logo (Circle No Text).jpg" alt="Logo"></a>
    <span style="font-size: 38px; color: white; margin-left: 85px;">iGrad<img style="margin-bottom: 5px;" src="images/gradicon.svg" alt="" width="35" height="45"> <a href="index.php?logout=yes"><button style="float: right; margin: 15px;" class="btn btn-primary" type="button">Log out</button></a></span>
</header>

<nav class="nav-pills navbar-inverse navbar-toggleable-sm" style="background-color: #4d4d4d;">
  <div class="container">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="personal-info(p).php">Personal Info</a>
      <a class="nav-item nav-link" href="education(p).php">Education</a>
      <a class="nav-item nav-link" href="parent-info(p).php">Parent/Guardian</a>
      <a class="nav-item nav-link" href="contacts-info(p).php">Contacts Info</a>
      <a class="nav-item nav-link active" href="documents.php">Documents</a>
    </div>
  </div>
</nav>

<div class="container">

<div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); padding: 30px;background-color: hsl(0, 0%, 94%);">
    <?php
    if (isset($_GET['pass'])) {
      echo "<h6 style='color: red; align: right;'>Please attach a valid file. (Format accepted: jpg, jpeg, png, pdf)</h6>";
    }else if (isset($_GET['submit'])) {
      echo "<h6 style='color: red; align: right;'>You cannot review your application before completing all forms.</h6>";
    }
    ?>
  <div class="row">
    <div class="col-2 offset-10">
      <span style="font-style: italic;">required fields: </span> ( <span style="color: red;">*</span> )
    </div>
  </div>

<form action="uploaded.php" method="post" enctype="multipart/form-data">
  <fieldset class="form-group">
    <legend>Documents</legend>

    <div class="form-group row">
      <div class="offset-2 col-10">
        <label>Please provide copies of the following documents: <span style="color: red;">*</span></label>
      </div>
    </div>

    <div class="form-group row">
          <div class="offset-2 col-4">
            Photo I.D. Student ID, if 18 years or older. Parent ID, if 16 or 17 years old
          </div>
          <div class="col-4 offset-2"><input type="file" name="fileToUpload" id="fileToUpload"> <small>jpg/ jpeg/ png/ pdf</small></div>
    </div>

    <div class="form-group row">
          <div class="offset-2 col-4">
            Copy of previous high school transcript(s) if you have them. if you don't have them, we'll send for them. All fines and fees must be paid to previous schools before official transcripts can be sent to iGrad.
          </div>
          <div class="col-4 offset-2"><input type="file" name="fileToUpload2" id="fileToUpload2"> <small>jpg/ jpeg/ png/ pdf</small></div>
    </div>
  </fieldset><!-- documents -->

  <div style="border-bottom: 1px solid lightgray; margin-bottom: 20px;"></div> <!-- gray line -->

  <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-2 offset-2">
        <a href="contacts-info(p).php"><button class="btn" type="button" style="background: #4CAF50;">&larr; Back</button></a>
      </div>
      <div class="offset-6 col-2">
        <button class="btn btn-primary" type="submit">Save & Review</button>
      </div>
    </div>
  </fieldset><!-- fieldset -->
</form>

</div> <!-- box shadow -->
</div><!-- content container -->

<script src="js/jquery.slim.min.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>
