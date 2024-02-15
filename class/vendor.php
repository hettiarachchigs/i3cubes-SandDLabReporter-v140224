<?php

include_once 'database.php';
include_once 'constants.php';

class vendor {

    public $id, $name, $address, $contact, $note, $status;

    function __construct($id = '') {
        $this->id = $id;
    }

    function getVendor() {
        $quer = "SELECT * from vendor where id=" . $this->id . " ";
        //print $quer;
        $result = dbQuery($quer);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->address = $row['address'];
            $this->contact = $row['contact'];
            $this->note = $row['note'];
            $this->status = $row['status'];
            return true;
        } else {
            return false;
        }
    }

    function add($name, $address, $contact, $note) {
        $name = getStringFormatted($name);
        $address = getStringFormatted($address);
        $contact = getStringFormatted($contact);
        $note = getStringFormatted($note);

        $quer = "Insert into vendor "
                . "(name,address,contact,note,status)"
                . " values (" . $name . "," . $address . "," . $contact . "," . $note . "," . constants::$Active_STE . ")";

        $result = dbQuery($quer);
        if ($result) {
            return dbInsertId(); //get last insertid 
        } else {
            return(false);
        }
    }

    function edit($name, $address, $contact, $note) {

        $name = getStringFormatted($name);
        $address = getStringFormatted($address);
        $contact = getStringFormatted($contact);
        $note = getStringFormatted($note);
        

        $str = "UPDATE vendor set  name=$name,address=$address,contact=$contact,"
                . "note=$note where id='$this->id'";
        //print $str;
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    
    public function delete() {
        $str = "UPDATE vendor set status='" . constants::$Deleted_STE . "' where id='$this->id'";
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>
