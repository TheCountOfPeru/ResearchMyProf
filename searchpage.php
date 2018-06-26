<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
   include('session.php');
   // define variables and set to empty values
   $selectErr = $queryErr = "";
    $select = $query = "";
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "GET") {
            //Button block
             if (empty(filter_input(INPUT_GET, 'select'))) {
                $selectErr = "Selection is required";
              } else {
                $select = test_input(filter_input(INPUT_GET, 'select'));
              }
              
            
            //Query block
            if (filter_input(INPUT_GET, 'query') == "") {
                $queryErr = "Query is required";
            }else{
                $query = mysqli_real_escape_string($db,filter_input(INPUT_GET, 'query'));
                $query = trim($query);
                
                if($select == 'country'){//Search by country name
                    $sql = "SELECT profile.profile_id, profile.name, institution.i_name, location.country, location.city
                            FROM profile JOIN location ON profile.I_postal=location.postal_code
                                         JOIN institution ON profile.I_postal=institution.postal_code
                                         WHERE location.country LIKE '%";
                    $sql = $sql.$query."%'";
                }elseif($select == 'institution'){//Search by institution name
                    $sql = "SELECT profile.profile_id, profile.name, institution.i_name, location.country, location.city
                            FROM profile JOIN location ON profile.I_postal=location.postal_code
                                         JOIN institution ON profile.I_postal=institution.postal_code
                                         WHERE institution.i_name LIKE '%";
                    $sql = $sql.$query."%'";
                }elseif($select == 'topic'){//Search ]by topic name
                    //Find profiles based on interested topics first - need exact match
                    $sql = "SELECT interested_in.profile_id
                            FROM interested_in
                            WHERE tname='";
                    $sql = $sql.strtolower($query)."'";
                }
                $result = mysqli_query($db,$sql);
            }
           
            
          }
          
          function test_input($data) {
            $trim = trim($data);
            $strip = stripslashes($trim);
            $special = htmlspecialchars($strip);
         return $special;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - Search</title>
        <link rel="stylesheet" type="text/css" href="newrmp.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
    <body>
    <div id = "container">
        <div id = "header">
        <h1 align="center"
        style="font-family:consolas">Search</h1>
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

        <h2>Query:</h2>
        <form class="w3-container w3-border w3-light-grey w3-animate-input">
                <input class="w3-input w3-border-5 w3-"  type="text" name="query" value="<?php echo $name;?>">
                    <br>
                <input class="w3-radio" type="radio" name="select" <?php if (isset($select) && $select=="country") echo "checked";?> value="country">Country
                <input class="w3-radio" type="radio" name="select" <?php if (isset($select) && $select=="institution") echo "checked";?> value="institution">Institution
                <input class="w3-radio" type="radio" name="select" <?php if (isset($select) && $select=="topic") echo "checked";?> value="topic">Topic<br>
                <br>
                <input class="w3-btn w3-padding w3-blue w3-round" type="submit" value='Search'>
        <br><br>



       <?php
            if($query != "" || $select != ""){//check if query is empty
                if ($result->num_rows > 0) {
                    // output data of each row
                    echo "<table align='center' //Print table headers
                            style='width:50%'
                            border='1'><tr>
                            <th>Name</th>
                            <th>Institution</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Topic(s)</th>
                            </tr>";
                    if($select == 'country' || $select == 'institution'){
                        while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><a href='profile.php?id=".$row["profile_id"]."'>".$row["name"]."</a></td>";
                        //echo "<td>".$row["tname"]."</td>";//Should change this to show all topics related to profile, dont make another row of the same profile
                        echo "<td>".$row["i_name"]."</td>";
                        echo "<td>".$row["country"]."</td>";
                        echo "<td>".$row["city"]."</td>";
                        
                        //Query for the profile_id interested in topics
                        echo "<td>";
                        echo "<table>";
                        $tsql = "SELECT tname FROM interested_in WHERE profile_id=".$row["profile_id"];
                        $tresult = mysqli_query($db,$tsql);
                        //print out the topics into the last column
                        while($trow = $tresult->fetch_assoc()){
                            echo $trow["tname"]."<br>";
                            }
                        echo "</table>";
                        echo "</td>";
                        echo "</tr>";
                        }
                    }elseif($select == 'topic'){
                        
                        while($row = $result->fetch_assoc()){//loop for print each row
                            $p_id = $row["profile_id"];
                            //from the row's profile_id find other info to print, need another query
                            $tsql = "SELECT profile.profile_id, profile.name, institution.i_name, location.country, location.city
                                     FROM profile JOIN location ON profile.I_postal=location.postal_code
                                             JOIN institution ON profile.I_postal=institution.postal_code
                                     WHERE profile.profile_id=".$p_id;
                            $tresult = mysqli_query($db,$tsql);//returns info about a profile_id. should only get 1 profile
                            $first_row = $tresult->fetch_assoc();
                        echo "<tr>";
                        echo "<td><a href='profile.php?id=".$first_row["profile_id"]."'>".$first_row["name"]."</a></td>";
                        //echo "<td>".$row["tname"]."</td>";//Should change this to show all topics related to profile, dont make another row of the same profile
                        echo "<td>".$first_row["i_name"]."</td>";
                        echo "<td>".$first_row["country"]."</td>";
                        echo "<td>".$first_row["city"]."</td>";
                        
                        //Query for the profile_id interested in topics
                        echo "<td>";
                        echo "<table>";
                        $tsql = "SELECT tname FROM interested_in WHERE profile_id=".$p_id;
                        $tresult = mysqli_query($db,$tsql);
                        //print out the topics into the last column
                        while($trow = $tresult->fetch_assoc()){
                            echo $trow["tname"]."<br>";
                            }
                        echo "</table>";
                        echo "</td>";
                        echo "</tr>";
                        }
                        
                    }
                    
                    
                    echo "</table>";
                } else {
                    echo "<p align='center'>0 results</p>";
                }
            }
            ?>
        </form>
    </div>
    <div id = "footer">
    </div>
        </body>
</html>
