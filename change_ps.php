<?php
session_start();
/*
 * ============ LOGIC ==========
 */
include_once 'class/user.php';
include_once 'class/employee.php';
include_once 'class/functions.php';


//print_r($_COOKIE);

/* if($ip!='123.231.12.78'){
  if(!isset($_COOKIE['engt']) || ($_COOKIE['engt'] != 'true')){
  header("Location:http://energynetlk.com/");
  }
  else {
  $msg="<div class='alert alert-warning fade in'>
  <i class='fa-fw fa fa-warning'></i>&nbsp;you are login through public network.
  </div>";
  }
  }
  else {

  } */




if (isset($_SESSION['UID'])) {
    $us = new user($_SESSION['UID']);
    $us->getUser();
}


if ($_POST['but'] == 'save') {

    $res_ps_c = $us->changePassword($_POST['password'], 'A');

    if ($res_ps_c) {
        $us->setLastLoginTime();
        $ary_prev = $us->getPreviledges();
        $_SESSION['USER_PREV'] = $ary_prev;
        $url = "home?" . SID;
        header("Location:$url");
    }
}

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
//require_once("inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Login";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_html_prop = array("id" => "extr-page", "class" => "animated fadeInDown");
include("inc/header.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<header id="header" style="">
        <!--<span id="logo"></span>-->
    <div id="logo-group" >
        <span id="logo"style="padding: 0px;margin-top: 10px"> <img style="width: 215px;" src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="LEOSys" class="img-responsive" style=""> </span>
    </div>

</header>

<div id="main" role="main" style="background-color:#11043ec4">

    <!-- MAIN CONTENT -->
    <div id="content" class="container" style="">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
               <h1 class="txt-color-white login-header-big">LEO SYS CORPORATION</h1>
				
                <div class="hero">

                    <div class="pull-left login-desc-box-l">
                        <h4 class="paragraph-header txt-color-white">
                           </h4>
                    </div>

<!--<img src="<?php // echo ASSETS_URL;         ?>/img/img_log.png" class="pull-right display-image img-responsive" alt="" style="width:300px">-->

                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                <div class="well no-padding">
                    <form action="" id="login-form" class="smart-form client-form" method="post">
                        <div class="col-12">
                            <img src="img/ict.jpeg" width="100%">
                        </div>

                        <fieldset>
                            <section>
                                <label class="label" style="font-size: 14px;font-weight: bolder">Change Password...</label>
                            </section>
                            <section>
                                <label class="label"><font style="font-weight: bolder;">User Name:</font>  <?php print $us->userName ?></label>
                            </section>

                            <section>
                                <label class="label">Password</label>
                                <label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" name="password">
                                </label>
                            </section>
                            <section>
                                <label class="label">Confirm Password</label>
                                <label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" name="password_conf">
                                </label>
                            </section>

                            <section>
                                <?php print $msg ?>
                            </section>
                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary" name="but" id="but" value="save">
                                Save
                            </button>
                        </footer>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php
//include required scripts
include("inc/scripts.php");
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->

<script type="text/javascript">
    runAllForms();

    $(function () {
        // Validation
        $("#login-form").validate({
            // Rules for form validation
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                }
            },

            // Messages for form validation
            messages: {
                username: {
                    required: 'Please enter your user name'
                },
                password: {
                    required: 'Please enter your password'
                }
            },

            // Do not change code below
            errorPlacement: function (error, element) {
                error.insertAfter(element.parent());
            }
        });
    });
</script>

<?php
//include footer
include("inc/google-analytics.php");
?>