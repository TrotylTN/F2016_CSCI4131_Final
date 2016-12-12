<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            Login Page
        </title>
        <link rel="stylesheet" type="text/css" href="./style.css">
    </head>
    <body>
        <?php
            session_start();
            $_SESSION["ACKed"] = 'no';
            $_SESSION["username"] = '';
            $_SESSION["login"] = '';
        ?>        
        <h2 class="tntitle"> You have successfully logged out! </h2>
        <p style="font-weight: bold; margin-left: 40px;">
            If you wanna log back, <a href='./login.php'> click here. </a>
        </p>
    </body>
</html>