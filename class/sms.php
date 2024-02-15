<?php 
include_once 'cls_employee.php';
//include_once 'cls_fault_ticket.php';
require_once('ESMSWS.php');
//require_once("../lib/config.php");

class sms{
    public function sendSMS($ary_to,$msg){
        $ary_result=array();
        foreach ($ary_to as $to){
            //$res=$this->send_DLG($to, $msg);
            //$res=$this->send_Mobitel($to, $msg);
            $res=  $this->addSMStoQue($to, $msg);
            array_push($ary_result, $res);
        }
        return $ary_result;
    }
    public function addSMStoQue($to,$msg){
        //$to_str=  implode(",", $to);
        $str="INSERT INTO sms_que (mobile,date_time,message,status) VALUES('$to',NOW(),'$msg','0');";
        $res= dbQuery($str);
        return $res;
    }
    public function updateSMSQueStatus($id,$status){
        $str="UPDATE sms_que SET status='$status' WHERE id='$id';";
        $res= dbQuery($str);
        return $res;
    }
    public function updateRetryCount($id){
        $str="UPDATE sms_que SET retry_count=retry_count+1 WHERE id='$id';";
        $res= dbQuery($str);
        return $res;
    }

    public function send_Mobitel($to,$msg){
        if($to!=''){
            $to_ary=array();
            if(strlen($to)>10){
                $ary_num= explode('[,; ]', $to);
                foreach ($ary_num as $num){
                    $to_new=ltrim($num,'0');
                    $to='94'.$to_new;
                    array_push($to_ary, $to_new);
                }
            }
            else{
                $to_new=ltrim($to,'0');
                $to='94'.$to_new;
                array_push($to_ary, $to_new);
            }
            $session = createSession('','esmsusr_168l','2pr8jmh','');
            $res=sendMessages($session,'Fentons',$msg,$to_ary);
            return $res;
        }
        else{
            return false;
        }
    }
    private function send_DLG($to,$msg){ //Energynets
        if($to!=''){
            //print "TO:".$to;
            if(strlen($to)>10){
                $ary_num= explode('[,; ]', $to);
                foreach ($ary_num as $num){
                    $to_new=ltrim($num,'0');
                    $to='94'.$to_new;
                    $message=str_replace(" ","%20",$msg);
                    $url="https://cpsolutions.dialog.lk/index.php/cbs/sms/send?destination=$to&q=14763686082015&message=$message";
                    //print $url;
                    $ch=curl_init();
                    curl_setopt($ch,CURLOPT_URL,$url);
                    //curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    //$to_post="destination=".$to."&message =".$msg."&q=14763686082015";
                    //curl_setopt($ch, CURLOPT_POSTFIELDS,$to_post);		
                    $res= curl_exec ($ch);
                    //print "RES:".$res." ERR:".curl_error($ch);
                    curl_close ($ch);
                }
            }
            else {
                $to_new=ltrim($to,'0');
                $to='94'.$to_new;
                $message=str_replace(" ","%20",$msg);
                $url="https://cpsolutions.dialog.lk/index.php/cbs/sms/send?destination=$to&q=14763686082015&message=$message";
                //print $url;
                $ch=curl_init();
                curl_setopt($ch,CURLOPT_URL,$url);
                //curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                //$to_post="destination=".$to."&message =".$msg."&q=14763686082015";
                //curl_setopt($ch, CURLOPT_POSTFIELDS,$to_post);		
                $res= curl_exec ($ch);

                curl_close ($ch);
            }

            $log="DLG::".date('Y-m-d H:i:s')." : TO-".$to." || MSG:".$msg." || RES:".$res." ERR:".curl_error($ch);
            $log_file=ASSETS_URL."/logs/sms_log_".date('Ym').".txt";
            if ($file=fopen($log_file, "a+")) {
                    fputs($file,"$log \n");
                    fclose($file);
            }
            else {
            }

            if($res=='0'){
                    return true;
            }
            else{
                    return false;
            }
        }
        else{
                return false;
        }
    }
}
?>