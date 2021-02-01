<?php
  ob_start();
  session_start();
  //error reporting
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  require '/home/teamdesi/db.php';

  if(isset($_GET['logout']))
  {
    unset($_SESSION['user_email']);
    unset($_SESSION['passw']);
    ob_end_clean();
    header("Location: index.php");
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

  <script src="http://code.jquery.com/jquery.js"></script> <!-- jquery liabray -->
  <title>iGrad Login</title>

  <style>
    .warning{
      color: orange;
    }
  </style>
</head>
<body>
  <body>
    
    <header class="clearfix" style="height: 10vh; background-color:#0080ff;  background-size: cover;">
      <img style="width: 80px;" src="images/iGrad Logo (Circle No Text).jpg" alt="Logo"><span style="font-size: 38px; color: white; margin-left: 85px;">iGrad<img style="margin-bottom: 5px;" src="images/gradicon.svg" alt="" width="35" height="45"><button style="float: right; margin: 15px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">Login as Admin</button></span>
    </header>

    <div style="height: 40px; background-color: #4d4d4d;"></div>
    <?php
    if (isset($_GET['pass'])) {
     echo "<p style= ' text-align: center; font-size:18px; color: red;'>Please enter a valid Admin Email and Password</p>";
    }
    ?>

    <?php 
      $_SESSION['admin_mail'] = 'admin@igrad.com';
      $_SESSION['admin_pass'] = 'abc123';
      $admin_mail = $_SESSION['admin_mail'];
      $admin_pass = $_SESSION['admin_pass'];
    ?>
    <!-- Staff login -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div style="background-color: lightgray;" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Staff Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="adminlogin.php" method="post">
          <div style="padding: 40px; background-color: hsl(0, 0%, 94%);" class="modal-body">
            <div class="form-group row">
              <input class="form-control" value="<?php echo $admin_mail?>" type="text" name="adminemail" placeholder="Email">
            </div>
            <div class="form-group row">
                <input class="form-control" value="<?php echo $admin_pass?>" type="password" name="adminpassword" placeholder="Password">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          </form>
        </div>
      </div>
    </div> <!-- Staff login -->

    <!-- age -->
    <form action="" method="post">
    <div class="modal fade" id="age" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div style="background-color: lightgray;" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Enter your Birthdate:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div style="padding: 40px; background-color: hsl(0, 0%, 94%);" class="modal-body">
            <div class="form-group row">
              <div class="col-4">
                <input name="month" class="form-control form-control" type="text" placeholder="Month">
              </div>

              <div class="col-4">
                <input name="day" class="form-control form-control" type="text" placeholder="Day">
              </div>

              <div class="col-4">
                <?php //confirm age from user
                  if(isset($_POST['ok']))
                  {
                    $isValid = true;

                    //check student is at least 16 
                    if(!empty($_POST['year']) && !empty($_POST['month']) && !empty($_POST['day']))
                    {
                      if($_POST['year'] >= 2001)
                      {
                        if($_POST['year'] > 2001)
                        {
                          $isValid = false;
                        } else if($_POST['year'] == 2001 && $_POST['month'] > 7)
                        {
                          $isValid = false;
                        }
                      }
                      else if($_POST['year'] <= 1996)
                      {
                        if($_POST['year'] < 1996)
                        {
                          $isValid = false;
                        } else if($_POST['year'] == 1996 && $_POST['month'] < 8)
                        {
                          $isValid = false;
                        }
                      }
                      else if(($_POST['month'] > 12 || $_POST['month'] < 1) || ($_POST['day'] > 31 || $_POST['day'] < 1) || ($_POST['year'] < 1920 || $_POST['year'] > 2017)) {
                          $isValid = false;
                      }
                    }
                  } 
                ?>
                <input name="year" class="form-control form-control" type="text" placeholder="Year">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button name="ok" type="submit" class="btn btn-primary">OK</button>
          </div>
        </div>
      </div>
    </div> <!-- age -->
  <!-- </form> -->
  
    <div class="container">
      <?php 
        //show an error if user enter age below 16 or above 20
        if(!empty($_POST['year']) && !empty($_POST['month']) && !empty($_POST['day']))
        {
          //check data type
          if(!is_numeric($_POST['year']) || !is_numeric($_POST['month']) || !is_numeric($_POST['day'])) {
            echo "<h5 style='text-align: center; color: red;'>Invalid data type!</h5>";
          } 
          else if(!$isValid)
          {
              echo "<h4 style='text-align: center; color: red;'>We are sorry, you are not eligible for this program!</h4>";
          }
          else if($isValid)
          {
            $r_email = $_POST['email'];
            $password = $_SESSION['createPassw'];
            $sql = "INSERT INTO igrad (user_email, password) VALUES('$r_email',SHA1('$password'));";
            $success = mysqli_query($cnxn, $sql);

            //move to next page if success
            if($success)
            {
              ob_end_clean();
              header("Location: personal-info(p).php");
              exit;
            }
          }
        }
       ?>
      <div style="margin:50px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); padding: 50px; background-color: hsl(0, 0%, 94%);">
      <div class="form-group row">
        <div class="col-2">
          <h3>Log In</h3>
        </div>
        <div class="col-2 offset-8">
          <h3 style="float: right;">Register</h3>
        </div>
      </div>
    
      <div style="border-top: 1px solid lightgray; margin-bottom: 20px; margin-top: 20px;"></div><!-- border -->

      <div class="form-group row">
        <div class="col-5"> 
          <?php 
            $isValidLogin = true;
            $loginEmail = "";
            $loginPassw = "";

            //hit login
            if(isset($_POST['login']))
            { 
              //get email
              if(!empty($_POST['login-email']))
              {
                $loginEmail = $_POST['login-email'];
                //validate email
                if (!filter_var($_POST["login-email"], FILTER_VALIDATE_EMAIL)) {
                  echo "<p class='warning'>Invalid email!</p>"; 
                  $isValidLogin = false;
                } 
                else 
                {
                  // if(isset($_POST['login']))
                  // {
                    if(!empty($_POST['login-passw']))
                    {
                      $loginPassw = $_POST['login-passw'];

                      $sql = "SELECT user_email,password FROM igrad WHERE user_email = '$loginEmail' AND password = SHA1('$loginPassw');";
                      $result = mysqli_query($cnxn, $sql);

                      //check email and password is in db
                      if(mysqli_num_rows($result) != 1)
                      {
                        $isValidLogin = false;
                        echo "<p class='warning'>Incorrect email or password!</p>";
                      } else {
                        if($isValidLogin)
                        {
                          $sql = "SELECT * FROM igrad WHERE user_email = '$loginEmail' AND password = SHA1('$loginPassw');";
                          $result = mysqli_query($cnxn, $sql);
                          $row = mysqli_fetch_assoc($result);

                          //set session
                          $_SESSION['user_email'] = $loginEmail;
                          $_SESSION['passw'] = $loginPassw;

                          //already submitted
                          if(!is_null($row['submit']))
                          {
                            ob_end_clean();
                            header("Location: submit.html");//go to next page
                            exit;
                          }else {
                            ob_end_clean();
                            header("Location: personal-info(p).php");//go to next page
                            exit;
                          }
                        }
                      }
                    }
                    else
                    {
                      $isValidLogin = false;
                      echo "<p class='warning'>Enter a password!</p>";
                    }
                }
              }
              else 
              {
                echo "<p class='warning'>Enter you email and password!</p>";
                $isValidLogin = false;
              }        
            }
          ?>
          <div class="form-group row" style="margin-bottom: 30px;">
          <input class="form-control" type="text" value="<?php echo $loginEmail;?>" name="login-email" placeholder="Email">
          </div>
          <div class="form-group row" style="margin-bottom: 30px;">
          <input class="form-control" type="password" value="<?php echo $loginPassw;?>" name="login-passw" placeholder="Password">
          </div>
          <div class="form-group row" style="margin-bottom: 30px;">
                <button style="width: 120px;" name="login" class="btn btn-primary" type="submit">Log in</button>
          </div>
          <div class="form-group row">
              <a id='show' href="" data-toggle="modal" data-target="#forgotpassword">Forgot Password?</a>
          </div>
          
            <div class="modal fade" id="forgotpassword" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="Title">Reset Password</h5>
                      
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div id = '' class="modal-body">
                          <div class="form-group">
                            <label> Please enter your email or phone number to search for your account.</label>
                            <input type="text" class="form-control">
                          </div>                                            
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary btn-sm">Submit</button>   
                        </div>
                      </div>
                    </div>
            </div>
        </div>

        <div style=" margin-left: 72px; border-left: 1px solid lightgray; height: 235px;"></div>

        <div class="col-5 offset-1">
          <div class="form-group row" style="margin-bottom: 30px;">
            <?php
            $email = "";
            $isValidUser = true;

            if(isset($_POST['register']))
            {
              //Get email
              if(!empty($_POST['email']))
              {
                $email = $_POST['email'];
                if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                  echo "<p class='warning'>Invalid email!</p>"; 
                  $isValidUser = false;
                } //else {
                  //$email = $_POST['email'];
                //}
              }
              else{
                  echo "<p class='warning'>Email is required!</p>";
                  $isValidUser = false;
              }

              //check email in database
              $sql = "SELECT user_email FROM igrad";
              $result = mysqli_query($cnxn, $sql);

              while($row = mysqli_fetch_assoc($result))
              {
                if($email == $row['user_email'])
                {
                  $isValidUser = false;
                }
              }

              if(!$isValidUser)
              {
                echo "<p class='warning'>This Email already registered!</p>";
              } 
            }
          ?>
          <input class="form-control" type="text" value="<?php echo $email?>" name="email" placeholder="Email">
          </div>
          <div class="form-group row" style="margin-bottom: 30px;">
          <?php 
            $newPassw = "";
            $confirmPassw = "";
            $passw = "";
            if(isset($_POST['register']))
            {
              //get new password
              if(empty($_POST['createPassw']))
              {
                $newPassw = $_POST['createPassw'];
                echo "<p class='warning'>Create a password!</p>";
                $isValidUser = false;
              }
              else if(empty($_POST['confirmPassw']))
              {
                $confirmPassw = $_POST['confirmPassw'];
                echo "<p class='warning'>Confirm a password!</p>";
                $isValidUser = false;
              }

              if(!empty($_POST['createPassw']) && !empty($_POST['confirmPassw']))
              {
                if($_POST['createPassw'] === $_POST['confirmPassw'])
                {
                  $passw = $_POST['confirmPassw'];
                  $_SESSION['createPassw'] = $_POST['confirmPassw'];
                }
                else {
                  $isValidUser = false;
                  echo "<p class='warning'>Password does not match!</p>";
                }
              }
            }
          ?>
          <input class="form-control" value="<?php echo $newPassw?>" type="password" name="createPassw" placeholder="Create Password">
          </div>
          <div class="form-group row" style="margin-bottom: 30px;">
          <input class="form-control" value="<?php echo $confirmPassw?>" type="password" name="confirmPassw" placeholder="Confirm Password">
          </div>
          <div class="row">
            <!-- <div class="col-2 offset-9"> -->
              <button id="register" name="register" style="width: 120px;" class="btn btn-primary" type="submit" data-toggle="modal" data-target="">Register</button>
            <!-- </div> -->
          </div>
  </form>
        </div>
      </div>
      </div>
      </div>
    </div>


  <script src="js/jquery.slim.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/scripts.js"></script>

  <?php
  if(isset($_POST['register']))
  {
      if($isValidUser)
      {
        $_SESSION['user_email'] = $email;
        $_SESSION['passw'] = $passw;
        echo "<script>$('#age').modal('show');</script>";
      }
  }
  ?>
  </body>
</html>