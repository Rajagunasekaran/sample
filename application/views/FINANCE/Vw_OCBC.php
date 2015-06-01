<html>
<head>
    <?php include 'Header.php'; ?>
</head>
<script>
    $(document).ready(function() {
        $('#spacewidth').height('0%');
        $('.preloader').hide();
        $('#Fin_OCBC_Forperiod').datepicker( {
            changeMonth: true,      //provide option to select Month
            changeYear: true,       //provide option to select year
            showButtonPanel: true,  // button panel having today and done button
            dateFormat: 'MM-yy',    //set date format
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));//here set the date when closing.
                $(this).blur();//remove focus input box
                leaseperiodvalidation();
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
        $(document).on('click','#OCBC_btn_submitbutton',function() {
            var Forperiod=$("#Fin_OCBC_Forperiod").val();
            $('.preloader').show();
            var appendeddata='<h4 style="color:#498af3" id="headerdata">DETAILS OF SELECTED MONTH : '+Forperiod+'</h4>';
            $('#headerdata').html(appendeddata);
            $("#OCBC_btn_submitbutton").attr("disabled", "disabled");
            $.ajax({
                type: "POST",
                url: '/index.php/Ctrl_Ocbc_Forms/Fin_OCBC_Submit',
                data:{Period:Forperiod,ErrorList:'2,3,309'},
                success: function(data){
                    var valuearray=JSON.parse(data);
                    var value_array=valuearray[0];
                    var allacticeunits=valuearray[1];
                    var paymenttype=valuearray[2];
                    errormsg=valuearray[3];
                    var unitoptions='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < allacticeunits.length; i++)
                    {
                        var data=allacticeunits[i];
                        unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                    }
                    var paymentoptions;
                    for (var i = 0; i < paymenttype.length; i++)
                    {
                        var data=paymenttype[i];
                        paymentoptions += '<option value="' + data.PP_DATA + '">' + data.PP_DATA + '</option>';
                    }
                    var ocbc_Tabledata="<table id='OCBC_Datatable' border=1 cellspacing='0' data-class='table'  class=' srcresult table' style='width:3800px'>";
                    ocbc_Tabledata+="<thead class='headercolor'><tr class='head' style='text-align:center'>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>ACCOUNT NUMBER</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>CURRENCY</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>PREVIOUS BALANCE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>OPENING BALANCE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>CLOSING BALANCE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>LAST BALANCE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>NO OF CREDITS</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>TRANS DATE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>NO OF DEBITS</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>OLD BALANCE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>D.AMOUNT</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>POST DATE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>VALUE DATE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>DEBIT AMOUNT</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>CREDIT AMOUNT</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>TRX CODE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>CLIENT REFERENCE	</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>TRANSACTION DESC DETAILS</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>BANK REFERENCE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>TRX TYPE	</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>UNIT</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>CUSTOMER</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>LEASE PERIOD</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>PAYMENT TYPE</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>AMOUNT</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>FOR PERIOD</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>BANKREF COMMENTS</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>SUBMIT</th>";
                    ocbc_Tabledata+="<th style='text-align:center;vertical-align: top'>DB SAVED</th>";
                    ocbc_Tabledata+="</tr></thead><tbody>";
                    var Ocbcid_Array=[];
                    for(var i=0;i<value_array.length;i++)
                    {
                        if(value_array[i].OBR_REFERENCE==null || value_array[i].OBR_REFERENCE=='null')
                        {var ref='';}else{ref=value_array[i].OBR_REFERENCE;}
                        if(value_array[i].OBR_TRX_TYPE==null || value_array[i].OBR_TRX_TYPE=='null')
                        {var trxtype='';}else{trxtype=value_array[i].OBR_TRX_TYPE;}
                        if(value_array[i].OBR_CLIENT_REFERENCE==null || value_array[i].OBR_CLIENT_REFERENCE=='null')
                        {var clientref='';}else{clientref=value_array[i].OBR_CLIENT_REFERENCE;}
                        if(value_array[i].OBR_DEBIT_AMOUNT!="" && value_array[i].OBR_DEBIT_AMOUNT!="0.00")
                        {
                            var autofillamount=value_array[i].OBR_DEBIT_AMOUNT;
                        }
                        else
                        {
                            autofillamount=value_array[i].OBR_CREDIT_AMOUNT;
                        }
                        var ocbc_comments=clientref+' '+value_array[i].OBR_TRANSACTION_DESC_DETAILS+' '+value_array[i].OBR_BANK_REFERENCE;
                        var rowid=value_array[i].OBR_ID;
                        var unitid='OCBCUnitNo_'+rowid;
                        var Customerid='OCBCCustomerid_'+rowid;
                        var leaseperiodid='OCBCLeaseperiod_'+rowid;
                        var paymentid='OCBCPaymenttype_'+rowid;
                        var amountid='OCBCAmount_'+rowid;
                        var forperiodid='OCBCForperiod_'+rowid;
                        var Commentsid='OCBCComments_'+rowid;
                        var amountflag='Checkbox_'+rowid;
                        var btnid='OCBCSave_'+rowid;
                        Ocbcid_Array.push(rowid);
                        if(value_array[i].OBR_REFERENCE!='X')
                        {
                            ocbc_Tabledata+='<tr style="text-align: center !important;">' +
                            "<td style='width:70px !important;vertical-align: middle'>"+value_array[i].ACCOUNT+"</td>" +
                            "<td style='width:70px !important;vertical-align: middle'>"+value_array[i].CURRENCY+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_PREVIOUS_BALANCE+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_OPENING_BALANCE+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_CLOSING_BALANCE+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_LAST_BALANCE+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_NO_OF_CREDITS+"</td>" +
                            "<td style='width:100px !important;vertical-align: middle'>"+value_array[i].OBR_TRANS_DATE+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_NO_OF_DEBITS+"</td>" +
                            "<td style='width:70px !important;vertical-align: middle'>"+value_array[i].OBR_OLD_BALANCE+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_D_AMOUNT+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_POST_DATE+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_VALUE_DATE+"</td>" +
                            "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_DEBIT_AMOUNT+"</td>" +
                            "<td style='width:120px !important;vertical-align: middle'>"+value_array[i].OBR_CREDIT_AMOUNT+"</td>" +
                            "<td style='width:100px !important;vertical-align: middle'>"+value_array[i].OCN_DATA+"</td>" +
                            "<td style='width:70px !important;vertical-align: middle'>"+clientref+"</td>" +
                            "<td style='width:90px !important;vertical-align: middle'>"+value_array[i].OBR_TRANSACTION_DESC_DETAILS+"</td>" +
                            "<td style='width:90px !important;vertical-align: middle'>"+value_array[i].OBR_BANK_REFERENCE+"</td>" +
                            "<td style='width:90px !important;vertical-align: middle'>"+trxtype+"</td>" +
                            "<td style='width:105px !important;vertical-align: middle'><SELECT class='form-control UnitChange OCBC_submitcheck' id="+unitid+"></SELECT></td>" +
                            "<td style='width:200px !important;vertical-align: middle'><SELECT class='form-control CustomerChange OCBC_submitcheck' disabled id="+Customerid+"><OPTION>SELECT</OPTION></SELECT></td>" +
                            "<td style='width:105px !important;vertical-align: middle'><SELECT class='form-control LPChange OCBC_submitcheck'disabled id="+leaseperiodid+"><OPTION>SELECT</OPTION></SELECT></td>" +
                            "<td style='width:150px !important;vertical-align: middle'><SELECT class='form-control LPChange OCBC_submitcheck' id="+paymentid+"></SELECT></td>" +
                            "<td style='width:100px !important;vertical-align: middle'><input type='text' value="+autofillamount+" class='form-control amtonly OCBC_submitcheck' id="+amountid+"><input type='checkbox' id="+amountflag+" name="+amountflag+"></td>" +
                            "<td style='width:145px !important;vertical-align: middle'><input type='text' class='form-control datepickperiod OCBC_submitcheck datemandtry' id="+forperiodid+"></td>" +
                            "<td style='width:250px !important;vertical-align: middle'><textarea class='form-control autogrowcomments OCBC_submitcheck' id="+Commentsid+">"+ocbc_comments+"</textarea></td>" +
                            "<td style='width:100px !important;'><input type='button' class='btn btn-primary Btn_save' value='SAVE' disabled style='max-width: 90px;text-align: center' id="+btnid+"></td>" +
                            "<td style='width:90px !important;vertical-align: middle'>"+ref+"</td></tr>";
                        }
                        else
                        {
                            ocbc_Tabledata+='<tr style="text-align: center !important;">' +
                                "<td style='width:70px !important;vertical-align: middle'>"+value_array[i].ACCOUNT+"</td>" +
                                "<td style='width:70px !important;vertical-align: middle'>"+value_array[i].CURRENCY+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_PREVIOUS_BALANCE+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_OPENING_BALANCE+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_CLOSING_BALANCE+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_LAST_BALANCE+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_NO_OF_CREDITS+"</td>" +
                                "<td style='width:100px !important;vertical-align: middle'>"+value_array[i].OBR_TRANS_DATE+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_NO_OF_DEBITS+"</td>" +
                                "<td style='width:70px !important;vertical-align: middle'>"+value_array[i].OBR_OLD_BALANCE+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_D_AMOUNT+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_POST_DATE+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_VALUE_DATE+"</td>" +
                                "<td style='width:80px !important;vertical-align: middle'>"+value_array[i].OBR_DEBIT_AMOUNT+"</td>" +
                                "<td style='width:120px !important;vertical-align: middle'>"+value_array[i].OBR_CREDIT_AMOUNT+"</td>" +
                                "<td style='width:100px !important;vertical-align: middle'>"+value_array[i].OCN_DATA+"</td>" +
                                "<td style='width:70px !important;vertical-align: middle'>"+clientref+"</td>" +
                                "<td style='width:90px !important;vertical-align: middle'>"+value_array[i].OBR_TRANSACTION_DESC_DETAILS+"</td>" +
                                "<td style='width:90px !important;vertical-align: middle'>"+value_array[i].OBR_BANK_REFERENCE+"</td>" +
                                "<td style='width:90px !important;vertical-align: middle'>"+trxtype+"</td>" +
                                "<td style='width:105px !important;vertical-align: middle'></td>" +
                                "<td style='width:200px !important;vertical-align: middle'></td>" +
                                "<td style='width:105px !important;vertical-align: middle'></td>" +
                                "<td style='width:150px !important;vertical-align: middle'></td>" +
                                "<td style='width:100px !important;vertical-align: middle'></td>" +
                                "<td style='width:145px !important;vertical-align: middle'></td>" +
                                "<td style='width:250px !important;vertical-align: middle'></td>" +
                                "<td style='width:100px !important;'></td>" +
                                "<td style='width:90px !important;vertical-align: middle'>"+ref+"</td></tr>";
                        }
                    }
                    ocbc_Tabledata+="</body>";
                    $('#ocbc_records').html(ocbc_Tabledata);
                    for(var k=0;k<Ocbcid_Array.length;k++)
                    {
                        $('#OCBCUnitNo_'+Ocbcid_Array[k]).html(unitoptions)
                        $('#OCBCPaymenttype_'+Ocbcid_Array[k]).html(paymentoptions)
                        $('#OCBCPaymenttype_'+Ocbcid_Array[k]).val('PAYMENT');
                    }
                    $(".datepickperiod").datepicker(
                        {
                            changeMonth: true,
                            changeYear: true,
                            showButtonPanel: true,
                            dateFormat: 'MM-yy',
                            onClose: function(dateText, inst) {
                                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                                $(this).datepicker('setDate', new Date(year, month, 1));
                                var sub_id=$(this).attr('id');
                                var no=(sub_id.toString()).split('_');
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
                    $('.autogrowcomments').autogrow({onInitialize: true});
                    $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
                    $('#OCBC_Datatable').DataTable( {
                        "aaSorting": [],
                        "pageLength": 10,
                        "responsive": true,
                        "sPaginationType":"full_numbers"
                    });

                    $('#FIN_OCBC_DataTable').show();
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('change','.UnitChange',function() {
         var id=this.id;
         var splittedid=id.split('_');
         $('.preloader').show();
         var unit=$('#'+id).val();
            if(unit!='SELECT')
            {
                $.ajax({
                    type: "POST",
                    url: '/index.php/Ctrl_Ocbc_Forms/ActiveCustomer',
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
                    url: '/index.php/Ctrl_Ocbc_Forms/ActiveCustomerLeasePeriod',
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
                url: '/index.php/Ctrl_Ocbc_Forms/OCBC_Record_Save',
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
                        <div class="col-md-3">
                            <label>SELECT THE MONTH<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control datemandtry" name="Fin_OCBC_Forperiod"  id="Fin_OCBC_Forperiod" style="max-width: 140px"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-offset-2 col-lg-3">
                            <input type="button" id="OCBC_btn_submitbutton" class="btn" value="SUBMIT" disabled>         <input type="button" id="OCBC_btn_Reset" class="btn" value="RESET">
                        </div>
                    </div>
                    <br>
                    <div id="FIN_OCBC_DataTable" class="table-responsive" hidden>
                        <div id="headerdata"></div><h3 style="color:#498af3" id="headerdata"><u></u></h3>
                        <section id="ocbc_records">
                        </section>
                    </div>
                </div>
            </div>
         </div>
     </div>
</body>