<?php

include_once 'database.php';
include_once 'branch.php';
include_once 'constants.php';
include_once 'customerEntity.php';

class customer extends customerEntity{

    function __construct($id = '') {
        parent::__construct($id);
    }
    function getCustomer() {
        parent::getData();
    }


    function addCustomer($name, $address, $code, $contact_name, $mobile, $email, $note, $acc_owner_id, $gourpID,$cluster,$type,$district,$vendor_id) {
        $res= parent::add($name, $address, $code, $contact_name, $mobile, $email, $note, $acc_owner_id, $gourpID,'CUS','',$cluster,$type,$district,$vendor_id);
        return $res;
    }

    function editCustomer($name, $address, $code, $contactname, $mobile, $email, $note, $acc_owner_id, $gourpID,$cluster,$type,$district) {
        return parent::edit($name, $address, $code, $contactname, $mobile, $email, $note, $acc_owner_id, $gourpID,$cluster,$type,$district);

    }

    public function deleteCustomer() {
        return parent::delete();
    }
    public function getAllEquipments() {
        parent::getAllEquipments();
    }
    public function getAllBranches(){
        $ary_res = array();
        $str="SELECT t1.*,t2.name as team_name,t3.cluster as cluster_name FROM customer_entity as t1 left join team as t2 on t1.team_id=t2.id "
                . "left join customer_cluster as t3 on t1.cluster=t3.id WHERE t1.parent_id='$this->id' AND t1.Status<>'".constants::$Deleted_STE."';";
        //print $str;
        $result= dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            $br=new branch($row['id']);
            $br->name = $row['name'];
            $br->address = $row['address'];
            $br->code = $row['code'];
            $br->contactName = $row['contact_name'];
            $br->contactNumber = $row['contact_number'];
            $br->contactEmail = $row['contact_email'];
            $br->note = $row['note'];
            $br->accOwnerID = $row['acc_owner_id'];
            $br->teamID = $row['team_id'];
            $br->teamName=$row['team_name'];
            $br->status = $row['status_id'];
            $br->cluster=$row['cluster'];
            $br->clusterName=$row['cluster_name'];
            $br->br_site_id=$row['br_site_id'];
            
            array_push($ary_res, $br);
        }
        return $ary_res;
    }
    public function getAllBranchIDs(){
        $ary_res = array();
        $str="SELECT id FROM customer_entity WHERE parent_id='$this->id';";
        $result= dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            array_push($ary_res, $row['id']);
        }
        return $ary_res;
    }
    public function getTeam() {
        return parent::getTeam();
    }

    public function getContractCoverage(){
        $ary_contract= parent::getContractCoverage();
        return $ary_contract;
    }
    public function getLastExpired(){
        $ary_contract= parent::getLastExpired();
        return $ary_contract;
    }
}
?>

