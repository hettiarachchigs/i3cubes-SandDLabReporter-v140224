<?php
$user="sd";
//$user='ngstrackadmin';
$pass="SandD@187";
//$pass='NgsAzr@187';
//$dbName="ngs";
$dbName='s_and_d_labreport';

//print $user." || ".$dbName.' || '.$pass;
$dbConn = mysqli_connect ("localhost",$user,$pass,$dbName) or die ('MySQL connect failed. ' . mysqli_error());
//$dbConn = mysql_connect ("10.2.26.26", "tigo", "tigonoc") or die ('MySQL connect failed. ' . mysql_error());
mysqli_set_charset($dbConn,'utf8');

function dbQuery($sql)
{
	global $dbConn;
	$result = mysqli_query($dbConn,$sql) or die(mysqli_error($dbConn));

	return $result;
}

function dbAffectedRows()
{
	global $dbConn;

	return mysqli_affected_rows($dbConn);
}

function dbFetchArray($result) {
	return mysqli_fetch_array($result, MYSQLI_NUM);
}

function dbFetchAssoc($result)
{
	return mysqli_fetch_assoc($result);
}

function dbFetchRow($result)
{
	return mysqli_fetch_row($result);
}

function dbFreeResult($result)
{
	return mysqli_free_result($result);
}

function dbFreeResorces()

{
	global $dbConn;
	mysqli_next_result($dbConn);
}

function dbNumRows($result)
{
	return mysqli_num_rows($result);
}

function dbSelect($dbName)
{
	global $dbConn;
	return mysqli_select_db($dbName,$dbConn);
}

function mysqlRealEscape($str) {
    global $dbConn;
    $result = mysqli_real_escape_string($dbConn, $str);
    return $result;
}


function dbInsertId()
{
	global $dbConn;
	return mysqli_insert_id($dbConn);
}

function cleanData($str){
//	$find=array("'",'"','_');
//	$replace=array("\'",'\"','\_');
//	$str_new=str_replace($find,$replace,$str);
	return mysqlRealEscape($str);
}
	
function dbcheckTableAvailability($tblname){
	$str="SHOW TABLES LIKE '$tblname';";
	$res=dbQuery($str);
	if(dbNumRows($res)>0){
		return true;
	}
	else {
		return false;
	}
}
function getStringFormatted($str){
	if($str==""){
		return "NULL";
	}
	else {
            $str_n= cleanData($str);
            return "'$str_n'";
	}
}
function getYN($str){
	if($str==""){
		return "'N'";
	}
	else {
		return "'$str'";
	}
}
?>