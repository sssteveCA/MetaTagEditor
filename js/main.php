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
let bt_page_id_show, bt_page_edit; //Buttons for show page meta and for edit it
let in_page_id_show; //Input field for page_id 
let page; //Page class instance
let main_page_id; //page_id value



document.addEventListener('DOMContentLoaded',function(){
    //Request for retrieving meta tags from plugin MySQL table
    getAllPages(ajaxGetAll,ajaxDelete);
    in_page_id_show = document.getElementById('mte_page_id_get');
    bt_page_id_show = document.getElementById('mte_btn_show');
    bt_page_edit = document.getElementById('mte_btn_edit');
    bt_page_id_show.onclick = function(){
        //User wants to show meta tags info about a particular page
        main_page_id = in_page_id_show.value;
        getPageMetaTags(main_page_id,ajaxGet);
    };//bt_page_id_show.onclick = function(){
    bt_page_edit.onclick = function (){
        //User wants edit meta tag page
        page = new Page();
        page.page_id = document.getElementById('mte_page_id_set').value;
        page.canonical_url = document.getElementById('mte_canonical_url_edit').value;
        page.title = document.getElementById('mte_title_edit').value;
        page.meta_description = document.getElementById('mte_meta_description_edit').value;
        page.robots = document.getElementById('mte_robots_edit').value;
        console.log(page);
        editPageMetaTags(page,ajaxSet);
    };//bt_page_edit.onclick = function (){
});
JS;

echo $js;
?>