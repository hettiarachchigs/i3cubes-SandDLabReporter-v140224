<?php
session_start();

$ary_prev = $_SESSION['USER_PREV'];
//print_r($_SESSION);
//initilize the page
require_once ("../lib/config.php");
include_once '../class/employeeManager.php';

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

include_once '../class/item.php';
include_once '../class/employeeManager.php';
include_once '../class/cls_log.php';

$i = new item();
//$fn=new functions();

if ($_POST['but'] == 'save') {
    $log=new log();
    print_r($_POST);
    if ($_POST['item_id'] == '') {
        //Add new
        $item_mgr=new item_manager();
        $item = new \item();
        $item_mgr = new item_manager();
        $item = $item_mgr->getPartFromCode($_POST['prd_code']);

        if ($item) {
            $msg = '<font color="red">Part Number already added.</font>';
            $close = false;
        } else {
            $item = new item();
            $item->description = $_POST['prd_name'];
            $item->code = $_POST['prd_code'];
            if($_POST['prd_manufacturer_id']==''){
                $item->makeID=$item_mgr->addMake($_POST['prd_manufacturer']);
            }
            else{
                $item->makeID = $_POST['prd_manufacturer_id'];
            }
            if($_POST['prd_model_id']==''){
                $item->modelID=$item_mgr->addModel($item->makeID, $_POST['prd_model'], $_POST['prd_cat']);
            }
            else{
                $item->modelID = $_POST['prd_model_id'];
            }
            $item->min_stock = $_POST['prd_min_stock'];
            $item->max_stock = $_POST['prd_max_stock'];
            $item->type = $_POST['prd_type'];
            $item->system_code=$_POST['prd_seq_code'];
            
            $item->save();
            if ($item->id) {
                $close = true;
                //set log
                $log_str="PART ADDED: ".$item->toString();
                $log->setLog($_SESSION['EMPID'], "SYS", $item->id, $log_str);
            } else {
                $close = false;
            }
        }
    } else {
        //Edit existing
        $item = new item($_POST['item_id']);
        $item->getItem();
        $log_str_old=$item->toString();
        $item->description = $_POST['prd_name'];
        $item->code = $_POST['prd_code'];
        if($_POST['prd_manufacturer_id']==''){
            $item->makeID=$item_mgr->addMake($_POST['prd_manufacturer']);
        }
        else{
            $item->makeID = $_POST['prd_manufacturer_id'];
        }
        if($_POST['prd_model_id']==''){
            $item->modelID=$item_mgr->addModel($item->makeID, $_POST['prd_model'], $_POST['prd_cat']);
        }
        else{
            $item->modelID = $_POST['prd_model_id'];
        }
        $item->min_stock = $_POST['prd_min_stock'];
        $item->max_stock = $_POST['prd_max_stock'];
        $item->type = $_POST['prd_type'];
        $item->system_code=$_POST['prd_seq_code'];
        $res = $item->update();
        if ($res) {
            $close = true;
            $log_str="PART MODIFIED: OLD-DATA".$log_str_old."::NEW DATA".$item->toString();
            $log->setLog($_SESSION['EMPID'], "SYS", $item->id, $log_str);
        } else {
            $close = false;
        }
    }
} else if ($_POST['but'] == 'delete') {
    $item = new item($_POST['item_id']);
    if ($item->delete()) {
        $close = true;
    } else {
        $close = false;
    }
} else {
    $item = new item($_REQUEST['item_id']);
    $item->getItem();
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
                            <span><h2 style="margin-left: 20px;">Add Item</h2></span>				

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
                                                <strong>Description:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-cog"></i>
                                                    <input type="text" name="prd_name" id="prd_name" placeholder="Item Description" value="<?php print $item->description ?>">
                                                    <b class="tooltip tooltip-bottom-right">Item Description</b> 
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Item Code:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-cog"></i>
                                                    <input type="text" name="prd_code" id="prd_code" placeholder="Product Code" value="<?php print $item->code ?>">
                                                    <b class="tooltip tooltip-bottom-right">Product Code</b> 
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Make(Manufacturer):</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="prd_manufacturer" id="prd_manufacturer" placeholder="Manufacturer" value="<?php print $item->make ?>">
                                                    <b class="tooltip tooltip-bottom-right">Manufacturer</b> 
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Model:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-wrench"></i>
                                                    <input type="text" name="prd_model" id="prd_model" placeholder="Model" value="<?php print $item->model ?>">
                                                    <b class="tooltip tooltip-bottom-right">Model</b> 
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Inventory Type:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class=" select "> <i class="icon-append"></i>
<!--                                                                                                    <input type="text" name="dobmonth" id="dobm" class="dob" placeholder="month">-->
                                                    <select name="prd_type" id="prd_type">
                                                        <option value="I" <?php if ($item->type == "I") {
                                                            print 'selected=""';
                                                        } ?>>Inventory Item</option>
                                                        <option value="C" <?php if ($item->type == "C") {
                                                            print 'selected=""';
                                                        } ?>>Consumable Item</option>
                                                        <option value="IEX" <?php if ($item->type == "IEX") {
                                                            print 'selected=""';
                                                        } ?>>External Inventory Item</option>
                                                    </select>
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Category:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class=" select "> <i class="icon-append"></i>
<!--                                                                                                    <input type="text" name="dobmonth" id="dobm" class="dob" placeholder="month">-->
                                                    <select name="prd_cat" id="prd_cat">
                                                        <?php 
                                                            $fn=new functions();
                                                            print $fn->CreateMenu("item_category", "category_name", "", $item->model_category_id, false, "id", true, false);
                                                        ?>
                                                    </select>
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Sequential Code:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="prd_seq_code" id="prd_seq_code" placeholder="Sequencial Code" value="<?php print $item->system_code ?>">
                                                    <b class="tooltip tooltip-bottom-right">Sequential Cod</b> 
                                                </label>
                                            </section>
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <!--
                                            <div class="row">
                                                    <section class="col-xs-1 col-sm-1 col-md-1">
                                                    </section>
                                                    <section class="col-xs-3 col-sm-3 col-md-3">
                                                            <strong>Min Stock:</strong>
                                                    </section>
                                                    <section class="col-xs-7 col-sm-7 col-md-7">
                                                        <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                <input type="text" name="prd_min_stock" id="prd_min_stock" placeholder="Min Stock" value="">
                                                                <b class="tooltip tooltip-bottom-right">Min Stock</b> 
                                                        </label>
                                                    </section>
                                                    <section class="col-xs-1 col-sm-1 col-md-1">

                                                    </section>
                                            </div>
                                            <div class="row">
                                                    <section class="col-xs-1 col-sm-1 col-md-1">
                                                    </section>
                                                    <section class="col-xs-3 col-sm-3 col-md-3">
                                                            <strong>Max Stock:</strong>
                                                    </section>
                                                    <section class="col-xs-7 col-sm-7 col-md-7">
                                                            <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                    <input type="text" name="prd_max_stock" id="prd_max_stock" placeholder="Max Stock" value="">
                                                                    <b class="tooltip tooltip-bottom-right">Max Stock</b> 
                                                            </label>
                                                    </section>
                                                    <section class="col-xs-1 col-sm-1 col-md-1">

                                                    </section>
                                            </div>
                                        -->
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
                                        <input type="hidden" name="prd_model_id" id="prd_model_id" value="<?php print $item->modelID ?>">
                                        <input type="hidden" name="prd_manufacturer_id" id="prd_manufacturer_id" value="<?php print $item->makeID ?>">
                                        <input type="hidden" name="item_id" id="item_id" value="<?php print $_REQUEST['item_id'] ?>">
                                        <?php if ($ary_prev['6'][1] == '1') { ?>
                                            <button type="submit" class="btn btn-primary" id="but_save" name="but" value="save">
                                                Save
                                            </button>
                                        <?php } ?>
                                        <?php if ($ary_prev['6'][2] == '1') { ?>
                                            <button type="submit" class="btn btn-danger" id="but_del" name="but" value="delete">
                                                Delete
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

if (($ary_prev[6][3] == '1')) {
    print '$( "#but_del" ).prop( "disabled", false );';
}
?>

        $('#prd_model').autocomplete({
            source: '../json/get_model',
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                if (id != '') {
                    $('#prd_model_id').val(id);
                }
            }
        });
        $('#prd_manufacturer').autocomplete({
            source: '../json/get_make',
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                if (id != '') {
                    $('#prd_manufacturer_id').val(id);
                }
            }
        });


        var $registerForm = $("#ven_add").validate({

            // Rules for form validation
            rules: {
                v_name: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                v_name: {
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