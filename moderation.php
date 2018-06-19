<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Displays reports that are currently in the db
-->
<?php
include('session.php');
        if($_SESSION['is_mod'] == '0'){
            header("location:welcome.php"); //Prevent non admin access to this page
        }
        if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "POST"){
            $sql="";
            $safePost = filter_input_array(INPUT_POST);
            foreach($safePost as $key => $value){
                $sql = "UPDATE report SET date_resolved=CURRENT_TIMESTAMP
                        WHERE report.profile_id=".substr($key, 0, 1)." AND report.user_id=".substr($key, 1, 1).
                        " AND date_submit='".str_replace('_', ' ', substr($key, 2))."'";
                mysqli_query($db,$sql);
                }                            
        }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - Moderation</title>
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Moderation</h1>
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
        <form action="" align="center" method="post">
        <?php
        $sql = "SELECT *
                FROM report";   
        $result = mysqli_query($db,$sql);
                    echo "<table align='center'
                            style='width:50%'
                            border='1'><tr>
                            <th>Profile Id</th>
                            <th>User Id</th>
                            <th>Date Submitted</th>
                            <th>Date Resolved</th>
                            <th>Info</th>
                            <th>Select</th>
                            </tr>";
                    while($row = $result->fetch_assoc()) {
                        if($row[date_resolved] != NULL){ //skip any rows that are already resolved.
                            continue;
                        }
                        echo "<tr>";
                        echo "<td><a href='profile.php?id=".$row["profile_id"]."' target='_blank'>".$row["profile_id"]."</a></td>";
                        echo "<td>".$row["user_id"]."</td>";
                        echo "<td>".$row["date_submit"]."</td>";
                        echo "<td>".$row["date_resolved"]."</td>";
                        echo "<td>".$row["info"]."</td>";
                        echo "<td align ='center'>"."<input type='checkbox' name='"
                                .$row["profile_id"]
                                .$row["user_id"]
                                .preg_replace('/\s+/', ' ', $row["date_submit"])
                                ."' value='true'></td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                
        ?>
        <input type="submit" value="Mark as resolved" title="Change the status of selected reports to 'resolved'"> 
        </form>
        </body>
</html>
