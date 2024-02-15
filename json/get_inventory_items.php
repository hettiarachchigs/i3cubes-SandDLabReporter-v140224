<?php

include_once('../class/database.php');
include_once('../class/constants.php');
include_once '../class/cls_stock_manager.php'; 


$txt = trim($_REQUEST['term']);
$cus_id = $_REQUEST['cus_id'];
$option = $_REQUEST['option'];
$sts = $_REQUEST['status'];

$stock_mgr=new stock_manager();

if ($sts != "" && $sts != "0") {
    $where = "  t1.status='" . $sts . "'";
}
if ($option == 'serial') {
    if ($sts != "0") {
        $where .= " AND t1.customer_entity_id='$cus_id' AND t1.serial like '%" . trim($txt) . "%' ";
    } else {
        $where .= " t1.customer_entity_id='$cus_id' AND t1.serial like '%" . trim($txt) . "%' ";
    }
} else {
    if ($sts != "" && $sts != "0") {
        $where .= " AND t1.customer_entity_id='$cus_id' AND  (t2.product_code like '%" . $txt . "%' OR t2.description like '%" . $txt . "%') ";
    } else {
        $where = " t1.customer_entity_id='$cus_id' AND  (t2.product_code like '%" . $txt . "%' OR t2.description like '%" . $txt . "%') ";
    }
}

if ($sts == "0") {
//    $limit = " AND t1.status IN ('" . constants::$SYS_ACTIVE . "','" . constants::$STN_CONF . "') LIMIT 100";
    $limit = "  LIMIT 100";
}

$str = "SELECT t1.*,t2.product_code,t2.description,t2.type FROM customer_systems as t1 left join systems as t2 on t1.systems_id=t2.id WHERE $where $limit;";

//echo $str;

$result = dbQuery($str);
$response = array();
$i = 0;
while ($row = dbFetchAssoc($result)) {
    //print_r($row);
    if ($option != 'serial') {
        $lable = $row['product_code'] == "" ? "" : "[" . $row['product_code'] . "]";
        $lable .= $row['description'];
        $lable .= $row['serial'] == "" ? "" : "{" . $row['serial'] . "}";
    } else {
        $details = $row['product_code'] == "" ? "" : "[" . $row['product_code'] . "]";
        $details .= $row['description'];
        $details .= $row['serial'] == "" ? "" : "{" . $row['serial'] . "}";
        $lable = $row['product_code'] == "" ? "" : "[" . $row['product_code'] . "]";
        $lable .= $row['serial'] == "" ? "" : " " . $row['serial'] . " ";
    }
    if ($row['type'] == "I" && ($row['status'] != constants::$SYS_IN_STN)) {
        if( $row['status'] == constants::$SYS_IN_JO){
            
        }else {
        $json[] = array(
            'id' => $row['id'],
            'value' => $lable,
            'label' => $lable,
            'details' => $details,
            'serial' => $row['serial'],
            'description' => $row['description'],
            'type' => $row['type'],
            'systems_id'=>$row['systems_id']
        );
        }
    }
}

/// NON Inventory Items
$where = " t1.customer_entity_id='$cus_id' AND  (t2.product_code like '%" . $txt . "%' OR t2.description like '%" . $txt . "%') ";
$str="SELECT * FROM systems_stock as t1 left join systems as t2 on t1.systems_id=t2.id WHERE ".$where;
//print $str;
$result = dbQuery($str);
while ($row = dbFetchAssoc($result)) {
    $details = $row['product_code'] == "" ? "" : "[" . $row['product_code'] . "]";
    $details .= $row['description'];
    //$details .= $row['serial'] == "" ? "" : "{" . $row['serial'] . "}";
    $lable = $row['product_code'] == "" ? "" : "[" . $row['product_code'] . "]";
   // $lable .= $row['serial'] == "" ? "" : " " . $row['serial'] . " ";
    $lable .= $row['description'];
    $stock_in_stn=$stock_mgr->stockInUnconfirmedSTN($cus_id, $row['id']);
    $stock_in_stn>0?$stock_bal_str=$row['balance']."  (STN:".$stock_in_stn.")":$stock_bal_str=$row['balance'];
    //$stock_bal_str=$row['balance']."  (IN STN:".$stock_in_stn.")";
    $stock_bal=$row['balance']-$stock_in_stn;
    if ($row['type'] == "C" && $row['balance'] > 0) {
        $json[] = array(
            'id' => $row['id'],
            'value' => $lable,
            'label' => $lable,
            'details' => $details,
            'serial' => $row['serial'],
            'description' => $row['description'],
            'type' => $row['type'],
            'balance' => $stock_bal,
            'balance_string' => $stock_bal_str,
            'systems_id'=>$row['systems_id']
        );
    }
}
print json_encode($json);
?>