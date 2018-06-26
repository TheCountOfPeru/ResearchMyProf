<!DOCTYPE html>
<!--
Displays reports that are currently in the db. Can resolve reports.
-->
<?php
include('session.php');
        if($_SESSION['is_mod'] == '0'){
            header("location:welcome.php"); //Prevent non admin access to this page
        }
        if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "POST"){
            //used when a report is checked as resolved
            $sql="";
            //all changed check boxes are stored in an array and parsed to create update queries
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
        <link rel="stylesheet" type="text/css" href="newrmp.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
    <body>
    <div id = "container">
        <div id = "header">
        <h1>Moderation</h1>
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
        <form action="" method="post">
        <?php
        //print a table of all unresolved reports
        $sql = "SELECT *
                FROM report";   
        $result = mysqli_query($db,$sql);
                    echo "<div>
                            <table class=\"w3-table w3-container w3-bordered\"><tr>
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
                    
                    echo "</table><br>";
                
        ?>
            </div>
        <input class="w3-btn w3-padding w3-blue w3-round" type="submit" value="Mark as resolved" title="Change the status of selected reports to 'resolved'">
        </form><br><br>
    </div>
        </body>
</html>
