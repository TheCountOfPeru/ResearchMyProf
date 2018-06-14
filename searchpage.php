<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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

                <td><a href="aboutpage.php">About</a></td>
            </tr>
        </table>
        <hr>
        <form>
        <table align="center">
            <tr>
                <td><input type="text" name="School"></td>
                <td>School</td> 
            </tr>
            <tr>
                <td><input type="text" name="Researcher Name"></td>
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
        // put your code here
        ?>
    </body>
</html>
