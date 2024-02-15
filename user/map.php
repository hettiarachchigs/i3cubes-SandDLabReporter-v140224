<?php
session_start();
if (!isset($_SESSION['UID'])) {
    header('Location: ../index');
}
$ary_prev = $_SESSION['USER_PREV'];

//initilize the page
require_once("../lib/config.php");

//require UI configuration (nav, ribbon, etc.)
//require_once("/inc/config.ui.php");

/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Fault Ticket";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
//$page_css[] = "your_style.css";
include("../ngs/header_ngspopup.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
//$page_nav["forms"]["sub"]["smart_layout"]["active"] = true;
//include("/inc/nav.php");

include_once '../class/fault_ticket.php';
include_once '../class/fault_ticket_manager.php';
include_once '../class/employee.php';
include_once '../class/functions.php';
include_once '../class/amc.php';
include_once '../class/warranty.php';
include_once '../class/customer.php';
include_once '../class/customerEntity.php';
include_once '../class/customerManager.php';
include_once '../class/team.php';
include_once '../class/branch.php';
include_once '../class/logs.php';
$log = new logs();
include_once '../class/cls_expenses.php';
$expenses = new expenses_manager();
//print_r($_POST);
$tid = $_REQUEST['tid'];
$emp_id = $_REQUEST[$_SESSION['UID']];
if(!isset($_REQUEST['lat']) || !isset($_REQUEST['lon']) || $_REQUEST['lat']=="" || $_REQUEST['lon']==""){
    print "ERROR";
    exit();
}
$lat = $_REQUEST['lat'];
$lon = $_REQUEST['lon'];
?>
<link href="../css/summernote-lite.css" rel="stylesheet">
<style>
    .txt_error {
        border : 1px red solid !important;
    }
</style>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="margin-left: 5px;">
    <?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Forms"] = "";
//include("/inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="widget-body">
            <section id="widget-grid-fte-m" class="">
                <div class="row">
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div role="widget" style="" class="jarviswidget" id="wid-id-fte-1"
                             data-widget-colorbutton="false"	
                             data-widget-editbutton="false"
                             data-widget-togglebutton="false"
                             data-widget-deletebutton="false"
                             data-widget-fullscreenbutton="false"
                             data-widget-custombutton="false"
                             data-widget-collapsed="false" 
                             data-widget-sortable="false">
                            <header role="heading">
                                <h2 style="width: 99%;">
                                   
                                    
                                </h2>
                            </header>

                            <!-- widget div-->
                            <div role="content">

                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="tab-content padding-10">
                                    <div class="tab-pane active" id="tab_0">
                                        <section id="widget-grid-fte-m" class="">            
                                            <!--<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">-->
                                                <div class="row">
                                                    
                                                    <section class="col-sm-12 col-md-12 col-lg-12">
                                                      <div class="col-md-12 modal_body_map" style="top:10px; right:-20px">
                <div class="location-map" id="location-map">
                    <div style="height: 450px;" id="map_canvas"></div>
                </div>
            </div>
                                                    </section>
                                    </div>


                                            <!--</article>-->
                                        </section>
                                       
                                         <section id="widget-grid-fte-s" class="">
                                                <div class="row">
                                                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                      
                                                    </article>
                                                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                      
                                                    </article>
                                                </div>
            </section>
                                        <!--End Ft section updates-->
                                    </div>
                                       
                                    </div>
                                    
                                </div>
                                <!-- end widget content -->

                            </div>
                            <!-- end widget div -->

                        </div>
                    </article>
                </div>
            </section>
           
        </div>



    </div>
    <!-- END MAIN CONTENT -->
</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<script src="../js/summernote-lite.js"></script>
<script src="../js/dropzone.js"></script>
<?php
// include page footer

include("../inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("../inc/scripts.php");
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBG9B3zdoqLsxv2ZApP_gk2vPy5O6WBQW0&libraries=places"> </script>
<script>
    var latlngbounds = new google.maps.LatLngBounds( );
$(document).ready(function(){
    checkUser("<?php print $_SESSION['UID'] ?>")
    initializeGMap("");
})
  

    function initializeGMap(id) {
            infowindow1 = new google.maps.InfoWindow();
            geocoder = new google.maps.Geocoder();
            /*var icon = {
                url: 'https://mts.googleapis.com/vt/icon/name=icons/spotlight/spotlight-waypoint-a.png&text=A&psize=16&font=fonts/Roboto-Regular.ttf&color=ff333333&ax=44&ay=48&scale=1',
                // This marker is 20 pixels wide by 32 pixels tall.
                size: new google.maps.Size(40, 40),
                // The origin for this image is 0,0.
                origin: new google.maps.Point(0, 0),
                // The anchor for this image is the base of the flagpole at 0,32.
                anchor: new google.maps.Point(20, 40)
            };*/
            //var lat = $('#dev_lat').val();
            //var lng = $('#dev_lng').val();
            var lat = "<?php print $lat ?>";
            var lng = "<?php print $lon ?>";
            if (lat == "" || lng == "") {
                var mapOptions = {
                    center: {lat: 32.2285853, lng: 34.8257488},
                    zoom: 16
                };
            } else {
                console.log(lat + "  " + lng);
                var mapOptions = {
                    center: {lat: parseFloat(lat), lng: parseFloat(lng)},
                    zoom: 16
                };
            }
            console.log(mapOptions);
            map1 = new google.maps.Map(document.getElementById('map_canvas'),
                    mapOptions);


            if (lat != "" && lng != "") {
//                
                deviceplace = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
                window.setTimeout(function () {
                    marker1 = new google.maps.Marker({
                        position: deviceplace,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        map: map1,
                        //icon: icon

                    });
                    google.maps.event.addListener(marker1, 'dragend', function (event) {
                        // console.log('drag End')
                        $('#dev_lat').val(event.latLng.lat());
                        $('#dev_lng').val(event.latLng.lng());
                        ///changeLoc(event.latLng.lat(), event.latLng.lng(), id);
                        geocoder.geocode({
                            'latLng': event.latLng
                        }, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {

                                if (results[1]) {
                                    $('#location').val(results[0].formatted_address);
                                    //alert(results[0].formatted_address);
                                } else {
                                    alert('No results found');
                                }
                            } else {
                                alert('Geocoder failed due to: ' + status);
                            }
                        });
                    });
                    marker1.setMap(map1);
                    latlngbounds.extend(marker1.getPosition());
//                if (bound) {
//                    map1.fitBounds(latlngbounds);
//                    map1.setCenter(latlngbounds.getCenter());
//                    map.panToBounds(latlngbounds);
//                } else {
                    ///// console.log('false');
//                }
                }, 100);



            } else {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        //initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        //map1.setCenter(initialLocation);
//                        console.log(initialLocation);
                    })
                }
                ;
                /*google.maps.event.addListener(map1, 'click', function (event) {
                    placeMarker(event.latLng);
                    $('#dev_lat').val(event.latLng.lat());
                    $('#dev_lng').val(event.latLng.lng());
                    geocoder.geocode({
                        'latLng': event.latLng
                    }, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {

                            if (results[1]) {
                                $('#location').val(results[0].formatted_address);
                                //alert(results[0].formatted_address);
                            } else {
                                alert('No results found');
                            }
                        } else {
                            alert('Geocoder failed due to: ' + status);
                        }
                    });
                    if (infowindow) {
                        infowindow.close();
                    }

                });*/
            }


        }
</script>