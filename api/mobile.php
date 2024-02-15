<?php
include_once '../class/user.php';
include_once '../class/employee.php';
include_once '../class/functions.php';
include_once '../class/productManager.php';
include_once '../class/product.php';
include_once '../class/cls_inventory_item.php';
include_once '../class/cls_inventory_item_Manager.php';
include_once '../class/ngs_date.php';


$user_code=  $_REQUEST['CODE'];
$sid=$_REQUEST['SID'];

//print $ip;
$log_file="api_mobile.txt";
$str=date("Y-m-d H:i:s")." || {".implode(",",array_keys($_REQUEST))."} -- {".implode(",",$_REQUEST)."}";
if ($file=fopen($log_file, "a+")) {
	fputs($file,"$str \n");
	fclose($file);
}

$response = array();
if($sid!=""){
    switch ($sid){
        case 100://mobile login
            $fn=new functions();
            $log_res=$fn->loginWithCode($user_code);
            if($log_res[0]==1){
                $us=new user($log_res[1]);
                $us->getUser();
                $emp=new employee($us->emp_id);
                $emp->getEmployee();
                $response[0]["result"] = '1';
                $response[0]["employee_id"]="$us->emp_id";
                $response[0]["name"]="$emp->name";
            }
            else if($log_res[0]==4){
                $response[0]["result"] = '0';
                $response[0]["error_code"]='103';
                $response[0]["error"]='user required to change the password through web';
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"]='104';
                $response[0]["error"]='user name or password not matched';
            }
            break;
            
        case 101:
            //Add Item
            $name=$_REQUEST["PRODUCT"];
            $batch_no=$_REQUEST["BATCHCODE"];
            $emp_id=$_REQUEST["EMPLOYEEID"];
            $qty=$_REQUEST['QTY'];
            $units=$_REQUEST["UNITS"];
            $prd_mgr=new productManager();
            
            $prd=new \product();
            $prd=$prd_mgr->getPartByName($name);
            if($prd!=null){
                //
            }
            else{
                //Add Product to DB
                $prd=new product();
                $prd->name=$name;
                $prd->remarks="added by mobile app";
                $prd->units_id=$prd_mgr->getUnitID($units);
                $prd->save();
            }
            //add item
            $inv_item=new inventory_item();
            $inv_item->product_id=$prd->id;
            $inv_item->batch_no=$batch_no;
            $inv_item->qty_init=$qty;
            $inv_item->qty_balance=$qty;
            $inv_item->adde_emp_id=$emp_id;
            //expiary_date
            $d=new ngs_date();
            $exp_date=date('Y-m-d',$d->dateadd(time(), 30));
            $inv_item->date_expiary=$exp_date;
            $inv_item->remarks="";
            $inv_item->save();
            if($inv_item->id!=null){
                $response[0]["result"] = '1';
                $response[0]["id"] = $inv_item->id;
            }
            else{
                $response[0]["result"] = '0';
            }
            
            break;
        case 102:
            //Add Location to item
            $id=$_REQUEST["ID"];
            $loc_id=$_REQUEST["LOCATIONID"];
            $emp_id=$_REQUEST["EMPLOYEEID"];
            $prd_mgr=new productManager();
            $item=new inventory_item($id);
            $item->getData();
            if($item->product_id){
                if($item->setLocation($loc_id)){
                    $response[0]["result"] = '1';
                }
                else{
                    $response[0]["result"] = '0';
                    $response[0]["msg"] = 'System failure.';
                }
            }
            else{
                //No item found
                $response[0]["result"] = '0';
                $response[0]["msg"] = 'No item added.';
            }            
            break;

        case 110:
            //view Item details
            $name=$_REQUEST["PRODUCT"];
            $batch_no=$_REQUEST["BATCHCODE"];
            $inv_mgr=new inventory_item_manager();
                
            $inv_item=$inv_mgr->getItemByBatchNo($batch_no);
            if($inv_item->id!=null){
                $response[0]["result"] = '1';
                $response[0]["id"] = $inv_item->id;
                $response[0]["name"] = $inv_item->name;
                $response[0]["batch_no"] = $inv_item->batch_no;
                $response[0]["location"] = $inv_item->location_name;
                $response[0]["init_qty"] = $inv_item->qty_init;
                $response[0]["balance_qty"] = $inv_item->qty_balance;
                $response[0]["units"] = $inv_item->unit_name;
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["msg"] = 'System failure.';
            }
            
            break;
        case 12://get branches
            if($cid!=""){
                $cus=new customer($cid);
                $ary_branches=$cus->getAllBranches();
                $br=new \branch();

                $ary_data=array();
                foreach ($ary_branches as $br){
                    array_push($ary_data, array(
                        "id"=>$br->id,
                        "code"=>$br->code,
                        "name"=>$br->name,
                        "address"=>$br->address,
                        "contact_no"=>$br->contactNumber,
                        "contact_name"=>$br->contactName
                    ));
                }
                $response[0]["result"] = '1';
                $response[0]["count"]=  count($ary_data);
                $response[1]["data"]=$ary_data;
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"]='121';
                $response[0]["error"]='Customer ID is missing';
            }
            break;
        case 13: //get FT types
            $str="call search_fault_type('','V');";
            $result=dbQuery($str);

            $ary_data=array();
            while ($row=dbFetchAssoc($result)){
                array_push($ary_data, array(
                    "fault_type_id"=>$row['id'],
                    "type"=>$row['fault']
                ));
            }
            $response[0]["result"] = '1';
            $response[0]["count"]=  count($ary_data);
            $response[1]["data"]=$ary_data;
            break;
        case 14: //get Group List
            $team_mgr=  new teamManager();
            $teams= $team_mgr->getAllTeams();
            //$result=dbQuery($str);

            $ary_data=array();
            $team=new \team();
            $emp=new \employee();
            foreach ($teams as $team){
                $ary_emp=array();
                foreach ($team->members as $emp){
                    array_push($ary_emp, array("type"=>$emp->type,"name"=>$emp->name,"emp_id"=>$emp->id,"mobile"=>$emp->mobile,"email"=>$emp->email));
                }
                array_push($ary_data, array(
                    "group_id"=>$team->id,
                    "group_name"=>$team->name,
                    "members"=>$ary_emp
                ));
            }
            $response[0]["result"] = '1';
            $response[0]["count"]=  count($ary_data);
            $response[1]["data"]=$ary_data;
            break;
        case 15://customer details
            if($cid!=""){
            $ary_data=array();
            $cus=new customer($cid);
            $cus->getData();
            //print "CCC:".$cus->name;
                array_push($ary_data, array(
                    "id"=>$cus->id,
                    "code"=>$cus->code,
                    "name"=>$cus->name,
                    "address"=>$cus->address,
                    "contact_no"=>$cus->contactNumber,
                    "contact_name"=>$cus->contactName,
                    "contact_email"=>$cus->contactEmail,
                    "tech_group_id"=>$cus->teamID,
                    "tech_group_name"=>$cus->teamName
                    ));
                //AMC Data
                $amc=new \amc();
                $serv=new \serviceJob();
                $br=new branch($cid);
                $serv_mgr=new seviceJobManager();
                $ary_contracts=$br->getContractCoverage();
                $ary_amc=array();
                $ary_services=array();
                foreach ($ary_contracts[0] as $amc){
                    array_push($ary_amc, array("amc_id"=>$amc->id,"start_date"=>$amc->startDate,"end_date"=>$amc->endDate,"type"=>$amc->categoryName,"type_id"=>$amc->category));
                    $ary_ser=$serv_mgr->getAMCServices($amc->id,$cid);
                    foreach ($ary_ser as $serv){
                        array_push($ary_services, array("ref_no"=>$serv->ref_no,"target_date"=>$serv->targetDate,"closed_date"=>$serv->closedDate,"service_no"=>$serv->service_no,"status"=>$serv->status));
                    }
                }
                $ary_war=array();
                foreach ($ary_contracts[1] as $amc){
                    array_push($ary_war, array("warr_id"=>$amc->id,"start_date"=>$amc->startDate,"end_date"=>$amc->endDate,"type"=>$amc->categoryName,"type_id"=>$amc->category));
                    $ary_ser=$serv_mgr->getAMCServices($amc->id,$cid);
                    foreach ($ary_ser as $serv){
                        array_push($ary_services, array("ref_no"=>$serv->ref_no,"target_date"=>$serv->targetDate,"closed_date"=>$serv->closedDate,"service_no"=>$serv->service_no,"status"=>$serv->status));
                    }
                }

                $ary_contracts=array("amc"=>$ary_amc,"warranty"=>$ary_war);
                $response[0]["result"] = '1';
                $response[0]["count"]=  count($ary_data);
                $response[1]["data"]=$ary_data;
                $response[2]["contacts"]=$ary_contracts;
                $response[3]["services"]=$ary_services;
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"]='151';
                $response[0]["error"]='Customer ID is missing';
            }

            break;
        case 16: //get Details of a group
            if($group_id!=""){
                $team_mgr=  new teamManager();
                $team=new team($group_id);
                $team->getTeam();

                $emp=new \employee();

                $ary_emp=array();
                foreach ($team->members as $emp){
                    array_push($ary_emp, array("type"=>$emp->type,"name"=>$emp->name,"emp_id"=>$emp->id,"mobile"=>$emp->mobile,"email"=>$emp->email));
                }
                $ary_data=array();
                array_push($ary_data, array(
                    "group_id"=>$team->id,
                    "group_name"=>$team->name,
                    "members"=>$ary_emp
                ));
                $response[0]["result"] = '1';
                $response[1]["data"]=$ary_data;
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"]='161';
                $response[0]["error"]='Group ID is missing';
            }
            break;
        case 20://FT inbox
            if($emp_id!=""){
                $const=new constants();
                $emp=new employee($emp_id);
                $ft=new fault_ticket();
                $ft_mngr=new fault_ticket_manager();

                $ary_team=$emp->getTeam();
                $ary_tkt=$ft_mngr->getInboxTicket($ary_team);

                $ary_data=array();
                foreach ($ary_tkt as $ft){
                    //format customer name
                    $area=$ft->area!=""?" [".$ft->area."]":"";
                    $code=$ft->sap_code!=""?" -".$ft->sap_code:"";

                    array_push($ary_data, array(
                        "id"=>$ft->id,
                        "reference"=>$ft->ref_no,
                        "customer_name"=>$ft->customer.$area.$code,
                        "date_open"=>$ft->dateOpen,
                        "description"=>$ft->description,
                        "status"=>$const->getStatus($ft->status)
                    ));
                }
                $response[0]["result"] = '1';
                $response[0]["count"]=  count($ary_data);
                $response[1]["data"]=$ary_data;
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"]='105';
                $response[0]["error"]='Employee ID is missing';
            }
            break;
        case 21://Add Ticket
            $ft=new fault_ticket();
            if($cid!="" && $ft_type_id!="" && $emp_id!=""){
                $res_tkt=$ft->add($cid,$ft_description,$emp_id,$ft_type_id,$note,$ft_cont_name,$ft_cont_number,$ft_cont_mail,'',"");
                if($res_tkt){
                    //send email to group,customer,cus-contact
                    $ft=new fault_ticket($res_tkt);
                    $ft->getData();
                    //$res_mail_emp=$ft->sendMail('OPEN');
                    $res_mail_cus=$ft->sendMail('CUSTOMER-OPEN');
                    //$res_mail_emp=$ft->sendSMS('OPEN');
                    $res_mail_cus=$ft->sendSMS('CUSTOMER-OPEN');
                    $response[0]["result"] = '1';
                    $response[0]["ticket_reference"]=$ft->ref_no;
                    $response[0]["error"]='';
                }
                else{
                    $response[0]["result"] = '0';
                    $response[0]["error_code"]='212';
                    $response[0]["error"]='could not open ticket';
                }
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"]='211';
                $response[0]["error"]='Customer/Branch ID, Fault Type or Empoyee ID is missing';
            }
            break;
        case 22://FT List of customer

            if($cid!=""){
                $cus_ent=new customerEntity($cid);
                $cus_ent->getData();
            }
            else if($code!=""){
                $cus_mgr=new customerManager();
                $cus_ent=$cus_mgr->getCustomerByCode($code);
                if($cus_ent==null){
                    $br_mgr=new branchManager();
                    $cus_ent=$br_mgr->getBranchByCode($code);
                }
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"]='221';
                $response[0]["error"]='Missing Parameter(customer ID or Code)';
            }


            if($cus_ent!=null){
                $const=new constants();
                $ft=new fault_ticket();
                $ft_mngr=new fault_ticket_manager();
                //CUS OR BRANCH
                //print "XXX";
                //print_r($cus_ent);
                if($cus_ent->category=="CUS"){
                    $ary_tkt=$ft_mngr->searchTickets($cus_ent->id, "", "", $from, $to, $status);
                }
                else{
                    $ary_tkt=$ft_mngr->searchTickets("", $cus_ent->id, "", $from, $to, $status);
                }
                //$ary_tkt=$ft_mngr->getInboxTicket($ary_team);

                $ary_data=array();
                foreach ($ary_tkt as $ft){
                    //format customer name
                    $area=$ft->area!=""?" [".$ft->area."]":"";
                    $code=$ft->sap_code!=""?" -".$ft->sap_code:"";

                    array_push($ary_data, array(
                        "id"=>$ft->id,
                        "reference"=>$ft->ref_no,
                        "customer_name"=>$ft->customer.$area.$code,
                        "date_open"=>$ft->dateOpen,
                        "date_closed"=>$ft->dateOpen,
                        "description"=>$ft->description,
                        "status"=>$const->getStatus($ft->status),
                        "tech_group_id"=>$ft->team_id,
                        "tech_group_name"=>$ft->teamName
                    ));
                }
                $response[0]["result"] = '1';
                $response[0]["count"]=  count($ary_data);
                $response[1]["data"]=$ary_data;
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"]='223';
                $response[0]["error"]='There are no customer found';
            }
            break;
        case 23: //Edit ticket
            $ft=new fault_ticket();
            if($comment!=""){
                $ft->addReply($ft_id, $comment, $emp_id);
                $res=true;
            }
            if($status=="CLOSE"){
                //Update
                $ft->addReply($ft_id,"CLOSED BY APP", $emp_id);
                if($ft->close()){
                    $ft->sendMail("CUSTOMER_CLOSE");
                    $ft->sendSMS("CUSTOMER_CLOSE");
                }
                else{
                    $res=false;
                }
            }
            else{
                $ft->setInprogress();
                $res=true;
            }
            if($res){
                $response[0]["result"] = '1';
                $response[0]["error_code"]='';
                $response[0]["error"]='';
            }
            else{
                $response[0]["result"] = '0';
                $response[0]["error_code"]='233';
                $response[0]["error"]='Not updated, service error';
            }
            break;

    }
}
else{
    $response[0]["result"] = '0';
    $response[0]["error_code"]='100';
    $response[0]["msg"]='Service ID is missing';
}

header('Content-Type: application/json');
//echo json_encode($response,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
echo json_encode($response);
?>
