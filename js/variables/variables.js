const title_deleteMetaTags = 'Elimina meta tag';
const title_editMetaTags = 'Modifica meta tag';
const title_getMetaTagsPage = 'Richiesta meta tag pagina';

const arrLabels = {
    "page_id" : "ID della pagina",
    "canonical_url" : "URL canonico",
    "title" : "Titolo della pagina",
    "meta_description" : "Descrizione meta",
    "robots" : "Robots"
};

const labels = {
    'canonical_url' : 'URL canonico',
    'title' : 'Titolo',
    'meta_description' : 'Meta description',
    'robots' : 'Robots'
};

let bsdialog; //BsDialog instance
let bt_page_id_show, bt_page_edit; //Buttons for show page meta and for edit it
let in_page_id_show; //Input field for page_id 
let mte_cb_noindex, mte_cb_nofollow, mte_cb_noarchive,mte_cb_nosnippet;
let mte_cb_indexifembedded, mte_maxsnippet, mte_sel_maximagepreview, mte_maxvideopreview;
let mte_cb_notranslate, mte_cb_noimageindex, mte_cb_unavailableafter, mte_input_unavailableafter;
let msg_ask_edit;
let page; //Page class instance
let main_page_id; //page_id value

let arrValues;
let container;
let divLabel, divRow, divValue;
let func_dialog,func_msg, func_nobtn;
let func_okbtn, func_yesbtn,func_page;
let headers,method,mh;
let params,pagesList,response;
let spinner;
let textLabel, textValue;

let mte_btn_delete;
let f2_bsdialog;
let f2_headers,f2_method, f2_mh, f2_msg_ask_delete;
let f2_pageslistDiv, f2_params, f2_del_spinner;
let index;