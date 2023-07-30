<?php
include "dbconnect.php";

/*if( empty(session_id()) && !headers_sent()){
    session_start();
}
*/
session_start();
//to check whether user is already logged in or not.if logged in then dont sign up

if(!isset($_SESSION['loggedin'])){
  
  }
  else{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Log out first to create another user </strong>You are being redirected
            <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    echo '<META HTTP-EQUIV="Refresh" Content=1;URL="notes.php?pageno=1">';
  exit;
    
  }
  ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGN UP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">NOTES</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">LOGIN</a>
              </li>
            
              
          </div>
        </div>
      </nav>



    <div class="container">
      <?php
      if(isset($_POST['signup'])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
      
        $sql="select username from logindetails where username='$username'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>OOPS!</strong>The username <strong> '.$username .'</strong> is alredy taken.Enter something unique just like you
            <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        else{
            if($password==$cpassword){
                $hash_password=password_hash($password,PASSWORD_DEFAULT);
                $sql1="insert into logindetails values('$username','$hash_password')";
                $result1=mysqli_query($conn,$sql1);
                if($result1){
                  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>HELLO HELLO HELLO !!!</strong> Welcome aboard,Your signup was successful.Redirecting...
                  <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                    echo '<META HTTP-EQUIV="Refresh" Content=2;URL="index.php">';
                }
                else {
                    echo "OPPS! Couldnt sign you due to some techincal errors";
                }
            }
            else{
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>OOPS!</strong> The passwords dont match.
              <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
            
        }
      
      
      
      }
      
      


?>
    </div>
    <div class="container my-5">
        <h1 class="text-center">SIGN UP</h1>
    </div>

<div class="container my-5">

<form method="POST" action="signup.php">
  <div class="mb-3 col-md-6">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" aria-describedby="emailHelp" name="username" required maxlength="20">
    
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required maxlength="15">
  </div>

  <div class="mb-3">
    <label for="cpassword" class="form-label"> Confirm Password</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword" required maxlength="15">
    <small>enter the same password</small>
  </div>
  
    
  </div>
  <button type="submit" class="btn btn-primary" name="signup" >Sign Up</button>
</form>
</div>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> 
</body>
</html>