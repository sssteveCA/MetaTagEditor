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
require_once(ABSPATH.'wp-admin/includes/upgrade.php');

use MetaTagEditor\Interfaces\Constants as C;
use MetaTagEditor\Interfaces\Html as H;
use MetaTagEditor\Interfaces\Messages as M;

$home = get_home_url();
$plugin_url = plugins_url();

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
    $metaTagJsMyHttp = $plugin_url.C::PLUGIN_JS_MYHTTP;
    $metaTagJs = $plugin_url.C::PLUGIN_JS_PATH1;
    //file_put_contents(C::LOG_FILE,$bsJs."\r\n",FILE_APPEND);
    wp_enqueue_style(C::H_BS_CSS,$bsCss,array(),null);
    wp_enqueue_style(C::BS_JS_PATH,$bsJs,array(),null);
    wp_enqueue_style(C::H_CSS1,$metaTagCss,array(),null);
    wp_enqueue_script(C::H_JS_MYHTTP,$metaTagJsMyHttp,array(),null);
    wp_enqueue_script(C::H_JS1,$metaTagJs,array(C::H_JS_MYHTTP),null);
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

//add tag to <script>
add_filter('script_loader_tag','mte_add_tags',10,3);
function mte_add_tags($tag,$handle,$src){
    file_put_contents(C::LOG_FILE,"mte_add_tags\n",FILE_APPEND);
    if($handle == C::H_JS_MYHTTP){ //This is Js MyHttp class that must be imported
        //$tag = '<script type="module" src="'.esc_url($src).'"></script>';
    }//if($handle != ''){
    if($handle == C::H_JS1){
        //$tag = '<script type="module" src="'.esc_url($src).'"></script>';
    }
    return $tag;
}

//Yoast SEO meta tags filters
add_filter('wpseo_canonical','mte_edit_canonical');
function mte_edit_canonical($canonical){
    file_put_contents(C::LOG_FILE,"mte_edit_canonical\r\n",FILE_APPEND);
    file_put_contents(C::LOG_FILE,"Canonical => {$canonical}\r\n",FILE_APPEND);
    return $canonical;
}

add_filter('wpseo_metadesc','mte_edit_description');
function mte_edit_description($description){
    file_put_contents(C::LOG_FILE,"mte_edit_description\r\n",FILE_APPEND);
    file_put_contents(C::LOG_FILE,"Descrizione => {$description}\r\n",FILE_APPEND);
    return $description;
}

add_filter('wpseo_robots','mte_edit_robots');
function mte_edit_robots($robots){
    file_put_contents(C::LOG_FILE,"mte_edit_robots\r\n",FILE_APPEND);
    file_put_contents(C::LOG_FILE,"Robots => {$robots}\r\n",FILE_APPEND);
    return $robots;
}

add_filter('wpseo_tile','mte_edit_title');
function mte_edit_title($title){
    file_put_contents(C::LOG_FILE,"mte_edit_title\r\n",FILE_APPEND);
    file_put_contents(C::LOG_FILE,"Titolo => {$title}\r\n",FILE_APPEND);
    return $title;
}
?>