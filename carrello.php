
<?php
    require_once "auth.php";

    if(!$userid=isSession()){
        header("Location: login.php");
        exit;
    }

    
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vujahday+Script&display=swap" rel="stylesheet">
    <script src="carrello_script.js" defer="true"></script>
    <link rel="stylesheet" href="carrello_style.css">
    <title>Carrello</title>
</head>
<body>

<nav>

<div id="nav_div">
    
    <em class="logo">CARLA<br>Trasporti</em>
    
    <div id="div_flex_items1">
    <a class="flex_item1" href="home.php" >Home</a>
    <a class="flex_item1" href="login.php">Login</a>
    <a class="flex_item1" href="signup.php">Registrati</a>
    <a class="flex_item1_da_tenere" href="logout.php">Logout</a>
    <a class="flex_item1" href="https://github.com/Carla0301" >CARLA</a>
    <div id="contatti">
            <a class="flex_item1" href="">Contatti</a>
            <div class="hidden">
                Email: cmasca02@gmail.com<br>
                Github: Carla0301
            
            </div>
    </div>
    <div id="menu_tendina_servizi">
        <a class="flex_item1" href="">Servizi a bordo</a>
        <div class="hidden">
            Wifi gratuito<br>
            Eco friendly<br>
            Toilette<br>
            Cappelliera<br>
            Prese elettriche<br>
            Sedili reclinabili<br>

        </div>
    </div>
    <a class="flex_item1">IT</a>
    </div>
    

    </div>


    <div class="striscia">
        <div id="riga1"></div>
        <div id="riga2"></div>
        <div id="riga3"></div>
        <div id="riga4"></div>
        <div id="riga5"></div>
    </div> 

</nav>

    <div id="blocco_biglietti"></div>
    <p class="testo_redirect">Torna alla <a class="link_redirect" href="home.php">home</a></p>

</body>
</html>