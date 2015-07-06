<!--********************************************OUTSTANDING PAYEES LIST*******************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 0.02- SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names AND active cc list in ver0.02-->
<!--VER 0.01-INITIAL VERSION-SD:11/05/2015 ED:12/05/2015 in ver0.01-->
<html>
<head>
    <?php require_once('application/libraries/EI_HDR.php'); ?>
</head>
<script>
    $(document).ready(function() {
        var controller_url="<?php echo base_url(); ?>" + '/index.php/FINANCE/FINANCE/Ctrl_Finance_Outstanding_Payee_list/' ;
        $('#spacewidth').height('0%');
        var Message;
        $.ajax({
            type: "POST",
            url: controller_url+"ProfileEmailId",
            data:{"ErrorList":'6'},
            success: function(data){
                var value_array=JSON.parse(data);
                $('.preloader').hide();
                Message=value_array[1];
                if(value_array[0].lengt!=0)
                {
                    var options ='<option value="SELECT">SELECT</option>';
                    for (var i = 0; i < value_array[0].length; i++)
                    {
                        var data=value_array[0][i];
                        options += '<option value="'+data+'">' + data+ '</option>';
                    }
                    $('#FIN_OPL_lb_mailid').html(options);
                    $('#Form_ErrorMessage').html('');
                }
                else
                {
                    var appeneddata='<h4 class="errormsg">'+Message[0].EMC_DATA+'</h4>';
                    $('#Form_ErrorMessage').html(appeneddata);
                    $('#FIN_OPL_outstanding_form').hide();
                }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });

//************************FORM VALIDATION FUNCTION START******************************//
        $('#FIN_OPL_outstanding_form').change(function(){
            FIN_OPL_formvalidation()
        });
        function FIN_OPL_formvalidation()
        {
            if($("#FIN_OPL_db_period").val()==""||($('input:radio[name=Radio]').is(':checked')==false)||($("#FIN_OPL_lb_mailid").val()=="SELECT"))
            {
                $("#FIN_OPL_btn_save").attr("disabled", "disabled");
            }
            else
            {
                $("#FIN_OPL_btn_save").removeAttr("disabled");
            }
        }
//************************FORM VALIDATION FUNCTION END******************************//
//************************FOR PERIOD DATE PICKER FUNCTION START******************************//
        $("#FIN_OPL_db_period").datepicker(
            {
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM-yy',
                onClose: function(dateText, inst) {
                    var month =inst.selectedMonth;
                    var year = inst.selectedYear;
                    $(this).datepicker('setDate', new Date(year, month, 1));
                    FIN_OPL_formvalidation();
                }
            });
        $('#FIN_OPL_db_period').datepicker("option","maxDate",new Date());
        $('#FIN_OPL_db_period').datepicker("option","minDate",new Date(2010,00));
        //************************FOR PERIOD DATE PICKER FUNCTION START******************************//
        //************************FORM RESET FUNCTION START******************************//
        $('#FIN_OPL_btn_reset').click(function(){
            oplreset();
        });
        function oplreset()
        {
            $("#FIN_OPL_radio_outstanding").attr('checked',false);
            $("#FIN_OPL_radio_active").attr('checked', false);
            $("#FIN_OPL_lb_mailid")[0].selectedIndex = 0;
            $('#FIN_OPL_outstanding_form').find('input[type=text]').val('');
            $("#FIN_OPL_btn_save").attr("disabled", "disabled");
        }
// //************************FORM RESET FUNCTION START******************************//
        $(document).on('click','#FIN_OPL_btn_save',function(){
            $('.preloader').show();
            var FormElements=$('#FIN_OPL_outstanding_form').serialize();
            $.ajax({
                type: "POST",
                url: controller_url+"FIN_OPL_opllist",
                data:FormElements,
                success: function(data){
                    $('.preloader').hide();
                    if(data=='opllist')
                    {
                        show_msgbox("OUTSTANDING PAYEES LIST",'EMAIL SENT WITH THE CURRENT OUTSTANDING PAYEES LIST',"success",false);
                    }
                    else if(data=='emptylist')
                    {
                        show_msgbox("OUTSTANDING PAYEES LIST",'EMAIL LIST EMPTY',"success",false);
                    }
                    else if(data=='ACTIVECCLIST')
                    {
                        show_msgbox("OUTSTANDING PAYEES LIST",'EMAIL SENT WITH THE CURRENT ACTIVE CUSTOMER LIST',"success",false);
                    }
                    else
                    {
                        show_msgbox("OUTSTANDING PAYEES LIST",data,"success",false);
                    }
                    oplreset();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        });
    });
</script>
<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>OUTSTANDING PAYEES LIST</b></h4></div>
        <div class ='row content'>
            <div id="Form_ErrorMessage">

            </div>
            <form id="FIN_OPL_outstanding_form" class="form-horizontal" role="form">
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>SELECT THE OPTION</label>
                        </div>
                        <div class="col-md-6">
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <input type="radio" name="Radio" id='FIN_OPL_radio_outstanding'  value="OPL_list"><label id="FIN_OPL_lbl_outstanding" >OUTSTANDING PAYEE LIST</label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <input type="radio"  name="Radio" id='FIN_OPL_radio_active' value="option2"><label id="FIN_OPL_lbl_active">ACTIVE CUSTOMER LIST</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>FOR PERIOD </label>
                        </div>
                        <div class="col-md-9">
                             <input type="text" class="datemandtry form-control" name="FIN_OPL_db_period" id="FIN_OPL_db_period"  placeholder="For Period" style="width:150px;">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>EMAIL ID<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" id="FIN_OPL_lb_mailid"  name="FIN_OPL_lb_mailid">
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-lg-offset-2 col-lg-3">
                            <input type="button" class="btn" name="FIN_OPL_btn_save" id="FIN_OPL_btn_save" disabled value="SUBMIT">         <input type="button" class="btn" name="FIN_OPL_btn_reset" id="FIN_OPL_btn_reset"  value="RESET">
                        </div>
                    </div>
                    <div>
                        <section>

                        </section>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->