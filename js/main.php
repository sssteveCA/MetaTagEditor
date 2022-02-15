<?php
header('Content-Type','application/javascript');

require_once("../../../../wp-load.php");
require_once("../interfaces/constants.php");

use MetaTagEditor\Interfaces\Constants as C;

$ajax = plugins_url().C::AJAX_GETMETA;

$js = <<<JS
document.addEventListener('DOMContentLoaded',function(){
    var ajaxUrl = '{$ajax}';
    console.log("main.php dom content loaded");
    console.log("ajaxUrl => "+ajaxUrl);
});
JS;

echo $js;
?>