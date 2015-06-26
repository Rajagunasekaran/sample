<!--********************************************PAYMENT SEARCH /UPDATE / DELETE********************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 0.02- SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names in ver0.02-->
<!--VER 0.01-INITIAL VERSION-SD:11/05/2015 ED:12/05/2015 in ver0.01-->
<html>
<head>
    <?php require_once('application/libraries/EI_HDR.php'); ?>
</head>
<!--<link rel="stylesheet" href ="--><?php //echo base_url().'bootstrap/CSS/colreorder.css'?><!--"  />-->
<!--<script src="--><?php //echo base_url().'JS/colreorder.js'?><!--"></script>-->
<!--<script type="text/javascript" src="http://datatables.net/release-datatables/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>-->
<style>
    body { font-size: 140%; }

    /* Ensure that the demo table scrolls */
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 1100px;
        margin: 0 auto;
    }
</style>
<script>
    $(document).ready(function() {
        $('.preloader').show();
        $('#spacewidth').height('0%');
        var controller_url="<?php echo base_url(); ?>" + '/index.php/FINANCE/FINANCE/Ctrl_Finance_Payment_Search_Update/' ;
        $('.amtonly').doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $('.autogrowcomments').autogrow({onInitialize: true});
        var Allunits;
        var PaymentType;
        var Errormsg;
        //UPDATION FORM DATE PICKERS//
        var CCRE_d = new Date();
        var changedmonth=new Date(CCRE_d.setFullYear(2009));
        $("#UD_Payment_Paiddate").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true});
        $('#UD_Payment_Paiddate').datepicker("option","maxDate",new Date());
        $('#UD_Payment_Paiddate').datepicker("option","minDate",changedmonth);
        $('#UD_Payment_Forperiod').datepicker( {
            changeMonth: true,      //provide option to select Month
            changeYear: true,       //provide option to select year
            showButtonPanel: true,  // button panel having today and done button
            dateFormat: 'MM-yy',    //set date format
            onClose: function(dateText, inst)
            {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));//here set the date when closing.
                $(this).blur();//remove focus input box
                paymentform_upadation();
            }
        });
        $("#UD_Payment_Forperiod").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });

        $('#Payment_Updation_form').hide();
        $.ajax({
            type: "POST",
            url: controller_url+"InitialDataLoad",
            data:{ErrorList:'2,5,45,93,247,248,315'},
            success: function(data){
                $('.preloader').hide();
                var valuearray=JSON.parse(data);
                Allunits=valuearray[0];
                PaymentType=valuearray[1];
                Errormsg=valuearray[2];
                var search_option=valuearray[3];
                var unitoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < Allunits.length; i++)
                {
                    var data=Allunits[i];
                    unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                var searchoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < search_option.length; i++)
                {
                    var data=search_option[i];
                    searchoptions += '<option value="' + data.PCN_ID + '">' + data.PCN_DATA + '</option>';
                }
                $('#Payment_SRC_SearchOption').html(searchoptions);
                var Paymenttypeoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < PaymentType.length; i++)
                {
                    var data=PaymentType[i];
                    Paymenttypeoptions += '<option value="' + data.PP_DATA+ '">' + data.PP_DATA+ '</option>';
                }
                $('#UD_Payment_Paymenttype').html(Paymenttypeoptions);
                $('.preloader').hide();
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
                $('.preloader').hide();
            }
        });
        $(document).on('click','#Payment_SRC_SearchOption',function() {

            $('#Payment_Updation_form').hide();
            $('#Payment_Search_DataTable').hide();
            $('#tableEmptyerrormessageshow').hide();
            $('#Payment_Search_DataTable').hide();
            $('#emptytableheader').text('');
            var searchoption=$('#Payment_SRC_SearchOption').val();
            if(searchoption==2)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">UNIT NUMBER SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>UNIT NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control" name="Payment_SRC_Uintsearch"  id="Payment_SRC_Uintsearch" style="max-width: 120px"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Payment_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Payment_SearchformDiv').html(appenddata);
                var unitoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < Allunits.length; i++)
                {
                    var data=Allunits[i];
                    unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                $('#Payment_SRC_Uintsearch').html(unitoptions);
                $('.preloader').hide();
            }
            if(searchoption==3)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">CUSTOMER NAME SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>UNIT NO<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control customer_btn_validation" name="Payment_SRC_unit"  id="Payment_SRC_unit" style="max-width: 120px"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control customer_btn_validation" name="Payment_SRC_Customer"  id="Payment_SRC_Customer" disabled><option>SELECT</option></SELECT></div>';
                appenddata+='<div class="col-md-5"><label id="FIN_SRC_customererrormsg" class="errormsg" hidden></label></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Payment_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Payment_SearchformDiv').html(appenddata);

                var unitoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < Allunits.length; i++)
                {
                    var data=Allunits[i];
                    unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                $('#Payment_SRC_unit').html(unitoptions);
                $('.preloader').hide();
            }
            if(searchoption==4)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">FOR PERIOD SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>FROM PERIOD<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<input type="text" class="form-control customer_btn_validation datemandtry" name="Payment_SRC_FP_fromdate" id="Payment_SRC_FP_fromdate"  placeholder="For Period" style="width:150px"></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>TO PERIOD<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<input type="text" class="form-control customer_btn_validation datemandtry" name="Payment_SRC_FP_todate" id="Payment_SRC_FP_todate"  placeholder="For Period" style="width:150px"></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Payment_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Payment_SearchformDiv').html(appenddata);
                $("#Payment_SRC_FP_fromdate").datepicker(
                    {
                        changeMonth: true,
                        changeYear: true,
                        showButtonPanel: true,
                        dateFormat: 'MM-yy',
                        onClose: function(dateText, inst) {
                            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                            $(this).datepicker('setDate', new Date(year, month, 1));
                            Fn_Toperiod_validation();
                            Fn_Btn_validation();
                        }
                    });
                $("#Payment_SRC_FP_fromdate").focus(function () {
                    $(".ui-datepicker-calendar").hide();
                    $("#ui-datepicker-div").position({
                        my: "center top",
                        at: "center bottom",
                        of: $(this)
                    });
                });
                var CCRE_d = new Date();
                var changedmonth=new Date(CCRE_d.setFullYear(2009));
                $('#Payment_SRC_FP_fromdate').datepicker("option","minDate",changedmonth);
                $('#Payment_SRC_FP_fromdate').datepicker("option","maxDate",changeyear);
                $('.preloader').hide();
            }
            if(searchoption==5)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">PAIDDATE SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>FROM DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<input type="text" class="form-control Paiddate_btn_validation datemandtry" name="Payment_SRC_PD_fromdate" id="Payment_SRC_PD_fromdate"  placeholder="From Date" style="width:110px"></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>TO DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<input type="text" class="form-control Paiddate_btn_validation datemandtry" name="Payment_SRC_PD_todate" id="Payment_SRC_PD_todate"  placeholder="To Date" style="width:110px"></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Payment_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Payment_SearchformDiv').html(appenddata);
                $("#Payment_SRC_PD_fromdate").datepicker({
                    dateFormat: "dd-mm-yy",
                    changeYear: true,
                    changeMonth: true});
                var CCRE_d = new Date();
                var changedmonth=new Date(CCRE_d.setFullYear(2009));
                $('#Payment_SRC_PD_fromdate').datepicker("option","minDate",changedmonth);
                $('#Payment_SRC_PD_fromdate').datepicker("option","maxDate",changeyear);
                $('.preloader').hide();
            }
            if(searchoption==6)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">AMOUNT RANGE SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>UNIT NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control AR_btn_validation" name="Payment_SRC_AR_Uint"  id="Payment_SRC_AR_Uint" style="max-width: 150px"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>FROM PERIOD<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input type="text" class="form-control AR_btn_validation datemandtry" name="Payment_SRC_AR_fromdate" id="Payment_SRC_AR_fromdate"  placeholder="From Period" style="width:150px"></div></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>TO PERIOD<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input type="text" class="form-control AR_btn_validation datemandtry" name="Payment_SRC_AR_todate" id="Payment_SRC_AR_todate"  placeholder="To Period" style="width:150px"></div></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>FROM AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input class="form-control AR_btn_validation amtonly" name="Payment_SRC_AR_fromamount"  id="Payment_SRC_AR_fromamount" style="max-width: 150px"></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>TO AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input class="form-control AR_btn_validation amtonly" name="Payment_SRC_AR_toamount"  id="Payment_SRC_AR_toamount" style="max-width: 150px"></div>';
                appenddata+='<div class="col-md-5"><label id="FIN_SRC_amounterrormsg" class="errormsg" hidden></label></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Payment_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Payment_SearchformDiv').html(appenddata);
                var unitoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < Allunits.length; i++)
                {
                    var data=Allunits[i];
                    unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                $('#Payment_SRC_AR_Uint').html(unitoptions);
                $("#Payment_SRC_AR_fromdate").datepicker(
                    {
                        changeMonth: true,
                        changeYear: true,
                        showButtonPanel: true,
                        dateFormat: 'MM-yy',
                        onClose: function(dateText, inst) {
                            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                            $(this).datepicker('setDate', new Date(year, month, 1));
                            AR_Fn_Toperiod_validation();
                            AR_Fn_Btn_validation();
                        }
                    });
                $("#Payment_SRC_AR_fromdate").focus(function () {
                    $(".ui-datepicker-calendar").hide();
                    $("#ui-datepicker-div").position({
                        my: "center top",
                        at: "center bottom",
                        of: $(this)
                    });
                });

                $('#Payment_SRC_AR_fromdate').datepicker("option","minDate",changedmonth);
                $('#Payment_SRC_AR_fromdate').datepicker("option","maxDate",changeyear);
                $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
                $('#FIN_SRC_amounterrormsg').text(Errormsg[2].EMC_DATA)
                $('.preloader').hide();
            }
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        });
        function FIN_SRC_forperiodconverttodate(searchinput)
        {
            $('#emptytableheader').text('');
            var FIN_SRC_UPD_DEL_fromperiod=searchinput.split('-');
            var FIN_ENTRY_monthlist=['January','February','March','April','May','June','July','August','September','October','November','December'];
            for(var i=0;i<FIN_ENTRY_monthlist.length;i++)
            {
                if(FIN_ENTRY_monthlist[i]==FIN_SRC_UPD_DEL_fromperiod[0])
                {
                    var FIN_ENTRY_frommonth=parseInt(i);
                    break;
                }
            }
            var dateformat=new Date(FIN_SRC_UPD_DEL_fromperiod[1],FIN_ENTRY_frommonth,02)
            return dateformat;
        }
        //FOR PERIOD TO DATEPICKER
        function Fn_Toperiod_validation()
        {
            var fromdate=FIN_SRC_forperiodconverttodate($("#Payment_SRC_FP_fromdate").val());
            $("#Payment_SRC_FP_todate").datepicker(
                {
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: 'MM-yy',
                    onClose: function(dateText, inst) {
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, month, 1));
                        Fn_Btn_validation();
                    }
                });
            $("#Payment_SRC_FP_todate").focus(function () {
                $(".ui-datepicker-calendar").hide();
                $("#ui-datepicker-div").position({
                    my: "center top",
                    at: "center bottom",
                    of: $(this)
                });
            });
            $('#Payment_SRC_FP_todate').datepicker("option","minDate",fromdate);
            $('#Payment_SRC_FP_todate').datepicker("option","maxDate",changeyear);
        }
        function AR_Fn_Toperiod_validation()
        {
            var fromdate=FIN_SRC_forperiodconverttodate($("#Payment_SRC_AR_fromdate").val());
            $("#Payment_SRC_AR_todate").datepicker(
                {
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    dateFormat: 'MM-yy',
                    onClose: function(dateText, inst) {
                        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                        $(this).datepicker('setDate', new Date(year, month, 1));
                        AR_Fn_Btn_validation();
                    }
                });
            $("#Payment_SRC_AR_todate").focus(function () {
                $(".ui-datepicker-calendar").hide();
                $("#ui-datepicker-div").position({
                    my: "center top",
                    at: "center bottom",
                    of: $(this)
                });
            });
            $('#Payment_SRC_AR_todate').datepicker("option","minDate",fromdate);
            $('#Payment_SRC_AR_todate').datepicker("option","maxDate",changeyear);
        }
        //PAIDDATE TO DATE PICKER
        var CCRE_d = new Date();
        var maxyear=CCRE_d.getFullYear()+parseInt(2);
        var changeyear=new Date(CCRE_d.setFullYear(maxyear));
        $(document).on('change','#Payment_SRC_PD_fromdate',function() {
            $("#Payment_SRC_PD_todate").datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true});
            var to_mindate=Form_dateConversion($('#Payment_SRC_PD_fromdate').val());
            $('#Payment_SRC_PD_todate').datepicker("option","minDate",to_mindate);
            $('#Payment_SRC_PD_todate').datepicker("option","maxDate",changeyear);
        });
        function Form_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[2],inputdate[1]-1,parseInt(inputdate[0])+parseInt(1));
            return newunitstartdate;
        }
        $(document).on('change','#Payment_SRC_unit',function() {
            $('.preloader').show();
            $('#emptytableheader').text('');
            $('#tableEmptyerrormessageshow').hide();
            $('#Payment_Search_DataTable').hide();
            var unit=$('#Payment_SRC_unit').val();
            $('#FIN_SRC_customererrormsg').hide();
            if(unit!='SELECT')
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"UnitCustomer",
                    data:{Unit:unit},
                    success: function(data){
                        var valuearray=JSON.parse(data);
                        var customeroptions='<OPTION>SELECT</OPTION>';
                        if(valuearray.length!=0)
                        {
                            for (var i = 0; i < valuearray.length; i++) {
                                var data = valuearray[i];
                                customeroptions += '<option value="' + data.CUSTOMER_FIRST_NAME + '_' + data.CUSTOMER_LAST_NAME + '">' + data.CUSTOMER_FIRST_NAME + ' ' + data.CUSTOMER_LAST_NAME + '</option>';
                            }
                            $('#Payment_SRC_Customer').html(customeroptions);
                            $('#Payment_SRC_Customer').prop("disabled", false);

                        }
                        else
                        {
                            var errormsg=Errormsg[4].EMC_DATA;
                            errormsg=errormsg.replace('[UNIT NO]',unit);
                            $('#FIN_SRC_customererrormsg').text(errormsg);
                            $('#FIN_SRC_customererrormsg').show();
                            $('#Payment_SRC_Customer').prop("disabled", true);
                            $('#Payment_SRC_Customer').val('SELECT');
                        }
                        $('.preloader').hide();
                    },
                    error: function(data){
                        alert('error in getting'+JSON.stringify(data));
                        $('.preloader').hide();
                    }
                });
            }
            else
            {
                $('#Payment_SRC_Customer').prop("disabled", true);
                $('#Payment_SRC_Customer').val('SELECT');
                $("#Payment_src_btn_search").attr("disabled", "disabled");
                $('.preloader').hide();
            }
        })
        //UNIT SEARCH BUTTON VALIDATION
        $(document).on('click','#Payment_SRC_Uintsearch',function() {
            $('#emptytableheader').text('');
            if($('#Payment_SRC_Uintsearch').val()!='SELECT')
            {
                $('#Payment_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Payment_src_btn_search").attr("disabled", "disabled");
            }
        });
        //CUSTOMER SEARCH BUTTON VALIDATION
        $(document).on('change','.customer_btn_validation',function() {
            $('#emptytableheader').text('');
            if($('#Payment_SRC_unit').val()!='SELECT' && $('#Payment_SRC_Customer').val()!='SELECT' && $('#Payment_SRC_Customer').val()!=undefined && $('#Payment_SRC_Customer').val()!='')
            {
                $('#Payment_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Payment_src_btn_search").attr("disabled", "disabled");
            }
        });
        //FORPERIOD SEARCH BUTTON VALIDATION
        function Fn_Btn_validation()
        {
            $('#emptytableheader').text('');
            if($('#Payment_SRC_FP_fromdate').val()!='' && $('#Payment_SRC_FP_todate').val()!='')
            {
                $('#Payment_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Payment_src_btn_search").attr("disabled", "disabled");
            }
        }
        //PAIDDATE SEARCH BUTTON VALIDATION
        $(document).on('change','.Paiddate_btn_validation',function() {
            $('#emptytableheader').text('');
            if($('#Payment_SRC_PD_fromdate').val()!='' && $('#Payment_SRC_PD_todate').val()!='')
            {
                $('#Payment_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Payment_src_btn_search").attr("disabled", "disabled");
            }
        });
        $(document).on('change blur','.AR_btn_validation',function() {
            AR_Fn_Btn_validation();
        });
        //AMOUNT RANGE SEARCH BUTTON VALIDATION
        function AR_Fn_Btn_validation()
        {
            var fromamount=$('#Payment_SRC_AR_fromamount').val();
            var toamount=$('#Payment_SRC_AR_toamount').val();
            if(fromamount!='' && toamount!='')
            {
                if(parseFloat(fromamount)<=parseFloat(toamount))
                {   var amountflag=1; $('#FIN_SRC_amounterrormsg').hide();     }
                else
                {    amountflag=0;   $('#FIN_SRC_amounterrormsg').show();                }
            }
            else
            {amountflag=0; $('#FIN_SRC_amounterrormsg').hide();    }
            if($('#Payment_SRC_AR_Uint').val()!='SELECT' && $('#Payment_SRC_AR_fromdate').val()!='' && $('#Payment_SRC_AR_todate').val()!='' && amountflag==1)
            {
                $('#Payment_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Payment_src_btn_search").attr("disabled", "disabled");
            }
        }
        var extractunitno;
        var extractcustomername;
        $(document).on('click','#Payment_src_btn_search',function() {
            $('.preloader').show();
            var searchoption=$('#Payment_SRC_SearchOption').val();
            $('#emptytableheader').text('');
            $("#Payment_src_btn_search").attr("disabled", "disabled");
            if(searchoption==2)
            {
                var unit=$('#Payment_SRC_Uintsearch').val();
                var data={Option:2,Unit:unit,Customer:'',FromDate:'',Todate:'',Fromamount:'',Toamount:''};
                var headervalue="DETAILS OF SELECTED UNIT : "+unit;
                var EMPTY_headervalue="NO DETAILS OF SELECTED UNIT : "+unit;
            }
            if(searchoption==3)
            {
                var unit=$('#Payment_SRC_unit').val();
                var customer=$('#Payment_SRC_Customer').val();
                extractunitno=unit;
                extractcustomername=customer;
                data={Option:3,Unit:unit,Customer:customer,FromDate:'',Todate:'',Fromamount:'',Toamount:''};
                customer=customer.replace('_',' ');
                headervalue="DETAILS OF SELECTED UNIT : "+unit+" AND CUSTOMER NAME : "+customer;
                var EMPTY_headervalue="NO DETAILS OF SELECTED UNIT : "+unit+" AND CUSTOMER NAME : "+customer;
            }
            if(searchoption==4)
            {
                var fromdate=$('#Payment_SRC_FP_fromdate').val();
                var todate=$('#Payment_SRC_FP_todate').val();
                data={Option:4,Unit:'',Customer:'',FromDate:fromdate,Todate:todate,Fromamount:'',Toamount:''};
                headervalue="DETAILS OF SELECTED FOR PERIOD DATE RANGE : "+fromdate+" TO : "+todate;
                var EMPTY_headervalue="NO DETAILS OF SELECTED FOR PERIOD DATE RANGE : "+fromdate+" TO : "+todate;
            }
            if(searchoption==5)
            {
                var fromdate=$('#Payment_SRC_PD_fromdate').val();
                var todate=$('#Payment_SRC_PD_todate').val();
                data={Option:5,Unit:'',Customer:'',FromDate:fromdate,Todate:todate,Fromamount:'',Toamount:''};
                headervalue="DETAILS OF SELECTED PAID DATE RANGE : "+fromdate+" TO : "+todate;
                EMPTY_headervalue="NO DETAILS OF SELECTED PAID DATE RANGE : "+fromdate+" TO : "+todate;
            }
            if(searchoption==6)
            {
                var unit=$('#Payment_SRC_AR_Uint').val();
                var fromdate=$('#Payment_SRC_AR_fromdate').val();
                var todate=$('#Payment_SRC_AR_todate').val();
                var fromamount=$('#Payment_SRC_AR_fromamount').val();
                var toamount=$('#Payment_SRC_AR_toamount').val();
                data={Option:6,Unit:unit,Customer:'',FromDate:fromdate,Todate:todate,Fromamount:fromamount,Toamount:toamount};
                headervalue="DETAILS OF SELECTED UNIT : "+unit+" AND FOR PERIOD : "+fromdate+" TO : "+todate+" AND AMOUNT : "+fromamount+" TO : "+toamount;
                EMPTY_headervalue="NO DETAILS OF SELECTED UNIT : "+unit+" AND FOR PERIOD : "+fromdate+" TO : "+todate+" AND AMOUNT : "+fromamount+" TO : "+toamount;
            }

            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url+"PaymentsearchData",
                data:data,
                success: function(data){
                    var valuearray=JSON.parse(data);

                    if(valuearray.length!=0)
                    {
                        $('#tableheader').text(headervalue);
                        PaymentDataTable(valuearray);
                        if (searchoption == 3) {
                            $('#Paymeny_Extract_btn').show();
                        }
                        else {
                            $('#Paymeny_Extract_btn').hide();
                        }
                        $('#emptytableheader').text('');
                        $("html, body").animate({scrollTop: $(document).height()}, "slow");
                    }
                    else
                    {
                        $('#emptytableheader').text(EMPTY_headervalue);
                        $('#tableEmptyerrormessageshow').show();
                        $('#Payment_Search_DataTable').hide();
                    }
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });

        function PaymentDataTable(valuearray)
        {

                var Payment_Tabledata = '<table style="width:2500px" id="Payment_Datatable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr>';
                Payment_Tabledata += "<th style='width:5%;' >UPDATE / DELETE</th>";
                Payment_Tabledata += "<th style='width:5%;' >UNIT</th>";
                Payment_Tabledata += "<th style='width:10%;' >CUSTOMER NAME</th>";
                Payment_Tabledata += "<th style='width:5%;' >PAYMENT AMOUNT</th>";
                Payment_Tabledata += "<th style='width:5%;' >DEPOSIT</th>";
                Payment_Tabledata += "<th style='width:5%;' >PROCESSING FEE</th>";
                Payment_Tabledata += "<th style='width:5%;' >CLEANING FEE</th>";
                Payment_Tabledata += "<th style='width:5%;' >DEPOSIT REFUND</th>";
                Payment_Tabledata += "<th style='width:5%;'  class='uk-perioddate-column'>FOR PERIOD</th>";
                Payment_Tabledata += "<th style='width:5%;'  class='uk-date-column'>PAID DATE</th>";
                Payment_Tabledata += "<th style='width:25%;'>COMMENTS</th>";
                Payment_Tabledata += "<th style='width:10%;' >USERSTAMP</th>";
                Payment_Tabledata += "<th style='width:10%;'  class='uk-timestp-column'>TIMESTAMP</th>";
                Payment_Tabledata += "</tr></thead><tbody>";
                for (var i = 0; i < valuearray.length; i++) {
                    var rowid = valuearray[i].PD_ID;
                    var EditId = 'Edit_' + rowid + '_' + valuearray[i].CUSTOMER_ID + '_' + valuearray[i].CED_REC_VER + '_' + valuearray[i].UNIT_NO;
                    var DeleteId = 'Delete_' + rowid;
                    if (valuearray[i].PD_HIGHLIGHT_FLAG != 'X') {
                        if (valuearray[i].PD_PAYMENT == null) {
                            var payment = ''
                        } else {
                            payment = valuearray[i].PD_PAYMENT
                        }
                        if (valuearray[i].PD_DEPOSIT == null) {
                            var deposit = ''
                        } else {
                            deposit = valuearray[i].PD_DEPOSIT
                        }
                        if (valuearray[i].PD_PROCESSING_FEE == null) {
                            var processfee = ''
                        } else {
                            processfee = valuearray[i].PD_PROCESSING_FEE
                        }
                        if (valuearray[i].PD_CLEANING_FEE == null) {
                            var cleaningfee = ''
                        } else {
                            cleaningfee = valuearray[i].PD_CLEANING_FEE
                        }
                        if (valuearray[i].PD_DEPOSIT_REFUND == null) {
                            var Depositrefund = ''
                        } else {
                            Depositrefund = valuearray[i].PD_DEPOSIT_REFUND
                        }
                        if (valuearray[i].PD_COMMENTS == null) {
                            var comments = ''
                        } else {
                            comments = valuearray[i].PD_COMMENTS
                        }
                        Payment_Tabledata += '<tr>' +
                        "<td><div class='col-lg-1'><span style='display: block;color:green' class='glyphicon glyphicon-edit Payment_editbutton' id=" + EditId + "></div><div class='col-lg-1'><span style='display: block;color:red' class='glyphicon glyphicon-trash Payment_removebutton' id=" + DeleteId + "></div></td>" +
                        "<td>" + valuearray[i].UNIT_NO + "</td>" +
                        "<td>" + valuearray[i].CUSTOMER_FIRST_NAME + " " + valuearray[i].CUSTOMER_LAST_NAME + "</td>" +
                        "<td>" + payment + "</td>" +
                        "<td>" + deposit + "</td>" +
                        "<td>" + processfee + "</td>" +
                        "<td>" + cleaningfee + "</td>" +
                        "<td>" + Depositrefund + "</td>" +
                        "<td>" + valuearray[i].PD_FOR_PERIOD + "</td>" +
                        "<td>" + valuearray[i].PD_PAID_DATE + "</td>" +
                        "<td>" + comments + "</td>" +
                        "<td>" + valuearray[i].ULD_lOGINID + "</td>" +
                        "<td>" + valuearray[i].PD_TIMESTAMP + "</td></tr>";
                    }
                    else {
                        if (valuearray[i].PD_PAYMENT == null) {
                            var payment = ''
                        } else {
                            payment = valuearray[i].PD_PAYMENT
                        }

                        if (valuearray[i].PD_DEPOSIT == null) {
                            var deposit = ''
                        } else {
                            deposit = valuearray[i].PD_DEPOSIT
                        }

                        if (valuearray[i].PD_PROCESSING_FEE == null) {
                            var processfee = ''
                        } else {
                            processfee = valuearray[i].PD_PROCESSING_FEE
                        }

                        if (valuearray[i].PD_CLEANING_FEE == null) {
                            var cleaningfee = ''
                        } else {
                            cleaningfee = valuearray[i].PD_CLEANING_FEE
                        }

                        if (valuearray[i].PD_DEPOSIT_REFUND == null) {
                            var Depositrefund = ''
                        } else {
                            Depositrefund = valuearray[i].PD_DEPOSIT_REFUND
                        }

                        if (valuearray[i].PD_COMMENTS == null) {
                            var comments = ''
                        } else {
                            comments = valuearray[i].PD_COMMENTS
                        }

                        Payment_Tabledata += '<tr>' +
                        "<td style='vertical-align: middle'><div class='col-lg-1'><span style='display: block;color:green' class='glyphicon glyphicon-edit Payment_editbutton' id=" + EditId + "></div><div class='col-lg-1'><span style='display: block;color:red' class='glyphicon glyphicon-trash Payment_removebutton' id=" + DeleteId + "></div></td>" +
                        "<td style='vertical-align: middle'>" + valuearray[i].UNIT_NO + "</td>" +
                        "<td>" + valuearray[i].CUSTOMER_FIRST_NAME + " " + valuearray[i].CUSTOMER_LAST_NAME + "</td>" +
                        "<td style='color:#FF0000;font-size:13px;font-weight:bold;'>" + payment + "</td>" +
                        "<td style='color:#FF0000;font-size:13px;font-weight:bold;'>" + deposit + "</td>" +
                        "<td style='color:#FF0000;font-size:13px;font-weight:bold;'>" + processfee + "</td>" +
                        "<td style='color:#FF0000;font-size:13px;font-weight:bold;'>" + cleaningfee + "</td>" +
                        "<td style='color:#FF0000;font-size:13px;font-weight:bold;'>" + Depositrefund + "</td>" +
                        "<td >" + valuearray[i].PD_FOR_PERIOD + "</td>" +
                        "<td>" + valuearray[i].PD_PAID_DATE + "</td>" +
                        "<td>" + comments + "</td>" +
                        "<td>" + valuearray[i].ULD_lOGINID + "</td>" +
                        "<td>" + valuearray[i].PD_TIMESTAMP + "</td></tr>";
                    }
                }
                Payment_Tabledata += "</body>";
                $('section').html(Payment_Tabledata);
                $('#Payment_Search_DataTable').show();
               var length=valuearray.length;
               if(length > 10)
               {
                   var pix ="300px";
               }
               else
               {
                   pix = length * 15;
                   pix=pix+100+'px';
               }
            var table = $('#Payment_Datatable').DataTable( {
                scrollY:        pix,
                scrollX:        true,
                "sDom": 'Rlfrtip',
                paging:         true,
                "aoColumnDefs" : [{ "aTargets" : ["uk-perioddate-column"] , "sType" : "uk_perioddate"},{ "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ]
            } );
//            new $.fn.dataTable.FixedColumns( table );
            sorting();
        }

        //FUNCTION TO CALL DATE PICKER FORMAT TO SHOW IN FORM ELEMENTS
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+''+ string[1]+''+string[0];
        }
        function FormTable_DateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        function FormTable_PERIODDateFormat(inputdate){
            var string = inputdate.split("-");
            return new Date(Date.parse(string[0] +" 1,"+string[1]));
        }
        //FUNCTION FOR SORTING
        function sorting(){
            jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
                var x = new Date( Date.parse(FormTable_DateFormat(a)));
                var y = new Date( Date.parse(FormTable_DateFormat(b)) );
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
                var x = new Date( Date.parse(FormTable_DateFormat(a)));
                var y = new Date( Date.parse(FormTable_DateFormat(b)) );
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_perioddate-asc']  = function(a,b) {
                var x = FormTable_PERIODDateFormat(a);
                var y = FormTable_PERIODDateFormat(b);
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_perioddate-desc'] = function(a,b) {
                var x = FormTable_PERIODDateFormat(a);
                var y = FormTable_PERIODDateFormat(b);
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_timestp-asc']  = function(a,b) {
                var x = new Date( Date.parse(FormTable_DateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(FormTable_DateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_timestp-desc'] = function(a,b) {
                var x = new Date( Date.parse(FormTable_DateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(FormTable_DateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
        }
        var LpDetails;
        $(document).on('click','.Payment_editbutton',function() {
            $('.preloader').show();
            var id=this.id;
            var SplittedData=id.split('_');
            var Rowid=SplittedData[1];
            var Customerid=SplittedData[2];
            var Recversion=SplittedData[3];
            var Unit=SplittedData[4];
            $('#UD_Btn_Payment_Updation').attr('disabled','disabled');
            $('#UD_Payment_Amountflag').prop('checked',false);
            $.ajax({
                type: "POST",
                url: controller_url+"PaymentsearchRowDetails",
                data:{Unit:Unit,Rowid:Rowid,Customerid:Customerid,Recversion:Recversion},
                success: function(data){
                    var valuearray=JSON.parse(data);
                    var updationrow=valuearray[0];
                    LpDetails=valuearray[1];
                    var lp=valuearray[2];
                    $('#UD_Payment_id').val(updationrow[0].PD_ID).hide();
                    $('#UD_Payment_Unit').val(updationrow[0].UNIT_NO);
                    $('#UD_Payment_Customer').val(updationrow[0].CUSTOMER_FIRST_NAME+' '+updationrow[0].CUSTOMER_LAST_NAME);
                    $('#UD_Payment_Paymenttype').val(updationrow[0].PP_DATA);
                    $('#UD_Payment_Amount').val(updationrow[0].PD_AMOUNT);
                    if(updationrow[0].PD_HIGHLIGHT_FLAG=='X')
                    {
                        $('#UD_Payment_Amountflag').prop('checked',true);
                    }
                    $('#UD_Payment_Paiddate').val(updationrow[0].PD_PAID_DATE);
                    $('#UD_Payment_Comments').val(updationrow[0].PD_COMMENTS);
                    var start_date;
                    var end_date;
                    var lpoptions='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < LpDetails.length; i++)
                    {
                        var data=LpDetails[i];
                        if(data.CLP_PRETERMINATE_DATE!=null && data.CLP_PRETERMINATE_DATE!='')
                        {  var enddate =  data.CLP_PRETERMINATE_DATE; }
                        else
                        { enddate =  data.CLP_ENDDATE}
                        var recverdateperiod=data.CLP_STARTDATE+' --- '+enddate;
                        if(data.CED_REC_VER==lp)
                        {
                            start_date=data.CLP_STARTDATE;
                            end_date=enddate;
                        }
                        lpoptions += '<option title="'+recverdateperiod+'" value="' + data.CED_REC_VER + '">' + data.CED_REC_VER + '</option>';
                    }
                    $('#UD_Payment_Leaseperiod').html(lpoptions);
                    $('#UD_Payment_Leaseperiod').val(lp);
                    var paymenttype=updationrow[0].PP_DATA;
                    if(paymenttype=='PAYMENT' || paymenttype=='CLEANING FEE')
                    {
                        var startdate=DBfrom_dateConversion(start_date);
                        var enddate=DBfrom_dateConversion(end_date);
                        $('#UD_Payment_Forperiod').datepicker("option","minDate",startdate);
                        $('#UD_Payment_Forperiod').datepicker("option","maxDate",enddate);
                    }
                    if(paymenttype=='DEPOSIT' || paymenttype=='PROCESSING FEE')
                    {
                        var depositmindate=DBstartdate_dateConversion(start_date);
                        var depositmaxdate=DBenddate_dateConversion(start_date);
                        $('#UD_Payment_Forperiod').datepicker("option","minDate",depositmindate);
                        $('#UD_Payment_Forperiod').datepicker("option","maxDate",depositmaxdate);
                    }
                    if(paymenttype=='DEPOSIT REFUND')
                    {
                        var depositmindate=DBstartdate_dateConversion(end_date);
                        var depositmaxdate=DBenddate_dateConversion(end_date);
                        $('#UD_Payment_Forperiod').datepicker("option","minDate",depositmindate);
                        $('#UD_Payment_Forperiod').datepicker("option","maxDate",depositmaxdate);
                    }
                    $('#UD_Payment_Forperiod').val(updationrow[0].PD_FOR_PERIOD);
                    $('#Payment_Updation_form').show();
                    $('.preloader').hide();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });

        });
        function DBfrom_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[0],inputdate[1]-1,inputdate[2]);
            return newunitstartdate;
        }
        function DBstartdate_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[0],inputdate[1]-1);
            return newunitstartdate;
        }
        function DBenddate_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[0],inputdate[1],0);
            return newunitstartdate;
        }
        $(document).on('change','.LPchange',function() {
            $('.preloader').show();
            var lp=$('#UD_Payment_Leaseperiod').val();
            var paymenttype=$('#UD_Payment_Paymenttype').val();
            if(lp!='SELECT' && paymenttype!='SELECT')
            {
                for (var i = 0; i < LpDetails.length; i++)
                {
                    var data=LpDetails[i];
                    if(data.CLP_PRETERMINATE_DATE!=null && data.CLP_PRETERMINATE_DATE!='')
                    {  var enddate =  data.CLP_PRETERMINATE_DATE; }
                    else
                    { enddate =  data.CLP_ENDDATE}
                    if(data.CED_REC_VER==lp)
                    {
                        var start_date=data.CLP_STARTDATE;
                        var end_date=enddate;
                    }
                }
                if(paymenttype=='PAYMENT' || paymenttype=='CLEANING FEE')
                {
                    var startdate=DBfrom_dateConversion(start_date);
                    var enddate=DBfrom_dateConversion(end_date);
                    $('#UD_Payment_Forperiod').datepicker("option","minDate",startdate);
                    $('#UD_Payment_Forperiod').datepicker("option","maxDate",enddate);
                }
                if(paymenttype=='DEPOSIT' || paymenttype=='PROCESSING FEE')
                {
                    var depositmindate=DBstartdate_dateConversion(start_date);
                    var depositmaxdate=DBenddate_dateConversion(start_date);
                    $('#UD_Payment_Forperiod').datepicker("option","minDate",depositmindate);
                    $('#UD_Payment_Forperiod').datepicker("option","maxDate",depositmaxdate);
                }
                if(paymenttype=='DEPOSIT REFUND')
                {
                    var depositmindate=DBstartdate_dateConversion(end_date);
                    var depositmaxdate=DBenddate_dateConversion(end_date);
                    $('#UD_Payment_Forperiod').datepicker("option","minDate",depositmindate);
                    $('#UD_Payment_Forperiod').datepicker("option","maxDate",depositmaxdate);
                }
            }
            $('.preloader').hide();
        });
        $(document).on('change','.PU_Validation',function() {
            paymentform_upadation()
        });
        function paymentform_upadation()
        {
            if($('#UD_Payment_Paymenttype').val()!='SELECT' && $('#UD_Payment_Leaseperiod').val()!='SELECT' && $('#UD_Payment_Forperiod').val()!='' && $('#UD_Payment_Paiddate').val()!='' && $('#UD_Payment_Amount').val()!='')
            {
                $('#UD_Btn_Payment_Updation').removeAttr("disabled");
            }
            else
            {
                $('#UD_Btn_Payment_Updation').attr('disabled','disabled');
            }
        }
        $(document).on('click','#UD_Btn_Payment_Updation',function() {
            $('.preloader').show();
            var FormElements=$('#Updation_form').serialize();
            var searchoption=$('#Payment_SRC_SearchOption').val();
            $("#Payment_src_btn_search").attr("disabled", "disabled");
            if(searchoption==2)
            {
                var unit=$('#Payment_SRC_Uintsearch').val();
                var Unit=unit;var Customer='';var FromDate='';var Todate='';var Fromamount='';var Toamount='';
                var headervalue="DETAILS OF SELECTED UNIT : "+unit;
                var EMPTY_headervalue="NO DETAILS OF SELECTED UNIT : "+unit;
            }
            if(searchoption==3)
            {
                var unit=$('#Payment_SRC_unit').val();
                var customer=$('#Payment_SRC_Customer').val();
                extractunitno=unit;
                extractcustomername=customer;
                var Unit=unit;var Customer=customer;var FromDate='';var Todate='';var Fromamount='';var Toamount='';
                customer=customer.replace('_',' ');
                headervalue="DETAILS OF SELECTED UNIT : "+unit+" AND CUSTOMER NAME : "+customer;
                var EMPTY_headervalue="NO DETAILS OF SELECTED UNIT : "+unit+" AND CUSTOMER NAME : "+customer;
            }
            if(searchoption==4)
            {
                var fromdate=$('#Payment_SRC_FP_fromdate').val();
                var todate=$('#Payment_SRC_FP_todate').val();
                var Unit='';var Customer='';var FromDate=fromdate;var Todate=todate;var Fromamount='';var Toamount='';
                headervalue="DETAILS OF SELECTED FOR PERIOD DATE RANGE : "+fromdate+" TO : "+todate;
                var EMPTY_headervalue="NO DETAILS OF SELECTED FOR PERIOD DATE RANGE : "+fromdate+" TO : "+todate;
            }
            if(searchoption==5)
            {
                var fromdate=$('#Payment_SRC_PD_fromdate').val();
                var todate=$('#Payment_SRC_PD_todate').val();
                var Unit='';var Customer='';var FromDate=fromdate;var Todate=todate;var Fromamount='';var Toamount='';
                headervalue="DETAILS OF SELECTED PAID DATE RANGE : "+fromdate+" TO : "+todate;
                EMPTY_headervalue="NO DETAILS OF SELECTED PAID DATE RANGE : "+fromdate+" TO : "+todate;
            }
            if(searchoption==6)
            {
                var unit=$('#Payment_SRC_AR_Uint').val();
                var fromdate=$('#Payment_SRC_AR_fromdate').val();
                var todate=$('#Payment_SRC_AR_todate').val();
                var fromamount=$('#Payment_SRC_AR_fromamount').val();
                var toamount=$('#Payment_SRC_AR_toamount').val();
                var Unit=unit;var Customer='';var FromDate=fromdate;var Todate=todate;var Fromamount=fromamount;var Toamount=toamount;
                headervalue="DETAILS OF SELECTED UNIT : "+unit+" AND FOR PERIOD : "+fromdate+" TO : "+todate+" AND AMOUNT : "+fromamount+" TO : "+toamount;
                EMPTY_headervalue="NO DETAILS OF SELECTED UNIT : "+unit+" AND FOR PERIOD : "+fromdate+" TO : "+todate+" AND AMOUNT : "+fromamount+" TO : "+toamount;
            }
            $.ajax({
                type: "POST",
                url: controller_url+"PaymentUpdationDetails",
                data:FormElements+"&Unit="+unit+"&Customer="+Customer+"&FromDate="+fromdate+"&Todate="+todate+"&Fromamount="+fromamount+"&Toamount="+toamount+"&Option="+searchoption,
                success: function(data){
                    var valuearray=JSON.parse(data);
                    if(valuearray[0]=='' || valuearray[0]==null)
                    {
                        show_msgbox("PAYMENT SEARCH AND UPDATE",Errormsg[3].EMC_DATA,"success",false);
                    }
                    else
                    {
                        show_msgbox("PAYMENT SEARCH AND UPDATE",valuearray[0],"success",false);
                    }
                    if(valuearray[1].length!=0)
                    {
                        $('#tableheader').text(headervalue);
                        PaymentDataTable(valuearray[1]);
                        if (searchoption == 3) {
                            $('#Paymeny_Extract_btn').show();
                        }
                        else {
                            $('#Paymeny_Extract_btn').hide();
                        }
                        $("html, body").animate({scrollTop: $(document).height()}, "slow");
                    }
                    $('#Payment_Updation_form').hide();
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
        var deleterowid;
        $(document).on('click','.Payment_removebutton',function() {
            var id=this.id;
            var SplittedData=id.split('_');
            var Rowid=SplittedData[1];
            deleterowid=Rowid;
            show_msgbox("PAYMENT SEARCH AND UPDATE",Errormsg[6].EMC_DATA,"success","delete");
        });
        $(document).on('click','.deleteconfirm',function(){
            $('.preloader').show();
            var searchoption=$('#Payment_SRC_SearchOption').val();
            $("#Payment_src_btn_search").attr("disabled", "disabled");
            if(searchoption==2)
            {
                var unit=$('#Payment_SRC_Uintsearch').val();
                var Unit=unit;var Customer='';var FromDate='';var Todate='';var Fromamount='';var Toamount='';
                var headervalue="DETAILS OF SELECTED UNIT : "+unit;
                var EMPTY_headervalue="NO DETAILS OF SELECTED UNIT : "+unit;
            }
            if(searchoption==3)
            {
                var unit=$('#Payment_SRC_unit').val();
                var customer=$('#Payment_SRC_Customer').val();
                extractunitno=unit;
                extractcustomername=customer;
                var Unit=unit;var Customer=customer;var FromDate='';var Todate='';var Fromamount='';var Toamount='';
                customer=customer.replace('_',' ');
                headervalue="DETAILS OF SELECTED UNIT : "+unit+" AND CUSTOMER NAME : "+customer;
                var EMPTY_headervalue="NO DETAILS OF SELECTED UNIT : "+unit+" AND CUSTOMER NAME : "+customer;
            }
            if(searchoption==4)
            {
                var fromdate=$('#Payment_SRC_FP_fromdate').val();
                var todate=$('#Payment_SRC_FP_todate').val();
                var Unit='';var Customer='';var FromDate=fromdate;var Todate=todate;var Fromamount='';var Toamount='';
                headervalue="DETAILS OF SELECTED FOR PERIOD DATE RANGE : "+fromdate+" TO : "+todate;
                var EMPTY_headervalue="NO DETAILS OF SELECTED FOR PERIOD DATE RANGE : "+fromdate+" TO : "+todate;
            }
            if(searchoption==5)
            {
                var fromdate=$('#Payment_SRC_PD_fromdate').val();
                var todate=$('#Payment_SRC_PD_todate').val();
                var Unit='';var Customer='';var FromDate=fromdate;var Todate=todate;var Fromamount='';var Toamount='';
                headervalue="DETAILS OF SELECTED PAID DATE RANGE : "+fromdate+" TO : "+todate;
                EMPTY_headervalue="NO DETAILS OF SELECTED PAID DATE RANGE : "+fromdate+" TO : "+todate;
            }
            if(searchoption==6)
            {
                var unit=$('#Payment_SRC_AR_Uint').val();
                var fromdate=$('#Payment_SRC_AR_fromdate').val();
                var todate=$('#Payment_SRC_AR_todate').val();
                var fromamount=$('#Payment_SRC_AR_fromamount').val();
                var toamount=$('#Payment_SRC_AR_toamount').val();
                var Unit=unit;var Customer='';var FromDate=fromdate;var Todate=todate;var Fromamount=fromamount;var Toamount=toamount;
                headervalue="DETAILS OF SELECTED UNIT : "+unit+" AND FOR PERIOD : "+fromdate+" TO : "+todate+" AND AMOUNT : "+fromamount+" TO : "+toamount;
                EMPTY_headervalue="NO DETAILS OF SELECTED UNIT : "+unit+" AND FOR PERIOD : "+fromdate+" TO : "+todate+" AND AMOUNT : "+fromamount+" TO : "+toamount;
            }
            $.ajax({
                type: "POST",
                url: controller_url+"PaymentsDetails",
                data:"&Rowid="+deleterowid+"&Unit="+unit+"&Customer="+Customer+"&FromDate="+fromdate+"&Todate="+todate+"&Fromamount="+fromamount+"&Toamount="+toamount+"&Option="+searchoption,
                success: function(data){
                    var valuearray=JSON.parse(data);
                    if(valuearray[0]==1)
                    {
                        show_msgbox("PAYMENT SEARCH AND UPDATE",Errormsg[1].EMC_DATA,"success",false);
                        $('#Payment_Search_DataTable').hide();
                    }
                    else
                    {
                        show_msgbox("PAYMENT SEARCH AND UPDATE",data,"success",false);
                    }
                    if(valuearray[1].length!=0)
                    {
                        $('#tableheader').text(headervalue);
                        PaymentDataTable(valuearray[1]);
                        if (searchoption == 3) {
                            $('#Paymeny_Extract_btn').show();
                        }
                        else {
                            $('#Paymeny_Extract_btn').hide();
                        }
                        $("html, body").animate({scrollTop: $(document).height()}, "slow");
                    }
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('click','#UD_Btn_Payment_Deletion',function(){
            $('#Payment_Updation_form').hide();
        });
        $(document).on('click','#Paymeny_Extract_btn',function(){
            extractunitno;
            extractcustomername;
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url+"PaymentsExtractDetails",
                data:{Unit:extractunitno,Customer:extractcustomername},
                success: function(data){
                    var returnvalue=JSON.parse(data);
                    if(returnvalue=='Success')
                    {
                        show_msgbox("PAYMENT SEARCH AND UPDATE",'SELECTED CUSTOMER DETAILS EXTRACTED IN SPREADSHEET',"success",false);
                    }
                    else
                    {
                        show_msgbox("PAYMENT SEARCH AND UPDATE",returnvalue,"success",false);
                    }
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('click','#Payment_btn_pdf',function(){
            var searchoption=$('#Payment_SRC_SearchOption').val();
            if(searchoption==2)
            {
                var inputone=$('#Payment_SRC_Uintsearch').val();
                var inputtwo='';var inputthree='';var inputfour='';var inputfive='';
                var headervalue="DETAILS OF SELECTED UNIT : "+inputone;
            }
            if(searchoption==3)
            {
                var inputone=$('#Payment_SRC_unit').val();
                var customer=$('#Payment_SRC_Customer').val();
                var inputtwo=customer;var inputthree='';var inputfour='';var inputfive='';
                customer=customer.replace('_',' ');
                headervalue="DETAILS OF SELECTED UNIT : "+inputone+" AND CUSTOMER NAME : "+customer;
            }
            if(searchoption==4)
            {
                var inputone=$('#Payment_SRC_FP_fromdate').val();
                var inputtwo=$('#Payment_SRC_FP_todate').val();
                headervalue="DETAILS OF SELECTED FOR PERIOD DATE RANGE : "+inputone+" TO : "+inputtwo;
                var inputthree='';var inputfour='';var inputfive='';
            }
            if(searchoption==5)
            {
                var inputone=$('#Payment_SRC_PD_fromdate').val();
                var inputtwo=$('#Payment_SRC_PD_todate').val();
                headervalue="DETAILS OF SELECTED PAID DATE RANGE : "+inputone+" TO : "+inputtwo;
                var inputthree='';var inputfour='';var inputfive='';
            }
            if(searchoption==6)
            {
                var inputone=$('#Payment_SRC_AR_Uint').val();
                var inputtwo=$('#Payment_SRC_AR_fromdate').val();
                var inputthree=$('#Payment_SRC_AR_todate').val();
                var inputfour=$('#Payment_SRC_AR_fromamount').val();
                var inputfive=$('#Payment_SRC_AR_toamount').val();
                headervalue="DETAILS OF SELECTED UNIT : "+inputone+" AND FOR PERIOD : "+inputtwo+" TO : "+inputthree+" AND AMOUNT : "+inputfour+" TO : "+inputfive;
            }
            var pdfurl=document.location.href='<?php echo site_url('FINANCE/FINANCE/Ctrl_Finance_Payment_Search_Update/PaymentPdfCreation')?>?inputone='+inputone+'&inputtwo='+inputtwo+'&inputthree='+inputthree+'&inputfour='+inputfour+'&inputfive='+inputfive+'&header='+headervalue+'&SearchOption='+searchoption;
        });
    });
</script>
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>PAYMENT SEARCH AND UPDATE</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <div class="row form-group" style="padding-left:20px;">
                    <div class="col-md-2">
                        <label>PAYMENT SEARCH BY<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-3">
                        <SELECT class="form-control" name="Payment_SRC_SearchOption"  id="Payment_SRC_SearchOption">
                            <OPTION>SELECT</OPTION>
                        </SELECT>
                    </div>
                </div>
                <br>
                <div id="Payment_SearchformDiv">

                </div>
                <div id="Payment_Search_DataTable" class="table-responsive" hidden>
                    <h4 style="color:#498af3;" id="tableheader"></h4>
                    <input type="button" id="Payment_btn_pdf" class="btnpdf" value="PDF">
                    <section>

                    </section>
                    <div class="row form-group">
                        <div class="col-lg-offset-2 col-lg-3">
                            <input type="button" id="Paymeny_Extract_btn" class="maxbtn" value="EXTRACT">
                        </div>
                    </div>
                </div>
                <div id="tableEmptyerrormessageshow">
                    <h4 class="errormsg" id="emptytableheader"></h4>
                </div>
                <div id="Payment_Updation_form" style="padding-left:30px;"hidden>
                    <form id="Updation_form">
                        <br>
                        <h4 style="color:#498af3;">PAYMENT UPDATION</h4><br>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>UNIT<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="UD_Payment_Unit" style="max-width: 100px;color:#ffffff;" required id="UD_Payment_Unit" readonly/><input class="form-control" id="UD_Payment_id" name="UD_Payment_id" hidden>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="UD_Payment_Customer" maxlength="50" style="color:#ffffff;" required id="UD_Payment_Customer" readonly/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>LEASEPERIOD<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control LPchange PU_Validation" name="UD_Payment_Leaseperiod"  required id="UD_Payment_Leaseperiod" style="max-width: 120px;">
                                    <OPTION>SELECT</OPTION>
                                </SELECT>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>PAYMENT TYPE<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control LPchange PU_Validation" name="UD_Payment_Paymenttype" style="width:170px;" required id="UD_Payment_Paymenttype">
                                    <OPTION>SELECT</OPTION>
                                </SELECT>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>AMOUNT<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-9">
                                <div class="col-sm-3" style="padding-left: 0px;">
                                    <div class="input-group">
                                        <input type="text" id="UD_Payment_Amount" placeholder="0.00" class="form-control PU_Validation amtonly" name="UD_Payment_Amount" ><span class="input-group-addon"><input type="checkbox" class="PU_Validation" name="UD_Payment_Amountflag" id=UD_Payment_Amountflag></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>FOR PERIOD<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control PU_Validation datemandtry" name="UD_Payment_Forperiod" id="UD_Payment_Forperiod"  placeholder="For Period" style="width:150px">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>PAIDDATE<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control PU_Validation datemandtry" name="UD_Payment_Paiddate" id="UD_Payment_Paiddate"  placeholder="Paid Date" style="width:120px">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>COMMENTS<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <textarea class="form-control autogrowcomments PU_Validation" name="UD_Payment_Comments" id="UD_Payment_Comments"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-offset-2 col-lg-3">
                                <input type="button" id="UD_Btn_Payment_Updation" class="btn" value="UPDATE" disabled>           <input type="button" id="UD_Btn_Payment_Deletion" class="btn" value="RESET">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

