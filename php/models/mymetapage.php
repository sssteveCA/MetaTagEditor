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
    //check if properties match with these patterns
    private static $regex = array(
        'id' => '/^[0-9]+$/', //only numbers
        'page_id' => '/^[0-9]+$/', //only numbers
        'canonical_url' => '/^\/([a-zA-Z0-9_-]+\/){0,}[a-zA-Z0-9_-]+\/?$/', //realtive URL
        'title' => '/^(?!\s*$).+$/', //at least one character except blanks
        'meta_description' => '/^(?!\s*$).+$/', //at least one character except blanks
        'robots' => '/^(?!\s*$).+$/'
    );
    private static $logFile = "log.txt";

    public function __construct($dati)
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->query = null;
        $this->queries = array();
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
            case Mmp::ERR_ID_NOTMATCH:
                $this->error = Mmp::MSG_ID_NOTMATCH;
                break;
            case Mmp::ERR_PAGEID_NOTMATCH: 
                $this->error = Mmp::MSG_PAGEID_NOTMATCH;
                break;
            case Mmp::ERR_CANONICALURL_NOTMATCH:
                $this->error = Mmp::MSG_CANONICALURL_NOTMATCH;
                break;
            case Mmp::ERR_TITLE_NOTMATCH:
                $this->error = Mmp::MSG_TITLE_NOTMATCH; 
                break;
            case Mmp::ERR_METADESCRIPTION_NOTMATCH: 
                $this->error = Mmp::MSG_METADESCRIPTION_NOTMATCH;
                break;
            case Mmp::ERR_ROBOTS_NOTMATCH: 
                $this->error = Mmp::MSG_ROBOTS_NOTMATCH;
                break;
            case Mmp::ERR_QUERYERROR: 
                $this->error = Mmp::MSG_QUERYERROR;
                break;
            case Mmp::ERR_NOROWSAFFECTED:
                $this->error = Mmp::MSG_NOROWSAFFECTED;
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

    //delete a row of the table with id passed
    public function deleteMetaById(){
        $ok = false;
        $this->errno = 0;
        if(isset($this->id)){
            if(preg_match(MyMetaPage::$regex["id"],$this->id)){
                $ar = $this->wpdb->delete($this->table,array('id' => $this->id),array('%d'));
                $this->query = $this->wpdb->last_query;
                $this->queries[] = $this->query;
                if($ar !== false){
                    //Query don't has errors
                    if($ar > 0){
                        //One or more rows updated
                        $ok = true;
                    }
                    else
                        $this->errno = Mmp::ERR_NOROWSAFFECTED;
                }//if($ar !== false){
                else
                    $this->errno = Mmp::ERR_QUERYERROR;
            }//if(preg_match(MyMetaPage::$regex["id"],$this->id)){
            else
                $this->errno = Mmp::ERR_ID_NOTMATCH;
        }//if(isset($this->id)){
        else
            $this->errno = Mmp::ERR_MISSEDREQPARAMS;
        return $ok;
    }

    //delete a row of the table with page id passed
    public function deleteMetaByPageId(){
        $ok = false;
        $this->errno = 0;
        if(isset($this->page_id)){
            if(preg_match(MyMetaPage::$regex["page_id"],$this->page_id)){
                $ar = $this->wpdb->delete($this->table,array('page_id' => $this->page_id),array('%d'));
                $this->query = $this->wpdb->last_query;
                $this->queries[] = $this->query;
                if($ar !== false){
                    //Query don't has errors
                    if($ar > 0){
                        //One or more rows updated
                        $ok = true;
                    }
                    else
                        $this->errno = Mmp::ERR_NOROWSAFFECTED;
                }//if($ar !== false){
                else
                    $this->errno = Mmp::ERR_QUERYERROR;
            }//if(preg_match(MyMetaPage::$regex["page_id"],$this->page_id)){
            else
                $this->errno = Mmp::ERR_PAGEID_NOTMATCH;
        }//if(isset($this->id)){
        else
            $this->errno = Mmp::ERR_MISSEDREQPARAMS;
        return $ok;
    }

    //Insert or update a row of meta tag table
    public function editPageMeta(){
        $ok = false;
        $this->errno = 0;
        if($this->editValidation()){
            //validation passed
            //concatenate root URL to relative path of page
            $this->canonical_url = get_home_url().$this->canonical_url;
            file_put_contents(MyMetaPage::$logFile,"full canonical => {$this->canonical}\r\n",FILE_APPEND);
            $sql = <<<SQL
INSERT INTO `{$this->table}` (`page_id`,`canonical_url`,`title`,`meta_description`,`robots`)
VALUES (%d,%s,%s,%s,%s)
ON DUPLICATE KEY UPDATE `canonical_url`= %s,`title`= %s,`meta_description`= %s,`robots`= %s;
SQL;
            $this->query = $this->wpdb->prepare($sql,$this->page_id,$this->canonical,$this->title,$this->meta_description,$this->robots,
                            $this->canonical,$this->title,$this->meta_description,$this->robots);
            $affected_rows = $this->wpdb->query($this->query);
            if($affected_rows !== false){
                if($affected_rows > 0){
                    $ok = true;
                }//if($affected_rows > 0){
                else
                    $this->errno = Mmp::ERR_NOROWSAFFECTED;
            }//if($affected_rows !== false){
            else
                $this->errno = Mmp::ERR_QUERYERROR;
            $this->queries[] = $this->query;
        }//if($this->editValidation()){
        return $ok;
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
            curl_setopt($ch, CURLOPT_URL, get_home_url().C::YOAST_RESTAPI_URL.$this->canonical_url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch,CURLOPT_TIMEOUT, 20);
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch,CURLOPT_MAXREDIRS,10);
            $result = curl_exec($ch);
            curl_close($ch);
            $json = json_decode($result,true,100,JSON_THROW_ON_ERROR);
            //file_put_contents(C::LOG_FILE,"\r\n\r\n".var_export($json["json"],true)."\r\n",FILE_APPEND);
            $this->robots = implode(",",$json["json"]["robots"]);
            $this->meta_description = $json["json"]["og_description"];
            $this->title = $json["json"]["og_title"];
            $ok = true;
        }//if(isset($this->canonical_url)){
        else
            $this->errno = Mmp::ERR_MISSEDREQPARAMS;
        return $ok;
    }

    //Validate properties before edit the database
    private function editValidation(){
        $valid = true;
        $this->errno = 0;
        if(isset($this->page_id,$this->canonical_url,$this->title,$this->meta_description,$this->robots)){
            if(!preg_match(MyMetaPage::$regex['page_id'],$this->page_id)){
                $valid = false;
            }
            if(!preg_match(MyMetaPage::$regex['canonical_url'],$this->canonical_url)){
                $valid = false;
            }
            if(!preg_match(MyMetaPage::$regex['title'],$this->title)){
                $valid = false;
            }
            if(!preg_match(MyMetaPage::$regex['meta_description'],$this->meta_description)){
                $valid = false;
            }
            if(!preg_match(MyMetaPage::$regex['robots'],$this->robots)){
                $valid = false;
            }
        }//if(isset($this->page_id,$this->canonical_url,$this->title,$this->meta_description,$this->robots)){
        else{
            $this->errno = Mmp::ERR_MISSEDREQPARAMS;
            $valid = false;
        }
        return $valid;
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