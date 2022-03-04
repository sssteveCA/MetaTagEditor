<?php
header('Content-Type','application/javascript');

require_once("../../../../wp-load.php");
require_once("../php/interfaces/constants.php");

use MetaTagEditor\Interfaces\Constants as C;

$plugins_url = plugins_url();
$ajaxDelete = $plugins_url.C::AJAX_DELETEMETA;
$ajaxGet = $plugins_url.C::AJAX_GETMETA;
$ajaxGetAll = $plugins_url.C::AJAX_ALLMETA;
$ajaxSet = $plugins_url.C::AJAX_SETMETA;

$js = <<<JS
let ajaxDelete = '{$ajaxDelete}';
let ajaxGet = '{$ajaxGet}';
let ajaxGetAll = '{$ajaxGetAll}';
let ajaxSet = '{$ajaxSet}';

document.addEventListener('DOMContentLoaded',function(){
    //Request for retrieving meta tags from plugin MySQL table
    getAllPages(ajaxGetAll,ajaxDelete);
    assignElement();
    buttonEvents();
    inputEvents();
});

function assignElement(){
    in_page_id_show = document.getElementById('mte_page_id_get');
    bt_page_id_show = document.getElementById('mte_btn_show');
    bt_page_edit = document.getElementById('mte_btn_edit');
    mte_cb_noindex = document.getElementById('mte_cb_noindex'); 
    mte_cb_nofollow = document.getElementById('mte_cb_nofollow');
    mte_cb_noarchive = document.getElementById('mte_cb_noarchive');
    mte_cb_nosnippet = document.getElementById('mte_cb_nosnippet');
    mte_cb_indexifembedded = document.getElementById('mte_cb_indexifembedded');
    mte_maxsnippet = document.getElementById('mte_maxsnippet');
    mte_sel_maximagepreview = document.getElementById('mte_sel_maximagepreview');
    mte_maxvideopreview = document.getElementById('mte_maxvideopreview');
    mte_cb_notranslate = document.getElementById('mte_cb_notranslate');  
    mte_cb_noimageindex = document.getElementById('mte_cb_noimageindex'); 
    mte_cb_unavailableafter = document.getElementById('mte_cb_unavailableafter');  
    mte_input_unavailableafter = document.getElementById('mte_input_unavailableafter'); 
}

//Button events function
function buttonEvents(){
    bt_page_id_show.onclick = function(){
        //User wants to show meta tags info about a particular page
        main_page_id = in_page_id_show.value;
        getPageMetaTags(main_page_id,ajaxGet);
    };//bt_page_id_show.onclick = function(){
    bt_page_edit.onclick = function (){
        //User wants edit meta tag page
        msg_ask_edit = 'Sei sicuro di voler modificare i meta tag della pagina selezionata con questi dati?';
        //Dialog ask confirm for do this operation
        bsdialog = new BsDialog('Modifica meta tag',msg_ask_edit,BsDialog.DLGTYPE_YESNO);
        bsdialog.setDialog();
        bsdialog.showDialog();
        //Bootstrap dialog click events
        bsdialog.btYes.onclick = function (){
            //User clicks 'YES'
            bsdialog.instance.dispose();
            document.body.removeChild(bsdialog.divDialog);
            page = new Page();
            page.page_id = document.getElementById('mte_page_id_set').value;
            page.canonical_url = document.getElementById('mte_canonical_url_edit').value;
            page.title = document.getElementById('mte_title_edit').value;
            page.meta_description = document.getElementById('mte_meta_description_edit').value;
            page.robots = {
                'noindex' : mte_cb_noindex.checked,
                'nofollow' : mte_cb_nofollow.checked,
                'noarchive' : mte_cb_noarchive.checked,
                'nosnippet' : mte_cb_nosnippet.checked,
                'indexifembedded' : mte_cb_indexifembedded.checked,
                'maxsnippet' : mte_maxsnippet.value,
                'maximagepreview' : mte_sel_maximagepreview.value,
                'maxvideopreview' : mte_maxvideopreview.value,
                'notranslate' : mte_cb_notranslate.checked,
                'noimageindex' : mte_cb_noimageindex.checked,
                'cb_unavailableafter' : mte_cb_unavailableafter.checked,
                'unavailableafter' : mte_input_unavailableafter.value
            };
            console.log(page);
            editPageMetaTags(page,ajaxSet,ajaxGetAll,ajaxDelete);
        };//bsdialog.btYes.onclick = function (){
        bsdialog.btNo.onclick = function (){
            //User clicks 'NO'
            bsdialog.instance.dispose();
            document.body.removeChild(bsdialog.divDialog);
        };//bsDialog.btNo.onclick = function (){       
    };//bt_page_edit.onclick = function (){
}

//Input events function
function inputEvents(){
    mte_cb_noindex.onchange = function (){
        if(mte_cb_noindex.checked){
            //indexifembedded option enabled if noindex checknox is checked
            mte_cb_indexifembedded.disabled = false;
        }
        else{
            mte_cb_indexifembedded.checked = false;
            mte_cb_indexifembedded.disabled = true;
        }
    };//mte_cb_noindex.onchange = function (){
    mte_cb_unavailableafter.onchange = function (){
        if(mte_cb_unavailableafter.checked){
            //unavailableafter input enabled if unavailableafter checkbox is checked
            mte_input_unavailableafter.disabled = false;
        }
        else{
            mte_input_unavailableafter.disabled = true;
        }
    };//mte_cb_unavailableafter.onchange = function (){
}
JS;

echo $js;
?>