<?php
include_once '../class/database.php';


$txt=$_REQUEST['term'];

$str="call search_vendor('$txt');";
//print $str;
$result=dbQuery($str);
$response = array();
$i=0;
while ($row=dbFetchAssoc($result)){
	$json[]=array(
            'id'=> $row['id'],
            'value'=> $row['name'],
            'label'=> $row['name']
  );
}

print json_encode($json);
?>