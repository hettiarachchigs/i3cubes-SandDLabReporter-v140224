<?php

include_once 'database.php';

class logs {
    public $id,$module,$ref_id,$log,$date_time;
    
    public function __construct($id="") {
        $this->id = $id;
    }
    
    public function save() {
        $module = getStringFormatted($this->module);
        $ref_id = getStringFormatted($this->ref_id);
        $log = getStringFormatted($this->log);
        $date_time = getStringFormatted(date("Y-m-d H:i:s"));
        
        $string = "INSERT INTO `logs` (`module`,`ref_id`,`log`,`date_time`) VALUES ($module,$ref_id,$log,$date_time);";
        $result = dbQuery($string);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getData() {
        $string = "SELECT * FROM `logs` WHERE `id` = $this->id;";
        $result = dbQuery($string);
        $row = dbFetchAssoc($result);
        $this->id = $row['id'];
        $this->module = $row['module'];
        $this->ref_id = $row['ref_id'];
        $this->log = $row['log'];
        $this->date_time = $row['date_time'];
    }
    function fileWrite($filename,$content){
        $filename = "../response/".$filename;
    if (!is_file($filename)) {
        $myfile = fopen($filename, "w", 755);
    }
    if (file_put_contents($filename, $content, FILE_APPEND)) {
      // echo 1;
    } else {
        // echo 0;
    }
        
    }
    
}

?>