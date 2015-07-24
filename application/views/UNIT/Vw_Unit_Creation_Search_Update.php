<?php
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
        th{
            text-align: center;
        }
    </style>
    <script type="text/javascript">
    // document ready function
    var ErrorControl ={AmountCompare:'InValid'};
    $(document).ready(function(){
        var ctrl_unitcreate_url="<?php echo site_url('UNIT/Ctrl_Unit_Creation_Search_Update'); ?>";
        // initial data
            $('.preloader').hide();
            $('#spacewidth').height('0%');
            var UC_room=[];
            var UC_errorMsg_array=[];
            var UC_stamp=[];
            var UC_flaglen=0;
            var UC_flag='true';
            var UC_flag_unit='true';
            var UC_flag_room='true';
            var UC_flag_stamp='true';
            var UC_flg_Login=1;
            var UC_flg_Doorcode=1;
        //---------------------UPDATE-----------------------//
            var USU_flag_updbtn=0;
            var USU_flag_stamptype=0;
            var USU_flag_roomtype=0;
            var USU_flag_access=0;
            var USU_flag_enddate=0;
            var USU_flag_unitno=0;
            var USU_flag_searchbtn=0;
            var USU_accesscard_no='';
            var USU_obj_rowvalue='';
            var USU_unit_optionvalues_roomtype=[];
            var USU_errormsg_arr =[];
            var USU_unitoption_arr =[];
            var USU_unitoptions_id_arr=[];
            var USU_glb_unitno_arr=[];
            var USU_obsolete_upd='';
            var editrowid;
            var USU_accesscard_transaction=false;
            var USU_select_options_card ='<option>SELECT</option>';
        //------------------------END UPDATE----------------------//
            $('textarea').autogrow({onInitialize: true});
            $("#UC_tb_accesscard,#UC_tb_unitdeposite,#UC_tb_unitrentalamt").doValidation({rule:'numbersonly',prop:{leadzero:false}});
            $("#UC_tb_stampamount").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
            $("#UC_db_stampdutydate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
            $(".numonly").doValidation({rule:'numbersonly',prop:{leadzero:true}});
            $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
            $("#UC_db_startdate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,maxDate: '+2Y',minDate:'-1M',
                onSelect:function(date){
                    $('#UC_db_enddate').datepicker("option","minDate",date);
                }
            });
            $("#UC_db_enddate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,maxDate: '+2Y'});
            $('#UNIT_form_unitcreate').focus();
            $(".uppercase").Setcase({caseValue : 'upper'});
        // RADIO BUTTON CLICK FUNCTION
            $('.UNIT_selectform').click(function(){
                var radiooption=$(this).val();
                if(radiooption=='unitcreate')
                {
                    $('#USU_form_unitupdate').hide();
                    $('.preloader').show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/Initialdata',
                        data:{'flag':'UC_flag_notcreation'},
                        success: function(data) {
                            var initial_values=JSON.parse(data);
                            UC_result(initial_values);
                            $("html, body").animate({ scrollTop: 1100 }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT CREATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                else{
                    $('#UC_form_unitcreation').hide();
                    $('.preloader').show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_Initialdata',
                        success: function(usudata) {
                            var usuinitial_values=JSON.parse(usudata);
                            USU_success(usuinitial_values);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT CREATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
            function UC_result(UC_response){
                $('.preloader').hide();
                if(UC_response.toString().match("error:"))
                {
                    show_msgbox("UNIT CREATION",UC_response,'error',false);
                }
                else
                {
                    $('#UC_form_unitcreation').show();
                    $('#UC_tb_unitno').focus();
                    var UC_flag=UC_response[3];
                    if((UC_flag!=true)&&(UC_flag!=0)){
                        UC_room=UC_response[0];
                        UC_stamp=UC_response[1];
                        UC_errorMsg_array=UC_response[2];
                        $(".UC_class_numonly").prop("title",UC_errorMsg_array[1].EMC_DATA);
                        if((UC_flag=='UC_flag_roomtype')||(UC_flag=='UC_flag_notcreation')||(UC_flag=='UC_flag_created')){
                            if(UC_room.length==0){
                                $('#UC_lb_roomtype').replaceWith('<input type="text" name="UC_tb_newroomtype" id="UC_tb_newroomtype" maxlength="30" class="form-control autosize" placeholder="Room Type"/>');
                                $('#UC_btn_addroomtype').hide();
                                $('#UC_btn_removeroomtype').hide();
                                $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                            }
                            else{
                                var UC_roomoptions ='<option>SELECT</option>';
                                for (var i = 0; i < UC_room.length; i++) {
                                    UC_roomoptions += '<option value="' + UC_room[i]  + '">' + UC_room[i] + '</option>';
                                }
                                $('#UC_tb_newroomtype').replaceWith('<select name="UC_lb_roomtype" id="UC_lb_roomtype" class="form-control"><option>SELECT</option></select>');
                                $('#UC_btn_removeroomtype').replaceWith('<input class="btn btn-info" type="button"  name="UC_btn_addroomtype" value="ADD" id="UC_btn_addroomtype"/>');
                                $('#UC_lb_roomtype').html(UC_roomoptions).show();
                                $('#UC_btn_addroomtype').show();
                            }
                        }
                        if((UC_flag=='UC_flag_stamptype')||(UC_flag=='UC_flag_notcreation')||(UC_flag=='UC_flag_created')){
                            if(UC_stamp.length==0){
                                $('#UC_lb_stamptype').replaceWith('<input type="text" name="UC_tb_newstamptype" id="UC_tb_newstamptype" maxlength="12" class="form-control alphaonly autosize" placeholder="Stamp Duty Type"/>');
                                $('#UC_btn_addstamptype').hide();
                                $('#UC_btn_removestamptype').hide();
                                $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
                                $("#UC_tb_newstamptype").prop("title",UC_errorMsg_array[0].EMC_DATA);
                            }
                            else{
                                var UC_stampoptions ='<option>SELECT</option>';
                                for (var i = 0; i < UC_stamp.length; i++) {
                                    UC_stampoptions += '<option value="' + UC_stamp[i]  + '">' + UC_stamp[i] + '</option>';
                                }
                                $('#UC_tb_newstamptype').replaceWith('<select id="UC_lb_stamptype" name="UC_lb_stamptype" class="form-control"><option>SELECT</option></select>');
                                $('#UC_btn_removestamptype').replaceWith('<input class="btn btn-info" type="button" name="UC_btn_addstamptype" value="ADD" id="UC_btn_addstamptype"/>');
                                $('#UC_lb_stamptype').html(UC_stampoptions).show();
                                $('#UC_btn_addstamptype').show();
                            }
                        }
                        if(UC_flag=='UC_flag_created'){
                            var UC_unitnumber= $("#UC_tb_unitno").val();
                            var UC_errmsg =UC_errorMsg_array[6].EMC_DATA.replace('[UNITNO]',UC_unitnumber);
                            show_msgbox("UNIT CREATION",UC_errmsg,'success',false);
                            UC_resetfrm();
                        }
                    }
                    else if(UC_response[3]==0)
                    {
                        show_msgbox("UNIT CREATION",UC_errorMsg_array[9].EMC_DATA,'error',false);
                    }
                }
            }
            var UC_max = 250;
        // KEYPRESS EVENT OF BANK ADDRESSS
            $('#UC_ta_address').keypress(function(e) {
                if (e.which < 0x20) {
                    return;
                }
                if (this.value.length == UC_max) {
                    e.preventDefault();
                }
                else if (this.value.length > UC_max) {
                    this.value = this.value.substring(0, UC_max);
                }
            });
        // CHECK UNIT NUMBER LENGTH
            $(document).on("change",'#UC_tb_unitno',function(){
                if(($('#UC_tb_unitno').val().length>0)&&($('#UC_tb_unitno').val().length<4)){
                    UC_flag='false';
                    $('#UC_div_errunitno').text(UC_errorMsg_array[2].EMC_DATA);
                    $("#UC_tb_unitno").addClass('invalid');
                }
                if(($('#UC_tb_unitno').val().length==4)&&(parseInt($('#UC_tb_unitno').val())!=0)){
                    $(".preloader").show();
                    UC_flag='true';
                    var UC_source='UC_tb_unitno';
                    var unitno=$('#UC_tb_unitno').val();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/Check_existinginput',
                        data:{'source':UC_source,'chkinput':unitno},
                        success: function(unitdata) {
                            var unit_values=JSON.parse(unitdata);
                            UC_unitresult(unit_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT CREATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                if(($('#UC_tb_unitno').val()==0)||(parseInt($('#UC_tb_unitno').val())==0)){
                    $('#UC_div_errunitno').text('');
                    $("#UC_tb_unitno").removeClass('invalid');
                }
            });
        // SUCCESS FUNCTION FOR UNIT ALREADY EXISTS
            function UC_unitresult(response){
                $(".preloader").hide();
                if(response==true){
                    UC_flag_unit='false';
                    $('#UC_div_errunitno').text(UC_errorMsg_array[4].EMC_DATA);
                    $("#UC_btn_submit").attr("disabled", "disabled");
                    $("#UC_tb_unitno").addClass('invalid');
                }
                else if(response==false){
                    UC_flag_unit='true';
                    $('#UC_div_errunitno').text('');
                    $("#UC_tb_unitno").removeClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                        $("#UC_btn_submit").removeAttr("disabled");
                    }
                }
            }
        // CHECKING ACCESS CARD LENGTH
            $(document).on("change",'#UC_tb_accesscard',function(){
                var access_card=parseInt($('#UC_tb_accesscard').val());
                if((parseInt($('#UC_tb_accesscard').val()).toString().length>0)&&(parseInt($('#UC_tb_accesscard').val()).toString().length<4)){
                    UC_flaglen=0;
                    $('#UC_div_errcard').text(UC_errorMsg_array[3].EMC_DATA);
                    $("#UC_tb_accesscard").addClass('invalid');
                }
                if((parseInt($('#UC_tb_accesscard').val())==0)||($('#UC_tb_accesscard').val().length==0)){
                    UC_flag='true';
                    $('#UC_div_errcard').text('');
                    $("#UC_tb_accesscard").removeClass('invalid');
                }
                if(parseInt($('#UC_tb_accesscard').val()).toString().length>=4){
                    $(".preloader").show();
                    var UC_source='UC_tb_accesscard';
                    var accesscardno=$('#UC_tb_accesscard').val();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/Check_existinginput',
                        data:{'source':UC_source,'chkinput':accesscardno},
                        success: function(carddata){
                            var card_values=JSON.parse(carddata);
                            UC_accessresult(card_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT CREATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // SUCCESS FUNCTION FOR UNIT NUMBER AND ACCESS CARD
            function UC_accessresult(cardresponse){
                $(".preloader").hide();
                if(cardresponse=='true'){
                    UC_flag='false';
                    $('#UC_div_errcard').text(UC_errorMsg_array[5].EMC_DATA);
                    $("#UC_btn_submit").attr("disabled", "disabled");
                    $("#UC_tb_accesscard").addClass('invalid');
                }
                else if(cardresponse=='false'){
                    UC_flag='true';
                    $('#UC_div_errcard').text('');
                    $("#UC_tb_accesscard").removeClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                        $("#UC_btn_submit").removeAttr("disabled");
                    }
                }
            }
        // CHANGE EVENT FOR ENABLING SUBMIT BUTTON UNTIL MANDATORY VALUES ARE GIVEN
            $(document).on("change blur",'#UC_form_unitcreation',function(){
                var UC_unitno=$("#UC_tb_unitno").val();
                var UC_access=$("#UC_tb_accesscard").val();
                if((parseInt($('#UC_tb_unitno').val())==0)||($("#UC_tb_unitno").val()=='')||($("#UC_tb_unitrentalamt").val()=='')||(parseInt($("#UC_tb_unitrentalamt").val())=='')||($("#UC_db_startdate").val()=='')||($("#UC_db_enddate").val()=='')||((UC_unitno.length>0)&&(UC_unitno.length<4))||((parseInt($('#UC_tb_accesscard').val()).toString().length>0)&&(parseInt($('#UC_tb_accesscard').val()).toString().length<4)&&(parseInt(UC_access)!=0)&&(UC_access!=''))||(UC_flg_Doorcode==0)||(UC_flg_Login==0)){
                    $("#UC_btn_submit").attr("disabled", "disabled");
                    UC_flaglen=0;
                }
                else
                    UC_flaglen=1;
                if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flag=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                    $("#UC_btn_submit").removeAttr("disabled");
                }
                else{
                    $("#UC_btn_submit").attr("disabled", "disabled");
                }
            });
        // CLICK FUNCTION FOR ADD AND REMOVE ROOM TYPE BUTTON
            $(document).on('click','#UC_btn_addroomtype,#UC_btn_removeroomtype',function(){
                $('#UC_div_errroom').text('');
                $("#UC_tb_newroomtype").removeClass('invalid');
                if($(this).attr('id')=="UC_btn_addroomtype"){
                    UC_flag_room='false';
                    // REPLACE NEW ROOM TYPE
                    $('#UC_lb_roomtype').replaceWith('<input type="text" name="UC_tb_newroomtype" id="UC_tb_newroomtype" maxlength="30" class="form-control autosize" placeholder="Room Type"/>');
                    $(this).replaceWith('<input class="btn btn-info" type="button" name="UC_btn_removeroomtype" value="CLEAR" id="UC_btn_removeroomtype"/>');
                    $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                }
                if($(this).attr('id')=='UC_btn_removeroomtype'){
                    $(".preloader").show();
                    UC_flag_room='true';
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/Initialdata',
                        data:{'flag':'UC_flag_roomtype'},
                        success: function(data) {
                            var initial_values=JSON.parse(data);
                            UC_result(initial_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT CREATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    $('#UC_tb_newroomtype').replaceWith('<select name="UC_lb_roomtype" id="UC_lb_roomtype" class="form-control"><option>SELECT</option></select>');
                    $(this).replaceWith('<input class="btn btn-info" type="button" name="UC_btn_addroomtype" value="ADD" id="UC_btn_addroomtype"/>');
                }
                if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flag=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                    $("#UC_btn_submit").removeAttr("disabled");
                }
                else{
                    $("#UC_btn_submit").attr("disabled", "disabled");
                }
            });
        // CLICK FUNCTION FOR ADD AND REMOVE ROOM TYPE BUTTON
            $(document).on('click','#UC_btn_addstamptype,#UC_btn_removestamptype',function(){
                $('#UC_div_errstamp').text('');
                $("#UC_tb_newstamptype").removeClass('invalid');
                // REPLACE NEW STAMP TYPE
                if($(this).attr('id')=="UC_btn_addstamptype"){
                    UC_flag_stamp='false';
                    $('#UC_lb_stamptype').replaceWith('<input type="text" name="UC_tb_newstamptype" id="UC_tb_newstamptype" maxlength="12" class="form-control alphaonly autosize" placeholder="Stamp Duty Type"/>');
                    $(this).replaceWith('<input type="button" name="UC_btn_removestamptype" value="CLEAR" id="UC_btn_removestamptype" class="btn btn-info"/>');
                    $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                    $("#UC_tb_newstamptype").prop("title",UC_errorMsg_array[0].EMC_DATA);
                }
                if($(this).attr('id')=='UC_btn_removestamptype'){
                    $(".preloader").show();
                    UC_flag_stamp='true';
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/Initialdata',
                        data:{'flag':'UC_flag_stamptype'},
                        success: function(data) {
                            var initial_values=JSON.parse(data);
                            UC_result(initial_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT CREATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    $('#UC_div_errstamp').text('');
                    $('#UC_tb_newstamptype').replaceWith('<select id="UC_lb_stamptype" name="UC_lb_stamptype" class="form-control"><option>SELECT</option></select>');
                    $(this).replaceWith('<input type="button" name="UC_btn_addstamptype" value="ADD" id="UC_btn_addstamptype" class="btn btn-info"/>');
                }
                if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flag=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                    $("#UC_btn_submit").removeAttr("disabled");
                }
                else{
                    $("#UC_btn_submit").attr("disabled", "disabled");
                }
            });
        // CHANGE EVENT FUNCTION FOR ROOM TYPE
            $(document).on("blur",'#UC_tb_newroomtype',function(){
                var UC_newroom=$(this).val();
                var UC_source=$(this).attr('id');
                if(UC_newroom.length==0){
                    UC_flag_room='false';
                    if((UC_newroom.length==0)&&(UC_room.length==0)){
                        UC_flag_room='true';
                    }
                    $('#UC_div_errroom').text('');
                    $("#UC_tb_newroomtype").removeClass('invalid');
                }
                else{
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/Check_existinginput',
                        data:{'source':UC_source,'chkinput':UC_newroom},
                        success: function(roomdata){
                            var room_values=JSON.parse(roomdata);
                            UC_roomresult(room_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT CREATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // SUCCESS FUNCTION FOR STAMP TYPE ALREADY EXISTS
            function UC_roomresult(UC_msgroom) {
                $(".preloader").hide();
                if(UC_msgroom=='true'){
                    $('#UC_div_errroom').text(UC_errorMsg_array[7].EMC_DATA);
                    $("#UC_tb_newroomtype").addClass('invalid');
                    $("#UC_btn_submit").attr("disabled", "disabled");
                    UC_flag_room='false';
                }
                else if(UC_msgroom=='false')
                {
                    UC_flag_room='true';
                    $('#UC_div_errroom').text('');
                    $("#UC_tb_newroomtype").removeClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_room=='true')&&(UC_flag_stamp=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                        $("#UC_btn_submit").removeAttr("disabled");
                    }
                }
            }
        // CHANGE EVENT FUNCTION FOR STAMP TYPE
            $(document).on("blur",'#UC_tb_newstamptype',function(){
                var UC_newstamp=$(this).val();
                var UC_source=$(this).attr('id');
                if(UC_newstamp.length==0){
                    UC_flag_stamp='false';
                    if((UC_newstamp.length==0)&&(UC_stamp.length==0)){
                        UC_flag_stamp='true';
                    }
                    $('#UC_div_errstamp').text('');
                    $("#UC_tb_newstamptype").removeClass('invalid');
                }
                else{
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/Check_existinginput',
                        data:{'source':UC_source,'chkinput':UC_newstamp},
                        success: function(stampdata){
                            var stamp_values=JSON.parse(stampdata);
                            UC_stampresult(stamp_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT CREATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // SUCCESS FUNCTION FOR STAMP TYPE ALREADY EXISTS
            function UC_stampresult(UC_msgstamp) {
                $(".preloader").hide();
                if(UC_msgstamp=='true')
                {
                    UC_flag_stamp='false';
                    $('#UC_div_errstamp').text(UC_errorMsg_array[8].EMC_DATA);
                    $("#UC_tb_newstamptype").addClass('invalid');
                    $("#UC_btn_submit").attr("disabled", "disabled");
                }
                else if(UC_msgstamp=='false')
                {
                    UC_flag_stamp='true';
                    $('#UC_div_errstamp').text('');
                    $("#UC_tb_newstamptype").removeClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1)){
                        $("#UC_btn_submit").removeAttr("disabled");
                    }
                }
            }
        // CHECK DOORCODE
            $(document).on("change blur",'#UNIT_tb_doorcode',function(){
                $('#UC_lbl_doorcode').text('');
                $(this).removeClass('invalid');
                UC_flg_Doorcode=1;
                if(($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length<6)){
                    $(this).addClass('invalid');
                    UC_flg_Doorcode=0;
                    $('#UC_lbl_doorcode').text(UC_errorMsg_array[14].EMC_DATA);
                }
                else if(($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length>=6)){
                    $(".preloader").show();
                    UC_func_doorcode_weblogin($(this).val(),$(this).attr('id'));
                }
            });
        // CHECK WEBLOGIN
            $(document).on("change blur",'#UNIT_tb_weblogin',function(){
                $('#UC_lbl_weblogin').text('');
                $(this).removeClass('invalid');
                UC_flg_Login=1;
                if(($(this).val()!='')&&($(this).val().length<5)){
                    $(this).addClass('invalid');
                    UC_flg_Login=0;
                    $('#UC_lbl_weblogin').text(UC_errorMsg_array[13].EMC_DATA);
                }
                else if(($(this).val()!='')&&($(this).val().length>=5)){
                    $(".preloader").show();
                    UC_func_doorcode_weblogin($(this).val(),$(this).attr('id'));
                }
            });
            function UC_func_doorcode_weblogin(UC_value,UC_attrid){
                $("#UC_btn_submit").attr("disabled", "disabled");
                $.ajax({
                    type: "POST",
                    url: ctrl_unitcreate_url+'/Check_existinginput',
                    data:{'source':UC_attrid,'chkinput':UC_value},
                    success: function(doorlogindata){
                        var door_logindata=JSON.parse(doorlogindata);
                        UC_SuccessLoginDoor(door_logindata);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("UNIT CREATION",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            }
        // SUCCESS FUNCTION FOR DOORCODE AND WEBLOGIN
            function UC_SuccessLoginDoor(UC_response_Login){
                $(".preloader").hide();
                if(UC_response_Login[0]==0){
                    if(UC_response_Login[1]=='UNIT_tb_doorcode'){
                        UC_flg_Doorcode=0;
                        $('#UC_lbl_doorcode').text(UC_errorMsg_array[12].EMC_DATA);
                    }
                    else if(UC_response_Login[1]=='UNIT_tb_weblogin'){
                        UC_flg_Login=0;
                        $('#UC_lbl_weblogin').text(UC_errorMsg_array[11].EMC_DATA);
                    }
                    $("#"+UC_response_Login[1]).addClass('invalid');
                    if((UC_flaglen==1)&&(UC_flag=='true')&&(UC_flag_stamp=='true')&&(UC_flag_room=='true')&&(UC_flag_unit=='true')&&(UC_flg_Doorcode==1)&&(UC_flg_Login==1))
                        $("#UC_btn_submit").removeAttr("disabled");
                }
                else{
                    if(UC_response_Login[1]=='UNIT_tb_doorcode'){
                        UC_flg_Doorcode=1;
                        $('#UC_lbl_doorcode').text('');
                    }
                    else if(UC_response_Login[1]=='UNIT_tb_weblogin'){
                        $('#UC_lbl_weblogin').text('');
                        UC_flg_Login=1;
                    }
                    $("#"+UC_response_Login[1]).removeClass('invalid');
                }
            }
        // FUCNTION FOR CLEAR ALL VALUES
            function UC_resetfrm(){
                $('#UC_form_unitcreation').find('textarea').val('');
                $(':input','#UC_form_unitcreation')
                    .not(':button')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
                $('#UC_form_unitcreation').find('select').val('SELECT');
                $("#UC_db_enddate").datepicker('option', {minDate: '-1M', maxDate: '+2Y'});
                $('input').removeClass('invalid');
                $("#UC_btn_submit").attr("disabled", "disabled");
                $('#UC_div_errunitno').text("");
                $('#UC_div_errcard').text("");
                $('#UC_div_errroom').text('');
                $('#UC_div_errstamp').text('');
                $('.errormsg').text('');
                $('#UC_ta_comments,#UC_ta_address').height(114);//set default size for textarea , we can give id also
            }
        //CLICK FUNCTION FOR RESET
            $("#UC_btn_reset").click(function(){
                if((($('#UC_lb_roomtype').val()==undefined)&&($('#UC_btn_removeroomtype').val()=='CLEAR'))||(($('#UC_lb_stamptype').val()==undefined)&&($('#UC_btn_removestamptype').val()=='CLEAR'))){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/Initialdata',
                        data:{'flag':'UC_flag_notcreation'},
                        success: function(data) {
                            var initial_values=JSON.parse(data);
                            UC_result(initial_values);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT CREATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                UC_resetfrm();
            });
        // CLICK FUNCTION FOR SAVE BUTTON
            $("#UC_btn_submit").click(function(){
                var UC_checked_nonEI=$('#UC_cb_nonEI').is(":checked");
                if (UC_checked_nonEI==true){
                    $('#UC_cb_nonEI').val('X')}
                else{
                    $('#UC_cb_nonEI').val('')
                }
                $(".preloader").show();
                var formelement=$('#unit_createupdate_form').serialize();
                $.ajax({
                    type: "POST",
                    url: ctrl_unitcreate_url+'/Unitsaveprocess',
                    data: formelement,
                    success: function(savedata) {
                        var initial_values=JSON.parse(savedata);
                        UC_result(initial_values);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("UNIT CREATION",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            });

    /*-------------------------------------------------UNIT SEARCH AND UPDATE FUNCTIONALITY------------------------------------------------*/
        // FUNCTION FOR CHANGE DATE FORMAT
            function USU_FormTableDateFormat(USU_inputdate){
                var USU_string  = USU_inputdate.split("-");
                return USU_string[2]+'-'+ USU_string[1]+'-'+USU_string[0];
            }
        // loade initial data in updateform
            function USU_success(USU_response){
                USU_errormsg_arr=USU_response[2];
                USU_unitoption_arr=USU_response[1];
                USU_glb_unitno_arr=USU_response[0];
                $('#USU_lb_searchby').html('');
                $('#USU_lb_typeofcard').html('');
                USU_select_options_card ='<option>SELECT</option>';
                $('#USU_subheaderdiv,#USU_carddiv,#USU_roomdiv,#USU_datediv,#USU_stampamtdiv,#USU_paymentamtdiv,#USU_searchbtn,#USU_headermsg,#USU_div_flex,#USU_errmsg_roominventory,#USU_div_updateform').hide();
                $('#USU_form_unitupdate').find('input:text').val('');
                $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                $('#USU_section1,#USU_section2').empty();
                $('#USU_pdf_btn').hide();
                if(USU_unitoption_arr.length==0)
                    $('#USU_form_unitupdate').replaceWith('<div class="form-group"><label class="col-sm-12 errormsg"> '+USU_errormsg_arr[35].EMC_DATA+'</label></div>');
                else{
                    var USU_select_options ='<option>SELECT</option>';
                    for (var i = 0; i < USU_unitoption_arr.length; i++)
                    {
                        if((USU_unitoption_arr[i].unitid==10)||(USU_unitoption_arr[i].unitid==11)||(USU_unitoption_arr[i].unitid==12))
                            USU_select_options_card += '<option value="' + USU_unitoption_arr[i].unitid + '">'+ USU_unitoption_arr[i].unitdata+' </option>';
                        else
                            USU_select_options += '<option value="' + USU_unitoption_arr[i].unitid + '">'+ USU_unitoption_arr[i].unitdata+' </option>';
                    }
                    $('#USU_lb_searchby').html(USU_select_options);
                    $('#USU_form_unitupdate').show();
                    $('.preloader').hide();
                    $('#USU_lb_searchby').focus();
                }
            }
            var USU_unitno_flag = 'unittrue';
            var USU_cardnumber_flag = 'accesstrue';
        // CHANGE FUNCTION SEARCH BY ALL TYPES
            $('#USU_lb_searchby').change(function(){
                var USU_unit_optionfetch =$(this).val();
                $('#USU_subheaderdiv,#USU_carddiv,#USU_roomdiv,#USU_datediv,#USU_stampamtdiv,#USU_paymentamtdiv,#USU_searchbtn,#USU_headermsg,#USU_div_flex,#USU_errmsg_roominventory,#USU_div_updateform').hide();
                $('#USU_form_unitupdate').find('input:text').val('');
                $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                $('#USU_section1,#USU_section2').empty();
                $('#USU_pdf_btn').hide();
                if(USU_unit_optionfetch!='SELECT')
                {
                    $(".preloader").show();
                    if((USU_unit_optionfetch==5)||(USU_unit_optionfetch==8))//ROOM TYPE,STAMP TYPE
                    {
                        var formelement=$('#unit_createupdate_form').serialize();
                        $.ajax({
                            type: "POST",
                            url: ctrl_unitcreate_url+'/USU_flexttable',
                            data: formelement,
                            success: function(flexdata) {
                                var flxsarray=JSON.parse(flexdata);
                                USU_success_flex(flxsarray);
                                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                            },
                            error:function(data){
                                var errordata=(JSON.stringify(data));
                                show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                                $('.preloader').hide();
                            }
                        });
                    }
                    else
                    {
                        $.ajax({
                            type: "POST",
                            url: ctrl_unitcreate_url+'/USU_Searchbyoption',
                            data: {'option':USU_unit_optionfetch,'USU_parentfunc_load':'USU_parentfunc_load','USU_not_load_lb':'USU_not_load_lb'},
                            success: function(data) {
                                var valuesarray=JSON.parse(data);
                                USU_success_load_searchby_lb(valuesarray);
                                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                                $('#USU_db_fromdate').focus();
                            },
                            error:function(data){
                                var errordata=(JSON.stringify(data));
                                show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                                $('.preloader').hide();
                            }
                        });
                    }
                }
            });
        // SUCCESS FUNCTION FOR ALL SEARCH BY SEARCH
            function USU_success_load_searchby_lb(USU_response_load_searchby){
                $(".preloader").hide();
                var USU_unit_optionfetch =USU_response_load_searchby[0].USU_flag;
                var USU_unit_optionvalues=USU_response_load_searchby[0].USU_loaddata_searchby;
                if(USU_unit_optionfetch==9)
                    USU_unit_optionvalues_roomtype=USU_unit_optionvalues;
                var USU_td='';
                $('#USU_subheadermsg').text($('#USU_lb_searchby').find('option:selected').text());
                if((USU_unit_optionfetch==2)||(USU_unit_optionfetch==4)||(USU_unit_optionfetch==3)||(USU_unit_optionfetch==6))
                {
                    if(USU_unit_optionfetch==2)//STAMP AMOUNT
                    {
                        $('#USU_carddiv,#USU_roomdiv,#USU_datediv,#USU_paymentamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory').hide();
                        $('#USU_stampamtdiv,#USU_searchbtn,#USU_subheaderdiv').show();
                        $('#USU_form_unitupdate').find('input:text').val('');
                        $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                        $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                        $('#USU_pdf_btn').hide();
                        $('#USU_tb_dutyamt_fromamt').focus();
                    }
                    else if(USU_unit_optionfetch==4)//PAYMENT
                    {
                        $('#USU_carddiv,#USU_roomdiv,#USU_datediv,#USU_stampamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory').hide();
                        $('#USU_paymentamtdiv,#USU_searchbtn,#USU_subheaderdiv').show();
                        $('#USU_form_unitupdate').find('input:text').val('');
                        $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                        $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                        $('#USU_pdf_btn').hide();
                        $('#USU_tb_payment_fromamt').focus();
                    }
                    else if((USU_unit_optionfetch==3)||(USU_unit_optionfetch==6))//END DATE,START DATE
                    {
                        $('#USU_carddiv,#USU_roomdiv,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory').hide();
                        $('#USU_datediv,#USU_searchbtn,#USU_subheaderdiv').show();
                        $('#USU_form_unitupdate').find('input:text').val('');
                        $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                        $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                        $('#USU_pdf_btn').hide();
                    }
                }
                else if((USU_unit_optionfetch==1)||(USU_unit_optionfetch==5)||(USU_unit_optionfetch==9)||(USU_unit_optionfetch==8)||(USU_unit_optionfetch==7))
                {
                    if(USU_unit_optionvalues.length==0){
                        if((USU_unit_optionfetch==1)||(USU_unit_optionfetch==7)){//INVENTROY CARD
                            var USU_errmsg_roominventory=USU_errormsg_arr[43].EMC_DATA;
                        }
                        else if(USU_unit_optionfetch==9)//ROOM TYPE WITH UNIT
                        {
                            var USU_errmsg_roominventory=USU_errormsg_arr[46].EMC_DATA;
                        }
                        $('#USU_errmsg_roominventory').show();
                        $('#USU_lbl_errmsg_roominventory').text(USU_errmsg_roominventory);
                    }
                    else
                    {
                        var USU_unit_options='<option>SELECT</option>';
                        if(USU_unit_optionfetch==1){
                            for(var i = 0; i < USU_unit_optionvalues.length; i++)
                            {
                                USU_unit_options += '<option value="' + USU_unit_optionvalues[i].UNIT_NO + '">' + USU_unit_optionvalues[i].UNIT_NO + '</option>';
                            }
                        }
                        else{
                            for(var i = 0; i < USU_unit_optionvalues.length; i++)
                            {
                                USU_unit_options += '<option value="' + USU_unit_optionvalues[i] + '">' + USU_unit_optionvalues[i] + '</option>';
                            }
                        }
                        if((USU_unit_optionfetch==1)||(USU_unit_optionfetch==7))//INVENTORY CARD, UNIT
                        {
                            $('#USU_lb_unitno').html(USU_unit_options);
                            $('#USU_carddiv,#USU_unitno,#USU_subheaderdiv').show();
                            $('#USU_roomdiv,#USU_cardtype,#USU_cardno,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory').hide();
                            $('#USU_form_unitupdate').find('input:text').val('');
                            $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                            $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                            $('#USU_pdf_btn').hide();
                            $('#USU_lb_unitno').focus();
                        }
                        else if(USU_unit_optionfetch==9)//ROOM TYPE WITH UNIT
                        {
                            $('#USU_lb_roomtyps').html(USU_unit_options);
                            $('#USU_roomdiv,#USU_subheaderdiv').show();
                            $('#USU_carddiv,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory').hide();
                            $('#USU_form_unitupdate').find('input:text').val('');
                            $('#USU_carddiv,#USU_roomdiv').find('select').val('SELECT');
                            $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                            $('#USU_pdf_btn').hide();
                            $('#USU_lb_roomtyps').focus();
                        }
                    }
                }
                $(document).doValidation({rule:'fromto',prop:{elem1:'USU_db_fromdate',elem2:'USU_db_todate'}});
                $("#USU_tb_dutyamt_fromamt").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
                $("#USU_tb_dutyamt_toamt").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
                $("#USU_tb_payment_fromamt").doValidation({rule:'numbersonly',prop:{realpart:4}});
                $("#USU_tb_payment_toamt").doValidation({rule:'numbersonly',prop:{realpart:4}});
                $(".USU_class_title_nums").prop("title",USU_errormsg_arr[1].EMC_DATA);
                $("#USU_db_fromdate,#USU_db_todate").datepicker("option", { maxDate: '+2Y'});
            }
        // VALIDATION FOR STAMP DUTY AMOUNT
            $(document).on('change blur','.USU_class_amtvalidstamp',function(){
                var USU_tb_dutyamt_fromamt=$('#USU_tb_dutyamt_fromamt').val();
                var USU_tb_dutyamt_toamt=$('#USU_tb_dutyamt_toamt').val();
                if((parseInt(USU_tb_dutyamt_fromamt) <= parseInt(USU_tb_dutyamt_toamt) )&& (USU_tb_dutyamt_fromamt!=''))
                    ErrorControl.AmountCompare="Valid";
                else
                    ErrorControl.AmountCompare="InValid";
                if((ErrorControl.AmountCompare=="InValid")||(USU_tb_dutyamt_fromamt==0)||(USU_tb_dutyamt_toamt==0))
                    $('#USU_btn_search').attr("disabled", "disabled");
                else
                    $('#USU_btn_search').removeAttr("disabled");
                if(USU_tb_dutyamt_fromamt!='' && USU_tb_dutyamt_toamt!='' && ErrorControl.AmountCompare=="InValid")
                    $("#USU_lbl_errmsg_date").text(USU_errormsg_arr[31].EMC_DATA);
                else
                    $("#USU_lbl_errmsg_date").text('');
            });
        // VALIDATION FOR PAYMENT AMOUNT
            $(document).on('change blur','.USU_class_amtvalidpayment',function(){
                var USU_tb_payment_fromamt=$('#USU_tb_payment_fromamt').val();
                var USU_tb_payment_toamt=$('#USU_tb_payment_toamt').val();
                if(USU_tb_payment_fromamt <= USU_tb_payment_toamt && USU_tb_payment_fromamt!='')
                    ErrorControl.AmountCompare="Valid";
                else
                    ErrorControl.AmountCompare="InValid";
                if((ErrorControl.AmountCompare=="InValid")||(USU_tb_payment_fromamt==0)||(USU_tb_payment_toamt==0))
                    $('#USU_btn_search').attr("disabled", "disabled");
                else
                    $('#USU_btn_search').removeAttr("disabled");
                if(USU_tb_payment_fromamt!='' && USU_tb_payment_toamt!='' && ErrorControl.AmountCompare=="InValid")
                    $("#USU_lbl_errmsg_paymentdate").text(USU_errormsg_arr[31].EMC_DATA);
                else
                    $("#USU_lbl_errmsg_paymentdate").text('');
            });
        // CHANGE EVENT FOR UNTI LISTBOX
            $(document).on('change','#USU_lb_unitno',function(event){
                event.stopPropagation();
                event.preventDefault();
                event.stopImmediatePropagation();
                $('#USU_cardtype,#USU_cardno,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory,#USU_div_updateform').hide();
                $('#USU_form_unitupdate').find('input:text').val('');
                $('#USU_cardtype,#USU_cardno').find('select').val('SELECT');
                $('#USU_headermsg,#USU_errmsg_roominventory,#USU_lbl_errmsg_cardno').text('');
                $('#USU_section1,#USU_section2').empty();
                $('#USU_lb_typeofcard').html('');
                $('#USU_pdf_btn').hide();
                var USU_unit_optionfetch =$('#USU_lb_searchby').val();
                var formelement=$('#unit_createupdate_form').serialize();
                if($('#USU_lb_unitno').val()!='SELECT'){
                    if(USU_unit_optionfetch==1)//INVENTORY CARD
                    {
                        $('#USU_lb_typeofcard').html(USU_select_options_card);
                        $('#USU_cardtype').show();
                        $('#USU_lb_typeofcard').focus();
                    }
                    else
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: ctrl_unitcreate_url+'/USU_flexttable',
                            data: formelement,
                            success: function(flexdata) {
                                var flxsarray=JSON.parse(flexdata);
                                USU_success_flex(flxsarray);
                                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                            },
                            error:function(data){
                                var errordata=(JSON.stringify(data));
                                show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                                $('.preloader').hide();
                            }
                        });
                    }
                }
            });
        // CHANGE EVENT FOR ROOM TYPE LISTBOX
        $(document).on('change','#USU_lb_roomtyps',function(event){
            event.stopPropagation();
            event.preventDefault();
            event.stopImmediatePropagation();
            $('#USU_cardtype,#USU_cardno,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory,#USU_div_updateform').hide();
            $('#USU_form_unitupdate').find('input:text').val('');
            $('#USU_cardtype,#USU_cardno').find('select').val('SELECT');
            $('#USU_headermsg,#USU_errmsg_roominventory').text('');
            $('#USU_section1,#USU_section2').empty();
            $('#USU_lb_typeofcard').html('');
            $('#USU_pdf_btn').hide();
            var USU_unit_optionfetch =$('#USU_lb_searchby').val();
            var formelement=$('#unit_createupdate_form').serialize();
            if($('#USU_lb_roomtyps').val()!='SELECT'){
                if(USU_unit_optionfetch==1)//INVENTORY CARD
                {
                    $('#USU_lb_typeofcard').html(USU_select_options_card);
                    $('#USU_cardtype').show();
                }
                else
                {
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_flexttable',
                        data: formelement,
                        success: function(flexdata) {
                            var flxsarray=JSON.parse(flexdata);
                            USU_success_flex(flxsarray);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            }
        });
        // CHANGE EVENT FOR SEARCH BY CARD
            $(document).on('change','#USU_lb_typeofcard',function(){
                $('#USU_cardno,#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory,#USU_div_updateform').hide();
                $('#USU_form_unitupdate').find('input:text').val('');
                $('#USU_cardno').find('select').val('SELECT');
                $('#USU_pdf_btn').hide();
                $('#USU_headermsg,#USU_errmsg_roominventory,#USU_lbl_errmsg_cardno').text('');
                if($('#USU_lb_typeofcard').val()!='SELECT'){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_AlreadyExists',
                        data: {'inventory_unitno':$('#USU_lb_unitno').val(),'typeofcard':$('#USU_lb_typeofcard').val(),'flag_card_unitno':'USU_flag_check_cardunitno','USU_parent_func':''},
                        success: function(existdata) {
                            var exist_data=JSON.parse(existdata);
                            USU_success_alreadyexists(exist_data);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // CHANGE EVENT FOR SEARCH BY LISTBOX
            $(document).on('change','#USU_lb_cardno',function(event){
                event.stopPropagation();
                event.preventDefault();
                event.stopImmediatePropagation();
                $('#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory,#USU_div_updateform').hide();
                $('#USU_form_unitupdate').find('input:text').val('');
                $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                $('#USU_section1,#USU_section2').empty();
                $('#USU_pdf_btn').hide();
                if($('#USU_lb_cardno').val()!='SELECT'){
                    $(".preloader").show();
                    var formelement=$('#unit_createupdate_form').serialize();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_flexttable',
                        data: formelement,
                        success: function(flexdata) {
                            var flxsarray=JSON.parse(flexdata);
                            USU_success_flex(flxsarray);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // CHANGE FUNCTION FOR FORM VALIDATION FOR SEARCH BUTTON
            $(document).on('change blur','.USU_class_datesearch',function(){
                $('#USU_paymentamtdiv,#USU_stampamtdiv,#USU_div_flex,#USU_headermsg,#USU_errmsg_roominventory,#USU_div_updateform').hide();
                $('#USU_headermsg,#USU_errmsg_roominventory').text('');
                $('#USU_section1,#USU_section2').empty();
                $('#USU_pdf_btn').hide();
                if(($('#USU_db_fromdate').val()=='')||($('#USU_db_todate').val()==''))
                {
                    $('#USU_btn_search').attr("disabled", "disabled")
                }
                else{
                    $('#USU_btn_search').removeAttr("disabled");
                }
            });
        // CLICK FUNCTION FOR DATE,AMOUNT SEARCH BUTTON
            $(document).on('click','#USU_btn_search',function(evnt){
                evnt.stopPropagation();
                evnt.preventDefault();
                evnt.stopImmediatePropagation();
                $(".preloader").show();
                var formelement=$('#unit_createupdate_form').serialize();
                $.ajax({
                    type: "POST",
                    url: ctrl_unitcreate_url+'/USU_flexttable',
                    data: formelement,
                    success: function(flexdata) {
                        var flxsarray=JSON.parse(flexdata);
                        USU_success_flex(flxsarray);
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            });
        // SUCCESS FUNCTION FOR FLEX TABLE
            var USU_flex_arr=[];
            var table; var previous_id;var tdvalue;var rid;
            function USU_success_flex(USU_response_flex){
                $(".preloader").hide();
                var sucssvar=USU_response_flex.USU_parentfunc_obj;
                if(USU_response_flex.toString().match("error:"))
                {
                    show_msgbox("UNIT SEARCH/UPDATE",USU_response_flex,'error',false);
                }
                else{
                    if((sucssvar!='true' && sucssvar!='zero') || (sucssvar=='')){
                        $('#USU_div_updateform').hide();
                        $("#USU_btn_search").attr("disabled","disabled");
                        $('#USU_div_stamphtmltable').hide();
                        $('#USU_div_flex').show();
                        $('#USU_div_htmltable').hide();
                        $('#USU_div_htmltable','#USU_div_stamphtmltable').empty();
                        $('#USU_headermsg').text('');
                        var USU_flex_flag=USU_response_flex.USU_flag;
                        USU_flex_arr=USU_response_flex.USU_flex_values;
                        var USU_load_flag_lb=USU_response_flex.USU_loadlb_obj;
                        if(USU_load_flag_lb==undefined){
                            if(USU_flex_arr!='')
                            {
                                if(USU_flex_flag==6){//START DATE
                                    var USU_sd_msg_rep=USU_errormsg_arr[18].EMC_DATA.replace('[START DATE]',$('#USU_db_fromdate').val());
                                    var USU_sd_msg=USU_sd_msg_rep.replace('[END DATE ]',$('#USU_db_todate').val());
                                }
                                else if(USU_flex_flag==3){//END DATE
                                    var USU_sd_msg_rep=USU_errormsg_arr[20].EMC_DATA.replace('[START DATE]',$('#USU_db_fromdate').val());
                                    var USU_sd_msg=USU_sd_msg_rep.replace('[END DATE]',$('#USU_db_todate').val());
                                }
                                else if(USU_flex_flag==4){//PAYMENT
                                    var USU_sd_msg_rep=USU_errormsg_arr[24].EMC_DATA.replace('[RNT FRM AMT]',$('#USU_tb_payment_fromamt').val());
                                    var USU_sd_msg=USU_sd_msg_rep.replace('[RNT TO AMT]',$('#USU_tb_payment_toamt').val());
                                }
                                else if(USU_flex_flag==2){//STAMP DUTY AMT
                                    var USU_sd_msg_rep=USU_errormsg_arr[25].EMC_DATA.replace('[STM FRM AMT]',$('#USU_tb_dutyamt_fromamt').val());
                                    var USU_sd_msg=USU_sd_msg_rep.replace('[STM TO AMT]',$('#USU_tb_dutyamt_toamt').val());
                                }
                                else if(USU_flex_flag==9)//ROOM TYPE WITH UNIT
                                {
                                    var USU_sd_msg=USU_errormsg_arr[23].EMC_DATA.replace('[ROOM TYPE]',$('#USU_lb_roomtyps').val());
                                }
                                else if(USU_flex_flag==8)//STAMP TYPE
                                {
                                    var USU_sd_msg=USU_errormsg_arr[40].EMC_DATA;
                                }
                                else if(USU_flex_flag==1)// CARD NUMBER
                                {
                                    if($('#USU_lb_typeofcard').val()==10)
                                        var USU_sd_msg=USU_errormsg_arr[49].EMC_DATA.replace('[CARD]',$('#USU_lb_cardno').val());
                                    if($('#USU_lb_typeofcard').val()==11)
                                        var USU_sd_msg=USU_errormsg_arr[50].EMC_DATA.replace('[CARD]',$('#USU_lb_cardno').val());
                                    if($('#USU_lb_typeofcard').val()==12)
                                        var USU_sd_msg=USU_errormsg_arr[22].EMC_DATA.replace('[CARD]',$('#USU_lb_cardno').val());
                                }
                                else if(USU_flex_flag==7)//UNIT
                                {
                                    var USU_sd_msg=USU_errormsg_arr[17].EMC_DATA.replace('[UNIT NO]',$('#USU_lb_unitno').val());
                                }
                                else if(USU_flex_flag==5)//ROOM TYPE
                                {
                                    var USU_sd_msg=USU_errormsg_arr[39].EMC_DATA;
                                }
                                $('#USU_headermsg').addClass('srctitle');
                                $('#USU_headermsg').removeClass('errormsg');
                                $('#USU_headermsg').text(USU_sd_msg).show();
                                $('#USU_pdf_btn').show();
                                var USU_tr ='';
                                var USU_tr_common_stamp ='<th style="width:50px">ACCESS CARD</th><th style="width:50px">ACCESS ACTIVE</th><th style="width:50px">ACCESS INVENTORY</th><th style="width:50px">ACCESS LOST</th><th style="width:160px">ROOM TYPE</th><th style="width:75px" class="uk-date-column">STAMP DUTY DATE</th><th style="width:140px">STAMP DUTY TYPE</th><th style="width:50px">STAMP DUTY AMOUNT</th><th style="width:500px">COMMENTS</th><th style="width:170px">USERSTAMP</th><th style="width:140px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>' ;
                                if(USU_flex_flag==8)//STAMP TYPE
                                {
                                    USU_tr +='<table id="USU_tble_htmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th style="width:350px">STAMP DUTY TYPE <em>*</em></th><th style="width:400px">USERSTAMP</th><th style="width:250px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                                }
                                else if(USU_flex_flag==5)//ROOM TYPE
                                {
                                    USU_tr += '<table id="USU_tble_htmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th style="width:350px">ROOM TYPE <em>*</em></th><th style="width:400px">USERSTAMP</th><th style="width:250px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                                }
                                else if((USU_flex_flag==7)||(USU_flex_flag==6)||(USU_flex_flag==3)||(USU_flex_flag==4))//UNIT,START DATE,END DATE,PAYMENT
                                {
                                    USU_tr += '<table style="width: 2800px" id="USU_tble_htmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th style="width:20px">EDIT</th><th style="width:40px">UNIT NUMBER</th><th style="width:75px" class="uk-date-column">START DATE</th><th style="width:75px" class="uk-date-column">END DATE</th><th style="width:20px">OBSOLETE</th><th style="width:20px">EI/NON_EI</th><th style="width:40px">UNIT RENTAL</th><th style="width:50px">UNIT DEPOSIT</th><th style="width:140px">ACCOUNT NUMBER</th><th style="width:200px">ACCOUNT NAME</th><th style="width:40px">BANK CODE</th><th style="width:40px">BRANCH CODE</th><th style="width:350px">BANK ADDRESS</th><th style="width:500px">COMMENTS</th><th style="width:180px">USERSTAMP</th><th style="width:130px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                                }
                                else if((USU_flex_flag==2)||(USU_flex_flag==1)||(USU_flex_flag==9))//STAMP DUTY AMT,INVENTORY CARD,ROOM TYPE WITH UNIT
                                {
                                    USU_tr +='<table style="width: 2000px" id="USU_tble_htmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th style="width:20px">EDIT</th><th style="width:40px">UNIT NUMBER</th>'+USU_tr_common_stamp;
                                }
                                for(var j=0;j<USU_flex_arr.length;j++)
                                {
                                    if((USU_flex_flag!=7)||((USU_flex_flag==7)&&(j==0))){
                                        if((USU_flex_flag==5) || (USU_flex_flag==8)){
                                            USU_tr +='<tr>';
                                        }
                                        else{
                                            USU_tr +='<tr><td><div class="col-lg-1"><span style="display: block; color:green;" class="glyphicon glyphicon-edit USU_class_flex" id="'+j+'_'+USU_flex_arr[j][0]+'"></div></td>';
                                        }
                                    }
                                    else{
                                        USU_tr +='<tr><td></td>';
                                    }
                                    if((USU_flex_flag==5) || (USU_flex_flag==8)){
                                        for (var i = 1; i < USU_flex_arr[j].length; i++)
                                        {
                                            var USU_null=USU_flex_arr[j][i];
                                            if(USU_null==null)
                                                USU_tr += '<td></td>';
                                            else
                                            {
                                                if(i==1)
                                                    USU_tr += '<td class="data_room_stamp" id="'+j+'_'+USU_flex_arr[j][0]+'">' + USU_null + '</td>';
                                                else{
                                                    if(i==3){
                                                        USU_tr += '<td style="text-align: center">' + USU_null + '</td>';
                                                    }
                                                    else{
                                                        USU_tr += '<td>' + USU_null + '</td>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    else{
                                        for (var i = 1; i < USU_flex_arr[j].length; i++)
                                        {
                                            var USU_null=USU_flex_arr[j][i];
                                            if(USU_null==null)
                                                USU_tr += '<td></td>';
                                            else{
                                                if((i>=1 && i <=7) || i==15){
                                                    USU_tr += '<td style="text-align: center">' + USU_null + '</td>';
                                                }
                                                else{
                                                    USU_tr += '<td>' + USU_null + '</td>';
                                                }
                                            }
                                        }
                                    }
                                    USU_tr +='</tr>';
                                }
                                USU_tr+='</tbody></table>';
                                $('#USU_section1').html(USU_tr);
                                table=$('#USU_tble_htmltable').DataTable({
                                    "aaSorting": [],
                                    "pageLength": 10,
                                    "sPaginationType":"full_numbers",
                                    "aoColumnDefs" : [
                                        { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"}],
                                    "sDom":"Rlfrtip"
                                });
                                // remove row hightlight and replace inline edit as td
                                table.on('page.dt', function(){
                                    $('#USU_tble_htmltable tr').removeClass('row_selected');
                                    $('#USU_div_updateform').hide();
                                    if(previous_id!=undefined){
                                        $('#'+previous_id).replaceWith("<td class='data_room_stamp' id='"+rid+'_'+previous_id+"' >"+tdvalue+"</td>");
                                    }
                                });
                                sorting();
                                $('#USU_div_htmltable').show();
                                var USU_stamp_unitdetails=USU_response_flex.USU_obj_stamp_rowarray_val[0];
                                var k=0;var q=75;
                                if(USU_stamp_unitdetails!=''){
                                    var USU_tr_stampunit='<table style="width: 2000px" id="USU_tble_stamphtmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr>'+USU_tr_common_stamp;
                                    for(var u=0;u<USU_response_flex.USU_obj_stamp_rowarray_val[1];u++){
                                        USU_tr_stampunit +='<tr>';
                                        for(var s=k;s<k+11;s++){
                                            if(USU_stamp_unitdetails[s]==null)
                                                USU_tr_stampunit +='<td></td>';
                                            else{
                                                if(((s%11)>=0 && (s%11)<=7) || (s%11)==10){
                                                    USU_tr_stampunit +='<td style="text-align: center">'+USU_stamp_unitdetails[s]+'</td>';
                                                }
                                                else{
                                                    USU_tr_stampunit +='<td>'+USU_stamp_unitdetails[s]+'</td>';
                                                }
                                            }
                                        }
                                        k=k+11;
                                        q=q+25;
                                        USU_tr_stampunit +='</tr>';
                                    }
                                    USU_tr_stampunit+='</tbody></table>';
                                    $('#USU_section2').html(USU_tr_stampunit);
                                    $('#USU_tble_stamphtmltable').DataTable({
                                        "aaSorting": [],
                                        "pageLength": 10,
                                        "sPaginationType":"full_numbers",
                                        "aoColumnDefs" : [
                                            { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ],
                                        "sDom":"Rlfrtip"
                                    });
                                    sorting();
                                    $('#USU_div_stamphtmltable').show();
                                }
                            }
                            else
                            {
                                if((USU_flex_flag==6)||(USU_flex_flag==3)){//START DATE,END DATE
                                    var USU_sd_msg_errrep=USU_errormsg_arr[19].EMC_DATA.replace('[START DATE]',$('#USU_db_fromdate').val());
                                    var USU_sd_errmsg=USU_sd_msg_errrep.replace('[END DATE ]',$('#USU_db_todate').val());
                                }
                                else if((USU_flex_flag==4)||(USU_flex_flag==2)){
                                    if(USU_flex_flag==4){//PAYMENT
                                        var USU_fromamt_errmsg=$('#USU_tb_payment_fromamt').val();
                                        var USU_toamt_errmsg=$('#USU_tb_payment_toamt').val();
                                    }
                                    else if(USU_flex_flag==2){//STAMPY DUTY AMT
                                        var USU_fromamt_errmsg=$('#USU_tb_dutyamt_fromamt').val();
                                        var USU_toamt_errmsg=$('#USU_tb_dutyamt_toamt').val();
                                    }
                                    var USU_sd_errmsg=USU_errormsg_arr[26].EMC_DATA.replace('[FRM AMT]',USU_fromamt_errmsg);
                                    var USU_sd_errmsg=USU_sd_errmsg.replace('[TO AMT]',USU_toamt_errmsg);
                                }
                                else if(USU_flex_flag==1)//INVENTORY CARD
                                {
                                    var USU_sd_errmsg=USU_errormsg_arr[33].EMC_DATA.replace('[CARD NO]',$('#USU_lb_cardno').val());
                                }
                                else if(USU_flex_flag==7)//UNIT
                                {
                                    var USU_sd_errmsg=USU_errormsg_arr[21].EMC_DATA.replace('[UNIT NO]',$('#USU_lb_unitno').val());
                                }
                                else if(USU_flex_flag==9)//ROOM TYPE WITH UNIT
                                {
                                    var USU_sd_errmsg=USU_errormsg_arr[32].EMC_DATA.replace('[ROOM TYPE]',$('#USU_lb_roomtyps').val());
                                }
                                else if(USU_flex_flag==5)//ROOM TYPE
                                {
                                    var USU_sd_errmsg=USU_errormsg_arr[46].EMC_DATA;
                                }
                                else if(USU_flex_flag==8)//STAMP TYPE
                                {
                                    var USU_sd_errmsg=USU_errormsg_arr[47].EMC_DATA;
                                }
                                $('#USU_headermsg').removeClass('srctitle');
                                $('#USU_headermsg').addClass('errormsg');
                                $('#USU_headermsg').text(USU_sd_errmsg).show();
                                $('#USU_pdf_btn').hide();
                            }
                        }
                        else{
                            $('#USU_div_flex').hide();
                            $('#USU_pdf_btn').hide();
                            var USU_unit_optionvalues=[];
                            USU_unit_optionvalues=USU_response_flex.USU_loaddata_searchby;
                            if($('#USU_lb_searchby').val()==7)
                                USU_glb_unitno_arr=USU_unit_optionvalues;
                            if(USU_unit_optionvalues!='')
                            {
                                var USU_unit_options='<option>SELECT</option>';
                                for(var i = 0; i < USU_unit_optionvalues.length; i++)
                                {
                                    USU_unit_options += '<option value="' + USU_unit_optionvalues[i] + '">' + USU_unit_optionvalues[i] + '</option>';
                                }
                                if($('#USU_lb_searchby').val()==1){//INVENTORY CARD
                                    $('#USU_lb_cardno').html(USU_unit_options);
                                    $('#USU_lb_cardno').val('SELECT');
                                    $('#USU_lbl_errmsg_cardno').text('');
                                }
                                else{
                                    $('#USU_lb_roomtyps').html(USU_unit_options);
                                    $('#USU_lb_roomtyps').val('SELECT');
                                }
                            }
                            else{
                                if($('#USU_lb_searchby').val()==1){//INVENTORY CARD
                                    $('#USU_lb_unitno').val('SELECT');
                                }
                                $('#USU_cardno,#USU_cardtype').hide();
                                $('#USU_form_unitupdate').find('input:text').val('');
                                $('#USU_cardno').find('select').val('SELECT');
                            }
                        }
                        var USU_parentfunc =USU_response_flex.USU_parentfunc_obj;
                        if(USU_parentfunc=='USU_parent_updation')
                        {
                            if(USU_flex_flag==5)//ROOM TYPE
                                var USU_replace_errmsg=USU_errormsg_arr[44].EMC_DATA;
                            else if(USU_flex_flag==8)//STAMP TYPE
                                var USU_replace_errmsg=USU_errormsg_arr[45].EMC_DATA;
                            else
                                var USU_replace_errmsg=USU_errormsg_arr[38].EMC_DATA.replace('[UNITNO]',USU_obj_rowvalue.USU_tr_first);
                            show_msgbox("UNIT SEARCH/UPDATE",USU_replace_errmsg,'success',false);
                        }
                    }
                    else{
                        show_msgbox("UNIT SEARCH/UPDATE",USU_errormsg_arr[48].EMC_DATA,'error',false);
                    }
                }
            }
        // HIGHLIGHT SELECTED ROW
        // CLICK FUNCTION FOR EDIT BUTTON
            $(document).on('click','#USU_tble_htmltable tr td .USU_class_flex',function(event){
                event.stopPropagation();
                event.preventDefault();
                event.stopImmediatePropagation();
                $('#USU_tble_htmltable tr').removeClass('row_selected');
                $(this).closest('tr').addClass('row_selected');
                $('#USU_div_updateform').hide();
                USU_flag_updbtn=0;
                USU_flag_enddate=1;
                USU_flag_roomtype=1;
                $('#USU_btn_search').attr("disabled", "disabled");
                $('#USU_btn_update').attr("disabled", "disabled");
                $('#USU_tble_update_reset').hide();
                $('#USU_tble_update').empty();
                var USU_selectrowid = this.id;
                var splitteddata=USU_selectrowid.split('_');
                var USU_dataid=splitteddata[0];
                var USU_id_attr=splitteddata[1];
                editrowid=USU_id_attr;
                for(var i=0;i<USU_flex_arr.length;i++){
                    if(USU_id_attr==USU_flex_arr[i][0]){
                        var tds = USU_flex_arr[i];
                    }
                }
                for(var j=0;j<tds.length;j++){
                    if(tds[j]==null){
                        tds[j]='';
                    }
                    else{
                        tds[j]=tds[j];
                    }
                }
                USU_obj_rowvalue={"USU_tr_first":tds[1],"USU_tr_second":tds[2],"USU_tr_third":tds[3],"USU_tr_four":tds[4],"USU_tr_five":tds[5],"USU_tr_six":tds[6],"USU_tr_seven":tds[7],"USU_tr_eight":tds[8],"USU_tr_nine":tds[9],"USU_tr_ten":tds[10],"USU_tr_eleven":tds[11],"USU_tr_twelve":tds[12],"USU_tr_thirteen":tds[13]};
                var USU_upd_tr='';
                var USU_lb_selectoption_unit=$('#USU_lb_searchby').val();
                var USU_unitid=USU_selectrowid;
                if((USU_lb_selectoption_unit==3)||(USU_lb_selectoption_unit==4)||(USU_lb_selectoption_unit==6)||(USU_lb_selectoption_unit==7))
                {
                    USU_upd_tr +='<div id="USU_updateform" style="padding-top:20px"> <div class="form-group" id="USU_unitno"> <label class="col-sm-2">UNIT NUMBER <em>*</em></label> <div class="col-sm-2"><input type="text" value="'+tds[1]+'" name="USU_tb_unitno" id="USU_tb_unitno" maxlength=4 class="USU_class_title_nums USU_class_updvalidation numonlyzero form-control" placeholder="Unit Number"></div> <div class="col-sm-4"> <label id="USU_lbl_alreadyexists" class="errormsg errpadding"></label> </div> </div> <div class="form-group" id="USU_startdate"> <label class="col-sm-2">START DATE <em>*</em></label> <div class="col-sm-2"> <div class="input-group addon"> <input value="'+tds[2]+'" type="text" name="USU_db_startdate_update" id="USU_db_startdate_update" class="USU_class_updvalidation form-control" placeholder="Start Date"/> <label for="USU_db_startdate_update" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label> </div> </div> </div> <div class="form-group" id="USU_enddate"> <label class="col-sm-2">END DATE <em>*</em></label> <div class="col-sm-2"> <div class="input-group addon"> <input value="'+tds[3]+'" type="text" name="USU_db_enddate_update" id="USU_db_enddate_update" class="USU_class_updvalidation form-control" placeholder="End Date"/> <label for="USU_db_enddate_update" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label> </div> </div> <div class="col-sm-2"> <div class="checkbox"> <label id="USU_lbl_obsolete"><input id ="USU_cb_obsolete" type="checkbox" name="USU_cb_obsolete" class="USU_class_obsolete USU_class_updvalidation" disabled>OBSOLETE</label> </div> </div> <div class="col-sm-4 errpadding errormsg" id="USU_lbl_obsolete_errmsg"> </div> </div> <div class="form-group" id="USU_unitrent"> <label class="col-sm-2">UNIT RENTAL <em>*</em></label> <div class="col-sm-2"><input value="'+tds[6]+'" id= "USU_tb_unitreltal" type = "text" name="USU_tb_unitreltal" maxlength=4 class="numonly USU_class_title_nums USU_class_updvalidation form-control" placeholder="Unit Rental"></div> </div> <div class="form-group" id="USU_unitdepo"> <label class="col-sm-2">UNIT DEPOSIT </label> <div class="col-sm-2"><input value="'+tds[7]+'" id="USU_tb_unitdeposit" type="text" name = "USU_tb_unitdeposit" maxlength=5 class="numonly USU_class_title_nums USU_class_updvalidation form-control" placeholder="Unit Deposit"></div> </div> <div class="form-group" id="USU_accntnumber"> <label class="col-sm-2">ACCOUNT NUMBER </label> <div class="col-sm-2"><input value="'+tds[8]+'" id ="USU_tb_accnoid" type="USU_tb_accnoid" name="USU_tb_accnoid" placeholder="Account Number" maxlength="15" class="numonlyzero USU_class_updvalidation USU_class_title_nums form-control"/></div> </div> <div class="form-group" id="USU_accntname"> <label class="col-sm-2">ACCOUNT NAME </label> <div class="col-sm-3"><input id="USU_tb_accname" type="text" name="USU_tb_accname" value="'+tds[9]+'" maxlength=25 class="uppercase USU_class_updvalidation form-control" placeholder="Account Name"/></div> </div> <div class="form-group" id="USU_bankcode"> <label class="col-sm-2">BANK CODE</label> <div class="col-sm-2"><input id = "USU_tb_bankcodeid" type="text" name="USU_tb_bankcodeid"  maxlength=5 value="'+tds[10]+'" class="numonlyzero USU_class_title_nums USU_class_updvalidation form-control" placeholder="Bank Code"/></div> </div> <div class="form-group" id="USU_branchcode"> <label class="col-sm-2">BRANCH CODE</label> <div class="col-sm-2"><input id ="USU_tb_branchcode" type="text" name="USU_tb_branchcode" value="'+tds[11]+'" maxlength=5 class="numonlyzero USU_class_title_nums USU_class_updvalidation form-control" placeholder="Branch Code"/></div> </div> <div class="form-group" id="USU_bankaddress"> <label class="col-sm-2">BANK ADDRESS</label> <div class="col-sm-4"><textarea id="USU_tb_bankaddr" name="USU_tb_bankaddr" placeholder="Bank Address" class="USU_class_updvalidation form-control" style="height: 114px" rows="5">'+tds[12]+'</textarea></div> </div> <div class="form-group" id="USU_comments"> <label class="col-sm-2">COMMENTS</label> <div class="col-sm-4"><textarea id="USU_ta_comments" name="USU_ta_comments" placeholder="Comments" class="USU_class_updvalidation form-control" style="height: 114px" rows="5">'+tds[13]+'</textarea></div> </div> <div class="form-group" id="USU_nonEI"> <label class="col-sm-2">EI/NON_EI</label> <div class="radio"> <label><input type="checkbox" name="USU_cb_nonei" id ="USU_cb_nonei" class="USU_class_updvalidation"></label> </div> </div> </div>';
                    $(USU_upd_tr).appendTo($("#USU_tble_update"));
                    $("#USU_db_startdate_update").datepicker({dateFormat: "dd-mm-yy",changeYear:true,changeMonth:true,maxDate:'+2Y',
                        onSelect: function(date) {
                            if((parseInt($('#USU_tb_unitno').val())==0)||($('#USU_tb_unitno').val()=='')||($('#USU_db_startdate_update').val()=='')||($('#USU_db_enddate_update').val()=='')||(parseInt($('#USU_tb_unitreltal').val())=='')||($('#USU_tb_unitreltal').val()=='')||($("#USU_tb_unitno").val().length<4)||(($('#USU_tb_unitno').val()==USU_obj_rowvalue.USU_tr_first)&&($('#USU_db_startdate_update').val()==USU_obj_rowvalue.USU_tr_second)&&($('#USU_db_enddate_update').val()==USU_obj_rowvalue.USU_tr_third)&&($('#USU_tb_unitreltal').val()==USU_obj_rowvalue.USU_tr_six)&&($('#USU_tb_unitdeposit').val()==USU_obj_rowvalue.USU_tr_seven)&&($('#USU_tb_accnoid').val()==USU_obj_rowvalue.USU_tr_eight)&&(($('#USU_tb_accname').val()).trim()==USU_obj_rowvalue.USU_tr_nine)&&($('#USU_tb_bankcodeid').val()==USU_obj_rowvalue.USU_tr_ten)&&($('#USU_tb_branchcode').val()==USU_obj_rowvalue.USU_tr_eleven)&&(($('#USU_tb_bankaddr').val()).trim()==USU_obj_rowvalue.USU_tr_twelve)&&(($('#USU_ta_comments').val()).trim()==USU_obj_rowvalue.USU_tr_thirteen))){
                                $("#USU_btn_update").attr("disabled","disabled");
                            }
                            else{
                                $('#USU_btn_update').removeAttr("disabled", "disabled");
                            }
                        }
                    });
                    $("#USU_db_enddate_update").datepicker({dateFormat: "dd-mm-yy" ,changeYear:true,changeMonth:true,
                        onSelect: function(date) {
                            if((parseInt($('#USU_tb_unitno').val())==0)||($('#USU_tb_unitno').val()=='')||($('#USU_db_startdate_update').val()=='')||($('#USU_db_enddate_update').val()=='')||(parseInt($('#USU_tb_unitreltal').val())=='')||($('#USU_tb_unitreltal').val()=='')||($("#USU_tb_unitno").val().length<4)||(($('#USU_tb_unitno').val()==USU_obj_rowvalue.USU_tr_first)&&($('#USU_db_startdate_update').val()==USU_obj_rowvalue.USU_tr_second)&&($('#USU_db_enddate_update').val()==USU_obj_rowvalue.USU_tr_third)&&($('#USU_tb_unitreltal').val()==USU_obj_rowvalue.USU_tr_six)&&($('#USU_tb_unitdeposit').val()==USU_obj_rowvalue.USU_tr_seven)&&($('#USU_tb_accnoid').val()==USU_obj_rowvalue.USU_tr_eight)&&(($('#USU_tb_accname').val()).trim()==USU_obj_rowvalue.USU_tr_nine)&&($('#USU_tb_bankcodeid').val()==USU_obj_rowvalue.USU_tr_ten)&&($('#USU_tb_branchcode').val()==USU_obj_rowvalue.USU_tr_eleven)&&(($('#USU_tb_bankaddr').val()).trim()==USU_obj_rowvalue.USU_tr_twelve)&&(($('#USU_ta_comments').val()).trim()==USU_obj_rowvalue.USU_tr_thirteen))){
                                $("#USU_btn_update").attr("disabled","disabled");
                            }
                            else{
                                $('#USU_btn_update').removeAttr("disabled", "disabled");
                            }
                        }
                    });
                    var USU_unitenddate = new Date( Date.parse( USU_FormTableDateFormat(tds[3])) );
                    var USU_new_date=USU_unitenddate.getDate();
                    var USU_new_month = USU_unitenddate.getMonth();
                    var USU_enddate_year=USU_unitenddate.getFullYear()+2;
                    var USU_enddate_unit =  new Date(USU_enddate_year,USU_new_month,USU_new_date);
                    $('#USU_db_enddate_update').datepicker("option","maxDate",USU_enddate_unit);
                    if(tds[8]!='')
                        $('#USU_tb_accnoid').attr("size",tds[8].length+1);
                    if(tds[9]!='')
                        $('#USU_tb_accname').attr("size",tds[9].length+3);
                    if(tds[12]!='')
                        $('#USU_tb_bankaddr').attr("size",tds[12].length+2);
                    USU_flag_roomtype=1;USU_flag_access=1;
                    $(".preloader").show();//CHECKING UNIT NO IF TRANSACTION IS THERE
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_AlreadyExists',
                        data: {'inventory_unitno':$('#USU_tb_unitno').val(),'typeofcard':'','flag_card_unitno':'USU_flag_transac_check_unitno','USU_parent_func':''},
                        success: function(existdata) {
                            var exist_data=JSON.parse(existdata);
                            USU_success_unitno_trans(exist_data);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    USU_flag_unitno=1;
                    if(tds[5]=='X')
                        $('#USU_cb_nonei').prop('checked',true);
                    var USU_obsolete=tds[4];
                    var USU_startdate_val=tds[2];
                    if(tds[4]=='X')
                        $('#USU_cb_obsolete').prop('checked',true);
                    else if(tds[4]==''){
                        $("#USU_cb_obsolete").hide();//SET MAX DATE FOR SDATE
                        $("#USU_lbl_obsolete").hide();
                    }//SET MIN DATE FOR EDATE
                    var USU_startdate = new Date( Date.parse( USU_FormTableDateFormat(USU_startdate_val)) );
                    USU_startdate.setDate( USU_startdate.getDate());
                    var USU_newsDate = USU_startdate.toDateString();
                    USU_newsDate = new Date( Date.parse( USU_newsDate ) );
                    if(USU_startdate.getMonth()==0)
                        var USU_month = 11;
                    else
                        var USU_month = (USU_startdate.getMonth() - 1) % 12;
                    if(USU_startdate.getMonth()==0)
                        var USU_startdate_year=USU_startdate.getFullYear()-1;
                    else
                        var USU_startdate_year=USU_startdate.getFullYear();
                    var USU_arr={0:[31,31],1:[31,28],2:[28,31],3:[31,30],4:[30,31],5:[31,30],6:[30,31],7:[31,31],8:[31,30],9:[30,31],10:[31,30],11:[30,31]};
                    var USU_date=USU_startdate.getDate();
                    if(USU_date!='Invalid Date'){
                        var USU_year=USU_startdate.getFullYear();
                        var USU_leapyear=USU_year%4;
                        if(USU_leapyear==0){
                            USU_arr[2][0]=29;
                            USU_arr[1][1]=29;
                        }
                        if(USU_arr[USU_month][0]==USU_startdate.getDate())
                            var USU_date=USU_arr[USU_month][1];
                    }
                    var USU_enddate_unit =  new Date(USU_startdate_year,USU_month,USU_date);
                    $('#USU_db_startdate_update').datepicker("option","minDate",USU_enddate_unit);
                    var  USU_enddate_change = new Date(Date.parse(USU_FormTableDateFormat(USU_startdate_val)));
                    USU_enddate_change.setDate( USU_enddate_change.getDate()+1);
                    if((USU_obsolete=='X')&&(new Date(Date.parse(new Date()))<USU_enddate_change)){
                        $('#USU_cb_obsolete').removeAttr("disabled");
                        var USU_obsolete_upd='X';
                    }
                    else if((USU_obsolete=='X')&&(new Date( Date.parse(new Date()))>USU_enddate_change)){
                        $('#USU_cb_obsolete').attr("disabled","disabled");
                        var USU_obsolete_upd='X';
                    }
                }
                else if(USU_lb_selectoption_unit==5)//ROOM TYPE
                {
                    USU_upd_tr +='<tr><td style="width:160px"><label>ROOM TYPE</label></td><td style="width:350px"><input id ="USU_tb_sep_roomtype" value="'+tds[1]+'" type="text" name="USU_tb_sep_roomtype" maxlength=30 class="general USU_class_sep_type USU_class_updvalidation"></td><td><label id="USU_lbl_roomstamp_errmsg" class="errormsg"></label></td></tr>';
                    $(USU_upd_tr).appendTo($("#USU_tble_update"));
                }
                else if(USU_lb_selectoption_unit==8)//STAMP TYPE
                {
                    USU_upd_tr +='<tr><td style="width:160px">STAMPDUTY TYPE</td><td style="width:200px"><input id ="USU_tb_sep_stamptype" type="text" value="'+tds[1]+'" name="USU_tb_sep_stamptype" class="alphaonly USU_class_title_alpha USU_class_sep_type USU_class_updvalidation" maxlength=12></td><td><label id="USU_lbl_roomstamp_errmsg" class="errormsg"></label></td></tr>';
                    $(USU_upd_tr).appendTo($("#USU_tble_update"));
                }
                else if((USU_lb_selectoption_unit==2)||(USU_lb_selectoption_unit==1)||(USU_lb_selectoption_unit==9)||(USU_lb_selectoption_unit==7)){
                    USU_upd_tr +='<div id="USU_updateform" style="padding-top: 20px"> <div class="form-group" id="USU_unitno"> <label class="col-sm-2">UNIT NUMBER <em>*</em></label> <div class="col-sm-2"><input value="'+tds[1]+'" type="text" id="USU_tb_accunitno" name="USU_tb_accunitno" class="rdonly USU_class_updvalidation form-control" readonly placeholder="Unit Number"></div> </div> <div class="form-group" id="USU_accesscard"> <label class="col-sm-2">ACCESS CARD </label> <div class="col-sm-2"><input value="'+tds[2]+'" id ="USU_tb_access" type="text" name="USU_tb_access" maxlength=7 class="numonly USU_class_title_nums USU_class_updvalidation form-control" placeholder="Access Card"></div> <div class="col-sm-1"> <div class="checkbox"> <label id="USU_lbl_lost" hidden><input type="checkbox" id="USU_cb_lost" name="USU_cb_lost" class="USU_class_updvalidation" hidden>LOST</label> </div> </div> <div class="col-sm-2"> <div class="checkbox"> <label id="USU_lbl_inventory" hidden><input type="checkbox" id="USU_cb_inventory" name="USU_cb_inventory" class="USU_class_updvalidation" hidden>INVENTORY</label> </div> </div> <div class="col-sm-3 errpadding errormsg" id="USU_lbl_alreadyexists" class="errormsg"> </div> </div> <div class="form-group" id="USU_roomtype"> <label class="col-sm-2">ROOM TYPE </label> <div class="col-sm-3"><select id="USU_lb_roomtype" name="USU_lb_roomtype" value="'+tds[6]+'" class="USU_class_updvalidation form-control"><option>SELECT</option></select> </div> <div class="col-sm-4 errpadding errormsg" id="USU_lbl_alreadyexists_roomtype" class="errormsg"> </div> </div> <div class="form-group" id="USU_stampdutydate"> <label class="col-sm-2">STAMP DUTY DATE </label> <div class="col-sm-2"> <div class="input-group addon"> <input id = "USU_db_stampdate" type="text" name="USU_db_stampdate" value="'+tds[7]+'" class="USU_class_updvalidation datenonmandtry form-control" placeholder="Stamp Duty Date"/> <label for="USU_db_stampdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label> </div> </div> </div> <div class="form-group" id="USU_stamptype"> <label class="col-sm-2">STAMP DUTY TYPE </label> <div class="col-sm-3"><select id="USU_lb_stamptype" name="USU_lb_stamptype" value="'+tds[8]+'" class="USU_class_updvalidation datenonmandtry form-control"><option>SELECT</option></select> </div> </div> <div class="form-group" id="USU_stampamount"> <label class="col-sm-2">STAMP DUTY AMOUNT </label> <div class="col-sm-2"><input type="text" name="USU_tb_stampamt" value="'+tds[9]+'" id="USU_tb_stampamt" maxlength=4 class ="amtonly USU_class_title_nums USU_class_updvalidation form-control" placeholder="Stamp Duty Amount"></div> </div> <div class="form-group" id="USU_comments"> <label class="col-sm-2">COMMENTS</label> <div class="col-sm-4"><textarea placeholder="Comments" id="USU_ta_accesscomment" name="USU_ta_accesscomment" class="USU_class_updvalidation USU_class_ta_cmts form-control" style="height: 114px" rows="5">'+tds[10]+'</textarea></div> </div>';
                    $(USU_upd_tr).appendTo($("#USU_tble_update"));
                    $(".preloader").show();
                    $("#USU_div_updateform").hide();
                    if((tds[2]=='')||(USU_lb_selectoption_unit!=1)){
                        $('#USU_lbl_lost').hide();
                        $('#USU_cb_lost').hide();
                        $('#USU_lbl_inventory').hide();
                        $('#USU_cb_inventory').hide();
                    }
                    if(tds[2]==''){
                        $('#USU_tb_access').prop("readonly", true);
                        $('#USU_tb_access').addClass("rdonly")}
                    if(tds[4]=='X'){
                        $('#USU_cb_inventory').prop('checked',true);
                        $('#USU_cb_lost').prop("checked", false);
                        $('#USU_cb_lost').removeAttr("disabled");
                    }
                    if(tds[5]=='X'){
                        $('#USU_cb_lost').prop('checked',true);
                        $('#USU_cb_inventory').prop("checked", false)
                    }
                    USU_flag_unitno=1;USU_flag_access=1;
                    USU_accesscard_no=$('#USU_tb_access').val();
                    if(((tds[4]=='X')&&(tds[2]!=''))||((tds[5]=='X')&&(tds[2]!=''))){
                        $('#USU_lbl_lost').show();
                        $('#USU_cb_lost').show();
                        $('#USU_lbl_inventory').show();
                        $('#USU_cb_inventory').show();
                    }
                    //LOAD STAMPTYPE,LOAD ROOMTYPE
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_roomstamp_unitno',
                        data: {'unitstamp_unitno':$("#USU_tb_accunitno").val()},
                        success: function(roomstampdata) {
                            var roomstamp_data=JSON.parse(roomstampdata);
                            USU_success_stamp_room(roomstamp_data);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    if(tds[6]==''){
                        $('#USU_lb_roomtype').val('SELECT');
                    }
                    if(tds[8]==''){
                        $('#USU_lb_stamptype').val('SELECT');
                    }
                    if(tds[7]==''){
                        $('#USU_db_stampdate').addClass("rdonly");
                    }
                    if(tds[9]==''){
                        $('#USU_tb_stampamt').addClass("rdonly");
                    }
                }
                $('#USU_tble_update_reset').show();
                // VALIDATION FOR NUMBERS,ALPHABETS & AMOUNT FIELDS
                $('textarea').autogrow({onInitialize: true});
                $(".numonlyzero").doValidation({rule:'numbersonly',prop:{leadzero:true}});
                $(".general").doValidation({rule:'general',prop:{whitespace:true,autosize:true}});
                $(".numonly").doValidation({rule:'numbersonly'});
//                $(".alphaonly").doValidation({rule:'alphanumeric'});
                $("#USU_tb_stampamt").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
                $("#USU_db_stampdate").datepicker({dateFormat: "dd-mm-yy" ,changeYear: true,changeMonth: true,
                    onSelect: function(date) {
                        if(($("#USU_lb_roomtype").val()==USU_obj_rowvalue.USU_tr_six)&&($("#USU_lb_stamptype").val()==USU_obj_rowvalue.USU_tr_eight)&&($("#USU_db_stampdate").val()==USU_obj_rowvalue.USU_tr_seven)&&($("#USU_tb_stampamt").val()==USU_obj_rowvalue.USU_tr_nine)&&(($("#USU_ta_accesscomment").val()).trim()==USU_obj_rowvalue.USU_tr_ten)){
                            $("#USU_btn_update").attr("disabled","disabled");
                        }
                        else{
                            $('#USU_btn_update').removeAttr("disabled", "disabled");
                        }
                    }
                });
                $(".USU_class_title_nums").prop("title",USU_errormsg_arr[1].EMC_DATA);
                $(".USU_class_title_alpha").prop("title",USU_errormsg_arr[0].EMC_DATA);
                $(".USU_class_ta_cmts").doValidation({rule:'general',prop:{uppercase:false}});
                $(".uppercase").Setcase({caseValue : 'upper'});
                function USU_success_unitno_trans(USU_response_unitno_trans){
                    $(".preloader").hide();
                    $("#USU_div_updateform").show();
                    var  USU_startdate_change = new Date(Date.parse(USU_response_unitno_trans.USU_objarr_custexpense[0]));
                    USU_startdate_change.setDate( USU_startdate_change.getDate()  ); //+ 1
                    var USU_newDate_start = USU_startdate_change.toDateString();
                    USU_newDate_start = new Date( Date.parse( USU_newDate_start ) );
                    $('#USU_db_startdate_update').datepicker("option","maxDate",USU_newDate_start);
                    var  USU_enddate_change = new Date(Date.parse(USU_response_unitno_trans.USU_objarr_custexpense[1]));
                    USU_enddate_change.setDate( USU_enddate_change.getDate()  ); //+ 1
                    var USU_newDate_end = USU_enddate_change.toDateString();
                    USU_newDate_end = new Date( Date.parse( USU_newDate_end ) );
                    $('#USU_db_enddate_update').datepicker("option","minDate",USU_newDate_end);
                    USU_glb_unitno_arr=USU_response_unitno_trans.USU_obj_loadunitno;
                    if(USU_response_unitno_trans.USU_objarr_custexpense[1]!=USU_FormTableDateFormat(USU_obj_rowvalue.USU_tr_second)){
                        $('#USU_tb_unitno').prop('readonly', true);
                        $('#USU_tb_unitno').addClass('rdonly');
                    }
                    // CHECK TRANSACTION FOR SDATE,IF NO TRANS MEANS NOT SET MIN DATE
                }
                // SUCCESS FUNCTION FOR LOAD LISTBOX FOR STAMP & ROOM TYPE
                function USU_success_stamp_room(USU_response_stamp_room){
                    var USU_stamp_options_arr=USU_response_stamp_room.USU_stamptype;
                    var USU_room_options_arr=USU_response_stamp_room.USU_roomtype;
                    var USU_stamp_options ='<option>SELECT</option>';
                    for (var i = 0; i < USU_stamp_options_arr.length; i++)
                    {
                        USU_stamp_options += '<option value="' + USU_stamp_options_arr[i] + '">'+ USU_stamp_options_arr[i]+' </option>';
                    }
                    if(tds[8]!='')
                        USU_stamp_options +='<option value="'+tds[8]+ '">'+ tds[8]+' </option>';
                    var USU_room_options ='<option>SELECT</option>';
                    for (var i = 0; i < USU_room_options_arr.length; i++)
                    {
                        USU_room_options += '<option value="' + USU_room_options_arr[i] + '">'+ USU_room_options_arr[i]+' </option>';
                    }
                    if(tds[6]!='')
                        USU_room_options +='<option value="'+tds[6]+ '">'+ tds[6]+' </option>';
                    $('#USU_lb_roomtype').html(USU_room_options);
                    $('#USU_lb_stamptype').html(USU_stamp_options);
                    if(tds[6]!='')
                        $('#USU_lb_roomtype').val(tds[6]);
                    if(tds[8]!='')
                        $('#USU_lb_stamptype').val(tds[8]);
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_AlreadyExists',
                        data: {'inventory_unitno':USU_obj_rowvalue.USU_tr_second,'typeofcard':'','flag_card_unitno':'USU_transac_check_accesscard','USU_parent_func':''},
                        success: function(existdata) {
                            var exist_data=JSON.parse(existdata);
                            USU_success_alreadyexists(exist_data);
                            $("#USU_div_updateform").show();
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // CHANGE FUNCTION FOR END DATE VALIDATION
//            $(document).on('change','#USU_db_startdate_update',function(){
//                var USU_sdate_onchange=new Date(Date.parse(USU_FormTableDateFormat($('#USU_db_startdate_update').val())));
//                var USU_edate_onchange=new Date(Date.parse(USU_FormTableDateFormat($('#USU_db_enddate_update').val())));
//                USU_sdate_onchange.setDate( USU_sdate_onchange.getDate()+1);
//                var USU_newDate = USU_sdate_onchange.toDateString();
//                USU_newDate = new Date( Date.parse( USU_newDate ) );
//                $('#USU_db_enddate_update').datepicker("option","minDate",USU_newDate);
//            });
        // CHANGE FUNCTION FOR END DATE VALIDATION
            $(document).on('change','#USU_db_enddate_update',function(){
                var USU_enddate_oldvalue=new Date(Date.parse(USU_FormTableDateFormat(USU_obj_rowvalue.USU_tr_third)));
                var USU_enddate_onchange=new Date(Date.parse(USU_FormTableDateFormat($('#USU_db_enddate_update').val())));
                if((USU_enddate_onchange>new Date(Date.parse(new Date())))&&(USU_obj_rowvalue.USU_tr_four=='X')){
                    $('#USU_cb_obsolete').removeAttr("disabled");
                }
                else if((USU_enddate_onchange<new Date(Date.parse(new Date())))&&(USU_obj_rowvalue.USU_tr_four=='X')){
                    $('#USU_cb_obsolete').attr("disabled","disabled");
                    $('#USU_cb_obsolete').prop("checked",true);
                }
            });
        // CLICK EVENT FOR INLINE EDIT FOR STAMP TYPE AND ROOM TYPE
            $(document).on('click','.data_room_stamp',function(){
                if(previous_id!=undefined){
                    $('#'+previous_id).replaceWith("<td class='data_room_stamp' id='"+rid+'_'+previous_id+"' >"+tdvalue+"</td>");
                }
                var cid = $(this).attr('id');
                var splittedcid=cid.split('_');
                var rowcid=splittedcid[0];
                var primcid=splittedcid[1];
                rid=rowcid;
                previous_id=primcid;
                editrowid=primcid;
                tdvalue=$(this).text();
                for(var i=0;i<USU_flex_arr.length;i++){
                    if(primcid==USU_flex_arr[i][0]){
                        var tds = USU_flex_arr[i];
                    }
                }
                for(var j=0;j<tds.length;j++){
                    if(tds[j]==null){
                        tds[j]='';
                    }
                    else{
                        tds[j]=tds[j];
                    }
                }
                USU_obj_rowvalue={"USU_tr_first":tds[0],"USU_tr_second":tds[1],"USU_tr_third":tds[2],"USU_tr_four":tds[3],"USU_tr_five":tds[4],"USU_tr_six":tds[5],"USU_tr_seven":tds[6],"USU_tr_eight":tds[7],"USU_tr_nine":tds[8],"USU_tr_ten":tds[9],"USU_tr_eleven":tds[10],"USU_tr_twelve":tds[11],"USU_tr_thirteen":tds[12]};
                if($('#USU_lb_searchby').val()==5)//ROOM TYPE
                {
                    $('#'+cid).replaceWith('<td class="new" id="'+previous_id+'"><input id ="USU_tb_sep_roomtype" type="text" name="USU_tb_sep_roomtype" maxlength=30 class="form-control uppercase USU_class_sep_type USU_class_updvalidation" value="'+tdvalue+'">');
                }
                else if($('#USU_lb_searchby').val()==8)//STAMP TYPE
                {
                    $('#'+cid).replaceWith('<td class="new" id="'+previous_id+'"><input id ="USU_tb_sep_stamptype" type="text" name="USU_tb_sep_stamptype" maxlength=12 class="form-control alphaonly USU_class_title_alpha uppercase USU_class_sep_type USU_class_updvalidation" value="'+tdvalue+'">');
                }
                // VALIDATION
                $(".uppercase").Setcase({caseValue : 'upper'});
                $(".USU_class_title_alpha").prop("title",USU_errormsg_arr[0].EMC_DATA);
            });
            $(document).on("keyup",'.alphaonly',function() {
                if (this.value.match(/[^a-zA-Z\ ]/g)) {
                    this.value = this.value.replace(/[^a-zA-Z\ ]/g, '').toUpperCase();
                }
            });
        // CHANGE EVENT FOR ROOM TYPE,STAMP TYPE TEXTBOX
            $(document).on('change','.USU_class_sep_type',function(event){
                event.stopPropagation();
                event.preventDefault();
                event.stopImmediatePropagation();
                USU_flag_updbtn=0;
                if($('#USU_tb_sep_roomtype').val()!=undefined){
                    var USU_roomstamptype_val=$('#USU_tb_sep_roomtype').val();
                    var USU_parentfunc_already=5;
                }
                else if($('#USU_tb_sep_stamptype').val()!=undefined){
                    var USU_roomstamptype_val=$('#USU_tb_sep_stamptype').val();
                    var USU_parentfunc_already=8;
                }
                if((($('#USU_tb_sep_stamptype').val()==undefined)&&($('#USU_tb_sep_roomtype').val()!='')&&(($('#USU_tb_sep_roomtype').val()).trim()!=USU_obj_rowvalue.USU_tr_second))||(($('#USU_tb_sep_stamptype').val()!='')&&($('#USU_tb_sep_roomtype').val()==undefined)&&(($('#USU_tb_sep_stamptype').val()).trim()!=USU_obj_rowvalue.USU_tr_second))){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_AlreadyExists',
                        data: {'inventory_unitno':USU_roomstamptype_val,'typeofcard':'','flag_card_unitno':USU_parentfunc_already,'USU_parent_func':''},
                        success: function(existdata) {
                            var exist_data=JSON.parse(existdata);
                            USU_success_alreadyexists(exist_data);
                            if(USU_flag_updbtn==1){
                                $(".preloader").show();
                                Unit_search_Update();
                            }
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                if(($('#USU_tb_sep_roomtype').val()=='')||($('#USU_tb_sep_stamptype').val()=='')){
                    $("#USU_lbl_roomstamp_errmsg").text('');
                    $("input").removeClass('invalid');
                }
            });
        // SUCCESS FUNCTION FOR INVENTORY CARDS,ACCESS CARD,UNIT NO,ALREADY EXISTS FOR ROOMTYPE STAMP TYPE
            function USU_success_alreadyexists(USU_response_Cardnumbers){
                $(".preloader").hide();
                var USU_cardarray_fetch = [] ;
                var USU_card_unitno_roomstamp=USU_response_Cardnumbers.USU_flag_check;
                var USU_flag_roomstamp=USU_response_Cardnumbers.USU_truefalse_flag;
                USU_cardarray_fetch = USU_response_Cardnumbers.USU_loaddata_searchby;
                if(USU_card_unitno_roomstamp=='USU_transac_check_accesscard'){
                    USU_accesscard_transaction=USU_flag_roomstamp;
                    if(USU_accesscard_transaction=='false'){
                        $('#USU_cb_inventory').removeAttr("disabled");
                    }
                    else if((USU_accesscard_transaction=='true')&&(USU_obj_rowvalue.USU_tr_five=='X')){
                        $('#USU_cb_lost').attr("disabled", "disabled");
                        $('#USU_cb_inventory').attr("disabled", "disabled")
                    }
                }
                if(USU_card_unitno_roomstamp=='USU_flag_check_cardunitno')
                {
                    if(USU_cardarray_fetch.length == 0){
                        $('#USU_lbl_errmsg_cardno').text(USU_errormsg_arr[34].EMC_DATA);
                        $('#USU_stamperrdiv').show();
                        $('#USU_cardno').hide();
                    }
                    else{
                        $('#USU_stamperrdiv').hide();
                        $('#USU_lbl_errmsg_cardno').text('');
                        var USU_inventory_options ='<option>SELECT</option>';
                        for (var i = 0; i < USU_cardarray_fetch.length; i++)
                        {
                            USU_inventory_options += '<option value="' + USU_cardarray_fetch[i] + '">' + USU_cardarray_fetch[i] + '</option>';
                        }
                        $('#USU_lb_cardno').html(USU_inventory_options);
                        $('#USU_cardno').show();
                        $('#USU_lb_cardno').focus();
                    }
                }
                else
                {
                    if(USU_flag_roomstamp=='false')
                    {
                        $("input").removeClass('invalid');
                        if((USU_card_unitno_roomstamp==5)||(USU_card_unitno_roomstamp==8))
                        {
                            $("#USU_lbl_roomstamp_errmsg").text('');
                            USU_flag_updbtn=1;
                        }
                        else if(USU_card_unitno_roomstamp=='USU_flag_check_accesscard'){
                            $("#USU_lbl_alreadyexists").text('');
                            $('#USU_cb_inventory,#USU_cb_lost').prop('checked',false);
                            USU_flag_updbtn=1;
                            if(USU_obj_rowvalue.USU_tr_four=='X')
                                $('#USU_cb_inventory').prop('checked',true);
                            else if(USU_obj_rowvalue.USU_tr_five=='X')
                                $('#USU_cb_lost').prop('checked',true);
                            if((USU_accesscard_transaction=='true')&&(USU_obj_rowvalue.USU_tr_five=='X'))
                                $('#USU_cb_lost').attr("disabled", "disabled");
                            else if((USU_accesscard_transaction=='false')||(USU_obj_rowvalue.USU_tr_four=='X')){
                                $('#USU_cb_inventory').removeAttr("disabled");
                                $('#USU_cb_lost').removeAttr("disabled");
                            }
                        }
                        else if(USU_card_unitno_roomstamp=='USU_transac_check_roomtype'){
                            $("#USU_lbl_alreadyexists_roomtype").text('');
                            $("#USU_lb_roomtype").removeClass('invalid');
                            USU_flag_roomtype=1;
                        }
                    }
                    else if(USU_flag_roomstamp=='true'){
                        if(USU_card_unitno_roomstamp=='USU_flag_check_unitno')
                        {
                            $("#USU_lbl_alreadyexists").text(USU_errormsg_arr[8].EMC_DATA);
                            USU_flag_unitno=0;
                            $("#USU_tb_unitno").addClass('invalid');
                        }
                        else if(USU_card_unitno_roomstamp=='USU_flag_check_accesscard'){
                            USU_flag_access=0;
                            $("#USU_lbl_alreadyexists").text(USU_errormsg_arr[9].EMC_DATA);
                            $("#USU_tb_access").addClass('invalid');
                        }
                        else if(USU_card_unitno_roomstamp==5){
                            USU_flag_updbtn=0;
                            show_msgbox("UNIT SEARCH/UPDATE",USU_errormsg_arr[29].EMC_DATA,'error',false);
//                            $("#USU_lbl_roomstamp_errmsg").text(USU_errormsg_arr[29].EMC_DATA);
                            $("#USU_tb_sep_roomtype").addClass('invalid');
                        }
                        else if(USU_card_unitno_roomstamp==8){
                            USU_flag_updbtn=0;
                            show_msgbox("UNIT SEARCH/UPDATE",USU_errormsg_arr[37].EMC_DATA,'error',false);
//                            $("#USU_lbl_roomstamp_errmsg").text(USU_errormsg_arr[37].EMC_DATA);
                            $("#USU_tb_sep_stamptype").addClass('invalid');
                        }
                        else if(USU_card_unitno_roomstamp=='USU_transac_check_roomtype'){
                            $("#USU_lbl_alreadyexists_roomtype").text(USU_errormsg_arr[42].EMC_DATA);
                            $("#USU_lb_roomtype").addClass('invalid');
                            USU_flag_roomtype=0;
                        }
                    }
                    if((USU_flag_updbtn==1)&&(USU_flag_roomtype==1)&&(USU_flag_access==1)&&(USU_flag_unitno==1)&&(USU_flag_enddate==1)){
                        $("#USU_btn_update").removeAttr("disabled");
                    }
                    else{
                        $('#USU_btn_update').attr("disabled", "disabled")
                    }
                }
            }
            $(document).on('blur','#USU_tb_bankaddr',function(){
                return $(this).val().length < 251;
            });
        // VALIDATION FOR UNIT NO UPDATION
            $(document).on('blur','#USU_tb_unitno',function(){
                if(($("#USU_tb_unitno").val()==USU_obj_rowvalue.USU_tr_first)||($("#USU_tb_unitno").val().length==0))
                {
                    $("#USU_tb_unitno").removeClass('invalid');
                    $("#USU_lbl_alreadyexists").text('');
                }
                else if(($("#USU_tb_unitno").val().length<4)&&($("#USU_tb_unitno").val().length>0))
                {
                    $("#USU_tb_unitno").addClass('invalid');
                    $("#USU_lbl_alreadyexists").text(USU_errormsg_arr[6].EMC_DATA);
                }
                else if(($("#USU_tb_unitno").val().length>=4)&&($("#USU_tb_unitno").val()!=USU_obj_rowvalue.USU_tr_first )&&(parseInt($("#USU_tb_unitno").val())!=0)){
                    var USU_flag_unitnumber=1;
                    for(var i=0;i<=USU_glb_unitno_arr.length;i++){
                        if($("#USU_tb_unitno").val()==USU_glb_unitno_arr[i])
                        {
                            var USU_flag_unitnumber=0;
                            break;
                        }
                    }
                    if(USU_flag_unitnumber==0){
                        $("#USU_lbl_alreadyexists").text(USU_errormsg_arr[8].EMC_DATA);
                        USU_flag_unitno=0;
                        $("#USU_tb_unitno").addClass('invalid');
                    }
                    else
                    {
                        USU_flag_unitno=1;
                        $("#USU_tb_unitno").removeClass('invalid');
                        $("#USU_lbl_alreadyexists").text('');
                    }
                }
            });
        // CLICK FUNCTION FOR LOST AND INVENTORY  CHECKBOX
            $(document).on('click','#USU_cb_lost',function(){
                if($('#USU_cb_lost').is(":checked"))
                    $('#USU_cb_inventory').prop("checked", false);
                else
                    $('#USU_cb_inventory').prop("checked", true);
            });
            $(document).on('click','#USU_cb_inventory',function(){
                if ($('#USU_cb_inventory').is(":checked"))
                    $('#USU_cb_lost').prop("checked", false);
                else
                    $('#USU_cb_lost').prop("checked", true);
            });
        // VALIDATION FOR ACCESS CARD UPDATION
            $(document).on('blur','#USU_tb_access',function(){
                if($("#USU_tb_access").val()==USU_obj_rowvalue.USU_tr_second)
                    USU_flag_access=1;
                if(($("#USU_tb_access").val().length==0)&&(USU_accesscard_transaction==true)){
                    USU_flag_access=0;
                    $("#USU_lbl_alreadyexists").text(USU_errormsg_arr[41].EMC_DATA);
                    $("#USU_tb_access").addClass('invalid');}
                else if(($("#USU_tb_access").val().length==0)&&(USU_accesscard_transaction==false)){
                    $("#USU_lbl_alreadyexists").text('');
                    USU_flag_access=1;USU_flag_updbtn=1;
                    $('#USU_cb_lost').attr("disabled", "disabled");
                    $('#USU_cb_inventory').attr("disabled", "disabled");
                    $('#USU_cb_inventory').prop("checked", false);
                    $('#USU_cb_lost').prop("checked", false);
                }
                if((($("#USU_tb_access").val().length==0)&&(USU_accesscard_transaction==false))||(($("#USU_tb_access").val()==USU_obj_rowvalue.USU_tr_second)&&(USU_accesscard_transaction!=false))){
                    $("#USU_tb_access").removeClass('invalid');
                    $("#USU_lbl_alreadyexists").text('')}
                else if(($("#USU_tb_access").val().length<4)&&(USU_accesscard_transaction==false))
                {
                    $("#USU_tb_access").addClass('invalid');
                    USU_flag_access=0;
                    $("#USU_lbl_alreadyexists").text(USU_errormsg_arr[7]);
                }
                else if(($("#USU_tb_access").val().length>=4)&&(USU_obj_rowvalue.USU_tr_second!=$("#USU_tb_access").val())){
                    $(".preloader").show();
                    USU_flag_access=1;
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_AlreadyExists',
                        data: {'inventory_unitno':$("#USU_tb_access").val(),'typeofcard':'','flag_card_unitno':'USU_flag_check_accesscard','USU_parent_func':''},
                        success: function(existdata) {
                            var exist_data=JSON.parse(existdata);
                            USU_success_alreadyexists(exist_data);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // VALIDATION FOR ROOM TYPE UPDATION
            $(document).on('change','#USU_lb_roomtype',function(){
                if(($("#USU_lb_roomtype").val()=='SELECT')&&(USU_obj_rowvalue.USU_tr_six!='')){
                    USU_flag_roomtype=0;
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitcreate_url+'/USU_AlreadyExists',
                        data: {'inventory_unitno':USU_obj_rowvalue.USU_tr_second,'typeofcard':'','flag_card_unitno':'USU_transac_check_roomtype','USU_parent_func':''},
                        success: function(existdata) {
                            var exist_data=JSON.parse(existdata);
                            USU_success_alreadyexists(exist_data);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                else{
                    $("#USU_lbl_alreadyexists_roomtype").text('');
                    $("#USU_lb_roomtype").removeClass('invalid');
                    USU_flag_roomtype=1;
                }
            });
        // FUNCTION FOR UPDATION
            function Unit_search_Update(){
                if ($('#USU_cb_nonei').is(":checked"))
                    var USU_cb_nonei='X';
                else
                    var USU_cb_nonei='';
                if ($('#USU_cb_obsolete').is(":checked"))
                    var USU_cb_obsolete='X';
                else
                    var USU_cb_obsolete='';
                if ($('#USU_cb_inventory').is(":checked"))
                    var USU_cb_inventory='X';
                else
                    var USU_cb_inventory='';
                if ($('#USU_cb_lost').is(":checked"))
                    var USU_cb_lost='X';
                else
                    var USU_cb_lost='';
                var USU_dbstartdateupdate=$('#USU_db_startdate_update').val();
                if(USU_dbstartdateupdate==undefined){
                    USU_dbstartdateupdate='';
                }
                var USU_tbunitno=$('#USU_tb_unitno').val();
                if(USU_tbunitno==undefined){
                    USU_tbunitno='';
                }
                var USU_dbenddateupdate=$('#USU_db_enddate_update').val();
                if(USU_dbenddateupdate==undefined){
                    USU_dbenddateupdate='';
                }
                var USU_tbunitdeposit=$('#USU_tb_unitdeposit').val();
                if(USU_tbunitdeposit==undefined){
                    USU_tbunitdeposit='';
                }
                var USU_tbunitreltal=$('#USU_tb_unitreltal').val();
                if(USU_tbunitreltal==undefined){
                    USU_tbunitreltal='';
                }
                var USU_tbaccnoid=$('#USU_tb_accnoid').val();
                if(USU_tbaccnoid==undefined){
                    USU_tbaccnoid='';
                }
                var USU_tbaccname=$('#USU_tb_accname').val();
                if(USU_tbaccname==undefined){
                    USU_tbaccname='';
                }
                var USU_tbbankcodeid=$('#USU_tb_bankcodeid').val();
                if(USU_tbbankcodeid==undefined){
                    USU_tbbankcodeid='';
                }
                var USU_tbbranchcode=$('#USU_tb_branchcode').val();
                if(USU_tbbranchcode==undefined){
                    USU_tbbranchcode='';
                }
                var USU_tbbankaddr=$('#USU_tb_bankaddr').val();
                if(USU_tbbankaddr==undefined){
                    USU_tbbankaddr='';
                }
                var USU_tbseproomtype=$('#USU_tb_sep_roomtype').val();
                if(USU_tbseproomtype==undefined){
                    USU_tbseproomtype='';
                }
                var USU_tbsepstamptype=$('#USU_tb_sep_stamptype').val();
                if(USU_tbsepstamptype==undefined){
                    USU_tbsepstamptype='';
                }
                var USU_tacomments=$('#USU_ta_comments').val();
                if(USU_tacomments==undefined){
                    USU_tacomments='';
                }
                var USU_tbaccunitno=$('#USU_tb_accunitno').val();
                if(USU_tbaccunitno==undefined){
                    USU_tbaccunitno='';
                }
                var USU_lbstamptype=$('#USU_lb_stamptype').val();
                if(USU_lbstamptype==undefined){
                    USU_lbstamptype='';
                }
                var USU_lbroomtype=$('#USU_lb_roomtype').val();
                if(USU_lbroomtype==undefined){
                    USU_lbroomtype='';
                }
                var USU_tbstampamt=$('#USU_tb_stampamt').val();
                if(USU_tbstampamt==undefined){
                    USU_tbstampamt='';
                }
                var USU_dbstampdate=$('#USU_db_stampdate').val();
                if(USU_dbstampdate==undefined){
                    USU_dbstampdate='';
                }
                var USU_tbaccess=$('#USU_tb_access').val();
                if(USU_tbaccess==undefined){
                    USU_tbaccess='';
                }
                var USU_taaccesscomment=$('#USU_ta_accesscomment').val();
                if(USU_taaccesscomment==undefined){
                    USU_taaccesscomment='';
                }
                var USU_obj_flex={"USU_parent_updation":'USU_parent_updation',"USU_lb_searchby":$('#USU_lb_searchby').val(),"USU_tb_dutyamt_fromamt":$('#USU_tb_dutyamt_fromamt').val(),"USU_tb_dutyamt_toamt":$('#USU_tb_dutyamt_toamt').val(),"USU_tb_payment_fromamt":$('#USU_tb_payment_fromamt').val(),"USU_tb_payment_toamt":$('#USU_tb_payment_toamt').val(),"USU_db_fromdate":$('#USU_db_fromdate').val(),"USU_db_todate":$('#USU_db_todate').val(),"USU_lb_unitno":$('#USU_lb_unitno').val(),"USU_lb_roomtyps":$('#USU_lb_roomtyps').val(),"USU_lb_cardno":$('#USU_lb_cardno').val()};
                var USU_obj_formvalues={"USU_lb_selectoption_unit":$('#USU_lb_searchby').val(),"USU_radio_flex":editrowid,"USU_db_startdate_update":USU_dbstartdateupdate,"USU_tb_unitno":USU_tbunitno,"USU_db_enddate_update":USU_dbenddateupdate,"USU_tb_unitdeposit":USU_tbunitdeposit,"USU_hidden_obsolete":USU_cb_obsolete,"USU_tb_unitreltal":USU_tbunitreltal,"USU_tb_accnoid":USU_tbaccnoid,"USU_tb_accname":USU_tbaccname,"USU_tb_bankcodeid":USU_tbbankcodeid,"USU_tb_branchcode":USU_tbbranchcode,"USU_cb_nonei":USU_cb_nonei,"USU_tb_bankaddr":USU_tbbankaddr,"USU_tb_sep_roomtype":USU_tbseproomtype,"USU_tb_sep_stamptype":USU_tbsepstamptype,"USU_ta_comments":USU_tacomments,"USU_tb_accunitno":USU_tbaccunitno,"USU_lb_stamptype":USU_lbstamptype,"USU_lb_roomtype":USU_lbroomtype,"USU_tb_stampamt":USU_tbstampamt,"USU_db_stampdate":USU_dbstampdate,"USU_tb_access":USU_tbaccess,"USU_ta_accesscomment":USU_taaccesscomment,"USU_cb_lost":USU_cb_lost,"USU_cb_inventory":USU_cb_inventory,"USU_typeofCard":$('#USU_lb_typeofcard').val()};
                $.ajax({
                    type: "POST",
                    url: ctrl_unitcreate_url+'/USU_func_update',
                    data: {'USU_obj_formvalues':USU_obj_formvalues,'USU_obj_rowvalue':USU_obj_rowvalue,'USU_obj_flex':USU_obj_flex},
                    success: function(successdata) {
                        var success_data=JSON.parse(successdata);
                        USU_success_flex(success_data);
                        rid=undefined;
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("UNIT SEARCH/UPDATE",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            }
        // UPDATE BUTTON EVENT
            $(document).on('click','#USU_btn_update',function(event){
                event.stopPropagation();
                event.preventDefault();
                event.stopImmediatePropagation();
                $(".preloader").show();
                Unit_search_Update();
            });
        // FUNCTION FOR RESET
            $(document).on('click','#USU_btn_reset',function(){
                if($('#USU_lb_searchby').val()==1)
                    $('#USU_tb_access').val('');
                $('#USU_lbl_alreadyexists').text('');
                $("#USU_lbl_alreadyexists_roomtype").text('');
                $("#USU_lbl_roomstamp_errmsg").text('');
                $("#USU_lbl_obsolete_errmsg").text('');
                $('input:not(#UNIT_form_unitcreate,#UNIT_form_unitupdate,#USU_lb_searchby,#USU_tb_accunitno,#USU_tb_dutyamt_fromamt,#USU_tb_dutyamt_toamt,#USU_lb_cardno,#USU_db_fromdate,#USU_tb_payment_fromamt,#USU_db_todate,#USU_tb_payment_toamt,.USU_class_flex,[readonly],[disabled])')
                    .not(':button')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');
                $('#USU_lb_stamptype').val('SELECT');
                $('#USU_lb_roomtype').val('SELECT');
                $('input').removeClass('invalid');
                $("#USU_db_startdate_update").datepicker({dateFormat: "dd-mm-yy" ,changeYear:true,changeMonth:true,minDate:'-1M',maxDate:'+2Y' });
                $("#USU_db_enddate_update").datepicker({dateFormat: "dd-mm-yy" ,changeYear:true,changeMonth:true,maxDate:'+2Y' });
                $('#USU_lb_roomtype').removeClass('invalid');
                $('textarea').val('');//set default size for textarea , we can give id also
                $('textarea').height(114);
                $('#USU_btn_update').attr("disabled","disabled");
                $('#USU_cb_lost').attr("disabled", "disabled");
            });
        // BLUR FUNCTION FOR FORM VALIDATION FOR UPDATE BUTTON
            $(document).on('change','.USU_class_updvalidation',function(event){
                event.stopPropagation();
                event.preventDefault();
                event.stopImmediatePropagation();
                if(($('#USU_lb_searchby').val()==1)||($('#USU_lb_searchby').val()==2)||($('#USU_lb_searchby').val()==9)){
                    if($("#USU_tb_access").val().length==0){
                        $('#USU_cb_lost,#USU_cb_inventory').prop("checked", false);
                    }
                    if ($('#USU_cb_lost').is(":checked")){
                        var USU_cb_lost='X';
                    }
                    else{
                        var USU_cb_lost='';
                    }
                    if ($('#USU_cb_inventory').is(":checked")){
                        var USU_cb_inventory='X';
                    }
                    else{
                        var USU_cb_inventory='';
                    }
                    if(USU_obj_rowvalue.USU_tr_eight==''){
                        USU_obj_rowvalue.USU_tr_eight='SELECT';
                    }
                    if(USU_obj_rowvalue.USU_tr_six==''){
                        USU_obj_rowvalue.USU_tr_six='SELECT';
                    }
                    if(($("#USU_lb_roomtype").val()==USU_obj_rowvalue.USU_tr_six)&&($("#USU_lb_stamptype").val()==USU_obj_rowvalue.USU_tr_eight)&&($("#USU_tb_stampamt").val()==USU_obj_rowvalue.USU_tr_nine)&&(($("#USU_ta_accesscomment").val()).trim()==USU_obj_rowvalue.USU_tr_ten)&&(USU_cb_lost==USU_obj_rowvalue.USU_tr_five)&&(USU_cb_inventory==USU_obj_rowvalue.USU_tr_four)){
                        USU_flag_updbtn=0;
                    }
                    else{
                        USU_flag_updbtn=1;
                    }
                }
                else if(($('#USU_lb_searchby').val()==5)||($('#USU_lb_searchby').val()==8)){
                    USU_flag_roomtype=1;USU_flag_access=1;USU_flag_unitno=1;
                }
                else if(($('#USU_lb_searchby').val()==3)||($('#USU_lb_searchby').val()==6)||($('#USU_lb_searchby').val()==7)||($('#USU_lb_searchby').val()==4)){
                    if ($('#USU_cb_nonei').is(":checked")){
                        var USU_cb_nonei='X';
                    }
                    else{
                        var USU_cb_nonei='';
                    }
                    if ($('#USU_cb_obsolete').is(":checked")){
                        var USU_cb_obsolete='X';
                    }
                    else{
                        var USU_cb_obsolete='';
                    }
                    if((parseInt($('#USU_tb_unitno').val())==0)||($('#USU_tb_unitno').val()=='')||(parseInt($('#USU_tb_unitreltal').val())=='')||($('#USU_tb_unitreltal').val()=='')||($("#USU_tb_unitno").val().length<4)||(($('#USU_tb_unitno').val()==USU_obj_rowvalue.USU_tr_first)&&($('#USU_tb_unitreltal').val()==USU_obj_rowvalue.USU_tr_six)&&($('#USU_tb_unitdeposit').val()==USU_obj_rowvalue.USU_tr_seven)&&(USU_cb_obsolete==USU_obj_rowvalue.USU_tr_four)&&($('#USU_tb_accnoid').val()==USU_obj_rowvalue.USU_tr_eight)&&(($('#USU_tb_accname').val()).trim()==USU_obj_rowvalue.USU_tr_nine)&&($('#USU_tb_bankcodeid').val()==USU_obj_rowvalue.USU_tr_ten)&&($('#USU_tb_branchcode').val()==USU_obj_rowvalue.USU_tr_eleven)&&(USU_cb_nonei==USU_obj_rowvalue.USU_tr_five)&&(($('#USU_tb_bankaddr').val()).trim()==USU_obj_rowvalue.USU_tr_twelve)&&(($('#USU_ta_comments').val()).trim()==USU_obj_rowvalue.USU_tr_thirteen))){
                        USU_flag_updbtn=0;
                    }
                    else{
                        USU_flag_updbtn=1;
                    }
                }
                if((USU_flag_updbtn==1)&&(USU_flag_roomtype==1)&&(USU_flag_access==1)&&(USU_flag_unitno==1)&&(USU_flag_enddate==1)){
                    $('#USU_btn_update').removeAttr("disabled", "disabled");
                }
                else{
                    $('#USU_btn_update').attr("disabled", "disabled")
                }
            });
        // PDF BUTTON EVENT
            $('#USU_btn_pdf').click(function()
            {
                var pdfurl=document.location.href='<?php echo site_url('UNIT/Ctrl_Unit_Creation_Search_Update/USU_flexttablepdf')?>?USU_parent_updation=USU_parent_updation&USU_lb_searchby='+$("#USU_lb_searchby").val()+'&USU_tb_dutyamt_fromamt='+$("#USU_tb_dutyamt_fromamt").val()+'&USU_tb_dutyamt_toamt='+$("#USU_tb_dutyamt_toamt").val()+'&USU_tb_payment_fromamt='+$("#USU_tb_payment_fromamt").val()+'&USU_tb_payment_toamt='+$("#USU_tb_payment_toamt").val()+'&USU_db_fromdate='+$("#USU_db_fromdate").val()+'&USU_db_todate='+$("#USU_db_todate").val()+'&USU_lb_unitno='+$("#USU_lb_unitno").val()+'&USU_lb_roomtyps='+$("#USU_lb_roomtyps").val()+'&USU_lb_cardno='+$("#USU_lb_cardno").val()+'&USU_lb_typeofcard='+$("#USU_lb_typeofcard").val();
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>UNIT CREATION / SEARCH AND UPDATE</b></h4></div>
    <form id="unit_createupdate_form" name="unit_createupdate_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <div class="form-group" id="unitselectoption">
                <div class="col-md-10">
                    <div class="radio">
                        <label><input type="radio" class="UNIT_selectform" value="unitcreate" name="UNIT_form_select" id="UNIT_form_unitcreate">UNIT CREATION</label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="radio">
                        <label><input type="radio" class="UNIT_selectform" value="unitsearchupdate" name="UNIT_form_select" id="UNIT_form_unitupdate">UNIT SEARCH AND UPDATE</label>
                    </div>
                </div>
            </div>
            <div id="UC_form_unitcreation" hidden>
                <div class="form-group" id="UC_unitno">
                    <label class="col-sm-2">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"><input type="text" name="UC_tb_unitno" id="UC_tb_unitno" maxlength=4 class="UC_class_numonly numonly form-control" placeholder="Unit Number"></div>
                    <div class="col-sm-4 errpadding errormsg" id="UC_div_errunitno" name="UC_div_errunitno">
                    </div>
                </div>
                <div class="form-group" id="UC_accesscard">
                    <label class="col-sm-2">ACCESS CARD </label>
                    <div class="col-sm-2"><input type="text" name="UC_tb_accesscard" id="UC_tb_accesscard" class="form-control UC_class_numonly" maxlength=7 placeholder="Access Card"></div>
                    <div class="col-sm-4 errpadding errormsg" id="UC_div_errcard" name="UC_div_errcard"> </div>
                </div>
                <div class="form-group" id="UC_roomtype">
                    <label class="col-sm-2">ROOM TYPE </label>
                    <div class="col-sm-3"><select name="UC_lb_roomtype" id="UC_lb_roomtype" class="form-control"></select></div>
                    <div class="col-sm-2 colsmhf"><input class="btn btn-info" type="button"  name="UC_btn_addroomtype" value="ADD" id="UC_btn_addroomtype"/></div>
                    <div class="col-sm-4 errpadding errormsg" id="UC_div_errroom" name="UC_div_errroom"> </div>
                </div>
                <div class="form-group" id="UC_unitrent">
                    <label class="col-sm-2">UNIT RENTAL <em>*</em></label>
                    <div class="col-sm-2"><input type="text" name="UC_tb_unitrentalamt" id="UC_tb_unitrentalamt" maxlength=4 class="UC_class_numonly form-control" placeholder="Unit Rental"></div>
                </div>
                <div class="form-group" id="UC_unitdepo">
                    <label class="col-sm-2">UNIT DEPOSIT </label>
                    <div class="col-sm-2"><input type="text" name="UC_tb_unitdeposite" id="UC_tb_unitdeposite" maxlength=5 class="UC_class_numonly form-control" placeholder="Unit Deposit"></div>
                </div>
                <div class="form-group" id="UC_startdate">
                    <label class="col-sm-2">START PERIOD <em>*</em></label>
                    <div class="col-sm-2">
                        <div class="input-group addon">
                            <input id="UC_db_startdate" name="UC_db_startdate" type="text" class="date-picker datemandtry form-control" placeholder="Start Date"/>
                            <label for="UC_db_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="UC_enddate">
                    <label class="col-sm-2">END PERIOD <em>*</em></label>
                    <div class="col-sm-2">
                        <div class="input-group addon">
                            <input id="UC_db_enddate" name="UC_db_enddate" type="text" class="date-picker datemandtry form-control" placeholder="End Date"/>
                            <label for="UC_db_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="UC_accntnumber">
                    <label class="col-sm-2">ACCOUNT NUMBER </label>
                    <div class="col-sm-2"><input type="text" name="UC_tb_accntnumber" id="UC_tb_accntnumber" placeholder="Account Number" maxlength="15" class="numonly UC_class_numonly form-control"/></div>
                </div>
                <div class="form-group" id="UC_accntname">
                    <label class="col-sm-2">ACCOUNT NAME </label>
                    <div class="col-sm-3"><input type="text" name="UC_tb_accntname" id="UC_tb_accntname" placeholder="Account Name" maxlength="25" class="uppercase form-control"/></div>
                </div>
                <div class="form-group" id="UC_bankcode">
                    <label class="col-sm-2">BANK CODE</label>
                    <div class="col-sm-2"><input type="text" name="UC_tb_bankcode" id="UC_tb_bankcode" maxlength=5 class="numonly UC_class_numonly form-control" placeholder="Bank Code"/></div>
                </div>
                <div class="form-group" id="UC_branchcode">
                    <label class="col-sm-2">BRANCH CODE</label>
                    <div class="col-sm-2"><input type="text" name="UC_tb_branchcode" id="UC_tb_branchcode" maxlength=5 class="numonly UC_class_numonly form-control" placeholder="Branch Code"/></div>
                </div>
                <div class="form-group" id="UC_bankaddress">
                    <label class="col-sm-2">BANK ADDRESS</label>
                    <div class="col-sm-4"><textarea name="UC_ta_address" id="UC_ta_address" placeholder="Bank Address" style="height: 114px" rows="5" class="form-control"></textarea></div>
                </div>
                <div class="form-group" id="UC_doorcode">
                    <label class="col-sm-2">DOOR CODE</label>
                    <div class="col-sm-2"><input type="text" name="UNIT_tb_doorcode" id="UNIT_tb_doorcode" class="UC_class_numonly numonly form-control" maxlength=10 placeholder="Door Code"/></div>
                    <div class="col-sm-4 errpadding" id="UC_doorcodeerr">
                        <label id="UC_lbl_doorcode" name="UC_lbl_doorcode" class="errormsg"></label>
                    </div>
                </div>
                <div class="form-group" id="UC_weblogin">
                    <label class="col-sm-2">WEB LOGIN</label>
                    <div class="col-sm-2"><input type="text" name="UNIT_tb_weblogin" id="UNIT_tb_weblogin" class="form-control" maxlength=13 placeholder="Web Login"/></div>
                    <div class="col-sm-4 errpadding" id="UC_weblogin">
                        <label id="UC_lbl_weblogin" name="UC_lbl_weblogin" class="errormsg"></label>
                    </div>
                </div>
                <div class="form-group" id="UC_webpass">
                    <label class="col-sm-2">WEB PASSWORD</label>
                    <div class="col-sm-2"><input type="text" name="UC_tb_webpass" id="UC_tb_webpass" class="UC_class_numonly numonly form-control" maxlength=6 placeholder="Web Password"/></div>
                </div>
                <div class="form-group" id="UC_stampdutydate">
                    <label class="col-sm-2">STAMP DUTY DATE </label>
                    <div class="col-sm-2">
                        <div class="input-group addon">
                            <input id="UC_db_stampdutydate" name="UC_db_stampdutydate" type="text" class="date-picker datemandtry form-control" placeholder="Stamp Duty Date"/>
                            <label for="UC_db_stampdutydate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="UC_stamptype">
                    <label class="col-sm-2">STAMP DUTY TYPE </label>
                    <div class="col-sm-3"><select name="UC_lb_stamptype" id="UC_lb_stamptype" class="form-control "></select></div>
                    <div class="col-sm-2 colsmhf"><input class="btn btn-info" type="button" name="UC_btn_addstamptype" value="ADD" id="UC_btn_addstamptype"/></div>
                    <div class="col-sm-4 errpadding errormsg" id="UC_div_errstamp" name="UC_div_errstamp"></div>
                </div>
                <div class="form-group" id="UC_stampamount">
                    <label class="col-sm-2">STAMP DUTY AMOUNT </label>
                    <div class="col-sm-2"><input type="text" name="UC_tb_stampamount" id="UC_tb_stampamount" placeholder="Stamp Duty Amount" class="UC_class_numonly numonly form-control"></div>
                </div>
                <div class="form-group" id="UC_comments">
                    <label class="col-sm-2">COMMENTS</label>
                    <div class="col-sm-4"><textarea name="UC_ta_comments" id="UC_ta_comments" placeholder="Comments" style="height: 114px" rows="5" class="form-control"></textarea></div>
                </div>
                <div class="form-group" id="UC_nonEI">
                    <label class="col-sm-2">EI/NON_EI</label>
                    <div class="radio">
                        <label><input type="checkbox" name="UC_cb_nonEI" id="UC_cb_nonEI"></label>
                    </div>
                </div>
                <div class="form-group" id="UC_buttons">
                    <div class="col-sm-offset-1 col-sm-3">
                        <input class="btn btn-info" type="button" id="UC_btn_submit" name="submit" value="SAVE" disabled/>
                        <input class="btn btn-info" type="button" id="UC_btn_reset" name="RESET" value="RESET"/>
                    </div>
                </div>
            </div>
            <div id="USU_form_unitupdate" hidden>
                <div class="form-group" id="USU_searchby">
                    <label class="col-sm-2">SEARCH BY <em>*</em></label>
                    <div class="col-sm-3"> <select name="USU_lb_searchby" id="USU_lb_searchby" class="form-control USU_formvalidation"></select></div>
                </div>
                <div class="form-group" id='USU_errmsg_roominventory' hidden>
                    <lable class="col-lg-12 errormsg" id="USU_lbl_errmsg_roominventory"></lable>
                </div>
                <div class="form-group" id='USU_subheaderdiv' hidden>
                    <lable class="col-lg-12 srctitle" id="USU_subheadermsg"></lable>
                </div>
                <div id="USU_carddiv" hidden>
                    <div class="form-group" id="USU_unitno">
                        <label class="col-sm-2">UNIT NUMBER </label>
                        <div class="col-sm-2"> <select name="USU_lb_unitno" id="USU_lb_unitno" class="USU_all_searchby form-control USU_formvalidation"></select></div>
                    </div>
                    <div class="form-group" id="USU_cardtype">
                        <label class="col-sm-2">TYPE OF CARD </label>
                        <div class="col-sm-2"> <select name="USU_lb_typeofcard" id="USU_lb_typeofcard" class="form-control USU_formvalidation"></select></div>
                        <div class="form-group errpadding" id='USU_stamperrdiv' hidden>
                            <lable class="col-lg-4 errormsg" id="USU_lbl_errmsg_cardno"></lable>
                        </div>
                    </div>
                    <div class="form-group" id="USU_cardno">
                        <label class="col-sm-2">CARD NUMBER </label>
                        <div class="col-sm-2"> <select name="USU_lb_cardno" id="USU_lb_cardno" class="form-control USU_formvalidation"></select></div>
                    </div>
                </div>
                <div id="USU_roomdiv" hidden>
                    <div class="form-group" id="USU_roomtype">
                        <label class="col-sm-2">ROOM TYPE </label>
                        <div class="col-sm-3"><select name="USU_lb_roomtyps" id="USU_lb_roomtyps" class="USU_all_searchby form-control"></select></div>
                    </div>
                </div>
                <div id="USU_datediv" hidden>
                    <div class="form-group" id="USU_fromdate">
                        <label class="col-sm-2">FROM DATE </label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="USU_db_fromdate" name="USU_db_fromdate" type="text" class="USU_class_datesearch date-picker datemandtry form-control" placeholder="From Date"/>
                                <label for="USU_db_fromdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="USU_todate">
                        <label class="col-sm-2">TO DATE </label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input id="USU_db_todate" name="USU_db_todate" type="text" class="USU_class_datesearch date-picker datemandtry form-control" placeholder="To Date"/>
                                <label for="USU_db_todate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="USU_stampamtdiv" hidden>
                    <div class="form-group" id="USU_stampfromamt">
                        <label class="col-sm-2">FROM AMOUNT </label>
                        <div class="col-sm-2"><input type="text" name="USU_tb_dutyamt_fromamt" id="USU_tb_dutyamt_fromamt" placeholder="From Amount" class="USU_class_amtvalidstamp form-control"></div>
                    </div>
                    <div class="form-group" id="USU_stamptoamt">
                        <label class="col-sm-2">TO AMOUNT </label>
                        <div class="col-sm-2"><input type="text" name="USU_tb_dutyamt_toamt" id="USU_tb_dutyamt_toamt" placeholder="To Amount" class="USU_class_amtvalidstamp form-control"></div>
                    </div>
                    <div class="form-group" id='USU_stamperrdiv' hidden>
                        <lable class="col-sm-offset-2 col-lg-12 errormsg" id="USU_lbl_errmsg_date"></lable>
                    </div>
                </div>
                <div id="USU_paymentamtdiv" hidden>
                    <div class="form-group" id="USU_paymentfromamt">
                        <label class="col-sm-2">FROM AMOUNT </label>
                        <div class="col-sm-2"><input type="text" name="USU_tb_payment_fromamt" id="USU_tb_payment_fromamt" maxlength="4" placeholder="From Amount" class="USU_class_title_nums USU_class_amtvalidpayment form-control"></div>
                    </div>
                    <div class="form-group" id="USU_paymenttoamt">
                        <label class="col-sm-2">TO AMOUNT </label>
                        <div class="col-sm-2"><input type="text" name="USU_tb_payment_toamt" id="USU_tb_payment_toamt" maxlength="4" placeholder="To Amount" class="USU_class_title_nums USU_class_amtvalidpayment form-control"></div>
                    </div>
                    <div class="form-group" id='USU_paymenterrdiv' hidden>
                        <lable class="col-sm-offset-2 col-lg-12 errormsg" id="USU_lbl_errmsg_paymentdate"></lable>
                    </div>
                </div>
                <div class="form-group" id="USU_searchbtn" hidden>
                    <div class="col-sm-offset-1 col-sm-3">
                        <input class="btn btn-info" type="button" id="USU_btn_search" name="USU_btn_search" value="SEARCH" disabled/>
                    </div>
                </div>
                <div id="USU_div_flex">
                    <div class="form-group">
                        <lable class="col-lg-12 srctitle" id="USU_headermsg" hidden></lable>
                    </div>
                    <div style="padding-bottom: 10px;" id="USU_pdf_btn" hidden>
                        <input type="button" id="USU_btn_pdf" class="btnpdf" value="PDF">
                    </div>
                    <div class="table-responsive" id="USU_div_htmltable" hidden>
                        <section id="USU_section1">
                        </section>
                    </div>
                    <div class="errpadding table-responsive" id="USU_div_stamphtmltable" hidden>
                        <section id="USU_section2">
                        </section>
                    </div>
                </div>
                <div id="USU_div_updateform" hidden>
                    <div id="USU_tble_update"></div>
                    <div id="USU_tble_update_reset" hidden>
                        <div class="col-sm-offset-1 col-sm-3">
                            <input class="btn btn-info" type="button" id="USU_btn_update" name="USU_btn_update" value="UPDATE" disabled/>
                            <input class="btn btn-info" type="button" id="USU_btn_reset" name="USU_btn_reset" value="RESET"/>
                            <input type="hidden" id="USU_hidden_flexrowval" name="USU_hidden_flexrowval">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>