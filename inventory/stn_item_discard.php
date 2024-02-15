<?php
session_start();

$ary_prev = $_SESSION['USER_PREV'];
//print_r($_SESSION);
//initilize the page
require_once ("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Item-Return";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["forms"]["sub"]["smart_layout"]["active"] = true;
//include("..inc/nav.php");
// ====================== LOGIC ================== --!>

include_once '../class/stn.php';
include_once '../class/cls_inventory_item.php';
//include_once '../class/item.php';
//include_once '../class/itemManager.php';
include_once '../class/cls_log.php';
include_once '../class/cls_system.php';

$trk_item=new inventory_track_item($_REQUEST['item_id']);
$trk_item->getData();
if ($_POST['but'] == 'save') {
    $note="Discarded Ref#:".$trk_item->issue_reference;
    $cus_sys=new system($trk_item->customer_system_id);
    $cus_sys->setStatus(constants::$SYS_DISCONTINUE);
    $trk_item->setItemStatus(constants::$STOCK_ITEM_FINISHED);
    $trk_item->FinishzeChainedReferenceItem();
    $log_str="ITEM DISCARD, REF#:".$trk_item->issue_reference;
    $log=new log();
    $log->setLog($_SESSION['EMPID'], "CUS_SYS", $cus_sys->id, $log_str);    
    
    $close=true;
}
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="min-height: 200px;"> 

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
                    <div class="jarviswidget" id="wid-id-4" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">

                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i></span>
                            <span><h2 style="margin-left: 20px;">Return Item</h2></span>				

                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <form id="ven_add" class="smart-form" action="" method="post">
                                    <fieldset>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Serial:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <?php print $trk_item->serial?>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Note:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="textarea">
                                                    <textarea rows="2" style="width: 100%;" name="note" id="note" placeholder="Note"></textarea> 
                                                    <b class="tooltip tooltip-bottom-right">Note</b>
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col col-12">
                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col col-12">
                                            </section>
                                        </div>
                                    </fieldset>
                                    <footer>	
                                        <input type="hidden" name="stn_item_id" id="stn_item_id" value="<?php print $_REQUEST['item_id'] ?>">
                                        <?php if ($ary_prev['6'][1] == '1') { ?>
                                            <button type="submit" class="btn btn-primary" id="but_save" name="but" value="save">
                                                Save
                                            </button>
                                        <?php } ?>
                                        <p><?php print $msg ?></p>
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
}
?>
    $(document).ready(function () {

<?php
if (($ary_prev[6][2] == '1') || ($ary_prev[6][1] == '1')) {
    print '$( "#but_save" ).prop( "disabled", false );';
}

?>

    });

</script>