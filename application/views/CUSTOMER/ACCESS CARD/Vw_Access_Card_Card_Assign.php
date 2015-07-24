<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <script type="text/javascript">
        // document ready function
        $(document).ready(function(){
            var ctrl_cardassign_url="<?php echo site_url('CUSTOMER/ACCESSCARD/Ctrl_Access_Card_Card_Assign'); ?>";
            $('textarea').autogrow({onInitialize: true});
        // initial data
            $('#spacewidth').height('0%');
            var CA_available_card=[];
            var CA_allcust_values;
            var CA_errorAarray;
            var CA_cust_id;
            $('#CA_btn_submitbutton').hide();
            $('#CA_btn_resetbutton').hide();
            $.ajax({
                type:'POST',
                url: ctrl_cardassign_url+'/Initialdata',
                data:{'ErrorList':'256,34,41,40,91,401,448'},
                success: function(data){
                    var value_array=JSON.parse(data);
                    $('.preloader').hide();
                    CA_errorAarray=value_array[1];
                    CA_allcust_values=value_array[0];
                    if(CA_allcust_values.length==0)
                    {
                        $('#cardassign_form').replaceWith('<form id="cardassign_form" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="col-sm-12 errormsg"> '+CA_errorAarray[4].EMC_DATA+'</label></div></fieldset></div></form>');
                    }
                    else
                    {
                        var CA_unit_array=[];
                        var CA_unitno_options ='<option>SELECT</option>';
                        for(var k=0;k<CA_allcust_values.length;k++)
                        {
                            CA_unit_array.push(CA_allcust_values[k].UNIT_NO)
                        }
                        CA_unit_array=unique(CA_unit_array);
                        for (var i = 0; i < CA_unit_array.length; i++)
                        {
                            CA_unitno_options += '<option value="' + CA_unit_array[i] + '">' + CA_unit_array [i]+ '</option>';
                        }
                        $('#CA_lb_unitno').html(CA_unitno_options);
                    }
                    $('#CA_lb_unitno').show();
                    $("#CA_lb_unitno").focus();
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("CARD ASSIGN",errordata,'error',false);
                    $('.preloader').hide();
                }
            });
            function unique(a) {
                var result = [];
                $.each(a, function(i, e) {
                    if ($.inArray(e, result) == -1) result.push(e);
                });
                return result;
            }
        // GET CUSTOMER NAME FOR THE SELECTED UNIT
            $('#CA_lb_unitno').change(function(){
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                var CA_unit = $(this).val();
                if(CA_unit=='SELECT'){
                    $('#CA_cardassigndiv').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_custid > div').remove();
                    $('#CA_custid').hide();
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('input:radio[name=custid]').attr('checked',false);
                    $('#CA_lb_custname').val('SELECT').hide();
                    $('#CA_custname').hide();
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_leaseperiod').hide();
                    $('#CA_lbl_error').hide();
                }
                else
                {
                    $('#CA_cardassigndiv').hide();
                    $('#CA_lbl_error').hide();
                    $('#CA_custid > div').remove();
                    $('#CA_custid').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_lb_custname').val('SELECT').hide();
                    $('#CA_custname').show();
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_leaseperiod').hide();
                    var CA_namearray=[];
                    for(var k=0;k<CA_allcust_values.length;k++)
                    {
                        if(CA_allcust_values[k].UNIT_NO==CA_unit)
                        {
                            CA_namearray.push(CA_allcust_values[k].CUSTOMERNAME);
                        }
                    }
                    CA_namearray=unique(CA_namearray);
                    var CA_custname_options ='<option>SELECT</option>';
                    for (var i = 0; i < CA_namearray.length; i++) {
                        var CA_myarray=CA_namearray[i].split('_');
                        var CA_custname=CA_myarray[0]+' '+CA_myarray[1];
                        CA_custname_options += '<option value="' + CA_namearray[i] + '">' + CA_custname + '</option>';
                    }
                    $('#CA_lb_custname').html(CA_custname_options);
                    $('#CA_lb_custname').show();
                    $("#CA_lb_custname").focus();
                }
            });
        // GET DETAIL'S FOR SELECTED CUSTOMER NAME
            $('#CA_lb_custname').change(function(){
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                var CA_name=$(this).val();
                if(CA_name=='SELECT')
                {
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_cardassigndiv').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_custid > div').remove();
                    $('#CA_custid').hide();
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('input:radio[name=custid]').attr('checked',false);
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_leaseperiod').hide();
                    $('#CA_lbl_error').hide();
                }
                else
                {
                    $(".preloader").show();
                    $('#CA_lbl_error').hide();
                    $('#CA_cardassigndiv').hide();
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('#CA_custid > div').remove();
                    $('#CA_custid').hide();
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_leaseperiod').hide();
                    var CA_name_id_array=[];
                    var CA_unit=$('#CA_lb_unitno').val();
                    for(var k=0;k<CA_allcust_values.length;k++)
                    {
                        if(CA_allcust_values[k].CUSTOMERNAME==CA_name && CA_allcust_values[k].UNIT_NO==CA_unit)
                        {
                            CA_name_id_array.push(CA_allcust_values[k].CUSTOMER_ID);
                        }
                    }
                    CA_name_id_array=unique(CA_name_id_array);
                    if(CA_name_id_array.length!=1)
                    {
                        $(".preloader").hide();
                        $('#CA_personaldetails').hide();
                        $('#CA_cardno_radio').hide();
                        $('#CA_feedetails').hide();
                        $('#CA_custid').show();
                        $('#CA_leaseperiod').hide();
                        var CA_customername=$('#CA_lb_custname').val();
                        var CA_myarray=CA_customername.split('_');
                        var CA_custname=CA_myarray[0]+' '+CA_myarray[1];
                        var CA_radio_value='';
                        for (var i = 0; i < CA_name_id_array.length; i++) {
                            var final=CA_custname+' '+CA_name_id_array[i];
                            CA_radio_value ='<div class="col-sm-offset-3" style="padding-left:15px"><div class="radio"><label><input type="radio" name="custid" id='+CA_name_id_array[i]+' value='+CA_name_id_array[i]+' class="CA_class_custid" />'+ final +'</label></div></div>';
                            $('#CA_custid').append(CA_radio_value);
                        }
                    }
                    else{
                        CA_cust_id=CA_name_id_array[0];
                        CA_load_customer_recver(CA_name_id_array[0]);
                        $('#CA_custid > div').remove();
                        $('#CA_custid').hide();
                    }
                }
            });
        // FUNCTION TO CALL TO SHOW CUSTOMER DETAIL'S FROM RADIO BUTTON
            $(document).on("change",'.CA_class_custid', function ()
            {
                $(".preloader").show();
                var CA_customerid=$("input[name=custid]:checked").val();
                CA_cust_id=CA_customerid;
                var CA_unit=$('#CA_lb_unitno').val();
                $('#CA_personaldetails').hide();
                $('#CA_cardno_radio').hide();
                $('#CA_feedetails').hide();
                $('#CA_lbl_radioerror').hide();
                $('#CA_avail_cardno > div').remove();
                $('#CA_guest_cardno > div').remove();
                $('input:radio[name=CA_selectcard]').attr('checked',false);
                $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                $('#CA_leaseperiod').hide();
                $('#CA_btn_resetbutton').hide();
                $('#CA_comment').hide();
                $('#CA_lbl_error').hide();
                CA_load_customer_recver(CA_customerid);
            });
        // FUNCTION TO LOAD CUSTOMER RECORD VERSION
            function CA_load_customer_recver(cust_id){
                var CA_cust_recver=[];
                var CA_unit=$('#CA_lb_unitno').val();
                for(var k=0;k<CA_allcust_values.length;k++)
                {
                    if(CA_allcust_values[k].CUSTOMER_ID==cust_id && CA_allcust_values[k].UNIT_NO==CA_unit)
                    {
                        CA_cust_recver.push(CA_allcust_values[k].CED_REC_VER+'_'+CA_allcust_values[k].CLP_STARTDATE+'_'+CA_allcust_values[k].CLP_ENDDATE);
                    }
                }
                CA_cust_recver=unique(CA_cust_recver);
                var CA_recver_options ='<option>SELECT</option>';
                for (var i = 0; i < CA_cust_recver.length; i++)
                {
                    var value=CA_cust_recver[i].split("_");
                    CA_recver_options += '<option value="' + value[0] + '" title="'+value[1]+"---"+value[2]+'">' + value[0]+ '</option>';
                }
                $('#CA_lb_leaseperiod').html(CA_recver_options);
                $('#CA_leaseperiod').show();
                $("#CA_lb_leaseperiod").focus();
                $(".preloader").hide();
            }
        // GET AVAILABLE CARD's FOR SELECTED UNIT
            $('.radio_selected').change(function(){
                var radio=$("input[name=CA_selectcard]:checked").val();
                $('#CA_avail_cardno > div').remove();
                $('#CA_avail_cardno').hide();
                $('#CA_lbl_radioerror').hide();
                var CA_unit=$('#CA_lb_unitno').val();
                var CA_fname=$('#CA_tb_firstname').val();
                var CA_lname=$('#CA_tb_lastname').val();
                var CA_recver=$('#CA_lb_leaseperiod').val();
                if(radio=='CARD'){
                    $('#CA_btn_submitbutton').attr("disabled","disabled");
                    $(".preloader").show();
                    CA_load_availablecards(available_card);
                }
                else{
                    $('#CA_avail_cardno').hide();
                    $('#CA_btn_submitbutton').removeAttr('disabled');
                }
            });
            $('#CA_custname').hide();
            $('#CA_personaldetails').hide();
            $('#CA_cardno_radio').hide();
            $('#CA_avail_cardno').hide();
            $('#CA_feedetails').hide();
            $('#CA_custid').hide();
            $('#CA_comment').hide();
            $('#CA_guest_cardno > div').remove();
        // FUNCTION TO CALL TO DISPLAY AVAILABLE CARD'S
            function CA_load_availablecards(CA_result_card)
            {
                $(".preloader").hide();
                CA_available_card=CA_result_card;
                var CA_cust_cardarray=[];
                var CA_availablecard_array=[];
                CA_cust_cardarray=CA_result_card[0];
                CA_availablecard_array=CA_result_card[1];
                if(CA_availablecard_array.length==0 &&CA_cust_cardarray.length==0)
                {
                    $('#CA_lbl_radioerror').text(CA_errorAarray[0].EMC_DATA);
                    $('#CA_lbl_radioerror').css("color","red");
                    $('#CA_lbl_radioerror').show();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                }
                else{
                    var unit=$('#CA_lb_unitno').val();
                    if(CA_cust_cardarray.length!=0){
                        $('#CA_rd_selectcard').attr('checked',true);
                        CA_show_cards(CA_result_card);
                    }
                    else{
                        CA_show_cards(CA_result_card);
                    }
                }
            }
        // FUNCTION TO SHOW AVAILABLE CARD'S
            function CA_show_cards(CA_result_card)
            {
                var CA_gcardarray=[];
                CA_gcardarray=CA_result_card[0];
                var CA_cardArray= [];
                CA_cardArray=CA_result_card[1];
                var CA_cardlbl_array=[];
                CA_cardlbl_array=CA_result_card[2];
                $('#CA_avail_cardno > div').remove();
                if(CA_gcardarray.length!=0){
                    for(var j=0;j<CA_gcardarray.length;j++){
                        var CA_checkboxid1='CA_cb_cardnumber'+j;
                        var CA_listboxid='CA_lb_selectnamelist'+j;
                        var va='CA_ta_selectnamelist1'+j;
                        var CA_myarray=CA_gcardarray[j].split('/');
                        var CA_cust_cardno=CA_myarray[0];
                        if(j==0){
                            var CA_custname=CA_myarray[1];
                            var CA_custname1=CA_custname.replace(/__/g," ");
                            var name=CA_custname1.split('_');
                            var customername=name[0]+' '+name[1];
                        }
                        else
                        {
                            var CA_custname=CA_myarray[1]+j;
                        }
                        if(CA_cardArray.length==0 && CA_gcardarray.length==1){
                            var CA_cardno1 ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cust_cardno+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber" checked="checked" disabled/>' + CA_cust_cardno + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" disabled></select></div><input type="hidden" id='+va+' name="CA_selectnamelist1[]" value='+CA_gcardarray[j]+'/></div>';
                        }
                        else
                        {
                            var CA_cardno1 ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cust_cardno+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber" checked="checked"/>' + CA_cust_cardno + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" disabled></select></div><input type="hidden" id='+va+' name="CA_selectnamelist1[]" value='+CA_gcardarray[j]+'/></div>';
                        }
                        $('#CA_avail_cardno').append(CA_cardno1);
                        $('#CA_avail_cardno').show();
                        var options ='<option>SELECT</option>';
                        if(j==0){
                            options+='<option value=' + CA_custname + '>' + customername + '</option>';
                        }
                        else{
                            options+='<option value=' + CA_custname + '>' + CA_custname + '</option>';
                        }
                        $('#CA_lb_selectnamelist'+j).html(options);
                        $('#CA_lb_selectnamelist'+j).prop('selectedIndex',1)
                    }
                    for (var i=0;i<CA_cardArray.length;i++)
                    {
                        var CA_listboxid='CA_lb_selectnamelist'+j;
                        var CA_checkboxid1='CA_cb_cardnumber'+j;
                        var va='CA_ta_selectnamelist1'+j;
                        if(CA_gcardarray.length==4)
                        {
                            var CA_cardno ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cardArray[i]+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber" disabled/>' + CA_cardArray[i] + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" style="display: none;"></select></div><input type="hidden" id='+va+' name="CA_selectnamelist1[]"/></div>';
                        }
                        else{
                            var CA_cardno ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cardArray[i]+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber"/>' + CA_cardArray[i] + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" style="display: none;"></select></div><input type="hidden" id='+va+' name="CA_selectnamelist1[]"/></div>';
                        }
                        $('#CA_avail_cardno').append(CA_cardno);
                        $('#CA_avail_cardno').show();
                        var options ='<option>SELECT</option>';
                        for(var k=0;k<CA_cardlbl_array.length;k++)
                        {
                            options += '<option value="' + CA_cardlbl_array[k] + '">' + CA_cardlbl_array[k] + '</option>';
                        }
                        $('#CA_lb_selectnamelist'+j).html(options);
                        j++;
                    }
                }
                if(CA_gcardarray.length==0){
                    for (var i=0;i<CA_cardArray.length;i++)
                    {
                        var CA_listboxid='CA_lb_selectnamelist'+i;
                        var CA_checkboxid1='CA_cb_cardnumber'+i;
                        var va='CA_ta_selectnamelist1'+i;
                        var CA_cardno ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cardArray[i]+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber"/>' + CA_cardArray[i] + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" style="display: none;"></select></div><input type="hidden" id='+va+' name="CA_selectnamelist1[]"/></div>';
                        $('#CA_avail_cardno').append(CA_cardno);
                        $('#CA_avail_cardno').show();
                    }
                    for(var i=0;i<CA_cardArray.length;i++){
                        var options ='<option>SELECT</option>';
                        for(var j=0;j<CA_cardlbl_array.length;j++)
                        {
                            if(j==0){
                                var CA_custname=CA_cardlbl_array[j];
                                var name=CA_custname.split('_');
                                var customername=name[0]+' '+name[1];
                                options += '<option value="' + CA_custname + '">' +customername+ '</option>';
                            }
                            else{
                                options += '<option value="' + CA_cardlbl_array[j] + '">' + CA_cardlbl_array[j] + '</option>';
                            }
                        }
                        $('#CA_lb_selectnamelist'+i).html(options);
                    }
                }
            }
        // CHANGE EVENT FOR LEASE PERIOD
            $('#CA_lb_leaseperiod').change(function(){
                var CA_recver=$(this).val();
                if(CA_recver=="SELECT"){
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_cardassigndiv').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_lbl_error').hide();
                }
                else{
                    $(".preloader").show();
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_cardassigndiv').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('#CA_btn_resetbutton').hide();
                    var CA_unit=$('#CA_lb_unitno').val();
                    $.ajax({
                        type:'POST',
                        url:ctrl_cardassign_url+'/Customerdetails',
                        data:{'CA_recver':CA_recver,'CA_unit':CA_unit,'CA_cust_id':CA_cust_id},
                        success: function(data){
                            var value_array=JSON.parse(data);
                            CA_load_customerdetails(value_array);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("CARD ASSIGN",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // FUNCTION TO CONVERT DATE FORMAT
            function FormTableDateFormat(inputdate){
                var string = inputdate.split("-");
                return string[2]+'-'+ string[1]+'-'+string[0];
            }
        // FUNCTION TO LOAD CUSTOMER DETAILS'S
            var available_card;
            var CA_guest_array;
            function CA_load_customerdetails(value_array)
            {
                var CA_customerdetails=[];
                CA_customerdetails=value_array[0];
                CA_guest_array=value_array[1];
                available_card=value_array[2];
                var check_card_flag=value_array[3];
                var check_rec_ver=value_array[4];
                var CA_fname_length=(CA_customerdetails.firstname).length;
                var CA_lname_length=(CA_customerdetails.lastname).length;
                var CA_email_length=(CA_customerdetails.email).length;
                var CA_nation_length=(CA_customerdetails.nationality).length;
                var CA_startdate=CA_customerdetails.startdate;
                CA_startdate=FormTableDateFormat(CA_startdate);
                var CA_enddate=CA_customerdetails.enddate;
                CA_enddate=FormTableDateFormat(CA_enddate);
                if(CA_customerdetails.company!=null && CA_customerdetails.company!=''){
                    var CA_companyname_length=(CA_customerdetails.company).length;
                    $('#CA_tb_companyname').attr("size",CA_companyname_length+9);
                }
                else{
                    $('#CA_tb_companyname').attr("size",5);
                }
                var CA_dob=CA_customerdetails.dob;
                if(CA_dob!=null && CA_dob!=''){
                    CA_dob=FormTableDateFormat(CA_dob);
                }
                var CA_passportdate=CA_customerdetails.passportdate;
                if(CA_passportdate!=null && CA_passportdate!=''){
                    CA_passportdate=FormTableDateFormat(CA_passportdate)
                }
                var CA_epdate=CA_customerdetails.epdate;
                if(CA_epdate!=null && CA_epdate!=''){
                    CA_epdate=FormTableDateFormat(CA_epdate)
                }
                var CA_noticedate=CA_customerdetails.noticedate;
                if(CA_noticedate!=null && CA_noticedate!=''){
                    CA_noticedate=FormTableDateFormat(CA_noticedate)
                }
                var CA_roomtype_length=(CA_customerdetails.roomtype).length;
                $('#CA_tb_roomtype').attr("size",CA_roomtype_length+3);
                $('#CA_tb_lastname').attr("size",CA_lname_length+3);
                $('#CA_tb_firstname').attr("size",CA_fname_length+3);
                $('#CA_tb_email').attr("size",CA_email_length);
                $('#CA_tb_nation').attr("size",CA_nation_length+6);
                $('#CA_tb_firstname').val(CA_customerdetails.firstname);
                $('#CA_tb_lastname').val(CA_customerdetails.lastname);
                $('#CA_tb_email').val(CA_customerdetails.email);
                $('#CA_tb_mobileno').val(CA_customerdetails.mobile1);
                $('#CA_tb_intmobileno').val(CA_customerdetails.mobile2);
                $('#CA_tb_officeno').val(CA_customerdetails.officeno);
                $('#CA_tb_dob').val(CA_dob);
                $('#CA_tb_passno').val(CA_customerdetails.passportno);
                $('#CA_tb_passdate').val(CA_passportdate);
                $('#CA_tb_epno').val(CA_customerdetails.epno);
                $('#CA_tb_epdate').val(CA_epdate);
                $('#CA_tb_roomtype').val(CA_customerdetails.roomtype);
                $('#CA_tb_cardno').val(CA_customerdetails.cardno);
                $('#CA_tb_startdate').val(CA_startdate);
                $('#CA_tb_enddate').val(CA_enddate);
                $('#CA_tb_noticeperiod').val(CA_customerdetails.noticeperiod);
                $('#CA_tb_noticedate').val(CA_noticedate);
                $('#CA_tb_elect').val(CA_customerdetails.electricitycap);
                $('#CA_tb_drycleanfee').val(CA_customerdetails.drycleanfee);
                $('#CA_tb_checkoutcleaningfee').val(CA_customerdetails.checkoutcleaningfee);
                $('#CA_tb_deposit').val(CA_customerdetails.deposit);
                $('#CA_tb_rent').val(CA_customerdetails.rental);
                $('#CA_tb_processingfee').val(CA_customerdetails.processingfee);
                $('#CA_ta_comments').val(CA_customerdetails.comments);
                $('#CA_tb_companyname').val(CA_customerdetails.company);
                $('#CA_tb_nation').val(CA_customerdetails.nationality);
                $('#CA_ta_comments').height(114);
                var CA_quaterlyfee=CA_customerdetails.airconquartelyfee;
                var CA_fixedfee=CA_customerdetails.airconfixedfee;
                if(CA_quaterlyfee==null || CA_quaterlyfee=='')
                {
                    $('#CA_tb_fixed').val(CA_customerdetails.airconfixedfee).show();
                    $('#CA_lbl_fixedfee').text("AIRCON FIXED FEE");
                }
                else if(CA_fixedfee==null || CA_fixedfee=='')
                {
                    $('#CA_tb_fixed').val(CA_customerdetails.airconquartelyfee).show();
                    $('#CA_lbl_fixedfee').text("AIRCON QUATERLY FEE");
                }
                if(CA_customerdetails.cardno==null || CA_customerdetails.cardno==''){
                    $('#CA_radio_null').attr("disabled","disabled");
                }
                else{
                    CA_load_availablecards(available_card);
                    $('#CA_radio_null').removeAttr("disabled");
                }
                if(CA_guest_array.length!=0)
                {
                    var CA_value='';
                    for (var i = 0; i < CA_guest_array.length; i++) {
                        CA_value = '<div class="form-group"><label class="col-sm-3" style="visibility:hidden;"> GUEST '+(i+1)+ ' CARD </lable><div class="col-sm-3"><input type="text" name="CA_tb_cardno[]" id='+CA_guest_array[i]+' value='+CA_guest_array[i]+' style="width:50px;"  readonly hidden /></div></div>';
                        $('#CA_guest_cardno').append(CA_value);
                    }
                }
                else
                {
                    $('#CA_guest_cardno > div').remove();
                }
                if(check_card_flag==0){
                    $('#CA_personaldetails').show();
                    $('#CA_cardno_radio').show();
                    $('#CA_feedetails').show();
                    $('#CA_cardassigndiv').show();
                    $('#CA_btn_submitbutton').show();
                    $('#CA_btn_resetbutton').show();
                    $('#CA_comment').show();
                    $('#CA_lbl_error').hide();
                }
                else{
                    $('#CA_personaldetails').hide();
                    $('#CA_cardno_radio').hide();
                    $('#CA_feedetails').hide();
                    $('#CA_cardassigndiv').hide();
                    $('#CA_btn_submitbutton').hide();
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_comment').hide();
                    var CA_lp=check_rec_ver;
                    var msg=(CA_errorAarray[6].EMC_DATA).replace('[LP]',CA_lp);
                    $('#CA_lbl_error').text(msg).show();
                    $('#CA_lb_leaseperiod').val('SELECT');
                }
                $(".preloader").hide();
                $("html, body").animate({ scrollTop: 1500 }, "slow");
            }
        // FUNCTION TO COMPARE TWO ARRAY
            function CA_card_diffArray(a, b) {
                var seen = [], diff = [];
                for ( var i = 0; i < b.length; i++)
                    seen[b[i]] = true;
                for ( var i = 0; i < a.length; i++)
                    if (!seen[a[i]])
                        diff.push(a[i]);
                return diff;
            }
//            $('#CA_unitno').hide();
        // FUNCTION TO CHECK CARD
            $(document).on("change",'.CA_class_cardnumber', function ()
            {
                var result_card=CA_available_card;
                var CA_cardlist=[];
                var CA_availablecard_array=[];
                var CA_custcard_array=[];
                var CA_check_cardclick_count=0;
                var CA_check_cardlistbox=0;
                CA_availablecard_array=result_card[1];
                CA_custcard_array=result_card[0];
                var CA_cardlbl_array=[];
                var CA_fname=$('#CA_tb_firstname').val();
                var CA_lname=$('#CA_tb_lastname').val();
                var name=CA_fname+'_'+CA_lname;
                CA_cardlbl_array=result_card[2];
                var CA_availablecard_array_length=CA_availablecard_array.length;
                var CA_custcard_array_length=CA_custcard_array.length;
                var len=CA_availablecard_array_length+CA_custcard_array_length;
                for(var i=0;i<len;i++)
                {
                    var CA_cardno_check=$('#CA_cb_cardnumber'+i).is(":checked");
                    if(CA_cardno_check==true)
                    {
                        $('#CA_lb_selectnamelist'+i).removeAttr('disabled');
                        var CA_cardlist_box=$('#CA_lb_selectnamelist'+i).val();
                        var CA_cardno=$('#CA_cb_cardnumber'+i).val();
                        if(CA_cardlist_box!="SELECT"){
                            $('#CA_lb_selectnamelist'+i).attr("disabled","disabled");
                            $('#CA_ta_selectnamelist1'+i).val(CA_cardno+'/'+CA_cardlist_box);
                            CA_cardlist.push(CA_cardlist_box);
                        }
                        else
                        {
                            CA_check_cardlistbox++;
                        }
                        CA_check_cardclick_count++;
                    }
                }
                var CA_available_cardlbl=[];
            //difference between two arrays
                CA_available_cardlbl=CA_card_diffArray(CA_cardlbl_array,CA_cardlist);
                for(var j=0;j<len;j++)
                {
                    var CA_check=$('#CA_cb_cardnumber'+j).is(":checked");
                    var CA_cardlist_box=$('#CA_lb_selectnamelist'+j).val();
                    if(CA_cardlist_box=="SELECT")
                    {
                        $('#CA_lb_selectnamelist'+j).empty();
                        var CA_cardlbl_options ='<option>SELECT</option>';
                        for(var l=0;l<CA_available_cardlbl.length;l++)
                        {
                            name=name.replace(/ /g,"__");
                            if(name==CA_available_cardlbl[l])
                            {
                                var CA_custname=CA_available_cardlbl[l];
                                var CA_custname1=CA_custname.replace(/__/g," ");
                                var name1=CA_custname1.split('_');
                                var customername1=name1[0]+' '+name1[1];
                                CA_cardlbl_options += '<option value="' + CA_custname + '">' + customername1 + '</option>';
                            }
                            else{
                                CA_cardlbl_options += '<option value="' + CA_available_cardlbl[l] + '">' + CA_available_cardlbl[l] + '</option>';
                            }
                        }
                        $('#CA_lb_selectnamelist'+j).html(CA_cardlbl_options);
                        $('#CA_lb_selectnamelist'+j).attr("enabled","enabled");
                    }
                    if(CA_check==true)
                    {
                        $('#CA_lb_selectnamelist'+j).show();
                        $('#CA_lb_selectnamelist'+j).attr("enabled","enabled");
                    }
                    else
                    {$('#CA_lb_selectnamelist'+j)[0].selectedIndex = 0;
                        $('#CA_lb_selectnamelist'+j).hide();
                        $('#CA_ta_selectnamelist1'+j).val('');
                    }
                }
                if(CA_check_cardclick_count==4)
                {
                    for(var i=0;i<len;i++)
                    {
                        var CA_check=$('#CA_cb_cardnumber'+i).is(":checked");
                        if(CA_check==false)
                        {
                            $('#CA_cb_cardnumber'+i).attr("disabled","disabled");
                        }
                    }
                }
                else
                {
                    if(CA_check_cardlistbox==0)
                    {
                        for(var i=0;i<len;i++)
                        {
                            var CA_check=$('#CA_cb_cardnumber'+i).is(":checked");
                            if(CA_check==false)
                            {
                                $('#CA_cb_cardnumber'+i).removeAttr('disabled');
                            }
                        }
                    }
                    else
                    {
                        for(var i=0;i<len;i++)
                        {
                            var CA_check=$('#CA_cb_cardnumber'+i).is(":checked");
                            if(CA_check==false)
                            {
                                $('#CA_cb_cardnumber'+i).attr("disabled","disabled");
                            }
                        }
                    }
                }
                CA_submit_validate(result_card);
            });
        // SUBMIT BUTTON VALIDATION FUNCTION
            function CA_submit_validate(result_card)
            {
                var CA_fname=$('#CA_tb_firstname').val();
                var CA_lname=$('#CA_tb_lastname').val();
                var CA_availablecard_array=[];
                var CA_custcard_array=[];
                CA_availablecard_array=result_card[1];
                CA_custcard_array=result_card[0];
                var guest_card=[];
                var CA_availablecardarray_length=CA_availablecard_array.length;
                var CA_custcard_array_length=CA_custcard_array.length;
                var len=CA_availablecardarray_length+CA_custcard_array_length;
                var printarray=[];
                var CA_uncheck_accesscard_flag=0;
                var CA_check_accesscard_flag=0;
                for(var k=0;k<len;k++)
                {
                    var access_card= $('#CA_cb_cardnumber'+k).is(":checked");
                    if(access_card==true)
                    {
                        CA_check_accesscard_flag++;
                    }
                    else
                    {
                        CA_uncheck_accesscard_flag++;
                    }
                }
                if(CA_check_accesscard_flag==0 || CA_lname=="")
                {
                    $('#CA_btn_submitbutton').attr("disabled","disabled");
                    $('#CA_lbl_radioerror').hide();
                }
                else
                {
                    $('#CA_btn_submitbutton').removeAttr('disabled');
                    $('#CA_lbl_radioerror').hide();
                    var CA_custname="";
                    if(CA_fname!=""&&CA_lname!="")
                    {
                        CA_custname=(CA_fname+"_"+CA_lname).toUpperCase();
                        CA_custname=CA_custname.replace(/ /g,"__");
                    }
                    var CA_set_matchname_flag=0;
                    var CA_set_accesscard_check_flag=0;
                    var flag2=0;
                    for(var i=0;i<len;i++)
                    {
                        var CA_cardlist_box=$('#CA_lb_selectnamelist'+i).val();
                        var CA_accesscard_check=$('#CA_cb_cardnumber'+i).is(":checked");
                        if(CA_accesscard_check==true)
                        {
                            CA_set_accesscard_check_flag=1;
                            if(CA_custname!="")
                            {
                                if(CA_cardlist_box.match(CA_custname))
                                {
                                    CA_set_matchname_flag=1;
                                }
                            }
                            if(CA_cardlist_box=="SELECT")
                            {
                                flag2=1;
                            }
                        }
                    }
                    if(CA_set_accesscard_check_flag==1)
                    {
                        if(CA_set_matchname_flag==0)
                        {
                            $('#CA_lbl_radioerror').text(CA_errorAarray[2].EMC_DATA).show();
                            $('#CA_btn_submitbutton').attr("disabled","disabled");
                        }
                        else
                        {
                            $('#CA_lbl_radioerror').text("");
                        }
                        if(flag2==1){
                            $('#CA_btn_submitbutton').attr("disabled","disabled");
                        }
                    }
                    else
                    {
                        $('#CA_lbl_radioerror').text("");
                    }
                    if(CA_set_accesscard_check_flag!=1)
                    {
                        $('#CA_btn_submitbutton').attr("disabled","disabled");
                    }
                }
            }
        // FUNCTION TO CLEAR FORM
            function CA_clear(CA_flag){
                $(".preloader").hide();
                $('#CA_cardassigndiv').hide();
                $('#CA_custname').hide();
                $('#CA_lb_custname').val("SELECT");
                $('#CA_lb_unitno').val("SELECT");
                $('#CA_leaseperiod').hide();
                $('#CA_lb_leaseperiod').val("SELECT");
                $('#CA_custid > div').remove();
                $('#CA_custid').hide();
                $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                $('#CA_btn_resetbutton').hide();
                $('input:radio[name=custid]').attr('checked',false);
                if(CA_flag==1){
                    show_msgbox("CARD ASSIGN",CA_errorAarray[1].EMC_DATA,'success',false);
                }
                else{
                    if(CA_flag!=0){
                        show_msgbox("CARD ASSIGN",CA_flag,'error',false);
                    }
                    else{
                        show_msgbox("CARD ASSIGN",CA_errorAarray[5].EMC_DATA,'error',false);
                    }
                }
            }
            $('#CA_btn_resetbutton').click(function(){
                $('#CA_cardassigndiv').hide();
                $('#CA_custname').hide();
                $('#CA_lb_custname').val("SELECT");
                $('#CA_lb_unitno').val("SELECT");
                $('#CA_leaseperiod').hide();
                $('#CA_lb_leaseperiod').val("SELECT");
                $('#CA_custid > div').remove();
                $('#CA_custid').hide();
                $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                $('#CA_btn_resetbutton').hide();
                $('input:radio[name=custid]').attr('checked',false);
                $('#CA_avail_cardno > div').remove();
                $('input:radio[name=CA_selectcard]').attr('checked',false);
            });
        //SUBMIT BUTTON CLICK
            $('#CA_btn_submitbutton').click(function(){
                $(".preloader").show();
                var formelement=$('#cardassign_form').serialize();
                $.ajax({
                    type:'POST',
                    url:ctrl_cardassign_url+'/Cardassignsave',
                    data:formelement+"&CA_cust_id="+CA_cust_id,
                    success: function(flag){
                        CA_clear(flag);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("CARD ASSIGN",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>CUSTOMER CARD ASSIGN</b></h4></div>
    <form id="cardassign_form" name="cardassign_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="CA_unitno">
                    <label class="col-sm-3">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"> <select name="CA_lb_unitno" id="CA_lb_unitno" class="form-control CA_formvalidation"><option>SELECT</option></select></div>
                </div>
                <div class="form-group" id="CA_custname" hidden>
                    <label class="col-sm-3">CUSTOMER NAME <em>*</em></label>
                    <div class="col-sm-4"><select name="CA_lb_custname" id="CA_lb_custname" class="CA_formvalidation form-control"></select></div>
                </div>
                <div class="form-group" id="CA_custid" hidden>
                </div>
                <div class="form-group" id="CA_leaseperiod" hidden>
                    <label class="col-sm-3">LEASE PERIOD <em>*</em></label>
                    <div class="col-sm-2"><select name="CA_lb_leaseperiod" id="CA_lb_leaseperiod" class="CA_formvalidation form-control" style="width:110px"></select></div>
                </div>
                <div class="col-sm-offset-3 col-sm-10" id="CA_error">
                    <label id="CA_lbl_error" name="CA_lbl_error" class="errormsg"></label>
                </div>
                <div id="CA_cardassigndiv" hidden>
                    <div id='CA_personaldetails'>
                        <div class="form-group">
                            <label class="col-sm-3">FIRST NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_firstname" id="CA_tb_firstname"  class="form-control CA_formvalidation" maxlength="50" readonly placeholder="First Name"/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">LAST NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_lastname" id="CA_tb_lastname"  maxlength="50" class="form-control CA_formvalidation" placeholder="Last Name" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">COMPANY NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_companyname" id="CA_tb_companyname"  class="form-control CA_formvalidation" placeholder="Company Name" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EMAIL ID</label>
                            <div class="col-sm-4"> <input type="text" name="CA_tb_email" id="CA_tb_email"  maxlength="50" class="form-control CA_formvalidation" placeholder="Email Id" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">MOBILE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_mobileno" id="CA_tb_mobileno"  maxlength="6" class="form-control CA_formvalidation" placeholder="Mobile No" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">INT'L MOBILE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_intmobileno" id="CA_tb_intmobileno"  maxlength="15" class="form-control CA_formvalidation" placeholder="Int'l Mobile No" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">OFFICE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_officeno" id="CA_tb_officeno"  maxlength="8" class="form-control CA_formvalidation" placeholder="Office No" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">DATE OF BIRTH</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_dob" id="CA_tb_dob"  maxlength="50" class="form-control CA_formvalidation" placeholder="DOB" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NATIONALITY</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_nation" id="CA_tb_nation"  maxlength="50" class="form-control CA_formvalidation" placeholder="Nationality" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PASSPORT NUMBER</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_passno" id="CA_tb_passno"  maxlength="15" class="form-control CA_formvalidation" placeholder="Passport Number" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PASSPORT EXPIRY DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_passdate" id="CA_tb_passdate"  maxlength="50" class="form-control CA_formvalidation" placeholder=" Passport Expiry Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EP NUMBER</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_epno" id="CA_tb_epno"  maxlength="15" class="form-control CA_formvalidation" placeholder="EP Number" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EP EXPIRY DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_epdate" id="CA_tb_epdate" class="form-control CA_formvalidation" placeholder="EP Expiry Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">ROOM TYPE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_roomtype" id="CA_tb_roomtype" class="form-control CA_formvalidation" placeholder="Room Type" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CUSTOMER CARD </label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_cardno[]" id="CA_tb_cardno" class="form-control CA_formvalidation" placeholder="Customer Card" readonly/></div>
                        </div>
                    </div>
                    <div id="CA_cardno_radio">
                        <div class="form-group">
                            <label class="col-sm-3">SELECT THE CARD <em>*</em></label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <label><input type="radio" name="CA_selectcard" id="CA_rd_selectcard" value='CARD' class='radio_selected'>CARD NUMBER</label>
                                    <label align='bottom' name='error' id='CA_lbl_radioerror' visible="false" class='errormsg'></label>
                                </div>
                                <div id="CA_avail_cardno" style="padding-left: 10px;display: none;" hidden="hidden">
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="CA_selectcard" id="CA_radio_null" value='NULL' class='radio_selected'>NULL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="CA_feedetails">
                        <div class="form-group">
                            <label class="col-sm-3">CHECK IN DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_startdate" id="CA_tb_startdate" class="form-control CA_formvalidation" placeholder="Check in Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CHECK OUT DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_enddate" id="CA_tb_enddate" class="form-control CA_formvalidation" placeholder="Check out Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NOTICE PERIOD</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_noticeperiod" id="CA_tb_noticeperiod" class="form-control CA_formvalidation" placeholder="Notice Period" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NOTICE DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_noticedate" id="CA_tb_noticedate" class="form-control CA_formvalidation" placeholder="Notice Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">ELECTRICITY CAPPED</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_elect" id="CA_tb_elect" class="form-control CA_formvalidation" placeholder="Electricity Capped" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label id="CA_lbl_fixedfee" class="col-sm-3">AIRCON FIXED FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_fixed" id="CA_tb_fixed" class="form-control CA_formvalidation" placeholder="Aircon Fixd Fee" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CURTAIN DRY CLEANING FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_drycleanfee" id="CA_tb_drycleanfee"  maxlength="50" class="form-control CA_formvalidation" placeholder="Curtain Dry Cleaning Fee" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CHECKOUT CLEANING FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_checkoutcleaningfee" id="CA_tb_checkoutcleaningfee"  maxlength="50" class="form-control CA_formvalidation" placeholder="Checkout cleaning Fee" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">DEPOSIT</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_deposit" id="CA_tb_deposit"  maxlength="50" class="form-control CA_formvalidation" placeholder="Deposit" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">RENT</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_rent" id="CA_tb_rent"  maxlength="50" class="form-control CA_formvalidation" placeholder="Rent" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PROCESSING COST</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_processingfee" id="CA_tb_processingfee" maxlength="50" class="form-control CA_formvalidation" placeholder="Processing Cost" readonly/></div>
                        </div>
                    </div>
                    <div id='CA_comment'>
                        <div class="form-group">
                            <label class="col-sm-3">COMMENTS</label>
                            <div class="col-sm-4"><textarea name="CA_ta_comments" id="CA_ta_comments" class="form-control CA_formvalidation" style="height: 114px" rows="5"></textarea></div>
                        </div>
                    </div>
                    <div id="CA_guest_cardno" hidden>
                    </div>
                    <div class="form-group" id="buttons">
                        <div class="col-sm-offset-2 col-sm-3">
                            <input class="btn btn-info" type="button" id="CA_btn_submitbutton" name="ASSIGN" value="ASSIGN" disabled/>
                            <input class="btn btn-info" type="button" id="CA_btn_resetbutton" name="RESET" value="RESET"/>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>