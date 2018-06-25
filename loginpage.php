<!DOCTYPE html>
<!--
sources: https://www.tutorialspoint.com/php/php_mysql_login.htm
https://stackoverflow.com/questions/19767894/warning-do-not-access-superglobal-post-array-directly-on-netbeans-7-4-for-ph
-->
<?php
   include("config.php");
   session_start();
   
   if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "POST") {
      // username and password sent from form 
      $myusername = mysqli_real_escape_string($db,filter_input(INPUT_POST, 'Username'));
      $mypassword = mysqli_real_escape_string($db,filter_input(INPUT_POST, 'Password')); 
      
      $sql = "SELECT user_id, is_admin, is_mod FROM user WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $first_row = $result->fetch_assoc();
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      //Get some user info from db
      $user_id = $first_row['user_id'];
      $is_admin = $first_row['is_admin'];
      $is_mod = $first_row['is_mod'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         //session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         $_SESSION['user_id'] = $user_id;
         $_SESSION['is_admin'] = $is_admin;
         $_SESSION['is_mod'] = $is_mod;
        
         header("location: welcome.php");
      }else {
          
         $error = "Your Login Name or Password is invalid";
         echo $error;
      }
   }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - Login</title>
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Login</h1>
        <hr>
        <table align="center">
            <tr>
                <td><a href="index.php">Home</a></td>
                <td><a href="loginpage.php">Login</a></td>
                <td><a href="aboutpage.php">About</a></td>
            </tr>
        </table>
        <hr>
        <form align="center" 
            action="" 
            method="post">
        Username:<br>
        <input type="text" name="Username" autofocus=""><br>
        Password:<br>
        <input type="password" name="Password"><br><br>
        <input type="submit" value="Login">
        </form>
    </body>
</html>
