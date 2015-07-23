<!--********************************************OCBC BANK TT ENTRY*******************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 15.1 -SD:09/07/2015 ED:09/07/2015 SAVE POINT-->
<!--VER 6.6 -SD:05/06/2015 ED:05/06/2015 GETTING HEADER FILE FROM LIB-->
<!--VER 0.02- SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names in ver0.02-->
<!--VER 0.01-INITIAL VERSION-SD:18/05/2015 ED:18/05/2015 in ver0.01-->
<?php
require_once('application/libraries/EI_HDR.php');
?>

<style>
    .errormsg{
        padding-top:12px;
    }
</style>
<script>
    $(document).ready(function(){
        $('.preloader').show();
        var controller_url="<?php echo base_url(); ?>" + '/index.php/FINANCE/OCBC/Ctrl_Ocbc_Banktt_Entry/' ;
        $(".date-picker").datepicker({
            dateFormat:"dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        $(".date-picker").on("change", function () {
            var id = $(this).attr("id");
            var val = $("label[for='" + id + "']").text();
            $("#msg").text(val + " changed");
        });
        var max = 250;
        $('#banktt_ta_address').keypress(function(e) {
            if (e.which < 0x20) {
                // e.which < 0x20, then it's not a printable character
                // e.which === 0 - Not a character
                return;     // Do nothing
            }
            if (this.value.length == max) {
                e.preventDefault();
            } else if (this.value.length > max) {
                // Maximum exceeded
                this.value = this.value.substring(0, max);
            }
        });
        $('textarea').autogrow({onInitialize: true});
        $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $(".alphanumonly").doValidation({rule:'alphanumeric'});
        $(".uppercase").doValidation({rule:'general'});
        $(".autosize").doValidation({rule:'general',prop:{whitespace:true,autosize:true}});
        $(".compautosize").doValidation({rule:'general',prop:{autosize:true}});
        $(".numonly").doValidation({rule:'numbersonly'});
        $("#banktt_tb_accno").doValidation({rule:'numbersonly',prop:{realpart:25,leadzero:true}});
        $("#banktt_tb_bankcode").doValidation({rule:'numbersonly',prop:{realpart:4,leadzero:true}});
        $("#banktt_tb_branchcode").doValidation({rule:'numbersonly',prop:{realpart:3,leadzero:true}});

        $('#banktt_customer').hide();
        $('#banktt_model').hide();
        $('#banktt_tb_bankcode').val('');
        $('#banktt_bankcode').hide().val('');
        $('#banktt_tb_branchcode').val('');
        $('#banktt_branchcode').hide().val('');
        $('#banktt_tb_swiftcode').val('');
        $('#banktt_swiftcode').hide().val('');
        $('#banktt_chargeto').hide();
        $('#banktt_errormsgcustomer').hide();
        $('#banktt_modelnameerrormsg').hide();
        $('#banktt_date').datepicker("option","minDate",new Date(new Date().getFullYear()-1,new Date().getMonth(),new Date().getDate()));
        $('#banktt_date').datepicker("option","maxDate",new Date());

        // initial data
        var type;
        var model;
        var unit;
        var charges;
        var errormsg;
        $.ajax({
            type: "POST",
            url: controller_url+"Initialdata",
            success: function(data){
                var value=JSON.parse(data);
                $('.preloader').hide();
                type=value[0];
                model=value[1];
                unit=value[2];
                charges=value[3];
                errormsg=value[4];
                if(type!=''){
                    $('#banktt_lb_transtype').append($('<option> SELECT </option>'));
                    for(var i=0;i<type.length;i++)
                    {
                        var data=type[i].BCN_DATA;
                        $('#banktt_lb_transtype').append($('<option>').text(data).attr('value', data));
                    }
                }
                if(model!=''){
                    $('#banktt_lb_model').append($('<option> SELECT </option>'));
                    for(var j=0;j<model.length;j++)
                    {
                        var data=model[j].BTM_DATA;
                        $('#banktt_lb_model').append($('<option>').text(data).attr('value', data));
                    }
                }
                if(unit!=''){
                    $('#banktt_lb_unit').append($('<option> SELECT </option>'));
                    for(var k=0;k<unit.length;k++)
                    {
                        var data=unit[k].UNIT_NO;
                        $('#banktt_lb_unit').append($('<option>').text(data).attr('value', data));
                    }
                }
                if(charges!=''){
                    $('#banktt_lb_chargeto').append($('<option> SELECT </option>'));
                    for(var l=0;l<charges.length;l++)
                    {
                        var data=charges[l].BCN_DATA;
                        $('#banktt_lb_chargeto').append($('<option>').text(data).attr('value', data));
                    }
                }
                $('#banktt_tb_amt').prop('title',errormsg[1].EMC_DATA);
                if(unit.length==0 || unit.length=='')
                {
                    if(unit.length==0)
                    {
                        var uniterrormsg='<p><label class="errormsg">'+errormsg[5].EMC_DATA+'</label></p>';
                        $('#banktt_errormessagetable').append(uniterrormsg);
                        $('#banktt_entry_form').hide();
                        $('#banktt_errormessageform').show();
                    }
//                if(emailname==null)
//                {
//                    var emailerrormsg='<p><label class="errormsg">'+errormsg[3].EMC_DATA+'</label></p>';
//                    $('#banktt_errormessagetable').append(emailerrormsg);
//                    $('#banktt_entry_form').hide();
//                    $('#banktt_errormessageform').show();
//                }
                }
                else
                {
                    $('#banktt_entry_form').show();
                }
            }
        });
        //UNIQUE FUNCTION
        function unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
        //unit chsange
        var customer=[];
        $(document).on('change','#banktt_lb_unit',function(){
            $('#banktt_errormsgcustomer').hide();
            var unitno=$('#banktt_lb_unit').val();
            if(unitno!='SELECT'){
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"Customername",
                    data:"unitno="+ unitno,
                    success: function(data){
                        $('.preloader').hide();
                        var value=JSON.parse(data);
                        customer=value;
                        var customername_array=[];
                        for(var k=0;k<customer.length;k++)
                        {
                            customername_array.push(customer[k].CUSTOMER_NAME);
                        }
                        customername_array=unique(customername_array);
                        $('#banktt_lb_customer').append($('<option> SELECT </option>'));
                        if(customer.length!=0){
                            var customeroptions='<OPTION>SELECT</OPTION>';
                            for (var i = 0; i < customername_array.length; i++)
                            {
                                var data=customername_array[i];
                                customeroptions += '<option value="' + data +'">' + data + '</option>';
                            }
                            $('#banktt_lb_customer').html(customeroptions);
                            $('#banktt_errormsgcustomer').hide();
                            $('#banktt_customer').show();
                            $('#banktt_lb_customer').val('SELECT').show();
                        }
                        else{
                            var msg=errormsg[4].EMC_DATA.replace('[UNIT NO]',unitno);
                            $('#banktt_errormsgcustomer').text(msg).show();
                            $('#banktt_customer').hide();
                            $('#banktt_lb_customer').val('SELECT').hide();
                        }
                    }
                });
            }
            else{
                $('#banktt_modelnameerrormsg').hide();
                $('#banktt_customer').hide();
                $('#banktt_lb_customer').val('SELECT').hide();
                $("#banktt_submitbutton").attr("disabled", "disabled");
            }
        });
        $(document).on('change','#banktt_lb_customer',function(){
            var selectedcustomer=$('#banktt_lb_customer').val();
            var custonmername_array=[];
            for(var i=0;i<customer.length;i++)
            {
                if(selectedcustomer==customer[i].CUSTOMER_NAME)
                {
                    custonmername_array.push(customer[i].CUSTOMER_NAME+'-'+customer[i].CUSTOMER_ID)
                }
            }
            if(custonmername_array.length==1)
            {
                var value=custonmername_array[0].split('-');
                GetcustomerOldDetails(value[1]);
                $('#multiplecustomerdiv').html('');
            }
            else
            {
                var appeneddata='';
                for(var a=0;a<custonmername_array.length;a++)
                {
                    var value=custonmername_array[a].split('-');
                    var radioname=custonmername_array[a];
                    var radiovalue=value[1];
                    appeneddata+='<div class="row form-group">';
                    appeneddata+='<div class="col-md-2">';
                    appeneddata+='</div>'
                    appeneddata+='<div class="col-md-6" >';
                    appeneddata+='<input type="radio" class="Multiplecustomer" name="Customer" id=multiplecustomer-'+a+' value='+radiovalue+'>'+radioname;
                    appeneddata+='</div></div>';
                }
                $('#multiplecustomerdiv').html(appeneddata);
                $('#multiplecustomerdiv').show();
            }
        });
        $(document).on('click','.Multiplecustomer',function(){
            var radiovalue=($('input[name="Customer"]:checked').val());
            GetcustomerOldDetails(radiovalue);
        });
        function GetcustomerOldDetails(id)
        {
            $('#temp_customerid').val(id)
        }
        // form reset
        $('#banktt_resetbutton').click(function(){
            BANKTT_ENTRY_reset();
        });
        function BANKTT_ENTRY_reset(){
            $("#banktt_entry_form").find('input:text, textarea').val('');
            $("#banktt_entry_form").find('select').val('SELECT');
            $('#banktt_transtype').show();
            $('#banktt_dt').show();
            $('#banktt_unit').show();
            $('#banktt_model').hide();
            $('#banktt_custref').show();
            $('#banktt_swiftcode').show();
            $('#banktt_amt').show();
            $('#banktt_chargeto').hide();
            $('#banktt_customer').hide();
            $('#banktt_bankaddress').show();
            $('#banktt_invdetails').show();
            $('#banktt_comments').show();
            $('#banktt_bankcode').hide();
            $('#banktt_branchcode').hide();
            $('#banktt_accname').show();
            $('#banktt_accno').show();
            $("#banktt_submitbutton").attr("disabled", "disabled");
            $('#banktt_errormsgcustomer').hide();
            $('#banktt_modelnameerrormsg').hide();
            $('#temp_customerid').val();
            $('#multiplecustomerdiv').html('');
        }
        // type change
        $(document).on('change','#banktt_lb_transtype',function(){
            $('#banktt_ta_address').val('');
            $('#banktt_tb_custref').val('');
            $('#banktt_ta_invdetails').val('');
            $('#banktt_ta_comments').val('');
            $('#banktt_errormsgcustomer').hide();
            $('#banktt_modelnameerrormsg').hide();
            $("#banktt_entry_form").find('input:text, textarea').val('');
            if($('#banktt_lb_transtype').val()=='TT')
            {
                $('#banktt_bankcode').hide();
                $('#banktt_branchcode').hide();
                $('#banktt_model').hide();
                $('#banktt_lb_model').val('SELECT').hide();
                $('#banktt_accno').show();
                $('#banktt_unit').show();
                $('#banktt_lb_unit').val('SELECT').show();
                $('#banktt_customer').hide();
                $('#banktt_lb_customer').val('SELECT').hide();
                $('#banktt_accname').show();
                $('#banktt_swiftcode').show();
                $('#banktt_amt').show();
                $('#banktt_dt').show();
                $('#banktt_chargeto').show();
                $('#banktt_lb_chargeto').val('SELECT').show();
                $('#banktt_modelnameerrormsg').hide();
                $("#banktt_submitbutton").attr("disabled", "disabled");
            }
            if($('#banktt_lb_transtype').val()=='GIRO')
            {
                $('#banktt_amt').show();
                $('#banktt_dt').show();
                $('#banktt_swiftcode').hide();
                $('#banktt_chargeto').hide();
                $('#banktt_lb_chargeto').val('SELECT').hide();
                $('#banktt_model').hide();
                $('#banktt_lb_model').val('SELECT').hide();
                $('#banktt_accno').show();
                $('#banktt_unit').show();
                $('#banktt_lb_unit').val('SELECT').show();
                $('#banktt_customer').hide();
                $('#banktt_lb_customer').val('SELECT').hide();
                $('#banktt_accname').show();
                $('#banktt_bankcode').show();
                $('#banktt_branchcode').show();
                $('#banktt_modelnameerrormsg').hide();
                $("#banktt_submitbutton").attr("disabled", "disabled");
            }
            if($('#banktt_lb_transtype').val()=='MODEL')
            {
                $('#banktt_accno').hide();
                $('#banktt_amt').show();
                $('#banktt_dt').show();
                $('#banktt_unit').hide();
                $('#banktt_lb_unit').val('SELECT').hide();
                $('#banktt_customer').hide();
                $('#banktt_lb_customer').val('SELECT').hide();
                $('#banktt_accname').hide();
                $('#banktt_swiftcode').hide();
                $('#banktt_chargeto').hide();
                $('#banktt_lb_chargeto').val('SELECT').hide();
                $('#banktt_bankcode').hide();
                $('#banktt_branchcode').hide();
                if(model.length!=0)
                {
                    $('#banktt_model').show();
                    $('#banktt_lb_model').val('SELECT').show();
                    $('#banktt_modelnameerrormsg').hide();

                }
                else
                {
                    $('#banktt_model').hide();
                    $('#banktt_lb_model').val('SELECT').hide();
                    $('#banktt_modelnameerrormsg').show();

                }
                $("#banktt_submitbutton").attr("disabled", "disabled");
            }
            $("html, body").animate({ scrollTop: "1050px" }, "slow");
        });

        // button validation
        $(document).on('change blur','.banktt_erntryform',function(){
            if($('#banktt_lb_transtype').val()=="TT")
            {
                if($('#banktt_date').val()!='' && $('#banktt_tb_amt').val()!='' && $('#banktt_lb_unit').val()!='SELECT'
                    && $('#banktt_lb_customer').val()!='SELECT' && $('#banktt_lb_customer').val()!='' && $('#banktt_lb_customer').val()!=undefined
                    && $('#banktt_tb_swiftcode').val()!='' && $('#banktt_lb_chargeto').val()!="SELECT"
                    && $('#banktt_tb_accno').val()!='' && $('#banktt_tb_accname').val()!='')
                {
                    $("#banktt_submitbutton").removeAttr("disabled");
                }
                else
                {
                    $("#banktt_submitbutton").attr("disabled", "disabled");
                }
            }
            else if($('#banktt_lb_transtype').val()=="GIRO")
            {
                if($('#banktt_date').val()!='' && $('#banktt_tb_amt').val()!='' && $('#banktt_lb_unit').val()!='SELECT'
                    &&  $('#banktt_lb_customer').val()!='SELECT' && $('#banktt_lb_customer').val()!='' && $('#banktt_lb_customer').val()!=undefined
                    && $('#banktt_tb_accno').val()!='' && $('#banktt_tb_accname').val()!='')
                {
                    $("#banktt_submitbutton").removeAttr("disabled");
                }
                else
                {
                    $("#banktt_submitbutton").attr("disabled", "disabled");
                }
            }
            else if($('#banktt_lb_transtype').val()=="MODEL")
            {
                if($('#banktt_date').val()!='' && $('#banktt_tb_amt').val()!='' && $('#banktt_lb_model').val()!="SELECT")
                {
                    $("#banktt_submitbutton").removeAttr("disabled");
                }
                else
                {
                    $("#banktt_submitbutton").attr("disabled", "disabled");
                }
            }
            else
            {
                $("#banktt_submitbutton").attr("disabled", "disabled");
            }
        });
        // save part
        $(document).on('click','#banktt_submitbutton',function(){
            $('.preloader').show();
            var FormElements=$('#banktt_entry_form').serialize();
            $.ajax({
                type: "POST",
                url: controller_url+"Banktt_Entry_Save",
                data:FormElements,
                success: function(data){
                    var returnvalue=JSON.parse(data);
                    if(returnvalue==1)
                    {
                        show_msgbox("BANK TT ENTRY",errormsg[2].EMC_DATA,"success",false);
                        BANKTT_ENTRY_reset();
                        $('.preloader').hide();
                    }
                    else
                    {
                        show_msgbox("BANK TT ENTRY",returnvalue,"success",false);
                        $('.preloader').hide();
                    }
                    $('.preloader').hide();
                },
                error: function(data){
                    show_msgbox("BANK TT ENTRY",'error in getting'+JSON.stringify(data),"error",false);
                }
            });
        });
    });
</script>
<!--BODY TAG START-->
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>BANK TT ENTRY</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <fieldset>
                    <form id="banktt_entry_form" name="banktt_entry_form" class="form-horizontal" role="form">
                        <div id='banktt_errormessagetable'>
                        </div>
                        <div class="form-group" id="banktt_transtype">
                            <label class=" col-sm-2">TRANSACTION TYPE<em>*</em></label>
                            <div class="col-sm-3"> <select name="banktt_lb_transtype" id="banktt_lb_transtype" class="form-control banktt_erntryform" style="max-width: 120px"></select></div>
                        </div>
                        <div class="form-group" id="banktt_modelnameerrormsg">
                            <label class=" col-sm-2"></label>
                            <div class="col-sm-3"> <label class="errormsg">NO DATA AVAILABLE IN MODEL DETAILS TABLE</label></div>
                        </div>
                        <div class="form-group" id="banktt_model">
                            <label class=" col-sm-2">MODEL NAME<em>*</em></label>
                            <div class="col-sm-3"> <select name="banktt_lb_model" id="banktt_lb_model" class="form-control banktt_erntryform"></select></div>
                        </div>
                        <div class="form-group" id="banktt_dt">
                            <label class="col-sm-2">DATE<em>*</em></label>
                            <div class="col-md-9">
                                <div class="col-sm-3" style="padding-left: 0px;">
                                    <div class="input-group addon">
                                        <input type="text" class="date-picker datemandtry form-control" name="banktt_date" id="banktt_date"  placeholder="Date"><label  class="input-group-addon" for=banktt_date><span class="glyphicon glyphicon-calendar"></span></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group" id="banktt_accname">
                            <label class=" col-sm-2">ACCOUNT NAME<em>*</em></label>
                            <div class="col-sm-3"><input type="text" name="banktt_tb_accname" id="banktt_tb_accname" placeholder="Account Name" maxlength="40" class="autosize banktt_erntryform form-control"/></div>
                        </div>
                        <div class="form-group" id="banktt_accno">
                            <label class=" col-sm-2">ACCOUNT NO<em>*</em></label>
                            <div class="col-sm-3"><input type="text" name="banktt_tb_accno" id="banktt_tb_accno" placeholder="Account No" maxlength="25" class="banktt_erntryform form-control"/></div>
                        </div>
                        <div class="form-group" id="banktt_amt">
                            <label class=" col-sm-2">AMOUNT<em>*</em></label>
                            <div class="col-sm-2"><input type="text" name="banktt_tb_amt" id="banktt_tb_amt" placeholder="Amount" maxlength="7" class="amtonly banktt_erntryform form-control"/></div>
                        </div>
                        <div class="form-group" id="banktt_unit">
                            <label class=" col-sm-2">UNIT<em>*</em></label>
                            <div class="col-sm-2"> <select name="banktt_lb_unit" id="banktt_lb_unit" class=" form-control banktt_erntryform"></select></div>
                            <label id='banktt_errormsgcustomer' class="errormsg banktt_erntryform" hidden></label>
                        </div>
                        <div class="form-group" id="banktt_customer">
                            <label class=" col-sm-2">CUSTOMER<em>*</em></label>
                            <div class="col-sm-3"> <select name="banktt_lb_customer" id="banktt_lb_customer" class="form-control banktt_erntryform"></select></div>
                            <div class="col-sm-2"><input type="hidden" name="temp_customerid" id="temp_customerid"  class="form-control"></div>
                        </div>
                        <div id="multiplecustomerdiv" hidden>

                        </div>
                        <div class="form-group" id="banktt_bankcode">
                            <label class="col-sm-2">BANK CODE</label>
                            <div class="col-sm-2"><input type="text" name="banktt_tb_bankcode" id="banktt_tb_bankcode" maxlength="4" class="alphanumeric banktt_erntryform form-control" placeholder="Bank Code"/></div>
                        </div>
                        <div class="form-group" id="banktt_branchcode">
                            <label class="col-sm-2">BRANCH CODE</label>
                            <div class="col-sm-2"><input type="text" name="banktt_tb_branchcode" id="banktt_tb_branchcode" maxlength="3" class="alphanumeric banktt_erntryform form-control" placeholder="Branch Code"/></div>
                        </div>
                        <div class="form-group" id="banktt_bankaddress">
                            <label class="col-sm-2">BANK ADDRESS</label>
                            <div class="col-sm-4"> <textarea  name="banktt_ta_address" id="banktt_ta_address" placeholder="Bank Address" rows="5" class="uppercase banktt_erntryform form-control"></textarea></div>
                        </div>
                        <div class="form-group" id="banktt_swiftcode">
                            <label class="col-sm-2">SWIFT CODE<em>*</em></label>
                            <div class="col-sm-2"><input type="text" name="banktt_tb_swiftcode" id="banktt_tb_swiftcode" maxlength="12" class="alphanumeric banktt_erntryform form-control" placeholder="Swift Code"/></div>
                        </div>
                        <div class="form-group" id="banktt_chargeto">
                            <label class=" col-sm-2">CHARGES TO<em>*</em></label>
                            <div class="col-sm-2"> <select name="banktt_lb_chargeto" id="banktt_lb_chargeto" class="form-control banktt_erntryform"></select></div>
                        </div>
                        <div class="form-group" id="banktt_custref">
                            <label class="col-sm-2">CUSTOMER REF</label>
                            <div class="col-sm-3"><input type="text" name="banktt_tb_custref" id="banktt_tb_custref" maxlength="200" class="autosize banktt_erntryform form-control" placeholder="Customer Ref"/></div>
                        </div>
                        <div class="form-group" id="banktt_invdetails">
                            <label class="col-sm-2">INV DETAILS</label>
                            <div class="col-sm-4"> <textarea  name="banktt_ta_invdetails" id="banktt_ta_invdetails" placeholder="Inv Details" maxlength="300" rows="5" class="banktt_erntryform form-control"></textarea></div>
                        </div>
                        <div class="form-group" id="banktt_comments">
                            <label class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-4"> <textarea  name="banktt_ta_comments" id="banktt_ta_comments" placeholder="Comments" maxlength="300" rows="5" class="banktt_erntryform form-control"></textarea></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-offset-2 col-lg-3">
                                <input type="button" id="banktt_submitbutton" class="btn" value="CREATE" disabled>         <input type="button" id="banktt_resetbutton" class="btn" value="RESET">
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</div>
</body>
</html>
