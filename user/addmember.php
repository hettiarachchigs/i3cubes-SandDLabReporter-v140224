<?php
session_start();
$ary_prev = $_SESSION['USER_PREV'];

require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Add Group Member";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");


include_once '../class/employee.php';
include_once '../class/employeeManager.php';
include_once '../class/team.php';
include_once '../class/teamManager.php';
include_once '../class/functions.php';
include_once '../class/constants.php';

$id = $_REQUEST['tid'];

$team = new team($id);

if ($_POST['but'] == 'save') {
    $team1 = new team($_POST['teamid']);
    $emplo = new employee($_POST['empid']);
    $arry1 = $emplo->getTeam();
    $value = $team1->isOwner();



    if (isset($_POST['name'])) {
        $team1->edit($_POST['name']);
    }

    $chk = 0;
    if ($_POST['op'] == "L") {
        if ($value > 0) {// leader exist already
            $msg = "<span class='ngs_failure_span'>
              <i class='fa-fw fa fa-times'></i>&nbsp;Group Leader already Added.
             </span>";
            $chk = 1;
        }
    }


    if ($chk == 0) {
        if (count($arry1) > 0) {// employee exist
            $msg = "<span class='ngs_failure_span'>
               <i class='fa-fw fa fa-times'></i>&nbsp;This Group Member already Added.
                    </span>";
        } else {

            $res = $team1->addMembers($_POST['empid'], $_POST['op']);
            if ($res) {
                $close = 1;
                $msg = "<span class='ngs_success_span'>
                    <i class='fa-fw fa fa-check'></i>&nbsp;Group Member Added.
                    </span>";
            } else {
                $close = 0;
            }
        }
    } else {
        
    }
}

$fn = new functions();
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="min-height: 80px;">

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
                    <div class="jarviswidget" id="wid-id-500" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i></span>
                            <span style="margin-left: 20px;"><h2>Add Member</h2></span>				

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

                                <form id="form_edit" class="smart-form" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
                                    <fieldset>
                                        <div class="row">
                                            <section class="col col-6">
                                                <label class="input"><i class="icon-append fa fa-user"></i>
                                                    <input type="text" value="" name="emp" id="emp" placeholder="Employee">
                                                </label>
                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col col-6">
                                                <label class="select"> <i class="icon-append fa fa-box"></i>  										
                                                    <select name="op" id="op" >
                                                        <option value="M">Member</option>
                                                        <option value="L">Leader</option>
                                                    </select> 
                                                </label>
                                            </section>
                                        </div>
                                    </fieldset>
                                    <footer>
                                        <div class="row">
                                            <section class="col col-6">
                                                <span class='ngs_failure_span' style="display: none;" id="warning_delete">
                                                    <i class='fa-fw fa fa-scissors'></i>&nbsp;Warning ! This Repair Order will be delete !
                                                </span>
                                                <div>
                                                    <?php print $msg ?>
                                                </div>

                                            </section>
                                            <section class="col col-6">
                                                <button type="submit" class="btn btn-primary but_save" id="but" name="but" value="save">
                                                    Save
                                                </button>


                                                <p style="display: none;" id="msg_prev"><font color="red"><i class="fa-fw fa fa-times"></i>You are not authorized</font></p>
                                            </section>
                                        </div>
                                    </footer>
                                    <input type="hidden" name="teamid" id="teamid" value="<?= $team->id ?>">
                                    <input type="hidden" name="empid" id="empid" >
                                </form>						

                            </div>
                            <!-- end widget content 

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

    <script type="text/javascript">

        checkUserPopUp('<?php print $_SESSION['UID'] ?>');
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
//     
<?php
if ($close == 1) {
    print "window.parent.location.reload();";
    print "window.parent.$.jeegoopopup.close();";
} else {
    
}
?>

        // DO NOT REMOVE : GLOBAL FUNCTIONS!

        $(document).ready(function () {

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

//            var $FTAForm = $("#ro_add").validate({
//                ignore: "not:hidden",
//                // Rules for form validation
//                rules: {
//                    qty: {
//                        required: true
//                    }
//
//                },
//                // Messages for form validation
//                messages: {
//                    qty: {
//                        required: 'Please enter qty'
//                    }
//
//                },
//                // Do not change code below
//                errorPlacement: function (error, element) {
//                    error.insertAfter(element.parent());
//                }
//            });


        });

    </script>
