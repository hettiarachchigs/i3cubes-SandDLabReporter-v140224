<?php
session_start();
//print_r($_SESSION);
$ary_prev=$_SESSION['USER_PREV'];

//print_r($_SESSION);
//initilize the page
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "User-Add";

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

include_once '../class/user.php';
include_once '../class/employee.php';
include_once '../class/functions.php';

$us=new user(1);
$emp=new employee(1);
$fn=new functions();

$user_id=$_REQUEST['UID'];

if($_POST['but']=='save'){
	//add emp first
	//print_r($_POST);
    $emp_id=$emp->addEmployee($_POST['emp_name'], $_POST['emp_address'], $_POST['emp_nic'], $_POST['emp_contact'], $_POST['emp_mobile'], $_POST['emp_email'], $_POST['emp-Designation'], '', $_POST['note'],"");
    if($emp_id){
        $res_user=$us->addUser($_POST['usr_username'], $_POST['usr_psw'], $_POST['usr_role'], $emp_id);
    }
    else{
        $res_user=false;
	}
	
    if($res_user){
            $close=true;
    }
    else {
            $close=false;
            $msg="User could not be added, please contact administrator";
    }
}

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">

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
					<div class="jarviswidget" id="wid-id-71" 
						data-widget-deletebutton="false" 
						data-widget-togglebutton="false"
						data-widget-editbutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-colorbutton="false">
		
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i></span>
							<span style="margin-left: 20px;"><h2>Add User</h2></span>				
							
						</header>
						
						<!-- widget div-->
						<div>
						<div class="widget-body no-padding">
                            <form id="form_add" class="smart-form" method="post" action="<?php echo str_replace('.php','',htmlentities($_SERVER['PHP_SELF']));?>">
							<fieldset>
							<div class="row">
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
										<section class="col-xs-3 col-sm-3 col-md-3">
											<strong>User Name:</strong>
										</section>
										<section class="col-xs-7 col-sm-7 col-md-7">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" name="usr_username" id="usr_username" placeholder="Username" value="">
										</section>	
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
							</div>
							<div class="row">
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
										<section class="col-xs-3 col-sm-3 col-md-3">
											<strong>Password:</strong>
										</section>
										<section class="col-xs-7 col-sm-7 col-md-7">
											<label class="input"> <i class="icon-append fa fa-lock"></i>
												<input type="password" name="usr_psw" placeholder="Password" id="usr_psw">
										</section>	
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
							</div>
							<div class="row">
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
										<section class="col-xs-3 col-sm-3 col-md-3">
											<strong>Confirm Password:</strong>
										</section>
										<section class="col-xs-7 col-sm-7 col-md-7">
											<label class="input"> <i class="icon-append fa fa-lock"></i>
												<input type="password" name="usr_psw_conf" id="usr_psw_conf" placeholder="Confirm password">
										</section>	
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
							</div>
							</fieldset>
										<header>
										Employee Data
										</header>
							<fieldset>
							<div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<strong>Name:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
												<label class="input"><i class="icon-append fa fa-user"></i>
													<input type="text" name="emp_name" id="emp_name" placeholder="Name" value="">
												</label>
											</section>	
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
							</div>
							<div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<strong>NIC:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
												<label class="input"><i class="icon-append fa fa-star"></i>
													<input type="text" name="emp_nic" id="emp_nic" placeholder="NIC" value="">
												</label>
											</section>	
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
							</div>
							<div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<strong>Mobile:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
												<label class="input"><i class="icon-append fa fa-phone"></i>
													<input type="text" name="emp_mobile" id="emp_mobile" placeholder="Mobile" value="">
												</label>
											</section>	
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
							</div>
							<div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<strong>Contact:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
												<label class="input"><i class="icon-append fa fa-phone"></i>
													<input type="text" name="emp_contact" id="emp_contact" placeholder="Contact" value="">
												</label>
											</section>	
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
							</div>
                            <div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<strong>Email:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
												<label class="input"><i class="icon-append fa fa-globe"></i>
													<input type="text" name="emp_email" id="emp_email" placeholder="Email" value="">
												</label>
											</section>	
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
							</div>
							<div class="row">
											<section class="col-xs-1 col-sm-1 col-md-1">
											</section>
											<section class="col-xs-3 col-sm-3 col-md-3">
												<strong>Designation:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
												
												<label class="select">													
													<select name="emp_designation" id="emp_designation">
													<option value="0" selected="" disabled="">Select Designation</option>
													<?php 
														print $fn->CreateMenu('designation','Designation','',$emp->designationID,'','ID','');
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
												<strong>User role:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
												
												<label class="select">													
													<select name="usr_role" id="usr_role">
													<option value="0" selected="" disabled="">Select Role</option>
													<?php 
														print $fn->CreateMenu('usr_role','name','',$us->user_role_id,'','ID','');
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
												<strong>Address:</strong>
											</section>
											<section class="col-xs-7 col-sm-7 col-md-7">
												<label class="textarea"> <i class="icon-append fa fa-map-marker"></i>  										
													<textarea rows="2" name="emp_address" id="emp_address" placeholder="Address"></textarea> 
												</label>
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
												<label class="textarea"> <i class="icon-append fa"></i>  										
													<textarea rows="2" name="note" id="note" placeholder="Note"></textarea> 
												</label>
											</section>
							</div>
							
							<footer>
										<button type="submit" class="" name="but" id="but" value=""></button>
										<section class="col-xs-1 col-sm-1 col-md-1">
										</section>
										<section class="col-xs-3 col-sm-3 col-md-3">
										<input type="hidden" name="submit_value" id="submit_value" value="">
										<p style="display: none;color: red;" id="msg_prev"><i class="fa-fw fa fa-times"></i>You are not authorized</p>
										</section>
										<section class="col-xs-7 col-sm-7 col-md-7">
										<button type="submit" class="btn btn-primary" name="but" id="but" value="save">Save</button>
										</section>
							
							</footer>
							</fieldset>
							
							</form>
						</div>	
							
						<!-- end widget content -->	
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
					
				<!-- END COL -->		
				</article>
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
else {
	print '$( "#msg_prev" ).html( "'.$msg.'" );';
        print '$( "#msg_prev" ).css("display", "block");';
}
?>
$(document).ready(function() {
	$( "input" ).prop( "disabled", true );
	$( "#but" ).hide();
	$( "#but_delete" ).hide();
	$( "textarea" ).prop( "disabled", true );

	<?php 
		$prev=false;
		//
		if($ary_prev[2][0]=='6'){//add
			print '$( "input" ).prop( "disabled", false );';
			print '$( "#but" ).show();';
			print '$( "textarea" ).prop( "disabled", false );';
			$prev=true;
		}
		else{
			print '$( "#msg_prev" ).css("display", "block");';
		}
	?>
	
        var $registerForm = $("#form_add").validate({

		// Rules for form validation
		rules : {
			usr_username : {
				required : true
			},
			usr_psw : {
				minlength : 3,
				maxlength : 20
			},
			usr_psw_conf : {
				minlength : 3,
				maxlength : 20,
				equalTo : '#usr_psw'
			}
		},

		// Messages for form validation
		messages : {
			usr_username : {
				required : 'Please enter your user name'
			},
			usr_username : {
				required : 'Please enter your email address',
				email : 'Please enter a VALID email address'
			},
			usr_psw : {
				required : 'Please enter your password'
			},
			usr_psw_conf : {
				required : 'Please enter your password one more time',
				equalTo : 'Please enter the same password as above'
			}
		},

		// Do not change code below
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		}
	});
});

</script>