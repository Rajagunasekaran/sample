<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE*******************************//
//DONE BY SARADA
//VER 0.02-SD:08/06/2015 ED:08/06/2015 CHANGED ALL CTRL,MODEL,VIEW FILE NAME AND GET USERSTAMP AND TIME ZONE FROM EILIB
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:18/05/2015 ED:18/05/2015
//************************************************************************************************************-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <style>
        textarea{
            resize: none;
            overflow: hidden;
        }
    </style>
    <script>
    var value_err_array=[];
        var ET_SRC_UPD_DEL_result_array=[];
        var ET_SRC_UPD_DEL_name;
        var listboxoption;
        var ErrorControl={'cpferror':null};
    //SEARCH FORM
    var STDTL_SEARCH_sucsval=0;
    var ErrorControl={AmountCompare:'InValid'}
    var STDTL_SEARCH_result_array=[];
    var STDTL_SEARCH_commnts='';
    var validate_flag=0;
    //READY FUNCTION START
    $(document).ready(function() {
        var SCTDTL_SEARH_controller_url="<?php echo base_url(); ?>" + '/index.php/EXPENSE/STAFF/Ctrl_Staff_Detail_Entry_Search_Update_Delete/' ;
        $('#spacewidth').height('0%');
        $(".preloader").hide();
        $('#SCTDTL_SEARH_lb_cpfnumber_listbox').hide();
        $('#STDTL_SEARCH_lb_employeename_listbox').hide();
        var STDTL_INPUT_expensearr_employeename=[];
        var EP_SRC_UPD_DEL_namearray=[];
        var STDTL_INPUT_expensearr_employeefirstname=[];
        var STDTL_INPUT_expensearr_employeelastname=[];
        var STDTL_INPUT_expensearr_employeeid=[];
        var STDTL_INPUT_names_concat=[];
        var STDTL_INPUT_expensearr_employeename=[];
        var STDTL_INPUT_expensearr_searchbydata=[];
        var STDTL_INPUT_expensearr_searchbyid=[];
        var STDTL_INPUT_idarray=[];
        //SEARCH FORM
        var cpfno=[];
        var STDTL_INPUT_expensearr_empfirstname=[];
        var STDTL_INPUT_expensearr_emplastname=[];
        //JQUERY LIB VALIDATION START
        $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
        $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $(".alphanumeric").doValidation({rule:'alphanumeric',prop:{realpart:9}});
        $('textarea').autogrow({onInitialize: true});
        $("#STDTL_SEARCH_tb_fromamt").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2,smallerthan:'STDTL_SEARCH_tb_toamt'}});
        $("#STDTL_SEARCH_tb_toamt").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2,greaterthan:'STDTL_SEARCH_tb_fromamt'}});
        //JQUERY LIB VALIDATION END
        STDTL_SEARCH_comments_auto()
        var STDTL_SEARCH_comments=[];
        //FUNCTION TO AUTOCOMPLETE SEARCH TEXT
        function STDTL_SEARCH_comments_auto()
        {
            $.ajax({
                type: "POST",
                url:SCTDTL_SEARH_controller_url+"STDTL_SEARCH_comments",
                success: function(data){
                    $('.preloader').hide();
                    $('#STDTL_SEARCH_div_headernodata').hide();
                    STDTL_SEARCH_comments=JSON.parse(data);
                },error:function(data){
                    alert(JSON.parse(data))
                }
            });
        }
        //AUTO COMPLETE START
        //FUNCTION TO HIGHLIGHT SEARCH TEXT
        function STDTL_SEARCH_highlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            };
        }
        $("#STDTL_SEARCH_ta_comments").keypress(function(){
            STDTL_SEARCH_chkflag=0;
            STDTL_SEARCH_highlightSearchText();
            $( "#STDTL_SEARCH_ta_comments").autocomplete({
                source:STDTL_SEARCH_comments,
                select:STDTL_SEARCH_AutoCompleteSelectHandler
            });
        });
        //CHANGE FUNCTION FOR COMMENTS
        var STDTL_SEARCH_chkflag;
        $(document).on('change','.commentsresultsvalidate',function(){
            $('#STDTL_SEARCH_div_headernodata').hide();
            var STDTL_SEARCH_staffcomments=$("#STDTL_SEARCH_btn_search_comments").val();
            var STDTL_SEARCH_staffcommentstxt=$('#STDTL_SEARCH_ta_comments').val();
            var STDTL_SEARCH_errormsg=value_err_array[2].EMC_DATA.replace('[COMMENTS]',STDTL_SEARCH_staffcommentstxt);
            if(STDTL_SEARCH_chkflag==1){
                $('#STDTL_SEARCH_div_headernodata').hide();
            }
            else
            {
                $('#STDTL_SEARCH_div_headernodata').text(STDTL_SEARCH_errormsg).show();
                $('#STDTL_SEARCH_tble_htmltable').hide();
                $('#STDTL_SEARCH_div_header').hide();
                $("#STDTL_SEARCH_btn_search_comments").attr("disabled","disabled");
            }
            if($('#STDTL_SEARCH_ta_comments').val()=="")
            {
                $('#STDTL_SEARCH_div_headernodata').hide();
                $('#STDTL_SEARCH_div_header').hide();
                $('#STDTL_SEARCH_tble_htmltable').hide();
                $('#STDTL_SEARCH_div_update').hide();
                $('#STDTL_SEARCH_tble_srchupd').hide();
            }
        });
        //FUNCTION TO GET SELECTED VALUE
        function STDTL_SEARCH_AutoCompleteSelectHandler(event, ui) {
            STDTL_SEARCH_chkflag=1;
            $('#STDTL_SEARCH_div_headernodata').hide();
            $('#STDTL_SEARCH_btn_search_comments').removeAttr("disabled");
        }
        //AUTO COMPLETE END
        //CHANGE E  VENT FUNCTION FOR STAFF COMMENTS
        $('#STDTL_SEARCH_btn_search_comments').click(function(){
            $('.preloader').show();
            STDTL_SEARCH_sucsval=0;
            $('#STDTL_SEARCH_div_header').hide();
            $('#STDTL_SEARCH_div_headernodata').hide();
            $('#STDTL_SEARCH_lbl_validamount').hide();
            $('#STDTL_SEARCH_lbl_validnumber').hide();
            $('#STDTL_SEARCH_tble_srchupd').hide();
            $("#STDTL_SEARCH_tb_updcpfnumber").removeClass('invalid')
            $("#STDTL_SEARCH_tb_updcpfamount").removeClass('invalid')
            var STDTL_SEARCH_staffcommentstxt=$('#STDTL_SEARCH_ta_comments').val();
            var STDTL_SEARCH_errormsg=value_err_array[3].EMC_DATA.replace(' [COMMENTS]',STDTL_SEARCH_staffcommentstxt);
            $('#STDTL_SEARCH_div_header').text(STDTL_SEARCH_errormsg).show();
            $('#STDTL_SEARCH_div_headernodata').hide();
            $('#STDTL_SEARCH_tble_srchupd').hide();
            $('#STDTL_SEARCH_div_update').hide();
            $('#STDTL_SEARCH_tble_htmltable').hide();
            if(STDTL_SEARCH_staffcommentstxt!="")
            {
                var  newPos= adjustPosition($(this).position(),100,270);
                resetPreloader(newPos);
                STDTL_SEARCH_srch_result()
            }
        });
        // INITIAL DATA LODING
        $.ajax({
            type: "POST",
            url:SCTDTL_SEARH_controller_url+"Initaildatas",
            data:{"Formname":'EmailTemplateSearchUpdate',"ErrorList":'45,60,71,72,128,135,136,137,145,146,147,170,171,172,173,239,240,241,314,315,375,400,401,446'},
            success: function(data){
                $('.preloader').hide();
                value_err_array=JSON.parse(data);
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
        //LIST BOX ITEM CHANGE FUNCTION
        $('.STDTL_rd_selectform').click(function(){
            $(".preloader").show();
            listboxoption=$(this).val();
            $('#ET_ENTRY_ta_subject').val('');
            $('#CONFIG_SRCH_UPD_div_htmltable').hide();
            $('#CONFIG_SRCH_UPD_div_header').hide();
            $("#STDTL_INPUT_lb_employeename").hide();
            $("#STDTL_INPUT_lbl_employeename").hide();
            $("#CONFIG_ENTRY_tr_type").hide();
            $("#CONFIG_ENTRY_tr_data").hide();
            $("#CONFIG_ENTRY_tr_btn").hide();
            $('#STDTL_INPUT_noform').hide();
            $('#STDTL_SEARCH_div_pdf').hide();
            if(listboxoption=='STAFF ENTRY')
            {
                $(".preloader").hide();
                $('#ET_SRC_UPD_DEL_tble_htmltable').hide();
                $('section').html('');
                $('#STDTL_SEARCH_div_header').hide();
                $('#STDTL_SEARCH_div_headernodata').hide();
                $('#searchfrm').hide();
                $('#STDTL_SEARCH_lbl_searchoptionheader').hide();
                $('#STDTL_SEARCH_tble_amt_option').hide();
                $('#STDTL_SEARCH_ta_comments').val('');
                $('#STDTL_SEARCH_tble_comments_option').hide();
            }
            else if(listboxoption=='STAFF SEARCH/UPDATE')
            {
                $(".preloader").hide();
                $("#enrtyfrm").hide();
                $("#STDTL_INPUT_lb_employeename").val('SELECT').show();
                $("#STDTL_INPUT_lbl_employeename").show();
                $('#STDTL_SEARCH_lbl_cpfnumber_listbox').val('').hide();
                $('#STDTL_SEARCH_lbl_employeename_listbox').val('').hide();
                $('#STDTL_SEARCH_lb_cpfnumber_listbox').val('').hide();
                $("#STDTL_SEARCH_lb_employeename_listbox").hide();
                $('#STDTL_INPUT_tb_cpfnumber').val('');
                $('#STDTL_INPUT_tb_cpfamount').val('');
                $('#STDTL_INPUT_tb_levyamount').val('');
                $('#STDTL_INPUT_tb_salaryamount').val('');
                $('#STDTL_INPUT_ta_comments').val('');
                $("textarea").height(114);
                $('#STDTL_SEARCH_btn_search_comments').hide();
            }
        });
        //FUNCTION FOR UNIQUE NAME AND ID
        function unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
        // radio click function
        var CONFIG_ENTRY_searchby=$('.STDTL_rd_selectform').val();
        $(document).on('click','.STDTL_rd_selectform',function(){
            $('.preloader').show();
            STDTL_INPUT_idarray=[];
            var STDTL_INPUT_data=$(this).val();
            $.ajax({
                type: "POST",
                url:SCTDTL_SEARH_controller_url+"STDTL_INPUT_getempname",
                data :{'STDTL_INPUT_searchby':STDTL_INPUT_data},
                success: function(data){
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    $('.preloader').hide();
                     STDTL_INPUT_expensearr_employeename=JSON.parse(data);
                    if(STDTL_INPUT_data=='STAFF ENTRY')
                    {
                        if(STDTL_INPUT_expensearr_employeename[0].length!=0){
                            var STDTL_INPUT_namearray=[];
                            for(var k=0;k<STDTL_INPUT_expensearr_employeename[0].length;k++)
                            {
                                STDTL_INPUT_namearray.push(STDTL_INPUT_expensearr_employeename[0][k].STDTL_INPUT_names_concat)
                                STDTL_INPUT_idarray.push(STDTL_INPUT_expensearr_employeename[0][k].EMP_ID)
                            }
                            STDTL_INPUT_namearray=unique(STDTL_INPUT_namearray);
                            var STDTL_INPUT_expensearray_employeename='<option value="SELECT">SELECT</option>';
                            for (var i = 0;i< STDTL_INPUT_namearray.length; i++)
                            {
                                var STDTL_INPUT_employeenameconcat=STDTL_INPUT_namearray[i].split("_");
                                STDTL_INPUT_expensearray_employeename += '<option value="' + STDTL_INPUT_idarray[i] + '">' + STDTL_INPUT_employeenameconcat[0]+" "+STDTL_INPUT_employeenameconcat[1]+ '</option>';
                            }
                            $('#STDTL_INPUT_lb_employeename').html(STDTL_INPUT_expensearray_employeename).show();
                            $('#STDTL_INPUT_lbl_employeename').show();
                            $("#enrtyfrm").show();
                        }
                        else
                        {
                            $('#STDTL_INPUT_lb_employeename').hide();
                            $('#STDTL_INPUT_lbl_employeename').hide();
                            $("#enrtyfrm").hide();
                            $('#STDTL_INPUT_noform').text(value_err_array[18].EMC_DATA).show();
                        }
                    }
                    else
                    {
                        if(STDTL_INPUT_expensearr_employeename[0].length!=0){
                           //SEARCH FORM SEARCH BY LIST
                            STDTL_INPUT_expensearr_searchbydata=STDTL_INPUT_expensearr_employeename[0][0].ECN_DATA
                            STDTL_INPUT_expensearr_searchbyid=STDTL_INPUT_expensearr_employeename[0][0].ECN_ID
                            var STDTL_SEARCH_searchoptions='<option>SELECT</option>';
                            for (var i = 0;i < STDTL_INPUT_expensearr_employeename[0].length; i++)
                            {
                                STDTL_SEARCH_searchoptions+='<option value="'+STDTL_INPUT_expensearr_employeename[0][i].ECN_ID+'">'+STDTL_INPUT_expensearr_employeename[0][i].ECN_DATA+'</option>';
                            }
                            $('#STDTL_SEARCH_lb_searchoption').html(STDTL_SEARCH_searchoptions).show();
                            $('#STDTL_SEARCH_lbl_searchoption').show();
                            $('#searchfrm').show();
                        }
                        else
                        {
                            $('#STDTL_INPUT_noform').text(value_err_array[4].EMC_DATA).show();
                            $('#STDTL_SEARCH_lb_searchoption').hide();
                            $('#STDTL_SEARCH_lbl_searchoption').hide();
                        }
                    }
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        });
        //GET EMPLOYEE ID FOR THE SELECTED EMPLOYEE NAME
        $('#STDTL_INPUT_lb_employeename').change(function(){
            $(".preloader").show();
            var STDTL_INPUT_name=$('#STDTL_INPUT_lb_employeename').find('option:selected').text();
            $("#STDTL_INPUT_lbl_cpfamount").hide();
            $("#STDTL_INPUT_tb_cpfamount").hide();
            $('#STDTL_INPUT_lbl_validamount').hide();
            $('#STDTL_INPUT_lbl_validnumber').hide();
            $("#STDTL_INPUT_lbl_cpfamount").hide();
            $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid')
            $("#STDTL_INPUT_tb_cpfnumber").removeClass('invalid')
            $("#STDTL_INPUT_tb_cpfnumber").val('');
            $("#STDTL_INPUT_tb_cpfamount").val('');
            $("#STDTL_INPUT_tb_levyamount").val('');
            $("#STDTL_INPUT_tb_salaryamount").val('');
            $("#STDTL_INPUT_ta_comments").val('');
            $('#STDTL_INPUT_tble_employid').empty();
            $("#STDTL_INPUT_btn_save").attr("disabled","disabled");
            var STDTL_INPUT_lb_employeename=$('#STDTL_INPUT_lb_employeename').val();
            if(STDTL_INPUT_lb_employeename!='')
            {
                $("#enrtyfrm").show();
                var STDTL_INPUT_eid=[];
                for(var k=0;k<STDTL_INPUT_idarray.length;k++)
                {
                    var final=STDTL_INPUT_expensearr_employeename[0][k].STDTL_INPUT_names_concat.split('_');
                    var first=final[0]+' '+final[1];
                    if(first==STDTL_INPUT_name)
                    {
                        STDTL_INPUT_eid.push(STDTL_INPUT_idarray[k]);
                    }
                }
                STDTL_INPUT_eid=unique(STDTL_INPUT_eid);
                if(STDTL_INPUT_eid.length!=1){
                    $(".preloader").hide();
                    $('#STDTL_INPUT_tble_employid').show();
                    var STDTL_INPUT_radio_value='';
                    for (var i = 0; i < STDTL_INPUT_eid.length; i++) {
                        var STDTL_INPUT_final=STDTL_INPUT_name+' '+STDTL_INPUT_eid[i]
                        STDTL_INPUT_radio_value = ' <div  class="col-sm-offset-2" style="padding-left:15px" id="employid"><div class="radio"><label><input type="radio" name="STDTL_INPUT_radioemployid" id='+STDTL_INPUT_eid[i]+' value='+STDTL_INPUT_eid[i]+' class="STDTL_INPUT_class_employid" />' + STDTL_INPUT_final + '</label></div></div>';
                        $('#STDTL_INPUT_tble_employid').append(STDTL_INPUT_radio_value);
                        $('#STDTL_INPUT_div_employid').show();
                    }
                }
                else
                {
                    $(".preloader").hide();
                    $('#STDTL_INPUT_hidden_employid').val(STDTL_INPUT_eid[0]);
                    $('#STDTL_INPUT_div_employid').hide();
                    $('#STDTL_INPUT_tble_employid').hide();
                    $('#STDTL_INPUT_tble_employid').empty();
                    $("#enrtyfrm").show();
                }
            }
            else
            {
                $(".preloader").hide();
                $('#STDTL_INPUT_div_employid').hide();
                $('#STDTL_INPUT_tble_employid').hide();
                $('#STDTL_INPUT_tble_employid').empty();
            }
        });
        //CHANGE FUNCTION FOR CPF NUMBER
        $("#STDTL_INPUT_tb_cpfnumber").change(function(){
            $("#STDTL_INPUT_btn_save").attr("disabled","disabled");
            var STDTL_INPUT_cpfnumber=$(this).val();
            var STDTL_INPUT_CpfNo=$("#STDTL_INPUT_tb_cpfnumber").val();
            if(STDTL_INPUT_CpfNo=='')
            {
                $("#STDTL_INPUT_lbl_cpfamount").hide();
                $("#STDTL_INPUT_tb_cpfamount").val("").hide();
                $('#STDTL_INPUT_lbl_validamount').hide();
            }
            else
            {
                $("#STDTL_INPUT_lbl_cpfamount").show();
                $("#STDTL_INPUT_tb_cpfamount").show();
            }
        });
        var flagSubmitCpf=1;var flagTotal=1;
        var flagSubmit=1;
        $(document).on('change blur','.submitValidation',function(){
            var STDTL_INPUT_Empname=$("#STDTL_INPUT_lb_employeename").val();
            var STDTL_INPUT_CpfNo=$("#STDTL_INPUT_tb_cpfnumber").val();
            var STDTL_INPUT_Salamt=$("#STDTL_INPUT_tb_salaryamount").val();

            if( $("#STDTL_INPUT_tb_cpfamount").val()!='' ){
                flagSubmitCpf=1;
            $('#STDTL_INPUT_lbl_validamount').hide();
            $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid');}

            if(STDTL_INPUT_Empname!='' && STDTL_INPUT_Salamt!='' && (parseFloat($('#STDTL_INPUT_tb_salaryamount').val())!=0) && flagSubmit==1 && flagSubmitCpf==1)
                $("#STDTL_INPUT_btn_save").removeAttr("disabled");
            else
                $("#STDTL_INPUT_btn_save").attr("disabled","disabled");
        });
        //EMPLOYEE SAVE BUTTON VALIDATION
        $("#STDTL_INPUT_tb_cpfnumber").blur(function(){
            var STDTL_INPUT_Empname=$("#STDTL_INPUT_lb_employeename").val();
            var STDTL_INPUT_CpfNo=$("#STDTL_INPUT_tb_cpfnumber").val();
            var STDTL_INPUT_Salamt=$("#STDTL_INPUT_tb_salaryamount").val();
            $("#STDTL_INPUT_btn_save").attr("disabled","disabled");
            $('#STDTL_INPUT_lbl_validamount').hide();
            if(STDTL_INPUT_CpfNo.length==9)
            {
                var  newPos= adjustPosition($(this).position(),100,220);
                resetPreloader(newPos);
                $('#STDTL_INPUT_lbl_validamount').hide();
                STDTL_INPUT_already_result()
                $('#STDTL_INPUT_lbl_validnumber').hide();
            }
            else
            {
                if(STDTL_INPUT_CpfNo.length>0 && STDTL_INPUT_CpfNo.length<9)
                {
                    flagSubmit=0;
                    $("#STDTL_INPUT_lbl_cpfamount").hide();
                    $("#STDTL_INPUT_tb_cpfamount").hide();
                    $('#STDTL_INPUT_lbl_validnumber').text(value_err_array[12].EMC_DATA).show();
                    $(this).addClass('invalid');
                    $('#STDTL_INPUT_lbl_validamount').hide();
                    $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid');
                }
                else
                {
                    flagSubmit=1;
                    if(STDTL_INPUT_Empname!='' && STDTL_INPUT_Salamt!='' && (parseFloat($('#STDTL_INPUT_tb_salaryamount').val())!=0))
                        $("#STDTL_INPUT_btn_save").removeAttr("disabled");
                    else
                        $("#STDTL_INPUT_btn_save").attr("disabled","disabled");
                    $('#STDTL_INPUT_lbl_validnumber').hide();
                    $(this).removeClass('invalid');
                    $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid');
                    $('#STDTL_INPUT_lbl_validamount').hide();
                }
            }
        });
        //SUCCESS FUNCTION FOR ALREADY EXIST FOR SCRIPT NAME
        function STDTL_INPUT_already_result()
        {
            $(".preloader").show();
            var STDTL_INPUT_Cpfno=$('#STDTL_INPUT_tb_cpfnumber').val();
            var STDTL_INPUT_Empname=$("#STDTL_INPUT_lb_employeename").val();
            var STDTL_INPUT_Salamt=$("#STDTL_INPUT_tb_salaryamount").val();
            var STDTL_INPUT_Cpfamt=$("#STDTL_INPUT_tb_cpfamount").val();
            $.ajax({
                type: "POST",
                url:SCTDTL_SEARH_controller_url+"STDTL_INPUT_already",
                data: {'STDTL_INPUT_Cpfno': STDTL_INPUT_Cpfno},
                success: function(data) {
                    var response=JSON.parse(data.script_name_already_exits_array)//retdata.final_array[0];
                    $(".preloader").hide();
                    if(response==0)
                    {flagSubmit=1;flagSubmitCpf=0;
                        $('#STDTL_INPUT_lbl_validnumber').hide();
                        $("#STDTL_INPUT_tb_cpfnumber").removeClass('invalid');
                        $("#STDTL_INPUT_lbl_cpfamount").show();
                        $("#STDTL_INPUT_tb_cpfamount").show();
                        $('#STDTL_INPUT_lbl_validamount').text(value_err_array[17].EMC_DATA).show();
                        if(STDTL_INPUT_Cpfamt=='')
                        {
                            $("#STDTL_INPUT_tb_cpfamount").addClass('invalid');
                            ErrorControl.cpferror='Valid';
                        }
                        else
                        {
                            flagSubmit=1;
                            if(STDTL_INPUT_Empname!='' && STDTL_INPUT_Salamt!='' && (parseFloat($('#STDTL_INPUT_tb_salaryamount').val())!=0))
                                $("#STDTL_INPUT_btn_save").removeAttr("disabled");
                            $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid');
                            $('#STDTL_INPUT_lbl_validamount').hide();
                            $('#STDTL_INPUT_lbl_validnumber').hide();
                                                                ErrorControl.cpferror='Valid';
                        }
                    }
                    else if(response!=0)
                    {flagSubmit=0;
                        $(".preloader").hide();
                        $("#STDTL_INPUT_tb_cpfnumber").addClass('invalid');
                        $('#STDTL_INPUT_lbl_validnumber').text(value_err_array[16].EMC_DATA).show();
                        $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid');
                        $('#STDTL_INPUT_lbl_validamount').hide();
                        ErrorControl.cpferror='InValid';
                    }
                },
                error: function(data) {
                    $(".preloader").hide();
                }
             });
        }
        //CHANGE FUNCTION FOR CPF NUMBER
        $("#STDTL_INPUT_tb_cpfnumber").change(function(){
            $("#STDTL_INPUT_btn_save").attr("disabled","disabled");
            var STDTL_INPUT_cpfnumber=$(this).val();
            var STDTL_INPUT_CpfNo=$("#STDTL_INPUT_tb_cpfnumber").val();
            if(STDTL_INPUT_CpfNo=='')
            {
                $("#STDTL_INPUT_lbl_cpfamount").hide();
                $("#STDTL_INPUT_tb_cpfamount").val("").hide();
                $('#STDTL_INPUT_lbl_validamount').hide();
            }
            else
            {
                $("#STDTL_INPUT_lbl_cpfamount").show();
                $("#STDTL_INPUT_tb_cpfamount").show();
            }
        });
        //SAVE BUTTON VALIDATION
        $(document).on('change','input:not(#STDTL_INPUT_tb_cpfnumber),select', function(){
            var STDTL_INPUT_radioemployid_val=$("input:radio[name=STDTL_INPUT_radioemployid]").is(":checked");
            var STDTL_INPUT_currentid=$(this).attr('id');
            var STDTL_INPUT_Empname=$("#STDTL_INPUT_lb_employeename").val();
            var STDTL_INPUT_Salamt=$("#STDTL_INPUT_tb_salaryamount").val();
            var STDTL_INPUT_CpfNo=$("#STDTL_INPUT_tb_cpfnumber").val();
            var STDTL_INPUT_Cpfamt=$("#STDTL_INPUT_tb_cpfamount").val();
            $("input:radio[name=STDTL_INPUT_radioemployid]").is(":checked")
            if((STDTL_INPUT_Empname!=''&& STDTL_INPUT_Salamt!='' && (parseFloat($('#STDTL_INPUT_tb_salaryamount').val())!=0))&&(STDTL_INPUT_CpfNo==''))
            {
                $('#STDTL_INPUT_lbl_validamount').hide();
                $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid');
                if($('.STDTL_INPUT_class_employid').length>0)
                {
                    if(STDTL_INPUT_radioemployid_val)
                    {
                        $("#STDTL_INPUT_btn_save").removeAttr("disabled");
                    }
                }
                else
                {
                    $("#STDTL_INPUT_btn_save").removeAttr("disabled");
                    $('#STDTL_INPUT_lbl_validnumber').hide();
                }
            }
            else if((STDTL_INPUT_Empname!='' && STDTL_INPUT_Salamt!='' && (parseFloat($('#STDTL_INPUT_tb_salaryamount').val())!=0)) && (STDTL_INPUT_CpfNo.length==9))
            {
                if(ErrorControl.cpferror=='Valid'&& STDTL_INPUT_Cpfamt!='' && (parseFloat($('#STDTL_SEARCH_tb_updsalaryamount').val())!=0) && (parseFloat($('#STDTL_INPUT_tb_cpfamount').val())!=0))
                {
                    if($('.STDTL_INPUT_class_employid').length>0)
                    {
                        if(STDTL_INPUT_radioemployid_val)
                        {
                            $("#STDTL_INPUT_btn_save").removeAttr("disabled");
                        }
                        else
                        {
                            $("#STDTL_INPUT_btn_save").removeAttr("disabled");
                        }
                    }
                    else
                    {
                        $("#STDTL_INPUT_btn_save").removeAttr("disabled");
                        $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid');
                        $('#STDTL_INPUT_lbl_validamount').hide();
                    }
                }
                else
                {
                    $("#STDTL_INPUT_tb_cpfamount").addClass('invalid');
                    $('#STDTL_INPUT_lbl_validamount').show();
                    $("#STDTL_INPUT_btn_save").attr("disabled","disabled");
                }
            }
            else if((STDTL_INPUT_Empname!='' && STDTL_INPUT_Salamt!='' && (parseFloat($('#STDTL_INPUT_tb_salaryamount').val())!=0)) && (STDTL_INPUT_CpfNo.length!=9))
            {
                if(STDTL_INPUT_CpfNo.length>0)
                {
                    $("#STDTL_INPUT_btn_save").attr("disabled","disabled");
                }
                else if(STDTL_INPUT_CpfNo.length==0 && STDTL_INPUT_radioemployid_val!=false)
                {
                    $("#STDTL_INPUT_btn_save").removeAttr("disabled");
                }
            }
            else
            {
                $("#STDTL_INPUT_btn_save").attr("disabled","disabled");
            }
            if(STDTL_INPUT_Cpfamt!='' && (parseFloat($('#STDTL_INPUT_tb_cpfamount').val())!=0) && STDTL_INPUT_CpfNo.length==9)
            {
                $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid');
                $('#STDTL_INPUT_lbl_validamount').hide();
            }
        });
        //CLICK EVENT FOR SAVE BUTTON
        $("#STDTL_INPUT_btn_save").click(function(){
            var  newPos= adjustPosition($(this).position(),100,280);
            resetPreloader(newPos);
            $(".preloader").show();
            var STDTL_INPUT_employeenameid=$('#STDTL_INPUT_lb_employeename').val();
            STDTL_INPUT_save_result()
        });
        function STDTL_INPUT_save_result(){
            $(".preloader").show();
            var STDTL_INPUT_employeenameid=$('#STDTL_INPUT_lb_employeename').val();
            var STDTL_INPUT_cpfnumber=$('#STDTL_INPUT_tb_cpfnumber').val();
            var STDTL_INPUT_cpfamount=$('#STDTL_INPUT_tb_cpfamount').val();
            var STDTL_INPUT_levyamount=$('#STDTL_INPUT_tb_levyamount').val();
            var STDTL_INPUT_salaryamount=$('#STDTL_INPUT_tb_salaryamount').val();
            var STDTL_INPUT_comments=$('#STDTL_INPUT_ta_comments').val();
            var STDTL_INPUT_radioemployid=$('input:radio[name=STDTL_INPUT_radioemployid]:checked').attr('id');
            $.ajax({
                type: "POST",
                url:SCTDTL_SEARH_controller_url+"STDTL_INPUT_save",
                data: {'STDTL_INPUT_radioemployid':STDTL_INPUT_radioemployid,'STDTL_INPUT_employeenameid': STDTL_INPUT_employeenameid,'STDTL_INPUT_cpfnumber': STDTL_INPUT_cpfnumber,'STDTL_INPUT_cpfamount': STDTL_INPUT_cpfamount,'STDTL_INPUT_levyamount': STDTL_INPUT_levyamount,'STDTL_INPUT_salaryamount': STDTL_INPUT_salaryamount,'STDTL_INPUT_comments': STDTL_INPUT_comments},
                success: function(data) {
                    $(".preloader").hide();
                    var result_value=JSON.parse(data.final_array);//retdata.final_array[0];
                    if(result_value==true)
                    {
                        $('input:radio[name=optradio]').attr('checked',false);
                        //MESSAGE BOX FOR SAVED SUCCESS
                        show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[15].EMC_DATA,"error",false)
                        var STDTL_INPUT_employeename=$('#STDTL_INPUT_lb_employeename').val();
                        $('#enrtyfrm').hide();
                        STDTL_INPUT_employeedetailrset();
                    }
                    else
                    {
                        //MESSAGE BOX FOR NOT SAVED
                        show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[5].EMC_DATA,"error",false)
                    }
                },
                error: function(data) {
                    $(".preloader").hide();
                    show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",JSON.parse(data),"error",false)
                }
            });
        }
        //CLICK EVENT FUCNTION FOR RESET
        $('#STDTL_INPUT_btn_reset').click(function()
        {
            STDTL_INPUT_employeedetailrset()
        });
        //CLEAR ALL FIELDS
        function STDTL_INPUT_employeedetailrset()
        {
            $('STDTL_INPUT_lb_employeename').prop('selectedIndex',0);
            $('#STDTL_SEARCH_lbl_cpfnumber_listbox').val('').hide();
            $('#STDTL_SEARCH_lbl_employeename_listbox').val('').hide();
            $('#STDTL_SEARCH_lb_cpfnumber_listbox').val('').hide();
            $("#STDTL_SEARCH_lb_employeename_listbox").hide();
            $('#STDTL_INPUT_tb_cpfnumber').val('');
            $('#STDTL_INPUT_tb_cpfamount').val('');
            $('#STDTL_INPUT_tb_levyamount').val('');
            $('#STDTL_INPUT_tb_salaryamount').val('');
            $('#STDTL_INPUT_ta_comments').val('');
            $('#STDTL_INPUT_lbl_validamount').hide();
            $('#STDTL_INPUT_lbl_validnumber').hide();
            $('#STDTL_INPUT_tble_employid').hide();
            $("#STDTL_INPUT_lbl_cpfamount").hide();
            $("#STDTL_INPUT_tb_cpfamount").hide();
            $("textarea").height(114);
            $("#STDTL_INPUT_tb_cpfamount").removeClass('invalid');
            $("#STDTL_INPUT_tb_cpfnumber").removeClass('invalid');
            $("#STDTL_INPUT_btn_save").attr("disabled", "disabled");
            $('STDTL_INPUT_lb_employeename').prop('selectedIndex',0);
            $('input:radio[name=STDTL_INPUT_radioemployid]:not(.STDTL_rd_selectform)').attr('checked',false);
        }
        //SEARCH FORM CODING START
        //CHANGE EVENT FUNCTION FOR SEARCH OPTION
        $('#STDTL_SEARCH_lb_searchoption').change(function(){
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            STDTL_SEARCH_sucsval=0;
            $('section').html('');
            STDTL_SEARCH_comments_auto()
            $('#STDTL_SEARCH_div_pdf').hide();
            var STDTL_SEARCH_searchheader=$('#STDTL_SEARCH_lb_searchoption').find('option:selected').text();
            $('#STDTL_SEARCH_lbl_searchoptionheader').text(STDTL_SEARCH_searchheader).show();
            $('textarea').height(114);
            $('#STDTL_SEARCH_tble_htmltable').hide();
            $('section').html('');
            $('#STDTL_SEARCH_lbl_validamount').hide();
            $('#STDTL_SEARCH_lbl_validnumber').hide();
            $('#STDTL_SEARCH_lbl_amounterrormsg').hide();
            $('#STDTL_SEARCH_tble_srchupd').hide();
            $('#STDTL_SEARCH_lb_cpfnumber_listbox').hide();
            $('#STDTL_SEARCH_lbl_cpfnumber_listbox').hide();
            $('#STDTL_SEARCH_lbl_employeename_listbox').hide();
            $('#STDTL_SEARCH_lb_employeename_listbox').hide();
            $('#STDTL_SEARCH_tble_amt_option').hide();
            $('#STDTL_SEARCH_btn_amtsearch').attr("disabled","disabled");//correct one
            $('#STDTL_SEARCH_btn_search_comments').attr("disabled","disabled");
            $("#data").removeClass('invalid')
            $("#STDTL_SEARCH_tb_updcpfamount").removeClass('invalid')
            var STDTL_SEARCH_search_option=$(this).val();
            if(STDTL_SEARCH_search_option=='SELECT')
            {
                $('#STDTL_SEARCH_tble_srchupd').hide();
                $('#STDTL_SEARCH_div_update').hide();
                $('#STDTL_SEARCH_lbl_searchoptionheader').hide();
                $('#STDTL_SEARCH_lbl_amounterrormsg').hide();
                $('#STDTL_SEARCH_div_table').hide();
                $('#STDTL_SEARCH_lb_employeename_listbox').hide();
                $('#STDTL_SEARCH_lbl_employeename_listbox').hide();
                $('#STDTL_SEARCH_lbl_cpfnumber_listbox').hide();
                $('#STDTL_SEARCH_ta_comments').hide();
                $('#STDTL_INPUT_lbl_comments').hide();
                $('#STDTL_SEARCH_tble_comments_option').hide();
                $('#STDTL_SEARCH_btn_search_comments').hide();
                $('#STDTL_SEARCH_div_header').hide();
            }
            else
            {
                if(STDTL_SEARCH_search_option==90)//EMPLOYEE NAME
                {
                    STDTL_SEARCH_sucsval=0;
                    var  newPos= adjustPosition($(this).position(),100,280);
                    resetPreloader(newPos);
                    $(".preloader").show();
                    STDTL_SEARCH_empcpfresult()
                    $('#STDTL_SEARCH_lb_employeename_listbox').val('');
                    $('#STDTL_SEARCH_div_searchbyemploy').show();
                    $('#STDTL_SEARCH_lb_employeename_listbox').show();
                    $('#STDTL_SEARCH_lbl_employeename_listbox').show();
                    $('#STDTL_SEARCH_lb_cpfnumber_listbox').hide();
                    $('#STDTL_SEARCH_lbl_cpfnumber_listbox').hide();
                    var STDTL_SEARCH_searchheader=$('#STDTL_SEARCH_lb_searchoption').find('option:selected').text();
                    $('#STDTL_SEARCH_lbl_searchoptionheader').text(STDTL_SEARCH_searchheader).show();
                    $('#STDTL_SEARCH_div_table').show();
                    $('#STDTL_SEARCH_tble_cpfnumber').hide();
                    $('#STDTL_SEARCH_tble_amt_option').hide();
                    $('#STDTL_SEARCH_div_update').hide();
                    $('#STDTL_SEARCH_tble_srchupd').hide();
                    $('#STDTL_SEARCH_div_header').hide();
                    $('#STDTL_SEARCH_div_headernodata').hide();
                    $('#STDTL_SEARCH_tble_htmltable').hide();
                    $('section').html('');
                    $('#STDTL_SEARCH_tble_comments_option').hide();
                }
                else if(STDTL_SEARCH_search_option==93)//CPF NUMBER
                {
                    STDTL_SEARCH_sucsval=0;
                    var  newPos= adjustPosition($(this).position(),100,280);
                    resetPreloader(newPos);
                    $(".preloader").show();
                    STDTL_SEARCH_empcpfresult()
                    $('#STDTL_SEARCH_lb_cpfnumber_listbox').val('');
                    $('#STDTL_SEARCH_lbl_cpfnumber_listbox').show();
                    $('#STDTL_SEARCH_lbl_employeename_listbox').hide();
                    $('#STDTL_SEARCH_lb_cpfnumber_listbox').show();
                    $('#STDTL_SEARCH_lb_employeename_listbox').hide();
                    var STDTL_SEARCH_searchheader=$('#STDTL_SEARCH_lb_searchoption').find('option:selected').text();
                    $('#STDTL_SEARCH_lbl_searchoptionheader').text(STDTL_SEARCH_searchheader).show();
                    $('#STDTL_SEARCH_div_table').show();
                    $('#STDTL_SEARCH_div_searchbyemploy').hide();
                    $('#STDTL_SEARCH_tble_employee').hide();
                    $('#STDTL_SEARCH_tble_amt_option').hide();
                    $('#STDTL_SEARCH_tble_srchupd').hide();
                    $('#STDTL_SEARCH_div_header').hide();
                    $('#STDTL_SEARCH_div_headernodata').hide();
                    $('#STDTL_SEARCH_div_update').hide();
                    $('#STDTL_SEARCH_tble_htmltable').hide();
                    $('section').html('');
                    $('#STDTL_SEARCH_tble_comments_option').hide();
                }
                else if(STDTL_SEARCH_search_option==86)//CPF AMOUNT
                {
                    $('#STDTL_SEARCH_tble_amt_option').show();
                    $('#STDTL_SEARCH_div_table').show();
                    var STDTL_SEARCH_searchheader=$('#STDTL_SEARCH_lb_searchoption').find('option:selected').text();
                    $('#STDTL_SEARCH_lbl_searchoptionheader').text(STDTL_SEARCH_searchheader).show();
                    $('#STDTL_SEARCH_tble_cpfnumber').hide();
                    $('#STDTL_SEARCH_div_searchbyemploy').hide();
                    $('#STDTL_SEARCH_tble_employee').hide();
                    $('#STDTL_SEARCH_tble_srchupd').hide();
                    $('#STDTL_SEARCH_div_header').hide();
                    $('#STDTL_SEARCH_div_headernodata').hide();
                    $('#STDTL_SEARCH_div_update').hide();
                    $('#STDTL_SEARCH_tble_htmltable').hide();
                    $('section').html('');
                    $('#STDTL_SEARCH_tble_comments_option').hide();
                    $('#STDTL_SEARCH_tb_fromamt').val('');
                    $('#STDTL_SEARCH_tb_toamt').val('');
                    $('#STDTL_SEARCH_lbl_cpfnumber_listbox').hide();
                    $('#STDTL_SEARCH_lbl_employeename_listbox').hide();
                }
                else if(STDTL_SEARCH_search_option==87)//LEVY AMOUNT
                {
                    $('#STDTL_SEARCH_tble_amt_option').show();
                    $('#STDTL_SEARCH_div_table').show();
                    var STDTL_SEARCH_searchheader=$('#STDTL_SEARCH_lb_searchoption').find('option:selected').text();
                    $('#STDTL_SEARCH_lbl_searchoptionheader').text(STDTL_SEARCH_searchheader).show();
                    $('#STDTL_SEARCH_tble_cpfnumber').hide();
                    $('#STDTL_SEARCH_div_searchbyemploy').hide();
                    $('#STDTL_SEARCH_tble_employee').hide();
                    $('#STDTL_SEARCH_tble_srchupd').hide();
                    $('#STDTL_SEARCH_div_header').hide();
                    $('#STDTL_SEARCH_div_headernodata').hide();
                    $('#STDTL_SEARCH_div_update').hide();
                    $('#STDTL_SEARCH_tble_htmltable').hide();
                    $('section').html('');
                    $('#STDTL_SEARCH_tble_comments_option').hide();
                    $('#STDTL_SEARCH_tb_fromamt').val('');
                    $('#STDTL_SEARCH_tb_toamt').val('');
                    $('#STDTL_SEARCH_lbl_cpfnumber_listbox').hide();
                    $('#STDTL_SEARCH_lbl_employeename_listbox').hide();
                }
                else if(STDTL_SEARCH_search_option==88)//SALARY AMOUNT
                {
                    $('#STDTL_SEARCH_tble_amt_option').show();
                    $('#STDTL_SEARCH_div_table').show();
                    var STDTL_SEARCH_searchheader=$('#STDTL_SEARCH_lb_searchoption').find('option:selected').text();
                    $('#STDTL_SEARCH_lbl_searchoptionheader').text(STDTL_SEARCH_searchheader).show();
                    $('#STDTL_SEARCH_tble_cpfnumber').hide();
                    $('#STDTL_SEARCH_div_searchbyemploy').hide();
                    $('#STDTL_SEARCH_tble_employee').hide();
                    $('#STDTL_SEARCH_tble_srchupd').hide();
                    $('#STDTL_SEARCH_div_header').hide();
                    $('#STDTL_SEARCH_div_headernodata').hide();
                    $('#STDTL_SEARCH_div_update').hide();
                    $('#STDTL_SEARCH_tble_htmltable').hide();
                    $('section').html('');
                    $('#STDTL_SEARCH_tble_comments_option').hide();
                    $('#STDTL_SEARCH_tb_fromamt').val('');
                    $('#STDTL_SEARCH_tb_toamt').val('');
                    $('#STDTL_SEARCH_lbl_cpfnumber_listbox').hide();
                    $('#STDTL_SEARCH_lbl_employeename_listbox').hide();
                }
                else if(STDTL_SEARCH_search_option==79)//STAFF COMMENTS
                {
                    $('#STDTL_SEARCH_tble_comments_option').show();
                    $('#STDTL_SEARCH_btn_search_comments').show();
                    $('#STDTL_SEARCH_div_table').show();
                    var STDTL_SEARCH_searchheader=$('#STDTL_SEARCH_lb_searchoption').find('option:selected').text();
                    $('#STDTL_SEARCH_lbl_searchoptionheader').text(STDTL_SEARCH_searchheader).show();
                    $('#STDTL_SEARCH_tble_amt_option').hide();
                    $('#STDTL_SEARCH_tble_cpfnumber').hide();
                    $('#STDTL_SEARCH_div_searchbyemploy').hide();
                    $('#STDTL_SEARCH_tble_employee').hide();
                    $('#STDTL_SEARCH_tble_srchupd').hide();
                    $('#STDTL_SEARCH_div_header').hide();
                    $('#STDTL_SEARCH_div_headernodata').hide();
                    $('#STDTL_SEARCH_div_update').hide();
                    $('#STDTL_SEARCH_tble_htmltable').hide();
                    $('section').html('');
                    $('#STDTL_SEARCH_ta_comments').val('').show();
                    $('#STDTL_SEARCH_lbl_cpfnumber_listbox').hide();
                    $('#STDTL_SEARCH_lbl_employeename_listbox').hide();
                    $('#STDTL_SEARCH_tble_comments_option').show();
                }
            }
        });
        //SUCCESS FUNCTION FOR SELECTING DATA
        function STDTL_SEARCH_empcpfresult()
        {
            $.ajax({
                type: "POST",
                url:SCTDTL_SEARH_controller_url+"STDTL_SEARCH_empcpfnoresult",
                success: function(data){
                    $('.preloader').hide();
                    cpfno=JSON.parse(data);
                    //GET STAFF CPF NUMBER
                    var STDTL_SEARCH_expensearr_cpfnumber= cpfno[0]
                    var STDTL_SEARCH_expensearr_employeename= cpfno[1]
                    STDTL_INPUT_expensearr_empfirstname=STDTL_INPUT_expensearr_employeename[0].EMP_FIRST_NAME;
                    var STDTL_SEARCH_expensearrcpfnumber1='<option>SELECT</option>';
                    for (var i = 0;i < STDTL_SEARCH_expensearr_cpfnumber.length;i++)
                    {
                        STDTL_SEARCH_expensearrcpfnumber1+='<option value="'+STDTL_SEARCH_expensearr_cpfnumber[i].EDSS_CPF_NUMBER+'">'+STDTL_SEARCH_expensearr_cpfnumber[i].EDSS_CPF_NUMBER+'</option>';
                    }
                    $('#STDTL_SEARCH_lb_cpfnumber_listbox').html(STDTL_SEARCH_expensearrcpfnumber1);
                    //GET STAFF EMPLOYEE NAME
                    var STDTL_SEARCH_expensearray_employeename='<option>SELECT</option>';
                    for (var i = 0;i< STDTL_SEARCH_expensearr_employeename.length; i++)
                    {
                        var STDTL_SEARCH_employeenameconcat=STDTL_SEARCH_expensearr_employeename[i].split("_");
                        STDTL_SEARCH_expensearray_employeename+='<option value="'+STDTL_SEARCH_expensearr_employeename[i]+'">'+STDTL_SEARCH_employeenameconcat[0]+" "+STDTL_SEARCH_employeenameconcat[1]+'</option>';
                    }
                    $('#STDTL_SEARCH_lb_employeename_listbox').html(STDTL_SEARCH_expensearray_employeename);

                }
            });
        }
        //CHANGE EVENT FUNCTION FOR EMPLOYEE NAME
        $('#STDTL_SEARCH_lb_employeename_listbox').change(function(){
            STDTL_SEARCH_sucsval=0;
            $(".preloader").show();
            $('#STDTL_SEARCH_div_header').hide();
            $('#STDTL_SEARCH_div_headernodata').hide();
            $('#STDTL_SEARCH_lbl_validamount').hide();
            $('#STDTL_SEARCH_lbl_validnumber').hide();
            $('#STDTL_SEARCH_tble_srchupd').hide();
            $("#data").removeClass('invalid')
            $("#STDTL_SEARCH_tb_updcpfamount").removeClass('invalid')
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            var STDTL_SEARCH_employeename=$("#STDTL_SEARCH_lb_employeename_listbox").val();
            if(STDTL_SEARCH_employeename=='SELECT')
            {
                $(".preloader").hide();
                $('#STDTL_SEARCH_div_header').hide();
                $('#STDTL_SEARCH_div_headernodata').hide();
                $('#STDTL_SEARCH_tble_srchupd').hide();
                $('#STDTL_SEARCH_div_update').hide();
                $('#STDTL_SEARCH_tble_htmltable').hide();
                $('section').html('');
            }
            else
            {
                var STDTL_SEARCH_ename=$('#STDTL_SEARCH_lb_employeename_listbox').val();
                STDTL_SEARCH_ename=STDTL_SEARCH_ename.replace("_"," ")
                var STDTL_SEARCH_errormsg=value_err_array[5].EMC_DATA.replace('[FNAME+LNAME]',STDTL_SEARCH_ename);
                $('#STDTL_SEARCH_div_header').text(STDTL_SEARCH_errormsg).show();
                $('#STDTL_SEARCH_div_headernodata').hide();
                $('#STDTL_SEARCH_tble_htmltable').hide();
                $('section').html('');
                $('#STDTL_SEARCH_tble_srchupd').hide();
                $('#STDTL_SEARCH_div_update').hide();
                STDTL_SEARCH_srch_result()
            }
        });
        //CHANGE EVENT FUNCTION FOR CPF NUMBER
        $('#STDTL_SEARCH_lb_cpfnumber_listbox').change(function(){
            STDTL_SEARCH_sucsval=0;
            $('section').html('');
            $('#STDTL_SEARCH_div_header').hide();
            $('#STDTL_SEARCH_div_headernodata').hide();
            $('#STDTL_SEARCH_lbl_validamount').hide();
            $('#STDTL_SEARCH_lbl_validnumber').hide();
            $('#STDTL_SEARCH_tble_srchupd').hide();
            $("#data").removeClass('invalid')
            $("#STDTL_SEARCH_tb_updcpfamount").removeClass('invalid')
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            var STDTL_SEARCH_cpfnumber=$("#STDTL_SEARCH_lb_cpfnumber_listbox").val();
            if(STDTL_SEARCH_cpfnumber=='SELECT')
            {
                $(".preloader").hide();
                $('#STDTL_SEARCH_div_header').hide();
                $('#STDTL_SEARCH_div_headernodata').hide();
                $('#STDTL_SEARCH_tble_srchupd').hide();
                $('#STDTL_SEARCH_div_update').hide();
                $('#STDTL_SEARCH_tble_htmltable').hide();
                $('section').html('');
            }
            else
            {
                var STDTL_SEARCH_cpfno=$('#STDTL_SEARCH_lb_cpfnumber_listbox').val();
                var STDTL_SEARCH_errormsg=value_err_array[7].EMC_DATA.replace('[CPFNO]',STDTL_SEARCH_cpfno);
                $('#STDTL_SEARCH_div_header').text(STDTL_SEARCH_errormsg).show();
                $('#STDTL_SEARCH_div_headernodata').hide();
                $('#STDTL_SEARCH_tble_htmltable').hide();
                $('section').html('');
                $('#STDTL_SEARCH_tble_srchupd').hide();
                $('#STDTL_SEARCH_div_update').hide();
                STDTL_SEARCH_srch_result()
            }
        });
        //BLUR FUNCTION FOR AMOUNT VALIDATION
        $(".amtsubmitval").blur(function(){
            $('#STDTL_SEARCH_div_header').hide();
            $('#STDTL_SEARCH_tble_htmltable').hide();
            $('#STDTL_SEARCH_div_pdf').hide();
            $('section').html('');
            $('#STDTL_SEARCH_div_update').hide();
            $('#STDTL_SEARCH_btn_search').hide();
            $('#STDTL_SEARCH_div_headernodata').hide();
            $('#STDTL_SEARCH_lbl_amounterrormsg').hide();
            var STDTL_SEARCH_search_option=$("#STDTL_SEARCH_lb_searchoption").val();
            if((STDTL_SEARCH_search_option==86) || (STDTL_SEARCH_search_option==87) || (STDTL_SEARCH_search_option==88 ))
            {
                if(($("#STDTL_SEARCH_tb_fromamt").val()!="")&&($("#STDTL_SEARCH_tb_toamt").val()!=""))
                {
                    var STDTL_SEARCH_validtype=ErrorControl.AmountCompare;

                    if(STDTL_SEARCH_validtype=='Valid')
                    {
                        $("#STDTL_SEARCH_btn_amtsearch").removeAttr("disabled");
                        $('#STDTL_SEARCH_div_headernodata').hide();
                        $('#STDTL_SEARCH_lbl_amounterrormsg').hide();
                    }
                    else
                    {
                        $("#STDTL_SEARCH_btn_amtsearch").attr("disabled","disabled");
                        $('#STDTL_SEARCH_div_header').hide();
                        $('#STDTL_SEARCH_lbl_amounterrormsg').text(value_err_array[0].EMC_DATA).show();
                    }
                }
                else
                {
                    $("#STDTL_SEARCH_btn_amtsearch").attr("disabled","disabled");
                    $('#STDTL_SEARCH_lbl_amounterrormsg').hide();
                    $('#STDTL_SEARCH_tble_htmltable').hide();
                    $('section').html('');
                    $('#STDTL_SEARCH_div_update').hide();
                    $('#STDTL_SEARCH_tble_srchupd').hide();
                    $('#STDTL_SEARCH_div_header').hide();
                    $('#STDTL_SEARCH_div_headernodata').hide();
                }
            }
        });
        //CHANGE EVENT FUNCTION FOR CPF AMOUNT,LEVY AMOUNT,SALARY AMOUNT
        $('#STDTL_SEARCH_btn_amtsearch').click(function(){
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            STDTL_SEARCH_sucsval=0;
            $(".preloader").show();
            $('#STDTL_SEARCH_div_header').hide();
            $('#STDTL_SEARCH_div_headernodata').hide();
            $('#STDTL_SEARCH_lbl_validamount').hide();
            $('#STDTL_SEARCH_lbl_validnumber').hide();
            $('#STDTL_SEARCH_tble_srchupd').hide();
            $("#data").removeClass('invalid')
            $("#STDTL_SEARCH_tb_updcpfamount").removeClass('invalid')
            var STDTL_SEARCH_search_option=$('#STDTL_SEARCH_lb_searchoption').val();
            var STDTL_SEARCH_fromamount=$('#STDTL_SEARCH_tb_fromamt').val();
            var STDTL_SEARCH_toamount=$('#STDTL_SEARCH_tb_toamt').val();
            if(STDTL_SEARCH_search_option==86)//CPF AMOUNT
            {
                STDTL_SEARCH_srch_result()
                var STDTL_SEARCH_conformsg=value_err_array[9].EMC_DATA;
                var STDTL_SEARCH_errormsgs=STDTL_SEARCH_conformsg.replace('[FAMT]',STDTL_SEARCH_fromamount);
                var STDTL_SEARCH_errormsg=STDTL_SEARCH_errormsgs.replace('[TAMT]',STDTL_SEARCH_toamount);
                $('#STDTL_SEARCH_div_header').text(STDTL_SEARCH_errormsg).show();
            }
            else if(STDTL_SEARCH_search_option==87)//LEVY AMOUNT
            {
                STDTL_SEARCH_srch_result()
                var STDTL_SEARCH_conformsg=value_err_array[8].EMC_DATA
                var STDTL_SEARCH_errormsgs=STDTL_SEARCH_conformsg.replace('[FAMT]',STDTL_SEARCH_fromamount);
                var STDTL_SEARCH_errormsg=STDTL_SEARCH_errormsgs.replace('[TAMT]',STDTL_SEARCH_toamount);
                $('#STDTL_SEARCH_div_header').text(STDTL_SEARCH_errormsg).show();
            }
            else if(STDTL_SEARCH_search_option==88)//SALARY AMOUNT
            {
                STDTL_SEARCH_srch_result()
                var STDTL_SEARCH_conformsg=value_err_array[10].EMC_DATA
                var STDTL_SEARCH_errormsgs=STDTL_SEARCH_conformsg.replace('[FAMT]',STDTL_SEARCH_fromamount);
                var STDTL_SEARCH_errormsg=STDTL_SEARCH_errormsgs.replace('[TAMT]',STDTL_SEARCH_toamount);
                $('#STDTL_SEARCH_div_header').text(STDTL_SEARCH_errormsg).show();
            }
            $('#STDTL_SEARCH_div_update').hide();
            $('#STDTL_SEARCH_tble_srchupd').hide();
        });
        //update form
        var values_array=[];
        var STDTL_SEARCH_cpfno;
        var STDTL_SEARCH_cpfamount;
        var STDTL_SEARCH_levyamount;
        var STDTL_SEARCH_comments;
        var STDTL_SEARCH_salaryamount;
        var ET_SRC_UPD_DEL_userstamp;
        var ET_SRC_UPD_DEL_timestmp;
        var id;
        var ET_SRC_UPD_DEL_table_value='';
        var STDTL_SEARCH_firstname;
        var STDTL_SEARCH_lastname;
        function STDTL_SEARCH_srch_result()
        {
            var STDTL_SEARCH_errormsg=[];
            var STDTL_SEARCH_staffexpense_selectquery = $("#STDTL_SEARCH_lb_searchoption").val();
            var STDTL_SEARCH_cpfnumber = $("#STDTL_SEARCH_lb_cpfnumber_listbox").val();
            var STDTL_SEARCH_cpffrom_form = $("#STDTL_SEARCH_tb_fromamt").val();
            var STDTL_SEARCH_cpfto_form = $("#STDTL_SEARCH_tb_toamt").val();
            var STDTL_SEARCH_staffcommentstxt=$('#STDTL_SEARCH_ta_comments').val();
            var STDTL_SEARCH_firstlastname = $("#STDTL_SEARCH_lb_employeename_listbox").val();
            var emp_name=STDTL_SEARCH_firstlastname.split("_")
            var emp_first_name=emp_name[0]
            var emp_last_name=emp_name[1]
            if(emp_last_name==undefined){
                emp_last_name='';
            }
            $.ajax({
                type: "POST",
                url:SCTDTL_SEARH_controller_url+"fetchdata",
                data: {'STDTL_SEARCH_staffexpense_selectquery':STDTL_SEARCH_staffexpense_selectquery,'STDTL_SEARCH_cpfnumber': STDTL_SEARCH_cpfnumber,'STDTL_SEARCH_cpffrom_form':STDTL_SEARCH_cpffrom_form,'STDTL_SEARCH_cpfto_form':STDTL_SEARCH_cpfto_form,'emp_first_name':emp_first_name,'emp_last_name':emp_last_name,'STDTL_SEARCH_staffcommentstxt':STDTL_SEARCH_staffcommentstxt},
                success: function(data) {
                    $('.preloader').hide();
                    values_array=JSON.parse(data);
                    if(values_array.length!=0)
                    {
                        var ET_SRC_UPD_DEL_table_header='<table id="STDTL_SEARCH_tble_htmltable" border="1"  cellspacing="0" class="srcresult" style="width:1300px"><thead  bgcolor="#6495ed" style="color:white"><tr><th></th><th  style="width:180px">EMPLOYEE NAME</th><th style="width:100px">CPF NUMBER</th><th style="width:100px">CPF AMOUNT</th><th style="width:100px">LEVY AMOUNT</th><th style="width:100px">SALARY AMOUNT <em>*</em></th><th style="width:250px">COMMENTS</th><th style="width:130px">USERSTAMP</th><th  class="uk-timestp-column" style="width:130px">TIMESTAMP</th></tr></thead><tbody>'
                        for(var j=0;j<values_array.length;j++){
                            var STDTL_SEARCH_values=values_array[j]
                            STDTL_SEARCH_firstname=values_array[j].EMP_FIRST_NAME;
                            STDTL_SEARCH_lastname=values_array[j].EMP_LAST_NAME;
                            STDTL_SEARCH_cpfno=values_array[j].cpfnumber
                            if((STDTL_SEARCH_cpfno=='null')||(STDTL_SEARCH_cpfno==undefined))
                            {
                                STDTL_SEARCH_cpfno='';
                            }
                            STDTL_SEARCH_cpfamount=values_array[j].cpfamount
                            if((STDTL_SEARCH_cpfamount=='null')||(STDTL_SEARCH_cpfamount==undefined))
                            {
                                STDTL_SEARCH_cpfamount='';
                            }
                            STDTL_SEARCH_levyamount=values_array[j].levyamount
                            if((STDTL_SEARCH_levyamount=='null')||(STDTL_SEARCH_levyamount==undefined))
                            {
                                STDTL_SEARCH_levyamount='';
                            }
                            STDTL_SEARCH_comments=values_array[j].comments
                            if((STDTL_SEARCH_comments=='null')||(STDTL_SEARCH_comments==undefined))
                            {
                                STDTL_SEARCH_comments='';
                            }
                            id=values_array[j].empno;
                            var STDTL_INPUT_names_concat=STDTL_SEARCH_firstname.concat(STDTL_SEARCH_lastname)
                            ET_SRC_UPD_DEL_table_header+='<tr><td><span  id ='+id+' class="glyphicon glyphicon-trash deletebutton"></span></td><td>'+STDTL_INPUT_names_concat+'</td><td id=cpfno_'+id+' class="staffedit"  >'+STDTL_SEARCH_cpfno+'</td><td id=cpfamt_'+id+' class="staffedit">'+STDTL_SEARCH_cpfamount+'</td><td id=levyamt_'+id+' class="staffedit">'+STDTL_SEARCH_levyamount+'</td><td id=salaryamt_'+id+' class="staffedit">'+STDTL_SEARCH_values.salaryamount+'</td><td id=comments_'+id+' class="staffedit">'+STDTL_SEARCH_comments+'</td><td>'+STDTL_SEARCH_values.userstamp+'</td><td>'+STDTL_SEARCH_values.timestamp+'</td></tr>';
                        }
                        ET_SRC_UPD_DEL_table_header+='</tbody></table>';
                        $('section').html(ET_SRC_UPD_DEL_table_header);
                       $('#STDTL_SEARCH_tble_htmltable').DataTable( {
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers"
                    });
                    $('#STDTL_SEARCH_div_pdf').show();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    sorting()
                    }
                    else
                    {
                        $('#STDTL_SEARCH_div_header').hide();
                        $('#ET_SRC_UPD_DEL_div_table').hide();
                        $('#STDTL_SEARCH_tble_htmltable').hide();
                        $('section').html('');
                        $('.preloader').hide();
                        $('#STDTL_SEARCH_div_pdf').hide();
                        var STDTL_SEARCH_search_option=$('#STDTL_SEARCH_lb_searchoption').val();
                        var STDTL_SEARCH_fromamount=$('#STDTL_SEARCH_tb_fromamt').val();
                        var STDTL_SEARCH_toamount=$('#STDTL_SEARCH_tb_toamt').val();
                        var STDTL_SEARCH_conformsg=value_err_array[1].EMC_DATA;
                        var STDTL_SEARCH_errormsgs=STDTL_SEARCH_conformsg.replace('[FROM AMOUNT]',STDTL_SEARCH_fromamount);
                        STDTL_SEARCH_errormsg=STDTL_SEARCH_errormsgs.replace('[TO AMOUNT]',STDTL_SEARCH_toamount);
                        if(STDTL_SEARCH_search_option==90)//EMPLOYEE NAME
                        {
                            $('#STDTL_SEARCH_div_header').hide();
                            var STDTL_SEARCH_employeename=$('#STDTL_SEARCH_lb_employeename_listbox').val();
                            STDTL_SEARCH_employeename=STDTL_SEARCH_employeename.replace("_"," ")
                            var STDTL_SEARCH_errormsg=value_err_array[6].EMC_DATA.replace('[FNAME+LNAME]',STDTL_SEARCH_employeename);
                            $('#STDTL_SEARCH_div_headernodata').text(STDTL_SEARCH_errormsg).show();
                        }
                        else if(STDTL_SEARCH_search_option==86)//CPF AMOUNT
                        {
                            $('#STDTL_SEARCH_div_headernodata').text(STDTL_SEARCH_errormsg).show();
                            $('#STDTL_SEARCH_div_header').hide();
                            $('#STDTL_SEARCH_tble_htmltable').hide();
                        }
                        else if(STDTL_SEARCH_search_option==87)//LEVY AMOUNT
                        {
                            $('#STDTL_SEARCH_div_headernodata').text(STDTL_SEARCH_errormsg).show();
                            $('#STDTL_SEARCH_div_header').hide();
                            $('#STDTL_SEARCH_tble_htmltable').hide();
                        }
                        else if(STDTL_SEARCH_search_option==88)//SALARY AMOUNT
                        {
                            $('#STDTL_SEARCH_div_headernodata').text(STDTL_SEARCH_errormsg).show();
                            $('#STDTL_SEARCH_div_header').hide();
                            $('#STDTL_SEARCH_tble_htmltable').hide();
                        }
                        else if(STDTL_SEARCH_search_option==79)//STAFF COMMENTS
                        {
                            $('#STDTL_SEARCH_div_header').hide();
                            $('#STDTL_SEARCH_tble_htmltable').hide();
                        }
                    }
                    $('#STDTL_SEARCH_div_flexdata_result').show();
                }
            });
            $('#STDTL_SEARCH_btn_amtsearch').attr("disabled","disabled");
            $('#STDTL_SEARCH_btn_search_comments').attr("disabled","disabled");
        }
        $(document).on('click','#STDTL_SEARCH_btn_pdf',function(){
            var STDTL_SEARCH_search_option=$('#STDTL_SEARCH_lb_searchoption').val();
            var STDTL_SEARCH_fromamount=$('#STDTL_SEARCH_tb_fromamt').val();
            var STDTL_SEARCH_toamount=$('#STDTL_SEARCH_tb_toamt').val();
            if(STDTL_SEARCH_search_option==86)//CPF AMOUNT
            {
                var STDTL_SEARCH_conformsg=value_err_array[9].EMC_DATA;
                var STDTL_SEARCH_errormsgs=STDTL_SEARCH_conformsg.replace('[FAMT]',STDTL_SEARCH_fromamount);
                var STDTL_SEARCH_errormsg=STDTL_SEARCH_errormsgs.replace('[TAMT]',STDTL_SEARCH_toamount);

            }
            else if(STDTL_SEARCH_search_option==87)//LEVY AMOUNT
            {
                var STDTL_SEARCH_conformsg=value_err_array[8].EMC_DATA
                var STDTL_SEARCH_errormsgs=STDTL_SEARCH_conformsg.replace('[FAMT]',STDTL_SEARCH_fromamount);
                var STDTL_SEARCH_errormsg=STDTL_SEARCH_errormsgs.replace('[TAMT]',STDTL_SEARCH_toamount);

            }
            else if(STDTL_SEARCH_search_option==88)//SALARY AMOUNT
            {
                var STDTL_SEARCH_conformsg=value_err_array[10].EMC_DATA
                var STDTL_SEARCH_errormsgs=STDTL_SEARCH_conformsg.replace('[FAMT]',STDTL_SEARCH_fromamount);
                var STDTL_SEARCH_errormsg=STDTL_SEARCH_errormsgs.replace('[TAMT]',STDTL_SEARCH_toamount);
            }
            else if(STDTL_SEARCH_search_option==93) {
                var STDTL_SEARCH_cpfno = $('#STDTL_SEARCH_lb_cpfnumber_listbox').val();
                var STDTL_SEARCH_errormsg = value_err_array[7].EMC_DATA.replace('[CPFNO]', STDTL_SEARCH_cpfno);
            }
            else if(STDTL_SEARCH_search_option==79){

                var STDTL_SEARCH_staffcommentstxt=$('#STDTL_SEARCH_ta_comments').val();
                var STDTL_SEARCH_errormsg=value_err_array[3].EMC_DATA.replace('[COMMENTS]',STDTL_SEARCH_staffcommentstxt);
            }
            var STDTL_SEARCH_staffexpense_selectquery = $("#STDTL_SEARCH_lb_searchoption").val();
            var STDTL_SEARCH_cpfnumber = $("#STDTL_SEARCH_lb_cpfnumber_listbox").val();
            var STDTL_SEARCH_cpffrom_form = $("#STDTL_SEARCH_tb_fromamt").val();
            var STDTL_SEARCH_cpfto_form = $("#STDTL_SEARCH_tb_toamt").val();
            var STDTL_SEARCH_staffcommentstxt=$('#STDTL_SEARCH_ta_comments').val();
            var STDTL_SEARCH_firstlastname = $("#STDTL_SEARCH_lb_employeename_listbox").val();
            var emp_name=STDTL_SEARCH_firstlastname.split("_")
            var emp_first_name=emp_name[0]
            var emp_last_name=emp_name[1]
            var pdfurl = document.location.href = '<?php echo site_url('EXPENSE/STAFF/Ctrl_Staff_Detail_Entry_Search_Update_Delete/Staff_Detail_pdf')?>?STDTL_SEARCH_staffexpense_selectquery='+STDTL_SEARCH_staffexpense_selectquery+'&STDTL_SEARCH_cpfnumber='+STDTL_SEARCH_cpfnumber+'&STDTL_SEARCH_cpffrom_form='+STDTL_SEARCH_cpffrom_form+'&STDTL_SEARCH_cpfto_form='+STDTL_SEARCH_cpfto_form+'&emp_first_name='+emp_first_name+'&emp_last_name='+emp_last_name+'&STDTL_SEARCH_staffcommentstxt='+STDTL_SEARCH_staffcommentstxt+'&header='+STDTL_SEARCH_errormsg;
        });
        var previous_id;
        var combineid;
        var tdvalue;
        var check;
        var cpfid;
        var checkamt;
        var cpfnoid;
        var levyamount_id;
        var salaryamount_id;
        var comments_id;
        var STDTL_SEARCH_currentval;
        var STDTL_SEARCH_cpfnoval;
        var STDTL_SEARCH_cpf_amount;
        //click function for INLINE EDIT
        $(document).on('click','.staffedit', function (){
            if(previous_id!=undefined){
                $('#'+previous_id).replaceWith("<td class='staffedit' id='"+previous_id+"' >"+tdvalue+"</td>");
            }
            var cid = $(this).attr('id');
            previous_id=cid;
            var id=cid.split('_');
            combineid=id[1];
            tdvalue=$(this).text();
            check=id[0]==('cpfno')
            checkamt=id[1]==('cpfamt')
            if(check==true){
                cpfnoid='cpfnum_'+id[1];
                $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"' style='width:100px'><input type='text' id='"+cpfnoid+"' name='data'  class='staffupdate form-control' maxlength='9' size='10' value='"+tdvalue+"'>");
            }
            else if(id[0]=='cpfamt' && tdvalue!=''){
                cpfid='cpfamountid_'+id[1];
                $('#cpfamt_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"' style='width:100px'><input type='text' id='"+cpfid+"' name='data'  class='staffupdate amountonly form-control'   value='"+tdvalue+"'>");
                $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
            }
            else if(id[0]=='levyamt'){
                levyamount_id='levyamounttid_'+id[1];
                $('#levyamt_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"' style='width:100px'><input type='text' id='"+levyamount_id+"' name='data'  class='staffupdate amountonly form-control'   value='"+tdvalue+"'>");
                $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
            }
            else if(id[0]=='salaryamt'){
                salaryamount_id='salaryamountid_'+id[1];
                $('#salaryamt_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"' style='width:100px'><input type='text' id='"+salaryamount_id+"' name='data'  class='staffupdate amountonly form-control'   value='"+tdvalue+"'>");
                $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
            }
            else if(id[0]=='comments'){
                comments_id='commentsid_'+id[1];
                $('#comments_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"' ><textarea id='"+comments_id+"' name='data'  class='staffupdate form-control' >"+tdvalue+"</textarea></td>");
            }
            else if(id[0]=='cpfamt' && tdvalue==''){
                show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE","PLZ ENTER CPF NUMBER","success",false)
            }
            if(check==true)
            {
            $('#STDTL_SEARCH_tb_updcpfnumberduplicate').val(tdvalue);
            }
            else
            {
                $('#STDTL_SEARCH_tb_updcpfnumberduplicate').val('');
            }
            if((check==true) && (tdvalue==''))
            {
                cpfid='cpfamt_'+id[1];
                $('#cpfamt_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='"+cpfid+"' name='data'  class='staffupdate amountonly form-control'   value='"+tdvalue+"'>");
                $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
            }
        });
        //blur function for subject update
        $(document).on(' change','.staffupdate',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#'+salaryamount_id).val()!='') {
                if (check == true) {
                    STDTL_SEARCH_currentval = $(this).val().trim();
                    STDTL_SEARCH_cpfnoval = $('#' + cpfnoid).val();
                    if ((STDTL_SEARCH_cpfnoval.length == 9) && (STDTL_SEARCH_cpfnoval != tdvalue)) {
                        $.ajax({
                            type: "POST",
                            url: SCTDTL_SEARH_controller_url + "dataupd_exists",
                            data: {'tdvalue': STDTL_SEARCH_currentval},
                            success: function (data) {
                                $('.preloader').hide();
                                var STDTL_SEARCH_response = JSON.parse(data.already_exits_array)//retdata.final_array[0];
                                if (STDTL_SEARCH_response == 1) {
                                    show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE", value_err_array[16].EMC_DATA, "success", false)
                                    $("#data").addClass('invalid');
                                }
                                else {
                                    STDTL_SEARCH_cpf_amount = $('#' + cpfid).val();
                                    if (STDTL_SEARCH_cpf_amount != '') {
                                        STDTL_SEARCH_updateresult(STDTL_SEARCH_cpf_amount)
                                    }
                                    else {
                                        show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE", value_err_array[17].EMC_DATA, "error", false)
                                    }
                                }
                            }
                        });
                    }
                    else {
                        show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE", value_err_array[12].EMC_DATA, "success", false)
                        $("#data").addClass('invalid');
                    }
                }
                else {
                    STDTL_SEARCH_cpf_amount = $('#' + cpfid).val();
                    STDTL_SEARCH_levyamount = $('#' + levyamount_id).val();
                    STDTL_SEARCH_salaryamount = $('#' + salaryamount_id).val();
                    STDTL_SEARCH_comments = $('#' + comments_id).val();
                    if (STDTL_SEARCH_cpf_amount != '') {
                        STDTL_SEARCH_updateresult(STDTL_SEARCH_cpf_amount, STDTL_SEARCH_levyamount, STDTL_SEARCH_salaryamount, STDTL_SEARCH_comments);
                    }
                }
            }
            else{
                show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",'ENTER SALARY AMOUNT',"error",false)

            }
        });
        //SUCCESS FUNCTION FOR UPDATION PART
        function STDTL_SEARCH_updateresult(STDTL_SEARCH_cpf_amount,STDTL_SEARCH_levyamount,STDTL_SEARCH_salaryamount,STDTL_SEARCH_comments){
            $('.preloader').show();
            if($('#cpfno_'+combineid).hasClass("staffedit")==true){
            var STDTL_SEARCH_cpfnumber=$('#cpfno_'+combineid).text();
            }
            else{
                var STDTL_SEARCH_cpfnumber=STDTL_SEARCH_cpfnoval;
            }
            if($('#cpfamt_'+combineid).hasClass("staffedit")==true){
                var STDTL_SEARCH_cpf_amount=$('#cpfamt_'+combineid).text();
            }
            else{
                var STDTL_SEARCH_cpf_amount=STDTL_SEARCH_cpf_amount;
            }
            if($('#levyamt_'+combineid).hasClass("staffedit")==true){
                var STDTL_SEARCH_levyamount=$('#levyamt_'+combineid).text();
            }
            else{
                var STDTL_SEARCH_levyamount=STDTL_SEARCH_levyamount;
            }
            if($('#salaryamt_'+combineid).hasClass("staffedit")==true){
                var STDTL_SEARCH_salaryamount=$('#salaryamt_'+combineid).text();
            }
            else{
                var STDTL_SEARCH_salaryamount=STDTL_SEARCH_salaryamount;
            }
            if($('#comments_'+combineid).hasClass("staffedit")==true){
                var STDTL_SEARCH_comments=$('#comments_'+combineid).text();
            }
            else{
                var STDTL_SEARCH_comments=STDTL_SEARCH_comments;
            }
            if(STDTL_SEARCH_salaryamount!=''){
                var data = $('#STDTL_INPUT_form_employeename').serialize();
                $.ajax({
                    type: "POST",
                    url:SCTDTL_SEARH_controller_url+"updatefunction",
                    data:{'id':combineid,'STDTL_SEARCH_cpfnumber':STDTL_SEARCH_cpfnumber,'STDTL_SEARCH_cpfamount':STDTL_SEARCH_cpf_amount,'STDTL_SEARCH_levyamount':STDTL_SEARCH_levyamount,'STDTL_SEARCH_salaryamount':STDTL_SEARCH_salaryamount,'STDTL_SEARCH_comments':STDTL_SEARCH_comments},
                    success: function(STDTL_SEARCH_updateresult) {
                        $('.preloader').hide();
                        if(STDTL_SEARCH_updateresult==1)
                        {
                            show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",value_err_array[13].EMC_DATA,"success",false)
                            STDTL_SEARCH_srch_result()
                            STDTL_SEARCH_comments_auto()
                            $("#STDTL_SEARCH_lb_cpfnumber_listbox").val('SELECT');
                            var STDTL_SEARCH_search_option=$('#STDTL_SEARCH_lb_searchoption').val();
                            if(STDTL_SEARCH_search_option==93)
                            STDTL_SEARCH_empcpfresult()
                            previous_id=undefined;
                        }
                        else
                        {
                            //MESSAGE BOX FOR NOT UPDATED
                            show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",value_err_array[22].EMC_DATA,"error",false)
                        }
                    }
                });
            }
        }
        //click event for delete btn
        $(document).on('click','.deletebutton',function(){
            rowid = $(this).attr('id');
            show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",value_err_array[19].EMC_DATA,"success","delete");
        });
        //CONFIRMATION DELETE CLICK BTN
        $(document).on('click','.deleteconfirm',function(){
            $(".preloader").show();
            $.ajax({
                type: "POST",
                url:SCTDTL_SEARH_controller_url+"deleteoption",
                data :{'rowid':rowid},
                success: function(data) {
                    $('.preloader').hide();
                    var successresult=JSON.parse(data);
                    var deleteflag=successresult[0].DELETION_FLAG;
                    if(deleteflag==1){
                        $.ajax({
                            type: "POST",
                            url:SCTDTL_SEARH_controller_url+"deleteconformoption",
                            data :{'rowid':rowid},
                            success: function(data) {
                                var successresult=JSON.parse(data);
                                var deleteflag=successresult;
                                if(deleteflag==1){
                                    show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",value_err_array[14].EMC_DATA,"success",false)
                                    CONFIG_SRCH_UPD_fetch_configdata()
                                }
                                else
                                {
                                    show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",value_err_array[11].EMC_DATA,"error",false)
                                }
                            }
                        });
                    }
                    else
                    {
                        show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",value_err_array[23].EMC_DATA,"error",false)
                    }
                }
            });
        });
        //FUNCTION FOR FORM TABLE DATE FORMAT
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        //FUNCTION FOR SORTING
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
    });
    //READY FUNCTION END
    </script>
    <!--SCRIPT TAG END-->
    <!--BODY TAG START-->
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE</b></h4></div>
    <form id="STDTL_INPUT_form_employeename" name="STDTL_INPUT_form_employeename" class="form-horizontal content" role="form">
        <div class="panel-body">
            <div style="padding-bottom: 15px">
                <div class="radio">
                    <label><input type="radio" name="optradio" value="STAFF ENTRY" class="STDTL_rd_selectform">ENTRY</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="optradio" value="STAFF SEARCH/UPDATE" class="STDTL_rd_selectform">SEARCH/UPDATE/DELETE</label>
                </div>
            </div>
            <label id="STDTL_INPUT_noform" name="STDTL_INPUT_noform" class="errormsg" disabled="" hidden></label>
            <div id="enrtyfrm" hidden>
                <div class="form-group">
                    <label  name="STDTL_INPUT_lbl_employeename" id="STDTL_INPUT_lbl_employeename" class="col-sm-2 " hidden>EMPLOYEE NAME<em>*</em></label>
                    <div class="col-sm-4">
                        <select class="form-control  validation" name="STDTL_INPUT_lb_employeename"  required id="STDTL_INPUT_lb_employeename" class=" uppercase autosize"  hidden>
                            <option value="SELECT">SELECT</option>
                        </select>
                    </div>
                    <input type="text" name="STDTL_INPUT_hidden_employid" id="STDTL_INPUT_hidden_employid" hidden>
                </div>
                <div id="STDTL_INPUT_div_employid">
                    <div id="STDTL_INPUT_tble_employid"></div>
                </div>
                <div class="row form-group">
                    <label name="STDTL_INPUT_lbl_cpfnumber" id="STDTL_INPUT_lbl_cpfnumber" class="col-sm-2">CPF NUMBER</label>
                    <div class="col-sm-10">
                        <input  type="text" name="STDTL_INPUT_tb_cpfnumber" id="STDTL_INPUT_tb_cpfnumber" maxlength='9' class="alphanumeric form-control" style="width:120px">
                        <label id="STDTL_INPUT_lbl_validnumber" name="STDTL_INPUT_lbl_validnumber" class="errormsg submitValidation" disabled="" hidden></label>
                    </div>
                </div>
                <div class="row form-group">
                    <label name="STDTL_INPUT_lbl_cpfamount" id="STDTL_INPUT_lbl_cpfamount" class="col-sm-2">CPF AMOUNT</label>
                    <div class="col-sm-10">
                        <input  type="text" name="STDTL_INPUT_tb_cpfamount" id="STDTL_INPUT_tb_cpfamount" class="amountonly submitValidation form-control" style="width:90px">
                        <label id="STDTL_INPUT_lbl_validamount" name="STDTL_INPUT_lbl_validamount" class="errormsg" disabled="" hidden></label>
                    </div>
                </div>
                <div class="row form-group">
                    <label name="STDTL_INPUT_lbl_levyamount" id="STDTL_INPUT_lbl_levyamount" class="col-sm-2">LEVY AMOUNT</label>
                    <div class="col-sm-10">
                        <input  type="text" name="STDTL_INPUT_tb_levyamount" id="STDTL_INPUT_tb_levyamount" class="amountonly submitValidation form-control" style="width:90px">
                    </div>
                </div>
                <div class="row form-group">
                    <label name="STDTL_INPUT_lbl_salaryamount" id="STDTL_INPUT_lbl_salaryamount" class="col-sm-2">SALARY AMOUNT<em>*</em></label>
                    <div class="col-sm-10">
                        <input  type="text" name="STDTL_INPUT_tb_salaryamount" id="STDTL_INPUT_tb_salaryamount"  class="amountonly submitValidation form-control" style="width:90px">
                    </div>
                </div>
                <div class="row form-group">
                    <label name="STDTL_INPUT_lbl_comments" id="STDTL_INPUT_lbl_comments" class="col-sm-2">COMMENTS</label>
                    <div class="col-sm-5">
                        <textarea class="form-control tarea maxlength submitValidation" rows="8" name="STDTL_INPUT_ta_comments" id="STDTL_INPUT_ta_comments"  >
                        </textarea>
                    </div>
                </div>
                <div class="col-lg-3 col-lg-offset-2">
                    <input type="button" class=" btn" name="STDTL_INPUT_btn_save" id="STDTL_INPUT_btn_save"  disabled=""   value="SAVE"  >
                    <input type="button" class=" btn" name="STDTL_INPUT_btn_reset" id="STDTL_INPUT_btn_reset"  value="RESET">
                </div>
            </div>
            <div id="searchfrm" hidden>
                <div class="form-group">
                    <label  name="STDTL_SEARCH_lbl_searchoption" id="STDTL_SEARCH_lbl_searchoption" class="col-sm-2" hidden>SEARCH BY<em>*</em></label>
                    <div class="col-sm-4">
                        <select class="form-control  validation" name="STDTL_SEARCH_lb_searchoption"  required id="STDTL_SEARCH_lb_searchoption"  hidden>
                            <option>SELECT</option>
                        </select>
                    </div>
                </div>
                <label id="STDTL_SEARCH_lbl_searchoptionheader" name="STDTL_SEARCH_lbl_searchoptionheader" class="srctitle" disabled=""></label>
                <div class="form-group">
                    <label  name="STDTL_SEARCH_lbl_employeename_listbox" id="STDTL_SEARCH_lbl_employeename_listbox" class="col-sm-2" hidden>EMPLOYEE NAME</label>
                    <div class="col-sm-4">
                        <select class="form-control  validation" name="STDTL_SEARCH_lb_employeename_listbox"  required id="STDTL_SEARCH_lb_employeename_listbox" hidden>
                            <option>SELECT</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label  name="STDTL_SEARCH_lbl_cpfnumber_listbox" id="STDTL_SEARCH_lbl_cpfnumber_listbox" class="col-sm-2" hidden>CPF NUMBER</label>
                    <div class="col-sm-4">
                        <select class="form-control  validation" name="STDTL_SEARCH_lb_cpfnumber_listbox"  required id="STDTL_SEARCH_lb_cpfnumber_listbox"  hidden>
                            <option>SELECT</option>
                        </select>
                    </div>
                </div>
                <div id="STDTL_SEARCH_tble_amt_option" hidden>
                    <div class="row form-group">
                        <label name="STDTL_SEARCH_lbl_fromamt" id="STDTL_SEARCH_lbl_fromamt" class="col-sm-2">FROM AMOUNT</label>
                        <div class="col-sm-2">
                            <input  type="text" name="STDTL_SEARCH_tb_fromamt" id="STDTL_SEARCH_tb_fromamt" class = "amtsubmitval amountonly form-control" style="width:100px">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="STDTL_SEARCH_lbl_toamt" id="STDTL_SEARCH_lbl_toamt" class="col-sm-2">TO AMOUNT</label>
                        <div class="col-sm-2">
                            <input  type="text" name="STDTL_SEARCH_tb_toamt" id="STDTL_SEARCH_tb_toamt" class = "amtsubmitval amountonly form-control" style="width:100px" >
                        </div>
                        <label class="errormsg" id='STDTL_SEARCH_lbl_amounterrormsg'  hidden></label>
                    </div>
                    <div class="col-lg-offset-2">
                        <input type="button"   id="STDTL_SEARCH_btn_amtsearch"   value="SEARCH" class="btn" disabled hidden />
                    </div>
                </div>
                <div id="STDTL_SEARCH_tble_comments_option" hidden>
                    <div class="row form-group">
                        <label name="STDTL_INPUT_lbl_comments" id="STDTL_INPUT_lbl_comments" class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4">
                            <textarea name="STDTL_SEARCH_ta_comments" id="STDTL_SEARCH_ta_comments" class="auto commentsresultsvalidate form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-offset-2">
                        <input type="button"   id="STDTL_SEARCH_btn_search_comments"   value="SEARCH" class="btn" disabled hidden />
                    </div>
                </div>
                <div class="srctitle" name="STDTL_SEARCH_div_header" id="STDTL_SEARCH_div_header"></div><br>
                <div class="errormsg" name="STDTL_SEARCH_div_headernodata" id="STDTL_SEARCH_div_headernodata"></div>
                <div id='STDTL_SEARCH_div_pdf' hidden>
                    <div>
                        <input type="button" id='STDTL_SEARCH_btn_pdf' class="btnpdf" value="PDF">
                    </div>
                </div><br>
                <div class="table-responsive" id="STDTL_SEARCH_div_flexdata_result" style="  overflow-y: hidden;" hidden>
                        <section>
                        </section>
                </div>
                <div class="row form-group">
                    <div class="col-sm-10">
                        <input  type="text" name="STDTL_SEARCH_tb_updcpfnumberduplicate" id="STDTL_SEARCH_tb_updcpfnumberduplicate" maxlength='9' class="alphanumeric" style="width:120px" hidden>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->