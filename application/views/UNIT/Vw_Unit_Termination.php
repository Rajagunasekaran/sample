<?php
//******************************************Unit Termination********************************************//
//VER 0.01-SD:21/05/2015 ED:21/05/2015,initial version BY RAJA
//*******************************************************************************************************//
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <script type="text/javascript">
    // document ready function
        $(document).ready(function(){
            var ctrl_unittermination_url="<?php echo site_url('UNIT/Ctrl_Unit_Termination'); ?>";
            var UT_errorarray =[];
            var UT_types_array= [];
            $('#spacewidth').height('0%');
            $('textarea').autogrow({onInitialize: true});
            $("#UT_ta_comments").doValidation({rule:'general',prop:{uppercase:false}});
        // initial data
            $.ajax({
                type: "POST",
                url: ctrl_unittermination_url+'/Initialdata',
                success: function(data) {
                    var initial_values=JSON.parse(data);
                    UT_refreshSuccess(initial_values);
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("UNIT TERMINATION",errordata,'error',false);
                    $('.preloader').hide();
                }
            });
        // FUNCTION FOR CONVERT DATE FORMAT
            function DatePickerFormat(inputdate){
                var string  = inputdate.split("-");
                return string[2]+'-'+ string[1]+'-'+string[0];
            }
        // FUNCTION FOR LOAD INITIAL DATA
            function UT_refreshSuccess(UT_response)
            {
                $(".preloader").hide();
                UT_errorarray=UT_response.UT_errormsg;
                UT_types_array=UT_response.UT_unitno;
                if(UT_types_array.length==0){
                    $('#UT_form_termination').replaceWith('<form id="UT_form_termination" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="errormsg"> '+UT_errorarray[3].EMC_DATA+'</label></div></fieldset></div></form>');
                }
                else{
                    var UT_options ='<option>SELECT</option>';
                    for (var i = 0; i < UT_types_array.length; i++)
                    {
                        UT_options += '<option value="' + UT_types_array[i]  + '">' + UT_types_array[i] + '</option>';
                    }
                    $('#UT_lb_unitnumber').html(UT_options);
                    $("#UT_form_termination").show();
                    $('#UT_lb_unitnumber').focus();
                }
            }
        // CHANGE EVENT FUNCTION FOR UNIT NUMBER
            $("#UT_lb_unitnumber").change(function(){
                if($('#UT_lb_unitnumber').val()!='SELECT')
                {
                    $(".preloader").show();
                    var UT_unitnumber=$('#UT_lb_unitnumber').val();
                    $("#UT_div_form").hide();
                    $("#UT_btn_terminate").attr("disabled", "disabled");
                    $.ajax({
                        type: "POST",
                        url: ctrl_unittermination_url+'/UT_unitdetails',
                        data: {'UT_unitnumber':UT_unitnumber,'UT_flag_select':'UT_flag_select'},
                        success: function(unitdata) {
                            var unitdata_values=JSON.parse(unitdata);
                            UT_selectSuccess(unitdata_values);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("UNIT TERMINATION",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                else
                {
                    $("#UT_div_form").hide();
                }
            });
        // SUCCESS FUNTION FOR UNIT DETAILS
            function UT_selectSuccess(UT_response)
            {
                $(".preloader").hide();
                var UT_startdate=DatePickerFormat(UT_response.UT_sdate);
                var UT_enddate=DatePickerFormat(UT_response.UT_edate);
                var UT_rental=UT_response.UT_rent;
                var UT_comments=UT_response.UT_comment;
                if((UT_startdate!='')&&(UT_enddate!='')&&(UT_rental!=''))
                {
                    $("#UT_div_form").show();
                    $("#UT_db_startdate").val(UT_startdate);
                    $("#UT_db_enddate").val(UT_enddate);
                    $("#UT_tb_unitrental").val(UT_rental);
                    $("#UT_ta_comments").val(UT_comments);
                    $("#UT_btn_terminate").removeAttr("disabled");
                    $('#UT_ta_comments').focus();
                }
            }
        // CLICK FUNCTION FOR UPDATION
            $("#UT_btn_terminate").click(function(event){
                event.stopPropagation();
                event.preventDefault();
                event.stopImmediatePropagation();
                $(".preloader").show();
                var UT_unitnumber=$('#UT_lb_unitnumber').val();
                $.ajax({
                    type: "POST",
                    url: ctrl_unittermination_url+'/UT_unitdetails',
                    data: {'UT_unitnumber':UT_unitnumber,'UT_flag_select':'UT_flag_check','UT_comments':$('#UT_ta_comments').val()},
                    success: function(unitvaldata){
                        var data_values=JSON.parse(unitvaldata);
                        UT_checkSuccess(data_values);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("UNIT TERMINATION",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            });
        // SUCCESS FUNTION FOR UNIT DETAILS
            function UT_checkSuccess(UT_response){
                $(".preloader").hide();
                if(UT_response.UT_UPDCODE_obj_flag==1)
                {
                    var UT_unitnumber= $("#UT_lb_unitnumber").val();
                    var UT_errmsg =UT_errorarray[0].EMC_DATA.replace('[UNITNO]',UT_unitnumber);
                    if(UT_response.UT_UPDCODE_unitno_obj.length==0){
                        $('#UT_form_termination').replaceWith('<form id="UT_form_termination" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="col-sm-12 errormsg"> '+UT_errorarray[3].EMC_DATA+'</label></div></fieldset></div></form>');
                    }
                    else{
                        var UT_options ='<option>SELECT</option>';
                        for (var i = 0; i < UT_response.UT_UPDCODE_unitno_obj.length; i++)
                        {
                            UT_options += '<option value="' + UT_response.UT_UPDCODE_unitno_obj[i]  + '">' + UT_response.UT_UPDCODE_unitno_obj[i] + '</option>';
                        }
                        $('#UT_lb_unitnumber').html(UT_options);
                    }
                    show_msgbox("UNIT TERMINATION",UT_errmsg,'success',false);
                    $("#UT_div_form").hide();
                    $('#UT_lb_unitnumber').val('SELECT');
                }
                else if(UT_response.UT_UPDCODE_obj_flag==0)
                {
                    show_msgbox("UNIT TERMINATION",UT_errorarray[1].EMC_DATA,'error',false);
                }
                $('textarea').height(114);
            }
        // CLICK EVENT FUNCTION FOR RESET
            $("#UT_btn_reset").click(function(){
                $("#UT_div_form").hide();
                $('#UT_lb_unitnumber').val('SELECT');
                $('textarea').height(114);
            });
        });
    </script>
</head>
<body>
<div class="container">
<div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
<div class="title text-center"><h4><b>UNIT TERMINATION</b></h4></div>
    <form id="UT_form_termination" name="UT_form_termination" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="UT_unitno">
                    <label class="col-sm-2">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"><select name="UT_lb_unitnumber" id="UT_lb_unitnumber" class="form-control"><option>SELECT</option></select></div>
                </div>
                <div id="UT_div_form" hidden>
                    <div class="form-group" id="UT_startdate">
                        <label class="col-sm-2">START DATE </label>
                        <div class="col-sm-2">
                            <input id="UT_db_startdate" name="UT_db_startdate" type="text" class="form-control" readonly placeholder="Start Date"/>
                        </div>
                    </div>
                    <div class="form-group" id="UT_enddate">
                        <label class="col-sm-2">END DATE </label>
                        <div class="col-sm-2">
                            <input id="UT_db_enddate" name="UT_db_enddate" type="text" class="form-control" readonly placeholder="End Date"/>
                        </div>
                    </div>
                    <div class="form-group" id="UT_unitrent">
                        <label class="col-sm-2">UNIT RENTAL </label>
                        <div class="col-sm-2"><input type="text" name="UT_tb_unitrental" id="UT_tb_unitrental" readonly class="form-control" placeholder="Unit Rental"></div>
                    </div>
                    <div class="form-group" id="UT_comments">
                        <label class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea name="UT_ta_comments" id="UT_ta_comments" placeholder="Comments" style="height: 114px" rows="5" class="form-control"></textarea></div>
                    </div>
                    <div class="form-group" id="UT_buttons">
                        <div class="col-sm-offset-1 col-sm-4">
                            <input class="maxbtn" type="button" id="UT_btn_terminate" name="submit" value="TERMINATE" disabled/>
                            <input class="maxbtn" type="button" id="UT_btn_reset" name="RESET" value="RESET"/>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>