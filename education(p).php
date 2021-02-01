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
  <title>Education History</title>

  <style>
    .warning{
      color: red;
    }

    .slow{
      -webkit-transition: 1s;
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
      <a class="nav-item nav-link active" href="education(p).php">Education</a>
      <a class="nav-item nav-link" href="parent-info(p).php">Parent/Guardian</a>
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
  $schoolname = array();
  $schools = array();
  $city = array();
  $state = array();
  $startyear = array();
  $endyear = array();
  $programs = array();
  $suspended = "";

    $schoolSet = false;
    $citySet = false;
    $stateSet = false;
    $startyearSet = false;
    $endyearSet = false;
    //get current user email
    $userEmail = $_SESSION['user_email'];
    //query database
    $sql = "SELECT * FROM igrad WHERE user_email = '$userEmail'";
    $result = mysqli_query($cnxn, $sql);
    //get row 
    $row = mysqli_fetch_assoc($result);
    $id = $row['std_id'];

    if(!is_null($row['suspended']))
    {
      //get first and last name
      $suspended = $row['suspended'];
      $programs = explode(", ", $row['special_program']);

      //check schools
      $sql = "SELECT * FROM schools WHERE std_id = '$id'";
      $result = mysqli_query($cnxn, $sql);

      if(mysqli_num_rows($result) >= 1)
      {
        $index = 0;
        while($row = mysqli_fetch_assoc($result))
        {
          $dbSchool = $row['schoolname'];
          // $cleanString = str_replace(',', '', $dbSchool);
          $cleanStr = str_replace('-', ',', $dbSchool);
          $convStrtoArray = explode(",", $cleanStr);

          $schoolname[$index] = $convStrtoArray[0];
          $city[$index] = $convStrtoArray[1]; 
          $state[$index] = $convStrtoArray[2];
          $startyear[$index] = $convStrtoArray[3]; 
          $endyear[$index] = $convStrtoArray[4]; 

          $schoolSet = true;
          $citySet = true;
          $stateSet = true;
          $startyearSet = true;
          $endyearSet = true;
          $index++;
        }
      }
    }

  if(isset($_POST['submit']))
  {
    $isValid = true;

    $schoolstr = implode(", ", $_POST['school']);
    $citystr = implode(", ", $_POST['city']);
    $statestr = implode(", ", $_POST['state']);
    $startyrstr = implode(", ", $_POST['startyear']);
    $endyrstr = implode(", ", $_POST['endyear']);

      //get school
      if(!empty($schoolstr))
      {
        $schoolname = $_POST['school'];
        $schoolSet = true;
      } else {
        echo "<p class='warning'>School name is required!</p>";
        $isValid = false;
      }

      if(!empty($citystr))
      {
        $city = $_POST['city'];
        $citySet = true;
      } else {"<p class='warning'>Missing city!</p>"; $isValid = false;}

      if(!empty($statestr))
      {
        $state = $_POST['state'];
        $stateSet = true;
      } else {"<p class='warning'>Missing state year!</p>"; $isValid = false;}

      if(!empty($startyrstr))
      {
        $startyear = $_POST['startyear'];
        $startyearSet = true;
      } else {echo "<p class='warning'>Missing start year!</p>"; $isValid = false;}

      if(!empty($endyrstr))
      {
        $endyear = $_POST['endyear'];
        $endyearSet = true;
      } else {echo "<p class='warning'>Missing end year!</p>"; $isValid = false;}

      if($isValid)
      {
        $index = 0;
        while($index < sizeof($schoolname))
        {
          $schools[$index] = $schoolname[$index].', '.$city[$index].', '.$state[$index].', '.$startyear[$index].'-'.$endyear[$index];
          // $schools[$index] = $schoolname[$index].' '.$city[$index].', '.$state[$index].' '.$startyear[$index].'-'.$endyear[$index];
          $index++;
        }
      } 
  }
?>
  <fieldset class="form-group">
    <legend>Education History</legend>
    <div class="form-group row">
        <div class="col-10 offset-2">
          <label class="form-control-label" for="schools">Please list every high school or institution in which you earned high school credit: </label> <span style="color: red;">*</span>
          <div class="form-group row">
            <div class="col-4">
              <label class="form-control-label sr-only" for="schoolname">School / Institution Name</label>
              <input name="school[]" value="<?php if($schoolSet) {echo $schoolname[0];}?>" class="form-control" type="text" id="studentintial" placeholder="School / Institution Name">
            </div>
            <div class="col-2">
              <label class="form-control-label sr-only" for="city">City</label>
              <input name="city[]" value="<?php if($citySet) {echo $city[0];}?>" class="form-control" type="text" id="city" placeholder="City">
            </div>
            <div class="col-2">
              <label class="form-control-label sr-only" for="state">State</label>
              <input name="state[]" value="<?php if($stateSet) {echo $state[0];}?>" class="form-control" type="text" id="state" placeholder="State">
            </div>
            <div class="col-2">
              <label class="form-control-label sr-only" for="startyear">Start Year</label>
              <input name="startyear[]" value="<?php if($startyearSet) {echo $startyear[0];}?>" class="form-control" type="text" id="startyear" placeholder="Start Year">
            </div>
            <div class="col-2">
              <label class="form-control-label sr-only" for="endyear">End Year</label>
              <input name="endyear[]" value="<?php if($endyearSet) {echo $endyear[0];}?>" class="form-control" type="text" id="endyear" placeholder="End Year">
            </div>
          </div><!--School 1-->

          <div id="otherSchool">
            <?php 
              $sql = "SELECT * FROM schools WHERE std_id = '$id'";
              $result = mysqli_query($cnxn, $sql);

              if(mysqli_num_rows($result) >= 1)
              {
                $i = 0;
                while($row = mysqli_fetch_assoc($result))
                {
                  if($i > 0)
                  {
                    $dbSchool = $row['schoolname'];
                    $cleanString = str_replace(',', '', $dbSchool);
                    $cleanStr = str_replace('-', ' ', $cleanString);
                    $convStrtoArray = explode(" ", $cleanStr);

                    echo "<div class='form-group row'>";
                    $schoolname[$index] = $convStrtoArray[0];
                    $city[$index] = $convStrtoArray[1]; 
                    $state[$index] = $convStrtoArray[2];
                    $startyear[$index] = $convStrtoArray[3]; 
                    $endyear[$index] = $convStrtoArray[4]; 
                    echo "<div class='col-4'>
                          <input name='school[]' value='$schoolname[$i]' class='form-control' type='text' id='studentintial' placeholder='School / Institution Name'>
                          </div>"; //school name

                    echo "<div class='col-2'>
                          <input name='city[]' value='$city[$i]' class='form-control' type='text' id='studentintial' placeholder='city'>
                          </div>"; //school city

                    echo "<div class='col-2'>
                          <input name='state[]' value='$state[$i]' class='form-control' type='text' id='studentintial' placeholder='State'>
                          </div>"; //school state

                    echo "<div class='col-2'>
                          <input name='startyear[]' value='$startyear[$i]' class='form-control' type='text' id='studentintial' placeholder='Start Year'>
                          </div>"; //start year

                    echo "<div class='col-2'>
                          <input name='endyear[]' value='$endyear[$i]' class='form-control' type='text' id='studentintial' placeholder='Start Year'>
                          </div>"; //end year

                    echo "</div>"; //close row
                  }
                  $i++;
                }
              }
            ?>
          </div><!--School 2-->


          <div class="form-group row">
            <div class="col-2">
              <button type="button" id="addSchool" class="form-control bg-warning">&#43;Add School</button>
            </div>

            <div class="col-3 offset-7">
              <button style="color: white;" type="button" id="removeSchool" class="form-control bg-danger form-control-sm">Remove School</button>
            </div>
          </div><!--add school-->
        </div>
    </div>
  </fieldset>

<?php //get sepcial program
  $program = "";
  if(isset($_POST['submit']))
  {
     if(isset($_POST['program'])) {
        $programs = $_POST['program'];

        //remeber form data
        $counter = 0;
        foreach ($programs as $cureent_program) 
        {
            if($counter != 0)
            {
              //add commas at the end if user select multiple programs
              $program .=", ";
            }
            $program .= $cureent_program; 
            $counter++;  
        }      
      } 
  }
?>
  <fieldset class="form-group">
    <div class="form-group row">
        <div class="col-10 offset-2">
          <label class="form-control-label" for="programs">Did you participate in any of the following programs? (Check all that apply)</label>
          <div class="form-check">
            <label class="form-check-label">
              <input <?php if(in_array("Special Education", $programs)) echo 'checked';?> name="program[]" class="form-check-input" type="checkbox" value="Special Education"> Special Education
            </label>
          </div><!-- form-check -->

          <div class="form-check">
            <label class="form-check-label">
              <input <?php if(in_array("504", $programs)) echo 'checked';?> name="program[]" class="form-check-input" type="checkbox" value="504"> 504
            </label>
          </div><!-- form-check -->

          <div class="form-check">
            <label class="form-check-label">
              <input <?php if(in_array("English Language Learner", $programs)) echo 'checked';?> name="program[]" class="form-check-input" type="checkbox" value="English Language Learner"> English Language Learner
            </label>
          </div><!-- form-check -->
      </div>
    </div>
  </fieldset><!--form check-->

<?php //get suspended field data
  if(isset($_POST['submit']))
  {
    if(isset($_POST['suspended']))
    {
      $suspended = $_POST['suspended'];
      $_SESSION['suspended'] = $suspended; 
    } else {
      echo "<p class='warning'>Missing field!</p>";
      $isValid = false;
    }
  }
?>
  <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-6 offset-2">
          <label class="form-control-label" for="suspended">Are you currently suspended or expelled from a previous school? <span style="color: red;">*</span></label>
          <div class="form-check form-check-inline">
            <label class="form-check-label">
              <input <?php if($suspended=="yes") echo 'checked';?> class="form-check-input" type="radio" name="suspended" value="yes"> Yes
            </label>
          </div><!-- form-check -->   

          <div class="form-check form-check-inline">
            <label class="form-check-label">
              <input <?php if($suspended=="no") echo 'checked';?> class="form-check-input" type="radio" name="suspended" value="no"> No
            </label>
          </div><!-- form-check -->       
      </div>
    </div>
  </fieldset>

  <?php
    if(isset($_POST['submit'])) {
      if($isValid){
        // $school_address = $city.', '.$state;
        // $start_endyear = $startyear.'-'.$endyear;

        //update entry in the db.
        $sql = "UPDATE igrad SET special_program = '$program' , suspended = '$suspended' WHERE user_email = '$userEmail'";
        $success = mysqli_query($cnxn, $sql);

        //add schools
        if($success)
        {
          //query database
          $sql = "SELECT * FROM igrad WHERE user_email = '$userEmail'";
          $result = mysqli_query($cnxn, $sql);
          //get row 
          $row = mysqli_fetch_assoc($result);
          //delete previous data
          $id = $row['std_id'];

          $sql = "DELETE FROM schools WHERE std_id = $id";
          $run = mysqli_query($cnxn, $sql);

          //add new schools
          //add new ethnicities
          foreach($schools as $name)
          {
            $sql = "INSERT INTO schools (schoolname, std_id) VALUES('$name', (SELECT std_id from igrad where std_id = $id));";
            $success = mysqli_query($cnxn, $sql);
          }
          $_SESSION['page2'] = "done";
        }
      }
    }
   ?>
  <div style="border-bottom: 1px solid lightgray; margin-bottom: 20px;"></div> <!-- gray line -->

  <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-2 offset-2">
        <a href="personal-info(p).php"><button class="btn" name="back" type="button" style="background: #4CAF50;">&larr; Back</button></a>
      </div>
      <div class="offset-6 col-2">
        <button class="btn btn-primary" name="submit" type="submit">Save & Continue</button>
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
      //clean the buffer for allowing to ridirect to next page
      ob_end_clean();
      //redirect to next page
      header("Location: parent-info(p).php");
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
    //load script on page load
    $(document).ready(function(){
      $('#removeSchool').hide();
      var counter = 2;

      $("#addSchool").click(function(){
        $('#removeSchool').show(500);
        var newSchoolrow = $(document.createElement('div')).addClass("form-group row");
            newSchoolrow.attr('id','school' + counter);
            newSchoolrow.hide();
        var newSchool = $(document.createElement('div')).addClass("col-4");
        var newCity = $(document.createElement('div')).addClass("col-2");
        var newState = $(document.createElement('div')).addClass("col-2");
        var newStartYr = $(document.createElement('div')).addClass("col-2");
        var newEndYr = $(document.createElement('div')).addClass("col-2");

        newSchool.after().html("<input class='form-control' name='school[]' type='text' placeholder='School / Institution Name'>");
        newCity.after().html("<input class='form-control' name='city[]' type='text' placeholder='City'>");
        newState.after().html("<input class='form-control' name='state[]' type='text' placeholder='State'>");
        newStartYr.after().html("<input class='form-control' name='startyear[]' type='text' placeholder='Start Year'>");
        newEndYr.after().html("<input class='form-control' name='endyear[]' type='text' placeholder='End Year'>");

        if(counter < 6)
        {
          newSchoolrow.appendTo("#otherSchool");
          newSchool.appendTo(newSchoolrow);
          newCity.appendTo(newSchoolrow);
          newState.appendTo(newSchoolrow);
          newStartYr.appendTo(newSchoolrow);
          newEndYr.appendTo(newSchoolrow);
          newSchoolrow.show(250);
        }
        counter++;
        if(counter >= 6)
        {
          counter = 6;
        }
      });

      $("#removeSchool").click(function(){
        counter--;
        if(counter <= 2)
        {
          counter = 2;
        }
        if(counter > 1)
        {
          $("#school" + counter).remove();
        }
        if(counter <= 2)
        {
          $('#removeSchool').hide(150);
        }
      });
    });
  </script>

</html>
