<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    }
    .chart{
        width:100%;
        height:60%;
        margin:auto;
        background:#fff;
        text-align:center;
    }
</style>
<script type="text/javascript">
// document ready function
$(document).ready(function(){
    var ctrl_charts_url="<?php echo site_url('REPORT/Ctrl_Report_Charts'); ?>";
// initial data
    $('#spacewidth').height('0%');
    var chartname;
    var unit;
    var errormsg;
    $.ajax({
        type: "POST",
        url: ctrl_charts_url+'/Initialdata',
        data:{'ErrorList':'387,388,389,390,391,392,393,394'},
        success: function(data){
            var value=JSON.parse(data);
            chartname=value[0];
            unit=value[1];
            errormsg=value[2];
            if(chartname!=''){
                $('#chart_lb_name').append($('<option> SELECT </option>'));
                for(var i=0;i<chartname.length;i++)
                {
                    var nameid=chartname[i].CGN_ID;
                    var namedata=chartname[i].CGN_TYPE;
                    $('#chart_lb_name').append($('<option>').text(namedata).attr('value', nameid));
                }
            }
            if(unit!=''){
                $('#chart_lb_unit').append($('<option> SELECT </option>'));
                for(var k=0;k<unit.length;k++)
                {
                    var data=unit[k].UNIT_NO;
                    $('#chart_lb_unit').append($('<option>').text(data).attr('value', data));
                }
            }
            $('.preloader').hide();
            $('#chart_lb_name').focus();
        },
        error:function(data){
            var errordata=(JSON.stringify(data));
            show_msgbox("CHARTS",errordata,'error',false);
            $('.preloader').hide();
        }
    });
// date picker and prepare input
    var chart_fromdate='';
    var chart_periodfromdate='';
    var chart_todate='';
    var chart_periodtodate='';
    var chart_monthdate='';
    var chart_flag_chart=0;
    var chart_monthBefore='';
    var chart_yearBefore='';
    var chart_periodmonthBefore='';
    var chart_periodyearBefore='';
    var chart_db_dataId=null;
    function CHART_datepicker(){
        $(function() {
            $('.date-picker').datepicker({
                changeMonth: true, changeYear: true,showButtonPanel: true,dateFormat: 'MM-yy', minDate: new Date(2005, 0,1), maxDate:  new Date(),
                onClose: function(dateText, inst) {
                    $("#chart_errmsgdiv,#chart_div,#chart_tablediv").empty();
                    var month =inst.selectedMonth;
                    var year = inst.selectedYear;
                    $(this).datepicker('setDate', new Date(year, month, 1));
                    if($(this).attr('id')=='chart_from'){
                        chart_monthBefore=month;
                        chart_yearBefore=year;
                    }
                    if($(this).attr('id')=='chart_periodfrom'){
                        chart_periodmonthBefore=month;
                        chart_periodyearBefore=year;
                    }
                    chart_db_dataId = $('input:radio[name=chart_rd_unit]:checked').attr('id');
                    if(chart_db_dataId=='chart_rd_perunit'){
                        var chart_flag_daterange='chart_flag_daterange_unit';
                    }
                    else if(chart_db_dataId=='chart_rd_allunit'){
                        var chart_flag_daterange='chart_flag_daterange_allunit';
                    }
                    else{
                        chart_flag_daterange='chart_flag_daterange_allunit';
                    }
                    var chart_srch_data=$('#chart_lb_srch_data').val();
                    var unitno=$('#chart_lb_unit').val();
                    chart_fromdate=$("#chart_from").val();
                    chart_periodfromdate=$("#chart_periodfrom").val();
                    chart_todate=$("#chart_to").val();
                    chart_periodtodate=$("#chart_periodto").val();
                    chart_monthdate=$("#chart_month").val();
                    if((chart_fromdate!='')&&(chart_fromdate!=undefined)&&(chart_todate!=undefined)&&(chart_todate!='')){
                        CHART_func_expense_inputdata(unitno,chart_fromdate,chart_todate,chart_srch_data,chart_flag_daterange);
                    }
                    if((chart_periodfromdate!='')&&(chart_periodfromdate!=undefined)&&(chart_periodtodate!=undefined)&&(chart_periodtodate!='')){
                        CHART_func_expense_inputdata(unitno,chart_periodfromdate,chart_periodtodate,chart_srch_data,chart_flag_daterange);
                    }
                    if((chart_monthdate!='')&&(chart_monthdate!=undefined)){
                        CHART_func_expense_inputdata(unitno,chart_monthdate,chart_monthdate,chart_srch_data,chart_flag_daterange);
                    }
                },
                beforeShow : function(selected) {
                    $("#chart_to").datepicker("option","minDate", new Date(chart_yearBefore, chart_monthBefore ,1));
                    $("#chart_periodto").datepicker("option","minDate", new Date(chart_periodyearBefore, chart_periodmonthBefore ,1));
                }
            });
        });
    }
// sp input and response
    function CHART_func_expense_inputdata(unitno,fromdate,todate,srch_data,flag){
        $('.preloader').show();
        $.ajax({
            type: "POST",
            url: ctrl_charts_url+'/Expense_inputdata',
            data:"unitno="+unitno+"&fromdate="+fromdate+"&todate="+todate+"&srch_data="+srch_data+"&flag="+flag,
            success: function(data){
                var value_array=JSON.parse(data);
                CHART_success_chartexpense(value_array);
            },
            error:function(data){
                var errordata=(JSON.stringify(data));
                show_msgbox("CHARTS",errordata,'error',false);
                $('.preloader').hide();
            }
        });
    }
// processing data from response table array
    function CHART_success_chartexpense(Response_array){
        $("#chart_errmsgdiv,#chart_div,#chart_tablediv").empty();
        $('.preloader').hide();
        var twodim=Response_array;
        //ERROR MSG
        var chart_errormsg='';
        var chart_srchdata=$('#chart_lb_srch_data').val();
        var chart_unitno=$('#chart_lb_unit').val();
        var chart_frmdate=$("#chart_from").val();
        var chart_periodfromdate=$("#chart_periodfrom").val();
        var chart_todate=$("#chart_to").val();
        var chart_periodtodate=$("#chart_periodto").val();
        var chart_monthdate=$("#chart_month").val();
        if(chart_srchdata!='SELECT' && chart_monthdate!=''){
            chart_errormsg=errormsg[0].EMC_DATA;
            chart_errormsg=chart_errormsg.replace('[DATE]',chart_monthdate);
        }
        if(twodim.length==1 && chart_srchdata!='SELECT' && chart_monthdate!=''){
            chart_errormsg=errormsg[2].EMC_DATA;
            chart_errormsg=chart_errormsg.replace('[DATE]',chart_monthdate);
        }
        if(chart_srchdata!='SELECT' && ((chart_frmdate!='' && chart_todate!='')||(chart_periodfromdate!='' && chart_periodtodate!=''))){
            chart_errormsg=errormsg[1].EMC_DATA;
            if((chart_frmdate!='' && chart_todate!='')){
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_frmdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_todate);
            }
            if((chart_periodfromdate!='' && chart_periodtodate!='')){
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_periodfromdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_periodtodate);
            }
        }
        if(twodim.length==1 && chart_srchdata!='SELECT' && ((chart_frmdate!='' && chart_todate!='')||(chart_periodfromdate!='' && chart_periodtodate!=''))){
            chart_errormsg=errormsg[3].EMC_DATA;
            if((chart_frmdate!='' && chart_todate!='')){
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_frmdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_todate);
            }
            if((chart_periodfromdate!='' && chart_periodtodate!='')){
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_periodfromdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_periodtodate);
            }
        }
        if(chart_srchdata!='SELECT' && chart_unitno!='SELECT' && $('input:radio[name=chart_rd_unit]:checked').val()=='PER UNIT' && ((chart_frmdate!='' && chart_todate!='')||(chart_periodfromdate!='' && chart_periodtodate!=''))){
            chart_errormsg=errormsg[4].EMC_DATA;
            if((chart_frmdate!='' && chart_todate!='')){
                chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_frmdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_todate);
            }
            if((chart_periodfromdate!='' && chart_periodtodate!='')){
                chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_periodfromdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_periodtodate);
            }
        }
        if(twodim.length==1 && chart_srchdata!='SELECT' && chart_unitno!='SELECT' && $('input:radio[name=chart_rd_unit]:checked').val()=='PER UNIT' && ((chart_frmdate!='' && chart_todate!='')||(chart_periodfromdate!='' && chart_periodtodate!=''))){
            chart_errormsg=errormsg[6].EMC_DATA;
            if((chart_frmdate!='' && chart_todate!='')){
                chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_frmdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_todate);
            }
            if((chart_periodfromdate!='' && chart_periodtodate!='')){
                chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_periodfromdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_periodtodate);
            }
        }
        if(chart_srchdata!='SELECT' && chart_monthdate!='' && chart_unitno!='SELECT' && $('input:radio[name=chart_rd_unit]:checked').val()=='PER UNIT'){
            chart_errormsg=errormsg[5].EMC_DATA;
            chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
            chart_errormsg=chart_errormsg.replace('[DATE]',chart_monthdate);
        }
        if(twodim.length==1 && chart_srchdata!='SELECT' && chart_monthdate!='' && chart_unitno!='SELECT' && $('input:radio[name=chart_rd_unit]:checked').val()=='PER UNIT'){
            chart_errormsg=errormsg[7].EMC_DATA;
            chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
            chart_errormsg=chart_errormsg.replace('[DATE]',chart_monthdate);
        }
        if(chart_srchdata!='SELECT' && chart_unitno=='SELECT' && $('input:radio[name=chart_rd_unit]:checked').val()=='ALL UNIT' && ((chart_frmdate!='' && chart_todate!='')||(chart_periodfromdate!='' && chart_periodtodate!=''))){
            chart_errormsg=errormsg[4].EMC_DATA;
            chart_unitno='ALL UNIT';
            if((chart_frmdate!='' && chart_todate!='')){
                chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_frmdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_todate);
            }
            if((chart_periodfromdate!='' && chart_periodtodate!='')){
                chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_periodfromdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_periodtodate);
            }
        }
        if(twodim.length==1 && chart_srchdata!='SELECT' && chart_unitno=='SELECT' && $('input:radio[name=chart_rd_unit]:checked').val()=='ALL UNIT' && ((chart_frmdate!='' && chart_todate!='')||(chart_periodfromdate!='' && chart_periodtodate!=''))){
            chart_errormsg=errormsg[6].EMC_DATA;
            chart_unitno='ALL UNIT';
            if((chart_frmdate!='' && chart_todate!='')){
                chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_frmdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_todate);
            }
            if((chart_periodfromdate!='' && chart_periodtodate!='')){
                chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
                chart_errormsg=chart_errormsg.replace('[FROM]',chart_periodfromdate);
                chart_errormsg=chart_errormsg.replace('[TO]',chart_periodtodate);
            }
        }
        if(chart_srchdata!='SELECT' && chart_monthdate=='SELECT' && $('input:radio[name=chart_rd_unit]:checked').val()=='ALL UNIT' && chart_unitno==''){
            chart_errormsg=errormsg[5].EMC_DATA;
            chart_unitno='ALL UNIT';
            chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
            chart_errormsg=chart_errormsg.replace('[DATE]',chart_monthdate);
        }
        if(twodim.length==1 && chart_srchdata!='SELECT' && chart_monthdate=='SELECT' && $('input:radio[name=chart_rd_unit]:checked').val()=='ALL UNIT' && chart_unitno==''){
            chart_errormsg=errormsg[7].EMC_DATA;
            chart_unitno='ALL UNIT';
            chart_errormsg=chart_errormsg.replace('[UNITNO]',chart_unitno);
            chart_errormsg=chart_errormsg.replace('[DATE]',chart_monthdate);
        }
        if((chart_srchdata==10)||(chart_srchdata==22)||(chart_srchdata==27)||(chart_srchdata==18)||(chart_srchdata==16)){
            chart_errormsg=chart_errormsg.replace('BAR','LINE');
        }
        chart_errormsg=chart_errormsg.replace('[TYPE]',$('#chart_lb_srch_data').find('option:selected').text());
        if(twodim.length==1){
            $("#chart_errmsgdiv").text(chart_errormsg);
            $('#chart_div').width('100%');$('#chart_div').height('60%');
        }
        else if(twodim.length>1){
            chart_flag_chart=1;
            var chart_flag_gross=[];
            var chart_flag_net=[];
            if(($('#chart_lb_srch_data').val()==17)||($('#chart_lb_srch_data').val()==16)||($('#chart_lb_srch_data').val()==18)||($('#chart_lb_srch_data').val()==14)){
                var chart_getsecondposition=new Array(twodim.length);
                for(var y=0;y<twodim.length;y++){
                    chart_getsecondposition[y]=new Array(2);
                    chart_getsecondposition[y][0]=twodim[y][0];
                    chart_getsecondposition[y][1]=twodim[y][3];
                //CHECK COND FOR NET !=0
                    if(chart_getsecondposition[y][1]==0){
                        chart_flag_net[y]=y;
                    }
                    if(($('#chart_lb_srch_data').val()==18)||($('#chart_lb_srch_data').val()==16)){
                        chart_getsecondposition[y][2]=twodim[y][1];
                    //CHECK COND FOR GROSS !=0
                        if(chart_getsecondposition[y][2]==0){
                            chart_flag_gross[y]=y;
                        }
                    }
                }
            }
            else{
                chart_flag_chart=1;
                chart_getsecondposition=twodim;
            }
            if(($('#chart_lb_srch_data').val()==16)||($('#chart_lb_srch_data').val()==18)){
                if((chart_getsecondposition.length == chart_flag_net.length)&&(chart_getsecondposition.length == chart_flag_gross.length)){
                    $('#chart_div').empty();
                    $('#chart_div').width('100%');$('#chart_div').height('60%');
                    chart_flag_chart=0;
                }
            }
            else if(($('#chart_lb_srch_data').val()==17)&&(chart_getsecondposition.length == chart_flag_net.length)){
                chart_flag_chart=0;
                $('#chart_div').empty();
                $('#chart_div').width('100%');$('#chart_div').height('60%');
            }
            if(chart_flag_chart==1){
                function resizeHandler(){
                    drawChart(chart_getsecondposition,chart_errormsg,$('#chart_lb_srch_data').val());
                    $("html, body").animate({ scrollTop: 1300}, "slow");
                }
                resizeHandler();
                if(window.addEventListener){
                    window.addEventListener('resize', resizeHandler);
                }
                else if(window.attachEvent){
                    window.attachEvent('onresize', resizeHandler);
                }
            }
            var arr1=[];
            arr1[0]='string';
            for(var j=1;j<twodim[0].length;j++){
                arr1[j]='number';
            }
            var chart_flexarr=new Array(twodim.length-1);
            for(var y=0;y<twodim.length-1;y++){
                chart_flexarr[y]=new Array(2);
                chart_flexarr[y]=twodim[y+1]
            }
            if(chart_flag_chart==1){
                function tableresizeHandler(){
                    drawTable(chart_flexarr,arr1,twodim[0]);
                }
                tableresizeHandler();
                if(window.addEventListener){
                    window.addEventListener('resize', tableresizeHandler);
                }
                else if(window.attachEvent){
                    window.attachEvent('onresize', tableresizeHandler);
                }
            }
            else{
                chart_errormsg=errormsg[7].EMC_DATA.replace('[UNITNO] [TYPE] BAR CHART FOR THE PERIOD [DATE]',chart_errormsg);
                $("#chart_errmsgdiv").text(chart_errormsg);
            }
        }
    }
// change event for chart name
    $(document).on('change','#chart_lb_name',function(){
        $("#chart_errmsgdiv,#chart_div,#chart_tablediv").empty();
        $('#chart_lb_srch_data').html('');
        $('#chart_lb_srch_data').append($('<option> SELECT </option>'));
        clear();
        var nameval=$('#chart_lb_name').val();
        if(nameval!='SELECT'){
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: ctrl_charts_url+'/Subchartdata',
                data:"nameval="+ nameval,
                success: function(data){
                    $('.preloader').hide();
                    var charttype=JSON.parse(data);
                    if(charttype.length!=0){
                        for(var i=0;i<charttype.length;i++)
                        {
                            var typeid=charttype[i].RCN_ID;
                            var typedata=charttype[i].RCN_DATA;
                            $('#chart_lb_srch_data').append($('<option>').text(typedata).attr('value',typeid));
                        }
                        $('#chart_srch_data').show();
                        $('#chart_lb_srch_data').focus();

                    }
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("CHARTS",errordata,'error',false);
                    $('.preloader').hide();
                }
            });
        }
    });
// change event for sub chart
    $(document).on('change','#chart_lb_srch_data',function(){
        $("html, body").animate({ scrollTop: 1000 }, "slow");
        $("#chart_errmsgdiv,#chart_div,#chart_tablediv").empty();
        var chart_val_srchdata =$(this).val();
        if(chart_val_srchdata==9||chart_val_srchdata==11||chart_val_srchdata==12||chart_val_srchdata==13||chart_val_srchdata==14||chart_val_srchdata==15||chart_val_srchdata==18){
            CHART_func_allperunit();
        }
        if(chart_val_srchdata==10||chart_val_srchdata==16||chart_val_srchdata==27||chart_val_srchdata==22){
            CHART_func_daterange();
        }
        if(chart_val_srchdata==19||chart_val_srchdata==21||chart_val_srchdata==20||chart_val_srchdata==23||chart_val_srchdata==24||chart_val_srchdata==25||chart_val_srchdata==26||chart_val_srchdata==17){
            CHART_func_permonth_daterange();
        }
        if(chart_val_srchdata=='SELECT'){
            clear();
        }
    });
    function clear(){
        $('#chart_unittype').hide();
        $('#chart_unit').hide();
        $('#chart_lb_unit').val('SELECT').hide();
        $('#chart_period').hide();
        $('#chart_fromto').hide();
        $('#chart_form').find('input:radio').removeAttr('checked');
    }
    function CHART_func_allperunit(){
        $('#chart_unittype').show();
        $('#chart_form').find('input:radio').removeAttr('checked');
        $('#chart_unit').hide();
        $('#chart_lb_unit').val('SELECT');
        $('#chart_period').hide();
        $('#chart_fromto').hide();
        $('#chart_periodfrom').val('');
        $('#chart_periodto').val('');
        $('#chart_month').val('');
        $('#chart_from').val('');
        $('#chart_to').val('');
        CHART_datepicker();
    }
    function CHART_func_daterange(){
        $('#chart_fromto').show();
        $('#chart_unit').hide();
        $('#chart_unittype').hide();
        $('#chart_lb_unit').val('SELECT');
        $('#chart_period').hide();
        $('#chart_form').find('input:radio').removeAttr('checked');
        $('#chart_periodfrom').val('');
        $('#chart_periodto').val('');
        $('#chart_month').val('');
        $('#chart_from').val('');
        $('#chart_to').val('');
        CHART_datepicker();
    }
    function CHART_func_permonth_daterange(){
        $('#chart_period').show();
        $('#chart_permonth').hide();
        $('#chart_periodfromto').hide();
        $('#chart_fromto').hide();
        $('#chart_unit').hide();
        $('#chart_unittype').hide();
        $('#chart_lb_unit').val('SELECT');
        $('#chart_form').find('input:radio').removeAttr('checked');
        $('#chart_periodfrom').val('');
        $('#chart_periodto').val('');
        $('#chart_month').val('');
        $('#chart_from').val('');
        $('#chart_to').val('');
        CHART_datepicker();
    }
// radio select for unit type
    $(document).on('click','.unittype',function(){
        $("html, body").animate({ scrollTop: 1000 }, "slow");
        $("#chart_errmsgdiv,#chart_div,#chart_tablediv").empty();
        var chart_unit=$(this).attr('id');
        if(chart_unit=='chart_rd_perunit'){
            $('#chart_unit').show();
            $('#chart_period').hide();
            $('#chart_lb_unit').val('SELECT').show();
            $('#chart_lb_unit').focus();
            $('#chart_permonth').hide();
            $('#chart_periodfromto').hide();
            $('#chart_fromto').hide();
            $('#chart_periodfrom').val('');
            $('#chart_periodto').val('');
            $('#chart_month').val('');
        }
        else if(chart_unit=='chart_rd_allunit'){
            $('#chart_period').show();
            $('#chart_unit').hide();
            $('#chart_lb_unit').val('SELECT');
            $('input[name=chart_rd_period]').attr('checked',false);
            $('#chart_permonth').hide();
            $('#chart_periodfromto').hide();
            $('#chart_fromto').hide();
            $('#chart_periodfrom').val('');
            $('#chart_periodto').val('');
            $('#chart_month').val('');
        }
    });
// radio select for period search type
    $(document).on('click','.period_range_month',function(){
        $("html, body").animate({ scrollTop:1000}, "slow");
        $("#chart_errmsgdiv,#chart_div,#chart_tablediv").empty();
        var chart_monperrange=$(this).attr('id');
        if(chart_monperrange=='chart_rd_month'){
            $('#chart_permonth').show();
            $('#chart_periodfromto').hide();
            $('#chart_fromto').hide();
            $('#chart_periodfrom').val('');
            $('#chart_periodto').val('');
            $('#chart_month').val('');
        }
        else if(chart_monperrange=='chart_rd_range'){
            $('#chart_periodfromto').show();
            $('#chart_permonth').hide();
            $('#chart_fromto').hide();
            $('#chart_periodfrom').val('');
            $('#chart_periodto').val('');
            $('#chart_month').val('');
        }
    });
// change event for unit no
    $(document).on('change','#chart_lb_unit',function(){
        $("html, body").animate({ scrollTop: 1000 }, "slow");
        $("#chart_errmsgdiv,#chart_div,#chart_tablediv").empty();
        $('#chart_period').show();
        $('#chart_permonth').hide();
        $('#chart_periodfromto').hide();
        $('#chart_fromto').hide();
        $('input[name=chart_rd_period]').attr('checked',false);
    });
});
</script>
</head>
<body>
<div class="container">
<div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>CHARTS</b></h4></div>
        <form id="chart_form" name="chart_form" class="form-horizontal content" role="form">
            <div class="panel-body">
                <fieldset>
                    <div class="form-group" id="chart_name">
                        <label class="col-sm-2">CHART NAME</label>
                        <div class="col-sm-3"> <select name="chart_lb_name" id="chart_lb_name" class="form-control chart_formvalidation"><option>SELECT</option></select></div>
                    </div>
                    <div class="form-group" id="chart_srch_data" hidden>
                        <label class="col-sm-2">SUB CHART</label>
                        <div class="col-sm-3"> <select name="chart_lb_srch_data" id="chart_lb_srch_data" class="form-control chart_formvalidation"></select></div>
                    </div>
                    <div class="form-group" id="chart_unittype" hidden>
                        <label class="col-sm-2">CHART TYPE</label>
                        <label class="radio-inline" style="padding-left:35px; padding-top: 0px;"> <input type="radio" name="chart_rd_unit" id="chart_rd_perunit" value="PER UNIT" class="unittype"> PER UNIT </label>
                        <label class="radio-inline" style="padding-top: 0px;"> <input type="radio" name="chart_rd_unit" id="chart_rd_allunit" value="ALL UNIT" class="unittype"> ALL UNIT </label>
                    </div>
                    <div class="form-group" id="chart_unit" hidden>
                        <label class="col-sm-2">UNIT NO</label>
                        <div class="col-sm-2"> <select name="chart_lb_unit" id="chart_lb_unit" class="form-control chart_formvalidation"></select></div>
                    </div>
                    <div id="chart_fromto" hidden>
                        <div class="form-group">
                            <label class="col-sm-offset-2 col-sm-1">FROM</label>
                            <div class="col-sm-9" style="padding-left:0px;">
                                <div class="col-sm-3">
                                    <div class="input-group addon">
                                        <input id="chart_from" name="chart_from" type="text" class="date-picker datemandtry form-control chartdatepicker" placeholder="From"/>
                                        <label for="chart_from" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-offset-2 col-sm-1">TO</label>
                            <div class="col-sm-9" style="padding-left:0px;">
                                <div class="col-sm-3">
                                    <div class="input-group addon">
                                        <input id="chart_to" name="chart_to" type="text" class="date-picker datemandtry form-control chartdatepicker" placeholder="To"/>
                                        <label for="chart_to" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" id="chart_period" hidden>
                        <div class="col-md-2">
                            <label>SELECT MONTH</label>
                        </div>
                        <div class="col-md-10">
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label class="radio-inline" style="padding-top: 0px;"> <input type="radio" name="chart_rd_period" id="chart_rd_month" value="MONTH" class="period_range_month"> MONTH</label>
                                </div>
                                <div id="chart_permonth" hidden>
                                    <label class="col-sm-2">SELECT MONTH</label>
                                    <div class="col-sm-2">
                                        <div class="input-group addon" style="width: 170px">
                                            <input id="chart_month" name="chart_month" type="text" class="date-picker datemandtry form-control chartdatepicker" placeholder="Month"/>
                                            <label for="chart_month" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label class="radio-inline" style="padding-top: 0px;"> <input type="radio" name="chart_rd_period" id="chart_rd_range" value="PERIOD RANGE" class="period_range_month"> PERIOD RANGE</label>
                                </div>
                                <div id="chart_periodfromto" hidden>
                                    <label class="col-sm-2">FROM</label>
                                    <div class="col-sm-5">
                                        <div class="input-group addon" style="width: 170px">
                                            <input id="chart_periodfrom" name="chart_periodfrom" type="text" class="date-picker datemandtry form-control chartdatepicker" placeholder="From"/>
                                            <label for="chart_periodfrom" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                        </div>
                                    </div>
                                    <label class="col-sm-offset-3 col-sm-2" style="padding-top: 15px">TO</label>
                                    <div class="col-sm-5" style="padding-top: 15px">
                                        <div class="input-group addon" style="width: 170px">
                                            <input id="chart_periodto" name="chart_periodto" type="text" class="date-picker datemandtry form-control chartdatepicker" placeholder="To"/>
                                            <label for="chart_periodto" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="chart_errmsgdiv" class="errormsg">
                    </div>
                    <div id="chart_div" class="chart">
                    </div>
                    <div id="chart_tablediv">
                    </div>
                </fieldset>
            </div>
        </form>
    </div>
</body>
</html>
                