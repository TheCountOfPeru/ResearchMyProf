<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Page for making updates to a profile. Should be linked to from all profile pages
Written Jonathan Yee, Brandt Davis and Dylan Loader
-->
<?php
   include('session.php');
   $result=$sql="";
   $id = filter_input(INPUT_GET, 'id');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - <?php
        $sql = "SELECT name
                FROM profile
                WHERE profile_id=".$id;
        $result = mysqli_query($db,$sql);
        $first_row = $result->fetch_assoc();
        echo $first_row['name'];
        ?>
        </title>
        <link rel="stylesheet" type="text/css" href="newrmp.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
    <body>
    <div id = "container">
        <div id = "header">
        <h1 align="center"
            style="font-family:consolas"><?php
        $sqlname = 
                "SELECT name
                FROM profile
                WHERE profile_id=".filter_input(INPUT_GET, 'id');
        $result = mysqli_query($db,$sqlname);
        $first_row = $result->fetch_assoc();
        echo $first_row['name'];
        ?></h1>
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

            <?php>
                $sqlname=
                    "SELECT profile_id
                    FROM profile
                    WHERE profile_id=".$id;
                 $result = mysqli_query($db,$sqlname);
                 $first_row = $result->fetch_assoc();
                
                echo "<td><a href='report.php?id=".$first_row["profile_id"]."'>Report Profile</a></td>"; 
                ?>
            </tr>
            </table>
            <hr>
            <p>
                <h2>
                    Institution:
                    <br>
            <p style="font-size:18px">
                <?php
                $sqlname =
                    "SELECT i.i_name, i.postal_code, l.postal_code, l.country, l.city, p.I_postal
                FROM institution i, location l, profile p
                WHERE i.postal_code = l.postal_code and p.I_postal = i.postal_code
                and p.profile_id=".filter_input(INPUT_GET, 'id');
                $result = mysqli_query($db, $sqlname);
                $first_row = $result->fetch_assoc();
                echo $first_row['i_name'].", ";
                echo $first_row['city'].", ";
                echo $first_row['country'];
                ?>
            </p>
            </h2>

            <h2>
                Interests:
                <br>
                <p style="font-size:18px">
                    <?php
                    $sqlname =
                        "SELECT interested_in.Tname
                  FROM interested_in, profile
                   WHERE interested_in.profile_id = profile.profile_id
                    and profile.profile_id=".filter_input(INPUT_GET, 'id');
                    $result2 = mysqli_query($db,$sqlname);
                    while($second_row = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$second_row['Tname']."</td>";
                        echo "<br>";
                    }
                    ?>
                </p>
            </h2>

            <h2>
                Papers:
                <br>
                <p style="font-size:18px">
                    <?php
                    $sqlname = "SELECT authored.Pname, publication.link_to
                      FROM authored, profile, publication
                       WHERE authored.profile_id = profile.profile_id
                       and publication.name = authored.Pname
                       and profile.profile_id=".filter_input(INPUT_GET, 'id');
                    $result2 = mysqli_query($db,$sqlname);
                    while($second_row = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$second_row['Tname']."</td>";
                        echo "<td>".$second_row['Pname']."<br>Link:"."</td>";
                        echo "<td><a href=" .$second_row['link_to'].">".$second_row['link_to']."</a></td>";
                        echo "<br><br>";
                    }
                    ?>
                </p>
            </h2>
            <h2>
                Institution:
                <br>
                <p style="font-size:18px">
                    <?php
                    $sqlname =
                        "SELECT i.i_name, i.postal_code, l.postal_code, l.country, l.city, p.I_postal
                FROM institution i, location l, profile p
                WHERE i.postal_code = l.postal_code and p.I_postal = i.postal_code
                and p.profile_id=".filter_input(INPUT_GET, 'id');
                    $result = mysqli_query($db, $sqlname);
                    $first_row = $result->fetch_assoc();
                    echo $first_row['i_name'].", ";
                    echo $first_row['city'].", ";
                    echo $first_row['country'];
                    ?>
                </p>
            </h2>

            <h2>
                Associated Profile(s):
                <br>
                <p style="font-size:18px">
                    <?php
                    $sqlname =
                        "SELECT worked_with.profile_idB, profile.name
                   FROM worked_with, profile
                    WHERE worked_with.profile_idB = profile.profile_id 
                    and worked_with.profile_idA =".filter_input(INPUT_GET, 'id');
                    $result2 = mysqli_query($db,$sqlname);
                    while($second_row = $result2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><a href='profile.php?id=".$second_row['profile_idB']."'>".$second_row['name']."</a></td>";
                        echo "<br>";
                    }
                    ?>
                </p>
                    </h2>

                </p>
        </div>
            </body>
</html>
