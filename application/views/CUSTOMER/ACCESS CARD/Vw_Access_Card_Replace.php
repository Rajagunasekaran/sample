<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <script type="text/javascript">
        // document ready function
        $(document).ready(function(){
            var ctrl_cardreplace_url="<?php echo site_url('CUSTOMER/ACCESSCARD/Ctrl_Access_Card_Replace'); ?>";
        // initial data
            $('textarea').autogrow({onInitialize: true});
            $('#spacewidth').height('0%');
            var CR_inventory_card_array=[];
            var CR_errorAarray=[];
            var CR_allcust_details=[];
            var CR_reason_array=[];
            var CR_cust_id;
            var CR_comment;
            $.ajax({
                type:'POST',
                url:ctrl_cardreplace_url+'/Initialdata',
                data:{'ErrorList':'100,99,28,401'},
                success: function(data){
                    var value_array=JSON.parse(data);
                    CR_load_initial_values(value_array);
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("REPLACE OF ACCESS CARD",errordata,'error',false);
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
        // FUNCTION TO LOAD INITIAL VALUES
            function CR_load_initial_values(initial_values){
                CR_errorAarray=initial_values[2];
                CR_allcust_details=initial_values[1];
                CR_reason_array=initial_values[0];
                var CR_unit_array=[];
                if(CR_allcust_details.length!=0){
                    var CR_unitno_options ='<option>SELECT</option>';
                    for(var k=0;k<CR_allcust_details.length;k++)
                    {
                        CR_unit_array.push(CR_allcust_details[k].unit)
                    }
                    CR_unit_array=unique(CR_unit_array);
                    for (var i = 0; i < CR_unit_array.length; i++) {
                        CR_unitno_options += '<option value="' + CR_unit_array[i] + '">' + CR_unit_array[i] + '</option>';
                    }
                    $('#CR_lb_unitno').html(CR_unitno_options).show();
                    $("#CR_lb_unitno").focus();
                }
                else{
                    $('#cardreplace_form').replaceWith('<form id="cardreplace_form" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="col-sm-12 errormsg"> '+CR_errorAarray[2].EMC_DATA+'</label></div></fieldset></div></form>');
                }
                var CR_reason_options ='<option>SELECT</option>';
                for (var i = 0; i < CR_reason_array.length; i++) {
                    CR_reason_options += '<option value="' + CR_reason_array[i] + '">' + CR_reason_array[i] + '</option>';
                }
                $('#CR_lb_reason').html(CR_reason_options);
                $('.preloader').hide();
            }
        // GET CUSTOMER NAME FOR THE SELECTED UNIT
            $('#CR_lb_unitno').change(function(){
                var CR_unit = $(this).val();
                if(CR_unit=='SELECT'){
                    $('#CR_lb_custname').val('SELECT').hide();
                    $('#CR_carddiv').find('select').val('SELECT');
                    $('#CR_custname,#CR_carddiv,#CR_comment,#CR_lbl_error,#CR_buttons,#CR_custid').hide();
                    $('#CR_custid > div').remove();
                }
                else
                {
                    $(".preloader").show();
                    $('#CR_lb_custname').val('SELECT').hide();
                    $('#CR_carddiv').find('select').val('SELECT');
                    $('#CR_custname,#CR_carddiv,#CR_comment,#CR_lbl_error,#CR_buttons,#CR_custid').hide();
                    $('#CR_custid > div').remove();
                    $.ajax({
                        type:'POST',
                        url:ctrl_cardreplace_url+'/Avialablecard',
                        data:{'unitno':CR_unit},
                        success: function(carddata){
                            var card_array=JSON.parse(carddata);
                            CR_avialablecard(card_array);
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("REPLACE OF ACCESS CARD",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            });
        // FUNCTION TO LOAD CUSTOMER NAME
            function CR_avialablecard(availcard_result){
                $(".preloader").hide();
                var CR_unit = $('#CR_lb_unitno').val();
                CR_inventory_card_array=availcard_result;
                if(CR_inventory_card_array.length!=0){
                    var CR_namearray=[];
                    for(var k=0;k<CR_allcust_details.length;k++)
                    {
                        if(CR_allcust_details[k].unit==CR_unit)
                        {
                            CR_namearray.push(CR_allcust_details[k].name);
                        }
                    }
                    CR_namearray=unique(CR_namearray);
                    var CR_custname_options ='<option>SELECT</option>';
                    for (var i = 0; i < CR_namearray.length; i++) {
                        var CR_myarray=CR_namearray[i].split('_');
                        var CR_custname=CR_myarray[0]+' '+CR_myarray[1];
                        CR_custname_options += '<option value="' + CR_namearray[i] + '">' + CR_custname + '</option>';
                    }
                    $('#CR_lb_custname').html(CR_custname_options).show();
                    $('#CR_custname').show();
                    $("#CR_lb_custname").focus();
                    $('#CR_lbl_error').hide();
                }
                else{
                    var msg=(CR_errorAarray[0].EMC_DATA).replace('[UNIT NO]',CR_unit);
                    $('#CR_lbl_error').text(msg).show();
                    $('#CR_error').show();
                    $('#CR_lb_unitno').val('SELECT');
                }
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            }
        // GET CARD NUMBER FOR SELECTED CUSTOMER NAME
            $('#CR_lb_custname').change(function(){
                var CR_custname=$(this).val();
                $('textarea').height(114);
                var CR_unit = $('#CR_lb_unitno').val();
                if(CR_custname=='SELECT'){
                    $('#CR_carddiv').find('select').val('SELECT');
                    $('#CR_curcard,#CR_newcard,#CR_reason,#CR_comment,#CR_lbl_error,#CR_buttons,#CR_custid').hide();
                    $('#CR_custid > div').remove();
                }
                else{
                    $(".preloader").show();
                    $('#CR_carddiv').find('select').val('SELECT');
                    $('#CR_curcard,#CR_newcard,#CR_reason,#CR_comment,#CR_lbl_error,#CR_buttons,#CR_custid').hide();
                    $('#CR_custid > div').remove();
                    var CR_name_id_array=[];
                    for(var k=0;k<CR_allcust_details.length;k++)
                    {
                        if((CR_allcust_details[k].name==CR_custname)&&(CR_allcust_details[k].unit==CR_unit))
                        {
                            CR_name_id_array.push(CR_allcust_details[k].customerid);
                        }
                    }
                    CR_name_id_array=unique(CR_name_id_array);
                    if(CR_name_id_array.length!=1){
                        $(".preloader").hide();
                        var CR_customername=$('#CR_lb_custname').val();
                        var CR_myarray=CR_customername.split('_');
                        var CCARD_custname=CR_myarray[0]+' '+CR_myarray[1];
                        var CR_radio_value='';
                        for (var i = 0; i < CR_name_id_array.length; i++) {
                            var final=CCARD_custname+' '+CR_name_id_array[i];
                            CR_radio_value ='<div class="col-sm-offset-2" style="padding-left:15px"><div class="radio"><label><input type="radio" name="custid" id='+CR_name_id_array[i]+' value='+CR_name_id_array[i]+' class="CR_class_custid" />'+ final +'</label></div></div>';
                            $('#CR_custid').append(CR_radio_value).show();
                        }
                    }
                    else{
                        CR_cust_id=CR_name_id_array[0];
                        CR_loadcust_card(CR_name_id_array[0]);
                        $('#CR_custid >div').remove();
                        $('#CR_custid').hide();
                    }
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                }
            });
        // LOAD CUSTOMER CARDS
            function CR_loadcust_card(CR_name_id){
                var CR_custcard_array=[];
                for(var k=0;k<CR_allcust_details.length;k++)
                {
                    if(CR_allcust_details[k].customerid==CR_name_id)
                    {
                        CR_custcard_array.push(CR_allcust_details[k].cardno);
                        var CR_comments=CR_allcust_details[k].comments;
                    }
                }
                CR_custcard_array=unique(CR_custcard_array);
                $('#CR_carddiv,#CR_curcard,#CR_lb_curcard').show();
                CR_comment=CR_comments;
                var CR_custcard_options ='<option>SELECT</option>';
                for (var i = 0; i < CR_custcard_array.length; i++) {
                    CR_custcard_options += '<option value="' + CR_custcard_array[i] + '">' + CR_custcard_array[i] + '</option>';
                }
                $('#CR_lb_curcard').html(CR_custcard_options);
                $(".preloader").hide();
                $("#CR_lb_curcard").focus();
            }
        // CHANGE EVENT FOR CURRENT CARD
            $('#CR_lb_curcard').change(function(){
                var CR_unit = $('#CR_lb_unitno').val();
                var currentcard=$(this).val();
                if(currentcard=='SELECT'){
                    $('#CR_comment,#CR_buttons,#CR_newcard,#CR_reason').hide();
                    $('#CR_lb_newcard').val('SELECT');
                    $('#CR_lb_reason').val('SELECT');
                }
                else{
                    $(".preloader").show();
                    $('#CR_comment,#CR_buttons,#CR_newcard,#CR_reason').hide();
                    $('#CR_lb_newcard').val('SELECT');
                    $('#CR_lb_reason').val('SELECT');
                    CR_load_availablecard(CR_inventory_card_array);
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                }
            });
        // FUNCTION TO LOAD AVAILABLE CARD'S
            function CR_load_availablecard(availablecards_result){
                $('#CR_lb_newcard,#CR_newcard').show();
                $(".preloader").hide();
                var CR_availablecard_array= [];
                CR_availablecard_array=CR_inventory_card_array;
                var CR_availablecard_options ='<option>SELECT</option>';
                for (var i = 0; i < CR_availablecard_array.length; i++) {
                    CR_availablecard_options += '<option value="' + CR_availablecard_array[i] + '">' + CR_availablecard_array[i] + '</option>';
                }
                $('#CR_lb_newcard').html(CR_availablecard_options);
                $("#CR_lb_newcard").focus();
            }
        // CHANGE EVENT FOR NEW CARD
            $('#CR_lb_newcard').change(function(){
                if($(this).val()=='SELECT'){
                    $('#CR_comment,#CR_buttons,#CR_reason').hide();
                    $('#CR_lb_reason').val('SELECT');
                }
                else{
                    $('#CR_comment,#CR_buttons').hide();
                    $('#CR_reason').show();
                    $('#CR_lb_reason').val('SELECT');
                    $("#CR_lb_reason").focus();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                }
            });
        // CUSTOMERS RADIO BUTTON EVENT
            $(document).on("change",'.CR_class_custid', function(){
                $(".preloader").show();
                var CR_customer_id=$("input[name=custid]:checked").val();
                CR_cust_id=CR_customer_id;
                var CR_unit = $('#CR_lb_unitno').val();
                $('#CR_carddiv').find('select').val('SELECT');
                $('#CR_curcard,#CR_newcard,#CR_reason,#CR_comment,#CR_buttons').hide();
                $('#CR_btn_submitbutton').attr('disabled','disabled');
                CR_loadcust_card(CR_customer_id);
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            });
        // FUNCTION TO LAOD ACCESS REASON
            $('#CR_lb_reason').change(function(){
                $('#CR_reason,#CR_comment').show();
                $('#CR_ta_comments').val(CR_comment).show();
                $("#CR_ta_comments").focus();
                $('#CR_cust_id').val(CR_cust_id);
                $('#CR_buttons').show();
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            });
        // SUBMIT BUTTON VALIDATION
            $(document).on("change",'.CR_formvalidation', function (){
                if(($('#CR_lb_custname').val()=='SELECT')||($('#CR_lb_curcard').val()=='SELECT')||($('#CR_lb_newcard')=='SELECT')||($('#CR_lb_reason').val()=='SELECT')||($('#CR_lb_unitno').val()=='SELECT'))
                {
                    $('#CR_btn_submitbutton').attr('disabled','disabled');
                }
                else{
                    $('#CR_btn_submitbutton').removeAttr('disabled','disabled');
                }
            });
        // CLEAR FORM
            function CR_clear(CR_final_result){
                $(".preloader").hide();
                var CR_SUCCESS_FLAG=CR_final_result[0];
                if(CR_SUCCESS_FLAG==1||CR_final_result=='clear')
                {
                    $('#CR_lb_unitno').val('SELECT');
                    $('#CR_lb_custname').val('SELECT');
                    $('#CR_carddiv').find('select').val('SELECT');
                    $('#CR_custname,#CR_curcard,#CR_newcard,#CR_reason,#CR_comment,#CR_lbl_error,#CR_buttons,#CR_custid').hide();
                    $('#CR_custid > div').remove();
                    $('#CR_ta_comments').val("");
                    $('#CR_btn_submitbutton').attr('disabled','disabled');
                    if(CR_final_result!='clear'){
                        CR_allcust_details=CR_final_result[1];
                    }
                    if(CR_SUCCESS_FLAG==1){
                        show_msgbox("REPLACE OF ACCESS CARD",CR_errorAarray[1].EMC_DATA,'success',false);
                    }
                }
                else
                {
                    if(CR_SUCCESS_FLAG==0){
                        show_msgbox("REPLACE OF ACCESS CARD",CR_errorAarray[3].EMC_DATA,'error',false);
                    }
                    else
                    {
                        show_msgbox("REPLACE OF ACCESS CARD",CR_SUCCESS_FLAG,'error',false);
                    }
                }
            }
        // RESET BUTTON EVENT
            $('#CR_btn_resetbutton').click(function(){
                CR_clear('clear');
            });
        // SUBMIT BUTTON EVENT
            $('#CR_btn_submitbutton').click(function(){
                $(".preloader").show();
                var formelement=$('#cardreplace_form').serialize();
                $.ajax({
                    type:'POST',
                    url:ctrl_cardreplace_url+'/Replacecardsave',
                    data:formelement,
                    success: function(CR_respons){
                        var card_array=JSON.parse(CR_respons);
                        CR_clear(card_array);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("REPLACE OF ACCESS CARD",errordata,'error',false);
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
    <div class="title text-center"><h4><b>REPLACE OF ACCESS CARD</b></h4></div>
    <form id="cardreplace_form" name="cardreplace_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="CR_unitno">
                    <label class="col-sm-2">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"> <select name="CR_lb_unitno" id="CR_lb_unitno" class="form-control CR_formvalidation"><option>SELECT</option></select></div>
                </div>
                <div class="form-group" id="CR_custname" hidden>
                    <label class="col-sm-2">CUSTOMER NAME <em>*</em></label>
                    <div class="col-sm-4"><select name="CR_lb_custname" id="CR_lb_custname" class="CR_formvalidation form-control"></select></div>
                </div>
                <div class="form-group" id="CR_custid" hidden>
                </div>
                <div id="CR_carddiv">
                    <div class="form-group" id="CR_curcard" hidden>
                        <label class="col-sm-2">CURRENT CARD <em>*</em></label>
                        <div class="col-sm-2"><select name="CR_lb_curcard" id="CR_lb_curcard" class="CR_formvalidation form-control"></select></div>
                        <input type="hidden" id="CR_cust_id" name="CR_cust_id"/>
                    </div>
                    <div class="form-group" id="CR_newcard" hidden>
                        <label class="col-sm-2">NEW CARD <em>*</em></label>
                        <div class="col-sm-2"><select name="CR_lb_newcard" id="CR_lb_newcard" class="CR_formvalidation form-control"></select></div>
                    </div>
                    <div class="form-group" id="CR_reason" hidden>
                        <label class="col-sm-2">REASON <em>*</em></label>
                        <div class="col-sm-2"><select name="CR_lb_reason" id="CR_lb_reason" class="CR_formvalidation form-control"></select></div>
                    </div>
                </div>
                <div class="form-group" id='CR_comment' hidden>
                    <label class="col-sm-2">COMMENTS</label>
                    <div class="col-sm-4"><textarea name="CR_ta_comments" id="CR_ta_comments" class="form-control" style="height: 114px" rows="5"></textarea></div>
                </div>
                <div class="form-group" id="CR_buttons" hidden>
                    <div class="col-sm-offset-1 col-sm-4">
                        <input class="maxbtn" type="button" id="CR_btn_submitbutton" name="REPLACE" value="REPLACE" disabled/>
                        <input class="maxbtn" type="button" id="CR_btn_resetbutton" name="RESET" value="RESET"/>
                    </div>
                </div>
                <div class="form-group" id="CR_error" hidden>
                    <lable id="CR_lbl_error" class="col-sm-4 errormsg"></lable>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>