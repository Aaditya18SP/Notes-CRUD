<?php

include "dbconnect.php";

//check whether the user is logged in or not ,if yes then allow to update

session_start();
$loggedin=0;
$loggedin_as_admin=0;
 if(isset($_SESSION['loggedin']) or $_SESSION['loggedin']==true){
  $loggedin=1;
  if(strtolower($_SESSION['username'])=='admin'){
    $loggedin_as_admin=1;
  }
  
}
 else{
 
         echo '<META HTTP-EQUIV="Refresh" Content=0;URL="index.php">';
         exit;
 }
       
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php 
    $note_id=$_GET['note_id'];
       $sql1="select title from noteinfo where note_id=$note_id";
       $result1=mysqli_query($conn,$sql1);
       if(mysqli_num_rows($result1)>0){
        while($row=mysqli_fetch_assoc($result1)){
            echo $row['title'];
        }
       } 
        ?>
        </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">NOTES APP</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="notes.php?pageno=1">Home</a>
              </li>
             
              <li class="nav-item">
                <a class="nav-link" href="notes.php?pageno=1">About</a>
              </li>
              <?php 
              if($loggedin){
              echo '
              <li class="nav-item">
                <a class="nav-link" href="logout.php"><strong>LOGOUT</strong></a>
              </li>
              ';
              
              if($loggedin_as_admin){
                //if user is admin then show controls, 
                //strtolower is used to check with admin as capital and small are different while entering in form but capital and small are same in database
              echo '
              <li class="nav-item">
                <a class="nav-link" href="admin_allnotes.php?adminnotespageno=1"><strong>ALL NOTES</strong></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="admin_allusers.php?adminuserspageno=1"><strong>ALL USERS</strong></a>
              </li>
              ';
              }
            }
              
              ?>

              
            </ul>
            
          </div>
        </div>
      </nav>
    
      <div class="container my-5">
      <div class="container my-3 text-center">
        <h1>
            YOUR NOTE
        </h1>
        </div>
        <?php 
       
        $note_id=$_GET['note_id'];
        
        
        //$adminuserspageno=$_GET['adminuserspageno'];


        $sql="select * from noteinfo where note_id=$note_id";
        $result=mysqli_query($conn,$sql);
                  
            if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
              if(isset($_GET['adminnotespageno'])){
                $adminnotespageno=$_GET['adminnotespageno'];
                echo'
                <div class="mb-3" style="border-style:solid;border-radius:20px;border-color:grey; padding:1vw">
                <p><h3>'. $row["title"].'</h3></p>
                <p>'. $row["description"].'</p>
                </div>  
                <div class="mb-3 my-5 ">      
                <a style=" color:white;text-decoration:none" href="admin_allnotes.php?adminnotespageno='.$adminnotespageno.'#allnotes" >
                <button type="button" class="btn btn-primary">Go Back</button>
                </a>
                <a style=" color:white;text-decoration:none" href="update.php?note_id='.$note_id.'&adminnotespageno='.$adminnotespageno.'">
                <button type="button" class="btn btn-primary">Update</button>
                </a>
                <a style=" color:white;text-decoration:none" href="delete.php?note_id='.$note_id.'&adminnotespageno='.$adminnotespageno.'">
                <button type="button" class="btn btn-primary">Delete</button>
                </a>
                  <div>
                ';

              }
              /*elseif(isset($_GET['adminuserspageno'])){
                 echo'
                    <div class="mb-3" style="border-style:solid;border-radius:20px;border-color:grey; padding:1vw">
                    <p><h3>'. $row["title"].'</h3></p>
                    <p>'. $row["description"].'</p>
                    </div>  
                    <div class="mb-3 my-5 ">      
                    <a style=" color:white;text-decoration:none" href="notes.php?pageno='.$pageno.'#allnotes" >
                    <button type="button" class="btn btn-primary">Go Back</button>
                    </a>
                    <a style=" color:white;text-decoration:none" href="update.php?note_id='.$note_id.'&pageno='.$pageno.'">
                    <button type="button" class="btn btn-primary">Update</button>
                    </a>
                    <a style=" color:white;text-decoration:none" href="delete.php?note_id='.$note_id.'&pageno='.$pageno.'">
                    <button type="button" class="btn btn-primary">Delete</button>
                    </a>
                      <div>
                    ';
                    continue;
              }*/
              else{
                $pageno=$_GET['pageno'];
                  echo'
                    <div class="mb-3" style="border-style:solid;border-radius:20px;border-color:grey; padding:1vw">
                    <p><h3>'. $row["title"].'</h3></p>
                    <p>'. $row["description"].'</p>
                    </div>  
                    <div class="mb-3 my-5 ">      
                    <a style=" color:white;text-decoration:none" href="notes.php?pageno='.$pageno.'#allnotes" >
                    <button type="button" class="btn btn-primary">Go Back</button>
                    </a>
                    <a style=" color:white;text-decoration:none" href="update.php?note_id='.$note_id.'&pageno='.$pageno.'">
                    <button type="button" class="btn btn-primary">Update</button>
                    </a>
                    <a style=" color:white;text-decoration:none" href="delete.php?note_id='.$note_id.'&pageno='.$pageno.'">
                    <button type="button" class="btn btn-primary">Delete</button>
                    </a>
                      <div>
                    ';
                 }
      

            }
        }
        

        ?>
        </div>





      
      


      


   
      

      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>