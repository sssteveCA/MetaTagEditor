
//display the values of Page object 
function displayPageValues(page){
    var container = document.getElementById('mte_page_values');
    container.innerHTML = '';
    if(container){
        //#mte_page_values exists
        var arrLabels = {
            "page_id" : "ID della pagina",
            "canonical_url" : "URL canonico",
            "title" : "Titolo della pagina",
            "meta_description" : "Descrizione meta",
            "robots" : "Robots"
        };
        var arrValues = {
            "page_id" : page.page_id,
            "canonical_url" : page.canonical_url,
            "title" : page.title,
            "meta_description" : page.meta_description,
            "robots" : page.robots
        };

        for(var key in arrValues){
            let div = document.createElement("div");
                div.setAttribute('id','mte_div_'+key);
                    let string = arrLabels[key]+": "+arrValues[key];
                    let text = document.createTextNode(string);
                div.appendChild(text);
            container.appendChild(div);
        }
    }
    else
        console.error("L'elemento richiesto non è stato trovato");
}