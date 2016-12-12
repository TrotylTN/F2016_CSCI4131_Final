<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            Calendar Input
        </title>
        <link rel="stylesheet" type="text/css" href="./style.css">
    </head>

    <body>   
        <div>
        <h2 class="tntitle"> Calendar Input </h2>      
        <?php
            session_start();
            if ($_SESSION["ACKed"] == 'yes') {
                echo "<span style='margin-left: 40px; font-weight: bold'>Welcome " . $_SESSION['username'] . '</span><br>';
                $loginname = $_SESSION['login'];
            } else {
                echo "<p style='color: red; font-weight: bold; margin-left: 40px;'> Please login first. </p>";
                echo "<p style='font-weight: bold; margin-left: 40px;'> If your browser didn't redirect automatically, <a href='./login.php'> click here to login. </a></p>";
                header("Location: ./login.php");
                die();
            }
        ?>
        <p>
        <button style='margin-left: 40px;' onclick="{location.href='./logout.php?<?php echo SID; ?>'}">Logout</button>
        </p>
        <nav class="cal">
            <button class="navlink" onclick="{location.href='./calendar.php?<?php echo SID; ?>'}">My Calendar</button>
            <button class="navlink" onclick="{location.href='./input.php?<?php echo SID; ?>'}">Form Input</button>
        </nav>
        </div>
        <table class="warn"> <tr class="warn"> <td class="warn">
            <?php 
                if ($_POST["clearall"] == 'confirm') {
                    $jsonfile = fopen($loginname."_calendar.txt", "w") or die("Unable to clean file!");
                    fclose($jsonfile);
                    header('Location: ./calendar.php?'.SID);
                }
                if ($_POST["passdata"] == 'submitted') {
                    $AllOK = true;
                    if ($_POST["eventname"] == "") {
                        echo "Please provide a value for Event Name<br>";
                        $AllOK = false;
                    }

                    if ($_POST["starttime"] == "") {
                        echo "Please select a value for Start Time!<br>";
                        $AllOK = false;
                    }

                    if ($_POST["endtime"] == "") {
                        echo "Please select a value for Event End Time<br>";
                        $AllOK = false;
                    }          

                    if ($_POST["location"] == "") {
                        echo "Please enter a value for Event Location<br>";
                        $AllOK = false;
                    }

                    if ($AllOK && ($_POST["starttime"] > $_POST["endtime"])) {
                        echo "Please enter a endtime which is later than the start time<br>";
                        $AllOK = false;
                    }

                    if ($AllOK) {
                        $jsonarr = array('eventname' => $_POST["eventname"],
                                         'starttime' => $_POST["starttime"],
                                         'endtime' => $_POST["endtime"],
                                         'location' => $_POST["location"],
                                         'day' => $_POST["day"],
                                         );
                        $jsonstring = json_encode($jsonarr);
                        $jsonfile = fopen($loginname."_calendar.txt", "a") or die("Unable to open file!");
                        fwrite($jsonfile, $jsonstring);
                        fwrite($jsonfile, "\n");
                        fclose($jsonfile);
                        header('Location: ./calendar.php?'.SID);
                    }                
                }
          ?>
        </td> </tr> </table>
        <p></p>
        <div>
        <form class="inputform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <table class="input">
            <tr class="input">
                <td class="input">
                    <p> <span class="sub"> Event Name: </span> </p>
                </td>
                <td class="input">
                    <p> <input type="text" name="eventname"> </p>
                </td>
            </tr>
            <tr class="input">
                <td class="input">
                    <p> <span class="sub"> Start Time: </span> </p>
                </td>
                <td class="input">
                    <p> <input type="time" name="starttime"> </p>
                </td>
            </tr>
            <tr class="input">
                <td class="input">
                    <p> <span class="sub"> End Time: </span> </p>
                </td>
                <td class="input">
                    <p> <input type="time" name="endtime"> </p>
                </td>
            </tr>
            <tr class="input">
                <td class="input">
                    <p> <span class="sub"> Location: </span> </p>
                </td>
                <td class="input">
                    <p> <input type="text" name="location"> </p>
                </td>
            </tr>
            <tr class="input">
                <td class="input">
                    <p> <span class="sub"> Day of the week: </span> </p>
                </td>
                <td class="input">
                <p>
                    <select name="day">
                        <option value="Mon">Mon</option>
                        <option value="Tue">Tue</option>
                        <option value="Wed">Wed</option>
                        <option value="Thu">Thu</option>
                        <option value="Fri">Fri</option>
                    </select>
                </p>
                </td>
            </tr>
            <tr class="input">
                <td class="input" style="text-align: center">
                    <button type="submit" name="clearall" value="confirm">Clear</button>
                </td>
                <td class="input" style="text-align: center">
                    <button type="submit" name="passdata" value="submitted">Submit</button>
                </td>
            </tr>
        </table>
        </form>
        </div>

        <div>
        <footer>
            <p class="foots">
                Tested in Chrome and Firefox.
            </p>
        </footer>
        </div>
    </body>
</html>
