<?php
session_start();
//require_once ("../lib/config.php");
include("../ngs/header_ngspopup.php");
$ary_prev = $_SESSION['ROLE_PREV'];
//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["raw"]["sub"]["add"]["active"] = true;
//include("inc/nav.php");

/*
 * ===== LOGIC =========*
 * 
 */


include_once '../class/stn.php';
include_once '../class/stnManager.php';
include_once '../class/cls_stn_system.php';
include_once '../class/fault_ticket.php';
include_once '../class/employee.php';
include_once '../class/customer.php';
include_once '../class/cls_log.php';

// Get the encoded URL parameters from the request
$encodedParams = $_SERVER['QUERY_STRING'];

// Decode the parameters
$decodedParams = urldecode($encodedParams);

// Parse the decoded parameters into an array
parse_str($decodedParams, $params);

// Output the result
$attention_to = $params['attention_to'];

?>
<!--<script src="./js/libs/jquery-2.0.2.min.js"></script>
<link rel="stylesheet" href="css/font-awesome.min.css">-->
<link href="../js/plugin/sweetalerts/sweetalert2.css" rel="Stylesheet" type="text/css" />
<style>


    html{ 
        margin:0;
        padding:0;
        min-height:100%;

        position:relative;

    }
    @media screen{
        html{
            background:url(img/mybg.png) #fff;
        }
    }
    @media print{
        html{
            background-color: white !important;
        }
    }
    body{
        font-family: bavaria_regular,Sans-serif;
        background-color: white;
        width:205mm;
        margin-left: auto;
        margin-right: auto;
        margin-top: 0px;
    }


    .head_txt{
        font-size: 28px;
        font-family: bavaria_bold,Sans-serif;
    }
    .head_l1{
        font-size: 14px;
        font-weight: bold;
    }
    .head_inv{
        font-size: 16px;
        font-weight: bold;
    }
    .head_inv1{
        font-size: 12px;
    }
    .head_l2{
        font-size: 12px;
        font-weight: bold;
    }
    .head_l3{
        font-size: 12px;
    }
    .txt_invoice{
        font-weight: bolder;
        font-size: 26px;
    }
    .txt_info_s{
        font-size: 8px;
    }

    .txt_status{
        font-family: bavaria_bold,Sans-serif;
        font-size: 20px;
        color: red;
        font-weight: 900;
    }

    .descript_h{
        font-size: 13px;
        font-weight: normal;
        padding: 5px;
    }
    .descript_h_bold{
        font-size: 13px;
        font-weight: bold;
        padding: 5px;
    }
    .descript_t{
        font-size: 12px;
        padding: 5px;
        font-weight: bold;
        padding-left: 20px;

    }
    #div_header{
        width: 100%;
        display: block;
    }
    .tbl_head{
        width: 100%;
        border: 0px;
        border-collapse: collapse;
    }
    .tbl_head td{
        padding-left: 15px;
        padding-right: 15px;
        padding-top: 25px;
    }

    .tbl_inv_addr{
        width: 100%;
        border-collapse: collapse;
    }
    .tbl_cus{
        width: 100%;
        border: 1px solid gray;
        border-collapse: collapse;
        border-spacing: 0px;
    }
    .tbl_cus td{
        padding: 3px;
        border: 1px solid gray;
        text-align: center;
    }
    .tbl_cus>tbody>tr:nth-child(odd)>td,.tbl_cus>tbody>tr:nth-child(odd)>th {
        background-color:#d5d1d1 !important;
    }
    .tbl_body{
        width: 100%;
        border: 1px solid gray;
        border-collapse: collapse;
        border-spacing: 0px;
    }
    .tbl_body th{
        background-color:#d5d1d1 !important;
        border-bottom:1px solid gray;
        font-size: 13px;
        font-weight: bold;
        padding: 3px;
    }
    .tbl_body td{
        padding: 3px;
        font-size: 12px;
    }
    .left{
        float: left;
    }
    .right{
        text-align: right;
    }
    label{
        display: inline-block;
        margin-bottom: 5px;
    }
    .tbl_total{
        width: 100%;

    }
    .tbl_total_ch{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0px;
    }
    .tbl_total_ch td{
        /*        padding-right: 0px;
                border-bottom: 1px solid gray;*/
    }
    @page {
        size: A4;
    }
    @MEDIA print {
        #div_but{
            display: none;
        }
        #but_print{
            display: none;
        }
        .print_hidden{
            display: block;
        }
    }

    .txt_cr_h1{
        font-size: 18px;
        font-weight: bold;
    }
    .txt_cr_h2{
        font-size: 12px;
        font-weight: bold;
    }
    .txt_cr_h3{
        font-size: 14px;
        font-weight: bold;
    }
    .txt_cr_h4{
        font-size: 14px;
    }
    #tbl_cr td{
        padding: 4px;
    }
    .cr_cb{
        width: 30px;
        height: 10px;
    }
    #div_note_sp{
        font-size: 14px;
        font-weight: bold;
        text-transform: capitalize;
        text-align: center;
    }
    #div_note{
        font-size: 12px;
    }
    .documentControlNumber {
        font-size: 10px;
        float: right
    }
    .swal2-container{
        /*background-color :transparent !important;*/
    }
</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->

<?php
$stn = new stn($_REQUEST["id"]);
$add_attention_to = $stn->addattention_to($attention_to);
$stn->getSTN();
$att_to = $stn->attention_to;
if($att_to ==""){
    $attention_to = $attention_to;
}else {
    $attention_to = $att_to;
}
?>
<!--<body onload="checkPage();" class="hidden-print" >-->
<body onload="" class="hidden-print" >
    <div id="contentDiv">
        <div id="div_header">
            <span class="documentControlNumber">LSC/STN/00</span>
            <table class="tbl_head" id="tbl_heade_id">
                <tr>
                    <td>

                        <div>
                            <label class="head_l1" style="font-size: 18px;" ><i class="fa-fw fa fa-map-marker"></i>LEOsys Corporation (Pvt.) Ltd.  </label>
                            <br>
                            <label class="head_l1"><i class="fa-fw fa fa-map-marker"></i>#266/10, Samagi Mw, Batalanda, Makola, Sri Lanka </label>
                            <br>
                            <label class="head_l2" style="margin-left: 2px;"><i class="fa-fw fa fa-phone"></i>Tel:&nbsp; (+94) 114 622 622, <i class="fa-fw fa fa-fax"></i>(+94) 70 645 11 80 </label>
                            <br>
                            <label class="head_l3" style="margin-left: 2px;"><b>Email:</b> info@leosys.lk</label>
                            <br>
                        </div>
                    </td>
                    <td width="100px;"><img src="../img/logo.png" width="300px"/></td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="30%">
                        <label style="color: #0066cc;font-weight: bold;font-size: 20px;" > DELIVERY NOTE</label>
                    </td>
                    <td width="30%">
                        <div style="margin-left: 50px"><label class="txt_status"></label></div>
                    </td>
                    <td width="40%">
                        <div style="width: 100%; text-align: right;"><label class="txt_invoice" style="margin-right: 15px;"></label></div>
                        <div style="width: 100%; text-align: right;"><label  style="margin-right: 15px;font-size: 14px;">STN No&nbsp;:&nbsp;<i class="head_l1" ><?= $stn->ref_no ?></i></label></div>
                        <div style="width: 100%; text-align: right;"><label  style="margin-right: 15px;font-size: 14px;">STN Date&nbsp;:&nbsp;<i class="head_l1" ><?= $stn->date_added ?></i></label></div>
                    </td>
                </tr>
            </table>

            <hr style="width: 100%; border-top: 1px solid #8c8b8b;border-bottom: 1px solid #fff">
        </div>
        <table style="border: 1px solid silver;"  class="tbl_inv_addr">
            <?php
            $emp = new employee($stn->emp_to);
            $emp->getEmployee();

            $customer = new customer($stn->to_customer_id);
            $customer->getCustomer();
            ?>
            <tr width="50%" >
                <td style="padding-top: 10px; padding-left: 35px;">
                    <div>
                        <label class="head_inv">Deliver To:</label>
                        <br>
                        <label  class="head_inv1">
                            <label style="font-size: 14px;" ><?= $stn->to_customer_name ?></label>
                            <br>
                            <label style="font-size: 14px;" ><?= $customer->address ?></label>
                        </label>
                    </div>
                </td>
                <td style="padding-top: 20px;">
                    <div>
                        <label class="head_inv">To:</label>
                        <br>
                        <label class="head_inv1">
                            Attention To :
                            <hr style="width: 120%;" >
                            <?= $attention_to ?>
                            <br>
                            <label style="font-size: 14px;" ><i></i></label>
                        </label>
                    </div>
                </td>
            </tr>

        </table>
        <br>
        <div id="div_inv_info">
            <!-- JOB DEtails -->
            <table class="tbl_cus">
                <tr>
                    <td class="descript_h">Date</td>
                    <td class="descript_h">Delivery From</td>
                    <td class="descript_h">Delivery Method</td>
                </tr>		
                <tr>
                    <td class="descript_t"><?= $stn->date_added ?></td>
                    <td class="descript_t"><?= $stn->from_customer_name ?></td>
                    <td class="descript_t" width="50%" ><?= $stn->deliverymethod ?></td>
                </tr>

            </table>
            <br>
            <table class="tbl_inv_addr">
                <?php
                $emp = new employee($stn->emp_to);
                $emp->getEmployee();
                ?>
                <tr>
<!--                    <td style="padding-top: 20px; padding-left: 35px;">
                        <div>
                            <label class="head_inv">Ship To:</label>
                            <br>
                            <label class="head_inv1">
                    <?= $stn->emp_to_name ?>
                                <br>
                                <label style="font-size: 16px;" ><?= $emp->mobile ?></label>
                            </label>
                        </div>
                    </td>-->
<!--                    <td style="padding-top: 20px;">
                        <div>
                            <label class="head_inv">To:</label>
                            <br>
                            <label class="head_inv1">
                                Attention To :
                                <hr style="width: 120%;" >
                    <?= $stn->emp_to_name ?>
                                <br>
                                <label style="font-size: 14px;" ><i><?= $emp->mobile ?></i></label>
                            </label>
                        </div>
                    </td>-->
                </tr>
            </table>
        </div>
        <div id="div_body" style="margin-top: 20px;">
            <!-- LABOUR AND PARTS -->
            <table class="tbl_body" id="tbl_body_id">	
                <thead>											
                    <tr>

                        <th align="left">No</th>
                        <th align="left">Item Code</th>
                        <th align="left">Description</th>
                        <th align="left">Serial#</th>
                        <th class="right">Qty</th>
                        <th class="right">RMA Ref#</th>
                    </tr>
                </thead>
                <?php
                //$ary_items = $stn->getSTNItems(Array(constants::$STOCK_ITEM_CLOSED, constants::$STOCK_ITEM_FINISHED));
                if($stn->status_id =="1"){
                   $ary_items = $stn->getSTNItems(); 
                }else {
                   $ary_items = $stn->getSTNItems(Array(constants::$STOCK_ITEM_CLOSED, constants::$STOCK_ITEM_FINISHED)); 
                }
                
                $inv_item = new \inventory_track_item();
                $i = 1;
                $qty = 0;
                $totqty = 0;
                if (count($ary_items) > 0) {
                    foreach ($ary_items as $inv_item) {
                        
                        if($inv_item->flag_str==""){
                            print '<tr>
                                            <td>' . $i . '</td>
                                            <td>' . $inv_item->system_code . '</td>
                                            <td>' . $inv_item->system_name . '</td>
                                            <td >' . $inv_item->serial . '</td>
                                            <td class="right">' . $inv_item->qty . '</td>
                                            <td class="right">' . $inv_item->issue_reference . '</td>
                                    </tr>';
                            $i++;
                            if ($inv_item->qty != "") {
                                $totqty += $inv_item->qty;
                            } else {

                                $totqty++;
                            }
                        }
                    }
                } else {

                    //echo '<script>window.close()</script>';
                }
                ?>
            </table>
        </div>

        <div id="div_total">
            <table class="tbl_total" id="tbl_total_id" style="border: 1px;">

                <tr>
                    <td width="50%" style="border: 1px;">
                        <div>

                        </div>
                    </td>
                    <td width="50%" style="border: 1px;">
                        <div>
                            <table class="tbl_total_ch" id="tbl_total" style="border: 1px;">

                                <tr>
                                    <td class="descript_h_bold" style="text-align: right;">QTY :</td>
                                    <td class="descript_h_bold" style="text-align: right;"><?= $totqty ?></td>
                                </tr> 

                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <table width="100%" style="border: 1px solid silver;" id="tbl_tail_id">
            <tr>
                <td colspan="1" height="35px;" style="font-size:13px; " ><b>Note</b> : &nbsp;&nbsp;<span  ><?= $stn->note ?></span></td>
            </tr>
        </table>
        
        <span style="font-size: 12px;">Delivered By: </span><span style="font-size: 12px;"> <?= $stn->emp_to_name ?> - <?= $emp->mobile ?></span>
        <br>
        <table width="100%" id="tbl_tail_id">
            <tr>
                <td colspan="3" height="35px;"></td>
            </tr>
            <tr>
                <td width="30%" align="center" class="descript_t"><div style="border-top: 1px solid gray; display: inline-block; width: 50%">Issued By</div></td>
                <!--<td width="30%" align="center" class="descript_t"><div style="border-top: 1px solid gray;display: inline-block; width: 50%"">Checked By</div></td>-->
                <td width="30%" align="center" class="descript_t"><div style="border-top: 1px solid gray;display: inline-block; width: 50%"">Received By / Date</div></td>
            </tr>
        </table>
        <hr>
        <div id="div_note">
            <table width="100%">
                <tr>
                    <td align="center" colspan="2" style="font-size:12px; " >Items received in good condition as per the quantity in delivery note</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;font-size:14px;" > Remarks :</td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div id="div_note_sp">
            <p></p>
        </div>

    </div>
    <div class="div_but" style="background-color: white;height: 70px;">


    </div>
</body>
<script type="text/javascript" src="../js/plugin/sweetalerts/sweetalerts.js"></script>
<script>

    $(document).ready(function () {
        <?php 
         if($stn->status_id =="1"){  ?>
           Swal.fire({
              title: 'Are you sure?',
              text: "This is not Confirm Yet!",
              icon: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'OK'
            }).then((result) => {
               
              if (result.isConfirmed) {
                 setTimeout(() => {
                    window.print();
                  }, 500);
              }
            })
         
         <?php } else { ?>
             window.print();
         <?php  } ?>
        
    });

    function checkPage() {
        var docHeight;
        var headerHeight = $('#div_header').height();
        var tableInfoHeight = $('#div_inv_info').height();
//alert(taleInfoHeight);
        var tableBodyHeight = $('#tbl_body_id').height();
//alert(taleBodyHeight);
        var tableTotalHeight = $('#tbl_total_id').height();
        var tableTailHeight = $('#tbl_tail_id').height();
        var orgHTML = $('#contentDiv').html();
        var headerHTML = $('#div_header').html();
        $('#contentDiv').html(headerHTML + orgHTML);
        var H_page = mmToPX(297);
        var H_margin_top = mmToPX(6.7);
        var H_margin_bot = mmToPX(18);
        var H_page_print = H_page - (H_margin_top + H_margin_bot);
//alert(headerHeight+tableInfoHeight+tableBodyHeight);
//alert(H_page_print);
        if ((headerHeight + tableInfoHeight + tableBodyHeight) > H_page_print) {
            //break
            var start_height = headerHeight + tableInfoHeight;
            var n = 1;
            var breaked = false;
            $("#tbl_body_id").find("tr").each(function () {
                start_height = start_height + $(this).height();
                if (start_height > H_page_print) {
                    //alert('break @:'+n);
                    var $main = $('#tbl_body_id'),
                            $head = $main.find('tr:first'),
                            $extraRows = $main.find('tr:gt(0)');
                    for (var i = 0; i < $extraRows.length; i = i + n) {
                        if (i > 1) {
                            braked = true;
                            $('<div style="page-break-before: always;">').append(headerHTML).appendTo($main.parent());
                        }
                        $('<table class="tbl_body">').append($head.clone(), $extraRows.slice(i, i + n)).appendTo($main.parent());
                    }
                    $main.remove();
                }
                n++;
            });
            //not breaked still high
            $('<div style="page-break-before: always;">').append(headerHTML).prependTo($('#div_total'));
        } else if ((headerHeight + tableInfoHeight + tableBodyHeight + tableTotalHeight + tableTailHeight) > H_page_print) {
            //alert('break');
            $('<div style="page-break-before: always;">').append(headerHTML).prependTo($('#div_total'));
            //alert('vvvv');
        }

    }

    function mmToPX(mm) {
        var div = document.createElement('div');
        div.style.display = 'block';
        div.style.height = '100mm';
        document.body.appendChild(div);
        var convert = div.offsetHeight * mm / 100;
        div.parentNode.removeChild(div);
        return convert;
    }
    ;
</script>