<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Page to create reports.
-->
<?php
include('session.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - Report</title>
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Report</h1>
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
        
        </body>
</html>
