/**
 * VER 0.01 DONE BY SARADA
 */
function REPORT_SS(arrReport) {
    var ss=arrReport.sheetId;
    var REP_ssheet=SpreadsheetApp.openById(ss).getSheets();var REP_Sheet=0;
    if(arrReport['sheetFlag']==0)
        REP_Sheet= SpreadsheetApp.openById(ss).getActiveSheet().setName(arrReport['sheet']);
    for(var j=0;j<REP_ssheet.length;j++){
        if(arrReport['sheet']==REP_ssheet[j].getName())
            REP_Sheet=SpreadsheetApp.openById(ss).getSheetByName( REP_ssheet[j].getName());
    }
    if(REP_Sheet==0)
        REP_Sheet=SpreadsheetApp.openById(ss).insertSheet(arrReport['sheet']);
    REP_Sheet.clear();
    var REP_counter=REP_Sheet.getLastRow()+1;
    for(var h=0;h<arrReport['header'].split('^^').length;h++){
        REP_Sheet.getRange(REP_counter,h+1).setValue(arrReport['header'].split('^^')[h]).setBackground('#498af3').setFontColor('white').setFontSize(12).setFontFamily('BOLD');
        REP_Sheet.setColumnWidth(h+1,arrReport['width'].split('^^')[h]);
    }
    REP_counter++;
    for(var i=0;i<arrReport['numsrow'];i++){
        var splitRecords=  arrReport['data'+i].split('^~^');
        for(var j=0;j<splitRecords.length;j++){
            REP_Sheet.getRange(REP_counter,j+1).setValue("'"+splitRecords[j]); }
        REP_counter++;
    }
    return SpreadsheetApp.openById(ss).getUrl();
}