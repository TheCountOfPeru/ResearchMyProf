<!--Logout page is having information about how to logout from login session.
-->
<?php
   session_start();
   
   if(session_destroy()) {
      header("Location: index.php");
   }
?>
