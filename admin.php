<?php
  ob_start();
  session_start();
  //error reporting
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  require '/home/teamdesi/db.php';
?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">  
      <title>Admin Page</title>
    </head>
        
<header class="clearfix" style="height: 10vh; background-color:#0080ff;  background-size: cover;">
    <a href="index.php"><img style="width: 80px;" src="images/iGrad Logo (Circle No Text).jpg" alt="Logo"></a><span style="font-size: 38px; color: white; margin-left: 85px;">iGrad<img style="margin-bottom: 5px;" src="images/gradicon.svg" alt="" width="35" height="45"><a href="logout.php"><button style="float: right; margin: 15px;" class="btn btn-primary" type="button">Log out</button> </a></span>
</header>
        
        <style>
          th {
            color: #4d4d4d;
          }
          td{
            color: #666666;
          }
        </style>
<nav class="nav-pills navbar-inverse navbar-toggleable-sm" style="background-color: #4d4d4d;">
  <div class="container">
    <div class="navbar-nav">
     <h2 style="color: white;"> Student Information </h2>
     
    </div>
  </div>
</nav>
    
    <div class="container">
        
        <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); padding: 30px;
    background-color: hsl(0, 0%, 94%);">
       
        
   <div class="container">
      

      <table id="salaryData" class="display" cellspacing="">
        <thead>
            <tr>
               <th>#</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Form Status</th>
                <th>View Info</th>
            </tr>
        </thead>
 
        <tbody>
               <?php
                $id = 0;

                $getinfo = "SELECT * FROM igrad";
                $check = mysqli_query($cnxn, $getinfo);

                  while($row = mysqli_fetch_assoc($check))
                  {
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $phone = $row['phone'];
                    $email = $row['user_email'];
                    $submit = $row['submit'];

                    $id++;
                    if(!is_null($row['fname']))
                    {
                      echo "<tr>";
                      echo "<td>$id</td>";
                      echo "<td>$lname</td>";
                      echo "<td>$fname</td>";
                      echo "<td>$phone</td>";
                      echo "<td>$email</td>";
                      if(!is_null($row['submit']))
                      {
                        echo "<td>Complete</td>";
                      } else {
                        echo "<td>Incomplete</td>";
                      }
                      echo "<td><button data-toggle='modal' data-target='#22222' id='$email' type='button' class='links btn btn-outline-primary'>View</button></td>";
                      echo "</tr>";
                    }
                }
               ?>
            
        </tbody>
    </table>
                
                
    <div class="modal fade" id="22222" tabindex="-1" role="dialog" aria-labelledby="Title" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="Title">Student Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id = 'detail' class="modal-body">
                                 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-sm">Email</button>
            <button type="button" class="btn btn-primary btn-sm">Approve</button>
            <button type="button" class="btn btn-primary btn-sm">Print</button>
          </div>
        </div>
      </div>
    </div>

      
    </div>
        
        
        <div style="border-bottom: 1px solid lightgray; margin-bottom: 20px;"></div> <!-- gray line -->

                <fieldset class="form-group">
                    <div class="form-group row">
                        <div class="col-2 offset-2">
                            <button class="btn" type="submit" style="background: #4CAF50;">&larr; Back</button>
                        </div>
                    </div>
                </fieldset><!-- fieldset -->
          
        </div> <!-- box shadow -->
        </div><!-- content container -->
        
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $("#salaryData").DataTable()
    </script>
    </body>

    <script src="http://code.jquery.com/jquery.js"></script>

    <script>
        $(".links").click(function(){
            var text = $(this).attr('id');
            console.log(text);
            $.post(
                "data.php",
                {text: text},

                function(result){
                    $("#detail").html(result);
                }
            );
        });
    </script>
</html>

