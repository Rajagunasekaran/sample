<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE*******************************//
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:27/05/2015 ED:18/05/2015
//************************************************************************************************************-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <script>
        //READY FUNCTION START
        var listboxoption;
        var ErrorControl ={EmailId:'Invalid'}
        var EMPSRC_UPD_DEL_sucsval=0;
        var EMP_ENTRY_error=[];
        var EMP_ENTRY_fullarr=[];
        $(document).ready(function() {
            var EMP_ENTRY_controller_url="<?php echo base_url(); ?>" + '/index.php/EXPENSE/STAFF/Ctrl_Staff_Employee_Entry_Search_Update_Delete/' ;
            $('#spacewidth').height('0%');
            $(".preloader").hide();
            $('textarea').autogrow({onInitialize: true});
            $("textarea").height(114);
            var EMP_ENTRY_multi_array=[];
            var EMP_ENTRY_emparr_employeedesig=[];
            var EMP_ENTRY_errorMsg_array=[];
            var EMP_ENTRY_expensearr_unitnumber=[];
            var EMP_ENTRY_unitArray=[];
            //SEARCH FORM
            var EMPSRC_UPD_DEL_fullarray=[];
            var EMPSRC_UPD_DEL_searchoption=[];
            var EMPSRC_UPD_DEL_expensearr_designation=[];
            var EMPSRC_UPD_DEL_expensearr_employeename=[];
            var EMPSRC_UPD_DEL_flexheader_array=[];
            var EMPSRC_UPD_DEL_multi_array=[];
            var EMPSRC_UPD_DEL_confmsg_array=[];
            var EMPSRC_UPD_DEL_employeenameconcat;
            var EMPSRC_UPD_DEL_searchoption_desigdata;
            var EMPSRC_UPD_DEL_searchoption_desigid;
            //JQUERY LIB VALIDATION START
            $('#EMP_ENTRY_tb_email').doValidation({rule:'email',prop:{uppercase:false,autosize:true}});
            $(".autosizealph").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
            $("#EMP_ENTRY_tb_mobile").doValidation({rule:'numbersonly',prop:{realpart:10,leadzero:true}});
            //JQUERY LIB VALIDATION END
            //LIST BOX ITEM CHANGE FUNCTION
            $('.PE_rd_selectform').click(function(){
                $(".preloader").show();

                listboxoption=$(this).val();
                $('#ET_ENTRY_ta_subject').val('');
                $('#CONFIG_SRCH_UPD_div_htmltable').hide();
                $('#CONFIG_SRCH_UPD_div_header').hide();
                $("#STDTL_INPUT_lb_employeename").hide();
                $("#STDTL_INPUT_lbl_employeename").hide();
                $("#EMPSRC_UPD_DEL_ta_mobile").hide();
                $('#EMPSRC_UPD_DEL_lb_searchoption').empty();
                $("#EMPSRC_UPD_DEL_ta_comments").hide();
                $("#EMPSRC_UPD_DEL_btn_search_autocomplt").hide();
                $('#STDTL_INPUT_noform').hide();
                $('#EMPSRC_UPD_DEL_ta_email').hide();
                EMP_ENTRY_employeedetailrset();
                $('#EMPSRC_UPD_DEL_pdf').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                if(listboxoption=='EMPLOYEE ENTRY')
                {

                    $('section').html('');
                    $('#searchfrm').hide();
                    $('#STDTL_SEARCH_lbl_searchoptionheader').hide();
                    $('#STDTL_SEARCH_tble_amt_option').hide();
                    $('#searchform').hide();
                    $("#EMPSRC_UPD_DEL_table_employee").hide();
                    $("#EMPSRC_UPD_DEL_lbl_searchoption").hide();
                    $("#EMPSRC_UPD_DEL_table_updateform").hide();
                    $.ajax({
                        type: "POST",
                        url:EMP_ENTRY_controller_url+"Initialdata",
                        data:{'ErrorList':'1,2,34,71,154,248,135,136,153,155,157,158,163,164,165,166,167,168,169,170,315,339,400,401,446'},
                        success: function(data){
                            $('.preloader').hide();
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                            EMP_ENTRY_fullarr=JSON.parse(data);
                            EMP_ENTRY_emparr_employeedesig=EMP_ENTRY_fullarr[0];
                            EMP_ENTRY_unitArray=EMP_ENTRY_fullarr[1];
                            EMP_ENTRY_multi_array=EMP_ENTRY_fullarr[2];
                            EMP_ENTRY_error=EMP_ENTRY_fullarr[3];
                            $(".EMP_ENTRY_title_alpha").prop("title",EMP_ENTRY_error[0].EMC_DATA);
                            $("#EMP_ENTRY_tb_mobile").prop("title",EMP_ENTRY_error[1].EMC_DATA)
                            if(((EMP_ENTRY_unitArray).length!=0))
                            {
                                $('#enrtyfrm').show();
                                $('#EMP_ENTRY_form_errormsg').show();
                                $('#EMP_ENTRY_table_employeetbl').show();
                                $('#EMP_ENTRY_lb_empdesig').empty();
                                $('#EMP_ENTRY_lbl_firstname').show();
                                $('#EMP_ENTRY_tb_firstname').show().focus();
                                $('#EMP_ENTRY_table_errormsg > div ').remove().hide();
                                var EMP_ENTRY_emparray_employee ='<option>SELECT</option>';
                                $('#EMP_ENTRY_lb_empdesig').append(EMP_ENTRY_emparray_employee);
                                for (var i = 0; i < EMP_ENTRY_emparr_employeedesig.length; i++)
                                {
                                    var EMP_ENTRY_emparray_employee=EMP_ENTRY_emparr_employeedesig[i].ECN_DATA;
                                    $('#EMP_ENTRY_lb_empdesig').append($('<option>').text(EMP_ENTRY_emparray_employee).attr('value', EMP_ENTRY_emparray_employee));
                                }
                            }
                            else
                            {
                                if((EMP_ENTRY_unitArray).length==0)
                                {
                                    $('#EMP_ENTRY_table_errormsg').show();
                                    $('#EMP_ENTRY_form_employeename').hide();
                                    var uniterrormsg='<p><label class="errormsg">'+EMP_ENTRY_error[18].EMC_DATA+'</label></p>';
                                    $('#EMP_ENTRY_table_errormsg').append(uniterrormsg);
                                }
                            }
                        },
                        error:function(data){
                            alert(JSON.stringify(data))
                        }
                    });
                }
                else if(listboxoption=='EMPLOYEE SEARCH/UPDATE')
                {
                    $("#enrtyfrm").hide();
                    $("#STDTL_INPUT_lb_employeename").val('SELECT').show();
                    $("#STDTL_INPUT_lbl_employeename").show();
                    $("#searchform").show();
                    $("#EMPSRC_UPD_DEL_table_employee").show();
                    $("#EMPSRC_UPD_DEL_lbl_searchoption").show();
                    $("#EMPSRC_UPD_DEL_lb_searchoption").show();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').hide();
                    $('#EMPSRC_UPD_DEL_lbl_designation_listbox').hide();
                    $('#EMPSRC_UPD_DEL_lb_designation_listbox').hide();
                    $("#STDTL_SEARCH_lb_employeename_listbox").hide();
                    $("#EMPSRC_UPD_DEL_table_updateform").hide();
                    EMPSRC_UPD_DEL_employlstbx();
                }
            });
            function EMPSRC_UPD_DEL_employlstbx(){
                $.ajax({
                    type: "POST",
                    url:EMP_ENTRY_controller_url+"EMPSRC_UPD_DEL_searchoptionresult",
                    data:{'ErrorList':'1,2,34,71,154,248,135,136,153,155,157,158,163,164,165,166,167,168,169,170,315,339,400,401,446'},
                    success: function(data){
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        $('#EMPSRC_UPD_DEL_lb_searchoption').empty();
                        EMPSRC_UPD_DEL_fullarray=JSON.parse(data);
                        EMPSRC_UPD_DEL_searchoption=EMPSRC_UPD_DEL_fullarray[0]
                        EMPSRC_UPD_DEL_expensearr_employeename=EMPSRC_UPD_DEL_fullarray[2]
                        EMP_ENTRY_error=EMPSRC_UPD_DEL_fullarray[3];
                        //GET STAFF SEARCH OPTION
                        var EMPSRC_UPD_DEL_searchoptions ='';
                        for (var i = 0; i < EMPSRC_UPD_DEL_searchoption.length; i++) {
                            if( i>=2 && i<=6)
                            {
                                var EMPSRC_UPD_DEL_searchoption_data=EMPSRC_UPD_DEL_searchoption[i].ECN_DATA;
                                var EMPSRC_UPD_DEL_searchoption_id=EMPSRC_UPD_DEL_searchoption[i].ECN_ID;
                                $('#EMPSRC_UPD_DEL_lb_searchoption').append($('<option>').text(EMPSRC_UPD_DEL_searchoption_data).attr('value', EMPSRC_UPD_DEL_searchoption_id));
                            }
                        }
                        EMPSRC_UPD_Sortit('EMPSRC_UPD_DEL_lb_searchoption');
                        $('#EMPSRC_UPD_DEL_lbl_searchoption').show();
                        //GET STAFF EMPLOYEE DESIGNATION
                        $('#EMPSRC_UPD_DEL_lb_designation_listbox').empty();
                        $('#EMPSRC_UPD_DEL_lb_empdesig').empty();
                        var EMPSRC_UPD_DEL_searchoptions ='';
                        $('#EMPSRC_UPD_DEL_lb_designation_listbox').append('<option>SELECT</option>');
                        $('#EMPSRC_UPD_DEL_lb_empdesig').append('<option>SELECT</option>');
                        for (var i = 0; i < EMPSRC_UPD_DEL_searchoption.length; i++) {
                            if( i>=0 && i<=1)
                            {
                                EMPSRC_UPD_DEL_searchoption_desigdata=EMPSRC_UPD_DEL_searchoption[i].ECN_DATA;
                                EMPSRC_UPD_DEL_searchoption_desigid=EMPSRC_UPD_DEL_searchoption[i].ECN_ID;
                                $('#EMPSRC_UPD_DEL_lb_designation_listbox').append($('<option>').text(EMPSRC_UPD_DEL_searchoption_desigdata).attr('value', EMPSRC_UPD_DEL_searchoption_desigid));
                                $('#EMPSRC_UPD_DEL_lb_empdesig').append($('<option>').text(EMPSRC_UPD_DEL_searchoption_desigdata).attr('value', EMPSRC_UPD_DEL_searchoption_desigdata));

                            }
                        }
                        //GET STAFF EMPLOYEE NAME
                        var EMPSRC_UPD_DEL_expensearray_employeename='<option>SELECT</option>';
                        for (var i = 0; i < EMPSRC_UPD_DEL_expensearr_employeename.length; i++)
                        {
                            EMPSRC_UPD_DEL_employeenameconcat=EMPSRC_UPD_DEL_expensearr_employeename[i].EMP_DETAIL_names_concat.split("_");
                            EMPSRC_UPD_DEL_expensearray_employeename += '<option value="' + EMPSRC_UPD_DEL_employeenameconcat[0]+" "+EMPSRC_UPD_DEL_employeenameconcat[1] + '">' + EMPSRC_UPD_DEL_employeenameconcat[0]+" "+EMPSRC_UPD_DEL_employeenameconcat[1]+ '</option>';
                        }
                        $('#EMPSRC_UPD_DEL_lb_employeename_listbox').html(EMPSRC_UPD_DEL_expensearray_employeename);
//                            $('#EMPSRC_UPD_DEL_lb_empdesig').html(EMPSRC_UPD_DEL_searchoption_desigdata)
//                            alert(EMPSRC_UPD_DEL_searchoption_desigdata)
                    },
                    error:function(data){
                        alert(JSON.stringify(data))
                    }
                });
                $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                $('section').html('');
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_lb_employeename_listbox').val('SELECT');
            }
            //FUNCTION FOR SORTING
            function EMPSRC_UPD_Sortit(lbid) {
                var $r = $("#"+lbid+" "+"option");
                $r.sort(function(a, b) {
                    if (a.text < b.text) return -1;
                    if (a.text == b.text) return 0;
                    return 1;
                });
                $($r).remove();
                $("#"+lbid).append($($r));
                $("#"+lbid+" "+"option").eq(0).before('<option value="SELECT">SELECT</option>')
                $("select#"+lbid)[0].selectedIndex = 0;
            }
            //CHANGE FUNCTION FOR DESIGNATION
            $("#EMP_ENTRY_lb_empdesig").change(function(){
                var EMP_ENTRY_desigoption=$(this).val();
                if((EMP_ENTRY_desigoption=="CLEANER")||(EMP_ENTRY_desigoption=="SELECT"))
                {
                    $('#EMP_ENTRY_lbl_cardno').hide();
                    $('#card').hide();
                    $('#EMP_ENTRY_nullcard').hide();
                    $('#EMP_ENTRY_lbl_shwcardno').hide();
                    $('#EMP_ENTRY_radio_selectcard').hide();
                    $('#EMP_ENTRY_radio_null').hide();
                    $('#EMP_ENTRY_tble_menu').hide();
                }
                else
                {
                    $('#EMP_ENTRY_lbl_cardno').show();
                    $('#card').show();
                    $('#EMP_ENTRY_nullcard').show();
                    $('#EMP_ENTRY_lbl_shwcardno').show();
                    $('#EMP_ENTRY_radio_selectcard').show();
                    $('#EMP_ENTRY_radio_null').show();
                    $('input[name="EMP_ENTRY_selectcard"]').prop('checked', false);
                    $('input[name="menu"]').prop('checked', false);
                    $('input[name="submenu[]"]').prop('checked', false);
                }
            });
            //CLICK FUNCTION FOR RADIO BUTTON
            $('.radio_selected').click(function()
            {
                var EMP_ENTRY_radio=$("input[name=EMP_ENTRY_selectcard]:checked").val()
                if(EMP_ENTRY_radio=='CARD')
                {
                    EMP_ENTRY_multitreeview(EMP_ENTRY_multi_array);
                    $('#EMP_ENTRY_tble_menu').show();
                    $(".preloader").hide();
                }else
                {
                    $('#EMP_ENTRY_tble_menu').hide();
                    $('#EMP_ENTRY_lbl_error').hide();
                    $(".preloader").hide();
                }
            });
            //SHOW THE TREE VIEW FORMATE//
            function EMP_ENTRY_multitreeview(EMP_ENTRY_multi_arraynew)
            {
                if((EMP_ENTRY_multi_arraynew.length)==0)
                {
                    EMP_ENTRY_multi_array=EMP_ENTRY_multi_arraynew;
                }else
                {
                    var EMPENTRY_multi_array=[];
                    EMPENTRY_multi_array=EMP_ENTRY_multi_arraynew
                    EMP_ENTRY_multi_array=EMPENTRY_multi_array;
                }
                if(EMP_ENTRY_multi_array==""||EMP_ENTRY_multi_array.length==0 || EMP_ENTRY_multi_array.length==null)
                {
                    $('#EMP_ENTRY_lbl_cardno').hide();
                    $('#card').hide();
                    if($('#EMP_ENTRY_radio_selectcard').is(":checked")==true)
                    {
                        $('#EMP_ENTRY_lbl_error').text(EMP_ENTRY_error[2].EMC_DATA).show();
                    }
                    $("#EMP_ENTRY_tble_menu").hide();
                }
                else
                {
                    //SHOW TREE VIEW FORMATE//
                    $('#EMP_ENTRY_lbl_cardno').show();
                    $('#card').show();
                    $('#EMP_ENTRY_lbl_error').hide();
                    $("#EMP_ENTRY_tble_menu").replaceWith("<table id ='EMP_ENTRY_tble_menu'></table>");
                    var EMP_ENTRY_menu=''
                    for (var j = 0; j < EMP_ENTRY_multi_array[0].length; j++) {
                        var id="EMP_ENTRY_tble_submenu"+j;
                        var id1="menu"+"_"+j;
                        var id2="sub"+j;
                        var id_menu=j+'m'
                        var mainmenuid=j;
                        EMP_ENTRY_menu = '<div ><ul style="list-style: none;" ><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input value="+" type="button"   id='+id1+' height="5" width="5" class="exp" /><input type="checkbox" name="menu" id='+id_menu+' value='+EMP_ENTRY_multi_array[0][j]+' level="parent" class="tree empsubmitvalidat"  />' + EMP_ENTRY_multi_array[0][j] + '</td></tr>';
                        EMP_ENTRY_menu+='<div id='+id2+' hidden ><tr><td><table id='+id+' class="EMP_ENTRY_class_submenu"  ></table></tr></div></li></ul></div>';
                        $('#EMP_ENTRY_tble_menu').append(EMP_ENTRY_menu);
                        var EMP_ENTRY_submenu='';
                        var submenulength=EMP_ENTRY_multi_array[j+1].length;
                        for (var j1 = 0; j1 < EMP_ENTRY_multi_array[j+1].length; j1++) {
                            var id3="EMP_ENTRY_tble_submenu1"+j1;
                            var submenuids="EMP_submenus-"+mainmenuid+'-'+submenulength+'-'+j1;
                            EMP_ENTRY_submenu='<div><ul style="list-style: none;"><li style="list-style: none;" ><tr><td>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="submenu[]" id='+submenuids+' value='+EMP_ENTRY_multi_array[j+1][j1]+' class="tree submenucheck Child" level="child" />' + EMP_ENTRY_multi_array[j+1][j1] + '</td></tr>';
                            $('#'+"EMP_ENTRY_tble_submenu"+j).append(EMP_ENTRY_submenu);
                        }
                    }
                }
            }
            //VALIDATION FOR SUB MENU CHECK BOX CLICKING
            $(document).on('click','.submenucheck',function(){
                var idvalid=$(this).attr("id");
                var idsplit=idvalid.split('-');
                var countchecking=0;
                for(var g=0;g<idsplit[2];g++)
                {
                    var EMP_checked='EMP_submenus-'+idsplit[1]+'-'+idsplit[2]+'-'+g;
                    var EMP_checked=$('#'+EMP_checked).attr("checked");
                    if(EMP_checked)
                    {
                        countchecking++;
                    }
                }
                if(countchecking!=0)
                {
                    $('#'+idsplit[1]+'m').prop('checked',true);
                }
                else
                {
                    $('#'+idsplit[1]+'m').prop('checked',false);
                }
            });
            //CLASS USED FOR TREE VIEW//
            $(document).on("click",'.exp,.collapse1', function (evt){
                evt.stopPropagation();
                evt.preventDefault();
                evt.stopImmediatePropagation();
                var id=$(this).attr("id")
                var btnid=id.split("_");
                var menu_btnid=btnid[1]
                if($(this).val()=='+'){
                    $(this).val('-')
                    $('#sub'+menu_btnid).toggle("fold",100);
                }
                else
                {
                    $('#sub'+menu_btnid).toggle("fold",100);
                    $(this).replaceWith('<input type="button"   value="+" id='+id+'  height="3" width="3" class="exp" />');
                }
            });
            //VALIDATION FOR MENU SUB MENU FULLY CHECKED BOX CLICKING
            $(document).on("change",'.tree ', function (){
                var val = $(this).attr("checked");
                $(this).parent().find("input:checkbox").each(function() {
                    if (val!=undefined) {
                        $(this).attr("checked", "checked");
                    } else {
                        $(this).removeAttr("checked");
                        $(this).parents('ul').each(function()
                        {
                            $(this).prev('input:checkbox').removeAttr("checked");
                            $(this).closest('ul').prev().attr('checked', false);
                        });
                    }
                });
            });
            //BLUR FUNCTION FOR EMAIL ID
            $("#EMP_ENTRY_tb_email").blur(function(){
                var EMP_ENTRY_email = $("#EMP_ENTRY_tb_email").val();
                if(EMP_ENTRY_email.length==0)
                {
                    $('#EMP_ENTRY_lbl_validemailid').hide();
                    $("#EMP_ENTRY_tb_email").removeClass('invalid');
                }
                else
                {
                    var validtype=ErrorControl.EmailId;
                    if(validtype=='Valid')
                    {
                        $('#EMP_ENTRY_lbl_validemailid').hide();
                        $("#EMP_ENTRY_tb_email").removeClass('invalid');
                        $('#EMP_ENTRY_tb_email').val($('#EMP_ENTRY_tb_email').val().toLowerCase())
                    }
                    else
                    {
                        $('#EMP_ENTRY_lbl_validemailid').text(EMP_ENTRY_error[6].EMC_DATA).show();
                        $("#EMP_ENTRY_tb_email").addClass('invalid');
                        $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                    }
                }
            });
            //SUBMIT BUTTON VALIDATION//
            $(document).on("blur",'.empsubmitvalidat',function ()
            {
                var EMP_ENTRY_Firstname= $("#EMP_ENTRY_tb_firstname").val();
                var EMP_ENTRY_Lastname =$("#EMP_ENTRY_tb_lastname").val();
                var EMP_ENTRY_empdesig =$("#EMP_ENTRY_lb_empdesig").val();
                var EMP_ENTRY_Mobileno = $("#EMP_ENTRY_tb_mobile").val();
                var EMP_ENTRY_email = $("#EMP_ENTRY_tb_email").val();
                var EMP_ENTRY_unitno = $("#EMP_ENTRY_lb_unitno").val();
                var EMP_ENTRY_menu=$("input[name=menu]").is(":checked");
                var EMP_ENTRY_submenu=$('input[name="submenu[]"]:checked').length;
                if((( EMP_ENTRY_menu==true && EMP_ENTRY_submenu>0 &&(EMP_ENTRY_multi_array.length!=0)) || $('#EMP_ENTRY_radio_null').is(":checked")==true) && (EMP_ENTRY_Firstname!='') && (EMP_ENTRY_Lastname!='' )&&( EMP_ENTRY_Mobileno!='' && (parseInt($('#EMP_ENTRY_tb_mobile').val())!=0) ) && (EMP_ENTRY_Mobileno.length>=6) && (EMP_ENTRY_empdesig!='SELECT'))
                {
                    $("#EMP_ENTRY_btn_save").removeAttr("disabled");
                }
                else
                {
                    $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                }
            });
            //EMPLOYEE SAVE BUTTON VALIDATION
            $("#EMP_ENTRY_form_employeename").change(function(){
                var EMP_ENTRY_Firstname= $("#EMP_ENTRY_tb_firstname").val();
                var EMP_ENTRY_Lastname =$("#EMP_ENTRY_tb_lastname").val();
                var EMP_ENTRY_empdesig =$("#EMP_ENTRY_lb_empdesig").val();
                var EMP_ENTRY_Mobileno = $("#EMP_ENTRY_tb_mobile").val();
                var EMP_ENTRY_email = $("#EMP_ENTRY_tb_email").val();
                var EMP_ENTRY_unitno = $("#EMP_ENTRY_lb_unitno").val();
                var EMP_ENTRY_menu=$("input[name=menu]").is(":checked");
                var EMP_ENTRY_submenu=$('input[name="submenu[]"]:checked').length;
                if(EMP_ENTRY_empdesig=='STAFF'){
                    if((( EMP_ENTRY_menu==true && EMP_ENTRY_submenu>0 &&(EMP_ENTRY_multi_array.length!=0)) || $('#EMP_ENTRY_radio_null').is(":checked")==true) && (EMP_ENTRY_Firstname!='') && (EMP_ENTRY_Lastname!='' )&&( EMP_ENTRY_Mobileno!='' && (parseInt($('#EMP_ENTRY_tb_mobile').val())!=0) ) && (EMP_ENTRY_Mobileno.length>=6)&& (EMP_ENTRY_empdesig!='SELECT'))
                    {
                        $("#EMP_ENTRY_btn_save").removeAttr("disabled");
                    }
                    else
                    {
                        $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                    }
                }
                else if(EMP_ENTRY_empdesig=='CLEANER'){
                    if((EMP_ENTRY_Firstname!='') && (EMP_ENTRY_Lastname!='' )&&( EMP_ENTRY_Mobileno!='' && (parseInt($('#EMP_ENTRY_tb_mobile').val())!=0)) && (EMP_ENTRY_Mobileno.length>=6)&& (EMP_ENTRY_empdesig!='SELECT'))
                    {
                        $("#EMP_ENTRY_btn_save").removeAttr("disabled");
                    }
                    else
                    {
                        $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                    }
                }
                else
                {
                    $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                }
            });
            //CHECK THE MOBILE NO//
            $('#EMP_ENTRY_tb_mobile').change(function()
            {
                var EMP_ENTRY_mobilenolength=$('#EMP_ENTRY_tb_mobile').val();
                if(EMP_ENTRY_mobilenolength.length<6)
                {

                    $('#EMP_ENTRY_tb_mobile').addClass('invalid');
                    $("#EMP_ENTRY_btn_save").attr("disabled","disabled");

                    $("#EMP_ENTRY_lbl_errmsg").text(EMP_ENTRY_error[21].EMC_DATA).show();
                }
                else
                {
                    $('#EMP_ENTRY_tb_mobile').removeClass('invalid');
                    $("#EMP_ENTRY_lbl_errmsg").hide();
                }
            });

            //CLICK EVENT FOR SAVE BUTTON
            $("#EMP_ENTRY_btn_save").click(function(){
                $(".preloader").show();
                var EMP_ENTRY_mobilenolength=$('#EMP_ENTRY_tb_mobile').val();
                if(EMP_ENTRY_mobilenolength.length<6 ||EMP_ENTRY_mobilenolength=="" )
                {
                    $(".preloader").hide();
                    $('#EMP_ENTRY_tb_mobile').addClass('invalid');
                    $("#EMP_ENTRY_btn_save").attr("disabled","disabled");
                    $("#EMP_ENTRY_lbl_errmsg").text(EMP_ENTRY_error[21].EMC_DATA).show();
                }
                else
                {
                    EMP_ENTRY_save_result()
                }
            });
            //SUCCESS FUNCTION FOR SAVE
            function EMP_ENTRY_save_result()
            {
                var EMP_ENTRY_firstname = $('#EMP_ENTRY_tb_firstname').val();
                var EMP_ENTRY_lastname = $('#EMP_ENTRY_tb_lastname').val();
                var EMP_ENTRY_empdesigname = $('#EMP_ENTRY_lb_empdesig').val();
                var EMP_ENTRY_mobilenumber = $('#EMP_ENTRY_tb_mobile').val();
                var EMP_ENTRY_email = $('#EMP_ENTRY_tb_email').val();
                var EMP_ENTRY_comments = $('#EMP_ENTRY_ta_comments').val();
                var EMP_ENTRY_radio_null=$('input:radio[name=EMP_ENTRY_radio_null]:checked').attr('id');
                var form_element = $('#EMP_ENTRY_form_employeename').serialize();
                $.ajax({
                    type: "POST",
                    url:EMP_ENTRY_controller_url+"EMP_ENTRY_save",
                    data:form_element+"&EMP_ENTRY_firstname="+EMP_ENTRY_firstname+"&EMP_ENTRY_lastname="+EMP_ENTRY_lastname+"&EMP_ENTRY_empdesigname="+EMP_ENTRY_empdesigname+"&EMP_ENTRY_mobilenumber="+EMP_ENTRY_mobilenumber+"&EMP_ENTRY_comments="+EMP_ENTRY_comments+"&EMP_ENTRY_radio_null="+EMP_ENTRY_radio_null,
                    success: function(data) {
                        $(".preloader").hide();
                        var result_value=JSON.parse(data);
                        var EMP_ENTRY_flagrslt=  result_value[0];
                        var EMP_ENTRY_multi_array=  result_value[1];
                        if(EMP_ENTRY_flagrslt==1)
                        {
                            EMP_ENTRY_multitreeview(EMP_ENTRY_multi_array);
                            //MESSAGE BOX FOR SAVED SUCCESS
                            show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[7].EMC_DATA,"success",false)
                            EMP_ENTRY_employeedetailrset();
                        }
                        else{
                            //MESSAGE BOX FOR NOT SAVED
                            if(EMP_ENTRY_flagrslt==0){
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[21].EMC_DATA,"error",false)
                            }
                            else
                            {
                               //CARD SHOULD NOT BE ASSIGNED
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_flagrslt,"error",false)
                            }
                        }
                    }
                });
            }
            //CLICK EVENT FUCNTION FOR RESET
            $('#EMP_ENTRY_btn_reset').click(function()
            {
                EMP_ENTRY_employeedetailrset()
            });

            function EMP_ENTRY_employeedetailrset()
            {
//                $("#EMP_ENTRY_form_employeename not:[name=optradio]")[0].reset();
                $('#EMP_ENTRY_tb_firstname').val('');
                $('#EMP_ENTRY_tb_lastname').val('');
                $('#EMP_ENTRY_tb_mobile').val('');
                $('#EMP_ENTRY_ta_comments').val('');
                $('#EMP_ENTRY_lb_empdesig').prop('selectedIndex',0);
                $("#EMP_ENTRY_btn_save").attr("disabled", "disabled");
                $('#EMP_ENTRY_lbl_validemailid').hide();
                $('#EMP_ENTRY_tble_avail_cardno').hide();
                $('#EMP_ENTRY_div_avail_cardno').hide();
                $("#EMP_ENTRY_tb_email").val('');
                $("#EMP_ENTRY_tb_email").removeClass('invalid');
                $('#EMP_ENTRY_tble_menu').hide();
                $('#EMP_ENTRY_tb_mobile').removeClass('invalid');
                $("#EMP_ENTRY_lbl_errmsg").hide();
                $('#EMP_ENTRY_lbl_error').hide();
                $('#EMP_ENTRY_table_errormsg').hide();
                $('.sizefix').prop("size","20");
                $('#EMP_ENTRY_lbl_cardno').hide();
                $('#card').hide();
                $('#EMP_ENTRY_nullcard').hide();
                $('#EMP_ENTRY_lbl_shwcardno').hide();
                $('#EMP_ENTRY_radio_selectcard').hide();
                $('#EMP_ENTRY_radio_null').hide();
                $('textarea').height(114);
            }
            //SEARCH FORM START
            //SEARCH BY ALL OPTIONS//
            $('#EMPSRC_UPD_DEL_lb_searchoption').change(function(){
                var  newPos= adjustPosition($(this).position(),100,270);
                resetPreloader(newPos);
                $(".preloader").show();
                $("textarea").height(116);
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
                $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_pdf').hide();
                $('#EMPSRC_UPD_DEL_lbl_employeename_listbox').hide();
                $('#EMPSRC_UPD_DEL_lb_employeename_listbox').hide();
                $('#EMPSRC_UPD_DEL_lbl_designation_listbox').hide();
                $('#EMPSRC_UPD_DEL_lb_designation_listbox').hide();
                $('#EMPSRC_UPD_DEL_lbl_comments').hide();
                $('#EMPSRC_UPD_DEL_ta_comments').hide();
                $('#STDTL_INPUT_lbl_email').hide();
                $('#EMPSRC_UPD_DEL_ta_email').hide();
                $('#STDTL_INPUT_lbl_mobile').hide();
                $('#EMPSRC_UPD_DEL_ta_mobile').hide();
                $('#EMPSRC_UPD_DEL_btn_search_autocomplt').attr("disabled", "disabled");
                $('#EMPSRC_UPD_DEL_btn_search_autocomplt').hide();
                var EMPSRC_UPD_DEL_search_option = $(this).val();
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                if(EMPSRC_UPD_DEL_search_option=='SELECT')
                {
                    $(".preloader").hide();
                    $('#EMPSRC_UPD_DEL_lbl_employeename_listbox').hide();
                    $('#EMPSRC_UPD_DEL_lb_employeename_listbox').hide();
                    $('#EMPSRC_UPD_DEL_lbl_designation_listbox').hide();
                    $('#EMPSRC_UPD_DEL_lb_designation_listbox').hide();
                    $('#EMPSRC_UPD_DEL_lbl_comments').hide();
                    $('#EMPSRC_UPD_DEL_ta_comments').hide();
                    $('#STDTL_INPUT_lbl_email').hide();
                    $('#EMPSRC_UPD_DEL_ta_email').hide();
                    $('#STDTL_INPUT_lbl_mobile').hide();
                    $('#EMPSRC_UPD_DEL_ta_mobile').hide();
                    $('#EMPSRC_UPD_DEL_btn_search_autocomplt').hide();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').hide();
                }
                if(EMPSRC_UPD_DEL_search_option==95)//DESIGNATION
                {
                    $('#EMPSRC_UPD_DEL_lbl_designation_listbox').show();
                    $('#EMPSRC_UPD_DEL_lb_designation_listbox').show().focus();
                    $('#EMPSRC_UPD_DEL_lb_designation_listbox').val('SELECT');
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $('EMPSRC_UPD_DEL_tble_email_option').hide();
                    $(".preloader").hide();
                }
                if(EMPSRC_UPD_DEL_search_option==90)//EMPLOYEE NAME
                {
                    $('#EMPSRC_UPD_DEL_lbl_employeename_listbox').show();
                    $('#EMPSRC_UPD_DEL_lb_employeename_listbox').show();
                    $('#EMPSRC_UPD_DEL_lb_employeename_listbox').val('SELECT').focus();
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $(".preloader").hide();
                }
                if(EMPSRC_UPD_DEL_search_option==96)//EMAIL
                {
                    EMPSRC_UPD_DEL_autocomplts_autocompleteresult()
                    $('#STDTL_INPUT_lbl_email').show();
                    $('#EMPSRC_UPD_DEL_ta_email').show().focus();
                    $('#EMPSRC_UPD_DEL_btn_search_autocomplt').show();
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_ta_email').val('');
                    $(".preloader").hide();
                }
                if(EMPSRC_UPD_DEL_search_option==99)//MOBILE NO
                {
                    EMPSRC_UPD_DEL_autocomplts_autocompleteresult()
                    $('#STDTL_INPUT_lbl_mobile').show();
                    $('#EMPSRC_UPD_DEL_ta_mobile').show().focus();
                    $('#EMPSRC_UPD_DEL_btn_search_autocomplt').show();
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_ta_mobile').val('');
                    $(".preloader").hide();
                }
                if(EMPSRC_UPD_DEL_search_option==94)//COMMENTS
                {
                    EMPSRC_UPD_DEL_autocomplts_autocompleteresult()
                    $('#EMPSRC_UPD_DEL_btn_search_autocomplt').show();
                    var EMPSRC_UPD_DEL_searchheader=$('#EMPSRC_UPD_DEL_lb_searchoption').find('option:selected').text();
                    $('#EMPSRC_UPD_DEL_lbl_searchoptionheader').text(EMPSRC_UPD_DEL_searchheader).show();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_ta_comments').val('');
                    $('#EMPSRC_UPD_DEL_lbl_comments').show();
                    $('#EMPSRC_UPD_DEL_ta_comments').show().focus();
                    $(".preloader").hide();
                }
            });
            //CHANGE EVENT FUNCTION FOR EMPLOYEE DESIGNATION
            $('#EMPSRC_UPD_DEL_lb_designation_listbox').change(function(){
                $(".preloader").show();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_pdf').show();
                var EMPSRC_UPD_DEL_designation = $("#EMPSRC_UPD_DEL_lb_designation_listbox").val();
                if(EMPSRC_UPD_DEL_designation=='SELECT')
                {
                    $(".preloader").hide();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                }
                else
                {
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    EMPSRC_UPD_DEL_srch_result()
                }
            });
            //CHANGE EVENT FUNCTION FOR EMPLOYEE NAME
            $('#EMPSRC_UPD_DEL_lb_employeename_listbox').change(function(){
                $(".preloader").show();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_pdf').hide();
                var EMPSRC_UPD_DEL_employeename = $("#EMPSRC_UPD_DEL_lb_employeename_listbox").val();
                if(EMPSRC_UPD_DEL_employeename=='SELECT')
                {
                    $(".preloader").hide();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                }
                else
                {
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    EMPSRC_UPD_DEL_srch_result()
                }
            });
            //CHANGE EVENT FUNCTION FOR COMMENTS
            $( "#EMPSRC_UPD_DEL_ta_comments" ).change(function()
            {
                $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
            });
            //CHANGE EVENT FUNCTION FOR EMAIL
            $( "#EMPSRC_UPD_DEL_ta_email" ).change(function()
            {
                $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide();
            });
            //CHANGE EVENT FUNCTION FOR MOBILE
            $(document).on('change blur','#EMPSRC_UPD_DEL_ta_mobile',function()
//            $( "#EMPSRC_UPD_DEL_ta_mobile" ).change(function()
            {
                $('#EMPSRC_UPD_DEL_btn_search_autocomplt').show();
                $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                $('#EMPSRC_UPD_DEL_table_updateform').hide();
                $('#EMPSRC_UPD_DEL_deletebutton').hide();
                $('#EMPSRC_UPD_DEL_searchbutton').hide()
                $('#EMPSRC_UPD_DEL_pdf').hide();

            });
            //FUNCTION TO AUTOCOMPLETE SEARCH TEXT
            var EMPSRC_UPD_DEL_comments=[];
            var EMPSRC_UPD_DEL_email=[];
            var EMPSRC_UPD_DEL_mobile=[];
            var EMPSRC_UPD_DEL_autocomplt_flag;
            var EMPSRC_UPD_DEL_auto=[];
            function EMPSRC_UPD_DEL_autocomplts_autocompleteresult()
            {
                EMPSRC_UPD_DEL_autocomplt_flag=$('#EMPSRC_UPD_DEL_lb_searchoption').val();
                var form_element = $('#EMP_ENTRY_form_employeename').serialize();
                $.ajax({
                    type: "POST",
                    url:EMP_ENTRY_controller_url+"EMPSRC_UPD_DEL_comments",
                    data:form_element,
                    success: function(data){
                        $('.preloader').hide();
                        $('#STDTL_SEARCH_div_headernodata').hide();
                        EMPSRC_UPD_DEL_auto=JSON.parse(data);
                        EMPSRC_UPD_DEL_comments=EMPSRC_UPD_DEL_auto
                        //KEY PRESS FUNCTION
                        $(".keypressvalid").keypress(function(){
                            EMPSRC_UPD_DEL_highlightSearchText();
                            if(EMPSRC_UPD_DEL_autocomplt_flag==94)//COMMENTS
                            {
                                $( "#EMPSRC_UPD_DEL_ta_comments" ).autocomplete({
                                    source: EMPSRC_UPD_DEL_comments,
                                    select: EMPSRC_UPD_DEL_AutoCompleteSelectHandler
                                });
                            }
                            if(EMPSRC_UPD_DEL_autocomplt_flag==96)//EMAIL
                            {
                                $("#EMPSRC_UPD_DEL_ta_email").autocomplete({
                                    source: EMPSRC_UPD_DEL_comments,
                                    select: EMPSRC_UPD_DEL_AutoCompleteSelectHandler
                                });
                            }
                            else if(EMPSRC_UPD_DEL_autocomplt_flag==99)//MOBILE NO
                            {
                                $("#EMPSRC_UPD_DEL_ta_mobile").autocomplete({
                                    source: EMPSRC_UPD_DEL_comments,
                                    select: EMPSRC_UPD_DEL_AutoCompleteSelectHandler
                                });
                            }
                        });
                    }
                });
            }
            //CHANGE FUNCTION FOR COMMENTS
            var EMPSRC_UPD_DEL_chkflag;
            $(document).on('change ','.commentsresultsvalidate',function(){
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                var EMPSRC_UPD_DEL_search_option = $('#EMPSRC_UPD_DEL_lb_searchoption').val();
                if(EMPSRC_UPD_DEL_search_option==94)//COMMENTS
                {
                    var EMPSRC_UPD_DEL_empcomments=$("#EMPSRC_UPD_DEL_btn_search_autocomplt").val();
                    var EMPSRC_UPD_DEL_empcommentstxt=$('#EMPSRC_UPD_DEL_ta_comments').val();
                    var EMPSRC_UPD_DEL_conformsg=EMPSRC_UPD_DEL_flexheader_array[3];
                    var EMPSRC_UPD_DEL_errormsg=EMPSRC_UPD_DEL_conformsg.replace('[COMMENTS]',EMPSRC_UPD_DEL_empcommentstxt);
                }
                else if(EMPSRC_UPD_DEL_search_option==96)//EMAIL
                {
                    var EMPSRC_UPD_DEL_empemailtxt=$('#EMPSRC_UPD_DEL_ta_email').val();
                    var EMPSRC_UPD_DEL_conformsg=EMPSRC_UPD_DEL_flexheader_array[11];
                    var EMPSRC_UPD_DEL_errormsg=EMPSRC_UPD_DEL_conformsg.replace('[EMAIL]',EMPSRC_UPD_DEL_empemailtxt);
                }
                else if(EMPSRC_UPD_DEL_search_option==99)//MOBILE NO
                {
                    var EMPSRC_UPD_DEL_empmobiletxt=$('#EMPSRC_UPD_DEL_ta_mobile').val();
                    var EMPSRC_UPD_DEL_conformsg=EMPSRC_UPD_DEL_flexheader_array[13];
                    var EMPSRC_UPD_DEL_errormsg=EMPSRC_UPD_DEL_conformsg.replace('[MOBILE NO]',EMPSRC_UPD_DEL_empmobiletxt);
                }
                if(EMPSRC_UPD_DEL_chkflag==1){
                    $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                }
                else
                {
                    $('#EMPSRC_UPD_DEL_nodataerrormsg').text(EMPSRC_UPD_DEL_errormsg).show();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                    $("#EMPSRC_UPD_DEL_btn_search_autocomplt").attr("disabled","disabled");
                }
                if($(this).val()=="")
                {
                    $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                    $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').hide();
                    $('#EMPSRC_UPD_DEL_tble_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_div_htmltable').hide();
                    $('#EMPSRC_UPD_DEL_table_updateform').hide();
                    $('#EMPSRC_UPD_DEL_searchbutton').hide();
                    $("#EMPSRC_UPD_DEL_btn_search_autocomplt").attr("disabled","disabled");
                }
            });
            //FUNCTION TO GET SELECTED VALUE
            function EMPSRC_UPD_DEL_AutoCompleteSelectHandler(event, ui) {
                $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                $('#EMPSRC_UPD_DEL_btn_search_autocomplt').removeAttr("disabled");
            }

            //FUNCTION TO HIGHLIGHT SEARCH TEXT
            function EMPSRC_UPD_DEL_highlightSearchText() {
                $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                    var re = new RegExp(this.term, "i") ;
                    var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + t + "</a>" )
                        .appendTo( ul );
                };
            }
            //CLICK FUNCTION FOR AUTO SEARCH BUTTON
            $('#EMPSRC_UPD_DEL_btn_search_autocomplt').click(function(){
                var EMPSRC_UPD_DEL_empcommentstxt=$('#EMPSRC_UPD_DEL_ta_comments').val();
                var EMPSRC_UPD_DEL_empemailtxt=$('#EMPSRC_UPD_DEL_ta_email').val();
                var EMPSRC_UPD_DEL_empmobilenotxt=$('#EMPSRC_UPD_DEL_ta_mobile').val();
                if((EMPSRC_UPD_DEL_empcommentstxt!="")||(EMPSRC_UPD_DEL_empemailtxt!="")||(EMPSRC_UPD_DEL_empmobilenotxt!=""))
                {
                    $(".preloader").show();
                    EMPSRC_UPD_DEL_srch_result()
                }
            });
            //SUCCESS FUNCTION FOR SELECTING DATA
            var EMPSRC_UPD_DEL_result_array;
            var id;var comments;var EMPSRC_UPD_DEL_unitno;var EMPSRC_UPD_DEL_emailid;var cardnumber;
            var EMPSRC_UPD_DEL_fname;var EMPSRC_UPD_DEL_lname;var EMPSRC_UPD_DEL_mobileno;var EMPSRC_UPD_DEL_destination;
            function EMPSRC_UPD_DEL_srch_result()
            {
                var EMPSRC_UPD_DEL_employeenameconcat = $('#EMPSRC_UPD_DEL_lb_employeename_listbox').val()
                var EMPSRC_UPD_DEL_lb_designation_listbox=$('#EMPSRC_UPD_DEL_lb_designation_listbox').find('option:selected').text();
                var EMPSRC_UPD_DEL_employeenameconcat =EMPSRC_UPD_DEL_employeenameconcat.split(' ');
                var emp_first_name=EMPSRC_UPD_DEL_employeenameconcat[0]
                var emp_last_name=EMPSRC_UPD_DEL_employeenameconcat[1]
                var EMPSRC_UPD_DEL_search_option = $('#EMPSRC_UPD_DEL_lb_searchoption').val();
                var form_element = $('#EMP_ENTRY_form_employeename').serialize();
                $.ajax({
                    type: "POST",
                    url:EMP_ENTRY_controller_url+"fetchdata",
                    data:form_element+"&EMPSRC_UPD_DEL_lb_designation_listbox="+EMPSRC_UPD_DEL_lb_designation_listbox+"&emp_first_name="+emp_first_name+"&emp_last_name="+emp_last_name,
                    success: function(data) {
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        EMPSRC_UPD_DEL_result_array = JSON.parse(data);
                        if (EMPSRC_UPD_DEL_result_array.length == 0) {
                            if (EMPSRC_UPD_DEL_search_option == 95)//DESIGNATION
                            {
                                var EMPSRC_UPD_DEL_designation_listbox = $('#EMPSRC_UPD_DEL_lb_designation_listbox').find('option:selected').text();
                                var EMPSRC_UPD_DEL_flexmsg = EMP_ENTRY_error[10].EMC_DATA;
                                var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[DESIGNATION]', EMPSRC_UPD_DEL_designation_listbox);
                            }
                            if (EMPSRC_UPD_DEL_search_option == 90)//EMPLOYEE NAME
                            {
                                var EMPSRC_UPD_DEL_employeename = $('#EMPSRC_UPD_DEL_lb_employeename_listbox').val();
                                var EMPSRC_UPD_DEL_flemployeename = emp_first_name + " " + emp_last_name;
                                var EMPSRC_UPD_DEL_flexmsg = EMP_ENTRY_error[5].EMC_DATA;
                                var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[FNAME+LNAME]', EMPSRC_UPD_DEL_flemployeename);
                            }
                            if (EMPSRC_UPD_DEL_search_option == 94)//COMMENTS
                            {
                                var EMPSRC_UPD_DEL_empcomments = $("#EMPSRC_UPD_DEL_btn_search_autocomplt").val();
                                var EMPSRC_UPD_DEL_empcommentstxt = $('#EMPSRC_UPD_DEL_ta_comments').val();
                                var EMPSRC_UPD_DEL_getflexmsg = EMP_ENTRY_error[3].EMC_DATA.replace('[COMMENTS]', EMPSRC_UPD_DEL_empcommentstxt);
                            }
                            if (EMPSRC_UPD_DEL_search_option == 96)//EMAILID
                            {
                                var EMPSRC_UPD_DEL_empemailtxt = $('#EMPSRC_UPD_DEL_ta_email').val();
                                var EMPSRC_UPD_DEL_getflexmsg = EMP_ENTRY_error[12].EMC_DATA.replace('[EMAIL]', EMPSRC_UPD_DEL_empemailtxt);
                            }
                            if (EMPSRC_UPD_DEL_search_option == 99)//MOBILE NO
                            {
                                var EMPSRC_UPD_DEL_empmobiletxt = $('#EMPSRC_UPD_DEL_ta_mobile').val();
                                var EMPSRC_UPD_DEL_getflexmsg = EMP_ENTRY_error[14].EMC_DATA.replace('[MOBILE NO]', EMPSRC_UPD_DEL_empmobiletxt);
                            }
                            $('#EMPSRC_UPD_DEL_nodataerrormsg').text(EMPSRC_UPD_DEL_getflexmsg).show();
                        }
                        else {
                            $('#EMPSRC_UPD_DEL_nodataerrormsg').hide();
                            if (EMPSRC_UPD_DEL_search_option == 90)//EMPLOYEE NAME
                            {
                                var EMPSRC_UPD_DEL_employeename = $('#EMPSRC_UPD_DEL_lb_employeename_listbox').val();

                                var EMPSRC_UPD_DEL_flemployeename = emp_first_name + " " + emp_last_name;
                                var EMPSRC_UPD_DEL_flexmsg = EMP_ENTRY_error[4].EMC_DATA;
                                var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[FNAME+LNAME]', EMPSRC_UPD_DEL_flemployeename);
                            }
                            if (EMPSRC_UPD_DEL_search_option == 95)//DESIGNATION
                            {
                                var EMPSRC_UPD_DEL_designation_listbox = $('#EMPSRC_UPD_DEL_lb_designation_listbox').find('option:selected').text();

                                var EMPSRC_UPD_DEL_flexmsg = EMP_ENTRY_error[9].EMC_DATA
                                var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[DESIGNATION]', EMPSRC_UPD_DEL_designation_listbox);
                            }
                            if (EMPSRC_UPD_DEL_search_option == 94)//COMMENTS
                            {
                                var EMPSRC_UPD_DEL_comments = $('#EMPSRC_UPD_DEL_ta_comments').val();
                                var EMPSRC_UPD_DEL_flexmsg = EMP_ENTRY_error[8].EMC_DATA
                                var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[COMTS]', EMPSRC_UPD_DEL_comments);
                            }
                            if (EMPSRC_UPD_DEL_search_option == 96)//EMAIL
                            {
                                var EMPSRC_UPD_DEL_email = $('#EMPSRC_UPD_DEL_ta_email').val();
                                var EMPSRC_UPD_DEL_flexmsg = EMP_ENTRY_error[11].EMC_DATA
                                var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[EMAIL]', EMPSRC_UPD_DEL_email);
                            }
                            if (EMPSRC_UPD_DEL_search_option == 99)//MOBILE NO
                            {
                                var EMPSRC_UPD_DEL_mobile = $('#EMPSRC_UPD_DEL_ta_mobile').val();
                                var EMPSRC_UPD_DEL_flexmsg = EMP_ENTRY_error[13].EMC_DATA;
                                var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[MOBILE NO]', EMPSRC_UPD_DEL_mobile);
                            }
                            $('#EMPSRC_UPD_DEL_lbl_htmltablemsg').text(EMPSRC_UPD_DEL_getflexmsg).show();
                            var EMPSRC_UPD_DEL_value = '';
                            var EMPSRC_UPD_DEL_header = '<table id="EMPSRC_UPD_DEL_tble_htmltable" border="1"  cellspacing="0" class="srcresult"  ><thead  bgcolor="#6495ed" style="color:white" width="1500"><tr><th>EDIT/DELETE</th><th style="width:80px">FIRST NAME</th><th style="width:80px">LAST NAME</th><th style="width:80px">MOBILE</th><th style="width:80px">EMAIL</th><th style="width:80px">DESIGNATION</th><th style="width:80px">UNIT NO</th><th style="width:80px">CARD NUMBER</th><th style="width:250px">COMMENTS</th><th style="width:200px">USERSTAMP</th><th style="width:150px">TIMESTAMP</th></tr></thead><tbody>'
                            for (var j = 0; j < EMPSRC_UPD_DEL_result_array.length; j++) {
                                var EMPSRC_UPD_DEL_values = EMPSRC_UPD_DEL_result_array[j]
                                id = EMPSRC_UPD_DEL_result_array[j].ID
                                EMPSRC_UPD_DEL_fname = EMPSRC_UPD_DEL_result_array[j].Femployeename
                                EMPSRC_UPD_DEL_lname = EMPSRC_UPD_DEL_result_array[j].Lemployeename
                                EMPSRC_UPD_DEL_mobileno = EMPSRC_UPD_DEL_result_array[j].mobile
                                EMPSRC_UPD_DEL_destination = EMPSRC_UPD_DEL_result_array[j].designation

                                comments = EMPSRC_UPD_DEL_result_array[j].comments
                                if ((comments == 'null') || (comments == undefined)) {
                                    comments = '';
                                }
                                EMPSRC_UPD_DEL_unitno = EMPSRC_UPD_DEL_result_array[j].EMPSRC_UPD_DEL_unitno
                                if ((EMPSRC_UPD_DEL_unitno == 'null') || (EMPSRC_UPD_DEL_unitno == undefined)) {
                                    EMPSRC_UPD_DEL_unitno = '';
                                }
                                EMPSRC_UPD_DEL_emailid = EMPSRC_UPD_DEL_result_array[j].email
                                if ((EMPSRC_UPD_DEL_emailid == 'null') || (EMPSRC_UPD_DEL_emailid == undefined)) {
                                    EMPSRC_UPD_DEL_emailid = '';
                                }
                                cardnumber = EMPSRC_UPD_DEL_result_array[j].cardnumber
                                if ((cardnumber == 'null') || (cardnumber == undefined)) {
                                    cardnumber = '';
                                }
                                EMPSRC_UPD_DEL_header += '<tr><td><div class="col-lg-1"><span style="display: block;color:green" class="glyphicon glyphicon-edit emp_editbutton" id=' + id + ' title="Edit"></div><div class="col-lg-1"><span style="display: block;color:red" class="glyphicon glyphicon-trash deletebutton" id=' + id + ' title="Delete"></div></td><td>' + EMPSRC_UPD_DEL_fname + '</td><td>' + EMPSRC_UPD_DEL_lname + '</td><td>' + EMPSRC_UPD_DEL_mobileno + '</td><td>' + EMPSRC_UPD_DEL_emailid + '</td><td>' + EMPSRC_UPD_DEL_destination + '</td><td>' + EMPSRC_UPD_DEL_unitno + '</td><td>' + cardnumber + '</td><td>' + comments + '</td><td>' + EMPSRC_UPD_DEL_values.userstamp + '</td><td>' + EMPSRC_UPD_DEL_values.timestamp + '</td></tr>';
                            }
                            EMPSRC_UPD_DEL_header += '</tbody></table>';
                            $('section').html(EMPSRC_UPD_DEL_header);
                            $('#EMPSRC_UPD_DEL_tble_htmltable').DataTable({
                                "aaSorting": [],
                                "pageLength": 10,
                                "sPaginationType": "full_numbers"
                            });
                            $('#EMPSRC_UPD_DEL_div_htmltable').show();
                            $('#EMPSRC_UPD_DEL_pdf').show();
                        }
                    },
                    error:function(data){
                        alert(JSON.stringify(data))
                    }


                });

            }
            $(document).on('click','#EMPSRC_UPD_DEL_btn_pdf',function(){
                var EMPSRC_UPD_DEL_search_option = $('#EMPSRC_UPD_DEL_lb_searchoption').val();
                if(EMPSRC_UPD_DEL_search_option==90)//EMPLOYEE NAME
                {
                    var EMPSRC_UPD_DEL_employeename=$('#EMPSRC_UPD_DEL_lb_employeename_listbox').val();
                    var EMPSRC_UPD_DEL_employeenameconcat =EMPSRC_UPD_DEL_employeename.split(' ');
                    var emp_first_name=EMPSRC_UPD_DEL_employeenameconcat[0]
                    var emp_last_name=EMPSRC_UPD_DEL_employeenameconcat[1]
                    var EMPSRC_UPD_DEL_flemployeename=emp_first_name+" "+emp_last_name;
                    var EMPSRC_UPD_DEL_flexmsg=EMP_ENTRY_error[4].EMC_DATA;
                    var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[FNAME+LNAME]', EMPSRC_UPD_DEL_flemployeename);
                }
                if(EMPSRC_UPD_DEL_search_option==95)//DESIGNATION
                {
                    var EMPSRC_UPD_DEL_designation_listbox=$('#EMPSRC_UPD_DEL_lb_designation_listbox').find('option:selected').text();

                    var EMPSRC_UPD_DEL_flexmsg=EMP_ENTRY_error[9].EMC_DATA
                    var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[DESIGNATION]', EMPSRC_UPD_DEL_designation_listbox);
                }
                if(EMPSRC_UPD_DEL_search_option==94)//COMMENTS
                {
                    var EMPSRC_UPD_DEL_comments=$('#EMPSRC_UPD_DEL_ta_comments').val();
                    var EMPSRC_UPD_DEL_flexmsg=EMP_ENTRY_error[8].EMC_DATA
                    var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[COMTS]', EMPSRC_UPD_DEL_comments);
                }
                if(EMPSRC_UPD_DEL_search_option==96)//EMAIL
                {
                    var EMPSRC_UPD_DEL_email=$('#EMPSRC_UPD_DEL_ta_email').val();
                    var EMPSRC_UPD_DEL_flexmsg=EMP_ENTRY_error[11].EMC_DATA
                    var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[EMAIL]', EMPSRC_UPD_DEL_email);
                }
                if(EMPSRC_UPD_DEL_search_option==99)//MOBILE NO
                {
                    var EMPSRC_UPD_DEL_mobile=$('#EMPSRC_UPD_DEL_ta_mobile').val();
                    var EMPSRC_UPD_DEL_flexmsg=EMP_ENTRY_error[13].EMC_DATA;
                    var EMPSRC_UPD_DEL_getflexmsg = EMPSRC_UPD_DEL_flexmsg.replace('[MOBILE NO]', EMPSRC_UPD_DEL_mobile);
                }

                var pdfurl=document.location.href='<?php echo site_url('EXPENSE/STAFF/Ctrl_Staff_Employee_Entry_Search_Update_Delete/EMPLOYEE_pdf')?>?EMPSRC_UPD_DEL_lb_designation_listbox='+EMPSRC_UPD_DEL_designation_listbox+'&emp_first_name='+emp_first_name+'&emp_last_name='+emp_last_name+'&EMPSRC_UPD_DEL_ta_mobile='+EMPSRC_UPD_DEL_mobile+'&EMPSRC_UPD_DEL_lb_employeename_listbox='+EMPSRC_UPD_DEL_employeenameconcat+'&EMPSRC_UPD_DEL_lb_searchoption='+EMPSRC_UPD_DEL_search_option+'&EMPSRC_UPD_DEL_ta_email='+EMPSRC_UPD_DEL_email+'&EMPSRC_UPD_DEL_ta_comments='+EMPSRC_UPD_DEL_comments+'&header='+EMPSRC_UPD_DEL_getflexmsg;


            });
            var currentid
            //CLICK EVENT FUCNTION FOR edit SEARCH
            $(document).on('click','.emp_editbutton',function(){
                currentid = $(this).attr('id');
                $('.preloader').show();
                $("textarea").height(114);
                $("#EMPSRC_UPD_DEL_lbl_errmsg").hide();
                $('#EMPSRC_UPD_DEL_tb_mobile').removeClass('invalid');
                $('#EMPSRC_UPD_DEL_lbl_validemailid').hide();
                $("#EMPSRC_UPD_DEL_tb_email").removeClass('invalid');
                $("#EMPSRC_UPD_DEL_lbl_errmsg").hide();
                $('#EMPSRC_UPD_DEL_tb_mobile').removeClass('invalid');
                EMPSRC_UPD_DEL_updatefunction(currentid)
            });
            var EMPSRC_UPD_DEL_result=[];
            var EMPSRC_UPD_DEL_radiovalue;
            function EMPSRC_UPD_DEL_updatefunction(currentid)
            {
                $("textarea").height(116);
                $.ajax({
                    type: "POST",
                    url:EMP_ENTRY_controller_url+"EMPSRC_UPD_DEL_getcardnoandunitno",
                    data :{'EMPSRC_UPD_DEL_id':currentid},
                    success: function(data){
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        EMPSRC_UPD_DEL_result=JSON.parse(data);
                        var EMPSRC_UPD_DEL_getallunitno=[];
                        var EMPSRC_UPD_DEL_getallcardno=[];
                        EMPSRC_UPD_DEL_getallunitno=EMPSRC_UPD_DEL_result[0];
                        EMPSRC_UPD_DEL_getallcardno=EMPSRC_UPD_DEL_result[1];
                        EMPSRC_UPD_DEL_multi_array=EMPSRC_UPD_DEL_result[2];
                        if((EMPSRC_UPD_DEL_getallunitno!="")&&(EMPSRC_UPD_DEL_getallunitno!=null))
                        {
                            $('input:radio[name=EMPSRC_UPD_DEL_selectcard][value=CARD]').attr('checked', true);
                            EMPSRC_UPD_DEL_updatemultitreeview(EMPSRC_UPD_DEL_multi_array ,EMPSRC_UPD_DEL_getallunitno,EMPSRC_UPD_DEL_getallcardno)
                        }
                        else if(EMPSRC_UPD_DEL_getallunitno=="")
                        {
                            $('#EMPSRC_UPD_DEL_tble_menu').hide();
                            $('input:radio[name=EMPSRC_UPD_DEL_selectcard][value=NULL]').attr('checked', true);
                        }
                    }
                });
                EMPSRC_UPD_DEL_radiovalue = $('input:radio[name=EMPSRC_UPD_DEL_radio_empdetail]:checked').val();
                for(var j=0;j<EMPSRC_UPD_DEL_result_array.length;j++){
                    var id=EMPSRC_UPD_DEL_result_array[j].ID;
                    if(id==currentid)
                    {
                        EMPSRC_UPD_DEL_fname=EMPSRC_UPD_DEL_result_array[j].Femployeename
                        EMPSRC_UPD_DEL_lname=EMPSRC_UPD_DEL_result_array[j].Lemployeename
                        EMPSRC_UPD_DEL_mobileno=EMPSRC_UPD_DEL_result_array[j].mobile
                        EMPSRC_UPD_DEL_destination=EMPSRC_UPD_DEL_result_array[j].designation
                        comments=EMPSRC_UPD_DEL_result_array[j].comments
                        EMPSRC_UPD_DEL_unitno=EMPSRC_UPD_DEL_result_array[j].EMPSRC_UPD_DEL_unitno
                        EMPSRC_UPD_DEL_emailid=EMPSRC_UPD_DEL_result_array[j].email
                        cardnumber=EMPSRC_UPD_DEL_result_array[j].cardnumber
                        $('#EMPSRC_UPD_DEL_table_updateform').show();
                        $('#EMPSRC_UPD_DEL_tb_updateid').val(EMPSRC_UPD_DEL_radiovalue).hide();
                        $('#EMPSRC_UPD_DEL_lbl_firstname').show();
                        $('#EMPSRC_UPD_DEL_tb_firstname').val(EMPSRC_UPD_DEL_fname).show();
                        $('#EMPSRC_UPD_DEL_lbl_lastname').show();
                        $('#EMPSRC_UPD_DEL_tb_lastname').val(EMPSRC_UPD_DEL_lname).show();
                        $('#EMPSRC_UPD_DEL_lbl_empdesig').show();
                        $('#EMPSRC_UPD_DEL_lb_empdesig').val(EMPSRC_UPD_DEL_destination).show();
                        $('#EMPSRC_UPD_DEL_lbl_mobile').show();
                        $('#EMPSRC_UPD_DEL_tb_mobile').val(EMPSRC_UPD_DEL_mobileno).show();
                        $('#EMPSRC_UPD_DEL_lbl_email').show();
                        $('#EMPSRC_UPD_DEL_tb_email').val(EMPSRC_UPD_DEL_emailid).show();
                        $('#EMPSRC_UPD_DEL_lbl_updatecomments').show();
                        $('#EMPSRC_UPD_DEL_ta_updatecomments').val(comments).show();
                        $('#EMPSRC_UPD_DEL_tb_firstnamehide').val(EMPSRC_UPD_DEL_fname).hide();
                        $('#EMPSRC_UPD_DEL_tb_lastnamehide').val(EMPSRC_UPD_DEL_lname).hide();
                        $('#EMPSRC_UPD_DEL_btn_update').show();
                        $('#EMPSRC_UPD_DEL_btn_update').attr("disabled", "disabled");
                        $('#EMPSRC_UPD_DEL_btn_reset').show();
                        if(EMPSRC_UPD_DEL_destination=='STAFF'){
                            $('#cardupd').show();
                            $('#EMPSRC_UPD_DEL_table_updateform').show();
                            $('#EMPSRC_UPD_DEL_lbl_cardno').show();
                            $('#EMPSRC_UPD_DEL_div_avail_cardno').show();
                            $('#EMPSRC_UPD_DEL_tble_avail_cardno').show();
                            $('#EMPSRC_UPD_DEL_radio_null').show();
                            $('#EMPSRC_UPD_DEL_lbl_cardno').show();
                            $('#EMPSRC_UPD_DEL_nullcard').show();
                            $('#EMPSRC_UPD_DEL_lbl_shwcardno').show();
                            $('#EMPSRC_UPD_DEL_radio_selectcard').show();
                        }
                        else{
                            $('#EMPSRC_UPD_DEL_lbl_cardno').hide();
                            $('#cardupd').hide();
                            $('#EMPSRC_UPD_DEL_div_avail_cardno').hide();
                            $('#EMPSRC_UPD_DEL_tble_avail_cardno').hide();
                            $('#EMPSRC_UPD_DEL_radio_null').hide();
                            $('#EMPSRC_UPD_DEL_lbl_cardno').hide();
                            $('#EMPSRC_UPD_DEL_nullcard').hide();
                            $('#EMPSRC_UPD_DEL_lbl_shwcardno').hide();
                            $('#EMPSRC_UPD_DEL_radio_selectcard').hide();
                        }
                        $('#EMPSRC_UPD_DEL_lbl_error').show();
                    }
                }
            }
            //SHOW THE UPDATE TREE VIEW//
            function EMPSRC_UPD_DEL_updatemultitreeview(EMPSRC_UPD_DEL_multi_arraynew ,EMPSRC_UPD_DEL_unitno,EMPSRC_UPD_DEL_multi_cardno)
            {$(".preloader").hide();
                var EMPSRC_UPD_DEL_unitno=EMPSRC_UPD_DEL_unitno;
                var EMPSRC_UPD_DEL_cardno=EMPSRC_UPD_DEL_multi_cardno;
                $('#EMPSRC_UPD_DEL_tb_checkcard').val(EMPSRC_UPD_DEL_cardno);
                if((EMPSRC_UPD_DEL_multi_arraynew.length)==0)
                {
                    EMPSRC_UPD_DEL_multi_array=EMPSRC_UPD_DEL_multi_arraynew;
                }else
                {
                    var EMPENTRY_multi_array=[];
                    EMPENTRY_multi_array=EMPSRC_UPD_DEL_multi_arraynew
                    EMPSRC_UPD_DEL_multi_array=EMPENTRY_multi_array;
                }
                if(EMPSRC_UPD_DEL_multi_array.length==0 || EMPSRC_UPD_DEL_multi_array.length==null)
                {
                    $('#EMPSRC_UPD_DEL_lbl_cardno').hide();
                    $('#EMPSRC_UPD_DEL_lbl_error').text(EMPSRC_UPD_DEL_flexheader_array[2]).show();
                }
                else
                {
                    $('#EMPSRC_UPD_DEL_lbl_error').hide();
                    //SHOW TREE VIEW FORMATE//
                    $('#EMPSRC_UPD_DEL_lbl_cardno').show();
                    $("#EMPSRC_UPD_DEL_tble_menu").replaceWith("<table id ='EMPSRC_UPD_DEL_tble_menu'></table>");
                    var EMPSRC_UPD_DEL_menu=''
                    for (var j = 0; j < EMPSRC_UPD_DEL_multi_array[0].length; j++) {
                        var id="EMPSRC_UPD_DEL_tble_submenu"+j;
                        var id1="menu"+"_"+j;
                        var id2="sub"+j;
                        var id_menu=j+'m'
                        var mainmenuid=j;
                        EMPSRC_UPD_DEL_menu = '<div ><ul style="list-style: none;" ><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input value="+" type="button"  id='+id1+' height="5" width="5" class="exp" /><input type="checkbox" name="menu" id='+id_menu+' value='+EMPSRC_UPD_DEL_multi_array[0][j]+' level="parent" class="tree empsubmitvalidatupd"  />' + EMPSRC_UPD_DEL_multi_array[0][j] + '</td></tr>';//+"_"+j+
                        EMPSRC_UPD_DEL_menu+='<div id='+id2+' hidden ><tr><td><table id='+id+' class="EMPSRC_UPD_DEL_class_submenu"  ></table></tr></div></li></ul></div>';
                        $('#EMPSRC_UPD_DEL_tble_menu').append(EMPSRC_UPD_DEL_menu);
                        for(var u1=0;u1<EMPSRC_UPD_DEL_unitno.length;u1++){
                            if(EMPSRC_UPD_DEL_multi_array[0][j]==EMPSRC_UPD_DEL_unitno[u1]){
                                $('#'+EMPSRC_UPD_DEL_multi_array[0][j]+"_"+j).prop("checked", true)
                            }
                        }
                        var EMPSRC_UPD_DEL_submenu='';
                        var submenulength=EMPSRC_UPD_DEL_multi_array[j+1].length;
                        for (var j1 = 0; j1 < EMPSRC_UPD_DEL_multi_array[j+1].length; j1++) {
                            var id3="EMPSRC_UPD_DEL_tble_submenu1"+j1;
                            var submenuids="EMP_submenus-"+mainmenuid+'-'+submenulength+'-'+j1;
                            EMPSRC_UPD_DEL_submenu='<div><ul style="list-style: none;"><li style="list-style: none;" ><tr><td>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="submenu[]" id='+submenuids+' value='+EMPSRC_UPD_DEL_multi_array[j+1][j1]+' class="tree submenucheck Child" level="child" />' + EMPSRC_UPD_DEL_multi_array[j+1][j1] + '</td></tr>';
                            $('#'+"EMPSRC_UPD_DEL_tble_submenu"+j).append(EMPSRC_UPD_DEL_submenu);
                            for(var m1=0;m1<EMPSRC_UPD_DEL_cardno.length;m1++){
                                if(EMPSRC_UPD_DEL_multi_array[j+1][j1]==EMPSRC_UPD_DEL_cardno[m1]){
                                    $('#'+submenuids).prop("checked", true)
                                    $('#'+id_menu).prop("checked", true)
                                }
                            }
                        }
                    }
                }
                $("#EMPSRC_UPD_DEL_tble_menu").show();
                $('#EMPSRC_UPD_DEL_table_updateform').show();
            }
            //CHANGE FUNCTION FOR DESIGNATION
            $("#EMPSRC_UPD_DEL_lb_empdesig").change(function(){
                var EMPSRC_UPD_DEL_desigoption=$(this).val();
                if((EMPSRC_UPD_DEL_desigoption=="CLEANER")||(EMPSRC_UPD_DEL_desigoption=="SELECT"))
                {
                    $('#EMPSRC_UPD_DEL_lbl_cardno').hide();
                    $('#cardupd').hide();
                    $('#EMPSRC_UPD_DEL_nullcard').hide();
                    $('#EMPSRC_UPD_DEL_lbl_shwcardno').hide();
                    $('#EMPSRC_UPD_DEL_radio_selectcard').hide();
                    $('#EMPSRC_UPD_DEL_radio_null').hide();
                    $('#EMPSRC_UPD_DEL_tble_menu').hide();
                }
                else
                {
                    $('#cardupd').show();
                    $('#EMPSRC_UPD_DEL_table_updateform').show();
                    $('#EMPSRC_UPD_DEL_nullcard').show();
                    $('#EMPSRC_UPD_DEL_lbl_shwcardno').show();
                    $('#EMPSRC_UPD_DEL_radio_selectcard').show();
                    $('#EMPSRC_UPD_DEL_radio_null').show();
                    $('input[name="EMPSRC_UPD_DEL_selectcard"]').prop('checked', false);
                    $('input[name="menu"]').prop('checked', false);
                    $('input[name="submenu"]').prop('checked', false);
                }
            });
            //CLICK FUNCTION FOR RADIO BUTTON
            $('.radio_selectedupd').click(function()
            {
                var EMP_ENTRY_radio=$("input[name=EMPSRC_UPD_DEL_selectcard]:checked").val()
                if(EMP_ENTRY_radio=='CARD')
                {
                    EMPSRC_UPD_DEL_multitreeview(EMPSRC_UPD_DEL_multi_array);
                    $("#EMPSRC_UPD_DEL_btn_update").attr("disabled","disabled");
                }else
                {
                    $('input:checkbox[name="menu"]').attr('disabled', "disabled");
                    $('input:checkbox[name="submenu[]"]').attr('disabled', "disabled");
                    $('#EMPSRC_UPD_DEL_tble_menu').hide();
                    $('#EMPSRC_UPD_DEL_lbl_error').hide();
                    $(".preloader").hide();
                }
            });
          //SHOW THE RESET TREE VIEW FORMATE//
            function EMPSRC_UPD_DEL_multitreeview(EMPSRC_UPD_DEL_multi_arraynew)
             {
                if((EMPSRC_UPD_DEL_multi_arraynew.length)==0)
                {
                    EMPSRC_UPD_DEL_multi_array=EMPSRC_UPD_DEL_multi_arraynew;
                }
                else
                {
                    var EMPENTRY_multi_array=[];
                    EMPENTRY_multi_array=EMPSRC_UPD_DEL_multi_arraynew;
                    EMPSRC_UPD_DEL_multi_array=EMPENTRY_multi_array;
                }
                if(EMPSRC_UPD_DEL_multi_array.length==0|| EMPSRC_UPD_DEL_multi_array.length==null||EMPSRC_UPD_DEL_multi_array=="")
                {
                    $('#EMPSRC_UPD_DEL_lbl_error').text(EMPSRC_UPD_DEL_flexheader_array[2]).show();
                    $("#EMPSRC_UPD_DEL_tble_menu").hide();
                    $("#EMPSRC_UPD_DEL_btn_update").attr("disabled","disabled");
                }
                else
                {
                    //SHOW TREE VIEW FORMATE//
                    $('#EMPSRC_UPD_DEL_lbl_error').hide();
                    $('#EMPSRC_UPD_DEL_lbl_cardno').show();
                    $("#EMPSRC_UPD_DEL_tble_menu").replaceWith("<table id ='EMPSRC_UPD_DEL_tble_menu'></table>");
                    var EMPSRC_UPD_DEL_menu=''
                    for (var j = 0; j < EMPSRC_UPD_DEL_multi_array[0].length; j++) {
                        var id="EMPSRC_UPD_DEL_tble_submenu"+j;
                        var id1="menu"+"_"+j;
                        var id2="sub"+j;
                        var id_menu=j+'m'
                        var mainmenuid=j;
                        EMPSRC_UPD_DEL_menu = '<div ><ul style="list-style: none;" ><li style="list-style: none;" ><tr ><td>&nbsp;&nbsp;&nbsp;<input value="+" type="button"  id='+id1+' height="5" width="5" class="exp" /><input type="checkbox" name="menu" id='+id_menu+' value='+EMPSRC_UPD_DEL_multi_array[0][j]+' level="parent" class="tree empsubmitvalidatupd"  />' + EMPSRC_UPD_DEL_multi_array[0][j] + '</td></tr>';
                        EMPSRC_UPD_DEL_menu+='<div id='+id2+' hidden ><tr><td><table id='+id+' class="EMPSRC_UPD_DEL_class_submenu"  ></table></tr></div></li></ul></div>';
                        $('#EMPSRC_UPD_DEL_tble_menu').append(EMPSRC_UPD_DEL_menu);
                        var EMPSRC_UPD_DEL_submenu='';
                        var submenulength=EMPSRC_UPD_DEL_multi_array[j+1].length;
                        for (var j1 = 0; j1 < EMPSRC_UPD_DEL_multi_array[j+1].length; j1++) {
                            var id3="EMPSRC_UPD_DEL_tble_submenu1"+j1;
                            var submenuids="EMP_submenus-"+mainmenuid+'-'+submenulength+'-'+j1;
                            EMPSRC_UPD_DEL_submenu='<div><ul style="list-style: none;"><li style="list-style: none;" ><tr><td>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="submenu[]" id='+submenuids+' value='+EMPSRC_UPD_DEL_multi_array[j+1][j1]+' class="tree submenucheck Child" level="child" />' + EMPSRC_UPD_DEL_multi_array[j+1][j1] + '</td></tr>';
                            $('#'+"EMPSRC_UPD_DEL_tble_submenu"+j).append(EMPSRC_UPD_DEL_submenu);
                        }
                    }
                    $("#EMPSRC_UPD_DEL_tble_menu").show();
                }
                 $('#EMPSRC_UPD_DEL_table_updateform').show();
                 $(".preloader").hide();
             }
            //VALIDATION FOR UPDATE FORRM START
            //CHANGE EVENT FUNCTION FOR MOBILENO
            $('#EMPSRC_UPD_DEL_tb_mobile').change(function()
            {
                var EMPSRC_UPD_DEL_bmobilenolength=$('#EMPSRC_UPD_DEL_tb_mobile').val();
                if(EMPSRC_UPD_DEL_bmobilenolength.length<6)
                {
                    $('#EMPSRC_UPD_DEL_tb_mobile').addClass('invalid');
                    $("#EMPSRC_UPD_DEL_btn_update").attr("disabled","disabled");
                    $("#EMPSRC_UPD_DEL_lbl_errmsg").text(EMPSRC_UPD_DEL_flexheader_array[19]).show();
                }
                else
                {
                    $('#EMPSRC_UPD_DEL_tb_mobile').removeClass('invalid');
                    $("#EMPSRC_UPD_DEL_lbl_errmsg").hide();
                }
            });
            //BLUR FUNCTION FOR CARD
            var EMPSRC_UPD_DEL_cardArray=[];
            $(document).on("change blur",'.empsubmitvalidatupd',function ()
            {
                var EMPSRC_UPD_DEL_Firstname= $("#EMPSRC_UPD_DEL_tb_firstname").val();
                var EMPSRC_UPD_DEL_Lastname =$("#EMPSRC_UPD_DEL_tb_lastname").val();
                var EMPSRC_UPD_DEL_empdesig =$("#EMPSRC_UPD_DEL_lb_empdesig").val();
                var EMPSRC_UPD_DEL_Mobileno = $("#EMPSRC_UPD_DEL_tb_mobile").val();
                var EMPSRC_UPD_DEL_email = $("#EMPSRC_UPD_DEL_tb_email").val();
                var EMP_ENTRY_menu=$("input[name=menu]").is(":checked");
                var EMP_ENTRY_submenu=$('input[name="submenu[]"]:checked').length;
                if( (( EMP_ENTRY_menu==true && EMP_ENTRY_submenu>0 &&( EMPSRC_UPD_DEL_multi_array.length!=0||EMPSRC_UPD_DEL_multi_array!="")) || $('#EMPSRC_UPD_DEL_radio_null').is(":checked")==true) && (EMPSRC_UPD_DEL_Firstname!='') && (EMPSRC_UPD_DEL_Lastname!='' )&&( EMPSRC_UPD_DEL_Mobileno!='' && (parseInt($('#EMPSRC_UPD_DEL_tb_mobile').val())!=0)) && (EMPSRC_UPD_DEL_Mobileno.length>=6)&& (EMPSRC_UPD_DEL_empdesig!='SELECT'))
                {
                    $("#EMPSRC_UPD_DEL_btn_update").removeAttr("disabled");
                }
                else
                {
                    $("#EMPSRC_UPD_DEL_btn_update").attr("disabled","disabled");
                }
            });
            //EMPLOYEE UPDATE BUTTON VALIDATION
            $("#EMP_ENTRY_form_employeename").change(function(){
                var EMPSRC_UPD_DEL_Firstname= $("#EMPSRC_UPD_DEL_tb_firstname").val();
                var EMPSRC_UPD_DEL_Lastname =$("#EMPSRC_UPD_DEL_tb_lastname").val();
                var EMPSRC_UPD_DEL_empdesig =$("#EMPSRC_UPD_DEL_lb_empdesig").val();
                var EMPSRC_UPD_DEL_Mobileno = $("#EMPSRC_UPD_DEL_tb_mobile").val();
                var EMPSRC_UPD_DEL_email = $("#EMPSRC_UPD_DEL_tb_email").val();
                var EMP_ENTRY_menu=$("input[name=menu]").is(":checked");
                var EMP_ENTRY_submenu=$('input[name="submenu[]"]:checked').length;
                if(EMPSRC_UPD_DEL_empdesig=='STAFF'){
                    if((( EMP_ENTRY_menu==true && EMP_ENTRY_submenu>0 && EMPSRC_UPD_DEL_multi_array.length!=0) || $('#EMPSRC_UPD_DEL_radio_null').is(":checked")==true) && (EMPSRC_UPD_DEL_Firstname!='') && (EMPSRC_UPD_DEL_Lastname!='' )&&( EMPSRC_UPD_DEL_Mobileno!='' && (parseInt($('#EMPSRC_UPD_DEL_tb_mobile').val())!=0)) && (EMPSRC_UPD_DEL_Mobileno.length>=6)&& (EMPSRC_UPD_DEL_empdesig!='SELECT'))
                    {
                        $("#EMPSRC_UPD_DEL_btn_update").removeAttr("disabled");
                    }
                    else
                    {
                        $("#EMPSRC_UPD_DEL_btn_update").attr("disabled","disabled");
                    }
                }
                else if(EMPSRC_UPD_DEL_empdesig=='CLEANER'){
                    if((EMPSRC_UPD_DEL_Firstname!='') && (EMPSRC_UPD_DEL_Lastname!='' )&&( EMPSRC_UPD_DEL_Mobileno!='' && (parseInt($('#EMPSRC_UPD_DEL_tb_mobile').val())!=0)) && (EMPSRC_UPD_DEL_Mobileno.length>=6)&& (EMPSRC_UPD_DEL_empdesig!='SELECT'))
                    {
                        $("#EMPSRC_UPD_DEL_btn_update").removeAttr("disabled");
                    }
                    else
                    {
                        $("#EMPSRC_UPD_DEL_btn_update").attr("disabled","disabled");
                    }
                }
                else
                {
                    $("#EMPSRC_UPD_DEL_btn_update").attr("disabled","disabled");
                }
            });
            //LOAD THE UPDATE FORM//
            $('#EMPSRC_UPD_DEL_btn_update').click(function(){

                var EMPSRC_UPD_DEL_bmobilenolength=$('#EMPSRC_UPD_DEL_tb_mobile').val();

                if(EMPSRC_UPD_DEL_bmobilenolength.length<6 || EMPSRC_UPD_DEL_bmobilenolength=="" )
                {
                    $(".preloader").hide();
                    $('#EMPSRC_UPD_DEL_tb_mobile').addClass('invalid');
                    $("#EMPSRC_UPD_DEL_btn_update").attr("disabled","disabled");
                    $("#EMPSRC_UPD_DEL_lbl_errmsg").text(EMPSRC_UPD_DEL_flexheader_array[19]).show();
                }
                else
                {

                    $("#EMPSRC_UPD_DEL_lbl_errmsg").hide();
                    $('#EMPSRC_UPD_DEL_tb_mobile').removeClass('invalid');
                    var EMPSRC_UPD_DEL_carccheckarray=[];

                    $('input[name="submenu[]"]:checked').each(function() {
                        EMPSRC_UPD_DEL_carccheckarray.push($(this).val());
                    });
                    var EMPSRC_UPD_DEL_carcunitarray=[];
                    $('input[name="menu"]:checked').each(function() {
                        EMPSRC_UPD_DEL_carcunitarray.push($(this).val());
                    });

                    EMPSRC_UPD_DEL_conformation_result(EMPSRC_UPD_DEL_carccheckarray,EMPSRC_UPD_DEL_carcunitarray)
                }
            });
            var EMPSRC_UPD_DEL_updateresultflag;
            var EMPSRC_UPD_DEL_updateresult;
            function EMPSRC_UPD_DEL_conformation_result(EMPSRC_UPD_DEL_carccheckarray,EMPSRC_UPD_DEL_carcunitarray)
            {
                $(".preloader").show();
                var EMPSRC_UPD_DEL_searchoption = $('#EMPSRC_UPD_DEL_lb_searchoption').val();
                var EMPSRC_UPD_DEL_firstname = $('#EMPSRC_UPD_DEL_tb_firstname').val();
                var EMPSRC_UPD_DEL_lastname = $('#EMPSRC_UPD_DEL_tb_lastname').val();
                var EMPSRC_UPD_DEL_empdesigname = $('#EMPSRC_UPD_DEL_lb_empdesig').val();
                var EMPSRC_UPD_DEL_mobilenumber = $('#EMPSRC_UPD_DEL_tb_mobile').val();
                var EMPSRC_UPD_DEL_email = $('#EMPSRC_UPD_DEL_tb_email').val();
                var EMPSRC_UPD_DEL_comments = $('#EMPSRC_UPD_DEL_ta_updatecomments').val();
                var EMP_ENTRY_radio_null = $('input:radio[name=EMPSRC_UPD_DEL_selectcard]:checked').val();
                var form_element = $('#EMP_ENTRY_form_employeename').serialize();
                $.ajax({
                    type: "POST",
                    url:EMP_ENTRY_controller_url+"EMPSRC_UPD_DEL_update",
                    data:form_element+"&EMPSRC_UPD_DEL_id="+currentid+"&EMPSRC_UPD_DEL_searchoption="+EMPSRC_UPD_DEL_searchoption+"&EMPSRC_UPD_DEL_firstname="+EMPSRC_UPD_DEL_firstname+"&EMPSRC_UPD_DEL_lastname="+EMPSRC_UPD_DEL_lastname+"&EMPSRC_UPD_DEL_empdesigname="+EMPSRC_UPD_DEL_empdesigname+"&EMPSRC_UPD_DEL_mobilenumber="+EMPSRC_UPD_DEL_mobilenumber+"&EMPSRC_UPD_DEL_comments="+EMPSRC_UPD_DEL_comments+"&EMP_ENTRY_radio_null="+EMP_ENTRY_radio_null+"&EMPSRC_UPD_DEL_email="+EMPSRC_UPD_DEL_email,
                    success: function(data) {
                        $(".preloader").hide();
                        var EMPSRC_UPD_DEL_conformation_resultval=JSON.parse(data);
                        EMPSRC_UPD_DEL_updateresultflag=EMPSRC_UPD_DEL_conformation_resultval[2]
                        if(EMPSRC_UPD_DEL_updateresultflag==1)
                        {
                            var EMPSRC_UPD_DEL_firstname=$('#EMPSRC_UPD_DEL_tb_firstname').val();
                            var EMPSRC_UPD_DEL_lastname=$('#EMPSRC_UPD_DEL_tb_lastname').val();
                            var EMPSRC_UPD_DEL_firstnamehide=$('#EMPSRC_UPD_DEL_tb_firstnamehide').val();
                            var EMPSRC_UPD_DEL_lastnamehide=$('#EMPSRC_UPD_DEL_tb_lastnamehide').val();
                            var EMPSRC_UPD_DEL_searchoption=$('#EMPSRC_UPD_DEL_lb_searchoption').val();
                            var EMPSRC_UPD_DEL_multi_val=[];
                            EMPSRC_UPD_DEL_multi_val=EMPSRC_UPD_DEL_conformation_resultval;
                            EMPSRC_UPD_DEL_multi_array=EMPSRC_UPD_DEL_multi_val[0];//
                            $('#EMPSRC_UPD_DEL_table_updateform').hide();
                            $('#EMPSRC_UPD_DEL_btn_update').hide();
                            $('#EMPSRC_UPD_DEL_btn_reset').hide();
                            if((EMPSRC_UPD_DEL_firstnamehide!=EMPSRC_UPD_DEL_firstname && EMPSRC_UPD_DEL_searchoption==90)||(EMPSRC_UPD_DEL_lastnamehide!=EMPSRC_UPD_DEL_lastname && EMPSRC_UPD_DEL_searchoption==90))
                            {
                                $(".preloader").show();
                                EMPSRC_UPD_DEL_employlstbx()
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[15].EMC_DATA,"success",false);
                            }
                            else
                            {
                                $(".preloader").show();
                                EMPSRC_UPD_DEL_srch_result()
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[15].EMC_DATA,"success",false);
                            }
                        }
                        else{
                            //MESSAGE BOX FOR NOT SAVED
                            if(EMPSRC_UPD_DEL_updateresultflag==0 || EMPSRC_UPD_DEL_updateresultflag==''){
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[24].EMC_DATA,"error",false);
                            }
                            else
                            {
                            //CARD SHOULD NOT BE ASSIGNED
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[24].EMC_DATA,"success",false);
                            }
                        }
                    },
                    error:function(data){
                        alert(JSON.stringify(data))
                    }
                });
            }
            //click event for delete btn
            var rowid='';
            $(document).on('click','.deletebutton',function(){
                rowid = $(this).attr('id');
                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[20].EMC_DATA,"success","delete");
            });
            $(document).on('click','.deleteconfirm',function(){
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url:EMP_ENTRY_controller_url+"deleteoption",
                    data :{'EMPSRC_UPD_DEL_deleteid':rowid},
                    success: function(data) {
                        $('.preloader').hide();
                        var successresult=JSON.parse(data);
                        var EMPSRC_UPD_DEL_deletemsgvalue=successresult[0].DELETION_FLAG;
                        var EMPSRC_UPD_DEL_searchoption=$('#EMPSRC_UPD_DEL_lb_searchoption').val();
                        if(EMPSRC_UPD_DEL_deletemsgvalue==1)
                        {
                            if(EMPSRC_UPD_DEL_searchoption==90)
                            {$(".preloader").show();
                                EMPSRC_UPD_DEL_employlstbx()
                                EMPSRC_UPD_DEL_srch_result()
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[16].EMC_DATA,"success",false);
                            }
                            else
                            {
                                $(".preloader").show();
                                EMPSRC_UPD_DEL_srch_result()
                                show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[16].EMC_DATA,"success",false);
                            }
                        }
                        else
                        {
                            //MESSAGE BOX FOR NOT DELETE
                            show_msgbox("EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE",EMP_ENTRY_error[18].EMC_DATA,"error",false);
                        }
                    }
                });
            });
            //CLICK EVENT FUCNTION FOR RESET
            $('#EMPSRC_UPD_DEL_btn_reset').click(function()
            {
                $(".preloader").show();
                EMPSRC_UPD_DEL_employeedetailrset()
            });
            //RESET ALL THE ELEMENT//
            function EMPSRC_UPD_DEL_employeedetailrset()
            {
                $(".preloader").hide();
                $("textarea").height(114);
                $('#EMPSRC_UPD_DEL_tble_menu').hide();
                $("#EMPSRC_UPD_DEL_btn_update").attr("disabled", "disabled");
                $('#EMPSRC_UPD_DEL_lbl_validemailid').hide();
                $('#EMPSRC_UPD_DEL_tble_avail_cardno').hide();
                $('#EMPSRC_UPD_DEL_div_avail_cardno').hide();
                $("#EMPSRC_UPD_DEL_tb_email").removeClass('invalid');
                $('#EMPSRC_UPD_DEL_tb_firstname').val('');
                $('#EMPSRC_UPD_DEL_tb_lastname').val('');
                $('#EMPSRC_UPD_DEL_lb_empdesig').val('');
                $('#EMPSRC_UPD_DEL_tb_mobile').val('');
                $('#EMPSRC_UPD_DEL_tb_email').val('');
                $('#EMPSRC_UPD_DEL_tb_mobile').removeClass('invalid');
                $("#EMPSRC_UPD_DEL_lbl_errmsg").hide();
                $('#EMPSRC_UPD_DEL_ta_updatecomments').val('');
                $('input[name="EMPSRC_UPD_DEL_selectcard"]').prop('checked', false);
                $('.sizefix').prop("size","20");
                $('#EMPSRC_UPD_DEL_lbl_cardno').hide();
                $('#cardupd').hide();
                $('#EMPSRC_UPD_DEL_nullcard').hide();
                $('#EMPSRC_UPD_DEL_lbl_shwcardno').hide();
                $('#EMPSRC_UPD_DEL_radio_selectcard').hide();
                $('#EMPSRC_UPD_DEL_radio_null').hide();
                $('#EMPSRC_UPD_DEL_tble_menu').hide();
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
    <div class="title text-center"><h4><b>EMPLOYEE DETAIL ENTRY/SEARCH/UPDATE/DELETE</b></h4></div>
    <form id="EMP_ENTRY_form_employeename" name="EMP_ENTRY_form_employeename" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div style="padding-bottom: 15px">
                    <div class="radio">
                        <label><input type="radio" name="optradio" value="EMPLOYEE ENTRY" class="PE_rd_selectform">ENTRY</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio" value="EMPLOYEE SEARCH/UPDATE" class="PE_rd_selectform">SEARCH/UPDATE/DELETE</label>
                    </div>
                </div>
                <div id="enrtyfrm" hidden>
                    <form id="EMP_ENTRY_form_errormsg">
                        <div id="EMP_ENTRY_table_errormsg">
                        </div>
                    </form>
                    <div class="row form-group">
                        <label name="EMP_ENTRY_lbl_firstname" id="EMP_ENTRY_lbl_firstname" class="col-sm-2" hidden>FIRST NAME <em>*</em></label>
                        <div class="col-sm-3">
                            <input  type="text" name="EMP_ENTRY_tb_firstname" id="EMP_ENTRY_tb_firstname"  class="autosizealph EMP_ENTRY_title_alpha empsubmitvalidat sizefix form-control" maxlength=30 hidden>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="EMP_ENTRY_lbl_lastname" id="EMP_ENTRY_lbl_lastname" class="col-sm-2" >LAST NAME <em>*</em></label>
                        <div class="col-sm-3">
                            <input  type="text" name="EMP_ENTRY_tb_lastname" id="EMP_ENTRY_tb_lastname" class="autosizealph EMP_ENTRY_title_alpha empsubmitvalidat sizefix form-control" maxlength=30 >
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="EMP_ENTRY_lbl_empdesig" id="EMP_ENTRY_lbl_empdesig" class="col-sm-2" >DESIGNATION<em>*</em></label>
                        <div class="col-sm-2"><select class="form-control" name="EMP_ENTRY_lb_empdesig" id="EMP_ENTRY_lb_empdesig">
                                <option>SELECT</option>
                            </select> </div>
                    </div>
                    <div id="card" hidden>
                        <div class="form-group">
                            <label class="col-sm-2">SELECT THE CARD <em>*</em></label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <label><input type="radio" name="EMP_ENTRY_selectcard" id="EMP_ENTRY_radio_selectcard" value='CARD' class='radio_selected empsubmitvalidat' hidden>CARD NUMBER</label>
                                    <label align='bottom' name='error' id='EMP_ENTRY_lbl_error' visible="false" class='errormsg'></label>
                                </div>
                                <div id="EMP_ENTRY_tble_menu" style="padding-left: 10px;display: none;" hidden="hidden">
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="EMP_ENTRY_selectcard" id="EMP_ENTRY_radio_null" value='NULL' class='radio_selected empsubmitvalidat' hidden>NULL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="EMP_ENTRY_div_avail_cardno">
                        <div id="EMP_ENTRY_tble_avail_cardno" hidden></div>
                    </div>
                    <div class="row form-group">
                            <label name="EMP_ENTRY_lbl_mobile" id="EMP_ENTRY_lbl_mobile" class="col-sm-2">MOBILE<em>*</em></label>
                        <div class="col-sm-3"><input type="text" name="EMP_ENTRY_tb_mobile" id="EMP_ENTRY_tb_mobile"  maxlength='10' style="width:110px" class="form-control"><label hidden name="EMP_ENTRY_lbl_errmsg" id="EMP_ENTRY_lbl_errmsg" class="errormsg"></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="EMP_ENTRY_lbl_email" id="EMP_ENTRY_lbl_email" class="col-sm-2">E-MAIL ID</label>
                        <div class="col-sm-3">
                            <input type="text" name="EMP_ENTRY_tb_email" id="EMP_ENTRY_tb_email" maxlength="40" class="sizefix form-control">
                            <label id="EMP_ENTRY_lbl_validemailid" name="EMP_ENTRY_lbl_validemailid" class="errormsg"></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="EMP_ENTRY_lbl_comments" id="EMP_ENTRY_lbl_comments"  class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-3">
                            <textarea name="EMP_ENTRY_ta_comments"  id="EMP_ENTRY_ta_comments" class="form-control  maxlength" style="height: 114px"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-3 col-lg-offset-2">
                        <input type="button" class=" btn" name="EMP_ENTRY_btn_save" id="EMP_ENTRY_btn_save"  disabled=""   value="SAVE"  >
                        <input type="button" class=" btn" name="EMP_ENTRY_btn_reset" id="EMP_ENTRY_btn_reset"  value="RESET">
                    </div>
                </div>
                <div id="searchform" hidden>
                    <form id="EMPSRC_UPD_DEL_form_errormsg">
                        <table id="EMPSRC_UPD_DEL_table_errormsg">
                        </table>
                    </form>
                    <div id="EMPSRC_UPD_DEL_table_employee">
                        <div class="row form-group">
                            <label name="EMPSRC_UPD_DEL_lbl_searchoption" id="EMPSRC_UPD_DEL_lbl_searchoption" class="col-sm-2" hidden>SEARCH BY<em>*</em></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="EMPSRC_UPD_DEL_lb_searchoption" id="EMPSRC_UPD_DEL_lb_searchoption" style="display:none" hidden>
                                </select>
                            </div>
                        </div>
                        <div>
                            <lable id = "EMPSRC_UPD_DEL_lbl_searchoptionheader" name = "EMPSRC_UPD_DEL_lbl_searchoptionheader" class = "srctitle" hidden >
                        </div>
                    </div>
                    <!----------ELEMENT TO CREATE SEARCH FORM FOR EMPLOYEE FIRST NAME------------------------------------------------>
                    <div class="form-group">
                        <lable id ="EMPSRC_UPD_DEL_lbl_employeename_listbox" class="col-sm-2" hidden> EMPLOYEE NAME </lable>
                        <div class="col-sm-4">
                            <select class="form-control" id="EMPSRC_UPD_DEL_lb_employeename_listbox" name="EMPSRC_UPD_DEL_lb_employeename_listbox"  style="display:none" hidden>
                                <option>SELECT</option>
                            </select>
                        </div>
                    </div>
                        <!----------ELEMENT TO CREATE SEARCH FORM FOR DESIGNATION------------------------------------------------>
                    <div class="row form-group">
                        <lable id ="EMPSRC_UPD_DEL_lbl_designation_listbox" class="col-sm-2" hidden>DESIGNATION</lable>
                        <div class="col-sm-4">
                            <select  class="form-control" id="EMPSRC_UPD_DEL_lb_designation_listbox" name="EMPSRC_UPD_DEL_lb_designation_listbox" style="display:none" hidden>
                                <option>SELECT</option>
                            </select>
                        </div>
                    </div>
                    <!----------ELEMENT TO CREATE SEARCH FORM FOR COMMENTS------------------------------------------------>
                    <div class="row form-group">
                        <label name="EMPSRC_UPD_DEL_lbl_comments" id="EMPSRC_UPD_DEL_lbl_comments"  class="col-sm-2" hidden>COMMENTS</label>
                        <div class="col-sm-4"><textarea name="EMPSRC_UPD_DEL_ta_comments"  id="EMPSRC_UPD_DEL_ta_comments" class="form-control   commentsresultsvalidate keypressvalid" hidden></textarea>
                        </div>
                    </div>
                    <!----------ELEMENT TO CREATE SEARCH FORM FOR EMAIL------------------------------------------------>
                    <div class="row form-group">
                        <label name="STDTL_INPUT_lbl_email" id="STDTL_INPUT_lbl_email"  class="col-sm-2" hidden>E-MAIL ID</label>
                        <div class="col-sm-4"><textarea name="EMPSRC_UPD_DEL_ta_email"  id="EMPSRC_UPD_DEL_ta_email" class="form-control  commentsresultsvalidate keypressvalid" hidden></textarea>
                        </div>
                    </div>
                    <!----------ELEMENT TO CREATE SEARCH FORM FOR MOBILE------------------------------------------------>
                    <div class="row form-group">
                        <label name="STDTL_INPUT_lbl_mobile" id="STDTL_INPUT_lbl_mobile"  class="col-sm-2" hidden>MOBILE</label>
                        <div class="col-sm-4"><textarea name="EMPSRC_UPD_DEL_ta_mobile"  id="EMPSRC_UPD_DEL_ta_mobile" class="form-control  commentsresultsvalidate keypressvalid" hidden></textarea>
                        </div>
                    </div>
                    <div class="form-group>
                    <div class="col-lg-3 col-lg-offset-2">
                        <input type="button" class=" btn" name="EMPSRC_UPD_DEL_btn_search_autocomplt" id="EMPSRC_UPD_DEL_btn_search_autocomplt"  disabled=""   value="SEARCH"  >
                    </div>


                    <div class="srctitle" name="EMPSRC_UPD_DEL_lbl_htmltablemsg" id="EMPSRC_UPD_DEL_lbl_htmltablemsg"></div><br>
                    <div class="errormsg" name="EMPSRC_UPD_DEL_nodataerrormsg" id="EMPSRC_UPD_DEL_nodataerrormsg"></div>
                    <div id='EMPSRC_UPD_DEL_pdf' hidden>
                        <div>
                            <input type="button" id='EMPSRC_UPD_DEL_btn_pdf' class="btnpdf" value="PDF">
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive" id="EMPSRC_UPD_DEL_div_htmltable" style="  overflow-y: hidden;" hidden>
                        <section>
                        </section>
                    </div>
                    <br>
                <!----------ELEMENT TO CREATE FOR UPDATE FORM------------------------------------------------>
                <div id ="EMPSRC_UPD_DEL_table_updateform" hidden>
                    <div class="row form-group">
                        <label name="EMPSRC_UPD_DEL_lbl_firstname" id="EMPSRC_UPD_DEL_lbl_firstname" class="col-sm-2">FIRST NAME <em>*</em></label>
                        <div class="col-sm-4">
                            <input type="text" name="EMPSRC_UPD_DEL_tb_firstname" id="EMPSRC_UPD_DEL_tb_firstname" maxlength='30' class="autosizealph EMP_ENTRY_title_alpha empsubmitvalidatupd sizefix form-control">
                            <input type="text" name="EMPSRC_UPD_DEL_tb_firstnamehide" id="EMPSRC_UPD_DEL_tb_firstnamehide" hidden>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="EMPSRC_UPD_DEL_lbl_lastname" id="EMPSRC_UPD_DEL_lbl_lastname" class="col-sm-2">LAST NAME <em>*</em></label>
                        <div class="col-sm-4">
                            <input type="text" name="EMPSRC_UPD_DEL_tb_lastname" id="EMPSRC_UPD_DEL_tb_lastname" maxlength='30' class="autosizealph EMPSRC_UPD_DEL_title_alpha empsubmitvalidatupd sizefix form-control">
                            <input type="text" name="EMPSRC_UPD_DEL_tb_lastnamehide" id="EMPSRC_UPD_DEL_tb_lastnamehide" hidden>
                        </div>
                     </div>
                    <div class="row form-group">
                        <label name="EMPSRC_UPD_DEL_lbl_empdesig" id="EMPSRC_UPD_DEL_lbl_empdesig" class="col-sm-2">DESIGNATION<em>*</em></label>
                        <div class="col-sm-4">
                            <select name="EMPSRC_UPD_DEL_lb_empdesig" id="EMPSRC_UPD_DEL_lb_empdesig" class="form-control">
                                <option>SELECT</option>
                            </select>
                        </div>
                    </div>
                    <div id="cardupd" hidden>
                        <div class="form-group">
                            <label class="col-sm-2">SELECT THE CARD <em>*</em></label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <label><input type="radio" name="EMPSRC_UPD_DEL_selectcard" id="EMPSRC_UPD_DEL_radio_selectcard" value='CARD' class='radio_selectedupd empsubmitvalidatupd' hidden>CARD NUMBER</label>
                                    <label align='bottom' name='error' id='EMPSRC_UPD_DEL_lbl_error' visible="false" class='errormsg'></label>
                                </div>
                                <div id="EMPSRC_UPD_DEL_tble_menu" style="padding-left: 10px;display: none;" hidden="hidden">
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="EMPSRC_UPD_DEL_selectcard" id="EMPSRC_UPD_DEL_radio_null" value='NULL' class='radio_selectedupd empsubmitvalidatupd' hidden>NULL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="EMPSRC_UPD_DEL_div_avail_cardno">
                        <div id="EMPSRC_UPD_DEL_tble_avail_cardno" hidden></div></div>
                    <div class="row form-group">
                        <label name="EMPSRC_UPD_DEL_lbl_mobile" id="EMPSRC_UPD_DEL_lbl_mobile" class="col-sm-2">MOBILE<em>*</em></label>
                        <div class="col-sm-3">
                            <input type="text" name="EMPSRC_UPD_DEL_tb_mobile" id="EMPSRC_UPD_DEL_tb_mobile"  maxlength='10' style="width:110px" class="form-control"><label hidden name="EMPSRC_UPD_DEL_lbl_errmsg" id="EMPSRC_UPD_DEL_lbl_errmsg" class="errormsg"></label>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="EMPSRC_UPD_DEL_lbl_email" id="EMPSRC_UPD_DEL_lbl_email"  class="col-sm-2">E-MAIL ID</label>
                        <div class="col-sm-3">
                            <input type="text" name="EMPSRC_UPD_DEL_tb_email" id="EMPSRC_UPD_DEL_tb_email" class="sizefix form-control" maxlength="40">
                            <div>
                                <label id="EMPSRC_UPD_DEL_lbl_validemailid" name="EMPSRC_UPD_DEL_lbl_validemailid" class="errormsg"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label name="EMPSRC_UPD_DEL_lbl_updatecomments" id="EMPSRC_UPD_DEL_lbl_comments"  class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-3">
                            <textarea name="EMPSRC_UPD_DEL_ta_updatecomments" id="EMPSRC_UPD_DEL_ta_updatecomments" class="autosize form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-offset-1 col-sm-3">
                        <input class="btn btn-info" type="button" id="EMPSRC_UPD_DEL_btn_update" name="UPDATE" value="UPDATE" />
                        <input class="btn btn-info resetsubmit" type="button" id="EMPSRC_UPD_DEL_btn_reset" name="RESET"   value="RESET"/>
                    </div>
                    <input type="text" name="EMPSRC_UPD_DEL_tb_checkcard" id="EMPSRC_UPD_DEL_tb_checkcard" hidden>
                    <input type="text" name="EMPSRC_UPD_DEL_tb_updateid" id="EMPSRC_UPD_DEL_tb_updateid" hidden>
                </div>

                </fieldset>
            </div>
        </form>
    </div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->