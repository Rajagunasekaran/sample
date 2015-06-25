
<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************EMAIL PROFILE ENTRY/SEARCH/UPDATE/DELETE*******************************//
//VER 0.02-SD:08/06/2015 ED:08/06/2015 CHANGED ALL CTRL,MODEL,VIEW FILE NAME AND GET USERSTAMP AND TIME ZONE FROM EILIB,
REMOVED COMMENTS AND EMPTY SPACE
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:18/05/2015 ED:18/05/2015
//************************************************************************************************************-->
<?PHP
require_once('application/libraries/EI_HDR.php');
?>
<!--SCRIPT TAG START-->
<script>
var value_err_array=[];
var listboxoption;
var CONF_ENTRY_flag_dataexistis=0;
var CONF_ENTRY_data_flag=1;
var CONF_ENTRY_subtype_flag=1;
var updateflag=0;
//DOCUMENT READY FUNCTION START
$(document).ready(function(){
var CONFIG_ENTRY_controller_url="<?php echo base_url(); ?>" + '/index.php/CONFIGURATION/Ctrl_Configuration_Entry_Update/' ;
    alert(CONFIG_ENTRY_controller_url)
$('#spacewidth').height('0%');
$('.preloader').hide();
$('#CONFIG_ENTRY_lb_module').hide();
var CONF_ENTRY_data_flag=1;
var CONF_ENTRY_glb_dataarr=[];
// INITIAL DATA LODING
$.ajax({
    type: "POST",
    'url':CONFIG_ENTRY_controller_url+"Initaildatas",
    data:{"Formname":'EmailTemplateEntry',"ErrorList":'170,273,275,272,274,276,277,287,289,315,320,400,401,453,454,455,458,465'},
    success: function(data){
        value_err_array=JSON.parse(data);
    },
    error: function(data){
        alert('error in getting'+JSON.stringify(data));
    }
});
//FUNCTION FOR FORM TABLE DATE FORMAT
function FormTableDateFormat(inputdate){
    var string = inputdate.split("-");
    return string[2]+'-'+ string[1]+'-'+string[0];
}
//LIST BOX ITEM CHANGE FUNCTION
$('.PE_rd_selectform').click(function(){
    listboxoption=$(this).val();
    $('#CONFIG_SRCH_UPD_div_htmltable').hide();
    $('#CONFIG_SRCH_UPD_div_header').hide();
    $('#ET_SRC_UPD_DEL_div_headernodata').hide();
    $("#CONFIG_ENTRY_lb_module").hide();
    $("#CONFIG_ENTRY_lbl_module").hide();
    $("#CONFIG_ENTRY_tr_type").hide();
    $("#CONFIG_ENTRY_tr_data").hide();
    $("#CONFIG_ENTRY_tr_btn").hide();
    if(listboxoption=='CONFIGURATION ENTRY')
    {
        $("#CONFIG_ENTRY_lb_module").val('SELECT').show();
        $("#CONFIG_ENTRY_lbl_module").show();
    }
    else if(listboxoption=='CONFIGURATION SEARCH/UPDATE')
    {
        $("#CONFIG_ENTRY_lb_module").val('SELECT').show();
        $("#CONFIG_ENTRY_lbl_module").show();
    }
});
// radio click function
var CONFIG_ENTRY_searchby=$('.PE_rd_selectform').val();
$(document).on('click','.PE_rd_selectform',function(){
    $('.preloader').show();
    $('#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn,#CONFIG_ENTRY_tr_type').empty();
    $('#CONFIG_ENTRY_div_errMod').hide();
    $('#CONFIG_SRCH_UPD_div_header').hide();
    $('#ET_SRC_UPD_DEL_div_headernodata').hide();
    var CONFIG_ENTRY_data=$(this).val();
    if($(this).val()!='SELECT'){
        $.ajax({
            type: "POST",
            'url':CONFIG_ENTRY_controller_url+"CONF_ENTRY_script_name",
            data :{'CONFIG_ENTRY_searchby':CONFIG_ENTRY_data},
            success: function(data){
                var value_array=JSON.parse(data);
                var CONFSCR_UPD_DEL_options ='<option>SELECT</option>';
                for (var i = 0; i < value_array[0].length; i++)
                {
                    var data=value_array[0][i];
                    CONFSCR_UPD_DEL_options += '<option value="' + data.CNP_ID + '">' + data.CNP_DATA+ '</option>';
                }
                $('#CONFIG_ENTRY_lb_module').html(CONFSCR_UPD_DEL_options);
                    $('.preloader').hide();
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
    }
});
//CHANGE EVENT FOR MODULE CONFIG
$(document).on('change','#CONFIG_ENTRY_lb_module',function(){
    $('#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn,#CONFIG_ENTRY_tr_type').empty();
    $('#CONFIG_SRCH_UPD_div_htmltable').hide();
    $('#CONFIG_ENTRY_div_errMod').hide();
    $('#CONFIG_SRCH_UPD_div_header').hide();
    $('#ET_SRC_UPD_DEL_div_headernodata').hide();
    var CONFIG_ENTRY_data=$(this).val();
    var CONFIG_ENTRY_searchby=$('#CONFIG_ENTRY_lb_searchby').val();
    var CONFIG_ENTRY_typ_opt='<option value="SELECT">SELECT</option>';
    var formElement = document.getElementById("CONFIG_ENTRY_form");
    if($(this).val()!='SELECT'){
        $('.preloader').show();
        $.ajax({
            type: "POST",
            'url':CONFIG_ENTRY_controller_url+"CONF_ENTRY_type_name",
            data :{'CONFIG_ENTRY_data':CONFIG_ENTRY_data,'CONFIG_ENTRY_searchby':CONFIG_ENTRY_searchby},
            success: function(data){
                $('.preloader').hide();
                var CONFIG_ENTRY_values=JSON.parse(data)
                if(CONFIG_ENTRY_values.length==0){
//                            $('#CONFIG_ENTRY_div_errMod').show();
//                            $('#CONFIG_ENTRY_div_errMod').text(CONFIG_ENTRY_errmsg[1].replace('[TYPE]',$("#CONFIG_ENTRY_lb_module option:selected").text()));
                }else{
                    $('#CONFIG_ENTRY_div_errMod').hide();
                    $('#CONFIG_SRCH_UPD_div_header').hide();
                    $('#ET_SRC_UPD_DEL_div_headernodata').hide();
                    for (var i=0;i<CONFIG_ENTRY_values.length;i++) {
                        CONFIG_ENTRY_typ_opt += '<option value="' + CONFIG_ENTRY_values[i].CGN_ID + '">' + CONFIG_ENTRY_values[i].CGN_TYPE + '</option>';
                    }
                    $('#CONFIG_ENTRY_tr_type').append(' <div class="form-group row" ><label class="col-sm-2 ">TYPE<em>*</em></label> <div class="col-sm-4"><select id="CONFIG_ENTRY_lb_type" name="CONFIG_ENTRY_lb_type"  class="form-control"></select> </div></div>')
                    $('#CONFIG_ENTRY_lb_type').html(CONFIG_ENTRY_typ_opt);
                    $("#CONFIG_ENTRY_tr_type").show();
                }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
    }
});
//CHANGE EVENT FOR TYPE CONFIG
$(document).on('change','#CONFIG_ENTRY_lb_type',function(){
    $('.preloader').show();
    $('#CONFIG_SRCH_UPD_div_htmltable').hide();
    $('#CONFIG_SRCH_UPD_div_header').hide();
    $('#ET_SRC_UPD_DEL_div_headernodata').hide();
    $("#CONF_ENTRY_lbl_Data").hide();
    $("#CONF_ENTRY_tb_Datadd").hide();
    $("#CONF_ENTRY_tr_dd").hide();
    $('#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn').empty();
    var SRC_UPD__idradiovalue=$('input:radio[name=optradio]:checked').attr('id');
    if($('#CONFIG_ENTRY_lb_type').val()!='SELECT' && listboxoption!='CONFIGURATION SEARCH/UPDATE')
    {
        $('#CONFIG_ENTRY_tr_data').append('<div class="form-group row" ><label class="col-sm-2">DATA<em>*</em></label> <div class="col-sm-4"><input type="text" id="CONFIG_ENTRY_tb_data" name="CONFIG_ENTRY_tb_data" class="form-control"  style="width:305px"></div><label id="CONFIG_ENTRY_div_errmsg" hidden class="errormsg"></label>');
        $('#CONFIG_ENTRY_tr_btn').append('&nbsp;&nbsp;&nbsp;<input  type="button" id="CONFIG_ENTRY_btn_save" class="btn  btn-info btn-lg" value="SAVE" disabled>&nbsp;&nbsp;&nbsp;<input type="button" id="CONFIG_ENTRY_btn_reset" class="btn btn-info btn-lg" value="RESET">');
        $("#CONFIG_ENTRY_tb_data").doValidation({rule:'alphanumeric',prop:{whitespace:true,uppercase:true,autosize:true}});

        if($('#CONFIG_ENTRY_lb_type').val()!=42){
            $("#CONFIG_ENTRY_tr_data").show();
            $("#CONF_ENTRY_tr_dd").hide();
        }
        else
        {
            $("#CONF_ENTRY_tb_Datadd").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}}).show();
            $("#CONF_ENTRY_lbl_Data").show();
            $("#CONF_ENTRY_tr_dd").show();
            $('#CONFIG_ENTRY_tr_data').empty();
        }
        $("#CONFIG_ENTRY_tr_btn").show();
        $(".alphabets").doValidation({rule:'alphabets',prop:{whitespace:true,uppercase:true,autosize:true}});
        $('.preloader').hide();
    }
    else if($('#CONFIG_ENTRY_lb_type').val()!='SELECT' && listboxoption=='CONFIGURATION SEARCH/UPDATE')
    {
        CONFIG_SRCH_UPD_fetch_configdata()
    }
    else
    {
        $('.preloader').hide();
        $('#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn').empty();
    }
});
//CHANGE FUNCTION FOR DATA
var CONF_ENTRY_data;
$(document).on('blur','#CONFIG_ENTRY_tb_data,#CONF_ENTRY_tb_Datadd',function(){
    $("#CONFIG_ENTRY_btn_save").attr("disabled", "disabled");
    if($('#CONFIG_ENTRY_tb_data').val()!=undefined){
        CONF_ENTRY_data = $('#CONFIG_ENTRY_tb_data').val().trim();
    }
    var CONF_ENTRY_profileName = $('#CONFIG_ENTRY_lb_module').val();
    var CONF_ENTRY_types = $('#CONFIG_ENTRY_lb_type').find('option:selected').text();
    var type = $('#CONFIG_ENTRY_lb_type').val();
    if(($("#CONFIG_ENTRY_lb_type").val()==42)&&($('#CONF_ENTRY_tb_Datadd').val()!='')){
        CONF_ENTRY_data=$("#CONF_ENTRY_tb_Datadd").val();
        if(($('#CONF_ENTRY_tb_Datadd').val()=='')||(parseInt($('#CONF_ENTRY_tb_Datadd').val())==0)||($('#CONF_ENTRY_tb_subtype_dd').val()=='')||(CONF_ENTRY_subtype_flag==1))
            $("#CONFIG_ENTRY_btn_save").attr("disabled", "disabled");
        else
            $("#CONFIG_ENTRY_btn_save").removeAttr("disabled");
    }
    else if((CONF_ENTRY_data=='')||(CONF_ENTRY_profileName=='SELECT')||(CONF_ENTRY_types=='SELECT'))
    {
        $("#CONFIG_ENTRY_btn_save").attr("disabled", "disabled");
        $('#CONFIG_ENTRY_div_errmsg').text('');
        $("#CONFIG_ENTRY_tb_data").removeClass('invalid');
    }
    else if(($('#CONFIG_ENTRY_lb_type').val()!=42)&&(CONF_ENTRY_data!='')&&(CONF_ENTRY_profileName!='SELECT')&&(CONF_ENTRY_types!='SELECT'))
    {
        $.ajax({
            type: "POST",
            'url':CONFIG_ENTRY_controller_url+"data_exists",
            data :{'module':CONF_ENTRY_profileName,'type':type,'data':CONF_ENTRY_data},
            success: function(data){
                $('.preloader').hide();
                CONF_ENTRY_flag_dataexistis=data.script_name_already_exits_array;
                if(CONF_ENTRY_flag_dataexistis==0){
                    $("#CONFIG_ENTRY_btn_save").removeAttr("disabled");
                    $('#CONFIG_ENTRY_div_errmsg').text('');
                    $("#CONFIG_ENTRY_tb_data").removeClass('invalid');
                }
                else if(CONF_ENTRY_flag_dataexistis==1){
                    $("#CONFIG_ENTRY_btn_save").attr("disabled", "disabled");
                    var CONF_ENTRY_errmsg =value_err_array[8].EMC_DATA.replace('[TYPE]',$('#CONFIG_ENTRY_lb_type').find('option:selected').text());
                    $('#CONFIG_ENTRY_div_errmsg').text(CONF_ENTRY_errmsg).show();
                    $("#CONFIG_ENTRY_tb_data").addClass('invalid');
                }
            },
            error:function(data){
                alert(JSON.stringify(data));
            }
        });
    }
});
/*--------------------------------------------CHANGE EVENT FOR TYPE------------------------------------------------------*/
$('#CONF_ENTRY_tb_subtype_dd').blur(function(){
    var sub_type_data=$('#CONF_ENTRY_tb_subtype_dd').val();
    if($('#CONF_ENTRY_tb_subtype_dd').val().length==0){
        $("#CONFIG_ENTRY_btn_save").attr("disabled", "disabled");
        $('#CONF_ENTRY_div_uniquesubtype').text('');
        $("#CONF_ENTRY_tb_subtype_dd").removeClass('invalid');
    }
    else if($('#CONF_ENTRY_tb_subtype_dd').val()!=''){
        $.ajax({
            type: "POST",
            'url':CONFIG_ENTRY_controller_url+"subdata_exists",
            data :{'sub_type_data':sub_type_data},
            success: function(data){
                $('.preloader').hide();
                CONF_ENTRY_flag_dataexistis=data.subtype_name_already_exits_array
                if(CONF_ENTRY_flag_dataexistis==0){
                    CONF_ENTRY_subtype_flag=0;
                    $("#CONFIG_ENTRY_btn_save").removeAttr("disabled");
                    $('#CONF_ENTRY_div_uniquesubtype').text('');
                    $("#CONF_ENTRY_tb_subtype_dd").removeClass('invalid');
                }
                else if(CONF_ENTRY_flag_dataexistis==1){
                    CONF_ENTRY_subtype_flag=1;
                    $("#CONFIG_ENTRY_btn_save").attr("disabled", "disabled");
                    var CONF_ENTRY_errmsg =value_err_array[10].EMC_DATA.replace('[TYPE]',$('#CONFIG_ENTRY_lb_type').find('option:selected').text());
                    $('#CONF_ENTRY_div_uniquesubtype').text(CONF_ENTRY_errmsg).show();
                    $("#CONF_ENTRY_tb_subtype_dd").addClass('invalid');
                }
                if($("#CONFIG_ENTRY_lb_type").val()==42){
                    if(($('#CONF_ENTRY_tb_Datadd').val()=='')||(CONF_ENTRY_response_alreadyexist_subtype==false)||($('#CONF_ENTRY_tb_subtype_dd').val()=='')||(CONF_ENTRY_subtype_flag==1)||(CONF_ENTRY_data_flag==0))
                        $("#CONFIG_ENTRY_btn_save").attr("disabled", "disabled");
                    else
                        $("#CONFIG_ENTRY_btn_save").removeAttr("disabled");
                }
            }
        });

    }
});
//end
var csearchval=[];
var id;
var Initial_flag;
var sub_type;
var type_id;
//FUNCTION FOR FETCHING DATA FOR FLEX TABLE
function CONFIG_SRCH_UPD_fetch_configdata(){
    var module=$('#CONFIG_ENTRY_lb_module').val();
    var type=$('#CONFIG_ENTRY_lb_type').find('option:selected').text();
    type_id=$('#CONFIG_ENTRY_lb_type').val();
    $.ajax({
        type: "POST",
//                data: $('#CONFIG_ENTRY_form').serialize(),
        'url':CONFIG_ENTRY_controller_url+"CONF_ENTRY_flex_data",
        data :{'module':module,'type':type},
        success: function(data){
            $('.preloader').hide();
            var CONFIG_SRCH_UPD_values=JSON.parse(data)
            if(CONFIG_SRCH_UPD_values.length!=0)
            {
                var CONFSRC_UPD_DEL_lb_Type = $('#CONFIG_ENTRY_lb_type').find('option:selected').text();
                var ET_SRC_UPD_DEL_errmsg =value_err_array[1].EMC_DATA.replace('[TYPE]',CONFSRC_UPD_DEL_lb_Type);
                $('#CONFIG_SRCH_UPD_div_header').text(ET_SRC_UPD_DEL_errmsg).show();
                if(type_id==42){
                    var CONFIG_SRCH_UPD_table_header='<table id="CONFIG_SRCH_UPD_tble_config" border="1"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th></th><th>SUB TYPE</th><th>DATA</th><th  class="uk-date-column"">USERSTAMP</th><th  class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    for(var i=0;i<CONFIG_SRCH_UPD_values.length;i++)
                    {
                        id=CONFIG_SRCH_UPD_values[i].ID;
                        Initial_flag=CONFIG_SRCH_UPD_values[i].INIFLAG;
                        sub_type=CONFIG_SRCH_UPD_values[i].SUBTYPE
                        if(Initial_flag=='X'){
                            CONFIG_SRCH_UPD_table_header+='<tr><td></td></td><td id=subdataamount_'+id+' class="data" >'+sub_type+'</td><td id=subtype_'+id+' class="data" >'+CONFIG_SRCH_UPD_values[i].DATA+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].ULD_LOGINID+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].DDC_TIMESTAMP+'</td></tr>';
                        }
                        else
                        {
                            CONFIG_SRCH_UPD_table_header+='<tr><td><span style="max-height:20px;max-width: 20px;" id ='+id+' class="glyphicon glyphicon-trash deletebutton"></span></td><td id=subdataamount_'+id+' class="data" >'+sub_type+'</td><td id=subtype_'+id+' class="data" >'+CONFIG_SRCH_UPD_values[i].DATA+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].ULD_LOGINID+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].DDC_TIMESTAMP+'</td></tr>';
                        } }
                }
                else if(type_id==30){
                    var CONFIG_SRCH_UPD_table_header='<table id="CONFIG_SRCH_UPD_tble_config" border="1"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th></th><th>DATA</th><th  class="uk-date-column"">USERSTAMP</th><th  class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    for(var i=0;i<CONFIG_SRCH_UPD_values.length;i++)
                    {
                        id=CONFIG_SRCH_UPD_values[i].ID;
                        Initial_flag=CONFIG_SRCH_UPD_values[i].INIFLAG;
                        sub_type=CONFIG_SRCH_UPD_values[i].SUBTYPE
                        if(Initial_flag=='X'){
                            CONFIG_SRCH_UPD_table_header+='<tr><td></td></td><td id=subtype_'+id+' class="data" >'+CONFIG_SRCH_UPD_values[i].DATA+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].ULD_LOGINID+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].DDC_TIMESTAMP+'</td></tr>';
                        }
                        else
                        {
                            CONFIG_SRCH_UPD_table_header+='<tr><td><span style="max-height:20px;max-width: 20px;" id ='+id+' class="glyphicon glyphicon-trash deletebutton"></span></td><td id=subtype_'+id+' class="data" >'+CONFIG_SRCH_UPD_values[i].DATA+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].ULD_LOGINID+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].DDC_TIMESTAMP+'</td></tr>';
                        } }
                }
                else
                {
                    var CONFIG_SRCH_UPD_table_header='<table id="CONFIG_SRCH_UPD_tble_config" border="1"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th></th><th  class="uk-date-column"">DATA</th><th  class="uk-date-column"">USERSTAMP</th><th  class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    for(var i=0;i<CONFIG_SRCH_UPD_values.length;i++)
                    {
                        id=CONFIG_SRCH_UPD_values[i].ID;
                        Initial_flag=CONFIG_SRCH_UPD_values[i].INIFLAG;
                        if(Initial_flag=='X'){
                            CONFIG_SRCH_UPD_table_header+='<tr><td></td></td><td id=name_'+id+' class="data" >'+CONFIG_SRCH_UPD_values[i].DATA+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].USERSTAMP+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].TIMESTAMP+'</td></tr>';
                        }
                        else
                        {
                            CONFIG_SRCH_UPD_table_header+='<tr><td><span style="max-height:20px;max-width: 20px;" id ='+id+' class="glyphicon glyphicon-trash deletebutton"></span></td><td id=name_'+id+' class="data" >'+CONFIG_SRCH_UPD_values[i].DATA+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].USERSTAMP+'</td><td nowrap>'+CONFIG_SRCH_UPD_values[i].TIMESTAMP+'</td></tr>';
                        } }
                }
                CONFIG_SRCH_UPD_table_header+='</tbody></table>';
                $('section').html(CONFIG_SRCH_UPD_table_header);
                $('#CONFIG_SRCH_UPD_div_htmltable').show();
                $('#CONFIG_SRCH_UPD_tble_config').DataTable( {
                    "aaSorting": [],
                    "pageLength": 10,
                    "sPaginationType":"full_numbers"
                });
                sorting()
            }
            else
            {
                var CONFSRC_UPD_DEL_lb_Type = $('#CONFIG_ENTRY_lb_type').find('option:selected').text();
                var ET_SRC_UPD_DEL_errmsg =value_err_array[3].EMC_DATA.replace('[TYPE]',CONFSRC_UPD_DEL_lb_Type);
                $('#ET_SRC_UPD_DEL_div_headernodata').text(ET_SRC_UPD_DEL_errmsg).show();
            }
        },
        error: function(data){
            alert('error in getting'+JSON.stringify(data));
        }
    });
}
var previous_id;
var combineid;
var tdvalue;
var subtype_val;
var subdatamount_val;
//click function for email subject
$(document).on('click','.data', function (){
    if(previous_id!=undefined){
        $('#'+previous_id).replaceWith("<td class='data' id='"+previous_id+"' >"+tdvalue+"</td>");
    }
    var cid = $(this).attr('id');
    previous_id=cid;
    var id=cid.split('_');
    combineid=id[1];
    tdvalue=$(this).text();
    if(tdvalue!=''){
     if(type_id!=88 || type_id!=89 || type_id!=90 || type_id!=91 || type_id!=92 || type_id!=93 || type_id!=94 || type_id!=95){
         $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='nameupd' name='data'  class='dataupdate uppercase red' maxlength='200'  style='width: 280px' value='"+tdvalue+"'>");
         $(".uppercase").doValidation({rule:'general',prop:{uppercase:true,autosize:true}});
     }
        else
     {
         $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='name' name='data'  class='dataupdate red' maxlength='200'  style='width: 280px' value='"+tdvalue+"'>");
     }
    }
    else
        $('#'+cid).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='name' name='data'  class='dataupdate red' maxlength='200'  style='width: 280px' value='"+tdvalue+"'>");

    if(id[0]=='subtype'){
        subtype_val='subtypeid_'+id[1];
        $('#subtype_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='"+subtype_val+"' name='data'  class='dataupdate amountonly uppercase red' style='width: 280px' value='"+tdvalue+"'>");
        if(type_id==42){
        $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        }
        else if(type_id!=88 || type_id!=89 || type_id!=90 || type_id!=91 || type_id!=92 || type_id!=93 || type_id!=94 || type_id!=95)
        {
            $(".uppercase").doValidation({rule:'general',prop:{uppercase:true,autosize:true}});
        }
    }
    else if(id[0]=='subdataamount'){
        subdatamount_val='subdataamount_'+id[1];
        $('#subdataamount_'+id[1]).replaceWith("<td class='new' id='"+previous_id+"'><input type='text' id='"+subdatamount_val+"' name='data'  class='dataupdate uppercase' style='width: 280px' value='"+tdvalue+"'>");
        $(".uppercase").doValidation({rule:'general',prop:{uppercase:true,autosize:true}});
    }
} );
//UPDATE FUNCTION
var dataupdte;
var subdatamount_value;
var CONFIG_SEARCH_subtype;
$(document).on('change','.dataupdate', function (){
//    $('.dataupdate').change(function(){
    updateflag=0;
    sub_type=$('#'+subtype_val).val();
    subdatamount_value=$('#'+subtype_val).val();
    dataupdte=$(this).val().trim();
    var module=$('#CONFIG_ENTRY_lb_module').val();
    var type=$('#CONFIG_ENTRY_lb_type').val();
    if($('#subtype_'+combineid).hasClass("data")==true){
         CONFIG_SEARCH_subtype=$('#subtype_'+combineid).text();
    }
    else{
         CONFIG_SEARCH_subtype=sub_type;
    }
    if($('#subdataamount_'+combineid).hasClass("data")==true){
        var subdatamount_value=$('#subdataamount_'+combineid).text();
    }
    else{
        var subdatamount_value=subdatamount_value;
    }
    if((dataupdte!=tdvalue && dataupdte!=sub_type) ||(dataupdte!=tdvalue)){
        $('.preloader').show();
        $.ajax({
            type: "POST",
            'url':CONFIG_ENTRY_controller_url+"dataupd_exists",
            data :{'module':module,'type':type,'data':dataupdte,'subdatamount_value':subdatamount_value},
            success: function(data){                $('.preloader').hide();

                var ET_ENTRY_response=JSON.parse(data.script_name_already_exits_array)//retdata.final_array[0];
                var CONFIG_ENTRY_values=ET_ENTRY_response;
                $('.preloader').hide();
                if(CONFIG_ENTRY_values==1){
                    var typedata=$('#CONFIG_ENTRY_lb_type').find('option:selected').text();
                    var CONF_ENTRY_errmsg =value_err_array[8].EMC_DATA.replace('[TYPE]',typedata);
                    show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",CONF_ENTRY_errmsg,"success",false)
//                        $('#nameupd').addClass('invalid');
                    updateflag=1;
                }
                if(CONFIG_ENTRY_values==1 && type_id==42){
                    var typedata=$('#CONFIG_ENTRY_lb_type').find('option:selected').text();
                    var CONF_ENTRY_errmsg =value_err_array[10].EMC_DATA.replace('[TYPE]',typedata);
                    show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",CONF_ENTRY_errmsg,"success",false)
                    updateflag=1;
                }
                else{
//                        $("#nameupd").removeClass('invalid');
                    var module=$('#CONFIG_ENTRY_lb_module').val();
                    if(type_id==42){
                        var type=$('#CONFIG_ENTRY_lb_type').val();
                    }
                    else
                    {
                        var type=$('#CONFIG_ENTRY_lb_type').find('option:selected').text();
                    }
                    if(updateflag==0)
                    {
                    updation()//                            $("#nameupd").removeClass('invalid');
                    }
                }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
    }
});
//UPDATE SUCCESS PART
function updation(){
    var module=$('#CONFIG_ENTRY_lb_module').val();
    var type=$('#CONFIG_ENTRY_lb_type').val();
    var CONFSRC_UPD_DEL_lb_Type = $('#CONFIG_ENTRY_lb_type').find('option:selected').text();
    if(dataupdte!=''){
    $('.preloader').show();
    $.ajax({
    type: "POST",
    'url':CONFIG_ENTRY_controller_url+"dataupdate",
    data:{'rowid':combineid,'module':module,'type':type,'data':dataupdte,'CONFIG_SEARCH_subdata':CONFIG_SEARCH_subtype,'subdatamount_value':subdatamount_value,'typeText':CONFSRC_UPD_DEL_lb_Type,'olddata':tdvalue},
    success: function(data) {
        $('.preloader').hide();
        var resultflag=data;
        if(resultflag=='true')
        {
            var errmsg=value_err_array[2].EMC_DATA.replace('[MODULE NAME]',$("#CONFIG_ENTRY_lb_module option:selected").text());
            show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",errmsg,"success",false)
            CONFIG_SRCH_UPD_fetch_configdata()
            previous_id=undefined;
        }
        else
        {
            show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",value_err_array[12].EMC_DATA,"error",false)
        }
    }
});}
}
//CLICK EVENT FOR BUTTON
$(document).on('click','#CONFIG_ENTRY_btn_save',function(){
    $('.preloader').show();
    var CONFIG_ENTRY_module=$('#CONFIG_ENTRY_lb_module').val();
    var CONFIG_ENTRY_type=$('#CONFIG_ENTRY_lb_type').val();
    var CONFIG_ENTRY_data=$('#CONFIG_ENTRY_tb_data').val();
    var CONFIG_ENTRY_subtype=$('#CONF_ENTRY_tb_subtype_dd').val();
    var CONFIG_ENTRY_subtypedata=$('#CONF_ENTRY_tb_Datadd').val();
    $.ajax({
        type: "POST",
        data: $('#CONFIG_ENTRY_form').serialize(),
        'url':CONFIG_ENTRY_controller_url+"CONF_ENTRY_save_data",
        success: function(data){
            $('.preloader').hide();
            var CONFIG_ENTRY_msg_alert=JSON.parse(data)
            if(CONFIG_ENTRY_msg_alert==1)
            {
                var errmsg=value_err_array[6].EMC_DATA.replace('[MODULE NAME]',$("#CONFIG_ENTRY_lb_module option:selected").text());
                show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",errmsg,"success",false)
                $("#CONF_ENTRY_lbl_Data").hide();
                $("#CONF_ENTRY_tb_Datadd").hide();
                $("#CONF_ENTRY_tr_dd").hide();
            }
            else if(CONFIG_ENTRY_msg_alert==0)
            {
                show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",value_err_array[11].EMC_DATA,"error",false)
            }
            if(CONFIG_ENTRY_msg_alert==2){
//                        $("#CONFIG_ENTRY_btn_save").attr("disabled","disabled");
//                        $("#CONFIG_ENTRY_div_errmsg").text(CONFIG_ENTRY_errmsg[3].replace('[TYPE]',$("#CONFIG_ENTRY_lb_type option:selected").text())).show();
            }
            else{
                $('#CONFIG_ENTRY_tr_type,#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn').empty();
                $('#CONFIG_ENTRY_lbl_module').hide();
                $('#CONFIG_ENTRY_lb_module').hide();
                $('input:radio[name=optradio]').attr('checked',false);
                $('#CONFIG_ENTRY_lb_searchby').val('SELECT');
            }
        },
        error: function(data){
            alert('error in getting'+JSON.stringify(data));
        }
    });
});
//CLICK EVENT FOR BUTTON RESET
$(document).on('click','#CONFIG_ENTRY_btn_reset',function(){
    $('#CONFIG_ENTRY_tr_type,#CONFIG_ENTRY_tr_data,#CONFIG_ENTRY_tr_btn,#CONF_ENTRY_tr_dd').empty();
    $("#CONFIG_ENTRY_lb_module").hide();
    $("#CONFIG_ENTRY_lbl_module").hide();
    $("#CONF_ENTRY_lbl_Data").hide();
    $("#CONF_ENTRY_tb_Datadd").hide();
    $("#CONF_ENTRY_tr_dd").hide();
    $('#CONFIG_ENTRY_lb_searchby').val('SELECT')
    $('input:radio[name=optradio]').attr('checked',false);
});
//click event for delete btn
var rowid='';
$(document).on('click','.deletebutton',function(){
    rowid = $(this).attr('id');
    show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",value_err_array[9].EMC_DATA,"success","delete");
});
$(document).on('click','.deleteconfirm',function(){
    $(".preloader").show();
    var module=$('#CONFIG_ENTRY_lb_module').val();
    var type=$('#CONFIG_ENTRY_lb_type').val();
    var data=$('#CONFIG_ENTRY_tb_data').val();
    var PDLY_SEARCH_obj_rowvalue=[];
    $.ajax({
        type: "POST",
        'url':CONFIG_ENTRY_controller_url+"deleteoption",
        data :{'rowid':rowid,'module':module,'type':type,'data':data},
        success: function(data) {
            $('.preloader').hide();
            var successresult=JSON.parse(data);
            var deleteflag=successresult[0].DELETION_FLAG;
            if(deleteflag==1){
                var module=$('#CONFIG_ENTRY_lb_module').val();
                var type=$('#CONFIG_ENTRY_lb_type').val();
                var data=$('#CONFIG_ENTRY_tb_data').val();
                $.ajax({
                    type: "POST",
                    'url':CONFIG_ENTRY_controller_url+"deleteconformoption",
                    data :{'rowid':rowid,'module':module,'type':type,'data':data},
                    success: function(data) {
                        var successresult=JSON.parse(data);
                        var deleteflag=successresult;
                        if(deleteflag==1){
                            var errmsg=value_err_array[4].EMC_DATA.replace('[MODULE NAME]',$("#CONFIG_ENTRY_lb_module option:selected").text());
                            show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",errmsg,"success",false)
                            CONFIG_SRCH_UPD_fetch_configdata()
                        }
                        else
                        {
                            show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",value_err_array[0].EMC_DATA,"error",false)
                        }
                    }

                });
            }
            else
            {
                show_msgbox("CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE",value_err_array[0].EMC_DATA,"error",false)
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
//DOCUMENT READY FUNCTION END
</script>
<!--SCRIPT TAG END-->
</head>
<!--HEAD TAG END-->
<!--BODY TAG START-->
<body>
<div class="container">
<div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
<div class="title text-center"><h4><b>CONFIGURATION ENTRY/SEARCH/UPDATE/DELETE</b></h4></div>
<form id="CONFIG_ENTRY_form" name="CONFIG_ENTRY_form" class="form-horizontal content" role="form">
    <div class="panel-body">
        <fieldset>
            <div style="padding-bottom: 15px">
                <div class="radio">
                    <label><input type="radio" name="optradio" value="CONFIGURATION ENTRY" class="PE_rd_selectform">ENTRY</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="optradio" value="CONFIGURATION SEARCH/UPDATE" class="PE_rd_selectform">SEARCH/UPDATE/DELETE</label>
                </div>
            </div>
            <div class="form-group row" >
                <label  id="CONFIG_ENTRY_lbl_module" class="col-sm-2" hidden>MODULE NAME<em>*</em></label>
                <div class="col-sm-4">
                    <select name="CONFIG_ENTRY_lb_module" id="CONFIG_ENTRY_lb_module" class="form-control" hidden>
                        <option>SELECT</option>
                    </select><br><label id="CONFIG_ENTRY_div_errMod" hidden class="errormsg" hidden></label>
                </div>
            </div>
            <div id="CONFIG_ENTRY_tr_type"> </div>
            <div id="CONF_ENTRY_tr_dd" hidden>
                <div class="row form-group">
                    <label class="col-sm-2 ">SUB TYPE<em>*</em></label>
                    <div class="col-sm-10">
                        <input  type="text" name="CONF_ENTRY_tb_subtype_dd" id="CONF_ENTRY_tb_subtype_dd" class="autosize" style="width:305px"  maxlength=200>
                        <label id="CONF_ENTRY_div_uniquesubtype" name="CONF_ENTRY_div_uniquesubtype" class="errormsg" disabled=""></label>
                    </div>
                </div>
            </div>
            <div id="CONFIG_ENTRY_tr_data"></div>
            <label  id="CONF_ENTRY_lbl_Data" class="col-sm-2" hidden>DATA<em>*</em></label>
            <div><input type="text" name="CONF_ENTRY_tb_Datadd" id="CONF_ENTRY_tb_Datadd"  hidden /></div>
            <div class="srctitle" name="CONFIG_SRCH_UPD_div_header" id="CONFIG_SRCH_UPD_div_header"></div><br>
            <div class="errormsg" name="ET_SRC_UPD_DEL_div_headernodata" id="ET_SRC_UPD_DEL_div_headernodata"></div>
            <div  id ="CONFIG_SRCH_UPD_div_htmltable" class="table-responsive">
                <section>
                </section>
            </div>
            <div id="CONFIG_ENTRY_tr_btn"></div>
            <fieldset>
    </div>
</div>
</form>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->