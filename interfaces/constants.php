<?php

interface Constants{
    //Name of database table(without prefix)
    const TABLE_NAME = "meta_tag_editor";
    const LOG_FILE = ABSPATH."/log.txt";
    
    //menu
    const MENU_TITLE = "Modifica meta tag";
    const MENU_PAGE_TITLE = "Meta tag editor";
    const MENU_CAPABILITY = "administrator";
    const MENU_SLUG = 'meta-tag-editor';
    const MENU_POSITION = 1;

}
?>