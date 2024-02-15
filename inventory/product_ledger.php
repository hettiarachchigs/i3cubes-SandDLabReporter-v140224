<?php
session_start();
//initilize the page

//print_r($_SESSION);
require_once ("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

//require UI configuration (nav, ribbon, etc.)


/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Product Ledger";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["forms"]["sub"]["smart_layout"]["active"] = true;
//include("..inc/nav.php");

// ====================== LOGIC ================== --!>


include_once '../class/cls_system.php';
include_once '../class/cls_stock_manager.php';
$stock_manager = new stock_manager();
include_once '../class/systemModel.php';
include_once '../class/customerEntity.php';
$system_id = $_REQUEST['id'];
$customer_entity_id = $_REQUEST['ent_id'];

$stok_mgr=new stock_manager();
$systems_ledger = $stock_manager->getStockLedger($customer_entity_id,$system_id,$from, $to);
//print_r($systems_ledger);
//$current_balance= $stock_manager->currentStock($system_id);
$systemModel = new systemModel($system_id);
$systemModel->getSystemModels();

$current_stock=$stock_manager->getCustomerStock($customer_entity_id, $system_id);

$cus_entity = new customerEntity($customer_entity_id);
$cus_entity->getData();
//print_r($current_balance);

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
					<div class="jarviswidget" id="w_store_e3"
						data-widget-deletebutton="false" 
						data-widget-togglebutton="false"
						data-widget-editbutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-colorbutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i></span>
							<h2>Stock Ledger Records</h2>				
							
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
								<div class="row" style="padding-top: 10px; padding-bottom: 10px;">
									<section class="col-xs-3 col-sm-3 col-md-3">
										<strong>Customer Name #:</strong>&nbsp;&nbsp;&nbsp;<font class="fnt_lgt_blue"><?php print $cus_entity->name?></font>
									</section>
									
									<section class="col-xs-3 col-sm-3 col-md-3">
										<strong>Product Code:&nbsp;&nbsp;&nbsp;</strong><font class="fnt_lgt_blue"><?php print $systemModel->product_code?></font>
									</section>
                                                                        <section class="col-xs-3 col-sm-3 col-md-3">
										<strong>Description:</strong>&nbsp;&nbsp;&nbsp;<font class="fnt_lgt_blue"><?php print $systemModel->description?></font>
									</section>
                                                                        <section class="col-xs-3 col-sm-3 col-md-3">
										<strong>Stock:</strong>&nbsp;&nbsp;&nbsp;<font class="fnt_lgt_blue"><?php print $current_stock?></font>
									</section>
								</div>					
								<?php 
									//$ary_grn_items=$inv->getInventryRecordsByType('GRN',$grn_id);
									//$ary_ledger=$inv->getProductLedger($prd_id,$_REQUEST['from'],$_REQUEST['to']);
									if(count($systems_ledger)> 0) {
									   	echo "<table id='t_ledger' class='table table-bordered table-hover' width='100%' >
												   <thead>
										           <tr>	   
										           <th data-hide='phone'>#</th>
										           <th data-hide='phone'>TYPE</th>
                                                                                            <th data-hide='phone'>REFERENCE</th>
                                                                                            <th data-hide='phone'>DATE</th>
                                                                                            <th data-hide='phone'>Serial</th>
                                                                                            <th data-hide='phone'>IN</th>
                                                                                            <th data-hide='phone'>OUT</th>
                                                                                            <th data-hide='phone'>FROM</th>
                                                                                            <th data-hide='phone'>TO</th>
										           </tr>
                                                                                            </thead>";
											$i=1;
											print '<tbody>';
							           		foreach ($systems_ledger as $row){   //Creates a loop to loop through results
							           			$qty_in='';
							           			$qty_out='';
							           			$qty_adj='';
                                                                                       
                                                                                     if ($row['reference_to'] == 'STN') {
                                                                                            $type = 'STN';
                                                                                            $ref_no=$row['stn_no'];
                                                                                            $date=$row['srn_date'];
                                                                                            if($row['customer_entity_id_to']==$customer_entity_id){
                                                                                                //IN
                                                                                                $flg = 'tr_lgt_green';
                                                                                                $qty_in = $row['qty'];
                                                                                            }
                                                                                            else{
                                                                                                $flg = 'tr_lgt_orange';                                                                                                
                                                                                                $qty_out = $row['qty'];
                                                                                            }
                                                                                        } else if($row['reference_to'] == 'GRN'){
                                                                                            $ref_no=$row['grn_no'];
                                                                                            $flg = 'tr_lgt_green';
                                                                                            $type = 'GRN';
                                                                                            $qty_in = $row['qty'];
                                                                                            $date=$row['grn_date'];
                                                                                        }
                                                                                        else{
                                                                                            $type = 'N/A';
                                                                                            $flg = 'tr_lgt_orange';
                                                                                            $qty_in = $row['qty'];
                                                                                        }
                                        
							           			echo "
                                                                                                <tr id=".'"'.$row['id'].'" class="'.$flg.'"'.">	  
                                                                                                <td>" . $i . "</td>
                                                                                                <td>" . $type . "</td>
                                                                                                <td>" . $ref_no . "</td>
                                                                                                <td>" . $date. "</td>
                                                                                                <td>" . $row['serial']. "</td>
                                                                                                <td>" . $qty_in. "</td>
                                                                                                <td>" . $qty_out. "</td>
												<td>" . $row['customer_from']. "</td>
                                                                                                <td>" . $row['customer_to']. "</td>
												   
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
<?php
	// include page footer
	include("../inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php 
	//include required scripts
	include("../inc/scripts.php"); 

?>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript" src="jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
<link href="jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
<link href="jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />

<script type="text/javascript">
checkUserPopUpBlank('<?php print $_SESSION['UID']?>');
<?php 
if($close){
	print "window.parent.location.reload(false);";
	print "window.close();";
}
?>
// DO NOT REMOVE : GLOBAL FUNCTIONS!

var del=0;

$(document).ready(function() {
	$("#but_add_part").click(function(){
		window.location.href = "pre_grn_add.php?grn_id=<?php print $grn_id?>";
	});
});

function print_this(){
	window.location.href = "pre_grn_print_view.php?grnid=<?php print $grn_id?>";
}
</script>

<?php 
	//include footer
	//include("/inc/google-analytics.php"); 
?>