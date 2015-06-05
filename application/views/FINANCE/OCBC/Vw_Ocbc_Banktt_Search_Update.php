<!--********************************************OCBC BANK TT SEARCH/UPDATE*******************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
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
                alert('error in getting'+JSON.stringify(data));
            }
        });
        var AllaccnameArray=[];
        $(document).on('change','#Banktt_SRC_SearchOption',function() {
            $('#Banktt_Search_DataTable').hide();
            $('#BankTT_Updation_Form').hide();
            var searchoption=$('#Banktt_SRC_SearchOption').val();
            if(searchoption==1)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">UNIT NUMBER SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
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
            }
            if(searchoption==2)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">CUSTOMER NAME SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>UNIT NO<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control customer_btn_validation" name="Banktt_SRC_unit"  id="Banktt_SRC_unit" style="max-width: 120px"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
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
            }
            if(searchoption==3)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">DATE RANGE SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>FROM DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input class="form-control Date_btn_validation datemandtry" name="Banktt_SRC_fromdate"  id="Banktt_SRC_fromdate" style="max-width: 120px"></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
                appenddata+='<div class="col-md-2"><label>TO DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input class="form-control Date_btn_validation datemandtry" name="Banktt_SRC_todate"  id="Banktt_SRC_todate" style="max-width: 120px"></div>';
                appenddata+='</div>';
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
                $('.preloader').hide();
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
                $('.preloader').hide();
            }
            if(searchoption==6)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">MODEL NAME SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:20px;">';
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
                        $('.preloader').hide();
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
                        alert('error in getting'+JSON.stringify(data));
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
            $('.preloader').show();
            if(searchoption==1)
            {
                var unit=$('#Banktt_SRC_Uintsearch').val();
                var inputdata={"Option":1,"Unit":unit,"Customer":''};
                var header="DETAILS OF SELECTED UNIT : "+unit;
                $('#Banktt_SRC_Uintsearch').val('SELECT');
            }
            if(searchoption==2)
            {
                var unit=$('#Banktt_SRC_unit').val();
                var customer=$('#Banktt_SRC_Customer').val()
                var inputdata={"Option":2,"Unit":unit,Customer:customer};
                var header="DETAILS OF SELECTED UNIT : "+unit +" AND CUSTOMER "+customer;
                $('#Banktt_SRC_unit').val('SELECT');
                $('#Banktt_SRC_Customer').val('SELECT');
                $('#Banktt_SRC_Customer').prop("disabled", true);
            }
            if(searchoption==4)
            {
                var accname=$('#Banktt_SRC_accname').val();
                var inputdata={"Option":4,"Unit":accname,Customer:''};
                var header="DETAILS OF SELECTED ACC NAME : "+accname;
                $('#Banktt_SRC_accname').val('');
            }
            if(searchoption==3)
            {
                var fromdate=$('#Banktt_SRC_fromdate').val();
                var todate=$('#Banktt_SRC_todate').val();
                var inputdata={"Option":3,"Unit":fromdate,Customer:todate};
                var header="DETAILS OF SELECTED DATE RANGE : "+fromdate+" TO "+todate
                $('#Banktt_SRC_fromdate').val('');
                $('#Banktt_SRC_todate').val('');
            }
            if(searchoption==5)
            {
                var Banktt_SRC_fromamt=$('#Banktt_SRC_FromAmount').val();
                var Banktt_SRC_toamt=$('#Banktt_SRC_ToAmount').val();
                var inputdata={"Option":5,"Unit":Banktt_SRC_fromamt,Customer:Banktt_SRC_toamt};
                var header="DETAILS OF SELECTED AMOUNT RANGE : "+Banktt_SRC_fromamt+" TO "+Banktt_SRC_toamt
                $('#Banktt_SRC_FromAmount').val('');
                $('#Banktt_SRC_ToAmount').val('');
            }
            if(searchoption==6)
            {
                var modelname=$('#Banktt_SRC_Modelsearch').val();
                var inputdata={"Option":6,"Unit":modelname,Customer:''};
                var header="DETAILS OF SELECTED MODEL : "+modelname
                $('#Banktt_SRC_Modelsearch').val('SELECT');
            }
            $.ajax({
                type: "POST",
                url: controller_url+"Banktt_Search_Details",
                data:inputdata,
                success: function(data){
                    var valuearray=JSON.parse(data);
                    var tabledata="<table id='Banktt_Datatable' border=1 cellspacing='0' data-class='table'  class='srcresult table' style='width:2500px'>";
                    tabledata+="<thead class='headercolor'><tr class='head' style='text-align:center'>";
                    tabledata+="<th style='width:80px !important;'>EDIT/UPDATE</th>";
                    tabledata+="<th style='width:130px !important;'>TRANSACTION TYPE<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='width:100px !important;'>DATE<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='width:200px !important;'>ACCOUNT NAME<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='width:200px !important;'>ACCOUNT NO<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='width:120px !important;'>AMOUNT<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='width:100px !important;'>UNIT</th>";
                    tabledata+="<th style='width:200px !important;'>CUSTOMER<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='width:100px !important;'>STATUS<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='width:150px !important;'>DEBITED / REJECTED DATE<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='width:120px !important;'>BANK CODE</th>";
                    tabledata+="<th style='width:120px !important;'>BRANCH CODE</th>";
                    tabledata+="<th style='width:200px !important;'>BANK ADDRESS</th>";
                    tabledata+="<th style='width:150px !important;'>SWIFT CODE</th>";
                    tabledata+="<th style='width:150px !important;'>CHARGES TO</th>";
                    tabledata+="<th style='width:200px !important;'>CUST REF</th>";
                    tabledata+="<th style='width:200px !important;'>INV DETAILSS</th>";
                    tabledata+="<th style='width:200px !important;'>COMMENTS</th>";
                    tabledata+="<th style='width:150px !important;'>CREATED BY</th>";
                    tabledata+="<th style='width:150px !important;'>USERSTAMP</th>";
                    tabledata+="<th style='width:150px !important;'>TIMESTAMP</th>";
                    tabledata+="</tr></thead><tbody>";
                    for(var i=0;i<valuearray.length;i++)
                    {
                        var Ermid=valuearray[i].BT_ID;
                        BT_id.push(Ermid)
                        var edit="Editid_"+valuearray[i].BT_ID;
                        var del="Deleteid_"+valuearray[i].BT_ID;
                        if(valuearray[i].BT_ACC_NAME==null){var accname='';}else{accname=valuearray[i].BT_ACC_NAME;}
                        if(valuearray[i].BT_ACC_NO==null){var accno='';}else{accno=valuearray[i].BT_ACC_NO;}
                        if(valuearray[i].UNIT_NO==null){var unit='';}else{unit=valuearray[i].UNIT_NO;}
                        if(valuearray[i].CUSTOMERNAME==null){var customer='';}else{customer=valuearray[i].CUSTOMERNAME;}
                        if(valuearray[i].TRANSACTION_STATUS==null){var status='';}else{status=valuearray[i].TRANSACTION_STATUS;}
                        if(valuearray[i].BT_DEBITED_ON==null){var debitedon='';}else{debitedon=valuearray[i].BT_DEBITED_ON;}
                        if(valuearray[i].BT_BANK_CODE==null){var bankcode='';}else{bankcode=valuearray[i].BT_BANK_CODE;}
                        if(valuearray[i].BT_BRANCH_CODE==null){var branchcode='';}else{branchcode=valuearray[i].BT_BRANCH_CODE;}
                        if(valuearray[i].BT_BANK_ADDRESS==null){var bankaddress='';}else{bankaddress=valuearray[i].BT_BANK_ADDRESS;}
                        if(valuearray[i].BT_SWIFT_CODE==null){var swiftcode='';}else{swiftcode=valuearray[i].BT_SWIFT_CODE;}
                        if(valuearray[i].BANK_TRANSFER_CHARGES_TO==null){var chargesto='';}else{chargesto=valuearray[i].BANK_TRANSFER_CHARGES_TO;}
                        if(valuearray[i].BT_CUST_REF==null){var custoref='';}else{custoref=valuearray[i].BT_CUST_REF;}
                        if(valuearray[i].BT_INV_DETAILS==null){var invdetails='';}else{invdetails=valuearray[i].BT_INV_DETAILS;}
                        if(valuearray[i].BT_COMMENTS==null){var comments='';}else{comments=valuearray[i].BT_COMMENTS;}
                        if(valuearray[i].BANK_TRANSFER_CREATED_BY==null){var createdby='';}else{createdby=valuearray[i].BANK_TRANSFER_CREATED_BY;}
                        tabledata+='<tr id='+valuearray[i].BT_ID+'>' +
                            "<td style='width:80px !important;'><div class='col-lg-2'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit Banktt_editbutton' id="+edit+"></div></td>" +
                            "<td style='width:130px !important;text-align: center' nowrap>"+valuearray[i].BANK_TRANSFER_TYPE+"</td>" +
                            "<td style='width:100px !important;text-align: center'nowrap >"+valuearray[i].BT_DATE+"</td>" +
                            "<td style='width:200px !important;' nowrap>"+accname+"</td>" +
                            "<td style='width:150px !important;' nowrap>"+accno+"</td>" +
                            "<td style='width:120px !important;text-align: center' nowrap>"+valuearray[i].BT_AMOUNT+"</td>" +
                            "<td style='width:100px !important;text-align: center' nowrap>"+unit+"</td>" +
                            "<td style='width:200px !important;text-align: center' nowrap>"+customer+"</td>" +
                            "<td style='width:100px !important;text-align: center' nowrap>"+status+"</td>" +
                            "<td style='width:150px !important;' nowrap>"+debitedon+"</td>" +
                            "<td style='width:120px !important;' nowrap>"+bankcode+"</td>" +
                            "<td style='width:120px !important;' nowrap>"+branchcode+"</td>" +
                            "<td nowrap>"+bankaddress+"</td>" +
                            "<td style='width:150px !important;' nowrap>"+swiftcode+"</td>" +
                            "<td style='width:150px !important;' nowrap>"+chargesto+"</td>" +
                            "<td style='width:200px !important;' nowrap>"+custoref+"</td>" +
                            "<td nowrap>"+invdetails+"</td>" +
                            "<td nowrap>"+comments+"</td>" +
                            "<td style='width:150px !important;' nowrap>"+createdby+"</td>" +
                            "<td style='width:150px !important;' nowrap>"+valuearray[i].ULD_LOGINID+"</td>" +
                            "<td style='width:150px !important;' nowrap>"+valuearray[i].BT_TIME_STAMP+"</td>" +
                            "</tr>";
                    }
                    tabledata+="</body>";
                    $('#tableheader').text(header);
                    $('section').html(tabledata);
                    $('.preloader').hide();
                    $('#Banktt_Search_DataTable').show();
                    $('#Banktt_Datatable').DataTable( {
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers"
                    });
                    },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('click','.Banktt_editbutton',function() {
        var cid = $(this).attr('id');
        var SplittedData=cid.split('_');
        var Rowid=SplittedData[1];
        $('#BankTT_Updation_Form').hide();
        $("#Banktt_SRC_Updatebutton").attr("disabled", "disabled");
        $('#BankTT_Updation_Form')[0].reset();
        $('#Temp_Bt_id').val(Rowid);
        var tds = $('#'+Rowid).children('td');
            if($(tds[1]).html()=='TT')
            {
                $('#ttgiropart1').show();
                $('#ttgiropart2').show();
                $('#giropart').hide();
                $('#modeldiv').hide();
                $('#ttpart').show();
                $('#Banktt_SRC_TTtype').val($(tds[1]).html());
                $('#Banktt_SRC_Accname').val($(tds[3]).html());
                $('#Banktt_SRC_Accno').val($(tds[4]).html());
                $('#Banktt_SRC_Unit').val($(tds[6]).html());
                $('#Banktt_SRC_Customername').val($(tds[7]).html());
                $('#Banktt_SRC_Swiftcode').val($(tds[13]).html());
                $('#Banktt_SRC_Chargesto').val($(tds[14]).html());
            }
            else if($(tds[1]).html()=='GIRO')
            {
                $('#ttgiropart1').show();
                $('#ttgiropart2').show();
                $('#ttpart').hide();
                $('#modeldiv').hide();
                $('#giropart').show();
                $('#Banktt_SRC_TTtype').val($(tds[1]).html());
                $('#Banktt_SRC_Accname').val($(tds[3]).html());
                $('#Banktt_SRC_Accno').val($(tds[4]).html());
                $('#Banktt_SRC_Unit').val($(tds[6]).html());
                $('#Banktt_SRC_Customername').val($(tds[7]).html());
                $('#Banktt_SRC_Bankcode').val($(tds[10]).html());
                $('#Banktt_SRC_Branchcode').val($(tds[11]).html());
            }
            else
            {
                $('#ttgiropart1').hide();
                $('#ttgiropart2').hide();
                $('#ttpart').hide();
                $('#giropart').hide();
                $('#modeldiv').show();
                $('#Banktt_SRC_TTtype').val('MODEL');
                $('#Banktt_SRC_Modelnames').val($(tds[1]).html());
            }
            $('#Banktt_SRC_Date').val($(tds[2]).html());
            $('#Banktt_SRC_Amount').val($(tds[5]).html());
            $('#Banktt_SRC_Status').val($(tds[8]).html());
            $('#Banktt_SRC_Debitedon').val($(tds[9]).html());
            $('#Banktt_SRC_BankAddress').val($(tds[12]).html());
            $('#Banktt_SRC_Customerref').val($(tds[15]).html());
            $('#Banktt_SRC_Invdetails').val($(tds[16]).html());
            if($(tds[18]).html()!='')
            {
                $('#Banktt_SRC_Createdby').val($(tds[18]).html());
            }
            $('#Banktt_SRC_Comments').val($(tds[17]).html());
            var bankttdate=$(tds[2]).html();
            var BANKTT_db_chkindate1 = new Date( Date.parse( FormTableDateFormat(bankttdate)));
            BANKTT_db_chkindate1.setDate( BANKTT_db_chkindate1.getDate());
            var BANKTT_db_chkindate1 = BANKTT_db_chkindate1.toDateString();
            BANKTT_db_chkindate1 = new Date( Date.parse( BANKTT_db_chkindate1 ) );
            $('#Banktt_SRC_Date').datepicker("option","minDate",new Date(BANKTT_db_chkindate1.getFullYear()-1,BANKTT_db_chkindate1.getMonth(),BANKTT_db_chkindate1.getDate()));
            if($(tds[9]).html()=='')
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
                    alert(data)
                    var returnvalue=JSON.parse(data);
                    if(returnvalue==1)
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
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
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
                        <div class="col-md-3">
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
                        <section>

                        </section>
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
                            <div class="col-md-3">
                                <input class="form-control datemandtry" name="Banktt_SRC_Date"  required id="Banktt_SRC_Date" style="max-width:120px;"/>
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
                                <div class="col-md-3">
                                    <input class="form-control" name="Banktt_SRC_Debitedon"  required id="Banktt_SRC_Debitedon" style="max-width:120px;"/>
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
