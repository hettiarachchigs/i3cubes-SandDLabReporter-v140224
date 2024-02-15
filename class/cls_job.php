<?php
include_once 'database.php';

class job {
	function addJob($joid,$code,$descript,$info,$fru,$lbrid,$discount, $price){
            //id, title, code, description, aditional_information, comment, invoice, index_no, status, job_order_ID, labour_id, price
		$descript=getStringFormatted($descript);
		$info=getStringFormatted($info);
		$fru=getStringFormatted($fru);
		$lbrid=getStringFormatted($lbrid);
                $discount=getStringFormatted($discount);
                $price=getStringFormatted($price);
		
		$str="INSERT INTO jobs (job_order_ID,code,description,aditional_information,labour_id,price) VALUES (
			'$joid','$code',$descript,$info,$lbrid,$price);";
		//print $str;
		$res=dbQuery($str);
		return dbInsertId();
	}
        function getlabourData ($jid){
            $results = array();
            $str = "SELECT * FROM jobs WHERE job_order_ID ='$jid'";
            //print $str;
            $res = dbQuery($str);
            while ($row = dbFetchAssoc($res)){
                array_push($results, $row);
            }
            return $results;
        }
        
	function editJob($jid,$fru){
		$str="UPDATE jobs SET FRU='$fru' WHERE JID='$jid';";
		$res=dbQuery($str);
		return $res;
	}
        function setRank($jid,$rnk){
		$str="UPDATE jobs SET index_no='$rnk' WHERE JID='$jid';";
		$res=dbQuery($str);
		return $res;
	}
        function editJobDiscount($jid,$disc){
		$str="UPDATE jobs SET discount='$disc' WHERE JID='$jid';";
		$res=dbQuery($str);
		return $res;
	}
	function setInvoiceType($jid,$type){
		if($type==''){
			$type='1';
		}
		$str="UPDATE jobs SET Invoice='$type' WHERE JID='$jid';";
		$res=dbQuery($str);
		return $res;
	}
	function setSrinkStatus($jid,$status='N'){
		$str="UPDATE jobs SET Shrink='$status' WHERE JID='$jid';";
		$res=dbQuery($str);
		return $res;
	}
	function setExtraJobInvoiceType($exjid,$type){
		if($type==''){
			$type='1';
		}
		$str="UPDATE other_job SET Invoice='$type' WHERE OJID='$exjid';";
		$res=dbQuery($str);
		return $res;
	}
	function addCommnet($jid,$comment){
		$comment=getStringFormatted($comment);
		
		$str="UPDATE jobs SET Comment='$commenst' WHERE JID='';";
		//print $str;
		$res=dbQuery($str);
		return $res;
	}
	function getJobData($jid){
		$str="SELECT * FROM jobs WHERE id='$jid';";
		//print $str;
		$result=dbQuery($str);
		$row=dbFetchAssoc($result);
		return $row;
	}
	function addgetJobs($joid){
		$result=array();
		$str="SELECT * FROM jobs WHERE JOID='$joid' ORDER BY -index_no DESC;";
		print $str;
		$res=dbQuery($str);
		while($row=dbFetchAssoc($res)){
			array_push($result,$row);
		}
		return $result;
	}
        function getJobIDs($joid){
		$result=array();
		$str="SELECT JID FROM jobs WHERE JOID='$joid' ORDER BY -index_no DESC;";
		//print $str;
		$res=dbQuery($str);
		while($row= dbFetchArray($res)){
                    array_push($result,$row[0]);
		}
		return $result;
	}
	function deleteJob($jid){
		$str="DELETE FROM jobs WHERE JID='$jid';";
		//print $str;
		$res=dbQuery($str);
		return $res;
	}
	function deleteJobs($joid){
		$str="DELETE FROM jobs WHERE JOID='$joid';";
		//print $str;
		$res=dbQuery($str);
		return $res;
	}
	function addSpare($jid,$itemid,$qty,$disc){
            $disc=  getStringFormatted($disc);
            $str="INSERT INTO jobs_spares (ItemID,JID,Date,Qty,discount) VALUES('$itemid','$jid',NOW(),'$qty',$disc);";
            //print $str;
            $res=dbQuery($str);
            return dbInsertId();
	}
	function deleteSpare($rid){
		$str="DELETE FROM jobs_spares WHERE RecordID='$rid';";
		//print $str;
		$res=dbQuery($str);
		return $res;
	}
        
	function setSpareStatus($rid,$status){
		$str="UPDATE jobs_spares SET Status='$status' WHERE RecordID='$rid';";
		$res=dbQuery($str);
		return $res;
	}
        function issueSpare($rid,$qty){
            //CHECK THE STOCK BEFORE CALLING
            $str="UPDATE jobs_spares SET Qty_Issued=IFNULL(Qty_Issued,0)+$qty WHERE RecordID='$rid';";
            $res=dbQuery($str);
            return $res;
	}
        function returnSpare($rid,$qty){
		$str="UPDATE jobs_spares SET Qty_Return=IFNULL(Qty_Return,0)+$qty WHERE RecordID='$rid';";
		$res=dbQuery($str);
		return $res;
	}
        function setSpareDiscount($rid,$disc){
		$str="UPDATE jobs_spares SET discount='$disc' WHERE RecordID='$rid';";
		$res=dbQuery($str);
		return $res;
	}
        function setSpareRank($rid,$id){
		$str="UPDATE jobs_spares SET index_no='$id' WHERE RecordID='$rid';";
		$res=dbQuery($str);
		return $res;
	}
	function getSpareList($jid){
		$result=array();
		$str="SELECT t1.*,t2.* FROM jobs_spares as t1 left join product as t2 on t1.ItemID=t2.ProductID WHERE t1.JID='$jid' order by -index_no DESC;";
		//print $str;
		$res=dbQuery($str);
		while($row=dbFetchAssoc($res)){
                    array_push($result,$row);
		}
		return $result;
	}
        function getIssuedSpareList($jid){
		$result=array();
		$str="SELECT t1.*,t2.*,t1.Qty_Issued-IFNULL(t1.Qty_Return,0) as issued FROM jobs_spares as t1 left join product as t2 on t1.ItemID=t2.ProductID WHERE t1.JID='$jid' order by -t1.index_no DESC;";
		//print $str;
		$res=dbQuery($str);
		while($row=dbFetchAssoc($res)){
			array_push($result,$row);
		}
		return $result;
	}
	function getPartData($rid){
		$str="SELECT t1.*,t2.* FROM jobs_spares as t1 left join product as t2 on t1.ItemID=t2.ProductID WHERE t1.RecordID='$rid';";
		//print $str;
		$res=dbQuery($str);
		$row=dbFetchAssoc($res);
		return $row;
	}
	function getJobRate($v_model){
		$str="SELECT FRURate FROM vehicle_model WHERE ModelID='$v_model';";
		//print $str;
		$result=dbQuery($str);
		$row=dbFetchArray($result);
		return $row[0];
	}
	function getJobChargingRate($c_cat,$type){
		if($type=='I'){
			//$c_cat='3';
		}
		elseif ($type=='W'){
			//$c_cat='4';
		}
		$str="SELECT Charge FROM charging_cat WHERE ChargingID='$c_cat';";
		//print $str;
		$result=dbQuery($str);
		$row=dbFetchArray($result);
		return $row[0];
	}
	function addExtraJob($joid,$vendorid,$descript,$price,$cost,$bill_ref){
		$descript=getStringFormatted($descript);
		$vendorid=getStringFormatted($vendorid);
		$cost=getStringFormatted($cost);
                $bill_ref=getStringFormatted($bill_ref);
		$str="INSERT INTO other_job (Description,Value,Price,JOID,VendorID,Bill_Ref,Date_added) VALUES($descript,$cost,'$price',$joid,$vendorid,$bill_ref,NOW());";
		//print $str;
		$res=dbQuery($str);
		return $res;
	}
	function getExtraJobs($joid){
		$result=array();
		$str="SELECT * FROM other_job WHERE JOID='$joid';";
		//print $str;
		$res=dbQuery($str);
		while($row=dbFetchAssoc($res)){
			array_push($result,$row);
		}
		return $result;
	}
	function getExtraJobData($jid){
		$str="SELECT * FROM other_job WHERE OJID='$jid';";
		//print $str;
		$res=dbQuery($str);
		$row=dbFetchAssoc($res);
		return $row;
	}
	function deleteExtraJob($jid){
		$str="DELETE FROM other_job WHERE OJID='$jid';";
		$res=dbQuery($str);
		return $res;
	}
        function searchExtraJobs($from,$to,$vendor){
            $ary_sql=array();
            if($from!=''){
                if($to==''){
                    $to=date('Y-m-d');
                }
                array_push($ary_sql, "t1.Date_added>'$from 00:00:00' AND t1.Date_added<'$to 23:59:59'");
            }
            if($vendor!=''){
                array_push($ary_sql, "t1.VendorID='$vendor'");
            }
            $result=array();
            if(count($ary_sql)>0){
                $where="WHERE ".implode(" AND ", $ary_sql);
            }
            else{
                $where='ORDER BY t1.OJID DESC LIMIT 50';
            }
            $str="SELECT t1.*,t3.InvoiceNo,t4.RegNo,t5.Name as VendorName,t2.LocationCode FROM other_job as t1 left join joborder as t2 on t1.JOID=t2.ID left join invoice as t3 on t1.JOID=t3.JOID left join vehicle as t4 on t2.VID=t4.VID left join vendor as t5 on t1.VendorID=t5.VendorID $where;";
            //print $str;
            $res=dbQuery($str);
            while($row=dbFetchAssoc($res)){
                    array_push($result,$row);
            }
            return $result;
        }
        function addJobSublet($jid,$description,$price,$qty,$disc){
            $disc=  getStringFormatted($disc);
            $str="INSERT INTO jobs_spares (JID,Date,Qty,discount,description,rate,Qty_Issued) VALUES('$jid',NOW(),'$qty',$disc,'$description','$price','$qty');";
            //print $str;
            $res=dbQuery($str);
            return $res;
        }
        function addLabourFRU($jid,$emp_id,$fru){
            if($fru>0){
                $str="INSERT INTO job_staff VALUES(NULL,'$jid','$emp_id','$fru',NOW());";
                $res=dbQuery($str);
                return $res;
            }
            else{
                return false;
            }
        }
        function getBalanceLabourFRU($jid){
            $str="SELECT FRU FROM jobs WHERE JID='$jid';";
            $res=dbQuery($str);
            $row=dbFetchAssoc($res);
            $org_fru=$row['FRU'];
            
            $str="SELECT SUM(FRU) as FRU FROM job_staff WHERE JID='$jid';";
            $res=dbQuery($str);
            $row=dbFetchAssoc($res);
            $bal_fru=$org_fru-$row['FRU'];
            return $bal_fru;
        }
        function getLabourFRU($jid){
            $result=array();
            $str="SELECT t1.*,t2.Name as employee_name FROM job_staff as t1 left join employee as t2 on t1.EMPID=t2.EMPID WHERE t1.JID='$jid';";
            //print $str;
            $res=dbQuery($str);
            while($row=dbFetchAssoc($res)){
                array_push($result,$row);
            }
            return $result;
        }
        function getLabourFRUData($lbr_fru_id){
            $str="SELECT t1.*,t2.Name as employee_name FROM job_staff as t1 left join employee as t2 on t1.EMPID=t2.EMPID WHERE t1.ID='$lbr_fru_id';";
            //print $str;
            $res=dbQuery($str);
            $row=dbFetchAssoc($res);
            return $row;
        }
        function deleteLabourFRU($fru_id){
            $str="DELETE FROM job_staff WHERE ID='$fru_id';";
            $res=dbQuery($str);
            return $res;
        }
        function getLabourFRUTotal($ary_job_ids){
            $result=array();
            if(count($ary_job_ids)!=0){
                $str="SELECT JID,SUM(FRU) as FRU FROM job_staff WHERE JID IN(". implode(",", $ary_job_ids).") GROUP BY JID;";
                //print $str;
                $res=dbQuery($str);
                while($row= dbFetchArray($res)){
                    $result[$row[0]]=$row[1];
                }
            }
            return $result;
        }
}
?>