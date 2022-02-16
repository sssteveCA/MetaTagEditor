<?php

require_once("../../../../../wp-load.php");

use MetaTagEditor\Interfaces\Messages as M;

$risposta = array();
$risposta['msg'] = '';
$risposta['done'] = false;
$risposta['post'] = $_POST;

if(isset($_POST["pageId"]) && is_numeric($_POST["pageId"])){
    $id = $_POST["pageId"];
    $url = wp_get_canonical_url($id);
    if($url != false){
        $risposta["url"] = $url;
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