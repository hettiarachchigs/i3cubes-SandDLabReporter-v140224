<?php

include_once '../class/database.php';

$txt = trim($_REQUEST['term']);
$ary_sql = array();
if($txt !=""){
    array_push($array,'category_name LIKE "%'.$txt.'"%');
}

if(count($ary_sql)>0){
    $WHERE = " WHERE ".implode(" AND ", $ary_sql);
}
$str = "SELECT * FROM item_category $WHERE ";
$res= dbQuery($str);
$results = array();
while ($row = dbFetchAssoc($res)){
    $res_arr = array(
        'id' => $row['id'],
            'value' => $row['category_name'],
            'label' => $row['category_name'],
            'code' => $row['code']
    );
    array_push($results, $res_arr);
}
echo json_encode($results);
