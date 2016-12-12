<?php
    $db_servername = 'egon.cs.umn.edu';
    $db_port = 3307;
    $db_name = 'C4131F16U128';  //Note xxx is a number, you can find it on moodle
    $db_username = 'C4131F16U128';
    $db_password = 18606;  // This should be on moodle as well.
    // Check connection
?>

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
        <h2 class="tntitle"> Login Page </h2>
        <p> </p>
        <table class="warn"> <tr class="warn"> <td class="warn">
        <?php     
            if ($_POST["passdata"] == "confirm") {          
                $flag = true;
                if ($_POST["login"] == "") {
                    $flag = false;
                    echo "Please enter a valid value for the User Login field.<br>";
                }
                if ($_POST["password"] == "") {
                    $flag = false;
                    echo "Please enter a valid value for the Password field.<br>";
                }
                if ($flag) {
                    $con= mysqli_connect($db_servername,$db_username,$db_password,$db_name,$db_port);
                    if (mysqli_connect_errno())
                    {
                        error_reporting(E_ALL); 
                        ini_set( 'display_errors','1');
                        echo 'Failed to connect to MySQL:' . mysqli_connect_error();
                        die();
                    }                       
                    $loginname = $_POST["login"];
                    $passwd = $_POST["password"];
                    $result = mysqli_query($con,"SELECT acc_password,acc_name FROM tbl_accounts WHERE acc_login='".$loginname."';");
                    // echo $result->num_rows;
                    if ($result->num_rows == 0)
                        echo "Account doesn't exist. Please check the login name again.";
                    else {
                        $obj = $result->fetch_object();
                        $svpasswd = $obj->acc_password;
                        $svname = $obj->acc_name;
                        if ($svpasswd != sha1($passwd)) {
                            echo "Password is incorrect. Please check the password and try again";
                        } else {
                            session_start();
                            $_SESSION['username'] = $svname;
                            $_SESSION['ACKed'] = 'yes';
                            $_SESSION['login'] = $loginname;
                            header("Location: ./calendar.php?".SID);
                        }
                    }
                    mysqli_close($con);
                }
            }
        ?>
        </td> </tr> </table>
        <form class="inputform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <p> </p>
        <table class="login">
            <tr class="login">
                <td class="login" style="width: 600px">
                    <p>Please enter your user's login name and password. Both values are case sensitive.</p>
                </td>
            </tr>
        </table>
        <table class="login">
            <tr class="login">
                <td class="login">
                    <p> Login: </p>
                </td>
                <td class="login" style="text-align: left">
                    <p> <input type="text" name="login"> </p>
                </td>
            </tr>
            <tr class="login">
                <td class="login">
                    <p> Password: </p>
                </td>
                <td class="login" style="text-align: left">
                    <p> <input type="password" name="password"> </p>
                </td>
            </tr>
        </table>
        <table class="login">
            <tr class="login">
                <td class="login" style="width: 600px">
                    <p> <button type="submit" name="passdata" value="confirm"> Submit </button> </p>
                </td>
            </tr>
        </table>
        </form>
    </body>
</html>