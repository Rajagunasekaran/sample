<!--********************************************CHEQUE ENTRY AND SEARCH UPDATE******************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 6.6 -SD:05/06/2015 ED:05/06/2015 GETTING HEADER FILE FROM LIB-->
<!--VER 0.02- SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names t in ver0.02-->
<!--VER 0.01-INITIAL VERSION-SD:21/05/2015 ED:21/05/2015 in ver0.01-->
<html>
<head>
    <?php
    require_once('application/libraries/EI_HDR.php');
    ?>
</head>
<script>
    var ErrorControl ={AmountCompare:'InValid'}
    $(document).ready(function() {
        $('#spacewidth').height('0%');
        $('#CHEQUE_ENTRY_ta_comments').autogrow({onInitialize: true});
        $(".preloader").hide();
        var controller_url="<?php echo base_url(); ?>" + '/index.php/FINANCE/OCBC/Ctrl_Ocbc_Cheque_Entry_Search_Update/' ;
        var Entry_errormsg=[];
        $("#CHEQUE_ENTRY_tb_chequeno").doValidation({rule:'numbersonly',prop:{realpart:6,leadzero:true}});
        $(".autosize").doValidation({rule:'alphanumeric',prop:{whitespace:true,autosize:true}});
        $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $(".numonly").doValidation({rule:'numbersonly'});
        $( "#CHEQUE_ENTRY_db_date").datepicker({dateFormat:'dd-mm-yy',changeYear: true,changeMonth: true});
        $('#CHEQUE_ENTRY_db_date').datepicker("option","maxDate",new Date());
        $('#CHEQUE_ENTRY_db_date').datepicker("option","minDate",new Date(2005,00));
        var Entry_errormsg;
        var SRC_errormsg;
        var Cheque_status;
        $(document).on('click','.BE_rd_selectform',function() {
            $('.preloader').show();
            var value=$("input[name='optradio']:checked").val();
            $('#SearchformDiv').html('');
            $('section').html('');
            $('#Tableheader').text('');
            $('#CHEQUE_SEARCH_DataTable').hide();
            $('#EmptyTableheader').text('');
            if(value=='Cheque_entryform')
            {
                $('#Cheque_Entry_Form').show();
                $('#Cheque_Search_Update_Form').hide();
                $('#Form_Cheque_entry')[0].reset();
                $('#CHEQUE_ENTRY_ta_comments').height(30);
                $("#Cheque_Entry_btn_savebutton").attr("disabled", "disabled");
                $.ajax({
                    type: "POST",
                    url: controller_url+"Cheque_Entry_InitialDataLoad",
                    data:{"Formname":'Cheque_Entry',"ErrorList":'2,3,400'},
                    success: function(data){
                        var value_array=JSON.parse(data);
                        Entry_errormsg=value_array;
                        $('#CHEQUE_ENTRY_tb_chequeno').prop('title',Entry_errormsg[0].EMC_DATA);
                        $('#CHEQUE_ENTRY_tb_amount').prop('title',Entry_errormsg[0].EMC_DATA);
                        $("#CHEQUE_ENTRY_db_date").focus();
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error: function(data){
                        show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                        $('.preloader').hide();
                    }
                });
            }
            else if(value=='Cheque_searchform')
            {
                $('#Cheque_Entry_Form').hide();
                $('#Cheque_Search_Update_Form').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"Cheque_Search_InitialDataLoad",
                    data:{"ErrorList":'1,2,4,45,247,385,401'},
                    success: function(data){
                        var value_array=JSON.parse(data);
                        SRC_errormsg=value_array[0];
                        Cheque_status=value_array[2];
                        var options='<OPTION>SELECT</OPTION>';
                        for (var i = 0; i < value_array[1].length; i++)
                        {
                            var data=value_array[1][i];
                            options += '<option value="' + data.CQCN_ID + '">' + data.CQCN_DATA + '</option>';
                        }
                        $('#CHEQUE_SRC_SearchOption').html(options);
                        $('.preloader').hide();
                    },
                    error: function(data){
                        show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                        $('.preloader').hide();
                    }
                });
            }
        });
        $(document).on('change','#Form_Cheque_entry',function() {
            if($('#CHEQUE_ENTRY_db_date').val()!='' && $('#CHEQUE_ENTRY_tb_chequeno').val()!='' && $('#CHEQUE_ENTRY_tb_chequeto').val()!='' && $('#CHEQUE_ENTRY_tb_chequefor').val()!='' && $('#CHEQUE_ENTRY_tb_amount').val()!='' && $('#CHEQUE_ENTRY_tb_amount').val()!='')
            {
                $("#Cheque_Entry_btn_savebutton").removeAttr("disabled");
            }
            else
            {
                $("#Cheque_Entry_btn_savebutton").attr("disabled", "disabled");
            }
        });
        $(document).on('click','#Cheque_Entry_btn_savebutton',function() {
            $('.preloader').show();
            var FormElements=$('#Form_Cheque_entry').serialize();
            $.ajax({
                type: "POST",
                url: controller_url+"Cheque_Entry_Save",
                data:FormElements,
                success: function(data){
                    var value_array=JSON.parse(data);
                    if(value_array==1)
                    {
                        show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",Entry_errormsg[1].EMC_DATA,"success",false);
                    }
                    else
                    {
                        show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",Entry_errormsg[2].EMC_DATA,"success",false);
                    }
                    $('.preloader').hide();
                    $('#Form_Cheque_entry')[0].reset();
                    $('#CHEQUE_ENTRY_ta_comments').height(30);
                    $("#Cheque_Entry_btn_savebutton").attr("disabled", "disabled");
                },
                error: function(data){
                    show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                    $('.preloader').hide();
                }
            });
        });
        //*******************ERM ENTRY FORM DETAILS END ************************//
        var AllchequenoArray=[];
        var AllchequeunitArray=[];
        var arr;var arrLast;var arrupdate;
        $('#CHEQUE_SRC_SearchOption').change(function(){
            $('#SearchformDiv').html('');
            $('section').html('');
            $('#Tableheader').text('');
            $('#CHEQUE_SEARCH_DataTable').hide();
            $('#EmptyTableheader').text('');
            $('.preloader').show();
            var searchoption=$('#CHEQUE_SRC_SearchOption').val();
            if(searchoption==1)
            {
                var appenddata='<BR><h4 style="color:#498af3;">AMOUNT RANGE SEARCH</h4><BR>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>FROM AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input type=text class="form-control amountonly Amount_btn_validation" name="CQ_SRC_FromAmount"  id="CQ_SRC_FromAmount" style="max-width:120px;" /></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>TO AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-2"><input type=text class="form-control amountonly Amount_btn_validation" name="CQ_SRC_ToAmount"  id="CQ_SRC_ToAmount" style="max-width:120px;" /></div>';
                appenddata+='<div class="col-md-6"><label id="CQ_SRC_lbl_amounterrormsg" class="errormsg" hidden></label></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="CQ_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#SearchformDiv').html(appenddata);
                $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
                $('#CQ_SRC_lbl_amounterrormsg').text(SRC_errormsg[3].EMC_DATA);
                $("#CQ_SRC_FromAmount").focus();
                $('.preloader').hide();
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            }
            else if(searchoption==3)
            {
                var appenddata='<BR><h4 style="color:#498af3;">DATE RANGE SEARCH</h4><BR>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>FROM DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-9"><div class="col-sm-3" style="padding-left: 0px;"><div class="input-group addon"><input type="text" class="form-control Daterange_btn_validation datemandtry" name="CQ_SRC_FromDate" id="CQ_SRC_FromDate"  placeholder="From Date"><label  class="input-group-addon" for=CQ_SRC_FromDate><span class="glyphicon glyphicon-calendar"></span></label></div></div></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>TO DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-9"><div class="col-sm-3" style="padding-left: 0px;"><div class="input-group addon"><input type="text" class="form-control Daterange_btn_validation datemandtry" name="CQ_SRC_ToDate" id="CQ_SRC_ToDate"  placeholder="From Date"><label  class="input-group-addon" for=CQ_SRC_ToDate><span class="glyphicon glyphicon-calendar"></span></label></div></div></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="CQ_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#SearchformDiv').html(appenddata);
                $("#CQ_SRC_FromDate").datepicker({
                    dateFormat: "dd-mm-yy",
                    changeYear: true,
                    changeMonth: true});
                var CCRE_d = new Date();
                var changedmonth=new Date(CCRE_d.setFullYear(2009));
                $('#CQ_SRC_FromDate').datepicker("option","minDate",changedmonth);
                $('#CQ_SRC_FromDate').datepicker("option","maxDate",new Date());
                $("#CQ_SRC_ToDate").datepicker({
                    dateFormat: "dd-mm-yy",
                    changeYear: true,
                    changeMonth: true});
                var CCRE_d = new Date();
                $('#CQ_SRC_ToDate').datepicker("option","minDate",changedmonth);
                $('#CQ_SRC_ToDate').datepicker("option","maxDate",new Date());
                $("#CQ_SRC_FromDate").focus();
                $('.preloader').hide();
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            }
            else if(searchoption==2)
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"ChequeNo",
                    success: function(data){
                        var value_array=JSON.parse(data);
                        var appenddata='<BR><h4 style="color:#498af3;">CHEQUE NUMBER SEARCH</h4><BR>';
                        appenddata+='<div class="row form-group">';
                        appenddata+='<div class="col-md-2"><label>CHEQUE NO<span class="labelrequired"><em>*</em></span></label></div>';
                        appenddata+='<div class="col-md-3"><input type=text class="form-control contactnoautovalidate" name="CQ_SRC_Chequeno"  id="CQ_SRC_Chequeno"/></div>';
                        appenddata+='<div class="col-md-5"><label id="autocompleteerrormsg" class="errormsg" hidden></label></div>';
                        appenddata+='</div>';
                        appenddata+='<div class="row form-group">';
                        appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                        appenddata+='<input type="button" id="CQ_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                        $('#SearchformDiv').html(appenddata);
                        $(".numonly").doValidation({rule:'numbersonly'});
                        for (var i = 0; i < value_array.length; i++)
                        {
                            var data=value_array[i].CHEQUE_NO;
                            AllchequenoArray.push(data);
                        }
                        $('#autocompleteerrormsg').text(SRC_errormsg[5].EMC_DATA);
                        $("#CQ_SRC_Chequeno").focus();
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error: function(data){
                        show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                        $('.preloader').hide();
                    }
                });
            }
            else if(searchoption==4)
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"ChequeUnit",
                    success: function(data){
                        var value_array=JSON.parse(data);
                        var appenddata='<BR><h4 style="color:#498af3;">UNIT SEARCH</h4><BR>';
                        appenddata+='<div class="row form-group">';
                        appenddata+='<div class="col-md-2"><label>UNIT <span class="labelrequired"><em>*</em></span></label></div>';
                        appenddata+='<div class="col-md-3"><input type=text class="form-control contactnoautovalidate" name="CQ_SRC_Chequeunit"  id="CQ_SRC_Chequeunit"/></div>';
                        appenddata+='<div class="col-md-5"><label id="autocompleteerrormsg" class="errormsg" hidden></label></div>';
                        appenddata+='</div>';
                        appenddata+='<div class="row form-group">';
                        appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                        appenddata+='<input type="button" id="CQ_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                        $('#SearchformDiv').html(appenddata);
                        $(".numonly").doValidation({rule:'numbersonly'});
                        for (var i = 0; i < value_array.length; i++)
                        {
                            var data=value_array[i].CHEQUE_UNIT_NO;
                            if(data!=null && data!="" && data!='null')
                            {
                                AllchequeunitArray.push(data);
                            }
                        }
                        $('#autocompleteerrormsg').text(SRC_errormsg[5].EMC_DATA);
                        $("#CQ_SRC_Chequeunit").focus();
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error: function(data){
                        show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                        $('.preloader').hide();
                    }
                });
            }
        });
        var CQ_chequeflag;
        $(document).on('keypress','#CQ_SRC_Chequeno',function() {
            CQ_chequeflag=0;
            CHEQUE_SEARCH_invfromhighlightSearchText();
            $("#CQ_SRC_Chequeno").autocomplete({
                source: AllchequenoArray,
                select: CHEQUE_SEARCH_AutoCompleteSelectHandler
            });
        });
        $(document).on('keypress','#CQ_SRC_Chequeunit',function() {
            CQ_chequeflag=0;
            CHEQUE_SEARCH_invfromhighlightSearchText();
            $("#CQ_SRC_Chequeunit").autocomplete({
                source: AllchequeunitArray,
                select: CHEQUE_SEARCH_AutoCompleteSelectHandler
            });
        });
        function CHEQUE_SEARCH_AutoCompleteSelectHandler(event, ui) {
            CQ_chequeflag=1;
            $('#autocompleteerrormsg').hide();
            $('#CQ_src_btn_search').removeAttr("disabled");
        }
        $(document).on('change','.contactnoautovalidate',function(){
            if(CQ_chequeflag==1){
                $('#autocompleteerrormsg').hide();
            }
            else
            {
                $('#autocompleteerrormsg').show();
                $("#CQ_src_btn_search").attr("disabled", "disabled");
            }
            if($('#CQ_SRC_Chequeno').val()=="")
            {
                $('#autocompleteerrormsg').hide();
                $("#CQ_src_btn_search").attr("disabled", "disabled");
            }
            if($('#CQ_SRC_Chequeunit').val()=="")
            {
                $('#autocompleteerrormsg').hide();
                $("#CQ_src_btn_search").attr("disabled", "disabled");
            }
        });
        //FUNCTION TO HIGHLIGHT SEARCH TEXT//
        function CHEQUE_SEARCH_invfromhighlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            };}
        $(document).on('change','#CQ_SRC_FromDate',function() {
            $('#EmptyTableheader').text('');
            var startdate=$('#CQ_SRC_FromDate').val()
            var currentdate=new Date( Date.parse( FormTableDateFormat(startdate)) )
            var date1 = $('#CQ_SRC_FromDate').datepicker('getDate');
            var date = new Date( Date.parse( date1 ) );
            date.setDate(date.getDate());
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ));
            $('#CQ_SRC_ToDate').datepicker("option","minDate",newDate);
            $('#CQ_SRC_ToDate').datepicker("option","maxDate",new Date());
        });
        //**************DATE RANGE SEARCH SUBMIT BUTTON VALIDATION ****************//
        $(document).on('change','.Daterange_btn_validation',function() {
            $('#EmptyTableheader').text('');
            if(($("#CQ_SRC_FromDate").val()!="")&&($("#CQ_SRC_ToDate").val()!=""))
            {
                $("#CQ_src_btn_search").removeAttr("disabled");
            }
            else
            {
                $("#CQ_src_btn_search").attr("disabled", "disabled");
            }
        });
        $(document).on('change','.Amount_btn_validation',function() {
            $('#EmptyTableheader').text('');
            var CQ_SRC_fromamt=$('#CQ_SRC_FromAmount').val();
            var CQ_SRC_toamt=$('#CQ_SRC_ToAmount').val();
            if(CQ_SRC_fromamt!='' && CQ_SRC_toamt!='')
            {
                if(parseFloat(CQ_SRC_fromamt)<=parseFloat(CQ_SRC_toamt))
                {
                    $("#CQ_src_btn_search").removeAttr("disabled");
                    $('#CQ_SRC_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#CQ_SRC_lbl_amounterrormsg').show();
                    $("#CQ_src_btn_search").attr("disabled", "disabled");
                }
            }
            else
            {
                $('#CQ_SRC_lbl_amounterrormsg').hide();
                $("#CQ_src_btn_search").attr("disabled", "disabled");
            }
        });
        var Cheque_id=[];
        $(document).on('click','#CQ_src_btn_search',function() {
            $('.preloader').show();
            $('#EmptyTableheader').text('');
            var searchoption=$('#CHEQUE_SRC_SearchOption').val();
            if(searchoption==1)
            {
                var FromAmount=$('#CQ_SRC_FromAmount').val();
                var ToAmount=$('#CQ_SRC_ToAmount').val();
                var data={'Option':searchoption,'Data1':FromAmount,'Data2':ToAmount};
                var title="DETAILS OF SELECTED AMOUNT RANGE : "+FromAmount+" TO "+ToAmount;
                var Emptytitle="NO DETAILS OF SELECTED AMOUNT RANGE : "+FromAmount+" TO "+ToAmount;
            }
            if(searchoption==2)
            {
                var chequeno=$("#CQ_SRC_Chequeno").val();
                var data={'Option':searchoption,'Data1':chequeno,'Data2':''};
                var title="DETAILS OF SELECTED CHEQUE NO : "+chequeno;
                var Emptytitle="NO DETAILS OF SELECTED CHEQUE NO : "+chequeno;
            }
            if(searchoption==3)
            {
                var fromdate=$("#CQ_SRC_FromDate").val();
                var todate=$("#CQ_SRC_ToDate").val();
                var data={'Option':searchoption,'Data1':fromdate,'Data2':todate};
                var title="DETAILS OF SELECTED DATE RANGE : "+fromdate+" TO "+todate;
                var Emptytitle="NO DETAILS OF SELECTED DATE RANGE : "+fromdate+" TO "+todate;
            }
            if(searchoption==4)
            {
                var chequeunit=$("#CQ_SRC_Chequeunit").val();
                var data={'Option':searchoption,'Data1':chequeunit,'Data2':''};
                var title="DETAILS OF SELECTED UNIT : "+chequeunit;
                var Emptytitle="NO DETAILS OF SELECTED UNIT : "+chequeunit;
            }
            $("#CQ_src_btn_search").attr("disabled", "disabled");

            $.ajax({
                type: "POST",
                url: controller_url+"Cheque_SearchOption",
                data:data,
                success: function(data){
                    var value_array=JSON.parse(data);
                    if(value_array.length!=0) {
                        $('#Tableheader').text(title);
                        var tabledata = '<table  id="CHEQUE_Datatable" border="1" cellspacing="0"  class="nowrap srcresult"><thead><tr>';
                        tabledata += "<th style='text-align:center;vertical-align: top'>EDIT/UPDATE</th>";
                        tabledata += "<th style='text-align:center;vertical-align: top' class='uk-date-column'>CHEQUE DATE<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='text-align:center;vertical-align: top''>CHEQUE NO<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='text-align:center;vertical-align: top''>CHEQUE TO<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='text-align:center;vertical-align: top''>CHEQUE FOR<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='text-align:center;vertical-align: top''>CHEQUE AMOUNT<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='text-align:center;vertical-align: top''>UNIT</th>";
                        tabledata += "<th style='text-align:center;vertical-align: top''>STATUS<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='text-align:center;vertical-align: top' class='uk-date-column'>DEBITED / REJECTED DATE<span class='labelrequired'><em>*</em></span></th>";
                        tabledata += "<th style='text-align:center;vertical-align: top''>COMMENTS</th>";
                        tabledata += "<th style='text-align:center;vertical-align: top''>USERSTAMP</th>";
                        tabledata += "<th style='text-align:center;vertical-align: top'class='uk-timestp-column'>TIMESTAMP</th>";
                        tabledata += "</tr></thead><tbody>";
                        for (var i = 0; i < value_array.length; i++) {
                            var Ermid = value_array[i].CHEQUE_ID;
                            Cheque_id.push(Ermid)
                            var edit = "Editid_" + value_array[i].CHEQUE_ID;
                            var del = "Deleteid_" + value_array[i].CHEQUE_ID;
                            if (value_array[i].CHEQUE_UNIT_NO == null) {
                                var unit = '';
                            } else {
                                unit = value_array[i].CHEQUE_UNIT_NO;
                            }
                            if (value_array[i].CHEQUE_COMMENTS == null) {
                                var comments = '';
                            } else {
                                comments = value_array[i].CHEQUE_COMMENTS;
                            }
                            if (value_array[i].CHEQUE_DEBITED_RETURNED_DATE == null) {
                                var date = '';
                            } else {
                                date = value_array[i].CHEQUE_DEBITED_RETURNED_DATE;
                            }
                            tabledata += '<tr id=' + value_array[i].CHEQUE_ID + '>' +
                                "<td id=ICON_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle' nowrap><div class='col-lg-2'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit Cheque_editbutton' disabled id=" + edit + "></div></td>" +
                                "<td id=CHKDATE_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle;text-align: center' nowrap>" + value_array[i].CHEQUE_DATE + "</td>" +
                                "<td id=CHKNO_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle;text-align: center' nowrap>" + value_array[i].CHEQUE_NO + "</td>" +
                                "<td id=CHKTO_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle' >" + value_array[i].CHEQUE_TO + "</td>" +
                                "<td id=CHKFOR_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle' >" + value_array[i].CHEQUE_FOR + "</td>" +
                                "<td id=CHKAMT_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle;text-align: center' nowrap>" + value_array[i].CHEQUE_AMOUNT + "</td>" +
                                "<td id=UNIT_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle;text-align: center'nowrap>" + unit + "</td>" +
                                "<td id=STATUS_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle;text-align: center' nowrap>" + value_array[i].BCN_DATA + "</td>" +
                                "<td id=DEBITED_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle;text-align: center' nowrap>" + date + "</td>" +
                                "<td id=COMMENTS_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle'>" + comments + "</td>" +
                                "<td id=USERSTAMP_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle' nowrap>" + value_array[i].ULD_LOGINID + "</td>" +
                                "<td id=TIMESTAMP_"+value_array[i].CHEQUE_ID+" style='vertical-align: middle' nowrap>" + value_array[i].CED_TIME_STAMP + "</td></tr>";
                        }
                        tabledata += "</body>";
                        $('section').html(tabledata);
                        $('#CHEQUE_SEARCH_DataTable').show();
                        var table = $('#CHEQUE_Datatable').DataTable({
                            "sDom":"Rlfrtip",
                            "deferRender":    true,
                            "scrollY": 200,
                            "scrollX": 500,
                            "scrollCollapse": true,
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
                        $('#CHEQUE_SEARCH_DataTable').hide();
                        $('#EmptyTableheader').text(Emptytitle);
                    }
                    $('.preloader').hide();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                },
                error: function(data){
                    show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                    $('.preloader').hide();
                }
            });
        });
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
        var selectedrowid;
        var pre_tds;
        $(document).on('click','.Cheque_editbutton', function (){
            var cid = $(this).attr('id');
            var SplittedData=cid.split('_');
            var Rowid=SplittedData[1];
            var tds = $('#'+Rowid).children('td');
            selectedrowid=Rowid;
            pre_tds = tds;
            var tdstr = '';
            var edit="Editid_"+Rowid;
            var del="Deleteid_"+Rowid;
            arrLast={"ICON":[$('#ICON_'+Rowid).html()],
                "CHKDATE":[$('#CHKDATE_'+Rowid).html()],"CHKNO":[$('#CHKNO_'+Rowid).html()],
                "CHKTO":[$('#CHKTO_'+Rowid).html()],"CHKFOR":[$('#CHKFOR_'+Rowid).html()],
                "CHKAMT":[$('#CHKAMT_'+Rowid).html()],"UNIT":[$('#UNIT_'+Rowid).html()],
                "STATUS":[$('#STATUS_'+Rowid).html()],"DEBITED":[$('#DEBITED_'+Rowid).html()],"COMMENTS":[$('#COMMENTS_'+Rowid).html()],"USERSTAMP":[$('#USERSTAMP_'+Rowid).html()],"TIMESTAMP":[$('#TIMESTAMP_'+Rowid).html()]}
            arr={"ICON":["<div class='col-lg-1'><span style='display: block;color:green' title='Update' class='glyphicon glyphicon-print Cheque_editbutton' disabled id="+edit+"></div><div class='col-lg-1'><span style='display: block;color:red' title='Cancel' class='glyphicon glyphicon-remove Cheque_editcancel' disabled id="+del+"></div>"],
                "CHKDATE":["<input type='text' id=chequedate  name='chequedate'  class='numonly datemandtry form-control FormValidation' style='font-weight:bold;width:120px' value='"+$('#CHKDATE_'+Rowid).html()+"'>"],
                "CHKNO":["<input type='text' id='chequeno' name='chequeno'  class='form-control FormValidation' maxlength='6' style='font-weight:bold;width:100px' value='"+$('#CHKNO_'+Rowid).html()+"'>"],
                "CHKTO":["<textarea id='chequeto' name='chequeto'  class='form-control FormValidation autogrowcomments autosize' maxlength='100' style='font-weight:bold;'>"+$('#CHKTO_'+Rowid).html()+"</textarea>"],
                "CHKFOR":["<textarea id='chequefor' name='chequefor'  class='form-control FormValidation autogrowcomments autosize' maxlength='100' style='font-weight:bold;'>"+$('#CHKFOR_'+Rowid).html()+"</textarea>"],
                "CHKAMT":["<input id='amount' name='amount'  class='amtonly form-control FormValidation' style='font-weight:bold;width:120px' value='"+$('#CHKAMT_'+Rowid).html()+"'>"],
                "UNIT":["<input id='unit' name='unit'  class='form-control FormValidation' style='font-weight:bold;width:150px' value='"+$('#UNIT_'+Rowid).html()+"'>"],
                "STATUS":["<SELECT id='status' name='status'  class='form-control  FormValidation Debitedvalidation'  style='font-weight:bold;width:150px' value='"+$('#STATUS_'+Rowid).html()+"'><OPTION>SELECT</OPTION></SELECT>"],
                "DEBITED":["<div class='col-sm-4'><div class='input-group addon'><input type='text' class='form-control FormValidation datemandtry' id=debiteddate style='width:120px;' value='"+$('#DEBITED_'+Rowid).html()+"'><label  class='input-group-addon' for=debiteddate><span class='glyphicon glyphicon-calendar'></span></label></div></div>"],
                "COMMENTS":["<textarea id='Comments' name='Comments'  class='form-control autogrowcomments FormValidation'  style='font-weight:bold;'>"+$('#COMMENTS_'+Rowid).html()+"</textarea>"],
                "USERSTAMP":[$('#USERSTAMP_'+Rowid).html()],
                "TIMESTAMP":[$('#TIMESTAMP_'+Rowid).html()]}
            for(var t=0;t<tds.length;t++){
                $(tds[t]).html(arr[$(tds[t]).attr('id').split('_')[0]][0]);
            }
            tdstr += "<td style='vertical-align: middle'><div class='col-lg-1'><span style='display: block;color:green' title='Update' class='glyphicon glyphicon-print Cheque_editbutton' disabled id="+edit+"></div><div class='col-lg-1'><span style='display: block;color:red' title='Cancel' class='glyphicon glyphicon-remove Cheque_editcancel' disabled id="+del+"></div></td>";
            tdstr += "<td style='vertical-align: middle'><input type='text' id=chequedate  name='chequedate'  class='numonly datemandtry form-control FormValidation' style='font-weight:bold;width:120px' value='"+$(tds[1]).html()+"'></td>";
            tdstr += "<td style='vertical-align: middle'><input type='text' id='chequeno' name='chequeno'  class='form-control FormValidation' maxlength='6' style='font-weight:bold;width:100px' value='"+$(tds[2]).html()+"'></td>";
            tdstr += "<td style='vertical-align: middle'><textarea id='chequeto' name='chequeto'  class='form-control FormValidation autogrowcomments autosize' maxlength='100' style='font-weight:bold;'>"+$(tds[3]).html()+"</textarea></td>";
            tdstr += "<td style='vertical-align: middle'><textarea id='chequefor' name='chequefor'  class='form-control FormValidation autogrowcomments autosize' maxlength='100' style='font-weight:bold;'>"+$(tds[4]).html()+"</textarea></td>";
            tdstr += "<td style='vertical-align: middle'><input id='amount' name='amount'  class='amtonly form-control FormValidation' style='font-weight:bold;width:120px' value='"+$(tds[5]).html()+"'></td>";
            tdstr += "<td style='vertical-align: middle'><input id='unit' name='unit'  class='form-control FormValidation' style='font-weight:bold;width:150px' value='"+$(tds[6]).html()+"'></td>";
            tdstr += "<td style='vertical-align: middle'><SELECT id='status' name='status'  class='form-control  FormValidation Debitedvalidation'  style='font-weight:bold;width:150px' value='"+$(tds[7]).html()+"'><OPTION>SELECT</OPTION></SELECT></td>";
            tdstr += "<td style='vertical-align: middle'><div class='col-sm-4'><div class='input-group addon'><input type='text' class='form-control FormValidation datemandtry' id=debiteddate style='width:120px;' value='"+$(tds[8]).html()+"'><label  class='input-group-addon' for=debiteddate><span class='glyphicon glyphicon-calendar'></span></label></div></div></td>";
            tdstr += "<td style='vertical-align: middle'><textarea id='Comments' name='Comments'  class='form-control autogrowcomments FormValidation'  style='font-weight:bold;'>"+$(tds[9]).html()+"</textarea></td>";
            tdstr += "<td style='vertical-align: middle'>"+$(tds[10]).html()+"</td>";
            tdstr += "<td style='vertical-align: middle'>"+$(tds[11]).html()+"</td>";
//            $('#'+Rowid).html(tdstr);
            $(".autosize").doValidation({rule:'alphanumeric',prop:{whitespace:true,autosize:true}});
            $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
            $(".numonly").doValidation({rule:'numbersonly'});
            $('.autogrowcomments').autogrow({onInitialize: true})
            var options='<option>SELECT</option>';
            for(var i=0;i<Cheque_status.length;i++)
            {
                var data=Cheque_status[i];
                options += '<option value="' + data.BCN_DATA + '">' + data.BCN_DATA + '</option>';
            }
            $('#status').html(options);
            $('#status').val(arrLast["STATUS"][0]);
            $('#debiteddate').datepicker({
                dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true
            });
            $("#chequedate").datepicker({dateFormat:'dd-mm-yy',changeYear: true,changeMonth: true});
            $('#chequedate').datepicker("option","minDate",new Date(2005,00));
            var chequenewdate=new Date();
            $('#chequedate').datepicker("option","maxDate",new Date());
            var CCRE_date1=arrLast["CHKDATE"][0];
            var CCRE_db_chkindate1 = new Date( Date.parse( FormTableDateFormat(CCRE_date1)));
            CCRE_db_chkindate1.setDate( CCRE_db_chkindate1.getDate());
            var CCRE_db_chkindate1 = CCRE_db_chkindate1.toDateString();
            CCRE_db_chkindate1 = new Date( Date.parse( CCRE_db_chkindate1 ) );
            $('#debiteddate').datepicker("option","minDate",CCRE_db_chkindate1);
            $('#debiteddate').datepicker("option","maxDate",new Date());
            for(var k=0;k<Cheque_id.length;k++)
            {
                $("#Editid_"+Cheque_id[k]).removeClass("Cheque_editbutton");
            }
            if(arrLast["DEBITED"][0]=="ENTERED" || arrLast["DEBITED"][0]=="CREATED" || arrLast["DEBITED"][0]=="CANCELLED")
            {
                $('#debiteddate').prop('disabled',true);
            }
        });
        $(document).on('change','#chequedate', function (){
            var debiteddate=$('#chequedate').val()
            var CCRE_db_chkindate1 = new Date( Date.parse( FormTableDateFormat(debiteddate)));
            CCRE_db_chkindate1.setDate( CCRE_db_chkindate1.getDate());
            var CCRE_db_chkindate1 = CCRE_db_chkindate1.toDateString();
            CCRE_db_chkindate1 = new Date( Date.parse( CCRE_db_chkindate1 ) );
            $('#debiteddate').datepicker("option","minDate",CCRE_db_chkindate1);
        });
        //*******************DEBITED DATE **********************//
        $(document).on('change','#status', function ()
        {
            if(($('#status').val()!="SELECT")&&($('#status').val()!="ENTERED")&&($('#status').val()!="CREATED")&&($('#status').val()!="CANCELLED"))
            {
                $('#debiteddate').val('');
                $('#debiteddate').prop('disabled',false);
            }
            else
            {
                $('#debiteddate').val('');
                $('#debiteddate').prop('disabled',true);
            }
        });
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        $('section').on('click','.Cheque_editcancel',function(){
            var cid = $(this).attr('id');
            var SplittedData=cid.split('_');
            var Rowid=SplittedData[1];
//            $('#'+Rowid).html(pre_tds);
            var tds = $('#'+Rowid).children('td');
//            alert(Rowid);
            for(var t=0;t<tds.length;t++){
                $(tds[t]).html(arrLast[$(tds[t]).attr('id').split('_')[0]][0]);
            }
            $("#Editid_"+Rowid).removeClass("Cheque_editcancel");
            for(var k=0;k<Cheque_id.length;k++)
            {
                $("#Editid_"+Cheque_id[k]).addClass("Cheque_editbutton");
            }
        });
        //*******************UPDATION FORM VALIDATION*****************************//
        $(document).on('change blur','.FormValidation',function(){
            var status=$('#status').val();
            if((status!="SELECT")&&(status!="CREATED") && (status!="CANCELLED") && (status!='ENTERED'))
            {
                if($('#chequedate').val()!='' && status!="SELECT" && $('#chequeno').val()!='' && $('#chequeto').val()!='' && $('#chequefor').val()!='' && $('#amount').val()!='' && $('#amount').val()!='' && $('#debiteddate').val()!='')
                {
                    $("#Editid_"+selectedrowid).addClass("Cheque_Update");
                    $("#Editid_"+selectedrowid).attr('title', 'Update');
                }
                else
                {
                    $("#Editid_"+selectedrowid).removeClass("Cheque_Update");
                    $("#Editid_"+selectedrowid).attr('title', 'Please Fill the Required Fields!!!');
                }
            }
            else
            {
                if($('#chequedate').val()!='' && status!="SELECT" && $('#chequeno').val()!='' && $('#chequeto').val()!='' && $('#chequefor').val()!='' && $('#amount').val()!="")
                {
                    $("#Editid_"+selectedrowid).addClass("Cheque_Update");
                    $("#Editid_"+selectedrowid).attr('title', 'Update');
                }
                else
                {
                    $("#Editid_"+selectedrowid).attr('title', 'Please Fill the Required Fields!!!');
                    $("#Editid_"+selectedrowid).removeClass("Cheque_Update");
                }
            }
        });
        $(document).on('click','.Cheque_Update',function(){
            $('.preloader').show();
            var cheque_date=$('#chequedate').val();
            var cheque_no=$('#chequeno').val();
            var cheque_to=$('#chequeto').val();
            var check_for=$('#chequefor').val();
            var check_amount=$('#amount').val();
            var status=$('#status').val();
            var debiteddate=$('#debiteddate').val();
            var unit=$('#unit').val();
            var comments=$('#Comments').val();
            var data={"ID":selectedrowid,"cheque_date":cheque_date,"cheque_no":cheque_no,"cheque_to":cheque_to,"check_for":check_for,"check_amount":check_amount,"status":status,"debiteddate":debiteddate,"unit":unit,"comments":comments};
            $.ajax({
                type: "POST",
                url: controller_url+"Cheque_Updation_Details",
                data:data,
                success: function(msg){
                    var value_array=JSON.parse(msg);
                    if(value_array[0]==1)
                    {
                        var tdstr = '';
                        var edit="Editid_"+selectedrowid;
                        var del="Deleteid_"+selectedrowid;
                        tdstr += "<td style='vertical-align: middle'><div class='col-lg-2'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit Cheque_editbutton' disabled id="+edit+"></div></td>";
                        tdstr += "<td style='vertical-align: middle;text-align: center'>"+cheque_date+"</td>";
                        tdstr += "<td style='vertical-align: middle;text-align: center'>"+cheque_no+"</td>";
                        tdstr += "<td style='vertical-align: middle'>"+cheque_to+"</td>";
                        tdstr += "<td style='vertical-align: middle'>"+check_for+"</td>";
                        tdstr += "<td style='vertical-align: middle;text-align: center'>"+check_amount+"</td>";
                        tdstr += "<td style='vertical-align: middle;text-align: center'>"+unit+"</td>";
                        tdstr += "<td style='vertical-align: middle;text-align: center'>"+status+"</td>";
                        tdstr += "<td style='vertical-align: middle;text-align: center'>"+debiteddate+"</td>";
                        tdstr += "<td style='vertical-align: middle'>"+comments+"</td>";
                        tdstr += "<td style='vertical-align: middle'>"+value_array[1]+"</td>";
                        tdstr += "<td style='vertical-align: middle'>"+value_array[2]+"</td>";
//                        $('#'+selectedrowid).html(tdstr);
                        arrupdate={"ICON":["<div class='col-lg-2'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit Cheque_editbutton' disabled id="+edit+"></div>"],
                            "CHKDATE":[cheque_date],"CHKNO":[cheque_no],
                            "CHKTO":[cheque_to],"CHKFOR":[check_for],
                            "CHKAMT":[check_amount],"UNIT":[unit],
                            "STATUS":[status],"DEBITED":[debiteddate],"COMMENTS":[comments],"USERSTAMP":[value_array[1]],"TIMESTAMP":[value_array[2]]}
                        var tds = $('#'+selectedrowid).children('td');
                        for(var t=0;t<tds.length;t++){
                            $(tds[t]).html(arrupdate[$(tds[t]).attr('id').split('_')[0]][0]);
                        }
                        $('.preloader').hide();
                        for(var k=0;k<Cheque_id.length;k++)
                        {
                            $("#Editid_"+Cheque_id[k]).addClass("Cheque_editbutton");
                        }
                        show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",SRC_errormsg[2].EMC_DATA,"success",false);
                    }
                    else
                    {
                        show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",SRC_errormsg[6].EMC_DATA,"success",false);
                    }
                },
                error: function(data){
                    show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('click','#Cheque_btn_pdf',function(){
            var searchoption=$('#CHEQUE_SRC_SearchOption').val();
            if(searchoption==1)
            {
                var FromAmount=$('#CQ_SRC_FromAmount').val();
                var ToAmount=$('#CQ_SRC_ToAmount').val();
                var title="DETAILS OF SELECTED AMOUNT RANGE : "+FromAmount+" TO "+ToAmount;
            }
            if(searchoption==2)
            {
                var FromAmount=$("#CQ_SRC_Chequeno").val();
                var ToAmount='';
                var title="DETAILS OF SELECTED CHEQUE NO : "+FromAmount;
            }
            if(searchoption==3)
            {
                var FromAmount=$("#CQ_SRC_FromDate").val();
                var ToAmount=$("#CQ_SRC_ToDate").val();
                var title="DETAILS OF SELECTED DATE RANGE : "+FromAmount+" TO "+ToAmount;
            }
            if(searchoption==4)
            {
                var FromAmount=$("#CQ_SRC_Chequeunit").val();
                var ToAmount='';
                var title="DETAILS OF SELECTED UNIT : "+FromAmount;
            }
            var pdfurl=document.location.href='<?php echo site_url('FINANCE/OCBC/Ctrl_Ocbc_Cheque_Entry_Search_Update/ChequePdfCreation')?>?Searchoption='+searchoption+'&Frominput='+FromAmount+'&Todate='+ToAmount+'&Header='+title;
        });
    });
</script>
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>CHEQUE ENTRY / SEARCH / UPDATE</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <div style="padding-bottom: 25px">
                    <div class="radio" style="padding-bottom: 25px">
                        <label><input type="radio" name="optradio" value="Cheque_entryform" class="BE_rd_selectform">CHEQUE ENTRY</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio" value="Cheque_searchform" class="BE_rd_selectform">CHEQUE SEARCH/UDATE/DELETE</label>
                    </div>
                </div>
                <div id="Cheque_Entry_Form" hidden>
                    <form id="Form_Cheque_entry" class="form-horizontal" role="form">
                        <h4 style="color:#498af3;">CHEQUE ENTRY FORM</h4>
                        <br>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CHEQUE DATE<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-9">
                                <div class="col-sm-3" style="padding-left: 0px;">
                                    <div class="input-group addon">
                                        <input type="text" class="form-control datemandtry" name="CHEQUE_ENTRY_db_date" id="CHEQUE_ENTRY_db_date"  placeholder="Cheque Date"><label  class="input-group-addon" for=CHEQUE_ENTRY_db_date><span class="glyphicon glyphicon-calendar"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CHEQUE NO<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="CHEQUE_ENTRY_tb_chequeno" maxlength="6" style="width:120px" required id="CHEQUE_ENTRY_tb_chequeno" placeholder="Cheque No"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CHEQUE TO<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control autosize" name="CHEQUE_ENTRY_tb_chequeto" maxlength="100" required id="CHEQUE_ENTRY_tb_chequeto" placeholder="Cheque To"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CHEQUE FOR<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control autosize" name="CHEQUE_ENTRY_tb_chequefor" maxlength="100" required id="CHEQUE_ENTRY_tb_chequefor" placeholder="Cheque For"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CHEQUE AMOUNT<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control amtonly" name="CHEQUE_ENTRY_tb_amount" style="width:120px" required id="CHEQUE_ENTRY_tb_amount" placeholder="0.00"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>UNIT</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control numberonlycommas" name="CHEQUE_ENTRY_tb_unit" maxlength="25" required id="CHEQUE_ENTRY_tb_unit" placeholder="Unit"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>COMMENTS<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <textarea class="form-control autogrowcomments" name="CHEQUE_ENTRY_ta_comments" id="CHEQUE_ENTRY_ta_comments" placeholder="Comments"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-offset-2 col-lg-3">
                                <input type="button" id="Cheque_Entry_btn_savebutton" class="btn" value="SAVE" disabled>         <input type="button" id="Cheque_Entry_btn_reset" class="btn" value="RESET">
                            </div>
                        </div>
                    </form>
                </div>
                <div id="Cheque_Search_Update_Form" hidden>
                    <form id="Form_Cheque_searchupdate" class="form-horizontal" role="form">
                        <h4 style="color:#498af3;"><U>CHEQUE SEARCH / UPDATE FORM</U></h4>
                        <br>
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label>SEARCH BY<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <SELECT class="form-control" name="CHEQUE_SRC_SearchOption"  id="CHEQUE_SRC_SearchOption">
                                    <OPTION>SELECT</OPTION>
                                </SELECT>
                            </div>
                        </div>

                        <div id="SearchformDiv">

                        </div>
                        <div id="CHEQUE_SEARCH_DataTable" class="table-responsive" hidden>
                            <h4 style="color:#498af3;" id="Tableheader"></h4>
                            <input type="button" id="Cheque_btn_pdf" class="btnpdf" value="PDF">
                            <section>

                            </section>
                        </div>
                        <div>
                            <h4 class="errormsg" id="EmptyTableheader"></h4>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
