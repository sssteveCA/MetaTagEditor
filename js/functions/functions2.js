
let func2_pageslistDiv;

//display all pages meta tags edited by this plugin
function displayAllPagesEdited(pageList){
    let list = pageList;
    func2_pageslistDiv = document.getElementById('mte_pagelist_collections');
    if(func2_pageslistDiv){
        func2_pageslistDiv.innerHTML = '';
            let divSelectLabel = document.createElement('div');
            divSelectLabel.classList.add('col-12','col-sm-2','text-center','text-sm-start','mt-4','mb-2');
            divSelectLabel.innerText = 'ID della pagina';
            divSelectLabel.style.position = 'relative';
            divSelectLabel.style.left = '6px';
        func2_pageslistDiv.appendChild(divSelectLabel);
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
        func2_pageslistDiv.appendChild(divSelect);
            let divDelete = document.createElement('div');
            divDelete.classList.add('col-12','offset-sm-3','col-sm-4','text-center','text-sm-start', 'mt-4','mb-2');
                let deleteBtn = document.createElement('button');
                deleteBtn.setAttribute('id','mte_btn_delete');
                deleteBtn.classList.add('btn','btn-danger');
                deleteBtn.innerText = 'ELIMINA';
            divDelete.appendChild(deleteBtn);
        func2_pageslistDiv.appendChild(divDelete);
            let divBr = document.createElement('div');
            divBr.className = 'w-100';
        func2_pageslistDiv.appendChild(divBr);  
    }//if(func2_pageslistDiv){
}