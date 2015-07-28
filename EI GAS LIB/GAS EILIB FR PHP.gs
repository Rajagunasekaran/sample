function doPost(e) {
    if(e.parameter.flag==1){
        var result=CUST_contract(e.parameter.flagProratedRentCkout,e.parameter.pro_rated_lineno,e.parameter.prlbl1,e.parameter.prlbl2,e.parameter.LastMonthformat,e.parameter.DEPOSITEword,e.parameter.ntc_date1,e.parameter.todaydat,e.parameter.todaydatestring,e.parameter.finalep_pass,
            e.parameter.LastMonthformat,e.parameter.flag_paraAlign,e.parameter.flag_paraAlign_sec,e.parameter.flag_paraAlign_thrd,e.parameter.flag_paraAlign_four,e.parameter.flag_paraAlign_five,
            e.parameter.cexdd,e.parameter.check_in_dated,e.parameter.noticeSt,e.parameter.address1value,e.parameter.cardno,e.parameter.fixedstmtfetch,e.parameter.noepcontlineno,e.parameter.elec_fetch,e.parameter.dryclean_fetch,
            e.parameter.checkoutfee_fetch,e.parameter.PROCESSno,e.parameter.DEPOSITno,e.parameter.weblogin,e.parameter.cust_config_array,e.parameter.RENTword,e.parameter.PROCESSword,e.parameter.DEPOSITword,e.parameter.proratedrent,e.parameter.proratedsmonth,
            e.parameter.proratedemonth,e.parameter.unitno,e.parameter.checkindate,e.parameter.checkoutdate,e.parameter.companyname,
            e.parameter.customername,e.parameter.noticeperiod,e.parameter.passportno,e.parameter.passportdate,e.parameter.epno,e.parameter.epdate,
            e.parameter.noticedate,e.parameter.lp,e.parameter.cardno,e.parameter.rent,e.parameter.airquartfee,
            e.parameter.airfixedfee,e.parameter.electcap,e.parameter.dryclean,e.parameter.chkoutfee,e.parameter.procfee,e.parameter.deposit,e.parameter.waived,
            e.parameter.roomtype,e.parameter.rent_check,e.parameter.formname,e.parameter.targetFolderId);

    }
    else if(e.parameter.flag==2){
        var result=CUST_invoice(e.parameter.arrCheckDateAmtConcate,e.parameter.singlemonth,e.parameter.reminingmonths,e.parameter.companyTemp,e.parameter.replaceSum,e.parameter.todaydat,
            e.parameter.todaydatestring,e.parameter.A3,e.parameter.A4,e.parameter.das,e.parameter.pc,e.parameter.A5,e.parameter.sum,e.parameter.cdate1,e.parameter.cdate2,
            e.parameter.todaysDate,e.parameter.Slno,e.parameter.tenant_fetch,e.parameter.length,
            e.parameter.proratedrentflag, e.parameter.nonPror_monthCal,e.parameter.prorated_monthCal, e.parameter.proratedrent,e.parameter.proratedsmonth,e.parameter.proratedemonth,e.parameter.unit,
            e.parameter.customername,e.parameter.companyname,e.parameter.invoiceid,e.parameter.invoicesno,e.parameter.invoicedate,e.parameter.rent,e.parameter.process,e.parameter.deposit,e.parameter.sdate,e.parameter.edate,e.parameter.roomtype,e.parameter.Leaseperiod,e.parameter.mailid,e.parameter.Folderid,e.parameter.rentcheck,e.parameter.docowner,e.parameter.formname,e.parameter.waived,e.parameter.custid)
    }
    if(e.parameter.DDC_flag==1){
        var result=DDC_check_create_ss(e.parameter.DDC_newspread_ssid,e.parameter.DDC_ssname_getid,e.parameter.DDC_currentmonth);
    }
    else if(e.parameter.DDC_flag==2){
        var result=DDC_template_exists_ss(e.parameter.DDC_currentfile_id,e.parameter.DDC_ssname_getid,e.parameter.DDC_ssname_oldyear);
    }
    else if(e.parameter.DDC_flag==3){
        var result=DDC_newsheet_ssinsert(e.parameter.DDC_currentfile_id,e.parameter.DDC_currentmonth,e.parameter.unit_value,e.parameter.name,e.parameter.flag,
            e.parameter.DDC_startdatearrary,e.parameter.DDC_enddatearrary,e.parameter.DDC_recverlgth,e.parameter.selectedrecverlength,
            e.parameter.DDC_recverarray,e.parameter.dep_value,e.parameter.depcomment,e.parameter.rentalcase,e.parameter.DDC_proratedunpaid,
            e.parameter.DDC_pay_unpaiddate,e.parameter.lastcarddate,e.parameter.DDC_cardcount,e.parameter.DDC_cardamount,e.parameter.DDC_cap,
            e.parameter.DDC_no_ofdivision,e.parameter.caps,e.parameter.modifies,e.parameter.maininvdate,e.parameter.mainelecamt,
            e.parameter.mainelecdivamt,e.parameter.DDC_electrcap,e.parameter.DDC_invoicedate,e.parameter.DDC_cap_flag,e.parameter.DDC_electsubtotal,
            e.parameter.fixedaircon,e.parameter.lpquaterval,e.parameter.quaterval,e.parameter.totalval,e.parameter.DDC_sumofquater,
            e.parameter.DDC_aircon,e.parameter.airquarter,e.parameter.airperquater,e.parameter.airvaldiff,e.parameter.DDC_airconsubtotal,
            e.parameter.unitinvoiceitem,e.parameter.unitinvoicedate,e.parameter.unitamount,e.parameter.unitdivamount,e.parameter.checkout_clean,
            e.parameter.DDC_maintenancelength,e.parameter.drycleaning,e.parameter.DDC_chargelength,e.parameter.chargtype,e.parameter.chargamount,
            e.parameter.DDC_unitsubtotal,e.parameter.DDC_totalallsubtl,e.parameter.DDC_tefundtotal,e.parameter.invoicedatekey,e.parameter.electrcapkey);
    }
    else if(e.parameter.DDE_flag==1){
        var result=Extract_ssnames(e.parameter.DDE_currentfile_id);
        return ContentService.createTextOutput(JSON.stringify(result)).setMimeType(ContentService.MimeType.JSON);
    }
    else if(e.parameter.DDE_flag==2){
        var result=Extract_unitno(e.parameter.shturl,e.parameter.selectedsheet);
        return ContentService.createTextOutput(JSON.stringify(result)).setMimeType(ContentService.MimeType.JSON);
    }
    else if(e.parameter.DDE_flag==3){
        var result=Extract_customers(e.parameter.shturl,e.parameter.selectedunit,e.parameter.selectedsheet);
        return ContentService.createTextOutput(JSON.stringify(result)).setMimeType(ContentService.MimeType.JSON);
    }
    else if(e.parameter.DDE_flag==4){
        var result=Extract_custid(e.parameter.shturl,e.parameter.selectedunit,e.parameter.selectedname,e.parameter.selectedsheet);
        return ContentService.createTextOutput(JSON.stringify(result)).setMimeType(ContentService.MimeType.JSON);
    }
    else if(e.parameter.DDE_flag==5){
        var result=Extract_recver(e.parameter.shturl,e.parameter.selectedunit,e.parameter.selectedname,e.parameter.selectedsheet,e.parameter.getid,
            e.parameter.nocustid);
        return ContentService.createTextOutput(JSON.stringify(result)).setMimeType(ContentService.MimeType.JSON);
    }
    else if(e.parameter.DDE_flag==6){
        var result=Extract_submit(e.parameter.shturl,e.parameter.selectedunit,e.parameter.customername,e.parameter.checkarray,e.parameter.selectedsheet,e.parameter.customeridname);
        return ContentService.createTextOutput(JSON.stringify(result)).setMimeType(ContentService.MimeType.JSON);
    }
    else if(e.parameter.DDE_flag==7){
        var result=deleteTemporarySheet();
    }
    if(e.parameter.ACtiveflag==10)
    {
        var result=Active_Customer_List(e.parameter);
    }
    else if(e.parameter.Extract==11)
    {
        var result=Finance_Payment_Extract(e.parameter);
    }
    else if(e.parameter.flag==12){
        var result=REPORT_SS(e.parameter);
    }
    return ContentService.createTextOutput(result);
}

