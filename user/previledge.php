<?php
session_start();

$ary_prev=$_SESSION['USER_PREV'];

//print_r($_SESSION);
//initilize the page
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "User-Previledge";

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

$uid=$_REQUEST['UID'];
$us=new user($uid);
$emp=new employee();
$fn=new functions();

if($_POST['but']=='save'){
        $ary_prev=array();
        isset($_POST['m_ft'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['ft_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['ft_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['ft_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        isset($_POST['ft_cancel'])?$ary_prev[4]='1':$ary_prev[4]='0';
        isset($_POST['ft_close'])?$ary_prev[5]='1':$ary_prev[5]='0';
        isset($_POST['ft_admin_close'])?$ary_prev[6]='1':$ary_prev[6]='0';
        isset($_POST['ft_reopen'])?$ary_prev[7]='1':$ary_prev[7]='0';
	$res=$us->setPreviledges(3, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_sv'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['sv_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['sv_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['sv_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        isset($_POST['sv_cancel'])?$ary_prev[4]='1':$ary_prev[4]='0';
        isset($_POST['sv_close'])?$ary_prev[5]='1':$ary_prev[5]='0';
        $res=$us->setPreviledges(7, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_ro'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['ro_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['ro_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['ro_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        isset($_POST['ro_cancel'])?$ary_prev[4]='1':$ary_prev[4]='0';
        isset($_POST['ro_close'])?$ary_prev[5]='1':$ary_prev[5]='0';
        $res=$us->setPreviledges(8, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_cus'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['cus_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['cus_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['cus_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        $res=$us->setPreviledges(1, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_ven'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['ven_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['ven_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['ven_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        $res=$us->setPreviledges(10, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_amc'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['amc_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['amc_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['amc_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        $res=$us->setPreviledges(4, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_user'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['user_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['user_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['user_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        $res=$us->setPreviledges(2, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_sys'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['sys_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['sys_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['sys_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        $res=$us->setPreviledges(5, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_eq'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['eq_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['eq_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['eq_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        isset($_POST['eq_reopen'])?$ary_prev[4]='1':$ary_prev[3]='0';
        $res=$us->setPreviledges(6, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_fb'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['fb_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['fb_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['fb_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        $res=$us->setPreviledges(9, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_ft_stn'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['ft_stn_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['ft_stn_edit'])?$ary_prev[2]='0':$ary_prev[2]='0';
        isset($_POST['ft_stn_delete'])?$ary_prev[3]='0':$ary_prev[3]='0';
        $res=$us->setPreviledges(11, $ary_prev);
        
        $ary_prev=array();
        isset($_POST['m_ft_grn'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['ft_grn_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['ft_grn_edit'])?$ary_prev[2]='0':$ary_prev[2]='0';
        isset($_POST['ft_grn_delete'])?$ary_prev[3]='0':$ary_prev[3]='0';
        $res=$us->setPreviledges(12, $ary_prev);
        
        //expenses
        $ary_prev=array();
        isset($_POST['m_exp'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['exp_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['exp_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['exp_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        isset($_POST['exp_cancel'])?$ary_prev[4]='1':$ary_prev[4]='0';
        isset($_POST['exp_close'])?$ary_prev[5]='1':$ary_prev[5]='0';
        //isset($_POST['exp_admin_close'])?$ary_prev[6]='1':$ary_prev[6]='0';
	$res=$us->setPreviledges(13, $ary_prev);
        //payment voucher
        $ary_prev=array();
        isset($_POST['m_pay'])?$ary_prev[0]='1':$ary_prev[0]='0';
        isset($_POST['pay_add'])?$ary_prev[1]='1':$ary_prev[1]='0';
        isset($_POST['pay_edit'])?$ary_prev[2]='1':$ary_prev[2]='0';
        isset($_POST['pay_delete'])?$ary_prev[3]='1':$ary_prev[3]='0';
        isset($_POST['pay_cancel'])?$ary_prev[4]='0':$ary_prev[4]='0';
        isset($_POST['pay_close'])?$ary_prev[5]='0':$ary_prev[5]='0';
	$res=$us->setPreviledges(16, $ary_prev);
        $res_usr=$res;
	if($res_usr){
		//$close=true;
            $msg="<font color='green'>User previledges changed.</font>";
	}
	else {
		//$close=false;
		$msg="<font class='err'>User previledges could not be changed, please contact administrator</font>";
	}
}

$us->getUser();
$row_prev=$us->getPreviledges();

//print_r($row_prev);
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
					<div class="jarviswidget" id="wid-id-74" 
						data-widget-deletebutton="false" 
						data-widget-togglebutton="false"
						data-widget-editbutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-colorbutton="false">
		
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i></span>
							<span style="margin-left: 20px;"><h2>User Menu and previledges</h2></span>				
							
						</header>
						
						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							<div class="widget-body no-padding">
                                                            <form id="form_prev" class="smart-form" method="post" action="<?php echo str_replace('.php','',htmlentities($_SERVER['PHP_SELF']));?>">

									<fieldset>
									<div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <strong>Menu</strong>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    Add
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    Edit
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    Delete
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    Cancel
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    Close
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    admin-close
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    re-open
										</section>
									</div>
									</fieldset>
									<div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_ft" <?php if($row_prev[3][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Fault Ticket
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ft_add" <?php if($row_prev[3][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ft_edit" <?php if($row_prev[3][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ft_delete" <?php if($row_prev[3][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ft_cancel" <?php if($row_prev[3][4]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ft_close" <?php if($row_prev[3][5]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ft_admin_close" <?php if($row_prev[3][6]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ft_reopen" <?php if($row_prev[3][7]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
									</div>
                                                                <div  style="display: none;" class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-5 col-sm-5 col-md-">
                                                                                    <label class="checkbox ">
                                                                                        Service Order
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="sv_edit" <?php if($row_prev[7][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="sv_delete" <?php if($row_prev[7][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="sv_cancel" <?php if($row_prev[7][4]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="sv_close" <?php if($row_prev[7][5]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
									</div>
                                                                        <div style="" class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_ro" <?php if($row_prev[8][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Repaire Order
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ro_add" <?php if($row_prev[8][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ro_edit" <?php if($row_prev[8][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ro_delete" <?php if($row_prev[8][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ro_cancel" <?php if($row_prev[8][4]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ro_close" <?php if($row_prev[8][5]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
									</div>
                                                                        <div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_cus" <?php if($row_prev[1][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Customer
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="cus_add" <?php if($row_prev[1][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="cus_edit" <?php if($row_prev[1][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="cus_delete" <?php if($row_prev[1][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
									</div>
                                                                        <div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_ven" <?php if($row_prev[10][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Vendor
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ven_add" <?php if($row_prev[10][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ven_edit" <?php if($row_prev[10][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ven_delete" <?php if($row_prev[10][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
									</div>
                                                                        <div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                   <label class="checkbox ">
                                                                                        <input class="" name="m_eq" <?php if($row_prev[6][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Inventory
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="eq_add" <?php if($row_prev[6][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="eq_edit" <?php if($row_prev[6][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="eq_delete" <?php if($row_prev[6][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="eq_reopen" <?php if($row_prev[6][4]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
									</div>
                                                                <div style="display: none;" class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_fb" <?php if($row_prev[9][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Feedback
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="fb_add" <?php if($row_prev[9][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="fb_edit" <?php if($row_prev[9][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="fb_delete" <?php if($row_prev[9][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
									</div>
                                                                        <div style="display: none;" class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_amc" <?php if($row_prev[4][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Contract (AMC/Warr)
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="amc_add" <?php if($row_prev[4][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="amc_edit" <?php if($row_prev[4][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="amc_delete" <?php if($row_prev[4][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
									</div>
                                                                        <div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_user" <?php if($row_prev[2][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>User
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="user_add" <?php if($row_prev[2][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="user_edit" <?php if($row_prev[2][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="user_delete" <?php if($row_prev[2][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
									</div>
                                                                        <div style="display: none;" class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_sys" <?php if($row_prev[5][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>System Data
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="sys_add" <?php if($row_prev[5][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="sys_edit" <?php if($row_prev[5][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="sys_delete" <?php if($row_prev[5][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
									</div>
                                                                        <div style="" class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_ft_stn" <?php if($row_prev[11][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Fault Ticket STN
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ft_stn_add" <?php if($row_prev[11][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
									</div>
                                                                        <div style="" class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_ft_grn" <?php if($row_prev[12][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Fault Ticket GRN
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="ft_grn_add" <?php if($row_prev[12][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
									</div>
                                                                <div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_exp" <?php if($row_prev[13][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Expenses
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="exp_add" <?php if($row_prev[13][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="exp_edit" <?php if($row_prev[13][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="exp_delete" <?php if($row_prev[13][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="exp_cancel" <?php if($row_prev[13][4]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="exp_close" <?php if($row_prev[13][5]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1 hidden">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="exp_admin_close" <?php if($row_prev[13][6]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
									</div>
                                                                <div class="row">
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">                                                                                    
										</section>
										<section class="col-xs-4 col-sm-4 col-md-4">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="m_pay" <?php if($row_prev[16][0]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>Payment Voucher
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="pay_add" <?php if($row_prev[16][1]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
										<section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="pay_edit" <?php if($row_prev[16][2]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" name="pay_delete" <?php if($row_prev[16][3]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
<!--                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" disabled="disabled" name="exp_cancel" <?php if($row_prev[16][4]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>
                                                                                <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <label class="checkbox ">
                                                                                        <input class="" disabled="disabled" name="exp_close" <?php if($row_prev[16][5]=='1'){print 'checked';}?> value="Y" type="checkbox"><i></i>
                                                                                    </label>
										</section>-->
									</div>
										
										<input type="hidden" name="UID" id="UID" value="<?php print $us->id?>">
										<input type="hidden" name="submit_value" id="submit_value" value="">
									<footer>
										<button type="submit" class="btn btn-primary" name="but" id="but" value="save">
											Save
										</button>
										
                                                                            <p style="display: none;" id="msg_prev"><i class="fa-fw fa fa-times"></i><font class="err">You are not authorized</font></p>
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
else {
	print '$( "#msg_prev" ).html( "'.$msg.'" );';
        print '$( "#msg_prev" ).css("display", "block");';
}
?>
$(document).ready(function() {
	$( "input" ).prop( "disabled", true );
	$( "#but" ).hide();

	<?php 
		$prev=false;
		if($ary_prev[2][2]=='1'){//edit
			print '$( "input" ).prop( "disabled", false );';
			print '$( "#but" ).show();';
			$prev=true;
		}
		if(!$prev){
			print '$( "#msg_prev" ).css("display", "block");';
		}
	?>
});

</script>