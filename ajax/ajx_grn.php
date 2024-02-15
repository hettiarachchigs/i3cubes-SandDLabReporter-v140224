<?php

include_once '../class/grn.php';
include_once '../class/grnManager.php';
include_once '../class/cls_log.php';
include_once '../class/ngs_date.php';
//include_once '../class/system.php';
session_start();

$grn = new grn();
$log = new log();
/*
  $log_file="test.txt";
  $str=date("Y-m-d H:i:s")." || {".implode(",",array_keys($_REQUEST))."} -- {".implode(",",$_REQUEST)."}";
  if ($file=fopen($log_file, "a+")) {
  fputs($file,"$str \n");
  fclose($file);
  }
  else {
  }
 */
$sid = $_REQUEST['SID'];
switch ($sid) {
    case '10':
        $grn->shipment_id = $_POST['shipment_id'];
        $grn->vendor_id = $_POST['supplier_id'];
        $grn->effective_date = $_POST['date'];
        $grn->emp_added = $_POST['emp_id'];
        $grn->note = $_POST['note'];
        $grn->customer_entity_id=$_POST['location'];
        $grn->fault_ticket_id=$_POST['ft_id'];
        $grn_id = $grn->addGRN();
        $rsp = array("result" => 1, "grn_id" => $grn->id, "grn_no" => $grn->ref_no);
        break;
    case '13'://update grn
        $Grn = new grn($_POST['grn_id']);
        $Grn->getGRN();
        $Grn->shipment_id = $_POST['shipment_id'];
        $Grn->vendor_id = $_POST['supplier_id'];
        $Grn->effective_date = $_POST['date'];
        $Grn->emp_added = $_POST['emp_id'];
        $Grn->note = $_POST['note'];
        $Grn->customer_entity_id=$_POST['location'];
        $res = $Grn->editGRN();
        if ($res == "1") {
            $rsp = array("result" => 1, "grn_id" => $Grn->id);
        } else {
            $rsp = array("result" => 0, "grn_id" => $Grn->id); //error
        }

        break;
    case '11'://add item
        $d = new ngs_date();
        $grn = new grn($_POST['grn_id']);
        $grn->getGRN();

        $grnmanger = new grnManager();
        $serial_exists = $grnmanger->isSerialAvailable($_POST['serial']);

        if($_POST['qty']==''){
            $qty=1;
        }
        else{
            $qty=$_POST['qty'];
        }

        if (!$serial_exists) {
            $item_id = $grn->addGRNItem($_POST['grn_id'], $_POST['prd_id'], $_POST['serial'],$_POST['part_no'], $grn->customer_entity_id, $_POST['warranty'], $_POST['price'], $qty);
            $rsp = array("result" => 1, "item_id" => $item_id);
        } else {
            $rsp = array("result" => 2, "serial" => $_POST['serial'],"message"=>"Serial nuber already in system");
        }
        break;
    case "12":
        $grn = new grn($_POST['grn_id']);
        $res = $grn->deleteGRNItem($_POST['item_id']);
        if ($res) {
            $rsp = array("result" => 1);
        } else {
            $rsp = array("result" => 0);
        }
        break;
    case 202://update warranty and cost
        $obj=$_POST['obj'];
        //print_r(count($obj));
        if(count($obj)>0){
            foreach ($obj AS $key=>$val){
                $warranty = $val['warranty_period'];
                $cost = $val['cost'];
                $upd = $grn->updateWarrantyandCost($warranty, $cost, $key);
            }
            $rsp = array("result" => 1);
        }else {
            $rsp = array("result" => 0);
        }
         
        break;
    default :
        break;
}
echo json_encode($rsp);
?>