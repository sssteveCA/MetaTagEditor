<?php
header('Content-Type','application/javascript');

require_once("../../../../wp-load.php");
require_once("../php/interfaces/constants.php");

use MetaTagEditor\Interfaces\Constants as C;

$ajax = plugins_url().C::AJAX_GETMETA;

$js = <<<JS
let ajaxUrl = '{$ajax}';
let bt_page_id_show, bt_page_edit; //Buttons for show page meta and for edit it
let headers = {}; //HTTP headers
let in_page_id_show; //Input field for page_id 
let method; //HTTP method
let mh; //MyHttp class instance
let page; //Page class instance
let page_id; //page_id value
let params = {}; //HTTP body request
let response; // HTTP response;
let spinner;


document.addEventListener('DOMContentLoaded',function(){
    in_page_id_show = document.getElementById('mte_page_id_get');
    bt_page_id_show = document.getElementById('mte_btn_show');
    bt_page_edit = document.getElementById('mte_btn_edit');
    bt_page_id_show.onclick = function(){
        //User wants to show meta tags info about a particular page
        page_id = in_page_id_show.value;
        method = 'POST';
        headers = {
            'Content-Type' : 'application/x-www-form-urlencoded'
        };
        params =  "pageId="+page_id;
        mh = new MyHttp(ajaxUrl,method,headers,params);
        //display spinner while waiting the response
        spinner = document.getElementById('mte_page_value_spinner');
        spinner.classList.toggle('d-none');
        response = mh.getResponse();
        response
            .then(result => {
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
            })
            .catch(error => {
                console.warn(error);
            })
            .finally(() => {
                spinner.classList.toggle('d-none');
            });
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
    };//bt_page_edit.onclick = function (){
});
JS;

echo $js;
?>