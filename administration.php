<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Page for user management. Restricted to admins.
Written Jonathan Yee, Brandt Davis and Dylan Loader
-->
<?php
include('session.php');
        if($_SESSION['is_admin'] == '0'){
            header("location:welcome.php"); //Prevent non admin access to this page
        }
        if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "POST"){
            
            $sql="";
            $safePost = filter_input_array(INPUT_POST);
            foreach($safePost as $key => $value){
                 $sql="UPDATE user SET ";
                    if(substr($key, 0, 1)=='a'){
                        $sql=$sql."is_admin=NOT is_admin";
                    }
                    elseif(substr($key, 0, 1)=='m'){
                        $sql=$sql."is_mod=NOT is_mod";
                    }
                $sql=$sql." WHERE user_id='".substr($key, -1)."'";   
                mysqli_query($db,$sql);
                }              
        }     
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - Administration</title>
        <link rel="stylesheet" type="text/css" href="newrmp.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>

    <body>
    <div id = "container">
        <div id = "header">
            <h1>Administration</h1>
        </div>
        <div id = "content">
            <div class="w3-bar bar">
                <?php if($_SESSION['is_admin'] == '1'){//Custom links depending on users permmisions
                    echo "<a href='administration.php' class=\"w3-button w3-blue w3-round w3-ripple w3-xlarge\" style=\"width: 20%\">Administration</a>";
                }?>
                <?php if($_SESSION['is_mod'] == '1'){
                    echo "<a href='moderation.php' class=\"w3-button w3-blue w3-round w3-ripple w3-xlarge\" style=\"width: 20%\">Moderation</a>";
                }?>
                <a href="searchpage.php" class="w3-button w3-blue w3-round w3-ripple w3-xlarge" style="width: 20%">Search</a>
                <a href="create_profile.php" class="w3-button w3-blue w3-round w3-ripple w3-xlarge" style="width: 20%">Add Profile</a>
                <a href="logout.php" class="w3-button w3-blue w3-round w3-ripple w3-xlarge" style="width: 20%">Logout</a>
            </div>
    </div>
        <form class="w3-cell-row w3-border w3-centered w3-light-grey w3-animate-input" action="" align="center" method="post">

        <?php
        $sql = "SELECT user.user_id, user.username, user.is_admin, user.is_mod, user.start_date
                FROM user";

        $result = mysqli_query($db,$sql);
                    echo "<div>
                            <table class=\"w3-table w3-cell-row w3-centered w3-bordered\"><tr>
                            <th>User Id</th>
                            <th>Username</th>
                            <th>Is Admin</th>
                            <th>Is Moderator</th>
                            <th>Created On</th>
                            <th>Admin Permissions Flip</th>
                            <th>Moderator Permissions Flip</th>
                            </tr>";
                    
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row["user_id"]."</td>";
                        echo "<td>".$row["username"]."</td>";
                        echo "<td>".$row["is_admin"]."</td>";
                        echo "<td>".$row["is_mod"]."</td>";
                        echo "<td>".$row["start_date"]."</td>";
                        echo "<td>"."<input class = 'w3-check w3-centered' type='checkbox' name=a".$row['user_id']." value='true'>"."</td>";
                        echo "<td>"."<input class = 'w3-check w3-centered' type='checkbox' name=m".$row['user_id']." value='true'>"."</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
        ?>
        <input class="w3-btn w3-padding w3-blue w3-round" type="submit" value="Admin/Moderator Permissions Flip" title="Change the status of a user">
        </form><br><br>

        <div id="footer">

        </div>

    </body>
</html>
