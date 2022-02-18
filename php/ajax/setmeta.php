<?php

use MetaTagEditor\Models\MyMetaPage;

$risposta = array();
$risposta['msg'] = '';
$risposta['done'] = false;
$risposta['post'] = $_POST;

echo json_encode($risposta);
?>