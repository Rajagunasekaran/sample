<?php
require_once "EI_HDR.php";
?>
<script>
    $(document).ready(function(){
        var Model_Errormsg;
        var Allmodels;
        var allmodelsarray=[];
        $(".autosize").doValidation({rule:'general',prop:{whitespace:true,autosize:true}});
        $.ajax({
            type: "POST",
            url: '/index.php/Ctrl_Ocbc_Model_Entry_Search_Update/Model_initialdatas',
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
     //*****************Common Function ***************//
     function InitialDataLoad(modeldetails)
     {
         var Model_Tabledata="<table id='Model_Datatable' border=1 cellspacing='0' data-class='table'  class=' srcresult table' style='width:1080px'>";
         Model_Tabledata+="<thead class='headercolor'><tr class='head' style='text-align:center'>";
         Model_Tabledata+="<th style='text-align:center;vertical-align: top'>UPDATE / DELETE</th>";
         Model_Tabledata+="<th style='text-align:center;vertical-align: top'>MODEL NAME</th>";
         Model_Tabledata+="<th style='text-align:center;vertical-align: top'>OBSOLETE</th>";
         Model_Tabledata+="<th style='text-align:center;vertical-align: top'>USERSTAMP</th>";
         Model_Tabledata+="<th style='text-align:center;vertical-align: top'>TIMESTAMP</th>";
         Model_Tabledata+="</tr></thead><tbody>";
         for(var i=0;i<modeldetails.length;i++)
         {
             var rowid=modeldetails[i].BTM_ID;
             var DeleteId='Delete_'+rowid;
             if(modeldetails[i].BTM_OBSOLETE==null){var obsolete=''}else{obsolete=modeldetails[i].BTM_OBSOLETE};
             Model_Tabledata+='<tr style="text-align: center !important;vertical-align: middle">' +
                 "<td style='width:100px !important;'><div class='col-lg-1'><div class='col-lg-1'><span style='display: block;color:red' class='glyphicon glyphicon-trash Model_removebutton' id="+DeleteId+"></div></td>" +
                 "<td style='width:500px !important;text-align: left !important' class='ModelEdit' id=Modelname_"+rowid+">"+modeldetails[i].BTM_DATA+"</td>" +
                 "<td style='width:100px !important;text-align: left !important' class='ModelEdit' id=Obsoletechk_"+rowid+">"+obsolete+"</td>" +
                 "<td style='width:250px !important;text-align: left !important'>"+modeldetails[i].ULD_LOGINID+"</td>" +
                 "<td style='width:150px !important;vertical-align: middle'>"+modeldetails[i].BTM_TIME_STAMP+"</td></tr>";
         }
         Model_Tabledata+="</body>";
         $('section').html(Model_Tabledata);
         $('#Model_Search_DataTable').show();
         $('#Model_Datatable').DataTable( {
             "aaSorting": [],
             "pageLength": 10,
             "sPaginationType":"full_numbers"
         });
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
                    url: '/index.php/Ctrl_Ocbc_Model_Entry_Search_Update/ModelnameUpdate',
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
                url: '/index.php/Ctrl_Ocbc_Model_Entry_Search_Update/ModelnameDelete',
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
            var modelname=$('#EntryModelName').val();
            $.ajax({
                type: "POST",
                url: '/index.php/Ctrl_Ocbc_Model_Entry_Search_Update/ModelnameInsert',
                data:{Data:modelname},
                success: function(data){
                var valuesarray=JSON.parse(data);
                  if(valuesarray[0]==true)
                 {
                     show_msgbox("MODEL ENTRY / SEARCH/UPDATE",Model_Errormsg[1].EMC_DATA,"success",false);
                 }
                 else
                 {
                     show_msgbox("MODEL ENTRY / SEARCH/UPDATE",Model_Errormsg[3].EMC_DATA,"success",false);
                 }
                    allmodelsarray=[];
                    for(var k=0;k<valuesarray[1].length;k++)
                    {
                        allmodelsarray.push(valuesarray[1][k].BTM_DATA)
                    }
                  InitialDataLoad(valuesarray[1]);
                    $("#Model_SearchformDiv").html('');
                    $('#AddNewModel').show();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').show();
                }
            });
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
                    <section>

                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
</body>