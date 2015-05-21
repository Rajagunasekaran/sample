<!--  VER 0.01-INITIAL VERSION-SD:16/05/2015 ED:19/05/2015-Merged entry and search updte form and did inline row edit for updation. Done by KUMAR R -->
<html>
<head>
    <?php include 'Header.php'; ?>
</head>
<script>
var ErrorControl ={AmountCompare:'InValid'}
$(document).ready(function() {
    $('.preloader').hide();
    //****************Form Option Selection*********************//
    $("#ERM_SRC_FromAmount").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
    $('#ERM_Entry_MovingDate').datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true
    });
    $('#ERM_Entry_Others').hide();
    $('.autogrowcomments').autogrow({onInitialize: true});
    $("#ERM_Entry_Contactno").doValidation({rule:'numbersonly',prop:{realpart:20,leadzero:true}});
    $(".autosize").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
    $('#ERM_Entry_Emailid').doValidation({rule:'email',prop:{uppercase:false,autosize:true}});
    $(".compautosize").doValidation({prop:{autosize:true}});
    $(".numonly").doValidation({rule:'numbersonly'});
    $("#ERM_Entry_Rent").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
    $(document).on('change','#ERM_SRC_FromDate',function(){
        var startdate=$('#ERM_SRC_FromDate').val();
        var FIN_ENTRY_db_chkindate1 = new Date( Date.parse(FormTableDateFormat(startdate)));
        FIN_ENTRY_db_chkindate1.setDate( FIN_ENTRY_db_chkindate1.getDate());
        var FIN_ENTRY_db_chkindate1 = FIN_ENTRY_db_chkindate1.toDateString();
        FIN_ENTRY_db_chkindate1 = new Date( Date.parse( FIN_ENTRY_db_chkindate1));
        $('#ERM_SRC_ToDate').datepicker("option","minDate",FIN_ENTRY_db_chkindate1);
        $('#ERM_SRC_ToDate').datepicker("option","maxDate",new Date());
    });
    function FormTableDateFormat(inputdate)
    {
        var string = inputdate.split("-");
        return string[2]+'-'+ string[1]+'-'+string[0];
    }
    var AllcustomerArray=[];
    var AllcontactnoArray=[];
    var Entry_errormsg;
    var SRC_nationality;
    var occupationvalue;
    var SRC_errormsg;
    $(document).on('click','.BE_rd_selectform',function() {
        var value=$("input[name='optradio']:checked").val();
        $('.preloader').show();
        if(value=='ERM_entryform')
        {
            $('#ERM_Entry_Form').show();
            $('#ERM_search_update_Form').hide();
            $('#ERM_Form_Entry')[0].reset();
            $('#ERM_Entry_Others').hide();
            $("#CERM_ENTRY_btn_savebutton").attr("disabled", "disabled");

            $.ajax({
                type: "POST",
                url: '/index.php/Ctrl_Erm_Forms/ERM_InitialDataLoad',
                data:{"Formname":'ERM_Entry',"ErrorList":'1,2,3,6,36,382,400'},
                success: function(data){
                    var value_array=JSON.parse(data);
                    Entry_errormsg=value_array[1];
                    for(var i=0;i<value_array[0].length;i++)
                    {
                        var data=value_array[0][i];
                        $('#ERM_Entry_Nationality').append($('<option>').text(data.NC_DATA).attr('value', data.NC_DATA));
                    }
                    for(var i=0;i<value_array[2].length;i++)
                    {
                        var data=value_array[2][i];
                        $('#ERM_Entry_Occupation').append($('<option>').text(data.ERMO_DATA).attr('value', data.ERMO_DATA));
                    }
                    $('#ERM_Entry_Customername').prop('title',Entry_errormsg[0].EMC_DATA)
                    $('#ERM_Entry_Rent').prop('title',Entry_errormsg[1].EMC_DATA);
                    $('#ERM_Entry_Contactno').prop('title',Entry_errormsg[1].EMC_DATA);
                    $('#CERM_ENTRY_lbl_emailiderrormsg').text(Entry_errormsg[4].EMC_DATA);
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        }
        else if(value=='ERM_searchform')
        {
            $('#ERM_Entry_Form').hide();
            $('#ERM_search_update_Form').show();
            $('#SearchformDiv').html('');
            $('section').html('');
            $('#ERM_SRC_SearchOption').val('SELECT');
            $.ajax({
                type: "POST",
                url: '/index.php/Ctrl_Erm_Forms/ERM_SRC_InitialDataLoad',
                data:{"Formname":'ERM_SRC_UPDATE',"ErrorList":'1,2,4,5,6,36,45,170,315,383,384,385,401'},
                success: function(data){
                    var value_array=JSON.parse(data);
                    SRC_errormsg=value_array[2];
                    SRC_nationality=value_array[1];
                    occupationvalue=value_array[3];
                    var options='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < value_array[0].length; i++)
                    {
                        var data=value_array[0][i];
                        options += '<option value="' + data.ERMCN_ID + '">' + data.ERMCN_DATA + '</option>';
                    }
                    $('#ERM_SRC_SearchOption').html(options);
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        }
    });
    //*******************ERM ENTRY FORM DETAILS START**********************//
    var CERM_id = new Date();
    $('#ERM_Entry_MovingDate').datepicker("option","minDate",new Date(CERM_id.getFullYear()-1,CERM_id.getMonth(),CERM_id.getDate()));
    $('#ERM_Entry_MovingDate').datepicker("option","maxDate",new Date(CERM_id.getFullYear(),CERM_id.getMonth()+3,CERM_id.getDate()));
    $(document).on('change','#ERM_Entry_Occupation',function(){
        if($('#ERM_Entry_Occupation').val()=='OTHERS')
        {
            $('#ERM_Entry_Others').show();
        }
        else
        {
            $('#ERM_Entry_Others').hide();
        }
    });
    //*************ERM SUBMIT BUTTON VALIDATION*******************//
    $('#ERM_Form_Entry').change(function(){
        //************************MAIL ID VALIDATION******************//
        var CERM_ENTRY_emailid=$("#ERM_Entry_Emailid").val();
        if(CERM_ENTRY_emailid.length>0)
        {
            var CERM_ENTRY_atpos=CERM_ENTRY_emailid.indexOf("@");
            var CERM_ENTRY_dotpos=CERM_ENTRY_emailid.lastIndexOf(".");
            if ((/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(CERM_ENTRY_emailid) || "" == CERM_ENTRY_emailid)&&(CERM_ENTRY_dotpos-1!=CERM_ENTRY_emailid.indexOf(".")))
            {
                var CERM_ENTRY_emailchk="valid";
                $('#ERM_Entry_Emailid').removeClass('invalid');
                $('#CERM_ENTRY_lbl_emailiderrormsg').hide();
                $('#ERM_Entry_Emailid').val($('#ERM_Entry_Emailid').val().toLowerCase());
            }
            else
            {
                CERM_ENTRY_emailchk="invalid"
                $('#ERM_Entry_Emailid').addClass('invalid');
                $('#CERM_ENTRY_lbl_emailiderrormsg').show();
            }
        }
        else
        {
            CERM_ENTRY_emailchk="valid";
            $('#ERM_Entry_Emailid').removeClass('invalid');
            $('#CERM_ENTRY_lbl_emailiderrormsg').hide();
        }
        if($('#ERM_Entry_Occupation').val()!="OTHERS")
        {
            //***********************IF OCCUPATION IS NOT= OTHERS THE FOLLOWING ID DATA'S ARE MANDATORY************************//
            if($('#ERM_Entry_Customername').val()!="" && $('#ERM_Entry_Rent').val()!="" && $('#ERM_Entry_MovingDate').val()!="" && $('#ERM_Entry_Minimumstay').val()!="" &&
                $('#ERM_Entry_Occupation').val()!="SELECT" && $('#ERM_Entry_Comments').val()!="" &&(CERM_ENTRY_emailchk=="valid"))
            {
                $("#CERM_ENTRY_btn_savebutton").removeAttr("disabled");
            }
            else
            {
                $("#CERM_ENTRY_btn_savebutton").attr("disabled", "disabled");
            }
        }
        else
        {
            //***********************IF OCCUPATION IS EQUAL TO OTHERS THE FOLLOWING ID DATA'S ARE MANDATORY************************//
            if($('#ERM_Entry_Customername').val()!="" && $('#ERM_Entry_Rent').val()!="" && $('#ERM_Entry_MovingDate').val()!="" && $('#ERM_Entry_Minimumstay').val()!="" &&
                $('#ERM_Entry_Occupation').val()!="SELECT" && $('#ERM_Entry_Others').val()!=""&& $('#ERM_Entry_Comments').val()!="")
            {
                $("#CERM_ENTRY_btn_savebutton").removeAttr("disabled");
            }
            else
            {
                $("#CERM_ENTRY_btn_savebutton").attr("disabled", "disabled");
            }
        }
    });
    $(document).on('click','#CERM_ENTRY_btn_savebutton',function(){
        $('.preloader').show();
        var FormElements=$('#ERM_Form_Entry').serialize();
        $.ajax({
            type: "POST",
            url: "/index.php/Ctrl_Erm_Forms/ERM_Entry_Save",
            data:FormElements,
            success: function(data){
                var returnflag=JSON.parse(data);
                if(returnflag==1)
                {
                    show_msgbox("ERM ENTRY/SEARCH/UPDATE",Entry_errormsg[2].EMC_DATA,"success",false);
                    $('#ERM_Form_Entry')[0].reset();
                    $("#CERM_ENTRY_btn_savebutton").attr("disabled", "disabled");
                    $('.preloader').hide();
                }
                else
                {
                    show_msgbox("ERM ENTRY/SEARCH/UPDATE",returnflag,"success",false);
                }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
                $('.preloader').hide();
            }
        });
    });
    $(document).on('click','#CERM_ENTRY_btn_reset',function(){
        $('#ERM_Form_Entry')[0].reset();
        $('#ERM_Entry_Others').hide();
        $("#CERM_ENTRY_btn_savebutton").attr("disabled", "disabled");
    });
    function unique(a) {
        var result = [];
        $.each(a, function(i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
    }
    //*******************ERM ENTRY FORM DETAILS END ************************//
    $('#ERM_SRC_SearchOption').change(function(){
        $('#SearchformDiv').html('');
        $('section').html('');
        var searchoption=$('#ERM_SRC_SearchOption').val();
        if(searchoption==4)
        {
            var appenddata='<BR><h4 style="color:#498af3;">NATIONALITY SEARCH</h4><BR>';
            appenddata+='<div class="row form-group">';
            appenddata+='<div class="col-md-2"><label>NATIONALITY<span class="labelrequired"><em>*</em></span></label></div>';
            appenddata+='<div class="col-md-3"><SELECT class="form-control" name="ERM_SRC_NationalitySearch"  id="ERM_SRC_NationalitySearch">';
            appenddata+='</SELECT></div></div>';
            appenddata+='<div class="row form-group">';
            appenddata+='<div class="col-lg-offset-1 col-lg-2">';
            appenddata+='<input type="button" id="ERM_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
            $('#SearchformDiv').html(appenddata);
            var options='<OPTION>SELECT</OPTION>';
            for (var i = 0; i < SRC_nationality.length; i++)
            {
                var data=SRC_nationality[i];
                options += '<option value="' + data.NC_DATA + '">' + data.NC_DATA + '</option>';
            }
            $('#ERM_SRC_NationalitySearch').html(options);
        }

        else if(searchoption==2)
        {
            $.ajax({
                type: "POST",
                url: '/index.php/Ctrl_Erm_Forms/CustomerName',
                success: function(data){
                    var value_array=JSON.parse(data);
                    var appenddata='<BR><h4 style="color:#498af3;">CUSTOMER NAME SEARCH</h4><BR>';
                    appenddata+='<div class="row form-group">';
                    appenddata+='<div class="col-md-2"><label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata+='<div class="col-md-3"><input type=text class="form-control autosize customernameautovalidate" name="ERM_SRC_CustomerNameSearch"  id="ERM_SRC_CustomerNameSearch"/></div>';
                    appenddata+='<div class="col-md-3"><label id="customernameautocompleteerrormsg" class="errormsg" hidden></label></div>';
                    appenddata+='</div>';
                    appenddata+='<div class="row form-group">';
                    appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                    appenddata+='<input type="button" id="ERM_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                    $('#SearchformDiv').html(appenddata);
                    for (var i = 0; i < value_array.length; i++)
                    {
                        var data=value_array[i].ERM_CUST_NAME;
                        AllcustomerArray.push(data);
                        AllcustomerArray=unique(AllcustomerArray);
                    }
                    $('#customernameautocompleteerrormsg').text(SRC_errormsg[11].EMC_DATA);

                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        }
        else if(searchoption==3)
        {
            $.ajax({
                type: "POST",
                url: '/index.php/Ctrl_Erm_Forms/CustomerContact',
                success: function(data){
                    var value_array=JSON.parse(data);
                    var appenddata='<BR><h4 style="color:#498af3;">CONTACT NUMBER SEARCH</h4><BR>';
                    appenddata+='<div class="row form-group">';
                    appenddata+='<div class="col-md-2"><label>CONTACT NO<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata+='<div class="col-md-3"><input type=text class="form-control contactnoautovalidate" name="ERM_SRC_ContactNo"  id="ERM_SRC_ContactNo"/></div>';
                    appenddata+='<div class="col-md-3"><label id="contactautocompleteerrormsg" class="errormsg" hidden></label></div>';
                    appenddata+='</div>';
                    appenddata+='<div class="row form-group">';
                    appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                    appenddata+='<input type="button" id="ERM_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                    $('#SearchformDiv').html(appenddata);
                    for (var i = 0; i < value_array.length; i++)
                    {
                        var data=value_array[i].ERM_CONTACT_NO;
                        if(data!='' && data!='null' && data!=' ' && data!=null)
                        {
                            AllcontactnoArray.push(data);
                        }
                    }
                    $('#contactautocompleteerrormsg').text(SRC_errormsg[11].EMC_DATA);

                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        }
        else if(searchoption==6)
        {
            $.ajax({
                type: "POST",
                url: '/index.php/Ctrl_Erm_Forms/Userstamp',
                success: function(data){
                    var value_array=JSON.parse(data);

                    var appenddata='<BR><h4 style="color:#498af3;">USERSTAMP SEARCH</h4><BR>';
                    appenddata+='<div class="row form-group">';
                    appenddata+='<div class="col-md-2"><label>USERSTAMP<span class="labelrequired"><em>*</em></span></label></div>';
                    appenddata+='<div class="col-md-3"><SELECT  class="form-control" name="ERM_SRC_UserStamp"  id="ERM_SRC_UserStamp"></SELECT>';
                    appenddata+='</div></div>';
                    appenddata+='<div class="row form-group">';
                    appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                    appenddata+='<input type="button" id="ERM_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                    $('#SearchformDiv').html(appenddata);
                    var options='<OPTION>SELECT</OPTION>';
                    for (var i = 0; i < value_array.length; i++)
                    {
                        var data=value_array[i];
                        options += '<option value="' + data.ULD_LOGINID + '">' + data.ULD_LOGINID + '</option>';
                    }
                    $('#ERM_SRC_UserStamp').html(options);

                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        }
        else if(searchoption==1)
        {
            var appenddata='<BR><h4 style="color:#498af3;">AMOUNT RANGE SEARCH</h4><BR>';
            appenddata+='<div class="row form-group">';
            appenddata+='<div class="col-md-2"><label>FROM AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
            appenddata+='<div class="col-md-3"><input type=text class="form-control amountonly Amount_btn_validation" name="ERM_SRC_FromAmount"  id="ERM_SRC_FromAmount" style="max-width:120px;" /></div></div>';
            appenddata+='<div class="row form-group">';
            appenddata+='<div class="col-md-2"><label>TO AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
            appenddata+='<div class="col-md-3"><input type=text class="form-control amountonly Amount_btn_validation" name="ERM_SRC_ToAmount"  id="ERM_SRC_ToAmount" style="max-width:120px;" /></div>';
            appenddata+='<div class="col-md-3"><label id="ERM_SRC_lbl_amounterrormsg" class="errormsg" hidden></label></div></div>';
            appenddata+='<div class="row form-group">';
            appenddata+='<div class="col-lg-offset-1 col-lg-2">';
            appenddata+='<input type="button" id="ERM_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
            $('#SearchformDiv').html(appenddata);
            $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
            $('#ERM_SRC_lbl_amounterrormsg').text(errormsg[6].EMC_DATA);
        }
        else if(searchoption==5)
        {
            var appenddata='<BR><h4 style="color:#498af3;">TIMESTAMP SEARCH</h4><BR>';
            appenddata+='<div class="row form-group">';
            appenddata+='<div class="col-md-2"><label>FROM DATE<span class="labelrequired"><em>*</em></span></label></div>';
            appenddata+='<div class="col-md-3"><input class="form-control timestamp_btn_validation" name="ERM_SRC_FromDate"  id="ERM_SRC_FromDate" style="max-width:120px;" /></div></div>';
            appenddata+='<div class="row form-group">';
            appenddata+='<div class="col-md-2"><label>TO DATE<span class="labelrequired"><em>*</em></span></label></div>';
            appenddata+='<div class="col-md-3"><input class="form-control timestamp_btn_validation" name="ERM_SRC_ToDate"  id="ERM_SRC_ToDate" style="max-width:120px;" /></div></div>';
            appenddata+='<div class="row form-group">';
            appenddata+='<div class="col-lg-offset-1 col-lg-2">';
            appenddata+='<input type="button" id="ERM_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
            $('#SearchformDiv').html(appenddata);
            $('#Finance_Entry_Update').hide();
            $("#ERM_SRC_FromDate").datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true});
            var CCRE_d = new Date();
            var changedmonth=new Date(CCRE_d.setFullYear(2009));
            $('#ERM_SRC_FromDate').datepicker("option","minDate",changedmonth);
            $('#ERM_SRC_FromDate').datepicker("option","maxDate",new Date());
            $("#ERM_SRC_ToDate").datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true});
            var CCRE_d = new Date();
            $('#ERM_SRC_ToDate').datepicker("option","minDate",changedmonth);
            $('#ERM_SRC_ToDate').datepicker("option","maxDate",new Date());
        }
        else if(searchoption=='SELECT')
        {
            $('#SearchformDiv').html('');
            $('section').html('');
        }
    });
    //****************VALIDATION************************//
    $(document).on('change','.timestamp_btn_validation',function() {
        if($('#ERM_SRC_FromDate').val()!='' && $('#ERM_SRC_ToDate').val()!='')
        {
            $("#ERM_src_btn_search").removeAttr("disabled");
        }
        else
        {
            $("#ERM_src_btn_search").attr("disabled", "disabled");
        }
    });
    $(document).on('change','.Amount_btn_validation',function() {
        var CERM_SRC_fromamt=$('#ERM_SRC_FromAmount').val();
        var CERM_SRC_toamt=$('#ERM_SRC_ToAmount').val();
        if(CERM_SRC_fromamt!='' && CERM_SRC_toamt!='')
        {
            if(parseFloat(CERM_SRC_fromamt)<=parseFloat(CERM_SRC_toamt))
            {
                $("#ERM_src_btn_search").removeAttr("disabled");
                $('#ERM_SRC_lbl_amounterrormsg').hide();
            }
            else
            {
                $('#ERM_SRC_lbl_amounterrormsg').show();
                $("#ERM_src_btn_search").attr("disabled", "disabled");
            }
        }
    });
    $(document).on('change','#ERM_SRC_NationalitySearch',function() {
        if($('#ERM_SRC_NationalitySearch').val()!="SELECT")
        {
            $("#ERM_src_btn_search").removeAttr("disabled");
        }
        else
        {
            $("#ERM_src_btn_search").attr("disabled", "disabled");
        }
    });
    $(document).on('change','#ERM_SRC_UserStamp',function() {
        if($('#ERM_SRC_UserStamp').val()!="SELECT")
        {
            $("#ERM_src_btn_search").removeAttr("disabled");
        }
        else
        {
            $("#ERM_src_btn_search").attr("disabled", "disabled");
        }
    });

    ///CUSTOMERNAME AUTO COMPLTE///
    var ERM_customerflag;
    $(document).on('keypress','#ERM_SRC_CustomerNameSearch',function() {
        ERM_customerflag=0;
        ERM_SEARCH_invfromhighlightSearchText();
        $("#ERM_SRC_CustomerNameSearch").autocomplete({
            source: AllcustomerArray,
            select: ERM_SEARCH_AutoCompleteSelectHandler
        });
    });
    /**********CUSTOMER AUTO ERROR MESSAGE******************/
    $(document).on('change','.customernameautovalidate',function(){
        if(ERM_customerflag==1){
            $('#customernameautocompleteerrormsg').hide();
        }
        else
        {
            $('#customernameautocompleteerrormsg').show();
            $("#ERM_src_btn_search").attr("disabled", "disabled");
        }
        if($('#ERM_SRC_CustomerNameSearch').val()=="")
        {
            $('#customernameautocompleteerrormsg').hide();
            $("#ERM_src_btn_search").attr("disabled", "disabled");
        }
    });
    function ERM_SEARCH_AutoCompleteSelectHandler(event, ui) {
        ERM_customerflag=1;
        $('#customernameautocompleteerrormsg').hide();
        $('#ERM_src_btn_search').removeAttr("disabled");
    }

    ///CONTACT NO AUTO COMPLTE///
    var ERM_contactnoflag;
    $(document).on('keypress','#ERM_SRC_ContactNo',function() {
        ERM_contactnoflag=0;
        ERM_SEARCH_invfromhighlightSearchText();
        $("#ERM_SRC_ContactNo").autocomplete({
            source: AllcontactnoArray,
            select: ERM_SEARCH_contactnoAutoCompleteSelectHandler
        });
    });

    /**********CUSTOMER AUTO ERROR MESSAGE******************/
    $(document).on('change','.contactnoautovalidate',function(){
        if(ERM_customerflag==1){
            $('#contactautocompleteerrormsg').hide();
        }
        else
        {
            $('#contactautocompleteerrormsg').show();
            $("#ERM_src_btn_search").attr("disabled", "disabled");
        }
        if($('#ERM_SRC_ContactNo').val()=="")
        {
            $('#contactautocompleteerrormsg').hide();
            $("#ERM_src_btn_search").attr("disabled", "disabled");
        }
    });
    function ERM_SEARCH_contactnoAutoCompleteSelectHandler(event, ui) {
        ERM_customerflag=1;
        $('#contactautocompleteerrormsg').hide();
        $('#ERM_src_btn_search').removeAttr("disabled");
    }
    //FUNCTION TO HIGHLIGHT SEARCH TEXT//
    function ERM_SEARCH_invfromhighlightSearchText() {
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        };}
    //FUNCTION TO GET SELECTED VALUE//
    function ERM_SEARCH_invfromAutoCompleteSelectHandler(event, ui) {
    }

    //DATATABLE LOADING//
    var ERM_id=[];
    $(document).on('click','#ERM_src_btn_search',function() {
        $('.preloader').show();
        var searchoption=$('#ERM_SRC_SearchOption').val();
        if(searchoption==6)
        {
            var Userstamp=$('#ERM_SRC_UserStamp').val();
            var data={'Option':searchoption,'Data1':Userstamp,'Data2':''};
            $('#ERM_SRC_UserStamp').val('SELECT');
        }
        else if(searchoption==1)
        {
            var FromAmount=$('#ERM_SRC_FromAmount').val();
            var ToAmount=$('#ERM_SRC_ToAmount').val();
            data={'Option':searchoption,'Data1':FromAmount,'Data2':ToAmount};
            $('#ERM_SRC_FromAmount').val('');
            $('#ERM_SRC_ToAmount').val('');
        }
        else if(searchoption==5)
        {
            var FromDate=$('#ERM_SRC_FromDate').val();
            var ToDate=$('#ERM_SRC_ToDate').val();
            data={'Option':searchoption,'Data1':FromDate,'Data2':ToDate};
            $('#ERM_SRC_FromDate').val('');
            $('#ERM_SRC_ToDate').val('');
        }
        else if(searchoption==2)
        {
            var CustomerName=$('#ERM_SRC_CustomerNameSearch').val();
            data={'Option':searchoption,'Data1':CustomerName,'Data2':''};
            $('#ERM_SRC_CustomerNameSearch').val('');
        }
        else if(searchoption==3)
        {
            var ContactNo=$('#ERM_SRC_ContactNo').val();
            data={'Option':searchoption,'Data1':ContactNo,'Data2':''};
            $('#ERM_SRC_ContactNo').val('');
        }
        else if(searchoption==4)
        {
            var Nationality=$('#ERM_SRC_NationalitySearch').val();
            data={'Option':searchoption,'Data1':Nationality,'Data2':''};
            $('#ERM_SRC_NationalitySearch').val('SELECT');
        }
        $("#ERM_src_btn_search").attr("disabled", "disabled");
        $.ajax({
            type: "POST",
            url: '/index.php/Ctrl_Erm_Forms/ERM_SearchOption',
            data:data,
            success: function(data){
                var value_array=JSON.parse(data);
                var tabledata="<table id='ERM_Datatable' border=1 cellspacing='0' data-class='table'  class='srcresult table' style='width:2500px;' >";
                tabledata+="<thead class='headercolor'><tr class='head' style='text-align:center'>";
                tabledata+="<th style='text-align:center;vertical-align: top'>EDIT/DELETE</th>";
                tabledata+="<th style='text-align:center;vertical-align: top'>CUSTOMERNAME<span class='labelrequired'><em>*</em></span></th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>RENT<span class='labelrequired'><em>*</em></span></th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>MOVING DATE<span class='labelrequired'><em>*</em></span></th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>MINIMUM STAY<span class='labelrequired'><em>*</em></span></th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>OCCUPATION<span class='labelrequired'><em>*</em></span></th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>NATIONALITY</th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>NO OF GUESTS</th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>AGE</th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>CONTACT NO</th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>EMAIL ID</th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>COMMENTS<span class='labelrequired'><em>*</em></span></th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>USERSTAMP</th>";
                tabledata+="<th style='text-align:center;vertical-align: top''>TIMESTAMP</th>";
                tabledata+="</tr></thead><tbody>";
                for(var i=0;i<value_array.length;i++)
                {
                    var Ermid=value_array[i].ERM_ID;
                    ERM_id.push(Ermid)
                    var edit="Editid_"+value_array[i].ERM_ID;
                    var del="Deleteid_"+value_array[i].ERM_ID;
                    if(value_array[i].NC_DATA==null){var nationality='';}else{nationality=value_array[i].NC_DATA;}
                    if(value_array[i].ERM_NO_OF_GUESTS==null){var guest='';}else{guest=value_array[i].ERM_NO_OF_GUESTS;}
                    if(value_array[i].ERM_AGE==null){var age='';}else{age=value_array[i].ERM_AGE;}
                    if(value_array[i].ERM_CONTACT_NO==null){var contact='';}else{contact=value_array[i].ERM_CONTACT_NO;}
                    if(value_array[i].ERM_EMAIL_ID==null){var mail='';}else{mail=value_array[i].ERM_EMAIL_ID;}
                    tabledata+='<tr id='+value_array[i].ERM_ID+'>' +
                        "<td style='width:80px !important;vertical-align: middle'><div class='col-lg-1'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit ERM_editbutton' disabled id="+edit+"></div><div class='col-lg-1'><span style='display: block;color:red' title='Delete' class='glyphicon glyphicon-trash ERM_removebutton' disabled id="+del+"></div></td>" +
                        "<td class='ERMEdit' style='width:200px !important;vertical-align: middle' id=Name_"+Ermid+">"+value_array[i].ERM_CUST_NAME+"</td>" +
                        "<td style='width:100px !important;vertical-align: middle' >"+value_array[i].ERM_RENT+"</td>" +
                        "<td style='width:100px !important;vertical-align: middle'>"+value_array[i].MOVING_DATE+"</td>" +
                        "<td style='width:100px !important;vertical-align: middle'>"+value_array[i].ERM_MIN_STAY+"</td>" +
                        "<td style='width:200px !important;vertical-align: middle'>"+value_array[i].ERMO_DATA+"</td>" +
                        "<td style='width:200px !important;vertical-align: middle'>"+nationality+"</td>" +
                        "<td style='width:100px !important;vertical-align: middle'>"+guest+"</td>" +
                        "<td style='width:100px !important;vertical-align: middle'>"+age+"</td>" +
                        "<td style='width:100px !important;vertical-align: middle'>"+contact+"</td>" +
                        "<td style='width:150px !important;vertical-align: middle'>"+mail+"</td>" +
                        "<td style='width:200px !important;vertical-align: middle'>"+value_array[i].ERM_COMMENTS+"</td>" +
                        "<td style='width:150px !important;vertical-align: middle'>"+value_array[i].ULD_LOGINID+"</td>" +
                        "<td style='width:150px !important;vertical-align: middle'>"+value_array[i].ERM_TIME_STAMP+"</td></tr>";
                }
                tabledata+="</body>";
                $('section').html(tabledata);
                $('#ERM_SEARCH_DataTable').show();
                var table = $('#ERM_Datatable').DataTable();
                $("#ERM_src_btn_search").attr("disabled", "disabled");
                $('.preloader').hide();
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
                $('.preloader').hide();
            }
        });
    });
    // *******************ERM DELETE ROW RECORDS FUNCTION START***************//
    var deleterowid;
    $(document).on('click','.ERM_removebutton', function (){
        var id=this.id;
        var SplittedData=id.split('_');
        var Rowid=SplittedData[1];
        deleterowid=Rowid;
        show_msgbox("PAYMENT SEARCH AND UPDATE",SRC_errormsg[8].EMC_DATA,"success","delete");
    });
    $(document).on('click','.deleteconfirm',function(){
        $(".preloader").show();
        $.ajax({
            type: "POST",
            url: "/index.php/Ctrl_Erm_Forms/ERM_Deletion_Details",
            data:{Rowid:deleterowid},
            success: function(data){
                $('.preloader').hide();
                if(data==1)
                {
                    show_msgbox("ERM ENTRY/SEARCH/UPDATE",SRC_errormsg[10].EMC_DATA,"success",false);
                }
                else
                {
                    show_msgbox("ERM ENTRY/SEARCH/UPDATE",data,"success",false);
                }
                $('section').html('');
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
                $('.preloader').hide();
            }
        });
    });
    // *******************ERM DELETE ROW RECORDS FUNCTION END***************//
    //ERM INLINE EDIT
    var pre_tds;
    var selectedrowid;
    $(document).on('click','.ERM_editbutton', function (){
        var cid = $(this).attr('id');
        var SplittedData=cid.split('_');
        var Rowid=SplittedData[1];
        var tds = $('#'+Rowid).children('td');
        selectedrowid=Rowid;
        pre_tds = tds;
        var tdstr = '';
        var edit="Editid_"+Rowid;
        var del="Deleteid_"+Rowid;
        tdstr += "<td style='vertical-align: middle'><div class='col-lg-1'><span style='display: block;color:green' title='Update' class='glyphicon glyphicon-print ERM_editbutton' disabled id="+edit+"></div><div class='col-lg-1'><span style='display: block;color:red' title='Cancel' class='glyphicon glyphicon-remove ERM_editcancel' disabled id="+del+"></div></td>";
        tdstr += "<td style='vertical-align: middle'><input type='text' id=customername  name='customername'  class='autosize form-control FormValidation' style='font-weight:bold;width:200px' value='"+$(tds[1]).html()+"'></td>";
        tdstr += "<td style='vertical-align: middle'><input type='text' id='Rent' name='Rent'  class='form-control FormValidation' style='font-weight:bold;width:100px' value='"+$(tds[2]).html()+"'></td>";
        tdstr += "<td style='vertical-align: middle'><input type='text' id='Movingdate' name='Movingdate'  class='form-control FormValidation' style='font-weight:bold;width:130px' value='"+$(tds[3]).html()+"'></td>";
        tdstr += "<td style='vertical-align: middle'><input type='text' id='Minimumstay' name='Minimumstay'  class='form-control FormValidation' maxlength='10' style='font-weight:bold;width:120px' value='"+$(tds[4]).html()+"'></td>";
        tdstr += "<td style='vertical-align: middle'><SELECT id='Occupation' name='Occupation'  class='form-control FormValidation' style='font-weight:bold;width:200px' value='"+$(tds[5]).html()+"'><OPTION>SELECT</OPTION></SELECT></td>";
        tdstr += "<td style='vertical-align: middle'><SELECT id='Nationality' name='Nationality'  class='form-control FormValidation' style='font-weight:bold;width:250px' value='"+$(tds[6]).html()+"'><OPTION>SELECT</OPTION></SELECT></td>";
        tdstr += "<td style='vertical-align: middle'><input type='text' id='Noofguests' name='Noofguests'  class='form-control alphanumonly FormValidation' maxlength='10' style='font-weight:bold;width:120px' value='"+$(tds[7]).html()+"'></td>";
        tdstr += "<td style='vertical-align: middle'><input type='text' id='age' name='age'  class='form-control alphanumonly FormValidation' maxlength='10' style='font-weight:bold;width:120px' value='"+$(tds[8]).html()+"'></td>";
        tdstr += "<td style='vertical-align: middle'><input type='text' id='Contactno' name='Contactno'  class='form-control FormValidation' maxlength='20' style='font-weight:bold;width:150px' value='"+$(tds[9]).html()+"'></td>";
        tdstr += "<td style='vertical-align: middle'><input type='text' id='Emailid' name='Emailid'  class='form-control FormValidation' maxlength='40' style='font-weight:bold;width:250px' value='"+$(tds[10]).html()+"'></td>";
        tdstr += "<td style='vertical-align: middle'><textarea id='Comments' name='Comments'  class='form-control autogrowcomments FormValidation'  style='font-weight:bold;'>"+$(tds[11]).html()+"</textarea></td>";
        tdstr += "<td style='vertical-align: middle'>"+$(tds[12]).html()+"</td>";
        tdstr += "<td style='vertical-align: middle'>"+$(tds[13]).html()+"</td>";
        $('#'+Rowid).html(tdstr);
        $(".autosize").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
        $("#Contactno").doValidation({rule:'numbersonly',prop:{realpart:20,leadzero:true}});
        $('#ERM_Entry_Emailid').doValidation({rule:'email',prop:{uppercase:false,autosize:true}});
        $(".compautosize").doValidation({prop:{autosize:true}});
        $(".numonly").doValidation({rule:'numbersonly'});
        $("#Rent").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $('.autogrowcomments').autogrow({onInitialize: true});
        $('#Movingdate').datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        var newmovingdate=($(tds[3]).html()).split('-');
        var CERM_NEWsysdate = new Date();
        $('#Movingdate').datepicker("option","minDate",new Date(newmovingdate[2]-1,newmovingdate[1]-1,newmovingdate[0]));
        $('#Movingdate').datepicker("option","maxDate",new Date(CERM_NEWsysdate.getFullYear(),CERM_NEWsysdate.getMonth()+3,CERM_NEWsysdate.getDate()));
        var options='<OPTION>SELECT</OPTION>';
        for (var i = 0; i < occupationvalue.length; i++)
        {
            var data=occupationvalue[i];
            options += '<option value="' + data.ERMO_DATA + '">' + data.ERMO_DATA + '</option>';
        }
        $('#Occupation').html(options);
        $('#Occupation').val($(tds[5]).html());
        var Nation_options='<OPTION>SELECT</OPTION>';
        for (var i = 0; i < SRC_nationality.length; i++)
        {
            var data=SRC_nationality[i];
            Nation_options += '<option value="' + data.NC_DATA + '">' + data.NC_DATA + '</option>';
        }
        $('#Nationality').html(Nation_options);
        if($(tds[6]).html()!="")
        {                $('#Nationality').val($(tds[6]).html());            }
        for(var k=0;k<ERM_id.length;k++)
        {
            $("#Editid_"+ERM_id[k]).removeClass("ERM_editbutton");
            $("#Deleteid_"+ERM_id[k]).removeClass("ERM_removebutton");
        }
        $("#Editid_"+Rowid).attr('title', '');
    });
    $('section').on('click','.ERM_editcancel',function(){
        var cid = $(this).attr('id');
        var SplittedData=cid.split('_');
        var Rowid=SplittedData[1];
        $('#'+Rowid).html(pre_tds);
        $("#Editid_"+Rowid).removeClass("ERM_editcancel");
        for(var k=0;k<ERM_id.length;k++)
        {
            $("#Editid_"+ERM_id[k]).addClass("ERM_editbutton");
            $("#Deleteid_"+ERM_id[k]).addClass("ERM_removebutton");
        }
    });
    $(document).on('change blur','.FormValidation',function(){
        var Emailid=$('#Emailid').val();
        if(Emailid.length>0)
        {
            var CERM_ENTRY_atpos=Emailid.indexOf("@");
            var CERM_ENTRY_dotpos=Emailid.lastIndexOf(".");
            if ((/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(Emailid) || "" == Emailid)&&(CERM_ENTRY_dotpos-1!=Emailid.indexOf(".")))
            {
                var CERM_ENTRY_emailchk="valid";
                $('#Emailid').removeClass('invalid');
                $('#Emailid').val($('#Emailid').val().toLowerCase());
            }
            else
            {
                CERM_ENTRY_emailchk="invalid"
                $('#Emailid').addClass('invalid');
            }
        }
        else
        {
            CERM_ENTRY_emailchk="valid";
            $('#Emailid').removeClass('invalid');
        }
        if($('#customername').val()!="" && $('#Rent').val()!="" && $('#Movingdate').val()!="" && $('#Minimumstay').val()!="" && $('#Occupation').val()!="SELECT" && $('#Comments').val()!='' && CERM_ENTRY_emailchk=='valid')
        {
            $("#Editid_"+selectedrowid).addClass("ERM_Update");
            $("#Editid_"+selectedrowid).attr('title', 'Update');
        }
        else
        {
            $("#Editid_"+selectedrowid).removeClass("ERM_Update");
            $("#Editid_"+selectedrowid).attr('title', 'Please Fill the Required Fields!!!');
        }
    });
    $(document).on('click','.ERM_Update',function(){
        $('.preloader').show();
        var customername= $('#customername').val();
        var Rent=$('#Rent').val();
        var movingdate=$('#Movingdate').val();
        var minimumstay=$('#Minimumstay').val();
        var occupation=$('#Occupation').val();
        var Nationality=$('#Nationality').val();
        if(Nationality=='SELECT'){Nationality='';}
        var guests=$('#Noofguests').val();
        var age=$('#age').val();
        var Contactno=$('#Contactno').val();
        var Emailid=$('#Emailid').val();
        var comments=$('#Comments').val();
        var data={RowId:selectedrowid,Name:customername,Rent:Rent,Movingdate:movingdate,Minstay:minimumstay,Occupation:occupation,Nation:Nationality,Guests:guests,Age:age,Contactno:Contactno,Emailid:Emailid,Comments:comments}
        $.ajax({
            type: "POST",
            url: "/index.php/Ctrl_Erm_Forms/ERM_Updation_Details",
            data:data,
            success: function(msg){
                var value_array=JSON.parse(msg);
                if(value_array[0]==1)
                {
                    show_msgbox("ERM ENTRY/SEARCH/UPDATE",SRC_errormsg[9].EMC_DATA,"success",false);
                    var edit="Editid_"+selectedrowid;
                    var del="Deleteid_"+selectedrowid;
                    var tdstr = '';
                    tdstr += "<td style='vertical-align: middle'><div class='col-lg-1'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit ERM_editbutton' disabled id="+edit+"></div><div class='col-lg-1'><span style='display: block;color:red' title='Delete' class='glyphicon glyphicon-trash ERM_removebutton' disabled id="+del+"></div></td>";
                    tdstr += "<td style='vertical-align: middle'>"+customername+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+Rent+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+movingdate+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+minimumstay+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+occupation+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+Nationality+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+guests+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+age+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+Contactno+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+Emailid+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+comments+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+value_array[2]+"</td>";
                    tdstr += "<td style='vertical-align: middle'>"+value_array[1]+"</td>";
                    $('#'+selectedrowid).html(tdstr);
                    for(var k=0;k<ERM_id.length;k++)
                    {
                        $("#Editid_"+ERM_id[k]).addClass("ERM_editbutton");
                        $("#Deleteid_"+ERM_id[k]).addClass("ERM_removebutton");
                    }
                    $('.preloader').hide();
                }
                else
                {
                    show_msgbox("ERM ENTRY/SEARCH/UPDATE",value_array[0],"success",false);
                    $('.preloader').hide();
                }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(msg));
                $('.preloader').hide();
            }
        });
    });
});
</script>
<body>
<div class="container">
<div class="wrapper">
<div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif" /></div></div></div>
<div class="row title text-center"><h4><b>ERM ENTRY / SEARCH / UPDATE</b></h4></div>
<div class ='row content'>
<div class="panel-body">
<div style="padding-bottom: 25px">
    <div class="radio" style="padding-bottom: 25px">
        <label><input type="radio" name="optradio" value="ERM_entryform" class="BE_rd_selectform">ERM ENTRY</label>
    </div>
    <div class="radio">
        <label><input type="radio" name="optradio" value="ERM_searchform" class="BE_rd_selectform">ERM SEARCH/UDATE/DELETE</label>
    </div>
</div>
<div id="ERM_Entry_Form" style="display:none;">
    <h4 style="color:#498af3;"><U>ERM ENTRY FORM</U></h4>
    <br>
    <form id="ERM_Form_Entry" class="form-horizontal" role="form">
        <div class="row form-group">
            <div class="col-md-3">
                <label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label>
            </div>
            <div class="col-md-3">
                <input class="form-control autosize" name="ERM_Entry_Customername" maxlength="50" required id="ERM_Entry_Customername" placeholder="Customer Name"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>RENT<span class="labelrequired"><em>*</em></span></label>
            </div>
            <div class="col-md-3">
                <input class="form-control amtonly" name="ERM_Entry_Rent" style="width:100px" required id="ERM_Entry_Rent" placeholder="0.00"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>MOVING DATE<span class="labelrequired"><em>*</em></span></label>
            </div>
            <div class="col-md-3">
                <input class="form-control datemandtry" name="ERM_Entry_MovingDate"  style="max-width:120px;" id="ERM_Entry_MovingDate" placeholder="Moving Date" />
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>MINIMUM STAY<span class="labelrequired"><em>*</em></span></label>
            </div>
            <div class="col-md-3">
                <input class="form-control" name="ERM_Entry_Minimumstay" maxlength="10"  style="max-width:120px;" id="ERM_Entry_Minimumstay" placeholder="Minimum Stay" />
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>OCCUPATION<span class="labelrequired"><em>*</em></span></label>
            </div>
            <div class="col-md-3">
                <SELECT class="form-control" name="ERM_Entry_Occupation"  id="ERM_Entry_Occupation">
                    <OPTION>SELECT</OPTION>
                </SELECT>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
            </div>
            <div class="col-md-3">
                <input class="form-control autosize" name="ERM_Entry_Others" id="ERM_Entry_Others" hidden placeholder="Other's Occupation"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>NATIONALITY</label>
            </div>
            <div class="col-md-3">
                <SELECT class="form-control" name="ERM_Entry_Nationality" id="ERM_Entry_Nationality">
                    <OPTION>SELECT</OPTION>
                </SELECT>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>NUMBER OF GUESTS</label>
            </div>
            <div class="col-md-3">
                <input class="form-control alphanumonly" name="ERM_Entry_Numberofguests" maxlength="10" style="max-width:120px;" id="ERM_Entry_Numberofguests" placeholder="Guests"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>AGE</label>
            </div>
            <div class="col-md-3">
                <input class="form-control alphanumonly" name="ERM_Entry_Age" maxlength="10" style="max-width:120px;" id="ERM_Entry_Age" placeholder="Age"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>CONTACT NO</label>
            </div>
            <div class="col-md-3">
                <input class="form-control" name="ERM_Entry_Contactno" maxlength="20" style="max-width:150px;" id="ERM_Entry_Contactno" placeholder="Contact No"/>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>EMAIL ID</label>
            </div>
            <div class="col-md-3">
                <input class="form-control" name="ERM_Entry_Emailid" maxlength="40" id="ERM_Entry_Emailid" placeholder="Email Id"/>
            </div>
            <div class="col-md-3"><label id="CERM_ENTRY_lbl_emailiderrormsg" class='errormsg' hidden></label></div>
        </div>
        <div class="row form-group">
            <div class="col-md-3">
                <label>COMMENTS<span class="labelrequired"><em>*</em></span></label>
            </div>
            <div class="col-md-3">
                <textarea class="form-control autogrowcomments" name="ERM_Entry_Comments" id="ERM_Entry_Comments" placeholder="Comments"></textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-lg-offset-2 col-lg-3">
                <input type="button" id="CERM_ENTRY_btn_savebutton" class="btn" value="SAVE" disabled>         <input type="button" id="CERM_ENTRY_btn_reset" class="btn" value="RESET">
            </div>
        </div>
    </form>
</div>
<div id="ERM_search_update_Form" style="display:none;">
    <form class="form-horizontal" role="form">
        <h4 style="color:#498af3;"><U>ERM SEARCH / UPDATE FORM</U></h4>
        <br>
        <div class="row form-group">
            <div class="col-md-2">
                <label>SEARCH BY<span class="labelrequired"><em>*</em></span></label>
            </div>
            <div class="col-md-3">
                <SELECT class="form-control" name="ERM_SRC_SearchOption"  id="ERM_SRC_SearchOption">
                    <OPTION>SELECT</OPTION>
                </SELECT>
            </div>
        </div>
        <div id="SearchformDiv">

        </div>
        <div id="ERM_SEARCH_DataTable" class="table-responsive" hidden>
            <section>

            </section>
        </div>
    </form>
    <div id="Formcontents" hidden>
        <form id="ERM_SRC_Update" class="form-horizontal" role="form">
            <div class="panel-body">
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control autosize" name="ERM_SRC_Customername" maxlength="50" required id="ERM_SRC_Customername"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>RENT<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control amtonly" name="ERM_SRC_Rent" style="width:100px" required id="ERM_SRC_Rent"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>MOVING DATE<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control datemandtry" name="ERM_SRC_MovingDate"  style="max-width:120px;" id="ERM_SRC_MovingDate" />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>MINIMUM STAY<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" name="ERM_SRC_Minimumstay" maxlength="10"  style="max-width:120px;" id="ERM_SRC_Minimumstay" />
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>OCCUPATION<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-3">
                        <SELECT class="form-control" name="ERM_SRC_Occupation"  id="ERM_SRC_Occupation">
                            <OPTION>SELECT</OPTION>
                        </SELECT>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                        <input class="form-control autosize" name="ERM_SRC_Others" id="ERM_SRC_Others" hidden/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>NATIONALITY</label>
                    </div>
                    <div class="col-md-3">
                        <SELECT class="form-control" name="ERM_SRC_Nationality" id="ERM_SRC_Nationality">
                            <OPTION>SELECT</OPTION>
                        </SELECT>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>NUMBER OF GUESTS</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control alphanumonly" name="ERM_SRC_Numberofguests" maxlength="10" style="max-width:120px;" id="ERM_SRC_Numberofguests"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>AGE</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control alphanumonly" name="ERM_SRC_Age" maxlength="10" style="max-width:120px;" id="ERM_SRC_Age"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>CONTACT NO</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" name="ERM_SRC_Contactno" maxlength="20" style="max-width:150px;" id="ERM_SRC_Contactno"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>EMAIL ID</label>
                    </div>
                    <div class="col-md-3">
                        <input class="form-control" name="ERM_SRC_Emailid" maxlength="40" id="ERM_SRC_Emailid"/>
                    </div>
                    <div class="col-md-3"><label id="CERM_ENTRY_lbl_emailiderrormsg" class='errormsg' hidden></label></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label>COMMENTS<span class="labelrequired"><em>*</em></span></label>
                    </div>
                    <div class="col-md-3">
                        <textarea class="form-control" name="ERM_SRC_Comments" id="ERM_SRC_Comments"></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-offset-2 col-lg-3">
                        <input type="button" id="CERM_ENTRY_btn_savebutton" class="btn" value="SAVE" disabled>         <input type="button" id="CERM_ENTRY_btn_reset" class="btn" value="RESET">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</div>
</body>