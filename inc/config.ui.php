<?php

session_start();

include_once '../class/employee.php';

$ary_prev = $_SESSION['USER_PREV'];
//print_r($_SESSION);
$emp = new employee($_SESSION['EMPID']);
//$ary_team = $emp->getTeam();

//array("Display Name" => "URL");
$breadcrumbs = array(
    "Home" => APP_URL
);

$total_test_count =0; //to be used in future


$ary_navi = array("dashboard" => array(
        "title" => "Home",
        "url" => APP_URL . "/home",
        "icon" => "fa-home"
        ));
$ary_main_inbox = array("inbox" => array(
        "title" => "Inbox",
        "icon" => "fa fa-inbox",
        "url" =>APP_URL."/inbox",
        "label_htm" => '<span class="badge pull-right inbox-badge" style="margin-right: 10px;">' . $total_test_count . '</span>',
        ));
$ary_navi = array_merge($ary_navi, $ary_main_inbox);

$ary_main_ft = array("tests" => array(
        "title" => "Tests",
        "icon" => "fa fa-flask",
        "sub" => array(
            "view" => array(
                "title" => "View",
                "url" => APP_URL . "/tests/tests_view"
            ),    
        )
));
$ary_navi = array_merge($ary_navi, $ary_main_ft);

$ary_main_store = array("sample" => array(
        "title" => "Samples",
        "icon" => "fa fa-database",
        "sub" => array(
            "stock" => array(
                "title" => "Stock",
                "url" => APP_URL . "/inventory/inventory_view"
            ),
            "item" => array(
                "title" => "Product",
                "url" => APP_URL . "/inventory/item_view"
            ),
            "location" => array(
                "title" => "Store Location",
                "url" => APP_URL . "/inventory/store_location_view"
            )
        )
        ));
$ary_navi = array_merge($ary_navi, $ary_main_store);

$ary_main_repo = array("reports" => array(
        "title" => "Reports",
        "icon" => "fa fa-line-chart",
        "sub" => array(
            "faultticket" => array(
                "title" => "Test Summary",
                "target" => "_blank",
                "url" => APP_URL . "/stat/group_summary"
            )
        )
        ));
        
if ($ary_prev[1][0] == '1') {
    $ary_navi = array_merge($ary_navi, $ary_main_repo);
}


$ary_main_cus = array("cus" => array(
        "title" => "Customer",
        "icon" => "fa fa-address-card ",
        "url" => APP_URL . "/customer/view"
        ));
if ($ary_prev[1][0] == '1') {
    $ary_navi = array_merge($ary_navi, $ary_main_cus);
}


$ary_my_acc = array("acc" => array(
        "title" => "My Account",
        "icon" => "fa fa-user",
        "sub" => array(
            "gr" => array(
                "title" => "Change Password",
                "url" => APP_URL . "/change_ps"
            ),
            "grm" => array(
                "title" => "My Group",
                "url" => APP_URL . "/user/groupview"
            )
        )
        ));

$ary_navi = array_merge($ary_navi, $ary_my_acc);

$ary_main_rep = array("user" => array(
        "title" => "Administrator",
        "icon" => "fa fa-cog",
        "sub" => array(
            "gr" => array(
                "title" => "Group",
                "url" => APP_URL . "/user/my_group"
            ),
            "us" => array(
                "title" => "User",
                "url" => APP_URL . "/user/view"
            )
            /*,"sy" => array(
                "title" => "System",
                "url" => APP_URL . "/system/systemview"
            ),*/
           /* "rosy" => array(
                "title" => "System RO",
                "url" => APP_URL . "/rosystem/systemview"
            )*/
        )
        ));
if ($ary_prev[2][0] == '1') {
    $ary_navi = array_merge($ary_navi, $ary_main_rep);
}

//GSH added new code for employee mgt
$ary_main_emp = array("user" => array(
    "title" => "User",
    "icon" => "fa fa-user",
    "sub" => array(
        "view" => array(
            "title" => "View",
            "url" => APP_URL . "/user/view"
        ), 
    /*    "add" => array(
            "title" => "Add New",
            "url" => APP_URL . "/user/add"
        ),
        "delete" => array(
            "title" => "Delete Employee",
            "url" => APP_URL . "/user/delete"
        )   */    )
));
if ($ary_prev[1][0] == '1' or 1 == 1) {
    $ary_navi = array_merge($ary_navi, $ary_main_emp);
}

$page_nav = $ary_navi;
//print_r($page_nav);
//configuration variables
$page_title = "";
$page_css = array();
$no_main_header = false; //set true for lock.php and login.php
$page_body_prop = array(); //optional properties for <body>
$page_html_prop = array(); //optional properties for <html>
?>