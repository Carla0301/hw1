<?php

    require_once "auth.php";

    if(isSession()){
        header("Location: home.php");
        exit;
    }

    if(!empty($_POST["nome"]) && !empty($_POST["cognome"]) && !empty($_POST["username"]) && !empty($_POST["email"]) &&
     !empty($_POST["password"]) && !empty($_POST["conferma_password"]) && !empty($_POST["condizioni"])){

        $errori=array(); //creo un array dove mettere eventuali errori

        //connessione al db
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        //faccio i controlli sullo username        
        if(!preg_match('/^[a-zA-Z0-9]{1,15}$/', $_POST["username"])){
            $errori[]="Username non valido";

        } else{

            $username=mysqli_real_escape_string($conn, $_POST["username"]);

            $query="SELECT* FROM users WHERE username= '".$username."'";

            $ris=mysqli_query($conn, $query) or die(mysqli_error($conn));

            if(mysqli_num_rows($ris) > 0){
                $errori[]="Username gia' utilizzato";
            }
        }

        //faccio i controlli sulla password
        if(strlen($_POST["password"])<8){
            $errori[]="Caratteri password insufficienti";
        }

        //faccio i controlli sulla conferma password
        if((strcmp($_POST["password"], $_POST["conferma_password"]))!=0){
            $errori[]="Le password non coincidono";
        }

        //faccio i controlli sull'email
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $errori[]="L'email non e' valida";
        } else{

            $email=mysqli_real_escape_string($conn, $_POST["email"]);

            $query="SELECT* FROM users WHERE email='".$email."'";

            $ris=mysqli_query($conn, $query);

            if(mysqli_num_rows($ris)>0){
                $errori[]="Email gia' utilizzata";
            }
        }


        //se non ci sono errori, registro il nuovo utente
        if(count($errori)==0){
            $nome=mysqli_real_escape_string($conn, $_POST["nome"]);
            $cognome=mysqli_real_escape_string($conn, $_POST["cognome"]);
            $password=mysqli_real_escape_string($conn, $_POST["password"]);
            $hash_password=password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users(username, pswrd, nome, cognome, email) VALUES('$username', '$hash_password', '$nome', '$cognome', '$email')";


            if (mysqli_query($conn, $query)) {

                //se va tutto bene, setto la sessione
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["user_id"] = mysqli_insert_id($conn);

                mysqli_close($conn);

                header("Location: home.php");
                exit;

            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
        
    } else if(isset($_POST["username"])){
        $errori[]="Riempi tutti i campi";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vujahday+Script&display=swap" rel="stylesheet">
    <script src="signup_script.js" defer></script>
    <link rel="stylesheet" href="signup_style.css">
    <title>Iscriviti</title>
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

    <section id="sezione_signup">
    <div id="sfocatura">

        <h1 id="signup_testo">Registrati</h1>

        <form name="signup" method="post">

        <div>
        <label class="label_input">Inserisci il nome<input type="text" name="nome"></label>
        </div>

        <div>
        <label class="label_input">Inserisci il cognome<input type="text" name="cognome"></label>
        </div>

        <div>
        <label class="label_input">Inserisci lo username<input type="text" name="username"></label>
        </div>

        <div>
        <label class="label_input">Inserisci l'email<input type="text" name="email"></label>
        </div>

        <div>
        <label class="label_input">Inserisci la password<input type="password" name="password"></label>
        </div>

        <div>
        <label class="label_input">Conferma la password<input type="password" name="conferma_password"></label>
        </div>

        <div>
        <label class="label_input">Accetta termini e condizioni di Carla Trasporti<input type="checkbox" name="condizioni" value="1"></label>
        </div>

        <?php
            if(isset($errori)){
                foreach($errori as $err){
                    echo "<span class='errore'>".$err."</span>";
                }
            }
        ?>

        <div>
        <input type="submit" value="Registrati">
        </div>

        </form>
        <div id="messaggio_finale">
        <p>Hai un account? <a class="link" href="login.php">Accedi</a></p>
        </div>
    </section>

</body>
</html>