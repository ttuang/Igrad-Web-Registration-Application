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
  <title>Parent/Guardian Info</title>

  <style>
    .warning{
      color: red;
    }
  </style>
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
      <a class="nav-item nav-link active" href="parent-info(p).php">Parent/Guardian</a>
      <a class="nav-item nav-link" href="contacts-info(p).php">Contacts Info</a>
      <a class="nav-item nav-link" href="documents.php">Documents</a>
    </div>
  </div>
</nav>

<div class="container">

<div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); padding: 30px;background-color: hsl(0, 0%, 94%);">
  <div class="row">
    <div class="col-2 offset-10">
      <span style="font-style: italic;">required fields: </span> ( <span style="color: red;">*</span> )
    </div>
  </div>

<form action="" method="post">

  <?php
  //define form data varibales
  $fname = "";
  $lname = "";
  $mintial = "";
  $street = "";
  $apt = "";
  $city = "";
  $state = "";
  $zip = "";
  $phonetype = "";
  $phone = "";
  $email = ""; 
  $income = "";
  $incomeType = "";
  $mail_address = "";
  $court_order = "";
  $parent_plan = "";

  //get current user email
  $userEmail = $_SESSION['user_email'];
  //query database
  $sql = "SELECT * FROM igrad WHERE user_email = '$userEmail'";
  $result = mysqli_query($cnxn, $sql);
  //get row 
  $row = mysqli_fetch_assoc($result);

  if(!is_null($row['pname']))
  {
    //read name from db
    $pname = explode(' ', $row['pname']);
    $fname = $pname[0];
    $lname = $pname[1];

    //read address
    $p_aaddress = explode(', ', $row['address']);
    $street = $p_aaddress[0];
    $city = $p_aaddress[1];
    $state = $p_aaddress[2];
    $zip = $row['zip'];

    //read phone and email
    $phone = $row['phone'];
    $phonetype = $row['phone_type'];
    $email = $row['email'];

    //read income
    $f_inco = explode(', ', $row['income']);
    $incomeType = $f_inco[0];
    $income = $f_inco[1];

    //mail address
    $mail_address = $row['rsdt_address'];

    //parent plan and court order field
    $court_order = $row['court_order'];
    $parent_plan = $row['parenting_plan'];
  }

  if(isset($_POST['submit']))
  {
    //track validity
    $isValid = true;

    //get first name
    if(!empty($_POST['pfname'])){
      $fname = $_POST['pfname'];
    } else {
      echo "<p class='warning'>First Name is required!</p>";
      $isValid = false;
    }

    //get last name
    if(!empty($_POST['plname'])){
      $lname = $_POST['plname'];
    } else {
      echo "<p class='warning'>Last Name is required!</p>";
      $isValid = false;
    }

    //get middle intial
    if(!empty($_POST['mintial'])){
      $mintial = $_POST['mintial'];
    } 

    //get city 
    if(!empty($_POST['street'])){
      $street = $_POST['street'];
    } else {
      echo "<p class='warning'>Street is required in address field!</p>";
      $isValid = false;
    }

    //get apartment
    if(!empty($_POST['apt'])){
      $apt = $_POST['apt'];
    }

    //get city 
    if(!empty($_POST['city'])){
      $city = $_POST['city'];
    } else {
      echo "<p class='warning'>City is required in address field!</p>";
      $isValid = false;
    } 

    //get state 
    if(!empty($_POST['state'])){
      $state = $_POST['state'];
    } else {
      echo "<p class='warning'>State is required in address field!</p>";
      $isValid = false;
    } 

    //get state 
    if(!empty($_POST['zip'])){
      $zip = $_POST['zip'];
    } else {
      echo "<p class='warning'>Zip code is required!</p>";
      $isValid = false;
    }
  }
  ?>

  <fieldset class="form-group">
    <legend>Primary Household</legend>
    <div class="form-group row">
      <div class="col-10 offset-2">
        <!-- <label class="form-control-label" for="household">Parent/Guardian where student resides</label> -->
      </div>
    </div>

    <div class="form-group row">
        <label class="form-control-label text-md-right col-md-2 col-form-label" for="parentfname">Parent/Guardian<span style="color: red;">*</span></label>
        <div class="col-4">
          <div id="city_wrap" class="input-group">
            <input value="<?php echo $fname ?>" name="pfname" class="form-control" type="text" id="parentfname" placeholder="First Name"><span style="color: red;" class="input-group-addon">*</span>
          </div>
        </div><!-- form-group -->
  
        <div class="form-group col-4">
          <label class="form-control-label sr-only" for="parentlname">Last Name</label>
          <div class="input-group">
            <input value="<?php echo $lname ?>" name="plname" class="form-control" type="text" id="parentlname" placeholder="Last Name"><span style="color: red;" class="input-group-addon">*</span>
          </div>
        </div><!-- form-group -->

        <div class="form-group col-2">
          <label class="form-control-label sr-only" for="parentintial">Middle Intial</label>
          <input value="<?php echo $mintial ?>" name="mintial" class="form-control" type="text" id="parentintial" placeholder="Middle Intial">
        </div><!-- form-group -->
    </div>

    <div class="form-group row">
      <!-- <div class="col-10"> -->
        <label class="form-control-label text-md-right col-md-2 col-form-label" for="household">Resident Address<span style="color: red;">*</span></label>

        <!-- <div class="form-group row"> -->
          <div class="col-4">
            <input value="<?php echo $street ?>" name="street" class="form-control" type="text" id="street" placeholder="Street">
          </div>

          <div class="col-2">
            <input value="<?php echo $apt ?>" name="apt" class="form-control" type="text" id="apt" placeholder="Apt #">
          </div>

          <div class="col-2">
            <input value="<?php echo $city ?>" name="city" class="form-control" type="text" id="city" placeholder="City">
          </div>
    </div>

    <div class="form-group row">
        <div class="col-4 offset-2">
          <input value="<?php echo $state ?>" name="state" class="form-control" type="text" id="state" placeholder="State">
        </div>

        <div class="col-4">
          <input value="<?php echo $zip ?>" name="zip" class="form-control" type="text" id="zip" placeholder="Zip">
        </div>
    </div>

    <?php 
      if(isset($_POST['submit']))
      {
        //get phone type
        if($_POST['phonetype'] != "none"){
          $phonetype = $_POST['phonetype'];
        } else {
          echo "<p class='warning'>Please select phone type!";
          $isValid = false;
        }

        //get phone number
        if(!empty($_POST['phone'])){
          $phone = $_POST['phone'];
        } else {
          echo "<p class='warning'>Phone number is required!</p>";
          $isValid = false;
        }  

        //get email
        if(!empty($_POST['email'])){
          $email = $_POST['email'];
        } else {
          echo "<p class='warning'>Email is required!</p>";
          $isValid = false;
        } 

        //get mailing address
        if(isset($_POST['mail_address'])){
          $mail_address = $_POST['mail_address'];
        }
      }
    ?>
    <div class="form-group row">
        <label class="form-control-label text-md-right col-md-2 col-form-label" for="household">Resident Phone<span style="color: red;">*</span></label>

        <div class="col-2">
          <select name="phonetype" class="form-control form-control-sm" id="gender">
            <option value="none">Select</option>
            <option <?php if($phonetype=="homephone") echo 'selected="selected"';?>  value="homephone">Home</option>
            <option <?php if($phonetype=="cellnumber") echo 'selected="selected"';?> value="cellnumber">Cell number</option>
          </select>
        </div><!--phone type-->

        <div class="col-4">
          <input value="<?php echo $phone ?>" name="phone" class="form-control form-control" type="text" id="phonenumber" placeholder="(555)-555-5555">
        </div>

        <div class="col-4">
          <input value="<?php echo $email ?>" name="email" class="form-control form-control" type="text" id="email" placeholder="Email">
        </div>
    </div><!--Resident address form-->

    <div class="form-group row">
      <div class="col-10 offset-2">
        <label class="form-control-label" for="household">Mailing Address:</label> <span style="color: red;">*</span>
        <div class="form-group row">
          <div class="col-4">
            <div class="form-check">
              <label class="form-check-label">
                <input name="mail_address" <?php if($mail_address == "same as resident") echo 'checked';?> value="same as resident" class="form-check-input" id="sameaddress" type="checkbox"> Same as Resident Address
              </label>
            </div><!-- form-check -->
          </div>
        </div>

        <div class="form-group row mailaddress">
          <div class="col-4">
            <input class="form-control" type="text" id="street" placeholder="Street">
          </div>

          <div class="col-2">
            <input class="form-control" type="text" id="apt" placeholder="Apt #">
          </div>

          <div class="col-2">
            <input class="form-control" type="text" id="apt" placeholder="PO Box">
          </div>

          <div class="col-2">
            <input class="form-control" type="text" id="city" placeholder="City">
          </div>
        </div>

        <div class="form-group row mailaddress">
          <div class="col-4">
            <input class="form-control" type="text" id="state" placeholder="State">
          </div>

          <div class="col-4">
            <input class="form-control" type="text" id="zip" placeholder="Zip">
          </div>
        </div>

      </div>
    </div>
  </fieldset> <!--Mailing address form-->

  <!-- get family income -->
  <?php 
    if(isset($_POST['submit']))
    {
      if(!empty($_POST['income']))
      {
        $income = $_POST['income'];
        $incomeType = $_POST['incomeType'];
      } else {
        echo "<p class='warning'>Family income is required!</p>";
        $isValid = false;
      }
    }
  ?>
  <!-- Family income -->
  <fieldset class="form-group">
    <div class="form-group row">
      <label class="form-control-label text-md-right col-md-2 col-form-label" for="household">Family Income<span style="color: red;">*</span></label>
      <div class="col-3">
        <div class="input-group">
            <span style="color: blue;" class="input-group-addon">$</span><input value="<?php echo $income ?>" name="income" class="form-control" type="text" id="parentfname" placeholder="">
        </div>
      </div>

      <div class="col-2">
        <select name="incomeType" class="form-control form-control-sm" id="incomeType">
            <option <?php if($incomeType=="Monthly") echo 'selected="selected"';?> value="Monthly">Monthly</option>
            <option <?php if($incomeType=="Yearly") echo 'selected="selected"';?> value="Yearly">Yearly</option>
          </select>
      </div>
    </div>
  </fieldset>

  <?php 
    if(isset($_POST['submit']))
    {
      if(!isset($_POST['parentingplan']))
      {
        echo "<p class='warning'>Missing field!</p>";
        $isValid = false;
      } else {
        $parent_plan = $_POST['parentingplan'];
      }
    }
  ?>
  <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-10 offset-2">
          <label class="form-control-label" for="parentingplan">IS THERE A PARENTING PLAN IN EFFECT? </label>

          <div class="form-group row">
            <div class="col-5">
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input id="addBtn1" <?php if($parent_plan=="yes") echo 'checked';?> class="form-check-input" type="radio" name="parentingplan" value="yes"> Yes
                </label>
              </div><!-- form-check -->

              <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input id="removeBtn1" <?php if($parent_plan=="no") echo 'checked';?> class="form-check-input" type="radio" name="parentingplan" value="no"> No
                </label>
                <label class="form-check-label firstDoc">please attach a copy</label>
              </div><!-- form-check --> 
            </div>

            <div class="col-4">
              <button type="button" class="btn btn-sm btn-outline-primary firstDoc">&#43;Attach File</button> <span class="firstDoc"> jpg/ png/ pdf</span>
            </div>
          </div>
      </div>   
    </div>
  </fieldset><!--pareting planing-->

  <?php 
    if(isset($_POST['submit']))
    {
      if(!isset($_POST['parentingplan2']))
      {
        echo "<p class='warning'>Missing field!</p>";
        $isValid = false;
      }
      else{
        $court_order = $_POST['parentingplan2'];
      }
    }
  ?>
  <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-10 offset-2">
          <label class="form-control-label" for="courtorder">IS THERE A COURT ORDER IN EFFECT THAT LIMITS  EDUCATIONAL  DECISION MAKING OR CONTACT WITH THE STUDENT OR SCHOOL(RESTRAINING  ORDER,PROTECTION ORDER,NO CONTACT ORDER, ANTI-HARRASSMENT ORDER,ETC.)?</label>

          <div class="form-group row">
            <div class="col-5">
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input id="addBtn2" <?php if($court_order=="yes") echo 'checked';?>  class="form-check-input" type="radio" name="parentingplan2" value="yes"> Yes
                </label>
              </div><!-- form-check -->

              <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input id="removeBtn2" <?php if($court_order=="no") echo 'checked';?> class="form-check-input" type="radio" name="parentingplan2" value="no"> No
                </label>
                <label class="form-check-label secondDoc">please attach a copy</label>
              </div><!-- form-check --> 
            </div>

            <div class="col-4">
              <button type="button" class="btn btn-sm btn-outline-primary secondDoc">&#43;Attach File</button> <span class="secondDoc"> jpg/ png/ pdf</span>
            </div>
          </div>

          <div class="form-group row secondDoc">
            <div class="col-3">
              <label class="form-control-label" for="courtorder">Court order limits</label>
            </div>

            <div class="col-2">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox"> Mother
                </label>
              </div><!-- form-check -->             
            </div>

            <div class="col-2">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox"> Father
                </label>
              </div><!-- form-check -->             
            </div>

            <div class="col-1.5">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox"> Other
                </label>
              </div><!-- form-check -->             
            </div>

            <div class="col-2">
              <input class="form-control form-control-sm" type="text" id="orderlimit" placeholder="Who, if other">
            </div>
          </div>
      </div>   
    </div>
  </fieldset><!--pareting planing-->

  <?php
    if(isset($_POST['submit'])) {
      if($isValid){
        $address = $street.', '.$city.', '.$state;
        $name = $fname.' '.$lname;
        $inco = $incomeType.', '.$income;

        //update entry in the db.
        $sql = "UPDATE igrad SET pname = '$name' , address = '$address', zip = '$zip', phone = '$phone', email = '$email', income = '$inco', parenting_plan = '$parent_plan', court_order = '$court_order', rsdt_address = '$mail_address', phone_type = '$phonetype' WHERE user_email = '$userEmail'";
        $success = mysqli_query($cnxn, $sql);

        $_SESSION['page3'] = 'done';
      }
    }
   ?>
  <div style="border-bottom: 1px solid lightgray; margin-bottom: 20px;"></div> <!-- gray line -->

  <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-2 offset-2">
        <a href="education(p).php"><button name="back" class="btn" type="button" style="background: #4CAF50;">&larr; Back</button></a>
      </div>
      <div class="offset-6 col-2">
        <button name="submit" class="btn btn-primary" type="submit">Save & Continue</button>
      </div>
    </div>
  </fieldset><!-- fieldset -->
</form>

<!-- <div style="padding: 30px; background-color: hsl(0, 0%, 94%);"> -->
</div> <!-- box shadow -->
</div><!-- content container -->

<?php 
  if(isset($_POST['submit'])) {
    if($isValid){
      ob_end_clean();
      header("Location: contacts-info(p).php");
      exit;
    }
  }
?>

<script src="js/jquery.slim.min.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>
</body>

<script src="http://code.jquery.com/jquery.js"></script>

  <script>
    //load script when page is loaded
    $(document).ready(function(){
      //hide attach button fieds
      $(".firstDoc").hide();
      $(".secondDoc").hide();

      //show first attach button when click
      $("#addBtn1").click(function(){
        $(".firstDoc").show(100);
      });

      //show second attach button when click
      $("#addBtn2").click(function(){
        $(".secondDoc").show(100);
      });

      //remove first button if click no
      $("#removeBtn1").click(function(){
        $(".firstDoc").hide(100);
      });

      //remove second button and other checkboxes when click no
      $("#removeBtn2").click(function(){
        $(".secondDoc").hide(100);
      });

      //remove mailing address if its same as resident address
      $("#sameaddress").click(function(){
        if($("#sameaddress").is(':checked')){
          $(".mailaddress").hide(500);
        } else {
          $(".mailaddress").show(500);
        } 
      });
    });
  </script>
</html>
