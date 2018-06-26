<!--Logout page is having information about how to logout from login session.
Written Jonathan Yee, Brandt Davis and Dylan Loader
-->
<?php
   session_start();
   
   if(session_destroy()) {
      header("Location: index.php");
   }
?>
