<?php
    // server che aggiunge un viaggio al carrello dell'utente loggato

    require_once "auth.php";

    if(!$userid=isSession()) exit;

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $userid = mysqli_real_escape_string($conn, $userid);
    $id_viaggio=mysqli_real_escape_string($conn, $_POST['id_viaggio']);
    $partenza=mysqli_real_escape_string($conn, $_POST['partenza']);
    $destinazione=mysqli_real_escape_string($conn, $_POST['destinazione']);
    $ora_partenza=mysqli_real_escape_string($conn, $_POST['ora_partenza']);
    $ora_arrivo=mysqli_real_escape_string($conn, $_POST['ora_arrivo']);
    $costo=mysqli_real_escape_string($conn, $_POST['costo']);

    //se ha gia' aggiunto per viaggio, non faccio nulla (si può prendere solo un biglietto per tipo, il biglietto e' personale)
    $query = "SELECT * FROM carrelli WHERE user_id = '$userid' AND id_viaggio = '$id_viaggio'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if(mysqli_num_rows($res) > 0) {
        mysqli_close($conn);
        echo json_encode(array('ok' => true));
        exit;
    }

    $query = "INSERT INTO carrelli(user_id, id_viaggio, partenza, destinazione, ora_partenza, ora_arrivo, costo) 
    VALUES('$userid','$id_viaggio', '$partenza', '$destinazione', '$ora_partenza', '$ora_arrivo', '$costo')";

    if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        mysqli_close($conn);
        echo json_encode(array('ok' => true));
        exit;
    }

    mysqli_close($conn);
    echo json_encode(array('ok' => false));

?>