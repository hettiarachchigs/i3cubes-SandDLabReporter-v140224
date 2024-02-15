<?php

include_once('../class/employeeManager.php');
include_once '../class/employee.php';

$txt = $_REQUEST['term'];
$type = $_REQUEST['type'];

$emp_mgr = new employeeManager();
$emp = new \employee();

$ary_emp = $emp_mgr->searchEmployeedetail('', $txt, "", "", "", "", "", "", "", "");
foreach ($ary_emp as $emp) {
    if ($emp->status == "0") {
        
    } else {
        $json[] = array(
            'id' => $emp->id,
            'value' => $emp->name
        );
    }
}
print json_encode($json);
?>