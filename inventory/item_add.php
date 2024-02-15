<?php
session_start();

$ary_prev=$_SESSION['ROLE_PREV'];
//print_r($_SESSION);
//initilize the page
require_once ("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/*---------------- PHP Custom Scripts ---------

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
include_once '../class/itemManager.php';

$i=new item();
//$fn=new functions();

if($_POST['but']=='save'){
	$item=new \item();
        $item_mgr=new item_manager();
        $item=$item_mgr->getPartFromCode($_POST['prd_code']);
        
	if($item){
            $msg='<font color="red">Part Number already added.</font>';
            $close=false;
	}
	else {
            $item=new item();
            $item->description=$_POST['prd_name'];
            $item->code=$_POST['prd_code'];
            $item->makeID=$_POST['prd_manufacturer_id'];
            $item->modelID=$_POST['prd_model_id'];
            $item->min_stock=$_POST['prd_min_stock'];
            $item->max_stock=$_POST['prd_max_stock'];
            $item->save();
            if($item->id){
                $close=true;
            }
            else {
                $close=false;
            }
	}
	
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
                                                                                                    <input type="text" name="prd_name" id="prd_name" placeholder="Item Description" value="">
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
                                                                                                    <input type="text" name="prd_code" id="prd_code" placeholder="Part Number/Spare Code" value="">
                                                                                                    <b class="tooltip tooltip-bottom-right">Item Code</b> 
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
                                                                                                        <input type="text" name="prd_model" id="prd_model" placeholder="Model" value="" style="text-transform: uppercase">
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
												<strong>Manufacturer:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
                                                                                            <label class="input"><i class="icon-append fa fa-user"></i>
                                                                                                    <input type="text" name="prd_manufacturer" id="prd_manufacturer" placeholder="Manufacturer" value="" style="text-transform: uppercase">
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
												<strong>Inventory Type:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
                                                                                            <label class=" select "> <i class="icon-append"></i>
            <!--                                                                                                    <input type="text" name="dobmonth" id="dobm" class="dob" placeholder="month">-->
                                                                                                <select name="prd_type" id="prd_type">
                                                                                                    <option value="I" selected="">Ineventory</option>
                                                                                                    <option value="C">Consumable</option>

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
												<strong>Min Stock:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
                                                                                            <label class="input"><i class="icon-append fa fa-calendar"></i>
                                                                                                    <input type="text" name="prd_min_stock" id="prd_min_stock" placeholder="Min Stock" value="<?php print $prd_data['Min_Stock']?>">
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
                                                                                                        <input type="text" name="prd_max_stock" id="prd_max_stock" placeholder="Max Stock" value="<?php print $prd_data['Max_Stock']?>">
                                                                                                        <b class="tooltip tooltip-bottom-right">Max Stock</b> 
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
                                                                            <input type="hidden" name="prd_model_id" id="prd_model_id" value="">
                                                                            <input type="hidden" name="prd_manufacturer_id" id="prd_manufacturer_id" value="">
                                                                            <?php if($ary_prev['3']['3'][0]=='1'){ ?>
										<button type="submit" class="btn btn-primary" id="but_save" name="but" value="save">
											Save
										</button>
                                                                            <?php }?>
										<p><?php print $msg?></p>
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
checkUserPopUp('<?php print $_SESSION['UID']?>');
// DO NOT REMOVE : GLOBAL FUNCTIONS!

<?php 
if($close){
	print "window.parent.location.reload();";
	print "window.parent.$.jeegoopopup.close();";
}
?>
$(document).ready(function() {
    
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
            minLength:1,
            select: function(event,ui){			
                    var id = ui.item.id;
                    if(id != '') {
                        $('#prd_model_id').val(id);
                    }
            }
    });
    $('#prd_manufacturer').autocomplete({
            source: '../json/get_make',
            minLength:1,
            select: function(event,ui){			
                    var id = ui.item.id;
                    if(id != '') {
                        $('#prd_manufacturer_id').val(id);
                    }
            }
    });
    

	var $registerForm = $("#ven_add").validate({

		// Rules for form validation
		rules : {
			v_name : {
				required : true
			}
		},

		// Messages for form validation
		messages : {
			v_name : {
				required : 'Please enter vendor name'
			}
		},

		// Do not change code below
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		}
	});
});

</script>