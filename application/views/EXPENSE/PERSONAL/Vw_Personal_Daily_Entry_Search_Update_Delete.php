<!--*********************************PERSONAL DAILY ENTRY SEARCH/UPDATE/DELETE********************************************//
//DONE BY:SASIKALA
//VER 0.03 -SD:05/06/2015 ED:05/06/2015 GETTING HEADER FILE FROM LIB
//VER 0.02 SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names
//VER 0.01-SD:21/04/2015 ED:07/05/2015,INITIAL VERSION
//*******************************************************************************************************//-->
<html>
<head>
<?php
require_once('application/libraries/EI_HDR.php');
?>
<style>
    td, th {
        padding: 8px;
    }
    textarea{
        resize: none;
        overflow: hidden;
    }
    .glyphicon-remove,.glyphicon-trash{
        color:red;
    }
    .txtareaheight{
        height:116px !important;
    }
</style>
<script>
var ErrorControl ={AmountCompare:'InValid'}
$(document).ready(function(){
    $('.preloader').hide();
    $('#spacewidth').height('0%');
//DATE PICKER FUNCTION
    $(".date-picker").datepicker({
        dateFormat:"dd-mm-yy",
        changeYear: true,
        changeMonth: true
    });
    <!---ENTRY FORM FUNCTIONS -->
    $(".numonly").doValidation({rule:'numbersonly',prop:{realpart:5}});
    $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
    $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
    $(".PDLY_INPUT_ta_cmtItem").doValidation({rule:'general',prop:{uppercase:false}});
    $('textarea').autogrow({onInitialize: true});
    var perexptype;
    var babyexptype;
    var expensetype;
    var error_message=[];
    var perinvfrom=[];
    var invfromarray=[];
    <!--UPDATE FORM FUNCTIONS   -->
    $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
    $("#PDLY_SEARCH_tb_fromamount").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2,smallerthan:'PDLY_SEARCH_tb_toamount'}});
    $("#PDLY_SEARCH_tb_toamount").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2,greaterthan:'PDLY_SEARCH_tb_fromamount'}});
    $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
    var PDLY_SEARCH_flag_deleteupd=0;
    $('#PDLY_SEARCH_btn_babybutton').hide();
    $('#PDLY_SEARCH_lb_babysearchoption').hide();
    $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
    $('#div_category').hide();
    $("#PDLY_SEARCH_btn_babybutton").hide();
    $("#PDLY_SEARCH_div_htmltable").hide();
    $('#PDLY_btn_pdf').hide();
    $("#PDLY_SEARCH_btn_searchbutton").hide();
    $("#PDLY_SEARCH_btn_deletebutton").hide();
    $('#PDLY_SEARCH_btn_sbutton').hide();
    $('#PDLY_SEARCH_btn_rbutton').hide();
    $('#PDLY_btn_pdf').hide();
    var PDLY_SEARCH_babyexpensecategArray=[];
    var PDLY_SEARCH_typofexpensesarray=[];
    var PDLY_SEARCH_carexpensecategArray=[];
    var PDLY_SEARCH_personalexpensecategArray=[];
    var PDLY_SEARCH_hdrmsgArray=[];
    var PDLY_SEARCH_typeid=[];
    var PDLY_SEARCH_expensepersonalArray=[];
    var PDLY_SEARCH_expensecarloanArray=[];
    var PDLY_SEARCH_expensecarArray=[];
    var PDLY_SEARCH_expensebabyArray=[];
    var PDLY_SEARCH_expenseArray=[];
    var PDLY_SEARCH_errorArraye=[];
    var PDLY_SEARCH_dataArray=[];
    var baby_category=[];
    var car_category=[];
    var personal_categroy=[];
    var personalinvoicefrom=[];
    var controller_url="<?php echo base_url(); ?>" + '/index.php/EXPENSE/PERSONAL/Ctrl_Personal_Daily_Entry_Search_Update_Delete/' ;
    //LIST BOX ITEM CHANGE FUNCTION
    $('.PE_rd_selectform').click(function(){
        var listboxoption=$(this).val();
        if(listboxoption=='entryform')
        {
            $('#PE_searchform').hide();
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url+"commondata",
                data:{"ErrorList":'105,106,400,401'},
                success: function(res) {
                    $('.preloader').hide();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    var arrayvalues=JSON.parse(res);
                    error_message=arrayvalues[4];
                    perinvfrom=arrayvalues[5];
                    //EXPENSE TYPE
                    expensetype='<option>SELECT</option>';
                    for (var i=0;i<arrayvalues[0].length;i++) {
                        expensetype += '<option value="' + arrayvalues[0][i].ECN_ID + '">' + arrayvalues[0][i].ECN_DATA + '</option>';
                    }
                    $('#PE_lb_expensetype').html(expensetype);

                    //PERSONALEXPENSETYPE
                    perexptype='<option>SELECT</option>';
                    for (var j=0;j<arrayvalues[1].length;j++) {
                        perexptype += '<option value="' + arrayvalues[1][j].ECN_ID + '">' + arrayvalues[1][j].ECN_DATA + '</option>';
                    }

                    //BABYEXPENSETYPE
                    babyexptype='<option>SELECT</option>';
                    for (var k=0;k<arrayvalues[2].length;k++) {
                        babyexptype += '<option value="' + arrayvalues[2][k].ECN_ID + '">' + arrayvalues[2][k].ECN_DATA + '</option>';
                    }

                    //CAREXPENSE TYPE
                    var carexptype='<option>SELECT</option>';
                    for (var l=0;l<arrayvalues[3].length;l++) {
                        carexptype += '<option value="' + arrayvalues[3][l].ECN_ID + '">' + arrayvalues[3][l].ECN_DATA + '</option>';
                    }
                    $('#PCE_lb_ctry').html(carexptype);

                    //PERSONAL EXPENSE FROM
                    for(var m=0;m<perinvfrom.length;m++)
                    {
                        if(perinvfrom[m].EP_INVOICE_FROM!='' && perinvfrom[m].EP_INVOICE_FROM!=null)
                            invfromarray.push(perinvfrom[m].EP_INVOICE_FROM);
                    }
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
            $('#PE_entryform').show();
            $('#entrytypeexpense').show();
            $('#PE_lb_expensetype').val('SELECT').show();
            $('#form_baby').hide();
            $('#form_car').hide();
            $('#form_carloan').hide();
        }
        else if(listboxoption=='searchform')
        {
            $('#PE_entryform').hide();
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url+"srchupdatecommondata",
                data:{"ErrorList":'2,20,45,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,134,140,170,209,210,211,212,315,401'},
                success: function(res) {
                    $('.preloader').hide();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    var searcharrayvalues=JSON.parse(res);
                    PDLY_SEARCH_expensepersonalArray=searcharrayvalues[0];
                    PDLY_SEARCH_expensecarloanArray=searcharrayvalues[3];
                    PDLY_SEARCH_expensecarArray=searcharrayvalues[2];
                    PDLY_SEARCH_expensebabyArray=searcharrayvalues[1];
                    var PDLY_SEARCH_errmsgarr=searcharrayvalues[7];
                    $(".PDLY_SEARCH_class_numonly").prop("title",PDLY_SEARCH_errmsgarr[0]);
                    for(var e=0;e<=PDLY_SEARCH_errmsgarr.length-1;e++){
                        PDLY_SEARCH_hdrmsgArray[e]=PDLY_SEARCH_errmsgarr[e+1];
                    }
                    PDLY_SEARCH_babyexpensecategArray=searcharrayvalues[4];
                    PDLY_SEARCH_errorArraye=searcharrayvalues[8];
                    PDLY_SEARCH_carexpensecategArray=searcharrayvalues[5];
                    PDLY_SEARCH_personalexpensecategArray=searcharrayvalues[6];
                    PDLY_SEARCH_dataArray=searcharrayvalues[0];
                    baby_category=searcharrayvalues[9];
                    car_category=searcharrayvalues[10];
                    personal_categroy=searcharrayvalues[11];
                    var invfromarray=searcharrayvalues[12];
                    var PDLY_SEARCH_options ='';
                    for (var i = 0; i < PDLY_SEARCH_errorArraye.length; i++) {
                        if(i>=0 && i<=3)
                        {
                            PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
                        }
                    }
                    $('#PDLY_SEARCH_lb_typelist').html(PDLY_SEARCH_options);
                    PDLY_SEARCH_Sortit('PDLY_SEARCH_lb_typelist');
                    //PERSONAL EXPENSE FROM
                    for(var m=0;m<invfromarray.length;m++)
                    {
                        if(invfromarray[m].EP_INVOICE_FROM!='' && invfromarray[m].EP_INVOICE_FROM!=null)
                            personalinvoicefrom.push(invfromarray[m].EP_INVOICE_FROM);
                    }
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
            $('#PE_searchform').show();
            $('#typesearchlb').show();
            $('#PDLY_SEARCH_lb_typelist').val('SELECT').show();
            $('#searchoption').hide();
            $("#PDLY_SEARCH_tble_searchtable").hide();
            $('#PDLY_SEARCH_lbl_bybabycmts').hide();
            $('#PDLY_SEARCH_lbl_flextableheader').hide();
            $('#PDLY_SEARCH_div_htmltable').hide();
            $('#PDLY_btn_pdf').hide();
            $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        }
        else
        {
            $('#PE_searchform').hide();
            $('#PE_entryform').hide();
        }
    });
// CHANGE FUNCTION FOR EXPENSE TYPE
    $('#PE_lb_expensetype').change(function(){
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        PDLY_SEARCH_clear_multirow()
        $("#form_car").find('input:text, input:password, input:file, textarea').val('');
        $("#form_car").find('select').val('SELECT');
        $("#form_carloan").find('input:text, input:password, input:file, textarea').val('');
        $("#form_carloan").find('select').val('SELECT');
        $('#PDLY_INPUT_btn_bbypsnlsbutton').attr("disabled", "disabled");
        var expensetype=$(this).val();
        if(expensetype==36)
        {
            $('#PDLY_INPUT_lb_category1').html(babyexptype);
            $('#form_baby').show();
            $('#PDLY_INPUT_tble_multi').show();
            $('#form_car').hide();
            $('#form_carloan').hide();
        }
        else if(expensetype==35)
        {
            $('#form_baby').hide();
            $('#form_car').show();
            $('#form_carloan').hide();
        }
        else if(expensetype==38)
        {
            $('#form_carloan').show();
            $('#form_baby').hide();
            $('#form_car').hide();
        }
        else if(expensetype==37)
        {
            $('#PDLY_INPUT_lb_category1').html(perexptype);
            $('#form_carloan').hide();
            $('#form_baby').show();
            $('#PDLY_INPUT_tble_multi').show();
            $('#form_car').hide();
        }
        else
        {

            $('#form_carloan').hide();
            $('#form_baby').hide();
            $('#PDLY_INPUT_tble_multi').hide();
            $('#form_car').hide();
        }
    });

// FUNCTION FOR MULTIROW
    function PDLY_SEARCH_clear_multirow(){
        $('#PDLY_INPUT_tble_multi').empty();
        $('<tr><td nowrap><label  id="PDLY_INPUT_lbl_expense" >CATEGORY OF EXPENSE<em>*</em></label></td><td style="max-width: 150px;" nowrap><label  id="PDLY_INPUT_lbl_invdate" >INVOICE DATE<em>*</em></label></td><td style="max-width:200px;" nowrap><label id="PDLY_INPUT_lbl_invamt" >INVOICE AMOUNT<em>*</em></label> </td><td ><label id="PDLY_INPUT_lbl_invitm" >INVOICE ITEMS<em>*</em></label> </td><td ><label id="PDLY_INPUT_lbl_invfrom" >INVOICE FROM<em>*</em></label> </td><td><label id="PDLY_INPUT_lbl_invcmt" >COMMENTS</label></td></tr><tr><td> <select class="submultivalid form-control"   name="PDLY_INPUT_lb_category[]" id="PDLY_INPUT_lb_category1"  ><option >SELECT</option> </select> </td> <td><input class=" form-control date-picker submultivalid datemandtry"   type="text" name ="PDLY_INPUT_db_invdate[]" id="PDLY_INPUT_db_invdate1" style="max-width:100px;" /> </td><td><input   type="text" name ="PDLY_INPUT_tb_incamtrp[]" id="PDLY_INPUT_tb_incamtrp1"  class="form-control amtonly submultivalid" style="max-width:90px;"   /></td><td><textarea class="form-control submultivalid PDLY_INPUT_ta_cmtItem"   name="PDLY_INPUT_ta_invitem[]" id="PDLY_INPUT_ta_invitem1"   ></textarea></td><td><input class="form-control submultivalid autosize autocompinc"  type="text" name ="PDLY_INPUT_tb_invfrom[]" id="PDLY_INPUT_tb_invfrom1" maxlength="200" /></td><td><textarea  class=" form-control submultivalid PDLY_INPUT_ta_cmtItem" name ="PDLY_INPUT_tb_comments[]" id="PDLY_INPUT_tb_comments1" ></textarea></td><td><input enabled type="button" disabled value="+" class="addbttn" alt="Add Row" style="max-height: 30px; max-width:30px;" name ="PDLY_INPUT_btn_addbtn" id="PDLY_INPUT_btn_addbtn1" disabled/></td><td><input  type="button" value="-" class="deletebttn" alt="delete Row" style="max-height: 30px; max-width:30px;" name ="PDLY_INPUT_btn_delbtn" id="PDLY_INPUT_btn_delbtn1"  disabled /></td></tr>').appendTo($('#PDLY_INPUT_tble_multi'));
        $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
        $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $(".date-picker").datepicker({dateFormat:'dd-mm-yy', changeYear: true, changeMonth: true});
        $('.date-picker').datepicker("option","maxDate",new Date());
    }
//<!-- MULTI ROW CREATION->
    var incid=1;
    var PDLY_INPUT_inc_id;
    $(document).on('click','.addbttn',function() {
        $('#PDLY_INPUT_btn_bbypsnlsbutton').attr("disabled", "disabled");
        $('#PDLY_INPUT_btn_delbtn1').removeAttr("disabled");
        var PDLY_INPUT_table = document.getElementById('PDLY_INPUT_tble_multi');
        var PDLY_INPUT_rowCount = PDLY_INPUT_table.rows.length;
        incid =  PDLY_INPUT_rowCount;
        $('#PDLY_INPUT_hidetablerowid').val(incid);
        var PDLY_INPUT_deladdrem =incid-1;
        var PDLY_INPUT_deladdid=$('#PDLY_INPUT_hideaddid').val();
        var PDLY_INPUT_delremoid=$('#PDLY_INPUT_hideremoveid').val();
        $(PDLY_INPUT_deladdid).hide();
        $(PDLY_INPUT_delremoid).hide();
        $('#PDLY_INPUT_btn_addbtn1').hide();
        $('#PDLY_INPUT_btn_delbtn1').hide();
        $('#PDLY_INPUT_btn_addbtn'+PDLY_INPUT_deladdrem).hide();
        $('#PDLY_INPUT_btn_delbtn'+PDLY_INPUT_deladdrem).hide();
        var newRow = PDLY_INPUT_table.insertRow(PDLY_INPUT_rowCount);
        var fCell =     newRow.insertCell(0);
        fCell.innerHTML ="<td> <select  class='submultivalid form-control' name='PDLY_INPUT_lb_category[]' id='"+"PDLY_INPUT_lb_category"+incid+"' ><option >SELECT</option></select> </td> "
        fCell = newRow.insertCell(1);
        fCell.innerHTML ="<td><input  class='submultivalid form-control date-picker datemandtry' type='text' name ='PDLY_INPUT_db_invdate[]' id='"+"PDLY_INPUT_db_invdate"+incid+"' style='max-width:100px;' /> </td>"
        fCell = newRow.insertCell(2);
        $(".date-picker").datepicker({dateFormat:'dd-mm-yy',
            changeYear: true,
            changeMonth: true,
            onClose: function(  ) {
                PDLY_INPUT_submultivalidfunction();
            }
        });
        $('.date-picker').datepicker("option","maxDate",new Date());
        fCell.innerHTML ="<td><input  class='submultivalid form-control amtonlyinc' type='text'  name ='PDLY_INPUT_tb_incamtrp[]' id='"+"PDLY_INPUT_tb_incamtrp"+incid+"' style='max-width:90px;'/></td>"
        fCell = newRow.insertCell(3);
        $(".amtonlyinc").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        fCell.innerHTML ="<td><textarea class='submultivalid form-control PDLY_INPUT_ta_cmtItem'  type='text' name='PDLY_INPUT_ta_invitem[]' id='"+"PDLY_INPUT_ta_invitem"+incid+"'></textarea></td>"
        fCell = newRow.insertCell(4);
        fCell.innerHTML ="<td><input  class='submultivalid form-control autosize autocompinc' type='text' name ='PDLY_INPUT_tb_invfrom[]' id='"+"PDLY_INPUT_tb_invfrom"+incid+"' maxlength='200'/></td>"
        fCell = newRow.insertCell(5);
        $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
        fCell.innerHTML = "<td><textarea  class='submultivalid form-control PDLY_INPUT_ta_cmtItem' type='text' name ='PDLY_INPUT_tb_comments[]' id='"+"PDLY_INPUT_tb_comments"+incid+"'></textarea></td>"
        fCell = newRow.insertCell(6);
        fCell.innerHTML ="<td><input type='button' value='+' class='addbttn' alt='Add Row' style='max-height: 30px; max-width:30px;' name ='PDLY_INPUT_btn_addbtn' id='"+"PDLY_INPUT_btn_addbtn"+incid+"'/></td>";
        fCell = newRow.insertCell(7);
        fCell.innerHTML ="<td><input  type='button' value='-' class='deletebttn' alt='delete Row' style='max-height: 30px; max-width:30px;' name ='PDLY_INPUT_btn_delbtn' id='"+"PDLY_INPUT_btn_delbtn"+incid+"' /></td>";
        $('#PDLY_INPUT_btn_addbtn'+incid).attr("disabled", "disabled");
        var PDLY_INPUT_expensetype=$('#PDLY_INPUT_lb_typelist').val();
        PDLY_INPUT_loadcategorymultirow();
    });
    //CALL FUNCTION TO HIGHLIGHT SEARCH TEXT//
    $(document).on('keypress','.autocompinc',function() {
        var PDLY_INPUT_getthisid=$(this).attr('id');
        PDLY_INPUT_inc_id=PDLY_INPUT_getthisid.replace( /^\D+/g, '');
        PDLY_SEARCH_invfromhighlightSearchText();
        var PDLY_INPUT_expensetype=$('#PE_lb_expensetype').val();
        if(PDLY_INPUT_expensetype==37)
        {
            $("#PDLY_INPUT_tb_invfrom"+PDLY_INPUT_inc_id).autocomplete({
                source: invfromarray,
                select: PDLY_SEARCH_invfromAutoCompleteSelectHandler
            });
        }
    });

//FUNCTION TO HIGHLIGHT SEARCH TEXT//
    function PDLY_SEARCH_invfromhighlightSearchText() {
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        };}
//FUNCTION TO GET SELECTED VALUE//
    function PDLY_SEARCH_invfromAutoCompleteSelectHandler(event, ui) {
    }

    function PDLY_INPUT_submultivalidfunction()
    {
        var STDLY_INPUT_table = document.getElementById('PDLY_INPUT_tble_multi');
        var STDLY_INPUT_table_rowlength=STDLY_INPUT_table.rows.length;
        var count=0;
        for(var i=1;i<STDLY_INPUT_table_rowlength;i++)
        {
            var unit=$('#PDLY_INPUT_lb_category'+i).val();
            var invoicedate=$('#PDLY_INPUT_db_invdate'+i).val();
            var fromdate=$('#PDLY_INPUT_tb_invfrom'+i).val();
            var todate=$('#PDLY_INPUT_ta_invitem'+i).val();
            var payment=$('#PDLY_INPUT_tb_incamtrp'+i).val();
            if((unit!=undefined)&&(unit!="SELECT")&&(unit!='')&&(payment!='')&&(parseInt(payment)!=0)&&(fromdate!="")&&(todate!="")&&(fromdate!=undefined)&&(todate!=undefined)&&(invoicedate!=''))
            {
                count=count+1;
            }
        }
        if(count==STDLY_INPUT_table_rowlength-1)
        {
            $('#PDLY_INPUT_btn_bbypsnlsbutton').removeAttr("disabled");
            $('#PDLY_INPUT_btn_addbtn'+(STDLY_INPUT_table_rowlength-1)).removeAttr("disabled");
        }
        else
        {
            $('#PDLY_INPUT_btn_bbypsnlsbutton').attr("disabled", "disabled");
            $('#PDLY_INPUT_btn_addbtn'+(STDLY_INPUT_table_rowlength-1)).attr("disabled", "disabled");
        }
    }

//INCREAMENT THE MULTIROW//
    function PDLY_INPUT_loadcategorymultirow()
    {
        var expensetype=$('#PE_lb_expensetype').val();
        if(expensetype==36)
        {
            var PDLY_INPUT_val=$('#PDLY_INPUT_hidetablerowid').val();
            $('#PDLY_INPUT_lb_category'+(PDLY_INPUT_val)).html(babyexptype);
        }
        else if(expensetype==37)
        {
            var PDLY_INPUT_val=$('#PDLY_INPUT_hidetablerowid').val();
            $('#PDLY_INPUT_lb_category'+(PDLY_INPUT_val)).html(perexptype);
        }
    }

//SUBMIT BUTTON VALIDATION FOR MULTIROW .........................
    $(document).on('blur','.submultivalid',function() {
        PDLY_INPUT_submultivalidfunction();
    });
//DELETE THE MULTIROW  ...................................
    $(document).on('click','.deletebttn',function() {
        var table = document.getElementById('PDLY_INPUT_tble_multi');
        var PDLY_INPUT_showbuttonlen=table.rows.length;
        if(table.rows.length>2)
            $(this).closest("tr").remove();
        var PDLY_INPUT_showbutton=PDLY_INPUT_showbuttonlen-2;
        var PDLY_INPUT_id=$(this).attr('id');
        var PDLY_INPUT_lyid=PDLY_INPUT_id.replace( /^\D+/g, '');
        PDLY_INPUT_lyid=PDLY_INPUT_lyid-1;
        var PDLY_INPUT_add='#PDLY_INPUT_btn_addbtn'+PDLY_INPUT_lyid;
        var PDLY_INPUT_del='#PDLY_INPUT_btn_delbtn'+PDLY_INPUT_lyid;
        $(PDLY_INPUT_add).show();
        $(PDLY_INPUT_del).show();
        $('#PDLY_INPUT_btn_addbtn'+PDLY_INPUT_showbutton).show();
        $('#PDLY_INPUT_btn_delbtn'+PDLY_INPUT_showbutton).show();
        if(PDLY_INPUT_showbuttonlen==3)
        {
            $('#PDLY_INPUT_btn_delbtn'+PDLY_INPUT_lyid).attr("disabled", "disabled");
            $('#PDLY_INPUT_btn_delbtn1').attr("disabled", "disabled");
        }
        $('#PDLY_INPUT_hideaddid').val(PDLY_INPUT_add);
        $('#PDLY_INPUT_hideremoveid').val(PDLY_INPUT_del);
        $('#PDLY_INPUT_btn_bbypsnlsbutton').removeAttr("disabled");
        if(table.rows.length<2)
        {
            if(($("#PDLY_INPUT_lb_category1").val()=="SELECT")||($("#PDLY_INPUT_db_invdate1").val()=="")||($("#PDLY_INPUT_tb_incamtrp1").val()=="")||($("#PDLY_INPUT_ta_invitem1").val()=="")||($("#PDLY_INPUT_tb_invfrom1").val()==""))
            {
                $('#PDLY_INPUT_btn_bbypsnlsbutton').attr("disabled", "disabled");
                $('#PDLY_INPUT_btn_addbtn1').attr("disabled", "disabled");
            }
            else
            {
                $('PDLY_INPUT_btn_delbtn1').attr("disabled", "disabled");
                $('#PDLY_INPUT_btn_addbtn1').removeAttr("disabled");
                $('PDLY_INPUT_btn_delbtn1').show();
                $('#PDLY_INPUT_btn_addbtn1').show();
                $('#PDLY_INPUT_btn_bbypsnlsbutton').show();
            }
        }
        PDLY_INPUT_submultivalidfunction()
    });
//CAR EXPENSE VALIDATION.........................
    $(document).on('change blur','.carsubmultivalid',function() {
        carsubmultivalidfunct();
    });
//CARLOAN EXPENSE VALIDATION//
    $(document).on('blur change','.carloansubmultivalid',function() {
        carsubmultivalidfunct();
    });
//CAR EXPENSE VALIDATION FUNCTION//
    function carsubmultivalidfunct()
    {
        var PDLY_INPUT_expensetype=$('#PE_lb_expensetype').val();
        if(PDLY_INPUT_expensetype==35)
        {
            if(($("#PCE_lb_ctry").val()=="SELECT")||($("#PCE_tb_invdate").val()=="")||($("#PCE_tb_invamt").val()=="")||(parseInt($("#PCE_tb_invamt").val())==0)||($("#PCE_ta_invitems").val()=="")||($("#PCE_tb_invfrom").val()==""))
            {
                $('#PCE_save_btn').attr("disabled", "disabled");
            }
            else
            {
                $('#PCE_save_btn').removeAttr("disabled");
            }
        }
        else if(PDLY_INPUT_expensetype==38)
        {
            if(($("#PCLE_tb_invamt").val()=="")||(parseInt($("#PCLE_tb_invamt").val())==0)||($("#PCLE_tb_fromperiod").val()=="")||($("#PCLE_ta_toperiod").val()=="")||($("#PCLE_tb_paiddte").val()==""))
            {
                $('#PCLE_save_btn').attr("disabled", "disabled");
            }
            else
            {
                $('#PCLE_save_btn').removeAttr("disabled");
            }
        }
    }
    $('#PCLE_tb_fromperiod') .datepicker( "option", "maxDate", new Date() );
    $('#PCLE_ta_toperiod') .datepicker( "option", "maxDate", new Date() );
    $(".date-picker").datepicker({dateFormat:'dd-mm-yy',
        changeYear: true,
        changeMonth: true,
        onClose: function() {
            var PDLY_INPUT_expensetype=$('#PE_lb_expensetype').val();
            if(PDLY_INPUT_expensetype==36 || PDLY_INPUT_expensetype==37)
            {
                PDLY_INPUT_submultivalidfunction();
            }
        }
    });
    $('.date-picker').datepicker("option","maxDate",new Date());
//<!--RESET THE ELEMENT IN THE FORM......................-->
    $('.resetbtn').click(function(){
        var PDLY_INPUT_expensetype=$('#PE_lb_expensetype').val();
        if(PDLY_INPUT_expensetype==35)
        {
            $("#PCE_tb_invfrom").prop("size","20");//set default size for textbox
            $('#PCE_tb_invdate').val('');
            $('#PCE_tb_invamt').val('');
            $('#PCE_ta_invitems').val('');
            $('#PCE_tb_invfrom').val('');
            $('#PCE_ta_comments').val('');
            $("select#PCE_lb_ctry").val('SELECT');
            $('#PCE_save_btn').attr("disabled", "disabled");
        }
        if(PDLY_INPUT_expensetype==38)
        {
            $('#PCLE_tb_invamt').val('');
            $('#PCLE_ta_toperiod').val('');
            $('#PCLE_tb_fromperiod').val('');
            $('#PCLE_tb_paiddte').val('');
            $('#PCLE_ta_comments').val('');
            $('#PCLE_save_btn').attr("disabled", "disabled");
            $('#PCLE_tb_fromperiod') .datepicker( "option", "maxDate", null );
            $('#PCLE_ta_toperiod') .datepicker( "option", "maxDate", null );
            $('#PCLE_tb_fromperiod') .datepicker( "option", "maxDate", new Date() );
            $('#PCLE_ta_toperiod') .datepicker( "option", "maxDate", new Date() );
        }
    });
    //<!-- DATE PICKER FOR THE CAR LOAN ENTRY -->
    $(document).on('change','#PCLE_tb_paiddte',function() {
        var PDLY_INPUT_datep = $('#PCLE_tb_paiddte').datepicker('getDate');
        var date = new Date( Date.parse( PDLY_INPUT_datep ) );
        date.setDate( date.getDate() );
        var PDLY_INPUT_newDate = date.toDateString();
        PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
        $('#PCLE_tb_fromperiod').datepicker("option","maxDate",PDLY_INPUT_newDate);
        $('#PCLE_ta_toperiod').datepicker("option","maxDate",PDLY_INPUT_newDate);
        carsubmultivalidfunct();
    });
//DATE PICKER FUNCTION FOR  FOR DATEBOX IN SALARY ENTRY...............
    $(document).on('change','#PCLE_tb_fromperiod',function() {
        var PDLY_INPUT_fromdate = $('#PCLE_tb_fromperiod').datepicker('getDate');
        var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
        date.setDate( date.getDate()  ); //+ 1
        var PDLY_INPUT_newDate = date.toDateString();
        PDLY_INPUT_newDate = new Date( Date.parse( PDLY_INPUT_newDate ) );
        $('#PCLE_ta_toperiod').datepicker("option","minDate",PDLY_INPUT_newDate);
        var paiddate = $('#PCLE_tb_paiddte').datepicker('getDate');
        var date = new Date( Date.parse( paiddate ) );
        date.setDate( date.getDate()  );
        var paidnewDate = date.toDateString();
        paidnewDate = new Date( Date.parse( paidnewDate ) );
        $('#PCLE_ta_toperiod').datepicker("option","maxDate",paidnewDate);
        carsubmultivalidfunct();
    });
//DATE PICKER FOR TO DATE IN THE  SALARY ENTRY.....................
    $(document).on('change','#PCLE_ta_toperiod',function() {
        var PDLY_INPUT_fromdate = $('#PCLE_tb_fromperiod').datepicker('getDate');
        var date = new Date( Date.parse( PDLY_INPUT_fromdate ) );
        date.setDate( date.getDate()  ); //+ 1
        var newDate = date.toDateString();
        newDate = new Date( Date.parse( newDate ) );
        $('#PCLE_ta_toperiod').datepicker("option","minDate",newDate);
        var PDLY_INPUT_paiddate = $('#PCLE_tb_paiddte').datepicker('getDate');
        var date = new Date( Date.parse( PDLY_INPUT_paiddate ) );
        date.setDate( date.getDate() ); // - 1
        var PDLY_INPUT_paidnewDate = date.toDateString();
        PDLY_INPUT_paidnewDate = new Date( Date.parse( PDLY_INPUT_paidnewDate ) );
        $('#PCLE_ta_toperiod').datepicker("option","maxDate",PDLY_INPUT_paidnewDate);
        carsubmultivalidfunct();
    });
//CAR EXPENSE SAVE FUNCTION
    $('#PCE_save_btn').click(function(){
        $('.preloader').show();
        $.ajax({
            type: "POST",
            data: $('#personalexpense').serialize(),
            url: controller_url+"carexpensesave",
            success: function(res) {
                $('.preloader').hide();
                if(res==1)
                {
                    var PDLY_INPUT_expensetypetext=$('#PE_lb_expensetype').find('option:selected').text();
                    var PDLY_INPUT_CONFSAVEMSG =error_message[0].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetypetext);
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_INPUT_CONFSAVEMSG,"success",false)
                    carexpenseclear();
                }
                else
                {
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",error_message[2].EMC_DATA,"success",false)
                    carexpenseclear();
                }
            },
            error: function (data) {
                alert('error in getting' + JSON.stringify(data));
            }
        });
    });
    function carexpenseclear(){
        $('#PCE_tb_invdate').val('');
        $('#PCE_tb_invamt').val('');
        $('#PCE_ta_invitems').val('');
        $('#PCE_tb_invfrom').val('');
        $('#PCE_ta_comments').val('');
        $('#PCE_save_btn').attr("disabled", "disabled");
        $('#PCE_lb_ctry').prop('selectedIndex',0);
    }
// CAR LOAN SAVE FUNCTION
    $('#PCLE_save_btn').click(function(){
        $('.preloader').show();
        $.ajax({
            type: "POST",
            data: $('#personalexpense').serialize(),
            url: controller_url+"carloansave",
            success: function(res) {
                $('.preloader').hide();
                if(res==1)
                {
                    var PDLY_INPUT_expensetypetext=$('#PE_lb_expensetype').find('option:selected').text();
                    var PDLY_INPUT_CONFSAVEMSG =error_message[0].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetypetext);
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_INPUT_CONFSAVEMSG,"success",false)
                    carloaneclear();
                }
                else
                {
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",error_message[2].EMC_DATA,"success",false)
                    carloaneclear();
                }
            },
            error: function (data) {
                alert('error in getting' + JSON.stringify(data));
            }
        });
    });
    function carloaneclear(){
        $('#PCLE_tb_invamt').val('');
        $('#PCLE_ta_comments').val('');
        $('#PCLE_ta_toperiod').val('');
        $('#PCLE_tb_fromperiod').val('');
        $('#PCLE_tb_paiddte').val('');
        $('#PCLE_save_btn').attr("disabled", "disabled");
        $('#PCLE_tb_fromperiod') .datepicker( "option", "maxDate", new Date() );
        $('#PCLE_ta_toperiod') .datepicker( "option", "maxDate", new Date() );
        $('#PCLE_tb_fromperiod') .datepicker( "option", "minDate", null );
        $('#PCLE_ta_toperiod') .datepicker( "option", "minDate", null );
    }

//EXPENSE BABY AND PERSONAL SAVE FUNCTION
    $('#PDLY_INPUT_btn_bbypsnlsbutton').click(function(){
        $('.preloader').show();
        $.ajax({
            type: "POST",
            data: $('#personalexpense').serialize(),
            url: controller_url+"babypersonalsave",
            success: function(res) {
                $('.preloader').hide();
                var result_value=JSON.parse(res);
                var resultflag=result_value[0].FLAG_INSERT;
                if(resultflag==1)
                {
                    var PDLY_INPUT_expensetypetext=$('#PE_lb_expensetype').find('option:selected').text();
                    var PDLY_INPUT_CONFSAVEMSG =error_message[0].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetypetext);
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_INPUT_CONFSAVEMSG,"success",false);
                    PDLY_SEARCH_clear_multirow();
                    var expensetype=$('#PE_lb_expensetype').find('option:selected').val();
                    if(expensetype==36)
                    {
                        $('#PDLY_INPUT_lb_category1').html(babyexptype);
                    }
                    else if(expensetype=37)
                    {
                        $('#PDLY_INPUT_lb_category1').html(perexptype);
                    }
                    $('#PDLY_INPUT_btn_bbypsnlsbutton').attr('disabled','disabled');

                }
                else
                {
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",error_message[2].EMC_DATA,"success",false)
                    PDLY_SEARCH_clear_multirow();
                    var expensetype=$('#PE_lb_expensetype').find('option:selected').val();
                    if(expensetype==36)
                    {
                        $('#PDLY_INPUT_lb_category1').html(babyexptype);
                    }
                    else if(expensetype=37)
                    {
                        $('#PDLY_INPUT_lb_category1').html(perexptype);
                    }
                    $('#PDLY_INPUT_btn_bbypsnlsbutton').attr('disabled','disabled');
                }
            },
            error: function (data) {
                alert('error in getting' + JSON.stringify(data));
            }
        });
    });
    <!--functionalties of update form-->
    //CALL FUNCTION TO HIGHLIGHT SEARCH TEXT//
    $( "#PDLY_SEARCH_tb_searchabycmt" ).keypress(function(){
        $('#PDLY_SEARCH_btn_babybutton').hide();
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_btn_pdf').hide();
        $('#PDLY_SEARCH_btn_searchbutton').hide();
        $('#PDLY_SEARCH_btn_deletebutton').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $('#PDLY_SEARCH_btn_sbutton,#PDLY_SEARCH_btn_rbutton').hide();
        if($( "#PDLY_SEARCH_tb_searchabycmt" ).val()=="")
        {
            $('#PDLY_SEARCH_btn_babybutton').hide();
        }
        PDLY_SEARCH_highlightSearchText();
        $( "#PDLY_SEARCH_tb_searchabycmt" ).autocomplete({
            source: csearchval,
            select: PDLY_SEARCH_AutoCompleteSelectHandler
        });
    });
//FUNCTION TO HIGHLIGHT SEARCH TEXT//
    function PDLY_SEARCH_highlightSearchText() {
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        };
    }
//FUNCTION TO GET SELECTED VALUE//
    function PDLY_SEARCH_AutoCompleteSelectHandler(event, ui) {
        $('#PDLY_SEARCH_btn_babybutton').show();
        $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
    }
//CALL FUNCTION TO HIGHLIGHT SEARCH TEXT//
    $( "#PDLY_SEARCH_tb_searchbyinvfrom" ).keypress(function(){
        $('#PDLY_SEARCH_btn_babybutton').hide();
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_btn_pdf').hide();
        $('#PDLY_SEARCH_btn_searchbutton').hide();
        $('#PDLY_SEARCH_btn_deletebutton').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $('#PDLY_SEARCH_btn_sbutton,#PDLY_SEARCH_btn_rbutton').hide();
        PDLY_SEARCH_invfromhighlightSearchText();
        $( "#PDLY_SEARCH_tb_searchbyinvfrom" ).autocomplete({
            source: Ivsearchval,
            select: PDLY_SEARCH_invfromAutoCompleteSelectHandler
        });
    });
//CALL FUNCTION TO HIGHLIGHT SEARCH TEXT//
    $( "#PDLY_SEARCH_tb_searchbyinvitem" ).keypress(function(){
        PDLY_SEARCH_invfromhighlightSearchText();
        $('#PDLY_SEARCH_btn_babybutton').hide();
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_btn_pdf').hide();
        $('#PDLY_SEARCH_btn_searchbutton').hide();
        $('#PDLY_SEARCH_btn_deletebutton').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $('#PDLY_SEARCH_btn_sbutton,#PDLY_SEARCH_btn_rbutton').hide();
        $( "#PDLY_SEARCH_tb_searchbyinvitem" ).autocomplete({
            source: itmIvsearchval,
            select: PDLY_SEARCH_invfromAutoCompleteSelectHandler
        });
    });
//FUNCTION TO HIGHLIGHT SEARCH TEXT//
    function PDLY_SEARCH_invfromhighlightSearchText() {
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        };
    }
//FUNCTION TO GET SELECTED VALUE//
    function PDLY_SEARCH_invfromAutoCompleteSelectHandler(event, ui) {
        $('#PDLY_SEARCH_btn_babybutton').show();
        $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
    }
//SORTING
    function PDLY_SEARCH_Sortit(lbid) {
        var $r = $("#"+lbid+" "+"option");
        $r.sort(function(a,b){
            if (a.text < b.text) return -1;
            if (a.text == b.text) return 0;
            return 1;
        });
        $($r).remove();
        $("#"+lbid).append($($r));
        $("#"+lbid+" "+"option").eq(0).before('<option value="SELECT">SELECT</option>')
        $("select#"+lbid)[0].selectedIndex = 0;
    }
//SEARCH BY TYPE OF EXPENSE//
    $('#PDLY_SEARCH_lb_typelist').change(function(){
        $(".preloader").show();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        $("#PDLY_SEARCH_lbl_bybabycmts").hide();
        $("#PDLY_SEARCH_tble_multi").hide();
        $("#PDLY_SEARCH_tble_searchtable").hide();
        $("#PDLY_SEARCH_btn_babybutton").hide();
        $("#PDLY_SEARCH_div_htmltable").hide();
        $('#PDLY_btn_pdf').hide();
        $("#PDLY_SEARCH_btn_searchbutton").hide();
        $("#PDLY_SEARCH_btn_deletebutton").hide();
        $('#PDLY_SEARCH_btn_sbutton').hide();
        $('#PDLY_SEARCH_btn_rbutton').hide();
        $('#PDLY_SEARCH_lb_babysearchoption').hide();
        $('#PDLY_SEARCH_lbl_babysearchoption').hide();
        var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
        if(PDLY_SEARCH_lb_typelistvalue=="SELECT")
        {
            $(".preloader").hide();
            $('#PDLY_SEARCH_lbl_flextableheader').hide();
            $("#PDLY_SEARCH_lbl_bybabycmts").hide();
            $("#PDLY_SEARCH_tble_multi").hide();
            $("#PDLY_SEARCH_tble_searchtable").hide();
            $("#PDLY_SEARCH_btn_babybutton").hide();
            $("#PDLY_SEARCH_div_htmltable").hide();
            $('#PDLY_btn_pdf').hide();
            $("#PDLY_SEARCH_btn_searchbutton").hide();
            $("#PDLY_SEARCH_btn_deletebutton").hide();
            $('#PDLY_SEARCH_btn_sbutton').hide();
            $('#PDLY_SEARCH_btn_rbutton').hide();
            $('#PDLY_SEARCH_lb_babysearchoption').hide();
            $('#PDLY_SEARCH_lbl_babysearchoption').hide();
        }
        if(PDLY_SEARCH_lb_typelistvalue==36)
        {
            if((PDLY_SEARCH_expensebabyArray).length==0)
            {
                $(".preloader").hide();
                $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_hdrmsgArray[32].EMC_DATA);
                $("#PDLY_SEARCH_lbl_nodataerrormsg").show();
            }
            else
            {
                $("#PDLY_SEARCH_lbl_nodataerrormsg").hide();
                PDLY_SEARCH_loadbabydata();
            }
        }
        if(PDLY_SEARCH_lb_typelistvalue==35)
        {
            if((PDLY_SEARCH_expensecarArray).length==0)
            {
                $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_hdrmsgArray[33].EMC_DATA);
                $("#PDLY_SEARCH_lbl_nodataerrormsg").show();
                $(".preloader").hide();
            }
            else
            {
                $("#PDLY_SEARCH_lbl_nodataerrormsg").hide();
                PDLY_SEARCH_loadbabydata();
            }
        }
        if(PDLY_SEARCH_lb_typelistvalue==38)
        {
            if((PDLY_SEARCH_expensecarloanArray).length==0)
            {
                $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_hdrmsgArray[34].EMC_DATA);
                $("#PDLY_SEARCH_lbl_nodataerrormsg").show();
                $(".preloader").hide();
            }
            else
            {
                $("#PDLY_SEARCH_lbl_nodataerrormsg").hide();
                PDLY_SEARCH_loadbabydata();
            }
        }
        if(PDLY_SEARCH_lb_typelistvalue==37)
        {
            if((PDLY_SEARCH_expensepersonalArray).length==0)
            {
                $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_hdrmsgArray[29].EMC_DATA);
                $("#PDLY_SEARCH_lbl_nodataerrormsg").show();
                $(".preloader").hide();
            }
            else
            {
                $("#PDLY_SEARCH_lbl_nodataerrormsg").hide();
                PDLY_SEARCH_loadbabydata();
            }
        }
    });

//LOADA THE TYPE OF SEARCH OPTION BY BABY  SEARCH//
    function PDLY_SEARCH_loadbabydata()//PDLY_SEARCH_loadbabydatavalue
    {
        $(".preloader").hide();
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
        var PDLY_SEARCH_options ='';
        for (var i = 0; i < PDLY_SEARCH_errorArraye.length; i++) {
            if(PDLY_SEARCH_lb_typelistvalue==36 && i>=4 && i<=9)
            {
                PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
            }
            if(PDLY_SEARCH_lb_typelistvalue==35 && i>=10 && i<=15)
            {
                PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
            }
            if(PDLY_SEARCH_lb_typelistvalue==38 && i>=16 && i<=20)
            {
                PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
            }
            if(PDLY_SEARCH_lb_typelistvalue==37 && i>=21 && i<=26)
            {
                PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
            }
        }
        $('#PDLY_SEARCH_lb_babysearchoption').empty();
        $('#PDLY_SEARCH_lbl_babysearchoption').show();
        $('#PDLY_SEARCH_lb_babysearchoption').html(PDLY_SEARCH_options);
        PDLY_SEARCH_Sortit('PDLY_SEARCH_lb_babysearchoption');
        $('#PDLY_SEARCH_lb_babysearchoption').show();
        $("select#PDLY_SEARCH_lb_babysearchoption")[0].selectedIndex = 0;
        $('#searchoption').show();
    }
//SEARCH BY THE BABY EXPENSE//
    $('#PDLY_SEARCH_lb_babysearchoption').change(function(){
        $(".preloader").show();
        $('#PDLY_SEARCH_db_enddate,#PDLY_SEARCH_db_startdate,#PDLY_SEARCH_tb_searchbyinvfrom').val('');
        $('#PDLY_SEARCH_lbl_searchbyinvitem,#PDLY_SEARCH_lbl_searchbyinvfrom,#PDLY_SEARCH_tb_searchbyinvfrom').hide();
        $('#div_invoicefrom').hide();
        $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
        $('#PDLY_SEARCH_btn_babybutton').hide();
        $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
        $("#PDLY_SEARCH_tble_multi").hide();
        $("#PDLY_SEARCH_lbl_bybabycmts").hide();
        $("#PDLY_SEARCH_tble_searchtable").hide();
        $("#PDLY_SEARCH_div_htmltable").hide();
        $('#PDLY_btn_pdf').hide();
        $("#PDLY_SEARCH_btn_searchbutton").hide();
        $("#PDLY_SEARCH_btn_deletebutton").hide();
        $('#PDLY_SEARCH_btn_sbutton').hide();
        $('#PDLY_SEARCH_btn_rbutton').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        if(PDLY_SEARCH_lb_babysearchoptionvalue=="SELECT")
        {
            $(".preloader").hide();
            $("#PDLY_SEARCH_lbl_bybabycmts").hide();
            $("#PDLY_SEARCH_tble_multi").hide();
            $("#PDLY_SEARCH_tble_searchtable").hide();
            $("#PDLY_SEARCH_div_htmltable").hide();
            $('#PDLY_btn_pdf').hide();
            $("#PDLY_SEARCH_btn_searchbutton").hide();
            $("#PDLY_SEARCH_btn_deletebutton").hide();
            $('#PDLY_SEARCH_btn_sbutton').hide();
            $('#PDLY_SEARCH_btn_rbutton').hide();
        }
        else if((PDLY_SEARCH_lb_babysearchoptionvalue==56)||(PDLY_SEARCH_lb_babysearchoptionvalue==62)||(PDLY_SEARCH_lb_babysearchoptionvalue==73)||(PDLY_SEARCH_lb_babysearchoptionvalue==67))
        {
            $(".preloader").hide();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
            $("#PDLY_SEARCH_tble_searchtable").show();
            $('#PDLY_SEARCH_lbl_toamount').hide();
            $('#PDLY_SEARCH_tb_toamount').hide();
            $('#div_toamt').hide();
            $('#PDLY_SEARCH_lbl_fromamount').hide();
            $('#PDLY_SEARCH_tb_fromamount').hide();
            $('#div_fromamt').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
            $('#PDLY_SEARCH_tb_searchbyinvfrom').hide();
            $('#div_invoicefrom').hide();
            $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
            $('#div_invoiceitem').hide();
            $('#PDLY_SEARCH_lbl_searchabycmt').hide();
            $('#PDLY_SEARCH_tb_searchabycmt').val('').hide();
            $('#div_comments').hide();
            $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
            $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
            $('#div_category').hide();
            $('#PDLY_SEARCH_lbl_startdate').show();
            $('#PDLY_SEARCH_db_startdate').val('').show();
            $('#div_startdate').show();
            $('#PDLY_SEARCH_lbl_enddate').show();
            $('#PDLY_SEARCH_db_enddate').val('').show();
            $('#div_enddate').show();
            $('#PDLY_SEARCH_btn_babybutton').hide();
            $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
        }
//SEARCH BY BABY CATEGORY//
        else if((PDLY_SEARCH_lb_babysearchoptionvalue==52)||(PDLY_SEARCH_lb_babysearchoptionvalue==58)||(PDLY_SEARCH_lb_babysearchoptionvalue==69))
        {
            $("#PDLY_SEARCH_tble_searchtable").show();
            $('#PDLY_SEARCH_lbl_toamount').hide();
            $('#PDLY_SEARCH_tb_toamount').hide();
            $('#div_toamt').hide();
            $('#PDLY_SEARCH_lbl_fromamount').hide();
            $('#PDLY_SEARCH_tb_fromamount').hide();
            $('#div_fromamt').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
            $('#PDLY_SEARCH_tb_searchbyinvfrom').hide();
            $('#div_invoicefrom').hide();
            $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
            $('#div_invoiceitem').hide();
            $('#PDLY_SEARCH_lbl_searchabycmt').hide();
            $('#PDLY_SEARCH_tb_searchabycmt').hide();
            $('#div_comments').hide();
            var categorydata=$('#PDLY_SEARCH_lb_babysearchoption').val();
            $.ajax({
                type: "POST",
                url: controller_url+"PDLY_SEARCH_lb_babysearchoptionvalue",
                data:'&categorydata='+categorydata,
                success: function(res) {
                    $(".preloader").hide();
                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    var PDLY_SEARCH_babyexpensecategArray=JSON.parse(res);
                    var PDLY_SEARCH_options =' <option>SELECT</option>';
                    for (var i = 0; i < PDLY_SEARCH_babyexpensecategArray.length; i++) {
                        PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_babyexpensecategArray[i].ECN_DATA + '">' + PDLY_SEARCH_babyexpensecategArray[i].ECN_DATA + '</option>';
                    }
                    var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
                    $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
                    if(PDLY_SEARCH_lb_babysearchoptionvalue==52)
                    {
                        $('#PDLY_SEARCH_lbl_babyexpansecategory').text('BABY EXPENSE CATEGORY').show();
                    }
                    if(PDLY_SEARCH_lb_babysearchoptionvalue==58)
                    {
                        $('#PDLY_SEARCH_lbl_babyexpansecategory').text('CAR EXPENSE CATEGORY').show();
                    }
                    if(PDLY_SEARCH_lb_babysearchoptionvalue==69)
                    {
                        $('#PDLY_SEARCH_lbl_babyexpansecategory').text('PERSONAL EXPENSE CATEGORY').show();
                    }
                    $('#PDLY_SEARCH_lb_babyexpansecategory').html(PDLY_SEARCH_options);
                    $('#PDLY_SEARCH_lb_babyexpansecategory').show();
                    $('#div_category').show();
                    $("select#PDLY_SEARCH_lb_babyexpansecategory")[0].selectedIndex = 0;
                    $('#PDLY_SEARCH_lbl_startdate').show();
                    $('#PDLY_SEARCH_db_startdate').val('').show();
                    $('#div_startdate').show();
                    $('#PDLY_SEARCH_lbl_enddate').show();
                    $('#PDLY_SEARCH_db_enddate').val('').show();
                    $('#div_enddate').show();
                    $('#PDLY_SEARCH_btn_babybutton').show();
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
//SEARCH BY INVOICE AMOUNT//
        else if((PDLY_SEARCH_lb_babysearchoptionvalue==51)||(PDLY_SEARCH_lb_babysearchoptionvalue==57)||(PDLY_SEARCH_lb_babysearchoptionvalue==68)||(PDLY_SEARCH_lb_babysearchoptionvalue==65))
        {
            $(".preloader").hide();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
            $("#PDLY_SEARCH_tble_searchtable").show();
            $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
            $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
            $('#div_category').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
            $('#PDLY_SEARCH_tb_searchbyinvfrom').hide();
            $('#div_invoicefrom').hide();
            $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
            $('#div_invoiceitem').hide();
            $('#PDLY_SEARCH_lbl_searchabycmt').hide();
            $('#PDLY_SEARCH_tb_searchabycmt').hide();
            $('#div_comments').hide();
            $('#PDLY_SEARCH_lbl_toamount').show();
            $('#PDLY_SEARCH_tb_toamount').val('').show();
            $('#div_toamt').show();
            $('#PDLY_SEARCH_lbl_fromamount').show();
            $('#PDLY_SEARCH_tb_fromamount').val('').show();
            $('#div_fromamt').show();
            $('#PDLY_SEARCH_lbl_startdate').show();
            $('#PDLY_SEARCH_db_startdate').val('').show();
            $('#div_startdate').show();
            $('#PDLY_SEARCH_lbl_enddate').show();
            $('#PDLY_SEARCH_db_enddate').val('').show();
            $('#div_enddate').show();
            $('#PDLY_SEARCH_btn_babybutton').show();
            $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
        }
//SEARCH BY BABY EXPENSE INVOICE DATE//
        else if((PDLY_SEARCH_lb_babysearchoptionvalue==53)||(PDLY_SEARCH_lb_babysearchoptionvalue==59)||(PDLY_SEARCH_lb_babysearchoptionvalue==70)||(PDLY_SEARCH_lb_babysearchoptionvalue==63)||(PDLY_SEARCH_lb_babysearchoptionvalue==66)||(PDLY_SEARCH_lb_babysearchoptionvalue==64))
        {
            $(".preloader").hide();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
            $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
            $("#PDLY_SEARCH_tble_searchtable").show();
            $('#PDLY_SEARCH_lbl_toamount').hide();
            $('#PDLY_SEARCH_tb_toamount').hide();
            $('#div_toamt').hide();
            $('#PDLY_SEARCH_lbl_fromamount').hide();
            $('#PDLY_SEARCH_tb_fromamount').hide();
            $('#div_fromamt').hide();
            $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
            $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
            $('#div_category').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
            $('#PDLY_SEARCH_tb_searchbyinvfrom').hide();
            $('#div_invoicefrom').hide();
            $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
            $('#div_invoiceitem').hide();
            $('#PDLY_SEARCH_lbl_searchabycmt').hide();
            $('#PDLY_SEARCH_tb_searchabycmt').hide();
            $('#div_comments').hide();
            $('#PDLY_SEARCH_lbl_startdate').show();
            $('#PDLY_SEARCH_db_startdate').val('').show();
            $('#div_startdate').show();
            $('#PDLY_SEARCH_lbl_enddate').show();
            $('#PDLY_SEARCH_db_enddate').val('').show();
            $('#div_enddate').show();
            $('#PDLY_SEARCH_btn_babybutton').show();
            $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
        }
        else if((PDLY_SEARCH_lb_babysearchoptionvalue==55)||(PDLY_SEARCH_lb_babysearchoptionvalue==61)||(PDLY_SEARCH_lb_babysearchoptionvalue==72))
        {
            $(".preloader").hide();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
            $("#PDLY_SEARCH_tble_searchtable").show();
            $('#PDLY_SEARCH_lbl_toamount').hide();
            $('#PDLY_SEARCH_tb_toamount').hide();
            $('#div_toamt').hide();
            $('#PDLY_SEARCH_lbl_fromamount').hide();
            $('#PDLY_SEARCH_tb_fromamount').hide();
            $('#div_fromamt').hide();
            $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
            $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
            $('#div_category').hide();
            $('#PDLY_SEARCH_lbl_searchabycmt').hide();
            $('#PDLY_SEARCH_tb_searchabycmt').hide();
            $('#div_comments').hide();
            $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
            $('#div_invoiceitem').hide();
            $('#PDLY_SEARCH_lbl_bybabycmts').show();
            $('#PDLY_SEARCH_lbl_searchbyinvfrom').text('INVOICE FROM').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
            $('#PDLY_SEARCH_tb_searchbyinvfrom').val('').hide();
            $('#div_invoicefrom').hide();
            $('#PDLY_SEARCH_lbl_startdate').show();
            $('#PDLY_SEARCH_db_startdate').val('').show();
            $('#div_startdate').show();
            $('#PDLY_SEARCH_lbl_enddate').show();
            $('#PDLY_SEARCH_db_enddate').val('').show();
            $('#div_enddate').show();
            $('#PDLY_SEARCH_btn_babybutton').hide();
            $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
        }
        else if((PDLY_SEARCH_lb_babysearchoptionvalue==54)||(PDLY_SEARCH_lb_babysearchoptionvalue==60)||(PDLY_SEARCH_lb_babysearchoptionvalue==71))
        {
            $(".preloader").hide();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
            $("#PDLY_SEARCH_tble_searchtable").show();
            $('#PDLY_SEARCH_lbl_toamount').hide();
            $('#PDLY_SEARCH_tb_toamount').hide();
            $('#div_toamt').hide();
            $('#PDLY_SEARCH_lbl_fromamount').hide();
            $('#PDLY_SEARCH_tb_fromamount').hide();
            $('#div_fromamt').hide();
            $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
            $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
            $('#div_category').hide();
            $('#PDLY_SEARCH_lbl_searchabycmt').hide();
            $('#PDLY_SEARCH_tb_searchabycmt').hide();
            $('#div_comments').hide();
            $('#PDLY_SEARCH_lbl_bybabycmts').show();
            $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
            $('#PDLY_SEARCH_tb_searchbyinvfrom').val('').hide();
            $('#div_invoicefrom').hide();
            $('#PDLY_SEARCH_tb_searchbyinvitem').val('').hide();
            $('#div_invoiceitem').hide();
            $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
            $('#PDLY_SEARCH_lbl_startdate').show();
            $('#PDLY_SEARCH_db_startdate').val('').show();
            $('#div_startdate').show();
            $('#PDLY_SEARCH_lbl_enddate').show();
            $('#PDLY_SEARCH_db_enddate').val('').show();
            $('#div_enddate').show();
            $('#PDLY_SEARCH_btn_babybutton').hide();
            $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
        }
    });

//DATE PICKER USED IN THE UPDATE FORM//
    $('#PDLY_SEARCH_db_invdate').datepicker("option","maxDate",new Date());
    $(".PDLY_SEARCH_db_invdate").datepicker({dateFormat:'dd-mm-yy',
        changeYear: true,
        changeMonth: true});
//DATEPICKER FOR  START DATE AND END DATE//
    $(".datebox").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,maxDate:new Date(),
        onSelect: function(date){
            PDLY_SEARCH_searchvalue();
            $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#PDLY_SEARCH_div_htmltable').hide();
            $('#PDLY_btn_pdf').hide();
            $('#PDLY_SEARCH_tble_multi').hide();
            $("#PDLY_SEARCH_btn_searchbutton").hide();
            $("#PDLY_SEARCH_btn_deletebutton").hide();
            $('#PDLY_SEARCH_btn_sbutton').hide();
            $('#PDLY_SEARCH_btn_rbutton').hide();
            $('#PDLY_SEARCH_tble_carloan').hide();
            var PDLY_SEARCH_startdate = $('#PDLY_SEARCH_db_startdate').datepicker('getDate');
            var date = new Date( Date.parse( PDLY_SEARCH_startdate ) );
            date.setDate( date.getDate() );
            var PDLY_SEARCH_newDate = date.toDateString();
            PDLY_SEARCH_newDate = new Date( Date.parse( PDLY_SEARCH_newDate ) );
            $('#PDLY_SEARCH_db_enddate').datepicker("option","minDate",PDLY_SEARCH_newDate);
            var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
            $('#PDLY_SEARCH_lbl_flextableheader').hide();
            if((PDLY_SEARCH_lb_babysearchoptionvalue==56)||(PDLY_SEARCH_lb_babysearchoptionvalue==62)||(PDLY_SEARCH_lb_babysearchoptionvalue==73)||(PDLY_SEARCH_lb_babysearchoptionvalue==67))
            {
                if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_tb_searchabycmt").val()==""))
                {
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                }
            }
//VALIDATION FOR SEARCH BUTTON (BABY EXPASE CATEGORY//
            if((PDLY_SEARCH_lb_babysearchoptionvalue==52)||(PDLY_SEARCH_lb_babysearchoptionvalue==58)||(PDLY_SEARCH_lb_babysearchoptionvalue==69))
            {
                if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_lb_babyexpansecategory").val()=="SELECT"))
                {
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                }
            }
//VALIDATION TO SEARCH ,BY BABY INVOICE AMOUNT//
            if((PDLY_SEARCH_lb_babysearchoptionvalue==51)||(PDLY_SEARCH_lb_babysearchoptionvalue==57)||(PDLY_SEARCH_lb_babysearchoptionvalue==68)||(PDLY_SEARCH_lb_babysearchoptionvalue==65))
            {
                if(($("#PDLY_SEARCH_db_startdate").val()!="")||($("#PDLY_SEARCH_db_enddate").val()!=""))
                {
                    if(($("#PDLY_SEARCH_tb_fromamount").val()!="")||($("#PDLY_SEARCH_tb_toamount").val()!=""))
                    {
                        if(ErrorControl.AmountCompare=='Valid')
                        {
                            $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                            $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                        }
                        else
                        {
                            $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                            $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1]).show();
                        }
                    }
                }
            }
//VALIDATION TO SEARCH  , SEARCH BY BABY INVOICE DATE//
            if((PDLY_SEARCH_lb_babysearchoptionvalue==53)||(PDLY_SEARCH_lb_babysearchoptionvalue==59)||(PDLY_SEARCH_lb_babysearchoptionvalue==70)||(PDLY_SEARCH_lb_babysearchoptionvalue==63)||(PDLY_SEARCH_lb_babysearchoptionvalue==66)||(PDLY_SEARCH_lb_babysearchoptionvalue==64))
            {
                if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()==""))
                {
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                }
            }
//VALIDATION TO SEARCH , SEARCH BY BABY INVOICE FROM//
            if((PDLY_SEARCH_lb_babysearchoptionvalue==55)||(PDLY_SEARCH_lb_babysearchoptionvalue==61)||(PDLY_SEARCH_lb_babysearchoptionvalue==72))
            {
                if(($("#PDLY_SEARCH_tb_searchbyinvfrom").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
                {
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                }
            }
//VALIDATION TO SEARCH , SEARCH BY STAFF INVOICE ITEMS//
            if((PDLY_SEARCH_lb_babysearchoptionvalue==54)||(PDLY_SEARCH_lb_babysearchoptionvalue==60)||(PDLY_SEARCH_lb_babysearchoptionvalue==71))
            {
                if(($("#PDLY_SEARCH_tb_searchbyinvitem").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
                {
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                }
            }
        }
    });
    var csearchval=[];
    var Ivsearchval = [];
    var itmIvsearchval = [];
    function PDLY_SEARCH_searchvalue()
    {
        $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        if(($('#PDLY_SEARCH_db_startdate').val()!="") && ($('#PDLY_SEARCH_db_enddate').val()!=""))
        {
            var PDLY_SEARCH_lb_getstartvaluevalue=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_lb_getendvaluevalue=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
            if((PDLY_SEARCH_lb_babysearchoptionvalue==56)||(PDLY_SEARCH_lb_babysearchoptionvalue==62)||(PDLY_SEARCH_lb_babysearchoptionvalue==73)||(PDLY_SEARCH_lb_babysearchoptionvalue==67))
            {
                csearchval=[];
                $('.preloader').show();
                var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
                $.ajax({
                    type: "POST",
                    url: controller_url+"PDLY_SEARCH_lb_comments",
                    data:'&PDLY_SEARCH_lb_typelistvalue='+PDLY_SEARCH_lb_typelistvalue+'&PDLY_SEARCH_lb_getstartvaluevalue='+PDLY_SEARCH_lb_getstartvaluevalue+'&PDLY_SEARCH_lb_getendvaluevalue='+PDLY_SEARCH_lb_getendvaluevalue,
                    success: function(res) {
                        $('.preloader').hide();
                        var values=JSON.parse(res);
                        if(PDLY_SEARCH_lb_typelistvalue==36)
                        {
                            for(var m=0;m<values.length;m++)
                            {
                                if(values[m].EB_COMMENTS!='' && values[m].EB_COMMENTS!=null)
                                    csearchval.push(values[m].EB_COMMENTS);
                            }
                        }
                        if(PDLY_SEARCH_lb_typelistvalue==35)
                        {
                            for(var m=0;m<values.length;m++)
                            {
                                if(values[m].EC_COMMENTS!='' && values[m].EC_COMMENTS!=null)
                                    csearchval.push(values[m].EC_COMMENTS);
                            }
                        }
                        if(PDLY_SEARCH_lb_typelistvalue==37)
                        {
                            for(var m=0;m<values.length;m++)
                            {
                                if(values[m].EP_COMMENTS!='' && values[m].EP_COMMENTS!=null)
                                    csearchval.push(values[m].EP_COMMENTS);
                            }
                        }
                        if(PDLY_SEARCH_lb_typelistvalue==38)
                        {
                            for(var m=0;m<values.length;m++)
                            {
                                if(values[m].ECL_COMMENTS!='' && values[m].ECL_COMMENTS!=null)
                                    csearchval.push(values[m].ECL_COMMENTS);
                            }
                        }
                        var response_len=values.length;
                        if(response_len>0){
                            $('#PDLY_SEARCH_tb_searchabycmt').removeAttr("disabled").attr('placeholder',response_len+' Records Matching').val('');
                        }
                        else{
                            $('#PDLY_SEARCH_tb_searchabycmt').attr("disabled", "disabled").attr('placeholder','No Matches').val('');
                        }
                        $('#PDLY_SEARCH_lbl_searchabycmt').show();
                        $('#PDLY_SEARCH_tb_searchabycmt').show();
                        $('#div_comments').show();
                        $('#PDLY_SEARCH_btn_babybutton').hide();
                        if(PDLY_SEARCH_flag_deleteupd==1){
                            PDLY_SEARCH_flag_deleteupd=0;
                            var PDLY_SEARCH_expensetype=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                            var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_SEARCH_expensetype);
                            show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
                        }
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            if((PDLY_SEARCH_lb_babysearchoptionvalue==55)||(PDLY_SEARCH_lb_babysearchoptionvalue==61)||(PDLY_SEARCH_lb_babysearchoptionvalue==72))
            {
                Ivsearchval=[];
                $('.preloader').show();
                var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
                $.ajax({
                    type: "POST",
                    url: controller_url+"PDLY_SEARCH_lb_invoicefrom",
                    data:'&PDLY_SEARCH_lb_typelistvalue='+PDLY_SEARCH_lb_typelistvalue+'&PDLY_SEARCH_lb_getstartvaluevalue='+PDLY_SEARCH_lb_getstartvaluevalue+'&PDLY_SEARCH_lb_getendvaluevalue='+PDLY_SEARCH_lb_getendvaluevalue+'&PDLY_SEARCH_lb_babysearchoptionvalue='+PDLY_SEARCH_lb_babysearchoptionvalue,
                    success: function(res) {
                        $('.preloader').hide();
                        var values=JSON.parse(res);
                        if(PDLY_SEARCH_lb_typelistvalue==36)
                        {
                            if(PDLY_SEARCH_lb_babysearchoptionvalue==55)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EB_INVOICE_FROM!='' && values[m].EB_INVOICE_FROM!=null)
                                        Ivsearchval.push(values[m].EB_INVOICE_FROM);
                                }
                            }
                        }
                        if(PDLY_SEARCH_lb_typelistvalue==35)
                        {
                            if(PDLY_SEARCH_lb_babysearchoptionvalue==61)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EC_INVOICE_FROM!='' && values[m].EC_INVOICE_FROM!=null)
                                        Ivsearchval.push(values[m].EC_INVOICE_FROM);
                                }
                            }
                        }
                        if(PDLY_SEARCH_lb_typelistvalue==37)
                        {
                            if(PDLY_SEARCH_lb_babysearchoptionvalue==72)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EP_INVOICE_FROM!='' && values[m].EP_INVOICE_FROM!=null)
                                        Ivsearchval.push(values[m].EP_INVOICE_FROM);
                                }
                            }
                        }

                        $('#PDLY_SEARCH_lbl_searchbyinvfrom').show();
                        $('#PDLY_SEARCH_tb_searchbyinvfrom').show();
                        $('#div_invoicefrom').show();
                        var response_len=values.length;
                        if(response_len>0){
                            $('#PDLY_SEARCH_tb_searchbyinvfrom').removeAttr("disabled").attr('placeholder',response_len+' Records Matching').val('');
                        }
                        else{
                            $('#PDLY_SEARCH_tb_searchbyinvfrom').attr("disabled", "disabled").attr('placeholder','No Matchs').val('');
                        }
                        $('#PDLY_SEARCH_btn_babybutton').hide();
                        if(PDLY_SEARCH_flag_deleteupd==1){
                            PDLY_SEARCH_flag_deleteupd=0;
                            var PDLY_SEARCH_expensetype=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                            var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_SEARCH_expensetype);
                            show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
                        }
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            if((PDLY_SEARCH_lb_babysearchoptionvalue==54)||(PDLY_SEARCH_lb_babysearchoptionvalue==60)||(PDLY_SEARCH_lb_babysearchoptionvalue==71))
            {
                itmIvsearchval=[];
                $('.preloader').show();
                var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
                $.ajax({
                    type: "POST",
                    url: controller_url+"PDLY_SEARCH_lb_invoiceitems",
                    data:'&PDLY_SEARCH_lb_typelistvalue='+PDLY_SEARCH_lb_typelistvalue+'&PDLY_SEARCH_lb_getstartvaluevalue='+PDLY_SEARCH_lb_getstartvaluevalue+'&PDLY_SEARCH_lb_getendvaluevalue='+PDLY_SEARCH_lb_getendvaluevalue+'&PDLY_SEARCH_lb_babysearchoptionvalue='+PDLY_SEARCH_lb_babysearchoptionvalue,
                    success: function(res) {
                        $('.preloader').hide();
                        var values=JSON.parse(res);
                        if(PDLY_SEARCH_lb_typelistvalue==36)
                        {
                            if(PDLY_SEARCH_lb_babysearchoptionvalue==54)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EB_INVOICE_ITEMS!='' && values[m].EB_INVOICE_ITEMS!=null)
                                        itmIvsearchval.push(values[m].EB_INVOICE_ITEMS);
                                }
                            }
                        }
                        if(PDLY_SEARCH_lb_typelistvalue==35)
                        {
                            if(PDLY_SEARCH_lb_babysearchoptionvalue==60)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EC_INVOICE_ITEMS!='' && values[m].EC_INVOICE_ITEMS!=null)
                                        itmIvsearchval.push(values[m].EC_INVOICE_ITEMS);
                                }
                            }
                        }
                        if(PDLY_SEARCH_lb_typelistvalue==37)
                        {
                            if(PDLY_SEARCH_lb_babysearchoptionvalue==71)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EP_INVOICE_ITEMS!='' && values[m].EP_INVOICE_ITEMS!=null)
                                        itmIvsearchval.push(values[m].EP_INVOICE_ITEMS);
                                }
                            }
                        }
                        $('#PDLY_SEARCH_tb_searchbyinvitem').val('').show();
                        $('#PDLY_SEARCH_lbl_searchbyinvitem').show();
                        $('#div_invoiceitem').show();
                        $('#PDLY_SEARCH_btn_babybutton').hide();
                        var response_len=values.length;
                        if(response_len>0){
                            $('#PDLY_SEARCH_tb_searchbyinvitem').removeAttr("disabled").attr('placeholder',response_len+' Records Matching').val('');
                        }
                        else{
                            $('#PDLY_SEARCH_tb_searchbyinvitem').attr("disabled", "disabled").attr('placeholder','No Matchs').val('');
                        }
                        if(PDLY_SEARCH_flag_deleteupd==1){
                            PDLY_SEARCH_flag_deleteupd=0;
                            var PDLY_SEARCH_expensetype=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                            var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].replace('[TYPE]', PDLY_SEARCH_expensetype);
                            show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
                        }
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        }
    }
//SUBMIT BUTTON  VALIDATION FOR SEARCHING FORM//
    $(".submitval").change(function(){
        $('textarea').height(116);
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_btn_pdf').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $("#PDLY_SEARCH_btn_searchbutton").hide();
        $("#PDLY_SEARCH_btn_deletebutton").hide();
        $('#PDLY_SEARCH_btn_sbutton').hide();
        $('#PDLY_SEARCH_btn_rbutton').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
        if((PDLY_SEARCH_lb_babysearchoptionvalue==56)||(PDLY_SEARCH_lb_babysearchoptionvalue==62)||(PDLY_SEARCH_lb_babysearchoptionvalue==73)||(PDLY_SEARCH_lb_babysearchoptionvalue==67))
        {
            if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_tb_searchabycmt").val()==""))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
//VALIDATION FOR SEARCH BUTTON (BABY EXPASE CATEGORY//
        if((PDLY_SEARCH_lb_babysearchoptionvalue==52)||(PDLY_SEARCH_lb_babysearchoptionvalue==58)||(PDLY_SEARCH_lb_babysearchoptionvalue==69))
        {
            if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_lb_babyexpansecategory").val()=="SELECT"))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH  , SEARCH BY BABY INVOICE DATE//
        if((PDLY_SEARCH_lb_babysearchoptionvalue==53)||(PDLY_SEARCH_lb_babysearchoptionvalue==59)||(PDLY_SEARCH_lb_babysearchoptionvalue==70)||(PDLY_SEARCH_lb_babysearchoptionvalue==63)||(PDLY_SEARCH_lb_babysearchoptionvalue==66)||(PDLY_SEARCH_lb_babysearchoptionvalue==64))
        {
            if(($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH , SEARCH BY BABY INVOICE FROM//
        if((PDLY_SEARCH_lb_babysearchoptionvalue==55)||(PDLY_SEARCH_lb_babysearchoptionvalue==61)||(PDLY_SEARCH_lb_babysearchoptionvalue==72))
        {
            if(($("#PDLY_SEARCH_tb_searchbyinvfrom").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH , SEARCH BY STAFF INVOICE ITEMS//
        if((PDLY_SEARCH_lb_babysearchoptionvalue==54)||(PDLY_SEARCH_lb_babysearchoptionvalue==60)||(PDLY_SEARCH_lb_babysearchoptionvalue==71))
        {
            if(($("#PDLY_SEARCH_tb_searchbyinvitem").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
        if((PDLY_SEARCH_lb_babysearchoptionvalue==51)||(PDLY_SEARCH_lb_babysearchoptionvalue==57)||(PDLY_SEARCH_lb_babysearchoptionvalue==68)||(PDLY_SEARCH_lb_babysearchoptionvalue==65))
        {
            if(($("#PDLY_SEARCH_tb_fromamount").val()!="")&&($("#PDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1].EMC_DATA).show();
                }
            }
            if(($("#PDLY_SEARCH_db_startdate").val()!="")&&($("#PDLY_SEARCH_db_enddate").val()!="")&&($("#PDLY_SEARCH_tb_fromamount").val()!="")&&($("#PDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1].EMC_DATA).show();
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
        }
    });
    $(".amtsubmitval").blur(function(){
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_btn_pdf').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $("#PDLY_SEARCH_btn_searchbutton").hide();
        $("#PDLY_SEARCH_btn_deletebutton").hide();
        $('#PDLY_SEARCH_btn_sbutton').hide();
        $('#PDLY_SEARCH_btn_rbutton').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
        if((PDLY_SEARCH_lb_babysearchoptionvalue==51)||(PDLY_SEARCH_lb_babysearchoptionvalue==57)||(PDLY_SEARCH_lb_babysearchoptionvalue==68)||(PDLY_SEARCH_lb_babysearchoptionvalue==65))
        {
            if(($("#PDLY_SEARCH_tb_fromamount").val()!="")&&($("#PDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1].EMC_DATA).show();
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
            }
            if(($("#PDLY_SEARCH_db_startdate").val()!="")&&($("#PDLY_SEARCH_db_enddate").val()!="")&&($("#PDLY_SEARCH_tb_fromamount").val()!="")&&($("#PDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1].EMC_DATA).show();
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
        }
    });

    //SEND VALUES TO DB FOR LOAD THE FLEX TABLES//
    $('#PDLY_SEARCH_btn_babybutton').click(function(){
        PDLY_SEARCH_loadflextable();
    });
    var  PDLY_SEARCH_babysearchdetailsvalues=[];
    function PDLY_SEARCH_loadflextable()
    {
        $(".preloader").show();
        var PDLY_SEARCH_lb_babysearchoptionmatch=$("#PDLY_SEARCH_lb_babysearchoption").val();
        if((PDLY_SEARCH_lb_babysearchoptionmatch==56)||(PDLY_SEARCH_lb_babysearchoptionmatch==62)||(PDLY_SEARCH_lb_babysearchoptionmatch==73)||(PDLY_SEARCH_lb_babysearchoptionmatch==67))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments=$('#PDLY_SEARCH_tb_searchabycmt').val();
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: controller_url+"PDLY_SEARCH_searchbybaby",
                data:{'PDLY_SEARCH_typelistvalue':PDLY_SEARCH_typelistvalue,'PDLY_SEARCH_startdate':PDLY_SEARCH_startdate,'PDLY_SEARCH_enddate':PDLY_SEARCH_enddate,'PDLY_SEARCH_babysearchoption':PDLY_SEARCH_babysearchoption,'PDLY_SEARCH_fromamount':PDLY_SEARCH_fromamount,'PDLY_SEARCH_toamount':PDLY_SEARCH_toamount,'PDLY_SEARCH_searchcomments':PDLY_SEARCH_searchcomments,'PDLY_SEARCH_invitemcom':PDLY_SEARCH_invitemcom,'PDLY_SEARCH_invfromcomt':PDLY_SEARCH_invfromcomt,'PDLY_SEARCH_babycategory':PDLY_SEARCH_babycategory},
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
        if((PDLY_SEARCH_lb_babysearchoptionmatch==52)||(PDLY_SEARCH_lb_babysearchoptionmatch==58)||(PDLY_SEARCH_lb_babysearchoptionmatch==69))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory=$('#PDLY_SEARCH_lb_babyexpansecategory').val();
            $.ajax({
                type: "POST",
                url: controller_url+"PDLY_SEARCH_searchbybaby",
                data:{'PDLY_SEARCH_typelistvalue':PDLY_SEARCH_typelistvalue,'PDLY_SEARCH_startdate':PDLY_SEARCH_startdate,'PDLY_SEARCH_enddate':PDLY_SEARCH_enddate,'PDLY_SEARCH_babysearchoption':PDLY_SEARCH_babysearchoption,'PDLY_SEARCH_fromamount':PDLY_SEARCH_fromamount,'PDLY_SEARCH_toamount':PDLY_SEARCH_toamount,'PDLY_SEARCH_searchcomments':PDLY_SEARCH_searchcomments,'PDLY_SEARCH_invitemcom':PDLY_SEARCH_invitemcom,'PDLY_SEARCH_invfromcomt':PDLY_SEARCH_invfromcomt,'PDLY_SEARCH_babycategory':PDLY_SEARCH_babycategory},
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
        if((PDLY_SEARCH_lb_babysearchoptionmatch==51)||(PDLY_SEARCH_lb_babysearchoptionmatch==57)||(PDLY_SEARCH_lb_babysearchoptionmatch==68)||(PDLY_SEARCH_lb_babysearchoptionmatch==65))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount=$('#PDLY_SEARCH_tb_fromamount').val();
            var PDLY_SEARCH_toamount=$('#PDLY_SEARCH_tb_toamount').val();
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: controller_url+"PDLY_SEARCH_searchbybaby",
                data:{'PDLY_SEARCH_typelistvalue':PDLY_SEARCH_typelistvalue,'PDLY_SEARCH_startdate':PDLY_SEARCH_startdate,'PDLY_SEARCH_enddate':PDLY_SEARCH_enddate,'PDLY_SEARCH_babysearchoption':PDLY_SEARCH_babysearchoption,'PDLY_SEARCH_fromamount':PDLY_SEARCH_fromamount,'PDLY_SEARCH_toamount':PDLY_SEARCH_toamount,'PDLY_SEARCH_searchcomments':PDLY_SEARCH_searchcomments,'PDLY_SEARCH_invitemcom':PDLY_SEARCH_invitemcom,'PDLY_SEARCH_invfromcomt':PDLY_SEARCH_invfromcomt,'PDLY_SEARCH_babycategory':PDLY_SEARCH_babycategory},
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
//SEARCH BY BABY EXPENSE INVOICE DATE//
        if((PDLY_SEARCH_lb_babysearchoptionmatch==53)||(PDLY_SEARCH_lb_babysearchoptionmatch==59)||(PDLY_SEARCH_lb_babysearchoptionmatch==70)||(PDLY_SEARCH_lb_babysearchoptionmatch==63)||(PDLY_SEARCH_lb_babysearchoptionmatch==66)||(PDLY_SEARCH_lb_babysearchoptionmatch==64))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: controller_url+"PDLY_SEARCH_searchbybaby",
                data:{'PDLY_SEARCH_typelistvalue':PDLY_SEARCH_typelistvalue,'PDLY_SEARCH_startdate':PDLY_SEARCH_startdate,'PDLY_SEARCH_enddate':PDLY_SEARCH_enddate,'PDLY_SEARCH_babysearchoption':PDLY_SEARCH_babysearchoption,'PDLY_SEARCH_fromamount':PDLY_SEARCH_fromamount,'PDLY_SEARCH_toamount':PDLY_SEARCH_toamount,'PDLY_SEARCH_searchcomments':PDLY_SEARCH_searchcomments,'PDLY_SEARCH_invitemcom':PDLY_SEARCH_invitemcom,'PDLY_SEARCH_invfromcomt':PDLY_SEARCH_invfromcomt,'PDLY_SEARCH_babycategory':PDLY_SEARCH_babycategory},
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
//SEARCH BY BABY EXPENSE INVOICE FROM//
        if((PDLY_SEARCH_lb_babysearchoptionmatch==55)||(PDLY_SEARCH_lb_babysearchoptionmatch==61)||(PDLY_SEARCH_lb_babysearchoptionmatch==72))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt=$('#PDLY_SEARCH_tb_searchbyinvfrom').val();
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: controller_url+"PDLY_SEARCH_searchbybaby",
                data:{'PDLY_SEARCH_typelistvalue':PDLY_SEARCH_typelistvalue,'PDLY_SEARCH_startdate':PDLY_SEARCH_startdate,'PDLY_SEARCH_enddate':PDLY_SEARCH_enddate,'PDLY_SEARCH_babysearchoption':PDLY_SEARCH_babysearchoption,'PDLY_SEARCH_fromamount':PDLY_SEARCH_fromamount,'PDLY_SEARCH_toamount':PDLY_SEARCH_toamount,'PDLY_SEARCH_searchcomments':PDLY_SEARCH_searchcomments,'PDLY_SEARCH_invitemcom':PDLY_SEARCH_invitemcom,'PDLY_SEARCH_invfromcomt':PDLY_SEARCH_invfromcomt,'PDLY_SEARCH_babycategory':PDLY_SEARCH_babycategory},
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
//SEARCH BY BABY EXPENSE INVOICE ITEM//
        if((PDLY_SEARCH_lb_babysearchoptionmatch==54)||(PDLY_SEARCH_lb_babysearchoptionmatch==60)||(PDLY_SEARCH_lb_babysearchoptionmatch==71))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom=$('#PDLY_SEARCH_tb_searchbyinvitem').val();
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: controller_url+"PDLY_SEARCH_searchbybaby",
                data:{'PDLY_SEARCH_typelistvalue':PDLY_SEARCH_typelistvalue,'PDLY_SEARCH_startdate':PDLY_SEARCH_startdate,'PDLY_SEARCH_enddate':PDLY_SEARCH_enddate,'PDLY_SEARCH_babysearchoption':PDLY_SEARCH_babysearchoption,'PDLY_SEARCH_fromamount':PDLY_SEARCH_fromamount,'PDLY_SEARCH_toamount':PDLY_SEARCH_toamount,'PDLY_SEARCH_searchcomments':PDLY_SEARCH_searchcomments,'PDLY_SEARCH_invitemcom':PDLY_SEARCH_invitemcom,'PDLY_SEARCH_invfromcomt':PDLY_SEARCH_invfromcomt,'PDLY_SEARCH_babycategory':PDLY_SEARCH_babycategory},
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
    }
    //FUNCTION TO CONVERT DATE FORMAT//
    function FormTableDateFormat(inputdate){
        var string = inputdate.split("-");
        return string[2]+'-'+ string[1]+'-'+string[0];
    }
    //LOAD THE FLEX TABLE  FOR THE  BABY SEARCH//
    function PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues){

        var PDLY_SEARCH_babytable_header='';
        $('#PDLY_SEARCH_tbl_htmltable').html('');
        $(".preloader").hide();
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
        $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
        var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
        var PDLY_SEARCH_searchoption=$("#PDLY_SEARCH_lb_babysearchoption").val();
        var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
        if(PDLY_SEARCH_babysearchdetailsvalues.length==0)
        {
            $('#PDLY_SEARCH_tbl_htmltable').hide();
            $('#PDLY_SEARCH_lbl_flextableheader').hide();
            $('#PDLY_SEARCH_btn_searchbutton').hide();
            $('#PDLY_SEARCH_btn_deletebutton').hide();
            $('#PDLY_SEARCH_div_htmltable').hide();
            $('#PDLY_btn_pdf').hide();
            if((PDLY_SEARCH_lb_typelistvalue==36)||(PDLY_SEARCH_lb_typelistvalue==35)||(PDLY_SEARCH_lb_typelistvalue==37))
            {
                if((PDLY_SEARCH_searchoption==52)||(PDLY_SEARCH_searchoption==58)||(PDLY_SEARCH_searchoption==69))
                {
                    var PDLY_SEARCH_category=$('#PDLY_SEARCH_lb_babyexpansecategory').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[5].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[TEXP]', PDLY_SEARCH_category);
                }
                if((PDLY_SEARCH_searchoption==51)||(PDLY_SEARCH_searchoption==57)||(PDLY_SEARCH_searchoption==68)||(PDLY_SEARCH_searchoption==65))
                {
                    var PDLY_SEARCH_famt=$('#PDLY_SEARCH_tb_fromamount').val();
                    var PDLY_SEARCH_tamt=$('#PDLY_SEARCH_tb_toamount').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[7].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[FAMT]', PDLY_SEARCH_famt);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[TAMT]', PDLY_SEARCH_tamt);
                }
                if((PDLY_SEARCH_searchoption==53)||(PDLY_SEARCH_searchoption==59)||(PDLY_SEARCH_searchoption==70)||(PDLY_SEARCH_searchoption==63)||(PDLY_SEARCH_searchoption==66)||(PDLY_SEARCH_searchoption==64))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[6].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if((PDLY_SEARCH_searchoption==55)||(PDLY_SEARCH_searchoption==61)||(PDLY_SEARCH_searchoption==72))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[0].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[START DATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[END DATE ]', PDLY_SEARCH_edate);
                }
                if((PDLY_SEARCH_searchoption==54)||(PDLY_SEARCH_searchoption==60)||(PDLY_SEARCH_searchoption==71))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[0].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[START DATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[END DATE ]', PDLY_SEARCH_edate);
                }
                if((PDLY_SEARCH_searchoption==56)||(PDLY_SEARCH_searchoption==62)||(PDLY_SEARCH_searchoption==73)||(PDLY_SEARCH_searchoption==67))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[0].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[START DATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[END DATE ]', PDLY_SEARCH_edate);
                }
            }
            if(PDLY_SEARCH_lb_typelistvalue==38)
            {
                if(PDLY_SEARCH_searchoption==65)
                {
                    var PDLY_SEARCH_famt=$('#PDLY_SEARCH_tb_fromamount').val();
                    var PDLY_SEARCH_tamt=$('#PDLY_SEARCH_tb_toamount').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[7].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[FAMT]', PDLY_SEARCH_famt);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[TAMT]', PDLY_SEARCH_tamt);
                }
                if(PDLY_SEARCH_searchoption==67)
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchabycmt').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[10].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[COMTS]', PDLY_SEARCH_fromcomt);
                }
                if(PDLY_SEARCH_searchoption==63)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[28].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if(PDLY_SEARCH_searchoption==66)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[28].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if(PDLY_SEARCH_searchoption==64)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[28].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
            }
            $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_CONFSAVEMSG);
            $('#PDLY_SEARCH_lbl_nodataerrormsg').show();
        }
        else
        {
            $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            var PDLY_SEARCH_babyvalue=PDLY_SEARCH_babysearchdetailsvalues;
            var expensetypetext=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
            var PDLY_SEARCH_babytable_value='';
            if((PDLY_SEARCH_lb_typelistvalue==36)||(PDLY_SEARCH_lb_typelistvalue==35)||(PDLY_SEARCH_lb_typelistvalue==37))
            {
                if((PDLY_SEARCH_searchoption==52)||(PDLY_SEARCH_searchoption==58)||(PDLY_SEARCH_searchoption==69))
                {
                    var PDLY_SEARCH_category=$('#PDLY_SEARCH_lb_babyexpansecategory').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[11].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[TEXP]', PDLY_SEARCH_category);
                }
                if((PDLY_SEARCH_searchoption==51)||(PDLY_SEARCH_searchoption==57)||(PDLY_SEARCH_searchoption==68)||(PDLY_SEARCH_searchoption==65))
                {
                    var PDLY_SEARCH_famt=$('#PDLY_SEARCH_tb_fromamount').val();
                    var PDLY_SEARCH_tamt=$('#PDLY_SEARCH_tb_toamount').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[13].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[FAMT]', PDLY_SEARCH_famt);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[TAMT]', PDLY_SEARCH_tamt);
                }
                if((PDLY_SEARCH_searchoption==53)||(PDLY_SEARCH_searchoption==59)||(PDLY_SEARCH_searchoption==70)||(PDLY_SEARCH_searchoption==63)||(PDLY_SEARCH_searchoption==66)||(PDLY_SEARCH_searchoption==64))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[12].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if((PDLY_SEARCH_searchoption==55)||(PDLY_SEARCH_searchoption==61)||(PDLY_SEARCH_searchoption==72))
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchbyinvfrom').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[15].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[INVFROM]', PDLY_SEARCH_fromcomt);
                }
                if((PDLY_SEARCH_searchoption==54)||(PDLY_SEARCH_searchoption==60)||(PDLY_SEARCH_searchoption==71))
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchbyinvitem').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[14].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[INVITEM]', PDLY_SEARCH_fromcomt);
                }
                if((PDLY_SEARCH_searchoption==56)||(PDLY_SEARCH_searchoption==62)||(PDLY_SEARCH_searchoption==73)||(PDLY_SEARCH_searchoption==67))
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchabycmt').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[16].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[COMTS]', PDLY_SEARCH_fromcomt);
                }
                $('#PDLY_SEARCH_lbl_flextableheader').text(PDLY_SEARCH_CONFSAVEMSG);
                $('#PDLY_SEARCH_hdn_flextableheader').val(PDLY_SEARCH_CONFSAVEMSG);
                $('#PDLY_SEARCH_hdn_expensetype').val(expensetypetext);
                $('#PDLY_SEARCH_lbl_flextableheader').show();
                if(PDLY_SEARCH_lb_typelistvalue==36)
                {
                    var PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1" width="1300px" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white;text-align: center;" ><tr><th>DELETE</th><th>TYPE OF BABY EXPENSE</th><th style="width:75px" class="uk-date-column"">INVOICE DATE</th><th style="width:60px">INVOICE AMOUNT</th><th style="width:200px">INVOICE FROM</th><th style="width:200px" >INVOICE ITEMS</th><th style="width:250px">COMMENTS</th><th>USERSTAMP</th><th class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    for(var i=0;i<PDLY_SEARCH_babyvalue.length;i++)
                    {
                        var rowid=(i+1);
                        var PDLY_SEARCH_values=PDLY_SEARCH_babyvalue[i];
                        var PDLY_SEARCH_date=FormTableDateFormat(PDLY_SEARCH_values.EB_INVOICE_DATE);
                        if(PDLY_SEARCH_values.EB_COMMENTS==null){PDLY_SEARCH_values.EB_COMMENTS='';}
                        PDLY_SEARCH_babytable_header+='<tr><td style="width:30px;"><span id ='+PDLY_SEARCH_values.EB_ID+' class="glyphicon glyphicon-trash PDLY_SEARCH_btn_deletebutton"></span></td><td id=ebcategory_'+PDLY_SEARCH_values.EB_ID+' class="babyedit">'+PDLY_SEARCH_values.ECN_DATA+'</td><td nowrap id=ebinvdate_'+PDLY_SEARCH_values.EB_ID+' class="babyedit">'+PDLY_SEARCH_date+'</td><td id=ebamount_'+PDLY_SEARCH_values.EB_ID+' class="babyedit">'+PDLY_SEARCH_values.EB_AMOUNT+'</td><td id=ebinvfrom_'+PDLY_SEARCH_values.EB_ID+' class="babyedit">'+PDLY_SEARCH_values.EB_INVOICE_FROM+'</td><td id=ebinvitem_'+PDLY_SEARCH_values.EB_ID+' class="babyedit">'+PDLY_SEARCH_values.EB_INVOICE_ITEMS+'</td><td id=ebcomments_'+PDLY_SEARCH_values.EB_ID+' class="babyedit">'+PDLY_SEARCH_values.EB_COMMENTS+'</td><td>'+PDLY_SEARCH_values.ULD_LOGINID+'</td><td nowrap>'+PDLY_SEARCH_values.TIMESTMP+'</td></tr>';
                    }
                    PDLY_SEARCH_babytable_header+='</tbody></table>';
                }
                if(PDLY_SEARCH_lb_typelistvalue==35)
                {
                    var PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1" width="1300px"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th>DELETE</th><th>TYPE OF CAR EXPENSE</th><th style="width:75px" class="uk-date-column"">INVOICE DATE</th><th style="width:60px">INVOICE AMOUNT</th><th style="width:200px">INVOICE FROM</th><th style="width:200px">INVOICE ITEMS</th><th style="width:230px">COMMENTS</th><th>USERSTAMP</th><th class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    for(var i=0;i<PDLY_SEARCH_babyvalue.length;i++)
                    {
                        var rowid=(i+1);
                        var PDLY_SEARCH_values=PDLY_SEARCH_babyvalue[i];
                        var PDLY_SEARCH_date=FormTableDateFormat(PDLY_SEARCH_values.EC_INVOICE_DATE);
                        if(PDLY_SEARCH_values.EC_COMMENTS==null){PDLY_SEARCH_values.EC_COMMENTS='';}
                        PDLY_SEARCH_babytable_header+='<tr><td style="width:30px;"><span id ='+PDLY_SEARCH_values.EC_ID+' class="glyphicon glyphicon-trash PDLY_SEARCH_btn_deletebutton"></span></td><td id=eccategory_'+PDLY_SEARCH_values.EC_ID+' class="caredit">'+PDLY_SEARCH_values.ECN_DATA+'</td><td nowrap id=ecinvdate_'+PDLY_SEARCH_values.EC_ID+' class="caredit">'+PDLY_SEARCH_date+'</td><td id=ecamount_'+PDLY_SEARCH_values.EC_ID+' class="caredit">'+PDLY_SEARCH_values.EC_AMOUNT+'</td><td id=ecinvfrom_'+PDLY_SEARCH_values.EC_ID+' class="caredit">'+PDLY_SEARCH_values.EC_INVOICE_FROM+'</td><td id=ecinvitem_'+PDLY_SEARCH_values.EC_ID+' class="caredit">'+PDLY_SEARCH_values.EC_INVOICE_ITEMS+'</td><td id=eccomments_'+PDLY_SEARCH_values.EC_ID+' class="caredit">'+PDLY_SEARCH_values.EC_COMMENTS+'</td><td>'+PDLY_SEARCH_values.ULD_LOGINID+'</td><td nowrap>'+PDLY_SEARCH_values.TIMESTMP+'</td></tr>';
                    }
                    PDLY_SEARCH_babytable_header+='</tbody></table>';
                }
                if(PDLY_SEARCH_lb_typelistvalue==37)
                {
                    var PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" width="1300px" border="1"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th>DELETE</th><th>TYPE OF PERSONAL EXPENSE</th><th style="width:75px" class="uk-date-column"">INVOICE DATE</th><th style="width:60px">INVOICE AMOUNT</th><th style="width:200px">INVOICE FROM</th><th style="width:200px">INVOICE ITEMS</th><th style="width:230px">COMMENTS</th><th>USERSTAMP</th><th class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    for(var i=0;i<PDLY_SEARCH_babyvalue.length;i++)
                    {
                        var rowid=(i+1);
                        var PDLY_SEARCH_values=PDLY_SEARCH_babyvalue[i];
                        var PDLY_SEARCH_date=FormTableDateFormat(PDLY_SEARCH_values.EP_INVOICE_DATE);
                        if(PDLY_SEARCH_values.EP_COMMENTS==null){PDLY_SEARCH_values.EP_COMMENTS='';}
                        PDLY_SEARCH_babytable_header+='<tr><td style="width:30px;"><span class="glyphicon glyphicon-trash PDLY_SEARCH_btn_deletebutton" id ='+PDLY_SEARCH_values.EP_ID+'></span></td><td id=epcategory_'+PDLY_SEARCH_values.EP_ID+' class="personaledit">'+PDLY_SEARCH_values.ECN_DATA+'</td><td nowrap id=epinvdate_'+PDLY_SEARCH_values.EP_ID+' class="personaledit">'+PDLY_SEARCH_date+'</td><td id=epamount_'+PDLY_SEARCH_values.EP_ID+' class="personaledit">'+PDLY_SEARCH_values.EP_AMOUNT+'</td><td id=epinvfrom_'+PDLY_SEARCH_values.EP_ID+' class="personaledit">'+PDLY_SEARCH_values.EP_INVOICE_FROM+'</td><td id=epinvitem_'+PDLY_SEARCH_values.EP_ID+' class="personaledit">'+PDLY_SEARCH_values.EP_INVOICE_ITEMS+'</td><td id=epcomments_'+PDLY_SEARCH_values.EP_ID+' class="personaledit">'+PDLY_SEARCH_values.EP_COMMENTS+'</td><td>'+PDLY_SEARCH_values.ULD_LOGINID+'</td><td nowrap>'+PDLY_SEARCH_values.TIMESTMP+'</td></tr>';
                    }
                    PDLY_SEARCH_babytable_header+='</tbody></table>';
                }
            }
            if(PDLY_SEARCH_lb_typelistvalue==38)
            {
                if(PDLY_SEARCH_searchoption==65)
                {
                    var PDLY_SEARCH_famt=$('#PDLY_SEARCH_tb_fromamount').val();
                    var PDLY_SEARCH_tamt=$('#PDLY_SEARCH_tb_toamount').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[18].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[FAMT]', PDLY_SEARCH_famt);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[TAMT]', PDLY_SEARCH_tamt);
                }
                if(PDLY_SEARCH_searchoption==67)
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchabycmt').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[16].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[COMTS]', PDLY_SEARCH_fromcomt);
                }
                if(PDLY_SEARCH_searchoption==63)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[20].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if(PDLY_SEARCH_searchoption==66)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[27].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if(PDLY_SEARCH_searchoption==64)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[22].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                $('#PDLY_SEARCH_lbl_flextableheader').text(PDLY_SEARCH_CONFSAVEMSG);
                $('#PDLY_SEARCH_hdn_flextableheader').val(PDLY_SEARCH_CONFSAVEMSG);
                $('#PDLY_SEARCH_hdn_expensetype').val(expensetypetext);
                $('#PDLY_SEARCH_lbl_flextableheader').show();
                PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1" width="1100px" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th>DELETE</th><th width="75px" class="uk-date-column"">PAID DATE</th><th width="60px">INVOICE AMOUNT</th><th width="75px" class="uk-date-column"">FROM PERIOD</th><th width="75px" class="uk-date-column"">TO PERIOD</th><th width="180px">COMMENTS</th><th width="250px">USERSTAMP</th><th width="150px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';

                for(var i=0;i<PDLY_SEARCH_babyvalue.length;i++)
                {
                    var rowid=(i+1);
                    var PDLY_SEARCH_values=PDLY_SEARCH_babyvalue[i];
                    var PDLY_SEARCH_paiddate=FormTableDateFormat(PDLY_SEARCH_values.ECL_PAID_DATE);
                    var PDLY_SEARCH_fromdate=FormTableDateFormat(PDLY_SEARCH_values.ECL_FROM_PERIOD);
                    var PDLY_SEARCH_todate=FormTableDateFormat(PDLY_SEARCH_values.ECL_TO_PERIOD);
                    if(PDLY_SEARCH_values.ECL_COMMENTS==null){PDLY_SEARCH_values.ECL_COMMENTS='';}
                    PDLY_SEARCH_babytable_header+='<tr><td style="width:30px;"><span id='+PDLY_SEARCH_values.ECL_ID+' class="glyphicon glyphicon-trash PDLY_SEARCH_btn_deletebutton"></span></td><td nowrap id=eclpaiddate_'+PDLY_SEARCH_values.ECL_ID+' class="carloanedit">'+PDLY_SEARCH_paiddate+'</td><td id=eclamount_'+PDLY_SEARCH_values.ECL_ID+' class="carloanedit">'+PDLY_SEARCH_values.ECL_AMOUNT+'</td><td nowrap id=eclfromperiod_'+PDLY_SEARCH_values.ECL_ID+' class="carloanedit">'+PDLY_SEARCH_fromdate+'</td><td nowrap id=ecltopaid_'+PDLY_SEARCH_values.ECL_ID+' class="carloanedit">'+PDLY_SEARCH_todate+'</td><td id=eclcomments_'+PDLY_SEARCH_values.ECL_ID+' class="carloanedit">'+PDLY_SEARCH_values.ECL_COMMENTS+'</td><td>'+PDLY_SEARCH_values.ULD_LOGINID+'</td><td nowrap>'+PDLY_SEARCH_values.TIMESTMP+'</td></tr>';
                }
                PDLY_SEARCH_babytable_header+='</tbody></table>';
                $('section').html(PDLY_SEARCH_babytable_header);
                $('#PDLY_SEARCH_div_htmltable').show();
                $('#PDLY_btn_pdf').show();
            }
            $('section').html(PDLY_SEARCH_babytable_header);
            $('#PDLY_SEARCH_tbl_htmltable').show();
            $('#PDLY_SEARCH_div_htmltable').show();
            $('#PDLY_btn_pdf').show();
            $('#PDLY_SEARCH_lbl_flextableheader').show();
            $('#PDLY_SEARCH_btn_searchbutton').hide();
            $('#PDLY_SEARCH_btn_deletebutton').hide();
            $('#PDLY_SEARCH_btn_searchbutton').attr("disabled", "disabled");
            $('#PDLY_SEARCH_btn_deletebutton').attr("disabled", "disabled");
            var table=$('#PDLY_SEARCH_tbl_htmltable').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
                "sPaginationType":"full_numbers",
                "aoColumnDefs" : [
                    { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ],
                "sDom":"Rlfrtip"
//                "scrollX": true,
//                "sScrollY":  ( 0.6 * $(window).height() ),
//                "bScrollCollapse": true,
//                "bAutoWidth": true

            });
            if ( $.browser.webkit ) {
                setTimeout(function () {
                    table.fnAdjustColumnSizing();
                }, 10);
            }
            sorting()
        }
        var PDLY_SEARCH_expensetype=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
        if(PDLY_SEARCH_flag_deleteupd==1){
            var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_SEARCH_expensetype);
            show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
            PDLY_SEARCH_flag_deleteupd=0;
        }
        if(PDLY_SEARCH_flag_deleteupd==2){
            var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[4].EMC_DATA.replace('[TYPE]', PDLY_SEARCH_expensetype);
            show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
            PDLY_SEARCH_flag_deleteupd=0;
        }

    }
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
    //EXPENSE BAY INLINE EDIT FUNCTION
    var combineid;
    var previous_id;
    var cval;
    var ifcondition;
    $(document).on('click','.babyedit', function (){
        if(previous_id!=undefined){
            $('#'+previous_id).replaceWith("<td align='left' class='babyedit' id='"+previous_id+"' >"+cval+"</td>");
        }
        var cid = $(this).attr('id');
        var id=cid.split('_');
        ifcondition=id[0];
        combineid=id[1];
        previous_id=cid;
        cval = $(this).text();
        if(ifcondition=='ebcategory')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+previous_id+"'><select class='form-control babyupdate' id='Eb_category' style='width: 250px;'></select></td>");
            var babycategory='<option value="SELECT">SELECT</option>';
            for (var i = 0; i < baby_category.length; i++) {
                if(baby_category[i].ECN_DATA==cval)
                {
                    var categorysindex=i;
                }
                babycategory += '<option value="' + baby_category[i].ECN_DATA + '">' + baby_category[i].ECN_DATA + '</option>';
            }
            $('#Eb_category').html(babycategory)
            $('#Eb_category').prop('selectedIndex',categorysindex+1);
        }
        if(ifcondition=='ebinvdate')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+previous_id+"'><input type='text' id='Eb_invdate' name='Eb_invdate'  class='babyupdate form-control date-picker' style='width: 110px' value='"+cval+"'></td>");
            $(".date-picker").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true
            });
            $('.date-picker').datepicker("option","maxDate",new Date());
        }
        if(ifcondition=='ebamount')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+previous_id+"'><input type='text' id='Eb_invamt' name='Eb_invamt'  class='babyupdate form-control amtonlyinc' style='width: 80px' value='"+cval+"'></td>");
            $(".amtonlyinc").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        }
        if(ifcondition=='ebinvfrom')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+previous_id+"'><input type='text' id='Eb_invfrom' name='Eb_invfrom'  class='babyupdate form-control autosize autocompinc' style='width: 150px' value='"+cval+"'></td>");
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
        }
        if(ifcondition=='ebinvitem')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+previous_id+"'><textarea id='Eb_invitem' name='Eb_invitem'  class='babyupdate form-control' style='width: 200px'>"+cval+"</textarea></td>");
        }
        if(ifcondition=='ebcomments')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+previous_id+"'><textarea id='Eb_invcomments' name='Eb_invcomments'  class='babyupdate form-control' style='width: 200px' >"+cval+"</textarea></td>");
        }
    });
    // EXPENSE BABY UPDATE FUNCTION
    $(document).on('change','.babyupdate', function (){
        if($('#ebcategory_'+combineid).hasClass("babyedit")==true){

            var babycategory=$('#ebcategory_'+combineid).text();
        }
        else{
            var babycategory=$('#Eb_category').find('option:selected').text();
        }
        if($('#ebinvdate_'+combineid).hasClass("babyedit")==true){

            var babyinvdate=$('#ebinvdate_'+combineid).text();
        }
        else{
            var babyinvdate=$('#Eb_invdate').val();
        }
        if($('#ebamount_'+combineid).hasClass("babyedit")==true){

            var babyinamt=$('#ebamount_'+combineid).text();
        }
        else{
            var babyinamt=$('#Eb_invamt').val();
        }
        if($('#ebinvfrom_'+combineid).hasClass("babyedit")==true){

            var babyinfromt=$('#ebinvfrom_'+combineid).text();
        }
        else{
            var babyinfromt=$('#Eb_invfrom').val();
        }
        if($('#ebinvitem_'+combineid).hasClass("babyedit")==true){

            var babyinvitem=$('#ebinvitem_'+combineid).text();
        }
        else{
            var babyinvitem=$('#Eb_invitem').val();
        }
        if($('#ebcomments_'+combineid).hasClass("babyedit")==true){

            var babycomment=$('#ebcomments_'+combineid).text();
        }
        else{
            var babycomment=$('#Eb_invcomments').val();
        }
        if($('#Eb_category').val()!='SELECT') {
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url + "expensebabyupdate",
                data: {
                    'rowid': combineid,
                    'babycategory': babycategory,
                    'babyinvdate': babyinvdate,
                    'babyinamt': babyinamt,
                    'babyinfromt': babyinfromt,
                    'babyinvitem': babyinvitem,
                    'babycomment': babycomment
                },
                success: function (data) {
                    $('.preloader').hide();
                    var resultflag = data;
                    if (resultflag == 1) {
                        var PDLY_INPUT_expensetypetext = $('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                        var PDLY_INPUT_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetypetext);
                        show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE", PDLY_INPUT_CONFSAVEMSG, "success", false);
                        var PDLY_SEARCH_lb_babysearchoptionvalue = $('#PDLY_SEARCH_lb_babysearchoption').val();
                        if ((PDLY_SEARCH_lb_babysearchoptionvalue == 56) || (PDLY_SEARCH_lb_babysearchoptionvalue == 55) || (PDLY_SEARCH_lb_babysearchoptionvalue == 54)) {
                            $('#PDLY_SEARCH_tbl_htmltable').hide();
                            $('#PDLY_SEARCH_div_htmltable').hide();
                            $('#PDLY_SEARCH_lbl_flextableheader').hide();
                            $('#PDLY_btn_pdf').hide();
                            PDLY_SEARCH_searchvalue()

                        }
                        else {
                            PDLY_SEARCH_loadflextable()
                            previous_id = undefined;

                        }
                    }
                    else {
                        show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE", PDLY_SEARCH_hdrmsgArray[36].EMC_DATA, "success", false);
                    }
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
    }) ;
    //EXPENSE CAR INLINE EDIT FUNCTION
    var carcombineid;
    var carprevious_id;
    var carcval;
    var carifcondition;
    $(document).on('click','.caredit', function (){
        if(carprevious_id!=undefined){
            $('#'+carprevious_id).replaceWith("<td align='left' class='caredit' id='"+carprevious_id+"' >"+carcval+"</td>");
        }
        var cid = $(this).attr('id');
        var id=cid.split('_');
        carifcondition=id[0];
        carcombineid=id[1];
        carprevious_id=cid;
        carcval = $(this).text();
        if(carifcondition=='eccategory')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+carprevious_id+"'><select class='form-control carupdate' id='Ec_category' style='width: 150px;'></select></td>");
            var carcategory='<option value="SELECT">SELECT</option>';
            for (var i=0;i<car_category.length;i++) {
                if(car_category[i].ECN_DATA==carcval)
                {
                    var categorysindex=i;
                }
                carcategory += '<option value="' + car_category[i].ECN_DATA + '">' + car_category[i].ECN_DATA + '</option>';
            }
            $('#Ec_category').html(carcategory)
            $('#Ec_category').prop('selectedIndex',categorysindex+1);
        }
        if(carifcondition=='ecinvdate')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+carprevious_id+"'><input type='text' id='Ec_invdate' name='Ec_invdate'  class='carupdate form-control date-picker' style='width: 110px' value='"+carcval+"'></td>");
            $(".date-picker").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true
            });
            $('.date-picker').datepicker("option","maxDate",new Date());
        }
        if(carifcondition=='ecamount')
        {
            $('#'+cid).replaceWith("<td class='new' id='"+carprevious_id+"'><input type='text' id='Ec_invamt' name='Ec_invamt'  class='carupdate form-control amtonlyinc' style='width: 80px' value='"+carcval+"'></td>");
            $(".amtonlyinc").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        }
        if(carifcondition=='ecinvfrom')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+carprevious_id+"'><input type='text' id='Ec_invfrom' name='Ec_invfrom'  class='carupdate form-control autosize autocompinc' style='width: 150px' value='"+carcval+"'></td>");
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});

        }
        if(carifcondition=='ecinvitem')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+carprevious_id+"'><textarea id='Ec_invitem' name='Ec_invitem'  class='carupdate form-control' style='width: 200px'>"+carcval+"</textarea></td>");
        }
        if(carifcondition=='eccomments')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+carprevious_id+"'><textarea id='Ec_invcomments' name='Ec_invcomments'  class='carupdate form-control' style='width: 200px' >"+carcval+"</textarea></td>");
        }
    });
    // EXPENSE CAR UPDATE FUNCTION
    $(document).on('change','.carupdate', function (){
        if($('#eccategory_'+carcombineid).hasClass("caredit")==true){

            var carcategory=$('#eccategory_'+carcombineid).text();
        }
        else{
            var carcategory=$('#Ec_category').find('option:selected').text();
        }
        if($('#ecinvdate_'+carcombineid).hasClass("caredit")==true){

            var carinvdate=$('#ecinvdate_'+carcombineid).text();
        }
        else{
            var carinvdate=$('#Ec_invdate').val();
        }
        if($('#ecamount_'+carcombineid).hasClass("caredit")==true){

            var carinamt=$('#ecamount_'+carcombineid).text();
        }
        else{
            var carinamt=$('#Ec_invamt').val();
        }
        if($('#ecinvfrom_'+carcombineid).hasClass("caredit")==true){

            var carinfromt=$('#ecinvfrom_'+carcombineid).text();
        }
        else{
            var carinfromt=$('#Ec_invfrom').val();
        }
        if($('#ecinvitem_'+carcombineid).hasClass("caredit")==true){

            var carinvitem=$('#ecinvitem_'+carcombineid).text();
        }
        else{
            var carinvitem=$('#Ec_invitem').val();
        }
        if($('#eccomments_'+carcombineid).hasClass("caredit")==true){

            var carcomment=$('#eccomments_'+carcombineid).text();
        }
        else{
            var carcomment=$('#Ec_invcomments').val();
        }
        if($('#Ec_category').val()!='SELECT') {
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url + "expensecarupdate",
                data: {
                    'rowid': carcombineid,
                    'carcategory': carcategory,
                    'carinvdate': carinvdate,
                    'carinamt': carinamt,
                    'carinfromt': carinfromt,
                    'carinvitem': carinvitem,
                    'carcomment': carcomment
                },
                success: function (data) {
                    $('.preloader').hide();
                    var resultflag = data;
                    if (resultflag == 1) {
                        var PDLY_INPUT_expensetypetext = $('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                        var PDLY_INPUT_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetypetext);
                        show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE", PDLY_INPUT_CONFSAVEMSG, "success", false);
                        var PDLY_SEARCH_lb_babysearchoptionvalue = $('#PDLY_SEARCH_lb_babysearchoption').val();
                        if ((PDLY_SEARCH_lb_babysearchoptionvalue == 60) || (PDLY_SEARCH_lb_babysearchoptionvalue == 61) || (PDLY_SEARCH_lb_babysearchoptionvalue == 62)) {
                            $('#PDLY_SEARCH_tbl_htmltable').hide();
                            $('#PDLY_SEARCH_div_htmltable').hide();
                            $('#PDLY_SEARCH_lbl_flextableheader').hide();
                            $('#PDLY_btn_pdf').hide();
                            PDLY_SEARCH_searchvalue()
                        }
                        else {
                            PDLY_SEARCH_loadflextable()
                            carprevious_id = undefined;
                        }
                    }
                    else {
                        show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE", PDLY_SEARCH_hdrmsgArray[36].EMC_DATA, "success", false);
                    }
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
    }) ;
    //EXPENSE BAY INLINE EDIT FUNCTION
    var personalcombineid;
    var personalprevious_id;
    var personalcval;
    var personalifcondition;
    $(document).on('click','.personaledit', function (){
        if(personalprevious_id!=undefined){
            $('#'+personalprevious_id).replaceWith("<td align='left' class='personaledit' id='"+personalprevious_id+"' >"+personalcval+"</td>");
        }
        var cid = $(this).attr('id');
        var id=cid.split('_');
        personalifcondition=id[0];
        personalcombineid=id[1];
        personalprevious_id=cid;
        personalcval = $(this).text();
        if(personalifcondition=='epcategory')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+personalprevious_id+"'><select class='form-control personalupdate' id='Ep_category' style='width: 250px;'></select></td>");
            var personalcategory='<option value="SELECT">SELECT</option>';
            for (var i=0;i<personal_categroy.length;i++) {
                if(personal_categroy[i].ECN_DATA==personalcval)
                {
                    var categorysindex=i;
                }
                personalcategory += '<option value="' + personal_categroy[i].ECN_DATA + '">' + personal_categroy[i].ECN_DATA + '</option>';
            }
            $('#Ep_category').html(personalcategory)
            $('#Ep_category').prop('selectedIndex',categorysindex+1);
        }
        if(personalifcondition=='epinvdate')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+personalprevious_id+"'><input type='text' id='Ep_invdate' name='Ep_invdate'  class='personalupdate form-control date-picker' style='width: 110px' value='"+personalcval+"'></td>");
            $(".date-picker").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true
            });
            $('.date-picker').datepicker("option","maxDate",new Date());
        }
        if(personalifcondition=='epamount')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+personalprevious_id+"'><input type='text' id='Ep_invamt' name='Ep_invamt'  class='personalupdate form-control amtonlyinc' style='width: 80px' value='"+personalcval+"'></td>");
            $(".amtonlyinc").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        }
        if(personalifcondition=='epinvfrom')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+personalprevious_id+"'><input type='text' id='Ep_invfrom' name='Ep_invfrom'  class='personalupdate form-control autosize autocompinc' style='width: 200px' value='"+personalcval+"'></td>");
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
        }
        if(personalifcondition=='epinvitem')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+personalprevious_id+"'><textarea id='Ep_invitem' name='Ep_invitem'  class='personalupdate form-control' style='width: 200px'>"+personalcval+"</textarea></td>");
        }
        if(personalifcondition=='epcomments')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+personalprevious_id+"'><textarea id='Ep_invcomments' name='Ep_invcomments'  class='personalupdate form-control' style='width: 200px' >"+personalcval+"</textarea></td>");
        }

        //CALL FUNCTION TO HIGHLIGHT SEARCH TEXT//
        $(document).on('keypress','.autocompinc',function() {
            var PDLY_INPUT_getthisid=$(this).attr('id');
            PDLY_INPUT_inc_id=PDLY_INPUT_getthisid.replace( /^\D+/g, '');
            PDLY_SEARCH_invfromhighlightSearchText();
            $("#Ep_invfrom").autocomplete({
                source: personalinvoicefrom,
                select: PDLY_SEARCH_invfromAutoCompleteSelectHandler
            });
        });

        function PDLY_SEARCH_invfromhighlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            };}
        function PDLY_SEARCH_invfromAutoCompleteSelectHandler(event, ui) {
        }
    });
    // EXPENSE PERSONAL UPDATE FUNCTION
    $(document).on('change','.personalupdate', function (){
        if($('#epcategory_'+personalcombineid).hasClass("personaledit")==true){

            var personalcategory=$('#epcategory_'+personalcombineid).text();
        }
        else{
            var personalcategory=$('#Ep_category').find('option:selected').text();
        }
        if($('#epinvdate_'+personalcombineid).hasClass("personaledit")==true){

            var personalinvdate=$('#epinvdate_'+personalcombineid).text();
        }
        else{
            var personalinvdate=$('#Ep_invdate').val();
        }
        if($('#epamount_'+personalcombineid).hasClass("personaledit")==true){

            var personalinamt=$('#epamount_'+personalcombineid).text();
        }
        else{
            var personalinamt=$('#Ep_invamt').val();
        }
        if($('#epinvfrom_'+personalcombineid).hasClass("personaledit")==true){

            var personalinfromt=$('#epinvfrom_'+personalcombineid).text();
        }
        else{
            var personalinfromt=$('#Ep_invfrom').val();
        }
        if($('#epinvitem_'+personalcombineid).hasClass("personaledit")==true){

            var personalinvitem=$('#epinvitem_'+personalcombineid).text();
        }
        else{
            var personalinvitem=$('#Ep_invitem').val();
        }
        if($('#epcomments_'+personalcombineid).hasClass("personaledit")==true){

            var personalcomment=$('#epcomments_'+personalcombineid).text();
        }
        else{
            var personalcomment=$('#Ep_invcomments').val();
        }
        if($('#Ep_category').val()!='SELECT') {
            $('.preloader').show();
            $.ajax({
                type: "POST",
                url: controller_url + "expensepersonalupdate",
                data: {
                    'rowid': personalcombineid,
                    'personalcategory': personalcategory,
                    'personalinvdate': personalinvdate,
                    'personalinamt': personalinamt,
                    'personalinfromt': personalinfromt,
                    'personalinvitem': personalinvitem,
                    'personalcomment': personalcomment
                },
                success: function (data) {
                    $('.preloader').hide();
                    var resultflag = data;
                    if (resultflag == 1) {
                        var PDLY_INPUT_expensetypetext = $('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                        var PDLY_INPUT_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetypetext);
                        show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE", PDLY_INPUT_CONFSAVEMSG, "success", false);
                        var PDLY_SEARCH_lb_babysearchoptionvalue = $('#PDLY_SEARCH_lb_babysearchoption').val();
                        if ((PDLY_SEARCH_lb_babysearchoptionvalue == 71) || (PDLY_SEARCH_lb_babysearchoptionvalue == 72) || (PDLY_SEARCH_lb_babysearchoptionvalue == 73)) {
                            $('#PDLY_SEARCH_tbl_htmltable').hide();
                            $('#PDLY_SEARCH_div_htmltable').hide();
                            $('#PDLY_SEARCH_lbl_flextableheader').hide();
                            $('#PDLY_btn_pdf').hide();
                            PDLY_SEARCH_searchvalue()
                        }
                        else {
                            PDLY_SEARCH_loadflextable()
                            personalprevious_id = undefined;
                        }
                    }
                    else {
                        show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE", PDLY_SEARCH_hdrmsgArray[36].EMC_DATA, "success", false);

                    }
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
    }) ;
    //EXPENSE CARLOAN INLINE EDIT FUNCTION
    var carloancombineid;
    var carloanprevious_id;
    var carloancval;
    var carloanifcondition;
    $(document).on('click','.carloanedit', function (){
        if(carloanprevious_id!=undefined){
            $('#'+carloanprevious_id).replaceWith("<td align='left' class='carloanedit' id='"+carloanprevious_id+"' >"+carloancval+"</td>");
        }
        var cid = $(this).attr('id');
        var id=cid.split('_');
        carloanifcondition=id[0];
        carloancombineid=id[1];
        var $row = $(this).parents('tr');
        var paiddate=$('#eclpaiddate_'+carloancombineid).text();
        var fromperiod=$('#eclfromperiod_'+carloancombineid).text();
        carloanprevious_id=cid;
        carloancval = $(this).text();
        if(carloanifcondition=='eclpaiddate')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+carloanprevious_id+"'><input type='text' id='Ecl_paiddate' name='Ecl_paiddate'  class='carloanupdate form-control date-picker' style='width: 110px' value='"+carloancval+"'></td>");
            $("#Ecl_paiddate").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true
            });
            $('#Ecl_paiddate').datepicker("option","maxDate",new Date());
        }
        if(carloanifcondition=='eclfromperiod')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+carloanprevious_id+"'><input type='text' id='Ecl_fromperiod' name='Ecl_fromperiod'  class='carloanupdate form-control date-picker' style='width: 110px' value='"+carloancval+"'></td>");
            $("#Ecl_fromperiod").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true
            });
            $('#Ecl_fromperiod').datepicker("option","maxDate",paiddate);
        }
        if(carloanifcondition=='ecltopaid')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+carloanprevious_id+"'><input type='text' id='Ecl_toperiod' name='Ecl_toperiod'  class='carloanupdate form-control date-picker'  style='width: 110px' value='"+carloancval+"'></td>");
            $("#Ecl_toperiod").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true
            });
            $('#Ecl_toperiod').datepicker("option","minDate",fromperiod);
            $('#Ecl_toperiod').datepicker("option","maxDate",paiddate);
        }
        if(carloanifcondition=='eclamount')
        {
            $('#'+cid).replaceWith("<td  class='new' id='"+carloanprevious_id+"'><input type='text' id='Ecl_invamt' name='Ecl_invamt'  class='carloanupdate form-control amtonlyinc' style='width: 80px' value='"+carloancval+"'></td>");
            $(".amtonlyinc").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        }
        if(carloanifcondition=='eclcomments')
        {
            $('#'+cid).replaceWith("<td class='new' id='"+carloanprevious_id+"'><textarea id='Ecl_invcomments' name='Ecl_invcomments'  class='carloanupdate form-control' style='width: 300px' >"+carloancval+"</textarea></td>");
        }

    });
    // EXPENSE CARLOAN UPDATE FUNCTION
    $(document).on('change','.carloanupdate', function (){
        $('.preloader').show();
        if($('#eclpaiddate_'+carloancombineid).hasClass("carloanedit")==true){

            var eclpaiddate=$('#eclpaiddate_'+carloancombineid).text();
        }
        else{
            var eclpaiddate=$('#Ecl_paiddate').val();
        }
        if($('#eclfromperiod_'+carloancombineid).hasClass("carloanedit")==true){

            var eclfromperiod=$('#eclfromperiod_'+carloancombineid).text();
        }
        else{
            var eclfromperiod=$('#Ecl_fromperiod').val();
        }
        if($('#ecltopaid_'+carloancombineid).hasClass("carloanedit")==true){

            var ecltopaid=$('#ecltopaid_'+carloancombineid).text();
        }
        else{
            var ecltopaid=$('#Ecl_toperiod').val();
        }
        if($('#eclamount_'+carloancombineid).hasClass("carloanedit")==true){

            var eclamount=$('#eclamount_'+carloancombineid).text();
        }
        else{
            var eclamount=$('#Ecl_invamt').val();
        }
        if($('#eclcomments_'+carloancombineid).hasClass("carloanedit")==true){

            var eclcomments=$('#eclcomments_'+carloancombineid).text();
        }
        else{
            var eclcomments=$('#Ecl_invcomments').val();
        }
        //CHECK PAID DATE GREATER THAN FROM PERIOD & TO PERIOD
        $.ajax({
            type: "POST",
            url: controller_url+"expensecarloanupdate",
            data:{'rowid':carloancombineid,'eclpaiddate':eclpaiddate,'eclfromperiod':eclfromperiod,'ecltopaid':ecltopaid,'eclamount':eclamount,'eclcomments':eclcomments},
            success: function(data) {
                $('.preloader').hide();
                var resultflag=data;
                if(resultflag==1)
                {
                    var PDLY_INPUT_expensetypetext=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                    var PDLY_INPUT_CONFSAVEMSG =PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_INPUT_expensetypetext);
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_INPUT_CONFSAVEMSG,"success",false);
                    var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
                    if((PDLY_SEARCH_lb_babysearchoptionvalue==67))
                    {
                        $('#PDLY_SEARCH_tbl_htmltable').hide();
                        $('#PDLY_SEARCH_div_htmltable').hide();
                        $('#PDLY_SEARCH_lbl_flextableheader').hide();
                        $('#PDLY_btn_pdf').hide();
                        PDLY_SEARCH_searchvalue()
                    }
                    else
                    {
                        PDLY_SEARCH_loadflextable()
                        carloanprevious_id=undefined;
                    }
                }
                else
                {
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_SEARCH_hdrmsgArray[36].EMC_DATA,"success",false);
                }
            },
            error: function (data) {
                alert('error in getting' + JSON.stringify(data));
            }
        });
    }) ;
    var PDLY_rowid='';
    //DELETE THE REQUIRED RECORD FOR ALL FORMS//
    $(document).on('click','.PDLY_SEARCH_btn_deletebutton',function(){
        PDLY_rowid = $(this).attr('id');
        show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_SEARCH_hdrmsgArray[35].EMC_DATA,"success","delete");
    });
    $(document).on('click','.deleteconfirm',function(){
        $(".preloader").show();
        var PDLY_SEARCH_obj_rowvalue=[];
        var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
        var startdate=$('#PDLY_SEARCH_db_startdate').val();
        var enddate=$('#PDLY_SEARCH_db_enddate').val();
        var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
        $.ajax({
            type: "POST",
            url: controller_url+"deleteoption",
            data:{'PDLY_SEARCH_lb_typelistvalue':PDLY_SEARCH_lb_typelistvalue,'PDLY_rowid':PDLY_rowid,'startdate':startdate,'enddate':enddate,'PDLY_SEARCH_lb_babysearchoptionvalue':PDLY_SEARCH_lb_babysearchoptionvalue},
            success: function(data) {
                $('.preloader').hide();
                var deleteflag=(data);
//                var deleteflag=successresult[0].DELETION_FLAG;
                var PDLY_SEARCH_expensetype=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                if(deleteflag==1){
                    var PDLY_SEARCH_CONFSAVEMSG = (PDLY_SEARCH_hdrmsgArray[4].EMC_DATA).replace('[TYPE]', PDLY_SEARCH_expensetype);
                    $('#PDLY_SEARCH_tble_multi').hide();
                    $('#PDLY_SEARCH_tble_carloan').hide();
                    $('#PDLY_SEARCH_btn_rbutton').hide();
                    $('#PDLY_SEARCH_btn_sbutton').hide();
                    $('#PDLY_SEARCH_btn_searchbutton').attr("disabled", "disabled");
                    $('#PDLY_SEARCH_btn_deletebutton').attr("disabled", "disabled");
                    var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false);
                    if((PDLY_SEARCH_lb_babysearchoptionvalue==54)||(PDLY_SEARCH_lb_babysearchoptionvalue==60)||(PDLY_SEARCH_lb_babysearchoptionvalue==71))
                    {
                        PDLY_SEARCH_flag_deleteupd=0;
                        itmIvsearchval=[];
                        $('#PDLY_SEARCH_tbl_htmltable').hide();
                        $('#PDLY_SEARCH_div_htmltable').hide();
                        $('#PDLY_SEARCH_lbl_flextableheader').hide();
                        $('#PDLY_btn_pdf').hide();
                        PDLY_SEARCH_searchvalue();
                    }
                    else if((PDLY_SEARCH_lb_babysearchoptionvalue==55)||(PDLY_SEARCH_lb_babysearchoptionvalue==61)||(PDLY_SEARCH_lb_babysearchoptionvalue==72))
                    {
                        Ivsearchval=[];
                        PDLY_SEARCH_searchvalue();
                        PDLY_SEARCH_flag_deleteupd=0;
                        $('#PDLY_SEARCH_tbl_htmltable').hide();
                        $('#PDLY_SEARCH_div_htmltable').hide();
                        $('#PDLY_SEARCH_lbl_flextableheader').hide();
                        $('#PDLY_btn_pdf').hide();
                    }
                    else if((PDLY_SEARCH_lb_babysearchoptionvalue==56)||(PDLY_SEARCH_lb_babysearchoptionvalue==62)||(PDLY_SEARCH_lb_babysearchoptionvalue==73)||(PDLY_SEARCH_lb_babysearchoptionvalue==67))
                    {
                        csearchval=[];
                        PDLY_SEARCH_searchvalue();
                        PDLY_SEARCH_flag_deleteupd=0;
                        $('#PDLY_SEARCH_tbl_htmltable').hide();
                        $('#PDLY_SEARCH_div_htmltable').hide();
                        $('#PDLY_SEARCH_lbl_flextableheader').hide();
                        $('#PDLY_btn_pdf').hide();
                    }
                    else
                    {
                        PDLY_SEARCH_loadflextable();
                    }
                }
                else
                {
                    show_msgbox("PERSONAL EXPENSE ENTRY/SEARCH/UPDATE/DELETE",PDLY_SEARCH_hdrmsgArray[30].EMC_DATA,"success",false);
                }
            },
            error: function (data) {
                alert('error in getting' + JSON.stringify(data));
            }
        });
    });
});

</script>

</head>
<body>
<div class="container">
<div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
<div class="title text-center"><h4><b>PERSONAL EXPENSE ENTRY/ SEARCH/ UPDATE/ DELETE</b></h4></div>
<form id="personalexpense" class="form-horizontal content" method="post" action="<?php echo site_url("EXPENSE/Ctrl_Pdf/pdfexport") ?>" >

<div class="panel-body">
<div style="padding-bottom: 15px">
    <div class="radio">
        <label><input type="radio" name="optradio" value="entryform" class="PE_rd_selectform">ENTRY</label>
    </div>
    <div class="radio">
        <label><input type="radio" name="optradio" value="searchform" class="PE_rd_selectform">SEARCH/ UDATE/ DELETE</label>
    </div>
</div>
<div id="PE_entryform" hidden>
    <div class="form-group" id="entrytypeexpense" hidden>
        <label id="PE_lbl_expensetype" class="col-sm-2" >TYPE OF EXPENSE<em>*</em></label>
        <div class="col-sm-2">
            <select id='PE_lb_expensetype' name="PE_lb_expensetype"  class="form-control" >
                <option value='SELECT' selected="selected"> SELECT</option>
            </select>
        </div>
    </div>
    <!-- FORM ELEMENT FOR EXPENSE BABY AND PERSONAL-->
    <div id="form_baby" hidden>
        <div class="table-responsive">
            <table  id="PDLY_INPUT_tble_multi">
                <tr>
                    <td nowrap><label  id="PDLY_INPUT_lbl_expense">CATEGORY OF EXPENSE<em>*</em></label> </td>
                    <td style="max-width: 150px" nowrap><label  id="PDLY_INPUT_lbl_invdate">INVOICE DATE<em>*</em></label></td>
                    <td style="max-width: 200px" nowrap><label id="PDLY_INPUT_lbl_invamt">INVOICE AMOUNT<em>*</em></label> </td>
                    <td ><label id="PDLY_INPUT_lbl_invitm">INVOICE ITEMS<em>*</em></label> </td>
                    <td ><label id="PDLY_INPUT_lbl_invfrom">INVOICE FROM<em>*</em></label> </td>
                    <td ><label id="PDLY_INPUT_lbl_invcmt">COMMENTS</label></td>
                </tr>
                <tr>
                    <td><select class="form-control submultivalid"   name="PDLY_INPUT_lb_category[]" id="PDLY_INPUT_lb_category1"><option >SELECT</option> </select> </td>
                    <td><input class="form-control submultivalid date-picker datemandtry"   type="text" name ="PDLY_INPUT_db_invdate[]" id="PDLY_INPUT_db_invdate1" style="max-width:100px;" /> </td>
                    <td><input   type="text" name ="PDLY_INPUT_tb_incamtrp[]" id="PDLY_INPUT_tb_incamtrp1"  class="submultivalid form-control amtonly" style="max-width:90px;"   /></td>
                    <td><textarea class="submultivalid form-control"   name="PDLY_INPUT_ta_invitem[]" id="PDLY_INPUT_ta_invitem1"></textarea></td>
                    <td><input class="submultivalid form-control autosize autocompinc"  type="text" name ="PDLY_INPUT_tb_invfrom[]" id="PDLY_INPUT_tb_invfrom1" maxlength="200"/></td>
                    <td><textarea  class="submultivalid form-control" name ="PDLY_INPUT_tb_comments[]" id="PDLY_INPUT_tb_comments1"></textarea></td>
                    <td><input enabled type='button'disabled value='+' class='addbttn' alt='Add Row' style="max-height: 30px; max-width:30px;" name ='PDLY_INPUT_btn_addbtn' id='PDLY_INPUT_btn_addbtn1'  disabled/></td>
                    <td><input  type='button' value='-' class='deletebttn' alt='delete Row' style="max-height: 30px; max-width:30px;" name ='PDLY_INPUT_btn_delbtn' id='PDLY_INPUT_btn_delbtn1'  disabled /></td>
                </tr>
            </table>
            <table>
                <tr><td><input type="button"   id="PDLY_INPUT_btn_bbypsnlsbutton"  value="SAVE" class="btn btn-info" disabled hidden /></td></tr>
                <tr><td><input type="text" name ="PDLY_INPUT_hideaddid" id="PDLY_INPUT_hideaddid" hidden /> </td></tr>
                <tr><td><input type="text" name ="PDLY_INPUT_hideremoveid" id="PDLY_INPUT_hideremoveid" hidden /> </td></tr>
                <tr><td><input type="text" name ="PDLY_INPUT_hidetablerowid" id="PDLY_INPUT_hidetablerowid" hidden /> </td></tr>
            </table>
        </div>
    </div>
    <!-- FORM EXPENSE CAR-->
    <div id="form_car" hidden>
        <div class="form-group">
            <label id="PCE_lbl_ctry" class="col-sm-2" >CATEGORY OF CAR EXPENSE<em>*</em></label>
            <div class="col-sm-2">
                <select id='PCE_lb_ctry' name="PCE_lb_ctry" class="form-control carsubmultivalid" >
                </select>
            </div>
        </div>
        <div class="form-group">
            <label id="PCE_lbl_invdte" class="col-sm-2" >INVOICE DATE<em>*</em></label>
            <div class="col-sm-2">
                <div class="input-group addon">
                <input type="text"  placeholder="Invoice Date" id="PCE_tb_invdate" name="PCE_tb_invdate" class="form-control date-picker datemandtry carsubmultivalid"/>
                <label for="PCE_tb_invdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
            </div>
            </div>
        </div>
        <div class="form-group">
            <label id="PCE_lbl_invitems" class="col-sm-2" >INVOICE AMOUNT<em>*</em></label>
            <div class="col-sm-3">
                <input type="text" style="max-width: 80px;" placeholder="Invoice Amount" id="PCE_tb_invamt" name="PCE_tb_invamt" class="form-control amtonly carsubmultivalid" />
            </div>
        </div>
        <div class="form-group">
            <label id="PCE_lbl_invitems" class="col-sm-2" >INVOICE ITEMS<em>*</em></label>
            <div class="col-sm-4">
                <textarea  placeholder="Invoice Items" id="PCE_ta_invitems" name="PCE_ta_invitems" class="form-control txtareaheight carsubmultivalid PDLY_INPUT_ta_cmtItem" ></textarea>
            </div>
        </div>
        <div class="form-group">
            <label id="PCE_lbl_invfrom" class="col-sm-2" >INVOICE FROM<em>*</em></label>
            <div class="col-sm-2">
                <input type="text" placeholder="Invoice From" id="PCE_tb_invfrom" class="form-control carsubmultivalid autosize" name="PCE_tb_invfrom" />
            </div>
        </div>
        <div class="form-group">
            <label id="PCE_lbl_comments" class="col-sm-2" >COMMENTS</label>
            <div class="col-sm-4">
                <textarea id="PCE_ta_comments" placeholder="Comments" name="PCE_ta_comments" class="form-control txtareaheight carsubmultivalid PDLY_INPUT_ta_cmtItem" ></textarea>
            </div>
        </div>
        <div class="col-lg-offset-1">
            <input class="btn  btn-info" type="button"  id="PCE_save_btn" name="PCE_save_btn" value="SAVE" disabled />&nbsp;&nbsp;<input class="btn  btn-info resetbtn" type="button"  id="PCE_reset_btn" name="PCE_reset_btn" value="RESET" />
        </div>
    </div>
    <!-- FORM EXPENSE CAR LOAN-->
    <div id="form_carloan" hidden>
        <div class="form-group">
            <label id="PCLE_lbl_paiddte" class="col-sm-2" >PAID DATE<em>*</em></label>
            <div class="col-sm-2">
                <div class="input-group addon">
                <input type="text" placeholder="Paid Date"  id="PCLE_tb_paiddte" name="PCLE_tb_paiddte" class="form-control date-picker datemandtry carloansubmultivalid"  />
                    <label for="PCLE_tb_paiddte" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label id="PCLE_lbl_frmperiod" class="col-sm-2" >FROM PERIOD<em>*</em></label>
            <div class="col-sm-2">
                <div class="input-group addon">
                <input type="text" placeholder="From Period"  id="PCLE_tb_fromperiod" name="PCLE_tb_fromperiod" class="form-control date-picker datemandtry carloansubmultivalid" />
                    <label for="PCLE_tb_fromperiod" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label id="PCLE_lbl_toperiod" class="col-sm-2" >TO PERIOD<em>*</em></label>
            <div class="col-sm-2">
                <div class="input-group addon">
                <input type="text" placeholder="To Period"  id="PCLE_ta_toperiod" name="PCLE_ta_toperiod" class="form-control date-picker datemandtry carloansubmultivalid" >
                    <label for="PCLE_ta_toperiod" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label id="PCLE_lbl_invamt" class="col-sm-2" >INVOICE AMOUNT<em>*</em></label>
            <div class="col-sm-3">
                <input type="text" placeholder="Invoice Amount" style="max-width: 80px;" id="PCLE_tb_invamt" class="form-control amtonly carloansubmultivalid" name="PCLE_tb_invamt" />
            </div>
        </div>
        <div class="form-group">
            <label id="PCLE_lbl_comments" class="col-sm-2" >COMMENTS</label>
            <div class="col-sm-4">
                <textarea placeholder="Comments" id="PCLE_ta_comments" name="PCLE_ta_comments" class="form-control txtareaheight PDLY_INPUT_ta_cmtItem carloansubmultivalid" ></textarea>
            </div>
        </div>
        <div class="col-lg-offset-1">
            <input class="btn  btn-info" type="button"  id="PCLE_save_btn" name="PCLE_save_btn" value="SAVE" disabled />&nbsp;&nbsp;<input class="btn  btn-info resetbtn" type="button"  id="PCLE_reset_btn" name="PCLE_reset_btn" value="RESET" />
        </div>
    </div>
</div>
<div id="PE_searchform" hidden>
    <div class="form-group" id="typesearchlb">
        <label id="PDLY_SEARCH_lbl_type" class="col-sm-2" >TYPE OF EXPENSE<em>*</em></label>
        <div class="col-sm-2">
            <select id='PDLY_SEARCH_lb_typelist' name="PDLY_SEARCH_lb_typelist"  class="form-control" >
                <option value='SELECT' selected="selected"> SELECT</option>
            </select>
        </div>
    </div>
    <div class="form-group" id="searchoption">
        <label id='PDLY_SEARCH_lbl_babysearchoption'  class="col-sm-2" hidden>SEARCH OPTION<em>*</em></label>
        <div class="col-sm-3">
            <select  id='PDLY_SEARCH_lb_babysearchoption' name="PDLY_SEARCH_lb_babysearchoption" class="form-control"  hidden>
                <option>SELECT</option>
            </select>
        </div>
    </div>
    <div>
        <label class="srctitle" id='PDLY_SEARCH_lbl_bybabycmts'  hidden>SEARCH BY BABY EXPENSE COMMENTS<em>*</em></label>
    </div>
    <div id='PDLY_SEARCH_tble_searchtable'>
        <div class="form-group" id="div_category">
            <label  id='PDLY_SEARCH_lbl_babyexpansecategory' class="col-sm-2" hidden>BABY EXPENSE CATEGORY<em>*</em></label>
            <div class="col-sm-2"><select class="submitval form-control" id='PDLY_SEARCH_lb_babyexpansecategory'  name="PDLY_SEARCH_lb_babyexpansecategory"  hidden>
                    <option>SELECT</option>
                </select></div>
        </div>
        <div class="form-group" id="div_startdate">
            <label  id='PDLY_SEARCH_lbl_startdate' class="col-sm-2" hidden> START DATE <em>*</em></label>
            <div class="col-sm-2">
                <div class="input-group addon">
                <input  type="text" class="datebox submitval datemandtry form-control"  name="PDLY_SEARCH_db_startdate" id="PDLY_SEARCH_db_startdate"  hidden />
                    <label for="PDLY_SEARCH_db_startdate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
                </div>
           </div>
        </div>
        <div class="form-group" id="div_enddate">
            <label id='PDLY_SEARCH_lbl_enddate' class="col-sm-2" hidden> END DATE <em>*</em></label>
            <div class="col-sm-2">
                <div class="input-group addon">
                <input  type="text" class="datebox submitval datemandtry form-control" name="PDLY_SEARCH_db_enddate" id="PDLY_SEARCH_db_enddate"  hidden />
                    <label for="PDLY_SEARCH_db_enddate" class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></label>
            </div>
            </div>
        </div>
        <div class="form-group" id="div_comments">
            <label  id='PDLY_SEARCH_lbl_searchabycmt' class="col-sm-2"   hidden> COMMENTS <em>*</em></label>
            <div class="col-sm-4">
                <textarea  name="PDLY_SEARCH_tb_searchabycmt" class="submitval form-control txtareaheight" id="PDLY_SEARCH_tb_searchabycmt"  hidden ></textarea>
            </div>
        </div>
        <div><label id='PDLY_SEARCH_lbl_babyshowcomments' class="errormsg" hidden >  </label></div>
        <div class="form-group" id="div_invoicefrom">
            <label  id='PDLY_SEARCH_lbl_searchbyinvfrom' class="col-sm-2" hidden> INVOICE FROM <em>*</em></label>
            <div class="col-sm-4">
                <input  type="text" class="submitval form-control" name ="PDLY_SEARCH_tb_searchbyinvfrom" id="PDLY_SEARCH_tb_searchbyinvfrom" hidden />
            </div>
        </div>
        <div class="form-group" id="div_invoiceitem">
            <label  id='PDLY_SEARCH_lbl_searchbyinvitem' class="col-sm-2" hidden> INVOICE ITEM <em>*</em></label>
            <div class="col-sm-4">
                <textarea  type="text" class="submitval form-control txtareaheight" name ="PDLY_SEARCH_tb_searchbyinvitem" id="PDLY_SEARCH_tb_searchbyinvitem"   hidden ></textarea>
            </div>
        </div>
        <div class="form-group" id="div_fromamt">
            <label  id='PDLY_SEARCH_lbl_fromamount' class="col-sm-2" hidden> FROM AMOUNT <em>*</em></label>
            <div class="col-sm-2">
                <input   type="text" name ="PDLY_SEARCH_tb_fromamount" id="PDLY_SEARCH_tb_fromamount"  class="amtsubmitval form-control" style="width:90px;"hidden />
            </div>
        </div>
        <div class="form-group" id="div_toamt">
            <label  id='PDLY_SEARCH_lbl_toamount' class="col-sm-2" hidden> TO AMOUNT <em>*</em></label>
            <div class="col-sm-2">
                <input   type="text" name ="PDLY_SEARCH_tb_toamount" id="PDLY_SEARCH_tb_toamount"  class="amtsubmitval form-control" style="width:90px;" hidden />
            </div>
            <label class="errormsg" id='PDLY_SEARCH_lbl_amounterrormsg'  hidden></label>
        </div>
        <div class="col-lg-offset-2">
            <input type="button"   id="PDLY_SEARCH_btn_babybutton" disabled  value="SEARCH" class="btn" hidden />
        </div>
    </div>
    <div>
        <label id='PDLY_SEARCH_lbl_flextableheader' name='PDLY_SEARCH_lbl_flextableheader' class="srctitle" hidden></label>
        <input type="hidden" name="PDLY_SEARCH_hdn_flextableheader" id="PDLY_SEARCH_hdn_flextableheader" />
        <input type="hidden" name="PDLY_SEARCH_hdn_expensetype" id="PDLY_SEARCH_hdn_expensetype" />
    </div>
    <div><input type="submit" id='PDLY_btn_pdf' class="btnpdf" value="PDF" hidden></div>
    <div  id ="PDLY_SEARCH_div_htmltable" class="table-responsive">
        <section>

        </section>
    </div>
    <div ><label class="errormsg" id="PDLY_SEARCH_lbl_nodataerrormsg" hidden></label></div>
</div>
</div>

</form>
</div>
</body>
</html>​
