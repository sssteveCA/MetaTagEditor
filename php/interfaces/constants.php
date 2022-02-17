<?php

namespace MetaTagEditor\Interfaces;

interface Constants{

    //ajax URL
    const AJAX_GETMETA = Constants::PLUGIN_DIR."/php/ajax/getmeta.php"; //Get all pages meta from database

    //Bootstrap path
    const BS_CSS_PATH = Constants::BS_VERSION."/css/bootstrap.min.css";
    const BS_JS_PATH = Constants::BS_VERSION."/js/bootstrap.min.js";
    const BS_VERSION = "/bootstrap-5.0.2-dist";

    //Name of database table(without prefix)
    const TABLE_NAME = "meta_tag_editor";
    const LOG_FILE = ABSPATH."/log.txt";

    //Script handles
    const H_BS_CSS = "bootstrapCss";
    const H_BS_JS = "bootstrapJs";
    const H_CSS1 = "metaTagStyle";
    const H_JS1 = "metaTagJs";
    const H_JS_MYHTTP = "metaTagJsMyHttp";
    const H_JS_PAGE = "metaTagJsPage";
    
    //menu
    const MENU_TITLE = "Modifica meta tag";
    const MENU_PAGE_TITLE = "Meta tag editor";
    const MENU_CAPABILITY = "administrator";
    const MENU_SLUG = 'meta-tag-editor';
    const MENU_POSITION = 1;

    //Plugin relative paths
    const PLUGIN_DIR = "/meta-tag-editor";
    const PLUGIN_CSS_PATH1 = Constants::PLUGIN_DIR."/css/meta-tag-style.css";
    const PLUGIN_JS_PATH1 = Constants::PLUGIN_DIR."/js/main.php";
    const PLUGIN_JS_MYHTTP = Constants::PLUGIN_DIR."/js/client/myhttp.js";
    const PLUGIN_JS_PAGE = Constants::PLUGIN_DIR."/js/models/page.js";
    const PLUGIN_MAIN_FILE = Constants::PLUGIN_DIR."/meta-tag-editor.php";
    const PLUGIN_YOASTSEO_FILE = "wordpress-seo/wp-seo.php";

    //Site URL
    const SITE_HOME_URL = "https://www.lafilosofiadibianca.com";

    //Yoast 
    const YOAST_RESTAPI_URL = "/wp-json/yoast/v1/get_head?url=";

}
?>