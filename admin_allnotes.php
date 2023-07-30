<?php
require "dbconnect.php";
session_start();
if(isset($_SESSION['loggedin']) && strtolower($_SESSION['username'])=='admin'){
    $loggedin_as_admin=1;
}
elseif(isset($_SESSION['loggedin']) && !(strtolower($_SESSION['username'])=='admin')){
 echo '<meta http-equiv="Refresh" content=0; url="notes.php">';
}
else{
    echo '<meta http-equiv="Refresh" content=0; url="index.php">';
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ALL NOTES </title>
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
              if($loggedin_as_admin){
              echo '
              <li class="nav-item">
                <a class="nav-link" href="logout.php"><strong>LOGOUT</strong></a>
              </li>
              ';
             
              if($loggedin_as_admin && strtolower($_SESSION['username'])=='admin'){
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


<!------------- TABLE OF ALL NOTES-------->

      <div class="container my-5">
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
    //$username=$_SESSION['username'];
    //pagination logic
    $sql4="select * from noteinfo ";
    $result4=mysqli_query($conn,$sql4);
    $total_records=mysqli_num_rows($result4);
    $limit=10;
    $total_pages=ceil($total_records/$limit);
    $pageno=$_GET['adminnotespageno'];
    $offset=($pageno-1)* $limit;
      $sql3="select * from noteinfo where author in (select author from noteinfo group by author) order by date_created limit $offset,$limit";
    $result3=mysqli_query($conn,$sql3);
    
    
  if(mysqli_num_rows($result3)>0)
        {
            $_SESSION['serialadmin']=$offset+1;

           while($row=mysqli_fetch_assoc($result3))
           {
            
    ?>
           
    <tr>
      <th scope="row"><?php echo $_SESSION['serialadmin'];   ?></th>
      <td><?php echo $row['title'];   ?></td>
      <td><?php echo $row['description'];   ?></td>
      <td><?php echo $row['author'];   ?></td>
      <td><?php echo $row['date_created'];   ?></td>
      <td><?php 
      $pageno=$_GET['adminnotespageno'];
      echo '<a style=" color:white;text-decoration:none" href="viewnote.php?note_id='.$row["note_id"].'&adminnotespageno='.$pageno.'">'; 
      ?>
        <button type="button" class="btn btn-primary">View</button>
           </a>
      </td>
      <td>
      <?php 
      $pageno=$_GET['adminnotespageno'];
      echo '<a style=" color:white;text-decoration:none" href="update.php?note_id='.$row["note_id"].'&adminnotespageno='.$pageno.'">'; 
      ?>
      <button type="button" class="btn btn-primary">Edit</button>
      </a>
      </td>
      <td>
      <?php 
      $pageno=$_GET['adminnotespageno'];
      echo '<a style=" color:white;text-decoration:none" href="delete.php?note_id='.$row["note_id"].'&adminnotespageno='.$pageno.'">'; 
      ?> ><button type="button" class="btn btn-primary">Remove</button>
      </a>
      </td>
    </tr>
<?php
   $_SESSION['serialadmin']++;
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
  $pageno=$_GET['adminnotespageno'];
  //if page=1,then dont show previous
  if($pageno<>1){
    echo '<li class="page-item ">
      <a class="page-link" href="admin_allnotes.php?adminnotespageno='.($pageno-1).'#allnotes">Previous</a>
    </li>';
  }
    
//pagination continued
    $j=1;
    $pageno=$_GET['adminnotespageno'];
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
    
    
    $pageno=$_GET['adminnotespageno'];
  //if last page,then dont show next
  
  if($pageno!=$total_pages && $pageno<$total_pages){
    echo '<li class="page-item">
      <a class="page-link" href="admin_allnotes.php?adminnotespageno='.($pageno+1).'#allnotes">Next</a>
    </li>';
  }
  ?>
  </ul>
</nav>
      </div>





      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        </body>
        </html>
        