<?php

$risposta = array();
$risposta['msg'] = '';
$risposta['done'] = false;
$risposta['post'] = $_POST;

echo json_encode($risposta,JSON_UNESCAPED_UNICODE);
?>