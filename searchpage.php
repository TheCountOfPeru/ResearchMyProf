<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
   include('session.php');
   
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
                <td><a href="searchpage.php">Search</a></td>
                <td><a href="logout.php">Logout</a></td>
            </tr>
        </table>
        <hr>
        <form action=""
              method="get">
        <table align="center">
            <tr>
                <td><input type="text" name="school"></td>
                <td>School</td> 
            </tr>
            <tr>
                <td><input type="text" name="researcherName"></td>
                <td>Researcher Name</td> 
            </tr>
            <tr>
                <td><input type="text" name="topic"></td>
                <td>Topic of Interest</td> 
            </tr>
        </table>
                <p align="center"><input type="submit" value="Search"></p>
        </form>
        <?php
                $schl = mysqli_real_escape_string($db,filter_input(INPUT_GET, 'school'));
                $sql = "SELECT postal_code, name FROM institution WHERE name LIKE '%$schl%'";
                //echo $sql."<br>"
                $result = mysqli_query($db,$sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "Postal Code: " . $row["postal_code"]. " Name: " . $row["name"]. "<br>";
                    }
                } else {
                    echo "0 results";
                }
                ;?>
        </body>
</html>
