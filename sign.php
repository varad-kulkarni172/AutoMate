
<?php
$success=0;
$user=0;
$invalid=0 ;

if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $email=$_POST['email'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
   
      $sql="Select * from registration where
      email='$email'";
      $result=mysqli_query($con,$sql);
      if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $user=1;
        }else{
          if($password===$cpassword){
            $hash=password_hash($password,PASSWORD_DEFAULT);
            $sql="insert into registration(email,password)
            values('$email','$hash')";
            $result=mysqli_query($con,$sql);
            if($result){
                    $success=1;
                    // header('location:login.php');
                 }
                }else{
                     $invalid=1;
                 }
        
      }
      }
}

?>



<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>HTML5 Login Form with validation Example</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="./style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

</head>
<body>

  <?php
  if($user){
     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
     <strong></strong>User Already exists
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
  }
 ?>
 <?php
  if($invalid){
     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
     <strong></strong>Password Doesnt Match
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
  }
 ?>

  <?php
  if($success){
     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
     <strong></strong>You are Successfully signed-up
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
  }
 ?>


<!-- partial:index.partial.html -->
<div id="login-form-wrap">
  <h2>Sign up</h2>
  <form action="sign.php" method="post" id="login-form">
   
    <p>
    <input type="email" id="email" name="email" placeholder="Email Address" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
        <input type="password" id="password" name="password" placeholder="Password" required><i class="validation"><span></span><span></span></i>
        </p>
        <p>
            <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required><i class="validation"><span></span><span></span></i>
            </p>
    <p>
    <input type="submit" id="login" value="Signup">
    </p>
  </form>
  <div id="create-account-wrap">
    <p>Already a member? <a href="login.php">Login</a><p>
  </div><!--create-account-wrap-->
</div><!--login-form-wrap-->
<!-- partial -->
  
</body>
</html>
