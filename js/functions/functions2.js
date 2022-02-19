

const labels = {
    'canonical_url' : 'URL canonico',
    'title' : 'Titolo',
    'meta_description' : 'Meta description',
    'robots' : 'Robots'
};
let func2_pageslistDiv;

//display all pages meta tags edited by this plugin
function displayAllPagesEdited(pageList){
    let list = pageList;
    console.log(list);
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
        //create meta tag page info items
            let divInfo = document.createElement('div');
            divInfo.className = 'col-12';
                let rowInfo = document.createElement('div');
                rowInfo.className = 'row';
                for(var [key, val] of Object.entries(labels)){
                    let divLabel = document.createElement('div');
                    divLabel.classList.add('col-12','col-md-6','text-center','text-md-start');
                    divLabel.innerText = val;
                rowInfo.appendChild(divLabel);
                    let divValue = document.createElement('div');
                    divValue.classList.add('col-12','col-md-6','text-center','text-md-start');
                    divValue.innerText = list[selectItem.value][key];
                rowInfo.appendChild(divValue);
                }//for(var [key, val] of Object.entries(labels)){
            divInfo.appendChild(rowInfo);
        func2_pageslistDiv.appendChild(divInfo);
        selectItem.onchange = function (){
            console.log("Select option value => ");
            console.log(selectItem.value);
        }  
    }//if(func2_pageslistDiv){
}