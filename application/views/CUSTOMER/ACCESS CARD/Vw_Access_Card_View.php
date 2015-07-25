<?php
//******************************************View All Card********************************************//
//VER 0.01-SD:09/05/2015 ED:12/05/2015,initial version BY RAJA
//*******************************************************************************************************//
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <style>
        .colerr {
            padding-top: 9px;
        }
        .colsmhf {
            width: 11.666%;
            padding-top: 2px;
            padding-left: 15px;
            padding-right: 0px;
        }
    </style>
    <script type="text/javascript">
    // document ready function
        $(document).ready(function(){
            var ctrl_cardview_url="<?php echo site_url('CUSTOMER/ACCESSCARD/Ctrl_Access_Card_View'); ?>";
        // initial data
            $('#spacewidth').height('0%');
            var CV_errorAarray=[];
            var CV_cust_array=[];
            var CV_customername=[];
            var CV_customerflag;
            var custnameid='';
            $.ajax({
                type:'POST',
                url:ctrl_cardview_url+'/Initialdata',
                data:{'ErrorList':'51,47,18,96,97,98,248,327,249,369'},
                success: function(data){
                    var value_array=JSON.parse(data);
                    CV_load_initial_values(value_array);
                    CV_customername_autocompleteresult(value_array[4]);
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("VIEW ALL CARD",errordata,'error',false);
                    $('.preloader').hide();
                }
            });
        // FUNCTION TO LOAD INITIAL VALUES
            function CV_load_initial_values(initial_values){
                CV_errorAarray=initial_values[3];
                var CV_unitarray=initial_values[0];
                var CV_cust_config=initial_values[2];
                var CV_cardno_array=initial_values[1];
                $('#CV_lbl_custautoerrmsg').text(CV_errorAarray[9].EMC_DATA);
                var CV_search_options ='<option>SELECT</option>';
                for (var i = 0; i < CV_cust_config.length; i++) {
                    var CV_configarray=CV_cust_config[i].split('_');
                    var CV_config_id=CV_configarray[0];
                    var CV_config_data=CV_configarray[1];
                    CV_search_options += '<option value="' + CV_config_id + '">' + CV_config_data + '</option>';
                }
                $('#CV_lb_searchby').html(CV_search_options);
                $('#CV_lb_searchby').focus();
                if(CV_unitarray.length!=0){
                    var CV_unitno_options ='<option value="SELECT">SELECT</option>';
                    for (var i = 0; i < CV_unitarray.length; i++) {
                        CV_unitno_options += '<option value="' + CV_unitarray[i] + '">' + CV_unitarray[i] + '</option>';
                    }
                    $('#CV_lb_unitno').html(CV_unitno_options);
                }
                else{
                    $('#card_view_form').replaceWith('<form id="card_view_form" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="col-sm-12 errormsg"> '+CV_errorAarray[6].EMC_DATA+'</label></div></fieldset></div></form>');
                    $(".preloader").hide();
                }
                var CV_cardno_options ='<option>SELECT</option>';
                for (var i = 0; i < CV_cardno_array.length; i++) {
                    CV_cardno_options += '<option value="' + CV_cardno_array[i] + '">' + CV_cardno_array[i] + '</option>';
                }
                $('#CV_lb_cardno').html(CV_cardno_options);
                var CV_custname_options ='<option>SELECT</option>';
            }
        // FUNCTION TO HIGHLIGHT SEARCH TEXT
            function CV_highlightSearchText() {
                $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                    var re = new RegExp(this.term, "i") ;
                    var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + t + "</a>" )
                        .appendTo( ul );
                };
            }
        // FUNCTION TO AUTOCOMPLETE SEARCH TEXT
            function CV_customername_autocompleteresult(response)
            {
                CV_customername=response;
                $("#CV_tb_custname").val('');
                $('.preloader').hide();
            }
            $("#CV_tb_custname").keypress(function(e){
                CV_customerflag=0;
                CV_highlightSearchText();
                $("#CV_tb_custname").autocomplete({
                    source: CV_customername,
                    select:CV_AutoCompleteSelectHandler
                });
            });
        // FUNCTION TO GET SELECTED VALUE
            function CV_AutoCompleteSelectHandler(event, ui) {
                CV_customerflag=1;
                $('#CV_lbl_custautoerrmsg').hide();
            }
            $(document).on('blur change','.CV_customerautovalidate',function(){
                if(CV_customerflag==1){
                    $('#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headerdiv,#CV_errmsg').hide();
                    $('#CV_tble_id > div').remove();
                    $('#CV_btn_search').removeAttr("disabled");
                }
                else
                {
                    $('#CV_lbl_custautoerrmsg').show();
                    $("#CV_btn_search").attr("disabled", "disabled");
                    $('#CV_errmsg,#CV_div_htmltable,#CV_headerdiv').hide();
                    $('#CV_tble_id > div').remove();
                }
                if($('#CV_tb_custname').val()=='')
                {
                    $('#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headerdiv,#CV_errmsg').hide();
                    $("#CV_btn_search").attr("disabled", "disabled");
                    $('#CV_tble_id > div').remove();
                }
            });
        // SEARCH BY CHANGE EVENT
            $('#CV_lb_searchby').change(function(){
                $(".preloader").show();
                if($(this).val()==31)
                {
                    $(".preloader").hide();
                    $('#CV_cardno,#CV_custname,#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headerdiv,#CV_errmsg').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_unitno').show();
                    $('#CV_tb_custname').val("");
                    $('#CV_tble_id > div').remove();
                    $('#CV_btn_search').attr("disabled","disabled");
                    $('#CV_lb_unitno').focus();
                }
                else if($(this).val()==18)
                {
                    $(".preloader").hide();
                    $('#CV_unitno,#CV_custname,#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headerdiv,#CV_errmsg').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_tb_custname').val("");
                    $('#CV_cardno').show();
                    $('#CV_tble_id > div').remove();
                    $('#CV_btn_search').attr("disabled","disabled");
                    $('#CV_lb_cardno').focus();
                }
                else if($(this).val()==21)
                {
                    $(".preloader").hide();
                    $('#CV_unitno,#CV_cardno').hide();
                    if(CV_customername.length!=0){
                        $('#CV_errmsg').hide();
                        $('#CV_custname').show();
                        $('#CV_tb_custname').focus();
                    }
                    else{
                        var msg=CV_errorAarray[7].EMC_DATA;
                        $('#CV_lbl_errmsg').text(msg).show();
                        $('#CV_errmsg').show();
                        $('#CV_custname').hide();
                    }
                    $('#CV_div_htmltable,#CV_headerdiv').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_tble_id > div').remove();
                }
                else if($(this).val()==40){
                    $(".preloader").show();
                    $('#CV_unitno,#CV_cardno,#CV_custname,#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headerdiv,#CV_errmsg').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_tb_custname').val("");
                    $('#CV_tble_id > div').remove();
                    $.ajax({
                        type:'POST',
                        url:ctrl_cardview_url+'/Cardnodetails',
                        data:{'unitno':'','cardno':'','option':$(this).val()},
                        success: function(alldata){
                            var allvalue_array=JSON.parse(alldata);
                            CV_loadcardno_details(allvalue_array);
                            $("html, body").animate({ scrollTop: 1000 }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("VIEW ALL CARD",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
                else if($(this).val()=='SELECT')
                {
                    $(".preloader").hide();
                    $('#CV_unitno,#CV_cardno,#CV_custname,#CV_lbl_custautoerrmsg,#CV_div_htmltable,#CV_headerdiv,#CV_errmsg').hide();
                    $('#CV_lb_cardno').val('SELECT');
                    $('#CV_lb_unitno').val('SELECT');
                    $('#CV_tb_custname').val("");
                    $('#CV_tble_id > div').remove();
                    $('#CV_btn_search').hide().attr("disabled","disabled");
                }
                if($(this).val()!=40){
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                }
            });
        // EVENT FOR FETCH RESULT FOR UNIT, CARD NO
            $('.CV_class_search').change(function(){
                var CV_cardno=$('#CV_lb_cardno').val();
                var CV_unitno=$('#CV_lb_unitno').val();
                var CV_searchoption=$('#CV_lb_searchby').val();
                $('#CV_div_htmltable').hide();
                $('#CV_headerdiv').hide();
                $('#CV_errmsg').hide();
                if($(this).val()=="SELECT" ){
                    $('#CV_div_htmltable').hide();
                    $('#CV_headerdiv').hide();
                    $('#CV_errmsg').hide();
                }
                else{
                    if(($('#CV_lb_searchby').val()==31)||($('#CV_lb_searchby').val()==18))
                    {
                        $(".preloader").show();
                        $.ajax({
                            type:'POST',
                            url:ctrl_cardview_url+'/Cardnodetails',
                            data:{'unitno':CV_unitno,'cardno':CV_cardno,'option':CV_searchoption},
                            success: function(carddata){
                                var cardvalue_array=JSON.parse(carddata);
                                CV_loadcardno_details(cardvalue_array);
                                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                            },
                            error:function(data){
                                var errordata=(JSON.stringify(data));
                                show_msgbox("VIEW ALL CARD",errordata,'error',false);
                                $('.preloader').hide();
                            }
                        });
                    }
                }
            });
        // CUSTOMER DATA SEARCH
            $('#CV_btn_search').click(function()
            {
                var CV_name =$('#CV_tb_custname').val();
                if(CV_name!=""){
                    $(".preloader").show();
                    $.ajax({
                        type:'POST',
                        url:ctrl_cardview_url+'/Customerid',
                        data:{'CV_name':CV_name},
                        success: function(custdata){
                            var custvalue_array=JSON.parse(custdata);
                            CV_CustId(custvalue_array);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("VIEW ALL CARD",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    $('#CV_div_htmltable').hide();
                    $('#CV_tble_id > div').remove();
                    $('#CV_errmsg').hide();
                    $('#CV_headerdiv').hide();
                }
            });
        // FUNCTION TO SHOW CUSTOMER NAME WITH RADIO BUTTON
            function CV_CustId(custid_result)
            {
                var CV_custarray=[];
                CV_custarray=custid_result;
                if(CV_custarray.length!=1)
                {
                    $(".preloader").hide();
                    $('#CV_errmsg').hide();
                    $('#CV_headerdiv').hide();
                    var CV_custname=$('#CV_tb_custname').val();
                    var CV_custid_radio='';
                    for (var i = 0; i < CV_custarray.length; i++) {
                        var final=CV_custname+' '+CV_custarray[i];
                        CV_custid_radio ='<div class="col-sm-offset-2" style="padding-left:6px"><div class="radio"><label><input type="radio" name="custid" id='+CV_custarray[i]+' value='+CV_custarray[i]+' class="CV_class_custid" />'+ final +'</label></div></div>';
                        $('#CV_tble_id').append(CV_custid_radio).show();
                    }
                }
                else{
                    //HANDLER TO GET CUSTOMER DETAIL'S
                    custnameid=CV_custarray[0];
                    $.ajax({
                        type:'POST',
                        url:ctrl_cardview_url+'/Customervalues',
                        data:{'CV_cid':CV_custarray[0]},
                        success: function(custdetaildata){
                            var custdetail_array=JSON.parse(custdetaildata);
                            CV_load_customerdetails(custdetail_array);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("VIEW ALL CARD",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    $('#CV_tble_id > div').remove();
                    $('#CV_errmsg').hide();
                    $('#CV_headerdiv,#CV_tble_id').hide();
                }
            }
        // FUNCTION TO CALL RADIO BUTTON CLICK
            $(document).on("change",'.CV_class_custid', function(){
                $(".preloader").show();
                var CV_customer_id=$("input[name=custid]:checked").val();
                custnameid=CV_customer_id;
                $('#CV_errmsg').hide();
                $('#CV_headerdiv').hide();
                $('#CV_div_htmltable').hide();
                //HANDLER TO GET CUSTOMER DETAIL'S
                $.ajax({
                    type:'POST',
                    url:ctrl_cardview_url+'/Customervalues',
                    data:{'CV_cid':CV_customer_id},
                    success: function(custdetaildata){
                        var custdetail_array=JSON.parse(custdetaildata);
                        CV_load_customerdetails(custdetail_array);
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("VIEW ALL CARD",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            });
        // FUNCTION TO SHOW CUSTOMER CARD DETAILS
            function CV_load_customerdetails(custdetails_result)
            {
                $(".preloader").hide();
                $("#CV_btn_search").attr("disabled", "disabled");
                var CV_custcard_array=custdetails_result[0];
                var CV_checkflag=custdetails_result[1];
                var CV_name =$('#CV_tb_custname').val();
                CV_name=CV_name.replace("_"," ");
                if(CV_custcard_array.length!=0)
                {
                    var CV_table_value='<table id="CV_tble_htmltable" border="1"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th style="text-align:center;width: 80px" nowrap>UNIT NO</th><th style="text-align:center;width: 160px" nowrap>ACTIVE CARDS</th><th style="text-align:center;width: 160px" nowrap>OLD CARDS</th><th style="text-align:center;width: 100px" nowrap>ACCESS REASON</th><th style="text-align:center;width: 260px" nowrap>ACCESS COMMENTS</th></tr></thead><tbody>';
                    for(var i=0;i<CV_custcard_array.length;i++){
                        var CV_values=CV_custcard_array[i];
                        var CV_active=CV_values.active;
                        var CV_lost=CV_values.lost;
                        CV_table_value+='<tr><td style="text-align:center;">'+CV_values.unitno+'</td><td>'+CV_active+'</td><td>'+CV_lost+'</td><td style="text-align:center;">'+CV_values.reason+'</td><td>'+CV_values.comments+'</td></tr>';
                    }
                    CV_table_value+='</tbody></table>';
                    $('section').html(CV_table_value);
                    $('#CV_tble_htmltable').DataTable({
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers",
                        "sDom":"Rlfrtip"
                    });
                    $('#CV_div_htmltable').show();
                    var msg=(CV_errorAarray[1].EMC_DATA).replace('[FIRST NAME + LAST NAME]',CV_name);
                    $('#CV_headermsg').text(msg);
                    $('#CV_headerdiv').show();
                }
                else if(CV_checkflag!=0&&CV_checkflag!=1){
                    $('#CV_lbl_errmsg').text(CV_checkflag).show();
                    $('#CV_errmsg').show();
                    $('#CV_div_htmltable').hide();
                    $('#CV_headerdiv').hide();
                }
                else{
                    $('#CV_div_htmltable').hide();
                    var msg=(CV_errorAarray[4].EMC_DATA).replace('[CNAME]',CV_name);
                    $('#CV_lbl_errmsg').text(msg).show();
                    $('#CV_errmsg').show();
                }
            }
        // FUNCTION TO LOAD UNIT, CARD NO HTML TABLE
            function CV_loadcardno_details(card_details)
            {
                $(".preloader").hide();
                if($('#CV_lb_searchby').val()==40 ||$('#CV_lb_searchby').val()==31||$('#CV_lb_searchby').val()==18){
                    var CV_result_array=card_details[0];
                    var CV_checkfalg=card_details[1];
                }
                else{
                    var CV_result_array=card_details;
                }
                var CV_cardno=$('#CV_lb_cardno').val();
                var CV_unitno=$('#CV_lb_unitno').val();
                var CV_table_value='';
                if($('#CV_lb_searchby').val()==18)
                {
                    if(CV_cardno!="SELECT")
                    {
                        if(CV_result_array.length!=0){
                            var CV_active=CV_result_array[0].active;
                            var CV_lost=CV_result_array[0].lost;
                            var CV_inventory=CV_result_array[0].inventory;
                            var CV_table_header='<table id="CV_tble_htmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th style="width:60px;text-align:center;" nowrap>UNIT NO</th><th style="width:160px;text-align:center;" nowrap>ACTIVE CARDS</th><th style="width:100px;text-align:center;">NON ACTIVE CARDS</th><th style="width:160px;text-align:center;" nowrap>OLD CARDS</th><th style="width:90px;text-align:center;">ACCESS REASON</th><th style="text-align:center;width: 250px">COMMENTS</th></tr></thead><tbody>';
                            CV_table_header+='<tr><td style="text-align:center;">'+CV_result_array[0].unitno+'<td>'+CV_active+'</td><td style="text-align:center;">'+CV_inventory+'</td><td>'+CV_lost+'</td><td style="text-align:center;">'+CV_result_array[0].reason+'</td><td>'+CV_result_array[0].comments+'</td></tr></tbody></table>';
                            $('section').html(CV_table_header);
                            $('#CV_tble_htmltable').DataTable({
                                "aaSorting": [],
                                "pageLength": 10,
                                "sPaginationType":"full_numbers",
                                "sDom":"Rlfrtip"
                            });
                            $('#CV_div_htmltable').show();
                            var msg=(CV_errorAarray[2].EMC_DATA).replace('[CARD NO]',CV_cardno);
                            $('#CV_headermsg').text(msg).show();
                            $('#CV_headerdiv').show();
                            $('#CV_errmsg').hide();
                        }
                        else if(CV_checkfalg!=0&&CV_checkfalg!=1){
                            $('#CV_lbl_errmsg').text(CV_checkfalg).show();
                            $('#CV_errmsg').show();
                            $('#CV_headerdiv').hide();
                            $('#CV_div_htmltable').hide();
                        }
                        else{
                            $('#CV_div_htmltable').hide();
                            $('#CV_headerdiv').hide();
                            var msg=(CV_errorAarray[5].EMC_DATA).replace('[CARD NO]',CV_cardno);
                            $('#CV_lbl_errmsg').text(msg).show();
                            $('#CV_errmsg').show();
                        }
                    }
                    else{
                        $('#CV_div_htmltable').hide();
                        $('#CV_headerdiv').hide();
                    }
                }
                else if($('#CV_lb_searchby').val()==31)
                {
                    if(CV_unitno!="SELECT"){
                        if(CV_result_array.length!=0){
                            var CV_table_header='<table id="CV_tble_htmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th style="text-align:center;">ACTIVE CARDS</th><th style="text-align:center;">NON ACTIVE CARDS</th><th style="text-align:center;">OLD CARDS</th><th style="text-align:center;">ACCESS REASON</th></tr></thead><tbody>';
                            var CV_active=[];
                            var CV_inventory=[];
                            var CV_lost=[];
                            var CV_reason=[];
                            CV_active=CV_result_array[0];
                            CV_inventory=CV_result_array[1];
                            CV_lost=CV_result_array[2];
                            CV_reason=CV_result_array[3];
                            var CV_active_len=CV_active.length;
                            var CV_inventory_len=CV_inventory.length;
                            var CV_lost_len=CV_lost.length;
                            var len=Math.max(CV_active_len,CV_inventory_len,CV_lost_len);
                            for(var i=0;i<len;i++){
                                var active_card=CV_active[i];
                                var inventory_card=CV_inventory[i];
                                var lost_card=CV_lost[i];
                                var reason=CV_reason[i];
                                if(active_card==undefined){active_card='';}
                                if(inventory_card==undefined){inventory_card='';}
                                if(lost_card==undefined){lost_card='';}
                                if(reason==undefined){reason='';}
                                CV_table_header+='<tr><td>'+active_card+'</td><td style="text-align:center;">'+inventory_card+'</td><td>'+lost_card+'</td><td style="text-align:center;">'+reason+'</td></tr>';
                            }
                            CV_table_header+='</tbody></table>';
                            $('section').html(CV_table_header);
                            $('#CV_tble_htmltable').DataTable({
                                "aaSorting": [],
                                "pageLength": 10,
                                "sPaginationType":"full_numbers",
                                "sDom":"Rlfrtip"
                            });
                            $('#CV_div_htmltable').show();
                            var msg=(CV_errorAarray[0].EMC_DATA).replace('[UNIT NO]',CV_unitno);
                            $('#CV_headermsg').text(msg).show();
                            $('#CV_headerdiv').show();
                            $('#CV_errmsg').hide();
                        }
                        else if(CV_checkfalg!=0&&CV_checkfalg!=1){
                            $('#CV_lbl_errmsg').text(CV_checkfalg).show();
                            $('#CV_errmsg').show();
                            $('#CV_headerdiv').hide();
                            $('#CV_div_htmltable').hide();
                        }
                        else{
                            $('#CV_div_htmltable').hide();
                            $('#CV_headerdiv').hide();
                            var msg=(CV_errorAarray[3].EMC_DATA).replace('[UNO]',CV_unitno);
                            $('#CV_lbl_errmsg').text(msg).show();
                            $('#CV_errmsg').show();
                        }
                    }
                    else{
                        $('#CV_div_htmltable').hide();
                        $('#CV_headerdiv').hide();
                        $('#CV_errmsg').hide();
                    }
                }
                else if($('#CV_lb_searchby').val()==40){
                    if(CV_result_array.length!=0){
                        var CV_table_header='<table id="CV_tble_htmltable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th style="text-align:center;">UNIT NO</th><th style="text-align:center;">ACTIVE CARDS</th><th style="text-align:center;">NON ACTIVE CARDS</th><th style="text-align:center;">CUSTOMER LOST CARDS</th><th style="text-align:center;">LOST CARDS</th><th style="text-align:center;">ACCESS REASON</th></tr><tbody>';
                        for(var i=0;i<CV_result_array.length;i++)
                        {
                            var CV_values=CV_result_array[i];
                            var CV_active=CV_values.active;
                            var CV_customer_lost=CV_values.customer_lost;
                            var CV_employee_lost=CV_values.employee_lost;
                            var CV_inventory=CV_values.inventory;
                            CV_table_header+='<tr><td style="text-align:center;">'+CV_values.unitno+'</td><td>'+CV_active+'</td><td style="text-align:center;">'+CV_inventory+'</td><td>'+CV_customer_lost+'</td><td style="text-align:center;">'+CV_employee_lost+'</td><td style="text-align:center;">'+CV_values.reason+'</td></tr>';
                        }
                        CV_table_header+='</tbody></table>';
                        $('section').html(CV_table_header);
                        $('#CV_tble_htmltable').DataTable({
                            "aaSorting": [],
                            "pageLength": 10,
                            "sPaginationType":"full_numbers",
                            "sDom":"Rlfrtip"
                        });
                        $('#CV_div_htmltable').show();
                        var msg=CV_errorAarray[8].EMC_DATA;
                        $('#CV_headermsg').text(msg).show();
                        $('#CV_headerdiv').show();
                        $('#CV_errmsg').hide();
                    }
                    else if(CV_checkfalg!=0&&CV_checkfalg!=1)
                    {
                        $('#CV_div_htmltable').hide();
                        $('#CV_headerdiv').hide();
                        $('#CV_lbl_errmsg').text(CV_checkfalg).show();
                        $('#CV_errmsg').show();
                    }
                    else{
                        $('#CV_div_htmltable').hide();
                        $('#CV_headerdiv').hide();
                        var msg=(CV_errorAarray[3].EMC_DATA).replace('[UNO]',$('#CV_lb_searchby').find('option:selected').text());
                        $('#CV_lbl_errmsg').text(msg).show();
                        $('#CV_errmsg').show();
                    }
                }
            }
        // PDF BUTTON EVENT
            $('#CV_btn_pdf').click(function()
            {
                var CV_searchby =$('#CV_lb_searchby').val();
                if(CV_searchby==40){
                    var pdfurl=document.location.href='<?php echo site_url('CUSTOMER/ACCESSCARD/Ctrl_Access_Card_View/Pdfcreation')?>?custname=&custnameid=&unitno=&cardno=&option='+CV_searchby;
                }
                if(CV_searchby==18){
                    var cardno =$('#CV_lb_cardno').val();
                    var pdfurl=document.location.href='<?php echo site_url('CUSTOMER/ACCESSCARD/Ctrl_Access_Card_View/Pdfcreation')?>?custname=&custnameid=&unitno=&cardno='+cardno+'&option='+CV_searchby;
                }
                if(CV_searchby==31){
                    var unitno =$('#CV_lb_unitno').val();
                    var pdfurl=document.location.href='<?php echo site_url('CUSTOMER/ACCESSCARD/Ctrl_Access_Card_View/Pdfcreation')?>?custname=&custnameid=&unitno='+unitno+'&cardno=&option='+CV_searchby;
                }
                if(CV_searchby==21){
                    var custname =$('#CV_tb_custname').val();
                    var pdfurl=document.location.href='<?php echo site_url('CUSTOMER/ACCESSCARD/Ctrl_Access_Card_View/Pdfcreation')?>?custname='+custname+'&custnameid='+custnameid+'&unitno=&cardno=&option='+CV_searchby;
                }
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>VIEW ALL CARD</b></h4></div>
    <form id="card_view_form" name="card_view_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="CV_searchby">
                    <label class="col-sm-2">SEARCH BY <em>*</em></label>
                    <div class="col-sm-3"> <select name="CV_lb_searchby" id="CV_lb_searchby" class="form-control CV_formvalidation"><option>SELECT</option></select></div>
                </div>
                <div class="form-group" id="CV_cardno" hidden>
                    <label class="col-sm-2">CARD NUMBER <em>*</em></label>
                    <div class="col-sm-2"><select name="CV_lb_cardno" id="CV_lb_cardno" class="CV_formvalidation CV_class_search form-control"></select></div>
                </div>
                <div class="form-group" id="CV_custname" hidden>
                    <label class="col-sm-2" id="CV_lbl_custname">CUSTOMER NAME <em>*</em></label>
                    <div class="col-sm-5"><input type="text" name="CV_tb_custname" id="CV_tb_custname" class="CV_customerautovalidate form-control"/></div>
                    <div class="col-sm-2 colsmhf"><input class="btn btn-info" type="button" id="CV_btn_search" name="search" value="SEARCH" disabled/></div>
                    <div class="col-sm-3 colerr"><lable id="CV_lbl_custautoerrmsg" class="errormsg" hidden></lable></div>
                </div>
                <div class="form-group" id="CV_unitno" hidden>
                    <label class="col-sm-2">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"> <select name="CV_lb_unitno" id="CV_lb_unitno" class="form-control CV_class_search CV_formvalidation"></select></div>
                </div>
                <div id='CV_tble_id' name='CV_tble_id' style="padding-bottom: 15px" hidden>
                </div>
                <div class="form-group" id='CV_headerdiv' hidden>
                    <lable class="col-lg-12 srctitle" style="padding-top:15px; padding-bottom: 10px" id="CV_headermsg"></lable>
                    <div style="padding-left: 15px;">
                        <input type="button" id="CV_btn_pdf" class="btnpdf" value="PDF">
                    </div>
                </div>
            </fieldset>
            <div class="table-responsive" id="CV_div_htmltable" hidden>
                <section>
                </section>
            </div>
            <div class="form-group" id="CV_errmsg" hidden>
                <lable id="CV_lbl_errmsg" class="col-sm-12 errormsg"></lable>
            </div>
        </div>
    </form>
</div>
</body>
</html>