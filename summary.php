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
  <title>Summary</title>
  <style>
    .summary_head{
      font-weight: bold;
    }
  </style>
</head>
<body>

<header class="clearfix" style="height: 10vh; background-color:#0080ff;  background-size: cover;">
    <a href="index.php"><img style="width: 80px;" src="images/iGrad Logo (Circle No Text).jpg" alt="Logo"></a><span style="font-size: 38px; color: white; margin-left: 85px;">iGrad<a href="index.php?logout=yes"><button style="float: right; margin: 15px;" class="btn btn-primary" type="button">Log out</button></a></span>
</header>

<div style="height: 40px; background-color: #4d4d4d;"><h3 style="color: white; text-align: center;">Summary<h3></div>

<div class="container">

<div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); padding: 30px;background-color: hsl(0, 0%, 94%);">

  <h4>Personal Information</h4>
  <div style="border-bottom: 1px solid lightgray; margin-bottom: 5px;"></div>
  <div class="row">
    <div class="col-12">
      <?php
          //get current user email
          $userEmail = $_SESSION['user_email'];
          //query database
          $sql = "SELECT * FROM igrad WHERE user_email = '$userEmail'";
          $result = mysqli_query($cnxn, $sql);
          //get row 
          $row = mysqli_fetch_assoc($result);
          $id = $row['std_id'];


          //personal info
          echo '<p><span class="summary_head">Name: </span>'.$row['fname'].' '.$row['lname'].'</p>';
          echo '<p><span class="summary_head">Birth Date: </span>'.$row['birthdate'].'</p>';
          echo '<p><span class="summary_head">Gender: </span>'.$row['gender'].'</p>';
          echo '<p><span class="summary_head">Birth Place: </span>'.$row['birthplace'].'</p>';
          echo '<p><span class="summary_head">Lives with: </span>'.$row['lives_with'].'</p>';

          //print ethnicity
          $sql = "SELECT DISTINCT ethnicity.ethnicity FROM igrad, ethnicity, student_race WHERE 
                    student_race.std_id = $id AND ethnicity.id = student_race.eth_id";
          $result = mysqli_query($cnxn, $sql);

          //loop over rows
          $race = "";
          while($row = mysqli_fetch_assoc($result))
          {
            $race .= $row['ethnicity'].", ";
          } 
          echo '<p><span class="summary_head">Ethinicity: </span>'.$race.'</p>';
          echo "<div style='border-bottom: 1px solid lightgray; margin-bottom: 5px;'></div>"; //border

          //education history
          echo "<br>";
          echo "<h4>Education History</h4>";
          echo "<div style='border-bottom: 1px solid lightgray; margin-bottom: 5px;'></div>"; //border
          $sql = "SELECT schoolname FROM schools WHERE std_id = '$id'";
          $result = mysqli_query($cnxn, $sql);

          //loop over rows for printing all schools
          $countschools = 1;
          while($row = mysqli_fetch_assoc($result))
          {
            echo '<h6>School '. $countschools .'</h6>';
            echo '<p><span class="summary_head">&nbsp;&nbsp;School name: </span>'.$row['schoolname'].'</p>';
            $countschools++;
          }
          echo "<div style='border-bottom: 1px solid lightgray; margin-bottom: 5px;'></div>";//border

          //parent/ guardian info
          //query database
          $sql = "SELECT * FROM igrad WHERE user_email = '$userEmail'";
          $result = mysqli_query($cnxn, $sql);
          $row = mysqli_fetch_assoc($result);
          echo "<br>";
          echo "<h4>Parent/Guardian Information</h4>";
          echo "<div style='border-bottom: 1px solid lightgray; margin-bottom: 5px;'></div>";
          echo '<p><span class="summary_head">Parent Name: </span>'.$row['pname'].'</p>';
          echo '<p><span class="summary_head">Resident Address: </span>'. $row['address'].' '.$row['zip'].'</p>';
          echo '<p><span class="summary_head">Phone no: </span>'.$row['phone'].'</p>';
          echo '<p><span class="summary_head">Email: </span>'.$row['email'].'</p>';
          echo '<p><span class="summary_head">Family Income: </span>$'.$row['income'].'</p>';
          echo "<div style='border-bottom: 1px solid lightgray; margin-bottom: 5px;'></div>";//border

          //emergency contact info
          $contact = explode(",", $row['e_contact']);
          echo "<br>";
          echo "<h4>Emergency Contact Information</h4>";
          echo "<div style='border-bottom: 1px solid lightgray; margin-bottom: 5px;'></div>";
          echo '<p><span class="summary_head">&nbsp;&nbsp;Name: </span>'.$contact[0].'</p>';
          echo '<p><span class="summary_head">&nbsp;&nbsp;Relation to child: </span>'.$contact[1].'</p>';
          echo '<p><span class="summary_head">&nbsp;&nbsp;Phone: </span>'.$contact[2].'</p>';
          echo "<br>";
   ?>
     </div>
  </div>

  <?php 
    if(isset($_POST['submit']))
    {
      $isValid = true;

      if(empty($_POST['sign']))
      {
        echo "<p style='color: red;'>Please sign here --> </p>";
        $isValid = false;
      }
    }
  ?>
  <form action="" method="post">
      <fieldset class="form-group">
        <div class="form-group row">
          <div class="col-4 offset-8">
            <small class="form-text text-muted">By signing below, I certify all information is true and correct to the best of my knowledge.</small>
          </div>
        </div>
        <div class="form-group row">
          <label style="font-size: 20px;" class="form-control-label text-md-right col-md-8 col-form-label" for="birthdate"><em>Signature: </em></label>
          <div class="col-4 has-warning">
            <input type="text" class="form-control form-control-warning" name="sign" placeholder="Type your full name">
          </div>
        </div>
      </fieldset>

      <div style="border-bottom: 1px solid lightgray; margin-bottom: 30px;"></div>
      <div class="form-group row">
      <div class="col-2">
        <a href="documents.php"><button name="back" class="btn" type="button" style="background: #4CAF50;">&larr; Back</button></a>
      </div>
      <div class="offset-8 col-2">
        <a href=""><button name="submit" class="btn btn-primary" type="submit">Submit</button></a>
      </div>
    </div> 
  </form>

</div> <!-- box shadow -->
</div><!-- content container -->

<?php 
  if(isset($_POST['submit'])) {
    if($isValid){
      $sql = "UPDATE igrad SET submit = 'yes' WHERE user_email = '$userEmail'";
      $success = mysqli_query($cnxn, $sql);

      //clean the buffer for allowing to ridirect to next page
      ob_end_clean();
      //redirect to next page
      header("Location: end.html");
      exit;
    }
  }
?>

<script src="js/jquery.slim.min.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>
