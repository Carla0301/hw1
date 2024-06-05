
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


function rimuoviDalCarrello(event){
    console.log("don't lemme go-");
    const viaggio=event.currentTarget.parentNode;

    //per rimuovere il biglietto dalla tabella carrelli del database
    const form_carrello= new FormData();
    form_carrello.append('id_viaggio', viaggio.dataset.id);

    console.log(viaggio.dataset.id)

    fetch("rimuovi_dal_carrello.php", {method: 'post', body: form_carrello}).then(onResponse, onError);
    event.stopPropagation();

    //per rimuovere il blocco dalla pagina
    const blocco_viaggi=viaggio.parentNode;
    blocco_viaggi.removeChild(viaggio);
}



function onJsonCarrello(json){
    console.log(json);
    const risultato=json;
    const blocco_ris=document.querySelector("#blocco_biglietti");



    if(risultato.ok==="false"){
      const titolo_noresults=document.createElement("h1");
      titolo_noresults.textContent="Non hai ancora aggiunto viaggi!";
      titolo_noresults.classList.add("titolo_viaggi");
      blocco_ris.appendChild(titolo_noresults);
      return;
    }else {
      const titolo_ris=document.createElement("h1");
      titolo_ris.textContent="Ecco il tuo carrello";
      titolo_ris.classList.add("titolo_viaggi");
      blocco_ris.appendChild(titolo_ris);
    
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

        //mi servira' per rimuovere poi quel viaggio dal carrello dell'utente (uso userid e id viaggio)
        blocco_viaggio.dataset.id=item.id_viaggio;

        console.log(blocco_viaggio.dataset.id);

        const bottone=document.createElement("button");
        bottone.textContent="Rimuovi questo biglietto dal carrello";
        bottone.addEventListener("click", rimuoviDalCarrello);
        blocco_viaggio.appendChild(bottone);
        bottone.classList.add("bottone");


        blocco_ris.appendChild(blocco_viaggio);
    }
  }
}

function onResponse(response) {

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

  function onRisposta(response){
    return response.json();
  }

function fetchCarrello(){

    fetch("fetch_carrello.php", {method: 'post'}).then(onRisposta).then(onJsonCarrello);

}



window.addEventListener("pageshow", fetchCarrello);