<?php

    include "auth.php";

    if(isSession()!=0){
        header("Location: home.php");
        exit;
    }

    //se username e password sono stati inseriti, creo la connessione al database
    if(!empty($_POST["username"]) && !empty($_POST["password"])){

        $conn=mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die(mysqli_error($conn));

        //per evitare injections
        $username=mysqli_real_escape_string($conn, $_POST["username"]);

        $query = "SELECT id, username, pswrd FROM users WHERE username = '$username'";

        $ris=mysqli_query($conn, $query) or die(mysqli_error($conn));
        

        if(mysqli_num_rows($ris)>0){
            $riga=mysqli_fetch_assoc($ris);

            if (password_verify($_POST["password"], $riga["pswrd"])) {

                //imposto la sessione
                $_SESSION["username"]=$riga["username"];
                $_SESSION["user_id"]=$riga["id"];

                //vado alla home
                header("Location: home.php");
                mysqli_free_result($ris);
                mysqli_close($conn);
                exit;
            }

        }
        $errore="Username o password errate";

    } else if (isset($_POST["username"]) || isset($_POST["password"])) {
        $errore = "Inserisci username e password";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vujahday+Script&display=swap" rel="stylesheet">
    <script src="login_script.js" defer></script>
    <link rel="stylesheet" href="login_style.css">
    <title>Accedi</title>
</head>
<body>
    
<nav>

<div id="menu_bar">

    <em class="logo">CARLA<br>Trasporti</em>
    

</div>
<div class="striscia">
    <div id="riga1"></div>
    <div id="riga2"></div>
    <div id="riga3"></div>
    <div id="riga4"></div>
    <div id="riga5"></div>
</div> 
</nav>

    <section id="sezione_login">
        <div id="sfocatura">
        <h1 id="accedi_testo">Accedi a Carla Trasporti</h1>

        <?php
        if (isset($errore)) {
            echo "<p class='error'>$errore</p>";
            }
        ?>

        <form name="login" method="post">
            <p>
                <label class="label_input">Username<input type="text" name="username"></label>          
            </p>
            <p>
                <label class="label_input">Password<input type="password" name="password"></label>
            </p>
            <p>
                <input type="submit" value="Accedi">
            </p>
        </form>

        <div id="messaggio_finale">
            <p>Non hai ancora un account?<br><a class="link" href="signup.php">Iscriviti</a></p>
        </div>
        </div>
    </section>  

</body>
</html>