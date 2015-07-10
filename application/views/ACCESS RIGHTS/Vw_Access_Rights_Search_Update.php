<!--
//*******************************************FILE DESCRIPTION*********************************************
//************************************ACCESS_RIGHTS_ACCESS_RIGHTS-SEARCH/UPDATE***********************************************//
 DONE BY:safi

   VER 0.01 - INITIAL VERSION-SD:04/05/2015 ED:14/05/2015
-->
<!--HTML TAG START-->
<?php

require_once('application/libraries/EI_HDR.php');

?>

<html>
<!--HEAD TAG START-->
<head>

<!--SCRIPT TAG START-->
<script>

$(document).ready(function(){

    $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
    $('#URSRC_tb_customrole').doValidation({rule:'alphanumeric',prop:{autosize:true,whitespace:true}});
    $('#URSRC_tb_loginid').doValidation({rule:'general',prop:{uppercase:false,autosize:true}});
    $(".preloader").show();
    var URSRC_multi_array=[];
    var URSRC_userrigths_array=[]
    var URSRC_role=[];
    var URSRC_custome_role_array=[];
    var URSRC_loginids_array=[];
    var URSRC_folder_array=[];
    var URSRC_basicradio_value;
    var URSRC_errorAarray=[]
    var URSRC_basicrole_array=[];
    var URSRC_basicrole_profile_array=[]
    var URSRC_basic_role;
    var UserStamp;
    var controller_url="<?php echo base_url(); ?>" + '/index.php/ACCESSRIGHTS/Ctrl_Access_Rights_Search_Update/' ;
    ////FUNCTION TO LOAD INITIAL VALUES
    $.ajax({
        type: "POST",
        'url': controller_url+"Loadinitialdata",
        success: function(data){
            $('.preloader').hide();
            var URSRC_intialvalues=JSON.parse(data);
            URSRC_errorAarray=URSRC_intialvalues[0].URSRC_errorAarray
            URSRC_userrigths_array=URSRC_intialvalues[0].URSRC_userrights;
            URSRC_role=URSRC_intialvalues[0].URSRC_role_array;
            URSRC_custome_role_array=URSRC_intialvalues[0].URSRC_custome_role;
            URSRC_basicrole_array=URSRC_intialvalues[0].URSRC_basicroles_array;
            URSRC_basic_role=URSRC_intialvalues[0].URSRC_basicrole;
            URSRC_basicrole_profile_array=URSRC_intialvalues[0].URSRC_basicrole_profile_array;
            UserStamp=URSRC_intialvalues[0].UserStamp;
            if(URSRC_userrigths_array.length!=0){
                var URSRC_role_radio='<div class="form-group" style="padding-left: 10px" ><div class="radio"><label class=" col-sm-2" style="white-space: nowrap!important;">SELECT ROLE ACCESS</label>'
                var URSRC_basicrole_radio='<div class="form-group"><div class="radio"><label class=" col-sm-2" style="white-space: nowrap!important;">SELECT BASIC ROLE</label>'
                for (var i = 0; i < URSRC_userrigths_array.length; i++) {
                    var id="URSRC_tble_table"+i
                    var id1="URSRC_userrigths_array"+i;
                    var value=URSRC_userrigths_array[i].replace(" ","_")
                    URSRC_role_radio+='  <div class="col-sm-offset-2 col-sm-10"><label style="white-space: nowrap!important;"><input type="radio" name="basicroles" id='+id1+' value='+value+' class="URSRC_class_basicroles "  />' + URSRC_userrigths_array[i] + '</label></div>';
                    URSRC_basicrole_radio+='<div class=" col-sm-offset-2 col-sm-10"><label style="white-space: nowrap!important;"><input type="radio" name="URSRC_radio_basicroles1" id='+value+i+' value='+value+' class="URSRC_class_basic"/>'+URSRC_userrigths_array[i]+'</label></div>';
                }
                URSRC_role_radio+='</div></div>';
                URSRC_basicrole_radio+='</div></div>';
                $('#URSRC_tble_roles').html(URSRC_role_radio);
                $('#URSRC_tble_basicroles').html(URSRC_basicrole_radio);
            }
            else{
                var msg=URSRC_errorAarray[10].replace("[USERID]",UserStamp);
                $('#URSRC_form_user_rights').replaceWith('<p><label class="errormsg">'+msg+'</label></p>');
            }
            var URSRC_basicrole_radio='<label class=" col-sm-2" style="white-space: nowrap!important;">SELECT BASIC ROLE</label>'
            var URSRC_basicroleprofile_radio='<label class=" col-sm-2" style="white-space: nowrap!important;">SELECT BASIC ROLE <em>*</em></label>'
            for(var j=0;j<URSRC_basicrole_profile_array.length;j++){
                var basic_roleprofile_value=URSRC_basicrole_profile_array[j].replace(" ","_")
                URSRC_basicroleprofile_radio+='<div class="col-sm-offset-2 col-sm-10"><label class=" col-sm-2" style="white-space: nowrap!important;"><input type="checkbox" name="URSRC_cb_basicroles1[]" id='+basic_roleprofile_value+' value='+basic_roleprofile_value+' class="URSRC_class_basicroles_chk tree"/>'+URSRC_basicrole_profile_array[j]+'</label></div>';
            }
            $('#URSRC_tble_basicroles_chk').html(URSRC_basicroleprofile_radio);
        },
        error: function(data){
            show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false);
        }
    });
    $('.datepicker').datepicker({
        dateFormat:"dd-mm-yy",changeYear:true,changeMonth:true
    });
    $( '.datepicker' ).datepicker( "option", "maxDate", new Date() );
   //BASIC ROLE MENU CREATION CLICK FUNCTION
    $('#URSRC_radio_basicrolemenucreation').click(function(){
        $('#URSRC_lbl_header').text("BASIC ROLE MENU CREATION").show();
        $('#URSRC_tble_basicroles').show();
        $('#URSRC_lbl_nodetails_err').hide()
        $('#URSRC_tble_basicrolemenucreation').show();
        $('#URSRC_lbl_login_role').hide();
        $('#URSRC_lbl_joindate').hide().val("");
        $('#URSRC_tb_joindate').hide().val("");
        $('#URSRC_tb_loginid').hide();
        $('#URSRC_lbl_loginid').hide();
        $('#URSRC_lbl_loginid1').hide();
        $('#URSRC_btn_submitbutton').val("CREATE").hide()
        $('#URSRC_tble_rolesearch').hide();
        $('#URSRC_btn_login_submitbutton').attr("disabled","disabled").hide();
        $('#URSRC_tb_customrole').val("");
        $('#URSRC_tble_rolecreation').empty().hide()
        $('#URSRC_tble_role').hide();
        $('#URSRC_tble_login').hide();
        $('#URSRC_lbl_basicrole_err').hide()
        $('#URSRC_tble_menu').hide();
        $('#URSRC_tble_folder').hide();
        $('#URSRC_tble_roles').hide()
        $('#URSRC_tble_basicroles_chk ').hide();
        $('#URSRC_lbl_role_err').hide()
        $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
        $('input[name=URSRC_cb_basicroles1]').attr('checked',false);
    });
    //BASIC ROLE MENU SEARCH/UPDATE CLICK FUNCTION
    $('#URSRC_radio_basicrolemenusearchupdate').click(function(){
        $('#URSRC_lbl_header').text("BASIC ROLE MENU SEARCH UPDATE").show()
        $('#URSRC_lbl_login_role').hide();
        $('#URSRC_lbl_joindate').hide().val("");
        $('#URSRC_lbl_nodetails_err').hide()
        $('#URSRC_tb_joindate').hide().val("");
        $('#URSRC_lbl_basicrole_err').hide()
        $('#URSRC_tb_loginid').hide();
        $('#URSRC_lbl_loginid').hide();
        $('#URSRC_lbl_loginid1').hide();
        $('#URSRC_lbl_basicrole_err').hide();
        $('#URSRC_lbl_role_err').hide()
        $('#URSRC_btn_submitbutton').val("UPDATE").hide()
        $('#URSRC_tble_rolesearch').hide();
        $('#URSRC_btn_login_submitbutton').attr("disabled","disabled").hide();
        $('#URSRC_tb_customrole').val("");
        $('#URSRC_tble_rolecreation').empty().hide()
        $('#URSRC_tble_role').hide();
        $('#URSRC_tble_roles').hide()
        $('#URSRC_tble_login').hide();
        $('#URSRC_tble_menu').hide();
        $('#URSRC_tble_folder').hide();
        $('#URSRC_tble_basicroles').show();
        $('#URSRC_tble_basicrolemenucreation').show();
        $('#URSRC_tble_basicroles_chk ').hide()
        $('input[name=URSRC_cb_basicroles1]').prop('checked',false);
        $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
    });
    //ROLE CREATION CLICK FUNCTION
    $('#URSRC_radio_rolecreation').click(function(){
        $('#URSRC_lbl_header').text("ROLE CREATION").show()
        $('#URSRC_tble_search').hide();
        $('#URSRC_tble_login').hide();
        $('#URSRC_lbl_nodetails_err').hide()
        $('#URSRC_tb_loginid').val("");
        $('#URSRC_lbl_role_err').hide()
        $('#URSRC_tble_role').show();
        $('#URSRC_tble_rolesearch').hide();
        $('#URSRC_tble_menu').hide();
        $('#URSRC_tble_folder').hide();
        $('#URSRC_tb_joindate').val("");
        $('#URSRC_lbl_basicrole_err').hide()
        $('#URSRC_btn_submitbutton').val("CREATE").hide()
        $('#URSRC_tble_basicroles').hide();
        $('#URSRC_tble_basicrolemenucreation').hide();
        $('#URSRC_tble_basicroles_chk ').hide()
        $('input:[name=URSRC_cb_basicroles1]').prop('checked',false);
        $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
    });
    //LOGIN CREATION CLICK FUNCTION
    $('#URSRC_radio_logincreation').click(function(){
        $('#URSRC_lbl_header').text("LOGIN CREATION").show()
        $('#URSRC_tb_customrole').val("");
        $('#URSRC_lbl_nodetails_err').hide()
        $('#URSRC_btn_submitbutton').val("UPDATE").hide()
        $('#URSRC_tble_rolesearch').hide();
        $('#URSRC_lbl_login_role').hide();
        $('#URSRC_lbl_role_err').hide()
        $('#URSRC_lbl_joindate').hide();
        $('#URSRC_lbl_loginid').show();
        $('#URSRC_lbl_loginid1').hide();
        $('#URSRC_tb_joindate').hide();
        $('#URSRC_lbl_basicrole_err').hide()
        $('#URSRC_lb_selectloginid').hide();
        $('input:radio[name=basicroles]').attr('checked',false);
        $('#URSRC_tble_role').hide()
        $('#URSRC_tble_roles').hide()
        $('#URSRC_tble_menu').hide();
        $('#URSRC_tble_folder').hide();
        $('#URSRC_tble_login').show();
        $('#URSRC_tb_loginid').show();
        $("#URSRC_lbl_email_err").hide()
        $('#URSRC_tble_rolesearch').hide();
        $('#URSRC_tble_rolecreation').empty().hide()
        $('#URSRC_tb_loginid').removeClass("invalid")
        $('#URSRC_lbl_nologin_err').hide()
        $('#URSRC_btn_login_submitbutton').attr("disabled","disabled").hide();
        $('#URSRC_tble_basicroles').hide();
        $('#URSRC_tble_basicrolemenucreation').hide();
        $('#URSRC_tble_basicroles_chk ').hide()
        $('input[name=URSRC_cb_basicroles1]').attr('checked',false);
        $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
    });
    //LOGIN SEARCH/UPDATE CLICK FUNCTION
    $('#URSRC_radio_loginsearchupdate').click(function(){
        $('#URSRC_lbl_header').text("LOGIN SEARCH/UPDATE").show()
        var  newPos= adjustPosition($(this).position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        $('#URSRC_tb_loginid').val("");
        $('#URSRC_lbl_nodetails_err').hide()
        $('#URSRC_lbl_role_err').hide();
        $('input:radio[name=basicroles]').attr('checked',false);
        $('#URSRC_tble_role').hide()
        $('#URSRC_tble_roles').hide()
        $('#URSRC_btn_submitbutton').val("UPDATE").hide()
        $('#URSRC_lbl_login_role').hide();
        $('#URSRC_lbl_basicrole_err').hide()
        $('#URSRC_lbl_joindate').hide().val("");
        $('#URSRC_tb_joindate').hide().val("");
        $('#URSRC_tb_loginid').hide();
        $('#URSRC_lbl_loginid').hide();
        $('#URSRC_lbl_loginid1').hide();
        $('#URSRC_tble_rolesearch').hide();
        $('#URSRC_tb_loginid').removeClass("invalid")
        $('#URSRC_tble_menu').hide();
        $("#URSRC_lbl_email_err").hide()
        $('#URSRC_tble_folder').hide();
        $('#URSRC_btn_login_submitbutton').attr("disabled","disabled").hide();
        $('#URSRC_tb_customrole').val("");
        $('#URSRC_tble_rolecreation').empty().hide();
        $('#URSRC_tble_basicroles').hide();
        $('#URSRC_tble_basicrolemenucreation').hide();
        $('#URSRC_tble_basicroles_chk ').hide()
        $('input[name=URSRC_cb_basicroles1]').attr('checked',false);
        $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
        $.ajax({
            type: "POST",
            'url': controller_url+"URSRC_get_loginid",
            data:{'URSRC_basicradio_value':URSRC_basicradio_value},
            success: function(data){
                $(".preloader").hide();
                var loginid_array=JSON.parse(data);
                if(loginid_array.length!=0){
                    var URSRC_loginid_options='<option>SELECT</option>'
                    for(var l=0;l<loginid_array.length;l++){
                        URSRC_loginid_options+= '<option value="' + loginid_array[l] + '">' + loginid_array[l]+ '</option>';
                    }
                    $('#URSRC_lb_selectloginid').html(URSRC_loginid_options);
                    $('#URSRC_lb_selectloginid').show().prop('selectedIndex',0);
                    $('#URSRC_tble_login').show();
                    $('#URSRC_lbl_loginid1').show();
                }
                else{
                    $('#URSRC_tble_login').show();
                    $('#URSRC_lbl_loginid1').hide();
                    $('#URSRC_lb_selectloginid').hide()
                    $('#URSRC_lbl_nologin_err').text(URSRC_errorAarray[3]).show();
                }
            },
            error: function(data){
                show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false);
            }
        });
    });
    //ROLE SEARCH/UPDATE CLICK
    $('#URSRC_radio_rolesearchupdate').click(function(){
        $('#URSRC_lbl_header').text("ROLE SEARCH/UPDATE").show();
        var  newPos= adjustPosition($(this).position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        $('#URSRC_btn_submitbutton').val('UPDATE').hide();
        $('#URSRC_tble_role').hide();
        $('#URSRC_tble_menu').hide();
        $('#URSRC_tble_folder').hide();
        $('#URSRC_lbl_nodetails_err').hide()
        $('#URSRC_tble_login').hide()
        $('#URSRC_tble_roles').hide();
        $('#URSRC_tb_customrole').val("")
        $('#URSRC_tble_search').hide();
        $('#URSRC_lbl_basicrole_err').hide()
        $('#URSRC_tble_login').hide();
        $('#URSRC_tb_loginid').val("");
        $('#URSRC_tb_joindate').val("");
        $('input:radio[name=basicroles]').attr('checked',false);
        $('#URSRC_tble_basicroles').hide();
        $('#URSRC_tble_basicrolemenucreation').hide();
        $('#URSRC_tble_basicroles_chk ').hide()
        $('input[name=URSRC_cb_basicroles1]').attr('checked',false);
        $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
        $.ajax({
            type:'POST',
            'url': controller_url+"URSRC_get_customrole",
            success:function(data){
              var URSRC_custome_role_array=JSON.parse(data);
              $(".preloader").hide();
              if(URSRC_custome_role_array.length!=0){
                    var URSRC_customerole_options='<option>SELECT</option>'
                    for(var l=0;l<URSRC_custome_role_array.length;l++){
                             URSRC_customerole_options+= '<option value="' + URSRC_custome_role_array[l] + '">' + URSRC_custome_role_array[l]+ '</option>';
                    }
                    $('#URSRC_lb_selectrole').html(URSRC_customerole_options);
                    $('#URSRC_tble_rolesearch').show();
                    $('#URSRC_rolesearch_roles').hide()
                    $('#URSRC_lbl_norole_err').hide();
              }
              else{
                $('#URSRC_lbl_norole_err').text(URSRC_errorAarray[9]).show();
                $('#URSRC_tble_rolesearch').show();
                $('#URSRC_lb_selectrole').hide()
                $('#URSRC_rolesearch_roles').hide()
                $('#URSRC_lbl_selectrole').hide()
              }
            },
            error: function(data){
                show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false);
            }
        }) ;
    });
    var basicmenurolesresult=[];
    //WEHN BASIC ROLE CLICK IN BASIC MENU CREATION AND SEARCH/UPDATE FORM
    $(document).on("click",'.URSRC_class_basic', function (){
        var  newPos= adjustPosition($(this).position(),100,270);
        resetPreloader(newPos)
        $('.preloader').show();
        $('#URSRC_btn_submitbutton').hide();
        $('input[type=checkbox]').attr('checked', false);
        URSRC_basicradio_value=$(this).val();
        var role=$(this).val()
        role=role.replace("_"," ")
        var formElement = document.getElementById("URSRC_userrightsform");
        $.ajax({
            type: "POST",
            'url': controller_url+"URSRC_check_basicrolemenu",
            data:{'URSRC_basicradio_value':URSRC_basicradio_value},
            success: function(data){
                var msg_alert=data;
                if(msg_alert==1){
                    $('.preloader').hide();
                    if($("input[name=URSRC_mainradiobutton]:checked").val()=="BASIC ROLE MENU CREATION"){
                        $('#URSRC_lbl_basicrole_err').hide();
                        $('#URSRC_tble_basicroles_chk').show();
                        URSRC_loadmenu_basicrole()
                    }
                    else{
                        $('.preloader').hide();
                        var msg=(URSRC_errorAarray[14].EMC_DATA).toString().replace("[NAME]",$("input[name=URSRC_radio_basicroles1]:checked").val())
                        $('#URSRC_lbl_basicrole_err').text(msg).show();
                        $('#URSRC_tble_basicroles_chk').hide()
                        $('#URSRC_tble_menu').hide();
                        $('#URSRC_tble_folder').hide();
                        $('#URSRC_btn_submitbutton').attr("disabled","disabled").hide()
                    }
                }
                else{
                    if($("input[name=URSRC_mainradiobutton]:checked").val()=="BASIC ROLE MENU CREATION")
                    {
                        $('#URSRC_lbl_basicrole_err').text(URSRC_errorAarray[11].EMC_DATA).show()
                        $('.preloader').hide();
                        $('#URSRC_tble_basicroles_chk').hide()
                        $('#URSRC_tble_menu').hide();
                        $('#URSRC_tble_folder').hide();
                    }
                    else{
                        $('input[name=URSRC_cb_basicroles1]').attr('checked',false);
                        var role=$("input[name=URSRC_radio_basicroles1]:checked").val()
                        role=role.replace("_"," ")
                        $('#URSRC_lbl_basicrole_err').hide()
                        URSRC_loadbasicrole_menus(role)
                    }
                }
            },
            error: function(data){
                show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false);
            }
        });
    });
    //BASIC ROLE CREATION FOR TRUE/FALSE
    function URSRC_loadmenu_basicrole()
    {
        $.ajax({
            type: "POST",
            'url': controller_url+"URSRC_getmenubasic_folder1",
            data:{'radio_value':URSRC_basicradio_value},
            success: function(data){
                var basic_role_menus=JSON.parse(data);
                URSRC_multi_array=basic_role_menus[0];
                $('#URSRC_tble_basicroles_chk').show()
                var menu=[]
                URSRC_tree_view(menu);
            },
            error: function(data){
                show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false);
            }
        });
    }
    var basicmenurolesresult=[];
    //SUCCESS FUNCTION FOR BASIC ROLE MENUS
    function URSRC_loadbasicrole_menus(role)
    {
        $.ajax({
            type:'POST',
            'url':controller_url+"URSRC_loadbasicrole_menu",
            data:{'URSRC_basicradio_value':URSRC_basicradio_value,'role':role},
            success:function(data){
                var basicrole_values=JSON.parse(data);
                URSRC_multi_array=basicrole_values[1];//[0].URSRC_multi_array;
                var URSRC_basicrole_menu=basicrole_values[0].URSRC_basicrole_menu;
                var URSRC_basicrole_profile=basicrole_values[0].URSRC_basicrole_array
                for(var j=0;j<URSRC_basicrole_profile_array.length;j++){
                    for(var i=0;i<URSRC_basicrole_profile.length;i++){
                        if(URSRC_basicrole_profile[i]==URSRC_basicrole_profile_array[j]){
                            var basic_role_value=URSRC_basicrole_profile[i].replace(" ","_")
                            $('#'+basic_role_value).prop("checked",true)
                        }
                    }
                }
                $('#URSRC_tble_basicroles_chk ').show()
                $('#URSRC_tble_basicrolemenusearch').show()
                URSRC_tree_view(URSRC_basicrole_menu);
            },
            error:function(data){
                show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false);
            }
        });
    }
    var submenuids;
    var subsubmenuid;
    //FUNCTION TO SHOW MENU'S
    function URSRC_tree_view(menus){
        $(".preloader").hide();
        $('#URSRC_btn_submitbutton').attr("disabled","disabled");
        $('#URSRC_tble_menu').replaceWith('<table id="URSRC_tble_menu"  ></table>')
        var count=0;
        var URSRC_main_menu=URSRC_multi_array[0]
        var URSRC_sub_menu=URSRC_multi_array[1]
        var URSRC_sub_menu1=URSRC_multi_array[2];
        var URSRC_menu1='<label>MENU<em>*</em></label>'
        $('#URSRC_tble_menu').append(URSRC_menu1);
        var URSRC_menu=''
        for(var i=0;i<URSRC_main_menu.length;i++)
        {
            var URSRC_submenu_table_id="URSRC_tble_submenu"+i;
            var URSRC_menu_button_id="menu"+"_"+i;
            var URSRC_submenu_div_id="sub"+i
            var menu_value=URSRC_main_menu[i].replace(/ /g,"&");
            var id_menu=i+'m'
            var mainmenuid=i;
            URSRC_menu= '<div ><ul style="list-style: none;" ><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input value="+" type="button"  id='+URSRC_menu_button_id+' height="1" width="1" class="exp" /><input type="checkbox" name="menu[]" id='+id_menu+' value='+menu_value+' level="parent" class="tree URSRC_submit_validate Parent"  />' + URSRC_main_menu[i] + '</td></tr>';
            URSRC_menu+='<div id='+URSRC_submenu_div_id+' hidden ><tr><td><table id='+URSRC_submenu_table_id+' class="URSRC_class_submenu"  ></table></tr></div></li></ul></div>';
            $('#URSRC_tble_menu').append(URSRC_menu);
            var URSRC_submenu='';
            for(var j=0;j<URSRC_sub_menu.length;j++)
            {
                if(i==j)
                {
                    var submenulength=URSRC_sub_menu[j].length;
                    for(var k=0;k<URSRC_sub_menu[j].length;k++)
                    {
                        var URSRC_submenu1_table_id="URSRC_tble_submenu1"+k+j;
                        var URSRC_submenu_button_id="sub_menu"+"_"+k+j;
                        var URSRC_submenu1_div_id="sub1"+k+j
                        var sub_menu_value1=URSRC_sub_menu[j][k].replace(/ /g,"&");
                        var sub_menu_values=sub_menu_value1.split("_");
                        var sub_menu_id=sub_menu_values[1]
                        var sub_menu_fp_id=sub_menu_values[2]
                        var fp_id='fp_id'+sub_menu_id
                        sub_menu_values[0]=sub_menu_values[0].replace(/&/g," ");
                        var submenuids="USR_SITE_submenus-"+mainmenuid+'-'+submenulength+'-'+k;//+'-'+sub_menu_id;
                        var idsubmenu=k+j
                        if(URSRC_sub_menu1[count].length!=0)
                        {
                            URSRC_submenu = '<div ><ul style="list-style: none;"><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input value="+" type="button"  id='+URSRC_submenu_button_id+' height="1" width="1" class="exp1" /><input type="checkbox" name="Sub_menu[]" id='+submenuids+' value='+sub_menu_id+'&&'+' level="child" class="tree submenucheck  Child"  />' + sub_menu_values[0] + '</td></tr>';
                        }
                        else
                        {
                            URSRC_submenu = '<div ><ul style="list-style: none;"><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="Sub_menu[]" id='+submenuids+' value='+sub_menu_id+' class="tree submenucheck" level="child" />' + sub_menu_values[0] + '</td><td><input type="hidden" value='+sub_menu_fp_id+' id='+fp_id+'></tr>';
                        }
                        URSRC_submenu+='<div id='+URSRC_submenu1_div_id+'  ><tr><td><table id='+URSRC_submenu1_table_id+' hidden ></table></tr></div></li></ul></div>';
                        $('#'+"URSRC_tble_submenu"+i).append(URSRC_submenu);
                        for(var m1=0;m1<menus.length;m1++){
                            if(sub_menu_id==menus[m1]){
                                $('#'+submenuids).prop("checked", true)
                                $('#'+id_menu).prop("checked", true)
                            }
                        }
                        var URSRC_submenu1='';
                        var subsubmenucount=URSRC_sub_menu1[count].length;
                        for(var m=0;m<URSRC_sub_menu1[count].length;m++)
                        {
                            var sub_menu1_value1=URSRC_sub_menu1[count][m].replace(/ /g,"&");
                            var sub_menu1_values=sub_menu1_value1.split("_");
                            sub_menu1_values[0]=sub_menu1_values[0].replace(/&/g," ")
                            var sub_menu1_id=sub_menu1_values[1];
                            var sub_menu1_fp_id=sub_menu1_values[2]
                            var idsubmenu1=count+m+'s1'
                            var subsubmenuid='USR_SITE_submenuchk-'+mainmenuid+'-'+submenulength+'-'+k+'-'+sub_menu_id+'-'+m+'-'+subsubmenucount;//+'-'+sub_menu1_id;
                            var fp_id='fp_id'+sub_menu1_id
                            URSRC_submenu1 = '<div ><ul style="list-style: none;"><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="Sub_menu1[]" id='+subsubmenuid+' value='+sub_menu1_id+' class="tree subsubmenuchk " level="child1" />' +sub_menu1_values[0] + '</td><td><input type="hidden" value='+sub_menu1_fp_id+' id='+fp_id+'></tr></li></ul></div>';
                            $('#'+"URSRC_tble_submenu1"+k+j).append(URSRC_submenu1);
                            for(var m1=0;m1<menus.length;m1++){
                                if(sub_menu1_id==menus[m1]){
                                    $('#'+subsubmenuid).prop("checked", true)
                                }
                            }
                        }
                        count++;
                    }
                }
            }
        }
        $('#URSRC_btn_submitbutton').show()
    }
    ///////////////////////////
    var check_flag=0;
    $(document).on('change','.submenucheck',function(){
        var URSRC_checkbox_id=$(this).attr("id");
        var URSRC_checkbox_id_split=URSRC_checkbox_id.split('-');
        var count=0;
        for(var g=0;g<URSRC_checkbox_id_split[2];g++)
        {
            var checked1='USR_SITE_submenus-'+URSRC_checkbox_id_split[1]+'-'+URSRC_checkbox_id_split[2]+'-'+g;
            var checked=$('#'+checked1).attr("checked");
            if(checked)
            {
                count++;
            }
        }
        if(count!=0)
        {
            $('#'+URSRC_checkbox_id_split[1]+'m').prop('checked',true);
            check_flag=1;
            URSRC_submit_validate()
        }
        else
        {
            $('#'+URSRC_checkbox_id_split[1]+'m').prop('checked',false);
        }
    });
    $(document).on('click','.subsubmenuchk',function(){
        var URSRC_checkbox_id=$(this).attr("id");
        var URSRC_checkbox_id_idsplit=URSRC_checkbox_id.split('-');
        var count=0;
        for(var i=0;i<URSRC_checkbox_id_idsplit[6];i++)
        {
            var chkboxid=URSRC_checkbox_id_idsplit[0]+'-'+URSRC_checkbox_id_idsplit[1]+'-'+URSRC_checkbox_id_idsplit[2]+'-'+URSRC_checkbox_id_idsplit[3]+'-'+URSRC_checkbox_id_idsplit[4]+'-'+i+'-'+URSRC_checkbox_id_idsplit[6];
            var checked=$('#'+chkboxid).attr("checked");
            if(checked)
            {
                count++;
            }
        }
        if(count!=0)
        {
            $('#USR_SITE_submenus-'+URSRC_checkbox_id_idsplit[1]+'-'+URSRC_checkbox_id_idsplit[2]+'-'+URSRC_checkbox_id_idsplit[3]).prop('checked',true);
        }
        else
        {
            $('#USR_SITE_submenus-'+URSRC_checkbox_id_idsplit[1]+'-'+URSRC_checkbox_id_idsplit[2]+'-'+URSRC_checkbox_id_idsplit[3]).prop('checked',false);
        }
        var submenucount=0;
        for(var j=0;j<URSRC_checkbox_id_idsplit[2];j++)
        {
            var subchkid=URSRC_checkbox_id_idsplit[1]+'-'+URSRC_checkbox_id_idsplit[2]+'-'+j;
            var submenuchecked=$('#USR_SITE_submenus-'+subchkid).attr("checked");
            if(submenuchecked)
            {
                submenucount++;
            }
        }
        if(submenucount!=0)
        {
            $('#'+URSRC_checkbox_id_idsplit[1]+'m').prop('checked',true);
            check_flag=1;
            URSRC_submit_validate()
        }
        else
        {
            $('#'+URSRC_checkbox_id_idsplit[1]+'m').prop('checked',false);
        }
    });

    $(document).on("click",'.exp,.collapse2', function (evt){
        evt.stopPropagation();
        evt.preventDefault();
        evt.stopImmediatePropagation();
        var button_id=$(this).attr("id")
        var btnid=button_id.split("_");
        var menu_btnid=btnid[1]
        if($(this).val()=='+'){
            $(this).val('-');
            if(btnid[0]=='folder'){
                $('#subf'+menu_btnid).toggle("fold",100);
            }
            else{
                $('#sub'+menu_btnid).toggle("fold",100);
            }
        }
        else
        {
            if(btnid[0]=='folder'){
                $('#subf'+menu_btnid).toggle("fold",100);
            }
            else{
                $('#sub'+menu_btnid).toggle("fold",100);
            }
            $(this).replaceWith('<input type="button"   value="+" id='+button_id+'  height="1" width="1" class="exp" />');
        }
    });
    $(document).on("click",'.exp1,.collapse1', function (evt){
        evt.stopPropagation();
        evt.preventDefault();
        evt.stopImmediatePropagation();
        var sub_buttonid=$(this).attr("id")
        var btnid=sub_buttonid.split("_");
        var menu_btnid=btnid[2]
        if($(this).val()=='+'){
            $(this).replaceWith('<input type="button"   value="-" id='+sub_buttonid+'  height="1" width="1" class="collapse1" />');
            $('#URSRC_tble_submenu1'+menu_btnid).toggle("fold",100);
        }
        else
        {
            $('#URSRC_tble_submenu1'+menu_btnid).toggle("fold",100);
            $(this).replaceWith('<input type="button"   value="+" id='+sub_buttonid+'  height="3" width="3" class="exp1" />');
        }
    });
    //CUSTOM ROLE CHANGE FUNCTION
    //FUNCTION TO CHECK CUSTOM ROLE ALREADY EXISTS
    $(document).on('blur','#URSRC_tb_customrole',function(){
        var URSRC_roleidval=$(this).val();
        if(URSRC_roleidval!=''){
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $('.preloader').show();
            $('#URSRC_tble_roles').hide()
            $('#URSRC_tble_menu').hide();
            $('#URSRC_tble_folder').hide();
            $('input:radio[name=basicroles]').attr('checked',false);
            $('#URSRC_btn_submitbutton').hide()
            $('#URSRC_lbl_role_err').hide();
            $.ajax({
                type: "POST",
                'url': controller_url+"URSRC_check_customrole",
                data :{'URSRC_roleidval':URSRC_roleidval},
                success: function(data){
                    $('.preloader').hide();
                    var msgalert=data;
                    if(msgalert==0)
                    {
                        $('#URSRC_tble_roles').show();
                        $('#URSRC_lbl_role_err').hide()
                    }
                    else{
                        var msg=URSRC_errorAarray[3].EMC_DATA.replace('[NAME]',$('#URSRC_tb_customrole').val())
                        $('#URSRC_btn_submitbutton').attr("disabled","disabled")
                        $('#URSRC_lbl_role_err').text(msg).show()
                    }
                },
                error: function(data){
                    show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false);
                }
            });
        }
    });
    //FUNCTION TO CLICK BASIC ROLE
    $(document).on("click",'.URSRC_class_basicroles', function (){
        $('.preloader').show();
        var radio_value=$(this).val();
        $.ajax({
            type:'POST',
            'url':controller_url+"URSRC_getmenu_folder",
            data:{'radio_value':radio_value},
            success:function(data){
                $('.preloader').hide();
                var URSRC_values=JSON.parse(data);
                URSRC_multi_array=URSRC_values[0].URSRC_multi_array;
                URSRC_folder_array=URSRC_values[0].URSRC_folder_array;
                var docflag=URSRC_values[0].docflag;
                var menu=[]
                if(docflag==1){
                    if(URSRC_multi_array[0].length!=0){
                        $('#URSRC_lbl_nodetails_err').hide()
                        URSRC_tree_view(menu);
                        URSRC_folder_view(menu);
                    }
                    else{
                        $(".preloader").hide();
                        var msg=URSRC_errorAarray[14].replace("[NAME]",$("input[name=basicroles]:checked").val())
                        $('#URSRC_lbl_nodetails_err').text(msg).show();
                        $('#URSRC_tble_menu').hide();
                        $('#URSRC_tble_folder').hide();
                        $('#URSRC_btn_submitbutton').hide()
                    }
                }
                else{
                    show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[18].EMC_DATA,"success",false)
                }
            }
        });
    });
    //Function to show folder
    function URSRC_folder_view(file){
        $('#URSRC_tble_folder').replaceWith('<table id="URSRC_tble_folder"  ></table>')
        var URSRC_folder1='<tr><td><label>FOLDER</label></tr>'
        $('#URSRC_tble_folder').append(URSRC_folder1);
        var URSRC_main_folder=URSRC_folder_array[0];

        var URSRC_sub_files=URSRC_folder_array[1]
        var URSRC_folder;
        for (var i = 0; i < URSRC_main_folder.length; i++) {
            var URSRC_main_filename1=URSRC_main_folder[i].split("_");
            var URSRC_main_filename=URSRC_main_filename1[0];
            var URSRC_main_fileid=URSRC_main_filename1[1]
            var URSRC_subfolder_id="URSRC_tble_subfolder"+i;
            var id1="folder"+"_"+i;
            var id2="subf"+i
            if(URSRC_sub_files[i].length!=0){
                URSRC_folder= '<div ><ul style="list-style: none;" ><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input value="+" type="button"  id='+id1+' height="5" width="5" class="exp" /><input type="checkbox" name="menu[]" id='+URSRC_main_fileid+'f'+' value='+URSRC_main_fileid+' class="tree"  />' + URSRC_main_filename + '</td></tr>';
                URSRC_folder+='<div id='+id2+' hidden  ><tr><td><table id='+URSRC_subfolder_id+' class="URSRC_class_submenu"  ></table></tr></div></li></ul></div>';
            }
            else{
                URSRC_folder= '<div ><ul style="list-style: none;" ><li style="list-style: none;" ><tr ><td></td><td>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="menu[]" id='+URSRC_main_fileid+'fol'+' value='+URSRC_main_fileid+"%%folder"+' class="tree"  />' + URSRC_main_filename + '</td></tr>';
                URSRC_folder+='<div id='+id2+' hidden  ><tr><td><table id='+URSRC_subfolder_id+' class="URSRC_class_submenu"  ></table></tr></div></li></ul></div>';
            }
            $('#URSRC_tble_folder').append(URSRC_folder);
            for(var m1=0;m1<file.length;m1++){
                if(URSRC_main_fileid==file[m1]){
                    $('#'+URSRC_main_fileid+'fol').prop("checked", true)
                }
            }
            var URSRC_subfolder='';
            for(var j=0;j<URSRC_sub_files.length;j++)
            {
                if(i==j)
                {
                    for(var k=0;k<URSRC_sub_files[j].length;k++)
                    {
                        var filename1=URSRC_sub_files[j][k].split("&&");
                        var filename=filename1[0]
                        var fileid=filename1[1];
                        URSRC_subfolder = '<div ><ul style="list-style: none;"><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="Sub_menu[]" id='+fileid+'fol'+' value='+fileid+"%%folder"+' class="tree"  />' +filename+ '</td></tr>';
                        $('#'+URSRC_subfolder_id).append(URSRC_subfolder);
                        for(var m1=0;m1<file.length;m1++){
                            if(fileid==file[m1]){
                                $('#'+fileid+'fol').prop("checked", true)
                                $('#1f').prop("checked", true)
                            }
                        }
                    }
                }
            }
        }
        $('#URSRC_tble_folder').show()
        $('#URSRC_btn_submitbutton').show()
    }
    var URSRC_mainmenu_value;

    $(document).on("change",'.tree ', function (){

            var val = $(this).attr("checked");
            URSRC_mainmenu_value = $(this).val()
            $(this).parent().find("input:checkbox").each(function () {

                if (val) {
                    $(this).attr("checked", "checked");
                }
                else {
                    $(this).removeAttr("checked");
                    $(this).parents('ul').each(function () {
                        $(this).prev('input:checkbox').removeAttr("checked");
                    });
                }
            });
            URSRC_submit_validate();
    });

    function URSRC_submit_validate(){
        var submenu_values=[];
        $('input[name="Sub_menu[]"]:checked').each(function() {
            submenu_values.push($(this).val())
        });
        var submenu1_values=[];
        $('input[name="Sub_menu1[]"]:checked').each(function() {
            submenu1_values.push($(this).val())
        });
        var menu_checked=$('input[name="menu[]"]:checked' ).val()
        var menu_values=[];
        $('input[name="menu[]"]:checked').each(function(){
            menu_values.push($(this).val())
        });
        var basicrole_profile_checked=$('input[name="URSRC_cb_basicroles1[]"]:checked').length;
        var URSRC_radio_button_select_value=$("input[name=URSRC_mainradiobutton]:checked").val();
        if((URSRC_radio_button_select_value=="ROLE CREATION")||(URSRC_radio_button_select_value=="ROLE SEARCH UPDATE")){
            var Submenu1_checked=$('input[name="Sub_menu1[]"]:checked').length;
            var Submenu_checked=$('input[name="Sub_menu[]"]:checked').length;
            if(Submenu1_checked>0||Submenu_checked>0){
                $('#URSRC_btn_submitbutton').removeAttr('disabled')
            }
            else
            {
                $('#URSRC_btn_submitbutton').attr("disabled","disabled");
            }
            for(var a=0;a<menu_values.length;a++){
                for(var i=0;i<submenu_values.length;i++){
                    if(menu_values[a]=="REPORT"|| URSRC_mainmenu_value=="REPORT"||URSRC_mainmenu_value==3 ){
                        if(submenu_values[i]==3 )
                        {
                            var URSRC_report_id=$('#fp_id3').val();
                            var URSRC_report_id=URSRC_report_id.split(',')

                            for(var k=0;k<URSRC_report_id.length;k++){
                                $('#'+URSRC_report_id[k]+'fol').prop("checked", true);
                            }
                            break;
                        }
                        else{
                            var URSRC_report_id=$('#fp_id3').val();
                            var URSRC_report_id=URSRC_report_id.split(',')

                            for(var k=0;k<URSRC_report_id.length;k++){
                                $('#'+URSRC_report_id[k]+'fol').prop("checked", false);
                            }
                        }
                        if(($('#1fol').is(":checked")==true)){
                            $('#1f').prop("checked", true);
                        }
                        else{
                            $('#1f').prop("checked", false);
                        }
                    }
                }
            }
            for(var a=0;a<menu_values.length;a++){
                for(var i=0;i<submenu_values.length;i++){
                    if(menu_values[a]=="CONFIGURATION"|| URSRC_mainmenu_value=="CONFIGURATION"|| URSRC_mainmenu_value==2){
                        if( submenu_values[i]==2)
                        {

                            var URSRC_report_id=$('#fp_id2').val();
                            var URSRC_report_id=URSRC_report_id.split(',')
                            for(var k=0;k<URSRC_report_id.length;k++){
                                $('#'+URSRC_report_id[k]+'fol').prop("checked", true);
                            }
                            break;
                        }
                        else{

                            var URSRC_report_id=$('#fp_id2').val();
                            var URSRC_report_id=URSRC_report_id.split(',')
                            for(var k=0;k<URSRC_report_id.length;k++){
                                $('#'+URSRC_report_id[k]+'fol').prop("checked", false);
                            }
                        }
                        if(($('#1fol').is(":checked")==true)){
                            $('#1f').prop("checked", true);
                        }
                        else{
                            $('#1f').prop("checked", false);
                        }
                    }
                }
            }
            if(submenu_values.length==0){
                var URSRC_report_id=$('#fp_id3').val();
                var URSRC_report_id=URSRC_report_id.split(',')
                for(var k=0;k<URSRC_report_id.length;k++){
                    $('#'+URSRC_report_id[k]+'fol').prop("checked", false);
                }
            }
            //FOR CUSTOMER
            var URSRC_customer_file_id1;
            for(var a=0;a<menu_values.length;a++){
                if((menu_values[a]=="CUSTOMER")||(URSRC_mainmenu_value=="CUSTOMER"||URSRC_mainmenu_value==11||URSRC_mainmenu_value==12||URSRC_mainmenu_value==13||URSRC_mainmenu_value==14||URSRC_mainmenu_value==19)){
                    var flag=0
                    var flag1=0;
                    for(var h=0;h<submenu1_values.length;h++){
                        if((submenu1_values[h]==11)||(submenu1_values[h]==12)||(submenu1_values[h]==13)||(submenu1_values[h]==14)||(submenu1_values[h]==19)){
                            flag=1;
                            flag1=1;
                            if((submenu1_values[h]==11))
                                var URSRC_customer_file_id=$('#fp_id11').val();
                            if((submenu1_values[h]==12))
                                var URSRC_customer_file_id=$('#fp_id12').val();
                            if((submenu1_values[h]==13))
                                var URSRC_customer_file_id=$('#fp_id13').val();
                            if((submenu1_values[h]==14))
                                var URSRC_customer_file_id=$('#fp_id14').val();
                            if((submenu1_values[h]==19))
                                var URSRC_customer_file_id=$('#fp_id19').val();
                            var URSRC_customer_file_id1=URSRC_customer_file_id.split(',')
                            var  URSRC_customer_file_id1_length=URSRC_customer_file_id1.length
                            for(var i=0;i<URSRC_customer_file_id1.length;i++){
                                $('#'+URSRC_customer_file_id1[i]+'fol').prop("checked", true);
                            }
                        }
                        else{
                            if(submenu1_values[h]!=12)
                                var URSRC_customer_file_id=$('#fp_id12').val();
                            if((submenu1_values[h]!=13))
                                var URSRC_customer_file_id=$('#fp_id13').val();
                            if((submenu1_values[h]!=14))
                                var URSRC_customer_file_id=$('#fp_id14').val();
                            var URSRC_customer_file_id1=URSRC_customer_file_id.split(',')
                            var URSRC_customer_file_id1_length=URSRC_customer_file_id1.length
                            if(flag==0 ){
                                for(var i=0;i<URSRC_customer_file_id1.length;i++){
                                    $('#'+URSRC_customer_file_id1[i]+'fol').prop("checked", false);
                                }
                            }
                            if(flag1==0 ){
                                for(var i=0;i<URSRC_customer_file_id1.length;i++){
                                    $('#'+URSRC_customer_file_id1[i]+'fol').prop("checked", false);
                                }
                            }
                        }
                        if(($('#2fol').is(":checked")==true)||($('#3fol').is(":checked")==true)){
                            $('#1f').prop("checked", true);
                        }
                        else{
                            $('#1f').prop("checked", false);
                        }
                    }
                }
            }
            if(submenu1_values.length==0){
                var URSRC_customer_file_id=$('#fp_id14').val();
                var URSRC_customer_file_id1=URSRC_customer_file_id.split(',')
                var URSRC_customer_file_id1_length=URSRC_customer_file_id1.length
                for(var i=0;i<URSRC_customer_file_id1.length;i++){
                    $('#'+URSRC_customer_file_id1[i]+'fol').prop("checked", false);
                }
                if(($('#2fol').is(":checked")==true)||($('#3fol').is(":checked")==true)){
                    $('#1f').prop("checked", true);
                }
                else{
                    $('#1f').prop("checked", false);
                }

                var URSRC_finance_file_id=$('#fp_id30').val();
                var URSRC_finance_file_id=URSRC_finance_file_id.split(',')
                for(var i=0;i<URSRC_finance_file_id.length;i++){
                    $('#'+URSRC_finance_file_id[i]+'fol').prop("checked", false);
                }
                var URSRC_finance_file_id=$('#fp_id36').val();
                var URSRC_finance_file_id=URSRC_finance_file_id.split(',')
                for(var i=0;i<URSRC_finance_file_id.length;i++){
                    $('#'+URSRC_finance_file_id[i]+'fol').prop("checked", false);
                }
                var URSRC_finance_file_id=$('#fp_id27').val();
                var URSRC_finance_file_id=URSRC_finance_file_id.split(',')
                for(var i=0;i<URSRC_finance_file_id.length;i++){
                    $('#'+URSRC_finance_file_id[i]+'fol').prop("checked", false);
                }
            }
            //    FINANCE
            for(var a=0;a<menu_values.length;a++){
                if(menu_values[a]=="FINANCE"||(URSRC_mainmenu_value=="FINANCE")||URSRC_mainmenu_value==36||URSRC_mainmenu_value==30||URSRC_mainmenu_value==35){
                    var fin_flag=0
                    var fin_flag1=0
                    var fin_flag2=0
                    for(var h=0;h<submenu1_values.length;h++){
                        if((submenu1_values[h]==36)){
                            fin_flag=1
                            var URSRC_finance_file_id=$('#fp_id36').val();
                            var URSRC_finance_file_id=URSRC_finance_file_id.split(',')
                            for(var i=0;i<URSRC_finance_file_id.length;i++){
                                $('#'+URSRC_finance_file_id[i]+'fol').prop("checked", true);
                            }
                        }
                        else{
                            if(fin_flag==0){
                                var URSRC_finance_file_id=$('#fp_id36').val();
                                var URSRC_finance_file_id=URSRC_finance_file_id.split(',')
                                for(var i=0;i<URSRC_finance_file_id.length;i++){
                                    $('#'+URSRC_finance_file_id[i]+'fol').prop("checked", false);
                                }
                            }
                        }
                        if((submenu1_values[h]==30)){
                            fin_flag1=1
                            var URSRC_finance_file_id=$('#fp_id30').val();
                            var URSRC_finance_file_id=URSRC_finance_file_id.split(',')
                            for(var i=0;i<URSRC_finance_file_id.length;i++){
                                $('#'+URSRC_finance_file_id[i]+'fol').prop("checked", true);
                            }
                        }
                        else{
                            if(fin_flag1==0){
                                var URSRC_finance_file_id=$('#fp_id30').val();
                                var URSRC_finance_file_id=URSRC_finance_file_id.split(',')
                                for(var i=0;i<URSRC_finance_file_id.length;i++){
                                    $('#'+URSRC_finance_file_id[i]+'fol').prop("checked", false);
                                }
                            }
                        }
                        if((submenu1_values[h]==26)||(submenu1_values[h]==27))
                        {
                            fin_flag2=1
                            if((submenu1_values[h]==26))
                                var URSRC_finance_file_id=$('#fp_id26').val();
                            if((submenu1_values[h]==27))
                                var URSRC_finance_file_id=$('#fp_id27').val();
                            var URSRC_finance_file_id=URSRC_finance_file_id.split(',')
                            for(var i=0;i<URSRC_finance_file_id.length;i++){
                                $('#'+URSRC_finance_file_id[i]+'fol').prop("checked", true);
                            }
                        }
                        else
                        {
                            if((submenu1_values[h]!=26))
                                var URSRC_finance_file_id=$('#fp_id26').val();
                            if((submenu1_values[h]!=27))
                                var URSRC_finance_file_id=$('#fp_id27').val();
                            var URSRC_finance_file_id=URSRC_finance_file_id.split(',');
                            if(fin_flag2==0){
                                for(var i=0;i<URSRC_finance_file_id.length;i++){
                                    $('#'+URSRC_finance_file_id[i]+'fol').prop("checked", false);
                                }
                            }
                        }
                        if(($('#1fol').is(":checked")==true)){
                            $('#1f').prop("checked", true);
                        }
                        else{
                            $('#1f').prop("checked", false);
                        }
                        if(($('#2fol').is(":checked")==true)||($('#3fol').is(":checked")==true)){
                            $('#1f').prop("checked", true);
                        }
                    }
                }
            }
            var Submenu1_checked=$('input[name="Sub_menu1[]"]:checked').length
            var Submenu_checked=$('input[name="Sub_menu[]"]:checked').length
            if(Submenu1_checked>0||Submenu_checked>0){
                $('#URSRC_btn_submitbutton').removeAttr('disabled')
            }
            else
            {
                $('#URSRC_btn_submitbutton').attr("disabled","disabled");
            }
        }
        else{
            var Submenu1_checked=$('input[name="Sub_menu1[]"]:checked').length
            var Submenu_checked=$('input[name="Sub_menu[]"]:checked').length
            if((Submenu1_checked>0)&&(basicrole_profile_checked>0)||(Submenu_checked>0)&&(basicrole_profile_checked>0)){
                $('#URSRC_btn_submitbutton').removeAttr('disabled')
            }
            else
            {
                $('#URSRC_btn_submitbutton').attr("disabled","disabled");
            }
        }
    }
    //Basic Role/Search&update/Role Creation and Update  button click
    $(document).on('click','#URSRC_btn_submitbutton',function(){
        var  newPos= adjustPosition($(this).position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        var URSRC_radio_button_select_value=$("input[name=URSRC_mainradiobutton]:checked").val();
        $.ajax({
            type:'POST',
            'url':controller_url+"URSRC_role_creation_save",
            data:$('#URSRC_form_user_rights').serialize(),
            'success':function(data){
                var URSRC_chkflag=JSON.parse(data);
                var success_flag=URSRC_chkflag[0];
                var docflag=URSRC_chkflag[1];
                $(".preloader").hide();
                var URSRC_radio_button_select_value=$("input[name=URSRC_mainradiobutton]:checked").val();
                if(URSRC_radio_button_select_value=="BASIC ROLE MENU CREATION"){
                    $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
                    $('input:radio[name=URSRC_cb_basicroles1]').attr('checked',false);
                    $('#URSRC_tble_menu').hide();
                    $('#URSRC_tble_folder').hide();
                    $('#URSRC_btn_submitbutton').hide();
                    $('#URSRC_tble_basicroles').hide();
                    $('#URSRC_tble_basicroles_chk').hide();
                    $('input[name=URSRC_mainradiobutton]:checked').attr('checked',false);
                    $('#URSRC_lbl_header').hide();
                    if(URSRC_chkflag==1){
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[12].EMC_DATA,"success",false)
                    }
                    else{
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[16].EMC_DATA,"success",false)
                    }
                }
                else if(URSRC_radio_button_select_value=="BASIC ROLE MENU SEARCH UPDATE"){
                    $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
                    $('input:radio[name=URSRC_cb_basicroles1]').attr('checked',false);
                    $('#URSRC_tble_basicroles_chk').hide();
                    $('#URSRC_tble_menu').hide();
                    $('#URSRC_tble_folder').hide();
                    $('#URSRC_btn_submitbutton').hide();
                    if(URSRC_chkflag==1){
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[13].EMC_DATA,"success",false)
                    }
                    else{
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[16].EMC_DATA,"success",false)
                    }
                }
                else if(URSRC_radio_button_select_value=="ROLE CREATION"){
                    $('#URSRC_tble_menu').hide();
                    $('#URSRC_tble_folder').hide();
                    $('#URSRC_tble_roles').hide();
                    $('#URSRC_btn_submitbutton').hide();
                    $('#URSRC_tble_role').hide();
                    $('#URSRC_tb_customrole').val("");
                    $('input[name=URSRC_mainradiobutton]:checked').attr('checked',false);
                    $('#URSRC_lbl_header').hide();
                    if(URSRC_chkflag==1){
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[4].EMC_DATA,"success",false)
                    }
                    else{
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[16].EMC_DATA,"success",false)
                    }
                }
                else if(URSRC_radio_button_select_value=="ROLE SEARCH UPDATE"){
                    if(success_flag==1 && (docflag==1||docflag=='')){
                        $('#URSRC_tble_menu').hide();
                        $('#URSRC_tble_folder').hide();
                            $('#URSRC_rolesearch_roles').empty().hide()
                        $('#URSRC_rolesearch_roles tr').remove()
                        $('#URSRC_tble_rolecreation').hide()
                        $('#URSRC_btn_submitbutton').hide();
                        $('#URSRC_lb_selectrole').prop('selectedIndex',0);
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[7].EMC_DATA,"success",false)
                    }
                    else if(success_flag==1 && docflag==0){
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[18].EMC_DATA,"success",false)
                    }
                }
            },
            error:function(data){
                show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false)
            }
        });
    });
//    function URSRC_clear(URSRC_chkflag){
//        if(URSRC_chkflag.match("SCRIPT EXCEPTION:"))
//        {
//            $(".preloader").hide();
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_chkflag,position:{top:150,left:500}}});
//        }
//        else if(URSRC_chkflag==0){
//            $(".preloader").hide();
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_errorAarray[16],position:{top:150,left:500}}})
//        }
//        else
//        {
//            var URSRC_radio_button_select_value=$("input[name=URSRC_mainradiobutton]:checked").val();
//            if(URSRC_radio_button_select_value=="BASIC ROLE MENU CREATION"){
//                $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
//                $('input:radio[name=URSRC_cb_basicroles1]').attr('checked',false);
//                $('#URSRC_tble_menu').hide();
//                $('#URSRC_tble_folder').hide();
//                $('#URSRC_btn_submitbutton').hide();
//                $('#URSRC_tble_basicroles').hide();
//                $('#URSRC_tble_basicroles_chk').hide();
//                $('input[name=URSRC_mainradiobutton]:checked').attr('checked',false);
//                $('#URSRC_lbl_header').hide();
//                if(URSRC_chkflag==1){
//                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_errorAarray[12],position:{top:150,left:500}}})
//                }
//
//            }
//            else if(URSRC_radio_button_select_value=="BASIC ROLE MENU SEARCH UPDATE"){
//                $('input:radio[name=URSRC_radio_basicroles1]').attr('checked',false);
//                $('input:radio[name=URSRC_cb_basicroles1]').attr('checked',false);
//                $('#URSRC_tble_basicroles_chk').hide();
//                $('#URSRC_tble_menu').hide();
//                $('#URSRC_tble_folder').hide();
//                $('#URSRC_btn_submitbutton').hide();
//                if(URSRC_chkflag==1){
//                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_errorAarray[13],position:{top:150,left:500}}});
//                }
//            }
//            else if(URSRC_radio_button_select_value=="ROLE CREATION"){
//                $('#URSRC_tble_menu').hide();
//                $('#URSRC_tble_folder').hide();
//                $('#URSRC_tble_roles').hide();
//                $('#URSRC_btn_submitbutton').hide();
//                $('#URSRC_tble_role').hide();
//                $('#URSRC_tb_customrole').val("");
//                $('input[name=URSRC_mainradiobutton]:checked').attr('checked',false);
//                $('#URSRC_lbl_header').hide();
//                if(URSRC_chkflag==1){
//                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_errorAarray[4],position:{top:150,left:500}}});
//                }
//            }
//            else if(URSRC_radio_button_select_value=="ROLE SEARCH UPDATE"){
//                $('#URSRC_tble_menu').hide();
//                $('#URSRC_tble_folder').hide();
//                $('#URSRC_rolesearch_roles tr').remove()
//                $('#URSRC_tble_rolecreation').hide()
//                $('#URSRC_btn_submitbutton').hide();
//                $('#URSRC_lb_selectrole').prop('selectedIndex',0);
//                if(URSRC_chkflag==1){
//                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_errorAarray[7],position:{top:150,left:500}}});
//                }
//            }
//            else if(URSRC_radio_button_select_value=="LOGIN CREATION"){
//                if(URSRC_chkflag==1){
//                    $('#URSRC_tble_login').hide();
//                    $('#URSRC_tble_rolesearch').hide();
//                    $('#URSRC_tb_joindate').val("");
//                    var name=$('#URSRC_tb_loginid').val();
//                    var msg=URSRC_errorAarray[5].replace("[NAME]",name)
//                    var finalmsg=msg.replace("[NAME]",name)
//                    $('input[name=URSRC_mainradiobutton]:checked').attr('checked',false);
//                    $('#URSRC_lbl_header').hide();
//                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:finalmsg,position:{top:150,left:500}}});
//                    $('#URSRC_tb_loginid').val("");
//                    $('#URSRC_tb_loginid').prop("size","20");
//                }
//            }
//            else if(URSRC_radio_button_select_value=="LOGIN SEARCH UPDATE"){
//                var name=$('#URSRC_tb_loginid').val();
//                $('#URSRC_tb_joindate').hide();
//                $('#URSRC_lbl_joindate').hide()
//                $('#URSRC_tble_rolecreation').hide();
//                $('#URSRC_lb_selectloginid').prop('selectedIndex',0);
//                $('#URSRC_btn_login_submitbutton').hide()
//                var msg=URSRC_errorAarray[6].replace("[NAME]",name)
//                if(URSRC_chkflag==1){
//                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:msg,position:{top:150,left:500}}});
//                }
//            }
//            $(".preloader").hide();
//        }
//    }
//    function URSRC_error(err){
//        $(".preloader").hide();
//        if(err=="ScriptError: Failed to establish a database connection. Check connection string, username and password.")
//        {
//            err="DB USERNAME/PWD WRONG, PLZ CHK UR CONFIG FILE FOR THE CREDENTIALS."
//            $('#URSRC_form_user_rights').replaceWith('<center><label class="dberrormsg">'+err+'</label></center>');
//        }
//        else if((err=='ReferenceError: "Calendar" is not defined.')||(err=='ScriptError: Access Not Configured. Please use Google Developers Console to activate the API for your project.')){
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_errorAarray[17],position:{top:150,left:500}}});
//        }
//        else if(err=='ScriptError: No item with the given ID could be found, or you do not have permission to access it.'){
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_errorAarray[18],position:{top:150,left:500}}});
//        }
//        else if((err=='ScriptError: Forbidden')||(err=='ScriptError: You do not have permission to perform that action.')){
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_errorAarray[20],position:{top:150,left:500}}});
//        }
//        else if((err=='ScriptError: Not Found')||(err=='Not Found')){
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URSRC_errorAarray[19],position:{top:150,left:500}}});
//        }
//        else{
//            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:err,position:{top:150,left:500}}});
//        }
//    }
    $('#URSRC_tb_loginid').blur(function(){
        var  newPos= adjustPosition($(this).position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        var URSRC_login_id=$(this).val();
        var atpos=URSRC_login_id.indexOf("@");
        var dotpos=URSRC_login_id.lastIndexOf(".");
        if(URSRC_login_id.length>0)
        {
            if ((atpos<1 || dotpos<atpos+2 || dotpos+2>=URSRC_login_id.length)||(/^[@a-zA-Z0-9-\\.]*$/.test(URSRC_login_id) == false))
            {
                $(".preloader").hide();
                $('#URSRC_tble_rolecreation').empty().hide();
                $('#URSRC_tble_rolecreation').hide()
                $('#URSRC_lbl_joindate').hide();
                $('#URSRC_tb_joindate').val("").hide();
                $('#URSRC_btn_login_submitbutton').hide().attr("disabled","disabled");
                $("#URSRC_lbl_email_err").text(URSRC_errorAarray[0].EMC_DATA).show()
                $('#URSRC_tb_loginid').addClass("invalid")
            }
            else
            {
                $("#URSRC_lbl_email_err").hide();
                $('#URSRC_tb_loginid').removeClass("invalid")
                $('#URSRC_tb_loginid').val($('#URSRC_tb_loginid').val().toLowerCase())
                URSRC_login_id=$(this).val();
                if((URSRC_login_id.substring(URSRC_login_id.indexOf("@") + 1) == "ssomens.com")||(URSRC_login_id.substring(URSRC_login_id.indexOf("@") + 1) == "gmail.com")||(URSRC_login_id.substring(URSRC_login_id.indexOf("@") + 1) == "expatsint.com")){
                    $.ajax({
                        type: "POST",
                        'url': controller_url+"URSRC_check_loginid",
                        data :{'URSRC_login_id':URSRC_login_id},
                        success:function(data){
                            $(".preloader").hide();
                            var msgalert=JSON.parse(data);
                            var LoginId_exist=msgalert[0];
                            var URSRC_role_array=msgalert[1];
                            if(LoginId_exist==0){
                                $('#URSRC_tble_rolecreation').empty();
                                var URSRC_roles=''
                                for (var i = 0; i < URSRC_role_array.length; i++){
                                    var value=URSRC_role_array[i].replace(" ","_")
                                    var id1="URSRC_role_array"+i;
                                    if(i==0){
                                        var URSRC_roles='<div class="form-group" style="padding-left: 10px"><div class="radio"><label class=" col-sm-2 " style="white-space: nowrap!important;">SELECT ROLE ACCESS<em>*</em></label>'
                                        URSRC_roles+= '<div class=" col-sm-offset-2 col-sm-10"><label  style="white-space: nowrap!important;"><input type="radio" name="roles1" id='+id1+' value='+value+' class="URSRC_class_role1 tree login_submitvalidate"   />' + URSRC_role_array[i] + '</lable></div>';
                                    }
                                    else{
                                        URSRC_roles+= '<div class="col-sm-offset-2 col-sm-10 "><label  style="white-space: nowrap!important;"><input type="radio" name="roles1" id='+id1+' value='+value+' class="URSRC_class_role1 tree login_submitvalidate"   />' + URSRC_role_array[i] + '</lable></div>';
                                    }
                                }
                                URSRC_roles+='</div></div>';
                                $('#URSRC_tble_rolecreation').append(URSRC_roles);

                                $('#URSRC_lbl_login_role').show();
                                $('#URSRC_tble_rolecreation').show();
                                $('#URSRC_lbl_joindate').hide();
                                $('#URSRC_tb_joindate').val("").hide();
                                $('#URSRC_btn_login_submitbutton').hide().attr("disabled","disabled");
                            }
                            else{
                                $('#URSRC_lbl_email_err').text(URSRC_errorAarray[2].EMC_DATA).show()
                                $('#URSRC_lbl_login_role').hide();
                                $('#URSRC_tble_rolecreation').hide();
                            }

                        },
                        error: function(data){
                            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:data,position:{top:150,left:500}}});
                        }
                    });
                }
                else{
                    $(".preloader").hide();
                    $('#URSRC_tble_rolecreation').empty().hide();
                    $('#URSRC_tble_rolecreation').hide()
                    $('#URSRC_lbl_joindate').hide();
                    $('#URSRC_tb_joindate').val("").hide();
                    $('#URSRC_btn_login_submitbutton').hide().attr("disabled","disabled");
                    $("#URSRC_lbl_email_err").text(URSRC_errorAarray[15].EMC_DATA).show()
                    $('#URSRC_tb_loginid').addClass("invalid");
                }
            }
        }
        else{
            $(".preloader").hide();
            $('#URSRC_tble_rolecreation').empty().hide();
            $('#URSRC_lbl_joindate').hide();
            $('#URSRC_tb_joindate').val("").hide();
            $('#URSRC_btn_login_submitbutton').hide().attr("disabled","disabled");
            $("#URSRC_lbl_email_err").hide();
            $('#URSRC_tb_loginid').removeClass("invalid")
        }
    });
    $(document).on("click",'.URSRC_class_role1', function (){
        $('#URSRC_lbl_joindate').show();
        $('#URSRC_tb_joindate').show();
        $('#URSRC_btn_login_submitbutton').val("CREATE").show();
    });
    //Login Submit button validation
    $(document).on("change",'.login_submitvalidate ', function (){
        var URSRC_radio_button_select_value=$("input[name=URSRC_mainradiobutton]:checked").val();
        if(URSRC_radio_button_select_value=="LOGIN CREATION"){
            var login_id=$('#URSRC_tb_loginid').val();
            var join_date=$('#URSRC_tb_joindate').val();
            if((login_id!="")&&(join_date!="")){
                $("#URSRC_btn_login_submitbutton").removeAttr("disabled")
            }
            else{
                $('#URSRC_btn_login_submitbutton').attr("disabled","disabled");
            }
        }
        else{
            var URSRC_select_loginid=$('#URSRC_lb_selectloginid').val();
            var URSRC_join_date=$('#URSRC_tb_joindate').val();
            var URSRC_role_select=$("input[name=roles1]").is(":checked");
            if((URSRC_select_loginid!="SELECT")&&(URSRC_join_date!="")&&(URSRC_role_select==true)){
                $("#URSRC_btn_login_submitbutton").removeAttr("disabled")
            }
            else{
                $('#URSRC_btn_login_submitbutton').attr("disabled","disabled");
            }
        }
    });
    //LOGIN ID CHANGE FUNCTION
    var old_role;
    $('#URSRC_lb_selectloginid').change(function(){
        var URSRC_login_id=$(this).val();
        if(URSRC_login_id!="SELECT"){
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            $('#URSRC_tble_rolecreation').hide();
            $('#URSRC_tble_rolecreation').empty().hide();
            $('#URSRC_lbl_joindate').hide();
            $('#URSRC_tb_joindate').hide().val("");
            $('#URSRC_lbl_login_role').hide()
            $('#URSRC_btn_login_submitbutton').attr("disabled","disabled");
            $.ajax({
                type: "POST",
                'url': controller_url+"URSRC_get_logindetails",
                data :{'URSRC_login_id':URSRC_login_id},
                success:function(data){
                    var details=JSON.parse(data);
                    $(".preloader").hide();
                    $('#URSRC_tb_loginid').hide();
                    var role=details[0][1]
                    var join_date=details[0][0]
                    var URSRC_role1=details[1];
                    old_role=URSRC_role1;
                    $('#URSRC_tble_rolecreation').show();
                    $('#URSRC_tble_login').show();
                    $('#URSRC_tble_rolecreation').empty().hide();
                    for (var i = 0; i < URSRC_role1.length; i++) {
                        var value=URSRC_role1[i].replace(" ","_");
                        var id1="URSRC_role_array"+i;
                        if(URSRC_role1[i]==role){
                            if(i==0)
                            {
                                var URSRC_roles='<label class=" control-label   col-sm-2" style="white-space: nowrap!important;">SELECT ROLE ACCESS</label>';
                                URSRC_roles+= '<div class="col-sm-offset-2 col-sm-10"><label  style="white-space: nowrap!important;"><input type="radio" name="roles1" id='+id1+' value='+value+' class="login_submitvalidate" checked  />' + URSRC_role1[i] + '</lable></div>';
                                $('#URSRC_tble_rolecreation').append(URSRC_roles);
                            }
                            else
                            {
                                URSRC_roles= '<div class="col-sm-offset-2 col-sm-10"><label  style="white-space: nowrap!important;"><input type="radio" name="roles1" id='+id1+' value='+value+' class="login_submitvalidate" checked  />' + URSRC_role1[i] + '</lable></div>';
                                $('#URSRC_tble_rolecreation').append(URSRC_roles);
                            }
                        }
                        else
                        {
                            if(i==0)
                            {
                                var URSRC_roles='<label class=" control-label col-sm-2" style="white-space: nowrap!important;">SELECT ROLE ACCESS<em>*</em></label>';
                                URSRC_roles+= '<div class="col-sm-offset-2 col-sm-10"><label  style="white-space: nowrap!important;"><input type="radio" name="roles1" id='+id1+' value='+value+' class="login_submitvalidate"   />' + URSRC_role1[i] + '</lable></div>';
                                $('#URSRC_tble_rolecreation').append(URSRC_roles);
                            }
                            else
                            {
                                URSRC_roles = '<div class="col-sm-offset-2 col-sm-10"><label  style="white-space: nowrap!important;"><input type="radio" name="roles1" id='+id1+' value='+value+' class="login_submitvalidate"   />' + URSRC_role1[i] + '</lable></div>';
                                $('#URSRC_tble_rolecreation').append(URSRC_roles);
                            }
                        }
                    }
                    $('#URSRC_lbl_login_role').show();
                    $('#URSRC_tble_rolecreation').show();
                    $('#URSRC_lbl_joindate').show();
                    $('#URSRC_tb_joindate').val(join_date).show();
                    $('#URSRC_btn_login_submitbutton').val("UPDATE").show()
                },
                error: function(data){
                    show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false)
                }
            });
        }
        else{
            $('#URSRC_tble_rolecreation').hide();
            $('#URSRC_tble_rolecreation').empty().hide();
            $('#URSRC_lbl_joindate').hide();
            $('#URSRC_tb_joindate').hide().val("");
            $('#URSRC_lbl_login_role').hide()
            $('#URSRC_btn_login_submitbutton').attr("disabled","disabled");
        }
    });
    //LOGIN CREATE/UPDATE BUTTON CLICK
    $('#URSRC_btn_login_submitbutton').click(function(){
        var  newPos= adjustPosition($(this).position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        var value=$("input[name=URSRC_mainradiobutton]:checked").val();
        var formelement=$('#URSRC_form_user_rights').serialize();
        $.ajax({
            type:'POST',
            'url':controller_url+"URSRC_login_creation_save",
            data:formelement+"&URSRC_old_rolename="+old_role,
            success:function(data){
                var URSRC_chkflag=JSON.parse(data);
                var success_flag=URSRC_chkflag[0];
                var doc_flag=URSRC_chkflag[1];
                var cal_flag=URSRC_chkflag[2];
                $(".preloader").hide();
                if(value=='LOGIN CREATION'){
                    if(success_flag==1 && doc_flag==1 && cal_flag==1 ){
                           var name=$('#URSRC_tb_loginid').val();
                           var msg=URSRC_errorAarray[5].EMC_DATA.replace("[NAME]",name)
                           var finalmsg=msg.replace("[NAME]",name)
                           $('input[name=URSRC_mainradiobutton]:checked').attr('checked',false);
                           $('#URSRC_lbl_header').hide();
                           show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",finalmsg,"success",false)
                           $('#URSRC_tb_loginid').val("");
                           $('#URSRC_tb_loginid').prop("size","20");
                           $('#URSRC_tble_login').hide();
                           $('#URSRC_tble_rolesearch').hide();
                           $('#URSRC_tb_joindate').val("");
                    }
                    else if(success_flag==1 && doc_flag==0){
                           show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[18].EMC_DATA,"success",false)
                    }
                    else if(success_flag==1 && doc_flag==1 && cal_flag==0){
                           show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[20].EMC_DATA,"success",false)
                    }
                }
                else if(value=="LOGIN SEARCH UPDATE"){
                    if(success_flag==1 && doc_flag==1  ){
                        var name=$('#URSRC_tb_loginid').val();
                        $('#URSRC_tb_joindate').hide();
                        $('#URSRC_lbl_joindate').hide()
                        $('#URSRC_tble_rolecreation').hide();
                        $('#URSRC_lb_selectloginid').prop('selectedIndex',0);
                        $('#URSRC_btn_login_submitbutton').hide()
                        var msg=URSRC_errorAarray[6].EMC_DATA.replace("[NAME]",name)
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",msg,"success",false)
                    }
                    else if(success_flag==1 && doc_flag==0){
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[18].EMC_DATA,"success",false)
                    }
                }
            },
            error:function(data){
                show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",JSON.stringify(data),"error",false)
            }
        });
    });
    //ROLE CHANGE FUNCTION FOR ROLE SEARCH AND UPDATE
    $('#URSRC_lb_selectrole').change(function(){
        if($(this).val()!='SELECT'){
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            $.ajax({
                type:'POST',
                'url':controller_url+"URSRC_get_roledetails",
                data:{'role':$(this).val()},
                success:function(data){
                    var roledetails=JSON.parse(data);
                    $(".preloader").hide();
                    var URSRC_basic_role_menu_folder=roledetails[3]
                    URSRC_multi_array=URSRC_basic_role_menu_folder[0].URSRC_multi_array;
                    URSRC_folder_array=URSRC_basic_role_menu_folder[0].URSRC_folder_array;
                    var docflag=URSRC_basic_role_menu_folder[0].docflag;
                    var URSRC_basic_role=roledetails[0]
                    var URSRC_menu_details=roledetails[1];
                    var URSRC_file_details=roledetails[2];
                    if(docflag==1){
                         var URSRC_role_radio='<div class="form-group"><div class="radio"><label class="col-sm-3" style="white-space: nowrap!important;">SELECT A ROLE ACCESS</label>'
                         $('#URSRC_rolesearch_roles').html(URSRC_role_radio);
                         for (var i = 0; i < URSRC_userrigths_array.length; i++) {
                                var id1="URSRC_userrigths_array"+i;
                                var value=URSRC_userrigths_array[i].replace(" ","_")
                                if(URSRC_userrigths_array[i]==URSRC_basic_role){
                                    URSRC_role_radio+='<div class=" col-sm-offset-2 col-sm-10"><label  style="white-space: nowrap!important;"><input type="radio" name="basicroles" id='+id1+' value='+value+' class="URSRC_class_basicroles"  checked  />' + URSRC_userrigths_array[i] + '</lable></div>';
                                }
                                else{
                                  URSRC_role_radio+='<div class=" col-sm-offset-2 col-sm-10"><label  style="white-space: nowrap!important;"><input type="radio" name="basicroles" id='+id1+' value='+value+' class="URSRC_class_basicroles"   />' + URSRC_userrigths_array[i] + '</lable></div>';
                                }
                         }
                         URSRC_role_radio+='</div></div>';
                        $('#URSRC_rolesearch_roles').html(URSRC_role_radio);
                        $('#URSRC_rolesearch_roles').show();
                        if(URSRC_multi_array[0].length!=0){
                            $('#URSRC_lbl_nodetails_err').hide()
                            URSRC_tree_view(URSRC_menu_details);
                            URSRC_folder_view(URSRC_file_details);
                        }
                    }
                    else{
                        show_msgbox("ACCESS RIGHTS-SEARCH/UPDATE",URSRC_errorAarray[18].EMC_DATA,"success",false)
                    }
                }
            });
        }
        $('#URSRC_tble_menu').hide();
        $('#URSRC_tble_folder').hide();
        $('#URSRC_rolesearch_roles tr').remove();
        $('#URSRC_btn_submitbutton').hide();
    });
    $('#URSRC_btn_submitbutton').hide();
});
</script>
<!--SCRIPT TAG START-->
</head>
<!--HEAD TAG START-->
<!--BODY TAG START-->
<body>
<div class="container">
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>ACCESS RIGHTS-SEARCH/UPDATE</b></h4></div>
    <div class ='row content'>
        <div class="panel-body">
        <form  id="URSRC_form_user_rights" name="URSRC_user_right"  class="form-horizontal" role="form">
            <div class="form-group">
                <label name="USU_lbl_strtdte" id="USU_lbl_strtdte" class="srctitle  col-sm-2">SELECT A OPTION
                </label>
            </div>
            <div class="form-group row">
                <div class="radio">
                    <label class="col-sm-2" name="URSRC_lbl_basicrolemenucreation" id="URSRC_lbl_basicrolemenucreation" style="white-space: nowrap!important;">
                        &nbsp;&nbsp;&nbsp;&nbsp;<input  type='radio' name='URSRC_mainradiobutton' id='URSRC_radio_basicrolemenucreation' value='BASIC ROLE MENU CREATION'>
                        BASIC ROLE MENU CREATION
                    </label>
                </div>

            </div>
            <div class="form-group row">
                <div class="radio">
                    <label class="col-sm-2" name="URSRC_lbl_basicrolemenusearchupdate" id="URSRC_lbl_basicrolemenusearchupdate" style="white-space: nowrap!important;">
                        &nbsp;&nbsp;&nbsp;&nbsp;<input  type='radio' name='URSRC_mainradiobutton' id='URSRC_radio_basicrolemenusearchupdate' value='BASIC ROLE MENU SEARCH UPDATE'>
                        BASIC ROLE MENU SEARCH / UPDATE
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="radio">
                    <label class="col-sm-2" name="URSRC_lbl_rolecreation" id="URSRC_lbl_rolecreation" style="white-space: nowrap!important;">
                        &nbsp;&nbsp;&nbsp;&nbsp;<input  type='radio' name='URSRC_mainradiobutton' id='URSRC_radio_rolecreation' value='ROLE CREATION'>
                        ROLE CREATION
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="radio">
                    <label class="col-sm-2" name="URSRC_lbl_rolesearchupdate" id="URSRC_lbl_rolesearchupdate" style="white-space: nowrap!important;">
                        &nbsp;&nbsp;&nbsp;&nbsp;<input   type='radio' name='URSRC_mainradiobutton' id='URSRC_radio_rolesearchupdate' value='ROLE SEARCH UPDATE'>
                        ROLE SEARCH / UPDATE
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="radio">
                    <label class="col-sm-2" name="URSRC_lbl_logincreation" id="URSRC_lbl_logincreation" style="white-space: nowrap!important;">
                        &nbsp;&nbsp;&nbsp;&nbsp;<input   type='radio' name='URSRC_mainradiobutton' id='URSRC_radio_logincreation' value='LOGIN CREATION'>
                        LOGIN CREATION
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="radio">
                    <label class="col-sm-2" name="URSRC_lbl_loginsearchupdate" id="URSRC_lbl_loginsearchupdate" style="white-space: nowrap!important;">
                        &nbsp;&nbsp;&nbsp;&nbsp;<input   type='radio' name='URSRC_mainradiobutton' id='URSRC_radio_loginsearchupdate' value='LOGIN SEARCH UPDATE'>
                        LOGIN SEARCH / UPDATE
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label id="URSRC_lbl_header" class="srctitle col-sm-2" style="white-space: nowrap!important;"></label>
            </div >

            <div id="URSRC_tble_basicrolemenucreation" hidden>
                <div class="form-group">
                    <div id="URSRC_tble_basicroles" hidden ></div>
                </div>

                <div><label id="URSRC_lbl_basicrole_err" class="errormsg"></label></div>
            </div>
            <div id="URSRC_tble_basicrolemenusearch" hidden>

                <div id="URSRC_tble_search_basicroles" hidden ></div>

            </div>
            <div class="form-group">
                <div id="URSRC_tble_basicroles_chk" hidden ></div>
            </div>
            <div id="URSRC_tble_role" hidden>
                <div class="form-group">
                    <label  class=" col-sm-2" >ROLE<em>*</em></label>
                    <div class="col-sm-3"><input type="text" name="URSRC_tb_customrole" id="URSRC_tb_customrole" maxlength="15" class="autosize form-control" placeholder="ROLE" /></div>
                    <label id="URSRC_lbl_role_err" class="errormsg"></label>
                </div>
                <div class="form-group">
                    <div id="URSRC_tble_roles" hidden ></div>
                </div>
            </div>

            <div id="URSRC_tble_login" hidden>
                <div ><label id="URSRC_lbl_nologin_err" class="errormsg"></label></div>
                <div class="form-group">
                    <label id="URSRC_lbl_loginid" class=" col-sm-2">LOGIN ID<em>*</em></label>
                    <div class="col-sm-3"> <input type="text" name="URSRC_tb_loginid" id="URSRC_tb_loginid"  maxlength="40" class="alphanumericdot login_submitvalidate URSRC_email_validate form-control autosize" hidden /></div>
                    <label id="URSRC_lbl_email_err" class="errormsg"></label>

                  </div>
                <div class="form-group" >
                    <label id="URSRC_lbl_loginid1" class=" col-sm-2">LOGIN ID<em>*</em></label>
                    <div class="col-sm-4"><select id='URSRC_lb_selectloginid' name="URSRC_lb_loginid" title="LOGIN ID" maxlength="40"  class="form-control "    >
                            <option value='SELECT' selected="selected"> SELECT</option>
                        </select></div>
                </div>


                <div class="form-group">
                    <div id="URSRC_tble_rolecreation" hidden></div>
                </div>
                <div id="joindate">
                    <div class="form-group">
                        <label id="URSRC_lbl_joindate" class="col-sm-2" hidden >SELECT A JOIN DATE<em>*</em></label>
                        <div class="col-sm-10"><input type="text" name="URSRC_tb_joindate"  id="URSRC_tb_joindate" class="datepicker login_submitvalidate datemandtry form-control" style="width:110px;" hidden  /></div>
                    </div>

                </div>
                <input class="btn" type="button"  id="URSRC_btn_login_submitbutton" name="SAVE" value="SUBMIT" disabled hidden /></td>
            </div>
            <div id="URSRC_tble_rolesearch" hidden >
                <div class="form-group">
                    <label id="URSRC_lbl_norole_err" class="errormsg"></label>
                </div>
                <div class="form-group">
                    <label id="URSRC_lbl_selectrole" class=" col-sm-2">SELECT A ROLE<em>*</em></label>
                    <div class="col-sm-3"> <select id='URSRC_lb_selectrole' name="URSRC_lb_rolename" title="ROLE" class='submitvalidate form-control' >
                            <option value='SELECT' selected="selected"> SELECT</option>
                        </select></div>
                </div>
                <div class="form-group">
                    <div id="URSRC_rolesearch_roles"></div>
                </div>
            </div>

            <label id="URSRC_lbl_nodetails_err" class="errormsg"></label>
            <div class="table-responsive">
                <table id="URSRC_tble_menu" hidden ></table>
            </div>
            <div class="table-responsive">
                <table id="URSRC_tble_folder" hidden ></table>
            </div>
            <input class="btn" type="button"  id="URSRC_btn_submitbutton" name="SAVE" value="SUBMIT" disabled />
        </form>
            </div>
    </div>
</div>
</body>
</html>