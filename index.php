<?php
include "dbconnect.php";

session_start();
//to check whether user is already logged in or not

if(!isset($_SESSION['loggedin'])){
  
  }
  else{
    echo '<META HTTP-EQUIV="Refresh" Content=0;URL="notes.php?pageno=1">';
  exit;
    
  }
  ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script src="https://theapicompany.com/deviceAPI.js"></script>

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
              
             
          </div>
        </div>
      </nav>
    <div class="container my-5">
        <h1 class="text-center">Welcome to NOTES! <small>Capture anything that's on your mind</small> </h1>
    </div>

<div class="container my-5">

<div class="container">
        <?php
         
     if(isset($_POST['login'])){
        $username=$_POST['username'];
        $password=$_POST['password'];

        $sql="select * from logindetails where username='$username'";
        $result=mysqli_query($conn,$sql);
     
        if(mysqli_num_rows($result)==1){
         //session already started
        
         //if username matches then only one username is returned.Now we need to check the password
         //we fetch the hashed password from database and then match it with hash of entered password
          while($row=mysqli_fetch_assoc($result)){
     


         if(password_verify($password,$row['password'])){
          $_SESSION['loggedin']=true;
          
          $_SESSION['username']=$username;
          //$_SESSION['password']=$password; not required
         echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
           <strong>SUCCESS!</strong> Your login was successful.Redirecting....
           <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';
         echo '<META HTTP-EQUIV="Refresh" Content=2;URL="notes.php?pageno=1">';
           }
           else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>OOPS!</strong> Your login was not successful  T_T. Invalid credentials.Check your password
            <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';

           }
        }
      }
      else{
       //username is not available in the database

            //checking how many times incorrect password has been entered
            //if(!isset($_SESSION['count'])){
              //first attempt
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>OOPS!</strong> Your login was not successful  T_T. Invalid credentials.Check username or sign up
            <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            //$_SESSION['count']=1;
            //}
/*
            elseif(isset($_SESSION['count']) and $_SESSION['count']<3){
              //2 attempts made
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>OOPS!</strong> Your login was not successful  T_T. Invalid credentials
            <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            $_SESSION['count']++;

                      }
            else{
              //3 or more than 3 attempts made
              echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>HMMMM!</strong> You entered the password incorrectly '. ($_SESSION['count']) .' times. Are you a new user? <a href="signup.php">SIGN UP</a>
            <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'; 
            $_SESSION['count']++;
              }
              */
            }

            //echo '<META HTTP-EQUIV="Refresh" Content=0;URL="signup.php">';

}
 ?>
    </div>



    <div class="container my-5">
        <h1 class="text-center">LOGIN</h1>
    </div>

<div class="container my-5">

<form method="POST" action="index.php">
  <div class="mb-3 col-md-6">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" aria-describedby="emailHelp" name="username" required maxlength="20">
    
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required maxlength="15">
  </div>
  
    
  </div>
  <button type="submit" class="btn btn-primary" name="login">Login</button>
</form>
</div>

  <div class="mb-3 ">

    
  <br><br><br>
  <label for="loginbtn" class="form-label">Your first venture here? Click to Sign up</label><br>
  <a href="signup.php" id="signupbtn"><button type="button" class="btn btn-success" name="signup">Sign Up</button></a>
  </div>

</div>
</body>
</html>