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
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Search</h1>
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
        <form action=""
              method="get">
            <p align="center">
               Query:<br>
        <input type="text" name="query" value="<?php echo $name;?>"><br> 
            </p>
           <p align="center">
            <input type="radio" name="select" <?php if (isset($select) && $select=="country") echo "checked";?> value="country">Country
            <input type="radio" name="select" <?php if (isset($select) && $select=="institution") echo "checked";?> value="institution">Institution
            <input type="radio" name="select" <?php if (isset($select) && $select=="topic") echo "checked";?> value="topic">Topic
           </p>
           <p align='center'>
               <input type="submit" value='Search'>
           </p>
        </form>
        <p>
            <?php
            if($query != "" || $select != ""){
                if ($result->num_rows > 0) {
                    // output data of each row
                    echo "<table align='center'
                            style='width:50%'
                            border='1'><tr>
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
        </p>
        </body>
</html>
