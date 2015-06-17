<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE*******************************//
//DONE BY SARADA
//VER 0.02-SD:08/06/2015 ED:08/06/2015 CHANGED ALL CTRL,MODEL,VIEW FILE NAME AND GET USERSTAMP AND TIME ZONE FROM EILIB,
REMOVED COMMENTS AND EMPTY SPACE
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:18/05/2015
//************************************************************************************************************-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
<style type="text/css">
    td, th {
        padding: 8px;
    }
    textarea{
        resize: none;
        overflow: hidden;
    }
</style>
<script type="text/javascript">
// document ready function
var listboxoption;
var ErrorControl ={AmountCompare:'InValid'}
$(document).ready(function(){
    var STDLY_SEARCH_controller_url="<?php echo base_url(); ?>" + '/index.php/EXPENSE/STAFF/Ctrl_Staff_Daily_Entry_Search_Update_Delete/' ;
    $(".preloader").hide();
    $('#staffdly_lb_type').hide();
    $('#staffdly_lbl_type').hide();
    $('#STDLY_SEARCH_btn_agentsbutton').hide();
    $('#STDLY_SEARCH_btn_salarybutton').hide();
    $('#STDLY_SEARCH_btn_staffbutton').hide();
    $('#STDLY_SEARCH_tble_agenttable').hide();
    $('#STDLY_SEARCH_lb_staffsearchoption').hide();
    //search frm
    var STDLY_SEARCH_expenseArray=[];
    var STDLY_SEARCH_expenseArrayallid=[];
    var STDLY_SEARCH_agenttable=[];
    var STDLY_SEARCH_employeeNameArray=[];
    var expencetype_agent=[];
    var STDLY_SEARCH_empdetail;
    var STDLY_SEARCH_empdetailstaffsalary;
    var STDLY_SEARCH_expensestaffsalary;
    var STDLY_SEARCH_expensestaff;
    var STDLY_SEARCH_loadcpfnosarray;
    //DATE PICKER USED IN THE STARING SEARCH PART//
    $(".datebox").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,maxDate:new Date(),
        onSelect: function(date){
            if((($('#STDLY_SEARCH_lb_typelist').val()==39)&&($('#STDLY_SEARCH_lb_searchoption').val()==77))||(($('#STDLY_SEARCH_lb_typelist').val()==40)&&($('#STDLY_SEARCH_lb_salarysearchoption').val()==85))||(($('#STDLY_SEARCH_lb_typelist').val()==41)&&($('#STDLY_SEARCH_lb_staffsearchoption').val()==79))||(($('#STDLY_SEARCH_lb_typelist').val()==41)&&($('#STDLY_SEARCH_lb_staffsearchoption').val()==82))||(($('#STDLY_SEARCH_lb_typelist').val()==41)&&($('#STDLY_SEARCH_lb_staffsearchoption').val()==83)))
                STDLY_SEARCH_start_enddate();
            var STDLY_SEARCH_startdate = $('#STDLY_SEARCH_db_startdate').datepicker('getDate');
            var date = new Date( Date.parse( STDLY_SEARCH_startdate ) );
            date.setDate( date.getDate() ); // + 1
            var STDLY_SEARCH_newDate = date.toDateString();
            STDLY_SEARCH_newDate = new Date( Date.parse( STDLY_SEARCH_newDate ) );
            $('#STDLY_SEARCH_db_enddate').datepicker("option","minDate",STDLY_SEARCH_newDate);
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
            $('#STDLY_SEARCH_lbl_salarycomments').hide();
            var STDLY_SEARCH_searchoptio=$('#STDLY_SEARCH_lb_searchoption').val();
            var STDLY_SEARCH_salaryoptionval=$('#STDLY_SEARCH_lb_salarysearchoption').val();
            var STDLY_SEARCH_staffoptionval=$("#STDLY_SEARCH_lb_staffsearchoption").val();
            if(STDLY_SEARCH_searchoptio==78)
            {
                if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
                    if(ErrorControl.AmountCompare=='Valid')
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                    }
                    else
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                    }
                }
                if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
                    $('#STDLY_SEARCH_btn_agentsbutton').removeAttr("disabled");
                    if(ErrorControl.AmountCompare=='Valid')
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                    }
                    else
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                        $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
                    }
                }
                else
                {
                    $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
                }
            }
            if(STDLY_SEARCH_searchoptio==77)
            {
                if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_tb_searchcomments").val()==""))
                {
                    $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_agentsbutton').removeAttr("disabled");
                }
            }
            if(STDLY_SEARCH_searchoptio==76)
            {
                if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
                {
                    $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_agentsbutton').removeAttr("disabled");
                }
            }
            if(STDLY_SEARCH_salaryoptionval==86)
            {
                if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
//                    if(ErrorControl.AmountCompare=='Valid')
//                    {
//                        $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
//                    }
//                    else
//                    {
//                        $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
//                    }
                }
                if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
                    $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
//                    if(ErrorControl.AmountCompare=='Valid')
//                    {
//                        $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
//                    }
//                    else
//                    {
//                        $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
//                        $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
//                    }
                }
                else
                {
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
            }
//VALIDATION BY SALARY AMOUNT..................
            if(STDLY_SEARCH_salaryoptionval==88)
            {
                if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
                    if(ErrorControl.AmountCompare=='Valid')
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                    }
                    else
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                    }
                }
                if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
                    $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
                    if(ErrorControl.AmountCompare=='Valid')
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                    }
                    else
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                        $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                    }
                }
                else
                {
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
            }
//VALIDATION BY SALARY COMMENTS..................
            if(STDLY_SEARCH_salaryoptionval==85)
            {
                if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_tb_searchcomments").val()==""))
                {
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
                }
            }
//VALIDATION BY FROM PERIOD..................
            if(STDLY_SEARCH_salaryoptionval==91)
            {
                if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
                {
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
                }
            }
//VALIDATION BY LEVY AMOUNT..................
            if(STDLY_SEARCH_salaryoptionval==87)
            {
                if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
                    if(ErrorControl.AmountCompare=='Valid')
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                    }
                    else
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                    }
                }
                if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
                    $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
                    if(ErrorControl.AmountCompare=='Valid')
                    {
                        $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                    }
                    else
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                        $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                    }
                }
                else
                {
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
            }
//VALIDATION BYSALARY PAID DATE................
            if(STDLY_SEARCH_salaryoptionval==89)
            {
                if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
                {
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
                }
            }
//VALIDATION BY SEARCH BY TO PERIOD................
            if(STDLY_SEARCH_salaryoptionval==92)
            {
                if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
                {
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
                }
            }
//STAFF SEARCH...................
//SEARCH BY CATEGORY...............
            var STDLY_SEARCH_staffoptionval=$("#STDLY_SEARCH_lb_staffsearchoption").val();
            if(STDLY_SEARCH_staffoptionval==80)
            {
                if(($("#STDLY_SEARCH_lb_staffexpansecategory").val()=="SELECT")||($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
                {
                    $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
                }
            }
//VALIDATION TO SEARCH ,BY STAFF INVOICE AMOUNT//
            if(STDLY_SEARCH_staffoptionval==84)
            {
                if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
                    if(ErrorControl.AmountCompare=='Valid')
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                    }
                    else
                    {
                        $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                    }
                }
                if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
                {
                    $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
                }
            }
//VALIDATION TO SEARCH  , SEARCH BY INVOICE DATE//
            if(STDLY_SEARCH_staffoptionval==81)
            {
                if(($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_db_startdate").val()==""))
                {
                    $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
                }
            }
//VALIDATION TO SEARCH , SEARCH BY INVOICE FROM//
            if(STDLY_SEARCH_staffoptionval==82)
            {
                if(($("#STDLY_SEARCH_tb_invfromcomt").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_db_startdate").val()==""))
                {
                    $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
                }
            }
//VALIDATION TO SEARCH , SEARCH BY INVOICE ITEMS//
            if(STDLY_SEARCH_staffoptionval==83)
            {
                if(($("#STDLY_SEARCH_tb_invitemcomt").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_db_startdate").val()==""))
                {
                    $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
                }
            }
//VALIDATION TO SEARCH , SEARCH BY STAFF COMMENTS.........
            if(STDLY_SEARCH_staffoptionval==79)
            {
                if(($("#STDLY_SEARCH_tb_searchcomments").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_db_startdate").val()==""))
                {
                    $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
                }
            }
        }
    });
    $('.amtvalidation').blur(function(){
        $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
        $('#STDLY_SEARCH_lbl_salarycomments').hide();
        $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#STDLY_SEARCH_lbl_headermesg').hide();
        $('#STDLY_SEARCH_tble_multi').hide();
        $('#STDLY_SEARCH_div_htmltable').hide();
        $('#STDLY_SEARCH_div_salaryhtmltable').hide();
        $('#STDLY_SEARCH_tble_agentupdateform').hide();
        $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
        $('#STDLY_SEARCH_btn_deletebutton').hide();
        $('#STDLY_SEARCH_btn_sbutton').hide();
        $('#STDLY_SEARCH_btn_searchbutton').hide();
        $('#STDLY_SEARCH_btn_rbutton').hide();
        var STDLY_SEARCH_listoption=$('#STDLY_SEARCH_lb_typelist').val();
        if(STDLY_SEARCH_listoption==39)
        {
            if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                }
            }
            if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
//                alert($("#STDLY_SEARCH_tb_fromamount").val() +'op'+$("#STDLY_SEARCH_tb_toamount").val())
                $('#STDLY_SEARCH_btn_agentsbutton').removeAttr("disabled");
//                alert(ErrorControl.AmountCompare)
//                if(ErrorControl.AmountCompare=='Valid')
//                {
//                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
//                }
//                else
//                {
//                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
//                    $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
//                }
            }
            else
            {
                $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
            }
        }
        if(STDLY_SEARCH_listoption==40)
        {
            if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
//                if(ErrorControl.AmountCompare=='Valid')
//                {
//                    $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
//                }
//                else
//                {
//                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
//                }
            }
            if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
//                if(ErrorControl.AmountCompare=='Valid')
//                {
//                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
//                }
//                else
//                {
//                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
//                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
//                }
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
        }
        if(STDLY_SEARCH_listoption==41)
        {
            if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
//                if(ErrorControl.AmountCompare=='Valid')
//                {
//                    $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
//                }
//                else
//                {
//                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
//                }
            }
            if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
//                if(ErrorControl.AmountCompare=='Valid')
//                {
//                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
//                }
//                else
//                {
//                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
//                    $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
//                }
            }
            else
            {
                $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            }
        }
    });
    //LIST BOX ITEM CHANGE FUNCTION
    $('.PE_rd_selectform').click(function(){
        $(".preloader").show();
        listboxoption=$(this).val();
//        $('#ET_ENTRY_ta_subject').val('');
//        $('#CONFIG_SRCH_UPD_div_htmltable').hide();
//        $('#CONFIG_SRCH_UPD_div_header').hide();
//        $("#STDTL_INPUT_lb_employeename").hide();
//        $("#STDTL_INPUT_lbl_employeename").hide();
//        $("#CONFIG_ENTRY_tr_type").hide();
//        $("#CONFIG_ENTRY_tr_data").hide();
//        $("#CONFIG_ENTRY_tr_btn").hide();
//        $('#STDTL_INPUT_noform').hide();
        $('#staffdly_lb_type').html('');
        if(listboxoption=='STAFF ENTRY')
        {
            $('#staffdly_lb_type').show();
            $('#staffdly_lbl_type').show();
//            $('#STDTL_SEARCH_div_headernodata').hide();
//            $('#searchfrm').hide();
//            $('#STDTL_SEARCH_lbl_searchoptionheader').hide();
//            $('#STDTL_SEARCH_tble_amt_option').hide();
//            $('#STDLY_SEARCH_lb_typelist').hide();
//            $('#STDLY_SEARCH_lbl_type').hide();
//            $('#STDLY_SEARCH_lb_salarysearchoption').hide();
//            $('#STDLY_SEARCH_lbl_salarysearchoption').hide();
//            $('#STDLY_SEARCH_lbl_startdate').hide();
//            $('#STDLY_SEARCH_db_startdate').hide();
//            $('#STDLY_SEARCH_lbl_enddate').hide();
//            $('#STDLY_SEARCH_db_enddate').hide();
//            $('#STDLY_SEARCH_tble_agenttable').hide();
//            $('#STDLY_SEARCH_lb_searchoption').hide();
//            $('#STDLY_SEARCH_lb_searchoption').hide();
//            $('#STDLY_SEARCH_lbl_byagentcomments').hide();
//            $('#STDLY_SEARCH_tb_fromamount').hide();
//            $('#STDLY_SEARCH_tb_toamount').hide();
//            $('#STDLY_SEARCH_lbl_fromamount').hide();
//            $('#STDLY_SEARCH_lbl_toamount').hide();
//            $('#STDLY_SEARCH_btn_agentsbutton').hide();
//            $('#STDLY_SEARCH_btn_salarybutton').hide();
//            $('#STDLY_SEARCH_btn_staffbutton').hide();
//            $('#STDLY_SEARCH_lbl_searchoption').hide();
            $.ajax({
                type: "POST",
                'url':STDLY_SEARCH_controller_url+"Initialdata",
                data:{'ErrorList':'337,169,105,400,45,106,107,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,169,170,315,377,378,379,401'},
                success: function(data){
                    $('.preloader').hide();
                    var value_array=JSON.parse(data);
                    expencetype=value_array[0];
                    checktable=value_array[1];
                    employeename=value_array[2];
                    errormsg=value_array[3];
                    if(expencetype!=''){
                        $('#staffdly_lb_type').append($('<option> SELECT </option>'));

                        for(var i=0;i<expencetype.length;i++)
                        {
                            if( i>=5 && i<=7)
                            {
                                var expid=expencetype[i].ECN_ID;
                                var expdata=expencetype[i].ECN_DATA;
                                $('#staffdly_lb_type').append($('<option>').text(expdata).attr('value', expid));
                            }
                            if( i>=0 && i<=4)
                            {
                                catid=expencetype[i].ECN_ID;
                                catdata=expencetype[i].ECN_DATA;
                                $('#STDLY_INPUT_lb_category1').append($('<option>').text(catdata).attr('value', catid));
                            }
                        }
                    }
                    if(checktable!=''){
                        $('#staffdly_lb_employee').append($('<option> SELECT </option>'));
                        var staffdly_employeename=[];
                        for(var i=0;i<checktable.length;i++)
                        {
                            staffdly_employeename.push(checktable[i].EMPLOYEE_NAME);
                        }
                        var staffdly_unique_employee=staffdly_unique(staffdly_employeename);
                        staffdly_unique_employee=staffdly_unique_employee.sort();
                        if(checktable.length!=0){
                            for(var j=0;j<staffdly_unique_employee.length;j++)
                            {
                                var listdata=staffdly_unique_employee[j];
                                $('#staffdly_lb_employee').append($('<option>').text(listdata).attr('value', listdata));
                            }
                        }
                    }
                }
            });
        }
        else if(listboxoption=='STAFF SEARCH/UPDATE')
        {
//            $('#staffdly_lb_type').hide();
//            $('#STDLY_SEARCH_lb_salarysearchoption').hide();
//            $('#staffdly_lbl_type').hide();
//            $("#STDLY_SEARCH_lb_typelist").val('SELECT').show();
//            $("#STDLY_SEARCH_lbl_type").show();
//            $('#agent_searchdiv').show();
//            $('#STDLY_SEARCH_lb_searchoption').hide();
//            $('#STDTL_SEARCH_lb_cpfnumber_listbox').hide();
//            $("#STDTL_SEARCH_lb_employeename_listbox").hide();
//            $("#staffdly_invdate").hide();
//            $("#staffdly_invdt").hide();
//            $("#staffdly_comisnamt").hide();
//            $("#staffdly_agentcomments").hide();
//            $("#staffdly_employee").hide();
//            $("#staffdly_cpf").hide();
//            $("#staffdly_paiddt").hide();
//            $("#staffdly_fromdt").hide();
//            $("#STDLY_INPUT_btn_sbutton").hide();
//            $("#staffdly_resetbutton").hide();
//            $("#staffdly_todt").hide();
//            $("#staffdly_salaryamt").hide();
//            $("#staffdly_ta_salarycomments").hide();
////            $("#STDTL_INPUT_lbl_comments").hide();
//            $("#STDLY_SEARCH_tblSTDLY_SEARCH_tb_searchcommentse_multi").hide();
            $.ajax({
                type: "POST",
                'url':STDLY_SEARCH_controller_url+"STDLY_SEARCH_searchbyagentcommission",
                success: function(data){
                    $('.preloader').hide();
                    STDLY_SEARCH_expenseArray=JSON.parse(data);
                    expencetype=STDLY_SEARCH_expenseArray[0];
                    STDLY_SEARCH_agenttable=STDLY_SEARCH_expenseArray[1];
                    STDLY_SEARCH_empdetail=STDLY_SEARCH_expenseArray[1];
                    STDLY_SEARCH_empdetailstaffsalary=STDLY_SEARCH_expenseArray[1];
                    STDLY_SEARCH_expensestaffsalary=STDLY_SEARCH_expenseArray[1];
                    STDLY_SEARCH_expensestaff=STDLY_SEARCH_expenseArray[1];
                    if(expencetype!=''){
                        $('#STDLY_SEARCH_lb_typelist').append($('<option> SELECT </option>'));
                        for(var i=0;i<expencetype.length;i++)
                        {
                            if( i>=5 && i<=7)
                            {
                                var expid=expencetype[i].ECN_ID;
                                var expdata=expencetype[i].ECN_DATA;
//                        if(listboxoption=='STAFF ENTRY')
                                $('#STDLY_SEARCH_lb_typelist').append($('<option>').text(expdata).attr('value', expid));
//                        else
//                        $('#STDLY_SEARCH_lb_typelist').append($('<option>').text(expdata).attr('value', expid));
                            }
                        }
                    }
                }
            });
        }
    });
    function STDLY_SEARCH_loadagentsearchoptionlist()
    {$(".preloader").hide();
        var STDLY_SEARCH_options ='';
        for (var i = 0; i < STDLY_SEARCH_agenttable.length; i++) {
            if( i>=8 && i<=10)
            {
                var STDLY_SEARCH_expenseArrayallid=STDLY_SEARCH_agenttable[i].ECN_ID;
                var STDLY_SEARCH_expenseArray=STDLY_SEARCH_agenttable[i].ECN_DATA;
                STDLY_SEARCH_options += '<option value="' + STDLY_SEARCH_expenseArrayallid+ '">' + STDLY_SEARCH_expenseArray+ '</option>';
            }
        }

        $('#STDLY_SEARCH_lbl_searchoption').show();
        $('#STDLY_SEARCH_lb_searchoption').html(STDLY_SEARCH_options);
        STDLY_SEARCH_Sortit('STDLY_SEARCH_lb_searchoption');
        $('#STDLY_SEARCH_lb_searchoption').show();
        $("select#STDLY_SEARCH_lb_searchoption")[0].selectedIndex = 0;
    }
    //SORTING FUNCTION
    function STDLY_SEARCH_Sortit(lbid) {
        var $r = $("#"+lbid+" "+"option");
        $r.sort(function(a, b) {
            if (a.text < b.text) return -1;
            if (a.text == b.text) return 0;
            return 1;
        });
        $($r).remove();
        $("#"+lbid).append($($r));
        $("#"+lbid+" "+"option").eq(0).before('<option value="SELECT">SELECT</option>')
        $("select#"+lbid)[0].selectedIndex = 0;
    }
    $('textarea').autogrow({onInitialize: true});
    $(".numonly").doValidation({rule:'numbersonly',prop:{realpart:5}});
    $("#staffdly_tb_comisnamt").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
    $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
    $(".amtonlysalary").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
    $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
    $("#STDLY_SEARCH_tb_fromamount").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2,smallerthan:'STDLY_SEARCH_tb_toamount'}}).width(60);
    $("#STDLY_SEARCH_tb_toamount").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2,greaterthan:'STDLY_SEARCH_tb_fromamount'}}).width(60);
    var catid;
// DATE PICKER FOR THE AGENT COMMISION
    $("#staffdly_invdate").datepicker({
        dateFormat:'dd-mm-yy',
        changeYear: true,
        changeMonth: true
    });
// DATE PICKER FOR THE STAFF
    $("#STDLY_INPUT_db_invdate1").datepicker({
        dateFormat:'dd-mm-yy',
        changeYear: true,
        changeMonth: true
    });
    $('#staffdly_tb_cursalary').hide();
    $('#staffdly_tb_newsalary').hide();
    $('#staffdly_tb_curcpfamt').hide();
    $('#staffdly_tb_newcpfamt').hide();
    $('#staffdly_tb_curlevyamt').hide();
    $('#staffdly_tb_newlevyamt').hide();
    $('#STDLY_INPUT_tb_hidelevy').hide();
// initial data
    $('#spacewidth').height('0%');
    $('#agent_comisndiv,#salary_entrydiv,#staffdiv,#buttons,#staff_errordiv').hide();
    var staffdly_currentsal='';
    var staffdly_currentcpf='';
    var staffdly_currentlevy='';
    var staffdly_employeeRadio=[];
    var checktable=[];
    var employeename=[];
    var category=[];
    var expencetype=[];
    var errormsg;
    var catdata=[];
    var catid=[];

    function staffdly_unique(a) {
        var result = [];
        $.each(a, function(i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
    }
// change event for expense
    $(document).on('change','#staffdly_lb_type',function(){
//        $("html, body").animate({ scrollTop: '100' }, "slow");
        $('#STDLY_INPUT_btn_sbutton').attr('disabled','disabled');
        var expensetype =$(this).val();
        if(expensetype=='SELECT'){
            $('#agent_comisndiv,#salary_entrydiv,#staffdiv,#buttons').hide();
         }
        if(expensetype==39){
            $('#agent_comisndiv,#buttons').show();
            $('#salary_entrydiv,#staffdiv,#staff_errordiv').hide();
            $('#staffdly_invdate').datepicker("option","maxDate",new Date());
            $('#STDLY_INPUT_btn_sbutton').attr('disabled','disabled').show();
            $('#staffdly_resetbutton').show();
        }
        if(expensetype==40){
            if((checktable.length==0)||(employeename.length==0))
            {
                $('#staff_errordiv').show();
                if((checktable.length==0)&&(employeename.length==0))
                {
                    $('#staffdly_lbl_erromsg').text(errormsg[1].EMC_DATA).show();
                    $('#staffdly_lbl_edtlerromsg').text(errormsg[2].EMC_DATA).show();
                }
                if((checktable.length==0)&&(employeename.length!=0))
                {
                    $('#staffdly_lbl_erromsg').text(errormsg[1].EMC_DATA).show();
                    $('#staffdly_lbl_edtlerromsg').text(errormsg[2].EMC_DATA).hide();
                }
                if((checktable.length!=0)&&(employeename.length==0))
                {
                    $('#staffdly_lbl_erromsg').text(errormsg[1].EMC_DATA).hide();
                    $('#staffdly_lbl_edtlerromsg').text(errormsg[2].EMC_DATA).show();
                }
            }
            else{
                $('#salary_entrydiv,#buttons').show();
                $('#agent_comisndiv,#staffdiv,#staff_errordiv').hide();
                $('#staffdly_paiddate').datepicker("option","maxDate",new Date());
                $('#staffdly_rd_curlevyamt').removeAttr("disabled");
                $('#staffdly_rd_cursalary').removeAttr("disabled");
                $('#staffdly_rd_newsalary').removeAttr("disabled");
                $('#staffdly_rd_curcpfamt').removeAttr("disabled");
                $('#staffdly_rd_newcpfamt').removeAttr("disabled");
                $('#staffdly_rd_newlevyamt').removeAttr("disabled");
                $('input[name="salarysalaryopt"]').prop('checked', false);
                $('input[name="salarycpfamtopt"]').prop('checked', false);
                $('input[name="salarylevyamtopt"]').prop('checked', false);
                $('#STDLY_INPUT_btn_sbutton').attr('disabled','disabled').show();
                $('#staffdly_resetbutton').show();
            }
            $('#staffdly_tb_cursalary').hide();
            $('#staffdly_tb_newsalary').hide();
            $('#staffdly_tb_curcpfamt').hide();
            $('#staffdly_tb_newcpfamt').hide();
            $('#staffdly_tb_curlevyamt').hide();
            $('#staffdly_tb_newlevyamt').hide();
            $('#staffdly_lb_employee').prop('selectedIndex',0);
            $('#staffdly_paiddate').val('');
            $('#staffdly_fromdate').val('');
            $('#staffdly_todate').val('');
            $('#staffdly_tb_cpf').val('');
        }
        if(expensetype==41){
            $('#staffdiv').show();
            $('#agent_comisndiv,#salary_entrydiv,#buttons,#staff_errordiv').hide();
            STAFF_clear_staff();
            STAFF_categorytyperesult();
        }
    });
// botton reset
    $(document).on('click','#staffdly_resetbutton',function(){
        var STDLY_INPUT_listvalue=$('#staffdly_lb_type').val();
        if(STDLY_INPUT_listvalue==39)
        {
            $('#staffdly_invdate').val('');
            $('#staffdly_tb_comisnamt').val('');
            $('#staffdly_ta_agentcomments').val('');
            $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
        }
        if(STDLY_INPUT_listvalue==40)
        {
            $('#staffdly_tb_cursalary').val('');
            $('#staffdly_tb_newsalary').val('');
            $('#staffdly_tb_curcpfamt').val('');
            $('#staffdly_tb_newcpfamt').val('');
            $('#staffdly_tb_curlevyamt').val('');
            $('#staffdly_tb_newlevyamt').val('');
            $('#staffdly_tb_cursalary').hide();
            $('#staffdly_tb_newsalary').hide();
            $('#staffdly_tb_curcpfamt').hide();
            $('#staffdly_tb_newcpfamt').hide();
            $('#staffdly_tb_curlevyamt').hide();
            $('#staffdly_tb_newlevyamt').hide();
            $("select#staffdly_lb_employee")[0].selectedIndex = 0;
            $('#staffdly_fromdate').val('');
            $('#staffdly_todate').val('');
            $('#staffdly_paiddate').val('');
            $('#staffdly_tb_cpf').val('');
            $('#STDLY_INPUT_btn_staffsbutton').hide();
            $('#STDLY_INPUT_ta_salarycommentsbox').val('');
            $('input[name="salarysalaryopt"]').prop('checked', false);
            $('input[name="salarycpfamtopt"]').prop('checked', false);
            $('input[name="salarylevyamtopt"]').prop('checked', false);
            $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
            $('#STDLY_INPUT_tble_multipleemployee').empty();
            $('#staffdly_fromdate') .datepicker( "option", "maxDate", new Date());
            $('#staffdly_todate') .datepicker( "option", "maxDate", new Date());
            $('#staffdly_todate') .datepicker( "option", "minDate",null );
        }
        if(STDLY_INPUT_listvalue==41)
        {
            $('#STDLY_INPUT_lb_category1').val('');
            $('#STDLY_INPUT_db_invdate1').val('');
            $('#STDLY_INPUT_lb_incamtrp1').val('');
            $('#STDLY_INPUT_ta_invitem1').val('');
            $('#STDLY_INPUT_tb_invfrom1').val('');
            $('#STDLY_INPUT_tb_comments1').val('');
            $('#STDLY_INPUT_tb_hidesal1').val('');
            $('#STDLY_INPUT_tb_hidecpf1').val('');
            $('#STDLY_INPUT_btn_addbtn1').attr("disabled", "disabled");
            $('#STDLY_INPUT_btn_staffsbutton').attr("disabled", "disabled");
        }
        $('#STDLY_INPUT_ta_comment,#STDLY_INPUT_ta_salarycommentsbox,#STDLY_INPUT_tb_comments1,#STDLY_INPUT_ta_invitem1').height(20);

    });
// CHANGE THE EMPLOYEE NAME
    function STAFFDLY_func_salaryentryclear(){
        $('#staffdly_tb_cursalary').val('').hide();
        $('#staffdly_tb_newsalary').val('').hide();
        $('#staffdly_tb_curcpfamt').val('').hide();
        $('#staffdly_tb_newcpfamt').val('').hide();
        $('#staffdly_tb_curlevyamt').val('').hide();
        $('#staffdly_tb_newlevyamt').val('').hide();
        $('#staffdly_todate').val('');
        $('#staffdly_fromdate').val('');
        $('#staffdly_paiddate').val('');
        $('#staffdly_ta_salarycomments').val('');
        $('#staffdly_salaryamt').find('input:radio').removeAttr('checked');
        $('#staffdly_rd_cursalary').removeAttr("disabled");
        $('#staffdly_rd_curcpfamt').removeAttr("disabled");
        $('#staffdly_rd_curlevyamt').removeAttr("disabled");
        $('#staffdly_rd_newsalary').removeAttr("disabled");
        $('#staffdly_rd_newcpfamt').removeAttr("disabled");
        $('#staffdly_rd_newlevyamt').removeAttr("disabled");
        $('#STDLY_INPUT_btn_sbutton').show();
        $('#staffdly_resetbutton').show();
        staffdly_currentsal='';
        staffdly_currentcpf='';
        staffdly_currentlevy='';
    }
// CHANGE FUNCTION FOR SALARY ENTRY
    $(document).on('change','#staffdly_lb_employee',function(){
        $('#staffdly_hidden_edssid').val('');
        STAFFDLY_func_salaryentryclear();
        var staffdly_listvalue=$('#staffdly_lb_employee').find('option:selected').text();
        if(staffdly_listvalue=="SELECT")
        {
            STAFFDLY_func_salaryentryclear();
            $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
            $('#staffdly_tb_cpf').val('');
            $('#STDLY_INPUT_tble_multipleemployee').empty();
        }
        else
        {
            staffdly_employeeRadio=[];
            $('#STDLY_INPUT_tble_multipleemployee').empty();
            for(var k=0;k<checktable.length;k++)
            {
                if(checktable[k].EMPLOYEE_NAME==staffdly_listvalue)
                {
                    staffdly_employeeRadio.push(checktable[k])
                }
            }
            if(staffdly_employeeRadio.length!=1)
            {
                STAFFDLY_func_salaryentryclear();
                $('#staffdly_tb_cpf').val('');
                for (var i=0;i<staffdly_employeeRadio.length;i++)
                {
                    var staffdly_val_emplyidname=staffdly_employeeRadio[i].EMPLOYEE_NAME+'-'+staffdly_employeeRadio[i].EMP_ID;
                    var staffdly_tr_radio ='<div class="col-sm-offset-3" style="padding-left:15px"><div class="radio"><label><input type="radio" value='+staffdly_employeeRadio[i].EMPLOYEE_NAME+' id='+staffdly_val_emplyidname+' name="staffdly_rd_employee" class="staffdly_sameemployee"/>'+ staffdly_val_emplyidname +'</label></div></div>';
                    $('#STDLY_INPUT_tble_multipleemployee').append(staffdly_tr_radio);
                    $('#STDLY_INPUT_tble_multipleemployee').show();
                }
            }
            else
            {
                $('#STDLY_INPUT_tble_multipleemployee').empty();
                staffdly_currentsal=staffdly_employeeRadio[0].EDSS_SALARY_AMOUNT;
                staffdly_currentcpf=staffdly_employeeRadio[0].EDSS_CPF_AMOUNT;
                staffdly_currentlevy=staffdly_employeeRadio[0].EDSS_LEVY_AMOUNT;
                $('#staffdly_hidden_edssid').val(staffdly_employeeRadio[0].EDSS_ID);
                var staffdly_arr_loadamt=[];
                staffdly_arr_loadamt.push(staffdly_employeeRadio[0].EDSS_CPF_NUMBER);
                staffdly_arr_loadamt.push(staffdly_employeeRadio[0].EDSS_LEVY_AMOUNT);
                STAFFDLY_loadamt(staffdly_arr_loadamt);
            }
        }
    });
// LOAD THE AMOUNT FOR THE LEVY ,SALARY AND CPF
    function STAFFDLY_loadamt(cpfamt)
    {
        var staffdly_getamtno=[];
        staffdly_getamtno=cpfamt;
        var staffdly_no=staffdly_getamtno[0];
        var staffdly_levy_amount=staffdly_getamtno[1];
        $('#staffdly_tb_cpf').val(staffdly_no);
        var staffdly_empname=$("#staffdly_lb_employee").val();
        if(staffdly_empname=='SELECT')
        {
            $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
        }
        else
        {
            if(staffdly_no==null)
            {
                $('#staffdly_tb_cpf').text("");
                $('#staffdly_rd_curcpfamt').attr("disabled", "disabled");
                $('#staffdly_rd_newcpfamt').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_rd_curcpfamt').removeAttr("disabled");
                $('#staffdly_rd_newcpfamt').removeAttr("disabled");
            }
            if(staffdly_levy_amount==null)
            {
                $('#staffdly_rd_curlevyamt').attr("disabled", "disabled");
            }
            else
            {
                $('#staffdly_rd_curlevyamt').removeAttr("disabled");
            }
        }
    }
// CLICK FUNCTION FOR SAME EMPLOYEE NAME
    $(document).on('click','.staffdly_sameemployee',function(){
//        $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
        STAFFDLY_func_salaryentryclear();
        for (var i=0;i<staffdly_employeeRadio.length;i++) {
            if(staffdly_employeeRadio[i].EDSS_ID==$(this).val()){
                staffdly_currentsal=staffdly_employeeRadio[i].EDSS_SALARY_AMOUNT;
                staffdly_currentcpf=staffdly_employeeRadio[i].EDSS_CPF_AMOUNT;
                staffdly_currentlevy=staffdly_employeeRadio[i].EDSS_LEVY_AMOUNT;
                var  staffdly_arr_loadamt=[];
                staffdly_arr_loadamt.push(staffdly_employeeRadio[i].EDSS_CPF_NUMBER);
                staffdly_arr_loadamt.push(staffdly_employeeRadio[i].EDSS_LEVY_AMOUNT);
                STAFFDLY_loadamt(staffdly_arr_loadamt);
            }
        }
    });
// RADIO BUTTON FUNCTIONS FOR GET SALARY AMOUNT IN THE SALARY ENTRY
    $('#staffdly_rd_cursalary').click(function(){
        $('#staffdly_tb_newsalary').val('').hide();
        $('#staffdly_tb_cursalary').val(staffdly_currentsal).show();
        var staffdly_listvalue=$('#staffdly_lb_employee').val();
    });
// SHOW THE TEXTBOX FOR CURRENT SALARY ENTRY
    $('#staffdly_rd_newsalary').click(function(){
        $('#staffdly_tb_cursalary').hide();
        $('#staffdly_tb_newsalary').val('').show();
    });
// RADIO BUTTON FUNCTIONS FOR GET CPF AMOUNT IN THE SALARY ENTRY
    $('#staffdly_rd_curcpfamt').click(function(){
        $('#staffdly_tb_newcpfamt').val('').hide();
        $('#staffdly_tb_curcpfamt').val(staffdly_currentcpf).show();
        var staffdly_listvalue=$('#staffdly_lb_employee').val();
    });
// SHOW THE TEXTBOX FOR CPF AMOUNT ENTRY
    $('#staffdly_rd_newcpfamt').click(function(){
        $('#staffdly_tb_curcpfamt').hide();
        $('#staffdly_tb_newcpfamt').val('').show();
    });
// RADIO BUTTON FUNCTIONS FOR GET LEVY AMOUNT IN THE SALARY ENTRY
    $('#staffdly_rd_curlevyamt').click(function(){
        $('#staffdly_tb_newlevyamt').val('').hide();
        $('#staffdly_tb_curlevyamt').val(staffdly_currentlevy).show();
        var staffdly_listvalue=$('#staffdly_lb_employee').val();
    });
// SHOW THE TEXTBOX FOR LEVY AMOUNT ENTRY
    $('#staffdly_rd_newlevyamt').click(function(){
        $('#staffdly_tb_curlevyamt').hide();
        $('#staffdly_tb_newlevyamt').val('').show();
    });

// DATE PICKER FOR THE SALARY ENTRY
    $("#staffdly_paiddate").datepicker({
        dateFormat:"dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var staffdly_datepaid = $('#staffdly_paiddate').datepicker('getDate');
            var date = new Date(Date.parse(staffdly_datepaid));
            date.setDate( date.getDate() - 1 );
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#staffdly_fromdate').datepicker("option","maxDate",newDate);
            $('#staffdly_todate').datepicker("option","maxDate",newDate);
            if( $('#staffdly_rd_cursalary').is(":checked")==true)
            {
                var staffdly_radio_radiovalue="data";
            }
            else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
            {
                var staffdly_radio_radiovalue="data";
            }
            if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
            {
                $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
            }
        }
    });
// DATE PICKER FUNCTION FOR  FOR DATEBOX IN SALARY ENTRY...............
    $("#staffdly_fromdate").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var staffdly_fromdate = $('#staffdly_fromdate').datepicker('getDate');
            var date = new Date( Date.parse( staffdly_fromdate ) );
            date.setDate( date.getDate()  ); //+ 1
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#staffdly_todate').datepicker("option","minDate",newDate);
            var paiddate = $('#staffdly_paiddate').datepicker('getDate');
            var date = new Date( Date.parse( paiddate ) );
            date.setDate( date.getDate() - 1 );
            var paidnewDate = date.toDateString();
            paidnewDate = new Date( Date.parse( paidnewDate ) );
            $('#staffdly_todate').datepicker("option","maxDate",paidnewDate);
            if( $('#staffdly_rd_cursalary').is(":checked")==true)
            {
                var staffdly_radio_radiovalue="data";
            }
            else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
            {
                var staffdly_radio_radiovalue="data";
            }
            if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
            {
                $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
            }
        }
    });
// DATE PICKER FOR TO DATE IN THE  SALARY ENTRY.....................
    $("#staffdly_todate").datepicker({
        dateFormat:"dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var staffdly_fromdate = $('#staffdly_fromdate').datepicker('getDate');
            var date = new Date( Date.parse( staffdly_fromdate ) );
            date.setDate( date.getDate()  ); //+ 1
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#staffdly_todate').datepicker("option","minDate",newDate);
            var paiddate = $('#staffdly_paiddate').datepicker('getDate');
            var date = new Date( Date.parse( paiddate ) );
            date.setDate( date.getDate() - 1 );
            var paidnewDate = date.toDateString();
            paidnewDate = new Date( Date.parse( paidnewDate ) );
            $('#staffdly_todate').datepicker("option","maxDate",paidnewDate);
            if( $('#staffdly_rd_cursalary').is(":checked")==true)
            {
                var staffdly_radio_radiovalue="data";
            }
            else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
            {
                var staffdly_radio_radiovalue="data";
            }
            if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
            {
                $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
            }
        }
    });
// CHANGE THE PAID DATE  BOX ....................
    $("#staffdly_paiddate").change(function(){
        var staffdly_datep = $('#staffdly_paiddate').datepicker('getDate');
        var date = new Date( Date.parse( staffdly_datep ) );
        date.setDate( date.getDate() - 1 );
        var newDate = date.toDateString();
        newDate = new Date( Date.parse( newDate ) );
        $('#staffdly_fromdate').datepicker("option","maxDate",newDate);
        $('#staffdly_todate').datepicker("option","maxDate",newDate);
        if($("#staffdly_paiddate").val()!='' && $("#staffdly_todate").val()!='' && $("#staffdly_fromdate").val()!='')
        {
            $('#STDLY_INPUT_btn_sbutton').removeAttr('disabled');
        }
        else
        {
            $('#STDLY_INPUT_btn_sbutton').attr('disabled','disabled');
        }
        if( $('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var staffdly_radio_radiovalue="data";
        }
        else if(($('#staffdly_rd_newsalary').is(":checked")==true) && ($("#staffdly_tb_newsalary").val()!=""))
        {
            var staffdly_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
        {
            $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
        }
    });
// DATEPICKER FOR USING DATE IN THE SALARY ENTRY...............
    $(".datebox").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var staffdly_fromdate = $('#staffdly_fromdate').datepicker('getDate');
            var date = new Date( Date.parse( staffdly_fromdate ) );
            date.setDate( date.getDate() + 1 );
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#staffdly_todate').datepicker("option","minDate",newDate);
            var paiddate = $('#staffdly_paiddate').datepicker('getDate');
            var date = new Date( Date.parse( paiddate ) );
            date.setDate( date.getDate() - 1 );
            var paidnewDate = date.toDateString();
            paidnewDate = new Date( Date.parse( paidnewDate ) );
            $('#staffdly_todate').datepicker("option","maxDate",paidnewDate);
        }
    });
    //CHANGE THE FROM AND TO DATE BOX................
    $("#staffdly_fromdate").change(function(){
        var staffdly_fromdate = $('#staffdly_fromdate').datepicker('getDate');
        var date = new Date( Date.parse( staffdly_fromdate ) );
        date.setDate( date.getDate()); // + 1
        var newDate = date.toDateString();
        newDate = new Date( Date.parse( newDate ) );
        $('#staffdly_todate').datepicker("option","minDate",newDate);
        var paiddate = $('#staffdly_paiddate').datepicker('getDate');
        var date = new Date( Date.parse( paiddate ) );
        date.setDate( date.getDate() - 1 );
        var paidnewDate = date.toDateString();
        paidnewDate = new Date( Date.parse( paidnewDate ) );
        $('#staffdly_todate').datepicker("option","maxDate",paidnewDate);
        if( $('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var staffdly_radio_radiovalue="data";
        }
        else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
        {
            var staffdly_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
        {
            $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
        }
    });
// CHANGE TO DATE BOX..................
    $('#staffdly_todate').change(function(){
        if($('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var staffdly_radio_radiovalue="data";
        }
        else if(($('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!=""))
        {
            var staffdly_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(staffdly_radio_radiovalue !="data"))
        {
            $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
        }
    });
// SUBMIT BUTTON VALIDATION FOR THE AGENT COMISSION
    $(".submitvalamt").blur(function(){
        var staffdly_typrval=$("#staffdly_lb_type").val();
        if(staffdly_typrval==39)
        {
            if(($("#staffdly_invdate").val()=="")||($("#staffdly_tb_comisnamt").val()==""))
            {
                $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
            }
        }
    });
//SUBMIT VALIDATION FOR SUBMIT BUTTON..............................................
    $(document).on('blur','.submitval',function() {
        var STDLY_SEARCH_typrval=$("#staffdly_lb_type").val()
        if(STDLY_SEARCH_typrval==39)
        {
            if(($("#staffdly_invdate").val()=="")||($("#staffdly_tb_comisnamt").val()=="")||(parseInt($("#staffdly_tb_comisnamt").val())==0))
            {
                $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
            }
        }
        if(STDLY_SEARCH_typrval==40)
        {
            var flag=0;
            if( $('#staffdly_rd_cursalary').is(":checked")==true)
            {
                var STDLY_SEARCH_radio_radiovalue="data";
            }
            else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!="")&&(parseInt($("#staffdly_tb_newsalary").val())!=0))
            {
                var STDLY_SEARCH_radio_radiovalue="data";
            }
            if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(STDLY_SEARCH_radio_radiovalue !="data")||(( $('#staffdly_rd_newcpfamt').is(":checked")==true)&&($("#staffdly_tb_newcpfamt").val()==""))||(( $('#staffdly_rd_newlevyamt').is(":checked")==true)&&($("#staffdly_tb_newlevyamt").val()=="")))
            {
                flag=1;
            }
            if(flag=="1")
            {
                $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
            }
        }
    });
    $(".radiosubmitval").click(function(){
        var flag=0;
        if( $('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var STDLY_SEARCH_radio_radiovalue="data";
        }
        else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("#staffdly_tb_newsalary").val()!="")&&(parseInt($("#staffdly_tb_newsalary").val())!=0))
        {
            var STDLY_SEARCH_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(STDLY_SEARCH_radio_radiovalue !="data")||(( $('#staffdly_rd_newcpfamt').is(":checked")==true)&&($("#staffdly_tb_newcpfamt").val()==""))||(( $('#staffdly_rd_newlevyamt').is(":checked")==true)&&($("#staffdly_tb_newlevyamt").val()=="")))
        {
            flag=1;
        }
        if(flag=="1")
        {
            $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
        }
    });
//RADIO AMOUNT TEXTBOX VALIDATION.............................
    $(".radiotextboxsubmitval").change(function(){
        var flag=0;
        if( $('#staffdly_rd_cursalary').is(":checked")==true)
        {
            var STDLY_SEARCH_radio_radiovalue="data";
        }
        else if(( $('#staffdly_rd_newsalary').is(":checked")==true)&&($("staffdly_tb_newsalary").val()!="")&&(parseInt($("#staffdly_tb_newsalary").val())!=0))
        {
            var STDLY_SEARCH_radio_radiovalue="data";
        }
        if(($("#staffdly_lb_employee").val()=="SELECT")||($("#staffdly_paiddate").val()=="")||($("#staffdly_fromdate").val()=="")||($("#staffdly_todate").val()=="")||(STDLY_SEARCH_radio_radiovalue !="data")||(( $('#staffdly_rd_newcpfamt').is(":checked")==true)&&($("#staffdly_tb_newcpfamt").val()==""))||(( $('#staffdly_rd_newlevyamt').is(":checked")==true)&&($("#staffdly_tb_newlevyamt").val()=="")))
        {
            flag=1;
        }
        if(flag=="1")
        {
            $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
        }
    });
    //STAFF DATEBOX//
    $(".staffdatebox").datepicker({dateFormat:'dd-mm-yy',changeYear: true,changeMonth: true,
        onSelect: function(){
            if(($("#STDLY_SEARCH_lb_category1").val()=="SELECT")||($("#STDLY_SEARCH_db_invdate1").val()=="")||($("#STDLY_SEARCH_lb_incamtrp1").val()=="")||($("#STDLY_SEARCH_ta_invitem1").val()=="")||($("#STDLY_SEARCH_tb_invfrom1").val()==""))
            {
                $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_INPUT_btn_sbutton').removeAttr("disabled");
            }
        }
    });
    function STAFF_clear_staff(){
        $('#STDLY_INPUT_btn_sbutton').hide();
        $('#staffdly_resetbutton').hide();
        $('#STDLY_INPUT_lb_category1').val('SELECT');
        $('#STDLY_INPUT_db_invdate1').val('');
        $('#STDLY_INPUT_lb_incamtrp1').val('');
        $('#STDLY_INPUT_ta_invitem1').val('');
        $('#STDLY_INPUT_tb_invfrom1').val('');
        $('#STDLY_INPUT_tb_comments1').val('');
//        $('#STDLY_INPUT_btn_addbtn1').attr("disabled", "disabled").show();
        $('#staffdly_btn_delbtn1').attr("disabled", "disabled").show();
        $('#STDLY_INPUT_btn_staffsbutton').attr('disabled','disabled');
        var elmtTable = document.getElementById('STDLY_INPUT_tble_multi');
        var tableRows = elmtTable.getElementsByTagName('tr');
        var rowCount = tableRows.length;
        for(var x=0;x<rowCount;x++)
        {
            if((x==0)||(x==1))continue;
            if(x==3)
            {
                STAFF_clear_staff();
            }
            $('#STDLY_INPUT_lb_category'+x).remove();
            $('#STDLY_INPUT_db_invdate'+x).remove();
            $('#STDLY_INPUT_lb_incamtrp'+x).remove();
            $('#STDLY_INPUT_ta_invitem'+x).remove();
            $('#STDLY_INPUT_tb_invfrom'+x).remove();
            $('#STDLY_INPUT_tb_comments'+x).remove();
            $('#STDLY_INPUT_btn_addbtn'+x).remove();
            $('#staffdly_btn_delbtn'+x).remove();
            document.getElementById('STDLY_INPUT_tble_multi').deleteRow(x);
        }
        $('#STDLY_INPUT_lb_category1').val('SELECT');
        $('#STDLY_INPUT_db_invdate1').val('');
        $('#STDLY_INPUT_lb_incamtrp1').val('');
        $('#STDLY_INPUT_ta_invitem1').val('');
        $('#STDLY_INPUT_tb_invfrom1').val('');
        $('#STDLY_INPUT_tb_comments1').val('');
//        $('#STDLY_INPUT_btn_addbtn1').attr("disabled", "disabled").show();
        $('#staffdly_btn_delbtn1').attr("disabled", "disabled").show();
        $('#STDLY_INPUT_tble_multi').hide();
        STAFF_categorytyperesult();
    }
    function STDLY_INPUT_Sortit(lbid)
    {
        var $r = $("#"+lbid+" "+"option");
        $r.sort(function(a, b) {
            if (a.text < b.text) return -1;
            if (a.text == b.text) return 0;
            return 1;
        });
        $($r).remove();
        $("#"+lbid).append($($r));
        $("#"+lbid+" "+"option").eq(0).before('<option value="SELECT">SELECT</option>');
        $("select#"+lbid)[0].selectedIndex = 0;
    }
// LOAD THE CATEGORY TYPE IN THE LISTBOX...................
    function STAFF_categorytyperesult()
    {
        $(".preloader").hide();
        $('#STDLY_INPUT_tble_multi').show();
//        STDLY_INPUT_Sortit('STDLY_INPUT_lb_category1');
        $('#STDLY_INPUT_lb_category1').show();
        $('#STDLY_INPUT_btn_staffsbutton').attr("disabled", "disabled").show();
        $('#STDLY_INPUT_db_invdate1').datepicker("option","maxDate",new Date());
        $('#STDLY_INPUT_db_invdate1').show();
        $('#STDLY_INPUT_lb_incamtrp1').show();
        $('#STDLY_INPUT_ta_invitem1').show();
        $('#STDLY_INPUT_tb_invfrom1').show();
        $('#STDLY_INPUT_tb_comments1').show();
//        $('#STDLY_INPUT_btn_addbtn1').attr("disabled", "disabled").show();
        $('#staffdly_btn_delbtn1').attr("disabled", "disabled").show();
    }
// LOAD THE CATEGORY TYPE FOR INCREAMENT MULTIROW LISTBOX...............
    function STAFF_loadcategorymultirow()
    {
        $(".preloader").hide();
        var staffdly_options ='';
        var staffdly_val=$('#STDLY_INPUT_hidetablerowid').val();
        for (var i = 0; i < expencetype.length; i++)
        {
            if( i>=0 && i<=4)
            {
                var catid=expencetype[i].ECN_ID;
                var catdata=expencetype[i].ECN_DATA;
                $('#STDLY_INPUT_lb_category'+staffdly_val).append($('<option>').text(catdata).attr('value', catid));
            }
        }
        STDLY_INPUT_Sortit('STDLY_INPUT_lb_category'+staffdly_val);
    }
    function STDLY_INPUT_Sortit(lbid) {
        var $r = $("#"+lbid+" "+"option");
        $r.sort(function(a, b) {
            if (a.text < b.text) return -1;
            if (a.text == b.text) return 0;
            return 1;
        });
        $($r).remove();
        $("#"+lbid).append($($r));
        $("#"+lbid+" "+"option").eq(0).before('<option value="SELECT">SELECT</option>')
        $("select#"+lbid)[0].selectedIndex = 0;
    }
    //SAVE  AND GET CONFORM MESSAGE FROM TABLE FOR FLEX TABLE.....................
    $('#STDLY_INPUT_btn_sbutton').click(function(){
        $(".preloader").show();
        STDLY_INPUT_showconformmsg()
    });
    var STDLY_INPUT_response;
    var PDLY_INPUT_expensetype;
    var salary_entry_response;
    function STDLY_INPUT_showconformmsg()
    {
        PDLY_INPUT_expensetype=$('#staffdly_lb_type').val();
        $.ajax({
            type: "POST",
            data: $('#staffdlyentry_form').serialize(),
            'url':STDLY_SEARCH_controller_url+"STDLY_INPUT_savedata",
            success: function(data){
                alert(data)
                $('.preloader').hide();

                PDLY_INPUT_expensetype=$('#staffdly_lb_type').val();
                if(PDLY_INPUT_expensetype==39)
                {
                    STDLY_INPUT_response=JSON.parse(data)
                }
                else{
                    STDLY_INPUT_response=JSON.parse(data)
                    salary_entry_response=STDLY_INPUT_response[0].SUCCESSMSG
                }
                if(STDLY_INPUT_response==1)
                {
                    var PDLY_INPUT_expensetype=$('#staffdly_lb_type').find('option:selected').text();
                    var STDLY_INPUT_CONFSAVEMSG = errormsg[1].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetype);
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",STDLY_INPUT_CONFSAVEMSG,"error",false)
                    $('#staffdly_invdate').val('');
                    $('#staffdly_tb_comisnamt').val('');
                    $('#staffdly_ta_agentcomments').val('');
                    $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
                }
                else if(salary_entry_response==1)
                {
                    var PDLY_INPUT_expensetype=$('#staffdly_lb_type').find('option:selected').text();
                    var STDLY_INPUT_CONFSAVEMSG = errormsg[1].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetype);
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",STDLY_INPUT_CONFSAVEMSG,"error",false)
                    $('#STDLY_INPUT_btn_sbutton').attr("disabled", "disabled");
                    $("#staffdly_lb_employee")[0].selectedIndex = 0;
                    $('#staffdly_paiddate').val('');
                    $('#staffdly_fromdate').val('');
                    $('#staffdly_todate').val('');
                    $('#staffdly_ta_salarycomments').val('');
                    $('input[name="salarysalaryopt"]').prop('checked', false);
                    $('input[name="salarycpfamtopt"]').prop('checked', false);
                    $('input[name="salarylevyamtopt"]').prop('checked', false);
                    $('#staffdly_tb_newsalary').val('').hide();
                    $('#staffdly_tb_cursalary').val('').hide();
                    $('#staffdly_tb_curcpfamt').val('').hide();
                    $('#staffdly_tb_newcpfamt').val('').hide();
                    $('#staffdly_tb_curlevyamt').val('').hide();
                    $('#staffdly_tb_newlevyamt').val('').hide();
                }
                else{
                    if($('#staffdly_lb_type').val()==40&&salary_entry_response!="")
                    {
                        show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",salary_entry_response,"error",false)
                    }
                }
            }
        });
    }
    //<!-- MULTI ROW CREATION IN THE STAFF FOR INPUT PROCESS -->
    var incid=1;
    $(document).on('click','.addbttn',function() {
        $('#STDLY_INPUT_btn_staffsbutton').attr("disabled", "disabled");
        $('#STDLY_INPUT_btn_delbtn1').removeAttr("disabled");
        var STDLY_INPUT_table = document.getElementById('STDLY_INPUT_tble_multi');
        var STDLY_INPUT_rowCount = STDLY_INPUT_table.rows.length;
        incid =  STDLY_INPUT_rowCount;
        $('#STDLY_INPUT_hidetablerowid').val(incid);
        var STDLY_INPUT_deladdrem =incid-1;
        var STDLY_INPUT_deladdid=$('#STDLY_INPUT_hideaddid').val();
        var STDLY_INPUT_delremoid=$('#STDLY_INPUT_hideremoveid').val();
        $(STDLY_INPUT_deladdid).hide();
        $(STDLY_INPUT_delremoid).hide();
        $('#STDLY_INPUT_btn_addbtn1').hide();
        $('#STDLY_INPUT_btn_delbtn1').hide();
        $('#STDLY_INPUT_btn_addbtn'+STDLY_INPUT_deladdrem).hide();
        $('#STDLY_INPUT_btn_delbtn'+STDLY_INPUT_deladdrem).hide();
        var newRow = STDLY_INPUT_table.insertRow(STDLY_INPUT_rowCount);
        var fCell = newRow.insertCell(0);
        fCell.innerHTML ="<td> <select  class='submultivalid form-control' name='STDLY_INPUT_lb_category[]' id='"+"STDLY_INPUT_lb_category"+incid+"' ><option >SELECT</option></select> </td> "
        fCell = newRow.insertCell(1);
        fCell.innerHTML ="<td><input  class='datepickinc submultivalid datemandtry form-control' type='text' name ='STDLY_INPUT_db_invdate[]' id='"+"STDLY_INPUT_db_invdate"+incid+"' style='width:100px;' /> </td>"
        $(".datepickinc").datepicker({dateFormat:'dd-mm-yy',
            changeYear: true,
            changeMonth: true});
        $('#STDLY_INPUT_db_invdate'+incid).datepicker("option","maxDate",new Date());
        fCell = newRow.insertCell(2);
        fCell.innerHTML ="<td><input  class='amtonly submultivalid form-control' type='text'  name ='STDLY_INPUT_lb_incamtrp[]' id='"+"STDLY_INPUT_lb_incamtrp"+incid+"' style='width:80px;'/></td>"
        $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        fCell = newRow.insertCell(3);
        fCell.innerHTML ="<td><textarea class='submultivalid form-control' name='STDLY_INPUT_ta_invitem[]' id='"+"STDLY_INPUT_ta_invitem"+incid+"'></textarea></td>"
        fCell = newRow.insertCell(4);
        fCell.innerHTML ="<td><input  class='autosize submultivalid form-control' name ='STDLY_INPUT_tb_invfrom[]' id='"+"STDLY_INPUT_tb_invfrom"+incid+"' /></td>"
        $(".autosize").doValidation({rule:'general',prop:{uppercase:true,autosize:true}});
        fCell = newRow.insertCell(5);
        fCell.innerHTML = "<td><textarea  class='form-control' name ='STDLY_INPUT_tb_comments[]' id='"+"STDLY_INPUT_tb_comments"+incid+"'></textarea></td>"
        fCell = newRow.insertCell(6);
        fCell.innerHTML ="<td><input type='button' value='+' class='addbttn' alt='Add Row' height='30' width='30' name ='STDLY_INPUT_btn_addbtn' id='"+"STDLY_INPUT_btn_addbtn"+incid+"'/></td>";
        fCell = newRow.insertCell(7);
        fCell.innerHTML ="<td><input  type='button' value='-' class='deletebttn' alt='delete Row' height='30' width='30' name ='STDLY_INPUT_btn_delbtn' id='"+"STDLY_INPUT_btn_delbtn"+incid+"' /></td>";
        $('#STDLY_INPUT_btn_addbtn'+incid).attr("disabled", "disabled");
        STAFF_loadcategorymultirow();
    });
    //<!-- SUBMIT BUTTON VALIDATION FOR THE STAFF SECTION  -->
    $(document).on('blur','.submultivalid',function() {
        var e=$(this).attr('id');
        var staffdly_table = document.getElementById('STDLY_INPUT_tble_multi');
        var staffdly_table_rowlength=staffdly_table.rows.length;
        var count=0;
        for(var i=1;i<staffdly_table_rowlength;i++)
        {
            var unit=$('#STDLY_INPUT_lb_category'+i).val()
            var invoicedate=$('#STDLY_INPUT_db_invdate'+i).val()
            var fromdate=$('#STDLY_INPUT_lb_incamtrp'+i).val()
            var todate=$('#STDLY_INPUT_ta_invitem'+i).val()
            var payment=$('#STDLY_INPUT_tb_invfrom'+i).val()
            if((unit!=undefined)&&(unit!="SELECT")&&(unit!='')&&(payment!='')&&(fromdate!="")&&(todate!="")&&(fromdate!=undefined)&&(todate!=undefined)&&(invoicedate!=''))
            {
                count=count+1;
            }
        }
        if(count==staffdly_table_rowlength-1)
        {
            $('#STDLY_INPUT_btn_staffsbutton').removeAttr("disabled");
            $('#STDLY_INPUT_btn_addbtn'+(staffdly_table_rowlength-1)).removeAttr("disabled");
        }
        else
        {
            $('#STDLY_INPUT_btn_staffsbutton').attr("disabled", "disabled");
            $('#STDLY_INPUT_btn_addbtn'+(staffdly_table_rowlength-1)).attr("disabled", "disabled");
        }

    });
//<!-- DELETE THE REQUIRED ROW IN THE MULTIROW CREATION -->
    $(document).on('click','.deletebttn',function() {
        var table = document.getElementById('STDLY_INPUT_tble_multi');
        if(table.rows.length>2)
            $(this).closest("tr").remove();
        var STDLY_INPUT_table = document.getElementById('STDLY_INPUT_tble_multi');
        var STDLY_INPUT_table_rowlength=STDLY_INPUT_table.rows.length;
        var STDLY_INPUT_newid=STDLY_INPUT_table_rowlength-1;
        $('#STDLY_INPUT_btn_addbtn'+STDLY_INPUT_newid).show();
        $('#STDLY_INPUT_btn_delbtn'+STDLY_INPUT_newid).show();
        var count=0;
        for(var i=1;i<STDLY_INPUT_table_rowlength;i++)
        {
            var unit=$('#STDLY_INPUT_lb_category'+i).val()
            var invoicedate=$('#STDLY_INPUT_db_invdate'+i).val()
            var fromdate=$('#STDLY_INPUT_lb_incamtrp'+i).val()
            var todate=$('#STDLY_INPUT_ta_invitem'+i).val()
            var payment=$('#STDLY_INPUT_tb_invfrom'+i).val()
            if((unit!=undefined)&&(unit!="SELECT")&&(unit!='')&&(payment!='')&&(fromdate!="")&&(todate!="")&&(fromdate!=undefined)&&(todate!=undefined)&&(invoicedate!=''))
            {
                count=count+1;
            }
        }
        if(count==STDLY_INPUT_table_rowlength-1)
        {
            $('#STDLY_INPUT_btn_staffsbutton').removeAttr("disabled");
            $('#STDLY_INPUT_btn_addbtn'+(STDLY_INPUT_table_rowlength-1)).removeAttr("disabled");
        }
        else
        {
            $('#STDLY_INPUT_btn_staffsbutton').attr("disabled", "disabled");
            $('#STDLY_INPUT_btn_addbtn'+(STDLY_INPUT_table_rowlength-1)).attr("disabled", "disabled");
        }
        if(STDLY_INPUT_table_rowlength==2)
        {
            $('#STDLY_INPUT_btn_delbtn'+(STDLY_INPUT_table_rowlength-1)).attr("disabled", "disabled");
            $('#STDLY_INPUT_btn_delbtn').attr("disabled", "disabled");
        }
    });
    /LOAD THE CATEGORY TYPE IN THE LISTBOX...................
        function STDLY_INPUT_categorytyperesult()
    {$(".preloader").hide();
//STDLY_INPUT_categorytypearray=STDLY_INPUT_categorytype;
        var options =' ';
        for (var i = 0; i < STDLY_SEARCH_liststaffvaluesarray.length; i++) {
            if( i>=0 && i<=4)
            {options += '<option value="' + STDLY_SEARCH_liststaffidvaluesarray[i] + '">' + STDLY_SEARCH_liststaffvaluesarray[i] + '</option>';
            }}
        $('#STDLY_INPUT_tble_multi').show();
        $('#STDLY_INPUT_lb_category1').html(options);
        STDLY_INPUT_Sortit('STDLY_INPUT_lb_category1')
        $('#STDLY_INPUT_lb_category1').show();
        $('#STDLY_INPUT_lbl_expense').show();
        $('#STDLY_INPUT_btn_staffsbutton').show();
        $('#STDLY_INPUT_tble_multi').show();
        $('#STDLY_INPUT_lbl_expense').show();
        $('#STDLY_INPUT_lbl_invdate').show();
        $('#STDLY_INPUT_lbl_invamt').show();
        $('#STDLY_INPUT_lbl_invitm').show();
        $('#STDLY_INPUT_lbl_invfrom').show();
        $('#STDLY_INPUT_lbl_invcmt').show();
        $('#STDLY_INPUT_lbl_add').show();
        $('#STDLY_INPUT_lbl_del').show();
        $('#STDLY_INPUT_db_invdate1').datepicker("option","maxDate",new Date());
        $('#STDLY_INPUT_db_invdate1').show();
        $('#STDLY_INPUT_lb_incamtrp1').show();
        $('#STDLY_INPUT_ta_invitem1').show();
        $('#STDLY_INPUT_tb_invfrom1').show();
        $('#STDLY_INPUT_tb_comments1').show();
        $('#STDLY_INPUT_btn_addbtn1').show();
        $('#STDLY_INPUT_btn_delbtn1').show();
        $('#STDLY_INPUT_btn_addbtn1').attr("disabled", "disabled");
        $('#STDLY_INPUT_btn_delbtn1').attr("disabled", "disabled");
        $('#STDLY_INPUT_btn_staffsbutton').attr("disabled", "disabled");
        $('input[name="STDLY_INPUT_radio_slramt"]').prop('checked', false);
        $('input[name="STDLY_INPUT_radio_cpfamt"]').prop('checked', false);
        $('input[name="STDLY_INPUT_radio_levyamt"]').prop('checked', false);
    }
//SAVE  AND GET CONFORM MESSAGE FROM TABLE......................
    $('#STDLY_INPUT_btn_staffsbutton').click(function(){
        $(".preloader").show();
        STDLY_INPUT_savestaff()
    });
    var STDLY_INPUT_response;
    var salary_entry_response;
    function STDLY_INPUT_savestaff()
    {
        $.ajax({
            type: "POST",
            data: $('#staffdlyentry_form').serialize(),
            'url':STDLY_SEARCH_controller_url+"STDLY_INPUT_savestaff",
            success: function(data){
                alert(data)
                $('.preloader').hide();
                STDLY_INPUT_response=JSON.parse(data)
                salary_entry_response=STDLY_INPUT_response[0].FLAGINSERT
                if(salary_entry_response==1)
                {
                    var PDLY_INPUT_expensetype=$('#staffdly_lb_type').find('option:selected').text();
                    var STDLY_INPUT_CONFSAVEMSG = errormsg[1].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetype);
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",STDLY_INPUT_CONFSAVEMSG,"error",false)
                    $('#STDLY_INPUT_tble_multi').empty();
                    $('<tr><td style="width:240px"><label id="STDLY_INPUT_lbl_expense" >CATEGORY OF EXPENSE<em>*</em></label> </td><td style="width:150"><label  id="STDLY_INPUT_lbl_invdate" >INVOICE DATE<em>*</em></label></td><td style="width:125" ><label id="STDLY_INPUT_lbl_invamt" >INVOICE AMOUNT<em>*</em></label> </td><td style="width:150" ><label id="STDLY_INPUT_lbl_invitm" >INVOICE ITEMS<em>*</em></label> </td><td style="width:150" ><label id="STDLY_INPUT_lbl_invfrom" >INVOICE FROM<em>*</em></label> </td><td style="width:150"><label id="STDLY_INPUT_lbl_invcmt">COMMENTS</label></td></tr><tr><td> <select class="submultivalid form-control"   name="STDLY_INPUT_lb_category[]" id="STDLY_INPUT_lb_category1"  ><option >SELECT</option></select> </td> <td><input class="submultivalid datemandtry form-control"   type="text" name ="STDLY_INPUT_db_invdate[]" id="STDLY_INPUT_db_invdate1" style="width:100px;"  /> </td><td><input   type="text" name ="STDLY_INPUT_lb_incamtrp[]" id="STDLY_INPUT_lb_incamtrp1"  class="amtonly submultivalid form-control"  style="width:80px;"  /></td> <td><textarea class="submultivalid form-control"  name="STDLY_INPUT_ta_invitem[]" id="STDLY_INPUT_ta_invitem1"   ></textarea></td><td><input class="submultivalid autosize form-control"  type="text" name ="STDLY_INPUT_tb_invfrom[]" id="STDLY_INPUT_tb_invfrom1"  /></td><td><textarea  class="form-control" name ="STDLY_INPUT_tb_comments[]" id="STDLY_INPUT_tb_comments1"  ></textarea></td><td><input enabled type="button" disabled value="+" class="addbttn" alt="Add Row" height="30" width="30" name ="STDLY_INPUT_btn_addbtn" id="STDLY_INPUT_btn_addbtn1"  disabled/></td><td><input  type="button" value="-" class="deletebttn" alt="delete Row" height="30" width="30" name ="STDLY_INPUT_btn_delbtn" id="STDLY_INPUT_btn_delbtn1" disabled /></td></tr>').appendTo($('#STDLY_INPUT_tble_multi'))
                    $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
                    $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
                    $("#STDLY_INPUT_db_invdate1").datepicker({dateFormat:'dd-mm-yy',
                        changeYear: true,
                        changeMonth: true});
                }
                else
                {
                    $('#STDLY_INPUT_lb_category1').val('');
                    $('#STDLY_INPUT_db_invdate1').val('');
                    $('#STDLY_INPUT_lb_incamtrp1').val('');
                    $('#STDLY_INPUT_ta_invitem1').val('');
                    $('#STDLY_INPUT_tb_invfrom1').val('');
                    $('#STDLY_INPUT_tb_comments1').val('');
                    $('#STDLY_INPUT_tb_hidesal1').val('');
                    $('#STDLY_INPUT_tb_hidecpf1').val('');
                    $('#STDLY_INPUT_btn_addbtn1').attr("disabled", "disabled");
                    $('#STDLY_INPUT_tble_multipleemployee').empty();
                }
            }
        });
    }
    //UPDATE FORM START
    var STDLY_SEARCH_employeeNameArray=[];
    var STDLY_SEARCH_errorArray=[];
    var STDLY_SEARCH_expenseArray=[];
    var STDLY_SEARCH_errorArraye=[];
    var STDLY_SEARCH_staffExpArray=[];
    var STDLY_SEARCH_searchoptionexpenseArray=[];
    var STDLY_SEARCH_expenseArrayallid=[];
    var STDLY_SEARCH_arr_eacomments=[];
    var STDLY_SEARCH_arr_salcomments=[];
    var STDLY_SEARCH_arr_escomments=[];
    var STDLY_SEARCH_arr_esinvoicefrom=[];
    var STDLY_SEARCH_arr_esinvoiceitems=[];
//LOADING THE FIRST LIST BOX IN THE FORM..................
    $('#STDLY_SEARCH_lb_typelist').change(function(){
        $('#STDLY_SEARCH_lbl_amounterrormsg').text('');
        $('#STDLY_SEARCH_lb_searchbycpfno').hide();
        $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
        $('#STDLY_SEARCH_tb_cpfno').hide();
        $('#STDLY_SEARCH_lbl_cpf').hide();
        $('#STDLY_SEARCH_lbl_commentblrrormsg').hide();
        $('#STDLY_SEARCH_lbl_stafferrormsg').hide();
        $('#STDLY_SEARCH_lbl_stfsalaryerrormsg').hide();
        $('#STDLY_SEARCH_lbl_commentlbl').hide();
        $('#STDLY_SEARCH_tb_searchcomments').hide();
        $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
        $('#STDLY_SEARCH_lbl_salarycomments').hide();
        $(".preloader").show();
        $('#STDLY_SEARCH_lbl_byagentcomments').hide();
        $('#STDLY_SEARCH_lbl_searchbydiv').hide();
        $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
        $('#STDLY_SEARCH_lbl_salarycomments').hide();
        $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#STDLY_SEARCH_lbl_headermesg').hide();
        $('#STDLY_SEARCH_lbl_byemployeename').hide();
        $('#STDLY_SEARCH_db_startdate').hide();
        $('#STDLY_SEARCH_lbl_startdate').hide();
        $('#STDLY_SEARCH_lbl_enddate').hide();
        $('#STDLY_SEARCH_db_enddate').hide();
        $('#STDLY_SEARCH_lbl_fromamount').hide();
        $('#STDLY_SEARCH_tb_fromamount').hide();
        $('#STDLY_SEARCH_lbl_toamount').hide();
        $('#STDLY_SEARCH_tb_toamount').hide();
        var STDLY_SEARCH_listoption=$('#STDLY_SEARCH_lb_typelist').val();
        if(STDLY_SEARCH_listoption=="SELECT")
        {
            $(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lb_salarysearchoption').hide();
            $('#STDLY_SEARCH_lbl_salarysearchoption').hide();
            $('#STDLY_SEARCH_lb_staffsearchoption').hide();
            $('#STDLY_SEARCH_lbl_staffsearchoption').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_db_startdate').val('');
            $('#STDLY_SEARCH_db_enddate').val('');
            $('#STDLY_SEARCH_tb_fromamount').val('');
            $('#STDLY_SEARCH_tb_toamount').val('');
            $('#STDLY_SEARCH_lbl_searchoption').hide();
            $('#STDLY_SEARCH_lb_searchoption').hide();
            $("select#STDLY_SEARCH_lb_searchoption")[0].selectedIndex = 0;
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_listoption==39)
        {
            $('#STDLY_SEARCH_lbl_searchbydiv').hide();
            var STDLY_SEARCH_empdetf;
            if(STDLY_SEARCH_agenttable.length==0)
            {
                $(".preloader").hide();
                $('#STDLY_SEARCH_lbl_commentblrrormsg').text(STDLY_SEARCH_errorArray[32]);
                $('#STDLY_SEARCH_lbl_commentblrrormsg').show();
            }
            else
            {
                $('#STDLY_SEARCH_lbl_commentblrrormsg').hide();
                STDLY_SEARCH_loadagentsearchoptionlist();
            }
            $('#STDLY_SEARCH_lbl_stafferrormsg').hide();
            $('#STDLY_SEARCH_lbl_stfsalaryerrormsg').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lb_salarysearchoption').hide();
            $('#STDLY_SEARCH_lbl_salarysearchoption').hide();
            $('#STDLY_SEARCH_lb_staffsearchoption').hide();
            $('#STDLY_SEARCH_lbl_staffsearchoption').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_listoption==40)
        {
            if(STDLY_SEARCH_empdetail.length==0){
                $(".preloader").hide();
                $('#STDLY_SEARCH_lbl_commentblrrormsg').show();
                $('#STDLY_SEARCH_lbl_commentblrrormsg').text(STDLY_SEARCH_errorArray[29]);
            }
            if(STDLY_SEARCH_empdetailstaffsalary.length==0)
            {
                $(".preloader").hide();
                $('#STDLY_SEARCH_lbl_stafferrormsg').text(STDLY_SEARCH_errorArray[34]).show();
            }
            if(STDLY_SEARCH_expensestaffsalary.length==0)
            {
                $(".preloader").hide();
                $('#STDLY_SEARCH_lbl_stfsalaryerrormsg').text(STDLY_SEARCH_errorArray[33]).show();
            }
            $('#STDLY_SEARCH_lbl_searchbydiv').hide();
            if(((STDLY_SEARCH_empdetail).length!=0)&&((STDLY_SEARCH_empdetailstaffsalary).length!=0)&&((STDLY_SEARCH_expensestaffsalary).length!=0))
            {
                $('#STDLY_SEARCH_lbl_commentblrrormsg').hide();
                $('#STDLY_SEARCH_lbl_stafferrormsg').hide();
                $('#STDLY_SEARCH_lbl_stfsalaryerrormsg').hide();
                STDLY_SEARCH_loadsearchoptionlistdata();
            }
            $("select#STDLY_SEARCH_lb_salarysearchoption")[0].selectedIndex = 0;
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_searchoption').hide();
            $('#STDLY_SEARCH_lb_searchoption').hide();
            $('#STDLY_SEARCH_lb_staffsearchoption').hide();
            $('#STDLY_SEARCH_lbl_staffsearchoption').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
        }
        if(STDLY_SEARCH_listoption==41)
        {
            $('#STDLY_SEARCH_tb_cpfno').hide();
            $('#STDLY_SEARCH_lbl_cpf').hide();
            if((STDLY_SEARCH_expensestaff).length==0)
            {$(".preloader").hide();
                $('#STDLY_SEARCH_lbl_commentblrrormsg').text(STDLY_SEARCH_errorArray[3]).show();
            }else
            {
                $('#STDLY_SEARCH_lbl_commentblrrormsg').hide();
                STDLY_SEARCH_loadstaffsearchoptionlistdata();
            }
            $('#STDLY_SEARCH_lbl_stafferrormsg').hide();
            $('#STDLY_SEARCH_lbl_stfsalaryerrormsg').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $("select#STDLY_SEARCH_lb_staffsearchoption")[0].selectedIndex = 0;
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_searchoption').hide();
            $('#STDLY_SEARCH_lb_searchoption').hide();
            $('#STDLY_SEARCH_lb_salarysearchoption').hide();
            $('#STDLY_SEARCH_lbl_salarysearchoption').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').hide();
            $('#STDLY_SEARCH_tb_toamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_lbl_startdate').hide();
            $('#STDLY_SEARCH_db_startdate').hide();
            $('#STDLY_SEARCH_lbl_enddate').hide();
            $('#STDLY_SEARCH_db_enddate').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
    });
    function STDLY_SEARCH_loadstaffsearchoptionlistdata()
    {
        $(".preloader").hide();
        var STDLY_SEARCH_typrval=$("#STDLY_SEARCH_lb_typelist").val();
        if(STDLY_SEARCH_typrval==41)
        {
            var options =' ';
            for (var i = 0; i < STDLY_SEARCH_expensestaff.length; i++) {
                if( i>=11 && i<=16)
                {
                    var STDLY_SEARCH_expenseArrayallid=STDLY_SEARCH_expensestaff[i].ECN_ID;
                    var STDLY_SEARCH_expenseArray=STDLY_SEARCH_expensestaff[i].ECN_DATA;
                    options += '<option value="' + STDLY_SEARCH_expenseArrayallid+ '">' + STDLY_SEARCH_expenseArray+ '</option>';
                }
            }
        }
        $('#STDLY_SEARCH_tble_agenttable').show();
        $('#STDLY_SEARCH_lb_staffsearchoption').html(options);
        STDLY_SEARCH_Sortit('STDLY_SEARCH_lb_staffsearchoption');
        $('#STDLY_SEARCH_lb_staffsearchoption').show();
        $('#STDLY_SEARCH_lbl_staffsearchoption').show();
    }
    //LOAD THE SALARY LIST SEARCH OPTION LIST BOX VALUE ..............................
    function STDLY_SEARCH_loadsearchoptionlistdata()
    {
        $(".preloader").hide();
        var STDLY_SEARCH_typrval=$("#STDLY_SEARCH_lb_typelist").val();
        if(STDLY_SEARCH_typrval==41)
        {
            var options =' ';
            for (var i = 0; i < STDLY_SEARCH_expenseArrayallid.length; i++) {
                if( i>=12 && i<=16)
                {
                    options += '<option value="' + STDLY_SEARCH_expenseArrayallid[i] + '">' + STDLY_SEARCH_expenseArray[i] + '</option>';
                }
            }
        }
        var STDLY_SEARCH_typrval=$("#STDLY_SEARCH_lb_typelist").val();
        if(STDLY_SEARCH_typrval==40)
        {
            var options =' ';
            for (var i = 0; i < STDLY_SEARCH_empdetail.length; i++) {
                if( i>=17 && i<=25)
                {
                    var STDLY_SEARCH_expenseArrayallid=STDLY_SEARCH_empdetail[i].ECN_ID;
                    var STDLY_SEARCH_expenseArray=STDLY_SEARCH_empdetail[i].ECN_DATA;
                    options += '<option value="' + STDLY_SEARCH_expenseArrayallid+ '">' + STDLY_SEARCH_expenseArray+ '</option>';
                }
            }
        }
        $('#STDLY_SEARCH_lb_salarysearchoption').html(options);
        STDLY_SEARCH_Sortit('STDLY_SEARCH_lb_salarysearchoption');
        $('#STDLY_SEARCH_lbl_salarysearchoption').show();
        $('#STDLY_SEARCH_lb_searchoption').hide();
        $('#STDLY_SEARCH_lb_salarysearchoption').show();
    }
    //LOAD THE START FOR BY AGENT COMMISSION...................
    $('#STDLY_SEARCH_lb_searchoption').change(function(){
        $('#STDLY_SEARCH_lbl_commentlbl').hide();
        $('.datebox') .datepicker( "option", "minDate", null);
        $('.datebox') .datepicker( "option", "minDate", new Date(1969, 10 , 19));
        $('#STDLY_SEARCH_lbl_amounterrormsg').text('');
        $('#STDLY_SEARCH_lbl_errmsg').text('');
        $('#STDLY_SEARCH_tb_cpfno').hide();
        $('#STDLY_SEARCH_lbl_cpf').hide();
        $('#STDLY_SEARCH_lbl_byagentcomments').hide();
        $('#STDLY_SEARCH_lbl_searchbydiv').hide();
        $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
        $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
        $(".preloader").show();
        $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
        $('#STDLY_SEARCH_lbl_salarycomments').hide();
        $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#STDLY_SEARCH_lbl_headermesg').hide();
        var STDLY_SEARCH_searchoptio=$('#STDLY_SEARCH_lb_searchoption').val();
        if(STDLY_SEARCH_searchoptio=="SELECT")
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').hide();
            $('#STDLY_SEARCH_db_startdate').val('');
            $('#STDLY_SEARCH_db_enddate').val('');
            $('#STDLY_SEARCH_tb_fromamount').val('');
            $('#STDLY_SEARCH_tb_toamount').val('');
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_searchoptio==78)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_searchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_lbl_fromamount').show();
            $('#STDLY_SEARCH_tb_fromamount').val('').show();
            $('#STDLY_SEARCH_tb_toamount').val('').show();
            $('#STDLY_SEARCH_lbl_toamount').show();
            $('#STDLY_SEARCH_btn_agentsbutton').show();
            $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDTL_INPUT_lbl_comments').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_searchoptio==77)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').hide();
            $('#STDLY_SEARCH_tb_toamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_searchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_searchoptio==76)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').hide();
            $('#STDLY_SEARCH_tb_toamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').show();
            $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_byagentcomments').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_searchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDTL_INPUT_lbl_comments').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
        }
    });
//SEND VALUES TO GS FOR LOAD THE FLEX TABLES.....................
    $('#STDLY_SEARCH_btn_agentsbutton').click(function(){
//        var  newPos= adjustPosition($(this).position(),100,120);
//        resetPreloader(newPos);
        $('#STDLY_SEARCH_btn_searchbutton').hide();
        $('#STDLY_SEARCH_btn_deletebutton').hide();
        STDLY_SEARCH_agentsearching();
//        STDLY_SEARCH_hideagent();
    });
    function STDLY_SEARCH_agentsearching()
    {
        $(".preloader").show();
        var STDLY_SEARCH_searchoptionmatch=$("#STDLY_SEARCH_lb_searchoption").val();
        if(STDLY_SEARCH_searchoptionmatch==78)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount=$('#STDLY_SEARCH_tb_fromamount').val();
            var STDLY_SEARCH_toamount=$('#STDLY_SEARCH_tb_toamount').val();
            var STDLY_SEARCH_searchcomments="";
            STDLY_SEARCH_searchdetails()
        }
        if(STDLY_SEARCH_searchoptionmatch==77)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_searchcomments=$('#STDLY_SEARCH_tb_searchcomments').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            STDLY_SEARCH_searchdetails()
        }
        if(STDLY_SEARCH_searchoptionmatch==76)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_selectedcpfno="";
            var STDLY_SEARCH_selectedempname="";
            STDLY_SEARCH_searchdetails()
        }
    }
    var values_array;
    var STDLY_SEARCH_date;
    var STDLY_SEARCH_agentcommamount;
    var STDLY_SEARCH_agentcomments;
    var STDLY_SEARCH_agentuserstamp;
    var STDLY_SEARCH_agenttimestamp;
    var id;
    function  STDLY_SEARCH_searchdetails()
    {
        var STDLY_SEARCH_startdate = $("#STDLY_SEARCH_db_startdate").val();
        var STDLY_SEARCH_enddate = $("#STDLY_SEARCH_db_enddate").val();
        var STDLY_SEARCH_fromamount = $("#STDLY_SEARCH_tb_fromamount").val();
        var STDLY_SEARCH_toamount = $("#STDLY_SEARCH_tb_toamount").val();
        var STDLY_SEARCH_searchoptio=$('#STDLY_SEARCH_lb_searchoption').val();
        var STDLY_SEARCH_searchcomments=$('#STDLY_SEARCH_tb_searchcomments').val();
        $('.preloader').hide();
        $.ajax({
            type: "POST",
            'url':STDLY_SEARCH_controller_url+"fetchdata",
            data: {'STDLY_SEARCH_searchoptio':STDLY_SEARCH_searchoptio,'STDLY_SEARCH_startdate':STDLY_SEARCH_startdate,'STDLY_SEARCH_enddate':STDLY_SEARCH_enddate,'STDLY_SEARCH_fromamount':STDLY_SEARCH_fromamount,'STDLY_SEARCH_toamount':STDLY_SEARCH_toamount,'STDLY_SEARCH_searchcomments':STDLY_SEARCH_searchcomments},
            success: function(data) {
                values_array=JSON.parse(data);
                if(values_array.length!=0)
                {
                    if(STDLY_SEARCH_searchoptio==76)
                    {
                        $('#STDLY_SEARCH_lbl_nodataerrormsg').show();
                        var STDLY_SEARCH_edate=$('#STDLY_SEARCH_db_enddate').val();
                        var STDLY_SEARCH_sdate=$('#STDLY_SEARCH_db_startdate').val();
                        var STDLY_SEARCH_conformsg=STDLY_SEARCH_errorArray[5];
                        var STDLY_SEARCH_CONFSAVEMSGs = STDLY_SEARCH_conformsg.replace('[SDATE]',":"+ STDLY_SEARCH_sdate);
                        var STDLY_SEARCH_CONFSAVEMSG = STDLY_SEARCH_CONFSAVEMSGs.replace('[EDATE]', STDLY_SEARCH_edate);
                    }
                    $('#STDLY_SEARCH_lbl_headermesg').text(STDLY_SEARCH_CONFSAVEMSG);
                    $('#STDLY_SEARCH_lbl_headermesg').show();
                    var STDLY_SEARCH_table_value='<table id="STDLY_SEARCH_tbl_htmltable" border="1"  cellspacing="0" class="srcresult"  ><thead  bgcolor="#6495ed" style="color:white"><tr><th>DELETE</th><th class="uk-date-column" style="width:75px">AGENT DATE</th><th style="width:60px">COMMISSION AMOUNT</th><th style="width:300px;">COMMENTS</th><th style="width:200px;">USERSTAMP</th><th style="width:100px;" >TIMESTAMP</th></tr></thead><tbody>'
//                    var ET_SRC_UPD_DEL_errmsg =value_err_array[4].EMC_DATA.replace('[SCRIPT]',ET_SRC_UPD_DEL_name);
//                    $('#ET_SRC_UPD_DEL_div_header').text(ET_SRC_UPD_DEL_errmsg).show();
                    alert(STDLY_SEARCH_table_value)
                    for(var j=0;j<values_array.length;j++){
                        STDLY_SEARCH_date=values_array[j].DATE;
                        STDLY_SEARCH_agentcommamount=values_array[j].AMNT;
                        STDLY_SEARCH_agentcomments=values_array[j].COMMENTS;
                        if((STDLY_SEARCH_agentcomments=='null')||(STDLY_SEARCH_agentcomments==undefined))
                        {
                            STDLY_SEARCH_agentcomments='';
                        }
                        STDLY_SEARCH_agentuserstamp=values_array[j].userstamp;
                        STDLY_SEARCH_agenttimestamp=values_array[j].timestamp;
                        id=values_array[j].EA_ID;
                        STDLY_SEARCH_table_value+='<tr><td><div class="col-lg-1"><span style="display: block;color:red" id ='+id+' class="glyphicon glyphicon-trash deletebutton" title="Delete"></span></div></td><td id=agentdate_'+id+' class="staffedit">'+STDLY_SEARCH_date+'</td><td id=agentcommissionamt_'+id+' class="staffedit">'+STDLY_SEARCH_agentcommamount+'</td><td id=comments_'+id+' class="staffedit">'+STDLY_SEARCH_agentcomments+'</td><td>'+STDLY_SEARCH_agentuserstamp+'</td><td>'+STDLY_SEARCH_agenttimestamp+'</td></tr>';
                   alert(STDLY_SEARCH_table_value+'***')
                    }
                    STDLY_SEARCH_table_value+='</tbody></table>';
                    alert(STDLY_SEARCH_table_value)
                    $('section').html(STDLY_SEARCH_table_value);
                    $('#STDLY_SEARCH_tbl_htmltable').DataTable({
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers",
                        "aoColumnDefs" : [
                            { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ]

                    });
                }
                else
                {
                    $('#ET_SRC_UPD_DEL_div_header').hide();
                    $('#ET_SRC_UPD_DEL_div_table').hide();
//                    $('#ET_SRC_UPD_DEL_div_headernodata').text(value_err_array[2].EMC_DATA).show();
                    $('#ET_SRC_UPD_DEL_tble_htmltable').hide();
                    $('section').html('');
                    $('.preloader').hide();
                }
                $('#STDLY_SEARCH_div_htmltable').show();
            },
            error:function(data){
                alert(JSON.stringify(data))
            }
        });
        sorting()
    }
    var previous_id;
    var combineid;
    var tdvalue;
    var check;
    var cpfid;
    var checkamt;
    var cpfnoid;
    var levyamount_id;
    var STDTL_SEARCH_agentcommissionamt;
    var comments_id;
    var STDTL_SEARCH_currentval;
    var agentdate_id;
    var agent_commissionamt;
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
            $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='"+cpfnoid+"' name='data'  class='staffupdate' maxlength='9'  value='"+tdvalue+"'>");
        }
        else if(id[0]=='agentcommissionamt' && tdvalue!=''){
            agent_commissionamt='agentamt_'+id[1];
            $('#agentcommissionamt_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='"+agent_commissionamt+"' name='data'  class='staffupdate amountonly' maxlength='50'  value='"+tdvalue+"'>");
            $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        }
        else if(id[0]=='comments'){
            comments_id='commentsid_'+id[1];
            $('#comments_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><textarea id='"+comments_id+"' name='data'  class='staffupdate' style='width: 200px'>"+tdvalue+"</textarea></td>");
        }
        else if(id[0]=='agentdate'){
            agentdate_id='agentdateid_'+id[1];
            $('#agentdate_'+id[1]).replaceWith("<td  class='new' id='"+agentdate_id+"'><input type='text' id='agent_date' name='data'  class='staffupdate form-control date-picker'  style='width: 110px' value='"+tdvalue+"'></td>");
        }
        $(".date-picker").datepicker({dateFormat:'dd-mm-yy',
            changeYear: true,
            changeMonth: true
        });
        $('.date-picker').datepicker("option","maxDate",new Date());
    });
    //blur function for subject update
    $(document).on('change','.staffupdate',function(){
        STDTL_SEARCH_currentval=$(this).val().trim();
        STDTL_SEARCH_agentcommissionamt=$('#'+agent_commissionamt).val();
        STDLY_SEARCH_comments=$('#'+comments_id).val();
        if($('#agentdate_'+combineid).hasClass("staffedit")==true){

            var agentdate=$('#agentdate_'+combineid).text();
        }
        else{
            var agentdate=$('#agent_date').val();
        }
        if($('#agentcommissionamt_'+combineid).hasClass("staffedit")==true){
            var STDTL_SEARCH_agentcommissionamt=$('#agentcommissionamt_'+combineid).text();
        }
        else{
            var STDTL_SEARCH_agentcommissionamt=STDTL_SEARCH_agentcommissionamt;
        }
        if($('#comments_'+combineid).hasClass("staffedit")==true){
            var STDLY_SEARCH_comments=$('#comments_'+combineid).text();
        }
        else{
            var STDLY_SEARCH_comments=STDLY_SEARCH_comments;
        }
//        var data = $('#staffdlyentry_form').serialize();
        var STDLY_SEARCH_typelist=$('#STDLY_SEARCH_lb_typelist').val();
        $.ajax({
            type: "POST",
            'url':STDLY_SEARCH_controller_url+"updatefunction",
            data:{'id':combineid,'STDLY_SEARCH_typelist':STDLY_SEARCH_typelist,'agentdate':agentdate,'STDLY_SEARCH_comments':STDLY_SEARCH_comments,'STDTL_SEARCH_agentcommissionamt':STDTL_SEARCH_agentcommissionamt},
            success: function(STDLY_SEARCH_upd_res) {
                if(STDLY_SEARCH_upd_res=='true')
                {
                    var replacetype=$('#STDLY_SEARCH_lb_typelist').find('option:selected').text();
                    var STDLY_INPUT_CONFSAVEMSG = errormsg[2].EMC_DATA.replace('[TYPE]', replacetype);
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",STDLY_INPUT_CONFSAVEMSG,"success",false)
                    previous_id=undefined;
                    STDLY_SEARCH_searchdetails()
                }
                else
                {
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",errormsg[38].EMC_DATA,"error",false)
                }
            }
        });
    });
    //click event for delete btn
    var rowid='';
    $(document).on('click','.deletebutton',function(){
        rowid = $(this).attr('id');
        show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",errormsg[32].EMC_DATA,"success","delete");
    });
    //CLICK FUNCTION FOR OK BUTTON IN DELETE MESSAGE BOX
    $(document).on('click','.deleteconfirm',function(){
        var STDLY_SEARCH_typelist=$('#STDLY_SEARCH_lb_typelist').val();
        var STDLY_SEARCH_srchoption=$('#STDLY_SEARCH_lb_searchoption').val();
        var  newPos= adjustPosition($(this).position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        $.ajax({
            type: "POST",
            url:STDLY_SEARCH_controller_url+"deleteconformoption",
            data :{'rowid':rowid,'STDLY_SEARCH_typelist':STDLY_SEARCH_typelist,'STDLY_SEARCH_srchoption':STDLY_SEARCH_srchoption},
            success: function(data) {
                $('.preloader').hide();
                var successresult=JSON.parse(data);
                var STDLY_SEARCH_res=successresult;
                if(STDLY_SEARCH_res==1){
                     STDLY_SEARCH_agentsearching();
                    STDLY_SEARCH_salarysearchdetails()
                    STDLY_SEARCH_staffsearchdetails()
                    if($('#STDLY_SEARCH_lb_typelist').val()==39)
                        var STDLY_SEARCH_sec_searchoption=$('#STDLY_SEARCH_lb_searchoption').val();
                    if($('#STDLY_SEARCH_lb_typelist').val()==40)
                        var STDLY_SEARCH_sec_searchoption=$('#STDLY_SEARCH_lb_salarysearchoption').val();
                    if($('#STDLY_SEARCH_lb_typelist').val()==41)
                        var STDLY_SEARCH_sec_searchoption=$('#STDLY_SEARCH_lb_staffsearchoption').val();
                    STDLY_SEARCH_success_comments(STDLY_SEARCH_sec_searchoption)
                    $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");

                    var replacetype=errormsg[3].EMC_DATA.replace('[TYPE]', $('#STDLY_SEARCH_lb_typelist').find('option:selected').text());
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",replacetype,"error",false)

//                    STDLY_SEARCH_arr_esinvoicefrom=STDLY_SEARCH_res[1][0];
//                    STDLY_SEARCH_arr_esinvoiceitems=STDLY_SEARCH_res[1][0];
//                    $('#STDLY_SEARCH_tble_agentupdateform').hide();
//                    $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
//                    $('#STDLY_SEARCH_tble_multi').hide();
//                    $('#STDLY_SEARCH_tble_agentupdateform').hide();
//                    var STDLY_SEARCH_listoption=$('#STDLY_SEARCH_lb_typelist').val();
//                    if((STDLY_SEARCH_listoption==39)&&($('#STDLY_SEARCH_lb_searchoption').val()==77))
//                    {
//                        if(STDLY_SEARCH_res[0][0].length>0)
//                            STDLY_SEARCH_arr_eacomments=STDLY_SEARCH_res[0][0];
//                    }
//                    if((STDLY_SEARCH_listoption==40)&&($('#STDLY_SEARCH_lb_salarysearchoption').val()==85))
//                    {
//                        if(STDLY_SEARCH_res[0][0].length>0)
//                            STDLY_SEARCH_arr_salcomments=STDLY_SEARCH_res[0][0];
//                    }
//                    if(((STDLY_SEARCH_listoption==41)&&($('#STDLY_SEARCH_lb_staffsearchoption').val()==79))||((STDLY_SEARCH_listoption==41)&&($('#STDLY_SEARCH_lb_staffsearchoption').val()==82))||((STDLY_SEARCH_listoption==41)&&($('#STDLY_SEARCH_lb_staffsearchoption').val()==83)))
//                    {
//                        if(STDLY_SEARCH_res[0][0].length>0){
//                            if($('#STDLY_SEARCH_lb_staffsearchoption').val()==79)
//                                STDLY_SEARCH_arr_escomments=STDLY_SEARCH_res[0][0];
//                            if($('#STDLY_SEARCH_lb_staffsearchoption').val()==82)
//                                STDLY_SEARCH_arr_esinvoicefrom=STDLY_SEARCH_res[0][0];
//                            if($('#STDLY_SEARCH_lb_staffsearchoption').val()==83)
//                                STDLY_SEARCH_arr_esinvoiceitems=STDLY_SEARCH_res[0][0];
//                        }
//                    }
//                    if(STDLY_SEARCH_listoption==39)
//                    {
//                        if((STDLY_SEARCH_listoption==39)&&($('#STDLY_SEARCH_lb_searchoption').val()==77)){
//                            if(STDLY_SEARCH_res[1][0].length>0)
//                                STDLY_SEARCH_arr_eacomments=STDLY_SEARCH_res[1][0];}
//                        STDLY_SEARCH_agentsearching();
//                    }
//                    if(STDLY_SEARCH_listoption==40)
//                    {
//                        if((STDLY_SEARCH_listoption==40)&&($('#STDLY_SEARCH_lb_salarysearchoption').val()==85)){
//                            if(STDLY_SEARCH_res[1][0].length>0)
//                                STDLY_SEARCH_arr_salcomments=STDLY_SEARCH_res[1][0];}
//                        STDLY_SEARCH_salaryfunction();
//                    }
//                    if(STDLY_SEARCH_listoption==41)
//                    {if(((STDLY_SEARCH_listoption==41)&&($('#STDLY_SEARCH_lb_staffsearchoption').val()==79))||((STDLY_SEARCH_listoption==41)&&($('#STDLY_SEARCH_lb_staffsearchoption').val()==82))||((STDLY_SEARCH_listoption==41)&&($('#STDLY_SEARCH_lb_staffsearchoption').val()==83)))
//                    {
//                        if(STDLY_SEARCH_res[1][0].length>0){
//                            if($('#STDLY_SEARCH_lb_staffsearchoption').val()==79)
//                                STDLY_SEARCH_arr_escomments=STDLY_SEARCH_res[0][0];
//                            if($('#STDLY_SEARCH_lb_staffsearchoption').val()==82)
//                                STDLY_SEARCH_arr_esinvoicefrom=STDLY_SEARCH_res[0][0];
//                            if($('#STDLY_SEARCH_lb_staffsearchoption').val()==83)
//                                STDLY_SEARCH_arr_esinvoiceitems=STDLY_SEARCH_res[0][0];
//                        }}
//                        STDLY_SEARCH_staffsearching();
//                    }
//                    $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
//                    $('#STDLY_SEARCH_lbl_salarycomments').hide();
////                    var errmsg=value_err_array[4].EMC_DATA.replace('[PROFILE]',EP_ENTRY_listboxname);
////                    show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",errmsg,"success",false)
////                    EP_SRC_UPD_DEL_srch_result()
                    STDLY_SEARCH_staffsearchdetails()
                }
                else
                {
                    show_msgbox("STAFF EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",errormsg[31].EMC_DATA,"error",false);
                }
            }

        });
    });
    //FUNCTION TO GET COMMENTS WITH COUNT
    function STDLY_SEARCH_start_enddate(){
        $('#STDLY_SEARCH_lbl_errmsg').text('');
        if(($('#STDLY_SEARCH_db_startdate').val()!='')&&($('#STDLY_SEARCH_db_enddate').val()!='')){
            if($('#STDLY_SEARCH_lb_typelist').val()==39)
                var STDLY_SEARCH_sec_searchoption=$('#STDLY_SEARCH_lb_searchoption').val();
            if($('#STDLY_SEARCH_lb_typelist').val()==40)
                var STDLY_SEARCH_sec_searchoption=$('#STDLY_SEARCH_lb_salarysearchoption').val();
            if($('#STDLY_SEARCH_lb_typelist').val()==41)
                var STDLY_SEARCH_sec_searchoption=$('#STDLY_SEARCH_lb_staffsearchoption').val();
            STDLY_SEARCH_success_comments(STDLY_SEARCH_sec_searchoption)
            $('.preloader').show();
        }
    }
    var STDLY_SEARCH_res_comments;
    var STDLY_SEARCH_arr_eacomments=[];
    function STDLY_SEARCH_success_comments(STDLY_SEARCH_sec_searchoption)
    {
        var STDLY_SEARCH_startdate = $("#STDLY_SEARCH_db_startdate").val();
        var STDLY_SEARCH_enddate = $("#STDLY_SEARCH_db_enddate").val();
        var STDLY_SEARCH_typelist = $("#STDLY_SEARCH_lb_typelist").val();
        $.ajax({
            type: "POST",
            'url':STDLY_SEARCH_controller_url+"STDLY_SEARCH_func_comments",
            data: {'STDLY_SEARCH_sec_searchoption':STDLY_SEARCH_sec_searchoption,'STDLY_SEARCH_startdate':STDLY_SEARCH_startdate,'STDLY_SEARCH_enddate':STDLY_SEARCH_enddate,'STDLY_SEARCH_typelist':STDLY_SEARCH_typelist},
            success: function(data) {
                STDLY_SEARCH_res_comments=JSON.parse(data);
                $('.preloader').hide();
                if(STDLY_SEARCH_res_comments.length!=0)
                {
                    if(STDLY_SEARCH_sec_searchoption==77){
                        $('#STDLY_SEARCH_lbl_commentlbl').show();
                        STDLY_SEARCH_arr_eacomments=STDLY_SEARCH_res_comments;
                        $('#STDLY_SEARCH_tb_searchcomments').val('');
                        $('#STDLY_SEARCH_tb_searchcomments').removeAttr("disabled").attr('placeholder',STDLY_SEARCH_res_comments.length+' Records Matching').val('').show();
                    }
                    if(STDLY_SEARCH_sec_searchoption==85){
                        $('#STDLY_SEARCH_lbl_commentlbl').show();
                        STDLY_SEARCH_arr_eacomments=STDLY_SEARCH_res_comments;
                        $('#STDLY_SEARCH_tb_searchcomments').val('');
                        $('#STDLY_SEARCH_tb_searchcomments').removeAttr("disabled").attr('placeholder',STDLY_SEARCH_res_comments.length+' Records Matching').val('').show();
                    }
                    if(STDLY_SEARCH_sec_searchoption==82){
                        $('#STDLY_SEARCH_lbl_invfromcomt').val('').show();
                        STDLY_SEARCH_arr_esinvoicefrom=STDLY_SEARCH_res_comments;
                        $('#STDLY_SEARCH_tb_invfromcomt').val('')
                        $('#STDLY_SEARCH_tb_invfromcomt').removeAttr("disabled").attr('placeholder',STDLY_SEARCH_res_comments.length+' Records Matching').val('').show();
                    }
                    if(STDLY_SEARCH_sec_searchoption==83){
                        $('#STDLY_SEARCH_lbl_invitemcom').val('').show();
                        STDLY_SEARCH_arr_esinvoiceitems=STDLY_SEARCH_res_comments;
                        $('#STDLY_SEARCH_tb_invitemcomt').val('')
                        $('#STDLY_SEARCH_tb_invitemcomt').removeAttr("disabled").attr('placeholder',STDLY_SEARCH_res_comments.length+' Records Matching').val('').show();
                    }
                    if(STDLY_SEARCH_sec_searchoption==79){
                        $('#STDLY_SEARCH_lbl_commentlbl').val('').show();
                        STDLY_SEARCH_arr_escomments=STDLY_SEARCH_res_comments;
                        $('#STDLY_SEARCH_tb_searchcomments').val('')
                        $('#STDLY_SEARCH_tb_searchcomments').removeAttr("disabled").attr('placeholder',STDLY_SEARCH_res_comments.length+' Records Matching').val('').show();
                    }
                }
            }
        });
    }
    var selected_value;
    var searchval = [];
    var STDLY_SEARCH_flag_autocom='';
    $( "#STDLY_SEARCH_tb_searchcomments" ).keypress(function(e){
//CALL FUNCTION TO HIGHLIGHT SEARCH TEXT
        STDLY_SEARCH_flag_autocom=0;
        STDLY_SEARCH_highlightSearchText();
        if (e.which ==13) {
            STDLY_SEARCH_flag_autocom=1;
        }
        if($('#STDLY_SEARCH_lb_typelist').val()==39)
            searchval=STDLY_SEARCH_arr_eacomments;
        else if($('#STDLY_SEARCH_lb_typelist').val()==40)
            searchval=STDLY_SEARCH_arr_salcomments;
        else if($('#STDLY_SEARCH_lb_typelist').val()==41)
            searchval=STDLY_SEARCH_arr_escomments;
        $( "#STDLY_SEARCH_tb_searchcomments" ).autocomplete({
            source: searchval,
            select: STDLY_SEARCH_AutoCompleteSelectHandler
        });
    });
    //FUNCTION TO HIGHLIGHT SEARCH TEXT
    function STDLY_SEARCH_highlightSearchText() {
        var STDLY_SEARCH_fromcomt=$('#STDLY_SEARCH_tb_searchcomments').val();
//        var STDLY_SEARCH_conformsg=STDLY_SEARCH_errorArray[16];
//        var STDLY_SEARCH_CONFSAVEMSG = STDLY_SEARCH_conformsg.replace('[COMTS]', STDLY_SEARCH_fromcomt);
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        };
    }
    //FUNCTION TO GET SELECTED VALUE
    function STDLY_SEARCH_AutoCompleteSelectHandler(event, ui) {
        var STDLY_SEARCH_listoption=$('#STDLY_SEARCH_lb_typelist').val();
        STDLY_SEARCH_flag_autocom=1;
        if(STDLY_SEARCH_listoption==39)
        {
            $('#STDLY_SEARCH_btn_agentsbutton').show();
        }
        if(STDLY_SEARCH_listoption==40)
        {
//            alert(STDLY_SEARCH_listoption)
            $('#STDLY_SEARCH_btn_salarybutton').show();
        }
        if(STDLY_SEARCH_listoption==41)
        {
            $('#STDLY_SEARCH_btn_staffbutton').show();
        }
    }
    //FUNCTION FOR CHANGE BLUR FOR COMMENTS,INVOICE AUTOCOMPLETE
    $(document).on('change blur','.STDLY_SEARCH_class_autocomplete',function(){
        if(STDLY_SEARCH_flag_autocom==1){
            $('#STDLY_SEARCH_lbl_errmsg').text('')
            $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
            $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
            $('#STDLY_SEARCH_btn_agentsbutton').removeAttr("disabled");
        }
        else
        {
            $('#STDLY_SEARCH_lbl_errmsg').addClass('errormsg')
            var STDLY_SEARCH_errormsg=STDLY_SEARCH_errorArray[16].replace('[COMTS]',$('#STDLY_SEARCH_tb_searchcomments').val())
            if(($('#STDLY_SEARCH_lb_typelist').val()==39)&&($('#STDLY_SEARCH_tb_searchcomments').val()!=''))
            {
                $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
            }
            if(($('#STDLY_SEARCH_lb_typelist').val()==40)&&($('#STDLY_SEARCH_tb_searchcomments').val()!=''))
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
            if($('#STDLY_SEARCH_lb_typelist').val()==41)
            {
                $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
                if(($('#STDLY_SEARCH_lb_staffsearchoption').val()==82)&&($('#STDLY_SEARCH_tb_invfromcomt').val()!=''))
                    var STDLY_SEARCH_errormsg=STDLY_SEARCH_errorArray[28].replace('[INVFROM]',$('#STDLY_SEARCH_tb_invfromcomt').val())
                if(($('#STDLY_SEARCH_lb_staffsearchoption').val()==83)&&($('#STDLY_SEARCH_tb_invitemcomt').val()!=''))
                    var STDLY_SEARCH_errormsg=STDLY_SEARCH_errorArray[26].replace('[INVITEM]',$('#STDLY_SEARCH_tb_invitemcomt').val())
            }
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_errmsg').text(STDLY_SEARCH_errormsg)}
    });
    //SEARCHING SALARY SEARCH OPTION ....................
    $('#STDLY_SEARCH_lb_salarysearchoption').change(function(){
        $('.datebox') .datepicker( "option", "minDate", null);
        $('.datebox') .datepicker( "option", "minDate", new Date(1969, 10 , 19));
        $('#STDLY_SEARCH_lbl_errmsg').text('');
        $('#STDLY_SEARCH_lbl_byemployeename').hide();
        $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
        $('#STDLY_SEARCH_lbl_salarycomments').hide();
        $(".preloader").show();
        $('#STDLY_SEARCH_lbl_searchbydiv').hide();
        $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
        $('#STDLY_SEARCH_lbl_salarycomments').hide();
        $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#STDLY_SEARCH_lbl_headermesg').hide();
        var STDLY_SEARCH_salarysearchoption=$('#STDLY_SEARCH_lb_salarysearchoption').val();
        if(STDLY_SEARCH_salarysearchoption=="SELECT")
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').hide();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_db_startdate').val('');
            $('#STDLY_SEARCH_db_enddate').val('');
            $('#STDLY_SEARCH_tb_fromamount').val('');
            $('#STDLY_SEARCH_tb_toamount').val('');
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
        }
        if(STDLY_SEARCH_salarysearchoption==86)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_lbl_fromamount').show();
            $('#STDLY_SEARCH_tb_fromamount').val('').show();
            $('#STDLY_SEARCH_tb_toamount').val('').show();
            $('#STDLY_SEARCH_lbl_toamount').show();
            $('#STDLY_SEARCH_btn_salarybutton').show();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
            $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
        }
        if(STDLY_SEARCH_salarysearchoption==93)
        {
            $(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
            STDLY_SEARCH_loadcpfnoinlistbox()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_loadcpfnoinlistbox).STDLY_SEARCH_loadcpfno(STDLY_SEARCH_salarysearchoption);
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').hide();
            $('#STDLY_SEARCH_db_startdate').hide();
            $('#STDLY_SEARCH_lbl_enddate').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_db_enddate').hide();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').hide();
            $('#STDLY_SEARCH_tb_toamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
            $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_salarysearchoption==90)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').hide();
            $('#STDLY_SEARCH_db_startdate').hide();
            $('#STDLY_SEARCH_lbl_enddate').hide();
            $('#STDLY_SEARCH_db_enddate').hide();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').hide();
            $('#STDLY_SEARCH_tb_toamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_lbl_searchbyemployeename').show();
            $('#STDLY_SEARCH_lb_searchbyemployeename').show();
            $("select#STDLY_SEARCH_lb_searchbyemployeename")[0].selectedIndex = 0;
            $('#STDLY_SEARCH_btn_salarybutton').show();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
        }
        if(STDLY_SEARCH_salarysearchoption==88)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_lbl_fromamount').show();
            $('#STDLY_SEARCH_tb_fromamount').val('').show();
            $('#STDLY_SEARCH_tb_toamount').val('').show();
            $('#STDLY_SEARCH_lbl_toamount').show();
            $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
            $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
            $('#STDLY_SEARCH_btn_salarybutton').show();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
        }
        if(STDLY_SEARCH_salarysearchoption==85)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').val('').hide();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').hide();
            $('#STDLY_SEARCH_tb_toamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
            $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
        }
        if(STDLY_SEARCH_salarysearchoption==91)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').hide();
            $('#STDLY_SEARCH_tb_toamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
            $('#STDLY_SEARCH_lbl_byemployeename').hide();
            $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
            $('#STDLY_SEARCH_btn_salarybutton').show();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
        }
        if(STDLY_SEARCH_salarysearchoption==87)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_lbl_fromamount').show();
            $('#STDLY_SEARCH_tb_fromamount').val('').show();
            $('#STDLY_SEARCH_tb_toamount').val('').show();
            $('#STDLY_SEARCH_lbl_toamount').show();
            $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
            $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
            $('#STDLY_SEARCH_btn_salarybutton').show();
            $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_salarysearchoption==89)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').hide();
            $('#STDLY_SEARCH_tb_toamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
            $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
            $('#STDLY_SEARCH_btn_salarybutton').show();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_salarysearchoption==92)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').hide();
            $('#STDLY_SEARCH_tb_toamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
            $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
            $('#STDLY_SEARCH_btn_salarybutton').show();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lb_searchbycpfno').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
    });
    function STDLY_SEARCH_loadcpfnoinlistbox()
    {
        var STDLY_SEARCH_loadcpfnosarray=[];
        $.ajax({
            type: "POST",
            'url':STDLY_SEARCH_controller_url+"STDLY_SEARCH_loadcpfno",
            success: function(data){
                $('.preloader').hide();
                STDLY_SEARCH_loadcpfnosarray=JSON.parse(data);
                var options =' <option>SELECT</option>';
                for (var i = 0; i < STDLY_SEARCH_loadcpfnosarray.length; i++) {
                    options += '<option value="' + STDLY_SEARCH_loadcpfnosarray[i].EDSS_CPF_NUMBER + '">' + STDLY_SEARCH_loadcpfnosarray[i].EDSS_CPF_NUMBER + '</option>';
                }
                $('#STDLY_SEARCH_lb_searchbycpfno').html(options);
                $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
                $('#STDLY_SEARCH_lb_searchbycpfno').show();
                $('#STDLY_SEARCH_lbl_searchbycpfno').show();
                $('#STDLY_SEARCH_btn_salarybutton').show();
            }
        });
    }

//        if(STDLY_SEARCH_loadcpfnosarray!=''){
//
//            $('#STDLY_SEARCH_lb_searchbycpfno').append($('<option> SELECT </option>'));
//            for(var i=0;i<STDLY_SEARCH_loadcpfnosarray.length;i++)
//            {
//
////
//                    var STDLY_SEARCH_loadcpfnosarray=STDLY_SEARCH_loadcpfnosarray[i].EDSS_CPF_NUMBER;
////                alert(STDLY_SEARCH_loadcpfnosarray)
////                        if(listboxoption=='STAFF ENTRY')
//                    $('#STDLY_SEARCH_lb_searchbycpfno').append($('<option>').text(STDLY_SEARCH_loadcpfnosarray).attr('value', STDLY_SEARCH_loadcpfnosarray));
////                        else
////                        $('#STDLY_SEARCH_lb_typelist').append($('<option>').text(expdata).attr('value', expid));
//
//            }
//            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_salarysearchoption').find('option:selected').text()).show();
//            $('#STDLY_SEARCH_lb_searchbycpfno').show();
//            $('#STDLY_SEARCH_lbl_searchbycpfno').show();
//            $('#STDLY_SEARCH_btn_salarybutton').show();
//        }

    // }
    //SEARCHING THE SALARY  SEARCH OPTION FROM THE  TABLES......................
    $('#STDLY_SEARCH_btn_salarybutton').click(function(){
//        var  newPos= adjustPosition($(this).position(),100,120);
//        resetPreloader(newPos);
        STDLY_SEARCH_salaryfunction();
    });
    function STDLY_SEARCH_salaryfunction()
    {
        $(".preloader").show();
        var STDLY_SEARCH_salaryoptionvalmatch=$("#STDLY_SEARCH_lb_salarysearchoption").val();
        if(STDLY_SEARCH_salaryoptionvalmatch==86)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount=$('#STDLY_SEARCH_tb_fromamount').val();
            var STDLY_SEARCH_toamount=$('#STDLY_SEARCH_tb_toamount').val();
            var STDLY_SEARCH_selectedcpfno="";
            var STDLY_SEARCH_selectedempname="";
            var STDLY_SEARCH_searchcomments="";
            STDLY_SEARCH_salarysearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_salarysearchdetails).STDLY_SEARCH_searchbysalaryentry(STDLY_SEARCH_salaryoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_selectedcpfno,STDLY_SEARCH_selectedempname);
        }
//SEARCH BY CPF NUMBER....................
        if(STDLY_SEARCH_salaryoptionvalmatch==93)
        {var STDLY_SEARCH_selectedcpfno=$('#STDLY_SEARCH_lb_searchbycpfno').val();
            var STDLY_SEARCH_selectedempname="";
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_startdate="";
            var STDLY_SEARCH_enddate="";
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            STDLY_SEARCH_salarysearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_salarysearchdetails).STDLY_SEARCH_searchbysalaryentry(STDLY_SEARCH_salaryoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_selectedcpfno,STDLY_SEARCH_selectedempname,STDLY_SEARCH_searchcomments);
        }
//SEARCH BY EMPLOYEE NAME...................
        if(STDLY_SEARCH_salaryoptionvalmatch==90)
        {var STDLY_SEARCH_selectedempname=$('#STDLY_SEARCH_lb_searchbyemployeename').val();
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_startdate="";
            var STDLY_SEARCH_enddate="";
            var STDLY_SEARCH_selectedcpfno="";
            STDLY_SEARCH_salarysearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_salarysearchdetails).STDLY_SEARCH_searchbysalaryentry(STDLY_SEARCH_salaryoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_selectedcpfno,STDLY_SEARCH_selectedempname,STDLY_SEARCH_searchcomments);
        }
//SEARCH BY SALARY AMOUNT...................
        if(STDLY_SEARCH_salaryoptionvalmatch==88)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount=$('#STDLY_SEARCH_tb_fromamount').val();
            var STDLY_SEARCH_toamount=$('#STDLY_SEARCH_tb_toamount').val();
            var STDLY_SEARCH_selectedcpfno="";
            var STDLY_SEARCH_selectedempname="";
            var STDLY_SEARCH_searchcomments="";
            STDLY_SEARCH_salarysearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_salarysearchdetails).STDLY_SEARCH_searchbysalaryentry(STDLY_SEARCH_salaryoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_selectedcpfno,STDLY_SEARCH_selectedempname,STDLY_SEARCH_searchcomments);
        }
//SEARCH BY SALARY COMMENTS...................
        if(STDLY_SEARCH_salaryoptionvalmatch==85)
        {
            var STDLY_SEARCH_searchcomments=$('#STDLY_SEARCH_tb_searchcomments').val();
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_selectedcpfno="";
            var STDLY_SEARCH_selectedempname="";
            STDLY_SEARCH_salarysearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_salarysearchdetails).STDLY_SEARCH_searchbysalaryentry(STDLY_SEARCH_salaryoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_selectedcpfno,STDLY_SEARCH_selectedempname,STDLY_SEARCH_searchcomments);
        }
//SEARCH BY SALARY FROM PERIOD...................
        if(STDLY_SEARCH_salaryoptionvalmatch==91)
        {
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_selectedcpfno="";
            var STDLY_SEARCH_selectedempname="";
            STDLY_SEARCH_salarysearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_salarysearchdetails).STDLY_SEARCH_searchbysalaryentry(STDLY_SEARCH_salaryoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_selectedcpfno,STDLY_SEARCH_selectedempname,STDLY_SEARCH_searchcomments);
        }
//SEARCH BY LEVY AMOUNT.................
        if(STDLY_SEARCH_salaryoptionvalmatch==87)
        {
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount=$('#STDLY_SEARCH_tb_fromamount').val();
            var STDLY_SEARCH_toamount=$('#STDLY_SEARCH_tb_toamount').val();
            var STDLY_SEARCH_selectedcpfno="";
            var STDLY_SEARCH_selectedempname="";
            STDLY_SEARCH_salarysearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_salarysearchdetails).STDLY_SEARCH_searchbysalaryentry(STDLY_SEARCH_salaryoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_selectedcpfno,STDLY_SEARCH_selectedempname,STDLY_SEARCH_searchcomments);
        }
//SEARCH BY PAID DATE.................
        if(STDLY_SEARCH_salaryoptionvalmatch==89)
        {
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_selectedcpfno="";
            var STDLY_SEARCH_selectedempname="";
            STDLY_SEARCH_salarysearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_salarysearchdetails).STDLY_SEARCH_searchbysalaryentry(STDLY_SEARCH_salaryoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_selectedcpfno,STDLY_SEARCH_selectedempname,STDLY_SEARCH_searchcomments);
        }
//SEARCH BY TO PERIOD................
        if(STDLY_SEARCH_salaryoptionvalmatch==92)
        {
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_selectedcpfno="";
            var STDLY_SEARCH_selectedempname="";
            STDLY_SEARCH_salarysearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_salarysearchdetails).STDLY_SEARCH_searchbysalaryentry(STDLY_SEARCH_salaryoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_selectedcpfno,STDLY_SEARCH_selectedempname,STDLY_SEARCH_searchcomments);
        }
    }
    var values_array;
    var STDLY_SEARCH_cpfamount;
    var STDLY_SEARCH_levyamount;
    var SALARY;
    var FIRST;
    var LAST;
    var id;
    var INVOICE;
    var CPFNO;
    var to_pereoid;
    var from_pereoid;
    var userstamp;
    var timestamp;
    var comments;
    var STDLY_SEARCH_salaryamount;
    var STDLY_SEARCH_salary;
    var STDLY_SEARCH_cpf;
    var STDLY_SEARCH_levy;
    function  STDLY_SEARCH_salarysearchdetails()
    {
        var STDLY_SEARCH_startdate = $("#STDLY_SEARCH_db_startdate").val();
        var STDLY_SEARCH_enddate = $("#STDLY_SEARCH_db_enddate").val();
        var STDLY_SEARCH_fromamount = $("#STDLY_SEARCH_tb_fromamount").val();
        var STDLY_SEARCH_toamount = $("#STDLY_SEARCH_tb_toamount").val();
        var STDLY_SEARCH_searchoptio=$('#STDLY_SEARCH_lb_salarysearchoption').val();
        var STDLY_SEARCH_searchcomments=$('#STDLY_SEARCH_tb_searchcomments').val();
        var STDLY_SEARCH_selectedcpfno=$('#STDLY_SEARCH_lb_searchbycpfno').val();
        $('.preloader').hide();
        $.ajax({
            type: "POST",
            'url':STDLY_SEARCH_controller_url+"fetch_salary_data",
            data: {'STDLY_SEARCH_searchoptio':STDLY_SEARCH_searchoptio,'STDLY_SEARCH_startdate':STDLY_SEARCH_startdate,'STDLY_SEARCH_enddate':STDLY_SEARCH_enddate,'STDLY_SEARCH_fromamount':STDLY_SEARCH_fromamount,'STDLY_SEARCH_toamount':STDLY_SEARCH_toamount,'STDLY_SEARCH_searchcomments':STDLY_SEARCH_searchcomments,'STDLY_SEARCH_selectedcpfno':STDLY_SEARCH_selectedcpfno},
            success: function(data) {
                values_array=JSON.parse(data);
                if(values_array.length!=0)
                {
                    var STDLY_SEARCH_table_value='<table id="STDLY_SEARCH_tbl_salaryhtmltable" border="1"  cellspacing="0" class="srcresult" width="1500" ><thead  bgcolor="#6495ed" style="color:white"><tr><th style="width:80px">EDIT/DELETE</th><th style="width:90px">FIRST NAME</th><th style="width:90px;">LAST NAME</th><th class="uk-date-column" style="width:100px;">INVOICE DATE</th><th class="uk-date-column" style="width:160px;">FROM PERIOD</th><th class="uk-date-column" style="width:160px;">TO PERIOD</th><th style="width:80px;">CPF NUMBER</th><th style="width:80px;">CPF AMOUNT</th><th style="width:70px;">LEVY AMOUNT</th><th style="width:70px;">SALARY AMOUNT</th><th style="width:320px;">COMMENTS</th><th style="width:150px;">USERSTAMP</th><th style="width:230px;" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>'
//                    var ET_SRC_UPD_DEL_errmsg =value_err_array[4].EMC_DATA.replace('[SCRIPT]',ET_SRC_UPD_DEL_name);
//                    $('#ET_SRC_UPD_DEL_div_header').text(ET_SRC_UPD_DEL_errmsg).show();
                    for(var j=0;j<values_array.length;j++){
                        STDLY_SEARCH_cpfamount=values_array[j].CPF;
                        if((STDLY_SEARCH_cpfamount=='null')||(STDLY_SEARCH_cpfamount==undefined))
                        {
                            STDLY_SEARCH_cpfamount='';
                        }
                        id=values_array[j].ESS_ID;
                        STDLY_SEARCH_levyamount=values_array[j].LEVY;
                        if((STDLY_SEARCH_levyamount=='null')||(STDLY_SEARCH_levyamount==undefined))
                        {
                            STDLY_SEARCH_levyamount='';
                        }
                        STDLY_SEARCH_salaryamount=values_array[j].SALARY;
                        FIRST=values_array[j].FIRST;
                        if((FIRST=='null')||(FIRST==undefined))
                        {
                            FIRST='';
                        }
                        LAST=values_array[j].LAST;
                        if((LAST=='null')||(LAST==undefined))
                        {
                            LAST='';
                        }
                        CPFNO=values_array[j].CPFNO;
                        if((CPFNO=='null')||(CPFNO==undefined))
                        {
                            CPFNO='';
                        }
                        INVOICE=values_array[j].INVOICE;
                        to_pereoid=values_array[j].TOPERIOD;
                        from_pereoid=values_array[j].FROMPERIOD;
                        comments=values_array[j].COMMENTS;
                        if((comments=='null')||(comments==undefined))
                        {
                            comments='';
                        }
                        userstamp=values_array[j].USERSTAMP;
                        timestamp=values_array[j].timestamp;
                        STDLY_SEARCH_salary=values_array[j].SALARYESS;
                        STDLY_SEARCH_cpf=values_array[j].CPFESS;
                        STDLY_SEARCH_levy=values_array[j].LEVYESS;
                        STDLY_SEARCH_table_value+='<tr><td><div class="col-lg-1"><span style="display: block;color:green" class="glyphicon glyphicon-edit staffsalary_editbutton" id='+id+' title="Edit"></div><div class="col-lg-1"><span style="display: block;color:red" class="glyphicon glyphicon-trash deletebutton" id='+id+' title="Delete"></div></td><td>'+FIRST+'</td><td>'+LAST+'</td><td>'+INVOICE+'</td><td>'+from_pereoid+'</td><td>'+to_pereoid+'</td><td>'+CPFNO+'</td><td>'+STDLY_SEARCH_cpfamount+'</td><td>'+STDLY_SEARCH_levyamount+'</td><td>'+STDLY_SEARCH_salaryamount+'</td><td>'+comments+'</td><td>'+userstamp+'</td><td>'+timestamp+'</td></tr>';
                    }
                    STDLY_SEARCH_table_value+='</tbody></table>';
                    $('#STDLY_SEARCH_div_salaryhtmltable').show();
                    $('#STDLY_SEARCH_sec_salryentry').html(STDLY_SEARCH_table_value);
                    $('#STDLY_SEARCH_tbl_salaryhtmltable').DataTable({
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers",
                        "aoColumnDefs" : [
                            { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ]

                    });

                }
                else
                {
                    $('#ET_SRC_UPD_DEL_div_header').hide();
                    $('#ET_SRC_UPD_DEL_div_table').hide();
//                    $('#ET_SRC_UPD_DEL_div_headernodata').text(value_err_array[2].EMC_DATA).show();
                    $('#STDLY_SEARCH_tbl_salaryhtmltable').hide();
                    $('section').html('');
                    $('.preloader').hide();
                }

            }
        });
        sorting()
    }
    var currentid
    //CLICK EVENT FUCNTION FOR edit SEARCH
    $(document).on('click','.staffsalary_editbutton',function(){
        currentid = $(this).attr('id');
        $('#STDLY_SEARCH_tbl_salaryupdatetable').show();
        $('#STDLY_SEARCH_lbl_name').show();
        var finalconcatempname=FIRST.concat(LAST);
        var STDLY_SEARCH_empnamesiz=(FIRST.concat(LAST)).length;
        $('#STDLY_SEARCH_lb_namelist').attr("size",STDLY_SEARCH_empnamesiz+3);
        $('#STDLY_SEARCH_lb_namelist').val(finalconcatempname);
        $('#STDLY_SEARCH_lb_namelist').show();
        $('#STDLY_SEARCH_lbl_cpf').show();
        $('#STDLY_SEARCH_tb_cpfno').val(CPFNO);
        $('#STDLY_SEARCH_tb_cpfno').attr("size",CPFNO.length+3);
        $('#STDLY_SEARCH_tb_cpfno').show();
        $('#STDLY_SEARCH_lbl_paid').show();
        $('#STDLY_SEARCH_db_paiddate').datepicker("option","maxDate",new Date());
        $('#STDLY_SEARCH_db_paiddate').val(INVOICE);
        $('#STDLY_SEARCH_db_paiddate').show();
        $('#STDLY_SEARCH_lbl_from').show();
        $('#STDLY_SEARCH_db_fromdate').val(from_pereoid);
        $('#STDLY_SEARCH_db_fromdate').show();
        var STDLY_SEARCH_dp_invoice=$('#STDLY_SEARCH_db_paiddate').datepicker('getDate');
        var STDLY_SEARCH_date = new Date( Date.parse( STDLY_SEARCH_dp_invoice ) );
        STDLY_SEARCH_date.setDate( STDLY_SEARCH_date.getDate() -1); // + 1
        var STDLY_SEARCH_newDate = STDLY_SEARCH_date.toDateString();
        $('#STDLY_SEARCH_db_fromdate').datepicker("option","maxDate",new Date( Date.parse(STDLY_SEARCH_newDate)));
        $('#STDLY_SEARCH_db_todate').datepicker("option","maxDate",new Date( Date.parse(STDLY_SEARCH_newDate)));
        var STDLY_SEARCH_dp_invoicefrom=$('#STDLY_SEARCH_db_fromdate').datepicker('getDate');
        $('#STDLY_SEARCH_db_todate').datepicker("option","minDate",new Date( Date.parse(STDLY_SEARCH_dp_invoicefrom)));
        $('#STDLY_SEARCH_lbl_to').show();
        $('#STDLY_SEARCH_db_todate').val(to_pereoid);
        $('#STDLY_SEARCH_db_todate').show();
        $('#STDLY_SEARCH_lbl_currentsalary').show();
        $('#STDLY_SEARCH_radio_currentslr').show();
        $('#STDLY_SEARCH_radio_newslr').show();
        $('#STDLY_SEARCH_radio_currentlevyamt').show();
        $('#STDLY_SEARCH_radio_newlevyamt').show();
        if(STDLY_SEARCH_salaryamount==STDLY_SEARCH_salary)
        {
            if(STDLY_SEARCH_salaryamount==null)
            {
                $('input:radio[name=STDLY_SEARCH_radio_slramt][value=current]').attr('checked', true);
                STDLY_SEARCH_salaryamount='';
                $('#STDLY_SEARCH_tb_hidesal').hide();
            }else
            {
                $('input:radio[name=STDLY_SEARCH_radio_slramt][value=current]').attr('checked', true);
                $('#STDLY_SEARCH_tb_hidesal').val(STDLY_SEARCH_salaryamount);
                $('#STDLY_SEARCH_tb_hidesal').show();
                $('#STDLY_SEARCH_tb_gethiddenesal').val(STDLY_SEARCH_salaryamount).hide();
            }
        }
        else
        {
            $('input:radio[name=STDLY_SEARCH_radio_slramt][value=new]').attr('checked', true);
            if(STDLY_SEARCH_salaryamount==null)
            {
                STDLY_SEARCH_salaryamount='';
                $('#STDLY_SEARCH_tb_hidesal1').hide();
            }else
            {
                $('#STDLY_SEARCH_tb_hidesal').hide();
                $('#STDLY_SEARCH_tb_hidesal1').val(STDLY_SEARCH_salaryamount);
                $('#STDLY_SEARCH_tb_hidesal1').show();
            }
        }
        //CPF AMOUNT  LOADING IN THE TEXT BOX.................
        $('#STDLY_SEARCH_radio_currentcpfamt').show();
        $('#STDLY_SEARCH_radio_newcpfamt').show();
        if((STDLY_SEARCH_cpfamount!=null)||(STDLY_SEARCH_cpfamount!=''))
        {
            if((STDLY_SEARCH_cpf!='')&&(STDLY_SEARCH_cpfamount==STDLY_SEARCH_cpf))
            {
                $('input:radio[name=STDLY_SEARCH_radio_cpfamt][value=current]').attr('checked', true);
                $('#STDLY_SEARCH_tb_hidecpf').val(STDLY_SEARCH_cpfamount);
                $('#STDLY_SEARCH_tb_hidecpf').show();
                $('#STDLY_SEARCH_tb_hidecpf1').hide();
                $('#STDLY_SEARCH_tb_gethiddenecpf').val(STDLY_SEARCH_cpfamount).hide();
            }
            else
            {$('#STDLY_SEARCH_radio_currentcpfamt').attr('disabled','disabled')
                if(STDLY_SEARCH_cpfamount!=''){
                    $('input:radio[name=STDLY_SEARCH_radio_cpfamt][value=new]').attr('checked', true);
                    $('#STDLY_SEARCH_tb_hidecpf1').val(STDLY_SEARCH_cpfamount);
                    $('#STDLY_SEARCH_tb_hidecpf1').show();
                }else{
                    $('#STDLY_SEARCH_tb_hidecpf1').hide();
                    $('input:radio[name=STDLY_SEARCH_radio_cpfamt][value=new]').attr('checked', false);}
                $('#STDLY_SEARCH_tb_hidecpf').hide();
            }
        }
        else
        {
            $('input:radio[name=STDLY_SEARCH_radio_cpfamt]').attr('checked', false);
            $('#STDLY_SEARCH_tb_hidecpf1').val(STDLY_SEARCH_cpfamount);
            $('#STDLY_SEARCH_tb_hidecpf1').hide();
            $('#STDLY_SEARCH_tb_gethiddenecpf').val(STDLY_SEARCH_cpf).hide();
            $('#STDLY_SEARCH_tb_hidecpf').val(STDLY_SEARCH_cpf);
            $('#STDLY_SEARCH_tb_hidecpf').hide();
        }
        //LEVY AMOUNT LOADING IN THE TEXT BOX.....................

        if(((STDLY_SEARCH_levy!=null)&&(STDLY_SEARCH_levy!=''))||(STDLY_SEARCH_levyamount!=''))
        {
            if(STDLY_SEARCH_levyamount==STDLY_SEARCH_levy)
            {
                $('input:radio[name=STDLY_SEARCH_radio_levyamt][value=current]').attr('checked', true);
                $('#STDLY_SEARCH_tb_hidelevy').val(STDLY_SEARCH_levyamount);
                $('#STDLY_SEARCH_tb_hidelevy').show();
                $('#STDLY_SEARCH_tb_hidelevy1').hide();
                $('#STDLY_SEARCH_tb_gethiddenelevy').val(STDLY_SEARCH_levyamount).hide();
            }
            else if(STDLY_SEARCH_levyamount!=''){
                $('input:radio[name=STDLY_SEARCH_radio_levyamt][value=new]').attr('checked', true);
                $('#STDLY_SEARCH_tb_hidelevy1').val(STDLY_SEARCH_levyamount);
                $('#STDLY_SEARCH_tb_hidelevy1').show();
                $('#STDLY_SEARCH_tb_hidelevy').hide();}}
        else
        {
            $('input:radio[name=STDLY_SEARCH_radio_levyamt]').attr('checked', false);
            if(STDLY_SEARCH_levy=='')
                $('#STDLY_SEARCH_radio_currentlevyamt').attr('disabled', 'disabled');
            $('#STDLY_SEARCH_tb_gethiddenelevy').val(STDLY_SEARCH_levy).hide();
            $('#STDLY_SEARCH_tb_hidelevy1').val(STDLY_SEARCH_levyamount);
            $('#STDLY_SEARCH_tb_hidelevy1').hide();
            $('#STDLY_SEARCH_tb_hidelevy').val(STDLY_SEARCH_levy);
            $('#STDLY_SEARCH_tb_hidelevy').hide();
        }
        //gaaaaaaaaaappppppp
        $('#STDLY_SEARCH_lbl_salarycomments').show();
        $('#STDLY_SEARCH_ta_salarycommentsbox').val(comments);
        $('#STDLY_SEARCH_ta_salarycommentsbox').show();
        $('#STDLY_SEARCH_lbl_cursal').show();
        $('#STDLY_SEARCH_lbl_newsal').show();
        $('#STDLY_SEARCH_lbl_cpamt').show();
        $('#STDLY_SEARCH_lbl_newcamt').show();
        $('#STDLY_SEARCH_lbl_curlamt').show();
        $('#STDLY_SEARCH_lbl_newlamt').show();
        $('#STDLY_SEARCH_btn_sbutton').show();
        $('#STDLY_SEARCH_btn_rbutton').show();
        $('#STDLY_SEARCH_btn_sbutton').attr("disabled", "disabled");
//            }
    });
    //SALARY RADIO BUTTON VALIDATION .....................................
    $("#STDLY_SEARCH_db_paiddate").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var STDLY_SEARCH_datep = $('#STDLY_SEARCH_db_paiddate').datepicker('getDate');
            var date = new Date( Date.parse( STDLY_SEARCH_datep ) );
            date.setDate( date.getDate() - 1 );
            var STDLY_SEARCH_newDate = date.toDateString();
            STDLY_SEARCH_newDate = new Date( Date.parse( STDLY_SEARCH_newDate ) );
            $('#STDLY_SEARCH_db_fromdate').datepicker("option","maxDate",STDLY_SEARCH_newDate);
            $('#STDLY_SEARCH_db_todate').datepicker("option","maxDate",STDLY_SEARCH_newDate);
            var flag=0;
            if( $('#STDLY_SEARCH_radio_currentslr').is(":checked")==true)
            {
                var STDLY_SEARCH_radio_radiovalue="data";
            }
            else if(( $('#STDLY_SEARCH_radio_newslr').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidesal1").val()!=""))
            {
                var STDLY_SEARCH_radio_radiovalue="data";
            }
            if(($("#STDLY_SEARCH_lb_namelist").val()=="SELECT")||($("#STDLY_SEARCH_db_paiddate").val()=="")||($("#STDLY_SEARCH_db_fromdate").val()=="")||($("#STDLY_SEARCH_db_todate").val()=="")||(STDLY_SEARCH_radio_radiovalue !="data")||(( $('#STDLY_SEARCH_radio_newcpfamt').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidecpf1").val()==""))||(( $('#STDLY_SEARCH_radio_newlevyamt').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidelevy1").val()=="")))
            {
                flag=1;
            }
            if(flag=="1")
            {
                $('#STDLY_SEARCH_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_sbutton').removeAttr("disabled");
            }
        }
    });

    //DATE PICKER FUNCTION FOR  FOR DATEBOX IN SALARY ENTRY...............
    $("#STDLY_SEARCH_db_fromdate").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var STDLY_SEARCH_fromdate = $('#STDLY_SEARCH_db_fromdate').datepicker('getDate');
            var date = new Date( Date.parse( STDLY_SEARCH_fromdate ) );
            date.setDate( date.getDate()  ); //+ 1
            var STDLY_SEARCH_newDate = date.toDateString();
            STDLY_SEARCH_newDate = new Date( Date.parse( STDLY_SEARCH_newDate ) );
            $('#STDLY_SEARCH_db_todate').datepicker("option","minDate",STDLY_SEARCH_newDate);
            var STDLY_SEARCH_paiddate = $('#STDLY_SEARCH_db_paiddate').datepicker('getDate');
            var date = new Date( Date.parse( STDLY_SEARCH_paiddate ) );
            date.setDate( date.getDate() - 1 ); //- 1
            var STDLY_SEARCH_paidnewDate = date.toDateString();
            STDLY_SEARCH_paidnewDate = new Date( Date.parse( STDLY_SEARCH_paidnewDate ) );
            $('#STDLY_SEARCH_db_todate').datepicker("option","maxDate",STDLY_SEARCH_paidnewDate);
            var flag=0;
            if( $('#STDLY_SEARCH_radio_currentslr').is(":checked")==true)
            {
                var STDLY_SEARCH_radio_radiovalue="data";
            }
            else if(( $('#STDLY_SEARCH_radio_newslr').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidesal1").val()!=""))
            {
                var STDLY_SEARCH_radio_radiovalue="data";
            }
            if(($("#STDLY_SEARCH_lb_namelist").val()=="SELECT")||($("#STDLY_SEARCH_db_paiddate").val()=="")||($("#STDLY_SEARCH_db_fromdate").val()=="")||($("#STDLY_SEARCH_db_todate").val()=="")||(STDLY_SEARCH_radio_radiovalue !="data")||(( $('#STDLY_SEARCH_radio_newcpfamt').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidecpf1").val()==""))||(( $('#STDLY_SEARCH_radio_newlevyamt').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidelevy1").val()=="")))
            {
                flag=1;
            }
            if(flag=="1")
            {
                $('#STDLY_SEARCH_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_sbutton').removeAttr("disabled");
            }
        }
    });
//DATE PICKER FOR TO DATE IN THE  SALARY ENTRY.....................
    $("#STDLY_SEARCH_db_todate").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        onSelect: function(date){
            var STDLY_SEARCH_fromdate = $('#STDLY_SEARCH_db_fromdate').datepicker('getDate');
            var date = new Date( Date.parse( STDLY_SEARCH_fromdate ) );
            date.setDate( date.getDate()  ); //+ 1
            var STDLY_SEARCH_newDate = date.toDateString();
            STDLY_SEARCH_newDate = new Date( Date.parse( STDLY_SEARCH_newDate ) );
            $('#STDLY_SEARCH_db_todate').datepicker("option","minDate",STDLY_SEARCH_newDate);
            var STDLY_SEARCH_paiddate = $('#STDLY_SEARCH_db_paiddate').datepicker('getDate');
            var date = new Date( Date.parse( STDLY_SEARCH_paiddate ) );
            date.setDate( date.getDate()- 1  ); //- 1
            var STDLY_SEARCH_paidnewDate = date.toDateString();
            STDLY_SEARCH_paidnewDate = new Date( Date.parse( STDLY_SEARCH_paidnewDate ) );
            $('#STDLY_SEARCH_db_todate').datepicker("option","maxDate",STDLY_SEARCH_paidnewDate);
            var flag=0;
            if( $('#STDLY_SEARCH_radio_currentslr').is(":checked")==true)
            {
                var STDLY_SEARCH_radio_radiovalue="data";
            }
            else if(( $('#STDLY_SEARCH_radio_newslr').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidesal1").val()!=""))
            {
                var STDLY_SEARCH_radio_radiovalue="data";
            }
            if(($("#STDLY_SEARCH_lb_namelist").val()=="SELECT")||($("#STDLY_SEARCH_db_paiddate").val()=="")||($("#STDLY_SEARCH_db_fromdate").val()=="")||($("#STDLY_SEARCH_db_todate").val()=="")||(STDLY_SEARCH_radio_radiovalue !="data")||(( $('#STDLY_SEARCH_radio_newcpfamt').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidecpf1").val()==""))||(( $('#STDLY_SEARCH_radio_newlevyamt').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidelevy1").val()=="")))
            {
                flag=1;
            }
            if(flag=="1")
            {
                $('#STDLY_SEARCH_btn_sbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_sbutton').removeAttr("disabled");
            }
        }
    });
    //<!-- RADIO BUTTON FUNCTIONS FOR GET SALARY AMOUNT IN THE SALARY ENTRY -->
    $('#STDLY_SEARCH_radio_currentslr').click(function(){
        var STDLY_SEARCH_listvalue=$('#STDLY_SEARCH_hideempname').val();
        $('#STDLY_SEARCH_tb_hidesal1').hide().val('');
        $('#STDLY_SEARCH_tb_hidesal').val(STDLY_SEARCH_salary);
        $('#STDLY_SEARCH_tb_gethiddenesal').val(STDLY_SEARCH_salary);
        $('#STDLY_SEARCH_tb_hidesal').show();
    });
//SHOW THE TEXTBOX FOR CURRENT SALARY ENTRY.............
    $('#STDLY_SEARCH_radio_newslr').click(function(){
        $('#STDLY_SEARCH_tb_hidesal').hide();
        $('#STDLY_SEARCH_tb_hidesal1').show();
        $('#STDLY_SEARCH_tb_hidesal1').val('');
        $('#STDLY_SEARCH_btn_sbutton').attr("disabled", "disabled");
    });
//<!-- RADIO BUTTON FUNCTIONS FOR GET CPF AMOUNT IN THE SALARY ENTRY -->
    $('#STDLY_SEARCH_radio_currentcpfamt').click(function(){
        var STDLY_SEARCH_listvalue=$('#STDLY_SEARCH_hideempname').val();
        $('#STDLY_SEARCH_tb_hidecpf1').hide().val('');
        $('#STDLY_SEARCH_tb_hidecpf').val(STDLY_SEARCH_cpfamt);
        $('#STDLY_SEARCH_tb_gethiddenecpf').val(STDLY_SEARCH_cpfamt);
        $('#STDLY_SEARCH_tb_hidecpf').show();
    });
//SHOW THE TEXTBOX FOR CPF AMOUNT ENTRY.............
    $('#STDLY_SEARCH_radio_newcpfamt').click(function(){
        $('#STDLY_SEARCH_tb_hidecpf').hide();
        $('#STDLY_SEARCH_tb_hidecpf1').show();
        $('#STDLY_SEARCH_tb_hidecpf1').val('');
        $('#STDLY_SEARCH_btn_sbutton').attr("disabled", "disabled");
    });
//<!-- RADIO BUTTON FUNCTIONS FOR GET LEVY AMOUNT IN THE SALARY ENTRY -->
    $('#STDLY_SEARCH_radio_currentlevyamt').click(function(){
        var STDLY_SEARCH_listvalue=$('#STDLY_SEARCH_hideempname').val();
        $('#STDLY_SEARCH_tb_hidelevy1').hide().val('');
        $('#STDLY_SEARCH_tb_hidelevy').val(STDLY_SEARCH_levy);
        $('#STDLY_SEARCH_tb_gethiddenelevy').val(STDLY_SEARCH_levy);
        $('#STDLY_SEARCH_tb_hidelevy').show();
    });
//SHOW THE TEXTBOX FOR LEVY AMOUNT ENTRY.............
    $('#STDLY_SEARCH_radio_newlevyamt').click(function(){
        $('#STDLY_SEARCH_tb_hidelevy').hide();
        $('#STDLY_SEARCH_tb_hidelevy1').show();
        $('#STDLY_SEARCH_tb_hidelevy1').val('');
        $('#STDLY_SEARCH_btn_sbutton').attr("disabled", "disabled");
    });

    $(".radiosubmitval").click(function(){
        var flag=0;
        if( $('#STDLY_SEARCH_radio_currentslr').is(":checked")==true)
        {
            var STDLY_SEARCH_radio_radiovalue="data";
        }
        else if(( $('#STDLY_SEARCH_radio_newslr').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidesal1").val()!="")&&(parseInt($("#STDLY_SEARCH_tb_hidesal1").val())!=0))
        {
            var STDLY_SEARCH_radio_radiovalue="data";
        }
        if(($("#STDLY_SEARCH_lb_namelist").val()=="SELECT")||($("#STDLY_SEARCH_db_paiddate").val()=="")||($("#STDLY_SEARCH_db_fromdate").val()=="")||($("#STDLY_SEARCH_db_todate").val()=="")||(STDLY_SEARCH_radio_radiovalue !="data")||(( $('#STDLY_SEARCH_radio_newcpfamt').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidecpf1").val()==""))||(( $('#STDLY_SEARCH_radio_newlevyamt').is(":checked")==true)&&($("#STDLY_SEARCH_tb_hidelevy1").val()=="")))
        {
            flag=1;
        }
        if(flag=="1")
        {
            $('#STDLY_SEARCH_btn_sbutton').attr("disabled", "disabled");
        }
        else
        {
            $('#STDLY_SEARCH_btn_sbutton').removeAttr("disabled");
        }
    });
    $('#STDLY_SEARCH_btn_sbutton').click(function()
    {
//        var  newPos= adjustPosition($(this).position(),100,280);
//        resetPreloader(newPos);
//        $(".preloader").show();
        STDLY_SEARCH_btn_sbuttonresult()
    });
    var STDLY_INPUT_response;
    function STDLY_SEARCH_btn_sbuttonresult()
    {
        var STDLY_SEARCH_typelist=$('#STDLY_SEARCH_lb_typelist').val();
        var STDLY_SEARCH_empname=$('#STDLY_SEARCH_lb_namelist').val();
        var STDLY_SEARCH_comments=$('#STDLY_SEARCH_ta_salarycommentsbox').val();
        var STDLY_SEARCH_paiddate=$('#STDLY_SEARCH_db_paiddate').val();
//        var STDLY_SEARCH_cpfradio=$('#STDLY_SEARCH_radio_cpfamt').val();
        var STDLY_SEARCH_cpfradio=$("input[name=STDLY_SEARCH_radio_cpfamt]:checked").val();
//        var STDLY_SEARCH_levyradio=$('#STDLY_SEARCH_radio_levyamt').val();
        var STDLY_SEARCH_levyradio=$("input[name=STDLY_SEARCH_radio_levyamt]:checked").val();
        var STDLY_SEARCH_fromperiod=$('#STDLY_SEARCH_db_fromdate').val();
        var STDLY_SEARCH_toperiod=$('#STDLY_SEARCH_db_todate').val();
        var STDLY_SEARCH_hidenlevyamount=$('#STDLY_SEARCH_tb_gethiddenelevy').val();
        var STDLY_SEARCH_hidensalaryamount=$('#STDLY_SEARCH_tb_gethiddenesal').val();
        var STDLY_SEARCH_hidencpfamount=$('#STDLY_SEARCH_tb_gethiddenecpf').val();
        var STDLY_SEARCH_cpfamount=$('#STDLY_SEARCH_tb_hidecpf1').val();
        var STDLY_SEARCH_searchoption=$('#STDLY_SEARCH_lb_salarysearchoption').val();
        var STDLY_SEARCH_tb_hidelevy1=$('#STDLY_SEARCH_tb_hidelevy1').val();
        var STDLY_SEARCH_tb_hidesal1=$('#STDLY_SEARCH_tb_hidesal1').val();
        $.ajax({
            type: "POST",
            'url':STDLY_SEARCH_controller_url+"updatefunction_staffentry",
            data:{'id':currentid,'STDLY_SEARCH_typelist':STDLY_SEARCH_typelist,'STDLY_SEARCH_comments':STDLY_SEARCH_comments,'STDLY_SEARCH_paiddate':STDLY_SEARCH_paiddate,'STDLY_SEARCH_cpfradio':STDLY_SEARCH_cpfradio,'STDLY_SEARCH_levyradio':STDLY_SEARCH_levyradio,'STDLY_SEARCH_fromperiod':STDLY_SEARCH_fromperiod,'STDLY_SEARCH_toperiod':STDLY_SEARCH_toperiod,'STDLY_SEARCH_hidenlevyamount':STDLY_SEARCH_hidenlevyamount,'STDLY_SEARCH_hidensalaryamount':STDLY_SEARCH_hidensalaryamount,'STDLY_SEARCH_hidencpfamount':STDLY_SEARCH_hidencpfamount,'STDLY_SEARCH_cpfamount':STDLY_SEARCH_cpfamount,'STDLY_SEARCH_searchoption':STDLY_SEARCH_searchoption,'STDLY_SEARCH_tb_hidelevy1':STDLY_SEARCH_tb_hidelevy1,'STDLY_SEARCH_tb_hidesal1':STDLY_SEARCH_tb_hidesal1},
            success: function(data) {
                $(".preloader").hide();
                STDLY_INPUT_response=JSON.parse(data)
                salary_entry_response=STDLY_INPUT_response.SUCCESSMSG
                if(salary_entry_response==1)
                {
                    var replacetype=$('#STDLY_SEARCH_lb_typelist').find('option:selected').text();
                    var STDLY_INPUT_CONFSAVEMSG = errormsg[2].EMC_DATA.replace('[TYPE]', replacetype);
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",STDLY_INPUT_CONFSAVEMSG,"success",false)
                    STDLY_SEARCH_salaryfunction()
                }
                else
                {
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",STDLY_INPUT_response,"error",false)
                }
            }
        });
    }
    //RESET ALL THE FORM ELEMENTS..................
    $('.resetsubmit').click(function(){
        $(".preloader").show();
        var STDLY_SEARCH_listvalue=$('#STDLY_SEARCH_lb_typelist').val();
        if(STDLY_SEARCH_listvalue==40)
        {
            $(".preloader").hide();
            $('#STDLY_SEARCH_tb_hidesal').val('');
            $('#STDLY_SEARCH_tb_hidesal1').val('');
            $('#STDLY_SEARCH_tb_hidecpf').val('');
            $('#STDLY_SEARCH_tb_hidecpf1').val('');
            $('#STDLY_SEARCH_tb_hidelevy').val('');
            $('#STDLY_SEARCH_tb_hidelevy1').val('');
            $('#STDLY_SEARCH_tb_hidesal').hide();
            $('#STDLY_SEARCH_tb_hidesal1').hide();
            $('#STDLY_SEARCH_tb_hidecpf').hide();
            $('#STDLY_SEARCH_tb_hidecpf1').hide();
            $('#STDLY_SEARCH_tb_hidelevy').hide();
            $('#STDLY_SEARCH_tb_hidelevy1').hide();
            $("#STDLY_SEARCH_lb_namelist")[0].selectedIndex = 0;
            $('#STDLY_SEARCH_db_fromdate').val('');
            $('#STDLY_SEARCH_db_paiddate').val('');
            $('#STDLY_SEARCH_db_todate').val('');
            $('#STDLY_SEARCH_db_fromdate') .datepicker( "option", "maxDate", new Date() );
            $('#STDLY_SEARCH_db_todate') .datepicker( "option", "maxDate", new Date() );
            $('#STDLY_SEARCH_db_todate') .datepicker( "option", "minDate", null);
            $('#STDLY_SEARCH_ta_salarycommentsbox').val('');
            $('input[name="STDLY_SEARCH_radio_slramt"]').prop('checked', false);
            $('input[name="STDLY_SEARCH_radio_cpfamt"]').prop('checked', false);
            $('input[name="STDLY_SEARCH_radio_levyamt"]').prop('checked', false);
            $('#STDLY_SEARCH_btn_sbutton').attr("disabled", "disabled");
        }
        $('#STDLY_SEARCH_ta_salarycommentsbox,#STDLY_SEARCH_ta_comment,#STDLY_SEARCH_tb_comments1,#STDLY_SEARCH_ta_invitem1').height(20);
    });
    //STAFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF
    //CALL BY STAFF SELECTED OPTION..................
    $('#STDLY_SEARCH_lb_staffsearchoption').change(function(){
        $('.datebox') .datepicker( "option", "minDate", null);
        $('.datebox') .datepicker( "option", "minDate", new Date(1969, 10 , 19));
        $('#STDLY_SEARCH_lbl_errmsg').text('');
        $('#STDLY_SEARCH_lbl_byemployeename').hide();
        $('#STDLY_SEARCH_lbl_salaryheadermesg').hide();
        $(".preloader").show();
        $('#STDLY_SEARCH_lbl_searchbydiv').hide();
        $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
        $('#STDLY_SEARCH_lbl_salarycomments').hide();
        $('#STDLY_SEARCH_lb_searchbyemployeename').hide();
        $('#STDLY_SEARCH_lbl_searchbyemployeename').hide();
        var STDLY_SEARCH_staffselectedoption=$('#STDLY_SEARCH_lb_staffsearchoption').val();
        if(STDLY_SEARCH_staffselectedoption=="SELECT")
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').hide();
            $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
            $('#STDLY_SEARCH_lbl_salarycomments').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_db_startdate').val('');
            $('#STDLY_SEARCH_db_enddate').val('');
            $('#STDLY_SEARCH_tb_fromamount').val('');
            $('#STDLY_SEARCH_tb_toamount').val('');
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_tble_agenttable').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
        }
        if(STDLY_SEARCH_staffselectedoption==80)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            STDLY_SEARCH_staffallcategory();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
        }
        if(STDLY_SEARCH_staffselectedoption==84)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').val('').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_lbl_fromamount').show();
            $('#STDLY_SEARCH_lbl_toamount').show();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_tb_fromamount').val('').show();
            $('#STDLY_SEARCH_tb_toamount').val('').show();
            $('#STDLY_SEARCH_btn_staffbutton').show();
            $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_staffsearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_staffselectedoption==81)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').val('').hide();
            $('#STDLY_SEARCH_tb_toamount').val('').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').val('').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_btn_staffbutton').show();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_staffsearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_staffselectedoption==82)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').val('').hide();
            $('#STDLY_SEARCH_tb_toamount').val('').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').val('').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_staffsearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').hide();
        }
        if(STDLY_SEARCH_staffselectedoption==83)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_tb_searchcomments').val('').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').val('').hide();
            $('#STDLY_SEARCH_tb_toamount').val('').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_staffsearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }
        if(STDLY_SEARCH_staffselectedoption==79)
        {$(".preloader").hide();
            $('#STDLY_SEARCH_lbl_searchbydiv').show();
            $('#STDLY_SEARCH_lbl_invitemcom').hide();
            $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
            $('#STDLY_SEARCH_lbl_staffexpansecategory').hide();
            $('#STDLY_SEARCH_lb_staffexpansecategory').hide();
            $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            $('#STDLY_SEARCH_lbl_startdate').show();
            $('#STDLY_SEARCH_lbl_enddate').show();
            $('#STDLY_SEARCH_tble_agenttable').show();
            $('#STDLY_SEARCH_lbl_commentlbl').hide();
            $('#STDLY_SEARCH_lbl_fromamount').hide();
            $('#STDLY_SEARCH_lbl_toamount').hide();
            $('#STDLY_SEARCH_tb_fromamount').val('').hide();
            $('#STDLY_SEARCH_tb_toamount').val('').hide();
            $('#STDLY_SEARCH_tb_searchcomments').val('').hide();
            $('#STDLY_SEARCH_db_startdate').val('').show();
            $('#STDLY_SEARCH_db_enddate').val('').show();
            $('#STDLY_SEARCH_btn_staffbutton').hide();
            $('#STDLY_SEARCH_tble_multi').hide();
            $('#STDLY_SEARCH_div_htmltable').hide();
            $('#STDLY_SEARCH_div_salaryhtmltable').hide();
            $('#STDLY_SEARCH_tble_agentupdateform').hide();
            $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
            $('#STDLY_SEARCH_btn_deletebutton').hide();
            $('#STDLY_SEARCH_btn_salarybutton').hide();
            $('#STDLY_SEARCH_btn_agentsbutton').hide();
            $('#STDLY_SEARCH_btn_sbutton').hide();
            $('#STDLY_SEARCH_btn_searchbutton').hide();
            $('#STDLY_SEARCH_btn_rbutton').hide();
            $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_staffsearchoption').find('option:selected').text()).show();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
            $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#STDLY_SEARCH_lbl_headermesg').hide();
        }});
    $('#STDLY_SEARCH_div_salaryhtmltable').hide();
    $('#STDLY_SEARCH_div_htmltable').hide();
    $('#STDLY_SEARCH_btn_salarybutton').hide();
    $('#STDLY_SEARCH_btn_sbutton').hide();
    $('#STDLY_SEARCH_btn_searchbutton').hide();
    $('#STDLY_SEARCH_btn_deletebutton').hide();
    $('#STDLY_SEARCH_btn_rbutton').hide();
    $('#STDLY_SEARCH_btn_staffbutton').hide();
    $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
    $('#STDLY_SEARCH_lbl_emp').hide();
    $('#STDLY_SEARCH_btn_agentsbutton').hide();
//LOAD ALL STAFF CATEGORY.......................
    function STDLY_SEARCH_staffallcategory()//STDLY_SEARCH_category
    {$(".preloader").hide();
        var options ='';
        for (var i = 0; i < STDLY_SEARCH_expensestaff.length; i++) {
            if( i>=0 && i<=4)
            {
                var STDLY_SEARCH_expenseArrayallid=STDLY_SEARCH_expensestaff[i].ECN_ID;
                var STDLY_SEARCH_expenseArray=STDLY_SEARCH_expensestaff[i].ECN_DATA;
                options += '<option value="' + STDLY_SEARCH_expenseArrayallid+ '">' + STDLY_SEARCH_expenseArray+ '</option>';
            }
        }
        $('#STDLY_SEARCH_lb_staffexpansecategory').html(options);
        STDLY_SEARCH_Sortit('STDLY_SEARCH_lb_staffexpansecategory');
        $('#STDLY_SEARCH_tble_agenttable').show();
        $('#STDLY_SEARCH_lbl_byagentcomments').text($('#STDLY_SEARCH_lb_staffsearchoption').find('option:selected').text()).show();
        $('#STDLY_SEARCH_lbl_staffexpansecategory').show();
        $('#STDLY_SEARCH_lb_staffexpansecategory').show();
        $('#STDLY_SEARCH_lbl_startdate').show();
        $('#STDLY_SEARCH_db_startdate').val('').show();
        $('#STDLY_SEARCH_lbl_enddate').show();
        $('#STDLY_SEARCH_db_enddate').val('').show();
        $('#STDLY_SEARCH_btn_staffbutton').show();
        $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
        $('#STDLY_SEARCH_lbl_salarycomments').hide();
        $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
        $('#STDLY_SEARCH_lb_searchbycpfno').hide();
        $('#STDLY_SEARCH_lbl_searchbycpfno').hide();
        $('#STDLY_SEARCH_btn_salarybutton').hide();
        $('#STDLY_SEARCH_tble_multi').hide();
        $('#STDLY_SEARCH_lbl_invfromcomt').val('').hide();
        $('#STDLY_SEARCH_tb_invfromcomt').val('').hide();
        $('#STDLY_SEARCH_div_htmltable').hide();
        $('#STDLY_SEARCH_div_salaryhtmltable').hide();
        $('#STDLY_SEARCH_tble_agentupdateform').hide();
        $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
        $('#STDLY_SEARCH_btn_deletebutton').hide();
        $('#STDLY_SEARCH_btn_salarybutton').hide();
        $('#STDLY_SEARCH_btn_agentsbutton').hide();
        $('#STDLY_SEARCH_btn_sbutton').hide();
        $('#STDLY_SEARCH_btn_searchbutton').hide();
        $('#STDLY_SEARCH_btn_rbutton').hide();
        $('#STDLY_SEARCH_tb_searchcomments').val('').hide();
        $('#STDLY_SEARCH_lbl_invitemcom').hide();
        $('#STDLY_SEARCH_tb_invitemcomt').val('').hide();
        $('#STDLY_SEARCH_lbl_fromamount').hide();
        $('#STDLY_SEARCH_lbl_toamount').hide();
        $('#STDLY_SEARCH_tb_fromamount').val('').hide();
        $('#STDLY_SEARCH_tb_toamount').val('').hide();
    }
    // STARTING AGENT SEARCH BUTTON VALIDATION.....................
    $(".submitvalagent").change(function(){
        $('textarea').height(20);
        $('#STDLY_SEARCH_ta_salarycommentsbox').hide();
        $('#STDLY_SEARCH_lbl_salarycomments').hide();
        $('#STDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#STDLY_SEARCH_lbl_headermesg').hide();
        $('#STDLY_SEARCH_tble_multi').hide();
        $('#STDLY_SEARCH_div_htmltable').hide();
        $('#STDLY_SEARCH_div_salaryhtmltable').hide();
        $('#STDLY_SEARCH_tble_agentupdateform').hide();
        $('#STDLY_SEARCH_tbl_salaryupdatetable').hide();
        $('#STDLY_SEARCH_btn_deletebutton').hide();
        $('#STDLY_SEARCH_btn_sbutton').hide();
        $('#STDLY_SEARCH_btn_searchbutton').hide();
        $('#STDLY_SEARCH_btn_rbutton').hide();
        var STDLY_SEARCH_optionval=$("#STDLY_SEARCH_lb_searchoption").val();
        var STDLY_SEARCH_salaryoptionval=$("#STDLY_SEARCH_lb_salarysearchoption").val();
        var STDLY_SEARCH_staffoptionval=$("#STDLY_SEARCH_lb_staffsearchoption").val();
        if(STDLY_SEARCH_optionval==78)
        {
            if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                }
            }
            if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#STDLY_SEARCH_btn_agentsbutton').removeAttr("disabled");
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                    $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
                }
            }
            else
            {
                $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
            }
        }
        if(STDLY_SEARCH_optionval==77)
        {
            if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_tb_searchcomments").val()==""))
            {
                $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_agentsbutton').removeAttr("disabled");
            }
        }
        if(STDLY_SEARCH_optionval==76)
        {
            if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
            {
                $('#STDLY_SEARCH_btn_agentsbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_agentsbutton').removeAttr("disabled");
            }
        }
        if(STDLY_SEARCH_salaryoptionval==86)
        {
            if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                }
            }
            if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
        }
        if(STDLY_SEARCH_salaryoptionval==93)
        {
            if(($("#STDLY_SEARCH_lb_searchbycpfno").val()=="SELECT"))
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
            }
        }
//VALIDATION BY EMPLOYEE NAME...............................................
        if(STDLY_SEARCH_salaryoptionval==90)
        {
            if(($("#STDLY_SEARCH_lb_searchbyemployeename").val()=="SELECT"))
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
            }
        }
//VALIDATION BY SALARY AMOUNT..................
        if(STDLY_SEARCH_salaryoptionval==88)
        {
            if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                }
            }
            if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
        }
//VALIDATION BY SALARY COMMENTS..................
        if(STDLY_SEARCH_salaryoptionval==85)
        {
            if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_tb_searchcomments").val()==""))
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
            }
        }
//VALIDATION BY SALARY COMMENTS..................
        if(STDLY_SEARCH_salaryoptionval==91)
        {
            if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
            }
        }
//VALIDATION BY LEVY AMOUNT..................
        if(STDLY_SEARCH_salaryoptionval==87)
        {
            if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                }
            }
            if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                    $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
                }
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
        }
//VALIDATION BYSALARY PAID DATE................
        if(STDLY_SEARCH_salaryoptionval==89)
        {
            if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
            }
        }
//VALIDATION BY SEARCH BY TO PERIOD//
        if(STDLY_SEARCH_salaryoptionval==92)
        {
            if(($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
            {
                $('#STDLY_SEARCH_btn_salarybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_salarybutton').removeAttr("disabled");
            }
        }
//STAFF SEARCHING//
//STAFF SEARCHING = SEARCH BY CATEGORY//
        if(STDLY_SEARCH_staffoptionval==80)
        {
            if(($("#STDLY_SEARCH_lb_staffexpansecategory").val()=="SELECT")||($("#STDLY_SEARCH_db_startdate").val()=="")||($("#STDLY_SEARCH_db_enddate").val()==""))
            {
                $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH ,BY STAFF INVOICE AMOUNT//
        if(STDLY_SEARCH_staffoptionval==84)
        {
            if(($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                }
            }
            if(($("#STDLY_SEARCH_db_startdate").val()!="")&&($("#STDLY_SEARCH_db_enddate").val()!="")&&($("#STDLY_SEARCH_tb_fromamount").val()!="")&&($("#STDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#STDLY_SEARCH_lbl_amounterrormsg').text(STDLY_SEARCH_errorArray[0]).show();
                    $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
                }
            }
            else
            {
                $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            }
        }
//VALIDATION TO SEARCH  , SEARCH BY INVOICE DATE//
        if(STDLY_SEARCH_staffoptionval==81)
        {
            if(($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_db_startdate").val()==""))
            {
                $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH , SEARCH BY INVOICE FROM.//
        if(STDLY_SEARCH_staffoptionval==82)
        {
            if(($("#STDLY_SEARCH_tb_invfromcomt").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_db_startdate").val()==""))
            {
                $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH , SEARCH BY INVOICE ITEMS.........
        if(STDLY_SEARCH_staffoptionval==83)
        {
            if(($("#STDLY_SEARCH_tb_invitemcomt").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_db_startdate").val()==""))
            {
                $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH , SEARCH BY STAFF COMMENTS.........
        if(STDLY_SEARCH_staffoptionval==79)
        {
            if(($("#STDLY_SEARCH_tb_searchcomments").val()=="")||($("#STDLY_SEARCH_db_enddate").val()=="")||($("#STDLY_SEARCH_db_startdate").val()==""))
            {
                $('#STDLY_SEARCH_btn_staffbutton').attr("disabled", "disabled");
            }
            else
            {
                $('#STDLY_SEARCH_btn_staffbutton').removeAttr("disabled");
            }
        }
    });
    //SEARCHING BY  STAFF CATEGORY FOR FLEX TABLE..................
    $('#STDLY_SEARCH_btn_staffbutton').click(function(){
//        var  newPos= adjustPosition($(this).position(),100,120);
//        resetPreloader(newPos);
//        STDLY_SEARCH_flag_srchUpdDel=0;
        STDLY_SEARCH_staffsearching();
    });
    function STDLY_SEARCH_staffsearching()
    {
        $(".preloader").show();
        $('#STDLY_SEARCH_tble_multi').hide();
        var STDLY_SEARCH_staffoptionvalmatch=$("#STDLY_SEARCH_lb_staffsearchoption").val();
        if(STDLY_SEARCH_staffoptionvalmatch==80)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_invitemcom="";
            var STDLY_SEARCH_invfromcomt="";
            var STDLY_SEARCH_staffexpansecategory=$('#STDLY_SEARCH_lb_staffexpansecategory').val();
            STDLY_SEARCH_staffsearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_staffsearchdetails).STDLY_SEARCH_searchbystaff(STDLY_SEARCH_staffoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_staffexpansecategory,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_searchcomments,STDLY_SEARCH_invitemcom,STDLY_SEARCH_invfromcomt);
        }
        if(STDLY_SEARCH_staffoptionvalmatch==84)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount=$('#STDLY_SEARCH_tb_fromamount').val();
            var STDLY_SEARCH_toamount=$('#STDLY_SEARCH_tb_toamount').val();
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_invitemcom="";
            var STDLY_SEARCH_invfromcomt="";
            var STDLY_SEARCH_staffexpansecategory=$('#STDLY_SEARCH_lb_staffexpansecategory').val();
            STDLY_SEARCH_staffsearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_staffsearchdetails).STDLY_SEARCH_searchbystaff(STDLY_SEARCH_staffoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_staffexpansecategory,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_searchcomments,STDLY_SEARCH_invitemcom,STDLY_SEARCH_invfromcomt);
        }
        if(STDLY_SEARCH_staffoptionvalmatch==81)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_invitemcom="";
            var STDLY_SEARCH_invfromcomt="";
            var STDLY_SEARCH_staffexpansecategory=$('#STDLY_SEARCH_lb_staffexpansecategory').val();
            STDLY_SEARCH_staffsearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_staffsearchdetails).STDLY_SEARCH_searchbystaff(STDLY_SEARCH_staffoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_staffexpansecategory,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_searchcomments,STDLY_SEARCH_invitemcom,STDLY_SEARCH_invfromcomt);
        }
        if(STDLY_SEARCH_staffoptionvalmatch==82)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_invfromcomt=$('#STDLY_SEARCH_tb_invfromcomt').val();
            var STDLY_SEARCH_invitemcom="";
            var STDLY_SEARCH_staffexpansecategory=$('#STDLY_SEARCH_lb_staffexpansecategory').val();
            STDLY_SEARCH_staffsearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_staffsearchdetails).STDLY_SEARCH_searchbystaff(STDLY_SEARCH_staffoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_staffexpansecategory,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_searchcomments,STDLY_SEARCH_invitemcom,STDLY_SEARCH_invfromcomt);
        }
        if(STDLY_SEARCH_staffoptionvalmatch==83)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_searchcomments="";
            var STDLY_SEARCH_invitemcom=$('#STDLY_SEARCH_tb_invitemcomt').val();
            var STDLY_SEARCH_invfromcomt="";
            var STDLY_SEARCH_staffexpansecategory=$('#STDLY_SEARCH_lb_staffexpansecategory').val();
            STDLY_SEARCH_staffsearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_staffsearchdetails).STDLY_SEARCH_searchbystaff(STDLY_SEARCH_staffoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_staffexpansecategory,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_searchcomments,STDLY_SEARCH_invitemcom,STDLY_SEARCH_invfromcomt);
        }
        if(STDLY_SEARCH_staffoptionvalmatch==79)
        {
            var STDLY_SEARCH_startdate=$('#STDLY_SEARCH_db_startdate').val();
            var STDLY_SEARCH_enddate=$('#STDLY_SEARCH_db_enddate').val();
            var STDLY_SEARCH_fromamount="";
            var STDLY_SEARCH_toamount="";
            var STDLY_SEARCH_searchcomments=$('#STDLY_SEARCH_tb_searchcomments').val();
            var STDLY_SEARCH_staffexpansecategory=$('#STDLY_SEARCH_lb_staffexpansecategory').val();
            var STDLY_SEARCH_invitemcom="";
            var STDLY_SEARCH_invfromcomt="";
            STDLY_SEARCH_staffsearchdetails()
//            google.script.run.withFailureHandler(STDLY_SEARCH_onFailure).withSuccessHandler(STDLY_SEARCH_staffsearchdetails).STDLY_SEARCH_searchbystaff(STDLY_SEARCH_staffoptionvalmatch,STDLY_SEARCH_startdate,STDLY_SEARCH_enddate,STDLY_SEARCH_staffexpansecategory,STDLY_SEARCH_fromamount,STDLY_SEARCH_toamount,STDLY_SEARCH_searchcomments,STDLY_SEARCH_invitemcom,STDLY_SEARCH_invfromcomt);
        }
    }

    var STDLY_SEARCH_comments;var STDLY_SEARCH_userstamp;var STDLY_SEARC_timestamp;
    var id;
    var STDLY_SEARCH_amount;
    function  STDLY_SEARCH_staffsearchdetails()
    {
        var STDLY_SEARCH_startdate = $("#STDLY_SEARCH_db_startdate").val();
        var STDLY_SEARCH_enddate = $("#STDLY_SEARCH_db_enddate").val();
        var STDLY_SEARCH_fromamount = $("#STDLY_SEARCH_tb_fromamount").val();
        var STDLY_SEARCH_toamount = $("#STDLY_SEARCH_tb_toamount").val();
//        var STDLY_SEARCH_searchoptio=$('#STDLY_SEARCH_lb_salarysearchoption').val();
        var STDLY_SEARCH_searchcomments=$('#STDLY_SEARCH_tb_searchcomments').val();
        var STDLY_SEARCH_staffexpansecategory=$('#STDLY_SEARCH_lb_staffexpansecategory').find('option:selected').text();
        var STDLY_SEARCH_searchoptio=$('#STDLY_SEARCH_lb_staffsearchoption').val();
        var STDLY_SEARCH_invfromcomt=$('#STDLY_SEARCH_tb_invfromcomt').val();
        var STDLY_SEARCH_invitemcom=$('#STDLY_SEARCH_tb_invitemcomt').val();
        $('.preloader').hide();
        $.ajax({
            type: "POST",
            'url':STDLY_SEARCH_controller_url+"STDLY_SEARCH_sendallstaffdata",
            data: {'STDLY_SEARCH_searchoptio':STDLY_SEARCH_searchoptio,'STDLY_SEARCH_staffexpansecategory':STDLY_SEARCH_staffexpansecategory,'STDLY_SEARCH_startdate':STDLY_SEARCH_startdate,'STDLY_SEARCH_enddate':STDLY_SEARCH_enddate,'STDLY_SEARCH_fromamount':STDLY_SEARCH_fromamount,'STDLY_SEARCH_toamount':STDLY_SEARCH_toamount,'STDLY_SEARCH_searchcomments':STDLY_SEARCH_searchcomments,'STDLY_SEARCH_invfromcomt':STDLY_SEARCH_invfromcomt,'STDLY_SEARCH_invitemcom':STDLY_SEARCH_invitemcom},
            success: function(data) {
                values_array=JSON.parse(data);
                if(values_array.length!=0)
                {
                    var STDLY_SEARCH_table_value='<table id="STDLY_SEARCH_tbl_salaryhtmltable" border="1"  cellspacing="0" class="srcresult" width="1500" ><thead  bgcolor="#6495ed" style="color:white"><tr><th>DELETE</th><th style="width:170px;">STAFF EXPENSE</th><th class="uk-date-column" style="width:105px;">INVOICE DATE</th><th style="width:65px;">INVOICE AMOUNT</th><th style="width:150px;">INVOICE ITEMS</th><th style="width:150px;">INVOICE FROM</th><th style="width:200px;">COMMENTS</th><th style="width:150px;">USERSTAMP</th><th style="width:160px;" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>'
//                    var ET_SRC_UPD_DEL_errmsg =value_err_array[4].EMC_DATA.replace('[SCRIPT]',ET_SRC_UPD_DEL_name);
//                    $('#ET_SRC_UPD_DEL_div_header').text(ET_SRC_UPD_DEL_errmsg).show();
                    for(var j=0;j<values_array.length;j++){
                        var STDLY_SEARCH_values=values_array[j];
                        id=values_array[j].ES_ID;
                        STDLY_SEARCH_amount=values_array[j].STDLY_SEARCH_amount;
                        STDLY_SEARCH_comments=values_array[j].COMMENTS;
                        if((STDLY_SEARCH_comments=='null')||(STDLY_SEARCH_comments==undefined))
                        {
                            STDLY_SEARCH_comments='';
                        }
                        STDLY_SEARCH_userstamp=values_array[j].USERSTAMP;
                        STDLY_SEARC_timestamp=values_array[j].timestamp;
                        STDLY_SEARCH_table_value+='<tr><td><div class="col-lg-1"><span style="display: block;color:red" id ='+id+' class="glyphicon glyphicon-trash deletebutton" title="Delete"></span></td><td id=staffcategory_'+id+' class="staffedit">'+STDLY_SEARCH_values.STDLY_SEARCH_type+'</td><td id=staffdate_'+id+' class="staffedit">'+STDLY_SEARCH_values.STDLY_SEARCH_date+'</td><td id=staffamountlist_'+id+' class="staffedit" >'+STDLY_SEARCH_amount+'</td><td id=staffinvoiceitem_'+id+' class="staffedit">'+STDLY_SEARCH_values.STDLY_SEARCH_items+'</td><td id=staffinvoicefrom_'+id+' class="staffedit">'+STDLY_SEARCH_values.STDLY_SEARCH_from+'</td><td id=comments_'+id+' class="staffedit">'+STDLY_SEARCH_comments+'</td><td>'+STDLY_SEARCH_userstamp+'</td><td>'+STDLY_SEARC_timestamp+'</td></tr>';
                    }
                    STDLY_SEARCH_table_value+='</tbody></table>';
                    $('#STDLY_SEARCH_sec_salryentry').html(STDLY_SEARCH_table_value);
                    $('#STDLY_SEARCH_tbl_salaryhtmltable').DataTable({
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers",
                        "aoColumnDefs" : [
                            { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ]

                    });
                }
                else
                {
                    $('#ET_SRC_UPD_DEL_div_header').hide();
                    $('#ET_SRC_UPD_DEL_div_table').hide();
//                    $('#ET_SRC_UPD_DEL_div_headernodata').text(value_err_array[2].EMC_DATA).show();
                    $('#STDLY_SEARCH_tbl_salaryhtmltable').hide();
                    $('section').html('');
                    $('.preloader').hide();
                }
                $('#STDLY_SEARCH_div_salaryhtmltable').show();
            }
        });
        sorting()
    }
    var previous_id;
    var combineid;
    var tdvalue;
    var check;
    var staff_category_id;
    var staff_category_list;
    var staffdate_id;
    var staff_invoice_from;
    var staff_invoice_item;
    var comments_id;
    var staff_staffamountlist;
    var agentdate_id;
    var agent_commissionamt;
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
        if(id[0]=='staffamountlist' && tdvalue!=''){
            staff_staffamountlist='staff_amount_list_'+id[1];
            $('#staffamountlist_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='"+staff_staffamountlist+"' name='data'  class='staffdlyupdate amountonly'   value='"+tdvalue+"'>");
            $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        }
        else if(id[0]=='staffinvoiceitem'){
            staff_invoice_item='staff_invoiceitem_'+id[1];
            $('#staffinvoiceitem_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><textarea id='"+staff_invoice_item+"' name='data'  class='staffdlyupdate' style='width: 200px'>"+tdvalue+"</textarea></td>");
        }
        else if(id[0]=='staffcategory'){
            staff_category_id='staff_invoiceitem_'+id[1];
//             $('#staffcategory_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='"+staff_category_list+"' name='data'  class='staffdlyupdate amountonly'   value='"+tdvalue+"'>");
            $('#staffcategory_'+id[1]).replaceWith("<td  class='new' id='"+previous_id+"'><select class='form-control staffdlyupdate' id='"+staff_category_id+"' style='width: 250px;'></select></td>");
            var staffcategory='<option value="SELECT">SELECT</option>';
            for (var i = 0; i < STDLY_SEARCH_expensestaff.length; i++) {
                if( i>=0 && i<=4)
                {
                    var STDLY_SEARCH_expenseArrayallid=STDLY_SEARCH_expensestaff[i].ECN_ID;
                    var STDLY_SEARCH_expenseArray=STDLY_SEARCH_expensestaff[i].ECN_DATA;
                    if(STDLY_SEARCH_expensestaff[i].ECN_DATA==id[0])
                    {
                        var categorysindex=i;
                    }
                    staffcategory += '<option value="' + STDLY_SEARCH_expensestaff[i].ECN_ID + '">' + STDLY_SEARCH_expensestaff[i].ECN_DATA + '</option>';
                }
            }
            $('#'+staff_category_id).html(staffcategory)
            $('#'+staff_category_id).prop('selectedIndex',categorysindex);
        }
        else if(id[0]=='staffinvoicefrom'){
            staff_invoice_from='staff_invoice_from'+id[1];
            $('#staffinvoicefrom_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='"+staff_invoice_from+"' name='data'  class='staffdlyupdate amountonly'   value='"+tdvalue+"'>");
        }
        else if(id[0]=='comments'){
            comments_id='commentsid'+id[1];
            $('#comments_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><textarea id='"+comments_id+"' name='data'  class='staffdlyupdate' style='width: 200px'>"+tdvalue+"</textarea></td>");
        }
        else if(id[0]=='staffdate'){
            staffdate_id='staffdateid'+id[1];
            $('#staffdate_'+id[1]).replaceWith("<td  class='new' id='"+staffdate_id+"'><input type='text' id='staff_date' name='data'  class='staffdlyupdate form-control date-picker'  style='width: 110px' value='"+tdvalue+"'></td>");
        }
        $(".date-picker").datepicker({dateFormat:'dd-mm-yy',
            changeYear: true,
            changeMonth: true
        });
        $('.date-picker').datepicker("option","maxDate",new Date());

    });
    //blur function for subject update
    $(document).on('change','.staffdlyupdate',function(){
        STDTL_SEARCH_currentval=$(this).val().trim();
        STDTL_SEARCH_agentcommissionamt=$('#'+agent_commissionamt).val();
        STDLY_SEARCH_staff_fullamount=$('#'+staff_staffamountlist).val();
        STDLY_SEARCH_tbinvoiceitems=$('#'+staff_invoice_item).val();
        STDLY_SEARCH_tbinvoicefrom=$('#'+staff_invoice_from).val();
        STDLY_SEARCH_tbcomments=$('#'+comments_id).val();
        STDLY_SEARCH_lbstaffexpense=$('#'+staff_category_id).find('option:selected').text();
        if($('#staffcategory_'+combineid).hasClass("staffedit")==true){

            var STDLY_SEARCH_lbstaffexpense=$('#staffcategory_'+combineid).text();
        }
        else{
            var STDLY_SEARCH_lbstaffexpense=STDLY_SEARCH_lbstaffexpense;
        }
        if($('#staffdate_'+combineid).hasClass("staffedit")==true){

            var STDLY_SEARCH_dbinvoicedate=$('#staffdate_'+combineid).text();
        }
        else{
            var STDLY_SEARCH_dbinvoicedate=$('#staff_date').val();
        }
        if($('#staffamountlist_'+combineid).hasClass("staffedit")==true){
            var STDLY_SEARCH_staff_fullamount=$('#staffamountlist_'+combineid).text();
        }
        else{
            var STDLY_SEARCH_staff_fullamount=STDLY_SEARCH_staff_fullamount;
        }
        if($('#staffinvoiceitem_'+combineid).hasClass("staffedit")==true){
            var STDLY_SEARCH_tbinvoiceitems=$('#staffinvoiceitem_'+combineid).text();
        }
        else{
            var STDLY_SEARCH_tbinvoiceitems=STDLY_SEARCH_tbinvoiceitems;
        }
        if($('#staffinvoicefrom_'+combineid).hasClass("staffedit")==true){
            var STDLY_SEARCH_tbinvoicefrom=$('#staffinvoicefrom_'+combineid).text();
        }
        else{
            var STDLY_SEARCH_tbinvoicefrom=STDLY_SEARCH_tbinvoicefrom;
        }
        if($('#comments_'+combineid).hasClass("staffedit")==true){
            var STDLY_SEARCH_tbcomments=$('#comments_'+combineid).text();
        }
        else{
            var STDLY_SEARCH_tbcomments=STDLY_SEARCH_tbcomments;
        }
//        var data = $('#staffdlyentry_form').serialize();
        var STDLY_SEARCH_typelist=$('#STDLY_SEARCH_lb_typelist').val();
        $.ajax({
            type: "POST",
            'url':STDLY_SEARCH_controller_url+"updatefunction",
            data:{'id':combineid,'STDLY_SEARCH_typelist':STDLY_SEARCH_typelist,'STDLY_SEARCH_lbstaffexpense':STDLY_SEARCH_lbstaffexpense,'STDLY_SEARCH_dbinvoicedate':STDLY_SEARCH_dbinvoicedate,'STDLY_SEARCH_staff_fullamount':STDLY_SEARCH_staff_fullamount,'STDLY_SEARCH_tbinvoiceitems':STDLY_SEARCH_tbinvoiceitems,'STDLY_SEARCH_tbinvoicefrom':STDLY_SEARCH_tbinvoicefrom,'STDLY_SEARCH_tbcomments':STDLY_SEARCH_tbcomments},
            success: function(STDLY_SEARCH_upd_res) {
                if(STDLY_SEARCH_upd_res=='true')
                {
                    var replacetype=$('#STDLY_SEARCH_lb_typelist').find('option:selected').text();
                    var STDLY_INPUT_CONFSAVEMSG = errormsg[2].EMC_DATA.replace('[TYPE]', replacetype);
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",STDLY_INPUT_CONFSAVEMSG,"error",false)
                    previous_id=undefined;
                    STDLY_SEARCH_staffsearchdetails()
                }
                else
                {
                    show_msgbox("STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",errormsg[38].EMC_DATA,"error",false)
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
    //AUTO COMPLETE INVOICE FROM
    //FUNCTION TO GET SELECTED VALUE
    function STDLY_SEARCH_AutoCompleteSelectitemHandler(event, ui) {
        STDLY_SEARCH_flag_autocom=1
        var STDLY_SEARCH_listoption=$('#STDLY_SEARCH_lb_typelist').val();
        $('#STDLY_SEARCH_btn_staffbutton').removeAttr('disabled').show();
    }
    $( "#STDLY_SEARCH_tb_invfromcomt" ).keypress(function(){
        var STDLY_SEARCH_lb_typelistvalue=$('#STDLY_SEARCH_lb_typelist').val();
        $('#STDLY_SEARCH_lbl_errmsg').text('');
        var searchval = [];
        searchval=STDLY_SEARCH_arr_esinvoicefrom;
//CALL FUNCTION TO HIGHLIGHT SEARCH TEXT
        STDLY_SEARCH_highlightSearchTextfrom();
        STDLY_SEARCH_flag_autocom=0;
        $( "#STDLY_SEARCH_tb_invfromcomt" ).autocomplete({
            source: searchval,
            select: STDLY_SEARCH_AutoCompleteSelectfromHandler
        });
    });
    //FUNCTION TO HIGHLIGHT SEARCH TEXT
    function STDLY_SEARCH_highlightSearchTextfrom() {
        var STDLY_SEARCH_fromcomt=$('#STDLY_SEARCH_tb_searchcomments').val();
//        var STDLY_SEARCH_conformsg=STDLY_SEARCH_errorArray[16];
//        var STDLY_SEARCH_CONFSAVEMSG = STDLY_SEARCH_conformsg.replace('[COMTS]', STDLY_SEARCH_fromcomt);
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        };
    }
    //FUNCTION TO GET SELECTED VALUE
    function STDLY_SEARCH_AutoCompleteSelectfromHandler(event, ui) {
        var STDLY_SEARCH_listoption=$('#STDLY_SEARCH_lb_typelist').val();
        $('#STDLY_SEARCH_btn_staffbutton').show();
        STDLY_SEARCH_flag_autocom=1;
    }
    //AUTO COMPLETE FOR STAFF -INVOICE ITEM
    //KEY PRESS EVENT FOR INVOICE ITEM
    $( "#STDLY_SEARCH_tb_invitemcomt" ).keypress(function(){
        $('#STDLY_SEARCH_lbl_errmsg').text('');
        var STDLY_SEARCH_lb_typelistvalue=$('#STDLY_SEARCH_lb_typelist').val();
        var searchval = [];
        $('#STDLY_SEARCH_lbl_errmsg').text('');
        searchval=STDLY_SEARCH_arr_esinvoiceitems;
//CALL FUNCTION TO HIGHLIGHT SEARCH TEXT
        STDLY_SEARCH_highlightSearchTextitem();
        $( "#STDLY_SEARCH_tb_invitemcomt" ).autocomplete({
            source: searchval,
            select: STDLY_SEARCH_AutoCompleteSelectitemHandler
        });});
    //FUNCTION TO HIGHLIGHT SEARCH TEXT
    function STDLY_SEARCH_highlightSearchTextitem() {
        var STDLY_SEARCH_fromcomt=$('#STDLY_SEARCH_tb_searchcomments').val();
//        var STDLY_SEARCH_conformsg=STDLY_SEARCH_errorArray[16];
//        var STDLY_SEARCH_CONFSAVEMSG = STDLY_SEARCH_conformsg.replace('[COMTS]', STDLY_SEARCH_fromcomt);
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        };
    }
//FUNCTION TO GET SELECTED VALUE
    function STDLY_SEARCH_AutoCompleteSelectitemHandler(event, ui) {
        STDLY_SEARCH_flag_autocom=1
        var STDLY_SEARCH_listoption=$('#STDLY_SEARCH_lb_typelist').val();
        $('#STDLY_SEARCH_btn_staffbutton').removeAttr('disabled').show();
    }
});
</script>
</head>
<body>
<div class="container">
<div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
<div class="title text-center"><h4><b>STAFF EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE</b></h4></div>
<form id="staffdlyentry_form" name="staffdlyentry_form" class="form-horizontal content" role="form">
<div class="panel-body">
<fieldset>
<div style="padding-bottom: 15px">
    <div class="radio">
        <label><input type="radio" name="optradio" value="STAFF ENTRY" class="PE_rd_selectform">ENTRY</label>
    </div>
    <div class="radio">
        <label><input type="radio" name="optradio" value="STAFF SEARCH/UPDATE" class="PE_rd_selectform">SEARCH/UPDATE/DELETE</label>
    </div>
</div>
<div id="staffdailyentry">
<div class="form-group" id="staffdly_type">
    <label class="col-sm-3" id="staffdly_lbl_type">TYPE OF EXPENSE</label>
    <div class="col-sm-3"> <select name="staffdly_lb_type" id="staffdly_lb_type" class="form-control staffdly_entryform" ></select></div>
</div>

<div id="agent_comisndiv">
    <div class="form-group" id="staffdly_invdt">
        <label class="col-sm-3">INVOICE DATE <em>*</em></label>
        <div class="col-sm-2">
            <div class="input-group addon">
                <input id="staffdly_invdate" name="staffdly_invdate" type="text" class="date-picker datemandtry submitval form-control" placeholder="Invoice Date"/>
                <label for="staffdly_invdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
            </div>
        </div>
    </div>
    <div class="form-group" id="staffdly_comisnamt">
        <label class="col-sm-3">COMMISSION AMOUNT <em>*</em></label>
        <div class="col-sm-2"><input type="text" name="staffdly_tb_comisnamt" style="width:80px" id="staffdly_tb_comisnamt" placeholder="Amount" class="staffdly_erntryform submitvalamt form-control"/></div>
    </div>
    <div class="form-group" id="staffdly_agentcomments">
        <label class="col-sm-3">COMMENTS</label>
        <div class="col-sm-4"> <textarea  name="staffdly_ta_agentcomments" id="staffdly_ta_agentcomments" placeholder="Comments" maxlength="300" rows="5" class="staffdly_erntryform form-control"></textarea></div>
    </div>
</div>

<div id="salary_entrydiv">
    <div class="form-group" id="staffdly_employee">
        <label class=" col-sm-3">EMPLOYEE NAME <em>*</em></label>
        <div class="col-sm-3"> <select name="staffdly_lb_employee" id="staffdly_lb_employee" class="form-control submitval staffdly_erntryform"></select></div>
    </div>
    <div class="form-group" id="STDLY_INPUT_tble_multipleemployee" hidden>
    </div>
    <div class="form-group" id="staffdly_cpf">
        <label class="col-sm-3">CPF NUMBER</label>
        <div class="col-sm-2"><input type="text" name="staffdly_tb_cpf" id="staffdly_tb_cpf" class="staffdly_erntryform form-control" placeholder="CPF Number" readonly/></div>
    </div>
    <div class="form-group" id="staffdly_paiddt">
        <label class="col-sm-3">PAID DATE <em>*</em></label>
        <div class="col-sm-2">
            <div class="input-group addon">
                <input id="staffdly_paiddate" name="staffdly_paiddate" type="text" class="date-picker datemandtry submitval form-control" placeholder="Paid Date"/>
                <label for="staffdly_paiddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
            </div>
        </div>
    </div>
    <div class="form-group" id="staffdly_fromdt">
        <label class="col-sm-3">FROM PERIOD <em>*</em></label>
        <div class="col-sm-2">
            <div class="input-group addon">
                <input id="staffdly_fromdate" name="staffdly_fromdate" type="text" class="date-picker datemandtry submitval form-control" placeholder="From Period"/>
                <label for="staffdly_fromdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
            </div>
        </div>
    </div>
    <div class="form-group" id="staffdly_todt">
        <label class="col-sm-3">TO PERIOD <em>*</em></label>
        <div class="col-sm-2">
            <div class="input-group addon">
                <input id="staffdly_todate" name="staffdly_todate" type="text" class="date-picker datemandtry submitval form-control" placeholder="To Period"/>
                <label for="staffdly_todate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
            </div>
        </div>
    </div>
    <div class="form-group" id="staffdly_salaryamt">
        <label class="col-sm-3">SALARY AMOUNT <em>*</em></label>
        <div class="col-sm-9">
            <div class="row form-group">
                <div class="col-md-5">
                    <div class="radio">
                        <label><input type="radio" class="radiosubmitval" name="salarysalaryopt" id="staffdly_rd_cursalary">CURRENT SALARY</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control staffdly_erntryform" name="staffdly_tb_cursalary" id="staffdly_tb_cursalary" readonly/>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <div class="radio">
                        <label><input type="radio" class="radiosubmitval" name="salarysalaryopt" id="staffdly_rd_newsalary">NEW SALARY</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control staffdly_erntryform submitval radiotextboxsubmitval amtonlysalary" name="staffdly_tb_newsalary" id="staffdly_tb_newsalary"/>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <div class="radio">
                        <label><input type="radio" class="submitval" name="salarycpfamtopt" id="staffdly_rd_curcpfamt">CURRENT CPF AMOUNT</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control staffdly_erntryform" name="staffdly_tb_curcpfamt" id="staffdly_tb_curcpfamt" readonly/>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <div class="radio">
                        <label><input type="radio" class="radiosubmitval" name="salarycpfamtopt" id="staffdly_rd_newcpfamt">NEW CPF AMOUNT</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control staffdly_erntryform submitval amtonlysalary" name="staffdly_tb_newcpfamt" id="staffdly_tb_newcpfamt"/>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <div class="radio">
                        <label><input type="radio" class="submitval" name="salarylevyamtopt" id="staffdly_rd_curlevyamt">CURRENT LEVY AMOUNT</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control staffdly_erntryform submitval amtonlysalary" name="staffdly_tb_curlevyamt" id="staffdly_tb_curlevyamt" readonly/>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <div class="radio">
                        <label><input type="radio" class="radiosubmitval" name="salarylevyamtopt" id="staffdly_rd_newlevyamt">NEW LEVY AMOUNT</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control staffdly_erntryform submitval amtonlysalary" name="staffdly_tb_newlevyamt" id="staffdly_tb_newlevyamt"/>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group" id="staffdly_salarycomments">
        <label class="col-sm-3">COMMENTS</label>
        <div class="col-sm-4"> <textarea name="staffdly_ta_salarycomments" id="staffdly_ta_salarycomments" placeholder="Comments" maxlength="300" rows="5" class="staffdly_erntryform form-control"></textarea></div>
        <input  type="hidden" id="staffdly_hidden_edssid" name="staffdly_hidden_edssid">
    </div>
</div>
<div class="form-group" id="buttons">
    <div class="col-sm-offset-1 col-sm-3">
        <input class="btn btn-info" type="button" id="STDLY_INPUT_btn_sbutton" name="SAVE" value="SAVE" disabled/>
        <input class="btn btn-info" type="button" id="staffdly_resetbutton" name="RESET" value="RESET"/>
    </div>
</div>
<div id="staffdiv">
    <div class="table-responsive">
        <table id="STDLY_INPUT_tble_multi">
            <tr>
                <td nowrap><label id="staffdly_lbl_expense">CATEGORY OF EXPENSE<em>*</em></label> </td>
                <td style="max-width: 150px" nowrap><label  id="staffdly_lbl_invdate">INVOICE DATE<em>*</em></label></td>
                <td style="max-width: 200px" nowrap><label id="staffdly_lbl_invamt">INVOICE AMOUNT<em>*</em></label> </td>
                <td ><label id="staffdly_lbl_invitm">INVOICE ITEMS<em>*</em></label> </td>
                <td ><label id="staffdly_lbl_invfrom">INVOICE FROM<em>*</em></label> </td>
                <td ><label id="staffdly_lbl_invcmt">COMMENTS</label></td>
            </tr>
            <tr>
                <td><select class="form-control submultivalid" name="STDLY_INPUT_lb_category[]" id="STDLY_INPUT_lb_category1"><option >SELECT</option> </select> </td>
                <td><input class="form-control submultivalid date-picker datemandtry" type="text" name ="STDLY_INPUT_db_invdate[]" id="STDLY_INPUT_db_invdate1" style="max-width:100px;" /> </td>
                <td><input type="text" name ="STDLY_INPUT_lb_incamtrp[]" id="STDLY_INPUT_lb_incamtrp1" class="submultivalid form-control amtonly" style="max-width:80px;"   /></td>
                <td><textarea class="submultivalid form-control" name="STDLY_INPUT_ta_invitem[]" id="STDLY_INPUT_ta_invitem1"></textarea></td>
                <td><input class="submultivalid form-control autosize autocompinc" type="text" name ="STDLY_INPUT_tb_invfrom[]" id="STDLY_INPUT_tb_invfrom1" /></td>
                <td><textarea class="submultivalid form-control" name ="STDLY_INPUT_tb_comments[]" id="STDLY_INPUT_tb_comments1"></textarea></td>
                <td><input enabled type='button'disabled value='+' class='addbttn' alt='Add Row' style="max-height: 30px; max-width:30px;" name ='STDLY_INPUT_btn_addbtn' id='STDLY_INPUT_btn_addbtn1'  disabled/></td>
                <td><input type='button' value='-' class='deletebttn' alt='delete Row' style="max-height: 30px; max-width:30px;" name ='staffdly_btn_delbtn' id='staffdly_btn_delbtn1'/></td>
            </tr>
        </table>
        <table>
            <tr><td><input type="button" id="STDLY_INPUT_btn_staffsbutton" value="SAVE" class="btn btn-info" disabled hidden /></td></tr>
            <tr><td><input type="text" name ="STDLY_INPUT_hideaddid" id="STDLY_INPUT_hideaddid" hidden /> </td></tr>
            <tr><td><input type="text" name ="STDLY_INPUT_hideremoveid" id="STDLY_INPUT_hideremoveid" hidden /> </td></tr>
            <tr><td><input type="text" name ="STDLY_INPUT_hidetablerowid" id="STDLY_INPUT_hidetablerowid" hidden /> </td></tr>
        </table>
    </div>
</div>
<div id="staff_errordiv">
    <div class="col-md-8">
        <label id='staffdly_lbl_erromsg' class="errormsg" hidden></label>
    </div>
    <div class="col-md-8">
        <label id='staffdly_lbl_edtlerromsg' class="errormsg" hidden></label>
    </div>
</div>
 </div>
<div id="agent_searchdiv" hidden>
<div class="form-group">
    <label class=" col-sm-3" id='STDLY_SEARCH_lbl_type'hidden>TYPE OF EXPENSE<em>*</em></label>
    <div class="col-sm-3"> <select name="STDLY_SEARCH_lb_typelist" id="STDLY_SEARCH_lb_typelist" class="form-control"></select></div>
</div>
<div class="form-group">
    <label class=" col-sm-3" id='STDLY_SEARCH_lbl_searchoption' hidden>SEARCH OPTION <em>*</em></label>
    <div class="col-sm-3"> <select name="STDLY_SEARCH_lb_searchoption" id="STDLY_SEARCH_lb_searchoption" class="form-control"></select></div>
</div>
<div class="form-group">
    <label class=" col-sm-3" id='STDLY_SEARCH_lbl_salarysearchoption' hidden>SEARCH OPTION <em>*</em></label>
    <div class="col-sm-3"> <select name="STDLY_SEARCH_lb_salarysearchoption" id="STDLY_SEARCH_lb_salarysearchoption" class="form-control"></select></div>
</div>
<div class="form-group">
    <label class=" col-sm-3" id='STDLY_SEARCH_lbl_staffsearchoption' hidden>SEARCH OPTION <em>*</em></label>
    <div class="col-sm-3"> <select name="STDLY_SEARCH_lb_staffsearchoption" id="STDLY_SEARCH_lb_staffsearchoption" class="form-control"></select></div>
</div>
<div class="srctitle" name="STDLY_SEARCH_lbl_byagentcomments" id="STDLY_SEARCH_lbl_byagentcomments"></div>
<div class="form-group">
    <label  id='STDLY_SEARCH_lbl_startdate' class="col-sm-3" hidden> START DATE <em>*</em></label>
    <div class="col-sm-3">
        <input  type="text" class="datebox submitvalagent STDLY_SEARCH_class_validcomments datemandtry"  name="STDLY_SEARCH_db_startdate" id="STDLY_SEARCH_db_startdate" style="width:80px;" hidden />
    </div>
</div>
<div class="form-group">
    <label id='STDLY_SEARCH_lbl_enddate' class="col-sm-3" hidden> END DATE <em>*</em></label>
    <div class="col-sm-3">
        <input  type="text" class="datebox submitvalagent STDLY_SEARCH_class_validcomments datemandtry" name="STDLY_SEARCH_db_enddate" id="STDLY_SEARCH_db_enddate" style="width:80px;" hidden />
    </div>
</div>
<div class="form-group">
    <label  id='STDLY_SEARCH_lbl_fromamount' class="col-sm-3" hidden> FROM AMOUNT <em>*</em></label>
    <div class="col-sm-3">
        <input  type="text" class="amtvalidation"  name="STDLY_SEARCH_tb_fromamount" id="STDLY_SEARCH_tb_fromamount" style="width:70px;" hidden />
    </div>
</div>
<div class="form-group">
    <label id='STDLY_SEARCH_lbl_toamount' class="col-sm-3" hidden> TO AMOUNT <em>*</em></label>
    <div class="col-sm-3">
        <input  type="text" class="amtvalidation" name="STDLY_SEARCH_tb_toamount" id="STDLY_SEARCH_tb_toamount" style="width:70px;" hidden />
        <label class="errormsg" id='STDLY_SEARCH_lbl_amounterrormsg'  hidden></label>
    </div>
</div>
<div id='STDLY_SEARCH_tble_agenttable'>
    <div class="row form-group">
        <label name="STDTL_INPUT_lbl_comments" id="STDTL_INPUT_lbl_comments" class="col-sm-3">COMMENTS</label>
        <div class="col-sm-3">
            <textarea class="form-control submitvalagent STDLY_SEARCH_class_autocomplete STDLY_SEARCH_ta_cmtItem" name="STDLY_SEARCH_tb_searchcomments" id="STDLY_SEARCH_tb_searchcomments"  >
            </textarea>
            <label id="STDLY_SEARCH_lbl_errmsg" name="STDLY_SEARCH_lbl_errmsg" class="errormsg" disabled=""></label>
        </div>
    </div>
    <div class="form-group">
        <label class=" col-sm-3" id='STDLY_SEARCH_lbl_staffexpansecategory' hidden>STAFF EXPENSE CATEGORY <em>*</em></label>
        <div class="col-sm-3 submitvalagent"> <select name="STDLY_SEARCH_lb_staffexpansecategory" id="STDLY_SEARCH_lb_staffexpansecategory" class="form-control"></select></div>
    </div>
    <div class="row form-group">
        <label name="STDLY_SEARCH_lbl_invfromcomt" id="STDLY_SEARCH_lbl_invfromcomt" class="col-sm-3">INVOICE FROM</label>
        <div class="col-sm-3">
            <textarea class="form-control submitvalagent STDLY_SEARCH_class_autocomplete" name="STDLY_SEARCH_tb_invfromcomt" id="STDLY_SEARCH_tb_invfromcomt" style="width:330px;"hidden  >
            </textarea>
            <label id="STDLY_SEARCH_lbl_errmsg" name="STDLY_SEARCH_lbl_errmsg" class="errormsg" disabled=""></label>
        </div>
    </div>
    <div class="row form-group">
        <label name="STDLY_SEARCH_lbl_invitemcom" id="STDLY_SEARCH_lbl_invitemcom" class="col-sm-3">INVOICE ITEMS </label>
        <div class="col-sm-3">
            <textarea class="form-control submitvalagent STDLY_SEARCH_class_autocomplete STDLY_SEARCH_ta_cmtItem" name="STDLY_SEARCH_tb_invitemcomt" id="STDLY_SEARCH_tb_invitemcomt" hidden  >
            </textarea>
            <label id="STDLY_SEARCH_lbl_errmsg" name="STDLY_SEARCH_lbl_errmsg" class="errormsg" disabled=""></label>
        </div>
    </div>
    <div class="srctitle"  id='STDLY_SEARCH_lbl_bycpfno'  hidden > SEARCH BY CPF NUMBER</div>
    <div class="form-group">
        <label class=" col-sm-3" id='STDLY_SEARCH_lbl_searchbycpfno' hidden>SEARCH BY CPF NUMBER<em>*</em></label>
        <div class="col-sm-3 submitvalagent "> <select name="STDLY_SEARCH_lb_searchbycpfno" id="STDLY_SEARCH_lb_searchbycpfno" ></select></div>
    </div>
    <div class="srctitle"  id='STDLY_SEARCH_lbl_byemployeename'  hidden > SEARCH BY CPF NUMBER</div>
    <div class="form-group">
        <label class=" col-sm-3" id='STDLY_SEARCH_lbl_searchbyemployeename' hidden>SEARCH BY EMPLOYEE NAME<em>*</em></label>
        <div class="col-sm-3 submitvalagent "> <select name="STDLY_SEARCH_lb_searchbyemployeename" id="STDLY_SEARCH_lb_searchbyemployeename" ></select></div>
    </div>
</div>
<div class="col-lg-offset-3">
    <input type="button"   id="STDLY_SEARCH_btn_agentsbutton" disabled  value="SEARCH" class="btn" hidden />
    <input type="button"   id="STDLY_SEARCH_btn_salarybutton" disabled  value="SEARCH" class="btn" hidden />
    <input type="button"   id="STDLY_SEARCH_btn_staffbutton" disabled  value="SEARCH" class="btn" hidden />
</div>
<div class="srctitle" name="ET_SRC_UPD_DEL_div_header" id="ET_SRC_UPD_DEL_div_header"></div><br>
<div class="errormsg" name="ET_SRC_UPD_DEL_div_headernodata" id="ET_SRC_UPD_DEL_div_headernodata"></div>
<div class="table-responsive" id="STDLY_SEARCH_div_htmltable" hidden>
    <section>
    </section>
</div>
<div class="srctitle" name="STDLY_SEARCH_lbl_salaryheadermesg" id="STDLY_SEARCH_lbl_salaryheadermesg"></div><br>
<div class="table-responsive" id="STDLY_SEARCH_div_salaryhtmltable" hidden>
    <section id="STDLY_SEARCH_sec_salryentry">
    </section>
</div><br>
<!--CREATE ELEMENT FOR SELARY ENTRY PART UPDATE FORM-->
<div id="STDLY_SEARCH_tbl_salaryupdatetable">
    <div class="form-group"><label id='STDLY_SEARCH_lbl_name'  class="col-sm-3"hidden> EMPLOYEE NAME </label><em id="STDLY_SEARCH_lbl_emp">*</em>
        <div class="col-sm-2"><input type="text" name="STDLY_SEARCH_lb_namelist" id="STDLY_SEARCH_lb_namelist"  hidden class="rdonly" readonly/>
        </div>
    </div>
    <div class="form-group"><label id='STDLY_SEARCH_lbl_cpf'  class="col-sm-3" hidden> CPF NUMBER </label>
        <div class="col-sm-2"><input type="text" name="STDLY_SEARCH_tb_cpfno" id="STDLY_SEARCH_tb_cpfno" style="width:75px;" hidden class="rdonly" readonly/>
        </div>
    </div>
    <div class="form-group">
        <label id='STDLY_SEARCH_lbl_paid'  class="col-sm-3"  hidden > PAID DATE <em>*</em></label>
        <div class="col-sm-2"><input  type="text"  class="submitval datemandtry" name="STDLY_SEARCH_db_paiddate" id="STDLY_SEARCH_db_paiddate" style="width:75px;" hidden />
        </div>
    </div>
    <div class="form-group">
        <label  id='STDLY_SEARCH_lbl_from'  class="col-sm-3" hidden> FROM PERIOD <em>*</em></label>
        <div class="col-sm-2"><input  type="text"class="submitval datemandtry" name="STDLY_SEARCH_db_fromdate" id="STDLY_SEARCH_db_fromdate" style="width:75px;" hidden />
        </div>
    </div>
    <div class="form-group"><label id='STDLY_SEARCH_lbl_to'  class="col-sm-3" hidden> TO PERIOD <em>*</em></label></td>
        <div class="col-sm-2"><input  type="text" class="submitval datemandtry" name="STDLY_SEARCH_db_todate" id="STDLY_SEARCH_db_todate" style="width:75px;" hidden />
        </div>
    </div>
    <div class="form-group">
        <label name="STDLY_SEARCH_lbl_currentsalary" id="STDLY_SEARCH_lbl_currentsalary" hidden class="col-sm-2">SALARY AMOUNT
        </label>
    </div>
    <div class="form-group row">
        <div class="radio">
            <label class="col-sm-2" name="STDLY_SEARCH_lbl_cursal" id="STDLY_SEARCH_lbl_cursal" style="white-space: nowrap!important;" hidden>
                &nbsp;&nbsp;&nbsp;&nbsp;<input  type='radio' class="radiosubmitval" name='STDLY_SEARCH_radio_slramt' id='STDLY_SEARCH_radio_currentslr' value='current' hidden>
                CURRENT SALARY
            </label>
            <div class="col-sm-2"><input  type="text" name="STDLY_SEARCH_tb_hidesal" id="STDLY_SEARCH_tb_hidesal" style="width:60px;" hidden class="rdonly"  readonly />
            </div>
            <div class="col-sm-2"><input  type="text" name="STDLY_SEARCH_tb_gethiddenesal" id="STDLY_SEARCH_tb_gethiddenesal" style="width:75px;" hidden />
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="radio">
            <label class="col-sm-2" name="STDLY_SEARCH_lbl_newsal" id="STDLY_SEARCH_lbl_newsal" style="white-space: nowrap!important;" hidden>
                &nbsp;&nbsp;&nbsp;&nbsp;<input  type='radio' class="radiosubmitval" name='STDLY_SEARCH_radio_slramt' id='STDLY_SEARCH_radio_newslr' value='new' hidden>
                NEW SALARY
            </label>
            <div class="col-sm-2"><input  type="text" name="STDLY_SEARCH_tb_hidesal1" id="STDLY_SEARCH_tb_hidesal1" style="width:60px;" class="amtonly radiotextboxsubmitval"  hidden />
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="radio">
            <label class="col-sm-2" name="STDLY_SEARCH_lbl_cpamt" id="STDLY_SEARCH_lbl_cpamt" style="white-space: nowrap!important;" hidden>
                &nbsp;&nbsp;&nbsp;&nbsp;<input  type='radio' class="submitval" name='STDLY_SEARCH_radio_cpfamt' id='STDLY_SEARCH_radio_currentcpfamt' value='current' hidden>
                CURRENT CPF AMOUNT
            </label>
            <div class="col-sm-2"><input  type="text" name="STDLY_SEARCH_tb_hidecpf" id="STDLY_SEARCH_tb_hidecpf" style="width:60px;" hidden class="rdonly"  readonly />
            </div>
            <div class="col-sm-2"><input  type="text" name="STDLY_SEARCH_tb_gethiddenecpf" id="STDLY_SEARCH_tb_gethiddenecpf" style="width:75px;" hidden />
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="radio">
            <label class="col-sm-2" name="STDLY_SEARCH_lbl_newcamt" id="STDLY_SEARCH_lbl_newcamt" style="white-space: nowrap!important;" hidden>
                &nbsp;&nbsp;&nbsp;&nbsp;<input  type='radio' class="submitval" name='STDLY_SEARCH_radio_cpfamt' id='STDLY_SEARCH_radio_newcpfamt' value='new' hidden>
                NEW CPF AMOUNT
            </label>
            <div class="col-sm-2"><input  type="text" name="STDLY_SEARCH_tb_hidecpf1" id="STDLY_SEARCH_tb_hidecpf1" style="width:60px;" class="amtonly submitval"  hidden />
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="radio">
            <label class="col-sm-2" name="STDLY_SEARCH_lbl_curlamt" id="STDLY_SEARCH_lbl_curlamt" style="white-space: nowrap!important;" hidden>
                &nbsp;&nbsp;&nbsp;&nbsp;<input  type='radio' class="submitval" name='STDLY_SEARCH_radio_levyamt' id='STDLY_SEARCH_radio_currentlevyamt' value='current' hidden>
                CURRENT LEVY AMOUNT
            </label>
            <div class="col-sm-2"><input  type="text" name="STDLY_SEARCH_tb_hidelevy" id="STDLY_SEARCH_tb_hidelevy" style="width:60px;" hidden class="rdonly"  readonly />
            </div>
            <div class="col-sm-2"><input  type="text" name="STDLY_SEARCH_tb_gethiddenelevy" id="STDLY_SEARCH_tb_gethiddenelevy" style="width:75px;"   hidden />
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="radio">
            <label class="col-sm-2" name="STDLY_SEARCH_lbl_newlamt" id="STDLY_SEARCH_lbl_newlamt" style="white-space: nowrap!important;" hidden>
                &nbsp;&nbsp;&nbsp;&nbsp;<input  type='radio' class="submitval" name='STDLY_SEARCH_radio_levyamt' id='STDLY_SEARCH_radio_newlevyamt' value='new' hidden>
                NEW LEVY AMOUNT
            </label>
            <div class="col-sm-2"><input  type="text" name="STDLY_SEARCH_tb_hidelevy1" id="STDLY_SEARCH_tb_hidelevy1"style="width:60px;" class="amtonly submitval"  hidden />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label id='STDLY_SEARCH_lbl_salarycomments'  class="col-sm-3" hidden > COMMENTS</label>
        <div class="col-sm-4">
            <textarea type="text" name="STDLY_SEARCH_ta_salarycommentsbox" id="STDLY_SEARCH_ta_salarycommentsbox" class="submitval STDLY_SEARCH_ta_cmtItem"  hidden ></textarea>
        </div>
    </div>
    <div class="col-sm-offset-1 col-sm-3">
        <input class="btn btn-info" type="button" id="STDLY_SEARCH_btn_sbutton" name="UPDATE" value="UPDATE" />
        <input class="btn btn-info resetsubmit" type="button" id="STDLY_SEARCH_btn_rbutton" name="RESET"   value="RESET"/>
    </div>
</div>
</div>
</fieldset>
</div>
</form>
</div>
</body>
</html>
