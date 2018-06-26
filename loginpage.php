<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
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
        <title>ResearchMyProf - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="newrmp.css">
    </head>
    <body>
    <div id = "container">
        <div id = "header">
        <h1>Login</h1>
        </div>
            <div id = "content">
                <div class="w3-bar bar", style="vertical-align: center">
                    <a href="index.php" class="w3-button w3-blue w3-round w3-ripple w3-xlarge" style="width: 30%">Index</a>
                    <a href="loginpage.php" class="w3-button w3-blue w3-round w3-ripple w3-xlarge" style="width: 30%">Login</a>
                    <a href="aboutpage.php" class="w3-button w3-blue w3-round w3-ripple w3-xlarge" style="width: 30%">About</a>
                </div>
            </div>
        <form class="w3-container w3-center"
            action=""
            method="post">
        Username:<br>
                <input class="w3-input w3-border" type="text" name="Username"><br>

        Password:<br>
                <input class="w3-input w3-border" type="password" name="Password"><br><br>
        <input class="w3-btn w3-padding w3-blue w3-round" type="submit" value="Login">
        </form><br><br>
    </div>
    </body>
</html>
