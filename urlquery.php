<?php
    $jsonfile = fopen("calendar.txt", "r") or die("Unable to open file!");
    $loc_req = $_GET["loc"];
    while (!feof($jsonfile)) {
        $enjsondata = fgets($jsonfile);
        if ($enjsondata == '') {
            break;
        }
        $jsondata = json_decode($enjsondata);
        if ($jsondata->{"location"} == $loc_req) {
            echo $jsondata->{"url"};
            fclose($jsonfile);
            break;
        }
    }
?>