<?php

require_once("../../../../../wp-load.php");
require_once("../interfaces/messages.php");
require_once("../interfaces/mmp_errors.php");
require_once("../models/mymetapage.php");

use MetaTagEditor\Interfaces\Messages as M;
use MetaTagEditor\Models\MyMetaPage;

$risposta = array();
$risposta['msg'] = '';
$risposta['done'] = false;
//$risposta['post'] = $_POST;

if(isset($_POST["pageId"]) && is_numeric($_POST["pageId"])){
    $page_id = $_POST["pageId"];
    $url = wp_get_canonical_url($page_id);
    if($url != false){
        //$risposta["url"] = $url;
        $dati = array (
            "page_id" => $page_id,
            "canonical_url" => $url
        );
        $mmp = new MyMetaPage($dati);
        if($mmp->getMetaByUrlFromYoast()){
            $risposta["page"]["page_id"] = $mmp->getPageId();
            $risposta["page"]["canonical_url"] = $mmp->getCanonicalUrl();
            $risposta["page"]["title"] = $mmp->getTitle();
            $risposta["page"]["meta_description"] = $mmp->getMetaDescription();
            $risposta["page"]["robots"] = $mmp->getRobots();
            $risposta["done"] = true;
        }//if($mmp->getMetaByUrlFromYoast()){
        else
            $risposta["msg"] = $mmp->getError();
    }//if($url != false){
    else{
        $risposta["msg"] = M::ERR_PAGE_NOTEXISTS;
    }
}//if(isset($_POST["pageId"]) && is_numeric($_POST["pageId"])){
else{
    $risposta['msg'] = M::ERR_DATA_MISSED;
}


echo json_encode($risposta,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
?>