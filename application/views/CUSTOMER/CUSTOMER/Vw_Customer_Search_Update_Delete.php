<html>
<head>
    <?php require_once('application/libraries/EI_HDR.php'); ?>
</head>
<script>
    $(document).ready(function() {
        $('#spacewidth').height('0%');
        $(".autosize").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
        $('#CCRE_SRC_Emailid').doValidation({rule:'email',prop:{uppercase:false,autosize:true}});
        $(".compautosize").doValidation({rule:'general',prop:{autosize:true}});
        $(".CCRE_numonlyvalidation").doValidation({rule:'numbersonly'});
        $(".CCRE_amtonlyvalidation").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        $(".CCRE_amtonlyvalidationmaxdigit").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $(".CCRE_processamtonlyvalidationmaxdigit").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
        $(".alphanumonly").doValidation({rule:'alphanumeric'});
        $("#CCRE_SRC_IntlMobile").doValidation({rule:'numbersonly',prop:{realpart:15,leadzero:true}});
        $("#CCRE_SRC_CompanyPostalCode").doValidation({rule:'numbersonly',prop:{realpart:6,leadzero:true}});
        $('.autogrowcomments').autogrow({onInitialize: true});
        var nationality;
        var errormsg;
        var allunits;
        var timelist;
        var emaillist;
        var ccoption;
        var prorated;
        var controller_url="<?php echo base_url(); ?>" + '/index.php/CUSTOMER/CUSTOMER/Ctrl_Customer_Search_Update_Delete/' ;
        $.ajax({
            type: "POST",
            url: controller_url+"CC_SRC_InitialDataLoad",
            data:{"Formname":'CustomerCreation',"ErrorList":'1,2,33,34,35,36,37,104,315,339,342,343,344,345,346,347,348,385,440,441,442,443,444,458,459,460,461'},
            success: function(data){
                $('.preloader').hide();
                var value_array=JSON.parse(data);
                errormsg=value_array[2];
                nationality=value_array[1];
                allunits=value_array[3];
                timelist=value_array[4];
                emaillist=value_array[5];
                ccoption=value_array[6];
                prorated=value_array[7];
                $('#CSRC_lbl_emailiderrormsg').text(errormsg[5].EMC_DATA);
                $('#CSRC_lbl_postalerrormsg').text(errormsg[12].EMC_DATA);
                $('#CSRC_lbl_mobileerrormsg').text(errormsg[9].EMC_DATA);
                $('#CSRC_lbl_intlmobileerrormsg').text(errormsg[9].EMC_DATA);
                $('#CSRC_lbl_officeerrormsg').text(errormsg[9].EMC_DATA);
                $('#CSRC_lbl_passporterrormsg').text(errormsg[10].EMC_DATA);
                $('#CSRC_lbl_epnoerrormsg').text(errormsg[11].EMC_DATA);
                $('#CSRC_lbl_postalerrormsg').text(errormsg[12].EMC_DATA);
                $('#CSRC_lbl_renterrormsg').text(errormsg[13].EMC_DATA);
                $('#CSRC_lbl_depositerrormsg').text(errormsg[14].EMC_DATA);
                $('#CSRC_lbl_processerrormsg').text(errormsg[15].EMC_DATA);
                $('#CSRC_lbl_electcaperrormsg').text(errormsg[16].EMC_DATA);
                $('#CSRC_lbl_passportnodateerrormsg').text(errormsg[21].EMC_DATA);
                $('#CSRC_lbl_epnodateerrormsg').text(errormsg[22].EMC_DATA);
                $('#CSRC_lbl_pportdateerrormsg').text(errormsg[26].EMC_DATA);
                $('#CSRC_lbl_ep_dateerrormsg').text(errormsg[25].EMC_DATA);
                var options='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < value_array[0].length; i++)
                {
                    var data=value_array[0][i];
                    if(data.CCN_ID!=40)
                    {
                        options += '<option value="' + data.CCN_ID + '">' + data.CCN_DATA + '</option>';
                    }
                }
                $('#CC_SRC_SearchOption').html(options);

            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
        var AllcustomerArray=[];
        var AllcompanyArray=[];
        var AllcradsArray=[];
        var AllEmailsArray=[]
        var AllEPnoArray=[];
        var AllPassportnoArray=[];
        var AllMobilenoArray=[];
        var AllIntMobilenoArray=[];
        var AllOfficenoArray=[];
        var AllCommentsArray=[];
        $(document).on('change','#CC_SRC_SearchOption',function() {
            $('#CSRC_updation_form').hide();
            $('#tableempty_message').text('');
            $('#Accesscardheader').text('');
            $('#CC_SEARCH_DataTable').hide();
            $('#CC_SEARCH_acDataTable').hide();
            var searchoption=$('#CC_SRC_SearchOption').val();
            if(searchoption!='SELECT') {
                $('.preloader').show();
                $('#CC_SearchformDiv').html('').show();
                if (searchoption == 21) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "CustomerName",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">CUSTOMER NAME SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3" ><label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><input type=text class="form-control autosize customernameautovalidate" name="CC_SRC_CustomerNameSearch"  id="CC_SRC_CustomerNameSearch"/></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                var data = value_array[i].CUSTOMER_FIRST_NAME + '  ' + value_array[i].CUSTOMER_LAST_NAME;
                                AllcustomerArray.push(data);
                            }
                            AllcustomerArray = unique(AllcustomerArray);
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_CustomerNameSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 18) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "CustomerCardNos",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">CARD NUMBER SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>CARD NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><input type=text class="form-control customernameautovalidate" name="CC_SRC_CardNoSearch" maxlength="7"  id="CC_SRC_CardNoSearch" style="max-width: 150px;"/></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                if (value_array[i].UASD_ACCESS_CARD != '' && value_array[i].UASD_ACCESS_CARD != null) {
                                    AllcradsArray.push(value_array[i].UASD_ACCESS_CARD);
                                }
                            }
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_CardNoSearch").doValidation({
                                rule: 'numbersonly',
                                prop: {realpart: 7, leadzero: true}
                            });
                            $("#CC_SRC_CardNoSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 19) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "CustomerCompnameName",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">COMPANY NAME SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>COMPANY NAME<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><input type=text class="form-control autosize customernameautovalidate" name="CC_SRC_CompanyNameSearch"  id="CC_SRC_CompanyNameSearch"/></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                if (value_array[i].CCD_COMPANY_NAME != '' && value_array[i].CCD_COMPANY_NAME != null) {
                                    AllcompanyArray.push(value_array[i].CCD_COMPANY_NAME);
                                }
                            }
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_CompanyNameSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 22) {
                    var appenddata = '<h4 style="color:#498af3;">DEPOSIT AMOUNT SEARCH</h4><br>';
                    appenddata += '<div class="row form-group" style="padding-left:20px;">';
                    appenddata += '<div class="col-md-3"><label>FROM AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata += '<div class="col-md-3"><input type=text class="form-control CCRE_amtonlyvalidationmaxdigit AmountValidation" name="CC_SRC_FromAmount"  id="CC_SRC_FromAmount" style="max-width: 100px" placeholder="0.00"/></div>';
                    appenddata += '</div>';
                    appenddata += '<div class="row form-group" style="padding-left:20px;">';
                    appenddata += '<div class="col-md-3"><label>TO AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata += '<div class="col-md-3"><input type=text class="form-control CCRE_amtonlyvalidationmaxdigit AmountValidation" name="CC_SRC_ToAmount"  id="CC_SRC_ToAmount" style="max-width: 100px" placeholder="0.00"/></div>';
                    appenddata += '<div class="col-md-5"><label id="depositamterrormsg" class="errormsg" hidden></label></div>';
                    appenddata += '</div>';
                    appenddata += '<div class="row form-group">';
                    appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                    appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                    $('#CC_SearchformDiv').html(appenddata);
                    $(".CCRE_amtonlyvalidationmaxdigit").doValidation({
                        rule: 'numbersonly',
                        prop: {realpart: 5, imaginary: 2}
                    });
                    $('#depositamterrormsg').text(errormsg[7].EMC_DATA);
                    $('.preloader').hide();
                }
                else if (searchoption == 30) {
                    var appenddata = '<h4 style="color:#498af3;">RENT AMOUNT SEARCH</h4><br>';
                    appenddata += '<div class="row form-group" style="padding-left:20px;">';
                    appenddata += '<div class="col-md-3"><label>FROM AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata += '<div class="col-md-3"><input type=text class="form-control CCRE_amtonlyvalidationmaxdigit AmountValidation" name="CC_SRC_FromAmount"  id="CC_SRC_FromAmount" style="max-width: 100px" placeholder="0.00"/></div>';
                    appenddata += '</div>';
                    appenddata += '<div class="row form-group" style="padding-left:20px;">';
                    appenddata += '<div class="col-md-3"><label>TO AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata += '<div class="col-md-3"><input type=text class="form-control CCRE_amtonlyvalidationmaxdigit AmountValidation" name="CC_SRC_ToAmount"  id="CC_SRC_ToAmount" style="max-width: 100px" placeholder="0.00"/></div>';
                    appenddata += '<div class="col-md-5"><label id="depositamterrormsg" class="errormsg" hidden></label></div>';
                    appenddata += '</div>';
                    appenddata += '<div class="row form-group">';
                    appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                    appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                    $('#CC_SearchformDiv').html(appenddata);
                    $(".CCRE_amtonlyvalidationmaxdigit").doValidation({
                        rule: 'numbersonly',
                        prop: {realpart: 5, imaginary: 2}
                    });
                    $('#depositamterrormsg').text(errormsg[7].EMC_DATA);
                    $('.preloader').hide();
                }
                else if (searchoption == 27) {
                    var appenddata = '<h4 style="color:#498af3;">NATIONALITY SEARCH</h4><br>';
                    appenddata += '<div class="row form-group" style="padding-left:20px;">';
                    appenddata += '<div class="col-md-3"><label>NATIONALITY<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata += '<div class="col-md-3"><SELECT class="form-control" name="CC_SRC_listsearch"  id="CC_SRC_listsearch" ></SELECT></div>';
                    appenddata += '</div>';
                    appenddata += '<div class="row form-group">';
                    appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                    appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                    $('#CC_SearchformDiv').html(appenddata);
                    var options = '<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < nationality.length; i++) {
                        var data = nationality[i];
                        options += '<option value="' + data.NC_DATA + '">' + data.NC_DATA + '</option>';
                    }
                    $('#CC_SRC_listsearch').html(options);
                    $('.preloader').hide();
                }
                else if (searchoption == 31) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "AllUnits",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">UNIT NUMBER SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>UNIT NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><SELECT class="form-control" name="CC_SRC_listsearch"  id="CC_SRC_listsearch" style="max-width: 120px"></SELECT></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            var options = '<OPTION>SELECT</OPTION>';
                            for (var i = 0; i < value_array.length; i++) {
                                var data = value_array[i];
                                options += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                            }
                            $('#CC_SRC_listsearch').html(options);
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 33) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "AllRoomtype",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">ROOMTYPE SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>ROOMTYPE<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><SELECT class="form-control" name="CC_SRC_listsearch"  id="CC_SRC_listsearch" style="max-width: 170px"></SELECT></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            var options = '<OPTION>SELECT</OPTION>';
                            for (var i = 0; i < value_array.length; i++) {
                                var data = value_array[i];
                                options += '<option value="' + data.URTD_ROOM_TYPE + '">' + data.URTD_ROOM_TYPE + '</option>';
                            }
                            $('#CC_SRC_listsearch').html(options);
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 24) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "AllEmails",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">EMAIL ID SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>EMAIL ID<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><input type=text class="form-control customernameautovalidate" name="CC_SRC_EmailSearch"  id="CC_SRC_EmailSearch"/></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                if (value_array[i].CPD_EMAIL != '' && value_array[i].CPD_EMAIL != null) {
                                    AllEmailsArray.push(value_array[i].CPD_EMAIL);
                                }
                            }
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_EmailSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 25) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "AllEPNumbers",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">EP NUMBER SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>EP NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><input type=text class="form-control autosize customernameautovalidate" name="CC_SRC_EPnoSearch"  id="CC_SRC_EPnoSearch"/></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                if (value_array[i].CPD_EP_NO != '' && value_array[i].CPD_EP_NO != null) {
                                    AllEPnoArray.push(value_array[i].CPD_EP_NO);
                                }
                            }
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_EPnoSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 29) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "AllPassPortNumbers",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">PASSPORT NUMBER SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>PASSPORT NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><input type=text class="form-control autosize customernameautovalidate" name="CC_SRC_PassportnoSearch"  id="CC_SRC_PassportnoSearch"/></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                if (value_array[i].CPD_PASSPORT_NO != '' && value_array[i].CPD_PASSPORT_NO != null) {
                                    AllPassportnoArray.push(value_array[i].CPD_PASSPORT_NO);
                                }
                            }
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_PassportnoSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 26) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "AllMobileNumbers",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">MOBILE NUMBER SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>MOBILE NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><input type=text class="form-control autosize customernameautovalidate" name="CC_SRC_MobilenoSearch"  id="CC_SRC_MobilenoSearch"/></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                if (value_array[i].CPD_MOBILE != '' && value_array[i].CPD_MOBILE != null) {
                                    AllMobilenoArray.push(value_array[i].CPD_MOBILE);
                                }
                            }
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_MobilenoSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 32) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "AllIntMobileNumbers",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">INTL MOBILE NUMBER SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>INTL MOBILE NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><input type=text class="form-control autosize customernameautovalidate" name="CC_SRC_IntMobilenoSearch"  id="CC_SRC_IntMobilenoSearch"/></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                if (value_array[i].CPD_INTL_MOBILE != '' && value_array[i].CPD_INTL_MOBILE != null) {
                                    AllIntMobilenoArray.push(value_array[i].CPD_INTL_MOBILE);
                                }
                            }
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_IntMobilenoSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 28) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "AllOfficeNumbers",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">OFFICE NUMBER SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>OFFICE NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><input type=text class="form-control autosize customernameautovalidate" name="CC_SRC_OfficenoSearch"  id="CC_SRC_OfficenoSearch"/></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                if (value_array[i].CCD_OFFICE_NO != '' && value_array[i].CCD_OFFICE_NO != null) {
                                    AllOfficenoArray.push(value_array[i].CCD_OFFICE_NO);
                                }
                            }
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_OfficenoSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 20) {
                    $.ajax({
                        type: "POST",
                        url: controller_url + "AllComments",
                        success: function (data) {
                            var value_array = JSON.parse(data);
                            var appenddata = '<h4 style="color:#498af3;">COMMENTS SEARCH</h4><br>';
                            appenddata += '<div class="row form-group" style="padding-left:20px;">';
                            appenddata += '<div class="col-md-3"><label>COMMENTS<span class="labelrequired"><em>*</em></span></label></div>';
                            appenddata += '<div class="col-md-3"><textarea class="form-control  customernameautovalidate" name="CC_SRC_CommentsSearch"  id="CC_SRC_CommentsSearch"></textarea></div>';
                            appenddata += '<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                            appenddata += '</div>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                            appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                            $('#CC_SearchformDiv').html(appenddata);
                            for (var i = 0; i < value_array.length; i++) {
                                if (value_array[i].CPD_COMMENTS != '' && value_array[i].CPD_COMMENTS != null) {
                                    AllCommentsArray.push(value_array[i].CPD_COMMENTS);
                                }
                            }
                            $('#customernameautocompleteerrormsg').text(errormsg[17].EMC_DATA);
                            $("#CC_SRC_CommentsSearch").focus();
                            $('.preloader').hide();
                        },
                        error: function (data) {
                            alert('error in getting' + JSON.stringify(data));
                            $('.preloader').hide();
                        }
                    });
                }
                else if (searchoption == 23) {
                    var appenddata = '<h4 style="color:#498af3;">DOB SEARCH</h4><br>';
                    appenddata += '<div class="row form-group" style="padding-left:20px;">';
                    appenddata += '<div class="col-md-3"><label>FROM DATE<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata += '<div class="col-md-3"><input type=text class="form-control dobvalidation" name="CC_SRC_Fromdate"  id="CC_SRC_Fromdate" style="max-width: 150px"/></div>';
                    appenddata += '</div>';
                    appenddata += '<div class="row form-group" style="padding-left:20px;">';
                    appenddata += '<div class="col-md-3"><label>TO DATE<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata += '<div class="col-md-3"><input type=text class="form-control dobvalidation" name="CC_SRC_Todate"  id="CC_SRC_Todate" style="max-width: 150px"/></div>';
//             appenddata+='<div class="col-md-5"><label id="depositamterrormsg" class="errormsg" hidden></label></div>';
                    appenddata += '</div>';
                    appenddata += '<div class="row form-group">';
                    appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                    appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                    $('#CC_SearchformDiv').html(appenddata);
                    $('#CC_SRC_Fromdate').datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeYear: true,
                        changeMonth: true,
                        yearRange: '1920:' + CCRE_year + '',
                        defaultDate: CCRE_d
                    });
                    $("#CC_SRC_Todate").datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeYear: true,
                        changeMonth: true
                    });
                    $('#CC_SRC_Todate').datepicker("option", "maxDate", new Date());
                    $('.preloader').hide();
                }
                else if (searchoption == 34) {
                    var appenddata = '<h4 style="color:#498af3;">LEASE PERIOD SEARCH</h4><br>';
                    appenddata += '<div class="row form-group" style="padding-left:20px;">';
                    appenddata += '<div class="col-md-3"><label>LEASE PERIOD<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata += '<div class="col-md-3"><input type="text" class="form-control" name="CC_SRC_Leaseperiod"  id="CC_SRC_Leaseperiod" /></div>';
                    appenddata += '</div>';
                    appenddata += '<div class="row form-group">';
                    appenddata += '<div class="col-lg-offset-2 col-lg-2">';
                    appenddata += '<input type="button" id="CC_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                    $('#CC_SearchformDiv').html(appenddata);
                    $('#CC_SRC_Leaseperiod').datepicker({
                        changeMonth: true,      //provide option to select Month
                        changeYear: true,       //provide option to select year
                        showButtonPanel: true,  // button panel having today and done button
                        dateFormat: 'MM-yy',    //set date format
                        onClose: function (dateText, inst) {
                            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                            $(this).datepicker('setDate', new Date(year, month, 1));//here set the date when closing.
                            $(this).blur();//remove focus input box
                            leaseperiodvalidation();
                        }
                    });
                    $("#CC_SRC_Leaseperiod").focus(function () {
                        $(".ui-datepicker-calendar").hide();
                        $("#ui-datepicker-div").position({
                            my: "center top",
                            at: "center bottom",
                            of: $(this)
                        });
                    });
                    $('.preloader').hide();
                }
            }else{
                $('#CC_SearchformDiv').html('');
            }
        });
        //////////////LEASE PERIOD///////////////////////////////
        function leaseperiodvalidation()
        {
            if($('#CC_SRC_Leaseperiod').val()!="")
            {
                $("#CC_src_btn_search").removeAttr("disabled");
            }
            else
            {
                $("#CC_src_btn_search").attr("disabled", "disabled");
            }
        }
        $(document).on('change','#CC_SRC_listsearch',function() {
            if($('#CC_SRC_listsearch').val()!="SELECT")
            {
                $("#CC_src_btn_search").removeAttr("disabled");
            }
            else
            {
                $("#CC_src_btn_search").attr("disabled", "disabled");
            }
        });
        $(document).on('change','.dobvalidation',function() {
            if($('#CC_SRC_Fromdate').val()!="" && $('#CC_SRC_Todate').val()!="")
            {
                $("#CC_src_btn_search").removeAttr("disabled");
            }
            else
            {
                $("#CC_src_btn_search").attr("disabled", "disabled");
            }
        });
        $(document).on('change','.AmountValidation',function() {
            var CERM_SRC_fromamt=$('#CC_SRC_FromAmount').val();
            var CERM_SRC_toamt=$('#CC_SRC_ToAmount').val();
            if(CERM_SRC_fromamt!='' && CERM_SRC_toamt!='')
            {
                if(parseFloat(CERM_SRC_fromamt)<=parseFloat(CERM_SRC_toamt))
                {
                    $("#CC_src_btn_search").removeAttr("disabled");
                    $('#depositamterrormsg').hide();
                }
                else
                {
                    $('#depositamterrormsg').show();
                    $("#CC_src_btn_search").attr("disabled", "disabled");
                }
            }
            else
            {
                $("#CC_src_btn_search").attr("disabled", "disabled");
            }
        });
        function unique(array){
            var unique = {};
            var distinct = [];
            for( var i in array ){
                if( typeof(unique[array[i]]) == "undefined"){
                    distinct.push(array[i]);
                }
                unique[array[i]] = 0;
            }
            return distinct;
        }
        ///CUSTOMERNAME AUTO COMPLTE///
        var CC_customerflag;
        $(document).on('keypress','#CC_SRC_CustomerNameSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_CustomerNameSearch").autocomplete({
                source: AllcustomerArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CC_SRC_CompanyNameSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_CompanyNameSearch").autocomplete({
                source: AllcompanyArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CC_SRC_CardNoSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_CardNoSearch").autocomplete({
                source: AllcradsArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CC_SRC_EmailSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_EmailSearch").autocomplete({
                source: AllEmailsArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CC_SRC_EPnoSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_EPnoSearch").autocomplete({
                source: AllEPnoArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CC_SRC_PassportnoSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_PassportnoSearch").autocomplete({
                source: AllPassportnoArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CC_SRC_MobilenoSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_MobilenoSearch").autocomplete({
                source: AllMobilenoArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CC_SRC_IntMobilenoSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_IntMobilenoSearch").autocomplete({
                source: AllIntMobilenoArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CC_SRC_OfficenoSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_OfficenoSearch").autocomplete({
                source: AllOfficenoArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CC_SRC_CommentsSearch',function() {
            CC_customerflag=0;
            CC_SEARCH_invfromhighlightSearchText();
            $("#CC_SRC_CommentsSearch").autocomplete({
                source: AllCommentsArray,
                select: CC_SEARCH_AutoCompleteSelectHandler
            });
        });
        /**********CUSTOMER AUTO ERROR MESSAGE******************/
        $(document).on('change','.customernameautovalidate',function(){
            if(CC_customerflag==1){
                $('#customernameautocompleteerrormsg').hide();
            }
            else
            {
                $('#customernameautocompleteerrormsg').show();
                $("#CC_src_btn_search").attr("disabled", "disabled");
            }
            if($('#CC_SRC_CustomerNameSearch').val()=="")
            {
                $('#customernameautocompleteerrormsg').hide();
                $("#CC_src_btn_search").attr("disabled", "disabled");
            }
        });
        function CC_SEARCH_AutoCompleteSelectHandler(event, ui) {
            CC_customerflag=1;
            $('#customernameautocompleteerrormsg').hide();
            $('#CC_src_btn_search').removeAttr("disabled");
        }

        //FUNCTION TO HIGHLIGHT SEARCH TEXT//
        function CC_SEARCH_invfromhighlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            };}
        //SEARCH DETAILS
        $(document).on('click','#CC_src_btn_search',function(){
            $('#CSRC_updation_form').hide();
            $('#tableempty_message').text('');
            $('#Accesscardheader').text('');
            var searchoption=$('#CC_SRC_SearchOption').val();
            $('.preloader').show();
            $('#CC_SEARCH_DataTable').hide();
            $('#CC_SEARCH_acDataTable').hide();
            $("#CC_src_btn_search").attr("disabled", "disabled");
            var CSRC_customer_acc_detailstitle="CUSTOMER ACCOUNT DETAILS - "
            var CSRC_customer_acc_detailsemptytitle="RECORDS NOT AVAILABLE FOR SELECTED "
            if(searchoption==18)
            {
                var companyname=$('#CC_SRC_CardNoSearch').val();
                var data={"SearchOption":searchoption,"data1":companyname}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" CARD NO : "+companyname;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" CARD NO: "+companyname;
//             $('#CC_SRC_CardNoSearch').val('');
            }
            if(searchoption==19)
            {
                var companyname=$('#CC_SRC_CompanyNameSearch').val();
                var data={"SearchOption":searchoption,"data1":companyname}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" COMPANY NAME : "+companyname;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" COMPANY NAME: "+companyname;
//             $('#CC_SRC_CompanyNameSearch').val('');
            }
            if(searchoption==21)
            {
                var customer_name=$('#CC_SRC_CustomerNameSearch').val();
                var customername=customer_name.replace('  ','_');
                var data={"SearchOption":searchoption,"data1":customername}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" CUSTOMER NAME : "+customer_name;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" CUSTOMER NAME: "+customer_name;
//             $('#CC_SRC_CustomerNameSearch').val('');
            }
            if(searchoption==22)
            {
                var CC_SRC_fromamt=$('#CC_SRC_FromAmount').val();
                var CC_SRC_toamt=$('#CC_SRC_ToAmount').val();
                var data={"SearchOption":searchoption,"data1":CC_SRC_fromamt,"data2":CC_SRC_toamt}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" DEPOSIT AMOUNT RANGE: "+CC_SRC_fromamt+" To "+CC_SRC_toamt
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" DEPOSIT AMOUNT RANGE: "+CC_SRC_fromamt+" To "+CC_SRC_toamt;
//             $('#CC_SRC_FromAmount').val('');
//             $('#CC_SRC_ToAmount').val('');
            }
            if(searchoption==30)
            {
                var CC_SRC_fromamt=$('#CC_SRC_FromAmount').val();
                var CC_SRC_toamt=$('#CC_SRC_ToAmount').val();
                var data={"SearchOption":searchoption,"data1":CC_SRC_fromamt,"data2":CC_SRC_toamt}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" RENT AMOUNT RANGE: "+CC_SRC_fromamt+" To "+CC_SRC_toamt
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" RENT AMOUNT RANGE: "+CC_SRC_fromamt+" To "+CC_SRC_toamt;
//             $('#CC_SRC_FromAmount').val('');
//             $('#CC_SRC_ToAmount').val('');
            }
            if(searchoption==27)
            {
                var CC_SRC_fromamt=$('#CC_SRC_listsearch').val();
                var data={"SearchOption":searchoption,"data1":CC_SRC_fromamt,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" NATIONALITY : "+CC_SRC_fromamt;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" NATIONALITY: "+CC_SRC_fromamt;
//             $('#CC_SRC_listsearch').val('SELECT');
            }
            if(searchoption==31)
            {
                var Unit=$('#CC_SRC_listsearch').val();
                var data={"SearchOption":searchoption,"data1":Unit,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" UNIT NO : "+Unit;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" UNIT NO: "+Unit;
//             $('#CC_SRC_listsearch').val('SELECT');
            }
            if(searchoption==33)
            {
                var Roomtype=$('#CC_SRC_listsearch').val();
                var data={"SearchOption":searchoption,"data1":Roomtype,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" ROOM TYPE : "+Roomtype;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" ROOM TYPE: "+Roomtype;
//             $('#CC_SRC_listsearch').val('SELECT');
            }
            if(searchoption==24)
            {
                var Email=$('#CC_SRC_EmailSearch').val();
                var data={"SearchOption":searchoption,"data1":Email,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" EMAIL ID : "+Email;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" EMAIL ID: "+Email;
//             $('#CC_SRC_EmailSearch').val('');
            }
            if(searchoption==25)
            {
                var Epno=$('#CC_SRC_EPnoSearch').val();
                var data={"SearchOption":searchoption,"data1":Epno,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" EP NUMBER : "+Epno;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" EP NUMBER: "+Epno;
//             $('#CC_SRC_EPnoSearch').val('');
            }
            if(searchoption==29)
            {
                var Passportno=$('#CC_SRC_PassportnoSearch').val();
                var data={"SearchOption":searchoption,"data1":Passportno,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" PASSPORT NUMBER : "+Passportno;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" PASSPORT NUMBER: "+Passportno;
//             $('#CC_SRC_PassportnoSearch').val('');
            }
            if(searchoption==26)
            {
                var Mobile=$('#CC_SRC_MobilenoSearch').val();
                var data={"SearchOption":searchoption,"data1":Mobile,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" MOBILE NUMBER : "+Mobile;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" MOBILE NUMBER: "+Mobile;
//             $('#CC_SRC_MobilenoSearch').val('');
            }
            if(searchoption==32)
            {
                var Mobile=$('#CC_SRC_IntMobilenoSearch').val();
                var data={"SearchOption":searchoption,"data1":Mobile,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" INT'L NUMBER : "+Mobile;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" INT'L NUMBER : "+Mobile;
//             $('#CC_SRC_IntMobilenoSearch').val('');
            }
            if(searchoption==28)
            {
                var Mobile=$('#CC_SRC_OfficenoSearch').val();
                var data={"SearchOption":searchoption,"data1":Mobile,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" OFFICE NUMBER : "+Mobile;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" OFFICE NUMBER : "+Mobile;
//             $('#CC_SRC_OfficenoSearch').val('');
            }
            if(searchoption==20)
            {
                var Comments=$('#CC_SRC_CommentsSearch').val();
                var data={"SearchOption":searchoption,"data1":Comments,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" COMMENTS : "+Comments;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" COMMENTS : "+Comments;
//             $('#CC_SRC_CommentsSearch').val('');
            }
            if(searchoption==23)
            {
                var fromdate=$('#CC_SRC_Fromdate').val();
                var todate=$('#CC_SRC_Todate').val();
                var data={"SearchOption":searchoption,"data1":fromdate,"data2":todate}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" DOB: "+fromdate+" To "+todate;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" DOB: "+fromdate+" To "+todate;
//             $('#CC_SRC_Fromdate').val('')
//             $('#CC_SRC_Todate').val('');
            }
            if(searchoption==34)
            {
                var fromdate=$('#CC_SRC_Leaseperiod').val();
                var data={"SearchOption":searchoption,"data1":fromdate,"data2":''}
                var CSRC_customerheader=CSRC_customer_acc_detailstitle+" LEASE PERIOD : "+fromdate;
                var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" LEASE PERIOD : "+fromdate;
//             $('#CC_SRC_Leaseperiod').val('')
            }
            $.ajax({
                type: "POST",
                url: controller_url+"SearchDataResults",
                data:data,
                success: function(data){
                    var value_array=JSON.parse(data);
                    if(value_array.length!=0)
                    {
                        CustomerTableLoading(value_array);
                        $('#tableempty_message').text('');
                        $('#Accesscardheader').text(CSRC_customerheader);
                        $('.preloader').hide();
                    }
                    else
                    {
                        $('#tableempty_message').text(CSRC_emptycustomerheader);
                        $('#Accesscardheader').text('');
                        $('.preloader').hide();
                    }
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });

        });
        function CustomerTableLoading(value_array)
        {
            var CustpmerPersonal_Tabledata='<table style="width: 3500px" id="Customer_Personal_Datatable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr>';
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:100px;'>CUSTOMER ID</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:200px;'>CUSTOMER FIRSTNAME</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:200px;'>CUSTOMER LASTNAME</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:200px;'>COMPANYNAME</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:200px;'>COMPANY ADDRESS</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:100px;'>POSTAL CODE</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:200px;' data-column-index='6' tabindex='0'>EMAIL</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:100px;'>MOBILE</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:150px;'>INT'L MOBILE</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:100px;'>OFFICE</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:100px;' class='uk-date-column'>DOB</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:150px;'>NATIONALITY</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:100px;'>PASSPORTNO</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:100px;' class='uk-date-column'>PASSPORTDATE</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:100px;'>EPNO</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:100px;' class='uk-date-column'>EPDATE</th>";
            CustpmerPersonal_Tabledata+="<th style='text-align:center;vertical-align: top;width:800px;'>COMMENTS</th>";
            CustpmerPersonal_Tabledata+="</tr></thead><tbody>";
            var CustomerPersonalDetailsarray=[];
            for(var i=0;i<value_array.length;i++)
            {
                if(value_array[i].CCD_COMPANY_NAME==null){var companyname='';}else{companyname=value_array[i].CCD_COMPANY_NAME;}
                if(value_array[i].CCD_COMPANY_ADDR==null){var companyaddress='';}else{companyaddress=value_array[i].CCD_COMPANY_ADDR;}
                if(value_array[i].CCD_POSTAL_CODE==null){var companypostalcode='';}else{companypostalcode=value_array[i].CCD_POSTAL_CODE;}
                if(value_array[i].CPD_MOBILE==null){var mobile='';}else{mobile=value_array[i].CPD_MOBILE;}
                if(value_array[i].CPD_INTL_MOBILE==null){var intlmobile='';}else{intlmobile=value_array[i].CPD_INTL_MOBILE;}
                if(value_array[i].CCD_OFFICE_NO==null){var office='';}else{office=value_array[i].CCD_OFFICE_NO;}
                if(value_array[i].CPD_DOB==null){var dob='';}else{dob=value_array[i].CPD_DOB;}
                if(value_array[i].CPD_PASSPORT_NO==null){var passportno='';}else{passportno=value_array[i].CPD_PASSPORT_NO;}
                if(value_array[i].CPD_PASSPORT_DATE==null){var passportdate='';}else{passportdate=value_array[i].CPD_PASSPORT_DATE;}
                if(value_array[i].CPD_EP_NO==null){var epno='';}else{epno=value_array[i].CPD_EP_NO;}
                if(value_array[i].CPD_PASSPORT_DATE==null){var epdate='';}else{epdate=value_array[i].CPD_PASSPORT_DATE;}
                if(value_array[i].CPD_COMMENTS==null){var Comments='';}else{Comments=value_array[i].CPD_COMMENTS;}
                var datas=[value_array[i].CUSTOMER_ID,value_array[i].CUSTOMER_FIRST_NAME,value_array[i].CUSTOMER_LAST_NAME,companyname,companyaddress,companypostalcode,value_array[i].CPD_EMAIL,mobile,intlmobile,office,dob,value_array[i].NC_DATA,passportno,passportdate,epno,epdate,Comments];
                CustomerPersonalDetailsarray.push(datas);
            }
            CustomerPersonalDetailsarray=unique(CustomerPersonalDetailsarray);
            for(var i=0;i<CustomerPersonalDetailsarray.length;i++)
            {
                var custid=CustomerPersonalDetailsarray[i][0];
                CustpmerPersonal_Tabledata+='<tr style="text-align: center !important;">' +
                    '<td >'+custid+'</td>' +
                    '<td >'+CustomerPersonalDetailsarray[i][1]+'</td>' +
                    '<td >'+CustomerPersonalDetailsarray[i][2]+'</td>' +
                    '<td >'+CustomerPersonalDetailsarray[i][3]+'</td>' +
                    '<td >'+CustomerPersonalDetailsarray[i][4]+'</td>' +
                    '<td >'+CustomerPersonalDetailsarray[i][5]+'</td>' +
                    '<td >'+CustomerPersonalDetailsarray[i][6]+'</td>' +
                    "<td >"+CustomerPersonalDetailsarray[i][7]+"</td>" +
                    "<td >"+CustomerPersonalDetailsarray[i][8]+"</td>" +
                    "<td >"+CustomerPersonalDetailsarray[i][9]+"</td>" +
                    "<td >"+CustomerPersonalDetailsarray[i][10]+"</td>" +
                    "<td >"+CustomerPersonalDetailsarray[i][11]+"</td>" +
                    "<td >"+CustomerPersonalDetailsarray[i][12]+"</td>" +
                    "<td >"+CustomerPersonalDetailsarray[i][13]+"</td>" +
                    "<td >"+CustomerPersonalDetailsarray[i][14]+"</td>" +
                    "<td >"+CustomerPersonalDetailsarray[i][15]+"</td>" +
                    "<td >"+CustomerPersonalDetailsarray[i][16]+"</td></tr>";
            }
            CustpmerPersonal_Tabledata+="</body>";
            $('#Customer_Personal_Table').html(CustpmerPersonal_Tabledata);
            $('#Customer_Personal_Datatable').DataTable( {
                "sDom":"Rlfrtip",
                "deferRender":    true,
                "scrollY": 200,
                "scrollX": 500,
                "scrollCollapse": true,
                "aoColumnDefs": [{"aTargets": ["uk-date-column"],"sType": "uk_date"}, {"aTargets": ["uk-timestp-column"], "sType": "uk_timestp"}]
            });
            var CustpmerAccount_Tabledata='<table style="width: 3500px" id="Customer_Account_Datatable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr>';
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>UPDATE / DELETE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>CUSTOMER ID</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>UNIT NUMBER</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top' class='uk-date-column'>STARTDATE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top' class='uk-date-column'>ENDDATE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top' class='uk-date-column'>PRETERMINATE DATE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top' class='uk-date-column'>CANCELDATE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>LEASE PERIOD</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>ROOM TYPE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>CARD NO</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>GUEST CARD</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>PRETERMINATE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>EXTENSION</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>RECHECKIN</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>TERMINATE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>LEASE PERIOD DURATION</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>QUARTERS</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>NOTICE PERIOD</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top' class='uk-date-column'>NOTICE PERIOD DATE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>DEPOSIT</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>RENT</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>PRORATED</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>PROCESSING FEE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>WAIVED</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>QUARTERLY SERVICE FEE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>FIXED AIRCON FEE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>ELECTRICITY CAPPED</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>CURTAIN DRYCLEANING FEE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>CHECKOUT CLEANING FEE</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top'>USERSTAMP</th>";
            CustpmerAccount_Tabledata+="<th style='text-align:center;vertical-align: top' class='uk-timestp-column'>TIMESTAMP</th>";
            CustpmerAccount_Tabledata+="</tr></thead><tbody>";
            for(var i=0;i<value_array.length;i++)
            {
                if(value_array[i].CLP_PRETERMINATE_DATE==null){var preterminatedate='';}else{preterminatedate=value_array[i].CLP_PRETERMINATE_DATE;}
                if(value_array[i].CED_CANCEL_DATE==null){var canceldate='';}else{canceldate=value_array[i].CED_CANCEL_DATE;}
                if(value_array[i].UASD_ACCESS_CARD==null){var accesscard='';}else{accesscard=value_array[i].UASD_ACCESS_CARD;}
                if(value_array[i].CLP_GUEST_CARD==null){var guestcard='';}else{guestcard=value_array[i].CLP_GUEST_CARD;}
                if(value_array[i].CED_PRETERMINATE==null){var preterminate='';}else{preterminate=value_array[i].CED_PRETERMINATE;}
                if(value_array[i].CED_EXTENSION==null){var extension='';}else{extension=value_array[i].CED_EXTENSION;}
                if(value_array[i].CED_RECHECKIN==null){var recheckin='';}else{recheckin=value_array[i].CED_RECHECKIN;}
                if(value_array[i].CLP_TERMINATE==null){var terminate='';}else{terminate=value_array[i].CLP_TERMINATE;}
                if(value_array[i].CED_NOTICE_PERIOD==null){var noticeperiod='';}else{noticeperiod=value_array[i].CED_NOTICE_PERIOD;}
                if(value_array[i].CED_NOTICE_START_DATE==null){var noticedate='';}else{noticedate=value_array[i].CED_NOTICE_START_DATE;}
                if(value_array[i].CC_DEPOSIT==null){var deposit='';}else{deposit=value_array[i].CC_DEPOSIT;}
                if(value_array[i].CC_PROCESSING_FEE==null){var processfee='';}else{processfee=value_array[i].CC_PROCESSING_FEE;}
                if(value_array[i].CED_PRORATED==null){var prorated='';}else{prorated=value_array[i].CED_PRORATED;}
                if(value_array[i].CED_PROCESSING_WAIVED==null){var waived='';}else{waived=value_array[i].CED_PROCESSING_WAIVED;}
                if(value_array[i].CC_AIRCON_QUARTERLY_FEE==null){var quarterlyfee='';}else{quarterlyfee=value_array[i].CC_AIRCON_QUARTERLY_FEE;}
                if(value_array[i].CC_AIRCON_FIXED_FEE==null){var fixedaircon='';}else{fixedaircon=value_array[i].CC_AIRCON_FIXED_FEE;}
                if(value_array[i].CC_AIRCON_QUARTERLY_FEE==null){var quarterlyfee='';}else{quarterlyfee=value_array[i].CC_AIRCON_QUARTERLY_FEE;}
                if(value_array[i].CC_ELECTRICITY_CAP==null){var electricitycap='';}else{electricitycap=value_array[i].CC_ELECTRICITY_CAP;}
                if(value_array[i].CC_DRYCLEAN_FEE==null){var curtaindryclean='';}else{curtaindryclean=value_array[i].CC_DRYCLEAN_FEE;}
                if(value_array[i].CC_CHECKOUT_CLEANING_FEE==null){var checkoutclean='';}else{checkoutclean=value_array[i].CC_CHECKOUT_CLEANING_FEE;}
                var edit="Editid/"+value_array[i].CUSTOMER_ID+"/"+value_array[i].CED_REC_VER+"/"+value_array[i].UNIT_NO;
                var del=value_array[i].CUSTOMER_ID;
                if(guestcard!='X')
                {
                    CustpmerAccount_Tabledata+='<tr style="text-align: center !important;">';
                    if(accesscard=='' && terminate!='X' && value_array[i].CED_REC_VER==1 )
                    {
                        CustpmerAccount_Tabledata+="<td><div class='col-lg-1'><span style='display: block;color:green' class='glyphicon glyphicon-edit CC_SRC_editbutton' id="+edit+"></div><div class='col-lg-1'><span style='display: block;color:red' class='glyphicon glyphicon-trash CC_SRC_removebutton' id="+del+"></div></td>";
                    }
                    else
                    {
                        CustpmerAccount_Tabledata+="<td><div class='col-lg-1'><span style='display: block;color:green' class='glyphicon glyphicon-edit CC_SRC_editbutton' id="+edit+"></div></td>";
                    }

                    CustpmerAccount_Tabledata+="<td style='width:70px !important;'>"+value_array[i].CUSTOMER_ID+"</td>" +
                        "<td style='width:70px !important;'>"+value_array[i].UNIT_NO+"</td>" +
                        "<td style='width:80px !important;'>"+value_array[i].CLP_STARTDATE+"</td>" +
                        "<td style='width:80px !important;'>"+value_array[i].CLP_ENDDATE+"</td>" +
                        "<td style='width:80px !important;'>"+preterminatedate+"</td>" +
                        "<td style='width:80px !important;'>"+canceldate+"</td>" +
                        "<td style='width:80px !important;'>"+value_array[i].CED_REC_VER+"</td>" +
                        "<td style='width:100px !important;'>"+value_array[i].CC_ROOM_TYPE+"</td>" +
                        "<td style='width:80px !important;'>"+accesscard+"</td>" +
                        "<td style='width:70px !important;'>"+guestcard+"</td>" +
                        "<td style='width:80px !important;'>"+preterminate+"</td>" +
                        "<td style='width:80px !important;'>"+extension+"</td>" +
                        "<td style='width:80px !important;'>"+recheckin+"</td>" +
                        "<td style='width:80px !important;'>"+terminate+"</td>" +
                        "<td style='width:120px !important;'>"+value_array[i].CED_LEASE_PERIOD+"</td>" +
                        "<td style='width:100px !important;'>"+value_array[i].CED_QUARTERS+"</td>" +
                        "<td style='width:70px !important;'>"+noticeperiod+"</td>" +
                        "<td style='width:90px !important;'>"+noticedate+"</td>" +
                        "<td style='width:90px !important;'>"+deposit+"</td>" +
                        "<td style='width:90px !important;'>"+value_array[i].CC_PAYMENT_AMOUNT+"</td>" +
                        "<td style='width:70px !important;'>"+prorated+"</td>" +
                        "<td style='width:90px !important;'>"+processfee+"</td>" +
                        "<td style='width:70px !important;'>"+waived+"</td>" +
                        "<td style='width:90px !important;'>"+quarterlyfee+"</td>" +
                        "<td style='width:90px !important;'>"+fixedaircon+"</td>" +
                        "<td style='width:90px !important;'>"+electricitycap+"</td>" +
                        "<td style='width:90px !important;'>"+curtaindryclean+"</td>" +
                        "<td style='width:90px !important;'>"+checkoutclean+"</td>" +
                        "<td style='width:200px !important;'>"+value_array[i].ULD_LOGINID+"</td>" +
                        "<td style='width:100px !important;'>"+value_array[i].CLP_TIMESTAMP+"</td></tr>";
                }
                else
                {
                    CustpmerAccount_Tabledata+='<tr style="text-align: center !important;">' +
                        "<td></td>" +
                        "<td style='width:70px !important;'>"+value_array[i].CUSTOMER_ID+"</td>" +
                        "<td style='width:70px !important;'>"+value_array[i].UNIT_NO+"</td>" +
                        "<td style='width:80px !important;'>"+value_array[i].CLP_STARTDATE+"</td>" +
                        "<td style='width:80px !important;'>"+value_array[i].CLP_ENDDATE+"</td>" +
                        "<td style='width:80px !important;'>"+preterminatedate+"</td>" +
                        "<td style='width:80px !important;'>"+canceldate+"</td>" +
                        "<td style='width:80px !important;'>"+value_array[i].CED_REC_VER+"</td>" +
                        "<td style='width:100px !important;'>"+value_array[i].CC_ROOM_TYPE+"</td>" +
                        "<td style='width:80px !important;'>"+accesscard+"</td>" +
                        "<td style='width:70px !important;'>"+guestcard+"</td>" +
                        "<td style='width:80px !important;'>"+preterminate+"</td>" +
                        "<td style='width:80px !important;'>"+extension+"</td>" +
                        "<td style='width:80px !important;'>"+recheckin+"</td>" +
                        "<td style='width:80px !important;'>"+terminate+"</td>" +
                        "<td style='width:120px !important;'>"+value_array[i].CED_LEASE_PERIOD+"</td>" +
                        "<td style='width:100px !important;'>"+value_array[i].CED_QUARTERS+"</td>" +
                        "<td style='width:70px !important;'>"+noticeperiod+"</td>" +
                        "<td style='width:90px !important;'>"+noticedate+"</td>" +
                        "<td style='width:90px !important;'>"+deposit+"</td>" +
                        "<td style='width:90px !important;'>"+value_array[i].CC_PAYMENT_AMOUNT+"</td>" +
                        "<td style='width:70px !important;'>"+prorated+"</td>" +
                        "<td style='width:90px !important;'>"+processfee+"</td>" +
                        "<td style='width:70px !important;'>"+waived+"</td>" +
                        "<td style='width:90px !important;'>"+quarterlyfee+"</td>" +
                        "<td style='width:90px !important;'>"+fixedaircon+"</td>" +
                        "<td style='width:90px !important;'>"+electricitycap+"</td>" +
                        "<td style='width:90px !important;'>"+curtaindryclean+"</td>" +
                        "<td style='width:90px !important;'>"+checkoutclean+"</td>" +
                        "<td style='width:200px !important;'>"+value_array[i].ULD_LOGINID+"</td>" +
                        "<td style='width:100px !important;'>"+value_array[i].CLP_TIMESTAMP+"</td></tr>";
                }
            }
            CustpmerAccount_Tabledata+="</body>";
            $('#AccessCard_table').html(CustpmerAccount_Tabledata);
            $('#Customer_Account_Datatable').DataTable( {
                "sDom":"Rlfrtip",
                "deferRender":    true,
                "scrollY": 200,
                "scrollX": 500,
                "scrollCollapse": true,
                "aaSorting": [],
                "pageLength": 10,
                "sPaginationType":"full_numbers",
                "aoColumnDefs": [{"aTargets": ["uk-date-column"],"sType": "uk_date"}, {"aTargets": ["uk-timestp-column"], "sType": "uk_timestp"}]
            });
            sorting();
            $('#CC_SEARCH_DataTable').show();
            $('#CC_SEARCH_acDataTable').show();
            $('.preloader').hide();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        }
        function DTFormTable_DateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        //FUNCTION FOR SORTING
        function sorting(){
            jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
                var x = new Date( Date.parse(DTFormTable_DateFormat(a)));
                var y = new Date( Date.parse(DTFormTable_DateFormat(b)) );
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
                var x = new Date( Date.parse(DTFormTable_DateFormat(a)));
                var y = new Date( Date.parse(DTFormTable_DateFormat(b)) );
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_timestp-asc']  = function(a,b) {
                var x = new Date( Date.parse(DTFormTable_DateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(DTFormTable_DateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_timestp-desc'] = function(a,b) {
                var x = new Date( Date.parse(DTFormTable_DateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(DTFormTable_DateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
        }
        $(document).on('click','.paginate_button',function(){
            $('#Customer_Account_Datatable tr').removeClass('row_selected');
            $('#CSRC_updation_form').hide();
        });
        $(document).on('click','#Customer_Account_Datatable tr td .CC_SRC_editbutton',function(){
            $('#Customer_Account_Datatable tr').removeClass('row_selected');
            $(this).closest('tr').addClass('row_selected');
        });
        $(document).on('change blur','.customernamechange',function(){
            $('#customernamelabel').text($('#CCRE_SRC_FirstName').val()+' '+$('#CCRE_SRC_LastName').val());
        });
        var card=[];
        $(document).on('click','.CC_SRC_editbutton',function() {
            $('#CSRC_div_fileupload').html('').html('<input type="file" id="CSRC_fileupload" name="CSRC_fileupload" class="form-control CSRC_fileextensionchk" />');
            var selectedrowDetails=this.id;
            var splitteddata=selectedrowDetails.split('/');
            var customerid=splitteddata[1];
            var leaseperiod=splitteddata[2];
            var unitno=splitteddata[3];
            var Recverdetails;
            $("#CSRC_btn_Updatebutton").attr("disabled", "disabled");
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url+"SelectCustomerResults",
                data:{customerid:customerid,LP:leaseperiod,Unit:unitno},
                success: function(data){
                    var value_array=JSON.parse(data);
                    Recverdetails=value_array[2];
                    var fileurls=value_array[6];

                    var Unit_StartDate=value_array[3][0].UD_START_DATE;
                    var Unit_EndDate=value_array[3][0].UD_END_DATE;
                    var PreRecver_ED=Recverdetails[0].PRE_RECVER_ENDDATE;
                    var NextRecver_SD=Recverdetails[0].NEXT_RECVER_STARTDATE;
                    var MaxRecver=Recverdetails[0].MAX_RECVER;
                    var SDFlag=Recverdetails[0].STARTFLAG;
                    var EDFlag=Recverdetails[0].ENDFLAG;
                    var allactiveunits=value_array[4];
                    var monthdiff=value_array[5];
                    monthdiff=(monthdiff[0].CCN_DATA);
                    var Accesscard_details=[];
                    for(var i=0;i<value_array[0].length;i++)
                    {
                        var CardDetails={Card:value_array[0][i].UASD_ACCESS_CARD,SD:value_array[0][i].STARTDATE,ED:value_array[0][i].ENDDATE}
                        Accesscard_details.push(CardDetails);
                        if(value_array[0][i].UASD_ACCESS_CARD!='' && value_array[0][i].UASD_ACCESS_CARD!=null)
                        {
                            card.push(value_array[0][i].UASD_ACCESS_CARD)
                        }
                    }
                    $("#CCRE_SRC_Quarterly_fee").hide().val('');
                    $("#CCRE_SRC_Fixedaircon_fee").hide().val('');
                    $('#CCRE_Quaterlyfee').prop('checked',false);
                    $('#CCRE_Airconfee').prop('checked',false);
                    var filename=value_array[0][0].UNIT_NO+'-'+value_array[0][0].CUSTOMER_ID+'-'+value_array[0][0].CUSTOMER_FIRST_NAME+'-'+value_array[0][0].CUSTOMER_LAST_NAME;
                    $('#CCRE_SRC_customerid').val(value_array[0][0].CUSTOMER_ID);
                    $('#CCRE_SRC_Recver').val(value_array[0][0].CED_REC_VER);
                    $('#CCRE_SRC_FirstName').val(value_array[0][0].CUSTOMER_FIRST_NAME);
                    $('#CCRE_SRC_LastName').val(value_array[0][0].CUSTOMER_LAST_NAME);
                    $('#CCRE_SRC_CompanyName').val(value_array[0][0].CCD_COMPANY_NAME);
                    $('#CCRE_SRC_CompanyAddress').val(value_array[0][0].CCD_COMPANY_ADDR);
                    $('#CCRE_SRC_CompanyPostalCode').val(value_array[0][0].CCD_POSTAL_CODE);
                    $('#CCRE_SRC_Emailid').val(value_array[0][0].CPD_EMAIL);
                    $('#CCRE_SRC_Mobile').val(value_array[0][0].CPD_MOBILE);
                    $('#CCRE_SRC_IntlMobile').val(value_array[0][0].CPD_INTL_MOBILE);
                    $('#CCRE_SRC_Officeno').val(value_array[0][0].CCD_OFFICE_NO);
                    $('#CCRE_SRC_DOB').val(value_array[0][0].CPD_DOB);
                    $('#CCRE_SRC_PassportNo').val(value_array[0][0].CPD_PASSPORT_NO);
                    $('#CCRE_SRC_PassportDate').val(value_array[0][0].CPD_PASSPORT_DATE);
                    $('#CCRE_SRC_EpNo').val(value_array[0][0].CPD_EP_NO);
                    $('#CCRE_SRC_EPDate').val(value_array[0][0].CPD_EP_DATE);
                    $('#CCRE_SRC_NoticePeriod').val(value_array[0][0].CED_NOTICE_PERIOD);
                    $('#CCRE_SRC_NoticePeriodDate').val(value_array[0][0].CED_NOTICE_START_DATE);
                    if(value_array[0][0].CC_AIRCON_QUARTERLY_FEE!='' && value_array[0][0].CC_AIRCON_QUARTERLY_FEE!=null)
                    {
                        $('#CCRE_SRC_Quarterly_fee').val(value_array[0][0].CC_AIRCON_QUARTERLY_FEE).show();
                        $('#CCRE_Quaterlyfee').prop('checked',true);
                    }
                    if(value_array[0][0].CC_AIRCON_FIXED_FEE!='' && value_array[0][0].CC_AIRCON_FIXED_FEE!=null)
                    {
                        $('#CCRE_SRC_Fixedaircon_fee').val(value_array[0][0].CC_AIRCON_FIXED_FEE).show();
                        $('#CCRE_Airconfee').prop('checked',true);
                    }
                    $('#CCRE_SRC_ElectricitycapFee').val(value_array[0][0].CC_ELECTRICITY_CAP);
                    $('#CCRE_SRC_Curtain_DrycleanFee').val(value_array[0][0].CC_DRYCLEAN_FEE);
                    $('#CCRE_SRC_CheckOutCleanFee').val(value_array[0][0].CC_CHECKOUT_CLEANING_FEE);
                    $('#CCRE_SRC_DepositFee').val(value_array[0][0].CC_DEPOSIT);
                    $('#CCRE_SRC_Rent').val(value_array[0][0].CC_PAYMENT_AMOUNT);
                    $('#CCRE_SRC_ProcessingFee').val(value_array[0][0].CC_PROCESSING_FEE);
                    $('#CCRE_SRC_Comments').val(value_array[0][0].CPD_COMMENTS);
                    $('#CCRE_lbl_prorated').text(prorated[0].CCN_DATA);
                    $('#CCRE_lbl_waived').text(prorated[1].CCN_DATA);

                    if(value_array[0][0].CED_PROCESSING_WAIVED=='X')
                    {
                        $('input:checkbox[name=CCRE_process_waived]').attr("checked",true);
                    }
                    else
                    {
                        $('input:checkbox[name=CCRE_process_waived]').attr("checked",false);
                    }
                    if(value_array[0][0].CED_PRORATED=='X')
                    {
                        $('input:checkbox[name=CCRE_Rent_Prorated]').attr("checked",true);
                    }
                    else
                    {
                        $('input:checkbox[name=CCRE_Rent_Prorated]').attr("checked",false);
                    }
                    var terminate=value_array[0][0].CLP_TERMINATE;
                    //NATIONALITY//
                    var options='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < nationality.length; i++)
                    {
                        var data=nationality[i];
                        options += '<option value="' + data.NC_DATA + '">' + data.NC_DATA + '</option>';
                    }
                    $('#CCRE_SRC_Nationality').html(options);
                    $('#CCRE_SRC_Nationality').val(value_array[0][0].NC_DATA);

                    //ROOMTYPE//
                    var Roomtypes='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < value_array[1].length; i++)
                    {
                        var data=value_array[1][i];
                        Roomtypes += '<option value="' + data.URTD_ROOM_TYPE + '">' + data.URTD_ROOM_TYPE + '</option>';
                    }
                    $('#CCRE_SRC_RoomType').html(Roomtypes);
                    $('#CCRE_SRC_RoomType').val(value_array[0][0].CC_ROOM_TYPE);
                    //TIMEOPTION//
                    var timeoptions='<OPTION>Select</OPTION>';
                    for (var i = 0; i < timelist.length; i++)
                    {
                        var data=timelist[i];
                        timeoptions += '<option value="' + data.TIME + '">' + data.TIME + '</option>';
                    }
                    //MAILSEND OPTION//
                    var mailoptions='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < emaillist.length; i++)
                    {
                        var data=emaillist[i];
                        mailoptions += '<option value="' + data.EL_EMAIL_ID + '">' + data.EL_EMAIL_ID + '</option>';
                    }
                    //CC OPTION//
                    $('#CCRE_SRC_MailList').html(mailoptions);
                    var ccoptions='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < ccoption.length; i++)
                    {
                        var data=ccoption[i];
                        ccoptions += '<option value="' + data.CCN_ID + '">' + data.CCN_DATA + '</option>';
                    }
                    $('#CCRE_SRC_Option').html(ccoptions);
                    //UNIT//
                    var unitoptions='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < allunits.length; i++)
                    {
                        var data=allunits[i];
                        unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                    }
                    $('#CCRE_SRC_UnitNo').html(unitoptions);
                    $('#CCRE_SRC_UnitNo').val(value_array[0][0].UNIT_NO);
                    $('#CCRE_SRC_SDStarttime').html(timeoptions);
                    $('#CCRE_SRC_SDEndtime').html(timeoptions);
                    $('#CCRE_SRC_EDStarttime').html(timeoptions);
                    $('#CCRE_SRC_EDEndtime').html(timeoptions);
                    $("#CCRE_SRC_Startdate").datepicker(
                        {
                            dateFormat: 'dd-mm-yy',
                            changeYear: true,
                            changeMonth: true
                        });
                    $("#CCRE_SRC_Enddate").datepicker(
                        {
                            dateFormat: 'dd-mm-yy',
                            changeYear: true,
                            changeMonth: true
                        });
                    $("#CCRE_SRC_NoticePeriodDate").datepicker(
                        {
                            dateFormat: 'dd-mm-yy',
                            changeYear: true,
                            changeMonth: true
                        });
                    var Noticestartdate=Form_dateConversion(value_array[0][0].STARTDATE);
                    var Noticeenddate=Form_NoticedateConversion(value_array[0][0].ENDDATE);
                    $('#CCRE_SRC_NoticePeriodDate').datepicker("option","maxDate",Noticeenddate);
                    if(Noticestartdate>new Date())
                    {
                        $('#CCRE_SRC_NoticePeriodDate').datepicker("option","minDate",Noticestartdate);
                    }
                    else
                    {
                        var newDate=NewDate_dateConversion();
                        $('#CCRE_SRC_NoticePeriodDate').datepicker("option","minDate",newDate);
                    }
                    var epandppdatemindate=DB_dateConversion(value_array[7][0].ENDDATE)
//                    var epandppdatemindate=Form_dateConversion("2011-06-18");

                    if(pass_changedmonth>epandppdatemindate)
                    $('#CCRE_SRC_PassportDate').datepicker("option","minDate",epandppdatemindate);
                    if(ep_changedmonth>epandppdatemindate)
                    $('#CCRE_SRC_EPDate').datepicker("option","minDate",epandppdatemindate);
                    var CSRC_recheckin=value_array[0][0].CED_RECHECKIN;
                    if(MaxRecver==1 && leaseperiod==1 && terminate==null && CSRC_recheckin!='X')
                    {
                        $('#CCRE_SRC_Startdate').val(value_array[0][0].STARTDATE).prop('disabled', false);
                        $('#CCRE_SRC_SDStarttime').val(timeformatchange(value_array[0][0].CED_SD_STIME)).prop('disabled', false);
                        $('#CCRE_SRC_SDEndtime').val(timeformatchange(value_array[0][0].CED_SD_ETIME)).prop('disabled', false);

                        $('#CCRE_SRC_Enddate').val(value_array[0][0].ENDDATE).prop('disabled', false);
                        $('#CCRE_SRC_EDStarttime').val(timeformatchange(value_array[0][0].CED_ED_STIME)).prop('disabled', false);
                        $('#CCRE_SRC_EDEndtime').val(timeformatchange(value_array[0][0].CED_ED_ETIME)).prop('disabled', false);
                        var MinDate=DB_dateConversion(Unit_StartDate);
                        $('#CCRE_SRC_Startdate').datepicker("option","minDate",MinDate);
                        var MaxDate=DB_dateConversion(Unit_EndDate);
                        $('#CCRE_SRC_Startdate').datepicker("option","maxDate",MaxDate);
                        var Endmaxdate=Form_dateConversion(value_array[0][0].STARTDATE);
                        $('#CCRE_SRC_Enddate').datepicker("option","maxDate",MaxDate);
                        $('#CCRE_SRC_Enddate').datepicker("option","minDate",Endmaxdate);
                        $('#CCRE_SRC_NoticePeriodDate').prop('disabled', false);

                    }
                    else if(MaxRecver==leaseperiod && MaxRecver!=1 && terminate==null && CSRC_recheckin!='X')
                    {
                        $('#CCRE_SRC_Startdate').val(value_array[0][0].STARTDATE).prop('disabled', true);
                        $('#CCRE_SRC_SDStarttime').val(timeformatchange(value_array[0][0].CED_SD_STIME)).prop('disabled', true);
                        $('#CCRE_SRC_SDEndtime').val(timeformatchange(value_array[0][0].CED_SD_ETIME)).prop('disabled', true);

                        $('#CCRE_SRC_Enddate').val(value_array[0][0].ENDDATE).prop('disabled', false);
                        $('#CCRE_SRC_EDStarttime').val(timeformatchange(value_array[0][0].CED_ED_STIME)).prop('disabled', false);
                        $('#CCRE_SRC_EDEndtime').val(timeformatchange(value_array[0][0].CED_ED_ETIME)).prop('disabled', false);
                        var MaxDate=DB_dateConversion(Unit_EndDate);
                        var Endmaxdate=Form_dateConversion(value_array[0][0].STARTDATE);
                        $('#CCRE_SRC_Enddate').datepicker("option","maxDate",MaxDate);
                        $('#CCRE_SRC_Enddate').datepicker("option","minDate",Endmaxdate);
                        $('#CCRE_SRC_NoticePeriodDate').prop('disabled', false);
                    }
                    else if(MaxRecver==leaseperiod && terminate=='X' && CSRC_recheckin!='X')
                    {
                        $('#CCRE_SRC_Startdate').val(value_array[0][0].STARTDATE).prop('disabled', true);
                        $('#CCRE_SRC_SDStarttime').val(timeformatchange(value_array[0][0].CED_SD_STIME)).prop('disabled', true);
                        $('#CCRE_SRC_SDEndtime').val(timeformatchange(value_array[0][0].CED_SD_ETIME)).prop('disabled', true);

                        $('#CCRE_SRC_Enddate').val(value_array[0][0].ENDDATE).prop('disabled', true);
                        $('#CCRE_SRC_EDStarttime').val(timeformatchange(value_array[0][0].CED_ED_STIME)).prop('disabled', true);
                        $('#CCRE_SRC_EDEndtime').val(timeformatchange(value_array[0][0].CED_ED_ETIME)).prop('disabled', true);
                        $('#CCRE_SRC_NoticePeriodDate').prop('disabled', true);
                    }
                    else if(MaxRecver==leaseperiod && terminate!='X' && CSRC_recheckin=='X')
                    {
                        $('#CCRE_SRC_Startdate').val(value_array[0][0].STARTDATE).prop('disabled', false);
                        $('#CCRE_SRC_SDStarttime').val(timeformatchange(value_array[0][0].CED_SD_STIME)).prop('disabled', false);
                        $('#CCRE_SRC_SDEndtime').val(timeformatchange(value_array[0][0].CED_SD_ETIME)).prop('disabled', false);

                        $('#CCRE_SRC_Enddate').val(value_array[0][0].ENDDATE).prop('disabled', false);
                        $('#CCRE_SRC_EDStarttime').val(timeformatchange(value_array[0][0].CED_ED_STIME)).prop('disabled', false);
                        $('#CCRE_SRC_EDEndtime').val(timeformatchange(value_array[0][0].CED_ED_ETIME)).prop('disabled', false);
                        var MinDate=DB_dateConversion(Unit_StartDate);
                        var previoussd=DB_dateConversion(PreRecver_ED);
                        var month_DiffDate=DB_beforedateCalculation(monthdiff);
                        var datearray=[MinDate,month_DiffDate,previoussd]
                        var chkminDate=new Date(Math.max.apply(null,datearray));
                        $('#CCRE_SRC_Startdate').datepicker("option","minDate",chkminDate);
                        var MaxDate=DB_dateConversion(Unit_EndDate);
                        $('#CCRE_SRC_Startdate').datepicker("option","maxDate",MaxDate);
                        var Endmaxdate=Form_dateConversion(value_array[0][0].STARTDATE);
                        $('#CCRE_SRC_Enddate').datepicker("option","maxDate",MaxDate);
                        $('#CCRE_SRC_Enddate').datepicker("option","minDate",Endmaxdate);
                        $('#CCRE_SRC_NoticePeriodDate').prop('disabled', false);
                    }
                    else
                    {
                        $('#CCRE_SRC_Startdate').val(value_array[0][0].STARTDATE).prop('disabled', true);
                        $('#CCRE_SRC_SDStarttime').val(timeformatchange(value_array[0][0].CED_SD_STIME)).prop('disabled', true);
                        $('#CCRE_SRC_SDEndtime').val(timeformatchange(value_array[0][0].CED_SD_ETIME)).prop('disabled', true);

                        $('#CCRE_SRC_Enddate').val(value_array[0][0].ENDDATE).prop('disabled', true);
                        $('#CCRE_SRC_EDStarttime').val(timeformatchange(value_array[0][0].CED_ED_STIME)).prop('disabled', true);
                        $('#CCRE_SRC_EDEndtime').val(timeformatchange(value_array[0][0].CED_ED_ETIME)).prop('disabled', true);
                        $('#CCRE_SRC_NoticePeriodDate').prop('disabled', true);
                    }
                    if(Accesscard_details[0].Card!=null && Accesscard_details[0].Card!='')
                    {
                        $('#CCRE_SRC_UnitNo').prop('disabled', true);
                        var appenddata='';

                        for (var i=0;i<Accesscard_details.length;i++)
                        {
                            appenddata+='<div class="row form-group">';
                            appenddata+='<div class="col-md-3">';
                            appenddata+='</div>';
                            appenddata+='<div class="col-md-2" style="padding-left: 50px;">';
                            appenddata+='<label>'+Accesscard_details[i].Card+'</label>';
                            appenddata+='</div>';
                            appenddata+='<div class="col-md-2">';
                            if(i==0)
                            {
                                appenddata+='<label id="customernamelabel">'+value_array[0][0].CUSTOMER_FIRST_NAME+' '+value_array[0][0].CUSTOMER_LAST_NAME+'</label>';
                            }
                            else
                            {
                                appenddata+='<label>GUEST</label>';
                            }
                            var Sdid='CSRC_StartDate-'+i;
                            var Edid='CSRC_EndDate-'+i;
                            appenddata+='</div>';
                            appenddata+='<div class="col-md-2">';
                            appenddata+='<input type="text" class="form-control" id='+Sdid+' name="CSRC_StartDate[]" style="max-width: 100px" value='+Accesscard_details[i].SD+' readonly>';
                            appenddata+='</div>';
                            appenddata+='<div class="col-md-2">';
                            appenddata+='<input type="text" class="form-control" id='+Edid+' name="CSRC_EndDate[]" style="max-width: 100px" value='+Accesscard_details[i].ED+' readonly>';
                            appenddata+='</div>';
                            appenddata+='<div class="col-md-2">';
                            appenddata+='<input type="hidden" class="form-control" name="CSRC_card[]" style="max-width: 100px" value='+Accesscard_details[i].Card+' readonly>';
                            appenddata+='</div>';
                            appenddata+='</div>';
                        }
                        $('#AccessCardDiv').html(appenddata).show();
                        $('#AccessCardDiv').show();
                    }
                    else
                    {
                        var appenddata='';
                        $('#AccessCardDiv').html(appenddata).show();
                        if(MaxRecver==1 && terminate!='X')
                        {
                            //UNIT//
                            var unitoptions='<OPTION>SELECT</OPTION>';
                            for (var i = 0; i < allactiveunits.length; i++)
                            {
                                var data=allactiveunits[i];
                                unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                            }
                            $('#CCRE_SRC_UnitNo').html(unitoptions);
                            $('#CCRE_SRC_UnitNo').val(value_array[0][0].UNIT_NO);
                            $('#CCRE_SRC_UnitNo').prop('disabled', false);
                        }
                        else
                        {
                            $('#CCRE_SRC_UnitNo').prop('disabled', true);
                        }
                    }
                    $('#startdatediv').show();
                    $('#CusromerEnddate').show();
                    $('#RoomtypeDiv').show();
                    $('#startdatetotime').show();
                    $('#endatedateto').show();
                    var appenddata='';
                    if(fileurls.length!=0)
                    {
                        for (var k = 0; k < fileurls.length; k++)
                        {
                            var data = fileurls[k].split('######');
                            var rowid=k+1;
                            var buttonid=data[1]+'/'+rowid;
                            var file_name=rowid+' . '+data[2];
                            appenddata += '<div id='+rowid+'>';
                            appenddata += '<div class="row form-group">';
                            appenddata += '<div class="col-md-3">';
                            appenddata += '<label></label>';
                            appenddata += '</div>';
                            appenddata += '<div class="col-md-3">';
                            appenddata += '<a href=' + data[0] + ' target="_blank" class="uploadtag">' + file_name + '</a>';
                            appenddata += '</div>';
                            appenddata += '<div class="col-md-2">';
                            appenddata += '<input type="button" class="btn filedelete" id=' + buttonid + '  value="REMOVE">';
                            appenddata += '</div>';
                            appenddata += '</div></div>';
                        }
                    }
                    $('#uploadedfilesview').html(appenddata);
                    $('#CSRC_updation_form').show();
                    $('.preloader').hide();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('click','.filedelete',function(){
            var fileid=this.id;
            var splitfileid=fileid.split('/');
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url+"customerfiledelete",
                data: {fileid: splitfileid[0]},
                success: function (data) {
                    if(data==1)
                    {
                        $('#'+ splitfileid[1]).hide();
                        show_msgbox("CUSTOMER SEARCH/UPDATE","FILE REMOVED FROM DRIVE","success",false);
                    }
                    else
                    {
                        show_msgbox("CUSTOMER SEARCH/UPDATE","FILE NOT REMOVED","success",false);
                    }
                    $('.preloader').hide();
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });

        });
        //START DATE CHANGES
        $(document).on('change','.startdatevalidate',function(){
            var SD=$('#CCRE_SRC_Startdate').val();
            var mindate=Form_dateConversion(SD);
            if(mindate>new Date())
            {
                $('#CCRE_SRC_Enddate').datepicker("option","minDate",mindate);
            }
            else
            {
                var minidate=NewDate_dateConversion()
                $('#CCRE_SRC_Enddate').datepicker("option","minDate",minidate);
            }
            if(mindate>new Date())
            {
                $('#CCRE_SRC_NoticePeriodDate').datepicker("option","minDate",mindate);
            }
            else
            {
                var newDate=NewDate_dateConversion();
                $('#CCRE_SRC_NoticePeriodDate').datepicker("option","minDate",newDate);
            }
            if(card.length!=0)
            {
                for(var k=0;k<card.length;k++)
                {
                    $('#CSRC_StartDate-'+k).val(SD);
                }
            }
        });
        $(document).on('change','.Enddatevalidate',function(){
            var ED=$('#CCRE_SRC_Enddate').val();
            var mindate=Form_NoticedateConversion(ED);
            $('#CCRE_SRC_NoticePeriodDate').datepicker("option","maxDate",mindate);
            if(card.length!=0)
            {
                for(var k=0;k<card.length;k++)
                {
                    $('#CSRC_EndDate-'+k).val(ED);
                }
            }
            var epandppdatemindate=Form_dateConversion(ED)
            $('#CCRE_SRC_PassportDate').datepicker("option","minDate",epandppdatemindate);
            $('#CCRE_SRC_EPDate').datepicker("option","minDate",epandppdatemindate);
        });
        function NewDate_dateConversion()
        {
            var CCRE_date1 = new Date();
            var CCRE_day=CCRE_date1.getDate();
            CCRE_date1.setDate( CCRE_day + 1 );
            var newDate = CCRE_date1.toDateString();
            newDate = new Date( Date.parse( newDate ));
            return newDate;
        }
        function DB_beforedateCalculation(startdateperiod)
        {
            var inputdate=new Date();
            var newunitstartdate=new Date(inputdate.getFullYear(),inputdate.getMonth()-parseInt(startdateperiod),inputdate.getDate());
            return newunitstartdate;
        }
        function DB_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[0],inputdate[1]-1,inputdate[2]);
            return newunitstartdate;
        }
        function Form_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[2],inputdate[1]-1,parseInt(inputdate[0])+parseInt(1));
            return newunitstartdate;
        }
        function Form_NoticedateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[2],inputdate[1]-1,parseInt(inputdate[0])-parseInt(1));
            return newunitstartdate;
        }
        function timeformatchange(time)
        {
            var splittime=time.split(':');
            var timeformat=splittime[0]+':'+splittime[1];
            return timeformat;
        }
        $(function ()
        {
            $("#radio").buttonset();
            $("input[name='Aircon']").on("change", function () {
                var CCRE_radio_name = $("input[name='Aircon']:checked").val();
                if(CCRE_radio_name=='QuarterlyFee')
                {
                    $("#CCRE_SRC_Quarterly_fee").show().val('');
                    $("#CCRE_SRC_Fixedaircon_fee").hide().val('');
                }
                if(CCRE_radio_name=='FixedAircon')
                {
                    $("#CCRE_SRC_Quarterly_fee").hide().val('');
                    $("#CCRE_SRC_Fixedaircon_fee").show().val('');
                }
            });
        });
        $(document).on('change','#CCRE_SRC_ProcessingFee',function(){
            if($('#CCRE_SRC_ProcessingFee').val()=="")
            {
                $('input:checkbox[name=CCRE_process_waived]').attr("checked",false);
                $('input:checkbox[name=CCRE_process_waived]').attr("disabled",'disabled');
            }
            else
            {
                $('input:checkbox[name=CCRE_process_waived]').removeAttr("disabled");
            }
        });
        ///*********************SET DOB DATEPICKER**************************************/
        var CCRE_d = new Date();
        var CCRE_year = CCRE_d.getFullYear() - 18;
        CCRE_d.setFullYear(CCRE_year);
        $('#CCRE_SRC_DOB').datepicker({dateFormat: 'dd-mm-yy',
            changeYear: true,
            changeMonth: true,
            yearRange: '1920:' + CCRE_year + '',
            defaultDate: CCRE_d
        });
        $('#CCRE_SRC_DOB').blur(function()
        {
        });
        $(document).on('change blur','#CCRE_Form_CustomerSearch',function(){
            /******POSATAL CODE************/
            var postalcode=$('#CCRE_SRC_CompanyPostalCode').val();
            if(postalcode!=""){if(postalcode.length>=5){var postalflag=1;$('#CSRC_lbl_postalerrormsg').hide();$('#CCRE_SRC_CompanyPostalCode').removeClass('invalid');}else{postalflag=0;$('#CSRC_lbl_postalerrormsg').show();$('#CCRE_SRC_CompanyPostalCode').addClass('invalid');}}else{$('#CSRC_lbl_postalerrormsg').hide();postalflag=1;$('#CCRE_SRC_CompanyPostalCode').removeClass('invalid');}
            /******MOBILE NO************/
            var mobileno=$('#CCRE_SRC_Mobile').val();
            if(mobileno!=""){if(mobileno.length>=6){var mobileflag=1;$('#CSRC_lbl_mobileerrormsg').hide();$('#CCRE_SRC_Mobile').removeClass('invalid');}else{mobileflag=0;$('#CSRC_lbl_mobileerrormsg').show();$('#CCRE_SRC_Mobile').addClass('invalid');}}else{$('#CSRC_lbl_mobileerrormsg').hide();mobileflag=1;$('#CCRE_SRC_Mobile').removeClass('invalid');}
            /******INTL MOBILE NO************/
            var intlmobileno=$('#CCRE_SRC_IntlMobile').val();
            if(intlmobileno!=""){if(intlmobileno.length>=6){var intlmobileflag=1;$('#CSRC_lbl_intlmobileerrormsg').hide();$('#CCRE_SRC_IntlMobile').removeClass('invalid');}else{intlmobileflag=0;$('#CSRC_lbl_intlmobileerrormsg').show();$('#CCRE_SRC_IntlMobile').addClass('invalid');}}else{$('#CSRC_lbl_intlmobileerrormsg').hide();intlmobileflag=1;$('#CCRE_SRC_IntlMobile').removeClass('invalid');};
            /******OFFICE NO************/
            var officeno=$('#CCRE_SRC_Officeno').val();
            if(officeno!=""){if(officeno.length>=6){var officenoflag=1;$('#CSRC_lbl_officeerrormsg').hide();$('#CCRE_SRC_Officeno').removeClass('invalid');}else{officenoflag=0;$('#CSRC_lbl_officeerrormsg').show();$('#CCRE_SRC_Officeno').addClass('invalid');}}else{$('#CSRC_lbl_officeerrormsg').hide();officenoflag=1;$('#CCRE_SRC_Officeno').removeClass('invalid');}
            /******PASSPORT NO************/
            var passportno=$('#CCRE_SRC_PassportNo').val();
            if(passportno!=""){if(passportno.length>=6){var passportnoflag=1;$('#CSRC_lbl_passporterrormsg').hide();$('#CCRE_SRC_PassportNo').removeClass('invalid');$('#CCRE_SRC_PassportNo').val($("#CCRE_SRC_PassportNo").val().toUpperCase());}else{passportnoflag=0;$('#CSRC_lbl_passporterrormsg').show();$('#CCRE_SRC_PassportNo').addClass('invalid');}}else{$('#CSRC_lbl_passporterrormsg').hide();passportnoflag=1;$('#CCRE_SRC_PassportNo').removeClass('invalid');}
            /******EP NO************/
            var epno=$('#CCRE_SRC_EpNo').val();
            if(epno!=""){if(epno.length>=6){var epnoflag=1;$('#CSRC_lbl_epnoerrormsg').hide();$('#CCRE_SRC_EpNo').removeClass('invalid');$('#CCRE_SRC_EpNo').val($("#CCRE_SRC_EpNo").val().toUpperCase())}else{epnoflag=0;$('#CSRC_lbl_epnoerrormsg').show();$('#CCRE_SRC_EpNo').addClass('invalid');}}else{$('#CSRC_lbl_epnoerrormsg').hide();$('#CCRE_SRC_EpNo').removeClass('invalid');epnoflag=1;}
            /******DEPOSIT ************/
            var deposit=$('#CCRE_SRC_DepositFee').val();
            if(deposit!=""){var depositamount=deposit.split('.');if(depositamount[0].length>=3){var depositflag=1;$('#CSRC_lbl_depositerrormsg').hide();$('#CCRE_SRC_DepositFee').removeClass('invalid');}else{depositflag=0;$('#CSRC_lbl_depositerrormsg').show();$('#CCRE_SRC_DepositFee').addClass('invalid');}}else{$('#CSRC_lbl_depositerrormsg').hide();depositflag=1;$('#CCRE_SRC_DepositFee').removeClass('invalid');}
            /******PROCESS************/
            var process=$('#CCRE_SRC_ProcessingFee').val();
            if(process!=""){var processamount=process.split('.');if(processamount[0].length>=3){var processflag=1;$('#CSRC_lbl_processerrormsg').hide();$('#CCRE_SRC_ProcessingFee').removeClass('invalid');}else{processflag=0;$('#CSRC_lbl_processerrormsg').show();$('#CCRE_SRC_ProcessingFee').addClass('invalid');}}else{$('#CSRC_lbl_processerrormsg').hide();$('#CCRE_SRC_ProcessingFee').removeClass('invalid');processflag=1;}
            /******RENT************/
            var rent=$('#CCRE_SRC_Rent').val();
            if(rent!=""){var rentamount=rent.split('.');if(rentamount[0].length>=3){var rentflag=1;$('#CSRC_lbl_renterrormsg').hide();$('#CCRE_SRC_Rent').removeClass('invalid');}else{rentflag=0;$('#CSRC_lbl_renterrormsg').show();$('#CCRE_SRC_Rent').addClass('invalid');}}else{$('#CSRC_lbl_renterrormsg').hide();$('#CCRE_SRC_Rent').removeClass('invalid');rentflag=1;}
            /******ELECTRICITY CAP************/
            var electricity=$('#CCRE_SRC_ElectricitycapFee').val();
            if(electricity!=""){var electamount=electricity.split('.');if(electamount[0].length>=2){var electflag=1;$('#CSRC_lbl_electcaperrormsg').hide();$('#CCRE_SRC_ElectricitycapFee').removeClass('invalid');}else{electflag=0;$('#CSRC_lbl_electcaperrormsg').show();$('#CCRE_SRC_ElectricitycapFee').addClass('invalid');}}else{$('#CSRC_lbl_electcaperrormsg').hide();$('#CCRE_SRC_ElectricitycapFee').removeClass('invalid');electflag=1;}
//         if($('#CCRE_SRC_PassportDate').val()=="" && $('#CCRE_SRC_PassportNo').val()=="") { var passportflag=1;$('#CSRC_lbl_passportnodateerrormsg').hide() } else { if($('#CCRE_SRC_PassportDate').val()!="" && $('#CCRE_SRC_PassportNo').val()==""){passportflag=0;$('#CSRC_lbl_passportnodateerrormsg').show()} else {passportflag=1;$('#CSRC_lbl_passportnodateerrormsg').hide()} }
//         if($('#CCRE_SRC_EPDate').val()=="" && $('#CCRE_SRC_EpNo').val()=="") { var epflag=1;$('#CSRC_lbl_epnodateerrormsg').hide() } else { if($('#CCRE_SRC_EPDate').val()!="" && $('#CCRE_SRC_EpNo').val()==""){epflag=0;$('#CSRC_lbl_epnodateerrormsg').show()} else {epflag=1;$('#CSRC_lbl_epnodateerrormsg').hide()} }
            var ppdate=$('#CCRE_SRC_PassportDate').val();
            var ppno=$('#CCRE_SRC_PassportNo').val();
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
            var EPdate=$('#CCRE_SRC_EPDate').val();
            var EPno=$('#CCRE_SRC_EpNo').val();
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
            var CCRE_emailid=$("#CCRE_SRC_Emailid").val();
            var CCRE_atpos=CCRE_emailid.indexOf("@");
            var CCRE_dotpos=CCRE_emailid.lastIndexOf(".");
            if(CCRE_emailid.length>0)
            {
                if ((/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(CCRE_emailid) || "" == CCRE_emailid)&&(CCRE_atpos-1!=CCRE_emailid.indexOf(".")))
                {
                    $('#CSRC_lbl_emailiderrormsg').hide();
                    var CCRE_emailchk="valid";
                    $('#CCRE_SRC_Emailid').removeClass('invalid');
                    $('#CCRE_SRC_Emailid').val(CCRE_emailid.toLowerCase());
                }
                else
                {
                    $('#CSRC_lbl_emailiderrormsg').show();
                    CCRE_emailchk="invalid"
                    $('#CCRE_SRC_Emailid').addClass('invalid');
                }
            }
            else
            {
                CCRE_emailchk="invalid"
                $('#CCRE_SRC_Emailid').removeClass('invalid');
                $('#CSRC_lbl_emailiderrormsg').hide();
            }
            var pp_date=$('#CCRE_SRC_PassportDate').val();
            var end_date=$("#CCRE_SRC_Enddate").val();
            var ep_date=$('#CCRE_SRC_EPDate').val();
            if(pp_date!="" && end_date!="")
            {
                var newpp_date=FormnewDateFormat(pp_date);
                var newend_date=FormnewDateFormat(end_date);
                if(newpp_date>newend_date)
                {var ppdateflag=1;}
                else
                {ppdateflag=0;}
            }
            else{ppdateflag=1;}
            if(ep_date!="" && end_date!="")
            {
                var newep_date=FormnewDateFormat(ep_date);
                var newend_date=FormnewDateFormat(end_date);
                if(newep_date>newend_date)
                {var epdateflag=1;}
                else
                {epdateflag=0;}
            }
            else
            {epdateflag=1}
            if($("#CCRE_SRC_FirstName").val()!=""&& $("#CCRE_SRC_LastName").val()!="" && $("#CCRE_SRC_Emailid").val()!="" && $("#CCRE_SRC_Nationality").val()!="SELECT"&& $("#CCRE_SRC_SDStarttime").val()!="Select"&&
                $("#CCRE_SRC_UnitNo").val()!="SELECT"&& $("#CCRE_SRC_RoomType").val()!="SELECT" && $("#CCRE_SRC_EDStarttime").val()!="Select" && $("#CCRE_SRC_Option").val()!="SELECT"&& $("#CCRE_SRC_MailList").val()!="SELECT"
                && $("#CCRE_SRC_Rent").val()!=""&& $("#CCRE_SRC_Startdate").val()!=""&& $("#CCRE_SRC_Enddate").val()!="" && (CCRE_emailchk=="valid") && mobileflag==1 && intlmobileflag==1 && officenoflag==1&& passportnoflag==1 && epnoflag==1 && depositflag==1 && rentflag==1 && postalflag==1 &&electflag==1 && passportflag==1 && epflag==1 && ppdateflag==1 && epdateflag==1)
            {
                $("#CSRC_btn_Updatebutton").removeAttr("disabled");
            }
            else
            {
                $("#CSRC_btn_Updatebutton").attr("disabled", "disabled");
            }
        });
        function FormnewDateFormat(inputdate)
        {
            var string = inputdate.split("-");
            var newdate=new Date(string[2],string[1]-1,string[0])
            return newdate;
        }
        $( "#CCRE_SRC_PassportDate" ).datepicker({dateFormat: 'dd-mm-yy',changeYear: true,changeMonth: true});
        $( "#CCRE_SRC_EPDate" ).datepicker({dateFormat: 'dd-mm-yy',changeYear: true,changeMonth: true});
        var passCCRE_d = new Date();
        var CCRE_passyear = passCCRE_d.getFullYear()+10;
        var pass_changedmonth=new Date(passCCRE_d.setFullYear(CCRE_passyear));
        $('#CCRE_SRC_PassportDate').datepicker("option","maxDate",pass_changedmonth);
        var epCCRE_d = new Date();
        var CCRE_epyear = epCCRE_d.getFullYear()+3;
        var ep_changedmonth=new Date(epCCRE_d.setFullYear(CCRE_epyear));
        $('#CCRE_SRC_EPDate').datepicker("option","maxDate",ep_changedmonth);

        $(document).on('click','#CustomerSearch_Reset', function (){
            $('#CSRC_updation_form').hide();
        });
        $(document).on('change','.Unitchange', function (){
            var unit=$('#CCRE_SRC_UnitNo').val();
            $("#CSRC_btn_Updatebutton").attr("disabled", "disabled");
            AccesscarddivClear();
            if(unit!='SELECT') {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url + "CustomerRoomTypeLoad",
                    data: {Unit: unit},
                    success: function (data) {
                        $('.preloader').hide();
                        var value_array = JSON.parse(data);
                        var Roomtypes = '<OPTION>SELECT</OPTION>';
                        for (var i = 0; i < value_array[0].length; i++) {
                            var data = value_array[0][i];
                            Roomtypes += '<option value="' + data.URTD_ROOM_TYPE + '">' + data.URTD_ROOM_TYPE + '</option>';
                        }
                        $('#CCRE_SRC_RoomType').html(Roomtypes);
                        $('#CCRE_SRC_Startdate').val('').show;
                        $('#CCRE_SRC_Enddate').val('');
                        var UnitDates = value_array[1];
                        var customerstartdate = value_array[2][0].CCN_DATA;
                        var UnitSD = UnitDates[0].UD_START_DATE;
                        var mindate = DBfromunit_dateConversion(UnitSD);
                        var UnitED = UnitDates[0].UD_END_DATE;
                        var maxdate = DBtounit_dateConversion(UnitED);
                        var newdate = NewDate_dateConversion()
                        var customerminimumsd = customersd_DBfromunit_dateConversion(customerstartdate);
                        if (mindate > customerminimumsd) {
                            $('#CCRE_SRC_Startdate').datepicker("option", "minDate", mindate);
                        }
                        else {
                            $('#CCRE_SRC_Startdate').datepicker("option", "minDate", customerminimumsd);
                        }
                        $('#CCRE_SRC_Startdate').datepicker("option", "maxDate", maxdate);
                        $('#CCRE_SRC_Enddate').datepicker("option", "minDate", newdate);
                        $('#CCRE_SRC_Enddate').datepicker("option", "maxDate", maxdate);
                        $('#RoomtypeDiv').show();
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else
            {
                AccesscarddivClear();
            }
        });
        function AccesscarddivClear() {
            $('#startdatediv').hide();
            $('#CusromerEnddate').hide();
            $('#RoomtypeDiv').hide();
            $('#CCRE_SRC_Startdate').val('');
            $('#CCRE_SRC_Enddate').val('');
            $('#CCRE_SRC_EDStarttime').val('Select');
            $('#CCRE_SRC_SDStarttime').val('Select');
            $('#startdatetotime').hide();
            $('#endatedateto').hide();
        }

        function DBfromunit_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[0],inputdate[1]-1,inputdate[2]);
            return newunitstartdate;
        }
        function customersd_DBfromunit_dateConversion(customerstartdate)
        {
            var date=new Date();
            var newunitstartdate=new Date(date.getFullYear(),date.getMonth()-customerstartdate,date.getDate());
            return newunitstartdate;
        }
        function DBtounit_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[0],inputdate[1]-1,inputdate[2]-1);
            return newunitstartdate;
        }

        $(document).on('click','#CSRC_btn_Updatebutton', function (){
//         $('.preloader').show();
            $('#CCRE_SRC_UnitNo').prop('disabled', false);
            $('#CCRE_SRC_SDStarttime').prop('disabled', false);
            $('#CCRE_SRC_SDEndtime').prop('disabled', false);
            $('#CCRE_SRC_EDStarttime').prop('disabled', false);
            $('#CCRE_SRC_EDEndtime').prop('disabled', false);
            $('#CCRE_SRC_Startdate').prop('disabled', false);
            $('#CCRE_SRC_Enddate').prop('disabled', false);
            $('#CCRE_SRC_NoticePeriodDate').prop('disabled', false);
            var FormElements = document.getElementById("CCRE_Form_CustomerSearch");
//         var CSRC_customer_acc_detailstitle="CUSTOMER ACCOUNT DETAILS - ";
//         var CSRC_customer_acc_detailsemptytitle="RECORDS NOT AVAILABLE FOR SELECTED ";
//         var searchoption=$('#CC_SRC_SearchOption').val();
//         if(searchoption==18)
//         {
//             var companyname=$('#CC_SRC_CardNoSearch').val();
//             var data={"SearchOption":searchoption,"data1":companyname}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" CARD NO : "+companyname;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" CARD NO: "+companyname;
//         }
//         if(searchoption==19)
//         {
//             var companyname=$('#CC_SRC_CompanyNameSearch').val();
//             var data={"SearchOption":searchoption,"data1":companyname}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" COMPANY NAME : "+companyname;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" COMPANY NAME: "+companyname;
//         }
//         if(searchoption==21)
//         {
//             var customer_name=$('#CC_SRC_CustomerNameSearch').val();
//             var customername=customer_name.replace('  ','_');
//             var data={"SearchOption":searchoption,"data1":customername}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" CUSTOMER NAME : "+customer_name;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" CUSTOMER NAME: "+customer_name;
//         }
//         if(searchoption==22)
//         {
//             var CC_SRC_fromamt=$('#CC_SRC_FromAmount').val();
//             var CC_SRC_toamt=$('#CC_SRC_ToAmount').val();
//             var data={"SearchOption":searchoption,"data1":CC_SRC_fromamt,"data2":CC_SRC_toamt}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" DEPOSIT AMOUNT RANGE: "+CC_SRC_fromamt+" To "+CC_SRC_toamt
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" DEPOSIT AMOUNT RANGE: "+CC_SRC_fromamt+" To "+CC_SRC_toamt;
//         }
//         if(searchoption==30)
//         {
//             var CC_SRC_fromamt=$('#CC_SRC_FromAmount').val();
//             var CC_SRC_toamt=$('#CC_SRC_ToAmount').val();
//             var data={"SearchOption":searchoption,"data1":CC_SRC_fromamt,"data2":CC_SRC_toamt}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" RENT AMOUNT RANGE: "+CC_SRC_fromamt+" To "+CC_SRC_toamt
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" RENT AMOUNT RANGE: "+CC_SRC_fromamt+" To "+CC_SRC_toamt;
//         }
//         if(searchoption==27)
//         {
//             var CC_SRC_fromamt=$('#CC_SRC_listsearch').val();
//             var data={"SearchOption":searchoption,"data1":CC_SRC_fromamt,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" NATIONALITY : "+CC_SRC_fromamt;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" NATIONALITY: "+CC_SRC_fromamt;
//         }
//         if(searchoption==31)
//         {
//             var Unit=$('#CC_SRC_listsearch').val();
//             var data={"SearchOption":searchoption,"data1":Unit,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" UNIT NO : "+Unit;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" UNIT NO: "+Unit;
//         }
//         if(searchoption==33)
//         {
//             var Roomtype=$('#CC_SRC_listsearch').val();
//             var data={"SearchOption":searchoption,"data1":Roomtype,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" ROOM TYPE : "+Roomtype;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" ROOM TYPE: "+Roomtype;
//         }
//         if(searchoption==24)
//         {
//             var Email=$('#CC_SRC_EmailSearch').val();
//             var data={"SearchOption":searchoption,"data1":Email,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" EMAIL ID : "+Email;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" EMAIL ID: "+Email;
//         }
//         if(searchoption==25)
//         {
//             var Epno=$('#CC_SRC_EPnoSearch').val();
//             var data={"SearchOption":searchoption,"data1":Epno,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" EP NUMBER : "+Epno;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" EP NUMBER: "+Epno;
//         }
//         if(searchoption==29)
//         {
//             var Passportno=$('#CC_SRC_PassportnoSearch').val();
//             var data={"SearchOption":searchoption,"data1":Passportno,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" PASSPORT NUMBER : "+Passportno;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" PASSPORT NUMBER: "+Passportno;
//         }
//         if(searchoption==26)
//         {
//             var Mobile=$('#CC_SRC_MobilenoSearch').val();
//             var data={"SearchOption":searchoption,"data1":Mobile,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" MOBILE NUMBER : "+Mobile;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" MOBILE NUMBER: "+Mobile;
//         }
//         if(searchoption==32)
//         {
//             var Mobile=$('#CC_SRC_IntMobilenoSearch').val();
//             var data={"SearchOption":searchoption,"data1":Mobile,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" INT'L NUMBER : "+Mobile;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" INT'L NUMBER : "+Mobile;
//         }
//         if(searchoption==28)
//         {
//             var Mobile=$('#CC_SRC_OfficenoSearch').val();
//             var data={"SearchOption":searchoption,"data1":Mobile,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" OFFICE NUMBER : "+Mobile;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" OFFICE NUMBER : "+Mobile;
//        }
//         if(searchoption==20)
//         {
//             var Comments=$('#CC_SRC_CommentsSearch').val();
//             var data={"SearchOption":searchoption,"data1":Comments,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" COMMENTS : "+Comments;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" COMMENTS : "+Comments;
//         }
//         if(searchoption==23)
//         {
//             var fromdate=$('#CC_SRC_Fromdate').val();
//             var todate=$('#CC_SRC_Todate').val();
//             var data={"SearchOption":searchoption,"data1":fromdate,"data2":todate}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" DOB: "+fromdate+" To "+todate;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" DOB: "+fromdate+" To "+todate;
//         }
//         if(searchoption==34)
//         {
//             var fromdate=$('#CC_SRC_Leaseperiod').val();
//             var data={"SearchOption":searchoption,"data1":fromdate,"data2":''}
//             var CSRC_customerheader=CSRC_customer_acc_detailstitle+" LEASE PERIOD : "+fromdate;
//             var CSRC_emptycustomerheader=CSRC_customer_acc_detailsemptytitle+" LEASE PERIOD : "+fromdate;
//         }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    $('.preloader').hide();
                    var msg_alert = JSON.parse(xmlhttp.responseText);
                    $('.preloader').hide();
                    if (msg_alert == 1) {
                        $('#CC_SRC_SearchOption').val("");
                        $('#CC_SearchformDiv').hide();
                        $('#CC_SEARCH_DataTable').hide();
                        $('#CC_SEARCH_acDataTable').hide();
                        $('#CSRC_updation_form').hide();
                        $('#CSRC_div_fileupload').html('').html('<input type="file" id="CSRC_fileupload" name="CSRC_fileupload" class="form-control CSRC_fileextensionchk" />');
                        show_msgbox("CUSTOMER SEARCH/UPDATE",errormsg[18].EMC_DATA,"success",false);
                    }
                    else {
                        $('#CC_SRC_SearchOption').val("");
                        $('#CCRE_SRC_UnitNo').prop('disabled', true);
                        $('#CCRE_SRC_SDStarttime').prop('disabled', true);
                        $('#CCRE_SRC_SDEndtime').prop('disabled', true);
                        $('#CCRE_SRC_EDStarttime').prop('disabled', true);
                        $('#CCRE_SRC_EDEndtime').prop('disabled', true);
                        $('#CCRE_SRC_Startdate').prop('disabled', true);
                        $('#CCRE_SRC_Enddate').prop('disabled', true);
                        $('#CCRE_SRC_NoticePeriodDate').prop('disabled', true);
                        if(msg_alert == 0)
                            show_msgbox("CUSTOMER SEARCH/UPDATE",data,"error",false);
                        else
                            show_msgbox("CUSTOMER SEARCH/UPDATE",xmlhttp.responseText,"error",false);
                    }
                }
            }
//         xmlhttp.open("POST",controller_url+"CustomerDetailsUpdate?SearchOption="+searchoption+"&data1="+customer_name+"&data2="+customer_name, true);
            xmlhttp.open("POST",controller_url+"CustomerDetailsUpdate", true);
            xmlhttp.send(new FormData(FormElements));
        });
        $(document).on('change','#CCRE_SRC_SDStarttime',function(){
            var fromtime=$('#CCRE_SRC_SDStarttime').val();
            if(fromtime!='Select')
            {
                var CCRE_timelist=totimecalculation(fromtime);
                $('#CCRE_SRC_SDEndtime').html(CCRE_timelist);
                $('#startdatetotime').show();
            }
            else
            {
                $('#startdatetotime').hide();
            }
        });
        $(document).on('change','#CCRE_SRC_EDStarttime',function(){
            var fromtime=$('#CCRE_SRC_EDStarttime').val();
            if(fromtime!='Select')
            {
                var CCRE_timelist=totimecalculation(fromtime);
                $('#CCRE_SRC_EDEndtime').html(CCRE_timelist).show();
                $('#endatedateto').show();
            }
            else
            {
                $('#endatedateto').hide();
            }
        });
        function totimecalculation(starttime)
        {
            for(var i=0;i<timelist.length;i++)
            {
                if(starttime==timelist[i].TIME)
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
                for(var i=location;i<timelist.length;i++)
                {
                    var data=timelist[i];
                    CCRE_timelist += '<option value="' + data.TIME + '">' + data.TIME + '</option>';
                }
            }
            else
            {
                CCRE_timelist += '<option value="23:59">23:59</option>';
            }
            return CCRE_timelist;
        }
        $(document).on('change', '.proratedcheck', function () {
            var startdate = $('#CCRE_SRC_Startdate').val();
            var enddate = $('#CCRE_SRC_Enddate').val();
            var Rent = $('#CCRE_Rent').val();
            if (startdate != '' && enddate != '' && Rent != '') {
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
        $(document).on('change', '.CSRC_fileextensionchk', function () {
            var filename = $('#CSRC_fileupload').val();
            var valid_extensions = /(\.pdf)$/i;
            if (valid_extensions.test(filename)) {
            }
            else {
                show_msgbox("CUSTOMER CREATION", 'UPLOAD ONLY PDF FILES', "success", false);
                $('#CSRC_fileupload').val('');
            }
        });
        $(document).on('change', '.calvalidation', function () {
            $('#CCRE_SRC_Calflag').val(1);
        });
        /**************RECORD DELETE BUTTON***************************/
        var cust_delid='';
        $(document).on('click','.deleteconfirm',function(){
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url+"CustomerRrecordDelete",
                data:{customerid:cust_delid},
                success: function(data){
                    if(data==1)
                    {
                        show_msgbox("CUSTOMER SEARCH/UPDATE/DELETE",errormsg[19].EMC_DATA, "success", false);
                    }
                    else
                    {
                        show_msgbox("CUSTOMER SEARCH/UPDATE/DELETE",errormsg[20].EMC_DATA, "success", false);
                    }
                    $('#CSRC_updation_form').hide();
                    $('#CC_SEARCH_DataTable').hide();
                    $('#CC_SEARCH_acDataTable').hide();
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });

        $(document).on('click', '.CC_SRC_removebutton', function ()
        {
            cust_delid=this.id;
            show_msgbox("CUSTOMER SEARCH/UPDATE/DELETE",errormsg[8].EMC_DATA,"success","delete");

        });
        $(document).on('change', '#CCRE_SRC_Startdate', function () {
            if ($('#CCRE_SRC_Startdate').val() != "") {
                $('#startdatediv').show();
//            $('#CusromerEnddate').show();
            }
            else {
                $('#startdatediv').hide();
//            $('#CusromerEnddate').hide();
            }
        });
        $(document).on('change','.Datepickerhide',function(){
            if ($('#CCRE_SRC_SDStarttime').val() != "Select") {
                $('#CusromerEnddate').show();
            }
            else {
                $('#CusromerEnddate').hide();
                $('#CCRE_SRC_EDStarttime').val('Select');
                $('#CCRE_SRC_Enddate').val('');
                $('#CCRE_SRC_EDEndtime').hide();
            }
        });
    });
</script>
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>CUSTOMER SEARCH UPDATE</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <div class="row form-group" style="padding-left:20px;">
                    <div class="col-md-3">
                        <label>SEARCH BY<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-3">
                        <SELECT class="form-control" name="CC_SRC_SearchOption"  id="CC_SRC_SearchOption">
                            <OPTION>SELECT</OPTION>
                        </SELECT>
                    </div>
                </div>
                <br>
                <div id="CC_SearchformDiv">

                </div>
                <div id="CC_SEARCH_DataTable" class="table-responsive" hidden>
                    <h3 style="color:#498af3">CUSTOMER PERSONAL DETAILS</h3><br>
                    <section id="Customer_Personal_Table">

                    </section>
                </div>
                <div id="CC_SEARCH_acDataTable" class="table-responsive" hidden>
                    <h3 style="color:#498af3" id="Accesscardheader"></h3><br>
                    <section id="AccessCard_table">

                    </section>
                </div>
                <div id="tableemptymessage">
                    <h3 class="errormsg" id="tableempty_message"></h3><br>
                </div>
                <div id="CSRC_updation_form" hidden>
                    <h3 style="color:#498af3">CUSTOMER DETAILS UPDATION</h3>
                    <form id="CCRE_Form_CustomerSearch" class="form-horizontal" role="form">
                        <div class="panel-body">
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>FIRST NAME<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control autosize customernamechange calvalidation" name="CCRE_SRC_FirstName" maxlength="30" required id="CCRE_SRC_FirstName"/>
                                    <input input type="hidden" class="form-control" name="CCRE_SRC_customerid" style="width:30px;"  id="CCRE_SRC_customerid"/>
                                    <input input type="hidden" class="form-control" name="CCRE_SRC_Recver" style="width:30px;" id="CCRE_SRC_Recver"/>
                                    <input input type="hidden" class="form-control" name="CCRE_SRC_Calflag" style="width:50px;" id="CCRE_SRC_Calflag" value="0"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>LAST NAME<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control autosize customernamechange calvalidation" name="CCRE_SRC_LastName" maxlength="30" required id="CCRE_SRC_LastName" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>COMPANY NAME</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control compautosize" name="CCRE_SRC_CompanyName" maxlength="50" required id="CCRE_SRC_CompanyName" placeholder="Company Name"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>COMPANY ADDRESS</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control compautosize" name="CCRE_SRC_CompanyAddress" maxlength="50" required id="CCRE_SRC_CompanyAddress" placeholder="Company Address" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>COMPANY POSTAL CODE</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" name="CCRE_SRC_CompanyPostalCode" maxlength="6" style="max-width:100px;" id="CCRE_SRC_CompanyPostalCode" placeholder="PostalCode"/>
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_postalerrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>E-MAIL ID<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control calvalidation" name="CCRE_SRC_Emailid" required id="CCRE_SRC_Emailid" />
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_emailiderrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>MOBILE</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control numonlynozero mobilevalidation calvalidation" name="CCRE_SRC_Mobile" maxlength="8" style="max-width:100px;" id="CCRE_SRC_Mobile" placeholder="Mobile No"/>
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_mobileerrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>INT'L MOBILE</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control calvalidation" name="CCRE_SRC_IntlMobile" maxlength="15" style="max-width:150px;" id="CCRE_SRC_IntlMobile" placeholder="Int'l Mobile No" />
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_intlmobileerrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>OFFICE NO</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control numonlynozero officevalidation calvalidation" name="CCRE_SRC_Officeno" maxlength="8" style="max-width:110px;" id="CCRE_SRC_Officeno" placeholder="Office No"/>
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_officeerrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>DATE OF BIRTH</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" name="CCRE_SRC_DOB"  style="max-width:120px;" id="CCRE_SRC_DOB" placeholder="D.O.B"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>NATIONALITY<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-3">
                                    <SELECT class="form-control" name="CCRE_SRC_Nationality" maxlength="8" required id="CCRE_SRC_Nationality" >
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
                                    <input class="form-control alnumonlyzero" name="CCRE_SRC_PassportNo" maxlength="15" style="max-width:170px;" id="CCRE_SRC_PassportNo" placeholder="PassPort No"/>
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_passporterrormsg" class="errormsg" hidden></label></div>
                                <div class="col-md-3"><label id="CSRC_lbl_passportnodateerrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div id="passportdate">
                                    <div class="col-md-3">
                                        <label>PASSPORT EXPITY DATE</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control passportdatevalidation datenonmandtry" name="CCRE_SRC_PassportDate" maxlength="15" style="max-width:120px;" id="CCRE_SRC_PassportDate" placeholder="PassPort Date">
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_pportdateerrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div id="epnumber">
                                    <div class="col-md-3">

                                        <label>EP NUMBER</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control alnumonlynozero" name="CCRE_SRC_EpNo" style="max-width:170px;" maxlength="15" id="CCRE_SRC_EpNo" placeholder="EP Number"/>
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_epnoerrormsg" class="errormsg" hidden></label></div>
                                <div class="col-md-3"><label id="CSRC_lbl_epnodateerrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div id="EPdate">
                                    <div class="col-md-3">
                                        <label>EP EXPIRY DATE</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control epdatevalidation" name="CCRE_SRC_EPDate" style="max-width:120px;" id="CCRE_SRC_EPDate" placeholder="EP Date"/>
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_ep_dateerrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>UNIT NUMBER<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-3">
                                    <SELECT class="form-control Unitchange calvalidation" name="CCRE_SRC_UnitNo" style="max-width:120px;" id="CCRE_SRC_UnitNo">
                                        <OPTION>SELECT</OPTION>
                                    </SELECT>
                                </div>
                            </div>
                            <div class="row form-group" id="RoomtypeDiv">
                                <div class="col-md-3">
                                    <label>ROOM TYPE<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-3">
                                    <SELECT class="form-control calvalidation" name="CCRE_SRC_RoomType" style="max-width:200px;" id="CCRE_SRC_RoomType">
                                        <OPTION>SELECT</OPTION>
                                    </SELECT>
                                </div>
                            </div>
                            <div id="AccessCardDiv" hidden>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>CHECK IN DATE<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <input class="form-control calvalidation prorated startdatevalidate datemandtry noticedate proratedcheck" name="CCRE_SRC_Startdate"  style="max-width:105px;" id="CCRE_SRC_Startdate"/>
                                        </div>
                                        <div id="startdatediv">
                                            <div class="col-md-1">
                                                <label>FROM</label>
                                            </div>
                                            <div class="col-md-2">
                                                <SELECT class="form-control totimevalidation calvalidation Datepickerhide" name="CCRE_SRC_SDStarttime"  style="max-width:100px;" id="CCRE_SRC_SDStarttime">
                                                    <OPTION>Select</OPTION>
                                                </SELECT>
                                            </div>
                                            <div id="startdatetotime" >
                                                <div class="col-md-1">
                                                    <label>TO</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <SELECT class="form-control calvalidation" name="CCRE_SRC_SDEndtime"  style="max-width:100px;" id="CCRE_SRC_SDEndtime" hidden>
                                                        <OPTION>Select</OPTION>
                                                    </SELECT>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" id="CusromerEnddate">
                                <div class="col-md-3">
                                    <label>CHECK OUT DATE<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <input class="form-control calvalidation noticedate datemandtry Enddatevalidate proratedcheck" name="CCRE_SRC_Enddate"  style="max-width:105px;" id="CCRE_SRC_Enddate"/>
                                        </div>
                                        <div class="col-md-1">
                                            <label>FROM</label>
                                        </div>
                                        <div class="col-md-2">
                                            <SELECT class="form-control calvalidation" name="CCRE_SRC_EDStarttime"  style="max-width:100px;" id="CCRE_SRC_EDStarttime">
                                                <OPTION>Select</OPTION>
                                            </SELECT>
                                        </div>
                                        <div id="endatedateto" >
                                            <div class="col-md-1">
                                                <label >TO</label>
                                            </div>
                                            <div class="col-md-2">
                                                <SELECT class="form-control calvalidation" name="CCRE_SRC_EDEndtime"  style="max-width:100px;" id="CCRE_SRC_EDEndtime">
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
                                    <input class="form-control" name="CCRE_SRC_NoticePeriod" maxlength="1" style="max-width:70px;" id="CCRE_SRC_NoticePeriod" placeholder="NP"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>NOTICE PERIOD DATE</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" name="CCRE_SRC_NoticePeriodDate"  style="max-width:120px;" id="CCRE_SRC_NoticePeriodDate" placeholder="NoticeDate"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>SELECT AIRCON FEE</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <div class="col-md-6" style="padding-left: 30px;">
                                            <input type="radio" class="Airconfeechange" name="Aircon" id="CCRE_Quaterlyfee" value="QuarterlyFee">QUARTERLY SERVICE FEE
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control CCRE_amtonlyvalidation" maxlength="6"  name="CCRE_SRC_Quarterly_fee" id="CCRE_SRC_Quarterly_fee" hidden placeholder="0.00"/>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-6" style="padding-left: 30px;">
                                            <input type="radio" class="Airconfeechange" name="Aircon" id="CCRE_Airconfee" value="FixedAircon">FIXED AIRCON FEE
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control CCRE_amtonlyvalidation" maxlength="6" name="CCRE_SRC_Fixedaircon_fee" id="CCRE_SRC_Fixedaircon_fee" hidden placeholder="0.00"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>ELECTRICITY CAPPED</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control CCRE_amtonlyvalidation" maxlength="6" name="CCRE_SRC_ElectricitycapFee"  style="max-width:100px;" id="CCRE_SRC_ElectricitycapFee" placeholder="0.00"/>
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_electcaperrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>CURTAIN DRY CLEANING FEE</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control CCRE_amtonlyvalidation" maxlength="6" name="CCRE_SRC_Curtain_DrycleanFee"  style="max-width:100px;" id="CCRE_SRC_Curtain_DrycleanFee" placeholder="0.00"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>CHECKOUT CLEANING FEE</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control CCRE_amtonlyvalidation" maxlength="6" name="CCRE_SRC_CheckOutCleanFee"  style="max-width:100px;" id="CCRE_SRC_CheckOutCleanFee" placeholder="0.00">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>DEPOSIT</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control CCRE_amtonlyvalidationmaxdigit" maxlength="7" name="CCRE_SRC_DepositFee"  style="max-width:100px;" id="CCRE_SRC_DepositFee" placeholder="0.00">
                                </div>
                                <div class="col-md-3"><label id="CSRC_lbl_depositerrormsg" class="errormsg" hidden></label></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>RENT<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-9">
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <input class="form-control CCRE_amtonlyvalidationmaxdigit proratedcheck" name="CCRE_SRC_Rent" maxlength="7"  style="max-width:100px;" id="CCRE_SRC_Rent" placeholder="0.00">
                                        </div>
                                        <div class="col-md-1">
                                            <input id="CCRE_Rent_Prorated" type="checkbox" name="CCRE_Rent_Prorated">
                                        </div>
                                        <div>
                                            <label id="CCRE_lbl_prorated"></label>
                                        </div>
                                        <div class="col-md-3"><label id="CSRC_lbl_renterrormsg" class="errormsg" hidden></label></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>PROCESSING COST</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <input class="form-control CCRE_processamtonlyvalidationmaxdigit" name="CCRE_SRC_ProcessingFee"  style="max-width:100px;" id="CCRE_SRC_ProcessingFee" placeholder="0.00">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="checkbox" name="CCRE_process_waived" id="CCRE_process_waived">
                                        </div>
                                        <div >
                                            <label id="CCRE_lbl_waived"></label>
                                        </div>
                                        <div class="col-md-3"><label id="CSRC_lbl_processerrormsg" class="errormsg" hidden></label></div>
                                    </div>
                                </div>

                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>SELECT THE OPTION<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-3">
                                    <SELECT class="form-control" name="CCRE_SRC_Option"  style="max-width:200px;" id="CCRE_SRC_Option">
                                        <OPTION>SELECT</OPTION>
                                    </SELECT>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>E-MAIL ID<span class="labelrequired"><em>*</em></span></label>
                                </div>
                                <div class="col-md-3">
                                    <SELECT class="form-control" name="CCRE_SRC_MailList" id="CCRE_SRC_MailList">
                                        <OPTION>SELECT</OPTION>
                                    </SELECT>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>COMMENTS</label>
                                </div>
                                <div class="col-md-3">
                                    <textarea class="form-control autogrowcomments" style="min-height:116px" name="CCRE_SRC_Comments"  id="CCRE_SRC_Comments"></textarea>
                                </div>
                            </div>
                            <div id="uploadedfilesview">

                            </div>

                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label>FILE UPLOAD</label>
                                </div>
                                <div class="col-md-3" id="CSRC_div_fileupload">
                                    <input type="file" id="CSRC_fileupload" name="CSRC_fileupload" class="form-control CSRC_fileextensionchk" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-offset-2 col-lg-3">
                                    <input type="button" id="CSRC_btn_Updatebutton" class="btn" value="UPDATE" disabled>         <input type="button" id="CustomerSearch_Reset" class="btn" value="CANCEL">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>