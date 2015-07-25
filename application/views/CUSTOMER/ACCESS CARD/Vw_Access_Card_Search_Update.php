<?php
//******************************************Card Search Update********************************************//
//VER 0.01-SD:08/05/2015 ED:09/05/2015,initial version BY RAJA
//*******************************************************************************************************//
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <script type="text/javascript">
        // document ready function
        $(document).ready(function(){
            var ctrl_cardupdate_url="<?php echo site_url('CUSTOMER/ACCESSCARD/Ctrl_Access_Card_Search_Update'); ?>";
        // initial data
            $('textarea').autogrow({onInitialize: true});
            $('#spacewidth').height('0%');
            var CSU_errorAarray=[];
            var CSU_allcust_details=[];
            var CSU_reason_array=[];
            var CSU_cust_id;
            $.ajax({
                type:'POST',
                url:ctrl_cardupdate_url+'/Initialdata',
                data:{'ErrorList':'94,95,401'},
                success: function(data){
                    var value_array=JSON.parse(data);
                    CSU_load_initial_values(value_array);
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("ACCESS CARD SEARCH AND UPDATE",errordata,'error',false);
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
            function CSU_load_initial_values(CSU_initial_values){
                CSU_errorAarray=CSU_initial_values[2];
                CSU_allcust_details=CSU_initial_values[1];
                CSU_reason_array=CSU_initial_values[0];
                if(CSU_allcust_details.length!=0){
                    var CSU_unit_array=[];
                    var CSU_unitno_options ='<option>SELECT</option>';
                    for(var k=0;k<CSU_allcust_details.length;k++)
                    {
                        CSU_unit_array.push(CSU_allcust_details[k].unit);
                    }
                    CSU_unit_array=unique(CSU_unit_array);
                    for (var i = 0; i < CSU_unit_array.length; i++) {
                        CSU_unitno_options += '<option value="' + CSU_unit_array[i] + '">' + CSU_unit_array[i] + '</option>';
                    }
                    $('#CSU_lb_unitno').html(CSU_unitno_options);
                    $('#CSU_lb_unitno').focus();
                }
                else{
                    $('#card_search_update_form').replaceWith('<form id="card_search_update_form" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="col-sm-12 errormsg"> '+CSU_errorAarray[0].EMC_DATA+'</label></div></fieldset></div></form>');
                }
                var CSU_reason_options ='<option>SELECT</option>';
                for (var i = 0; i < CSU_reason_array.length; i++) {
                    CSU_reason_options += '<option value="' + CSU_reason_array[i] + '">' + CSU_reason_array[i] + '</option>';
                }
                $('#CSU_lb_reason').html(CSU_reason_options);
                $(".preloader").hide();
            }
        // GET CUSTOMER NAME FOR THE SELECTED UNIT
            $('#CSU_lb_unitno').change(function(){
                var CSU_unit = $(this).val();
                if(CSU_unit=='SELECT'){
                    $('#CSU_lb_custname').val('SELECT').hide();
                    $('#CSU_lb_curcard').val('SELECT').hide();
                    $('#CSU_detailsdiv').find('select').val('SELECT');
                    $('#CSU_custname,#CSU_curcard,#CSU_detailsdiv,#CSU_comments,#CSU_lbl_error,#CSU_buttons,#CSU_custid').hide();
                    $('#CSU_custid > div').remove();
                    $('#CSU_btn_updatebutton').attr('disabled','disabled');
                }
                else
                {
                    $('#CSU_lb_custname').val('SELECT').hide();
                    $('#CSU_lb_curcard').val('SELECT').hide();
                    $('#CSU_detailsdiv').find('select').val('SELECT');
                    $('#CSU_custname,#CSU_curcard,#CSU_detailsdiv,#CSU_comments,#CSU_lbl_error,#CSU_buttons,#CSU_custid').hide();
                    $('#CSU_custid > div').remove();
                    $('#CSU_btn_updatebutton').attr('disabled','disabled');
                    var CSU_namearray=[];
                    for(var k=0;k<CSU_allcust_details.length;k++)
                    {
                        if(CSU_allcust_details[k].unit==CSU_unit)
                        {
                            CSU_namearray.push(CSU_allcust_details[k].name);
                        }
                    }
                    CSU_namearray=unique(CSU_namearray);
                    var CSU_custname_options ='<option>SELECT</option>';
                    for (var i = 0; i < CSU_namearray.length; i++) {
                        var CSU_myarray=CSU_namearray[i].split('_');
                        var CSU_custname=CSU_myarray[0]+' '+CSU_myarray[1];
                        CSU_custname_options += '<option value="' + CSU_namearray[i] + '">' + CSU_custname + '</option>';
                    }
                    $('#CSU_lb_custname').html(CSU_custname_options).show();
                    $('#CSU_custname').show();
                    $('#CSU_lb_custname').focus();
                    $('#CSU_lbl_error').hide();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                }
            });
        // GET CARD NUMBER FOR SELECTED CUSTOMER NAME
            $('#CSU_lb_custname').change(function(){
                $('textarea').height(114);
                var CSU_custname=$(this).val();
                $(".preloader").show();
                var CSU_unit = $('#CSU_lb_unitno').val();
                if(CSU_custname=='SELECT')
                {
                    $('#CSU_lb_curcard').val('SELECT').hide();
                    $('#CSU_detailsdiv').find('select').val('SELECT');
                    $('#CSU_curcard,#CSU_detailsdiv,#CSU_comments,#CSU_lbl_error,#CSU_buttons,#CSU_custid').hide();
                    $('#CSU_custid > div').remove();
                    $('#CSU_btn_updatebutton').attr('disabled','disabled');
                }
                else{
                    $('#CSU_lb_curcard').val('SELECT').hide();
                    $('#CSU_detailsdiv').find('select').val('SELECT');
                    $('#CSU_curcard,#CSU_detailsdiv,#CSU_comments,#CSU_lbl_error,#CSU_buttons,#CSU_custid').hide();
                    $('#CSU_custid > div').remove();
                    $('#CSU_btn_updatebutton').attr('disabled','disabled');
                    var CSU_name_id_array=[];
                    for(var k=0;k<CSU_allcust_details.length;k++)
                    {
                        if((CSU_allcust_details[k].name==CSU_custname)&&(CSU_allcust_details[k].unit==CSU_unit))
                        {
                            CSU_name_id_array.push(CSU_allcust_details[k].customerid);
                        }
                    }
                    CSU_name_id_array=unique(CSU_name_id_array);
                    if(CSU_name_id_array.length!=1)
                    {
                        $(".preloader").hide();
                        var CSU_customername=$('#CSU_lb_custname').val();
                        var CSU_myarray=CSU_customername.split('_');
                        var CCARD_custname=CSU_myarray[0]+' '+CSU_myarray[1];
                        var CSU_radio_value='';
                        for (var i = 0; i < CSU_name_id_array.length; i++) {
                            var final=CCARD_custname+' '+CSU_name_id_array[i];
                            CSU_radio_value ='<div class="col-sm-offset-2" style="padding-left:15px"><div class="radio"><label><input type="radio" name="custid" id='+CSU_name_id_array[i]+' value='+CSU_name_id_array[i]+' class="CSU_class_custid" />'+ final +'</label></div></div>';
                            $('#CSU_custid').append(CSU_radio_value).show();
                        }
                    }
                    else{
                        CSU_cust_id=CSU_name_id_array[0];
                        CSU_loadcust_card(CSU_name_id_array[0]);
                        $('#CSU_custid > div').remove();
                        $('#CSU_custid').hide();
                    }
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                }
            });
        // LOAD CUSTOMER CARDS
            function CSU_loadcust_card(CACS_REP_name_id){
                var CSU_lostcard_array=[];
                for(var k=0;k<CSU_allcust_details.length;k++)
                {
                    if(CSU_allcust_details[k].customerid==CACS_REP_name_id)
                    {
                        CSU_lostcard_array.push(CSU_allcust_details[k].cardno);
                    }
                }
                CSU_lostcard_array=unique(CSU_lostcard_array);
                $('#CSU_curcard,#CSU_lb_curcard').show();
                var CSU_custcard_options ='<option>SELECT</option>';
                for (var i = 0; i < CSU_lostcard_array.length; i++) {
                    CSU_custcard_options += '<option value="' + CSU_lostcard_array[i] + '">' + CSU_lostcard_array[i] + '</option>';
                }
                $('#CSU_lb_curcard').html(CSU_custcard_options);
                $('#CSU_lb_curcard').focus();
                $(".preloader").hide();
            }
        // CUSTOMER RADIO CHANGE EVENT
            $(document).on("change",'.CSU_class_custid', function ()
            {
                $(".preloader").show();
                var CSU_customer_id=$("input[name=custid]:checked").val();
                CSU_cust_id=CSU_customer_id;
                var CSU_unit = $('#CSU_lb_unitno').val();
                $('#CSU_lb_curcard').val('SELECT').hide();
                $('#CSU_detailsdiv').find('select').val('SELECT');
                $('#CSU_curcard,#CSU_detailsdiv,#CSU_comments,#CSU_lbl_error,#CSU_buttons,#CSU_custid').hide();
                $('#CSU_custid > div').remove();
                $('#CSU_btn_updatebutton').attr('disabled','disabled');
                $('#CSU_ta_comments').val("");
                CSU_loadcust_card(CSU_customer_id);
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            });
        // CARD NO CHANGE EVENT
            $('#CSU_lb_curcard').change(function(){
                $(".preloader").show();
                $('#CSU_detailsdiv,#CSU_comments,#CSU_buttons').hide();
                $('#CSU_btn_updatebutton').attr('disabled','disabled');
                var CSU_unitno=$('#CSU_lb_unitno').val();
                var CSU_cardno=$('#CSU_lb_curcard').val();
                if(CSU_cardno!="SELECT"){
                    CSU_loadcustomer_details(CSU_unitno,CSU_cardno);
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                }
                else{
                    $('#CSU_detailsdiv,#CSU_comments,#CSU_buttons').hide();
                    $(".preloader").hide();
                }
            });
        //FUNCTION TO CONVERT DATE FORMAT
            function FormTableDateFormat(inputdate){
                var string = inputdate.split("-");
                return string[2]+'-'+ string[1]+'-'+string[0];
            }
        // LOAD CUSTOMER DETAILS
            function CSU_loadcustomer_details(CSU_unitno,CSU_cardno)
            {
                $(".preloader").hide();
                for(var k=0;k<CSU_allcust_details.length;k++)
                {
                    if((CSU_allcust_details[k].unit==CSU_unitno)&&(CSU_allcust_details[k].cardno==CSU_cardno))
                    {
                        var CSU_name=(CSU_allcust_details[k].name);
                        CSU_name=CSU_name.split("_");
                        var CSU_fname=CSU_name[0];
                        var CSU_lname=CSU_name[1];
                        var CSU_validfrom=CSU_allcust_details[k].validfrom;
                        CSU_validfrom=FormTableDateFormat(CSU_validfrom);
                        var CSU_validtill=CSU_allcust_details[k].validtill;
                        CSU_validtill=FormTableDateFormat(CSU_validtill);
                        var CSU_comments=CSU_allcust_details[k].comments;
                        var CSU_reason=CSU_allcust_details[k].reason;
                    }
                }
                var CSU_cardno=$('#CSU_lb_curcard').val();
                var CSU_unitno=$('#CSU_lb_unitno').val();
                var CSU_fname_length=(CSU_fname).length;
                var CSU_lname_length=(CSU_lname).length;
                $('#CSU_tb_lastname').attr("size",CSU_lname_length);
                $('#CSU_tb_firstname').attr("size",CSU_fname_length);
                $('#CSU_tb_unitno').val(CSU_unitno);
                $('#CSU_tb_firstname').val(CSU_fname);
                $('#CSU_tb_lastname').val(CSU_lname);
                $('#CSU_tb_cardno').val(CSU_cardno);
                $('#CSU_tb_validfrom').val(CSU_validfrom);
                $('#CSU_tb_validtill').val(CSU_validtill);
                $('#CSU_ta_comments').val(CSU_comments);
                $('#CSU_lb_reason').val(CSU_reason);
                $('#CSU_cust_id').val(CSU_cust_id);
                $('#CSU_detailsdiv,#CSU_comments,#CSU_buttons').show();
                $('#CSU_lb_reason').focus();
            }
        // SUBMIT BUTTON VALIDATION
            $('.submit_validate').change(function(){
                if($('#CSU_lb_reason').val()!='SELECT')
                {
                    $('#CSU_btn_updatebutton').removeAttr('disabled','disabled');
                }
                else
                {
                    $('#CSU_btn_updatebutton').attr('disabled','disabled');
                }
            });
        // RESET BUTTON EVENT
            $('#CSU_btn_resetbutton').click(function(){
                $('#card_search_update_form').find('select').val('SELECT');
                $('#card_search_update_form').find('input:text, textarea').val('');
                $('#CSU_custname,#CSU_curcard,#CSU_detailsdiv,#CSU_comments,#CSU_lbl_error,#CSU_buttons,#CSU_custid').hide();
                $('#CSU_custid > div').remove();
                $('#CSU_btn_updatebutton').attr('disabled','disabled');
            });
        // FORM CLEAR
            function CSU_clear(final_result){
                $(".preloader").hide();
                $('#card_search_update_form').find('select').val('SELECT');
                $('#card_search_update_form').find('input:text, textarea').val('');
                $('#CSU_custname,#CSU_curcard,#CSU_detailsdiv,#CSU_comments,#CSU_lbl_error,#CSU_buttons,#CSU_custid').hide();
                $('#CSU_custid > div').remove();
                $('#CSU_btn_updatebutton').attr('disabled','disabled');
                CSU_allcust_details=final_result[1];
                var return_flag=final_result[0];
                if(return_flag==1){
                    show_msgbox("ACCESS CARD SEARCH AND UPDATE",CSU_errorAarray[1].EMC_DATA,'success',false);
                }
                else{
                    show_msgbox("ACCESS CARD SEARCH AND UPDATE",CSU_errorAarray[2].EMC_DATA,'error',false);
                }
            }
            $('#CSU_btn_updatebutton').click(function(){
                $(".preloader").show();
                var formelement=$('#card_search_update_form').serialize();
                $.ajax({
                    type:'POST',
                    url:ctrl_cardupdate_url+'/Accesscardupdate',
                    data:formelement,
                    success: function(return_flag){
                        var flag_array=JSON.parse(return_flag);
                        CSU_clear(flag_array);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("ACCESS CARD SEARCH AND UPDATE",errordata,'error',false);
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
    <div class="title text-center"><h4><b>ACCESS CARD SEARCH AND UPDATE</b></h4></div>
    <form id="card_search_update_form" name="card_search_update_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="CSU_unitno">
                    <label class="col-sm-2">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"> <select name="CSU_lb_unitno" id="CSU_lb_unitno" class="form-control CSU_formvalidation"><option>SELECT</option></select></div>
                </div>
                <div class="form-group" id="CSU_custname" hidden>
                    <label class="col-sm-2">CUSTOMER NAME <em>*</em></label>
                    <div class="col-sm-4"><select name="CSU_lb_custname" id="CSU_lb_custname" class="CSU_formvalidation form-control"></select></div>
                </div>
                <div class="form-group" id="CSU_custid" hidden>
                </div>
                <div class="form-group" id="CSU_curcard" hidden>
                    <label class="col-sm-2">CARD NUMBER <em>*</em></label>
                    <div class="col-sm-2"><select name="CSU_lb_curcard" id="CSU_lb_curcard" class="CSU_formvalidation form-control"></select></div>
                </div>
                <div id="CSU_detailsdiv" hidden>
                    <div class="form-group">
                        <label class="col-sm-2">UNIT NUMBER</label>
                        <div class="col-sm-2"> <input type="text" name="CSU_tb_unitno" id="CSU_tb_unitno" class="form-control CSU_formvalidation" placeholder="Unit No" readonly/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">FIRST NAME</label>
                        <div class="col-sm-3"> <input type="text" name="CSU_tb_firstname" id="CSU_tb_firstname" class="form-control CSU_formvalidation" placeholder="First Name" readonly/></div>
                        <input type="hidden" id="CSU_cust_id" name="CSU_cust_id"/>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">LAST NAME</label>
                        <div class="col-sm-3"> <input type="text" name="CSU_tb_lastname" id="CSU_tb_lastname" class="form-control CSU_formvalidation" placeholder="Last Name" readonly/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">CARD NUMBER</label>
                        <div class="col-sm-2"> <input type="text" name="CSU_tb_cardno" id="CSU_tb_cardno" class="form-control CSU_formvalidation" placeholder="Card No" readonly/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">VALID FROM</label>
                        <div class="col-sm-2"> <input type="text" name="CSU_tb_validfrom" id="CSU_tb_validfrom" class="form-control CSU_formvalidation" placeholder="Valid From" readonly/></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">VALID TILL</label>
                        <div class="col-sm-2"> <input type="text" name="CSU_tb_validtill" id="CSU_tb_validtill" class="form-control CSU_formvalidation" placeholder="Valid Till" readonly/></div>
                    </div>
                    <div class="form-group" id="CSU_reason" >
                        <label class="col-sm-2">REASON <em>*</em></label>
                        <div class="col-sm-2"><select name="CSU_lb_reason" id="CSU_lb_reason" class="CSU_formvalidation submit_validate form-control"></select></div>
                    </div>
                </div>
                <div class="form-group" id='CSU_comments' hidden>
                    <label class="col-sm-2">COMMENTS</label>
                    <div class="col-sm-4"><textarea name="CSU_ta_comments" id="CSU_ta_comments" class="submit_validate form-control" style="height: 114px" rows="5"></textarea></div>
                </div>
                <div class="form-group" id="CSU_buttons" hidden>
                    <div class="col-sm-offset-1 col-sm-3">
                        <input class="btn btn-info" type="button" id="CSU_btn_updatebutton" name="submit" value="UPDATE" disabled/>
                        <input class="btn btn-info" type="button" id="CSU_btn_resetbutton" name="RESET" value="RESET"/>
                    </div>
                </div>
                <div class="form-group" id="CSU_error" hidden>
                    <lable id="CSU_lbl_error" class="col-sm-4 errormsg"></lable>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>