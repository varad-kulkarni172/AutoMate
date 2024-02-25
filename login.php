<?php
$login=0;
$Invalid=0;


if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $email=$_POST['email'];
    $password=$_POST['password'];
   
      
      $sql="Select * from registration where email='$email'";
    
      $result=mysqli_query($con,$sql);
      if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
          while($row=mysqli_fetch_assoc($result)){
            if(password_verify($password,$row['password'])){
            $login=1;
            session_start();
            $_SESSION['email']=$email;
            header('Location:http://127.0.0.1:5000/');
        }
        else{
          $Invalid=1;
      }
      }
    }
        else{
            $Invalid=1;
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
  if($login){
     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
     <strong></strong>You are Successfully Logged-in
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
  }
 ?>
  <?php
  if($Invalid){
     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
     <strong></strong> Invalid Credentials
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>';
  }
 ?>


<!-- partial:index.partial.html -->
<div id="login-form-wrap">
  <h2>Login</h2>
  <form action="login.php" method="post" id="login-form">
   
    <p>
    <input type="email" id="email" name="email" placeholder="Email Address" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
      <input type="password" id="password" name="password" placeholder="Password" required><i class="validation"><span></span><span></span></i>
      </p>
    <p>
    <input type="submit" id="login" value="Login">
    </p>

    <div><a href="" class="float-end">Forgot your Password</a></div>
  </form>

  <div id="create-account-wrap">
    <p>Not a member? <a href="sign.php">Create Account</a><p>
  </div><!--create-account-wrap-->
</div><!--login-form-wrap-->
<!-- partial -->
  
</body>
</html>
