		<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
		<aside id="left-panel">

			<!-- User info -->
			<div class="login-info">
				<span style="color: blueviolet;text-align: center;padding-top: 10px;"> <!-- User image size is adjusted inside CSS, it should stay as is -->  
                                    
                                            <?php print $_SESSION['USERNAME']?> 
                                    
					
				</span>
			</div>
			<!-- end user info -->

			<!-- NAVIGATION : This navigation is also responsive

			To make this navigation dynamic please make sure to link the node
			(the reference to the nav > ul) after page load. Or the navigation
			will not initialize.
			-->
			<nav>
				<!-- NOTE: Notice the gaps after each icon usage <i></i>..
				Please note that these links work a bit different than
				traditional hre="" links. See documentation for details.
				-->
				<ul>
					<?php //print_r($page_nav);
						foreach ($page_nav as $key => $nav_item) {
							//process parent nav
							$nav_htm = '';
							$url = isset($nav_item["url"]) ? $nav_item["url"] : "#";
							$url_target = isset($nav_item["url_target"]) ? 'target="'.$nav_item["url_target"].'"' : "";
							$icon_badge = isset($nav_item["icon_badge"]) ? '<em>'.$nav_item["icon_badge"].'</em>' : '';
							$icon = isset($nav_item["icon"]) ? '<i class="fa fa-lg fa-fw '.$nav_item["icon"].'">'.$icon_badge.'</i>' : "";
							$nav_title = isset($nav_item["title"]) ? $nav_item["title"] : "(No Name)";
							$label_htm = isset($nav_item["label_htm"]) ? $nav_item["label_htm"] : "";
							$nav_htm .= '<a href="'.$url.'" '.$url_target.' title="'.$nav_title.'">'.$icon.' <span class="menu-item-parent">'.$nav_title.'</span>'.$label_htm.'</a>';

							if (isset($nav_item["sub"]) && $nav_item["sub"])
								$nav_htm .= process_sub_nav($nav_item["sub"]);

							echo '<li '.(isset($nav_item["active"]) ? 'class = "active"' : '').'>'.$nav_htm.'</li>';
						}

						function process_sub_nav($nav_item) {
							$sub_item_htm = "";
							if (isset($nav_item["sub"]) && $nav_item["sub"]) {
								$sub_nav_item = $nav_item["sub"];
								$sub_item_htm = process_sub_nav($sub_nav_item);
							} else {
								$sub_item_htm .= '<ul>';
								foreach ($nav_item as $key => $sub_item) {
									$url = isset($sub_item["url"]) ? $sub_item["url"] : "#";
									$url_target = isset($sub_item["url_target"]) ? 'target="'.$sub_item["url_target"].'"' : "";
									$icon = isset($sub_item["icon"]) ? '<i class="fa fa-lg fa-fw '.$sub_item["icon"].'"></i>' : "";
									$nav_title = isset($sub_item["title"]) ? $sub_item["title"] : "(No Name)";
									$label_htm = isset($sub_item["label_htm"]) ? $sub_item["label_htm"] : "";
									$sub_item_htm .= 
										'<li '.(isset($sub_item["active"]) ? 'class = "active"' : '').'>
											<a href="'.$url.'" '.$url_target.'>'.$icon.' '.$nav_title.$label_htm.'</a>
											'.(isset($sub_item["sub"]) ? process_sub_nav($sub_item["sub"]) : '').'
										</li>';
								}
								$sub_item_htm .= '</ul>';
							}
							return $sub_item_htm;
						}


					?>
				</ul>

			</nav>
                        <style type="text/css" >
                            .minifyme {
                            border-bottom: 1px solid #302F2F;
                            background: #225699;
                            color: #0C0C0C;
                            text-align: center;
                            padding: 0;
                            width: 36px;
                            height: 28px;
                            display: block;
                            position: absolute;
                            right: -3px;
                            border-radius: 5px 0 0 5px;
                            cursor: pointer;
                            margin-top: 5px;
                            font-size: 19px;
                            transition: all .1s linear 0s;
                        }
                        </style>
                        
			<span class="minifyme" id="mm" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>

		</aside>
		<!-- END NAVIGATION -->