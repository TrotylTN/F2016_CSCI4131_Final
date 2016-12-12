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
    </body>
</html>