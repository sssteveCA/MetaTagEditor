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


require_once('interfaces/constants.php');
require_once('interfaces/html.php');
require_once('interfaces/messages.php');
require_once(ABSPATH.'wp-admin/includes/upgrade.php');

use Constants as C;
use Html as H;
use Messages as M;

$home = get_home_url();

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
`canonical_url` varchar(1000) DEFAULT NULL,
`title` varchar(100) NOT NULL,
`meta_tags` varchar(10000) NOT NULL COMMENT '//custom meta tags edited from user',
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
    global $home;
    $bsCss = $home.C::BS_CSS_PATH;
    $bsJs = $home.C::BS_JS_PATH;
    $metaTagCss = plugins_url().C::PLUGIN_CSS_PATH1;
    //file_put_contents(C::LOG_FILE,$bsJs."\r\n",FILE_APPEND);
    wp_enqueue_style('bootstrapCss',$bsCss,array(),null);
    wp_enqueue_style('bootstrapJs',$bsJs,array(),null);
    wp_enqueue_style('metaTagStyle',$metaTagCss,array(),null);

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
?>