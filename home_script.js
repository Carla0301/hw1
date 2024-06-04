//mostra una seconda immagine di ciascuna localita' quando si passa sopra con il mouse
//torna l'immagine di prima una volta che ci si sposta con il mouse

const mappaViaggiOver={
    venezia: "https://a.cdn-hotels.com/gdcs/production126/d943/56a06cca-b264-46e6-86eb-d518efd2198f.jpg?impolicy=fcrop&w=800&h=533&q=medium",
    roma: "https://tourismmedia.italia.it/is/image/mitur/1600X1000_8_cose_imperdibili_natale_di_roma_hero?wid=1080&hei=660&fit=constrain,1&fmt=webp",
    palermo:"https://a.cdn-hotels.com/gdcs/production63/d1896/79f77da4-aa4b-4915-a74d-6c8f9b652694.jpg",
    trento:"https://scorcidimondo.it/wp-content/uploads/2021/10/PSX_20211026_175601-scaled.jpg"
}

const mappaViaggiOut={
    venezia: "https://experience.europlan.it/wp-content/uploads/2019/04/venezia-classica1920x1080.jpg",
    roma: "https://media.istockphoto.com/id/539115110/it/foto/colosseo-di-roma-e-sole-mattutino-italia.jpg?s=612x612&w=0&k=20&c=ngbBMGVEkJxHsnt4SN7ZuncEnRenq2tFI8V0-zCg4pw=",
    palermo:"https://civitavecchia.portmobility.it/sites/default/files/palermo_-_la_fontana_pretoria.jpg",
    trento:"https://www.hotelmontana.it/wp-content/uploads/2019/04/Trento.jpg"
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




//api meteo


// function chiudiMeteo(event){
//     if(event.key==="Escape"){
//         const blocco_risultato=document.querySelector("#results_meteo");
//         blocco_risultato.innerHTML="";
//         // const testo_barra_input=document.querySelector("#content");
//         // console.log(testo_barra_input)
//         // testo_barra_input.innerHTML="";
//         //non funonzia
//     }
// }

//per chiudere i risultati delle api
function chiudiRisultati(event){
    
        const blocco_risultato=event.currentTarget;
        // console.log(event.currentTarget)
        blocco_risultato.innerHTML="";
    
}

function onJson_meteo(json){

    console.log("richiesta ricevuta!");
    const risultato=json;
    console.log(risultato);


    for(let item of risultato.days){
        const previsione_giornata=document.createElement("p");
        previsione_giornata.textContent=item.datetime+" temperatura: "+item.temp+". "+item.description;
        blocco_risultato_meteo.appendChild(previsione_giornata);
        
    }

    const messaggio_chiusura=document.createElement("p");
    messaggio_chiusura.textContent="Fai doppio click per cancellare le previsioni";
    blocco_risultato_meteo.appendChild(messaggio_chiusura);
}


function onResponse(response){
    return response.json();
}


function search_meteo(event){

    event.preventDefault();

    //seleziono il contenuto di testo inserito
    const contenuto=document.querySelector("#content").value;

    //verifico che sia stato inserito effettivamente del testo
    if(contenuto){
        const localita = encodeURIComponent(contenuto);
        meteo_request=meteo_endpoint+localita+"/?key="+key_meteo+"&lang=it"+"&unitGroup=metric";
        fetch(meteo_request).then(onResponse).then(onJson_meteo);
    }else alert("inserisci una località");
}


const form_meteo=document.querySelector("#search_content");
form_meteo.addEventListener("submit", search_meteo);


const key_meteo="98PN893CB5TC5MNASCALHZULR"
const meteo_endpoint="https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/"


const blocco_risultato_meteo=document.querySelector("#results_meteo");

blocco_risultato_meteo.addEventListener('dblclick', chiudiRisultati);


//spotify con server
function jsonSpotify(json) {

    console.log(json);
    const container = document.getElementById('results_spotify');
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

        const img = document.createElement('img');
        img.src = json.tracks.items[track].album.images[0].url;
        trackInfo.appendChild(img);


        const infoContainer = document.createElement('div');
        trackInfo.appendChild(infoContainer);

        const info = document.createElement('div');
        infoContainer.appendChild(info);

        const name = document.createElement('strong');
        name.innerHTML = json.tracks.items[track].name+"<br>";
        info.appendChild(name);

        const artist = document.createElement('a');
        artist.innerHTML = json.tracks.items[track].artists[0].name;
        info.appendChild(artist);


        // info sulle canzoni quando selected
        const canzoneInfo= document.createElement('div');
        const popularity = document.createElement('p');
        popularity.innerHTML = 'Popolarità: '+json.tracks.items[track].popularity;
        canzoneInfo.appendChild(popularity);
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







