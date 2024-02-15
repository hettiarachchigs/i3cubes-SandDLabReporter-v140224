<?php
//initilize the page
session_start();
if (!isset($_SESSION['UID'])) {
    header('Location: index');
}
require_once ("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once ("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Customers";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include ("../inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["inventory"]["sub"]["store"]["active"] = true;
include ("../inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">

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
                    <div class="jarviswidget" id="wid-id-3" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                            <h2>Stores</h2>
                            <span id="storenew" class="span_head_lnk"><a class="btn btn-primary btn-xs" href="javascript:void(0);">add new</a></span>
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
                                include_once '../class/customer.php';
                                include_once '../class/customerManager.php';
                                $cus_mngr = new customerManager();
                                $cus = new \customer();
                                $ary_cus = $cus_mngr->getAllCustomers("S");
                                if (count($ary_cus) > 0) {
                                    echo "
                                    <table id='datatable_customer' class='table table-striped table-bordered table-hover' width='100%' >
					<thead>
                                        <tr>
                                           <th data-hide='phone'>Location Name</th>
					   <th data-hide='phone'>Address</th>
					   <th data-hide='phone'>Contact Number</th>
					   <th data-hide='phone'>Contact Person</th>
					   <th data-hide='phone'>Contact Note</th>
					   <th data-hide='phone'>Action</th>
                                        </tr>
					</thead>";

                                    foreach ($ary_cus as $cus) {   //Creates a loop to loop through results
                                        echo "
                                            <tr id=" . '"' . $cus->id . '" class="ngs-popup"' . ">
                                                <td>" . $cus->name . "</td>
                                                <td>" . $cus->address . "</td>
                                                <td>" . $cus->contactNumber . "</td>
                                                <td>" . $cus->contactName . "</td>
                                                <td>" . $cus->note . "</td>
                                                    <td><a href='javascript:void(0);' class='btn_print' id='$cus->id'><img src='../img/printIcon.png' height='20'/></a></td>
                                            </tr>";
                                    }
                                }
                                ?>

                                <script type="text/javascript">
                                    /*NGS addings*/
                                    $('.ngs-popup').click(function () {
                                        var url = 'store_edit?id=' + this.id;
//                                        var url = 'store_inventory_view?id=' + this.id;
                                        var NWin = window.open(url, '_blank');
                                        if (window.focus)
                                        {
                                            NWin.focus();
                                        }
                                    });


                                    $('#storenew').click(function () {
                                        add_customer();
                                    });

                                    
                                </script>
                                </thead>
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
//include ("/inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include ("../inc/scripts.php");
?>
<!--<script src="<?php echo ASSETS_URL; ?>/lib/datatables/jquery.dataTables.js"></script>
<script src="<?php echo ASSETS_URL; ?>/lib/datatables-responsive/dataTables.responsive.js"></script>
-->

<!--datatables-->

<script type="text/javascript">

// DO NOT REMOVE : GLOBAL FUNCTIONS!

    $(document).ready(function () {

        $('#span_clients_head_lnk').click(function () {
            add_customer();
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
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };


        $('#datatable_customer').DataTable({

            responsive: true,
            dom: "<'dt-toolbar '<'col-sm-6 col-xs-12 hidden-xs' B><'col-sm-6 col-xs-12' f>>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",

            buttons: [

                {extend: 'csv', title: 'Customers'},
                {extend: 'excel', title: 'Customers'},
                {extend: 'pdf', title: 'Customers'},

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
    function add_customer() {
        var options = {
            url: 'store_add?<?php print SID . "&" ?>',
            width: '600',
            height: '500',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }
$('.btn_print').on('click', function(event) {
  // Prevent the row click function from firing
  var id = $(this).attr('id');;
  event.stopPropagation();
  var url = '../reports/rpt_store?id='+id;
        var NWin = window.open(url, '_blank');
        if (window.focus)
        {
            NWin.focus();
        }
  // Open a new window for printing
});
</script>