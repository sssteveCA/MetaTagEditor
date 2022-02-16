<?php
header('Content-Type','application/javascript');

require_once("../../../../wp-load.php");
require_once("../php/interfaces/constants.php");

use MetaTagEditor\Interfaces\Constants as C;

$ajax = plugins_url().C::AJAX_GETMETA;
$myHttp = plugins_url().C::PLUGIN_JS_MYHTTP;

$js = <<<JS
var ajaxUrl = '{$ajax}';
var in_page_id_show; //Input field for page_id show
var page_id; //page_id value
var bt_page_id_show;
var method; //HTTP method
var headers = {}; //HTTP headers
var params = {}; //HTTP body request
var response; // HTTP response;
var mh; //myHttp class instance
import {myHttp} from '{$myHttp}';

document.addEventListener('DOMContentLoaded',function(){
    in_page_id_show = document.getElementById('mte_page_id_get');
    bt_page_id_show = document.getElementById('mte_btn_show');

    bt_page_id_show.onclick = function(){
        console.log("bt_page_id_show.onclick");
        //User wants to show meta tags info about a particular page
        page_id = in_page_id_show.value;
        console.log("page_id => "+page_id);
        method = 'POST';
        headers = {
            'Content-Type' : 'application/x-www-form-urlencoded'
        };
        params = {
            'page_id' : page_id
        }
        mh = new myHttp(ajaxUrl,method,headers,params);
        response = mh.getResponse();
        console.log(response);
        console.log("Errore => "+mh.errno);
    };//bt_page_id_show.onclick = function(){
});
JS;

echo $js;
?>