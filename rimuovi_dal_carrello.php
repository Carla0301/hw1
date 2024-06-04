<?php
    require_once "auth.php";

    if(!$userid=isSession()) exit;

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $userid = mysqli_real_escape_string($conn, $userid);
    $id_viaggio=mysqli_real_escape_string($conn, $_POST['id_viaggio']);


    $query = "SELECT * FROM carrelli WHERE user_id = '$userid' AND id_viaggio = '$id_viaggio'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if(mysqli_num_rows($res) == 0) {
        echo json_encode(array('ok' => true));
        exit;
    }

    $query = "DELETE FROM carrelli WHERE user_id = '$userid' AND id_viaggio = '$id_viaggio'";


    if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        echo json_encode(array('ok' => true));
        exit;
    }

    mysqli_close($conn);
    echo json_encode(array('ok' => false));
?>