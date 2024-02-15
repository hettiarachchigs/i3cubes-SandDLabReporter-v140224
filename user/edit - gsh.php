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

$page_title = "User-Edit";

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

$user_id = $_REQUEST['UID'];


print_r($_POST);
if ($_POST['but'] == 'save') {
    $us = new user($user_id);
    $res_usr = $us->editUser($_POST['usr_username']);
    $us->getUser();
    $emp = new employee($us->employeeID);
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $res_emp = $emp->editEmployee($_POST['emp_name'], $_POST['emp_address'], $_POST['emp_nic'], $_POST['emp_mobile'], $_POST['emp_email'], $_POST['emp_designation'], '', $_POST['note'],$lat,$lon);
    if ($_POST['usr_psw'] != '') {
        $res_ps = $us->changePassword($_POST['usr_psw']);
    } else {
        $res_ps = true;
    }
    if ($res_usr) {
        if ($res_ps) {
            if ($res_emp) {
                $close = true;
            } else {
                $msg = "could not change the employee data .";
                $close = false;
            }
        } else {
            $msg .= "could not change the password .";
            $close = false;
        }
    } else {
        $close = false;
        $msg .= "User could not be changed .";
    }
}
if ($_POST['submit_value'] == 'delete') {
     $us = new user($user_id);
    $us->getUser();
    $emp = new employee($us->employeeID);
    $res_emp = $emp->deleteEmployee();
    $res_usr = $us->deleteUser();
    //$res_usr = true; // NEED to remove
    if ($res_usr) {
        $close = true;
    } else {
        $close = false;
        $msg = "User could not be changed, please contact administrator";
    }
} else {
    $us = new user($user_id);
    $us->getUser();
    $emp = new employee($us->employeeID);
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
<?php print $_SERVER['PHP_SELF']; ?> 
                        </br></br></br>
                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <form id="form_edit" class="smart-form" method="post" action="<?php echo str_replace('.php', '', htmlentities($_SERVER['PHP_SELF'])); ?>">

                                    <fieldset>
                                        <div class="row">
                                            <section class="col-xs-1 col-sm-1 col-md-1">
                                            </section>
                                            <section class="col-xs-3 col-sm-3 col-md-3">
                                                <strong>User Name:</strong>
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                                    <input type="text" name="usr_username" id="usr_username" placeholder="Username" value="<?php print $us->userName ?>">
                                                    </section>	
                                                    <section class="col-xs-1 col-sm-1 col-md-1">

                                                    </section>
                                                    </div>
                                                    <div class="row">
                                                        <section class="col-xs-1 col-sm-1 col-md-1">
                                                        </section>
                                                        <section class="col-xs-3 col-sm-3 col-md-3">
                                                            <strong>Password:</strong>
                                                        </section>
                                                        <section class="col-xs-7 col-sm-7 col-md-7">
                                                            <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                                <input type="password" name="usr_psw" placeholder="Password" id="usr_psw">
                                                                </section>	
                                                                <section class="col-xs-1 col-sm-1 col-md-1">

                                                                </section>
                                                                </div>
                                                                <div class="row">
                                                                    <section class="col-xs-1 col-sm-1 col-md-1">
                                                                    </section>
                                                                    <section class="col-xs-3 col-sm-3 col-md-3">
                                                                        <strong>Confirm Password:</strong>
                                                                    </section>
                                                                    <section class="col-xs-7 col-sm-7 col-md-7">
                                                                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                                            <input type="password" name="usr_psw_conf" id="usr_psw_conf" placeholder="Confirm password">
                                                                            </section>	
                                                                            <section class="col-xs-1 col-sm-1 col-md-1">

                                                                            </section>
                                                                            </div>
                                                                            </fieldset>
                                                                            <header>
                                                                                Employee Data
                                                                            </header>
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
                                                                                        <strong>Email:</strong>
                                                                                    </section>
                                                                                    <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                        <label class="input"><i class="icon-append fa fa-globe"></i>
                                                                                            <input type="text" name="emp_email" id="emp_email" placeholder="Email" value="<?php print $emp->email ?>">
                                                                                        </label>
                                                                                    </section>	
                                                                                    <section class="col-xs-1 col-sm-1 col-md-1">

                                                                                    </section>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    </section>
                                                                                    <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                        <strong>Latitude:</strong>
                                                                                    </section>
                                                                                    <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                        <label class="input">
                                                                                            <input type="text" name="lat" id="lat" placeholder="Latitude" value="<?php print $emp->lat ?>">
                                                                                        </label>
                                                                                    </section>	
                                                                                    <section class="col-xs-1 col-sm-1 col-md-1">

                                                                                    </section>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    </section>
                                                                                    <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                        <strong>Longitude:</strong>
                                                                                    </section>
                                                                                    <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                        <label class="input">
                                                                                            <input type="text" name="lon" id="lon" placeholder="Longitude" value="<?php print $emp->lon ?>">
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
                                                                                <div class="row">
                                                                                    <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    </section>
                                                                                    <section class="col-xs-3 col-sm-3 col-md-3">
                                                                                        <strong>Note:</strong>
                                                                                    </section>
                                                                                    <section class="col-xs-7 col-sm-7 col-md-7">
                                                                                        <label class="textarea"> <i class="icon-append fa"></i>  										
                                                                                            <textarea rows="2" name="note" id="note" placeholder="Note"><?php print $emp->note ?></textarea> 
                                                                                        </label>
                                                                                    </section>	
                                                                                    <section class="col-xs-1 col-sm-1 col-md-1">
                                                                                    <button type="submit" class="btn btn-primary" name="but" id="but" value="save">
                                                                                        Save
                                                                                    </button>
                                                                                    <button type="submit" class="btn btn-primary" name="but" id="but_delete" value="delete">
                                                                                        Delete
                                                                                    </button>
                                                                                    </section>
                                                                                </div>

                                                                                <input type="hidden" name="UID" id="UID" value="<?php print $us->id ?>">
                                                                                <input type="hidden" name="submit_value" id="submit_value" value="">
                                                                                <footer> 
                                                                                    <?php //if($us->status == constants::$USER_DELETED) {
                                                                                       // print '<p style="" id=""><font color="red"><i class="fa-fw fa fa-times"></i>Deleted User</font></p>';
                                                                                    //} else {?>
                                                                                    <button type="submit" class="btn btn-primary" name="but" id="but" value="save">
                                                                                        Save
                                                                                    </button>
                                                                                    <button type="submit" class="btn btn-primary" name="but" id="but_delete" value="delete">
                                                                                        Delete
                                                                                    </button>
                                                                                   
                                                                                    <?php
                                                                                    //print_r($ary_prev);
                                                                                    if ($ary_prev[2][1] == '1') {
                                                                                        print '<button type="button" class="btn btn-primary" id="but_prev" name="but_prev">
                                                                                                        Previledges
                                                                                                </button>';
                                                                                    }
                                                                                    ?>
                                                                                    <?php //} ?>
                                                                                     <div style="float: right; padding-right: 15px; padding-bottom: 15px;">
                                                                                        <a href='../reports/rpt_user?id=<?php print $user_id ?>' target='_blank' id=""><img src="../img/printIcon.png" height="50"/></a>
                                                                                    </div>
                                                                                    <p style="display: none;" id="warning_delete"><font color="red"><i class="fa-fw fa fa-times"></i>User Will be deleted, to confirm press Delete again</font></p>
                                                                                    <p style="display: none;color: red;" id="msg_prev"><i class="fa-fw fa fa-times"></i>You are not authorized</p>
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
//DO NOT REMOVE : GLOBAL FUNCTIONS!                                                                               
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
$("input").prop("disabled", false);
$("#but").hide();
$("#but_delete").hide();
$("textarea").prop("disabled", false);

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
?>
                                                                                        var del = 0;
                                                                                        $('#but_delete').click(function (e) {
                                                                                            e.preventDefault();
                                                                                            if (del == 0) {
                                                                                                $('#but_delete').text("Confirm Delete");
                                                                                                $('#but_delete').removeClass('btn-info').addClass('btn-danger');
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
$('#but_print').click(function(){
var from = $('#jo_s_from').val();
var to = $('#jo_s_to').val();
 var url = 'rpt_return_note_excel?from='+from+'&to='+ to;
        var NWin = window.open(url, '_blank');
        if (window.focus)
        {
            NWin.focus();
        }
})
                                                                                </script>