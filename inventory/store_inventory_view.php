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

$page_title = "Customer-Edit";

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

$fn = new functions();
//print_r($_POST);
$cid = $_REQUEST['id'];
if ($cid == '') {
    $cid = $_POST['cus_id'];
}
$cus = new customer($cid);

$cus->getCustomer();
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="margin-left: 10px;">

    <!-- MAIN CONTENT -->
    <div id="content">

        
        <!-- end widget grid -->
        <!-- Customer Equipments if there is any-->
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
                            <h2>Inventory[<?php print $cus->name?>]</h2>

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
                                $ary_eq = $cus->getAllSystems();
                                //var_dump($ary_eq);
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
                                                <th data-hide='phone'>Cus-Warranty</th>
                                                <th data-hide='phone'>Vender-Warranty</th>
                                                <th data-hide='phone'>Type</th>
                                                <th data-hide='phone'>Qty</th>
                                                <th data-hide='phone'>Opr.Status</th>
                                                <th data-hide='phone'>Status</th>
                                           </tr>
                                            </thead>
                                            <tbody>";

                                    $i = 1;
                                    $sys=new \system();
                                    $const=new constants();
                                    foreach ($ary_eq as $sys) {   //Creates a loop to loop through results

                                        echo "
                                        <tr id=" . '"' . $sys->id . '" class="ngs-popup-eq"' . ">	  
                                            <td>" . $i . "</td>
                                            <td>" . $sys->system_code . "</td>
                                            <td>" . $sys->system_name . "</td>
                                            <td>" . $sys->serial . "</td>
                                            <td>" . $sys->cus_warr_end . '</td>
                                            <td>' . $sys->v_warr_end . '</td>
                                            <td>' . $sys->system_type . '</td>
                                            <td>' . $sys->qty . '</td>
                                            <td>' . $const->getSYS_OPR_STATUS($sys->opr_status). '</td>
                                            <td>' . $const->getSYSTEM_STATUS($sys->status). '</td>
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
//$('.ngs-popup-eq').click(function () {
//    edit_equipment(this.id);
//});

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
    
    $('.ngs-popup-eq').click(function () {
        edit_equipment(this.id);
    });

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
    $('#t_cus_eq_list').dataTable({

        responsive: true,
        pageLength: 20,
        dom: "<'dt-toolbar '<'col-sm-6 col-xs-12 hidden-xs' B><'col-sm-6 col-xs-12' f>>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",

        buttons: [

            {extend: 'csv'},
            {extend: 'excel', title: 'Fault Ticket'},
            {extend: 'pdf', title: 'Fault Ticket'},

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

    /* END TABLETOOLS */

    /*NGS addings*/


<?php

?>

    });

                                                            
                                                            
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
