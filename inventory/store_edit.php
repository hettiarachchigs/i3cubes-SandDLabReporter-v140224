<?php
session_start();
if (!isset($_SESSION['UID'])) {
    header('Location: index');
}
//initilize the page
$ary_prev = $_SESSION['USER_PREV'];
//print_r($_SESSION);
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Store-Edit";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["forms"]["sub"]["smart_layout"]["active"] = true;
//include("../inc/nav.php");
// ====================== LOGIC ================== --!>

include_once '../class/customer.php';
include_once '../class/employee.php';
include_once '../class/branch.php';
include_once '../class/cls_system.php';
include_once '../class/functions.php';
include_once '../class/cls_stock_manager.php';
include_once '../class/job_order_systems.php';
include_once '../class/job_order.php'; 
$jo_inv_systems = new job_order_systems();
$stk_mgr = new stock_manager();
$fn = new functions();
//print_r($_POST);
$cid = $_REQUEST['id'];
if ($cid == '') {
    $cid = $_POST['cus_id'];
}
$cus = new customer($cid);
if ($_POST['but'] == 'save') {
    $close = false;
    $res = $cus->editCustomer($_POST['cus_name'], $_POST['cus_address'], $_POST['cus_code'], $_POST['cus_contact_name'], $_POST['cus_contact_number'], $_POST['cus_contact_email'], $_POST['cus_note'], $_POST['cus_acc_owner_id'], $_POST['cus_team'], $_POST['cus_cluster'], "S", $_POST['cus_district']);
    if ($res) {
        $msg = "<span class='ngs_success_span'>
                    <i class='fa-fw fa fa-check'></i>&nbsp;Store details Changed.
                    </span>";
    } else {
        $msg = "<span class='ngs_failure_span'>
                <i class='fa-fw fa fa-times'></i>&nbsp;Store details could not be changed. please contact administrator.
                </span>";
    }
} elseif ($_POST['submit_value'] == 'delete') {
    //delete branches
    $br = new \branch();
    $ary_br = $cus->getAllBranches();
    foreach ($ary_br as $br) {
        $br->delete();
    }
    //delete customer
    $res = $cus->delete();
    if ($res) {
        $close = true;
        $msg = "<span class='ngs_success_span'>
                <i class='fa-fw fa fa-check'></i>&nbsp;Store and its branches were deleted.
                </span>";
    } else {
        $close = false;
        $msg = "<span class='ngs_failure_span'>
            <i class='fa-fw fa fa-times'></i>&nbsp;Store could not be deleted. please contact administrator.
            </span>";
    }
}

$cus->getCustomer();
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="margin-left: 10px;">

    <!-- MAIN CONTENT -->
    <div id="content">

        <!-- widget grid -->
        <section id="widget-grid" class="">


            <!-- START ROW -->

            <div class="row">

                <!-- NEW COL START -->

                <!-- END COL -->

                <!-- NEW COL START -->
                <article class="col-sm-12 col-md-12 col-lg-12">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" id="wid-id-51" data-widget-editbutton="false" data-widget-custombutton="false">
                        <!-- widget options:
                                usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                                
                                data-widget-colorbutton="false"	
                                data-widget-editbutton="false"
                                data-widget-togglebutton="false"
                                data-widget-deletebutton="false"
                                data-widget-fullscreenbutton="false"
                                data-widget-custombutton="false"
                                data-widget-collapsed="true" 
                                data-widget-sortable="false"
                                
                        -->

                        <!-- widget div-->
                        <div>

                            <!-- widget edit box -->
                            <div class="jarviswidget-editbox">
                                <!-- This area used as dropdown edit box -->

                            </div>
                            <!-- end widget edit box -->

                            <!-- widget content -->
                            <div class="widget-body no-padding">

                                <form id="form_edit" class="smart-form" method="post" action="<?php echo str_replace('.php', '', htmlentities($_SERVER['PHP_SELF'])); ?>">
                                    <fieldset>
                                        <div class="row">
                                            <section class="col col-3">
                                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="cus_name" id="cus_name" placeholder="Store Name" value="<?php print $cus->name ?>">
                                                </label>
                                                <p class="note">Store Name</p>
                                            </section>
                                            <section class="col col-3">
                                                <label class="input"><i class="icon-append "></i>
                                                    <input type="text" name="cus_code" id="cus_code" placeholder="Site Code" value="<?php print $cus->code ?>">
                                                </label>
                                                <p class="note">Site Code</p>
                                            </section>
                                            <section class="col col-3">
                                                <label class="input"><i class="icon-append fa fa-globe"></i>
                                                    <input type="text" name="cus_contact_name" id="cus_contact_name" placeholder="Contact Name" value="<?php print $cus->contactName ?>">
                                                </label>
                                                <p class="note">Contact Name</p>
                                            </section>
                                            <section class="col col-3">
                                                <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                                                    <input type="tel" name="cus_contact_number" id="cus_contact_number" placeholder="Phone" value="<?php print $cus->contactNumber ?>">
                                                </label>
                                                <p class="note">Contact Number</p>
                                            </section>
                                        </div>

                                        <div class="row">
                                            <section class="col col-3">
                                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="cus_contact_email" id="cus_contact_email" placeholder="Contact Email" value="<?php print $cus->contactEmail ?>">
                                                </label>
                                                <p class="note">Contact Email</p>
                                                <br>
                                                <label class="select">													
                                                    <select name="cus_team" id="cus_team">
                                                        <option value="0" selected="" disabled="">Select Group</option>
                                                        <?php
                                                        print $fn->CreateMenu('team', 'name', '', $cus->teamID, false, 'id', false, true);
                                                        ?>
                                                    </select> <i></i> 
                                                </label>
                                                <p class="note">Technical Group</p>

                                            </section>
                                            <section class="col col-3">
<!--                                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="cus_acc_owner" id="cus_acc_owner" placeholder="Account Owner" value="<?php print $cus->accOwnerName ?>">
                                                </label>
                                                <p class="note">Account Owner</p>
                                                <br>-->
                                                <label class="select">													
                                                    <select name="cus_cluster" id="cus_cluster">
                                                        <option value="0" selected="" disabled="">Select Cluster</option><!--
                                                        <?php
                                                        print $fn->CreateMenu('customer_cluster', 'cluster', '', $cus->cluster, false, 'id', false, true);
                                                        ?>
-->                                                    </select> <i></i> 
                                                </label>
                                                <p class="note">Cluster</p>
                                                <br>
                                                <label class="select">													
                                                                <select name="cus_district" id="cus_district">
                                                                    <option value="0" selected="" disabled="">District</option>
                                                                    <?php
                                                                    print $fn->CreateMenu('district', 'district_name', '', $cus->district_id, false, 'id', false, true);
                                                                    ?>
                                                                </select> <i></i> 
                                                            </label>
                                                            <p class="note">District</p>
                                        </section>
                                                        <section class="col col-3">
                                                            <label class="textarea"><i class="icon-append fa fa-comment"></i> 	  										
                                                                <textarea rows="3" name="cus_address" id="cus_address" placeholder="Store Address"><?php print $cus->address ?></textarea> 
                                                            </label>
                                                            <p class="note">Address</p>
                                                            <br>
                                                            <!--                                                                                                <label class="select">													
                                                                                                                                                                <select name="cus_type" id="cus_type">
                                                                                                                                                                    <option value="0" selected="" disabled="">Type</option>
                                                            <?php
                                                            $ary_t = array("Voice", 'Data');
                                                            $ary_v = array("V", 'D');
                                                            print $fn->CreateCustomMenu($ary_t, $ary_v, '', $cus->type);
                                                            ?>
                                                                                                                                                                </select> <i></i> 
                                                                                                                                                            </label>
                                                                                                                                                            <p class="note">customer type</p>-->
                                                        </section>
                                                        <section class="col col-3">
                                                            <label class="textarea"><i class="icon-append fa fa-comment"></i> 	  										
                                                                <textarea rows="3" name="cus_note" id="cus_note" placeholder="Contact Note"><?php print $cus->note ?></textarea> 
                                                            </label>
                                                            <p class="note">Contact Note</p>

                                                        </section>
                                                        <section class="col col-3">

                                                            
                                                        </section>
                                                        </div>
                                                        </fieldset>
                                                        <footer>
                                                            <div class="row">
                                                                <section class="col col-6">
                                                                    <span class='ngs_failure_span' style="display: none;" id="warning_delete">
                                                                        <i class='fa-fw fa fa-scissors'></i>&nbsp;All branches belongs to customer will be deleted, to confirm press delete again.
                                                                    </span>
                                                                    <div>
                                                                        <?php print $msg ?>
                                                                    </div>

                                                                </section>
                                                                <section class="col col-6">
                                                                    <button type="submit" disabled="" class="btn btn-primary" id="but" name="but" value="save" >
                                                                        Save
                                                                    </button>										
                                                                    <button type="button" disabled="" class="btn btn-primary" id="but_del" name="but" value="delete">
                                                                        Delete
                                                                    </button>
                                                                    <!--
                                                                    <button type="button" disabled="" class="btn btn-primary" id="add_br" name="add_br">
                                                                        Add Branch
                                                                    </button>
                                                                    -->
                                                                    <p style="display: none;" id="msg_prev"><font color="red"><i class="fa-fw fa fa-times"></i>You are not authorized</font></p>
                                                                </section>
                                                            </div>
                                                        </footer>
                                                        <input type="hidden" name="cus_id" id="cus_id" value="<?php print $cid ?>">
                                                        <input type="hidden" name="cus_acc_owner_id" id="cus_acc_owner_id" value="<?php print $cus->accOwnerID ?>">
                                                        <input type="hidden" name="submit_value" id="submit_value" value="">
                                                        </form>	

                                                        </div>
                                                        <!-- end widget content -->

                                                        </div>
                                                        <!-- end widget div -->

                                                        </div>
                                                        <!-- end widget -->

                                                        <!-- END COL -->		

                                                        </div>

                                                        <!-- END ROW -->
                                                        </section>
                                                        <!-- end widget grid -->
                                                        <!-- Store Equipments if there is any-->
                                                        <!-- widget grid -->
                                                        <section id="widget-grid" class="">

                                                            <!-- row -->
                                                            <div class="row">

                                                                <!-- NEW WIDGET START -->
                                                                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <!-- end widget -->

                                                                    <!-- Widget ID (each widget will need unique ID)-->
                                                                    <div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-53" data-widget-editbutton="false">
                                                                        <!-- widget options:
                                                                        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                                                
                                                                        data-widget-colorbutton="false"
                                                                        data-widget-editbutton="false"
                                                                        data-widget-togglebutton="false"
                                                                        data-widget-deletebutton="false"
                                                                        data-widget-fullscreenbutton="false"
                                                                        data-widget-custombutton="false"
                                                                        data-widget-collapsed="true"
                                                                        data-widget-sortable="false"
                                                
                                                                        -->
                                                                        <header>
                                                                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                                                            <h2>Systems</h2>

                                                                        </header>

                                                                        <!-- widget div-->
                                                                        <div>

                                                                            <!-- widget edit box -->
                                                                            <div class="jarviswidget-editbox">
                                                                                <!-- This area used as dropdown edit box -->

                                                                            </div>
                                                                            <!-- end widget edit box -->

                                                                            <!-- widget content -->
                                                                            <div class="widget-body no-padding">

                                                                                <?php
                                                                                //$cus->type ="I";
                                                                                $ary_eq = $cus->getAllSystems('I');
                                                                                $eq = new \system();
//$result=$dbh->dbQuery($str);
                                                                                if (count($ary_eq) > 0) {
                                                                                    echo "
                                                                                            <table id='t_cus_eq_list' class='table table-striped table-bordered table-hover' width='100%' >
                                                                                            <thead>
                                                                                            <tr>	   
                                                                                                <th data-hide='phone'>..</th>
                                                                                                <th data-hide='phone'>Code</th>
                                                                                                <th data-hide='phone'>Description</th>
                                                                                                <th data-hide='phone'>Serial</th>
                                                                                                <th data-hide='phone'>Qty</th>
                                                                                                <th data-hide='phone'>Cus-Warranty</th>
                                                                                                <th data-hide='phone'>Vender-Warr</th>
                                                                                           </tr>
                                                                                            </thead>
                                                                                            <tbody>";

                                                                                    $i = 1;
                                                                                    $sys=new \system();
                                                                                    foreach ($ary_eq as $sys) {   //Creates a loop to loop through results
                                                                                        //print_r($sys);
                                                                                        $flag = "";
                                                                                        $title="";
                                                                                        $status = $sys->status;
                                                                                        if($status == constants::$SYS_IN_JO){
                                                                                            $arry_ref = array();
                                                                                           
                                                                                            $jo_inv_systems->customer_systems_id = $sys->id;
                                                                                            $ro_details = $jo_inv_systems->get();
                                                                                            foreach ($ro_details as $row_items){
                                                                                                $job_order_ID = $row_items->job_order_ID;
                                                                                                $job_order = new job_order($job_order_ID);
                                                                                                $job_order->getData();
                                                                                                $jo_ref = $job_order->ref_no;
                                                                                                array_push($arry_ref, $jo_ref);
                                                                                            }
                                                                                            $flag = 'fnt_lgt_blue';
                                                                                            $title="PRODUCT IN Repair Order \n"
                                                                                                    . "Reference # \n"
                                                                                                    . "". implode(",", $arry_ref);
                                                                                        }
                                                                                        echo "
                                                                                        <tr title ='$title' id=" . '"' . $sys->id . '" class="ngs-popup-eq '.$flag.'"' . ">	  
                                                                                            <td>" . $i . "</td>
                                                                                            <td>" . $sys->system_code . "</td>
                                                                                            <td>" . $sys->system_name . "</td>
                                                                                             <td>" . $sys->serial . "</td>
                                                                                             <td>" . $sys->qty . "</td>
                                                                                            <td>" . $sys->cus_warr_end . '</td>
                                                                                            <td>' . $sys->v_warr_end . '</td>
                                                                                        </tr>';
                                                                                        $i++;
                                                                                    }
                                                                                    print '</tbody>'
                                                                                            . '</table>';
                                                                                }
                                                                                ?>

                                                                            </div>
                                                                            <!-- end widget content -->

                                                                        </div>
                                                                        <!-- end widget div -->

                                                                    </div>
                                                                    <!-- end widget -->

                                                                </article>
                                                                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <!-- end widget -->

                                                                    <!-- Widget ID (each widget will need unique ID)-->
                                                                    <div class="jarviswidget jarviswidget-color-greenLight" id="" data-widget-editbutton="false">
                                                                        <!-- widget options:
                                                                        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                                                
                                                                        data-widget-colorbutton="false"
                                                                        data-widget-editbutton="false"
                                                                        data-widget-togglebutton="false"
                                                                        data-widget-deletebutton="false"
                                                                        data-widget-fullscreenbutton="false"
                                                                        data-widget-custombutton="false"
                                                                        data-widget-collapsed="true"
                                                                        data-widget-sortable="false"
                                                
                                                                        -->
                                                                        <header>
                                                                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                                                            <h2>Consumables</h2>

                                                                        </header>

                                                                        <!-- widget div-->
                                                                        <div>

                                                                            <!-- widget edit box -->
                                                                            <div class="jarviswidget-editbox">
                                                                                <!-- This area used as dropdown edit box -->

                                                                            </div>
                                                                            <!-- end widget edit box -->

                                                                            <!-- widget content -->
                                                                            <div class="widget-body no-padding">

                                                                                <?php
                                                                                //$cus->type ="I";
                                                                                //$ary_eq = $cus->getAllSystems('C');
                                                                                $ary_eq = $stk_mgr->getConsumableStock($cid, $systems_id, "C");
                                                                                
                                                                                $eq = new \system();
//$result=$dbh->dbQuery($str);
                                                                                if (count($ary_eq) > 0) {
                                                                                    echo "
                                                                                            <table id='t_cus_cons_list' class='table table-striped table-bordered table-hover' width='100%' >
                                                                                            <thead>
                                                                                            <tr>	   
                                                                                                <th data-hide='phone'>..</th>
                                                                                                <th data-hide='phone'>Code</th>
                                                                                                <th data-hide='phone'>Description</th>
                                                                                                <th data-hide='phone'>Serial</th>
                                                                                                <th data-hide='phone'>Qty</th>
                                                                                                <th data-hide='phone'>Cus-Warranty</th>
                                                                                                <th data-hide='phone'>Vender-Warr</th>
                                                                                           </tr>
                                                                                            </thead>
                                                                                            <tbody>";

                                                                                    $i = 1;
                                                                                    $sys=new \system();
                                                                                    foreach ($ary_eq as $sys) {   //Creates a loop to loop through results ngs-popup-eq
                                                                                        
                                                                                        echo "
                                                                                        <tr id=" . '"' . $sys->id . '" class=""' . ">	  
                                                                                            <td>" . $i . "</td>
                                                                                            <td>" . $sys->system_code . "</td>
                                                                                            <td>" . $sys->system_name . "</td>
                                                                                             <td>" . $sys->serial . "</td>
                                                                                             <td>" . $sys->qty . "</td>
                                                                                            <td>" . $sys->cus_warr_end . '</td>
                                                                                            <td>' . $sys->v_warr_end . '</td>
                                                                                        </tr>';
                                                                                        $i++;
                                                                                    }
                                                                                    print '</tbody>'
                                                                                            . '</table>';
                                                                                }
                                                                                ?>

                                                                            </div>
                                                                            <!-- end widget content -->

                                                                        </div>
                                                                        <!-- end widget div -->

                                                                    </div>
                                                                    <!-- end widget -->

                                                                </article>
                                                                <!-- WIDGET END -->

                                                            </div>

                                                            <!-- end row -->

                                                            <!-- end row -->

                                                        </section>
                                                        <!-- end widget grid -->
                                                        <!-- Store Branches -->
                                                        <!-- widget grid -->
                                                        <section id="widget-grid" class="">

                                                            <!-- row -->
                                                            <div  style="display: none;" class="row">

                                                                <!-- NEW WIDGET START -->
                                                                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                                    <!-- end widget -->

                                                                    <!-- Widget ID (each widget will need unique ID)-->
                                                                    <div class="jarviswidget jarviswidget-color-blue" id="wid-id-54" data-widget-editbutton="false">
                                                                        <!-- widget options:
                                                                        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                                                
                                                                        data-widget-colorbutton="false"
                                                                        data-widget-editbutton="false"
                                                                        data-widget-togglebutton="false"
                                                                        data-widget-deletebutton="false"
                                                                        data-widget-fullscreenbutton="false"
                                                                        data-widget-custombutton="false"
                                                                        data-widget-collapsed="true"
                                                                        data-widget-sortable="false"
                                                
                                                                        -->
                                                                        <header>
                                                                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                                                            <h2>Branches</h2>

                                                                        </header>

                                                                        <!-- widget div-->
                                                                        <div>

                                                                            <!-- widget edit box -->
                                                                            <div class="jarviswidget-editbox">
                                                                                <!-- This area used as dropdown edit box -->

                                                                            </div>
                                                                            <!-- end widget edit box -->

                                                                            <!-- widget content -->
                                                                            <div class="widget-body no-padding">

                                                                                <?php
                                                                                $ary_branches = $cus->getAllBranches();
                                                                                $br = new \branch();
//$result=$dbh->dbQuery($str);
                                                                                if (count($ary_branches) > 0) {
                                                                                    echo "
                                    <table id='t_cus_br_list' class='table table-striped table-bordered table-hover' width='100%' >
                                    <thead>
                                    <tr>	   
                                        <th data-hide='phone'>ID</th>
                                        <th data-hide='phone'>Branch Code</th>
                                        <th data-hide='phone'>Branch Name</th>
                                        <th data-hide='phone'>Address</th>
                                        <th data-hide='phone'>Tech.group</th>
                                        <th data-hide='phone'>Cluster</th>
                                        <th data-hide='phone'>Contact Person</th>
                                        <th data-hide='phone'>Contact Number</th>                                        
                                        <th data-hide='phone'>..</th>
			           </tr>
                                    </thead>
                                    <tbody>";

                                                                                    $i = 1;
                                                                                    foreach ($ary_branches as $br) {   //Creates a loop to loop through results
                                                                                        echo "
                                            <tr id=" . '"' . $br->id . '" class="ngs-popup-br"' . ">	  
                                                <td>" . $i . "</td>
                                                <td>" . $br->code . "</td>
                                                <td>" . $br->name . "</td>
                                                <td>" . $br->address . "</td>
                                                <td>" . $br->teamName . "</td>
                                                <td>" . $br->clusterName . "</td>
                                                <td>" . $br->contactName . "</td>
                                                <td>" . $br->contactNumber . '</td>
                                                <td><i class="fa fa-history ngs-history"></i></td>
                                            </tr>';
                                                                                        $i++;
                                                                                    }
                                                                                    print '</tbody>'
                                                                                            . '</table>';
                                                                                }
                                                                                ?>

                                                                            </div>
                                                                            <!-- end widget content -->

                                                                        </div>
                                                                        <!-- end widget div -->

                                                                    </div>
                                                                    <!-- end widget -->

                                                                </article>
                                                                <!-- WIDGET END -->

                                                            </div>

                                                            <!-- end row -->

                                                            <!-- end row -->

                                                        </section>
                                                        <!-- end widget grid -->


                                                        </div>
                                                        <!-- END MAIN CONTENT -->


                                                        </div>
                                                        <!-- END MAIN PANEL -->
                                                        <!-- ==========================CONTENT ENDS HERE ========================== -->

                                                        <!-- PAGE FOOTER -->
                                                        <?php
// include page footer
                                                        include("../inc/footer.php");
                                                        ?>
                                                        <!-- END PAGE FOOTER -->

                                                        <?php
//include required scripts
                                                        include("../inc/scripts.php");
                                                        ?>
                                                        <!-- PAGE RELATED PLUGIN(S) -->
                                                        <script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
                                                        <script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
                                                        <script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
                                                        <script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
                                                        <script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

                                                        <script type="text/javascript" src="<?php echo ASSETS_URL; ?>/jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
                                                        <link href="<?php echo ASSETS_URL; ?>/jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
                                                        <link href="<?php echo ASSETS_URL; ?>/jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />

                                                        <script type="text/javascript">
<?php
if ($close) {
    print "window.opener.location.reload(false);";
    print "window.close();";
}
?>

                                                            $('.ngs-popup-br').click(function () {
                                                                var url = '../branch/edit?br_id=' + this.id;
                                                                window.open(url, '_blank');
                                                            });
                                                            $('.ngs-popup-eq').click(function () {
                                                                edit_equipment(this.id);
                                                            });

                                                            $('.ngs-history').click(function (event) {
                                                                event.stopPropagation();
                                                                var id = $(this).closest('tr').prop('id');
                                                                var url = 'customer_branch_history.php?br_id=' + id + "&<?php print SID ?>";
                                                                window.open(url, '_blank');
                                                            });
                                                        </script>

                                                        <script type="text/javascript">

                                                        // DO NOT REMOVE : GLOBAL FUNCTIONS!

                                                            $(document).ready(function () {

                                                                /* // DOM Position key index //
         
                                                                 l - Length changing (dropdown)
                                                                 f - Filtering input (search)
                                                                 t - The Table! (datatable)
                                                                 i - Information (records)
                                                                 p - Pagination (paging)
                                                                 r - pRocessing 
                                                                 < and > - div elements
                                                                 <"#id" and > - div with an id
                                                                 <"class" and > - div with a class
                                                                 <"#id.class" and > - div with an id and class
         
                                                                 Also see: http://legacy.datatables.net/usage/features
                                                                 */

                                                                /* BASIC ;*/
                                                                var responsiveHelper_dt_basic = undefined;
                                                                var responsiveHelper_datatable_fixed_column = undefined;
                                                                var responsiveHelper_datatable_col_reorder = undefined;
                                                                var responsiveHelper_datatable_tabletools = undefined;

                                                                var breakpointDefinition = {
                                                                    tablet: 1024,
                                                                    phone: 480
                                                                };


                                                                /* END BASIC */


                                                                /* TABLETOOLS */
                                                                     $('#t_cus_eq_list').DataTable({

                                                                        responsive: true,
                                                                        dom: "<'dt-toolbar '<'col-sm-6 col-xs-12 hidden-xs' B><'col-sm-6 col-xs-12' f>>" +
                                                                                "t" +
                                                                                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",

                                                                        buttons: [

                                                                            {extend: 'csv', title: '<?php print $cus->name ?>_systems_csv'},
                                                                            {extend: 'excel', title: '<?php print $cus->name ?>_systems_excel'},
                                                                            {extend: 'pdf', title: '<?php print $cus->name ?>_systems_pdf'},

                                                                            {extend: 'print',
                                                                                customize: function (win) {
                                                                                    $(win.document.body).addClass('white-bg');
                                                                                    $(win.document.body).css('font-size', '15px');

                                                                                    $(win.document.body).find('table')
                                                                                            .addClass('compact')
                                                                                            .css('font-size', 'inherit');
                                                                                }
                                                                            }
                                                                        ]

                                                                    });
                                                               /* $('#t_cus_eq_list').dataTable({

                                                                    // Tabletools options: 
                                                                    //   https://datatables.net/extensions/tabletools/button_options
                                                                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                                                                            "t" +
                                                                            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
                                                                    "oTableTools": {
                                                                        "aButtons": [
                                                                            "copy",
                                                                            "csv",
                                                                            "xls",
                                                                            {
                                                                                "sExtends": "pdf",
                                                                                "sTitle": "SmartAdmin_PDF",
                                                                                "sPdfMessage": "SmartAdmin PDF Export",
                                                                                "sPdfSize": "letter"
                                                                            },
                                                                            {
                                                                                "sExtends": "print",
                                                                                "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                                                                            }
                                                                        ],
                                                                        "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
                                                                    },
                                                                    "autoWidth": true,
                                                                    "preDrawCallback": function () {
                                                                        // Initialize the responsive datatables helper once.
                                                                        if (!responsiveHelper_datatable_tabletools) {
                                                                            responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#t_cus_eq_list'), breakpointDefinition);
                                                                        }
                                                                    },
                                                                    "rowCallback": function (nRow) {
                                                                        responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
                                                                    },
                                                                    "drawCallback": function (oSettings) {
                                                                        responsiveHelper_datatable_tabletools.respond();
                                                                    }
                                                                });*/
                                                                    $('#t_cus_cons_list').DataTable({

                                                                        responsive: true,
                                                                        dom: "<'dt-toolbar '<'col-sm-6 col-xs-12 hidden-xs' B><'col-sm-6 col-xs-12' f>>" +
                                                                                "t" +
                                                                                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",

                                                                        buttons: [

                                                                            {extend: 'csv', title: '<?php print $cus->name ?>_consumable_csv'},
                                                                            {extend: 'excel', title: '<?php print $cus->name ?>_consumable_excel'},
                                                                            {extend: 'pdf', title: '<?php print $cus->name ?>_consumable_pdf'},

                                                                            {extend: 'print',
                                                                                customize: function (win) {
                                                                                    $(win.document.body).addClass('white-bg');
                                                                                    $(win.document.body).css('font-size', '15px');

                                                                                    $(win.document.body).find('table')
                                                                                            .addClass('compact')
                                                                                            .css('font-size', 'inherit');
                                                                                }
                                                                            }
                                                                        ]

                                                                    });
                                                               /* $('#t_cus_cons_list').dataTable({

                                                                    // Tabletools options: 
                                                                    //   https://datatables.net/extensions/tabletools/button_options
                                                                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                                                                            "t" +
                                                                            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
                                                                    "oTableTools": {
                                                                        "aButtons": [
                                                                            "copy",
                                                                            "csv",
                                                                            "xls",
                                                                            {
                                                                                "sExtends": "pdf",
                                                                                "sTitle": "SmartAdmin_PDF",
                                                                                "sPdfMessage": "SmartAdmin PDF Export",
                                                                                "sPdfSize": "letter"
                                                                            },
                                                                            {
                                                                                "sExtends": "print",
                                                                                "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                                                                            }
                                                                        ],
                                                                        "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
                                                                    },
                                                                    "autoWidth": true,
                                                                    "preDrawCallback": function () {
                                                                        // Initialize the responsive datatables helper once.
                                                                        if (!responsiveHelper_datatable_tabletools) {
                                                                            responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#t_cus_cons_list'), breakpointDefinition);
                                                                        }
                                                                    },
                                                                    "rowCallback": function (nRow) {
                                                                        //responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
                                                                    },
                                                                    "drawCallback": function (oSettings) {
                                                                        responsiveHelper_datatable_tabletools.respond();
                                                                    }
                                                                });
                                                                */
                                                                $('#t_cus_br_list').dataTable({

                                                                    // Tabletools options: 
                                                                    //   https://datatables.net/extensions/tabletools/button_options
                                                                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                                                                            "t" +
                                                                            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
                                                                    "oTableTools": {
                                                                        "aButtons": [
                                                                            "copy",
                                                                            "csv",
                                                                            "xls",
                                                                            {
                                                                                "sExtends": "pdf",
                                                                                "sTitle": "SmartAdmin_PDF",
                                                                                "sPdfMessage": "SmartAdmin PDF Export",
                                                                                "sPdfSize": "letter"
                                                                            },
                                                                            {
                                                                                "sExtends": "print",
                                                                                "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                                                                            }
                                                                        ],
                                                                        "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
                                                                    },
                                                                    "autoWidth": true,
                                                                    "preDrawCallback": function () {
                                                                        // Initialize the responsive datatables helper once.
                                                                        if (!responsiveHelper_datatable_tabletools) {
                                                                            responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#t_cus_br_list'), breakpointDefinition);
                                                                        }
                                                                    },
                                                                    "rowCallback": function (nRow) {
                                                                        responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
                                                                    },
                                                                    "drawCallback": function (oSettings) {
                                                                        responsiveHelper_datatable_tabletools.respond();
                                                                    }
                                                                });
                                                                /* END TABLETOOLS */

                                                                /*NGS addings*/

                                                                var del = 0;
                                                                $('#add_eq').click(function () {
                                                                    add_equipment('<?php print $cid ?>');
                                                                });
                                                                $('#add_br').click(function () {
                                                                    add_branch('<?php print $cid ?>');
                                                                });
                                                                $('#but_del').click(function () {
                                                                    if (del == 0) {
                                                                        $("#warning_delete").css("display", "block");
                                                                        $('#but_del').text("Confirm Delete");
                                                                        $('#submit_value').val("delete");
                                                                        del = 1;
                                                                    } else {
                                                                        $('#form_edit').submit();
                                                                    }
                                                                });

                                                                $('#cus_group').autocomplete({
                                                                    source: 'json/get_group',
                                                                    minLength: 1,
                                                                    select: function (event, ui) {
                                                                        var id = ui.item.id;
                                                                        if (id != '') {
                                                                            $('#cus_group_id').val(id);
                                                                        }
                                                                    },
                                                                });
                                                                $('#cus_acc_owner').autocomplete({
                                                                    source: '../json/get_employee',
                                                                    minLength: 1,
                                                                    select: function (event, ui) {
                                                                        var id = ui.item.id;
                                                                        if (id != '') {
                                                                            $('#cus_acc_owner_id').val(id);
                                                                        }
                                                                    },
                                                                });

<?php
if (($ary_prev[6][2] == '1') || ($ary_prev[6][1] == '1')) {
    print '$( "#but" ).prop( "disabled", false );';
}

if (($ary_prev[6][3] == '1')) {
    print '$( "#but_del" ).prop( "disabled", false );';
    print ' $(".delbtn").show();';
}
?>

                                                            });

                                                            function open_history(id) {

                                                            }
                                                            function add_branch(cid) {
                                                                var options = {
                                                                    url: '../branch/add?<?php print SID . "&" ?>cid=' + cid,
                                                                    width: '600',
                                                                    height: '500',
                                                                    skinClass: 'jg_popup_round'
                                                                };
                                                                $.jeegoopopup.open(options);
                                                            }
                                                            function add_equipment(brid) {
                                                                var options = {
                                                                    url: '../equipment/add?<?php print SID . "&" ?>cus_ent_id=' + brid,
                                                                    width: '600',
                                                                    height: '500',
                                                                    skinClass: 'jg_popup_round'
                                                                };
                                                                $.jeegoopopup.open(options);
                                                            }
                                                            function edit_equipment(eqid) {
                                                                var options = {
                                                                    url: '../equipment/edit?<?php print SID . "&" ?>eq_id=' + eqid,
                                                                    width: '600',
                                                                    height: '500',
                                                                    skinClass: 'jg_popup_round'
                                                                };
                                                                $.jeegoopopup.open(options);
                                                            }
                                                        </script>
