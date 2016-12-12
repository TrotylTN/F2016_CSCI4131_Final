<?php
    session_start();
    include_once "./models/account.php";
    if ($_SESSION["ACKed"] != 'yes') {
        header("Location: ./login.php");
    }
    $users_error = "";
    

    include_once "./views/users_view.php";
?>