<?php

class ngs_date{
var $home_tz='Asia/Colombo';
var $local_tz="";
function __construct($tz=''){
	$this->local_tz=$tz;
}
function dateadd($timestamp,$Day=null,$Hour=null,$Mins=null,$Sec=null){
	$Ans=$timestamp+($Day*24*60*60)+($Hour*60*60)+($Mins*60)+$Sec;
	return $Ans;
	//returns timestamps
}
function datesub($timestamp,$Day=null,$Hour=null,$Mins=null,$Sec=null){
	$Ans=$timestamp-($Day*24*60*60)-($Hour*60*60)-($Mins*60)-$Sec;
	return $Ans;
	//returns timestamps
}
function split_date($datetime){
	$dateY=substr($datetime,0,10);
	$dateH=substr($datetime,11,2);
	$dateM=substr($datetime,14,2);

	$ary_date=array($dateY,$dateH,$dateM);
	return $ary_date;
}

function scatter_date($datetime){//Date format 2009-10-09 20:20:00
	$Y=substr($datetime,0,4);
	$M=substr($datetime,5,2);
	$D=substr($datetime,8,2);
	$H=substr($datetime,11,2);
	$Mn=substr($datetime,14,2);
	$S=substr($datetime,17,2);
	$ary_date=array($Y,$M,$D,$H,$Mn,$S);
	return $ary_date;
}
function scatter_string_to_date($str){//20150707112338
	$Y=substr($str,0,4);
	$M=substr($str,4,2);
	$D=substr($str,6,2);
	$H=substr($str,8,2);
	$Mn=substr($str,10,2);
	$S=substr($str,12,2);
	$ary_date=array($Y,$M,$D,$H,$Mn,$S);
	return $ary_date;
	
}
function formatTime12H($str_time){//13:23:12
	$h=substr($str_time,0,2);
	$m=substr($str_time,3,2);
	$s=substr($str_time,6,2);
	if($h<=12){
		$time=$h.":".$m.":".$s." AM";
	}
	else{
		$time=($h-12).":".$m.":".$s." PM";
	}
	return $time;
}
function formatFullDate12H($str_date){//2015-08-11 12:00:00
	$ary_date=$this->scatter_date($str_date);
	$date='';
	if($ary_date[3]<=12){
		$date=$ary_date[0]."-".$ary_date[1]."-".$ary_date[2]." ".$ary_date[3].":".$ary_date[4].":".$ary_date[5]." AM";
	}
	else{
		$date=$ary_date[0]."-".$ary_date[1]."-".$ary_date[2]." ".($ary_date[3]-12).":".$ary_date[4].":".$ary_date[5]." PM";
	}
	return $date;
}
function getDuration($date1,$date2){//Date format 2009-10-09 20:20:00
	$ary_date1=$this->scatter_date($date1);
	$ary_date2=$this->scatter_date($date2);
	$datetime1=mktime($ary_date1[3],$ary_date1[4],$ary_date1[5],$ary_date1[1],$ary_date1[2],$ary_date1[0]);
	$datetime2=mktime($ary_date2[3],$ary_date2[4],$ary_date2[5],$ary_date2[1],$ary_date2[2],$ary_date2[0]);
	$duration=($datetime1-$datetime2)/(60*60);
	return $duration;//in hours
}
function getDurationHr($ts1,$ts2){
	$dura=($ts2-$ts1)/(60*60);
	return $dura;
}
function getDuration_DHM($date1,$date2){//Date format 2009-10-09 20:20:00
	$ary_date1=$this->scatter_date($date1);
	$ary_date2=$this->scatter_date($date2);
	$datetime1=mktime($ary_date1[3],$ary_date1[4],$ary_date1[5],$ary_date1[1],$ary_date1[2],$ary_date1[0]);
	$datetime2=mktime($ary_date2[3],$ary_date2[4],$ary_date2[5],$ary_date2[1],$ary_date2[2],$ary_date2[0]);
	$duration=($datetime1-$datetime2);//seconds
	$h=($duration)/(60*60);
	$hr=floor($h);
	if($hr>24 || $hr<-24){
		$d=$hr/24;
		$days=floor($d);
		$hr=$hr%24;
	}
	else{
		$days=0;
	}
	$mn=round(($duration/60)%60);
	$ary_duration=array($days,$hr,$mn);
	return $ary_duration;
}
function getDuration_mn($date1,$date2){//Date format 2009-10-09 20:20:00
	$ary_date1=$this->scatter_date($date1);
	$ary_date2=$this->scatter_date($date2);
	$datetime1=mktime($ary_date1[3],$ary_date1[4],$ary_date1[5],$ary_date1[1],$ary_date1[2],$ary_date1[0]);
	$datetime2=mktime($ary_date2[3],$ary_date2[4],$ary_date2[5],$ary_date2[1],$ary_date2[2],$ary_date2[0]);
	$duration=($datetime1-$datetime2)/(60);
	$mins=round($duration);
	return $mins;//in minutes
}

function getDuration_ms($date1,$date2){//Date format 2009-10-09 20:20:00
	$ary_date1=$this->scatter_date($date1);
	$ary_date2=$this->scatter_date($date2);
	$datetime1=mktime($ary_date1[3],$ary_date1[4],$ary_date1[5],$ary_date1[1],$ary_date1[2],$ary_date1[0]);
	$datetime2=mktime($ary_date2[3],$ary_date2[4],$ary_date2[5],$ary_date2[1],$ary_date2[2],$ary_date2[0]);
	$duration=($datetime1-$datetime2);
	return $duration;
}
function getTimeStamp($date){ 	//(2010-01-20 10:15:00)
	$ary_date=$this->scatter_date($date);
	$ts=mktime($ary_date[3],$ary_date[4],$ary_date[5],$ary_date[1],$ary_date[2],$ary_date[0]);
	return $ts;
}
function getTimeStamp_Day($time){//20:34:33
	$ary_times=preg_split("/:/",$time);
	$ts=($ary_times[0]*60*60)+($ary_times[1]*60)+$ary_times[2];
	return $ts;
}
function month_add($date_start){	//date_start='2010-02' and Add only one month
	$no_of_days=array(31,28,31,30,31,30,31,31,30,31,30,31);
	$date=$date_start."-01 00:00:01";
	$year=substr($date_start,0,4);
	$month=substr($date_start,5,2)+0;
	$remainder=$year%4;
	if($month==2){
		if($remainder==0){
			$noofdays=29;
		}
		else{
			$noofdays=28;
		}
	}
	else{
		$noofdays=$no_of_days[$month-1];
	}
	$ts=$this->getTimeStamp($date);
	
	$ts_new=$this->dateadd($ts,$noofdays,0,0,0);
	return $ts_new;			//return TS
}

function getStringMonth($no){
	$ary_months=array('January','February','March','April','May','June','July','August','September','October','November','December');
	return $ary_months[$no-1];
}
function month_sub($date_start){	//date_start='2010-02' and Add only one month
	$no_of_days=array(31,28,31,30,31,30,31,31,30,31,30,31);
	$date=$date_start."-01 00:00:01";
	$year=substr($date_start,0,4);
	$month=substr($date_start,5,2)+0;
	$remainder=$year%4;
	if($month==2){
		if($remainder==0){
			$noofdays=29;
		}
		else{
			$noofdays=28;
		}
	}
	else{
		$noofdays=$no_of_days[$month-1];
	}
	$ts=$this->getTimeStamp($date);
	
	$ts_new=$this->datesub($ts,$noofdays,0,0,0);
	return $ts_new;			//return TS
}
function getNoDaysInMonth($year,$month){//1,2,...12
	$no_of_days=array(31,28,31,30,31,30,31,31,30,31,30,31);
	if($month==2){
		$remainder=$year%4;
		if($remainder==0){
			$noofdays=29;
		}
		else{
			$noofdays=28;
		}
	}
	else{
		$noofdays=$no_of_days[$month-1];
	}
	return $noofdays;
}
function getLoaclTime(){
	$date = new DateTime();
	$date->setTimezone(new DateTimeZone($this->local_tz));
	return $date;
}

function shiftTime($time,$tz_from,$tz_to){ //UTC  2015-08-21 00:00:00
	$ary_date=$this->scatter_date($time);
	$date = new DateTime();
	$date->setTimezone(new DateTimeZone($tz_from));
	$date->setDate($ary_date[0],$ary_date[1],$ary_date[2]);
	$date->setTime($ary_date[3],$ary_date[4],$ary_date[5]);
	$date->setTimezone(new DateTimeZone($tz_to));
	return $date;
}

public function tz_list() {
    $zones_array = array();
    $timestamp = time();
    foreach(timezone_identifiers_list() as $key => $zone) {
      date_default_timezone_set($zone);
      $zones_array['zone'][$key] = $zone;
      $zones_array['offset'][$key] = (int) ((int) date('O', $timestamp))/100;
      $zones_array['diff_from_GMT'][$key] = 'UTC/GMT ' . date('P', $timestamp);
      $zones_array['display_name'][$key] = $zone." (".'UTC/GMT ' . date('P', $timestamp).")";
    }
    return $zones_array;
}
}
?>