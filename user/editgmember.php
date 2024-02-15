<?php
session_start();
//initilize the page
$ary_prev = $_SESSION['USER_PREV'];
//print_r($_SESSION);
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Add Group Members";

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

include_once '../class/employee.php';
include_once '../class/employeeManager.php';
include_once '../class/team.php';
include_once '../class/teamManager.php';
include_once '../class/functions.php';
include_once '../class/constants.php';


$fn = new functions();

$id = $_REQUEST['tid'];

$team = new team($id);
$team->getTeam();
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="margin-left: 10px;">

    <!-- MAIN CONTENT -->
    <div id="content">

        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div role="widget" class="jarviswidget" id="wid-id-fte-2"
                 data-widget-colorbutton="false"	
                 data-widget-editbutton="false"
                 data-widget-togglebutton="false"
                 data-widget-deletebutton="false"
                 data-widget-fullscreenbutton="false"
                 data-widget-custombutton="false"
                 data-widget-collapsed="false" 
                 data-widget-sortable="false">
                <header role="heading">
                    <h2><strong>Members &nbsp;&nbsp;(<?= $team->name ?>)</strong></h2>
                    <span id="span_clients_head_lnk" class="span_head_lnk"><button class="btn btn-primary btn-xs" id="but" onclick="addmember(<?= $id ?>);" href="javascript:void(0);">Add Member</button></span>

                </header>

                <div>
                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        <?php
                        $temmangr = new teamManager();
                        $arrayitm = $temmangr->getTeamsemployee($id);


                        if (count($arrayitm) > 0) {
//                                     <th data-hide='phone'>Qty WS In</th>
                            echo "
                                    <table id='t_cus_eq_list' class='table table-striped table-bordered table-hover' width='100%' >
                                    <thead>
                                    <tr>	   
                                        <th data-hide='phone'>..</th>
                                        <th data-hide='phone'>Employee Name</th>
                                        <th data-hide='phone'>Type</th>
                                        <th data-hide='phone'></th>
                                        <th data-hide='phone'></th>
                                       
			           </tr>
                                    </thead>
                                    <tbody>";

                            $i = 1;

                            foreach ($arrayitm as $row) {   //Creates a loop to loop through results
                                echo "
                                            <tr id=" . '"' . $row["id"] . '" class="ngs-popup-eq"' . ">	  
                                                <td>" . $i . "</td>
                                                <td>" . $row["employee"] . "</td>
                                                <td>" . $row["type"] . "</td>
                                                <td> <form id='fm'  method='post' action='deletemember' > "
                                . "<input type='hidden' value=" . $id . " name='gid'  >"
                                . "<input type='hidden' value=" . $row["id"] . " name='emp_id'  >
                                                    <button type='submit' id='but' class='btn btn-primary btn-xs' name='but' value='delete'  >Remove</button>
                                                    </form></td>
                                               
                                                   <td> <button type='button' id='edit'  onclick='editmem(" . $row["id"] . ")' class='btn btn-primary btn-xs' name='but' value='edit'  >Edit</button>   </td>

                                            </tr>";

//                                         <td>" . $item1->rackname . "</td>
////                                                <td>" . $item->getROItemStatus($item->status) . "</td>
                                $i++;
                            }
                            print '</tbody>'
                                    . '</table>';
                        }
                        ?>

                    </div>
                </div>
            </div>
        </article>


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



<script type="text/javascript">
<?php
//if ($close) {
//    print "window.opener.location.reload(false);";
//    print "window.close();";
//}
?>



//$('.ngs-popup-br').click(function() {
//	var url='../branch/edit?br_id='+this.id;
//	window.open(url, '_blank');
//});
//$('.ngs-popup-eq').click(function() {
//        edit_equipment(this.id);
//});
//
//$('.ngs-history').click(function(event){
//    event.stopPropagation();
//    var id=$(this).closest('tr').prop('id');
//    var url='customer_branch_history.php?br_id='+id+"&<?php // print SID                                                                                                                                                                                      ?>";
//    window.open(url, '_blank');
//});
</script>

<script type="text/javascript">

    function editmem(id) {
        var options = {
            url: 'teamuser?eid=' + id,
            width: '480',
            height: '380',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }


    $('#emp').autocomplete({
        source: '../json/get_employee',
        minLength: 1,
        select: function (event, ui) {
            var id = ui.item.id;
            if (id != '') {
                $('#empid').val(id);
            }
        },
    });

    function addmember(id) {
        var options = {
            url: 'addmember?tid=' + id,
            width: '450',
            height: '260',
            skinClass: 'jg_popup_round'
        };
        $.jeegoopopup.open(options);
    }


    $(document).ready(function () {

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


        /* END BASIC */


        /* TABLETOOLS */
        $('#t_cus_eq_list').dataTable({

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
            "autoWidth": true,
            "preDrawCallback": function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#t_cus_eq_list'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

        $('#t_cus_br_list').dataTable({

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
                        "sTitle": "SmartAdmin_PDF",
                        "sPdfMessage": "SmartAdmin PDF Export",
                        "sPdfSize": "letter"
                    },
                    {
                        "sExtends": "print",
                        "sMessage": " <i>(press Esc to close)</i>"
                    }
                ],
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "autoWidth": true,
            "preDrawCallback": function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#t_cus_br_list'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });
        /* END TABLETOOLS */

        /*NGS addings*/

        var del = 0;
        $('#add_eq').click(function () {
            add_equipment('<?php print $cid ?>');
        });
        $('#add_br').click(function () {
            add_branch('<?php print $cid ?>');
        });
        $('#but_delete').click(function () {
            if (del == 0) {
                $("#warning_delete").css("display", "block");
                $('#but_delete').text("Confirm Delete");
                $('#submit_value').val("delete");
                del = 1;
            } else {
                $('#form_edit').submit();
            }
        });

        $('#cus_group').autocomplete({
            source: 'json/get_group',
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                if (id != '') {
                    $('#cus_group_id').val(id);
                }
            },
        });
        $('#cus_acc_owner').autocomplete({
            source: '../json/get_employee',
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                if (id != '') {
                    $('#cus_acc_owner_id').val(id);
                }
            },
        });




        $('#ro_customer').autocomplete({
            source: '../json/get_customer',
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                if (id != '') {
                    $('#ro_customer_id').val(id);
                }
            }
        });
        $('#ro_branch').autocomplete({
            //var cusid=$('#ft_customer_id').val();		
            source: function (request, response) {
                $.getJSON("../json/get_branch", {cus_id: $('#ro_customer_id').val(), term: $('#ro_branch').val()},
                        response);
            },
            minLength: 1,
            select: function (event, ui) {
                var id = ui.item.id;
                if (id != '') {
                    $('#ro_branch_id').val(id);

                }
            },
        });

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
