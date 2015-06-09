<!--//*******************************************FILE DESCRIPTION*********************************************//
//***********************************************TICKLER HISTORY*******************************//
//DONE BY:LALITHA
//VER 0.01-INITIAL VERSION, SD:26/05/2015 ED:26/05/2015
//************************************************************************************************************-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<html>
<head>
    <script>
        //READY FUNCTION START
        $(document).ready(function() {
            var TH_controller_url="<?php echo base_url(); ?>" + '/index.php/REPORT/Ctrl_Report_Tickler_History/' ;
            $('#spacewidth').height('0%');
            $(".preloader").hide();
            TH_customername_autocompleteresult()
            //FUNCTION TO HIGHLIGHT SEARCH TEXT
            function TH_highlightSearchText() {
                $.ui.autocomplete.prototype._renderItem=function(ul,item) {
                    var re = new RegExp(this.term, "i") ;
                    var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append( "<a>" + t + "</a>" )
                        .appendTo( ul );
                };
            }
            //FUNCTION TO AUTOCOMPLETE SEARCH TEXT
            var TH_customername=[];
            var TH_customername_array=[];
            var TH_error=[];
            function TH_customername_autocompleteresult()
            {
                $.ajax({
                        type: "POST",
                    'url':TH_controller_url+"TH_customername_autocomplete",
                    data:{'ErrorList':'46,368,369'},
                    success: function(data) {
                            $(".preloader").hide();
                            TH_customername_array=JSON.parse(data)
                            TH_customername=TH_customername_array[0]
                            TH_error=TH_customername_array[1]
                            $("#TH_ta_customername").val("");
                        },error:function(data){
                        alert(JSON.stringify(data))
                    }
                });
            }
            //KEY PRESS FUNCTION
            $("#TH_ta_customername").keypress(function(){
                $('#TH_div_headernodata').hide();
                $('#TH_lbl_notmatch').hide();
                $('#TH_tble_htmltable').hide();
                $('section').html('');
                $('#TH_div_header').hide();
                $("#TH_btn_search_customername").attr("disabled","disabled");
                TH_chkflag=0;
                TH_highlightSearchText();
                $("#TH_ta_customername").autocomplete({
                    source:TH_customername,
                    select:TH_AutoCompleteSelectHandler
                });
            });
//CHANGE FUNCTION FOR CUSTOMER NAME
            var TH_chkflag;
            $(document).on('change','.custnameresultsvalidate',function(){
                if(TH_chkflag==1){
                    $('#TH_lbl_notmatch').hide();
                }
                else
                {
                    $('#TH_lbl_notmatch').text(TH_error[2].EMC_DATA);
                    $('#TH_div_headernodata').hide();
                    $('#TH_tble_htmltable').hide();
                    $('#TH_div_header').hide();
                    $("#TH_btn_search_customername").attr("disabled","disabled");
                }
                if($('#TH_ta_customername').val()=="")
                {
                    $('#TH_lbl_notmatch').hide();
                    $('#TH_div_header').hide();
                    $('#TH_div_headernodata').hide();
                }
            });
//FUNCTION TO GET SELECTED VALUE
            function TH_AutoCompleteSelectHandler(event,ui) {
                TH_chkflag=1;
                $('#TH_lbl_notmatch').hide();
                $('#TH_btn_search_customername').removeAttr("disabled");
            }
            //CLICK EVENT FUNCTION FOR CUSTOMER NAME
            $('#TH_btn_search_customername').click(function(){
                var  newPos= adjustPosition($(this).position(),100,230);
                resetPreloader(newPos);
                $(".preloader").show();
                $('#TH_btn_search_customername').removeAttr("disabled");
                $('#TH_div_headernodata').hide();
                $('#TH_div_header').hide();
                $('#TH_tble_htmltable').hide();
                var TH_customername=$('#TH_ta_customername').val();
                TH_srch_result()
            });
            var TH_srch_result_array=[];
//SUCCESS FUNCTION FOR FLEX TABLE DATA
            function TH_srch_result()
            {
                var TH_customer_name=$('#TH_ta_customername').val();
                var cust_name=TH_customer_name.split(" ")
                var cust_first_name=cust_name[0]
                var cust_last_name=cust_name[1]
                var TH_customername=$("#TH_ta_customername").val();
                $('#TH_ta_customername').val('');
                $.ajax({
                    type: "POST",
                    'url':TH_controller_url+"fetchdata",
                    data: {'cust_first_name':cust_first_name,'cust_last_name':cust_last_name},
                    success: function(data) {
                        $('.preloader').hide();
                        TH_srch_result_array=JSON.parse(data);
                        if(TH_srch_result_array.length!=0)
                        {
                            var TH_errmsg=TH_error[1].EMC_DATA.replace('[CUSTOMER NAME]',TH_customername);
                            $('#TH_div_header').text(TH_errmsg).show();
                            var TH_value='<table id="TH_tble_htmltable" border="1"  cellspacing="0" class="srcresult"  ><thead  bgcolor="#6495ed" style="color:white"><tr><th style="width:600px">HISTORY</th><th style="width:200px">USERSTAMP</th><th style="width:150px">TIMESTAMP</th></tr></thead><tbody>'
                            for(var i=0;i<TH_srch_result_array.length;i++){
                                var TH_values=TH_srch_result_array[i]
                                var TH_arrrow=TH_values.oldvalue;
                                var TH_arrnewrow=TH_values.newvalue;
                                var TH_arrchk=[];
                                var TH_arrnewchk=[];
                                TH_arrchk=(TH_arrrow).split(',')
                                TH_arrnewchk=(TH_arrnewrow).split(',')
                                var TH_arroldvalue='';
                                var TH_arrnewvalue='';
                                for(var j=0;j<TH_arrchk.length;j++)
                                {
                                    if(j==0)
                                    {
                                        TH_arroldvalue=TH_arrchk[j];
                                    }
                                    else
                                    {
                                        TH_arroldvalue +=' , '+TH_arrchk[j];
                                    }
                                    TH_arroldvalue=replaceSpclcharAngularBrack(TH_arroldvalue)
                                }
                                for(var k=0;k<TH_arrnewchk.length;k++)
                                {
                                    if(k==0)
                                    {
                                        TH_arrnewvalue=TH_arrnewchk[k];
                                    }
                                    else
                                    {
                                        TH_arrnewvalue +=' , '+TH_arrnewchk[k];
                                    }
                                    TH_arrnewvalue=replaceSpclcharAngularBrack(TH_arrnewvalue)
                                }
                                TH_value+='<tr><td>'+'CUSTOMER ID:'+''+TH_values.customerid+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+'CUSTOMER NAME:'+''+cust_first_name+' '+cust_last_name+'<br>'+'UPDATION/DELETION  :'+''+TH_values.upddel+'<br>'+'TABLE NAME:'+''+TH_values.tablename+'<br><br>'+'OLD VALUE:'+TH_arroldvalue+'<br><br><br>'+'NEW VALUE:'+TH_arrnewvalue+'</td><td>'+TH_values.userstamp+'</td><td>'+TH_values.timestamp+'</td></tr>';
                            }
                            TH_value+='</tbody></table>';
                            $('section').html(TH_value);
                            $('#TH_tble_htmltable').DataTable( {
                                "aaSorting": [],
                                "pageLength": 10,
                                "sPaginationType":"full_numbers"
                            });
                            $('#TH_div_flexdata_result').show();
                        }
                        else
                        {
                            $('#TH_div_header').hide();
                            $('#TH_tble_htmltable').hide();
                            $('#TH_btn_search_customername').attr("disabled", "disabled");
                            var TH_errmsg=TH_error[0].EMC_DATA.replace('[FIRST NAME + LAST NAME]',TH_customername);
                            $('#TH_div_headernodata').text(TH_errmsg).show();
                            $('#TH_div_flexdata_result').hide();
                        }
                        $('#TH_btn_search_customername').attr("disabled", "disabled");
            },error:function(data){
                        alert(JSON.stringify(data))
                    }
                });
            }
            //FUNCTION FOR FORMTABLEDATEFORMAT
            function FormTableDateFormat(inputdate){
                var string = inputdate.split("-");
                return string[2]+'-'+ string[1]+'-'+string[0];
            }
            function replaceSpclcharAngularBrack(str)
            {
                var finalstr = str.replace(/</g, "&lt;");
                finalstr = finalstr.replace(/>/g, "&gt;");
                return finalstr;
            }
            //FUNCTION FOR SORTING
            function sorting(){
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
</script>
</head>
<body>
<div class="container">
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>TICKLER HISTORY</b></h4></div>
    <form id="TH_form_customername" name="TH_form_customername" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="row form-group">
                    <label name="TH_lbl_customername" id="TH_lbl_customername" class="col-sm-2">CUSTOMER NAME</label>
                    <div class="col-sm-4">
                        <input  type="text" name="TH_ta_customername" id="TH_ta_customername" class = " amtsubmitval  amountonly" style="width:400px">
                        <div><label id="TH_lbl_notmatch" name="TH_lbl_notmatch" class="errormsg" hidden></label></div>                    </div>
                </div>
                <div class="col-lg-offset-2">
                    <input type="button"   id="TH_btn_search_customername"   value="SEARCH" class="btn" disabled hidden />
                </div>
                <div class="srctitle" name="TH_div_header" id="TH_div_header"></div><br>
                <div class="errormsg" name="TH_div_headernodata" id="TH_div_headernodata"></div>
                <div class="table-responsive" id="TH_div_flexdata_result" style="  overflow-y: hidden;" hidden>
                    <section>
                    </section>
                </div>
 </fieldset>
        </div>
    </form>
</div>
</body>
</html>