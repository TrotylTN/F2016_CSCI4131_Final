<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            Users Manager
        </title>
        <link rel="stylesheet" type="text/css" href="./style.css">
    </head>

    <body>
        <div>
        <h2 class="tntitle"> Users Manager </h2>
        <span style='margin-left: 40px; font-weight: bold'> Welcome  <?php echo $_SESSION['username']; ?> </span><br>
        <p>
        <button style='margin-left: 40px;' onclick="{location.href='./logout.php?<?php echo SID; ?>'}">Logout</button>
        </p>
        <nav class="cal">
            <button class="navlink" onclick="{location.href='./Calendar.php?<?php echo SID; ?>'}">My Calendar</button>
            <button class="navlink" onclick="{location.href='./Form.php?<?php echo SID; ?>'}">Form Input</button>
            <button class="navlink" onclick="{location.href='./admin.php?<?php echo SID; ?>'}">Users Manager</button>
        </nav>
        </div>
        <table class="warn"> <tr class="warn"> <td class="warn">
            <?php
                echo $users_error;
            ?>
        </td> </tr> </table> 
        <p></p>
        <form class="inputform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

        <table>
            <tr>
                <td style="width: 50px; height: 50px"> <b> ID </b> </td>
                <td> <b> Name </b> </td>
                <td> <b> Login </b> </td>
                <td> <b> New Password </b> </td>
                <td> <b> Action </b> </td>
            </tr>
            <?php echo $users_data; ?>
        </table>
        <p></p>
        <table style="width: 600px; border: none;">
            <tr style="height: 40px; border: none;">
                <td style="border: none;">
                    <h3> Add New User </h3>
                </td>
            </tr>
            <tr style="height: 40px; border: none;">
                <td style="border: none;">
                    <b> Name: <input type="text" name="addname"> </b>
                </td>
            </tr>
            <tr style="height: 40px; border: none;">
                <td style="border: none;">
                    <b> Login: <input type="text" name="addlogin"> </b>
                </td>
            </tr>
            <tr style="height: 40px; border: none;">
                <td style="border: none;">
                    <b> Password: <input type="password" name="addpassword"> </b>
                </td>
            </tr>             
            <tr style="height: 40px; border: none;">
                <td style="border: none;">
                    <button type="submit" name="addnew" value="submitted">Add User</button>
                </td>
            </tr>
        </table>
        </form>
    </body>
</html>