<?php

    //controllo se l'utente e' loggato
    require_once "auth.php";

    if(!$userid=isSession()){
        header("Location: login.php");
        exit;
    }

    

    $conn=mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die(mysqli_error($conn));

    $userid = mysqli_real_escape_string($conn, $userid);
    $query = "SELECT * FROM users WHERE id ='$userid'";
    $ris = mysqli_query($conn, $query);

    //raccolgo i dati relativi all'utente dal database per scrivere benvenuto utente
    $riga_user = mysqli_fetch_assoc($ris);  


    // //codice php per il form viaggi
    // //controllo se i campi sono stati compilati
    // if(!empty($_POST["partenza"]) && !empty($_POST["destinazione"])){

    //     //non apro la connessione, perche' l'ho lasciata aperta nelle righe piu' su
    //     $partenza=mysqli_real_escape_string($conn, $_POST["partenza"]);
    //     $destinazione=mysqli_real_escape_string($conn, $_POST["destinazione"]);

    //     $query="SELECT* FROM viaggi WHERE partenza= '$partenza' AND destinazione='$destinazione'";

    //     $ris=mysqli_query($conn, $query) or die(mysqli_error($conn));

    //     //se ci sono risultati mando alla pagina dei risultati
    //     if(mysqli_num_rows($ris)>0){
            
    //         header("Location: risultati_viaggi.php");
    //         mysqli_free_result($ris);
    //         mysqli_close($conn);
    //         exit;

    //     } else $errore="Non ci sono viaggi con i parametri selezionati";

    // } else if (isset($_POST["partenza"]) || isset($_POST["destinazione"])){
    //     $errore="Tutti i campi devono essere compilati";
    // }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vujahday+Script&display=swap" rel="stylesheet">
    <script src="home_script.js" defer></script>
    <link rel="stylesheet" href="home_style.css">
</head>

<body>
    <article>
    <nav>
<div id="nav_div">
            
        <em class="logo">CARLA<br>Trasporti</em>

        <div id="div_flex_items1">
        <a class="flex_item1" href="home.php" >Home</a>
        <a class="flex_item1" href="login.php">Login</a>
        <a class="flex_item1" href="signup.php">Registrati</a>
        <a class="flex_item1" href="logout.php">Logout</a>
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
        <a class="flex_item1" href="carrello.php">Carrello</a>
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
    
    
    <header>
        <div id="overlay">
        <p id="benvenuto">Benvenuto <?php echo $riga_user['username']?></p>

        </div>
    </header>


    <section id="viaggia_con_noi">
            <p id="titolo_viaggia_con_noi">
                <strong>VIAGGIA CON NOI</strong><br>
                Il miglior comfort al miglior prezzo
            </p>
            
            <p id="seleziona">
                Seleziona la partenza, la destinazione e prenota il tuo viaggio
            </p>
        

        <div id="ricerca_viaggi">
            <form id="form_viaggio" method="post">
                <div>
                <input class="input_viaggi" id="input_partenza" type="text" name="partenza" placeholder="PARTENZA">
                <input class="input_viaggi" id="input_destinazione" type="text" name="destinazione" placeholder="DESTINAZIONE">
                <input class="submit" type="reset" name="reset" value="RICOMINCIA">
                <input class="submit" type="submit" name="submit" value="TROVA">
                </div>

            </form>
            <div id="risultati_viaggi"></div>
        </div>

   
        <div id="comunicato">
            <h1>COMUNICATO</h1>
            <p>I biglietti relativi ai servizi regionali (TPL) non sono acquistabili online, contatta le nostre biglietterie.<br>
                Prima di procedere all'acquisto dei biglietti, leggere le condizioni d'acquisto.</p>
    
    </div>

    </section>

    <section id="viaggi">

        <h1>I nostri viaggi</h1>

        
    </section>
 

    <section id="flex_img_viaggi">

        <div id="blocco_venezia" class="items_viaggi" 
        data-citta="venezia"
        data-abitanti="250.073 di abitanti, " 
        data-turismo="23 milioni di turisti all'anno, "
        data-grandezza="414,6 km² di estensione">
            <img id="img_venezia" src="https://experience.europlan.it/wp-content/uploads/2019/04/venezia-classica1920x1080.jpg" alt="foto_canale">
            <h1>VENEZIA</h1>
            <p>
                Non perdere tempo, cogli al balzo l'occasione di visitare Venezia e i suoi canali.<br>
                Partenze tutti i giorni dalla Sicilia, da Roma e da Bologna. 
            </p>
            <button id="bottone_venezia" class="bottoni_viaggi">Clicca qui per saperne di più</button>
        </div>

        <div id="blocco_roma" class="items_viaggi"
        data-citta="roma"
        data-abitanti="2.751.125 di abitanti, " 
        data-turismo="49 milioni di turisti all'anno, "
        data-grandezza="1285 km² di estensione">
            <img id="img_roma" src="https://media.istockphoto.com/id/539115110/it/foto/colosseo-di-roma-e-sole-mattutino-italia.jpg?s=612x612&w=0&k=20&c=ngbBMGVEkJxHsnt4SN7ZuncEnRenq2tFI8V0-zCg4pw=" alt="foto_colosseo">
            <h1>ROMA</h1>
            <p>
                Cogli l'occasione per andare a Roma in bus con noi e scoprire tutti i segreti della nostra bellissima capitale.<br>
                Scopri tutti i nostri collegamenti per Roma e prenota.
            </p>
            <button id="bottone_roma" class="bottoni_viaggi">Clicca qui per saperne di più</button>
        </div>

        <div id="blocco_palermo" class="items_viaggi"
        data-citta="palermo"
        data-abitanti="673.735 di abitanti, " 
        data-turismo="722.288 di turisti all'anno, "
        data-grandezza="158,9 km² di estensione">
            <img id="img_palermo" src="https://civitavecchia.portmobility.it/sites/default/files/palermo_-_la_fontana_pretoria.jpg" alt="foto_fontanta">
            <h1>PALERMO</h1>
            <p>
                Palermo è una delle città più visitate della Sicilia, un luogo ricco di storia e di arte, ma anche di tradizioni.<br>
                Pianifica il tuo viaggio in autobus con noi, partenze tutti i giorni dalla Sicilia, da Roma e da Bologna. 
            </p>
            <button id="bottone_palermo" class="bottoni_viaggi">Clicca qui per saperne di più</button>
        </div>

        <div id="blocco_trento" class="items_viaggi"
        data-citta="trento"
        data-abitanti="117.417 di abitanti, " 
        data-turismo="5,7 milioni di turisti all'anno, "
        data-grandezza="157,9 km² di estensione">
            <img id="img_trento" src="https://www.hotelmontana.it/wp-content/uploads/2019/04/Trento.jpg" alt="foto_montagne">
            <h1>TRENTO</h1>
            <p>
                Lasciati sedurre dal Trentino-Alto Adige e da una delle zone più belle del nord Italia.<br>
                Prenota subito il tuo viaggio.
            </p>
            <button id="bottone_trento" class="bottoni_viaggi">Clicca qui per saperne di più</button>
        </div>
        
    </section>


    
    <section class="sezione_api">
    <!-- form api meteo -->
    <h1 class="titolo_api">Controlla il meteo della tua destinazione</h1>


    <form class="form_api" id="form_meteo" name ="form_meteo">
			
        <div>
        <label class="label_api">Inserisci la città: <input class="input_api" id="input_meteo" type="text" name = "input_meteo"></label>	
        </div>
        <input class="submit" type='submit'>
                
    </form>

    <div id="results_meteo">
    </div>
    </section>




    
    <section class="sezione_api">

        <h1 class="titolo_api">Scegli la musica giusta per il tuo viaggio</h1>
        <p class="testo_api">Hai scelto la destinazione e hai controllato le previsioni meteo, non ti resta che scegliere i brani da ascoltare durante il tuo viaggio</p>

       
        <form class="form_api" id="search_music" name="search_music">


            <label class="label_api">Cerca: <input class="input_api" type="text" name="input_musica"></label>

            <!-- <select name = 'tipo' id='tipo'>
				<option value='album'>Album</option>
				<option value='artist'>Artista</option>
				<option value='track'>Brano</option>
			</select> -->

            <input class="submit" name="submit" type="submit">

        </form>
    
        <div id="results_spotify">
        </div>
    </section>




    <section id="flex_servizi">

        <div class="item_servizi">
            <img src="https://img.freepik.com/premium-vector/wi-fi-wireless-technology-symbol-wifi-pictogram_532867-431.jpg" alt="simbolo_wifi">
            <p>WIFI GRATUITO</p>
        </div>

        <div class="item_servizi">
            <img src="https://static.vecteezy.com/ti/vettori-gratis/p3/22245958-pianeta-terra-icona-con-foglia-proteggere-esso-salva-il-mondo-eco-friendly-simbolo-proteggere-il-ambiente-vettoriale.jpg" alt="simbolo_eco">
            <p>ECO FRIENDLY</p>
        </div>

        <div class="item_servizi">
            <img src="https://www.adesivocrea.it/images/virtuemart/product/al0018.jpg" alt="simbolo_toilette">
            <p>TOILETTE</p>
        </div>

        <div class="item_servizi">
            <img src="https://img.freepik.com/premium-vector/briefcase-icon-suitcase-symbol_260216-369.jpg" alt="simbolo_cappelliera">
            <p>CAPPELLIERA</p>
        </div>

        <div class="item_servizi">
            <img src="https://img.freepik.com/premium-vector/electric-plug-power-cabel-icon-symbol-from-blue-icon-set_840036-51.jpg" alt="simbolo_presa_elettrica">
            <p>PRESE ELETTRICHE</p>
        </div>

        <div class="item_servizi">
            <img src="https://static.vecteezy.com/ti/vettori-gratis/p3/15485060-poltrona-pixel-perfetto-pendenza-lineare-ui-icona-hotel-camera-disposizione-motel-servizio-linea-colore-utente-interfaccia-simbolo-moderno-stile-pittogramma-vettore-isolato-schema-illustrazione-vettoriale.jpg" alt="simbolo_sedile">
            <p>SEDILI RECLINABILI</p>
        </div>

    </section>

    <section id="app">
        <img src="https://www.mooneygo.it/wp-content/uploads/2022/10/App-MooneyGo-dettaglio-percorso-trasporto-pubblico_aggiornata.png" alt="simbolo_app">
        <p>LA NUOVA APP<br>
            Scarica la nostra app per rimanere sempre aggiornato
        <div id="flex_loghi">
            <div class="items_loghi">
                <img src="https://cdn.icon-icons.com/icons2/2235/PNG/512/apple_os_logo_icon_134677.png" alt="mela">
            </div>
            <div class="items_loghi">
                <img src="https://www.zeusnews.it/img/9/5/9/9/1/0/019959-470-android1.jpg" alt="android">
            </div>
        </div>
        </p>
    
    </section>

  <footer>
    <section id="footer_banda1">
        <div class="items_footer_banda1">
            <em class="logo">CARLA<br>Trasporti</em>
            <p>
            CARLA trasporti S.p.A.<br> 
            Partita IVA: 00700700700<br> 
            Via Bellissima 32/A - 90135 Canicattì, Italia<br> 
            </p>
        </div>
        <div class="items_footer_banda1">
            <h1>Informazioni Utili</h1>
            <p>
                <a class="link_footer1" href="https://www.saistrasporti.it/servizi-online">Avvisi e news</a><br>
                <a class="link_footer1" href="https://www.saistrasporti.it/infos/it/azienda">Azienda</a><br>
                <a class="link_footer1" href="https://www.saistrasporti.it/bandi-e-gare">Bandi e Gare</a><br>
                <a class="link_footer1" href="https://saistrasporti.it/Media/SaisTrasporti/Documenti/CONDIZIONI%20DI%20ACQUISTO%20U[1].pdf">Condizioni di Acquisto</a><br>
                <a class="link_footer1" href="https://saistrasporti.it/Media/SaisTrasporti/Documenti/Carta%20Mobilit%C3%A0%20SAIS%202023%20uu.pdf">Carte della Mobilità</a><br>
            </p>
        </div>
        <div class="items_footer_banda1">
            <h1>Contatti</h1>
            <p>
                cmasca02@gmail.com<br>
                1234567890 (call center)<br>
                Per info su orari degli autobus contattare le biglietterie cliccando <a href="https://www.saistrasporti.it/biglietterie">QUI</a><br>
                
            </p>
        </div>
        <div class="items_footer_banda1">
            <h1>App disponibile in</h1>
            <img src="https://cdn.icon-icons.com/icons2/2235/PNG/512/apple_os_logo_icon_134677.png" alt="mela">
            <img src="https://www.zeusnews.it/img/9/5/9/9/1/0/019959-470-android1.jpg" alt="android">
        </div>
    </section>

    <h1 id="altre_autolinee">Altre autolinee</h1>

    <section id="footer_banda2">
        <div class="items_footer_banda2">
            <a class="link_footer2" href="https://www.templetourbusagrigento.com/">TEMPLE RUN BUS</a>
        </div>
        <div class="items_footer_banda2">
            <a class="link_footer2" href="https://www.autolineegiamporcaro.it/">GIAMPORCHETTA</a>
        </div>
        <div class="items_footer_banda2">
            <a class="link_footer2" href="https://www.autolineegallo.it/">AUTOLINEE GALLINA</a>
        </div>
    </section>
    <p id="copyright">
        Copyright © 2024 CARLA Trasporti<br>
         All rights reserved <a id="privacy" href="https://www.saistrasporti.it/privacy">Privacy</a><br>
        Ogni riferimento a fatti, persone o siti realmente esistenti è puramente voluto
    </p>
  </footer>

</article>

</body>
</html>