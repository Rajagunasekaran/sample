//common function for ss
function ssopen_byid(ssid){
    var ssbyid= SpreadsheetApp.openById(ssid);
    return ssbyid;
}
function ssopen_byid_getsheet(ssid){
    var ssgetsheet=SpreadsheetApp.openById(ssid).getSheets();
    return ssgetsheet;
}
function ssopen_byid_byname(ssid,sheetname){
    var ssbyname=SpreadsheetApp.openById(ssid).getSheetByName(sheetname);
    return ssbyname;
}
// get sheet names
function Extract_ssnames(DDE_currentfile_id) {
    var deductionsheets = ssopen_byid_getsheet(DDE_currentfile_id);
    var sheetarray =[];
    for (var i in deductionsheets){
        var sheetname =  deductionsheets[i].getSheetName();
        if(sheetname=='TEMPLATE' || sheetname =='PAYMENT HISTORY' || sheetname == 'SENDING EMAIL')continue;
        sheetarray.push(sheetname);
    }
    return sheetarray;
}
// get unit no from sheet
function Extract_unitno(shturl,selectedsheet){
    var deductionsheet =ssopen_byid_byname(shturl,selectedsheet)
    var unitdata= deductionsheet.getRange(1,1,deductionsheet.getLastRow(),1).getValues();
    var newarray = [];
    for (var i in unitdata) {
        unitdata[i];
        if(unitdata[i] == 'Unit No') {
            var k =parseFloat(i)+1;
            var sheetunitnumbr = deductionsheet.getRange(k,2,1,1).getValue();
            newarray.push(sheetunitnumbr);
        }
    }
    return newarray;
}
// get customer name for unit no
function Extract_customers(shturl,selectedunit,selectedsheet){
    var selectedunit=parseFloat(selectedunit);
    var deductionsheet = ssopen_byid_byname(shturl,selectedsheet);
    var data= deductionsheet.getRange(1,2,deductionsheet.getLastRow(),1).getValues();
    var cusname_array=[];
    for (var i in data) {
        data[i];
        if(data[i] == selectedunit){
            var k =parseInt(i)+2;
            var cusname = deductionsheet.getRange(k,2,1,1).getValue();
            cusname_array.push(cusname);
        }
    }
    return cusname_array;
}
// get customerid for cust name
function Extract_custid(shturl,selectedunit,selectedname,selectedsheet){
    var commentarray=[];
    var deductionsheet = ssopen_byid_byname(shturl,selectedsheet);
    var custname= deductionsheet.getRange(1,2,deductionsheet.getLastRow(),1).getValues();
    for (var i=0; i<=custname.length; i++) {
        custname[i];
        if((custname[i] == selectedunit)&&(custname[parseInt(i)+1] == selectedname)) {
            var custrow =parseInt(i)+2;
            var comment = deductionsheet.getRange(custrow,2,1,1).getNote();
            commentarray.push(comment);
            commentarray.sort();
        }
    }
    return commentarray;
}
// extract data for the recver date
function Extract_recver(shturl,selectedunit,selectedname,selectedsheet,getid,nocustid){
    var deductionsheet = ssopen_byid_byname(shturl,selectedsheet);
    var start_end_date=[];
    var custid_date=[];
    start_end_date= deductionsheet.getRange(1,2,deductionsheet.getLastRow(),1).getValues();
    custid_date= deductionsheet.getRange(1,2,deductionsheet.getLastRow(),1).getNotes();
    for(var j=0;j<custid_date.length;j++) {
        start_end_date.push(custid_date[j]);
    }
    var recversion =0;  var commentarray=[];  var multiarray=[];
    for ( var i=0; i<=start_end_date.length; i++)
    {
        start_end_date[i];
        if(parseInt(nocustid)=='1')
        {
            if((start_end_date[i] == selectedunit)&&( start_end_date[parseInt(i)+1] == selectedname)) //DATA MATCHES NAME AND UNIT NUMBR
            {
                var sdaterow =parseInt(i)+3;
                var edaterow=parseInt(i)+4;
                var sdate = deductionsheet.getRange(sdaterow,2,1,1).getValue();//sdaterow
                var edate = deductionsheet.getRange(edaterow,2,1,1).getValue();//edaterow
                var comment = deductionsheet.getRange(sdaterow,2,1,1).getNote();//sdaterow
                commentarray.push(comment);
                var singlearray =[];
                singlearray.push({key:comment,startdate:sdate,enddate:edate});
                multiarray.push(singlearray);
                recversion++
            }
        }
        else
        {
            if((start_end_date[i] == selectedunit)&&(start_end_date[parseInt(i)+1] == selectedname)&&(start_end_date[parseInt(i)+1] == getid)) // DATA MATCHES NAME AND UNIT NUMBR
            {
                var sdaterow =parseInt(i)+3;
                var edaterow=parseInt(i)+4;
                var sdate = deductionsheet.getRange(sdaterow,2,1,1).getValue();
                var edate = deductionsheet.getRange(edaterow,2,1,1).getValue();
                var comment = deductionsheet.getRange(sdaterow,2,1,1).getNode();
                commentarray.push(comment);
                var singlearray =[];
                singlearray.push({key:comment,startdate:sdate,enddate:edate});
                multiarray.push(singlearray);
                recversion++
            }
        }
    }
    var unique_recver =uniqueObj(multiarray);
    var recleng=commentarray.length;
    var recveremail={'unique_recver':unique_recver}
    return recveremail;
}
//FUNCTION FOR UNIQUE OBJECT ARRAY
function uniqueObj(array){
    var unique = {};
    var distinct = [];
    for( var i in array ){
        if( typeof(unique[array[i][0].key]) == "undefined"){
            distinct.push(array[i]);
        }
        unique[array[i][0].key] = 0;
    }
    return distinct;
}
// extrac all data for selected recver
function Extract_submit(shturl,selectedunit,customername,checkarray,selectedsheet,customeridname){
    try{var leaseperiod=checkarray;
        var ss = ssopen_byid(shturl);
        var deductionsheet =ss.getSheetByName(selectedsheet);
        var start_end_date= deductionsheet.getRange(1,2,deductionsheet.getLastRow(),1).getValues();
        var recversion =0;  var commentarray=[];   var rowno=[];  var advancedArgs=[];
        for (var i in start_end_date) {
            start_end_date[i];
            if((start_end_date[i] == selectedunit)&&(start_end_date[parseInt(i)+1] == customername)){ //DATA MATCHES NAME AND UNIT NUMBR
                var sdaterow =parseInt(i)+3;
                var edaterow=parseInt(i)+4;
                var sdate = deductionsheet.getRange(sdaterow,2,1,1).getValue();
                var edate = deductionsheet.getRange(edaterow,2,1,1).getValue();
                var comment = deductionsheet.getRange(sdaterow,2,1,1).getNote();
                var cmt=sdaterow;
                rowno.push(cmt);
                commentarray.push(comment);
                recversion++;
            }
        }
        var checkarray=checkarray.split('^^');
        for(var k=0; k<checkarray.length;k++){
            for(var s=0; s<commentarray.length;s++){
                if((checkarray[k]==undefined)||(checkarray[k]=='')||(commentarray[k]==undefined)||(commentarray[s]==undefined)) continue;
                if(selectedsheet!='DECEMBER'||selectedsheet!='NOVEMBER'){
                    var  cgcheckarray = checkarray[k].replace('LEAST_PERIOD', 'REC_VER');
                }
                if(cgcheckarray==commentarray[s]){
                    var getstartrow=rowno[s];
                    var startrow =getstartrow-1; // FIRST ROW OF EXTRACTING DATA
                }
            }
            var refund_row = deductionsheet.getRange(1,1,deductionsheet.getLastRow(),1).getValues();
            for (var m=startrow; m<=deductionsheet.getLastRow(); m++){
                if(refund_row[m] == 'REFUND'){
                    var endrow =parseInt(m)+2; // LAST ROW OF EXTRACTING DATA
                    break;
                }
            }
            var numberofrow = endrow- startrow;  // CALCULATING NUMBER OF ROWS TO EXTRACT
            var deductionsheet = ss.getSheetByName(selectedsheet);
            var mailsheet = ss.getSheetByName('TEMPLATE');
            if(mailsheet==null){
                return 'DDC_flag_nosheet';
            }
            var headingrow= deductionsheet.getRange(1,1,1,4);
            var customerdata= deductionsheet.getRange(startrow,1,numberofrow,4);
            var customerdatacolor= deductionsheet.getRange(startrow,1,numberofrow,4).getBackgroundColors();
            //NEW SCRIPT FOR FINDING SENDING EMAIL PART
            var DDE_range=mailsheet.getRange(1,1,mailsheet.getLastRow(),4).getValues();
            for(var i in DDE_range){
                for(var j=0;j<DDE_range[i].length;j++){
                    var DDE_location_name=DDE_range[i][j];
                    if(DDE_location_name=='SENDING MAIL'){
                        var DDE_location=i
                    }
                }
            }
            var position=parseInt(DDE_location)+parseInt(5);
            mailsheet.getRange(position,1,mailsheet.getLastRow(),4).clear();
            mailsheet.deleteRows(position,mailsheet.getLastRow());
            var maildata= mailsheet.getRange(position,1,numberofrow,4);
            customerdata.copyTo(maildata); //maildata.
            customerdata=null;
            var unitnumbsize =selectedunit.toString().length;
            if(unitnumbsize<4){
                selectedunit='0'+selectedunit;
            }
            var sheetName = "sheetname";
            var newSpreadsheet = SpreadsheetApp.create("TEMPORARY SHEET");
            var mailsheet = ss.getSheetByName('TEMPLATE');
            mailsheet.copyTo(newSpreadsheet);
            var DDE_getTemplateSheet = newSpreadsheet.getSheetByName('Copy of TEMPLATE');
            DDE_getTemplateSheet.getRange(2,1).setValue(leaseperiod);
            DDE_getTemplateSheet.clearNotes();
            var DDE_row=parseInt(DDE_location)+parseInt(2);
            DDE_getTemplateSheet.getRange(1,1,DDE_row,4).clear();
            DDE_getTemplateSheet.deleteRows(1,DDE_row);
            newSpreadsheet.getSheetByName('sheet1').activate();
            var DDC_newspread_ssid=newSpreadsheet.getId();
            newSpreadsheet.deleteActiveSheet();
            var contents = DriveApp.getFileById(newSpreadsheet.getId()).getAs('application/pdf').getBytes();
            advancedArgs.push(contents);
      }
        return advancedArgs;
    }
    catch(err){Logger.log(err)
        return err;
    }
}
function deleteTemporarySheet(){
    try{
        var DDE_files = DriveApp.getFiles();
        while (DDE_files.hasNext()) {
            var DDE_file = DDE_files.next();
            if(DDE_file.getName()=="TEMPORARY SHEET"){
                DDE_file.setTrashed(true)
            }
        }return 1;
    }catch(err){
        return err;
    }}