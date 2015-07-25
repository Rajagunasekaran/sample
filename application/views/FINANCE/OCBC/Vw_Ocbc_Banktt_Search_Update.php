<!--********************************************OCBC BANK TT SEARCH/UPDATE*******************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 15.1 -SD:09/07/2015 ED:09/07/2015 GET DATA FROM DB INSTEAD OF GET FROM FLEX TABLE FOR UPDATE FORM,SAVE POINT,INCLUDED COL-REORDER->
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
    textarea{
        min-height:116px;
    }
</style>
<script>
    $(document).ready(function(){
        $('#spacewidth').height('0%');
        $('#BankTT_Updation_Form').hide();
        var controller_url="<?php echo base_url(); ?>" + '/index.php/FINANCE/OCBC/Ctrl_Ocbc_Banktt_Search_Update/' ;
        var Allunits;
        var SRC_ErrorMsg;
        var modelnames;
        $('.amtonly').doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $('.autogrowcomments').autogrow({onInitialize: true});
        $("#Banktt_SRC_Accno").doValidation({rule:'numbersonly',prop:{realpart:25,leadzero:true}});
        $(".autosize").doValidation({rule:'general',prop:{whitespace:true,autosize:true}});
        $("#Banktt_SRC_Bankcode").doValidation({rule:'numbersonly',prop:{realpart:4,leadzero:true}});
        $("#Banktt_SRC_Branchcode").doValidation({rule:'numbersonly',prop:{realpart:3,leadzero:true}});
        $("#Banktt_SRC_Date").datepicker({dateFormat:'dd-mm-yy',changeYear: true,changeMonth: true});
        $('#Banktt_SRC_Date').datepicker("option","maxDate",new Date());
        $('#Banktt_SRC_Debitedon').datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        $.ajax({
            type: "POST",
            url: controller_url+"Banktt_initialdatas",
            data:{'ErrorList':'1,2,4,6,45,247,385,401'},
            success: function(data){
                var value=JSON.parse(data);
                var searchoption=value[0];
                Allunits=value[2];
                SRC_ErrorMsg=value[1];
                modelnames=value[3];
                var searchoptions='<OPTION>SELECT</OPTION>';
                var statusoptions='<OPTION>SELECT</OPTION>';
                var chargestooptions='<OPTION>SELECT</OPTION>';
                var createdbyoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < searchoption.length; i++)
                {
                    var data=searchoption[i];
                    if(data.CGN_ID==56)
                    {
                        searchoptions += '<option value="' + data.BCN_ID + '">' + data.BCN_DATA + '</option>';
                    }
                    if(data.CGN_ID==70)
                    {
                        if(data.BCN_ID!=13 && data.BCN_ID!=14)
                        {
                            statusoptions += '<option value="' + data.BCN_DATA + '">' + data.BCN_DATA + '</option>';
                        }
                    }
                    if(data.CGN_ID==71)
                    {
                        chargestooptions += '<option value="' + data.BCN_DATA + '">' + data.BCN_DATA + '</option>';
                    }
                    if(data.CGN_ID==72)
                    {
                        createdbyoptions += '<option value="' + data.BCN_DATA + '">' + data.BCN_DATA + '</option>';
                    }
                }
                $('#Banktt_SRC_Status').html(statusoptions);
                $('#Banktt_SRC_Chargesto').html(chargestooptions);
                $('#Banktt_SRC_Createdby').html(createdbyoptions);
                var modeloptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < modelnames.length; i++)
                {
                    var data=modelnames[i];
                    modeloptions += '<option value="' + data.BTM_DATA + '">' + data.BTM_DATA + '</option>';
                }
                $('#Banktt_SRC_SearchOption').html(searchoptions);
                $('#Banktt_SRC_Modelnames').html(modeloptions);
                $('.preloader').hide();
            },
            error: function(data){
                show_msgbox("BANK TT ENTRY",'error in getting'+JSON.stringify(data),"error",false);
            }
        });
        var AllaccnameArray=[];
        $(document).on('change','#Banktt_SRC_SearchOption',function() {
            $('#Banktt_Search_DataTable').hide();
            $('#BankTT_Updation_Form').hide();
            $('#tableheader').text('');
            $('#emptytableheader').text('');
            var searchoption=$('#Banktt_SRC_SearchOption').val();
            if(searchoption==1)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">UNIT NUMBER SEARCH</h4><br>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>UNIT NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control" name="Banktt_SRC_Uintsearch"  id="Banktt_SRC_Uintsearch" style="max-width: 120px"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                var unitoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < Allunits.length; i++)
                {
                    var data=Allunits[i];
                    unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                $('#Banktt_SRC_Uintsearch').html(unitoptions);
                $('.preloader').hide();
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            }
            if(searchoption==2)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">CUSTOMER NAME SEARCH</h4><br>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>UNIT NO<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control customer_btn_validation" name="Banktt_SRC_unit"  id="Banktt_SRC_unit" style="max-width: 120px"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control customer_btn_validation" name="Banktt_SRC_Customer"  id="Banktt_SRC_Customer" disabled><option>SELECT</option></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                var unitoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < Allunits.length; i++)
                {
                    var data=Allunits[i];
                    unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                $('#Banktt_SRC_unit').html(unitoptions);
                $('.preloader').hide();
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            }
            if(searchoption==3)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">DATE RANGE SEARCH</h4><br>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>FROM DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-9"><div class="col-sm-3" style="padding-left: 0px;"><div class="input-group addon"><input type="text" class="form-control Date_btn_validation datemandtry" name="Banktt_SRC_fromdate" id="Banktt_SRC_fromdate"  placeholder="From Date"><label  class="input-group-addon" for=Banktt_SRC_fromdate><span class="glyphicon glyphicon-calendar"></span></label></div></div></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>TO DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-9"><div class="col-sm-3" style="padding-left: 0px;"><div class="input-group addon"><input type="text" class="form-control Date_btn_validation datemandtry" name="Banktt_SRC_todate" id="Banktt_SRC_todate"  placeholder="To Date"><label  class="input-group-addon" for=Banktt_SRC_todate><span class="glyphicon glyphicon-calendar"></span></label></div></div></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                $("#Banktt_SRC_fromdate").datepicker({
                    dateFormat: "dd-mm-yy",
                    changeYear: true,
                    changeMonth: true});
                var CCRE_d = new Date();
                var changedmonth=new Date(CCRE_d.setFullYear(2009));
                $('#Banktt_SRC_fromdate').datepicker("option","minDate",changedmonth);
                $('#Banktt_SRC_fromdate').datepicker("option","maxDate",changeyear);
                $("#Banktt_SRC_fromdate").focus();
                $('.preloader').hide();
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            }
            if(searchoption==5)
            {
                var appenddata='<BR><h4 style="color:#498af3;">AMOUNT RANGE SEARCH</h4><BR>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>FROM AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input type=text class="form-control amountonly Amount_btn_validation" name="Banktt_SRC_FromAmount"  id="Banktt_SRC_FromAmount" style="max-width:120px;" /></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>TO AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-2"><input type=text class="form-control amountonly Amount_btn_validation" name="Banktt_SRC_ToAmount"  id="Banktt_SRC_ToAmount" style="max-width:120px;" /></div>';
                appenddata+='<div class="col-md-6"><label id="Banktt_SRC_lbl_amounterrormsg" class="errormsg" hidden></label></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
                $('#Banktt_SRC_lbl_amounterrormsg').text(SRC_ErrorMsg[4].EMC_DATA);
                $("#Banktt_SRC_FromAmount").focus();
                $('.preloader').hide();
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            }
            if(searchoption==6)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">MODEL NAME SEARCH</h4><br>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>MODEL NAME<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control" name="Banktt_SRC_Modelsearch"  id="Banktt_SRC_Modelsearch"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                var modeloptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < modelnames.length; i++)
                {
                    var data=modelnames[i];
                    modeloptions += '<option value="' + data.BTM_DATA + '">' + data.BTM_DATA + '</option>';
                }
                $('#Banktt_SRC_Modelsearch').html(modeloptions);
                $('.preloader').hide();
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            }
            else if(searchoption==4)
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"Banktt_getAccname",
                    success: function(data){
                        var value_array=JSON.parse(data);
                        var appenddata='<BR><h4 style="color:#498af3;">ACCOUNT NAME SEARCH</h4><BR>';
                        appenddata+='<div class="row form-group">';
                        appenddata+='<div class="col-md-2"><label>ACCOUNT NAME<span class="labelrequired"><em>*</em></span></label></div>';
                        appenddata+='<div class="col-md-3"><input type=text class="form-control contactnoautovalidate" name="Banktt_SRC_accname"  id="Banktt_SRC_accname"/></div>';
                        appenddata+='<div class="col-md-5"><label id="autocompleteerrormsg" class="errormsg" hidden></label></div>';
                        appenddata+='</div>';
                        appenddata+='<div class="row form-group">';
                        appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                        appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                        $('#Banktt_SearchformDiv').html(appenddata);
                        for (var i = 0; i < value_array.length; i++)
                        {
                            var data=value_array[i].BT_ACC_NAME;
                            AllaccnameArray.push(data);
                        }
                        $('#autocompleteerrormsg').text(SRC_ErrorMsg[6].EMC_DATA);
                        $("#Banktt_SRC_accname").focus();
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error: function(data){
                        show_msgbox("BANKTT/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                        $('.preloader').hide();
                    }
                });
            }
        });
        var Banktt_chequeflag;
        $(document).on('keypress','#Banktt_SRC_accname',function() {
            Banktt_chequeflag=0;
            BANKTT_SEARCH_invfromhighlightSearchText();
            $("#Banktt_SRC_accname").autocomplete({
                source: AllaccnameArray,
                select: BANKTT_SEARCH_AutoCompleteSelectHandler
            });
        });
        function BANKTT_SEARCH_AutoCompleteSelectHandler(event, ui) {
            Banktt_chequeflag=1;
            $('#autocompleteerrormsg').hide();
            $('#Banktt_src_btn_search').removeAttr("disabled");
        }
        $(document).on('change','.contactnoautovalidate',function(){
            $('#tableheader').text('');
            $('#emptytableheader').text('');
            $('#Banktt_Search_DataTable').hide();
            if(Banktt_chequeflag==1){
                $('#autocompleteerrormsg').hide();
            }
            else
            {
                $('#autocompleteerrormsg').show();
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
            if($('#Banktt_SRC_accname').val()=="")
            {
                $('#autocompleteerrormsg').hide();
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        //FUNCTION TO HIGHLIGHT SEARCH TEXT//
        function BANKTT_SEARCH_invfromhighlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            };}
        $(document).on('change','#Banktt_SRC_unit',function() {
            $('.preloader').show();
            var unit=$('#Banktt_SRC_unit').val();
            if(unit!='SELECT')
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"Banktt_customer",
                    data:{Unit:unit},
                    success: function(data){
                        var valuearray=JSON.parse(data);
                        var customeroptions='<OPTION>SELECT</OPTION>';
                        for (var i = 0; i < valuearray.length; i++)
                        {
                            var data=valuearray[i];
                            customeroptions += '<option value="' + data.CUSTOMER_FIRST_NAME+'_'+data.CUSTOMER_LAST_NAME + '">' + data.CUSTOMER_FIRST_NAME+' '+data.CUSTOMER_LAST_NAME + '</option>';
                        }
                        $('#Banktt_SRC_Customer').html(customeroptions);
                        $('#Banktt_SRC_Customer').prop("disabled", false);
                        $('.preloader').hide();
                    },
                    error: function(data){
                        show_msgbox("BANK TT ENTRY",'error in getting'+JSON.stringify(data),"error",false);
                        $('.preloader').hide();
                    }
                });
            }
            else
            {
                $('#Banktt_SRC_Customer').prop("disabled", true);
                $('#Banktt_SRC_Customer').val('SELECT');
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
                $('.preloader').hide();
            }
        });
        //PAIDDATE TO DATE PICKER
        var CCRE_d = new Date();
        var maxyear=CCRE_d.getFullYear()+parseInt(2);
        var changeyear=new Date(CCRE_d.setFullYear(maxyear));
        $(document).on('change','#Banktt_SRC_fromdate',function() {
            $("#Banktt_SRC_todate").datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true});
            var to_mindate=Form_dateConversion($('#Banktt_SRC_fromdate').val());
            $('#Banktt_SRC_todate').datepicker("option","minDate",to_mindate);
            $('#Banktt_SRC_todate').datepicker("option","maxDate",changeyear);
        });
        function Form_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[2],inputdate[1]-1,parseInt(inputdate[0])+parseInt(1));
            return newunitstartdate;
        }
        //MODEL NAME SEARCH BUTTON VALIDATION
        $(document).on('change','#Banktt_SRC_Modelsearch',function() {
            $('#tableheader').text('');
            $('#emptytableheader').text('');
            $('#Banktt_Search_DataTable').hide();
            if($('#Banktt_SRC_Modelsearch').val()!='SELECT')
            {
                $('#Banktt_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        //UNIT SEARCH BUTTON VALIDATION
        $(document).on('change','#Banktt_SRC_Uintsearch',function() {
            $('#tableheader').text('');
            $('#emptytableheader').text('');
            $('#Banktt_Search_DataTable').hide();
            if($('#Banktt_SRC_Uintsearch').val()!='SELECT')
            {
                $('#Banktt_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        //CUSTOMER SEARCH BUTTON VALIDATION
        $(document).on('change','.customer_btn_validation',function() {
            $('#tableheader').text('');
            $('#emptytableheader').text('');
            $('#Banktt_Search_DataTable').hide();
            if($('#Banktt_SRC_unit').val()!='SELECT' && $('#Banktt_SRC_Customer').val()!='SELECT' && $('#Banktt_SRC_Customer').val()!=undefined && $('#Banktt_SRC_Customer').val()!='')
            {
                $('#Banktt_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        //DATE SEARCH BUTTON VALIDATION
        $(document).on('change','.Date_btn_validation',function() {
            $('#tableheader').text('');
            $('#emptytableheader').text('');
            $('#Banktt_Search_DataTable').hide();
            if($('#Banktt_SRC_fromdate').val()!='' && $('#Banktt_SRC_todate').val()!='')
            {
                $('#Banktt_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        $(document).on('change','.Amount_btn_validation',function() {
            $('#tableheader').text('');
            $('#emptytableheader').text('');
            $('#Banktt_Search_DataTable').hide();
            var Banktt_SRC_fromamt=$('#Banktt_SRC_FromAmount').val();
            var Banktt_SRC_toamt=$('#Banktt_SRC_ToAmount').val();
            if(Banktt_SRC_fromamt!='' && Banktt_SRC_toamt!='')
            {
                if(parseFloat(Banktt_SRC_fromamt)<=parseFloat(Banktt_SRC_toamt))
                {
                    $("#Banktt_src_btn_search").removeAttr("disabled");
                    $('#Banktt_SRC_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#Banktt_SRC_lbl_amounterrormsg').show();
                    $("#Banktt_src_btn_search").attr("disabled", "disabled");
                }
            }
            else
            {
                $('#Banktt_SRC_lbl_amounterrormsg').hide();
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        var BT_id=[];
        $(document).on('click','#Banktt_src_btn_search',function() {
            $('#BankTT_Updation_Form').hide();
            var searchoption=$('#Banktt_SRC_SearchOption').val();
            $("#Banktt_src_btn_search").attr("disabled", "disabled");
            $('#tableheader').text('');
            $('#emptytableheader').text('');
            $('.preloader').show();
            if(searchoption==1)
            {
                var unit=$('#Banktt_SRC_Uintsearch').val();
                var inputdata={"Option":1,"Unit":unit,"Customer":''};
                var header="DETAILS OF SELECTED UNIT : "+unit;
                var emptyheader="NO DETAILS OF SELECTED UNIT : "+unit;
            }
            if(searchoption==2)
            {
                var unit=$('#Banktt_SRC_unit').val();
                var customer=$('#Banktt_SRC_Customer').val()
                var inputdata={"Option":2,"Unit":unit,Customer:customer};
                var customerheader=customer.replace('_',' ');
                var header="DETAILS OF SELECTED UNIT : "+unit +" AND CUSTOMER : "+customerheader;
                var emptyheader="NO DETAILS OF SELECTED UNIT : "+unit +" AND CUSTOMER : "+customerheader;
            }
            if(searchoption==4)
            {
                var accname=$('#Banktt_SRC_accname').val();
                var inputdata={"Option":4,"Unit":accname,Customer:''};
                var header="DETAILS OF SELECTED ACC NAME : "+accname;
                var emptyheader="NO DETAILS OF SELECTED ACC NAME : "+accname;
            }
            if(searchoption==3)
            {
                var fromdate=$('#Banktt_SRC_fromdate').val();
                var todate=$('#Banktt_SRC_todate').val();
                var inputdata={"Option":3,"Unit":fromdate,Customer:todate};
                var header="DETAILS OF SELECTED DATE RANGE : "+fromdate+" TO "+todate;
                var emptyheader="NO DETAILS OF SELECTED DATE RANGE : "+fromdate+" TO "+todate;
            }
            if(searchoption==5)
            {
                var Banktt_SRC_fromamt=$('#Banktt_SRC_FromAmount').val();
                var Banktt_SRC_toamt=$('#Banktt_SRC_ToAmount').val();
                var inputdata={"Option":5,"Unit":Banktt_SRC_fromamt,Customer:Banktt_SRC_toamt};
                var header="DETAILS OF SELECTED AMOUNT RANGE : "+Banktt_SRC_fromamt+" TO "+Banktt_SRC_toamt;
                var emptyheader="NO DETAILS OF SELECTED AMOUNT RANGE : "+Banktt_SRC_fromamt+" TO "+Banktt_SRC_toamt;
            }
            if(searchoption==6)
            {
                var modelname=$('#Banktt_SRC_Modelsearch').val();
                var inputdata={"Option":6,"Unit":modelname,Customer:''};
                var header="DETAILS OF SELECTED MODEL : "+modelname;
                var emptyheader="NO DETAILS OF SELECTED MODEL : "+modelname;
            }
            $.ajax({
                type: "POST",
                url: controller_url+"Banktt_Search_Details",
                data:inputdata,
                success: function(data){
                    var valuearray = JSON.parse(data);
                    if(valuearray.length!=0) {
                        var tabledata = '<table style="width:3500px" id="Banktt_Datatable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr>';
                        tabledata += "<th style='width:80px !important;text-align: center'>EDIT/UPDATE</th>";
                        tabledata += "<th style='width:130px !important;text-align: center'>TRANSACTION TYPE<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='width:100px !important;text-align: center' class='uk-date-column'>DATE<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='width:150px !important;text-align: center'>ACCOUNT NAME<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='width:150px !important;text-align: center'>ACCOUNT NO<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='width:120px !important;text-align: center'>AMOUNT<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='width:100px !important;text-align: center'>UNIT</th>";
                        tabledata += "<th style='width:150px !important;text-align: center'>CUSTOMER<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='width:100px !important;text-align: center'>STATUS<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='width:150px !important;text-align: center' class='uk-date-column'>DEBITED / REJECTED DATE<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='width:120px !important;text-align: center'>BANK CODE</th>";
                        tabledata += "<th style='width:120px !important;text-align: center'>BRANCH CODE</th>";
                        tabledata += "<th style='width:200px !important;text-align: center'>BANK ADDRESS</th>";
                        tabledata += "<th style='width:150px !important;text-align: center'>SWIFT CODE</th>";
                        tabledata += "<th style='width:150px !important;text-align: center'>CHARGES TO</th>";
                        tabledata += "<th style='width:200px !important;text-align: center'>CUST REF</th>";
                        tabledata += "<th style='width:200px !important;text-align: center'>INV DETAILSS</th>";
                        tabledata += "<th style='width:200px !important;text-align: center'>COMMENTS</th>";
                        tabledata += "<th style='width:150px !important;text-align: center'>CREATED BY</th>";
                        tabledata += "<th style='width:150px !important;text-align: center'>USERSTAMP</th>";
                        tabledata += "<th style='width:150px !important;text-align: center' class='uk-timestp-column'>TIMESTAMP</th>";
                        tabledata += "</tr></thead><tbody>";
                        for (var i = 0; i < valuearray.length; i++) {
                            var Ermid = valuearray[i].BT_ID;
                            BT_id.push(Ermid)
                            var edit = "Editid_" + valuearray[i].BT_ID;
                            var del = "Deleteid_" + valuearray[i].BT_ID;
                            if (valuearray[i].BT_ACC_NAME == null) {
                                var accname = '';
                            } else {
                                accname = valuearray[i].BT_ACC_NAME;
                            }
                            if (valuearray[i].BT_ACC_NO == null) {
                                var accno = '';
                            } else {
                                accno = valuearray[i].BT_ACC_NO;
                            }
                            if (valuearray[i].UNIT_NO == null) {
                                var unit = '';
                            } else {
                                unit = valuearray[i].UNIT_NO;
                            }
                            if (valuearray[i].CUSTOMERNAME == null) {
                                var customer = '';
                            } else {
                                customer = valuearray[i].CUSTOMERNAME;
                            }
                            if (valuearray[i].TRANSACTION_STATUS == null) {
                                var status = '';
                            } else {
                                status = valuearray[i].TRANSACTION_STATUS;
                            }
                            if (valuearray[i].BT_DEBITED_ON == null) {
                                var debitedon = '';
                            } else {
                                debitedon = valuearray[i].BT_DEBITED_ON;
                            }
                            if (valuearray[i].BT_BANK_CODE == null) {
                                var bankcode = '';
                            } else {
                                bankcode = valuearray[i].BT_BANK_CODE;
                            }
                            if (valuearray[i].BT_BRANCH_CODE == null) {
                                var branchcode = '';
                            } else {
                                branchcode = valuearray[i].BT_BRANCH_CODE;
                            }
                            if (valuearray[i].BT_BANK_ADDRESS == null) {
                                var bankaddress = '';
                            } else {
                                bankaddress = valuearray[i].BT_BANK_ADDRESS;
                            }
                            if (valuearray[i].BT_SWIFT_CODE == null) {
                                var swiftcode = '';
                            } else {
                                swiftcode = valuearray[i].BT_SWIFT_CODE;
                            }
                            if (valuearray[i].BANK_TRANSFER_CHARGES_TO == null) {
                                var chargesto = '';
                            } else {
                                chargesto = valuearray[i].BANK_TRANSFER_CHARGES_TO;
                            }
                            if (valuearray[i].BT_CUST_REF == null) {
                                var custoref = '';
                            } else {
                                custoref = valuearray[i].BT_CUST_REF;
                            }
                            if (valuearray[i].BT_INV_DETAILS == null) {
                                var invdetails = '';
                            } else {
                                invdetails = valuearray[i].BT_INV_DETAILS;
                            }
                            if (valuearray[i].BT_COMMENTS == null) {
                                var comments = '';
                            } else {
                                comments = valuearray[i].BT_COMMENTS;
                            }
                            if (valuearray[i].BANK_TRANSFER_CREATED_BY == null) {
                                var createdby = '';
                            } else {
                                createdby = valuearray[i].BANK_TRANSFER_CREATED_BY;
                            }
                            tabledata += '<tr id=' + valuearray[i].BT_ID + '>' +
                                "<td ><div class='col-lg-2'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit Banktt_editbutton' id=" + edit + "></div></td>" +
                                "<td >" + valuearray[i].BANK_TRANSFER_TYPE + "</td>" +
                                "<td  >" + valuearray[i].BT_DATE + "</td>" +
                                "<td>" + accname + "</td>" +
                                "<td>" + accno + "</td>" +
                                "<td>" + valuearray[i].BT_AMOUNT + "</td>" +
                                "<td>" + unit + "</td>" +
                                "<td>" + customer + "</td>" +
                                "<td>" + status + "</td>" +
                                "<td>" + debitedon + "</td>" +
                                "<td>" + bankcode + "</td>" +
                                "<td>" + branchcode + "</td>" +
                                "<td>" + bankaddress + "</td>" +
                                "<td>" + swiftcode + "</td>" +
                                "<td>" + chargesto + "</td>" +
                                "<td>" + custoref + "</td>" +
                                "<td>" + invdetails + "</td>" +
                                "<td>" + comments + "</td>" +
                                "<td>" + createdby + "</td>" +
                                "<td>" + valuearray[i].ULD_LOGINID + "</td>" +
                                "<td>" + valuearray[i].BT_TIME_STAMP + "</td>" +
                                "</tr>";
                        }
                        tabledata += "</body>";
                        $('#tableheader').text(header);
                        $('section').html(tabledata);
                        $('#Banktt_Search_DataTable').show();
                        $('.preloader').hide();
                        $('#Banktt_Datatable').DataTable({
                            "sDom":"Rlfrtip",
                            "deferRender":    true,
                            "scrollY": 200,
                            "scrollX": 500,
                            "scrollCollapse": true,
                            "aaSorting": [],
                            "pageLength": 10,
                            "sPaginationType": "full_numbers",
                            "aoColumnDefs": [{
                                "aTargets": ["uk-date-column"],
                                "sType": "uk_date"
                            }, {"aTargets": ["uk-timestp-column"], "sType": "uk_timestp"}]
                        });
                        sorting();
                    }
                    else
                    {
                        $('#Banktt_Search_DataTable').hide();
                        $('#tableheader').text('');
                        $('#emptytableheader').text(emptyheader);
                    }
                    $('.preloader').hide();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                },
                error: function(data){
                    show_msgbox("BANK TT ENTRY",'error in getting'+JSON.stringify(data),"error",false);
                    $('.preloader').hide();
                }
            });
        });
        function DataTableshow(valuearray)
        {
            var tabledata = '<table style="width:3500px" id="Banktt_Datatable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr>';
            tabledata += "<th style='width:80px !important;text-align: center'>EDIT/UPDATE</th>";
            tabledata += "<th style='width:130px !important;text-align: center'>TRANSACTION TYPE<span class='labelrequired'><em>*</em></span></th>";
            tabledata += "<th style='width:100px !important;text-align: center' class='uk-date-column'>DATE<span class='labelrequired'><em>*</em></span></th>";
            tabledata += "<th style='width:150px !important;text-align: center'>ACCOUNT NAME<span class='labelrequired'><em>*</em></span></th>";
            tabledata += "<th style='width:150px !important;text-align: center'>ACCOUNT NO<span class='labelrequired'><em>*</em></span></th>";
            tabledata += "<th style='width:120px !important;text-align: center'>AMOUNT<span class='labelrequired'><em>*</em></span></th>";
            tabledata += "<th style='width:100px !important;text-align: center'>UNIT</th>";
            tabledata += "<th style='width:150px !important;text-align: center'>CUSTOMER<span class='labelrequired'><em>*</em></span></th>";
            tabledata += "<th style='width:100px !important;text-align: center'>STATUS<span class='labelrequired'><em>*</em></span></th>";
            tabledata += "<th style='width:150px !important;text-align: center' class='uk-date-column'>DEBITED / REJECTED DATE<span class='labelrequired'><em>*</em></span></th>";
            tabledata += "<th style='width:120px !important;text-align: center'>BANK CODE</th>";
            tabledata += "<th style='width:120px !important;text-align: center'>BRANCH CODE</th>";
            tabledata += "<th style='width:200px !important;text-align: center'>BANK ADDRESS</th>";
            tabledata += "<th style='width:150px !important;text-align: center'>SWIFT CODE</th>";
            tabledata += "<th style='width:150px !important;text-align: center'>CHARGES TO</th>";
            tabledata += "<th style='width:200px !important;text-align: center'>CUST REF</th>";
            tabledata += "<th style='width:200px !important;text-align: center'>INV DETAILSS</th>";
            tabledata += "<th style='width:200px !important;text-align: center'>COMMENTS</th>";
            tabledata += "<th style='width:150px !important;text-align: center'>CREATED BY</th>";
            tabledata += "<th style='width:150px !important;text-align: center'>USERSTAMP</th>";
            tabledata += "<th style='width:150px !important;text-align: center' class='uk-timestp-column'>TIMESTAMP</th>";
            tabledata += "</tr></thead><tbody>";
            for (var i = 0; i < valuearray.length; i++) {
                var Ermid = valuearray[i].BT_ID;
                BT_id.push(Ermid)
                var edit = "Editid_" + valuearray[i].BT_ID;
                var del = "Deleteid_" + valuearray[i].BT_ID;
                if (valuearray[i].BT_ACC_NAME == null) {
                    var accname = '';
                } else {
                    accname = valuearray[i].BT_ACC_NAME;
                }
                if (valuearray[i].BT_ACC_NO == null) {
                    var accno = '';
                } else {
                    accno = valuearray[i].BT_ACC_NO;
                }
                if (valuearray[i].UNIT_NO == null) {
                    var unit = '';
                } else {
                    unit = valuearray[i].UNIT_NO;
                }
                if (valuearray[i].CUSTOMERNAME == null) {
                    var customer = '';
                } else {
                    customer = valuearray[i].CUSTOMERNAME;
                }
                if (valuearray[i].TRANSACTION_STATUS == null) {
                    var status = '';
                } else {
                    status = valuearray[i].TRANSACTION_STATUS;
                }
                if (valuearray[i].BT_DEBITED_ON == null) {
                    var debitedon = '';
                } else {
                    debitedon = valuearray[i].BT_DEBITED_ON;
                }
                if (valuearray[i].BT_BANK_CODE == null) {
                    var bankcode = '';
                } else {
                    bankcode = valuearray[i].BT_BANK_CODE;
                }
                if (valuearray[i].BT_BRANCH_CODE == null) {
                    var branchcode = '';
                } else {
                    branchcode = valuearray[i].BT_BRANCH_CODE;
                }
                if (valuearray[i].BT_BANK_ADDRESS == null) {
                    var bankaddress = '';
                } else {
                    bankaddress = valuearray[i].BT_BANK_ADDRESS;
                }
                if (valuearray[i].BT_SWIFT_CODE == null) {
                    var swiftcode = '';
                } else {
                    swiftcode = valuearray[i].BT_SWIFT_CODE;
                }
                if (valuearray[i].BANK_TRANSFER_CHARGES_TO == null) {
                    var chargesto = '';
                } else {
                    chargesto = valuearray[i].BANK_TRANSFER_CHARGES_TO;
                }
                if (valuearray[i].BT_CUST_REF == null) {
                    var custoref = '';
                } else {
                    custoref = valuearray[i].BT_CUST_REF;
                }
                if (valuearray[i].BT_INV_DETAILS == null) {
                    var invdetails = '';
                } else {
                    invdetails = valuearray[i].BT_INV_DETAILS;
                }
                if (valuearray[i].BT_COMMENTS == null) {
                    var comments = '';
                } else {
                    comments = valuearray[i].BT_COMMENTS;
                }
                if (valuearray[i].BANK_TRANSFER_CREATED_BY == null) {
                    var createdby = '';
                } else {
                    createdby = valuearray[i].BANK_TRANSFER_CREATED_BY;
                }
                tabledata += '<tr id=' + valuearray[i].BT_ID + '>' +
                    "<td ><div class='col-lg-2'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit Banktt_editbutton' id=" + edit + "></div></td>" +
                    "<td >" + valuearray[i].BANK_TRANSFER_TYPE + "</td>" +
                    "<td  >" + valuearray[i].BT_DATE + "</td>" +
                    "<td>" + accname + "</td>" +
                    "<td>" + accno + "</td>" +
                    "<td>" + valuearray[i].BT_AMOUNT + "</td>" +
                    "<td>" + unit + "</td>" +
                    "<td>" + customer + "</td>" +
                    "<td>" + status + "</td>" +
                    "<td>" + debitedon + "</td>" +
                    "<td>" + bankcode + "</td>" +
                    "<td>" + branchcode + "</td>" +
                    "<td>" + bankaddress + "</td>" +
                    "<td>" + swiftcode + "</td>" +
                    "<td>" + chargesto + "</td>" +
                    "<td>" + custoref + "</td>" +
                    "<td>" + invdetails + "</td>" +
                    "<td>" + comments + "</td>" +
                    "<td>" + createdby + "</td>" +
                    "<td>" + valuearray[i].ULD_LOGINID + "</td>" +
                    "<td>" + valuearray[i].BT_TIME_STAMP + "</td>" +
                    "</tr>";
            }
            tabledata += "</body>";
            $('#tableheader').text(header);
            $('section').html(tabledata);
            $('.preloader').hide();
            $('#Banktt_Search_DataTable').show();
            $('#Banktt_Datatable').DataTable({
                "sDom":"Rlfrtip",
                "aaSorting": [],
                "pageLength": 10,
                "sPaginationType": "full_numbers",
                "aoColumnDefs": [{
                    "aTargets": ["uk-date-column"],
                    "sType": "uk_date"
                }, {"aTargets": ["uk-timestp-column"], "sType": "uk_timestp"}]
            });
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
        $(document).on('click','.Banktt_editbutton',function(e) {
            e.stopPropagation();
            e.preventDefault();
            e.stopImmediatePropagation();
            var cid = $(this).attr('id');
            var SplittedData=cid.split('_');
            var Rowid=SplittedData[1];
            $('#BankTT_Updation_Form').hide();
            $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
            $('#BankTT_Updation_Form')[0].reset();
            $('#Temp_Bt_id').val(Rowid);
            var tds = $('#'+Rowid).children('td');
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url+"Banktt_Update_FetchData",
                data:{"id":Rowid},
                success: function(data){
                    var returnvalue=JSON.parse(data);
                    if(returnvalue[0].TRANSACTION_TYPE=='TT')
                    {
                        $('#ttgiropart1').show();
                        $('#ttgiropart2').show();
                        $('#giropart').hide();
                        $('#modeldiv').hide();
                        $('#ttpart').show();
                        $('#Banktt_SRC_TTtype').val(returnvalue[0].TRANSACTION_TYPE);
                        $('#Banktt_SRC_Accname').val(returnvalue[0].BT_ACC_NAME);
                        $('#Banktt_SRC_Accno').val(returnvalue[0].BT_ACC_NO);
                        $('#Banktt_SRC_Unit').val(returnvalue[0].UNIT);
                        $('#Banktt_SRC_Customername').val(returnvalue[0].CUSTOMER_NAME);
                        $('#Banktt_SRC_Swiftcode').val(returnvalue[0].SWIFT_CODE);
                        $('#Banktt_SRC_Chargesto').val(returnvalue[0].CHARGES_TO);
                    }
                    else if(returnvalue[0].TRANSACTION_TYPE=='GIRO')
                    {
                        $('#ttgiropart1').show();
                        $('#ttgiropart2').show();
                        $('#ttpart').hide();
                        $('#modeldiv').hide();
                        $('#giropart').show();
                        $('#Banktt_SRC_TTtype').val(returnvalue[0].TRANSACTION_TYPE);
                        $('#Banktt_SRC_Accname').val(returnvalue[0].BT_ACC_NAME);
                        $('#Banktt_SRC_Accno').val(returnvalue[0].BT_ACC_NO);
                        $('#Banktt_SRC_Unit').val(returnvalue[0].UNIT_NO);
                        $('#Banktt_SRC_Customername').val(returnvalue[0].CUSTOMER_NAME);
                        $('#Banktt_SRC_Bankcode').val(returnvalue[0].BANK_CODE);
                        $('#Banktt_SRC_Branchcode').val(returnvalue[0].BRANCH_CODE);
                    }
                    else
                    {
                        $('#ttgiropart1').hide();
                        $('#ttgiropart2').hide();
                        $('#ttpart').hide();
                        $('#giropart').hide();
                        $('#modeldiv').show();
                        $('#Banktt_SRC_TTtype').val('MODEL');
                        $('#Banktt_SRC_Modelnames').val(returnvalue[0].BRANCH_CODE);
                    }
                    $('#Banktt_SRC_Date').val(FormTableDateFormat(returnvalue[0].BT_DATE));
                    $('#Banktt_SRC_Amount').val(returnvalue[0].BT_AMOUNT);
                    $('#Banktt_SRC_Status').val(returnvalue[0].STATUS);
                    if(returnvalue[0].DEBITED_ON!=null)
                        $('#Banktt_SRC_Debitedon').val(FormTableDateFormat(returnvalue[0].DEBITED_ON));
                    else
                        $('#Banktt_SRC_Debitedon').val("");
//                    if(returnvalue[0].STATUS=="ENTERED" || returnvalue[0].STATUS=="CREATED"){
//                        $('#debittedondiv').hide();
//                    }
//                    else
//                    {
//                        $('#debittedondiv').show();
//                    }
                    $('#Banktt_SRC_BankAddress').val(returnvalue[0].BANK_ADDRESS);
                    $('#Banktt_SRC_Customerref').val(returnvalue[0].CUST_REF);
                    $('#Banktt_SRC_Invdetails').val(returnvalue[0].INV_DETAILS);
                    if(returnvalue[0].CREATED_BY!=null)
                    {
                        $('#Banktt_SRC_Createdby').val(returnvalue[0].CREATED_BY);
                    }
                    $('#Banktt_SRC_Comments').val(returnvalue[0].COMMENTS);
                    var bankttdate=returnvalue[0].BT_DATE;
                    var BANKTT_db_chkindate1 = new Date( Date.parse( bankttdate));
                    BANKTT_db_chkindate1.setDate( BANKTT_db_chkindate1.getDate());
                    var BANKTT_db_chkindate1 = BANKTT_db_chkindate1.toDateString();
                    BANKTT_db_chkindate1 = new Date( Date.parse( BANKTT_db_chkindate1 ) );
                    $('#Banktt_SRC_Date').datepicker("option","minDate",new Date(BANKTT_db_chkindate1.getFullYear()-1,BANKTT_db_chkindate1.getMonth(),BANKTT_db_chkindate1.getDate()));
                    if(returnvalue[0].DEBITED_ON==null)
                    {
                        $('#debittedondiv').hide().val('');
                    }
                    else
                    {
                        $('#debittedondiv').show();
                    }
                    $('#Banktt_SRC_Debitedon').datepicker("option","minDate",BANKTT_db_chkindate1);
                    $('#Banktt_SRC_Debitedon').datepicker("option","maxDate",new Date());
                    $('#BankTT_Updation_Form').show();
                    $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
                    $('.preloader').hide();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                },
                error: function(data){
                    $('#BankTT_Updation_Form').hide();
                    show_msgbox("BANK TT ENTRY",'error in getting'+JSON.stringify(data),"error",false);
                    $('.preloader').hide();
                }
            });
//            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        });
        $(document).on('change','#Banktt_SRC_Date',function() {
            var debiteddate=$('#Banktt_SRC_Date').val();
            var CCRE_db_chkindate1 = new Date( Date.parse( FormTableDateFormat(debiteddate)));
            CCRE_db_chkindate1.setDate( CCRE_db_chkindate1.getDate());
            var CCRE_db_chkindate1 = CCRE_db_chkindate1.toDateString();
            CCRE_db_chkindate1 = new Date( Date.parse( CCRE_db_chkindate1 ) );
            $('#Banktt_SRC_Debitedon').datepicker("option","minDate",CCRE_db_chkindate1);
        });
        $(document).on('change','#Banktt_SRC_Status',function() {
            var debiteddate=$('#Banktt_SRC_Date').val();
            var CCRE_db_chkindate1 = new Date( Date.parse( FormTableDateFormat(debiteddate)));
            CCRE_db_chkindate1.setDate( CCRE_db_chkindate1.getDate());
            var CCRE_db_chkindate1 = CCRE_db_chkindate1.toDateString();
            CCRE_db_chkindate1 = new Date( Date.parse( CCRE_db_chkindate1 ) );
            $('#Banktt_SRC_Debitedon').datepicker("option","minDate",CCRE_db_chkindate1);
            $('#Banktt_SRC_Debitedon').datepicker("option","maxDate",new Date());
            if(($('#Banktt_SRC_Status').val()!="SELECT")&&($('#Banktt_SRC_Status').val()!="ENTERED")&&($('#Banktt_SRC_Status').val()!="CREATED"))
            {
                $('#debittedondiv').show();
                $('#Banktt_SRC_Debitedon').val('');
            }
            else
            {
                $('#debittedondiv').hide();
                $('#Banktt_SRC_Debitedon').val('');
            }
        });
        /////////////UPDATE FORM VALIDATION///////
        $(document).on('change blur','#BankTT_Updation_Form',function() {
            var type=$('#Banktt_SRC_TTtype').val();
            $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
            if((type=='TT')||(type=="GIRO"))
            {
                if(($('#Banktt_SRC_Status').val()!="SELECT") && ($('#Banktt_SRC_Status').val()!="ENTERED")&& ($('#Banktt_SRC_Status').val()!="CREATED"))
                {
                    if(type=='TT')
                    {
                        if($('#Banktt_SRC_Accname').val()!="" && $('#Banktt_SRC_Accno').val()!="" && $('#Banktt_SRC_Date').val()!="" && $('#Banktt_SRC_Amount').val()!="" && $('#Banktt_SRC_Swiftcode').val()!="" && $('#Banktt_SRC_Chargesto').val()!="SELECT" && $('#Banktt_SRC_Debitedon').val()!="")
                        {
                            $("#Banktt_SRC_Updatebutton").removeAttr("disabled");
                        }
                        else
                        {
                            $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
                        }
                    }
                    if(type=='GIRO')
                    {
                        if($('#Banktt_SRC_Accname').val()!="" && $('#Banktt_SRC_Accno').val()!="" && $('#Banktt_SRC_Date').val()!="" && $('#Banktt_SRC_Amount').val()!="" && $('#Banktt_SRC_Debitedon').val()!="" )
                        {
                            $("#Banktt_SRC_Updatebutton").removeAttr("disabled");
                        }
                        else
                        {
                            $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
                        }
                    }
                }
                else
                {
                    if(type=='TT')
                    {
                        if($('#Banktt_SRC_Accname').val()!="" && $('#Banktt_SRC_Accno').val()!="" && $('#Banktt_SRC_Date').val()!="" && $('#Banktt_SRC_Amount').val()!="" && $('#Banktt_SRC_Swiftcode').val()!="" && $('#Banktt_SRC_Status').val()!="SELECT" && $('#Banktt_SRC_Chargesto').val()!="SELECT")
                        {
                            $("#Banktt_SRC_Updatebutton").removeAttr("disabled");
                        }
                        else
                        {
                            $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
                        }
                    }
                    if(type=='GIRO')
                    {
                        if($('#Banktt_SRC_Accname').val()!="" && $('#Banktt_SRC_Accno').val()!="" && $('#Banktt_SRC_Date').val()!="" && $('#Banktt_SRC_Amount').val()!="" && $('#Banktt_SRC_Status').val()!="SELECT" )
                        {
                            $("#Banktt_SRC_Updatebutton").removeAttr("disabled");
                        }
                        else
                        {
                            $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
                        }
                    }
                }
            }
            else
            {
                if(($('#Banktt_SRC_Status').val()!="SELECT") && ($('#Banktt_SRC_Status').val()!="ENTERED") && ($('#Banktt_SRC_Status').val()!="CREATED"))
                {
                    if($('#Banktt_SRC_Date').val()!="" && $('#Banktt_SRC_Amount').val()!="" && $('#Banktt_SRC_Modelnames').val()!="SELECT" && $('#Banktt_SRC_Debitedon').val()!="")
                    {
                        $("#Banktt_SRC_Updatebutton").removeAttr("disabled");
                    }
                    else
                    {
                        $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
                    }
                }
                else
                {
                    if($('#BANKTT_SRC_db_date').val()!="" && $('#Banktt_SRC_Amount').val()!="" && $('#Banktt_SRC_Modelnames').val()!="SELECT" && $('#BANKTT_SRC_lb_status').val()!="SELECT")
                    {
                        $("#Banktt_SRC_Updatebutton").removeAttr("disabled");
                    }
                    else
                    {
                        $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
                    }
                }
            }
        });
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        $(document).on('click','#Banktt_SRC_Updatebutton',function() {
            $('.preloader').show();
            var FormElements=$('#BankTT_Updation_Form').serialize();
            $.ajax({
                type: "POST",
                url: controller_url+"Banktt_Update_Save",
                data:FormElements,
                success: function(data){
                    var returnvalue=JSON.parse(data);
                    if(returnvalue[0]==1)
                    {
                        show_msgbox("BANK TT ENTRY",SRC_ErrorMsg[2].EMC_DATA,"success",false);
                        $('#BankTT_Updation_Form').hide();
                        $('#Banktt_Search_DataTable').hide();
                        $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
                        $('.preloader').hide();
                    }
                    else
                    {
                        show_msgbox("BANK TT ENTRY",SRC_ErrorMsg[7].EMC_DATA,"success",false);
                    }
                    $('.preloader').hide();
                },
                error: function(data){
                    show_msgbox("BANK TT ENTRY",'error in getting'+JSON.stringify(data),"error",false);
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('click','#Banktt_btn_pdf',function(){
            var searchoption=$('#Banktt_SRC_SearchOption').val();
            if(searchoption==1)
            {
                var Frominput=$('#Banktt_SRC_Uintsearch').val();
                var Toinput='';
                var header="DETAILS OF SELECTED UNIT : "+Frominput;
            }
            if(searchoption==2)
            {
                var Frominput=$('#Banktt_SRC_unit').val();
                var Toinput=$('#Banktt_SRC_Customer').val()
                var header="DETAILS OF SELECTED UNIT : "+Frominput +" AND CUSTOMER "+Toinput;
            }
            if(searchoption==4)
            {
                var Frominput=$('#Banktt_SRC_accname').val();
                var Toinput='';
                var header="DETAILS OF SELECTED ACC NAME : "+Frominput;
            }
            if(searchoption==3)
            {
                var Frominput=$('#Banktt_SRC_fromdate').val();
                var Toinput=$('#Banktt_SRC_todate').val();
                var header="DETAILS OF SELECTED DATE RANGE : "+Frominput+" TO "+Toinput
            }
            if(searchoption==5)
            {
                var Frominput=$('#Banktt_SRC_FromAmount').val();
                var Toinput=$('#Banktt_SRC_ToAmount').val();
                var header="DETAILS OF SELECTED AMOUNT RANGE : "+Frominput+" TO "+Toinput
            }
            if(searchoption==6)
            {
                var Frominput=$('#Banktt_SRC_Modelsearch').val();
                var Toinput='';
                var header="DETAILS OF SELECTED MODEL : "+Frominput;
            }
            var pdfurl=document.location.href='<?php echo site_url('FINANCE/OCBC/Ctrl_Ocbc_Banktt_Search_Update/BankttPdfCreation')?>?Searchoption='+searchoption+'&Frominput='+Frominput+'&Todate='+Toinput+'&Header='+header;
        });
    });
</script>
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>BANK TT SEARCH / UPDATE</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <div class="row form-group" style="padding-left:20px;">
                    <div class="col-md-2">
                        <label>BANKTT SEARCH BY<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-3">
                        <SELECT class="form-control" name="Banktt_SRC_SearchOption"  id="Banktt_SRC_SearchOption">
                            <OPTION>SELECT</OPTION>
                        </SELECT>
                    </div>
                </div>
                <div id="Banktt_SearchformDiv" style="padding-left:20px;">

                </div>
                <div id="Banktt_Search_DataTable" class="table-responsive" hidden>
                    <h4 style="color:#498af3;" id="tableheader"></h4>
                    <input type="button" id="Banktt_btn_pdf" class="btnpdf" value="PDF">
                    <section>

                    </section>
                </div>
                <div>
                    <h4 class="errormsg" id="emptytableheader"></h4>
                </div>
                <form id="BankTT_Updation_Form" style="padding-left:20px;"><br>
                    <h4 style="color:#498af3;">BANK TT UPDATION</h4><br>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>TRANSACTION TYPE<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" name="Banktt_SRC_TTtype" required id="Banktt_SRC_TTtype" readonly style="max-width:150px;"/><input type="hidden" class="form-control" id="Temp_Bt_id" name="Temp_Bt_id" hidden>
                        </div>
                    </div>
                    <div id="modeldiv">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>MODEL NAME<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control" name="Banktt_SRC_Modelnames"  required id="Banktt_SRC_Modelnames" ><OPTION>SELECT</OPTION></SELECT>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>DATE<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="col-sm-3" style="padding-left: 0px;">
                                <div class="input-group addon">
                                    <input type="text" class="form-control datemandtry" name="Banktt_SRC_Date" id="Banktt_SRC_Date"  placeholder="Date"><label  class="input-group-addon" for=Banktt_SRC_Date><span class="glyphicon glyphicon-calendar"></span></label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="ttgiropart1">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>ACCOUNT NAME<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control autosize" name="Banktt_SRC_Accname" maxlength="40" required id="Banktt_SRC_Accname"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>ACCOUNT NO<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="Banktt_SRC_Accno" maxlength="25" required id="Banktt_SRC_Accno"/>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>AMOUNT<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control amtonly" name="Banktt_SRC_Amount" maxlength="7" required id="Banktt_SRC_Amount" style="max-width:120px;"/>
                        </div>
                    </div>
                    <div id="ttgiropart2">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>UNIT<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="Banktt_SRC_Unit"  required id="Banktt_SRC_Unit" style="max-width:120px;" readonly/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CUSTOMER<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="Banktt_SRC_Customername"  required id="Banktt_SRC_Customername" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>STATUS<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="Banktt_SRC_Status"  required id="Banktt_SRC_Status" style="max-width:150px;"><OPTION>SELECT</OPTION></SELECT>
                        </div>
                    </div>
                    <div id="debittedondiv">
                        <div class="row form-group">

                            <div class="col-md-3">
                                <label>DEBITED/REJECTED DATE<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-9">
                                <div class="col-sm-3" style="padding-left: 0px;">
                                    <div class="input-group addon">
                                        <input type="text" class="form-control" name="Banktt_SRC_Debitedon" id="Banktt_SRC_Debitedon"  placeholder="Date"><label  class="input-group-addon" for=Banktt_SRC_Debitedon><span class="glyphicon glyphicon-calendar"></span></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="giropart">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>BANK CODE</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control alphanumeric" name="Banktt_SRC_Bankcode" maxlength="4" required id="Banktt_SRC_Bankcode" style="max-width:80px;"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>BRANCH CODE</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control alphanumeric" name="Banktt_SRC_Branchcode" maxlength="3" required id="Banktt_SRC_Branchcode" style="max-width:80px;"/>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>BANK ADDRESS</label>
                        </div>
                        <div class="col-md-3">
                            <textarea class="form-control autogrowcomments" name="Banktt_SRC_BankAddress"  required id="Banktt_SRC_BankAddress"></textarea>
                        </div>
                    </div>
                    <div id="ttpart">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>SWIFT CODE<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control alphanumeric" name="Banktt_SRC_Swiftcode" maxlength="12" required id="Banktt_SRC_Swiftcode"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CHARGES TO<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control" name="Banktt_SRC_Chargesto"  required id="Banktt_SRC_Chargesto"><OPTION>SELECT</OPTION></SELECT>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>CUSTOMER REF</label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control autosize" name="Banktt_SRC_Customerref" maxlength="200" required id="Banktt_SRC_Customerref"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>INV DETAILS</label>
                        </div>
                        <div class="col-md-3">
                            <textarea class="form-control autogrowcomments" name="Banktt_SRC_Invdetails" maxlength="300" required id="Banktt_SRC_Invdetails"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>CREATED BY</label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="Banktt_SRC_Createdby"  required id="Banktt_SRC_Createdby" style="max-width:200px;"><OPTION>SELECT</OPTION></SELECT>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>COMMENTS</label>
                        </div>
                        <div class="col-md-3">
                            <textarea class="form-control autogrowcomments" name="Banktt_SRC_Comments" maxlength="300" required id="Banktt_SRC_Comments"/></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-offset-2 col-lg-3">
                            <input type="button" id="Banktt_SRC_Updatebutton" class="btn" value="UPDATE" disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
