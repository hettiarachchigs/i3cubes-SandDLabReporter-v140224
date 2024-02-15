<?php
session_start();
$ary_prev=$_SESSION['USER_PREV'];

//print_r($ary_prev[6]);
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Add Customer System";

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

//include_once '../class/system.php';
include_once '../class/functions.php';
include_once '../class/constants.php';
include_once '../class/customerEntity.php';
include_once '../class/stn.php';
include_once '../class/cls_stn_system.php';
//include_once '../class/cls_system.php';
include_once '../class/sttn.php';
include_once '../class/cls_inventory_item.php';

$fn=new functions();

$trk_item=new inventory_track_item($_REQUEST['item_id']);
$trk_item->getData();
$cus_system_old=new system($trk_item->customer_system_id);
$cus_system_old->getSystem();
    
if($_POST['but']=='save'){
    
    $sttn=new sttn();
    $sttn->emp_added=$_SESSION['EMPID'];
    $sttn->to_customer_id=$trk_item->customer_entity_id_from;
    $sttn->loguserid=$_SESSION['EMPID'];
    $sttn->addSTTN();
    if($sttn->id!=""){
        $item=new item($_POST['eq_system']);
        $item->getItem();
        $cus_sys=new system();
        $cus_sys_id=$cus_sys->addSystem($item->code, $_POST['eq_serial'], '', $item->description, $_POST['eq_system'], $sttn->to_customer_id, "","","");
        $sttn->addSTTNItem($sttn->id, $_POST['eq_system'], $_POST['eq_serial'], $_POST['eq_optional_text'], '', $sttn->to_customer_id, '1', $cus_sys_id);
        $sttn->ConfirmItemChanges();
        $sttn->confirnSTTN();
        $trk_item->setItemStatus(constants::$STOCK_ITEM_FINISHED);
        $trk_item->FinishzeChainedReferenceItem();
        $log=new log();
        $log_str=$cus_system_old->serial." Replaced with ".$_POST['eq_serial'];
        $log->setLog($_SESSION['EMPID'], 'CUS_SYS', $cus_system_old->id, $log_str);
        $cus_system_old->setStatus(constants::$SYS_IN_DISCONTINUE);
        $close=true;
    }
 
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
					<div class="jarviswidget" id="wid-id-59" 
                                                data-widget-deletebutton="false" 
						data-widget-togglebutton="false"
						data-widget-editbutton="false"
						data-widget-fullscreenbutton="false"
                                                data-widget-colorbutton="false">
                                                <header>
							<span class="widget-icon"> <i class="fa fa-edit"></i></span>
							<span style="margin-left: 20px;"><h2>Add Customer System</h2></span>				
							
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
								
								<form id="frm_system_add" class="smart-form" method="post">
									<fieldset>
                                                                            <div class="row">
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
										<section class="col-xs-3 col-sm-3 col-md-3">
											<strong>Replace to:</strong>
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
											<strong>Description:</strong>
										</section>
										<section class="col-xs-7 col-sm-7 col-md-7">
                                                                                    <?php print $cus_system_old->system_name?>
										</section>	
										<section class="col-xs-1 col-sm-1 col-md-1">
	
										</section>
                                                                            </div>
                                                                            <div class="row">
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
										<section class="col-xs-3 col-sm-3 col-md-3">
											<strong>Description:</strong>
										</section>
										<section class="col-xs-7 col-sm-7 col-md-7">
                                                                                    <label class="select">													
                                                                                        <select name="eq_system" id="eq_system">
                                                                                            <option value="" selected="" disabled="">Select System</option>
                                                                                            <?php 
                                                                                                print $fn->CreateMenu('systems','description',"type='I'",$stn_system->system_id,false,'id',false,true);
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
											<strong>Serial:</strong>
										</section>
										<section class="col-xs-7 col-sm-7 col-md-7">
											<label class="input"> <i class="icon-append fa fa-user"></i>
                                                                                            <input type="text" name="eq_serial" id="eq_serial" placeholder="Serial" value="" disabled="">
										</section>	
										<section class="col-xs-1 col-sm-1 col-md-1">
	
										</section>
                                                                            </div>
                                                                            
                                                                            <div class="row">
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
										<section class="col-xs-3 col-sm-3 col-md-3">
											<strong>Optional Text:</strong>
										</section>
										<section class="col-xs-7 col-sm-7 col-md-7">
											<label class="textarea"> <i class="icon-append fa fa-location-arrow"></i>
                                                                                            <textarea name="eq_optional_text" id="eq_optional_text" placeholder="Optional Text" disabled=""></textarea>
                                                                                        </label>
										</section>	
										<section class="col-xs-1 col-sm-1 col-md-1">
	
										</section>
                                                                            </div>
									</fieldset>
									<footer>
                                                                            <?php print $msg?>
                                                                            <p style="display: none;color: red;" id="msg_prev"><i class="fa-fw fa fa-times"></i>You are not authorized</p>
                                                                            <input type="hidden" name="cus_ent_id" id="cus_ent_id" value="<?php print $cus_ent_id?>">
                                                                            <input type="hidden" name="stn_item_id" id="stn_item_id" value="<?php print $_REQUEST['stn_item_id']?>">
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
checkUserPopUp('<?php print $_SESSION['UID']?>');
// DO NOT REMOVE : GLOBAL FUNCTIONS!

<?php 
if($close){
	print "window.parent.location.reload();";
	print "window.parent.$.jeegoopopup.close();";
}
else {
	print '$( "#msg_prev" ).html( "'.$msg.'" );';
        print '$( "#msg_prev" ).css("display", "block");';
}
?>
    
// DO NOT REMOVE : GLOBAL FUNCTIONS!

$(document).ready(function() {

    <?php 
    if (($ary_prev[6][1]=='1')){
        print '$( "input" ).prop( "disabled", false );';
        print '$( "#but" ).prop( "disabled", false );';
        print '$( "select" ).prop( "disabled", false );';
        print '$( "textarea" ).prop( "disabled", false );';
    }
    else {
            print '$( "#msg_prev" ).css("display", "block");';
    }
    ?>
            
    var $Form_Val = $("#frm_system_add").validate({
             ignore: "not:hidden",
            // Rules for form validation
            rules : {
                    eq_system : {
                            required : true
                    }                                                                                                                                                                                                                                
            },

            // Messages for form validation
            messages : {
                    eq_system : {
                            required : 'Please select a system'
                    }
            },

            // Do not change code below
            errorPlacement : function(error, element) {
                    error.insertAfter(element.parent());
            }
    });
		
});

</script>
