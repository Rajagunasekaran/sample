<!--//*******************************************FILE DESCRIPTION*********************************************//
//************************************CUSTOMER EXPIRY LIST***********************************************//
//DONE BY:SAFI

VER 0.01 -INITIAL VERSION-SD:26/05/2015 ED:28/05/2015;
//*********************************************************************************************************//
-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<!--HTML TAG START-->
<html>
<!--HEAD TAG START-->
<head>
<script>

//<!----------READY FUNCTION------------->
$(document).ready(function(){
    $('#spacewidth').height('0%');
    var CEXP_max_date_array;
    var from_date;
    var to_date;
    var radio_value;
    var controller_url="<?php echo base_url(); ?>" + '/index.php/CUSTOMER/CUSTOMER/Ctrl_Customer_Expiry_List/' ;
    $(".preloader").show();
    $('#CEXP_div_htmltable').hide();
    $('#CWEXP_tble_buttontable').hide();
    $.ajax({
         type:'post',
        'url':controller_url+"CEXP_get_initial_values",
         success:function(data){
             $(".preloader").hide();
             var initial_value=JSON.parse(data)
             CEXP_load_initial_values(initial_value);
         },
        error:function(data){
            show_msgbox("CUSTOMER EXPIRY LIST",JSON.stringify(data),"error",false);
        }
    });
    var CEXP_errorAarray=[];
    var CEXP_email_array=[];
    $(".numonly").doValidation({rule:'numbersonly',prop:{realpart:1}});
    //-----FUNCTION TO LOAD INITIAL VALUES-------------------//
    function CEXP_load_initial_values(CEXP_initial_values){
        CEXP_errorAarray=CEXP_initial_values[0].CEXP_error_msg;
        CEXP_email_array=CEXP_initial_values[0].CEXP_emailid;
        var CEXP_custAarray=CEXP_initial_values[0].CEXP_custAarray;
        CEXP_max_date_array=CEXP_initial_values[0].CEXP_max_date_array;
        if(CEXP_custAarray.length==0){
            $('#CEXP_form_expirylist_weeklyexpiryform').replaceWith('<p><label class="errormsg">'+ CEXP_errorAarray[10].EMC_DATA+'</label></p>');
        }
        else{
            var CEXP_email_options ='<option>SELECT</option>'
            for (var i = 0; i < CEXP_email_array.length; i++) {
                CEXP_email_options += '<option value="' + CEXP_email_array[i] + '">' + CEXP_email_array[i]+ '</option>';
            }
            $('#CWEXP_lb_selectemail').html(CEXP_email_options);
            $('#CEXP_tble_main').show()
        }
    }
   //------------EXPIRY LIST BUTTON CHANGE---------------//
    $('#CEXP_radio_Expirylist').change(function(){
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        $('#CEXP_tble_expiry_list').show();
        $('#CEXP_tble_Weekly_expiry_list').hide();
        $('#CWEXP_btn_submit').attr('disabled','disabled');
        $('#CWEXP_lb_selectemail').prop('selectedIndex',0);
        $('#CWEXP_TB_weekBefore').val("");
        $('#CWEXP_tble_buttontable').hide();
        $('#CEXP_lbl_msg').hide();
        $('#CWEXP_lbl_msg').hide();
    });
    //--------------------EQUAL RADIO BUTTON CHANGE------------//
    $('#CEXP_radio_equal').change(function(){
        $('#CEXP_lbl_msg').hide();
        $('#CEXP_btn_submit').attr('disabled','disabled');
        $('#CEXP_lbl_equalto').show();
        $('#CEXP_tbl_htmltable tr').remove();
        $('#CEXP_div_htmltable').hide();
        $('#CEXP_db_selected_equal_date').show();
        $('#CEXP_span_selected_equal_date').show();
        $('#CEXP_db_selected_from_date').hide().val("");
        $('#CEXP_span_selected_from_date').hide();
        $('#CEXP_db_selected_to_date').hide().val("");
        $('#CEXP_span_selected_to_date').hide();
        $('#CEXP_lbl_fromdate').hide();
        $('#CEXP_lbl_todate').hide();
        $('#CEXP_lbl_beforedate').hide();
        $('#CWEXP_pdf').hide();
        $('#CEXP_db_selected_before_date').hide().val("");
        $('#CEXP_span_selected_before_date').hide();
        $('#CEXP_db_selected_equal_date').datepicker({
            dateFormat:"dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        var date = new Date( Date.parse( CEXP_max_date_array ));
        $('#CEXP_db_selected_equal_date').datepicker("option","maxDate",date);
        $("#CEXP_db_selected_equal_date").focus();
    });
    //-------------------EQUAL DATEPICKER CHANGE---------------//
    $('#CEXP_db_selected_equal_date').change(function(){

        if($('#CEXP_db_selected_equal_date').val()!=''){
            $('#CEXP_btn_submit').removeAttr('disabled');
        }
        else{
            $('#CEXP_btn_submit').attr('disabled','disabled');
        }
        $('#CEXP_lbl_msg').hide()
        $('#CEXP_div_htmltable').hide();
        $('#CWEXP_pdf').hide();
    });
    //--------------------BEFORE RADIO BUTTON CHANGE------------//
    $('#CEXP_radio_before').change(function(){
        $('#CEXP_btn_submit').attr('disabled','disabled');
        $('#CEXP_lbl_msg').hide();
        $('#CEXP_tbl_htmltable tr').remove();
        $('#CEXP_div_htmltable').hide();
        $('#CEXP_lbl_equalto').hide();
        $('#CEXP_db_selected_equal_date').hide().val("");
        $('#CEXP_span_selected_equal_date').hide();
        $('#CEXP_db_selected_from_date').hide().val("");
        $('#CEXP_span_selected_from_date').hide();
        $('#CEXP_db_selected_to_date').hide().val("");
        $('#CEXP_span_selected_to_date').hide();
        $('#CEXP_lbl_fromdate').hide();
        $('#CEXP_lbl_todate').hide();
        $('#CWEXP_pdf').hide();
        $('#CEXP_lbl_beforedate').show();
        $('#CEXP_db_selected_before_date').show();
        $('#CEXP_span_selected_before_date').show();
        $('#CEXP_db_selected_before_date').datepicker({
            dateFormat:"dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        var date = new Date( Date.parse( CEXP_max_date_array ));
        $('#CEXP_db_selected_before_date').datepicker("option","maxDate",date);
        $("#CEXP_db_selected_before_date").focus();
    });
    //-------------------BEFORE DATEPICKER CHANGE---------------//
    $('#CEXP_db_selected_before_date').change(function(){
        if($('#CEXP_db_selected_before_date').val()!=''){
            $('#CEXP_btn_submit').removeAttr('disabled');
        }
        else{
            $('#CEXP_btn_submit').attr('disabled','disabled');
        }
        $('#CEXP_lbl_msg').hide();
        $('#CEXP_div_htmltable').hide();
        $('#CWEXP_pdf').hide();
    });
    //--------------------BETWEEN RADIO BUTTON CHANGE------------//
    $('#CEXP_radio_between').change(function(){
        $('#CEXP_btn_submit').attr('disabled','disabled');
        $('#CEXP_lbl_equalto').hide();
        $('#CEXP_div_htmltable').hide();
        $('#CEXP_lbl_msg').hide();
        $('#CEXP_tbl_htmltable tr').remove();
        $('#CEXP_db_selected_equal_date').hide().val("");
        $('#CEXP_span_selected_equal_date').hide();
        $('#CEXP_lbl_beforedate').hide();
        $('#CEXP_db_selected_before_date').hide().val("");
        $('#CEXP_span_selected_before_date').hide();
        $('#CEXP_db_selected_from_date').show();
        $('#CEXP_span_selected_from_date').show();
        $('#CEXP_db_selected_to_date').hide();
        $('#CEXP_span_selected_to_date').hide();
        $('#CEXP_lbl_fromdate').show();
        $('#CEXP_lbl_todate').hide();
        $('#CWEXP_pdf').hide();
        //SET FROM DATE DATEPICKER
        $('#CEXP_db_selected_from_date').datepicker({
            dateFormat:"dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        $('#CEXP_db_selected_to_date').datepicker({
            dateFormat:"dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        var date = new Date( Date.parse( CEXP_max_date_array ));
        $('#CEXP_db_selected_to_date').datepicker("option","maxDate",date);
        $('#CEXP_db_selected_from_date').datepicker("option","maxDate",date);
        $("#CEXP_db_selected_from_date").focus();
    });
    //-----------------WEEKLY-EXPIRY LIST BUTTON CHANGE--------------//
    $('#CEXP_radio_WeeklyExpirylist').change(function(){
        if(CEXP_email_array.length==0){
            var msg=CEXP_errorAarray[11]
            msg=msg.replace("[PROFILE]",'EXPIRY LIST')
            $('#CEXP_tble_Weekly_expiry_list').hide();
            $('#CWEXP_lbl_msg').text(msg).removeClass( "srctitle" ).addClass( "errormsg" ).show();
        }
        else{
            $('#CEXP_tble_Weekly_expiry_list').show();
            $('#CWEXP_lbl_msg').hide()
            $('#CWEXP_tble_buttontable').show();
        }
        $('#CEXP_tble_expiry_list').hide();
        $('#CEXP_btn_submit').attr('disabled','disabled');
        $("input[name=CEXP_radiobotton]:checked").attr('checked',false);
        $('#CEXP_db_selected_from_date').hide().val("");
        $('#CEXP_span_selected_from_date').hide();
        $('#CEXP_db_selected_to_date').hide().val("");
        $('#CEXP_span_selected_to_date').hide();
        $('#CEXP_db_selected_before_date').hide().val("");
        $('#CEXP_span_selected_before_date').hide();
        $('#CEXP_db_selected_equal_date').hide().val("");
        $('#CEXP_span_selected_equal_date').hide();
        $('#CEXP_div_htmltable').hide();
        $('#CEXP_lbl_msg').hide();
        $('#CEXP_lbl_fromdate').hide();
        $('#CEXP_lbl_todate').hide();
        $('#CEXP_lbl_beforedate').hide();
        $('#CEXP_lbl_equalto').hide();
        $('#CWEXP_pdf').hide();
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");

    });
    //-------------------TO DATEPICKER CHANGE---------------//
    $('#CEXP_db_selected_to_date').change(function(){
        if($("#CEXP_db_selected_from_date").val()!=''&& $("#CEXP_db_selected_to_date").val()!=''){
            $('#CEXP_btn_submit').removeAttr('disabled');
        }
        else{
            $('#CEXP_btn_submit').attr('disabled','disabled');
        }
        $('#CEXP_lbl_msg').hide();
        $('#CEXP_div_htmltable').hide();
        $('#CWEXP_pdf').hide();
    });
    //-------------------FROM DATEPICKER CHANGE---------------//
    $('#CEXP_db_selected_from_date').change(function(){
        var CEXP_startdate = $('#CEXP_db_selected_from_date').datepicker('getDate');
        var date = new Date( Date.parse( CEXP_startdate ));
        date.setDate( date.getDate()  );
        var CEXP_todate = date.toDateString();
        CEXP_todate = new Date( Date.parse( CEXP_todate ));
        $('#CEXP_db_selected_to_date').datepicker("option","minDate",CEXP_todate);
        if($("#CEXP_db_selected_from_date").val()=='')
        {
            $("#CEXP_db_selected_to_date").val('').hide();
            $('#CEXP_lbl_todate').hide();
        }
        else{
            $("#CEXP_db_selected_to_date").show();
            $('#CEXP_span_selected_to_date').show();

            $('#CEXP_lbl_todate').show();
        }
        if($("#CEXP_db_selected_from_date").val()!=''&&$("#CEXP_db_selected_to_date").val()!='')
        {
            $('#CEXP_btn_submit').removeAttr('disabled');
        }
        else
        {
            $('#CEXP_btn_submit').attr('disabled','disabled');
        }
        $('#CEXP_lbl_msg').hide();
        $('#CEXP_div_htmltable').hide();
        $('#CWEXP_pdf').hide();
//        $("#CEXP_db_selected_to_date").focus();
    });
    //--------------FUNCTION TO GET VALUES FROM DATABASE----------------------//

    $('#CEXP_btn_submit').click(function(){
        var  newPos= adjustPosition($(this).position(),100,280);
        resetPreloader(newPos);
        $(".preloader").show();
        var CEXP_radio_button_select_value=$("input[name=CEXP_radiobotton]:checked").val();
        radio_value=CEXP_radio_button_select_value;
        if(CEXP_radio_button_select_value=="EQUAL")
        {
            var CEXP_equaldate=$('#CEXP_db_selected_equal_date').val();
            from_date=CEXP_equaldate;
            to_date=CEXP_equaldate;
            $.ajax({
                type:'post',
                'url':controller_url+"CEXP_get_customer_details",
                data:{'CEXP_fromdate':CEXP_equaldate,'CEXP_todate':CEXP_equaldate,'CEXP_radio_button_select_value':CEXP_radio_button_select_value},
                success:function(data){
                    var final_value=JSON.parse(data);
                    CEXP_load_customer_details(final_value);

                },
                error:function(data){

                    show_msgbox("CUSTOMER EXPIRY LIST",JSON.stringify(data),"error",false);
                }
            });
        }
        else if(CEXP_radio_button_select_value=="BEFORE")
        {
            var CEXP_beforedate=$('#CEXP_db_selected_before_date').val();
            from_date=CEXP_beforedate;
            to_date=CEXP_beforedate;
            $.ajax({
                type:'post',
                'url':controller_url+"CEXP_get_customer_details",
                data:{'CEXP_fromdate':CEXP_beforedate,'CEXP_todate':CEXP_beforedate,'CEXP_radio_button_select_value':CEXP_radio_button_select_value},
                success:function(data){
                    var final_value=JSON.parse(data);
                    CEXP_load_customer_details(final_value);


                },
                error:function(data){
                    show_msgbox("CUSTOMER EXPIRY LIST",JSON.stringify(data),"error",false);

                }
            });
        }
        else if(CEXP_radio_button_select_value=="BETWEEN")
        {
            var CEXP_fromdate=$('#CEXP_db_selected_from_date').val();
            var CEXP_enddate=$('#CEXP_db_selected_to_date').val();
            from_date=CEXP_fromdate;
            to_date=CEXP_enddate;
            $.ajax({
                type:'post',
                'url':controller_url+"CEXP_get_customer_details",
                data:{'CEXP_fromdate':CEXP_fromdate,'CEXP_todate':CEXP_enddate,'CEXP_radio_button_select_value':CEXP_radio_button_select_value},
                success:function(data){
                    var final_value=JSON.parse(data);
                    CEXP_load_customer_details(final_value);

                },
                error:function(data){
                    show_msgbox("CUSTOMER EXPIRY LIST",JSON.stringify(data),"error",false);

                }
            });
        }
    });
    $(document).on('click','#CEXP_btn_pdf',function(){



        var pdfurl=document.location.href='<?php echo site_url('CUSTOMER/CUSTOMER/Ctrl_Customer_Expiry_List/Customer_Expiry_List_pdf')?>?CEXP_fromdate='+from_date+'&CEXP_todate='+to_date+'&CEXP_radio_button_select_value='+radio_value+'&header='+header;

    });
    ///----------SUBMIT BUTTON VALIDATION----------------------//
    $('.submitvalidate').blur(function(){
        var CWEXP_weekno=$('#CWEXP_TB_weekBefore').val();
        var CWEXP_email=$('#CWEXP_lb_selectemail').val();
        if((CWEXP_weekno!='') &&(CWEXP_email!="SELECT"))
        {
            $('#CWEXP_btn_submit').removeAttr('disabled');
            $('#CWEXP_lbl_msg').hide();
        }
        else{
            $('#CWEXP_btn_submit').attr('disabled','disabled');
        }
    });
    $('#CWEXP_btn_submit').click(function(){
        var  newPos= adjustPosition($("#CWEXP_tble_buttontable").position(),100,310);
        resetPreloader(newPos);
        $(".preloader").show();
        var formelement=$('#CEXP_form_expirylist_weeklyexpiryform').serialize();
        $.ajax({
             type:'post',
            'url':controller_url+"CWEXP_get_customerdetails",
             data:formelement,
            success:function(data){
                var final_value=JSON.parse(data);
                CWEXP_clear(final_value);

            },
            error:function(data){
                show_msgbox("CUSTOMER EXPIRY LIST",JSON.stringify(data),"error",false);

            }

        });
//        google.script.run.withFailureHandler(CWEXP_error).withSuccessHandler(CWEXP_clear).CWEXP_get_customerdetails(document.getElementById('CEXP_form_expirylist_weeklyexpiryform'))
    });
    $('#CWEXP_btn_reset').click(function(){
        $('#CWEXP_btn_submit').attr('disabled','disabled');
        $('#CWEXP_lbl_msg').hide();
        $('#CWEXP_TB_weekBefore').val('');
        $('#CWEXP_lb_selectemail').prop('selectedIndex',0);
    });
////------------NUMBER'S ONLY VALIDATION--------------//
//
    //-----------------Function to load HTML table--------------------//
    var header;
    function CEXP_load_customer_details(result){
        $(".preloader").hide();
        var CEXP_radio_button_select_value=$("input[name=CEXP_radiobotton]:checked").val();
        if(CEXP_radio_button_select_value=="EQUAL")
        {
            var CEXP_equal_date=($('#CEXP_db_selected_equal_date').val());
            $('#CEXP_lbl_msg').text((CEXP_errorAarray[1].EMC_DATA).replace('[EQDATE]',CEXP_equal_date));
            $('#CEXP_db_selected_equal_date').val("");
            header=(CEXP_errorAarray[1].EMC_DATA).replace('[EQDATE]',CEXP_equal_date);
        }
        else if(CEXP_radio_button_select_value=="BEFORE")
        {
            var CEXP_before_date=($('#CEXP_db_selected_before_date').val());
            $('#CEXP_lbl_msg').text((CEXP_errorAarray[3].EMC_DATA).replace('[BDATE]',CEXP_before_date));
            $('#CEXP_db_selected_before_date').val("");
            header=(CEXP_errorAarray[3].EMC_DATA).replace('[BDATE]',CEXP_before_date);
        }
        else if(CEXP_radio_button_select_value=="BETWEEN")
        {
            var CEXP_startdate=($('#CEXP_db_selected_from_date').val());
            var CEXP_enddate=($('#CEXP_db_selected_to_date').val());
            var CEXP_between_error=(CEXP_errorAarray[5]).EMC_DATA.replace("[SDATE]",CEXP_startdate);
            var CEXP_between_error1=CEXP_between_error.replace("[EDATE]",CEXP_enddate);
            $('#CEXP_lbl_msg').text(CEXP_between_error1);
            $('#CEXP_db_selected_from_date').val("")
            $('#CEXP_db_selected_to_date').val("");
            header=CEXP_between_error1;
        }
        var CEXP_result_array=result
         if(CEXP_result_array.length==0)
        {
            if(CEXP_radio_button_select_value=="EQUAL")
            {
                $('#CEXP_lbl_msg').text((CEXP_errorAarray[0].EMC_DATA).replace('[EQDATE]',CEXP_equal_date)).show().removeClass( "srctitle" ).addClass( "errormsg" );
                $('#CEXP_div_htmltable').hide();
                $('#CEXP_btn_submit').attr('disabled','disabled');
            }
            if(CEXP_radio_button_select_value=="BEFORE")
            {
                $('#CEXP_lbl_msg').text((CEXP_errorAarray[2].EMC_DATA).replace('[BDATE]',CEXP_before_date)).show().removeClass( "srctitle" ).addClass( "errormsg" );
                $('#CEXP_div_htmltable').hide();
                $('#CEXP_btn_submit').attr('disabled','disabled');
            }
            if(CEXP_radio_button_select_value=="BETWEEN")
            {
                var CEXP_between_error=(CEXP_errorAarray[4].EMC_DATA).replace("[SDATE]",CEXP_startdate);
                var CEXP_between_error1=CEXP_between_error.replace("[EDATE]",CEXP_enddate);
                $('#CEXP_lbl_msg').text(CEXP_between_error1).show().removeClass( "srctitle" ).addClass( "errormsg" );
                $('#CEXP_div_htmltable').hide();
                $('#CEXP_btn_submit').attr('disabled','disabled');
            }
        }
        else{
            var CEXP_table_value='<table id="CEXP_tbl_htmltable" border="1"  cellspacing="0" class="srcresult" style="width:2500px" ><thead><tr><th style="width:40px" nowrap>UNIT NO</th><th style="width:150px" nowrap>FIRST NAME</th><th style="width:150px" nowrap>LAST NAME</th><th style="width:60px" nowrap class="uk-date-column">START DATE</th><th style="width:70px" nowrap class="uk-date-column">END DATE</th><th style="width:100px"  class="uk-date-column">PRETERMINATE DATE</th><th style="width:130px" nowrap>ROOM TYPE</th><th style="width:40px" nowrap>EXTENSION</th><th style="width:40px" nowrap>RE CHECKIN</th><th style="width:45px">RENT</th><th style="width:45px">DEPOSIT</th><th style="width:800px">COMMENTS</th><th style="width:210px" nowrap>USERSTAMP</th><th style="width:120px" nowrap class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
            for(var i=0;i<CEXP_result_array.length;i++)
            {
                var CEXP_values=CEXP_result_array[i]
                var CEXP_startdate=CEXP_values.startdate;
                CEXP_startdate=FormTableDateFormat(CEXP_startdate);
                var CEXP_enddate=CEXP_values.enddate;
                CEXP_enddate=FormTableDateFormat(CEXP_enddate);
                var CEXP_preterminatedate=CEXP_values.preterminatedate;
                if(CEXP_preterminatedate!=""){
                    CEXP_preterminatedate=FormTableDateFormat(CEXP_preterminatedate)
                }
                CEXP_table_value+='<tr ><td nowarp style="width:40px" >'+CEXP_values.unitno+'</td><td style="width:150px"  >'+CEXP_values.firstname+'</td><td  style="width:150px" >'+CEXP_values.lastname+'</td><td style="width:100px" >'+CEXP_startdate+'</td><td style="width:100px"  >'+CEXP_enddate+'</td><td style="width:100px"  >'+CEXP_preterminatedate+'</td><td style="width:130px" nowrap >'+CEXP_values.roomtype+'</td><td style="width:40px">'+CEXP_values.extension+'</td><td style="width:40px">'+CEXP_values.rechecking+'</td><td style="width:45px">'+CEXP_values.rental+'</td><td style="width:45px">'+CEXP_values.deposit+'</td><td style="width:800px" >'+CEXP_values.comments+'</td><td style="width:200px">'+CEXP_values.userstamp+'</td><td style="width:120px" nowrap>'+CEXP_values.timestamp+'</td></tr>';
//                $('#CEXP_tbl_htmltable').append(CEXP_table_value);
            }
             CEXP_table_value+='</tbody></table>';
            $('section').html(CEXP_table_value);
            var table=$('#CEXP_tbl_htmltable').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
                "sPaginationType":"full_numbers",
                 "sDom": 'Rlfrtip',
//                "scrollY": "300px",
//                "scrollX": "100%",
                     "scrollCollapse": true,
//                     "paging": false,
                "aoColumnDefs" : [
                    { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ]
            });

            sorting();
            $('#CEXP_div_htmltable').show();
             $('#CWEXP_pdf').show();
            $('#CEXP_btn_submit').attr('disabled','disabled');
            $('#CEXP_lbl_msg').show().addClass( "srctitle" );
        }
    }
    function sorting(){
        jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a)));
            var y = new Date( Date.parse(FormTableDateFormat(b)) );
            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };
        jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a)));
            var y = new Date( Date.parse(FormTableDateFormat(b)) );
            return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
        };
        jQuery.fn.dataTableExt.oSort['uk_timestp-asc']  = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
            var y = new Date( Date.parse(FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };
        jQuery.fn.dataTableExt.oSort['uk_timestp-desc'] = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
            var y = new Date( Date.parse(FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
            return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
        };
    }
    ////----------FUNCTION TO CLEAR-------------
    function CWEXP_clear(res)
    {
        $(".preloader").hide();
        var CWEXP_result =res
        var CWEXP_weekno=$('#CWEXP_TB_weekBefore').val();
        if(CWEXP_result==false)
        {
            var CWEXP_errormsg=(CEXP_errorAarray[6].EMC_DATA).replace('[WEEKNO]',CWEXP_weekno);
            var CWEXP_errormsg1=(CEXP_errorAarray[7].EMC_DATA).replace('[WEEKNO]',CWEXP_weekno);
            if(CWEXP_weekno==1)
            {
                show_msgbox("CUSTOMER EXPIRY LIST",CWEXP_errormsg,"success",false);
//                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER EXPIRY LIST",msgcontent:CWEXP_errormsg,position:{top:150,left:500}}});
            }
            else{
                show_msgbox("CUSTOMER EXPIRY LIST",CWEXP_errormsg1,"success",false);

//                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER EXPIRY LIST",msgcontent:CWEXP_errormsg1,position:{top:150,left:500}}});
            }
        }
        else
        {
            var CWEXP_confirm_msg=(CEXP_errorAarray[8].EMC_DATA).replace('[WEEKNO]',CWEXP_weekno);
            var CWEXP_confirm_msg1=(CEXP_errorAarray[9].EMC_DATA).replace('[WEEKNO]',CWEXP_weekno);
            if(CWEXP_weekno==1)
            {
                show_msgbox("CUSTOMER EXPIRY LIST",CWEXP_confirm_msg,"success",false);

//                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER EXPIRY LIST",msgcontent:CWEXP_confirm_msg,position:{top:150,left:500}}});

            }
            else{
                show_msgbox("CUSTOMER EXPIRY LIST",CWEXP_confirm_msg1,"success",false);

//                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER EXPIRY LIST",msgcontent:CWEXP_confirm_msg1,position:{top:150,left:500}}});
            }
        }
        $('#CWEXP_btn_submit').attr('disabled','disabled');
        $('#CWEXP_lb_selectemail').prop('selectedIndex',0);
        $('#CWEXP_TB_weekBefore').val("");
    }
   //Function to show error msg
    function CWEXP_error(err)
    {
        $(".preloader").hide();
        if(err=="ScriptError: Failed to establish a database connection. Check connection string, username and password.")
        {
            err="DB USERNAME/PWD WRONG, PLZ CHK UR CONFIG FILE FOR THE CREDENTIALS."
            $('#CEXP_form_expirylist_weeklyexpiryform').replaceWith('<center><label class="dberrormsg">'+err+'</label></center>');
        }
        else{
            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER EXPIRY LIST",msgcontent:err,position:{top:150,left:500}}});
        }
    }
    //FUNCTION TO CONVERT DATE FORMAT
    function FormTableDateFormat(inputdate){
        var string = inputdate.split("-");
        return string[2]+'-'+ string[1]+'-'+string[0];
    }
});
</script>
<!--SCRIPT TAG END-->
</head>
<!--HEAD TAG END-->
<!--BODY TAG START-->
<body>
<div class="container">
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="row title text-center"><h4><b>CUSTOMER EXPIRY LIST</b></h4></div>
    <form class="content form-horizontal" name="CEXP_form_expirylist_weeklyexpiryform" id="CEXP_form_expirylist_weeklyexpiryform" >
         <div class="panel-body">
            <div style="padding-bottom: 15px" id="CEXP_tble_main" hidden>
                <div class="radio">
                    <label >
                        <input  type="radio"  name="CEXP_mainradiobutton" id="CEXP_radio_Expirylist"  value="CUSTOMER EXPIRY LIST" >
                        CUSTOMER EXPIRY LIST
                    </label>
                </div>
                <div class="radio">
                    <label >
                        <input type="radio" name="CEXP_mainradiobutton" id="CEXP_radio_WeeklyExpirylist" value="WEEKLY CUSTOMER EXPIRY LIST" >
                        WEEKLY CUSTOMER EXPIRY LIST
                    </label>
                </div>
            </div>
            <div id="CEXP_tble_expiry_list"  hidden>
                   <div><label id="CCAN_lbl_title" class="srctitle" style="text-align:CENTER;width:400px">CUSTOMER EXPIRY LIST</label></div>
                   <div class="form-group" style="padding-left: 15px">
                      <div class="radio" style="padding-bottom:10px;">
                         <label >
                           <input type="radio" name="CEXP_radiobotton" id="CEXP_radio_equal" value="EQUAL" >
                          EQUAL DATES
                         </label>
                      </div>
                      <div class="form-group" >
                         <label name='CEXP_equalto' id='CEXP_lbl_equalto' class="col-sm-3"  hidden>ENTER EQUAL TO  DATE <em>*</em></label>
                         <div class="col-sm-2" id="CEXP_span_selected_equal_date" hidden>
                             <div class="input-group addon">
                                 <input type="text" name="selected_equal_date" id="CEXP_db_selected_equal_date" style="display: none" class="datemandtry form-control" placeholder="Date" hidden  >
                                 <label for="CEXP_db_selected_equal_date" class="input-group-addon" ><span class="glyphicon glyphicon-calendar" ></span></label>
                             </div>
                         </div>
                      </div>
                   </div>
                   <div class="form-group" style="padding-left: 15px">
                        <div class="radio" style="padding-bottom:10px;">
                            <label >
                                 <input type="radio" name="CEXP_radiobotton" id="CEXP_radio_before" value="BEFORE" >BEFORE DATES
                            </label>
                        </div>
                        <div class="form-group">
                           <label name='CEXP_beforedate' id='CEXP_lbl_beforedate' class="col-sm-3"  hidden>ENTER A BEFORE  DATE <em>*</em></label>
                           <div class="col-sm-2" id="CEXP_span_selected_before_date" hidden >
                               <div class="input-group addon">
                                   <input type="text" name="selected_before_date" id="CEXP_db_selected_before_date" style="display: none" class="datemandtry form-control" placeholder="Date"  >
                                   <label for="CEXP_db_selected_before_date" class="input-group-addon" ><span class="glyphicon glyphicon-calendar"></span></label>
                               </div>
                          </div>
                        </div>
                   </div>
                   <div class="form-group" style="padding-left: 15px">
                         <div class="radio" style="padding-bottom:10px;">
                              <label >
                                   <input type="radio" name="CEXP_radiobotton" id="CEXP_radio_between" value="BETWEEN" >BETWEEN DATES
                              </label>
                         </div>
                         <div class="form-group">
                              <label name='CEXP_fromdate' id='CEXP_lbl_fromdate' class="col-sm-3"  hidden >ENTER A FROM  DATE <em>*</em></label>
                              <div class="col-sm-2" id="CEXP_span_selected_from_date" hidden >
                                  <div class="input-group addon" style="padding-bottom:15px;">
                                      <input type="text" name="selected_from_date" id="CEXP_db_selected_from_date" style="display: none" class="datemandtry form-control" hidden placeholder="Date">
                                      <label for="CEXP_db_selected_from_date" class="input-group-addon" ><span class="glyphicon glyphicon-calendar"></span></label>
                                  </div>
                              </div>
                         </div>
                         <div class="form-group">
                             <label name='CEXP_todate' id='CEXP_lbl_todate' class="col-sm-3"  hidden>ENTER A  TO DATE <em>*</em> </label>
                             <div class="col-sm-2" id="CEXP_span_selected_to_date" hidden >
                                 <div class="input-group addon"  >
                                     <input type="text" name="selected_to_date" id="CEXP_db_selected_to_date" style="display: none" class="datemandtry form-control" hidden placeholder="Date">
                                     <label for="CEXP_db_selected_to_date" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                 </div>
                             </div>
                         </div>
                   </div>
                   <div class="form-group" style="position:relative;left:12px;"><input class="maxbtn" type="button" name="submit" value="SHOW LIST" id="CEXP_btn_submit"   disabled/></div>
            </div>
            <div id="CEXP_tble_Weekly_expiry_list" hidden>
                <div><label class="srctitle" style="text-align:CENTER;width:400px">WEEKLY CUSTOMER EXPIRY LIST</label></div>
                <div class="form-group">
                      <label class="col-sm-4" >ENTER THE WEEK AHEAD GOING TO EXPIRE<em>*</em></label>
                      <div class="col-sm-2" >
                          <input type='text' name="CWEXP_TB_weekBefore" id="CWEXP_TB_weekBefore"  style="width:17px" class='numonly submitvalidate'  />
                      </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4">SELECT THE EMAIL ID<em>*</em></label>
                    <div class="col-sm-4">
                        <select name="CWEXP_email" id="CWEXP_lb_selectemail" title="EMAIL ADDRESS" class="form-control submitvalidate ">
                            <option value='SELECT' selected="selected"> SELECT</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group" id="CWEXP_tble_buttontable">
                <div class="col-sm-offset-1 col-sm-3">
                    <input class="btn" type="button" name="submit" value="SEND" id="CWEXP_btn_submit"  disabled/>
                    <input class="btn" type="button" name="reset" value="RESET" id="CWEXP_btn_reset"  />
                </div>
            </div>
            <div>
                <label name="CEXP_msg" id="CEXP_lbl_msg" class="srctitle errormsg"   visible="false"/>
                <label name="CWEXP_msg" id="CWEXP_lbl_msg" class="srctitle errormsg"   visible="false"/>
            </div>
            <div id='CWEXP_pdf' hidden>
                <div>
                    <input type="button" id='CEXP_btn_pdf' class="btnpdf" value="PDF">
                </div>
            </div><br>
            <div    class="table-responsive" id ="CEXP_div_htmltable" >
                <section>
                </section>
            </div>
        </div>
    </form>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->