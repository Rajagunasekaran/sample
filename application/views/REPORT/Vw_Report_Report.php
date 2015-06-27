<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************REPORT*******************************************************//
//DONE BY:SARADA
//VER 0.02-INITIAL VERSION SD:10-06-2015 ED:11-06-2015 LOADED ALL REPORT IN CATEGORY LIST BOX,COMPLETED ALL REPORT USING ARR DYNAMIC ARRAY CONCEPT
//*********************************************************************************************************//
<!--HTML TAG START-->
<?php

include "application/libraries/EI_HDR.php";

?>
<html>
<!--HEAD TAG START-->
<head>

    <!--SCRIPT TAG START-->
    <script>
        //FAILURE FUNCTION END
        //DOCUMENT READY FUNCTION START
        $(document).ready(function(){
            var REP_controller_url="<?php echo base_url(); ?>" + '/index.php/REPORT/Ctrl_Report_Report/' ;
            $(".preloader").hide();
            $('#spacewidth').height('0%');
            $.ajax({
              type:'post',
                url:REP_controller_url+"REP_getdomain_err",
                success:function(data) {
                     var REP_getdomain_errresult_response=JSON.parse(data);
                     REP_getdomain_errresult(REP_getdomain_errresult_response);
                },
                error:function(data){
                    alert(JSON.stringify(data));
                }
            });
//            google.script.run.withFailureHandler(onFailure).withSuccessHandler(REP_getdomain_errresult).REP_getdomain_err();
            $(".preloader").show();
            var REP_emailarr_emailid=[];
            var REP_arr_reportname=[];
            var REP_arr_catagoryreportname=[];
            var REP_errorMsg_array=[];
            var REP_report_optionvalues=[];
//SUCCESS FUNCTION FOR REPORT PROFILE NAME,ERROR MESSAGE
            function REP_getdomain_errresult(REP_getdomain_errresult_response)
            {
                $(".preloader").hide();
                $('#REP_form_report').show();
                REP_emailarr_emailid=REP_getdomain_errresult_response.REP_emailid;
                REP_arr_catagoryreportname=REP_getdomain_errresult_response.REP_catagoryreportname;
                REP_arr_reportname=REP_getdomain_errresult_response.REP_reportname;
                REP_errorMsg_array=REP_getdomain_errresult_response.REP_errormsg;
                if(REP_emailarr_emailid.length==0)
                {
                    var REP_errmsg=REP_errorMsg_array[0].EMC_DATA.replace('[PROFILE]','REPORT');
                    $('#REP_form_report').replaceWith('<p><label class="errormsg"> '+REP_errmsg+'</label></p>')
                }
                else
                {
                    var REP_emailarray_emailid='<option>SELECT</option>';
                    for (var i = 0; i < REP_emailarr_emailid.length; i++)
                    {
                        REP_emailarray_emailid += '<option value="' + REP_emailarr_emailid[i]  + '">' + REP_emailarr_emailid[i] + '</option>';
                    }
                    $('#REP_lb_emailid').html(REP_emailarray_emailid);
                }
                var REP_array_reportname='<option>SELECT</option>';
                for (var i = 0; i < REP_arr_reportname.length; i++)
                {
                    REP_array_reportname += '<option value="' + REP_arr_reportname[i].REP_reportnames_id + '">' + REP_arr_reportname[i].REP_reportnames_data + '</option>';
                }
                $('#REP_lb_reportname').html(REP_array_reportname);
                var REP_array_catagoryreportname ='<option>SELECT</option>';
                for (var i = 0; i < REP_arr_catagoryreportname.length; i++)
                {
                    REP_array_catagoryreportname += '<option value="' + REP_arr_catagoryreportname[i].REP_searchoption_id + '">'+ REP_arr_catagoryreportname[i].REP_searchoption_data+' </option>';
                }
                $('#REP_lb_catgreportname').html(REP_array_catagoryreportname).show();
//TO HIDE PRELOADER START
                SubPage=0;
                CheckPageStatus();
//TO HIDE PRELOADER END
            }
//CHANGE EVENT FUNCTION FOR SEARCH OPTION
            $('.validation').blur(function(){
                var REP_catagoryvalid=$('#REP_lb_catgreportname').val();
                $('#REP_div_nodata').hide();
                $("#REP_btn_send").attr("disabled", "disabled");
                if(($("#REP_lb_catgreportname").val()!="SELECT")&&($("#REP_lb_reportname").val()!="SELECT")&&($("#REP_lb_emailid").val()!="SELECT"))
                {
                    if(REP_catagoryvalid==82 || REP_catagoryvalid==73)
                    {
                        if(($('#REP_db_month').val()!=undefined)&&($('#REP_db_month').val()!=''))
                            $("#REP_btn_send").removeAttr("disabled");
                    }
                    else
                        $("#REP_btn_send").removeAttr("disabled");
                }
                else
                {
                    $("#REP_btn_send").attr("disabled", "disabled");
                }
            });
//CHANGE EVENT FUNCTION FOR REPORT CATAGORY OPTION
            $('#REP_lb_catgreportname').change(function(){
                var REP_report_optionfetch=$(this).val();
                $('#REP_db_month').val('');
                $("#REP_btn_send").attr("disabled", "disabled");
                $('#REP_div_nodata').hide();
                if(REP_report_optionfetch=='SELECT')
                {
                    $(".preloader").hide();
                    $('#REP_div_nodata').hide();
                    $('#REP_lbl_reportname').hide();
                    $('#REP_lb_reportname').hide();
                    $('#REP_lbl_emailid').hide();
                    $('#REP_lb_emailid').hide();
                    $('#REP_lbl_selectmonth').hide();
                    $('#REP_db_month').hide();
                }
                else
                {
                    var  newPos= adjustPosition($(this).position(),100,150);
                    resetPreloader(newPos);
                    $(".preloader").show();
                    $.ajax({
                        type:'post',
                        url:"<?php echo base_url();?>"+"index.php/REPORT/Ctrl_Report_Report/REP_func_load_searchby_option",
                        data:{'REP_report_optionfetch':REP_report_optionfetch},
                        success:function(data){
                           var REP_response_load_searchby=JSON.parse(data);
                            REP_success_load_searchby_lb(REP_response_load_searchby);
                        }
                    })
                }
            });
//SUCCESS FUNCTION FOR ALL SEARCH BY CATAGORY REPORT
            function REP_success_load_searchby_lb(REP_response_load_searchby)
            {
                $(".preloader").hide();
                var REP_report_optionfetch=REP_response_load_searchby.REP_flag;
                REP_report_optionvalues=REP_response_load_searchby.REP_loaddata_searchby;
                var REP_report_options='<option>SELECT</option>';
                for(var i = 0;i<REP_report_optionvalues.length; i++)
                {
                    REP_report_options += '<option value="' + REP_report_optionvalues[i].REP_seperatereportnames_id + '">' + REP_report_optionvalues[i].REP_seperatereportnames_data + '</option>';
                }
                $('#REP_lb_reportname').html(REP_report_options).show();
                $('#REP_lbl_reportname').show();
                $("#REP_btn_send").attr("disabled", "disabled");
                $('#REP_lbl_emailid').hide();
                $('#REP_lb_emailid').hide();
                $('#REP_lbl_selectmonth').hide();
                $('#REP_db_month').hide();
            }
//CHANGE EVENT FUNCTION FOR REPORT NAME
            $('#REP_lb_reportname').change(function(){
                $(".preloader").show();
                var REP_catagory_option=$(this).val();
                $("#REP_btn_send").attr("disabled", "disabled");
                $('#REP_div_nodata').hide();
                if(REP_catagory_option=='SELECT')
                {
                    $(".preloader").hide();
                    $('#REP_lbl_emailid').hide();
                    $('#REP_lb_emailid').hide();
                    $('#REP_div_nodata').hide();
                    $('#REP_lbl_selectmonth').hide();
                    $('#REP_db_month').hide();
                }
                else
                {
                    $(".preloader").hide();
                    $('#REP_lbl_emailid').show();
                    $('#REP_lb_emailid').val('SELECT').show();
                    if(REP_catagory_option==32 || REP_catagory_option==28 )
                    {
                        $('#REP_lbl_emailid').hide();
                        $('#REP_lb_emailid').hide();
                        $('#REP_lbl_selectmonth').show();
                        $('#REP_db_month').show();
                    }
                }
            });
//CLICK FUNCTION FOR SAVE BUTTON
            $('#REP_btn_send').click(function(){
                $(".preloader").show();
                $.ajax({
                    type:'post',
                    url:REP_controller_url+"REP_ss_getdatas",
                    data:{'reportNameVal':$('#REP_lb_reportname').val(),'reportNameText':$('#REP_lb_reportname').find('option:selected').text(),'emailId':($('#REP_lb_emailid').val()),'categoryName':$('#REP_lb_catgreportname').find('option:selected').text(),'month':$("#REP_db_month").val()},
                    success:function(data){
                        REP_ss_getdatas_result(data)
//                        var REP_response_load_searchby=JSON.parse(data);
//                        REP_success_load_searchby_lb(REP_response_load_searchby);
                    },error:function(data){
                        $(".preloader").hide();
                        alert(JSON.stringify(data));
                    }
                })
            });
//SUCCESS FUNCTION FOR SEND BUTTON
            function REP_ss_getdatas_result(REP_response)
            {
                $(".preloader").hide();
                var REP_reportname=$('#REP_lb_reportname').find('option:selected').text();
                if(REP_response==1)
                {  $("#REP_btn_send").attr("disabled", "disabled");
                    var REP_errmsg=REP_errorMsg_array[1].EMC_DATA.replace('[PROFILE]',REP_reportname);
//MESSAGE BOX FOR SEND BUTTON
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"REPORT",msgcontent:REP_errmsg,position:{top:150,left:500}}});
                    $('#REP_lbl_reportname').hide();
                    $('#REP_lbl_emailid').hide();
                    $('#REP_lb_reportname').hide();
                    $('#REP_lb_emailid').hide();
                    $('#REP_lb_catgreportname').val('SELECT');
                    $('#REP_div_nodata').hide();
                    $('#REP_lbl_selectmonth').hide();
                    $('#REP_db_month').hide();
                    $('#REP_db_month').val('');
                }
                else
                {
                    $("#REP_btn_send").attr("disabled", "disabled");
                    if(REP_response==2)
                        var REP_errormsgnodata=REP_errorMsg_array[0];
                    else
                    var REP_errormsgnodata=REP_errorMsg_array[2].EMC_DATA.replace('[REPORT]',REP_reportname);
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"REPORT",msgcontent:REP_errormsgnodata,position:{top:150,left:500}}});
                    $('#REP_div_nodata').text("");
                    $('#REP_lbl_reportname').hide();
                    $('#REP_lbl_emailid').hide();
                    $('#REP_lb_reportname').hide();
                    $('#REP_lb_emailid').hide();
                    $('#REP_lb_catgreportname').val('SELECT');
                    $('#REP_lbl_selectmonth').hide();
                    $('#REP_db_month').hide();
                }
            }
//DATE PICKER FUNCTION FOR ERM LEEDS
            $('.date-picker').datepicker( {changeMonth: true,  changeYear: true,  showButtonPanel: true,  dateFormat: 'MM-yy',
                maxDate:new Date(),onClose: function(dateText, inst) {
                    $('#REP_lbl_emailid').show();
                    $('#REP_lb_emailid').show();
                    var month =inst.selectedMonth;
                    var year = inst.selectedYear;
                    $(this).datepicker('setDate', new Date(year, month, 1));
                    $(this).blur();
                }
            });
            $(".date-picker").focus(function () {
                $(".ui-datepicker-calendar").hide();
                $("#ui-datepicker-div").position({ my: "left top", at: "left bottom", of: $(this)});});
//CLICK EVENT FUCNTION FOR RESET
            $('#REP_btn_reset').click(function()
            {
                $('#REP_lb_catgreportname').val('');
                $('#REP_lbl_reportname').hide();
                $('#REP_lb_reportname').hide();
                $('#REP_lbl_emailid').hide();
                $('#REP_lb_emailid').hide();
                $("#REP_btn_send").attr("disabled", "disabled");
                $('#REP_div_nodata').hide();
                $('#REP_lbl_selectmonth').hide();
                $('#REP_db_month').hide();
            });
        });
        //DOCUMENT READY FUNCTION END
    </script>
    <!--SCRIPT TAG END-->
</head>
<!--HEAD TAG END-->
<!--BODY TAG START-->
<body>

    <div class="container">
            <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>

<!--        <div class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif"/></div></div></div>-->
        <div class="title text-center"><h4><b>REPORT</b></h4></div>
        <form class="form-horizontal content" name="REP_form_report" id="REP_form_report" hidden >
            <div>
                <div class="form-group" >
                   <label  class="col-sm-3" name="REP_lbl_catgreportname" id="REP_lbl_catgreportname">REPORT CATEGORY<em>*</em></label>
                    <div class="col-sm-2"><select name="REP_lb_catgreportname" id="REP_lb_catgreportname" class="validation form-control" >
                            <option>SELECT</option>
                        </select></div>
               </div>
                <div class="form-group" >
                    <label name="REP_lbl_reportname" id="REP_lbl_reportname" class="col-sm-3" hidden >REPORT NAME<em>*</em></label>
                    <div class="col-sm-4"><select name="REP_lb_reportname" id="REP_lb_reportname" class="validation form-control" style="display:none">
                            <option>SELECT</option>
                        </select></div>
                </div>
                <div class="form-group" ><label name="REP_lbl_selectmonth" id="REP_lbl_selectmonth" class="col-sm-3" hidden>SELECT MONTH<em>*</em></label>
                    <div class="col-sm-2"><input type="text" id="REP_db_month" name="REP_db_month" class="date-picker validation form-control" style="width:110px;display:none" >
                </div>
                    </div>
                <div class="form-group" ><label name="REP_lbl_emailid" id="REP_lbl_emailid" class="col-sm-3" hidden>EMAIL ID<em>*</em></label>
                    <div class="col-sm-4"><select name="REP_lb_emailid" id="REP_lb_emailid" class="validation form-control"   style="display:none">
                            <option>SELECT</option>
                        </select></div>
                </div
            </div>
            <div style="position:relative;left:130px;">
                   <input type="button" class="maxbtn" name="REP_btn_send" id="REP_btn_send" value="SEND" disabled>
                    <input type="button" class="maxbtn" name="REP_btn_reset" id="REP_btn_reset" value="RESET">
            </div>
            <div class="errormsg" name="REP_div_nodata" id="REP_div_nodata"></div>
        </form>
    </div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->