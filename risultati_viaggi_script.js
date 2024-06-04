
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

//mi faccio passare i dati come variabili $_POST e li inserisco in un formData che uso per fare la fetch a fetch_sogn (database)

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
    const blocco_ris=document.querySelector("#risultati");

    
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


        blocco_ris.appendChild(blocco_viaggio);
    }

}

function onResponse(response) {
    console.log(response);
    if (!response.ok) {
        return null
    };
    return response.json();
}

function fetchViaggi(){

    console.log("invio il form")
    const partenza=document.querySelector("#partenza").textContent;
    const destinazione=document.querySelector("#destinazione").textContent;


    const form_data = new FormData();
    form_data.append('partenza', partenza);
    form_data.append('destinazione', destinazione);

    fetch("fetch_viaggi.php", {method: 'post', body: form_data}).then(onResponse).then(onJsonViaggi);

}

window.addEventListener("pageshow", fetchViaggi);
