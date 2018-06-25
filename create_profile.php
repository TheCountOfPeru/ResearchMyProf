<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
Profile creation page
-->
<?php
include('session.php');
if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "POST"){
    //this part happens after information has been submitted to create a new profile
    //initialize some vars
    $sql="";
$name = $_POST['profile_name'];
$institution = $_POST['institution'];
//start inserting into the db
$sql="INSERT INTO profile (user_id_creator, I_postal, name) VALUES ('".$_SESSION['user_id']."', '".$institution."', '".$name."');";
mysqli_query($db,$sql);
//grab the newly created profile's id
$sql="SELECT profile_id FROM profile WHERE user_id_creator=".$_SESSION['user_id']." AND I_postal='".$institution."' AND name='".$name."';";
$result = mysqli_query($db,$sql);
$first_row = $result->fetch_assoc();

//prepare to insert into other important profile related tables
$profile_id = $first_row['profile_id'];
$topicsArr = $_POST['topics'];
$assocArr = $_POST['assoc'];
$publication = $_POST['publication'];

if(!empty($topicsArr)){
    foreach ($topicsArr as $key => $value) {
       $sql="INSERT INTO interested_in VALUES (".$profile_id.", '".$value."');";
       mysqli_query($db,$sql);
   }
}

if(!empty($assocArr)){
    foreach ($assocArr as $key => $value) {
       $sql="INSERT INTO worked_with VALUES (".$profile_id.", ".$value.");";
       mysqli_query($db,$sql);
   }
}

$publicationArr = explode("\n", str_replace("\r", "", $publication));//source:https://stackoverflow.com/a/16518665
if(!empty($publicationArr)){
    foreach ($publicationArr as $key => $value) {
       $pieces = explode(",", $value);
       $sql="INSERT INTO publication VALUES ('".trim($pieces[0])."', '".trim($pieces[1])."');";
       mysqli_query($db,$sql);
       $sql="INSERT INTO related_to VALUES ('".trim($pieces[2])."', '".trim($pieces[0])."');";
       mysqli_query($db,$sql);
       $sql="INSERT INTO authored VALUES (".$profile_id.", '".trim($pieces[0])."');";
       mysqli_query($db,$sql);

   }
}
//transport the user to the newly created profile page
header("location: profile.php?id=".$profile_id);
}?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Profile</title>
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Add Profile</h1>
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
              action="create_profile.php"
              method="POST">
                   Full Name:<br>
                   <input type="text" name="profile_name"><br><br>
                   
                   Institution:<br>
                    <?php
            $sql="SELECT i_name, postal_code FROM institution order by i_name"; 
                //populate a option box with a query
            //source:https://www.idtech.com/blog/populating-a-combo-box-in-php-dynamically-from-mysql
                echo "<select name=institution value=''>Institution</option>"; // list box select command
 
                foreach ($db->query($sql) as $row){//Array or records stored in $row
                    echo "<option value=".preg_replace('/\s+/', ' ', $row[postal_code]).">$row[i_name]</option>"; 
                    /* Option values are added by looping through the array */ 
                }
                 echo "</select><br><br>";// Closing of list box
            ?>
                   
                   Topic(s) Interest In:<br>
                   Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.<br>
                    <?php
            $sql="SELECT name FROM topic order by name"; 
                /* You can add order by clause to the sql statement if the names are to be displayed in alphabetical order */
                echo "<select name='topics[]' multiple='multiple' size='16'>Topic</option>"; // list box select command
                foreach ($db->query($sql) as $row){//Array or records stored in $row
                    echo "<option value=$row[name]>$row[name]</option>"; 
                    
                    /* Option values are added by looping through the array */ 
                }
                 echo "</select><br><br>";// Closing of list box
            ?>
                   
                   Publications Authored: <br>
                   Please type one publication per line in the format:<br>
                   [Title],[link to],[Topic Related to]<br>
                    <textarea name="publication" rows="20" cols="100" autofocus="">
                    </textarea><br><br>
                    
                    Associated Profiles:<br>
                     Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.<br>
                    <?php
            $sql="SELECT name, profile_id FROM profile order by name"; 
                /* You can add order by clause to the sql statement if the names are to be displayed in alphabetical order */
                echo "<select name='assoc[]' multiple='multiple' size='16'>Topic</option>"; // list box select command
 
                foreach ($db->query($sql) as $row){//Array or records stored in $row
                    echo "<option value=$row[profile_id]>$row[name]</option>"; 
                    /* Option values are added by looping through the array */ 
                }
                 echo "</select><br><br>";// Closing of list box
            ?>
                    
                    
            <input type="submit" value="Submit">
        </form>
        </body>
</html>
