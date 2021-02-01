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
  <title>Contacts Information</title>
</head>

  <style>
    .warning{
      color: red;
    }
  </style>
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
      <a class="nav-item nav-link active" href="contacts-info(p).php">Contacts Info</a>
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
    $name = "";
    $relation = "";
    $emPhone = "";
    $authorize = "";

    //get current user email
    $userEmail = $_SESSION['user_email'];
    //query database
    $sql = "SELECT * FROM igrad WHERE user_email = '$userEmail'";
    $result = mysqli_query($cnxn, $sql);
    //get row 
    $row = mysqli_fetch_assoc($result);

    if(!is_null($row['autho']))
    {
      $contact = explode(", ", $row['e_contact']);
      $name = $contact[0];
      $relation = $contact[1];
      $emPhone = $contact[2];
      $authorize = $row['autho'];
    }

    if(isset($_POST['submit']))
    {
      $isValid = true;

      //get name
      if(!empty($_POST['name']))
      {
        $name = $_POST['name'];
      } else {
        echo "<p class='warning'>Contact name is required!</p>";
        $isValid = false;
      }

      //get relation 
      if(!empty($_POST['relation']))
      {
        $relation = $_POST['relation'];
      } else {
        echo "<p class='warning'>Relation field is missing!</p>";
        $isValid = false;
      }

      if(!empty($_POST['phone']))
      {
        $emPhone = $_POST['phone'];
      } else {
        echo "<p class='warning'>Phone number is required!</p>";
        $isValid = false;
      }
    }
  ?>
  <fieldset class="form-group">
    <legend>Emergency Contact Information</legend>
    <div class="form-group row">
      <div class="col-10 offset-2">
        <label class="form-control-label" for="childcaretitle">When an emergency situation occurs involving your child,we want to be able to quickly reach responsible adults. In the event we cannot reach a parent/guardian, please list persons you trust who are available during the day to provide care for your child.</label>

        <!-- first contact -->
        <div class="form-group row">
          <div class="col-6">
            <small class="form-text text-muted">Contact (other than parent/guardian) <span style="color: red;">*</span></small>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-4">
            <input class="form-control" value="<?php echo $name?>" type="text" name="name" id="emergencycontact1" placeholder="Name">
          </div>
          
          <div class="col-3">
            <input class="form-control" value="<?php echo $relation?>" type="text" name="relation" id="relation1" placeholder="Relation to Child:">
          </div>

          <div class="col-4">
            <input class="form-control" value="<?php echo $emPhone?>" type="text" name="phone" id="emergencycontact1phn" placeholder="Phone: (555)-555-5555">
          </div>
        </div>

        <!-- other contacts -->
        <div id="otherContacts">

        </div>

        <div class="form-group row">
            <div class="col-3">
              <button id="addcontact" type="button" class="form-control bg-warning">&#43;Add Contact</button>
            </div>
            <div class="col-3 offset-5">
              <button type="button" style="color: white;" id="removeContact" class="form-control form-control-sm bg-danger">&#43;Remove Contact</button>
            </div>
          </div>
      </div>
    </div>
  </fieldset><!--emergency contact form-->  

  <?php 
    if(isset($_POST['submit']))
    {
      if(isset($_POST["authorization"]))
      {
        $authorize = $_POST['authorization'];
      } else {
         echo "<p class='warning'>Need student release authorization!</p>";
        $isValid = false;
      }
    }
  ?>
  <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-10 offset-2">
        STUDENT RELEASE AUTHORIZATION: <span style="color: red;">*</span>
        <div class="form-check">
          <label class="form-check-label">
            <input <?php if($authorize == "authorized") echo 'checked';?> name="authorization" value="authorized" class="form-check-input" id="sameaddress" type="checkbox"> In the event the school unable to contact the parents or legal guardian, I authorize my child to be released to the parson(s) listed above.
          </label>
        </div><!-- form-check -->
      </div>
    </div>
  </fieldset>

  <div style="border-bottom: 1px solid lightgray; margin-bottom: 20px;"></div> <!-- gray line -->

  <fieldset class="form-group">
    <div class="form-group row">
      <div class="col-2 offset-2">
        <a href="parent-info(p).php"><button class="btn" type="button" style="background: #4CAF50;">&larr; Back</button>
      </div>
      <div class="offset-6 col-2">
        <a href=""><button name="submit" class="btn btn-primary" type="submit">Save & Continue</button></a>
      </div>
    </div>
  </fieldset><!-- fieldset -->
</form>

</div>
</div><!-- content container -->

<?php 
  if(isset($_POST['submit'])) {
    if($isValid)
    {
      $e_contact = $name.', '.$relation.', '.$emPhone;
      $sql = "UPDATE igrad SET e_contact = '$e_contact' , autho = '$authorize' WHERE user_email = '$userEmail'";
      $success = mysqli_query($cnxn, $sql);

      if($success)
      {
        //clean the buffer for allowing to ridirect to next page
        ob_end_clean();
        //redirect to next page
        header("Location: documents.php");
        exit;
      } 
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
      $('#removeContact').hide();
      var counter = 2;

      $("#addcontact").click(function(){
        $('#removeContact').show(500);

        var newContactrow = $(document.createElement('div')).addClass("form-group row");
        newContactrow.attr('id','contact' + counter);
        newContactrow.hide();
        var contactName = $(document.createElement('div')).addClass("col-4");
        var relation = $(document.createElement('div')).addClass("col-3");
        var phone = $(document.createElement('div')).addClass("col-4");

        contactName.after().html("<input class='form-control' name='name[]' type='text' placeholder='Name'>");
        relation.after().html("<input class='form-control' name='relation[]' type='text' placeholder='Relation to Child:'>");
        phone.after().html("<input class='form-control' name='phone[]' type='text' placeholder='Phone: (555)-555-5555'>");

        if(counter < 5)
        {
          newContactrow.appendTo("#otherContacts");
          contactName.appendTo(newContactrow);
          relation.appendTo(newContactrow);
          phone.appendTo(newContactrow);
          newContactrow.show(250);
        }
        counter++;
        if(counter >= 5)
        {
          counter = 5;
        }
      });

      $("#removeContact").click(function(){
        counter--;
        if(counter <= 2)
        {
          counter = 2;
        }
        if(counter > 1)
        {
          $("#contact" + counter).remove();
        }
        if(counter <= 2)
        {
          $('#removeContact').hide(150);
        }
      });
    });
  </script>
</html>
