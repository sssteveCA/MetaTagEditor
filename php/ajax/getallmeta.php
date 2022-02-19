<?php

use MetaTagEditor\Interfaces\Constants;
use MetaTagEditor\Interfaces\MmpErrors;
use MetaTagEditor\Interfaces\MmtErrors;
use MetaTagEditor\Models\MyMetaPage as Page;
use MetaTagEditor\Models\MetaTagTable;

require_once('../../../../../wp-load.php');
require_once('../interfaces/constants.php');
require_once('../interfaces/mmp_errors.php');
require_once('../interfaces/mmt_errors.php');
require_once('../models/mymetapage.php');
require_once('../models/metatagtable.php');

$risposta = array();
$risposta['msg'] = '';
$risposta['done'] = false;

try{
    $pageTable = new MetaTagTable(array());
    //get data from database
    $getData = $pageTable->getDataFromDb();
    if($getData){
        //data retrieved successfully
        $risposta['data'] = $pageTable->getPages();
        $risposta['pages'] = array();
        $i = 0;
        foreach($risposta['data'] as $k => $v){
            //Insert values in Page object collection
            $page = new Page($risposta['data'][$k]);
            $risposta['pages'][$k] = $page;
        }
        $risposta['done'] = true;
    }
    else
        $risposta['msg'] = $pageTable->getError();
}
catch(Exception $e){
    $risposta['msg'] = $e->getMessage();
}

echo json_encode($risposta);
?>