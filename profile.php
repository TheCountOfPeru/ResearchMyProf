<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Page for making updates to a profile. Should be linked to from all profile pages
-->
<?php
   include('session.php');
   $result=$sql="";
   $id = filter_input(INPUT_GET, 'id');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - <?php
        $sql = "SELECT name
                FROM profile
                WHERE profile_id=".$id;
        $result = mysqli_query($db,$sql);
        $first_row = $result->fetch_assoc();
        echo $first_row['name'];
        ?>
        </title>
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas"><?php
        $sqlname = "SELECT name
                FROM profile
                WHERE profile_id=".filter_input(INPUT_GET, 'id');
        $result = mysqli_query($db,$sqlname);
        $first_row = $result->fetch_assoc();
        echo $first_row['name'];
        ?></h1>
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
        <p>		
	<h2>
        Institution - <?php
        $sqlname = "SELECT institution.i_name, location.country, location.city
                    FROM profile JOIN location ON profile.I_postal=location.postal_code
                                 JOIN institution ON profile.I_postal=institution.postal_code
                    WHERE profile.profile_id=".filter_input(INPUT_GET, 'id');
        $result = mysqli_query($db,$sqlname);
        $first_row = $result->fetch_assoc();
        echo $first_row['i_name'].", ";
        echo $first_row['country'].", ";
        echo $first_row['city'];
        ?>
        </h2>

	<h2>
	Interests
        </h2>

	<h2>
        Papers
        </h2>

        </p>
        
        
        </body>
</html>