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
                $sql = "SELECT profile.profile_id, profile.name, interested_in.tname, institution.i_name, location.country, location.city
                        FROM profile JOIN location ON profile.I_postal=location.postal_code
						 JOIN institution ON profile.I_postal=institution.postal_code
						 JOIN interested_in ON profile.profile_id=interested_in.profile_id
                        WHERE";
                if($select == 'country'){
                    $sql = $sql." location.country LIKE '%".$query."%'";
                }elseif($select == 'institution'){
                    $sql = $sql." institution.i_name LIKE '%".$query."%'";
                }elseif($select == 'topic'){
                    $sql = $sql." interested_in.tname LIKE '%".$query."%'";
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
                <input class="w3-input w3-border-5 w3-pale-blue" type="text" name="query" value="<?php echo $name;?>">
                <br>
                <input class="w3-radio" type="radio" name="select" <?php if (isset($select) && $select=="country") echo "checked";?> value="country">Country
                <input class="w3-radio" type="radio" name="select" <?php if (isset($select) && $select=="institution") echo "checked";?> value="institution">Institution
                <input class="w3-radio" type="radio" name="select" <?php if (isset($select) && $select=="topic") echo "checked";?> value="topic">Topic<br>
                <br>
                <input class="w3-btn w3-padding w3-blue w3-round" type="submit" value='Search'>
        <br>
        </form>


        <?php
            if($query != "" || $select != ""){
                if ($result->num_rows > 0) {
                    // output data of each row
                    echo "        
        <div class=\"w3-table w4-container\" align='center'>
                            <table><tr>
                            <th>Name</th>
                            <th>Topic</th>
                            <th>Institution</th>
                            <th>Country</th>
                            <th>City</th>
                            </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><a href='profile.php?id=".$row["profile_id"]."'>".$row["name"]."</a></td>";
                        echo "<td>".$row["tname"]."</td>";//Should change this to show all topics related to profile, dont make another row of the same profile
                        echo "<td>".$row["i_name"]."</td>";
                        echo "<td>".$row["country"]."</td>";
                        echo "<td>".$row["city"]."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p align='center'>0 results</p>";
                }
            }
            ?>
        </div>
    </div>
    <div id = "footer">
    </div>
        </body>
</html>
