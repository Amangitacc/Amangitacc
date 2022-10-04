<?php 
include_once 'connectdb.php';
session_start();
error_reporting(0);
$errors= [''];
$success[''];
$updatePass="";
$conn = mysqli_connect("localhost", "root", "", "student");

if(isset($_POST['changePassword'])){
    $password = sha1($_POST['password']);
    $confirmPassword = sha1($_POST['confirmPassword']);
 
   
        // if password not matched so
        if ($_POST['password'] != $_POST['confirmPassword']) {
            $errors['password_error'] = 'Password not matched';
      
        }
        
         else {
            $useremail = $_SESSION['useremail'];        // here note that session is use for another page as an identification of user which tells us which 
                                                            // user is accessing 

            $updatePassword = "UPDATE registrations SET password = '$password' WHERE email = '$useremail'";    // here the variable $email is comparing to the query is user belonging to the database 
            $updatePass = mysqli_query($conn, $updatePassword) or die("Query Failed");
            $success['password_success']= 'Password updated';
           
            
            session_destroy();
       
            header('refresh:1 index.php');
          }
          
        }
        


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Student | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- jQuery 3 -->
<script src="assets/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="assets/sweetalert.js"></script>
  
  
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
 
 

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="row">
    <div class="col-md-3">
<div class="login-box">
  <div class="login-logo">
    <h2>Reset Your Password</h2>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
   
    <form action="newPassword.php" method="POST" autocomplete="off">  

    <?php
            if ($errors > 0) {
                foreach ($errors as $displayError) {
            ?>
                    <div id="hidden" aria-hidden="true"><?php  $displayError; ?></div>
            <?php
                }
            } 
              if($success>0){
                foreach($success as $successmsg){
                  ?>
                  <div id="hidden" aria-hidden="true"><?php  $successmsg; ?></div>
              
              <?php    
                }
              }

            ?>


      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="New Password"  required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
    <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password"   required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
<br>
        </div>
        <div class="col-xs-4">
     <button type="submit" class="btn btn-primary btn-block btn-flat" name="changePassword" value="Save" style="border-radius: 4px;"><b>Save<b></button>
        </div>
        </div>
        <div class="link login-link text-center" style="margin: 20px 10px 0px 0px;"></div>
     
       
    
        <!-- /.col -->
       
        <!-- /.col -->
      </div>
</form>
</div>
</div>

<?php

  
  if(!empty($displayError)){

    echo'<script type="text/javascript">
  jQuery(function validation(){
  swal({
    title: "Sorry!'.$_SESSION['name'].'",
    text: "Password Not Matched!",
    icon: "error",
    button: "Ok",
    });
   });
  </script>';
  }
  
 if(empty($displayError)){

  echo'<script type="text/javascript">
  jQuery(function validation(){
  swal({
    title: "Good Job!'.$_SESSION['name'].'",
    text: "Otp Verified!",
    icon: "success",
    button: "Ok",
    });
   });
  </script>';


 }

 if(!empty($successmsg)){

  echo'<script type="text/javascript">
  jQuery(function validation(){
  swal({
    title: "Good Job!'.$_SESSION['username'].'",
    text: "Password Updated!",
    icon: "success",
    button: "Ok",
    });
   });
  </script>';

 }


  

?>

</div>
</div>
</body>
</html>







