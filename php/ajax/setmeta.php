<?php

use MetaTagEditor\Interfaces\Messages as M;
use MetaTagEditor\Interfaces\MmpErrors;
use MetaTagEditor\Models\MyMetaPage;

require_once('../../../../../wp-load.php');
require_once('../interfaces/messages.php');
require_once('../interfaces/mmp_errors.php');
require_once('../models/mymetapage.php');

$risposta = array();
$risposta['msg'] = '';
$risposta['done'] = false;
$risposta['post'] = $_POST;

if(isset($_POST['page_id'],$_POST['canonical_url'],$_POST['title'],$_POST['meta_description'],$_POST['robots'])){
    $dati = array(
        'page_id' => $_POST['page_id'],
        'canonical_url' => $_POST['canonical_url'],
        'title' => $_POST['title'],
        'meta_description' => $_POST['meta_description'],
        'robots' => $_POST['robots']
    );
    try{
        $page = new MyMetaPage($dati);
        $edited = $page->editPageMeta();
        if($edited){
            //database edited successfully
            $risposta['done'] = true;
            $risposta['msg'] = M::OK_DB_EDIT;
        }
        else
            $risposta['msg'] = $page->getError();
    }catch(Exception $e){
        $risposta['msg'] = $e->getMessage();
    }

}//if(isset($_POST['page_id'],$_POST['canonical_url'],$_POST['title'],$_POST['meta_description'],$_POST['robots'])){
else
    $risposta['msg'] = M::ERR_DATA_MISSED; 


echo json_encode($risposta);
?>