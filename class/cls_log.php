<?php 

include_once 'database.php';

class log{	
	function setLog($emp_id,$module,$ref,$log){
		$log=getStringFormatted($log);
		$module=getStringFormatted($module);
		$ref=getStringFormatted($ref);
		
		$str="INSERT INTO logs(module,reference_id,log,employee_id,date) VALUES ($module,$ref,$log,'$emp_id',NOW());";
		//print $str;
		$res=dbQuery($str);
		return $res;
	}
	function getlog($module,$ref){
		$result=array();
		$str="SELECT t1.*,t2.name FROM logs as t1 left join employee as t2 on t1.employee_id=t2.id WHERE t1.Module='$module' AND t1.RefID='$ref' ORDER BY Time DESC;";
		//print $str;
		$res=dbQuery($str);
		while($row=dbFetchAssoc($res)){
                    array_push($result,$row);
		}
		return $result;
	}
}
?>