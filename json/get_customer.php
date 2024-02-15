<?php

include_once '../class/database.php';


$txt = $_REQUEST['term'];
$type = $_REQUEST['type'];
$exclude = $_REQUEST['exclude'];

$str = "call search_customer('$txt','$type');";
//print $str;
$result = dbQuery($str);
$response = array();
$i = 0;
while ($row = dbFetchAssoc($result)) {
    if($exclude!=$row['id']){
        $json[] = array(
            'id' => $row['id'],
    //        'value' => $row['cus_type'] . "-" . $row['name'] . "[" . $row['area'] . "]-" . $row['code'] . " {" . $row['team'] . "} -- " . $row['address'],
    //        'label' => $row['cus_type'] . "-" . $row['name'] . "[" . $row['area'] . "]-" . $row['code'] . " {" . $row['team'] . "} -- " . $row['address'],
            'value' => $row['name'] . $row['code']=""?"":$row['code'],
            'label' => $row['name'] . $row['code']=""?"":$row['code'],
            'area' => $row['area'],
            'address' => $row['address'],
            'code' => $row['code'],
            'district_id' => $row['district_id'],
        );
    }
}

print json_encode($json);
?>