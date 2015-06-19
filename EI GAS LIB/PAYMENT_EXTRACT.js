function Finance_Payment_Extract(PaymentDetails)
{
    var SSfileid=PaymentDetails['Fileid'];
    var SSHeader=PaymentDetails['header'];
    var totalpaymentrows=PaymentDetails['Rows'];

    var Sexistflag=0;
    var SSsheet=SpreadsheetApp.openById(SSfileid).getSheets();
    for(var i=0;i<SSsheet.length;i++)
    {
        if(SSsheet[i].getName()=='PAYMENT HISTORY')
        {
            Sexistflag=1;
        }
    }
    /*************************ALREADY EXISTING SS DELETE OLD RECORDS AND RELOAD ALL DETAILS*****************************/
    if(Sexistflag==1)
    {
        var Spreadsheetid=SSfileid;
        var paymentrecord=PaymentDetails['Paymentdata0'];
        var paymentrecordsplit=paymentrecord.split('!~');
        var ex_unit=paymentrecordsplit[0];
        var ex_customer=paymentrecordsplit[1];
        var paymentsheet=SpreadsheetApp.openById(SSfileid).getSheetByName('PAYMENT HISTORY');
        var paymentrecordschk=paymentsheet.getRange(1, 1, paymentsheet.getLastRow(), 2).getValues();
        var deleterowflag=0;
        var rowid_array=[];
        for(var row in paymentrecordschk)
        {
            var unit=paymentrecordschk[row][0];
            var customer=paymentrecordschk[row][1];
            if(unit==ex_unit && customer==ex_customer)
            {
                var existflag=1;
                var startrow=row;
                break;
            }
        }
        for(var row in paymentrecordschk)
        {
            var unit=paymentrecordschk[row][0];
            var customer=paymentrecordschk[row][1];
            if(unit==ex_unit && customer==ex_customer)
            {
                var endrow=row;
            }
        }
        if(existflag==1)
        {
            var counting=parseInt(endrow-startrow)+2;
            paymentsheet.deleteRows(startrow,counting);
        }
    }
    if(Sexistflag==0)
    {
        var widtharray=[50,250,150,75,150,130,150,100,100,300,150,250];
        var paymentsheetcreate=SpreadsheetApp.openById(SSfileid);
        var paymentsheet=paymentsheetcreate.insertSheet('PAYMENT HISTORY');
        var newddsheetlastrow=paymentsheet.getLastRow()+1;
        var SSHeadersplit=SSHeader.split(',');
        for(var k=0;k<widtharray.length;k++)
        {
            paymentsheet.getRange(newddsheetlastrow,k+1).setValue(SSHeadersplit[k]);
            paymentsheet.setColumnWidth(k+1,widtharray[k]);
        }
        PaymentHeaderbgcolorsetting(paymentsheet)
    }
    /**********************INSERTING PAYMENT DETAILS IN SS***************************/
    var paymentsheet=SpreadsheetApp.openById(SSfileid).getSheetByName('PAYMENT HISTORY');
    for(var i=0;i<totalpaymentrows;i++)
    {
        var paymentlastrow=paymentsheet.getLastRow()+1;
        var paymentrowvalue=PaymentDetails['Paymentdata'+i];
        var rowvalue=paymentrowvalue.split('!~');
        paymentsheet.getRange(paymentlastrow,1).setValue("'"+rowvalue[0]);
        paymentsheet.getRange(paymentlastrow,2).setValue(rowvalue[1]);
        var amountflagvalue=rowvalue[2];
        var paymentid=rowvalue[3];
        paymentsheet.getRange(paymentlastrow,3).setValue(rowvalue[4]);
        paymentsheet.getRange(paymentlastrow,4).setValue(rowvalue[5]);
        paymentsheet.getRange(paymentlastrow,5).setValue(rowvalue[6]);
        paymentsheet.getRange(paymentlastrow,6).setValue(rowvalue[7]);
        paymentsheet.getRange(paymentlastrow,7).setValue(rowvalue[8]);
        paymentsheet.getRange(paymentlastrow,8).setValue("'"+rowvalue[9]);
        paymentsheet.getRange(paymentlastrow,9).setValue("'"+rowvalue[10]);
        paymentsheet.getRange(paymentlastrow,10).setValue(rowvalue[11]);
        paymentsheet.getRange(paymentlastrow,11).setValue("'"+rowvalue[12]);
        paymentsheet.getRange(paymentlastrow,12).setValue(rowvalue[13]);
        if(rowvalue[2]=='X')
        {
            var coumnnumber=parseInt(paymentid)+2;
            paymentsheet.getRange(paymentlastrow,coumnnumber).setBackground('#FF0000').setFontColor('white');
        }
    }
    paymentsheet
    var paymentlastrow1=paymentsheet.getLastRow()+1;
    paymentsheet.getRange(paymentlastrow1,1).setValue('end');
    paymentsheet.getRange(paymentlastrow1, 1, 1, 12).setBackground('#000000');
    var totalcolumns=paymentsheet.getLastColumn();
    return 'Success';
}
function PaymentHeaderbgcolorsetting(paymentsheet)
{
    var paymentlastrow1=paymentsheet.getLastRow()+1;
    paymentsheet.getRange(paymentlastrow1,1).setValue('end');
    paymentsheet.getRange(paymentlastrow1, 1, 1, 12).setBackground('#000000');
    paymentsheet.setFrozenRows(1);
    paymentsheet.getRange(1, 1, 1, paymentsheet.getLastColumn()).setBackground('#498af3').setFontColor('white').setFontSize(12).setFontStyle('BOLD');
}
