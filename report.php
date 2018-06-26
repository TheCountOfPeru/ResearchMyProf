<!DOCTYPE html>
<!--
Page to create reports. Needs to be accessed from a profile page so that the profile_id is given to this page
-->
<?php
    include('session.php');
    $profile_id = $_GET["id"];
    if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "POST"){//used when a report is submitted
                $report = mysqli_real_escape_string($db,filter_input(INPUT_POST, 'Report'));
                $sql = "INSERT INTO report VALUES (".$profile_id.", ".$_SESSION['user_id'].
                        ", NULL, CURRENT_TIMESTAMP, '".$report."')";
                echo $sql;
                mysqli_query($db,$sql);
                //transport the user back to the profile page
                header("location: profile.php?id=".$profile_id);
            }
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
        <form align="center"
              method="post">
            <p>
                Please write a report that clearly states what is incorrect and how it should be fixed.
                <br>
                Providing sources to where you found the correct information is recommended.
            </p>
            
            <textarea name="Report" rows="10" cols="50" autofocus="">
            
            </textarea>
            <br>
            <input type="submit">
        </form>
        </body>
</html>
