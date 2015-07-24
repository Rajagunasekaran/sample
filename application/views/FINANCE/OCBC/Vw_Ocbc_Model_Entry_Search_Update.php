<!--********************************************MODEL ENTRY AND SEARCH UPDATE******************************************-->
<!--*******************************************FILE DESCRIPTION***************************************************-->
<!--VER 6.6 -SD:05/06/2015 ED:05/06/2015 GETTING HEADER FILE FROM LIB-->
<!--VER 0.02- SD:04/06/2015 ED:04/06/2015,changed Controller Model and View names t in ver0.02-->
<!--VER 0.01-INITIAL VERSION-SD:23/05/2015 ED:23/05/2015 in ver0.01-->
<?php require_once('application/libraries/EI_HDR.php'); ?>
<script>
    $(document).ready(function(){
//        $('#example').html("<thead><tr><th>First name</th><th>Last name</th><th>Position</th><th>Office</th><th>Age</th><th>Start date</th><th>Salary</th>"
//        +"<th>Extn.</th>"
//            +"<th>E-mail</th>"
//            +"<th>Extn.</th>"
//            +"<th>E-mail</th>"
//            +"</tr>"
//            +"</thead>"
//
//            +"<tbody>"
//            +"<tr>"
//            +"<td>Tiger</td>"
//            +"<td>Nixon</td>"
//            +"<td>System Architect</td>"
//            +"<td>Edinburgh</td>"
//            +"<td>61</td>"
//            +"<td>2011/04/25</td>"
//            +"<td>$320,800</td>"
//            +"<td>5421</td>"
//            +"<td>t.nixon@datatables.net</td>"
//            +"<td>5421</td>"
//            +"<td>t.nixon@datatables.net</td>"
//            +"</tr>"
//            +"<tr>"
//            +"<td>Garrett</td>"
//            +"<td>Winters</td>"
//            +"<td>Accountant</td>"
//            +"<td>Tokyo</td>"
//            +"<td>63</td>"
//            +"<td>2011/07/25</td>"
//            +"<td>$170,750</td>"
//            +"<td>8422</td>"
//            +"<td>g.winters@datatables.net</td>"
//            +"<td>5421</td>"
//            +"<td>t.nixon@datatables.net</td>"
//            +"</tr>"
//            +"<tr>"
//            +"<td>Ashton</td>"
//            +"<td>Cox</td>"
//            +"<td>Junior Technical Author</td>"
//            +"<td>San Francisco</td>"
//            +"<td>66</td>"
//            +"<td>2009/01/12</td>"
//            +"<td>$86,000</td>"
//            +"<td>1562</td>"
//            +"<td>a.cox@datatables.net</td>"
//            +"<td>5421</td>"
//            +"<td>t.nixon@datatables.net</td>"
//            +"</tr>"
//            +"<tr>"
//            +"<td>Cedric</td>"
//            +"<td>Kelly</td>"
//            +"<td>Senior Javascript Developer</td>"
//            +"<td>Edinburgh</td>"
//            +"<td>22</td>"
//            +"<td>2012/03/29</td>"
//            +"<td>$433,060</td>"
//            +"<td>6224</td>"
//            +"<td>c.kelly@datatables.net</td>"
//            +"<td>5421</td>"
//            +"<td>t.nixon@datatables.net</td>"
//            +"</tr></tbody>")
//        $('#example').DataTable({
//                "sDom":"Rlfrtip",
//                "deferRender":    true,
//                "dom":            "frtiS",
//                "scrollY": 200,
//                "scrollX": true,
//                "scrollCollapse": true
//            }
//        );
//        $.extend( $.fn.dataTable.defaults, {
//            responsive: true
//        } );
        $('#spacewidth').height('0%');
        var Model_Errormsg;
        var Allmodels;
        var allmodelsarray=[];
        var controller_url="<?php echo base_url(); ?>" + '/index.php/FINANCE/OCBC/Ctrl_Ocbc_Model_Entry_Search_Update/' ;
        $(".autosize").doValidation({rule:'general',prop:{whitespace:true,autosize:true}});
        $.ajax({
            type: "POST",
            url: controller_url+"Model_initialdatas",
            data:{ErrorList:'3,4,5'},
            success: function(data){
                $('.preloader').hide();
                var value_array=JSON.parse(data);
                Model_Errormsg=value_array[0];
                Allmodels=value_array[1];
                for(var k=0;k<Allmodels.length;k++)
                {
                    allmodelsarray.push(Allmodels[k].BTM_DATA)
                }
                var modeldetails=value_array[2];
                InitialDataLoad(modeldetails);
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
                $('.preloader').hide();
            }
        });
        function FormTable_DateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        //FUNCTION FOR SORTING
        function sorting(){

            jQuery.fn.dataTableExt.oSort['uk_timestp-asc']  = function(a,b) {
                var x = new Date( Date.parse(FormTable_DateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(FormTable_DateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? -1 : ((x > y) ?  1 : 0));
            };
            jQuery.fn.dataTableExt.oSort['uk_timestp-desc'] = function(a,b) {
                var x = new Date( Date.parse(FormTable_DateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
                var y = new Date( Date.parse(FormTable_DateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
                return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
            };
        }
        //*****************Common Function ***************//
        function InitialDataLoad(modeldetails)
        {
//            var Model_Tabledata='<table style="width:1200px" id="Model_Datatable" border="1" cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr>';
//            Model_Tabledata+="<th style='width: 102.767px !important;text-align:center;vertical-align: top'>UPDATE / DELETE</th>";
//            Model_Tabledata+="<th style='text-align:center;vertical-align: top'>MODEL NAME</th>";
//            Model_Tabledata+="<th style='text-align:center;vertical-align: top'>OBSOLETE</th>";
//            Model_Tabledata+="<th style='text-align:center;vertical-align: top'>USERSTAMP</th>";
//            Model_Tabledata+="<th style='text-align:center;vertical-align: top' class='uk-timestp-column'>TIMESTAMP</th>";
//            Model_Tabledata+="</tr></thead><tbody>";
//            for(var i=0;i<modeldetails.length;i++)
//            {
//                var rowid=modeldetails[i].BTM_ID;
//                var DeleteId='Delete_'+rowid;
//                if(modeldetails[i].BTM_OBSOLETE==null){var obsolete=''}else{obsolete=modeldetails[i].BTM_OBSOLETE};
//                Model_Tabledata+='<tr style="text-align: center !important;vertical-align: middle">' +
//                    "<td style='width: 102.767px !important;'><div class='col-lg-1'><div class='col-lg-1'><span style='display: block;color:red' class='glyphicon glyphicon-trash Model_removebutton' id="+DeleteId+"></div></td>" +
//                    "<td style='width:300px !important;text-align: left !important' class='ModelEdit' id=Modelname_"+rowid+">"+modeldetails[i].BTM_DATA+"</td>" +
//                    "<td style='width:100px !important;text-align: left !important' class='ModelEdit' id=Obsoletechk_"+rowid+">"+obsolete+"</td>" +
//                    "<td style='width:250px !important;text-align: left !important'>"+modeldetails[i].ULD_LOGINID+"</td>" +
//                    "<td style='width:150px !important;vertical-align: middle'>"+modeldetails[i].BTM_TIME_STAMP+"</td></tr>";
//            }
//            Model_Tabledata+="</body>";
//            $('section').html(Model_Tabledata);
            var Model_Tabledata='<table id="Model_Datatable" class="nowrap srcresult" cellspacing="0" width="100%"><thead><tr>';
            Model_Tabledata+="<th >UPDATE / DELETE</th>";
            Model_Tabledata+="<th >MODEL NAME</th>";
            Model_Tabledata+="<th >OBSOLETE</th>";
            Model_Tabledata+="<th >USERSTAMP</th>";
            Model_Tabledata+="<th  class='uk-timestp-column'>TIMESTAMP</th>";
            Model_Tabledata+="</tr></thead><tbody>";
            for(var i=0;i<modeldetails.length;i++)
            {
                var rowid=modeldetails[i].BTM_ID;
                var DeleteId='Delete_'+rowid;
                if(modeldetails[i].BTM_OBSOLETE==null){var obsolete=''}else{obsolete=modeldetails[i].BTM_OBSOLETE};
                Model_Tabledata+='<tr >' +
                    "<td ><div class='col-lg-1'><div class='col-lg-1'><span style='display: block;color:red' class='glyphicon glyphicon-trash Model_removebutton' id="+DeleteId+"></div></td>" +
                    "<td  class='ModelEdit' id=Modelname_"+rowid+">"+modeldetails[i].BTM_DATA+"</td>" +
                    "<td class='ModelEdit' id=Obsoletechk_"+rowid+">"+obsolete+"</td>" +
                    "<td >"+modeldetails[i].ULD_LOGINID+"</td>" +
                    "<td >"+modeldetails[i].BTM_TIME_STAMP+"</td></tr>";
            }
            Model_Tabledata+="</tbody></table>";
            $('section').html(Model_Tabledata);
            $('#Model_Search_DataTable').show();
            $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            var oTable=$('#Model_Datatable').DataTable( {
                "aaSorting": [],
//                "sDom":"Rlfrtip",
//                "deferRender":    true,
//                "scrollY": 200,
//                "scrollX": 500,
//                "scrollCollapse": true,
                "pageLength": 10,
                "sPaginationType":"full_numbers",
                "aoColumnDefs" : [{ "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ],
                "sDom":"Rlfrtip",
                "deferRender":    true,
                "dom":            "frtiS",
                "scrollY": 200,
                "scrollX": true,
                "scrollCollapse": true
            });
            if ( $.browser.webkit ) {
                setTimeout(function () {
                    oTable.fnAdjustColumnSizing();
                }, 10);
            }
            sorting();
        }
        var combineid;
        var previous_id;
        var cval;
        var ifcondition;
        $(document).on('click','.ModelEdit',function() {
            if(previous_id!=undefined)
            {
                $('#'+previous_id).replaceWith("<td align='left' class='ModelEdit' id='"+previous_id+"' >"+cval+"</td>");
            }
            var cid = $(this).attr('id');
            var id=cid.split('_');
            ifcondition=id[0];
            combineid=id[1];
            previous_id=cid;
            cval = $(this).text();
            if(ifcondition=='Modelname')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+previous_id+"'><input type='text' class='form-control ModelUpdate autosize' id='Model_Name' maxlength='50' value='"+cval+"'></td>");
                $(".autosize").doValidation({rule:'general',prop:{whitespace:true,autosize:true}});
            }
            if(ifcondition=='Obsoletechk')
            {
                $('#'+cid).replaceWith("<td  class='new' id='"+previous_id+"'><input type='checkbox' id='obsoleteflag' name='obsolete' class='form-control ModelUpdate'></td>");
                if(cval=='X')
                {
                    $('input:checkbox[name=obsolete]').attr("checked",true);
                }
            }
        });
        $(document).on('change','.ModelUpdate',function() {
            $('.preloader').show();
            if(ifcondition=='Modelname')
            {
                var modelname=$('#Model_Name').val();
                for(var i=0;i<allmodelsarray.length;i++)
                {
                    if(allmodelsarray[i]==modelname)
                    {
                        var flag=1;
                        show_msgbox("MODEL ENTRY / SEARCH/UPDATE",'MODEL NAME ALREADY EXSISTS',"success",false);
                        break; }
                    else
                    { flag=0; }
                }
                var data={Option:'Model',Data:modelname,Rowid:combineid};
            }
            if(ifcondition=='Obsoletechk')
            {
                flag=0;
                var Obsolete=$('#obsoleteflag').is(":checked");
                if(Obsolete==true){var obsflag='X'}else{obsflag=''}
                var data={Option:'Obsolete',Data:obsflag,Rowid:combineid};
            }

            if(flag==0)
            {
                $.ajax({
                    type: "POST",
                    url: controller_url+"ModelnameUpdate",
                    data:data,
                    success: function(data){
                        var values_array=JSON.parse(data);
                        allmodelsarray=[];

                        for(var k=0;k<values_array[0].length;k++)
                        {
                            var data=values_array[0][k];
                            allmodelsarray.push(data.BTM_DATA)
                        }
                        previous_id=undefined;
                        InitialDataLoad(values_array[1]);
                        $('.preloader').hide();
                        show_msgbox("MODEL ENTRY / SEARCH/UPDATE",Model_Errormsg[1].EMC_DATA,"success",false);
                    },
                    error: function(data){
                        alert('error in getting'+JSON.stringify(data));

                    }
                });
            }
        });
        $(document).on('click','.Model_removebutton',function() {
            $('.preloader').show();
            var cid = $(this).attr('id');
            var id=cid.split('_');
            var Rowid=id[1];
            $.ajax({
                type: "POST",
                url: controller_url+"ModelnameDelete",
                data:{Data:Rowid},
                success: function(data){
                    var value_array=JSON.parse(data);
                    if(value_array[1]=='UPDATED')
                    {
                        show_msgbox("MODEL ENTRY / SEARCH/UPDATE","SELECTED MODELNAME USED IN BANK TRANSFER TABLE,SO CAN'T BE DELETED AND UPDATED X IN OBSOLETE","success",false);
                    }
                    else
                    {
                        show_msgbox("MODEL ENTRY / SEARCH/UPDATE",Model_Errormsg[2].EMC_DATA,"success",false);
                    }
                    InitialDataLoad(value_array[0]);
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('click','#AddNewModel',function() {
            var appenddata='<div class="row form-group"><div class="col-md-3"><label>MODEL NAME<span class="labelrequired"><em>*</em></span></label>';
            appenddata+='</div>';
            appenddata+='<div class="col-md-3"><input class="form-control autosize" name="EntryModelName" maxlength="50" required id="EntryModelName"/>';
            appenddata+='</div>';
            appenddata+='<div class="col-md-3"><div><input type="button" class="btn" value="ADD" id="AddModelname" disabled></div></div>';
            $("#Model_SearchformDiv").html(appenddata);
            $('#AddNewModel').hide();
            $(".autosize").doValidation({rule:'general',prop:{whitespace:true,autosize:true}});
        });
        $(document).on('change blur','#EntryModelName',function() {
            var modelname=$('#EntryModelName').val();
            for(var i=0;i<allmodelsarray.length;i++)
            {
                if(allmodelsarray[i]==modelname)
                {
                    show_msgbox("MODEL ENTRY / SEARCH/UPDATE",'MODEL NAME ALREADY EXSISTS',"success",false);
                    $("#AddModelname").attr("disabled", "disabled");
                    break;
                }
                else
                {
                    $('#AddModelname').removeAttr('disabled');
                }
            }
        });
        $(document).on('click','#AddModelname',function() {
            $('.preloader').show();
            var modelname=$('#EntryModelName').val();
            $.ajax({
                type: "POST",
                url: controller_url+"ModelnameInsert",
                data:{Data:modelname},
                success: function(data){
                    var valuesarray=JSON.parse(data);
                    if(valuesarray[0]==true)
                    {

                        show_msgbox("MODEL ENTRY / SEARCH/UPDATE",Model_Errormsg[0].EMC_DATA,"success",false);
                    }
                    else
                    {
                        show_msgbox("MODEL ENTRY / SEARCH/UPDATE",valuesarray[0],"success",false);
                    }
                    allmodelsarray=[];
                    for(var k=0;k<valuesarray[1].length;k++)
                    {
                        allmodelsarray.push(valuesarray[1][k].BTM_DATA)
                    }
                    InitialDataLoad(valuesarray[1]);
                    $("#Model_SearchformDiv").html('');
                    $('#AddNewModel').show();
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
            });
        });
        $(document).on('click','#Model_btn_pdf',function(){
            var Header="BANK TT MODEL DETAILS";
            var pdfurl=document.location.href='<?php echo site_url('FINANCE/OCBC/Ctrl_Ocbc_Model_Entry_Search_Update/ModelPdfCreation')?>?Header='+Header;
        });
    });
</script>
<body>
<div class="container">
    <div class="wrapper">
        <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
        <div class="row title text-center"><h4><b>MODEL ENTRY / SEARCH/UPDATE</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <div id="Model_SearchformDiv">
                </div>
                <div id="Model_Search_DataTable" class="table-responsive" hidden>
                    <div><input type="button" class="maxbtn" value="ADD MODEL" id="AddNewModel"></div>
                    <h4 style="color:#498af3;" id="tableheader"></h4>
                    <input type="button" id="Model_btn_pdf" class="btnpdf" value="PDF">
                    <section>

                    </section>
                </div>
            </div>
        </div>
    </div>
    <!--    <table id="example" class="display nowrap" cellspacing="0" width="100%">-->


</div>
</body>