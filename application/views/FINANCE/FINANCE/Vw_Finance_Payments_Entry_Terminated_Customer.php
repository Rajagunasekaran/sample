<!--********************************************PAYMENT ENTRY FOR TERMINATED CUSTOMER*********************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 0.02- SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names in ver0.02-->
<!--VER 0.01-INITIAL VERSION-SD:15/05/2015 ED:15/05/2015 in ver0.01-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<script>
    $(document).ready(function()
    {
        var controller_url="<?php echo base_url(); ?>" + '/index.php/FINANCE/FINANCE/Ctrl_Finance_Payments_Entry_Terminated_Customer/' ;
        $('#FIN_Payment_id').hide();
        $('.autogrowcomments').autogrow({onInitialize: true});
        $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $("#FIN_TER_Payment_Paiddate").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        $('#FIN_TER_Payment_Forperiod').datepicker( {
            changeMonth: true,      //provide option to select Month
            changeYear: true,       //provide option to select year
            showButtonPanel: true,  // button panel having today and done button
            dateFormat: 'MM-yy',    //set date format
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));//here set the date when closing.
                $(this).blur();//remove focus input box
                Submitbuttonvalidation();
            }
        });
        $("#FIN_TER_Payment_Forperiod").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
        var CCRE_d = new Date();
        var CCRE_year = CCRE_d.getFullYear()+2;
        var changedmonth=new Date(CCRE_d.setFullYear(CCRE_year));
        $('#FIN_TER_Payment_Forperiod').datepicker("option","maxDate",changedmonth);
        $('#FIN_TER_Payment_Paiddate').datepicker("option","maxDate",new Date());
        var Message;
        var allunitdetails;
        $.ajax({
            type: "POST",
            url: controller_url+"PaymentInitialDatas",
            data:{"ErrorList":'2,3,92,248,309'},
            success: function(data){
                $('.preloader').hide();
                var value_array=JSON.parse(data);
                allunitdetails=value_array[0];
                Message=value_array[2];
                if(allunitdetails.length!=0)
                {
                    var paymenttype=value_array[1];
                    var options ='<option value="SELECT">SELECT</option>';
                    var allunitarray=[];
                    for (var i = 0; i < allunitdetails.length; i++)
                    {
                        allunitarray.push(allunitdetails[i].UNIT_NO);
                    }
                    allunitarray=unique(allunitarray);
                    for (var j = 0; j < allunitarray.length; j++)
                    {
                        options += '<option value="'+allunitarray[j]+'">' +allunitarray[j]+ '</option>';
                    }
                    $('#FIN_TER_Payment_Unit').html(options);
                    var paymentoptions='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < paymenttype.length; i++)
                    {
                        var data=paymenttype[i];
                        paymentoptions += '<option value="' + data.PP_DATA + '">' + data.PP_DATA + '</option>';
                    }
                    $('#FIN_TER_Payment_Paymenttype').html(paymentoptions);
                    $('#Form_ErrorMessage').html('');
                    $('.preloader').hide();
                }
                else
                {
                    var appeneddata='<h4 class="errormsg">'+Message[3].EMC_DATA+'</h4>';
                    $('#Form_ErrorMessage').html(appeneddata);
                    $('#FIN_TER_PaymentEntry_form').hide();
                }
                $('.preloader').hide();
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
        var allcustomer=[];
        var allcustomerdetails=[];
        $(document).on('change','#FIN_TER_Payment_Unit',function() {
            var unit=$('#FIN_TER_Payment_Unit').val();
            allcustomer=[];
            allcustomerdetails=[];
            if(unit!='SELECT')
            {
                for (var i = 0; i < allunitdetails.length; i++)
                {
                    if(allunitdetails[i].UNIT_NO==unit)
                    {
                        allcustomerdetails.push(allunitdetails[i].CUSTOMER_FIRST_NAME+' '+allunitdetails[i].CUSTOMER_LAST_NAME+'-'+allunitdetails[i].CUSTOMER_ID);
                        allcustomer.push(allunitdetails[i].CUSTOMER_FIRST_NAME+' '+allunitdetails[i].CUSTOMER_LAST_NAME);
                    }
                }
                allcustomer=unique(allcustomer);
                allcustomerdetails=unique(allcustomerdetails);
                var options='<OPTION>SELECT</OPTION>';
                for (var j = 0; j < allcustomer.length; j++)
                {
                    options += '<option value="'+allcustomer[j]+'">' +allcustomer[j]+ '</option>';
                }
                $('#FIN_TER_Payment_Customer').html(options);
                $('#FIN_TER_Payment_Customer').removeAttr("disabled");
            }
            else
            {

                $('#FIN_TER_Payment_Customer').prop('disabled',true);
                $('#FIN_TER_Payment_Leaseperiod').prop('disabled',true);
            }
        });
        $(document).on('change','#FIN_TER_Payment_Customer',function() {
            var Customer=$('#FIN_TER_Payment_Customer').val();
            $('#FIN_TER_Payment_Leaseperiod').prop('disabled',true);
            $('#multiplecustomerdiv').html('');
            if(Customer!='SELECT')
            {
                var alluniquecustomer=[];
                for (var i = 0; i < allcustomerdetails.length; i++)
                {
                    var data=allcustomerdetails[i].split('-');
                    if(data[0]==Customer)
                    {
                        alluniquecustomer.push(allcustomerdetails[i]);
                    }
                }

                if(alluniquecustomer.length==1)
                {
                    var value=alluniquecustomer[0].split('-');
                    GetcustomerOldDetails(value[1]);
                    $('#multiplecustomerdiv').html('');
                }
                else
                {
                    var appeneddata='';
                    for(var a=0;a<alluniquecustomer.length;a++)
                    {
                        var value=alluniquecustomer[a].split('-');
                        var radioname=alluniquecustomer[a];
                        var radiovalue=value[1];
                        appeneddata+='<div class="row form-group">';
                        appeneddata+='<div class="col-md-3">';
                        appeneddata+='</div>'
                        appeneddata+='<div class="col-md-3" >';
                        appeneddata+='<input type="radio" class="Multiplecustomer" name="Customer" id=multiplecustomer-'+a+' value='+radiovalue+'>'+radioname;
                        appeneddata+='</div></div>';
                    }
                    $('#multiplecustomerdiv').html(appeneddata);
                    $('#multiplecustomerdiv').show();
                }
            }
        });
        $(document).on('click','.Multiplecustomer',function(){
            var radiovalue=($('input[name="Customer"]:checked').val());
            GetcustomerOldDetails(radiovalue);
        });
        var recver=[]
        function GetcustomerOldDetails(customerid)
        {
            $('#FIN_Payment_id').val(customerid);
            var unitno=$('#FIN_TER_Payment_Unit').val();
            var customer=$('#FIN_TER_Payment_Customer').val();
            var options='<OPTION>SELECT</OPTION>';
            for(var i=0;i<allunitdetails.length;i++)
            {
                if(customerid==allunitdetails[i].CUSTOMER_ID && unitno==allunitdetails[i].UNIT_NO)
                {
                    var title=allunitdetails[i].CLP_STARTDATE+'----'+allunitdetails[i].CLP_ENDDATE;
                    options += '<option title='+title+' value="'+allunitdetails[i].CED_REC_VER+'">' +allunitdetails[i].CED_REC_VER+ '</option>';
                    recver.push(allunitdetails[i].CED_REC_VER+'/'+allunitdetails[i].CLP_STARTDATE+'/'+allunitdetails[i].CLP_ENDDATE);
                }
            }
            $('#FIN_TER_Payment_Leaseperiod').html(options);
            $('#FIN_TER_Payment_Leaseperiod').removeAttr("disabled");
        }
        $(document).on('click','.LPchange',function(){
            var LP=$('#FIN_TER_Payment_Leaseperiod').val();
            var paymenttype=$('#FIN_TER_Payment_Paymenttype').val();
            for(var i=0;i<recver.length;i++)
            {
                var data=recver[i].split('/');
                if(data[0]==LP)
                {
                    var DBstartdate= data[1];
                    var DBenddate= data[2];
                }
            }
            var startdate=DBfrom_dateConversion(DBstartdate);
            var enddate=DBfrom_dateConversion(DBenddate);
            if(paymenttype=='PAYMENT' || paymenttype=='CLEANING FEE')
            {
                var startdate=DBfrom_dateConversion(DBstartdate);
                var enddate=DBfrom_dateConversion(DBenddate);
                $('#FIN_TER_Payment_Forperiod').datepicker("option","minDate",startdate);
                $('#FIN_TER_Payment_Forperiod').datepicker("option","maxDate",enddate);
            }
            if(paymenttype=='DEPOSIT' || paymenttype=='PROCESSING FEE')
            {
                var depositmindate=DBstartdate_dateConversion(DBstartdate);
                var depositmaxdate=DBenddate_dateConversion(DBstartdate);
                $('#FIN_TER_Payment_Forperiod').datepicker("option","minDate",depositmindate);
                $('#FIN_TER_Payment_Forperiod').datepicker("option","maxDate",depositmaxdate);
            }
            if(paymenttype=='DEPOSIT REFUND')
            {
                var depositmindate=DBstartdate_dateConversion(DBenddate);
                var depositmaxdate=DBenddate_dateConversion(DBenddate);
                $('#FIN_TER_Payment_Forperiod').datepicker("option","minDate",depositmindate);
                $('#FIN_TER_Payment_Forperiod').datepicker("option","maxDate",depositmaxdate);
            }
        });
        /*************UNIQUE FUNCTION*********************/
        function unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
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
        //************************PAYMENT FORM BUTTON VALIDATION******************** //
        $(document).on('change','#FIN_TER_PaymentEntry_form',function(){
            Submitbuttonvalidation()
        });
        function Submitbuttonvalidation()
        {
            if($('#FIN_TER_Payment_Unit').val()!='SELECT' && $('#FIN_TER_Payment_Customer').val()!='SELECT' && $('#FIN_TER_Payment_Leaseperiod').val()!='SELECT' &&
                $('#FIN_TER_Payment_Paymenttype').val()!='SELECT' && $('#FIN_TER_Payment_Amount').val()!='' && $('#FIN_TER_Payment_Forperiod').val()!='' && $('#FIN_TER_Payment_Paiddate').val()!='')
            {
                $("#FIN_TER_Btn_Payment_save").removeAttr("disabled");
            }
            else
            {
                $("#FIN_TER_Btn_Payment_save").attr("disabled", "disabled");
            }
        }
        $(document).on('click','#FIN_TER_Btn_Payment_reset',function(){
            Reset();
        });
        function Reset()
        {
            $('#FIN_TER_PaymentEntry_form')[0].reset();
            $('#FIN_TER_Payment_Customer').prop('disabled',true);
            $('#FIN_TER_Payment_Leaseperiod').prop('disabled',true);
            $('#multiplecustomerdiv').html('');
            $("#FIN_TER_Btn_Payment_save").attr("disabled", "disabled");
            $('input:checkbox[name=FIN_TER_Payment_Amountflag]').attr("checked",false);
        }
        $(document).on('click','#FIN_TER_Btn_Payment_save',function(){
            $('.preloader').show();
            var FormElements=$('#FIN_TER_PaymentEntry_form').serialize();
            $.ajax({
                type: "POST",
                url: controller_url+"Term_PaymentEntry_Save",
                data:FormElements,
                success: function(data){
                    var returnvalue=JSON.parse(data);
                    if(returnvalue==null || returnvalue=="" || returnvalue=='null' || returnvalue==' ')
                    {
                        show_msgbox("PAYMENTS ENTRY-TERMINATED CUSTOMER",Message[1].EMC_DATA,"success",false);
                    }
                    else
                    {
                        show_msgbox("PAYMENTS ENTRY-TERMINATED CUSTOMER",returnvalue,"success",false);
                    }
                    Reset();
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        });
    });
</script>
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>PAYMENTS ENTRY-TERMINATED CUSTOMER</b></h4></div>
        <div class ='row content'>
            <div id="Form_ErrorMessage">
            </div>
            <form id="FIN_TER_PaymentEntry_form" class="form-horizontal" role="form">
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>UNIT<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="FIN_TER_Payment_Unit" style="max-width: 120px;" required id="FIN_TER_Payment_Unit">
                                <OPTION>SELECT</OPTION></SELECT><input type="hidden" class="form-control" id="FIN_Payment_id" name="FIN_Payment_id">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="FIN_TER_Payment_Customer"  id="FIN_TER_Payment_Customer" disabled >
                                <OPTION>SELECT</OPTION></SELECT>
                        </div>
                    </div>
                    <div id="multiplecustomerdiv" hidden>

                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>LEASEPERIOD<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control LPchange " name="FIN_TER_Payment_Leaseperiod"  required id="FIN_TER_Payment_Leaseperiod" style="max-width: 120px;" disabled>
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>PAYMENT TYPE<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control LPchange" name="FIN_TER_Payment_Paymenttype"  required id="FIN_TER_Payment_Paymenttype">
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
                                    <input type="text" id="FIN_TER_Payment_Amount" placeholder="0.00" class="form-control amtonly" name="FIN_TER_Payment_Amount" ><span class="input-group-addon"><input type="checkbox" class="Btn_validation" name="Amountflag[]" id=Amountflag_'+counter+'></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>FOR PERIOD<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control datemandtry" name="FIN_TER_Payment_Forperiod"  required id="FIN_TER_Payment_Forperiod" style="max-width: 150px;" placeholder="For Period">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>PAIDDATE<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control datemandtry" name="FIN_TER_Payment_Paiddate"  required id="FIN_TER_Payment_Paiddate" style="max-width: 150px;" placeholder="Paid Date">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>COMMENTS<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <textarea class="form-control autogrowcomments" name="FIN_TER_Payment_Comments" id="FIN_TER_Payment_Comments" placeholder="Comments"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-offset-2 col-lg-3">
                            <input type="button" id="FIN_TER_Btn_Payment_save" class="btn" value="SAVE" disabled>           <input type="button" id="FIN_TER_Btn_Payment_reset" class="btn" value="RESET">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<!--BODY TAG END-->