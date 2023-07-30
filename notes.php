<?php

include "dbconnect.php";
/*if( empty(session_id()) && !headers_sent()){
    session_start();
}
*/
session_start();

$loggedin_as_admin=0;
$loggedin=0;
 if(isset($_SESSION['loggedin'])){
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
    <title><?php echo $_SESSION['username'] ."'s"; ?> NOTES </title>
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
                <a class="nav-link active" aria-current="page" href="notes.php?pageno=1">Home</a>
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
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
      <div class="container">
        <?php
        if($loggedin_as_admin){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
           <strong>WELCOME WELCOME '. $_SESSION["username"] .' !</strong>TAKE CONTROL and lets get some work done !!!!  
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';
        }
        else{
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>WELCOME '. $_SESSION["username"] .' !</strong> Have a great time writing  
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
         ?>
      </div>

      <div class="container">
        <?php
         //session_start();
         $username=$_SESSION['username'];
         //inserting form data into db
         //connection already created
         if(isset($_POST['submit'])){
 
           //to assign the initial note_id when no note_id is present and then it auto increments
           $sql="select * from noteinfo";
           $result=mysqli_query($conn,$sql);
           
           if(mysqli_num_rows($result)==0){
           $note_id=101;
           $title=$_POST['notetitle'];
           $description=$_POST['notedesc'];
           $author=$username;
           $date_created=date("y-m-d");
           $sql1="insert into noteinfo values($note_id,'$title','$description','$author','$date_created')";
         $result1=mysqli_query($conn,$sql1);
         }
         else{
           $title=$_POST['notetitle'];
           $description=$_POST['notedesc'];
           $author=$username;
           $date_created=date("y-m-d");
           //variables to store form data
 
 
         $sql1="insert into noteinfo(title,description,author,date_created) values('$title','$description','$author','$date_created')";
         $result1=mysqli_query($conn,$sql1);
         //echo mysqli_error($conn);
         }
         if($result1){
           echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
           <strong>SUCCESS WOOHOO!</strong> You entered a note successfully.
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';
         }
         else{
           echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
           <strong>OOPS!</strong> Couldnt enter your note T_T.
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';
         }
 
 
        
       }


?>
      </div>

      <div class="container my-5">
        <h1>
            ADD A NOTE
        </h1>
        <?php 
        $pageno=$_GET['pageno'];
        echo '<form method="post" action="notes.php?pageno='.$pageno.'">';
        ?>
            <div class="mb-3">
              <label for="noteauthor" class="form-label">Note Author</label>
              <input type="text" class="form-control" id="noteauthor" aria-describedby="emailHelp" name="noteauthor" value ="<?php $username=$_SESSION['username'];echo $username;?>"  disabled>  
            </div>      
            <div class="mb-3">
              <label for="notetitle" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="notetitle" aria-describedby="emailHelp" name="notetitle" required maxlength="30">
              
            </div>
            <div class="mb-3">
                <label for="notedesc" class="form-label">Your Note</label>
                <textarea class="form-control" id="notedesc" rows="3" name="notedesc" required maxlength="3000"></textarea>
              </div>
              
            <button type="submit" class="btn btn-primary" name="submit">Add Note</button>
          </form>
      </div>

  <!--  --------------------------------------------------THE TABLE OF NOTES------------------------------------------------------  -->
      <div class="container">
      
      <h1> ALL NOTES</h1>
      </div>


      <div class="container" id="allnotes">
      <table class="table">
  <thead>
    <tr>
      <th scope="col">S no.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Author</th>
      <th scope="col">Created on</th>
      <th scope="col">View</th>
      <th scope="col">Update</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php
    //session_start();
    $username=$_SESSION['username'];
    //pagination logic
    $sql4="select * from noteinfo where author='$username'";
    $result4=mysqli_query($conn,$sql4);
    $total_records=mysqli_num_rows($result4);
    $limit=3;
    $total_pages=ceil($total_records/$limit);
    $pageno=$_GET['pageno'];
    $offset=($pageno-1)* $limit;
      $sql3="select * from noteinfo where author='$username' limit $offset,$limit";
    $result3=mysqli_query($conn,$sql3);
    
    
  if(mysqli_num_rows($result3)>0)
        {
          $_SESSION['i']=$offset+1;
          
           while($row=mysqli_fetch_assoc($result3))
           {
            
    ?>
           
    <tr>
      <th scope="row"><?php echo $_SESSION['i'];   ?></th>
      <td><?php echo $row['title'];   ?></td>
      <td><?php echo $row['description'];   ?></td>
      <td><?php echo $row['author'];   ?></td>
      <td><?php echo $row['date_created'];   ?></td>
      <td><?php 
      $pageno=$_GET['pageno'];
      echo '<a style=" color:white;text-decoration:none" href="viewnote.php?note_id='.$row["note_id"].'&pageno='.$pageno.'">'; 
      ?>
        <button type="button" class="btn btn-primary">View</button>
           </a>
      </td>
      <td>
      <?php 
      $pageno=$_GET['pageno'];
      echo '<a style=" color:white;text-decoration:none" href="update.php?note_id='.$row["note_id"].'&pageno='.$pageno.'">'; 
      ?>
      <button type="button" class="btn btn-primary">Edit</button>
      </a>
      </td>
      <td>
      <?php 
      $pageno=$_GET['pageno'];
      echo '<a style=" color:white;text-decoration:none" href="delete.php?note_id='.$row["note_id"].'&pageno='.$pageno.'">'; 
      ?> ><button type="button" class="btn btn-primary">Remove</button>
      </a>
      </td>
    </tr>
<?php
   $_SESSION['i']++;
          }
        }
      
    ?>
  </tbody>
</table>
      </div>

      


      
      <!--PAGINATION-->

      <div class="container">
        <h6>click on previous and next to see all your notes.</h6>
      <nav aria-label="...">
  <ul class="pagination">
  <?php
  $pageno=$_GET['pageno'];
  //if page=1,then dont show previous
  if($pageno<>1){
    echo '<li class="page-item ">
      <a class="page-link" href="notes.php?pageno='.($pageno-1).'#allnotes">Previous</a>
    </li>';
  }
    ?>

    <?php
    //pagination continued
    $j=1;
    $pageno=$_GET['pageno'];
    while($j<=$total_pages){
      if($j==$pageno){
     echo '
    <li class="page-item active"><a class="page-link" href="#">'.$j.'</a></li>';
      }
     
      else{
       echo '<li class="page-item"><a class="page-link">'.$j.'</a></li>';
        
      }
      $j++;
    }
    ?>
    <?php
    $pageno=$_GET['pageno'];
  //if last page,then dont show next
  
  if($pageno!=$total_pages && $pageno<$total_pages){
    echo '<li class="page-item">
      <a class="page-link" href="notes.php?pageno='.($pageno+1).'#allnotes">Next</a>
    </li>';
  }
  ?>
  </ul>
</nav>
      </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>