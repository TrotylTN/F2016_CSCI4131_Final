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
            echo $login_error;
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