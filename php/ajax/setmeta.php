<?php

use MetaTagEditor\Interfaces\Messages as M;
use MetaTagEditor\Interfaces\Constants as C;
use MetaTagEditor\Interfaces\MmpErrors;
use MetaTagEditor\Models\MyMetaPage;

require_once('../../../../../wp-load.php');
require_once('../interfaces/messages.php');
require_once('../interfaces/mmp_errors.php');
require_once('../models/mymetapage.php');

$content = file_get_contents("php://input");
$_POST = json_decode($content,true);

$risposta = array();
$risposta['msg'] = '';
$risposta['done'] = false;
$risposta['post'] = $_POST;

if(isset($_POST['page_id'],$_POST['canonical_url'],$_POST['title'],$_POST['meta_description'],$_POST['robots'])){
    $robots = setRobotsString($_POST['robots']);
    $dati = array(
        'page_id' => $_POST['page_id'],
        'canonical_url' => $_POST['canonical_url'],
        'title' => $_POST['title'],
        'meta_description' => $_POST['meta_description'],
        'robots' => $robots
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

//create meta robots string from request value 
function setRobotsString($robots){
    $robotsArray = array();
    $robotsString = '';
    if($robots['noindex'] == true){$robotsArray[] = 'noindex';}
    else{$robotsArray[] = 'index';}
    if($robots['nofollow'] == true){$robotsArray[] = 'nofollow';}
    else{$robotsArray[] = 'follow';}
    if($robots['noarchive'] == true){$robotsArray[] = 'noarchive';}
    if($robots['nosnippet'] == true){$robotsArray[] = 'nosnippet';}
    if($robots['nofollow'] == true && $robots['indexifembedded'] == true){
        $robotsArray[] = 'indexifembedded';
    }
    if($robots["maxsnippet"] >= 0){$robotsArray[] = "max-snippet:{$robots['maxsnippet']}";}
    else{$robotsArray[] = 'max-snippet:-1';}
    //check if value inserted is present in this array
    $maximageprev_vals = array('none','standard','large');
    if(in_array($robots['maximagepreview'],$maximageprev_vals)){
        $robotsArray[] = "max-image-preview:{$robots['maximagepreview']}";
    }
    else{$robotsArray[] = "max-image-preview:standard";}
    if($robots['maxvideopreview'] >= 0){$robotsArray[] = "max-video-preview:{$robots['maxvideopreview']}";}
    else{$robotsArray[] = 'max-video-preview:-1';}
    if($robots['notranslate'] == true){$robotsArray[] = 'notranslate';}
    if($robots['noimageindex'] == true){$robotsArray[] = 'noimageindex';}
    if($robots["cb_unavailableafter"] == true){$robotsArray[] = "unavailable_after:{$robots['unavailableafter']}";}
    $robotsString = implode(", ",$robotsArray);
    //file_put_contents(C::LOG_FILE,"robotsString => {$robotsString}\r\n",FILE_APPEND);
    return $robotsString;
}
?>