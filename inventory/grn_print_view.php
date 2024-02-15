<?php
session_start();
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


include_once '../class/grn.php';
include_once '../class/grnManager.php';
include_once '../class/cls_stn_system.php';
include_once '../class/employee.php';
include_once '../class/customer.php';
include_once '../class/cls_log.php';
include_once '../class/format.php';
include_once '../class/cls_inventory_item.php';
?>
<!--<script src="./js/libs/jquery-2.0.2.min.js"></script>
<link rel="stylesheet" href="css/font-awesome.min.css">-->

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
        border-bottom:1px solid gray;
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
</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->

<?php
$grn = new grn($_REQUEST["id"]);
$grn->getGRN();

$fomrat=new format();
?>
<!--<body onload="checkPage();" class="hidden-print" >-->
<body onload="" class="hidden-print" >
    <div id="contentDiv">
        <div id="div_header">
            <span class="documentControlNumber">LSC/GRN/00</span>
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
                        <label style="color: #008200;font-weight: bold;font-size: 20px;" >GOOD RECEIVE NOTE</label>
                    </td>
                    <td width="30%">
                        <div style="margin-left: 50px"><label class="txt_status"></label></div>
                    </td>
                    <td width="40%">
                        <div style="width: 100%; text-align: right;"><label class="txt_invoice" style="margin-right: 15px;"></label></div>
                        <div style="width: 100%; text-align: right;"><label  style="margin-right: 15px;font-size: 14px;">GRN No&nbsp;:&nbsp;<i class="head_l1" ><?= $grn->ref_no ?></i></label></div>
                        <div style="width: 100%; text-align: right;"><label  style="margin-right: 15px;font-size: 14px;">GRN Date&nbsp;:&nbsp;<i class="head_l1" ><?= $grn->date_added?></i></label></div>
                    </td>
                </tr>
            </table>

            <hr style="width: 100%; border-top: 1px solid #8c8b8b;border-bottom: 1px solid #fff">
        </div>
        
        <div id="div_inv_info">
            <!-- JOB DEtails -->
            <table class="tbl_cus">
                <tr>
                    <td class="descript_h">Date</td>
                    <td class="descript_h">Batch/Shipment ID/Invoice No</td>
                    <td class="descript_h">Supplier</td>
                </tr>		
                <tr>
                    <td class="descript_t"><?= $grn->effective_date?></td>
                    <td class="descript_t"><?= $grn->shipment_id?></td>
                    <td class="descript_t"  ><?= $grn->vendor_name ?></td>
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
                        <th align="right">Price (Rs)</th>
                        <th class="right">Qty</th>
                        <th class="right">Amount</th>
                    </tr>
                </thead>
                <?php
                $ary_items = $grn->getGRNItems();
                $inv_item = new \inventory_track_item();
                $i = 1;
                $qty = 0;
                $totqty = 0;
                $total_amount=0;
                if (count($ary_items) > 0) {
                    foreach ($ary_items as $inv_item) {

                        print '<tr>
                                        <td>' . $i . '</td>
                                        <td>' . $inv_item->system_code . '</td>
                                        <td>' . $inv_item->system_name . '</td>
                                        <td >' . $inv_item->serial . '</td>
                                        <td align="right">' . $fomrat->formartCurrency($inv_item->cost) . '</td>
                                        <td class="right">' . $inv_item->qty . '</td>
                                        <td align="right">' . $fomrat->formartCurrency($inv_item->cost*$inv_item->qty) . '</td>
                                </tr>';
                        $i++;
                        if ($inv_item->qty != "") {
                            $totqty +=$inv_item->qty;
                        } else {

                            $totqty++;
                        }
                        $total_amount=$total_amount+($inv_item->cost*$inv_item->qty);
                    }
                } else {

                    echo '<script>window.close()</script>';
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
                                    <td class="descript_h_bold" style="text-align: right;">TOTAL AMOUNT :</td>
                                    <td class="descript_h_bold" style="text-align: right;"><?= $fomrat->formartCurrency($total_amount)?></td>
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
                <td colspan="1" height="35px;" style="font-size:13px; " ><b>Note</b> : &nbsp;&nbsp;<span  ><?= $grn->note ?></span></td>
            </tr>
        </table>
        <br>
        <table width="100%" id="tbl_tail_id">
            <tr>
                <td colspan="3" height="35px;"></td>
            </tr>
            <tr>
                <td width="30%" align="center" class="descript_t"><div style="border-top: 1px solid gray; display: inline-block; width: 50%">Checked By</div></td>
                <!--<td width="30%" align="center" class="descript_t"><div style="border-top: 1px solid gray;display: inline-block; width: 50%"">Checked By</div></td>-->
                <td width="30%" align="center" class="descript_t"><div style="border-top: 1px solid gray;display: inline-block; width: 50%"">Received By / Date</div></td>
            </tr>
        </table>
        <hr>
        <div id="div_note">
            <table width="100%">
                <tr>
                    <!--<td align="center" colspan="2" style="font-size:12px; " >Items received in good condition as per the quantity in delivery note</td>-->
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

<script>

    $(document).ready(function () {

        window.print();
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