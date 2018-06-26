<!DOCTYPE html>
<!--
Page to create reports. Needs to be accessed from a profile page so that the profile_id is given to this page
Written Jonathan Yee, Brandt Davis and Dylan Loader
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
        <link rel="stylesheet" type="text/css" href="newrmp.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
    <body>
    <div id = "container">
        <div id = "header">
        <h1>Report</h1>
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
        <form class="w3-dropdown w3-center w3-container"
              method="post">
            <p>
                Please write a report that clearly states what is incorrect and how it should be fixed.
                <br>
                Providing sources to where you found the correct information is recommended.
            </p>
            
            <textarea  style="width:80%" name="Report" rows="10" cols="50" autofocus="">
            
            </textarea>
            <br>
            <input class="w3-btn w3-padding w3-blue w3-round" type="submit">
            <br><br>
        </form>
        </div>
    </div>
    </body>
</html>
