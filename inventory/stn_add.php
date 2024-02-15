<?php
session_start();
//initilize the page
//print_r($_SESSION);
require_once ("../lib/config.php");

$ary_prev = $_SESSION['USER_PREV'];
//print_r($ary_prev[6]);
//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "STN Add/Edit";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["inventory"]["sub"]["stn"]["active"] = true;
//include("..inc/nav.php");
// ====================== LOGIC ================== --!>
//include_once 'lib/i3c_config.php';
include_once '../class/stn.php';
include_once '../class/rma.php';
include_once '../class/cls_stn_system.php';
include_once '../class/fault_ticket.php';
include_once '../class/employee.php';
include_once '../class/cls_log.php';
include_once '../class/cls_inventory_item.php';

$stn_id = $_REQUEST['inv_stn_id'];
//print_r($_POST);

$log=new log();

/////////RMA
if($_REQUEST['source']=='RMA'){
    //check items are not already added
    $can_add=true;
    $ary_ids= explode('|', $_REQUEST['ids']);
    foreach ($ary_ids as $id){
        if($id!=""){
            $trk_item=new inventory_track_item($id);
            $trk_item->getData();
            if($trk_item->status!= constants::$STN_OPEN){
                $can_add=false;
            }
        }
    }
    if($can_add){
        //Add STN and its Items
        $rma=new rma($_REQUEST['rma_id']);
        $rma->getRMA();

        $stn = new stn();
        $stn->from_customer_id = $rma->from_customer_id;
        $stn->to_customer_id = $rma->to_customer_id;
        $stn->emp_added = $_SESSION['EMPID'];
        $stn->note = $rma->note;
        $stn->vendor="Y";
        $stn->addSTN();
        $stn_id=$stn->id;
        //print $_REQUEST['ids'];
        $ary_ids= explode('|', $_REQUEST['ids']);
        //print_r($ary_ids);
        foreach ($ary_ids as $id){
            if($id!=""){
                $trk_item=new inventory_track_item($id);
                $trk_item->getData();
                //var_dump($trk_item);
                if($trk_item->system_type=='I'){    
                    $item_id = $stn->addSTNItem($stn_id, $trk_item->systems_id, $trk_item->serial,"",$stn->from_customer_id,$stn->to_customer_id,'1',$trk_item->customer_system_id,"");
                    if($item_id){
                        $systems = new system($trk_item->customer_system_id);
                        $systems->getSystem();
                        $systems->setStatus(constants::$SYS_IN_STN);

                        $trk_item->setItemStatus(constants::$STN_CONF);
                        $trk_item->addNote($stn->ref_no);
                        $trk_item->addChainReference($item_id);
                    }
                }
                else{
                    //print "CCCCC";
                }
            }
        }
        $url="stn_add?".SID."&inv_stn_id=".$stn_id;
        header("Location:".$url);
    }
    else{
        $msg="<font color='red'>cannot add STN. one or more item is not in active condition to add</font>";
    }
}

if ($_POST['submitted'] == 'reopen') {
    //Open STN Again //Add log
    $stn = new stn($stn_id);
    $stn->loguserid=$_SESSION['EMPID'];
    $res_open=$stn->reOpen();
    
} else if ($_POST['submitted'] == 'conf') {
    $stn_attention_to = $_POST['stn_attention_to'];
    $stn = new stn($stn_id);
    $stn->getSTN();
    $stn->note = $_POST['note'];
    $stn->deliverymethod = $_POST['dm'];
    $stn->emp_to = $_POST['stn_emp_id'];
    $stn->loguserid = $_SESSION['EMPID'];
    $prev_stn_to_id = $_POST['prev_stn_to_id'];
    $stn_to_id = $_POST['stn_to_id'];
    $log->setLog($_SESSION['UID'], "STN-CONFIRM", $stn_id, json_encode($_POST));
    if ($prev_stn_to_id != $stn_to_id) {
        //change location to new location
        $log_str="STN CHANGE OLD LOCATION $prev_stn_to_id TO $stn_to_id ";
        $log->setLog($_SESSION['UID'], "STN-CONFIRM", $stn_id, $log_str);
        $changeSTN = $stn->changeLocation($prev_stn_to_id, $stn_to_id);
        if ($changeSTN) {
            $stn->updateSTN();
            $add_attention_to = $stn->addattention_to($stn_attention_to);
            if ($stn->ConfirmItemChanges()) {
                if ($stn->confirnSTN()) {
                    
                    $icon = "success";
                    $msg = "STN and it's items updated";
                    $log_str = "STN items updated Ref#" . $stn->ref_no;
                    $confirmed = true;
                } else {
                    $icon = "error";
                    $msg = "STN NOT updated but it's items updated";
                    $log_str = "STN items NOT updated Ref#" . $stn->ref_no;
                    $confirmed = false;
                }
            } else {
                $icon = "error";
                $msg = "STN and it's items could NOT updated";
                $log->setLog($_SESSION['EMPID'], "STN", $stn_id, $log_str);
                $confirmed = false;
            }
        }
    } else {
        
        //$stn->loguserid = $_SESSION['UID'];
        $log_str="CONFIRM WITHOUT LOCATION CHANGE";
        $log->setLog($_SESSION['UID'], "STN-CONFIRM", $grn_id, $log_str);
        $stn->updateSTN();
        $add_attention_to = $stn->addattention_to($stn_attention_to);
        if ($stn->ConfirmItemChanges()) {
            if ($stn->confirnSTN()) {
                $icon = "success";
                $msg = "STN and it's items updated";
                $log_str = "STN items updated Ref#" . $stn->ref_no;
                $confirmed = true;
            } else {
                $icon = "error";
                $msg = "STN NOT updated but it's items updated";
                $log_str = "STN items NOT updated Ref#" . $stn->ref_no;
                $confirmed = false;
            }
        } else {
            $icon = "error";
            $msg = "STN and it's items could NOT updated";
            $log->setLog($_SESSION['EMPID'], "STN", $stn_id, $log_str);
            $confirmed = false;
        }
    }
} else if ($_POST['submitted'] == 'delete') {
    $stn = new stn($stn_id);
    $stn->getSTN();
    $res = $stn->deleteSTNItems();
    if ($res) {
        if ($stn->deleteSTN()) {
            $icon = "success";
            $msg = "STN and it's items deleted";
            $close=true;
            $deleted = true;
        } else {
            $icon = "error";
            $msg = "STN Could not deleted, but items deleted";
            $deleted = false;
        }
    } else {
        $icon = "error";
        $msg = "STN items could not be deleted";
        $deleted = false;
    }
}
$stnrefno = "";

if ($stn_id == '') {
    //$grn_no=$grn->getNextPreGRNNumber();
    $save = true;
} else {
    $stn = new stn($stn_id);
    $stn->getSTN();
    $ary_items = $stn->getSTNItems();
    //var_dump($ary_items);
    $save = true;
    $stnrefno = $stn->ref_no;
    $ft = new fault_ticket($stn->ft_id);
    $ft->getData();
    if ($stn->ft_id != "") {// ft included stn
        $SID = "14";
        $Incident_no = $ft->incidentcode;
    } else {
        $SID = "12";
        $Incident_no = "N/A";
    }



//    print_r($ft);
}

if ($stn->status_id == '1') {
    $conf = true;
    $save = true;
    $edit = true;
} else if ($stn->status_id == '2') {
    $save = false;
    $edit = false;
} else {
    $conf = false;
}
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
                    <div class="jarviswidget" id=""
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i></span>
                            <?php ?>

                            <h2>Add STN &nbsp;&nbsp;</h2>	
                            <?php
                            if ($stn_id != "") {
                                ?>
                                <p></p>
                                <span style="margin-left: 50px; font-size: 14px;">
                                    Ref No :<b style="color: #000080;" >&nbsp;&nbsp;<?php print $stnrefno ?></b>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Incident Id :<b style="color: #000080;" >&nbsp;&nbsp;<?php print $Incident_no ?></b>
                                </span>

                                <?php
                            }
                            ?>
                            <?php
                            if ($ft->id != "") {
                                ?>
                                <div class="pull-right">

                                    <span style="margin-left: 20px;margin-right: 10px;font-weight: bold;">Fault Ticket:</span>
                                    <span style="margin-right: 30px;font-weight: bold; color: green;"><a target="_blank" href="../ft/edit?tid=<?= $ft->id ?>" ><?php print $ft->ref_no ?></a></span>
                                </div>
                            <?php } ?>
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
                                <form id="from_inventory_add" class="smart-form" method="post" action="">
                                    <br>

                                    <table id="tbl1"   class="table" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center"><strong>From:</strong></td>
                                                <td>
                                                    <label class="input"><i class="icon-append fa fa-home"></i>
                                                        <input type="text"  name="stn_from" id="stn_from" placeholder="From Location" autocomplete="off" value="<?php print $stn->from_customer_name ?>">
                                                        <b class="tooltip tooltip-bottom-right">From Location</b>
                                                    </label>
                                                </td>
                                                
                                                <td align="center"><strong>To:</strong></td>
                                                <td style="width: 50px">
                                                    <label class="checkbox ">
                                                        Vendor<input class="" name="stn_chb_vendor" id="stn_chb_vendor" <?php if($stn->vendor=="Y"){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="input"><i class="icon-append fa fa-home"></i>
                                                        <input type="text" name="stn_to" id="stn_to" placeholder="To Location" autocomplete="off" value="<?php print $stn->to_customer_name ?>">
                                                        <b class="tooltip tooltip-bottom-right">To Location</b>
                                                    </label>
                                                </td>
                                                <td align="right"><strong>Handed Over To:</strong></td>
                                                <td>
                                                    <label class="input"><i class="icon-append fa fa-user"></i>
                                                        <input type="text" name="stn_emp" id="stn_emp" placeholder="Employee" autocomplete="off" value="<?php print $stn->emp_to_name ?>">
                                                        <b class="tooltip tooltip-bottom-right">Employee</b>
                                                    </label>
                                                </td>
                                                <td align="right"><strong>Attention To</strong></td>
                                                <td>
                                                    <label class="input"><i class="icon-append fa fa-user"></i>
                                                        <input type="text" name="stn_attention_to" id="stn_attention_to" placeholder="Attention to" autocomplete="off" value="<?php print $stn->attention_to ?>">
                                                        <b class="tooltip tooltip-bottom-right">Attention to</b>
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="right"><strong>Note:</strong></td>
                                                <td>
                                                    <label class="textarea">
                                                        <textarea rows="2" style="width: 100%;" name="note" id="note" placeholder="Note"><?php print $stn->note ?></textarea> 
                                                        <b class="tooltip tooltip-bottom-right">Note</b>
                                                    </label>
                                                </td>
                                                <td align="right" colspan="2"><strong>Delivery Method:</strong></td>
                                                <td>
                                                    <label class="textarea">
                                                        <textarea rows="2" style="width: 100%;" name="dm" id="dm" placeholder="Delivery Method"><?php print $stn->deliverymethod ?></textarea> 
                                                        <b class="tooltip tooltip-bottom-right">Note</b>
                                                    </label>
                                                </td>
                                                <?php
                                                if ($stn_id != "") {
                                                    ?>
                                                    <td style="padding: 10px;" align="right"><strong>Created Date:</strong></td>
                                                    <td style="padding: 10px;"  ><b  style="color: #008200;" >
                                                            &nbsp; &nbsp;
                                                            <?php print $stn->date_added; ?></b>
                                                    </td>
                                                    <td style="padding: 10px;" align="right"><strong>Created By:</strong></td>
                                                    <td style="padding: 10px;"  >
                                                        <b style="color: saddlebrown;" >
                                                            &nbsp; &nbsp;
                                                            <?php
                                                            print $stn->emp_added_name;
                                                            ?>
                                                        </b>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <br>
                                    <div style="border-top: 1px solid gray; width: 80%; margin-left: auto;margin-right: auto;">
                                        <label style="width: 100%; text-align: center;"><h3>STN Items</h3></label>

                                    </div>
                                    <?php if ($save) { ?>
                                        <div class="row do-not-print" id="row_1" style="margin: 0px 10px 0px 10px;">
                                            <section class="col col-4">
                                                <label class="label font-xs">Description</label>
                                                <label class="input">
                                                    <input type="text" class="" name="" id="inv_part_name" autocomplete="off" placeholder="Description">
                                                    <b class="tooltip tooltip-bottom-right">Description</b> 
                                                </label>
                                            </section>

                                            <section class="col col-3">
                                                <label class="label font-xs">Serial</label>
                                                <label class="input">
                                                    <input type="text" name="" value="" id="inv_serial" autocomplete="off" placeholder="Serial">
                                                    <b class="tooltip tooltip-bottom-right">Serial</b> </label>
                                                <label class="label font-xs" id="txt_bin"></label>
                                            </section>
                                            <section class="col col-1">
                                                <label class="label font-xs">Qty</label>
                                                <label class="input">
                                                    <input type="text" name="inv_qty" id="inv_qty" autocomplete="off" placeholder="Qty">
                                                    <b class="tooltip tooltip-bottom-right">Qty</b> </label>
                                                <label class="label font-xs" id="txt_cost"></label>
                                            </section>
                                            <section class="col col-1">
                                                <label class="label font-xs">AVL QTY</label>
                                                <span id="lbl_avl_qty"></span>
                                                <input type="hidden" id="inv_type" value="">
                                                <input type="hidden" id="inv_available" value="">
                                                <input type="hidden" id="inv_systems_id" value="">
                                            </section>
                                            <section class="col col-1">
                                                <label class="label font-xs">Issue Ref#</label>
                                            </section>
                                            <section class="col col-1">
                                                <label class="label font-xs">Date</label>
                                            </section>
                                            <section class="col col-1">
                                                <label class="label font-xs">..</label>
                                            </section>
                                        </div>
                                    <?php } else { ?>

                                        <div class="row"  style="margin: 0px 10px 0px 10px;">
                                            <section class="col col-4">
                                                <h6>Description</h6>
                                            </section>
                                            <section class="col col-3">
                                                <h6> Serial</h6>
                                            </section>
                                            <section class="col col-1">
                                                <h6>  Qty</h6>
                                            </section>
                                            <section class="col col-1">
                                                <h6></h6>
                                            </section>
                                            <section class="col col-1">
                                                <h6>  Issue Ref#</h6>
                                            </section>
                                            <section class="col col-1">
                                                <h6>  Date</h6>
                                            </section>
                                            <section class="col col-1">

                                            </section>
                                        </div>

                                        <?php
                                    }
                                    $inv_item = new \inventory_track_item();
                                    $can_delete = true;
                                    
                                    foreach ($ary_items as $inv_item) {
                                        //print "Status".$inv_item->status;
                                        if ($inv_item->status == '2' ) {
                                            $can_delete = false;
                                        }
                                        if($inv_item->status==constants::$STOCK_ITEM_ERROR){
                                            $flg="fnt_lgt_red";
                                        }
                                        else{
                                            $flg="";
                                        }
                                        //
                                        $issue_ref=$inv_item->issue_reference;
                                        //IF ERROR
                                        if($inv_item->status==constants::$STOCK_ITEM_ERROR){
                                            $issue_ref= $inv_item->note;
                                        }
                                        //IF return item
                                        if($inv_item->flag_str=="R"){
                                            $flg=$flg." fnt_lgt_red";
                                        }
                                        else if(is_numeric($inv_item->flag_str)){
                                            $flg=$flg." fnt_lgt_blue";
                                        }
                                        else{
                                            $flg=$flg;
                                        }
                                        print '<div class="row '.$flg.'" id="' . $inv_item->id . '" style="margin: 0px 10px 0px 10px;border-bottom: 1px dashed #dbd6d6;"><section class="col col-4">'
                                                . $inv_item->system_name . '</section><section class="col col-3">'
                                                . $inv_item->serial . '</section><section class="col col-1">'
                                                . $inv_item->qty . '</section><section class="col col-1"></section><section class="col col-1">'
                                                . $issue_ref. '</section><section class="col col-1">'
                                                . $inv_item->date. '</section><section class="col col-1">';
                                        if($inv_item->status=='1' && $stn->status_id=='1'){
                                            print 
                                                '<a class="delbtn"   href="javascript:delete_item(' . "'$inv_item->id'" . ')"><img alt="" src="../img/cross.png" width="16px" height="16px"></a>';
                                        }
                                        else if($inv_item->status==constants::$STOCK_ITEM_CLOSED && $stn->status_id==constants::$STN_CONF && $stn->vendor=="Y"){
                                            print 
                                                '<a href="javascript:return_item('.$inv_item->id.')" title="return same"><i class="fa fa-reply" style="margin-left:10px;" aria-hidden="true"></i></a>'
                                                . '<a href="javascript:add_new_item('.$inv_item->id.')" title="add new"><i class="fa fa-plus-square-o" style="margin-left:10px;" aria-hidden="true"></a></i>'
                                                . '<a href="javascript:discontinue_item('.$inv_item->id.')" title="discontinue"><i class="fa fa-ban" style="margin-left:10px;" aria-hidden="true"></a></i>';
                                                
                                        }
                                        else if($inv_item->status==constants::$STOCK_ITEM_CLOSED && $stn->status_id==constants::$STN_OPEN && $inv_item->flag_str==""){
                                            //Return but for item
                                            print 
                                                '<a class="delbtn"   href="javascript:reverse_item(' . "'$inv_item->id'" . ')" title="revers item"><i class="fa fa-undo" style="margin-left:10px;" aria-hidden="true"></i></a>';
                                        }
                                        if(!is_numeric($inv_item->flag_str)){
                                            print "<span class='fnt_lgt_red'>".$inv_item->flag_str."</span>";
                                        }
                                        print '</section></div>';
                                    }
                                    ?>

                                    <footer>	
                                        <div class="row do-not-print">	
                                            <section class="col col-3">

                                            </section>
                                            <section class="col col-2">

                                            </section>
                                            <section class="col col-3">
                                                <span id="msg_span"><?php print $msg ?></span>
                                            </section>
                                            <section class="col col-4">
                                                <input type="hidden" name="inv_stn_id" id="inv_stn_id" value="<?php print $stn_id ?>">
                                                <input type="hidden" name="inv_prd_id" id="inv_prd_id" value="">	
                                                <input type="hidden" name="stn_from_id" id="stn_from_id" value="<?php print $stn->from_customer_id ?>">
                                                <input type="hidden" name="stn_to_id" id="stn_to_id" value="<?php print $stn->to_customer_id ?>">
                                                <input type="hidden" name="prev_stn_to_id" id="prev_stn_to_id" value="<?php print $stn->to_customer_id ?>">
                                                <input type="hidden" name="stn_emp_id" id="stn_emp_id" value="<?php print $stn->emp_to ?>">
                                                <input type="hidden" name="submitted" id="submitted" value="">
                                                <?php if ($ary_prev[6][4] == '1' && $stn->status_id==constants::$STN_CONF) { ?>
                                                    <button type="button" class="btn btn-primary" id="but_reopen" name="but" value="reopen">
                                                        Re-Open
                                                    </button>
                                                <?php }if ($ary_prev[6][1] == '1' && $save) { ?>
                                                    <button type="button" class="btn btn-primary" id="but_save" name="but" value="save">
                                                        Save
                                                    </button>
                                                <?php }if ($ary_prev[6][2]=='1' && $conf) { ?>
                                                    <button type="button" class="btn btn-primary" id="but_conf" name="but" value="confirm">
                                                        Confirm
                                                    </button>
                                                <?php }if ($ary_prev[6][3]=='1' && $can_delete) { ?>
                                                    <button type="button" class="btn btn-danger" id="but_del" name="but" value="delete">
                                                        Delete
                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                                <button type="button" class="btn btn-success" id="print" name="print" value="print">
                                                    Print
                                                </button>
                                            </section>
                                        </div>		

                                        <p style="display: none;" id="msg_prev"><?php print $msg ?></p>
                                    </footer>
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

<script type="text/javascript">
    checkUserPopUpBlank('<?php print $_SESSION['UID'] ?>');
<?php
if ($close) {
    print "window.opener.location.reload(false);";
    //print "window.close();";
}
//$msg = "TEST";
//$icon="error";
?>
// DO NOT REMOVE : GLOBAL FUNCTIONS!

    var del = 0;
    var flag = false;
    var flagdel = false;
    var flag_reverse = false;
    


    $(document).ready(function () {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
  <?php if($msg !="") { ?>
            Swal.fire({
            position: 'top-end',
            icon: '<?php print $icon ?>',
            title: "<?php print $msg ?>",
            showConfirmButton: false,
            timer: 2500
          })
<?php }?>
<?php
if (($ary_prev[6][2] == '1') || ($ary_prev[6][1] == '1')) {
    print '$( "#but_conf" ).prop( "disabled", false );';
    print '$( "#but_save" ).prop( "disabled", false );';
    print ' $(".crossdel").hide();';
    print ' flag=true;';
}

if (($ary_prev[6][3] == '1')) {
    print '$( "#but_del" ).prop( "disabled", false );';
    print ' $(".delbtn").show();';
    print ' flagdel=true;';
}
if (($ary_prev[6][2] == '1')) {
    print 'flag_reverse=true;';
}
?>


        if ($('#inv_stn_id').val() != "") {
            $("#stn_from").prop("disabled", true);
        }



<?php
if (!$edit) {
    print "$('.delbtn').hide();";
    print "$('#but_del').hide();";
}

if ($confirmed == true) {
    print "goSTN();";
}


if ($deleted == true) {
    ?>
    $("button").hide();

    <?php
}
?>


        $('#print').click(function (e) {
            var inv_stn_id = $("#inv_stn_id").val();
            if(inv_stn_id !=""){
            var stn_attention_to = $("#stn_attention_to").val();
            if(stn_attention_to ==""){
                alert("please fill Attention to:");
                $("#stn_attention_to").focus();
                return
        }
        var params = {
                    id:inv_stn_id,
                    attention_to: stn_attention_to
                  };

                  // Encode the parameters
                  var encodedParams = Object.keys(params)
                    .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(params[key]))
                    .join('&');

            var url = 'stn_print_view?'+encodedParams;
            var NWin = window.open(url, '_blank');
            if (window.focus)
            {
                NWin.focus();
            }
        }
        });


        $('#but_save').click(function (e) {
            e.preventDefault();
            if ($('#stn_to_id').val() == "") {
                alert("please select destination location");
            } else {
                addItems(true);
                $("#msg_span").html("STN added successfully. you can close this window");
                $("#msg_span").addClass("fnt_lgt_blue");
            }
        });
        $('#but_conf').click(function () {
            var prev_stn_to_id = $('#prev_stn_to_id').val();
            var stn_to_id = $('#stn_to_id').val();
            if(stn_to_id ==""){
                Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Please select vendor from list',
                        showConfirmButton: false,
                        timer: 2000
                      })
                      
                      
                      return ;
            }
            if(prev_stn_to_id != stn_to_id){
                  swalWithBootstrapButtons.fire({
                      title: 'Are you sure?',
                      text: "You want to change the location!",
                      icon: 'question',
                      showCancelButton: true,
                      confirmButtonText: 'Yes, Change it!',
                      cancelButtonText: 'No, cancel!',
                      reverseButtons: true,
                      position:'top'
                    }).then((result) => {
                      if (result.isConfirmed) {
                         $('#submitted').val("conf");
                         addItems(true);
                         $('#from_inventory_add').submit();
                      } else if (result.dismiss === Swal.DismissReason.cancel  ) /* Read more about handling dismissals below */
                                        {
                                            location.reload();
                                          /*swalWithBootstrapButtons.fire(
                                            'Cancelled',
                                            'Your imaginary file is safe :)',
                                            'error'
                                          )*/
                                        }
                    })
            }else {
            $('#submitted').val("conf");
            addItems(true);
            $('#from_inventory_add').submit();
        }
        });
        $('#but_reopen').click(function () {
            $('#submitted').val("reopen");
            $('#from_inventory_add').submit();
        });
        $('#but_del').click(function () {
            swalWithBootstrapButtons.fire({
                      title: 'Are you sure?',
                      text: "STN and its items will be deleted!",
                      icon: 'question',
                      showCancelButton: true,
                      confirmButtonText: 'Yes',
                      cancelButtonText: 'No',
                      reverseButtons: true,
                      position:'center'
                    }).then((result) => {
                      if (result.isConfirmed) {
                         $('#submitted').val("delete");
                         $('#from_inventory_add').submit();
                      } else if (result.dismiss === Swal.DismissReason.cancel  ) /* Read more about handling dismissals below */
                        {
                            location.reload();

                        }
                    })
            /*$('#submitted').val("delete");
            
            var newDiv = $(document.createElement('div'));
            $(newDiv).html('STN and its items will be deleted.Are you sure?');
            $(newDiv).attr('title', 'Delete STN');
            //$(newDiv).css('font-size','62.5%');
            $(newDiv).dialog({
                resizable: false,
                height: 160,
                modal: true,
                buttons: {
                    "Yes": function () {
                        $('#from_inventory_add').submit();
                        $(this).dialog("close");
                    },
                    Cancel: function () {
                        $(this).dialog("close");
                    }
                }
            });*/
        });
        $('#stn_from').autocomplete({
            source: function (request, response) {
                $.getJSON(
                        "../json/get_customer_entity",
                        {term: request.term, type: "", exclude: $('#stn_to_id').val()},
                        response
                        );
            },
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                var prd = ui.item.name;
                if (id != '') {
                    $('#stn_from_id').val(id);
                }
            }
        });
        $('#stn_to').autocomplete({
            source: function (request, response) {
                $.getJSON(
                        "../json/get_customer_entity",
                        {term: request.term, type: "", exclude: $('#stn_from_id').val(),to_vendor:$('#stn_chb_vendor').prop("checked")},
                        response
                        );
            },
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                var prd = ui.item.name;
                if (id != '') {
                    $('#stn_to_id').val(id);
                }
            }
        });
        $('#stn_emp').autocomplete({
            source: function (request, response) {
                $.getJSON(
                        "../json/get_employee",
                        {term: request.term},
                        response
                        );
            },
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                var prd = ui.item.name;
                if (id != '') {
                    $('#stn_emp_id').val(id);
                }
            }
        });

        $('#inv_part_name').autocomplete({
            source: function (request, response) {
                if ($('#stn_from_id').val() == "") {
                    $('#stn_from').addClass('ngs_input_invalid');
                } else {
                    $('#stn_from').removeClass('ngs_input_invalid');
                }
                $.getJSON(
                        "../json/get_inventory_items",
                        {term: request.term, cus_id: $('#stn_from_id').val(), status: "0"},
                        response
                        );
            },
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                var serial = ui.item.serial;
                var type = ui.item.type;
                if (type == 'I') {
                    $('#inv_qty').hide();
                    $('#lbl_avl_qty').text("");
                    $('#inv_serial').prop( "disabled", false );
                    $('#inv_available').val(1);
                    $('#inv_type').val(type);
                } else {
                    $('#inv_qty').show();
                    $('#lbl_avl_qty').text(ui.item.balance_string);
                    $('#inv_serial').prop( "disabled", true );
                    $('#inv_available').val(ui.item.balance);
                    $('#inv_type').val(type);
                }
                if (id != '') {
                    $('#inv_prd_id').val(id);
                    $('#inv_serial').val(serial);
                    $('#inv_serial').focus();
                    $('#inv_systems_id').val(ui.item.systems_id);
                }
            }
        });
        $('#inv_serial').autocomplete({
            source: function (request, response) {
                if ($('#stn_from_id').val() == "") {
                    $('#stn_from').addClass('ngs_input_invalid');
                } else {
                    $('#stn_from').removeClass('ngs_input_invalid');
                }
                $.getJSON(
                        "../json/get_inventory_items",
                        {term: request.term, option: "serial", cus_id: $('#stn_from_id').val(), status: "0"},
                        response
                        );
            },
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                var serial = ui.item.serial;
                var type = ui.item.type;
                var details = ui.item.details;

                if (type == 'I') {
                    $('#inv_qty').hide();
                } else {
                    $('#inv_qty').show();
                }
                if (id != '') {
                    event.preventDefault();
                    $('#inv_prd_id').val(id);
                    $("#inv_serial").val(serial);
                    $('#lbl_avl_qty').text("");
                    $("#inv_part_name").val(details);
                    $('#inv_systems_id').val(ui.item.systems_id);
                    $('#inv_type').val(type);
                }
            }
        });


        $('#inv_qty').keyup(function (e) {

            e.stopPropagation();
            if (e.keyCode == 13)
            {
                e.preventDefault();
                if ($('#stn_to_id').val() == "") {
                    alert("please select destination location");
                } else {
                    addItems();
                }
            }
        });
        $('#inv_serial').keyup(function (e) {
            if ($('#inv_serial').val() == "") {
                clear();
            }

            e.stopPropagation();
            if (e.keyCode == 13)
            {
                e.preventDefault();
                if ($('#stn_to_id').val() == "") {
                    alert("please select destination location");
                } else {
                    addItems();
                }
            }
        });

        $('#inv_part_name').keyup(function (e) {
            if ($('#inv_part_name').val() == "") {
                clear();
            }

        });

    });


    function goSTN() {
        setTimeout(
                function ()
                {
                    location.href = "stn_view";
                }, 2500);
    }

    function clear() {
        $('#inv_serial').val("");
        $('#inv_part_name').val("");
        $('#inv_qty').val("");
        $('#inv_qty').show();
        $('#inv_serial').prop( "disabled", false );
        $('#inv_available').val("");
        $('#inv_type').val("");
    }

    function addItems(update) {

        if (!flag) {
            alert("You haven't rights to do this activity!");
            return;
        }

        var prd_id = $('#inv_prd_id').val();
        var prd_name = $('#inv_part_name').val();
        var serial = $('#inv_serial').val();
        var from = $('#stn_from_id').val();
        var to = $('#stn_to_id').val();
        var employee = $('#stn_emp_id').val();
        var stn_id = $('#inv_stn_id').val();
        var note = $('#note').val();
        var deliverym = $('#dm').val();
        var qty = $('#inv_qty').val();
        var type = $('#inv_type').val();
        var available = $('#inv_available').val();
        var systems_id = $('#inv_systems_id').val();
        if (prd_id == "") {
//            return;
        }
        if (stn_id != '') {
            if(update){
                $.ajax({
                    url: '../ajax/ajx_stn', //this is the submit URL
                    type: 'POST', //or POST
                    dataType: 'JSON',
                    data: {SID: "13", uid:'<?php print $_SESSION['UID'] ?>',open_emp:'<?php print $_SESSION['EMPID'] ?>', stn_id: stn_id, to_id: to, emp_id: employee, note: note, deliverym: deliverym,to_vendor:$('#stn_chb_vendor').prop("checked")},
                    success: function (response) {
                        //alert(data);
                        if (response['result'] == '1') {
                            stn_id = response['stn_id'];
                            $('#inv_stn_id').val(stn_id);
                            $("#stn_from").prop("disabled", true);
                        } else {
                            alert('could not add STN [0]');
                        }
                    },
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }
            if ((prd_id != "" || systems_id!="")&&prd_name!="") {
                addItem(stn_id, prd_id,systems_id,type,prd_name,serial, qty);
            }
        } else {
            $.ajax({
                url: '../ajax/ajx_stn', //this is the submit URL   --ADD STN
                type: 'POST', //or POST
                dataType: 'JSON',
                data: {SID: "10", uid:<?php print $_SESSION['UID'] ?>,open_emp:<?php print $_SESSION['EMPID'] ?>, from_id: from, to_id: to, emp_id: employee, note: note, deliverym: deliverym,to_vendor:$('#stn_chb_vendor').prop("checked")},
                success: function (response) {
                    //alert(data);
                    if (response['result'] == '1') {
                        stn_id = response['stn_id'];
                        $('#inv_stn_id').val(stn_id);
                        $("#stn_from").prop("disabled", true);
                        addItem(stn_id, prd_id,systems_id,type,prd_name,serial, qty);
                    } else {
                        alert('could not add STN [0]');
                    }
                },
                error: function () {
                    alert("could not add STN [1]");
                }
            });
        }



        console.log(stn_id + "-" + prd_id + "-" + serial + "-" + prd_name + "-" + qty);

    }
    function addItem(stn_id, cus_sys_id,sys_id,sys_type, description, serial, qty) {
        if (stn_id != '') {
            if(parseFloat($('#inv_available').val())>=parseFloat(qty) || sys_type=='I'){
                $.ajax({
                    url: '../ajax/ajx_stn', //this is the submit URL
                    type: 'POST', //or POST
                    dataType: 'JSON',
                    data: {SID: "11", uid:<?php print $_SESSION['UID'] ?>,open_emp:<?php print $_SESSION['EMPID'] ?>, stn_id: stn_id, cus_sys_id: cus_sys_id, qty: qty,system_id:sys_id,system_type:sys_type},
                    success: function (data) {
                        if (data['result'] == '1') {
                            item_id = data['item_id'];
                            iss_ref=data['issue_ref'];
                            addItemInterface(item_id, description, serial, qty,iss_ref);
                        } else if (data['result'] == '2') {
                            alert(data['msg']);
                        } else {
                            alert('could not add STN [0]');
                        }
                    },
                    error: function () {
                        alert("could not add STN [1]");
                    }
                });
            }
            else{
                alert("Qty is grater than available quantity");
            }
        }
    }
    function addItemInterface(item_id, description, serial, qty,iss_ref) {
        if (isNaN(item_id) == false) {

            var html = '<div class="row" id="' + item_id + '" style="margin: 0px 10px 0px 10px;border-bottom: 1px dashed #dbd6d6;"><section class="col col-4">' +
                    description + '</section><section class="col col-3">' +
                    serial + '</section><section class="col col-1">' + qty +
                    '</section><section class="col col-1"></section><section class="col col-1">' + iss_ref +
                    '</section><section class="col col-1"></section><section class="col col-1"><a class="delbtn" href="javascript:delete_item(' + "'" + item_id + "'" + ')"><img alt="" src="../img/cross.png" width="16px" height="16px"></a></section></div>';

            $('#inv_part_name').val('');
            $('#inv_prd_id').val('');
            $('#inv_serial').val('');
            $('#inv_qty').val('');
            $('#inv_serial').prop( "disabled", false );
            $('#inv_available').val("");
            $('#inv_type').val("");
            $('#row_1').after(html);
        } else {
            alert('faile-[NAN]');
        }
    }
    function delete_item(inv_id) {

        if (!flagdel) {
            alert("You haven't rights to do this activity!");
            return;
        }
        var newDiv = $(document.createElement('div'));
        $(newDiv).html('Item will be deleted.Are you sure?');
        $(newDiv).attr('title', 'Delete STN Item');
        //$(newDiv).css('font-size','62.5%');
        $(newDiv).dialog({
            resizable: false,
            height: 160,
            modal: true,
            buttons: {
                "Yes": function () {
                    $.ajax({
                        url: '../ajax/ajx_stn', //this is the submit URL
                        type: 'POST', //or POST
                        dataType: 'JSON',
                        data: {SID: "12", item_id: inv_id, uid:<?php print $_SESSION['UID'] ?>,emp_id:<?php print $_SESSION['EMPID'] ?>, stn_id: $('#inv_stn_id').val(),to_vendor:$('#stn_chb_vendor').prop("checked")},
                        success: function (data) {
                            if (data['result'] == '1') {
                                window.parent.location.reload(false);
                            } else {
                                alert("failure");
                            }
                        },
                        error: function () {
                            alert("failure");
                        }
                    });
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    }
    function reverse_item(inv_id) {

        if (!flag_reverse) {
            alert("You haven't rights to do this activity!");
            return;
        }
        var newDiv = $(document.createElement('div'));
        $(newDiv).html('Item will be revered.Are you sure?');
        $(newDiv).attr('title', 'Reverse STN Item');
        //$(newDiv).css('font-size','62.5%');
        $(newDiv).dialog({
            resizable: false,
            height: 160,
            modal: true,
            buttons: {
                "Yes": function () {
                    $.ajax({
                        url: '../ajax/ajx_stn', //this is the submit URL
                        type: 'POST', //or POST
                        dataType: 'JSON',
                        data: {SID: "15", item_id: inv_id, uid:<?php print $_SESSION['UID'] ?>,emp_id:<?php print $_SESSION['EMPID'] ?>, stn_id: $('#inv_stn_id').val(),to_vendor:$('#stn_chb_vendor').prop("checked")},
                        success: function (data) {
                            if (data['result'] == '1') {
                                window.parent.location.reload(false);
                                $(this).dialog("close");
                            } else {
                                alert("failure");
                            }
                        },
                        error: function () {
                            alert("failure");
                        }
                    });
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    }



    function print_this() {
        window.print();
    }
    
    function return_item(id) {
        var options = {
            url: 'stn_item_return?<?php print SID?>&item_id='+id,
            width: '550',
            height: '300',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }
    function discontinue_item(id) {
        var options = {
            url: 'stn_item_discard?<?php print SID?>&item_id='+id,
            width: '550',
            height: '300',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }
    function add_new_item(id){
        var options = {
            url: 'stn_item_replace?<?php print SID?>&item_id='+id,
            width: '600',
            height: '500',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }
</script>
