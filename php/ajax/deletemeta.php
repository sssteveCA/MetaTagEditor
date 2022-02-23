<?php

require_once('../../../../../wp-load.php');
require_once('../interfaces/messages.php');
require_once('../interfaces/mmp_errors.php');
require_once('../models/mymetapage.php');

use MetaTagEditor\Interfaces\Messages as M;
use MetaTagEditor\Models\MyMetaPage;

$risposta = array();
$risposta['msg'] = '';
$risposta['done'] = false;
$risposta['post'] = $_POST;

if(isset($_POST['page_id'])){
    $dati = array('page_id' => $_POST['page_id']);
    try{
        $mmp = new MyMetaPage($dati);
        $del = $mmp->deleteMetaByPageId();
        if($del){
            $risposta['msg'] = M::OK_DB_DELETE;
            $risposta['done'] = true;
        }
        else{
            $risposta['msg'] = $mmp->getError();
        }
    }catch(Exception $e){
        $risposta['msg'] = $e->getMessage();
    }
    
}//if(isset($_POST['page_id'])){
else{
    $risposta['msg'] = M::ERR_DATA_MISSED;
}

echo json_encode($risposta,JSON_UNESCAPED_UNICODE);

?>