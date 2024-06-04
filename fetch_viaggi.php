<?php
        require_once 'auth.php';
        if (!$userid = isSession()) exit;

        
    
        header('Content-Type: application/json');

    
        $conn=mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die(mysqli_error($conn));
    
        $userid = mysqli_real_escape_string($conn, $userid);

        $partenza=$_POST['partenza'];
        $destinazione=$_POST['destinazione'];

    
        $query = "SELECT* from viaggi where partenza='$partenza' and destinazione='$destinazione'";
    
        $ris=mysqli_query($conn, $query) or die(mysqli_error($conn));
        
        if(mysqli_num_rows($ris)==0){
            echo json_encode("errore");
            mysqli_free_result($ris);
            mysqli_close($conn);
            exit;
        }
        $array_viaggi = array();
        while($riga = mysqli_fetch_assoc($ris)) {
            $array_viaggi[] =array('id' => $riga['id'],
                            'partenza' => $riga['partenza'],
                            'destinazione' => $riga['destinazione'],
                            'costo' => $riga['costo'],
                            // 'data_partenza' => $riga['data_partenza']
                            'ora_partenza' => $riga['ora_partenza'],
                            'ora_arrivo' => $riga['ora_arrivo']);
        }

        echo json_encode($array_viaggi);
        mysqli_free_result($ris);
        mysqli_close($conn);
        
        
        exit;
    
    
?>
