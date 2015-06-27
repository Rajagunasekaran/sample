
<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE*******************************//
//VER 0.02-SD:08/06/2015 ED:08/06/2015 CHANGED ALL CTRL,MODEL,VIEW FILE NAME AND GET USERSTAMP AND TIME ZONE FROM EILIB,
REMOVED DUPLICATE FUNCTION NAME,REMOVED COMMENTS AND EMPTY SPACE
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:18/05/2015 ED:18/05/2015
//************************************************************************************************************-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
<script>
    var ErrorControl ={EmailId:'Invalid'}
    var EP_ENTRY_listboxname;
    var value_err_array=[];
    var CA_namearray=[];
    var EP_SRC_UPD_DEL_emailid_id='';
    var ET_SRC_UPD_DEL_scriptname_id;
    $(document).ready(function() {
        var data=[];
        var EP_ENTRY_controller_url="<?php echo base_url(); ?>" + '/index.php/CONFIGURATION/EMAIL/Ctrl_Email_Profile_Entry_Search_Update_Delete/' ;
        $("#EP_ENTRY_btn_reset").hide();
        $("#EP_ENTRY_btn_save").hide();
        $("#EP_ENTRY_lb_profilename").hide();
        //START UNIQUE FUNCTION
        function unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
        // INITIAL DATA LODING
        $.ajax({
            type: "POST",
            'url':EP_ENTRY_controller_url+"Initaildatas",
            data:{"Formname":'EmailTemplateEntry',"ErrorList":'36,170,288,283,284,285,286,282,315,400,401,481,482,483'},
            success: function(data){
                $(".preloader").hide();
                value_err_array=JSON.parse(data);
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
        //LIST BOX ITEM CHANGE FUNCTION
        $('.PE_rd_selectform').click(function(){
            listboxoption=$(this).val();
            $('#ET_SRC_UPD_DEL_div_header').hide();
            $('#ET_SRC_UPD_DEL_div_headernodata').hide();
            $('#EP_ENTRY_lbl_validid').hide();
            $('#ET_SRC_UPD_DEL_div_header').hide();
            $('#ET_SRC_UPD_DEL_tble').hide();
            $("#EP_ENTRY_lb_profilename").hide();
            $("#EP_ENTRY_lbl_profilename").hide();
            $("#CONFIG_ENTRY_tr_type").hide();
            $("#EP_ENTRY_btn_reset").hide();
            $("#EP_ENTRY_btn_save").hide();
            $('#ET_SRC_UPD_DEL_tble').hide();
            if(listboxoption=='EMAIL ENTRY')
            {
                $("#EP_ENTRY_lb_profilename").val('SELECT').show();
                $("#EP_ENTRY_lbl_profilename").show();
            }
            else if(listboxoption=='EMAIL SEARCH/UPDATE')
            {
                $("#EP_ENTRY_lb_profilename").val('SELECT').show();
                $("#EP_ENTRY_lbl_profilename").show();
                $('#EP_ENTRY_tb_emailid').hide();
                $('#EP_ENTRY_lbl_emailid').hide();
            }
        });
        //JQUERY LIB VALIDATION START
        $('#EP_ENTRY_tb_emailid').doValidation({rule:'email',prop:{uppercase:false,autosize:true}});
        //JQUERY LIB VALIDATION END
        // radio click function
        var CONFIG_ENTRY_searchby=$('.PE_rd_selectform').val();
        $(document).on('click','.PE_rd_selectform',function(){
            $('.preloader').show();
            $('#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn,#CONFIG_ENTRY_tr_type').empty();
            $('#CONFIG_ENTRY_div_errMod').hide();
            $('#CONFIG_SRCH_UPD_div_header').hide();
            var EMAIL_ENTRY_data=$(this).val();
            var EP_SRC_UPD_DEL_emailarr_profilename=[];
            var EP_SRC_UPD_DEL_namearray=[];
            if($(this).val()!='SELECT'){
                $.ajax({
                    type: "POST",
                    'url':EP_ENTRY_controller_url+"EMAIL_ENTRY_script_name",
                    data :{'EMAIL_ENTRY_searchby':EMAIL_ENTRY_data},
                    success: function(data){
                        $('.preloader').hide();
                        var value_array=JSON.parse(data);
                        EP_SRC_UPD_DEL_emailarr_profilename=value_array[0]
                        for(var k = 0;k < EP_SRC_UPD_DEL_emailarr_profilename.length;k++)
                        {
                            EP_SRC_UPD_DEL_namearray.push(EP_SRC_UPD_DEL_emailarr_profilename[k].EP_EMAIL_DOMAIN+'_'+EP_SRC_UPD_DEL_emailarr_profilename[k].EP_ID)
                        }
                        EP_SRC_UPD_DEL_namearray=unique(EP_SRC_UPD_DEL_namearray);
                        var EP_SRC_UPD_DEL_emailarray_profilename ='<option>SELECT</option>';
                        for (var i = 0;i < EP_SRC_UPD_DEL_namearray.length; i++)
                        {
                            var EP_SRC_UPD_DEL_profilenameidconcat=EP_SRC_UPD_DEL_namearray[i].split("_");
                            EP_SRC_UPD_DEL_emailarray_profilename += '<option value="'+EP_SRC_UPD_DEL_profilenameidconcat[1]+'">'+EP_SRC_UPD_DEL_profilenameidconcat[0]+'</option>';
                        }
                        $('#EP_ENTRY_lb_profilename').html(EP_SRC_UPD_DEL_emailarray_profilename).show();
                    },
                    error: function(data){
                        alert('error in getting'+JSON.stringify(data));
                    }
                });
            }
        });
        //CHANGE EVENT FOR PROFILE
        $('#EP_ENTRY_lb_profilename').change(function(){
//                var  newPos= adjustPosition($(this).position(),100,270);
//                resetPreloader(newPos);
            $(".preloader").show();
            ET_SRC_UPD_DEL_scriptname_id = $("#EP_ENTRY_lb_profilename").val();
            EP_ENTRY_listboxname=$('#EP_ENTRY_lb_profilename').find('option:selected').text();
            var EP_ENTRY_profilename=$(this).val();
            $('#EP_ENTRY_tb_emailid').prop("size","20");
            $("#EP_ENTRY_btn_save").attr("disabled","disabled");
            if(EP_ENTRY_profilename=='SELECT')
            {
                $(".preloader").hide();
                $('#ET_SRC_UPD_DEL_div_header').hide();
                $('#ET_SRC_UPD_DEL_div_headernodata').hide();
                $('#ET_SRC_UPD_DEL_tble').hide();
                $('#EP_ENTRY_lbl_emailid').hide();
                $('#EP_ENTRY_tb_emailid').hide();
                $('#EP_ENTRY_btn_save').hide();
                $('#EP_ENTRY_btn_reset').hide();
                $('#EP_ENTRY_lbl_validid').hide();
            }
            else if(listboxoption=="EMAIL ENTRY")
            {
                $(".preloader").hide();
                $('#EP_ENTRY_tb_emailid').val('');
                $('#EP_ENTRY_lbl_emailid').show();
                $('#EP_ENTRY_tb_emailid').show();
                $('#EP_ENTRY_btn_save').show();
                $('#EP_ENTRY_btn_reset').show();
                $("#EP_ENTRY_tb_emailid").removeClass('invalid');
                $('#EP_ENTRY_lbl_validid').hide();
                var EP_ENTRY_id;
                for(var k=0;k<data.length;k++)
                {
                    if(data[k].EP_EMAIL_DOMAIN==EP_ENTRY_listboxname)
                    {
                        EP_SRC_UPD_DEL_id=(data[k].EP_ID);
                    }
                }
            }
            else if(listboxoption=="EMAIL SEARCH/UPDATE")
            {
                EP_SRC_UPD_DEL_srch_result();
            }

        });
        //EMAIL SUBMIT BUTTON VALIDATION
        function EP_ENTRY_checkmailid()
        {
            var EP_ENTRY_email=$("#EP_ENTRY_tb_emailid").val();
            if(EP_ENTRY_email.length==0 || EP_ENTRY_listboxname=='SELECT')
            {
                $("#EP_ENTRY_btn_save").attr("disabled","disabled");
                $('#EP_ENTRY_lbl_validid').hide();
                $("#EP_ENTRY_tb_emailid").removeClass('invalid');
            }
            else
            {
                var EP_ENTRY_validtype=ErrorControl.EmailId;
                if(EP_ENTRY_validtype=='Valid')
                {
                    $('#EP_ENTRY_lbl_validid').hide();
                    $("#EP_ENTRY_tb_emailid").removeClass('invalid');
                    $('#EP_ENTRY_tb_emailid').val($('#EP_ENTRY_tb_emailid').val().toLowerCase())
                    EP_ENTRY_already_result()
                }
                else
                {
                    $('#EP_ENTRY_lbl_validid').text(value_err_array[0].EMC_DATA).show();
                    $("#EP_ENTRY_tb_emailid").addClass('invalid');
                    $("#EP_ENTRY_btn_save").attr("disabled","disabled");
                }
            }
//SUCCESS FUNCTION FOR ALREADY EXIST FOR EMAIL ID
            function EP_ENTRY_already_result()
            {
                $(".preloader").hide();
                var EP_ENTRY_listboxname=$('#EP_ENTRY_lb_profilename').find('option:selected').text();
                var EP_ENTRY_profilenameid=$('#EP_ENTRY_lb_profilename').val();
                var EP_ENTRY_emailid=$('#EP_ENTRY_tb_emailid').val();
                $.ajax({
                    type: "POST",
                    'url':EP_ENTRY_controller_url+"data_exists",
                    data :{'EP_ENTRY_listboxname':EP_ENTRY_listboxname,'EP_ENTRY_emailid':EP_ENTRY_emailid},
                    success: function(data){
                        $('.preloader').hide();
                        var EP_ENTRY_response=JSON.parse(data.script_name_already_exits_array)//retdata.final_array[0];
                        if(EP_ENTRY_response==0)
                        {
                            if($("#EP_ENTRY_hidden_chkvalid").val()=="" && EP_ENTRY_emailid!='')
                            {
                                $("#EP_ENTRY_btn_save").removeAttr("disabled");
                            }
                            else
                            {
                                EP_ENTRY_save_success()
                            }
                        }
                        else
                        {
                            $(".preloader").hide();
                            var EP_ENTRY_email_errmsg=value_err_array[6].EMC_DATA.replace('[PROFILE]',EP_ENTRY_listboxname);
                            $('#EP_ENTRY_lbl_validid').show();
                            $('#EP_ENTRY_lbl_validid').text(EP_ENTRY_email_errmsg);
                            $("#EP_ENTRY_tb_emailid").addClass('invalid');
                            $("#EP_ENTRY_btn_save").attr("disabled","disabled");
                        }
                    }
                });
            }}
//BLUR FUNCTION FOR VALIDATION
        $("#EP_ENTRY_tb_emailid").blur(function(){
            $("#EP_ENTRY_hidden_chkvalid").val("")//SET VALIDATION FUNCTION VALUE
            EP_ENTRY_checkmailid()
        });
        //CLICK FUNCTION FOR SAVE BUTTON
        $("#EP_ENTRY_btn_save").click(function(){
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            $("#EP_ENTRY_hidden_chkvalid").val("SAVE")//SET SAVE FUNCTION VALUE
            var EP_ENTRY_emailid=$('#EP_ENTRY_tb_emailid').val();
            if(EP_ENTRY_emailid!="")
            {
                EP_ENTRY_checkmailid()
            }
        });
        //SAVE SUCCESS FUNCTION
        function EP_ENTRY_save_success(){
            var EP_ENTRY_profilenameid=$('#EP_ENTRY_lb_profilename').val();
            var EP_ENTRY_emailid=$('#EP_ENTRY_tb_emailid').val();
            $.ajax({
                type: "POST",
                'url':EP_ENTRY_controller_url+"save",
                data: {'EP_ENTRY_profilenameid': EP_ENTRY_profilenameid,'EP_ENTRY_emailid': EP_ENTRY_emailid},
                success: function(data) {
                    var result_value=JSON.parse(data.final_array);//retdata.final_array[0];
                    if(result_value==true)
                    {
                        $('#EP_ENTRY_lbl_emailid').hide();
                        $('#EP_ENTRY_tb_emailid').hide();
                        $('#EP_ENTRY_btn_save').attr("disabled","disabled").hide();
                        $('#EP_ENTRY_btn_reset').hide();
                        $('input:radio[name=optradio]').attr('checked',false);
                        var EP_ENTRY_email_errmsg=value_err_array[5].EMC_DATA.replace('[PROFILE]',EP_ENTRY_listboxname);
//MESSAGE BOX FOR SAVED SUCCESS
                        show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",EP_ENTRY_email_errmsg,"error",false)
                        $('#EP_ENTRY_lb_profilename').hide();
                        $('#EP_ENTRY_lbl_profilename').hide();
                        $('#EP_ENTRY_tb_emailid').prop("size","20");
                        $('#EP_ENTRY_lbl_validid').hide();
                    }
                    else
                    {
                        //MESSAGE BOX FOR NOT SAVED
                        show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[9].EMC_DATA,"error",false)
                        $('input:radio[name=optradio]').attr('checked',false);
                    }
                },
                error: function(data) {
//                    alert('Error has occurred. Status: ' + status + ' - Message: ' + message);
                }
            });
        }
        //CLICK FUNCTION FOR RESET BUTTON
        $('#EP_ENTRY_btn_reset').click(function()
        {
            EP_ENTRY_email_profile_rset();
        });
        //CLEAR ALL FIELDS
        function EP_ENTRY_email_profile_rset()
        {
//                $("#EP_ENTRY_form_emailprofile")[0].reset();
            $('#EP_ENTRY_lbl_emailid').hide();
            $('#EP_ENTRY_tb_emailid').hide();
            $('#EP_ENTRY_btn_save').hide();
            $('#EP_ENTRY_btn_reset').hide();
            $('#EP_ENTRY_lbl_validid').hide();
            $("#EP_ENTRY_lb_profilename").val('SELECT');
            $("#EP_ENTRY_tb_emailid").removeClass('invalid');
            $("#EP_ENTRY_btn_save").attr("disabled","disabled");
            $('#EP_ENTRY_tb_emailid').prop("size","20");
        }
        //FUNCTION FOR FORM TABLE DATE FORMAT
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        //update form
        var values_array=[];
        var ET_SRC_UPD_DEL_id;
        var emailid_id='';
        var ET_SRC_UPD_DEL_emailbody;
        var ET_SRC_UPD_DEL_userstamp;
        var ET_SRC_UPD_DEL_timestmp;
        var id;
        var ET_SRC_UPD_DEL_table_value='';
        var initialflag;
        //RESPONSE FUNCTION FOR FLEXTABLE SHOWING
        function EP_SRC_UPD_DEL_srch_result(){
            $(".preloader").hide();
            var ET_SRC_UPD_DEL_scriptname_id = $("#EP_ENTRY_lb_profilename").val();
            $('.preloader').hide();
            $.ajax({
                type: "POST",
                'url':EP_ENTRY_controller_url+"fetchdata",
                data: {'scriptnameid': ET_SRC_UPD_DEL_scriptname_id},
                success: function(data) {
                    values_array=JSON.parse(data);
                    if(values_array.length!=0)
                    {
                        var ET_SRC_UPD_DEL_table_header='<table id="ET_SRC_UPD_DEL_tble_htmltable" border="1"  cellspacing="0" class="srcresult"  ><thead  bgcolor="#6495ed" style="color:white"><tr><th></th><th style="width:1000px">EMAIL ID</th><th style="width:1000px">USERSTAMP</th><th style="width:150px" nowrap class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>'
                        var ET_SRC_UPD_DEL_errmsg =value_err_array[7].EMC_DATA.replace('[PROFILE]',EP_ENTRY_listboxname);
                        $('#ET_SRC_UPD_DEL_div_header').text(ET_SRC_UPD_DEL_errmsg).show();
                        for(var j=0;j<values_array.length;j++){
                            emailid_id=values_array[j].EL_EMAIL_ID;
                            ET_SRC_UPD_DEL_emailbody=values_array[j].USERSTAMP;
                            ET_SRC_UPD_DEL_timestmp=values_array[j].TIMESTAMP;
                            id=values_array[j].EL_ID;
                            initialflag=values_array[j].EP_NON_IP_FLAG;
                            if(initialflag=='X'){
                                ET_SRC_UPD_DEL_table_header+='<tr><td></td><td id=name_'+id+' class="emailidupdate" style="width:500px">'+emailid_id+'</td><td id=body_'+id+' class="emailbody" style="width:500px">'+ET_SRC_UPD_DEL_emailbody+'</td><td>'+ET_SRC_UPD_DEL_timestmp+'</td></tr>';
                            }
                            else{
                                ET_SRC_UPD_DEL_table_header+='<tr><td><span style="max-height:20px;max-width: 20px;" id ='+id+' class="glyphicon glyphicon-trash deletebutton"></span></td><td id=name_'+id+' class="emailidupdate" style="width:500px">'+emailid_id+'</td><td id=body_'+id+' class="emailbody" style="width:500px">'+ET_SRC_UPD_DEL_emailbody+'</td><td>'+ET_SRC_UPD_DEL_timestmp+'</td></tr>';
                            }}
                        ET_SRC_UPD_DEL_table_header+='</tbody></table>';
                        $('section').html(ET_SRC_UPD_DEL_table_header);
                        $('#ET_SRC_UPD_DEL_tble_htmltable').DataTable({
                            "aaSorting": [],
                            "pageLength": 10,
                            "sPaginationType":"full_numbers",
                            "aoColumnDefs" : [
                                { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ]

                        });
                        sorting()
                    }
                    else
                    {
                        $('#ET_SRC_UPD_DEL_div_header').hide();
                        $('#ET_SRC_UPD_DEL_div_table').hide();
                        var EP_SRC_UPD_DEL_errmsg=value_err_array[2].EMC_DATA.replace('[PROFILE]',EP_ENTRY_listboxname);
                        $('#ET_SRC_UPD_DEL_div_headernodata').text(EP_SRC_UPD_DEL_errmsg).show();
                        $('#ET_SRC_UPD_DEL_tble_htmltable').hide();
                        $('section').html('');
                        $('.preloader').hide();
                    }
                    $('#ET_SRC_UPD_DEL_tble').show();
                }
            });
        }
        var previous_id;
        var combineid;
        var tdvalue;
        //click function for email subject
        $(document).on('click','.emailidupdate', function (){
            if(previous_id!=undefined){
                $('#'+previous_id).replaceWith("<td class='data' id='"+previous_id+"' >"+tdvalue+"</td>");
            }
            var cid = $(this).attr('id');
            previous_id=cid;
            var id=cid.split('_');
            combineid=id[1];
            tdvalue=$(this).text();
            if(tdvalue!=''){
                $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='EP_SRC_UPD_DEL_tb_updemailid' name='data'  class='emailupdate uppercase' maxlength='50'  value='"+tdvalue+"'>");
            }
        } );

        $(document).on('click','.emailupdate',function(){
           EP_SRC_UPD_DEL_emailid_id=$(this).val().trim();
        });
        //CLICK EVENT FUCNTION FOR UPDATE
        var EP_SRC_UPD_DEL_updemailid;
        $(document).on('change','.emailupdate',function(){
                $("#EP_SRC_UPD_DEL_hidden_chkvalid").val("UPDATE")//SET UPDATE FUNCTION VALUE
//                var  newPos= adjustPosition($("#EP_SRC_UPD_DEL_tble_htmltable").position(),100,270);
//                resetPreloader(newPos);
//                $(".preloader").show();
                EP_SRC_UPD_DEL_updemailid=$(this).val().trim();
                if(EP_SRC_UPD_DEL_emailid_id!=EP_SRC_UPD_DEL_updemailid)
                {
                EP_SRC_UPD_DEL_checkmailid()
                }
            //CHECK VALID EMAIL ID
            function EP_SRC_UPD_DEL_checkmailid(){
                var ET_SRC_UPD_DEL_scriptname_id = $("#EP_ENTRY_lb_profilename").val();

                var atpos=EP_SRC_UPD_DEL_updemailid.indexOf("@");
                var dotpos=EP_SRC_UPD_DEL_updemailid.lastIndexOf(".");
                if(EP_SRC_UPD_DEL_updemailid.length>0)
                {
                    if ((atpos<1 || dotpos<atpos+2 || dotpos+2>=EP_SRC_UPD_DEL_updemailid.length)||(/^[@a-zA-Z0-9-\\.]*$/.test(EP_SRC_UPD_DEL_updemailid) == false))
                    {
                        $(".preloader").hide();
                        show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[0].EMC_DATA,"success",false)
                        $('#EP_SRC_UPD_DEL_tb_updemailid').addClass("invalid")
                    }
                    else if(ET_SRC_UPD_DEL_scriptname_id==8)
                    {
                        if((($("#EP_SRC_UPD_DEL_tb_updemailid").val()).substring(($("#EP_SRC_UPD_DEL_tb_updemailid").val()).indexOf("@") + 1) == "ssomens.com"))
                        {
                            EP_SRC_UPD_DEL_checkmailid1()
                        }
                        else
                        {
                            $("#EP_SRC_UPD_DEL_tb_updemailid").addClass('invalid');
                            show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[11].EMC_DATA,"success",false)
                        }
                    }
                    else if(ET_SRC_UPD_DEL_scriptname_id==7)
                    {
                        if((($("#EP_SRC_UPD_DEL_tb_updemailid").val()).substring(($("#EP_SRC_UPD_DEL_tb_updemailid").val()).indexOf("@") + 1) == "gmail.com"))
                        {
                            EP_SRC_UPD_DEL_checkmailid1()
                        }
                        else
                        {
                            $("#EP_SRC_UPD_DEL_tb_updemailid").addClass('invalid');
                            show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[13].EMC_DATA,"success",false)
                        }
                    }
                    else if(ET_SRC_UPD_DEL_scriptname_id==3)
                    {
                        if((($("#EP_SRC_UPD_DEL_tb_updemailid").val()).substring(($("#EP_SRC_UPD_DEL_tb_updemailid").val()).indexOf("@") + 1) == "expatsint.com"))
                        {
                            EP_SRC_UPD_DEL_checkmailid1()
                        }
                        else
                        {
                            $("#EP_SRC_UPD_DEL_tb_updemailid").addClass('invalid');
                            show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[12].EMC_DATA,"success",false)
                        }
                    }
                    else if(ET_SRC_UPD_DEL_scriptname_id!=8)
                    {
                        $('#EP_SRC_UPD_DEL_tb_updemailid').removeClass("invalid")
                        EP_SRC_UPD_DEL_checkmailid1()
                    }
                    //ALREADY EMAIL ID EXIT FUNCTION
                }
            }
    });
        function EP_SRC_UPD_DEL_checkmailid1(){
            var EP_ENTRY_listboxname=$('#EP_ENTRY_lb_profilename').find('option:selected').text();
            var EP_ENTRY_profilenameid=$('#EP_ENTRY_lb_profilename').val();
            var EP_ENTRY_emailid=$('#EP_ENTRY_tb_emailid').val();
            $.ajax({
                type: "POST",
                'url':EP_ENTRY_controller_url+"upddata_exists",
                data :{'EP_SRC_UPD_DEL_updemailid':EP_SRC_UPD_DEL_updemailid,'EP_ENTRY_listboxname':EP_ENTRY_listboxname},
                success: function(data){
                    $('.preloader').hide();
                    var ET_ENTRY_response=JSON.parse(data.emailid_already_exits_array)//retdata.final_array[0];
                    var CONFIG_ENTRY_values=ET_ENTRY_response;
                    if(CONFIG_ENTRY_values==1){
                        var EP_ENTRY_email_errmsg=value_err_array[6].EMC_DATA.replace('[PROFILE]',EP_ENTRY_listboxname);
                        $("#EP_SRC_UPD_DEL_tb_updemailid").addClass('invalid');
                        show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",EP_ENTRY_email_errmsg,"success",false)

                    }
                    else{
                        EP_SRC_UPD_DEL_update_result()
                    }
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        }
        //SUCCESS FUNCTION FOR UPDATION PROCESS
        function EP_SRC_UPD_DEL_update_result()
        {
            if((EP_SRC_UPD_DEL_updemailid!='')){
                $.ajax({
                    type: "POST",
                    'url':EP_ENTRY_controller_url+"emailupdate",
                    data:{'rowid':combineid,'profileid':EP_SRC_UPD_DEL_updemailid},
                    success: function(ET_SRC_UPD_DEL_update_result) {
                        if(ET_SRC_UPD_DEL_update_result=="true")
                        {
                            EP_SRC_UPD_DEL_srch_result()
                            var ET_SRC_UPD_DEL_errmsg=value_err_array[3].EMC_DATA.replace('[PROFILE]',EP_ENTRY_listboxname);
                            show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",ET_SRC_UPD_DEL_errmsg,"success",false)
                            previous_id=undefined;                            }
                        else
                        {
                            //MESSAGE BOX FOR NOT UPDATED
                            show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[10].EMC_DATA,"error",false)
                        }
                    }
                });
            }
        }
        //CLICK FUNCTION FOR DELETE BTN
        var rowid='';
        $(document).on('click','.deletebutton',function(){
            rowid = $(this).attr('id');
            show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[8].EMC_DATA,"success","delete");
        });
        //CLICK FUNCTION FOR OK BUTTON IN DELETE MESSAGE BOX
        $(document).on('click','.deleteconfirm',function(){
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Email_Profile_Forms/deleteconformoption",
                data :{'rowid':rowid},
                success: function(data) {
                    $('.preloader').hide();
                    var successresult=JSON.parse(data);
                    var deleteflag=successresult;
                    if(deleteflag==1){
                        var errmsg=value_err_array[4].EMC_DATA.replace('[PROFILE]',EP_ENTRY_listboxname);
                        show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",errmsg,"success",false)
                        EP_SRC_UPD_DEL_srch_result()
                    }
                    else
                    {
                        show_msgbox("EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE",value_err_array[1].EMC_DATA,"error",false)
                    }
                }
            });
        });
        //FUNCTION FOR SORTING
        function sorting(){
            jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
                var x = new Date( Date.parse(FormTableDateFormat(a)));
                var y = new Date( Date.parse(FormTableDateFormat(b)) );
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
                var x = new Date( Date.parse(FormTableDateFormat(a)));
                var y = new Date( Date.parse(FormTableDateFormat(b)) );
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_timestp-asc']  = function(a,b) {
                var x = new Date( Date.parse(FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_timestp-desc'] = function(a,b) {
                var x = new Date( Date.parse(FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
        }
    });
    //READY FUNCTION END
</script>
<!--SCRIPT TAG END-->
<!--BODY TAG START-->
</head>
<body>
<div class="container">
<div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
<div class="title text-center"><h4><b>EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE</b></h4></div>
<form id="EP_ENTRY_form_emailprofile" name="EP_ENTRY_form_emailprofile" class="form-horizontal content" role="form">
    <div class="panel-body">
        <fieldset>
            <div style="padding-bottom: 15px">
                <div class="radio">
                    <label><input type="radio" name="optradio" value="EMAIL ENTRY" class="PE_rd_selectform">ENTRY</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="optradio" value="EMAIL SEARCH/UPDATE" class="PE_rd_selectform">SEARCH/UPDATE/DELETE</label>
                </div>
            </div>
            <div class="form-group">
                <label  name="EP_ENTRY_lbl_profilename" id="EP_ENTRY_lbl_profilename" class="col-sm-2 " hidden>PROFILE NAME<em>*</em></label>
                <div class="col-sm-4">
                    <select class="form-control  validation" name="EP_ENTRY_lb_profilename"  required id="EP_ENTRY_lb_profilename"  hidden>
                        <option>SELECT</option>
                    </select/>
                </div>
            </div>
            <div class="row form-group">
                <label name="EP_ENTRY_lbl_emailid" id="EP_ENTRY_lbl_emailid" class="col-sm-2" hidden>E-MAIL ID<em>*</em></label>
                <div class="col-sm-10">
                    <input  type="text" name="EP_ENTRY_tb_emailid" id="EP_ENTRY_tb_emailid" class=" uppercase autosize" maxlength=100 hidden>
                    <label id="EP_ENTRY_lbl_validid" name="EP_ENTRY_lbl_validid" class="errormsg" disabled="" hidden></label>
                </div>
            </div>
            <input type="button" class="btn" name="EP_ENTRY_btn_save" id="EP_ENTRY_btn_save" value="SAVE" hidden>
            <input type="button" class="btn" name="EP_ENTRY_btn_reset" id="EP_ENTRY_btn_reset" value="RESET" hidden>
            <input type=hidden id="EP_ENTRY_hidden_chkvalid">
            <div class="srctitle" name="ET_SRC_UPD_DEL_div_header" id="ET_SRC_UPD_DEL_div_header"></div><br>
            <div class="errormsg" name="ET_SRC_UPD_DEL_div_headernodata" id="ET_SRC_UPD_DEL_div_headernodata"></div>
            <div class="table-responsive" id="ET_SRC_UPD_DEL_tble" hidden>
                <section>
                </section>
            </div>
            <input type=hidden id="EP_SRC_UPD_DEL_hidden_chkvalid">
            <fieldset>
    </div>
</div>
</form>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->
