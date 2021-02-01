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
  <title>Personal Info</title>

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
      <a class="nav-item nav-link active" href="personal-info(p).php">Personal Info</a>
      <a class="nav-item nav-link" href="education(p).php">Education</a>
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

<?php
  //define form data varibales
  $fname = "";
  $lname = "";
  $mintial = "";
  $birthday = "";
  $birthmonth = "";
  $birthyear = "";
  $gender = "";
  $birthcity = "";
  $birthstate = "";
  $birthcountry = "";
  $liveswith = array();
  $otherperson = "";
  $hispanic = "";
  $ethnicity = array();
  $id = "";

  //user email
  $userEmail = $_SESSION['user_email'];
  //read values from db if first page already submitted once
  $isNull = true;
    $sql = "SELECT * FROM igrad WHERE user_email = '$userEmail'";
    $result = mysqli_query($cnxn, $sql);
    //get row 
    $row = mysqli_fetch_assoc($result);
    $id = $row['std_id'];

    if(!is_null($row['fname']))
    {
      //get first and last name
      $fname = $row['fname'];
      $lname = $row['lname'];

      //get birthdate
      $birthdate = $row['birthdate'];
      //convert birthdate string convert into array
      $convtoArray = explode("/", $birthdate);

      //get birth date columns
      $birthmonth = $convtoArray[0];
      $birthday = $convtoArray[1];
      $birthyear = $convtoArray[2];

      //get gender
      $gender = $row['gender'];

      //birth place
      $birthplace = $row['birthplace'];
      //remove commas
      $cleanString = str_replace(',', '', $birthplace);
      //convert birthplace string into array
      $convStrtoArray = explode(" ", $cleanString);
      $birthcity = $convStrtoArray[0];
      $birthstate = $convStrtoArray[1];
      $birthcountry = $convStrtoArray[2];

      //student lives with
      $std_liveswith = $row['lives_with'];
      $liveswith = explode(", ", $std_liveswith);

      //is student hispanic/latino?
      $hispanic = $row['hispanic'];

      $isNull = false;
    }


  if(isset($_POST['submit']))
  {
    //track validity
    $isValid = true;

    //get first name
    if(!empty($_POST['fname'])){
      $fname = $_POST['fname'];
    } else {
      echo "<p class='warning'>First Name is required!</p>";
      $isValid = false;
    }

    //get last name
    if(!empty($_POST['lname'])){
      $lname = $_POST['lname'];
    } else {
      echo "<p class='warning'>Last Name is required!</p>";
      $isValid = false;
    }

    //get birth date
    if($_POST['birthmonth'] != "none" || $_POST['birthday'] != "none" || $_POST['birthyear'] != "none") {

      if($_POST['birthmonth'] != "none") {
        $birthmonth = $_POST['birthmonth'];
      } else {
        echo "<p class='warning'>Missing month in Birthdate!</p>";
        $isValid = false;
      }

      if($_POST['birthday'] != "none") {
        $birthday = $_POST['birthday'];
      } else {
        echo "<p class='warning'>Missing day in Birthdate!</p>";
        $isValid = false;
      }

      if($_POST['birthyear'] != "none") {
        $birthyear = $_POST['birthyear'];
      } else {
        echo "<p class='warning'>Missing year in birthdate!</p>";
        $isValid = false;
      }
    } else {
      echo "<p class='warning'>Birthdate is required!</p>";
      $isValid = false;
    }

    //get gender
    if($_POST['gender'] != "none") {
      $gender = $_POST['gender'];
    } else {
      echo "<p class='warning'>Please select a gender!</p>";
      $isValid = false;
    }
  }
?>

<form action="" method="post">
  <fieldset class="form-group">
    <legend>Student Info</legend>

    <div class="form-group row">
          <label class="form-control-label text-md-right col-md-2 col-form-label" for="studentfname">Student <span style="color: red;">*</span></label>
          <div class="col-4">
            <div class="input-group">
              <input class="form-control" value="<?php echo $fname ?>" name="fname" type="text" id="studentfname" placeholder="First Name"><span style="color: red;" class="input-group-addon">*</span>
            </div>
          </div>
        <!--</div>--><!-- form-group -->
  
        <div class="form-group col-4">
          <label class="form-control-label sr-only" for="studentlname">Last Name</label>
          <div class="input-group">
            <input class="form-control" value="<?php echo $lname ?>" name="lname" type="text" id="studentlname" placeholder="Last Name"><span style="color: red;" class="input-group-addon">*</span>
          </div>
        </div><!-- form-group -->

        <div class="form-group col-2">
          <label class="form-control-label sr-only" for="studentintial">Middle Intial</label>
          <input class="form-control" value="<?php echo $mintial ?>" name="mintial" type="text" id="studentintial" placeholder="Middle Intial">
        </div><!-- form-group -->
    </div><!-- form-group -->

    <div class="form-group row">
          <label class="form-control-label text-md-right col-md-2 col-form-label" for="birthdate">Birth Date <span style="color: red;">*</span></label>
          <div class="col-2">
            <select name="birthmonth" class="form-control form-control" id="todaydate">
              <option value="none">Month</option>
              <option <?php if($birthmonth=="01") echo 'selected="selected"';?> value="01">01</option>
              <option <?php if($birthmonth=="02") echo 'selected="selected"';?> value="02">02</option>
              <option <?php if($birthmonth=="03") echo 'selected="selected"';?> value="03">03</option>
              <option <?php if($birthmonth=="04") echo 'selected="selected"';?> value="04">04</option>
              <option <?php if($birthmonth=="05") echo 'selected="selected"';?> value="05">05</option>
              <option <?php if($birthmonth=="06") echo 'selected="selected"';?> value="06">06</option>
              <option <?php if($birthmonth=="07") echo 'selected="selected"';?> value="07">07</option>
              <option <?php if($birthmonth=="08") echo 'selected="selected"';?> value="08">08</option>
              <option <?php if($birthmonth=="09") echo 'selected="selected"';?> value="09">09</option>
              <option <?php if($birthmonth=="10") echo 'selected="selected"';?> value="10">10</option>
              <option <?php if($birthmonth=="11") echo 'selected="selected"';?> value="11">11</option>
              <option <?php if($birthmonth=="12") echo 'selected="selected"';?> value="12">12</option>
            </select>
          </div><!--birthdate col-->

          <div class="col-2">
            <select name="birthday" class="form-control form-control" id="todaymonth">
              <option value="none">Day</option>
              <option <?php if($birthday=="01") echo 'selected="selected"';?> value="01">01</option>
              <option <?php if($birthday=="02") echo 'selected="selected"';?> value="02">02</option>
              <option <?php if($birthday=="03") echo 'selected="selected"';?> value="03">03</option>
              <option <?php if($birthday=="04") echo 'selected="selected"';?> value="04">04</option>
              <option <?php if($birthday=="05") echo 'selected="selected"';?> value="05">05</option>
              <option <?php if($birthday=="06") echo 'selected="selected"';?> value="06">06</option>
              <option <?php if($birthday=="07") echo 'selected="selected"';?> value="07">07</option>
              <option <?php if($birthday=="08") echo 'selected="selected"';?> value="08">08</option>
              <option <?php if($birthday=="09") echo 'selected="selected"';?> value="09">09</option>
              <option <?php if($birthday=="10") echo 'selected="selected"';?> value="10">10</option>
              <option <?php if($birthday=="11") echo 'selected="selected"';?> value="11">11</option>
              <option <?php if($birthday=="12") echo 'selected="selected"';?> value="12">12</option>
              <option <?php if($birthday=="13") echo 'selected="selected"';?> value="13">13</option>
              <option <?php if($birthday=="14") echo 'selected="selected"';?> value="14">14</option>
              <option <?php if($birthday=="15") echo 'selected="selected"';?> value="15">15</option>
              <option <?php if($birthday=="16") echo 'selected="selected"';?> value="16">16</option>
              <option <?php if($birthday=="17") echo 'selected="selected"';?> value="17">17</option>
              <option <?php if($birthday=="18") echo 'selected="selected"';?> value="18">18</option>
              <option <?php if($birthday=="19") echo 'selected="selected"';?> value="19">19</option>
              <option <?php if($birthday=="20") echo 'selected="selected"';?> value="20">20</option>
              <option <?php if($birthday=="21") echo 'selected="selected"';?> value="21">21</option>
              <option <?php if($birthday=="22") echo 'selected="selected"';?> value="22">22</option>
              <option <?php if($birthday=="23") echo 'selected="selected"';?> value="23">23</option>
              <option <?php if($birthday=="24") echo 'selected="selected"';?> value="24">24</option>
              <option <?php if($birthday=="25") echo 'selected="selected"';?> value="25">25</option>
              <option <?php if($birthday=="26") echo 'selected="selected"';?> value="26">26</option>
              <option <?php if($birthday=="27") echo 'selected="selected"';?> value="27">27</option>
              <option <?php if($birthday=="28") echo 'selected="selected"';?> value="28">28</option>
              <option <?php if($birthday=="29") echo 'selected="selected"';?> value="29">29</option>
              <option <?php if($birthday=="30") echo 'selected="selected"';?> value="30">30</option>
              <option <?php if($birthday=="31") echo 'selected="selected"';?> value="31">31</option>
            </select>
          </div><!--gender col-->

          <div class="col-2">
            <select name="birthyear" class="form-control form-control">
              <option value="none">Year</option>
              <option <?php if($birthyear=="1996") echo 'selected="selected"';?> value="1996">1996</option>
              <option <?php if($birthyear=="1997") echo 'selected="selected"';?> value="1997">1997</option>
              <option <?php if($birthyear=="1998") echo 'selected="selected"';?> value="1998">1998</option>
              <option <?php if($birthyear=="1999") echo 'selected="selected"';?> value="1999">1999</option>
              <option <?php if($birthyear=="2000") echo 'selected="selected"';?> value="2000">2000</option>
              <option <?php if($birthyear=="2001") echo 'selected="selected"';?> value="2001">2001</option>
            </select>
            <!-- <input name="birthyear" value="" class="form-control" type="text" id="birthyear" placeholder="Year"> -->
          </div><!--year-->

          <label class="form-control-label text-md-right col-md-2 col-form-label" for="birthdate">Gender <span style="color: red;">*</span></label>
          <div class="col-2">
            <select name="gender" class="form-control" id="gender">
              <option value="none">Select</option>
              <option <?php if($gender=="male") echo 'selected="selected"';?> value="male">Male</option>
              <option <?php if($gender=="female") echo 'selected="selected"';?> value="female">Female</option>
            </select>
          </div><!--gender col-->
    </div><!-- form-group -->
  </fieldset><!--student info-->

  <fieldset class="form-group">
        <?php
            //get birthplace
          if(isset($_POST['submit'])) {
            if(!empty($_POST['birthcity']) || !empty($_POST['birthstate']) || !empty($_POST['birthcountry'])) {

              if(!empty($_POST['birthcity'])) {
                $birthcity = $_POST['birthcity'];
              } else {
                echo "<p class='warning'>Missing city in birthplace field!</p>";
                $isValid = false;
              }

              if(!empty($_POST['birthstate'])) {
                $birthstate = $_POST['birthstate'];
              } else {
                echo "<p class='warning'>Missing state in birthplace field!</p>";
                $isValid = false;
              }

              if(!empty($_POST['birthcountry'])) {
                $birthcountry = $_POST['birthcountry'];
              } else {
                echo "<p class='warning'>Missing country in birthplace field!</p>";
                $isValid = false;
              }
              
            } else {
              echo "<p class='warning'>Birth place is required!</p>";
              $isValid = false;
            }
          }
        ?>
  
    <div class="form-group row">
      <label class="form-control-label text-md-right col-md-2 col-form-label" for="birthcity">Birth Place <span style="color: red;">*</span></label>
      
      <div class="col-3">
        <div class="input-group">
          <input name="birthcity" value="<?php echo $birthcity ?>" class="form-control" type="text" id="birthcity" placeholder="City"><span style="color: red;" class="input-group-addon">*</span>
        </div>
      </div><!--birth city-->

      <label class="form-control-label col-md-2 col-form-label sr-only" for="birthstate">State</label>
      <div class="col-3">
        <div class="input-group">
          <input name="birthstate" value="<?php echo $birthstate ?>" class="form-control" type="text" id="birthstate" placeholder="State"><span style="color: red;" class="input-group-addon">*</span>
        </div>
      </div><!--birth city-->

      <label class="form-control-label col-md-2 col-form-label sr-only" for="birthcountry">Country</label>
      <div class="col-3">
        <div class="input-group">
          <input name="birthcountry" value="<?php echo $birthcountry ?>" class="form-control" type="text" id="birthcountry" placeholder="Country"><span style="color: red;" class="input-group-addon">*</span>
        </div>
      </div><!--birth city-->
    </div><!--birthplace-->
  </fieldset><!--birthplace form-->

  <fieldset class="form-group">
    <?php 
          //get student liveing with details
          if(isset($_POST['submit'])) {
            if(isset($_POST['liveswith'])) {
                $liveswith = $_POST['liveswith'];

                //remeber form data
                $livingwith = "";
                $counter = 0;
                foreach ($liveswith as $person) {
                  if($counter != 0)
                    {
                      $livingwith .=", ";
                    }
                    $livingwith .= $person; 
                    $counter++;  
                  }      
              } else {
                echo "<p class='warning'>Student lives with field required!</p>";
                $isValid = false;
            }
          }
        ?>
    <div class="form-group row">
      <div class="col-10 offset-2">
        <label class="form-control-label" for="liveswith">Student Lives With</label>
        <div class="form-group row">
          <div class="col-2">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Both parents", $liveswith)) echo 'checked';?> value="Both parents" name="liveswith[]" class="form-check-input" type="checkbox"> Both parents
              </label>
            </div><!-- form-check -->
          </div>

          <div class="col-2">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Mother Only", $liveswith)) echo 'checked';?> name="liveswith[]" class="form-check-input" value="Mother Only" type="checkbox"> Mother only
              </label>
            </div><!-- form-check -->
          </div>

          <div class="col-3">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Father/Stepmother", $liveswith)) echo 'checked';?>  name="liveswith[]" value="Father/Stepmother" class="form-check-input" type="checkbox"> Father/Stepmother
              </label>
            </div><!-- form-check -->
          </div>

          <div class="col-2">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Guardians", $liveswith)) echo 'checked';?> name="liveswith[]" value="Guardians" class="form-check-input" type="checkbox"> Guardians
              </label>
            </div><!-- form-check -->
          </div>

          <div class="col-2">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Self", $liveswith)) echo 'checked';?> name="liveswith[]" value="Self" class="form-check-input" type="checkbox"> Self
              </label>
            </div><!-- form-check -->
          </div>
        </div><!--first row check-->

        <div class="form-group row">
          <div class="col-2">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Gradparents", $liveswith)) echo 'checked';?> name="liveswith[]" value="Gradparents" class="form-check-input" type="checkbox"> Gradparents
              </label>
            </div><!-- form-check -->
          </div>

          <div class="col-2">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Father Only", $liveswith)) echo 'checked';?> name="liveswith[]" value="Father Only" class="form-check-input" type="checkbox"> Father only
              </label>
            </div><!-- form-check -->
          </div>

          <div class="col-3">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Mother/Stepfather", $liveswith)) echo 'checked';?> name="liveswith[]" value="Mother/Stepfather" class="form-check-input" type="checkbox"> Mother/Stepfather
              </label>
            </div><!-- form-check -->
          </div>

          <div class="col-2">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Foster Parent", $liveswith)) echo 'checked';?> name="liveswith[]" value="Foster Parent" class="form-check-input" type="checkbox"> Foster Parent
              </label>
            </div><!-- form-check -->
          </div>

          <div class="col-2">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Agency", $liveswith)) echo 'checked';?> name="liveswith[]" value="Agency" class="form-check-input" type="checkbox"> Agency
              </label>
            </div><!-- form-check -->
          </div>
        </div><!--row2 form check-->

        <div class="form-group row">
          <div class="col-2">
            <div class="form-check">
              <label class="form-check-label">
                <input <?php if(in_array("Other", $liveswith)) echo 'checked';?> name="liveswith[]" value="Other" class="form-check-input" type="checkbox"> Other
              </label>
            </div><!-- form-check -->
          </div>

          <div class="col-4">
            <input value="<?php echo $otherperson ?>" name="otherperson" class="form-control form-control-sm" type="text" id="liveswithother" placeholder="Who, If other">
          </div>
        </div><!--last row form check-->
      </div>
    </div>
  </fieldset><!--Student lives with field set-->


  <!-- get ethnicity -->
        <?php 
          if(isset($_SESSION['page1']))
          {
            if(!$isNull)
            {
              $sql = "SELECT DISTINCT ethnicity.ethnicity FROM igrad, ethnicity, student_race WHERE 
                    student_race.std_id = $id AND ethnicity.id = student_race.eth_id";
              $result = mysqli_query($cnxn, $sql);

              $race = "";
              //get row 
              while($row = mysqli_fetch_assoc($result))
              {
                $race .= $row['ethnicity'].", ";
              } 
              $ethnicity = explode(", ", $race);
            }
          }

          if(isset($_POST['submit'])) {
            if(isset($_POST['ethnicity']) && isset($_POST['hispanic'])) {
                $ethnicity = $_POST['ethnicity'];
                $hispanic = $_POST['hispanic'];
                //remeber form data
                // $race = "";
                // $counter = 0;
                // foreach ($ethnicity as $raceType) {
                //   if($counter != 0)
                //   {
                //       $race .=", ";
                //   }
                //   $race .= $raceType; 
                //   $counter++;  
                // }      
              } else {
                echo "<p class='warning'>Ethnicity field is required!</p>";
                $isValid = false;
            }
          }
        ?> <!-- ethnicity -->
  <!-- ethnicity modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Ethnicity</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div style="background-color: hsl(0, 0%, 94%);" class="modal-body">
          <fieldset id="latinofield" class="form-group">
            <div class="form-group row">
              <div class="col-12">
                <label class="form-control-label" for="ethnicity">If Hispanic or Latino Origin? (Check all that apply.)</label>
                <div class="row">
                  <div class="col-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Cuban", $ethnicity)) echo 'checked';?> value="Cuban" class="form-check-input" type="checkbox"> Cuban
                      </label>
                    </div><!-- form-check -->
                  </div>

                  <div class="col-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Dominican", $ethnicity)) echo 'checked';?> value="Dominican" class="form-check-input" type="checkbox"> Dominican
                      </label>
                    </div><!-- form-check -->
                  </div>

                  <div class="col-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Spaniard", $ethnicity)) echo 'checked';?> value="Spaniard" class="form-check-input" type="checkbox"> Spaniard
                      </label>
                    </div><!-- form-check -->
                  </div>

                  <div class="col-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Puerto Rican", $ethnicity)) echo 'checked';?> value="Puerto Rican" class="form-check-input" type="checkbox"> Puerto Rican
                      </label>
                    </div><!-- form-check -->
                  </div>

                  <div class="col-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Central American", $ethnicity)) echo 'checked';?> value="Central American" class="form-check-input" type="checkbox"> Central American
                      </label>
                    </div><!-- form-check -->
                  </div>

                  <div class="col-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("South American", $ethnicity)) echo 'checked';?> value="South American" class="form-check-input" type="checkbox"> South American
                      </label>
                    </div><!-- form-check -->
                  </div>

                  <div class="col-3">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Latin American", $ethnicity)) echo 'checked';?> value="Latin American" class="form-check-input" type="checkbox"> Latin American
                      </label>
                    </div><!-- form-check -->
                  </div>

                  <div class="col-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Other Hispanic/Latino", $ethnicity)) echo 'checked';?> value="Other Hispanic/Latino" class="form-check-input" type="checkbox"> Other Hispanic/Latino
                      </label>
                    </div><!-- form-check -->
                  </div>

                </div>
            </div>
          </fieldset>

          <fieldset class="form-group">
            <div class="form-group row">
              <div class="col-12">
                <label class="form-control-label" for="ethnicity">What race(s) do you consider your child? (Check all that apply)</label>
                <div class="row">
                  <div class="col-4">
                    <h6>Asian</h6>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Asian Indian", $ethnicity)) echo 'checked';?> value="Asian Indian" class="form-check-input" type="checkbox"> Asian Indian
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Cambodian", $ethnicity)) echo 'checked';?> value="Cambodian" class="form-check-input" type="checkbox"> Cambodian
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Chinese", $ethnicity)) echo 'checked';?> value="Chinese" class="form-check-input" type="checkbox"> Chinese
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Filipino", $ethnicity)) echo 'checked';?> value="Filipino" class="form-check-input" type="checkbox"> Filipino
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Hmong", $ethnicity)) echo 'checked';?> value="Hmong" class="form-check-input" type="checkbox"> Hmong
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Indonesian", $ethnicity)) echo 'checked';?> value="Indonesian" class="form-check-input" type="checkbox"> Indonesian
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Japanese", $ethnicity)) echo 'checked';?> value="Japanese" class="form-check-input" type="checkbox"> Japanese
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Korean", $ethnicity)) echo 'checked';?> value="Korean" class="form-check-input" type="checkbox"> Korean
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Laotian", $ethnicity)) echo 'checked';?> value="Laotian" class="form-check-input" type="checkbox"> Laotian
                      </label>
                    </div><!-- form-check -->

                    <div id="more-asian" class="collapse">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Malaysian", $ethnicity)) echo 'checked';?> value="Malaysian" class="form-check-input" type="checkbox"> Malaysian
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Pakistani", $ethnicity)) echo 'checked';?> value="Pakistani" class="form-check-input" type="checkbox"> Pakistani
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Singaporean", $ethnicity)) echo 'checked';?> value="Singaporean" class="form-check-input" type="checkbox"> Singaporean
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Taiwanese", $ethnicity)) echo 'checked';?> value="Taiwanese" class="form-check-input" type="checkbox"> Taiwanese
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Thai", $ethnicity)) echo 'checked';?> value="Thai" class="form-check-input" type="checkbox"> Thai
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Vietnamese", $ethnicity)) echo 'checked';?> value="Vietnamese" class="form-check-input" type="checkbox"> Vietnamese
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Other Asian", $ethnicity)) echo 'checked';?> value="Other Asian" class="form-check-input" type="checkbox"> Other Asian
                        </label>
                      </div><!-- form-check -->
                    </div>
                    <button type="button" data-toggle="collapse" data-target="#more-asian" class="btn btn-outline-primary btn-sm">&#8675; more</button>
                    </div>

                  <div class="col-4">
                    <h6>Native Hawaiian</h6>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Native Hawaiian", $ethnicity)) echo 'checked';?> value="Native Hawaiian" class="form-check-input" type="checkbox"> Native Hawaiian
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Fijian", $ethnicity)) echo 'checked';?> value="Fijian" class="form-check-input" type="checkbox"> Fijian
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Guamanian or Chamorro", $ethnicity)) echo 'checked';?> value="Guamanian or Chamorro" class="form-check-input" type="checkbox"> Guamanian or Chamorro
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Mariana Islander", $ethnicity)) echo 'checked';?> value="Mariana Islander" class="form-check-input" type="checkbox"> Mariana Islander
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Melanesian", $ethnicity)) echo 'checked';?> value="Melanesian" class="form-check-input" type="checkbox"> Melanesian
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Samoan", $ethnicity)) echo 'checked';?> value="Samoan" class="form-check-input" type="checkbox"> Samoan
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Tongan", $ethnicity)) echo 'checked';?> value="Tongan" class="form-check-input" type="checkbox"> Tongan
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Other Pacific Islander", $ethnicity)) echo 'checked';?> value="Other Pacific Islander" class="form-check-input" type="checkbox"> Other Pacific Islander
                      </label>
                    </div><!-- form-check -->
                  </div>

                  <div class="col-4">
                    <h6>American Indian or Alaskan Native</h6>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Alaska Native", $ethnicity)) echo 'checked';?> value="Alaska Native" class="form-check-input" type="checkbox"> Alaska Native
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Chehalis", $ethnicity)) echo 'checked';?> value="Chehalis" class="form-check-input" type="checkbox"> Chehalis
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Colville", $ethnicity)) echo 'checked';?> value="Colville" class="form-check-input" type="checkbox"> Colville
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Cowlitz", $ethnicity)) echo 'checked';?> value="Cowlitz" class="form-check-input" type="checkbox"> Cowlitz
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Hoh", $ethnicity)) echo 'checked';?> value="Hoh" class="form-check-input" type="checkbox"> Hoh
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Hames", $ethnicity)) echo 'checked';?> value="Hames" class="form-check-input" type="checkbox"> Hames
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Kalispel", $ethnicity)) echo 'checked';?> value="Kalispel" class="form-check-input" type="checkbox"> Kalispel
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Lower Elwha", $ethnicity)) echo 'checked';?> value="Lower Elwha" class="form-check-input" type="checkbox"> Lower Elwha
                      </label>
                    </div><!-- form-check -->

                    <div class="form-check">
                      <label class="form-check-label">
                        <input name="ethnicity[]" <?php if(in_array("Lummi", $ethnicity)) echo 'checked';?> value="Lummi" class="form-check-input" type="checkbox"> Lummi
                      </label>
                    </div><!-- form-check -->

                    <div id="more-alaskan" class="collapse">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Makah", $ethnicity)) echo 'checked';?> value="Makah" class="form-check-input" type="checkbox"> Makah
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Muckleshoot", $ethnicity)) echo 'checked';?> value="Muckleshoot" class="form-check-input" type="checkbox"> Muckleshoot
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Nisqually", $ethnicity)) echo 'checked';?> value="Nisqually" class="form-check-input" type="checkbox"> Nisqually
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Nooksack", $ethnicity)) echo 'checked';?> value="Nooksack" class="form-check-input" type="checkbox"> Nooksack
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Port Gamble Challam", $ethnicity)) echo 'checked';?> value="Port Gamble Challam" class="form-check-input" type="checkbox"> Port Gamble Challam
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Puyallup", $ethnicity)) echo 'checked';?> value="Puyallup" class="form-check-input" type="checkbox"> Puyallup
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Quileute", $ethnicity)) echo 'checked';?> value="Quileute" class="form-check-input" type="checkbox"> Quileute
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Samish", $ethnicity)) echo 'checked';?> value="Samish" class="form-check-input" type="checkbox"> Samish
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Sauk-Suiattle", $ethnicity)) echo 'checked';?> value="Sauk-Suiattle" class="form-check-input" type="checkbox"> Sauk-Suiattle
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Shoalwater", $ethnicity)) echo 'checked';?> value="Shoalwater" class="form-check-input" type="checkbox"> Shoalwater
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Other Washington Indian", $ethnicity)) echo 'checked';?> value="Other Washington Indian" class="form-check-input" type="checkbox"> Other Washington Indian
                        </label>
                      </div><!-- form-check -->

                      <div class="form-check">
                        <label class="form-check-label">
                          <input name="ethnicity[]" <?php if(in_array("Other North, Central, or South American", $ethnicity)) echo 'checked';?> value="Other North, Central, or South American" class="form-check-input" type="checkbox"> Other North, Central, or South American
                        </label>
                      </div><!-- form-check -->
                    </div>
                    <button type="button" data-toggle="collapse" data-target="#more-alaskan" class="btn btn-outline-primary btn-sm">&#8675; more</button>
                  </div>

                </div>
            </div>
          </fieldset>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
        </div>
        
      </div>
    </div>
  </div>

  <fieldset class="form-group">
  <legend>Ethnicity</legend>

   <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-10 offset-2">
        <label class="form-control-label" for="ethnicity">Is the student of Hispanic or Latino origin?</label>
        
        <div class="form-group row">
            <div class="col-5">
              <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input data-toggle="modal" data-target="#myModal" <?php if($hispanic=="yes") echo 'checked';?> id="yes" class="form-check-input" type="radio" name="hispanic" value="yes"> Yes
                </label>
              </div><!-- form-check -->

              <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input data-toggle="modal" data-target="#myModal" <?php if($hispanic=="no") echo 'checked';?> id="no" class="form-check-input" type="radio" name="hispanic" value="no"> No
                </label>     
            </div><!-- form-check -->          
          </div>
        </div>
      </div>
  </fieldset>

  <?php
    if(isset($_POST['submit'])) {
      if($isValid){
        $birthplace = $birthcity." ".$birthstate.", ".$birthcountry;
        $birthdate = $birthmonth.'/'.$birthday.'/'.$birthyear;

        $ethnicity = $_POST['ethnicity'];

        $sql = "UPDATE igrad SET fname = '$fname', lname = '$lname', birthdate='$birthdate', gender='$gender',birthplace='$birthplace', lives_with='$livingwith', hispanic = '$hispanic' WHERE user_email = '$userEmail'";
        $success = mysqli_query($cnxn, $sql);

        if($success)
        {
          //query database
          $sql = "SELECT * FROM igrad WHERE user_email = '$userEmail'";
          $result = mysqli_query($cnxn, $sql);
          //get row 
          $row = mysqli_fetch_assoc($result);
          //delete previous data
          $id = $row['std_id'];
          $sql = "DELETE FROM student_race WHERE std_id = $id";
          $run = mysqli_query($cnxn, $sql);

          //add new ethnicities
          foreach($ethnicity as $race)
          {
            $sql = "INSERT INTO student_race VALUES((SELECT ethnicity.id FROM ethnicity WHERE ethnicity.ethnicity = '$race'), (SELECT igrad.std_id FROM igrad WHERE igrad.user_email = '$userEmail'))";
            $success = mysqli_query($cnxn, $sql);
          }
          $_SESSION['page1'] = "done";
        }
      }
    }
   ?>
  <div style="border-bottom: 1px solid lightgray; margin-bottom: 20px;"></div> <!-- gray line -->

  <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-2 offset-2">
      
      </div>
      <div class="offset-6 col-2">
        <button name="submit" class="btn btn-primary" type="submit">Save & Continue</button>
      </div>
    </div>
  </fieldset><!-- fieldset -->
</form>
</div> <!-- box shadow -->
</div><!-- content container -->

<?php 
  if(isset($_POST['submit'])) {
    if($isValid)
    {
      ob_end_clean();
      header("Location: education(p).php");
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
      //hispanic or latino and race field
      $("#latinofield").hide();

      //show fields if user click yes
      $("#yes").click(function(){
        $("#latinofield").show(200);
      });

      //if no 
      $("#no").click(function(){
        $("#latinofield").hide(300);
        $('#latinofield input:checked').removeAttr('checked');
      });
    });
  </script>

</html>
