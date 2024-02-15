<?php
include_once '../class/database.php';


$txt=$_REQUEST['term'];

$str="call search_make('$txt');";
//print $str;
$result=dbQuery($str);
$response = array();
$i=0;
while ($row=dbFetchAssoc($result)){
	$json[]=array(
            'id'=> $row['id'],
            'value'=> $row['make'],
            'label'=> $row['make']
  );
}

print json_encode($json);
?>