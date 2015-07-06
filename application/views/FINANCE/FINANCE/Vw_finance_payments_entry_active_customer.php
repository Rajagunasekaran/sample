<!--********************************************PAYMENT ENTRY FOR ACTIVE CUSTOMER*********************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 8.2 -SD:09/06/2015 ED:09/06/2015,Cleared button vlaidation ussue -->
<!--VER 0.02- SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names in ver0.02-->
<!--VER 0.01-INITIAL VERSION-SD:11/05/2015 ED:11/05/2015 in ver0.01-->
<html>
<head>
    <?php require_once('application/libraries/EI_HDR.php'); ?>
</head>
<script>
    $(document).ready(function() {
        $('#spacewidth').height('0%');
        var controller_url="<?php echo base_url(); ?>" + '/index.php/FINANCE/FINANCE/Ctrl_Finance_Payments_Entry_Active_Customer/' ;
        var t=$('#Finance_Entry_Table').DataTable({

        });
        var ActiveUnits;
        var Paymenttype;
        var ErrorMsg;
        var unitoptions;
        var paymentoptions;
        var counter=0;
        $.ajax({
            type: "POST",
            url: controller_url+"PaymentInitialDatas",
            data:{ErrorList:'2,3,92,248,309'},
            success: function(data){
                $('.preloader').hide();
                var valuearray=JSON.parse(data);
                ActiveUnits=valuearray[0];
                Paymenttype=valuearray[1];
                ErrorMsg=valuearray[2];
                unitoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < ActiveUnits.length; i++)
                {
                    var data=ActiveUnits[i];
                    unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                paymentoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < Paymenttype.length; i++)
                {
                    var data=Paymenttype[i];
                    paymentoptions += '<option value="' + data.PP_DATA + '">' + data.PP_DATA + '</option>';
                }
                InitialDataSetting()
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
                $('.preloader').hide();
            }
        });
        function InitialDataSetting()
        {
            $('#AddNewPayment').attr("disabled", "disabled");
            $('#Payment_btn_submitbutton').attr("disabled", "disabled");
            counter=counter+1;
            t.row.add( [
                '<a href="#" class="removebutton"><span style="max-width:40px !important;max-height:40px !important;color:red;text-align:center" class="glyphicon glyphicon-trash"></span></a><input type="text" class="form-control" hidden style="max-width:50px" id=vlaidation_'+counter+'>',
                '<SELECT class="form-control UnitChange Btn_validation" style="width:120px" name="Unit[]" id=Unitid_'+counter+'><OPTION>SELECT</OPTION></SELECT>',
                '<SELECT class="form-control CustomernameChange Btn_validation" disabled style="width:250px" name="Customer[]" id=Customerid_'+counter+'><OPTION>SELECT</OPTION></SELECT><div id=multiplecustomerdiv_'+counter+'></div>',
                '<SELECT class="form-control LPChange Btn_validation" disabled name="LeasePeriod[]" style="width:120px" id=Leaseperiodid_'+counter+'><OPTION>SELECT</OPTION></SELECT><input type="text" class="form-control" hidden style="max-width:50px" id=TempCustomerid_'+counter+'>',
                '<SELECT class="form-control LPChange Btn_validation" name="Payment[]" style="width:150px" id=Paymentid_'+counter+'><OPTION>SELECT</OPTION></SELECT>',
                '<div class="col-lg-6"><div class="input-group"><input type="text" name="Amount[]" class="form-control amtonly Btn_validation" style="width:120px" id=Amountid_'+counter+'><span class="input-group-addon"><input type="checkbox" class="Btn_validation" name="Amountflag[]" id=Amountflag_'+counter+'></span></div></div>',
                '<input type="text" class="form-control datepickperiod Btn_validation datemandtry" name="ForPeriod[]" style="width:150px" id=Forperiodid_'+counter+' >',
                '<input type="text" class="form-control datepickpaiddate Btn_validation datemandtry" name="PaidDate[]" style="width:120px" id=Paiddate_'+counter+' >',
                '<textarea class="form-control autogrowcomments Btn_validation" name="Comments[]" style="width:200px" id=Comments_'+counter+'></textarea>'
            ] ).draw();
            $('.autogrowcomments').autogrow({onInitialize: true});
            $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
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
                        Form_Btn_Validation(no[1]);
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
            $(".datepickpaiddate").datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true
            });
            $('.datepickpaiddate').datepicker("option","maxDate",new Date());
            $('#Unitid_'+counter).html(unitoptions);
            $('#Paymentid_'+counter).html(paymentoptions);
            $('#vlaidation_'+counter).hide();
            $('#TempCustomerid_'+counter).hide();
        }
        $('#AddNewPayment').on( 'click', function () {
            InitialDataSetting();
        });
        var CustomerNameArray=[];
        var CustomernameDetails;
        $(document).on('change','.UnitChange',function() {
            var id=this.id;
            $('.preloader').show();
            var splittedid=id.split('_');
            var unit=$('#'+id).val();
            $('#Payment_btn_submitbutton').attr("disabled", "disabled");
            $('#AddNewPayment').attr("disabled", "disabled");
            $('#customeremptymessage').text('');
            var options ='<option value="empty">SELECT</option>';
            if(unit!='SELECT')
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"ActiveCustomer",
                    data:{"UNIT":unit},
                    success: function(data){
                        $('.preloader').hide();
                        var value_array=JSON.parse(data);
                        CustomernameDetails=value_array;
                        var uniquecustomer=[];
                        for (var i = 0; i < value_array.length; i++)
                        {
                            var data=value_array[i];
                            var customername=data.CUSTOMERNAME.replace('_','  ');
                            CustomerNameArray.push(data.CUSTOMERNAME);
                            uniquecustomer.push(customername);
                        }
                        uniquecustomer=unique(uniquecustomer);
                        for(var k=0;k<uniquecustomer.length;k++)
                        {
                            var customer_name=uniquecustomer[k].replace('  ','_');
                            options += '<option value="' + customer_name + '">' + uniquecustomer[k] + '</option>';
                        }
                        $('#Customerid_'+splittedid[1]).html(options);
                        $('#multiplecustomerdiv_'+splittedid[1]).html('');
                        if(uniquecustomer.length!=0)
                        {
                            $('#Customerid_'+splittedid[1]).prop('disabled', false);
                        }
                        else
                        {
                            $('#customeremptymessage').text(ErrorMsg[2].EMC_DATA);
                            $('#Leaseperiodid_'+splittedid[1]).prop('disabled', true);
                            $('#Customerid_'+splittedid[1]).prop('disabled', true);
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
                $('#Customerid_'+splittedid[1]).prop('disabled', true);
                $('#Leaseperiodid_'+splittedid[1]).prop('disabled', true);
                $('#Customerid_'+splittedid[1]).html(options);
                $('#Leaseperiodid_'+splittedid[1]).html(options);
                $('#Forperiodid_'+splittedid[1]).val('');
                $('#multiplecustomerdiv_'+splittedid[1]).html('');
            }
        });
        $(document).on('change','.CustomernameChange',function(){
            var id=this.id;
            var splittedid=id.split('_');
            var Customer=$('#'+id).val();
            var options ='<option value="empty">SELECT</option>';
            if(Customer!='empty')
            {
                var Multiplenamearray=[];
                for(var j=0;j<CustomernameDetails.length;j++)
                {
                    var data=CustomernameDetails[j];
                    if(data.CUSTOMERNAME==Customer)
                    {
                        var customername=data.CUSTOMERNAME.replace('_','  ')+'/'+data.CUSTOMER_ID+'/'+splittedid[1];
                        Multiplenamearray.push(customername)
                    }
                }
                if(Multiplenamearray.length==1)
                {
                    var value=Multiplenamearray[0].split('/');
                    GetcustomerOldDetails(value[1],splittedid[1]);
                    $('#multiplecustomerdiv_'+splittedid[1]).html('');
                }
                else
                {
                    var appeneddata='';
                    for(var a=0;a<Multiplenamearray.length;a++)
                    {
                        var value=Multiplenamearray[a].split('/');
                        var radioname=value[0]+'-'+value[1];
                        var radiovalue=value[1]+'-'+splittedid[1];
                        appeneddata+='<div class="row form-group">';
                        appeneddata+='<div class="col-md-1">';
                        appeneddata+='</div>'
                        appeneddata+='<div class="col-md-9" >';
                        appeneddata+='<input type="radio" class="Multiplecustomer" name="Customer" id=multiplecustomer-'+a+' value='+radiovalue+'>'+radioname;
                        appeneddata+='</div></div>';
                    }
                    $('#multiplecustomerdiv_'+splittedid[1]).html(appeneddata);
                    $('#multiplecustomerdiv_'+splittedid[1]).show();
                }
            }
            else
            {
                $('#multiplecustomerdiv_'+splittedid[1]).html('');
                $('#Customerid_'+splittedid[1]).prop('disabled', false);
                $('#Leaseperiodid_'+splittedid[1]).prop('disabled',true);
                $('#Leaseperiodid_'+splittedid[1]).html(options);
                $('#Forperiodid_'+splittedid[1]).val('');
            }
        });
        $(document).on('click','.Multiplecustomer',function(){
            var radiovalue=($('input[name="Customer"]:checked').val());
            var radiovaluesplit=radiovalue.split('-');
            GetcustomerOldDetails(radiovaluesplit[0],radiovaluesplit[1]);
        });
        var LpDetailsDate=[];
        var LP=[];
        function GetcustomerOldDetails(Customerid,rowid)
        {
            $('.preloader').show();
            var unit=$('#Unitid_'+rowid).val();
            var customer=$('#Customerid_'+rowid).val();
            var options ='<option value="">SELECT</option>';
            if(customer!='SELECT')
            {
                $('#TempCustomerid_'+rowid).val(Customerid);
                $.ajax({
                    type: "POST",
                    url: controller_url+"ActiveCustomerLeasePeriod",
                    data:{"UNIT":unit,"CUSTOMERID":Customerid},
                    success: function(data){
                        var value_array=JSON.parse(data);

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
                        $('#Leaseperiodid_'+rowid).html(options);
                        if(value_array.length!=0)
                        {
                            $('#Leaseperiodid_'+rowid).prop('disabled', false);
                        }else
                        {
                            $('#Leaseperiodid_'+rowid).prop('disabled', true);
                            $('#Forperiodid_'+rowid).val('');
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
                $('#Leaseperiodid_'+rowid).html(options);
                $('#Leaseperiodid_'+rowid).prop('disabled', false);
                $('#Forperiodid_'+rowid).val('');
            }
        }
        $(document).on('change','.LPChange',function() {
            var id=this.id;
            $('.preloader').show();
            var splittedid=id.split('_');
            $('#Payment_btn_submitbutton').attr("disabled", "disabled");
            $('#AddNewPayment').attr("disabled", "disabled");
            var Leaseperiod=$('#Leaseperiodid_'+splittedid[1]).val();
            var paymenttype=$('#Paymentid_'+splittedid[1]).val();
            var unit=$('#Unitid_'+splittedid[1]).val();
            var customer=$('#TempCustomerid_'+splittedid[1]).val();
            var lp=$('#Leaseperiodid_'+splittedid[1]).val();
            var DBstartdate;
            var DBenddate;
            if(Leaseperiod!='SELECT' && Leaseperiod!='')
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"ActiveCustomerLeasePeriodDates",
                    data:{"UNIT":unit,"CUSTOMERID":customer,"RECVER":lp},
                    success: function(data){
                        $('.preloader').hide();
                        var value_array=JSON.parse(data);
                        DBstartdate=value_array[0].CLP_STARTDATE;
                        if(value_array[0].CLP_PRETERMINATE_DATE!=null && value_array[0].CLP_PRETERMINATE_DATE!='')
                        {DBenddate=value_array[0].CLP_PRETERMINATE_DATE}else{DBenddate=value_array[0].CLP_ENDDATE}
                        var startdate=DBfrom_dateConversion(DBstartdate);
                        var enddate=DBfrom_dateConversion(DBenddate);
                        if(paymenttype=='PAYMENT' || paymenttype=='CLEANING FEE')
                        {
                            var startdate=DBfrom_dateConversion(DBstartdate);
                            var enddate=DBfrom_dateConversion(DBenddate);
                            $('#Forperiodid_'+splittedid[1]).datepicker("option","minDate",startdate);
                            $('#Forperiodid_'+splittedid[1]).datepicker("option","maxDate",enddate);
                        }
                        if(paymenttype=='DEPOSIT' || paymenttype=='PROCESSING FEE')
                        {
                            var depositmindate=DBstartdate_dateConversion(DBstartdate);
                            var depositmaxdate=DBenddate_dateConversion(DBstartdate);
                            $('#Forperiodid_'+splittedid[1]).datepicker("option","minDate",depositmindate);
                            $('#Forperiodid_'+splittedid[1]).datepicker("option","maxDate",depositmaxdate);
                        }
                        if(paymenttype=='DEPOSIT REFUND')
                        {
                            var depositmindate=DBstartdate_dateConversion(DBenddate);
                            var depositmaxdate=DBenddate_dateConversion(DBenddate);
                            $('#Forperiodid_'+splittedid[1]).datepicker("option","minDate",depositmindate);
                            $('#Forperiodid_'+splittedid[1]).datepicker("option","maxDate",depositmaxdate);
                        }
                        $('#Forperiodid_'+splittedid[1]).val('');
                        Form_Btn_Validation(splittedid[1]);
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
                $('#Forperiodid_'+splittedid[1]).val('');
                $('#vlaidation_'+splittedid[1]).val(0);
                $('#AddNewPayment').attr("disabled", "disabled");
                $('#Payment_btn_submitbutton').attr("disabled", "disabled");
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
        /*************UNIQUE FUNCTION*********************/
        function unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
        $(document).on('change','.Btn_validation',function() {
            var id=this.id;
            var splittedid=id.split('_');
            Form_Btn_Validation(splittedid[1]);
        });
        $(document).on('click', '.removebutton', function () {
            var row = $(this).closest('tr');
            var rowCount = ($('#Finance_Entry_Table tr').length);
            if(rowCount>2)
            {
                $('#Finance_Entry_Table').dataTable().fnDeleteRow(row);
            }
            var rowCount = ($('#Finance_Entry_Table tr').length)-1;
            var count=0;
            for(var j=1;j<=counter;j++)
            {
                if($('#vlaidation_'+j).val()==1)
                {
                    count++;
                }
            }
            if(rowCount==count)
            {
                $('#AddNewPayment').removeAttr("disabled");
                $('#Payment_btn_submitbutton').removeAttr("disabled");
            }
            else
            {
                $('#AddNewPayment').attr("disabled", "disabled");
                $('#Payment_btn_submitbutton').attr("disabled", "disabled");
            }
        });
        function Form_Btn_Validation(rowid)
        {
            var unit=$('#Unitid_'+rowid).val();
            var customer=$('#Customerid_'+rowid).val();
            var leaseperiod=$('#Leaseperiodid_'+rowid).val();
            var Paymenttype=$('#Paymentid_'+rowid).val();
            var amount=$('#Amountid_'+rowid).val();
            var Period=$('#Forperiodid_'+rowid).val();
            var Paiddate=$('#Paiddate_'+rowid).val();
            if(unit!='SELECT' && customer!='SELECT' && leaseperiod!='SELECT' && leaseperiod!='' && Paymenttype!='SELECT' && amount!='' && Period!='' && Paiddate!='')
            {
                $('#vlaidation_'+rowid).val(1);
            }
            else
            {
                $('#vlaidation_'+rowid).val(0);
            }
            var rowCount = ($('#Finance_Entry_Table tr').length)-1;
            var count=0;
            for(var j=1;j<=counter;j++)
            {
                if($('#vlaidation_'+j).val()==1)
                {
                    count++;
                }
            }
            if(rowCount==count)
            {
                $('#AddNewPayment').removeAttr("disabled");
                $('#Payment_btn_submitbutton').removeAttr("disabled");
            }
            else
            {
                $('#AddNewPayment').attr("disabled", "disabled");
                $('#Payment_btn_submitbutton').attr("disabled", "disabled");
            }
        }
        $(document).on('click', '#Payment_btn_submitbutton', function () {
            $('.preloader').show();
            var unitarray=[];
            var Customerarray=[];
            var Leasperiodarray=[];
            var paymenttypearray=[];
            var amountarray=[];
            var forperiodarray=[];
            var paiddatearray=[];
            var commentsarray=[];
            var amountflag=[];
            for(var i=1;i<=counter;i++)
            {
                unitarray.push($('#Unitid_'+i).val());
                Customerarray.push($('#TempCustomerid_'+i).val());
                Leasperiodarray.push($('#Leaseperiodid_'+i).val());
                paymenttypearray.push($('#Paymentid_'+i).val());
                amountarray.push($('#Amountid_'+i).val());
                forperiodarray.push($('#Forperiodid_'+i).val());
                paiddatearray.push($('#Paiddate_'+i).val());
                commentsarray.push($('#Comments_'+i).val());
                var amount_flag=$('#Amountflag_'+i).is(":checked");
                if(amount_flag==true)
                {             var flag='X';          }
                else
                {              flag='';          }
                amountflag.push(flag);
            }
            $.ajax({
                type: "POST",
                url: controller_url+"PaymentEntrySave",
                data:{"UNIT":unitarray,"CUSTOMERID":Customerarray,"LP":Leasperiodarray,"PAYMENT":paymenttypearray,"AMOUNT":amountarray,"FORPERIOD":forperiodarray,"PAIDDATE":paiddatearray,"Comments":commentsarray,"FLAG":amountflag},
                success: function(data){
                    $('.preloader').hide();
                    var value_array=JSON.parse(data);
                    if(value_array=='' || value_array==null)
                    {
                        show_msgbox("PAYMENT ENTRY-ACTIVE CUSTOMER",ErrorMsg[1].EMC_DATA,"success",false);
                    }
                    else
                    {
                        show_msgbox("PAYMENT ENTRY-ACTIVE CUSTOMER",value_array,"success",false);
                    }
                    counter=0;
                    t.clear().draw();
                    InitialDataSetting();
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
        <div class="row title text-center"><h4><b>PAYMENT ENTRY-ACTIVE CUSTOMER</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <div id="Finance_Entry_Container" class="table-responsive">
                    <div><input type="button" class="maxbtn" value="ADD ROW" id="AddNewPayment" disabled></div>
                    <section>
                        <table id="Finance_Entry_Table" border=1 cellspacing='0' data-class='table'  class=' srcresult table' style="width: 1500px;">
                            <thead style="height: 15px;font-size:13px;">
                            <tr>
                                <th style='width:70px !important;vertical-align: middle'>ACTION</th>
                                <th style='width:130px !important;vertical-align: middle'>UNIT<span class="labelrequired"><em>*</em></span></th>
                                <th style='width:250px !important;vertical-align: middle'>CUSTOMER<span class="labelrequired"><em>*</em></span></th>
                                <th style='width:130px !important;vertical-align: middle'>LEASE PERIOD<span class="labelrequired"><em>*</em></span></th>
                                <th style='width:200px !important;vertical-align: middle'>PAYMENT<span class="labelrequired"><em>*</em></span></th>
                                <th style='width:80px !important;vertical-align: middle'>AMOUNT<span class="labelrequired"><em>*</em></span></th>
                                <th style='width:120px !important;vertical-align: middle'>FOR PERIOD<span class="labelrequired"><em>*</em></span></th>
                                <th style='width:100px !important;vertical-align: middle'>PAID DATE<span class="labelrequired"><em>*</em></span></th>
                                <th style='width:200px !important;vertical-align: middle'>COMMENTS</th>
                            </tr>
                            </thead>
                        </table>
                    </section>
                </div>
                <br>
                <div>
                    <label id="customeremptymessage" class="errormsg"></label>
                </div>
                <br>
                <div class="row form-group">
                    <div class="col-lg-offset-1 col-lg-2">
                        <input type="button" id="Payment_btn_submitbutton" class="btn" value="SAVE" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>