<!--//*******************************************FILE DESCRIPTION*********************************************//
//************************************CUSTOMER CANCEL***********************************************//
//DONE BY:SAFI
VER 0.02- SD:20/06/2015 ED:20/06/2015-remove duplicate cust radio option.
VER 0.01 - INITIAL VERSION-SD:22/05/2015 ED:26/05/2015
//*********************************************************************************************************//
-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
<script>

$(document).ready(function(){
    $('#spacewidth').height('0%');
    $(".preloader").show();
    $('textarea').autogrow({onInitialize: true});
    var CCAN_errorAarray=[];
    var controller_url="<?php echo base_url(); ?>" + '/index.php/CUSTOMER/CUSTOMER/Ctrl_Customer_Cancel_Uncancel/' ;
    $.ajax({
        type:'post',
        'url':controller_url+"CCAN_getcustomer",
        success:function(data){
            $(".preloader").hide();
            var CCAN_initialvalues_result=JSON.parse(data);
            CCAN_errorAarray=CCAN_initialvalues_result[0].CCAN_error_msg;
            var CCAN_check_customer=CCAN_initialvalues_result[0].CCAN_cust_values;
            if(CCAN_check_customer=='true'){
                $('#CCAN_tble_main').show();
            }
            else{
                var CCAN_err_msg=CCAN_errorAarray[1].EMC_DATA+'  &  '+CCAN_errorAarray[3].EMC_DATA;
                $('#CCAN_form_cancelform').replaceWith('<p><label class="errormsg"> '+CCAN_err_msg+'</label></p>');
            }
        },
        error:function(data){
           show_msgbox("CUSTOMER CANCELLATION",JSON.stringify(data),"error",false);
        }
    });
    $('#CCAN_radio_cancellist').change(function(){
        var  newPos= adjustPosition($(this).position(),100,260);
        resetPreloader(newPos);
        $(".preloader").show();
        var CCAN_select_type=$('#CCAN_radio_cancellist').val()
        $('#CCAN_tble_unitno').hide();
        $('#CCAN_div_cancelform').hide();
        $('#CCAN_custname').hide();
        $('#CCAN_lbl_errmsg').hide();
        $('#CCAN_div_buttons').hide();
        $('#CCAN_tble_guest_cardno > div').remove();
        $('#CCAN_lb_selectname').hide();
        $('#CCAN_lb_selectname').prop('selectedIndex',0);
        $('#CCAN_lbl_cname').hide();
        $('#CCAN_div_uncancelbuttons').hide();
        $('input:radio[name=CCAN_id]').attr('checked',false);
        $('#CCAN_tble_id > div').remove();
        $('#CCAN_tble_unitno').hide();
        $('#CCAN_lbl_title').text("CANCEL CUSTOMER").show();
        $.ajax({
            type:'post',
            'url':controller_url+"CCAN_getcustomer_details",
            data:{'CCAN_select_type':CCAN_select_type},
            success:function(data){
                var response_unit=JSON.parse(data);
                CCAN_loadUnitNo(response_unit)  ;
            },
            error:function(data){
               show_msgbox("CUSTOMER CANCELLATION",JSON.stringify(data),"error",false);
            }
        });
    });
    $('#CCAN_radio_uncancellist').change(function(){
        var  newPos= adjustPosition($(this).position(),100,260);
        resetPreloader(newPos);
        $(".preloader").show();
        $('#CCAN_div_cancelform').hide();
        $('#CCAN_lbl_errmsg').hide();
        $('#CCAN_div_buttons').hide();
        $('#CCAN_custname').hide();
        $('#CCAN_tble_guest_cardno > div').remove();
        $('#CCAN_lb_selectname').hide();
        $('#CCAN_lb_selectname').prop('selectedIndex',0);
        $('#CCAN_lbl_cname').hide();
        $('input:radio[name=CCAN_id]').attr('checked',false);
        $('#CCAN_tble_id > div').remove();
        var CCAN_select_type=$('#CCAN_radio_uncancellist').val()
        $('#CCAN_tble_unitno').hide();
        $('#CCAN_lbl_title').text("UNCANCEL CUSTOMER").show();
        $.ajax({
            type:'post',
            'url':controller_url+"CCAN_getcustomer_details",
            data:{'CCAN_select_type':CCAN_select_type},
            success:function(data){
                var response_unit=JSON.parse(data);
                CCAN_loadUnitNo(response_unit)  ;
            },
            error:function(data){
                show_msgbox("CUSTOMER CANCELLATION",JSON.stringify(data),"error",false);
            }
        });
    });
    //-----UNIT NO CHANGE FUNCTION-----------------
    $('#CCAN_lb_selectunit').change(function(){
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        var CCAN_unit = $(this).val();
        if(CCAN_unit=='SELECT'){
            $('#CCAN_div_cancelform').hide();
            $('#CCAN_div_buttons').hide();
            $('#CCAN_div_uncancelbuttons').hide();
            $('#CCAN_tble_guest_cardno > div').remove();
            $('#CCAN_lb_selectname').hide();
            $('#CCAN_lb_selectname').prop('selectedIndex',0);
            $('#CCAN_custname').hide();
            $('#CCAN_lbl_cname').hide();
            $('input:radio[name=CCAN_id]').attr('checked',false);
            $('#CCAN_tble_id > div').remove();
        }
        else{
            $('#CCAN_lb_selectname').hide();
            $('#CCAN_div_buttons').hide();
            $('#CCAN_div_uncancelbuttons').hide();
            $('#CCAN_lb_selectname').prop('selectedIndex',0);
            $('#CCAN_lbl_cname').hide();
            $('#CCAN_div_cancelform').hide();
            $('input:radio[name=CCAN_id]').attr('checked',false);
            $('#CCAN_tble_id > div').remove();
            $('#CCAN_tble_guest_cardno > div').remove();
            var CCAN_namearray=[];
            for(var k=0;k<CCAN_all_result.length;k++){
                if(CCAN_all_result[k].unit==CCAN_unit){
                    CCAN_namearray.push(CCAN_all_result[k].name);
                }
            }
            CCAN_namearray=unique(CCAN_namearray);
            var CCAN_custname_options ='<option>SELECT</option>'
            for (var i = 0; i < CCAN_namearray.length; i++) {
                var CCAN_myarray=CCAN_namearray[i].split('_');
                var CCAN_custname=CCAN_myarray[0]+' '+CCAN_myarray[1];
                CCAN_custname_options += '<option value="' + CCAN_namearray[i] + '">' + CCAN_custname + '</option>';
            }
            $('#CCAN_lb_selectname').html(CCAN_custname_options)
            $('#CCAN_lb_selectname').show();
            $('#CCAN_custname').show();
        }
    });
   //------------CUSTOMER NAME CHANGE FUNCTION------------------
    var CCAN_name_recver;
    $('#CCAN_lb_selectname').change(function(){
        var CCAN_name=$(this).val();
        var CCAN_unit_no=$('#CCAN_lb_selectunit').val();
        if(CCAN_name=='SELECT'){
            $('#CCAN_lbl_error').hide();
            $('#CCAN_div_cancelform').hide();
            $('#CCAN_div_buttons').hide();
            $('#CCAN_div_uncancelbuttons').hide();
            $('#CCAN_tble_guest_cardno > div').remove();
            $('input:radio[name=CCAN_id]').attr('checked',false);
            $('#CCAN_tble_id > div').remove();
        }
        else{
            $(".preloader").show();
            $('#CCAN_lbl_error').hide();
            $('#CCAN_div_buttons').hide();
            $('#CCAN_div_uncancelbuttons').hide();
            $('#CCAN_div_cancelform').hide();
            $('#CCAN_tble_guest_cardno > div').remove();
            $('input:radio[name=CCAN_id]').attr('checked',false);
            $('#CCAN_tble_id > div').remove();
            var CCAN_name_id_array=[];
            for(var k=0;k<CCAN_all_result.length;k++)
            {
                if((CCAN_all_result[k].name==CCAN_name)&& (CCAN_all_result[k].unit==CCAN_unit_no))
                {
                    CCAN_name_id_array.push(CCAN_all_result[k].customerid);
                }
            }
            CCAN_name_id_array=CCAN_name_id_array.sort();

                for(var k=0;k<CCAN_all_result.length;k++){
                    if(CCAN_all_result[k].customerid==CCAN_name_id_array[0]){
                        CCAN_name_recver=(CCAN_all_result[k].recver);
                    }
                }
                cust_id=CCAN_name_id_array[0];
               //HANDLER TO GET CUSTOMER DETAIL'S
                var CCAN_select_type = $('input:radio[name=CCAN_mainradiobutton]:checked').val();
                $.ajax({
                    type:'post',
                    url:controller_url+"CCAN_get_customervalues",
                    data:{'CCAN_select_type':CCAN_select_type,'CCAN_name_recver':CCAN_name_recver,'cust_id':CCAN_name_id_array[0]},
                    success:function(data){
                        var response_unit=JSON.parse(data);
                        CCAN_load_customerdetails(response_unit)  ;
                    },
                    error:function(data){
                          show_msgbox("CUSTOMER CANCELLATION",JSON.stringify(data),"error",false);
                    }
                });
                $('#CCAN_tble_id > div').remove();
//            }
        }
    });
    $('.clear').click(function(){
        CCAN_clear('RESET');
    });
    $('#CCAN_lb_selectname').hide();
    $('#CCAN_lbl_cname').hide();
    $('#CCAN_lbl_unitno').hide();
    $('#CCAN_lb_selectunit').hide();
    //FUNCTION TO CHECK CUSTOMER AVAILABLE
    function CCAN_checkcustomer(CCAN_initialvalues_result){
        CCAN_errorAarray=CCAN_initialvalues_result[0].CCAN_error_msg;
        var CCAN_check_customer=CCAN_initialvalues_result[0].CCAN_cust_values;
        if(CCAN_check_customer=='true'){
            $('#CCAN_tble_main').show();
        }
        else{
            var CCAN_err_msg=CCAN_errorAarray[1]+'  &  '+CCAN_errorAarray[3]
            $('#CCAN_form_cancelform').replaceWith('<p><label class="errormsg"> '+CCAN_err_msg+'</label></p>');
        }

    }
    //FUNCTION TO LOAD INITIAL VALUES
    var CCAN_all_result=[]
    function CCAN_loadUnitNo(CCAN_unitno){
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        $(".preloader").hide();
        CCAN_all_result=CCAN_unitno;
        var CCAN_select_type = $('input:radio[name=CCAN_mainradiobutton]:checked').val();
        if(CCAN_all_result.length==0){
            $('#CCAN_unitno').hide();
            if(CCAN_select_type=="CANCEL CUSTOMER"){
                $('#CCAN_lbl_title').hide();
                $('#CCAN_lbl_errmsg').text(CCAN_errorAarray[1].EMC_DATA).show();
            }
            else{
                $('#CCAN_lbl_title').hide();
                $('#CCAN_lbl_errmsg').text(CCAN_errorAarray[3].EMC_DATA).show();
            }
        }
        else{
            var unit_array=[];
            for(var k=0;k<CCAN_all_result.length;k++){
                unit_array.push(CCAN_all_result[k].unit)
            }
            unit_array=unique(unit_array);
            var CCAN_unitno_options ='<option>SELECT</option>'
            for (var i = 0; i < unit_array.length; i++) {
                CCAN_unitno_options += '<option value="' + unit_array[i] + '">' + unit_array [i]+ '</option>';
            }
            $('#CCAN_lb_selectunit').html(CCAN_unitno_options);
            $('#CCAN_tble_unitno').show();
            $('#CCAN_lbl_unitno').show();
            $('#CCAN_unitno').show();
            $('#CCAN_lb_selectunit').show();
        }
    }
    function unique(a) {
        var result = [];
        $.each(a, function(i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
    }
    //FUNCTION TO CALL RADIO BUTTON CLICK
    var cust_id;

    ///////////////************ FUNCTION TO LOAD CUSTOMER DETAILS***********////////////////////
    function CCAN_load_customerdetails(data){
        $(".preloader").hide();
        $("html, body").animate({ scrollTop: $(document).height() }, "fast");
        var CCAN_customer_details=[];
        CCAN_customer_details=data[0];
        var CCAN_guest_array=data[1];
        var CCAN_fname_length=(CCAN_customer_details.firstname).length;
        var CCAN_lname_length=(CCAN_customer_details.lastname).length
        var CCAN_email_length=(CCAN_customer_details.email).length
        var CCAN_nation_length=(CCAN_customer_details.nationality).length;
        if(CCAN_customer_details.company!=null){
            var CCAN_companyname_length=(CCAN_customer_details.company).length;
            $('#CCAN_tb_companyname').attr("size",CCAN_companyname_length+9)
        }
        var CCAN_roomtype_length=(CCAN_customer_details.roomtype).length;
        if(CCAN_customer_details.cardno!=null){
            var CCAN_card_no_length=(CCAN_customer_details.cardno).length;
            $('#CCAN_tb_cardno').attr("size",CCAN_card_no_length)
        }
        else{
            $('#CCAN_tb_cardno').attr("size",7)
        }
        var CCAN_startdate=CCAN_customer_details.startdate;
        CCAN_startdate=FormTableDateFormat(CCAN_startdate);
        var CCAN_enddate=CCAN_customer_details.enddate;
        CCAN_enddate=FormTableDateFormat(CCAN_enddate);
        var CCAN_passportdate=CCAN_customer_details.passportdate;
        if(CCAN_passportdate!=null){
            CCAN_passportdate=FormTableDateFormat(CCAN_passportdate);
        }
        var CCAN_dob=CCAN_customer_details.dob;
        if(CCAN_dob!=null){
            CCAN_dob=FormTableDateFormat(CCAN_dob);
        }
        var CCAN_passportdate=CCAN_customer_details.passportdate;
        if(CCAN_passportdate!=null){
            CCAN_passportdate=FormTableDateFormat(CCAN_passportdate)
        }
        var CCAN_epdate=CCAN_customer_details.epdate;
        if(CCAN_epdate!=null){
            CCAN_epdate=FormTableDateFormat(CCAN_epdate)
        }
        var CCAN_noticedate=CCAN_customer_details.noticedate;
        if(CCAN_noticedate!=null){
            CCAN_noticedate=FormTableDateFormat(CCAN_noticedate)
        }
        $('#CCAN_tb_lastname').attr("size",CCAN_lname_length+3);
        $('#CCAN_tb_firstname').attr("size",CCAN_fname_length+3);
        $('#CCAN_tb_email').attr("size",CCAN_email_length+4);
        $('#CCAN_tb_nation').attr("size",CCAN_nation_length+6);
        $('#CCAN_tb_roomtype').attr("size",CCAN_roomtype_length+3);
        $('#CCAN_tb_firstname').val(CCAN_customer_details.firstname);
        $('#CCAN_tb_lastname').val(CCAN_customer_details.lastname);
        $('#CCAN_tb_email').val(CCAN_customer_details.email);$('#CCAN_tb_mobileno').val(CCAN_customer_details.mobile1);
        $('#CCAN_tb_intmobileno').val(CCAN_customer_details.mobile2);$('#CCAN_tb_officeno').val(CCAN_customer_details.officeno);
        $('#CCAN_tb_dob').val(CCAN_dob);$('#CCAN_tb_passno').val(CCAN_customer_details.passportno);
        $('#CCAN_tb_passdate').val(CCAN_passportdate);$('#CCAN_tb_epno').val(CCAN_customer_details.epno);
        $('#CCAN_tb_epdate').val(CCAN_epdate);$('#CCAN_tb_roomtype').val(CCAN_customer_details.roomtype);
        $('#CCAN_tb_cardno').val(CCAN_customer_details.cardno);
        $('#CCAN_tb_startdate').val(CCAN_startdate);
        $('#CCAN_tb_enddate').val(CCAN_enddate);
        $('#CCAN_tb_noticeperiod').val(CCAN_customer_details.noticeperiod);
        $('#CCAN_tb_noticedate').val(CCAN_noticedate);$('#CCAN_tb_elect').val(CCAN_customer_details.electricitycap);
        $('#CCAN_tb_drycleanfee').val(CCAN_customer_details.drycleanfee);$('#CCAN_tb_checkoutcleaningfee').val(CCAN_customer_details.checkoutcleaningfee);
        $('#CCAN_tb_deposit').val(CCAN_customer_details.deposit);$('#CCAN_tb_rent').val(CCAN_customer_details.rental);
        $('#CCAN_tb_processingfee').val(CCAN_customer_details.processingfee);
        $('#CCAN_ta_comments').val(CCAN_customer_details.comments);
        $('#CCAN_tb_companyname').val(CCAN_customer_details.company);
        $('#CCAN_tb_nation').val(CCAN_customer_details.nationality);
        var CCAN_quaterlyfee=CCAN_customer_details.airconquartelyfee
        var CCAN_fixedfee=CCAN_customer_details.airconfixedfee
        if(CCAN_quaterlyfee==null){
            $('#CCAN_tb_fixed').val(CCAN_customer_details.airconfixedfee)
            $('#CCAN_lbl_fixedfee').text("AIRCON FIXED FEE")
            $('#CCAN_tb_fixed').show();
        }
        else {
            $('#CCAN_tb_fixed').val(CCAN_customer_details.airconquartelyfee)
            $('#CCAN_lbl_fixedfee').text("AIRCON QUATERLY FEE")
            $('#CCAN_tb_fixed').show();
        }
        if(CCAN_guest_array.length!=0){
            var CCAN_guestcard='';
            for (var i = 0; i < CCAN_guest_array.length; i++) {
                CCAN_guestcard = "<div class='form-group'><label class='col-sm-3'>GUEST"+(i+1)+" CARD </label> <div class='col-sm-2'><input type='text' name='CCAN_tb_cardno' id='+CCAN_guest_array[i]+' value="+CCAN_guest_array[i]+"  class='form-control' readonly  /></div></div>";
                $('#CCAN_tble_guest_cardno').append(CCAN_guestcard);
            }
        }
        else{
            $('#CCAN_tble_guest_cardno > div').remove();
        }
        $('#CCAN_tble_personaldetails').show();
        $('#CCAN_tble_third').show();
        $('#CCAN_tble_feedetails').show();
        $('#CCAN_tble_guest_cardno').show();
        $('#CCAN_div_cancelform').show();
        $('#CCAN_tble_comment').show();
        var CCAN_select_type = $('input:radio[name=CCAN_mainradiobutton]:checked').val();
        if(CCAN_select_type=="CANCEL CUSTOMER"){
            $('#CCAN_div_buttons').show();
            $('#CCAN_div_uncancelbuttons').hide();
        }
        if(CCAN_select_type=="UNCANCEL CUSTOMER"){
            $('#CCAN_div_uncancelbuttons').show();
            $('#CCAN_div_buttons').hide();
        }
    }
    //******************** FUNCTION TO SHOW EXCEPTION**********************
    function CCAN_error(error){
        if(error=="ScriptError: Failed to establish a database connection. Check connection string, username and password.")
        {
            error="DB USERNAME/PWD WRONG, PLZ CHK UR CONFIG FILE FOR THE CREDENTIALS."
            $('#CCAN_form_cancelform').replaceWith('<center><label class="dberrormsg">'+error+'</label></center>');
        }
        else{
            if(error=='TypeError: Cannot call method "getEvents" of undefined.'||error=='TypeError: Cannot call method "createEvent" of undefined.')
            {
                error=CCAN_errorAarray[6];
            }
            else if(error=='ScriptError: No item with the given ID could be found, or you do not have permission to access it.')
            {
                error=CCAN_errorAarray[6];
            }
            else{
                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER CANCELLATION",msgcontent:error,position:{top:150,left:500}}});
            }
        }
    }
//*********************FUNCTION TO CLEAR FORM*************************
    function CCAN_clear(response)
    {
        $(".preloader").hide();
        $('#CCAN_div_cancelform').hide();
        $('#CCAN_lbl_cname').hide();
        $('#CCAN_lb_selectname').hide();
        $('#CCAN_custname').hide();
        $('#CCAN_lb_selectname').prop('selectedIndex',0);
        $('#CCAN_tble_id > div').remove();
        $('#CCAN_div_buttons').hide();
        $('#CCAN_div_uncancelbuttons').hide();
        $('input:radio[name=CCAN_id]').attr('checked',false);
        if(response[0]==1 && response[1]==1)
        {
            $('#CCAN_lbl_unitno').hide();
            var CCAN_select_type = $('input:radio[name=CCAN_mainradiobutton]:checked').val();
            $.ajax({
                type:'post',
                'url':controller_url+"CCAN_getcustomer_details",
                data:{'CCAN_select_type':CCAN_select_type},
                success:function(data){
                    var response_unit=JSON.parse(data);
                    CCAN_loadUnitNo(response_unit)  ;
                },
                error:function(data){
                    show_msgbox("CUSTOMER CANCELLATION",JSON.stringify(data),"error",false);
                }
            });
            $('#CCAN_lb_selectunit').prop('selectedIndex',0).hide();
            if(CCAN_select_type=="CANCEL CUSTOMER"){
                show_msgbox("CUSTOMER CANCELLATION",CCAN_errorAarray[0].EMC_DATA,"success",false);
            }
            else{
                show_msgbox("CUSTOMER CANCELLATION",CCAN_errorAarray[4].EMC_DATA,"success",false);
            }
        }
        else if(response[0]==1 && response[1]!=1){
            show_msgbox("CUSTOMER CANCELLATION",CCAN_errorAarray[6].EMC_DATA,"error",false);
        }
        else if(response[0]==0){
            if(CCAN_select_type=="CANCEL CUSTOMER"){
                show_msgbox("CUSTOMER CANCELLATION",CCAN_errorAarray[5].EMC_DATA,"success",false);
            }
            else{
              show_msgbox("CUSTOMER CANCELLATION",CCAN_errorAarray[5].EMC_DATA,"success",false);
            }
            $('#CCAN_lbl_unitno').show();
            $('#CCAN_lb_selectunit').prop('selectedIndex',0).show();
        }
        else if(response=='RESET'){
            $('#CCAN_lbl_unitno').show();
            $('#CCAN_lb_selectunit').prop('selectedIndex',0).show();
        }
        else{
            if(CCAN_select_type=="CANCEL CUSTOMER"){
                show_msgbox("CUSTOMER CANCELLATION",response,"success",false);
            }
            else{
                show_msgbox("CUSTOMER CANCELLATION",response,"success",false);
            }
            $('#CCAN_lbl_unitno').show();
            $('#CCAN_lb_selectunit').prop('selectedIndex',0).show();

        }
    }
//FUNCTION TO CALL SUBMIT BUTTON
    $('#CCAN_btn_submitbutton').click(function(){
        $(".preloader").show();
        var form_element=$('#CCAN_form_cancelform').serialize()
        $.ajax({
            type:'post',
            url:controller_url+"CCAN_cancel",
            data:form_element+"&cust_id="+cust_id+"&CCAN_name_recver="+CCAN_name_recver,
            success:function(data){
                var final_value=JSON.parse(data);
                CCAN_clear(final_value);


            },
            error:function(data){

            show_msgbox("CUSTOMER CANCELLATION",JSON.stringify(data),"error",false);
        }

        });
    });
    $('#CCAN_btn_uncancelbutton').click(function(){
        $(".preloader").show();
        var form_element=$('#CCAN_form_cancelform').serialize()
        $.ajax({
            type:'post',
            url:controller_url+"CCAN_uncancel",
            data:form_element+"&cust_id="+cust_id+"&CCAN_name_recver="+CCAN_name_recver,
            success:function(data){

                var final_value=JSON.parse(data);
                CCAN_clear(final_value);

            },
            error:function(data){

            show_msgbox("CUSTOMER CANCELLATION",JSON.stringify(data),"error",false);
        }
        });
    });
//FUNCTION TO CONVERT DATE FORMAT
    function FormTableDateFormat(inputdate){
        var string = inputdate.split("-");
        return string[2]+'-'+ string[1]+'-'+string[0];
    }
});
</script>
<!---SCRIPT TAG END--->
</head>
<!---HEAD TAG END--->
<!---BODY TAG START--->


<body>
<div class="container">
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>CUSTOMER CANCELLATION</b></h4></div>
    <form id="CCAN_form_cancelform" name="CCAN_cancel_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div style="padding-bottom: 15px" id="CCAN_tble_main" hidden>
                    <div class="radio">
                        <label >
                            <input  type="radio"  name="CCAN_mainradiobutton" id="CCAN_radio_cancellist"  value="CANCEL CUSTOMER" >
                            CANCEL CUSTOMER
                        </label>
                    </div>
                    <div class="radio">
                        <label >
                            <input type="radio" name="CCAN_mainradiobutton" id="CCAN_radio_uncancellist" value="UNCANCEL CUSTOMER" >
                            UNCANCEL CUSTOMER
                        </label>

                    </div>

                 </div>
                <div><lable id="CCAN_lbl_errmsg" class="errormsg" hidden></lable></div>
                <div><label id="CCAN_lbl_title" class="srctitle" style="text-align:CENTER;width:400px" hidden></label></div>
                <div id='CCAN_tble_unitno'  hidden>
                     <div class="form-group" id="CCAN_unitno">
                       <label class="col-sm-3">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"> <select name="CCAN_unitnumber" id="CCAN_lb_selectunit" class="form-control "></select></div>
                </div>
                </div>
                <div class="form-group" id="CCAN_custname" hidden>
                    <label class="col-sm-3">CUSTOMER NAME <em>*</em></label>
                    <div class="col-sm-3"><select name="CCAN_name" id="CCAN_lb_selectname" class="CCAN_formvalidation form-control"></select></div>
                </div>
                <div id="CCAN_div_cancelform" hidden>
                    <div id='CCAN_tble_personaldetails'>
                        <div class="form-group">
                            <label class="col-sm-3">FIRST NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_firstname" id="CCAN_tb_firstname"  class="form-control CCAN_formvalidation" maxlength="50" readonly /></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">LAST NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_lastname" id="CCAN_tb_lastname"  maxlength="50" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">COMPANY NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_companyname" id="CCAN_tb_companyname"  class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EMAIL ID</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_email" id="CCAN_tb_email"  maxlength="50" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">MOBILE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_mobileno" id="CCAN_tb_mobileno"  maxlength="6" style="width:90px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">INT'L MOBILE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_intmobileno" id="CCAN_tb_intmobileno"  maxlength="15" style="max-width:200px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">OFFICE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_officeno" id="CCAN_tb_officeno"  maxlength="8"  style="width:90px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">DATE OF BIRTH</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_dob" id="CCAN_tb_dob"  maxlength="50" style="width:110px;" class="form-control CCAN_formvalidation" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NATIONALITY</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_nation" id="CCAN_tb_nation"  maxlength="50"  class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PASSPORT NUMBER</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_passno" id="CCAN_tb_passno"  maxlength="15" style="max-width:170px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PASSPORT EXPIRY DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_passdate" id="CCAN_tb_passdate"  style="width:110px;" maxlength="50" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EP NUMBER</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_epno" id="CCAN_tb_epno"  maxlength="15" style="max-width:170px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EP EXPIRY DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_epdate" id="CCAN_tb_epdate" style="width:110px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">ROOM TYPE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_roomtype" id="CCAN_tb_roomtype" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CUSTOMER CARD </label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_cardno[]" id="CCAN_tb_cardno" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                    </div>
                    <div  id="CCAN_tble_guest_cardno"></div>
                    <div id="CCAN_tble_feedetails">
                        <div class="form-group">
                            <label class="col-sm-3">CHECK IN DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_startdate" id="CCAN_tb_startdate" style="width:110px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CHECK OUT DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_enddate" id="CCAN_tb_enddate" style="width:110px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NOTICE PERIOD</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_noticeperiod" id="CCAN_tb_noticeperiod" style="width:45px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NOTICE DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_noticedate" id="CCAN_tb_noticedate" style="width:110px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">ELECTRICITY CAPPED</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_elect" id="CCAN_tb_elect" style="width:77px;"class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label id="CCAN_lbl_fixedfee" class="col-sm-3">AIRCON FIXED FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_fixed" id="CCAN_tb_fixed" style="width:77px;" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CURTAIN DRY CLEANING FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_drycleanfee" id="CCAN_tb_drycleanfee"  style="width:77px;" maxlength="50" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CHECKOUT CLEANING FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_checkoutcleaningfee" style="width:77px;" id="CCAN_tb_checkoutcleaningfee"  maxlength="50" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">DEPOSIT</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_deposit" id="CCAN_tb_deposit" style="width:77px; " maxlength="50" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">RENT</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_rent" id="CCAN_tb_rent" style="width:77px;" maxlength="50" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PROCESSING COST</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_processingfee" style="width:77px;" id="CCAN_tb_processingfee" maxlength="50" class="form-control CCAN_formvalidation"  readonly/></div>
                        </div>
                    </div>
                    <div id='CCAN_tble_comment'>
                        <div class="form-group">
                            <label class="col-sm-3">COMMENTS</label>
                            <div class="col-sm-4"><textarea name="CCAN_ta_comments" id="CCAN_ta_comments" class="form-control CCAN_formvalidation" rows="5"></textarea></div>
                        </div>
                    </div>
                    </div>
                        <div class="form-group" id="CCAN_div_buttons"  hidden>
                            <div class="col-sm-offset-1 col-sm-3">
                                <input class="btn" type="button"  id="CCAN_btn_submitbutton" name="submit" value="CANCEL"  />
                               <input class="btn clear" type="button"  id="CCAN_btn_resetbutton" name="reset" value="RESET"  />
                            </div>
                        </div>
                        <div  id="CCAN_div_uncancelbuttons"  hidden>
                            <div class="col-sm-offset-1">
                               <input class="maxbtn" type="button"  id="CCAN_btn_uncancelbutton" name="submit" value="UNCANCEL"  />
                               <input class="maxbtn clear" type="button"  id="CCAN_btn_resetbutton1" name="reset" value="RESET"  />

                            </div>
                        </div>

            </fieldset>
        </div>
    </form>
</div>
</body>
<!---BODY TAG END-->
</html>
<!---HTML TAG END-->