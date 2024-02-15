<?php
session_start();
$ary_prev = $_SESSION['USER_PREV'];
//print_r($_SESSION);
//initilize the page
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("../inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Group";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["user"]["sub"]["gr"]["active"] = true;
include("../inc/nav.php");

/*
 * ===== LOGIC =========*
 * 
 */
include_once '../class/employee.php';
include_once '../class/employeeManager.php';
include_once '../class/team.php';
include_once '../class/teamManager.php';
include_once '../class/constants.php';

$emp = new employee($_SESSION['EMPID']);
//$ary_team_ids = $emp->getLeadingTeam();
//$prev=$us->getPreviledges($_SESSION['UID']);

$team = new teamManager();
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
                    <div class="jarviswidget" id="wid-id-14"
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i></span>
                            <label style="font-size: 15px;padding-top: 6px;padding-left: 6px;" >Group</label>	
                            <span id="span_clients_head_lnk" class="span_head_lnk"><button class="btn btn-primary btn-xs" id="but" onclick="addgroupmember();" href="javascript:void(0);">add new</button></span>			

                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <?php
                                $teamID = "";
                                $teamarry = $team->getAllTeams();
                                $const = new constants();
                                //print_r($ary_user);
                                if (count($teamarry) > 0) {
                                    echo "<table id='t_user_view' class='table table-bordered table-hover' width='100%' >
                                                                                <thead>
									           <tr>	   
									           <th data-hide='phone'>#</th>
									           <th data-hide='phone'>Name</th>
									           <th data-hide='phone'>Status</th>
                                                                                   
									           </tr>
                                                                                </thead>";
                                    $i = 1;
                                    print '<tbody>';

                                    $tem = new \team();

                                    foreach ($teamarry as $tem) {
                                        echo "<tr id=" . '"' . $tem->id . '" class="ngs-popup ' . $flg . '"' . ">	  
                                            <td>" . $i . "</td>
                                            <td>" . $tem->name . "</td>
                                            <td>" . $const->getStatus($tem->status) . "</td>
                                            
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
<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript" src="<?php echo ASSETS_URL; ?>/jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
<link href="<?php echo ASSETS_URL; ?>/jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
<link href="<?php echo ASSETS_URL; ?>/jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />
<script type="text/javascript">
                                checkUser('<?php print $_SESSION['UID'] ?>');

                                function addgroupmember() {
                                    var options = {
                                        url: 'addteam',
                                        width: '450',
                                        height: '220',
                                        skinClass: 'jg_popup_round'
                                    };
                                    $.jeegoopopup.open(options);
                                }

                                function edit_employee(eid, tid) {
                                    var options = {
                                        url: 'edit_employee?EMPID=' + eid + '&teamID=' + tid,
                                        width: '600',
                                        height: '500',
                                        skinClass: 'jg_popup_round'
                                    };
                                    $.jeegoopopup.open(options);
                                }


                                $(document).ready(function () {
                                    $('.ngs-popup').click(function () {

                                        var url = 'editgmember?tid=' + this.id;
                                        var NWin = window.open(url, '_blank');
                                        if (window.focus)
                                        {
                                            NWin.focus();
                                        }
//                                    
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


                                    /* END BASIC */

                                    /* TABLETOOLS */
                                     $('#t_user_view').DataTable({

                                            responsive: true,
                                            dom: "<'dt-toolbar '<'col-sm-6 col-xs-12 hidden-xs' B><'col-sm-6 col-xs-12' f>>" +
                                                    "t" +
                                                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",

                                            buttons: [

                                                {extend: 'csv', title: '<?php print $cus->name ?>_systems_csv'},
                                                {extend: 'excel', title: '<?php print $cus->name ?>_systems_excel'},
                                                {extend: 'pdf', title: '<?php print $cus->name ?>_systems_pdf'},

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
                                    /*$('#t_user_view').dataTable({

                                        // Tabletools options: 
                                        //   https://datatables.net/extensions/tabletools/button_options
                                        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>" +
                                                "t" +
                                                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
                                        "oTableTools": {
                                            "aButtons": [
                                                "copy",
                                                "csv",
                                                "xls",
                                                {
                                                    "sExtends": "pdf",
                                                    "sTitle": "NGS_PDF",
                                                    "sPdfMessage": "NGS PDF Export",
                                                    "sPdfSize": "letter"
                                                },
                                                {
                                                    "sExtends": "print",
                                                    "sMessage": "<i>(press Esc to close)</i>"
                                                }
                                            ],
                                            "sSwfPath": "<?php echo ASSETS_URL; ?>/js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
                                        },
                                        "autoWidth": true,
                                        "preDrawCallback": function () {
                                            // Initialize the responsive datatables helper once.
                                            if (!responsiveHelper_datatable_ft) {
                                                responsiveHelper_datatable_ft = new ResponsiveDatatablesHelper($('#t_user_view'), breakpointDefinition);
                                            }
                                        },
                                        "rowCallback": function (nRow) {
                                            responsiveHelper_datatable_ft.createExpandIcon(nRow);
                                        },
                                        "drawCallback": function (oSettings) {
                                            responsiveHelper_datatable_ft.respond();
                                        }
                                    });*/

                                    /* END TABLETOOLS */

<?php
if (($ary_prev[2][1] != "1")) {
    print '$( "#but" ).prop( "disabled", true );';
    print '$( "button" ).prop( "disabled", true );';
    print '$( "#msg_prev" ).css("display", "block");';
} else {
    
}
?>


                                });

</script>