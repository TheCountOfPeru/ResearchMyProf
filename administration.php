<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Page for user management. Restricted to admins.
-->
<?php
include('session.php');
        if($_SESSION['is_admin'] == '0'){
            echo $_SESSION['is_admin'];
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
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Administration</h1>
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
        <form action="" align="center" method="post">
        <?php
        $sql = "SELECT user.user_id, user.username, user.is_admin, user.is_mod, user.start_date
                FROM user";
                
        $result = mysqli_query($db,$sql);
                    echo "<table align='center'
                            style='width:50%'
                            border='1'><tr>
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
                        echo "<td align ='center'>"."<input type='checkbox' name=a".$row['user_id']." value='true'>"."</td>";
                        echo "<td align ='center'>"."<input type='checkbox' name=m".$row['user_id']." value='true'>"."</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                
        ?>
        <input type="submit" value="Admin/Moderator Permissions Flip" title="Change the status of a user"> 
        </form>
        
        </body>
</html>
