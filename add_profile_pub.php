<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Profile creation page
-->
<?php
include('session.php');
$temp="";
$safePost = filter_input_array(INPUT_GET);
            foreach($safePost as $key => $value){  
               $temp=$key.",".$temp;
                }        
               echo $temp;
$_SESSION['topics']=$temp;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - Add Publications</title>
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Add Publications</h1>
        <hr>
        <table align="center">
            <tr>
                 <?php if($_SESSION['is_admin'] == '1'){//Custom links depending on users permmisions
                    echo "<td><a href='administration.php'>Administration</a></td>";
                }?>
                <?php if($_SESSION['is_mod'] == '1'){
                    echo "<td><a href='moderation.php'>Moderation</a></td>";
                }?>
                <td><a href="searchpage.php">Search</a></td>
                <td><a href="create_profile.php">Add Profile</a></td>
                <td><a href="logout.php">Logout</a></td>
            </tr>
        </table>
        <hr>
        
        <form align="center"
              action="add_profile_worked.php"
              method="">
Publications Authored: <br>
                    Please type one publication per line. Add one link next to the title. Include the http part.<br>
                    <textarea name="Report" rows="20" cols="75" autofocus="">
                    </textarea><br><br>
                
                     
                    
 
            <input type="submit" value="Next">
            
        </form>
        
        </body>
</html>
