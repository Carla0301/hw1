<?php

    require_once 'auth.php';
    if (!$userid = isSession()) exit;


    header('Content-Type: application/json');

    $key_meteo='98PN893CB5TC5MNASCALHZULR';
    $meteo_endpoint='https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/';


    $localita=$_POST['localita'];

    $curl = curl_init();
    $url=$meteo_endpoint.$localita.'/?key='.$key_meteo.'&lang=it'.'&unitGroup=metric';
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $ris = curl_exec($curl);
    curl_close($curl);

    echo $ris;

?>