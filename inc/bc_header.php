<!DOCTYPE html>
<html lang="en-us" <?php echo implode(' ', array_map(function($prop, $value) {
			return $prop.'="'.$value.'"';
		}, array_keys($page_html_prop), $page_html_prop)) ;?>>
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> <?php echo $page_title != "" ? $page_title." - " : ""; ?>Energynet </title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support is under construction-->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/smartadmin-rtl.min.css">

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.-->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/ngs.css">

		<?php

			if ($page_css) {
				foreach ($page_css as $css) {
					echo '<link rel="stylesheet" type="text/css" media="screen" href="'.ASSETS_URL.'/css/'.$css.'">';
				}
			}
		?>


		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo ASSETS_URL; ?>/css/demo.min.css">

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

	</head>
	<body <?php echo implode(' ', array_map(function($prop, $value) {
			return $prop.'="'.$value.'"';
		}, array_keys($page_body_prop), $page_body_prop)) ;?>>

		<!-- POSSIBLE CLASSES: minified, fixed-ribbon, fixed-header, fixed-width
			 You can also add different skin classes such as "smart-skin-1", "smart-skin-2" etc...-->
		<?php
			if (!$no_main_header) {

		?>
				<!-- HEADER -->
				<header id="header">
					<div id="logo-group">

						<!-- PLACE YOUR LOGO HERE -->
						<span id="logo" style="margin-top: 0px;"> <img style="width: 150px;" src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="SmartAdmin"> </span>
						<!-- END LOGO PLACEHOLDER -->
							
						<!-- Note: The activity badge color changes when clicked and resets the number to 0
						Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
						<!-- <span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge"> 21 </b> </span>-->

						<!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->

						<!-- END AJAX-DROPDOWN -->
					</div>
					
					<!-- projects dropdown -->
					<div class="" style="width: 800px;">
						<h4 style="font-size: 28px; margin-left:15%; font-weight: bolder; color: #2001b4;">Warranty Management System (WMS)</h4>
					</div>
					<!-- end projects dropdown -->

					<!-- pulled right: nav area -->
					<div class="pull-right">

						<!-- collapse menu button -->
						<div id="hide-menu" class="btn-header pull-right">
							<span> <a href="javascript:void(0);" title="Collapse Menu" data-action="toggleMenu"><i class="fa fa-reorder"></i></a> </span>
						</div>
						<!-- end collapse menu -->

						<!-- #MOBILE -->
						<!-- Top menu profile link : this shows only when top menu is active -->
						<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
							<li class="">
								<a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 
									<img src="<?php echo ASSETS_URL; ?>/img/avatars/sunny.png" alt="John Doe" class="online" />
								</a>
								<ul class="dropdown-menu pull-right">
									<li>
										<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="profile.php" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="index.php" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
									</li>
								</ul>
							</li>
						</ul>

						<!-- logout button -->
						<div id="logout" class="btn-header transparent pull-right">
							<span> <a href="<?php echo APP_URL; ?>/index.php" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
						</div>
						<!-- end logout button -->



						<!-- fullscreen button -->
						<div id="fullscreen" class="btn-header transparent pull-right">
							<span> <a href="javascript:void(0);" title="Full Screen" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i></a> </span>
						</div>
						<!-- end fullscreen button -->
						
						<!-- #Voice Command: Start Speech -->
						<!-- end voice command -->
						
						<!-- multiple lang dropdown : find all flags in the flags page -->
											
						<!--<ul class="header-dropdown-list hidden-xs">
							<li>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
									<img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-us" alt="United States"> <span> English (US) </span> <i class="fa fa-angle-down"></i> </a>
								<ul class="dropdown-menu pull-right">
									<li class="active">
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-us" alt="United States"> English (US)</a>
									</li>
									<li>
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-fr" alt="France"> FranÃ§ais</a>
									</li>
									<li>
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-es" alt="Spanish"> EspaÃ±ol</a>
									</li>
									<li>
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-de" alt="German"> Deutsch</a>
									</li>
									<li>
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-jp" alt="Japan"> æ—¥æœ¬èªž</a>
									</li>
									<li>
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-cn" alt="China"> ä¸­æ–‡</a>
									</li>	
									<li>
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-it" alt="Italy"> Italiano</a>
									</li>	
									<li>
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-pt" alt="Portugal"> Portugal</a>
									</li>
									<li>
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-ru" alt="Russia"> Ð ÑƒÑ�Ñ�ÐºÐ¸Ð¹ Ñ�Ð·Ñ‹Ðº</a>
									</li>
									<li>
										<a href="javascript:void(0);"><img src="<?php echo ASSETS_URL; ?>img/blank.gif" class="flag flag-kp" alt="Korea"> í•œêµ­ì–´</a>
									</li>						
								</ul>
							</li>
						</ul>-->
						
						<!-- end multiple lang -->

					</div>
					<!-- end pulled right: nav area -->

				</header>
				<!-- END HEADER -->

				<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
				Note: These tiles are completely responsive,
				you can add as many as you like
				-->
				<div id="shortcut">
					<ul>
						<li>
							<a href="<?php echo APP_URL; ?>/inbox.php" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/calendar.php" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/gmap-xml.php" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/invoice.php" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/gallery.php" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
						</li>
						<li>
							<a href="<?php echo APP_URL; ?>/profile.php" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
						</li>
					</ul>
				</div>
				<!-- END SHORTCUT AREA -->

		<?php
			}
		?>