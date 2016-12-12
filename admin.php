<?php
    session_start();
    include_once "./models/account.php";
    $users_error = "";
    if ($_SESSION["ACKed"] != 'yes') {
        header("Location: ./login.php");
    }

    include_once "./views/users_view.php";
?>