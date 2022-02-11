<?php

interface Constants{

    //Bootstrap path
    const BS_CSS_PATH = "/bootstrap-5.1.3-dist/css/bootstrap.min.css";
    const BS_JS_PATH = "/bootstrap-5.1.3-dist/js/bootstrap.min.js";

    //Name of database table(without prefix)
    const TABLE_NAME = "meta_tag_editor";
    const LOG_FILE = ABSPATH."/log.txt";
    
    //menu
    const MENU_TITLE = "Modifica meta tag";
    const MENU_PAGE_TITLE = "Meta tag editor";
    const MENU_CAPABILITY = "administrator";
    const MENU_SLUG = 'meta-tag-editor';
    const MENU_POSITION = 1;

    //Plugin relative paths
    const PLUGIN_DIR = "/meta-tag-editor";
    const PLUGIN_CSS_PATH1 = Constants::PLUGIN_DIR."/css/meta-tag-style.css";
    const PLUGIN_MAIN_FILE = Constants::PLUGIN_DIR."meta-tag-editor.php";
    const PLUGIN_YOASTSEO_FILE = "/wordpress-seo/wp-seo.php";

}
?>