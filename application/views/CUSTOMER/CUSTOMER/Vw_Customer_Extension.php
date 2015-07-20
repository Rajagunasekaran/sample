<!--//*******************************************FILE DESCRIPTION*********************************************//
/**********************************************CUSTOMER EXTENSION******************************************/
//DONE BY:SAFI
//VER 0.02-SD:20/06/2015 ED:20/06/2015 -removed duplicate cust radio
//VER 0.01-INITIAL VERSION SD:01/06/2014 ED:12/06/2015
//*********************************************************************************************************//
-->
<?php

require_once('application/libraries/EI_HDR.php');

?>
<!--HTML TAG START-->
<html>
<!--HEAD TAG START-->
<head>
    <style>
        .colsmhf {
            width: 11.666%;
            padding-top: 2px;
            padding-left: 15px;
            padding-right: 0px;
        }
    </style>
</head>
<!--HEAD TAG END-->
<!--SCRIPT TAG START-->
<script>

    //JQUERY FUNCTIONALITIES
    $(document).ready(function(){
        $('#spacewidth').height('0%');
        $('textarea').autogrow({onInitialize: true});
        var controller_url="<?php echo base_url(); ?>" +'/index.php/CUSTOMER/CUSTOMER/Ctrl_Customer_Extension/';
        //FUNCTION TO ALERT TRY CATCH ERROR MESSAGE
        //        function onFailure(CEXTN_error) {
        //            $(".preloader").hide();
        //            if(CEXTN_error=="ScriptError: Failed to establish a database connection. Check connection string, username and password.")
        //            {
        ////$('#CEXTN_form').hide();
        //                CEXTN_error="DB USERNAME/PWD WRONG, PLZ CHK UR CONFIG FILE FOR THE CREDENTIALS."
        //                $('#CEXTN_form').replaceWith('<center><label class="dberrormsg">'+CEXTN_error+'</label></center>');
        //            }
        //            else
        //            {
        //                if(CEXTN_error=='TypeError: Cannot call method "getEvents" of undefined.'||CEXTN_error=='TypeError: Cannot call method "createEvent" of undefined.')
        //                {
        //                    CEXTN_error=CEXTN_errmsgs[25];
        //                }
        //                else if(CEXTN_error=='ScriptError: No item with the given ID could be found, or you do not have permission to access it.')
        //                {
        //                    CEXTN_error=CEXTN_errmsgs[26];
        //                }
        //                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER EXTENSION",msgcontent:CEXTN_error,position:{top:150,left:500}}});
        //            }
        //        }
        $(".preloader").show();
        var CEXTN_cardcount=0;
        var CEXTN_chkunitdateflag=0;
        var CEXTN_chkcardlen=0;
        var CEXTN_chkfuturedate=0;
        var CEXTN_finalCard=[];
        var CEXTN_errmsgs=[];
        var CEXTN_diffunitlen=0;
        var CEXTN_allCustExtndts=[];
        var calentime=[];
        var CEXTN_currentcheckoutdate="";
        var CEXTN_initial_unitsdate="";
        var CEXTN_initial_unitedate="";
        //JQUERY VALIDATION
        $('#CEXTN_tb_emailid').doValidation({rule:'general',prop:{uppercase:false,autosize:true}});
        $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
        $("#CEXTN_tb_passno").doValidation({rule:'general',prop:{autosize:true}});
        $("#CEXTN_tb_epno").doValidation({rule:'general',prop:{autosize:true}});
        $("#CEXTN_tb_comppostcode").doValidation({rule:'numbersonly',prop:{realpart:6,leadzero:true}});
        $(".numonly").doValidation({rule:'numbersonly',prop:{realpart:5}});
        $(".3digitdollaronly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        $("#CEXTN_tb_diffamtprocost").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
        $(".5digitdollaronly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $("#CEXTN_tb_officeno").doValidation({rule:'numbersonly',prop:{realpart:8}});
        $("#CEXTN_tb_noticeperiod").doValidation({rule:'numbersonly',prop:{realpart:1}});
        $("#CEXTN_tb_mobileno").doValidation({rule:'numbersonly',prop:{realpart:8}});
        $("#CEXTN_tb_intmobileno").doValidation({rule:'numbersonly',prop:{realpart:20,leadzero:true}});
        //DATE PICKER FOR CHECK IN DATE ,DOB,PASSPORT DATE,NOTICE DATE,EP DATE
        ////SET CHECK OUT DATEPICKER
        $('#CEXTN_db_chkoutdate').datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        //SET NOTICE PERIOD DATE DATEPICKER
        $('#CEXTN_db_noticeperioddate').datepicker({
            dateFormat: "dd-mm-yy" ,
            changeYear: true,
            changeMonth: true
        });
        var CEXTN_d = new Date();
        var CEXTN_year = CEXTN_d.getFullYear() - 18;
        CEXTN_d.setFullYear(CEXTN_year);
        //SET DOB DATEPICKER
        $('#CEXTN_db_dob').datepicker({
            dateFormat: 'dd-mm-yy',
            changeYear: true,
            changeMonth: true,
            yearRange: '1920:' + CEXTN_year + '',
            defaultDate: CEXTN_d
        });
        //SET EP N PASSPORT MIN N MAX DATE
        var CEXTN_date = new Date();
        CEXTN_date.setDate( CEXTN_date.getDate() + 1 );
        var CEXTN_newDate = CEXTN_date.toDateString();
        CEXTN_newDate = new Date( Date.parse(CEXTN_newDate ) );
        $('#CEXTN_db_passdate').datepicker({
            dateFormat: "dd-mm-yy" ,
            changeYear: true,
            changeMonth: true
        });
        var passepnewCEXTN_d = new Date();
        var CEXTN_passyear = passepnewCEXTN_d.getFullYear()+10;
        var pass_changedmonth=new Date(passepnewCEXTN_d.setFullYear(CEXTN_passyear));
        $('#CEXTN_db_passdate').datepicker("option","minDate",CEXTN_newDate);
        $('#CEXTN_db_passdate').datepicker("option","maxDate",pass_changedmonth);
        var CEXTN_epyear = new Date().getFullYear()+3;
        var ep_changedmonth=new Date(passepnewCEXTN_d.setFullYear(CEXTN_epyear));
        $('#CEXTN_db_epdate').datepicker({
            dateFormat: "dd-mm-yy" ,
            changeYear: true,
            changeMonth: true
        });
        $('#CEXTN_db_epdate').datepicker("option","minDate",CEXTN_newDate);
        $('#CEXTN_db_epdate').datepicker("option","maxDate",ep_changedmonth);
        //FUNCTION TO UNIQUE ARRAY VALUES
        function unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
        //FUNCTION TO CALENDER END TIME
        function CEXTN_startendtimevalues(endtime){
            var timearray=[];
            for(var i=0;i<calentime.length;i++){
                if(endtime==calentime[i].TIME){
                    var endtime_status=i;
                    break;
                }
            }
            if(endtime=="23:30"){
                timearray.push("23:59");
            }
            else if(endtime=="23:00"){
                timearray.push("23:30");
                timearray.push("23:59");
            }
            else{
                var length=endtime_status+2;
                for(var j=endtime_status+1;j<=length;j++){
                    timearray.push(calentime[j].TIME);
                }
            }
            return timearray;
        }
        //CALL FUNCTION TO GET UNIT NOS,ERROR MSGS,PRORATED N WAIVED VALUE
        $.ajax({
            type: "POST",
            url: controller_url+"CEXTN_getCommonvalues",
            data:{"Formname":'EXTENSION',"ErrorList":'1,2,33,34,35,36,76,77,97,282,331,332,339,342,343,344,345,346,347,348,386,400,443,444,447,458,459,460,461'},
            success: function(data){
                var value_array=JSON.parse(data);
                CEXTN_getCommonvalues_result(value_array);
                $(".preloader").hide();
            },
            error: function(data){
                show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);
            }
        });
        function CEXTN_getCommonvalues_result(value_array) {
            var emailid = [];
            var prowaived = [];
            var unitno = [];
            var nationality=[];
            calentime = [];
            var CEXTN_allCustExtnUnitno = [];
            CEXTN_allCustExtnUnitno = value_array[0];//get all extn details
            nationality=value_array[1];
            emailid = value_array[2];
            prowaived = value_array[6];
            CEXTN_errmsgs = value_array[4];
            calentime = value_array[5];
            for (var k = 0; k < CEXTN_allCustExtnUnitno.length; k++) {
                unitno.push(CEXTN_allCustExtnUnitno[k])
            }
            unitno = unique(unitno);
            unitno.sort(function (a, b) {
                return a - b
            });
            if (unitno.length == 0 || emailid.length == 0) {
                $('#CEXTN_form').hide()
                if (unitno.length == 0) {
                    $('#CEXTN_div_allerrmsg').append('<p><label class="errormsg">' + CEXTN_errmsgs[6].EMC_DATA + '</label></p>');
                }
                else {
                    if (emailid.length == 0) {
                        $('#CEXTN_div_allerrmsg').append('<p><label class="errormsg"> ' + CEXTN_errmsgs[9].EMC_DATA.replace('[PROFILE]', "CUSTOMER EXTENSION") + '</label></p>');
                    }
                }
            }
            else {
                $('#CEXTN_div_allerrmsg').text("");
                //GET UNIT NOS
                var CEXTN_unitnosres = '<option>SELECT</option>';
                for (var i = 0; i < unitno.length; i++) {
                    CEXTN_unitnosres += '<option value="' + unitno[i] + '">' + unitno[i] + '</option>';
                }
                $('#CEXTN_lb_unitno').html(CEXTN_unitnosres);
                var nationality_list='';
                for(var i=0;i<nationality.length;i++){
                    nationality_list+='<option value="' + nationality[i].NC_DATA + '">' + nationality[i].NC_DATA + '</option>';
                }
                $('#CEXTN_tb_nation').append(nationality_list);
                $('#CEXTN_form').show();
                //PLACE PRORATED WAIVED VALUE
                $('#CEXTN_lbl_sameamtprorated').text(prowaived[0].CCN_DATA)
                $('#CEXTN_lbl_sameamtwaived').text(prowaived[1].CCN_DATA)
                $('#CEXTN_lbl_diffamtprorated').text(prowaived[0].CCN_DATA)
                $('#CEXTN_lbl_diffamtwaived').text(prowaived[1].CCN_DATA)
                //PLACE EMAIL ID IN THE LISTBOX
                var CEXTN_mailidres = '<option>SELECT</option>';
                for (var i = 0; i < emailid.length; i++) {
                    CEXTN_mailidres += '<option value="' + emailid[i] + '">' + emailid[i] + '</option>';
                }
                $('#CEXTN_lb_emailid').html(CEXTN_mailidres);
                //PLACE ERROR MESSAGES
                $('#CEXTN_div_diffunitnocarderrmsg').text(CEXTN_errmsgs[3].EMC_DATA)
                $('#CEXTN_div_custerrmsg').hide();
                //PLACE CALENDAR TIME IN LISTBOX
                var CEXTN_calentimeres = '<option>SELECT</option>';
                for (var i = 0; i < calentime.length; i++) {
                    CEXTN_calentimeres += '<option value="' + calentime[i].TIME + '">' + calentime[i].TIME + '</option>';
                }
                $('#CEXTN_lb_chkoutfromtime').html(CEXTN_calentimeres);
                $('#CEXTN_lb_chkinfromtime').html(CEXTN_calentimeres);
            }
        }
        //GET CUSTOMER NAME FOR THE SELECTED UNIT
        $('#CEXTN_lb_unitno').change(function(){
            $('#CEXTN_div_nocusterr').text("");
            $('#CEXTN_fileupload').val('');
            var CEXTN_lb_unitno=$('#CEXTN_lb_unitno').val();
            var CEXTN_div_custid=$('#CEXTN_div_custid').hide();
            var CEXTN_div_seconform=$('#CEXTN_div_seconform').hide();
            var CEXTN_lbl_custname=$('#CEXTN_lbl_custname').hide();
            var CEXTN_lb_custname=$('#CEXTN_lb_custname').hide();
            if(CEXTN_lb_unitno!='SELECT'){
                var  newPos= adjustPosition($(this).position(),100,150);
                resetPreloader(newPos);
                $(".preloader").show();
                //CALL FUNCTION TO GET UNIT NOS,ERROR MSGS,PRORATED N WAIVED VALUE
                $.ajax({
                    type: "POST",
                    url: controller_url+"CEXTN_getCustomerNameId_result",
                    data:{"unitno":CEXTN_lb_unitno},
                    success: function(data){
                        var value_array=JSON.parse(data);
                        CEXTN_allCustExtndts=value_array;
                        var CEXTN_namearray=[];
                        for(var k=0;k<CEXTN_allCustExtndts[1].length;k++){
                            CEXTN_namearray.push(CEXTN_allCustExtndts[1][k]);
                        }
                        CEXTN_namearray=unique(CEXTN_namearray)
                        CEXTN_namearray.sort();
                        var CEXTN_nameres='<option>SELECT</option>';
                        for(var i=0;i<CEXTN_namearray.length;i++){
                            var CEXTN_custname=CEXTN_namearray[i].split("_");
                            CEXTN_nameres += '<option value="' + CEXTN_namearray[i] + '">' + CEXTN_custname[0]+" "+CEXTN_custname[1] + '</option>';
                        }
                        $('#CEXTN_lb_custname').html(CEXTN_nameres);
                        var CEXTN_div_custid=$('#CEXTN_div_custid').hide();
                        var CEXTN_div_seconform=$('#CEXTN_div_seconform').hide();
                        var CEXTN_lbl_custname=$('#CEXTN_lbl_custname').show();
                        var CEXTN_lb_custname=$('#CEXTN_lb_custname').show();
                        $(".preloader").hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error: function(data){
                        show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);
                    }
                });
            }
            else{
                $(".preloader").hide();
            }
        });
        //GET CUSTOMER ID FOR THE SELECTED CUSTOMER NAME
        $('#CEXTN_lb_custname').change(function(){
            $('#CEXTN_div_nocusterr').text("");
            CEXTN_setselectIndex();
            $('#CEXTN_fileupload').val('');
            $('#CEXTN_div_custid').hide();
            $('#CEXTN_div_sameunitdiffroomerr').text("");
            $('#CEXTN_div_seconform').hide();
            var CEXTN_lb_custname=$('#CEXTN_lb_custname').val();
            var CEXTN_lb_unitno=$('#CEXTN_lb_unitno').val();
            var CEXTN_custname=CEXTN_lb_custname.split("_");
            var CEXTN_name_id_array=[];
            for(var k=0;k<CEXTN_allCustExtndts[1].length;k++){
                if(CEXTN_allCustExtndts[1][k]==CEXTN_lb_custname){
                    CEXTN_name_id_array.push(CEXTN_allCustExtndts[0][k]);
                }
            }
            CEXTN_name_id_array=unique(CEXTN_name_id_array);
            CEXTN_name_id_array.sort(function(a,b){return a-b});
            if(CEXTN_lb_custname!='SELECT'){
                $(".preloader").show();
                if(CEXTN_name_id_array.length==0){
                    $('#CEXTN_div_nocusterr').text(CEXTN_errmsgs[8].EMC_DATA.replace('[CNAME]',$('#CEXTN_lb_custname').val().split("_")[0]+" "+$('#CEXTN_lb_custname').val().split("_")[1]));
                }
                else{
                    if(CEXTN_name_id_array.length==1){
                        $('#CEXTN_hidden_custid').val(CEXTN_name_id_array[0]);
                        $.ajax({
                            type: "POST",
                            url: controller_url+"CEXTN_getCustomerdtls_result",
                            data:{"unitno":CEXTN_lb_unitno,"customerId":CEXTN_name_id_array[0]},
                            success: function(data){
                                $(".preloader").hide();
                                var value_array=JSON.parse(data);
                                CEXTN_getCustomerdtls_result(value_array)
                                $("html, body").animate({ scrollTop:1800 }, "slow");
                            },
                            error: function(data){
                                show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);

                            }
                        });
                        $('#CEXTN_div_custid').hide();
                    }
                }
            }
        });
        //AMOUNT RADIO BUTTON VALIDATION
        $("input[name='CEXTN_radio_amt']").on("change", function () {
            if(this.value=="CEXTN_radio_sameamt"){
                $('#CEXTN_div_sameamt').show();
                $('#CEXTN_div_diffamt').hide();
                $("#CEXTN_tb_diffamtdep").val("");
                $("#CEXTN_tb_diffamtrent").val("");
                $("#CEXTN_tb_diffamtprocost").val("");
            }
            if(this.value=="CEXTN_radio_diffamt"){
                $('#CEXTN_div_diffamt').show();
                $('#CEXTN_tb_diffamtdep').val('')
                $('#CEXTN_tb_diffamtrent').val('')
                $('#CEXTN_tb_diffamtprocost').val('')
                $('#CEXTN_div_sameamt').hide();
            }
        });
        //UNIT RADIO BUTTON VALIDATION
        $("input[name='CEXTN_radio_unit']").on("change", function () {
            var  newPos= adjustPosition($(this).position(),100,150);
            resetPreloader(newPos);
            $(".preloader").show();
            $('#CEXTN_div_custerrmsg').hide();
            var CEXTN_rmtype=$('#CEXTN_tb_sameunitsamermrmtype').val();
            var CEXTN_lb_unitno=$('#CEXTN_lb_unitno').val();
            var CEXTN_radio_unit =$("input[name='CEXTN_radio_unit']:checked").val()
            if(this.value=="CEXTN_radio_sameunit"){
                CEXTN_SetMinMaxCheckoutDate(CEXTN_initial_unitsdate,CEXTN_initial_unitedate,CEXTN_currentcheckoutdate)//set check out min n max date
                $('#CEXTN_div_nodiffuniterr').hide();
                $("#CEXTN_lbl_chkindate").text("CURRENT CHECK OUT DATE");
                $("#CEXTN_lb_chkinfromtime").val("SELECT").hide();
                $("#CEXTN_lb_chkintotime").hide();
                $("#CEXTN_lbl_chkinto").hide();
                $('#CEXTN_lb_diffunituno').val("SELECT");
                $("#CEXTN_lb_sameunitdiffrmrmtype").val("SELECT");
                $('#CEXTN_div_sameunitdiffrm').hide();
                $('#CEXTN_lb_diffunitrmtype').val("SELECT");
                $('#CEXTN_div_diffunit').hide();
                $('#CEXTN_div_sameunitsamerm').show();
                $('#CEXTN_div_sameunitdiffroomerr').text("");
                $(".preloader").hide();
            }
            if(this.value=="CEXTN_radio_diffunit"){
                CEXTN_cardcount=0;
                if(CEXTN_diffunitlen==0){
                    $('#CEXTN_div_diffunit').hide();
                    $('#CEXTN_div_nodiffuniterr').text(CEXTN_errmsgs[20].EMC_DATA).show();
                }
                else {
                    $('#CEXTN_div_nodiffuniterr').hide();
                    $('#CEXTN_div_diffunit').show();
                }
                $("#CEXTN_lbl_chkindate").text("CURRENT CHECK IN DATE");
                $("#CEXTN_lb_sameunitdiffrmrmtype").val("SELECT");
                $("#CEXTN_hidden_setrmtype").val(this.value);
                $('#CEXTN_lb_diffunituno').val("SELECT");
                $('#CEXTN_lbl_diffunitselectcard').hide();
                $('#CEXTN_radio_difunitcardno').hide();
                $('#CEXTN_lbl_diffunitcard').hide();
                $('#CEXTN_radio_difunitnullcard').hide();
                $('#CEXTN_lbl_diffunitnull').hide();
                $('#CEXTN_div_normtypeerr').text("");
                $('#CEXTN_lbl_diffunitrmtype').hide();
                $('#CEXTN_lb_diffunitrmtype').val("SELECT").hide();
                $('#CEXTN_div_normtypeerr').text("");
                $('#CEXTN_div_sameunitsamerm').hide();
                $('#CEXTN_div_sameunitdiffrm').hide();
                $('#CEXTN_div_diffunitcardlist').hide();
                $('#CEXTN_div_sameunitdiffroomerr').text("");
                $(".preloader").hide();
            }
            if(this.value=="CEXTN_radio_sameunitdiffroom"){
                $('#CEXTN_div_nodiffuniterr').hide();
                $('#CTERM_tbl_sameunitdiffrmcust_card').show();
                $("#CEXTN_lbl_chkindate").text("CURRENT CHECK IN DATE");
                $('#CEXTN_div_sameunitsamerm').hide();
                $('#CEXTN_div_sameunitdiffrm').hide();
                $('#CEXTN_div_diffunit').hide();
                $("#CEXTN_lb_sameunitdiffrmrmtype").val("SELECT");
                $('#CEXTN_lb_diffunituno').val("SELECT");
                $('#CEXTN_lb_diffunitrmtype').val("SELECT");
                $("#CEXTN_hidden_setrmtype").val(this.value);
                $.ajax({
                    type: "POST",
                    url: controller_url+"CEXTN_getRoomType",
                    data:{"unitno":CEXTN_lb_unitno,"rmtype":CEXTN_rmtype},
                    success:function(data){
                        $('.preloader').hide();
                        var CEXTN_rmtype=JSON.parse(data);
                        CEXTN_getRoomType_result(CEXTN_rmtype);
                    },
                    error:function(data){
                        show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);
                    }
                });
            }
            if(CEXTN_radio_unit!="CEXTN_radio_sameunit"){
                $("#CEXTN_lb_chkinfromtime").show();
            }
        });
        //FUNCTION TO GET ROOM TYPE RESULT FOR SAME UNIT
        function CEXTN_getRoomType_result(CEXTN_rmtype){
            var CEXTN_lb_unitno=$('#CEXTN_lb_unitno').val();
            var CEXTN_lb_diffunituno=$("#CEXTN_lb_diffunituno").val();
            var CEXTN_normtypeerr=CEXTN_errmsgs[2].EMC_DATA;
            var CEXTN_roomtype=CEXTN_rmtype.roomtype;
            var CEXTNunitsdate=CEXTN_rmtype.unitsdate
            var CEXTNunitedate=CEXTN_rmtype.unitedate
            CEXTN_SetMinMaxCheckoutDate(CEXTNunitsdate,CEXTNunitedate,CEXTN_currentcheckoutdate)//set check out min n max date
            var CEXTN_unittype=$("#CEXTN_hidden_setrmtype").val();
            if(CEXTN_roomtype.length>0){
                $('#CEXTN_div_sameunitdiffroomerr').text("");
                if(CEXTN_unittype=="CEXTN_radio_sameunitdiffroom"){
                    var CEXTN_rmtyperes='<option>SELECT</option>';
                    for(var i=0;i<CEXTN_roomtype.length;i++){
                        CEXTN_rmtyperes += '<option value="' + CEXTN_roomtype[i] + '">' + CEXTN_roomtype[i] + '</option>';
                    }
                    $('#CEXTN_lb_sameunitdiffrmrmtype').html(CEXTN_rmtyperes);
                    $('#CEXTN_div_sameunitsamerm').hide();
                    $('#CEXTN_div_diffunit').hide();
                    $('#CEXTN_div_sameunitdiffrm').show();
                }
                else{
                    var CEXTN_rmtyperes='<option>SELECT</option>';
                    for(var i=0;i<CEXTN_roomtype.length;i++){
                        CEXTN_rmtyperes += '<option value="' + CEXTN_roomtype[i] + '">' + CEXTN_roomtype[i] + '</option>';
                    }
                    $('#CEXTN_lb_diffunitrmtype').html(CEXTN_rmtyperes).show();
                    $('#CEXTN_lbl_diffunitrmtype').show();
                    $('#CEXTN_lb_diffunitrmtype').show();
                    $('#CEXTN_lbl_diffunitselectcard').hide();
                    $('#CEXTN_radio_difunitcardno').show();
                    $('#CEXTN_lbl_diffunitcard').show();
                    $('#CEXTN_radio_difunitnullcard').show();
                    $('#CEXTN_lbl_diffunitnull').show();
                    $('#CEXTN_div_normtypeerr').text("");
                }
            }
            else{
                if(CEXTN_unittype=="CEXTN_radio_sameunitdiffroom"){
                    var CEXTN_div_normtypeerr=CEXTN_normtypeerr.replace('[UNIT NO]',CEXTN_lb_unitno)
                    $('#CEXTN_div_sameunitdiffroomerr').text(CEXTN_div_normtypeerr);
                }
                else{
                    $('#CEXTN_lb_diffunitrmtype').hide();
                    $('#CEXTN_lbl_diffunitrmtype').hide();
                    $('#CEXTN_lb_diffunitrmtype').hide();
                    $('#CEXTN_lbl_diffunitselectcard').hide();
                    $('#CEXTN_radio_difunitcardno').hide();
                    $('#CEXTN_lbl_diffunitcard').hide();
                    $('#CEXTN_radio_difunitnullcard').hide();
                    $('#CEXTN_lbl_diffunitnull').hide();
                    var CEXTN_div_normtypeerr=CEXTN_normtypeerr.replace('[UNIT NO]',CEXTN_lb_diffunituno)
                    $('#CEXTN_div_normtypeerr').text(CEXTN_div_normtypeerr).show();
                }
            }
            $(".preloader").hide();
        }
        //AIRCON AMT RADIO BUTTON VALIDATION
        $("input[name='CEXTN_radio_airconfee']").on("change", function (){
            if(this.value=="CEXTN_radio_quartairconfee"){
                $('#CEXTN_tb_airquarterfee').val("").show();
                $('#CEXTN_tb_fixedairfee').hide();
            }
            if(this.value=="CEXTN_radio_fixedairconfee"){
                $('#CEXTN_tb_airquarterfee').hide();
                $('#CEXTN_tb_fixedairfee').val("").show();
            }
        });
        //ADD ROOM TYPE FOR DIFF UNIT
        $('#CEXTN_lb_diffunituno').change(function(){
            $('#CEXTN_div_custerrmsg').hide();
            $('#CEXTN_div_diffunitnocarderrmsg').hide();
            $('#CEXTN_lb_diffunitrmtype').val("SELECT");
            $('#CEXTN_radio_difunitcardno').prop('checked',false);
            $('#CEXTN_radio_difunitnullcard').prop('checked',false);
            $('#CEXTN_div_diffunitcardlist').hide();
            $('#CEXTN_lbl_diffunitrmtype').hide();
            $('#CEXTN_lb_diffunitrmtype').hide();
            $('#CEXTN_lbl_diffunitselectcard').hide();
            $('#CEXTN_radio_difunitcardno').hide();
            $('#CEXTN_lbl_diffunitcard').hide();
            $('#CEXTN_radio_difunitnullcard').hide();
            $('#CEXTN_lbl_diffunitnull').hide();
            var CEXTN_lb_unitno=$('#CEXTN_lb_diffunituno').val();
            var CEXTN_rmtype="";
            if(CEXTN_lb_unitno!="SELECT"){
                var  newPos= adjustPosition($(this).position(),100,80);
                resetPreloader(newPos);
                $(".preloader").show();
                //ADD DIFF UNIT ROOM TYPE
                $.ajax({
                    type: "POST",
                    url: controller_url+"CEXTN_getRoomType",
                    data:{"unitno":CEXTN_lb_unitno,"rmtype":CEXTN_rmtype},
                    success:function(data){
                        $(".preloader").hide();
                        var CEXTN_rmtype=JSON.parse(data);
                        CEXTN_getRoomType_result(CEXTN_rmtype);
                    },
                    error:function(data){
                        show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);
                    }
                });
            }
        });
        $("input[name='CEXTN_radio_difunitcard']").on("change", function () {
            var  newPos= adjustPosition($(this).position(),100,60);
            resetPreloader(newPos);
            $(".preloader").show();
            var CEXTN_tb_firstname=$('#CEXTN_tb_firstname').val();
            var CEXTN_tb_lastname=$('#CEXTN_tb_lastname').val();
            var CEXTN_lb_unitno=$('#CEXTN_lb_diffunituno').val();
            $('#CEXTN_div_custerrmsg').hide();
            $('#CEXTN_div_diffunitnocarderrmsg').hide();
            $('#CEXTN_div_diffunitcardlist').hide();
            if(this.value=="CEXTN_radio_difunitcardno"){
                $.ajax({
                    type: "POST",
                    url: controller_url+"CEXTN_getdiffunitCardNo",
                    data:{"unitno":CEXTN_lb_unitno,"CEXTN_tb_firstname":CEXTN_tb_firstname,"CEXTN_tb_lastname":CEXTN_tb_lastname},
                    success:function(data){
                        var CEXTN_diffunitcard=JSON.parse(data);
                        CEXTN_getdiffunitCardNo_result(CEXTN_diffunitcard);
                    },
                    error:function(data){
                        show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);
                    }
                });
            }
            else{
                $('#CEXTN_div_diffunitcardlist').hide();
                $(".preloader").hide();
            }
        });
        //ADD CARD NOS IN THE FORM
        function CEXTN_getdiffunitCardNo_result(CEXTN_diffunitcard){
            CEXTN_finalCard=CEXTN_diffunitcard[1];
            $('#CEXTN_tble_diffunitcardlist > div').remove();
            $('#CEXTN_div_diffunitnocarderrmsg').hide();
            CEXTN_chkcardlen=CEXTN_diffunitcard[0].length;
            if(CEXTN_diffunitcard[0].length>0){
                for(var i=0;i<CEXTN_diffunitcard[0].length;i++){
                    var CEXTN_cardnovalue=CEXTN_diffunitcard[0][i];
                    var CEXTN_lb_diffunitcardid="CEXTN_lb_diffunitcard"+i;
                    var CEXTN_cb_diffunitcardid="CEXTN_cb_diffunitcard"+i;
                    var CEXTN_tb_diffunitcard="CEXTN_tb_diffunitcard"+i;
                    var CEXTN_cardresult ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type=checkbox class="CEXTN_class_diffunitcard CEXTN_btn_validate_class" name="CEXTN_cb_diffunitcard[]" id='+i+' value='+CEXTN_cardnovalue+'>' + CEXTN_cardnovalue + '</label></div></div><div class="col-md-5"><select name="CEXTN_lb_diffunitcard" id='+CEXTN_lb_diffunitcardid+' class="CEXTN_class_diffunitcard CEXTN_btn_validate_class form-control"  style="display: none;"></select></div><input type="hidden"  name="CEXTN_tb_diffunitcard" id='+CEXTN_tb_diffunitcard+'/></div>';
                    $('#CEXTN_tble_diffunitcardlist').append(CEXTN_cardresult);
                    var CEXTN_cardnolbl='<option>SELECT</option>';
                    for(var j=0;j<CEXTN_diffunitcard.length;j++){
                        var CEXTN_cardnolabel=CEXTN_diffunitcard[1][j];
                        CEXTN_cardnolbl += '<option value="' + CEXTN_cardnolabel + '">' + CEXTN_cardnolabel + '</option>';
                    }
                    $('#CEXTN_lb_diffunitcard'+i).html(CEXTN_cardnolbl);
                }
                $('#CEXTN_div_diffunitcardlist').show();
            }
            else{
                $('#CEXTN_div_diffunitnocarderrmsg').show();
                $('#CEXTN_div_custerrmsg').hide();
            }
            $(".preloader").hide();
        }
        //FUNCTION TO COMPARE TWO ARRAYS
        function CEXTN_card_diffArray(a, b) {
            var seen = [], diff = [];
            for ( var i = 0; i < b.length; i++)
                seen[b[i]] = true;
            for ( var i = 0; i < a.length; i++)
                if (!seen[a[i]])
                    diff.push(a[i]);
            return diff;
        }
        //FUNCTION TO CALL DATE PICKER FORMAT
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        //FUNCTION TO CALL PRORATED CHKING FUNCTION AND VALIDATING WAIVED CHKBOX
        $(".CEXTN_class_prowaiv").change(function(){
            //VALIDATING WAIVED CHKBOX

            var CEXTN_tb_diffamtprocost=$("#CEXTN_tb_diffamtprocost").val();
            var CEXTN_tb_diffamtrent=$("#CEXTN_tb_diffamtrent").val();
            var CEXTN_radio_amt =$("input[name='CEXTN_radio_amt']:checked").val()
            if(CEXTN_tb_diffamtprocost!=""){
                $("#CEXTN_cb_diffamtwaived").removeAttr('disabled');
            }
            else{
                $("#CEXTN_cb_diffamtwaived").prop('checked',false).attr('disabled','disabled');
            }
            //PRORATED CHK
            var CEXTN_db_chkindate=$("#CEXTN_db_chkindate").val();
            var CEXTN_db_chkoutdate=$("#CEXTN_db_chkoutdate").val()
            if(CEXTN_radio_amt=="CEXTN_radio_sameamt"){
                if(CEXTN_db_chkoutdate!=""){
                    $('.preloader').show();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"CEXTN_chkProrated",
                        data:{"CEXTN_db_chkindate":CEXTN_db_chkindate,"CEXTN_db_chkoutdate":CEXTN_db_chkoutdate},
                        success:function(data){
                            $('.preloader').hide();
                            var CEXTN_rmtype=JSON.parse(data);
                            CEXTN_chkProrated_result(CEXTN_rmtype);
                        },
                        error:function(data){
                            show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);
                        }
                    });
                }
            }
            else{
                if(CEXTN_db_chkoutdate!=""&&CEXTN_tb_diffamtrent!=""){
                    $('.preloader').show();
                    $.ajax({
                        type: "POST",
                        url: controller_url+"CEXTN_chkProrated",
                        data:{"CEXTN_db_chkindate":CEXTN_db_chkindate,"CEXTN_db_chkoutdate":CEXTN_db_chkoutdate},
                        success:function(data){
                            $('.preloader').hide();
                            var CEXTN_rmtype=JSON.parse(data);
                            CEXTN_chkProrated_result(CEXTN_rmtype);
                        },
                        error:function(data){
                            show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);
                        }
                    });
                }
            }
            if(CEXTN_tb_diffamtrent==""||CEXTN_radio_amt=="CEXTN_radio_sameamt"){
                $("#CEXTN_cb_diffamtprorated").attr("disabled","disabled").prop('checked',false);
            }
            $('#CEXTN_db_noticeperioddate').removeAttr("disabled");
            //SET NOTICE PERIOD DATE
            $('#CEXTN_db_noticeperioddate').datepicker({
                dateFormat: "dd-mm-yy" ,
                changeYear: true,
                changeMonth: true
            });
            var CEXTN_db_noticeperioddate=$("#CEXTN_db_noticeperioddate").val()
            var CEXTN_date1 = $('#CEXTN_db_chkindate').val();
            var CEXTN_db_prevchkindate=$('#CEXTN_db_prevchkindate').val();
            if((CEXTN_db_chkoutdate!=""))
            {
                var CEXTN_db_chkindate1 = new Date( Date.parse( FormTableDateFormat(CEXTN_db_chkindate)) );
                CEXTN_db_chkindate1.setDate( CEXTN_db_chkindate1.getDate() + 1 );
                var CEXTN_db_chkindate1 = CEXTN_db_chkindate1.toDateString();
                CEXTN_db_chkindate1 = new Date( Date.parse( CEXTN_db_chkindate1 ) );
                if(new Date(CEXTN_db_chkindate1)<new Date())
                {
                    var CEXTN_date = new Date();
                    CEXTN_date.setDate( CEXTN_date.getDate() + 1 );
                    var CEXTN_newDate = CEXTN_date.toDateString();
                    CEXTN_newDate = new Date( Date.parse(CEXTN_newDate ) );
                    $('#CEXTN_db_noticeperioddate').datepicker("option","minDate",CEXTN_newDate);
                }
                else
                {
                    $('#CEXTN_db_noticeperioddate').datepicker("option","minDate",CEXTN_db_chkindate1);
                }
                var CEXTN_db_chkoutdate1 = new Date( Date.parse(FormTableDateFormat(CEXTN_db_chkoutdate)) );
                CEXTN_db_chkoutdate1.setDate( CEXTN_db_chkoutdate1.getDate()-1);
                var CEXTN_db_chkoutdate1 = CEXTN_db_chkoutdate1.toDateString();
                CEXTN_db_chkoutdate1 = new Date( Date.parse( CEXTN_db_chkoutdate1 ) );
                var CEXTN_chkoutdate=CEXTN_db_chkoutdate1.getDate()
                var CEXTN_chkoutmonth=CEXTN_db_chkoutdate1.getMonth()+1
                var CEXTN_chkoutyear=CEXTN_db_chkoutdate1.getFullYear()
                var CEXTN_finnoticedate=CEXTN_chkoutyear+"-"+CEXTN_chkoutmonth+"-"+CEXTN_chkoutdate;
                CEXTN_finnoticedate = new Date( Date.parse( CEXTN_finnoticedate ) );
                $('#CEXTN_db_noticeperioddate').datepicker("option","maxDate",CEXTN_db_chkoutdate1);
                if(new Date(CEXTN_finnoticedate).setHours(0,0,0,0)<=new Date(FormTableDateFormat(CEXTN_db_chkindate)).setHours(0,0,0,0))
                {
                    $('#CEXTN_db_noticeperioddate').val("");
                    $('#CEXTN_db_noticeperioddate').attr("disabled","disabled");
                }
                if(new Date(CEXTN_finnoticedate).setHours(0,0,0,0)<=new Date().setHours(0,0,0,0))
                {
                    $('#CEXTN_db_noticeperioddate').val("");
                    $('#CEXTN_db_noticeperioddate').attr("disabled","disabled");
                }
            }
            var CEXTN_db_chkoutdate=$("#CEXTN_db_chkoutdate").val();
        });
        //FUNCTION TO ENABLE PROCESSING COST CHECK BOX USING THE RETURN RESULT
        function CEXTN_chkProrated_result(CEXTN_chkproflag){
            var CEXTN_radio_amt =$("input[name='CEXTN_radio_amt']:checked").val()
            if(CEXTN_chkproflag=='true'){
                if(CEXTN_radio_amt!="CEXTN_radio_sameamt")
                {
                    $("#CEXTN_cb_diffamtprorated").removeAttr("disabled").prop('checked',true);
                }
                $("#CEXTN_cb_sameamtprorated").removeAttr("disabled").prop('checked',true);
            }
            else
            {
                if(CEXTN_radio_amt!="CEXTN_radio_sameamt")
                {
                    $("#CEXTN_cb_diffamtprorated").attr("disabled","disabled").prop('checked',true);
                }
                $("#CEXTN_cb_sameamtprorated").attr("disabled","disabled").prop('checked',true);
            }
            var chkedvalue="X";
            var sameproratedchk=$("#CEXTN_cb_sameamtprorated").prop("checked");
            var diffwaivedchk=$("#CEXTN_cb_diffamtwaived").prop("checked");
            var diffproratedchk=$("#CEXTN_cb_diffamtprorated").prop("checked");
            if (sameproratedchk==true)
            {
                $("#CEXTN_hidden_sameamtprorated").val(chkedvalue);
            }
            else
            {
                $("#CEXTN_hidden_sameamtprorated").val("");
            }
            if (diffproratedchk==true)
            {
                $("#CEXTN_hidden_diffamtprorated").val(chkedvalue);
            }
            else
            {
                $("#CEXTN_hidden_diffamtprorated").val("");
            }
        }
        function CEXTN_setproratedvalue()
        {
            var chkedvalue="X";
            var sameproratedchk=$("#CEXTN_cb_sameamtprorated").prop("checked");
            var diffwaivedchk=$("#CEXTN_cb_diffamtwaived").prop("checked");
            var diffproratedchk=$("#CEXTN_cb_diffamtprorated").prop("checked");
            if (sameproratedchk==true)
            {
                $("#CEXTN_hidden_sameamtprorated").val(chkedvalue);
            }
            else
            {
                $("#CEXTN_hidden_sameamtprorated").val("");
            }
            if (diffproratedchk==true)
            {
                $("#CEXTN_hidden_diffamtprorated").val(chkedvalue);
            }
            else
            {
                $("#CEXTN_hidden_diffamtprorated").val("");
            }
        }
        //FUNCTION TO GET TO TIME FOR CHECK IN DATE
        $("#CEXTN_lb_chkinfromtime").change(function(){
            $(".preloader").show();
            var CEXTN_lb_chkinfromtime=$("#CEXTN_lb_chkinfromtime").val();
            if(CEXTN_lb_chkinfromtime!="SELECT"){
                var CEXTN_totimelb=''
                var totime=CEXTN_startendtimevalues(CEXTN_lb_chkinfromtime)
                for(var j=0;j<totime.length;j++){
                    CEXTN_totimelb += '<option value="' + totime[j] + '">' + totime[j]+ '</option>';
                }
                $("#CEXTN_lbl_chkinto").show();
                $('#CEXTN_lb_chkintotime').html(CEXTN_totimelb).show();
                $(".preloader").hide();
            }
            else{
                $(".preloader").hide();
                $('#CEXTN_lb_chkintotime').hide();
                $("#CEXTN_lbl_chkinto").hide();
            }
        });
        //FUNCTION TO GET TO TIME FOR CHECK OUT DATE
        $("#CEXTN_lb_chkoutfromtime").change(function(){
            $(".preloader").show();
            var CEXTN_totimelb="";
            var CEXTN_lb_chkoutfromtime=$("#CEXTN_lb_chkoutfromtime").val();
            if(CEXTN_lb_chkoutfromtime!="SELECT"){
                var totime=CEXTN_startendtimevalues(CEXTN_lb_chkoutfromtime)
                for(var j=0;j<totime.length;j++){
                    CEXTN_totimelb += '<option value="' + totime[j] + '">' + totime[j]+ '</option>';
                }
                $('#CEXTN_lbl_chkoutto').show();
                $('#CEXTN_lb_chkouttotime').html(CEXTN_totimelb).show();
                $(".preloader").hide();
            }
            else{
                $(".preloader").hide();
                $('#CEXTN_lb_chkouttotime').hide();
                $('#CEXTN_lbl_chkoutto').hide();
            }
        });
        //FUNCTION TO VALIDATE FORM
        $(document).on("change blur",'#CEXTN_form', function (){
            var CEXTN_validinput=1;
            var CEXTN_validoutput=CEXTN_validateinputform(CEXTN_validinput);
            CEXTN_validatesubmitbtn(CEXTN_validoutput);
        });
        //FUNCTION TO VALIDATE INPUT FIELDS
        function CEXTN_validateinputform(CEXTN_validinput){
            var CEXTN_db_passdate=$('#CEXTN_db_passdate').val();
            var CEXTN_tb_passno=$('#CEXTN_tb_passno').val();
            var CEXTN_db_epdate=$('#CEXTN_db_epdate').val();
            var CEXTN_tb_epno=$('#CEXTN_tb_epno').val();
            var CEXTN_db_chkoutdate=$('#CEXTN_db_chkoutdate').val();
            var CEXTN_lb_diffunituno=$('#CEXTN_lb_diffunituno').val();
            var CEXTN_tb_emailid=$('#CEXTN_tb_emailid').val();
            var CEXTN_lb_sameunitdiffrmrmtype=$('#CEXTN_lb_sameunitdiffrmrmtype').val();
            var CEXTN_lb_chkoutfromtime=$("#CEXTN_lb_chkoutfromtime").val();
            var CEXTN_lb_chkouttotime=$('#CEXTN_lb_chkouttotime').val();
            var CEXTN_lb_chkinfromtime=$("#CEXTN_lb_chkinfromtime").val();
            var CEXTN_lb_chkintotime=$('#CEXTN_lb_chkintotime').val();
            var CEXTN_radio_amt =$("input[name='CEXTN_radio_amt']:checked").val()
            var CEXTN_radio_unit =$("input[name='CEXTN_radio_unit']:checked").val()
            var CEXTN_tb_diffamtrent=$("#CEXTN_tb_diffamtrent").val();
            var CEXTN_lb_diffunituno=$("#CEXTN_lb_diffunituno").val();
            var CEXTN_lb_diffunitrmtype=$("#CEXTN_lb_diffunitrmtype").val();
            var CEXTN_lb_emailid=$("#CEXTN_lb_emailid").val();
            var CEXTN_radio_difunitcard=$("input[name='CEXTN_radio_difunitcard']:checked").val();
            var CEXTN_chkdifunitcard=$("input:radio[name='CEXTN_radio_difunitcard']").is(":checked")
            var emailchk="";
            var atpos=CEXTN_tb_emailid.indexOf("@");
            var dotpos=CEXTN_tb_emailid.lastIndexOf(".");
            if(CEXTN_tb_emailid.length>0){
                if ((/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(CEXTN_tb_emailid) || "" == CEXTN_tb_emailid)
                    &&(atpos-1!=CEXTN_tb_emailid.indexOf("."))){
                    $('#CEXTN_tb_emailid').removeClass("invalid");
                    $("#CEXTN_lbl_emailerrmsg").text("");
                    $('#CEXTN_tb_emailid').val($('#CEXTN_tb_emailid').val().toLowerCase());
                    emailchk="valid";
                }
                else {
                    emailchk="invalid";
                    $("#CEXTN_lbl_emailerrmsg").text(CEXTN_errmsgs[5].EMC_DATA)
                    $('#CEXTN_tb_emailid').addClass("invalid")
                }
            }
            else{
                $('#CEXTN_tb_emailid').removeClass("invalid");
                $("#CEXTN_lbl_emailerrmsg").text("");
                emailchk="invalid";
            }
            //SHOW OR HIDE TIME BOX
            if($("#CEXTN_db_chkoutdate").val()!=""){
                if($("#CEXTN_db_passdate").val()!=""&&new Date(FormTableDateFormat($("#CEXTN_db_passdate").val())).setHours(0,0,0,0)<=new Date(FormTableDateFormat($("#CEXTN_db_chkoutdate").val())).setHours(0,0,0,0))
                {
                    $('#CEXTN_db_passdate').addClass("invalid")
                    $("#CEXTN_passdate_err").text(CEXTN_errmsgs[28].EMC_DATA)
                    CEXTN_validinput=0;
                }
                else
                {
                    $('#CEXTN_db_passdate').removeClass("invalid");
                    $("#CEXTN_passdate_err").text("");
                }
                if($("#CEXTN_db_epdate").val()!=""&&new Date(FormTableDateFormat($("#CEXTN_db_epdate").val())).setHours(0,0,0,0)<=new Date(FormTableDateFormat($("#CEXTN_db_chkoutdate").val())).setHours(0,0,0,0))
                {
                    $('#CEXTN_db_epdate').addClass("invalid")
                    $("#CEXTN_epdate_err").text(CEXTN_errmsgs[27].EMC_DATA)
                    CEXTN_validinput=0;
                }
                else
                {
                    $('#CEXTN_db_epdate').removeClass("invalid");
                    $("#CEXTN_epdate_err").text("");
                }
                $("#CEXTN_lb_chkoutfromtime").show();
            }
            else {
                $("#CEXTN_lb_chkoutfromtime").val("SELECT").hide();
                $("#CEXTN_lb_chkouttotime").hide();
                $('#CEXTN_lbl_chkoutto').hide();
            }
            if(CEXTN_radio_unit=="CEXTN_radio_diffunit"&&CEXTN_radio_difunitcard=="CEXTN_radio_difunitcardno"){
                $("#CEXTN_btn_save").attr("disabled","disabled");
                ////VALIDATION TO SHOW CARD FOR DIFFERENT UNIT OPTION N CODING  TO CHK CARD CHKBOX N LISTBOX
                var CEXTN_cardlist=[];
                var CEXTN_selectcardlist=[];
                for(var k=0;k<CEXTN_finalCard.length;k++){
                    var CEXTN_Cardnos=CEXTN_finalCard[k];
                    CEXTN_cardlist.push(CEXTN_Cardnos)
                }
                var cardnos = [];
                var cardid=[];
                var cardlblll=[];
                $('input:checkbox[name="CEXTN_cb_diffunitcard[]"]:checked').each(function() {
                    if ($(this).val()) {
                        cardnos.push($(this).val());
                        var id=$(this).attr("id")
                        var CEXTN_lb_diffunitcard= $('#CEXTN_lb_diffunitcard'+id).val();
                        if(CEXTN_lb_diffunitcard!="SELECT")
                        {
                            cardlblll.push(CEXTN_lb_diffunitcard)
                        }
                        cardid.push(id);
                    }
                });
                $('#CEXTN_slctcustlbl').val(cardlblll)
                var cardnos1 = [];
                var cardid1=[];
                $('input:checkbox[name="CEXTN_cb_diffunitcard[]"]:not(:checked)').each(function() {
                    cardnos1.push($(this).val());
                    var id=$(this).attr("id")
                    cardid1.push(id);
                    if(cardid.length>0)
                    {
                        $('#'+id).attr("disabled","disabled");
                    }
                });
                CEXTN_cardcount=0;
                var CEXTN_chkcustflag=0;
                var CEXTN_chkcard=0;
                for(var i=0;i<cardid.length;i++)
                {
                    var id=cardid[i];
                    var cardno=$('input[name="CEXTN_cb_diffunitcard[]"]:checked').val();
                    $('#CEXTN_lb_diffunitcard'+id)
                    var CEXTN_tb_firstname=$('#CEXTN_tb_firstname').val();
                    var CEXTN_tb_lastname=$('#CEXTN_tb_lastname').val();
                    var CEXTN_lb_diffunitcard= $('#CEXTN_lb_diffunitcard'+id).show().val();
                    CEXTN_chkcard=1;
                    if(CEXTN_lb_diffunitcard!="SELECT"){
                        $('#CEXTN_lb_diffunitcard'+id).attr("disabled","disabled");
                        CEXTN_cardcount++;
                        CEXTN_selectcardlist.push(CEXTN_lb_diffunitcard);
                        if(CEXTN_lb_diffunitcard==CEXTN_tb_firstname+" "+CEXTN_tb_lastname)
                        {
                            CEXTN_chkcustflag=1;
                        }
                        var cardlabl=CEXTN_lb_diffunitcard.replace(/ /g,"_");
                        $('#CEXTN_tb_diffunitcard'+id).val(cardlabl);
                    }
                }
                if(CEXTN_cardcount>0){
                    if(CEXTN_chkcustflag==0){
                        CEXTN_validinput=0;
                        $('#CEXTN_div_custerrmsg').text(CEXTN_errmsgs[4].EMC_DATA).show();
                        $('#CEXTN_div_diffunitnocarderrmsg').hide();
                    }
                    else{
                        $('#CEXTN_div_custerrmsg').hide();
                    }
                }
                var fincardlbl=CEXTN_card_diffArray(CEXTN_cardlist,CEXTN_selectcardlist);
                for(var i=0;i<cardid.length;i++){
                    var id=cardid[i];
                    var CEXTN_lb_diffunitcard= $('#CEXTN_lb_diffunitcard'+id).show().val();
                    if(CEXTN_lb_diffunitcard=="SELECT"){
                        CEXTN_validinput=0;
                        var CEXTN_cardnolbl='<option>SELECT</option>';
                        for(var j=0;j<fincardlbl.length;j++){
                            var CEXTN_cardnolabel=fincardlbl[j];
                            CEXTN_cardnolbl += '<option value="' + CEXTN_cardnolabel + '">' + CEXTN_cardnolabel+ '</option>';
                        }
                        $('#CEXTN_lb_diffunitcard'+id).html(CEXTN_cardnolbl);
                    }
                }
                for(var i=0;i<cardid1.length;i++){
                    var id=cardid1[i];
                    $('#CEXTN_tb_diffunitcard'+id).val("");
                    //SET CARD LABEL IN CARD LISTBOX
                    var CEXTN_cardnolbl='<option>SELECT</option>';
                    var CEXTN_chkselect=0;
                    for(var j=0;j<fincardlbl.length;j++){
                        var CEXTN_cardnolabel=fincardlbl[j];
                        CEXTN_cardnolbl += '<option value="' + CEXTN_cardnolabel + '">' + CEXTN_cardnolabel+ '</option>';
                    }
                    $('#CEXTN_lb_diffunitcard'+id).html(CEXTN_cardnolbl);
                    $('#CEXTN_lb_diffunitcard'+id).removeAttr("disabled");
                    $('#CEXTN_lb_diffunitcard'+id).val("SELECT")
                    $('#CEXTN_lb_diffunitcard'+id).hide();
                    for(var kk=0;kk<cardid.length;kk++){
                        var idd=cardid[kk];
                        var CEXTN_lb_diffunitcard= $('#CEXTN_lb_diffunitcard'+idd).val();
                        if(CEXTN_lb_diffunitcard=="SELECT"){
                            CEXTN_chkselect=1;
                        }
                    }
                    if(CEXTN_chkselect==0&&CEXTN_cardcount<=3){
                        $('#'+id).removeAttr("disabled");
                    }
                }
            }
            CEXTN_setproratedvalue()
            var samewaivedchk=$("#CEXTN_cb_sameamtwaived").prop("checked");
            var chkedvalue="X";
            var diffwaivedchk=$("#CEXTN_cb_diffamtwaived").prop("checked");
            if (samewaivedchk==true){
                $("#CEXTN_hidden_sameamtwaived").val(chkedvalue);
            }
            else{
                $("#CEXTN_hidden_sameamtwaived").val("");
            }
            if (diffwaivedchk==true){
                $("#CEXTN_hidden_diffamtwaived").val(chkedvalue);
            }
            else{
                $("#CEXTN_hidden_diffamtwaived").val("");
            }
            if(emailchk=="invalid"||CEXTN_db_chkoutdate==""||CEXTN_lb_chkoutfromtime=="SELECT"||CEXTN_lb_emailid=="SELECT"||CEXTN_chkunitdateflag==1)
            {
                CEXTN_validinput=0;
            }
            if(CEXTN_radio_amt=='CEXTN_radio_diffamt'&&($("#CEXTN_tb_diffamtrent").val()==""||parseFloat($("#CEXTN_tb_diffamtrent").val())==0))
            {
                CEXTN_validinput=0;
            }
            var CEXTN_epnoflag=0,CEXTN_passnoflag=0;
            if (CEXTN_db_passdate!= "" || CEXTN_tb_passno!= ""){
                var ppnoappenddata='<div id="passportnumber"><div class="col-md-3" ><label >PASSPORT NUMBER<span class="labelrequired"><em>*</em></span></label></div></div>';
                $('#passportnumber').replaceWith(ppnoappenddata);
                var ppdateappenddata='<div id="passportdate"><div class="col-md-3"><label>PASSPORT EXPIRY DATE<span class="labelrequired"><em>*</em></span></label></div></div>';
                $('#passportdate').replaceWith(ppdateappenddata);
                if (CEXTN_db_passdate != "" && CEXTN_tb_passno != ""){ CEXTN_passnoflag=0;}
                else{CEXTN_passnoflag=0;CEXTN_validinput=0;}
            }
            else if(CEXTN_db_passdate == "" && CEXTN_tb_passno == ""){
                CEXTN_passnoflag=0;
                var ppnoappenddata1='<div id="passportnumber"><div class="col-md-3" ><label >PASSPORT NUMBER</label></div></div>';
                $('#passportnumber').replaceWith(ppnoappenddata1);
                var ppdateappenddata1='<div id="passportdate"><div class="col-md-3"><label>PASSPORT EXPIRY DATE</label></div></div>';
                $('#passportdate').replaceWith(ppdateappenddata1);
            }
//            else if(CEXTN_tb_passno == ""){
//                CEXTN_passnoflag=0;
//
//            }
            if (CEXTN_db_epdate!= "" || CEXTN_tb_epno!= ""){
                var EPnoappenddata='<div id="epnumber"><div class="col-md-3" ><label >EP NUMBER<span class="labelrequired"><em>*</em></span></label></div></div>';
                $('#epnumber').replaceWith(EPnoappenddata);
                var EPdateappenddata='<div id="EPdate"><div class="col-md-3"><label>EP EXPIRY DATE<span class="labelrequired"><em>*</em></span></label></div></div>';
                $('#EPdate').replaceWith(EPdateappenddata);
                if (CEXTN_db_epdate != "" && CEXTN_tb_epno != ""){ CEXTN_epnoflag=0;}
                else{CEXTN_epnoflag=0;CEXTN_validinput=0;}
            }
            else if(CEXTN_db_epdate == "" && CEXTN_tb_epno == ""){
                CEXTN_epnoflag=0;
                var EPnoappenddata='<div id="epnumber"><div class="col-md-3" ><label >EP NUMBER</label></div></div>';
                $('#epnumber').replaceWith(EPnoappenddata);
                var EPdateappenddata='<div id="EPdate"><div class="col-md-3"><label>EP EXPIRY DATE</label></div></div>';
                $('#EPdate').replaceWith(EPdateappenddata);
            }
            //MINIMUM DIGIT VALIDATION START
            if((parseInt($("#CEXTN_tb_electcapfee").val().split('.')[0])==0||$("#CEXTN_tb_electcapfee").val().split('.')[0]==""||parseInt($("#CEXTN_tb_electcapfee").val().split('.')[0]).toString().length<2)&&parseFloat($("#CEXTN_tb_electcapfee").val())!=0&&$("#CEXTN_tb_electcapfee").val()!="")
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_electcapfee").addClass("invalid")
                $("#CEXTN_electcap_err").text(CEXTN_errmsgs[19].EMC_DATA)
            }
            else
            {
                $("#CEXTN_tb_electcapfee").removeClass("invalid")
                $("#CEXTN_electcap_err").text("")
            }
            if((parseInt($("#CEXTN_tb_diffamtrent").val().split('.')[0])==0||$("#CEXTN_tb_diffamtrent").val().split('.')[0]==""||parseInt($("#CEXTN_tb_diffamtrent").val().split('.')[0]).toString().length<3)&&parseFloat($("#CEXTN_tb_diffamtrent").val())!=0&&$("#CEXTN_tb_diffamtrent").val()!="")
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_diffamtrent").addClass("invalid")
                $("#CEXTN_diffamtrent_err").text(CEXTN_errmsgs[16].EMC_DATA)
            }
            else
            {
                $("#CEXTN_tb_diffamtrent").removeClass("invalid")
                $("#CEXTN_diffamtrent_err").text("")
            }
            if((parseInt($("#CEXTN_tb_diffamtdep").val().split('.')[0])==0||$("#CEXTN_tb_diffamtdep").val().split('.')[0]==""||parseInt($("#CEXTN_tb_diffamtdep").val().split('.')[0]).toString().length<3)&&parseFloat($("#CEXTN_tb_diffamtdep").val())!=0&&$("#CEXTN_tb_diffamtdep").val()!="")
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_diffamtdep").addClass("invalid")
                $("#CEXTN_diffamtdeposit_err").text(CEXTN_errmsgs[17].EMC_DATA)
            }
            else
            {
                $("#CEXTN_tb_diffamtdep").removeClass("invalid")
                $("#CEXTN_diffamtdeposit_err").text("")
            }
            if((parseInt($("#CEXTN_tb_diffamtprocost").val().split('.')[0])==0||$("#CEXTN_tb_diffamtprocost").val().split('.')[0]==""||parseInt($("#CEXTN_tb_diffamtprocost").val().split('.')[0]).toString().length<3)&&parseFloat($("#CEXTN_tb_diffamtprocost").val())!=0&&$("#CEXTN_tb_diffamtprocost").val()!="")
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_diffamtprocost").addClass("invalid")
                $("#CEXTN_diffamtprofee_err").text(CEXTN_errmsgs[18].EMC_DATA)
            }
            else
            {
                $("#CEXTN_tb_diffamtprocost").removeClass("invalid")
                $("#CEXTN_diffamtprofee_err").text("")
            }
            if($("#CEXTN_tb_comppostcode").val()!=""&&($("#CEXTN_tb_comppostcode").val()).toString().length<5&&parseInt($("#CEXTN_tb_comppostcode").val())!=0)
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_comppostcode").addClass("invalid")
                $("#CEXTN_postcode_err").text(CEXTN_errmsgs[15].EMC_DATA)
            }
            else
            {
                $("#CEXTN_tb_comppostcode").removeClass("invalid")
                $("#CEXTN_postcode_err").text("")
            }
            if(($("#CEXTN_tb_passno").val().trim()!=""&&($("#CEXTN_tb_passno").val()).trim().toString().length<6))
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_passno").addClass("invalid")
                $("#CEXTN_passno_err").text(CEXTN_errmsgs[13].EMC_DATA)
            }
            else if(CEXTN_passnoflag==0)
            {
                $("#CEXTN_tb_passno").val($("#CEXTN_tb_passno").val().toUpperCase())
                $("#CEXTN_tb_passno").removeClass("invalid")
                $("#CEXTN_passno_err").text("")
            }
            if(($("#CEXTN_tb_epno").val().trim()!=""&&($("#CEXTN_tb_epno").val()).trim().toString().length<6))
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_epno").addClass("invalid")
                $("#CEXTN_epno_err").text(CEXTN_errmsgs[14].EMC_DATA)
            }
            else if(CEXTN_epnoflag==0)
            {
                $("#CEXTN_tb_epno").val($("#CEXTN_tb_epno").val().toUpperCase())
                $("#CEXTN_tb_epno").removeClass("invalid")
                $("#CEXTN_epno_err").text("")
            }
            //MINIMUM DIGIT VALIDATION END
            //CONTACT NO VALIDATION START
            if($("#CEXTN_tb_mobileno").val()!=""&&(parseInt($("#CEXTN_tb_mobileno").val()).toString().length)<6&&parseInt($("#CEXTN_tb_mobileno").val())!=0)
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_mobileno").addClass("invalid")
                $("#CEXTN_mobile_err").text(CEXTN_errmsgs[12].EMC_DATA)
            }
            else
            {
                $("#CEXTN_tb_mobileno").removeClass("invalid")
                $("#CEXTN_mobile_err").text("")
            }
            if($("#CEXTN_tb_intmobileno").val()!=""&&($("#CEXTN_tb_intmobileno").val().toString().length)<6&&parseInt($("#CEXTN_tb_intmobileno").val())!=0)
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_intmobileno").addClass("invalid")
                $("#CEXTN_intlmobile_err").text(CEXTN_errmsgs[12].EMC_DATA)
            }
            else
            {
                $("#CEXTN_tb_intmobileno").removeClass("invalid")
                $("#CEXTN_intlmobile_err").text("")
            }
            if($('#CEXTN_tb_firstname').val()=='' || $('#CEXTN_tb_lastname').val()==''){
                CEXTN_validinput=0;
            }
            if($('#CEXTN_tb_nation').val()=="SELECT"){
                CEXTN_validinput=0;
            }
            if($("#CEXTN_tb_officeno").val()!=""&&(parseInt($("#CEXTN_tb_officeno").val()).toString().length)<6&&parseInt($("#CEXTN_tb_officeno").val())!=0)
            {
                CEXTN_validinput=0;
                $("#CEXTN_tb_officeno").addClass("invalid")
                $("#CEXTN_officeno_err").text(CEXTN_errmsgs[12].EMC_DATA)
            }
            else
            {
                $("#CEXTN_tb_officeno").removeClass("invalid")
                $("#CEXTN_officeno_err").text("")
            }
            //CONTACT NO VALIDATION END
            if(CEXTN_radio_unit=="CEXTN_radio_sameunitdiffroom")
            {
                if((CEXTN_lb_sameunitdiffrmrmtype=="SELECT"||CEXTN_lb_sameunitdiffrmrmtype==null))
                {
                    CEXTN_validinput=0;
                }
                if((CEXTN_lb_chkinfromtime=="SELECT"||CEXTN_lb_chkinfromtime==null))
                {
                    CEXTN_validinput=0;
                }
            }
            if(CEXTN_radio_unit=="CEXTN_radio_diffunit")
            {
                if((CEXTN_lb_diffunituno=="SELECT"||CEXTN_lb_diffunituno==null))
                {
                    CEXTN_validinput=0;
                }
                if(CEXTN_lb_diffunitrmtype=="SELECT"||CEXTN_lb_diffunitrmtype==null)
                {
                    CEXTN_validinput=0;
                }
                if((CEXTN_lb_chkinfromtime=="SELECT"||CEXTN_lb_chkinfromtime==null))
                {
                    CEXTN_validinput=0;
                }
                if(CEXTN_chkcard==0)
                {
                    CEXTN_validinput=0;
                }
                if(CEXTN_chkfuturedate==0)
                {
                    if(CEXTN_chkdifunitcard==false)
                    {
                        CEXTN_validinput=0;
                    }
                    if(CEXTN_radio_difunitcard=="CEXTN_radio_difunitcardno")
                    {
                        if(CEXTN_chkcardlen==0)
                        {
                            CEXTN_validinput=0;
                        }
                    }
                }
            }
            return CEXTN_validinput;
        }
        function CEXTN_eppasslabel(){

            var ppnoappenddata1='<div id="passportnumber"><div class="col-md-3" ><label >PASSPORT NUMBER</label></div></div>';
            $('#passportnumber').replaceWith(ppnoappenddata1);
            var ppdateappenddata1='<div id="passportdate"><div class="col-md-3"><label>PASSPORT EXPIRY DATE</label></div></div>';
            $('#passportdate').replaceWith(ppdateappenddata1);
            var EPnoappenddata='<div id="epnumber"><div class="col-md-3" ><label >EP NUMBER</label></div></div>';
            $('#epnumber').replaceWith(EPnoappenddata);
            var EPdateappenddata='<div id="EPdate"><div class="col-md-3"><label>EP EXPIRY DATE</label></div></div>';
            $('#EPdate').replaceWith(EPdateappenddata);

        }
        //FUNCTION TO VALIDATE SUBMIT BUTTON
        function CEXTN_validatesubmitbtn(CEXTN_validoutput){
            if(CEXTN_validoutput==0)
            {
                $("#CEXTN_btn_save").attr("disabled","disabled");
            }
            else{
                $("#CEXTN_btn_save").removeAttr("disabled");
            }
        }
//        //FUNCTION FOR ON CLICK OF CUST ID
//        $(document).on("change",'.CEXTN_class_custid', function ()
//        {
//            var  newPos= adjustPosition($(this).position(),100,150);
//            resetPreloader(newPos);
//            $(".preloader").show();
//            CEXTN_Show_ExtensionForm()
//        });
//        //GET DETAILS OF SELECTED CUSTOMER ID
//        function CEXTN_Show_ExtensionForm()
//        {
//            CEXTN_setselectIndex();
//            $('#CEXTN_div_seconform').hide();
//            var CEXTN_lb_unitno=$('#CEXTN_lb_unitno').val();
//            var CEXTN_id=$("input[name=CEXTN_radiocustid]:checked").val();
//            $('#CEXTN_hidden_custid').val(CEXTN_id);
//            $.ajax({
//                type: "POST",
//                url: controller_url+"CEXTN_getCustomerdtls_result",
//                data:{"unitno":CEXTN_lb_unitno,"customerId":CEXTN_id},
//                success: function(data){
//                    var value_array=JSON.parse(data);
//                    CEXTN_getCustomerdtls_result(value_array)
//                    $("html, body").animate({ scrollTop: 1500 }, "slow");
//
//                },
//                error: function(data){
//                    show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);
//
//                }
//            });
//        }
        //SET VALUES OF THE CUST DETAILS RESULT
        function CEXTN_getCustomerdtls_result(CEXTN_custdtls1)
        {
            var CEXTN_custdtls=CEXTN_custdtls1.custdtls;
            if(CEXTN_custdtls!=""&&CEXTN_custdtls!=undefined){
                $('#CEXTN_div_nocusterr').text("");
                CEXTN_currentcheckoutdate=CEXTN_custdtls1.currentcheckoutdate;
                CEXTN_initial_unitsdate=CEXTN_custdtls1.unitsdate;
                CEXTN_initial_unitedate=CEXTN_custdtls1.unitedate;
                var CEXTNunitsdate=CEXTN_initial_unitsdate;
                var CEXTNunitedate=CEXTN_initial_unitedate;
                $('#CEXTN_db_chkoutdate').removeAttr('disabled');
                var CEXTN_unno=$('#CEXTN_lb_unitno').val();
                $("#CEXTN_lbl_chkindate").text("CURRENT CHECK OUT DATE");
                var unitnono=[];
                unitnono=CEXTN_custdtls1.unitno;

                var CEXTN_diffunit=CEXTN_custdtls1.unitno;
                CEXTN_diffunitlen=CEXTN_diffunit.length;
                //ADD DIFF UNIT UNIT NO
                var CEXTN_resdiffunitno='<option>SELECT</option>';
                for(var i=0;i<CEXTN_diffunit.length;i++)
                {
                    CEXTN_resdiffunitno += '<option value="' + CEXTN_diffunit[i] + '">' + CEXTN_diffunit[i] + '</option>';
                }
                $('#CEXTN_lb_diffunituno').html(CEXTN_resdiffunitno);
                $('#CEXTN_tb_firstname').val(CEXTN_custdtls.cust_firstname).attr("size",(CEXTN_custdtls.cust_firstname).length+5);
                $('#CEXTN_tb_lastname').val(CEXTN_custdtls.cust_lastname).attr("size",(CEXTN_custdtls.cust_lastname).length+5);
                if(CEXTN_custdtls.cust_compname!="")
                {
                    $('#CEXTN_tb_compname').val(CEXTN_custdtls.cust_compname).attr("size",parseInt(((CEXTN_custdtls.cust_compname).length)+6))
                }
                else
                {
                    $('#CEXTN_tb_compname').val("").prop("size","20");
                }
                if(CEXTN_custdtls.cust_compaddr!="")
                {
                    $('#CEXTN_tb_compaddr').val(CEXTN_custdtls.cust_compaddr).attr("size",parseInt(((CEXTN_custdtls.cust_compaddr).length)+6));
                }
                else
                {
                    $('#CEXTN_tb_compaddr').val("").prop("size","20");
                }
                if(CEXTN_custdtls.cust_comppostcode!="")
                {
                    $('#CEXTN_tb_comppostcode').val(CEXTN_custdtls.cust_comppostcode).prop("title",CEXTN_errmsgs[1].EMC_DATA);
                }
                else
                {
                    $('#CEXTN_tb_comppostcode').val("").prop("title",CEXTN_errmsgs[1].EMC_DATA).prop("title",CEXTN_errmsgs[1].EMC_DATA)
                }
                $('#CEXTN_tb_emailid').val(CEXTN_custdtls.cust_email).attr("size",(CEXTN_custdtls.cust_email).length);
                if(CEXTN_custdtls.cust_mobile!="")
                {
                    $('#CEXTN_tb_mobileno').val(CEXTN_custdtls.cust_mobile).prop("title",CEXTN_errmsgs[1].EMC_DATA);
                }
                else
                {
                    $('#CEXTN_tb_mobileno').val("").prop("size","20").prop("title",CEXTN_errmsgs[1].EMC_DATA)
                }
                if(CEXTN_custdtls.cust_intlmobile!="")
                {
                    $('#CEXTN_tb_intmobileno').val(CEXTN_custdtls.cust_intlmobile).prop("title",CEXTN_errmsgs[1].EMC_DATA);//.attr("size",(CEXTN_custdtls.cust_intlmobile).length);
                }
                else
                {
                    $('#CEXTN_tb_intmobileno').val("").prop("size","20").prop("title",CEXTN_errmsgs[1].EMC_DATA)
                }
                if(CEXTN_custdtls.cust_officeno!="")
                {
                    $('#CEXTN_tb_officeno').val(CEXTN_custdtls.cust_officeno).prop("title",CEXTN_errmsgs[1].EMC_DATA);
                }
                else
                {
                    $('#CEXTN_tb_officeno').val("").prop("size","20").prop("title",CEXTN_errmsgs[1].EMC_DATA)
                }
                if(CEXTN_custdtls.cust_dob=="")
                {
                    $('#CEXTN_db_dob').val(CEXTN_custdtls.cust_dob);//.prop("readonly",false).removeClass("rdonly");

                }
                else
                {
                    $('#CEXTN_db_dob').val(FormTableDateFormat(CEXTN_custdtls.cust_dob));//.prop("readonly",true).addClass("rdonly");
//                    $('#CEXTN_db_dob').datepicker( "destroy" )
                }
                $('#CEXTN_tb_nation').val(CEXTN_custdtls.cust_nation);//.attr("size",parseInt(((CEXTN_custdtls.cust_nation).length)+6));
                if(CEXTN_custdtls.cust_passno!="")
                {
                    $('#CEXTN_tb_passno').val(CEXTN_custdtls.cust_passno).attr("size",(CEXTN_custdtls.cust_passno).length+3);
                }
                else
                {
                    $('#CEXTN_tb_passno').val("").prop("size","20")
                }
                if(CEXTN_custdtls.cust_passdate!="")
                {
                    $('#CEXTN_db_passdate').val(FormTableDateFormat(CEXTN_custdtls.cust_passdate));
                }
                else
                {
                    $('#CEXTN_db_passdate').val("");
                }
                if(CEXTN_custdtls.cust_epno!="")
                {
                    $('#CEXTN_tb_epno').val(CEXTN_custdtls.cust_epno).attr("size",(CEXTN_custdtls.cust_epno).length+3);
                }
                else
                {
                    $('#CEXTN_tb_epno').val("").prop("size","20")
                }
                if(CEXTN_custdtls.cust_epdate!="")
                {
                    $('#CEXTN_db_epdate').val(FormTableDateFormat(CEXTN_custdtls.cust_epdate));
                }
                else
                {
                    $('#CEXTN_db_epdate').val("");
                }
                $('#CEXTN_tb_sameunitsamermrmtype').val(CEXTN_custdtls.cust_rmtype).attr("size",(CEXTN_custdtls.cust_rmtype).length+3);
                $('#CEXTN_tb_sameunitsamermuno').val($('#CEXTN_lb_unitno').val());
                $('#CEXTN_lb_sameunitdiffrmrmtype').val(CEXTN_custdtls.cust_rmtype);
                $('#CEXTN_tb_sameunitdiffrmuno').val($('#CEXTN_lb_unitno').val());
                if(CEXTN_custdtls.cust_chkindate!="")
                {
                    $('#CEXTN_db_prevchkindate').val(FormTableDateFormat(CEXTN_custdtls.cust_chkindate));
                }
                else
                {
                    $('#CEXTN_db_prevchkindate').val("");
                }
                if(CEXTN_custdtls.cust_preterminatedate!="")
                {
                    $('#CEXTN_db_chkindate').val(FormTableDateFormat(CEXTN_custdtls.cust_preterminatedate));
                }
                else
                {
                    $('#CEXTN_db_chkindate').val(FormTableDateFormat(CEXTN_custdtls.cust_chkoutdate));
                }
                ////START PLACE CARD
                $('#CTERM_tbl_sameunitsamermcust_card').empty();
                $('#CTERM_tbl_sameunitdiffrmcust_card').empty();
                var CEXTN_card=[];
                CEXTN_card=CEXTN_custdtls1.cardarray;
                if(CEXTN_card.length>0&&CEXTN_card[0]!="")
                {
                    for(var i=0;i<CEXTN_card.length;i++)
                    {
                        if(i==0)
                        {
                            var CEXTN_cardlabel='<div class="form-group"><label class="col-sm-3" >CUSTOMER CARD</label>'
                            var CEXTN_custlbl=$('#CEXTN_tb_firstname').val()+"_"+$('#CEXTN_tb_lastname').val()
                            CEXTN_custlbl=CEXTN_custlbl.replace(/ /g,"_")
                        }
                        else
                        {
                            var CEXTN_cardlabel='<div class="form-group"><label class="col-sm-3" >GUEST '+i+' CARD</label>'
                            var CEXTN_custlbl='GUEST'+i;
                        }
                        var cardsize=CEXTN_card[i].length;
                        var CEXTN_result=CEXTN_cardlabel+' <div class="col-sm-2"><input type="text" class="form-control" name="CEXTN_tb_sameunitsamermcustcard[]" value='+CEXTN_card[i]+' size='+cardsize+' readonly ></div><div><input type="text" name="CEXTN_hidden_sameunitsamermcustcard[]"  value='+CEXTN_custlbl+' hidden/></div>';
                        var CEXTN_result1=CEXTN_cardlabel+' <div class="col-sm-2"><input type="text" class="form-control" name="CEXTN_tb_sameunitdiffrmcustcard[]" value='+CEXTN_card[i]+' size='+cardsize+' readonly></div><div><input type="text" name="CEXTN_hidden_sameunitdiffrmcustcard[]"  value='+CEXTN_custlbl+' hidden/></div>';
                        CEXTN_result=CEXTN_result+'</div>';
                        CEXTN_result1=CEXTN_result1+'</div>';
                        $('#CTERM_tbl_sameunitsamermcust_card').append(CEXTN_result);
                        $('#CTERM_tbl_sameunitdiffrmcust_card').append(CEXTN_result1);
                    }
                    $('#CTERM_tbl_sameunitsamermcust_card').show();
                }
                //END PLACE CARD
                //START PLACE AMT
                $('#CEXTN_tb_airquarterfee').prop("title",CEXTN_errmsgs[1].EMC_DATA)
                $('#CEXTN_tb_fixedairfee').prop("title",CEXTN_errmsgs[1].EMC_DATA);
                $('#CEXTN_tb_diffamtdep').prop("title",CEXTN_errmsgs[1].EMC_DATA);
                $('#CEXTN_tb_diffamtrent').prop("title",CEXTN_errmsgs[1].EMC_DATA);
                $('#CEXTN_tb_diffamtprocost').prop("title",CEXTN_errmsgs[1].EMC_DATA)
                if(CEXTN_custdtls.cust_airconquarterfee=="")
                {
                    $('#CEXTN_tb_airquarterfee').val(CEXTN_custdtls.cust_airconquarterfee).hide();
                    $('#CEXTN_radio_quartairconfee').prop('checked',false);
                }
                else
                {
                    $('#CEXTN_radio_quartairconfee').prop('checked',true);
                    $('#CEXTN_tb_airquarterfee').val(CEXTN_custdtls.cust_airconquarterfee).show();
                    $('#CEXTN_tb_fixedairfee').val(CEXTN_custdtls.cust_airconfixedfee).hide();
                }
                if(CEXTN_custdtls.cust_airconfixedfee=="")
                {
                    $('#CEXTN_tb_fixedairfee').val(CEXTN_custdtls.cust_airconfixedfee).hide();
                    $('#CEXTN_radio_fixedairconfee').prop('checked',false);
                }
                else
                {
                    $('#CEXTN_radio_fixedairconfee').prop('checked',true);
                    $('#CEXTN_tb_fixedairfee').val(CEXTN_custdtls.cust_airconfixedfee).show();
                    $('#CEXTN_tb_airquarterfee').val(CEXTN_custdtls.cust_airconquarterfee).hide();
                }
                $('#CEXTN_tb_sameamtdep').val(CEXTN_custdtls.cust_deposit);
                $('#CEXTN_tb_sameamtrent').val(CEXTN_custdtls.cust_rental);
                $('#CEXTN_tb_sameamtprocost').val(CEXTN_custdtls.cust_procfee);
                $('#CEXTN_tb_electcapfee').val(CEXTN_custdtls.cust_electcapfee).prop("title",CEXTN_errmsgs[1].EMC_DATA);
                $('#CEXTN_tb_curtaindryfee').val(CEXTN_custdtls.cust_dryclean).prop("title",CEXTN_errmsgs[1].EMC_DATA);
                $('#CEXTN_tb_chkoutcleanfee').val(CEXTN_custdtls.cust_chkoutfee).prop("title",CEXTN_errmsgs[1].EMC_DATA);
                //END PLACE AMT
                CEXTN_SetMinMaxCheckoutDate(CEXTNunitsdate,CEXTNunitedate,CEXTN_currentcheckoutdate)//set check out min n max date
                $("#CEXTN_lb_chkoutfromtime").val("SELECT").hide();
                $("#CEXTN_lb_chkouttotime").hide();
                $('#CEXTN_lbl_chkoutto').hide();
                $('#CEXTN_db_chkoutdate').val("");

                //SET PRORATED WAIVED CHECK BOX
                if(CEXTN_custdtls.cust_prorated!="")
                {
                    $('#CEXTN_cb_sameamtprorated').prop('checked',true);
                    $("#CEXTN_hidden_sameamtprorated").val("X");
                }
                else
                {
                    $('#CEXTN_cb_sameamtprorated').prop('checked',false);
                    $("#CEXTN_hidden_sameamtprorated").val("");
                }
                if(CEXTN_custdtls.cust_waived!="")
                {
                    $('#CEXTN_cb_sameamtwaived').prop('checked',true);
                    $("#CEXTN_hidden_sameamtwaived").val("X");
                }
                else
                {
                    $('#CEXTN_cb_sameamtwaived').prop('checked',false);
                    $("#CEXTN_hidden_sameamtwaived").val("");
                }
                //            $('#CEXTN_ta_comments').height(20);
                $("#CEXTN_ta_comments").val(CEXTN_custdtls.cust_comts);
                //SET NOTICE PERIOD DATE
                if(CEXTN_custdtls.cust_noticedate!="")
                {
                    $("#CEXTN_db_noticeperioddate").val(FormTableDateFormat(CEXTN_custdtls.cust_noticedate));
                }
                //SET CHECK IN FROM TIME N TO TIME
                var prechkinfromtimee=CEXTN_custdtls.cust_stfrmtime.split(':');
                var prechkintotimee=CEXTN_custdtls.cust_sttotime.split(':');
                var chkinfromtimee=CEXTN_custdtls.cust_edfrmtime.split(':');
                var chkintotimee=CEXTN_custdtls.cust_edtotime.split(':');
                $('#CEXTN_hidden_prechkinfromtime').val(prechkinfromtimee[0]+":"+prechkinfromtimee[1])
                $('#CEXTN_hidden_prechkintotime').val(prechkintotimee[0]+":"+prechkintotimee[1])
                $('#CEXTN_hidden_chkinfromtime').val(chkinfromtimee[0]+":"+chkinfromtimee[1])
                $('#CEXTN_hidden_chkintotime').val(chkintotimee[0]+":"+chkintotimee[1])
                $('#CEXTN_tb_noticeperiod').val(CEXTN_custdtls.cust_noticeperiod).prop("title",CEXTN_errmsgs[1].EMC_DATA);
                $('#CEXTN_div_seconform').show();
                //SET RADIO BUTTON
                $('#CEXTN_div_sameunitsamerm').show();
                $('#CEXTN_radio_sameunit').prop('checked',true);
                $('#CEXTN_radio_sameunitdiffroom').prop('checked',false);
                $('#CEXTN_radio_diffunit').prop('checked',false);
                $('#CEXTN_div_sameunitdiffrm').hide();
                $('#CEXTN_div_diffunit').hide();
                $('#CEXTN_div_sameamt').show();
                $('#CEXTN_radio_sameamt').prop('checked',true);
                $('#CEXTN_div_diffamt').hide();
                $('#CEXTN_radio_diffamt').prop('checked',false);
            }
            else
            {
                $('#CEXTN_div_nocusterr').text(CEXTN_errmsgs[8].EMC_DATA.replace('[CNAME]',$('#CEXTN_lb_custname').val().split("_")[0]+" "+$('#CEXTN_lb_custname').val().split("_")[1]));
            }
            $('#CEXTN_db_chkoutdate').focus();
            $(".preloader").hide();

        }
        //FUNCTION TO SET MIN N MAX DATE FOR CHECK OUT DATE
        function CEXTN_SetMinMaxCheckoutDate(CEXTNunitsdate,CEXTNunitedate,CEXTN_currentcheckoutdate){
            $('#CEXTN_db_chkoutdate').removeAttr('disabled');
            $('#CEXTN_db_chkoutdate').val('');
            $("#CEXTN_lb_chkoutfromtime").val('SELECT').hide();
            $('#CEXTN_lb_chkouttotime').hide();
            $('#CEXTN_lbl_chkoutto').hide();
            $('#CEXTN_db_chkoutdate').datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true
            });
            //get check in date
            var CEXTN_date1 = $('#CEXTN_db_chkindate').val();
            var CEXTN_chkoutmaxdate = new Date( Date.parse(CEXTNunitedate) );
            CEXTN_chkoutmaxdate.setDate( CEXTN_chkoutmaxdate.getDate()-1);
            CEXTN_chkoutmaxdate = CEXTN_chkoutmaxdate.toDateString();
            CEXTN_chkoutmaxdate = new Date( Date.parse( CEXTN_chkoutmaxdate ) );
            if(new Date(FormTableDateFormat(CEXTN_date1)).setHours(0,0,0,0)>=new Date(CEXTN_chkoutmaxdate).setHours(0,0,0,0))
            {
                CEXTN_chkunitdateflag=1;
                $('#CEXTN_db_chkindate').addClass("invalid");
                $('#CEXTN_usdatexpiremsg').text(CEXTN_errmsgs[10].EMC_DATA);
                $('#CEXTN_db_chkoutdate').datepicker( "destroy" )
                $('#CEXTN_db_chkoutdate').attr('disabled','disabled');
                $('#CEXTN_db_chkoutdate').val('');
                $('#CEXTN_uedatexpiremsg').text('');
            }
            else{
                CEXTN_chkunitdateflag=0;
                $('#CEXTN_db_chkindate').removeClass("invalid")
                $('#CEXTN_usdatexpiremsg').text("");
            }
            if(new Date(CEXTNunitsdate).setHours(0,0,0,0)<=new Date(FormTableDateFormat(CEXTN_date1)).setHours(0,0,0,0))
            {
                CEXTN_date1=CEXTN_date1;
                var CEXTN_date = new Date( Date.parse(FormTableDateFormat(CEXTN_date1) ) );
            }
            else
            {
                CEXTN_date1=FormTableDateFormat(CEXTNunitsdate);
                var CEXTN_date = new Date( Date.parse(FormTableDateFormat(CEXTN_date1)) );
            }
            CEXTN_date.setDate( CEXTN_date.getDate() + 1 );
            var CEXTN_newDate = CEXTN_date.toDateString();
            CEXTN_newDate = new Date( Date.parse( CEXTN_newDate ) );
            //get today date
            var CEXTN_todaydate = new Date();
            CEXTN_todaydate.setDate( CEXTN_todaydate.getDate() + 1 );
            var CEXTN_todaydate = CEXTN_todaydate.toDateString();
            CEXTN_todaydate = new Date( Date.parse(CEXTN_todaydate ) );
            if(new Date(FormTableDateFormat(CEXTN_date1)).setHours(0,0,0,0)>=new Date(CEXTN_currentcheckoutdate))
            {
                CEXTN_date1=FormTableDateFormat(CEXTN_currentcheckoutdate);
            }
            if(new Date(FormTableDateFormat(CEXTN_date1)).setHours(0,0,0,0)<=new Date().setHours(0,0,0,0))
            {
                $('#CEXTN_db_chkoutdate').datepicker("option","minDate",CEXTN_todaydate);
            }
            else
            {
                $('#CEXTN_db_chkoutdate').datepicker("option","minDate",CEXTN_newDate);
            }
            var CEXTN_chkoutmaxdate = new Date( Date.parse(CEXTNunitedate) );
            CEXTN_chkoutmaxdate.setDate( CEXTN_chkoutmaxdate.getDate()-1);
            CEXTN_chkoutmaxdate = CEXTN_chkoutmaxdate.toDateString();
            CEXTN_chkoutmaxdate = new Date( Date.parse( CEXTN_chkoutmaxdate ) );
            var CEXTN_ptdchkflag=0;
            if(new Date(CEXTN_chkoutmaxdate).setHours(0,0,0,0)>=new Date(CEXTN_currentcheckoutdate))
            {
                CEXTN_ptdchkflag=1;
                CEXTNunitedate=CEXTN_currentcheckoutdate;
            }
            var CEXTN_chkoutmaxdate = new Date( Date.parse(CEXTNunitedate) );
            if(CEXTN_ptdchkflag==0)
            {
                CEXTN_chkoutmaxdate.setDate( CEXTN_chkoutmaxdate.getDate()-1);
            }
            else
            {
                CEXTN_chkoutmaxdate.setDate( CEXTN_chkoutmaxdate.getDate());
            }
            CEXTN_chkoutmaxdate = CEXTN_chkoutmaxdate.toDateString();
            CEXTN_chkoutmaxdate = new Date( Date.parse( CEXTN_chkoutmaxdate ) );
            $("#CEXTN_db_chkoutdate").datepicker("option","maxDate",CEXTN_chkoutmaxdate);
            var mindate=new Date($( "#CEXTN_db_chkoutdate" ).datepicker( "option", "minDate"))
            var maxdate=new Date($( "#CEXTN_db_chkoutdate" ).datepicker( "option", "maxDate"))
            if(CEXTN_chkunitdateflag==0)
            {
                if(maxdate.setHours(0,0,0,0)<mindate.setHours(0,0,0,0))
                {
                    $('#CEXTN_db_chkoutdate').addClass("invalid");
                    $('#CEXTN_db_chkoutdate').datepicker( "destroy" )
                    $('#CEXTN_db_chkoutdate').attr('disabled','disabled');
                    $('#CEXTN_db_chkoutdate').val('');
                    $('#CEXTN_uedatexpiremsg').text(CEXTN_errmsgs[24].EMC_DATA);//.text(CEXTN_errmsgs[10])
                    CEXTN_chkunitdateflag=1;
                }
                else{
                    CEXTN_chkunitdateflag=0;
                    if(new Date(CEXTN_chkoutmaxdate).setHours(0,0,0,0)<=new Date().setHours(0,0,0,0))
                    {
                        CEXTN_chkunitdateflag=1;
                        $('#CEXTN_db_chkoutdate').val("");
                        $('#CEXTN_db_chkoutdate').addClass("invalid")
                        $('#CEXTN_uedatexpiremsg').text(CEXTN_errmsgs[10].EMC_DATA)
                        $("#CEXTN_lb_chkoutfromtime").val("SELECT").hide();
                        $("#CEXTN_lb_chkouttotime").hide();
                        $('#CEXTN_lbl_chkoutto').hide();
                        $('#CEXTN_db_chkoutdate').datepicker( "destroy" )
                        $('#CEXTN_db_chkoutdate').attr('disabled','disabled');
                    }
                    else
                    {
                        $('#CEXTN_db_chkoutdate').removeClass("invalid")
                        $('#CEXTN_uedatexpiremsg').text("");
                        CEXTN_chkunitdateflag=0;
                    }
                }
            }
            CEXTN_clearerrmsg();
        }
        //FUNCTION TO SET SOME LISTBOX VALUE TO SELECT
        function CEXTN_setselectIndex()
        {
            CEXTN_clearerrmsg()
            $('#CEXTN_form').find('input:text').prop("size","20");
            $('#CEXTN_lb_chkinfromtime').val("SELECT").hide();
            $('#CEXTN_lb_chkintotime').hide();
            $("#CEXTN_lbl_chkinto").hide();
            $('#CEXTN_lb_chkoutfromtime').val("SELECT");
            $('#CEXTN_lb_chkouttotime').hide();
            $('#CEXTN_lbl_chkoutto').hide();
            $("#CEXTN_lb_emailid").val("SELECT");
            $("#CEXTN_btn_save").attr("disabled","disabled");
        }
        $('#CEXTN_btn_save').on('click', function () {
            $('.preloader').show();
            var FormElements = document.getElementById("CEXTN_form");
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var saveresult = JSON.parse(xmlhttp.responseText);
                    $('.preloader').hide();
                    CEXTN_SaveDetails_result(saveresult)
                }
            }
            var option = 'SAVE';
            xmlhttp.open("POST",controller_url+"CEXTN_SaveDetails", true);
            xmlhttp.send(new FormData(FormElements));
        });
        //FUNCTION TO RETURN SAVE RESULT
        function CEXTN_SaveDetails_result(saveresult){
            var CEXTN_tb_firstname=$("#CEXTN_tb_firstname").val();
            var CEXTN_tb_lastname=$("#CEXTN_tb_lastname").val();
            var CEXTN_successmsg=CEXTN_errmsgs[7].EMC_DATA;
            var paymentchkmsg=saveresult[1];
            var saveresult1=saveresult[0];
            var cal_flag=saveresult[2];
            if(saveresult1==1 && cal_flag==1){
                CEXTN_clearForm();
                CEXTN_successmsg=CEXTN_successmsg.replace('[FIRST NAME]',CEXTN_tb_firstname)
                CEXTN_successmsg=CEXTN_successmsg.replace('[LAST NAME]',CEXTN_tb_lastname)
                if(paymentchkmsg!=null){
                    show_msgbox("CUSTOMER EXTENSION",CEXTN_successmsg+" "+paymentchkmsg,"success",false);
                }
                else {
                    show_msgbox("CUSTOMER EXTENSION",CEXTN_successmsg,"success",false);
                }
            }
            else{
                if(saveresult1.toString()=='0'){
                    show_msgbox("CUSTOMER EXTENSION",CEXTN_errmsgs[21].EMC_DATA,"success",false);
                }
                else {
                    show_msgbox("CUSTOMER EXTENSION",saveresult1,"success",false);
                }
                $(".preloader").hide();
            }
        }
        ////FUNCTION TO CLEAR LIST BOX FIELD
        function CEXTN_clearForm(){
            var  newPos= adjustPosition($('#CEXTN_lb_unitno').position(),100,150);
            resetPreloader(newPos);
            $('#CEXTN_ta_comments').height(116);
            $(".preloader").show();
            CEXTN_clearerrmsg();
            $('#CEXTN_lbl_custname').hide();
            $('#CEXTN_lb_custname').hide();
            $('#CEXTN_div_custid').hide();
            $('#CEXTN_div_seconform').hide();
            $("#CEXTN_form").hide();
            $.ajax({
                type: "POST",
                url: controller_url+"CEXTN_getCommonvalues",
                data:{"Formname":'EXTENSION',"ErrorList":'1,2,33,34,35,36,76,77,97,282,331,332,339,342,343,344,345,346,347,348,386,400,443,444,447,458,459,460,461'},
                success: function(data){
                    $(".preloader").hide();
                    var value_array=JSON.parse(data);
                    CEXTN_getCommonvalues_result(value_array);

                },
                error: function(data){
                    show_msgbox("CUSTOMER EXTENSION",JSON.stringify(data),"error",false);

                }
            });
        }
        //RESET FORM FIELDS
        $("#CEXTN_btn_reset").click(function(){
            CEXTN_clearForm();
            $('#CEXTN_ta_comments').height(116);
        });
        $(document).on('change', '.CEXTN_fileextensionchk', function () {
            var filename = $('#CEXTN_fileupload').val();
            if(filename!='') {
                var valid_extensions = /(\.pdf)$/i;
                if (valid_extensions.test(filename)) {
                }
                else {
                    show_msgbox("CUSTOMER EXTENSION", 'UPLOAD ONLY PDF FILES', "success", false);
                    $('#CEXTN_fileupload').val('');
                }
            }
        });
        //FUNCTION TO CLEAR ERR MSG
        function CEXTN_clearerrmsg()
        {
            $('#CEXTN_div_custerrmsg').hide();
            $('#CEXTN_div_diffunitnocarderrmsg').hide();
            $('#CEXTN_div_nodiffuniterr').hide();
            $('#CEXTN_tb_emailid').removeClass("invalid");
            $("#CEXTN_lbl_emailerrmsg").text("");
            $("#CEXTN_tb_electcapfee").removeClass("invalid")
            $("#CEXTN_electcap_err").text("")
            $("#CEXTN_tb_diffamtrent").removeClass("invalid")
            $("#CEXTN_diffamtrent_err").text("")
            $("#CEXTN_tb_diffamtdep").removeClass("invalid")
            $("#CEXTN_diffamtdeposit_err").text("")
            $("#CEXTN_tb_diffamtprocost").removeClass("invalid")
            $("#CEXTN_diffamtprofee_err").text("")
            $("#CEXTN_tb_comppostcode").removeClass("invalid")
            $("#CEXTN_postcode_err").text("")
            $("#CEXTN_tb_passno").removeClass("invalid")
            $("#CEXTN_passno_err").text("")
            $("#CEXTN_tb_epno").removeClass("invalid")
            $("#CEXTN_epno_err").text("")
            $("#CEXTN_tb_mobileno").removeClass("invalid")
            $("#CEXTN_mobile_err").text("")
            $("#CEXTN_tb_intmobileno").removeClass("invalid")
            $("#CEXTN_intlmobile_err").text("")
            $("#CEXTN_tb_officeno").removeClass("invalid")
            $("#CEXTN_officeno_err").text("")
            $('#CEXTN_db_epdate').removeClass("invalid");
            $("#CEXTN_epdate_err").text("");
            $('#CEXTN_db_passdate').removeClass("invalid");
            $("#CEXTN_passdate_err").text("");
            $('#CEXTN_fileupload').val('');
            CEXTN_eppasslabel();
        }
    });
</script>
<!--SCRIPT TAG END-->
<!--BODY TAG START-->
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="row title text-center"><h4><b>CUSTOMER EXTENSION</b></h4></div>
    <div id="CEXTN_div_allerrmsg"></div>
    <form class="content form-horizontal" name="CEXTN_form" id="CEXTN_form" hidden>
        <div class="panel-body">
            <div id="CEXTN_tble_first" >
                <div class="form-group">
                    <label class="col-sm-3" name="CEXTN_lbl_unitno" id="CEXTN_lbl_unitno">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"> <select id="CEXTN_lb_unitno" name="CEXTN_lb_unitno" class="CEXTN_btn_validate_class form-control"></select></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" name="CEXTN_lbl_custname" id="CEXTN_lbl_custname" hidden>CUSTOMER NAME <em>*</em></label>
                    <div class="col-sm-4"> <select id="CEXTN_lb_custname" name="CEXTN_lb_custname"  class="CEXTN_btn_validate_class form-control " style=" display:none" ></select></div>
                </div>
            </div>
            <div id="CEXTN_div_nocusterr" class="errormsg"></div>
            <div id="CEXTN_div_seconform" hidden>
                <div id='CEXTN_tble_seconform'>
                    <div class="form-group">
                        <label class="col-sm-3">FIRST NAME<em>*</em></label>
                        <div class="col-sm-3"> <input type="text" name="CEXTN_tb_firstname" id="CEXTN_tb_firstname"  class="form-control autosize CEXTN_btn_validate_class" maxlength="30" placeholder="Customer First Name" /><p class="field" ></p><input type="hidden" name="CEXTN_hidden_custid" id="CEXTN_hidden_custid"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">LAST NAME<em>*</em></label>
                        <div class="col-sm-3"> <input type="text" name="CEXTN_tb_lastname" id="CEXTN_tb_lastname"  maxlength="30" class="form-control autosize CEXTN_btn_validate_class" placeholder="Customer Last Name"  /></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">COMPANY NAME</label>
                        <div class="col-sm-3"> <input type="text" name="CEXTN_tb_compname" id="CEXTN_tb_compname"  maxlength="50" class="form-control autosize" placeholder="Company Name" /></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">COMPANY ADDRESS</label>
                        <div class="col-sm-3"> <input type="text" name="CEXTN_tb_compaddr" id="CEXTN_tb_compaddr"  maxlength="50"  class="form-control autosize " placeholder="Company Address"  /></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">COMPANY POSTAL CODE</label>
                        <div class="col-sm-3">
                            <input type="text" name="CEXTN_tb_comppostcode" id="CEXTN_tb_comppostcode" maxlength="6" style="max-width:100px;" class="form-control CEXTN_btn_validate_class" placeholder="Postal Code" />
                        </div>
                        <div class="col-sm-4"><p id="CEXTN_postcode_err" class="errormsg" ></p></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">EMAIL ID<em>*</em></label>
                        <div class="col-sm-3">
                            <input type="text" name="CEXTN_tb_emailid" id="CEXTN_tb_emailid"  maxlength="40"  class="form-control CEXTN_btn_validate_class"  placeholder="Customer Email Id" />
                        </div>
                        <div class="col-sm-4"><label  id="CEXTN_lbl_emailerrmsg" class="errormsg"></label></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">MOBILE</label>
                        <div class="col-sm-2">
                            <input type="text" name="CEXTN_tb_mobileno" id="CEXTN_tb_mobileno"  style="width:90px;" class="numonlynozero CEXTN_btn_validate_class form-control" placeholder="Mobile No" />
                        </div>
                        <div class="col-sm-4"><p id="CEXTN_mobile_err" class="errormsg"></p></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">INT'L MOBILE NO</label>
                        <div class="col-sm-3">
                            <input type="text" name="CEXTN_tb_intmobileno" style="max-width:200px;" id="CEXTN_tb_intmobileno"  class="CEXTN_btn_validate_class form-control" placeholder="Int'l Mobile No"/>
                        </div>
                        <div class="col-sm-4"><p id="CEXTN_intlmobile_err" class="errormsg"></p></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">OFFICE NO</label>
                        <div class="col-sm-2">
                            <input type="text" name="CEXTN_tb_officeno" id="CEXTN_tb_officeno"  style="width:90px;" maxlength="8"  class="numonlynozero CEXTN_btn_validate_class form-control" placeholder="Office No" />
                        </div>
                        <div class="col-sm-4"><p id="CEXTN_officeno_err" class="errormsg"></p></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">DATE OF BIRTH</label>
                        <div class="col-sm-2"> <input type="text" name="CEXTN_db_dob" id="CEXTN_db_dob"  maxlength="10"  class="datenonmandtry CEXTN_btn_validate_class form-control" placeholder="DateOfBirth"/><p class="field" ></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">NATIONALITY<em>*</em></label>
                        <div class="col-md-3">
                            <SELECT class="form-control CEXTN_btn_validate_class" name="CEXTN_tb_nation" maxlength="8"  id="CEXTN_tb_nation" >
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3" id="passportnumber">PASSPORT NUMBER</label>
                        <div class="col-sm-3">
                            <input type="text" name="CEXTN_tb_passno" id="CEXTN_tb_passno" style="max-width:170px;" maxlength="15" class="alnumonlyzero CEXTN_btn_validate_class form-control" placeholder="Passport No" />
                        </div>
                        <div class="col-sm-4"><p id="CEXTN_passno_err" class="errormsg"></p></div>
                    </div>
                    <div class="form-group" >
                        <label class="col-sm-3" id="passportdate">PASSPORT EXPIRY DATE</label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" name="CEXTN_db_passdate" id="CEXTN_db_passdate"  maxlength="10"  class="datenonmandtry CEXTN_btn_validate_class form-control" placeholder="Passport Date"/><label for="CEXTN_db_passdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                        <div class="col-sm-4"><p id="CEXTN_passdate_err" class="errormsg" ></p></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3" id="epnumber">EP NUMBER</label>
                        <div class="col-sm-3">
                            <input type="text" name="CEXTN_tb_epno" id="CEXTN_tb_epno"  style="max-width:170px;" maxlength="15" class="alnumonlynozero CEXTN_btn_validate_class form-control" placeholder="EP No" />
                        </div>
                        <div class="col-sm-4"><p id="CEXTN_epno_err" class="errormsg"></div>
                    </div>
                    <div class="form-group" >
                        <label class="col-sm-3" id="EPdate">EP EXPIRY DATE</label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" name="CEXTN_db_epdate" id="CEXTN_db_epdate"  maxlength="10"  class="datenonmandtry CEXTN_btn_validate_class form-control" placeholder="EP Date" /><label for="CEXTN_db_epdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                        <div class="col-sm-4"><p id="CEXTN_epdate_err" class="errormsg" ></p></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">SAME/DIFFERENT UNIT<em>*</em></label>
                        <div class="col-sm-offset-3 ">
                            <div class="radio" style="padding-left: 15px">
                                <label><input type="radio" name="CEXTN_radio_unit" id="CEXTN_radio_sameunit" value="CEXTN_radio_sameunit" checked="checked" class="CEXTN_btn_validate_class"/>
                                    SAME UNIT & SAME ROOM </label><input type="hidden" id="CEXTN_hidden_setrmtype"/>
                            </div>
                            <div id="CEXTN_div_sameunitsamerm" class="" style="padding-left: 20px">
                                <div class="form-group">
                                    <label  class="col-sm-3">UNIT NUMBER</label>
                                    <div class="col-sm-2"> <input type="text" name="CEXTN_tb_sameunitsamermuno" id="CEXTN_tb_sameunitsamermuno" style="width:60px;" class="rdonly form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3">ROOM TYPE</label>
                                    <div class="col-sm-3"> <input type="text" name="CEXTN_tb_sameunitsamermrmtype" id="CEXTN_tb_sameunitsamermrmtype" class=" form-control" readonly />
                                    </div>
                                </div>
                                <div id="CTERM_tbl_sameunitsamermcust_card" hidden></div>
                            </div>
                        </div>
                        <div class="col-sm-offset-3">
                            <div class="radio" style="padding-left: 15px">
                                <label>
                                    <input type="radio" name="CEXTN_radio_unit" id="CEXTN_radio_sameunitdiffroom"  value="CEXTN_radio_sameunitdiffroom" class="CEXTN_btn_validate_class" />
                                    SAME UNIT & DIFFERENT ROOM</label><div id="CEXTN_div_sameunitdiffroomerr" class="errormsg"></div>
                            </div>
                            <div id="CEXTN_div_sameunitdiffrm" class="" hidden style="padding-left: 20px">
                                <div class="form-group">
                                    <label class="col-sm-3" id="CEXTN_lbl_sameunitdiffrmuno">UNIT NUMBER</label>
                                    <div class="col-sm-2"><input type="text" name="CEXTN_tb_sameunitdiffrmuno" id="CEXTN_tb_sameunitdiffrmuno" style="width:60px;" class=" form-control" readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3" id="CEXTN_lbl_sameunitdiffrmrmtype">ROOM TYPE<em>*</em></label>
                                    <div class="col-sm-3">
                                        <select name="CEXTN_lb_sameunitdiffrmrmtype" id="CEXTN_lb_sameunitdiffrmrmtype" class="form-control"></select>
                                    </div>
                                </div>
                                <div id="CTERM_tbl_sameunitdiffrmcust_card" hidden></div>
                            </div>
                        </div>
                        <div class="col-sm-offset-3">
                            <div class="radio" style="padding-left: 15px">
                                <label>
                                    <input type="radio" name="CEXTN_radio_unit" id="CEXTN_radio_diffunit" value="CEXTN_radio_diffunit" class="CEXTN_btn_validate_class" />
                                    DIFFERENT UNIT</label><div id="CEXTN_div_nodiffuniterr" class="errormsg"></div>
                            </div>
                            <div id="CEXTN_div_diffunit" hidden style="padding-left: 18px">
                                <div class="form-group">
                                    <label class="col-sm-3" id="CEXTN_lbl_diffunituno">UNIT NUMBER<em>*</em></label>
                                    <div class="col-sm-3"><select id="CEXTN_lb_diffunituno" name="CEXTN_lb_diffunituno" class="CEXTN_btn_validate_class form-control">
                                        </select>
                                    </div>
                                    <div id="CEXTN_div_normtypeerr" class="errormsg"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3" id="CEXTN_lbl_diffunitrmtype" hidden>ROOM TYPE<em>*</em></label>
                                    <div class="col-sm-3">
                                        <select id="CEXTN_lb_diffunitrmtype" name="CEXTN_lb_diffunitrmtype" class="CEXTN_btn_validate_class form-control" style="display:none" hidden>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="CEXTN_lbl_diffunitselectcard" hidden>SELECT THE CARD<em>*</em></label>
                                    <div class="col-sm-3">
                                        <div class="radio">
                                            <label id="CEXTN_lbl_diffunitcard" hidden>
                                                <input type="radio" name="CEXTN_radio_difunitcard" id="CEXTN_radio_difunitcardno"  value="CEXTN_radio_difunitcardno" class="CEXTN_btn_validate_class" hidden />
                                                CARD NUMBER</label><label id="CEXTN_div_custerrmsg" class="errormsg" hidden></label>
                                        </div>
                                    </div>
                                </div>
                                <div id="CEXTN_div_diffunitcardlist" hidden>
                                    <div id="CEXTN_tble_diffunitcardlist" class="CEXTN_btn_validate_class"></div>
                                </div>
                                <div id="CEXTN_div_diffunitnocarderrmsg" class="errormsg" ></div>
                                <div class="radio">
                                    <label id="CEXTN_lbl_diffunitnull" hidden>
                                        <input type="radio" name="CEXTN_radio_difunitcard" id="CEXTN_radio_difunitnullcard"  value="CEXTN_radio_difunitnullcard" class="CEXTN_btn_validate_class" hidden/>
                                        NULL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" row form-group">
                        <label class="col-sm-3">INITIAL CHECK IN DATE </label>
                        <div class="col-sm-2">
                            <input type="text" name="CEXTN_db_prevchkindate" id="CEXTN_db_prevchkindate" style="width:110px;" class="rdonly form-control" readonly />
                            <input type="hidden" name="CEXTN_hidden_prechkinfromtime" id="CEXTN_hidden_prechkinfromtime"><input type="hidden" name="CEXTN_hidden_prechkintotime" id="CEXTN_hidden_prechkintotime">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-sm-3" id="CEXTN_lbl_chkindate">CURRENT CHECK OUT DATE </label>
                        <div class="col-sm-2">
                            <input type="text" name="CEXTN_db_chkindate" id="CEXTN_db_chkindate" style="width:110px;" class="rdonly form-control" readonly />
                        </div>
                        <div class="col-sm-2 colsmhf">
                            <select id="CEXTN_lb_chkinfromtime" name="CEXTN_lb_chkinfromtime"  style="width:110px;" class="CEXTN_btn_validate_class form-control col-sm-2" hidden><option>SELECT</option>
                            </select></div>
                        <label  id="CEXTN_lbl_chkinto" style="width:35px;" class="col-sm-2" hidden>TO</label>
                        <div class="col-sm-3">
                            <select id="CEXTN_lb_chkintotime" name="CEXTN_lb_chkintotime"  style="width:110px;" class="CEXTN_btn_validate_class form-control" hidden><option>SELECT</option></select>
                        </div>
                        <input type="hidden" name="CEXTN_hidden_chkinfromtime" id="CEXTN_hidden_chkinfromtime"><input type="hidden" name="CEXTN_hidden_chkintotime" id="CEXTN_hidden_chkintotime">
                        <div class="errormsg" id="CEXTN_usdatexpiremsg"></div>
                    </div>
                    <div class="row form-group">
                        <label class="col-sm-3">NEW CHECK OUT DATE<em>*</em></label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" name="CEXTN_db_chkoutdate" id="CEXTN_db_chkoutdate" maxlength="10" class="CEXTN_class_prowaiv datemandtry CEXTN_btn_validate_class form-control"  placeholder="CHECK OUT DATE" />
                                <label for="CEXTN_db_chkoutdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                        <div class="col-sm-2 colsmhf">
                            <select id="CEXTN_lb_chkoutfromtime" name="CEXTN_lb_chkoutfromtime" style="width:110px;display:none;" class="CEXTN_btn_validate_class form-control col-sm-2" hidden><option>SELECT</option>
                            </select>
                        </div>
                        <label  id="CEXTN_lbl_chkoutto" style="width:35px;" class="col-sm-2" hidden>TO</label>
                        <div class="col-sm-3">
                            <select id="CEXTN_lb_chkouttotime" name="CEXTN_lb_chkouttotime"  style="width:110px;display:none;" class="CEXTN_btn_validate_class form-control" hidden><option>SELECT</option></select>
                        </div>
                        <div class="errormsg" id="CEXTN_uedatexpiremsg"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">NOTICE PERIOD</label>
                        <div class="col-sm-2"><input type="text" name="CEXTN_tb_noticeperiod" id="CEXTN_tb_noticeperiod" style="width:45px;" class="form-control" placeholder="NP"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">NOTICE PERIOD DATE</label>
                        <div class="col-sm-2">
                            <div class="input-group addon">
                                <input type="text" name="CEXTN_db_noticeperioddate" id="CEXTN_db_noticeperioddate" class="CEXTN_class_prowaiv CEXTN_btn_validate_class datenonmandtry form-control" maxlength="10" style="width:110px;" placeholder="Notice Date"/>
                                <label for="CEXTN_db_noticeperioddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">SELECT AIRCON FEE</label>
                        <div class="col-sm-offset-3 " style="padding-left: 15px">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <div class="radio " style="padding-bottom: 20px">
                                        <label >
                                            <input type="radio" name="CEXTN_radio_airconfee" id="CEXTN_radio_quartairconfee" value="CEXTN_radio_quartairconfee" class="CEXTN_btn_validate_class"/>
                                            QUARTERLY SERVICE FEE
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" name="CEXTN_tb_airquarterfee" id="CEXTN_tb_airquarterfee" style="width:77px;" maxlength="7" class="3digitdollaronly CEXTN_btn_validate_class form-control" placeholder="0.00" hidden />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-offset-3 " style="padding-left: 15px">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <div class="radio " style="padding-bottom: 20px">
                                        <label >
                                            <input type="radio" name="CEXTN_radio_airconfee" id="CEXTN_radio_fixedairconfee" value="CEXTN_radio_fixedairconfee" class="CEXTN_btn_validate_class " />
                                            FIXED AIRCON FEE
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" name="CEXTN_tb_fixedairfee" id="CEXTN_tb_fixedairfee" style="width:77px;" maxlength="7" class="3digitdollaronly CEXTN_btn_validate_class form-control" placeholder="0.00" hidden/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">SAME/DIFFERENT AMOUNT<em>*</em></label>
                        <div class="radio col-sm-offset-3" style="padding-left: 15px" >
                            <label >
                                <input type="radio" name="CEXTN_radio_amt" id="CEXTN_radio_sameamt" value="CEXTN_radio_sameamt" checked="checked" class="CEXTN_class_prowaiv CEXTN_btn_validate_class" / >
                                SAME AMOUNT
                            </label>
                        </div>
                        <div id="CEXTN_div_sameamt">
                            <div id="CEXTN_tble_sameamt" class="col-sm-offset-3" style="padding-left: 15px">
                                <div class="form-group">
                                    <label class="col-sm-3" id="CEXTN_lbl_sameamtdep">DEPOSIT</label>
                                    <div class="col-sm-2">
                                        <input type="text" name="CEXTN_tb_sameamtdep" id="CEXTN_tb_sameamtdep" style="width:77px;height: 34px" class="rdonly" readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-3" id="CEXTN_lbl_sameamtrent">RENT</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="CEXTN_tb_sameamtrent" id="CEXTN_tb_sameamtrent" style="width:77px;height: 34px" class="rdonly" readonly />
                                        <input type="checkbox" name="CEXTN_cb_sameamtprorated" id="CEXTN_cb_sameamtprorated" disabled /><label id="CEXTN_lbl_sameamtprorated"></label><input type="hidden" name="CEXTN_hidden_sameamtprorated" id="CEXTN_hidden_sameamtprorated" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3" id="CEXTN_lbl_sameamtprocost">PROCESSING COST</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="CEXTN_tb_sameamtprocost" id="CEXTN_tb_sameamtprocost" style="width:77px;height: 34px" class="rdonly" readonly />
                                        <input type="checkbox" name="CEXTN_cb_sameamtwaived" id="CEXTN_cb_sameamtwaived" class="CEXTN_btn_validate_class" disabled /><label id="CEXTN_lbl_sameamtwaived"></label><input type="hidden" id="CEXTN_hidden_sameamtwaived" name="CEXTN_hidden_sameamtwaived"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="radio col-sm-offset-3" style="padding-left: 15px">
                            <label >
                                <input type="radio" name="CEXTN_radio_amt" id="CEXTN_radio_diffamt"  value="CEXTN_radio_diffamt" class="CEXTN_class_prowaiv CEXTN_btn_validate_class" / >
                                DIFFERENT AMOUNT
                            </label>
                        </div>
                        <div id="CEXTN_div_diffamt" hidden>
                            <div id="CEXTN_tble_diffamt" class="col-sm-offset-3" style="padding-left: 15px">
                                <div class="form-group">
                                    <label class="col-sm-3" id="CEXTN_lbl_diffamtdep">DEPOSIT</label>
                                    <div class="col-sm-2">
                                        <input type="text" name="CEXTN_tb_diffamtdep" id="CEXTN_tb_diffamtdep" style="width:85px;" class="5digitdollaronly CEXTN_btn_validate_class form-control" placeholder="0.00"/>
                                    </div>
                                    <<div class="col-sm-4">
                                        <p id="CEXTN_diffamtdeposit_err" class="errormsg"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3" id="CEXTN_lbl_diffamtrent">RENT<em>*</em></label>
                                    <div class="col-sm-6">
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <input type="text" name="CEXTN_tb_diffamtrent" id="CEXTN_tb_diffamtrent" style="width:85px;" class="CEXTN_class_prowaiv 5digitdollaronly CEXTN_btn_validate_class form-control" placeholder="0.00"/>
                                            </div>
                                            <div class="col-md-2" style="padding-right:10px;width:10px">
                                                <input type="checkbox" name="CEXTN_cb_diffamtprorated" id="CEXTN_cb_diffamtprorated"  class="CEXTN_btn_validate_class" disabled />
                                            </div>
                                            <div class="col-md-3"><label id="CEXTN_lbl_diffamtprorated"></label><input type="hidden" name="CEXTN_hidden_diffamtprorated" id="CEXTN_hidden_diffamtprorated" /></div>
                                            <div class="col-md-6"><p id="CEXTN_diffamtrent_err" class="errormsg"></p></div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" row form-group">
                                    <label class="col-sm-3" id="CEXTN_lbl_diffamtprocost">PROCESSING COST</label>
                                    <div class="col-sm-6">
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <input type="text" name="CEXTN_tb_diffamtprocost" id="CEXTN_tb_diffamtprocost" style="width:77px;" maxlength="7" class="CEXTN_class_prowaiv CEXTN_btn_validate_class form-control" placeholder="0.00"/>
                                            </div>
                                            <div class="col-md-1" style="padding-right:10px;width:10px">
                                                <input type="checkbox" name="CEXTN_cb_diffamtwaived" id="CEXTN_cb_diffamtwaived" class="CEXTN_class_prowaiv CEXTN_btn_validate_class" disabled  />
                                            </div>
                                            <div class="col-md-3"><label id="CEXTN_lbl_diffamtwaived"></label><input type="hidden" id="CEXTN_hidden_diffamtwaived" name="CEXTN_hidden_diffamtwaived"/></div>
                                            <div class="col-md-8" style="padding-right:10px"><p id="CEXTN_diffamtprofee_err" class="errormsg"></p></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">ELECTRICITY CAPPED</label>
                        <div class="col-sm-2"><input type="text" name="CEXTN_tb_electcapfee" id="CEXTN_tb_electcapfee" style="width:77px;" maxlength="7" class="3digitdollaronly CEXTN_btn_validate_class form-control" placeholder="0.00"/>
                            <p id="CEXTN_electcap_err" class="errormsg"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">CURTAIN DRY CLEANING FEE</label>
                        <div class="col-sm-2"><input type="text" name="CEXTN_tb_curtaindryfee" id="CEXTN_tb_curtaindryfee" style="width:77px;" maxlength="7" class="3digitdollaronly CEXTN_btn_validate_class form-control" placeholder="0.00"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">CHECKOUT CLEANING FEE</label>
                        <div class="col-sm-2"><input type="text" name="CEXTN_tb_chkoutcleanfee" id="CEXTN_tb_chkoutcleanfee" style="width:77px;" maxlength="7" class="3digitdollaronly CEXTN_btn_validate_class form-control" placeholder="0.00"/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">E-MAIL ID<em>*</em></label>
                        <div class="col-sm-4"><select id="CEXTN_lb_emailid" name="CEXTN_lb_emailid" class="CEXTN_btn_validate_class form-control"><option>SELECT</option></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3">COMMENTS</label>
                        <div class="col-sm-4"><textarea  style="min-height: 116px;" name="CEXTN_ta_comments" id="CEXTN_ta_comments" class="CEXTN_btn_validate_class form-control" rows="5"></textarea></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>FILE UPLOAD</label>
                        </div>
                        <div class="col-md-3">
                            <input type="file" id="CEXTN_fileupload" name="CEXTN_fileupload" class="form-control CEXTN_fileextensionchk" />
                        </div>
                    </div>

                    <div  id="CEXTN_div_save">
                        <div class="row form-group">
                            <div class="col-lg-offset-2 col-lg-3">
                                <input  type="button" value="EXTEND" id="CEXTN_btn_save" class="btn" disabled /><input type="button" value="RESET"  id="CEXTN_btn_reset" class="btn"/>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="CEXTN_slctcustlbl" id="CEXTN_slctcustlbl">

    </form>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->