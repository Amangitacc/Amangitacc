<?php
include_once 'connectdb.php';
session_start();
error_reporting(0);
$errors= [''];
$success[''];

$conn = mysqli_connect("localhost", "root", "", "pos_db");

if (isset($_POST['btnsubmit'])) {
   
    $email = $_POST['txt_email'];
    $_SESSION['useremail'] = $email;        // here it is more important because it maintain the session of the user, use on another page also 
                                                                              // it tells us who the user is to be to perform action like edit, update etc
    $emailCheckQuery = "SELECT * FROM tbl_user WHERE useremail = '$email'";
    $emailCheckResult = mysqli_query($conn, $emailCheckQuery);
    while($row = mysqli_fetch_array($emailCheckResult)){

      $_SESSION['username']=$row['username'];
    }

    // if query run
    if ($emailCheckResult) {
        // if email matched
        

        if (mysqli_num_rows($emailCheckResult) > 0) {
            $code = rand(999999, 111111);
            $updateQuery = "UPDATE tbl_user SET code = $code WHERE useremail = '$email'";
            $updateResult = mysqli_query($conn, $updateQuery);
            if ($updateResult) {
                $subject = 'Email Verification Code';
                $message = "your verification code is $code";
                $sender = 'From: singsingaman26@gmail.com';

                if (mail($email, $subject, $message, $sender)) {
                    $message = "We've sent a verification code to your Email <br> $email";

                    $_SESSION['message'] = $message;
                    header('location: verifyotp.php');
                } else {
                    $errors['otp_errors'] = 'Failed while sending code!';
                }
            } else {
                $errors['db_errors'] = "Failed while inserting data into database!";
            }
        }else{
             $errors['invalidEmail'] = "error";
        }
    }else {
        $errors['db_error'] = "Failed while checking email from database!";
    }
  } else {
      $success['db_success'] = "code sended!";
  }







?>

<!DOCTYPE html>
<html>
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
  <div class="login-box-body" style="height: 275px;">
   

    <form action="forgot-password.php" method="POST" autocomplete="">
                    <h2 class="text-center">Email Verify</h2>
                    <p class="text-center" style="margin: 0px 0px 22px 0px;">It's quick and easy.</p>
                    <?php
                        if(count($errors) > 0){
                           
                                    foreach($errors as $error){
                                        ?>
                                     <div class="hidden" aria-hidden="true"><?php echo $error; ?></div>
                                    <?php
                                    }
                              
                        }
                    ?>
                   
                   <div class="form-group has-feedback">
        <input type="email" class="form-control" name="txt_email" placeholder="Email"  required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
                    
                   
                   
                    <div class="form-group">
                        <input class="form-control btn btn-primary btn-block btn-flat" type="submit" name="btnsubmit" value="Submit">
                    </div>
                    
                    <div class="link login-link text-center" ><b>New member? <a href="signup-user.php">Signup here</a><b></div>
                </form>

   

      
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?php


if(!empty($error)){
echo'<script type="text/javascript">
jQuery(function validation(){
swal({
  title: "Email is Invalid!",
  text: "Not Found!",
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