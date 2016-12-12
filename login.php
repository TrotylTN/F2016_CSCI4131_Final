<?php
    session_start();
    include "models/users.php";
    if (!isset($userdb)) {
        $userdb = new UsersDB();
    }
    $login_error = "";
    if (isset($_POST["passdata"])) {          
        $flag = true;
        if ($_POST["login"] == "") {
            $flag = false;
            $login_error .= "Please enter a valid value for the User Login field.<br>";
        }
        if ($_POST["password"] == "") {
            $flag = false;
            $login_error .= "Please enter a valid value for the Password field.<br>";
        }
        if ($flag) {                      
            $loginname = $_POST["login"];
            $passwd = $_POST["password"];
            $result = $userdb->get_user($loginname);
            // echo $result->num_rows;
            if ($result->num_rows == 0)
                $login_error .= "Account doesn't exist. Please check the login name again.";
            else {
                $obj = $result->fetch_object();
                $svpasswd = $obj->acc_password;
                $svname = $obj->acc_name;
                if ($svpasswd != sha1($passwd)) {
                    $login_error .= "Password is incorrect. Please check the password and try again";
                } else {
                    session_start();
                    $_SESSION['username'] = $svname;
                    $_SESSION['ACKed'] = 'yes';
                    $_SESSION['login'] = $loginname;
                    header("Location: ./calendar.php?".SID);
                }
            }
        }
    }
    include "./views/login_view.php";
?>