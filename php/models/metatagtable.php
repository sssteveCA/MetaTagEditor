<?php

namespace MetaTagEditor\Models;

use MetaTagEditor\Interfaces\MmtErrors as Mmt;
use MetaTagEditor\Models\MyMetaPage as Page;
use MetaTagEditor\Interfaces\Constants as C;

//This class is used to retrive the entire meta tag table content
class MetaTagTable implements Mmt{

    private $table;
    private $wpdb;
    private $pages; //MyMetaPage result collection
    private $query; //Last SQL query sent
    private $queries; //List of SQL queries executed
    private $errno;
    private $error;

    public function __construct($dati){
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->query = null;
        $this->queries = array();
        $this->table = isset($dati["table"]) ? $dati["table"] : $this->wpdb->prefix.C::TABLE_NAME;
        if(!$this->tableExists()){
            //table specified doesn't exists
            throw new \Exception(Mmt::MSG_TABLENOTEXISTS);
        }
        $this->errno = 0;
        $this->error = null;
        $this->pages = null;
    }

    public function getTable(){return $this->table;}
    public function getQuery(){return $this->query;}
    public function getPages(){return $this->pages;}
    public function getErrno(){return $this->errno;}
    public function getError(){
        switch($this->errno){
            case Mmt::ERR_NORESULTS:
                $this->error = Mmt::MSG_NORESULTS;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }

    //Retrieve all table content
    public function getDataFromDb(){
        $ok = false;
        $this->errno = 0;
        $this->query = <<<SQL
SELECT * FROM `{$this->table}`;
SQL;
        $this->queries[] = $this->query;
        $this->pages = $this->wpdb->get_results($this->query,ARRAY_A);
        if($this->pages !== null){
            $ok = true;
        }//if($result !== null){
        else
            $this->errno = Mmt::ERR_NORESULTS;
        return $ok;
    }

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
}
?>