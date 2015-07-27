<?php
//******************************************Existing Unit********************************************//
//VER 0.02-SD:25/05/2015 ED:25/05/2015,did save part BY RAJA
//VER 0.01-SD:22/05/2015 ED:23/05/2015,completed form design and validation BY RAJA
//*******************************************************************************************************//
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <style>
        .errpadding{
            padding-top: 10px;
        }
        .colsmhf {
            width: 11.666%;
            padding-top: 2px;
            padding-left: 15px;
            padding-right: 0px;
        }
    </style>
    <script type="text/javascript">
    // document ready function
        $(document).ready(function(){
            var ctrl_existingunit_url="<?php echo site_url('UNIT/Ctrl_Unit_Existing_Unit'); ?>";
            var EU_room_arr=[];
            var EU_errorMsg_array=[];
            var EU_stamp=[];
            var EU_unitno_arr=[];
            var EU_unitno='SELECT';
            var EU_flag_access=1;
            var EU_flag_unit=1;
            var EU_flag_room='true';
            var EU_flag_stamp='true';
            var EU_deposit='';
            var EU_nonactive_arr=[];
            var EU_flg_Login=1;
            var EU_flg_Doorcode=1;
            var EU_unit_source= '';
            $('#spacewidth').height('0%');
            $('#EU_radio_activeunit').focus();
        // initial data
            $.ajax({
                type: "POST",
                url: ctrl_existingunit_url+'/Initialdata',
                data: {'EU_unitno':EU_unitno,'flag':'EU_flag_unitno_errormsg'},
                success: function(data) {
                    var initial_values=JSON.parse(data);
                    EU_result(initial_values);
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("EXISTING UNIT",errordata,'error',false);
                    $('.preloader').hide();
                }
            });
        //SUCCESS FUNCTION FOR LOAD STAMP,ROOM TYPE PLUS ERROR MSG
            function EU_result(EU_response_arr){
                $('.preloader').hide();
                var EU_response=EU_response_arr[0];
                var EU_unitno=EU_response.EU_unitno_flag;
                if(EU_response.EU_unitno_err_roomstamp_flag=='EU_flag_unitno_errormsg'){
                    EU_errorMsg_array=EU_response.EU_errarray;
                    EU_unitno_arr=EU_response.EU_unitno;
                    EU_nonactive_arr=EU_response.EU_nonactive;
                }
                else{
                    EU_room_arr=EU_response.EU_roomtype;
                    EU_stamp=EU_response.EU_stamp;
                    if((EU_response.EU_unitno_err_roomstamp_flag=='EU_flag_roomstamp')||(EU_response.EU_unitno_err_roomstamp_flag=='EU_flag_deposit_roomstamp')||(EU_response.EU_unitno_err_roomstamp_flag=='EU_flag_roomtype')){
                        if(EU_room_arr.length==0){
                            $('#EU_lb_oldroomtype').replaceWith('<input type="text" name="EU_tb_newroomtype" id="EU_tb_newroomtype" maxlength=30 class="EU_class_validupdate form-control autosize" placeholder="Room Type"/>');
                            $('#EU_btn_addroomtype').hide();
                            $('#EU_btn_removeroomtype').hide();
                            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
                        }
                        else{
                            var EU_roomoptions ='<option>SELECT</option>';
                            for (var i = 0; i < EU_room_arr.length; i++)
                            {
                                EU_roomoptions += '<option value="' + EU_room_arr[i]  + '">' + EU_room_arr[i] + '</option>';
                            }
                          // REPLACE TB INTO LB FOR ROOMTYPE & STAMPTYPE
                            $('#EU_btn_addroomtype').show();
                            $('#EU_tb_newroomtype').replaceWith('<select id="EU_lb_oldroomtype" name="EU_lb_oldroomtype" class="EU_class_validupdate form-control"><option>SELECT</option></select>');
                            $('#EU_btn_removeroomtype').replaceWith('<input type="button" name="EU_btn_addroomtype" value="ADD" id="EU_btn_addroomtype" class="btn btn-info EU_class_validupdate"/>');
                            $('#EU_lb_oldroomtype').html(EU_roomoptions).show();
                        }
                    }
                    if((EU_response.EU_unitno_err_roomstamp_flag=='EU_flag_roomstamp')||(EU_response.EU_unitno_err_roomstamp_flag=='EU_flag_deposit_roomstamp')||(EU_response.EU_unitno_err_roomstamp_flag=='EU_flag_stamptype')){
                        if(EU_stamp.length==0){
                            $('#EU_lb_oldstamptype').replaceWith('<input type="text" name="EU_tb_newstamptype" id="EU_tb_newstamptype" maxlength=12 class="EU_class_validupdate autosize alphaonly EU_class_title_alpha form-control" placeholder="Stamp Duty Type" />');
                            $('#EU_btn_addstamptype').hide();
                            $('#EU_btn_removestamptype').hide();
                            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
                            $(".EU_class_title_alpha").prop("title",EU_errorMsg_array[0].replace('NUMBERS','ALPHABETS').EMC_DATA);
                        }
                        else{
                            var EU_stampoptions ='<option>SELECT</option>';
                            for (var i = 0; i < EU_stamp.length; i++)
                            {
                                EU_stampoptions += '<option value="' + EU_stamp[i]  + '">' + EU_stamp[i] + '</option>';
                            }
                            if(EU_unit_source=='EU_radio_nonactiveunit'){
                                $("#EU_tble_resetupdatebtn").show();
                            }
                            $('#EU_btn_addstamptype').show();
                            $('#EU_tb_newstamptype').replaceWith('<select id="EU_lb_oldstamptype" name="EU_lb_oldstamptype" class="EU_class_validupdate form-control"><option>SELECT</option></select>');
                            $('#EU_btn_removestamptype').replaceWith('<input type="button" name="EU_btn_addstamptype" value="ADD" id="EU_btn_addstamptype" class="btn btn-info EU_class_validupdate">');
                            $('#EU_lb_oldstamptype').html(EU_stampoptions).show();
                        }
                    }
                // SUCCESS FUNCTION FOR OTHER DETAILS
                    if(EU_response.EU_unitno_err_roomstamp_flag=='EU_flag_deposit_roomstamp'){
                        var EU_response_deposit=EU_response_arr[1];
                        $("#EU_tble_resetupdatebtn").show();
                        if(EU_response_deposit==''){
                            $("#EU_tb_unitdeposite").prop("readonly", false);
                            $("#EU_div_others").show();
                        }
                        else{
                            $("#EU_div_others").show();
                            EU_deposit=EU_response_deposit;
                            $("#EU_tb_unitdeposite").val(EU_response_deposit);
                            $("#EU_tb_unitdeposite").prop("readonly", true);
                            $("#EU_tb_unitdeposite").prop("title",'');
                            $("#EU_tb_unitdeposite").addClass('rdonly');
                        }
                    }
                    $(".preloader").hide();
                }
                $(".EU_class_numsonly").prop("title",EU_errorMsg_array[0].EMC_DATA);
                $('#EU_lb_unitnumber').val(EU_unitno);
                $('#EU_form_existingUnit').show();
            }
            var EU_max = 250;
        // KEYPRESS EVENT OF BANK ADDRESSS
            $('#EU_tb_bankaddrs').keypress(function(e) {
                if (e.which < 0x20) {
                    return;
                }
                if (this.value.length == EU_max) {
                    e.preventDefault();
                } else if (this.value.length > EU_max) {
                    this.value = this.value.substring(0, EU_max);
                }
            });
        // VALIDATION FOR NUMBERS AND AMOUNT VALUES
            $("#EU_tb_stampamount").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
            $(".numonly").doValidation({rule:'numbersonly',prop:{leadzero:true}});
            $('textarea').autogrow({onInitialize: true});
        // DATE FUNCTION FOR STAMPDUTYDATE
            $("#EU_db_stampdutydate").datepicker({dateFormat:"dd-mm-yy",changeYear: true,changeMonth: true});
            $("#EU_tb_accesscard,#EU_tb_unitdeposite").doValidation({rule:'numbersonly',prop:{leadzero:false}});
        // REPLACE NEW ROOM TYPE
            $(document).on('click','#EU_btn_addroomtype,#EU_btn_removeroomtype',function(){
                var EU_unitno=$('#EU_lb_unitnumber').val();
                $('#EU_div_errroom').text('');
                if($(this).attr('id')=="EU_btn_addroomtype"){
                    EU_flag_room='false';
                    $('#EU_lb_oldroomtype').replaceWith('<input type="text" name="EU_tb_newroomtype" id="EU_tb_newroomtype" maxlength=30 class="EU_class_validupdate autosize form-control" placeholder="Room Type"/>');
                    $(this).replaceWith('<input type="button" name="EU_btn_removeroomtype" value="CLEAR" id="EU_btn_removeroomtype" class="btn btn-info EU_class_validupdate" />');
                    $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                }
                if($(this).attr('id')=='EU_btn_removeroomtype'){
                    EU_flag_room='true';
                    if((($("#EU_tb_unitdeposite").val()=='')||($("#EU_tb_unitdeposite").val()==EU_deposit))&&($("#EU_tb_accesscard").val()=='')&&($("#EU_db_stampdutydate").val()=='')&&($("#EU_tb_stampamount").val()=='')&&($("#EU_ta_comments").val()=='')){
                        EU_flag_unit=0;
                    }
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_existingunit_url+'/Initialdata',
                        data: {'EU_unitno':EU_unitno,'flag':'EU_flag_roomtype'},
                        success: function(rmstampdata) {
                            var res_values=JSON.parse(rmstampdata);
                            EU_result(res_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("EXISTING UNIT",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    $('#EU_tb_newroomtype').replaceWith('<select id="EU_lb_oldroomtype" name="EU_lb_oldroomtype" class="EU_class_validupdate form-control"><option>SELECT</option></select>');
                    $(this).replaceWith('<input type="button" name="EU_btn_addroomtype" value="ADD" id="EU_btn_addroomtype" class="btn btn-info EU_class_validupdate"/>');
                }
                if((EU_flag_unit==1)&&(EU_flag_access==1)&&(EU_flag_room=='true')&&(EU_flag_stamp=='true')&&(EU_flg_Doorcode==1)&&(EU_flg_Login==1))
                    $("#EU_btn_update").removeAttr("disabled");
                else
                    $("#EU_btn_update").attr("disabled", "disabled");
            });
        // CHANGE EVENT FUNCTION FOR ROOM TYPE
            $(document).on("change blur",'#EU_tb_newroomtype',function(){
                var EU_newroom=$(this).val();
                var EU_source=  $(this).attr('id');
                if(EU_newroom.length==0){
                    EU_flag_room='false';
                    if((EU_room_arr.length==0)&&(EU_newroom.length==0))
                        EU_flag_room='true';
                    $('#EU_div_errroom').text('');
                    $("#EU_tb_newroomtype").removeClass('invalid');
                }
                else if(EU_newroom.length>0){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_existingunit_url+'/EU_Alreadyexists',
                        data: {'EU_input':EU_newroom,'EU_source':EU_source},
                        success: function(roomdata) {
                            var room_values=JSON.parse(roomdata);
                            EU_roomresult(room_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("EXISTING UNIT",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // REPLACE NEW STAMP TYPE
            $(document).on('click','#EU_btn_addstamptype,#EU_btn_removestamptype',function(){
                var EU_unitno=$('#EU_lb_unitnumber').val();
                $('#EU_div_errstamp').text('');
                if($(this).attr('id')=="EU_btn_addstamptype"){
                    EU_flag_stamp='false';
                    $('#EU_lb_oldstamptype').replaceWith('<input type="text" name="EU_tb_newstamptype" id="EU_tb_newstamptype" maxlength=12 class="autosize EU_class_validupdate alphaonly EU_class_title_alpha form-control" placeholder="Stamp Duty Type"/>');
                    $(this).replaceWith('<input type="button" name="EU_btn_removestamptype" value="CLEAR" id="EU_btn_removestamptype" class="btn btn-info EU_class_validupdate"/>');
                    $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                    $(".EU_class_title_alpha").prop("title",EU_errorMsg_array[0].EMC_DATA.replace('NUMBERS','ALPHABETS'));
                }
                if($(this).attr('id')=='EU_btn_removestamptype'){
                    EU_flag_stamp='true';
                    if((EU_unit_source=='EU_radio_activeunit')&&(($("#EU_tb_unitdeposite").val()=='')||($("#EU_tb_unitdeposite").val()==EU_deposit))&&($("#EU_tb_accesscard").val()=='')&&($("#EU_db_stampdutydate").val()=='')&&($("#EU_tb_stampamount").val()=='')&&($("#EU_ta_comments").val()==''))
                        EU_flag_unit=0;
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_existingunit_url+'/Initialdata',
                        data: {'EU_unitno':EU_unitno,'flag':'EU_flag_stamptype'},
                        success: function(rmstampdata) {
                            var res_values=JSON.parse(rmstampdata);
                            EU_result(res_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("EXISTING UNIT",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    $('#EU_tb_newstamptype').replaceWith('<select id="EU_lb_oldstamptype" name="EU_lb_oldstamptype"class="EU_class_validupdate form-control" ><option>SELECT</option></select>');
                    $(this).replaceWith('<input type="button" name="EU_btn_addstamptype" value="ADD" id="EU_btn_addstamptype" class="btn btn-info EU_class_validupdate">');
                }
                if((EU_flag_unit==1)&&(EU_flag_access==1)&&(EU_flag_room=='true')&&(EU_flag_stamp=='true')&&(EU_flg_Doorcode==1)&&(EU_flg_Login==1))
                    $("#EU_btn_update").removeAttr("disabled");
                else
                    $("#EU_btn_update").attr("disabled", "disabled");
            });
            $(document).on("keyup",'.alphaonly',function() {
                if (this.value.match(/[^a-zA-Z\ ]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z\ ]/g, '').toUpperCase();
                }
            });
        // CHANGE EVENT FUNCTION FOR STAMP TYPE
            $(document).on("change blur",'#EU_tb_newstamptype',function(){
                var EU_newstamp=$(this).val();
                var EU_source=$(this).attr('id');
                if(EU_newstamp.length==0){
                    EU_flag_stamp='false';
                    if((EU_stamp.length==0)&&(EU_newstamp.length==0))
                        EU_flag_stamp='true';
                    $('#EU_div_errstamp').text('');
                    $("#EU_tb_newstamptype").removeClass('invalid');
                }
                else if(EU_newstamp.length>0){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_existingunit_url+'/EU_Alreadyexists',
                        data: {'EU_input':EU_newstamp,'EU_source':EU_source},
                        success: function(stampdata) {
                            var stamp_values=JSON.parse(stampdata);
                            EU_stampresult(stamp_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("EXISTING UNIT",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // SUCCESS FUNCTION FOR ROOM TYPE ALREADY EXISTS
            function EU_roomresult(EU_msgroom) {
                $(".preloader").hide();
                if(EU_msgroom=='true'){
                    $('#EU_div_errroom').text(EU_errorMsg_array[5].EMC_DATA);
                    $("#EU_tb_newroomtype").addClass('invalid');
                    $("#EU_btn_update").attr("disabled", "disabled");
                    EU_flag_room='false';
                }
                else if(EU_msgroom=='false'){
                    EU_flag_room='true';
                    $('#EU_div_errroom').text('');
                    $("#EU_tb_newroomtype").removeClass('invalid');
                }
                if((EU_flag_unit==1)&&(EU_flag_access==1)&&(EU_flag_room=='true')&&(EU_flag_stamp=='true')&&(EU_flg_Doorcode==1)&&(EU_flg_Login==1))
                    $("#EU_btn_update").removeAttr("disabled");
            }
        // SUCCESS FUNCTION FOR STAMP TYPE ALREADY EXISTS
            function EU_stampresult(EU_msgstamp) {
                $(".preloader").hide();
                if(EU_msgstamp=='true')
                {
                    EU_flag_stamp='false';
                    $('#EU_div_errstamp').text(EU_errorMsg_array[6].EMC_DATA);
                    $("#EU_tb_newstamptype").addClass('invalid');
                    $("#EU_btn_update").attr("disabled", "disabled");
                }
                else if(EU_msgstamp=='false')
                {
                    EU_flag_stamp='true';
                    $('#EU_div_errstamp').text('');
                    $("#EU_tb_newstamptype").removeClass('invalid');
                }
                if((EU_flag_unit==1)&&(EU_flag_access==1)&&(EU_flag_room=='true')&&(EU_flag_stamp=='true')&&(EU_flg_Doorcode==1)&&(EU_flg_Login==1))
                    $("#EU_btn_update").removeAttr("disabled");
            }
        // CHANGE EVENT FUNCTION FOR UNIT NUMBER
            $(document).on('change','#EU_lb_unitnumber',function(){
                $('#EU_form_existingUnit').find('input:text').val('');
                $('#EU_form_existingUnit').find('input:text').prop("readonly", false);
                $('#EU_form_existingUnit').find('input:text').removeClass('rdonly');
                $('#EU_tb_accesscard,#EU_tb_unitdeposite,#EU_tb_branchcode,#EU_tb_newroomtype').val('');
                $('#UNIT_tb_doorcode,#EU_tb_unitdeposite,#EU_tb_branchcode,#EU_tb_bankcode,#EU_tb_accesscard,#EU_tb_stampamount,#EU_tb_webpass').addClass('EU_class_numsonly');
                $('#EU_ta_comments').val('');
                if($('#EU_lb_unitnumber').val()!='SELECT'){
                    EU_flag_room='true';
                    EU_flag_stamp='true';
                    $("#EU_div_form").show();
                    $("#EU_div_doorloginpwsd").hide();
                    $("#EU_tble_resetupdatebtn").hide();
                    $('#EU_radio_doorloginpswd').attr('checked', false);
                    $("#EU_div_acctdetails").hide();
                    $('#EU_radio_acctdetails').attr('checked', false);
                    $("#EU_div_others").hide();
                    $('#EU_radio_others').attr('checked', false);
                    $("#EU_div_errmsg").text('').hide();
                    $("#EU_div_errmsgacct").text('').hide();
                    $('#EU_div_errasscard').text('');
                    $("#EU_btn_update").attr("disabled", "disabled");
                    $("#EU_tb_accesscard").removeClass('invalid');
                    $(".EU_td_webotheraccount").hide();
                    $(".EU_class_nonstampdetail").hide();
                    if(EU_unit_source=='EU_radio_activeunit'){
                        $(".EU_td_webotheraccount").show();
                        $(".EU_class_nonstampdetail").show();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    }
                    else if(EU_unit_source=='EU_radio_nonactiveunit'){
                        $('#EU_div_errstamp').text('');
                        $("#EU_tb_newstamptype").removeClass('invalid');
                        $(".EU_td_webotheraccount").hide();
                        $(".EU_class_nonstampdetail").hide();
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: ctrl_existingunit_url+'/EU_login_acct_others',
                            data: {'lbunitno':$("#EU_lb_unitnumber").val(),'radioflag':'EU_radio_others'},
                            success: function(accdata) {
                                var accdata_values=JSON.parse(accdata);
                                EU_result(accdata_values);
                                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                            },
                            error:function(data){
                                var errordata=(JSON.stringify(data));
                                show_msgbox("EXISTING UNIT",errordata,'error',false);
                                $('.preloader').hide();
                            }
                        });
                    }
                }
                else{
                    $("#EU_div_form").hide();
                }
            });
        // CHANGE EVENT FUNCTION FOR RADIO BUTTON
            $(document).on('click','.EU_class_loginacctothers',function(){
                EU_flg_Doorcode=1;EU_flg_Login=1;
                $("#EU_tble_resetupdatebtn").hide();
                EU_flag_access=1;
                EU_flag_unit=1;
                EU_flag_room='true';
                EU_flag_stamp='true';
                var EU_source=  $(this).attr('id');
                $('#EU_form_existingUnit').find('input:text,textarea').val('');
                $('#EU_form_existingUnit').find('input:text,textarea').prop("readonly", false);
                $('#EU_form_existingUnit').find('input:text,textarea').removeClass('rdonly');
                $('#UNIT_tb_doorcode,#UNIT_tb_weblogin,#EU_tb_webpass').addClass('EU_class_numsonly');
                $('#EU_lb_oldroomtype').val('SELECT');
                $('#EU_lb_oldstamptype').val('SELECT');
                $("#EU_tb_bankaddrs").removeAttr("readonly");
                $('#EU_div_errasscard').text("");
                $('#EU_div_errroom').text('');
                $('#EU_div_errstamp').text('');
                $("#EU_div_errmsg").text('').hide();
                $('#EU_lbl_doorcode,#EU_lbl_weblogin').text('');
                $("#UNIT_tb_doorcode").removeClass('invalid');
                $("#UNIT_tb_weblogin").removeClass('invalid');
                $("#EU_tb_accesscard").removeClass('invalid');
                $("#EU_tb_newroomtype").removeClass('invalid');
                $("#EU_tb_newstamptype").removeClass('invalid');
                $("#EU_btn_update").attr("disabled", "disabled");
                var EU_unitnumber=$("#EU_lb_unitnumber").val();
                // CLICK EVENT FUNCTION FOR LOGIN DETAILS
                if(EU_source=='EU_radio_doorloginpswd'){
                    $(".preloader").show();
                    $("#EU_div_acctdetails").hide();
                    $("#EU_div_others").hide();
                    $("#EU_div_errmsg").text('').hide();
                    $("#EU_div_errmsgacct").text('').hide();
                    $.ajax({
                        type: "POST",
                        url: ctrl_existingunit_url+'/EU_login_acct_others',
                        data: {'lbunitno':EU_unitnumber,'radioflag':EU_source},
                        success: function(logdata) {
                            var logdata_values=JSON.parse(logdata);
                            EU_loginSuccess(logdata_values);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("EXISTING UNIT",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                // CLICK EVENT FUNCTION FOR ACCOUNT DETAILS
                else if(EU_source=='EU_radio_acctdetails'){
                    $(".preloader").show();
                    $("#EU_div_errmsg").text('').hide();
                    $("#EU_div_others").hide();
                    $("#EU_div_doorloginpwsd").hide();
                    $("#EU_div_errmsgacct").text('').hide();
                    $.ajax({
                        type: "POST",
                        url: ctrl_existingunit_url+'/EU_login_acct_others',
                        data: {'lbunitno':EU_unitnumber,'radioflag':EU_source},
                        success: function(accdata) {
                            var accdata_values=JSON.parse(accdata);
                            EU_acctSuccess(accdata_values);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("EXISTING UNIT",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                // CLICK EVENT FUNCTION FOR OTHERS DETAILS
                else if(EU_source=='EU_radio_others'){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_existingunit_url+'/EU_login_acct_others',
                        data: {'lbunitno':EU_unitnumber,'radioflag':EU_source},
                        success: function(resdata) {
                            var resdata_values=JSON.parse(resdata);
                            EU_result(resdata_values);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("EXISTING UNIT",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    var EU_unitno=$('#EU_lb_unitnumber').val();
                    $("#EU_div_acctdetails").hide();
                    $("#EU_div_doorloginpwsd").hide();
                    $("#EU_div_errmsgacct").text('').hide();
                    $("#EU_div_errmsg").text('').hide();
                    $('#EU_div_errroom').text('');
                    $('#EU_div_errstamp').text('');
                }
            });
        // SUCCESS FUNCTION FOR LOGIN DETAILS
            var EU_door='';
            var EU_login='';
            var EU_pass='';
            function EU_loginSuccess(EU_response){
                $(".preloader").hide();
                $("#EU_tble_resetupdatebtn").show();
                EU_door=EU_response.EU_dcode;
                EU_login=EU_response.EU_weblogin;
                EU_pass=EU_response.EU_webpass;
                if(EU_response==''){
                    $("#EU_div_doorloginpwsd").show();
                }
                else{
                    if((EU_door!=null)&&(EU_login!=null)&&(EU_pass!=null)){
                        $("#EU_div_errmsg").text(EU_errorMsg_array[4].EMC_DATA).show();
                        $("#EU_tble_resetupdatebtn").hide();
                    }
                    else if((EU_door==null)||(EU_login==null)||(EU_pass==null)){
                        $("#EU_div_doorloginpwsd").show();
                        $("#EU_div_errmsg").text('').hide();
                        if(EU_door!=null){
                            $("#UNIT_tb_doorcode").prop("readonly", true);
                            $("#UNIT_tb_doorcode").removeClass('EU_class_numsonly');
                            $("#UNIT_tb_doorcode").val(EU_door);
                            $("#UNIT_tb_doorcode").addClass('rdonly');
                        }
                        if(EU_login!=null){
                            $("#UNIT_tb_weblogin").prop("readonly", true);
                            $("#UNIT_tb_weblogin").val(EU_login);
                            $("#UNIT_tb_weblogin").addClass('rdonly');
                        }
                        if(EU_pass!=null){
                            $("#EU_tb_webpass").prop("readonly", true);
                            $("#EU_tb_webpass").removeClass('EU_class_numsonly');
                            $("#EU_tb_webpass").val(EU_pass);
                            $("#EU_tb_webpass").addClass('rdonly');
                        }
                    }
                }
            }
        // SUCCESS FUNCTION FOR ACCOUNT DETAILS
            var EU_acctno='';
            var EU_acctname='';
            var EU_bankcode='';
            var EU_branchcode='';
            var EU_bankaddr='';
            function EU_acctSuccess(EU_response){
                $(".preloader").hide();
                $("#EU_tble_resetupdatebtn").show();
                EU_acctno=EU_response.EU_acctnum;
                EU_acctname=EU_response.EU_acctname;
                EU_bankcode=EU_response.EU_bankcode;
                EU_branchcode=EU_response.EU_branchcode;
                EU_bankaddr=EU_response.EU_bankaddress;
                if(EU_response==''){
                    $("#EU_div_acctdetails").show();
                }
                else{
                    if((EU_acctno!=null)&&(EU_acctname!=null)&&(EU_bankcode!=null)&&(EU_branchcode!=null)&&(EU_bankaddr!=null))
                    {
                        $("#EU_div_errmsgacct").text(EU_errorMsg_array[4].EMC_DATA).show();
                        $("#EU_tble_resetupdatebtn").hide();
                    }
                    else if((EU_acctno==null)||(EU_acctname==null)||(EU_bankcode==null)||(EU_branchcode==null)||(EU_bankaddr==null)){
                        $("#EU_div_acctdetails").show();
                        $("#EU_div_errmsgacct").text('').hide();
                        if(EU_acctno!=null)
                        {
                            $("#EU_tb_accntnumber").prop("readonly", true);
                            $("#EU_tb_accntnumber").val(EU_acctno);
                            $("#EU_tb_accntnumber").addClass('rdonly');
                        }
                        if(EU_acctname!=null)
                        {
                            $("#EU_tb_accntname").prop("readonly", true);
                            $("#EU_tb_accntname").val(EU_acctname);
                            $("#EU_tb_accntname").addClass('rdonly');
                        }
                        if(EU_bankcode!=null){
                            $("#EU_tb_bankcode").prop("readonly", true);
                            $("#EU_tb_bankcode").removeClass('EU_class_numsonly');
                            $("#EU_tb_bankcode").val(EU_bankcode);
                            $("#EU_tb_bankcode").addClass('rdonly');
                        }
                        if(EU_branchcode!=null){
                            $("#EU_tb_branchcode").prop("readonly", true);
                            $("#EU_tb_branchcode").removeClass('EU_class_numsonly');
                            $("#EU_tb_branchcode").val(EU_branchcode);
                            $("#EU_tb_branchcode").addClass('rdonly');
                        }
                        if(EU_bankaddr!=null){
                            $("#EU_tb_bankaddrs").attr("readonly", "readonly");
                            $("#EU_tb_bankaddrs").val(EU_bankaddr);
                            $("#EU_tb_bankaddrs").addClass('rdonly');
                        }
                    }
                }
            }
        // CLICK FUNCTION FOR UPDATION
            $(document).on('click','#EU_btn_update',function(event){
                event.stopPropagation();
                event.preventDefault();
                event.stopImmediatePropagation();
                $(".preloader").show();
                if($('#EU_radio_doorloginpswd').is(':checked')) {
                    $("#EU_hidden_flag").val('EU_doorlogpwd');
                }
                if($('#EU_radio_acctdetails').is(':checked')) {
                    $("#EU_hidden_flag").val('EU_acctdetails');
                }
                if($('#EU_radio_others').is(':checked')) {
                    $("#EU_hidden_flag").val('EU_others');
                }
                if(EU_unit_source=='EU_radio_nonactiveunit')
                    $("#EU_hidden_flag").val('EU_others');
                var formelement=$('#EU_form_existingUnit').serialize();
                $.ajax({
                    type: "POST",
                    url: ctrl_existingunit_url+'/EU_updateForm',
                    data: formelement,
                    success: function(savedata) {
                        var saved_values=JSON.parse(savedata);
                        EU_updateSuccess(saved_values);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("EXISTING UNIT",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
                $('textarea').height(114);
            });
        // SUCCESS FUNCTION FOR WHICH ARE INSERTING VALUES
            function EU_updateSuccess(EU_response){
                $(".preloader").hide();
                if((EU_response.EU_obj_flag==1)&&(EU_response.EU_obj_flag_existing==false)){
                    var EU_errorMsg=EU_errorMsg_array[7].EMC_DATA.replace('[UNIT NO]',EU_response.EU_obj_no);
                    show_msgbox("EXISTING UNIT",EU_errorMsg,'success',false);
                    $("#EU_unitno").hide();
                    $(':input','#EU_form_existingUnit')
                        .not(':button')
                        .val('')
                        .removeAttr('selected');
                    $("#EU_div_form").hide();
                    $('#EU_radio_activeunit,#EU_radio_nonactiveunit').attr('checked', false);
                }
                else if(EU_response.EU_obj_flag==0){
                    show_msgbox("EXISTING UNIT",EU_errorMsg_array[10].EMC_DATA,'error',false);
                }
            }
        // CHANGE FUNCTION FOR ACCESS CARD FOR ALREADY EXISTS DATA
            $(document).on("change blur",'#EU_tb_accesscard',function(){
                var EU_access=$("#EU_tb_accesscard").val();
                var EU_source='EU_tb_accesscard';
                if((parseInt(EU_access).toString().length>0)&&(parseInt(EU_access).toString().length<4)){
                    EU_flag_access=0;
                    $("#"+EU_source).addClass('invalid');
                    $('#EU_div_errasscard').text(EU_errorMsg_array[2].EMC_DATA);
                }
                else if(parseInt($('#EU_tb_accesscard').val()).toString().length>=4){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_existingunit_url+'/EU_Alreadyexists',
                        data: {'EU_input':EU_access,'EU_source':EU_source},
                        success: function(existdata) {
                            var exists_values=JSON.parse(existdata);
                            EU_accessresult(exists_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("EXISTING UNIT",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                if((parseInt($('#EU_tb_accesscard').val())==0)||($('#EU_tb_accesscard').val().length==0)){
                    EU_flag_access=1;
                    $('#EU_div_errasscard').text('');
                    $("#EU_tb_accesscard").removeClass('invalid');
                }
            });
        // FUNCTION FOR ACCESS CARD ALREADY EXISTS
            function EU_accessresult(EU_msgAccess) {
                $(".preloader").hide();
                if(EU_msgAccess=='true'){
                    EU_flag_access=0;
                    $("#EU_btn_update").attr("disabled", "disabled");
                    $('#EU_div_errasscard').text(EU_errorMsg_array[3].EMC_DATA);
                    $('#EU_tb_accesscard').addClass('invalid');
                }
                else if(EU_msgAccess=='false'){
                    EU_flag_access=1;
                    $('#EU_div_errasscard').text('');
                    $("#EU_tb_accesscard").removeClass('invalid');
                    if((EU_flag_unit==1)&&(EU_flag_access==1)&&(EU_flag_room=='true')&&(EU_flag_stamp=='true')&&(EU_flg_Doorcode==1)&&(EU_flg_Login==1)){
                        $("#EU_btn_update").removeAttr("disabled");
                    }
                    $('#EU_div_errasscard').text('');
                    $('#EU_tb_accesscard').removeClass('invalid');
                }
            }
        // FUNCTION TO VALIDATE LOGIN DETAILS
            function EU_func_loginvalidation(){
                if((($('#UNIT_tb_doorcode').val()!='')&&(($('#UNIT_tb_doorcode').val()).trim()!=EU_door)&&(parseInt($('#UNIT_tb_doorcode').val())!=0)&&(EU_flg_Doorcode==1)&&(EU_flg_Login==1))||(($('#UNIT_tb_weblogin').val()!='')&&(($('#UNIT_tb_weblogin').val()).trim()!=EU_login)&&(parseInt($('#UNIT_tb_weblogin').val())!=0)&&(EU_flg_Doorcode==1)&&(EU_flg_Login==1))||(($('#EU_tb_webpass').val()!='')&&(($('#EU_tb_webpass').val()).trim()!=EU_pass)&&(parseInt($('#EU_tb_webpass').val())!=0)&&(EU_flg_Doorcode==1)&&(EU_flg_Login==1)))
                    $("#EU_btn_update").removeAttr("disabled");
                else
                    $("#EU_btn_update").attr("disabled", "disabled");
            }
        // CHANGE EVENT FOR ENABLING UPDATE BUTTON UNTIL MANDATORY VALUES ARE GIVEN
            $(document).on('change blur','.EU_class_validupdate',function(){
                if($('#EU_radio_doorloginpswd').is(':checked')){
                    EU_func_loginvalidation();
                }
                if($('#EU_radio_acctdetails').is(':checked')){
                    if((($('#EU_tb_accntnumber').val()!='')&&($('#EU_tb_accntnumber').val()!=EU_acctno)&&(parseInt($('#EU_tb_accntnumber').val())!=0))||(($('#EU_tb_accntname').val()!='')&&($('#EU_tb_accntname').val()!=EU_acctname)&&(parseInt($('#EU_tb_accntname').val())!=0))||(($('#EU_tb_bankcode').val()!='')&&($('#EU_tb_bankcode').val()!=EU_bankcode)&&(parseInt($('#EU_tb_bankcode').val())!=0))||(($('#EU_tb_branchcode').val()!='')&&($('#EU_tb_branchcode').val()!=EU_branchcode)&&(parseInt($('#EU_tb_branchcode').val())!=0))||(($('#EU_tb_bankaddrs').val()!='')&&($('#EU_tb_bankaddrs').val()!=EU_bankaddr))){
                        $("#EU_btn_update").removeAttr("disabled");
                    }
                    else{
                        $("#EU_btn_update").attr("disabled", "disabled");
                    }
                }
                if((EU_unit_source=='EU_radio_nonactiveunit')||($('#EU_radio_others').is(':checked'))){
                    if($('#EU_radio_others').is(':checked')){
                        if((($('#EU_tb_unitdeposite').val()!='')&&(parseInt($('#EU_tb_unitdeposite').val())!='')&&($('#EU_tb_unitdeposite').val()!=EU_deposit))||($('#EU_db_stampdutydate').val()!='')||(($('#EU_tb_stampamount').val()!='')&&(parseInt($('#EU_tb_stampamount').val())!=0))||($('#EU_ta_comments').val()!='')||(($('#EU_tb_accesscard').val().length>=4)&&(parseInt($('#EU_tb_accesscard').val())!=0))||(($('#EU_lb_oldstamptype').val()!='SELECT')&&($('#EU_lb_oldstamptype').val()!=undefined))||(($('#EU_lb_oldroomtype').val()!='SELECT')&&($('#EU_lb_oldroomtype').val()!=undefined))||(($('#EU_tb_newroomtype').val()!='')&&($('#EU_tb_newroomtype').val()!=undefined))||(($('#EU_tb_newstamptype').val()!='')&&($('#EU_tb_newstamptype').val()!=undefined))){
                            EU_flag_unit=1;
                        }
                        else{
                            EU_flag_unit=0;
                        }
                    }
                    if(EU_unit_source=='EU_radio_nonactiveunit'){
                        EU_flag_room='true';EU_flag_access=1;
                        if(($('#EU_db_stampdutydate').val()!='')||(($('#EU_tb_stampamount').val()!='')&&(parseInt($('#EU_tb_stampamount').val())!=0))||($('#EU_ta_comments').val()!='')||(($('#EU_lb_oldstamptype').val()!='SELECT')&&($('#EU_lb_oldstamptype').val()!=undefined))||(($('#EU_tb_newstamptype').val()!='')&&($('#EU_tb_newstamptype').val()!=undefined)))
                            EU_flag_unit=1;
                        else
                            EU_flag_unit=0;
                    }
                    if((EU_flag_unit==1)&&(EU_flag_access==1)&&(EU_flag_room=='true')&&(EU_flag_stamp=='true')){
                        $("#EU_btn_update").removeAttr("disabled");
                    }
                    else{
                        $("#EU_btn_update").attr("disabled", "disabled");
                    }
                }
            });
        // CHECK DOORCODE
            $(document).on("change blur",'#UNIT_tb_doorcode',function(){
                $('#EU_lbl_doorcode').text('');
                $(this).removeClass('invalid');
                EU_flg_Doorcode=1;
                if(($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length<6)){
                    $(this).addClass('invalid');
                    EU_flg_Doorcode=0;
                    $('#EU_lbl_doorcode').text(EU_errorMsg_array[14].EMC_DATA);
                }
                else if(($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length>=6)&&($('#UNIT_tb_doorcode').hasClass('rdonly'))!=true){
                    EU_func_doorcode_login($(this).val(),$(this).attr('id'));
                }
            });
        // CHECK WEBLOGIN
            $(document).on("change blur",'#UNIT_tb_weblogin',function(){
                $('#EU_lbl_weblogin').text('');
                $(this).removeClass('invalid');
                EU_flg_Login=1;
                if(($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length<5)){
                    $(this).addClass('invalid');
                    EU_flg_Login=0;
                    $('#EU_lbl_weblogin').text(EU_errorMsg_array[13].EMC_DATA);
                }
                else if(($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length>=5)&&($('#UNIT_tb_weblogin').hasClass('rdonly'))!=true){
                    EU_func_doorcode_login($(this).val(),$(this).attr('id'));
                }
            });
            function EU_func_doorcode_login(UCRE_value,UCRE_attrid){
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: ctrl_existingunit_url+'/EU_Alreadyexists',
                    data: {'EU_input':UCRE_value,'EU_source':UCRE_attrid},
                    success: function(existdata) {
                        var exists_values=JSON.parse(existdata);
                        EU_SuccessLoginDoor(exists_values);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("EXISTING UNIT",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            }
        // SUCCESS FUNCTION FOR DOORCODE AND WEBLOGIN
            function EU_SuccessLoginDoor(EU_response_Login){
                $(".preloader").hide();
                if(EU_response_Login[0]==0){
                    if(EU_response_Login[1]=='UNIT_tb_doorcode'){
                        EU_flg_Doorcode=0;
                        $('#EU_lbl_doorcode').text(EU_errorMsg_array[12].EMC_DATA);
                    }
                    else if(EU_response_Login[1]=='UNIT_tb_weblogin'){
                        EU_flg_Login=0;
                        $('#EU_lbl_weblogin').text(EU_errorMsg_array[11].EMC_DATA);
                    }
                    $("#"+EU_response_Login[1]).addClass('invalid');
                }
                else{
                    if(EU_response_Login[1]=='UNIT_tb_doorcode'){
                        EU_flg_Doorcode=1;
                        $('#EU_lbl_doorcode').text('');
                    }
                    else if(EU_response_Login[1]=='UNIT_tb_weblogin'){
                        $('#EU_lbl_weblogin').text('');
                        EU_flg_Login=1;
                    }
                    $("#"+EU_response_Login[1]).removeClass('invalid');
                }
                EU_func_loginvalidation();
            }
        // CLICK FUNCTION FOR RESET
            $("#EU_btn_reset").click(function(){
                $("#EU_btn_update").attr("disabled", "disabled");
                $(':input[type=text]:not([readonly])','#EU_form_existingUnit').val('').not(':button');
                EU_resetfrm();
                $("#EU_lb_oldroomtype").val('SELECT');
                $("#EU_lb_oldstamptype").val('SELECT');
                $("#EU_ta_comments").val('');
                if(EU_bankaddr==null){
                    $("#EU_tb_bankaddrs").val('');
                }
                EU_flag_unit=0;
                EU_flag_room='true';
                EU_flag_stamp='true';
            });
        // COMMON FUCNTION FOR CLEARING ALL VALUES
            function EU_resetfrm(){
                $("#EU_btn_update").attr("disabled", "disabled");
                $('#EU_div_errasscard').text("");
                $("#EU_tb_accesscard,#EU_tb_newstamptype,#EU_tb_newroomtype,#UNIT_tb_weblogin,#UNIT_tb_doorcode").removeClass('invalid');
                $('#EU_div_errroom').text('');
                $('#EU_div_errstamp').text('');
                $('#EU_lbl_doorcode,#EU_lbl_weblogin').text('');
                // REPLACE OLDROOMTYPE & OLDSTAMPTYPE WHEN RESET BUTTON CLICKED
                if((($('#EU_lb_oldroomtype').val()==undefined)&&($('#EU_btn_removeroomtype').val()=='CLEAR'))||(($('#EU_btn_removestamptype').val()=='CLEAR')&&($('#EU_lb_oldstamptype').val()==undefined))){
                    $(".preloader").show();
                    var EU_unitno=$('#EU_lb_unitnumber').val();
                    $.ajax({
                        type: "POST",
                        url: ctrl_existingunit_url+'/Initialdata',
                        data: {'EU_unitno':EU_unitno,'flag':'EU_flag_roomstamp'},
                        success: function(resetdata) {
                            var reset_values=JSON.parse(resetdata);
                            EU_result(reset_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("EXISTING UNIT",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                $('#EU_ta_comments,#EU_tb_bankaddrs').height(116);
                $('#EU_ta_comments,#EU_tb_bankaddrs').prop("rows",5);
            }
        // FUNCTION FOR ACTIVE UNIT
            $(document).on('click','.EU_class_unit',function(){
                EU_flg_Doorcode=1;EU_flg_Login=1;
                EU_unit_source=  $(this).attr('id');
                $("#EU_div_form").hide();
                var EU_load_unitno ='<option>SELECT</option>';
                if(EU_unit_source=='EU_radio_activeunit'){
                    var EU_unitnum_errmsg=EU_errorMsg_array[8].EMC_DATA;
                    var EU_unitnum_arr=EU_unitno_arr;
                    for (var i = 0; i < EU_unitnum_arr.length; i++) {
                        EU_load_unitno += '<option value="' + EU_unitnum_arr[i].UNIT_NO + '">' + EU_unitnum_arr[i].UNIT_NO + '</option>';
                    }
                }
                else if(EU_unit_source=='EU_radio_nonactiveunit'){
                    var EU_unitnum_arr=EU_nonactive_arr;
                    var EU_unitnum_errmsg=EU_errorMsg_array[9].EMC_DATA;
                    for (var i = 0; i < EU_unitnum_arr.length; i++) {
                        EU_load_unitno += '<option value="' + EU_unitnum_arr[i] + '">' + EU_unitnum_arr[i] + '</option>';
                    }
                }
                $("#EU_lb_unitnumber").html(EU_load_unitno);
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                if(EU_unitnum_arr.length==0){
                    $("#EU_unitno").hide();
                    $('#EU_lbl_errmsgunitno').text(EU_unitnum_errmsg).show();
                }
                else{
                    $("#EU_unitno").show();
                    $('#EU_lb_unitnumber').focus();
                    $('#EU_lbl_errmsgunitno').text('').hide();
                }
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>EXISTING UNIT</b></h4></div>
    <form id="EU_form_existingUnit" name="EU_form_existingUnit" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="existsselectoption">
                    <label style="padding-left: 15px">SELECT ACTIVE / NON ACTIVE UNIT</label>
                    <div class="col-md-12">
                        <div class="radio">
                            <label><input type="radio" id="EU_radio_activeunit" name="EU_radio_unit" value="EU_value_activeunit" class="EU_class_unit">ACTIVE UNIT </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="radio">
                            <label><input type="radio" id="EU_radio_nonactiveunit" name="EU_radio_unit" value="EU_value_nonactiveunit" class="EU_class_unit">NON ACTIVE UNIT </label>
                        </div>
                    </div>
                    <label style="padding-left: 15px;" class="col-lg-12 errormsg errpadding" id="EU_lbl_errmsgunitno" hidden></label>
                </div>
                <div class="form-group" id="EU_unitno" hidden>
                    <label class="col-sm-2">UNIT NO <em>*</em></label>
                    <div class="col-sm-2"><select name="EU_lb_unitnumber" id="EU_lb_unitnumber" class="form-control"></select></div>
                </div>
                <div id="EU_div_form" hidden>
                    <div id="EU_tble_activeunit_form">
                        <div class="form-group EU_td_webotheraccount" id="EU_selectoption1">
                            <label style="padding-left: 15px">SELECT OPTION</label><input type="hidden" id="EU_hidden_flag" name="EU_hidden_flag">
                            <div class="col-md-12">
                                <div class="radio">
                                    <label><input type="radio" name="EU_radio_loginacctothers" id="EU_radio_doorloginpswd" value="EU_doorloginpswd" class="EU_class_loginacctothers">DOORCODE LOGIN PASSWORD </label>
                                </div>
                            </div>
                        </div>
                        <div id="EU_div_errmsg" style="padding-bottom: 10px;" class="srctitle" hidden> </div>
                        <div id="EU_div_doorloginpwsd">
                            <div class="form-group" id="EU_doorcode">
                                <label class="col-sm-2">DOOR CODE </label>
                                <div class="col-sm-2"><input type="text" name="EU_tb_doorcode" id="UNIT_tb_doorcode" class="EU_class_validupdate numonly EU_class_numsonly form-control" maxlength=10  placeholder="Door Code"/></div>
                                <div class="col-sm-4 errpadding errormsg" id="EU_lbl_doorcode"> </div>
                            </div>
                            <div class="form-group" id="EU_doorcode">
                                <label class="col-sm-2">WEB LOGIN </label>
                                <div class="col-sm-2"><input type="text" name="EU_tb_weblogin" id="UNIT_tb_weblogin" class="EU_class_validupdate autosize form-control" maxlength=13  placeholder="Web Login"/></div>
                                <div class="col-sm-4 errpadding errormsg" id="EU_lbl_weblogin"> </div>
                            </div>
                            <div class="form-group" id="EU_doorcode">
                                <label class="col-sm-2">WEB PASSWORD </label>
                                <div class="col-sm-2"><input type="text" name="EU_tb_webpass" id="EU_tb_webpass" class="EU_class_validupdate numonly EU_class_numsonly form-control" maxlength=6  placeholder="Web Password"/></div>
                            </div>
                        </div>
                        <div class="form-group EU_td_webotheraccount" id="EU_selectoption2">
                            <div class="col-md-12">
                                <div class="radio">
                                    <label><input type="radio" name="EU_radio_loginacctothers" id="EU_radio_others" value="EU_others" class="EU_class_loginacctothers"/>OTHERS </label>
                                </div>
                            </div>
                        </div>
                        <div id="EU_div_others">
                            <div class="form-group EU_class_nonstampdetail" id="EU_unitdeposit">
                                <label class="col-sm-2">UNIT DEPOSIT </label>
                                <div class="col-sm-2"><input type="text" name="EU_tb_unitdeposite" id="EU_tb_unitdeposite" maxlength="5" class="EU_class_validupdate numonly EU_class_numsonly form-control" placeholder="Unit Deposit"></div>
                            </div>
                            <div class="form-group EU_class_nonstampdetail" id="EU_accesscard">
                                <label class="col-sm-2">ACCESS CARD </label>
                                <div class="col-sm-2"><input input type="text" name="EU_tb_accesscard" id="EU_tb_accesscard" class="EU_class_validupdate EU_class_numsonly form-control" maxlength=7 placeholder="Access Card"></div>
                                <div class="col-sm-4 errpadding errormsg" id="EU_div_errasscard"> </div>
                            </div>
                            <div class="form-group EU_class_nonstampdetail" id="EU_roomtype">
                                <label class="col-sm-2">ROOM TYPE </label>
                                <div class="col-sm-3"><select id="EU_lb_oldroomtype" name="EU_lb_oldroomtype" class="EU_class_validupdate form-control"><option>SELECT</option></select></div>
                                <div class="col-sm-2 colsmhf"><input class="btn btn-info EU_class_validupdate" type="button" name="EU_btn_addroomtype" value="ADD" id="EU_btn_addroomtype"/></div>
                                <div class="col-sm-4 errpadding errormsg" id="EU_div_errroom" name="EU_div_errroom"> </div>
                            </div>
                            <div class="form-group" id="EU_stampdutydate">
                                <label class="col-sm-2">STAMP DUTY DATE </label>
                                <div class="col-sm-2">
                                    <div class="input-group addon">
                                        <input type="text" name="EU_db_stampdutydate" class="EU_class_validupdate datenonmandtry form-control" id="EU_db_stampdutydate" placeholder="Stamp Duty Date"/>
                                        <label for="EU_db_stampdutydate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="EU_stamptype">
                                <label class="col-sm-2">STAMP DUTY TYPE </label>
                                <div class="col-sm-3"><select id='EU_lb_oldstamptype' name="EU_lb_oldstamptype" class="EU_class_validupdate form-control"><option>SELECT</option> </select></div>
                                <div class="col-sm-2 colsmhf"><input class="btn btn-info EU_class_validupdate" type="button" name="EU_btn_addstamptype" value="ADD" id="EU_btn_addstamptype"/></div>
                                <div class="col-sm-4 errpadding errormsg" id="EU_div_errstamp" name="EU_div_errstamp"></div>
                            </div>
                            <div class="form-group" id="EU_stampamount">
                                <label class="col-sm-2">STAMP DUTY AMOUNT </label>
                                <div class="col-sm-2"><input type="text" id="EU_tb_stampamount" name="EU_tb_stampamount" class="EU_class_validupdate EU_class_numsonly form-control" placeholder="Stamp Duty Amount"></div>
                            </div>
                            <div class="form-group" id="EU_comments">
                                <label class="col-sm-2">COMMENTS</label>
                                <div class="col-sm-4"><textarea name="EU_ta_comments" id="EU_ta_comments" class="EU_class_validupdate form-control" placeholder="Comments" style="height: 114px;" rows="5"></textarea></div>
                            </div>
                        </div>
                        <div class="form-group EU_td_webotheraccount" id="EU_selectoption3">
                            <div class="col-md-12">
                                <div class="radio">
                                    <label><input type="radio" name="EU_radio_loginacctothers" id="EU_radio_acctdetails" value="EU_acctdetails" class="EU_class_loginacctothers"/>ACCOUNT DETAILS </label>
                                </div>
                            </div>
                        </div>
                        <div id="EU_div_errmsgacct" class="srctitle" hidden> </div>
                        <div id="EU_div_acctdetails">
                            <div class="form-group" id="EU_accntnumber">
                                <label class="col-sm-2">ACCOUNT NUMBER </label>
                                <div class="col-sm-2"><input type="text" name="EU_tb_accntnumber" id="EU_tb_accntnumber" class="EU_class_validupdate numonly EU_class_numsonly form-control" placeholder="Account Number" maxlength="15"/></div>
                            </div>
                            <div class="form-group" id="EU_accntname">
                                <label class="col-sm-2">ACCOUNT NAME </label>
                                <div class="col-sm-3"><input type="text" name="EU_tb_accntname" id="EU_tb_accntname" class="EU_class_validupdate autosize form-control" placeholder="Account Name" maxlength="25"/></div>
                            </div>
                            <div class="form-group" id="EU_bankcode">
                                <label class="col-sm-2">BANK CODE</label>
                                <div class="col-sm-2"><input type="text" name="EU_tb_bankcode" id="EU_tb_bankcode" class="EU_class_validupdate numonly EU_class_numsonly form-control" maxlength="5" placeholder="Bank Code"/></div>
                            </div>
                            <div class="form-group" id="EU_branchcode">
                                <label class="col-sm-2">BRANCH CODE</label>
                                <div class="col-sm-2"><input type="text" name="EU_tb_branchcode" id="EU_tb_branchcode" class="EU_class_validupdate numonly EU_class_numsonly form-control" maxlength="5" placeholder="Branch Code"/></div>
                            </div>
                            <div class="form-group" id="EU_bankaddress">
                                <label class="col-sm-2">BANK ADDRESS</label>
                                <div class="col-sm-4"><textarea name="EU_tb_bankaddrs" id="EU_tb_bankaddrs" class="EU_class_validupdate autosize form-control" placeholder="Bank Address" style="height: 114px;" rows="5"></textarea></div>
                            </div>
                        </div>
                    </div>
                    <div id="EU_tble_upd_stampdetails"></div>
                    <div class="form-group" id="EU_tble_resetupdatebtn" hidden>
                        <div class="col-sm-offset-1 col-sm-3">
                            <input class="btn btn-info" type="button" value="UPDATE" name="EU_btn_update" id="EU_btn_update" disabled/>
                            <input class="btn btn-info" type="button" name="EU_btn_reset" value="RESET" id="EU_btn_reset"/>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>