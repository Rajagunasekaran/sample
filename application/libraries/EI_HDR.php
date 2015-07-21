<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--TO SUPPORT JQUERY FUNCTIONALITIES-->
    <script src="<?php echo base_url().'JS/jquery.2.1.3.min.js'?>"></script>
    <!--TO SUPPORT JQUERY UI FUNCTIONALITIES-->
    <script src="<?php echo base_url().'JS/jquery.1.11.3.ui-min.js'?>"></script>
    <script src="<?php echo base_url().'JS/jquery-migrate-1.2.1.min.js'?>"></script>
    <!--TO SUPPORT JQUERY LIB VALIDATION-->
    <script src="<?php echo base_url().'JS/JQuery.js'?>"></script>
    <script src="<?php echo base_url().'JS/datepickerjs.js'?>"></script>
    <script src="<?php echo base_url().'JS/jquery-ui-timepicker-addon.js'?>"></script>
    <script src="<?php echo base_url().'JS/SetCase.js'?>"></script>
    <!--TO SUPPORT CSS-->
    <link rel="stylesheet" href ="<?php echo base_url().'CSS/jquery-ui-1.11.0.css'?>"  />
    <!--TO SUPPORT BOOTSTRAP CSS-->
    <link rel="stylesheet" href ="<?php echo base_url().'bootstrap/CSS/bootstrap.css'?>"  />
    <link rel="stylesheet" href ="<?php echo base_url().'bootstrap/CSS/bootstrap.min.css'?>"  />
    <link rel="stylesheet" href ="<?php echo base_url().'bootstrap/CSS/bootstrap-responsive.css'?>"  />
    <link rel="stylesheet" href ="<?php echo base_url().'bootstrap/CSS/bootstrap-responsive.min.css'?>"  />
    <link rel="stylesheet" href ="<?php echo base_url().'bootstrap/img/glyphicons-halflings.png'?>"  />
    <link rel="stylesheet" href ="<?php echo base_url().'bootstrap-datetimepicker.css'?>"  />
    <link rel="stylesheet" href ="<?php echo base_url().'bootstrap/CSS/bootstrap-datetimepicker.min.css'?>"  />
    <!--TO SUPPORT BOOTSTRAP JQUERY FUNCTIONALITIES-->
    <script src="<?php echo base_url().'bootstrap/JS/bootstrap.js'?>"></script>
    <script src="<?php echo base_url().'bootstrap/JS/bootstrap.min.js'?>"></script>
    <script src="<?php echo base_url().'JS/moment-with-locales.js'?>"></script>
    <script src="<?php echo base_url().'bootstrap/JS/bootstrap-datetimepicker.js'?>"></script>
    <script src="<?php echo base_url().'bootstrap/JS/bootstrap-datetimepicker.min.js'?>"></script>
    <!--Message box-->
    <link rel="stylesheet" href ="<?php echo base_url().'msgbox/jquery-confirm.css'?>"  />
    <script src="<?php echo base_url().'msgbox/jquery-confirm.js'?>"></script>

    <link rel="stylesheet" href ="<?php echo base_url().'CSS/StyleSheet.css'?>"  />

    <link rel="stylesheet" href="<?= base_url();?>Data_table/media/css/jquery.dataTables.css">
    <link rel="stylesheet" href="<?= base_url();?>Data_table/media/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="<?= base_url();?>Data_table/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url();?>Data_table/media/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="<?= base_url().'Data_table/media/css/colreorder.css'?>">
    <script type="text/javascript" src="<?= base_url().'Data_table/media/js/colreorder.js'?>"></script>
    <script src="<?php echo base_url().'Data_table/media/js/dataTables.scroller.js'?>"></script>
    <link rel="stylesheet" href ="<?php echo base_url().'Data_table/media/css/dataTables.scroller.css'?>"  />

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <link rel="shortcut icon" type="image/ico" href ="<?php echo base_url().'images/eifevicon.ico'?>"  />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
    <title>EXPATS INTEGRATED CRM DEV</title>
    <style>
        .dropdown-menu{
            font-size: 8px;
        }
        tr.row_selected td{
            background-color:#C4C4C4 !important;
        }
    </style>
    <script type="text/javascript">
        // function for graphics chart
        function drawChart(twoarr,CHART_errormsg,CHART_linebar) {
            var data = google.visualization.arrayToDataTable(twoarr);
            var options = {
                'title': CHART_errormsg,'width':'100%','height':'100%'
            };
            if((CHART_linebar==10)||(CHART_linebar==22)||(CHART_linebar==27)||(CHART_linebar==18)||(CHART_linebar==16)){
                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            }
            else{
                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            }
            chart.draw(data, options);
        }
        google.load('visualization', '1.0', {packages:['corechart']});
        google.setOnLoadCallback(drawChart);
        // function for data table chart
        function drawTable(twodim,arr1,arr2){
            var data = new google.visualization.DataTable();
            for(var i=0;i<twodim[0].length;i++){
                data.addColumn(arr1[i],arr2[i]);
            }
            data.addRows(twodim);
            var table = new google.visualization.Table(document.getElementById('chart_tablediv'));
            table.draw(data, {showRowNumber: true});
        }
        google.load('visualization', '1.0', {packages:['table']});
        google.setOnLoadCallback(drawTable);
    </script>
</head>
<html>
<!--HEAD TAG START-->