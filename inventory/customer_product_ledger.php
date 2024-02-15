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

$system_id = $_REQUEST['id'];

/*$inv=new inventry();
$prd=new product();
$stn=new stn();
$grn=new grn();

$prd_id=$_REQUEST['prdid'];


$prd_data=$prd->getProductData($prd_id);

$ary_stock=$inv->getStock($prd_id);
$ary_reserved=$inv->getReserved($prd_id);*/
//print_r($ary_stock);
$systems = new system();
//$systems_ledger = $systems->getledger($system_id, $from, $to);
//print_r($systems_ledger);
//$current_balance= $stock_manager->currentStock($system_id);
$systemModel = new systemModel($system_id);
$systemModel->getSystemModels();

$ary_stock=$stock_manager->stockbalance($system_id);

//print_r($ary_stock);
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
                                <div style="display: flex;flex-direction: column;
    align-items: center;">
				<article class="col-sm-8 col-md-8 col-lg-8">
					
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="w_store_e3"
						data-widget-deletebutton="false" 
						data-widget-togglebutton="false"
						data-widget-editbutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-colorbutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i></span>
							<h2>Location Product Stock</h2>				
							
						</header>

						<!-- widget div-->
                                                <div style="">
							
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
								
							</div>
							<!-- end widget edit box -->
							
							<!-- widget content -->
							<div class="widget-body no-padding">	
								<div class="row" style="padding-top: 10px; padding-bottom: 10px;">
									<section class="col-xs-6 col-sm-6 col-md-6">
										<strong>Product Code #:</strong>&nbsp;&nbsp;&nbsp;<font class="fnt_lgt_blue"><?php print $systemModel->product_code?></font>
									</section>
									<section class="col-xs-3 col-sm-3 col-md-5">
										<strong>Description:</strong>&nbsp;&nbsp;&nbsp;<font class="fnt_lgt_blue"><?php print $systemModel->description?></font>
									</section>
<!--									<section class="col-xs-4 col-sm-4 col-md-4">
										<strong>Current Stock:&nbsp;&nbsp;&nbsp;</strong> <?php print '<font class="fnt_lgt_blue">'.$current_balance['balance'].'</font>'?>
									</section>-->
								</div>					
								<?php 
									//$ary_grn_items=$inv->getInventryRecordsByType('GRN',$grn_id);
									//$ary_ledger=$inv->getProductLedger($prd_id,$_REQUEST['from'],$_REQUEST['to']);
									if(count($ary_stock)> 0) {
									   	echo "<table id='t_ledger' class='table table-bordered table-hover' width='100%' >
												   <thead>
										           <tr>	   
										           <th data-hide='phone'>#</th>
										           <th data-hide='phone'>Customer Name</th>
												   <th data-hide='phone'>Qty</th>
												   
												   
										           </tr>
												   </thead>";
											$i=1;
											print '<tbody>';
							           		foreach ($ary_stock as $row){   //Creates a loop to loop through results
							           			$qty_in='';
							           			$qty_issue='';
							           			$qty_adj='';
                                                                                       
                                                                                     
                                                                                        $ref_no = $row['ref_no'];
                                        /*if($row['TransactionType']=='GRN'){
							               			$reference=$row['GRN'];
							               			$qty_in=$row['Qty'];
							               		}
							               		elseif ($row['TransactionType']=='STN'){
							               			$reference=$row['STN'];
							               			if($row['Direction']=='IN'){
							               				$qty_in=$row['Qty'];
							               			}
							               			else {
							               				$qty_issue=$row['Qty'];
							               			}
							               		}
							               		elseif ($row['TransactionType']=='JO'){
							               			$reference=$row['RefID'];
							               			if($row['Direction']=='IN'){
							               				$qty_in=$row['Qty'];
							               			}
							               			else {
							               				$qty_issue=$row['Qty'];
							               			}
							               		}
							               		elseif ($row['TransactionType']=='ADJ'){
							               			$reference=$row['ADJ'];
							               			$qty_adj=$row['Qty'];
							               		}
							               		else {
							               			
							               		}
							               		if($row['Direction']=='IN'){
							               			$flg='tr_lgt_green';
							               		}
							               		else {
							               			$flg='tr_lgt_orange';
							               		}*/
							           			echo "
									               <tr id=".'"'.$row['customer_entity_id'].'" class="ngs-popup '.$flg.'"'.">	  
									               <td>" . $i . "</td>
									               <td>" . $row['customer_name'] . "</td>
									               <td>" . $row['balance'] . "</td>
												
												   
												   
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
                                </article>
                                </div>
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
$('.ngs-popup').click(function() {
		var id=this.id;
		var url='product_ledger?<?php print SID?>&id=<?php print $system_id ?>&ent_id='+id;
		var Win = window.open(url,'_blank');
	     if (window.focus)
	     {
	       Win.focus();
	     }
	});
</script>

<?php 
	//include footer
	//include("/inc/google-analytics.php"); 
?>