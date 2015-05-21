<html>
<head>
    <?php include 'Header.php'; ?>
</head>
<script>
    var ErrorControl ={AmountCompare:'InValid'}
    $(document).ready(function() {
        $('#CHEQUE_ENTRY_ta_comments').autogrow({onInitialize: true});
        $(".preloader").hide();
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
            if(value=='Cheque_entryform')
            {
                $('#Cheque_Entry_Form').show();
                $('#Cheque_Search_Update_Form').hide();
                $('#Form_Cheque_entry')[0].reset();
                $('#CHEQUE_ENTRY_ta_comments').height(30);
                $("#Cheque_Entry_btn_savebutton").attr("disabled", "disabled");
                $.ajax({
                    type: "POST",
                    url: '/index.php/Ctrl_Cheque_Forms/Cheque_Entry_InitialDataLoad',
                    data:{"Formname":'Cheque_Entry',"ErrorList":'2,3,400'},
                    success: function(data){
                        var value_array=JSON.parse(data);
                        Entry_errormsg=value_array;
                        $('#CHEQUE_ENTRY_tb_chequeno').prop('title',Entry_errormsg[0].EMC_DATA);
                        $('#CHEQUE_ENTRY_tb_amount').prop('title',Entry_errormsg[0].EMC_DATA);
                        $('.preloader').hide();
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
                    url: '/index.php/Ctrl_Cheque_Forms/Cheque_Search_InitialDataLoad',
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
                url: '/index.php/Ctrl_Cheque_Forms/Cheque_Entry_Save',
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
        $('#CHEQUE_SRC_SearchOption').change(function(){
            $('#SearchformDiv').html('');
            $('section').html('');
            $('#Tableheader').text('');
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
                $('.preloader').hide();
            }
            else if(searchoption==3)
            {
                var appenddata='<BR><h4 style="color:#498af3;">DATE RANGE SEARCH</h4><BR>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>FROM DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input class="form-control Daterange_btn_validation" name="CQ_SRC_FromDate"  id="CQ_SRC_FromDate" style="max-width:120px;" /></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>TO DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input class="form-control Daterange_btn_validation" name="CQ_SRC_ToDate"  id="CQ_SRC_ToDate" style="max-width:120px;" /></div></div>';
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
                $('.preloader').hide();
            }
            else if(searchoption==2)
            {
                $.ajax({
                    type: "POST",
                    url: '/index.php/Ctrl_Cheque_Forms/ChequeNo',
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
                        $('.preloader').hide();
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
                    url: '/index.php/Ctrl_Cheque_Forms/ChequeUnit',
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
                        $('.preloader').hide();
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
            var searchoption=$('#CHEQUE_SRC_SearchOption').val();
            if(searchoption==1)
            {
                var FromAmount=$('#CQ_SRC_FromAmount').val();
                var ToAmount=$('#CQ_SRC_ToAmount').val();
                var data={'Option':searchoption,'Data1':FromAmount,'Data2':ToAmount};
                $('#CQ_SRC_FromAmount').val('');
                $('#CQ_SRC_ToAmount').val('');
                var title="DETAILS OF SELECTED AMOUNT RANGE : "+FromAmount+" TO "+ToAmount;
            }
            if(searchoption==2)
            {
                var chequeno=$("#CQ_SRC_Chequeno").val();
                var data={'Option':searchoption,'Data1':chequeno,'Data2':''};
                $('#CQ_SRC_Chequeno').val('');
                var title="DETAILS OF SELECTED CHEQUE NO : "+chequeno;
            }
            if(searchoption==3)
            {
             var fromdate=$("#CQ_SRC_FromDate").val();
             var todate=$("#CQ_SRC_ToDate").val();
             var data={'Option':searchoption,'Data1':fromdate,'Data2':todate};
             $('#CQ_SRC_FromDate').val('');
             $('#CQ_SRC_ToDate').val('');
             var title="DETAILS OF SELECTED DATE RANGE : "+fromdate+" TO "+todate;
            }
            if(searchoption==4)
            {
                var chequeunit=$("#CQ_SRC_Chequeunit").val();
                var data={'Option':searchoption,'Data1':chequeunit,'Data2':''};
                $('#CQ_SRC_Chequeunit').val('');
                var title="DETAILS OF SELECTED UNIT : "+chequeunit;
            }
            $("#CQ_src_btn_search").attr("disabled", "disabled");
            $('#Tableheader').text(title);
            $.ajax({
                type: "POST",
                url: '/index.php/Ctrl_Cheque_Forms/Cheque_SearchOption',
                data:data,
                success: function(data){
                    var value_array=JSON.parse(data);
                    var tabledata="<table id='CHEQUE_Datatable' border=1 cellspacing='0' data-class='table'  class='srcresult table' style='width:2200px;' >";
                    tabledata+="<thead class='headercolor'><tr class='head' style='text-align:center'>";
                    tabledata+="<th style='text-align:center;vertical-align: top'>EDIT/UPDATE</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top'>CHEQUE DATE<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>CHEQUE NO<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>CHEQUE TO<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>CHEQUE FOR<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>CHEQUE AMOUNT<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>UNIT</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>STATUS<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>DEBITED / REJECTED DATE<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>COMMENTS</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>USERSTAMP</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>TIMESTAMP</th>";
                    tabledata+="</tr></thead><tbody>";
                    for(var i=0;i<value_array.length;i++)
                    {
                        var Ermid=value_array[i].CHEQUE_ID;
                        Cheque_id.push(Ermid)
                        var edit="Editid_"+value_array[i].CHEQUE_ID;
                        var del="Deleteid_"+value_array[i].CHEQUE_ID;
                        if(value_array[i].CHEQUE_UNIT_NO==null){var unit='';}else{unit=value_array[i].CHEQUE_UNIT_NO;}
                        if(value_array[i].CHEQUE_COMMENTS==null){var comments='';}else{comments=value_array[i].CHEQUE_COMMENTS;}
                        if(value_array[i].CHEQUE_DEBITED_RETURNED_DATE==null){var date='';}else{date=value_array[i].CHEQUE_DEBITED_RETURNED_DATE;}
                        tabledata+='<tr id='+value_array[i].CHEQUE_ID+'>' +
                            "<td style='width:80px !important;vertical-align: middle'><div class='col-lg-2'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit Cheque_editbutton' disabled id="+edit+"></div></td>" +
                            "<td style='width:100px !important;vertical-align: middle;text-align: center'>"+value_array[i].CHEQUE_DATE+"</td>" +
                            "<td style='width:100px !important;vertical-align: middle;text-align: center' >"+value_array[i].CHEQUE_NO+"</td>" +
                            "<td style='width:250px !important;vertical-align: middle'>"+value_array[i].CHEQUE_TO+"</td>" +
                            "<td style='width:250px !important;vertical-align: middle'>"+value_array[i].CHEQUE_FOR+"</td>" +
                            "<td style='width:120px !important;vertical-align: middle;text-align: center'>"+value_array[i].CHEQUE_AMOUNT+"</td>" +
                            "<td style='width:150px !important;vertical-align: middle;text-align: center'>"+unit+"</td>" +
                            "<td style='width:100px !important;vertical-align: middle;text-align: center'>"+value_array[i].BCN_DATA+"</td>" +
                            "<td style='width:100px !important;vertical-align: middle;text-align: center'>"+date+"</td>" +
                            "<td style='width:250px !important;vertical-align: middle'>"+comments+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+value_array[i].ULD_LOGINID+"</td>" +
                            "<td style='width:150px !important;vertical-align: middle'>"+value_array[i].CED_TIME_STAMP+"</td></tr>";
                    }
                    tabledata+="</body>";
                    $('section').html(tabledata);
                    $('#CHEQUE_SEARCH_DataTable').show();
                    var table = $('#CHEQUE_Datatable').DataTable();
                },
                error: function(data){
                    show_msgbox("CHEQUE ENTRY/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                }
            });
        });
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
            tdstr += "<td style='vertical-align: middle'><div class='col-lg-1'><span style='display: block;color:green' title='Update' class='glyphicon glyphicon-print Cheque_editbutton' disabled id="+edit+"></div><div class='col-lg-1'><span style='display: block;color:red' title='Cancel' class='glyphicon glyphicon-remove Cheque_editcancel' disabled id="+del+"></div></td>";
            tdstr += "<td style='vertical-align: middle'><input type='text' id=chequedate  name='chequedate'  class='numonly datemandtry form-control FormValidation' style='font-weight:bold;width:120px' value='"+$(tds[1]).html()+"'></td>";
            tdstr += "<td style='vertical-align: middle'><input type='text' id='chequeno' name='chequeno'  class='form-control FormValidation' maxlength='6' style='font-weight:bold;width:100px' value='"+$(tds[2]).html()+"'></td>";
            tdstr += "<td style='vertical-align: middle'><textarea id='chequeto' name='chequeto'  class='form-control FormValidation autogrowcomments autosize' maxlength='100' style='font-weight:bold;'>"+$(tds[3]).html()+"</textarea></td>";
            tdstr += "<td style='vertical-align: middle'><textarea id='chequefor' name='chequefor'  class='form-control FormValidation autogrowcomments autosize' maxlength='100' style='font-weight:bold;'>"+$(tds[4]).html()+"</textarea></td>";
            tdstr += "<td style='vertical-align: middle'><input id='amount' name='amount'  class='amtonly form-control FormValidation' style='font-weight:bold;width:120px' value='"+$(tds[5]).html()+"'></td>";
            tdstr += "<td style='vertical-align: middle'><input id='unit' name='unit'  class='form-control FormValidation' style='font-weight:bold;width:150px' value='"+$(tds[6]).html()+"'></td>";
            tdstr += "<td style='vertical-align: middle'><SELECT id='status' name='status'  class='form-control  FormValidation Debitedvalidation'  style='font-weight:bold;width:150px' value='"+$(tds[7]).html()+"'><OPTION>SELECT</OPTION></SELECT></td>";
            tdstr += "<td style='vertical-align: middle'><input type='text' id='debiteddate' name='debiteddate'  class='form-control FormValidation' style='font-weight:bold;width:120px' value='"+$(tds[8]).html()+"'></td>";
            tdstr += "<td style='vertical-align: middle'><textarea id='Comments' name='Comments'  class='form-control autogrowcomments FormValidation'  style='font-weight:bold;'>"+$(tds[9]).html()+"</textarea></td>";
            tdstr += "<td style='vertical-align: middle'>"+$(tds[10]).html()+"</td>";
            tdstr += "<td style='vertical-align: middle'>"+$(tds[11]).html()+"</td>";
            $('#'+Rowid).html(tdstr);
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
            $('#status').val($(tds[7]).html());
            $('#debiteddate').datepicker({
                dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true
            });
            $("#chequedate").datepicker({dateFormat:'dd-mm-yy',changeYear: true,changeMonth: true});
            $('#chequedate').datepicker("option","minDate",new Date(2005,00));
            var chequenewdate=new Date();
            $('#chequedate').datepicker("option","maxDate",new Date());
            var CCRE_date1=$(tds[1]).html();
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
            if($(tds[7]).html()=="ENTERED" || $(tds[7]).html()=="CREATED" || $(tds[7]).html()=="CANCELLED")
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
            $('#'+Rowid).html(pre_tds);
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
                url: "/index.php/Ctrl_Cheque_Forms/Cheque_Updation_Details",
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
                        $('#'+selectedrowid).html(tdstr);
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
    });
 </script>
<body>
<div class="container">
    <div class="wrapper">
        <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif" /></div></div></div>
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
                        <h4 style="color:#498af3;"><U>CHEQUE ENTRY FORM</U></h4>
                        <br>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>CHEQUE DATE<span class="labelrequired"><em>*</em></span></label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control datemandtry" name="CHEQUE_ENTRY_db_date" required id="CHEQUE_ENTRY_db_date" style="width:120px" placeholder="Cheque Date"/>
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
                                <section>

                                </section>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
