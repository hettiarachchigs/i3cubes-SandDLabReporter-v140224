<?php
session_start();

$ary_prev = $_SESSION['USER_PREV'];

require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Add Store";

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

include_once '../class/branch.php';
include_once '../class/customer.php';
include_once '../class/functions.php';

if ($_POST['but'] == 'save') {
    $cus = new customer();
    $res = $cus->addCustomer($_POST['cus_name'], $_POST['cus_address'], $_POST['cus_code'], $_POST['cus_cont_name'], $_POST['cus_cont_number'], $_POST['cus_cont_email'], $_POST['cus_note'], $_POST['cus_acc_owner_id'], $_POST['cus_group'], $_POST['cus_cluster'], "S",$_POST['cus_district'],"");
    if ($res) {
        $close = true;
    } else {
        $close = false;
        $msg = "Store could not be added..";
    }
}

$fn = new functions();
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
                    <div class="jarviswidget" id="wid-id-500" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i></span>
                            <span style="margin-left: 20px;"><h2>Add Store</h2></span>				

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

                                <form id="smart-form-register" class="smart-form" method="post">
                                    <fieldset>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Store Name:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="cus_name" id="cus_name" placeholder="Store Name" value="" >
                                                    </section>	
                                                    <section class="col-xs-1 col-sm-1 col-md-1">

                                                    </section>
                                                    </div>
                                                    <div class="row">
                                                        <section class="col-xs-1 col-sm-1 col-md-1">
                                                        </section>
                                                        <section class="col-xs-3 col-sm-3 col-md-3">
                                                            <strong>Address:</strong>
                                                        </section>
                                                        <section class="col-xs-7 col-sm-7 col-md-7">
                                                            <label class="textarea"> <i class="icon-append fa fa-location-arrow"></i>
                                                                <textarea name="cus_address" id="cus_address" placeholder="Address" ></textarea>
                                                            </label>
                                                        </section>	
                                                        <section class="col-xs-1 col-sm-1 col-md-1">

                                                        </section>
                                                    </div>
                                                    <div class="row">
                                                        <section class="col-xs-1 col-sm-1 col-md-1">
                                                        </section>
                                                        <section class="col-xs-3 col-sm-3 col-md-3">
                                                            <strong>Site Code:</strong>
                                                        </section>
                                                        <section class="col-xs-7 col-sm-7 col-md-7">
                                                            <label class="input"> <i class="icon-append fa fa-user"></i>
                                                                <input type="text" name="cus_code" id="cus_code" placeholder="Site Code" value="" >
                                                                </section>	
                                                                <section class="col-xs-1 col-sm-1 col-md-1">

                                                                </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col-xs-1 col-sm-1 col-md-1">
                                                                    </section>
                                                                    <section class="col-xs-3 col-sm-3 col-md-3">
                                                                        <strong>Contact Name:</strong>
                                                                    </section>
                                                                    <section class="col-xs-7 col-sm-7 col-md-7">
                                                                        <label class="input"> <i class="icon-append fa fa-user"></i>
                                                                            <input type="text" name="cus_cont_name" id="cus_cont_name" placeholder="Contact Name" value="" >
                                                                            </section>	
                                                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                                                            </section>
                                                                            </div>
                                                                            <div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                </section>
                                                                                <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                    <strong>Contact Number:</strong>
                                                                                </section>
                                                                                <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                    <label class="input"> <i class="icon-append fa fa-user"></i>
                                                                                        <input type="text" name="cus_cont_number" id="cus_cont_number" placeholder="Contact Number" value="" >
                                                                                        </section>	
                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">

                                                                                        </section>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                            </section>
                                                                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                                <strong>Contact Email:</strong>
                                                                                            </section>
                                                                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                                                                                    <input type="text" name="cus_cont_email" id="cus_cont_email" placeholder="Contact Email" value="" >
                                                                                                    </section>	
                                                                                                    <section class="col-xs-1 col-sm-1 col-md-1">

                                                                                                    </section>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                                        </section>
                                                                                                        <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                                            <strong>Technical Group:</strong>
                                                                                                        </section>
                                                                                                        <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                                            <label class="select">													
                                                                                                                <select name="cus_group" id="cus_group">
                                                                                                                    <option value="0" selected="" disabled="">Select Group</option>
                                                                                                                    <?php
                                                                                                                    print $fn->CreateMenu('team', 'name', '', '', false, 'id', false, true);
                                                                                                                    ?>
                                                                                                                </select> <i></i> 
                                                                                                            </label>
                                                                                                        </section>	
                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">

                                                                                                        </section>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                                        </section>
                                                                                                        <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                                            <strong>Cluster:</strong>
                                                                                                        </section>
                                                                                                        <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                                            <label class="select">													
                                                                                                                <select name="cus_cluster" id="cus_cluster">
                                                                                                                    <option value="0" selected="" disabled="">Select Cluster</option>
                                                                                                                    <?php
                                                                                                                    print $fn->CreateMenu('customer_cluster', 'cluster', '', '', false, 'id', false, true);
                                                                                                                    ?>
                                                                                                                </select> <i></i> 
                                                                                                            </label>
                                                                                                        </section>	
                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">

                                                                                                        </section>
                                                                                                    </div>
                                                                                                    <div class="row">
                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                                        </section>
                                                                                                        <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                                            <strong>District:</strong>
                                                                                                        </section>
                                                                                                        <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                                            <label class="select">													
                                                                                                                <select name="cus_district" id="cus_district">
                                                                                                                    <option value="0" selected="" disabled="">District</option>
                                                                                                                    <?php
                                                                                                                    print $fn->CreateMenu('district', 'district_name', '', $cus->district_id, false, 'id', false, true);
                                                                                                                    ?>
                                                                                                                </select> <i></i> 
                                                                                                            </label>
                                                                                                        </section>	
                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">

                                                                                                        </section>
                                                                                                    </div>

                                                                                                    <div class="row">
                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                                        </section>
                                                                                                        <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                                            <strong>Contact Note:</strong>
                                                                                                        </section>
                                                                                                        <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                                            <label class="textarea"> <i class="icon-append fa fa-comment"></i> 
                                                                                                                <textarea name="cus_note" id="cus_note" rows="5" placeholder="Contact Note" disabled=""></textarea>
                                                                                                            </label>
                                                                                                        </section>	
                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">

                                                                                                        </section>
                                                                                                    </div>

                                                                                                    <!--                                                                                                    <div class="row">
                                                                                                                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                                                                                                                                        </section>
                                                                                                                                                                                                        <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                                                                                                                                        <strong>Store Type:</strong>
                                                                                                                                                                                                        </section>
                                                                                                                                                                                                        <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                                                                                                                                        <label class="select">													
                                                                                                                                                                                                        <select name="cus_type" id="cus_type">
                                                                                                                                                                                                        <option value="V" selected="">Voice</option>
                                                                                                                                                                                                        <option value="D">Data</option>
                                                                                                                                                                                                        </select> <i></i> 
                                                                                                                                                                                                        </label>
                                                                                                                                                                                                        </section>	
                                                                                                                                                                                                        <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                            
                                                                                                                                                                                                        </section>
                                                                                                                                                                                                        </div>-->
                                                                                                    </fieldset>
                                                                                                    <footer>
                                                                                                        <p style="display: none;color: red;" id="msg_prev"><i class="fa-fw fa fa-times"></i>You are not authorized</p>

                                                                                                        <input type="hidden" name="group_id" id="group_id" value="">
                                                                                                        <button type="submit" class="btn btn-primary" id="but" name="but" value="save" disabled="">
                                                                                                            Save
                                                                                                        </button>
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

                                                                                        <!-- END PAGE FOOTER -->

                                                                                        <?php
                                                                                        //include required scripts
                                                                                        include("../inc/scripts.php");
                                                                                        ?>

                                                                                        <script type="text/javascript">
                                                                                            checkUserPopUp('<?php print $_SESSION['UID'] ?>');
                                                                                            // DO NOT REMOVE : GLOBAL FUNCTIONS!

<?php
if ($close) {
    print "window.parent.location.reload();";
    print "window.parent.$.jeegoopopup.close();";
} else {
    print '$( "#msg_prev" ).html( "' . $msg . '" );';
    print '$( "#msg_prev" ).css("display", "block");';
}
?>

                                                                                            // DO NOT REMOVE : GLOBAL FUNCTIONS!

                                                                                            $(document).ready(function () {

                                                                                                /*NGS addings*/
                                                                                                $('#br_group').autocomplete({
                                                                                                    source: 'json/get_group.php',
                                                                                                    minLength: 1,
                                                                                                    select: function (event, ui) {
                                                                                                        var id = ui.item.id;
                                                                                                        if (id != '') {
                                                                                                            $('#group_id').val(id);
                                                                                                        }
                                                                                                    }
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

                                                                                        </script>
