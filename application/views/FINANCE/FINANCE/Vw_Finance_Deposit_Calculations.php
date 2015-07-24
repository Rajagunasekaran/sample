<?php
require_once('application/libraries/EI_HDR.php');
//******************************************Deposit_Calculations********************************************//
//VER 0.03-SD:02/06/2015 ED:03/06/2015,moved to folder and changed filename eilib file name
//VER 0.02-SD:28/05/2015 ED:04/06/2015,did the ss part for deposit calculation and ss insert part
//VER 0.01-SD:25/05/2015 ED:26/05/2015,completed form design and validation without ss part
//*******************************************************************************************************//
?>
<html>
<head>
    <style>
        .errpadding{
            padding-top: 10px;
        }
    </style>
    <script type="text/javascript">
    // document ready function
        $(document).ready(function(){
            var ctrl_DDCalculation_url="<?php echo site_url('FINANCE/FINANCE/Ctrl_Finance_Deposit_Calculations'); ?>";
            $('#spacewidth').height('0%');
            $('#DDC_btn_rbutton').hide();
            $('#DDC_btn_sbutton').hide();
            $('#DDC_customerselect').hide();
            var DDC_errorAarray=[];
            var DDC_unique_unitno=[];
            var DDC_unique_customer=[];
            var DDC_allunit=[];
            var DDC_recver=1;
        // initial data
            $.ajax({
                type: "POST",
                url: ctrl_DDCalculation_url+'/Initialdata',
                success: function(data) {
                    var initial_values=JSON.parse(data);
                    DDC_loadunitlistbox(initial_values);
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("DEPOSIT DEDUCTION CALCULATIONS",errordata,'error',false);
                    $('.preloader').hide();
                }
            });
        // FUNCTION TO UNIQUE FOR CUSTOMER NAME
            function DDC_unique(a) {
                var result = [];
                $.each(a, function(i, e) {
                    if ($.inArray(e, result) == -1) result.push(e);
                });
                return result;
            }
        // FUNCTION TO CONVERT DATE FORMAT
            function FormTableDateFormat(inputdate){
                var string = inputdate.split("-");
                return string[2]+'-'+ string[1]+'-'+string[0];
            }
        // FUNCTION FOR CALCULATION
            $("#DDC_btn_sbutton").click(function(){
                $(".preloader").show();
                var formelement=$('#DD_calculationform').serialize();
                $.ajax({
                    type: "POST",
                    url: ctrl_DDCalculation_url+'/DDC_Dep_Cal_submit',
                    data: formelement,
                    success: function(calcdata) {
                        var calc_values=JSON.parse(calcdata);
                        DDC_conformationmsg(calc_values);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("DEPOSIT DEDUCTION CALCULATIONS",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            });
            function DDC_conformationmsg(DDC_conformationmsgvalue)
            {
                $(".preloader").hide();
                if(DDC_conformationmsgvalue[0]=='DDC_flag_nosheet'){
                    var DDC_errorAarray_ss=DDC_errorAarray[17].EMC_DATA.replace('[SS]', DDC_conformationmsgvalue[1]);
                    show_msgbox("DEPOSIT DEDUCTION CALCULATIONS",DDC_errorAarray_ss,'error',false);
                }
                else if(DDC_conformationmsgvalue[0]=='Get_access'){
                    show_msgbox("DEPOSIT DEDUCTION CALCULATIONS",DDC_errorAarray[18].EMC_DATA,'error',false);
                }
                else{
                    if((DDC_conformationmsgvalue[0]==0)){
                        if(DDC_conformationmsgvalue[0]==0) {
                            show_msgbox("DEPOSIT DEDUCTION CALCULATIONS", DDC_errorAarray[15].EMC_DATA, 'error', false);
                        }
                    }
                    else{
                        $("#DDC_btn_sbutton").hide();
                        $("#DDC_btn_rbutton").hide();
                        $('#DDC_radiotable').hide();
                        DDC_allunit=DDC_conformationmsgvalue[0].DDC_unit_array;
                        var DDC_lb_unitselectvalue=$('#DDC_lb_unitselect').val();
                        var currentYear = (new Date).getFullYear();
                        var DDC_INPUT_CONFSAVEMSG = DDC_errorAarray[13].EMC_DATA.replace('[PROFILE]', DDC_lb_unitselectvalue);
                        var DDC_INPUT_CONFSAVEMSGval = DDC_INPUT_CONFSAVEMSG.replace('[YEAR]', currentYear);
                        show_msgbox("DEPOSIT DEDUCTION CALCULATIONS",DDC_INPUT_CONFSAVEMSGval,'success',false);
                        $('#DDC_hide').hide();
                        $('#DDC_recvertable >div').remove();
                        $('#DDC_recvertable').hide();
                        $('#DDC_customerselect').hide();
                        $('#DDC_btn_sbutton').attr("disabled", "disabled");
                        $("#DDC_lb_unitselect").val('SELECT');
                        DDC_loadunitlistbox(DDC_conformationmsgvalue)
                    }
                }
            }
        // LOAD THE UNIT NUMBER IN THE LISTBOX
            function DDC_loadunitlistbox(DDC_loadunitlistboxvalues)
            {
                DDC_allunit=DDC_loadunitlistboxvalues[0].DDC_unit_array;
                DDC_errorAarray=DDC_loadunitlistboxvalues[0].DDC_errorAarray;
                if(((DDC_loadunitlistboxvalues[0].DDC_cusentryarray).length!=0)&&((DDC_loadunitlistboxvalues[0].DDC_customertrmdtlarray).length!=0)&&((DDC_loadunitlistboxvalues[0].DDC_customerarray).length!=0)&&((DDC_loadunitlistboxvalues[0].DDC_expunitarray).length!=0)&&((DDC_loadunitlistboxvalues[0].DDC_paymentarray).length!=0)&&((DDC_loadunitlistboxvalues[0].DDC_unitarray).length!=0))
                {
                    $('#DD_calculationform').show();
                    if(DDC_allunit.length==0)
                    {
                        $('#DDC_errmsgdata').text(DDC_errorAarray[14].EMC_DATA).show();
                    }
                    else
                    {
                        $("#errorpanel").hide();
                        $('#DDC_table_errormsg >div').remove().hide();
                        var DDC_arr_allunit=[];
                        for(var k=0;k<DDC_allunit.length;k++)
                        {
                            DDC_arr_allunit[k]=DDC_allunit[k].DDC_unitno;
                        }
                        DDC_unique_unitno=DDC_unique(DDC_arr_allunit);
                        DDC_unique_unitno=DDC_unique_unitno.sort();
                        var DDC_unitvalue ='<option>SELECT</option>';
                        for(var i=0;i<DDC_unique_unitno.length;i++)
                        {
                            DDC_unitvalue += '<option value="' + DDC_unique_unitno[i] + '">' + DDC_unique_unitno[i] + '</option>';
                        }
                        $('#DDC_lb_unitselect').html(DDC_unitvalue).show();
                        $('#DDC_unitno').show();
                        $('#DDC_lb_unitselect').focus();
                    }
                }
                else
                {
                    if((DDC_loadunitlistboxvalues[0].DDC_cusentryarray).length==0)
                    {
                        $('#DD_calculationform').hide();
                        var uniterrormsg='<p><label class="errormsg">' +DDC_errorAarray[8].EMC_DATA + '</label></p>';
                        $('#DDC_table_errormsg').append(uniterrormsg).show();
                    }
                    if((DDC_loadunitlistboxvalues[0].DDC_customertrmdtlarray).length==0)
                    {
                        $('#DD_calculationform').hide();
                        var uniterrormsg='<p><label class="errormsg">' +DDC_errorAarray[9].EMC_DATA + '</label></p>';
                        $('#DDC_table_errormsg').append(uniterrormsg).show();
                    }
                    if((DDC_loadunitlistboxvalues[0].DDC_customerarray).length==0)
                    {
                        $('#DD_calculationform').hide();
                        var uniterrormsg='<p><label class="errormsg">' +DDC_errorAarray[5].EMC_DATA + '</label></p>';
                        $('#DDC_table_errormsg').append(uniterrormsg).show();
                    }
                    if((DDC_loadunitlistboxvalues[0].DDC_expunitarray).length==0)
                    {
                        $('#DD_calculationform').hide();
                        var uniterrormsg='<p><label class="errormsg">' +DDC_errorAarray[4].EMC_DATA + '</label></p>';
                        $('#DDC_table_errormsg').append(uniterrormsg).show();
                    }
                    if((DDC_loadunitlistboxvalues[0].DDC_paymentarray).length==0)
                    {
                        $('#DD_calculationform').hide();
                        var uniterrormsg='<p><label class="errormsg">' +DDC_errorAarray[11].EMC_DATA + '</label></p>';
                        $('#DDC_table_errormsg').append(uniterrormsg).show();
                    }
                    if((DDC_loadunitlistboxvalues[0].DDC_unitarray).length==0)
                    {
                        $('#DD_calculationform').hide();
                        var uniterrormsg='<p><label class="errormsg">' +DDC_errorAarray[0].EMC_DATA + '</label></p>';
                        $('#DDC_table_errormsg').append(uniterrormsg).show();
                    }
                    $("#errorpanel").show();
                }
                $("#errorpanel").hide();
                $("#DDC_btn_sbutton").hide();
                $("#DDC_btn_rbutton").hide();
                $('#DDC_btn_sbutton').attr("disabled", "disabled");
                $(".preloader").hide();
            }
            $('#DDC_recvertable >div').remove();
            $('#DDC_recvertable').hide();
        // CALL FOR  CUSTOMER NAME TO LOAD.........
            $('#DDC_lb_unitselect').change(function(){
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                $("#DDC_btn_sbutton,#DDC_btn_rbutton").hide();
                $(".preloader").show();
                $('#DDC_radiotable').hide();
                $('#DDC_customerselect').hide();
                $('#DDC_btn_sbutton').attr("disabled", "disabled");
                var unit = $(this).val();
                if(unit=="SELECT")
                {
                    $(".preloader").hide();
                    $('#DDC_radiotable >div').remove().hide();
                    $('#DDC_customerselect').hide();
                    $('#DDC_recvertable').hide();
                }
                else
                {
                    $('#DDC_recvertable').hide();
                    var DDC_arr_allcustomer=[];
                    var w=0;
                    for(var k=0;k<DDC_allunit.length;k++)
                    {
                        if(DDC_allunit[k].DDC_unitno==unit){
                            DDC_arr_allcustomer[w]=DDC_allunit[k].DDC_customername;
                            w++;
                        }
                    }
                    DDC_unique_customer=DDC_unique(DDC_arr_allcustomer);
                    DDC_unique_customer=DDC_unique_customer.sort();
                    $("#DDC_btn_sbutton").hide();
                    $("#DDC_btn_rbutton").hide();
                    $(".preloader").hide();
                    var options =' <option>SELECT</option>';
                    for (var o = 0; o < DDC_unique_customer.length; o++) {
                        var DDC_lb_cust_value=DDC_unique_customer[o].replace('-',' ');
                        options += '<option value="' + DDC_unique_customer[o] + '">' + DDC_lb_cust_value + '</option>';
                    }
                    $('#DDC_lb_customerselect').html(options);
                    $('#DDC_customerselect').show();
                    $("#DDC_lb_customerselect").val('SELECT').focus();
                }
            });
        // CALL FOR REC_VER AND START DATE AND END DATE TO LOAD IN THE FORM.........
            $('#DDC_lb_customerselect').change(function(){
                $("#DDC_btn_sbutton").hide();
                $("#DDC_btn_rbutton").hide();
                $('#DDC_radiotable').hide();
                $(".preloader").show();
                var DDC_unitnum=$('#DDC_lb_unitselect').val();
                $('#DDC_radiotable >div').remove();
                $('#DDC_hide').hide();
                var DDC_name = $(this).val();
                if(DDC_name=="SELECT")
                {
                    $(".preloader").hide();
                    $('#DDC_recvertable >div').remove();
                    $('#DDC_recvertable').hide();
                    $('#DDC_btn_sbutton').attr("disabled", "disabled");
                }
                else
                {
                    var DDC_arr_allcustomerid=[];
                    for(var q=0;q<DDC_allunit.length;q++)
                    {
                        if((DDC_allunit[q].DDC_customername==DDC_name)&&(DDC_allunit[q].DDC_unitno==DDC_unitnum)){
                            DDC_arr_allcustomerid.push(DDC_allunit[q].DDC_customername+'-'+DDC_allunit[q].DDC_customerid)
                        }
                    }
                    DDC_getdatebox(DDC_arr_allcustomerid);
                }
            });
            $('#DDC_customerselect').hide();
            $('#DDC_hide').hide();
        // CLEAR THE FORM WHEN CLICK THE RESET BUTTON...........
            $('#DDC_btn_rbutton').click(function(){
                $("#DDC_btn_sbutton").hide();
                $("#DDC_btn_rbutton").hide();
                $(".preloader").hide();
                $('#DDC_hide').hide();
                $('#DDC_recvertable >div').remove();
                $('#DDC_recvertable').hide();
                $('#DDC_customerselect').hide();
                $('#DDC_btn_sbutton').attr("disabled", "disabled");
                $("#DDC_lb_unitselect").val('SELECT');
                $('#DDC_radiotable >div').remove();
                $('#DDC_radiotable').hide();
            });
        // FOR SUBMIT BUTTON VALIDATION............
            $("#DD_form").change(function() {
                if(($("#DDC_lb_unitselect").val()=="SELECT")||($('input:checkbox[name=checkboxinc]').is(':checked')==false)||($("#DDC_lb_customerselect").val()=="SELECT"))
                {
                    $('#DDC_btn_sbutton').attr("disabled", "disabled");
                }
                else
                {
                    $('#DDC_btn_sbutton').removeAttr("disabled");
                }
            });
        // LOADING THE RADIO BUTTON WHEN SAME CUSTOMER NAME WITH DIFFERENT CUSTID
            function DDC_getdatebox(DDC_get){
                $("#DDC_btn_sbutton").hide();
                $("#DDC_btn_rbutton").hide();
                $('#DDC_btn_sbutton').attr("disabled", "disabled");
                $('#DDC_recvertable >div').remove();
                var idarray=[];
                idarray=DDC_get;
                var DDC_unitno=$('#DDC_lb_unitselect').val();
                var DDC_name=$('#DDC_lb_customerselect').val();
                if(idarray.length!=1)
                {
                    $(".preloader").hide();
                    $('#DDC_radiotable').show();
                    $('#DDC_recvertable').hide();
                    $('#DDC_btn_rbutton').hide();
                    $('#DDC_btn_sbutton').hide();
                    var DDC_radio_value='';
                    for (var i = 0; i < idarray.length; i++) {
                        var custid=idarray[i].split('-');
                        DDC_radio_value ='<div class="col-sm-offset-2" style="padding-left:15px"><div class="radio"><label><input type="radio" id="DDC_radio_idradiobtn" class="DDC_class_idradiobtn" name="DDC_radio_idradiobtn" value='+custid[1]+'/>' + custid[0] +' '+custid[1]+ '</label></div></div>';
                        $('#DDC_radiotable').append(DDC_radio_value);
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    }
                }
                else{
                    $('#DDC_radiotable').hide();
                    var custid=idarray[0].split('-');
                    $.ajax({
                        type: "POST",
                        url: ctrl_DDCalculation_url+'/DDC_loaddatebox',
                        data: {'custid':custid[1],'custname':$('#DDC_lb_customerselect').val(),'unitno':$('#DDC_lb_unitselect').val()},
                        success: function(dateval) {
                            var datevalues=JSON.parse(dateval);
                            DDC_getrecver(datevalues);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("DEPOSIT DEDUCTION CALCULATIONS",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                }
            }
        // CALLING BY  RADIO BUTTON FOR LOAD THE REC_VER AND START AND END DATE..........
            $(document).on('click','.DDC_class_idradiobtn',function()
            {
                $("#DDC_btn_sbutton").hide();
                $("#DDC_btn_rbutton").hide();
                $(".preloader").show();
                $('#DDC_btn_sbutton').attr("disabled","disabled");
                var DDC_unitno=$('#DDC_lb_unitselect').val();
                var DDC_name=$('#DDC_lb_customerselect').val();
                var id=$("input[name=DDC_radio_idradiobtn]:checked").val();
                $('#DDC_recvertable >div').remove();
                $('#DDC_recvertable').hide();
                $.ajax({
                    type: "POST",
                    url: ctrl_DDCalculation_url+'/DDC_loaddatebox',
                    data: {'custid':id,'custname':DDC_name,'unitno':DDC_unitno},
                    success: function(dateval) {
                        var datevalues=JSON.parse(dateval);
                        DDC_getrecver(datevalues);
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("DEPOSIT DEDUCTION CALCULATIONS",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            });
        // LOAD THE REC_VER, START DATE AND END DATE IN THE FORM FOR SELECTED CUSTOMER NAME.......
            function DDC_getrecver(recver)
            {
                DDC_recver=1;
                $("#DDC_btn_sbutton").hide();
                $("#DDC_btn_rbutton").hide();
                $(".preloader").hide();
                $("#DDC_tb_recdate").val('');
                $('.checkbox').removeClass('disabled');
                var myArray= [];
                var recv= [];
                var sdate= [];
                var edate= [];
                var pdate= [];
                myArray=recver;
                recv=myArray[0];
                sdate=myArray[1];
                edate=myArray[2];
                pdate=myArray[3];
                var idval=myArray[4];
                $('#DDC_tb_hidecustid').val(idval);
                var w=recv[0];
                var recverlenght = recv.length;
                $('#DDC_recvertable').show();
                var sedatelab='<label></label>';
                sedatelab='<div class="form-group"><label id="DDC_startdate" class="col-sm-offset-2 col-sm-2">START DATE</label><label id="DDC_enddate" class="col-sm-2">END DATE</label></div>';
                $('#DDC_recvertable').append(sedatelab);
                if(recverlenght==1)
                    DDC_recver=0;
                for(var k=1;k<=recverlenght;k++)
                {
                    var version = "LEASE PERIOD "+recv[k-1];
                    var recver='<label></label>';
                    var y =k-1;
                    var sdateid ="Dep_Cal_sdatetb"+k;
                    var edateid ="Dep_Cal_edatetb"+k;
                    var errid="calerrid"+k;
                    var checkvalid=recv[k-1];
                    var prestartchk =sdate[y];
                    if(pdate[y]==""||pdate[y]==undefined)
                        var preterchk = edate[y];
                    else
                    {
                        if(prestartchk<pdate[y])
                            var preterchk = pdate[y];
                        else
                            var preterchk = edate[y];
                    }
                    var sd=FormTableDateFormat(prestartchk);
                    var ed=FormTableDateFormat(preterchk);
                    var rbutton =k+"^"+recv[k-1]+"^"+sd+"^"+ed;
                    var sdatetb='<label></label>';
                    var edatetb='<label></label>';
                    if((sd=="01-01-1970")&&(ed=="01-01-1970"))
                    {
                        var sdateclear="";
                        var edateclear="";
                        recver = '<div class="form-group"><div class="col-sm-2"><div class="checkbox"><label><input type="checkbox" name="DDC_chk_checkboxinc[]" id="'+checkvalid+'" value="'+rbutton+'" class="calcheckbox">' + version + '</label></div></div><div class="col-sm-2"><input type="text" name="DDC_db_startdate" id="'+sdateid+'" value="'+sdateclear+'" class="rdonly form-control" readonly></div><div class="col-sm-2"><input type="text" name="DDC_db_enddate" id='+edateid+' value="'+edateclear+'" class="rdonly form-control" readonly></div><div><label id="'+errid+'" hidden class="errormsg errpadding"></label></div></div>';
                        $('#DDC_recvertable').append(recver);
                    }
                    else
                    if((sd=="01-01-1970")&&(ed!="01-01-1970")||(sd!="01-01-1970")&&(ed=="01-01-1970"))
                    {
                        if(sd=="01-01-1970")
                        {
                            var sdateclear="";
                            recver = '<div class="form-group"><div class="col-sm-2"><div class="checkbox"><label><input type="checkbox" name="DDC_chk_checkboxinc[]" id="'+checkvalid+'" value="'+rbutton+'" class="calcheckbox">' + version + '</label></div></div><div class="col-sm-2"><input type="text" name="DDC_db_startdate" id="'+sdateid+'" value="'+sdateclear+'" class="rdonly form-control" readonly></div><div class="col-sm-2"><input type="text" name="DDC_db_enddate" id='+edateid+' value="'+ed+'" class="rdonly form-control" readonly></div><div><label id="'+errid+'" hidden class="errormsg errpadding"></label></div></div>';
                            $('#DDC_recvertable').append(recver);
                        }
                        if(ed=="01-01-1970")
                        {
                            var edateclear="";
                            recver = '<div class="form-group"><div class="col-sm-2"><div class="checkbox"><label><input type="checkbox" name="DDC_chk_checkboxinc[]" id="'+checkvalid+'" value="'+rbutton+'" class="calcheckbox">' + version + '</label></div></div><div class="col-sm-2"><input type="text" name="DDC_db_startdate" id="'+sdateid+'" value="'+sd+'" class="rdonly form-control" readonly></div><div class="col-sm-2"><input type="text" name="DDC_db_enddate" id='+edateid+' value="'+edateclear+'" class="rdonly form-control" readonly></div><div><label id="'+errid+'" hidden class="errormsg errpadding"></label></div></div>';
                            $('#DDC_recvertable').append(recver);
                        }
                    }
                    if((sd!="01-01-1970")&&(ed!="01-01-1970"))
                    {
                        var lblid=checkvalid+'_1';
                        recver = '<div class="form-group"><div class="col-sm-2"><div class="checkbox"><label id="'+lblid+'"><input type="checkbox" name="DDC_chk_checkboxinc[]" id="'+checkvalid+'" value="'+rbutton+'" class="calcheckbox">' + version + '</label></div></div><div class="col-sm-2"><input type="text" name="DDC_db_startdate" id="'+sdateid+'" value="'+sd+'" class="rdonly form-control" readonly></div><div class="col-sm-2"><input type="text" name="DDC_db_enddate" id='+edateid+' value="'+ed+'" class="rdonly form-control" readonly></div><div><label id="'+errid+'" hidden class="errormsg errpadding"></label></div></div>';
                        $('#DDC_recvertable').append(recver);
                    }
                }
                $('#DDC_tb_hiderecverlength').val(recverlenght);
                if(DDC_recver==0){
                    $('#'+checkvalid).hide();
                    $('#'+lblid).css('padding-left',0);
                    $('.checkbox').addClass('disabled');
                    $("#DDC_tb_recdate").val(rbutton);
                    $("#DDC_btn_sbutton").show();
                    $("#DDC_btn_rbutton").show();
                    if(($("#Dep_Cal_edatetb1").val()=="")||($("#Dep_Cal_sdatetb1").val()==""))
                    {
                        $("#DDC_btn_sbutton").attr("disabled", "disabled");
                    }
                    else
                        $("#DDC_btn_sbutton").removeAttr("disabled");
                }
            }
        //CALL BY CHECK BOX FOR SHOW THE ERROR MESSAGE FOR EMPTY DATE INTHE FORM...........
            $(document).on('click','.calcheckbox',function()
            {
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                $("#DDC_btn_sbutton,#DDC_btn_rbutton").show();
                var idckb= $(this).val();
                var checkid =$(this).attr('id');
                var cc_check=$('input[name="DDC_chk_checkboxinc[]"]:checked').is(":checked");
                var email=$("#DDC_LB_Emaillist").val();
                if(cc_check==false)
                {
                    $("#DDC_btn_rbutton").hide();
                    $("#DDC_btn_sbutton").attr("disabled", "disabled").hide();
                }
                var checkid=checkid.replace( /^\D+/g, '');
                var sdateid ="Dep_Cal_sdatetb"+checkid;
                var edateid ="Dep_Cal_edatetb"+checkid;
                var sd=$("#"+sdateid).val();
                var ed=$("#"+edateid).val();
                var errid="calerrid"+checkid;
                var cc_check=$('input[name="DDC_chk_checkboxinc[]"]:checked').is(":checked");
                var sedatetb='<label></label>';
                if((sd=="")||(ed==""))
                {
                    if(cc_check==true)
                    {
                        if((sd=="")&&(ed==""))
                        {
                            $("#DDC_btn_sbutton").attr("disabled", "disabled");
                        }
                        else
                        if((sd=="")&&(ed!="")||(sd!="")&&(ed==""))
                        {
                            if((sd=="")&&(ed!=""))
                            {
                                $("#DDC_btn_sbutton").attr("disabled", "disabled");
                            }
                            if((sd!="")&&(ed==""))
                            {
                                $("#DDC_btn_sbutton").attr("disabled", "disabled");
                            }
                        }
                        if((sd==""&&ed=="")||((sd!=""&&ed=="")||(sd==""&&ed!="")))
                        {
                            $("#DDC_btn_sbutton").attr("disabled", "disabled");
                        }
                    }
                    else
                    {
                        $('#'+errid).hide();
                    }
                }
                if(cc_check==false)
                {
                    $("#DDC_btn_sbutton").attr("disabled", "disabled");
                }else
                {
                    $("#DDC_btn_sbutton").removeAttr("disabled");
                }
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>DEPOSIT DEDUCTION CALCULATIONS</b></h4></div>
    <form id="DDC_form_errormsg">
        <div class="panel-body" id="errorpanel" hidden>
            <fieldset>
                <div class="form-group" id="DDC_table_errormsg">
                </div>
            </fieldset>
        </div>
    </form>
    <form id="DD_calculationform" name="DD_calculationform" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div id="maintable">
                    <div class="form-group" id="DDC_unitno">
                        <label class="col-sm-2">SELECT A UNIT <em>*</em></label>
                        <div class="col-sm-2"><select name="DDC_lb_unitselect" id="DDC_lb_unitselect" class="form-control"><option>SELECT</option></select></div>
                    </div>
                    <div class="form-group" id="DDC_customerselect" hidden>
                        <label class="col-sm-2">CUSTOMER NAME <em>*</em></label>
                        <div class="col-sm-3"><select name="DDC_lb_customerselect" id="DDC_lb_customerselect" class="form-control"></select></div>
                    </div>
                    <div class="form-group" id="DDC_radiotable" hidden>
                    </div>
                </div>
                <div id="DDC_recvertable" hidden>
                </div>
                <div class="col-sm-offset-1 col-sm-4">
                    <input class="maxbtn" type="button" id="DDC_btn_sbutton" value='CALCULATE' disabled hidden/>
                    <input class="maxbtn" type="button" id="DDC_btn_rbutton" value="RESET" hidden/>
                    <input type="hidden" name ="DDC_tb_hidecustid" id="DDC_tb_hidecustid"/>
                    <input type="hidden" name ="DDC_tb_hiderecverlength" id="DDC_tb_hiderecverlength"/>
                </div>
                <div class="form-group col-lg-12 errormsg errpadding" id="DDC_errmsgdata" hidden>
                </div>
                <div><input type='hidden' id="DDC_tb_recdate" name="DDC_tb_recdate"></div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>