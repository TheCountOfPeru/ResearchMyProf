<!--After successful login, it will display welcome page.
-->

<?php
   include('session.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ResearchMyProf - Welcome</title>
    </head>
    <body>
        <h1 align="center"
        style="font-family:consolas">Welcome<?php
        echo ", ".$login_session;
        ?></h1>
        <hr>
        <table align="center">
            <tr>
                <td><a href="searchpage.php">Search</a></td>
                <td><a href="logout.php">Logout</a></td>
                
            </tr>
        </table>
        <hr>
        
    </body>
</html>

