<?php

function EditLine($ID, $Name, $Login)
{
    $return_val = "";
    $return_val .= "<tr style='height: 50px'>\n";
    $return_val .= "<td style='width: 50px'> " . $ID . " </td>\n";
    $return_val .= "<td> <input type='text' name='". $ID ."nname' value='" . $Name . "'> </td>\n";
    $return_val .= "<td> <input type='text' name='". $ID ."nlog' value='" . $Login . "'> </td>\n";
    $return_val .= "<td> <input type='password' name='". $ID ."npass'> </td>\n";

    $return_val .= "<td>\n";
    $return_val .= '<button type="submit" name="'. $ID .'update" value="submitted">Update</button>';
    $return_val .= '<button type="submit" name="'. $ID .'can" value="submitted">Cancel</button>';
    $return_val .= "</td>\n";

    $return_val .= "</tr>\n";

    return $return_val;
}

function ShowLine($ID, $Name, $Login)
{
    $return_val = "";
    $return_val .= "<tr style='height: 50px'>\n";
    $return_val .= "<td style='width: 50px'> " . $ID . " </td>\n";
    $return_val .= "<td> " . $Name . " </td>\n";
    $return_val .= "<td> " . $Login . " </td>\n";
    $return_val .= "<td> </td>\n";

    $return_val .= "<td>\n";
    $return_val .= '<button type="submit" name="'. $ID .'edit" value="submitted">Edit</button>';
    $return_val .= '<button type="submit" name="'. $ID .'del" value="submitted">Delete</button>';
    $return_val .= "</td>\n";

    $return_val .= "</tr>\n";

    return $return_val;
}

function AddUser($newname, $newlogin, $newpass) {
    global $accDB;
    global $users_error;
    $users_error = "";
    if ($newname == "")
        $users_error .= "Please enter a valid username.<br>";
    if ($newlogin == "")
        $users_error .= "Please enter a valid login name.<br>";
    if ($newpass == "")
        $users_error .= "Please enter a valid password.<br>";

    if ($users_error != "") {
        return;
    }
    if ($accDB->adduser($newname, $newlogin, sha1($newpass)) == 1)
    {
        // success
    }
    else
    {
        $users_error .= "There has been a user which login name is '" . $newlogin . "'. Please choose other login name.<br>";
    }
    
}

function EditUser($old_info, $newName, $newLogin, $newPass) {
    if ($newName == "") {
        $name = $old_info['acc_name'];
    } else {
        $name = $newName;
    }
    if ($newLogin == "") {
        $login = $old_info['acc_login'];
    } else {
        $login = $newLogin;
    }
    if ($newPass == "") {
        $passcode = $old_info['acc_password'];
    } else {
        $passcode = sha1($newPass);
    }
    global $accDB;
    $accDB->update($old_info['acc_id'], $name, $login, $passcode);
}

    session_start();
    include_once "./models/account.php";
    if ($_SESSION["ACKed"] != 'yes') {
        header("Location: ./login.php");
    }
    $users_error = "";
    $users_data = "";
    if (!isset($accDB)) {
        global $accDB;
        $accDB = new AccountDB();
    }

    if (isset($_POST["addnew"])) {
        unset($_POST["addnew"]);
        AddUser($_POST["addname"], $_POST["addlogin"], $_POST["addpassword"]);
    }

    $cur_users = $accDB->getusers();
    // echo var_dump($cur_users);    
    foreach ($cur_users as $key_n => $user_info) {
        if (isset($_POST[$user_info['acc_id'].'update']))
        {
            EditUser($user_info,$_POST[$user_info['acc_id'].'nname'], $_POST[$user_info['acc_id'].'nlog'], $_POST[$user_info['acc_id'].'npass']);
            unset($_POST[$user_info['acc_id'].'update']);
            unset($_POST[$user_info['acc_id'].'edit']);
        }
        else if (isset($_POST[$user_info['acc_id'].'del']))
        {
            $accDB->deluser($user_info['acc_id']);
            unset($_POST[$user_info['acc_id'].'del']);
        }
        else if (isset($_POST[$user_info['acc_id'].'can']))
        {
            unset($_POST[$user_info['acc_id'].'can']);
            unset($_POST[$user_info['acc_id'].'edit']);
        }
    }
    $cur_users = $accDB->getusers();
    // echo var_dump($cur_users);
    foreach ($cur_users as $key_n => $user_info) {
        if (isset($_POST[$user_info['acc_id'].'edit']))
        {
            $users_data .= EditLine($user_info['acc_id'], $user_info['acc_name'], $user_info['acc_login']);
        }
        else 
        {
            $users_data .= ShowLine($user_info['acc_id'], $user_info['acc_name'], $user_info['acc_login']);
        }
    }

    include_once "./views/users_view.php";
?>