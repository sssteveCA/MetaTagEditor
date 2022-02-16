<?php

namespace MetaTagEditor\Models;

use MetaTagEditor\Interfaces\MmpErrors as Mmp;
use MetaTagEditor\Interfaces\Constants as C;

//This model communicate with mySql table of pages that have custom meta tags edited by the plugin
class MyMetaPage implements Mmp, C{

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
            throw new \Exception(Mmp::MSG_TABLENOTEXISTS);
        }
        $this->id = isset($dati['id']) ? $dati['id'] : null;
        $this->canonical_url = isset($dati["canonical_url"]) ? $dati["canonical_url"] : null;
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
    public function getError(){
        switch($this->errno){
            case Mmp::ERR_MISSEDREQPARAMS:
                $this->error = Mmp::MSG_MISSEDREQPARAMS;
                break;
            case Mmp::ERR_NORESULTS:
                $this->error = Mmp::MSG_NORESULTS;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }
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
SHOW TABLES LIKE '{$this->table}';
SQL;
        $this->queries[] = $this->query;
        $table = $this->wpdb->get_var($this->query);
        if($table != null)$exists = true;
        else $exists = false;
        return $exists;
    }

    //retrieve a row with meta tags by specifing primary key
    public function getMetaById(){
        $ok = false; //true if operations have success
        $this->errno = 0;
        if(isset($this->id)){
            $this->query = <<<SQL
SELECT * FROM `{$this->table}` WHERE `id` = '{$this->id}';
SQL;
            $this->queries[] = $this->query;
            $metas = $this->wpdb->get_row($this->query);
            if($metas != null){
                //Results found
                $this->page_id = $metas->page_id;
                $this->canonical_url = $metas->canonical_url;
                $this->title = $metas->title;
                $this->meta_description = $metas->meta_description;
                $this->robots = $metas->robots;
                $ok = true;
            }//if($metas != null){
            else
                $this->errno = Mmp::ERR_NORESULTS;
        }//if(isset($this->id)){
        else
            $this->errno = Mmp::ERR_MISSEDREQPARAMS;
        return $ok;
    }

    //retrieve a row with meta tags by specifing unique page id
    public function getMetaByPageId(){
        $ok = false; //true if operations have success
        $this->errno = 0;
        if(isset($this->page_id)){
            $this->query = <<<SQL
SELECT * FROM `{$this->table}` WHERE `page_id` = '{$this->page_id}';
SQL;
            $this->queries[] = $this->query;
            $metas = $this->wpdb->get_row($this->query);
            if($metas != null){
                //Results found
                $this->id = $metas->id;
                $this->canonical_url = $metas->canonical_url;
                $this->title = $metas->title;
                $this->meta_description = $metas->meta_description;
                $this->robots = $metas->robots;
                $ok = true;
            }//if($metas != null){
            else
                $this->errno = Mmp::ERR_NORESULTS;
        }//if(isset($this->page_id)){
        else
            $this->errno = Mmp::ERR_MISSEDREQPARAMS;
        return $ok;
    }

    //get meta tags of page from Yoast Server
    public function getMetaByUrlFromYoast(){
        $ok = false;
        $this->errno = false;
        if(isset($this->canonical_url)){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, C::YOAST_RESTAPI_URL.$this->canonical_url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch,CURLOPT_TIMEOUT, 20);
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch,CURLOPT_MAXREDIRS,10);
            $result = curl_exec($ch);
            curl_close($ch);
            file_put_contents(C::LOG_FILE,"\r\n\r\n{$result}\r\n",FILE_APPEND);
            $ok = true;
        }//if(isset($this->canonical_url)){
        else
            $this->errno = Mmp::ERR_MISSEDREQPARAMS;
        return $ok;
    }
}
?>