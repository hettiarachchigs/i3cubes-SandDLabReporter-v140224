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
include_once '../class/team.php';
include_once '../class/functions.php';


$close = 0;
$msg = "";
if ($_POST['but'] == 'save') {

    $name = $_POST['team'];

    $team = new team();

    if ($team->addTeam($name)) {

        $close = 1;
    } else {
        $msg = "<br><span style='color: red;' >Error Occur !Please check</span>";
        $close = 2;
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
                            <span style="margin-left: 20px;"><h2>Add Group</h2></span>				

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

                                <form id="ro_add" class="smart-form" method="post">
                                    <fieldset>
                                        <div class="row" >
                                            <section class="col-xs-1 col-sm-1 col-md-1">
<!--                                                <strong>Qty Issued:</strong>-->
                                            </section>
                                            <section class="col-xs-7 col-sm-7 col-md-7">
                                                <label class="input"> 	<i class="icon-append fa fa-user"></i> 									
                                                    <input type="text" autocomplete="false" name="team" id="team" value="" placeholder="Group Name">
                                                    <p style="color: red;" id="msg" ></p>   
                                                </label>
                                            </section>
                                        </div>


                                    </fieldset>
                                    <footer>  
                                        <?= $msg ?>
                                        <p style="display:none;color: red;" id="msg_prev"><i class="fa-fw fa fa-times"></i>You are not authorized</p>
                                        <input type="hidden" name="teamid" id="teamid" value="<?php echo $_REQUEST['gid']; ?> "  >
                                        <button type="submit" class="btn btn-primary" id="but" name="but" value="save" >
                                            Save
                                        </button>
                                    </footer>
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

//            $('#memb').autocomplete({
//                source: '../json/get_employee',
//                minLength: 1,
//                select: function (event, ui) {
//                    var id = ui.item.id;
//                    if (id != '') {
//                        $('#membid').val(id);
//                    }
//                },
//            });

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
