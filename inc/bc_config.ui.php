<?php
//CONFIGURATION for SmartAdmin UI



//ribbon breadcrumbs config
//array("Display Name" => "URL");
$breadcrumbs = array(
	"Home" => APP_URL
);

/*navigation array config

ex:
"dashboard" => array(
	"title" => "Display Title",
	"url" => "http://yoururl.com",
	"url_target" => "_self",
	"icon" => "fa-home",
	"label_htm" => "<span>Add your custom label/badge html here</span>",
	"sub" => array() //contains array of sub items with the same format as the parent
)

*/


$ary_navi=array("dashboard" => array(
		"title" => "Dashboard",
		"url" => APP_URL."/home.php",
		"icon" => "fa-line-chart"
	));
$ary_issue=array("issue" => array(
	"title" => "Issue",
	"url" => APP_URL."/bc_issue_item.php",
	"icon" => "fa-inbox"
));
$ary_navi=array_merge($ary_navi,$ary_issue);

$ary_main_receive=array("return" => array(
	"title" => "Receive",
	"url" => APP_URL."/bc_return.php",
	"icon" => "fa-inbox"
));
$ary_navi=array_merge($ary_navi,$ary_main_receive);

$ary_main_item=array("inventry" => array(
	"title" => "Invenrty",
	"icon" => "fa-inbox",
	"sub" => array(
				"add" => array(
					"title" => "Add",
					"url" => APP_URL."/bc_add_product_item.php"
				),
				"search" => array(
					"title" => "Search",
					"url" => APP_URL."/bc_inventory_search.php"
				)
				
			)
));
$ary_navi=array_merge($ary_navi,$ary_main_item);

$ary_main_product=array("product" => array(
	"title" => "Product",
	"icon" => "fa-inbox",
	"sub" => array(
				"add" => array(
					"title" => "Add",
					"url" => APP_URL."/bc_register_product.php"
				),
				"search" => array(
					"title" => "Search",
					"url" => APP_URL."/bc_product_search.php"
				)
				
			)
));
$ary_navi=array_merge($ary_navi,$ary_main_product);

$page_nav = $ary_navi;
//print_r($_SESSION);
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>