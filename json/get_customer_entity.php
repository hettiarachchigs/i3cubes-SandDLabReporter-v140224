<?php

include_once '../class/database.php';

$txt = $_REQUEST['term'];
$type = $_REQUEST['type'];
$exclude = $_REQUEST['exclude'];
$to_vendor=$_REQUEST['to_vendor'];

$ary_where=array();
if($to_vendor=="true"){
    array_push($ary_where,"t1.category='VEN'");
    if($txt!=""){
        array_push($ary_where,"(t1.code like '%".$txt."%' or t1.name like '%".$txt."%')");
    }
}
else{
    if($type!=""){
        array_push($ary_where,"t1.cus_type='".$type."'");
    }
    if($txt!=""){
        array_push($ary_where,"(t1.code like '%".$txt."%' or t1.name like '%".$txt."%')");
    }
}
$where= implode(" AND ", $ary_where);
$str="select t1.id,t1.code,t1.name,t1.area,t1.code,t1.cus_type,t1.district_id,t2.name as team From customer_entity as t1 left join team as t2 on t1.team_id=t2.id where   ".$where." AND t1.status='1' ";
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