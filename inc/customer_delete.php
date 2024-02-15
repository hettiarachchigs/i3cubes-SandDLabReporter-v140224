<?php
session_start();
//initilize the page
require_once("/inc/init.php");

//require UI configuration (nav, ribbon, etc.)


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Add Customer";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("/ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["forms"]["sub"]["smart_layout"]["active"] = true;
//include("../inc/nav.php");

// ====================== LOGIC ================== --!>

include_once '/class/cls_customer.php';
include_once 'class/cls_employee.php';
include_once 'cl';

$cid=$_REQUEST['id'];
$cus=new customer();
if($_POST['but']=='save'){	
	$res=
	$res=$cus->editCUstomer($cid,$_POST['cus_code'],$_POST['cus_name'],$_POST['cus_br'],$_POST['cus_address'],$_POST['cus_phone'],$_POST['cus_cont'],$_POST['cus_note'],$_POST['eq_owner_id']);
	if($res){
		$msg=  "<div class='alert alert-success fade in'>
						<i class='fa-fw fa fa-check'></i>&nbsp;Customer details Changed.
						</div>";
	}
	else{
		$msg="<div class='alert alert-success fade in'>
						<i class='fa-fw fa fa-times'></i>&nbsp;Customer details could not be changed. please contact administrator.
						</div>";
	}
}

$row=$cus->getDetails($cid);

$emp=new employee();
$emp_data=$emp->getDetails($row['Tech_Owner_EmployeeID']);
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="margin-left: 10px;">

	<!-- MAIN CONTENT -->
	<div id="content">


		<div class="row">
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<h1 class="page-title txt-color-blueDark">
					
					<!-- PAGE HEADER -->
					<i class="fa-fw fa fa-user"></i> 
						Customer Details
				</h1>
			</div>
		</div>

		<!--<div class="alert alert-block alert-success">
			<a class="close" data-dismiss="alert" href="#">×</a>
			<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> Check validation!</h4>
			<p>
				You may also check the form validation by clicking on the form action button. Please try and see the results below!
			</p>
		</div>-->

		<!-- widget grid -->
		<section id="widget-grid" class="">


			<!-- START ROW -->

			<div class="row">

				<!-- NEW COL START -->
	
				<!-- END COL -->

				<!-- NEW COL START -->
				<article class="col-sm-12 col-md-12 col-lg-12">
					
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
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
									<header>
										<?php print $msg?>
									</header>
									<fieldset>
										<div class="row">
											<section class="col col-3">
												<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" name="cus_name" id="cus_name" placeholder="Customer Name" value="<?php print $row['Name']?>">
												</label>
												<p class="note">Customer Name</p>
											</section>
											<section class="col col-3">
												<label class="input"><i class="icon-append fa fa-envelope-o"></i>
													<input type="text" name="cus_code" id="cus_code" placeholder="Customer Code" value="<?php print $row['CustomerCode']?>">
												</label>
												<p class="note">Customer Code</p>
											</section>
											<section class="col col-3">
												<label class="input"><i class="icon-append fa fa-globe"></i>
													<input type="text" name="cus_br" id="cus_br" placeholder="Business Registration Number" value="<?php print $row['BR']?>">
												</label>
												<p class="note">Business Registration No</p>
											</section>
											<section class="col col-3">
												<label class="input"> <i class="icon-prepend fa fa-phone"></i>
													<input type="tel" name="cus_phone" id="cus_phone" placeholder="Phone" data-mask="(999) 999-9999" value="<?php print $row['ContactNumber']?>">
												</label>
												<p class="note">Contact Number</p>
											</section>
										</div>
																				
										<div class="row">
											<section class="col col-3">
												<label class="input"> <i class="icon-append fa fa-user"></i>
													<input type="text" name="cus_cont" id="cus_cont" placeholder="Contact Person" value="<?php print $row['ContactPerson']?>">
												</label>
												<p class="note">Contact Person</p>
											</section>
											<section class="col col-3">
												<label class="input"> <i class="icon-append fa fa-eye"></i>
													<input type="text" name="eq_owner" id="eq_owner" placeholder="Tech Owner" value="<?php print $emp_data['Name']?>"> 
													<b class="tooltip tooltip-bottom-right">Technical Owner of Equipment</b>
												</label><p class="note">Technical Owner</p>
											</section>
										
											<section class="col col-3">
												<label class="textarea"><i class="icon-append fa fa-comment"></i> 	  										
													<textarea rows="3" name="cus_address" id="cus_address" placeholder="Customer Address"><?php print $row['Address']?></textarea> 
												</label>
												<p class="note">Address</p>
											</section>
											<section class="col col-3">
												<label class="textarea"><i class="icon-append fa fa-comment"></i> 	  										
													<textarea rows="3" name="cus_note" id="cus_note" placeholder="Note"><?php print $row['Note']?></textarea> 
												</label>
												<p class="note">Note</p>
											</section>
										</div>
										<!--<section>
											<label class="checkbox">
												<input type="checkbox" name="subscription" id="subscription">
												<i></i>I want to receive news and special offers</label>
											<label class="checkbox">
												<input type="checkbox" name="terms" id="terms">
												<i></i>I agree with the Terms and Conditions</label>
										</section>-->
									</fieldset>
									<footer>
										<div class="row">
										<section class="col col-6">
												<div class="alert alert-danger fade in" style="display: none;" id="warning_delete">
													<i class="fa-fw fa fa-times"></i>
													<strong>Warning!</strong>All Branches will be deleted with Customer. To confirm press Delete again.														
												</div>
												
											</section>
											<section class="col col-6">
												<button type="submit" class="btn btn-primary" id="but" name="but" value="save">
													Save
												</button>										
												<button type="button" class="btn btn-primary" id="but_delete" name="but_delete">
													Delete
												</button>
												<button type="button" class="btn btn-primary" id="add_br" name="add_br">
													Add Branch
												</button>
												<?php 
													if($_SESSION['UL']!='1'){
														print '<p><font color="red"><i class="fa-fw fa fa-times"></i>You cannot edit this record</font></p>';
													}
												?>
											</section>
										</div>
									</footer>
									<input type="hidden" name="eq_owner_id" id="eq_owner_id" value="<?php print $row['Tech_Owner_EmployeeID']?>">
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
		
		<!-- widget grid -->
		<section id="widget-grid" class="">
		
			<!-- row -->
			<div class="row">
		
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- end widget -->
		
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false">
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
							<h2>Branches</h2>
		
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
			include_once '/class/cls_dbHandler.php';
			$dbh=new dbHandler();		  
 			$str = "SELECT BranchID ,BranchCode,Name,Address,ContactNumber,ContactPerson FROM branch WHERE CustomerID='$cid' AND Deleted='N''';";
 			$result=$dbh->dbQuery($str);
       		if($dbh->dbNumRows($result) > 0) {
		   		echo "
						<table id='datatable_tabletools' class='table table-striped table-bordered table-hover' width='100%' >
					   <thead>
			           <tr>	   
			           <th data-hide='phone'>ID</th>
			           <th data-hide='phone'>Branch Code&emsp;</th>
			           <th data-hide='phone'>Branch Name&emsp;</th>
					   <th data-hide='phone'>Address&emsp;</th>
					   <th data-hide='phone'>Contact Number&emsp;</th>
					   <th data-hide='phone'>Contact Person&emsp;</th>
			           </tr>
					   </thead>";

		   		$i=1;
           		while($row = $dbh->dbFetchAssoc($result)){   //Creates a loop to loop through results
           			if($row['BranchCode']=='D00'){
           				$i_ext='<span class="label label-primary">Default</span>';
           				$i_name='<span class="label label-primary">Default(HQ)</span>';
           			}
           			else {
           				$i_ext='';
           				$i_name='';
           			}
               		echo "
		               <tr id=".'"'.$row['BranchID'].'" class="ngs-popup"'.">	  
		               <td>" . $i .$i_ext. "</td>
		               <td>" . $row['BranchCode']  . "</td>
		               <td>" . $row['Name'] .$i_name. "</td>
					   <td>" . $row['Address'] . "</td>
					   <td>" . $row['ContactNumber'] . "</td>
					   <td>" . $row['ContactPerson'] . "</td>
		               </tr>";
               		$i++;
           		} 
		
       	}
?>
<script type="text/javascript">
$('.ngs-popup').click(function() {
	var url='branch_edit.php?id='+this.id;
	var BRin = window.open(url, '', 'height=800,width=800');
	     if (window.focus)
	     {
	       BRin.focus();
	     }
});
</script>								</thead>
									<tbody>
									<!--If You need add this to customer search table ID it will shows filter option

									<table id='datatable_col_reorder' class='table table-striped table-bordered table-hover' width='100%'>-->






									</tbody>
								</table>
		
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
		<!-- end widget grid -->
	

	</div>
	<!-- END MAIN CONTENT -->
	

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
	// include page footer
	include("/inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php 
	//include required scripts
	include("/inc/scripts.php"); 
?>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript">

// DO NOT REMOVE : GLOBAL FUNCTIONS!

$(document).ready(function() {
	
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
			tablet : 1024,
			phone : 480
		};

		$('#dt_basic').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});

	/* END BASIC */
	
	/* COLUMN FILTER  */
    var otable = $('#datatable_fixed_column').DataTable({
    	//"bFilter": false,
    	//"bInfo": false,
    	//"bLengthChange": false
    	//"bAutoWidth": false,
    	//"bPaginate": false,
    	//"bStateSave": true // saves sort state using localStorage
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_fixed_column) {
				responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_fixed_column.respond();
		}		
	
    });
    
    // custom toolbar
    $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');
    	   
    // Apply the filter
    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {
    	
        otable
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
            
    } );
    /* END COLUMN FILTER */   

	/* COLUMN SHOW - HIDE */
	$('#datatable_col_reorder').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_col_reorder) {
				responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_col_reorder.respond();
		}			
	});
	
	/* END COLUMN SHOW - HIDE */

	/* TABLETOOLS */
	$('#datatable_tabletools').dataTable({
		
		// Tabletools options: 
		//   https://datatables.net/extensions/tabletools/button_options
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "oTableTools": {
        	 "aButtons": [
             "copy",
             "csv",
             "xls",
                {
                    "sExtends": "pdf",
                    "sTitle": "SmartAdmin_PDF",
                    "sPdfMessage": "SmartAdmin PDF Export",
                    "sPdfSize": "letter"
                },
             	{
                	"sExtends": "print",
                	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
            	}
             ],
            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
        },
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_tabletools) {
				responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_tabletools.respond();
		}
	});
	
	/* END TABLETOOLS */

	/*NGS addings*/

	var del=0;
	$('#add_br').click(function() {
		var url='branch_add.php?id=<?php print $cid?>';
		var BRin = window.open(url, '', 'height=800,width=800');
		     if (window.focus)
		     {
		       BRin.focus();
		     }
	});
	$('#but_delete').click(function() {
		if(del==0){
			$("#warning_delete").css("display", "block");
			$('#but_delete').text("Confirm Delete");
			del=1;
		}
		else{
			alert("xxxx");
		}
	});

	$('#eq_owner').autocomplete({
		source: 'json/get_employee.php',
		minLength:1,
		select: function(event,ui){			
			var id = ui.item.id;
			if(id != '') {
				$('#eq_owner_id').val(id);
			}
		},
    });
    
	<?php 
		if ($_SESSION['UL']!='1'){
			print '$( "input" ).prop( "disabled", true );';
			print '$( "#but" ).prop( "disabled", true );';
			print '$( "select" ).prop( "disabled", true );';
			print '$( "#add_br" ).prop( "disabled", true );';
		}
	?>
	
})

</script>

<?php 
	//include footer
	include("/inc/google-analytics.php"); 
?>