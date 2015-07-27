<?php
//******************************************Door Code Search Update********************************************//
//VER 0.02-SD:22/05/2015 ED:22/05/2015,did inline edit for save part BY RAJA
//VER 0.01-SD:21/05/2015 ED:21/05/2015,completed form design and validation BY RAJA
//*******************************************************************************************************//
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <style>
        th{
            text-align: center;
        }
    </style>
    <script type="text/javascript">
    // document ready function
        $(document).ready(function(){
            var ctrl_unitdoorcode_url="<?php echo site_url('UNIT/Ctrl_Unit_Door_Code_Search_Update'); ?>";
            var DCSU_doorcode_val='';
            var DCSU_weblogin_val='';
            var DCSU_webpass_val='';
            var DCSU_flg_Doorcode=0;
            var DCSU_flg_Login=0;
            var DCSU_flg_pass=0;
            var DCSU_errormsg=[];
            var DCSU_unitno=[];
            var DCSU_login_id='';
            $('#spacewidth').height('0%');
        // initial data
            $.ajax({
                type: "POST",
                url: ctrl_unitdoorcode_url+'/Initialdata',
                success: function(data) {
                    var initial_values=JSON.parse(data);
                    DCSU_unitno_errSuccess(initial_values);
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("DOOR CODE:SEARCH/UPDATE",errordata,'error',false);
                    $('.preloader').hide();
                }
            });
        // SUCCESS FUNCTION FOR ERRORMSG & UNIT NO
            function DCSU_unitno_errSuccess(DCSU_response){
                DCSU_errormsg=DCSU_response.DCSU_errorarray;
                DCSU_unitno=DCSU_response.DCSU_unitno;
                if(DCSU_unitno.length==0){
                    $('#DCSU_form_doorcode').replaceWith('<form id="DCSU_form_doorcode" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="col-sm-12 errormsg"> '+DCSU_errormsg[3].EMC_DATA+'</label></div></fieldset></div></form>');
                }
                else{
                    var DCSU_options ='<option>SELECT</option>';
                    for (var i = 0; i < DCSU_unitno.length; i++)
                    {
                        DCSU_options += '<option value="' + DCSU_unitno[i].UNIT_NO + '">' + DCSU_unitno[i].UNIT_NO + '</option>';
                    }
                    $('#DCSU_lb_unitnumber').html(DCSU_options);
                    $('#DCSU_lb_unitnumber').focus();
                    $("#DCSU_form_doorcode").show();
                }
                $('.preloader').hide();
            }
        // CHANGE EVENT FUNCTION FOR UNIT NUMBER
            $("#DCSU_lb_unitnumber").change(function(){
                $("#DCSU_div_htmltable").hide();
                $("#DCSU_div_errmsgdooor,#DCSU_div_errmsgNodooor").hide();
                $("#DCSU_lbl_errmsgdooor").text('');
                $('#DCSU_pdf_btn').hide();
                $("#DCSU_div_errmsgNodooor").text('').hide();
                if($('#DCSU_lb_unitnumber').val()!='SELECT'){
                    $(".preloader").show();
                    var DCSU_unitnumber=$('#DCSU_lb_unitnumber').val();
                    var DCSU_flag='DCSU_flex';
                    $.ajax({
                        type: "POST",
                        url: ctrl_unitdoorcode_url+'/DCSU_logindetails',
                        data: {'DCSU_unitnumber':DCSU_unitnumber,'DCSU_flag':DCSU_flag},
                        success: function(doordata) {
                            var door_values=JSON.parse(doordata);
                            DCSU_loginSuccess(door_values);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("DOOR CODE:SEARCH/UPDATE",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                else {
                    $("#DCSU_div_htmltable").hide();
                }
            });
        // SUCCESS FUNCTION FOR LOGIN DETAILS
            function DCSU_loginSuccess(DCSU_response){
                $(".preloader").show();
                $("#DCSU_div_htmltable").hide();
                var DCSU_unitnumber=$('#DCSU_lb_unitnumber').val();
                if((DCSU_response.DCSU_id!='')&&(DCSU_response.DCSU_id!=undefined)){
                    $('#DCSU_div_htmltable').empty();
                    var DCSU_div_errmsg=DCSU_errormsg[1].EMC_DATA.replace('[UNIT NO]',DCSU_unitnumber);
                    $("#DCSU_lbl_errmsgdooor").text(DCSU_div_errmsg);
                    $("#DCSU_div_errmsgdooor").show();
                    $('#DCSU_pdf_btn').show();
                    var tr='<table id="DCSU_tble_htmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white;"><tr><th style="width:100px">DOOR CODE <em>*</em></th><th style="width:130px">WEB LOGIN</th><th style="width:100px">WEB PASSWORD</th><th style="width:300px">USERSTAMP</th><th style="width:150px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    var i=0;
                    DCSU_login_id=DCSU_response.DCSU_id;
                    tr += '<tr id="'+DCSU_response.DCSU_id+'"><td id="doorcode_'+DCSU_login_id+'" style="text-align: center" class="datadoorcode">'+DCSU_response.DCSU_doorcode+'</td><td id="weblogin_'+DCSU_login_id+'" class="datadoorcode" style="text-align: center">'+DCSU_response.DCSU_weblog+'</td><td id="webpass_'+DCSU_login_id+'" class="datadoorcode" style="text-align: center">'+DCSU_response.DCSU_webpass+'</td><td>'+DCSU_response.DCSU_user+'</td><td style="text-align: center">'+DCSU_response.DCSU_time+'</td></tr></tbody></table>';
                    $('#DCSU_div_htmltable').append(tr);
                    $('#DCSU_tble_htmltable').DataTable({
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers",
                        "aoColumnDefs" : [
                            { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ],
                        "sDom":"Rlfrtip"
                    });
                    sorting();
                    $("#DCSU_div_htmltable").show();
                    $(".preloader").hide();
                }
                else{
                    var DCSU_div_errmsg=DCSU_errormsg[2].EMC_DATA.replace('[UNIT NO]',DCSU_unitnumber);
                    $("#DCSU_div_errmsgNodooor").text(DCSU_div_errmsg).show();
                    $("#DCSU_div_errmsgdooor").hide();
                    $('#DCSU_pdf_btn').hide();
                    $("#DCSU_lbl_errmsgdooor").text('');
                    $(".preloader").hide();
                }
                if(DCSU_response.DCSU_flg==1){
                    $(".preloader").hide();
                    var DCSU_upd_errmsg=DCSU_errormsg[4].EMC_DATA.replace('[UNITNO]',DCSU_unitnumber);
                    show_msgbox("DOOR CODE:SEARCH/UPDATE",DCSU_upd_errmsg,'success',false);
                }
                if(DCSU_response.DCSU_flg==0){
                    $(".preloader").hide();
                    show_msgbox("DOOR CODE:SEARCH/UPDATE",DCSU_errormsg[5].EMC_DATA,'error',false);
                }
            }
        // CLICK EVENT FOR INLINE EDIT FOR STAMP TYPE AND ROOM TYPE
            var previous_id;var tdvalue;var primcid;
            $(document).on('click','.datadoorcode',function(){
                if(previous_id!=undefined){
                    $('#'+previous_id).replaceWith("<td class='datadoorcode' style='text-align: center' id='"+previous_id+"' >"+tdvalue+"</td>");
                }
                var cid = $(this).attr('id');
                previous_id=cid;
                var splittedcid=cid.split('_');
                var rowcid=splittedcid[0];
                primcid=splittedcid[1];
                tdvalue=$(this).text();
                DCSU_doorcode_val=$('#doorcode_'+primcid).text();
                DCSU_weblogin_val=$('#weblogin_'+primcid).text();
                DCSU_webpass_val=$('#webpass_'+primcid).text();
                if(rowcid=='doorcode')//door code
                {
                    $('#'+cid).replaceWith('<td class="new" id="'+previous_id+'"><input type="text" name="UNIT_tb_doorcode" id="UNIT_tb_doorcode" maxlength=10 size="6" class="DCSU_class_login numonly DCSU_class_numsonly form-control" value="'+tdvalue+'">');
                    if(tdvalue==''){
                        $('#UNIT_tb_doorcode').prop('readonly', true);
                    }
                }
                else if(rowcid=='weblogin')//web login
                {
                    $('#'+cid).replaceWith('<td class="new" id="'+previous_id+'"><input type="text" name="UNIT_tb_weblogin" id="UNIT_tb_weblogin" maxlength=13 size="10" class="DCSU_class_login form-control" value="'+tdvalue+'">');
                    if(tdvalue==''){
                        $('#UNIT_tb_weblogin').prop('readonly', true);
                    }
                }
                else if(rowcid=='webpass')//web password
                {
                    $('#'+cid).replaceWith('<td class="new" id="'+previous_id+'"><input type="text" name="DCSU_tb_webpass" id="DCSU_tb_webpass" maxlength=6  size="5" class="DCSU_class_login numonly DCSU_class_numsonly form-control" value="'+tdvalue+'">');
                    if(tdvalue==''){
                        $('#DCSU_tb_webpass').prop('readonly', true);
                    }
                }
                // TEXT BOX VALIDATION
                $(".DCSU_class_numsonly").prop("title",DCSU_errormsg[0].EMC_DATA);
                $("#UNIT_tb_weblogin").doValidation({rule:'general'});
                $(".numonly").doValidation({rule:'numbersonly',prop:{leadzero:true}});
                $('#DCSU_form_doorcode').find('input:text,textarea').removeClass('rdonly');
            });
        // CHANGE FUNCTION FOR DOORCODE
            $(document).on('blur','.DCSU_class_login',function(evnt){
                evnt.stopPropagation();
                evnt.preventDefault();
                evnt.stopImmediatePropagation();
                DCSU_flg_pass=0;DCSU_flg_Doorcode=0;DCSU_flg_Login=0;
                var idval=$(this).val();
                var idflag=$(this).attr('id');
                $(".preloader").hide();
                if((($(this).attr('id')=='UNIT_tb_doorcode')&&($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length>=6)&&(($(this).val()).trim()!=DCSU_doorcode_val))){
                    $(".preloader").show();
                    callExistsDoorcode(idval,idflag);
                }
                else if((($(this).attr('id')=='UNIT_tb_weblogin')&&($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length>=5)&&(($(this).val()).trim()!=DCSU_weblogin_val))){
                    $(".preloader").show();
                    callExistsDoorcode(idval,idflag);
                }
                else if((($(this).attr('id')=='UNIT_tb_weblogin')&&($(this).val()=='')&&(($(this).val()).trim()!=DCSU_weblogin_val))){
                    $(".preloader").show();
                    callExistsDoorcode(idval,idflag);
                }
                else if((($(this).attr('id')=='DCSU_tb_webpass')&&($(this).val()=='')&&(($(this).val()).trim()!=DCSU_webpass_val))||(($(this).attr('id')=='DCSU_tb_webpass')&&($(this).val()!='')&&(($(this).val()).trim()!=DCSU_webpass_val))){
                    $(".preloader").show();
                    callExistsDoorcode(idval,idflag);
                    DCSU_flg_pass=1;
                }
                else{
                    if(($(this).attr('id')=='UNIT_tb_doorcode')&&($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length<6)&&(($(this).val()).trim()!=DCSU_doorcode_val))
                    {
                        DCSU_flg_Doorcode=0;
                        show_msgbox("DOOR CODE:SEARCH/UPDATE",DCSU_errormsg[9].EMC_DATA,'error',false);
                        $("#UNIT_tb_doorcode").addClass('invalid');
                    }
                    else if(($(this).attr('id')=='UNIT_tb_weblogin')&&($(this).val()!='')&&(parseInt($(this).val())!=0)&&($(this).val().length<5)&&(($(this).val()).trim()!=DCSU_weblogin_val))
                    {
                        DCSU_flg_Login=0;
                        show_msgbox("DOOR CODE:SEARCH/UPDATE",DCSU_errormsg[8].EMC_DATA,'error',false);
                        $("#UNIT_tb_weblogin").addClass('invalid');
                    }
                    else
                    {
                        $(this).removeClass('invalid');
                    }
                }
            });
        // FUNCTION FOR CALL THE EXIST DOOR CODE FUNCTION
            function callExistsDoorcode(values,flag){
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: ctrl_unitdoorcode_url+'/DCSU_ExistsDoorcode',
                    data: {'val':values,'flag':flag},
                    success: function(exitstdata) {
                        var exitst_data=JSON.parse(exitstdata);
                        DCSU_doorcodeSuccess(exitst_data);
                        if(DCSU_flg_Doorcode==1 || DCSU_flg_Login==1 || DCSU_flg_pass==1){
                            $(".preloader").show();
                            if($('#doorcode_'+primcid).hasClass("datadoorcode")==true){
                                var DCSU_doorcode=$('#doorcode_'+primcid).text();
                            }
                            else{
                                var DCSU_doorcode=$("#UNIT_tb_doorcode").val();
                            }
                            if($('#weblogin_'+primcid).hasClass("datadoorcode")==true){
                                var DCSU_weblogin=$('#weblogin_'+primcid).text();
                            }
                            else{
                                var DCSU_weblogin=$("#UNIT_tb_weblogin").val();
                            }
                            if($('#webpass_'+primcid).hasClass("datadoorcode")==true){
                                var DCSU_webpass=$('#webpass_'+primcid).text();
                            }
                            else{
                                var DCSU_webpass=$("#DCSU_tb_webpass").val();
                            }
                            var DCSU_unitnumber=$('#DCSU_lb_unitnumber').val();
                            DCSU_update_Doorcode(DCSU_unitnumber,DCSU_doorcode,DCSU_weblogin,DCSU_webpass);
                        }
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("DOOR CODE:SEARCH/UPDATE",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            }
        // FUNCTION FOR EXISTING DATA
            function DCSU_doorcodeSuccess(DCSU_doorcoderesponse){
                if(DCSU_doorcoderesponse[0]==0){
                    if(DCSU_doorcoderesponse[1]=='UNIT_tb_doorcode'){
                        DCSU_flg_Doorcode=0;
                        show_msgbox("DOOR CODE:SEARCH/UPDATE",DCSU_errormsg[7].EMC_DATA,'error',false);
                        $("#UNIT_tb_doorcode").addClass('invalid');
                    }
                    else if(DCSU_doorcoderesponse[1]=='UNIT_tb_weblogin'){
                        DCSU_flg_Login=0;
                        show_msgbox("DOOR CODE:SEARCH/UPDATE",DCSU_errormsg[6].EMC_DATA,'error',false);
                        $("#UNIT_tb_weblogin").addClass('invalid');
                    }
                    $(".preloader").hide();
                }
                else{
                    if(DCSU_doorcoderesponse[1]=='UNIT_tb_doorcode'){
                        DCSU_flg_Doorcode=1;
                        $("#UNIT_tb_doorcode").removeClass('invalid');
                    }
                    else if(DCSU_doorcoderesponse[1]=='UNIT_tb_weblogin'){
                        DCSU_flg_Login=1;
                        $("#UNIT_tb_weblogin").removeClass('invalid');
                    }
                    $(".preloader").hide();
                }
            }
            // FUNCTION FOR UPDATE DOOR CODE
            function DCSU_update_Doorcode(DCSU_unitnumber,DCSU_doorcode,DCSU_weblogin,DCSU_webpass){
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: ctrl_unitdoorcode_url+'/DCSU_updateDoorcode',
                    data: {'DCSU_login_id':DCSU_login_id,'DCSU_unitnumber':DCSU_unitnumber,'DCSU_doorcode':DCSU_doorcode,'DCSU_weblogin':DCSU_weblogin,'DCSU_webpass':DCSU_webpass},
                    success: function(data){
                        $(".preloader").show();
                        var successdata=JSON.parse(data);
                        DCSU_loginSuccess(successdata);
                        previous_id=undefined;
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("DOOR CODE:SEARCH/UPDATE",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            }
        // PDF BUTTON EVENT
            $('#DCSU_btn_pdf').click(function()
            {
                var DCSUunitno=$('#DCSU_lb_unitnumber').val();
                var pdfurl=document.location.href='<?php echo site_url('UNIT/Ctrl_Unit_Door_Code_Search_Update/DCSU_tablepdf')?>?DCSUunitno='+DCSUunitno;
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>DOOR CODE: SEARCH / UPDATE</b></h4></div>
    <form id="DCSU_form_doorcode" name="DCSU_form_doorcode" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="DCSU_unitno">
                    <label class="col-sm-2">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"><select name="DCSU_lb_unitnumber" id="DCSU_lb_unitnumber" class="form-control"><option>SELECT</option></select></div>
                </div>
                <div class="form-group" id="DCSU_div_errmsgdooor" hidden>
                    <label id="DCSU_lbl_errmsgdooor" class="srctitle col-lg-12"></label>
                </div>
                <div style="padding-bottom: 10px;" id="DCSU_pdf_btn" hidden>
                    <input type="button" id="DCSU_btn_pdf" class="btnpdf" value="PDF">
                </div>
                <div class="form-group col-lg-12 errormsg" id="DCSU_div_errmsgNodooor" hidden>
                </div>
            </fieldset>
            <div class="table-responsive" id="DCSU_div_htmltable" hidden>
                <section id="DCSU_section">
                </section>
            </div>
        </div>
    </form>
</div>
</body>
</html>