<?php

$res_prev=$us->getPreviledges($row['UserID']);
foreach ($res_prev as $key=>$val){
	$_SESSION[$key]=$val;
}
?>