<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Profile creation page
-->
<?php
include('session.php');
$_SESSION['institution']= filter_input(INPUT_GET, 'institution');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - Pick Interests</title>
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Pick Interests</h1>
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
              action="add_profile_pub.php"
              method="">
                    Topics involved in:<br>
            <?php
            $sql="SELECT name FROM topic order by name"; 
                /* You can add order by clause to the sql statement if the names are to be displayed in alphabetical order */
                 
                foreach ($db->query($sql) as $row){//Array or records stored in $row
                    echo "<input type='checkbox' name='".$row[name]."' value='true'>".$row[name]."<br>";
                    
                    /* Option values are added by looping through the array */ 
                }
                 echo "</select><br><br>";// Closing of list box
            ?>
 
            <input type="submit" value="Next">
            
        </form>
        <?php
        echo $_SESSION['institution']
        ?>
        </body>
</html>
