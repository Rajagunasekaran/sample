function Active_Customer_List(customerdetails) {
    var sheetname=customerdetails.period;
    var spreadsheetid=customerdetails.Fileid;
    var FIN_ACT_newspread=SpreadsheetApp.openById(spreadsheetid);
    var FIN_ACT_newSheet = FIN_ACT_newspread.getActiveSheet().setName(sheetname);
    var FIN_ACT_url=FIN_ACT_newspread.getUrl();
    var header=customerdetails.header;
    var Rows=customerdetails.Rows;
    var SortRows=customerdetails.SortRows;
    var abc=Rows+'//'+SortRows;
    for(var i=0;i<1;i++)
    {
        var FIN_ACT_counter =FIN_ACT_newSheet.getLastRow()+1;
        var headersplit=header.split(',');
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,1).setValue(headersplit[0]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,2).setValue(headersplit[1]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,3).setValue(headersplit[2]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,4).setValue(headersplit[3]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,5).setValue(headersplit[4]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,6).setValue(headersplit[5]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,7).setValue(headersplit[6]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,8).setValue(headersplit[7]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,9).setValue(headersplit[8]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,10).setValue(headersplit[9]);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,11).setValue(headersplit[10]);
        FIN_ACT_newSheet.setFrozenRows(1);
        FIN_ACT_newSheet.getRange(1, 1, 1, FIN_ACT_newSheet.getLastColumn()).setBackground('#498af3').setFontColor('white').setFontSize(12).setFontStyle('BOLD');
    }
    for(var i=0;i<Rows;i++)
    {
        var FIN_ACT_activecustomer_arraylist=customerdetails['data'+i];
        var FIN_ACT_counter =FIN_ACT_newSheet.getLastRow()+1;
        var FIN_ACT_value=FIN_ACT_activecustomer_arraylist;
        var FIN_ACT_value1=FIN_ACT_value.split('!~');
        var FIN_ACT_unitvalue="'"+FIN_ACT_value1[0];
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,1).setValue(FIN_ACT_unitvalue);
        FIN_ACT_newSheet.setColumnWidth(1, 40)
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,2).setValue(FIN_ACT_value1[1]);
        FIN_ACT_newSheet.setColumnWidth(2, 300);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,3).setValue(FIN_ACT_value1[2]);
        FIN_ACT_newSheet.setColumnWidth(3, 100);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,4).setValue(FIN_ACT_value1[3]);
        FIN_ACT_newSheet.setColumnWidth(4, 80);
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,5).setValue(FIN_ACT_value1[4]);
        if(FIN_ACT_value1[5]=='null')
        {
            FIN_ACT_value1[5]="";
        }
        FIN_ACT_newSheet.setColumnWidth(5, 60)
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,6).setValue(FIN_ACT_value1[5]);
        if(FIN_ACT_value1[6]=='null')
        {
            FIN_ACT_value1[6]="";
        }
        FIN_ACT_newSheet.setColumnWidth(6,70)
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,7).setValue(FIN_ACT_value1[6]);
        if(FIN_ACT_value1[7]=='null')
        {
            FIN_ACT_value1[7]="";
        }
        FIN_ACT_newSheet.setColumnWidth(7,100)
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,8).setValue(FIN_ACT_value1[7]);
        if(FIN_ACT_value1[8]=='null')
        {
            FIN_ACT_value1[8]="";
        }
        FIN_ACT_newSheet.setColumnWidth(8, 100)
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,9).setValue(FIN_ACT_value1[8]);
        if(FIN_ACT_value1[9]=='null')
        {
            FIN_ACT_value1[9]="";
        }
        FIN_ACT_newSheet.setColumnWidth(9, 100)
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,10).setValue(FIN_ACT_value1[9]);
        if(FIN_ACT_value1[10]=='null')
        {
            FIN_ACT_value1[10]="";
        }
        FIN_ACT_newSheet.setColumnWidth(10, 100)
        FIN_ACT_newSheet.setColumnWidth(11, 500)
        FIN_ACT_newSheet.getRange(FIN_ACT_counter,11).setValue(FIN_ACT_value1[10]);
    }
    var sorcustomersheet=FIN_ACT_newspread.insertSheet('SORTED');
    for(var i=0;i<1;i++)
    {
        var FIN_ACT_counter =sorcustomersheet.getLastRow()+1;
        var headersplit=header.split(',');
        sorcustomersheet.getRange(FIN_ACT_counter,1).setValue(headersplit[0]);
        sorcustomersheet.getRange(FIN_ACT_counter,2).setValue(headersplit[1]);
        sorcustomersheet.getRange(FIN_ACT_counter,3).setValue(headersplit[2]);
        sorcustomersheet.getRange(FIN_ACT_counter,4).setValue(headersplit[3]);
        sorcustomersheet.getRange(FIN_ACT_counter,5).setValue(headersplit[4]);
        sorcustomersheet.getRange(FIN_ACT_counter,6).setValue(headersplit[5]);
        sorcustomersheet.getRange(FIN_ACT_counter,7).setValue(headersplit[6]);
        sorcustomersheet.getRange(FIN_ACT_counter,8).setValue(headersplit[7]);
        sorcustomersheet.getRange(FIN_ACT_counter,9).setValue(headersplit[8]);
        sorcustomersheet.getRange(FIN_ACT_counter,10).setValue(headersplit[9]);
        sorcustomersheet.getRange(FIN_ACT_counter,11).setValue(headersplit[10]);
        sorcustomersheet.setFrozenRows(1);
        sorcustomersheet.getRange(1, 1, 1, sorcustomersheet.getLastColumn()).setBackground('#498af3').setFontColor('white').setFontSize(12).setFontStyle('BOLD');
    }
    for(var a=0;a<SortRows;a++)
    {
        var FIN_ACT_counter =sorcustomersheet.getLastRow()+1;
        var FIN_ACT_value=customerdetails['sortdata'+a];
        var FIN_ACT_value1=FIN_ACT_value.split('!~');
        var FIN_ACT_unitvalue="'"+FIN_ACT_value1[0];
        sorcustomersheet.getRange(FIN_ACT_counter,1).setValue(FIN_ACT_unitvalue);
        sorcustomersheet.setColumnWidth(1, 40)
        sorcustomersheet.getRange(FIN_ACT_counter,2).setValue(FIN_ACT_value1[1]);
        sorcustomersheet.setColumnWidth(2, 300);
        sorcustomersheet.getRange(FIN_ACT_counter,3).setValue(FIN_ACT_value1[2]);
        sorcustomersheet.setColumnWidth(3, 100);
        sorcustomersheet.getRange(FIN_ACT_counter,4).setValue(FIN_ACT_value1[3]);
        sorcustomersheet.setColumnWidth(4, 80);
        sorcustomersheet.getRange(FIN_ACT_counter,5).setValue(FIN_ACT_value1[4]);
        if(FIN_ACT_value1[5]=='null')
        {
            FIN_ACT_value1[5]="";
        }
        sorcustomersheet.setColumnWidth(5, 60)
        sorcustomersheet.getRange(FIN_ACT_counter,6).setValue(FIN_ACT_value1[5]);
        if(FIN_ACT_value1[6]=='null')
        {
            FIN_ACT_value1[6]="";
        }
        sorcustomersheet.setColumnWidth(6,70)
        sorcustomersheet.getRange(FIN_ACT_counter,7).setValue(FIN_ACT_value1[6]);
        if(FIN_ACT_value1[7]=='null')
        {
            FIN_ACT_value1[7]="";
        }
        sorcustomersheet.setColumnWidth(7,100)
        sorcustomersheet.getRange(FIN_ACT_counter,8).setValue(FIN_ACT_value1[7]);
        if(FIN_ACT_value1[8]=='null')
        {
            FIN_ACT_value1[8]="";
        }
        sorcustomersheet.setColumnWidth(8, 100)
        sorcustomersheet.getRange(FIN_ACT_counter,9).setValue(FIN_ACT_value1[8]);
        if(FIN_ACT_value1[9]=='null')
        {
            FIN_ACT_value1[9]="";
        }
        sorcustomersheet.setColumnWidth(9, 100)
        sorcustomersheet.getRange(FIN_ACT_counter,10).setValue(FIN_ACT_value1[9]);
        if(FIN_ACT_value1[10]=='null')
        {
            FIN_ACT_value1[10]="";
        }
        sorcustomersheet.setColumnWidth(10, 100)
        sorcustomersheet.setColumnWidth(11, 500)
        sorcustomersheet.getRange(FIN_ACT_counter,11).setValue(FIN_ACT_value1[10]);
    }
    return FIN_ACT_url;
}
