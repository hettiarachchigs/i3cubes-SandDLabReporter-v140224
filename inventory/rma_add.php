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

$page_title = "RMA Add/Edit";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["inventory"]["sub"]["rma"]["active"] = true;
//include("..inc/nav.php");
// ====================== LOGIC ================== --!>
//include_once 'lib/i3c_config.php';
include_once '../class/rma.php';
//include_once '../class/cls_stn_system.php';
include_once '../class/fault_ticket.php';
include_once '../class/employee.php';
include_once '../class/cls_log.php';
include_once '../class/cls_inventory_item.php';

$rma_id = $_REQUEST['inv_rma_id'];
//print_r($_POST);

$log=new log();

if ($_POST['submitted'] == 'save') {
    
} else if ($_POST['submitted'] == 'close') {
    $rma = new rma($rma_id);
    $rma->confirnRMA();
} else if ($_POST['submitted'] == 'delete') {
    $rma = new rma($rma_id);
    $rma->getRMA();
    $res = $rma->deleteRMAItems();
    if ($res) {
        if ($rma->deleteRMA()) {
            $msg = "RMA and it's items deleted";
            $deleted = true;
        } else {
            $msg = "RMA Could not deleted, but items deleted";
            $deleted = false;
        }
    } else {
        $msg = "RMA items could not be deleted";
        $deleted = false;
    }
}
$rmarefno = "";

if ($rma_id == '') {
    //$grn_no=$grn->getNextPreGRNNumber();
    $save = true;
} else {
    $rma = new rma($rma_id);
    $rma->getRMA();
    $ary_items = $rma->getRMAItems();
    //var_dump($ary_items);
    $save = true;
    $rmarefno = $rma->ref_no;



//    print_r($ft);
}

if ($rma->status_id == '1') {
    $close = true;
    $save = true;
    $edit = true;
} else if ($rma->status_id == '2') {
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
                    <div class="jarviswidget" id="w_inv_e1"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i></span>
                            <?php ?>

                            <h2>Add RMA &nbsp;&nbsp;</h2>	
                            <?php
                            if ($rma_id != "") {
                                ?>
                                <p></p>
                                <span style="margin-left: 50px; font-size: 14px;">
                                    Ref No :<b style="color: #000080;" >&nbsp;&nbsp;<?php print $rmarefno ?></b>
                                </span>

                                <?php
                            }
                            ?>
                            
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
                                                        <input type="text"  name="stn_from" id="stn_from" placeholder="From Location" autocomplete="off" value="<?php print $rma->from_customer_name ?>">
                                                        <b class="tooltip tooltip-bottom-right">From Location</b>
                                                    </label>
                                                </td>
                                                
                                                <td align="center"><strong>To:</strong></td>
                                                
                                                <td>
                                                    <label class="input"><i class="icon-append fa fa-home"></i>
                                                        <input type="text" name="stn_to" id="stn_to" placeholder="To Location" autocomplete="off" value="<?php print $rma->to_customer_name ?>">
                                                        <b class="tooltip tooltip-bottom-right">To Location</b>
                                                    </label>
                                                </td>
                                                <td align="right"><strong>Note:</strong></td>
                                                <td>
                                                    <label class="textarea">
                                                        <textarea rows="2" style="width: 100%;" name="note" id="note" placeholder="Note"><?php print $rma->note ?></textarea> 
                                                        <b class="tooltip tooltip-bottom-right">Note</b>
                                                    </label>
                                                </td>
                                                <td align="right"><strong></strong></td>
                                                <td>
                                                    <label>
                                                        <span>&nbsp;</span>
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="right"></td>
                                                <td>
                                                    
                                                </td>
                                                <td></td>
                                                <td>
                                                    
                                                </td>
                                                <?php
                                                if ($rma_id != "") {
                                                    ?>
                                                    <td style="padding: 10px;" align="right"><strong>Created Date:</strong></td>
                                                    <td style="padding: 10px;"  ><b  style="color: #008200;" >
                                                            &nbsp; &nbsp;
                                                            <?php print $rma->date_added; ?></b>
                                                    </td>
                                                    <td style="padding: 10px;" align="right"><strong>Created By:</strong></td>
                                                    <td style="padding: 10px;"  >
                                                        <b style="color: saddlebrown;" >
                                                            &nbsp; &nbsp;
                                                            <?php
                                                            print $rma->emp_added_name;
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
                                        <label style="width: 100%; text-align: center;"><h3>RMA Items</h3></label>

                                    </div>
                                    <?php if ($save) { ?>
                                        <div class="row do-not-print" id="row_1" style="margin: 0;">
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
                                            <section class="col col-2">
                                                <label class="label font-xs">AVL QTY</label>
                                                <span id="lbl_avl_qty"></span>
                                                <input type="hidden" id="inv_type" value="">
                                                <input type="hidden" id="inv_available" value="">
                                                <input type="hidden" id="inv_systems_id" value="">
                                            </section>
                                            <section class="col col-1">

                                            </section>
                                        </div>
                                    <?php } else { ?>

                                        <div class="row"  style="margin: 0px;"><section class="col col-4"><h6>Description</h6>
                                            </section>
                                            <section class="col col-3">
                                                <h6> Serial</h6>
                                            </section>
                                            <section class="col col-1">
                                                <h6>  Qty</h6>
                                            </section>
                                            <section class="col col-2">
                                                
                                            </section>
                                            <section class="col col-1">

                                            </section></div>

                                        <?php
                                    }
                                    $inv_item = new \inventory_track_item();
                                    $can_delete = true;
                                    $can_send=false;
                                    foreach ($ary_items as $inv_item) {
                                        if ($inv_item->status == '2') {
                                            $can_delete = false;
                                        }
                                        else if($inv_item->status=='1'){
                                            $close=false;
                                            $can_send=true;
                                        }
                                        print '<div class="row" id="' . $inv_item->id . '" style="margin: 0px;"><section class="col col-4">'
                                                . $inv_item->system_name . '</section><section class="col col-3">'
                                                . $inv_item->serial . '</section><section class="col col-1">'
                                                . $inv_item->qty . '</section><section class="col col-2">'
                                                . $inv_item->note. '</section><section class="col col-1">';
                                        if($inv_item->status=='1' && $rma->status_id=='1'){
                                            print 
                                                '<a class="delbtn"   href="javascript:delete_item(' . "'$inv_item->id'" . ')"><img alt="" src="../img/cross.png" width="16px" height="16px" style="margin-bottom: 3px;"></a>&nbsp&nbsp'
                                                    . '<input class="rma_chb_stn" name="rma_chb_stn" id="" value="'.$inv_item->id.'" type="checkbox">';
                                        }
                                        if($inv_item->status=='2' && $rma->status_id=='2' && $rma->vendor=="Y"){
                                            print 
                                                '<a href="javascript:return_item('.$sys->record_id.')" title="return same"><i class="fa fa-reply" style="margin-left:10px;" aria-hidden="true"></i></a>'
                                                . '<a href="javascript:add_new_item('.$sys->record_id.",".$rma->from_customer_id.')" title="add new"><i class="fa fa-plus-square-o" style="margin-left:10px;" aria-hidden="true"></a></i>'
                                                . '<a href="javascript:discontinue_item('.$sys->record_id.')" title="discontinue"><i class="fa fa-ban" style="margin-left:10px;" aria-hidden="true"></a></i>';
                                                
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
                                                <?php print $msg ?>
                                            </section>
                                            <section class="col col-4">
                                                <input type="hidden" name="inv_rma_id" id="inv_rma_id" value="<?php print $rma_id ?>">
                                                <input type="hidden" name="inv_prd_id" id="inv_prd_id" value="">	
                                                <input type="hidden" name="stn_from_id" id="stn_from_id" value="<?php print $rma->from_customer_id ?>">
                                                <input type="hidden" name="stn_to_id" id="stn_to_id" value="<?php print $rma->to_customer_id ?>">
                                                <input type="hidden" name="submitted" id="submitted" value="">

                                                <?php if ($ary_prev[6][1] == '1' && $save) { ?>
                                                    <button type="button" class="btn btn-primary" id="but_save" name="but" value="save">
                                                        Save
                                                    </button>
                                                <?php }if ($ary_prev[6][2]=='1' && $close) { ?>
                                                    <button type="button" class="btn btn-primary" id="but_conf" name="but" value="close">
                                                        Close
                                                    </button>
                                                <?php }if ($ary_prev[6][3]=='1' && $can_delete) { ?>
                                                    <button type="button" class="btn btn-danger" id="but_del" name="but" value="delete">
                                                        Delete
                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                                <?php if ($ary_prev[6][1]=='1' && $can_send) { ?>
                                                <button type="button" class="btn btn-success" id="send_dn" name="send_dn" value="send_dn">
                                                    Send DN
                                                </button>
                                                <?php
                                                }
                                                ?>
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
    //print "window.parent.location.reload(false);";
    //print "window.close();";
}
?>
// DO NOT REMOVE : GLOBAL FUNCTIONS!

    var del = 0;
    var flag = false;
    var flagdel = false;



    $(document).ready(function () {

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
    print ' flagdel=true';
}
?>


        if ($('#inv_rma_id').val() != "") {
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


        $('#send_dn').click(function (e) {
            var item_ids_str="";
            $('.rma_chb_stn').each(function () {
                if(this.checked){
                    console.log($(this).val());
                    item_ids_str=item_ids_str+"|"+$(this).val();
                }
            });
            var url = 'stn_add?<?php print SID ?>rma_id=<?php print $rma_id ?>&source=RMA&ids='+item_ids_str;
            var NWin = window.open(url, '_blank');
            if (window.focus)
            {
                NWin.focus();
            }
        });


        $('#but_save').click(function (e) {
            e.preventDefault();
            if ($('#stn_to_id').val() == "") {
                alert("please select destination location");
            } else {
                addItems(true);
            }
        });
        $('#but_conf').click(function () {
            $('#submitted').val("close");
            $('#from_inventory_add').submit();
        });
        $('#but_del').click(function () {
            $('#submitted').val("delete");
            
            var newDiv = $(document.createElement('div'));
            $(newDiv).html('RMA and its items will be deleted.Are you sure?');
            $(newDiv).attr('title', 'Delete RMA');
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
        $('#stn_from').autocomplete({
            source: function (request, response) {
                $.getJSON(
                        "../json/get_customer_entity",
                        {term: request.term, type: "S", exclude: $('#stn_to_id').val()},
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
                        {term: request.term, type: "", exclude: $('#stn_from_id').val(),to_vendor:true},
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


    function goRMA() {
        setTimeout(
                function ()
                {
                    location.href = "rma_view";
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
            alert("You have no rights to do this activity!");
            return;
        }

        var prd_id = $('#inv_prd_id').val();
        var prd_name = $('#inv_part_name').val();
        var serial = $('#inv_serial').val();
        var from = $('#stn_from_id').val();
        var to = $('#stn_to_id').val();
        var rma_id = $('#inv_rma_id').val();
        var note = $('#note').val();
        var qty = $('#inv_qty').val();
        var type = $('#inv_type').val();
        var available = $('#inv_available').val();
        var systems_id = $('#inv_systems_id').val();
        var employee_id=<?php print $_SESSION['EMPID'] ?>;
        if (prd_id == "") {
//            return;
        }
        if (rma_id != '') {
            if(update){
                $.ajax({
                    url: '../ajax/ajx_rma', //this is the submit URL
                    type: 'POST', //or POST
                    dataType: 'JSON',
                    data: {SID: "13", uid:<?php print $_SESSION['UID'] ?>, rma_id: rma_id, to_id: to, emp_id: employee_id, note: note},
                    success: function (response) {
                        //alert(data);
                        if (response['result'] == '1') {
                            clear();
                            rma_id = response['rma_id'];
                            $('#inv_rma_id').val(rma_id);
                            $("#stn_from").prop("disabled", true);
                        } else {
                            alert('could not add RMA [0]');
                        }
                    },
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }
            if (prd_id != "" || systems_id!="") {
                addItem(rma_id, prd_id,systems_id,type,prd_name,serial, qty);
            }
        } else {
            $.ajax({
                url: '../ajax/ajx_rma', //this is the submit URL   --ADD STN
                type: 'POST', //or POST
                dataType: 'JSON',
                data: {SID: "10", uid:<?php print $_SESSION['UID'] ?>, from_id: from, to_id: to, emp_id: employee_id, note: note},
                success: function (response) {
                    //alert(data);
                    if (response['result'] == '1') {
                        rma_id = response['rma_id'];
                        $('#inv_rma_id').val(rma_id);
                        $("#stn_from").prop("disabled", true);
                        addItem(rma_id, prd_id,systems_id,type,prd_name,serial, qty);
                    } else {
                        alert('could not add STN [0]');
                    }
                },
                error: function () {
                    alert("could not add STN [1]");
                }
            });
        }



        console.log(rma_id + "-" + prd_id + "-" + serial + "-" + prd_name + "-" + qty);

    }
    function addItem(rma_id, cus_sys_id,sys_id,sys_type, description, serial, qty) {
        if (rma_id != '' && sys_id!="") {
            if(parseFloat($('#inv_available').val())>=parseFloat(qty) || sys_type=='I'){
                $.ajax({
                    url: '../ajax/ajx_rma', //this is the submit URL
                    type: 'POST', //or POST
                    dataType: 'JSON',
                    data: {SID: "11", uid:<?php print $_SESSION['UID'] ?>, rma_id: rma_id, cus_sys_id: cus_sys_id, qty: qty,system_id:sys_id,system_type:sys_type},
                    success: function (data) {
                        if (data['result'] == '1') {
                            item_id = data['item_id'];
                            iss_ref=data['issue_ref'];
                            addItemInterface(item_id, description, serial, qty,iss_ref);
                        } else if (data['result'] == '2') {
                            alert(data['msg']);
                        } else {
                            alert('could not add RMA [0]');
                        }
                    },
                    error: function () {
                        alert("could not add RMA [1]");
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

            var html = '<div class="row" id="' + item_id + '" style="margin: 0px;"><section class="col col-4">' +
                    description + '</section><section class="col col-3">' +
                    serial + '</section><section class="col col-1">' + qty +
                    '</section><section class="col col-2">' + iss_ref +
                    '</section><section class="col col-1"><a class="delbtn" href="javascript:delete_item(' + "'" + item_id + "'" + ')"><img alt="" src="../img/cross.png" width="16px" height="16px"></a></section></div>';

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
            alert("You have no rights to do this activity!");
            return;
        }

<?php
if (!$edit) {
//    print "alert('cannot do changes....');";
//    print "return;";
}
?>
        var newDiv = $(document.createElement('div'));
        $(newDiv).html('Item will be deleted.Are you sure?');
        $(newDiv).attr('title', 'Delete RMA Item');
        //$(newDiv).css('font-size','62.5%');
        $(newDiv).dialog({
            resizable: false,
            height: 160,
            modal: true,
            buttons: {
                "Yes": function () {
                    $.ajax({
                        url: '../ajax/ajx_rma', //this is the submit URL
                        type: 'POST', //or POST
                        dataType: 'JSON',
                        data: {SID: "12", item_id: inv_id, uid:<?php print $_SESSION['UID'] ?>, rma_id: $('#inv_rma_id').val()},
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
    
    function return_item(id) {
        var options = {
            url: 'stn_item_return?item_id='+id,
            width: '550',
            height: '300',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }
    function discontinue_item(id) {
        var options = {
            url: 'stn_item_discard?item_id='+id,
            width: '550',
            height: '300',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }
    function add_new_item(stn_item_is,cus_ent_id){
        var options = {
            url: '../equipment/add?cus_ent_id='+cus_ent_id+"&stn_item_id="+stn_item_is,
            width: '600',
            height: '500',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }
</script>
