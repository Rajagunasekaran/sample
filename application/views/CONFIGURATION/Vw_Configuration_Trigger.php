<!--********************************************TRIGGER*******************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 0.02- SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names AND active cc list in ver0.02-->
<!--VER 0.01-INITIAL VERSION-SD:11/05/2015 ED:12/05/2015 in ver0.01-->
<html>
<head>
    <?php require_once('application/libraries/EI_HDR.php'); ?>
</head>
<script>
    $(document).ready(function() {
        var controller_url="<?php echo base_url(); ?>" + '/index.php/CONFIGURATION/Ctrl_Configuration_Trigger/' ;
        $.ajax({
            type: "POST",
            url: controller_url+"TriggerConfiguration",
            success: function(data){
                var value_array=JSON.parse(data);
                for(var i=0;i<value_array.length;i++)
                {
                    var data=value_array[i];
                    if(data.TC_ID!=8 && data.TC_ID!=10 && data.TC_ID!=11 && data.TC_ID!=12 && data.TC_ID!=14)
                    {
                        $('#Triggername').append($('<option>').text(data.TC_DATA).attr('value', data.TC_ID));
                    }
                }
                $('.preloader').hide();
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
                $('.preloader').hide();
            }
        });
        $(document).on('change','#Triggername',function() {
            var tirgger=$('#Triggername').val();
            if(tirgger!='SELECT')
            {
                $("#Trigger_submitbutton").removeAttr("disabled");
            }
            else
            {
                $("#Trigger_submitbutton").attr("disabled", "disabled");
            }
        });
        $(document).on('click','#Trigger_submitbutton',function() {
            var Tirgger=$('#Triggername').val();
            $('.preloader').show();
            if(Tirgger==5)
            {
                $.ajax({
                    type: "POST",
                    data: {Triggernameid: Tirgger},
                    url: controller_url+"CSV_Updation",
                    success: function (data) {
                        var returnvalue = JSON.parse(data);
                        $('section').html(returnvalue);
                        show_msgbox("CSV UPDATION", returnvalue, "success", false);
                        $('.preloader').hide();
                        var value_array = JSON.parse(data);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                        $('.preloader').hide();
                    }
                });
            }
            if(Tirgger==2)
            {
                $.ajax({
                    type: "POST",
                    data: {Triggernameid: Tirgger},
                    url: controller_url+"Monthlypaymentreminder",
                    success: function (data) {
                        alert(data);
                        $('.preloader').hide();
                        var returnvalue = JSON.parse(data);
                        show_msgbox("MONTHLY PAYMENT REMINDER", returnvalue, "success", false);
                        $('.preloader').hide();
                        var value_array = JSON.parse(data);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                        $('.preloader').hide();
                    }
                });
            }
            if(Tirgger==1)
            {
                $.ajax({
                    type: "POST",
                    data: {Triggernameid: Tirgger},
                    url: controller_url+"Nonpaymentreminder",
                    success: function (data) {
                        alert(data);
                        $('.preloader').hide();
                        var returnvalue = JSON.parse(data);
                        show_msgbox("MONTHLY PAYMENT REMINDER", returnvalue, "success", false);
                        $('.preloader').hide();
                        var value_array = JSON.parse(data);
                    },
                    error: function (data) {
                        alert('error in getting' + JSON.stringify(data));
                        $('.preloader').hide();
                    }
                });
            }
        });
    });
    </script>

    <body>
    <div class="container">
        <div class="wrapper">
            <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif" /></div></div></div>
            <div class="row title text-center"><h4><b>TRIGGER</b></h4></div>
            <div class ='row content'>
            <form id="TriggerForm" class="form-horizontal" role="form">
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>TRIGGER NAME<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="Triggername" id="Triggername">
                                <OPTION value="SELECT">SELECT</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-lg-offset-2 col-lg-3">
                            <input type="button" id="Trigger_submitbutton" class="btn" value="RUN" disabled>
                        </div>
                    </div>
                    <div>
                        <section>

                        </section>
                    </div>
                </div>
            </form>
        </body>

