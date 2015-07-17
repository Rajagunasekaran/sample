<html>
<head>
    <?php require_once('application/libraries/EI_HDR.php'); ?>
</head>
<script>
    $(document).ready(function() {
        //****************FORM VALIDATION CLASSES***********************//
        $(".autosize").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
        $('#CCRE_Emailid').doValidation({rule:'email',prop:{uppercase:false,autosize:true}});
        $(".compautosize").doValidation({rule:'general',prop:{autosize:true}});
        $(".CCRE_numonlyvalidation").doValidation({rule:'numbersonly'});
        $(".CCRE_amtonlyvalidation").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        $(".CCRE_amtonlyvalidationmaxdigit").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $(".CCRE_processamtonlyvalidationmaxdigit").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
        $(".alphanumonly").doValidation({rule:'alphanumeric'});
        $("#CCRE_IntlMobile").doValidation({rule:'numbersonly',prop:{realpart:15,leadzero:true}});
        $("#CCRE_CompanyPostalCode").doValidation({rule:'numbersonly',prop:{realpart:6,leadzero:true}});
        $('.autogrowcomments').autogrow({onInitialize: true});
        $(".numonly").doValidation({rule:'numbersonly'});
        //******************CUSTOMER INITIAL DATA LODING***********************//
        $("#CCRE_Quarterly_fee").hide().val('');
        $("#CCRE_Fixedaircon_fee").hide().val('');
        $('#CCRE_CustomerId').hide();
        var controller_url="<?php echo base_url(); ?>" + '/index.php/CUSTOMER/CUSTOMER/Ctrl_Customer_Recheckin/' ;
        var timearray;
        var errormsg
        $.ajax({
            type: "POST",
            url: controller_url+"Customer_Initaildatas",
            data:{"Formname":'CustomerCreation',"ErrorList":'1,2,6,33,34,35,36,37,321,324,339,342,343,344,345,346,347,348,400,443,444,458,459,460,461'},
            success: function(data){
                $('.preloader').hide();
                var value_array=JSON.parse(data);
                timearray=value_array[5];
                errormsg=value_array[4];
                var prorated=value_array[6];
                $('#CCRE_FirstName').prop('title',errormsg[0].EMC_DATA)
                $('#CCRE_LastName').prop('title',errormsg[0].EMC_DATA)
                $('#CCRE_CompanyPostalCode').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_IntlMobile').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_Mobile').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_Officeno').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_NoticePeriod').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_Quarterly_fee').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_Fixedaircon_fee').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_ElectricitycapFee').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_Curtain_DrycleanFee').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_CheckOutCleanFee').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_DepositFee').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_ProcessingFee').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_Rent').prop('title',errormsg[1].EMC_DATA);
                $('#CCRE_lbl_emailiderrormsg').text(errormsg[6].EMC_DATA);
                $('#CCRE_lbl_mobileerrormsg').text(errormsg[10].EMC_DATA)
                $('#CCRE_lbl_intlmobileerrormsg').text(errormsg[10].EMC_DATA)
                $('#CCRE_lbl_officeerrormsg').text(errormsg[10].EMC_DATA)
                $('#CCRE_lbl_passporterrormsg').text(errormsg[11].EMC_DATA)
                $('#CCRE_lbl_epnoerrormsg').text(errormsg[12].EMC_DATA)
                $('#CCRE_lbl_postalerrormsg').text(errormsg[13].EMC_DATA)
                $('#CCRE_lbl_renterrormsg').text(errormsg[14].EMC_DATA)
                $('#CCRE_lbl_depositerrormsg').text(errormsg[15].EMC_DATA)
                $('#CCRE_lbl_processerrormsg').text(errormsg[16].EMC_DATA)
                $('#CCRE_lbl_electcaperrormsg').text(errormsg[17].EMC_DATA)
                $('#CCRE_lbl_prorated').text(prorated[0].CCN_DATA);
                $('#CCRE_lbl_waived').text(prorated[1].CCN_DATA);
                $('#CCRE_lbl_passportdateerrormsg').text(errormsg[19].EMC_DATA);
                $('#CCRE_lbl_epnodateerrormsg').text(errormsg[20].EMC_DATA);
                $('#CCRE_lbl_passportdateerrormsg').text(errormsg[24].EMC_DATA);
                $('#CCRE_lbl_ep_dateerrormsg').text(errormsg[23].EMC_DATA);

                var options ='<option value="">SELECT</option>';
                for (var i = 0; i < value_array[7].length; i++)
                {
                    var data=value_array[7][i];
                    options += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                $('#CRC_AllUnits').html(options);
                for(var i=0;i<value_array[0].length;i++)
                {
                    var data=value_array[0][i];
                    $('#CCRE_UnitNo').append($('<option>').text(data.UNIT_NO).attr('value', data.UNIT_NO));
                }
                for(var i=0;i<value_array[1].length;i++)
                {
                    var data=value_array[1][i];
                    $('#CCRE_Nationality').append($('<option>').text(data.NC_DATA).attr('value', data.NC_DATA));
                }
                for(var i=0;i<value_array[2].length;i++)
                {
                    var data=value_array[2][i];
                    $('#CCRE_MailList').append($('<option>').text(data.EL_EMAIL_ID).attr('value', data.EL_EMAIL_ID));
                }
                for(var i=0;i<value_array[3].length;i++)
                {
                    var data=value_array[3][i];
                    $('#CCRE_Option').append($('<option>').text(data.CCN_DATA).attr('value', data.CCN_ID));
                }
                for(var i=0;i<value_array[5].length-1;i++)
                {
                    var data=value_array[5][i];
                    $('#CCRE_SDStarttime').append($('<option>').text(data.TIME).attr('value', data.TIME));
                    $('#CCRE_EDStarttime').append($('<option>').text(data.TIME).attr('value', data.TIME));
                }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
                $('.preloader').hide();
            }
        });
        var CustomerNameArray=[];
        var CustomernameDetails;
        $(document).on('change','#CRC_AllUnits',function(){
            var unitno=$('#CRC_AllUnits').val();
            $('#RecheckinForm').hide();
            $('#multiplecustomerdiv').html('');
            var options ='<option value="">SELECT</option>';
            if(unitno!='SELECT')
            {
                $('.preloader').show();
                $('#CustomeremptyErrormsg').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"Recheckin_Customer",
                    data:{"Unit":unitno},
                    success: function(data){
                        var value_array=JSON.parse(data);
                        CustomernameDetails=value_array;
                        if(value_array.length!=0)
                        {
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
                            $('#CRC_AllCustomers').prop('disabled',false);
                        }
                        else
                        {
                            var messg='NO CUSTOMER AVALIABLE FOR RECHECK-IN IN UNIT NO: [UNIT NO]';
                            messg=messg.replace('[UNIT NO]',unitno);
                            $('#CustomeremptyErrormsg').text(messg);
                            $('#CustomeremptyErrormsg').show();
                            $('#CRC_AllCustomers').prop('disabled',true);
                        }
                        $('#CRC_AllCustomers').html(options);
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
                $('#CRC_AllCustomers').html(options);
                $('#CRC_AllCustomers').prop('disabled',true);
            }
        });
        $(document).on('change','#CRC_AllCustomers',function(){
            $('#RecheckinForm').hide();
            var Customer=$('#CRC_AllCustomers').val();
            var Multiplenamearray=[];
            for(var j=0;j<CustomernameDetails.length;j++)
            {
                var data=CustomernameDetails[j];
                if(data.CUSTOMERNAME==Customer)
                {
                    var customername=data.CUSTOMERNAME.replace('_','  ')+'/'+data.CUSTOMER_ID+'/'+data.CED_REC_VER;
                    Multiplenamearray.push(customername)
                }
            }
            if(Multiplenamearray.length==1)
            {
                var value=Multiplenamearray[0].split('/');
                GetcustomerOldDetails(value[1],value[2]);
                $('#multiplecustomerdiv').html('');
            }
            else
            {
                var appeneddata='';
                for(var a=0;a<Multiplenamearray.length;a++)
                {
                    var value=Multiplenamearray[a].split('/');
                    var radioname=value[0]+'-'+value[1];
                    var radiovalue=value[1]+'-'+value[2];
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


        });
        $(document).on('click','.Multiplecustomer',function(){
            var radiovalue=($('input[name="Customer"]:checked').val());
            var radiovaluesplit=radiovalue.split('-');
            GetcustomerOldDetails(radiovaluesplit[0],radiovaluesplit[1]);
        });
        var RecheckinSD;
        function GetcustomerOldDetails(customerid,Recver)
        {
            $('.preloader').show();
            var unitno=$('#CRC_AllUnits').val();
            $.ajax({
                type: "POST",
                url: controller_url+"Recheckin_Customer_PersonalDetails",
                data:{"Unit":unitno,Customerid:customerid,Recver:Recver},
                success: function(data){
                    var valuearray=JSON.parse(data);
                    var value_array=valuearray[0];
                    var PreviousEnddate=valuearray[1];
                    if(PreviousEnddate[0].CLP_PRETERMINATE_DATE!=null && PreviousEnddate[0].CLP_PRETERMINATE_DATE!='')
                    {
                        RecheckinSD=PreviousEnddate[0].CLP_PRETERMINATE_DATE;
                    }
                    else
                    {
                        RecheckinSD=PreviousEnddate[0].CLP_ENDDATE;
                    }
                    Reset()
                    $('#CCRE_CustomerId').val(value_array[0].CUSTOMER_ID);
                    $("#CCRE_FirstName").val(value_array[0].CUSTOMER_FIRST_NAME);
                    $("#CCRE_LastName").val(value_array[0].CUSTOMER_LAST_NAME);
                    $('#CCRE_CompanyName').val(value_array[0].CCD_COMPANY_NAME);
                    $('#CCRE_CompanyAddress').val(value_array[0].CCD_COMPANY_ADDR);
                    $('#CCRE_CompanyPostalCode').val(value_array[0].CCD_POSTAL_CODE);
                    $('#CCRE_Emailid').val(value_array[0].CPD_EMAIL);
                    $('#CCRE_DOB').val(value_array[0].CPD_DOB);
                    $('#CCRE_Nationality').val(value_array[0].NC_DATA);
                    $('#CCRE_Mobile').val(value_array[0].CPD_MOBILE);
                    $('#CCRE_IntlMobile').val(value_array[0].CPD_INTL_MOBILE);
                    $('#CCRE_Officeno').val(value_array[0].CCD_OFFICE_NO);
                    $('#CCRE_PassportDate').val(value_array[0].CPD_PASSPORT_DATE);
                    $('#CCRE_PassportNo').val(value_array[0].CPD_PASSPORT_NO);
                    $('#CCRE_EpNo').val(value_array[0].CPD_EP_NO);
                    $('#CCRE_EPDate').val(value_array[0].CPD_EP_DATE);
                    $('#CCRE_Comments').val(value_array[0].CPD_COMMENTS);
                    $('#RecheckinForm').show();
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        }
        /*************UNIQUE FUNCTION*********************/
        function unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
        //BUTTON VALIDATION

        /***************************CUSTOMER FORM SUBMIT BUTTON VALIDATION*******************************/
        function FormnewDateFormat(inputdate)
        {
            var string = inputdate.split("-");
            var newdate=new Date(string[2],string[1]-1,string[0])
            return newdate;
        }
        $(document).on('change blur','#CRC_Form_CustomerRecheckin',function(){
            /******POSATAL CODE************/
            var postalcode=$('#CCRE_CompanyPostalCode').val();
            if(postalcode!=""){if(postalcode.length>=5){var postalflag=1;$('#CCRE_lbl_postalerrormsg').hide();$('#CCRE_CompanyPostalCode').removeClass('invalid');}else{postalflag=0;$('#CCRE_lbl_postalerrormsg').show();$('#CCRE_CompanyPostalCode').addClass('invalid');}}else{$('#CCRE_lbl_postalerrormsg').hide();postalflag=1;$('#CCRE_CompanyPostalCode').removeClass('invalid');}
            /******MOBILE NO************/
            var mobileno=$('#CCRE_Mobile').val();
            if(mobileno!=""){if(mobileno.length>=6){var mobileflag=1;$('#CCRE_lbl_mobileerrormsg').hide();$('#CCRE_Mobile').removeClass('invalid');}else{mobileflag=0;$('#CCRE_lbl_mobileerrormsg').show();$('#CCRE_Mobile').addClass('invalid');}}else{$('#CCRE_lbl_mobileerrormsg').hide();mobileflag=1;$('#CCRE_Mobile').removeClass('invalid');}
            /******INTL MOBILE NO************/
            var intlmobileno=$('#CCRE_IntlMobile').val();
            if(intlmobileno!=""){if(intlmobileno.length>=6){var intlmobileflag=1;$('#CCRE_lbl_intlmobileerrormsg').hide();$('#CCRE_IntlMobile').removeClass('invalid');}else{intlmobileflag=0;$('#CCRE_lbl_intlmobileerrormsg').show();$('#CCRE_IntlMobile').addClass('invalid');}}else{$('#CCRE_lbl_intlmobileerrormsg').hide();intlmobileflag=1;$('#CCRE_IntlMobile').removeClass('invalid');};
            /******OFFICE NO************/
            var officeno=$('#CCRE_Officeno').val();
            if(officeno!=""){if(officeno.length>=6){var officenoflag=1;$('#CCRE_lbl_officeerrormsg').hide();$('#CCRE_Officeno').removeClass('invalid');}else{officenoflag=0;$('#CCRE_lbl_officeerrormsg').show();$('#CCRE_Officeno').addClass('invalid');}}else{$('#CCRE_lbl_officeerrormsg').hide();officenoflag=1;$('#CCRE_Officeno').removeClass('invalid');}
            /******PASSPORT NO************/
            var passportno=$('#CCRE_PassportNo').val();
            if(passportno!=""){if(passportno.length>=6){var passportnoflag=1;$('#CCRE_lbl_passporterrormsg').hide();$('#CCRE_PassportNo').removeClass('invalid');$('#CCRE_PassportNo').val($("#CCRE_PassportNo").val().toUpperCase());}else{passportnoflag=0;$('#CCRE_lbl_passporterrormsg').show();$('#CCRE_PassportNo').addClass('invalid');}}else{$('#CCRE_lbl_passporterrormsg').hide();passportnoflag=1;$('#CCRE_PassportNo').removeClass('invalid');}
            /******EP NO************/
            var epno=$('#CCRE_EpNo').val();
            if(epno!=""){if(epno.length>=6){var epnoflag=1;$('#CCRE_lbl_epnoerrormsg').hide();$('#CCRE_EpNo').removeClass('invalid');$('#CCRE_EpNo').val($("#CCRE_EpNo").val().toUpperCase())}else{epnoflag=0;$('#CCRE_lbl_epnoerrormsg').show();$('#CCRE_EpNo').addClass('invalid');}}else{$('#CCRE_lbl_epnoerrormsg').hide();$('#CCRE_EpNo').removeClass('invalid');epnoflag=1;}
            /******DEPOSIT ************/
            var deposit=$('#CCRE_DepositFee').val();
            if(deposit!=""){var depositamount=deposit.split('.');if(depositamount[0].length>=3){var depositflag=1;$('#CCRE_lbl_depositerrormsg').hide();$('#CCRE_DepositFee').removeClass('invalid');}else{depositflag=0;$('#CCRE_lbl_depositerrormsg').show();$('#CCRE_DepositFee').addClass('invalid');}}else{$('#CCRE_lbl_depositerrormsg').hide();depositflag=1;$('#CCRE_DepositFee').removeClass('invalid');}
            /******PROCESS************/
            var process=$('#CCRE_ProcessingFee').val();
            if(process!=""){var processamount=process.split('.');if(processamount[0].length>=3){var processflag=1;$('#CCRE_lbl_processerrormsg').hide();$('#CCRE_ProcessingFee').removeClass('invalid');}else{processflag=0;$('#CCRE_lbl_processerrormsg').show();$('#CCRE_ProcessingFee').addClass('invalid');}}else{$('#CCRE_lbl_processerrormsg').hide();$('#CCRE_ProcessingFee').removeClass('invalid');processflag=1;}
            /******RENT************/
            var rent=$('#CCRE_Rent').val();
            if(rent!=""){var rentamount=rent.split('.');if(rentamount[0].length>=3){var rentflag=1;$('#CCRE_lbl_renterrormsg').hide();$('#CCRE_Rent').removeClass('invalid');}else{rentflag=0;$('#CCRE_lbl_renterrormsg').show();$('#CCRE_Rent').addClass('invalid');}}else{$('#CCRE_lbl_renterrormsg').hide();$('#CCRE_Rent').removeClass('invalid');rentflag=1;}
            /******ELECTRICITY CAP************/
            var electricity=$('#CCRE_ElectricitycapFee').val();
            if(electricity!=""){var electamount=electricity.split('.');if(electamount[0].length>=2){var electflag=1;$('#CCRE_lbl_electcaperrormsg').hide();$('#CCRE_ElectricitycapFee').removeClass('invalid');}else{electflag=0;$('#CCRE_lbl_electcaperrormsg').show();$('#CCRE_ElectricitycapFee').addClass('invalid');}}else{$('#CCRE_lbl_electcaperrormsg').hide();$('#CCRE_ElectricitycapFee').removeClass('invalid');electflag=1}
//        if($('#CCRE_PassportDate').val()=="" && $('#CCRE_PassportNo').val()=="") { var passportflag=1;$('#CCRE_lbl_passportdateerrormsg').hide();$('#CCRE_PassportNo').removeClass('invalid'); } else { if($('#CCRE_PassportDate').val()!="" && $('#CCRE_PassportNo').val()==""){passportflag=0;$('#CCRE_lbl_passportdateerrormsg').show();$('#CCRE_PassportNo').addClass('invalid');} else {passportflag=1;$('#CCRE_lbl_passportdateerrormsg').hide();$('#CCRE_PassportNo').removeClass('invalid');} }
//        if($('#CCRE_EPDate').val()=="" && $('#CCRE_EpNo').val()=="") { var epflag=1;$('#CCRE_lbl_epnodateerrormsg').hide();$('#CCRE_EpNo').removeClass('invalid') } else { if($('#CCRE_EPDate').val()!="" && $('#CCRE_EpNo').val()==""){epflag=0;$('#CCRE_lbl_epnodateerrormsg').show();$('#CCRE_EpNo').addClass('invalid');} else {epflag=1;$('#CCRE_lbl_epnodateerrormsg').hide();$('#CCRE_EpNo').removeClass('invalid')} }
            var ppdate=$('#CCRE_PassportDate').val();
            var ppno=$('#CCRE_PassportNo').val();
            if (ppdate!= "" || ppno!= "")
            {
                var ppnoappenddata='<div id="passportnumber"><div class="col-md-3" ><label >PASSPORT NUMBER<span class="labelrequired"><em>*</em></span></label></div></div>';
                $('#passportnumber').replaceWith(ppnoappenddata);
                var ppdateappenddata='<div id="passportdate"><div class="col-md-3"><label>PASSPORT EXPIRY DATE<span class="labelrequired"><em>*</em></span></label></div></div>';
                $('#passportdate').replaceWith(ppdateappenddata);
                if (ppdate != "" && ppno != ""){var passportflag=1;}
                else{passportflag=0;}
            }
            else if(ppdate == "" && ppno == "")
            {
                passportflag=1;
                var ppnoappenddata1='<div id="passportnumber"><div class="col-md-3" ><label >PASSPORT NUMBER</label></div></div>';
                $('#passportnumber').replaceWith(ppnoappenddata1);
                var ppdateappenddata1='<div id="passportdate"><div class="col-md-3"><label>PASSPORT EXPIRY DATE</label></div></div>';
                $('#passportdate').replaceWith(ppdateappenddata1);
            }
            var EPdate=$('#CCRE_EPDate').val();
            var EPno=$('#CCRE_EpNo').val();
            if (EPdate!= "" || EPno!= "")
            {
                var EPnoappenddata='<div id="epnumber"><div class="col-md-3" ><label >EP NUMBER<span class="labelrequired"><em>*</em></span></label></div></div>';
                $('#epnumber').replaceWith(EPnoappenddata);
                var EPdateappenddata='<div id="EPdate"><div class="col-md-3"><label>EP EXPIRY DATE<span class="labelrequired"><em>*</em></span></label></div></div>';
                $('#EPdate').replaceWith(EPdateappenddata);
                if (EPdate != "" && EPno != ""){var epflag=1;}
                else{epflag=0;}
            }
            else if(EPdate == "" && EPno == "")
            {
                epflag=1;
                var EPnoappenddata='<div id="epnumber"><div class="col-md-3" ><label >EP NUMBER</label></div></div>';
                $('#epnumber').replaceWith(EPnoappenddata);
                var EPdateappenddata='<div id="EPdate"><div class="col-md-3"><label>EP EXPIRY DATE</label></div></div>';
                $('#EPdate').replaceWith(EPdateappenddata);
            }
            var CCRE_emailid=$("#CCRE_Emailid").val();
            var CCRE_atpos=CCRE_emailid.indexOf("@");
            var CCRE_dotpos=CCRE_emailid.lastIndexOf(".");
            if(CCRE_emailid.length>0)
            {
                if ((/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(CCRE_emailid) || "" == CCRE_emailid)&&(CCRE_atpos-1!=CCRE_emailid.indexOf(".")))
                {
                    $('#CCRE_lbl_emailiderrormsg').hide();
                    var CCRE_emailchk="valid";
                    $('#CCRE_Emailid').removeClass('invalid');
                    $('#CCRE_Emailid').val(CCRE_emailid.toLowerCase());
                }
                else
                {
                    $('#CCRE_lbl_emailiderrormsg').show();
                    CCRE_emailchk="invalid"
                    $('#CCRE_Emailid').addClass('invalid');
                }
            }
            else
            {
                CCRE_emailchk="invalid"
                $('#CCRE_Emailid').removeClass('invalid');
                $('#CCRE_lbl_emailiderrormsg').hide();
            }
            var pp_date=$('#CCRE_PassportDate').val();
            var end_date=$("#CCRE_Enddate").val();
            var ep_date=$('#CCRE_EPDate').val();
            if(pp_date!="" && end_date!="")
            {
                var newpp_date=FormnewDateFormat(pp_date);
                var newend_date=FormnewDateFormat(end_date);
                if(newpp_date>newend_date)
                {
                    var ppdateflag=1;
                    $('#CCRE_lbl_passportdateerrormsg').hide();
                }
                else
                {
                    ppdateflag=0;
                    $('#CCRE_lbl_passportdateerrormsg').show();
                }
            }
            else
            {
                ppdateflag=1;
                $('#CCRE_lbl_passportdateerrormsg').hide();
            }
            if(ep_date!="" && end_date!="")
            {
                var newep_date=FormnewDateFormat(ep_date);
                var newend_date=FormnewDateFormat(end_date);
                if(newep_date>newend_date)
                {
                    var epdateflag=1;
                    $('#CCRE_lbl_ep_dateerrormsg').hide();
                }
                else
                {
                    epdateflag=0;
                    $('#CCRE_lbl_ep_dateerrormsg').show();
                }
            }
            else
            {
                epdateflag=1;
                $('#CCRE_lbl_ep_dateerrormsg').hide();
            }
            if($("#CCRE_FirstName").val()!=""&& $("#CCRE_LastName").val()!=""&&$("#CCRE_Emailid").val()!=""&&$("#CCRE_Nationality").val()!="SELECT"&&$("#CCRE_SDStarttime").val()!="Select"&& $('#CCRE_EDEndtime').val()!='Select' &&
                $("#CCRE_UnitNo").val()!="SELECT"&& $("#CCRE_RoomType").val()!="SELECT"&&$("#CCRE_EDStarttime").val()!="Select"&& $("#CCRE_Option").val()!="SELECT"&& $("#CCRE_MailList").val()!="SELECT"
                && $("#CCRE_Rent").val()!=""&& $("#CCRE_Startdate").val()!=""&& $("#CCRE_Enddate").val()!="" &&(CCRE_emailchk=="valid")  && mobileflag==1 && intlmobileflag==1 && officenoflag==1&& passportnoflag==1 && epnoflag==1 && processflag==1&& depositflag==1 && rentflag==1 && postalflag==1 &&electflag==1 && passportflag==1 && epflag==1 && ppdateflag==1 && epdateflag==1)
            {
                if(($("input[name='AccessCard']:checked").val()=='Null')||(($("input[name='AccessCard']:checked").val()=='Cardnumber')&&($("input[name='checkbox']:checked").val()!="")&&($("input[name='checkbox']:checked").val()!=undefined)))
                {
                    if($("input[name='AccessCard']:checked").val()=='Cardnumber')
                    {
                        var CCRE_cardflag=0;
                        for(var card=0;card<CCRE_cardArray.length;card++)
                        {
                            if($('#CCRE_cb_cardlistselect'+card).val()==$("#CCRE_FirstName").val()+" "+$("#CCRE_LastName").val())
                            {
                                CCRE_cardflag=1;
                            }
                            else
                            {
                                $("#CCRE_btn_savebutton").attr("disabled", "disabled");
                            }
                        }
                        if(CCRE_cardflag==1)
                        {
                            $("#CCRE_btn_savebutton").removeAttr("disabled");
                        }
                    }
                    else
                    {
                        $("#CCRE_btn_savebutton").removeAttr("disabled");
                    }
                }
                else
                {
                    $("#CCRE_btn_savebutton").attr("disabled", "disabled");
                }
            }
            else
            {
                $("#CCRE_btn_savebutton").attr("disabled", "disabled");
            }
        });


        ///*********************SET DOB DATEPICKER**************************************/
        var CCRE_d = new Date();
        var CCRE_year = CCRE_d.getFullYear() - 18;
        CCRE_d.setFullYear(CCRE_year);
        $('#CCRE_DOB').datepicker({dateFormat: 'dd-mm-yy',
            changeYear: true,
            changeMonth: true,
            yearRange: '1920:' + CCRE_year + '',
            defaultDate: CCRE_d
        });
        $('#CCRE_DOB').blur(function()
        {
        });

        //************ROOM TYPE LISTBOX LOADING*****************//
        var unitstart_end_date=[];
        $(document).on('change','.Unitchange',function(){
            var Unit=$('#CCRE_UnitNo').val();
            $('#CardNumbersdiv').hide();
            $('#CCRE_Roomtype_error').text('');
            $('#CCRE_Cardnumber').prop('checked',false);
            $('#CCRE_Nullcard').prop('checked',false);
            AccesscarddivClear();
            if(Unit!='SELECT')
            {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"CustomerRoomTypeLoad",
                    data:{"Unit":Unit},
                    success: function(data){
                        var value_array=JSON.parse(data);
                        if(value_array[0].length!=0)
                        {
                            var options ='<option value="">SELECT</option>';
                            for (var i = 0; i < value_array[0].length; i++)
                            {
                                var data=value_array[0][i];
                                options += '<option value="' + data.URTD_ROOM_TYPE + '">' + data.URTD_ROOM_TYPE + '</option>';
                            }
                            $('#CCRE_RoomType').html(options);
                            $('#RoomtypeDiv').show();
                            $('#AccessCardDiv').show();
                        }
                        else
                        {
                            var CCRE_message=errormsg[3].EMC_DATA.replace("[UNIT NO]",Unit);
                            $('#CCRE_Roomtype_error').text(CCRE_message);
                            $('#CCRE_Roomtype_error').show();
                            $('#RoomtypeDiv').hide();
                            $('#AccessCardDiv').hide();
                        }
                        for (var i = 0; i < value_array[1].length; i++)
                        {
                            var data=value_array[1][i];
                            var unitstartdate=data.UD_START_DATE;
                            var unit_startdate=DB_dateCalculation(unitstartdate);
                            var startdateperiod=value_array[2][0].CCN_DATA;
                            var customerstartdate=DB_beforedateCalculation(startdateperiod);
                            var unitenddate=data.UD_END_DATE;
                            var unit_enddate=DB_dateCalculationminusone(unitenddate);
                            var Customer_enddate=DB_dateCalculationplueone(RecheckinSD);
                            var datearray=[customerstartdate,unit_startdate,Customer_enddate]
                            var maxDate=new Date(Math.max.apply(null,datearray));
                            $('#CCRE_Startdate').datepicker("option","minDate",maxDate);
                            $('#CCRE_Startdate').datepicker("option","maxDate",unit_enddate);
                            $('#CCRE_Enddate').datepicker("option","maxDate",unit_enddate);
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
                AccesscarddivClear();
            }
        });
        function AccesscarddivClear()
        {
            $('#startdatediv').hide();
            $('#CusromerEnddate').hide();
            $('#RoomtypeDiv').hide();
            $('#CCRE_Startdate').val('');
            $('#CCRE_Enddate').val('');
            $('#CCRE_EDStarttime').val('Select');
            $('#CCRE_SDStarttime').val('Select');
            $('#startdatetotime').hide();
            $('#endatedateto').hide();
        }
        function DB_dateCalculation(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[0],inputdate[1]-1,inputdate[2]);
            return newunitstartdate;
        }
        function DB_dateCalculationminusone(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[0],inputdate[1]-1,inputdate[2]-1);
            return newunitstartdate;
        }
        function DB_dateCalculationplueone(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[0],inputdate[1]-1,parseInt(inputdate[2])+parseInt(1));
            return newunitstartdate;
        }
        function DB_beforedateCalculation(startdateperiod)
        {
            var inputdate=new Date();
            var newunitstartdate=new Date(inputdate.getFullYear(),inputdate.getMonth()-parseInt(startdateperiod),inputdate.getDate());
            return newunitstartdate;
        }
        $(document).on('change','#CCRE_Startdate',function(){
            if($('#CCRE_Startdate').val()!="")
            {
                $('#startdatediv').show();
                $('#CusromerEnddate').show();
            }
            else
            {
                $('#startdatediv').hide();
                $('#CusromerEnddate').hide();
            }
        });
        $(function ()
        {
            $("#radio").buttonset();
            $("input[name='Aircon']").on("change", function () {
                var CCRE_radio_name = $("input[name='Aircon']:checked").val();
                if(CCRE_radio_name=='QuarterlyFee')
                {
                    $("#CCRE_Quarterly_fee").show().val('');
                    $("#CCRE_Fixedaircon_fee").hide().val('');
                }
                if(CCRE_radio_name=='FixedAircon')
                {
                    $("#CCRE_Quarterly_fee").hide().val('');
                    $("#CCRE_Fixedaircon_fee").show().val('');
                }
            });
        });
        ///*********************SET CHECKIN DATE AND CHECKOUT DATE*****************************************/
        $("#CCRE_Startdate").datepicker(
            {
                dateFormat: 'dd-mm-yy',
                changeYear: true,
                changeMonth: true
            });
        $("#CCRE_Enddate").datepicker(
            {
                dateFormat: 'dd-mm-yy',
                changeYear: true,
                changeMonth: true
            });
        /**********************ENDDATE VALIDATION***********************************/
        $(document).on('change','.startdatevalidate',function(){
            $("#CCRE_NoticePeriodDate").removeAttr("disabled");
            var startdate=$('#CCRE_Startdate').val();
            var currentdate=Form_dateCalculation(startdate)
            if(new Date()<=currentdate){
                var date1 = $('#CCRE_Startdate').datepicker('getDate');
                var date = new Date( Date.parse( date1 ) );
                date.setDate(date.getDate() + 1);
                var newDate = date.toDateString();
                newDate = new Date( Date.parse( newDate ));
                $('#CCRE_Enddate').datepicker("option","minDate",newDate);
            }
            else
            {
                var CCRE_date1 = new Date();
                var CCRE_day=CCRE_date1.getDate();
                CCRE_date1.setDate( CCRE_day + 1 );
                var newDate = CCRE_date1.toDateString();
                newDate = new Date( Date.parse( newDate ));
                $('#CCRE_Enddate').datepicker("option","minDate",newDate);
            }
        });
        function Form_dateCalculation(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[2],inputdate[1]-1,inputdate[0]);
            return newunitstartdate;
        }
        /******************************SET PASSPORTDATE,EPDATE,NOTICEDATE DATEPICKER********************************/
        $( "#datepicker" ).datepicker({dateFormat: 'dd-mm-yy',changeYear: true,changeMonth: true});
        $( "#CCRE_PassportDate" ).datepicker({dateFormat: 'dd-mm-yy',changeYear: true,changeMonth: true});
        $( "#CCRE_EPDate" ).datepicker({dateFormat: 'dd-mm-yy',changeYear: true,changeMonth: true});
        $( "#CCRE_NoticePeriodDate" ).datepicker({dateFormat: 'dd-mm-yy',changeYear: true,changeMonth: true});
        var CCRE_date1 = new Date();
        var CCRE_day=CCRE_date1.getDate();
        CCRE_date1.setDate( CCRE_day + 1 );
        var newDate = CCRE_date1.toDateString();
        newDate = new Date( Date.parse( newDate ));
        $('#CCRE_PassportDate').datepicker("option","minDate",newDate);
        var passCCRE_d = new Date();
        var CCRE_passyear = passCCRE_d.getFullYear()+10;
        var pass_changedmonth=new Date(passCCRE_d.setFullYear(CCRE_passyear));
        $('#CCRE_PassportDate').datepicker("option","maxDate",pass_changedmonth);
        $('#CCRE_EPDate').datepicker("option","minDate",newDate);
        var epCCRE_d = new Date();
        var CCRE_epyear = epCCRE_d.getFullYear()+3;
        var ep_changedmonth=new Date(epCCRE_d.setFullYear(CCRE_epyear));
        $('#CCRE_EPDate').datepicker("option","maxDate",ep_changedmonth);

        //***********NOTICE PERIOD VALIDATION**********************//
        $(document).on('change','.noticedate',function(){
            var CCRE_date1 = $('#CCRE_Startdate').val();
            var CCRE_date2 = $('#CCRE_Enddate').val();
            if(CCRE_date2!="")
            {
                var checkindate=CCRE_date1.split('-');
                var newnoticemindate=new Date(checkindate[2],checkindate[1]-parseInt(1),parseInt(checkindate[0])+1);
                var checkoutdate=CCRE_date2.split('-');
                var newnoticemaxdate=new Date(checkoutdate[2],checkoutdate[1]-parseInt(1),checkoutdate[0]-parseInt(1));
                if(newnoticemindate>new Date())
                {
                    $('#CCRE_NoticePeriodDate').datepicker("option","maxDate",newnoticemaxdate);
                    $('#CCRE_NoticePeriodDate').datepicker("option","minDate",newnoticemindate);
                }
                else
                {
                    $('#CCRE_NoticePeriodDate').datepicker("option","maxDate",newnoticemaxdate);
                    var newnoticestartdate=new Date();
                    var day=newnoticestartdate.getDate()+1;
                    var newnoticemindate=new Date(newnoticestartdate.getFullYear(),newnoticestartdate.getMonth(),day);
                    $('#CCRE_NoticePeriodDate').datepicker("option","minDate",newnoticemindate);
                }
            }
        });
        $(document).on('change','.CardNumbers',function(){
            var CCRE_CardOptionname = $("input[name='AccessCard']:checked").val();
            var firstname=$('#CCRE_FirstName').val();
            var lastname=$('#CCRE_LastName').val();
            if(firstname!="" && lastname!="")
            {
                if(CCRE_CardOptionname=='Cardnumber')
                {
                    $('.preloader').show();
                    var Unit=$('#CCRE_UnitNo').val();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"UnitCardNumbers",
                        data:{"Unit":Unit},
                        success: function(data){
                            var value_array=JSON.parse(data);
                            var cardnolblval=[];
                            var cardnoresult=[];
                            if(value_array.length!=0)
                            {
                                for(var i=0;i<value_array.length;i++)
                                {
                                    cardnoresult.push(value_array[i].UASD_ACCESS_CARD);
                                    if(i<=3)
                                    {
                                        if(i==0)
                                        {
                                            cardnolblval.push(firstname+" "+lastname);
                                        }
                                        else
                                        {
                                            cardnolblval.push("GUEST "+i);
                                        }
                                    }
                                }
                                cardnoresult=[cardnoresult,cardnolblval];
                                CCRE_cardhandleMessageResponse(cardnoresult);
                            }
                            else
                            {
                                $('#CCRE_Cardnumber').prop('checked', false);
                                $('#CCRE_Nullcard').prop('checked', false);
                                var errormessage=errormsg[4].EMC_DATA;
                                var appenddata='';
                                appenddata+='<div class="row form-group">';
                                appenddata+='<div class="col-md-3">';
                                appenddata+='</div>';
                                appenddata+='<div class="col-md-6" style="padding-left: 50px;"><label style="color:red;" class="errormsg">'+errormessage+'</label></div>';
                                $('#CardNumbersdiv').html(appenddata);
                                $('#CardNumbersdiv').show();
                                $('#CCRE_Startdate').val('');
                                $('#CCRE_Enddate').val('');
                                $('#CCRE_EDStarttime').val('Select');
                                $('#CCRE_SDStarttime').val('Select');
                                $('#startdatetotime').hide();
                                $('#endatedateto').hide();
                            }
                            $('.preloader').hide();
                        },
                        error: function(data){
                            alert('error in getting'+JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                    $('#CardNumbersdiv').show();
                }
                else
                {
                    var appenddata='';
                    $('#CardNumbersdiv').append(appenddata);
                    $('#CardNumbersdiv').hide();
                }
            }
            else
            {
                $('#CCRE_Cardnumber').prop('checked', false);
                $('#CCRE_Nullcard').prop('checked', false);
                var appenddata='';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-3">';
                appenddata+='</div>';
                appenddata+='<div class="col-md-4" style="padding-left: 50px;"><label style="color:red;">ENTER THE CUSTOMER NAME</label></div>';
                $('#CardNumbersdiv').html(appenddata);
                $('#CardNumbersdiv').show();
            }
        });
        var CCRE_cardArray= [];
        var CCRE_cardslbl_array=[];
        var accesscard_array=[];
        function CCRE_cardhandleMessageResponse(card)
        {
            accesscard_array=card;
            CCRE_cardArray=card[0];
            CCRE_cardslbl_array=card[1];
            var appenddata='';
            if(CCRE_cardArray.length!=0)
            {
                for (var i=0;i<CCRE_cardArray.length;i++)
                {
                    var listid='CCRE_cb_cardlistselect'+i;
                    appenddata+='<div class="row form-group">';
                    appenddata+='<div class="col-md-3">';
                    appenddata+='</div>';
                    appenddata+='<div class="col-md-2" style="padding-left: 50px;">';
                    appenddata+='<input type="checkbox"  value='+CCRE_cardArray[i]+' id="CCRE_cb_cardnumberarray'+i+'" name="checkbox" class="CCRE_showlist" />'+CCRE_cardArray[i];
                    appenddata+='</div>';
                    appenddata+='<div class="col-md-3">';
                    appenddata+='<SELECT class="form-control CCRE_showlist"  name="CCRE_cb_cardlistselect"  value="Cardnumber" id='+listid+'><OPTION>SELECT</OPTION></SELECT>';
                    appenddata+='</div>';
                    appenddata+='<div class="col-md-3">';
                    appenddata+='<input type="text" id="CCRE_lb_cardlisttext'+i+'" name="temptex[]" >';
                    appenddata+='</div>';
                    appenddata+='</div>';
                }
                $('#CardNumbersdiv').html(appenddata);
                for (var k=0;k<CCRE_cardArray.length;k++)
                {
                    $('#CCRE_cb_cardlistselect'+k).hide();
                    $('#CCRE_lb_cardlisttext'+k).hide();
                }
                $('#CardNumbersdiv').show();
                for(var i=0;i<CCRE_cardArray.length;i++){
                    var CCRE_options ='<option >SELECT</option>'
                    for(var j=0;j<CCRE_cardslbl_array.length;j++)
                    {
                        CCRE_options += '<option value="' + CCRE_cardslbl_array[j] + '">' + CCRE_cardslbl_array[j] + '</option>';
                    }
                    $('#CCRE_cb_cardlistselect-'+i).html(CCRE_options);
                    $('#CCRE_cb_cardlistselect-'+i).hide();

                }
            }
        }

        /***************************************FUNCTION FOR CARD SELECTIONS***********************************************/
        $(document).on('change','.CCRE_showlist',function(){
//        $(".preloader").show();
            $('#CCRE_btn_savebutton').attr("disabled","disabled");
            var CCRE_cardlist=[];
            var f=0;var count=0;var ll=0;
            var CCRE_cc_cardarray_length=CCRE_cardArray.length;
            for(var i=0;i<CCRE_cc_cardarray_length;i++)
            {
                var CCRE_cc_check=$('#CCRE_cb_cardnumberarray'+i).is(":checked");
                if(CCRE_cc_check==true)
                {
                    $('#CCRE_cb_cardlistselect'+i).removeAttr("disabled");
                    var CCRE_selectcardno=$('#CCRE_cb_cardnumberarray'+i).val();
                    var CCRE_card_cardlist_box=$('#CCRE_cb_cardlistselect'+i).val();
                    if(CCRE_card_cardlist_box!="SELECT"){
                        $('#CCRE_cb_cardlistselect'+i).attr("disabled","disabled");
                        $('#CCRE_lb_cardlisttext'+i).val(CCRE_selectcardno+'/'+CCRE_card_cardlist_box);
                        CCRE_cardlist.push(CCRE_card_cardlist_box);
                    }
                    else
                    {
                        ll++;
                    }
                    count++;
                }
            }
            var n1=[];
//difference between two arrays
            var n1=CCRE_card_diffArray(CCRE_cardslbl_array,CCRE_cardlist);
            for(var j=0;j<CCRE_cc_cardarray_length;j++)
            {
                var CCRE_cc_check=$('#CCRE_cb_cardnumberarray'+j).is(":checked");
                var CCRE_card_cardlist_box=$('#CCRE_cb_cardlistselect'+j).val();
                if(CCRE_card_cardlist_box=="SELECT")
                {
                    $('#CCRE_cb_cardlistselect'+j).empty();
                    var CCRE_options ='<option >SELECT</option>'
                    for(var l=0;l<n1.length;l++)
                    {
                        CCRE_options += '<option value="' + n1[l] + '">' + n1[l] + '</option>';
                    }
                    $('#CCRE_cb_cardlistselect'+j).html(CCRE_options);

                    $('#CCRE_cb_cardlistselect'+j).attr("enabled","enabled")
                }
                if(CCRE_cc_check==true)
                {
                    $('#CCRE_cb_cardlistselect'+j).show();
                    $('#CCRE_cb_cardlistselect'+j).attr("enabled","enabled")
                }
                else
                {
                    $('#CCRE_cb_cardlistselect'+j)[0].selectedIndex = 0;
                    $('#CCRE_lb_cardlisttext'+j).val('');
                    $('#CCRE_cb_cardlistselect'+j).hide();}
            }
            if(count==4)
            {
                for(var i=0;i<CCRE_cc_cardarray_length;i++)
                {
                    var CCRE_cc_check=$('#CCRE_cb_cardnumberarray'+i).is(":checked");
                    if(CCRE_cc_check==false)
                    {
                        $('#CCRE_cb_cardnumberarray'+i).attr("disabled","disabled");
                    }
                }
            }
            else
            {
                if(ll==0)
                {
                    for(var i=0;i<CCRE_cc_cardarray_length;i++)
                    {
                        var CCRE_cc_check=$('#CCRE_cb_cardnumberarray'+i).is(":checked");
                        if(CCRE_cc_check==false)
                        {
                            $('#CCRE_cb_cardnumberarray'+i).removeAttr("disabled","disabled");
                        }
                    }
                }
                else
                {
                    for(var y=0;y<CCRE_cc_cardarray_length;y++)
                    {
                        var CCRE_cc_check=$('#CCRE_cb_cardnumberarray'+y).is(":checked");
                        if(CCRE_cc_check==false)
                        {
                            $('#CCRE_cb_cardnumberarray'+y).attr("disabled","disabled");
                        }
                    }
                }
            }
            CCRE_submit_validate(accesscard_array)
//        $(".preloader").hide();
        });
        function CCRE_submit_validate(card)
        {
            var CCRE_fname=$('#CCRE_FirstName').val();
            var CCRE_lname=$('#CCRE_LastName').val();
            var CCRE_cardArray=[];
            var CCRE_g_array=[];
            CCRE_cardArray=card[0];
            CCRE_g_array=card[1]
            var CCRE_cararray_length=CCRE_cardArray.length;
            var CCRE_gcardlen=CCRE_g_array.length;
            var CCRE_printarray=[];
            var CCRE_false_flag=0;
            var CCRE_true_flag=0;
            var CCRE_flag=0;var CCRE_flag1=0;var CCRE_flag2=0;var CCRE_flag3=0;
            for(var k=0;k<CCRE_cararray_length;k++)
            {
                var CCRE_access_card= $('#CCRE_cb_cardnumberarray'+k).is(":checked");
                if(CCRE_access_card==true)
                {
                    CCRE_true_flag++;
                }
                else
                {
                    CCRE_false_flag++;
                }
            }
            if(CCRE_true_flag==0||CCRE_lname=="")
            {
                $('#CCRE_btn_savebutton').attr("disabled","disabled");
                $('#CCRE_lbl_error').hide();
            }
            else
            {
                $('#CCRE_lbl_error').hide();
                if($("#CCRE_Rent").val()!="" &&$("#CCRE_Startdate").val()!=""  && $("#CCRE_Enddate").val()!="" && $("#CCRE_Nationality").val()!="SELECT" &&$("#CCRE_SDStarttime").val()!="Select"&& $("#CCRE_Option").val()!="SELECT"&& $("#CCRE_MailList").val()!="SELECT")
                {
                    $('#CCRE_btn_savebutton').removeAttr('disabled');
                }
                var CCRE_custname="";
                if(CCRE_fname!=""&&CCRE_lname!="")
                {
                    CCRE_custname=(CCRE_fname+" "+CCRE_lname);
                }
                if(CCRE_cararray_length>0)
                {
                    for(var i=0;i<CCRE_cararray_length;i++)
                    {
                        var CCRE_card_cardlist_box=$('#CCRE_cb_cardlistselect'+i).val();
                        if(CCRE_card_cardlist_box=="SELECT"){CCRE_flag3=1;}
                        var CCRE_cc_check=$('#CCRE_cb_cardnumberarray'+i).is(":checked");
                        if(CCRE_cc_check==true)
                        {
                            CCRE_flag1=1;
                            if(CCRE_custname!="")
                            {
                                if(CCRE_card_cardlist_box.match(CCRE_custname))
                                {
                                    CCRE_flag=1;
                                }
                            }
                            if(CCRE_card_cardlist_box=="SELECT")
                            {
                                CCRE_flag2=1;
                            }
                        }
                    }
                    if(CCRE_flag1==1)
                    {
                        if(CCRE_flag==0)
                        {
                            $('#CCRE_btn_savebutton').attr("disabled","disabled");
                            $('#CCRE_lbl_error').text(errormsg[5].EMC_DATA)
                            $('#CCRE_lbl_error').show();
                        }
                        else
                        {
                            $('#CCRE_lbl_error').text("");
                        }
                        if(CCRE_flag2==1){
                            $('#CCRE_btn_savebutton').attr("disabled","disabled");
                        }
                    }
                    else
                    {
                        $('#CCRE_lbl_error').text("");
                    }
                    if(CCRE_flag1!=1)
                    {
                        $('#CCRE_btn_savebutton').attr("disabled","disabled");
                    }
                }
            }
        }
        function CCRE_card_diffArray(a, b) {
            var seen = [], diff = [];
            for ( var i = 0; i < b.length; i++)
                seen[b[i]] = true;
            for ( var i = 0; i < a.length; i++)
                if (!seen[a[i]])
                    diff.push(a[i]);
            return diff;
        }
        $(document).on('change','#CCRE_ProcessingFee',function(){
            if($('#CCRE_ProcessingFee').val()=="")
            {
                $('input:checkbox[name=CCRE_process_waived]').attr("checked",false);
                $('input:checkbox[name=CCRE_process_waived]').attr("disabled",'disabled');
            }
            else
            {
                $('input:checkbox[name=CCRE_process_waived]').removeAttr("disabled");
            }
        });
        $(document).on('change','#CCRE_SDStarttime',function(){
            var fromtime=$('#CCRE_SDStarttime').val();
            if(fromtime!='Select')
            {
                var CCRE_timelist=totimecalculation(fromtime);
                $('#CCRE_SDEndtime').html(CCRE_timelist);
                $('#startdatetotime').show();
            }
            else
            {
                $('#startdatetotime').hide();
            }
        });
        $(document).on('change','#CCRE_EDStarttime',function(){
            var fromtime=$('#CCRE_EDStarttime').val();
            if(fromtime!='Select')
            {
                var CCRE_timelist=totimecalculation(fromtime);
                $('#CCRE_EDEndtime').html(CCRE_timelist);
                $('#endatedateto').show();
            }
            else
            {
                $('#endatedateto').hide();
            }
        });
        function totimecalculation(starttime)
        {
            for(var i=0;i<timearray.length;i++)
            {
                if(starttime==timearray[i].TIME)
                {
                    var endtime_status=i;
                    break;
                }
            }
//        var CCRE_timelist='<option>Select</option>';
            if(starttime!='23:30')
            {
                var location=endtime_status+1;
                var CCRE_timelist;
                for(var i=location;i<timearray.length;i++)
                {
                    var data=timearray[i];
                    CCRE_timelist += '<option value="' + data.TIME + '">' + data.TIME + '</option>';
                }
            }
            else
            {
                CCRE_timelist += '<option value="23:59">23:59</option>';
            }
            return CCRE_timelist;
        }
        $('#CCRE_btn_savebutton').on('click', function () {
            $('.preloader').show();
            var FormElements = document.getElementById("CRC_Form_CustomerRecheckin");
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    $('.preloader').hide();
                    var returnvalue=xmlhttp.responseText;
                    var allunits=returnvalue[1];
//                var options ='<option value="">SELECT</option>';
//                for (var i = 0; i < allunits.length; i++)
//                {
//                    var data=allunits[i];
//                    options += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
//                }alert(options)
//                $('#CRC_AllUnits').html(options);
                    $('#CRC_AllCustomers').prop('disabled',true);
                    var CUSTOMERoptions ='<option value="">SELECT</option>';
                    $('#CRC_AllCustomers').html(CUSTOMERoptions);
                    if (returnvalue==1) {
                        $('.preloader').hide();
                        show_msgbox("CUSTOMER RECHECKIN", errormsg[7].EMC_DATA, "success", false);
                        Reset();
                    }
                    else if(returnvalue==0)
                    {
                        show_msgbox("CUSTOMER RECHECKIN", 'CUSTOMER NOT SAVED', "success", false);
                    }
                    else
                    {
                        $('.preloader').hide();
                        show_msgbox("CUSTOMER RECHECKIN", returnvalue, "success", false);
                    }
                }
            }
            xmlhttp.open("POST",controller_url+"CustomerRecheckinSave", true);
            xmlhttp.send(new FormData(FormElements));
        });
        $(document).on('change blur','.Customernamechange',function(){
            var appenddata='';
            $('#CardNumbersdiv').append(appenddata);
            $('#CardNumbersdiv').hide();
            $('#CCRE_Cardnumber').prop('checked', false);
            $('#CCRE_Nullcard').prop('checked', false);
        });
        $('#CustomerCreation_Reset').on('click',function(){
            Reset();
            $('#CRC_AllCustomers').val("");
        });
        function Reset()
        {
            AccesscarddivClear();
            var appenddata='';
            $('#AccessCardDiv').hide();
            $('#CardNumbersdiv').append(appenddata);
            $('#CardNumbersdiv').hide();
            $('#CustomeremptyErrormsg').show();
            $('#CCRE_Cardnumber').prop('checked', false);
            $('#CCRE_Nullcard').prop('checked', false);
            $("#CCRE_btn_savebutton").attr("disabled", "disabled");
            $('#CRC_Form_CustomerRecheckin')[0].reset();
            $('#CCRE_lbl_emailiderrormsg').hide();
            $('#CCRE_lbl_mobileerrormsg').hide();
            $('#CCRE_lbl_intlmobileerrormsg').hide();
            $('#CCRE_lbl_officeerrormsg').hide();
            $('#CCRE_lbl_passporterrormsg').hide();
            $('#CCRE_lbl_epnoerrormsg').hide();
            $('#CCRE_lbl_postalerrormsg').hide();
            $('#CCRE_lbl_renterrormsg').hide();
            $('#CCRE_lbl_depositerrormsg').hide();
            $('#CCRE_lbl_processerrormsg').hide();
            $('#CCRE_lbl_electcaperrormsg').hide();
            $('#CCRE_lbl_passportdateerrormsg').hide();
            $('#CCRE_lbl_epnodateerrormsg').hide();
            $('#CCRE_lbl_passportdateerrormsg').hide();
            $('#CCRE_lbl_ep_dateerrormsg').hide();
            $('#CCRE_CompanyPostalCode').removeClass('invalid');
            $('#CCRE_Emailid').removeClass('invalid');
            $('#CCRE_Mobile').removeClass('invalid');
            $('#CCRE_IntlMobile').removeClass('invalid');
            $('#CCRE_Officeno').removeClass('invalid');
            $('#CCRE_PassportDate').removeClass('invalid');
            $('#CCRE_PassportNo').removeClass('invalid');
            $('#CCRE_EpNo').removeClass('invalid');
            $('#CCRE_EPDate').removeClass('invalid');
            $('#CCRE_DepositFee').removeClass('invalid');
            $('#CCRE_ElectricitycapFee').removeClass('invalid');
            $('#CCRE_ProcessingFee').removeClass('invalid');
            $('#CCRE_Rent').removeClass('invalid');
            $('#RecheckinForm').hide();
            $('#CC_fileupload').val('');
            $('input:checkbox[name=CCRE_process_waived]').attr("checked", false);
            $('input:checkbox[name=CCRE_Rent_Prorated]').attr("checked", false);
            $('input:checkbox[name=CCRE_process_waived]').attr("disabled", "disabled");
            $('input:checkbox[name=CCRE_Rent_Prorated]').attr("disabled", "disabled");
            $('#CCRE_Quarterly_fee').hide();
            $('#CCRE_Fixedaircon_fee').hide();
        }
        $(document).on('change', '.fileextensionchk', function () {
            var filename = $('#CC_fileupload').val();
            var valid_extensions = /(\.pdf)$/i;
            if (valid_extensions.test(filename)) {
            }
            else {
                show_msgbox("CUSTOMER RECHECKIN", 'UPLOAD ONLY PDF FILES', "success", false);
                $('#CC_fileupload').val('');
            }
        });
        $(document).on('change', '.proratedcheck', function () {
            var startdate = $('#CCRE_Startdate').val();
            var enddate = $('#CCRE_Enddate').val();
            var Rent = $('#CCRE_Rent').val();
            if (startdate != '' && enddate != '' && Rent != '') {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"Prorated_check",
                    data: {SD: startdate, ED: enddate},
                    success: function (data) {
                        if (data != 'true') {
                            $('input:checkbox[name=CCRE_Rent_Prorated]').attr('checked', false);
                            $('input:checkbox[name=CCRE_Rent_Prorated]').attr("disabled", 'disabled');
                        }
                        else {
                            $('input:checkbox[name=CCRE_Rent_Prorated]').attr('checked', true);
                            $('input:checkbox[name=CCRE_Rent_Prorated]').removeAttr("disabled");
                        }
                        $('.preloader').hide();
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else {
                $('input:checkbox[name=CCRE_Rent_Prorated]').attr('checked', false);
                $('input:checkbox[name=CCRE_Rent_Prorated]').attr("disabled", 'disabled');
            }
        });
    });
</script>
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>CUSTOMER RECHECKIN</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <!--         <form id="CRC_Form_CustomerRecheckin" class="form-horizontal" role="form">-->
                <div style="padding-left: 20px">
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>UNIT<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="CRC_AllUnits" required id="CRC_AllUnits" style="max-width:120px"><OPTION>SELECT</OPTION></SELECT>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>CUSTOMER NAME <span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="CRC_AllCustomers" required id="CRC_AllCustomers" disabled><OPTION>SELECT</OPTION></SELECT>
                        </div>
                        <div class="col-md-4">
                            <label class="errormsg" id="CustomeremptyErrormsg"></label>
                        </div>
                    </div>
                    <div id="multiplecustomerdiv" hidden>

                    </div>
                </div>
                <br>
                <div id="RecheckinForm" hidden>
                    <form id="CRC_Form_CustomerRecheckin" class="form-horizontal" role="form">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>FIRST NAME<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control autosize Customernamechange" name="CCRE_FirstName" maxlength="30" required id="CCRE_FirstName" placeholder="Customer FirstName"/>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="CCRE_CustomerId" maxlength="30" required id="CCRE_CustomerId" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>LAST NAME<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control autosize Customernamechange" name="CCRE_LastName" maxlength="30" required id="CCRE_LastName" placeholder="Customer LastName" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>COMPANY NAME</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control compautosize" name="CCRE_CompanyName" maxlength="50" required id="CCRE_CompanyName" placeholder="Company Name"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>COMPANY ADDRESS</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control compautosize" name="CCRE_CompanyAddress" maxlength="50" required id="CCRE_CompanyAddress" placeholder="Company Address"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>COMPANY POSTAL CODE</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="CCRE_CompanyPostalCode" maxlength="6" style="max-width:100px;" id="CCRE_CompanyPostalCode" placeholder="Postal Code" />
                            </div>
                            <div class="col-md-3"><label id="CCRE_lbl_postalerrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>E-MAIL ID<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="CCRE_Emailid" required id="CCRE_Emailid" />
                            </div>
                            <div class="col-md-3"><label id="CCRE_lbl_emailiderrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>MOBILE</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control numonlynozero mobilevalidation" name="CCRE_Mobile" maxlength="8" style="max-width:100px;" id="CCRE_Mobile" placeholder="Mobile"/>
                            </div>
                            <div class="col-md-3"><label id="CCRE_lbl_mobileerrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>INT'L MOBILE</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="CCRE_IntlMobile" maxlength="15" style="max-width:150px;" id="CCRE_IntlMobile" placeholder="Int'l Mobile"/>
                            </div>
                            <div class="col-md-3"><label id="CCRE_lbl_intlmobileerrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>OFFICE NO</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control numonlynozero officevalidation" name="CCRE_Officeno" maxlength="8" style="max-width:110px;" id="CCRE_Officeno" placeholder="Office No"/>
                            </div>
                            <div class="col-md-3"><label id="CCRE_lbl_officeerrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>DATE OF BIRTH</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="CCRE_DOB"  style="max-width:120px;" id="CCRE_DOB" placeholder="DateOf Birth"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>NATIONALITY<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control" name="CCRE_Nationality" maxlength="8" required id="CCRE_Nationality" >
                                    <OPTION>SELECT</OPTION>
                                </SELECT>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div id="passportnumber">
                                <div class="col-md-3">
                                    <label>PASSPORT NUMBER</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control alnumonlyzero" name="CCRE_PassportNo" maxlength="15" style="max-width:170px;" id="CCRE_PassportNo" placeholder="Passport No"/>
                            </div>
                            <div class="col-md-3"><label id="CCRE_lbl_passporterrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div id="passportdate">
                                <div class="col-md-3">
                                    <label>PASSPORT EXPIRY DATE</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control passportdatevalidation datenonmandtry" name="CCRE_PassportDate" maxlength="15" style="max-width:120px;" id="CCRE_PassportDate" placeholder="PassportDate">
                            </div>
                            <div class="col-md-5"><label id="CCRE_lbl_passportdateerrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div id="epnumber">
                                <div class="col-md-3">
                                    <label>EP NUMBER</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control alnumonlynozero" name="CCRE_EpNo" style="max-width:170px;" maxlength="15" id="CCRE_EpNo" placeholder="EP No"/>
                            </div>
                            <div class="col-md-5"><label id="CCRE_lbl_epnoerrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div id="EPdate">
                                <div class="col-md-3">
                                    <label>EP EXPIRY DATE</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control epdatevalidation" name="CCRE_EPDate" style="max-width:120px;" id="CCRE_EPDate" placeholder="EP Date"/>
                            </div>
                            <div class="col-md-3"><label id="CCRE_lbl_ep_dateerrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>UNIT NUMBER<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control Unitchange" name="CCRE_UnitNo" style="max-width:120px;" id="CCRE_UnitNo">
                                    <OPTION>SELECT</OPTION>
                                </SELECT>
                            </div>
                            <div class="col-md-5"><label id="CCRE_Roomtype_error" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group" id="RoomtypeDiv" hidden>
                            <div class="col-md-3">
                                <label>ROOM TYPE<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control" name="CCRE_RoomType" style="max-width:200px;" id="CCRE_RoomType">
                                    <OPTION>SELECT</OPTION>
                                </SELECT>
                            </div>

                        </div>
                        <div id="AccessCardDiv" hidden>
                            <div class="row form-group">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" class="CardNumbers"  name="AccessCard" id="CCRE_Cardnumber" value="Cardnumber">CARD NUMBER
                                </div>
                                <div class="col-md-3"><label id="CCRE_lbl_error" class="errormsg" hidden></label></div>
                            </div>
                            <div  id="CardNumbersdiv" hidden>

                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3">
                                    <input type="radio" class="CardNumbers" name="AccessCard" id="CCRE_Nullcard" value="Null">NULL
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CHECK IN DATE<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <input class="form-control prorated startdatevalidate datemandtry noticedate proratedcheck" name="CCRE_Startdate"  style="max-width:120px;" id="CCRE_Startdate" placeholder="Check In Date"/>
                                    </div>
                                    <div id="startdatediv" hidden>
                                        <div class="col-md-1">
                                            <label>FROM</label>
                                        </div>
                                        <div class="col-md-2">
                                            <SELECT class="form-control totimevalidation" name="CCRE_SDStarttime"  style="max-width:100px;" id="CCRE_SDStarttime">
                                                <OPTION>Select</OPTION>
                                            </SELECT>
                                        </div>
                                        <div id="startdatetotime" hidden>
                                            <div class="col-md-1">
                                                <label>TO</label>
                                            </div>
                                            <div class="col-md-2">
                                                <SELECT class="form-control" name="CCRE_SDEndtime"  style="max-width:100px;" id="CCRE_SDEndtime" hidden>
                                                    <OPTION>Select</OPTION>
                                                </SELECT>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" id="CusromerEnddate" hidden>
                            <div class="col-md-3">
                                <label>CHECK OUT DATE<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <input class="form-control noticedate datemandtry proratedcheck" name="CCRE_Enddate"  style="max-width:120px;" id="CCRE_Enddate" placeholder="Check Out Date"/>
                                    </div>
                                    <div class="col-md-1">
                                        <label>FROM</label>
                                    </div>
                                    <div class="col-md-2">
                                        <SELECT class="form-control" name="CCRE_EDStarttime"  style="max-width:100px;" id="CCRE_EDStarttime">
                                            <OPTION>Select</OPTION>
                                        </SELECT>
                                    </div>
                                    <div id="endatedateto" hidden>
                                        <div class="col-md-1">
                                            <label >TO</label>
                                        </div>
                                        <div class="col-md-2">
                                            <SELECT class="form-control" name="CCRE_EDEndtime"  style="max-width:100px;" id="CCRE_EDEndtime">
                                                <OPTION>Select</OPTION>
                                            </SELECT>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>NOTICE PERIOD</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control numonly" name="CCRE_NoticePeriod" maxlength="1" style="max-width:70px;" id="CCRE_NoticePeriod" placeholder="No"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>NOTICE PERIOD DATE</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="CCRE_NoticePeriodDate"  style="max-width:150px;" id="CCRE_NoticePeriodDate" placeholder="Notice Date"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>SELECT AIRCON FEE</label>
                            </div>
                            <div class="col-md-6">
                                <div class="row form-group">
                                    <div class="col-md-5">
                                        <input type="radio" class="Airconfeechange" name="Aircon" id="CCRE_Quaterlyfee" value="QuarterlyFee">QUARTERLY SERVICE FEE
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control CCRE_amtonlyvalidation" maxlength="6" style="max-width:120px;" name="CCRE_Quarterly_fee" id="CCRE_Quarterly_fee" placeholder="0.00"/>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-5">
                                        <input type="radio" class="Airconfeechange" name="Aircon" id="CCRE_Quaterlyfee" value="FixedAircon">FIXED AIRCON FEE
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control CCRE_amtonlyvalidation" maxlength="6" style="max-width:120px;" name="CCRE_Fixedaircon_fee" id="CCRE_Fixedaircon_fee" placeholder="0.00"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>ELECTRICITY CAPPED</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control CCRE_amtonlyvalidation" maxlength="6" name="CCRE_ElectricitycapFee"  style="max-width:100px;" id="CCRE_ElectricitycapFee" placeholder="0.00"/>
                            </div>
                            <div class="col-md-3"><label id="CCRE_lbl_electcaperrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CURTAIN DRY CLEANING FEE</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control CCRE_amtonlyvalidation" maxlength="6" name="CCRE_Curtain_DrycleanFee"  style="max-width:100px;" id="CCRE_Curtain_DrycleanFee" placeholder="0.00"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CHECKOUT CLEANING FEE</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control CCRE_amtonlyvalidation" maxlength="6" name="CCRE_CheckOutCleanFee"  style="max-width:100px;" id="CCRE_CheckOutCleanFee" placeholder="0.00"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>DEPOSIT</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control CCRE_amtonlyvalidationmaxdigit" maxlength="7" name="CCRE_DepositFee"  style="max-width:100px;" id="CCRE_DepositFee" placeholder="0.00"/>
                            </div>
                            <div class="col-md-3"><label id="CCRE_lbl_depositerrormsg" class="errormsg" hidden></label></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">RENT<em>*</em></label>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <input type="text" name="CCRE_Rent" id="CCRE_Rent" style="width:100px;" class="form-control CCRE_amtonlyvalidationmaxdigit proratedcheck" placeholder="0.00"/>
                                    </div>
                                    <div class="col-md-2" style="padding-right:10px;width:10px">
                                        <input type="checkbox" name="CCRE_Rent_Prorated" id="CCRE_Rent_Prorated" disabled />
                                    </div>
                                    <div class="col-md-3"><label id="CCRE_lbl_prorated"></label></div>
                                    <div class="col-md-6"><p id="CCRE_lbl_renterrormsg" class="errormsg" hidden></p></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PROCESSING COST</label>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <input type="text" name="CCRE_ProcessingFee" id="CCRE_ProcessingFee" style="width:100px;" class="form-control CCRE_processamtonlyvalidationmaxdigit" placeholder="0.00"/>
                                    </div>
                                    <div class="col-md-2" style="padding-right:10px;width:10px">
                                        <input type="checkbox" name="CCRE_process_waived" id="CCRE_process_waived" disabled />
                                    </div>
                                    <div class="col-md-3"><label id="CCRE_lbl_waived"></label></div>
                                    <div class="col-md-6"><p id="CCRE_lbl_processerrormsg" class="errormsg" hidden></p></div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>SELECT THE OPTION<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control" name="CCRE_Option"  style="max-width:200px;" id="CCRE_Option">
                                    <OPTION>SELECT</OPTION>
                                </SELECT>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>E-MAIL ID<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control" name="CCRE_MailList" id="CCRE_MailList">
                                    <OPTION>SELECT</OPTION>
                                </SELECT>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>COMMENTS</label>
                            </div>
                            <div class="col-md-3">
                                <textarea style="min-height:116px" class="form-control autogrowcomments" name="CCRE_Comments"  id="CCRE_Comments" placeholder="Comments"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>FILE UPLOAD</label>
                            </div>
                            <div class="col-md-3">
                                <input type="file" id="CC_fileupload" name="CC_fileupload" class="form-control fileextensionchk" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-offset-2 col-lg-3">
                                <input type="button" id="CCRE_btn_savebutton" class="btn" value="CREATE" disabled>         <input type="button" id="CustomerCreation_Reset" class="btn" value="RESET">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--        </form>-->
        </div>
    </div>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->
