<?php
include_once 'connectdb.php';
session_start();
error_reporting(0);
$errors= [''];
$success[''];
$conn = mysqli_connect("localhost", "root", "", "pos_db");

if(isset($_POST['verifyEmail'])){
    
    $OTPverify = mysqli_real_escape_string($conn, $_POST['OTPverify']);
    $verifyQuery = "SELECT * FROM tbl_user WHERE code = $OTPverify";
    $runVerifyQuery = mysqli_query($conn, $verifyQuery);
    if($runVerifyQuery){
        if(mysqli_num_rows($runVerifyQuery) > 0){

          $fetch_data = mysqli_fetch_assoc($runVerifyQuery);
          $fetch_code = $fetch_data['code'];

          $update_status = "Verified";
          $update_code = 0;

            $newQuery = "UPDATE tbl_user SET status = '$update_status', code = $update_code WHERE code = $fetch_code";
            $run = mysqli_query($conn,$newQuery);

            if($run){
              header("location: newPassword.php");
            }
            
        }else{
            $errors ['verification_error'] = "Invalid Verification Code";
        }
    }else{
        $errors['db_error'] = "Failed while checking Verification Code from database!";
    }
  } else{
      $success['db_success'] = "valid code!";
  }







?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Student | Sign up</title>
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
 
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="row">
    <div class="col-md-3">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Student</b>Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="height: 255px;">
   

    <form action="verifyotp.php" method="POST" autocomplete="">

    <?php
            if(isset($_SESSION['message'])){
                ?>
                <div class="hidden" aria-hidden="true"><?php echo $_SESSION['message']; ?></div>
                <?php
            }
            ?>

            <?php
            if($errors > 0){
                foreach($errors AS $displayErrors){
                ?>
                 <div class="hidden" aria-hidden="true"><?php echo $displayErrors; ?></div>
                <?php
                }
            }
            ?>      
            <!-- <input type="number" name="OTPverify" placeholder="Verification Code" required><br>
            <input type="submit" name="verifyEmail" value="Verify"> -->

                    <h2 class="text-center">Otp Verify</h2>
                    <p class="text-center">It's quick and easy.</p>
                    <?php
                 
                    ?>
                   
                    <div class="form-group">
                    <input class ="form-control" type="number" name="OTPverify" placeholder="Verification Code" required>
                    </div>
                    
                   
                   
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="verifyEmail"><b>Verify<b></button>
                    </div>
                   
                </form>

   

      
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?php

if(empty($error)){

 

}

if(empty($displayErrors)){

  echo'<script type="text/javascript">
jQuery(function validation(){
swal({
  title: "Good Job!'.$_SESSION['name'].'",
  text: "Otp Send On Email!",
  icon: "success",
  button: "Ok",
  });
 });
</script>';


}

if(!empty($displayErrors)){

  echo'<script type="text/javascript">
  jQuery(function validation(){
  swal({
    title: "Not Verified!",
    text: "Otp Not Matched!",
    icon: "error",
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




