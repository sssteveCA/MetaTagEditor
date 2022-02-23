<?php

namespace MetaTagEditor\Interfaces;

interface Constants{

    //ajax URL
    const AJAX_ALLMETA = Constants::PLUGIN_DIR."/php/ajax/getallmeta.php"; //Get all pages that were edited from this plugin
    const AJAX_DELETEMETA = Constants::PLUGIN_DIR."/php/ajax/deletemeta.php"; //Delete meta tags of particular page
    const AJAX_GETMETA = Constants::PLUGIN_DIR."/php/ajax/getmeta.php"; //Get all pages meta from Yoast REST API
    const AJAX_SETMETA = Constants::PLUGIN_DIR."/php/ajax/setmeta.php"; //Edit meta tags of particular page

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
    const H_BS_BUNDLE_JS = "bootstrapBundleJs";
    const H_CSS1 = "metaTagStyle";
    const H_JS1 = "metaTagJs";
    const H_JS_BSDIALOG = "metaTagJsBsDialog";
    const H_JS_FUNCTIONS1 = "metaTagJsFunctions";
    const H_JS_FUNCTIONS2 = "metaTagJsFunctions2";
    const H_JS_MESSAGE = "metaTagJsMessage";
    const H_JS_MYHTTP = "metaTagJsMyHttp";
    const H_JS_PAGE = "metaTagJsPage";
    const H_JS_PAGELIST = "metaTagJsPagelist";
    
    //menu
    const MENU_TITLE = "Modifica meta tag";
    const MENU_PAGE_TITLE = "Meta tag editor";
    const MENU_CAPABILITY = "administrator";
    const MENU_SLUG = 'meta-tag-editor';
    const MENU_POSITION = 1;

    //Plugin relative paths
    const PLUGIN_DIR = "/meta-tag-editor";
    const PLUGIN_CSS_PATH1 = Constants::PLUGIN_DIR."/css/meta-tag-style.css";
    const PLUGIN_JS_BSDIALOG = Constants::PLUGIN_DIR."/js/dialog/bsdialog.js";
    const PLUGIN_JS_FUNCTIONS1 = Constants::PLUGIN_DIR."/js/functions/functions.js";
    const PLUGIN_JS_FUNCTIONS2 = Constants::PLUGIN_DIR."/js/functions/functions2.js";
    const PLUGIN_JS_MESSAGE = Constants::PLUGIN_DIR."/js/models/message.js";
    const PLUGIN_JS_MYHTTP = Constants::PLUGIN_DIR."/js/client/myhttp.js";
    const PLUGIN_JS_PAGE = Constants::PLUGIN_DIR."/js/models/page.js";
    const PLUGIN_JS_PAGELIST = Constants::PLUGIN_DIR."/js/models/pagelist.js";
    const PLUGIN_JS_PATH1 = Constants::PLUGIN_DIR."/js/main.php";
    const PLUGIN_MAIN_FILE = Constants::PLUGIN_DIR."/meta-tag-editor.php";
    const PLUGIN_YOASTSEO_FILE = "wordpress-seo/wp-seo.php";

    //Site URL
    const SITE_HOME_URL = "https://www.lafilosofiadibianca.com";

    //Yoast 
    const YOAST_RESTAPI_URL = "/wp-json/yoast/v1/get_head?url=";

}
?>