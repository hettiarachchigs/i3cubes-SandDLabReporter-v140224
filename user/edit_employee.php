<?php
session_start();

$ary_prev = $_SESSION['USER_PREV'];

//print_r($ary_prev);
//print_r($_SESSION);
//initilize the page
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)


/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Employee-Edit";

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

include_once '../class/user.php';
include_once '../class/employee.php';
include_once '../class/team.php';
include_once '../class/functions.php';

$fn = new functions();

$emp_id = $_REQUEST['EMPID'];
$teamID = $_REQUEST['teamID'];

 $emp = new employee($emp_id);
if ($_POST['but'] == 'save') {
   
    $res_emp = $emp->editEmployee($_POST['emp_name'], $_POST['emp_address'], $_POST['emp_nic'], $_POST['emp_mobile'], $_POST['emp_email'], $_POST['emp_designation'], '');
    if ($res_emp) {
        $close = true;
    } else {
        $msg = "could not change the employee data .";
        $close = false;
    }
} else if ($_POST['submit_value'] == 'delete') {

    $team = new team($_POST['TEAMID']);
    $res=$team->deleteMember($_POST['EMPID']);

    if ($res) {
        $close = true;
    } else {
        $close = false;
        $msg = "<span class='ngs_failure_span'>
            <i class='fa-fw fa fa-times'></i>&nbsp;This group member could not be deleted. please contact administrator.
            </span>";
    }
} else {
    $emp = new employee($emp_id);
    $emp->getEmployee();
}
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
                    <div class="jarviswidget" id="wid-id-4" 
                         data-widget-deletebutton="false" 
                         data-widget-togglebutton="false"
                         data-widget-editbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-colorbutton="false">

                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i></span>
                            <span style="margin-left: 20px;"><h2>Edit User</h2></span>				

                        </header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <form id="form_edit" class="smart-form" method="post" action="<?php echo str_replace('.php', '', htmlentities($_SERVER['PHP_SELF'])); ?>">


                                    <fieldset>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Name:</strong>
                                            </section>
                                          
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="emp_name" id="emp_name" placeholder="Name" value="<?php print $emp->name ?>">
                                                </label>
                                            </section>	
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>NIC:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-star"></i>
                                                    <input type="text" name="emp_nic" id="emp_nic" placeholder="NIC" value="<?php print $emp->nic ?>">
                                                </label>
                                            </section>	
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Mobile:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-phone"></i>
                                                    <input type="text" name="emp_mobile" id="emp_mobile" placeholder="Mobile" value="<?php print $emp->mobile ?>">
                                                </label>
                                            </section>	
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Designation:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">

                                                <label class="select">													
                                                    <select name="emp_designation" id="emp_designation">
                                                        <option value="0" selected="" disabled="">Select Designation</option>
                                                        <?php
                                                        print $fn->CreateMenu('designation', 'designation', '', $emp->designationID, false, 'id', false, true);
                                                        ?>
                                                    </select> <i></i> 
                                                </label>

                                            </section>	
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>Address:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="textarea"> <i class="icon-append fa fa-map-marker"></i>  										
                                                    <textarea rows="3" name="emp_address" id="emp_address" placeholder="Address"><?php print $emp->address ?></textarea> 
                                                </label>
                                            </section>	
                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                            </section>
                                        </div>

                                        <input type="hidden" name="EMPID" id="EMPID" value="<?php print $emp_id ?>">
                                        <input type="hidden" name="TEAMID" id="TEAMID" value="<?php print $teamID ?>">
                                        <input type="hidden" name="submit_value" id="submit_value" value="">
                                        <footer>
                                            <button type="submit" class="btn btn-primary" name="but" id="but" value="save">
                                                Save
                                            </button>
                                            <?Php
                                            $emtype = $emp->getEmployeType();
                                            if ($emtype != 'L') {
                                                ?>
                                                <button type="button" class="btn btn-primary but_delete" id="but_delete" name="but" value="delete">
                                                    Delete
                                                </button>
                                                <?Php
                                            }
                                            ?>
                                            <p style="display: none;color: red;" id="msg_prev"><i class="fa-fw fa fa-times"></i>You are not authorized</p>
                                            <p style="display: none;color: red;" id="warning_delete" > <i class='fa-fw fa fa-scissors'></i>&nbsp;Warning ! This Group Member will be delete !</p>
                                            <?php print $msg; ?>
                                        </footer>
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


    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->



<?php
//include required scripts
include("../inc/scripts.php");
?>

<script type="text/javascript">
    checkUserPopUp('<?php print $_SESSION['UID'] ?>');
// DO NOT REMOVE : GLOBAL FUNCTIONS!

<?php
if ($close) {
    print "window.parent.location.reload();";
    print "window.parent.$.jeegoopopup.close();";
} else {
    print '$( "#msg_prev" ).html( "' . $msg . '" );';
    print '$( "#msg_prev" ).css("display", "block");';
}
?>
    $(document).ready(function () {
        //$( "input" ).prop( "disabled", true );
        //$( "#but" ).hide();
        //$( "#but_delete" ).hide();
        //$( "textarea" ).prop( "disabled", true );

<?php
$prev = false;
if ($ary_prev[2][2] == '1') {//Save
    print '$( "input" ).prop( "disabled", false );';
    print '$( "#but" ).show();';
    print '$( "textarea" ).prop( "disabled", false );';
    $prev = true;
}
if ($ary_prev[2][3] == '1') {//delete
    print '$( "input" ).prop( "disabled", false );';
    print '$( "#but_delete" ).show();';
    print '$( "textarea" ).prop( "disabled", false );';
    $prev = true;
}
if (!$prev) {
    print '$( "#msg_prev" ).css("display", "block");';
}


if ($close == 1) {
    print "window.parent.location.reload();";
    print "window.parent.$.jeegoopopup.close();";
} else {
    
}
?>

        var del = 0;
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


        var $registerForm = $("#form_edit").validate({

            // Rules for form validation
            rules: {
                emp_name: {
                    required: true
                }
            },

            // Messages for form validation
            messages: {
                emp_name: {
                    required: 'Please enter employee name'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });
    });

</script>