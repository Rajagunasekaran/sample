<!--********************************************OCBC*******************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 6.6 -SD:05/06/2015 ED:05/06/2015 GETTING HEADER FILE FROM LIB-->
<!--VER 0.02- SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names AND DT alignment in ver0.02-->
<!--VER 0.01-INITIAL VERSION-SD:08/05/2015 ED:08/05/2015 in ver0.01-->
<html>
<head>
    <?php require_once('application/libraries/EI_HDR.php'); ?>
</head>
<link rel="stylesheet" href ="<?php echo base_url().'bootstrap/CSS/colreorder.css'?>"  />
<script src="<?php echo base_url().'JS/colreorder.js'?>"></script>
<style>
    .calendar-off table.ui-datepicker-calendar {
        display:none !important;
    }
    body { font-size: 140%; }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 1100px;
        margin: 0 auto;
    }
</style>
<script>
    $(document).ready(function() {
        var controller_url="<?php echo base_url(); ?>" + '/index.php/FINANCE/OCBC/Ctrl_Ocbc_Ocbc/' ;
        $('#spacewidth').height('0%');
        $('.preloader').hide();
        $('#Fin_OCBC_Forperiod').datepicker( {
            changeMonth: true,      //provide option to select Month
            changeYear: true,       //provide option to select year
            showButtonPanel: true,  // button panel having today and done button
            dateFormat: 'MM-yy',    //set date format
            onClose: function(dateText, inst) {
                var month =inst.selectedMonth;
                var year = inst.selectedYear;
                $(this).datepicker('setDate', new Date(year, month, 1));//here set the date when closing.
                $(this).blur();//remove focus input box
                leaseperiodvalidation();
            },
            beforeShow:function(input, inst) {
                $(inst.dpDiv).addClass('calendar-off');
            }
        });
        $("#Fin_OCBC_Forperiod").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
        $('#Fin_OCBC_Forperiod').datepicker("option","minDate",new Date(2010,00));
        $('#Fin_OCBC_Forperiod').datepicker("option","maxDate",new Date());

        $(document).on('click','#OCBC_btn_Reset',function() {
            $("#Fin_OCBC_Forperiod").val('');
            $("#OCBC_btn_submitbutton").attr("disabled", "disabled");
            $('#ocbc_records').html('');
            $('#headerdata').html('');
            $('#emptyheaderdatadiv').hide();
            $('#emptyheaderdata').text('');
            $('#OCBC_btn_pdf').hide();

        });
        function leaseperiodvalidation()
        {

            if($('#Fin_OCBC_Forperiod').val()!="")
            {
                $("#OCBC_btn_submitbutton").removeAttr("disabled");
            }
            else
            {
                $("#OCBC_btn_submitbutton").attr("disabled", "disabled");
            }
        }
        var errormsg;
        //***********SUBMIT BUTTON ********************//
        $(document).on('click','#OCBC_btn_submitbutton',function() {
            var Forperiod=$("#Fin_OCBC_Forperiod").val();
            $('#emptyheaderdatadiv').hide();
            $('.preloader').show();
            $('#emptyheaderdatadiv').hide();
            $('#emptyheaderdata').text('');

            $("#OCBC_btn_submitbutton").attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: controller_url+"Fin_OCBC_Submit",
                data:{Period:Forperiod,ErrorList:'2,3,309'},
                success: function(data){
                    var valuearray = JSON.parse(data);
                    var value_array = valuearray[0];
                    var allacticeunits = valuearray[1];
                    var paymenttype = valuearray[2];
                    var CSVfileCount= valuearray[4];
                    if(value_array.length!=0)
                    {
                        $('#OCBC_btn_pdf').show();
                        errormsg = valuearray[3];
                        var unitoptions = '<OPTION>SELECT</OPTION>';
                        for (var i = 0; i < allacticeunits.length; i++) {
                            var data = allacticeunits[i];
                            unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                        }
                        var paymentoptions;
                        for (var i = 0; i < paymenttype.length; i++) {
                            var data = paymenttype[i];
                            paymentoptions += '<option value="' + data.PP_DATA + '">' + data.PP_DATA + '</option>';
                        }
                        sorting();
                        var ocbc_Tabledata = '<table style="width:5000px;" id="OCBC_Datatable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr>';
                        ocbc_Tabledata += "<th style='width:3%;'>ACCOUNT NUMBER</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>CURRENCY</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>PREVIOUS BALANCE</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>OPENING BALANCE</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>CLOSING BALANCE</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>LAST BALANCE</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>NO OF CREDITS</th>";
                        ocbc_Tabledata += "<th style='width:3%;' class='uk-date-column'>TRANS DATE</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>NO OF DEBITS</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>OLD BALANCE</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>D.AMOUNT</th>";
                        ocbc_Tabledata += "<th style='width:3%;' class='uk-date-column'>POST DATE</th>";
                        ocbc_Tabledata += "<th style='width:3%;' class='uk-date-column'>VALUE DATE</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>DEBIT AMOUNT</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>CREDIT AMOUNT</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>TRX CODE</th>";
                        ocbc_Tabledata += "<th style='width:4%;'>CLIENT REFERENCE	</th>";

                        ocbc_Tabledata += "<th style='width:6%;'>TRANSACTION DESC DETAILS</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>BANK REFERENCE</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>TRX TYPE	</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>UNIT</th>";
                        ocbc_Tabledata += "<th style='width:6%;'>CUSTOMER</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>LEASE PERIOD</th>";
                        ocbc_Tabledata += "<th style='width:4%;'>PAYMENT TYPE</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>AMOUNT</th>";
                        ocbc_Tabledata += "<th style='width:4%;'>FOR PERIOD</th>";
                        ocbc_Tabledata += "<th style='width:7%;'>BANKREF COMMENTS</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>SUBMIT</th>";
                        ocbc_Tabledata += "<th style='width:3%;'>DB SAVED</th>";
                        ocbc_Tabledata += "</tr></thead><tbody>";
                        var Ocbcid_Array = [];
                        for (var i = 0; i < value_array.length; i++) {
                            if (value_array[i].OBR_REFERENCE == null || value_array[i].OBR_REFERENCE == 'null') {
                                var ref = '';
                            } else {
                                ref = value_array[i].OBR_REFERENCE;
                            }
                            if (value_array[i].OBR_TRX_TYPE == null || value_array[i].OBR_TRX_TYPE == 'null') {
                                var trxtype = '';
                            } else {
                                trxtype = value_array[i].OBR_TRX_TYPE;
                            }
                            if (value_array[i].OBR_CLIENT_REFERENCE == null || value_array[i].OBR_CLIENT_REFERENCE == 'null') {
                                var clientref = '';
                            } else {
                                clientref = value_array[i].OBR_CLIENT_REFERENCE;
                            }
                            if (value_array[i].OBR_DEBIT_AMOUNT != "" && value_array[i].OBR_DEBIT_AMOUNT != "0.00") {
                                var autofillamount = value_array[i].OBR_DEBIT_AMOUNT;
                            }
                            else {
                                autofillamount = value_array[i].OBR_CREDIT_AMOUNT;
                            }
                            var ocbc_comments = clientref + ' ' + value_array[i].OBR_TRANSACTION_DESC_DETAILS + ' ' + value_array[i].OBR_BANK_REFERENCE;
                            var rowid = value_array[i].OBR_ID;
                            var unitid = 'OCBCUnitNo_' + rowid;
                            var Customerid = 'OCBCCustomerid_' + rowid;
                            var leaseperiodid = 'OCBCLeaseperiod_' + rowid;
                            var paymentid = 'OCBCPaymenttype_' + rowid;
                            var amountid = 'OCBCAmount_' + rowid;
                            var forperiodid = 'OCBCForperiod_' + rowid;
                            var Commentsid = 'OCBCComments_' + rowid;
                            var amountflag = 'Checkbox_' + rowid;
                            var btnid = 'OCBCSave_' + rowid;
                            Ocbcid_Array.push(rowid);
                            if (value_array[i].OBR_REFERENCE != 'X') {
                                ocbc_Tabledata += '<tr>' +
                                "<td style='width:3%;'>" + value_array[i].ACCOUNT + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].CURRENCY + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_PREVIOUS_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_OPENING_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_CLOSING_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_LAST_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_NO_OF_CREDITS + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_TRANS_DATE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_NO_OF_DEBITS + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_OLD_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_D_AMOUNT + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_POST_DATE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_VALUE_DATE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_DEBIT_AMOUNT + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_CREDIT_AMOUNT + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OCN_DATA + "</td>" +
                                "<td style='width:4%;'>" + clientref + "</td>" +
                                "<td style='width:6%;word-wrap:break-word;table-layout: fixed;'>" + value_array[i].OBR_TRANSACTION_DESC_DETAILS + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_BANK_REFERENCE + "</td>" +
                                "<td style='width:3%;'>" + trxtype + "</td>" +
                                "<td style='width:3%;'><SELECT class='form-control UnitChange OCBC_submitcheck' id=" + unitid + "></SELECT></td>" +
                                "<td style='width:6%;'><SELECT class='form-control CustomerChange OCBC_submitcheck' disabled id=" + Customerid + "><OPTION>SELECT</OPTION></SELECT></td>" +
                                "<td style='width:3%;'><SELECT class='form-control LPChange OCBC_submitcheck'  disabled id=" + leaseperiodid + "><OPTION>SELECT</OPTION></SELECT></td>" +
                                "<td style='width:4%;'><SELECT class='form-control LPChange OCBC_submitcheck'id=" + paymentid + "></SELECT></td>" +
                                "<td style='width:3%;'><div class='col-lg-6' id=amountflag_"+rowid+"><div class='input-group'><input type='text' style='width:100px' id=" + amountid + " class='form-control amtonly OCBC_submitcheck' value=" + autofillamount + " ><span class='input-group-addon'><input type='checkbox'  id=" + amountflag + " name=" + amountflag + "></span></div></div>"+
                                "<td style='width:4%;'><div class='col-sm-4' id=Forperiodflag_"+rowid+"><div class='input-group addon'><input type='text' style='width:150px' class='form-control datepickperiod OCBC_submitcheck datemandtry' id=" + forperiodid + " ><label  class='input-group-addon' for=" + forperiodid + "><span class='glyphicon glyphicon-calendar'></span></label></div></div>"+
                                "<td style='width:7%;'><textarea class='form-control autogrowcomments OCBC_submitcheck'  id=" + Commentsid + ">" + ocbc_comments + "</textarea></td>" +
                                "<td style='width:3%;'><input type='button' class='btn btn-primary Btn_save' value='SAVE' disabled  id=" + btnid + "></td>" +
                                "<td style='width:3%;'>" + ref + "</td></tr>";
                            }
                            else {
                                ocbc_Tabledata += '<tr>' +
                                "<td style='width:3%;'>" + value_array[i].ACCOUNT + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].CURRENCY + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_PREVIOUS_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_OPENING_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_CLOSING_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_LAST_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_NO_OF_CREDITS + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_TRANS_DATE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_NO_OF_DEBITS + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_OLD_BALANCE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_D_AMOUNT + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_POST_DATE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_VALUE_DATE + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_DEBIT_AMOUNT + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_CREDIT_AMOUNT + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OCN_DATA + "</td>" +
                                "<td style='width:4%;'>" + clientref + "</td>" +
                                "<td style='width:6%;word-break:break-all;'>" + value_array[i].OBR_TRANSACTION_DESC_DETAILS + "</td>" +
                                "<td style='width:3%;'>" + value_array[i].OBR_BANK_REFERENCE + "</td>" +
                                "<td style='width:3%;'>" + trxtype + "</td>" +
                                "<td style='width:3%;'></td>" +
                                "<td style='width:7%;'></td>" +
                                "<td style='width:3%;'></td>" +
                                "<td style='width:4%;'></td>" +
                                "<td style='width:3%;'></td>" +
                                "<td style='width:4%;'></td>" +
                                "<td style='width:7%;'></td>" +
                                "<td style='width:3%;'></td>" +
                                "<td style='width:3%;'>" + ref + "</td></tr>";
                            }
                        }
                        ocbc_Tabledata += "</body>";
                        $('#ocbc_records').html(ocbc_Tabledata);
                        var forperiod=(Forperiod+' = '+Ocbcid_Array.length).toUpperCase();
                        if((CSVfileCount==Ocbcid_Array.length)|| CSVfileCount=='')
                        {
                            var appendeddata = '<h4 style="color:green" id="headerdata">TOTAL RECORDS IN ' + forperiod + '</h4>';
                        }
                        if((CSVfileCount!=Ocbcid_Array.length)&& CSVfileCount!='')
                        {
                            appendeddata = '<h4 style="color:red" id="headerdata">TOTAL RECORDS IN ' + forperiod + '</h4>';
                        }
                        $('#headerdata').html(appendeddata);
                        for (var k = 0; k < Ocbcid_Array.length; k++) {
                            $('#OCBCUnitNo_' + Ocbcid_Array[k]).html(unitoptions)
                            $('#OCBCPaymenttype_' + Ocbcid_Array[k]).html(paymentoptions)
                            $('#OCBCPaymenttype_' + Ocbcid_Array[k]).val('PAYMENT');
                        }
                        $(".datepickperiod").datepicker(
                            {
                                changeMonth: true,
                                changeYear: true,
                                showButtonPanel: true,
                                dateFormat: 'MM-yy',
                                onClose: function (dateText, inst) {
                                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                                    $(this).datepicker('setDate', new Date(year, month, 1));
                                    var sub_id = $(this).attr('id');
                                    var no = (sub_id.toString()).split('_');
                                    submitbuttonvalidation(no[1]);
                                }
                            });
                        $(".datepickperiod").focus(function () {
                            $(".ui-datepicker-calendar").hide();
                            $("#ui-datepicker-div").position({
                                my: "center top",
                                at: "center bottom",
                                of: $(this)
                            });
                        });
                        var pix='300px';
                        $('.autogrowcomments').autogrow({onInitialize: true});
                        $(".amtonly").doValidation({rule: 'numbersonly', prop: {realpart: 5, imaginary: 2}});
                        var oTable=$('#OCBC_Datatable').DataTable({
//                            scrollY:        pix,
//                            scrollX:        true,
                            "sDom": 'Rlfrtip',
                            paging:         true,
                            "bAutoWidth": false,
                            "aoColumnDefs" : [{ "aTargets" : ["uk-date-column"] , "sType" : "uk_date"} ]
                        });

                        sorting();
                        $('#FIN_OCBC_DataTable').show();
                        $('.preloader').hide();
                        $('#emptyheaderdatadiv').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    }
                    else
                    {
                        $('#emptyheaderdatadiv').show();
                        $('#emptyheaderdata').html('NO DETAILS OF SELECTED MONTH '+Forperiod);
                        $('#FIN_OCBC_DataTable').hide();
                        $('.preloader').hide();
                    }
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
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
        }
        $(document).on('change','.UnitChange',function() {
            var id=this.id;
            var splittedid=id.split('_');
            $('.preloader').show();
            var unit=$('#'+id).val();
            if(unit!='SELECT')
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"ActiveCustomer",
                    data:{"UNIT":unit},
                    success: function(data){
                        var value_array=JSON.parse(data);
                        var options ='<option value="">SELECT</option>';
                        for (var i = 0; i < value_array.length; i++)
                        {
                            var data=value_array[i];
                            options += '<option value="' + data.CUSTOMER_ID + '">' + data.CUSTOMERNAME + '</option>';
                        }
                        $('#OCBCCustomerid_'+splittedid[1]).html(options);
                        if(value_array.length!=0)
                        {
                            $('#OCBCCustomerid_'+splittedid[1]).prop('disabled', false);
                        }
                        else
                        {
                            $('#OCBCCustomerid_'+splittedid[1]).prop('disabled', true);
                            $('#OCBCLeaseperiod_'+splittedid[1]).prop('disabled', false);
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
                $('.preloader').hide();
                var options ='<option value="">SELECT</option>';
                $('#OCBCCustomerid_'+splittedid[1]).prop('disabled', true);
                $('#OCBCLeaseperiod_'+splittedid[1]).prop('disabled', true);
                $('#OCBCCustomerid_'+splittedid[1]).html(options);
                $('#OCBCLeaseperiod_'+splittedid[1]).html(options);
                $('#OCBCForperiod_'+splittedid[1]).val('');
            }
        });
        var LpDetailsDate=[];
        var LP=[];
        $(document).on('change','.CustomerChange',function() {
            var id=this.id;
            $('.preloader').show();
            var splittedid=id.split('_');
            var unit=$('#OCBCUnitNo_'+splittedid[1]).val();
            var Customerid=$('#'+id).val();
            if(unit!='SELECT' && Customerid!='SELECT')
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"ActiveCustomerLeasePeriod",
                    data:{"UNIT":unit,"CUSTOMERID":Customerid},
                    success: function(data){
                        var value_array=JSON.parse(data);
                        var options ='<option value="">SELECT</option>';
                        for (var i = 0; i < value_array.length; i++)
                        {
                            var data=value_array[i];
                            var recver=data.CED_REC_VER;
                            if(data.CLP_PRETERMINATE_DATE!=null && data.CLP_PRETERMINATE_DATE!='')
                            {  var enddate =  data.CLP_PRETERMINATE_DATE; }
                            else
                            { enddate =  data.CLP_ENDDATE}
                            var recverdateperiod=data.CLP_STARTDATE+' --- '+enddate;
                            LpDetailsDate.push(data.CLP_STARTDATE+'/'+enddate);
                            LP.push(recver);
                            options += '<option title="'+recverdateperiod+'" value="' + data.CED_REC_VER + '">' + data.CED_REC_VER + '</option>';
                        }
                        $('#OCBCLeaseperiod_'+splittedid[1]).html(options);
                        if(value_array.length!=0)
                        {
                            $('#OCBCLeaseperiod_'+splittedid[1]).prop('disabled', false);
                        }else
                        {
                            $('#OCBCLeaseperiod_'+splittedid[1]).prop('disabled', true);
                            $('#OCBCForperiod_'+splittedid[1]).val('');
                        }
                        $('.preloader').hide();
                    },
                    error: function(data){
                        alert('error in getting'+JSON.stringify(data));
                        $('.preloader').hide();
                    }
                });
            }
        });
        $(document).on('change','.LPChange',function() {
            var id=this.id;
            var splittedid=id.split('_');
            var Leaseperiod=$('#OCBCLeaseperiod_'+splittedid[1]).val();
            var paymenttype=$('#OCBCPaymenttype_'+splittedid[1]).val();
            $('#OCBCSave_'+splittedid[1]).attr("disabled", "disabled");
            var Position=LP.indexOf(Leaseperiod);
            var LPDates=LpDetailsDate[Position];
            var datesplit=LPDates.split('/');
            var startdate=DBfrom_dateConversion(datesplit[0]);
            var enddate=DBfrom_dateConversion(datesplit[1]);
            if(paymenttype=='PAYMENT' || paymenttype=='CLEANING FEE')
            {
                var startdate=DBfrom_dateConversion(datesplit[0]);
                var enddate=DBfrom_dateConversion(datesplit[1]);
                $('#OCBCForperiod_'+splittedid[1]).datepicker("option","minDate",startdate);
                $('#OCBCForperiod_'+splittedid[1]).datepicker("option","maxDate",enddate);
            }
            if(paymenttype=='DEPOSIT' || paymenttype=='PROCESSING FEE')
            {
                var depositmindate=DBstartdate_dateConversion(datesplit[0]);
                var depositmaxdate=DBenddate_dateConversion(datesplit[0]);
                $('#OCBCForperiod_'+splittedid[1]).datepicker("option","minDate",depositmindate);
                $('#OCBCForperiod_'+splittedid[1]).datepicker("option","maxDate",depositmaxdate);
            }
            if(paymenttype=='DEPOSIT REFUND')
            {
                var depositmindate=DBstartdate_dateConversion(datesplit[1]);
                var depositmaxdate=DBenddate_dateConversion(datesplit[1]);
                $('#OCBCForperiod_'+splittedid[1]).datepicker("option","minDate",depositmindate);
                $('#OCBCForperiod_'+splittedid[1]).datepicker("option","maxDate",depositmaxdate);
            }
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
        /**********************OCBC RECORD SUBMIT BUTTON VALIDATION******************************/
        $(document).on("change",'.OCBC_submitcheck', function (){
            var sub_id=$(this).attr('id');
            var no=(sub_id.toString()).split('_');
            submitbuttonvalidation(no[1]);
        });
        function submitbuttonvalidation(ocbcid)
        {
            var unit = $('#OCBCUnitNo_'+ocbcid).val();
            var customer = $('#OCBCCustomerid_'+ocbcid).val();
            var recver=$('#OCBCLeaseperiod_'+ocbcid).val();
            var payment = $('#OCBCPaymenttype_'+ocbcid).val();
            var amount = $('#OCBCAmount_'+ocbcid).val();
            var forperiod = $('#OCBCForperiod_'+ocbcid).val();
            if((unit!="SELECT")&&(customer!="SELECT")&&(payment!="SELECT")&&(amount!="")&&(forperiod!="")&&(customer!="")&&(unit!="")&&(recver!="SELECT")&&(recver!=""))
            {
                $('#OCBCSave_'+ocbcid).removeAttr("disabled");
            }
            else
            {
                $('#OCBCSave_'+ocbcid).attr("disabled", "disabled");
            }
        }
        $(document).on('click','.Btn_save',function() {
            var id=this.id;
            $('.preloader').show();
            var splittedid=id.split('_');
            var ocbcid=splittedid[1];
            var unit = $('#OCBCUnitNo_'+ocbcid).val();
            var customer = $('#OCBCCustomerid_'+ocbcid).val();
            var recver=$('#OCBCLeaseperiod_'+ocbcid).val();
            var payment = $('#OCBCPaymenttype_'+ocbcid).val();
            var amount = $('#OCBCAmount_'+ocbcid).val();
            var forperiod = $('#OCBCForperiod_'+ocbcid).val();
            var Comments = $('#OCBCComments_'+ocbcid).val();
            var amountflag=$('#Checkbox_'+ocbcid).is(":checked");
            if(amountflag==true)
            {
                amountflag='X';
            }
            else
            {
                amountflag='';
            }
            $.ajax({
                type: "POST",
                url: controller_url+"OCBC_Record_Save",
                data:{"ID":ocbcid,"UNIT":unit,"CUSTOMERID":customer,"LP":recver,"PAYMENT":payment,"AMOUNT":amount,"FORPERIOD":forperiod,"COMMENTS":Comments,"FLAG":amountflag},
                success: function(data){
                    var value_array=JSON.parse(data);
                    if(value_array==null || value_array=='')
                    {
                        show_msgbox("OCBC",errormsg[1].EMC_DATA,"success",false);
                        $('#OCBCUnitNo_'+ocbcid).hide();
                        $('#OCBCCustomerid_'+ocbcid).hide();
                        $('#OCBCLeaseperiod_'+ocbcid).hide();
                        $('#OCBCPaymenttype_'+ocbcid).hide();
                        $('#OCBCAmount_'+ocbcid).hide();
                        $('#OCBCForperiod_'+ocbcid).hide();
                        $('#OCBCComments_'+ocbcid).hide();
                        $('#Checkbox_'+ocbcid).hide();
                        $('#OCBCSave_'+ocbcid).hide();
                        $('#amountflag_'+ocbcid).hide();
                        $('#Forperiodflag_'+ocbcid).hide();
                    }
                    else
                    {
                        show_msgbox("OCBC",value_array,"success",false);
                    }
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('click','#OCBC_btn_pdf',function(){
            var Forperiod=$("#Fin_OCBC_Forperiod").val();
            var pdfurl=document.location.href='<?php echo site_url('FINANCE/OCBC/Ctrl_Ocbc_Ocbc/OCBCPdfCreation')?>?Period='+Forperiod;
        });
    });
</script>
<body>
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>OCBC</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <div class="row form-group" style="padding-left:20px;">
                    <div class="col-md-2">
                        <label>SELECT THE MONTH<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control datemandtry" name="Fin_OCBC_Forperiod" id="Fin_OCBC_Forperiod"  placeholder="For Period">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-offset-2 col-lg-3">
                        <input type="button" id="OCBC_btn_submitbutton" class="btn" value="SUBMIT" disabled>    <input type="button" id="OCBC_btn_Reset" class="btn" value="RESET">
                    </div>
                </div>
                <br>
                <div id="FIN_OCBC_DataTable" class="table-responsive" hidden>
                    <div id="headerdata"></div><h3 style="color:green" id="headerdata"></h3>
                    <input type="button" id="OCBC_btn_pdf" class="btnpdf" value="PDF">
                    <section id="ocbc_records">
                    </section>
                </div>
                <div id="emptyheaderdatadiv"></div><h3 class="errormsg" id="emptyheaderdata"></h3>

            </div>
        </div>
    </div>
</div>
</body>