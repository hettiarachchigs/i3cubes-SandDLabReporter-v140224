<?php //initilize the page
session_start();
require_once ("/lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once ("/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

 YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
 E.G. $page_title = "Custom Title" */

$page_title = "Inbox";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include ("/inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["inbox"]["active"] = true;
include ("/inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">

	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["Tables"] = "";
		include("/inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
	<div id="content">		
		<!-- widget grid -->
		<section id="widget-grid" class="">
		
			<!-- row -->
			<div class="row">
		
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- end widget -->
		
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3"
					 	data-widget-deletebutton="false" 
						data-widget-togglebutton="false"
						data-widget-editbutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-colorbutton="false">
						
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>Inbox</h2>
		
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
			include_once 'class/cls_fault_ticket.php';
			include_once 'class/cls_job_order.php';
			
			$ary_bkp_ids=$emp->getEmpID_BackingUpBy($_SESSION['EMPID']);			
			$ft=new fault_ticket();		  
			$jo=new job_order();
			
			$ary_items=array();
			print_r($ary_bkp_ids);
			foreach ($ary_bkp_ids as $id){
				$ary_tkt=$ft->getTickets($id);
 				$ary_jo=$jo->getJobOrders($id);
 				$ary_items_id=array_merge($ary_tkt,$ary_jo);
 				$ary_items=array_merge($ary_items,$ary_items_id);
			}
       		if(count($ary_items)> 0) {
		   		echo "
						<table id='datatable_tabletools' class='table table-bordered table-hover' width='100%' >
					   <thead>
			           <tr>	   
			           <th data-hide='phone'>#</th>
			           <th data-hide='phone'>Type&emsp;</th>
			           <th data-hide='phone'>Ref Noe&emsp;</th>
					   <th data-hide='phone'>Customer&emsp;</th>
					   <th data-hide='phone'>Open Date&emsp;</th>
					   <th data-hide='phone'>Equipment&emsp;</th>
					   <th data-hide='phone'>Fault/Job;</th>
					   <th data-hide='phone'>Description&emsp;</th>
					   <th data-hide='phone'>Note&emsp;</th>
			           </tr>
					   </thead>";
				$i=1;
           		foreach ($ary_jo as $row){   //Creates a loop to loop through results
           			if($row['Status']=='OPEN'){
           				$flg='open_tkt';
           			}
           			elseif ($row['Status']=='CLOSE'){
           				$flg='close_tkt';
           			}
           			else {
           				$flg='cancel_tkt';
           			}
               		echo "
		               <tr id=".'"'.$row['ID'].'" class="ngs-popup-jo '.$flg.'"'.">
		               <td>" . $i . "</td>
		               <td>Job Order</td>
		               <td>" . $row['ReferenceNo']  . "</td>
					   <td>" . $row['CustomerName'] . "</td>
					   <td>" . $row['OpenDate'] . "</td>
					   <td></td>
					   <td>" . $row['JobName'] . "</td>
					   <td>" . $row['Description'] . "</td>
					   <td>" . $row['Note'] . "</td>
		               </tr>";
               		$i++;
           		} 
       			foreach ($ary_tkt as $row){   //Creates a loop to loop through results
           			if($row['Status']=='OPEN'){
           				$flg='open_tkt';
           			}
           			elseif ($row['Status']=='CLOSE'){
           				$flg='close_tkt';
           			}
           			else {
           				$flg='cancel_tkt';
           			}
               		echo "
		               <tr id=".'"'.$row['ID'].'" class="ngs-popup-ft '.$flg.'"'.">
		               <td>" . $i . "</td>
		               <td>Fault Ticket</td>
		               <td>" . $row['ReferenceNo']  . "</td>
					   <td>" . $row['BranchName'] . "</td>
					   <td>" . $row['OpenDate'] . "</td>
					   <td>" . $row['Make']."[".$row['Model']."]" . "</td>
					   <td>" . $row['Fault'] . "</td>
					   <td>" . $row['Description'] . "</td>
					   <td>" . $row['Note'] . "</td>
		               </tr>";
               		$i++;
           		}
		
       	}
?>
									</thead>
									<tbody>
									<!--If You need add this to customer search table ID it will shows filter option

									<table id='datatable_col_reorder' class='table table-striped table-bordered table-hover' width='100%'>-->






									</tbody>
								</table>

<script type="text/javascript">
/*NGS addings*/
$('.ngs-popup-ft').click(function() {
	var url='ft_edit_e.php?tid='+this.id;
	var NWin = window.open(url,'_blank');
	     if (window.focus)
	     {
	       NWin.focus();
	     }
});
$('.ngs-popup-jo').click(function() {
	var url='jo_edit_e.php?joid='+this.id;
	var NWin = window.open(url,'_blank');
	     if (window.focus)
	     {
	       NWin.focus();
	     }
});
</script>

							<?php 
							if(count($ary_items)==0) {
								print '<div class="alert alert-info fade in">
											<i class="fa-fw fa fa-info"></i>
   											No Tickets/Jobs in your inbox.
										</div>';
							}
							?>
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
<?php // include page footer
include ("/inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php //include required scripts
include ("/inc/scripts.php");
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
})

</script>

<?php
//include footer
include ("/inc/google-analytics.php");
?>