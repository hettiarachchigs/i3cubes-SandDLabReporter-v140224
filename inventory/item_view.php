<?php

session_start();

//print_r($_SESSION);
//initilize the page
require_once ("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Parts";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["sample"]["sub"]["item"]["active"] = true;
include("../inc/nav.php");

/*
 * ===== LOGIC =========*
 * 
 */
include_once '../class/product.php';
include_once '../class/productManager.php';


//$prev=$us->getPreviledges($_SESSION['UID']);
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		//$breadcrumbs["Forms"] = "";
		//include("inc/ribbon.php");
	?>

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
					<div class="jarviswidget" id="wid-id-14"
						data-widget-deletebutton="false" 
						data-widget-togglebutton="false"
						data-widget-editbutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-colorbutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i></span>
							<h2>Items</h2>	
							<span id="span_product_head_lnk" class="span_head_lnk"><a class="btn btn-primary btn-xs" href="javascript:void(0);">add new</a></span>			
							
						</header>

						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							<div class="widget-body no-padding">
								<?php
								$item=new \product();
								$item_mgr=new productManager();
                                                                $ary_items=$item_mgr->getAllProducts();
								
								//print_r($ary_user);
								if(count($ary_items)> 0) {
								   	echo "<table id='t_raw_search' class='table table-bordered table-hover' width='100%' >
											   <thead>
									           <tr>	   
									           <th data-hide='phone'>#</th>
									           <th data-hide='phone'>Name</th>
									           <th data-hide='phone'>Code</th>
                                                                                    <th data-hide='phone'>Remarks</th>
                                                                                    <th data-hide='phone'>Unuts</th>
									           </tr>
											   </thead>";
										$i=1;
										print '<tbody>';
						           		foreach ($ary_items as $item){   //Creates a loop to loop through results
						           			
						               		echo "
								               <tr id=".'"'.$item->id.'" class="ngs-popup '.$flg.'"'.">	  
								               <td>" . $i . "</td>
								               <td>" . $item->name . "</td>
								               <td>" . $item->code . "</td>
								               <td>" . $item->remarks . "</td>
                                                                                <td>" . $item->units_name ."</td>
								               </tr>";
						               		$i++;
						           		} 
										print '</tbody>
												</table>';
						       	}
						
							?>				
								
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


<script type="../text/javascript" src="jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
<link href="../jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
<link href="../jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />
<script type="text/javascript">
checkUser('<?php print $_SESSION['UID']?>');

$(document).ready(function() {
	$('#span_product_head_lnk').click(function(){
		add_product();
	});
	$('.ngs-popup').click(function() {
		edit_product(this.id);
	});

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
		var responsiveHelper_datatable_ft = undefined;
		
		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

	/* TABLETOOLS */
	$('#t_raw_search').dataTable({
            responsive: true,
            dom: "<'dt-toolbar '<'col-sm-6 col-xs-12 hidden-xs' B><'col-sm-6 col-xs-12' f>>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",

            buttons: [

                {extend: 'csv'},
                {extend: 'excel', title: 'Fault Ticket'},
                {extend: 'pdf', title: 'Fault Ticket'},

                {extend: 'print',
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '15px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    }
                }
            ]
	});
	
	/* END TABLETOOLS */

});

function add_product(){
	var options = {
	url: 'item_add_edit?<?php print SID."&"?>',
	width: '600',
	height: '500',
	skinClass: 'jg_popup_round'
	};		
	$.jeegoopopup.open(options);		
}
function edit_product(sid){
	var options = {
	url: 'item_add_edit?<?php print SID."&"?>item_id='+sid,
	width: '600',
	height: '500',
	skinClass: 'jg_popup_round'
	};		
	$.jeegoopopup.open(options);		
}
</script>