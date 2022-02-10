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
require_once(ABSPATH.'wp-admin/includes/upgrade.php');

//When plugin is activated
register_activation_hook(__FILE__, 'mte_activator');

function mte_activator(){
    global $wpdb;
    file_put_contents(Constants::LOG_FILE,"mte_activator\r\n",FILE_APPEND);
    $table_name = $wpdb->prefix.Constants::TABLE_NAME;
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
}
?>