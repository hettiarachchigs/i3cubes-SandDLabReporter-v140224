<?php
session_start();
//initilize the page
//print_r($_SESSION);
require_once ("../lib/config.php");
require_once ("../class/ngs_date.php");

$ary_prev = $_SESSION['USER_PREV'];
//print_r($ary_prev[6]);
//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "GRN Add";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["inventory"]["sub"]["grn"]["active"] = true;
//include("..inc/nav.php");
// ====================== LOGIC ================== --!>
//include_once 'lib/i3c_config.php';
include_once '../class/grn.php';
//include_once '../class/system.php';
include_once '../class/cls_log.php';
include_once '../class/cls_inventory_item.php';
$log=new log();
$grn_id = $_REQUEST['inv_grn_id'];
//print_r($_POST);
$effctfate = "";

$deleteflag = false;
$close=false;

if ($_POST['submitted'] == 'save') {

//    if ($_REQUEST['inv_grn_id'] == '') {
//        $grn = new grn();
//        $grn->shipment_id = $_POST['inv_batchno'];
//        $grn->vendor_id = $_POST['inv_supplier_id'];
//        $grn->effective_date = $_POST['inv_date'];
//        $grn->emp_added = $_SESSION['EMPID'];
//        $grn_id = $grn->addGRN();
//        $grn_id = $grn->id;
//        $effctfate = $_POST['inv_date'];
//        if ($grn_id) {
//            $log_str = "GRN added: ";
////                $log->setLog($_SESSION['UID'],'GRN',$grn_id,$log_str);
//        } else {
//            $log_str = "GRN could not added";
////                $log->setLog($_SESSION['UID'],'GRN','0',$log_str);
//        }
//    } else {
//        $grn_id = $_REQUEST['inv_grn_id'];
//        $grn = new grn($grn_id);
//        $grn->shipment_id = $_POST['inv_batchno'];
//        $grn->vendor_id = $_POST['inv_supplier_id'];
//        $grn->effective_date = $_POST['inv_date'];
//        $res = $grn->editGRN();
//        $effctfate = $_POST['inv_date'];
//    }
//    if ($_REQUEST['inv_prd_id'] != '') {
//        $d = new ngs_date();
//        if ($effctfate == "") {
////            $v_warr_end = date("Y-m-d", $d->dateadd(time(), ($_POST['inv_v_warr'] * 12), 0, 0, 0));
//            $v_warr_end = date('Y-m-d', strtotime("+" . trim($_POST['inv_v_warr']) . " months", strtotime(date("Y-m-d"))));
//        } else {
////            $v_warr_end = date("Y-m-d", $d->dateadd(strtotime($grn->effective_date), ($_POST['inv_v_warr'] * 12), 0, 0, 0));
//            $v_warr_end = date('Y-m-d', strtotime("+" . trim($_POST['inv_v_warr']) . " months", strtotime($effctfate)));
//        }
//
//        $grnmanger = new grnManager();
//        $arraygrn = $grnmanger->getGRNItemsforserial($grn_id, $_POST['inv_serial']);
//
////        print_r($arraygrn);
//        
//        $checkserial = "1";
//        if (count($arraygrn) > 0) { // check serial already existing
//            $checkserial = "0";
//        }
//        if ($checkserial=="1") {
//            $res = $grn->addGRNItem($grn_id, "", $_REQUEST['inv_prd_id'], $_POST['inv_serial'], "", "", "", $v_warr_end, $_POST['inv_price'], $_POST['inv_qty']);
//
//            if ($res) {
//                $log_str = "GRN item added: " . implode(',', $_REQUEST);
////                $log->setLog($_SESSION['UID'],'Pre-GRN',$grn_id,$log_str);
//            } else {
//                $log_str = "GRN item could not add: " . implode(',', $_REQUEST);
////                $log->setLog($_SESSION['UID'],'Pre-GRN',$grn_id,$log_str);
//            }
//        }
//    }
//    $url = "grn_add?grn_id=" . $grn_id;
//    //print $url;
//    header("Location:$url");
} else if ($_POST['submitted'] == 'conf') {
    $prev_grn_to_id = $_POST['prev_grn_to_id'];
    $new_grn_to_id = $_POST['grn_to_id'];
    $grn = new grn($grn_id);
    $grn->getGRN();
    $grn->note = $_POST['note'];
    $log->setLog($_SESSION['UID'], "GRN-CONFIRM", $grn_id, json_encode($_POST));
    if ($prev_grn_to_id != $new_grn_to_id) {
        $log_str="CHANGE OLD LOCATION $prev_grn_to_id TO $new_grn_to_id ";
        $log->setLog($_SESSION['UID'], "GRN-CONFIRM", $grn_id, $log_str);
        $changeGrn = $grn->changeLocation($prev_grn_to_id, $new_grn_to_id);
        if ($changeGrn) {
            if ($grn->confirmGRN()) {
                $close=true;
                $icon = "success";
                $msg = "GRN is now confirmed. No changes can be done..";
            } else {
                $icon = "error";
                $msg = "GRN could not be confirmed..";
            }
        }else {
            $icon = "error";
            $msg = "GRN could not be confirmed..";
        }
    } else {
        $log_str="CONFIRM WITHOUT LOCATION CHANGE";
        $log->setLog($_SESSION['UID'], "GRN-CONFIRM", $grn_id, $log_str);
        if ($grn->confirmGRN()) {
            $close =true;
            $icon = "success";
            $msg = "GRN is now confirmed. No changes can be done..";
        } else {
            $icon = "error";
            $msg = "GRN could not be confirmed..";
        }
    }

    /**/
} else if ($_POST['submitted'] == 'delete') {
    $grn = new grn($grn_id);
    $res = $grn->deleteGRNItems();
    $log->setLog($_SESSION['UID'], "GRN - DELETE", $grn_id, json_encode($_POST));
    if ($res) {
        if ($grn->deleteGRN()) {
            $deleteflag = true;
            $icon = "";
            $close =true;
            $msg = "GRN and it's items deleted";
        } else {
            $icon = "error";
            $msg = "GRN Could not deleted, but items deleted";
        }
    } else {
        $close =true;
        $icon = "error";
        $msg = "GRN items could not be deleted";
    }
}
if ($grn_id == '') {
    //$grn_no=$grn->getNextPreGRNNumber();
    $save = true;
} else {
    $grn = new grn($grn_id);
    $grn->getGRN();
    $ary_items = $grn->getGRNItems();
    //var_dump($ary_items);
    $save = true;
}
$cross = false;
if ($grn->status_id == '1') {
    $conf = true;
    $can_delete=true;
} else if ($grn->status_id == '2') {

    $save = false;
    $edit = false;
    $conf = false;
    $cross = true;
    $can_delete=false;
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
                            <h2>Add Items to inventory   </h2>	
                            <p></p>
                            <span style="margin-left: 50px; font-size: 14px;">
                                <?php if($grn->fault_ticket_id!=""){print "Ticket Ref #:".$grn->fault_ticket_ref;} ?>
                            </span>
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
                                    <table class="table table-striped" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="right"><strong>Date  <?php // echo $conf;                                                   ?> </strong></td>
                                                <td width="150">
                                                    <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                        <input type="text" name="inv_date" id="inv_date" placeholder="Date" autocomplete="off" value="<?php print $grn->effective_date ?>" class="form-control datepicker" data-dateformat="yy-mm-dd">
                                                        <b class="tooltip tooltip-bottom-right">Date</b>
                                                    </label>
                                                </td>
                                                <td align="right"><strong>Location:</strong></td>
                                                <td>
                                                    <label class="input"><i class="icon-append fa fa-home"></i>
                                                        <input type="text" name="grn_to" id="grn_to" placeholder="To Location" autocomplete="off" value="<?php print $grn->customer_name ?>">
                                                        <b class="tooltip tooltip-bottom-right">To Location</b>
                                                    </label>
                                                </td>
                                                
                                                <td align="right"><strong>Supplier:</strong></td>
                                                <td>
                                                    <label class="input"><i class="icon-append fa fa-user"></i>
                                                        <input type="text" name="inv_supplier" id="inv_supplier" autocomplete="off" placeholder="Supplier" value="<?php print $grn->vendor_name ?>">
                                                        <b class="tooltip tooltip-bottom-right">Supplier</b>
                                                    </label>
                                                    <input type="hidden" name="inv_supplier_id" id="inv_supplier_id" value="<?php print $grn->vendor_id ?>">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td align="right"><strong>Note:</strong></td>
                                                <td>
                                                    <label class="textarea">
                                                        <textarea rows="2" style="width: 200%;" name="note" id="note" placeholder="Note"><?php print $grn->note ?></textarea> 
                                                        <b class="tooltip tooltip-bottom-right">Note</b>
                                                    </label>
                                                </td>
                                                <td align="right"><strong>Batch / Shipment ID/Invoice No:</strong></td>
                                                <td>
                                                    <label class="input"><i class="icon-append fa fa-wrench"></i>
                                                        <input type="text" name="inv_batchno" id="inv_batchno" autocomplete="off" placeholder="Batch / Shipment ID / Invoice No" value="<?php print $grn->shipment_id ?>">
                                                        <b class="tooltip tooltip-bottom-right">Batch / Shipment ID/Invoice No</b>
                                                    </label>
                                                </td>
                                                <td align="right"><strong>Created By:</strong></td>
                                                <td>
                                                    <p><?php print $grn->emp_added_name ?></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <div style="border-top: 1px solid gray; width: 80%; margin-left: auto;margin-right: auto;">
                                        <label style="width: 100%; text-align: center;"><h3>GRN Items</h3></label>

                                    </div>
                                    <?php if ($save) { ?>
                                        <div class="row do-not-print" id="row_1" style="margin: 0px;">
                                            <section class="col col-2">
                                                <label class="label font-xs">Item Code</label>
                                                <label class="input">
                                                    <input type="text" class="" autocomplete="off" name="inv_part_no" autocomplete="off" id="inv_part_no" placeholder="Item Cod">
                                                    <b class="tooltip tooltip-bottom-right">Item Cod</b> 
                                                </label>
                                            </section>
                                            <section class="col col-4">
                                                <label class="label font-xs">Description</label>
                                                <label class="input">
                                                    <input type="text" class="" autocomplete="off" name="" id="inv_part_name" autocomplete="off" placeholder="Description">
                                                    <b class="tooltip tooltip-bottom-right">Description</b> 
                                                </label>
                                                </label>
                                            </section>

                                            <section class="col col-2">
                                                <label class="label font-xs">Serial</label>
                                                <label class="input">
                                                    <input type="text" autocomplete="off" name="inv_serial" id="inv_serial" autocomplete="off" placeholder="Serial">
                                                    <b class="tooltip tooltip-bottom-right">Serial</b> </label>
                                                <label class="label font-xs" id="txt_bin"></label>
                                            </section>
                                            <section class="col col-1">
                                                <label class="label font-xs">V.Warr(Month)</label>
                                                <label class="input">
                                                    <input type="text" autocomplete="off" name="inv_v_warr" id="inv_v_warr" autocomplete="off" placeholder="Month">
                                                    <b class="tooltip tooltip-bottom-right">V.Warr</b> </label>
                                                <label class="label font-xs" id="txt_cost"></label>
                                            </section>

                                            <section class="col col-1">
                                                <label class="label font-xs">price (Rs)</label>
                                                <label class="input">
                                                    <input type="text" autocomplete="off" name="inv_price" id="inv_price" autocomplete="off" placeholder="Price">
                                                    <b class="tooltip tooltip-bottom-right">Price</b> </label>
                                                <label class="label font-xs" id="txt_price"></label>
                                            </section>
                                            <section class="col col-1">
                                                <label class="label font-xs">Qty</label>
                                                <label class="input">
                                                    <input type="text" name="inv_qty" id="inv_qty" autocomplete="off" placeholder="Qty">
                                                    <b class="tooltip tooltip-bottom-right">Qty</b> </label>
                                                <label class="label font-xs" id="txt_price"></label>
                                            </section>
                                        </div>
                                    <?php } else { ?>

                                        <div class="row"  style="margin: 0px;">
                                            <section class="col col-2">
                                                <h6>Item Code</h6>
                                            </section>
                                            <section class="col col-4">
                                                <h6>Description</h6>
                                            </section>
                                            <section class="col col-2">
                                                <h6>Serial</h6>
                                            </section>
                                            <section class="col col-1">
                                                <h6>V.Warr(Mo)</h6>
                                            </section>
                                            <section class="col col-1">
                                                <h6>price (Rs)</h6>
                                            </section>
                                            <section class="col col-1">
                                                <h6>Qty</h6>
                                            </section>
                                            <section class="col col-1"> <h6></h6></section>
                                        </div>

                                    
                                        <?php
                                    }
                                    $inv_item = new \inventory_track_item();                                    
                                    //$can_delete = true;
                                    print '<div id="inv_itm">';
                                    foreach ($ary_items as $inv_item) {
                                        //print_r($inv_item);
                                        if ($inv_item->status != '2') {
                                            //$can_delete = false;
                                            $warranty_end = "<label class='input'><input id ='w_". $inv_item->id ."' style='height:25px;' type='text' value='".$inv_item->warranty_period."' ></label> ";
                                            $cost = "<label class='input'><input type='text' id ='c_". $inv_item->id ."' style='height:25px;' value='".$inv_item->cost."' > </label>";
                                        }else {
                                            print $inv_item->status."<br>";
                                            $can_delete = false;
                                            $warranty_end = $inv_item->warranty_period;
                                            $cost = $inv_item->cost;
                                        }
                                        print '<div class="row" id="' . $inv_item->id . '" style="margin: 0px;"><section class="col col-2">'
                                                . $inv_item->system_code . '</section><section class="col col-4">'
                                                . $inv_item->system_name . '</section><section class="col col-2">'
                                                . $inv_item->serial . '</section><section class="col col-1">'
                                                . $warranty_end . '</section><section class="col col-1">'
                                                . $cost . '</section><section class="col col-1">'
                                                . $inv_item->qty . '</section><section class="col col-1"><a href="javascript:delete_item(' . "'$inv_item->id'" . ')"><img  class="crossdel" alt="" src="../img/cross.png" width="16px" height="16px"></a></section></div>';
                                    }
                                    ?>
                                </div>
                                    <footer>	
                                        <div class="row do-not-print">	
                                            <section class="col col-3">

                                            </section>
                                            <section class="col col-2">

                                            </section>
                                            <section class="col col-3">

                                            </section>
                                            <section class="col col-4">
                                                <input type="hidden" name="inv_grn_id" id="inv_grn_id" value="<?php print $grn_id ?>">
                                                <input type="hidden" name="inv_prd_id" id="inv_prd_id" value="">		
                                                <input type="hidden" name="submitted" id="submitted" value="">
                                                <input type="hidden" name="grn_to_id" id="grn_to_id" value="<?php print $grn->customer_entity_id ?>">
                                                <input type="hidden" name="prev_grn_to_id" id="prev_grn_to_id" value="<?php print $grn->customer_entity_id ?>">
                                                <?php if ($ary_prev[6][1] == '1' && $save) { ?>
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

                                        <p  id="msg_prev"><?php print $msg ?></p>
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
    //print "window.parent.location.reload(false);";
    //print "window.close();";
}
?>
// DO NOT REMOVE : GLOBAL FUNCTIONS!

    var del = 0;
    var flag = false;
    var flagdel = false;



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
  title: '<?php print $msg ?>',
  showConfirmButton: false,
  timer: 2500
})
<?php }?>

        var conf = '<?php echo $cross ?>';
        var deleteflag = '<?php echo $deleteflag ?>';
//        var serialcheck = '<?php // echo $checkserial                                            ?>';


//        if (serialcheck == "0") {
//            serialCheckMsg('<?php // echo $_POST['inv_serial']                                            ?>');
//        }


        $('#print').click(function (e) {
            var url = 'grn_print_view?id=<?php print $grn_id ?>';
            var NWin = window.open(url, '_blank');
            if (window.focus)
            {
                NWin.focus();
            }
        });



//        $('#but_save').click(function () {
//            $('#submitted').val("save");
//            $('#from_inventory_add').submit();
//        });
        $('#but_conf').click(function () {
            //$('#submitted').val("conf");
            //$('#from_inventory_add').submit();
            var prev_grn_to_id = $('#prev_grn_to_id').val();
            var grn_to_id = $('#grn_to_id').val();
            if(grn_to_id != prev_grn_to_id){
                
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
                $('#from_inventory_add').submit();
            }
            //$('#submitted').val("conf");
            //$('#from_inventory_add').submit();
        });
        $('#but_del').click(function () {
            $('#submitted').val("delete");
            var newDiv = $(document.createElement('div'));
            $(newDiv).html('GRN and its items will be deleted.Are you sure?');
            $(newDiv).attr('title', 'Delete GRN');
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
            });
        });
        $('#inv_supplier').autocomplete({
            source: '../json/get_vendor',
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                if (id != '') {
                    $('#inv_supplier_id').val(id);
                }
            }
        });
        $('#grn_to').autocomplete({
            source: function (request, response) {
                $.getJSON(
                        "../json/get_customer_entity",
                        {term: request.term, type: "", exclude: "",to_vendor:"N"},
                        response
                        );
            },
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                var prd = ui.item.name;
                if (id != '') {
                    $('#grn_to_id').val(id);
                }
            }
        });
        $('#inv_part_no').autocomplete({
            source: '../json/get_system_code',
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                var prd = ui.item.name;
                if (ui.item.type == "I") {
                    $('#inv_qty').hide();
                    $('#inv_serial').prop( "disabled", false );
                } else {
                    $('#inv_qty').show();
                    $('#inv_serial').prop( "disabled", true );
                }
                if (id != '') {
                    $('#inv_prd_id').val(id);
                    $('#inv_part_name').val(prd);
                }
            }
        });
        $('#inv_part_name').autocomplete({
            source: '../json/get_system_name',
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                var prt_no = ui.item.code;
                if (ui.item.type == "I") {
                    $('#inv_qty').hide();
                } else {
                    $('#inv_qty').show();
                }
                if (id != '') {
                    $('#inv_prd_id').val(id);
                    $('#inv_part_no').val(prt_no);
                }
            }
        });

        $('#inv_part_no').keyup(function (e) {

            if ($('#inv_part_no').val() == "") {
                clear();
            }
            e.stopPropagation();
            if (e.keyCode == 13)
            {
                e.preventDefault();
            }
        });
        $('#inv_part_name').keyup(function (e) {

            if ($('#inv_part_name').val() == "") {
                clear();
            }
            e.stopPropagation();
            if (e.keyCode == 13)
            {
                e.preventDefault();
            }
        });


        $('#inv_price').keyup(function (e) {
            e.stopPropagation();
            if (e.keyCode == 13)
            {
                e.preventDefault();
                precessData();

            }
        });
        $('#inv_qty').keyup(function (e) {
            e.stopPropagation();
            if (e.keyCode == 13)
            {
                e.preventDefault();
                precessData();

            }
        });
        $('#inv_v_warr').keyup(function (e) {
            e.stopPropagation();
            if (e.keyCode == 13)
            {
                e.preventDefault();
                precessData();

            }
        });

        $('#but_save').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            precessData();
            warrantyCostUpdate();
        });


<?php
if (($ary_prev[6][2] == '1') || ($ary_prev[6][1] == '1')) {
    print '$( "#but_conf" ).prop( "disabled", false );';
    print '$( "#but_save" ).prop( "disabled", false );';
    print ' $(".crossdel").hide();';
    print ' flag=true;';
}

if (($ary_prev[6][3] == '1')) {
    print '$( "#but_del" ).prop( "disabled", false );';
    print ' $(".crossdel").show();';
    print ' flagdel=true';
}
?>


        if (conf == true) {

            $(".crossdel").hide();
        }

        if (deleteflag == true) {
            $("#but_conf").hide();
            $("#but_save").hide();
            $("#but_del").hide();
        }


    });

    function clear() {
        $('#inv_part_no').val("");
        $('#inv_part_name').val("");
        $('#inv_serial').val("");
        $('#inv_v_warr').val("");
        $('#inv_price').val("");
        $('#inv_qty').val("");
        $('#inv_prd_id').val("");
        $('#inv_qty').show();
    }


    function serialCheckMsg(serial) {
        alert("This (" + serial + ") serial already exist in stock.Please check ! ");
    }

    function precessData() {

        if (!flag) {
            alert("You haven't rights to do this activity!");
            return;
        }


        var prd_id = $('#inv_prd_id').val();
        var serial = $('#inv_serial').val();
        var date = $('#inv_date').val();
        var shipment_id = $('#inv_batchno').val();
        var supplier_id = $('#inv_supplier_id').val();
        var price = $('#inv_price').val();
        var part_no = $('#inv_part_no').val();
        var part_name = $('#inv_part_name').val();
        var v_warr = $('#inv_v_warr').val();
        var qty = $('#inv_qty').val();
        var note = $('#note').val();
        var inv_id = '';
        var grn_id = $('#inv_grn_id').val();
        var location_id = $('#grn_to_id').val();

        if (grn_id != '') {
            $.ajax({
                url: '../ajax/ajx_grn', //this is the submit URL
                type: 'POST', //or POST
                dataType: 'JSON',
                async: false,
                data: {SID: "13", uid:<?php print $_SESSION['UID'] ?>, emp_id:<?php print $_SESSION['EMPID'] ?>, grn_id: grn_id, shipment_id: shipment_id, supplier_id: supplier_id, date: date, note: note,location:location_id},
                success: function (response) {
                    //alert(data);
                    if (response['result'] == '1') {
                        grn_id = response['grn_id'];
                        $('#inv_grn_id').val(grn_id);
//                        alert('could not add GRN [0]');
                    }
                },
                error: function () {
//                    alert("could not add GRN [1]");
                }
            });
            if (prd_id != "") {
                addItem(grn_id, prd_id, serial, v_warr, price, qty, part_no, part_name, part_no);
            }
        } else {
            $.ajax({
                url: '../ajax/ajx_grn', //this is the submit URL
                type: 'POST', //or POST
                dataType: 'JSON',
                async: false,
                data: {SID: "10", uid:<?php print $_SESSION['UID'] ?>, emp_id:<?php print $_SESSION['EMPID'] ?>, shipment_id: shipment_id, supplier_id: supplier_id, date: date, note: note,location:location_id},
                success: function (response) {
                    //alert(data);
                    if (response['result'] == '1') {
                        grn_id = response['grn_id'];
                        $('#inv_grn_id').val(grn_id);
                        addItem(grn_id, prd_id, serial, v_warr, price, qty, part_no, part_name, part_no);
                    } else {
                        alert('could not add GRN [0]');
                    }
                },
                error: function () {
                    alert("could not add GRN [1]");
                }
            });
        }
    }



    function addItem(grn_id, prd_id, serial, v_warr, price, qty, code, descript, part_no) {
//console.log(grn_id+"-"+prd_id+"-"+serial+"-"+v_warr+"-"+price+"-"+code+"-"+descript);
        if (prd_id != '') {
            $.ajax({
                url: '../ajax/ajx_grn', //this is the submit URL
                type: 'POST', //or POST
                dataType: 'JSON',
                data: {SID: "11", uid:<?php print $_SESSION['UID'] ?>, emp_id:<?php print $_SESSION['EMPID'] ?>, grn_id: grn_id, prd_id: prd_id, part_no: part_no, serial: serial, price: price, warranty: v_warr, qty: qty},
                success: function (data) {
                    if (data['result'] == '1') {
                        item_id = data['item_id'];
                        addItemInterface(item_id, code, descript, serial, v_warr, price, qty);
                    } else if (data['result'] == '2') {
                        serialCheckMsg(data['serial']);
                    } else {
                        alert('could not add GRN [0]');
                    }
                },
                error: function () {
                    alert("could not add GRN [1]");
                }
            });
        }
    }
    function addItemInterface(item_id, code, name, serial, warr, price, qty) {
        if (isNaN(item_id) == false) {

            var html = '<div class="row" id="' + item_id + '" style="margin: 0px;"><section class="col col-2">' +
                    code + '</section><section class="col col-4">' +
                    name + '</section><section class="col col-2">' + serial +
                    '</section><section class="col col-1">' + warr +
                    '</section><section class="col col-1">' + price +
                    '</section><section class="col col-1">' + qty +
                    '</section><section class="col col-1"><a href="javascript:delete_item(' + "'" + item_id + "'" + ')"><img class="crossdel" alt="" src="../img/cross.png" width="16px" height="16px"></a></section></div>';

            $('#inv_prd_id').val('');
            $('#inv_part_no').val('');
            $('#inv_part_name').val('');
            $('#inv_price').val('');
            $('#inv_serial').val('');
            $('#inv_v_warr').val('');
            $('#inv_qty').val('');
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
        $(newDiv).attr('title', 'Delete Inventry Item');
        //$(newDiv).css('font-size','62.5%');
        $(newDiv).dialog({
            resizable: false,
            height: 160,
            modal: true,
            buttons: {
                "Yes": function () {
                    $.ajax({
                        url: '../ajax/ajx_grn', //this is the submit URL
                        type: 'POST', //or POST
                        dataType: 'JSON',
                        data: {SID: "12", item_id: inv_id, uid:<?php print $_SESSION['UID'] ?>,emp_id:<?php print $_SESSION['EMPID'] ?>, grn_id: $('#inv_grn_id').val()},
                        success: function (data) {
                            if (data['result'] == '1') {
                                var id_of_div = '#' + inv_id;
                                $(id_of_div).remove();
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
    function warrantyCostUpdate(){
        var data = $("#inv_itm .row");
        var data_arr = {};
        data.each(function (){
            var r_id = (this.id);
                var warranty_period = $("#w_"+r_id).val();
                var cost = $("#c_"+r_id).val();
                if(warranty_period !== undefined && cost!==undefined){
                    warranty_period = warranty_period.trim();
                    cost = cost.trim();
                    if(warranty_period ==""){
                        
                    }
                    if(cost ==""){
                        
                    }
               var val = {warranty_period:warranty_period,cost: cost};
               
                        //console.log(this.id + " qty= " + dispatch_qty + " batch NO = " + dispatch_batch_no);
                        if (data_arr[this.id] !== undefined) {
                            if (!data_arr[this.id].push) {
                                data_arr[this.id] = [data_arr[this.id]];
                            }
                            data_arr[this.id].push(val || '');
                        } else {
                            data_arr[this.id] = val || '';
                        }
                        }
        });
        console.log( Object.keys(data_arr).length);
        if(Object.keys(data_arr).length>0){
            $.post('../ajax/ajx_grn',{SID:202,obj:data_arr},function(response){
                if(response.result =='1'){
                    location.reload();
        }
            },"JSON");
        }
    }
</script>
