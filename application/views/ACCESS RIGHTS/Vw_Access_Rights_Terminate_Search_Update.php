<!--*********************************************************************************************************//-->
<!--//*******************************************FILE DESCRIPTION*********************************************//
//************************************ACCESS RIGHTS_TERMINATE-SEARCH/UPDATE***********************************************//
//DONE BY SAFI

//VER 0.01-INITIAL VERSION,SD:15/05/2015,ED:19/05/2015-->
<?php

require_once('application/libraries/EI_HDR.php');

?>

<html>
<head>

    <script>


        /*-------------------------------------FUNCTION FOR CHANGE DATE FORMAT---------------------------*/
        function FormTableDateFormat(URT_SRC_inputdate){
            var string  = URT_SRC_inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        $(document).ready(function(){
            $('textarea').autogrow({onInitialize: true});
            var URT_SRC_arr_loginid=[];
            var URT_SRC_arr_errormsg=[];
            var URT_SRC_customrole=[]
            var URT_SRC_loginid ='';
            var URT_SRC_upd_edate=''
            var URT_SRC_upd_rson='';
            var URT_SRC_flag_emaiid='';
            var controller_url="<?php echo base_url(); ?>" + '/index.php/ACCESSRIGHTS/Ctrl_Access_Rights_Terminate_Search_Update/' ;
            //    /*------------------------------------------SUCCESS FUNCTION FOR ERROR MSG & LOAD EMAIL_ID--------------------------------*/
            $.ajax({
                type:'post',
                'url':controller_url+"URT_SRC_errormsg_loginid",
                data:{'URT_SRC_source':'URT_SRC_flag_errmsg'},
                success:function(data){
                    var URT_SRC_response_errmsg_loginid=JSON.parse(data)
                    URT_SRC_success_errmsg_loginid(URT_SRC_response_errmsg_loginid);
                }
            });
            function URT_SRC_success_errmsg_loginid(URT_SRC_response_errmsg_loginid){

                $(".preloader").hide();
                URT_SRC_arr_loginid=URT_SRC_response_errmsg_loginid.URT_SRC_obj_loginid;
                URT_SRC_arr_errormsg=URT_SRC_response_errmsg_loginid.URT_SRC_obj_errmsg;
                URT_SRC_customrole=URT_SRC_response_errmsg_loginid.URT_SRC_customerole;
                var URT_SRC_flag_emailid=URT_SRC_response_errmsg_loginid.URT_SRC_obj_source;
                var URT_SRC_flg_login=URT_SRC_response_errmsg_loginid.URT_SRC_obj_flg_login;
                if(URT_SRC_flg_login==false){
                    $('#URT_SRC_form_terminatesrcupd').replaceWith('<p><label class="errormsg"> '+URT_SRC_arr_errormsg[6].EMC_DATA+'</label></p>')
                }
                else if((URT_SRC_flag_emailid!='URT_SRC_flag_errmsg')&&(URT_SRC_flag_emailid!=undefined)){
                    if(URT_SRC_arr_loginid.length==0){
                        if(URT_SRC_flag_emailid=='URT_SRC_radio_loginterminate')
                            var URT_SRC_errormsg_nodata=URT_SRC_arr_errormsg[3].EMC_DATA;
                        else if(URT_SRC_flag_emailid=='URT_SRC_radio_rejoin')
                            var URT_SRC_errormsg_nodata=URT_SRC_arr_errormsg[4].EMC_DATA;
                        else if(URT_SRC_flag_emailid=='URT_SRC_radio_optsrcupd')
                            var URT_SRC_errormsg_nodata=URT_SRC_arr_errormsg[5].EMC_DATA;
                        $('#URT_SRC_lbl_errormsg_nodata').text(URT_SRC_errormsg_nodata)
                    }
                    else{
                        URT_SRC_loginid +='<div ><option>SELECT</option>';
                        for (var i = 0; i < URT_SRC_arr_loginid.length; i++) {
                            URT_SRC_loginid += '<option value="' + URT_SRC_arr_loginid[i]  + '">' + URT_SRC_arr_loginid[i] + '</option>';
                        }
                        URT_SRC_loginid+='</div></div>';
                        URT_SRC_flag_emaiid=URT_SRC_flag_emailid;
                        $("#URT_SRC_tble_emailid").empty();
                        $('<div class="form-group "style="padding-right: 9px"><label class="srctitle col-sm-2">LOGIN ID<em>*</em></label> <div class="col-sm-3"><select id="URT_SRC_lb_loginid" name="URT_SRC_lb_loginid" class="URT_SRC_class_terminatevalid URT_SRC_class_rejoinvalid URT_SRC_class_srchupdvalid form-control">'+URT_SRC_loginid+'</select></div></div><div class="form-group row"><label id="URT_SRC_lbl_recordversion" class="srctitle col-sm-2" hidden>RECORD VERSION<em>*</em></label><div class="col-sm-2"><select name="URT_SRC_lb_recordversion" id="URT_SRC_lb_recordversion" class="form-control" style="display:none"  hidden></select></div></div>').appendTo($("#URT_SRC_tble_emailid"))
                    }
                }
            }
            /*-------------------------------------CHANGE EVENT FUNCTION FOR RADIO BUTTON FOR LOGIN/SRCH UPDATE-------------------------------------------*/
            $('.URT_SRC_class_loginterminate_srcupd').click(function(){
                var URT_SRC_source=  $(this).attr('id');
                $("#URT_SRC_tble_emailid").empty();
                $("#URT_SRC_tble_srchupd").empty();
                $("#URT_SRC_tble_loginterm").empty();
                $("#URT_SRC_tble_rejoin").empty();
                $("#URT_SRC_tble_optsrchupd").empty();
                $("#URT_SRC_lbl_errormsg_nodata").text('');
                /*-------------------------------------------CLICK EVENT FUNCTION FOR LOGIN DETAILS-----------------------------------*/
                if(URT_SRC_source=='URT_SRC_radio_loginterminate'){
                    $(".preloader").show();
                    URT_SRC_loginid ='';
                    $.ajax({
                        type:'post',
                        'url':controller_url+"URT_SRC_errormsg_loginid",
                        data:{'URT_SRC_source':URT_SRC_source},
                        success:function(data){
                            var URT_SRC_response_errmsg_loginid=JSON.parse(data);
                            URT_SRC_success_errmsg_loginid(URT_SRC_response_errmsg_loginid);
                        },
                        error:function(data){

                            show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                        }
                    });
                }
                else if(URT_SRC_source=='URT_SRC_radio_srcupd'){
                    $(' <div class="form-group "><label class="srctitle col-sm-2">SELECT A OPTION</label></div><div class="form-group" style="padding-left: 15px"><div class="radio"><label class="col-sm-2" name="URT_SRC_lbl_nselectrejoin" id="URT_SRC_lbl_selectrejoin"   ><input type="radio" id="URT_SRC_radio_rejoin" name="URT_SRC_radio_rejoin_srcupd" class="URT_SRC_class_rejoin_srcupd">REJOIN</label></div><div class="radio"><label class="col-sm-2" name="URT_SRC_lbl_nselectsearchupdate" id="URT_SRC_lbl_selectsearchupdate"  style="white-space: nowrap!important;"><input type="radio" id="URT_SRC_radio_optsrcupd" name="URT_SRC_radio_rejoin_srcupd" class="URT_SRC_class_rejoin_srcupd">SEARCH/UPDATE</label></div></div>').appendTo($("#URT_SRC_tble_srchupd"));
                }
            });
            /*-------------------------------------CHANGE EVENT FUNCTION FOR EMAIL_ID TO GET JOIN DATE-------------------------------------------*/
            $(document).on('change','#URT_SRC_lb_loginid',function(evt){
                evt.stopPropagation();
                evt.preventDefault();
                evt.stopImmediatePropagation();
                if($("#URT_SRC_lb_loginid").val()!='SELECT'){

                    $(".preloader").show();
                    $("#URT_SRC_tble_loginterm").empty();
                    $("#URT_SRC_tble_rejoin").empty();
                    $("#URT_SRC_tble_optsrchupd").empty();
                    $("#URT_SRC_db_logindate").val('')
                    if(URT_SRC_flag_emaiid=='URT_SRC_radio_loginterminate'){
                        $("#URT_SRC_tble_srchupd").empty();
                        $.ajax({
                            type:'post',
                            'url':controller_url+"URT_SRC_func_enddate",
                            data:{'login_id':$("#URT_SRC_lb_loginid").val(),'URT_SRC_recdver':'URT_SRC_recdver','URT_SRC_check_enddate':'URT_SRC_check_enddate','URT_SRC_recvrsion_one':'URT_SRC_recvrsion_one'},
                            success:function(data){
                                var URT_SRC_response_enddate=JSON.parse(data);
                                URT_SRC_success_enddate(URT_SRC_response_enddate);
                            },
                            error:function(data){

                                show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                            }
                        });
                    }
                    else if(URT_SRC_flag_emaiid=='URT_SRC_radio_rejoin'){
                        $.ajax({
                            type:'post',
                            'url':controller_url+"URT_SRC_func_enddate",
                            data:{'login_id':$("#URT_SRC_lb_loginid").val(),'URT_SRC_recdver':'URT_SRC_recdver','URT_SRC_check_enddate':'URT_SRC_check_rejoindate','URT_SRC_recvrsion_one':'URT_SRC_recvrsion_one'},
                            success:function(data){
                                var URT_SRC_response_enddate=JSON.parse(data);
                                URT_SRC_success_enddate(URT_SRC_response_enddate);
                            },
                            error:function(data){

                                show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                            }
                        });
                    }
                    else if(URT_SRC_flag_emaiid=='URT_SRC_radio_optsrcupd'){
                        $.ajax({
                            type:'post',
                            'url':controller_url+"URT_SRC_func_recordversion",
                            data:{'login_id':$("#URT_SRC_lb_loginid").val(),'URT_SRC_flag_recver':'URT_SRC_flag_recver','URT_SRC_recvrsion_one':'URT_SRC_recvrsion_one'},
                            success:function(data){
                                var URT_SRC_response_enddate=JSON.parse(data);
                                URT_SRC_success_enddate(URT_SRC_response_enddate);
                            },
                            error:function(data){

                                show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                            }
                        });
                    }
                }
                else{
                    $(".preloader").hide();
                    $("#URT_SRC_tble_loginterm").empty();
                    $("#URT_SRC_tble_rejoin").empty();
                    $("#URT_SRC_tble_optsrchupd").empty();
                    $("#URT_SRC_db_logindate").val('')
                }
            });
            /*---------------------------------------SUCCESS FUNCTION-----------------------------------*/
            function URT_SRC_success_enddate(URT_SRC_response_enddate){
                $(".preloader").hide();
                var URT_SRC_arr_recordversion=[];
                if(URT_SRC_response_enddate.URT_SRC_obj_recordversion!=undefined){
                    URT_SRC_arr_recordversion=URT_SRC_response_enddate.URT_SRC_obj_recordversion;}
                if((URT_SRC_response_enddate.URT_SRC_obj_srcupd=='URT_SRC_check_enddate')&&(URT_SRC_response_enddate.URT_SRC_obj_srcupd!=undefined)){
                    $('<div class="form-group row"><label class="srctitle col-sm-2">SELECT A END DATE<em>*</em></label><div class="col-sm-10"><input type="textbox" id="URT_SRC_db_logindate" name="URT_SRC_db_logindate" style="width:100px" class="URT_SRC_class_terminatevalid datemandtry form-control"></div></div><div class="form-group row"><label class="srctitle col-sm-2">REASON OF TERMINATION<em>*</em></label> <div class="col-sm-4"><textarea id="URT_SRC_ta_reasonterm" name="URT_SRC_ta_reasonterm" class="URT_SRC_class_terminatevalid form-control" rows="5"></textarea> </div> </div><div><input type="button" id="URT_SRC_btn_terminate" name="URT_SRC_btn_terminate" value="TERMINATE" class="maxbtn" disabled></div>').appendTo($("#URT_SRC_tble_loginterm"));
                    $('textarea').autogrow({onInitialize: true});
                    $("#URT_SRC_db_logindate").datepicker({dateFormat: "dd-mm-yy" ,changeYear:true,changeMonth:true });
                    var date = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_joindate ) );
                    date.setDate( date.getDate() + 1 );
                    var newDate = date.toDateString();
                    newDate = new Date( Date.parse( newDate ) );
                    $('#URT_SRC_db_logindate').datepicker("option","minDate",newDate);
                    $('#URT_SRC_db_logindate').datepicker("option","maxDate",new Date());
                }
                else if((URT_SRC_response_enddate.URT_SRC_obj_srcupd=='URT_SRC_check_rejoindate')&&(URT_SRC_response_enddate.URT_SRC_obj_srcupd!=undefined)){

                    var URT_SRC_roles='<div class="form-group" style="padding-right: 15px"><div class="radio"><label class="srctitle col-sm-2" style="white-space: nowrap!important;">SELECT ROLE ACCESS<em>*</em></label>';
                    for (var i = 0; i < URT_SRC_customrole.length; i++) {
                        var id1="URSRC_role_array"+i;
                        var value=URT_SRC_customrole[i].replace(" ","_")
                        URT_SRC_roles += '  <div class="col-sm-offset-2 col-sm-10"><label style="white-space: nowrap!important;"><input type="radio" name="customrole" id='+id1+' value='+value+' class="URT_SRC_class_rejoinvalid"   />' + URT_SRC_customrole[i] + '</label></div>';
                    }
                    URT_SRC_roles+='</div></div>';
                    URT_SRC_roles +='<div class="form-group row"><label class="srctitle col-sm-2">SELECT A REJOIN DATE<em>*</em></label><div class="col-sm-10"><input type="textbox" id="URT_SRC_db_rejoindate" name="URT_SRC_db_rejoindate" style="width:100px" class="URT_SRC_class_rejoinvalid datemandtry form-control"></div></div><div><input type="button" id="URT_SRC_btn_rejoin" name="URT_SRC_btn_rejoin" value="REJOIN" class="btn" disabled></div>'
                    $("#URT_SRC_tble_rejoin").append(URT_SRC_roles);
                    $("#URT_SRC_db_rejoindate").datepicker({dateFormat: "dd-mm-yy" ,changeYear:true,changeMonth:true });
                    var date = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_endate ) );
                    date.setDate( date.getDate() + 1 );
                    var newDate = date.toDateString();
                    newDate = new Date( Date.parse( newDate ) );
                    $('#URT_SRC_db_rejoindate').datepicker("option","minDate",newDate);
                    $('#URT_SRC_db_rejoindate' ).datepicker( "option", "maxDate", new Date() );
                }
                else if(URT_SRC_response_enddate.URT_SRC_obj_srcupd=='URT_SRC_flag_recver'){
                    var URT_SRC_recver ='<option>SELECT</option>';
                    for (var i = 0; i < URT_SRC_arr_recordversion.length; i++) {
                        URT_SRC_recver += '<option value="' + URT_SRC_arr_recordversion[i]  + '">' + URT_SRC_arr_recordversion[i] + '</option>';
                    }
                    $('#URT_SRC_lbl_recordversion').show();
                    $('#URT_SRC_lb_recordversion').html(URT_SRC_recver).show();
                    $('#URT_SRC_lb_recordversion').removeAttr('display');
                }
                else if((URT_SRC_response_enddate.URT_SRC_obj_srcupd=='URT_SRC_srcupd')&&(URT_SRC_response_enddate.URT_SRC_obj_srcupd!=undefined)){
                    $('<div class="form-group row"><label class="srctitle col-sm-2">SELECT A END DATE<em>*</em></label><div class="col-sm-10"><input type="textbox" id="URT_SRC_db_upd_enddate" name="URT_SRC_db_upd_enddate" style="width:100px" class="URT_SRC_class_srchupdvalid datemandtry"></div></div><div class="form-group row"><label class="srctitle col-sm-2">REASON OF TERMINATION<em>*</em></label><div class="col-sm-4"><textarea id="URT_SRC_ta_upd_reasonterm" name="URT_SRC_ta_upd_reasonterm" class="URT_SRC_class_srchupdvalid form-control" rows="5"></textarea></div></div><div><input type="button" id="URT_SRC_btn_update" name="URT_SRC_btn_update" value="UPDATE" class="btn" disabled></div>').appendTo($("#URT_SRC_tble_optsrchupd"));
                    $("#URT_SRC_db_upd_enddate").datepicker({dateFormat: "dd-mm-yy" ,changeYear:true,changeMonth:true });
                    $('textarea').autogrow({onInitialize: true});
                    var date = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_joindate ) );
                    date.setDate( date.getDate() + 1 );
                    var newDate = date.toDateString();
                    newDate = new Date( Date.parse( newDate ) );
                    $('#URT_SRC_db_upd_enddate').datepicker("option","minDate",newDate);
                    $('#URT_SRC_db_upd_enddate').datepicker("option","maxDate",new Date());
                    if(URT_SRC_arr_recordversion.length==1){
                        $('#URT_SRC_lbl_recordversion').hide();
                        $('#URT_SRC_lb_recordversion').hide();}
                    else{
                        var date = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_joindate ) );
                        date.setDate( date.getDate() + 1 );
                        var newDate = date.toDateString();
                        newDate = new Date( Date.parse( newDate ) );
                        $('#URT_SRC_db_upd_enddate').datepicker("option","minDate",newDate);
                        $('#URT_SRC_db_upd_enddate').datepicker("option","maxDate",new Date());
                        if(URT_SRC_response_enddate.URT_SRC_obj_next_jdate!='URT_SRC_nomore_recver'){
                            var enddate = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_next_jdate ) );
                            enddate.setDate( enddate.getDate() - 1 );
                            var neweDate = enddate.toDateString();
                            neweDate = new Date( Date.parse( neweDate ) );
                            $('#URT_SRC_db_upd_enddate').datepicker("option","maxDate",neweDate);
                        }}
                    $('#URT_SRC_db_upd_enddate').val(FormTableDateFormat(URT_SRC_response_enddate.URT_SRC_obj_endate));
                    URT_SRC_upd_edate=FormTableDateFormat(URT_SRC_response_enddate.URT_SRC_obj_endate)
                    URT_SRC_upd_rson=URT_SRC_response_enddate.URT_SRC_obj_reason
                    $('#URT_SRC_ta_upd_reasonterm').val(URT_SRC_response_enddate.URT_SRC_obj_reason);

                }
            }
            /*-------------------------------------CLICK EVENT FUNCTION FOR RADIO BUTTON FOR REJOIN FORM-------------------------------------------*/
            $(document).on('click','.URT_SRC_class_rejoin_srcupd',function(){

//        var  newPos= adjustPosition($(this).position(),100,270);
//        resetPreloader(newPos);
                $(".preloader").show();
                $("#URT_SRC_lbl_errormsg_nodata").text('');
                var URT_SRC_source=  $(this).attr('id');
                $("#URT_SRC_tble_emailid").empty();
                $("#URT_SRC_tble_rejoin").empty();
                $("#URT_SRC_tble_optsrchupd").empty();
//                evt.stopPropagation();
//                evt.preventDefault();
//                evt.stopImmediatePropagation();
                if(URT_SRC_source=='URT_SRC_radio_rejoin'){
                    URT_SRC_loginid ='';
                    $.ajax({
                        type:'post',
                        'url':controller_url+"URT_SRC_errormsg_loginid",
                        data:{'URT_SRC_source':URT_SRC_source},
                        success:function(data){
                            var URT_SRC_response_errmsg_loginid=JSON.parse(data);
                            URT_SRC_success_errmsg_loginid(URT_SRC_response_errmsg_loginid);
                        },
                        error:function(data){

                            show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                        }
                    });
                }
                else if(URT_SRC_source=='URT_SRC_radio_optsrcupd'){
                    URT_SRC_loginid ='';
                    $.ajax({
                        type:'post',
                        'url':controller_url+"URT_SRC_errormsg_loginid",
                        data:{'URT_SRC_source':URT_SRC_source},
                        success:function(data){
                            var URT_SRC_response_errmsg_loginid=JSON.parse(data);
                            URT_SRC_success_errmsg_loginid(URT_SRC_response_errmsg_loginid);
                        },
                        error:function(data){

                            show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                        }
                    });
                }
            });
            /*-------------------------------CLICK FUNCTION FOR TERMINATE----------------------------*/
            $(document).on('click','#URT_SRC_btn_terminate',function(evt){
                evt.stopPropagation();
                evt.preventDefault();
                evt.stopImmediatePropagation();

                $(".preloader").show();
                $.ajax({
                    type:'post',
                    'url':controller_url+"URT_SRC_func_terminate",
                    data:{'login_id':$("#URT_SRC_lb_loginid").val(),'terminate_date':$('#URT_SRC_db_logindate').val(),'terminate_reason':$('#URT_SRC_ta_reasonterm').val(),'URT_SRC_flag_terminate':'URT_SRC_flag_terminate'},
                    success:function(data){
                        var URT_SRC_response=JSON.parse(data);
                        URT_SRC_success_update_rejoin_terminate(URT_SRC_response);
                    },
                    error:function(data){

                        show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                    }
                });
            });
            /*---------------------------CLICK FUNCTION FOR REJOIN----------------------------*/
            $(document).on('click','#URT_SRC_btn_rejoin',function(evt){
                evt.stopPropagation();
                evt.preventDefault();
                evt.stopImmediatePropagation();
//        var  newPos= adjustPosition($("#URT_SRC_lb_loginid").position(),100,270);
//        resetPreloader(newPos);
                $(".preloader").show();
                $.ajax({
                    type:'post',
                    'url':controller_url+"URT_SRC_func_rejoin",
                    data:{'login_id':$("#URT_SRC_lb_loginid").val(),'rejoin_date':$('#URT_SRC_db_rejoindate').val(),'role':$("input[name=customrole]:checked").val(),'URT_SRC_flag_rejoin':'URT_SRC_flag_rejoin'},
                    success:function(data){

                        var URT_SRC_response=JSON.parse(data);
                        URT_SRC_success_update_rejoin_terminate(URT_SRC_response);
                    },
                    error:function(data){

                        show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                    }
                });
            });
            /*----------------------------CLICK FUNCTION FOR UPDATE-----------------------------*/
            $(document).on('click','#URT_SRC_btn_update',function(evt){
                evt.stopPropagation();
                evt.preventDefault();
                evt.stopImmediatePropagation();
                var  newPos= adjustPosition($("#URT_SRC_lb_loginid").position(),100,270);
                resetPreloader(newPos);
                $(".preloader").show();
                $.ajax({
                    type:'post',
                    'url':controller_url+"URT_SRC_func_update",
                    data:{'login_id':$("#URT_SRC_lb_loginid").val(),'URT_SRC_recdver':$("#URT_SRC_lb_recordversion").val(),'URT_SRC_upd_enddate':$('#URT_SRC_db_upd_enddate').val(),'reason':$('#URT_SRC_ta_upd_reasonterm').val(),'URT_SRC_flag_updation':'URT_SRC_flag_updation','URT_SRC_upd_rson':URT_SRC_upd_rson},
                    success:function(data){

                        var URT_SRC_response=JSON.parse(data);
                        URT_SRC_success_update_rejoin_terminate(URT_SRC_response);
                    },
                    error:function(data){

                        show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                    }

                });
            });
            /*---------------------------------------SUCCESS FUNCTION-----------------------------------*/
            function URT_SRC_success_update_rejoin_terminate(URT_SRC_response_upd_rejoin){


                if(URT_SRC_response_upd_rejoin[1]==0)
                {
                    show_msgbox("TERMINATE - SEARCH/UPDATE",URT_SRC_arr_errormsg[7].EMC_DATA,"success",false)

//                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[7].EMC_DATA,position:{top:150,left:500}}});
                }
                else
                {
                    var doc_flag=URT_SRC_response_upd_rejoin[2];
                    var cal_flag=URT_SRC_response_upd_rejoin[3];
                    if(URT_SRC_response_upd_rejoin[1]==1){
                        if((URT_SRC_response_upd_rejoin[0]=='URT_SRC_flag_updation')&&(URT_SRC_response_upd_rejoin[0]!=undefined)){
                            var URT_SRC_err_term_rejoin_srcupd=(URT_SRC_arr_errormsg[0].EMC_DATA).replace('[LOGIN ID]',$("#URT_SRC_lb_loginid").val())
//                            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_err_term_rejoin_srcupd,position:{top:150,left:500}}});
                        }
                        else if((URT_SRC_response_upd_rejoin[0]=='URT_SRC_flag_rejoin')&&(URT_SRC_response_upd_rejoin[0]!=undefined)){
                            if(doc_flag==1 && cal_flag==1){
                                var URT_SRC_err_term_rejoin_srcupd=(URT_SRC_arr_errormsg[2].EMC_DATA).replace('[LOGIN ID]',$("#URT_SRC_lb_loginid").val())
                            }
                            if( doc_flag==0){
                                show_msgbox("TERMINATE - SEARCH/UPDATE",URT_SRC_arr_errormsg[9].EMC_DATA,"success",false)
                            }
                            else if( doc_flag==1 && cal_flag==0){
                                show_msgbox("TERMINATE - SEARCH/UPDATE",URSRC_errorAarray[11].EMC_DATA,"success",false)
                            }
                        }
                        else if((URT_SRC_response_upd_rejoin[0]=='URT_SRC_flag_terminate')&&(URT_SRC_response_upd_rejoin[0]!=undefined)){
                            if(doc_flag==1 && cal_flag==1){
                                var URT_SRC_err_term_rejoin_srcupd=(URT_SRC_arr_errormsg[1].EMC_DATA).replace('[LOGIN ID]',$("#URT_SRC_lb_loginid").val())

                            }
                            if( doc_flag==0){
                                show_msgbox("TERMINATE - SEARCH/UPDATE",URT_SRC_arr_errormsg[9].EMC_DATA,"success",false)
                            }
                            else if( doc_flag==1 && cal_flag==0){
                                show_msgbox("TERMINATE - SEARCH/UPDATE",URT_SRC_arr_errormsg[11].EMC_DATA,"success",false)
                            }
                        }
                        if(URT_SRC_response_upd_rejoin[0]!=undefined)
                            show_msgbox("TERMINATE - SEARCH/UPDATE",URT_SRC_err_term_rejoin_srcupd,"success",false)
//                            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_err_term_rejoin_srcupd,position:{top:150,left:500}}});
                    }
                    $(':input','#URT_SRC_form_terminatesrcupd').removeAttr('checked');
                    $("#URT_SRC_tble_rejoin").empty();
                    $("#URT_SRC_tble_emailid").empty();
                    $("#URT_SRC_tble_optsrchupd").empty();
                    $("#URT_SRC_tble_loginterm").empty();
                    $("#URT_SRC_tble_srchupd").empty();
                }
                $(".preloader").hide();
            }
            /*-----------------------------------------CHANGE FUNCTION TERMINATE BTN VALIDATION--------------------------*/
            $(document).on('change','.URT_SRC_class_terminatevalid',function(){
                if(($('#URT_SRC_lb_loginid').val()!='SELECT')&&($('#URT_SRC_db_logindate').val()!='')&&($('#URT_SRC_ta_reasonterm').val()!='')){
                    $("#URT_SRC_btn_terminate").removeAttr("disabled");
                }
                else
                    $('#URT_SRC_btn_terminate').attr("disabled", "disabled")
            });
            /*-----------------------------------------CHANGE FUNCTION REJOIN BTN VALIDATION--------------------------*/
            $(document).on('change','.URT_SRC_class_rejoinvalid',function(){
                var URT_SRC_role_select=$("input[name=customrole]").is(":checked");
                if(($('#URT_SRC_lb_loginid_srchupd').val()!='SELECT')&&($('#URT_SRC_db_rejoindate').val()!='')&&(URT_SRC_role_select==true)){
                    $("#URT_SRC_btn_rejoin").removeAttr("disabled");
                }
                else
                    $('#URT_SRC_btn_rejoin').attr("disabled", "disabled")
            });
            /*-----------------------------------------CHANGE FUNCTION UPDATE BTN VALIDATION--------------------------*/
            $(document).on('change','.URT_SRC_class_srchupdvalid',function(){
                if(($('#URT_SRC_lb_upd_loginid').val()=='SELECT')||($('#URT_SRC_db_upd_enddate').val()=='')||($('#URT_SRC_ta_upd_reasonterm').val()=='')||(($('#URT_SRC_db_upd_enddate').val()==URT_SRC_upd_edate)&&($('#URT_SRC_ta_upd_reasonterm').val()==URT_SRC_upd_rson))){
                    $('#URT_SRC_btn_update').attr("disabled", "disabled")
                }
                else
                    $("#URT_SRC_btn_update").removeAttr("disabled");
            });
            /*-------------------------------------CHANGE EVENT FUNCTION FOR EMAIL_ID TO GET END DATE,REASON-------------------------------------------*/
            $(document).on('change','#URT_SRC_lb_upd_loginid',function(){
                if($("#URT_SRC_lb_upd_loginid").val()!="SELECT")
                {
                    var  newPos= adjustPosition($(this).position(),100,270);
                    resetPreloader(newPos);
                    $(".preloader").show();
                    $.ajax({
                        type:'post',
                        'url':controller_url+"URT_SRC_func_recordversion",
                        data:{'login_id':$("#URT_SRC_lb_loginid").val(),'URT_SRC_flag_recver':'URT_SRC_flag_recver'},
                        success:function(data){

                            var URT_SRC_response_enddate=JSON.parse(data);
                            URT_SRC_success_enddate(URT_SRC_response_enddate);

                        }
                    });
//            google.script.run.withSuccessHandler(URT_SRC_success_enddate).withFailureHandler(URT_SRC_onFailure).URT_SRC_func_recordversion($("#URT_SRC_lb_upd_loginid").val(),'URT_SRC_flag_recver')
                }
                else
                {
                    $("#URT_SRC_lbl_recordversion").hide();
                    $("#URT_SRC_lb_recordversion").hide();
                    $("#URT_SRC_db_logindate").val('').hide()
                    $("#URT_SRC_ta_reasonterm").val('').hide()
                }
            });
            /*----------------------------CHANGE EVENT FUNCTION FOR RECORD VERSION TO GET ENDDATE,REASON TO UPDATE-------------------------------------------*/
            $(document).on('change','#URT_SRC_lb_recordversion',function(evt){
                evt.stopPropagation();
                evt.preventDefault();
                evt.stopImmediatePropagation();
                if($("#URT_SRC_lb_recordversion").val()!="SELECT")
                {
                    var  newPos= adjustPosition($("#URT_SRC_lb_loginid").position(),100,270);
                    resetPreloader(newPos);
                    $(".preloader").show();
                    $("#URT_SRC_tble_optsrchupd").empty();
                    $.ajax({
                        type:'post',
                        'url':controller_url+"URT_SRC_func_enddate",
                        data:{'login_id':$("#URT_SRC_lb_loginid").val(),'URT_SRC_recdver':$("#URT_SRC_lb_recordversion").val(),'URT_SRC_check_enddate':'URT_SRC_srcupd','URT_SRC_srcupd':'URT_SRC_recvrsion_more'},
                        success:function(data){

                            var URT_SRC_response_enddate=JSON.parse(data);
                            URT_SRC_success_enddate(URT_SRC_response_enddate);

                        },
                        error:function(data){

                            show_msgbox("TERMINATE - SEARCH/UPDATE",JSON.stringify(data),"error",false);
                        }
                    });
                }
                else{
                    $("#URT_SRC_db_logindate").val('').hide()
                    $("#URT_SRC_ta_reasonterm").val('').hide()
                }
            });
//    function URT_SRC_onFailure(URT_SRC_error){
//        $(".preloader").hide();
//        if(URT_SRC_error=="ScriptError: Failed to establish a database connection. Check connection string, username and password.")
//        {
//            URT_SRC_error="DB USERNAME/PWD WRONG, PLZ CHK UR CONFIG FILE FOR THE CREDENTIALS."
//            $('#URT_SRC_form_terminatesrcupd').replaceWith('<center><label class="dberrormsg">'+URT_SRC_error+'</label></center>');
//        }
//        else if((URT_SRC_error=='ReferenceError: "Calendar" is not defined.')||(URT_SRC_error=='ScriptError: Access Not Configured. Please use Google Developers Console to activate the API for your project.')){
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[8],position:{top:150,left:500}}});
//        }
//        else if(URT_SRC_error=='ScriptError: No item with the given ID could be found, or you do not have permission to access it.'){
//
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[9],position:{top:150,left:500}}});
//        }
//        else if((URT_SRC_error=='ScriptError: Forbidden')||(URT_SRC_error=='ScriptError: You do not have permission to perform that action.')){
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[11],position:{top:150,left:500}}});
//
//        }
//        else if((URT_SRC_error=='ScriptError: Not Found')||(URT_SRC_error=='Not Found')){
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[10],position:{top:150,left:500}}});
//
//        }
//        else{
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_error.message,position:{top:150,left:500}}});
//        }
//    }
        });
    </script>
    <!--SCRIPT TAG END-->
</head>
<body>
<div class="container">
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>TERMINATE - SEARCH/UPDATE</b></h4></div>
    <form  name="URT_SRC_form_terminatesrcupd" id="URT_SRC_form_terminatesrcupd" class=" form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div style="padding-bottom: 15px">
                    <div class="radio">
                        <label >
                            <input  type="radio"  name="URT_SRC_radio_loginterminate_srcupd" id="URT_SRC_radio_loginterminate"  value="URT_SRC_loginterminate" class="URT_SRC_class_loginterminate_srcupd">
                            LOGIN TERMINATION
                        </label>
                    </div>
                    <div class="radio">
                        <label >
                            <input type="radio" name="URT_SRC_radio_loginterminate_srcupd" id="URT_SRC_radio_srcupd" value="URT_SRC_srcupd" class="URT_SRC_class_loginterminate_srcupd">
                            SEARCH/UPDATE
                        </label>

                    </div>
                </div>
                <div id="URT_SRC_tble_srchupd"></div>
                <div id="URT_SRC_tble_emailid"></div>
                <div id="URT_SRC_tble_loginterm"></div>
                <div id="URT_SRC_tble_rejoin"></div>
                <div id="URT_SRC_tble_optsrchupd"></div>
                <label id="URT_SRC_lbl_errormsg_nodata" class="errormsg"></label>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>
