<?php
//******************************************Deposit_Extraction********************************************//
//VER 0.02-SD:06/06/2015 ED:10/06/2015,did the ss part for deposit extraction and ss insert part BY RAJA
//VER 0.01-SD:26/05/2015 ED:27/05/2015,completed form design and validation without ss part BY RAJA
//*******************************************************************************************************//
require_once('application/libraries/EI_HDR.php');
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
            var ctrl_DDExtract_url="<?php echo site_url('FINANCE/FINANCE/Ctrl_Finance_Extract_Deposit_Pdf'); ?>";
            $('#spacewidth').height('0%');
            var srtemailarray=[];
            var montharray=[];
            var DDE_errorAarray;
            var DDE_tableerrorarray=[];
            var DDE_glb_samename=[];
            var DDE_flg_checkbox=1;
            var shturl='';
            var selectedsheet='';
            var unitno='';
            var customername='';
            var nocustid='1';
        // initial data
            $.ajax({
                type: "POST",
                url: ctrl_DDExtract_url+'/Initialdata',
                success: function(data){
                    var initial_values=JSON.parse(data);
                    DDE_loadgetmonthh(initial_values);
                },
                error:function(data){
                    var errordata=(JSON.stringify(data));
                    show_msgbox("DEPOSIT DEDUCTION EXTRACTS",errordata,'error',false);
                    $('.preloader').hide();
                }
            });
            $('#DDE_customerselect').hide();
            $('#DDE_btn_sbutton').hide();
            $('#DDE_btn_rbutton').hide();
            $('#maintable').hide();
            $('#DDE_unitselect').hide();
            $('#DDE_Emaillist').hide();
            $('#DDE_monthselect').hide();
            $('#DDE_startdate').hide();
            $('#em').hide();
            $('#DDE_enddate').hide();
            $('#DDE_emailtable >div').remove().hide();
            $("#DDE_btn_sbutton").attr("disabled", "disabled");
        // CHANGE FUNCTION FOR MONTH SELECTION
            $('#DDE_lb_monthselect').change(function(){
                $(".preloader").show();
                $("#DDE_btn_sbutton").hide();
                $("#DDE_btn_rbutton").hide();
                $("#DDE_btn_sbutton").attr("disabled", "disabled");
                var month = $(this).val();
                if(month=="SELECT")
                {
                    $(".preloader").hide();
                    $('#em').hide();
                    $('#DDE_customerselect').hide();
                    $('#DDE_emailtable >div').remove().hide();
                    $('#DDE_radiotable').hide();
                    $('#DDE_recvertable').hide();
                    $('#DDE_unitselect').hide();
                }
                else
                {
                    selectedsheet=month;
                    $.ajax({
                        type: "POST",
                        url: ctrl_DDExtract_url+'/DDE_getsheetunit',
                        data: {'month':month,shturl:shturl},
                        success: function(unitdata){
                            var unit_values=JSON.parse(unitdata);
                            DDE_getunit(unit_values);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("DEPOSIT DEDUCTION EXTRACTS",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    $('#DDE_customerselect').hide();
                    $('#DDE_radiotable').hide();
                    $('#DDE_recvertable').hide();
                    $('#em').hide();
                    $('#DDE_unitselect').hide();
                    $('#DDE_emailtable >div').remove();
                    $('#DDE_emailtable').hide();
                }
            });
        // SHOWS THE CUSTOMER LISTBOX..................
            $('#DDE_lb_unitselect').change(function(){
                $(".preloader").show();
                $("#DDE_btn_sbutton").hide();
                $("#DDE_btn_rbutton").hide();
                $("#DDE_btn_sbutton").attr("disabled", "disabled");
                var unit = $(this).val();
                if(unit=="SELECT")
                {
                    $(".preloader").hide();
                    $('#em').hide();
                    $('#DDE_customerselect').hide();
                    $('#DDE_radiotable').hide();
                    $('#DDE_emailtable >div').remove();
                    $('#DDE_emailtable').hide();
                    $('#DDE_recvertable').hide();
                }
                else
                {
                    unitno=unit;
                    var month=$('#DDE_lb_monthselect').val();
                    $.ajax({
                        type: "POST",
                        url: ctrl_DDExtract_url+'/DDE_customername',
                        data: {'unit':unit,'month':month,'shturl':shturl},
                        success: function(custdata){
                            var cust_values=JSON.parse(custdata);
                            DDE_custname(cust_values);
                            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        },
                        error:function(data){
                            var errordata=(JSON.stringify(data));
                            show_msgbox("DEPOSIT DEDUCTION EXTRACTS",errordata,'error',false);
                            $('.preloader').hide();
                        }
                    });
                    $('#DDE_customerselect').hide();
                    $('#DDE_radiotable').hide();
                    $('#DDE_emailtable >div').remove();
                    $('#DDE_emailtable').hide();
                    $('#DDE_recvertable').hide();
                }
            });
        // SHOWS THE  REC_VER ,START DATE AND END DATE..............
            $('#DDE_lb_customerselect').change(function(){
                $("#DDE_btn_sbutton").hide();
                $("#DDE_btn_rbutton").hide();
                $("#DDE_btn_sbutton").attr("disabled", "disabled");
                var name = $(this).val();
                if(name=="SELECT")
                {
                    $(".preloader").hide();
                    $('#DDE_recvertable >div').remove().hide();
                    $('#DDE_emailtable >div').remove().hide();
                }
                else
                {
                    customername=name;
                    $('#DDE_radiotable').show();
                    $('#DDE_radiotable').empty();
                    var DDE_flag_radio_custname=0;
                    var DDE_unit=$('#DDE_lb_unitselect').val();
                    var DDE_month=$('#DDE_lb_monthselect').val();
                    for(var c=0;c<DDE_glb_samename.length;c++){
                        var DDE_split_nameid=DDE_glb_samename[c].split('_');
                        // RADIO BTN FOR DUPLICATE CUSTOMER
                        if(DDE_split_nameid[1]!='' && DDE_split_nameid[1]!=undefined && DDE_split_nameid[0]==name){
                            DDE_flag_radio_custname=1;
                            var DDE_customernameid=DDE_glb_samename[c].replace('_',' ');
                            var DDE_td ='<div class="col-sm-offset-2" style="padding-left:15px"><div class="radio"><label><input type="radio" id="DDE_customer_id_name'+c+'" name="DDE_customer_id_name" class="DDE_class_customeridname" value="'+DDE_glb_samename[c]+'" >'+DDE_customernameid+'</label></div></div>';
                            $(DDE_td).appendTo($("#DDE_radiotable"));
                        }
                    }
                    if(DDE_flag_radio_custname==1){
                        for(var c=0;c<DDE_glb_samename.length;c++){
                            if(DDE_glb_samename[c]==name){
                                DDE_flag_radio_custname=1;
                                var DDE_customername_id=DDE_glb_samename[c].replace('_',' ');
                                var DDE_td ='<div class="col-sm-offset-2" style="padding-left:15px"><div class="radio"><label><input type="radio" id="DDE_customer_id_name'+c+'" name="DDE_customer_id_name" class="DDE_class_customeridname" value="'+DDE_glb_samename[c]+'" >'+DDE_customername_id+'</label></div></div>';
                                $(DDE_td).appendTo($("#DDE_radiotable"));
                            }
                        }
                    }
                    if(DDE_flag_radio_custname==0){
                        $(".preloader").show();
                        $.ajax({
                            type: "POST",
                            url: ctrl_DDExtract_url+'/DDE_getcustid',
                            data: {'name':name,'DDE_unit':DDE_unit,'DDE_month':DDE_month,'shturl':shturl},
                            success: function(custdtldata){
                                var custdtl_values=JSON.parse(custdtldata);
                                DDE_getdatebox(custdtl_values);
                            },
                            error:function(data){
                                var errordata=(JSON.stringify(data));
                                show_msgbox("DEPOSIT DEDUCTION EXTRACTS",errordata,'error',false);
                                $('.preloader').hide();
                            }
                        });
                        $('#DDE_radiotable').hide();
                    }
                    $('#DDE_recvertable >div').remove().hide();
                    $('#DDE_emailtable >div').remove().hide();
                }
            });
        // CLICK FUNCTION FOR RADIO BTN FOR DUPLICATE CUSTOMER
            $(document).on('click','.DDE_class_customeridname',function(){
                $(".preloader").show();
                var DDE_unit=$('#DDE_lb_unitselect').val();
                var DDE_month=$('#DDE_lb_monthselect').val();
                var DDE_name=$(this).val();
                $('#DDE_recvertable >div').remove();
                $('#DDE_recvertable').hide();
                $('#DDE_emailtable >div').remove();
                $('#DDE_emailtable').hide();
                $.ajax({
                    type: "POST",
                    url: ctrl_DDExtract_url+'/DDE_Dep_Exct_recversionfun',
                    data: {'DDE_namesplit':DDE_name.split(' ')[2],'DDE_unit':DDE_unit,'DDE_month':DDE_month,'DDE_name':DDE_name},
                    success: function(recverdata){
                        var recver_values=JSON.parse(recverdata);
                        DDE_getrecver(recver_values);
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("DEPOSIT DEDUCTION EXTRACTS",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            });
        // RESET ALL THE ELEMENT  AND RETURN  TO ORIGAN STAGE..................
            $('#DDE_btn_rbutton').click(function(){
                $('#DDE_customerselect').hide();
                $('#em').hide();
                $('#DDE_radiotable').hide();
                $('#DDE_recvertable').hide();
                $('#DDE_unitselect').hide();
                $('#DDE_Emaillable').hide();
                $('#DDE_startdate').hide();
                $('#DDE_enddate').hide();
                $('#DDE_emailtable >div').remove();
                $('#DDE_emailtable').hide();
                $("#DDE_btn_sbutton").attr("disabled", "disabled");
                $("#DDE_btn_sbutton").hide();
                $("#DDE_btn_rbutton").hide();
                $("#DDE_lb_monthselect").val('SELECT');
            });
        // CONFORMATION MESSAGE IS  SHOWS AFTER CLICK THE SUBMIT BUTTON................
            $('#DDE_btn_sbutton').click(function(){
                $(".preloader").show();
                var formelement=$("#DD_Extractionform").serialize();
                $.ajax({
                    type: "POST",
                    url: ctrl_DDExtract_url+'/DDE_Dep_Exct_submit',
                    data: formelement+'&shturl='+shturl,
                    success: function(submitdata){
                        var submit_values=JSON.parse(submitdata);
                        DDE_clearandshowmsg(submit_values);
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("DEPOSIT DEDUCTION EXTRACTS",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            });
            function DDE_clearandshowmsg(success)
            {
                $(".preloader").hide();
                if(success=='DDC_flag_nosheet'){
                    show_msgbox("DEPOSIT DEDUCTION EXTRACTS",DDE_errorAarray[11].EMC_DATA,'error',false);
                }
                else if(success=='Get_access'){
                    show_msgbox("DEPOSIT DEDUCTION EXTRACTS",DDE_errorAarray[13].EMC_DATA,'error',false);
                }
                else{
                    $('#em').hide();
                    $('#DDE_customerselect').hide();
                    var unit=$('#DDE_lb_customerselect').val();
                    var save=DDE_errorAarray[7].EMC_DATA;
                    var savemsg = save.replace('[PROFILE]', unit);
                    show_msgbox("DEPOSIT DEDUCTION EXTRACTS",savemsg,'success',false);
                    $('#DDE_radiotable').hide();
                    $('#DDE_recvertable').hide();
                    $('#DDE_unitselect').hide();
                    $('#DDE_Emaillable').hide();
                    $('#DDE_startdate').hide();
                    $('#DDE_enddate').hide();
                    $('#DDE_emailtable >div').remove();
                    $('#DDE_emailtable').hide();
                    $("#DDE_btn_sbutton").attr("disabled", "disabled");
                    $("#DDE_lb_monthselect").val("SELECT");
                    $("#DDE_btn_sbutton").hide();
                    $("#DDE_btn_rbutton").hide();
                }
            }
        // LOAD THE MONTH IN THE MONTH LISTBOX FROM  THE SHEET................
            function DDE_loadgetmonthh(month)
            {
                $(".preloader").hide();
                DDE_errorAarray=month.DDE_errorAarray;
                if(month.DDE_flag_noss=='DDE_flag_noss'){
                    show_msgbox("DEPOSIT DEDUCTION EXTRACTS",DDE_errorAarray[12].EMC_DATA,'error',false);
                }
                else{
                    montharray=month.montharray;
                    shturl=month.shturl;
                    //DDE_tableerrorarray=month.DDE_tableerrorarray;
                    srtemailarray=month.srtemailarray;
                    if(((month.srtemailarray).length!=0)&&(montharray.length!=0 && montharray!=undefined && montharray.length!=""))
                    {
                        $('#DDE_table_errormsg').text('').hide();
                        if(montharray.length!=0 && montharray!=undefined && montharray.length!="")
                        {
                            var options =' <lable></lable>';
                            for (var i = 0; i < montharray.length; i++) {
                                options += '<option value="' + montharray[i] + '">' + montharray[i] + '</option>';
                            }
                            $('#DDE_lb_monthselect').append(options);
                            $('#DDE_monthselect').show();
                        }
                    }
                    else
                    {
                        if(montharray.length==0 && montharray==undefined && montharray.length=="")
                        {
                            $('#DD_Extractionform').hide();
                            var uniterrormsg='<p><label class="errormsg">' +DDE_errorAarray[10].EMC_DATA + '</label></p>';
                            $('#DDE_table_errormsg').append(uniterrormsg).show();
                        }
                        if((month.srtemailarray).length==0)
                        {
                            $('#DD_Extractionform').hide();
                            var DDE_tableerrg=DDE_errorAarray[9].EMC_DATA;
                            var DDE_tableerrgchg = DDE_tableerrg.replace('[PROFILE]', 'DEPOSITE DEDUCTION');
                            var uniterrormsg='<p><label class="errormsg">' +DDE_tableerrgchg + '</label></p>';
                            $('#DDE_table_errormsg').append(uniterrormsg).show();
                        }
                    }
                    $("#DDE_btn_sbutton").hide();
                    $("#DDE_btn_rbutton").hide();
                    $('#maintable').show();
                    $('#DDE_lb_monthselect').focus();
                }
            }
        // LOAD THE UNITNO FROM THE SHEET IN TO UNIT LISTBOX.................
            function DDE_getunit(unit)
            {
                $(".preloader").hide();
                $("select[id$=DDE_lb_unitselect] > option").remove();
                var unitarray=[];
                unitarray=unit;
                var options =' <option>SELECT</option>';
                for (var i = 0; i < unitarray.length; i++) {
                    options += '<option value="' + unitarray[i] + '">' + unitarray[i] + '</option>';
                }
                $('#DDE_lb_unitselect').append(options);
                $('#DDE_unitselect').show();
                $('#DDE_lb_unitselect').focus();
                $("#DDE_btn_sbutton").hide();
                $("#DDE_btn_rbutton").hide();
            }
            function DDE_unique(a) {
                var result = [];
                $.each(a, function(i, e) {
                    if ($.inArray(e, result) == -1) result.push(e);
                });
                return result;
            }
        // LOAD THE CUSTOMER NAME FROM SHEET TO CUSTOMER LISTBOX..................
            function DDE_custname(response){
                $(".preloader").hide();
                $("#DDE_btn_sbutton").hide();
                $("#DDE_btn_rbutton").hide();
                var myArray= [];
                myArray=DDE_unique(response[0]);
                DDE_glb_samename=response[1];
                myArray=myArray.sort();
                $("select[id$=DDE_lb_customerselect] > option").remove();
                var options =' <option>SELECT</option>';
                for (var i = 0; i < myArray.length; i++) {
                    options += '<option value="' + myArray[i] + '">' + myArray[i] + '</option>';
                }
                $('#DDE_lb_customerselect').html(options);
                $('#DDE_customerselect').show();
                $('#em').show();
                $("#DDE_lb_customerselect").val('SELECT').focus();
            }
        // SHOWS THE RADIOBUTTON  IF  WE HAVE  SAME CUSTOMER NAME WITH  DIFFERENT  CUSTID..........
            function DDE_getdatebox(getid)
            {
                $("#DDE_btn_sbutton").hide();
                $("#DDE_btn_rbutton").hide();
                $('#DDE_btn_sbutton').attr("disabled", "disabled");
                var DDE_unit=$('#DDE_lb_unitselect').val();
                var DDE_month=$('#DDE_lb_monthselect').val();
                var name=$('#DDE_lb_customerselect').val();
                $.ajax({
                    type: "POST",
                    url: ctrl_DDExtract_url+'/DDE_Dep_Exct_recversionfun',
                    data: {'DDE_namesplit':getid,'DDE_unit':DDE_unit,'DDE_month':DDE_month,'DDE_name':name,'shturl':shturl,'nocustid':nocustid},
                    success: function(recverdata){
                        var recver_values=JSON.parse(recverdata);
                        DDE_getrecver(recver_values);
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("DEPOSIT DEDUCTION EXTRACTS",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            }
        // GET THE REC_VER ,START DATE AND END DATE  FOR SELECTED  CUSTOMER NAME..............
            function DDE_radiobtnid()
            {
                $(".preloader").hide();
                var getid=$("input[name=DDE_radio_idradiobtn]:checked").val();
                var DDE_unit=$('#DDE_lb_unitselect').val();
                var DDE_month=$('#DDE_lb_monthselect').val();
                var name=$('#DDE_lb_customerselect').val();
                $("#DDE_btn_sbutton").hide();
                $("#DDE_btn_rbutton").hide();
                $('#DDE_emailtable >div').remove();
                $('#DDE_emailtable').hide();
                $('#DDE_recvertable >div').remove();
                $('#DDE_recvertable').hide();
                $.ajax({
                    type: "POST",
                    url: ctrl_DDExtract_url+'/DDE_Dep_Exct_recversionfun',
                    data: {'DDE_namesplit':getid,'DDE_unit':DDE_unit,'DDE_month':DDE_month,'DDE_name':name},
                    success: function(recverdata){
                        var recver_values=JSON.parse(recverdata);
                        DDE_getrecver(recver_values);
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                    },
                    error:function(data){
                        var errordata=(JSON.stringify(data));
                        show_msgbox("DEPOSIT DEDUCTION EXTRACTS",errordata,'error',false);
                        $('.preloader').hide();
                    }
                });
            }
        // convert ss date into new date
            function formatSSDate(dt)
            {
                var month = dt.getMonth();
                var day = dt.getDate();
                month = month + 1;
                month = month + "";
                if (month.length == 1){
                    month = "0" + month;
                }
                day = day + "";
                if (day.length == 1){
                    day = "0" + day;
                }
                return day + '-' + month + '-' + dt.getFullYear();
            }
        // LOAD THE REC_VER, START DATE AND END DATE  IN THE FORM.................
            function DDE_getrecver(recver)
            {
                $(".preloader").hide();
                $("#DDE_btn_sbutton").hide();
                $("#DDE_btn_rbutton").hide();
                $('#DDE_tb_recdate').val('');
                var unique_recver= [];
                var recv= [];
                var sdate= [];
                var edate= [];
                var pdate= [];
                unique_recver=recver.unique_recver;
                var recverlenght = unique_recver.length;
                var checkvalue=[];
                var sedatelab='<label></label>';
                sedatelab='<div class="form-group"><label id="DDE_startdate" class="col-sm-offset-2 col-sm-2">START DATE</label><label id="DDE_enddate" class="col-sm-2">END DATE</label></div>';
                $('#DDE_recvertable').append(sedatelab).show();
                for(var k=1;k<=recverlenght;k++)
                {
                    DDE_flg_checkbox=1;
                    var  y = (k-1);
                    var version = unique_recver[y][0].key;
                    var version = version.replace( 'REC_VER', 'LEAST_PERIOD');
                    var splitversion=version.split('_');
                    var leastperiodtext=splitversion[0]+' '+splitversion[1];
                    var rbutton ="Dep_Exct_rbutton/"+k;
                    checkvalue.push(rbutton);
                    var recver='<label></label>';
                    var z =k+3;
                    var sdateid ="Dep_Exct_sdatetb"+k;
                    var edateid ="Dep_Exct_edatetb"+k;
                    var errid="errid"+k;
                    var checkvalid="checkid"+k;
                    var sd=new Date(unique_recver[y][0].startdate);
                    var ed=new Date(unique_recver[y][0].enddate);
                    sd=formatSSDate(sd);
                    ed=formatSSDate(ed);
                    var sdatetb='<label></label>';
                    var edatetb='<label></label>';
                    if((sd=="01-01-1970")&&(ed=="01-01-1970"))
                    {
                        var sdateclear=" ";
                        var edateclear=" ";
                        recver = '<div class="form-group"><div class="col-sm-2"><div class="checkbox"><label><input type="checkbox" name="DDE_chk_checkboxinc[]" id="'+checkvalid+'" value="'+version+'" class="extcheckbox submitvalidate">' + leastperiodtext + '</label></div></div><div class="col-sm-2"><input type="text" name='+sdateid+' id="'+sdateid+'" value="'+sdateclear+'" class="rdonly form-control" readonly></div><div class="col-sm-2"><input type="text" name='+edateid+' id='+edateid+' value="'+edateclear+'" class="rdonly form-control" readonly></div><div class="col-sm-6"><label id="'+errid+'" hidden class="errormsg errpadding"></label></div></div>';
                        $('#DDE_recvertable').append(recver);
                    }
                    else
                    if((sd=="01-01-1970")&&(ed!="01-01-1970")||(sd!="01-01-1970")&&(ed=="01-01-1970"))
                    {
                        if((sd=="01-01-1970")&&(ed!="01-01-1970"))
                        {
                            var sdateclear=" ";
                            recver = '<div class="form-group"><div class="col-sm-2"><div class="checkbox"><label><input type="checkbox" name="DDE_chk_checkboxinc[]" id="'+checkvalid+'" value="'+version+'" class="extcheckbox submitvalidate">' + leastperiodtext + '</label></div></div><div class="col-sm-2"><input type="text" name='+sdateid+' id="'+sdateid+'" value="'+sdateclear+'" class="rdonly form-control" readonly></div><div class="col-sm-2"><input type="text" name='+edateid+' id='+edateid+' value="'+ed+'" class="rdonly form-control" readonly></div><div class="col-sm-6"><label id="'+errid+'" hidden class="errormsg errpadding"></label></div></div>';
                            $('#DDE_recvertable').append(recver);
                        }
                        if((sd!="01-01-1970")&&(ed=="01-01-1970"))
                        {
                            var edateclear=" ";
                            recver = '<div class="form-group"><div class="col-sm-2"><div class="checkbox"><label><input type="checkbox" name="DDE_chk_checkboxinc[]" id="'+checkvalid+'" value="'+version+'" class="extcheckbox submitvalidate">' + leastperiodtext + '</label></div></div><div class="col-sm-2"><input type="text" name='+sdateid+' id="'+sdateid+'" value="'+sd+'" class="rdonly form-control" readonly></div><div class="col-sm-2"><input type="text" name='+edateid+' id='+edateid+' value="'+edateclear+'" class="rdonly form-control" readonly></div><div class="col-sm-6"><label id="'+errid+'" hidden class="errormsg errpadding"></label></div></div>';
                            $('#DDE_recvertable').append(recver);
                        }
                    }
                    if((sd!="01-01-1970")&&(ed!="01-01-1970"))
                    {
                        var lblid=checkvalid+'_1';
                        recver = '<div class="form-group"><div class="col-sm-2"><div class="checkbox"><label id="'+lblid+'"><input type="checkbox" name="DDE_chk_checkboxinc[]" id="'+checkvalid+'" value="'+version+'" class="extcheckbox submitvalidate">' + leastperiodtext + '</label></div></div><div class="col-sm-2"><input type="text" name='+sdateid+' id="'+sdateid+'" value="'+sd+'" class="rdonly form-control" readonly></div><div class="col-sm-2"><input type="text" name='+edateid+' id='+edateid+' value="'+ed+'" class="rdonly form-control" readonly></div><div class="col-sm-6"><label id="'+errid+'" hidden class="errormsg errpadding"></label></div></div>';
                        $('#DDE_recvertable').append(recver);
                    }
                }
                $('#DDE_Emaillist').hide();
                $('#DDE_emailtable').hide();
                var email='<label></label>';
                email='<div class="form-group" id="DDE_Emaillist"><label class="col-sm-2" id="DDE_LBL_Emaillable"> EMAIL ADDRESS <em>*</em></label><div class="col-sm-4"><select id="DDE_LB_Emaillist" name="DDE_LB_Emaillist" class="submitvalidate form-control" ></select></div></div>';
                $('#DDE_emailtable').append(email);
                var options =' <option>SELECT</option>';
                for (var i = 0; i < srtemailarray.length; i++) {
                    options += '<option value="' + srtemailarray[i] + '">' + srtemailarray[i] + '</option>';
                }
                $('#DDE_LB_Emaillist').html(options);
                if(recverlenght==1){
                    $('#DDE_Emaillist').show();
                    $('#DDE_emailtable').show();
                    $('#DDE_btn_sbutton').hide();
                    $('#DDE_btn_rbutton').hide();
                    $('#'+lblid).css('padding-left',0);
                    $('.checkbox').addClass('disabled');
                    $('.extcheckbox').hide();
                    $('#'+checkvalid).hide();
                    $('#DDE_tb_recdate').val(version);
                    DDE_flg_checkbox=0;
                    $('#DDE_LB_Emaillist').focus();
                }
            }
        // SHOWS THE ERROR MESSAGE WHEN WE HAVE DEFAULT DATE................
            $(document).on('click','.extcheckbox',function()
            {
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                var idckb= $(this).val();
                var checkid =$(this).attr('id');
                var cc_check=$('input[name="DDE_chk_checkboxinc[]"]:checked').is(":checked");
                var email=$("#DDE_LB_Emaillist").val();
                var checkid =$(this).attr('id');
                var dd=$("#DDE_LB_Emaillist").val();
                var checkidly=checkid.replace( /^\D+/g, '');
                var sdateid ="Dep_Exct_sdatetb"+checkidly;
                var edateid ="Dep_Exct_edatetb"+checkidly;
                var sd=$("#"+sdateid).val();
                var ed=$("#"+edateid).val();
                var errid="errid"+checkidly;
                if($("#"+checkid).is(":checked")==true)
                {
                    if((cc_check==false))
                    {
                        $("#DDE_LB_Emaillist").val('SELECT');
                        $("#DDE_btn_sbutton").attr("disabled", "disabled");
                        $('#DDE_Emaillist').hide();
                        $('#DDE_emailtable').hide();
                        $('#DDE_btn_sbutton').hide();
                        $('#DDE_btn_rbutton').hide();
                    }
                    else if((cc_check==true) && sd!="" && sd!="")
                    {
                        $('#DDE_Emaillist').show();
                        $('#DDE_emailtable').show();
                        $('#DDE_LB_Emaillist').focus();
                        $('#DDE_btn_sbutton').show();
                        $('#DDE_btn_rbutton').show();
                        if((email=="SELECT"))
                        {
                            $("#DDE_btn_sbutton").attr("disabled", "disabled");
                        }
                        else
                        {
                            $("#DDE_btn_sbutton").removeAttr("disabled");
                        }
                    }
                    if((cc_check==false)&&(email=="SELECT"))
                    {
                        $("#DDE_btn_sbutton").attr("disabled", "disabled");
                        $('#DDE_btn_sbutton').hide();
                        $('#DDE_btn_rbutton').hide();
                    }
                    var checkid=checkid.replace( /^\D+/g, '');
                    var sdateid ="Dep_Exct_sdatetb"+checkid;
                    var edateid ="Dep_Exct_edatetb"+checkid;
                    var sd=$("#"+sdateid).val();
                    var ed=$("#"+edateid).val();
                    var errid="errid"+checkid;
                    var cc_check=$('input[name="DDE_chk_checkboxinc[]"]:checked').is(":checked");
                    var sedatetb='<label></label>';
                    if((sd=="")||(ed==""))
                    {
                        if(cc_check==true)
                        {
                            if((sd=="")&&(ed==""))
                            {
                                $("#DDE_btn_sbutton").attr("disabled", "disabled");
                                $('#'+errid).text(DDE_errorAarray[0].EMC_DATA).show();
                                $('#DDE_btn_sbutton').hide();
                                $('#DDE_btn_rbutton').hide();
                                $('#DDE_Emaillist').hide();
                            }
                            else {
                                if ((sd == "") && (ed != "") || (sd != "") && (ed == "")) {
                                    if ((sd == "") && (ed != "")) {
                                        $("#DDE_btn_sbutton").attr("disabled", "disabled");
                                        $('#' + errid).text(DDE_errorAarray[2].EMC_DATA).show();
                                        $('#DDE_btn_sbutton').hide();
                                        $('#DDE_btn_rbutton').hide();
                                        $('#DDE_Emaillist').hide();
                                    }
                                    if ((sd != "") && (ed == "")) {
                                        $('#' + errid).text(DDE_errorAarray[1].EMC_DATA).show();
                                        $("#DDE_btn_sbutton").attr("disabled", "disabled");
                                        $('#DDE_btn_sbutton').hide();
                                        $('#DDE_btn_rbutton').hide();
                                        $('#DDE_Emaillist').hide();
                                    }
                                }
                                if ((sd == "" && ed == "") || ((sd != "" && ed == "") || (sd == "" && ed != ""))) {
                                    $("#DDE_btn_sbutton").attr("disabled", "disabled");
                                }
                            }
                        }
                        else
                        {
                            if((cc_check==false)||(email=="SELECT")) {
                                $("#DDE_btn_sbutton").attr("disabled", "disabled");
                            }
                            else {
                                $("#DDE_btn_sbutton").removeAttr("disabled");
                            }
                            $('#'+errid).hide();
                        }
                    }
                }
                else
                {
                    $('#'+errid).hide();
                    var getid=[];
                    $('input:checkbox[name="DDE_chk_checkboxinc[]"]:checked').each(function() {
                        var checkgetid=$(this).attr('id');
                        getid.push(checkgetid.replace( /^\D+/g, ''))
                    });
                    var count=0;
                    for(var i=0;i<getid.length;i++)
                    {
                        var sdateid ="Dep_Exct_sdatetb"+getid[i];
                        var edateid ="Dep_Exct_edatetb"+getid[i];
                        var sd=$("#"+sdateid).val();
                        var ed=$("#"+edateid).val();
                        if(sd!="" && ed!="")
                        {
                            var sdateid ="Dep_Exct_sdatetb"+checkid;
                            var edateid ="Dep_Exct_edatetb"+checkid;
                            count=count+1;
                        }
                    }
                    if(count==(getid.length))
                    {
                        if(getid.length==0){
                            $('#DDE_btn_sbutton').hide();
                            $('#DDE_btn_rbutton').hide();
                        }
                        else{
                            $('#DDE_btn_sbutton').show();
                            $('#DDE_btn_rbutton').show();
                        }
                        $('#DDE_Emaillist').show();
                        $('#DDE_emailtable').show();
                    }
                    else
                    {
                        $('#DDE_btn_sbutton').hide();
                        $('#DDE_btn_rbutton').hide();
                        $('#DDE_Emaillist').hide();
                        $('#DDE_emailtable').hide();
                    }
                }
            });
        // SUBMIT BUTTOM VALIDATION  ....................
            $(document).on("change",'.submitvalidate', function (){
                var checkid =$(this).attr('id');
                var dd=$("#DDE_LB_Emaillist").val();
                var checkid=checkid.replace( /^\D+/g, '');
                if(DDE_flg_checkbox==0)
                    checkid=1;
                var sdateid ="Dep_Exct_sdatetb"+checkid;
                var edateid ="Dep_Exct_edatetb"+checkid;
                var sd=$("#"+sdateid).val();
                var ed=$("#"+edateid).val();
                if(($("#DDE_LB_Emaillist").val()=="SELECT")||($("#DDE_lb_unitselect").val()=="SELECT")||(($('input:checkbox[name="DDE_chk_checkboxinc[]"]').is(':checked')==false)&&(checkid>1))||($("#DDE_lb_customerselect").val()=="SELECT" ||sd==""||ed==""))
                {
                    $('#DDE_btn_sbutton').attr("disabled", "disabled");
                }
                else
                {
                    $("#DDE_btn_sbutton").show();
                    $("#DDE_btn_rbutton").show();
                    $('#DDE_btn_sbutton').removeAttr("disabled");
                }
            });
        // FAILURE FUNCTION
            function DDE_onFailuremsg(DDE_err)
            {
                $(".preloader").hide();
                if(DDE_err=="ScriptError: Failed to establish a database connection. Check connection string, username and password.")
                {
                    DDE_err="DB USERNAME/PWD WRONG, PLZ CHK UR CONFIG FILE FOR THE CREDENTIALS.";
                    $('#DDE_form').replaceWith('<center><label class="dberrormsg">'+DDE_err+'</label></center>');
                }
                else{
                    if(DDE_err=='ScriptError: No item with the given ID could be found, or you do not have permission to access it.')
                    {
                        show_msgbox("DEPOSIT DEDUCTION EXTRACTS",DDE_err,'error',false);
                    }
                    else {
                        var DDE_err=DDE_err.toString();
                        var match=DDE_err.search("Cannot find method getRange");
                        var matchClass=DDE_err.search("class");
                        if((match>-1)||(matchClass>-1)){
                            DDE_err=DDE_errorAarray[14].EMC_DATA;
                            var DDE_postion=$("#DDE_btn_sbutton").position();
                        }
                        show_msgbox("DEPOSIT DEDUCTION EXTRACTS",DDE_err,'error',false);
                    }
                }
            }
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>DEPOSIT DEDUCTION EXTRACTS</b></h4></div>
    <form id="DDE_form_errormsg">
        <div class="panel-body" id="dde_errorpanel" hidden>
            <fieldset>
                <div class="form-group" id="DDE_table_errormsg">
                </div>
            </fieldset>
        </div>
    </form>
    <form id="DD_Extractionform" name="DD_Extractionform" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div id="maintable">
                    <div class="form-group" id="DDE_monthselect">
                        <label class="col-sm-2">SELECT A MONTH <em>*</em></label>
                        <div class="col-sm-2"><select id='DDE_lb_monthselect' name="DDE_lb_monthselect" class="form-control"><option>SELECT</option></select></div>
                    </div>
                    <div class="form-group" id="DDE_unitselect">
                        <label class="col-sm-2">SELECT A UNIT <em>*</em></label>
                        <div class="col-sm-2"><select id='DDE_lb_unitselect' name="DDE_lb_unitselect" class="form-control"><option>SELECT</option></select></div>
                    </div>
                    <div class="form-group" id="DDE_customerselect">
                        <label class="col-sm-2">CUSTOMER NAME <em id='em'#>*</em></label>
                        <div class="col-sm-4"><select id='DDE_lb_customerselect' name="DDE_lb_customerselect" class="form-control"><option>SELECT</option></select></div>
                    </div>
                    <div class="form-group" id="DDE_radiotable" hidden>
                    </div>
                </div>
                <div id="DDE_recvertable" hidden>
                </div>
                <div id="DDE_emailtable" hidden>
                </div>
                <div class="col-sm-offset-1 col-sm-4">
                    <input class="maxbtn" type="button" id="DDE_btn_sbutton" value='EXTRACT' disabled/>
                    <input class="maxbtn" type="button" id="DDE_btn_rbutton" value="RESET"/>
                    <input type="hidden" name ="DDC_tb_hidecustid" id="DDC_tb_hidecustid"/>
                    <input type="hidden" name ="DDC_tb_hiderecverlength" id="DDC_tb_hiderecverlength"/>
                </div>
                <div class="form-group col-lg-12 errormsg errpadding" id="DDC_errmsgdata" hidden>
                </div>
                <div><input type='hidden' id="DDE_tb_recdate" name="DDE_tb_recdate"></div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>