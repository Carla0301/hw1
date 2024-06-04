<?php
require_once 'auth.php';


if (!isSession()) exit;


header('Content-Type: application/json');

spotify();

function spotify() {
    $client_id = "2e836c32d8e2429b887c4d348e393941";
    $client_secret = "6731a89481c745c388f3533bf0bae8c6";

    //token
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://accounts.spotify.com/api/token' );
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=client_credentials'); 
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($client_id.':'.$client_secret))); 
    $token=json_decode(curl_exec($curl), true);
    curl_close($curl);    

    //query
    $query = urlencode($_GET["q"]);
    $url = 'https://api.spotify.com/v1/search?type=track&q='.$query;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token['access_token'])); 
    $res=curl_exec($curl);
    curl_close($curl);

    echo $res;
}
?>