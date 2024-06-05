//mostra una seconda immagine di ciascuna localita' quando si passa sopra con il mouse
//torna l'immagine di prima una volta che ci si sposta con il mouse

const mappaViaggiOver={
    venezia: "immagini/venezia2.webp",
    roma: "immagini/roma2.webp",
    palermo:"immagini/palermo2.avif",
    trento:"immagini/trento2.jpg"
}

const mappaViaggiOut={
    venezia: "immagini/venezia1.jpg",
    roma: "immagini/roma1.jpg",
    palermo:"immagini/palermo1.jpg",
    trento:"immagini/trento1.jpg"
}



function onMouseoverViaggio(event){

    const image=event.currentTarget;
    image.src=mappaViaggiOver[image.parentNode.dataset.citta];
    image.removeEventListener("mouseover", onMouseoverViaggio);
    image.addEventListener("mouseout", onMouseoutViaggio);
}

function onMouseoutViaggio(event){

    const image=event.currentTarget;
    image.src=mappaViaggiOut[image.parentNode.dataset.citta];
    image.removeEventListener("mouseout", onMouseoutViaggio);
    image.addEventListener("mouseover", onMouseoverViaggio);

}

const img_venezia=document.querySelector("#img_venezia");
img_venezia.addEventListener("mouseover", onMouseoverViaggio);

const img_roma=document.querySelector("#img_roma");
img_roma.addEventListener("mouseover", onMouseoverViaggio);

const img_palermo=document.querySelector("#img_palermo");
img_palermo.addEventListener("mouseover", onMouseoverViaggio);

const img_trento=document.querySelector("#img_trento");
img_trento.addEventListener("mouseover", onMouseoverViaggio);




//menu a tendina su Servizi a bordo e Contatti

function menuTendina(event){

    const elemento=event.currentTarget;


    const tendina=elemento.parentNode.querySelector(".hidden");
    tendina.classList.remove("hidden");
    tendina.classList.add("menu_tendina");
    

    elemento.removeEventListener("mouseover", menuTendina);
    elemento.addEventListener("mouseout", rimuoviTendina);
}

function rimuoviTendina(event){

    const elemento=event.currentTarget;
    const tendina=elemento.parentNode.querySelector(".menu_tendina");
    
    tendina.classList.remove("menu_tendina");
    tendina.classList.add("hidden");

    elemento.removeEventListener("mouseout", rimuoviTendina);
    elemento.addEventListener("mouseover", menuTendina);
}

const servizi=document.querySelector("#menu_tendina_servizi a");
servizi.addEventListener("mouseover", menuTendina);

const contatti=document.querySelector("#contatti a");
contatti.addEventListener("mouseover", menuTendina);



function onClickScopriDiPiu(event){
    
    const elemento=event.currentTarget;
    const info=document.createElement("p");

    const blocco_viaggio=elemento.parentNode;

    info.textContent=blocco_viaggio.dataset.abitanti + blocco_viaggio.dataset.turismo + blocco_viaggio.dataset.grandezza;
    

    
    elemento.classList.remove("bottoni_viaggi")
    elemento.classList.add("hidden");

    
    blocco_viaggio.appendChild(info);
}


const bottone_venezia=document.querySelector("#bottone_venezia");
bottone_venezia.addEventListener("click", onClickScopriDiPiu);

const bottone_palermo=document.querySelector("#bottone_palermo");
bottone_palermo.addEventListener("click", onClickScopriDiPiu);

const bottone_roma=document.querySelector("#bottone_roma");
bottone_roma.addEventListener("click", onClickScopriDiPiu);

const bottone_trento=document.querySelector("#bottone_trento");
bottone_trento.addEventListener("click", onClickScopriDiPiu);



//////////////////////////////////////////

//per chiudere i risultati delle api
function chiudiRisultati(event){
    
    const blocco_risultato=event.currentTarget;
    blocco_risultato.innerHTML="";

}


function onJsonMeteo(json){

    console.log("richiesta ricevuta!");
    const risultato=json;
    console.log(risultato);



    if(risultato.days.length>7){

        for(let i=0; i<7;i++){
            const previsione_giornata=document.createElement("div");
            previsione_giornata.textContent="Nella giornata del "+risultato.days[i].datetime+" ci sarà una temperatura di "+risultato.days[i].temp+" °C. "+risultato.days[i].description;
            blocco_risultato_meteo.appendChild(previsione_giornata);
            previsione_giornata.classList.add("previsioni");
        }
    } else{
        for(let item of risultato.days){
        const previsione_giornata=document.createElement("div");
        previsione_giornata.textContent="Nella giornata del "+item.datetime+" ci sarà una temperatura di "+item.temp+" °C. "+item.description;
        blocco_risultato_meteo.appendChild(previsione_giornata);
        previsione_giornata.classList.add("previsioni");
        
        }
    }

    const messaggio_chiusura=document.createElement("div");
    messaggio_chiusura.textContent="Fai doppio click per cancellare le previsioni";
    blocco_risultato_meteo.appendChild(messaggio_chiusura);
    messaggio_chiusura.classList.add("previsioni");
}


function onResponseMeteo(response){
    console.log(response)
    return response.json();
}


function searchMeteo(event){
    event.preventDefault();

    blocco_risultato_meteo.innerHTML="";

    //seleziono il contenuto di testo inserito
    const contenuto=document.querySelector("#input_meteo").value;

    //verifico che sia stato inserito effettivamente del testo
    if(contenuto){
        const form_data = new FormData();
        form_data.append('localita', encodeURIComponent(contenuto));
        fetch("fetch_meteo.php", {method: 'post', body: form_data}).then(onResponseMeteo).then(onJsonMeteo);

    } else{
        const errore=document.createElement("p");
        errore.classList.add("errore");
        errore.textContent="Compila tutti i campi";
        blocco_risultato_meteo.appendChild(errore);
    }
}






const form_meteo=document.querySelector("#form_meteo");
form_meteo.addEventListener("submit", searchMeteo);

const blocco_risultato_meteo=document.querySelector("#results_meteo");
blocco_risultato_meteo.addEventListener('dblclick', chiudiRisultati);



///////////////////////////////////////////


//spotify con server
function jsonSpotify(json) {

    console.log(json);
    const container = document.querySelector("#results_spotify");
    container.innerHTML = '';
    if (!json.tracks.items.length) {
        console.log("no results") 
        return;}
    
    for (let track in json.tracks.items) {
        const card = document.createElement('div');
        card.dataset.id = json.tracks.items[track].id;
        card.dataset.title = json.tracks.items[track].name;
        card.dataset.artist = json.tracks.items[track].artists[0].name;
        card.dataset.duration = json.tracks.items[track].duration_ms;
        card.dataset.popularity = json.tracks.items[track].popularity;
        card.dataset.image = json.tracks.items[track].album.images[0].url;
        card.classList.add("blocchi_spotify");
        

        const trackInfo = document.createElement('div');
        card.appendChild(trackInfo);
        trackInfo.classList.add('trackInfo');



        const img = document.createElement('img');
        img.src = json.tracks.items[track].album.images[0].url;
        trackInfo.appendChild(img);



        const infoContainer = document.createElement('div');
        trackInfo.appendChild(infoContainer);
        infoContainer.classList.add("infoContainer");


        const info = document.createElement('div');
        infoContainer.appendChild(info);
        info.classList.add("info");


        const name = document.createElement('strong');
        name.innerHTML = json.tracks.items[track].name+"<br>";
        info.appendChild(name);

        const artist = document.createElement('a');
        artist.innerHTML = json.tracks.items[track].artists[0].name;
        info.appendChild(artist);


        // info sulle canzoni 
        const canzoneInfo= document.createElement('div');

        const date = document.createElement('p');
        date.innerHTML = 'Data di pubblicazione: '+json.tracks.items[track].album.release_date;
        canzoneInfo.appendChild(date);

        const duration = document.createElement('p');
        const durationMs = json.tracks.items[track].duration_ms;
        const durationMin  = durationMs / 1000 / 60;
        const intPart = parseInt(durationMin, 10);
        const decimalPart = durationMin - intPart;
        const decimalPartRounded =  Math.floor(decimalPart * 100) / 100;
        const trackSec = parseInt((decimalPartRounded * 60), 10);
        duration.innerHTML = "Durata: "+intPart+" min "+trackSec+" sec";

        canzoneInfo.appendChild(duration);
        card.appendChild(canzoneInfo);



        container.appendChild(card);
        }
}

function search_music(event){
    const form_data = new FormData(document.querySelector("#search_music"));
    fetch("fetch_spotify.php?q="+encodeURIComponent(form_data.get('input_musica'))).then(searchResponse).then(jsonSpotify);
    event.preventDefault();
}

function searchResponse(response){
    console.log(response);
    return response.json();
}

document.querySelector("#search_music").addEventListener("submit", search_music);



//////////////////////////////////////////////////////
//fetch viaggi


function onRisposta(response) {

    console.log(response);
    return response.json().then(databaseResponse); 
  }
  
  function onError(error) { 
    console.log("Errore");
  }
  
  function databaseResponse(json) {
    if (!json.ok) {
        onError();
        return null;
    }
  }


function aggiungiAlCarrello(event){
    const viaggio=event.currentTarget.parentNode;

    console.log("mi hai cliccato!!!");
    //creo il form da inviare al server
    const form_carrello= new FormData();
    form_carrello.append('id_viaggio', viaggio.dataset.id);
    form_carrello.append('partenza', viaggio.dataset.partenza);
    form_carrello.append('destinazione', viaggio.dataset.destinazione);
    form_carrello.append('ora_partenza', viaggio.dataset.orario_partenza);
    form_carrello.append('ora_arrivo', viaggio.dataset.orario_arrivo);
    form_carrello.append('costo', viaggio.dataset.prezzo);
    fetch("fetch_aggiungi_al_carrello.php", {method: 'post', body: form_carrello}).then(onRisposta, onError);
    event.stopPropagation();
}




function onJsonViaggi(json){

    console.log("faccio la fetch");
    console.log(json);
    const risultato=json;

    if(risultato.ok==="false"){
        const titolo_noresults=document.createElement("h1");
        titolo_noresults.textContent="Non ci sono viaggi con quei parametri!";
        titolo_noresults.classList.add("errore");
        blocco_risultati_viaggi.appendChild(titolo_noresults);
        return;
    }else {

        const titolo_risultati=document.createElement("h1");
        blocco_risultati_viaggi.appendChild(titolo_risultati);

    for(let item of risultato){

        const blocco_viaggio=document.createElement("div");

        const partenza_destinazione=document.createElement("div");
        partenza_destinazione.textContent=item.partenza+" - "+item.destinazione;
        const orario=document.createElement("div");
        orario.textContent="Orario: "+item.ora_partenza+" - "+item.ora_arrivo;
        const prezzo=document.createElement("div");
        prezzo.textContent="Prezzo: "+item.costo+" euro";


        blocco_viaggio.appendChild(partenza_destinazione);
        blocco_viaggio.appendChild(orario);
        blocco_viaggio.appendChild(prezzo);
        blocco_viaggio.classList.add("blocco_viaggio");

        //mi serviranno poi nella aggiungiAlCarrello per fare poi il form ed inserire i dati giusti nel database
        blocco_viaggio.dataset.id=item.id;
        blocco_viaggio.dataset.partenza=item.partenza;
        blocco_viaggio.dataset.destinazione=item.destinazione;
        blocco_viaggio.dataset.orario_partenza=item.ora_partenza;
        blocco_viaggio.dataset.orario_arrivo=item.ora_arrivo;
        blocco_viaggio.dataset.prezzo=item.costo;



        const bottone=document.createElement("button");
        bottone.textContent="Aggiungi questo viaggio al tuo carrello";
        bottone.addEventListener("click", aggiungiAlCarrello);
        blocco_viaggio.appendChild(bottone);
        bottone.classList.add("bottone");


        blocco_risultati_viaggi.appendChild(blocco_viaggio);
    }
    }

}

function onResponse(response) {
    console.log(response);
    return response.json();
}

function fetchViaggi(event){

    blocco_risultati_viaggi.innerHTML="";

    event.preventDefault();

    if(partenza.value.length!=0 && destinazione.value.length!=0){
    
    console.log(partenza.value.length)

    const form_data = new FormData();
    form_data.append('partenza', partenza.value);
    form_data.append('destinazione', destinazione.value);

    fetch("fetch_viaggi.php", {method: 'post', body: form_data}).then(onResponse).then(onJsonViaggi);
    } else{
        const errore=document.createElement("p");
        errore.classList.add("errore");
        errore.textContent="Compila tutti i campi";
        blocco_risultati_viaggi.appendChild(errore);
    }
}

const form_viaggi=document.querySelector("#form_viaggio");
form_viaggi.addEventListener("submit", fetchViaggi);
const partenza=document.querySelector("#input_partenza");
const destinazione=document.querySelector("#input_destinazione");
const blocco_risultati_viaggi=document.querySelector("#risultati_viaggi");