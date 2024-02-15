<?php
//include_once('../class/database.php');
include_once '../class/amc.php';
include_once '../class/warranty.php';
include_once '../class/equipment.php';
include_once '../class/branch.php';
include_once '../class/customer.php';
include_once '../class/amc_manager.php';
include_once '../class/cls_systemManager.php';
$sys_manager = new systemManager();
$txt=$_REQUEST['term'];
$cus_id=$_REQUEST['cus_id'];
$br_id=$_REQUEST['br_id'];
$eq_id=$_REQUEST['eq_id'];
$serial=$_REQUEST['serial'];
if($cus_id==''){
	$cus_id='null';
}
if($br_id==''){
	$br_id=null;
}

if($eq_id!=''){
    //EQ contract coverage
    $marched_to="Equipment";
}
else if($br_id!=''){
   
}
else if($cus_id!=''){
    //$cus=new customer($cus_id);
    //$ary_contracts=$cus->getContractCoverage();
    //$ary_contracts_exp=$cus->getLastExpired();
    //$marched_to="Customer";
    $invItemsDetails = $sys_manager->serachFullInventory($serial, "", $cus_id);
}
$amc=new \amc();
//print_r($invItemsDetails);
$i=0;

if((count($invItemsDetails))>0){
	echo "
            <table id='tbl_ft_amc' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 90%;' >
             <thead>
                <tr>	   
                <th data-hide='phone'>Code</th>
                <th data-hide='phone'>Description</th>
                <th data-hide='phone'>Serial</th>
                <th data-hide='phone'>Qty</th>
                <th data-hide='phone'>Cus-Warranty-End</th>
                <th data-hide='phone'>vendor-Warranty-End</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($invItemsDetails as $row){
                $id = $row['id'];
                $product_code = $row['product_code'];
                $description = $row['description'];
                $serial = $row['serial'];
                $qty = $row['qty'];
                $customer_warranty_end = $row['customer_warranty_end'];
                $vendor_warranty_end = $row['vendor_warranty_end'];
                echo "
                    <tr id=".'"'.$id.'" class="ngs-popup-amc"'." style='font-size: 85%;cursor: pointer;'>
                      <td>" . $product_code . "</td>
                      <td>" . $description . "</td>
                      <td>$serial</td>
                      <td>" . $qty . "</td>
                      <td>" . $customer_warranty_end . "</td>
                      <td>" . $vendor_warranty_end . "</td>
                    </tr>";
            }
            
	print '</tbody>
		</table>';
}
else{
	print "<div style='text-align: center;margin-top: 20px;'>
                    <span class='ngs_failure_span'>
                    <i class='fa fa-exclamation-triangle'></i>&nbsp;&nbsp;NO Product Details For Serial $serial.
                    </span>
                </div>";
}
?>