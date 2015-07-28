<!--*********************************BIZ EXPENSE DETAIL ENTRY SEARCH/UPDATE/DELETE********************************************//
//DONE BY:SASIKALA
//VER 0.03 -SD:05/06/2015 ED:05/06/2015 GETTING HEADER FILE FROM LIB
//VER 0.02 SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names
//VER 0.01-SD:22/05/2015 ED:29/05/2015,INITIAL VERSION
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
    .glyphicon-edit{
        color:green;
    }
</style>

<script>
    //CHECK PRELOADER STATUS N HIDE END
    /*-------------------------------------FUNCTION FOR CHANGE DATE FORMAT---------------------------*/
    function BDTL_FormTableDateFormat(BDTL_inputdate){
        var BDTL_string  = BDTL_inputdate.split("-");
        return BDTL_string[2]+'-'+ BDTL_string[1]+'-'+BDTL_string[0];
    }
    /*------------------------------------------FUNCTION FOR CHANGING DATE FORMAT----------------------------------------------------*/
    function DatePickerFormat(inputdate){
        var string  = inputdate.split("-");
        return string[2]+'-'+ string[1]+'-'+string[0];
    }
    $(document).ready(function(){
        $('.preloader').hide();
        var BDTL_flag_date=1;
        $('#spacewidth').height('0%');
        var BDTL_INPUT_errorarr=[];
        var BDTL_INPUT_expensearr=[];
        var BDTL_INPUT_invoicearr=[];
        var BDTL_INPUT_arr_aircon=[];
        var BDTL_glb_startdate='';
        var BDTL_INPUT_configmonth='';
        var BTDTL_SEARCH_obj='';
        var BTDTL_SEARCH_airconservicedby='';
        var BTDTL_SEARCH_digitalinvoiceto='';
        var BTDTL_SEARCH_elecinvoiceto='';
        var BTDTL_SEARCH_starhubinvoiceto='';
        var BTDTL_SEARCH_cable_sdate='';
        var BTDTL_SEARCH_cable_edate='';
        var BTDTL_SEARCH_internet_sdate='';
        var BTDTL_SEARCH_internet_edate='';
        var BTDTL_SEARCH_flag_autocom;
        var BTDTL_SEARCH_arr_invoicto=[];
        var BTDTL_SEARCH_options_invoiceto ='';
        var BTDTL_SEARCH_expensearr=[];
        var BTDTL_SEARCH_errorarr=[];
        var BTDTL_SEARCH_configmon_aircon=[];
        var BTDTL_SEARCH_starhubid=[];
        var BTDTL_SEARCH_airconserviceby=[];
        var BTDTL_SEARCH_aircontypes ='';
        var BTDTL_SEARCH_carparktypes ='';
        var BTDTL_SEARCH_digitaltypes ='';
        var BTDTL_SEARCH_electricitytypes ='';
        var BTDTL_SEARCH_starhubtypes ='';
        var BTDTL_SEARCH_aircontypes_flag ='';
        var BTDTL_SEARCH_carparktypes_flag ='';
        var BTDTL_SEARCH_digitaltypes_flag ='';
        var BTDTL_SEARCH_electricitytypes_flag ='';
        var BTDTL_SEARCH_starhubtypes_flag ='';
        var airconservicebyarray=[];
        var sdate='';
        var edate='';
        var controller_url="<?php echo base_url(); ?>" + '/index.php/EXPENSE/BIZEXPENSE/Ctrl_Biz_Expense_Detail_Entry_Search_Update_Delete/' ;
        $('#BDTL_btn_pdf').hide();
        //RADIO  BUTTON CLICK FUNCTION
        $('.BDE_rd_selectform').click(function(){
            $('#BTDTL_SEARCH_lb_searchoptions').html('');
            BTDTL_SEARCH_aircontypes='';
            BTDTL_SEARCH_carparktypes ='';
            BTDTL_SEARCH_digitaltypes ='';
            BTDTL_SEARCH_electricitytypes ='';
            BTDTL_SEARCH_starhubtypes ='';
            var bizdetailradiooption=$(this).val();
            if(bizdetailradiooption=='bizdetailentryform')
            {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDTL_INPUT_expense_err_invoice",
                    success: function(res) {
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        var result=JSON.parse(res);
                        BDTL_INPUT_resultset(result);

                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
                $('#divbizdetailentryform').show();
                $('#divbizdetailupdateform').hide();
                $('#BDTL_INPUT_lb_expense_type').prop('selectedIndex',0).focus();
                $('#BDTL_INPUT_div_aircon').hide();
                $('#BDTL_INPUT_div_carpark').hide();
                $('#BDTL_INPUT_div_digitalvoice').hide();
                $('#BDTL_INPUT_div_electricity').hide();
                $('#BDTL_INPUT_div_starhub').hide();
                $('#BDTL_INPUT_lbl_unitno_list').hide();
                $('#BDTL_INPUT_lb_unitno_list').hide();
                $('#BDTL_INPUT_tble_btn').hide();
                $('#BTDTL_SEARCH_lb_searchoptions').html('');
            }
            else if(bizdetailradiooption=='bizdetailsearchform')
            {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_expensetypes",
                    success: function(res) {
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        var result=JSON.parse(res);
                        BTDTL_SEARCH_success_expense(result);

                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
                $('#divbizdetailupdateform').show();
                $('#divbizdetailentryform').hide();
                $('#BTDTL_SEARCH_lbl_searchoptions').hide();
                $('#BTDTL_SEARCH_lb_searchoptions').html('').hide();
                $('#BTDTL_SEARCH_tble_searchby').html('');
                $('#BTDTL_SEARCH_div_msg').text('');
                $('#BTDTL_SEARCH_div_flex_searchbtn').hide();
                $('#BTDTL_SEARCH_lb_expense_type').prop('selectedIndex',0)

            }
        });
        /*----------------------------------------------SUCCESS FUNCTION FOR EXPENSE TYPES,INVOICE & ERROR MSG--------------------------------------------------------*/
        function BDTL_INPUT_resultset(BDTL_INPUT_result){
            BDTL_INPUT_errorarr=BDTL_INPUT_result.BDTL_INPUT_error;
            BDTL_INPUT_expensearr=BDTL_INPUT_result.BDTL_INPUT_expense;
            BDTL_INPUT_invoicearr=BDTL_INPUT_result.BDTL_INPUT_invoice;
            var BDTL_INPUT_flag_unit=BDTL_INPUT_result.BDTL_INPUT_obj_unitflag;
            BDTL_INPUT_arr_aircon=BDTL_INPUT_result.BDTL_INPUT_obj_aircon;
            BDTL_INPUT_configmonth=BDTL_INPUT_result.BDTL_INPUT_obj_configmonth;
            if(BDTL_INPUT_flag_unit==false){
                $('#BDTL_INPUT_form_biz_detail').replaceWith('<p><label class="errormsg"> '+BDTL_INPUT_errorarr[5].EMC_DATA+'</label></p>')
            }
            else{
                var BDTL_INPUT_invoice_options ='<option>SELECT</option>';
                for (var i = 0; i < BDTL_INPUT_invoicearr.length; i++) {
                    BDTL_INPUT_invoice_options += '<option value="' + BDTL_INPUT_invoicearr[i].BDTL_INPUT_expensetypes_id + '">' + BDTL_INPUT_invoicearr[i].BDTL_INPUT_expensetypes_data+ '</option>';
                }
                $('#BDTL_INPUT_lb_digital_invoiceto').html(BDTL_INPUT_invoice_options);
                $('#BDTL_INPUT_lb_bizdetail_electricity_invoiceto').html(BDTL_INPUT_invoice_options);
                $('#BDTL_INPUT_lb_starhub_invoiceto').html(BDTL_INPUT_invoice_options);
                var BDTL_INPUT_expense_options ='<option>SELECT</option>';
                for (var i = 0; i < BDTL_INPUT_expensearr.length; i++) {
                    BDTL_INPUT_expense_options += '<option value="' + BDTL_INPUT_expensearr[i].BDTL_INPUT_expensetypes_id + '">' + BDTL_INPUT_expensearr[i].BDTL_INPUT_expensetypes_data + '</option>';
                }
                $('#BDTL_INPUT_lb_expense_type').html(BDTL_INPUT_expense_options).show();
                $('#BDTL_INPUT_lb_expense_type').focus();
                $('#BDTL_INPUT_lbl_expensetype').show();
                $('#BDTL_INPUT_form_biz_detail').show();
                $("#BDTL_INPUT_tb_exp_digivoiceno").prop("title",BDTL_INPUT_errorarr[1].EMC_DATA)
            }
            $('.preloader').hide();
        }
        var BDTL_INPUT_flag_newaircon='';
        /*-----------------------------------------VALIDATION FOR CHARACTER,NUMBERS AND ALPHA NUMERIC--------------------------------------------------------*/
        $('textarea').autogrow({onInitialize: true});
        $(".charonly").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
        $(".alphanumeric").doValidation({rule:'alphanumeric'});
        $(".alphanumericdot").doValidation({rule:'alphanumeric',prop:{allowdot:true}});
        $(".numbersonly").doValidation({rule:'numbersonly',prop:{realpart:8},leadzero:true});
        $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
        $("input.autosize").autoGrowInput();
        $(".general").doValidation({rule:'general',prop:{uppercase:false,autosize:true}});
        $("#BDTL_INPUT_db_appl_date").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
        $(".BDTL_INPUT_comments").doValidation({rule:'general',prop:{uppercase:false}});
        /*--------------------------------------DATE VALIDATION FOR CABLE,INTERNET START DATE & END DATE------------------------*/
        $("#BDTL_INPUT_db_cable_enddate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
        $("#BDTL_INPUT_db_internet_enddate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
        $("#BDTL_INPUT_db_cable_startdate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,
            onSelect: function(date){
                if((parseInt($('#BDTL_INPUT_tb_starhub_account_no').val())==0)||($('#BDTL_INPUT_tb_starhub_account_no').val()=='')||(($('#BDTL_INPUT_db_cable_startdate').val()=='')&&($('#BDTL_INPUT_db_cable_enddate').val()!=''))||(($('#BDTL_INPUT_db_cable_startdate').val()!='')&&($('#BDTL_INPUT_db_cable_enddate').val()==''))||(($('#BDTL_INPUT_db_internet_startdate').val()=='')&&($('#BDTL_INPUT_db_internet_enddate').val()!=''))||(($('#BDTL_INPUT_db_internet_startdate').val()!='')&&($('#BDTL_INPUT_db_internet_enddate').val()=='')))
                    $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
                else
                    $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                var BDTL_startdate = new Date( Date.parse( BDTL_FormTableDateFormat( $('#BDTL_INPUT_db_cable_startdate').val())) );
                BDTL_startdate.setDate( BDTL_startdate.getDate());
                var BDTL_newsDate = BDTL_startdate.toDateString();
                BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
                $('#BDTL_INPUT_db_cable_enddate').datepicker("option","minDate",BDTL_newsDate);
            }});
        $("#BDTL_INPUT_db_internet_startdate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,
            onSelect: function(date){
                if((parseInt($('#BDTL_INPUT_tb_starhub_account_no').val())==0)||($('#BDTL_INPUT_tb_starhub_account_no').val()=='')||(($('#BDTL_INPUT_db_cable_startdate').val()=='')&&($('#BDTL_INPUT_db_cable_enddate').val()!=''))||(($('#BDTL_INPUT_db_cable_startdate').val()!='')&&($('#BDTL_INPUT_db_cable_enddate').val()==''))||(($('#BDTL_INPUT_db_internet_startdate').val()=='')&&($('#BDTL_INPUT_db_internet_enddate').val()!=''))||(($('#BDTL_INPUT_db_internet_startdate').val()!='')&&($('#BDTL_INPUT_db_internet_enddate').val()=='')))
                    $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
                else
                    $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                var BDTL_startdate = new Date( Date.parse( BDTL_FormTableDateFormat( $('#BDTL_INPUT_db_internet_startdate').val())) );
                BDTL_startdate.setDate( BDTL_startdate.getDate());
                var BDTL_newsDate = BDTL_startdate.toDateString();
                BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
                $('#BDTL_INPUT_db_internet_enddate').datepicker("option","minDate",BDTL_newsDate);
            }});
        /*----------------------------------------------------CHANGE FUNCTION FOR EXPENSE TYPE-----------------------------------------------------*/
        $('#BDTL_INPUT_lb_expense_type').change(function(){
            $("textarea").height(116);
            $('#BDTL_INPUT_form_biz_detail').find('input:text').val('');
            $('textarea').val('');
            $('#BDTL_INPUT_div_errmsg_aircon,#BDTL_INPUT_div_exp_detail_err').text('');
            $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            var BDTL_INPUT_all_expense_types = $(this).val();
            $('#BDTL_INPUT_lb_unitno_list').hide();
            $('#BDTL_INPUT_lbl_unitno_list').hide();
            $('#BDTL_INPUT_div_aircon').hide();
            $('#BDTL_INPUT_div_carpark').hide();
            $('#BDTL_INPUT_div_digitalvoice').hide();
            $('#BDTL_INPUT_div_electricity').hide();
            $('#BDTL_INPUT_div_starhub').hide();
            $('#BDTL_INPUT_lb_digital_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_starhub_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_bizdetail_electricity_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_airconservicedby').val('SELECT');
            $('#BDTL_INPUT_tble_btn').hide();
            if(BDTL_INPUT_all_expense_types!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDTL_INPUT_all_exp_types_unitno",
                    data:{'BDTL_INPUT_all_expense_types':BDTL_INPUT_all_expense_types},
                    success: function(res) {
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        var result=JSON.parse(res);
                        BDTL_INPUT_loadunitno(result);

                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else
            {
                $('#BDTL_INPUT_lb_unitno_list').hide();
                $('#BDTL_INPUT_lbl_unitno_list').hide();
            }
        });
        /*-----------------------------------------SUCCESS FUNCTION FOR CODING TO LOAD UNIT NO IN UNIT NO LISTBOX-----------------------------------------*/
        function BDTL_INPUT_loadunitno(BDTL_INPUT_response){
            $(".preloader").hide();
            var BDTL_INPUT_unitnosArray = [];
            BDTL_INPUT_unitnosArray = BDTL_INPUT_response;
            var options ='<option>SELECT</option>'
            if(BDTL_INPUT_unitnosArray.length==0){
                var BDTL_INPUT_oldvalue = BDTL_INPUT_errorarr[4].EMC_DATA;
                var BDTL_INPUT_newvalue = BDTL_INPUT_oldvalue.replace("[TYPE]",$('#BDTL_INPUT_lb_expense_type').find('option:selected').text());
                $('#BDTL_INPUT_div_exp_detail_err').text(BDTL_INPUT_newvalue)
            }
            else
            {
                for (var i = 0; i < BDTL_INPUT_unitnosArray.length; i++)
                {
                    options += '<option value="' + BDTL_INPUT_unitnosArray[i].BDTL_INPUT_obj_unitid + '">' + BDTL_INPUT_unitnosArray[i].BDTL_INPUT_obj_unitno + '</option>';
                }
                $('#BDTL_INPUT_lb_unitno_list').html(options);
                $('#BDTL_INPUT_lb_unitno_list').show();
                $('#BDTL_INPUT_lb_unitno_list').focus();
                $('#BDTL_INPUT_lbl_unitno_list').show();
            }
        }
        /*--------------------------------------------------CHANGE EVENT FUNCTION FOR UNIT NUMBER------------------------------------------------------------------*/
        $('#BDTL_INPUT_lb_unitno_list').change(function(){
            $('#BDTL_INPUT_div_aircon').hide();
            $('#BDTL_INPUT_div_carpark').hide();
            $('#BDTL_INPUT_div_digitalvoice').hide();
            $('#BDTL_INPUT_div_electricity').hide();
            $('#BDTL_INPUT_div_starhub').hide();
            $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            $('#BDTL_INPUT_form_biz_detail').find('input:text').val('');
            $('textarea').val('');
            $("textarea").height(116);
            $('#BDTL_INPUT_div_errmsg_aircon').text('');
            $('#BDTL_INPUT_lb_digital_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_starhub_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_bizdetail_electricity_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_airconservicedby').val('SELECT');
            $('#BDTL_INPUT_tble_btn').hide();
            var BDTL_INPUT_unit_num = $(this).val();
            if(BDTL_INPUT_unit_num!='SELECT'){
                var BDTL_INPUT_types_of_expense = $('#BDTL_INPUT_lb_expense_type').val();
                if(BDTL_INPUT_types_of_expense==16)
                {

                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    if($('#BDTL_INPUT_lb_airconservicedby').val()==undefined)
                    {
                        $('#BDTL_INPUT_tb_newaircon').replaceWith('<select id="BDTL_INPUT_lb_airconservicedby" name="BDTL_INPUT_lb_airconservicedby" class="BDTL_INPUT_class_save_valid form-control"><option>SELECT</option></select>');
                        $('#BDTL_INPUT_btn_remove_aircon').replaceWith('<input type="button" name="BDTL_INPUT_btn_add_aircon" value="ADD" id="BDTL_INPUT_btn_add_aircon" class="btn"/>');
                    }
                    if(BDTL_INPUT_arr_aircon.length==0){
                        $('#BDTL_INPUT_lb_airconservicedby').replaceWith('<input type="text" name="BDTL_INPUT_tb_newaircon" id="BDTL_INPUT_tb_newaircon" maxlength="50" class="autosize BDTL_INPUT_class_save_valid charonly form-control" placeholder="Aircon Service By"/>');
                        $('#BDTL_INPUT_btn_add_aircon').hide();
                        $(".charonly").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
                        $('#BDTL_INPUT_div_errmsg_aircon').text('')
                    }
                    else{
                        var BDTL_INPUT_aircon ='<option>SELECT</option>';
                        for (var i = 0; i < BDTL_INPUT_arr_aircon.length; i++)
                        {
                            BDTL_INPUT_aircon += '<option value="' + BDTL_INPUT_arr_aircon[i] + '">' + BDTL_INPUT_arr_aircon[i] + '</option>';
                        }
                        $('#BDTL_INPUT_lb_airconservicedby').show();
                        $('#BDTL_INPUT_lb_airconservicedby').html(BDTL_INPUT_aircon);
                        $('#BDTL_INPUT_btn_add_aircon').show();
                    }
                    $('#BDTL_INPUT_div_aircon').show();
                    $('#BDTL_INPUT_div_carpark').hide();
                    $('#BDTL_INPUT_div_digitalvoice').hide();
                    $('#BDTL_INPUT_div_electricity').hide();
                    $('#BDTL_INPUT_div_starhub').hide();
                }
                else if(BDTL_INPUT_types_of_expense==17)
                {
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    $('#BDTL_INPUT_div_aircon').hide();
                    $('#BDTL_INPUT_div_carpark').show();
                    $('#BDTL_INPUT_div_digitalvoice').hide();
                    $('#BDTL_INPUT_div_electricity').hide();
                    $('#BDTL_INPUT_div_starhub').hide();
                }
                else if(BDTL_INPUT_types_of_expense==15)
                {
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    $('#BDTL_INPUT_div_aircon').hide();
                    $('#BDTL_INPUT_div_carpark').hide();
                    $('#BDTL_INPUT_div_digitalvoice').show();
                    $('#BDTL_INPUT_div_electricity').hide();
                    $('#BDTL_INPUT_div_starhub').hide();
                }
                else if(BDTL_INPUT_types_of_expense==13)
                {
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    $('#BDTL_INPUT_div_aircon').hide();
                    $('#BDTL_INPUT_div_carpark').hide();
                    $('#BDTL_INPUT_div_digitalvoice').hide();
                    $('#BDTL_INPUT_div_electricity').show();
                    $('#BDTL_INPUT_div_starhub').hide();
                }
                else if(BDTL_INPUT_types_of_expense==14)
                {
                    $('#BDTL_INPUT_div_aircon').hide();
                    $('#BDTL_INPUT_div_carpark').hide();
                    $('#BDTL_INPUT_div_digitalvoice').hide();
                    $('#BDTL_INPUT_div_electricity').hide();
                    $('#BDTL_INPUT_div_starhub').show();
                    $('.preloader').show();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BDTL_INPUT_get_SDate_EDate",
                        data:{'unitselectedlist':$('#BDTL_INPUT_lb_unitno_list').find('option:selected').text()},
                        success: function(res) {
                            $('.preloader').hide();
                            $("html, body").animate({ scrollTop: 1000 }, "slow");
                            var result=JSON.parse(res);
                            BDTL_INPUT_success_unitdate(result);

                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
                $('#BDTL_INPUT_tble_btn').show();
            }});
        /*--------------------------------------SETTING MIN DATE AND MAX DATE FOR APPL DATE,CABLE SDATE EDATE AND INTERNET SDATE EDATE-----------------------*/
        function BDTL_INPUT_success_unitdate(BDTL_INPUT_response_unitdate){
            $('.preloader').hide();
            BDTL_glb_startdate=BDTL_INPUT_response_unitdate.unitsdate
            var BDTL_startdate = new Date( Date.parse( BDTL_INPUT_response_unitdate.unitsdate) );
            BDTL_startdate.setDate( BDTL_startdate.getDate());
            var BDTL_newsDate = BDTL_startdate.toDateString();
            BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
            $('#BDTL_INPUT_db_appl_date,#BDTL_INPUT_db_cable_startdate,#BDTL_INPUT_db_internet_startdate,#BDTL_INPUT_db_cable_enddate,#BDTL_INPUT_db_internet_enddate').datepicker("option","minDate",BDTL_newsDate);
            var BDLY_INPUT_enddate=new Date(Date.parse( BDTL_INPUT_response_unitdate.unitedate));
            var BIZDLY_SRC_chkoutdate=BDLY_INPUT_enddate.getDate();
            var BIZDLY_SRC_chkoutmonth=BDLY_INPUT_enddate.getMonth()+parseInt(BDTL_INPUT_configmonth);
            var BIZDLY_SRC_chkoutyear=BDLY_INPUT_enddate.getFullYear();
            var BDLY_INPUT_enddate_unit = new Date(BIZDLY_SRC_chkoutyear,BIZDLY_SRC_chkoutmonth,BIZDLY_SRC_chkoutdate);
            if(BDLY_INPUT_enddate_unit.setHours(0,0,0,0)<=new Date().setHours(0,0,0,0))
            {
                var BDLY_INPUT_unit_end_date=BDLY_INPUT_enddate_unit;
            }
            else{
                var BDLY_INPUT_unit_end_date=new Date();
            }
            $('#BDTL_INPUT_db_appl_date,#BDTL_INPUT_db_cable_startdate,#BDTL_INPUT_db_internet_startdate').datepicker("option","maxDate",BDLY_INPUT_unit_end_date);
            $('#BDTL_INPUT_db_cable_enddate,#BDTL_INPUT_db_internet_enddate').datepicker("option","maxDate",BDLY_INPUT_enddate_unit);
        }
        /*-------------------------------------------------------REPLACE NEW AIRCON SERVICES--------------------------------------------------------------*/
        $(document).on('click','#BDTL_INPUT_btn_add_aircon,#BDTL_INPUT_btn_remove_aircon',function(){
            BDTL_INPUT_flag_newaircon='';
            $('#BDTL_INPUT_div_errmsg_aircon').text('');
            $('#BDTL_INPUT_tb_newaircon').text('');
            $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            if($(this).attr('id')=="BDTL_INPUT_btn_add_aircon"){
                $('#BDTL_INPUT_lb_airconservicedby').replaceWith('<input type="text" name="BDTL_INPUT_tb_newaircon" id="BDTL_INPUT_tb_newaircon" maxlength="50" class="autosize BDTL_INPUT_class_save_valid charonly form-control" placeholder="Aircon Service By"/>');
                $(this).replaceWith('<input type="button" name="BDTL_INPUT_btn_remove_aircon"  value="CLEAR" id="BDTL_INPUT_btn_remove_aircon" class="btn" />');
                $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                $("input.autosize").autoGrowInput();
                $(".charonly").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
            }
            if($(this).attr('id')=='BDTL_INPUT_btn_remove_aircon'){
                var BDTL_INPUT_aircon='<option>SELECT</option>'
                for (var i = 0; i < BDTL_INPUT_arr_aircon.length; i++)
                {
                    BDTL_INPUT_aircon += '<option value="' + BDTL_INPUT_arr_aircon[i] + '">' + BDTL_INPUT_arr_aircon[i] + '</option>';
                }
                $('#BDTL_INPUT_tb_newaircon').replaceWith('<select id="BDTL_INPUT_lb_airconservicedby" name="BDTL_INPUT_lb_airconservicedby" class="BDTL_INPUT_class_save_valid form-control">'+BDTL_INPUT_aircon+'</select>');
                $(this).replaceWith('<input type="button" name="BDTL_INPUT_btn_add_aircon" value="ADD" id="BDTL_INPUT_btn_add_aircon" class="btn"/>');
            }});
        /*------------------------------------------------CHANGE EVENT FUNCTION FOR NEW AIRCON SERVICED BY-------------------------------------------*/
        $(document).on('blur','#BDTL_INPUT_tb_newaircon',function(){
            var BDTL_INPUT_newaircon=$(this).val();
            if(BDTL_INPUT_newaircon.length==0)
            {
                BDTL_INPUT_flag_newaircon='';
                $('#BDTL_INPUT_div_errmsg_aircon').text('');
                $("#BDTL_INPUT_tb_newaircon").removeClass('invalid');
                $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            }else if(BDTL_INPUT_newaircon.length>0)
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDTL_INPUT_airconservicedby_check",
                    data:{'BDTL_INPUT_newaircon':BDTL_INPUT_newaircon},
                    success: function(res) {
                        $('.preloader').hide();
                        BDTL_INPUT_airconresult(res);

                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }});
        /*------------------------------------------SUCCESS FUNCTION FOR NEW AIRCON SERVICED BY---------------------------------------------------*/
        function BDTL_INPUT_airconresult(BDTL_INPUT_response){
            $(".preloader").hide();
            if(BDTL_INPUT_response=='true'){
                BDTL_INPUT_flag_newaircon='false';
                $('#BDTL_INPUT_div_errmsg_aircon').text(BDTL_INPUT_errorarr[2].EMC_DATA);
                $("#BDTL_INPUT_tb_newaircon").addClass('invalid');
                $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            }
            else if((BDTL_INPUT_response=='false')&&($('#BDTL_INPUT_lb_airconservicedby').val()==undefined))
            {
                BDTL_INPUT_flag_newaircon='true';
                $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                $('#BDTL_INPUT_div_errmsg_aircon').text('');
                $("#BDTL_INPUT_tb_newaircon").removeClass('invalid');
            }
        }
        /*-------------------------------------- CHANGE EVENT FOR ACCOUNT NO VALIDATION----------------------*/
        $(document).on("change blur",'#BDTL_INPUT_tb_exp_digiaccno,#BDTL_INPUT_tb_starhub_account_no,#BDTL_INPUT_tb_exp_carno',function(){
            if(parseInt($('#BDTL_INPUT_tb_exp_digiaccno').val())==0)
                $('#BDTL_INPUT_tb_exp_digiaccno').val('')
            if(parseInt($('#BDTL_INPUT_tb_starhub_account_no').val())==0)
                $('#BDTL_INPUT_tb_starhub_account_no').val('')
            if(parseInt($('#BDTL_INPUT_tb_exp_carno').val())==0)
                $('#BDTL_INPUT_tb_exp_carno').val('')
        });
        /*-------------------------------------- CHANGE EVENT FOR ENABLING SUBMIT BUTTON UNTIL MANDATORY VALUES ARE GIVEN----------------------*/
        $(document).on("blur change",'.BDTL_INPUT_class_save_valid',function(){
            var BDTL_INPUT_types_of_expense = $('#BDTL_INPUT_lb_expense_type').val()
            if(BDTL_INPUT_types_of_expense!='SELECT')
            {
                if(BDTL_INPUT_types_of_expense==16)
                {
                    if((($('#BDTL_INPUT_lb_airconservicedby').val()=='SELECT')&&($('#BDTL_INPUT_tb_newaircon').val()==undefined))||(($('#BDTL_INPUT_lb_airconservicedby').val()==undefined)&&($('#BDTL_INPUT_tb_newaircon').val()==''))||(BDTL_INPUT_flag_newaircon=='false')||($('#BDTL_INPUT_tb_newaircon').val()=='')||(($('#BDTL_INPUT_lb_airconservicedby').val()==undefined)&&(BDTL_INPUT_flag_newaircon=='')))
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled")
                    else
                    {
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                    }
                }
                else if(BDTL_INPUT_types_of_expense==17)
                {
                    if(($('#BDTL_INPUT_tb_exp_carno').val()!='')&&(parseInt($('#BDTL_INPUT_tb_exp_carno').val())!=0))
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                    else
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled")
                }
                else if(BDTL_INPUT_types_of_expense==15)
                {
                    if(($('#BDTL_INPUT_tb_exp_digivoiceno').val()!='')&&(parseInt($('#BDTL_INPUT_tb_exp_digivoiceno').val())!=0)&&(parseInt($('#BDTL_INPUT_tb_exp_digiaccno').val())!=0)&&($('#BDTL_INPUT_tb_exp_digiaccno').val()!=''))
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                    else
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
                }
                else if(BDTL_INPUT_types_of_expense==13)
                {
                    if($('#BDTL_INPUT_lb_bizdetail_electricity_invoiceto').val()!='SELECT')
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                    else
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled")
                }
                else if(BDTL_INPUT_types_of_expense==14)
                {
                    if((parseInt($('#BDTL_INPUT_tb_starhub_account_no').val())==0)||($('#BDTL_INPUT_tb_starhub_account_no').val()=='')||(($('#BDTL_INPUT_db_cable_startdate').val()=='')&&($('#BDTL_INPUT_db_cable_enddate').val()!=''))||(($('#BDTL_INPUT_db_cable_startdate').val()!='')&&($('#BDTL_INPUT_db_cable_enddate').val()==''))||(($('#BDTL_INPUT_db_internet_startdate').val()=='')&&($('#BDTL_INPUT_db_internet_enddate').val()!=''))||(($('#BDTL_INPUT_db_internet_startdate').val()!='')&&($('#BDTL_INPUT_db_internet_enddate').val()=='')))
                        BDTL_flag_date=0;
                    else
                        BDTL_flag_date=1;
                    if(BDTL_flag_date==0){
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled")}
                    else {
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");}
                }}});
        /*------------------------------------------------CLICK FUNCTION FOR SAVE BIZ DETAILS-------------------------------------------------------*/
        $(document).on("click",'#BDTL_INPUT_btn_save',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            var BDTL_INPUT_types_of_expense = $('#BDTL_INPUT_lb_expense_type').val();
            var BDTL_INPUT_unit_num = $('#BDTL_INPUT_lb_unitno_list').val();
            if(BDTL_INPUT_types_of_expense!='SELECT'){
                $('#BDTL_INPUT_hidden_unitno').val($('#BDTL_INPUT_lb_unitno_list').find('option:selected').text())
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BDTL_INPUT_save",
                    data:$('#BDTL_INPUT_form_biz_detail').serialize(),
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BDTL_INPUT_bizSuccess(result);

                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }});
        /*------------------------------------------SUCCESS FUNCTION FOR INSERTING ------------------------------------------*/
        function BDTL_INPUT_bizSuccess(BDTL_INPUT_response){
            if(BDTL_INPUT_response[1]==1){
                var BDTL_INPUT_expensetypes='';
                if($('#BDTL_INPUT_lb_expense_type').val()==16){
                    BDTL_INPUT_arr_aircon=BDTL_INPUT_response[0];
                }
                var BDTL_INPUT_errormsg_replace = BDTL_INPUT_errorarr[3].EMC_DATA.replace("[TYPE]",$('#BDTL_INPUT_lb_expense_type').find('option:selected').text());
                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BDTL_INPUT_errormsg_replace,"success",false);
                $('#BDTL_INPUT_lb_unitno_list').hide();
                $('#BDTL_INPUT_lbl_unitno_list').hide();
                $('#BDTL_INPUT_div_aircon').hide();
                $('#BDTL_INPUT_div_carpark').hide();
                $('#BDTL_INPUT_div_digitalvoice').hide();
                $('#BDTL_INPUT_div_electricity').hide();
                $('#BDTL_INPUT_div_starhub').hide();
                $('#BDTL_INPUT_tble_btn').hide();
                $('#BDTL_INPUT_lb_expense_type').prop('selectedIndex',0);
                BDTL_INPUT_reset();
            }
            else
                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BDTL_INPUT_errorarr[6].EMC_DATA,"success",false);
        }
        /*----------------------------------------------------COMMON FUNCTION FOR CLEARING ALL VALUES------------------------------------*/
        function BDTL_INPUT_reset(){
            var BDTL_startdate = new Date( Date.parse( BDTL_glb_startdate) );
            BDTL_startdate.setDate( BDTL_startdate.getDate());
            var BDTL_newsDate = BDTL_startdate.toDateString();
            BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
            $('#BDTL_INPUT_db_cable_enddate,#BDTL_INPUT_db_internet_enddate').datepicker('option', {minDate: BDTL_newsDate});
            $("#BDTL_INPUT_div_errmsg_aircon").text('');
            $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            $('#BDTL_INPUT_ta_starhub_comments').prop("rows",2).prop("cols",20);
            $('#BDTL_INPUT_form_biz_detail').find('input:text').prop("size","20");
        }
        /*------------------------------------------------FUNCTION FOR RESET---------------------------------------------------*/
        $(document).on("click",'#BDTL_INPUT_btn_reset',function(){
            $("#BDTL_INPUT_lb_starhub_invoiceto").val('SELECT');
            $("#BDTL_INPUT_lb_bizdetail_electricity_invoiceto").val('SELECT');
            $("#BDTL_INPUT_lb_digital_invoiceto").val('SELECT');
            $("#BDTL_INPUT_lb_airconservicedby").val('SELECT');
            $(':input[type=text]','#BDTL_INPUT_form_biz_detail').val('').not(':button');
            $("textarea").val('');
            $("textarea").height(116);
            BDTL_INPUT_reset();
            if($('#BDTL_INPUT_lb_airconservicedby').val()==undefined)
            {
                var BDTL_INPUT_aircon='<option>SELECT</option>'
                for (var i = 0; i < BDTL_INPUT_arr_aircon.length; i++)
                {
                    BDTL_INPUT_aircon += '<option value="' + BDTL_INPUT_arr_aircon[i] + '">' + BDTL_INPUT_arr_aircon[i] + '</option>';
                }
                $('#BDTL_INPUT_tb_newaircon').replaceWith('<select id="BDTL_INPUT_lb_airconservicedby" name="BDTL_INPUT_lb_airconservicedby" class="BDTL_INPUT_class_save_valid form-control">'+BDTL_INPUT_aircon+'</select>');
                $('#BDTL_INPUT_btn_remove_aircon').replaceWith('<input type="button" name="BDTL_INPUT_btn_add_aircon" value="ADD" id="BDTL_INPUT_btn_add_aircon" class="btn"/>');
            }
        });

        //SEARCH AND UPDATE FORM STARTS
        /*-----------------------------------------SUCCESS FUNCTION FOR EXPENSE TYPES-----------------------------------------------------*/
        function BTDTL_SEARCH_success_expense(BTDTL_SEARCH_response){
            BTDTL_SEARCH_errorarr=BTDTL_SEARCH_response.BTDTL_SEARCH_errormsg;
            BTDTL_SEARCH_configmon_aircon=BTDTL_SEARCH_response.BTDTL_SEARCH_aircon_errmsg;
            BTDTL_SEARCH_expensearr=BTDTL_SEARCH_response.BTDTL_SEARCH_expense;
            BTDTL_SEARCH_starhubid=BTDTL_SEARCH_response.BTDTL_SEARCH_obj_starhubid;
            BTDTL_SEARCH_arr_invoicto=BTDTL_SEARCH_response.BTDTL_SEARCH_obj_invoiceto;
            BTDTL_SEARCH_aircontypes_flag=BTDTL_SEARCH_response.BTDTL_SEARCH_aircondetail_obj;
            BTDTL_SEARCH_carparktypes_flag=BTDTL_SEARCH_response.BTDTL_SEARCH_cardetail_obj;
            BTDTL_SEARCH_digitaltypes_flag=BTDTL_SEARCH_response.BTDTL_SEARCH_digitaldetail_obj;
            BTDTL_SEARCH_electricitytypes_flag=BTDTL_SEARCH_response.BTDTL_SEARCH_elecdetail_obj;
            BTDTL_SEARCH_starhubtypes_flag=BTDTL_SEARCH_response.BTDTL_SEARCH_stardetail_obj;
            var BTDTL_SEARCH_flag_notable=BTDTL_SEARCH_response.BTDTL_SEARCH_notable_obj;
            BTDTL_SEARCH_options_invoiceto='<option>SELECT</option>';
            if(BTDTL_SEARCH_flag_notable==false){
                $('#BDTL_INPUT_form_biz_detail').replaceWith('<p><label class="errormsg"> '+BTDTL_SEARCH_errorarr[41].EMC_DATA+'<br>'+BTDTL_SEARCH_errorarr[39].EMC_DATA+'<br>'+BTDTL_SEARCH_errorarr[38].EMC_DATA+'<br>'+BTDTL_SEARCH_errorarr[40].EMC_DATA+'<br>'+BTDTL_SEARCH_errorarr[37].EMC_DATA+'</label></p>')
            }else{
                var BTDTL_SEARCH_options ='<option>SELECT</option>';
                for (var i = 0; i < BTDTL_SEARCH_expensearr.length; i++)
                {
                    if((BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==16)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==17)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==15)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==13)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==14))
                        BTDTL_SEARCH_options += '<option value="' + BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id + '">'+ BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_data+' </option>';
                }
                for (var i = 0; i < BTDTL_SEARCH_arr_invoicto.length; i++)
                {
                    BTDTL_SEARCH_options_invoiceto += '<option value="' + BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_id + '">'+ BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data+' </option>';
                }
                $('#BDTL_INPUT_form_biz_detail').show();
                $('#BTDTL_SEARCH_lb_expense_type').html(BTDTL_SEARCH_options).show();
                $('#BTDTL_SEARCH_lb_expense_type').focus();
                $('#srchexpensetype').show();
                BTDTL_SEARCH_aircontypes ='<option>SELECT</option>';
                BTDTL_SEARCH_carparktypes ='<option>SELECT</option>';
                BTDTL_SEARCH_digitaltypes ='<option>SELECT</option>';
                BTDTL_SEARCH_electricitytypes ='<option>SELECT</option>';
                BTDTL_SEARCH_starhubtypes ='<option>SELECT</option>';
                for (var i = 0; i < BTDTL_SEARCH_expensearr.length; i++)
                {
                    if((BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==100)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==101)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==191)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==195))
                        BTDTL_SEARCH_aircontypes += '<option value="' + BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id + '">'+ BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_data+' </option>';
                    if((BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==102)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==103)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==191))
                        BTDTL_SEARCH_carparktypes += '<option value="' + BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id + '">'+ BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_data+' </option>';
                    if((BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==106)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==107)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==191)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==108)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==109))
                        BTDTL_SEARCH_digitaltypes += '<option value="' + BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id + '">'+ BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_data+' </option>';
                    if((BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==104)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==105)||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==191))
                        BTDTL_SEARCH_electricitytypes += '<option value="' + BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id + '">'+ BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_data+' </option>';
                    if(((BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id >=110)&&(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id <=123))||(BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id ==191))
                        BTDTL_SEARCH_starhubtypes += '<option value="' + BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_id + '">'+ BTDTL_SEARCH_expensearr[i].BTDTL_SEARCH_expensetypes_data+' </option>';
                }
            }
            $('.preloader').hide();
        }
        /*------------------------------------------FUNCTION TO AUTOCOMPLETE SEARCH TEXT--------------------------------------------------------*/
        var BTDTL_SEARCH_comments = [];
        var BTDTL_SEARCH_comment_flag='';
        function BTDTL_SEARCH_success_comments(BTDTL_SEARCH_response){
            BTDTL_SEARCH_comments=BTDTL_SEARCH_response.BTDTL_SEARCH_searchvalue_comments;
            BTDTL_SEARCH_comment_flag=BTDTL_SEARCH_response.BTDTL_SEARCH_flag_comments;
        }
        $(document).on('keypress','#BTDTL_SEARCH_ta_airconcomments',function(){
            BTDTL_SEARCH_flag_autocom=0;
            highlightSearchText();
            $("#BTDTL_SEARCH_ta_airconcomments").autocomplete({
                source: BTDTL_SEARCH_comments,
                select: AutoCompleteSelectHandler
            });});
        $(document).on('keypress','#BTDTL_SEARCH_ta_carparkcomments',function(){
            BTDTL_SEARCH_flag_autocom=0;
            highlightSearchText();
            $("#BTDTL_SEARCH_ta_carparkcomments").autocomplete({
                source: BTDTL_SEARCH_comments,
                select: AutoCompleteSelectHandler
            });});
        $(document).on('keypress','#BTDTL_SEARCH_ta_digitalcomments',function(){
            BTDTL_SEARCH_flag_autocom=0;
            highlightSearchText();
            $("#BTDTL_SEARCH_ta_digitalcomments").autocomplete({
                source: BTDTL_SEARCH_comments,
                select: AutoCompleteSelectHandler
            });});
        $(document).on('keypress','#BTDTL_SEARCH_ta_electricitycomments',function(){
            BTDTL_SEARCH_flag_autocom=0;
            highlightSearchText();
            $("#BTDTL_SEARCH_ta_electricitycomments").autocomplete({
                source: BTDTL_SEARCH_comments,
                select: AutoCompleteSelectHandler
            });});
        $(document).on('keypress','#BTDTL_SEARCH_ta_starhubcomments',function(){
            BTDTL_SEARCH_flag_autocom=0;
            highlightSearchText();
            $("#BTDTL_SEARCH_ta_starhubcomments").autocomplete({
                source: BTDTL_SEARCH_comments,
                select: AutoCompleteSelectHandler
            });});
        $(document).on('keypress','#BTDTL_SEARCH_ta_starhubbasic',function(){
            BTDTL_SEARCH_flag_autocom=0;
            highlightSearchText();
            $("#BTDTL_SEARCH_ta_starhubbasic").autocomplete({
                source: BTDTL_SEARCH_comments,
                select: AutoCompleteSelectHandler
            });});
        $(document).on('keypress','#BTDTL_SEARCH_ta_starhubaddtnlch',function(){
            BTDTL_SEARCH_flag_autocom=0;
            highlightSearchText();
            $("#BTDTL_SEARCH_ta_starhubaddtnlch").autocomplete({
                source: BTDTL_SEARCH_comments,
                select: AutoCompleteSelectHandler
            });
        });
        /*----------------------------------------------------FUNCTION TO HIGHLIGHT SEARCH TEXT------------------------------------------------------------------------*/
        function highlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            }}
        /*---------------------------------------------------FUNCTION TO GET SELECTED VALUE----------------------------------------------------------------*/
        function AutoCompleteSelectHandler(event, ui) {
            var BTDTL_SEARCH_comment_value=ui.item.value;
            BTDTL_SEARCH_flag_autocom=1;
        }
//CHANGE FUNCTION FOR CUSTOMER NAME
        $(document).on('change blur','.BTDTL_SEARCH_class_autocomplete',function(){
            if(BTDTL_SEARCH_flag_autocom==1){
                $('#BTDTL_SEARCH_lbl_errauto').text('')
                $('#BTDTL_SEARCH_btn_datesearch').removeAttr("disabled");
            }
            else
            {
                $('#BTDTL_SEARCH_lbl_errauto').addClass('errormsg')
                if((BTDTL_SEARCH_comment_flag==101)&&($('#BTDTL_SEARCH_ta_airconcomments').val()!=''))
                    $('#BTDTL_SEARCH_lbl_errauto').text(BTDTL_SEARCH_errorarr[47].EMC_DATA.replace('[ACOMTS]',$('#BTDTL_SEARCH_ta_airconcomments').val()))
                else if((BTDTL_SEARCH_comment_flag==103)&&($('#BTDTL_SEARCH_ta_carparkcomments').val()!=''))
                    $('#BTDTL_SEARCH_lbl_errauto').text(BTDTL_SEARCH_errorarr[48].EMC_DATA.replace('[CCOMTS]',$('#BTDTL_SEARCH_ta_carparkcomments').val()))
                else if((BTDTL_SEARCH_comment_flag==108)&&($('#BTDTL_SEARCH_ta_digitalcomments').val()!=''))
                    $('#BTDTL_SEARCH_lbl_errauto').text(BTDTL_SEARCH_errorarr[49].EMC_DATA.replace('[DCOMTS]',$('#BTDTL_SEARCH_ta_digitalcomments').val()))
                else if((BTDTL_SEARCH_comment_flag==104)&&($('#BTDTL_SEARCH_ta_electricitycomments').val()!=''))
                    $('#BTDTL_SEARCH_lbl_errauto').text(BTDTL_SEARCH_errorarr[50].EMC_DATA.replace('[ECOMTS]',$('#BTDTL_SEARCH_ta_electricitycomments').val()))
                else if((BTDTL_SEARCH_comment_flag==122)&&($('#BTDTL_SEARCH_ta_starhubcomments').val()!=''))
                    $('#BTDTL_SEARCH_lbl_errauto').text(BTDTL_SEARCH_errorarr[51].EMC_DATA.replace('[SCOMTS]',$('#BTDTL_SEARCH_ta_starhubcomments').val()))
                else if((BTDTL_SEARCH_comment_flag==110)&&($('#BTDTL_SEARCH_ta_starhubaddtnlch').val()!=''))
                    $('#BTDTL_SEARCH_lbl_errauto').text(BTDTL_SEARCH_errorarr[52].EMC_DATA.replace('[ADDTNLCH]',$('#BTDTL_SEARCH_ta_starhubaddtnlch').val()))
                else if((BTDTL_SEARCH_comment_flag==112)&&($('#BTDTL_SEARCH_ta_starhubbasic').val()!=''))
                    $('#BTDTL_SEARCH_lbl_errauto').text(BTDTL_SEARCH_errorarr[54].EMC_DATA.replace('[BGROUP]',$('#BTDTL_SEARCH_ta_starhubbasic').val()))
                $("#BTDTL_SEARCH_btn_datesearch").attr("disabled", "disabled");
            }});
        /*----------------------------------------------------CHANGE EVENT FUNCTION FOR EXPENSE TYPES---------------------------------------------------*/
        $('#BTDTL_SEARCH_lb_expense_type').change(function(){
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            $("textarea").height(116);
            $('#BTDTL_SEARCH_lb_searchoptions').html('');
            var BTDTL_SEARCH_bizdetail_search_exp_types = $(this).val();
            $('#BTDTL_SEARCH_tble_update').empty();
            $('#BTDTL_SEARCH_lb_searchoptions').hide();
            $('#BTDTL_SEARCH_lbl_searchoptions').hide();
            $('#BTDTL_SEARCH_div_aircon').hide();
            $('#BTDTL_SEARCH_div_flex_searchbtn').hide();
            $('#BTDTL_SEARCH_div_update').hide();
            $('#BTDTL_SEARCH_div_errmsg').text('');
            $('#BTDTL_SEARCH_div_msg').text('');
            $('#BTDTL_SEARCH_btn_datesearch').attr("disabled", "disabled")
            if($('#BTDTL_SEARCH_lb_expense_type').val()!='SELECT'){
                if($('#BTDTL_SEARCH_lb_expense_type').val()==16){//AIRCON
                    if(BTDTL_SEARCH_aircontypes_flag==false)
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text(BTDTL_SEARCH_errorarr[41].EMC_DATA)
                    else{
                        $('#BTDTL_SEARCH_lb_searchoptions').show();
                        $('#BTDTL_SEARCH_lbl_searchoptions').show();
                        $('#BTDTL_SEARCH_lb_searchoptions').html('');
                        $('#BTDTL_SEARCH_lb_searchoptions').html(BTDTL_SEARCH_aircontypes);
                        $('#BTDTL_SEARCH_lb_searchoptions').focus();
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text('');
                    }}
                else if($('#BTDTL_SEARCH_lb_expense_type').val()==17){//CARPARK
                    if(BTDTL_SEARCH_carparktypes_flag==false)
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text(BTDTL_SEARCH_errorarr[39].EMC_DATA)
                    else{
                        $('#BTDTL_SEARCH_lb_searchoptions').show();
                        $('#BTDTL_SEARCH_lbl_searchoptions').show();
                        $('#BTDTL_SEARCH_lb_searchoptions').html('');
                        $('#BTDTL_SEARCH_lb_searchoptions').html(BTDTL_SEARCH_carparktypes);
                        $('#BTDTL_SEARCH_lb_searchoptions').focus();
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text('');
                    }}
                else if($('#BTDTL_SEARCH_lb_expense_type').val()==15){//DIGITAL VOICE
                    if(BTDTL_SEARCH_digitaltypes_flag==false)
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text(BTDTL_SEARCH_errorarr[40].EMC_DATA)
                    else{
                        $('#BTDTL_SEARCH_lb_searchoptions').show();
                        $('#BTDTL_SEARCH_lbl_searchoptions').show();
                        $('#BTDTL_SEARCH_lb_searchoptions').html('');
                        $('#BTDTL_SEARCH_lb_searchoptions').html(BTDTL_SEARCH_digitaltypes);
                        $('#BTDTL_SEARCH_lb_searchoptions').focus();
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text('');
                    }}
                else if($('#BTDTL_SEARCH_lb_expense_type').val()==13){//ELECTRICITY
                    if(BTDTL_SEARCH_electricitytypes_flag==false)
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text(BTDTL_SEARCH_errorarr[38].EMC_DATA)
                    else{
                        $('#BTDTL_SEARCH_lb_searchoptions').show();
                        $('#BTDTL_SEARCH_lbl_searchoptions').show();
                        $('#BTDTL_SEARCH_lb_searchoptions').html('');
                        $('#BTDTL_SEARCH_lb_searchoptions').html(BTDTL_SEARCH_electricitytypes);
                        $('#BTDTL_SEARCH_lb_searchoptions').focus();
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text('');
                    }}
                else if($('#BTDTL_SEARCH_lb_expense_type').val()==14){//STARHUB
                    if(BTDTL_SEARCH_starhubtypes_flag==false)
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text(BTDTL_SEARCH_errorarr[37].EMC_DATA)
                    else{
                        $('#BTDTL_SEARCH_lb_searchoptions').show();
                        $('#BTDTL_SEARCH_lbl_searchoptions').show();
                        $('#BTDTL_SEARCH_lb_searchoptions').html('');
                        $('#BTDTL_SEARCH_lb_searchoptions').html(BTDTL_SEARCH_starhubtypes);
                        $('#BTDTL_SEARCH_lb_searchoptions').focus();
                        $('#BTDTL_SEARCH_lbl_errmsg_notable').text('');
                    }}}
            else
                $('#BTDTL_SEARCH_lbl_errmsg_notable').text('');
        });
        /*----------------------------------------------------CHANGE EVENT FUNCTION FOR SEARCH OPTION----------------------------------------------------*/
        $('#BTDTL_SEARCH_lb_searchoptions').change(function(){
            $("textarea").height(116);
            $('#BTDTL_SEARCH_div_aircon').hide();
            $('#BTDTL_SEARCH_tble_update').empty();
            $('#BTDTL_SEARCH_div_flex_searchbtn').hide();
            $('#BTDTL_SEARCH_div_update').hide();
            $('#BTDTL_SEARCH_div_errmsg').text('');
            $('#BTDTL_SEARCH_div_msg').text('');
            var BTDTL_SEARCH_search_option = $(this).val();
            var BTDTL_SEARCH_lb_expense_types = $('#BTDTL_SEARCH_lb_expense_type').val();
            if(BTDTL_SEARCH_search_option!='SELECT')
            {
                $(".preloader").show();
                var BTDTL_SEARCH_flag_searchby='BTDTL_SEARCH_flag_load';
                if(BTDTL_SEARCH_search_option==100)//AIRCON SERVICED BY
                {
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BTDTL_SEARCH_expense_searchby",
                        data:{'BTDTL_SEARCH_search_option':BTDTL_SEARCH_search_option,'BTDTL_SEARCH_lb_expense_types':BTDTL_SEARCH_lb_expense_types,'BTDTL_SEARCH_flag_searchby':BTDTL_SEARCH_flag_searchby},
                        success: function(res) {
                            $('.preloader').hide();
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                            var result=JSON.parse(res)
                            BTDTL_SEARCH_success_showflex(result);

                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: controller_url+"BTDTL_SEARCH_expense_searchby",
                        data:{'BTDTL_SEARCH_search_option':BTDTL_SEARCH_search_option,'BTDTL_SEARCH_lb_expense_types':BTDTL_SEARCH_lb_expense_types,'BTDTL_SEARCH_flag_searchby':BTDTL_SEARCH_flag_searchby},
                        success: function(res) {
                            $('.preloader').hide();
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                            var result=JSON.parse(res)
                            BTDTL_SEARCH_success_searchby(result);

                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                        }
                    });
                }
            }
        });
        /*-----------------------------SUCCESS FUNCTION FOR SEARCH BY OPTION------------------------------------------------------------*/
        function BTDTL_SEARCH_success_searchby(BTDTL_SEARCH_response){
            $(".preloader").hide();
            $('#BTDTL_SEARCH_div_aircon').show();
            var BTDTL_SEARCH_lb_expense_types = $('#BTDTL_SEARCH_lb_expense_type').val();
            var BTDTL_SEARCH_search_option = $('#BTDTL_SEARCH_lb_searchoptions').val();
            $('#BTDTL_SEARCH_btn_datesearch').attr("disabled", "disabled")
            $('#BTDTL_SEARCH_tble_searchby').empty();
            var BTDTL_SEARCH_searchby_arr=[];
            var BTDTL_SEARCH_flag=BTDTL_SEARCH_response.BTDTL_SEARCH_search_flag;
            var BTDTL_SEARCH_parentfunction=BTDTL_SEARCH_response.BTDTL_SEARCH_parentfunction;
            BTDTL_SEARCH_searchby_arr=BTDTL_SEARCH_response.BTDTL_SEARCH_searchvalue;
            if((BTDTL_SEARCH_searchby_arr!='')&&(BTDTL_SEARCH_searchby_arr!=undefined))
            {
                var BTDTL_SEARCH_options ='<option>SELECT</option>';
                for (var i = 0; i < BTDTL_SEARCH_searchby_arr.length; i++)
                {
                    BTDTL_SEARCH_options += '<option value="' + BTDTL_SEARCH_searchby_arr[i]  + '">' + BTDTL_SEARCH_searchby_arr[i] + '</option>';
                }
                $('<div class="srctitle">'+$('#BTDTL_SEARCH_lb_searchoptions').find('option:selected').text()+'</div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                if(BTDTL_SEARCH_search_option==191)//UNIT NO
                {
                    if(BTDTL_SEARCH_lb_expense_types==16)//AIRCON
                        $('<div class="form-group"><label class="col-sm-2">UNIT NO<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_ariconunitno form-control" id="BTDTL_SEARCH_lb_ariconunitno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                    else if(BTDTL_SEARCH_lb_expense_types==17)//CARPARK
                        $('<div class="form-group"><label class="col-sm-2">UNIT NO<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_carparkunitno form-control" id="BTDTL_SEARCH_lb_carparkunitno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                    else if(BTDTL_SEARCH_lb_expense_types==15)//DIGITAL VOICE
                        $('<div class="form-group"><label class="col-sm-2">UNIT NO<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_digitalunitno form-control" id="BTDTL_SEARCH_lb_digitalunitno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                    else if(BTDTL_SEARCH_lb_expense_types==13)//ELECTRICITY
                        $('<div class="form-group"><label class="col-sm-2">UNIT NO<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_electricityunitno form-control" id="BTDTL_SEARCH_lb_electricityunitno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                    else if(BTDTL_SEARCH_lb_expense_types==14)//STARHUB
                        $('<div class="form-group"><label class="col-sm-2">UNIT NO<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_starhubunitno form-control" id="BTDTL_SEARCH_lb_starhubunitno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==195)
                {
                    $('<div class="form-group"><label class="col-sm-2">AIRCON SERVICED WITH UNIT<em>*</em></label><div class="col-sm-4"><select class="BTDTL_SEARCH_class_ariconservicedbyunitno form-control" id="BTDTL_SEARCH_lb_ariconservicedbyunitno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==102)
                {
                    $('<div class="form-group"><label class="col-sm-2">CARNO<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_carno form-control" id="BTDTL_SEARCH_lb_carno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==109)
                {
                    $('<div class="form-group"><label class="col-sm-2">DIGITAL ACCOUNT NO<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_digitalacctno form-control" id="BTDTL_SEARCH_lb_digitalacctno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==107)
                {
                    $('<div class="form-group"><label class="col-sm-2">DIGITAL INVOICE TO<em>*</em></label><div class="col-sm-3"><select class="BTDTL_SEARCH_class_digitalinvoiceto form-control" id="BTDTL_SEARCH_lb_digitalinvoiceto">'+BTDTL_SEARCH_options_invoiceto+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==106)
                {
                    $('<div class="form-group"><label class="col-sm-2">DIGITAL VOICE NO<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_digitalvoiceno form-control" id="BTDTL_SEARCH_lb_digitalvoiceno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==105)
                {
                    $('<div class="form-group"><label class="col-sm-2">ELECTRICITY INVOICE TO<em>*</em></label><div class="col-sm-3"><select class="BTDTL_SEARCH_class_electricityinvoiceto form-control" id="BTDTL_SEARCH_lb_electricityinvoiceto">'+BTDTL_SEARCH_options_invoiceto+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==118)
                {
                    $('<div class="form-group"><label class="col-sm-2">STARHUB INVOICE TO<em>*</em></label><div class="col-sm-3"><select class="BTDTL_SEARCH_class_starhubinvoiceto form-control" id="BTDTL_SEARCH_lb_starhubinvoiceto">'+BTDTL_SEARCH_options_invoiceto+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==123)
                {
                    $('<div class="form-group"><label class="col-sm-2">STARHUB ACCOUNT NO<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_starhubacctno form-control" id="BTDTL_SEARCH_lb_starhubacctno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==113)
                {
                    $('<div class="form-group"><label class="col-sm-2">STARHUB CABLE BOX SERIAL NO<em>*</em></label><div class="col-sm-4"><select class="BTDTL_SEARCH_class_starhub_cableserialno form-control" id="BTDTL_SEARCH_lb_starhub_cableserialno">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==119)
                {
                    $('<div class="form-group"><label class="col-sm-2">STARHUB MODEM SERIAL NO<em>*</em></label><div class="col-sm-4"><select class="BTDTL_SEARCH_class_starhubmodem form-control" id="BTDTL_SEARCH_lb_starhubmodem">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==121)
                {
                    $('<div class="form-group"><label class="col-sm-2">STARHUB PWD<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_starhubpwd form-control" id="BTDTL_SEARCH_lb_starhubpwd">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if(BTDTL_SEARCH_search_option==120)
                {
                    $('<div class="form-group"><label class="col-sm-2">STARHUB SSID<em>*</em></label><div class="col-sm-2"><select class="BTDTL_SEARCH_class_starhubssid form-control" id="BTDTL_SEARCH_lb_starhubssid">'+BTDTL_SEARCH_options+'</select></div></div>').appendTo($("#BTDTL_SEARCH_tble_searchby"));
                }
                else if((BTDTL_SEARCH_search_option==101)||(BTDTL_SEARCH_search_option==108)||(BTDTL_SEARCH_search_option==110)||(BTDTL_SEARCH_search_option==111)||(BTDTL_SEARCH_search_option==122)||(BTDTL_SEARCH_search_option==112)||(BTDTL_SEARCH_search_option==104)||(BTDTL_SEARCH_search_option==103)||(BTDTL_SEARCH_search_option==117)||(BTDTL_SEARCH_search_option==116)||(BTDTL_SEARCH_search_option==115)||(BTDTL_SEARCH_search_option==114)||(BTDTL_SEARCH_search_option==110))
                {
                    var BTDTL_SEARCH_table_searchby  ='';
                    if(BTDTL_SEARCH_search_option==101)
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">AIRCON COMMENTS<em>*</em></label><div class="col-sm-4"><textarea class="BTDTL_SEARCH_class_autocomplete BTDTL_SEARCH_comments form-control" id="BTDTL_SEARCH_ta_airconcomments" style="height: 116px"></textarea></div></div><div><label id="BTDTL_SEARCH_lbl_errauto"></label></div>'
                    }
                    else if(BTDTL_SEARCH_search_option==108)
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">DIGITAL COMMENTS<em>*</em></label><div class="col-sm-4"><textarea class="BTDTL_SEARCH_class_autocomplete BTDTL_SEARCH_comments form-control" id="BTDTL_SEARCH_ta_digitalcomments" style="height: 116px"></textarea></div></div><div><label id="BTDTL_SEARCH_lbl_errauto"></label></div>';
                    }
                    else if(BTDTL_SEARCH_search_option==104)
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">ELECTRICITY COMMENTS<em>*</em></label><div class="col-sm-4"><textarea class="BTDTL_SEARCH_class_autocomplete BTDTL_SEARCH_comments form-control" id="BTDTL_SEARCH_ta_electricitycomments" style="height: 116px"></textarea></div></div><div><label id="BTDTL_SEARCH_lbl_errauto"></label></div>';
                    }
                    else if(BTDTL_SEARCH_search_option==103)
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">CARPARK COMMENTS<em>*</em></label><div class="col-sm-4"><textarea class="BTDTL_SEARCH_class_autocomplete BTDTL_SEARCH_comments form-control" id="BTDTL_SEARCH_ta_carparkcomments" style="height: 116px"></textarea></div></div><div><label id="BTDTL_SEARCH_lbl_errauto"></label></div>';
                    }
                    else if(BTDTL_SEARCH_search_option==122)
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">STARHUB COMMENTS<em>*</em></label><div class="col-sm-4"><textarea class="BTDTL_SEARCH_class_autocomplete BTDTL_SEARCH_comments form-control" id="BTDTL_SEARCH_ta_starhubcomments" style="height: 116px"></textarea></div></div><div><label id="BTDTL_SEARCH_lbl_errauto"></label></div>';
                    }
                    else if(BTDTL_SEARCH_search_option==110)
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">STARHUB ADDTNL CH<em>*</em></label><div class="col-sm-4"><textarea class="BTDTL_SEARCH_class_autocomplete BTDTL_SEARCH_comments form-control" id="BTDTL_SEARCH_ta_starhubaddtnlch" style="height: 116px"></textarea></div></div><div><label id="BTDTL_SEARCH_lbl_errauto"></label></div>';
                    }
                    else if(BTDTL_SEARCH_search_option==111)
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">FROM DATE<em>*</em></label><div class="col-sm-2"><div class="input-group addon"><input type="text" id="BTDTL_SEARCH_db_starhubappl_startdate" class="BTDTL_SEARCH_class_datesearchbtn datemandtry form-control"><label for="BTDTL_SEARCH_db_starhubappl_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div></div><div class="form-group"><label class="col-sm-2">TO DATE<em>*</em></label><div class="col-sm-2"><div class="input-group addon"><input type="text" id="BTDTL_SEARCH_db_starhubappl_enddate"  class="datemandtry BTDTL_SEARCH_class_datesearchbtn form-control"><label for="BTDTL_SEARCH_db_starhubappl_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div></div>';
                    }
                    else if(BTDTL_SEARCH_search_option==112)
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">STARHUB BASIC GROUP<em>*</em></label><div class="col-sm-3"><textarea class="BTDTL_SEARCH_class_autocomplete BTDTL_SEARCH_comments form-control" id="BTDTL_SEARCH_ta_starhubbasic" style="height: 116px"></textarea></div></div><div><label id="BTDTL_SEARCH_lbl_errauto"></label></div>';
                    }
                    else if((BTDTL_SEARCH_search_option==115)||(BTDTL_SEARCH_search_option==114))
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">FROM DATE<em>*</em></label><div class="col-sm-2"><div class="input-group addon"><input type="text" id="BTDTL_SEARCH_db_starhubcable_startdate"  class="BTDTL_SEARCH_class_datesearchbtn datemandtry form-control"><label for="BTDTL_SEARCH_db_starhubcable_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div></div><div class="form-group"><label class="col-sm-2">TO DATE<em>*</em></label><div class="col-sm-2"><div class="input-group addon"><input type="text" id="BTDTL_SEARCH_db_starhubcable_enddate"  class="BTDTL_SEARCH_class_datesearchbtn datemandtry form-control"><label for="BTDTL_SEARCH_db_starhubcable_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div></div>';
                    }
                    else if((BTDTL_SEARCH_search_option==117)||(BTDTL_SEARCH_search_option==116))
                    {
                        BTDTL_SEARCH_table_searchby +='<div class="form-group"><label class="col-sm-2">FROM DATE<em>*</em></label><div class="col-sm-2"><div class="input-group addon"><input type="text"  id="BTDTL_SEARCH_db_starhubinternet_startdate"  class="BTDTL_SEARCH_class_datesearchbtn datemandtry form-control"><label for="BTDTL_SEARCH_db_starhubinternet_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div></div><div class="form-group"><label class="col-sm-2">TO DATE<em>*</em></label><div class="col-sm-2"><div class="input-group addon"><input type="text" id="BTDTL_SEARCH_db_starhubinternet_enddate"  class="BTDTL_SEARCH_class_datesearchbtn datemandtry form-control"><label for="BTDTL_SEARCH_db_starhubinternet_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label></div></div></div>';
                    }
                    BTDTL_SEARCH_table_searchby +=' <div class="col-lg-offset-2" id="BDTL_INPUT_tble_btn"><input type="button" id="BTDTL_SEARCH_btn_datesearch" value="SEARCH" class="btn" disabled=""></div>';
                    $(BTDTL_SEARCH_table_searchby).appendTo($("#BTDTL_SEARCH_tble_searchby"));
                    if((BTDTL_SEARCH_search_option==112)||(BTDTL_SEARCH_search_option==110)||(BTDTL_SEARCH_search_option==122)||(BTDTL_SEARCH_search_option==104)||(BTDTL_SEARCH_search_option==108)||(BTDTL_SEARCH_search_option==103)||(BTDTL_SEARCH_search_option==101)){
                        $.ajax({
                            type: "POST",
                            url: controller_url+"BTDTL_SEARCH_comments_autocomplete",
                            data:{'searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val()},
                            success: function(res) {
                                $('.preloader').hide();
                                var result=JSON.parse(res)
                                BTDTL_SEARCH_success_comments(result);
                            },
                            error: function (data) {
                                alert('error in getting' + JSON.stringify(data));
                            }
                        });
                    }
                    /*------------------------------------------------------------VALIDATION FOR DATE BOX-------------------------------------------------------------------------------------------------*/
                    $('textarea').autogrow({onInitialize: true});
                    $(document).doValidation({rule:'fromto',prop:{elem1:'BTDTL_SEARCH_db_starhubappl_startdate',elem2:'BTDTL_SEARCH_db_starhubappl_enddate'}});
                    $(document).doValidation({rule:'fromto',prop:{elem1:'BTDTL_SEARCH_db_starhubcable_startdate',elem2:'BTDTL_SEARCH_db_starhubcable_enddate'}});
                    $(document).doValidation({rule:'fromto',prop:{elem1:'BTDTL_SEARCH_db_starhubinternet_startdate',elem2:'BTDTL_SEARCH_db_starhubinternet_enddate'}});
                    $('#BTDTL_SEARCH_db_starhubappl_startdate,#BTDTL_SEARCH_db_starhubappl_enddate,#BTDTL_SEARCH_db_starhubcable_startdate,#BTDTL_SEARCH_db_starhubcable_enddate,#BTDTL_SEARCH_db_starhubinternet_startdate,#BTDTL_SEARCH_db_starhubinternet_enddate').datepicker("option","maxDate",new Date());
                    if(BTDTL_SEARCH_search_option==114 || BTDTL_SEARCH_search_option==116)
                        $('#BTDTL_SEARCH_db_starhubcable_startdate,#BTDTL_SEARCH_db_starhubcable_enddate,#BTDTL_SEARCH_db_starhubinternet_startdate,#BTDTL_SEARCH_db_starhubinternet_enddate').datepicker("option", { maxDate: null});
                }}
            $(".preloader").hide();
            if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_update_listbox')
            {
                if(BTDTL_SEARCH_search_option==100)//AIRCON SERVICED BY
                {
                    $('#BTDTL_SEARCH_lb_searchoptions').val('SELECT')
                    var BTDTL_SEARCH_errorupdate_replace=BTDTL_SEARCH_errorarr[60].EMC_DATA;
                }
                else
                    var BTDTL_SEARCH_errorupdate_replace=BTDTL_SEARCH_errorarr[4].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorupdate_replace,"success",false);
            }
            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_delete')
            {
                if(BTDTL_SEARCH_search_option==100)//AIRCON SERVICED BY
                {
                    $('#BTDTL_SEARCH_lb_searchoptions').val('SELECT')
                }
                var BTDTL_SEARCH_errordelete_replace=BTDTL_SEARCH_errorarr[5].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errordelete_replace,"success",false);
            }
        }
        /*---------------------------------------------CLICK FUNCTION FOR SEARCH BY ALL TYPES-------------------------------------------------*/
        $(document).on('change','#BTDTL_SEARCH_tble_searchby',function(){
            $('#BTDTL_SEARCH_tble_update').empty();
            $('#BTDTL_SEARCH_div_flex_searchbtn').hide();
            $('#BTDTL_SEARCH_tble_updatereset').hide();
            $('#BTDTL_SEARCH_btn_search').attr("disabled", "disabled")
            $('#BTDTL_SEARCH_btn_delete').attr("disabled", "disabled")
            $('#BTDTL_SEARCH_btn_update').attr("disabled", "disabled")
            $('#BTDTL_SEARCH_div_errmsg').text('');
            $('#BTDTL_SEARCH_div_msg').text('');
        });
        /*---------------------------------------------CHANGE EVENT FUNCTION FOR AIRCON UNIT NO----------------------------------------*/
        $(document).on('change','.BTDTL_SEARCH_class_ariconunitno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_ariconunitno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_flex_aircon",
                    data:{'BTDTL_SEARCH_lb_ariconunitno':$('#BTDTL_SEARCH_lb_ariconunitno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        /*---------------------------------------------CHANGE EVENT FUNCTION FOR SEARCH BY ALL TYPES OF EXPENSE----------------------------------------*/
        $(document).on('change','.BTDTL_SEARCH_class_ariconservicedbyunitno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_ariconservicedbyunitno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_flex_aircon1",
                    data:{'BTDTL_SEARCH_lb_ariconservicedbyunitno':$('#BTDTL_SEARCH_lb_ariconservicedbyunitno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_carno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_carno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_carpark",
                    data:{'BTDTL_SEARCH_lb_carno':$('#BTDTL_SEARCH_lb_carno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_carparkunitno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_carparkunitno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_carpark1",
                    data:{'BTDTL_SEARCH_lb_carparkunitno':$('#BTDTL_SEARCH_lb_carparkunitno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_digitalacctno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_digitalacctno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_digital",
                    data:{'BTDTL_SEARCH_lb_digitalacctno':$('#BTDTL_SEARCH_lb_digitalacctno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_digitalvoiceno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_digitalvoiceno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_digital1",
                    data:{'BTDTL_SEARCH_lb_digitalvoiceno':$('#BTDTL_SEARCH_lb_digitalvoiceno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_digitalinvoiceto',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_digitalinvoiceto').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_digital2",
                    data:{'BTDTL_SEARCH_lb_digitalinvoiceto':$('#BTDTL_SEARCH_lb_digitalinvoiceto').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_digitalunitno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_digitalunitno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_digital3",
                    data:{'BTDTL_SEARCH_lb_digitalunitno':$('#BTDTL_SEARCH_lb_digitalunitno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_electricityinvoiceto',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_electricityinvoiceto').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_electricity",
                    data:{'BTDTL_SEARCH_lb_electricityinvoiceto':$('#BTDTL_SEARCH_lb_electricityinvoiceto').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_electricityunitno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_electricityunitno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_electricity1",
                    data:{'BTDTL_SEARCH_lb_electricityunitno':$('#BTDTL_SEARCH_lb_electricityunitno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_starhubunitno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_starhubunitno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub",
                    data:{'BTDTL_SEARCH_lb_starhubunitno':$('#BTDTL_SEARCH_lb_starhubunitno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_starhubacctno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_starhubacctno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub1",
                    data:{'BTDTL_SEARCH_flag':$('#BTDTL_SEARCH_flag').val(),'BTDTL_SEARCH_lb_starhubacctno':$('#BTDTL_SEARCH_lb_starhubacctno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_starhubinvoiceto',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_starhubinvoiceto').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub2",
                    data:{'BTDTL_SEARCH_emptyflag':$('#BTDTL_SEARCH_emptyflag').val(),'BTDTL_SEARCH_lb_starhubinvoiceto':$('#BTDTL_SEARCH_lb_starhubinvoiceto').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_starhubssid',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_starhubssid').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub3",
                    data:{'BTDTL_SEARCH_emptyflag':$('#BTDTL_SEARCH_emptyflag').val(),'BTDTL_SEARCH_lb_starhubssid':$('#BTDTL_SEARCH_lb_starhubssid').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_starhubpwd',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_starhubpwd').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub4",
                    data:{'BTDTL_SEARCH_emptyflag':$('#BTDTL_SEARCH_emptyflag').val(),'BTDTL_SEARCH_lb_starhubpwd':$('#BTDTL_SEARCH_lb_starhubpwd').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_starhubmodem',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_starhubmodem').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub5",
                    data:{'BTDTL_SEARCH_emptyflag':$('#BTDTL_SEARCH_emptyflag').val(),'BTDTL_SEARCH_lb_starhubmodem':$('#BTDTL_SEARCH_lb_starhubmodem').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('change','.BTDTL_SEARCH_class_starhub_cableserialno',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            if($('#BTDTL_SEARCH_lb_starhub_cableserialno').val()!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub6",
                    data:{'BTDTL_SEARCH_emptyflag':$('#BTDTL_SEARCH_emptyflag').val(),'BTDTL_SEARCH_lb_starhub_cableserialno':$('#BTDTL_SEARCH_lb_starhub_cableserialno').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        $(document).on('click','#BTDTL_SEARCH_btn_datesearch',function(evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $(".preloader").show();
            if($('#BTDTL_SEARCH_lb_searchoptions').val()==101)//AIRCON COMMENTS
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_flex_aircon2",
                    data:{'BTDTL_SEARCH_ta_airconcomments':$('#BTDTL_SEARCH_ta_airconcomments').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==103)//CARPARK COMMENTS
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_carpark2",
                    data:{'BTDTL_SEARCH_ta_carparkcomments':$('#BTDTL_SEARCH_ta_carparkcomments').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==108)//DIGITAL COMMENTS
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_digital4",
                    data:{'BTDTL_SEARCH_ta_digitalcomments':$('#BTDTL_SEARCH_ta_digitalcomments').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==104)//ELECTRICITY COMMENTS
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_electricity2",
                    data:{'BTDTL_SEARCH_ta_electricitycomments':$('#BTDTL_SEARCH_ta_electricitycomments').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==110)//ADDITIONAL CHANNEL
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub7",
                    data:{'BTDTL_SEARCH_emptyflag':$('#BTDTL_SEARCH_emptyflag').val(),'BTDTL_SEARCH_ta_starhubaddtnlch':$('#BTDTL_SEARCH_ta_starhubaddtnlch').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==112)//BASIC GROUP
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub8",
                    data:{'BTDTL_SEARCH_emptyflag':$('#BTDTL_SEARCH_emptyflag').val(),'BTDTL_SEARCH_ta_starhubbasic':$('#BTDTL_SEARCH_ta_starhubbasic').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==122)//STARHUB COMMENTS
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub9",
                    data:{'BTDTL_SEARCH_emptyflag':$('#BTDTL_SEARCH_emptyflag').val(),'BTDTL_SEARCH_ta_starhubcomments':$('#BTDTL_SEARCH_ta_starhubcomments').val(),'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==111)//STARHUB APPL DATE
            {
                var BTDTL_SEARCH_starhubappl_startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubappl_startdate').val());
                var BTDTL_SEARCH_starhubappl_enddate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubappl_enddate').val());
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub10",
                    data:{'BTDTL_SEARCH_starhubappl_startdate':BTDTL_SEARCH_starhubappl_startdate,'BTDTL_SEARCH_starhubappl_enddate':BTDTL_SEARCH_starhubappl_enddate,'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else if(($('#BTDTL_SEARCH_lb_searchoptions').val()==114)||($('#BTDTL_SEARCH_lb_searchoptions').val()==115))//CABLE START DATE & END DATE
            {
                var BTDTL_SEARCH_cable_startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                var BTDTL_SEARCH_cable_enddate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_enddate').val());
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub11",
                    data:{'BTDTL_SEARCH_cable_startdate':BTDTL_SEARCH_cable_startdate,'BTDTL_SEARCH_cable_enddate':BTDTL_SEARCH_cable_enddate,'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else if(($('#BTDTL_SEARCH_lb_searchoptions').val()==116)||($('#BTDTL_SEARCH_lb_searchoptions').val()==117))//INTERNET START DATE & END DATE
            {
                var BTDTL_SEARCH_internet_startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                var BTDTL_SEARCH_internet_enddate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
                $.ajax({
                    type: "POST",
                    url: controller_url+"BTDTL_SEARCH_show_starhub12",
                    data:{'BTDTL_SEARCH_internet_startdate':BTDTL_SEARCH_internet_startdate,'BTDTL_SEARCH_internet_enddate':BTDTL_SEARCH_internet_enddate,'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_parentfunc_flex':'BTDTL_SEARCH_parentfunc_flex'},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BTDTL_SEARCH_success_showflex(result);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        /*--------------------------------------------SUCCESS FUNCTION FOR FLEX TABLE-----------------------------------------------------*/
        var BTDTL_SEARCH_searchvalue=[];
        var BTDTL_SEARCH_response=[];
        function BTDTL_SEARCH_success_showflex(BTDTL_SEARCH_responseflex){
            $('#BTDTL_SEARCH_div_flex').hide();
            $('#BDTL_btn_pdf').hide();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            $('#BTDTL_SEARCH_btn_datesearch').attr("disabled", "disabled")
            $('#BTDTL_SEARCH_tble_searchdel').hide();
            $('#BTDTL_SEARCH_div_errmsg').text('');
            $('#BTDTL_SEARCH_div_msg').text('');
            $('#BTDTL_SEARCH_div_update').hide();
            var BTDTL_SEARCH_searchby_arr=[];
            var BTDTL_SEARCH_id=[];
            var BTDTL_SEARCH_aircon_unitno=BTDTL_SEARCH_responseflex.BTDTL_SEARCH_search_flag;
            BTDTL_SEARCH_searchby_arr=BTDTL_SEARCH_responseflex.BTDTL_SEARCH_aircondata;
            BTDTL_SEARCH_id=BTDTL_SEARCH_responseflex.BTDTL_SEARCH_id;
            BTDTL_SEARCH_response=BTDTL_SEARCH_responseflex.BTDTL_SEARCH_expenseflex;
            BTDTL_SEARCH_searchvalue=BTDTL_SEARCH_responseflex.BTDTL_SEARCH_searchvalue;
            airconservicebyarray=BTDTL_SEARCH_responseflex.airconservicebyarray;
            var BTDTL_SEARCH_expensetypes=$('#BTDTL_SEARCH_lb_expense_type').val();
            if(BTDTL_SEARCH_searchvalue!=undefined){
                if(BTDTL_SEARCH_aircon_unitno==100)
                    BTDTL_SEARCH_response=BTDTL_SEARCH_searchby_arr;
                else
                    BTDTL_SEARCH_success_searchby(BTDTL_SEARCH_responseflex)
            }
            $('#BTDTL_SEARCH_tble_flex').empty();
            var BTDTL_SEARCH_tr  ='';
            if((BTDTL_SEARCH_response!='')&&(BTDTL_SEARCH_response!=undefined))
            {
                if(BTDTL_SEARCH_response.length!=1)
                {
                    $('#BTDTL_SEARCH_div_flex_searchbtn').show();
                    $('#BTDTL_SEARCH_div_flex').show();
                    $('#BTDTL_SEARCH_div_errmsg').text('');
                    if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)//UNIT NO
                    {
                        if(BTDTL_SEARCH_expensetypes==16)//AIRCON SERVICES
                            var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[2].EMC_DATA.replace('[UNIT NO]',$('#BTDTL_SEARCH_lb_ariconunitno').val());
                        else if(BTDTL_SEARCH_expensetypes==17)//CARPARK
                            var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[2].EMC_DATA.replace('[UNIT NO]',$('#BTDTL_SEARCH_lb_carparkunitno').val());
                        else if(BTDTL_SEARCH_expensetypes==15)//DIGITAL VOICE
                            var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[2].EMC_DATA.replace('[UNIT NO]',$('#BTDTL_SEARCH_lb_digitalunitno').val());
                        else if(BTDTL_SEARCH_expensetypes==13)//ELECTRICITY
                            var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[2].EMC_DATA.replace('[UNIT NO]',$('#BTDTL_SEARCH_lb_electricityunitno').val());
                        else if(BTDTL_SEARCH_expensetypes==14)//STARHUB
                            var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[2].EMC_DATA.replace('[UNIT NO]',$('#BTDTL_SEARCH_lb_starhubunitno').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==108)//DIGITAL COMMENTS
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[44].EMC_DATA.replace('[DCOMTS]',$('#BTDTL_SEARCH_ta_digitalcomments').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==104)//ELECTRICITY COMMENTS
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[45].EMC_DATA.replace('[ECOMTS]',$('#BTDTL_SEARCH_ta_electricitycomments').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==122)//STARHUB COMMENTS
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[46].EMC_DATA.replace('[SCOMTS]',$('#BTDTL_SEARCH_ta_starhubcomments').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==101)//AIRCON COMMENTS
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[42].EMC_DATA.replace('[ACOMTS]',$('#BTDTL_SEARCH_ta_airconcomments').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==103)//CARPARK COMMENTS
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[43].EMC_DATA.replace('[CCOMTS]',$('#BTDTL_SEARCH_ta_carparkcomments').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==110)//STARHUB ADDITIONAL CHANNEL
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[30].EMC_DATA.replace('[ADDTNLCH]',$('#BTDTL_SEARCH_ta_starhubaddtnlch').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==112)//STARHUB BASIC
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[28].EMC_DATA.replace('[BG]',$('#BTDTL_SEARCH_ta_starhubbasic').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==195)//ARICON SERVICED WITH UNIT
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[7].EMC_DATA.replace('[AB]',$('#BTDTL_SEARCH_lb_ariconservicedbyunitno').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==100)//AIRCON SERVICED BY
                    {
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_configmon_aircon[1]);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==102)//CAR NO
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[9].EMC_DATA.replace('[CAR NO]',$('#BTDTL_SEARCH_lb_carno').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==109)//DIGITAL ACCOUNT NO
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[17].EMC_DATA.replace('[ACCNO]',$('#BTDTL_SEARCH_lb_digitalacctno').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==107)//DIGITAL INVOICE TO
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[13].EMC_DATA.replace('[INVETO]',$('#BTDTL_SEARCH_lb_digitalinvoiceto').find('option:selected').text());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==106)//DIGITAL VOICE NO
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[15].EMC_DATA.replace('[DGTLVNO]',$('#BTDTL_SEARCH_lb_digitalvoiceno').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==105)//ELECTRICITY INVOICE TO
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[12].EMC_DATA.replace('[INVETO]',$('#BTDTL_SEARCH_lb_electricityinvoiceto').find('option:selected').text());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==123)//STARHUB ACCT NO
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[18].EMC_DATA.replace('[ACCNO]',$('#BTDTL_SEARCH_lb_starhubacctno').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==113)//STARHUB CABLE SERIAL NO
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[24].EMC_DATA.replace('[SNO]',$('#BTDTL_SEARCH_lb_starhub_cableserialno').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==118)//STARHUB INVOICE TO
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[11].EMC_DATA.replace('[INVETO]',$('#BTDTL_SEARCH_lb_starhubinvoiceto').find('option:selected').text());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==119)//STARHUB MODEM SERIAL NO
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[26].EMC_DATA.replace('[SNO]',$('#BTDTL_SEARCH_lb_starhubmodem').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==121)//STARHUB PWD
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[22].EMC_DATA.replace('[PWD]',$('#BTDTL_SEARCH_lb_starhubpwd').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==120)//STARHUB SSID
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[20].EMC_DATA.replace('[SSID]',$('#BTDTL_SEARCH_lb_starhubssid').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==114)//STARHUB CABEL SDATE
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[34].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubcable_enddate').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==115)//STARHUB CABLE EDATE
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[33].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubcable_enddate').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==116)//STARHUB INTERNET SDATE
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[36].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==117)//STARHUB INTERNET EDATE
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[35].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==111)//STARHUB APPL SDATE
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[32].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubappl_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubappl_enddate').val());
                        $('#BTDTL_SEARCH_div_msg').text(BTDTL_SEARCH_error_replace);
                    }
                    if(BTDTL_SEARCH_expensetypes==16){
                        if($('#BTDTL_SEARCH_lb_searchoptions').val()==100)
                        {
                            BTDTL_SEARCH_tr ='<table class="srcresult" id="BTDTL_SEARCH_tble_flex"><thead><tr><th style="width:300px">AIRCON SERVICED BY</th><th style="width:250px">USERSTAMP</th><th style="width:180px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>'
                        }
                        else
                        {
                            BTDTL_SEARCH_tr ='<table class="srcresult" id="BTDTL_SEARCH_tble_flex"><thead><tr><th style="width:20px">DELETE</th><th style="width:75px">UNIT NUMBER</th><th style="width:300px">AIRCON SERVICED BY</th><th style="width:300px">COMMENTS</th><th style="width:250px">USERSTAMP</th><th style="width:130px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>'
                        }
                    }
                    else if(BTDTL_SEARCH_expensetypes==17)
                    {
                        BTDTL_SEARCH_tr ='<table class="srcresult" id="BTDTL_SEARCH_tble_flex"><thead><tr><th style="width:20px">DELETE</th><th style="width:75px">UNIT NUMBER</th><th style="width:80px">CAR NO</th><th style="width:250px">COMMENTS</th><th style="width:250px">USERSTAMP</th><th style="width:130px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';

                    }
                    else if(BTDTL_SEARCH_expensetypes==15)
                    {
                        BTDTL_SEARCH_tr ='<table class="srcresult" id="BTDTL_SEARCH_tble_flex"><thead><tr><th style="width:20px">DELETE</th><th style="width:75px">UNIT NUMBER</th><th style="width:150px">INVOICE TO</th><th style="width:80px">DIGITAL VOICE NO</th><th style="width:110px">DIGITAL ACCOUNT NO</th><th style="width:300px">COMMENTS</th><th style="width:250px">USERSTAMP</th><th style="width:130px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';

                    }
                    else if(BTDTL_SEARCH_expensetypes==13)
                    {
                        BTDTL_SEARCH_tr ='<table class="srcresult" id="BTDTL_SEARCH_tble_flex" ><thead><tr><th style="width:20px">DELETE</th><th style="width:75px">UNIT NUMBER</th><th style="width:140px">INVOICE TO</th><th style="width:300px">COMMENTS</th><th style="width:250px">USERSTAMP</th><th style="width:130px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>'

                    }
                    else if(BTDTL_SEARCH_expensetypes==14){
                        BTDTL_SEARCH_tr = '<table class="srcresult" id="BTDTL_SEARCH_tble_flex" style="width: 2750px;"><thead><tr><th style="width:20px">EDIT/ DELETE</th><th style="width:75px" >UNIT NUMBER</th><th style="width:140px">INVOICE TO</th><th style="width:100px">STARHUB ACCOUNT NO<em>*</em></th><th style="width:75px" class="uk-date-column">APPL DATE</th><th style="width:75px" class="uk-date-column">CABLE START DATE</th><th style="width:75px" class="uk-date-column">CABLE END DATE</th><th style="width:75px" class="uk-date-column">INTERNET START DATE</th><th style="width:75px" class="uk-date-column">INTERNET END DATE</th><th style="width:200px">SSID</th><th style="width:200px">PWD</th><th style="width:200px">CABLE BOX SERIAL NO</th><th style="width:250px">MODEM SERIAL NO</th><th style="width:200px">BASIC GROUP</th><th style="width:200px">ADDTNL CH</th><th style="width:300px">COMMENTS</th><th style="width:200px">USERSTAMP</th><th style="width:130px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';

                    }
                    $('#BDTL_btn_pdf').show();
                }
                else if(BTDTL_SEARCH_response.length==1)
                {
                    $('#BTDTL_SEARCH_div_flex_searchbtn').show();
                    $('#BTDTL_SEARCH_btn_datesearch').attr("disabled", "disabled")
                    $('#BDTL_btn_pdf').hide();
                    if($('#BTDTL_SEARCH_lb_searchoptions').val()==108)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[49].EMC_DATA.replace('[DCOMTS]',$('#BTDTL_SEARCH_ta_digitalcomments').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==104)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[50].EMC_DATA.replace('[ECOMTS]',$('#BTDTL_SEARCH_ta_electricitycomments').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==122)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[51].EMC_DATA.replace('[SCOMTS]',$('#BTDTL_SEARCH_ta_starhubcomments').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==101)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[47].EMC_DATA.replace('[ACOMTS]',$('#BTDTL_SEARCH_ta_airconcomments').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==103)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[48].EMC_DATA.replace('[CCOMTS]',$('#BTDTL_SEARCH_ta_carparkcomments').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==110)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[36].EMC_DATA.replace('[ADDTNLCH]',$('#BTDTL_SEARCH_ta_starhubaddtnlch').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==112)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[54].EMC_DATA.replace('[BGROUP]',$('#BTDTL_SEARCH_ta_starhubbasic').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==100)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[8].EMC_DATA.replace('[AB]',$('#BTDTL_SEARCH_lb_ariconservicedby').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==195)
                    {
                        $('#BTDTL_SEARCH_btn_ariconservicedbyunitno').attr("disabled", "disabled")
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[8].EMC_DATA.replace('[AB]',$('#BTDTL_SEARCH_lb_ariconservicedbyunitno').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==100)
                    {
                        $('#BTDTL_SEARCH_btn_ariconservicedbyunitno').attr("disabled", "disabled")
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[8].EMC_DATA.replace('[AB]',$('#BTDTL_SEARCH_lb_ariconservicedbyunitno').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==102)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[10].EMC_DATA.replace('[CAR NO]',$('#BTDTL_SEARCH_lb_carno').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==123)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[19].EMC_DATA.replace('[ACCNO]',$('#BTDTL_SEARCH_lb_starhubacctno').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==109)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[19].EMC_DATA.replace('[ACCNO]',$('#BTDTL_SEARCH_lb_digitalacctno').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==107)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[14].EMC_DATA.replace('[INVETO]',$('#BTDTL_SEARCH_lb_digitalinvoiceto').find('option:selected').text());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==105)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[14].EMC_DATA.replace('[INVETO]',$('#BTDTL_SEARCH_lb_electricityinvoiceto').find('option:selected').text());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==118)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[14].EMC_DATA.replace('[INVETO]',$('#BTDTL_SEARCH_lb_starhubinvoiceto').find('option:selected').text());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==106)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[16].EMC_DATA.replace('[DGTLVNO]',$('#BTDTL_SEARCH_lb_digitalvoiceno').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==113)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[25].EMC_DATA.replace('[SNO]',$('#BTDTL_SEARCH_lb_starhub_cableserialno').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==119)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[27].EMC_DATA.replace('[SNO]',$('#BTDTL_SEARCH_lb_starhubmodem').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==121)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[23].EMC_DATA.replace('[PWD]',$('#BTDTL_SEARCH_lb_starhubpwd').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==120)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[21].EMC_DATA.replace('[SSID]',$('#BTDTL_SEARCH_lb_starhubssid').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==114)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[55].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubcable_enddate ').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==115)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[56].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubcable_enddate').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==116)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[57].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==117)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[58].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                    else if($('#BTDTL_SEARCH_lb_searchoptions').val()==111)
                    {
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_errorarr[53].EMC_DATA.replace('[SDATE]',$('#BTDTL_SEARCH_db_starhubappl_startdate').val());
                        var BTDTL_SEARCH_error_replace=BTDTL_SEARCH_error_replace.replace('[EDATE]',$('#BTDTL_SEARCH_db_starhubappl_startdate').val());
                        $('#BTDTL_SEARCH_div_errmsg').text(BTDTL_SEARCH_error_replace);
                    }
                }
                //AIRCON SERIVICE
                if(BTDTL_SEARCH_expensetypes==16)
                {
                    for(var j=0;j<BTDTL_SEARCH_response.length;j++)
                    {
                        if(j!=BTDTL_SEARCH_response.length-1)
                        {
                            if($('#BTDTL_SEARCH_lb_searchoptions').val()==100)
                            {
                                BTDTL_SEARCH_tr +='<tr><td id=servicby_'+BTDTL_SEARCH_id[j]+' class="airconserviceedit">'+BTDTL_SEARCH_response[j][0]+'</td><td>'+BTDTL_SEARCH_response[j][1]+'</td><td nowrap>'+BTDTL_SEARCH_response[j][2]+'</td></tr>';
                            }
                            else
                            {

                                if(BTDTL_SEARCH_response[j][2]==null){BTDTL_SEARCH_response[j][2]='';}
                                BTDTL_SEARCH_tr +='<tr><td><div class="col-sm-1"><span  class="glyphicon glyphicon-trash  classdelete"  id="aircondelete_'+BTDTL_SEARCH_id[j]+'"></span></div></td><td style="width:75px">'+BTDTL_SEARCH_response[j][0]+'</td><td id=airconserviceby_'+BTDTL_SEARCH_id[j]+' class="airconserviceedit" style="width:300px">'+BTDTL_SEARCH_response[j][1]+'</td><td id=airconcomments_'+BTDTL_SEARCH_id[j]+' class="airconserviceedit"  style="width:300px">'+BTDTL_SEARCH_response[j][2]+'</td><td  style="width:250px">'+BTDTL_SEARCH_response[j][3]+'</td><td  style="width:130px" nowrap>'+BTDTL_SEARCH_response[j][4]+'</td></tr>';
                            }
                        }
                        else
                        {
                            var BTDTL_SEARCH_parentfunction=BTDTL_SEARCH_response[j];
                            if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_delete')
                            {
                                var BTDTL_SEARCH_errordelete_replace=BTDTL_SEARCH_errorarr[5].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errordelete_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction==0){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[6].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_notupdate'){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[62].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_update')
                            {
                                var BTDTL_SEARCH_errorupdate_replace=BTDTL_SEARCH_errorarr[4].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorupdate_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_aircon_update')
                            {
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[60].EMC_DATA,"success",false);
                            }
                        }
                    }
                    BTDTL_SEARCH_tr +='</tbody></table>';
                }
                // EXPENSE CARPARK
                if(BTDTL_SEARCH_expensetypes==17)
                {
                    for(var j=0;j<BTDTL_SEARCH_response.length;j++)
                    {
                        if(j!=BTDTL_SEARCH_response.length-1)
                        {
                            if(BTDTL_SEARCH_response[j][2]==null){BTDTL_SEARCH_response[j][2]='';}
                            BTDTL_SEARCH_tr +='<tr><td><div class="col-sm-1"><span  class="glyphicon glyphicon-trash  classdelete"  id="carparkdelete_'+BTDTL_SEARCH_id[j]+'"></span></div></td><td>'+BTDTL_SEARCH_response[j][0]+'</td><td id=carno_'+BTDTL_SEARCH_id[j]+' class="carparkedit">'+BTDTL_SEARCH_response[j][1]+'</td><td id=carparkcomments_'+BTDTL_SEARCH_id[j]+' class="carparkedit">'+BTDTL_SEARCH_response[j][2]+'</td><td>'+BTDTL_SEARCH_response[j][3]+'</td><td nowrap>'+BTDTL_SEARCH_response[j][4]+'</td></tr>';
                        }
                        else
                        {
                            var BTDTL_SEARCH_parentfunction=BTDTL_SEARCH_response[j];
                            if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_delete')
                            {
                                var BTDTL_SEARCH_errordelete_replace=BTDTL_SEARCH_errorarr[5].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errordelete_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction==0){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[6].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_notupdate'){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[62].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_update')
                            {
                                var BTDTL_SEARCH_errorupdate_replace=BTDTL_SEARCH_errorarr[4].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorupdate_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_aircon_update')
                            {
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[60].EMC_DATA,"success",false);
                            }
                        }
                    }
                    BTDTL_SEARCH_tr +='</tbody></table>';
                }
                // EXPENSE DIGITAL VOICE
                if(BTDTL_SEARCH_expensetypes==15)
                {
                    for(var j=0;j<BTDTL_SEARCH_response.length;j++)
                    {
                        if(j!=BTDTL_SEARCH_response.length-1)
                        {
                            if(BTDTL_SEARCH_response[j][4]==null){BTDTL_SEARCH_response[j][4]='';}
                            if(BTDTL_SEARCH_response[j][1]==null){BTDTL_SEARCH_response[j][1]='';}
                            BTDTL_SEARCH_tr +='<tr><td><div class="col-sm-1"><span  class="glyphicon glyphicon-trash  classdelete"  id="digitaldelete_'+BTDTL_SEARCH_id[j]+'"></span></div></td><td>'+BTDTL_SEARCH_response[j][0]+'</td><td id=invoiceto_'+BTDTL_SEARCH_id[j]+' class="digitalvoiceedit">'+BTDTL_SEARCH_response[j][1]+'</td><td id=digitalvoiceno_'+BTDTL_SEARCH_id[j]+' class="digitalvoiceedit">'+BTDTL_SEARCH_response[j][2]+'</td><td id=digitalacctno_'+BTDTL_SEARCH_id[j]+' class="digitalvoiceedit">'+BTDTL_SEARCH_response[j][3]+'</td><td id=digitalcomments_'+BTDTL_SEARCH_id[j]+' class="digitalvoiceedit">'+BTDTL_SEARCH_response[j][4]+'</td><td>'+BTDTL_SEARCH_response[j][5]+'</td><td nowrap>'+BTDTL_SEARCH_response[j][6]+'</td></tr>';
                        }
                        else
                        {
                            var BTDTL_SEARCH_parentfunction=BTDTL_SEARCH_response[j];
                            if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_delete')
                            {
                                var BTDTL_SEARCH_errordelete_replace=BTDTL_SEARCH_errorarr[5].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errordelete_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction==0){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[6].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_notupdate'){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[62].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_update')
                            {
                                var BTDTL_SEARCH_errorupdate_replace=BTDTL_SEARCH_errorarr[4].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorupdate_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_aircon_update')
                            {
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[60].EMC_DATA,"success",false);
                            }
                        }
                    }
                    BTDTL_SEARCH_tr +='</tbody></table>';
                }
                // EXPENSE ELECTRICITY
                if(BTDTL_SEARCH_expensetypes==13)
                {
                    for(var j=0;j<BTDTL_SEARCH_response.length;j++)
                    {
                        if(j!=BTDTL_SEARCH_response.length-1)
                        {
                            if(BTDTL_SEARCH_response[j][2]==null){BTDTL_SEARCH_response[j][2]='';}
                            BTDTL_SEARCH_tr +='<tr><td><div class="col-sm-1"><span  class="glyphicon glyphicon-trash  classdelete"  id="electricitydelete_'+BTDTL_SEARCH_id[j]+'"></span></div></td><td>'+BTDTL_SEARCH_response[j][0]+'</td><td id=electinvoiceto_'+BTDTL_SEARCH_id[j]+' class="eletricityedit">'+BTDTL_SEARCH_response[j][1]+'</td><td id=eleccomments_'+BTDTL_SEARCH_id[j]+' class="eletricityedit">'+BTDTL_SEARCH_response[j][2]+'</td><td>'+BTDTL_SEARCH_response[j][3]+'</td><td nowrap>'+BTDTL_SEARCH_response[j][4]+'</td></tr>';
                        }
                        else
                        {
                            var BTDTL_SEARCH_parentfunction=BTDTL_SEARCH_response[j];
                            if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_delete')
                            {
                                var BTDTL_SEARCH_errordelete_replace=BTDTL_SEARCH_errorarr[5].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errordelete_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction==0){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[6].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_notupdate'){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[62].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_update')
                            {
                                var BTDTL_SEARCH_errorupdate_replace=BTDTL_SEARCH_errorarr[4].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorupdate_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_aircon_update')
                            {
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[60].EMC_DATA,"success",false);
                            }
                        }
                    }
                    BTDTL_SEARCH_tr +='</tbody></table>';
                }
                // EXPENSE STARHUB
                if(BTDTL_SEARCH_expensetypes==14)
                {
                    for(var j=0;j<BTDTL_SEARCH_response.length;j++)
                    {
                        if(j!=BTDTL_SEARCH_response.length-1)
                        {
                            if(BTDTL_SEARCH_response[j][1]==null){BTDTL_SEARCH_response[j][1]='';}
                            if(BTDTL_SEARCH_response[j][2]==null){BTDTL_SEARCH_response[j][2]='';}
                            if(BTDTL_SEARCH_response[j][3]==null){BTDTL_SEARCH_response[j][3]='';}
                            if(BTDTL_SEARCH_response[j][4]==null){BTDTL_SEARCH_response[j][4]='';}
                            if(BTDTL_SEARCH_response[j][5]==null){BTDTL_SEARCH_response[j][5]='';}
                            if(BTDTL_SEARCH_response[j][6]==null){BTDTL_SEARCH_response[j][6]='';}
                            if(BTDTL_SEARCH_response[j][7]==null){BTDTL_SEARCH_response[j][7]='';}
                            if(BTDTL_SEARCH_response[j][8]==null){BTDTL_SEARCH_response[j][8]='';}
                            if(BTDTL_SEARCH_response[j][9]==null){BTDTL_SEARCH_response[j][9]='';}
                            if(BTDTL_SEARCH_response[j][10]==null){BTDTL_SEARCH_response[j][10]='';}
                            if(BTDTL_SEARCH_response[j][11]==null){BTDTL_SEARCH_response[j][11]='';}
                            if(BTDTL_SEARCH_response[j][12]==null){BTDTL_SEARCH_response[j][12]='';}
                            if(BTDTL_SEARCH_response[j][13]==null){BTDTL_SEARCH_response[j][13]='';}
                            if(BTDTL_SEARCH_response[j][14]==null){BTDTL_SEARCH_response[j][14]='';}
                            BTDTL_SEARCH_tr +='<tr id='+BTDTL_SEARCH_id[j]+'><td id =icon__'+BTDTL_SEARCH_id[j]+'><div class="col-lg-1"><span id =edit__'+BTDTL_SEARCH_id[j]+' class="glyphicon glyphicon-edit BDTL_starhubeditbtn"></span></div><div class="col-sm-1"><span  class="glyphicon glyphicon-trash  classdelete"  id="starhub^'+BTDTL_SEARCH_id[j]+'"></span></div></td><td id=unitno__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][0]+'</td><td id=invoiceto__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][1]+'</td><td id=acctno__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][2]+'</td><td nowrap id=appldate__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][3]+'</td><td nowrap id=cablestartdate__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][4]+'</td><td nowrap id=cableendate__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][5]+'</td><td nowrap id=internetstartdate__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][6]+'</td><td nowrap id=internetenddate__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][7]+'</td><td id=ssid__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][8]+'</td><td id=pwd__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][9]+'</td><td id=cableboxserialno__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][10]+'</td><td id=modemserialno__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][11]+'</td><td id=basicgroup__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][12]+'</td><td id=addchnnl__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][13]+'</td><td id=comments__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][14]+'</td><td id=userstamp__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][15]+'</td><td nowrap id=timestmap__'+BTDTL_SEARCH_id[j]+'>'+BTDTL_SEARCH_response[j][16]+'</td></tr>';
                        }
                        else
                        {
                            var BTDTL_SEARCH_parentfunction=BTDTL_SEARCH_response[j];
                            if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_delete')
                            {
                                var BTDTL_SEARCH_errordelete_replace=BTDTL_SEARCH_errorarr[5].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errordelete_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction==0){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[6].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_notupdate'){
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[62].EMC_DATA,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_update')
                            {
                                var BTDTL_SEARCH_errorupdate_replace=BTDTL_SEARCH_errorarr[4].EMC_DATA.replace('[TYPE]',$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text());
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorupdate_replace,"success",false);
                            }
                            else if(BTDTL_SEARCH_parentfunction=='BTDTL_SEARCH_flag_aircon_update')
                            {
                                show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[60].EMC_DATA,"success",false);
                            }
                        }
                    }
                    BTDTL_SEARCH_tr +='</tbody></table>';
                }
                $('section').html(BTDTL_SEARCH_tr);
                var oTable=$('#BTDTL_SEARCH_tble_flex').dataTable( {
                    "aaSorting": [],
                    "pageLength": 10,
                    "sPaginationType":"full_numbers",
                    "aoColumnDefs" : [
                        { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ],
                    "sDom":"Rlfrtip"
//                    "scrollX": true,
//                    "sScrollY":  ( 0.6 * $(window).height() ),
//                    "bScrollCollapse": true,
//                    "bAutoWidth": true

                });
                if ( $.browser.webkit ) {
                    setTimeout(function () {
                        oTable.fnAdjustColumnSizing();
                    }, 10);
                }
            }
            sorting();
        }
        //FUNCTION FOR SORTING
        function sorting(){
            jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
                var x = new Date( Date.parse(BDTL_FormTableDateFormat(a)));
                var y = new Date( Date.parse(BDTL_FormTableDateFormat(b)) );
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
                var x = new Date( Date.parse(BDTL_FormTableDateFormat(a)));
                var y = new Date( Date.parse(BDTL_FormTableDateFormat(b)) );
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_timestp-asc']  = function(a,b) {
                var x = new Date( Date.parse(BDTL_FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(BDTL_FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_timestp-desc'] = function(a,b) {
                var x = new Date( Date.parse(BDTL_FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(BDTL_FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
        }
        /*--------------------------------------------------CHANGE FUNCTION VALIDATION FOR SEARCH BUTTON--------------------------------------------------------------*/
        $(document).on('change blur','.BTDTL_SEARCH_class_datesearchbtn',function(){
            if((($('#BTDTL_SEARCH_ta_airconcomments').val()=='')&&($('#BTDTL_SEARCH_ta_airconcomments').val()!=undefined))||
                (($('#BTDTL_SEARCH_ta_carparkcomments').val()=='')&&($('#BTDTL_SEARCH_ta_carparkcomments').val()!=undefined))||
                (($('#BTDTL_SEARCH_ta_digitalcomments').val=='')&&($('#BTDTL_SEARCH_ta_digitalcomments').val()!=undefined))||
                (($('#BTDTL_SEARCH_ta_electricitycomments').val()=='')&&($('#BTDTL_SEARCH_ta_electricitycomments').val()!=undefined))||
                (($('#BTDTL_SEARCH_ta_starhubcomments').val()!='')&&($('#BTDTL_SEARCH_ta_starhubcomments').val()!=undefined))||
                (($('#BTDTL_SEARCH_ta_starhubcomments').val()=='')&&($('#BTDTL_SEARCH_ta_starhubcomments').val()!=undefined))||
                (($('#BTDTL_SEARCH_ta_starhubaddtnlch').val()=='')&&($('#BTDTL_SEARCH_ta_starhubaddtnlch').val()!=undefined))||
                (($('#BTDTL_SEARCH_ta_starhubbasic').val()=='')&&($('#BTDTL_SEARCH_ta_starhubbasic').val()!=undefined))||
                (($('#BTDTL_SEARCH_db_starhubappl_startdate').val()=='')&&($('#BTDTL_SEARCH_db_starhubappl_startdate').val()!=undefined))||
                (($('#BTDTL_SEARCH_db_starhubappl_enddate').val()=='')&&($('#BTDTL_SEARCH_db_starhubappl_enddate').val()!=undefined))||
                (($('#BTDTL_SEARCH_db_starhubcable_startdate').val()=='')&&($('#BTDTL_SEARCH_db_starhubcable_startdate').val()!=undefined))||
                (($('#BTDTL_SEARCH_db_starhubcable_enddate').val()=='')&&($('#BTDTL_SEARCH_db_starhubcable_enddate').val()!=undefined))||
                (($('#BTDTL_SEARCH_db_starhubinternet_startdate').val()=='')&&($('#BTDTL_SEARCH_db_starhubinternet_startdate').val()!=undefined))||
                (($('#BTDTL_SEARCH_db_starhubinternet_enddate').val()=='')&&($('#BTDTL_SEARCH_db_starhubinternet_enddate').val()!=undefined)))
            {
                $('#BTDTL_SEARCH_btn_datesearch').attr("disabled", "disabled")
            }
            else if((($('#BTDTL_SEARCH_db_starhubappl_startdate').val()!='')&&($('#BTDTL_SEARCH_db_starhubappl_startdate').val()!=undefined)&&($('#BTDTL_SEARCH_db_starhubappl_enddate').val()!='')&&($('#BTDTL_SEARCH_db_starhubappl_enddate').val()!=undefined))||(($('#BTDTL_SEARCH_db_starhubcable_startdate').val()!='')&&($('#BTDTL_SEARCH_db_starhubcable_startdate').val()!=undefined)&&($('#BTDTL_SEARCH_db_starhubcable_enddate').val()!='')&&($('#BTDTL_SEARCH_db_starhubcable_enddate').val()!=undefined))||(($('#BTDTL_SEARCH_db_starhubinternet_startdate').val()!='')&&($('#BTDTL_SEARCH_db_starhubinternet_startdate').val()!=undefined)&&($('#BTDTL_SEARCH_db_starhubinternet_enddate').val()!='')&&($('#BTDTL_SEARCH_db_starhubinternet_enddate').val()!=undefined)))
            {
                $('#BTDTL_SEARCH_btn_datesearch').removeAttr("disabled");
            }
        });
//EXPENSE AIRCON INLINE EDIT FUNCTION
        var airconcombineid;
        var airconprevious_id;
        var airconcval;
        var airconifcondition;
        var airconunitid;
        $(document).on('click','.airconserviceedit', function (){
            if(airconprevious_id!=undefined){
                $('#'+airconprevious_id).replaceWith("<td align='left' class='airconserviceedit' id='"+airconprevious_id+"' >"+airconcval+"</td>");
            }
            var cid = $(this).attr('id');
            var id=cid.split('_');
            airconifcondition=id[0];
            airconcombineid=id[1];
            airconunitid=id[2];
            airconprevious_id=cid;
            airconcval = $(this).text();
            if($('#BTDTL_SEARCH_lb_searchoptions').val()==100)
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+airconprevious_id+"'><input type='text' id='ASB_serviceby' name='ASB_serviceby'  class='airconserviceupdate uppercase form-control charonly' maxlength=50 title='ALPHABETS ONLY' style='width: 300px' value='"+airconcval+"'></td>");
                $(".charonly").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
            }
            if(airconifcondition=='airconserviceby')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+airconprevious_id+"'><select class='form-control airconserviceupdate' id='ASB_airconserviceby' style='width: 300px;'></select></td>");
                var airconserviceby='<option value="SELECT">SELECT</option>';
                for (var i = 0; i < airconservicebyarray.BTDTL_SEARCH_obj_id.length; i++) {
                    if(airconservicebyarray.BTDTL_SEARCH_obj_data[i]==airconcval)
                    {
                        var categorysindex=i;
                    }
                    airconserviceby += '<option value="' + airconservicebyarray.BTDTL_SEARCH_obj_id[i]+ '">' + airconservicebyarray.BTDTL_SEARCH_obj_data[i]+ '</option>';
                }
                $('#ASB_airconserviceby').html(airconserviceby)
                $('#ASB_airconserviceby').prop('selectedIndex',categorysindex+1);
            }
            if(airconifcondition=='airconcomments')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+airconprevious_id+"'><textarea rows='3' id='ASB_comments' name='ASB_comments'  class='airconserviceupdate form-control' style='width: 330px;height:100px;'>"+airconcval+"</textarea></td>");
            }
        });
//AIRCON SERVICE UPDATE PART
        $(document).on('change','.airconserviceupdate', function (evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $('.preloader').show();
            if($('#airconserviceby_'+airconcombineid+'_'+airconunitid).hasClass("airconserviceedit")==true){

                var airconserviceby=$('#airconserviceby_'+airconcombineid+'_'+airconunitid).text();
            }
            else{
                var airconserviceby=$('#ASB_airconserviceby').find('option:selected').text();
            }
            if($('#airconcomments_'+airconcombineid+'_'+airconunitid).hasClass("airconserviceedit")==true){

                var aircomments=$('#airconcomments_'+airconcombineid+'_'+airconunitid).text();
            }
            else{
                var aircomments=$('#ASB_comments').val();
            }
            if($('#BTDTL_SEARCH_lb_searchoptions').val()==100)
            {
                var serviceby=($('#ASB_serviceby').val()).toUpperCase();
                $('#ASB_serviceby').val(serviceby);
            }
            // SEARCH BY OPTIONS VALUE
            if($('#BTDTL_SEARCH_lb_searchoptions').val()==195)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_ariconservicedbyunitno').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==101)
            {
                var searchvalue=$('#BTDTL_SEARCH_ta_airconcomments').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_ariconunitno').val();
            }
            $.ajax({
                type: "POST",
                url: controller_url+"airconserviceupdate",
                data:{'primaryid':airconcombineid,'unitid':airconunitid,'airconserviceby':airconserviceby,'aircomments':aircomments,'serviceby':serviceby,'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_lb_expense_type':$('#BTDTL_SEARCH_lb_expense_type').val(),'searchvalue':searchvalue},
                success: function(data) {
                    $('.preloader').hide();
                    var result=JSON.parse(data)
                    BTDTL_SEARCH_success_showflex(result);
                    airconprevious_id=undefined;
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }) ;
        //EXPENSE CARPARK INLINE EDIT FUNCTION
        var carparkcombineid;
        var carparkprevious_id;
        var carparkcval;
        var carparkifcondition;
        var carparkunitid;
        $(document).on('click','.carparkedit', function (){
            if(carparkprevious_id!=undefined){
                $('#'+carparkprevious_id).replaceWith("<td align='left' class='carparkedit' id='"+carparkprevious_id+"' >"+carparkcval+"</td>");
            }
            var cid = $(this).attr('id');
            var id=cid.split('_');
            carparkifcondition=id[0];
            carparkcombineid=id[1];
            carparkunitid=id[2];
            carparkprevious_id=cid;
            carparkcval = $(this).text();
            if(carparkifcondition=='carno')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+carparkprevious_id+"'><input type='text' class='form-control carparkupdate alphanumeric' id='CP_carno' maxlength='9' value='"+carparkcval+"'></td>");
            }
            else if(carparkifcondition=='carparkcomments')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+carparkprevious_id+"'><textarea rows='3' id='CP_comments' name='CP_comments'  class='carparkupdate form-control' style='width: 330px;height:100px;'>"+carparkcval+"</textarea></td>");
            }
            $(".alphanumeric").doValidation({rule:'alphanumeric'});
        });
//CARPARK UPDATE PART
        $(document).on('change','.carparkupdate', function (evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $('.preloader').show();
            if($('#carno_'+carparkcombineid+'_'+carparkunitid).hasClass("carparkedit")==true){

                var carno=$('#carno_'+carparkcombineid+'_'+carparkunitid).text();
            }
            else{
                var carno=($('#CP_carno').val()).toUpperCase();
                $('#CP_carno').val(carno);
            }
            if($('#carparkcomments_'+carparkcombineid+'_'+carparkunitid).hasClass("carparkedit")==true){

                var carparkcomments=$('#carparkcomments_'+carparkcombineid+'_'+carparkunitid).text();
            }
            else{
                var carparkcomments=$('#CP_comments').val();
            }

            // SEARCH BY OPTIONS VALUE
            if($('#BTDTL_SEARCH_lb_searchoptions').val()==102)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_carno').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==103)
            {
                var searchvalue=$('#BTDTL_SEARCH_ta_carparkcomments').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_carparkunitno').val();
            }
            $.ajax({
                type: "POST",
                url: controller_url+"carparkupdate",
                data:{'primaryid':carparkcombineid,'unitid':carparkunitid,'carno':carno,'carparkcomments':carparkcomments,'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_lb_expense_type':$('#BTDTL_SEARCH_lb_expense_type').val(),'searchvalue':searchvalue},
                success: function(data) {
                    $('.preloader').hide();
                    var result=JSON.parse(data)
                    BTDTL_SEARCH_success_showflex(result);
                    carparkprevious_id=undefined;
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }) ;
        //EXPENSE DIGITAL INLINE EDIT FUNCTION
        var digitalcombineid;
        var digitalprevious_id;
        var digitalcval;
        var digitalifcondition;
        var digitalunitid;
        $(document).on('click','.digitalvoiceedit', function (){
            if(digitalprevious_id!=undefined){
                $('#'+digitalprevious_id).replaceWith("<td align='left' class='digitalvoiceedit' id='"+digitalprevious_id+"' >"+digitalcval+"</td>");
            }
            var cid = $(this).attr('id');
            var id=cid.split('_');
            digitalifcondition=id[0];
            digitalcombineid=id[1];
            digitalunitid=id[2];
            digitalprevious_id=cid;
            digitalcval = $(this).text();
            if(digitalifcondition=='invoiceto')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+digitalprevious_id+"'><select class='form-control digitalupdate' id='DV_invoiceto' style='width: 150px;'></select></td>");
                var BTDTL_SEARCH_options_invoiceto_upd='<option value="">SELECT</option>';
                for (var i = 0; i <BTDTL_SEARCH_arr_invoicto.length; i++) {
                    if(BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data==digitalcval){
                        BTDTL_SEARCH_options_invoiceto_upd +='<option value="'+BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_id +'" selected>' + BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data + '</option>';
                    }else
                        BTDTL_SEARCH_options_invoiceto_upd +='<option value="'+BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_id +'">' + BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data + '</option>';
                }
                $('#DV_invoiceto').html(BTDTL_SEARCH_options_invoiceto_upd)
            }
            else if(digitalifcondition=='digitalvoiceno')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+digitalprevious_id+"'><input type='text' class='form-control numbersonly digitalupdate' id='DV_invoiceno' maxlength='8' value='"+digitalcval+"'></td>");
            }
            else if(digitalifcondition=='digitalacctno')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+digitalprevious_id+"'><input type='text' class='form-control alphanumericdot digitalupdate' maxlength='11' id='DV_acctno' value='"+digitalcval+"'></td>");
            }
            else if(digitalifcondition=='digitalcomments')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+digitalprevious_id+"'><textarea rows='3' id='DV_comments' name='DV_comments'  class='digitalupdate form-control' style='width: 330px;height:100px;'>"+digitalcval+"</textarea></td>");
            }
            $(".alphanumericdot").doValidation({rule:'alphanumeric',prop:{allowdot:true}});
            $(".numbersonly").doValidation({rule:'numbersonly',prop:{realpart:8},leadzero:true});
        });
//DIGITAL VOICE UPDATE PART
        $(document).on('change','.digitalupdate', function (evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $('.preloader').show();
            if($('#invoiceto_'+digitalcombineid+'_'+digitalunitid).hasClass("digitalvoiceedit")==true){

                var invoiceto=$('#invoiceto_'+digitalcombineid+'_'+digitalunitid).text();
            }
            else{
                var invoiceto=$('#DV_invoiceto').find('option:selected').text();
            }
            if($('#digitalvoiceno_'+digitalcombineid+'_'+digitalunitid).hasClass("digitalvoiceedit")==true){

                var invoiceno=$('#digitalvoiceno_'+digitalcombineid+'_'+digitalunitid).text();
            }
            else{
                var invoiceno=$('#DV_invoiceno').val();
            }
            if($('#digitalacctno_'+digitalcombineid+'_'+digitalunitid).hasClass("digitalvoiceedit")==true){

                var acctno=$('#digitalacctno_'+digitalcombineid+'_'+digitalunitid).text();
            }
            else{
                var acctno=$('#DV_acctno').val();
            }
            if($('#digitalcomments_'+digitalcombineid+'_'+digitalunitid).hasClass("digitalvoiceedit")==true){

                var comments=$('#digitalcomments_'+digitalcombineid+'_'+digitalunitid).text();
            }
            else{
                var comments=$('#DV_comments').val();
            }

            // SEARCH BY OPTIONS VALUE
            if($('#BTDTL_SEARCH_lb_searchoptions').val()==109)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_digitalacctno').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==108)
            {
                var searchvalue=$('#BTDTL_SEARCH_ta_digitalcomments').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==106)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_digitalvoiceno').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==107)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_digitalinvoiceto').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_digitalunitno').val();
            }
            $.ajax({
                type: "POST",
                url: controller_url+"digitalvoiceupdate",
                data:{'primaryid':digitalcombineid,'unitid':digitalunitid,'invoiceto':invoiceto,'invoiceno':invoiceno,'acctno':acctno,'comments':comments,'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_lb_expense_type':$('#BTDTL_SEARCH_lb_expense_type').val(),'searchvalue':searchvalue},
                success: function(data) {
                    $('.preloader').hide();
                    var result=JSON.parse(data)
                    BTDTL_SEARCH_success_showflex(result);
                    digitalprevious_id=undefined;
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }) ;
        //EXPENSE CARPARK INLINE EDIT FUNCTION
        var electriccombineid;
        var electricprevious_id;
        var electriccval;
        var electricifcondition;
        var electricunitid;
        $(document).on('click','.eletricityedit', function (){
            if(electricprevious_id!=undefined){
                $('#'+electricprevious_id).replaceWith("<td align='left' class='eletricityedit' id='"+electricprevious_id+"' >"+electriccval+"</td>");
            }
            var cid = $(this).attr('id');
            var id=cid.split('_');
            electricifcondition=id[0];
            electriccombineid=id[1];
            electricunitid=id[2];
            electricprevious_id=cid;
            electriccval = $(this).text();
            if(electricifcondition=='electinvoiceto')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+electricprevious_id+"'><select class='form-control electricityupdate' id='ELEC_invoiceto' style='width: 150px;'></select></td>");
                var BTDTL_SEARCH_options_invoiceto_upd='<option value="">SELECT</option>';
                for (var i = 0; i <BTDTL_SEARCH_arr_invoicto.length; i++) {
                    if(BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data==electriccval){
                        BTDTL_SEARCH_options_invoiceto_upd +='<option value="'+BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_id +'" selected>' + BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data + '</option>';
                    }else
                        BTDTL_SEARCH_options_invoiceto_upd +='<option value="'+BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_id +'">' + BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data + '</option>';
                }
                $('#ELEC_invoiceto').html(BTDTL_SEARCH_options_invoiceto_upd)
            }
            else if(electricifcondition=='eleccomments')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+electricprevious_id+"'><textarea rows='3' id='ELEC_comments' name='ELEC_comments'  class='electricityupdate form-control' style='width: 330px;height:100px;'>"+electriccval+"</textarea></td>");
            }
        });
//ELECTRICITY UPDATE PART
        $(document).on('change','.electricityupdate', function (evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $('.preloader').show();
            if($('#electinvoiceto_'+electriccombineid+'_'+electricunitid).hasClass("eletricityedit")==true){

                var invoiceto=$('#electinvoiceto_'+electriccombineid+'_'+electricunitid).text();
            }
            else{
                var invoiceto=$('#ELEC_invoiceto').find('option:selected').text();
            }
            if($('#eleccomments_'+electriccombineid+'_'+electricunitid).hasClass("eletricityedit")==true){

                var electcomments=$('#eleccomments_'+electriccombineid+'_'+electricunitid).text();
            }
            else{
                var electcomments=$('#ELEC_comments').val();
            }

            // SEARCH BY OPTIONS VALUE
            if($('#BTDTL_SEARCH_lb_searchoptions').val()==104)
            {
                var searchvalue=$('#BTDTL_SEARCH_ta_electricitycomments').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==105)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_electricityinvoiceto').val();
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
            {
                var searchvalue=$('#BTDTL_SEARCH_lb_electricityunitno').val();
            }
            $.ajax({
                type: "POST",
                url: controller_url+"electricityupdate",
                data:{'primaryid':electriccombineid,'unitid':electricunitid,'invoiceto':invoiceto,'electcomments':electcomments,'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_lb_expense_type':$('#BTDTL_SEARCH_lb_expense_type').val(),'searchvalue':searchvalue},
                success: function(data) {
                    $('.preloader').hide();
                    var result=JSON.parse(data)
                    BTDTL_SEARCH_success_showflex(result);
                    electricprevious_id=undefined;
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }) ;
        //STARHUB INLINE EDIT
        var pre_tds;
        var selectedrowid;
        var unitid;
        var primaryid;
        var arrayvalues;
        var arr;
        var tds;
        $(document).on('click','.BDTL_starhubeditbtn', function (){
            var cid = $(this).attr('id');
            var SplittedData=cid.split('__');
            var Rowid=SplittedData[1];
            tds = $('#'+Rowid).children('td');
            selectedrowid=Rowid;
            pre_tds = tds;
            var tdstr = '';
            var edit="Editid__"+Rowid;
            var cancel="Cancelid__"+Rowid;
            arrayvalues={"icon":[$('#icon__'+Rowid).html()], "unitno":[$('#unitno__'+Rowid).html()],"invoiceto":[$('#invoiceto__'+Rowid).html()],
                "acctno":[$('#acctno__'+Rowid).html()],"appldate":[$('#appldate__'+Rowid).html()],
                "cablestartdate":[$('#cablestartdate__'+Rowid).html()],"cableendate":[$('#cableendate__'+Rowid).html()],
                "internetstartdate":[$('#internetstartdate__'+Rowid).html()],"internetenddate":[$('#internetenddate__'+Rowid).html()],
                "ssid":[$('#ssid__'+Rowid).html()],"pwd":[$('#pwd__'+Rowid).html()],"cableboxserialno":[$('#cableboxserialno__'+Rowid).html()],
                "modemserialno":[$('#modemserialno__'+Rowid).html()],"basicgroup":[$('#basicgroup__'+Rowid).html()],"addchnnl":[$('#addchnnl__'+Rowid).html()],"comments":[$('#comments__'+Rowid).html()],
                "userstamp":[$('#userstamp__'+Rowid).html()],"timestmap":[$('#timestmap__'+Rowid).html()]}

            arr={"icon":["<div class='col-lg-1'><span style='display: block;color:green' title='Update' class='glyphicon glyphicon-print BDTL_starhubupdatebutton' disabled id="+edit+"></div><div class='col-lg-1'><span style='display: block;color:red' title='Cancel' class='glyphicon glyphicon-remove BDTL_starhubcancel' disabled id="+cancel+"></div>"],
                "unitno":[$('#unitno__'+Rowid).html()],
                "invoiceto":["<SELECT id='SH_invoiceto' name='SH_invoiceto'  class='BDTL_INPUT_class_update_valid form-control'  style='width: 150px;' value='"+$('#invoiceto__'+Rowid).html()+"'><OPTION>SELECT</OPTION></SELECT>"],
                "acctno":["<input type='text' id='SH_acctno' name='SH_acctno'  maxlength='11' style='width: 120px;' class='alphanumericdot BDTL_INPUT_class_update_valid form-control'  value='"+$('#acctno__'+Rowid).html()+"'>"],
                "appldate":["<input type='text' id='SH_appldate' name='SH_appldate' style='width: 110px;' class='BDTL_INPUT_class_datebox BDTL_INPUT_class_update_valid datenonmandtry form-control' value='"+$('#appldate__'+Rowid).html()+"'>"],
                "cablestartdate":["<input type='text' id='SH_cablestartdate' name='SH_cablestartdate' style='width: 110px;' class='BDTL_INPUT_class_datebox BDTL_INPUT_class_update_valid datenonmandtry form-control' value='"+$('#cablestartdate__'+Rowid).html()+"'>"],
                "cableendate":["<input type='text' id='SH_cableenddate' name='SH_cableenddate' style='width: 110px;' class='BDTL_INPUT_class_datebox BDTL_INPUT_class_update_valid BDTL_INPUT_dateInput datenonmandtry form-control' value='"+$('#cableendate__'+Rowid).html()+"'>"],
                "internetstartdate":["<input type='text' id='SH_internetstartdate' name='SH_internetstartdate' style='width: 110px;' class='BDTL_INPUT_class_internet_datebox BDTL_INPUT_class_update_valid datenonmandtry form-control' value='"+$('#internetstartdate__'+Rowid).html()+"'>"],
                "internetenddate":["<input type='text' id='SH_internetenddate' name='SH_internetenddate' style='width: 110px;' class='BDTL_INPUT_class_internet_datebox BDTL_INPUT_class_update_valid BDTL_INPUT_dateInput datenonmandtry form-control' value='"+$('#internetenddate__'+Rowid).html()+"'>"],
                "ssid":["<input type='text' id='SH_ssid' name='SH_ssid'  class='general BDTL_INPUT_class_update_valid form-control' style='width:100px;' value='"+$('#ssid__'+Rowid).html()+"'>"],
                "pwd":["<input type='text' id='SH_pwd' name='SH_pwd'  class='general BDTL_INPUT_class_update_valid form-control' style='width:100px;' value='"+$('#pwd__'+Rowid).html()+"'>"],
                "cableboxserialno":["<input type='text' id='SH_cablebox' name='SH_cablebox'  class='autosize BDTL_INPUT_class_update_valid form-control'  style='width:140px;' value='"+$('#cableboxserialno__'+Rowid).html()+"'>"],
                "modemserialno":["<input type='text' id='SH_modem' name='SH_modem'  class='autosize BDTL_INPUT_class_update_valid form-control'  style='width:140px;' value='"+$('#modemserialno__'+Rowid).html()+"'>"],
                "basicgroup":["<textarea id='SH_basicgroup' name='SH_basicgroup'  class='BDTL_INPUT_class_update_valid BDTL_INPUT_comments form-control'  style='width:130px;'>"+$('#basicgroup__'+Rowid).html()+"</textarea>"],
                "addchnnl":["<textarea id='SH_addchnl' name='SH_addchnl'  class='BDTL_INPUT_class_update_valid BDTL_INPUT_comments form-control'  style='width:150px;'>"+$('#addchnnl__'+Rowid).html()+"</textarea></td>"],
                "comments":["<textarea id='SH_comments' name='SH_comments'  class='BDTL_INPUT_class_update_valid BDTL_INPUT_comments form-control'  style='width:150px;'>"+$('#comments__'+Rowid).html()+"</textarea>"],
                "userstamp":[$('#userstamp__'+Rowid).html()],
                "timestmap":[$('#timestmap__'+Rowid).html()]}
            for(var t=0;t<tds.length;t++){
                $(tds[t]).html(arr[$(tds[t]).attr('id').split('__')[0]][0]);
            }
            tdstr += "<td><div class='col-lg-1'><span style='display: block;color:green' title='Update' class='glyphicon glyphicon-print BDTL_starhubupdatebutton' disabled id="+edit+"></div><div class='col-lg-1'><span style='display: block;color:red' title='Cancel' class='glyphicon glyphicon-remove BDTL_starhubcancel' disabled id="+cancel+"></div></td>";
            tdstr += "<td>"+$(tds[1]).html()+"</td>";
            tdstr += "<td><SELECT id='SH_invoiceto' name='SH_invoiceto'  class='BDTL_INPUT_class_update_valid form-control'  style='width: 150px;' value='"+$(tds[2]).html()+"'><OPTION>SELECT</OPTION></SELECT></td>";
            tdstr += "<td><input type='text' id='SH_acctno' name='SH_acctno'  maxlength='11' style='width: 100px;' class='alphanumericdot BDTL_INPUT_class_update_valid form-control'  value='"+$(tds[3]).html()+"'></td>";
            tdstr += "<td><input type='text' id='SH_appldate' name='SH_appldate' style='width: 110px;' class='BDTL_INPUT_class_datebox BDTL_INPUT_class_update_valid datenonmandtry form-control' value='"+$(tds[4]).html()+"'></td>";
            tdstr += "<td><input type='text' id='SH_cablestartdate' name='SH_cablestartdate' style='width: 110px;' class='BDTL_INPUT_class_datebox BDTL_INPUT_class_update_valid datenonmandtry form-control' value='"+$(tds[5]).html()+"'></td>";
            tdstr += "<td><input type='text' id='SH_cableenddate' name='SH_cableenddate' style='width: 110px;' class='BDTL_INPUT_class_datebox BDTL_INPUT_class_update_valid BDTL_INPUT_dateInput datenonmandtry form-control' value='"+$(tds[6]).html()+"'></td>";
            tdstr += "<td><input type='text' id='SH_internetstartdate' name='SH_internetstartdate' style='width: 110px;' class='BDTL_INPUT_class_internet_datebox BDTL_INPUT_class_update_valid datenonmandtry form-control' value='"+$(tds[7]).html()+"'></td>";
            tdstr += "<td><input type='text' id='SH_internetenddate' name='SH_internetenddate' style='width: 110px;' class='BDTL_INPUT_class_internet_datebox BDTL_INPUT_class_update_valid BDTL_INPUT_dateInput datenonmandtry form-control' value='"+$(tds[8]).html()+"'></td>";
            tdstr += "<td><input type='text' id='SH_ssid' name='SH_ssid'  class='general BDTL_INPUT_class_update_valid form-control' value='"+$(tds[9]).html()+"'></td>";
            tdstr += "<td><input type='text' id='SH_pwd' name='SH_pwd'  class='general BDTL_INPUT_class_update_valid form-control' value='"+$(tds[10]).html()+"'></td>";
            tdstr += "<td><input type='text' id='SH_cablebox' name='SH_cablebox'  class='autosize BDTL_INPUT_class_update_valid form-control' value='"+$(tds[11]).html()+"'></td>";
            tdstr += "<td><input type='text' id='SH_modem' name='SH_modem'  class='autosize BDTL_INPUT_class_update_valid form-control' value='"+$(tds[12]).html()+"'></td>";
            tdstr += "<td><textarea id='SH_basicgroup' name='SH_basicgroup'  class='BDTL_INPUT_class_update_valid BDTL_INPUT_comments form-control'>"+$(tds[13]).html()+"</textarea></td>";
            tdstr += "<td><textarea id='SH_addchnl' name='SH_addchnl'  class='BDTL_INPUT_class_update_valid BDTL_INPUT_comments form-control'>"+$(tds[14]).html()+"</textarea></td>";
            tdstr += "<td><textarea id='SH_comments' name='SH_comments'  class='BDTL_INPUT_class_update_valid BDTL_INPUT_comments form-control'>"+$(tds[15]).html()+"</textarea></td>";
            tdstr += "<td>"+$(tds[16]).html()+"</td>";
            tdstr += "<td>"+$(tds[17]).html()+"</td>";
//            $('#'+Rowid).html(tdstr);
            var BTDTL_SEARCH_options_invoiceto_upd='<option value="">SELECT</option>';
            for (var i = 0; i <BTDTL_SEARCH_arr_invoicto.length; i++) {
                if(BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data==arrayvalues["invoiceto"][0]){
                    BTDTL_SEARCH_options_invoiceto_upd +='<option value="'+BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_id +'" selected>' + BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data + '</option>';
                }else
                    BTDTL_SEARCH_options_invoiceto_upd +='<option value="'+BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_id +'">' + BTDTL_SEARCH_arr_invoicto[i].BTDTL_SEARCH_expensetypes_data + '</option>';
            }
            $('#SH_invoiceto').html(BTDTL_SEARCH_options_invoiceto_upd);
            BTDTL_SEARCH_obj={"BTDTL_invoiceto":arrayvalues["invoiceto"][0],"BTDTL_acctno":arrayvalues["acctno"][0],"BTDTL_appldate":arrayvalues["appldate"][0],"BTDTL_cablestartdate":arrayvalues["cablestartdate"][0],"BTDTL_cableenddate":arrayvalues["cableendate"][0],"BTDTL_internetsd":arrayvalues["internetstartdate"][0],"BTDTL_interneted":arrayvalues["internetenddate"][0],"BTDTL_ssid":arrayvalues["ssid"][0],"BTDTL_pwd":arrayvalues["pwd"][0],"BTDTL_cablebox":arrayvalues["cableboxserialno"][0],"BTDTL_modem":arrayvalues["modemserialno"][0],"BTDTL_basicgroup":arrayvalues["basicgroup"][0],"BTDTL_addchhnl":arrayvalues["addchnnl"][0],"BTDTL_comments":arrayvalues["comments"][0]}

            /*-----------------------------------------VALIDATION FOR CHARACTER,NUMBERS AND ALPHA NUMERIC--------------------------------------------------------*/
            $('textarea').autogrow({onInitialize: true});
            $(".charonly").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
            $(".alphanumeric").doValidation({rule:'alphanumeric'});
            $(".alphanumericdot").doValidation({rule:'alphanumeric',prop:{allowdot:true}});
            $(".numbersonly").doValidation({rule:'numbersonly',prop:{realpart:8},leadzero:true});
            $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
            $("input.autosize").autoGrowInput();
            $(".general").doValidation({rule:'general',prop:{uppercase:false,autosize:true}});
            $("#SH_appldate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
            $(".BDTL_INPUT_comments").doValidation({rule:'general',prop:{uppercase:false}});
            /*--------------------------------------DATE VALIDATION FOR CABLE,INTERNET START DATE & END DATE------------------------*/
            $("#SH_cableenddate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
            $("#SH_internetenddate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
            $("#SH_cablestartdate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,
                onSelect: function(date){
                    if((parseInt($('#SH_acctno').val())==0)||($('#SH_acctno').val()=='')||(($('#SH_cablestartdate').val()=='')&&($('#SH_cableenddate').val()!=''))||(($('#SH_cablestartdate').val()!='')&&($('#SH_cableenddate').val()==''))||(($('#SH_internetstartdate').val()=='')&&($('#SH_internetenddate').val()!=''))||(($('#SH_internetstartdate').val()!='')&&($('#SH_internetenddate').val()=='')))
                        $('.BDTL_starhubupdatebutton').removeClass('BDTL_starhubupdatebutton').addClass('Checkvalidation');
                    else
                        $('.Checkvalidation').removeClass('Checkvalidation').addClass('BDTL_starhubupdatebutton')
                    var BDTL_startdate = new Date( Date.parse( BDTL_FormTableDateFormat( $('#SH_cablestartdate').val())) );
                    BDTL_startdate.setDate( BDTL_startdate.getDate());
                    var BDTL_newsDate = BDTL_startdate.toDateString();
                    BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
                    $('#SH_cableenddate').datepicker("option","minDate",BDTL_newsDate);
                }});
            $("#SH_internetstartdate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,
                onSelect: function(date){
                    if((parseInt($('#SH_acctno').val())==0)||($('#SH_acctno').val()=='')||(($('#SH_cablestartdate').val()=='')&&($('#SH_cableenddate').val()!=''))||(($('#SH_cablestartdate').val()!='')&&($('#SH_cableenddate').val()==''))||(($('#SH_internetstartdate').val()=='')&&($('#SH_internetenddate').val()!=''))||(($('#SH_internetstartdate').val()!='')&&($('#SH_internetenddate').val()=='')))
                        $('.BDTL_starhubupdatebutton').removeClass('BDTL_starhubupdatebutton').addClass('Checkvalidation');
                    else
                        $('.Checkvalidation').removeClass('Checkvalidation').addClass('BDTL_starhubupdatebutton')
                    var BDTL_startdate = new Date( Date.parse( BDTL_FormTableDateFormat( $('#SH_internetstartdate').val())) );
                    BDTL_startdate.setDate( BDTL_startdate.getDate());
                    var BDTL_newsDate = BDTL_startdate.toDateString();
                    BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
                    $('#SH_internetenddate').datepicker("option","minDate",BDTL_newsDate);
                }});
            var BTDTL_SEARCH_cable_sdate=arrayvalues["cablestartdate"][0];
            if(BTDTL_SEARCH_cable_sdate!='')
            {
                var BTDTL_SEARCH_appl_startdate = DatePickerFormat(BTDTL_SEARCH_cable_sdate);
                var BTDTL_SEARCH_appl_date = new Date( Date.parse( BTDTL_SEARCH_appl_startdate) );
                BTDTL_SEARCH_appl_date.setDate( BTDTL_SEARCH_appl_date.getDate());
                var newDate = BTDTL_SEARCH_appl_date.toDateString();
                newDate = new Date( Date.parse( newDate ) );
                $('#SH_cableenddate').datepicker("option","minDate",newDate);
            }
            var BTDTL_SEARCH_internet_sdate=arrayvalues["internetstartdate"][0];
            if(BTDTL_SEARCH_internet_sdate!='')
            {
                var BTDTL_SEARCH_internet_startdate = DatePickerFormat(BTDTL_SEARCH_internet_sdate);
                var BTDTL_SEARCH_internet_start = new Date( Date.parse( BTDTL_SEARCH_internet_startdate) );
                BTDTL_SEARCH_internet_start.setDate( BTDTL_SEARCH_internet_start.getDate());
                var newDate = BTDTL_SEARCH_internet_start.toDateString();
                newDate = new Date( Date.parse( newDate ) );
                $('#SH_internetenddate').datepicker("option","minDate",newDate);
            }
            var splitunitidsded=cid.split('__');
            primaryid=splitunitidsded[1].split('_')[0];
            unitid=splitunitidsded[1].split('_')[1];
            sdate=splitunitidsded[1].split('_')[2]
            edate=splitunitidsded[1].split('_')[3]
            var sdate_unit = new Date( Date.parse( sdate) );
            sdate_unit.setDate( sdate_unit.getDate() );
            var sdate_unit_new = sdate_unit.toDateString();
            sdate_unit_new = new Date( Date.parse( sdate_unit_new ) );
            $('#SH_appldate,#SH_cablestartdate,#SH_internetstartdate').datepicker("option","minDate",sdate_unit_new);
            var BTDTL_SEARCH_cable_edate=$(tds[6]).html();
            if(BTDTL_SEARCH_cable_edate=='')
                $('#SH_cableenddate').datepicker("option","minDate",sdate_unit_new);
            var BTDTL_SEARCH_internet_edate=$(tds[8]).html();
            if(BTDTL_SEARCH_internet_edate=='')
                $('#SH_internetenddate').datepicker("option","minDate",sdate_unit_new);
            BDLY_INPUT_func_enddate();
            $('.BDTL_starhubeditbtn').removeClass('BDTL_starhubeditbtn').addClass('Editremove');
            $('.classdelete').removeClass('classdelete').addClass('Deleteremove');

        });
        /*------------------------------------FUNCTION FOR DATE PICKER VALIDATION--------------------------*/
        function BDLY_INPUT_func_enddate(){
            var BDLY_INPUT_enddate=new Date(Date.parse( edate));
            var BIZDLY_SRC_chkoutdate=BDLY_INPUT_enddate.getDate();
            var BIZDLY_SRC_chkoutmonth=BDLY_INPUT_enddate.getMonth()+parseInt(BTDTL_SEARCH_configmon_aircon[0]);
            var BIZDLY_SRC_chkoutyear=BDLY_INPUT_enddate.getFullYear();
            var BDLY_INPUT_enddate_unit = new Date(BIZDLY_SRC_chkoutyear,BIZDLY_SRC_chkoutmonth,BIZDLY_SRC_chkoutdate);
            if(BDLY_INPUT_enddate_unit.setHours(0,0,0,0)<=new Date().setHours(0,0,0,0))
            {
                var BDLY_INPUT_unit_end_date=BDLY_INPUT_enddate_unit;
            }
            else{
                var BDLY_INPUT_unit_end_date=new Date();
            }
            $('#SH_appldate,#SH_cablestartdate,#SH_internetstartdate').datepicker("option","maxDate",BDLY_INPUT_unit_end_date);
            $('#SH_cableenddate,#SH_internetenddate').datepicker("option","maxDate",BDLY_INPUT_enddate_unit);
        }
        $('section').on('click','.BDTL_starhubcancel',function(){
            var cid = $(this).attr('id');
            var SplittedData=cid.split('__');
            var Rowid=SplittedData[1];
            for(var t=0;t<tds.length;t++){
                $(tds[t]).html(arrayvalues[$(tds[t]).attr('id').split('_')[0]][0]);
            }
            $("#Editid_"+Rowid).removeClass("BDTL_starhubcancel");
            $('.Editremove').addClass('BDTL_starhubeditbtn');
            $('.Deleteremove').removeClass('Deleteremove').addClass('classdelete');
        });
        $(document).on('change blur','.BDTL_INPUT_class_update_valid', function (){
            if((($('#SH_acctno').val()=='')&&($('#SH_acctno').val()!=undefined))||(($('#SH_acctno').val()!=undefined)&&($('#SH_invoiceto').find('option:selected').text()==BTDTL_SEARCH_obj.BTDTL_invoiceto)&&(($('#SH_acctno').val()).trim()==BTDTL_SEARCH_obj.BTDTL_acctno)&&($('#SH_appldate').val()==BTDTL_SEARCH_obj.BTDTL_appldate)&&($('#SH_cablestartdate').val()==BTDTL_SEARCH_obj.BTDTL_cablestartdate)&&($('#SH_cableenddate').val()==BTDTL_SEARCH_obj.BTDTL_cableenddate)&&($('#SH_internetstartdate').val()==BTDTL_SEARCH_obj.BTDTL_internetsd)&&($('#SH_internetenddate').val()==BTDTL_SEARCH_obj.BTDTL_interneted)&&(($('#SH_ssid').val()).trim()==BTDTL_SEARCH_obj.BTDTL_ssid)&&(($('#SH_pwd').val()).trim()==BTDTL_SEARCH_obj.BTDTL_pwd)&&(($('#SH_cablebox').val()).trim()==BTDTL_SEARCH_obj.BTDTL_cablebox)&&(($('#SH_modem').val()).trim()==BTDTL_SEARCH_obj.BTDTL_modem)&&(($('#SH_basicgroup').val()).trim()==BTDTL_SEARCH_obj.BTDTL_basicgroup)&&(($('#SH_addchnl').val()).trim()==BTDTL_SEARCH_obj.BTDTL_addchhnl)&&(($('#SH_comments').val()).trim()==BTDTL_SEARCH_obj.BTDTL_comments))||(($('#SH_cablestartdate').val()=='')&&($('#SH_cableenddate').val()!=''))||(($('#SH_cablestartdate').val()!='')&&($('#SH_cableenddate').val()==''))||(($('#SH_internetstartdate').val()=='')&&($('#SH_internetenddate').val()!=''))||(($('#SH_internetstartdate').val()!='')&&($('#SH_internetenddate').val()=='')))
            {
                $('.BDTL_starhubupdatebutton').removeClass('BDTL_starhubupdatebutton').addClass('Checkvalidation');
            }
            else
            {
                $('.Checkvalidation').removeClass('Checkvalidation').addClass('BDTL_starhubupdatebutton');
            }
        });

        //STARHUB UPDATE PART
        $(document).on('click','.BDTL_starhubupdatebutton', function (evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $('.preloader').show();
            var acctno=$('#SH_acctno').val();
            var unitno=$(pre_tds[1]).html();
            var invoiceto=$('#SH_invoiceto').val();
            var appldate=$('#SH_appldate').val();
            var cablestartdte=$('#SH_cablestartdate').val();
            var cableenddate=$('#SH_cableenddate').val();
            var internetstartdte=$('#SH_internetstartdate').val();
            var internetenddate=$('#SH_internetenddate').val();
            var ssid=$('#SH_ssid').val();
            var pwd=$('#SH_pwd').val();
            var cablebox=$('#SH_cablebox').val();
            var modemno=$('#SH_modem').val();
            var basicgroup=$('#SH_basicgroup').val();
            var addchnnl=$('#SH_addchnl').val();
            var comments=$('#SH_comments').val();

            // SEARCH BY OPTIONS VALUE
            if($('#BTDTL_SEARCH_lb_searchoptions').val()==123)
                var searchvalue=$('#BTDTL_SEARCH_lb_starhubacctno').val();
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==110)
                var searchvalue=$('#BTDTL_SEARCH_ta_starhubaddtnlch').val();
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==111)
            {
                var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubappl_startdate').val());
                var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubappl_enddate').val());
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==112)
                var searchvalue=$('#BTDTL_SEARCH_ta_starhubbasic').val();
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==113)
                var searchvalue=$('#BTDTL_SEARCH_lb_starhub_cableserialno').val();
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==114)
            {
                var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_enddate').val());
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==115)
            {
                var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_enddate').val());
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==116)
            {
                var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==117)
            {
                var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
            }
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==118)
                var searchvalue=$('#BTDTL_SEARCH_lb_starhubinvoiceto').val();
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==119)
                var searchvalue=$('#BTDTL_SEARCH_lb_starhubmodem').val();
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==120)
                var searchvalue=$('#BTDTL_SEARCH_lb_starhubssid').val();
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==121)
                var searchvalue=$('#BTDTL_SEARCH_lb_starhubpwd').val();
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==122)
                var searchvalue=$('#BTDTL_SEARCH_ta_starhubcomments').val();
            else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                var searchvalue=$('#BTDTL_SEARCH_lb_starhubunitno').val();
            $.ajax({
                type: "POST",
                url: controller_url+"starhubupdate",
                data:{'primaryid':primaryid,'unitid':unitid,'unitno':unitno,'invoiceto':invoiceto,'acctno':acctno,'appldate':appldate,'cablestartdte':cablestartdte,'cableenddate':cableenddate,'internetstartdte':internetstartdte,'internetenddate':internetenddate,'ssid':ssid,'pwd':pwd,'cablebox':cablebox,'modemno':modemno,'basicgroup':basicgroup,'addchnnl':addchnnl,'comments':comments,'BTDTL_SEARCH_lb_searchoptions':$('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_lb_expense_type':$('#BTDTL_SEARCH_lb_expense_type').val(),'searchvalue':searchvalue,'startdate':startdate,'BTDTL_SEARCH_starhubid':BTDTL_SEARCH_starhubid},
                success: function(data) {
                    $('.preloader').hide();
                    var result=JSON.parse(data)
                    BTDTL_SEARCH_success_showflex(result);
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }) ;

        //PDF CLICK FUNCTION
        $('#BDTL_btn_pdf').click(function(){
            var Expensetype=$('#BTDTL_SEARCH_lb_expense_type').val();
            var expensetypetext=$('#BTDTL_SEARCH_lb_expense_type').find('option:selected').text();
            if(Expensetype==16)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==195)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_ariconservicedbyunitno').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==101)
                {
                    var searchvalue=$('#BTDTL_SEARCH_ta_airconcomments').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_ariconunitno').val();
                }
            }
            else if(Expensetype==17)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==102)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_carno').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==103)
                {
                    var searchvalue=$('#BTDTL_SEARCH_ta_carparkcomments').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_carparkunitno').val();
                }
            }
            else if(Expensetype==15)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==109)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_digitalacctno').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==108)
                {
                    var searchvalue=$('#BTDTL_SEARCH_ta_digitalcomments').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==106)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_digitalvoiceno').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==107)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_digitalinvoiceto').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_digitalunitno').val();
                }
            }
            else if(Expensetype==13)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==104)
                {
                    var searchvalue=$('#BTDTL_SEARCH_ta_electricitycomments').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==105)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_electricityinvoiceto').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_electricityunitno').val();
                }
            }
            else if(Expensetype==14)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==123)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubacctno').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==110)
                    var searchvalue=$('#BTDTL_SEARCH_ta_starhubaddtnlch').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==111)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubappl_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubappl_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==112)
                    var searchvalue=$('#BTDTL_SEARCH_ta_starhubbasic').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==113)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhub_cableserialno').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==114)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==115)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==116)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==117)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==118)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubinvoiceto').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==119)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubmodem').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==120)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubssid').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==121)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubpwd').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==122)
                    var searchvalue=$('#BTDTL_SEARCH_ta_starhubcomments').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubunitno').val();
            }
            var pdfurl=document.location.href='<?php echo site_url("EXPENSE/Ctrl_Pdf/pdfexportbizdetailexpense") ?>?Expensetype='+Expensetype+'&expensetypetext='+expensetypetext+'&BTDTL_SEARCH_lb_searchoptions='+$("#BTDTL_SEARCH_lb_searchoptions").val()+'&searchvalue='+searchvalue+'&startdate='+startdate+'&BTDTL_SEARCH_parentfunc_flex=BTDTL_SEARCH_parentfunc_flex&labelheadername='+$('#BTDTL_SEARCH_div_msg').text();
        });
        // DELTE FUNCTION
        var rowid;
        var unit_id;
        var unitsdate;
        var unitedate;
        $(document).on('click','.classdelete', function (evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $('.preloader').show();
            var id=this.id;
            var splitid=id.split('_');
            if(splitid[0]=='aircondelete' || splitid[0]=="carparkdelete" || splitid[0]=="digitaldelete" || splitid[0]=="electricitydelete")
            {
                rowid=splitid[1];
                unit_id=splitid[2];
            }
            else {
                rowid = splitid[0].split('^')[1];
                unit_id=splitid[1];
                unitsdate=splitid[2];
                unitedate=splitid[3];
            }
            if($('#BTDTL_SEARCH_lb_expense_type').val()==14) {
                var cid = $(this).attr('id');
                var SplittedData = cid.split('^');
                var Rowid = SplittedData[1];
                BTDTL_SEARCH_obj={"unitno":[$('#unitno__'+Rowid).html()],"BTDTL_invoiceto":[$('#invoiceto__'+Rowid).html()],
                    "BTDTL_acctno":[$('#acctno__'+Rowid).html()],"BTDTL_appldate":[$('#appldate__'+Rowid).html()],
                    "BTDTL_cablestartdate":[$('#cablestartdate__'+Rowid).html()],"BTDTL_cableenddate":[$('#cableendate__'+Rowid).html()],
                    "BTDTL_internetsd":[$('#internetstartdate__'+Rowid).html()],"BTDTL_interneted":[$('#internetenddate__'+Rowid).html()],
                    "BTDTL_ssid":[$('#ssid__'+Rowid).html()],"BTDTL_pwd":[$('#pwd__'+Rowid).html()],"BTDTL_cablebox":[$('#cableboxserialno__'+Rowid).html()],
                    "BTDTL_modem":[$('#modemserialno__'+Rowid).html()],"BTDTL_basicgroup":[$('#basicgroup__'+Rowid).html()],"BTDTL_addchhnl":[$('#addchnnl__'+Rowid).html()],"BTDTL_comments":[$('#comments__'+Rowid).html()]}
            }
            $.ajax({
                type: "POST",
                url: controller_url + "checktransaction",
                data: {'rowid':rowid,'unitid':unit_id,'BTDTL_SEARCH_lb_searchoptions': $('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_lb_expense_type': $('#BTDTL_SEARCH_lb_expense_type').val()},
                success: function (data) {
                    $('.preloader').hide();
                    var result=JSON.parse(data);
                    var checktransflag=result[0];
                    var recversion=result[1];
                    if(checktransflag==0)
                    {
                        var unitno = result[2];
                        var BDTL_INPUT_errormsg_replace = BTDTL_SEARCH_errorarr[64].EMC_DATA.replace("[UNITNO]",unitno);
                        BDTL_INPUT_errormsg_replace=BDTL_INPUT_errormsg_replace.replace("[LP]",recversion);
                        show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BDTL_INPUT_errormsg_replace,"success",false);
                    }
                    else if(checktransflag==1)
                    {
                        show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BTDTL_SEARCH_errorarr[59].EMC_DATA,"success","delete");
                    }
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        });
        $(document).on('click','.deleteconfirm', function (evnt){
            evnt.stopPropagation();
            evnt.preventDefault();
            evnt.stopImmediatePropagation();
            $('.preloader').show();
            var Expensetype=$('#BTDTL_SEARCH_lb_expense_type').val();
            if(Expensetype==16)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==195)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_ariconservicedbyunitno').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==101)
                {
                    var searchvalue=$('#BTDTL_SEARCH_ta_airconcomments').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_ariconunitno').val();
                }
            }
            else if(Expensetype==17)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==102)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_carno').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==103)
                {
                    var searchvalue=$('#BTDTL_SEARCH_ta_carparkcomments').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_carparkunitno').val();
                }
            }
            else if(Expensetype==15)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==109)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_digitalacctno').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==108)
                {
                    var searchvalue=$('#BTDTL_SEARCH_ta_digitalcomments').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==106)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_digitalvoiceno').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==107)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_digitalinvoiceto').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_digitalunitno').val();
                }
            }
            else if(Expensetype==13)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==104)
                {
                    var searchvalue=$('#BTDTL_SEARCH_ta_electricitycomments').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==105)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_electricityinvoiceto').val();
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                {
                    var searchvalue=$('#BTDTL_SEARCH_lb_electricityunitno').val();
                }
            }
            else if(Expensetype==14)
            {
                if($('#BTDTL_SEARCH_lb_searchoptions').val()==123)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubacctno').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==110)
                    var searchvalue=$('#BTDTL_SEARCH_ta_starhubaddtnlch').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==111)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubappl_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubappl_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==112)
                    var searchvalue=$('#BTDTL_SEARCH_ta_starhubbasic').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==113)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhub_cableserialno').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==114)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==115)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubcable_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==116)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==117)
                {
                    var startdate=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_startdate').val());
                    var searchvalue=DatePickerFormat($('#BTDTL_SEARCH_db_starhubinternet_enddate').val());
                }
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==118)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubinvoiceto').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==119)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubmodem').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==120)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubssid').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==121)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubpwd').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==122)
                    var searchvalue=$('#BTDTL_SEARCH_ta_starhubcomments').val();
                else if($('#BTDTL_SEARCH_lb_searchoptions').val()==191)
                    var searchvalue=$('#BTDTL_SEARCH_lb_starhubunitno').val();
            }
            $.ajax({
                type: "POST",
                url: controller_url + "deletefunction",
                data: {'rowid':rowid,'unitid':unit_id,'BTDTL_SEARCH_lb_searchoptions': $('#BTDTL_SEARCH_lb_searchoptions').val(),'BTDTL_SEARCH_lb_expense_type': $('#BTDTL_SEARCH_lb_expense_type').val(),'searchvalue': searchvalue,'startdate': startdate,'BTDTL_SEARCH_starhubid':BTDTL_SEARCH_starhubid,'BTDTL_SEARCH_obj':BTDTL_SEARCH_obj},
                success: function (data) {
                    $('.preloader').hide();
                    var result = JSON.parse(data)
                    BTDTL_SEARCH_success_showflex(result);
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        });
    });
</script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/></div>
    <div class="title text-center"><h4><b>BIZ EXPENSE DETAIL ENTRY/ SEARCH/ UPDATE/ DELETE</b></h4></div>
    <form id="BDTL_INPUT_form_biz_detail" class="form-horizontal content">
        <div class="panel-body">
            <div style="padding-bottom: 15px">
                <div class="radio">
                    <label><input type="radio" name="optradio" value="bizdetailentryform" class="BDE_rd_selectform">ENTRY</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="optradio" value="bizdetailsearchform" class="BDE_rd_selectform">SEARCH/ UDATE/ DELETE</label>
                </div>
            </div>
            <div id="divbizdetailentryform">
                <div class="form-group">
                    <label class="col-sm-2" id="BDTL_INPUT_lbl_expensetype" hidden>TYPE OF EXPENSE<em>*</em></label>
                    <div class="col-sm-3"><select id='BDTL_INPUT_lb_expense_type' name='BDTL_INPUT_lb_expense_type' class="BDTL_INPUT_class_save_valid form-control" style="display: none;">
                            <option>SELECT</option>
                        </select></div>
                </div>
                <div class="form-group">
                    <label id="BDTL_INPUT_lbl_unitno_list" class="col-sm-2" hidden>UNIT NO<em>*</em></label>
                    <div class="col-sm-2"><select id="BDTL_INPUT_lb_unitno_list"  name="BDTL_INPUT_lb_unitno_list" class="BDTL_INPUT_class_save_valid form-control" style="display: none;" hidden>
                            <option>SELECT</option>
                        </select>
                    </div>
                </div>
                <!-------------------------------------------------------CODING TO CREATE AIRON SERVICE EXPENSE FORM------------------------------------------------->
                <div id='BDTL_INPUT_div_aircon' hidden>
                    <div class="form-group">
                        <label class="col-sm-2">AIRCON SERVICED BY<em>*</em></label></td>
                        <div class="col-sm-4">
                            <select id="BDTL_INPUT_lb_airconservicedby" name="BDTL_INPUT_lb_airconservicedby" class="BDTL_INPUT_class_save_valid form-control"><option>SELECT</option>
                            </select>
                        </div>
                        <div class="col-sm-2"><input class="btn" type="button" name="BDTL_INPUT_btn_add_aircon" value="ADD" id="BDTL_INPUT_btn_add_aircon"/><td><td><input type="hidden" id="BDTL_INPUT_hidden_unitno" name="BDTL_INPUT_hidden_unitno"></td>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea placeholder="Comments" name="BDTL_INPUT_ta_aircon_comments" id="BDTL_INPUT_ta_aircon_comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control" style="height:116px;" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-7"><div id="BDTL_INPUT_div_errmsg_aircon" name="BDTL_INPUT_div_errmsg_aircon" class="errormsg"></div>
                        </div>
                    </div>
                </div>
                <!------------------------------------------------------CODING TO CREATE CARPARK EXPENSE FORM------------------------------------------------------>
                <div id='BDTL_INPUT_div_carpark' hidden>
                    <div class="form-group">
                        <label class="col-sm-2">CAR NO<em>*</em></label>
                        <div class="col-sm-2"><input style="width:110px" type="text" name="BDTL_INPUT_tb_exp_carno" id="BDTL_INPUT_tb_exp_carno" maxlength='9' class='alphanumeric BDTL_INPUT_class_save_valid form-control' placeholder="Car No"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea placeholder="Comments" name="BDTL_INPUT_ta_carpark_comments" id="BDTL_INPUT_ta_carpark_comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control" style="height:116px;" ></textarea></div>
                    </div>
                </div>
                <!--------------------------------------------------CODING TO CREATE DIGITAL VOICE EXPENSE FORM------------------------------------------------------>
                <div id='BDTL_INPUT_div_digitalvoice' hidden>
                    <div class="form-group">
                        <label class="col-sm-2">INVOICE TO</label>
                        <div class="col-sm-3"><select id="BDTL_INPUT_lb_digital_invoiceto" name="BDTL_INPUT_lb_digital_invoiceto" class="BDTL_INPUT_class_save_valid form-control">
                                <option>SELECT</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">DIGITAL VOICE NO<em>*</em></label>
                        <div class="col-sm-2"><input style="width:95px" type="text" name="BDTL_INPUT_tb_exp_digivoiceno" id="BDTL_INPUT_tb_exp_digivoiceno" class="numbersonly BDTL_INPUT_class_save_valid form-control" placeholder="Digital Voice No" maxlength="8"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">DIGITAL ACCOUNT NO<em>*</em></label>
                        <div class="col-sm-2"><input style="width:120px" type="text" name="BDTL_INPUT_tb_exp_digiaccno" placeholder="Digital Account no" id="BDTL_INPUT_tb_exp_digiaccno" maxlength="11" class='alphanumericdot BDTL_INPUT_class_save_valid form-control'/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea style="height:116px;" name="BDTL_INPUT_ta_digitalvoice_comments" id="BDTL_INPUT_ta_digitalvoice_comments" placeholder="Comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control"></textarea></div>
                    </div>
                </div>
                <!-----------------------------------------CODING TO CREATE ELECTRICITY EXPENSE FORM-------------------------------------------------------------->
                <div id='BDTL_INPUT_div_electricity' hidden>
                    <div class="form-group">
                        <label class="col-sm-2">INVOICE TO<em>*</em></label>
                        <div class="col-sm-3"><select id="BDTL_INPUT_lb_bizdetail_electricity_invoiceto" name="BDTL_INPUT_lb_bizdetail_electricity_invoiceto" class="BDTL_INPUT_class_save_valid form-control">
                                <option>SELECT</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea placeholder="Comments" name="BDTL_INPUT_ta_ectricity_comments" id="BDTL_INPUT_ta_ectricity_comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control" style="height:116px;"></textarea></div>
                    </div>
                </div>
                <!-----------------------------------------------------------CODING TO CREATE STARHUB EXPENSE FORM------------------------------------------------------>
                <div id='BDTL_INPUT_div_starhub' hidden>
                    <div class="form-group">
                        <label class="col-sm-2">INVOICE TO</label>
                        <div class="col-sm-3"><select id="BDTL_INPUT_lb_starhub_invoiceto" name="BDTL_INPUT_lb_starhub_invoiceto" class="BDTL_INPUT_class_save_valid form-control">
                                <option>SELECT</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">STARHUB ACCOUNT NO<em>*</em></label>
                        <div class="col-sm-2"><input style="width:120px" type='text' placeholder="Account no" name='BDTL_INPUT_tb_starhub_account_no' id='BDTL_INPUT_tb_starhub_account_no' maxlength='11' class='alphanumericdot BDTL_INPUT_class_save_valid form-control'/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">APPL DATE</label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input  type="text" placeholder="Appl Date" name="BDTL_INPUT_db_appl_date" id="BDTL_INPUT_db_appl_date" class='BDTL_INPUT_class_datebox BDTL_INPUT_class_save_valid datenonmandtry form-control'/>
                                <label for="BDTL_INPUT_db_appl_date" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">CABLE START DATE</label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input  type="text" placeholder="Cable StartDate" name="BDTL_INPUT_db_cable_startdate"  id="BDTL_INPUT_db_cable_startdate" class='BDTL_INPUT_class_datebox BDTL_INPUT_class_save_valid datenonmandtry form-control'/>
                                <label for="BDTL_INPUT_db_cable_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">CABLE END DATE</label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input  type='text' placeholder="Cable Enddate" name='BDTL_INPUT_db_cable_enddate' id='BDTL_INPUT_db_cable_enddate' class='BDTL_INPUT_class_datebox BDTL_INPUT_class_save_valid BDTL_INPUT_dateInput datenonmandtry form-control'/>
                                <label for="BDTL_INPUT_db_cable_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">INTERNET START DATE</label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input  type='text' placeholder="Internet Startdate" name='BDTL_INPUT_db_internet_startdate' id='BDTL_INPUT_db_internet_startdate' class='BDTL_INPUT_class_internet_datebox BDTL_INPUT_class_save_valid datenonmandtry form-control'/>
                                <label for="BDTL_INPUT_db_internet_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">INTERNET END DATE</label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type='text' placeholder="Internet Enddate" name='BDTL_INPUT_db_internet_enddate' id='BDTL_INPUT_db_internet_enddate' class='BDTL_INPUT_class_internet_datebox BDTL_INPUT_class_save_valid BDTL_INPUT_dateInput datenonmandtry form-control'/>
                                <label for="BDTL_INPUT_db_internet_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">SSID</label>
                        <div class="col-sm-3"><input type='text' placeholder="SSID" name='BDTL_INPUT_tb_ssid' id='BDTL_INPUT_tb_ssid' maxlength='25' class="general BDTL_INPUT_class_save_valid form-control"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">PWD</label>
                        <div class="col-sm-3"><input type='text' placeholder="PWD" name='BDTL_INPUT_tb_pwd' id='BDTL_INPUT_tb_pwd' maxlength='25' class="general BDTL_INPUT_class_save_valid form-control"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">CABLE BOX SERIAL NO</label>
                        <div class="col-sm-3"><input type='text' placeholder="Cablebox serialno" name='BDTL_INPUT_tb_cablebox_sno' id='BDTL_INPUT_tb_cablebox_sno' maxlength='50' class="autosize BDTL_INPUT_class_save_valid form-control"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">MODEM SERIAL NO</label>
                        <div class="col-sm-3"><input type='text' placeholder="Modemserialno" name='BDTL_INPUT_tb_modem_sno' id='BDTL_INPUT_tb_modem_sno' maxlength='50' class="autosize BDTL_INPUT_class_save_valid form-control"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">BASIC GROUP</label>
                        <div class="col-sm-4"><textarea name="BDTL_INPUT_ta_basic_group" placeholder="BasicGroup" id="BDTL_INPUT_ta_basic_group" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control" style="height:116px;"></textarea></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">ADDITIONAL CHANNEL</label>
                        <div class="col-sm-4"><textarea placeholder="Additional Channel" name="BDTL_INPUT_ta_addtl_ch" id="BDTL_INPUT_ta_addtl_ch" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control" style="height:116px;"></textarea></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea placeholder="Comments" name="BDTL_INPUT_ta_starhub_comments" id="BDTL_INPUT_ta_starhub_comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control" style="height:116px;"></textarea></div>
                    </div>
                </div>
                <div class="col-lg-offset-2" id="BDTL_INPUT_tble_btn" hidden>
                    <input type="button" style="cursor:pointer" disabled="" name="BDTL_INPUT_btn_save" id="BDTL_INPUT_btn_save" class="btn" value="SAVE"/>&nbsp;&nbsp;
                    <input type="button" style="cursor:pointer" name="BDTL_INPUT_btn_reset" id="BDTL_INPUT_btn_reset" class="btn" value="RESET" />
                </div>
            </div>
            <div id="divbizdetailupdateform">
                <div class="form-group">
                    <label class="col-sm-2" id="srchexpensetype"hidden>TYPE OF EXPENSE<em>*</em></label>
                    <div class="col-sm-3"><select  id='BTDTL_SEARCH_lb_expense_type' name='BTDTL_SEARCH_lb_expense_type' class="form-control" style="display: none;">
                            <option>SELECT</option>
                        </select></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2" hidden="" name='BTDTL_SEARCH_lbl_searchoptions' id='BTDTL_SEARCH_lbl_searchoptions'>SEARCH OPTIONS<em>*</em></label>
                    <div class="col-sm-3"><select name='BTDTL_SEARCH_lb_searchoptions' id='BTDTL_SEARCH_lb_searchoptions' class="form-control" style="display: none;" hidden>
                            <option>SELECT</option>
                        </select>
                    </div>
                </div>
                <div><label id="BTDTL_SEARCH_lbl_errmsg_notable" class="errormsg"></label></div>
                <!----------CODING TO CREATE SEARCH FORM FOR AIRCON SERVICES------------------------------------------------>
                <div id='BTDTL_SEARCH_div_aircon'>
                    <table style="width:1000px" id='BTDTL_SEARCH_tble_airconcomments'>
                    </table>
                    <div  id="BTDTL_SEARCH_tble_searchby" >
                    </div>
                </div>
                <div id="BTDTL_SEARCH_div_flex_searchbtn">
                    <div id="BTDTL_SEARCH_div_msg" class="srctitle"></div>
                    <div id="BTDTL_SEARCH_div_errmsg" class="errormsg"></div>
                    <div><input type="button" id='BDTL_btn_pdf' class="btnpdf" value="PDF" hidden></div>
                    <div id ="BTDTL_SEARCH_div_flex" class="table-responsive">
                        <section></section>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>