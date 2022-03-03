

const labels = {
    'canonical_url' : 'URL canonico',
    'title' : 'Titolo',
    'meta_description' : 'Meta description',
    'robots' : 'Robots'
};
let mte_btn_delete;
let f2_bsdialog;
let f2_headers,f2_method, f2_mh, f2_msg_ask_delete;
let f2_pageslistDiv, f2_params, f2_del_spinner;
let index;

//delete specific meta tags page selecting his page id
function deleteMetaTagsPage(page_id,url,getAllUrl){
    f2_method = 'POST';
    f2_headers = {
        'Content-Type' : 'application/x-www-form-urlencoded'
    };
    f2_params = "page_id="+page_id;
    f2_mh = new MyHttp(url, f2_method, f2_headers, f2_params);
    f2_del_spinner.classList.toggle('d-none');
    f2_mh.getResponse();
    if(f2_mh.response != null){
        f2_mh.response.then(result => {
            console.log(result);
            getAllPages(getAllUrl,url);
            //get the message in JSON string
            func_msg = new Message(result);
            func_msg.parseText();
            console.log(func_msg.message);
            //Show dialog that print the message
            func_dialog = new BsDialog('Elimina meta tag',func_msg.message,BsDialog.DLGTYPE_OK);
            func_dialog.setDialog();
            func_dialog.showDialog();
            //events on dialog buttons click
            if(func_dialog.type == BsDialog.DLGTYPE_OK){
                func_okbtn = document.querySelector('.mte_okbutton');
                func_okbtn.onclick = function (){
                    //Close dialog and remove it
                    func_dialog.instance.dispose();
                    document.body.removeChild(func_dialog.divDialog);
                    if(func_msg.done == true){
                        //Update the pages list from database
                        getAllPages(getAllUrl,url);
                    }
                };
            }
        })//f2_mh.response.then(result => {
        .catch(error => {
            console.warn(error);
        })
        .finally(() => {
            f2_del_spinner.classList.toggle('d-none');
        });
    }//if(f2_mh.response != null){

}

//display all pages meta tags edited by this plugin
function displayAllPagesEdited(pageList,deleteUrl,getAllUrl){
    let list = pageList;
    //console.log(list);
    f2_pageslistDiv = document.getElementById('mte_pagelist_collections');
    if(f2_pageslistDiv){
        f2_pageslistDiv.innerHTML = '';
            let divSelectLabel = document.createElement('div');
            divSelectLabel.classList.add('col-12','col-sm-2','text-center','text-sm-start','mt-4','mb-2');
            divSelectLabel.innerText = 'ID della pagina';
            divSelectLabel.style.position = 'relative';
            divSelectLabel.style.left = '6px';
        f2_pageslistDiv.appendChild(divSelectLabel);
            let divSelect = document.createElement('div');
            divSelect.classList.add('col-12','col-sm-1','text-center','text-sm-start','mt-4','mb-2');
            //create SELECT item that contains page id list
                let selectItem = document.createElement('select');
                selectItem.setAttribute('id','mte_select_pageid');
                for(var [k, v] of Object.entries(list)){
                    //add pageId list to select item
                    let option = document.createElement('option');
                        let text = document.createTextNode(v.page_id);
                        option.appendChild(text);
                selectItem.appendChild(option);
                }//for(var [k, v] of Object.entries(list)){
            divSelect.appendChild(selectItem);
        f2_pageslistDiv.appendChild(divSelect);
            let divDelete = document.createElement('div');
            divDelete.classList.add('col-12','offset-sm-3','col-sm-2','text-center','text-sm-start','mt-4','mb-2');
                let deleteBtn = document.createElement('button');
                deleteBtn.setAttribute('id','mte_btn_delete');
                deleteBtn.classList.add('btn','btn-danger');
                deleteBtn.innerText = 'ELIMINA';
            divDelete.appendChild(deleteBtn);
        f2_pageslistDiv.appendChild(divDelete);
            let divSpinner = document.createElement('div');
            divSpinner.classList.add('col-12','col-sm-2','d-flex','justify-content-center','mt-4','mb-4');
                f2_del_spinner = document.createElement('div');
                f2_del_spinner.classList.add('spinner-border','d-none');
                f2_del_spinner.setAttribute('role','status');
            divSpinner.appendChild(f2_del_spinner);
        f2_pageslistDiv.appendChild(divSpinner);
            let divBr = document.createElement('div');
            divBr.className = 'w-100';
        f2_pageslistDiv.appendChild(divBr);
        //create meta tag page info items
            let divInfo = document.createElement('div');
            divInfo.className = 'col-12';
                let rowInfo = document.createElement('div');
                rowInfo.className = 'row';
                for(var [key, val] of Object.entries(labels)){
                    let divLabel = document.createElement('div');
                    divLabel.classList.add('col-12','col-md-6','text-center','text-md-start','mt-3');
                    divLabel.innerText = val;
                    divLabel.style.fontSize = '18px';
                    divLabel.style.textTransform = 'uppercase';
                rowInfo.appendChild(divLabel);
                    let divValue = document.createElement('div');
                    divValue.setAttribute('id','mte_edit_val_'+key);
                    divValue.classList.add('col-12','col-md-6','text-center','text-md-start','mt-3');
                    divValue.innerText = list[selectItem.value][key];
                    divValue.style.fontSize = '18px';
                    divValue.style.fontWeight = 'bold';
                    divValue.style.fontStyle = 'italic';
                rowInfo.appendChild(divValue);
                }//for(var [key, val] of Object.entries(labels)){
            divInfo.appendChild(rowInfo);
        f2_pageslistDiv.appendChild(divInfo);
        selectItem.onchange = function (){
            index = this.value;
            document.getElementById('mte_edit_val_canonical_url').innerText = list[index]["canonical_url"];
            document.getElementById('mte_edit_val_title').innerText = list[index]["title"];
            document.getElementById('mte_edit_val_meta_description').innerText = list[index]["meta_description"];
            document.getElementById('mte_edit_val_robots').innerText = list[index]["robots"];
        } //selectItem.onchange = function (){
        mte_btn_delete = document.getElementById('mte_btn_delete');
        if(mte_btn_delete){
            mte_btn_delete.onclick = function(){
                f2_msg_ask_delete = 'Sei sicuro di voler cancellare i meta tag della pagina modificati?';
                f2_bsdialog = new BsDialog('Elimina meta tag',f2_msg_ask_delete,BsDialog.DLGTYPE_YESNO);
                f2_bsdialog.setDialog();
                f2_bsdialog.showDialog();
                //Bootstrap dialog click events
                f2_bsdialog.btYes.onclick = function(){
                    f2_bsdialog.instance.dispose();
                    document.body.removeChild(f2_bsdialog.divDialog);
                    index = selectItem.value;
                    deleteMetaTagsPage(list[index]["page_id"],deleteUrl,getAllUrl);
                };//f2_bsdialog.btYes.onclick = function(){
                f2_bsdialog.btNo.onclick = function(){
                    f2_bsdialog.instance.dispose();
                    document.body.removeChild(f2_bsdialog.divDialog);
                };//f2_bsdialog.btNo.onclick = function(){
            };// mte_btn_delete.onclick = function(){
        }//if(mte_btn_delete){
    }//if(func2_pageslistDiv){
}