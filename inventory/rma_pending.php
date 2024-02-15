<?php
session_start();

//print_r($_SESSION);
//initilize the page
require_once ("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "STN View";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["inventory"]["sub"]["rma"]["active"] = true;
include("../inc/nav.php");

/*
 * ===== LOGIC =========*
 * 
 */
include_once '../class/rma.php';
include_once '../class/rmaManager.php';
include_once '../class/constants.php';


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
                    <div class="jarviswidget" id="wid-id-23"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i></span>
                            <h2>RMA Pending Items</h2>	
                            <span id="span_grn_head_lnk_grn" class="span_head_lnk"><a class="btn btn-primary btn-xs" href="javascript:void(0);">RMA</a></span>			

                        </header>
                        <form id="smart-form-register" class="smart-form" method="post">
                            <fieldset>
                                <div class="row">											
                                    <section class="col col-3">
                                        <label class="input">
                                            <input type="text" name="jo_s_vid" id="jo_s_vid" placeholder="Customer/Location" value="<?php print $_POST['jo_s_vid'] ?>">
                                        </label>
                                    </section>
                                    <section class="col col-3">
                                        <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                            <input type="text" name="jo_s_from" autocomplete="off" id="jo_s_from" placeholder="From" class="form-control datepicker" data-dateformat="yy-mm-dd" value="<?php print $_POST['jo_s_from'] ?>">
                                        </label>
                                    </section>
                                    <section class="col col-3">
                                        <label class="input"> <i class="icon-append fa fa-calendar"></i>
                                            <input type="text" name="jo_s_to" autocomplete="off" id="jo_s_to" placeholder="To" class="form-control datepicker" data-dateformat="yy-mm-dd" value="<?php print $_POST['jo_s_to'] ?>">
                                        </label>
                                    </section>
                                    <section class="col col-3">	
                                        <input type="hidden" name="jo_s_vid_id" id="jo_s_vid_id" value="<?php $_POST['jo_s_vid_id'] ?>">
                                        <button type="submit" class="btn btn-primary btn-xs" id="but" name="but" value="search">
                                            Search
                                        </button>
                                    </section>
                                </div>
                            </fieldset>
                        </form>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <?php
                                $jo_s_from = $_POST['jo_s_from'];
                                $jo_s_to = $_POST['jo_s_to'];
                                $jo_s_vid = $_POST['jo_s_vid_id'];

                                $rma = new \rma();
                                $trk_item=new \inventory_track_item();
                                $rms_mgr = new rmaManager();
                                $ary_items = $rms_mgr->getPendingRMAItems();

                                //print_r($ary_user);
                                if (count($ary_items) > 0) {
                                    echo "<table id='t_raw_search' class='table table-bordered table-hover' width='100%' >
											   <thead>
									           <tr>	   
									           <th data-hide='phone'>#</th>
									           <th data-hide='phone'>STN No</th>
                                                                                   <th data-hide='phone'>Part Code</th>
                                                                                    <th data-hide='phone'>Serial</th>
                                                                                    <th data-hide='phone'>Description</th>
									           <th data-hide='phone'>STN Date</th>
                                                                                    <th data-hide='phone'>From</th>
                                                                                    <th data-hide='phone'>To</th>
                                                                                    <th data-hide='phone'>..</th>
									           </tr>
                                                                                </thead>";
                                    $i = 1;
                                    print '<tbody>';
                                    foreach ($ary_items as $trk_item) {   //Creates a loop to loop through results
                                        
                                        echo "
								               <tr id=" . '"' . $trk_item->id . '" class="ngs-popup ' . $flg . '"' . ">	  
								               <td>" . $i . "</td>
								               <td>" . $trk_item->note . "</td>
								               <td>" . $trk_item->system_code . "</td>
								               <td>" . $trk_item->serial . "</td>
                                                                                <td>" . $trk_item->system_name . "</td>
                                                                                <td>" . $trk_item->date . "</td>
                                                                                <td>" . $trk_item->customer_name_from . "</td>
                                                                                <td>" . $trk_item->customer_name_to . "</td>
                                                                                <td>";
                                                                                if($trk_item->status=='2' && $trk_item->chain_reference_id!=''){
                                                                                    print 
                                                                                        '<a href="javascript:return_item('.$trk_item->chain_reference_id.')" title="return same"><i class="fa fa-reply" style="margin-left:10px;" aria-hidden="true"></i></a>'
                                                                                        . '<a href="javascript:add_new_item('.$trk_item->chain_reference_id.')" title="add new"><i class="fa fa-plus-square-o" style="margin-left:10px;" aria-hidden="true"></a></i>'
                                                                                        . '<a href="javascript:discontinue_item('.$trk_item->chain_reference_id.')" title="discontinue"><i class="fa fa-ban" style="margin-left:10px;" aria-hidden="true"></a></i>';

                                                                                }
                                                                            print "</td>
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

<script type="text/javascript" src="../jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
<link href="../jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
<link href="../jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />
<script type="text/javascript">

    $(document).ready(function () {
        $('#span_grn_head_lnk_grn').click(function () {
            var url = 'rma_view?<?php print SID ?>';
            window.location.replace(url);
        });
        $('.ngs-popup').click(function () {

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
            tablet: 1024,
            phone: 480
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
    
    function return_item(id) {
        var options = {
            url: 'stn_item_return?<?php print SID?>&item_id='+id,
            width: '550',
            height: '300',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }
    function discontinue_item(id) {
        var options = {
            url: 'stn_item_discard?<?php print SID?>&item_id='+id,
            width: '550',
            height: '300',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }
    function add_new_item(id){
        var options = {
            url: 'stn_item_replace?<?php print SID?>&item_id='+id,
            width: '600',
            height: '500',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }


</script>