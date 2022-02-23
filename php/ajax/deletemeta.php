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

echo json_encode($risposta,JSON_UNESCAPED_UNICODE);

?>