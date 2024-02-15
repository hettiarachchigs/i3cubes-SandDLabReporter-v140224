<?php
session_start();
//print_r($_SESSION);
if (!isset($_SESSION['UID']))
{
    header('Location: index');
}
//include_once 'class/fault_ticket_manager.php'; //GSH comented
//include_once 'class/seviceJobManager.php';  //GSH comented
//include_once 'class/repair_order_manager.php';  //GSH comented
include_once 'class/employee.php';
//
//print_r($_SESSION);
$ary_prev = $_SESSION['ROLE_PREV'];
//print_r($ary_prev);
//initilize the page




require_once("lib/config.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");
include("inc/header.php");
/* ---------------- PHP Custom Scripts ---------

  YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
  E.G. $page_title = "Custom Title" */

$page_title = "Home";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "ngs.css";


//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["dashboard"]["active"] = true;
include("inc/nav.php");

include_once 'class/reports.php';
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main" style="padding-bottom: 0px;">
    <?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
//include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">
        <div class="row" id="div_db">
           
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div id="div_db_jo" style="float: right;display: table-cell;">
                    <ul id="sparks" >

                        <?php
                        //$datemonth_fst = date("Y-m") . "-01 00:00:00";
                        //$datetoday1st = date("Y-m-d") . " 00:00:00";
                        //$datenow = date("Y-m-d") . " 23:59:59";

                        //$ft_rep_month = new reports();
                        //$ft_rep_month->summery_counts($datemonth_fst, $datenow, "fault_ticket");
                        ?>
                        <li class="sparks-info" style="height: 80px;max-height: 80px;text-align: center;">
                            <h5 style="text-align: center;">FT this month
                                <span style="text-align: center;">
                                    <table style="margin-left: auto; margin-right: auto;">
                                        <tr>
                                            <td style="font-size: 10px; padding-right: 8px;" align="right">Open</td>
                                            <td style="font-size: 10px; border-left: 1px solid black; padding-left: 8px;" align="left">Closed</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; padding-right: 8px;" align="right"><?= $ft_rep_month->tot_open ?></td>
                                            <td style="font-size: 12px; border-left: 1px solid black; padding-left: 8px;" align="left"><?= $ft_rep_month->tot_closed ?></td>
                                        </tr>
                                    </table>
                                </span></h5>
                        </li>
                        <li class="sparks-info" style="height: 80px;max-height: 80px;text-align: center;">
                            <h5>FT Status 
                                <span style="text-align: center;">
                                    <?php
                                    //$ft_rep_today = new reports();
                                    //$ft_rep_today->summery_counts($datetoday1st, $datenow, "fault_ticket");
                                    ?> 
                                    <table style="margin-left: auto; margin-right: auto;">
                                        <tr>
                                            <td style="font-size: 10px; padding-right: 8px;" align="right">Open</td>
                                            <td style="font-size: 10px; border-left: 1px solid black; padding-left: 8px;" align="left">Pending</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px;padding-right: 8px;" align="right"><?= $ft_rep_today->tot_open ?></td>
                                            <td style="font-size: 12px; border-left: 1px solid black; padding-left: 8px;" align="left"><?= $ft_rep_today->tot_pending ?></td>
                                        </tr>
                                    </table>
                                </span></h5>
                        </li>
<!--                        <li class="sparks-info" style="height: 80px;max-height: 80px;text-align: center;">
                            <h5>AMC Expiring
                                <span style="text-align: center;">
                                    <table style="margin-left: auto; margin-right: auto;">
                                        <tr>
                                            <td style="font-size: 10px; padding-right: 8px;" align="right">this month</td>
                                            <td style="font-size: 10px; border-left: 1px solid black; padding-left: 8px;" align="left">next month</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px;padding-right: 8px;" align="right">20</td>
                                            <td style="font-size: 12px; border-left: 1px solid black;padding-left: 8px;" align="left">18</td>
                                        </tr>
                                    </table>
                                </span></h5>
                        </li>-->
<!--                        <li class="sparks-info" style="height: 80px;max-height: 80px;text-align: center;">
                            <h5>AMC Service - this month
                                <span style="text-align: center;">
                                    <table style="margin-left: auto; margin-right: auto;">
                                        <tr>
                                            <td style="font-size: 10px; padding-right: 8px;" align="right">Schedule</td>
                                            <td style="font-size: 10px; border-left: 1px solid black; padding-left: 8px;" align="left">Completed</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px;padding-right: 8px;" align="right">89</td>
                                            <td style="font-size: 12px; border-left: 1px solid black; padding-left: 8px;" align="left">63</td>
                                        </tr>
                                    </table>
                                </span></h5>
                        </li>-->
                    </ul>
                </div>
            </div>
        </div>
        <!-- widget grid -->
        <section id="widget-grid" class="">
            <!-- row -->

            <div class="row">

                <article class="col-sm-12 col-md-12 col-lg-3">

<style>
                canvas {
                    /*border: 1px dotted red;*/
                }

                .chart-container {
                  /* position: relative;
                    margin: auto;
                    height: 10vh;
                   // width: 550px;*/
                }

            </style>

                </article>
                <article class="col-sm-12 col-md-2 col-lg-6">
                    <!--<article class="col-sm-12 col-md-12 col-lg-12">-->
                    <div>
                        <canvas id="myChart" style="background: #FFF;opacity: 1; color: red;height: 250px"></canvas>
                    </div>
                    <!--</article>-->
                </article>
                <!-- ============================= -->

                <article class="col-sm-12 col-md-12 col-lg-3">
                    <div class="row">

                    </div>
                </article>
            </div>
            
            <div class="row" >

            </div>
            <div class="row"style="margin-top: 50px;">
                <article class="col-sm-12 col-md-12 col-lg-12" id="sub-charts">

                </article>
            </div>

            <!-- end row -->

        </section>
        
        <!-- end widget grid -->


    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>

<style type="text/css" >
    .txt-color-orangeDark {
    color: #3e34b5 !important;
}
    
</style>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.cust.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- Full Calendar -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>

<script type="text/javascript" src="jeegoopopup/jquery.jeegoopopup.1.0.0.js"></script>
<link href="jeegoopopup/skins/blue/style.css" rel="Stylesheet" type="text/css" />
<link href="jeegoopopup/skins/round/style.css" rel="Stylesheet" type="text/css" />
<script src="js/chart.js"></script>
<script src="js/chartUtils.js"></script>
<script src="js/chartjs-plugin-datalabels.js"></script>
<script src="js/chart2.4.min.js"></script>

<script>
    checkUser('<?php print $_SESSION['UID'] ?>');

    $(document).ready(function () {
        var h = $(document).height();
        var cont_h = h - $('#header').height() - $('.page-footer').height();
        $('#content').height(cont_h);
        $('body').css('height','auto');
        /*
         * PAGE RELATED SCRIPTS
         */

        $(window).resize(function () {
            var h = $(document).height();
            var cont_h = h - $('#header').height() - $('.page-footer').height();
            $('#content').height(cont_h);
        });
        chart("","");
    });
  
function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }    
function chart(data,container){
   
    $.post("ajax/ajx_report",{SID:200},function (response){
        //$.each(response,function(index,data){
            
        //});
        
        var subchart = response['sub'];
        //getRandomColor()
        var color = [];
        creartChart(response,container);
        // console.log(Object.keys(subchart).length);
        if(Object.keys(subchart).length >0){
          createOtherChart(subchart);
        }
        
    },"JSON");
}
function creartChart(response,container,colorarr){
    var randomColor = {};
    var piecolor =[];
    var lable = response[0].allLable.split(",");
    
    var data = response[1].allData.split(",");
    /*$.each(lable,function (index,labledata){
                var getRandomColors = getRandomColor()
                 randomColor[labledata] =getRandomColors ;
                 piecolor.push(getRandomColors);
            })*/
   //
   
   if (localStorage.getItem("chartColor-LEO") === null  ) {
        //...'rgb(255, 99, 132)',
          var colorarr = {
              'Default':'rgb(255, 99, 132)',
              'Western Province':'rgb(255, 192, 0)',
              'Southern Province':'rgb(179, 255, 64)',
              'Central Province':'rgb(255, 160, 160)',
              'North-Central Province':'rgb(255, 255, 144)',
              'Sabaragamu Province':'rgb(255, 128, 192)',
              'North Western - KRG / PUT':'rgb(112, 160, 255)',
              'Eastern Province':'rgb(128, 128, 0)',
              'Northern Provice':'rgb(255, 148, 112)',
              'UVA Province':'rgb(0, 240, 240)',
              'Test':'rgb(229, 229, 229)'
          };
          $.each(lable,function (index,labledata){
                var getRandomColors = getRandomColor()
                 randomColor[labledata] =colorarr[labledata] ;
                 //console.log("Lable" + " - "+labledata);
            })
          localStorage.setItem("chartColor-LEO",JSON.stringify(randomColor));
  
    }else {
            var selectedcolor = JSON.parse(localStorage.getItem("chartColor-LEO"));
            randomColor=selectedcolor
            //console.log(Object.keys(selectedcolor).length+", "+lable.length);
            //console.log(randomColor);
               if(Object.keys(selectedcolor).length == lable.length){
                    

               }else {
                   
                    $.each(lable,function (index,labledata){
                        
                        var getRandomColors = getRandomColor()
                        //randomColor[labledata] =getRandomColors ;
                        //piecolor.push(getRandomColors);
                        if(selectedcolor.hasOwnProperty(labledata)){
                            //has key
                            //console.log(labledata);
                            if(selectedcolor[labledata]==""){
                                //add color
                                randomColor[labledata] =getRandomColors ;
                                //localStorage.setItem("chartColor",JSON.stringify(randomColor));
                            }

                        }else {
                            //no key'rgb(229, 229, 229)'
                            if(labledata =="REPAIR CENTER"){
                                randomColor[labledata] ='rgb(229, 229, 229)' ;
                            }else{
                             randomColor[labledata] =getRandomColors ;
                         }
                             //randomColor.push(getRandomColors)
                             //console.log(randomColor);
                             
                        }

                })
                localStorage.setItem("chartColor-LEO",JSON.stringify(randomColor));
               }
               
}
//console.log(randomColor);
var selectedcolor = JSON.parse(localStorage.getItem("chartColor-LEO"));
 $.each(selectedcolor,function (index,color){
     piecolor.push(color);
 })
 //var backgroundColor = piecolor.split(",")

    var pieOptions = {
  events: false,
  layout: {
            padding: {
                bottom: 10
            }
        },
  animation: {
    duration: 500,
    easing: "easeOutQuart",
    onComplete: function () {
      var ctx = this.chart.ctx;
      ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
      ctx.textAlign = 'center';
      ctx.textBaseline = 'bottom';

      this.data.datasets.forEach(function (dataset) {

        for (var i = 0; i < dataset.data.length; i++) {
          var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
              total = dataset._meta[Object.keys(dataset._meta)[0]].total,
              mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius)/2,
              start_angle = model.startAngle,
              end_angle = model.endAngle,
              mid_angle = start_angle + (end_angle - start_angle)/2;

          var x = mid_radius * Math.cos(mid_angle);
          var y = mid_radius * Math.sin(mid_angle);

          ctx.fillStyle = '#fff';
          if (i == 3){ // Darker text color for lighter background
            ctx.fillStyle = '#444';
          }
          var percent = String(Math.round(dataset.data[i]/total*100)) + "%";      
          //Don't Display If Legend is hide or value is 0
          if(dataset.data[i] != 0 && dataset._meta[0].data[i].hidden != true) {
            ctx.fillText(dataset.data[i], model.x + x, model.y + y);
            // Display percent in another line, line break doesn't work for fillText
            ctx.fillText(percent, model.x + x, model.y + y + 15);
          }
        }
      });               
    }
  }
};
    var allChartData ={
        labels: lable,
        labelAlign: 'center',
        datasets: [{
           label: 'Pending/Open Tickets',
            data:data,
            backgroundColor: piecolor,
    borderColor: "rgba(255,99,132,1)",
            borderWidth: 0
        }]
    } 
    var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: allChartData,
    options: pieOptions
    /*options: {
        scales: {
            y: {
                beginAtZero: true
            },
            xAxes: [{
            barPercentage: 0.3
        }]
        },
        animation: {
        //duration: 100,
        onComplete: function () {
                var chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                        ctx.textAlign = 'center';
                        ctx.fillStyle = "rgba(0, 0, 0, 1)";
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function (bar, index) {
                                        var data = dataset.data[index];
                                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                        });
                }
        },
        showLines: false,
        legend: {
          display: false
        },//plugins: {
                  title: {
                      display: true,
                      text: 'Pending/Open Tickets'
                  }
              //}
    }*/
});
}
function createOtherChart(response){
    
    //console.log(response);
    var subarticlecontainer = $('#sub-charts');
    var chart_container ="";
    var canvas = "";
    $.each(response,function(index,data){
        var count = data.data;
        var lable1 = data.lable;
        var container = "<div style='margin-bottom:20px;' class=\"col-sm-6 col-md-6 col-lg-6\"><div class=\"chart-container\"><canvas id=\"myChart"+index+"\" style=\"background: #FFF;opacity: 0.8; color: red\"></canvas></div></div>";
        var sumofcount = 0;
        var data = count;
       $.each(count,function(ind,val){
           sumofcount += parseInt(val);
           //console.log(index+ " " +sumofcount);
       });
        if(data.length=="0"){}else {
        subarticlecontainer.append(container);
        var selectedcolor = JSON.parse(localStorage.getItem("chartColor-LEO"));
       var bar_color = [];
        //console.log(index + "   "+selectedcolor[index]);
        var lable = lable1;
        $.each(lable,function(ind,d){
            if(d=="REPAIR CENTER"){
                bar_color.push(selectedcolor['REPAIR CENTER']);
            }else {
                bar_color.push(selectedcolor[index]);
            }
                
        })
        
        console.log();
         var allChartData ={
        labels: lable,
        datasets: [{
           label: index+' Pendings/Open Tickets '+sumofcount,
            data:data,
            backgroundColor: bar_color,
            borderColor: "rgba(255,99,132,1)",
            borderWidth: 0
        }]
        } ;
        var id = 'myChart'+index;
        
        var ctx = document.getElementById(id).getContext('2d');
        var myChart = new Chart(ctx, {
    type: 'bar',
    data: allChartData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            },
            xAxes: [{
            barPercentage: 0.3
        }]
        },
        layout: {
            padding: {
                bottom: 15,
                top:10
            }
        },
        animation: {
        //duration: 100,
        onComplete: function () {
                var chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                        ctx.textAlign = 'center';
                        ctx.fillStyle = "rgba(0, 0, 0, 1)";
                        ctx.textBaseline = 'bottom';
                        this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function (bar, index) {
                                        var data = dataset.data[index];
                                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                        });
                }
        },
        showLines: false,
  legend: {
          display: false
        },//plugins: {
                  title: {
                      display: true,
                      text: index+' Pending/Open Tickets - '+sumofcount,
                      font: {
          size: 30
        }
                      
                  }
           
    }
});
    
        }   
    });
    /*
                    
                    */
}
</script>

<?php
//include footer
?>