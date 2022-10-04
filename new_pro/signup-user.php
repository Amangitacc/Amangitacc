<?php 
session_start();
include_once "connectdb.php";



$useremail = "";
$name = "";
$userrole= "";

$con = mysqli_connect("localhost", "root", "", "student");
$errors = array();
$showesuccess= '';


//if user signup button
if(isset($_POST['signup'])){
    $name =  $_POST['name'];
    $fathername =  $_POST['txtf_name'];
    $useremail = $_POST['txtemail'];
    $password = sha1($_POST['txt_password']);
    $cpassword = sha1($_POST['txt_cpassword']);
    if($password !== $cpassword){
        $errors['txt_password'] = "Confirm password not matched!";
    }
    $email_check = "SELECT * FROM registrations WHERE email = '$useremail'";
    $res = mysqli_query($con, $email_check);
    if(mysqli_num_rows($res) > 0){
        $errors['email'] = "Email that you have entered is already exist!";
    }
    if(count($errors) === 0){
        $password = sha1($_POST['txt_password']);
        $code = rand(999999, 111111);
        $status = "notverified";
        $insert_data = "INSERT INTO registrations (name, f_name, email, password, code, status)
                        values('$name', '$fathername', '$useremail', '$password', '$code', '$status')";       
       

        $data_check = mysqli_query($con, $insert_data);
        $showesuccess= 'Registration successfull';
        header('refresh:1; index.php');

        if($data_check){
            $subject = "Email Verification Code";
            $message = "Your verification code is $code";
            $sender = "From: singsingaman26@gmail.com";
            if(mail($useremail, $subject, $message, $sender)){
                $info = "We've sent a verification code to your useremail - $useremail";
                $_SESSION['info'] = $info;
                $_SESSION['useremail'] = $useremail;
                $_SESSION['password'] = $password;
                $_SESSION['role'] = $userrole;
               
               
               
                exit();
            }else{
                $errors['otp-error'] = "Failed while sending code!";
            }
        }else{
            $errors['db-error'] = "Failed while inserting data into database!";
        }
    }
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS | Sign up</title>
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
  <div class="login-box-body" style="height: 467px;">
   

    <form action="signup-user.php" method="POST" autocomplete="">
                    <h2 class="text-center">Signup Form</h2>
                    <p class="text-center" style="height: 28px; padding: 0px 0px 20px 0px;">It's quick and easy.</p>
                    <?php
                    if(count($errors) == 1){
                        ?>
                        <div class="hidden" >
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }elseif(count($errors) > 1){
                        ?>
                        <div class="hidden" >
                            <?php
                            foreach($errors as $howerror){
                                ?>
                                <li><?php echo $howerror; ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }?>

                    <div class="form-group has-feedback">
                        <input class="form-control" type="text" name="name" placeholder="Full Name" required value="<?php echo $name ?>">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                   <input type="text" class="form-control" placeholder="father name" name="txtf_name" required>
                   <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                   </div>

                   <div class="form-group has-feedback">
                   <input type="email" class="form-control" placeholder="email" name="txtemail" required>
                   <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                   </div>

                   
                    <div class="form-group has-feedback">
                        <input class="form-control" type="password" name="txt_password" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input class="form-control" type="password" name="txt_cpassword" placeholder="Confirm password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    
                    <div class="form-group">
                        <input class="form-control button btn btn-primary btn-block btn-flat"  type="submit" name="signup" value="Signup">
                    </div>
                    <div class="link login-link text-center" ><b>Already a member? <a href="index.php">Login here</a><b></div>
                </form>

   

      
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->



<?php 

if($errors['txt_password']){

echo'<script type="text/javascript">
jQuery(function validation(){
swal({
  title: "Sorry!'.$_SESSION[''].'",
  text: "Confirm Password Unmatched",
  icon: "error",
  button: "Ok",
  });
 });
</script>';
}




if($errors['email']){
echo'<script type="text/javascript">
jQuery(function validation(){
swal({
  title: "Sorry!'.$_SESSION[''].'",
  text: "Email Alredy Exist!",
  icon: "error",
  button: "Ok",
  });
 });
</script>';
}



if($showesuccess){
    echo'<script type="text/javascript">
    jQuery(function validation(){
    swal({
      title: "Good Job!'.$_SESSION[''].'",
      text: "Registration Successfull",
      icon: "success",
      button: "Loading...",
      });
     });
    </script>';
    }

?>





<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</div>
</div>
</body>
</html>