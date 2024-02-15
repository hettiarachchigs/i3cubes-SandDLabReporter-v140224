<!DOCTYPE html>

<html lang="en-us" <?php
echo implode(' ', array_map(function($prop, $value) {
            return $prop . '="' . $value . '"';
        }, array_keys($page_html_prop), $page_html_prop));
?>>
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title> <?php echo $page_title != "" ? $page_title . " - " : ""; ?>S$D Chemicals </title>
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/font-awesome.min.css">

        <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production.min.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/smartadmin-skins.min.css">

        <!-- SmartAdmin RTL Support is under construction-->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/smartadmin-rtl.min.css">

        <!-- We recommend you use "your_style.css" to override SmartAdmin
             specific styles this will also ensure you retrain your customization with each SmartAdmin update.-->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/ngs.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/alertify.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/fixedColumns.dataTables.css">
        <!--<link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/summernote/summernote.css">-->
        <link href="<?php echo ASSETS_URL; ?>/css/summernote-lite.css" rel="stylesheet">

        <?php
        if ($page_css) {
            foreach ($page_css as $css) {
                echo '<link rel="stylesheet" type="text/css" media="screen" href="' . ASSETS_URL . '/css/' . $css . '">';
            }
        }
        ?>


        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo ASSETS_URL; ?>/css/demo.min.css">

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="<?php echo ASSETS_URL; ?>/img/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo ASSETS_URL; ?>/img/favicon/favicon.ico" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

        <!-- Specifying a Webpage Icon for Web Clip
                 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
        <link rel="apple-touch-icon" href="<?php echo ASSETS_URL; ?>/img/splash/sptouch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo ASSETS_URL; ?>/img/splash/touch-icon-ipad-retina.png">

        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Startup image for web apps -->
        <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="<?php echo ASSETS_URL; ?>/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

        <!-- NGS Addings-->
        <link href="<?php echo ASSETS_URL; ?>/jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
        <link href="<?php echo ASSETS_URL; ?>/jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />
        <!--<link href="<?php echo ASSETS_URL; ?>/js/plugin/sweetalerts/animate.min.css" rel="Stylesheet" type="text/css" />-->
        <!-- NGS Addings-->

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script>
                if (!window.jQuery) {
                        document.write('<script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-2.0.2.min.js"><\/script>');
                }
        </script>
        -->
        <script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-2.0.2.min.js">
        </script>

<!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
        if (!window.jQuery.ui) {
                document.write('<script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
        }
</script>

        -->
        <script src="<?php echo ASSETS_URL; ?>/js/libs/jquery-ui-1.10.3.min.js">
        </script>
        <script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/datatables.min.js"></script>
        
<!--        <link href="<?php echo ASSETS_URL; ?>/lib/datatables/jquery.dataTables.css" rel="stylesheet">
        <link href="<?php echo ASSETS_URL; ?>/lib/datatables-responsive/responsive.dataTables.scss" rel="stylesheet">
        <link href="<?php echo ASSETS_URL; ?>/lib/datatables/css/buttons.dataTables.min.css" rel="stylesheet">-->
        <!--<script src="<?php //echo ASSETS_URL; ?>/js/plugin/sweetalerts/sweetalert2.css"></script>-->

       

        <script type="text/javascript">
            $(document).ready(function () {
                // $('body').addClass('smart-style-3')
            })
        </script>
        <?php $page_body_prop['class'] = 'body_back smart-style-3'; ?>
        <style>
            #overlay{	
  position: fixed;
  top: 0;
  z-index: 1000;
  width: 100%;
  height:100%;
  display: none;
  background: rgba(0,0,0,0.6);
}
.cv-spinner {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;  
}
.spinner {
  width: 40px;
  height: 40px;
  border: 4px #ddd solid;
  border-top: 4px #2e93e6 solid;
  border-radius: 50%;
  animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
  100% { 
    transform: rotate(360deg); 
  }
}
.is-hide{
  display:none;
}
     .loading {
    position: absolute;
    left: 0;
    right: 0;
    top: 60%;
    width: 100px;
    color: #FFF;
    font-size: 16px;
    margin: auto;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    z-index: 1100;
}
.loading span {
    position: absolute;
    height: 10px;
    width: 84px;
    top: 50px;
    overflow: hidden;
}
.loading span > i {
    position: absolute;
    height: 4px;
    width: 4px;
    border-radius: 50%;
    -webkit-animation: wait 4s infinite;
    -moz-animation: wait 4s infinite;
    -o-animation: wait 4s infinite;
    animation: wait 4s infinite;
}
.loading span > i:nth-of-type(1) {
    left: -28px;
    background: yellow;
}
.loading span > i:nth-of-type(2) {
    left: -21px;
    -webkit-animation-delay: 0.8s;
    animation-delay: 0.8s;
    background: lightgreen;
}
@-webkit-keyframes wait {
    0%   { left: -7px  }
    30%  { left: 52px  }
    60%  { left: 22px  }
    100% { left: 100px }
}
@-moz-keyframes wait {
    0%   { left: -7px  }
    30%  { left: 52px  }
    60%  { left: 22px  }
    100% { left: 100px }
}
@-o-keyframes wait {
    0%   { left: -7px  }
    30%  { left: 52px  }
    60%  { left: 22px  }
    100% { left: 100px }
}
@keyframes wait {
    0%   { left: -7px  }
    30%  { left: 52px  }
    60%  { left: 22px  }
    100% { left: 100px }
}
        </style>
    </head>
    <body <?php
    echo implode(' ', array_map(function($prop, $value) {
                return $prop . '="' . $value . '"';
            }, array_keys($page_body_prop), $page_body_prop));
    ?>>
<div id="overlay">
    <div class="loading">
        <span><i></i><i></i></span>
        <p>Please wait</p>
        
    </div>
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
        <!-- POSSIBLE CLASSES: minified, fixed-ribbon, fixed-header, fixed-width
                 You can also add different skin classes such as "smart-skin-1", "smart-skin-2" etc...-->
        <?php
        if (!$no_main_header) {
            ?>
            <!-- HEADER -->
            <header id="header" style="display: flex;width: 100%;">
                <div id="logo-group" style="">

                    <!-- PLACE YOUR LOGO HERE -->
                    <span id="logo" style="margin-top: 0px;"> <img style="width: 110px;" src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="S&D"> </span>
                    <!-- END LOGO PLACEHOLDER -->

                    <!-- Note: The activity badge color changes when clicked and resets the number to 0
                    Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
                    <!-- <span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge"> 21 </b> </span>-->

                    <!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->

                    <!-- END AJAX-DROPDOWN -->
                </div>

                <!-- projects dropdown -->
                <div class="" style="width: 800px;width: 100%;text-align: center;">
                    <h4 style="font-size: 28px; font-weight: bolder; color: #11043ec4;">Test Management System</h4>
                </div>
                <!-- end projects dropdown -->

                <!-- pulled right: nav area -->
                <div class="pull-right" style="width: 175px;">

                    <!-- collapse menu button -->
                    <div id="hide-menu" class="btn-header pull-right">
                        <span> <a href="javascript:void(0);" title="Collapse Menu" data-action="toggleMenu"><i class="fa fa-reorder"></i></a> </span>
                    </div>
                    <!-- end collapse menu -->


                    <!-- logout button -->
                    <div id="logout" class="btn-header transparent pull-right">
                        <span> <a href="<?php echo APP_URL; ?>/logout" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
                    </div>
                    <!-- end logout button -->


                </div>
                <!-- end pulled right: nav area -->

            </header>
            <!-- END HEADER -->

            <!-- END SHORTCUT AREA -->

            <?php
        }
        ?>