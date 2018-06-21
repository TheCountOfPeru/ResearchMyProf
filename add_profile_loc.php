<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Profile creation page
-->
<?php
include('session.php');
$_SESSION['profile_name']= filter_input(INPUT_GET, 'profile_name');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - Pick Location</title>
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Pick Location</h1>
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
              action="add_interests.php"
              method="">
                    Institution:<br>
            <?php
            $sql="SELECT i_name, postal_code FROM institution order by i_name"; 
                /* You can add order by clause to the sql statement if the names are to be displayed in alphabetical order */
                echo "<select name=institution value=''>Institution</option>"; // list box select command
 
                foreach ($db->query($sql) as $row){//Array or records stored in $row
                    echo "<option value=".preg_replace('/\s+/', ' ', $row[postal_code]).">$row[i_name]</option>"; 
                    /* Option values are added by looping through the array */ 
                }
                 echo "</select><br><br>";// Closing of list box
            ?>
            <input type="submit" value="Next">
        </form>
        <?php
        echo $_SESSION['profile_name']
        ?>
        </body>
</html>
