
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
            //create a row inside a col class div
            let div = document.createElement("div");
                div.setAttribute('id','mte_div_'+key);
                div.classList.add('row','mb-3');
                    //create col div that contains a description of the value
                    let divLabel = document.createElement('div');
                    divLabel.classList.add('col-12','col-md-5');
                        //Insert the label string into divLabel
                        let textLabel = document.createTextNode(arrLabels[key]);
                        divLabel.append(textLabel);
                div.appendChild(divLabel);
                    //create col div that contains the value that corresponds to the description
                    let divValue = document.createElement('div');
                    divValue.classList.add('col-12','offset-md-1','col-md-5');
                        //Insert the value into divValue
                        let textValue = document.createTextNode(arrValues[key]);
                        divValue.appendChild(textValue);
                div.appendChild(divValue);
            container.appendChild(div);
        }//for(var key in arrValues){
    }
    else
        console.error("L'elemento richiesto non è stato trovato");
}