<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password)
Written Jonathan Yee, Brandt Davis and Dylan Loader*/
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'rootpass');
define('DB_NAME', 'researchmyprof');
 
/* Attempt to connect to MySQL database */
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

<!--
 source: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
 -->

