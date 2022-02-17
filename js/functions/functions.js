let arrLabels = {
    "page_id" : "ID della pagina",
    "canonical_url" : "URL canonico",
    "title" : "Titolo della pagina",
    "meta_description" : "Descrizione meta",
    "robots" : "Robots"
};
let arrValues;
let container;
let divLabel, divRow, divValue;
let textLabel, textValue;

//display the values of Page object 
function displayPageValues(page){
    container = document.getElementById('mte_page_values');
    container.innerHTML = '';
    if(container){
        container.classList.add('border','border-secondary');
        //#mte_page_values exists
        arrValues = {
            "page_id" : page.page_id,
            "canonical_url" : page.canonical_url,
            "title" : page.title,
            "meta_description" : page.meta_description,
            "robots" : page.robots
        };
        for(var key in arrValues){
            //create a row inside a col class div
            divRow = document.createElement("div");
                divRow.setAttribute('id','mte_div_'+key);
                divRow.classList.add('row','mb-3');
                    //create col div that contains a description of the value
                    divLabel = document.createElement('div');
                    divLabel.classList.add('col-12','col-md-5','d-md-flex','align-items-md-center');
                    divLabel.style.fontWeight = 'bold';
                    divLabel.style.textTransform = 'uppercase';
                divRow.appendChild(divLabel);
                    //Insert the label string into divLabel
                    textLabel = document.createTextNode(arrLabels[key]);
                    divLabel.append(textLabel);
                    //create col div that contains the value that corresponds to the description
                    divValue = document.createElement('div');
                    divValue.classList.add('col-12','offset-md-1','col-md-5','d-md-flex','align-items-md-center');
                        //Insert the value into divValue
                        textValue = document.createTextNode(arrValues[key]);
                        divValue.appendChild(textValue);
                divRow.appendChild(divValue);
            container.appendChild(divRow);
        }//for(var key in arrValues){
    }
    else
        console.error("L'elemento richiesto non è stato trovato");
}