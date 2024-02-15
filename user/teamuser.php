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

$page_title = "Edit-Employee";

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
include_once '../class/functions.php';

$fn = new functions();

$emp_id = $_REQUEST['eid'];


$emp = new employee($emp_id);

$emp->getEmployee();


if ($_POST['but'] == 'save') {

    $id = $_POST['emid'];

    $empl = new employee($id);

    $empl->getEmployee();

    $empl->editEmployeeteam($_POST['emp_address'], $_POST['emp_mobile'], $_POST['email']);

    if ($emp) {
        $close = 1;
    } else {
        $close = 0;
        $msg = "Error Occur Please Check ! ";
    }
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
                            <span style="margin-left: 20px;"><h2>Edit Member</h2></span>				

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
                                                    <input type="text" name="emp_name" id="emp_name" disabled="" placeholder="Name" value="<?php print $emp->name ?>">
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
                                                <strong>Email:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"><i class="icon-append fa fa-phone"></i>
                                                    <input type="text" name="email" id="" placeholder="email" value="<?php print $emp->email ?>">
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

                                        <input type="hidden" name="emid" id="emid" value="<?php print $emp->id ?>">
                                        <input type="hidden" name="submit_value" id="submit_value" value="">
                                        <footer>
                                            <button type="submit" class="btn btn-primary" name="but" id="but" value="save">
                                                Save
                                            </button>

                                            <p style="display: none;color: red;" id="msg_prev"><i class="fa-fw fa fa-times"></i>You are not authorized</p>
                                        </footer>
                                    </fieldset>			
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
//        $("input").prop("disabled", true);
//        $("#but").hide();
//        $("#but_delete").hide();
//        $("textarea").prop("disabled", true);

<?php
$prev = false;
if ($ary_prev[2][2] == '1') {//Save
//    print '$( "input" ).prop( "disabled", false );';
//    print '$( "#but" ).show();';
//    print '$( "textarea" ).prop( "disabled", false );';
//    $prev = true;
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
?>
        var del = 0;
        $('#but_delete').click(function (e) {
            e.preventDefault();
            if (del == 0) {
                $('#but_delete').text("Confirm Delete");
                del = 1;
            } else {
                $('#but_delete').val('delete');
                $('#submit_value').val('delete');
                $('#form_edit').submit();
            }
        });
        $('#but_prev').click(function (e) {
            e.preventDefault();
            window.location.href = 'previledge?UID=<?php print $user_id ?>';
        });

        var $registerForm = $("#form_edit").validate({

            // Rules for form validation
            rules: {
                usr_username: {
                    required: true
                },
                usr_psw: {
                    minlength: 3,
                    maxlength: 20
                },
                usr_psw_conf: {
                    minlength: 3,
                    maxlength: 20,
                    equalTo: '#usr_psw'
                }
            },

            // Messages for form validation
            messages: {
                usr_username: {
                    required: 'Please enter your user name'
                },
                usr_username: {
                    required: 'Please enter your email address',
                    email: 'Please enter a VALID email address'
                },
                usr_psw: {
                    required: 'Please enter your password'
                },
                usr_psw_conf: {
                    required: 'Please enter your password one more time',
                    equalTo: 'Please enter the same password as above'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });
    });

</script>