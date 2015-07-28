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
function ssopen_byid_insertsheet(ssid,month){
  var sheet_insert=SpreadsheetApp.openById(ssid).insertSheet(month);
  return sheet_insert;
}
// for create new ss
function DDC_check_create_ss(DDC_newspread_ssid,DDC_ssname_getid,DDC_currentmonth){
  var DDC_currentfile_id;
  //CREATE TEMPLATE FOR NEW SS
  var DDC_source = ssopen_byid(DDC_ssname_getid);
  var DDC_templatesheet = DDC_source.getSheets();
  var DDC_flg_tempsht=0;
  for(var i=0;i<DDC_templatesheet.length;i++){
    if(DDC_templatesheet[i].getSheetName()=='TEMPLATE'){
      DDC_flg_tempsht=1;
      var DDC_sh=DDC_source.getSheets()[i];
      DDC_sh.copyTo(ssopen_byid(DDC_newspread_ssid)); 
    }
  }
  var DDC_rename=ssopen_byid_getsheet(DDC_newspread_ssid);
  for(var k=0;k<DDC_rename.length;k++){
    if(DDC_rename[k].getSheetName()=='Copy of TEMPLATE'){
      DDC_rename[k].setName('TEMPLATE');
    }
  }
  var DDC_destination = ssopen_byid(DDC_newspread_ssid);
  var DDC_newspread_delete=DDC_destination.getSheetByName('Sheet1');
  DDC_destination.deleteSheet(DDC_newspread_delete);  
  var DDC_rename=ssopen_byid_getsheet(DDC_newspread_ssid);
  for(var k=0;k<DDC_rename.length;k++){
    if(DDC_rename[k].getSheetName()!=DDC_currentmonth){
      ssopen_byid_insertsheet(DDC_newspread_ssid,DDC_currentmonth);
      break;
    }
  }
  DDC_currentfile_id=DDC_newspread_ssid;
  return [DDC_flg_tempsht,DDC_currentfile_id];
}
// for create template sheet
function DDC_template_exists_ss(DDC_currentfile_id,DDC_ssname_getid,DDC_ssname_oldyear){
  var temp_sheet = ssopen_byid_byname(DDC_currentfile_id,'TEMPLATE');
  if(temp_sheet==null){
    if(DDC_ssname_getid==undefined || DDC_ssname_getid==''){
      return ['DDC_flag_nosheet',DDC_ssname_oldyear];
    }
    var DDC_source = ssopen_byid(DDC_ssname_getid);
    var DDC_templatesheet = DDC_source.getSheets();
    for(var F=0;F<DDC_templatesheet.length;F++){
      if((temp_sheet==null)&&(DDC_templatesheet[F].getSheetName()=='TEMPLATE')){
        var DDC_sh=DDC_source.getSheets()[F];
        DDC_sh.copyTo(ssopen_byid(DDC_currentfile_id)); 
      }
    }
    var DDC_rename=ssopen_byid_getsheet(DDC_currentfile_id);
    for(var W=0;W<DDC_rename.length;W++){
      if(DDC_rename[W].getSheetName()=='Copy of TEMPLATE'){
        DDC_rename[W].setName('TEMPLATE');
      }
    }
  }
}
// insert new sheet in ss data insert
function DDC_newsheet_ssinsert(DDC_currentfile_id,DDC_currentmonth,unit_value,name,flag,DDC_startdatearrary,DDC_enddatearrary,DDC_recverlgth,selectedrecverlength,
                               DDC_recverarray,dep_value,depcomment,rentalcase,DDC_proratedunpaid,DDC_pay_unpaiddate,lastcarddate,DDC_cardcount,DDC_cardamount,
                               DDC_cap,DDC_no_ofdivision,caps,modifies,maininvdate,mainelecamt,mainelecdivamt,DDC_electrcap,DDC_invoicedate,DDC_cap_flag,DDC_electsubtotal,
                               fixedaircon,lpquaterval,quaterval,totalval,DDC_sumofquater,DDC_aircon,airquarter,airperquater,airvaldiff,DDC_airconsubtotal,unitinvoiceitem,
                               unitinvoicedate,unitamount,unitdivamount,checkout_clean,DDC_maintenancelength,drycleaning,DDC_chargelength,chargtype,chargamount,
                               DDC_unitsubtotal,DDC_totalallsubtl,DDC_tefundtotal,invoicedatekey,electrcapkey)
{
  var temp_sheet = ssopen_byid_byname(DDC_currentfile_id,'TEMPLATE');
  if(temp_sheet==null){
    return 'no_template_sheet';
  }
  var temp_header = temp_sheet.getRange(1,1,1,4);
  var head_color = temp_sheet.getRange(1,1,1,temp_sheet.getLastColumn()).getBackgroundColor();
  var ur = 2;  
  var unit_temp = temp_sheet.getRange(ur,1,1,1);
  var output_sheet = ssopen_byid_byname(DDC_currentfile_id,DDC_currentmonth);
  if(output_sheet == null)
  {
    var output_sheet = ssopen_byid_insertsheet(DDC_currentfile_id,DDC_currentmonth);
  }
  output_sheet.setColumnWidth(1, 600).setFrozenRows(1);
  output_sheet.setColumnWidth(2,300);
  var output_header = output_sheet.getRange(1,1,1,4);  
  temp_header.copyTo(output_header);
  var starting_row=output_sheet.getLastRow()+3;
  var unit_row = output_sheet.getRange(starting_row,1,1,1);
  unit_temp.copyTo(unit_row);
  //SET THE UNIT NUMBER IN THE SHEET//
  var unit_row1 = output_sheet.getRange(output_sheet.getLastRow(),2,1,1).setValue("'"+unit_value);
  var cust_temp = temp_sheet.getRange(ur+1,1,1,1);
  var cust_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1);
  cust_temp.copyTo(cust_row);
  //SET THE  CUSTOMER NAME IN THE SHEET//
  var cust_row1 = output_sheet.getRange(output_sheet.getLastRow(),2,1,1).setValue(name);
  var start_temp = temp_sheet.getRange(ur+2,1,1,1);
  var start_date = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1);
  start_temp.copyTo(start_date);
  //SET THE START DATE//
  if(DDC_recverlgth==selectedrecverlength)
  {
    var start_date1 = output_sheet.getRange(output_sheet.getLastRow(),2,1,1).setValue(DDC_startdatearrary).setNote('LEASE_PERIOD '+DDC_recverarray);
  }
  else
  {
    var start_date1 = output_sheet.getRange(output_sheet.getLastRow(),2,1,1).setValue(DDC_startdatearrary).setNote('LEASE_PERIOD '+DDC_recverarray);
  }
  //SET THE END DATE//
  var end_temp = temp_sheet.getRange(ur+3,1,1,1);
  var end_date = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1);
  end_temp.copyTo(end_date);
  if(DDC_recverlgth==selectedrecverlength)
  {
    var end_date1 = output_sheet.getRange(output_sheet.getLastRow(),2,1,1).setValue(DDC_enddatearrary);
  }
  else
  {
    var end_date1 = output_sheet.getRange(output_sheet.getLastRow(),2,1,1).setValue(DDC_enddatearrary);
  }
  var dep_temp = temp_sheet.getRange(ur+4,1,1,1);
  var dep_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1);
  dep_temp.copyTo(dep_row);
  var dep_row1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(dep_value);
  if(DDC_pay_unpaiddate!="")
  {
    var cell = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1);
    cell.setWrap(true);
    var rentcard_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue("RENT  = UNPAID FR "+DDC_pay_unpaiddate).setBackgroundRGB(255, 242, 204).setFontWeight("bold");
  }
  if(DDC_proratedunpaid=="UNPAID")
  {
    var pccard_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue("PC ="+DDC_proratedunpaid).setBackgroundRGB(255, 242, 204).setFontWeight("bold");
  }
  //LOST CARD AMOUNT ,TILL DATE STORED IN THE SHEET//
  if(DDC_cardcount!=0)
  {
    var lastcard_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue(lastcarddate).setBackgroundRGB(255, 242, 204).setFontWeight("bold");
    var lastcard_rowcrg1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(DDC_cardamount);
  }else
  {
    var lastcard_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue("ACCESS CARD LOST").setBackgroundRGB(255, 242, 204).setFontWeight("bold");
    var lastcard_rowcrg1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(DDC_cardamount);
  }
  if(rentalcase==3)
  {
    dep_row1.setNote(depcomment).setBackgroundColor('RED');
  }
  var elec_temp = temp_sheet.getRange(ur+5,1,1,1);
  var elec_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1);
  elec_temp.copyTo(elec_row);
  var elec_row1 = output_sheet.getRange(output_sheet.getLastRow(),2,1,1).setValue(DDC_cap);  
  //SET THE NO OF DIVISION VALUE IN THE SHEET//
  var div_val = output_sheet.getRange(output_sheet.getLastRow(),3,1,1).setValue('No of Div  '+DDC_no_ofdivision);
  var elec_beginrow = output_sheet.getLastRow()+2;  
  var elec_counter=elec_beginrow;
  var caps_split=caps.split('^^');
  var modifies_split=modifies.split('^^');
  var invoicedate_key=invoicedatekey.split('^^');
  var electrcap_key=electrcapkey.split('^^');
  var invdate_split=maininvdate.split('^^');
  var elecamt_split=mainelecamt.split('^^');
  var elecdivamt_split=mainelecdivamt.split('^^');
  var DDC_sheet_range='';
  for(var c=0;c<DDC_electrcap;c++){
    if(DDC_cap_flag==0){
      output_sheet.getRange(elec_counter,1).setValue(caps_split[c]);
      if(caps_split[c]!='')
        DDC_sheet_range=elec_counter;
      if((c!=0)&&(modifies_split[c]!=''))
      output_sheet.getRange(DDC_sheet_range,1).setValue(modifies_split[c])          
    }
    for(var j=0;j<DDC_invoicedate;j++){
      if(electrcap_key[c]==invoicedate_key[j]){
        output_sheet.getRange(elec_counter,2).setValue(invdate_split[j]).setFontWeight("bold"); 
        output_sheet.getRange(elec_counter,3).setValue(elecamt_split[j]);
        output_sheet.getRange(elec_counter,4).setValue(elecdivamt_split[j]); 
        elec_counter++;
      }
    }
  }
  //SET THE  TOTAL VALUES UPTO ELECTRICITY//
  var sub_temp = temp_sheet.getRange(ur+17,1,1,4);
  var sub_row = output_sheet.getRange(output_sheet.getLastRow()+2,1,1,4);
  sub_temp.copyTo(sub_row);
  var sub_row1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(parseFloat(DDC_electsubtotal)).setFontWeight("bold");
  var aircon_temp = temp_sheet.getRange(ur+20,1,1,1);
  var aircon_row = output_sheet.getRange(output_sheet.getLastRow()+2,1,1,1);
  aircon_temp.copyTo(aircon_row);
  //SET  THE  AIRCON FEE//   
  if(fixedaircon!=''){
    var aircon_row1 = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue('Fixed Aircon Fee ');
    var aircon_row1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(fixedaircon);
  }  
  if(DDC_sumofquater!=0 && DDC_sumofquater<DDC_aircon){
    var lpquaterval_split=lpquaterval.split('^^');
    var quaterval_split=quaterval.split('^^');
    var totalval_split=totalval.split('^^');
    for(var a=0;a<DDC_sumofquater;a++){
      var quarter_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue(lpquaterval_split[a]);
      var cell_quarter_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1);
      cell_quarter_row.setWrap(true);
      var quarter_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue(quaterval_split[a]);
      var aircon_row1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(totalval_split[a]);
    }
  }
  else{
    var airquarter_split=airquarter.split('^^');
    var airperquater_split=airperquater.split('^^');
    var airvaldiff_split=airvaldiff.split('^^');
    for(var l=0; l<DDC_aircon;l++){          
      var quarter_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue(airquarter_split[l]);
      var aircon_row1 = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue(airperquater_split[l]);
      var aircon_row1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(airvaldiff_split[l]);     
    }
  }
  var sub1_temp = temp_sheet.getRange(ur+23,1,1,4);  
  var sub1_row = output_sheet.getRange(output_sheet.getLastRow()+2,1,1,4);
  sub1_temp.copyTo(sub1_row);
  var sub1_row1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(DDC_airconsubtotal).setFontWeight("bold");
  var main_temp = temp_sheet.getRange(ur+25,1,1,1);
  var maint_row = output_sheet.getRange(output_sheet.getLastRow()+2,1,1,1);  
  main_temp.copyTo(maint_row);
  var beginrow = output_sheet.getLastRow()+2;
  var counter=beginrow;
  var invitem_split=unitinvoiceitem.split('^^');
  var invdate_split=unitinvoicedate.split('^^');
  var unitamt_split=unitamount.split('^^');
  var unitdivamt_split=unitdivamount.split('^^');
  for (var u=0;u<parseInt(DDC_maintenancelength);u++)
  {
    output_sheet.getRange(counter,1).setValue(invitem_split[u]);
    output_sheet.getRange(counter,2).setValue(invdate_split[u]);
    output_sheet.getRange(counter,3).setValue(unitamt_split[u]); 
    output_sheet.getRange(counter,4).setValue(unitdivamt_split[u]); 
    counter++       
  }
  if(checkout_clean!='')
  {
    var checkout_clean_temp = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue("Checkout Cleaning");
    var checkout_clean_row = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(checkout_clean);
  }
  if(drycleaning!="")
  {
    var dry_clean_temp = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,1).setValue("Curtain Dry Cleaning");
    var dry_clean_row = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(drycleaning);
  }
  var crgbeginrow = output_sheet.getLastRow()+1;
  var crgcounter=crgbeginrow;
  var chargtype_split=chargtype.split('^^');
  var chargamount_split=chargamount.split('^^');
  for ( var c=0;c<parseInt(DDC_chargelength);c++)
  {
    output_sheet.getRange(crgcounter,1).setValue(chargtype_split[c]).setFontWeight("bold");
    output_sheet.getRange(crgcounter,4).setValue(chargamount_split[c]); 
    crgcounter++;
  }
  var sub2_temp = temp_sheet.getRange(ur+33,1,1,4);
  var sub2_row = output_sheet.getRange(output_sheet.getLastRow()+2,1,1,4);
  sub2_temp.copyTo(sub2_row);
  var sub2_row1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(DDC_unitsubtotal).setFontWeight("bold");
  var tded_temp = temp_sheet.getRange(ur+37,1,1,4);
  var tded_row = output_sheet.getRange(output_sheet.getLastRow()+2,1,1,4);
  tded_temp.copyTo(tded_row); 
  var tded_row1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(DDC_totalallsubtl);
  var refun_temp = temp_sheet.getRange(ur+38,1,1,4);  
  var refun_row = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,4);
  refun_temp.copyTo(refun_row);
  var refun_row1 = output_sheet.getRange(output_sheet.getLastRow(),4,1,1).setValue(DDC_tefundtotal);
  var end_row =output_sheet.getLastRow();
  var no_of_row = end_row-starting_row+1;
  output_sheet.getRange(starting_row,1,no_of_row,4).setBorder(true,true,true,true,true,true);
  output_sheet.getRange(starting_row,2,end_row,1).setHorizontalAlignment("left");
  var black_row1 = output_sheet.getRange(output_sheet.getLastRow()+1,1,1,4).setBackgroundColor('black');
  output_sheet.insertRows(output_sheet.getLastRow()+5, 50);  
  return 'success';  
}