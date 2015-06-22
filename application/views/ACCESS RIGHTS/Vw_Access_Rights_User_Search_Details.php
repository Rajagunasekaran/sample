<!--*********************************************GLOBAL DECLARATION******************************************-->
<!--*********************************************************************************************************//-->
<!--//*******************************************FILE DESCRIPTION*********************************************//
//****************************************USER SEARCH DETAILS*************************************************//
//DONE BY:safi
//VER 0.01-INITIAL VERSION,SD:19/05/2015 ED:19/05/2015
//*********************************************************************************************************//-->

<?php

require_once('application/libraries/EI_HDR.php');

?>

<html>
<head>

    <script>
    //DOCUMENT READY FUNCTION START
    $(document).ready(function(){
        $(document).on('click','#URSRC_btn_pdf',function(){
            var pdfurl=document.location.href='<?php echo site_url('ACCESSRIGHTS/Ctrl_Access_Rights_User_Search_Details/User_Details_pdf')?>';
        });
        $('#URSRC_btn_pdf').hide();
        var title;
        var values_arraystotal=[];
        var values_array=[];
        table();
        //FUNCTION FOR FORM TABLE DATE FORMAT
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        function table(){
            $.ajax({
                type:'post',
                'url':"<?php echo base_url();?>" +"index.php/ACCESSRIGHTS/Ctrl_Access_Rights_User_Search_Details/USD_SRC_flextable_getdatas",
                success:function(data){
                    $('.preloader').hide();
                    var USD_SRC_response=JSON.parse(data);
                    values_array=USD_SRC_response[0];
                    var USD_SRC_errorAarray=USD_SRC_response[1];
                    if(values_array.length!=0)
                    {

                        $('#URSRC_btn_pdf').show();
                        var USU_table_header='<table id="USD_SRC_SRC_tble_htmltable" border="1"  cellspacing="0" class="srcresult" style="width:1500px" ><thead  bgcolor="#6495ed" style="color:white"><tr><th nowrap>LOGIN ID</th><th nowrap>ROLE</th><th>REC VER</th><th   class="uk-date-column">JOIN DATE</th><th  class="uk-date-column">TERMINATION DATE</th><th >REASON OF TERMINATION</th><th>USERSTAMP</th><th  class="uk-timestp-column" nowrap>TIMESTAMP</th></tr></thead><tbody>'
                        for(var j=0;j<values_array.length;j++){
                            var USD_SRC_loginid=values_array[j].loginid;
                            var USD_SRC_rcid=values_array[j].rcid;
                            var USD_SRC_recordver=values_array[j].recordver;
                            var USD_SRC_joindate=values_array[j].joindate;
                            var USD_SRC_terminationdate=values_array[j].terminationdate;
                            if((USD_SRC_terminationdate=='null')||(USD_SRC_terminationdate==undefined))
                            {
                                USD_SRC_terminationdate='';
                            }
                            var USD_SRC_reasonoftermination=values_array[j].reasonoftermination;
                            if((USD_SRC_reasonoftermination=='null')||(USD_SRC_reasonoftermination==undefined))
                            {
                                USD_SRC_reasonoftermination='';
                            }
                            var USD_SRC_userstamp=values_array[j].userstamp;
                            var USD_SRC_timestamp=values_array[j].timestamp;
                            USU_table_header+='<tr><td nowrap>'+USD_SRC_loginid+'</td><td align="center" nowrap>'+USD_SRC_rcid+'</td><td align="center">'+USD_SRC_recordver+'</td><td nowrap align="center">'+USD_SRC_joindate+'</td><td style="width:10px;" align="center">'+USD_SRC_terminationdate+'</td><td style="width:650px;">'+USD_SRC_reasonoftermination+'</td><td align="center">'+USD_SRC_userstamp+'</td><td  style="min-width:150px;" align="center" nowrap>'+USD_SRC_timestamp+'</td></tr>';
                        }
                        USU_table_header+='</tbody></table>';
                        $('section').html(USU_table_header);
                        $('#USD_SRC_SRC_tble_htmltable').DataTable( {
                            dom: "Rlfrtip",
                            tableTools: {"aButtons": [
                                {
                                    "sExtends": "pdf",

                                    "sPdfOrientation": "landscape",
                                    "sPdfSize": "A3"
                                }],
                                "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"
                            },
                            "aaSorting": [],
                            "pageLength": 10,
                            "sPaginationType":"full_numbers",
                            "aoColumnDefs" : [
                                { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ]
                        });
                        sorting();
                                        $('#tablecontainer').show();
                    }
                    else
                    {
                        $('#URSRC_lbl_norole_err').text(USD_SRC_errorAarray[0].EMC_DATA).show();
                        $('#URSRC_lbl_title').hide();
                        $('#URSRC_btn_pdf').hide();
                    }

                },
                error:function(data){

                    show_msgbox("USER SEARCH DETAILS",JSON.stringify(data),"error",false);
                }

            } );//FUNCTION FOR SORTING
        }
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
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="row title text-center"><h4><b>USER SEARCH DETAILS</b></h4></div>
            <form id="USD_SRC_SRC_form_user" name="USD_SRC_SRC_form_user" class="form-horizontal content" role="form">
                <div class="panel-body">
                <div><label id="URSRC_lbl_title" name="URSRC_lbl_title" class="srctitle"></label></div>
                <div><input type="button" id='URSRC_btn_pdf' class="btnpdf" value="PDF"></div><br>
                <div class="table-responsive" id="tablecontainer" hidden >
                    <section>
                    </section>
                </div>
                </div>
                <div><label id="URSRC_lbl_norole_err" name="URSRC_lbl_norole_err" class="errormsg"></label></div>
            </form>
    </div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->