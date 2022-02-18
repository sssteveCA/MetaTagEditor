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
let headers,method,mh;
let params, response;
let spinner;
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

//insert or update the meta page values 
function editPageMetaTags(page,url){
    if(page.notEmpty()){
        //all edit page field must be filled
        method = 'POST';
        headers = {
                'Content-Type' : 'application/x-www-form-urlencoded'
        };
        params = "pageId="+page.page_id+"&canonical_url="+page.canonical_url+"&title="+page.title+"&meta_description="+page.meta_description+"&robots="+page.robots;
        mh = new MyHttp(url,method,headers,params);
        //display spinner while waiting the response
        spinner = document.getElementById('mte_page_edit_spinner');
        spinner.classList.toggle('d-none');
        //send edit meta request
        response = mh.getResponse();
        response.then(result => {
            console.log(result);
        })
        .catch(error => {
            console.warn(error);
        })
        .finally(() => {
            spinner.classList.toggle('d-none');
        });//response.then(result => {

    }//if(page.notEmpty()){
}

//get meta tags value of particular page
function getPageMetaTags(page_id,url){
    method = 'POST';
    headers = {
            'Content-Type' : 'application/x-www-form-urlencoded'
        };
    params =  "pageId="+page_id;
    mh = new MyHttp(url,method,headers,params);
    //display spinner while waiting the response
    spinner = document.getElementById('mte_page_value_spinner');
    spinner.classList.toggle('d-none');
    response = mh.getResponse();
    response.then(result => {
        //get response from ajaxUrl
        console.log(result);
        page = new Page();
        var pageParsed = page.parseJsonString(result); //parse JSON string and set properties values
        if(pageParsed){
            //JSON string parsed successufly
            displayPageValues(page);
        }
        else
            console.log("errore => "+page.errno)
    })//response.then(result => {
    .catch(error => {
        console.warn(error);
    })
    .finally(() => {
        spinner.classList.toggle('d-none');
    });
}