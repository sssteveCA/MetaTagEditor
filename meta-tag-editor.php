<?php
/**
 * Plugin Name: Meta tag editor
 * Description: This plugin allow to modify meta tag of wordpress pages
 * Version: 1.0
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Author: Stefano Puggioni
 * Author URI: https://github.com/sssteveCA
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */


require_once('php/interfaces/constants.php');
require_once('php/interfaces/html.php');
require_once('php/interfaces/messages.php');
require_once('php/interfaces/mmt_errors.php');
require_once('php/models/metatagtable.php');
require_once(ABSPATH.'wp-admin/includes/upgrade.php');

use MetaTagEditor\Interfaces\Constants as C;
use MetaTagEditor\Interfaces\Html as H;
use MetaTagEditor\Interfaces\Messages as M;
use MetaTagEditor\Models\MetaTagTable as Mmt;

$home = get_home_url();
$plugin_url = plugins_url();
$mmt = null; //MetaTagTable object
$found = false; //true if post_id of page is found on database
$pages = array(); //this array contains info of the pages retrieved from DB
$pageFound = array(); //if page_id match the current post id, this array contains meta info of that page

//When plugin is activated
register_activation_hook(__FILE__, 'mte_activator');

function mte_activator(){
    global $wpdb;
    file_put_contents(C::LOG_FILE,"mte_activator\r\n",FILE_APPEND);
    //Check if Yoast SEO plugin is active
    if(is_plugin_active(C::PLUGIN_YOASTSEO_FILE)){
        $table_name = $wpdb->prefix.C::TABLE_NAME;
        $sql = <<<SQL
CREATE TABLE `{$table_name}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL COMMENT '//unique id of the page',
  `canonical_url` varchar(1000) DEFAULT NULL COMMENT '<link rel="canonical" href="%s">',
  `title` varchar(100) DEFAULT NULL COMMENT '<title>%s</title>',
  `meta_description` varchar(1000) DEFAULT NULL COMMENT '<meta name="description" content="%s">',
  `robots` varchar(200) DEFAULT NULL COMMENT '<meta name="robots" content="%s">',
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_id` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
SQL;
        dbDelta($sql);
    }//if(is_plugin_active(C::PLUGIN_MAIN_FILE)){
    else{
        die(M::ERR_YOASTSEO_MISSING);
    }

}

//Insert script to use bootstrap in control panel
add_action('admin_enqueue_scripts','mte_enqueue_scripts');

function mte_enqueue_scripts(){
    global $home,$plugin_url;
    $bsCss = $home.C::BS_CSS_PATH;
    $bsJs = $home.C::BS_JS_PATH;
    $metaTagCss = $plugin_url.C::PLUGIN_CSS_PATH1;
    $metaTagJsBsDialog = $plugin_url.C::PLUGIN_JS_BSDIALOG;
    $metaTagJsFunc = $plugin_url.C::PLUGIN_JS_FUNCTIONS1;
    $metaTagJsFunc2 = $plugin_url.C::PLUGIN_JS_FUNCTIONS2;
    $metaTagJsMessage = $plugin_url.C::PLUGIN_JS_MESSAGE;
    $metaTagJsMyHttp = $plugin_url.C::PLUGIN_JS_MYHTTP;
    $metaTagJsPage = $plugin_url.C::PLUGIN_JS_PAGE;
    $metaTagJsPages = $plugin_url.C::PLUGIN_JS_PAGELIST;
    $metaTagJsVariables = $plugin_url.C::PLUGIN_JS_VARIABLES;
    $metaTagJs = $plugin_url.C::PLUGIN_JS_PATH1;
    //file_put_contents(C::LOG_FILE,$bsJs."\r\n",FILE_APPEND);
    wp_enqueue_style(C::H_BS_CSS,$bsCss,array(),null);
    wp_enqueue_script(C::BS_JS_PATH,$bsJs,array(),null);
    wp_enqueue_style(C::H_CSS1,$metaTagCss,array(),null);
    wp_register_script(C::H_JS_VARIABLES,$metaTagJsVariables,array(),null);
    wp_register_script(C::H_JS_BSDIALOG,$metaTagJsBsDialog,array(),null);
    wp_register_script(C::H_JS_MESSAGE,$metaTagJsMessage,array(),null);
    wp_register_script(C::H_JS_PAGE,$metaTagJsPage,array(),null);
    wp_register_script(C::H_JS_PAGELIST,$metaTagJsPages,array(),null);
    wp_register_script(C::H_JS_MYHTTP,$metaTagJsMyHttp,array(),null);
    wp_register_script(C::H_JS_FUNCTIONS1,$metaTagJsFunc,array(),null);
    wp_register_script(C::H_JS_FUNCTIONS2,$metaTagJsFunc2,array(),null);
    $hjs1_deps = array(
        C::H_JS_BSDIALOG,
        C::H_JS_FUNCTIONS1,
        C::H_JS_FUNCTIONS2,
        C::H_JS_MESSAGE,
        C::H_JS_MYHTTP,
        C::H_JS_PAGE,
        C::H_JS_PAGELIST,
        C::H_JS_VARIABLES
        );
    wp_enqueue_script(C::H_JS1,$metaTagJs,$hjs1_deps,null);
}

//Print the menu in control panel
add_action('admin_menu','mte_menu');
function mte_menu(){
    add_menu_page(C::MENU_PAGE_TITLE,C::MENU_TITLE,C::MENU_CAPABILITY,C::MENU_SLUG,'mte_main_menu','',C::MENU_POSITION);
}

//HTML for main menu page
function mte_main_menu(){
    //file_put_contents(C::LOG_FILE,H::MAIN_MENU."\r\n",FILE_APPEND);
    echo H::MAIN_MENU;
}

//Get the data of the table that contains meta tags values of pages present
add_action('wp','mte_load_table');
function mte_load_table(){
    //global $mmt;
    global $found,$mmt,$pageFound,$pages,$post;
    if(is_admin() || is_page() || is_single()){
        //If current link is of a page or a article
        //file_put_contents(C::LOG_FILE,"post => ".var_export($post,true)."\r\n",FILE_APPEND);
        try{
            $mmt = new Mmt();
            $get = $mmt->getDataFromDb();
            if($get){
                //Data retrieved from DB
                $pages = $mmt->getPages();
                if($pages !== null){
                    //file_put_contents(C::LOG_FILE,"pages => ".var_export($pages,true)."\r\n",FILE_APPEND);
                    foreach($pages as $n => $page){
                        //loop to find if current post id is found in pages array
                        if($page['page_id'] == $post->ID){
                            $found = true;
                            $pageFound = array(
                                'id' => $page['id'],
                                'page_id' => $page['page_id'],
                                'canonical_url' => $page['canonical_url'],
                                'title' => $page['title'],
                                'meta_description' => $page['meta_description'],
                                'robots' => $page['robots']
                            );
                            //file_put_contents(C::LOG_FILE,"pageFound => ".var_export($pageFound,true)."\r\n",FILE_APPEND);
                            break;
                        }//if($page['page_id'] == $post->ID){
                    }//foreach($pages as $n => $page){
                }//if($pages !== null){
            }//if($get){
        }catch(Exception $e){
            file_put_contents(C::LOG_FILE,"mte_load_table errore => ".$e->getMessage());
        }
    }//if(is_page() || is_single()){
}

//Yoast SEO meta tags filters
add_filter('wpseo_canonical','mte_edit_canonical');
function mte_edit_canonical($canonical){
    global $found, $pageFound;
    if(is_admin() || is_page() || is_single()){
        //If current link is of admin backend, a page or a article
        file_put_contents(C::LOG_FILE,"mte_edit_canonical\r\n",FILE_APPEND);
        //file_put_contents(C::LOG_FILE,"Canonical => {$canonical}\r\n",FILE_APPEND);
        if($found) //current post_id has been found in database
            $canonical = $pageFound['canonical_url'];
    }
    return $canonical;
}

add_filter('wpseo_metadesc','mte_edit_description');
function mte_edit_description($description){
    global $found, $pageFound;
    if(is_admin() || is_page() || is_single()){
        //If current link is of admin backend, a page or a article
        file_put_contents(C::LOG_FILE,"mte_edit_description\r\n",FILE_APPEND);
        //file_put_contents(C::LOG_FILE,"Descrizione => {$description}\r\n",FILE_APPEND);
        if($found) //current post_id has been found in database
            $description = $pageFound['meta_description'];   
    }
    return $description;
}

add_filter('wpseo_robots','mte_edit_robots');
function mte_edit_robots($robots){
    global $found, $pageFound;
    if(is_admin() || is_page() || is_single()){
        //If current link is of admin backend, a page or a article
        file_put_contents(C::LOG_FILE,"mte_edit_robots\r\n",FILE_APPEND);
        //file_put_contents(C::LOG_FILE,"Robots => {$robots}\r\n",FILE_APPEND);
        if($found) //current post_id has been found in database
            $robots = $pageFound['robots'];
    }
    return $robots;
}

add_filter('wpseo_title','mte_edit_title');
function mte_edit_title($title){
    global $found, $pageFound;
    if(is_admin() || is_page() || is_single()){
        //If current link is of admin backend, a page or a article
        file_put_contents(C::LOG_FILE,"mte_edit_title\r\n",FILE_APPEND);
        //file_put_contents(C::LOG_FILE,"Titolo => {$title}\r\n",FILE_APPEND);
        if($found) //current post_id has been found in database
            $title = $pageFound['title'];
    }
    return $title;
}
?>