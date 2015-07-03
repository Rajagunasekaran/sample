<!--*********************************CUSTOMER TERMINATION*******************************************//
//ver 0.04- updated save point and CR in termination
//DONE BY:SASIKALA
//VER 0.03 -SD:05/06/2015 ED:05/06/2015 GETTING HEADER FILE FROM LIB
//VER 0.02 SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names
//VER 0.01-SD:30/05/2015 ED:03/06/2015,INITIAL VERSION
//*******************************************************************************************************//-->
<?php
require_once('application/libraries/EI_HDR.php');
?>
<style>
td, th {
    padding: 9px;
}
</style>
<script>
    $(document).ready(function(){
        $('#spacewidth').height('0%');
        $('textarea').autogrow({onInitialize: true});
        //FUNCTION TO UNIQUE ARRAY VALUES
        function unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
//FUNCTION TO CALL DATE PICKER FORMAT
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        var controller_url="<?php echo base_url(); ?>" + '/index.php/CUSTOMER/CUSTOMER/Ctrl_Customer_Termination/' ;
        var CTERM_ptdfrmtime=[];
        var CTERM_minptdcustdate="";
        var CTERM_custptdchkflag=false;
        var CTERM_errmsgs=[];
        var CTERM_result_array=[];
        var Globalrecver='';
//CALL GS FUNCTION TO CALENDAR EVENT TIME N ERROR MESSAGES
        $.ajax({
            type: "POST",
            'url': controller_url+"CTERM_getErrMsgCalTime",
            success: function(res) {
                $('.preloader').hide();
                var result=JSON.parse(res);
                CTERM_getErrMsgCalTime_result(result)
             },
            error: function (data) {
                alert('error in getting' + JSON.stringify(data));
            }
        });
//FUNCTION TO SET CALENDAR EVENT TIME RESULT
        function CTERM_getErrMsgCalTime_result(cterm_errtime)
        {
            CTERM_errmsgs=cterm_errtime.errormsg;
            CTERM_ptdfrmtime=cterm_errtime.calfrmtime;
            if(cterm_errtime.namelen==0)
            {
                $('#CTERM_form').replaceWith('<p><label class="errormsg"> '+CTERM_errmsgs[0].EMC_DATA+' & '+CTERM_errmsgs[4].EMC_DATA+'</label></p>')
            }
            else
            {
                $('#CTERM_form').show();
            }
        }
        //OPTION RADIO BUTTON CHANGE
        $("input[name='CTERM_radio_termoption']").on("change", function () {
            $(".preloader").show();
            $('#CTERM_lbl_custname').hide();
            $('#CTERM_lb_custname').hide();
            $('#CTERM_div_custid').hide();
            $('#CTERM_div_errmsg').hide();
            $('#CTERM_div_srctable').hide();
            $('#CTERM_div_srcbtn').hide();
            $('#CTERM_div_termform').hide();
            if(this.value=="CTERM_radio_activecust")
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"CTERM_getCustomerName",
                    data:$('#CTERM_form').serialize(),
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getCustomerName_result(result)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            if(this.value=="CTERM_radio_untermnonactive")
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"CTERM_getCustomerName",
                    data:$('#CTERM_form').serialize(),
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getCustomerName_result(result)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            if(this.value=="CTERM_radio_reactivecust")
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"CTERM_getCustomerName",
                    data:$('#CTERM_form').serialize(),
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getCustomerName_result(result)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        //FUNCTION TO SET CUSTOMER NAME
        function CTERM_getCustomerName_result(CTERM_cname)
        {
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            var cterm_err="";
            var CTERM_radio_termoption =$("input[name='CTERM_radio_termoption']:checked").val();
            $('#CTERM_div_custid').hide();
            if(CTERM_cname.length==0)
            {
                $('#CTERM_lbl_custname').hide();
                $('#CTERM_lb_custname').val("SELECT").hide();
                if(CTERM_radio_termoption=="CTERM_radio_reactivecust")
                {
                    cterm_err=CTERM_errmsgs[4].EMC_DATA;
                }
                else
                {
                    cterm_err=CTERM_errmsgs[0].EMC_DATA;
                }
                $('#CTERM_div_errmsg').text(cterm_err).removeClass("srctitle").addClass("errormsg").show();
            }
            else
            {
                $('#CTERM_div_errmsg').text("")
                var CTERM_nameres='<option>SELECT</option>';
                for(var i=0;i<CTERM_cname.length;i++)
                {
                    var CTERM_custname=CTERM_cname[i].split("_");
                    CTERM_nameres += '<option value="' + CTERM_cname[i] + '">' + CTERM_custname[0]+" "+CTERM_custname[1] + '</option>';
                }
                $('#CTERM_lbl_custname').show();
                $('#CTERM_lb_custname').html(CTERM_nameres).show();
            }
        }
        //GET CUSTOMER ID FOR THE SELECTED CUSTOMER NAME
        $('#CTERM_lb_custname').change(function()
        {
            $('#CTERM_div_custid').hide();
            $('#CTERM_div_errmsg').hide();
            $('#CTERM_div_srctable').hide();
            $('#CTERM_div_srcbtn').hide();
            $('#CTERM_div_termform').hide();
            var CTERM_lb_custname=$('#CTERM_lb_custname').val();
            if(CTERM_lb_custname!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"CTERM_getCustomerId",
                    data:$('#CTERM_form').serialize(),
                    success: function(res) {
                        var result=JSON.parse(res);
                        CTERM_getCustomerId_result(result)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
            else
            {
                $('#CTERM_div_custid').hide();
                $('#CTERM_div_srctable').hide();
            }
        });
        //ADD CUSTOMER ID IN THE  RADIO BUTTON
        function CTERM_getCustomerId_result(CTERM_Cid)
        {
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            var CTERM_lb_custname=$('#CTERM_lb_custname').val();
            var CTERM_radio_termoption=$("input[name=CTERM_radio_termoption]:checked").val();
            var CTERM_custname=CTERM_lb_custname.split("_");
            if(CTERM_Cid.length==1)
            {
                $('#CTERM_hidden_custid').val(CTERM_Cid[0]);
                $.ajax({
                    type: "POST",
                    url: controller_url+"CTERM_getCustomerdtls",
                    data:{'custid':CTERM_Cid[0],'radiooption':CTERM_radio_termoption},
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getCustomerdtls_result(result)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
                $('#CTERM_div_custid').hide();
            }
            else
            {
                $(".preloader").hide();
                $('#CTERM_div_custid >div').remove();
                for(var i=0;i<CTERM_Cid.length;i++)
                {
                    var CTERM_result='<div class="radio"><label id="custid"><input type=radio name="CTERM_radiocustid" id='+CTERM_Cid[i]+' value='+CTERM_Cid[i]+' class="CTERM_class_custid">'+CTERM_custname[0]+" "+CTERM_custname[1]+' '+CTERM_Cid[i]+'</label></div>';
                    $('#CTERM_div_custid').append(CTERM_result);
                }
                $('#CTERM_div_custid').show();
            }
        }
        //FUNCTION TO SET DETAILS IN TABLE FOR THE SELECTED CUSTOMER NAME
        function CTERM_getCustomerdtls_result(result)
        {
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            var CTERM_lb_custname=$('#CTERM_lb_custname').val();
            var CTERM_custname=CTERM_lb_custname.split("_");
            var CTERM_radio_termoption =$("input[name='CTERM_radio_termoption']:checked").val()
            CTERM_result_array=result.finaldts;
            Globalrecver=result.globalrecver;
            if(CTERM_result_array.length==0)
            {
                $('#CTERM_div_errmsg').text(CTERM_errmsgs[3].EMC_DATA.replace('[CNAME]',(CTERM_custname[0]+" "+CTERM_custname[1]))).removeClass("srctitle").addClass("errormsg").show();
            }
            else
            {
                var CTERM_table_header='';
                $('#CTERM_div_errmsg').text(CTERM_errmsgs[2].EMC_DATA.replace('[FIRST NAME + LAST NAME]',CTERM_custname[0]+" "+CTERM_custname[1])).removeClass("errormsg").addClass("srctitle").show();
                CTERM_table_header='<table id="CTERM_tbl_srctable" border="1"  cellspacing="0" class="srcresult"  style="width:3000px"><thead><tr><th style="width:40px">UNIT NUMBER</th><th >FIRST NAME</th><th >LAST NAME</th><th style="width:95px">START DATE</th><th style="width:75px">END DATE</th><th style="width:75px">PRETERMINATE DATE</th><th style="width:30px">LEASE PERIOD</th><th style="width:180px">ROOM TYPE</th><th style="width:55px">CARD NUMBER</th ><th style="width:10px">GUEST CARD</th><th style="width:10px">PRETERMINATE</th><th style="width:10px">EXTENSION</th><th style="width:10px">RECHECKIN</th><th style="width:10px">TERMINATE</th><th style="width:100px">LEASE PERIOD DURATION</th><th style="width:30px">QUARTERS</th><th style="width:55px">RENT</th><th style="width:500px">COMMENTS</th><th style="width:170px">USERSTAMP</th><th style="width:140px">TIMESTAMP</th></tr></thead><tbody>';
                for(var i=0;i<CTERM_result_array.length;i++)
                {
                    var CTERM_values=CTERM_result_array[i]
                    var CTERM_startdate=CTERM_values.startdate;
                    CTERM_startdate=FormTableDateFormat(CTERM_startdate);
                    var CTERM_enddate=CTERM_values.enddate;
                    CTERM_enddate=FormTableDateFormat(CTERM_enddate);
                    var CTERM_preterminatedate=CTERM_values.preterminatedate;
                    if(CTERM_preterminatedate!=""){
                        CTERM_preterminatedate=FormTableDateFormat(CTERM_preterminatedate)
                    }
                    CTERM_table_header+='<tr><td>'+CTERM_values.unitno+'</td><td>'+CTERM_values.firstname+'</td><td>'+CTERM_values.lastname+'</td><td>'+CTERM_startdate+'</td><td nowrap>'+CTERM_enddate+'</td><td>'+CTERM_preterminatedate+'</td><td>'+CTERM_values.redver+'</td><td>'+CTERM_values.roomtype+'</td><td>'+CTERM_values.cardno+'</td><td>'+CTERM_values.guestcard+'</td><td>'+CTERM_values.preterm+'</td><td>'+CTERM_values.extension+'</td><td>'+CTERM_values.rechk+'</td><td>'+CTERM_values.term+'</td><td>'+CTERM_values.lp+'</td><td>'+CTERM_values.quartors+'</td><td>'+CTERM_values.rental+'</td><td>'+CTERM_values.comments+'</td><td>'+CTERM_values.userstamp+'</td><td>'+CTERM_values.timestamp+'</td></tr>';

                }
                CTERM_table_header+='</tbody></table>';
                $('section').html(CTERM_table_header);
                $('#CTERM_div_srctable').show();
                $('#CTERM_tbl_srctable').DataTable( {
                    "aaSorting": [],
                    "pageLength": 10,
                    "sPaginationType":"full_numbers"
                });
                if(CTERM_radio_termoption=="CTERM_radio_activecust")
                {
                    $('#CTERM_btn_srcbtn').val("SEARCH").removeClass("maxbtn").addClass("btn");
                }
                else if(CTERM_radio_termoption=="CTERM_radio_untermnonactive")
                {
                    $('#CTERM_btn_srcbtn').val("TERMINATE").removeClass("btn").addClass("maxbtn");
                }
                else
                {
                    $('#CTERM_btn_srcbtn').val("RE-ACTIVE").removeClass("btn").addClass("maxbtn");
                }
                $('#CTERM_div_srcbtn').show();
            }
            $(".preloader").hide();
        }
        //FUNCTION FOR ON CLICK OF CUST ID
        $(document).on("change",'.CTERM_class_custid', function ()
        {
            $(".preloader").show();
            $('#CTERM_div_errmsg').hide();
            $('#CTERM_div_srctable').hide();
            $('#CTERM_div_srcbtn').hide();
            $('#CTERM_div_termform').hide();
            CTERM_Show_srctable()
        });
//GET DETAILS OF SELECTED CUSTOMER ID
        function CTERM_Show_srctable()
        {
            var CTERM_lb_custname=$('#CTERM_lb_custname').val();
            var CTERM_radio_termoption=$("input[name=CTERM_radio_termoption]:checked").val();
            var CTERM_id=$("input[name=CTERM_radiocustid]:checked").val();
            $('#CTERM_hidden_custid').val(CTERM_id);
            $.ajax({
                type: "POST",
                url: controller_url+"CTERM_getCustomerdtls",
                data:{'custid':CTERM_id,'radiooption':CTERM_radio_termoption},
                success: function(res) {
                    $('.preloader').hide();
                    var result=JSON.parse(res);
                    CTERM_getCustomerdtls_result(result)
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        }
        //FUNCTION TO CALL SAVE FUNCTION
        $("#CTERM_btn_srcbtn").click(function()
        {
            $(".preloader").show();
            var CTERM_radio_termoption =$("input[name='CTERM_radio_termoption']:checked").val()
            if(CTERM_radio_termoption=="CTERM_radio_activecust")
            {
                CTERM_ShowTermForm()
            }
            else
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"CTERM_UpdatePtd",
                    data:$('#CTERM_form').serialize()+'&Globalrecver='+Globalrecver,
                    success: function(res) {
                        $('.preloader').hide();
                        CTERM_UpdatePtd_result(res)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
            }
        });
        //SET VALUES IN FORM
        function CTERM_ShowTermForm()
        {
            $(".preloader").show();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            var CTERM_radio_termoption =$("input[name='CTERM_radio_termoption']:checked").val()
            if(CTERM_radio_termoption=="CTERM_radio_activecust")
            {
//SET ROW ID
                var rowid=$('#CTERM_tbl_srctable tr:eq(0)');
                var len=$('#CTERM_tbl_srctable tr').length;
                var CTERM_unitno,CTERM_custfname,CTERM_custlname,CTERM_chkindate,CTERM_chkoutdate,CTERM_ptdd;
                var cterm_unitno=[];
                var cterm_stdate=[];
                var cterm_eddate=[];
                var cterm_stdate1=[];
                var cterm_eddate1=[];
                var cterm_ptdd=[];
                var cterm_rv=[];
                var cterm_rv1=[];
                var CTERM_cardnos=[];
                var ctermgstcard=[];
                var CTERM_comts="";
                var ctermrv="";
                var CTERM_gstcard="";
                var CTERM_card="";
//GET UNITNO ,CUSTOMER NAME,INITIAL CHECK IN DATE
                $('#CTERM_tbl_srctable tr').not(':first').each(function () {
                    var $tds = $(this).find('td');
                    CTERM_unitno = $tds.eq(0).text();
                    CTERM_custfname = $tds.eq(1).text();
                    CTERM_custlname = $tds.eq(2).text();
                    CTERM_chkindate=$tds.eq(3).text();
                    CTERM_comts=$tds.eq(17).text();
                    CTERM_card=$tds.eq(8).text();
                    CTERM_chkoutdate=$tds.eq(4).text();
                    CTERM_gstcard=$tds.eq(9).text();
                    CTERM_ptdd=$tds.eq(5).text();
                    ctermrv=$tds.eq(6).text();
                    $('#CTERM_ta_comments').height(116);
                    $('#CTERM_ta_comments').val(CTERM_comts);//set comments
                    ctermgstcard.push(CTERM_gstcard);
                    if(CTERM_unitno!=""&&CTERM_gstcard=="")
                    {
                        cterm_unitno.push(CTERM_unitno)
                    }
                    cterm_stdate1.push(CTERM_chkindate)
                    cterm_eddate1.push(CTERM_chkoutdate)
                    if(CTERM_chkindate!=""&&CTERM_gstcard=="")
                    {
                        cterm_stdate.push(CTERM_chkindate)
                    }
                    if(CTERM_chkoutdate!=""&&CTERM_gstcard=="")
                    {
                        cterm_eddate.push(CTERM_chkoutdate)
                    }
                    if(CTERM_ptdd!=undefined)
                    {
                        cterm_ptdd.push(CTERM_ptdd)
                    }
                    if(ctermrv!="")
                    {
                        cterm_rv.push(ctermrv)
                    }
                    CTERM_cardnos.push(CTERM_card);
                });
                cterm_rv1=unique( cterm_rv );
                $('#CTERM_tble_termfrm tr').remove();
                var CTERM_cards="";
                var CTERM_cards1="";
                var CTERM_table="";
                CTERM_table='<tr ><th></th><th>UNIT NO</th><th>LEASE PERIOD</th><th >NAME</th><th>START DATE</th><th>END DATE</th></tr>'
                $('#CTERM_tble_termfrm').append(CTERM_table);
                for(var i=0;i<cterm_rv1.length;i++)
                {
                    var c=0;
                    var CTERM_th_cname="CTERM_th_cname"+i;
                    var CTERM_rvchkindate="CTERM_rvchkindate"+cterm_rv1[i];
                    var CTERM_rvchkoutdate="CTERM_rvchkoutdate"+cterm_rv1[i];
                    CTERM_table='<tr ><td><input type="radio" name="CTERM_unitno" class="CTERM_validate_ptd CTERM_getminptdd" id='+i+' value='+cterm_rv1[i]+'></td><td>'+cterm_unitno[i]+'</td><td><label name="CTERM_recver" style="width:30px" >'+cterm_rv1[i]+'</label></td><td id='+CTERM_th_cname+'>'+CTERM_custfname+" "+CTERM_custlname+'</td><td><label id='+CTERM_rvchkindate+' style="width:100px" > '+cterm_stdate[i]+'</label></td><td><label id='+CTERM_rvchkoutdate+' style="width:100px" >'+cterm_eddate[i]+'</label ></td></tr>'
                    $('#CTERM_tble_termfrm').append(CTERM_table);
                    for (var j=0;j<CTERM_cardnos.length;j++)
                    {
                        if(cterm_rv1[i]==cterm_rv[j])
                        {
                            if(ctermgstcard[j]=="")
                            {
                                var CTERM_cardrow="CTERM_cardrow"+cterm_rv1[i]+c;
                                var CTERM_hidden_sdate="CTERM_hidden_sdate"+i+"chk"+c;
                                var CTERM_db_ptddate="CTERM_db_ptddate"+i+"chk"+c;
                                var CTERM_hidden_ptddate="CTERM_hidden_ptddate"+i+"chk"+c;
                                var CTERM_chkboxid=i+"chk"+c;
                                var CTERM_cb_cardnos="CTERM_cb_cardnos"+c
                                var CTERM_hidden_cardnos='CTERM_hidden_cardnos'+i+"chk"+c;
                                var CTERM_lb_ptdfrmtime="CTERM_lb_ptdfrmtime"+i+"chk"+c;
                                var CTERM_lb_ptdtotime="CTERM_lb_ptdtotime"+i+"chk"+c;
                                var cterm_ptderr="cterm_ptderr"+i+"chk"+c;
                                var cterm_totimelbl="cterm_totimelbl"+i+"chk"+c;
                                CTERM_cards=CTERM_custfname+" "+CTERM_custlname;
                                CTERM_cards1=CTERM_custfname+"_"+CTERM_custlname;
                                CTERM_cards1=CTERM_cards1.replace(/ /g,"_");
                                var CTERM_cardvalue=CTERM_cardnos[j]+"$"+CTERM_cards1;
                                if((new Date(FormTableDateFormat(cterm_stdate[i])).setHours(0,0,0,0)>=new Date(FormTableDateFormat(cterm_ptdd[j])).setHours(0,0,0,0))||new Date(FormTableDateFormat(cterm_eddate[i])).setHours(0,0,0,0)<new Date(FormTableDateFormat(cterm_ptdd[j])).setHours(0,0,0,0))
                                {
                                    cterm_ptdd[j]="";
                                }
                                CTERM_table='<tr id='+CTERM_cardrow+'   hidden><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" name="CTERM_hidden_cardnos" id='+CTERM_hidden_cardnos+' value='+CTERM_cardvalue+'><input type="checkbox" name="CTERM_cb_cardnos" id='+CTERM_chkboxid+' value='+CTERM_cardvalue+' class="CTERM_validate_ptd CTERM_getminptdd"></td><td>'+CTERM_cardnos[j]+'</td><td><td>'+CTERM_cards+'</td><td>'+cterm_stdate1[j]+'</td><td><input type=hidden name="CTERM_hidden_sdate" id='+CTERM_hidden_sdate+' value='+cterm_stdate1[j]+' class="CTERM_validate_ptd"  ><input type=text name="CTERM_db_ptddate" id='+CTERM_db_ptddate+' value="'+cterm_ptdd[j]+'" class="CTERM_validate_ptd CTERM_getminptdd datemandtry form-control" style="width:100px;" readonly><input type=text name="CTERM_hidden_ptddate" id='+CTERM_hidden_ptddate+' value="'+cterm_ptdd[j]+'" class="CTERM_validate_ptd form-control"  style="display:none;"><td><label id='+cterm_ptderr+' class="errormsg"></label></td><td style="padding-bottom:20px"><select id='+CTERM_lb_ptdfrmtime+' name="CTERM_lb_ptdfrmtime[]" class="CTERM_class_timelb CTERM_validate_ptd form-control" hidden style="width:100px"></select></td><td><label id='+cterm_totimelbl+' style="float:left;" hidden>TO</label></td><td style="padding-bottom:20px"><select id='+CTERM_lb_ptdtotime+' name="CTERM_lb_ptdtotime[]"  class="form-control" hidden style="width:100px"></select></td></tr>'

                                var CTERM_frmtime='<option>SELECT</option>';
                                for(var k=0;k<CTERM_ptdfrmtime.length;k++)
                                {
                                    CTERM_frmtime += '<option value="' + CTERM_ptdfrmtime[k] + '">' + CTERM_ptdfrmtime[k] + '</option>';
                                }
                            }
                            else
                            {
                                c=c+1;
                                var CTERM_cardrow="CTERM_cardrow"+cterm_rv1[i]+c;
                                var CTERM_hidden_sdate="CTERM_hidden_sdate"+i+"chk"+c;
                                var CTERM_db_ptddate="CTERM_db_ptddate"+i+"chk"+c;
                                var CTERM_hidden_ptddate="CTERM_hidden_ptddate"+i+"chk"+c;
                                var CTERM_chkboxid=i+"chk"+c;
                                var CTERM_cb_cardnos="CTERM_cb_cardnos"+c
                                var CTERM_hidden_cardnos='CTERM_hidden_cardnos'+i+"chk"+c;
                                var CTERM_lb_ptdfrmtime="CTERM_lb_ptdfrmtime"+i+"chk"+c;
                                var CTERM_lb_ptdtotime="CTERM_lb_ptdtotime"+i+"chk"+c;
                                var cterm_ptderr="cterm_ptderr"+i+"chk"+c;
                                CTERM_cards="GUEST "+c;
                                var CTERM_cardvalue=CTERM_cardnos[j]+"$"+CTERM_cards;
                                if((new Date(FormTableDateFormat(cterm_stdate[i])).setHours(0,0,0,0)>=new Date(FormTableDateFormat(cterm_ptdd[j])).setHours(0,0,0,0))||new Date(FormTableDateFormat(cterm_eddate[i])).setHours(0,0,0,0)<new Date(FormTableDateFormat(cterm_ptdd[j])).setHours(0,0,0,0))
                                {
                                    cterm_ptdd[j]="";
                                }
                                    CTERM_table='<tr id='+CTERM_cardrow+'   hidden><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" name="CTERM_hidden_cardnos" id='+CTERM_hidden_cardnos+' value='+CTERM_cardvalue+'><input type="checkbox" name="CTERM_cb_cardnos" id='+CTERM_chkboxid+' value='+CTERM_cardvalue+' class="CTERM_validate_ptd CTERM_getminptdd"></td><td>'+CTERM_cardnos[j]+'</td><td><td>'+CTERM_cards+'</td><td>'+cterm_stdate1[j]+'</td><td><input type="hidden" name="CTERM_hidden_sdate" id='+CTERM_hidden_sdate+' value='+cterm_stdate1[j]+' class="CTERM_validate_ptd"  ><input type=text name="CTERM_db_ptddate" id='+CTERM_db_ptddate+' value="'+cterm_ptdd[j]+'" class="CTERM_validate_ptd CTERM_getminptdd datemandtry form-control" style="width:100px;" readonly><input type=text name="CTERM_hidden_ptddate" id='+CTERM_hidden_ptddate+' value="'+cterm_ptdd[j]+'" class="CTERM_validate_ptd form-control"  style="display:none;"><td><label id='+cterm_ptderr+' class="errormsg"></label></tr>'
                            }
                            $('#CTERM_tble_termfrm').append(CTERM_table);
                            $('#CTERM_lb_ptdfrmtime'+i+"chk"+c).html(CTERM_frmtime);
                        }
                    }
                }
                $('#CTERM_div_termform').show();
            }
            $('#CTERM_btn_termbtn').attr("disabled","disabled");
            $(".preloader").hide();
        }
//FUNCTION TO VALIDATE PTD
        function setPtdMinMaxDate(CTERM_unitno,chkid,CTERM_ptd,CTERM_allrv,CTERM_selectrv,CTERM_validatebtn)
        {
            if(CTERM_allrv!=undefined)
            {
                CTERM_allrv.sort(function(a,b){return a-b});
            }
            var data=chkid.split("chk");//to chk customer check box
            var chkhiddenptd=$("#CTERM_hidden_ptddate"+chkid).val();
            var custptd=$("#CTERM_hidden_custptd").val()
//SET MIN DATE AS CHECK IN DATE
            var CTERM_chkindate= $('#CTERM_rvchkindate'+CTERM_unitno).text();
            var CTERM_min_ptdsdate=CTERM_chkindate;
            var chkptdflag=0;
            if(CTERM_minptdcustdate!="" &&(data[1]==0))//get max ptd if any guest fully ptd before cust
            {
                if(new Date(FormTableDateFormat(CTERM_minptdcustdate)).setHours(0,0,0,0)>new Date(FormTableDateFormat(CTERM_min_ptdsdate)).setHours(0,0,0,0))
                {
                    chkptdflag=1;
                    CTERM_min_ptdsdate=CTERM_minptdcustdate;
                }
            }
            var CTERM_ptdmindate = new Date( Date.parse(FormTableDateFormat(CTERM_min_ptdsdate) ) );
            if(chkptdflag==1)
            {
                CTERM_ptdmindate.setDate( CTERM_ptdmindate.getDate());
            }
            else
            {
                CTERM_ptdmindate.setDate( CTERM_ptdmindate.getDate() + 1 );
            }
            var CTERM_ptdmindate = CTERM_ptdmindate.toDateString();
            CTERM_ptdmindate = new Date( Date.parse( CTERM_ptdmindate ) );
            $("#CTERM_db_ptddate"+chkid).datepicker("option","minDate",CTERM_ptdmindate);
//SET MAX DATE AS CHECK OUT DATE
            var CTERM_chkoutdate= $('#CTERM_rvchkoutdate'+CTERM_unitno).text();
            if(chkhiddenptd!="")
            {
                CTERM_chkoutdate=chkhiddenptd;
            }
            var flag=0;//to chk last ptd n cust ptd is empty
            var flag1=0;//to chk last ptd n cust ptd not empty
            var equalflag=0;//to chk last ptd is empty or not
            if(chkhiddenptd==""&&custptd=="")
            {
                CTERM_chkoutdate=CTERM_chkoutdate;
                flag=1;
                equalflag=1
            }
            else if(chkhiddenptd==""&&custptd!="")
            {
                var CTERM_chkoutdate1=custptd;
                flag1=1;
                if(data[1]==0)
                {
                    equalflag=1
                }
            }
            else if(chkhiddenptd!=""&&custptd=="")
            {
                var CTERM_chkoutdate1=chkhiddenptd;
                flag=1;
            }
            else if(chkhiddenptd!=""&&custptd!="")
            {
                if(new Date(FormTableDateFormat(custptd)).setHours(0,0,0,0)<new Date(FormTableDateFormat(chkhiddenptd)).setHours(0,0,0,0))
                {
                    var CTERM_chkoutdate1=custptd;
                    flag1=1;
                }
                else
                {
                    flag=1;
                    var CTERM_chkoutdate1=chkhiddenptd;
                }
            }
            if(equalflag==1)
            {
                var CTERM_ptdmaxdate = new Date( Date.parse(FormTableDateFormat(CTERM_chkoutdate) ) );
                if(CTERM_allrv!=undefined&&CTERM_allrv[CTERM_allrv.length-1]==CTERM_selectrv)
                {
                    CTERM_ptdmaxdate.setDate( CTERM_ptdmaxdate.getDate() - 1 );
                }
                else
                {
                    CTERM_ptdmaxdate.setDate( CTERM_ptdmaxdate.getDate());
                }
            }
            else
            {
                if(flag==1)
                {
                    var CTERM_ptdmaxdate = new Date( Date.parse(FormTableDateFormat(CTERM_chkoutdate) ) );
                    CTERM_ptdmaxdate.setDate( CTERM_ptdmaxdate.getDate() - 1 );
                }
                else if(flag1==1)
                {
                    if(data[1]!=0)
                    {
                        var CTERM_ptdmaxdate = new Date( Date.parse(FormTableDateFormat(CTERM_chkoutdate1) ) );
                        CTERM_ptdmaxdate.setDate( CTERM_ptdmaxdate.getDate());
                    }
                    else
                    {
                        var CTERM_ptdmaxdate = new Date( Date.parse(FormTableDateFormat(CTERM_chkoutdate) ) );
                        CTERM_ptdmaxdate.setDate( CTERM_ptdmaxdate.getDate() - 1 );
                    }
                }
            }
            if(new Date(CTERM_ptdmaxdate).setHours(0,0,0,0)<=new Date(FormTableDateFormat(CTERM_chkindate)).setHours(0,0,0,0))
            {
                $("#CTERM_db_ptddate"+chkid).val("")
            }
            var CTERM_ptdmaxdate = CTERM_ptdmaxdate.toDateString();
            CTERM_ptdmaxdate = new Date( Date.parse( CTERM_ptdmaxdate ) );
            $("#CTERM_db_ptddate"+chkid).datepicker("option","maxDate",CTERM_ptdmaxdate);
            var ctermerrr="PRETERMINATE DATE SHOULD GREATER THAN [SDATE] AND LESS THAN [EDATE] "
            ctermerrr=ctermerrr.replace("[SDATE]",CTERM_min_ptdsdate)
            ctermerrr=ctermerrr.replace("[EDATE]",CTERM_chkoutdate)
            if(new Date($("#CTERM_db_ptddate"+chkid).datepicker("option","minDate"))>new Date($("#CTERM_db_ptddate"+chkid).datepicker("option","maxDate")))
            {
                $("#CTERM_db_ptddate"+chkid).val(chkhiddenptd).addClass('invalid')
                $("#CTERM_db_ptddate"+chkid).prop("readonly",true).addClass("rdonly");
                $("#"+chkid).prop("disabled",true)
                $("#cterm_ptderr"+chkid).text(ctermerrr)
                CTERM_validatebtn=0;
                $('#CTERM_btn_termbtn').attr("disabled","disabled");
                $('#CTERM_lb_ptdfrmtime'+chkid).val("SELECT").hide();
                $('#CTERM_lb_ptdtotime'+chkid+'option').eq(0).before('<option value="SELECT">SELECT</option>')
                $('#CTERM_lb_ptdtotime'+chkid+'option').val('SELECT').hide();
            }
            else
            {
                $("#CTERM_db_ptddate"+chkid).removeClass('invalid')
                $("#cterm_ptderr"+chkid).text("")
            }
        }
//FUNCTION TO GET MIN PTD FOR A CUST IF GST PTD <=SYSDATE
        $(document).on("change",'.CTERM_getminptdd', function ()
        {
            $(".preloader").show();
            var CTERM_radio_termoption=$("input[name=CTERM_radio_termoption]:checked").val();
            var CTERM_custid=$('#CTERM_hidden_custid').val();
            var CTERM_unitno =$("input[name='CTERM_unitno']:checked").val();
            $.ajax({
                type: "POST",
                url: controller_url+"CTERM_getMinPTD",
                data:{'CTERM_custid':CTERM_custid,'CTERM_radio_termoption':CTERM_radio_termoption,'CTERM_unitno':CTERM_unitno},
                success: function(res) {
                    $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getMinPTD_result(result)
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
        });
        //FUNCTION TO SET MIN PTD FOR A CUST
        function CTERM_getMinPTD_result(CTERM_minptd)
        {
            CTERM_minptdcustdate=CTERM_minptd.cterm_mincustptd;
            CTERM_custptdchkflag=CTERM_minptd.cterm_custptdchk;
            $(".preloader").hide();
        }
//FUNCTION TO GET CALENDAR TO TIME
        $(document).on("change",'.CTERM_class_timelb', function ()
        {
            var CTERM_cardid=[];
//GET THE VALUES OF CHECK BOX CHECKED
            $('input:checkbox[name=CTERM_cb_cardnos]:checked').each(function() {
                if ($(this).val()) {
                    var id=$(this).attr("id");
                    CTERM_cardid.push(id);
                }
            });
            for(var i=0;i<CTERM_cardid.length;i++)
            {
                var chkid=CTERM_cardid[i];
                var data=chkid.split("chk");
                var CTERM_lb_ptdfrmtime=$('#CTERM_lb_ptdfrmtime'+chkid).val();
                if(data[1]==0)
                {
                    if(CTERM_lb_ptdfrmtime!="SELECT"&&CTERM_lb_ptdfrmtime!=undefined)
                    {
                        $(".preloader").show();
                        var cterm_ptdtotime=CTERM_startendtimevalues(CTERM_lb_ptdfrmtime)
                        for(var i=0;i<CTERM_cardid.length;i++)
                        {
                            var chkid=CTERM_cardid[i];
                            var CTERM_totime="";
                            for(var k=0;k<cterm_ptdtotime.length;k++)
                            {
                                CTERM_totime += '<option value="' + cterm_ptdtotime[k] + '">' + cterm_ptdtotime[k] + '</option>';
                            }
                            $('#cterm_totimelbl'+chkid).show()
                            $('#CTERM_lb_ptdtotime'+chkid).html(CTERM_totime).show();
                        }
                        $(".preloader").hide();
                    }
                }
            }
        });
//FUNCTION TO CALENDER END TIME
        function CTERM_startendtimevalues(endtime)
        {
            var timearray=[];
            for(var i=0;i<CTERM_ptdfrmtime.length;i++)
            {
                if(endtime==CTERM_ptdfrmtime[i])
                {
                    var endtime_status=i;
                    break;
                }
            }
            if(endtime=="23:30")
            {
                timearray.push("23:59");
            }
            else if(endtime=="23:00")
            {
                timearray.push("23:30");
                timearray.push("23:59");
            }
            else
            {
                var length=endtime_status+2;
                for(var j=endtime_status+1;j<=length;j++)
                {
                    timearray.push(CTERM_ptdfrmtime[j]);
                }
            }
            return timearray;
        }
        //FUNCTION TO VALIDATE FORM
        $(document).on("change",'.CTERM_validate_ptd', function ()
        {
            var CTERM_radio_termoption=$("input[name=CTERM_radio_termoption]:checked").val();
            var CTERM_custid=$('#CTERM_hidden_custid').val();
            var CTERM_allrv=[];
            var CTERM_validatebtn=1;
            var CTERM_chkcardselect=0;
            var CTERM_unchkradio=[];
            var CTERM_chkrowid=[];
            var CTERM_unitno =$("input[name='CTERM_unitno']:checked").val();
            CTERM_allrv.push(CTERM_unitno)
            var CTERM_custidrv=$('#CTERM_hidden_custid').val();
            CTERM_custidrv=CTERM_custidrv.split("@")[0]+"@"+CTERM_unitno;
            $('#CTERM_hidden_custid').val(CTERM_custidrv);
            var CTERM_radioid=$("input[name='CTERM_unitno']:checked").attr("id");
            if($('#CTERM_th_cname'+CTERM_radioid).text()!="")
            {
                var custname=$('#CTERM_th_cname'+CTERM_radioid).text()
            }
            $('#CTERM_th_cname'+CTERM_radioid).text("")
            $('#CTERM_th_cname'+CTERM_radioid).text("")
            var srctablelength=$('#CTERM_tbl_srctable tr').length;
            var formtablelength=$('#CTERM_tble_termfrm tr').length;
            $(("input[name='CTERM_unitno']:not(:checked)")).each(function(){
                if ($(this).val()) {
                    var id1=$(this).attr("id");
                    CTERM_chkrowid.push(id1)
                }
            });
            for(var i=0;i<formtablelength;i++)
            {
                for(var k=0;k<CTERM_chkrowid.length;k++)
                {
                    $('#CTERM_th_cname'+CTERM_chkrowid[k]).text(custname)
                    var rowid=CTERM_chkrowid[k]+"chk"+i;
                    $('#CTERM_lb_ptdfromtime'+rowid).hide();
                    $('#cterm_totimelbl'+rowid).hide()
                    $('#CTERM_lb_ptdtotime'+rowid).hide();
                    $("#"+rowid).prop("checked",false);
                }
            }
            var CTERMrvchek=$("input:radio[name=CTERM_unitno]").is(':checked')//get unitno radio checked
            if(CTERMrvchek==false)
            {
                CTERM_validatebtn=0;
            }
            var CTERM_unitno1 =$("input[name='CTERM_unitno']:not(:checked)").val();//get unitno radio unchecked
            $("#CTERM_cardrow"+CTERM_unitno).show();
//get unitno radio unchecked
            $(("input[name='CTERM_unitno']:not(:checked)")).each(function(){
                CTERM_allrv.push($(this).val())
                CTERM_unchkradio.push($(this).val());
            });
            var CTERM_fullcardid=[];
            var CTERM_cardid=[];
            var CTERM_cardid1=[];
//GET THE VALUES OF CHECK BOX CHECKED
            $('input:checkbox[name=CTERM_cb_cardnos]:checked').each(function() {
                if ($(this).val()) {
                    var id=$(this).attr("id");
                    CTERM_cardid.push(id);
                    CTERM_fullcardid.push(id);
                }
            });
//GET THE VALUES OF CHECK BOX UNCHECKED
            $('input:checkbox[name=CTERM_cb_cardnos]:not(:checked)').each(function() {
                if ($(this).val()) {
                    var id1=$(this).attr("id");
                    CTERM_cardid1.push(id1);
                    CTERM_fullcardid.push(id1);
                }
            });
            var CTERM_chkcustflag=0;
            var CTERM_chkcustptdflag=0;
            var CTERM_chkgstdateflag=0;
            var CTERM_chkptdfromtime=[];
            var CTERM_chkptdtotime=[]
//SET PTD DATE ENABLE,DATE PICKER FOR THE CHECK BOX CHECKED
            CTERM_chkedcards()
//FUNCTION TO CHK CHECKED CHECKBOX N TO SET DATE PICKER N ENABLE PTD DATEBOX TO GIVE INPUT
            function CTERM_chkedcards()
            {
                var CTERM_finalcardnos=[];
                var CTERM_gstchkflag=0;
                for(var i=0;i<CTERM_cardid.length;i++)
                {
                    CTERM_chkcardselect=1;
                    var chkid=CTERM_cardid[i];
                    var data=chkid.split("chk");
                    $("#CTERM_db_ptddate"+chkid).prop("readonly",false).removeClass("rdonly");
//SET DATEPICKER
                    $("#CTERM_db_ptddate"+chkid).datepicker({
                        dateFormat: "dd-mm-yy" ,
                        changeYear: true,
                        changeMonth: true
                    });
                    var chkboxval=$("#"+chkid).val();
                    var CTERM_ptd=$("#CTERM_db_ptddate"+chkid).val();
                    if(data[1]==0)
                    {
                        CTERM_chkcustflag=1;
                        if(CTERM_ptd!="")
                        {
                            CTERM_chkcustptdflag=1;
                            $('#CTERM_lb_ptdfrmtime'+chkid).show();
                        }
                        if(CTERM_ptd=="")
                        {
                            $('#CTERM_lb_ptdfrmtime'+chkid).val("SELECT").hide();
                            $('#CTERM_lb_ptdtotime'+chkid+'option').eq(0).before('<option value="SELECT">SELECT</option>')
                            $('#CTERM_lb_ptdtotime'+chkid+'option').val('SELECT').hide();
                            $('#cterm_totimelbl'+chkid).hide()
                        }
                    }
                    else
                    {
                        CTERM_gstchkflag=1;
                    }
                    setPtdMinMaxDate(CTERM_unitno,chkid,CTERM_ptd,CTERM_allrv,CTERM_unitno,CTERM_validatebtn);//function to set ptd min max date
                    if(CTERM_ptd=="")
                    {
                        CTERM_validatebtn=0;
                    }
                    else
                    {
                        var chkboxval=(chkboxval).split("@")[0]+"@"+CTERM_ptd;
                        $("#"+chkid).val(chkboxval);
                        CTERM_finalcardnos.push(chkboxval)
                    }
                    $("#CTERM_cardrow"+CTERM_unitno+data[1]).show();
                    var CTERM_lb_ptdfrmtime=$('#CTERM_lb_ptdfrmtime'+chkid).val();
                    var CTERM_lb_ptdtotime=$('#CTERM_lb_ptdtotime'+chkid).val();
                    if(data[1]==0)
                    {
                        if(CTERM_lb_ptdfrmtime=="SELECT"||CTERM_lb_ptdfrmtime==undefined)
                        {
                            CTERM_validatebtn=0;
                            $('#CTERM_lb_ptdtotime'+chkid).hide();
                            $('#cterm_totimelbl'+chkid).hide()
                        }
                        else
                        {
                            if(CTERM_lb_ptdfrmtime!="SELECT"&&CTERM_lb_ptdtotime!=undefined)
                            {
                                CTERM_chkptdfromtime.push(CTERM_lb_ptdfrmtime)
                                CTERM_chkptdtotime.push(CTERM_lb_ptdtotime)
                            }
                        }
                    }
                }
//if cust ptd is empty while clicking gst checkbox n cust ptd<=startdate -cust check box ll be automatically chked to avoid issue cut ptd before the gst
//eg:rv1 cust ptd:1/2 n gst also same n in rv2 same ptd ll be updated n while giving ptd in rv2 for gst cust ll be empty so gst ll not released when cust ptd
                if(CTERM_custptdchkflag==true&&CTERM_gstchkflag==1)
                {
                    $("#"+data[0]+"chk0").prop('checked',true);
                    $("#"+data[0]+"chk0").attr('disabled',true);
                }
                $("#CTERM_hidden_finalcards").val(CTERM_finalcardnos)
            }
            CTERM_chkallchkboxcard();
//FUNCTION TO SET DATE OR CHK CHECKBOX IF CUST IS PTD N GST > CUST PTD
            function CTERM_chkallchkboxcard()
            {
                for(var kk=0;kk<CTERM_fullcardid.length;kk++)
                {
                    var CTERM_srv=CTERM_fullcardid[kk].split("chk");
                    if(CTERM_srv[0]==CTERM_radioid)
                    {
                        var chkhiddenptd=$("#CTERM_hidden_ptddate"+CTERM_fullcardid[kk]).val();
                        var chkptd=$("#CTERM_db_ptddate"+CTERM_fullcardid[kk]).val();
                        var cptd=chkhiddenptd;
                        if(CTERM_chkcustflag==1)
                        {
                            for(var kl=0;kl<CTERM_cardid.length;kl++)
                            {
                                var CTERM_srv1=CTERM_cardid[kl].split("chk");
                                var chkptd1=$("#CTERM_db_ptddate"+CTERM_cardid[kl]).val();
                                if(CTERM_srv1[1]==0)
                                {
                                    var custptd=chkptd1;
                                    $("#CTERM_hidden_custptd").val(custptd);
                                }
                            }
//chek date
                            if($("#CTERM_hidden_custptd").val()!=""&&(chkhiddenptd!=""||chkhiddenptd=="")&&CTERM_srv[1]!=0)
                            {
                                if(chkhiddenptd=="")
                                {
                                    chkhiddenptd=chkptd;
                                }
                                if(chkhiddenptd!="")
                                {
                                    if(new Date(FormTableDateFormat($("#CTERM_hidden_custptd").val())).setHours(0,0,0,0)<new Date(FormTableDateFormat(chkhiddenptd)).setHours(0,0,0,0))
                                    {
                                        CTERM_chkgstdateflag=1;
                                        $("#"+CTERM_fullcardid[kk]).prop("checked",true).attr("disabled",true);
                                    }
                                    if(new Date(FormTableDateFormat($("#CTERM_hidden_custptd").val())).setHours(0,0,0,0)<new Date(FormTableDateFormat(chkptd)).setHours(0,0,0,0))
                                    {
                                        $("#CTERM_db_ptddate"+CTERM_fullcardid[kk]).val(custptd);
                                    }
                                }
                            }
                            if(cptd!=""&&CTERM_chkgstdateflag==0) //if last ptd is not null n gst ptd !>cust ptd
                            {
                                $("#"+CTERM_fullcardid[kk]).attr("disabled",false);//enable checkbox
                            }
                            if(CTERM_srv[0]==CTERM_radioid)
                            {
                                if((chkhiddenptd==""&&CTERM_srv[1]!=0))//if cust checkbox selected n ptd is null
                                {
                                    $("#"+CTERM_fullcardid[kk]).prop("checked",true).attr("disabled",true);
                                }
                                if(CTERM_chkcustflag==0)
                                {
                                    $("#"+CTERM_fullcardid[kk]).attr("disabled",false);
                                }
                            }
                            if((chkptd==""&&CTERM_chkcustptdflag==1))
                            {
                                if(CTERM_srv[0]==CTERM_radioid)
                                {
                                    $("#CTERM_db_ptddate"+CTERM_fullcardid[kk]).val(custptd);
                                }
                            }
                        }
                        else
                        {
                            if(CTERM_chkcustflag==0)
                            {
                                $("#"+CTERM_fullcardid[kk]).attr("disabled",false);
                            }
                            if(CTERM_srv[1]==0&&chkhiddenptd=="")
                            {
                                $("#CTERM_hidden_custptd").val("")
                            }
                        }
                    }
                }
            }
//SET PTD DATE DISABLE,REMOVE DATE PICKER FOR THE CHECK BOX UNCHECKED
            for(var j=0;j<CTERM_cardid1.length;j++)
            {
                var unchkid=CTERM_cardid1[j];
                $("#CTERM_hidden_cardnos"+unchkid).val("");
                var CTERM_srv=unchkid.split("chk");
                var chkhiddenptd=$("#CTERM_hidden_ptddate"+unchkid).val();
                $("#CTERM_db_ptddate"+unchkid).val(chkhiddenptd)
                var chkptd=$("#CTERM_db_ptddate"+unchkid).val();
                var data=unchkid.split("chk");
                $("#CTERM_db_ptddate"+unchkid).prop("readonly",true).addClass("rdonly");
//REMOVE DATEPICKER
                $("#CTERM_db_ptddate"+unchkid).datepicker( "destroy" );
                $("#CTERM_cardrow"+CTERM_unitno+data[1]).show();
                $("#CTERM_comments"+CTERM_unitno).show();
                $('#CTERM_lb_ptdfrmtime'+unchkid).val("SELECT").hide();
                $('#CTERM_lb_ptdtotime'+unchkid).append("<option>SELECT</option>");
                $('#CTERM_lb_ptdtotime'+unchkid).val("SELECT").hide();
                $('#cterm_totimelbl'+unchkid).hide()
                for(var k=0;k<CTERM_unchkradio.length;k++)
                {
                    $("#CTERM_cardrow"+CTERM_unchkradio[k]+data[1]).hide();
                    $("#CTERM_comments"+CTERM_unchkradio[k]).hide();
                }
                for(var kl=0;kl<CTERM_cardid.length;kl++)
                {
                    var CTERM_srv1=CTERM_cardid[kl].split("chk");
                }
                if(CTERM_cardid.length>0)
                {
                    if(CTERM_srv[1]==0&&CTERM_srv1[0]==CTERM_srv[0])
                    {
                        $("#CTERM_hidden_custptd").val(chkptd);
                    }
                }
                $("#CTERM_db_ptddate"+unchkid).removeClass('invalid')
                $("#cterm_ptderr"+unchkid).text("")
            }
//VALIDATE ACTIVE CUSTOMER TERMINATE BUTTON START
            if(CTERM_validatebtn==0||CTERM_chkcardselect==0)
            {
                $('#CTERM_btn_termbtn').attr("disabled","disabled");
            }
            else
            {
                $('#CTERM_btn_termbtn').removeAttr("disabled");
            }
//VALIDATE ACTIVE CUSTOMER TERMINATE BUTTON END
            var CTERM_cardid=[];
            var CTERM_fullcardid=[];
//GET THE VALUES OF CHECK BOX CHECKED
            $('input:checkbox[name=CTERM_cb_cardnos]:checked').each(function() {
                if ($(this).val()) {
                    var id=$(this).attr("id");
                    CTERM_cardid.push(id);
                    CTERM_fullcardid.push(id);
                }
            });
            CTERM_chkedcards()
            CTERM_chkallchkboxcard();
        });
       //FUNCTION TO CALL SAVE FUNCTION
        $("#CTERM_btn_termbtn").click(function()
        {
            $(".preloader").show();
            $.ajax({
                type: "POST",
                url: controller_url+"CTERM_UpdatePtd",
                data:$('#CTERM_form').serialize()+'&Globalrecver='+Globalrecver,
                success: function(res) {

                    $('.preloader').hide();
                        CTERM_UpdatePtd_result(res)
                },
                error: function (data) {
                    alert('error in getting' + JSON.stringify(data));
                }
            });
       });
//FUNCTION TO CALL SAVE FUNCTION RESULT
        function CTERM_UpdatePtd_result(ctermresult)
        {
            var CTERM_radio_termoption =$("input[name='CTERM_radio_termoption']:checked").val()
            var sucessmsg=CTERM_errmsgs[1].EMC_DATA;
            if(CTERM_radio_termoption=="CTERM_radio_reactivecust")
            {
                sucessmsg=CTERM_errmsgs[5].EMC_DATA;
            }
            if(ctermresult==1)
            {
                $('#CTERM_div_errmsg').hide();
                $("#CTERM_div_srctable").hide();
                $("#CTERM_btn_termbtn").attr("disabled","disabled");
                $("#CTERM_div_srcbtn").hide();
                $("#CTERM_div_termform").hide();
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: controller_url+"CTERM_getCustomerName",
                    data:$('#CTERM_form').serialize(),
                    success: function(res) {
                        $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getCustomerName_result(result)
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                    }
                });
                show_msgbox("CUSTOMER TERMINATION",sucessmsg,"success",false);
            }
            else if(ctermresult==0)
            {
                $(".preloader").hide();
                show_msgbox("CUSTOMER TERMINATION",CTERM_errmsgs[6].EMC_DATA,"success",false);
            }
            else
            {
                $(".preloader").hide();
                show_msgbox("CUSTOMER TERMINATION",ctermresult,"success",false);
            }
        }
    });
</script>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/></div>
    <div class="title text-center"><h4><b>CUSTOMER TERMINATION</b></h4></div>
            <form class="content form-horizontal" name="CTERM_form" id="CTERM_form" hidden>
                <div class="panel-body">
                    <div style="padding-bottom: 15px">
                        <div class="radio">
                            <label><input type="radio" name="CTERM_radio_termoption" id="CTERM_radio_activecust" value="CTERM_radio_activecust">ACTIVE CUSTOMER</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="CTERM_radio_termoption" id="CTERM_radio_untermnonactive" value="CTERM_radio_untermnonactive">UNTERMINATED NON ACTIVE CUSTOMER</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="CTERM_radio_termoption" id="CTERM_radio_reactivecust" value="CTERM_radio_reactivecust">RE-ACTIVE CUSTOMER</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2" id="CTERM_lbl_custname" hidden>CUSTOMER NAME<em>*</em></label>
                        <div class="col-sm-5"><select id='CTERM_lb_custname' name='CTERM_lb_custname' class="form-control" style="display: none;">
                                <option>SELECT</option>
                            </select></div>
                    </div>
                    <div id="CTERM_div_custid" class="col-lg-offset-2">
                    </div>
                <div id="CTERM_div_errmsg"></div>
                <div id="CTERM_div_srctable" class="table-responsive" hidden>
                    <section></section>
                </div>
                <div id="CTERM_div_srcbtn"  hidden>
                    <input type="button" id="CTERM_btn_srcbtn" value="SEARCH" class="btn">
                </div>
                <div  id="CTERM_div_termform" hidden>
                    <div class="table-responsive">
                        <table id="CTERM_tble_termfrm">
                        </table>
                    </div>
                        <div class="form-group">
                          <label class="col-sm-2">COMMENTS</label>
                          <div class="col-sm-4  "><textarea name="CTERM_ta_comments" id="CTERM_ta_comments" class="form-control" maxlength="50"></textarea>
                           </div>
                        </div>
                        <div>
                            <input type="button" id="CTERM_btn_termbtn" value="TERMINATE" class="maxbtn" disabled>
                        </div>
                </div>
                <input type=hidden name="CTERM_hidden_custid" id="CTERM_hidden_custid" />
                <input type=hidden name="CTERM_hidden_custptd" id="CTERM_hidden_custptd" />
                <input type=hidden name="CTERM_hidden_finalcards" id="CTERM_hidden_finalcards" />
                </div>
            </form>

</div>
</body>