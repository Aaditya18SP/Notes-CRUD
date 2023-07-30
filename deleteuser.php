<?php
require 'dbconnect.php';
session_start();
$loggedin_as_admin=0;
$loggedin=0;
if(isset($_SESSION['loggedin'])){
if( strtolower($_SESSION['username'])=='admin'){
    $loggedin_as_admin=1;
}
else{
    echo '<meta http-equiv="Refresh" content=0;url="notes.php?pageno=1>';
}
}
else{
    echo '<meta http-equiv="Refresh" content=0;url="index.php>';
}

if($loggedin_as_admin){
    $username=$_GET['username'];
    
    $adminuserspageno=$_GET['adminuserspageno'];
    if(strtolower($username)=='admin'){
       echo '<meta http-equiv="Refresh" content=0;url="admin_allusers.php?adminuserspageno='.$adminuserspageno.'#allusers">'; 
    }
    else{
        
    
    $sql="delete from logindetails where username='$username'";
    $result=mysqli_query($conn,$sql);
    if($result){
        echo '<meta http-equiv="Refresh" content=0;url="admin_allusers.php?adminuserspageno='.$adminuserspageno.'#allusers">';
    }
    else{
        echo mysqli_error($conn);
    }
    }
}



?>