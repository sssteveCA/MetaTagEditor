<?php
header('Content-Type','application/javascript');

require_once("../../../../wp-load.php");
require_once("../interfaces/constants.php");

use MetaTagEditor\Interfaces\Constants as C;

$ajax = plugins_url().C::AJAX_GETMETA;

$js = <<<JS
var ajaxUrl = '{$ajax}';
var in_page_id_show; //Input field for page_id show
var page_id; //page_id value
var bt_page_id_show;
var headers = {}; //HTTP headers
var params = {}; //HTTP body request
var response; // HTTP response;

document.addEventListener('DOMContentLoaded',function(){
    in_page_id_show = document.getElementById('mte_page_id_get');
    bt_page_id_show = document.getElementById('mte_btn_show');

    bt_page_id_show.onclick = function(){
        page_id = in_page_id_show.value;
    };//bt_page_id_show.onclick = function(){
});
JS;

echo $js;
?>