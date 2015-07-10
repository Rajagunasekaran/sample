<!--//*******************************************FILE DESCRIPTION*********************************************//
//*******************************************SITE MAINTENANCE*********************************************//
//DONE BY:safi

//VER 0.01-INITIAL VERSION, SD:19/05/2015 ED:19/05/2015
//*********************************************************************************************************//-->
<?php

require_once('application/libraries/EI_HDR.php');

?>

<html>
<head>

    <script>
        //GLOBAL DECLARATION
        var value_array=[];
        var USR_SITE_checked_mpid=[];
        var USR_SITE_errorAarray=[];
        var controller_url="<?php echo base_url(); ?>" + '/index.php/ACCESSRIGHTS/Ctrl_Access_Rights_Site_Maintenance/' ;
        //START DOCUMENT READY FUNCTION
        $(document).ready(function(){
            $('.preloader').show();
            var USR_SITE_menuname=[];
            var USR_SITE_submenu=[];
            var USR_SITE_subsubmenu=[];
            var sub_menu1_id=[];
            var USR_SITE_basicradio_value;
            $('#USR_SITE_btn_submitbutton').hide();
            var USR_SITE_multi_array=[];
            USR_SITE_loadInitialValue();
            function USR_SITE_loadInitialValue(){
                $.ajax({
                    type:'post',
                    'url':controller_url+"/USR_SITE_getintialvalue",
                    success:function(data){
                        value_array=JSON.parse(data);
                        USR_SITE_tree_view(value_array) ;
                    },
                    error:function(data){

                        show_msgbox("SITE MAINTENANCE",JSON.stringify(data),"error",false);
                    }
                });
            }
            //COMMON TREE VIEW FUNCTION
            function USR_SITE_tree_view(value_array){
                $('.preloader').hide();
                $('#USR_SITE_tble_menu').replaceWith('<table id="USR_SITE_tble_menu"  ></table>')
                var count=0;
                var menus=[];
                USR_SITE_menuname=value_array[0][0];
                USR_SITE_submenu=value_array[0][1];
                USR_SITE_subsubmenu=value_array[0][2];
                USR_SITE_checked_mpid=value_array[1];
                USR_SITE_errorAarray=value_array[2];
                var USR_SITE_main_menu=USR_SITE_menuname
                var USR_SITE_sub_menu=USR_SITE_submenu
                var USR_SITE_sub_menu1=USR_SITE_subsubmenu
                var USR_SITE_menu1='<label>MENU<em>*</em></label>'
                $('#USR_SITE_tble_menu').append(USR_SITE_menu1);
                var USR_SITE_menu=''
                for(var i=0;i<USR_SITE_main_menu.length;i++)
                {
                    var USR_SITE_submenu_table_id="USR_SITE_tble_submenu"+i;
                    var USR_SITE_menu_button_id="menu"+"_"+i;
                    var USR_SITE_submenu_div_id="sub"+i
                    var menu_value=USR_SITE_main_menu[i].replace(/ /g,"&");
                    var id_menu=i+'m'
                    var mainmenuid=i;
                    USR_SITE_menu= '<div ><ul style="list-style: none;" ><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;<input value="+" type="button"  id='+USR_SITE_menu_button_id+' height="1" width="1" class="exp2" />&nbsp;<input type="checkbox" name="menu" id='+id_menu+' value='+menu_value+' level="parent" class="tree USR_SITE_submit_validate Parent"  />' + USR_SITE_main_menu[i] + '</td></tr>';
                    USR_SITE_menu+='<div id='+USR_SITE_submenu_div_id+' hidden ><tr><td><table id='+USR_SITE_submenu_table_id+' class="USR_SITE_class_submenu"  ></table></tr></div></li></ul></div>';
                    $('#USR_SITE_tble_menu').append(USR_SITE_menu);
                    var USR_SITE_submenu='';
                    for(var j=0;j<USR_SITE_sub_menu.length;j++)
                    {
                        if(i==j)
                        {
                            var submenulength=USR_SITE_sub_menu[j].length;
                            for(var k=0;k<USR_SITE_sub_menu[j].length;k++)
                            {
                                var USR_SITE_submenu1_table_id="USR_SITE_tble_submenu1"+k+j;
                                var USR_SITE_submenu_button_id="sub_menu"+"_"+k+j;
                                var USR_SITE_submenu1_div_id="sub1"+k+j
                                var sub_menu_value1=USR_SITE_sub_menu[j][k].replace(/ /g,"&");
                                var sub_menu_values=sub_menu_value1.split("_");
                                var sub_menu_id=sub_menu_values[1]
                                var sub_menu_fp_id=sub_menu_values[2]
                                var fp_id='fp_id'+sub_menu_id
                                sub_menu_values[0]=sub_menu_values[0].replace(/&/g," ");
                                var submenuids="USR_SITE_submenus-"+mainmenuid+'-'+submenulength+'-'+k;//+'-'+sub_menu_id;
                                var idsubmenu=k+j
                                if(USR_SITE_sub_menu1[count].length!=0)
                                {
                                    USR_SITE_submenu = '<div ><ul style="list-style: none;"><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;<input value="+" type="button"  id='+USR_SITE_submenu_button_id+' height="1" width="1" class="exp1" />&nbsp;<input type="checkbox" name="Sub_menu[]" id='+submenuids+' value='+sub_menu_id+'&&'+' level="child" class="tree submenucheck USR_SITE_submit_validate Child"  />' + sub_menu_values[0] + '</td></tr>';
                                }
                                else
                                {
                                    USR_SITE_submenu = '<div ><ul style="list-style: none;"><li style="list-style: none;" ><tr ><td>&nbsp;<input type="checkbox" name="Sub_menu[]" id='+submenuids+' value='+sub_menu_id+' class="tree submenucheck USR_SITE_submit_validate" level="child" />' + sub_menu_values[0] + '</td><td><input type="hidden" value='+sub_menu_fp_id+' id='+fp_id+'></tr>';
                                }
                                USR_SITE_submenu+='<div id='+USR_SITE_submenu1_div_id+'  ><tr><td><table id='+USR_SITE_submenu1_table_id+' hidden ></table></tr></div></li></ul></div>';
                                $('#'+"USR_SITE_tble_submenu"+i).append(USR_SITE_submenu);
                                for(var m1=0;m1<USR_SITE_checked_mpid.length;m1++){
                                    if(sub_menu_id==USR_SITE_checked_mpid[m1]){
                                        $('#'+submenuids).prop("checked", true)
                                        $('#'+id_menu).prop("checked", true)
                                    }
                                }
                                var USR_SITE_submenu1='';
                                var subsubmenucount=USR_SITE_sub_menu1[count].length;
                                for(var m=0;m<USR_SITE_sub_menu1[count].length;m++)
                                {
                                    var sub_menu1_value1=USR_SITE_sub_menu1[count][m].replace(/ /g,"&");
                                    var sub_menu1_values=sub_menu1_value1.split("_");
                                    sub_menu1_values[0]=sub_menu1_values[0].replace(/&/g," ")
                                    var sub_menu1_id=sub_menu1_values[1];
                                    var sub_menu1_fp_id=sub_menu1_values[2]
                                    var idsubmenu1=count+m+'s1'
                                    var subsubmenuid='USR_SITE_submenuchk-'+mainmenuid+'-'+submenulength+'-'+k+'-'+sub_menu_id+'-'+m+'-'+subsubmenucount;//+'-'+sub_menu1_id;
                                    var fp_id='fp_id'+sub_menu1_id
                                    USR_SITE_submenu1 = '<div ><ul style="list-style: none;"><li style="list-style: none;" ><tr ><td>&nbsp;<input type="checkbox" name="Sub_menu1[]" id='+subsubmenuid+' value='+sub_menu1_id+' class="tree subsubmenuchk USR_SITE_submit_validate" level="child1" />' +sub_menu1_values[0] + '</td><td><input type="hidden" value='+sub_menu1_fp_id+' id='+fp_id+'></tr></li></ul></div>';
                                    $('#'+"USR_SITE_tble_submenu1"+k+j).append(USR_SITE_submenu1);
                                    for(var m1=0;m1<USR_SITE_checked_mpid.length;m1++){
                                        if(sub_menu1_id==USR_SITE_checked_mpid[m1]){
                                            $('#'+subsubmenuid).prop("checked", true)
                                        }
                                    }
                                }
                                count++;
                            }
                        }
                    }
                }

                if($("input[name=menu]").is(":checked")==true)
                {
                    $('#USR_SITE_btn_submitbutton').val('GRANT ACCESS');
                }
                else
                {
                    $('#USR_SITE_btn_submitbutton').val('REVOKE ACCESS');
                }
                $('#USR_SITE_btn_submitbutton').attr("disabled", "disabled").show();

                if(USR_SITE_sucsval==1)
                {
//MESSAGE BOX FOR REVOKE AND GRANT BUTTON
                    $(".preloader").hide();
                    show_msgbox("SITE MAINTENANCE",USR_SITE_errorAarray[0].EMC_DATA,"success",false);
                }
                if(USR_SITE_sucsval==2)
                {
                    $(".preloader").hide();
                    show_msgbox("SITE MAINTENANCE",USR_SITE_errorAarray[1].EMC_DATA,"error",false);
                }
            }
            //BTN VALIDATION
            $(document).on("click",'.tree', function (){
                if($("input[name=menu]").is(":checked")==true)
                {
                    $('#USR_SITE_btn_submitbutton').removeAttr("disabled", "disabled");
                }
                else
                {
                    $('#USR_SITE_btn_submitbutton').removeAttr("disabled", "disabled");
                }
            });
            //TREE VIEW EXPANDING
            $(document).on("click",'.exp2,.collapse2', function (evt){
                evt.stopPropagation();
                evt.preventDefault();
                evt.stopImmediatePropagation();
                var button_id=$(this).attr("id")
                var btnid=button_id.split("_");
                var menu_btnid=btnid[1]
                if($(this).val()=='+'){
                    $(this).val('-')
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
                    $(this).replaceWith('<input type="button"   value="+" id='+button_id+'  height="1" width="1" class="exp2" />');
                }
            });
            //TREE VIEW EXPANDING
            $(document).on("click",'.exp1,.collapse1', function (evt){
                evt.stopPropagation();
                evt.preventDefault();
                evt.stopImmediatePropagation();
                var sub_buttonid=$(this).attr("id")
                var btnid=sub_buttonid.split("_");
                var menu_btnid=btnid[2]
                if($(this).val()=='+'){
                    $(this).replaceWith('<input type="button"   value="-" id='+sub_buttonid+'  height="1" width="1" class="collapse1" />');
                    $('#USR_SITE_tble_submenu1'+menu_btnid).toggle("fold",100);
                }
                else
                {
                    $('#USR_SITE_tble_submenu1'+menu_btnid).toggle("fold",100);
                    $(this).replaceWith('<input type="button"   value="+" id='+sub_buttonid+'  height="3" width="3" class="exp1" />');
                }
            });
            //VALIDATION FOR MENU SUB MENU FULLY CHECKED BOX CLICKING
            var USR_SITE_mainmenu_value;
            $(document).on("change blur",'.tree ', function (){
                var val = $(this).attr("checked");
                USR_SITE_mainmenu_value=$(this).val()
                $(this).parent().find("input:checkbox").each(function() {
                    if (val) {
                        $(this).attr("checked", "checked");
                    } else {
                        $(this).removeAttr("checked");
                        $(this).parents('ul').each(function(){
                            $(this).prev('input:checkbox').removeAttr("checked");
                        });
                    }
                });
            });
            //VALIDATION FOR SUB MENU CHECK BOX CLICKING
            $(document).on('click','.submenucheck',function(){
                var USR_SITE_checkbox_id=$(this).attr("id");
                var USR_SITE_checkbox_id_split=USR_SITE_checkbox_id.split('-');
                var count=0;
                for(var g=0;g<USR_SITE_checkbox_id_split[2];g++)
                {
                    var checked1='USR_SITE_submenus-'+USR_SITE_checkbox_id_split[1]+'-'+USR_SITE_checkbox_id_split[2]+'-'+g;
                    var checked=$('#'+checked1).attr("checked");
                    if(checked)
                    {
                        count++;
                    }
                }
                if(count!=0)
                {
                    $('#'+USR_SITE_checkbox_id_split[1]+'m').prop('checked',true);
                }
                else
                {
                    $('#'+USR_SITE_checkbox_id_split[1]+'m').prop('checked',false);
                }
            });
            //VALIDATION FOR SUB SUB MENU CHECK BOX CLICKING
            $(document).on('click','.subsubmenuchk',function(){
                var USR_SITE_checkbox_id=$(this).attr("id");
                var USR_SITE_checkbox_id_idsplit=USR_SITE_checkbox_id.split('-');
                var count=0;
                for(var i=0;i<USR_SITE_checkbox_id_idsplit[6];i++)
                {
                    var chkboxid=USR_SITE_checkbox_id_idsplit[0]+'-'+USR_SITE_checkbox_id_idsplit[1]+'-'+USR_SITE_checkbox_id_idsplit[2]+'-'+USR_SITE_checkbox_id_idsplit[3]+'-'+USR_SITE_checkbox_id_idsplit[4]+'-'+i+'-'+USR_SITE_checkbox_id_idsplit[6];
                    var checked=$('#'+chkboxid).attr("checked");
                    if(checked)
                    {
                        count++;
                    }
                }
                if(count!=0)
                {
                    $('#USR_SITE_submenus-'+USR_SITE_checkbox_id_idsplit[1]+'-'+USR_SITE_checkbox_id_idsplit[2]+'-'+USR_SITE_checkbox_id_idsplit[3]).prop('checked',true);
                }
                else
                {
                    $('#USR_SITE_submenus-'+USR_SITE_checkbox_id_idsplit[1]+'-'+USR_SITE_checkbox_id_idsplit[2]+'-'+USR_SITE_checkbox_id_idsplit[3]).prop('checked',false);
                }
                var submenucount=0;
                for(var j=0;j<USR_SITE_checkbox_id_idsplit[2];j++)
                {
                    var subchkid=USR_SITE_checkbox_id_idsplit[1]+'-'+USR_SITE_checkbox_id_idsplit[2]+'-'+j;
                    var submenuchecked=$('#USR_SITE_submenus-'+subchkid).attr("checked");
                    if(submenuchecked)
                    {
                        submenucount++;
                    }
                }
                if(submenucount!=0)
                {
                    $('#'+USR_SITE_checkbox_id_idsplit[1]+'m').prop('checked',true);
                }
                else
                {
                    $('#'+USR_SITE_checkbox_id_idsplit[1]+'m').prop('checked',false);
                }
            });
            //CLICK FUNCTON FOR SUBMIT BUTTON
            $(document).on('click','#USR_SITE_btn_submitbutton',function(){
                $('.preloader').show();
                $.ajax({
                    type:'POST',
                    'url':controller_url+"/USR_SITE_update",
                    data:$('#USR_SITE_form_user').serialize(),
                    success:function(data){
                        if($('#USR_SITE_btn_submitbutton').val()=='REVOKE ACCESS')
                        {
                            $(".preloader").show();
                            USR_SITE_sucsval=1;
                            USR_SITE_clear()
                        }
                        else
                        {
                            $(".preloader").show();
                            USR_SITE_sucsval=2;
                            USR_SITE_clear()
                        }

                    }
                });
            });
//SUCCESS FUNCTION FOR UPDATING
            function USR_SITE_clear(){
//        $('.preloader').hide();
                USR_SITE_loadInitialValue();
            }
        });
        //END DOCUMENT READY FUNCTION
    </script>
    <!--SCRIPT TAG END-->
</head>
<!--HEAD TAG END-->
<!--BODY TAG START-->
<body>
<div class="container">
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>SITE MAINTENANCE</b></h4></div>
    <div class="panel-body">
        <form id="USR_SITE_form_user" name="USR_SITE_form_user" class="form-horizontal content" role="form">
            <div class="table-responsive">
                <table id="USR_SITE_tble_menu" hidden></table>
            </div>
            <input align="right" type="button" class="maxbtn" name="USR_SITE_btn_submitbutton" id="USR_SITE_btn_submitbutton" style="width:190px">

        </form>
    </div>
</div>

</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->