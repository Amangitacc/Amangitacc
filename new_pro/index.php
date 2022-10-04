<?php
include_once 'connectdb.php';
session_start();
error_reporting(0);        // this type of predefined function use to avoid some notices like warning type //


if(isset($_POST['btn_login'])){
$useremail = $_POST['txt_email'];         // here we getting data from user in form platform in the way of associative array as Key which contain value
$password = sha1($_POST['txt_password']);                              // and storing in a variable 
//echo $useremail." - ".$password;
$select= $pdo->prepare("select * from registrations where email='$useremail' AND  password='$password'");  
$select->execute();
$row= $select->fetch(PDO::FETCH_ASSOC);
if($row['email']==$useremail AND $row['password']==$password){
$_SESSION['id']=$row['userid'];               
$_SESSION['name']=$row['name'];                   // here use of $_SESSION which super global variable which store the user credentials 
$_SESSION['email']=$row['email'];                                               // as a security purpose without log in user or admin can't granted
$_SESSION['password'] = $row['password'];


// echo'<script type="text/javascript">
// jQuery(function validation(){
// swal({
//   title: "Good job!'.$_SESSION['username'].'",
//   text: "Details Matched",
//   icon: "success",
//   button: "Loading.....",
//   timer: 2000
//  });
//  });
// </script>';
 
$message = 'success';
header('refresh:2;dashboard.php');     
    
}else{
$errormsg= 'error';    
    

} 
}
?>

<!DOCTYPE html>
<html>
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

<link rel="stylesheet" href="assets/font-awesome.min.css">
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="assets/sweetalert.js"></script>
  
  
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/font-awesome.min.css">


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
  <div class="login-box-body">
    <p class="login-box-msg"><b>Sign in to start your session<b></p>
</br>
    <form action="" method="post">     
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="txt_email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
    <input type="password" class="form-control" placeholder="Password" name="txt_password"  required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
<a href="forgot-password.php" >I forgot my password</a><br>
        </div>
        <div class="col-xs-4">
     <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn_login"><b>Login<b></button>
        </div>
        </div>
        <div class="link login-link text-center" ><b>Not yet a member?&nbsp;</b><a href="signup-user.php">Signup now</a></div>
    
        <!-- /.col -->
       
        <!-- /.col -->
      </div>
      
     

      <?php




      
      if(!empty($message)){                         // here in this case when we inserting data means it is not empty condition true for matched variable
                                                      // that will run the part of if or elseif
echo'<script type="text/javascript">
jQuery(function validation(){
swal({
  title: "Good job!'.$_SESSION['name'].'",
  text: "Details Matched!",
  icon: "success",
  button: "Loading.....",
  });
 });
</script>';
         
}
      
      
      if($errormsg){                   // here in this variable we have written on else sec. this will true when the matching of all above fields in
                                            // if sec not the else part having variable will execute and here we have to show sweet alert 
                                              // therefore we use like this
      
          
          
           echo'<script type="text/javascript">
jQuery(function validation(){


swal({
  title: "EMAIL OR PASSWORD IS WRONG!",
  text: "Details Not Matched",
  icon: "error",
  button: "Ok",
});


});

</script>'; 
          
      } 
      
     
      
      ?>
      
      
      
      
    </form>

   

      
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->





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





