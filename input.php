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
        <table class="ad">
        <tr class="ad">
            <td class="adbutton">
                <img id="leftbutton" src="./prev_blue.png" alt="previous" title="Previous">
            </td>
            <td class="ad">
                <img id="mainad" src="./Nerve.jpg" alt="Nerve">
            </td>
            <td class="adbutton">
                <img id="rightbutton" src="./next_blue.png" alt="next" title="Next">
            </td>
        </tr>
        </table>

        <table class="adswitch">
        <tr class="sw">
            <td class="sw">
                <img id="adbutton1" src="./bullet_gray.png" alt="ad_1" title="First Ad">
            </td>
            <td class="sw">
                <img id="adbutton2" src="./bullet_gray.png" alt="ad_2" title="Second Ad">
            </td>
            <td class="sw">
                <img id="adbutton3" src="./bullet_gray.png" alt="ad_3" title="Third Ad">
            </td>
        </tr>
        </table>

        <div>
        <h2 class="tntitle"> Calendar Input </h2>
        <nav class="cal">
            <button class="navlink" onclick="{location.href='./calendar.php'}">My Calendar</button>
            <button class="navlink" onclick="{location.href='./input.php'}">Form Input</button>
        </nav>
        </div>
        <table class="warn"> <tr class="warn"> <td class="warn">
            <?php 
                if ($_POST["clearall"] == 'confirm') {
                    $jsonfile = fopen("calendar.txt", "w") or die("Unable to clean file!");
                    fclose($jsonfile);
                    header('Location: ./calendar.php');
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

                    if ($_POST["url"] == "") {
                        echo "Please enter a picture URL for the event<br>";
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
                                         'url' => $_POST["url"]
                                         );
                        $jsonstring = json_encode($jsonarr);
                        $jsonfile = fopen("calendar.txt", "a") or die("Unable to open file!");
                        fwrite($jsonfile, $jsonstring);
                        fwrite($jsonfile, "\n");
                        fclose($jsonfile);
                        header('Location: ./calendar.php');
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
                <td class="input">
                    <p> <span class="sub"> Picture URL: </span> </p>
                </td>
                <td class="input">
                    <p> <input type="url" name="url"> </p>
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

        <script type="text/javascript">
            var filmURL = "http://sua.umn.edu/events/calendar/event/14781/";
            var curr_ad = 0;
            var curr_mouse = 0;

            var leftbutton = document.getElementById("leftbutton");
            leftbutton.addEventListener("click", prev_ad);
            leftbutton.addEventListener("mouseover", function() {
                leftbutton.src = "./prev_orange.png";
            });
            leftbutton.addEventListener("mouseout", function() {
                leftbutton.src = "./prev_blue.png";
            });

            var rightbutton = document.getElementById("rightbutton");
            rightbutton.addEventListener("click", next_ad);
            rightbutton.addEventListener("mouseover", function() {
                rightbutton.src = "./next_orange.png";
            });
            rightbutton.addEventListener("mouseout", function() {
                rightbutton.src = "./next_blue.png";
            })

            var ad = document.getElementById("mainad");
            ad.addEventListener("click", function() {
                window.open(filmURL);
            });

            var bullet_color_before_on1;
            var bullet_color_before_on2;
            var bullet_color_before_on3;

            var button1 = document.getElementById("adbutton1");
            button1.addEventListener("click", ad_1);
            button1.addEventListener("mouseover", function() {
                bullet_color_before_on1 = button1.src;
                curr_mouse = 1;
                if (curr_ad != 1)
                {
                    button1.src = "./bullet_orange.png";
                }
            });
            button1.addEventListener("mouseout", function() {
                button1.src = bullet_color_before_on1;
                curr_mouse = 0;
            });

            var button2 = document.getElementById("adbutton2");
            button2.addEventListener("click", ad_2);
            button2.addEventListener("mouseover", function() {
                bullet_color_before_on2 = button2.src;
                curr_mouse = 2;
                if (curr_ad != 2)
                {
                    button2.src = "./bullet_orange.png";
                }
            });
            button2.addEventListener("mouseout", function() {
                button2.src = bullet_color_before_on2;
                curr_mouse = 0;
            });

            var button3 = document.getElementById("adbutton3");
            button3.addEventListener("click", ad_3);
            button3.addEventListener("mouseover", function() {
                bullet_color_before_on3 = button3.src;
                curr_mouse = 3;
                if (curr_ad != 3)
                {
                    button3.src = "./bullet_orange.png";
                }
            });
            button3.addEventListener("mouseout", function() {
                button3.src = bullet_color_before_on3;
                curr_mouse = 0;
            })

            var temptime;

            ad_1();

            function prev_ad()
            {
                if (curr_ad == 1)
                {
                    curr_ad = 3;
                }
                else
                {
                    curr_ad = curr_ad - 1;
                }
                // stop all time func started before
                clearTimeout(temptime);
                temptime = setTimeout("ad_" + String(curr_ad) + "()", 0);
            }

            function next_ad()
            {
                if (curr_ad == 3)
                {
                    curr_ad = 1;
                }
                else
                {
                    curr_ad = curr_ad + 1;
                }
                // stop all time func started before
                clearTimeout(temptime);
                temptime = setTimeout("ad_" + String(curr_ad) + "()", 0);
            }

            function ad_1()
            {
                clearTimeout(temptime);
                curr_ad = 1;
                ad.src = "./Nerve.jpg";
                ad.alt = "Nerve";
                ad.title = "Nerve\nFri, Sep 30 7:00PM";
                bullet_color_before_on1 = "./bullet_blue.png";
                bullet_color_before_on2 = "./bullet_gray.png";
                bullet_color_before_on3 = "./bullet_gray.png";
                button2.src = "./bullet_gray.png";
                button3.src = "./bullet_gray.png";
                button1.src = "./bullet_blue.png";
                if (curr_mouse != 0 && curr_mouse != curr_ad)
                {
                    setTimeout("button" + String(curr_mouse) + ".src = './bullet_orange.png'", 0);
                }
                filmURL = "http://sua.umn.edu/events/calendar/event/14781/";
                temptime = setTimeout("ad_2()", 7000);
            }

            function ad_2()
            {
                clearTimeout(temptime);
                curr_ad = 2;
                ad.src = "./secret-life-of-pets.jpg";
                ad.alt = "Secret-life-of-pets";
                ad.title = "The Secret Life of Pets\nFri, Oct 7 7:00PM";
                bullet_color_before_on2 = "./bullet_blue.png";
                bullet_color_before_on1 = "./bullet_gray.png";
                bullet_color_before_on3 = "./bullet_gray.png";
                button3.src = "./bullet_gray.png";
                button1.src = "./bullet_gray.png";
                button2.src = "./bullet_blue.png";
                if (curr_mouse != 0 && curr_mouse != curr_ad)
                {
                    setTimeout("button" + String(curr_mouse) + ".src = './bullet_orange.png'", 0);
                }
                filmURL = "http://sua.umn.edu/events/calendar/event/14786/";
                temptime = setTimeout("ad_3()", 5000);
            }

            function ad_3()
            {
                clearTimeout(temptime);
                curr_ad = 3;
                ad.src = "./suicide-squad.jpg";
                ad.alt = "suicide-squad";
                ad.title = "Suicide Squad\nFri, Oct 14 8:00PM";
                bullet_color_before_on3 = "./bullet_blue.png";
                bullet_color_before_on1 = "./bullet_gray.png";
                bullet_color_before_on2 = "./bullet_gray.png";
                button2.src = "./bullet_gray.png";
                button1.src = "./bullet_gray.png";
                button3.src = "./bullet_blue.png";
                if (curr_mouse != 0 && curr_mouse != curr_ad)
                {
                    setTimeout("button" + String(curr_mouse) + ".src = './bullet_orange.png'", 0);
                }
                filmURL = "http://sua.umn.edu/events/calendar/event/14794/";
                temptime = setTimeout("ad_1()", 3000);
            }
        </script>
    </body>
</html>
