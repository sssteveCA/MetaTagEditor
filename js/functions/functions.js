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
function editPageMetaTags(page,url,getAllUrl,deleteUrl){
    if(page.notEmpty()){
        //all edit page field must be filled
        method = 'POST';
        headers = {
                //'Content-Type' : 'application/x-www-form-urlencoded'
                'Content-Type' : 'application/json',
                'Accept' : 'application/json'
        };
        params = {
            'page_id' : page.page_id,
            'canonical_url' : page.canonical_url,
            'title' : page.title,
            'meta_description' : page.meta_description,
            'robots' : page.robots
        };
        /* console.log("editPageMetaTags params");
        console.log(params); */
        params = JSON.stringify(params);
        /* console.log("editPageMetaTags params stringify");
        console.log(params); */
        //params = "page_id="+page.page_id+"&canonical_url="+page.canonical_url+"&title="+page.title+"&meta_description="+page.meta_description+"&robots="+page.robots;
        mh = new MyHttp(url,method,headers,params);
        //display spinner while waiting the response
        spinner = document.getElementById('mte_page_edit_spinner');
        spinner.classList.toggle('d-none');
        //send edit meta request
        response = mh.getResponse();
        if(mh.response != null){
            mh.response.then(result => {
                //console.log(result);
                //get the message in JSON string
                func_msg = new Message(result);
                func_msg.parseText();
                //console.log(func_msg.message);
                //Show dialog that print the message
                func_dialog = new BsDialog(title_editMetaTags,func_msg.message,BsDialog.DLGTYPE_OK);
                func_dialog.setDialog();
                func_dialog.showDialog();
                //events on dialog buttons click
                func_dialog.btOk.onclick = function (){
                    //Close dialog and remove it
                    func_dialog.instance.dispose();
                    document.body.removeChild(func_dialog.divDialog);
                    if(func_msg.done == true){
                        //Update the pages list from database
                        getAllPages(getAllUrl,deleteUrl);
                    }
                };    
            })//mh.response.then(result => {
            .catch(error => {
                console.warn(error);
            })
            .finally(() => {
                spinner.classList.toggle('d-none');
            });//response.then(result => {
        }//if(mh.response != null){
    }//if(page.notEmpty()){
    else{
        func_dialog = new BsDialog(title_editMetaTags,page.error,BsDialog.DLGTYPE_OK);
        func_dialog.setDialog();
        func_dialog.showDialog();
        func_dialog.btOk.onclick = function (){
            //Close dialog and remove it
            func_dialog.instance.dispose();
            document.body.removeChild(func_dialog.divDialog);
        };
    }//else di if(page.notEmpty())
}

//get meta tags edited by this plugin from all pages 
function getAllPages(getAllUrl,deleteUrl){
    method = 'GET';
    headers = {};
    params = {};
    mh = new MyHttp(getAllUrl,method);
    mh.getResponse();
    if(mh.response != null){
        mh.response.then(result => {
            //console.log(result);
            pagesList = new PagesList(result);
            pagesList.parseText();
            //console.log(pagesList.pages);
            displayAllPagesEdited(pagesList.pages,deleteUrl,getAllUrl);
        })
        .catch(error => {
            console.warn(error);
        })
        .finally(() => {
    
        });
    }//if(mh.response != null){
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
    mh.getResponse();
    if(mh.response != null){
        mh.response.then(result => {
            //get response from ajaxUrl
            //console.log(result);
            page = new Page();
            var pageParsed = page.parseJsonString(result); //parse JSON string and set properties values
            if(pageParsed){
                //JSON string parsed successufly
                displayPageValues(page);
            }
            else{
                let msg = '';
                if(page.errno == Page.ERR_FROMSERVER){
                    //Display error message in Bootstrap dialog
                    func_msg = new Message(result);
                    func_msg.parseText();
                    if(func_msg.errno == 0)
                        //Json structure and content is ok
                        msg = func_msg.message;
                    else
                        msg = func_msg.error;
                }//if(page.errno == Page.ERR_FROMSERVER){
                else
                    msg = page.error;      
                func_dialog = new BsDialog(title_getMetaTagsPage,msg,BsDialog.DLGTYPE_OK);
                func_dialog.setDialog();
                func_dialog.showDialog();
                func_dialog.btOk.onclick = function (){
                    //Close dialog and remove it
                    func_dialog.instance.dispose();
                    document.body.removeChild(func_dialog.divDialog);
                };
            }//else di if(pageParsed){
        })//response.then(result => {
        .catch(error => {
            console.warn(error);
        })
        .finally(() => {
            spinner.classList.toggle('d-none');
        });
    }//if(mh.response != null){
}