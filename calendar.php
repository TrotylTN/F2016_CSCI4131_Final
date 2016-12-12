<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <title>
        My Calendar
    </title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLvHU7BAexcgc-wuWvEzQg6OHMBo_7Le8&libraries=places">
    </script>

</head>

<body>
    <div>
    <h2 class="tntitle"> My Calendar </h2>
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

    <p>
    </p>

    <table class="warn"> <tr class="warn"> <td class="warn">
      <?php
        global $caldata;
        $caldata = array("Mon"=>array(), "Tue"=>array(), "Wed"=>array(), "Thu"=>array(), "Fri"=>array());
        if (!file_exists($loginname."_calendar.txt")) {
            echo "Calendar has no events. Please use the input page to enter some events.\n";
        }
        else {
            $jsonfile = fopen($loginname."_calendar.txt", "r") or die("Unable to open file!");
            global $caldata;
            $enjsondata = fgets($jsonfile);
            if (feof($jsonfile)) {
                echo "Calendar has no events. Please use the input page to enter some events.\n";            
            }
            else {
                while (!feof($jsonfile)) {
                    if ($enjsondata == "")
                        break; 
                    $jsondata = json_decode($enjsondata);
                    $cnt = count($caldata[$jsondata->{"day"}]); 
                    $caldata[$jsondata->{"day"}][$cnt]["eventname"] = $jsondata->{"eventname"};
                    $caldata[$jsondata->{"day"}][$cnt]["starttime"] = $jsondata->{"starttime"};
                    $caldata[$jsondata->{"day"}][$cnt]["endtime"] = $jsondata->{"endtime"};
                    $caldata[$jsondata->{"day"}][$cnt]["location"] = $jsondata->{"location"};
                    $enjsondata = fgets($jsonfile);
                }
            }
            fclose($jsonfile);
        }

        // sort
        global $max_cnt;
        $max_cnt = 0;
        foreach ($caldata as $day_n => $day_arr) {
            $tot = count($day_arr);
            if ($tot > $max_cnt) {
                $max_cnt = $tot;
            }
            for ($i = 0; $i <$tot; $i++) {
                for ($j = $i; $j < $tot; $j++) {
                    if ($day_arr[$i]["starttime"] > $day_arr[$j]["starttime"]) {
                        $temp = $caldata[$day_n][$i];
                        $caldata[$day_n][$i] = $caldata[$day_n][$j];
                        $caldata[$day_n][$j] = $temp;
                    }
                }
            }
        }
      ?>
    </td> </tr> </table>      
    <div>
    <table>
      <?php
        global $caldata;
        global $max_cnt;
        $id = 0;
        foreach ($caldata as $day_n => $day_arr) {
          $id++;
          if (count($day_arr) > 0) {
            echo "<tr class='c'>\n";
            echo "<td class='days'> " . $day_n . " </td>\n";
            $tot = count($day_arr);
            for ($i = 0; $i < $tot; $i++) {
              echo "<td class='c'>" ;
              echo "<span class='time'> ";
              echo $day_arr[$i]["starttime"] . " - " . $day_arr[$i]["endtime"];
              echo " </span> <br> <br>";

              echo $day_arr[$i]["eventname"] . "<br>@";
              echo $day_arr[$i]["location"] . "<br>";
              echo "</td>\n";
            }
            for ($i = $tot; $i < $max_cnt; $i++) {
              echo "<td class='c'>";
              echo "<p> - </p>";
              echo "</td>";
            }
            echo "</tr>\n";
          }
        }
      ?>
    </table>
    </div>

    <p>
    </p>
    <table class="mp">
        <tr class="mp">
            <td class="mp">
                <input id="address" type="text" value="Coffman Memorial Union, MN" />
                <input id="submit_geo" type="button" value="Submit" />
            </td>
        </tr>
        <tr class="mp">
            <td class="mp">
                Radius between 500 and 50,000 <input id="radius" type="text" />
                <input id="submit_res" type="button" value="Find Nearby Restaurants" />
            </td>
        </tr>
    </table>

    <table class="mp">
        <tr class="mpmp">
            <td class="mpmp">
                <div id="map"></div>
            </td>
        </tr>
    </table>

    <div>
    <footer>
        <p class="foots">
            Tested in Chrome and Firefox.
        </p>
    </footer>
    </div>

    <script>
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: {lat: 44.974, lng: -93.234}
    });
    centerPoint = new google.maps.LatLng(44.974, -93.234);

    var infowindow = new google.maps.InfoWindow();
    var service = new google.maps.places.PlacesService(map);

    document.getElementById('submit_geo').addEventListener('click', getAddress);
    document.getElementById('submit_res').addEventListener('click', getRestaurants);

    // createCourse(44.9745476, -93.23223189999999, "Keller Hall<br><br>CSCI 4061 DIS<br>#1-250<br><br>CSCI 3081W DIS<br>#1-250");
    // createCourse(44.9740918, -93.23723039999999, "Bruininks Hall<br><br>CSCI 3081W LEC<br>#412<br><br>CSCI 4131 LEC<br>#230");
    // createCourse(44.977829, -93.23339799999997, "Bell Museum<br><br>CSCI 4061 LEC<br>Auditorium");
    // createCourse(44.9755702, -93.2373867, "Fraser Hall<br><br>CSCI 4707 LEC<br>#101");
    // createCourse(44.974518, -93.23470199999997, "Vincent Hall<br><br>CSCI 4211 LEC<br>#16");
    // createCourse(44.9694932, -93.2446084, "Hanson Hall<br><br>GEOG 1502 LEC<br>#1-106");

    function createCourse(myLatlng, courseName)
    {
        var marker = new google.maps.Marker({
            map: map,
            position: myLatlng,
            animation: google.maps.Animation.BOUNCE,
            title: 'UMN Pin'
        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(courseName);
            infowindow.open(map, this);
        });
    }

    function callback(results, status)
    {
        if (status == google.maps.places.PlacesServiceStatus.OK)
        {
            for (var i = 0; i < results.length; i++)
            {
                createMarker(results[i]);
            }
        }
    }

    function createMarker(place_result)
    {
        var request = {
            placeId: place_result.place_id
        };
        service.getDetails(request, function(place, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK)
            {
                var placeLoc = place.geometry.location;
                var placeName = place.name;
                var placeAddress = place.formatted_address;
                var marker = new google.maps.Marker({
                    map: map,
                    position: place.geometry.location,
                    title: 'UMN Pin'
                });
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent('<b>' + placeName + '</b><br>' +placeAddress);
                    infowindow.open(map, this);
                });
            }
        });
    }

    function getAddress() {
        var address = document.getElementById('address').value;
        var request = {
            query: address
        };
        service.textSearch(request, function(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK)
            {
                centerPoint = results[0].geometry.location;
                map.setCenter(centerPoint);
                var place = results[0];
                createMarker(place);
            }
        });
    }

    function getRestaurants()
    {
        var radius = document.getElementById('radius').value;
        var request = {
            location: centerPoint,
            radius: radius,
            type: ['restaurant']
        }
        service.nearbySearch(request, callback);
    }

    function eventPhpCallback(results, status)
    {
      if (status == google.maps.places.PlacesServiceStatus.OK)
      {
        createCourse(results[0].geometry.location, "<b>" + results[0].name + "</b>");
      }      
    }

    <?php
      global $caldata;
      foreach ($caldata as $day_n => $day_arr) {
        if (count($day_arr) > 0) {
          $tot = count($day_arr);
          for ($i = 0; $i < $tot; $i++) {
            echo "request = {query: '" . $day_arr[$i]["location"] . ", Minneapolis'};\n";
            echo "service.textSearch(request, eventPhpCallback);\n";
            // echo "createCourse(php_loc, '" . $day_arr[$i]["eventname"] . "' );\n";
          }
        }
      }      
    ?>
    </script>
</body>
</html>
