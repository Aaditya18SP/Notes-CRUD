<?php
include "dbconnect.php";


//check whether the user is logged in
/*if( empty(session_id()) && !headers_sent()){
    session_start();
}
*/
session_start();

 if(isset($_SESSION['loggedin'])){
  
}
 else{
  
  echo '<META HTTP-EQUIV="Refresh" Content=0;URL="index.php">';
  exit;
 }
       
//delete operation

$note_id=$_GET['note_id'];
$sql="delete from noteinfo where note_id=$note_id";
$result=mysqli_query($conn,$sql);
if($result){
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
echo '<META HTTP-EQUIV="Refresh" Content=1;URL="notes.php?pageno='.$pageno.'#allnotes">'; 
}
}
else{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>OOPS!</strong> Could not delete your note :(.
    <button type="button" class="btn-close" id="crossbtn" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}


?>