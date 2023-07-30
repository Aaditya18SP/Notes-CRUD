<?php

/*if( empty(session_id()) && !headers_sent()){
    session_start();
}*/
session_start();
if(isset($_SESSION['loggedin'])){
session_unset();
session_destroy();
echo '<META HTTP-EQUIV="Refresh" Content=0;URL="index.php">';
}
else {
    echo '<META HTTP-EQUIV="Refresh" Content=0;URL="index.php">';
}



?>