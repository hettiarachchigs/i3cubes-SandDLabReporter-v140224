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

$page_title = "Tests-Add";

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

include_once '../class/tests.php';
include_once '../class/testsManager.php';

$tsts = new tests();
//$fn=new functions();
$testArray = array();

if($_POST['but']=='save'){
//print_r($_POST);
//Array ( [tst_name] => [tst_type] => 1 [tst_apparatus] => [files] => [tst_proced] => [tst_chemical] => [tst_material] => [tst_evaluate] => [tst_done_by] => admin [but] => save ) 	

			$tsts->name = $_POST['tst_name'];
			$tsts->type=$_POST['tst_type'];
			//$tsts->category=$_POST['category'];
			$tsts->doneBy=$_POST['tst_done_by'];
			//$tsts->status=$_POST['status'];
			//$tstsArray->note=$_POST['note'];
			$tsts->apparatus = htmlspecialchars($_POST['tst_apparatus']);
			$tsts->proced = htmlspecialchars($_POST['tst_proced']);
			$tsts->chemical = htmlspecialchars($_POST['tst_chemical']);
			$tsts->material = htmlspecialchars($_POST['tst_material']);
			$tsts->evaluate = htmlspecialchars($_POST['tst_evaluate']); 

			//array_push($testArray, $tsts);
			//print_r($testArray);
            $result = $tsts->addTest();
            if($result){
                $close=true;
            }
            else {
                $close=false;
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
							<span><h2 style="margin-left: 20px;">Add Tests</h2></span>				
							
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
                                                        <input type="text" name="tst_name" id="tst_name" placeholder="Test Name" value=""> 
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
            									<!--<input type="text" name="dobmonth" id="dobm" class="dob" placeholder="month">-->
                                                    <select name="tst_type" id="tst_type">
                                                        <option value="1" selected="">Test Type</option>
                                                        <option value="2">Reactive Soaping Agent</option>
														<option value="3">Hydrogen Peroxide Stability Test(During Steaming)</option>
														<option value="4">Hydrogen Peroxide Stability Test(Exhaus)</option>
														<option value="5">De areation method for wetting agents using the Sulpher dye solution</option>
														<option value="6">Washing off Hydrolyzed reactive Dyes</option>
														<option value="7">Reductive clearing of dyeing on PES in acidec dyebath</option>
														<option value="8">Determination of oil emulsifying capacity</option>
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
												<strong>Date:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
                                                    <p><?php echo date("l jS \of F Y h:i:s A"); ?></p> 
                                                </label>
											</section>
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
										</div>
                                        <div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<strong>Done By:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"></i>
                                                    <?php echo $_SESSION['USERNAME']; ?> 
                                                </label>
											</section>
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
										</div>
										<div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<label><strong>Apparatus:</strong></label>
                                				<textarea id='makeMeSummernote' name='tst_apparatus' class="form-control"></textarea></br></br>
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
											
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
											
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
											<label><strong>Procedure:</strong></label>
                                				<textarea id='makeMeSummernote4' name='tst_proced' class="form-control"></textarea></br></br>
											</section>
										</div>
										<div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<label><strong>Chemicals,Dyes & Auxiliarues:</strong></label>
                                				<textarea id='makeMeSummernote1' name='tst_chemical' class="form-control"></textarea></br></br>
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
										</div>
										<div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<label><strong>Material:</strong></label>
                                				<textarea id='makeMeSummernote2' name='tst_material' class="form-control"></textarea></br></br>
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
										</div>
										<div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<label><strong>Evaluation:</strong></label>
                                				<textarea id='makeMeSummernote3' name='tst_evaluate' class="form-control"></textarea></br></br>
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
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
                                            <input type="hidden" name="tst_done_by" id="tst_done_by" value="<?php echo $_SESSION['USERNAME']; ?>">
                                            <input type="hidden" name="" id="" value="">
                                    <?php //if($ary_prev['3']['3'][0]=='1'){ ?>
										<button type="submit" class="btn btn-primary" id="but_save" name="but" value="save">
											Save
										</button>
                                    <?php //}?>
										<p><?php // print $msg?></p>
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
<link href="../js/summernote-0.8.20/package/dist/summernote-lite.min.css" rel="Stylesheet" type="text/css" />
<script type="../text/javascript" src="../js/summernote-0.8.20/package/dist/summernote-lite.min.js"></script>
<script type="../text/javascript" src="../js/jquery.min.js"></script> 
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

$('#makeMeSummernote').summernote({
            height:200,
			width:180,
        });
$('#makeMeSummernote1').summernote({
            height:200,
			width:180,
});
$('#makeMeSummernote2').summernote({
            height:200,
			width:180,
});
$('#makeMeSummernote3').summernote({
            height:200,
			width:180,
});
$('#makeMeSummernote4').summernote({
            height:200,
			width:400,
});

</script>