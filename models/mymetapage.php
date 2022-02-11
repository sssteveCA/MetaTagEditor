<?php

use MmpErrors as Mmp;
use Constants as C;

//This model communicate with mySql table of pages that have custom meta tags edited by the plugin
class MyMetaPage implements MmpErrors, Constants{

    private $canonical_url; //href of link rel canonical
    private $errno; //error code
    private $error; //error message
    private $id; //Primary key
    private $meta_description; //content of meta name description
    private $page_id; //Unique id of the page
    private $queries; //SQL collection of queries executed in last script
    private $query; //last SQL query sent
    private $robots; //content of meta name robots
    private $table; //MySql table used by this class
    private $title; //page <title>
    private $wpdb; //Wordpress database instance

    public function __construct($dati)
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table = isset($dati['table']) ? $this->wpdb->prefix.$dati['table'] : $this->wpdb->prefix.C::TABLE_NAME;
        if(!$this->tableExists()){
            //table specified doesn't exists
            throw new Exception(Mmp::MSG_TABLENOTEXISTS);
        }
        $this->id = isset($dati['id']) ? $dati['id'] : null;
        $this->meta_description = isset($dati['meta_description']) ? $dati['meta_description'] : null;
        $this->page_id = isset($dati['page_id']) ? $dati['page_id'] : null;
        $this->robots = isset($dati['robots']) ? $dati['robots'] : null;
        $this->title = isset($dati['title']) ? $dati['title'] : null;
        $this->errno = 0;
        $this->error = null;
        $this->queries = array();
        $this->query = null;
    }

    public function getCanonicalUrl(){return $this->canonical_url;}
    public function getErrno(){return $this->errno;}
    public function getError(){return $this->error;}
    public function getId(){return $this->id;}
    public function getMetaDescription(){return $this->meta_description;}
    public function getPageId(){return $this->page_id;}
    public function getQuery(){return $this->query;}
    public function getQueries(){return $this->queries;}
    public function getRobots(){return $this->robots;}
    public function getTitle(){return $this->title;}

    //check if MySql table exists before proceed
    private function tableExists(){
        $exists = false;
        $this->query = <<<SQL
SHOW TABLES LIKE `{$this->table}`;
SQL;
        $table = $this->wpdb->get_var($this->query);
        if($table != null)$exists = true;
        else $exists = false;
        return $exists;
    }
}
?>