<?php
session_start();

$ary_prev = $_SESSION['USER_PREV'];
//print_r($_POST);
//initilize the page
require_once ("../lib/config.php");
include_once '../class/itemManager.php';

//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Item-Add";

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

include_once '../class/cls_store_location.php';
include_once '../class/cls_store_locationManager.php';
include_once '../class/cls_log.php';

$s = new store_location();
$s_mgr=new store_locationManager();
//$fn=new functions();

if ($_POST['but'] == 'save') {
    $log=new log();
    if ($_POST['s_id'] == '') {
        //Add new
        if($s_mgr->getByName($_POST['s_name'])){
             $msg = '<font color="red">Location Name already exists.</font>';
        }
        else{
            $s=new store_location();
            $s->name=$_POST['s_name'];
            if($s->save()){
               $close=true;
               $log_str="Store Location ADDED: ".$s->id."|".$s->name;
               $log->setLog($_SESSION['EMPID'], "SYS", $s->id, $log_str);
            }
            else{
                $msg = '<font color="red">Could not save location.</font>';
            }
        }
    } else {
        //Edit existing
        $s = new store_location($_POST['s_id']);
        $s->getData();
        $s->name=$_POST['s_name'];
        $res = $s->update();
        if ($res) {
            $close = true;
            $log_str="Store Location modified: OLD-DATA".$log_str_old."::NEW DATA".$s->toString();
            $log->setLog($_SESSION['EMPID'], "SYS", $s->id, $log_str);
        } else {
            $close = false;
        }
    }
} else if ($_POST['but'] == 'delete') {
    $s= new store_location($_POST['s_id']);
    if ($s->delete()) {
        $close = true;
    } else {
        $close = false;
    }
} else {
    $s = new store_location($_REQUEST['s_id']);
    $s->getData();
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
                            <span><h2 style="margin-left: 20px;">Store Location</h2></span>				

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
                                                <strong>Name:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-cog"></i>
                                                    <input type="text" name="s_name" id="s_name" placeholder="Name(Rack/Shelf/Bin)" value="<?php print $s->name ?>">
                                                    <b class="tooltip tooltip-bottom-right">Name(Rack/Shelf/Bin)</b> 
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        
                                        <div class="row">
                                            <section class="col col-12">
                                                <div style="text-align: center;">
                                                <?php 
                                                if($s->id){
                                                    print '<img src="../inc/qr_image?string='.$s->id.'|'.$s->name.'" /><br>';
                                                    print $s->name;
                                                }
                                                
                                                ?>
                                                </div>
                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col col-12">
                                            </section>
                                        </div>
                                    </fieldset>
                                    <footer>
                                        <input type="hidden" name="s_id" id="s_id" value="<?php print $_REQUEST['s_id'] ?>">
                                        <?php //if ($ary_prev['6'][1] == '1') {----ENABLE WITH PREV ?>
                                            <button type="submit" class="btn btn-primary" id="but_save" name="but" value="save">
                                                Save
                                            </button>
                                        <?php //} ?>
                                        <?php //if ($ary_prev['6'][2] == '1') { ?>
                                            <button type="submit" class="btn btn-danger" id="but_del" name="but" value="delete">
                                                Delete
                                            </button>
                                        <?php //} ?>
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

        var $registerForm = $("#ven_add").validate({

            // Rules for form validation
            rules: {
                s_name: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                s_name: {
                    required: 'Please enter vendor name'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });
    });

</script>