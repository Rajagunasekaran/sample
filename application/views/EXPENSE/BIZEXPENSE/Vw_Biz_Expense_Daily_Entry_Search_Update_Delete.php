<!--*********************************BIZ EXPENSE DAILY ENTRY SEARCH/UPDATE/DELETE********************************************//
//DONE BY:SASIKALA
//VER 0.03 -SD:05/06/2015 ED:05/06/2015 GETTING HEADER FILE FROM LIB
//VER 0.02 SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names
//VER 0.01-SD:08/05/2015 ED:21/05/2015,INITIAL VERSION
//*******************************************************************************************************//-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<style>
    td, th {
        padding: 7px;
    }
    textarea{
        resize: none;
        overflow: hidden;
    }
    .glyphicon-remove,.glyphicon-trash{
        color:red;
    }
    .auto{
        width:100% !important;
    }
    .calendar-off table.ui-datepicker-calendar {
        display:none !important;
    }
</style>

<script>
    //ERROR MESSAGE CODES
    var BDLY_SRC_errormessagecodes={126:[115,109],125:[119,113,406],124:[220,221,404],131:[115,109],191:[18,22,407,8,10],197:[312,313],
        132:[116,110,45],127:[226,227,405],128:[119,113,406],129:[123,122],130:[125,124],151:[184,186,408],
        152:[116,110,45],153:[119,113,406],154:[182,183,409],155:[123,122],156:[115,109],157:[180,181,410],
        158:[125,124],159:[119,113,406],162:[123,122],164:[115,109],165:[179,181,410],166:[125,124],
        160:[144,148,45],161:[144,148,45],163:[144,148,45],185:[119,113,406],186:[114,108,411],188:[115,109],
        187:[116,110,45],189:[117,111,406],190:[118,112,406],178:[185,186,408],179:[119,113,406],180:[123,122],184:[125,124],181:[116,110,45],
        182:[115,109],183:[178,181,410],175:[119,113,406,8,10],177:[115,109,0,8,10],174:[51,50,412,8,10],
        176:[116,110,45,8,10],137:[144,148,45],138:[144,148,45],
        136:[115,109],140:[119,113,406],139:[117,111,406],
        171:[119,113,406],173:[115,109],172:[144,148,45],
        146:[119,113,406],147:[415,134],148:[144,148,45],149:[130,134],150:[18,22,407,8,10],198:[414,7,9],
        167:[119,113,406],170:[115,109],168:[144,148,45],169:[144,148,45],
        141:[419,424,422,245,246,445],142:[421,425,422,245,246,445],143:[418,423,406,245,246,445],145:[416,417,0,245,246,445],144:[420,134,0,245,246,445]
    };
    //DECLARATION OF GLOBAL VARIABLES
    var BDLY_SRC_sucsval=0;
    var CurrentElem='null',
        BDLY_SRC_CurrentTR=null,
        Unit_Exp_Category=null,
        BDLY_SRC_DeleteKey=null,
        startdate=null,enddate=null,
        Unit_Exp_Cusname_global=null,
        unit_start_end_date_obj=null,
        BDLY_DT_currentunit=null,
        BDLY_DT_unitno_toload_name=null,
        BDLY_DT_row_new_vals=null,
        BDLY_DT_row_old_vals=null,
        BDLY_SRC_unit_custname=null,
        BDLY_SCR_DT_currentfield_access_card=null,
        BDLY_SCR_DT_currentfield_hkp_unitno=null,BDLY_SCR_monthBefore=null,BDLY_SCR_yearBefore=null,
        ErrorControl ={AmountCompare:'InValid'},
        BDLY_SRC_unitcategoryvalue=[],
        BDLY_SRC_HKunitnovalues=[],
        BDLY_SRC_errormsglist=[],
        BDLY_SRC_arr_chkexp=[],
        BDLY_SRC_errormessagewitdata,
        BDLY_SRC_errormessagenodata,
        BDLY_SRC_finalerrr=[],
        BDLY_SRC_finalerrrcodes,
        BDLY_SRC_btn_dbvalues=true,
        BDLY_SRC_purchasecard=1,
        BDLY_SRC_unitenddate=null,
        BDLY_SRC_unitstartdate=null,
        BDLY_SRC_unitinvdate=null,
        BDLY_DT_flg_date=1,
        BDLY_SRC_confirmmessages=[],
        BDLY_SRC_arr_unitcmts=[];
    var BDLY_SRC_flag_autocom='';

    $(document).ready(function(){
        $('.preloader').hide();
        $('#spacewidth').height('0%');
        $('#BDLY_INPUT_lb_unitno').hide();
        $('#typeofexpense').hide();
        $('#BDLY_INPUT_lb_selectexptype').hide();
        $('#BDLY_btn_pdf').hide();
        $('textarea').autogrow({onInitialize: true});
//VALIDATION USED IN THE FORMS//
        $('.includeminusfour').doValidation({rule:'numbersonly',prop:{integer:true,realpart:4,imaginary:2}});
        $('.includeminus').doValidation({rule:'numbersonly',prop:{integer:true,realpart:3,imaginary:2}});
        $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        $("#BDLY_INPUT_tb_petty_cashin,#BDLY_INPUT_tb_petty_cashout").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
        $(".amtonlyfivedigit").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $(".thramtonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
        $(".numonly").doValidation({rule:'numbersonly',prop:{realpart:5}});
        $(".hrnumonly").doValidation({rule:'numbersonly',prop:{realpart:2}});
        $('#BDLY_INPUT_btn_multisubmitbutton').hide();
        $('#BDLY_INPUT_btn_submitbutton').hide();
        $('#BDLY_INPUT_btn_resetbutton').hide();
        var BDLY_INPUT_tableerrmsgarr=[];
        var BDLY_INPUT_access_flag='';
        var BDLY_INPUT_access_flag1=1;
        var BDLY_INPUT_petty_date;
        var BDLY_INPUT_id_no;
        var BDLY_INPUT_arraylength;
        var BDLY_INPUT_uexp_id_no;
        var BDLY_INPUT_star_id_no;
        var BDLY_INPUT_unitno=[];
        var BDLY_INPUT_customername_array=[];
        var BDLY_INPUT_exptype_array=[];
        var BDLY_INPUT_unitenddate;
        var BDLY_INPUT_unitstartdate;
        var BDLY_INPUT_unitinvdate;
        var BDLY_INPUT_load_allunitnovalues;
        var BDLY_INPUT_unitno_options ='';
        var BDLY_INPUT_arr_autocmp='';
        var controller_url="<?php echo base_url(); ?>" + '/index.php/EXPENSE/BIZEXPENSE/Ctrl_Biz_Expense_Daily_Entry_Search_Update_Delete/' ;
        $(".datepickdate").datepicker({dateFormat:'dd-mm-yy',changeYear: true,changeMonth: true,beforeShow:function(input, inst){
            $(inst.dpDiv).removeClass('calendar-off');
        }});
        $(".datepickdate").datepicker("option","maxDate",new Date());
        //RADIO BUTTON CLICK FUNCTION
        var initial_values=[];
        $('.BE_rd_selectform').click(function(){
            $('#BDLY_SRC_lb_ExpenseList').html('');
            var bizdailyradiooption=$(this).val();
            if(bizdailyradiooption=='bizentryform')
            {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"initialvalues",
                    data:{"ErrorList":'2,8,9,10,105,169,204,205,206,207,208,242,245,246,247,248,250,256,258,400'},
                    success: function(res) {
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        initial_values=JSON.parse(res);
                        BDLY_INPUT_load_initialvalue(initial_values)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
                $('#biz_expenseentryform').show();
                $('#updateform').hide();
                $('#BDLY_INPUT_lb_selectexptype').val('SELECT').show();
                $('#typeofexpense').hide();
                $('#BDLY_INPUT_tble_aircon').hide();
                $('#BDLY_INPUT_tble_cardpark').hide();
                $('#BDLY_INPUT_tble_digitalvoice').hide();
                $('#BDLY_INPUT_tble_facility').hide();
                $('#BDLY_INPUT_tble_moving').hide();
                $('#BDLY_INPUT_tble_purchase').hide();
                $('#BDLY_INPUT_tble_pettycash').hide();
                $('#BDLY_INPUT_tble_housekeeping').hide();
                $('#BDLY_INPUT_tble_housepayment').hide();
                $('#BDLY_INPUT_tble_electricity').hide();
                $('#BDLY_INPUT_tble_unitexpense').hide();
                $('#BDLY_INPUT_tble_starhub').hide();
                $('#BDLY_INPUT_btn_submitbutton').hide();
                $('#BDLY_INPUT_btn_multisubmitbutton').hide();
                $('#BDLY_INPUT_btn_resetbutton').hide();

            }
            if(bizdailyradiooption=='bizsearchform')
            {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_SRC_getInitialvalue",
                    success: function(res) {
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        var initialvalue=JSON.parse(res);
                        BDLY_SRC_result_getInitialvalue(initialvalue)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
                $('#biz_expenseentryform').hide();
                $('#updateform').show();
                $('#BDLY_SRC_lb_ExpenseList').val('SELECT').show();
                $('#BDLY_SRC_tble_maintable').show();
                $('#BDLY_SRC_dynamicarea').html('');
                $("#BDLY_SRC_tr_serachopt").hide();
                $('#BDLY_SRC_btn_search').hide();
                $('#BDLY_btn_pdf').hide();
                $('#BDLY_SRC_tb_DataTableId').hide();
                $('#BDLY_SRC_div_searchresult').html('');
                $('#BDLY_SRC_Optionhead').text('');
                $('#BDLY_SRC_div_searchresult_head').html('');
                $('#BDLY_SRC_nodyndataerr').html('');
            }
        });
        /*------------------------------------------------CHANGE FUNCTION FOR AMOUNT VALIDATION------------------------------------------*/
        $(document).on("change",'.amtentry', function (){
            var id=$(this).attr('id');
            var BDLY_INPUT_amtid =id.replace(/^\D+/g,'');
            var BDLY_INPUT_paymentval=$('#BDLY_INPUT_lb_elect_payment'+BDLY_INPUT_amtid).val();
            $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_amtid).doValidation({rule:'numbersonly',prop:{integer:true,realpart:3,imaginary:2}});
            $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_amtid).doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
            if(BDLY_INPUT_paymentval==134||BDLY_INPUT_paymentval==133)
            {
                $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_amtid).val('').show();
                $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_amtid).hide();
            }
            else
            {
                $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_amtid).hide();
                $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_amtid).val('').show();
            }});
        /*------------------------------------------------CHANGE FUNCTION FOR AMOUNT VALIDATION------------------------------------------*/
        $(document).on("change blur",'.BDLY_INPUT_listboxclass_submitvalidate', function (){
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val();
            if(BDLY_INPUT_type==9){
                if($('#BDLY_INPUT_tb_air_date').val()!=''){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }}
            if(BDLY_INPUT_type==5){
                if(($('#BDLY_INPUT_lb_digi_invoiceto').val()!='SELECT')&&($('#BDLY_INPUT_tb_digi_voiceno').val()!='')&&($('#BDLY_INPUT_tb_digi_accno').val()!='')&&($('#BDLY_INPUT_tb_digi_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_digi_fromdate').val()!='')&&($('#BDLY_INPUT_tb_digi_todate').val()!='')&&($('#BDLY_INPUT_tb_digi_invoiceamt').val()!='')&&(parseInt($('#BDLY_INPUT_tb_digi_invoiceamt').val())!=0)){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==8){
                if(($('#BDLY_INPUT_tb_cp_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_cp_fromdate').val()!='')&&($('#BDLY_INPUT_tb_cp_todate').val()!='')&&($('#BDLY_INPUT_tb_cp_invoiceamt').val()!='')){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==6){
                if((BDLY_INPUT_access_flag==1)&&(BDLY_INPUT_access_flag1!=0)&&($('#BDLY_INPUT_tb_access_date').val()!='')&&($('#BDLY_INPUT_tb_access_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_access_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_access_cardno').val()!='')){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==10){//PETTY CASH//
                if(((($('#BDLY_INPUT_tb_petty_cashin').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_petty_cashin').val())!=0))||(($('#BDLY_INPUT_tb_petty_cashout').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_petty_cashout').val())!=0)))&&($('#BDLY_INPUT_ta_petty_invoiceitem').val()!='')&&($('#BDLY_INPUT_tb_petty_date').val()!='')){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==7){
                if(($('#BDLY_INPUT_tb_mov_date').val()!='')&&($('#BDLY_INPUT_tb_mov_invoiceamt').val()!='')&&(parseInt($('#BDLY_INPUT_tb_mov_invoiceamt').val())!=0))
                {
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==4){
                if(($('#BDLY_INPUT_lb_unitno').val()!='SELECT')&&($('#BDLY_INPUT_tb_fac_invoicedate').val()!='')&&((($('#BDLY_INPUT_radio_fac_deposit').is(":checked")==true)&&($('#BDLY_INPUT_tb_fac_depositamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_fac_depositamt').val())!=0))||(($('#BDLY_INPUT_radio_fac_invoiceamt').is(":checked")==true)&&($('#BDLY_INPUT_tb_fac_invoiceamt').val()!='')))){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==12){
                var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
                if(BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
                {
                    if(BDLY_INPUT_unitval.length<4)
                    {
                        $('#BDLY_INPUT_tb_pay_unitnocheck').addClass('invalid');
                        $('#BDLY_INPUT_tb_pay_unitnocheck').val('');
                        $('#BDLY_INPUT_lbl_pay_uniterrmsg').text(BDLY_INPUT_tableerrmsgarr[14].EMC_DATA).show();
                    }
                    else
                    {
                        $('#BDLY_INPUT_tb_pay_unitnocheck').removeClass('invalid');
                        $('#BDLY_INPUT_lbl_pay_uniterrmsg').hide();
                    }
                    if(((BDLY_INPUT_unitval.length==4))&&((($('#BDLY_INPUT_tb_pay_unitnocheck').val()!=undefined)||($('#BDLY_INPUT_tb_pay_unitnocheck').val()!=''))||(($('#BDLY_INPUT_tb_pay_unitno').val()!=undefined)||($('#BDLY_INPUT_tb_pay_unitno').val()!=''&&$('#BDLY_INPUT_tb_pay_unitno').val()!='SELECT')))&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
                var BDLY_INPUT_unitvalno=$('#BDLY_INPUT_tb_pay_unitno').val();
                if(BDLY_INPUT_unitvalno!="SELECT"&&BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!=undefined)
                {
                    if(((BDLY_INPUT_unitvalno.length==4))&&((($('#BDLY_INPUT_tb_pay_unitnocheck').val()!=undefined)||($('#BDLY_INPUT_tb_pay_unitnocheck').val()!=''))||(($('#BDLY_INPUT_tb_pay_unitno').val()!=undefined)||($('#BDLY_INPUT_tb_pay_unitno').val()!=''&&$('#BDLY_INPUT_tb_pay_unitno').val()!='SELECT')))&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
            }
            if(BDLY_INPUT_type==11){
                var BDLY_INPUT_cleanername=$('#BDLY_INPUT_lb_house_cleanername').val();
                var BDLY_INPUT_housekeepingdate=$('#BDLY_INPUT_tb_house_date').val();
                var BDLY_INPUT_housekeepinghours=$('#BDLY_INPUT_tb_house_hours').val();
                var BDLY_INPUT_housekeepingmin=$('#BDLY_INPUT_tb_house_min').val();
                if(BDLY_INPUT_housekeepinghours==""&&BDLY_INPUT_housekeepingmin=="")
                {
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
                else if(BDLY_INPUT_housekeepinghours!=""||BDLY_INPUT_housekeepingmin!="")
                {
                    if((BDLY_INPUT_housekeepinghours>24)||((BDLY_INPUT_housekeepinghours==24)&&(BDLY_INPUT_housekeepingmin<60)&&(parseInt(BDLY_INPUT_housekeepingmin)!=0)&&(BDLY_INPUT_housekeepingmin!='')))
                    {
                        $('#BDLY_INPUT_tb_house_hours').addClass('invalid');
                        $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[11].EMC_DATA);
                        $('#BDLY_INPUT_lbl_hourmsg').show();
                    }
                    else
                    {
                        $('#BDLY_INPUT_tb_house_hours').removeClass('invalid');
                        $('#BDLY_INPUT_lbl_hourmsg').hide();
                    }
                    if(BDLY_INPUT_housekeepingmin>=60)
                    {
                        $('#BDLY_INPUT_tb_house_min').addClass('invalid');
                        $('#BDLY_INPUT_lbl_minmsg').text(BDLY_INPUT_tableerrmsgarr[12].EMC_DATA);
                        $('#BDLY_INPUT_lbl_minmsg').show();
                    }
                    else
                    {
                        $('#BDLY_INPUT_tb_house_min').removeClass('invalid');
                        $('#BDLY_INPUT_lbl_minmsg').hide();
                    }
                    if(BDLY_INPUT_housekeepinghours>24&&BDLY_INPUT_housekeepingmin>60)
                    {
                        if(BDLY_INPUT_housekeepinghours>24&&BDLY_INPUT_housekeepingmin>60)
                        {
                            $('#BDLY_INPUT_tb_house_hours').addClass('invalid');
                            $('#BDLY_INPUT_tb_house_min').addClass('invalid');
                            $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[11].EMC_DATA);
                            $('#BDLY_INPUT_lbl_minmsg').text(BDLY_INPUT_tableerrmsgarr[12].EMC_DATA);
                            $('#BDLY_INPUT_lbl_hourmsg').show();
                            $('#BDLY_INPUT_lbl_minmsg').show();
                        }
                        else
                        {
                            $('#BDLY_INPUT_tb_house_min').removeClass('invalid');
                            $('#BDLY_INPUT_lbl_minmsg').hide();
                            $('#BDLY_INPUT_tb_house_hours').removeClass('invalid');
                            $('#BDLY_INPUT_lbl_hourmsg').hide();
                        }
                    }
                }
                if((($('#BDLY_INPUT_tb_house_hours').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_hours').val())!=0)&&(BDLY_INPUT_housekeepinghours<=24)&&((parseInt($('#BDLY_INPUT_tb_house_min').val())==0)||($('#BDLY_INPUT_tb_house_min').val()==''))&&($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&((($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&($('.BDLY_INPUT_class_hkname').attr('id')==undefined))||(($('.BDLY_INPUT_class_hkname').attr('id')!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!=undefined)))&&($('#BDLY_INPUT_tb_house_date').val()!='')&&($('#BDLY_INPUT_ta_house_desc').val()!=''))
                    ||(($('#BDLY_INPUT_tb_house_min').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_min').val())!=0)&&(BDLY_INPUT_housekeepingmin<60)&&((parseInt($('#BDLY_INPUT_tb_house_hours').val())==0)||($('#BDLY_INPUT_tb_house_hours').val()==''))&&($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&((($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&($('.BDLY_INPUT_class_hkname').attr('id')==undefined))||(($('.BDLY_INPUT_class_hkname').attr('id')!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!=undefined)))&&($('#BDLY_INPUT_tb_house_date').val()!='')&&($('#BDLY_INPUT_ta_house_desc').val()!=''))
                    ||(($('#BDLY_INPUT_tb_house_hours').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_hours').val())!=0)&&(BDLY_INPUT_housekeepinghours<24)&&(BDLY_INPUT_housekeepingmin<60)&&($('#BDLY_INPUT_tb_house_min').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_min').val())!=0)&&($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&((($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&($('.BDLY_INPUT_class_hkname').attr('id')==undefined))||(($('.BDLY_INPUT_class_hkname').attr('id')!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!=undefined)))&&($('#BDLY_INPUT_tb_house_date').val()!='')&&($('#BDLY_INPUT_ta_house_desc').val()!=''))){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled');
                }
                else
                {
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
        });
        //LOAD THE INITIAL DATA IN THE LIST BOX//
        var BDLY_INPUT_airconservice=[];
        var BDLY_INPUT_allunittables;
        var BDLY_INPUT_allcarpark=[];
        var BDLY_INPUT_alldetaildigitalvoice=[];
        var BDLY_INPUT_alldetailelsec=[];
        var BDLY_INPUT_allempdetailsarry=[];
        var BDLY_INPUT_allsetailstarhub=[];
        var BDLY_INPUT_allcustentrydtl=[];
        function BDLY_INPUT_load_initialvalue(initial_values)
        {
            BDLY_INPUT_exptype_array=initial_values.BDLY_INPUT_expanse_array;
            var BDLY_INPUT_errmsgarr=initial_values.BDLY_INPUT_tableerrmsgarr;
            $(".BDLY_INPUT_class_numonly").prop("title",BDLY_INPUT_errmsgarr[0].EMC_DATA);
            for(var e=0;e<=BDLY_INPUT_errmsgarr.length-1;e++){
                BDLY_INPUT_tableerrmsgarr[e]=BDLY_INPUT_errmsgarr[e+1];
            }
            BDLY_INPUT_airconservice=initial_values.BDLY_INPUT_detailairconservice;
            BDLY_INPUT_allunittables=initial_values.BDLY_INPUT_unittable;
            BDLY_INPUT_allcarpark=initial_values.BDLY_INPUT_detailcarpark;
            BDLY_INPUT_alldetaildigitalvoice=initial_values.BDLY_INPUT_detaildigitalvoice;
            BDLY_INPUT_alldetailelsec=initial_values.BDLY_INPUT_detailelecticity;
            BDLY_INPUT_allempdetailsarry=initial_values.BDLY_INPUT_empdetailsarry;
            BDLY_INPUT_allsetailstarhub=initial_values.BDLY_INPUT_detailstarhub;
            BDLY_INPUT_allcustentrydtl=initial_values.BDLY_INPUT_customerentrydetails;
            if((initial_values.BDLY_INPUT_unittable.length!=0)&&(initial_values.BDLY_INPUT_customer.length!=0)&&(initial_values.BDLY_INPUT_customerentrydetails.length!=0)&&(initial_values.BDLY_INPUT_detailairconservice.length!=0)&&(initial_values.BDLY_INPUT_detailstarhub.length!=0)&&(initial_values.BDLY_INPUT_detailelecticity.length!=0))
            {
                $('#BDLY_INPUT_form_dailyentry').show();
                $('#BDLY_INPUT_table_errormsg tr').remove().hide();
            }
            else
            {
                if((initial_values.BDLY_INPUT_unittable).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[14].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_customer).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[16].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_customerentrydetails).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[17].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_detailairconservice).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[9].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_detailstarhub).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[5].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_detailelecticity).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[6].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
            }
            var expense_id=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_id;
            var expense_Data=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_date;
            var BDLY_INPUT_exptype_options ='';
            for (var i = 0; i <expense_id.length ; i++) {
                if(i>=0 && i<=11)
                {
                    BDLY_INPUT_exptype_options += '<option value="' + expense_id[i] + '">' + expense_Data[i]+ '</option>';
                }
            }
            $('#BDLY_INPUT_lb_selectexptype').html(BDLY_INPUT_exptype_options)
            $('#BDLY_INPUT_lb_selectexptype').show();
            $('#BDLY_INPUT_lb_selectexptype').focus();
            $('#BDLY_INPUT_lbl_exptype').show();
            BDLY_INPUT_Sortit('BDLY_INPUT_lb_selectexptype');
            $('.preloader').hide();
        }
        function BDLY_INPUT_Sortit(lbid) {
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
        $("#BDLY_INPUT_tb_pay_unitnocheck").blur(function()
        {
            $('#BDLY_INPUT_lbl_checkcardno').val("");
            BDLY_INPUT_checkunitno();
        });
        //DATE PICKER VALIDATION FOR INDEPENDENT UNIT
        $(".datepickperiod").datepicker({dateFormat:'MM-yy', changeYear: true, changeMonth: true,maxDate:new Date(),
            onClose: function(dateText, inst) {
                var month =inst.selectedMonth;
                var year = inst.selectedYear;
                $(this).datepicker('setDate', new Date(year, month, 1));
                $(this).blur();
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).addClass('calendar-off');
            }});
        $('.BDLY_INPUT_class_forperiod').datepicker( {changeMonth: true,  changeYear: true,  showButtonPanel: true,  dateFormat: 'MM-yy',
            maxDate:new Date(),onClose: function(dateText, inst) {
                var month =inst.selectedMonth;
                var year = inst.selectedYear;
                $(this).datepicker('setDate', new Date(year, month, 1));
                $(this).blur();
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).addClass('calendar-off');
            }
        });
        $(".BDLY_INPUT_class_forperiod").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({ my: "left top", at: "left bottom", of: $(this)});});
        var checkunit;
        //CHECK THE UNITNO VALIDATION//
        function BDLY_INPUT_checkunitno()
        {
            var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
            var BDLY_INPUT_unitvalold=$('#BDLY_INPUT_tb_pay_unitno').val();
            if(BDLY_INPUT_unitvalold==undefined)
            {
                if(BDLY_INPUT_unitval.length==4)
                {
                    $('.preloader').show();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_INPUT_checkexistunit",
                        data:{"BDLY_INPUT_unitval":BDLY_INPUT_unitval},
                        success: function(res) {
                            $('.preloader').hide();
                            checkunit=res;
                            BDLY_INPUT_checkunitnoexist(checkunit)
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
            }
            else
            {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_INPUT_save_values",
                    data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                    success: function(res) {
                        $('.preloader').hide();
                        var responsearray=JSON.parse(res);
                        BDLY_INPUT_clearalldatas(responsearray)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        }
        function BDLY_INPUT_checkunitnoexist(checkunit)
        {
            var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
            if(checkunit==1)
            {
                $(".preloader").hide();
                $('#BDLY_INPUT_tb_pay_unitnocheck').addClass('invalid');
                $('#BDLY_INPUT_lbl_pay_uniterrmsg').text(BDLY_INPUT_tableerrmsgarr[1].EMC_DATA).show();
                $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
            }
            if(checkunit==0)
            {
                $(".preloader").hide();
                if(BDLY_INPUT_unitval!='')
                {
                    if(BDLY_INPUT_unitval.length<4)
                    {$(".preloader").hide();
                        $('#BDLY_INPUT_tb_pay_unitnocheck').addClass('invalid');
                        $('#BDLY_INPUT_lbl_pay_uniterrmsg').text(BDLY_INPUT_tableerrmsgarr[14].EMC_DATA).show();
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                    else
                    {
                        $('#BDLY_INPUT_tb_pay_unitnocheck').removeClass('invalid');
                        if($("#BDLY_INPUT_lbl_checkcardno").val()=="")
                        {
                            $('#BDLY_INPUT_lbl_pay_uniterrmsg').hide();
                        }
                        else
                        {
                            $(".preloader").show();
                            $.ajax({
                                type: "POST",
                                url: controller_url+"BDLY_INPUT_save_values",
                                data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                                success: function(res) {
                                    $('.preloader').hide();
                                    var responsearray=JSON.parse(res);
                                    BDLY_INPUT_clearalldatas(responsearray)

                                },
                                error: function (data) {
                                    alert('error in getting' + JSON.stringify(data));
                                }
                            });
                        }
                    }
                }
            }
            var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
            if(BDLY_INPUT_unitval==''||BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
            {
                if(BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
                {
                    if((BDLY_INPUT_unitval.length==4)&&($('#BDLY_INPUT_tb_pay_unitnocheck').val()!='')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            var BDLY_INPUT_unitvalno=$('#BDLY_INPUT_tb_pay_unitno').val();
            if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!=undefined)
            {
                if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!="SELECT"&&BDLY_INPUT_unitvalno!=undefined)
                {
                    if((BDLY_INPUT_unitvalno.length==4)&&($('#BDLY_INPUT_tb_pay_unitno').val()!=''&&$('#BDLY_INPUT_tb_pay_unitno').val()!='SELECT')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
        }
        //  /SELECT THE EXPENSE//
        var BDLY_INPUT_unitno_result_auto=[];
        $(document).on('change','#BDLY_INPUT_lb_selectexptype',function() {
            BDLY_INPUT_clearalldates();
            $('textarea').height(116);
            $('#BDLY_INPUT_tble_electricity').hide();
            $('#BDLY_INPUT_tb_access_cardno').removeClass('invalid')
            $('#BDLY_INPUT_tble_starhub').hide();
            $('#BDLY_INPUT_tble_unitexpense').hide();
            $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
            $('#BDLY_INPUT_lbl_pay_uniterrmsg').hide();
            $('#BDLY_INPUT_tble_housepayment').hide();
            $('#BDLY_INPUT_lbl_hourmsg').hide();
            $('#BDLY_INPUT_lbl_minmsg').hide();
            $('#BDLY_INPUT_tble_aircon').hide();
            $('#BDLY_INPUT_lbl_unitno').hide();
            $('#BDLY_INPUT_lb_unitno').hide();
            $('#typeofexpense').hide();
            $('#BDLY_INPUT_tble_cardpark').hide();
            $('#BDLY_INPUT_tble_digitalvoice').hide();
            $('#BDLY_INPUT_tble_facility').hide();
            $('#BDLY_INPUT_tble_moving').hide();
            $('#BDLY_INPUT_tble_purchase').hide();
            $('#BDLY_INPUT_btn_submitbutton').hide();
            $('#BDLY_INPUT_btn_resetbutton').hide();
            $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
            $('#BDLY_INPUT_tble_pettycash').hide();
            $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled');
            $('#BDLY_INPUT_btn_multisubmitbutton').hide();
            $('#BDLY_INPUT_lb_elect_unit-1').prop('selectedIndex',0)
            $('#BDLY_INPUT_db_invoicedate1').val("").hide();
            $('#BDLY_INPUT_db_fromperiod1').val('').hide();
            $('#BDLY_INPUT_db_toperiod1').val('').hide();
            $('#BDLY_INPUT_lb_elect_payment1').prop('selectedIndex',0).hide()
            $('#BDLY_INPUT_tb_elect_amount1').val('').hide();
            $('#BDLY_INPUT_tb_elect_minusamt1').val('').hide();
            $('#BDLY_INPUT_ta_comments1').hide()
            $('#BDLY_INPUT_tb_invoiceto1').val('').hide();
            $('#BDLY_INPUT_tble_electricity').hide();
            var BDLY_INPUT_flag_notsave=[];
            BDLY_INPUT_flag_notsave[0]='BDLY_INPUT_flag_notsave'
            BDLY_INPUT_clear_electricity(BDLY_INPUT_flag_notsave);
            BDLY_INPUT_clear_unitExpanse(BDLY_INPUT_flag_notsave);
            BDLY_INPUT_clear_starhub(BDLY_INPUT_flag_notsave);
            $('#BDLY_INPUT_db_star_invoicedate1').val('').hide()
            $('#BDLY_INPUT_tb_star_amount1').val("").hide()
            $('#BDLY_INPUT_db_star_toperiod1').val('').hide();
            $('#BDLY_INPUT_db_star_fromperiod1').val('').hide();
            $('#BDLY_INPUT_star_add1').attr("disabled", "disabled").show();
            $('#BDLY_INPUT_star_del1').attr("disabled", "disabled").show();
            $('#BDLY_INPUT_lb_star_unit-1').prop('selectedIndex',0);
            $('#BDLY_INPUT_btn_multisubmitbutton').attr('disabled','disabled')
            $('#BDLY_INPUT_lb_star_invoice-1').hide();
            $('#BDLY_INPUT_tb_star_accno1').hide();
            $('#BDLY_INPUT_tble_unitexpense').hide();
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
            if(BDLY_INPUT_type=="SELECT"){
                $('#BDLY_INPUT_tble_aircon').hide();
                $('#BDLY_INPUT_lbl_unitno').hide();
                $('#BDLY_INPUT_lb_unitno').hide();
                $('#typeofexpense').hide();
                $('#BDLY_INPUT_tble_cardpark').hide();
                $('#BDLY_INPUT_tble_digitalvoice').hide();
                $('#BDLY_INPUT_tble_facility').hide();
                $('#BDLY_INPUT_tble_moving').hide();
                $('#BDLY_INPUT_tble_purchase').hide();
                $('#BDLY_INPUT_btn_submitbutton').hide();
                $('#BDLY_INPUT_btn_resetbutton').hide();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
                $('#BDLY_INPUT_tble_pettycash').hide();
                $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled');
                $('#BDLY_INPUT_btn_multisubmitbutton').hide();
                $('#BDLY_INPUT_tble_electricity').hide();
                $('#BDLY_INPUT_tble_housekeeping').hide();
                $('#BDLY_INPUT_tble_housepayment').hide();
                $('#BDLY_INPUT_tble_pettycash').hide();
                $('#BDLY_INPUT_lbl_checkcardno').hide();
                $('#BDLY_INPUT_lbl_hourmsg').hide();
            }
            if(BDLY_INPUT_type!="SELECT"){
                $('#BDLY_INPUT_btn_submitbutton').hide();
                $(".preloader").show();
                if(BDLY_INPUT_allunittables.length==0)
                {
                    $(".preloader").hide();
                    $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[14].EMC_DATA);
                    $('#BDLY_INPUT_lbl_hourmsg').show();
                }else
                if(BDLY_INPUT_type==9 ||BDLY_INPUT_type==8||BDLY_INPUT_type==5||BDLY_INPUT_type==4||BDLY_INPUT_type==7||BDLY_INPUT_type==6||BDLY_INPUT_type==1||BDLY_INPUT_type==3||BDLY_INPUT_type==2){
                    $('#BDLY_INPUT_tble_housepayment').hide();
                    $('#BDLY_INPUT_tble_housekeeping').hide();
                    $('#BDLY_INPUT_tble_digitalvoice').hide();
                    $('#BDLY_INPUT_btn_submitbutton').hide();
                    if((BDLY_INPUT_type==9)&&(BDLY_INPUT_airconservice.length==0))
                    {
                        $(".preloader").hide();
                        $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[9].EMC_DATA);
                        $('#BDLY_INPUT_lbl_checkcardno').show();
                    }
                    else if((BDLY_INPUT_type==8)&&(BDLY_INPUT_allcarpark.length==0))
                    {
                        $(".preloader").hide();
                        $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[7].EMC_DATA);//
                        $('#BDLY_INPUT_lbl_checkcardno').show();
                    }
                    else if((BDLY_INPUT_type==5)&&(BDLY_INPUT_alldetaildigitalvoice.length==0))
                    {
                        $(".preloader").hide();
                        $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[8].EMC_DATA);//
                        $('#BDLY_INPUT_lbl_checkcardno').show();
                    }
                    else if((BDLY_INPUT_type==1)&&(BDLY_INPUT_alldetailelsec.length==0))
                    {
                        $(".preloader").hide();
                        $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[6].EMC_DATA);
                        $('#BDLY_INPUT_lbl_checkcardno').show();
                    }
                    else if((BDLY_INPUT_type==2)&&(BDLY_INPUT_allsetailstarhub.length==0))
                    {
                        $(".preloader").hide();
                        $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[5].EMC_DATA);
                        $('#BDLY_INPUT_lbl_checkcardno').show();
                    }
                    else if((BDLY_INPUT_type==3)&&(BDLY_INPUT_allcustentrydtl.length==0))
                    {
                        $(".preloader").hide();
                        $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[17].EMC_DATA);
                        $('#BDLY_INPUT_lbl_checkcardno').show();
                    }
                    else
                    {
                        $('#BDLY_INPUT_lbl_checkcardno').hide();
                        $('#BDLY_INPUT_lbl_hourmsg').hide();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_INPUT_get_unitno",
                            data:{"BDLY_INPUT_type":BDLY_INPUT_type},
                            success: function(res) {
                                $('.preloader').hide();
                                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                                BDLY_INPUT_unitno_result_auto=JSON.parse(res);
                                BDLY_INPUT_load_unitno(BDLY_INPUT_unitno_result_auto)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                }
                if(BDLY_INPUT_type==10)
                {
                    $('#BDLY_INPUT_lbl_checkcardno').hide();
                    $('#BDLY_INPUT_lbl_hourmsg').hide();
                    $('#BDLY_INPUT_tble_housekeeping').hide();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_INPUT_get_balance",
                        success: function(res) {
                            $('.preloader').hide();
                            balance_result=JSON.parse(res);
                            BDLY_INPUT_load_balance(balance_result)
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
                if(BDLY_INPUT_type==11){
                    $('#BDLY_INPUT_tble_starhub').hide();
                    $('#BDLY_INPUT_tble_housepayment').hide();
                    if(BDLY_INPUT_allempdetailsarry.length==0)
                    {
                        $(".preloader").hide();
                        $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[10].EMC_DATA);//
                        $('#BDLY_INPUT_lbl_checkcardno').show();
                    }else
                    {
                        $('#BDLY_INPUT_lbl_checkcardno').hide();
                        $('#BDLY_INPUT_lbl_hourmsg').hide();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_INPUT_get_cleanername",
                            success: function(res) {
                                $('.preloader').hide();
                                cleanername=JSON.parse(res);
                                BDLY_INPUT_load_cleanername(cleanername)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                }
                if(BDLY_INPUT_type==12){
                    if(BDLY_INPUT_allunittables.length==0)
                    {
                        $(".preloader").hide();
                        $('#BDLY_INPUT_lbl_checkcardno').hide();
                        $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[14].EMC_DATA);
                        $('#BDLY_INPUT_lbl_hourmsg').show();
                    }else
                    {
                        $('#BDLY_INPUT_lbl_checkcardno').hide();
                        $('#BDLY_INPUT_lbl_hourmsg').hide();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_INPUT_get_allunitno",
                            success: function(res) {
                                $('.preloader').hide();
                                BDLY_INPUT_load_allunitnoval=JSON.parse(res);
                                BDLY_INPUT_load_allunitno(BDLY_INPUT_load_allunitnoval.sort())
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    $('#BDLY_INPUT_tble_housekeeping').hide();
                }
            }
        });
        //FUNCTION TO LOAD UNIT NO//
        function BDLY_INPUT_load_unitno(BDLY_INPUT_unitno_result_auto)
        {
            $(".preloader").hide();
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val();
            BDLY_INPUT_unitno=BDLY_INPUT_unitno_result_auto[0];
            BDLY_INPUT_arr_autocmp=BDLY_INPUT_unitno_result_auto[1];
            var BDLY_INPUT_unitno_result=BDLY_INPUT_unitno_result_auto[0];
            if(BDLY_INPUT_unitno_result.length==0)
            {
            }
            else
            {
                BDLY_INPUT_unitno_options ='<option>SELECT</option>';
                for (var i = 0; i < BDLY_INPUT_unitno_result.length; i++){
                    BDLY_INPUT_unitno_options += '<option value="' + BDLY_INPUT_unitno_result[i] + '">' + BDLY_INPUT_unitno_result [i]+ '</option>';
                }
                if(BDLY_INPUT_type==1){
                    $('#BDLY_INPUT_tble_electricity').show();
                    $('#BDLY_INPUT_lb_elect_unit-1').html(BDLY_INPUT_unitno_options);
                    $('#BDLY_INPUT_tble_electricity').show();
                    $('#BDLY_INPUT_lb_elect_unit-1').show();
                    $('#BDLY_INPUT_add1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_del1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_btn_submitbutton').hide();
                    $('#BDLY_INPUT_btn_multisubmitbutton').show();
                    $('#BDLY_INPUT_ta_comments1').hide();
                }
                else if(BDLY_INPUT_type==3){
                    $('#BDLY_INPUT_tble_unitexpense').show();
                    $('#BDLY_INPUT_lb_uexp_unit-1').html(BDLY_INPUT_unitno_options).show();
                    $('#BDLY_INPUT_add1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_del1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_btn_submitbutton').hide();
                    $('#BDLY_INPUT_btn_multisubmitbutton').show();
                    $('#BDLY_INPUT_ta_uexpcomments1').hide();
                }
                else if(BDLY_INPUT_type==2){
                    $('#BDLY_INPUT_tble_starhub').show();
                    $('#BDLY_INPUT_lb_star_unit-1').html(BDLY_INPUT_unitno_options).show();
                    $('#BDLY_INPUT_tble_starhub').show();
                    $('#BDLY_INPUT_add1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_del1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_btn_submitbutton').hide();
                    $('#BDLY_INPUT_btn_multisubmitbutton').show();
                    $('#BDLY_INPUT_ta_star_comments1').hide();
                }
                else{
                    $('#BDLY_INPUT_lb_unitno').html(BDLY_INPUT_unitno_options).focus();
                    $('#BDLY_INPUT_lbl_unitno').show();
                    $('#BDLY_INPUT_lb_unitno').show();
                    $('#typeofexpense').show();
                    $('#BDLY_INPUT_btn_submitbutton').hide();
                }
                $('#BDLY_INPUT_btn_resetbutton').hide();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            }
        }
        //<!-- DATE PICKER FOR THE DIGITAL VOICE ENTRY -->
        $("#BDLY_INPUT_tb_digi_invoicedate").datepicker({dateFormat: 'dd-mm-yy', changeYear: true, changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_datep = $('#BDLY_INPUT_tb_digi_invoicedate').datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_datep ) );
                date.setDate( date.getDate() );
                var PDLY_INPUT_newDate = date.toDateString();
                PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                $('#BDLY_INPUT_tb_digi_fromdate,#BDLY_INPUT_tb_digi_todate').datepicker("option","maxDate",PDLY_INPUT_newDate);
                var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
                if(BDLY_INPUT_type==5){
                    if(($('#BDLY_INPUT_lb_digi_invoiceto').val()!='SELECT')&&($('#BDLY_INPUT_tb_digi_voiceno').val()!='')&&($('#BDLY_INPUT_tb_digi_accno').val()!='')&&($('#BDLY_INPUT_tb_digi_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_digi_fromdate').val()!='')&&($('#BDLY_INPUT_tb_digi_todate').val()!='')&&($('#BDLY_INPUT_tb_digi_invoiceamt').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
        //DATE PICKER FUNCTION FOR FROM DATE..............
        $("#BDLY_INPUT_tb_digi_fromdate").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_fromdate = $('#BDLY_INPUT_tb_digi_fromdate').datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                date.setDate( date.getDate()  ); //+ 1
                var PDLY_INPUT_newDate = date.toDateString();
                PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                $('#BDLY_INPUT_tb_digi_todate').datepicker("option","minDate",PDLY_INPUT_newDate);
                var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
                if(BDLY_INPUT_type==5){
                    if(($('#BDLY_INPUT_lb_digi_invoiceto').val()!='SELECT')&&($('#BDLY_INPUT_tb_digi_voiceno').val()!='')&&($('#BDLY_INPUT_tb_digi_accno').val()!='')&&($('#BDLY_INPUT_tb_digi_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_digi_fromdate').val()!='')&&($('#BDLY_INPUT_tb_digi_todate').val()!='')&&($('#BDLY_INPUT_tb_digi_invoiceamt').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
        //DATE PICKER FOR TO DATE ..................
        $("#BDLY_INPUT_tb_digi_todate").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_fromdate = $('#BDLY_INPUT_tb_digi_fromdate').datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                date.setDate( date.getDate()  ); //+ 1
                var newDate = date.toDateString();
                newDate = new Date( Date.parse( newDate ) );
                $('#BDLY_INPUT_tb_digi_todate').datepicker("option","minDate",newDate);
                var PDLY_INPUT_paiddate = $('#BDLY_INPUT_tb_digi_invoicedate').datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_paiddate ) );
                date.setDate( date.getDate() ); // - 1
                var PDLY_INPUT_paidnewDate = date.toDateString();
                PDLY_INPUT_paidnewDate = new Date( Date.parse( PDLY_INPUT_paidnewDate ) );
                $('#BDLY_INPUT_tb_digi_todate').datepicker("option","maxDate",PDLY_INPUT_paidnewDate);
                var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
                if(BDLY_INPUT_type==5){
                    if(($('#BDLY_INPUT_lb_digi_invoiceto').val()!='SELECT')&&($('#BDLY_INPUT_tb_digi_voiceno').val()!='')&&($('#BDLY_INPUT_tb_digi_accno').val()!='')&&($('#BDLY_INPUT_tb_digi_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_digi_fromdate').val()!='')&&($('#BDLY_INPUT_tb_digi_todate').val()!='')&&($('#BDLY_INPUT_tb_digi_invoiceamt').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
//CAR PARK DATE PICKER//
        $("#BDLY_INPUT_tb_cp_invoicedate").datepicker({
            dateFormat: "dd-mm-yy",  changeYear: true, changeMonth: true,
            onSelect: function(date){
                var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val();
                if(BDLY_INPUT_type==8){
                    if(($('#BDLY_INPUT_tb_cp_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_cp_fromdate').val()!='')&&($('#BDLY_INPUT_tb_cp_todate').val()!='')&&($('#BDLY_INPUT_tb_cp_invoiceamt').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
//DATE PICKER FUNCTION FOR FROM DATE..............
        $("#BDLY_INPUT_tb_cp_fromdate").datepicker({
            dateFormat: "dd-mm-yy",  changeYear: true, changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_fromdate = $('#BDLY_INPUT_tb_cp_fromdate').datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                date.setDate( date.getDate()  ); //+ 1
                var PDLY_INPUT_newDate = date.toDateString();
                PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                $('#BDLY_INPUT_tb_cp_todate').datepicker("option","minDate",PDLY_INPUT_newDate);
                var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
                if(BDLY_INPUT_type==8){
                    if(($('#BDLY_INPUT_tb_cp_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_cp_fromdate').val()!='')&&($('#BDLY_INPUT_tb_cp_todate').val()!='')&&($('#BDLY_INPUT_tb_cp_invoiceamt').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
        //DATE PICKER FOR TO DATE ..................
        $("#BDLY_INPUT_tb_cp_todate").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_fromdate = $('#BDLY_INPUT_tb_cp_fromdate').datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                date.setDate( date.getDate()  ); //+ 1
                var newDate = date.toDateString();
                newDate = new Date( Date.parse( newDate ) );
                $('#BDLY_INPUT_tb_cp_todate').datepicker("option","minDate",newDate);
                var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
                if(($('#BDLY_INPUT_tb_cp_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_cp_fromdate').val()!='')&&($('#BDLY_INPUT_tb_cp_todate').val()!='')&&($('#BDLY_INPUT_tb_cp_invoiceamt').val()!='')){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
        var balance_result=[];
//FUNCTION TO LOAD PETTY CASH BALANCE//
        function BDLY_INPUT_load_balance(balance_result){
            $(".preloader").hide();
            $('#BDLY_INPUT_tb_petty_balance').val(balance_result[0]);
            BDLY_INPUT_petty_date=balance_result[1];
            var date = new Date( Date.parse( BDLY_INPUT_petty_date ) );
            date.setDate( date.getDate() );
            var BDLY_INPUT_newDate = date.toDateString();
            BDLY_INPUT_newDate = new Date( Date.parse( BDLY_INPUT_newDate ) );
            $('#BDLY_INPUT_tb_petty_date').datepicker("option","minDate",BDLY_INPUT_newDate);
            $('#BDLY_INPUT_tble_pettycash').show();
            $('#BDLY_INPUT_btn_submitbutton').show();
            $('#BDLY_INPUT_btn_resetbutton').show();
            $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
        }
        /*--------------------------FUNCTION TO UNIQUE FOR CUSTOMER NAME---------------------------------------------------*/
        function STDLY_INPUT_unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
        var cleanername=[];
        var BDLY_INPUT_arr_housekeepingname= [];
        //FUNCTION TO LOAD HOUSEKEEPING CLEANER NAME//
        function BDLY_INPUT_load_cleanername(cleanername){
            $(".preloader").hide();
            BDLY_INPUT_arr_housekeepingname=cleanername;
            if(BDLY_INPUT_arr_housekeepingname.length==0)
            {
                $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[4].EMC_DATA).show();
            }
            else
            {
                var BDLY_INPUT_arr_uniquedata=[];
                for (var j = 0; j < BDLY_INPUT_arr_housekeepingname.length; j++) {
                    BDLY_INPUT_arr_uniquedata[j]=BDLY_INPUT_arr_housekeepingname[j].BDLY_INPUT_cleanername;
                }
                BDLY_INPUT_arr_uniquedata=STDLY_INPUT_unique(BDLY_INPUT_arr_uniquedata)
                var BDLY_INPUT_cleanername_options ='<option value="SELECT">SELECT</option>'
                for (var i = 0; i < BDLY_INPUT_arr_uniquedata.length; i++) {
                    BDLY_INPUT_cleanername_options += '<option value="' + BDLY_INPUT_arr_uniquedata[i] + '">' + BDLY_INPUT_arr_uniquedata[i] + '</option>';
                }
                $('#BDLY_INPUT_lb_house_cleanername').html(BDLY_INPUT_cleanername_options);
                $('#BDLY_INPUT_tble_housekeeping').show();
                $('#BDLY_INPUT_btn_submitbutton').show();
                $('#BDLY_INPUT_btn_resetbutton').show();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
            }
        }
        var BDLY_INPUT_load_allunitnoval=[];
        function BDLY_INPUT_load_allunitno(BDLY_INPUT_load_allunitnoval)
        {
            $(".preloader").hide();
            BDLY_INPUT_load_allunitnovalues=BDLY_INPUT_load_allunitnoval;
            if(BDLY_INPUT_load_allunitnovalues.length!=0)
            {
                var BDLY_INPUT_allunitno_options ='<option>SELECT</option>'
                for (var i = 0; i < BDLY_INPUT_load_allunitnovalues.length; i++){
                    BDLY_INPUT_allunitno_options += '<option value="' + BDLY_INPUT_load_allunitnovalues[i] + '">' + BDLY_INPUT_load_allunitnovalues [i]+ '</option>';
                }
                $('#BDLY_INPUT_tb_pay_unitno').html(BDLY_INPUT_allunitno_options);
                $('#BDLY_INPUT_tb_pay_unitno').show();
            }
            else
            {
                $('#BDLY_INPUT_tb_pay_unitno').replaceWith('<input type="text" name="BDLY_INPUT_tb_pay_unitnocheck" id="BDLY_INPUT_tb_pay_unitnocheck" style="width:32px;"  class="BDLY_INPUT_class_submitvalidate " />').show();
                $("#BDLY_INPUT_tb_pay_unitnocheck").doValidation({rule:'numbersonly',prop:{realpart:4,leadzero:true}});
                $("#BDLY_INPUT_btn_addbutton").hide();
                $("#BDLY_INPUT_tb_pay_unitnocheck").blur(function()
                {   $('#BDLY_INPUT_lbl_checkcardno').val("");
                    BDLY_INPUT_checkunitno();
                });
            }
            $('#BDLY_INPUT_lbl_pay_unitno').show();
            $('#BDLY_INPUT_tble_housepayment').show();
            $('#BDLY_INPUT_lbl_pay_invoiceamt').show();
            $('#BDLY_INPUT_tb_pay_invoiceamt').val('').show();
            $('#BDLY_INPUT_lbl_pay_forperiod').show();
            $('#BDLY_INPUT_tb_pay_forperiod').val('').show();
            $('#BDLY_INPUT_lbl_pay_paiddate').show();
            $('#BDLY_INPUT_tb_pay_paiddate').val('').show();
            $('#BDLY_INPUT_ta_pay_comments').val('').show();
            $('#BDLY_INPUT_lbl_pay_comment').show();
            $('#BDLY_INPUT_btn_submitbutton').show();
            $('#BDLY_INPUT_btn_resetbutton').show();
            $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
        }
        // FUNCTION FOR CLEAR ALL DATES
        function BDLY_INPUT_clearalldates()
        {
            $('textarea').height(116);
            $('#BDLY_INPUT_tble_radioclearnername').empty();
            $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
            $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
            var BDLY_INPUT_listvalue= $('#BDLY_INPUT_lb_selectexptype').val();
            if(BDLY_INPUT_listvalue==9)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_tb_air_date').val("");
                $('#BDLY_INPUT_ta_aircon_comments').val("");
            }
            if(BDLY_INPUT_listvalue==8)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_tb_cp_invoicedate').val("");
                $('#BDLY_INPUT_tb_cp_fromdate').val("");
                $('#BDLY_INPUT_tb_cp_todate').val("");
                $('#BDLY_INPUT_tb_cp_invoiceamt').val("");
                $('#BDLY_INPUT_ta_cp_comments').val("");
            }
            if(BDLY_INPUT_listvalue==5)
            {
                $('#BDLY_INPUT_lb_digi_invoiceto').prop('selectedIndex',0);
                $('#BDLY_INPUT_tb_digi_invoicedate').val("");
                $('#BDLY_INPUT_tb_digi_fromdate').val("");
                $('#BDLY_INPUT_tb_digi_todate').val("");
                $('#BDLY_INPUT_tb_digi_invoiceamt').val("");
                $('#BDLY_INPUT_ta_digi_comments').val("");
                BDLY_INPUT_setdatepick();
            }
            if(BDLY_INPUT_listvalue==4)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_tb_fac_invoicedate').val("");
                $('#BDLY_INPUT_radio_fac_deposit').prop('checked',false);
                $('#BDLY_INPUT_radio_fac_invoiceamt').prop('checked',false);
                $('#BDLY_INPUT_tb_fac_depositamt').val("").hide();
                $('#BDLY_INPUT_tb_fac_invoiceamt').val("").hide();
                $('#BDLY_INPUT_ta_fac_comments').val("");
            }
            if(BDLY_INPUT_listvalue==11)
            {
                $('#BDLY_INPUT_ta_house_desc').val("");
                $('#BDLY_INPUT_lb_house_cleanername').prop('selectedIndex',0);
                $('#BDLY_INPUT_tb_house_date').val("");
                $('#BDLY_INPUT_tb_house_hours').val("");
                $('#BDLY_INPUT_tb_house_min').val("");
                $('#BDLY_INPUT_tb_house_hours,#BDLY_INPUT_tb_house_min').removeClass("invalid");
                $('#BDLY_INPUT_lbl_hourmsg,#BDLY_INPUT_lbl_minmsg').text("");
            }
            if(BDLY_INPUT_listvalue==12)
            {
                $('#BDLY_INPUT_tb_pay_unitnocheck').val('');
                $('#BDLY_INPUT_tb_pay_unitnocheck').removeClass('invalid');
                $('#BDLY_INPUT_tb_pay_unitno').val('');
                $('#BDLY_INPUT_lbl_pay_uniterrmsg').text('');
                $('#BDLY_INPUT_tb_pay_unitno').prop('selectedIndex',0);
                $('#BDLY_INPUT_tb_pay_invoiceamt').val('');
                $('#BDLY_INPUT_tb_pay_forperiod').val('');
                $('#BDLY_INPUT_tb_pay_paiddate').val('');
                $('#BDLY_INPUT_ta_pay_comments').val('');
                $('input[name="BDLY_INPUT_radio_hk_oldnewentry"]').prop('checked', false);
            }
            if(BDLY_INPUT_listvalue==7)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_tb_mov_date').val('');
                $('#BDLY_INPUT_tb_mov_invoiceamt').val('');
                $('#BDLY_INPUT_ta_mov_comments').val('');
            }
            if(BDLY_INPUT_listvalue==10)
            {
                $('input[name="BDLY_INPUT_radio_petty"]').prop('checked', false);
                $('#BDLY_INPUT_tb_petty_cashin').val("").hide();
                $('#BDLY_INPUT_tb_petty_cashout').val("").hide();
                $('#BDLY_INPUT_ta_petty_comments').val('');
                $('#BDLY_INPUT_tb_petty_date').val('');
                $('#BDLY_INPUT_ta_petty_invoiceitem').val('');
            }
            if(BDLY_INPUT_listvalue==6)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_ta_access_comments').val('');
                $('#BDLY_INPUT_tb_access_cardno').val('');
                $('#BDLY_INPUT_tb_access_cardno').removeClass('invalid');
                $('#BDLY_INPUT_tb_access_date').val('');
                $('#BDLY_INPUT_tb_access_invoiceamt').val('');
            }
        }
        //FUNCATION FOR SETDATEPICKER
        function BDLY_INPUT_setdatepick()
        {
            var BDLY_INPUT_unit_end_date='';
            var BDLY_INPUT_enddate=new Date(Date.parse(BDLY_INPUT_unitenddate));
            var unitstardate = new Date( Date.parse( BDLY_INPUT_unitstartdate ) );
            var unitinvdate = new Date( Date.parse( BDLY_INPUT_unitinvdate ) );
//VALIDATION FOR EACH EXPENSE
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val();
            if(BDLY_INPUT_type==3){
                $('#BDLY_INPUT_db_uexp_invoicedate'+BDLY_INPUT_uexp_id_no).datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_db_uexp_invoicedate'+BDLY_INPUT_uexp_id_no).datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==6){
                $('#BDLY_INPUT_tb_access_date').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_access_date').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==7){
                $('#BDLY_INPUT_tb_mov_date').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_mov_date').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==9){
                $('#BDLY_INPUT_tb_air_date').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_air_date').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==4){
                $('#BDLY_INPUT_tb_fac_invoicedate').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_fac_invoicedate').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==8){
                $('#BDLY_INPUT_tb_cp_invoicedate').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_cp_fromdate,#BDLY_INPUT_tb_cp_todate').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_cp_invoicedate').datepicker("option","maxDate",unitinvdate);
                $('#BDLY_INPUT_tb_cp_fromdate,#BDLY_INPUT_tb_cp_todate').datepicker("option","maxDate",BDLY_INPUT_enddate);
            }
            if(BDLY_INPUT_type==5){
                $('#BDLY_INPUT_tb_digi_invoicedate,#BDLY_INPUT_tb_digi_fromdate,#BDLY_INPUT_tb_digi_todate').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_digi_invoicedate,#BDLY_INPUT_tb_digi_fromdate,#BDLY_INPUT_tb_digi_todate').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==2){
                BDLY_INPUT_func_starhubperiod();
                $("#BDLY_INPUT_db_star_invoicedate"+BDLY_INPUT_star_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_star_fromperiod"+BDLY_INPUT_star_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_star_toperiod"+BDLY_INPUT_star_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_star_invoicedate"+BDLY_INPUT_star_id_no).datepicker("option","maxDate",unitinvdate);
                $("#BDLY_INPUT_db_star_fromperiod"+BDLY_INPUT_star_id_no).datepicker("option","maxDate",BDLY_INPUT_enddate);
                $("#BDLY_INPUT_db_star_toperiod"+BDLY_INPUT_star_id_no).datepicker("option","maxDate",BDLY_INPUT_enddate);
            }
            if(BDLY_INPUT_type==1){
                $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker("option","maxDate",unitinvdate);
                $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",unitinvdate);
                $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",unitinvdate);
            }
        }
//FUNCTION TO CLEAR ELECTRICITY
        function BDLY_INPUT_clear_electricity(BDLY_INPUT_unit_response){
            $(".preloader").hide();
            $('#BDLY_INPUT_btn_multisubmitbutton').attr('disabled','disabled')
            $('#BDLY_INPUT_tble_electricity').empty();
            $('<tr><td nowrap><label id="BDLY_INPUT_lbl_elect_unit" >UNIT</label><em>*</em> </td><td nowrap><label  id="BDLY_INPUT_lbl_elect_invoiceto" >INVOICE TO</label><em>*</em></td><td nowrap> <label id="BDLY_INPUT_lbl_elect_invoicedate" >INVOICE DATE</label><em>*</em> </td><td nowrap><label id="BDLY_INPUT_lbl_elect_fromperiod" >FROM PERIOD</label><em>*</em> </td><td nowrap><label id="BDLY_INPUT_lbl_elect_toperiod" >TO PERIOD</label><em>*</em></td><td nowrap><label id="BDLY_INPUT_lbl_elect_payment"  >PAYMENT OF</label><em>*</em> </td><td nowrap><label id="BDLY_INPUT_lbl_elect_amount" >AMOUNT</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_elect_comments" >COMMENTS</label> </td><td ><label id="BDLY_INPUT_lbl_elect_add" ></label> </td><td ><label id="BDLY_INPUT_lbl_elect_del" ></label> </td></tr><tr><td> <select  class="BDLY_INPUT_class_unit submultivalid form-control"  name="BDLY_INPUT_lb_elect_unit[]" id="BDLY_INPUT_lb_elect_unit-1" style="width: 90px;" hidden><option value="">SELECT</option></select> </td> <td><input  class="submultivalid rdonly form-control"  type="text" name ="BDLY_INPUT_tb_invoiceto[]" id="BDLY_INPUT_tb_invoiceto1"  style="display: none;" readonly/><input type="text" id="BDLY_INPUT_hidden_ecnid_elec1" name="BDLY_INPUT_hidden_ecnid_elec[]" class="form-control" style="display: none;"  hidden> </td><td><input  class="eledatepicker submultivalid datemandtry form-control"   type="text" name ="BDLY_INPUT_db_invoicedate[]" id="BDLY_INPUT_db_invoicedate1" style="width:100px;display: none;" hidden /> </td><td><input   class="eledatepicker submultivalid datemandtry form-control"  type="text" name ="BDLY_INPUT_db_fromperiod[]" id="BDLY_INPUT_db_fromperiod1" style="width:100px;display: none;" hidden/> </td><td><input  class="eledatepicker submultivalid datemandtry form-control"  type="text" name ="BDLY_INPUT_db_toperiod[]" id="BDLY_INPUT_db_toperiod1" style="width:100px;display: none;" hidden/> </td><td><select style="display: none;width:173px;"   name="BDLY_INPUT_lb_elect_payment[]" class="submultivalid amtentry form-control" id="BDLY_INPUT_lb_elect_payment1"  hidden><option value="" >SELECT</option></select></td><td><input  class="amtonlyvalidation submultivalid form-control" type="text" name ="BDLY_INPUT_tb_elect_amount[]" id="BDLY_INPUT_tb_elect_amount1" style="width:70px;display: none;" hidden /> <input class="amtonlyvalidation submultivalid form-control"  type="text" name ="BDLY_INPUT_tb_elect_minusamt[]" id="BDLY_INPUT_tb_elect_minusamt1" style="width:70px;display: none;" hidden /><input type="hidden" id="BDLY_INPUT_hidden_amt_elec1" style="display: none;"  name="BDLY_INPUT_hidden_amt_elec[]" ></td><td><textarea row="3" class=" submultivalid form-control" name ="BDLY_INPUT_ta_comments[]"  style="display: none;min-height:100px;width:180px;" id="BDLY_INPUT_ta_comments1" hidden ></textarea> </td><td><input type="button" value="+" class="addbttn" alt="Add Row" height="30" width="30" name ="BDLY_INPUT_add[]" id="BDLY_INPUT_add1" disabled > </td><td><input  type="button" value="-" class="deletebttn" alt="delete Row" height="30" width="30" name ="BDLY_INPUT_delete[]" id="BDLY_INPUT_del1" disabled ></td></tr>').appendTo($('#BDLY_INPUT_tble_electricity'));
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
            $(".datepickdate").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true,
                beforeShow:function(input, inst){
                    $(inst.dpDiv).removeClass('calendar-off');
                }});
            if(BDLY_INPUT_unit_response[0]!='BDLY_INPUT_flag_notsave'){
                BDLY_INPUT_load_unitno(BDLY_INPUT_unit_response);
            }}
//CLEARED UNIT EXPENSE MULTI  ROW //
        function BDLY_INPUT_clear_unitExpanse(BDLY_INPUT_unit_response){
            $(".preloader").hide();
            $('#BDLY_INPUT_btn_multisubmitbutton').attr('disabled','disabled')
            $('#BDLY_INPUT_tble_unitexpense').empty();
            $('<tr><td nowrap><label id="BDLY_INPUT_lbl_uexp_unit" >UNIT</label><em>*</em> </td><td nowrap><label  id="BDLY_INPUT_lbl_uexp_category" >CATEGORY</label><em>*</em></td><td nowrap><label  id="BDLY_INPUT_lbl_uexp_customer" hidden>CUSTOMER<em>*</em></label></td><td nowrap><label  id="BDLY_INPUT_lbl_uexp_customerid" hidden></label></td><td nowrap> <label id="BDLY_INPUT_lbl_uexp_invoicedate" >INVOICE DATE</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_uexp_invoiceitem" >INVOICE ITEM</label><em>*</em> </td><td nowrap><label id="BDLY_INPUT_lbl_uexp_invoicefrom" >INVOICE FROM</label><em>*</em></td><td nowrap><label id="BDLY_INPUT_lbl_uexp_amount" >AMOUNT</label><em>*</em> </td><td nowrap><label id="BDLY_INPUT_lbl_uexp_comments" >COMMENTS</label> </td><td ><label id="BDLY_INPUT_lbl_uexp_add" ></label> </td><td ><label id="BDLY_INPUT_lbl_uexp_del" ></label> </td></tr><tr><td style="max-width:200px;"> <select  class="BDLY_INPUT_uexp_class_unit uexp_submultivalid form-control"  name="BDLY_INPUT_lb_uexp_unit[]" id="BDLY_INPUT_lb_uexp_unit-1" style="display: none; width:90px;" hidden><option value="">SELECT</option></select> </td> <td style="max-width:200px;"><select  name="BDLY_INPUT_lb_uexp_category[]" class="uexp_submultivalid BDLY_INPUT_uexp_class_category form-control" id="BDLY_INPUT_lb_uexp_category-1" style="display: none;width:140px;" hidden><option value="" >SELECT</option></select></td><td style="max-width:200px;"><select  name="BDLY_INPUT_lb_uexp_customer[]" class="uexp_submultivalid BDLY_INPUT_uexp_class_custname form-control" id="BDLY_INPUT_lb_uexp_customer1" style="display: none;width:160px;" hidden><option value="" >SELECT</option></select></td><td style="max-width:200px;"><table id="multiplecustomer-1" width="250px" hidden></table><td style="max-width:150px;"><input  class="datepickdate uexp_submultivalid datemandtry form-control "  type="text" name ="BDLY_INPUT_db_uexp_invoicedate[]" id="BDLY_INPUT_db_uexp_invoicedate1" style="width:100px;display: none;" hidden /> </td><td style="max-width:250px;"><textarea  class="uexp_submultivalid form-control"  name ="BDLY_INPUT_tb_uexp_invoiceitem[]" id="BDLY_INPUT_tb_uexp_invoiceitem1" style="display: none;min-height:100px;width:180px;" hidden/></textarea> </td><td style="max-width:200px;"><input  class="uexp_submultivalid autosize autocomplete form-control" type="text" name ="BDLY_INPUT_tb_uexp_invoicefrom[]" id="BDLY_INPUT_tb_uexp_invoicefrom1" maxlength="200" style="display: none;" hidden/> </td><td style="max-width:100px;"><input  class="amtonlyfivedigit uexp_submultivalid form-control"  type="text" name ="BDLY_INPUT_tb_uexp_amount[]" id="BDLY_INPUT_tb_uexp_amount1" style="width:65px;display: none;" hidden /> </td><td><textarea style="width:180px;min-height:100px;" row="3" name ="BDLY_INPUT_ta_uexpcomments[]" id="BDLY_INPUT_ta_uexpcomments1" class=" uexp_submultivalid form-control" hidden ></textarea> </td><td><input type="button" value="+" class="uexp_addbttn" alt="Add Row" height="30" width="30" name ="BDLY_INPUT_uexpadd[]" id="BDLY_INPUT_uexp_add1" disabled > </td><td><input  type="button" value="-" class="uexp_deletebttn" alt="delete Row" height="30" width="30" name ="BDLY_INPUT_uexpdelete[]" id="BDLY_INPUT_uexp_del1" disabled ></td><td><input    type="text" name ="BDLY_INPUT_tb_uexp_hideradioid[]" id="BDLY_INPUT_tb_uexp_hideradioid1" style="width:75px;" hidden/> </td></tr>').appendTo($('#BDLY_INPUT_tble_unitexpense'))
            $(".amtonlyfivedigit").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
            $(".datepickdate").datepicker({dateFormat:'dd-mm-yy', changeYear: true, changeMonth: true,beforeShow:function(input, inst){
                $(inst.dpDiv).removeClass('calendar-off');
            }});
            if(BDLY_INPUT_unit_response[0]!='BDLY_INPUT_flag_notsave'){
                BDLY_INPUT_load_unitno(BDLY_INPUT_unit_response);
            }}
//CLEARED STAR HUB MULTI  ROW //
        function BDLY_INPUT_clear_starhub(BDLY_INPUT_unit_response){
            $(".preloader").hide();
            $('#BDLY_INPUT_tble_starhub').empty();
            $('<tr> <td nowrap><label id="BDLY_INPUT_lbl_star_unit" >UNIT</label><em>*</em> </td><td nowrap><label  id="BDLY_INPUT_lbl_star_invoiceto" >INVOICE TO</label><em>*</em></td><td nowrap><label id="BDLY_INPUT_lbl_star_accountno"  >ACCOUNT NO</label><em>*</em> </td><td nowrap> <label id="BDLY_INPUT_lbl_star_invoicedate" >INVOICE DATE</label><em>*</em> </td><td nowrap><label id="BDLY_INPUT_lbl_star_fromperiod" >FROM PERIOD</label><em>*</em> </td><td nowrap><label id="BDLY_INPUT_lbl_star_toperiod" >TO PERIOD</label><em>*</em></td><td nowrap><label id="BDLY_INPUT_lbl_star_amount" >AMOUNT</label><em>*</em> </td><td nowrap><label id="BDLY_INPUT_lbl_star_comments" >COMMENTS</label> </td><td ><label id="BDLY_INPUT_lbl_star_add" ></label> </td><td ><label id="BDLY_INPUT_lbl_star_del" ></label> </td></tr><tr><td> <select  class="BDLY_INPUT_class_star_unit star_submultivalid form-control"  name="BDLY_INPUT_lb_star_unit[]" id="BDLY_INPUT_lb_star_unit-1" style="display:none;" hidden>'+BDLY_INPUT_unitno_options+'</select> </td> <td> <select  class="BDLY_INPUT_class_star_invoice star_submultivalid form-control"  name="BDLYUT_lb_star_invoiceto[]" id="BDLY_INPUT_lb_star_invoice-1" style="display:none;" hidden><option value="">SELECT</option></select><input type="hidden" id="BDLY_INPUT_hidden_star_ecnid1" name="BDLY_INPUT_hidden_star_ecnid[]"> </td><td><input  class="star_submultivalid rdonly form-control"  type="text" name ="BDLY_INPUT_tb_star_accno[]" id="BDLY_INPUT_tb_star_accno1"  style="display:none;" hidden readonly/> </td><td><input  class="starinvdatepickdate star_submultivalid datemandtry form-control"  type="text" name ="BDLY_INPUT_db_star_invoicedate[]" id="BDLY_INPUT_db_star_invoicedate1" style="width:100px;display: none;" hidden /> </td><td><input  class="starfrmdatepickdate star_submultivalid datemandtry form-control"  type="text" name ="BDLY_INPUT_db_star_fromperiod[]" id="BDLY_INPUT_db_star_fromperiod1" style="width:100px;display: none;" hidden/> </td><td><input  class="startodatepickdate star_submultivalid datemandtry form-control"  type="text" name ="BDLY_INPUT_db_star_toperiod[]" id="BDLY_INPUT_db_star_toperiod1" style="width:100px;display: none;" hidden/> </td><td><input  class=" star_submultivalid includeminusfour form-control"  type="text" name ="BDLY_INPUT_tb_star_amount[]" id="BDLY_INPUT_tb_star_amount1" style="width:90px;display: none;" maxlength=4 hidden /> </td><td><textarea row="3" class=" star_submultivalid form-control"  name ="BDLY_INPUT_ta_star_comments[]" id="BDLY_INPUT_ta_star_comments1" style="display:none;min-height:100px;width:180px;" hidden ></textarea> </td><td><input type="button" value="+" class="star_addbttn" alt="Add Row" height="30" width="30" name ="BDLY_INPUT_add[]" id="BDLY_INPUT_star_add1" disabled > </td><td><input  type="button" value="-" class="star_deletebttn" alt="delete Row" height="30" width="30" name ="BDLY_INPUT_delete[]" id="BDLY_INPUT_star_del1" disabled ></td></tr>').appendTo($('#BDLY_INPUT_tble_starhub'));
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
            $('.includeminusfour').doValidation({rule:'numbersonly',prop:{integer:true,realpart:4,imaginary:2}});
            $(".datepickdate").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true,
                beforeShow:function(input, inst){
                    $(inst.dpDiv).removeClass('calendar-off');
                }});
            if(BDLY_INPUT_unit_response[0]!='BDLY_INPUT_flag_notsave'){
                BDLY_INPUT_load_unitno(BDLY_INPUT_unit_response);
            }
        }
        $(document).on('click','#BDLY_INPUT_btn_addbutton,#BDLY_INPUT_btn_removebutton',function(){
            $("#BDLY_INPUT_lbl_pay_uniterrmsg").hide();
            if($(this).attr('id')=="BDLY_INPUT_btn_addbutton"){
                $('#BDLY_INPUT_tb_pay_unitno').replaceWith('<input type="text" name="BDLY_INPUT_tb_pay_unitnocheck" id="BDLY_INPUT_tb_pay_unitnocheck" style="width:60px;"  class="BDLY_INPUT_class_submitvalidate form-control" />');
                $(this).replaceWith('<input type="button" name="BDLY_INPUT_btn_removebutton"  value="CLEAR" id="BDLY_INPUT_btn_removebutton" class="btn"/>');
                $("#BDLY_INPUT_tb_pay_unitnocheck").doValidation({rule:'numbersonly',prop:{realpart:4,leadzero:true}});
                $("#BDLY_INPUT_tb_pay_unitnocheck").blur(function()
                {   $('#BDLY_INPUT_lbl_checkcardno').val("");
                    BDLY_INPUT_checkunitno();
                });
            }
            if($(this).attr('id')=='BDLY_INPUT_btn_removebutton'){
                var BDLY_INPUT_allunitno_options ='<option>SELECT</option>'
                for (var i = 0; i < BDLY_INPUT_load_allunitnovalues.length; i++){
                    BDLY_INPUT_allunitno_options += '<option value="' + BDLY_INPUT_load_allunitnovalues[i] + '">' + BDLY_INPUT_load_allunitnovalues [i]+ '</option>';
                }
                $('#BDLY_INPUT_tb_pay_unitnocheck').replaceWith('<select id="BDLY_INPUT_tb_pay_unitno" name="BDLY_INPUT_tb_pay_unitno" class="BDLY_INPUT_class_hksubmitvalidate form-control" ></select>');
                $('#BDLY_INPUT_tb_pay_unitno').html(BDLY_INPUT_allunitno_options)
                $(this).replaceWith('<input type="button" name="BDLY_INPUT_btn_addbutton" value="ADD" id="BDLY_INPUT_btn_addbutton" class="btn"/>');
            }
            var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
            if(BDLY_INPUT_unitval==''||BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
            {
                if(BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
                {
                    if((BDLY_INPUT_unitval.length==4)&&($('#BDLY_INPUT_tb_pay_unitnocheck').val()!='')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            var BDLY_INPUT_unitvalno=$('#BDLY_INPUT_tb_pay_unitno').val();
            if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!=undefined)
            {
                if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!="SELECT"&&BDLY_INPUT_unitvalno!=undefined)
                {
                    if((BDLY_INPUT_unitvalno.length==4)&&($('#BDLY_INPUT_tb_pay_unitno').val()!=''&&$('#BDLY_INPUT_tb_pay_unitno').val()!='SELECT')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
        });
        var BDLY_INPUT_values=[];
        $(document).on('change','#BDLY_INPUT_lb_unitno',function(evnt) {
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $(".preloader").show();
            $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
            var BDLY_INPUT_unitno=$('#BDLY_INPUT_lb_unitno').val();
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
            $('#BDLY_INPUT_tble_digitalvoice').hide();
            if(BDLY_INPUT_unitno=="SELECT"){
                $(".preloader").hide();
                $('#BDLY_INPUT_tble_aircon').hide();
                $('#BDLY_INPUT_tble_cardpark').hide();
                $('#BDLY_INPUT_tble_digitalvoice').hide();
                $('#BDLY_INPUT_tble_facility').hide();
                $('#BDLY_INPUT_tble_moving').hide();
                $('#BDLY_INPUT_tble_purchase').hide();
                $('#BDLY_INPUT_btn_submitbutton').hide();
                $('#BDLY_INPUT_btn_resetbutton').hide();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
                $('#BDLY_INPUT_tble_pettycash').hide();
                $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled');
                $('#BDLY_INPUT_btn_multisubmitbutton').hide();
                $('#BDLY_INPUT_tble_electricity').hide();
                $('#BDLY_INPUT_tble_housekeeping').hide();
                $('#BDLY_INPUT_tble_housepayment').hide();
                $('#BDLY_INPUT_tble_pettycash').hide();
                $('#BDLY_INPUT_tble_moving').hide();
            }
            else
            {
                if(BDLY_INPUT_type==4){
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_INPUT_get_SEdate",
                        data:{"BDLY_INPUT_unitno":BDLY_INPUT_unitno},
                        success: function(res) {
                            $('.preloader').hide();
                            BDLY_INPUT_values=JSON.parse(res);
                            BDLY_INPUT_load_form(BDLY_INPUT_values)
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                    $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
                }
                else if(BDLY_INPUT_type==7){
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_INPUT_get_SEdate",
                        data:{"BDLY_INPUT_unitno":BDLY_INPUT_unitno},
                        success: function(res) {
                            $('.preloader').hide();
                            BDLY_INPUT_values=JSON.parse(res);
                            BDLY_INPUT_load_form(BDLY_INPUT_values)
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                    $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
                }
                else if(BDLY_INPUT_type==6){
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_INPUT_get_SEdate",
                        data:{"BDLY_INPUT_unitno":BDLY_INPUT_unitno},
                        success: function(res) {
                            $('.preloader').hide();
                            BDLY_INPUT_values=JSON.parse(res);
                            BDLY_INPUT_load_form(BDLY_INPUT_values)
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                    $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
                }
                else{
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_INPUT_get_values",
                        data:{"BDLY_INPUT_unitno":BDLY_INPUT_unitno,"BDLY_INPUT_type":BDLY_INPUT_type},
                        success: function(res) {
                            $('.preloader').hide();
                            BDLY_INPUT_values=JSON.parse(res);
                            BDLY_INPUT_load_form(BDLY_INPUT_values)

                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
            }
        });
        //LOAD THE VALUE IN THE FORMS//
        function BDLY_INPUT_load_form(BDLY_INPUT_values)
        {
            $(".preloader").hide();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
            $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled").show();
            if(BDLY_INPUT_type==6){
                BDLY_INPUT_unitenddate=BDLY_INPUT_values.unitedate;
                BDLY_INPUT_unitstartdate=BDLY_INPUT_values.unitsdate;
                BDLY_INPUT_unitinvdate=BDLY_INPUT_values.invdate;
                $('#BDLY_INPUT_tble_purchase').show();
                $('#BDLY_INPUT_btn_submitbutton').show();
                $('#BDLY_INPUT_btn_resetbutton').show();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
            }
            if(BDLY_INPUT_type==7){
                BDLY_INPUT_unitenddate=BDLY_INPUT_values.unitedate;
                BDLY_INPUT_unitstartdate=BDLY_INPUT_values.unitsdate;
                BDLY_INPUT_unitinvdate=BDLY_INPUT_values.invdate;
                $(".preloader").hide();
                $('#BDLY_INPUT_tble_moving').show();
                $('#BDLY_INPUT_btn_submitbutton').show();
                $('#BDLY_INPUT_btn_resetbutton').show();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
            }
            if(BDLY_INPUT_type==4){
                $(".preloader").hide();
                BDLY_INPUT_unitenddate=BDLY_INPUT_values.unitedate;
                BDLY_INPUT_unitstartdate=BDLY_INPUT_values.unitsdate;
                BDLY_INPUT_unitinvdate=BDLY_INPUT_values.invdate;
                $('#BDLY_INPUT_tble_facility').show();
                $('#BDLY_INPUT_btn_submitbutton').show();
                $('#BDLY_INPUT_btn_resetbutton').show();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
            }
            if(BDLY_INPUT_type==9){
                $(".preloader").hide();
                $('#BDLY_INPUT_tble_digitalvoice').hide();
                var BDLY_INPUT_sevbyvalues=(BDLY_INPUT_values[0].BDLY_INPUT_airconserviceby).length;
                $('#BDLY_INPUT_tb_serviceby').attr("size",BDLY_INPUT_sevbyvalues+4);
                $('#BDLY_INPUT_tb_serviceby').val(BDLY_INPUT_values[0].BDLY_INPUT_airconserviceby);
                $('#BDLY_INPUT_hidden_edasid').val(BDLY_INPUT_values[0].BDLY_INPUT_edasid);
                $('#BDLY_INPUT_tble_aircon').show();
                BDLY_INPUT_unitenddate=BDLY_INPUT_values[1].unitedate;
                BDLY_INPUT_unitstartdate=BDLY_INPUT_values[1].unitsdate;
                BDLY_INPUT_unitinvdate=BDLY_INPUT_values[1].invdate;
            }
            if(BDLY_INPUT_type==8){
                $(".preloader").hide();
                $('#BDLY_INPUT_tble_digitalvoice').hide();
                var BDLY_INPUT_carnovalues=(BDLY_INPUT_values[0].BDLY_INPUT_carno_data).length;
                $('#BDLY_INPUT_tb_carno').attr("size",(BDLY_INPUT_carnovalues+2));
                $('#BDLY_INPUT_tb_carno').val(BDLY_INPUT_values[0].BDLY_INPUT_carno_data)
                $('#BDLY_INPUT_hidden_edcpid').val(BDLY_INPUT_values[0].BDLY_INPUT_carno_id)
                $('#BDLY_INPUT_tble_cardpark').show();
                BDLY_INPUT_unitenddate=BDLY_INPUT_values[1].unitedate;
                BDLY_INPUT_unitstartdate=BDLY_INPUT_values[1].unitsdate;
                BDLY_INPUT_unitinvdate=BDLY_INPUT_values[1].invdate;
            }
            if(BDLY_INPUT_type==5){
                $(".preloader").hide();
                $('#BDLY_INPUT_tble_digitalvoice').show();
                var BDLY_INPUT_invoiceno=BDLY_INPUT_values[1];
                var BDLY_INPUT_invoiceto=BDLY_INPUT_values[0];
                var BDLY_INPUT_accno=BDLY_INPUT_values[2];
                var BDLY_INPUT_invoicetoval=(BDLY_INPUT_invoiceto).length;
                var BDLY_INPUT_accnoval=(BDLY_INPUT_accno).length;
                $('#BDLY_INPUT_tb_digi_voiceno').attr("size",parseInt(BDLY_INPUT_invoiceno.length)+3);
                $('#BDLY_INPUT_tb_digi_accno').attr("size",BDLY_INPUT_accnoval+4);
                $('#BDLY_INPUT_tb_digi_accno').val(BDLY_INPUT_accno)
                $('#BDLY_INPUT_tb_digi_voiceno').val(BDLY_INPUT_invoiceno)
                if(BDLY_INPUT_invoiceto!="")
                {
                    var values='<input type="text"  class="rdonly form-control" id="BDLY_INPUT_lb_digi_invoiceto" name="BDLY_INPUT_tb_digi_invoiceto" value="'+BDLY_INPUT_invoiceto+'" readonly >'
                    $('#BDLY_INPUT_lb_digi_invoiceto').replaceWith(values)
                    $('#BDLY_INPUT_lbl_digi_invoiceto').attr("size",225);
                    $('#BDLY_INPUT_lb_digi_invoiceto').attr("size",(BDLY_INPUT_invoicetoval+4));
                }
                else{
                    $('#BDLY_INPUT_lb_digi_invoiceto').empty();
                    var expense_id=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_id;
                    var expense_Data=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_date;
                    var BDLY_INPUT_options =''
                    for (var i = 0; i <expense_id.length ; i++) {
//                        var PDLY_INPUT_gettypofexpensevalues=BDLY_INPUT_exptype_array[i]
                        if(i>=16 && i<=18)
                        {
                            BDLY_INPUT_options += '<option value="' + expense_id[i] + '">' + expense_Data[i]+ '</option>';
                        }
                    }
                    var values='<select id="BDLY_INPUT_lb_digi_invoiceto" name="BDLY_INPUT_lb_digi_invoiceto" class="BDLY_INPUT_class_submitvalidate form-control" > '+BDLY_INPUT_options+'</select>'
                    $('#BDLY_INPUT_lb_digi_invoiceto').replaceWith(values);
                    $('#BDLY_INPUT_lbl_digi_invoiceto').attr("size",225);
                    BDLY_INPUT_Sortit('BDLY_INPUT_lb_digi_invoiceto');
                }
                BDLY_INPUT_unitenddate=BDLY_INPUT_values[3].unitedate;
                BDLY_INPUT_unitstartdate=BDLY_INPUT_values[3].unitsdate;
                BDLY_INPUT_unitinvdate=BDLY_INPUT_values[3].invdate;
                BDLY_INPUT_setdatepick();
            }
            BDLY_INPUT_clearalldates();
            $('#BDLY_INPUT_btn_submitbutton').show();
            $('#BDLY_INPUT_btn_resetbutton').show();
            $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
        }
        $(document).on('change','.BDLY_INPUT_class_unit',function(evnt)
        {
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $(".preloader").show();
            var BDLY_INPUT_id=$(this).attr('id');
            $('#BDLY_INPUT_tb_access_cardno').removeClass('invalid')
            BDLY_INPUT_id_no =BDLY_INPUT_id.split("-");
            BDLY_INPUT_id_no=BDLY_INPUT_id_no[1]
            var BDLY_INPUT_unit = $("#"+BDLY_INPUT_id).val();
            if(BDLY_INPUT_unit=="SELECT")
            {$(".preloader").hide();
                $('#BDLY_INPUT_lb_elect_payment'+BDLY_INPUT_id_no).prop('selectedIndex',0).hide();
                $('#BDLY_INPUT_db_invoicedate'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_db_fromperiod'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_db_toperiod'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_ta_comments'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_tb_invoiceto'+BDLY_INPUT_id_no).hide();
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
                $('#BDLY_INPUT_add'+BDLY_INPUT_id_no).attr("disabled", "disabled");
                $('#BDLY_INPUT_del'+BDLY_INPUT_id_no).attr("disabled", "disabled");
            }
            if(BDLY_INPUT_unit!="SELECT")
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_INPUT_get_invoiceto",
                    data:{"BDLY_INPUT_unit":BDLY_INPUT_unit},
                    success: function(res) {
                        $('.preloader').hide();
                        elect_values=JSON.parse(res);
                        BDLY_INPUT_load_invoiceto(elect_values)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });var elect_values=[];
        //*********************FUNCTION TO LOAD ELECTRICITY INVOICE TO******************************//
        function BDLY_INPUT_load_invoiceto(elect_values)
        {
            $(".preloader").hide();
            var BDLY_INPUT_invoiceto=elect_values[0];
//var BDLY_INPUT_paymentof=elect_values[1];
            var BDLY_INPUT_elecsedate=elect_values[1];
            BDLY_INPUT_unitenddate=BDLY_INPUT_elecsedate.unitedate;
            BDLY_INPUT_unitstartdate=BDLY_INPUT_elecsedate.unitsdate;
            BDLY_INPUT_unitinvdate=BDLY_INPUT_elecsedate.invdate;
            var BDLY_INPUT_invoicetoval=BDLY_INPUT_invoiceto.length;
            $('#BDLY_INPUT_tb_invoiceto'+BDLY_INPUT_id_no).show();
            $('#BDLY_INPUT_tb_invoiceto'+BDLY_INPUT_id_no).attr("size",BDLY_INPUT_invoicetoval+4);
            $('#BDLY_INPUT_tb_invoiceto'+BDLY_INPUT_id_no).val(BDLY_INPUT_invoiceto)
            $('#BDLY_INPUT_hidden_ecnid_elec'+BDLY_INPUT_id_no).val(elect_values[2])
            $('#BDLY_INPUT_db_invoicedate'+BDLY_INPUT_id_no).val('').show();
            $('#BDLY_INPUT_db_fromperiod'+BDLY_INPUT_id_no).val('').show();
            $('#BDLY_INPUT_db_toperiod'+BDLY_INPUT_id_no).val('').show();
            var BDLY_INPUT_payment_options =''
            var expense_id=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_id;
            var expense_Data=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_date;
            for (var i = 0; i <expense_id.length ; i++) {
//                var PDLY_INPUT_gettypofexpensevalues=BDLY_INPUT_exptype_array[i]
                if(i>=19 && i<=21)
                {
                    BDLY_INPUT_payment_options += '<option value="' + expense_id[i] + '">' +expense_Data[i]+ '</option>';
                }
            }
            $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_id_no).val('').show();
            $('#BDLY_INPUT_lb_elect_payment'+BDLY_INPUT_id_no).html(BDLY_INPUT_payment_options).show();
            BDLY_INPUT_Sortit('BDLY_INPUT_lb_elect_payment'+BDLY_INPUT_id_no);
            $('#BDLY_INPUT_ta_comments'+BDLY_INPUT_id_no).val('').show();
            $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_datep = $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_datep ) );
                    date.setDate( date.getDate() );
                    var PDLY_INPUT_newDate = date.toDateString();
                    PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                    $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",PDLY_INPUT_newDate);
                    $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",PDLY_INPUT_newDate);
                    BDLY_INPUT_electricityvaliation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
//DATE PICKER FUNCTION FOR FROM DATE..............
            $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_fromdate = $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                    date.setDate( date.getDate()  ); //+ 1
                    var PDLY_INPUT_newDate = date.toDateString();
                    PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                    $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","minDate",PDLY_INPUT_newDate);
                    var paiddate = $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( paiddate ) );
                    date.setDate( date.getDate()  );
                    var paidnewDate = date.toDateString();
                    paidnewDate = new Date( Date.parse( paidnewDate ) );
                    $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",paidnewDate);
                    BDLY_INPUT_electricityvaliation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
//DATE PICKER FOR TO DATE ..................
            $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_fromdate = $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                    date.setDate( date.getDate()  );
                    var newDate = date.toDateString();
                    newDate = new Date( Date.parse( newDate ) );
                    $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","minDate",newDate);
                    var PDLY_INPUT_paiddate = $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_paiddate ) );
                    date.setDate( date.getDate() ); // - 1
                    var PDLY_INPUT_paidnewDate = date.toDateString();
                    PDLY_INPUT_paidnewDate = new Date( Date.parse( PDLY_INPUT_paidnewDate ) );
                    $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",PDLY_INPUT_paidnewDate);
                    BDLY_INPUT_electricityvaliation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
            BDLY_INPUT_electricityvaliation();
            BDLY_INPUT_setdatepick();
        }
        //SUBMIT BUTTON VALIDATION FOR ELECTRICITY//
        $(document).on('blur','.submultivalid',function() {
            BDLY_INPUT_electricityvaliation();
        });
        function BDLY_INPUT_electricityvaliation()
        {
            var BDLY_INPUT_table = document.getElementById('BDLY_INPUT_tble_electricity');
            var BDLY_INPUT_table_rowlength=BDLY_INPUT_table.rows.length;
            var BDLY_INPUT_lastrowid=BDLY_INPUT_table_rowlength-1;
            var count=0;
            for(var i=1;i<=BDLY_INPUT_table_rowlength;i++)
            {
                var unit=$('#BDLY_INPUT_lb_elect_unit-'+i).val()
                var invoicedate=$('#BDLY_INPUT_db_invoicedate'+i).val()
                var fromdate=$('#BDLY_INPUT_db_fromperiod'+i).val()
                var todate=$('#BDLY_INPUT_db_toperiod'+i).val()
                var payment=$('#BDLY_INPUT_lb_elect_payment'+i).val()
                if($('#BDLY_INPUT_lb_elect_payment'+i).val()==133||$('#BDLY_INPUT_lb_elect_payment'+i).val()==134)
                    var amount=$('#BDLY_INPUT_tb_elect_minusamt'+i).val()
                else
                    var amount=$('#BDLY_INPUT_tb_elect_amount'+i).val()
                if((unit!=undefined)&&(payment!=undefined)&&(unit!="SELECT")&&(payment!="SELECT")&&(unit!='')&&(payment!='')&&(amount!="")&&(parseInt(amount)!=0)&&(fromdate!="")&&(todate!="")&&(amount!=undefined)&&(fromdate!=undefined)&&(todate!=undefined)&&(invoicedate!=''))
                {
                    count=count+1;
                }
            }
            if(count==BDLY_INPUT_table_rowlength-1)
            {
                $('#BDLY_INPUT_add'+BDLY_INPUT_lastrowid).removeAttr("disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').removeAttr("disabled");
            }
            else
            {
                $('#BDLY_INPUT_add'+BDLY_INPUT_lastrowid).attr("disabled", "disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            }
        }
        var newid=1;
//ADDING NEW ROW IN ELECTRICITY//
        $(document).on('click','.addbttn',function() {
            var table = document.getElementById('BDLY_INPUT_tble_electricity');
            var rowCount = table.rows.length;
            newid =rowCount;
            var newid1=newid-1;
            $('#BDLY_INPUT_add'+newid1).hide();
            $('#BDLY_INPUT_del'+newid1).hide();
            var newRow = table.insertRow(rowCount);
            var oCell = newRow.insertCell(0);
            oCell.innerHTML = "<select  class='BDLY_INPUT_class_unit submultivalid form-control' name ='BDLY_INPUT_lb_elect_unit[]' id='"+"BDLY_INPUT_lb_elect_unit-"+newid+"' style='display:none;' hidden  >";
            oCell = newRow.insertCell(1);
            oCell.innerHTML ="<input  class='rdonly submultivalid form-control'  type='text' name ='BDLY_INPUT_tb_invoiceto[]' id='"+"BDLY_INPUT_tb_invoiceto"+newid+"' style='display:none;' readonly  hidden/><input  type='hidden' name ='BDLY_INPUT_hidden_ecnid_elec' id='"+"BDLY_INPUT_hidden_ecnid_elec"+newid+"' />";
//oCell.innerHTML ="<input  type='hidden' name ='BDLY_INPUT_hidden_ecnid_elec' id='"+"BDLY_INPUT_hidden_ecnid_elec"+newid+"' />";
            oCell = newRow.insertCell(2);
            oCell.innerHTML ="<input  class=' submultivalid datemandtry form-control'  type='text' name ='BDLY_INPUT_db_invoicedate[]' id='"+"BDLY_INPUT_db_invoicedate"+newid+"' style='width:100px;display:none;' hidden /> ";
            oCell = newRow.insertCell(3);
            oCell.innerHTML ="<input  class=' submultivalid datemandtry form-control'  type='text' name ='BDLY_INPUT_db_fromperiod[]' id='"+"BDLY_INPUT_db_fromperiod"+newid+"' style='width:100px;display:none;' hidden/> ";
            oCell = newRow.insertCell(4);
            oCell.innerHTML ="<input  class=' submultivalid datemandtry form-control'  type='text' name ='BDLY_INPUT_db_toperiod[]' id='"+"BDLY_INPUT_db_toperiod"+newid+"' style='width:100px;display:none;' hidden/> ";
//<!-- DATE PICKER FOR THE ELECTRICITY DATE BOX ENTRY -->
            $(document).on('blur','.submultivalid',function() {
                BDLY_INPUT_electricityvaliation();
            });
            $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_datep = $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_datep ) );
                    date.setDate( date.getDate() );
                    var PDLY_INPUT_newDate = date.toDateString();
                    PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                    $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",PDLY_INPUT_newDate);
                    $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",PDLY_INPUT_newDate);
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
//DATE PICKER FUNCTION FOR FROM DATE..............
            $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_fromdate = $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                    date.setDate( date.getDate()  ); //+ 1
                    var PDLY_INPUT_newDate = date.toDateString();
                    PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                    $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","minDate",PDLY_INPUT_newDate);
                    BDLY_INPUT_electricityvaliation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
//DATE PICKER FOR TO DATE ..................
            oCell = newRow.insertCell(5);
            oCell.innerHTML ="<select  name='BDLY_INPUT_lb_elect_payment[]' class='submultivalid amtentry form-control' id='"+"BDLY_INPUT_lb_elect_payment"+newid+"' style='display:none;width:173px;' hidden><option value='' >SELECT</option></select>";
            oCell = newRow.insertCell(6);
            oCell.innerHTML ="<input  class='amtonlyvalidation submultivalid form-control' type='text' name ='BDLY_INPUT_tb_elect_amoun[]t' id='"+"BDLY_INPUT_tb_elect_amount"+newid+"' style='width:70px;display:none;' hidden /> <input class='amtonlyvalidation submultivalid form-control' type='text' name ='BDLY_INPUT_tb_elect_amount[]' id='"+"BDLY_INPUT_tb_elect_minusamt"+newid+"' style='width:70px;display:none;' hidden /><input type='hidden' id='"+"BDLY_INPUT_hidden_amt_elec"+newid+"' name='BDLY_INPUT_hidden_amt_elec[]'>";
            $(".amtonlyvalidation").click(function(){
                var BDLY_INPUT_id=$(this).attr('id');
                var BDLY_INPUT_elemtid =BDLY_INPUT_id.replace( /^\D+/g, '');
                var BDLY_INPUT_paymentval=$('#BDLY_INPUT_lb_elect_payment'+BDLY_INPUT_elemtid).val();
                $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_elemtid).doValidation({rule:'numbersonly',prop:{integer:true,realpart:3,imaginary:2}});
                $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_elemtid).doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
                if(BDLY_INPUT_paymentval==134||BDLY_INPUT_paymentval==133)
                {
                    $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_elemtid).show();
                    $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_elemtid).hide();
                }
                else
                {
                    $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_elemtid).hide();
                    $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_elemtid).show();
                }
            });
            $(document).on("change blur",'.amtonlyvalidation', function (){
                var BDLY_INPUT_id=$(this).attr('id');
                var BDLY_INPUT_elemtid =BDLY_INPUT_id.replace( /^\D+/g, '');
                $('#BDLY_INPUT_hidden_amt_elec'+BDLY_INPUT_elemtid).val('')
                var BDLY_INPUT_paymentval=$('#BDLY_INPUT_lb_elect_payment'+BDLY_INPUT_elemtid).val();
                $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_elemtid).doValidation({rule:'numbersonly',prop:{integer:true,realpart:3,imaginary:2}});
                $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_elemtid).doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
                $('#BDLY_INPUT_hidden_amt_elec'+BDLY_INPUT_elemtid).val('')
                if(BDLY_INPUT_paymentval==134||BDLY_INPUT_paymentval==133)
                {
                    $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_elemtid).show();
                    $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_elemtid).hide();
                    $('#BDLY_INPUT_hidden_amt_elec'+BDLY_INPUT_elemtid).val($('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_elemtid).val());
                }
                else
                {
                    $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_elemtid).hide();
                    $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_elemtid).show();
                    $('#BDLY_INPUT_hidden_amt_elec'+BDLY_INPUT_elemtid).val($('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_elemtid).val());
                }});
            oCell = newRow.insertCell(7);
            oCell.innerHTML = "<textarea row='2' class=' submultivalid form-control' name ='BDLY_INPUT_ta_comments[]' id='"+"BDLY_INPUT_ta_comments"+newid+"' style='display:none;min-height:100px;width:180px' hidden></textarea>";
            oCell = newRow.insertCell(8);
            oCell.innerHTML = "<input type='button' value='+' class='addbttn' alt='Add Row' height='30' width='30' name ='BDLY_INPUT_add[]' id='"+"BDLY_INPUT_add"+newid+"' disabled>";
            oCell = newRow.insertCell(9);
            oCell.innerHTML = "<input  type='button' value='-' class='deletebttn' alt='delete Row' height='30' width='30' name ='BDLY_INPUT_delete[]' id='"+"BDLY_INPUT_del"+newid+"' >";
            $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            BDLY_INPUT_loadmulti_unitno(BDLY_INPUT_unitno);
            $(document).on('blur','.submultivalid',function() {
                BDLY_INPUT_electricityvaliation();
            });
        });
        //LOAD THE MULTIROW UNIT NUMBER//
        function BDLY_INPUT_loadmulti_unitno(unitno){
            $(".preloader").hide();
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
            var BDLY_INPUT_unitno_options ='<option>SELECT</option>'
            for (var i = 0; i < unitno.length; i++){
                BDLY_INPUT_unitno_options += '<option value="' + unitno[i] + '">' + unitno [i]+ '</option>';
            }
            if(BDLY_INPUT_type==1){
                $('#BDLY_INPUT_lb_elect_unit-'+newid).html(BDLY_INPUT_unitno_options).show();
            }
            if(BDLY_INPUT_type==3){
                $('#BDLY_INPUT_lb_uexp_unit-'+newid).html(BDLY_INPUT_unitno_options).show();
            }
            if(BDLY_INPUT_type==2){
                $('#BDLY_INPUT_lb_star_unit-'+newid).html(BDLY_INPUT_unitno_options).show();
            }
        }
        $(document).on('click','.deletebttn',function() {
            var table = document.getElementById('BDLY_INPUT_tble_electricity');
            if(table.rows.length>2)
                $(this).closest("tr").remove();
            var BDLY_INPUT_table = document.getElementById('BDLY_INPUT_tble_electricity');
            var BDLY_INPUT_table_rowlength=BDLY_INPUT_table.rows.length;
            var BDLY_INPUT_newid=BDLY_INPUT_table_rowlength-1;
            $('#BDLY_INPUT_add'+BDLY_INPUT_newid).show();
            $('#BDLY_INPUT_del'+BDLY_INPUT_newid).show();
            var count=0;
            for(var i=1;i<=BDLY_INPUT_table_rowlength;i++)
            {
                var unit=$('#BDLY_INPUT_lb_elect_unit-'+i).val()
                var invoicedate=$('#BDLY_INPUT_db_invoicedate'+i).val()
                var fromdate=$('#BDLY_INPUT_db_fromperiod'+i).val()
                var todate=$('#BDLY_INPUT_db_toperiod'+i).val()
                var payment=$('#BDLY_INPUT_lb_elect_payment'+i).val()
                if($('#BDLY_INPUT_lb_elect_payment'+i).val()==133||$('#BDLY_INPUT_lb_elect_payment'+i).val()==134)
                    var amount=$('#BDLY_INPUT_tb_elect_minusamt'+i).val()
                else
                    var amount=$('#BDLY_INPUT_tb_elect_amount'+i).val()
                if((unit!=undefined)&&(payment!=undefined)&&(unit!="SELECT")&&(payment!="SELECT")&&(unit!='')&&(payment!='')&&(amount!="")&&(parseInt(amount)!=0)&&(fromdate!="")&&(todate!="")&&(amount!=undefined)&&(fromdate!=undefined)&&(todate!=undefined)&&(invoicedate!=''))
                {
                    count=count+1;
                }
            }
            if(count==BDLY_INPUT_table_rowlength-1)
            {
                $('#BDLY_INPUT_add'+BDLY_INPUT_newid).removeAttr("disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').removeAttr("disabled");
            }
            else
            {
                $('#BDLY_INPUT_add'+BDLY_INPUT_newid).attr("disabled", "disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            }
        });
        //VALIDATION FOR LIST BOX//
        $(document).on("change blur",'.BDLY_INPUT_class_submitvalidate', function (){
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val();
            if(BDLY_INPUT_type==9){
                if($('#BDLY_INPUT_tb_air_date').val()!=''){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==5){
                if(($('#BDLY_INPUT_lb_digi_invoiceto').val()!='SELECT')&&($('#BDLY_INPUT_tb_digi_voiceno').val()!='')&&($('#BDLY_INPUT_tb_digi_accno').val()!='')&&($('#BDLY_INPUT_tb_digi_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_digi_fromdate').val()!='')&&($('#BDLY_INPUT_tb_digi_todate').val()!='')&&($('#BDLY_INPUT_tb_digi_invoiceamt').val()!='')&&(parseInt($('#BDLY_INPUT_tb_digi_invoiceamt').val())!=0)){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==8){
                if(($('#BDLY_INPUT_tb_cp_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_cp_fromdate').val()!='')&&($('#BDLY_INPUT_tb_cp_todate').val()!='')&&($('#BDLY_INPUT_tb_cp_invoiceamt').val()!='')){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==6){
                if((BDLY_INPUT_access_flag==1)&&(BDLY_INPUT_access_flag1!=0)&&($('#BDLY_INPUT_tb_access_date').val()!='')&&($('#BDLY_INPUT_tb_access_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_access_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_access_cardno').val()!='')){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==10){//PETTY CASH//
                if(((($('#BDLY_INPUT_tb_petty_cashin').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_petty_cashin').val())!=0))||(($('#BDLY_INPUT_tb_petty_cashout').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_petty_cashout').val())!=0)))&&($('#BDLY_INPUT_ta_petty_invoiceitem').val()!='')&&($('#BDLY_INPUT_tb_petty_date').val()!='')){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==7){
                if(($('#BDLY_INPUT_tb_mov_date').val()!='')&&($('#BDLY_INPUT_tb_mov_invoiceamt').val()!='')&&(parseInt($('#BDLY_INPUT_tb_mov_invoiceamt').val())!=0))
                {
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==4){
                if(($('#BDLY_INPUT_lb_unitno').val()!='SELECT')&&($('#BDLY_INPUT_tb_fac_invoicedate').val()!='')&&((($('#BDLY_INPUT_radio_fac_deposit').is(":checked")==true)&&($('#BDLY_INPUT_tb_fac_depositamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_fac_depositamt').val())!=0))||(($('#BDLY_INPUT_radio_fac_invoiceamt').is(":checked")==true)&&($('#BDLY_INPUT_tb_fac_invoiceamt').val()!='')))){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==12){
                var d=$(this).attr('id')
                var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
                if(BDLY_INPUT_unitval==''||BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
                {
                    if(BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
                    {
                        if(BDLY_INPUT_unitval.length<4)
                        {
                            $('#BDLY_INPUT_tb_pay_unitnocheck').addClass('invalid');
                            $('#BDLY_INPUT_tb_pay_unitnocheck').val('');
                            $('#BDLY_INPUT_lbl_pay_uniterrmsg').text(BDLY_INPUT_tableerrmsgarr[15].EMC_DATA).show();
                        }
                        else
                        {
                            $('#BDLY_INPUT_tb_pay_unitnocheck').removeClass('invalid');
                            $('#BDLY_INPUT_lbl_pay_uniterrmsg').hide();
                        }
                        if((BDLY_INPUT_unitval.length==4)&&($('#BDLY_INPUT_tb_pay_unitnocheck').val()!='')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                            $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                        }
                        else{
                            $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                        }
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
                var BDLY_INPUT_unitvalno=$('#BDLY_INPUT_tb_pay_unitno').val();
                if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!=undefined)
                {
                    if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!="SELECT"&&BDLY_INPUT_unitvalno!=undefined)
                    {
                        if((BDLY_INPUT_unitvalno.length==4)&&($('#BDLY_INPUT_tb_pay_unitno').val()!=''&&$('#BDLY_INPUT_tb_pay_unitno').val()!='SELECT')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                            $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                        }
                        else{
                            $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                        }
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
            }
            if(BDLY_INPUT_type==11){
                var BDLY_INPUT_cleanername=$('#BDLY_INPUT_lb_house_cleanername').val();
                var BDLY_INPUT_housekeepingdate=$('#BDLY_INPUT_tb_house_date').val();
                var BDLY_INPUT_housekeepinghours=$('#BDLY_INPUT_tb_house_hours').val();
                var BDLY_INPUT_housekeepingmin=$('#BDLY_INPUT_tb_house_min').val();
                if(BDLY_INPUT_housekeepinghours==""&&BDLY_INPUT_housekeepingmin=="")
                {
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
                else
                if(BDLY_INPUT_housekeepinghours!=""||BDLY_INPUT_housekeepingmin!="")
                {
                    if((BDLY_INPUT_housekeepinghours>24)||((BDLY_INPUT_housekeepinghours==24)&&(BDLY_INPUT_housekeepingmin<60)&&(parseInt(BDLY_INPUT_housekeepingmin)!=0)&&(BDLY_INPUT_housekeepingmin!='')))
                    {
                        $('#BDLY_INPUT_tb_house_hours').addClass('invalid');
                        $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[11].EMC_DATA);
                        $('#BDLY_INPUT_lbl_hourmsg').show();
                    }
                    else
                    {
                        $('#BDLY_INPUT_tb_house_hours').removeClass('invalid');
                        $('#BDLY_INPUT_lbl_hourmsg').hide();
                    }
                    if(BDLY_INPUT_housekeepingmin>=60)
                    {
                        $('#BDLY_INPUT_tb_house_min').addClass('invalid');
                        $('#BDLY_INPUT_lbl_minmsg').text(BDLY_INPUT_tableerrmsgarr[12].EMC_DATA);
                        $('#BDLY_INPUT_lbl_minmsg').show();
                    }
                    else
                    {
                        $('#BDLY_INPUT_tb_house_min').removeClass('invalid');
                        $('#BDLY_INPUT_lbl_minmsg').hide();
                    }
                    if(BDLY_INPUT_housekeepinghours>24&&BDLY_INPUT_housekeepingmin>60)
                    {
                        if(BDLY_INPUT_housekeepinghours>24&&BDLY_INPUT_housekeepingmin>60)
                        {
                            $('#BDLY_INPUT_tb_house_hours').addClass('invalid');
                            $('#BDLY_INPUT_tb_house_min').addClass('invalid');
                            $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[11].EMC_DATA);
                            $('#BDLY_INPUT_lbl_minmsg').text(BDLY_INPUT_tableerrmsgarr[12].EMC_DATA);
                            $('#BDLY_INPUT_lbl_hourmsg').show();
                            $('#BDLY_INPUT_lbl_minmsg').show();
                        }
                        else
                        {
                            $('#BDLY_INPUT_tb_house_min').removeClass('invalid');
                            $('#BDLY_INPUT_lbl_minmsg').hide();
                            $('#BDLY_INPUT_tb_house_hours').removeClass('invalid');
                            $('#BDLY_INPUT_lbl_hourmsg').hide();
                        }
                    }
                }
                if((($('#BDLY_INPUT_tb_house_hours').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_hours').val())!=0)&&(BDLY_INPUT_housekeepinghours<=24)&&((parseInt($('#BDLY_INPUT_tb_house_min').val())==0)||($('#BDLY_INPUT_tb_house_min').val()==''))&&($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&((($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&($('.BDLY_INPUT_class_hkname').attr('id')==undefined))||(($('.BDLY_INPUT_class_hkname').attr('id')!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!=undefined)))&&($('#BDLY_INPUT_tb_house_date').val()!='')&&($('#BDLY_INPUT_ta_house_desc').val()!=''))
                    ||(($('#BDLY_INPUT_tb_house_min').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_min').val())!=0)&&(BDLY_INPUT_housekeepingmin<60)&&((parseInt($('#BDLY_INPUT_tb_house_hours').val())==0)||($('#BDLY_INPUT_tb_house_hours').val()==''))&&($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&((($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&($('.BDLY_INPUT_class_hkname').attr('id')==undefined))||(($('.BDLY_INPUT_class_hkname').attr('id')!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!=undefined)))&&($('#BDLY_INPUT_tb_house_date').val()!='')&&($('#BDLY_INPUT_ta_house_desc').val()!=''))
                    ||(($('#BDLY_INPUT_tb_house_hours').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_hours').val())!=0)&&(BDLY_INPUT_housekeepinghours<24)&&(BDLY_INPUT_housekeepingmin<60)&&($('#BDLY_INPUT_tb_house_min').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_min').val())!=0)&&($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&((($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&($('.BDLY_INPUT_class_hkname').attr('id')==undefined))||(($('.BDLY_INPUT_class_hkname').attr('id')!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!=undefined)))&&($('#BDLY_INPUT_tb_house_date').val()!='')&&($('#BDLY_INPUT_ta_house_desc').val()!=''))){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
        });
        $('#BDLY_INPUT_btn_submitbutton').click(function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $(".preloader").show();
            $('#BDLY_INPUT_lbl_checkcardno').val("save");
            var BDLY_INPUT_listvalue=$('#BDLY_INPUT_lb_selectexptype').val();
            if((BDLY_INPUT_listvalue==6)||(BDLY_INPUT_listvalue==12))
            {
                if(BDLY_INPUT_listvalue==6)
                {
                    BDLY_INPUT_checkcardvalue();
                }
                if(BDLY_INPUT_listvalue==12)
                {
                    BDLY_INPUT_checkunitno();
                }
            }
            else
            {
//                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_INPUT_save_values",
                    data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                    success: function(res) {
                        $('.preloader').hide();
                        var responsearray=JSON.parse(res);
                        BDLY_INPUT_clearalldatas(responsearray)

                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        function BDLY_INPUT_checkcardvalue()
        {
            var BDLY_INPUT_cardno= $('#BDLY_INPUT_tb_access_cardno').val();
            if(BDLY_INPUT_cardno.length==0)
                $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
            if((parseInt(BDLY_INPUT_cardno.length)>0)&&(parseInt(BDLY_INPUT_cardno.length)<4)&&(BDLY_INPUT_cardno!=""))
            {
                BDLY_INPUT_access_flag1=0;
                $('#BDLY_INPUT_lbl_pcarderrmsg').text(BDLY_INPUT_tableerrmsgarr[0].EMC_DATA).show();
            }
            else if(parseInt(BDLY_INPUT_cardno.length)>=4)
            {
                $(".preloader").show();
                BDLY_INPUT_access_flag1=1;
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_INPUT_checkcardno",
                    data:{"BDLY_INPUT_cardno":BDLY_INPUT_cardno},
                    success: function(res) {
                        $('.preloader').hide();
                        var  card_result=JSON.parse(res);
                        BDLY_INPUT_checkcard(card_result)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        }
        //CHECK THE CARD//
        function BDLY_INPUT_checkcard(card_result){
            $(".preloader").hide();
            if(card_result==true)
            {
                BDLY_INPUT_access_flag=0;
                $('#BDLY_INPUT_lbl_pcarderrmsg').text(BDLY_INPUT_tableerrmsgarr[2].EMC_DATA).show();
                $('#BDLY_INPUT_tb_access_cardno').focus()
                $('#BDLY_INPUT_tb_access_cardno').addClass('invalid')
                if((BDLY_INPUT_access_flag!=1)||(BDLY_INPUT_access_flag1==0)||($('#BDLY_INPUT_tb_access_date').val()=='')||($('#BDLY_INPUT_tb_access_cardno').val()=='')||($('#BDLY_INPUT_tb_access_invoiceamt').val()=='')||(parseFloat($('#BDLY_INPUT_tb_access_invoiceamt').val())==0)){
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            else{
                if($("#BDLY_INPUT_lbl_checkcardno").val()=="")
                {
                    $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
                    $('#BDLY_INPUT_tb_access_cardno').removeClass('invalid')
                    BDLY_INPUT_access_flag=1;
                    if((BDLY_INPUT_access_flag==1)&&(BDLY_INPUT_access_flag1!=0)&&($('#BDLY_INPUT_tb_access_date').val()!='')&&($('#BDLY_INPUT_tb_access_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_access_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_access_cardno').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                        $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
                    }
                }
                else
                {
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_INPUT_save_values",
                        data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                        success: function(res) {
                            $('.preloader').hide();
                            var responsearray=JSON.parse(res);
                            BDLY_INPUT_clearalldatas(responsearray)

                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
            }
        }
        //CLEARED ALL MULTI  ROW //
        function BDLY_INPUT_clear(BDLY_INPUT_response)
        {
            if(BDLY_INPUT_response[1]==1){
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
                var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').find('option:selected').text();
                var BDLY_INPUT_CONFSAVEMSG = BDLY_INPUT_tableerrmsgarr[3].EMC_DATA.replace('[TYPE]', BDLY_INPUT_type);
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_INPUT_CONFSAVEMSG,"success",false);
                $('#BDLY_INPUT_btn_submitbutton').hide();
                $('#BDLY_INPUT_btn_resetbutton').hide();
            }
            else{
                $(".preloader").hide();
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_INPUT_tableerrmsgarr[18].EMC_DATA+BDLY_INPUT_response[1],"success",false);
            }
            if($('#BDLY_INPUT_lb_selectexptype').val()==3)
                BDLY_INPUT_clear_unitExpanse(BDLY_INPUT_response[0]);
            if($('#BDLY_INPUT_lb_selectexptype').val()==2)
                BDLY_INPUT_clear_starhub(BDLY_INPUT_response[0]);
            if($('#BDLY_INPUT_lb_selectexptype').val()==1)
                BDLY_INPUT_clear_electricity(BDLY_INPUT_response[0]);
        }
        $('#BDLY_INPUT_radio_petty_cashin').click(function(){
            $('#BDLY_INPUT_tb_petty_cashin').show();
            $('#BDLY_INPUT_tb_petty_cashout').hide().val("");
        });
        $('#BDLY_INPUT_radio_petty_cashout').click(function(){
            $('#BDLY_INPUT_tb_petty_cashin').hide().val("");
            $('#BDLY_INPUT_tb_petty_cashout').show();
        });
        $('#BDLY_INPUT_radio_fac_deposit').click(function(){
            $('#BDLY_INPUT_tb_fac_depositamt').show();
            $('#BDLY_INPUT_tb_fac_invoiceamt').hide().val("");
        });
        $('#BDLY_INPUT_radio_fac_invoiceamt').click(function(){
            $('#BDLY_INPUT_tb_fac_depositamt').hide().val("");
            $('#BDLY_INPUT_tb_fac_invoiceamt').show();
        });
        $(".numonly").doValidation({rule:'numbersonly',prop:{realpart:7}});
//RESET ALL ELEMENT //
        $('#BDLY_INPUT_btn_resetbutton').click(function()
        {
            BDLY_INPUT_clearalldates();
        });
        //SUBMIT VALIDATION
        $(document).on("change blur",'.BDLY_INPUT_class_hksubmitvalidate', function (){
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
            if(BDLY_INPUT_type==6){
                if((BDLY_INPUT_access_flag==1)&&(BDLY_INPUT_access_flag1!=0)&&($('#BDLY_INPUT_tb_access_date').val()!='')&&($('#BDLY_INPUT_tb_access_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_access_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_access_cardno').val()!='')){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==10){
//PETTY CASH//
                if(((($('#BDLY_INPUT_tb_petty_cashin').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_petty_cashin').val())!=0))||(($('#BDLY_INPUT_tb_petty_cashout').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_petty_cashout').val())!=0)))&&($('#BDLY_INPUT_ta_petty_invoiceitem').val()!='')&&($('#BDLY_INPUT_tb_petty_date').val()!='')){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==7){
                if(($('#BDLY_INPUT_tb_mov_date').val()!='')&&($('#BDLY_INPUT_tb_mov_invoiceamt').val()!='')&&(parseInt($('#BDLY_INPUT_tb_mov_invoiceamt').val())!=0))
                {
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==11){
                var BDLY_INPUT_cleanername=$('#BDLY_INPUT_lb_house_cleanername').val();
                var BDLY_INPUT_housekeepingdate=$('#BDLY_INPUT_tb_house_date').val();
                var BDLY_INPUT_housekeepinghours=$('#BDLY_INPUT_tb_house_hours').val();
                var BDLY_INPUT_housekeepingmin=$('#BDLY_INPUT_tb_house_min').val();
                if(BDLY_INPUT_housekeepinghours==""&&BDLY_INPUT_housekeepingmin=="")
                {
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
                else
                if(BDLY_INPUT_housekeepinghours!=""||BDLY_INPUT_housekeepingmin!="")
                {
                    if((BDLY_INPUT_housekeepinghours>24)||(BDLY_INPUT_housekeepinghours==24 && BDLY_INPUT_housekeepingmin<60 && parseInt(BDLY_INPUT_housekeepingmin)!=0))
                    {
                        $('#BDLY_INPUT_tb_house_hours').addClass('invalid');
                        $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[11].EMC_DATA);
                        $('#BDLY_INPUT_lbl_hourmsg').show();
                    }
                    else
                    {
                        $('#BDLY_INPUT_tb_house_hours').removeClass('invalid');
                        $('#BDLY_INPUT_lbl_hourmsg').hide();
                    }
                    if(BDLY_INPUT_housekeepingmin>=60)
                    {
                        $('#BDLY_INPUT_tb_house_min').addClass('invalid');
                        $('#BDLY_INPUT_lbl_minmsg').text(BDLY_INPUT_tableerrmsgarr[12].EMC_DATA);
                        $('#BDLY_INPUT_lbl_minmsg').show();
                    }
                    else
                    {
                        $('#BDLY_INPUT_tb_house_min').removeClass('invalid');
                        $('#BDLY_INPUT_lbl_minmsg').hide();
                    }
                    if(BDLY_INPUT_housekeepinghours>24&&BDLY_INPUT_housekeepingmin>60)
                    {
                        if(BDLY_INPUT_housekeepinghours>24&&BDLY_INPUT_housekeepingmin>60)
                        {
                            $('#BDLY_INPUT_tb_house_hours').addClass('invalid');
                            $('#BDLY_INPUT_tb_house_min').addClass('invalid');
                            $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[11].EMC_DATA);
                            $('#BDLY_INPUT_lbl_minmsg').text(BDLY_INPUT_tableerrmsgarr[12].EMC_DATA);
                            $('#BDLY_INPUT_lbl_hourmsg').show();
                            $('#BDLY_INPUT_lbl_minmsg').show();
                        }
                        else
                        {
                            $('#BDLY_INPUT_tb_house_min').removeClass('invalid');
                            $('#BDLY_INPUT_lbl_minmsg').hide();
                            $('#BDLY_INPUT_tb_house_hours').removeClass('invalid');
                            $('#BDLY_INPUT_lbl_hourmsg').hide();
                        }
                    }
                }
                if((($('#BDLY_INPUT_tb_house_hours').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_hours').val())!=0)&&(BDLY_INPUT_housekeepinghours<=24)&&((parseInt($('#BDLY_INPUT_tb_house_min').val())==0)||($('#BDLY_INPUT_tb_house_min').val()==''))&&($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&((($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&($('.BDLY_INPUT_class_hkname').attr('id')==undefined))||(($('.BDLY_INPUT_class_hkname').attr('id')!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!=undefined)))&&($('#BDLY_INPUT_tb_house_date').val()!='')&&($('#BDLY_INPUT_ta_house_desc').val()!=''))
                    ||(($('#BDLY_INPUT_tb_house_min').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_min').val())!=0)&&(BDLY_INPUT_housekeepingmin<60)&&((parseInt($('#BDLY_INPUT_tb_house_hours').val())==0)||($('#BDLY_INPUT_tb_house_hours').val()==''))&&($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&((($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&($('.BDLY_INPUT_class_hkname').attr('id')==undefined))||(($('.BDLY_INPUT_class_hkname').attr('id')!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!=undefined)))&&($('#BDLY_INPUT_tb_house_date').val()!='')&&($('#BDLY_INPUT_ta_house_desc').val()!=''))
                    ||(($('#BDLY_INPUT_tb_house_hours').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_hours').val())!=0)&&(BDLY_INPUT_housekeepinghours<24)&&(BDLY_INPUT_housekeepingmin<60)&&($('#BDLY_INPUT_tb_house_min').val()!='')&&(parseInt($('#BDLY_INPUT_tb_house_min').val())!=0)&&($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&((($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT')&&($('.BDLY_INPUT_class_hkname').attr('id')==undefined))||(($('.BDLY_INPUT_class_hkname').attr('id')!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!='')&&($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val()!=undefined)))&&($('#BDLY_INPUT_tb_house_date').val()!='')&&($('#BDLY_INPUT_ta_house_desc').val()!=''))){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==4){
                if(($('#BDLY_INPUT_lb_unitno').val()!='SELECT')&&($('#BDLY_INPUT_tb_fac_invoicedate').val()!='')&&((($('#BDLY_INPUT_radio_fac_deposit').is(":checked")==true)&&($('#BDLY_INPUT_tb_fac_depositamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_fac_depositamt').val())!=0))||(($('#BDLY_INPUT_radio_fac_invoiceamt').is(":checked")==true)&&($('#BDLY_INPUT_tb_fac_invoiceamt').val()!='')))){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==5){
                if(($('#BDLY_INPUT_lb_digi_invoiceto').val()!='SELECT')&&($('#BDLY_INPUT_tb_digi_voiceno').val()!='')&&($('#BDLY_INPUT_tb_digi_accno').val()!='')&&($('#BDLY_INPUT_tb_digi_invoicedate').val()!='')&&($('#BDLY_INPUT_tb_digi_fromdate').val()!='')&&($('#BDLY_INPUT_tb_digi_todate').val()!='')&&($('#BDLY_INPUT_tb_digi_invoiceamt').val()!='')&&(parseInt($('#BDLY_INPUT_tb_digi_invoiceamt').val())!=0)){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==9){
                if($('#BDLY_INPUT_tb_air_date').val()!=''){
                    $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            if(BDLY_INPUT_type==12){
                var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
                if(BDLY_INPUT_unitval==''||BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
                {
                    if(BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
                    {
                        if(BDLY_INPUT_unitval.length<4)
                        {
                            $('#BDLY_INPUT_tb_pay_unitnocheck').addClass('invalid');
                            $('#BDLY_INPUT_tb_pay_unitnocheck').val('');
                            $('#BDLY_INPUT_lbl_pay_uniterrmsg').text(BDLY_INPUT_tableerrmsgarr[15].EMC_DATA).show();
                        }
                        else
                        {
                            $('#BDLY_INPUT_tb_pay_unitnocheck').removeClass('invalid');
                            $('#BDLY_INPUT_lbl_pay_uniterrmsg').hide();
                        }
                        if((BDLY_INPUT_unitval.length==4)&&($('#BDLY_INPUT_tb_pay_unitnocheck').val()!='')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                            $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                        }
                        else{
                            $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                        }
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
                var BDLY_INPUT_unitvalno=$('#BDLY_INPUT_tb_pay_unitno').val();
                if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!=undefined)
                {
                    if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!="SELECT"&&BDLY_INPUT_unitvalno!=undefined)
                    {
                        if((BDLY_INPUT_unitvalno.length==4)&&($('#BDLY_INPUT_tb_pay_unitno').val()!=''&&$('#BDLY_INPUT_tb_pay_unitno').val()!='SELECT')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                            $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                        }
                        else{
                            $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                        }
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
            }
        });
        $('#BDLY_INPUT_tb_access_cardno').change(function(){
            $('#BDLY_INPUT_lbl_checkcardno').val("");
            BDLY_INPUT_checkcardvalue();
        });
        $(document).on('change','.BDLY_INPUT_class_unit',function()
        { $(".preloader").show();
            var BDLY_INPUT_id=$(this).attr('id');
            $('#BDLY_INPUT_tb_access_cardno').removeClass('invalid')
            BDLY_INPUT_id_no =BDLY_INPUT_id.split("-");
            BDLY_INPUT_id_no=BDLY_INPUT_id_no[1]
            var BDLY_INPUT_unit = $("#"+BDLY_INPUT_id).val();
            if(BDLY_INPUT_unit=="SELECT")
            {$(".preloader").hide();
                $('#BDLY_INPUT_lb_elect_payment'+BDLY_INPUT_id_no).prop('selectedIndex',0).hide();
                $('#BDLY_INPUT_db_invoicedate'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_db_fromperiod'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_db_toperiod'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_tb_elect_amount'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_tb_elect_minusamt'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_ta_comments'+BDLY_INPUT_id_no).val('').hide();
                $('#BDLY_INPUT_tb_invoiceto'+BDLY_INPUT_id_no).hide();
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
                $('#BDLY_INPUT_add'+BDLY_INPUT_id_no).attr("disabled", "disabled");
                $('#BDLY_INPUT_del'+BDLY_INPUT_id_no).attr("disabled", "disabled");
            }
            if(BDLY_INPUT_unit!="SELECT")
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_INPUT_get_invoiceto",
                    data:{"BDLY_INPUT_unit":BDLY_INPUT_unit},
                    success: function(res) {
                        $('.preloader').hide();
                        elect_values=JSON.parse(res);
                        BDLY_INPUT_load_invoiceto(elect_values)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $('#BDLY_INPUT_btn_multisubmitbutton').click(function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $(".preloader").show();
            $.ajax({
                type: "POST",
                url: controller_url+"BDLY_INPUT_save_values",
                data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                success: function(res) {
                    $('.preloader').hide();
                    var responsearray=JSON.parse(res);
                    BDLY_INPUT_clear(responsearray)

                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        });
        //SHOWS THE CONFORMATION MESSAGE FOR AIRCON SERVICES ,CARPARK,DIGITAL VOICE,FACILITY USE,HOUSEKEEPING,HOUSEKEEPING PAYMENT,MOVING IN OUT,PETTY CASH,PURCHASE NEW ACCESS CARD//
        function BDLY_INPUT_clearalldatas(BDLY_INPUT_clearresponse)
        {
            $('textarea').height(116);
            if(BDLY_INPUT_clearresponse[1]==1){
                var BDLY_INPUT_datep = $('#BDLY_INPUT_tb_petty_date').datepicker('getDate');
                var date = new Date( Date.parse( BDLY_INPUT_clearresponse[0][1] ) );
                date.setDate( date.getDate() );
                var BDLY_INPUT_newDate = date.toDateString();
                BDLY_INPUT_newDate = new Date( Date.parse( BDLY_INPUT_newDate ) );
                $('#BDLY_INPUT_tb_petty_date').datepicker("option","minDate",BDLY_INPUT_newDate);
                var BDLY_INPUT_getoldvalue=$('#BDLY_INPUT_tb_petty_balance').val(BDLY_INPUT_clearresponse[0][0]);
                $('#BDLY_INPUT_lbl_hourmsg').hide();
                $('#BDLY_INPUT_lbl_minmsg').hide();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
                var BDLY_INPUT_listvalue=$('#BDLY_INPUT_lb_selectexptype').val();
                var BDLY_INPUT_listvalues=$('#BDLY_INPUT_lb_selectexptype').find('option:selected').text();
                var BDLY_INPUT_CONFSAVEMSG = BDLY_INPUT_tableerrmsgarr[3].EMC_DATA.replace('[TYPE]', BDLY_INPUT_listvalues);
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_INPUT_CONFSAVEMSG,"success",false);
                if(BDLY_INPUT_listvalue==9)
                {
                    $('#BDLY_INPUT_tb_air_date').val("");
                    $('#BDLY_INPUT_ta_aircon_comments').val("");
                }
                if(BDLY_INPUT_listvalue==8)
                {
                    $('#BDLY_INPUT_tb_cp_invoicedate').val("");
                    $('#BDLY_INPUT_tb_cp_fromdate').val("");
                    $('#BDLY_INPUT_tb_cp_todate').val("");
                    $('#BDLY_INPUT_tb_cp_invoiceamt').val("");
                    $('#BDLY_INPUT_ta_cp_comments').val("");
                }
                if(BDLY_INPUT_listvalue==5)
                {
                    BDLY_INPUT_load_form(BDLY_INPUT_clearresponse[0])
                    $('#BDLY_INPUT_lb_digi_invoiceto').prop('selectedIndex',0);
                    $('#BDLY_INPUT_tb_digi_invoicedate').val("");
                    $('#BDLY_INPUT_tb_digi_fromdate').val("");
                    $('#BDLY_INPUT_tb_digi_todate').val("");
                    $('#BDLY_INPUT_tb_digi_invoiceamt').val("");
                    $('#BDLY_INPUT_ta_digi_comments').val("");
                }
                if(BDLY_INPUT_listvalue==4)
                {
                    $('#BDLY_INPUT_tb_fac_invoicedate').val("");
                    $('input[name="BDLY_INPUT_radio_facility"]').prop('checked', false);
                    $('#BDLY_INPUT_tb_fac_depositamt').val("").hide();
                    $('#BDLY_INPUT_tb_fac_invoiceamt').val("").hide();
                    $('#BDLY_INPUT_ta_fac_comments').val("");
                }
                if(BDLY_INPUT_listvalue==11)
                {
                    $('#BDLY_INPUT_tble_radioclearnername').empty();
                    $('#BDLY_INPUT_ta_house_desc').val("");
                    $('#BDLY_INPUT_lb_house_cleanername').prop('selectedIndex',0);
                    $('#BDLY_INPUT_tb_house_date').val("");
                    $('#BDLY_INPUT_tb_house_hours').val("");
                    $('#BDLY_INPUT_tb_house_min').val("");
                }
                if(BDLY_INPUT_listvalue==12)
                {
                    $('#BDLY_INPUT_tb_pay_unitnocheck').val('');
                    $('#BDLY_INPUT_tb_pay_unitno').val('');
                    $('#BDLY_INPUT_tb_pay_unitno').prop('selectedIndex',0);
                    $('#BDLY_INPUT_tb_pay_invoiceamt').val('');
                    $('#BDLY_INPUT_tb_pay_forperiod').val('');
                    $('#BDLY_INPUT_tb_pay_paiddate').val('');
                    $('#BDLY_INPUT_ta_pay_comments').val('');
                    BDLY_INPUT_load_allunitnovalues=BDLY_INPUT_clearresponse[0];
                    if($('#BDLY_INPUT_btn_addbutton').val()==undefined){
                        var BDLY_INPUT_allunitno_options ='<option>SELECT</option>'
                        for (var i = 0; i < BDLY_INPUT_load_allunitnovalues.length; i++){
                            BDLY_INPUT_allunitno_options += '<option value="' + BDLY_INPUT_load_allunitnovalues[i] + '">' + BDLY_INPUT_load_allunitnovalues [i]+ '</option>';
                        }
                        $('#BDLY_INPUT_tb_pay_unitnocheck').replaceWith('<select id="BDLY_INPUT_tb_pay_unitno" name="BDLY_INPUT_tb_pay_unitno" class="BDLY_INPUT_class_hksubmitvalidate form-control" ></select>');
                        $('#BDLY_INPUT_tb_pay_unitno').html(BDLY_INPUT_allunitno_options)
                        $('#BDLY_INPUT_btn_removebutton').replaceWith('<input type="button" name="BDLY_INPUT_btn_addbutton" value="ADD" id="BDLY_INPUT_btn_addbutton" class="btn"/>');
                    }
                }
                if(BDLY_INPUT_listvalue==7)
                {
                    $('#BDLY_INPUT_tb_mov_date').val('');
                    $('#BDLY_INPUT_tb_mov_invoiceamt').val('');
                    $('#BDLY_INPUT_ta_mov_comments').val('');
                }
                if(BDLY_INPUT_listvalue==10)
                {
                    $('input[name="BDLY_INPUT_radio_petty"]').prop('checked', false);
                    $('#BDLY_INPUT_tb_petty_cashin').val("").hide();
                    $('#BDLY_INPUT_tb_petty_cashout').val("").hide();
                    $('#BDLY_INPUT_ta_petty_comments').val('');
                    $('#BDLY_INPUT_tb_petty_date').val('');
                    $('#BDLY_INPUT_ta_petty_invoiceitem').val('');
                }
                if(BDLY_INPUT_listvalue==6)
                {
                    $('#BDLY_INPUT_ta_access_comments').val('');
                    $('#BDLY_INPUT_tb_access_cardno').val('');
                    $('#BDLY_INPUT_tb_access_date').val('');
                    $('#BDLY_INPUT_tb_access_invoiceamt').val('');
                }$(".preloader").hide();
                BDLY_INPUT_setdatepick();
            }
            else{
                if(BDLY_INPUT_clearresponse[1]==0)
                    BDLY_INPUT_clearresponse[1]=BDLY_INPUT_tableerrmsgarr[18].EMC_DATA;
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_INPUT_clearresponse[1],"success",false);
            }$(".preloader").hide();
        }
        $(document).on('change','.BDLY_INPUT_uexp_class_unit',function(evnt)
        {
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $('#BDLY_INPUT_lbl_hourmsg').hide();
            var BDLY_INPUT_uexp_id=$(this).attr('id');
            BDLY_INPUT_uexp_id_no =BDLY_INPUT_uexp_id.split("-");
            BDLY_INPUT_uexp_id_no=BDLY_INPUT_uexp_id_no[1];
            $('#multiplecustomer-'+BDLY_INPUT_uexp_id_no).hide();
            $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            var BDLY_INPUT_uexp_unit = $("#"+BDLY_INPUT_uexp_id).val();
            if(BDLY_INPUT_uexp_unit=="SELECT")
            {$(".preloader").hide();
                $('#BDLY_INPUT_lb_uexp_customer'+BDLY_INPUT_uexp_id_no).prop('selectedIndex',0).hide();
                $('#BDLY_INPUT_lb_uexp_category-'+BDLY_INPUT_uexp_id_no).prop('selectedIndex',0).hide();
                $('#multiplecustomer-'+BDLY_INPUT_uexp_id_no).hide();
                $('#BDLY_INPUT_db_uexp_invoicedate'+BDLY_INPUT_uexp_id_no).val('').hide();
                $('#BDLY_INPUT_tb_uexp_invoiceitem'+BDLY_INPUT_uexp_id_no).val('').hide();
                $('#BDLY_INPUT_tb_uexp_invoicefrom'+BDLY_INPUT_uexp_id_no).val('').hide();
                $('#BDLY_INPUT_tb_uexp_amount'+BDLY_INPUT_uexp_id_no).val('').hide();
                $('#BDLY_INPUT_ta_uexpcomments'+BDLY_INPUT_uexp_id_no).val('').hide();
            }
            if(BDLY_INPUT_uexp_unit!="SELECT")
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_INPUT_get_category",
                    data:{"BDLY_INPUT_uexp_unit":BDLY_INPUT_uexp_unit},
                    success: function(res) {
                        $('.preloader').hide();
                        var uexp_values=JSON.parse(res);
                        BDLY_INPUT_load_category(uexp_values)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        var BDLY_INPUT_Array_customername=[];
//FUNCTION TO LOAD CATEGORY AND CUSTOMER NAME FOR UNIT EXPENSE //
        function BDLY_INPUT_load_category(uexp_values){
            $(".preloader").hide();
            $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            var BDLY_INPUT_customername=uexp_values[0];
            var BDLY_INPUT_unitstartenddate=uexp_values[1];
            BDLY_INPUT_customername_array=BDLY_INPUT_customername;
            BDLY_INPUT_unitenddate=BDLY_INPUT_unitstartenddate.unitedate;
            BDLY_INPUT_unitstartdate=BDLY_INPUT_unitstartenddate.unitsdate;
            BDLY_INPUT_unitinvdate=BDLY_INPUT_unitstartenddate.invdate;
            var BDLY_INPUT_category_options =''
            var expense_id=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_id;
            var expense_Data=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_date;
            for (var i = 0; i <expense_id.length ; i++) {
                var PDLY_INPUT_gettypofexpensevalues=BDLY_INPUT_exptype_array[i]
                if(i>=12 && i<=14)
                {
                    BDLY_INPUT_category_options += '<option value="' + expense_id[i] + '">' +expense_Data[i]+ '</option>';
                }
            }
            $('#BDLY_INPUT_lb_uexp_category-'+BDLY_INPUT_uexp_id_no).html(BDLY_INPUT_category_options);
            BDLY_INPUT_Sortit('BDLY_INPUT_lb_uexp_category-'+BDLY_INPUT_uexp_id_no);
            $('#BDLY_INPUT_lb_uexp_category-'+BDLY_INPUT_uexp_id_no).show();
            $('#BDLY_INPUT_db_uexp_invoicedate'+BDLY_INPUT_uexp_id_no).val('').show();
            $('#BDLY_INPUT_tb_uexp_invoiceitem'+BDLY_INPUT_uexp_id_no).val('').show();
            $('#BDLY_INPUT_tb_uexp_invoicefrom'+BDLY_INPUT_uexp_id_no).val('').show();
            var BDLY_INPUT_name_options ='<option>SELECT</option>';
            BDLY_INPUT_Array_customername=BDLY_INPUT_customername;
            var BDLY_INPUT_arr_customername=[];
            for (var i = 0; i < BDLY_INPUT_customername.length; i++) {
                BDLY_INPUT_arr_customername[i]=BDLY_INPUT_customername[i].BDLY_INPUT_custname;
            }
            var BDLY_INPUT_unique_customer=[];
            BDLY_INPUT_unique_customer=STDLY_INPUT_unique(BDLY_INPUT_arr_customername);
            for (var i = 0; i < BDLY_INPUT_unique_customer.length; i++) {
                BDLY_INPUT_name_options += '<option value="' + BDLY_INPUT_unique_customer[i] + '">' + BDLY_INPUT_unique_customer[i] + '</option>';
            }
            $('#BDLY_INPUT_tb_uexp_amount'+BDLY_INPUT_uexp_id_no).val('').show();
            $('#BDLY_INPUT_lb_uexp_customer'+BDLY_INPUT_uexp_id_no).html(BDLY_INPUT_name_options).hide();
            $('#BDLY_INPUT_ta_uexpcomments'+BDLY_INPUT_uexp_id_no).val('').show();
            uexp_submultivalidfun();
            BDLY_INPUT_setdatepick();
            BDLY_INPUT_unit_autocomplete(BDLY_INPUT_uexp_id_no);
        }
        $(document).on('change','.BDLY_INPUT_class_star_unit',function()
        {
            var BDLY_INPUT_star_id=$(this).attr('id');
            BDLY_INPUT_star_id_no =BDLY_INPUT_star_id.split("-");
            BDLY_INPUT_star_id_no=BDLY_INPUT_star_id_no[1]
            var BDLY_INPUT_star_unit = $("#"+BDLY_INPUT_star_id).val();
            if(BDLY_INPUT_star_unit=="SELECT")
            {$(".preloader").hide();
                $('#BDLY_INPUT_lb_star_invoice-'+BDLY_INPUT_star_id_no).hide();
                $('#BDLY_INPUT_tb_star_accno'+BDLY_INPUT_star_id_no).hide();
                $('#BDLY_INPUT_db_star_invoicedate'+BDLY_INPUT_star_id_no).hide();
                $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).hide();
                $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).hide();
                $('#BDLY_INPUT_tb_star_amount'+BDLY_INPUT_star_id_no).hide();
                $('#BDLY_INPUT_ta_star_comments'+BDLY_INPUT_star_id_no).hide();
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
                $('#BDLY_INPUT_star_add'+BDLY_INPUT_id_no).attr("disabled", "disabled");
                $('#BDLY_INPUT_star_del'+BDLY_INPUT_id_no).attr("disabled", "disabled");
            }
            if(BDLY_INPUT_star_unit!="SELECT")
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_INPUT_get_accno",
                    data:{"BDLY_INPUT_star_unit":BDLY_INPUT_star_unit},
                    success: function(res) {
                        $('.preloader').hide();
                        var starhub_vlaues=JSON.parse(res);
                        BDLY_INPUT_load_accno(starhub_vlaues)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        //FUNCTION TO LOAD STAR HUB VALUES//
        function BDLY_INPUT_load_accno(starhub_vlaues){
            $(".preloader").hide();
            $('#BDLY_INPUT_lb_star_invoice-1').show();
            $('#BDLY_INPUT_tb_star_accno1').show();
            var BDLY_INPUT_accno=starhub_vlaues[0];
            var BDLY_INPUT_invoiceto=starhub_vlaues[1];
            var BDLY_INPUT_starsedate=starhub_vlaues[3];
            BDLY_INPUT_unitenddate=BDLY_INPUT_starsedate.unitedate;
            BDLY_INPUT_unitstartdate=BDLY_INPUT_starsedate.unitsdate;
            BDLY_INPUT_unitinvdate=BDLY_INPUT_starsedate.invdate;
            BDLY_INPUT_setdatepick();
            $('#BDLY_INPUT_db_star_invoicedate'+BDLY_INPUT_star_id_no).val('').show();
            $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).val('').show();
            $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).val('').show();
            $('#BDLY_INPUT_hidden_star_ecnid'+BDLY_INPUT_star_id_no).val('');
            $('#BDLY_INPUT_tb_star_accno'+BDLY_INPUT_star_id_no).show();
            var BDLY_INPUT_accnolen=(BDLY_INPUT_accno).length;
            $('#BDLY_INPUT_tb_star_accno'+BDLY_INPUT_star_id_no).attr("size",BDLY_INPUT_accnolen+2);
            $('#BDLY_INPUT_tb_star_accno'+BDLY_INPUT_star_id_no).val(BDLY_INPUT_accno).show();
            $('#BDLY_INPUT_tb_star_amount'+BDLY_INPUT_star_id_no).val('').show();
            $('#BDLY_INPUT_ta_star_comments'+BDLY_INPUT_star_id_no).val('').show();
            $('#BDLY_INPUT_lb_star_invoice-'+BDLY_INPUT_star_id_no).show();
            if((BDLY_INPUT_invoiceto!="")&&(BDLY_INPUT_invoiceto!=null))
            {
                var values="<table><tr><td><input type='text' class='rdonly form-control' id='BDLY_INPUT_lb_star_invoice-"+BDLY_INPUT_star_id_no+"' name='BDLY_INPUT_lb_star_invoiceto' value='"+BDLY_INPUT_invoiceto+"'   readonly  ></td></tr></table>"
                $('#BDLY_INPUT_hidden_star_ecnid'+BDLY_INPUT_star_id_no).val(starhub_vlaues[2])
                $('#BDLY_INPUT_lb_star_invoice-'+BDLY_INPUT_star_id_no).replaceWith(values)
                var BDLY_INPUT_invoicetoval=(BDLY_INPUT_invoiceto).length;
                $('#BDLY_INPUT_lb_star_invoice-'+BDLY_INPUT_star_id_no).attr("size",BDLY_INPUT_invoicetoval+4);
            }
            else{
                var BDLY_INPUT_options =''
                var expense_id=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_id;
                var expense_Data=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_date;
                 for (var i = 0; i <expense_id.length ; i++) {
                    var PDLY_INPUT_gettypofexpensevalues=BDLY_INPUT_exptype_array[i]
                    if(i>=16 && i<=18)
                    {
                        BDLY_INPUT_options += '<option value="' + expense_id[i] + '">' + expense_Data[i]+ '</option>';
                    }
                }
                var values="<table><tr><td> <select  class='BDLY_INPUT_class_star_invoice star_submultivalid form-control'  name='BDLY_INPUT_lb_star_invoiceto' id='BDLY_INPUT_lb_star_invoice-"+BDLY_INPUT_star_id_no+"' >"+BDLY_INPUT_options+"</select></td></tr></table>"
                $('#BDLY_INPUT_lb_star_invoice-'+BDLY_INPUT_star_id_no).replaceWith(values);
                BDLY_INPUT_Sortit('BDLY_INPUT_lb_star_invoice-'+BDLY_INPUT_star_id_no);
            }
            $('#BDLY_INPUT_lb_star_invoice-'+BDLY_INPUT_star_id_no).show();
            /*----------------------------------------CHANGE FUNCTION FOR STARHUB INVOICE TO--------------------------------------*/
            $(document).on('change','.BDLY_INPUT_class_star_invoice',function() {
                $('#BDLY_INPUT_hidden_star_ecnid'+BDLY_INPUT_star_id_no).val('');
                if($(this).val()!='SELECT')
                    $('#BDLY_INPUT_hidden_star_ecnid'+BDLY_INPUT_star_id_no).val($('#BDLY_INPUT_lb_star_invoice-'+BDLY_INPUT_star_id_no).val())
            });
            BDLY_INPUT_func_starhubperiod();
        }
        //FUNCTION FOR STARHUB FROM ADN TO PERIOD VALIDATION
        function BDLY_INPUT_func_starhubperiod(){
            $("#BDLY_INPUT_db_star_invoicedate"+BDLY_INPUT_star_id_no).datepicker({
                dateFormat: "dd-mm-yy",  changeYear: true, changeMonth: true});
//DATE PICKER FUNCTION FOR FROM DATE..............
            $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_fromdate = $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                    date.setDate( date.getDate()  ); //+ 1
                    var PDLY_INPUT_newDate = date.toDateString();
                    PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                    var BDLY_INPUT_smonth=date.getMonth()+3;
                    var BDLY_INPUT_syear=date.getFullYear();
                    var BDLY_INPUT_startdate = new Date(BDLY_INPUT_syear,BDLY_INPUT_smonth);
                    var enddate=new Date(BDLY_INPUT_startdate.getFullYear(),BDLY_INPUT_startdate.getMonth(),BDLY_INPUT_startdate.getDate()-1);
                    var BDLY_INPUT_enddate=new Date(Date.parse(BDLY_INPUT_unitenddate));
                    var BDLY_INPUT_sh_maxdate='';
                    if(enddate>BDLY_INPUT_enddate)
                        BDLY_INPUT_sh_maxdate=BDLY_INPUT_enddate;
                    else
                        BDLY_INPUT_sh_maxdate=enddate;
                    $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker("option","minDate",PDLY_INPUT_newDate);
                    $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker("option","maxDate",BDLY_INPUT_sh_maxdate);
                    star_submultivalidvalidation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
            //DATE PICKER FOR TO DATE ..................
            $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_fromdate = $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                    date.setDate( date.getDate()  ); //+ 1
                    var newDate = date.toDateString();
                    newDate = new Date( Date.parse( newDate ) );
                    $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker("option","minDate",newDate);
                    star_submultivalidvalidation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
        }
        //ADDING NEW ROW IN UNIT EXPENSE
        $(document).on('click','.uexp_addbttn',function() {
            var table = document.getElementById('BDLY_INPUT_tble_unitexpense');
            var rowCount = table.rows.length;
            BDLY_INPUT_arraylength=0;
            newid =rowCount;
            var newid1=newid-1;
            $('#BDLY_INPUT_uexp_add'+newid1).hide();
            $('#BDLY_INPUT_uexp_del'+newid1).hide();
            var newRow = table.insertRow(rowCount);
            var oCell = newRow.insertCell(0);
            oCell.innerHTML = "<select  class='BDLY_INPUT_uexp_class_unit uexp_submultivalid form-control' name ='BDLY_INPUT_lb_uexp_unit[]' id='"+"BDLY_INPUT_lb_uexp_unit-"+newid+"' style='display:none; width:90px;' hidden  >";
            oCell = newRow.insertCell(1);
            oCell.innerHTML ="<select  name='BDLY_INPUT_lb_uexp_category[]' class='uexp_submultivalid BDLY_INPUT_uexp_class_category form-control' id='"+"BDLY_INPUT_lb_uexp_category-"+newid+"' style='display:none;width:140px;' hidden><option value='' >SELECT</option></select>";
            oCell = newRow.insertCell(2);
            oCell.innerHTML ="<select name='BDLY_INPUT_lb_uexp_customer[]' class='uexp_submultivalid BDLY_INPUT_uexp_class_custname form-control' id='"+"BDLY_INPUT_lb_uexp_customer"+newid+"'  style='display:none;width:160px' hidden><option value='' >SELECT</option></select>";
            oCell = newRow.insertCell(3);
            oCell.innerHTML ="<table id='"+"multiplecustomer-"+newid+"' width='250px' hidden></table>"
            oCell = newRow.insertCell(4);
            oCell.innerHTML ="<input class='datepickdate uexp_submultivalid datemandtry form-control'  type='text' name ='BDLY_INPUT_db_uexp_invoicedate[]' id='"+"BDLY_INPUT_db_uexp_invoicedate"+newid+"' style='width:100px;display:none;' hidden/> ";
            $( ".datepickdate" ).datepicker({dateFormat:'dd-mm-yy', changeYear: true, changeMonth: true, onSelect: function(date){
                uexp_submultivalidfun();
                BDLY_INPUT_setdatepick();
            },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
            oCell = newRow.insertCell(5);
            oCell.innerHTML ="<textarea class='uexp_submultivalid form-control'  name ='BDLY_INPUT_tb_uexp_invoiceitem[]' id='"+"BDLY_INPUT_tb_uexp_invoiceitem"+newid+"' style='display:none;min-height:100px;width:180px;' hidden/></textarea> ";
            oCell = newRow.insertCell(6);
            oCell.innerHTML ="<input  class='uexp_submultivalid autosize autocomplete form-control'  type='text' name ='BDLY_INPUT_tb_uexp_invoicefrom[]' id='"+"BDLY_INPUT_tb_uexp_invoicefrom"+newid+"' maxlength='200'  style='display:none;' hidden/> ";
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
            oCell = newRow.insertCell(7);
            oCell.innerHTML ="<input  class='amtonlyfivedigit uexp_submultivalid form-control' type='text' name ='BDLY_INPUT_tb_uexp_amount[]' id='"+"BDLY_INPUT_tb_uexp_amount"+newid+"' style='width:65px;display:none;' hidden /> ";
            $(".amtonlyfivedigit").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
            oCell = newRow.insertCell(8);
            oCell.innerHTML = "<textarea row='2' class=' uexp_submultivalid form-control' name ='BDLY_INPUT_ta_uexpcomments[]' id='"+"BDLY_INPUT_ta_uexpcomments"+newid+"' style='display:none;min-height:100px;width:180px;' hidden></textarea>";
            oCell = newRow.insertCell(9);
            oCell.innerHTML = "<input type='button' value='+' class='uexp_addbttn' alt='Add Row' height='30' width='30' name ='BDLY_INPUT_uexp_add[]' id='"+"BDLY_INPUT_uexp_add"+newid+"' disabled>";
            oCell = newRow.insertCell(10);
            oCell.innerHTML = "<input  type='button' value='-' class='uexp_deletebttn' alt='delete Row' height='30' width='30' name ='BDLY_INPUT_uexp_delete[]' id='"+"BDLY_INPUT_uexp_del"+newid+"' >";
            oCell = newRow.insertCell(11);
            oCell.innerHTML ="<input  type='text' name ='BDLY_INPUT_tb_uexp_hideradioid[]' id='"+"BDLY_INPUT_tb_uexp_hideradioid"+newid+"' style='width:75px;' hidden/> ";
            $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            BDLY_INPUT_loadmulti_unitno(BDLY_INPUT_unitno);
        });
        $(document).on('change','.BDLY_INPUT_uexp_class_custname',function() {
            var BDLY_INPUT_id=$(this).attr('id');
            var BDLY_INPUT_custgblid1 =BDLY_INPUT_id.replace( /^\D+/g, '');
            $('#multiplecustomer-'+BDLY_INPUT_custgblid1).hide();
            var BDLY_INPUT_custvalue=$('#BDLY_INPUT_lb_uexp_customer'+BDLY_INPUT_custgblid1).val();
            $('#BDLY_INPUT_tb_uexp_hideradioid'+BDLY_INPUT_custgblid1).val('')
            if(BDLY_INPUT_custvalue=="SELECT")
            {
                $('#multiplecustomer-'+BDLY_INPUT_custgblid1).hide();
            }
            var BDLY_INPUT_unit=$('#BDLY_INPUT_lb_uexp_unit-'+BDLY_INPUT_uexp_id_no).val();
            var BDLY_INPUT_custresult=[];
            BDLY_INPUT_custresult[0]=BDLY_INPUT_Array_customername;
            BDLY_INPUT_custresult[1]=BDLY_INPUT_custgblid1;
            BDLY_INPUT_custresult[2]=BDLY_INPUT_unit;
            BDLY_INPUT_custresult[3]=BDLY_INPUT_custvalue;
            BDLY_INPUT_custvalidationresult(BDLY_INPUT_custresult)
        });
        function BDLY_INPUT_custvalidationresult(BDLY_INPUT_custresult)
        {
            $('#BDLY_INPUT_hidden_customerid').val('')
            var BDLY_INPUT_arr_customername=[];
            for(var k=0;k<BDLY_INPUT_Array_customername.length;k++)
            {
                if(BDLY_INPUT_Array_customername[k].BDLY_INPUT_custname==BDLY_INPUT_custresult[3])
                {
                    BDLY_INPUT_arr_customername.push(BDLY_INPUT_Array_customername[k])
                }
            }
            $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            var BDLY_INPUT_multiple_row_array=BDLY_INPUT_arr_customername;
            var BDLY_INPUT_id=BDLY_INPUT_custresult[1];
            $("#multiplecustomer-"+BDLY_INPUT_id+" tr").remove();
            BDLY_INPUT_arraylength=BDLY_INPUT_multiple_row_array.length;
            for (var i=0;i<BDLY_INPUT_multiple_row_array.length;i++)
            {
                var BDLY_INPUT_tablerowid=i+'_'+BDLY_INPUT_id
                var BDLY_INPUT_customername_id=BDLY_INPUT_multiple_row_array[i];
                var BDLY_INPUT_customer_nameid=BDLY_INPUT_customername_id.BDLY_INPUT_custname+' '+BDLY_INPUT_customername_id.BDLY_INPUT_custid;
                var BDLY_INPUT_unitid_custid=BDLY_INPUT_custresult[2]+'-'+BDLY_INPUT_customername_id.BDLY_INPUT_custid+'-'+BDLY_INPUT_id+'-'+i+'-'+BDLY_INPUT_arraylength;
                var BDLY_INPUT_idlen=(BDLY_INPUT_customer_nameid).length;
                $('#multiplecustomer-'+BDLY_INPUT_uexp_id_no).attr("size",BDLY_INPUT_idlen+4);
                var BDLY_INPUT_uexp_id_decrease0ne=BDLY_INPUT_uexp_id_no-1;
                var name="customerid"+BDLY_INPUT_uexp_id_decrease0ne;
                var id="customerids-"+i;
                var CRCHK_value ='<tr><td ><input type="radio" class="uexp_submultivalid setvalue" value='+BDLY_INPUT_customername_id.BDLY_INPUT_custid+' id='+id+' name='+name+'  />' + BDLY_INPUT_customer_nameid + '</td><td ><input type="hidden" name="customerids+'+BDLY_INPUT_uexp_id_no+'" id="customerid-'+BDLY_INPUT_tablerowid+'"</td></tr>';
                $('#multiplecustomer-'+BDLY_INPUT_id).append(CRCHK_value);
            }
            if(BDLY_INPUT_multiple_row_array.length!=1)
            {
                $('#BDLY_INPUT_lbl_uexp_customerid').show();
                $('#multiplecustomer-'+BDLY_INPUT_id).show();
                if(BDLY_INPUT_multiple_row_array.length==0)
                {
                    $('#multiplecustomer-'+BDLY_INPUT_id).hide();
                    $('#BDLY_INPUT_lbl_uexp_customerid').hide();
                }
            }
            else
            {
                $('#BDLY_INPUT_tb_uexp_hideradioid'+BDLY_INPUT_id).val(BDLY_INPUT_multiple_row_array[0].BDLY_INPUT_custid)
                $('#multiplecustomer-'+BDLY_INPUT_id).hide();
                $('#BDLY_INPUT_lbl_uexp_customerid').hide();
            }
        }
        //CLICK FUNCTION FOR MULTIPLE CUSTOMER
        $(document).on('click','.setvalue',function() {
            var BDLY_INPUT_getrdoval=$(this).val();
            $('#BDLY_INPUT_tb_uexp_hideradioid'+BDLY_INPUT_uexp_id_no).val(BDLY_INPUT_getrdoval);
        });
        $(document).on('change','.BDLY_INPUT_uexp_class_category',function() {
            var BDLY_INPUT_id=$(this).attr('id');
            var BDLY_INPUT_id1 =BDLY_INPUT_id.split("-");
            BDLY_INPUT_id1=BDLY_INPUT_id1[1]
            $('#multiplecustomer-'+BDLY_INPUT_id1).hide();
            var value=$('#BDLY_INPUT_lb_uexp_category-'+BDLY_INPUT_id1).val();
            if(value==23)
            {
                if(BDLY_INPUT_customername_array.length!=0){
                    $('#BDLY_INPUT_lb_uexp_customer'+BDLY_INPUT_id1).show();
                    $('#BDLY_INPUT_lbl_uexp_customer').show();
                }
                else{
                    $('#BDLY_INPUT_lb_uexp_unit-1').show();
                    $('#BDLY_INPUT_lb_uexp_category-'+BDLY_INPUT_id1).prop('selectedIndex',0).show();
                    $('#BDLY_INPUT_db_uexp_invoicedate'+BDLY_INPUT_id1).val('').hide();
                    $('#BDLY_INPUT_tb_uexp_invoiceitem'+BDLY_INPUT_id1).val('').hide();
                    $('#BDLY_INPUT_tb_uexp_invoicefrom'+BDLY_INPUT_id1).val('').hide();
                    $('#BDLY_INPUT_tb_uexp_amount'+BDLY_INPUT_id1).val('').hide();
                    $('#BDLY_INPUT_ta_uexpcomments'+BDLY_INPUT_id1).val('').hide();
                    var BDLY_INPUT_unitvals= $('#BDLY_INPUT_lb_uexp_unit-'+BDLY_INPUT_id1).val();
                    var BDLY_INPUT_uniterrmesg = BDLY_INPUT_tableerrmsgarr[13].EMC_DATA.replace('[UNIT NO]', BDLY_INPUT_unitvals);
                    $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_uniterrmesg);
                    $('#BDLY_INPUT_lbl_hourmsg').show();
                    $('#BDLY_INPUT_lb_uexp_customer'+BDLY_INPUT_id1).prop('selectedIndex',0).hide();
                }
            }
            else{
                $('#BDLY_INPUT_lb_uexp_customer'+BDLY_INPUT_id1).prop('selectedIndex',0).hide();
                $('#BDLY_INPUT_db_uexp_invoicedate'+BDLY_INPUT_id1).show();
                $('#BDLY_INPUT_tb_uexp_invoiceitem'+BDLY_INPUT_id1).show();
                $('#BDLY_INPUT_tb_uexp_invoicefrom'+BDLY_INPUT_id1).show();
                $('#BDLY_INPUT_tb_uexp_amount'+BDLY_INPUT_id1).show();
                $('#BDLY_INPUT_ta_uexpcomments'+BDLY_INPUT_id1).show();
                $('#BDLY_INPUT_lbl_hourmsg').hide();
            }
        });
        //ADDING NEW ROW IN STAR HUB//
        $(document).on('click','.star_addbttn',function() {
            var table = document.getElementById('BDLY_INPUT_tble_starhub');
            var rowCount = table.rows.length;
            newid =rowCount;
            var newid1=newid-1;
            $('#BDLY_INPUT_star_add'+newid1).hide();
            $('#BDLY_INPUT_star_del'+newid1).hide();
            var newRow = table.insertRow(rowCount);
            var oCell = newRow.insertCell(0);
            oCell.innerHTML = "<select class='BDLY_INPUT_class_star_unit star_submultivalid form-control' style='display: none;' name ='BDLY_INPUT_lb_star_unit[]' id='"+"BDLY_INPUT_lb_star_unit-"+newid+"'   hidden  >";
            oCell = newRow.insertCell(1);
            oCell.innerHTML ="<select readonly  class='rdonly BDLY_INPUT_class_star_invoice star_submultivalid form-control'  style='display: none;' name='BDLY_INPUT_lb_star_invoiceto[]' id='"+"BDLY_INPUT_lb_star_invoice-"+newid+"' hidden><option value=''>SELECT</option></select><input type='hidden' id='"+"BDLY_INPUT_hidden_star_ecnid"+newid+"' name='BDLY_INPUT_hidden_star_ecnid[]'>";
            oCell = newRow.insertCell(2);
            oCell.innerHTML ="<input class='rdonly star_submultivalid form-control ' style='display: none;' type='text' name ='BDLY_INPUT_tb_star_accno[]' id='"+"BDLY_INPUT_tb_star_accno"+newid+"'  readonly hidden /> ";
            oCell = newRow.insertCell(3);
            oCell.innerHTML ="<input  class='starvalidatepickdate star_submultivalid datemandtry form-control'  type='text' name ='BDLY_INPUT_db_star_invoicedate[]' id='"+"BDLY_INPUT_db_star_invoicedate"+newid+"' style='width:100px;display:none;' hidden /> ";
            oCell = newRow.insertCell(4);
            oCell.innerHTML ="<input  class='starvalidatepickdate star_submultivalid datemandtry form-control'  type='text' name ='BDLY_INPUT_db_star_fromperiod[]' id='"+"BDLY_INPUT_db_star_fromperiod"+newid+"' style='width:100px;display:none;' hidden/> ";
            oCell = newRow.insertCell(5);
            oCell.innerHTML ="<input  class='starvalidatepickdate star_submultivalid datemandtry form-control'  type='text' name ='BDLY_INPUT_db_star_toperiod[]' id='"+"BDLY_INPUT_db_star_toperiod"+newid+"' style='width:100px;display:none;' hidden/> ";
            $(document).on('blur','.starvalidatepickdate',function() {
                star_submultivalidvalidation();
            });
            //DATEPICKER FOR STAR HUB  DATE BOX//
            $("#BDLY_INPUT_db_star_invoicedate"+BDLY_INPUT_star_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    star_submultivalidvalidation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
            //DATE PICKER FUNCTION FOR FROM DATE..............
            $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_fromdate = $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                    date.setDate( date.getDate()  ); //+ 1
                    var PDLY_INPUT_newDate = date.toDateString();
                    PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                    $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker("option","minDate",PDLY_INPUT_newDate);
                    star_submultivalidvalidation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
//DATE PICKER FOR TO DATE ..................
            $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_fromdate = $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                    date.setDate( date.getDate()  ); //+ 1
                    var newDate = date.toDateString();
                    newDate = new Date( Date.parse( newDate ) );
                    $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker("option","minDate",newDate);
                    star_submultivalidvalidation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }
            });
            oCell = newRow.insertCell(6);
            oCell.innerHTML ="<input  class='includeminusfour star_submultivalid form-control' type='text' name ='BDLY_INPUT_tb_star_amount[]' id='"+"BDLY_INPUT_tb_star_amount"+newid+"' style='width:90px;display:none;' maxlength=4 hidden /> ";
            $('.includeminusfour').doValidation({rule:'numbersonly',prop:{integer:true,realpart:4,imaginary:2}});
            oCell = newRow.insertCell(7);
            oCell.innerHTML = "<textarea row='3' class=' star_submultivalid form-control' name ='BDLY_INPUT_ta_star_comments[]' style='display: none;min-height:100px;width:180px;' id='"+"BDLY_INPUT_ta_star_comments"+newid+"' hidden></textarea>";
            oCell = newRow.insertCell(8);
            oCell.innerHTML = "<input type='button' value='+' class='star_addbttn' alt='Add Row' height='30' width='30' name ='BDLY_INPUT_star_add[]' id='"+"BDLY_INPUT_star_add"+newid+"' disabled>";
            oCell = newRow.insertCell(9);
            oCell.innerHTML = "<input  type='button' value='-' class='star_deletebttn' alt='delete Row' height='30' width='30' name ='BDLY_INPUT_star_delete[]' id='"+"BDLY_INPUT_star_del"+newid+"' >";
            $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            BDLY_INPUT_loadmulti_unitno(BDLY_INPUT_unitno);
            $(document).on('blur','.star_submultivalid',function() {
                star_submultivalidvalidation();
            });
        });
        $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        $(document).on("change",'.amtonlyvalidation', function (){
            var BDLY_INPUT_id=$(this).attr('id');
            var BDLY_INPUT_elemtid =BDLY_INPUT_id.replace( /^\D+/g, '');
            var BDLY_INPUT_paymentval=$('#BDLY_INPUT_lb_elect_payment'+BDLY_INPUT_elemtid).val();
            $('#BDLY_INPUT_hidden_amt_elec'+BDLY_INPUT_elemtid).val('')
            if(BDLY_INPUT_paymentval==134||BDLY_INPUT_paymentval==133)
            {
                $("#BDLY_INPUT_tb_elect_minusamt"+BDLY_INPUT_elemtid).doValidation({rule:'numbersonly',prop:{integer:true,realpart:3,imaginary:2}});
                $('#BDLY_INPUT_hidden_amt_elec'+BDLY_INPUT_elemtid).val($("#BDLY_INPUT_tb_elect_minusamt"+BDLY_INPUT_elemtid).val())
            }
            else
            {
                $("#BDLY_INPUT_tb_elect_amount"+BDLY_INPUT_elemtid).doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
                $('#BDLY_INPUT_hidden_amt_elec'+BDLY_INPUT_elemtid).val($("#BDLY_INPUT_tb_elect_amount"+BDLY_INPUT_elemtid).val())
            }
            BDLY_INPUT_electricityvaliation();
        });
        $("#BDLY_INPUT_db_invoicedate1").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_datep = $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_datep ) );
                date.setDate( date.getDate() );
                var PDLY_INPUT_newDate = date.toDateString();
                PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",PDLY_INPUT_newDate);
                $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",PDLY_INPUT_newDate);
                BDLY_INPUT_electricityvaliation();
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
        //DATE PICKER FUNCTION FOR FROM DATE..............
        $("#BDLY_INPUT_db_fromperiod1").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_fromdate = $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                date.setDate( date.getDate()  ); //+ 1
                var PDLY_INPUT_newDate = date.toDateString();
                PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","minDate",PDLY_INPUT_newDate);
                var paiddate = $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker('getDate');
                var date = new Date( Date.parse( paiddate ) );
                date.setDate( date.getDate()  );
                var paidnewDate = date.toDateString();
                paidnewDate = new Date( Date.parse( paidnewDate ) );
                $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",paidnewDate);
                BDLY_INPUT_electricityvaliation();
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
        //DATE PICKER FOR TO DATE ..................
        $("#BDLY_INPUT_db_toperiod1").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_fromdate = $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                date.setDate( date.getDate()  ); //+ 1
                var newDate = date.toDateString();
                newDate = new Date( Date.parse( newDate ) );
                $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","minDate",newDate);
                var PDLY_INPUT_paiddate = $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_paiddate ) );
                date.setDate( date.getDate() ); // - 1
                var PDLY_INPUT_paidnewDate = date.toDateString();
                PDLY_INPUT_paidnewDate = new Date( Date.parse( PDLY_INPUT_paidnewDate ) );
                $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",PDLY_INPUT_paidnewDate);
                BDLY_INPUT_electricityvaliation();
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
        //DELETE ROW IN UNIT EXPENSE//
        $(document).on('click','.uexp_deletebttn',function() {
            var table = document.getElementById('BDLY_INPUT_tble_unitexpense');
            if(table.rows.length>2)
                $(this).closest("tr").remove();
            var BDLY_INPUT_table = document.getElementById('BDLY_INPUT_tble_unitexpense');
            var BDLY_INPUT_table_rowlength=BDLY_INPUT_table.rows.length;
            var BDLY_INPUT_lastrowid=BDLY_INPUT_table_rowlength-1;
            $('#BDLY_INPUT_uexp_add'+BDLY_INPUT_lastrowid).show();
            $('#BDLY_INPUT_uexp_del'+BDLY_INPUT_lastrowid).show();
            var count=0;
            for(var i=1;i<=BDLY_INPUT_table_rowlength;i++)
            {
                var unit=$('#BDLY_INPUT_lb_uexp_unit-'+i).val()
                var category=$('#BDLY_INPUT_lb_uexp_category-'+i).val()
                var customer=$('#BDLY_INPUT_lb_uexp_customer'+i).val()
                var invoiceitem=$('#BDLY_INPUT_tb_uexp_invoiceitem'+i).val()
                var invoicedate=$('#BDLY_INPUT_db_uexp_invoicedate'+i).val()
                var invoicefrom=$('#BDLY_INPUT_tb_uexp_invoicefrom'+i).val()
                var amount=$('#BDLY_INPUT_tb_uexp_amount'+i).val()
                if((unit!=undefined)&&(category!=undefined)&&(unit!="SELECT")&&(category!="SELECT")&&(unit!='')&&(category!='')&&(amount!="")&&(parseInt(amount)!=0)&&(invoicedate!="")&&(invoiceitem!="")&&(amount!=undefined)&&(invoiceitem!=undefined)&&(invoicedate!=undefined)&&(invoicefrom!='')&&(invoicefrom!=undefined))
                {
                    if(category==23){
                        if((customer!=undefined)&&(customer!="SELECT")){
                            count=count+1;
                        }
                    }
                    else{
                        count=count+1;
                    }
                }
            }
            if(count==BDLY_INPUT_table_rowlength-1)
            {
                $('#BDLY_INPUT_uexp_add'+BDLY_INPUT_lastrowid).removeAttr("disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').removeAttr("disabled");
            }
            else
            {
                $('#BDLY_INPUT_uexp_add'+BDLY_INPUT_lastrowid).attr("disabled", "disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            }
        });
        //DELETE ROW IN STAR HUB//
        $(document).on('click','.star_deletebttn',function() {
            var table = document.getElementById('BDLY_INPUT_tble_starhub');
            if(table.rows.length>2)
                $(this).closest("tr").remove();
            var BDLY_INPUT_table = document.getElementById('BDLY_INPUT_tble_starhub');
            var BDLY_INPUT_table_rowlength=BDLY_INPUT_table.rows.length;
            var BDLY_INPUT_lastrowid=BDLY_INPUT_table_rowlength-1;
            $('#BDLY_INPUT_star_add'+BDLY_INPUT_lastrowid).show();
            $('#BDLY_INPUT_star_del'+BDLY_INPUT_lastrowid).show();
            var count=0;
            for(var i=1;i<=BDLY_INPUT_table_rowlength;i++)
            {
                var unit=$('#BDLY_INPUT_lb_star_unit-'+i).val()
                var invoicedate=$('#BDLY_INPUT_db_star_invoicedate'+i).val()
                var fromdate=$('#BDLY_INPUT_db_star_fromperiod'+i).val()
                var todate=$('#BDLY_INPUT_db_star_toperiod'+i).val()
                var invoiceto=$('#BDLY_INPUT_lb_star_invoice-'+i).val()
                var amount=$('#BDLY_INPUT_tb_star_amount'+i).val()
                if((unit!=undefined)&&(invoiceto!=undefined)&&(unit!="SELECT")&&(invoiceto!="SELECT")&&(unit!='')&&(invoiceto!='')&&(amount!="")&&(parseInt(amount)!=0)&&(fromdate!="")&&(todate!="")&&(amount!=undefined)&&(fromdate!=undefined)&&(todate!=undefined)&&(invoicedate!=''))
                {
                    count=count+1;
                }
            }
            if(count==BDLY_INPUT_table_rowlength-1)
            {
                $('#BDLY_INPUT_star_add'+BDLY_INPUT_lastrowid).removeAttr("disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').removeAttr("disabled");
            }
            else
            {
                $('#BDLY_INPUT_star_add'+BDLY_INPUT_lastrowid).attr("disabled", "disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            }
        });
        //SUBMIT BUTTON VALIDATION FOR UNIT EXPENSE//
        $(document).on('blur','.uexp_submultivalid',function() {
            uexp_submultivalidfun();
        });
        function uexp_submultivalidfun(){
            var BDLY_INPUT_table = document.getElementById('BDLY_INPUT_tble_unitexpense');
            var BDLY_INPUT_table_rowlength=BDLY_INPUT_table.rows.length;
            var BDLY_INPUT_lastrowid=BDLY_INPUT_table_rowlength-1;
            var count=0;
            var BDLY_INPUT_uexp_id_decrsone=BDLY_INPUT_uexp_id_no-1;
            var BDLY_INPUT_radioname='customerid'+BDLY_INPUT_uexp_id_decrsone;
            for(var i=1;i<=BDLY_INPUT_table_rowlength;i++)
            {
                var unit=$('#BDLY_INPUT_lb_uexp_unit-'+i).val()
                var category=$('#BDLY_INPUT_lb_uexp_category-'+i).val()
                var customer=$('#BDLY_INPUT_lb_uexp_customer'+i).val()
                var invoiceitem=$('#BDLY_INPUT_tb_uexp_invoiceitem'+i).val()
                var invoicedate=$('#BDLY_INPUT_db_uexp_invoicedate'+i).val()
                var invoicefrom=$('#BDLY_INPUT_tb_uexp_invoicefrom'+i).val()
                var amount=$('#BDLY_INPUT_tb_uexp_amount'+i).val()
                if((BDLY_INPUT_arraylength==0)||(BDLY_INPUT_arraylength==undefined)||(BDLY_INPUT_arraylength==1))
                {
                    if((unit!=undefined)&&(category!=undefined)&&(unit!="SELECT")&&(category!="SELECT")&&(unit!='')&&(category!='')&&(amount!="")&&(parseInt(amount)!=0)&&(invoicedate!="")&&(invoiceitem!="")&&(amount!=undefined)&&(invoiceitem!=undefined)&&(invoicedate!=undefined)&&(invoicefrom!='')&&(invoicefrom!=undefined))
                    {
                        if(category==23){
                            if((customer!=undefined)&&(customer!="SELECT")){
                                count=count+1;
                            }
                        }
                        else{
                            count=count+1;
                        }
                    }
                }
                if((BDLY_INPUT_arraylength!=0)&&(BDLY_INPUT_arraylength!=undefined)&&(BDLY_INPUT_arraylength!=1))
                {
                    if(($('input:radio[name='+BDLY_INPUT_radioname+']').is(":checked")==true)&&(unit!=undefined)&&(category!=undefined)&&(unit!="SELECT")&&(category!="SELECT")&&(unit!='')&&(category!='')&&(amount!="")&&(parseInt(amount)!=0)&&(invoicedate!="")&&(invoiceitem!="")&&(amount!=undefined)&&(invoiceitem!=undefined)&&(invoicedate!=undefined)&&(invoicefrom!='')&&(invoicefrom!=undefined))
                    {
                        if(category==23){
                            if((customer!=undefined)&&(customer!="SELECT")){
                                count=count+1;
                            }
                        }
                        else{
                            count=count+1;
                        }
                    }
                }
            }
            if(count==BDLY_INPUT_table_rowlength-1)
            {
                $('#BDLY_INPUT_uexp_add'+BDLY_INPUT_lastrowid).removeAttr("disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').removeAttr("disabled");
            }
            else
            {
                $('#BDLY_INPUT_uexp_add'+BDLY_INPUT_lastrowid).attr("disabled", "disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            }
        }
        $("#BDLY_INPUT_db_star_invoicedate1").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_datep = $('#BDLY_INPUT_db_star_invoicedate'+BDLY_INPUT_star_id_no).datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_datep ) );
                date.setDate( date.getDate() );
                var PDLY_INPUT_newDate = date.toDateString();
                PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                star_submultivalidvalidation();
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
        //DATE PICKER FOR TO DATE ..................
        $('#BDLY_INPUT_db_star_toperiod1').datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,
            onSelect: function(date){
                var PDLY_INPUT_fromdate = $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).datepicker('getDate');
                var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                date.setDate( date.getDate()  ); //+ 1
                var newDate = date.toDateString();
                newDate = new Date( Date.parse( newDate ) );
                $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker("option","minDate",newDate);
                star_submultivalidvalidation();
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).removeClass('calendar-off');
            }
        });
//SUBMIT BUTTON VALIDATION FOR STAR HUB//
        $(document).on('blur','.star_submultivalid',function() {
            star_submultivalidvalidation();
        });
        function star_submultivalidvalidation()
        {
//DATEPICKER FOR STAR HUB  DATE BOX//
            $("#BDLY_INPUT_db_star_invoicedate"+BDLY_INPUT_star_id_no).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true
            });
//DATE PICKER FUNCTION FOR FROM DATE..............
            $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).datepicker({
                dateFormat: "dd-mm-yy",  changeYear: true, changeMonth: true,
                onSelect: function(date){
                    var PDLY_INPUT_fromdate = $('#BDLY_INPUT_db_star_fromperiod'+BDLY_INPUT_star_id_no).datepicker('getDate');
                    var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
                    date.setDate( date.getDate()  ); //+ 1
                    var PDLY_INPUT_newDate = date.toDateString();
                    PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
                    $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker("option","minDate",PDLY_INPUT_newDate);
                    var BDLY_INPUT_smonth=date.getMonth()+3;
                    var BDLY_INPUT_syear=date.getFullYear();
                    var BDLY_INPUT_startdate = new Date(BDLY_INPUT_syear,BDLY_INPUT_smonth);
                    var enddate=new Date(BDLY_INPUT_startdate.getFullYear(),BDLY_INPUT_startdate.getMonth(),BDLY_INPUT_startdate.getDate()-1);
                    var BDLY_INPUT_enddate=new Date(Date.parse(BDLY_INPUT_unitenddate));
                    var BDLY_INPUT_sh_maxdate='';
                    if(enddate>BDLY_INPUT_enddate)
                        BDLY_INPUT_sh_maxdate=BDLY_INPUT_enddate;
                    else
                        BDLY_INPUT_sh_maxdate=enddate;
                    $('#BDLY_INPUT_db_star_toperiod'+BDLY_INPUT_star_id_no).datepicker("option","maxDate",BDLY_INPUT_sh_maxdate);
                    star_submultivalidvalidation();
                },
                beforeShow:function(input, inst) {
                    $(inst.dpDiv).removeClass('calendar-off');
                }});
            var BDLY_INPUT_table = document.getElementById('BDLY_INPUT_tble_starhub');
            var BDLY_INPUT_table_rowlength=BDLY_INPUT_table.rows.length;
            var BDLY_INPUT_lastrowid=BDLY_INPUT_table_rowlength-1;
            var count=0;
            for(var i=1;i<=BDLY_INPUT_table_rowlength;i++)
            {
                var unit=$('#BDLY_INPUT_lb_star_unit-'+i).val()
                var invoicedate=$('#BDLY_INPUT_db_star_invoicedate'+i).val()
                var fromdate=$('#BDLY_INPUT_db_star_fromperiod'+i).val()
                var todate=$('#BDLY_INPUT_db_star_toperiod'+i).val()
                var invoiceto=$('#BDLY_INPUT_lb_star_invoice-'+i).val()
                var amount=$('#BDLY_INPUT_tb_star_amount'+i).val()
                if((unit!=undefined)&&(invoiceto!=undefined)&&(unit!="SELECT")&&(invoiceto!="SELECT")&&(unit!='')&&(invoiceto!='')&&(amount!="")&&(parseInt(amount)!=0)&&(fromdate!="")&&(todate!="")&&(amount!=undefined)&&(fromdate!=undefined)&&(todate!=undefined)&&(invoicedate!=''))
                {
                    count=count+1;
                }
            }
            if(count==BDLY_INPUT_table_rowlength-1)
            {
                $('#BDLY_INPUT_star_add'+BDLY_INPUT_lastrowid).removeAttr("disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').removeAttr("disabled");
            }
            else
            {
                $('#BDLY_INPUT_star_add'+BDLY_INPUT_lastrowid).attr("disabled", "disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            }
        }
        //FUNCTION TO CREATE RADIO FOR HOUSE KEEPING NAME
        $(document).on('change','#BDLY_INPUT_lb_house_cleanername',function() {
            var BDLY_INPUT_arr_createradio=[];
            $('#BDLY_INPUT_hidden_edeid').val('');
            $('#BDLY_INPUT_tble_radioclearnername').empty();
            if($('#BDLY_INPUT_lb_house_cleanername').val()!='SELECT'){
                for (var j = 0; j < BDLY_INPUT_arr_housekeepingname.length; j++) {
                    if(BDLY_INPUT_arr_housekeepingname[j].BDLY_INPUT_cleanername==$('#BDLY_INPUT_lb_house_cleanername').val())
                        BDLY_INPUT_arr_createradio.push(BDLY_INPUT_arr_housekeepingname[j])
                }
            }
            if(BDLY_INPUT_arr_createradio.length!=1){
                var BDLY_INPUT_radio=''
                for (var k = 0; k < BDLY_INPUT_arr_createradio.length; k++) {
                    BDLY_INPUT_radio +='<tr><td><input type="radio" name="BDLY_INPUT_radio_hkname" id="'+BDLY_INPUT_arr_createradio[k].BDLY_INPUT_empid+'" class="BDLY_INPUT_class_hkname BDLY_INPUT_class_submitvalidate" value='+BDLY_INPUT_arr_createradio[k].BDLY_INPUT_empid+'>'+BDLY_INPUT_arr_createradio[k].BDLY_INPUT_cleanername+'-'+BDLY_INPUT_arr_createradio[k].BDLY_INPUT_empid+'</td></tr>'
                }
                $('#BDLY_INPUT_hidden_edeid').val('');
                $('#BDLY_INPUT_tble_radioclearnername').append(BDLY_INPUT_radio);
            }
            else{
                $('#BDLY_INPUT_tble_radioclearnername').empty();
                $('#BDLY_INPUT_hidden_edeid').val(BDLY_INPUT_arr_createradio[0].BDLY_INPUT_empid);
            }
        });
        /*-------------------------------------CLICK FUNCTION FOR SAME EMPLOYEE NAME-----------------------------------*/
        $(document).on('click','.BDLY_INPUT_class_hkname',function(){
            $('#BDLY_INPUT_hidden_edeid').val($('input:radio[name=BDLY_INPUT_radio_hkname]:checked').val());
        });
        $(document).on("change",'.amtonlyvalidation', function (){
            var BDLY_INPUT_id=$(this).attr('id');
            var BDLY_INPUT_elemtid =BDLY_INPUT_id.replace( /^\D+/g, '');
            var BDLY_INPUT_paymentval=$('#BDLY_INPUT_lb_elect_payment'+BDLY_INPUT_elemtid).val();
            if(BDLY_INPUT_paymentval==134||BDLY_INPUT_paymentval==133)
            {
                $("#BDLY_INPUT_tb_elect_minusamt"+BDLY_INPUT_elemtid).doValidation({rule:'numbersonly',prop:{integer:true,realpart:3,imaginary:2}});
            }
            else
            {
                $("#BDLY_INPUT_tb_elect_amount"+BDLY_INPUT_elemtid).doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
            }
            BDLY_INPUT_electricityvaliation();
        });
        /*--------------------------------------------CALL FUNCTION TO HIGHLIGHT SEARCH TEXT---------------------------------------------------*/
        function BDLY_INPUT_unit_autocomplete(BDLY_INPUT_inc_id){
            var searchoption_elem =$('#BDLY_INPUT_tb_uexp_invoicefrom'+BDLY_INPUT_inc_id);
            highlightSearchText();
            searchoption_elem.autocomplete({
                source: BDLY_INPUT_arr_autocmp,
                select:AutoCompleteSelectHandler
            });}
        /*----------------------------------------------------FUNCTION TO HIGHLIGHT SEARCH TEXT------------------------------------------------------------------------*/
        function highlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            };
        }
        /*---------------------------------------------------FUNCTION TO GET SELECTED VALUE----------------------------------------------------------------*/
        function AutoCompleteSelectHandler(event, ui) {
        }
        /* SEARCH AND UPDATE FORM SCRIPT STARTS*/
        function BDLY_SRC_result_getInitialvalue(initialvalue) {
            var ExpenseList=[];
            BDLY_SRC_errormsglist=initialvalue.errormsg;
            ExpenseList=initialvalue.explist;
            BDLY_SRC_unitcategoryvalue=initialvalue.unitcat;
            BDLY_SRC_arr_chkexp=initialvalue.BIZDLY_SRC_chk_exptble;
            var confirmmessagescodes=[106,107,170,401,315,2,462,204,205,206,207,208,426,427,428,429,430,431,432,433,434,435,436,437,438,439,413];
            //GET CONFIRMATION MESSAGES
            BDLY_SRC_confirmmessages=BDLY_SRC_getAllErrorMessages(confirmmessagescodes)
            var BDLY_SRC_flg_chkExpTble=0;
            for (var j = 0; j < initialvalue.BIZDLY_SRC_chk_exptble.length; j++)
            {
                if(initialvalue.BIZDLY_SRC_chk_exptble[j]==0)
                    BDLY_SRC_flg_chkExpTble=BDLY_SRC_flg_chkExpTble+1;
                else
                    BDLY_SRC_flg_chkExpTble=BDLY_SRC_flg_chkExpTble;
            }
            if(BDLY_SRC_flg_chkExpTble==16){
                var BDLY_SRC_append_errmsg='<p><label class="errormsg">';
                for (var j = 7; j < BDLY_SRC_confirmmessages.length-2; j++)
                {
                    BDLY_SRC_append_errmsg +=BDLY_SRC_confirmmessages[j]+'<br>'
                }
                BDLY_SRC_append_errmsg +='</label></p>'
                $('#BDLY_INPUT_form_dailyentry').replaceWith(BDLY_SRC_append_errmsg)
            }
            else{
                var options='<option value="SELECT" >SELECT</option>';
                for (var i = 0; i < ExpenseList.length; i++)
                {
                    options +='<option value="'+ExpenseList[i][0]+'">' + ExpenseList[i][1] + '</option>';
                }
                $('#BDLY_SRC_lb_ExpenseList').append(options).show();
                $('#BDLY_SRC_lb_ExpenseList').focus();
            }
            $('.preloader').hide();
        }
        /*---------------------------------FUNCTION TO GET ERR MESSAGES-------------------------------------------*/
        function BDLY_SRC_getAllErrorMessages(BDLY_SRC_finalerrrcodes)
        {
            BDLY_SRC_finalerrr=[];
            for(var i=0;i<BDLY_SRC_finalerrrcodes.length;i++)
            {
                BDLY_SRC_finalerrr.push(BDLY_SRC_errormsglist.errormsg[BDLY_SRC_errormsglist.errorcode.indexOf(BDLY_SRC_finalerrrcodes[i].toString())])
            }

            return BDLY_SRC_finalerrr;
        }
        /*------------------------------------------TO GET SEARCH OPTION LIST FOR SELECTED EXPENSE----------------------------------------------------*/
        $("#BDLY_SRC_lb_ExpenseList").change(function(){
            $("#BDLY_SRC_div_searchresult,#BDLY_SRC_dynamicarea,#BDLY_SRC_Optionhead,#BDLY_SRC_div_searchresult_head,#BDLY_SRC_nodyndataerr").html('');
            $('#BDLY_btn_pdf').hide();
            $('#BDLY_SRC_btn_search').hide();
            $("#BDLY_SRC_lbl_errmsg_exp").text('')
            $("#BDLY_SRC_tr_serachopt").hide();
            var selectedexpense = $(this).val();
//CHECK EACH TABLE OF EXPENSE
            var BDLY_SRC_twodim_chktble={
                9:[BDLY_SRC_arr_chkexp[0],BDLY_SRC_confirmmessages[12],BDLY_SRC_arr_chkexp[1],BDLY_SRC_confirmmessages[11]],
                8:[BDLY_SRC_arr_chkexp[2],BDLY_SRC_confirmmessages[13],BDLY_SRC_arr_chkexp[3],BDLY_SRC_confirmmessages[9]],
                5:[BDLY_SRC_arr_chkexp[4],BDLY_SRC_confirmmessages[14],BDLY_SRC_arr_chkexp[5],BDLY_SRC_confirmmessages[10]],
                1:[BDLY_SRC_arr_chkexp[8],BDLY_SRC_confirmmessages[15],BDLY_SRC_arr_chkexp[9],BDLY_SRC_confirmmessages[8]],
                4:[BDLY_SRC_arr_chkexp[11],BDLY_SRC_confirmmessages[16],1,1],11:[BDLY_SRC_arr_chkexp[15],BDLY_SRC_confirmmessages[17],1,1],
                12:[BDLY_SRC_arr_chkexp[16],BDLY_SRC_confirmmessages[18],1,1],7:[BDLY_SRC_arr_chkexp[12],BDLY_SRC_confirmmessages[20],1,1],
                10:[BDLY_SRC_arr_chkexp[14],BDLY_SRC_confirmmessages[21],1,1],6:[BDLY_SRC_arr_chkexp[13],BDLY_SRC_confirmmessages[22],1,1],
                2:[BDLY_SRC_arr_chkexp[6],BDLY_SRC_confirmmessages[23],BDLY_SRC_arr_chkexp[7],BDLY_SRC_confirmmessages[7]],3:[BDLY_SRC_arr_chkexp[10],BDLY_SRC_confirmmessages[24],1,1]};
            if((BDLY_SRC_twodim_chktble[selectedexpense][0]==0)||(BDLY_SRC_twodim_chktble[selectedexpense][2]==0)){
                if(BDLY_SRC_twodim_chktble[selectedexpense][0]==0)
                    $("#BDLY_SRC_lbl_errmsg_exp").html(BDLY_SRC_twodim_chktble[selectedexpense][1]+'<br>')
                if(BDLY_SRC_twodim_chktble[selectedexpense][2]==0)
                    $("#BDLY_SRC_lbl_errmsg_exp").append(BDLY_SRC_twodim_chktble[selectedexpense][3])
                $('#BDLY_SRC_tr_serachopt').hide();
            }
            else{
                if(selectedexpense!=""){
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_SRC_getSearchOptions",
                        data:{'selectedexpense':selectedexpense},
                        success: function(res) {
                            $('.preloader').hide();
                            var Searchoptionhkpunit=JSON.parse(res);
                            BDLY_SRC_LoadSearchOption(Searchoptionhkpunit)
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
                $("#BDLY_SRC_div_searchresult").text("");
                $('#BDLY_btn_pdf').hide();
            }
        });
        /*-------------------------------------------SUCCESS FUNCTION SEARCH OPTION FOR SEARCH OPTION----------------*/
        function BDLY_SRC_LoadSearchOption(Searchoptionhkpunit) {
            $(".preloader").fadeOut(500);
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            var Searchoption_array=Searchoptionhkpunit.srcoption;
            BDLY_SRC_HKunitnovalues=Searchoptionhkpunit.hkpunitno;
            var totalsearchopt=Searchoption_array.length;
            $("#BDLY_SRC_tr_serachopt").show();
            $('#BDLY_SRC_lb_serachopt').html('');
            var options='<option value="">SELECT</option>';
            for (var i = 0; i <totalsearchopt; i++) {
                options +='<option value="'+Searchoption_array[i].key +'">' + Searchoption_array[i].value + '</option>';
            }
            $('#BDLY_SRC_lb_serachopt').html(options);
        }
        //FUNCTION TO GET SEARCH OPTION FORM TYPE
        function BDLY_SRC_getsearch_optiontype(selectedSearchopt)
        {
            var searchformtkeygroup = {127:'CAR NO',128:'COMMENTS',129:'FROM PERIOD',130:'TO PERIOD',131:'INVOICE DATE',132:'INVOICE AMOUNT',              //Car Park
                159:'COMMENTS',160:'INVOICE AMOUNT',161:'INVOICE AMOUNT',162:'FROM PERIOD',163:'INVOICE AMOUNT',164:'INVOICE DATE',165:'INVOICE TO',166:'TO PERIOD',  //Electricity
                167:'COMMENTS',168:'INVOICE AMOUNT',169:'INVOICE AMOUNT',170:'INVOICE DATE',
                171:'COMMENTS',172:'INVOICE AMOUNT',173:'INVOICE DATE',136:'INVOICE DATE',137:'INVOICE AMOUNT',138:'INVOICE AMOUNT',139:'INVOICE ITEMS',140:'COMMENTS',
                185:'COMMENTS',186:'CATEGORY',187:'INVOICE AMOUNT',188:'INVOICE DATE',189:'INVOICE ITEMS',190:'INVOICE FROM',191:'UNIT NO',                    //Unit Expense
                174:'CARD NO',175:'COMMENTS',176:'INVOICE AMOUNT',177:'INVOICE DATE',                                                                          //purchase card
                141:'CLEANER NAME',142:'FOR PERIOD DURATION',143:'COMMENTS',144:'DURATION',145:'INVOICE DATE',
                146:'COMMENTS',147:'FOR PERIOD',148:'INVOICE AMOUNT',149:'INVOICE DATE',150:'UNIT NO',                                                // House keeping payment
                151:'ACCOUNT NO',152:'INVOICE AMOUNT',153:'COMMENTS',154:'VOCIE NO',155:'INVOICE DATE',156:'INVOICE DATE',157:'INVOICE TO',158:'INVOICE DATE',
                124:'SERVICED BY',125:'COMMENTS',126:'INVOICE DATE',197:'SERVICE DUE',
                178:'ACCOUNT NO',179:'COMMENTS',180:'FROM PERIOD',181:'INVOICE AMOUNT',182:'INVOICE DATE',183:'INVOICE TO',184:'TO PERIOD'
            };
            return searchformtkeygroup[selectedSearchopt]
        }
        /*------------------------------------------TO GET EXPENSE DATA ON BASIS OF SELECTED SEARCH OPTION----------------------------------------------------*/
        $("#BDLY_SRC_lb_serachopt").change(function(){
            BDLY_SRC_btn_dbvalues=true;
            BDLY_SRC_sucsval=0;
            $('#BDLY_SRC_btn_search').attr("disabled", "disabled").hide();
            $("#BDLY_SRC_div_searchresult_head,#BDLY_SRC_div_searchresult,#BDLY_SRC_dynamicarea,#BDLY_SRC_Optionhead,#BDLY_SRC_nodyndataerr").html('');
            $('#BDLY_btn_pdf').hide();
            var selectedSearchopt = $(this).val(),selectedexpense=$('#BDLY_SRC_lb_ExpenseList').val();
            $("#BDLY_SRC_Optionhead").text("");
//GET ERR MESSAGES BASED ON THE SEARCH OPTION START
            BDLY_SRC_finalerrrcodes=BDLY_SRC_errormessagecodes[selectedSearchopt];
            BDLY_SRC_getAllErrorMessages(BDLY_SRC_finalerrrcodes);
//GET ERR MESSAGES BASED ON THE SEARCH OPTION END
            if(selectedSearchopt==198)
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_SRC_getAnyTypeExpData",
                    data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                    success: function(res) {
                        $('.preloader').hide();
                        var response=JSON.parse(res);
                        BDLY_SRC_UpdateDataTable(response)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else
            {
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                if(selectedSearchopt!=""){
                    $("#BDLY_SRC_Optionhead").text($(this).find('option:selected').text());
                    seclectFormtype =BDLY_SRC_getsearch_optiontype(selectedSearchopt);//GET SEARCH OPTION FORM TYPE
//CREATE DYNAMIC SEARCH FORM ELEMENTS START
                    var TempInvoiceFromTR ='<div id="BDLY_SRC_tr_searchopt_invoicefrom" class="BDLY_SRC_class_dynamicrows form-group" ><label class="col-sm-2">INVOICE FROM</label><div class="col-sm-4"><input type="text" name="BDLY_SRC_invoicefrom" id="BDLY_SRC_invoicefrom" class="auto form-control" disabled /></div></div>';
                    var TempVoiceNoTR ='<div id="BDLY_SRC_tr_searchopt_voiceno" class="BDLY_SRC_class_dynamicrows form-group" ><label class="col-sm-2">DIGITAL VOICE NO</label><div class="col-sm-3"><input type="text" name="BDLY_SRC_voiceno" id="BDLY_SRC_voiceno" class="auto form-control"  disabled /></div></div>';
                    var TempDurationFromTR ='<div id="BDLY_SRC_tr_searchopt_durationfrom" class="BDLY_SRC_class_dynamicrows form-group" ><label class="col-sm-2">FROM DURATION</label><div class="col-sm-2"><input type="text" name="BDLY_SRC_fromduration" id="BDLY_SRC_durationfrom" class="BDLY_SCR_Field duration form-control"/></div></div>';
                    var TempDurationToTR ='<div id="BDLY_SRC_tr_searchopt_durationto" class="BDLY_SRC_class_dynamicrows form-group" ><label class="col-sm-2">TO DURATION</label><div class="col-sm-2"><input type="text" name="BDLY_SRC_toduration" id="BDLY_SRC_durationto" class="BDLY_SCR_Field duration form-control"/></div><div><label id="BDLY_SCR_lbl_err_durationmin" class="errormsg"></label></div><div><label id="BDLY_SCR_lbl_err_durationhrs" class="errormsg"></label></div><div><label id="BDLY_SCR_lbl_err_duration" class="errormsg"></label></div></div>';
                    var TempServiceDueTR ='<div id="BDLY_SRC_tr_searchopt_servicedue" class="form-group"><label class=" col-sm-2">SERVICE DUE</label><div style="padding-left:0px;" class="col-sm-9"><div class="col-sm-3"><div class="input-group addon"><input type="text" name="BDLY_SRC_servicedue" id="BDLY_SRC_servicedue" class="BDLY_SCR_Field BDLY_SCR_forperiod BDLT_SRC_Month_picker monthpicker datemandtry form-control"/><label for="BDLY_SRC_servicedue" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div></div></div>';
                    var TempCommentsTR ='<div id="BDLY_SRC_tr_searchopt_comments" class="BDLY_SRC_class_dynamicrows form-group" ><label class="col-sm-2">COMMENTS</label><div class="col-sm-4"><textarea name="BDLY_SRC_comments" id="BDLY_SRC_comments"  class="form-control auto" style="min-height:116px;!important" disabled ></textarea></div></div>';
                    var TempItemsTR ='<div id="BDLY_SRC_tr_searchopt_invoiceitem" class="BDLY_SRC_class_dynamicrows form-group" ><label class="col-sm-2">INVOICE ITEMS</label><div class="col-sm-4"><textarea name="BDLY_SRC_invoiceitem" id="BDLY_SRC_invoiceitem"  class="auto form-control" style="min-height:116px; !important"  disabled ></textarea></div></div>';
                    var TempCategoryTR ='<div id="BDLY_SRC_tr_searchopt_category" class="BDLY_SRC_class_dynamicrows form-group" ><label class="BDLY_SRC_class_lb_lbl col-sm-2">CATEGORY</label><div class="col-sm-2"><select class="BDLY_SRC_class_Searchbtn_list_box BDLY_SCR_Field form-control" name="BDLY_SRC_lb_category" id="BDLY_SRC_lb_category" ><option>SELECT</option></select></div></div>';
                    var TempCusnameTR ='<div style="display:none;" id="BDLY_SRC_tr_searchopt_cusname" class="form-group"><label class="BDLY_SRC_class_lb_lbl col-sm-2">CUSTOMER NAME</label><div class="col-sm-4"><select class="BDLY_SRC_class_Searchbtn_list_box form-control" name="BDLY_SRC_lb_cusname" id="BDLY_SRC_lb_cusname" ><option>SELECT</option></select></div></div>';
                    var TempUnitTR ='<div id="BDLY_SRC_tr_searchopt_unit" class="BDLY_SRC_class_dynamicrows form-group" ><label class="BDLY_SRC_class_lb_lbl col-sm-2">UNIT NO</label><div class="col-sm-2"><select class="BDLY_SRC_class_Searchbtn_list_box BDLY_SCR_Field form-control" name="BDLY_SRC_lb_unitno" id="BDLY_SRC_lb_unitno" ><option>SELECT</option></select></div></div>';
                    var TempDigvoicenoTR ='<div id="BDLY_SRC_tr_searchopt_Digvoiceno" class="BDLY_SRC_class_dynamicrows form-group" ><label class="BDLY_SRC_class_lb_lbl col-sm-2">DIGITAL VOICE NO</label><div class="col-sm-2"><select class="BDLY_SRC_class_Searchbtn_list_box BDLY_SCR_Field form-control" name="BDLY_SRC_lb_Digvoiceno" id="BDLY_SRC_lb_Digvoiceno" ><option>SELECT</option></select></div></div>';
                    var TempCarNoTR ='<div id="BDLY_SRC_tr_searchopt_carno" class="BDLY_SRC_class_dynamicrows form-group" ><label class="BDLY_SRC_class_lb_lbl col-sm-2">CAR NO</label><div class="col-sm-2"><select class="BDLY_SRC_class_Searchbtn_list_box BDLY_SCR_Field form-control" name="BDLY_SRC_lb_carno" id="BDLY_SRC_lb_carno" ><option>SELECT</option></select></div></div>';
                    var TempCardNoTR ='<div id="BDLY_SRC_tr_searchopt_cardno" class="BDLY_SRC_class_dynamicrows form-group" ><label class="BDLY_SRC_class_lb_lbl col-sm-2">CARD NO</label><div class="col-sm-2"><select class="BDLY_SRC_class_Searchbtn_list_box BDLY_SCR_Field form-control" name="BDLY_SRC_lb_cardno" id="BDLY_SRC_lb_cardno" ><option>SELECT</option></select></div></div>';
                    var TempServiceByTR ='<div id="BDLY_SRC_tr_searchopt_serviceby" class="BDLY_SRC_class_dynamicrows form-group" ><label class="BDLY_SRC_class_lb_lbl col-sm-2">AIRCON SERVICE BY</label><div class="col-sm-4"><select class="BDLY_SRC_class_Searchbtn_list_box BDLY_SCR_Field form-control" name="BDLY_SRC_lb_serviceby" id="BDLY_SRC_lb_serviceby" ><option>SELECT</option></select></div></div>';
                    var TempInvoiceToTR ='<div id="BDLY_SRC_tr_searchopt_invoiceto" class="BDLY_SRC_class_dynamicrows form-group" ><label class="BDLY_SRC_class_lb_lbl col-sm-2">INVOICE TO</label><div class="col-sm-2"><select class="BDLY_SRC_class_Searchbtn_list_box BDLY_SCR_Field form-control" name="BDLY_SRC_lb_invoiceto" id="BDLY_SRC_lb_invoiceto" ><option>SELECT</option></select></div></div>';
                    var TempCleanerNameTR ='<div id="BDLY_SRC_tr_searchopt_cleanername" class="BDLY_SRC_class_dynamicrows form-group" ><label class="BDLY_SRC_class_lb_lbl col-sm-2">CLEANER NAME</label><div class="col-sm-3"><select class="BDLY_SRC_class_Searchbtn_list_box BDLY_SCR_Field form-control" name="BDLY_SRC_lb_cleanername" id="BDLY_SRC_lb_cleanername" ><option>SELECT</option></select></div></div>';
                    var TempAccountTR ='<div id="BDLY_SRC_tr_searchopt_accountno" class="BDLY_SRC_class_dynamicrows form-group" ><label class="BDLY_SRC_class_lb_lbl col-sm-2">ACCOUNT NO</label><div class="col-sm-2"><select  class="BDLY_SRC_class_Searchbtn_list_box BDLY_SCR_Field form-control" name="BDLY_SRC_lb_accountno" id="BDLY_SRC_lb_accountno" ><option>SELECT</option></select></div></div>';
                    var TempFromamtTR ='<div id="BDLY_SRC_tr_searchopt_fromamt" class="BDLY_SRC_class_dynamicrows form-group" ><label class="col-sm-2">FROM AMOUNT</label><div class="col-sm-2" ><input class="BDLY_SCR_Field form-control" type="text" id="BDLY_SRC_tb_fromamt" name="BDLY_SRC_tb_fromamnt" /></div></div>';
                    var TempToamtTR ='<div id="BDLY_SRC_tr_searchopt_toamt" class="BDLY_SRC_class_dynamicrows form-group" ><label class="col-sm-2">TO AMOUNT</label><div class="col-sm-2"><input class="BDLY_SCR_Field form-control" type="text" id="BDLY_SRC_tb_toamt"  name="BDLY_SRC_tb_toamnt" /></div><div class="errormsg" id="BDLY_SRC_tb_fromtoamnt_errormsg"></div></div>';
                    var TempStart_DateTR ='<div id="BDLY_SRC_tr_searchopt_startdate" class="BDLY_SRC_class_dynamicrowss form-group" ><label class="col-sm-2">START DATE</label><div class="col-sm-2"><div class="input-group addon"><input  type="text" id="BDLY_SRC_startdate" name="BDLY_SRC_startdate" class="BDLY_SCR_Field datepickerbox BDLY_class_sedatechange datemandtry form-control" /><label for="BDLY_SRC_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div><div class="errormsg" id="BDLY_SRC_startdate_errormsg"></div></div>';
                    var TempEnd_DateTR ='<div id="BDLY_SRC_tr_searchopt_enddate" class="BDLY_SRC_class_dynamicrowss form-group" ><label class="col-sm-2">END DATE</label><div class="col-sm-2"><div class="input-group addon"><input class="BDLY_SCR_Field datepickerbox BDLY_class_sedatechange datemandtry form-control" type="text" id="BDLY_SRC_enddate" name="BDLY_SRC_enddate" /><label for="BDLY_SRC_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div><div class="errormsg" id="BDLY_SRC_enddate_errormsg"></div></div></div>';
                    var TempStart_ForperiodTR ='<div id="BDLY_SRC_tr_searchopt_startforperiod"  class="form-group"><label class="col-sm-2">START PERIOD</label><div style="padding-left:0px;" class="col-sm-9"><div class="col-sm-3"><div class="input-group addon"><input type="text" name="BDLY_SRC_startforperiod" id="BDLY_SRC_startforperiod"  class="BDLY_SCR_Field BDLY_SCR_forperiod monthpicker datemandtry form-control" /><label for="BDLY_SRC_startforperiod" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div></div></div>';
                    var TempEnd_ForperiodTR ='<div id="BDLY_SRC_tr_searchopt_endforperiod" class="form-group" ><label class="col-sm-2">END PERIOD</label><div style="padding-left:0px;" class="col-sm-9"><div class="col-sm-3"><div class="input-group addon"><input type="text" name="BDLY_SRC_endforperiod" id="BDLY_SRC_endforperiod"  class="BDLY_SCR_Field BDLY_SCR_forperiod monthpicker datemandtry form-control" /><label for="BDLY_SRC_endforperiod" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div></div></div>';
                    var BDLY_SRC_Form_search_btn_html='<div class="col-lg-offset-2" style="padding-left:65px;"><input type="button" name="BDLY_SRC_btn_search" id="BDLY_SRC_btn_search" class="btn" value="SEARCH"  />';
                    var TempdurationamtTR ='<div id="BDLY_SRC_tr_searchopt_durationamt" class="form-group" ><label class="col-sm-2">AMOUNT PER DURATION</label><div class="col-sm-2" ><input class="BDLY_SCR_Field form-control" type="text" id="BDLY_SRC_tb_durationamt" name="BDLY_SRC_tb_durationamt" /></div></div>';
//CREATE DYNAMIC SEARCH FORM ELEMENTS END
//APPEND DYNAMIC ELEMENTS BASED ON THE SEARCH OPTION GROUPED START
                    switch (seclectFormtype)
                    {
                        case 'FROM PERIOD':
                        case 'TO PERIOD':
                        case 'INVOICE DATE':
                        {
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR);
                            break;
                        }
                        case 'FOR PERIOD DURATION':
                        {
                            $('#BDLY_SRC_dynamicarea').append(TempServiceDueTR+TempCleanerNameTR+TempdurationamtTR);
                            BDLY_SCR_func_forperiod();
                            $("#BDLY_SRC_tb_durationamt").doValidation({rule:'numbersonly',prop:{integer:true,realpart:3,imaginary:2}}).width(50);
                            break;
                        }
                        case 'SERVICE DUE':{
                            $('#BDLY_SRC_dynamicarea').append(TempServiceDueTR);
                            BDLY_SCR_func_forperiod();
                            break;
                        }
                        case 'ACCOUNT NO':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempAccountTR);
                            break;
                        }
                        case 'INVOICE TO':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempInvoiceToTR);
                            break;
                        }
                        case 'DURATION':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempDurationFromTR+TempDurationToTR);
                            if(selectedexpense==11){
                                $("#BDLY_SRC_durationfrom").doValidation({rule:'numbersonly',prop:{integer:true,realpart:2,imaginary:2}}).width(40);
                                $("#BDLY_SRC_durationto").doValidation({rule:'numbersonly',prop:{integer:true,realpart:2,imaginary:2}}).width(40);
                            }
                            break;
                        }
                        case 'VOCIE NO':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempDigvoicenoTR);
                            break;
                        }
                        case 'CLEANER NAME':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempCleanerNameTR);
                            break;
                        }
                        case 'CARD NO':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempCardNoTR);
                            break;
                        }
                        case 'CAR NO':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempCarNoTR);
                            break;
                        }
                        case 'FOR PERIOD':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_ForperiodTR+TempEnd_ForperiodTR);
                            BDLY_SCR_func_forperiod();
                            break;
                        }
                        case 'COMMENTS':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempCommentsTR);
                            break;
                        }
                        case 'CATEGORY':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempCategoryTR+TempCusnameTR);
                            break;
                        }
                        case 'INVOICE AMOUNT':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempFromamtTR+TempToamtTR);
                            if(selectedexpense==3 ){
                                $("#BDLY_SRC_tb_fromamt").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}}).width(50);
                                $("#BDLY_SRC_tb_toamt").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}}).width(50);
                            }
                            else if(selectedexpense==10){
                                $("#BDLY_SRC_tb_fromamt").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}}).width(50);
                                $("#BDLY_SRC_tb_toamt").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}}).width(50);
                            }
                            else if((selectedexpense==1)||(selectedexpense==2)||(selectedexpense==5)){
                                var BDLY_SRC_realpartamt=3;
                                var searchoption=$('#BDLY_SRC_lb_serachopt').val();
                                if(selectedexpense==2)
                                {BDLY_SRC_realpartamt=4;}
                                if(selectedexpense==1 && searchoption==160) {
                                    $("#BDLY_SRC_tb_fromamt").doValidation({rule: 'numbersonly',prop: {realpart: BDLY_SRC_realpartamt, imaginary: 2}}).width(55);
                                    $("#BDLY_SRC_tb_toamt").doValidation({rule: 'numbersonly',prop: {realpart: BDLY_SRC_realpartamt, imaginary: 2}}).width(55);
                                }
                                else
                                {
                                    $("#BDLY_SRC_tb_fromamt").doValidation({rule:'numbersonly',prop:{integer:true,realpart:BDLY_SRC_realpartamt,imaginary:2}}).width(55);
                                    $("#BDLY_SRC_tb_toamt").doValidation({rule:'numbersonly',prop:{integer:true,realpart:BDLY_SRC_realpartamt,imaginary:2}}).width(55);
                                }
                            }
                            else{
                                $("#BDLY_SRC_tb_fromamt").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}}).width(45);
                                $("#BDLY_SRC_tb_toamt").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}}).width(45);
                            }
                            break;
                        }
                        case 'INVOICE FROM':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempInvoiceFromTR);
                            break;
                        }
                        case 'INVOICE ITEMS':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempItemsTR);
                            break;
                        }
                        case 'SERVICED BY':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempServiceByTR);
                            break;
                        }
                        case 'UNIT NO':{
                            $('#BDLY_SRC_dynamicarea').append(TempStart_DateTR+TempEnd_DateTR+TempUnitTR);
                            break;
                        }
                    }
                    var maxinidate= new Date();
                    var maxdatyr =maxinidate.getFullYear()+2;
                    maxdatyr=new Date(maxinidate.setFullYear(maxdatyr));
                    $(".BDLY_class_sedatechange").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,beforeShow:function(input, inst){
                        $(inst.dpDiv).removeClass('calendar-off');}
                    });
                    $('.BDLY_class_sedatechange').datepicker("option","minDate",new Date(1969, 10 , 19));
                    if((selectedSearchopt!=129)&&(selectedSearchopt!=130)&&(selectedSearchopt!=155)&&(selectedSearchopt!=158)&&(selectedSearchopt!=162)&&(selectedSearchopt!=166)&&(selectedSearchopt!=180)&&(selectedSearchopt!=183)&&(selectedSearchopt!=184))
                        $('#BDLY_SRC_enddate,#BDLY_SRC_startdate').datepicker("option","maxDate",new Date());
                    else
                        $('#BDLY_SRC_enddate,#BDLY_SRC_startdate').datepicker("option","maxDate",maxdatyr);
                    $( ".BDLY_SRC_class_dynamicrows" ).hide();
                }}
//APPEND DYNAMIC ELEMENTS BASED ON THE SEARCH OPTION GROUPED END
        });
//COMMON FUNCTION FOR FOR PERIOD VALIDATION
        function BDLY_SCR_func_forperiod(){
            var selectedSearchopt = $('#BDLY_SRC_lb_serachopt').val();
            var BDLY_SRC_getsearch_optiontypearray=["CATEGORY","ACCOUNT NO","INVOICE TO","CLEANER NAME","CARD NO","CAR NO","SERVICED BY","UNIT NO","VOCIE NO"];
            var BDLY_SRC_getsearch_optiontypeval=BDLY_SRC_getsearch_optiontype(selectedSearchopt)
            $('.BDLY_SCR_forperiod').datepicker( {changeMonth: true,  changeYear: true,  showButtonPanel: true,  dateFormat: 'MM-yy',
                maxDate:new Date(),
                onClose: function(dateText, inst) {
                    var month =inst.selectedMonth;
                    var year = inst.selectedYear;
                    $(this).datepicker('setDate', new Date(year, month, 1));
                    $(this).blur();
                    if(($(this).attr('id')=='BDLY_SRC_startforperiod')||($(this).attr('id')=='BDLY_SRC_servicedue')){
                        BDLY_SCR_monthBefore=month;BDLY_SCR_yearBefore=year;
                        $('#BDLY_SRC_btn_search').show();
                    }
                    if($("#BDLY_SRC_endforperiod").val()==''||$("#BDLY_SRC_endforperiod").val()=='')
                        BDLY_SRC_btn_validation = false;
                    else if($("#BDLY_SRC_servicedue").val()=='')
                        BDLY_SRC_btn_validation = false;
                    else
                        $('.auto').val('')
                    var BDLY_SRC_servicedue=$('#BDLY_SRC_servicedue').val(),selectedexpense=$('#BDLY_SRC_lb_ExpenseList').val();
                    if(selectedexpense==11&&selectedSearchopt==142){
                        if(BDLY_SRC_getsearch_optiontypeval=="FOR PERIOD DURATION"&&BDLY_SRC_servicedue!="")
                        {
                            $(".preloader").show();
                            $( ".BDLY_SRC_class_dynamicrows" ).show();
                            $.ajax({
                                type: "POST",
                                url: controller_url+"BDLY_SRC_get_cleanernameservicedue",
                                data:{'BDLY_SRC_servicedue':BDLY_SRC_servicedue,'BDLY_SRC_servicedue':BDLY_SRC_servicedue,'selectedSearchopt':selectedSearchopt},
                                success: function(res) {
                                    $('.preloader').hide();
                                    var response=JSON.parse(res);
                                    BDLY_SRC_success_exp_cleanername(response)
                                },
                                error: function (data) {
                                    alert('error in getting' + JSON.stringify(data));
                                }
                            });
                        }
                    }},
                beforeShow : function(input, inst) {
                    $(inst.dpDiv).addClass('calendar-off');
                    $("#BDLY_SRC_endforperiod").datepicker("option","minDate", new Date(BDLY_SCR_yearBefore, BDLY_SCR_monthBefore ,1));
                } });
            $(".BDLY_SCR_forperiod").focus(function () {
                $(".ui-datepicker-calendar").hide();
                $("#ui-datepicker-div").position({ my: "left top", at: "left bottom", of: $(this)});});
        }
        /*------------------------------------------SEARCH FORM SEARCH BUTTON VALIDATION --------------------------------------------------------*/
        $(document).on('change blur','.BDLY_SCR_Field',function(){
            $('textarea').height(116);
            $('#BDLY_SRC_div_searchresult_head').text("")
            $('#BDLY_SRC_div_searchresult').text("")
            $('#BDLY_btn_pdf').hide();
            var BDLY_SRC_btn_validation = true;
            $( ".BDLY_SCR_Field" ).each(function( index ) {
                var val =$.trim($(this).val());
                if(val == "" || val == 0 || $(this).hasClass('invalid') ) {
                    BDLY_SRC_btn_validation = false;
                } });
            if($('#BDLY_SRC_lb_cusname').val()!=undefined){
                if($('#BDLY_SRC_lb_cusname').val()=='')
                    BDLY_SRC_btn_validation = false;
            }
            if($('#BDLY_SRC_durationfrom').val()!=undefined){
                if((($('#BDLY_SRC_durationfrom').val().length!='')&&($('#BDLY_SRC_durationfrom').val()!=undefined))||(($('#BDLY_SRC_durationto').val().length!='')&&($('#BDLY_SRC_durationto').val()!=undefined))){
                    $(this).removeClass('invalid')
                    var BDLY_SRC_duration=$(this).val().split('.')
                    var BDLY_SRC_durhrs=parseInt(BDLY_SRC_duration[0])
                    var BDLY_SRC_durmin=parseInt(BDLY_SRC_duration[1])
                    if(( BDLY_SRC_durhrs<=24) || (BDLY_SRC_durhrs=='')|| (BDLY_SRC_durhrs==undefined)|| (BDLY_SRC_durhrs==0)){
                        $('#BDLY_SCR_lbl_err_durationhrs').html('')
                        if(( BDLY_SRC_durmin<60) || (BDLY_SRC_durmin=='')|| (BDLY_SRC_durmin==undefined)||(BDLY_SRC_durmin==00)||isNaN(BDLY_SRC_durmin)||(BDLY_SRC_durmin==0)){
                            $('#BDLY_SCR_lbl_err_durationmin').html('')
                            if(($('#BDLY_SRC_durationfrom').val().length!='')&&($('#BDLY_SRC_durationto').val().length!='')&&(parseFloat($('#BDLY_SRC_durationfrom').val()) > parseFloat($('#BDLY_SRC_durationto').val() ))){
                                $('#BDLY_SCR_lbl_err_duration').html(BDLY_SRC_finalerrr[5])}
                            else
                                $('#BDLY_SCR_lbl_err_duration').html('')
                        }
                        else{
                            $(this).addClass('invalid')
                            $('#BDLY_SCR_lbl_err_durationmin').html(BDLY_SRC_finalerrr[4])
                            $('#BDLY_SCR_lbl_err_durationhrs,#BDLY_SCR_lbl_err_duration').html('');
                        }}
                    else if(BDLY_SRC_durhrs>24){
                        $('#BDLY_SCR_lbl_err_durationhrs').html(BDLY_SRC_finalerrr[3])
                        $('#BDLY_SCR_lbl_err_durationmin,#BDLY_SCR_lbl_err_duration').html('');
                        $(this).addClass('invalid')
                    }
                    if((parseFloat($('#BDLY_SRC_durationfrom').val()) > parseFloat($('#BDLY_SRC_durationto').val()) )||( $('#BDLY_SRC_durationfrom').val().split('.')[0]>24)||($('#BDLY_SRC_durationfrom').val().split('.')[1]>60 )||( $('#BDLY_SRC_durationto').val().split('.')[0]>24)||($('#BDLY_SRC_durationto').val().split('.')[1]>60 )){
                        ErrorControl.AmountCompare="InValid";
                    }
                    else{
                        $('#BDLY_SCR_lbl_err_durationhrs,#BDLY_SCR_lbl_err_duration,#BDLY_SCR_lbl_err_durationmin').html('');
                        ErrorControl.AmountCompare="Valid";}
                    if(ErrorControl.AmountCompare=="InValid"){
                        BDLY_SRC_btn_validation = false;
                        $('#BDLY_SRC_btn_search').attr("disabled", "disabled");
                    }
                    else if(ErrorControl.AmountCompare!="InValid" && BDLY_SRC_btn_validation != false )
                        $('#BDLY_SRC_btn_search').removeAttr("disabled");
                }}
            if(($('#BDLY_SRC_tb_fromamt').val()!=undefined)&&($('#BDLY_SRC_tb_toamt').val()!=undefined)){
                var BDLY_SRC_tb_fromamt_plain=$('#BDLY_SRC_tb_fromamt').val();
                var BDLY_SRC_tb_fromamt=parseFloat(BDLY_SRC_tb_fromamt_plain);
                var BDLY_SRC_tb_toamt_plain=$('#BDLY_SRC_tb_toamt').val();
                var BDLY_SRC_tb_toamt=parseFloat(BDLY_SRC_tb_toamt_plain);
                if(BDLY_SRC_tb_fromamt <= BDLY_SRC_tb_toamt && BDLY_SRC_tb_fromamt!='')
                    ErrorControl.AmountCompare="Valid";
                else
                    ErrorControl.AmountCompare="InValid";
                if(ErrorControl.AmountCompare=="InValid"){
                    BDLY_SRC_btn_validation = false;
                    $('#BDLY_SRC_btn_search').attr("disabled", "disabled");
                }
                else if(ErrorControl.AmountCompare!="InValid" && BDLY_SRC_btn_validation != false )
                    $('#BDLY_SRC_btn_search').removeAttr("disabled");
                if(isNaN(BDLY_SRC_tb_fromamt) || isNaN(BDLY_SRC_tb_toamt))
                    $('#BDLY_SRC_tb_fromtoamnt_errormsg').html('');
                else if( ErrorControl.AmountCompare=="InValid" && BDLY_SRC_tb_fromamt!='' && BDLY_SRC_tb_toamt!='')
                    $('#BDLY_SRC_tb_fromtoamnt_errormsg').html(BDLY_SRC_finalerrr[2]);
                else $('#BDLY_SRC_tb_fromtoamnt_errormsg').html('');
            }
            if((BDLY_SRC_btn_validation==false)||(BDLY_SRC_btn_dbvalues==false)){
                $('#BDLY_SRC_btn_search').attr("disabled", "disabled");}
            else if($('.auto').length==0)
                $('#BDLY_SRC_btn_search').removeAttr("disabled");
        });
        /*-------------------FUNCTION TO SHOW SEARCH BUTTON OF FOR PERIOD DATE PICKER------------------------*/
        $(document).on('change','.BDLT_SRC_Month_picker',function(){
            $('#BDLY_SRC_btn_search').show();
        });
        /*-------------------FUNCTION TO VALIDATE SEARCH BUTTON WITH CUSTOMER NAME LIST BOX FOR UNIT EXP CATEGORY------------------------*/
        $(document).on('change','#BDLY_SRC_lb_cusname',function(){
            if($(this).val()==""){
                $('#BDLY_SRC_btn_search').attr("disabled", "disabled");}
            else
                $('#BDLY_SRC_btn_search').removeAttr("disabled");
        });
        /*------------------------------------------FUNCTION TO BIND EXPENSE CATEGORY IN LB --------------------------------------------------------*/
        function BDLY_SRC_success_exp_catgdata(BDLY_expcateg_response){
            if(BDLY_expcateg_response.length==0)
            {
                $('#BDLY_SRC_lb_category').hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
            }
            else
            {
                $('#BDLY_SRC_nodyndataerr').text("")
                Unit_Exp_Category=BDLY_expcateg_response;
                if($('#BDLY_SRC_lb_category').length>0){
                    var options='<option value="">SELECT</option>';
                    for (var i = 0; i <BDLY_expcateg_response.length; i++) {
                        options +='<option value="'+BDLY_expcateg_response[i][0] +'">' + BDLY_expcateg_response[i][1] + '</option>';
                    }
                    $('#BDLY_SRC_lb_category').html(options).show();
                }
                $( ".BDLY_SRC_class_lb_lbl" ).show();
                $('#BDLY_SRC_tr_searchopt_cusname').hide();
            }
            $( ".BDLY_SRC_class_dynamicrows" ).show();
            $(".preloader").fadeOut(500);
        }
        /*------------------------------------------TO BIND UNIT  NO IN LISTBOX----------------------------------------------------*/
        function BDLY_SRC_success_exp_unitno(BDLY_unitno_response){
            if($('#BDLY_SRC_tr_searchopt_enddate').next().find('select').length>0)
                var select_elem =$('#BDLY_SRC_tr_searchopt_enddate').next().find('select');
            else var select_elem =$('#BDLY_SRC_dynamicarea').find('select');
            if(BDLY_unitno_response.length==0)
            {
                select_elem.hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
            }
            else
            {
                $('#BDLY_SRC_nodyndataerr').text("")
                var options='<option value="">SELECT</option>';
                for (var i = 0; i <BDLY_unitno_response.length; i++) {
                    options +='<option value="'+BDLY_unitno_response[i].key +'">' + BDLY_unitno_response[i].value + '</option>';
                }
                select_elem.html(options).show();
                $( ".BDLY_SRC_class_lb_lbl" ).show();
            }
            $(".preloader").fadeOut(500);
        }
        /*------------------------------------------TO BIND DIGITAL VOICE NO IN LISTBOX----------------------------------------------------*/
        function BDLY_SRC_success_exp_digitalvoiceno(BDLY_digvoiceno_response){
            if($('#BDLY_SRC_tr_searchopt_enddate').next().find('select').length>0)
                var select_elem =$('#BDLY_SRC_tr_searchopt_enddate').next().find('select');
            else var select_elem =$('#BDLY_SRC_dynamicarea').find('select');
            if(BDLY_digvoiceno_response.length==0)
            {
                select_elem.hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
            }
            else
            {
                $('#BDLY_SRC_nodyndataerr').text("")
                var options='<option value="">SELECT</option>';
                for (var i = 0; i <BDLY_digvoiceno_response.length; i++) {
                    options +='<option value="'+BDLY_digvoiceno_response[i].key +'">' + BDLY_digvoiceno_response[i].key + '</option>';
                }
                select_elem.html(options).show();
                $( ".BDLY_SRC_class_lb_lbl" ).show();
            }
            $(".preloader").fadeOut(500);
        }
        /*------------------------------------------FUNCTION TO GET CUSTOMER NAME FOR  LB --------------------------------------------------------*/
        $(document).on('change','#BDLY_SRC_lb_category',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($(this).val()==23 && startdate!="" && enddate!=""){
                $(".preloader").show();
                $('#BDLY_SRC_btn_search').attr("disabled", "disabled");
                $('#BDLY_SRC_tr_searchopt_cusname').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_SRC_get_cusname",
                    data:{'startdate':startdate,'enddate':enddate},
                    success: function(res) {
                        $('.preloader').hide();
                        var response=JSON.parse(res);
                        BDLY_SRC_success_cusname(response)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else $('#BDLY_SRC_tr_searchopt_cusname').hide();
        });
        /*------------------------------------------TO BIND CUSTOMER NAME NO IN LISTBOX----------------------------------------------------*/
        function BDLY_SRC_success_cusname(response){
            if(response.length==0)
            {
                $('#BDLY_SRC_lb_cusname').hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
            }
            else
            {
                $('#BDLY_SRC_nodyndataerr').text("")
                var options='<option value="">SELECT</option>';
                for (var i = 0; i <response.length; i++) {
                    options +='<option value="'+response[i].key +'">' + response[i].value +'</option>';
                }
                $('#BDLY_SRC_lb_cusname').html(options).show();
                $('.BDLY_SRC_class_lb_lbl').show();
            }
            $(".preloader").fadeOut(500);
        }
        /*------------------------------------------TO BIND ACCESS CARD NO IN LISTBOX----------------------------------------------------*/
        function BDLY_SRC_success_cardno(response){$(".preloader").fadeOut(500);
            if(response.length==0)
            {
                $('#BDLY_SRC_lb_cardno').hide();
                $(".BDLY_SRC_class_lb_lbl").hide();
                $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
            }
            else
            {
                $('#BDLY_SRC_nodyndataerr').text("")
                var options='<option value="">SELECT</option>';
                for (var i = 0; i <response.length; i++) {
                    options +='<option value="'+response[i].key +'">'+response[i].value+'</option>';
                }
                $('#BDLY_SRC_lb_cardno').html(options).show();
                $( ".BDLY_SRC_class_lb_lbl" ).show();
            }
            $(".preloader").fadeOut(500);
        }
        /*------------------------------------------TO BIND CAR NO IN LISTBOX----------------------------------------------------*/
        function BDLY_SRC_success_carno(response){
            if(response.length==0)
            {
                $('#BDLY_SRC_lb_carno').hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
            }
            else
            {
                $('#BDLY_SRC_nodyndataerr').text("")
                var options='<option value="">SELECT</option>';
                for (var i = 0; i <response.length; i++) {
                    options +='<option value="'+response[i].key +'">'+response[i].key+'</option>';
                }
                $('#BDLY_SRC_lb_carno').html(options).show();
                $( ".BDLY_SRC_class_lb_lbl" ).show();
            }
            $(".preloader").fadeOut(500);
        }
        /*------------------------------------------TO BIND SERVICE BY IN LISTBOX----------------------------------------------------*/
        function BDLY_SRC_success_serviceby(response){
            if(response.length==0)
            {
                $('#BDLY_SRC_lb_serviceby').hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
            }
            else
            {
                $('#BDLY_SRC_nodyndataerr').text("")
                var options='<option value="">SELECT</option>';
                for (var i = 0; i <response.length; i++) {
                    options +='<option value="'+response[i].key +'">'+response[i].key+'</option>';
                }
                $('#BDLY_SRC_lb_serviceby').html(options).show();
                $( ".BDLY_SRC_class_lb_lbl" ).show();
            }
            $(".preloader").fadeOut(500);
        }
        /*------------------------------------------TO BIND CLEANERNAME IN LISTBOX----------------------------------------------------*/
        function BDLY_SRC_success_exp_cleanername(response){
            var selectedSearchopt = $('#BDLY_SRC_lb_serachopt').val();
            if(response.length==0)
            {
                BDLY_SRC_btn_dbvalues = false;
                $('#BDLY_SRC_btn_search').attr("disabled", "disabled");
                $('#BDLY_SRC_lb_cleanername').hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                if(selectedSearchopt==142)
                {
                    if(BDLY_SRC_finalerrr[1].match("[FP]"))
                    {
                        var BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[FP]",$("#BDLY_SRC_servicedue").val())
                    }
                    $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_errormessagenodata);
                }
                else
                {
                    $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
                }
            }
            else
            {
                BDLY_SRC_btn_dbvalues=true;
                $('#BDLY_SRC_nodyndataerr').text("")
                var options='<option value="">SELECT</option>';
                for (var i = 0; i <response.length; i++) {
                    options +='<option value="'+response[i].key +'">' +response[i].value+'</option>';
                }
                $('#BDLY_SRC_lb_cleanername').html(options).show();
                $( ".BDLY_SRC_class_lb_lbl" ).show();
            }
            $(".preloader").fadeOut(500);
        }
        /*------------------------------------------TO BIND ACCOUNT NO IN LISTBOX----------------------------------------------------*/
        function BDLY_SRC_success_exp_accountno(response){
            if(response.length==0)
            {
                $('#BDLY_SRC_lb_accountno').hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
            }
            else
            {
                $('#BDLY_SRC_nodyndataerr').text("")
                var options='<option value="">SELECT</option>';
                for (var i = 0; i <response.length; i++) {
                    options +='<option value="'+response[i].value +'">' +response[i].value+'</option>';
                }
                $('#BDLY_SRC_lb_accountno').html(options).show();
                $( ".BDLY_SRC_class_lb_lbl" ).show();
            }
            $(".preloader").fadeOut(500);
        }
        /*------------------------------------------TO BIND INVOCIE OPTION IN LISTBOX----------------------------------------------------*/
        function BDLY_SRC_success_digital_invoiceto(response){
            if(response.length==0)
            {
                $('#BDLY_SRC_lb_invoiceto').hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                $('#BDLY_SRC_nodyndataerr').text(BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2]));
            }
            else
            {
                $('#BDLY_SRC_nodyndataerr').text("")
                var options='<option value="">SELECT</option>';
                for (var i = 0; i <response.length; i++) {
                    options +='<option value="'+response[i].key +'">' +response[i].value+'</option>';
                }
                $('#BDLY_SRC_lb_invoiceto').html(options).show();
                $( ".BDLY_SRC_class_lb_lbl" ).show();
            }
            $(".preloader").fadeOut(500);
        }
        /*---------------------------------FOR PERIOD SEARCH BUTTON VALIDATION--------------------------------------------*/
        $(document).on('change','#BDLY_SRC_startforperiod,#BDLY_SRC_endforperiod',function(){
            $( ".BDLY_SRC_class_dynamicrows" ).show();
            $('#BDLY_SRC_btn_search').show();
        });
//FUNCTION TO CALL DATE PICKER FORMAT TO SHOW IN FORM ELEMENTS
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        /*------------------------------------------TO PERFORM AUTO COMPLETE DATA OR DYNAMIC DATA RANGE TO APPEND IN LIST BOX-------------------------------------------------------*/
        $(document).on('change','.BDLY_class_sedatechange,.BDLT_SRC_Month_picker',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            var BDLY_SRC_searchoptionarr={1:[159],2:[179],3:[185,189,190],4:[167],5:[153],6:[175],7:[171],8:[128],9:[125],10:[139,140],11:[143],12:[146]};
            var selectedSearchopt = $('#BDLY_SRC_lb_serachopt').val(),selectedexpense=$('#BDLY_SRC_lb_ExpenseList').val();
            var BDLY_SRC_getsearch_optiontypearray=["CATEGORY","ACCOUNT NO","INVOICE TO","CLEANER NAME","CARD NO","CAR NO","SERVICED BY","UNIT NO","VOCIE NO"];
            var BDLY_SRC_getsearch_optiontypeval=BDLY_SRC_getsearch_optiontype(selectedSearchopt)
            startdate=$('#BDLY_SRC_startdate').val();enddate=$('#BDLY_SRC_enddate').val();
            $('#startdate').val(startdate);$('#enddate').val(enddate);
            var BDLY_SRC_servicedue=$('#BDLY_SRC_servicedue').val();
//SET END DATE OR END FOR PERIOD START
            if(startdate!="")
            {
                var BDLY_SRC_in_sdate = new Date( Date.parse( FormTableDateFormat(startdate)) );
                BDLY_SRC_in_sdate.setDate( BDLY_SRC_in_sdate.getDate());
                var BDLY_SRC_in_sdate = BDLY_SRC_in_sdate.toDateString();
                BDLY_SRC_in_sdate = new Date( Date.parse( BDLY_SRC_in_sdate ) );
                $('#BDLY_SRC_enddate').datepicker("option","minDate",BDLY_SRC_in_sdate);
            }
//SET END DATE OR END FOR PERIOD END
            if(startdate!="" && enddate!=""){
                if(BDLY_SRC_searchoptionarr[selectedexpense].indexOf(parseInt(selectedSearchopt))>-1)
                {
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_SRC_get_autocomplete",
                        data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                        success: function(res) {
                            $('.preloader').hide();
                            var BDLY_autocompl_response=JSON.parse(res);
                            BDLY_SRC_success_autodata(BDLY_autocompl_response)
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
                else
                {
                    if(BDLY_SRC_getsearch_optiontypearray.indexOf(BDLY_SRC_getsearch_optiontypeval)>-1)
                    {
                        $(".preloader").show();
                    }
                    if(BDLY_SRC_getsearch_optiontypeval=="CATEGORY"){
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_getUnitexp_catg",
                            data:{'startdate':startdate,'enddate':enddate},
                            success: function(res) {
                                $('.preloader').hide();
                                var BDLY_expcateg_response=JSON.parse(res);
                                BDLY_SRC_success_exp_catgdata(BDLY_expcateg_response)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    else if(BDLY_SRC_getsearch_optiontypeval=="ACCOUNT NO")
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_get_accountno",
                            data:{'selectedexpense':selectedexpense,'startdate':startdate,'enddate':enddate},
                            success: function(res) {
                                $('.preloader').hide();
                                var response=JSON.parse(res);
                                BDLY_SRC_success_exp_accountno(response)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    else if(BDLY_SRC_getsearch_optiontypeval=="INVOICE TO")
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_invoiceto",
                            data:{'selectedexpense':selectedexpense,'selectedSearchopt':selectedSearchopt,'startdate':startdate,'enddate':enddate},
                            success: function(res) {
                                $('.preloader').hide();
                                var response=JSON.parse(res);
                                BDLY_SRC_success_digital_invoiceto(response)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    else if(BDLY_SRC_getsearch_optiontypeval=="CLEANER NAME")
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_get_cleanername",
                            data:{'selectedSearchopt':selectedSearchopt,'startdate':startdate,'enddate':enddate},
                            success: function(res) {
                                $('.preloader').hide();
                                var response=JSON.parse(res);
                                BDLY_SRC_success_exp_cleanername(response)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    else if(BDLY_SRC_getsearch_optiontypeval=="CARD NO")
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_getPurchase_card",
                            data:{'startdate':startdate,'enddate':enddate},
                            success: function(res) {
                                $('.preloader').hide();
                                var response=JSON.parse(res);
                                BDLY_SRC_success_cardno(response)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    else if(BDLY_SRC_getsearch_optiontypeval=="CAR NO")
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_getCarNoList",
                            data:{'startdate':startdate,'enddate':enddate},
                            success: function(res) {
                                $('.preloader').hide();
                                var response=JSON.parse(res);
                                BDLY_SRC_success_carno(response)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    else if(BDLY_SRC_getsearch_optiontypeval=="SERVICED BY")
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_getServiceByList",
                            data:{'startdate':startdate,'enddate':enddate},
                            success: function(res) {
                                $('.preloader').hide();
                                var response=JSON.parse(res);
                                BDLY_SRC_success_serviceby(response)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    else if(BDLY_SRC_getsearch_optiontypeval=="UNIT NO")
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_getUnitList",
                            data:{'selectedexpense':selectedexpense,'selectedSearchopt':selectedSearchopt,'startdate':startdate,'enddate':enddate},
                            success: function(res) {
                                $('.preloader').hide();
                                var response=JSON.parse(res);
                                BDLY_SRC_success_exp_unitno(response)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    else if(BDLY_SRC_getsearch_optiontypeval=="VOCIE NO")
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_getDigitalVoiceNo",
                            data:{'startdate':startdate,'enddate':enddate},
                            success: function(res) {
                                $('.preloader').hide();
                                var response=JSON.parse(res);
                                BDLY_SRC_success_exp_digitalvoiceno(response)
                            }, error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }

                        });
                    }
                }
                if(BDLY_SRC_getsearch_optiontypeval=="TO PERIOD"||
                    BDLY_SRC_getsearch_optiontypeval=="FROM PERIOD"||
                    BDLY_SRC_getsearch_optiontypeval=="INVOICE DATE"||
                    BDLY_SRC_getsearch_optiontypeval=="FOR PERIOD"
                )
                {
                    $('#BDLY_SRC_btn_search').removeAttr("disabled").show()
                }
                else
                {
                    if(BDLY_SRC_getsearch_optiontypeval!='INVOICE AMOUNT')
                        $('#BDLY_SRC_btn_search').attr("disabled", "disabled").show();
                }
                $('#BDLY_SRC_btn_search').show();
                $( ".BDLY_SRC_class_dynamicrows" ).show();
            }
        });
        /*------------------------------------------FUNCTION TO AUTOCOMPLETE SEARCH TEXT--------------------------------------------------------*/
        function BDLY_SRC_success_autodata(BDLY_autocompl_response)
        {
///*--------------------------------------------CALL FUNCTION TO HIGHLIGHT SEARCH TEXT---------------------------------------------------*/
            var searchoption_elem =$('#BDLY_SRC_tr_searchopt_enddate').next().find('.auto');
            var response_len = BDLY_autocompl_response.length;
            highlightSearchText();
            searchoption_elem.autocomplete({
                source: BDLY_autocompl_response,
                select:AutoCompleteSelectHandler
            });
            if(response_len>0){
                searchoption_elem.removeAttr("disabled").attr('placeholder',response_len+' Records Matching').val('');
            }
            else{
                searchoption_elem.attr("disabled", "disabled").attr('placeholder',BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2])).val('');
            }
            $(".preloader").fadeOut(500);
        }
        /*----------------------------------------------------FUNCTION TO HIGHLIGHT SEARCH TEXT------------------------------------------------------------------------*/
        function highlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            };
        }
        /*---------------------------------------------------FUNCTION TO GET SELECTED VALUE----------------------------------------------------------------*/
        function AutoCompleteSelectHandler(event, ui) {
            BDLY_SRC_flag_autocom=ui.item.value;
            if(BDLY_SRC_flag_autocom!='' && $('#BDLY_SRC_startdate').val()!="" && $('#BDLY_SRC_enddate').val()!="" )
                $('#BDLY_SRC_btn_search').removeAttr("disabled");
            else
                $('#BDLY_SRC_btn_search').attr("disabled", "disabled");
        }
        /*----------------------------------FUNCTION TO DISABLE SEARCH BUTTON IF ANY INPUT IN AUTO COMPLETE FIELD---------------------------------*/
        $(document).on('keypress keydown','.auto',function(e){
            if (e.which ==13 && $('#BDLY_SRC_startdate').val()!="" && $('#BDLY_SRC_enddate').val()!="" && BDLY_SRC_flag_autocom!='') {
                $('#BDLY_SRC_btn_search').removeAttr("disabled");
            }else
                $('#BDLY_SRC_btn_search').attr("disabled", "disabled");
        });
        /*----------------------------------FUNCTION TO GET SEARCH RESULT OF INPUT VALUES---------------------------------------------*/
        $(document).on('click','#BDLY_SRC_btn_search',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $(".preloader").show();
            BDLY_SRC_sucsval=0;
            $.ajax({
                type: "POST",
                url: controller_url+"BDLY_SRC_getAnyTypeExpData",
                data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                success: function(res) {
                    $('.preloader').hide();
                    var response=JSON.parse(res);
                    BDLY_SRC_UpdateDataTable(response)
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        });
//FUNCTION TO REPLACE ERROR MESSAGE
        function BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrrvalues)
        {
            var BDLY_SRC_errormessage;
            if(BDLY_SRC_finalerrrvalues.match("[SDATE]"))
            {
                BDLY_SRC_errormessage=BDLY_SRC_finalerrrvalues.replace("[SDATE]",$("#BDLY_SRC_startdate").val())
                BDLY_SRC_errormessage=BDLY_SRC_errormessage.replace("[EDATE]",$("#BDLY_SRC_enddate").val())
            }
            return BDLY_SRC_errormessage;
        }
        var oTable;
//FUNCTION TO UPDATE DATA TABLE DYNAMICALLY FOR THE SEARCH RESULT
        function BDLY_SRC_UpdateDataTable(reaponse){
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            BDLY_SRC_arr_unitcmts=reaponse[3];
            $('#BDLY_SRC_div_searchresult_head').text("")
            var selectedSearchopt=$("#BDLY_SRC_lb_serachopt").val(),
                BDLY_SRC_selectedexptype=$("#BDLY_SRC_lb_ExpenseList").val(),
                BDLY_SRC_getsearch_optiontypeval=BDLY_SRC_getsearch_optiontype(selectedSearchopt);
//CHK SEARCH OPTION TYPE
            if(BDLY_SRC_getsearch_optiontypeval=="COMMENTS"||
                BDLY_SRC_getsearch_optiontypeval=="CAR NO"||
                BDLY_SRC_getsearch_optiontypeval=="INVOICE ITEMS"||
                BDLY_SRC_getsearch_optiontypeval=="INVOICE FROM"||
                BDLY_SRC_getsearch_optiontypeval=="UNIT NO"||
                BDLY_SRC_getsearch_optiontypeval=="CARD NO"||
                BDLY_SRC_getsearch_optiontypeval=="CLEANER NAME"||
                BDLY_SRC_getsearch_optiontypeval=="ACCOUNT NO"||
                BDLY_SRC_getsearch_optiontypeval=="VOCIE NO"||
                BDLY_SRC_getsearch_optiontypeval=="SERVICED BY"||
                BDLY_SRC_getsearch_optiontypeval=="INVOICE TO"||
                BDLY_SRC_getsearch_optiontypeval=="CATEGORY"
            )
            {
                $( ".BDLY_SRC_class_Searchbtn_list_box" ).hide();
                $( ".BDLY_SRC_class_lb_lbl" ).hide();
                $( ".BDLY_class_sedatechange" ).val("");
                $( ".BDLY_SRC_class_dynamicrows" ).hide();
                $( "#BDLY_SRC_btn_search" ).hide();
            }
            else
            {
                $( ".BDLY_SRC_class_dynamicrows" ).show();
                if(selectedSearchopt!=198)
                {
                    $( "#BDLY_SRC_btn_search" ).show();
                }
            }
            var selectedSearchopt = $('#BDLY_SRC_lb_serachopt').val();
            if((selectedSearchopt!=129)&&(selectedSearchopt!=130)&&(selectedSearchopt!=155)&&(selectedSearchopt!=157)&&(selectedSearchopt!=162)&&(selectedSearchopt!=166)&&(selectedSearchopt!=180)&&(selectedSearchopt!=183)&&(selectedSearchopt!=184))
                $('#BDLY_SRC_enddate,#BDLY_SRC_startdate').datepicker("option","maxDate",new Date());
            else
                $( ".BDLY_class_sedatechange" ).datepicker('option', {minDate: null, maxDate: null});
            var resultarray=reaponse[0];
            unit_start_end_date_obj=reaponse[1];
            var BIZDLY_SRC_tablewidth=reaponse[2];
            $("#BDLY_SRC_div_searchresult").html('').append('<table class="srcresult" id="BDLY_SRC_tb_DataTableId" style="width:'+BIZDLY_SRC_tablewidth+'px" hidden><thead><tr></tr></thead><tbody></tbody></table>');
            if(BDLY_SRC_selectedexptype==10||selectedSearchopt==198)
            {
                $("#BDLY_SRC_tb_DataTableId > thead >tr"). append("<th style='width:50px'>EDIT/CANCEL</th>");
            }
            else if(selectedSearchopt!=142)
            {
                $("#BDLY_SRC_tb_DataTableId > thead >tr"). append("<th style='width:50px'>EDIT/DELETE</th>");
            }
            $.each( resultarray[0], function( key, header ) {
                var gsheader=header.replace(/ /g,'&nbsp;');
                var Header=gsheader.split("^")[0];
                var headerwidth=gsheader.split("^")[1];
                if(headerwidth!=undefined)
                {
                    if(Header=='SNO')
                        $("<th style='width:"+headerwidth+"px;display:none'>"+Header+"</th>").addClass(resultarray[1][key]).appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                    else if((Header=='INVOICE&nbsp;DATE')||(Header=='INVOICE&nbsp;DATE<em>*</em>')||(Header=='FROM&nbsp;PERIOD<em>*</em>')||(Header=='TO&nbsp;PERIOD<em>*</em>')||(Header=='WORK&nbsp;DATE<em>*</em>')||(Header=='PAID&nbsp;DATE<em>*</em>'))
                        $("<th style='width:"+headerwidth+"px'>"+Header+"</th>").addClass(resultarray[1][key]).addClass("uk-date-column").appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                    else if(Header=='FOR&nbsp;PERIOD<em>*</em>')
                        $("<th style='width:"+headerwidth+"px'>"+Header+"</th>").addClass(resultarray[1][key]).addClass("uk-forperiod-column").appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                    else if(Header=='TIMESTAMP')
                        $("<th style='width:"+headerwidth+"px'>"+Header+"</th>").addClass(resultarray[1][key]).addClass("uk-timestp-column").appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                    else
                        $("<th style='width:"+headerwidth+"px'>"+Header+"</th>").addClass(resultarray[1][key]).appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                }
                else
                {
                    if(Header=='SNO')
                        $("<th style='display:none'>"+Header+"</th>").addClass(resultarray[1][key]).appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                    else if((Header=='INVOICE&nbsp;DATE')||(Header=='INVOICE&nbsp;DATE<em>*</em>')||(Header=='FROM&nbsp;PERIOD<em>*</em>')||(Header=='TO&nbsp;PERIOD<em>*</em>')||(Header=='WORK&nbsp;DATE<em>*</em>')||(Header=='PAID&nbsp;DATE<em>*</em>'))
                        $("<th style='width:"+headerwidth+"px'>"+Header+"</th>").addClass(resultarray[1][key]).addClass("uk-date-column").appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                    else if(Header=='FOR&nbsp;PERIOD<em>*</em>')
                        $("<th style='width:"+headerwidth+"px'>"+Header+"</th>").addClass(resultarray[1][key]).addClass("uk-forperiod-column").appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                    else if(Header=='TIMESTAMP')
                        $("<th style='width:"+headerwidth+"px'>"+Header+"</th>").addClass(resultarray[1][key]).addClass("uk-timestp-column").appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                    else
                        $("<th style='width:"+headerwidth+"px'>"+Header+"</th>").addClass(resultarray[1][key]).appendTo("#BDLY_SRC_tb_DataTableId > thead >tr");
                }
            });

            $.each(resultarray, function(index, row) {
                var keyid;
                if (index < 2) return;
                var tr = $("#BDLY_SRC_tb_DataTableId >tbody").append("<tr></tr>");
                var eachcell;
                $.each( row, function( key, cell ) {
                    var selectedSearchopt = $('#BDLY_SRC_lb_serachopt').val();
                    if(key==0)
                        keyid=cell;
                    var cell = ((cell==null)?"":cell);
                    if((key==0)&&(selectedSearchopt!=142))
                        eachcell +='<td style="display:none;">'+cell+'</td>';
                    else if(key==1)
                        eachcell +='<td class="unitno">'+cell+'</td>';
                    else
                        eachcell +='<td >'+cell+'</td>';
                });
                var selectedSearchopt=$("#BDLY_SRC_lb_serachopt").val(),
                    BDLY_SRC_selectedexptype=$("#BDLY_SRC_lb_ExpenseList").val();
                if(BDLY_SRC_selectedexptype==10||selectedSearchopt==198)
                {
                    var BDLY_SRC_delbtn='<span style="display: none;"  class="glyphicon glyphicon-trash  delete"  id="delete_'+keyid+'">';
//                   '<input type="button" class="multirowbtn delete" value="Delete" style="display: none;">';
                }
                else
                {
                    var BDLY_SRC_delbtn='<span style="display: block;"  class="glyphicon glyphicon-trash  delete"  id="delete_'+keyid+'">';
//                           '<input type="button" class="multirowbtn delete" value="Delete" >';
                }
                if(selectedSearchopt!=142)
                {
                    $("#BDLY_SRC_tb_DataTableId >tbody >tr:last").append('<td><div class="col-lg-1"><span style="display: block;color:green" class="glyphicon glyphicon-edit  edit" id="edit_'+keyid+'"></span></div><div class="col-lg-1">'+BDLY_SRC_delbtn+'</div></td>'); //myButton
//                   <input type="button" class="multirowbtn edit" value="Edit">
                }
                $("#BDLY_SRC_tb_DataTableId >tbody >tr:last").append(eachcell);
            });
            jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
                var x = new Date( Date.parse(FormTableDateFormat(a)));
                var y = new Date( Date.parse(FormTableDateFormat(b)) );
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
                var x = new Date( Date.parse(FormTableDateFormat(a)));
                var y = new Date( Date.parse(FormTableDateFormat(b)) );
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            }
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
// UK Date Sorting
            jQuery.fn.dataTableExt.oSort['uk_forperiod-asc']  = function(a,b) {
                var ukDatea = a.split('-'); var ukDateb = b.split('-');
                var monthArr={January:['00'],February:['01'],March:['02'],April:['03'],May:['04' ],June:['05'],July:['06'],August:['07'],September:['08'],October:['09'],November:['10'],December:['11']};
                var x = new Date( ukDatea[1],monthArr[ukDatea[0]][0],1);
                var y = new Date( ukDateb[1],monthArr[ukDateb[0]][0],1);
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_forperiod-desc'] = function(a,b) {
                var ukDatea = a.split('-');  var ukDateb =b.split('-');
                var monthArr={January:['00'],February:['01'],March:['02'],April:['03'],May:['04' ],June:['05'],July:['06'],August:['07'],September:['08'],October:['09'],November:['10'],December:['11']};
                var x = new Date( ukDatea[1],monthArr[ukDatea[0]][0],1);
                var y = new Date( ukDateb[1],monthArr[ukDateb[0]][0],1);
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
            switch (BDLY_SRC_getsearch_optiontypeval)
            {
                case "DURATION":
                {
                    if(BDLY_SRC_finalerrr[0].match("[SD]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[SD]",$("#BDLY_SRC_durationfrom").val())
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_errormessagewitdata.replace("[ED]",$("#BDLY_SRC_durationto").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[SDATE]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[SDATE]",$("#BDLY_SRC_durationfrom").val())
                        BDLY_SRC_errormessagenodata=BDLY_SRC_errormessagenodata.replace("[EDATE]",$("#BDLY_SRC_durationto").val())
                    }
                    break;
                }
                case "FOR PERIOD DURATION":
                {
                    if(BDLY_SRC_finalerrr[0].match("[CNAME]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[CNAME]",$('#BDLY_SRC_lb_cleanername').find('option:selected').text())
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_errormessagewitdata.replace("[FP]",$('#BDLY_SRC_servicedue').val())
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_errormessagewitdata.replace("[DUR]",$('#BDLY_SRC_tb_durationamt').val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[CNAME]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[CNAME]",$('#BDLY_SRC_lb_cleanername').find('option:selected').text())
                    }
                    break;
                }
                case "CLEANER NAME":
                {
                    if(BDLY_SRC_finalerrr[0].match("[CNAME]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[CNAME]",$('#BDLY_SRC_lb_cleanername').find('option:selected').text())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[CNAME]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[CNAME]",$('#BDLY_SRC_lb_cleanername').find('option:selected').text())
                    }
                    break;
                }
                case "FOR PERIOD":
                {
                    if(BDLY_SRC_finalerrr[0].match("[SDATE]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[SDATE]",$("#BDLY_SRC_startforperiod").val())
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_errormessagewitdata.replace("[EDATE]",$("#BDLY_SRC_endforperiod").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[SDATE]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[SDATE]",$("#BDLY_SRC_startforperiod").val())
                        BDLY_SRC_errormessagenodata=BDLY_SRC_errormessagenodata.replace("[EDATE]",$("#BDLY_SRC_endforperiod").val())
                    }
                    break;
                }
                case "CARD NO":
                {
                    if(BDLY_SRC_finalerrr[0].match("[CARD NO]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[CARD NO]",$('#BDLY_SRC_lb_cardno').find('option:selected').text())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[CARD NO]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[CARD NO]",$('#BDLY_SRC_lb_cardno').find('option:selected').text())
                    }
                    break;
                }
                case "CATEGORY":
                {
                    if(BDLY_SRC_finalerrr[0].match("[TEXP]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[TEXP]",$('#BDLY_SRC_lb_category').find('option:selected').text())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[TEXP]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[TEXP]",$('#BDLY_SRC_lb_category').find('option:selected').text())
                    }
                    break;
                }
                case "INVOICE ITEMS":
                {
                    if(BDLY_SRC_finalerrr[0].match("[INVITEM]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[INVITEM]",$("#BDLY_SRC_invoiceitem").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[INVITEM]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[INVITEM]",$("#BDLY_SRC_invoiceitem").val())
                    }
                    break;
                }
                case "INVOICE FROM":
                {
                    if(BDLY_SRC_finalerrr[0].match("[INVFROM]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[INVFROM]",$("#BDLY_SRC_invoicefrom").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[INVFROM]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[INVFROM]",$("#BDLY_SRC_invoicefrom").val())
                    }
                    break;
                }
                case "FROM PERIOD":
                case "TO PERIOD":
                case "INVOICE DATE":
                {
                    if(BDLY_SRC_finalerrr[0].match("[SDATE]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[0]);
                    }
                    if(BDLY_SRC_finalerrr[1].match("[SDATE]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[1]);
                    }
                    break;
                }
                case "COMMENTS":
                {
                    if(BDLY_SRC_finalerrr[0].match("[COMTS]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[COMTS]",$("#BDLY_SRC_comments").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[COMTS]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[COMTS]",$("#BDLY_SRC_comments").val())
                    }
                    if($("#BDLY_SRC_lb_serachopt").val()==143){
                        if(BDLY_SRC_finalerrr[0].match("[DESC]"))
                        {
                            BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[DESC]",$("#BDLY_SRC_comments").val())
                        }
                        if(BDLY_SRC_finalerrr[1].match("[DESC]"))
                        {
                            BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[DESC]",$("#BDLY_SRC_comments").val())
                        }}
                    break;
                }
                case "SERVICED BY":
                {
                    if(BDLY_SRC_finalerrr[0].match("[AB]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[AB]",$("#BDLY_SRC_lb_serviceby").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[AB]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[AB]",$("#BDLY_SRC_lb_serviceby").val())
                    }
                    break;
                }
                case "SERVICE DUE":
                {
                    if(BDLY_SRC_finalerrr[0].match("[MONTH]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[MONTH]",$("#BDLY_SRC_servicedue").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[MONTH]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[MONTH]",$("#BDLY_SRC_servicedue").val())
                    }
                    break;
                }
                case "CAR NO":
                {
                    if(BDLY_SRC_finalerrr[0].match("[CAR NO]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[CAR NO]",$("#BDLY_SRC_lb_carno").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[CAR NO]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[CAR NO]",$("#BDLY_SRC_lb_carno").val())
                    }
                    break;
                }
                case "INVOICE AMOUNT":
                {
                    if(BDLY_SRC_finalerrr[0].match("[FAMT]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[FAMT]",$("#BDLY_SRC_tb_fromamt").val())
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_errormessagewitdata.replace("[TAMT]",$("#BDLY_SRC_tb_toamt").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[FAMT]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[FAMT]",$("#BDLY_SRC_tb_fromamt").val())
                        BDLY_SRC_errormessagenodata=BDLY_SRC_errormessagenodata.replace("[TAMT]",$("#BDLY_SRC_tb_toamt").val())
                    }
                    break;
                }
                case "ACCOUNT NO":
                {
                    if(BDLY_SRC_finalerrr[0].match("[ACCNO]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[ACCNO]",$("#BDLY_SRC_lb_accountno").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[ACCNO]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[ACCNO]",$("#BDLY_SRC_lb_accountno").val())
                    }
                    break;
                }
                case "VOCIE NO":
                {
                    if(BDLY_SRC_finalerrr[0].match("[DGTLVNO]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[DGTLVNO]",$("#BDLY_SRC_lb_Digvoiceno").val())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[DGTLVNO]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[DGTLVNO]",$("#BDLY_SRC_lb_Digvoiceno").val())
                    }
                    break;
                }
                case "INVOICE TO":
                {
                    if(BDLY_SRC_finalerrr[0].match("[INVETO]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[INVETO]",$('#BDLY_SRC_lb_invoiceto').find('option:selected').text())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[INVETO]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[INVETO]",$('#BDLY_SRC_lb_invoiceto').find('option:selected').text())
                    }
                    break;
                }
                case "UNIT NO":
                {
                    if(BDLY_SRC_finalerrr[0].match("[UNIT NO]"))
                    {
                        BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0].replace("[UNIT NO]",$('#BDLY_SRC_lb_unitno').find('option:selected').text())
                    }
                    if(BDLY_SRC_finalerrr[1].match("[UNIT NO]"))
                    {
                        BDLY_SRC_errormessagenodata=BDLY_SRC_finalerrr[1].replace("[UNIT NO]",$('#BDLY_SRC_lb_unitno').find('option:selected').text())
                    }
                    break;
                }
            }
            if(selectedSearchopt==198)
            {
                BDLY_SRC_errormessagewitdata=BDLY_SRC_finalerrr[0];
                BDLY_SRC_errormessagenodata="";
            }
            if(resultarray.length==2)
            {
                $("#BDLY_SRC_div_searchresult_head").text(BDLY_SRC_errormessagenodata).removeClass("srctitle").addClass("errormsg")
                $('#BDLY_btn_pdf').hide();
                $('#pdfheader').val(BDLY_SRC_errormessagenodata);
                $('#BDLY_SRC_tb_DataTableId').hide();
                $('#BDLY_SRC_btn_search').attr("disabled", "disabled")
            }
            else
            {
                $('#BDLY_btn_pdf').show();
                $('#BDLY_SRC_tb_DataTableId').show();
                $("#BDLY_SRC_div_searchresult_head").text(BDLY_SRC_errormessagewitdata).removeClass("errormsg").addClass("srctitle");
                $('#pdfheader').val(BDLY_SRC_errormessagewitdata);
                var expensetype=$('#BDLY_SRC_lb_ExpenseList').find('option:selected').text();
                $('#expensetypetext').val(expensetype);
                oTable= $('#BDLY_SRC_tb_DataTableId').dataTable({
                    "aaSorting": [],
                    "pageLength": 10,
                    "sPaginationType":"full_numbers",
                    "aoColumnDefs" : [
                        { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"},{ "aTargets" : ["uk-forperiod-column"] , "sType" : "uk_forperiod"} ]
//                    "scrollX": true,
//                    "sScrollY":  "400px",
//                    "bScrollCollapse": true,
//                    "bAutoWidth": true
                });
                if ( $.browser.webkit ) {
                    setTimeout(function () {
                        oTable.fnAdjustColumnSizing();
                    }, 10);
                }
            }
            if(BDLY_SRC_sucsval==1)
            {
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_confirmmessages[0].replace('[TYPE]',$('#BDLY_SRC_lb_ExpenseList').find('option:selected').text()),"success",false);
            }
            if(BDLY_SRC_sucsval==2)
            {
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_confirmmessages[1].replace('[TYPE]',$('#BDLY_SRC_lb_ExpenseList').find('option:selected').text()),"success",false);
            }
            $(".preloader").fadeOut(500);
        }
        /*-------------------------------------------------FUNCTION TO VALIDATE UPDATE BUTTON------------------------------------*/
        $(document).on('change blur','.required,.textarea,.hrs',function() {
            var selectedSearchopt=$("#BDLY_SRC_lb_serachopt").val(),
                BDLY_SRC_selectedexptype=$("#BDLY_SRC_lb_ExpenseList").val(),
                BDLY_SRC_updatebtnflag=1;
            var BDLY_SRC_inputvalarray=[];
            $('.required').each(function() {
                $(this).removeClass('invalid');
                if(BDLY_SRC_purchasecard==0)
                    $('.tb_access_card').addClass('invalid');
                if(($(this).hasClass('listbox'))&&($(this).val()!=23)){
                    BDLY_SRC_purchasecard=1}
                var inputval=$(this).val();
                BDLY_SRC_inputvalarray.push(inputval)
                if(BDLY_SRC_selectedexptype==11)
                {
                    if($(this).hasClass('hrs'))
                    {
                        var BDLY_SRC_duration=$(this).val().split('.');
                        var BDLY_SRC_durhrs=parseInt(BDLY_SRC_duration[0])
                        var BDLY_SRC_durmin=parseInt(BDLY_SRC_duration[1])
                        if(( BDLY_SRC_durhrs<24) || (BDLY_SRC_durhrs=='')|| (BDLY_SRC_durhrs==undefined)){
                            $('#BDLY_SCR_lbl_err_durationhrs').html('')
                            if((BDLY_SRC_durmin<60) || (BDLY_SRC_durmin=='')|| (BDLY_SRC_durmin==undefined)|| (BDLY_SRC_durmin==00)|| isNaN(BDLY_SRC_durmin)|| (BDLY_SRC_durmin==0)|| (BDLY_SRC_durmin=='00'))
                                $('#BDLY_SCR_lbl_err_durationmin').html('')
                            else{
                                BDLY_SRC_updatebtnflag=0;
                                $('.hrs').addClass('invalid')
                                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_finalerrr[4],"success",false);
                            }}
                        else if((BDLY_SRC_durhrs>24)||(BDLY_SRC_durhrs==24 && BDLY_SRC_durmin!=0 && BDLY_SRC_durmin<60)){
                            BDLY_SRC_updatebtnflag=0;
                            $('.hrs').addClass('invalid');
                            show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_finalerrr[3],"success",false);
                        }}}
                if(selectedSearchopt==198)
                {
                    if(parseInt(inputval)==0&&parseInt(inputval)=="")
                    {BDLY_SRC_updatebtnflag=0;}
                    if((inputval!=""&&(inputval).toString().length<4&&parseInt(inputval)!=0))
                    {
                        BDLY_SRC_updatebtnflag=0;
                        $(this).addClass('invalid');
//CHECK UNIT NO LENGTH==4
                        show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_finalerrr[1],"success",false);
                    }
                    else if((inputval!=""&&(inputval).toString().length==4&&parseInt(inputval)!=0)&&BDLY_SCR_DT_currentfield_hkp_unitno!=inputval)
                    {
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_check_access_cardOrUnitno",
                            data:{'inputval':inputval,'BDLY_SRC_selectedexptype':BDLY_SRC_selectedexptype},
                            success: function(res) {
                                $('.preloader').hide();
                                var responsearray=JSON.parse(res);
                                BDLY_SRC_check_access_cardOrUnitnoresult(responsearray)

                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                }
                if((inputval.toString()=="")||(parseInt(inputval)==0 && BDLY_SRC_selectedexptype!=11)||(parseFloat(inputval)==0 ))
                {
                    BDLY_SRC_updatebtnflag=0;
                }});
            if(BDLY_SRC_selectedexptype==6)
            {
                var BDLY_SRC_cardlenerr;
                var BDLY_SCR_DT_access_card=BDLY_SRC_inputvalarray[0];
                if(parseInt(BDLY_SCR_DT_access_card)==0&&parseInt(BDLY_SCR_DT_access_card)=="")
                {BDLY_SRC_updatebtnflag=0;}
                if($(this).hasClass('tb_access_card'))
                {
//CHECK CARD NO LESS THAN 4 DIGITS
                    if(selectedSearchopt==175||selectedSearchopt==191){BDLY_SRC_cardlenerr=BDLY_SRC_finalerrr[4];
                    }
                    else{BDLY_SRC_cardlenerr=BDLY_SRC_finalerrr[3]}
                    if(selectedSearchopt==175||selectedSearchopt==191){BDLY_SRC_cardlenerr=BDLY_SRC_finalerrr[3]}else{BDLY_SRC_cardlenerr=BDLY_SRC_finalerrr[3]}
                    if((BDLY_SCR_DT_access_card!=""&&(BDLY_SCR_DT_access_card).toString().length<4&&parseInt(BDLY_SCR_DT_access_card)!=0))
                    {
                        BDLY_SRC_purchasecard=0;
                        $(this).addClass('invalid');
                        show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_cardlenerr,"success",false);
                    }
                    else if(BDLY_SCR_DT_currentfield_access_card!=BDLY_SCR_DT_access_card)
                    {
                        if(BDLY_SCR_DT_access_card!='' && (BDLY_SCR_DT_access_card!=""&&(BDLY_SCR_DT_access_card).toString().length>=4&&parseInt(BDLY_SCR_DT_access_card)!=0)){
                            $(".preloader").show();
                            BDLY_SRC_purchasecard=1;
                            $.ajax({
                                type: "POST",
                                url: controller_url+"BDLY_SRC_check_access_cardOrUnitno",
                                data:{'inputval':BDLY_SCR_DT_access_card,'BDLY_SRC_selectedexptype':BDLY_SRC_selectedexptype},
                                success: function(res) {
                                    $('.preloader').hide();
                                    var responsearray=JSON.parse(res);
                                    BDLY_SRC_check_access_cardOrUnitnoresult(responsearray)

                                },
                                error: function (data) {
                                    alert('error in getting' + JSON.stringify(data));
                                }
                            });
                        }
                    }
                    else{
                        BDLY_SRC_purchasecard=1;}
                }
            }
            /*---------------------------------------------------FUNCTION TO CHECK CARD OR UNIT NO EXISTS OR NOT---------------------------*/
            function BDLY_SRC_check_access_cardOrUnitnoresult(response){
                var selectedSearchopt=$("#BDLY_SRC_lb_serachopt").val(),
                    BDLY_SRC_selectedexptype=$("#BDLY_SRC_lb_ExpenseList").val()
                $(".preloader").fadeOut(500);
                var BDLY_SRC_cardalexistserr;
                if(response==true || response=='true' )
                {
                    $(".clsupdatebtn").removeClass('update');
                    if(selectedSearchopt==191){BDLY_SRC_cardalexistserr=BDLY_SRC_finalerrr[4];}
                    else{BDLY_SRC_cardalexistserr=BDLY_SRC_finalerrr[4]}
                    if(BDLY_SRC_selectedexptype==6)
                    {BDLY_SRC_purchasecard=0;
//CHECK CARD NO EXISTS OR NOT
                        $('.tb_access_card').addClass('invalid');
                        show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_cardalexistserr,"success",false);
                    }
                    else
                    {
//CHECK UNIT NO ALREADY EXISTS OR NOT
                        $('.unittextbox1').addClass('invalid');
                        show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_finalerrr[2],"success",false);
                    }
                }
                else if($('.tb_access_card').hasClass('invalid')){
                    BDLY_SRC_purchasecard=1;
                    $('.tb_access_card').removeClass('invalid');}
                else if($('.unittextbox1').hasClass('invalid'))
                    $('.unittextbox1').removeClass('invalid');
            }
            if((BDLY_SRC_updatebtnflag==0)||(BDLY_SRC_purchasecard==0)){
                $(".clsupdatebtn").removeClass('update');
            }
            else{
                $(".clsupdatebtn").addClass('update');
            }
        });
        /*------------------------------------------------DATE PICKER FUNCTION FOR DATA TABLE----------------------------*/
        $(document).on('change','.unit_based_date',function(){
            if(($("#BDLY_SRC_lb_ExpenseList").val()==1) || ($("#BDLY_SRC_lb_ExpenseList").val()==5)){
                var smindate= new Date( Date.parse(FormTableDateFormat($(this).val())) );
                smindate.setDate( smindate.getDate() );
                var smindate = smindate.toDateString();
                smindate = new Date( Date.parse( smindate ) );
                $(".edate").datepicker( "option", "maxDate",smindate);
                $(".sdate").datepicker( "option", "maxDate",smindate);
            }});
        $(document).on('change','.sdate',function(){
            var smindate= new Date( Date.parse(FormTableDateFormat($(this).val())) );
            if($("#BDLY_SRC_lb_ExpenseList").val()==2){
                var BDLY_INPUT_smonth=smindate.getMonth()+3;  var BDLY_INPUT_syear=smindate.getFullYear();
                var BDLY_INPUT_startdate = new Date(BDLY_INPUT_syear,BDLY_INPUT_smonth);
                var enddate=new Date(BDLY_INPUT_startdate.getFullYear(),BDLY_INPUT_startdate.getMonth(),BDLY_INPUT_startdate.getDate()-1);
                var BDLY_SRC_sh_maxdate='';
                var BIZDLY_SRC_enddate = new Date( Date.parse(BDLY_SRC_unitenddate) );
                if(enddate>BIZDLY_SRC_enddate)
                    BDLY_SRC_sh_maxdate=BIZDLY_SRC_enddate;
                else
                    BDLY_SRC_sh_maxdate=enddate;
                $(".edate").datepicker( "option", "maxDate",BDLY_SRC_sh_maxdate);
            }
            smindate.setDate( smindate.getDate() );
            var smindate = smindate.toDateString();
            smindate = new Date( Date.parse( smindate ) );
            $(".edate").datepicker( "option", "minDate",smindate);
        });
        /*------------------------------------------------TO DELETE EACH ROW FROM TABLE----------------------------*/
        $(document).on('click','.delete,.cancel',function() {
            $('.EditRemove').addClass("edit").removeClass("EditRemove");
            $('.DeleteRemove').addClass('delete').removeClass('DeleteRemove');
            var selectedSearchopt=$("#BDLY_SRC_lb_serachopt").val()
            var BDLY_SRC_selectedexptype=$("#BDLY_SRC_lb_ExpenseList").val()
            if($(this).attr('class')=='cancel glyphicon glyphicon-remove'){
                if(BDLY_SRC_selectedexptype==10||selectedSearchopt==198)
                {
                    $('.cancel').removeClass('cancel glyphicon glyphicon-remove').addClass('delete glyphicon glyphicon-trash').hide();
                }
                else
                {
                    $(this).removeClass('cancel glyphicon glyphicon-remove').addClass('delete glyphicon glyphicon-trash');
                }
                $(this).parent().prev().find('span').show().removeClass('update').removeClass("clsupdatebtn glyphicon glyphicon-print").addClass('edit glyphicon glyphicon-edit');
                var td =  $(this).closest("tr").children("td");
                $(td).each(function (i) {
                    if($(this).index()<td.length-2 && i!=0 ){
                        $(this).html($(this).data('restore'));
                    }
                });
            }
            else{
                var td =  $(this).closest("tr").children("td");
                var totallenght =td.length;
                BDLY_DT_row_old_vals=[];
                $(td).each(function () {
                    var tdid =$(this).index();
                    var html = $(this).html();
                    if(tdid<totallenght-2)
                        BDLY_DT_row_old_vals.push(html)
                });
                $('.edit').removeAttr("disabled").next().removeAttr("disabled");
                var dbrowid=$(this).closest("tr").children("td:nth-child(2)").html();
                BDLY_SRC_DeleteKey=dbrowid;
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_confirmmessages[4],"success","delete");
                BDLY_SRC_CurrentTR=$(this).closest("tr");
            }
        });
        /*------------------------------------------------TO DELETE EACH ROW FROM TABLE AFTER CONFIRMATION----------------------------*/
        $(document).on('click','.deleteconfirm',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $(".preloader").show();
            var selectedexpense=$('#BDLY_SRC_lb_ExpenseList').val();
            $.ajax({
                type: "POST",
                url: controller_url+"BDLY_SRC_DeleteRowData",
                data:{'BDLY_SRC_DeleteKey':BDLY_SRC_DeleteKey,'selectedexpense':selectedexpense},
                success: function(res) {
                    var responsearray=res;
                    BDLY_SRC_DT_success_deleterow(responsearray)

                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        });
        function BDLY_SRC_DT_success_deleterow(BDLY_SRC_chkdelflag){
            BDLY_SRC_sucsval=2;
            if(BDLY_SRC_chkdelflag==1)
            {
                var selectedSearchopt=$("#BDLY_SRC_lb_serachopt").val(),
                    BDLY_SRC_selectedexptype=$("#BDLY_SRC_lb_ExpenseList").val(),
                    BDLY_SRC_getsearch_optiontypeval=BDLY_SRC_getsearch_optiontype(selectedSearchopt);
//CHK SEARCH OPTION TYPE
                if(BDLY_SRC_getsearch_optiontypeval=="COMMENTS"||
                    BDLY_SRC_getsearch_optiontypeval=="CAR NO"||
                    BDLY_SRC_getsearch_optiontypeval=="INVOICE ITEMS"||
                    BDLY_SRC_getsearch_optiontypeval=="INVOICE FROM"||
                    BDLY_SRC_getsearch_optiontypeval=="UNIT NO"||
                    BDLY_SRC_getsearch_optiontypeval=="CARD NO"||
                    BDLY_SRC_getsearch_optiontypeval=="CLEANER NAME"||
                    BDLY_SRC_getsearch_optiontypeval=="ACCOUNT NO"||
                    BDLY_SRC_getsearch_optiontypeval=="VOCIE NO"||
                    BDLY_SRC_getsearch_optiontypeval=="SERVICED BY"||
                    BDLY_SRC_getsearch_optiontypeval=="INVOICE TO"||
                    BDLY_SRC_getsearch_optiontypeval=="CATEGORY"
                )
                {
                    if(BDLY_SRC_sucsval==2)
                    {
                        $("#BDLY_SRC_div_searchresult,#BDLY_SRC_div_searchresult_head,#BDLY_SRC_nodyndataerr").html('');
                        $(".preloader").fadeOut(500);
                        $('#BDLY_btn_pdf').hide();
                        show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_confirmmessages[1].replace('[TYPE]',$('#BDLY_SRC_lb_ExpenseList').find('option:selected').text()),"success",false);
                    }
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_SRC_getAnyTypeExpData",
                        data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                        success: function(res) {
                            var response=JSON.parse(res);
                            BDLY_SRC_UpdateDataTable(response)
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
            }
            else
            {
                $(".preloader").fadeOut(500);
                var BDLY_SRC_err_deletion=BDLY_SRC_confirmmessages[2];
                if($('#BDLY_SRC_lb_ExpenseList').val()==6)
                    BDLY_SRC_err_deletion=BDLY_SRC_confirmmessages[25];
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_err_deletion,"success",false);
            }
        }
        $(document).on('click','.required,.invalid',function() {
            $(this).css({ backgroundColor:'white' });
        });
        /*------------------------------VALIDATE FOR SDATE,EDATE AND INV DATE-----------------------------*/
        function BIZDLY_SRC_func_date(){
            BDLY_DT_flg_date=1;
            var BIZDLY_SRC_invdate = new Date( Date.parse(BDLY_SRC_unitinvdate)  );
            var BIZDLY_SRC_startdate = new Date( Date.parse(BDLY_SRC_unitstartdate) );
            var BIZDLY_SRC_maxdate=new Date( Date.parse(BDLY_SRC_unitenddate)  );
            if(($("#BDLY_SRC_lb_ExpenseList").val()==1) || ($("#BDLY_SRC_lb_ExpenseList").val()==5))
                var BIZDLY_SRC_maxdate=new Date( Date.parse(BDLY_SRC_unitinvdate)  );
            if((BDLY_SRC_unitinvdate!=null && new Date( Date.parse($( ".unit_based_date" ).datepicker('getDate')) ).setHours(0,0,0,0)>BIZDLY_SRC_invdate.setHours(0,0,0,0))
                || (BDLY_SRC_unitinvdate!=null && new Date( Date.parse($( ".unit_based_date" ).datepicker('getDate')) ).setHours(0,0,0,0)<BIZDLY_SRC_startdate.setHours(0,0,0,0))){
                BDLY_DT_flg_date=0;
            }
            else if((BDLY_SRC_unitstartdate!=null && $('.sdate')!=undefined && new Date( Date.parse($(".sdate").parent().find('input').datepicker( 'getDate')) ).setHours(0,0,0,0)>BIZDLY_SRC_maxdate.setHours(0,0,0,0))
                || (BDLY_SRC_unitstartdate!=null && $('.sdate')!=undefined && new Date( Date.parse($(".sdate").parent().find('input').datepicker( 'getDate')) ).setHours(0,0,0,0)<BIZDLY_SRC_startdate.setHours(0,0,0,0))){
                BDLY_DT_flg_date=0;
            }
            else if((BDLY_SRC_unitenddate!=null && $('.edate')!=undefined && new Date( Date.parse($(".edate").parent().find('input').datepicker( 'getDate')) ).setHours(0,0,0,0)>BIZDLY_SRC_maxdate.setHours(0,0,0,0))
                || (BDLY_SRC_unitenddate!=null && $('.edate')!=undefined && new Date( Date.parse($(".edate").parent().find('input').datepicker( 'getDate')) ).setHours(0,0,0,0)<BIZDLY_SRC_startdate.setHours(0,0,0,0))){
                BDLY_DT_flg_date=0;
            }
            if(BDLY_DT_flg_date==0){
                BDLY_DT_func_oldposition();
            }
            else{
                $(".unit_based_date").datepicker( "option", "maxDate",BIZDLY_SRC_invdate);
                $(".unit_based_date").datepicker( "option", "minDate",BIZDLY_SRC_startdate);
                $(".sdate").datepicker( "option", "minDate",BIZDLY_SRC_startdate);
                if($("#BDLY_SRC_lb_ExpenseList").val()==1){
                    $(".sdate").datepicker( "option", "minDate",BIZDLY_SRC_startdate);
                    $(".unit_based_date").datepicker( "option", "minDate",BIZDLY_SRC_startdate);
                }
                if(($("#BDLY_SRC_lb_ExpenseList").val()==1) || ($("#BDLY_SRC_lb_ExpenseList").val()==5)){
//FROM DATE
                    var CEXTN_db_chkindate1 = new Date( Date.parse($( ".unit_based_date" ).datepicker('getDate')) );
                    CEXTN_db_chkindate1.setDate( CEXTN_db_chkindate1.getDate() );
                    var CEXTN_db_chkindate1 = CEXTN_db_chkindate1.toDateString();
                    CEXTN_db_chkindate1 = new Date( Date.parse( CEXTN_db_chkindate1 ) );
                    $(".sdate").datepicker( "option", "maxDate",CEXTN_db_chkindate1);
                    $(".edate").datepicker( "option", "maxDate",CEXTN_db_chkindate1);
                }
                else{
                    var BIZDLY_SRC_enddate = new Date( Date.parse(BDLY_SRC_unitenddate) );
                    $(".sdate").datepicker( "option", "maxDate",BIZDLY_SRC_enddate);
                    if($("#BDLY_SRC_lb_ExpenseList").val()==2){
                        var CEXTN_db_sdate = new Date( Date.parse($(".sdate").parent().find('input').datepicker( 'getDate')) );
                        var BDLY_INPUT_smonth=CEXTN_db_sdate.getMonth()+3;  var BDLY_INPUT_syear=CEXTN_db_sdate.getFullYear();
                        var BDLY_INPUT_startdate = new Date(BDLY_INPUT_syear,BDLY_INPUT_smonth);
                        var enddate=new Date(BDLY_INPUT_startdate.getFullYear(),BDLY_INPUT_startdate.getMonth(),BDLY_INPUT_startdate.getDate()-1)
                        var BDLY_SRC_sh_maxdate='';
                        if(enddate>BIZDLY_SRC_maxdate)
                            BDLY_SRC_sh_maxdate=BIZDLY_SRC_maxdate;
                        else
                            BDLY_SRC_sh_maxdate=enddate;
                        $(".edate").datepicker( "option", "maxDate",BDLY_SRC_sh_maxdate);
                    }else
                        $(".edate").datepicker( "option", "maxDate",BIZDLY_SRC_enddate);
                }
                var CEXTN_db_sdate = new Date( Date.parse($(".sdate").parent().find('input').datepicker( 'getDate')) );
                $(".edate").datepicker( "option", "minDate",CEXTN_db_sdate);
            }
        }
        /*------------------------------SUCCESS FUNCTION FOR EILIB DATE FUNCTION-------------------------------*/
        function BDLY_SRC_succ_Unitdate(BDLY_SRC_res_Unitdate){
            BDLY_SRC_unitstartdate=BDLY_SRC_res_Unitdate.unitsdate;
            BDLY_SRC_unitenddate=BDLY_SRC_res_Unitdate.unitedate;
            BDLY_SRC_unitinvdate=BDLY_SRC_res_Unitdate.invdate;
            $(".preloader").fadeOut(500);
            if(BDLY_DT_flg_date!=0)
                BIZDLY_SRC_func_date();
        }
        /*----------------------------------COMMON FUNCTION FOR CHECKING DATE WITH IN UNIT VALIDATION PERIOD---------*/
        function BDLY_DT_func_oldposition(){
//SHOWING ERR MSG IF WE HAVE WRONG DATE
            if(BDLY_DT_flg_date==0){
                var BDLY_SRC_sdate_err_tostring=BDLY_SRC_confirmmessages[6].toString();
                var BDLY_SRC_sdate=BDLY_SRC_sdate_err_tostring.replace("[SD]",FormTableDateFormat(BDLY_SRC_unitstartdate));
                var BDLY_SRC_date_err=BDLY_SRC_sdate.replace("[ED]", FormTableDateFormat(BDLY_SRC_unitinvdate))
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_date_err,"success",false);
                var td =$('.clsupdatebtn').closest("tr").children("td");
                $(td).each(function (i) {
                    if($(this).index()<td.length-2 && i!=0 ){
                        $(this).html($(this).data('restore'));
                    }});
                $('.clsupdatebtn').val('Edit').addClass('edit glyphicon glyphicon-edit').removeClass('update').removeClass("clsupdatebtn glyphicon glyphicon-print").removeAttr('disabled');
                $('.edit').removeAttr("disabled").next().removeAttr("disabled");
            }
            else{
                $(this).parent().next().find('span').show().removeClass('delete glyphicon glyphicon-trash').addClass('cancel glyphicon glyphicon-remove');
                $('.edit').attr("disabled", "disabled").next().attr("disabled", "disabled");
                oTable.fnUpdate(record, 1);}
        }
        /*-----------------------------------ACTON TO EDIT EACH ROW IN DATA TABLE---------------------*/
        $(document).on('click','.edit',function(evnt) {
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $(".preloader").show();
            var BDLY_DT_wrongendate='';
            var tr = $(this).closest("tr").index()+1;
            var td =  $(this).closest("tr").children("td");
            var tdcount = td.index()+1;
            var totallenght =td.length;
            $(this).val('Update').removeClass('edit glyphicon glyphicon-edit').addClass("clsupdatebtn glyphicon glyphicon-print");
            BDLY_DT_row_old_vals=[];
            var BDLY_DT_row_old_vals1=[];
            BDLY_DT_flg_date=1;
            $(td).each(function () {
                var tdid =$(this).index();
                var thtext = $("#BDLY_SRC_tb_DataTableId tr:eq(0) th:eq("+tdid+")").attr('class').split(" ")[0];
                var requiredindex=$("#BDLY_SRC_tb_DataTableId tr:eq(0) th:eq("+tdid+")").html().search("\\*");
                BDLY_DT_row_old_vals1.push($(this).text())
                var html = $(this).html();
                $(this).data("restore",html);
                if(tdid<totallenght-1)
                    BDLY_DT_row_old_vals.push(html)
                var dateindex=thtext.search("date");
                if(dateindex!=-1){
                    BDLY_DT_currentunit= $(this).parent().find('td.unitno').html();
                    if(thtext=='date')
                        var input = $('<input type="text" class="unit_based_date datepickerbox datemandtry form-control" style="width:109px;"/>');
                    if(thtext=='ndate')
                        var input = $('<input type="text" class="ndate datepickerbox datemandtry form-control" style="width:109px;" />');
                    if(thtext=='sdate')
                        var input = $('<input type="text" class="sdate datepickerbox datemandtry form-control" style="width:109px;" />');
                    if(thtext=='edate')
                        var input = $('<input type="text" required class="edate datepickerbox datemandtry form-control" style="width:109px;" />');
                    input.val(html);
                    $(this).html(input);
                    var BIZDLY_SRC_migdate=html;
                    var BIZDLY_SRC_migdate = new Date( Date.parse( FormTableDateFormat(html)) );
                    if(thtext=='ndate'){
                        if(BIZDLY_SRC_migdate>new Date()){
                            BDLY_DT_flg_date=0;
                            BDLY_DT_func_oldposition();
                        }
                        else
                            $(".ndate").datepicker({dateFormat: "dd-mm-yy",changeMonth: true,changeYear:true,maxDate:new Date(),beforeShow:function(input, inst){
                                $(inst.dpDiv).removeClass('calendar-off');}
                            });
                    }
                    if((thtext=='date')||(thtext=='edate')||(thtext=='sdate')){
                        $(".datepickerbox").datepicker({dateFormat: "dd-mm-yy",changeMonth: true,changeYear:true,beforeShow:function(input, inst){
                            $(inst.dpDiv).removeClass('calendar-off');}
                        });
                    }
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required').addClass('prevent');
                }
                else if(thtext=='unittextbox')
                {
                    BDLY_SCR_DT_currentfield_hkp_unitno=html;
                    var input = $('<input type="text" required class="unittextbox1 form-control" maxlength="4"  size="4" />');
                    input.val(BDLY_DT_row_old_vals1[(BDLY_DT_row_old_vals1.length)-1]);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                else if(thtext=='textbox')
                {
                    var input = $('<input type="text"  class="textbox autocom form-control" maxlength="200"/>');
                    var tbinputlen=((BDLY_DT_row_old_vals1[(BDLY_DT_row_old_vals1.length)-1]).toString().length)+3;
                    var input = $('<input type="text"  class="textbox autocom form-control" maxlength="200"  size='+tbinputlen+' />');
                    input.val(BDLY_DT_row_old_vals1[(BDLY_DT_row_old_vals1.length)-1]);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                else if (thtext=='textarea' ){
                    var tbinputlen=(BDLY_DT_row_old_vals1[(BDLY_DT_row_old_vals1.length)-1]).toString().length;
                    var  input = $('<textarea class="textarea form-control" ></textarea>');
                    input.val(BDLY_DT_row_old_vals1[(BDLY_DT_row_old_vals1.length)-1]);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('textarea').addClass('required');
                }
                else if(thtext=='amount'){
                    var  input = $('<input type="text"  class="amount BDLY_SRC_nums form-control"  />');
                    input.val(html);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                    $(".BDLY_SRC_nums").prop("title",BDLY_SRC_confirmmessages[5]);
                }
                else if(thtext=='optionalamnt1'){
                    var  input = $('<input type="text"  id="optionalamnt1" class="amount form-control"  />');
                    input.val(html);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                else if(thtext=='optionalamnt2'){
                    var  input = $('<input type="text"  id="optionalamnt2" class="amount form-control"  />');
                    input.val(html);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                else if(thtext=='optionalamnt3'){
                    var  input = $('<input type="text"  id="optionalamnt3" class="amount form-control"  />');
                    input.val(html);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                else if(thtext=='duration'){
                    var  input = $('<input type="text" class="hrs form-control"/>');
                    input.val(html);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                else if(thtext=='month'){
                    var  input = $('<input type="text" class="BDLY_SCR_forperiod datemandtry form-control"/>');
                    input.val(html);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                    $('.BDLY_SCR_forperiod').datepicker( {changeMonth: true,  changeYear: true,  showButtonPanel: true,  dateFormat: 'MM-yy', maxDate:new Date(),
                        onClose: function(dateText, inst) {
                            var month =inst.selectedMonth;
                            var year = inst.selectedYear;
                            $(this).datepicker('setDate', new Date(year, month, 1));
                            $(this).blur();
                        },
                        beforeShow:function(input, inst) {
                            $(inst.dpDiv).addClass('calendar-off');
                        }});
                    $(".BDLY_SCR_forperiod").focus(function () {
                        $(".ui-datepicker-calendar").hide();
                        $("#ui-datepicker-div").position({ my: "left top", at: "left bottom", of: $(this)});});
                }
                else if(thtext=='access_card'){
                    BDLY_SCR_DT_currentfield_access_card=html;
                    var  input = $('<input type="text" class="tb_access_card form-control"/>');
                    input.val(html);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                else if(thtext=='hfp_unit_lb'){
                    var  input = $('<select id="DT_hkp_unit_lb" class="listbox required form-control" value="" style="width:100px;"></select>');
                    input.val(html);
                    var options='';
                    for (var i = 0; i <BDLY_SRC_HKunitnovalues.length; i++) {
                        if(BDLY_SRC_HKunitnovalues[i].value==html){
                            options +='<option value="'+BDLY_SRC_HKunitnovalues[i].value +'" selected>' + BDLY_SRC_HKunitnovalues[i].value + '</option>';
                        }else
                            options +='<option value="'+BDLY_SRC_HKunitnovalues[i].value +'">' + BDLY_SRC_HKunitnovalues[i].value + '</option>';
                    }
                    input.html(options);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                else if(thtext=='unit_category_lb'){
                    var  input = $('<select id="DT_unit_category_lb" class="listbox required form-control" value="" style="width:150px;"></select>');
                    input.val(html);
                    for (var i = 0; i <BDLY_SRC_unitcategoryvalue.length; i++) {
                        if(BDLY_SRC_unitcategoryvalue[i][1]==html)
                        {
                            var BDLY_SRC_lb_category=BDLY_SRC_unitcategoryvalue[i][0];
                        }
                        if(BDLY_SRC_unitcategoryvalue[i][0]==192)continue;
                        if(BDLY_SRC_unitcategoryvalue[i][1]==html){
                            options +='<option value="'+BDLY_SRC_unitcategoryvalue[i][0] +'" selected>' + BDLY_SRC_unitcategoryvalue[i][1] + '</option>';
                        }else
                        {
                            options +='<option value="'+BDLY_SRC_unitcategoryvalue[i][0]+'">' + BDLY_SRC_unitcategoryvalue[i][1] + '</option>';
                        }
                    }
                    input.html(options);
                    $(this).html(input);
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                else if(thtext=='cus_name_lb'){
                    var BDLY_SRC_lb_cusname=$("#BDLY_SRC_lb_cusname").val();
                    if(html!=""){
                        var BDLY_DT_getunit_no =BDLY_DT_row_old_vals1[2];
                        var  input = $('<select id="DT_unitexp_cus_name_lb" class="listbox required form-control"></select>');
                        var options;
                        if(BDLY_SRC_lb_cusname==undefined)
                            BDLY_SRC_unit_custname=html;
                        else
                            BDLY_SRC_unit_custname=BDLY_SRC_lb_cusname;
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_get_cusname1",
                            data:{'BDLY_DT_getunit_no':BDLY_DT_getunit_no},
                            success: function(res) {
                                $('.preloader').hide();
                                var responsearray=JSON.parse(res);
                                BDLY_SRC_DT_success_cusname(responsearray)

                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                        input.html(options);
                        $(this).html(input);
                    }
                    if(requiredindex!=-1)
                        $(this).find('input').addClass('required');
                }
                var selectedexpense=$('#BDLY_SRC_lb_ExpenseList').val();
                var selectedSearchopt=$('#BDLY_SRC_lb_serachopt').val();
                if(selectedexpense==11)
                {
                    $(".hrs").doValidation({rule:'numbersonly',prop:{realpart:2,imaginary:2}}).width(60);
                }
                else if((selectedexpense==1)||(selectedexpense==2)||(selectedexpense==5))
                {
                    var BDLY_SRC_amtrealpart=3;
                    if(selectedexpense==2){
                        BDLY_SRC_amtrealpart=4;}
                    if(selectedexpense==1 && thtext=='optionalamnt1')
                    {
                        $(".amount").doValidation({rule:'numbersonly',prop:{realpart:BDLY_SRC_amtrealpart,imaginary:2}}).width(65);
                    }
                    else {
                        $(".amount").doValidation({rule: 'numbersonly',prop: {integer: true, realpart: BDLY_SRC_amtrealpart, imaginary: 2}}).width(65);
                    }
                }
                else if(selectedexpense==10)
                {
                    $(".amount").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}}).width(70);
                }
                else{
                    var realpart =((selectedexpense==3)?5:3);
                    var width =((realpart==3)?50:70);
                    $(".amount").doValidation({rule:'numbersonly',prop:{realpart:realpart,imaginary:2}}).width(width);
                }
                if(selectedexpense==3)
                {
                    $(".textbox").doValidation({rule:'general',prop:{autosize:true}});//unit exp invoice from autosize textbox
                }
                if(($('#BDLY_SRC_lb_ExpenseList').val()==10)||($('#BDLY_SRC_lb_ExpenseList').val()==11)||($('#BDLY_SRC_lb_ExpenseList').val()==12))
                {
                    $(".preloader").fadeOut(500);
                }
                $(".unittextbox1").doValidation({rule:'numbersonly',prop:{realpart:4,leadzero:true}});
                $(".tb_access_card").doValidation({rule:'numbersonly',prop:{realpart:7}}).width(80);
            });
            $(this).parent().next().find('span').show().removeClass('delete glyphicon glyphicon-trash').addClass('cancel glyphicon glyphicon-remove');
            $('.edit').each(function (i,obj) {
                $('#'+obj.id).removeClass('edit').addClass('EditRemove');
            });
            $('.delete').each(function (i,obj) {
                $('#'+obj.id).removeClass('delete').addClass('DeleteRemove');
            });
            var td =  $(this).closest("tr").children("td");
            $(td).each(function () {
                var tdid =$(this).index();
                var thtext = $("#BDLY_SRC_tb_DataTableId tr:eq(0) th:eq("+tdid+")").attr('class').split(" ")[0];
                if((thtext=='unit')&&($('#BDLY_SRC_lb_ExpenseList').val()!=11)&&($('#BDLY_SRC_lb_ExpenseList').val()!=12)){
                    BDLY_SRC_unitenddate=null,
                        BDLY_SRC_unitstartdate=null,
                        BDLY_SRC_unitinvdate=null;
                    $(".preloader").show();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDLY_SRC_getUnitDate",
                        data:{'unidate':$(this).html()},
                        success: function(res) {
                            $('.preloader').hide();
                            var responsearray=JSON.parse(res);
                            BDLY_SRC_succ_Unitdate(responsearray)

                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
            });
            if($('#BDLY_SRC_lb_ExpenseList').val()==3)
                auto();
        });
        function auto(){
            highlightSearchText();
            $('.autocom').autocomplete({
                source: BDLY_SRC_arr_unitcmts,
                select:AutoCompleteSelectHandler
            });
        }
//FUNCTION TO VALIDATE AMOUNT TEXT BOX HAVING MORE THAN ONE AMT FOR ELECTRICITY,FACILITY USE
        $(document).on('keypress keydown','#optionalamnt1,#optionalamnt2,#optionalamnt3',function() {
            if($(this).attr('id')=='optionalamnt1'){
                $(this).addClass('required');
                $('#optionalamnt2').val('').removeClass('required');
                if($('#optionalamnt3').length)
                    $('#optionalamnt3').val('').removeClass('required');
            }
            else if($(this).attr('id')=='optionalamnt2') {
                $(this).addClass('required');
                $('#optionalamnt1').val('').removeClass('required');
                if($('#optionalamnt3').length)
                    $('#optionalamnt3').val('').removeClass('required');
            }
            else if($(this).attr('id')=='optionalamnt3') {
                $(this).addClass('required');
                $('#optionalamnt1').val('').removeClass('required');
                $('#optionalamnt2').val('').removeClass('required');
            }
        });
        /*---------------------------------------------------ACTION ON UNIT EXPENSE CATEGORY CHANGE --------------------*/
        $(document).on('change','#DT_unit_category_lb',function(evnt) {
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            var BDLY_DT_unit_category_lb=$(this).val();
            $(this).parent().next().html('');
            if(BDLY_DT_unit_category_lb==23){
                var BDLY_DT_getunit_no =$(this).parent().parent().find('td.unitno').html();
                var  input = $('<select id="DT_unitexp_cus_name_lb" class="listbox form-control"></select>');
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDLY_SRC_get_cusname2",
                    data:{'BDLY_DT_getunit_no':BDLY_DT_getunit_no},
                    success: function(res) {
                        $('.preloader').hide();
                        var response=JSON.parse(res);
                        BDLY_SRC_DT_success_cusname(response)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
                $(this).parent().next().html(input);
            }
        });
        /*---------------------------------------------------BIND CUSTOMER NAME IN LIST BOX--------------------*/
        function BDLY_SRC_DT_success_cusname(response){
            Unit_Exp_Cusname_global=response;
            var options;
            if(Unit_Exp_Cusname_global.length==0){
                BDLY_SRC_purchasecard=0;
                $('#DT_unitexp_cus_name_lb').hide().removeClass('required');
                show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_confirmmessages[26],"success",false);
            }
            else{
                BDLY_SRC_purchasecard=1;
                for (var i = 0; i <Unit_Exp_Cusname_global.length; i++) {
                    var firstname_lastname =Unit_Exp_Cusname_global[i].value;
                    if($("#BDLY_SRC_lb_cusname").val()==undefined)
                    {
                        var Unit_Exp_Cusname_srch=Unit_Exp_Cusname_global[i].value;
                    }
                    else
                    {
                        var Unit_Exp_Cusname_srch=Unit_Exp_Cusname_global[i].key;
                    }
                    if(Unit_Exp_Cusname_srch==BDLY_SRC_unit_custname)
                        options +='<option value="'+Unit_Exp_Cusname_global[i].key +'" selected>' +firstname_lastname+ '</option>';
                    else
                        options +='<option value="'+Unit_Exp_Cusname_global[i].key +'">' +firstname_lastname+ '</option>';
                }
                $('#DT_unitexp_cus_name_lb').html(options).show().addClass('required');
            }
            if(BDLY_SRC_unitenddate!=null && BDLY_SRC_unitenddate!='null' )
                $(".preloader").fadeOut(500);
        }
        $(document).on('focus','#DT_unitexp_cus_name_lb, #DT_unit_category_lb',function() {
            if($(this).attr('id')=='DT_unitexp_cus_name_lb')
                $("#DT_unitexp_cus_name_lb option[value='']").remove();
            else
                $("#DT_unit_category_lb option[value='']").remove();
        });
        /*--------------------------------------------------update each row in database--------------------*/
        $(document).on('click','.update',function() {
            var allGood = true;
            $( ".autocom" ).autocomplete( "destroy" );
            $('.ui-autocomplete-input').removeClass('ui-autocomplete-input').removeClass("autocom");
            var requiredtd =  $(this).closest("tr").children("td").find(".required");
            requiredtd.each(function(){
                var val =$.trim($(this).val());
                if(val == "" || val == 0 || $(this).hasClass('invalid') ) {
                    $(this).animate({'backgroundColor' : '#F8E2CE'});
                    $(this).animate({'backgroundColor' : '#FFFFCC'}, 100);
                    allGood = false;
                } });
            if(allGood==false)
                return false;
            $(".preloader").show();
            BDLY_DT_row_new_vals=[];
            var td =  $(this).closest("tr").children("td");
            var BDLY_SRC_selectedexptype=$("#BDLY_SRC_lb_ExpenseList").val()
            var selectedSearchopt=$("#BDLY_SRC_lb_serachopt").val();
            var totallenght= td.length;
            $(td).each(function () {
                var tdid =$(this).index();
                if(tdid==1)
                    BDLY_DT_row_new_vals.push($(this).html())
                if(tdid>1 && tdid<totallenght-2){
                    var oldinput= $(this).children();
                    if(oldinput.length){
                        BDLY_DT_row_new_vals.push(oldinput.val())}
                    else {BDLY_DT_row_new_vals.push($(this).html());
                    }
                    if(oldinput.hasClass('listbox'))
                        var val =oldinput.find('option:selected').text();
                    else var val =oldinput.val();
                }
            });
//CALL FUNCTION TO UPDATE RECORD IN DB
            $.ajax({
                type: "POST",
                url: controller_url+"BDLY_SRC_UpdaterowData",
                data:{'BDLY_DT_row_new_vals':BDLY_DT_row_new_vals,'BDLY_DT_row_old_vals':BDLY_DT_row_old_vals,'BDLY_SRC_lb_ExpenseList':$("#BDLY_SRC_lb_ExpenseList").val(),'selectedSearchopt':selectedSearchopt},
                success: function(res) {
                    $('.preloader').hide();
                    BDLY_SRC_UpdaterowData_result(res)
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
//SUCCESS FUNCTION TO UPDATE DATA TABLE N TO SHOW CONFIRMATION MESSAGE
            function BDLY_SRC_UpdaterowData_result(BDLY_successflag){
                var selectedSearchopt=$("#BDLY_SRC_lb_serachopt").val()
                if(BDLY_successflag==1)
                {
                    if(BDLY_SRC_selectedexptype==10||selectedSearchopt==198)
                    {
                        $(this).val('Edit').addClass("edit glyphicon glyphicon-edit").addClass("Currentbtn").removeClass("update glyphicon glyphicon-print");
                        $('.cancel').hide();

                    }
                    else
                    {
                        $(this).val('Edit').addClass("edit glyphicon glyphicon-edit").addClass("Currentbtn").removeClass("update glyphicon glyphicon-print");
                        $(this).parent().next().find('span').show().removeClass('cancel glyphicon glyphicon-remove').addClass('delete glyphicon glyphicon-trash');
                    }
                    $(".Currentbtn").removeClass("Currentbtn");
                    $(".edit").removeAttr("disabled").next().removeAttr("disabled");
                    BDLY_SRC_sucsval=1;
                    var selectedSearchopt=$("#BDLY_SRC_lb_serachopt").val(),
                        BDLY_SRC_selectedexptype=$("#BDLY_SRC_lb_ExpenseList").val(),
                        BDLY_SRC_getsearch_optiontypeval=BDLY_SRC_getsearch_optiontype(selectedSearchopt);
//CHK SEARCH OPTION TYPE
                    if(BDLY_SRC_getsearch_optiontypeval=="COMMENTS"||
                        BDLY_SRC_getsearch_optiontypeval=="CAR NO"||
                        BDLY_SRC_getsearch_optiontypeval=="INVOICE ITEMS"||
                        BDLY_SRC_getsearch_optiontypeval=="INVOICE FROM"||
                        BDLY_SRC_getsearch_optiontypeval=="UNIT NO"||
                        BDLY_SRC_getsearch_optiontypeval=="CARD NO"||
                        BDLY_SRC_getsearch_optiontypeval=="CLEANER NAME"||
                        BDLY_SRC_getsearch_optiontypeval=="ACCOUNT NO"||
                        BDLY_SRC_getsearch_optiontypeval=="VOCIE NO"||
                        BDLY_SRC_getsearch_optiontypeval=="SERVICED BY"||
                        BDLY_SRC_getsearch_optiontypeval=="INVOICE TO"||
                        BDLY_SRC_getsearch_optiontypeval=="CATEGORY"
                    )
                    {
                        $("#BDLY_SRC_div_searchresult,#BDLY_SRC_div_searchresult_head,#BDLY_SRC_nodyndataerr").html('');
                        $('#BDLY_btn_pdf').hide();
                        if(BDLY_SRC_sucsval==1)
                        {
                            $(".preloader").fadeOut(500);
                            show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_SRC_confirmmessages[0].replace('[TYPE]',$('#BDLY_SRC_lb_ExpenseList').find('option:selected').text()),"success",false);
                        }
                    }
                    else
                    {
                        $('.preloader').show();
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BDLY_SRC_getAnyTypeExpData",
                            data:$('#BDLY_INPUT_form_dailyentry').serialize(),
                            success: function(res) {
                                $('.preloader').hide();
                                var response=JSON.parse(res);
                                BDLY_SRC_UpdateDataTable(response)
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                }
                else
                {
                    $(".preloader").fadeOut(500);
                    if(BDLY_successflag==0)
                        var BDLY_successflag=BDLY_SRC_confirmmessages[3];
                    show_msgbox("BIZ EXPENSE DAILY ENTRY/SEARCH/UPDATE/DELETE",BDLY_successflag,"success",false);
                }
            }
        });
        /*------------------------------------------FUNCTION TO AUTOCOMPLETE SEARCH TEXT--------------------------------------------------------*/
        function BDLY_SRC_success_autodata(BDLY_autocompl_response)
        {
///*--------------------------------------------CALL FUNCTION TO HIGHLIGHT SEARCH TEXT---------------------------------------------------*/
            var searchoption_elem =$('#BDLY_SRC_tr_searchopt_enddate').next().find('.auto');
            var response_len = BDLY_autocompl_response.length;
            highlightSearchText();
            searchoption_elem.autocomplete({
                source: BDLY_autocompl_response,
                select:AutoCompleteSelectHandler
            });
            if(response_len>0){
                searchoption_elem.removeAttr("disabled").attr('placeholder',response_len+' Records Matching').val('');
            }
            else{
                searchoption_elem.attr("disabled", "disabled").attr('placeholder',BDLY_SRC_replaceerrmsg(BDLY_SRC_finalerrr[2])).val('');
            }
            $(".preloader").fadeOut(500);
        }
        /*----------------------------------------------------FUNCTION TO HIGHLIGHT SEARCH TEXT------------------------------------------------------------------------*/
        function highlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            };
        }
        /*---------------------------------------------------FUNCTION TO GET SELECTED VALUE----------------------------------------------------------------*/
        function AutoCompleteSelectHandler(event, ui) {
            BDLY_SRC_flag_autocom=ui.item.value;
            if(BDLY_SRC_flag_autocom!='' && $('#BDLY_SRC_startdate').val()!="" && $('#BDLY_SRC_enddate').val()!="" )
                $('#BDLY_SRC_btn_search').removeAttr("disabled");
            else
                $('#BDLY_SRC_btn_search').attr("disabled", "disabled");
        }
    });
</script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>BIZ EXPENSE DAILY ENTRY/ SEARCH/ UPDATE/ DELETE</b></h4></div>
    <form id="BDLY_INPUT_form_dailyentry" class="form-horizontal content"  method="post" action="<?php echo site_url("EXPENSE/Ctrl_Pdf/pdfexportbizexpense") ?>">
        <div class="panel-body">
            <div style="padding-bottom: 15px">
                <div class="radio">
                    <label><input type="radio" name="optradio" value="bizentryform" class="BE_rd_selectform">ENTRY</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="optradio" value="bizsearchform" class="BE_rd_selectform">SEARCH/ UDATE/ DELETE</label>
                </div>
            </div>
            <div id="biz_expenseentryform" hidden>
                <table id="BDLY_INPUT_table_errormsg">
                </table>
                <div class="form-group">
                    <label  id='BDLY_INPUT_lbl_exptype' class="col-sm-2" hidden>TYPE OF EXPENSE <em>*</em></label>
                    <div class="col-sm-3">
                        <select id='BDLY_INPUT_lb_selectexptype' class="form-control" name="BDLY_INPUT_lb_selectexptype" hidden  >
                        </select>
                    </div>
                </div>
                <div class="form-group" id="typeofexpense">
                    <label  id='BDLY_INPUT_lbl_unitno' class="col-sm-2" hidden>UNIT NO<em>*</em></label>
                    <div class="col-sm-2">
                        <select id='BDLY_INPUT_lb_unitno' class="form-control" name="BDLY_INPUT_lb_unitno" hidden >
                            <option value='SELECT' selected="selected"> SELECT</option>
                        </select>
                    </div>
                </div>
                <!--CREATING AIRCON ELEMENT-->
                <div id="BDLY_INPUT_tble_aircon" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_serviceby' class="col-sm-2">AIRCON SERVICE BY<em>*</em></label>
                        <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_serviceby" name="BDLY_INPUT_tb_serviceby" class="BDLY_INPUT_class_submitvalidate autosize form-control" readonly  >
                            <input type="hidden" id="BDLY_INPUT_hidden_edasid" name="BDLY_INPUT_hidden_edasid">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_air_date' class="col-sm-2" >DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_air_date" name="BDLY_INPUT_tb_air_date" class="datepickdate BDLY_INPUT_class_submitvalidate datemandtry form-control" placeholder="Date" >
                                <label for="BDLY_INPUT_tb_air_date" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_comment' class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea  name="BDLY_INPUT_ta_aircon_comments" id="BDLY_INPUT_ta_aircon_comments" class="form-control" style="height:116px;" placeholder="Comments"></textarea></div>
                    </div>
                </div>
                <!--CREATING OF CAR PARK ELEMENT-->
                <div id="BDLY_INPUT_tble_cardpark" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_carno' class="col-sm-2">CAR NO<em>*</em></label>
                        <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_carno" name="BDLY_INPUT_tb_carno" placeholder="Car No" class="BDLY_INPUT_class_submitvalidate rdonly form-control" readonly  ></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_cp_invoicedate' class="col-sm-2" >INVOICE DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_cp_invoicedate" name="BDLY_INPUT_tb_cp_invoicedate" placeholder="Invoice Date" class="BDLY_INPUT_class_submitvalidate datemandtry form-control"  >
                                <label for="BDLY_INPUT_tb_cp_invoicedate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_cp_fromdate' class="col-sm-2">FROM PERIOD<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_cp_fromdate" name="BDLY_INPUT_tb_cp_fromdate" placeholder="From Period" class=" BDLY_INPUT_class_submitvalidate datemandtry form-control"  >
                                <label for="BDLY_INPUT_tb_cp_fromdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_cp_todate' class="col-sm-2">TO PERIOD<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_cp_todate" name="BDLY_INPUT_tb_cp_todate"  placeholder="To Period"class="BDLY_INPUT_class_submitvalidate datemandtry form-control"  >
                                <label for="BDLY_INPUT_tb_cp_todate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_cp_invoiceamt' class="col-sm-2">INVOICE AMOUNT<em>*</em></label>
                        <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_cp_invoiceamt" name="BDLY_INPUT_tb_cp_invoiceamt" placeholder="Invoice Amount" class="BDLY_INPUT_class_submitvalidate amtonly BDLY_INPUT_class_numonly form-control" style="width:70px" ></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_cp_comment' class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_cp_comments" id="BDLY_INPUT_ta_cp_comments" placeholder="Comments" style="height:116px;" class="BDLY_INPUT_class_submitvalidate form-control" ></textarea></div>
                    </div>
                </div>
                <!--CREATING OF DIGITAL VOICE ELEMENT-->
                <div id="BDLY_INPUT_tble_digitalvoice" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_digi_invoiceto' class="col-sm-2">INVOICE TO<em>*</em></label>
                        <div class="col-sm-3"><select id='BDLY_INPUT_lb_digi_invoiceto' name="BDLY_INPUT_lb_digi_invoiceto" class="BDLY_INPUT_class_hksubmitvalidate rdonly form-control" readonly>
                            </select></div></div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_digi_voiceno' class="col-sm-2">DIGITAL VOICE NO<em>*</em></label>
                        <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_digi_voiceno" name="BDLY_INPUT_tb_digi_voiceno" placeholder="Digital voice No" class="BDLY_INPUT_class_submitvalidate rdonly form-control" readonly  ></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_digi_accno' class="col-sm-2">ACCOUNT NO<em>*</em></label>
                        <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_digi_accno" name="BDLY_INPUT_tb_digi_accno" placeholder="Account No" class="BDLY_INPUT_class_submitvalidate rdonly form-control"  readonly></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_digi_invoicedate' class="col-sm-2">INVOICE DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_digi_invoicedate" name="BDLY_INPUT_tb_digi_invoicedate" placeholder="Invoice Date" class=" BDLY_INPUT_class_submitvalidate datemandtry form-control"  >
                                <label for="BDLY_INPUT_tb_digi_invoicedate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_digi_fromdate' class="col-sm-2">FROM PERIOD<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_digi_fromdate" name="BDLY_INPUT_tb_digi_fromdate" placeholder="From Period" class=" BDLY_INPUT_class_submitvalidate datemandtry form-control"  >
                                <label for="BDLY_INPUT_tb_digi_fromdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_digi_todate' class="col-sm-2">TO PERIOD<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_digi_todate" placeholder="To Period" name="BDLY_INPUT_tb_digi_todate"  class=" BDLY_INPUT_class_submitvalidate datemandtry form-control" >
                                <label for="BDLY_INPUT_tb_digi_todate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_digi_invoiceamt' class="col-sm-2" >INVOICE AMOUNT<em>*</em></label>
                        <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_digi_invoiceamt" placeholder="Invoice Amount" name="BDLY_INPUT_tb_digi_invoiceamt" class="BDLY_INPUT_class_submitvalidate includeminus BDLY_INPUT_class_numonly form-control" style="width:70px"></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_digi_comment' class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_digi_comments" id="BDLY_INPUT_ta_digi_comments" placeholder="Comments" style="height:116px;" class="BDLY_INPUT_class_submitvalidate form-control"></textarea></div>
                    </div>
                </div>
                <!--CREATING OF FACILITY ELEMENT-->
                <div id="BDLY_INPUT_tble_facility" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_fac_invoicedate' class="col-sm-2">DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_fac_invoicedate" placeholder="Date" name="BDLY_INPUT_tb_fac_invoicedate" class=" form-control datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry" >
                                <label for="BDLY_INPUT_tb_fac_invoicedate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-9">
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label><input type="radio" id="BDLY_INPUT_radio_fac_deposit" name="BDLY_INPUT_radio_facility"class="BDLY_INPUT_class_submitvalidate" value="deposit">DEPOSIT</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input style="width:70px" type="text" id="BDLY_INPUT_tb_fac_depositamt" name="BDLY_INPUT_tb_fac_depositamt"  class=" amtonly BDLY_INPUT_class_submitvalidate BDLY_INPUT_class_numonly form-control" hidden >
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <div class="radio">
                                        <label><input type="radio" id="BDLY_INPUT_radio_fac_invoiceamt" name="BDLY_INPUT_radio_facility"class="BDLY_INPUT_class_submitvalidate" value="invoiceamount">INVOICE AMOUNT</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input style="width:70px" type="text" id="BDLY_INPUT_tb_fac_invoiceamt" name="BDLY_INPUT_tb_fac_invoiceamt" class="amtonly BDLY_INPUT_class_submitvalidate BDLY_INPUT_class_numonly form-control" hidden >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2" id='BDLY_INPUT_lbl_fac_comment' >COMMENTS</label>
                        <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_fac_comments" id="BDLY_INPUT_ta_fac_comments" placeholder="Comments" class="BDLY_INPUT_class_submitvalidate form-control" style="height:116px;" ></textarea></div>
                    </div>
                </div>
                <!--CREATING OF MOVING IN AND OUT ELEMENT-->
                <div id="BDLY_INPUT_tble_moving" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_mov_date' class="col-sm-2">INVOICE DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_mov_date" name="BDLY_INPUT_tb_mov_date" placeholder="Invoice Date" class="BDLY_INPUT_class_hksubmitvalidate datepickdate datemandtry form-control"  >
                                <label for="BDLY_INPUT_tb_mov_date" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_mov_invoiceamt' class="col-sm-2">INVOICE AMOUNT<em>*</em></label>
                        <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_mov_invoiceamt" name="BDLY_INPUT_tb_mov_invoiceamt" placeholder="Invoice Amount" class="BDLY_INPUT_class_submitvalidate thramtonly BDLY_INPUT_class_numonly form-control" style="width:70px" ></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_mov_comment' class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_mov_comments" id="BDLY_INPUT_ta_mov_comments" placeholder="Comments" style="height:116px;" class="BDLY_INPUT_class_submitvalidate form-control" ></textarea></div>
                    </div>
                </div>
                <!--CREATING OF PURCHASE ELEMENT-->
                <div id="BDLY_INPUT_tble_purchase" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_access_cardno' class="col-sm-2">CARD NO<em>*</em></label>
                        <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_access_cardno" name="BDLY_INPUT_tb_access_cardno" placeholder="Card No" style="width:85px;" class="numonly BDLY_INPUT_class_hksubmitvalidate form-control" ></div>
                        <label class="errormsg" id="BDLY_INPUT_lbl_pcarderrmsg" ></label>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_access_date' class="col-sm-2">INVOICE DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_access_date" name="BDLY_INPUT_tb_access_date" placeholder="Invoice Date"  class="datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry form-control" >
                                <label for="BDLY_INPUT_tb_access_date" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_access_invoiceamt' class="col-sm-2">INVOICE AMOUNT<em>*</em></label>
                        <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_access_invoiceamt" name="BDLY_INPUT_tb_access_invoiceamt" placeholder="Invoice Amount" style="width:70px;" class="BDLY_INPUT_class_hksubmitvalidate amtonly BDLY_INPUT_class_numonly form-control" ></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_access_comment' class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_access_comments" id="BDLY_INPUT_ta_access_comments" placeholder="Comments" style="height:116px;" class="BDLY_INPUT_class_hksubmitvalidate form-control" ></textarea></div>
                    </div>
                </div>
                <!--CREATING OF PETTYCASH ELEMENT-->
                <div id="BDLY_INPUT_tble_pettycash" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_petty_balance' class="col-sm-2" >CURRENT BALANCE<em>*</em></label>
                        <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_petty_balance" name="BDLY_INPUT_tb_petty_balance" placeholder="Current Balance" style="width:80px;" class="rdonly form-control" readonly ></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_petty_date'class="col-sm-2" >DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_petty_date" name="BDLY_INPUT_tb_petty_date" placeholder="Date" class="datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry form-control">
                                <label for="BDLY_INPUT_tb_petty_date" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div><!--datepickdate-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-9">
                            <div class="row form-group">
                                <div class="col-md-2">
                                    <div class="radio">
                                        <label><input  type="radio" id="BDLY_INPUT_radio_petty_cashin" name="BDLY_INPUT_radio_petty" class="BDLY_INPUT_class_submitvalidate" value="cashin">CASH IN</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" id="BDLY_INPUT_tb_petty_cashin" name="BDLY_INPUT_tb_petty_cashin"  class="BDLY_INPUT_class_submitvalidate BDLY_INPUT_class_numonly form-control"  style="width:80px" hidden>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-2">
                                    <div class="radio">
                                        <label><input type="radio" id="BDLY_INPUT_radio_petty_cashout" name="BDLY_INPUT_radio_petty" class="BDLY_INPUT_class_submitvalidate" value="cashout">CASH OUT</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" id="BDLY_INPUT_tb_petty_cashout" name="BDLY_INPUT_tb_petty_cashout" class="BDLY_INPUT_class_submitvalidate BDLY_INPUT_class_numonly form-control"  style="width:80px" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_petty_invoiceitem' class="col-sm-2">INVOICE ITEM<em>*</em></label>
                        <div class="col-sm-4"><textarea id="BDLY_INPUT_ta_petty_invoiceitem" name="BDLY_INPUT_ta_petty_invoiceitem" placeholder="Invoice Item" style="height:116px;" class="BDLY_INPUT_class_submitvalidate form-control" ></textarea></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_petty_comment'class="col-sm-2" >COMMENTS</label>
                        <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_petty_comments" id="BDLY_INPUT_ta_petty_comments" placeholder="Comments" class="form-control" style="height:116px;" ></textarea></div>
                    </div>
                </div>
                <!--CREATING OF HOUSE KEEPING ELEMENT-->
                <div id="BDLY_INPUT_tble_housekeeping" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_house_cleanername' class="col-sm-2">CLEANER NAME<em>*</em></label>
                        <div class="col-sm-3"><select id='BDLY_INPUT_lb_house_cleanername' name="BDLY_INPUT_lb_house_cleanername" class="BDLY_INPUT_class_submitvalidate form-control"  >
                                <option value='SELECT' selected="selected"> SELECT</option>
                            </select></div></div>
                    <div><input type="hidden" id="BDLY_INPUT_hidden_edeid" name="BDLY_INPUT_hidden_edeid"></div>
                    <div><table id="BDLY_INPUT_tble_radioclearnername"></table></div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_house_date' class="col-sm-2">WORK DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_house_date" name="BDLY_INPUT_tb_house_date" placeholder="Work Date" class="datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry form-control"  >
                                <label for="BDLY_INPUT_tb_house_date" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_house_duration' class="col-sm-2">DURATION<em>*</em></label>
                        <div class="col-sm-4" style="padding-left: 0px">
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_house_hours" name="BDLY_INPUT_tb_house_hours" placeholder="Hrs" class="BDLY_INPUT_class_submitvalidate hrnumonly BDLY_INPUT_class_numonly form-control" style="width:50px;" ></div>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_house_min" name="BDLY_INPUT_tb_house_min"  placeholder="Mins" class="BDLY_INPUT_class_submitvalidate hrnumonly BDLY_INPUT_class_numonly form-control"  style="width:50px;" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_house_desc' class="col-sm-2">DESCRIPTION<em>*</em></label>
                        <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_house_desc" id="BDLY_INPUT_ta_house_desc" placeholder="Description" class="BDLY_INPUT_class_submitvalidate form-control" style="height:116px;"></textarea></div>
                    </div>
                </div>
                <!--CREATING OF HOUSEKEEPING PAYMENT ELEMENT-->
                <div id="BDLY_INPUT_tble_housepayment" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_pay_unitno' class="col-sm-2">UNIT NO<em>*</em></label>
                        <div class="col-sm-2"><select id='BDLY_INPUT_tb_pay_unitno' name="BDLY_INPUT_tb_pay_unitno" class="BDLY_INPUT_class_hksubmitvalidate form-control"  >
                                <option value='SELECT' selected="selected"> SELECT</option>
                            </select></div>
                        <input class="btn" type="button"  id="BDLY_INPUT_btn_addbutton" name="BDLY_INPUT_btn_addbutton" value="ADD"  />
                        <label class="errormsg" hidden id='BDLY_INPUT_lbl_pay_uniterrmsg' ></label>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_pay_invoiceamt'  class="col-sm-2">INVOICE AMOUNT<em>*</em></label>
                        <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_pay_invoiceamt" name="BDLY_INPUT_tb_pay_invoiceamt" placeholder="Invoice Amount" class="BDLY_INPUT_class_submitvalidate thramtonly BDLY_INPUT_class_numonly form-control" style="width:70px;" ></div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_pay_forperiod' class="col-sm-2">FOR PERIOD<em>*</em></label>
                        <div class="col-sm-9" style="padding:0px;">
                            <div class="col-sm-3">
                                <div class="input-group addon">
                                    <input type="text" id="BDLY_INPUT_tb_pay_forperiod" name="BDLY_INPUT_tb_pay_forperiod" placeholder="For Period" class="BDLY_INPUT_class_forperiod BDLY_INPUT_class_hksubmitvalidate datemandtry form-control">
                                    <label for="BDLY_INPUT_tb_pay_forperiod" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_pay_paiddate' class="col-sm-2">PAID DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" id="BDLY_INPUT_tb_pay_paiddate" name="BDLY_INPUT_tb_pay_paiddate" placeholder="Paid Date" class="datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry form-control" >
                                <label for="BDLY_INPUT_tb_pay_paiddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_pay_comment' class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_pay_comments" id="BDLY_INPUT_ta_pay_comments" placeholder="Comments" class="form-control" style="height:116px;"></textarea></div>
                    </div>
                </div>
                <!--CREATING OF ELECTRICITY ELEMENT-->
                <div class="table-responsive">
                    <table id="BDLY_INPUT_tble_electricity" cellpadding="10" cellspacing="2" hidden>
                        <tr> <td><label id="BDLY_INPUT_lbl_elect_unit" >UNIT</label><em>*</em> </td>
                            <td nowrap><label  id="BDLY_INPUT_lbl_elect_invoiceto" >INVOICE TO</label><em>*</em></td>
                            <td nowrap> <label id="BDLY_INPUT_lbl_elect_invoicedate" >INVOICE DATE</label><em>*</em> </td>
                            <td nowrap><label id="BDLY_INPUT_lbl_elect_fromperiod" >FROM PERIOD</label><em>*</em> </td>
                            <td nowrap><label id="BDLY_INPUT_lbl_elect_toperiod" >TO PERIOD</label><em>*</em></td>
                            <td nowrap><label id="BDLY_INPUT_lbl_elect_payment"  >PAYMENT OF</label><em>*</em> </td>
                            <td nowrap><label id="BDLY_INPUT_lbl_elect_amount" >AMOUNT</label><em>*</em> </td>
                            <td nowrap><label id="BDLY_INPUT_lbl_elect_comments" >COMMENTS</label> </td>
                            <td ><label id="BDLY_INPUT_lbl_elect_add" ></label> </td>
                            <td ><label id="BDLY_INPUT_lbl_elect_del" ></label> </td>
                        </tr>
                        <tr><td> <select  class="BDLY_INPUT_class_unit submultivalid form-control"  name="BDLY_INPUT_lb_elect_unit" id="BDLY_INPUT_lb_elect_unit-1" hidden><option value="">SELECT</option></select> </td>
                            <td><input  class=' submultivalid rdonly form-control'  type="text" name ="BDLY_INPUT_tb_invoiceto" id="BDLY_INPUT_tb_invoiceto1"  hidden readonly/><input type="text" id="BDLY_INPUT_hidden_ecnid_elec1" name="BDLY_INPUT_hidden_ecnid_elec" hidden> </td>
                            <td><input  class='eledatepicker submultivalid datemandtry form-control'  type="text" name ="BDLY_INPUT_db_invoicedate" id="BDLY_INPUT_db_invoicedate1" style="width:75px;" hidden /> </td>
                            <td><input  class='eledatepicker submultivalid datemandtry form-control'  type="text" name ="BDLY_INPUT_db_fromperiod" id="BDLY_INPUT_db_fromperiod1" style="width:75px;" hidden/> </td>
                            <td><input  class='eledatepicker submultivalid datemandtry form-control'  type="text" name ="BDLY_INPUT_db_toperiod" id="BDLY_INPUT_db_toperiod1" style="width:75px;" hidden/> </td>
                            <td><select  name="BDLY_INPUT_lb_elect_payment" class="submultivalid amtentry form-control" id='BDLY_INPUT_lb_elect_payment1' hidden><option value="" >SELECT</option></select></td>
                            <td><input  class="amtonlyvalidation submultivalid BDLY_INPUT_class_numonly form-control" type="text" name ="BDLY_INPUT_tb_elect_amount" id="BDLY_INPUT_tb_elect_amount1" style="width:50px;" hidden /> <input  class="amtonlyvalidation submultivalid BDLY_INPUT_class_numonly"  type="text" name ="BDLY_INPUT_tb_elect_minusamt" id="BDLY_INPUT_tb_elect_minusamt1" style="width:50px;" hidden /><input type="text" id="BDLY_INPUT_hidden_amt_elec1" name="BDLY_INPUT_hidden_amt_elec" hidden></td>
                            <td><textarea row="2" class=" submultivalid form-control" name ="BDLY_INPUT_ta_comments" id="BDLY_INPUT_ta_comments1" hidden ></textarea> </td><td>
                                <input type='button' value='+' class='addbttn' alt='Add Row' height='30' width='30' name ='BDLY_INPUT_add[]' id='BDLY_INPUT_add1'disabled > </td><td>
                                <input  type='button' value='-' class='deletebttn' alt='delete Row' height='30' width='30' name ='BDLY_INPUT_delete[]' id='BDLY_INPUT_del1' disabled ></td>
                        </tr>
                    </table>
                </div>
                <!--CREATING OF UNIT EXPENSE ELEMENT-->
                <div class="table-responsive">
                    <table id="BDLY_INPUT_tble_unitexpense" cellpadding="10" cellspacing="2" style="width:1220px;"hidden>
                        <tr> <td><label id="BDLY_INPUT_lbl_uexp_unit" >UNIT</label><em>*</em> </td>
                            <td ><label  id="BDLY_INPUT_lbl_uexp_category" >CATEGORY</label><em>*</em></td>
                            <td ><label  id="BDLY_INPUT_lbl_uexp_customer" hidden>CUSTOMER<em>*</em></label></td>
                            <td ><label  id="BDLY_INPUT_lbl_uexp_customerid" hidden></label></td>
                            <td > <label id="BDLY_INPUT_lbl_uexp_invoicedate" >INVOICE DATE</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_invoiceitem" >INVOICE ITEM</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_invoicefrom" >INVOICE FROM</label><em>*</em></td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_amount" >AMOUNT</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_comments" >COMMENTS</label> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_add" ></label> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_del" ></label> </td>
                        </tr>
                        <tr><td> <select  class="BDLY_INPUT_uexp_class_unit uexp_submultivalid "  name="BDLY_INPUT_lb_uexp_unit[]" id="BDLY_INPUT_lb_uexp_unit-1" style="width:90px;" hidden><option value="">SELECT</option></select> </td>
                            <td><select  name="BDLY_INPUT_lb_uexp_category[]" class="uexp_submultivalid BDLY_INPUT_uexp_class_category " id='BDLY_INPUT_lb_uexp_category-1' style="width:140px;" hidden><option value="" >SELECT</option></select></td>
                            <td><select  name="BDLY_INPUT_lb_uexp_customer[]" class="uexp_submultivalid BDLY_INPUT_uexp_class_custname" id='BDLY_INPUT_lb_uexp_customer1' style="width:160px;" hidden><option value="" >SELECT</option></select></td>
                            <td ><table id="multiplecustomer-1" width="250px" hidden></table>
                            <td><input  class='datepickdate uexp_submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_uexp_invoicedate[]" id="BDLY_INPUT_db_uexp_invoicedate1" style="width:75px;" hidden /> </td>
                            <td><textarea  class='uexp_submultivalid'  name ="BDLY_INPUT_tb_uexp_invoiceitem[]" id="BDLY_INPUT_tb_uexp_invoiceitem1"  hidden></textarea> </td>
                            <td><input  class=' uexp_submultivalid autosize autocomplete'  type="text" name ="BDLY_INPUT_tb_uexp_invoicefrom[]" id="BDLY_INPUT_tb_uexp_invoicefrom1" maxlength='200'  hidden/> </td>
                            <td><input  class="amtonlyfivedigit uexp_submultivalid BDLY_INPUT_class_numonly"  type="text" name ="BDLY_INPUT_tb_uexp_amount[]" id="BDLY_INPUT_tb_uexp_amount1" style="width:65px;" hidden /> </td>
                            <td><textarea row="2" name ="BDLY_INPUT_ta_uexpcomments[]" id="BDLY_INPUT_ta_uexpcomments1" class=" uexp_submultivalid" hidden ></textarea> </td><td>
                                <input type='button' value='+' class='uexp_addbttn' alt='Add Row' height='30' width='30' name ='BDLY_INPUT_uexpadd[]' id='BDLY_INPUT_uexp_add1'disabled > </td><td>
                                <input  type='button' value='-' class='uexp_deletebttn' alt='delete Row' height='30' width='30' name ='BDLY_INPUT_uexpdelete[]' id='BDLY_INPUT_uexp_del1' disabled ></td>
                            <td><input    type="text" name ="BDLY_INPUT_tb_uexp_hideradioid" id="BDLY_INPUT_tb_uexp_hideradioid1" style="width:75px;" hidden/> </td>
                        </tr>
                    </table>
                </div>
                <!--CREATING OF STARHUB ELEMENT-->
                <div class="table-responsive">
                    <table id="BDLY_INPUT_tble_starhub" cellpadding="10" cellspacing="2" style="width:1200px;" hidden>
                        <tr> <td><label id="BDLY_INPUT_lbl_star_unit" >UNIT</label><em>*</em> </td>
                            <td ><label  id="BDLY_INPUT_lbl_star_invoiceto" >INVOICE TO</label><em>*</em></td>
                            <td ><label id="BDLY_INPUT_lbl_star_accountno"  >ACCOUNT NO</label><em>*</em> </td>
                            <td > <label id="BDLY_INPUT_lbl_star_invoicedate" >INVOICE DATE</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_fromperiod" >FROM PERIOD</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_toperiod" >TO PERIOD</label><em>*</em></td>
                            <td ><label id="BDLY_INPUT_lbl_star_amount" >AMOUNT</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_comments" >COMMENTS</label> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_add" ></label> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_del" ></label> </td>
                        </tr>
                        <tr>
                            <td> <select  class="BDLY_INPUT_class_star_unit star_submultivalid "  name="BDLY_INPUT_lb_star_unit" id="BDLY_INPUT_lb_star_unit-1" hidden><option value="">SELECT</option></select> </td>
                            <td> <select  class="BDLY_INPUT_class_star_invoice star_submultivalid "  name="BDLY_INPUT_lb_star_invoiceto" id="BDLY_INPUT_lb_star_invoice-1" hidden><option value="">SELECT</option></select><input type="hidden" id="BDLY_INPUT_hidden_star_ecnid1" name="BDLY_INPUT_hidden_star_ecnid[]"> </td>
                            <td><input  class=' star_submultivalid rdonly'  type="text" name ="BDLY_INPUT_tb_star_accno" id="BDLY_INPUT_tb_star_accno1"  hidden readonly/> </td>
                            <td><input  class='starinvdatepickdate star_submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_star_invoicedate" id="BDLY_INPUT_db_star_invoicedate1" style="width:75px;" hidden /> </td>
                            <td><input  class='starfrmdatepickdate star_submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_star_fromperiod" id="BDLY_INPUT_db_star_fromperiod1" style="width:75px;" hidden/> </td>
                            <td><input  class='startodatepickdate star_submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_star_toperiod" id="BDLY_INPUT_db_star_toperiod1" style="width:75px;" hidden/> </td>
                            <td><input  class=" star_submultivalid includeminusfour BDLY_INPUT_class_numonly"  type="text" name ="BDLY_INPUT_tb_star_amount" id="BDLY_INPUT_tb_star_amount1" style="width:55px;" maxlength=4 hidden /> </td>
                            <td><textarea row="2" class=" star_submultivalid"  name ="BDLY_INPUT_ta_star_comments" id="BDLY_INPUT_ta_star_comments1" hidden ></textarea> </td><td>
                                <input type='button' value='+' class='star_addbttn' alt='Add Row' height='30' width='30' name ='BDLY_INPUT_add[]' id='BDLY_INPUT_star_add1'disabled > </td><td>
                                <input  type='button' value='-' class='star_deletebttn' alt='delete Row' height='30' width='30' name ='BDLY_INPUT_delete[]' id='BDLY_INPUT_star_del1' disabled ></td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-offset-1" id="BDLY_INPUT_tble_button">
                    <input class="btn" type="button"  id="BDLY_INPUT_btn_submitbutton" name="BDLY_INPUT_btn_submitbutton" value="SAVE" disabled  hidden/>&nbsp;&nbsp;<input class="btn" type="button"  id="BDLY_INPUT_btn_resetbutton" name="BDLY_INPUT_btn_resetbutton" value="RESET" hidden />
                </div>

                <div>
                    <input class="btn" type="button"  id="BDLY_INPUT_btn_multisubmitbutton" name="SAVE" value="SAVE" disabled hidden/>
                </div>
                <div><label class="errormsg" id="BDLY_INPUT_lbl_hourmsg" ></label></div>
                <div><label class="errormsg" id="BDLY_INPUT_lbl_minmsg" ></label></div>
                <div><label class="errormsg" id="BDLY_INPUT_lbl_checkcardno" ></label></div>

            <input type="hidden" id="BDLY_INPUT_hidden_edcpid" name="BDLY_INPUT_hidden_edcpid">
            <input type="hidden" id="BDLY_INPUT_hidden_customerid" name="BDLY_INPUT_hidden_customerid">
        </div>
        <!-- SEARCH UPDATE FORM-->
        <div id="updateform">
            <div id="BDLY_SRC_tble_maintable" hidden>
                <div class="form-group">
                    <label  id='BDLY_INPUT_srch_lbl_typeofexp' class="col-sm-2">TYPE OF EXPENSE<em>*</em></label>
                    <div class="col-sm-3"><select id="BDLY_SRC_lb_ExpenseList" name="BDLY_SRC_lb_ExpenseList" class="form-control" ></select></div>
                </div>
                <div class="form-group" id="BDLY_SRC_tr_serachopt" style="display: none;">
                    <label class="col-sm-2">SEARCH BY</label>
                    <div class="BDLY_SRC_input_val col-sm-3">
                        <select id="BDLY_SRC_lb_serachopt" name="BDLY_SRC_lb_serachopt" class="form-control"><option value="" >SELECT</option></select>
                    </div>
                </div>
                <div><label class="srctitle" colspan="2" id="BDLY_SRC_Optionhead"></label></div>
                <div id="BDLY_SRC_dynamicarea" >
                </div>
                <div class="col-lg-offset-2" id="BDLY_SRC_td_for_searchbutton">
                    <input type="button" name="BDLY_SRC_btn_search" id="BDLY_SRC_btn_search" class="btn" value="SEARCH" style="display:none" disabled />
                </div>
                <div><label id="BDLY_SRC_lbl_errmsg_exp" class="errormsg"></label></div>
            </div>
            <div id="BDLY_SRC_nodyndataerr" class="errormsg"></div>
            <div class="srctitle" id="BDLY_SRC_div_searchresult_head"></div>
            <input type="hidden" id="pdfheader" name="pdfheader"/>
            <input type="hidden" id="expensetypetext" name="expensetypetext"/>
            <div><input type="submit" id='BDLY_btn_pdf' class="btnpdf" value="PDF" hidden></div>
            <div id="BDLY_SRC_div_searchresult" class="table-responsive"></div>
            <input type="hidden" id="startdate" name="startdate"/>
            <input type="hidden" id="enddate" name="enddate"/>
        </div>

</div>
</form>
</div>
</body>
</html>