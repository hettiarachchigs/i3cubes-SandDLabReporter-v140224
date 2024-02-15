<?php
include_once('../class/database.php');


$txt=$_REQUEST['term'];

$str="call search_system('$txt','IEX');";
$result=dbQuery($str);
$i=0;
while ($row=dbFetchAssoc($result)){
	$json[]=array(
   		'id'=> $row['id'],
   		'value'=> $row['product_code'],
		'label'=> $row['product_code']."[".$row['description']."]",
		'name'=> $row['description'],
                'type'=>$row['type']
  );
}
print json_encode($json);
?>