<?php

include "dbconnect.php";

//check whether the user is logged in or not ,if yes then allow to update
/*if( empty(session_id()) && !headers_sent()){
    session_start();
}
*/
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
    <title>Edit your note</title>
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
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
             
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
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
      <div class="container">
        <?php
        //updating form data into db
        //connection already created
        if(isset($_POST['update'])){
          $note_id=$_GET['note_id'];
          $title=$_POST['notetitle'];
          $description=$_POST['notedesc'];
          //$author=$_POST['noteauthor'];
          //$date_created=date("y-m-d");

          //to assign the initial note_id when no note_id is present and then it auto increments
          $sql="update noteinfo set title='$title',description='$description' where note_id=$note_id";
          $result=mysqli_query($conn,$sql);
          
        if($result){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>SUCCESS!</strong> Your note was updated successfully.Redirecting....
          <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
              if(isset($_GET['adminnotespageno'])){
                $adminnotespageno=$_GET['adminnotespageno'];
                echo '<META HTTP-EQUIV="Refresh" Content=2;URL="admin_allnotes.php?adminnotespageno='.$adminnotespageno.'#allnotes">';
          }
        /*     elseif(isset($_GET['adminuserspageno'])){
                  $adminuserspageno=$_GET['adminuserspageno'];
                  echo '<META HTTP-EQUIV="Refresh" Content=2;URL="admin_allusers.php?adminuserspageno='.$adminuserspageno.'#allnotes">';
        }*/
          else{
            $pageno=$_GET['pageno'];
            echo '<META HTTP-EQUIV="Refresh" Content=2;URL="notes.php?pageno='.$pageno.'#allnotes">';
          }
        
      }
      else{
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>OOPS!</strong> Your note was not updated  T_T.
          <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
      }
           
          
          
        
        
        }
        ?>
    </div>

      <div class="container my-5">
        <h1>
            EDIT NOTE
        </h1>
        <?php 
        $note_id=$_GET['note_id'];
        if(isset($_GET['adminnotespageno'])){
          $adminnotespageno=$_GET['adminnotespageno'];
        echo'
        <form method="post" action="update.php?note_id='.$note_id.'&adminnotespageno='.$adminnotespageno.'">
            <div class="mb-3">';
          
        }
        /*elseif(isset($_GET['adminuserspageno'])){
           $adminnotespageno=$_GET['adminuserspageno'];
        echo'
        <form method="post" action="update.php?note_id='.$note_id.'&adminnotespageno='.$adminuserspageno.'">
            <div class="mb-3">';

        }*/
        else{
          $pageno=$_GET['pageno'];
        echo'
        <form method="post" action="update.php?note_id='.$note_id.'&pageno='.$pageno.'">
            <div class="mb-3">';

        }
        
            
                  $note_id=$_GET['note_id'];
                  $sql="select * from noteinfo where note_id=$note_id";
                  $result=mysqli_query($conn,$sql);
                  if($result){
                     if(mysqli_num_rows($result)>0){
                        while($row=mysqli_fetch_assoc($result)){


               ?>
              <label for="noteauthor" class="form-label">Note Author</label>
              <input type="text" value="<?php echo $row['author'];  ?>"
              class="form-control" id="noteauthor" aria-describedby="emailHelp" name="noteauthor" required disabled>  
            </div>      
            <div class="mb-3">
              <label for="notetitle" class="form-label">Note Title</label>
              <input type="text" value="<?php echo $row['title'];  ?>" class="form-control" id="notetitle" aria-describedby="emailHelp" name="notetitle" required maxlength="30">
              
            </div>
            <div class="mb-3">
                <label for="notedesc" class="form-label">Your Note</label>
                <textarea  class="form-control" id="notedesc" rows="3" name="notedesc" required maxlength="300"><?php echo $row['description'];  ?></textarea>
              </div>
              
            <button type="submit" class="btn btn-primary" name="update">Update</button>
          </form>
      </div>  
      <?php
      

                }
            }
        }

        ?>





      
      


      


   
      

      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>