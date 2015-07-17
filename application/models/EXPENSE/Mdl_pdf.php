<?php

Class Mdl_pdf extends CI_Model
{
public function Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory,$timeZoneFormat)
{
if($PDLY_SEARCH_typelistvalue==36)
{

$PDLY_SEARCH_selectquery[56]=$this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_COMMENTS="'.$PDLY_SEARCH_searchcomments.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[52] =$this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_DATA="'.$PDLY_SEARCH_babycategory.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID)ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[51] = $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_AMOUNT BETWEEN "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[53] = $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_ID=EXPBABY.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[55]= $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID,  DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_INVOICE_FROM="'.$PDLY_SEARCH_invfromcomt.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[54] = $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T")  AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_INVOICE_ITEMS="'.$PDLY_SEARCH_invitemcom.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
}
if($PDLY_SEARCH_typelistvalue==35)
{
$PDLY_SEARCH_selectquery[62] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_COMMENTS ="'.$PDLY_SEARCH_searchcomments.'") AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[58] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_DATA="'.$PDLY_SEARCH_babycategory.'") AND (EXPCONFIG.ECN_ID=EXPCAR.ECN_ID)ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[57] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" )AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_AMOUNT BETWEEN  "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'") AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[59] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_ID=EXPCAR.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[61] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_INVOICE_FROM="'.$PDLY_SEARCH_invfromcomt.'") AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[60] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_INVOICE_ITEMS="'.$PDLY_SEARCH_invitemcom.'")AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
}
if($PDLY_SEARCH_typelistvalue==37)
{
$PDLY_SEARCH_selectquery[73] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_COMMENTS="'.$PDLY_SEARCH_searchcomments.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[69] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_DATA="'.$PDLY_SEARCH_babycategory.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID)ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[68] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_AMOUNT BETWEEN "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[70] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_ID=EXPPERSONAL.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[72] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_INVOICE_FROM="'.$PDLY_SEARCH_invfromcomt.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[71] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_INVOICE_ITEMS="'.$PDLY_SEARCH_invitemcom.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
}
if($PDLY_SEARCH_typelistvalue==38)
{
$PDLY_SEARCH_selectquery[65] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_PAID_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (ECL_AMOUNT BETWEEN "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'")ORDER BY ECL_PAID_DATE ASC');
$PDLY_SEARCH_selectquery[67] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_PAID_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (ECL_COMMENTS="'.$PDLY_SEARCH_searchcomments.'")ORDER BY ECL_PAID_DATE ASC');
$PDLY_SEARCH_selectquery[63] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_PAID_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") ORDER BY ECL_PAID_DATE ASC');
$PDLY_SEARCH_selectquery[66] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_FROM_PERIOD BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") ORDER BY ECL_PAID_DATE ASC');
$PDLY_SEARCH_selectquery[64] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_TO_PERIOD BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") ORDER BY ECL_PAID_DATE ASC');
}
$arrayvalues= $PDLY_SEARCH_selectquery[$PDLY_SEARCH_babysearchoption];
    $PDLY_SEARCH_babytable_header='';
    if($PDLY_SEARCH_typelistvalue==36)
    {
        $PDLY_SEARCH_babytable_header='<br><br><table id="PDLY_SEARCH_tbl_htmltable" border="1"  style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult"><thead><tr><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TYPE OF BABY EXPENSE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">INVOICE DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:60px;font-weight: bold;">INVOICE AMOUNT</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE FROM</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;" >INVOICE ITEMS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:230px;font-weight: bold;">COMMENTS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach ($arrayvalues->result_array() as $row)
        {
            $ebcategory=$row['ECN_DATA'];
            $eb_invoicedate=$row['EB_INVOICE_DATE'];
            $eb_invoicedate=date('d-m-Y',strtotime($eb_invoicedate));
            $eb_invoceamount=$row['EB_AMOUNT'];
            $eb_invoicefrom=$row['EB_INVOICE_FROM'];
            $eb_invoiceitem=$row['EB_INVOICE_ITEMS'];
            $eb_comments=$row['EB_COMMENTS'];
            if($eb_comments==null){$eb_comments='';}
            $eb_userstamp=$row['ULD_LOGINID'];
            $eb_timestamp=$row['TIMESTMP'];
            $PDLY_SEARCH_babytable_header.='<tr><td>'.$ebcategory.'</td><td>'.$eb_invoicedate.'</td><td>'.$eb_invoceamount.'</td><td>'.$eb_invoicefrom.'</td><td>'.$eb_invoiceitem.'</td><td>'.$eb_comments.'</td><td>'.$eb_userstamp.'</td><td nowrap>'.$eb_timestamp.'</td></tr>';
        }
        $PDLY_SEARCH_babytable_header.='</tbody></table>';
    }
    if($PDLY_SEARCH_typelistvalue==35)
    {
        $PDLY_SEARCH_babytable_header='<br><br><table id="PDLY_SEARCH_tbl_htmltable" border="1" style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult"><thead><tr><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TYPE OF CAR EXPENSE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">INVOICE DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:60px;font-weight: bold;">INVOICE AMOUNT</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE FROM</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE ITEMS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:230px;font-weight: bold;">COMMENTS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach ($arrayvalues->result_array() as $row)
        {
            $eccategory=$row['ECN_DATA'];
            $ec_invoicedate=$row['EC_INVOICE_DATE'];
            $ec_invoicedate=date('d-m-Y',strtotime($ec_invoicedate));
            $ec_invoceamount=$row['EC_AMOUNT'];
            $ec_invoicefrom=$row['EC_INVOICE_FROM'];
            $ec_invoiceitem=$row['EC_INVOICE_ITEMS'];
            $ec_comments=$row['EC_COMMENTS'];
            if($ec_comments==null){$ec_comments='';}
            $ec_userstamp=$row['ULD_LOGINID'];
            $ec_timestamp=$row['TIMESTMP'];
            $PDLY_SEARCH_babytable_header.='<tr><td>'.$eccategory.'</td><td>'.$ec_invoicedate.'</td><td>'.$ec_invoceamount.'</td><td>'.$ec_invoicefrom.'</td><td>'.$ec_invoiceitem.'</td><td>'.$ec_comments.'</td><td>'.$ec_userstamp.'</td><td nowrap>'.$ec_timestamp.'</td></tr>';
        }
        $PDLY_SEARCH_babytable_header.='</tbody></table>';
    }
    if($PDLY_SEARCH_typelistvalue==37)
    {
        $PDLY_SEARCH_babytable_header='<br><br><table id="PDLY_SEARCH_tbl_htmltable" border="1"  style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult"><thead><tr><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TYPE OF PERSONAL EXPENSE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">INVOICE DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:60px;font-weight: bold;">INVOICE AMOUNT</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE FROM</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE ITEMS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:230px;font-weight: bold;">COMMENTS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach ($arrayvalues->result_array() as $row)
        {
            $epcategory=$row['ECN_DATA'];
            $ep_invoicedate=$row['EP_INVOICE_DATE'];
            $ep_invoicedate=date('d-m-Y',strtotime($ep_invoicedate));
            $ep_invoceamount=$row['EP_AMOUNT'];
            $ep_invoicefrom=$row['EP_INVOICE_FROM'];
            $ep_invoiceitem=$row['EP_INVOICE_ITEMS'];
            $ep_comments=$row['EP_COMMENTS'];
            if($ep_comments==null){$ep_comments='';}
            $ep_userstamp=$row['ULD_LOGINID'];
            $ep_timestamp=$row['TIMESTMP'];
            $PDLY_SEARCH_babytable_header.='<tr><td>'.$epcategory.'</td><td>'.$ep_invoicedate.'</td><td>'.$ep_invoceamount.'</td><td>'.$ep_invoicefrom.'</td><td>'.$ep_invoiceitem.'</td><td>'.$ep_comments.'</td><td>'.$ep_userstamp.'</td><td nowrap>'.$ep_timestamp.'</td></tr>';
        }
        $PDLY_SEARCH_babytable_header.='</tbody></table>';
    }
    if($PDLY_SEARCH_typelistvalue==38)
    {
    $PDLY_SEARCH_babytable_header='<br><br><table id="PDLY_SEARCH_tbl_htmltable" border="1"  style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult"><thead><tr><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">PAID DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:60px;font-weight: bold;">INVOICE AMOUNT</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">FROM PERIOD</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">TO PERIOD</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:230px;font-weight: bold;">COMMENTS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:250px;font-weight: bold;">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:150px;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';

        foreach ($arrayvalues->result_array() as $row)
        {
            $eclpaiddate=$row['ECL_PAID_DATE'];
            $eclpaiddate=date('d-m-Y',strtotime($eclpaiddate));
            $eclfromperiod=$row['ECL_FROM_PERIOD'];
            $eclfromperiod=date('d-m-Y',strtotime($eclfromperiod));
            $eclTPeriod=$row['ECL_TO_PERIOD'];
            $eclTPeriod=date('d-m-Y',strtotime($eclTPeriod));
            $ecl_invoceamount=$row['ECL_AMOUNT'];
            $ecl_comments=$row['ECL_COMMENTS'];
            if($ecl_comments==null){$ecl_comments='';}
            $ecl_userstamp=$row['ULD_LOGINID'];
            $ecl_timestamp=$row['TIMESTMP'];
            $PDLY_SEARCH_babytable_header.='<tr><td>'.$eclpaiddate.'</td><td>'.$ecl_invoceamount.'</td><td nowrap>'.$eclfromperiod.'</td><td nowrap>'.$eclTPeriod.'</td><td>'.$ecl_comments.'</td><td>'.$ecl_userstamp.'</td><td nowrap>'.$ecl_timestamp.'</td></tr>';
        }
            $PDLY_SEARCH_babytable_header.='</tbody></table>';
    }
    return $PDLY_SEARCH_babytable_header;

}
//BIX EXPENSE DAILY PDF
    /*------------------------------------------TO GET DATA TABLE HEADER WIDTH--------------------------------------------------------*/
    public  function BDLY_SRC_getHeaderWidth($BDLY_SRC_exptype,$BDLY_SRC_OPTION)
    {
        $BDLY_SRC_finalheader=[];
        $BDLY_SRC_headerwidth=["SNO"=>"30","USERSTAMP"=>"170","CATEGORY<em>*</em>"=>"40","TIMESTAMP"=>"140","UNIT NO"=>"40",'CARD NUMBER<em>*</em>'=>"50","CAR NO"=>"60",
            "INVOICE DATE<em>*</em>"=>"75","INVOICE AMOUNT<em>*</em>"=>"10","COMMENTS"=>"500","PAID DATE<em>*</em>"=>"75","FOR PERIOD<em>*</em>"=>"75",
            "INVOICE ITEMS<em>*</em>"=>"250","INVOICE FROM<em>*</em>"=>"150","INVOICE TO"=>"120","ACCOUNT NO"=>"80",
            "FROM PERIOD<em>*</em>"=>"75","TO PERIOD<em>*</em>"=>"75","AIRCON SERVICE BY"=>"250","TOTAL AMOUNT"=>"120","UNIT NO<em>*</em>"=>"40","CUSTOMER"=>"250","CLEANER NAME"=>"90",
            "WORK DATE<em>*</em>"=>"90","DURATION<em>*</em>"=>"70","DESCRIPTION<em>*</em>"=>"600","DIGITAL VOICE NO"=>"150","DEPOSIT"=>"80","DEPOSIT REFUND"=>"150",
            "INVOICE AMOUNT"=>"150","TOTAL DURATION"=>"100","INVOICE DATE"=>"75","CASH IN"=>"60",'CASH OUT'=>'60','CURRENT BALANCE'=>"130"];
        $BDLY_SRC_headerwidthlen=count(array_keys($BDLY_SRC_headerwidth));
        $BDLY_SRC_tablewidth=["1"=>"2000","2"=>"2000","3"=>"2250","4"=>"1500","5"=>"2000","6"=>"1700","7"=>"1500","8"=>"2000","9"=>"1800","10"=>"1800","11"=>"1500","12"=>"1700"];
        if($BDLY_SRC_OPTION==142||$BDLY_SRC_OPTION==198)
        {
            if($BDLY_SRC_OPTION==142)
            {
                $BDLY_SRC_GridHeaders=[11=>['TOTAL DURATION','TOTAL AMOUNT']];
                $BDLY_SRC_tablewidth=["11"=>"100"];
            }
            if($BDLY_SRC_OPTION==198)
            {
                $BDLY_SRC_GridHeaders=[12=>['UNIT NO<em>*</em>','USERSTAMP','TIMESTAMP']];
                $BDLY_SRC_tablewidth=["12"=>"800"];
            }
        }
        else
        {
            $BDLY_SRC_GridHeaders=[1=>['UNIT NO','INVOICE TO','INVOICE DATE<em>*</em>','FROM PERIOD<em>*</em>','TO PERIOD<em>*</em>','DEPOSIT','DEPOSIT REFUND','INVOICE AMOUNT','COMMENTS','USERSTAMP','TIMESTAMP'],
                2=>['UNIT NO','INVOICE TO','ACCOUNT NO','INVOICE DATE<em>*</em>','FROM PERIOD<em>*</em>','TO PERIOD<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                3=>['UNIT NO','CATEGORY<em>*</em>','CUSTOMER','INVOICE DATE<em>*</em>','INVOICE ITEMS<em>*</em>','INVOICE FROM<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                4=>['UNIT NO','INVOICE DATE<em>*</em>','DEPOSIT','INVOICE AMOUNT','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                5=>['UNIT NO','INVOICE TO','DIGITAL VOICE NO','ACCOUNT NO','INVOICE DATE<em>*</em>','FROM PERIOD<em>*</em>','TO PERIOD<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP','TIMESTAMP'],
                6=>['UNIT NO','CARD NUMBER<em>*</em>','INVOICE DATE<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                7=>['UNIT NO','INVOICE DATE<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP','TIMESTAMP'],
                8=>['UNIT NO','CAR NO','INVOICE DATE<em>*</em>','FROM PERIOD<em>*</em>','TO PERIOD<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                9=>['UNIT NO','AIRCON SERVICE BY','INVOICE DATE<em>*</em>','COMMENTS','USERSTAMP','TIMESTAMP'],
                10=>['INVOICE DATE','CASH IN','CASH OUT','CURRENT BALANCE','INVOICE ITEMS<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                11=>['CLEANER NAME','WORK DATE<em>*</em>','DURATION<em>*</em>','DESCRIPTION<em>*</em>','USERSTAMP','TIMESTAMP'],
                12=>['UNIT NO','INVOICE AMOUNT<em>*</em>','FOR PERIOD<em>*</em>','PAID DATE<em>*</em>','COMMENTS','USERSTAMP','TIMESTAMP']];
        }
        for($i=0;$i<count($BDLY_SRC_GridHeaders[$BDLY_SRC_exptype]);$i++)
        {
            if($BDLY_SRC_headerwidth[$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i]]&&$BDLY_SRC_headerwidth[$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i]]!='undefined')
            {
                $str=$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i].'^'.$BDLY_SRC_headerwidth[$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i]];
                $BDLY_SRC_finalheader[]=$str;
            }
            else
            {
                $BDLY_SRC_finalheader[]=$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i];
            }
        }
        $BDLY_SRC_finalwidth=(object)["headerwidth"=>$BDLY_SRC_finalheader,"tablewidth"=>$BDLY_SRC_tablewidth[$BDLY_SRC_exptype]];
        return $BDLY_SRC_finalwidth;
    }
    /*------------------------------------------TO CALL HOUSE KEEPING PAYMENT SP--------------------------------------------------------*/
    public  function BDLY_SRC_callhkpaymentsp($USERSTAMP)
    {
        $BDLY_SRC_HKunitnospquery=$this->db->query("CALL SP_BIZDLY_HOUSE_KEEPING_PAYMENT_SRCH_DTLS('$USERSTAMP',@TEMP_TBLE_HKPSRCH)");
        $BDLY_SRC_rs_temptble=$this->db->query('SELECT @TEMP_TBLE_HKPSRCH AS TEMP_TBLE_HKPSRCH');
        $TEMP_tablename=$BDLY_SRC_rs_temptble->row()->TEMP_TBLE_HKPSRCH;
        return $TEMP_tablename;
    }
    /*------------------------------------------TO DROP HOUSE KEEPING PAYMENT TEMP TABLE--------------------------------------------------------*/
    public function BDLY_SRC_drophkpaymentsptemptable($BDLY_SRC_drptmptbl_hkpsrch)
    {
        if($BDLY_SRC_drptmptbl_hkpsrch!='')
            $this->db->query('DROP TABLE IF EXISTS '.$BDLY_SRC_drptmptbl_hkpsrch);
    }
    /*------------------------------------------WILL FETCH RESULT FROM DB AND WILL SHOW IN DATA TABLE -----------------------------------------------------*/
    public function BDLY_SRC_getAnyTypeExpData($USERSTAMP,$timeZoneFormat,$BDLY_SRC_lb_unitno,$BDLY_SRC_lb_invoiceto,$BDLY_SRC_comments,$BDLY_SRC_comments,$BDLY_SRC_tb_fromamnt,$BDLY_SRC_tb_toamnt,$BDLY_SRC_servicedue,$BDLY_SRC_lb_cleanername,$BDLY_SRC_tb_durationamt,$BDLY_SRC_startdate,$BDLY_SRC_enddate,$BDLY_SRC_invoicefrom,$BDLY_SRC_lb_accountno,$BDLY_SRC_lb_cusname,$BDLY_SRC_lb_Digvoiceno,$BDLY_SRC_lb_cardno,$BDLY_SRC_lb_carno,$BDLY_SRC_lb_serviceby,$BDLY_SRC_invoiceitem,$BDLY_SRC_lb_category){
        $BDLY_SRC_lb_ExpenseList_val=$_POST['BDLY_SRC_lb_ExpenseList'];
        $BDLY_SRC_lb_serachopt=$_POST['BDLY_SRC_lb_serachopt'];
        $BDLY_SRC_tmptbl_hkpsrch='';
        $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
        $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
        $BDLY_SRC_invoiceitemssrcvalue=$this->db->escape_like_str($BDLY_SRC_invoiceitem);
        $BDLY_SRC_commentssrcvalue=$this->db->escape_like_str($BDLY_SRC_comments);
        $BDLY_SRC_invfromsrcvalue=$this->db->escape_like_str($BDLY_SRC_invoicefrom);
        $BDLY_SRC_temptabledropQuery=[1=>[],2=>[],3=>[],4=>[],5=>[],6=>[],7=>[],8=>[],9=>[],10=>[],11=>[],12=>[]];
        $BDLY_SRC_SelectQuery=[1=>[],2=>[],3=>[],4=>[],5=>[],6=>[],7=>[],8=>[],9=>[],10=>[],11=>[],12=>[]];
        //Data Table Header Caption
        $BDLY_SRC_GridHeaders=$this->BDLY_SRC_getHeaderWidth($BDLY_SRC_lb_ExpenseList_val,$BDLY_SRC_lb_serachopt);
        $BDLY_SRC_TableWidth=$BDLY_SRC_GridHeaders->tablewidth;
        $BDLY_SRC_GridHeaders=$BDLY_SRC_GridHeaders->headerwidth;

        if($BDLY_SRC_lb_ExpenseList_val==12)
        {
            $BDLY_SRC_tmptbl_hkpsrch=$this->BDLY_SRC_callhkpaymentsp($USERSTAMP);
        }
        if($BDLY_SRC_lb_ExpenseList_val==1||$BDLY_SRC_lb_serachopt==142)
        {
            if($BDLY_SRC_lb_serachopt==191)
                $BDLY_SRC_sp_thirdval="'$BDLY_SRC_lb_unitno'";
            if($BDLY_SRC_lb_serachopt==165)
                $BDLY_SRC_sp_thirdval="'$BDLY_SRC_lb_invoiceto'";
            if($BDLY_SRC_lb_serachopt==159)
                $BDLY_SRC_sp_thirdval="'$BDLY_SRC_comments'";
            if($BDLY_SRC_lb_serachopt==160||$BDLY_SRC_lb_serachopt==161||$BDLY_SRC_lb_serachopt==163){
                $BDLY_SRC_sp_thirdval="'$BDLY_SRC_tb_fromamnt'";
                $BDLY_SRC_sp_fourthval="'$BDLY_SRC_tb_toamnt'";}
            if($BDLY_SRC_lb_serachopt==162||$BDLY_SRC_lb_serachopt==164||$BDLY_SRC_lb_serachopt==166)
                $BDLY_SRC_sp_thirdval='null';
            if($BDLY_SRC_lb_serachopt==162||$BDLY_SRC_lb_serachopt==164||$BDLY_SRC_lb_serachopt==166||$BDLY_SRC_lb_serachopt==191||$BDLY_SRC_lb_serachopt==165||$BDLY_SRC_lb_serachopt==159)
                $BDLY_SRC_sp_fourthval='null';
            if($BDLY_SRC_lb_serachopt==142){
                $BDLY_SRC_hkpforperiod =date("Y-m-01", strtotime($BDLY_SRC_servicedue));
                $BDLY_SRC_electtempstmt=$this->db->query("CALL SP_BIZDLY_HOUSEKEEPING_DURATION_AMOUNT_SRCH('$BDLY_SRC_lb_cleanername','$BDLY_SRC_hkpforperiod','$BDLY_SRC_tb_durationamt','$USERSTAMP',@TEMPTABLE_ELECTRICITY)");
            }
            else
            {
                $BDLY_SRC_electtempstmt=$this->db->query("CALL SP_TEMP_BIZDLY_ELECTRICITY_SEARCH('$BDLY_SRC_startdate','$BDLY_SRC_enddate',$BDLY_SRC_sp_thirdval,$BDLY_SRC_sp_fourthval,'$BDLY_SRC_lb_serachopt','$USERSTAMP',@TEMPTABLE_ELECTRICITY)");
            }
            $BDLY_SRC_dynatemp_stmt=$this->db->query('SELECT @TEMPTABLE_ELECTRICITY AS TEMPTABLE_ELECTRICITY');
            $BDLY_SRC_electemp_name=$BDLY_SRC_dynatemp_stmt->row()->TEMPTABLE_ELECTRICITY;
        }
        $BDLY_SRC_Expdataobject=[];
        //ELECTRICITY--1
        if($BDLY_SRC_lb_ExpenseList_val==1)
        {
            //UNIT NO SEARCH OPTION ID-191
            $BDLY_SRC_SelectQuery['1']['191'] = "SELECT EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_INVOICE_DATE ASC";
            //INVOICE TO SEARCH OPTION ID-165
            $BDLY_SRC_SelectQuery['1']['165'] = "SELECT EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_UNITNO,EE_INVOICE_DATE ASC";
            //INVOICE DATE SEARCH OPTION ID-164
            $BDLY_SRC_SelectQuery['1']['164'] = "SELECT EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_INVOICE_DATE,EE_UNITNO ASC";
            //COMMENTS SEARCH OPTION ID-159
            $BDLY_SRC_SelectQuery['1']['159'] = "SELECT EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_UNITNO,EE_INVOICE_DATE ASC";
            //FROM PERIOD SEARCH OPTION ID-162
            $BDLY_SRC_SelectQuery['1']['162'] = "SELECT EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_FROM_PERIOD,EE_UNITNO,EE_INVOICE_DATE ASC";
            //TO PERIOD SEARCH OPTION ID-166
            $BDLY_SRC_SelectQuery['1']['166'] = "SELECT EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_TO_PERIOD,EE_UNITNO,EE_INVOICE_DATE ASC";
        }
        //------------------------------------------------------------STARHUB=2-----------------------------------------------------------------------------------//
        /*ACCOUNT NO SEARCH*/$BDLY_SRC_SelectQuery['2']['178'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDSH.EDSH_ACCOUNT_NO='$BDLY_SRC_lb_accountno' ORDER BY U.UNIT_NO,ESH_INVOICE_DATE ASC";
        /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['2']['179'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND ESH_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,ESH_INVOICE_DATE ASC";
        /*FROM PERIOD SEARCH*/$BDLY_SRC_SelectQuery['2']['180'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_FROM_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ESH_FROM_PERIOD,U.UNIT_NO ASC";
        /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['2']['182'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ESH_INVOICE_DATE,U.UNIT_NO ASC";
        /*INVOICE TO SEARCH*/$BDLY_SRC_SelectQuery['2']['183'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDSH.ECN_ID='$BDLY_SRC_lb_invoiceto' ORDER BY U.UNIT_NO,ESH_INVOICE_DATE ASC";
        /*TO PERIOD SEARCH*/$BDLY_SRC_SelectQuery['2']['184'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_TO_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ESH_TO_PERIOD,U.UNIT_NO ASC";
        /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['2']['191'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,ESH_INVOICE_DATE ASC";
        //----------------------------------------------------------UNIT EXPENSE=3---------------------------------------------------------------------------------//
        /*CATEGORY SEARCH*/
        $CUSTOMER_TYPE=$BDLY_SRC_lb_category==23?true:false;
        if($CUSTOMER_TYPE) //CUSTOMER TYPE
            $BDLY_SRC_SelectQuery['3']['186'] = "SELECT U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT AS U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND EU.ECN_ID ='$BDLY_SRC_lb_category' AND EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.CUSTOMER_ID='$BDLY_SRC_lb_cusname' ORDER BY U.UNIT_NO ASC";
        else if($BDLY_SRC_lb_ExpenseList_val==3) // NON CUSTOMER
            $BDLY_SRC_SelectQuery['3']['186'] = "SELECT U.UNIT_NO,EC.ECN_DATA,NULL AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND EU.ECN_ID ='$BDLY_SRC_lb_category' AND EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.CUSTOMER_ID IS NULL ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
        /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['3']['188'] = "SELECT U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EU.EU_INVOICE_DATE,U.UNIT_NO ASC";
        /*INVOICE ITEM SEARCH*/$BDLY_SRC_SelectQuery['3']['189'] = "SELECT U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.EU_INVOICE_ITEMS='$BDLY_SRC_invoiceitemssrcvalue' ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC ";
        /*INVOICE FROM*/$BDLY_SRC_SelectQuery['3']['190'] = "SELECT U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.EU_INVOICE_FROM='$BDLY_SRC_invfromsrcvalue' ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
        /*COMMENTS*/$BDLY_SRC_SelectQuery['3']['185'] = "SELECT U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.EU_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
        /*UNIT NO*/$BDLY_SRC_SelectQuery['3']['191'] = "SELECT U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
        /*-----------------------------------------------------------------------FACILITY USE=4----------------------------------------------------------------------*/
        /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['4']['167'] =  "SELECT U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM  EXPENSE_FACILITY_USE EFU JOIN VW_ACTIVE_UNIT U  ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU.EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EFU.EFU_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EFU.EFU_INVOICE_DATE ASC";
        /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['4']['170'] =  "SELECT U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_FACILITY_USE EFU ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EFU.EFU_INVOICE_DATE ASC";
        /*UNIT NO*/$BDLY_SRC_SelectQuery['4']['191'] =  "SELECT U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM UNIT U JOIN EXPENSE_FACILITY_USE EFU ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,EFU.EFU_INVOICE_DATE ASC";
        /*----------------------------------------------------------------------DIGITAL VOICE=5--------------------------------------------------------------------------*/
        /*ACCOUNT NO*/$BDLY_SRC_SelectQuery['5']['151'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDDV.EDDV_DIGITAL_ACCOUNT_NO='$BDLY_SRC_lb_accountno' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
        /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['5']['153'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDV.EDV_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
        /*DIGITAL VOICE NO*/$BDLY_SRC_SelectQuery['5']['154'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDDV.EDDV_DIGITAL_VOICE_NO='$BDLY_SRC_lb_Digvoiceno' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
        /*FROM PERIOD*/$BDLY_SRC_SelectQuery['5']['155'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_FROM_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDV.EDV_FROM_PERIOD,U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
        /*INVOICE DATE*/$BDLY_SRC_SelectQuery['5']['156'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDV.EDV_INVOICE_DATE,U.UNIT_NO ASC";
        /*INVOICE TO*/$BDLY_SRC_SelectQuery['5']['157'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EC.ECN_ID='$BDLY_SRC_lb_invoiceto' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
        /*TO PERIOD*/$BDLY_SRC_SelectQuery['5']['158'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_TO_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDV.EDV_TO_PERIOD,U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
        /*UNIT NO*/$BDLY_SRC_SelectQuery['5']['191'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDDV.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
        /*----------------------------------------------------------PURCHASE NEW ACCESS CARD=6-------------------------------------------------------------------------------*/
        /*CARD NO*/$BDLY_SRC_SelectQuery['6']['174'] = "SELECT U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN VW_ACTIVE_UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.EPNC_NUMBER='$BDLY_SRC_lb_cardno' ORDER BY U.UNIT_NO,EPC.EPNC_INVOICE_DATE ASC";
        /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['6']['175'] = "SELECT U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN VW_ACTIVE_UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.EPNC_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EPC.EPNC_INVOICE_DATE ASC";
        /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['6']['177'] = "SELECT U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN VW_ACTIVE_UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EPC.EPNC_INVOICE_DATE,U.UNIT_NO ASC";
        /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['6']['191'] = "SELECT U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.UNIT_ID ='$BDLY_SRC_lb_unitno' ORDER BY EPC.EPNC_INVOICE_DATE ASC";
        /*----------------------------------------------------------MOVING IN OUT=7-------------------------------------------------------------------------------------*/
        /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['7']['171'] = "SELECT U.UNIT_NO,DATE_FORMAT(M.EMIO_INVOICE_DATE,'%d-%m-%Y') AS COMMENTSDATE,M.EMIO_AMOUNT,M.EMIO_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(M.EMIO_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS MOVING_TIMESTAMP FROM EXPENSE_MOVING_IN_AND_OUT M JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=M.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=M.ULD_ID AND M.EMIO_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND M.EMIO_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,M.EMIO_INVOICE_DATE ASC";
        /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['7']['173'] = "SELECT U.UNIT_NO,DATE_FORMAT(M.EMIO_INVOICE_DATE,'%d-%m-%Y') AS COMMENTSDATE,M.EMIO_AMOUNT,M.EMIO_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(M.EMIO_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS MOVING_TIMESTAMP FROM EXPENSE_MOVING_IN_AND_OUT M JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=M.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=M.ULD_ID AND M.EMIO_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY M.EMIO_INVOICE_DATE,U.UNIT_NO ASC";
        /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['7']['191'] = "SELECT U.UNIT_NO,DATE_FORMAT(M.EMIO_INVOICE_DATE,'%d-%m-%Y') AS COMMENTSDATE,M.EMIO_AMOUNT,M.EMIO_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(M.EMIO_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS MOVING_TIMESTAMP FROM EXPENSE_MOVING_IN_AND_OUT M JOIN UNIT U ON U.UNIT_ID=M.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=M.ULD_ID AND M.EMIO_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,M.EMIO_INVOICE_DATE ASC";
        /*------------------------------------------------------------CAR PARK=8------------------------------------------------------------------------------------------*/
        /*CAR NO SEARCH*/$BDLY_SRC_SelectQuery['8']['127'] = "SELECT U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDCP.EDCP_CAR_NO='$BDLY_SRC_lb_carno' ORDER BY U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
        /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['8']['128'] = "SELECT U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND ECP.ECP_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
        /*FROM PERIOD SEARCH*/$BDLY_SRC_SelectQuery['8']['129'] = "SELECT U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_FROM_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ECP.ECP_FROM_PERIOD,U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
        /*TO PERIOD SEARCH*/$BDLY_SRC_SelectQuery['8']['130'] = "SELECT U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_TO_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ECP.ECP_TO_PERIOD,U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
        /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['8']['131'] = "SELECT U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ECP.ECP_INVOICE_DATE,U.UNIT_NO ASC";
        /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['8']['191'] = "SELECT U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDCP.UNIT_ID ='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
        /*-----------------------------------------------------------AIRCON SERVICE=9-------------------------------------------------------------------------------------------------*/
        /*AIRCON SERVICE BY SEARCH*/$BDLY_SRC_SelectQuery['9']['124'] = "SELECT U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN VW_ACTIVE_UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EASB.EASB_DATA='$BDLY_SRC_lb_serviceby' ORDER BY U.UNIT_NO,EAS.EAS_DATE ASC";
        /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['9']['125'] = "SELECT U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN VW_ACTIVE_UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EAS.EAS_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EAS.EAS_DATE ASC";
        /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['9']['126'] = "SELECT U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN VW_ACTIVE_UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EAS.EAS_DATE,U.UNIT_NO ASC";
        /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['9']['191'] = "SELECT U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,EAS.EAS_DATE ASC";
        /*AIRCON DUE SEARCH*/if($BDLY_SRC_lb_serachopt==197){
            $BDLY_SRC_Aircon_DueDatefromdate =date("Y-m-01", strtotime($BDLY_SRC_servicedue));
            $BDLY_SRC_Aircon_DueDatetodate =date("Y-m-t", strtotime($BDLY_SRC_servicedue));
            $BDLY_SRC_SelectQuery['9']['197'] = "SELECT U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN VW_ACTIVE_UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN SUBDATE('$BDLY_SRC_Aircon_DueDatefromdate',INTERVAL 3 MONTH) AND SUBDATE('$BDLY_SRC_Aircon_DueDatetodate',INTERVAL 3 MONTH) ORDER BY EAS.EAS_DATE,U.UNIT_NO ASC";
        }
        /*-------------------------------------------------------------PETTY CASH=10----------------------------------------------------------------------------*/
        /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['10']['136'] = "SELECT DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EPC.EPC_DATE ASC";
        /*INVOICE ITEM*/$BDLY_SRC_SelectQuery['10']['139'] = "SELECT DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate'  AND EPC.EPC_INVOICE_ITEMS='$BDLY_SRC_invoiceitemssrcvalue' ORDER BY EPC.EPC_DATE ASC";
        /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['10']['140'] = "SELECT DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.EPC_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY EPC.EPC_DATE ASC";
        /*------------------------------------------------------------HOUSE KEEPING=11----------------------------------------------------------------------------*/
        /*EMP NAME SEARCH*/$BDLY_SRC_SelectQuery['11']['141'] = "SELECT CONCAT(ED.EMP_FIRST_NAME,' ',ED.EMP_LAST_NAME) AS NAME ,DATE_FORMAT(EHK.EHK_WORK_DATE,'%d-%m-%Y') AS DATE,EHK.EHK_DURATION,EHK.EHK_DESCRIPTION,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHK.EHK_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHK_TIMESTAMP FROM EXPENSE_HOUSEKEEPING EHK JOIN EMPLOYEE_DETAILS ED ON ED.EMP_ID=EHK.EMP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHK.ULD_ID AND EHK.EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHK.EMP_ID='$BDLY_SRC_lb_cleanername' ORDER BY EHK.EHK_WORK_DATE ASC";
        if($BDLY_SRC_lb_serachopt==142)
        {
            /*FOR PERIOD DURATION SEARCH*/$BDLY_SRC_SelectQuery['11']['142'] = "SELECT DURATION,AMOUNT FROM $BDLY_SRC_electemp_name";
        }
        // SELECT DURATION,AMOUNT FROM TEMP_HOUSEKEEPING_DURATION_AMOUNT
        /*DESCRIPTION SEARCH*/$BDLY_SRC_SelectQuery['11']['143'] = "SELECT CONCAT(ED.EMP_FIRST_NAME,' ',ED.EMP_LAST_NAME) AS NAME ,DATE_FORMAT(EHK.EHK_WORK_DATE,'%d-%m-%Y') AS DATE,EHK.EHK_DURATION,EHK.EHK_DESCRIPTION,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHK.EHK_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHK_TIMESTAMP FROM EXPENSE_HOUSEKEEPING EHK JOIN EMPLOYEE_DETAILS ED ON ED.EMP_ID=EHK.EMP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHK.ULD_ID AND EHK.EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHK.EHK_DESCRIPTION ='$BDLY_SRC_commentssrcvalue' ORDER BY EHK.EHK_WORK_DATE ASC";
        /*WORK DATE SEARCH*/$BDLY_SRC_SelectQuery['11']['145'] = "SELECT CONCAT(ED.EMP_FIRST_NAME,' ',ED.EMP_LAST_NAME) AS NAME ,DATE_FORMAT(EHK.EHK_WORK_DATE,'%d-%m-%Y') AS DATE,EHK.EHK_DURATION,EHK.EHK_DESCRIPTION,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHK.EHK_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHK_TIMESTAMP FROM EXPENSE_HOUSEKEEPING EHK JOIN EMPLOYEE_DETAILS ED ON ED.EMP_ID=EHK.EMP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHK.ULD_ID AND EHK.EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EHK.EHK_WORK_DATE ASC";
        /*DURATION SEARCH*/if($BDLY_SRC_lb_serachopt==144)
        {
            $BDLY_SRC_duration=$_POST['BDLY_SRC_duration'];
            $BDLY_SRC_SelectQuery['11']['144']="SELECT CONCAT(ED.EMP_FIRST_NAME,' ',ED.EMP_LAST_NAME) AS NAME ,DATE_FORMAT(EHK.EHK_WORK_DATE,'%d-%m-%Y') AS DATE,EHK.EHK_DURATION,EHK.EHK_DESCRIPTION,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHK.EHK_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHK_TIMESTAMP FROM EXPENSE_HOUSEKEEPING EHK JOIN EMPLOYEE_DETAILS ED ON ED.EMP_ID=EHK.EMP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHK.ULD_ID AND EHK.EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHK.EHK_DURATION BETWEEN '$BDLY_SRC_duration[0]' AND '$BDLY_SRC_duration[1]' ORDER BY EHK.EHK_DURATION,EHK.EHK_WORK_DATE ASC";
        }
        /*---------------------------------------------------------------HOUSEKEEPING PAYMENT=12-----------------------------------------------------------------*/
        /*COMMENTS SEARCH*/  $BDLY_SRC_SelectQuery['12']['146'] = "SELECT UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,EHKP.EHKP_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM $BDLY_SRC_tmptbl_hkpsrch EHKP WHERE EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHKP.EHKP_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY UNIT_NO,EHKP.EHKP_PAID_DATE ASC";
        /*FOR PERIOD SEARCH*/if($BDLY_SRC_lb_serachopt==147)
        {
            $BDLY_SRC_startforperiodfromdate =date("Y-m-01", strtotime($_POST['BDLY_SRC_startforperiod']));
            $BDLY_SRC_startforperiodtodate =date("Y-m-t", strtotime($_POST['BDLY_SRC_endforperiod']));
            $BDLY_SRC_SelectQuery['12']['147'] = "SELECT UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,EHKP.EHKP_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM $BDLY_SRC_tmptbl_hkpsrch EHKP WHERE EHKP.EHKP_FOR_PERIOD BETWEEN '$BDLY_SRC_startforperiodfromdate' AND '$BDLY_SRC_startforperiodtodate' ORDER BY EHKP.EHKP_FOR_PERIOD,UNIT_NO ASC";
        }
        /*PAID DATE SEARCH*/ $BDLY_SRC_SelectQuery['12']['149'] = "SELECT UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,EHKP.EHKP_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM $BDLY_SRC_tmptbl_hkpsrch EHKP WHERE EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EHKP.EHKP_PAID_DATE,UNIT_NO ASC";
        /*UNIT NO SEARCH*/ $BDLY_SRC_SelectQuery['12']['198'] = "SELECT EHKU_UNIT_NO,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHKU.EHKU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKU_TIMESTAMP FROM EXPENSE_HOUSEKEEPING_UNIT EHKU,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EHKU.ULD_ID ORDER BY EHKU_UNIT_NO ASC";
        /*WITH UNIT NO SEARCH*/ if($BDLY_SRC_lb_ExpenseList_val==12 && $BDLY_SRC_lb_serachopt==150){
            $BDLY_SRC_Merged_UnitNo=$_POST['BDLY_SRC_lb_unitno'];
            $BDLY_SRC_Sep_Unit_Id=explode(" ",$BDLY_SRC_Merged_UnitNo);
            if (strlen(strstr($BDLY_SRC_Merged_UnitNo,"HKUNIT"))>0)
                $BDLY_SRC_SelectQuery['12']['150'] = "SELECT EHKU.EHKU_UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM EXPENSE_HOUSEKEEPING_PAYMENT EHKP JOIN EXPENSE_HOUSEKEEPING_UNIT AS EHKU ON EHKP.EHKU_ID = EHKU.EHKU_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHKP.ULD_ID AND EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHKU.EHKU_ID='$BDLY_SRC_Sep_Unit_Id[0]' ORDER BY EHKP.EHKP_PAID_DATE ASC";
            else
                $BDLY_SRC_SelectQuery['12']['150'] = "SELECT U.UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM EXPENSE_HOUSEKEEPING_PAYMENT EHKP JOIN UNIT U ON EHKP.UNIT_ID = U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHKP.ULD_ID AND EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_Sep_Unit_Id[0]' ORDER BY EHKP.EHKP_PAID_DATE ASC";
        }
        /*********************************************************************All type amount search******************************************************************/
        if (isset($_POST['BDLY_SRC_tb_fromamnt'])) {
            $BDLY_SRC_tb_fromamnt=$_POST['BDLY_SRC_tb_fromamnt'];
            if($BDLY_SRC_lb_ExpenseList_val==1)//ELECTRICITY
            {
                //INVOICE AMOUNT SEARCH OPTION ID-163
                $BDLY_SRC_SelectQuery['1']['163'] = "SELECT EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y') AS EE_FROM_PERIOD,DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y') AS EE_TO_PERIOD,EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') FROM $BDLY_SRC_electemp_name ORDER BY EE_INVOICE_AMOUNT,EE_UNITNO,EE_INVOICE_DATE ASC";
                //DEPOSIT AMOUNT SEARCH OPTION ID-160
                $BDLY_SRC_SelectQuery['1']['160'] = "SELECT EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y') AS EE_FROM_PERIOD,DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y') AS EE_TO_PERIOD,EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') FROM $BDLY_SRC_electemp_name ORDER BY EE_DEPOSIT,EE_UNITNO,EE_INVOICE_DATE ASC";
                //DEPOSIT REFUND AMOUNT SEARCH OPTION ID-161
                $BDLY_SRC_SelectQuery['1']['161'] = "SELECT EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y') AS EE_FROM_PERIOD,DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y') AS EE_TO_PERIOD,EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') FROM $BDLY_SRC_electemp_name ORDER BY EE_DEPOSIT_REFUND,EE_UNITNO,EE_INVOICE_DATE ASC";
            }
            /*STARHUB AMNT*/$BDLY_SRC_SelectQuery['2']['181'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND ESH.ESH_AMOUNT BETWEEN '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY ESH_AMOUNT,U.UNIT_NO,ESH_INVOICE_DATE ASC ";
            /*UNIT EXPENSE AMNT*/$BDLY_SRC_SelectQuery['3']['187'] = "SELECT U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.EU_AMOUNT BETWEEN '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EU.EU_AMOUNT,U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
            /*FACILITY USE DEPOSIT AMNT*/$BDLY_SRC_SelectQuery['4']['168'] = "SELECT U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_FACILITY_USE EFU ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EFU.EFU_DEPOSIT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EFU.EFU_DEPOSIT,U.UNIT_NO,EFU.EFU_INVOICE_DATE ASC";
            /*FACILITY USE INVOICE AMNT*/$BDLY_SRC_SelectQuery['4']['169'] = "SELECT U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_FACILITY_USE EFU ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EFU.EFU_AMOUNT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EFU.EFU_AMOUNT,U.UNIT_NO,EFU.EFU_INVOICE_DATE ASC";
            /*DIGITAL VOICE*/$BDLY_SRC_SelectQuery['5']['152'] = "SELECT U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDV.EDV_AMOUNT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EDV.EDV_AMOUNT,U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
            /*PURCHASE CARD AMNT*/$BDLY_SRC_SelectQuery['6']['176'] = "SELECT U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN VW_ACTIVE_UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.EPNC_AMOUNT BETWEEN '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EPC.EPNC_AMOUNT,U.UNIT_NO,EPC.EPNC_INVOICE_DATE ASC";
            /*MOVING IN OUT AMNT*/$BDLY_SRC_SelectQuery['7']['172'] = "SELECT U.UNIT_NO,DATE_FORMAT(M.EMIO_INVOICE_DATE,'%d-%m-%Y') AS COMMENTSDATE,M.EMIO_AMOUNT,M.EMIO_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(M.EMIO_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS MOVING_TIMESTAMP FROM EXPENSE_MOVING_IN_AND_OUT M JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=M.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=M.ULD_ID AND  M.EMIO_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate'AND M.EMIO_AMOUNT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY M.EMIO_AMOUNT,U.UNIT_NO,M.EMIO_INVOICE_DATE ASC";
            /*CAR PARK AMNT*/$BDLY_SRC_SelectQuery['8']['132'] = "SELECT U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND ECP.ECP_AMOUNT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY ECP.ECP_AMOUNT,U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
            /*PETTY CASH CASH IN AMT*/$BDLY_SRC_SelectQuery['10']['137'] = "SELECT DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC_CASH_IN  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EPC_CASH_IN,EPC.EPC_DATE ASC";
            /*PETTY CASH CASH OUT AMT*/$BDLY_SRC_SelectQuery['10']['138'] = "SELECT DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC ,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC_CASH_OUT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EPC_CASH_OUT,EPC.EPC_DATE ASC";
            /*HOUSE KEEPING PAYMENT AMNT*/$BDLY_SRC_SelectQuery['12']['148'] ="SELECT UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,EHKP.EHKP_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM $BDLY_SRC_tmptbl_hkpsrch EHKP WHERE  EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHKP.EHKP_AMOUNT BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EHKP.EHKP_AMOUNT,UNIT_NO,EHKP.EHKP_PAID_DATE ASC";
        }
        $execute_statement = $this->db->query($BDLY_SRC_SelectQuery[$BDLY_SRC_lb_ExpenseList_val][$BDLY_SRC_lb_serachopt]);
        $headerarrdata=array();
        foreach ($execute_statement->list_fields() as $field)
        {
            $headerarrdata[] = $field;
        }

        foreach ($execute_statement->result_array() as $row)
        {
            $rowarray =[];$Totalcolumns=count($BDLY_SRC_GridHeaders);
            for($x=0; $x<$Totalcolumns; $x++){
                if($BDLY_SRC_lb_serachopt==142&&$x==2){
                    $rowarray[]=number_format($row[$headerarrdata[$x]],2);
                }
                else
                {
                    $rowarray[]=$row[$headerarrdata[$x]];
                }
            }
            $BDLY_SRC_Expdataobject[]=$rowarray;
        }
        if(($BDLY_SRC_lb_ExpenseList_val==1)||($BDLY_SRC_lb_serachopt==142))
        {
            $this->BDLY_SRC_drophkpaymentsptemptable($BDLY_SRC_electemp_name);
        }

        $this->BDLY_SRC_drophkpaymentsptemptable($BDLY_SRC_tmptbl_hkpsrch);


        if($BDLY_SRC_lb_serachopt==142||$BDLY_SRC_lb_serachopt==198)
        {
            if($BDLY_SRC_lb_serachopt==142)
            {
                $BDLY_SRC_GridHeaders=[11=>['TOTAL DURATION','TOTAL AMOUNT']];
            }
            if($BDLY_SRC_lb_serachopt==198)
            {
                $BDLY_SRC_GridHeaders=[12=>['UNIT NO','USERSTAMP','TIMESTAMP']];
            }
        }
        else
        {
            $BDLY_SRC_GridHeaders=[1=>['UNIT NO','INVOICE TO','INVOICE DATE','FROM PERIOD','TO PERIOD','DEPOSIT','DEPOSIT REFUND','INVOICE AMOUNT','COMMENTS','USERSTAMP','TIMESTAMP'],
                2=>['UNIT NO','INVOICE TO','ACCOUNT NO','INVOICE DATE','FROM PERIOD','TO PERIOD','INVOICE AMOUNT','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                3=>['UNIT NO','CATEGORY','CUSTOMER','INVOICE DATE','INVOICE ITEMS','INVOICE FROM','INVOICE AMOUNT','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                4=>['UNIT NO','INVOICE DATE','DEPOSIT','INVOICE AMOUNT','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                5=>['UNIT NO','INVOICE TO','DIGITAL VOICE NO','ACCOUNT NO','INVOICE DATE','FROM PERIOD','TO PERIOD','INVOICE AMOUNT','COMMENTS','USERSTAMP','TIMESTAMP'],
                6=>['UNIT NO','CARD NUMBER','INVOICE DATE','INVOICE AMOUNT','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                7=>['UNIT NO','INVOICE DATE','INVOICE AMOUNT','COMMENTS','USERSTAMP','TIMESTAMP'],
                8=>['UNIT NO','CAR NO','INVOICE DATE','FROM PERIOD','TO PERIOD','INVOICE AMOUNT','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                9=>['UNIT NO','AIRCON SERVICE BY','INVOICE DATE','COMMENTS','USERSTAMP','TIMESTAMP'],
                10=>['INVOICE DATE','CASH IN','CASH OUT','CURRENT BALANCE','INVOICE ITEMS','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                11=>['CLEANER NAME','WORK DATE','DURATION','DESCRIPTION','USERSTAMP','TIMESTAMP'],
                12=>['UNIT NO','INVOICE AMOUNT','FOR PERIOD','PAID DATE','COMMENTS','USERSTAMP','TIMESTAMP']];
        }
        $appendtable="<br><br><table  border='1'  style='border-collapse: collapse;width: 1000px' cellspacing='0' data-class='table'  class='srcresult table'><thead>";
        $appendtable .="<tr>";
        for($i=0;$i<count($BDLY_SRC_GridHeaders[$BDLY_SRC_lb_ExpenseList_val]);$i++)
        {
            $appendtable.="<th style='color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;'>".$BDLY_SRC_GridHeaders[$BDLY_SRC_lb_ExpenseList_val][$i]."</th>";
        }
        $appendtable .="</tr></thead><tbody>";
        for($j=0;$j<count($BDLY_SRC_Expdataobject);$j++)
        {
            $appendtable .="<tr>";
            for($y = 0; $y <count($BDLY_SRC_Expdataobject[$j]); $y++) {
                $appendtable .="<td>".$BDLY_SRC_Expdataobject[$j][$y]."</td>";
            }
            $appendtable .="</tr>";
        }
        $appendtable .="</tbody></table>";
        return $appendtable;
   }
    /*------------------------------------FUNCTION FOR FETCHING FLEX TABLE FOR AIRCON-------------------------------------------------*/
    public function BTDTL_SEARCH_flex_aircon($BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
    {
        if($BTDTL_SEARCH_searchby==100)//-AIRCON SERVICED BY
        {
            $BTDTL_SEARCH_airconserviced_selectquery = "SELECT EASB.EASB_ID,EASB.EASB_DATA,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EASB.EASB_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EASB_TIMESTAMP FROM EXPENSE_AIRCON_SERVICE_BY EASB,USER_LOGIN_DETAILS ULD WHERE EASB.ULD_ID=ULD.ULD_ID AND EASB_DATA!='' ORDER BY EASB_DATA ASC";
            $BTDTL_SEARCH_airconservicedby_rs = $this->db->query($BTDTL_SEARCH_airconserviced_selectquery);
            $BTDTL_SEARCH_tr ='<br><br><table border="1"  style="border-collapse: collapse;width: 1000px" cellspacing="0" data-class="table"  class="srcresult table"><thead><tr><th style="width:300px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">AIRCON SERVICED BY</th><th style="width:250px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th style="width:180px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
            foreach($BTDTL_SEARCH_airconservicedby_rs->result_array() as $row)
            {
                $easbdata=$row["EASB_DATA"];
                $logindi=$row["ULD_LOGINID"];
                $timestamp=$row["EASB_TIMESTAMP"];
                $BTDTL_SEARCH_tr.='<tr><td>'.$easbdata.'</td><td>'.$logindi.'</td><td>'.$timestamp.'</td></tr>';
            }
            $BTDTL_SEARCH_tr.='</tbody></table>';

        }
        else
        {
        if($BTDTL_SEARCH_searchby==101)//SEARCH BY AIRCON COMMENTS
        {
            $BTDTL_SEARCH_searchval=$this->db->escape_like_str($BTDTL_SEARCH_searchval);
            $BTDTL_SEARCH_search_aircon = "SELECT EDAS.EDAS_ID,U.UNIT_ID,U.UNIT_NO,EASB.EASB_DATA,EDAS.EDAS_REC_VER,EDAS.EDAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDAS.EDAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_AIRCON_SERVICE_BY EASB, EXPENSE_DETAIL_AIRCON_SERVICE EDAS,UNIT U,VW_ACTIVE_UNIT VAU,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDAS.ULD_ID AND EDAS.UNIT_ID=U.UNIT_ID AND EDAS.UNIT_ID=VAU.UNIT_ID AND EDAS.EDAS_COMMENTS='$BTDTL_SEARCH_searchval' AND EDAS.EASB_ID=EASB.EASB_ID  ORDER BY EDAS.EDAS_COMMENTS,U.UNIT_NO";
        }
        else if($BTDTL_SEARCH_searchby==195)//SEARCH BY AIRCON SERVICED BY UNIT
        {
            $BTDTL_SEARCH_search_aircon = "SELECT EDAS.EDAS_ID,U.UNIT_ID,U.UNIT_NO,EASB.EASB_DATA,EDAS.EDAS_REC_VER,EDAS.EDAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDAS.EDAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS,EXPENSE_AIRCON_SERVICE_BY EASB,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDAS.ULD_ID AND EASB.EASB_ID=EDAS.EASB_ID AND U.UNIT_ID=EDAS.UNIT_ID AND EDAS.UNIT_ID=VAU.UNIT_ID AND EASB.EASB_DATA='$BTDTL_SEARCH_searchval' ORDER BY U.UNIT_NO,EASB.EASB_DATA";
        }
        else if($BTDTL_SEARCH_searchby==191)//SEARCH BY UNIT NO
        {
            $BTDTL_SEARCH_search_aircon = "SELECT EDAS.EDAS_ID,U.UNIT_ID,U.UNIT_NO,EASB.EASB_DATA,EDAS.EDAS_REC_VER,EDAS.EDAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDAS.EDAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS, EXPENSE_AIRCON_SERVICE_BY EASB, UNIT U ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDAS.ULD_ID AND U.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$BTDTL_SEARCH_searchval') AND  EDAS.EASB_ID=EASB.EASB_ID AND U.UNIT_ID=EDAS.UNIT_ID ORDER BY U.UNIT_NO ASC";
        }

        $BTDTL_SEARCH_aircon_rs= $this->db->query($BTDTL_SEARCH_search_aircon);
        $BTDTL_SEARCH_tr ='<br><br><table border="1"  style="border-collapse: collapse;width: 1000px" cellspacing="0" data-class="table"  class="srcresult table"><thead><tr><th style="width:75px; color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">UNIT NUMBER</th><th style="width:300px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">AIRCON SERVICED BY</th><th style="width:300px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">COMMENTS</th><th style="width:250px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th style="width:130px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach($BTDTL_SEARCH_aircon_rs->result_array() as $row)
        {
            $BTDTL_SEARCH_aircon_unitno = $row['UNIT_NO'];
            $BTDTL_SEARCH_aircon_data = $row['EASB_DATA'];
            $BTDTL_SEARCH_aircon_comments = $row['EDAS_COMMENTS'];
            $BTDTL_SEARCH_aircon_userstamp = $row['ULD_LOGINID'];
            $BTDTL_SEARCH_aircon_timestamp = $row['TIMESTAMP'];
            $BTDTL_SEARCH_tr.='<tr><td>'.$BTDTL_SEARCH_aircon_unitno.'</td><td>'.$BTDTL_SEARCH_aircon_data.'</td><td>'.$BTDTL_SEARCH_aircon_comments.'</td><td>'.$BTDTL_SEARCH_aircon_userstamp.'</td><td>'.$BTDTL_SEARCH_aircon_timestamp.'</td></tr>';
        }
        $BTDTL_SEARCH_tr.='</tbody></table>';
        }
        return $BTDTL_SEARCH_tr;
    }
    /*-----------------------------------------------FUNCTION FOR CARPARK SHOWING FLEX TABLE--------------------------------------------------*/
    public  function BTDTL_SEARCH_show_carpark($BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
    {
        if($BTDTL_SEARCH_searchby==102){//CAR NO
            $BTDTL_SEARCH_search_carpark = "SELECT EDCP.EDCP_ID,U.UNIT_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,EDCP.EDCP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDCP.EDCP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT U, EXPENSE_DETAIL_CARPARK EDCP,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDCP.ULD_ID AND U.UNIT_ID= EDCP.UNIT_ID AND EDCP.EDCP_CAR_NO ='$BTDTL_SEARCH_searchval' AND EDCP.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO, EDCP.EDCP_CAR_NO";
        }
        else if($BTDTL_SEARCH_searchby==103){//CARPARK COMMENTS
            $BTDTL_SEARCH_searchval=$this->db->escape_like_str($BTDTL_SEARCH_searchval);
            $BTDTL_SEARCH_search_carpark = "SELECT EDCP.EDCP_ID,U.UNIT_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,EDCP.EDCP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDCP.EDCP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT U, EXPENSE_DETAIL_CARPARK EDCP,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDCP.ULD_ID AND U.UNIT_ID=EDCP.UNIT_ID AND EDCP.EDCP_COMMENTS='$BTDTL_SEARCH_searchval' AND EDCP.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDCP.EDCP_COMMENTS";
        }
        else if($BTDTL_SEARCH_searchby==191)//UNIT No
        {
            $BTDTL_SEARCH_search_carpark = "SELECT EDCP.EDCP_ID,U.UNIT_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,EDCP.EDCP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDCP.EDCP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT U, EXPENSE_DETAIL_CARPARK EDCP ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDCP.ULD_ID AND U.UNIT_ID= (SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$BTDTL_SEARCH_searchval') AND U.UNIT_ID=EDCP.UNIT_ID ORDER BY U.UNIT_NO ASC";
        }
        $BTDTL_SEARCH_carpark_rs = $this->db->query($BTDTL_SEARCH_search_carpark);
        $BTDTL_SEARCH_tr ='<br><br><table border="1"  style="border-collapse: collapse;width: 1000px" cellspacing="0" data-class="table"  class="srcresult table"><thead><tr><th style="width:75px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">UNIT NUMBER</th><th style="width:80px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">CAR NO</th><th style="width:250px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">COMMENTS</th><th style="width:250px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th style="width:130px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach($BTDTL_SEARCH_carpark_rs->result_array() as $row)
        {
            $unitno=$row['UNIT_NO'];
            $carno=$row['EDCP_CAR_NO'];
            $comments=$row['EDCP_COMMENTS'];
            $loginid=$row['ULD_LOGINID'];
            $timestamp=$row['TIMESTAMP'];
            $BTDTL_SEARCH_tr.='<tr><td>'.$unitno.'</td><td>'.$carno.'</td><td>'.$comments.'</td><td>'.$loginid.'</td><td>'.$timestamp.'</td></tr>';
        }
        $BTDTL_SEARCH_tr.='</tbody></table>';
        return $BTDTL_SEARCH_tr;
    }
    /*---------------------------------------FUNCTION FOR DIGITAL SHOWING FLEX TABLE-----------------------------------------------------------*/
    public  function BTDTL_SEARCH_show_digital($BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
    {
        if($BTDTL_SEARCH_searchby==109)//SEARCH BY DIGITAL ACCOUNT NO
        {
            $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV LEFT JOIN EXPENSE_CONFIGURATION EC ON EDDV.ECN_ID=EC.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.EDDV_DIGITAL_ACCOUNT_NO='$BTDTL_SEARCH_searchval' AND EDDV.UNIT_ID=U.UNIT_ID  AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO";
        }
        else if($BTDTL_SEARCH_searchby==108)//SEARCH BY DIGITAL COMMENTS
        {
            $BTDTL_SEARCH_searchval=$this->db->escape_like_sr($BTDTL_SEARCH_searchval);
            $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV LEFT JOIN EXPENSE_CONFIGURATION EC ON EDDV.ECN_ID=EC.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.EDDV_COMMENTS='$BTDTL_SEARCH_searchval' AND EDDV.UNIT_ID=U.UNIT_ID  AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDDV.EDDV_COMMENTS";
        }
        else if($BTDTL_SEARCH_searchby==107)//SEARCH BY DIGITAL INVOICE TO
        {
            $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_CONFIGURATION EC,UNIT U,EXPENSE_DETAIL_DIGITAL_VOICE EDDV,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.ECN_ID ='$BTDTL_SEARCH_searchval' AND EDDV.UNIT_ID=U.UNIT_ID AND EDDV.ECN_ID=EC.ECN_ID AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EC.ECN_DATA";
        }
        else if($BTDTL_SEARCH_searchby==106)//SEARCH BY DIGITAL VOICE NO
        {
            $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV LEFT JOIN EXPENSE_CONFIGURATION EC ON EDDV.ECN_ID=EC.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.EDDV_DIGITAL_VOICE_NO='$BTDTL_SEARCH_searchval' AND EDDV.UNIT_ID=U.UNIT_ID AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDDV.EDDV_DIGITAL_VOICE_NO";
        }
        else if($BTDTL_SEARCH_searchby==191)//SEARCH BY UNIT NO
        {
            $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV LEFT JOIN EXPENSE_CONFIGURATION EC ON EDDV.ECN_ID=EC.ECN_ID,UNIT U ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO ='$BTDTL_SEARCH_searchval') AND EDDV.UNIT_ID=U.UNIT_ID ORDER BY U.UNIT_NO ASC";
        }
        $BTDTL_SEARCH_digital_rs=$this->db->query($BTDTL_SEARCH_select_digital);
        $BTDTL_SEARCH_tr ='<br><br><table border="1"  style="border-collapse: collapse;width: 1000px" cellspacing="0" data-class="table"  class="srcresult table"><thead><tr><th style="width:75px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">UNIT NUMBER</th><th style="width:150px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">INVOICE TO</th><th style="width:80px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">DIGITAL VOICE NO</th><th style="width:110px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">DIGITAL ACCOUNT NO</th><th style="width:300px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">COMMENTS</th><th style="width:250px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th style="width:130px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach($BTDTL_SEARCH_digital_rs->result_array() as $row)
        {
            $unitno=$row['UNIT_NO'];
            $ecndata=$row['ECN_DATA'];
            $voiceno=$row['EDDV_DIGITAL_VOICE_NO'];
            $acctno=$row['EDDV_DIGITAL_ACCOUNT_NO'];
            $comments=$row['EDDV_COMMENTS'];
            $loginid=$row['ULD_LOGINID'];
            $timestamp=$row['TIMESTAMP'];
            $BTDTL_SEARCH_tr.='<tr><td>'.$unitno.'</td><td>'.$ecndata.'</td><td>'.$voiceno.'</td><td>'.$acctno.'</td><td>'.$comments.'</td><td>'.$loginid.'</td><td>'.$timestamp.'</td></tr>';
        }
        $BTDTL_SEARCH_tr.='</tbody></table>';
       return $BTDTL_SEARCH_tr;
    }
    /*--------------------------------------------FETCHING ELECTRICITY FOR LOADING FLEX TABLE--------------------------------------------------*/
    public   function BTDTL_SEARCH_show_electricity($BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
    {
        if($BTDTL_SEARCH_searchby==104)//SEARCH BY ELECTRICITY COMMENTS
        {
            $BTDTL_SEARCH_searchval=$this->db->escape_like_str($BTDTL_SEARCH_searchval);
            $BTDTL_SEARCH_select_electricity="SELECT EDE.EDE_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDE.EDE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDE.EDE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP  FROM EXPENSE_DETAIL_ELECTRICITY EDE,EXPENSE_CONFIGURATION EC,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDE.ULD_ID AND EDE.EDE_COMMENTS='$BTDTL_SEARCH_searchval' AND EDE.ECN_ID=EC.ECN_ID AND EDE.UNIT_ID=U.UNIT_ID AND EDE.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDE.EDE_COMMENTS";
        }
        else if($BTDTL_SEARCH_searchby==105)//SEARCH BY ELECTRICITY INVOICE TO
        {
            $BTDTL_SEARCH_select_electricity="SELECT EDE.EDE_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDE.EDE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDE.EDE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP  FROM EXPENSE_DETAIL_ELECTRICITY EDE,EXPENSE_CONFIGURATION EC,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDE.ULD_ID AND EDE.ECN_ID ='$BTDTL_SEARCH_searchval' AND EDE.ECN_ID=EC.ECN_ID AND EDE.UNIT_ID=U.UNIT_ID AND EDE.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EC.ECN_DATA";
        }
        else if($BTDTL_SEARCH_searchby==191)//SEARCH BY UNIT NO
        {
            $BTDTL_SEARCH_select_electricity ="SELECT EDE.EDE_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDE.EDE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDE.EDE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP  FROM EXPENSE_DETAIL_ELECTRICITY EDE,EXPENSE_CONFIGURATION EC,UNIT U,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDE.ULD_ID AND EDE.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$BTDTL_SEARCH_searchval') AND EDE.ECN_ID=EC.ECN_ID AND EDE.UNIT_ID=U.UNIT_ID ORDER BY U.UNIT_NO ASC";
        }
        $BTDTL_SEARCH_electricity_rs=$this->db->query($BTDTL_SEARCH_select_electricity);
        $BTDTL_SEARCH_tr ='<br><br><table border="1"  style="border-collapse: collapse;width: 1000px" cellspacing="0" data-class="table"  class="srcresult table"><thead><tr><th style="width:75px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">UNIT NUMBER</th><th style="width:140px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">INVOICE TO</th><th style="width:300px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">COMMENTS</th><th style="width:250px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th style="width:130px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
        foreach($BTDTL_SEARCH_electricity_rs->result_array() as $row)
        {
            $unitno=$row['UNIT_NO'];
            $ecndata=$row['ECN_DATA'];
            $comments=$row['EDE_COMMENTS'];
            $loginid=$row['ULD_LOGINID'];
            $timestamp=$row['TIMESTAMP'];
            $BTDTL_SEARCH_tr.='<tr><td>'.$unitno.'</td><td>'.$ecndata.'</td><td>'.$comments.'</td><td>'.$loginid.'</td><td>'.$timestamp.'</td></tr>';
        }
        $BTDTL_SEARCH_tr.='</tbody></table>';
       return $BTDTL_SEARCH_tr;
    }
    /*---------------------------------------------FUNCTION FOR STARHUB SHOWING FLEX TABLE-----------------------------------------------------------*/
    public  function BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_date,$BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
    {
        if($BTDTL_SEARCH_date==null)
            $BTDTL_SEARCH_date='';
         if($BTDTL_SEARCH_searchby==123)//SEARCH BY STARTHUB ACCOUNT NO
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID, UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_ACCOUNT_NO='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_ACCOUNT_NO";
        }
        else if($BTDTL_SEARCH_searchby==113)//SEARCH BY STARTHUB CABLE BOX SERIAL NO
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_CABLE_BOX_SERIAL_NO='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_CABLE_BOX_SERIAL_NO";
        }
        else if($BTDTL_SEARCH_searchby==118)//SEARCH BY STARTHUB INVOICE TO
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM VW_ACTIVE_UNIT VAU,UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.ECN_ID='$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EC.ECN_DATA";
        }
        else if($BTDTL_SEARCH_searchby==119)//SEARCH BY STARTHUB MODEM SERIAL NO
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU  ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_MODEM_SERIAL_NO='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_MODEM_SERIAL_NO";
        }
        else if($BTDTL_SEARCH_searchby==121)//SEARCH BY STARTHUB PWD
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU  ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_PWD='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_PWD";
        }
        else if($BTDTL_SEARCH_searchby==120)//SEARCH BY STARTHUB SSID
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU  ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_SSID='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_SSID";
        }
        else if($BTDTL_SEARCH_searchby==191)//SEARCH BY UNIT NO
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND  EDSH.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$BTDTL_SEARCH_searchval') AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO";
        }
        else if($BTDTL_SEARCH_searchby==111)//SEARCH BY STARTHUB APPL DATE
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_APPL_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_APPL_DATE";
        }
        else if($BTDTL_SEARCH_searchby==115)//SEARCH BY STARTHUB CABLE START DATE
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_CABLE_START_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_CABLE_START_DATE";
        }
        else if($BTDTL_SEARCH_searchby==114)//SEARCH BY STARTHUB CABLE END DATE
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_CABLE_END_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_CABLE_END_DATE";
        }
        else if($BTDTL_SEARCH_searchby==117)//SEARCH BY STARTHUB INTERNET START DATE
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_INTERNET_START_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_INTERNET_START_DATE";
        }
        else if($BTDTL_SEARCH_searchby==116)//SEARCH BY STARTHUB INTERNET END DATE
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_INTERNET_END_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_INTERNET_END_DATE";
        }
        else if($BTDTL_SEARCH_searchby==122)//SEARCH BY STARTHUB COMMENTS
        {
            $BTDTL_SEARCH_searchval=$this->db->escape_like_str($BTDTL_SEARCH_searchval);
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID, UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_COMMENTS='$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_COMMENTS";
        }
        else if($BTDTL_SEARCH_searchby==112)//SEARCH BY STARTHUB BASIC GROUP
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID, UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND  EDSH.EDSH_BASIC_GROUP='$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_BASIC_GROUP";
        }
        else if($BTDTL_SEARCH_searchby==110)//SEARCH BY STARTHUB ADDTNL CH
        {
            $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID, UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_ADDTNL_CH='$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_ADDTNL_CH";
        }
        $BTDTL_SEARCH_starhub_rs = $this->db->query($BTDTL_SEARCH_select_starhub);
        $BTDTL_SEARCH_tr = '<br><br><table border="1"  style="border-collapse: collapse;width: 2750px" cellspacing="0" data-class="table"  class="srcresult table"><thead><tr><th style="width:75px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">UNIT NUMBER</th><th style="width:140px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">INVOICE TO</th><th style="width:100px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">STARHUB ACCOUNT NO<em>*</em></th><th style="width:75px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">APPL DATE</th><th style="width:75px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">CABLE START DATE</th><th style="width:75px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">CABLE END DATE</th><th style="width:75px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">INTERNET START DATE</th><th style="width:75px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">INTERNET END DATE</th><th style="width:200px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">SSID</th><th style="width:200px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">PWD</th><th style="width:200px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">CABLE BOX SERIAL NO</th><th style="width:250px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">MODEM SERIAL NO</th><th style="width:200px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">BASIC GROUP</th><th style="width:200px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">ADDTNL CH</th><th style="width:300px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">COMMENTS</th><th style="width:200px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th style="width:130px;color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach($BTDTL_SEARCH_starhub_rs->result_array() as $row)
        {
            $unitno=$row['UNIT_NO'];
            $ecndata=$row['ECN_DATA'];
            $accountno=$row["EDSH_ACCOUNT_NO"];
            $appldate=$row['EDSH_APPL_DATE'];
            $cablestartdate=$row['EDSH_CABLE_START_DATE'];
            $cabelenddate=$row['EDSH_CABLE_END_DATE'];
            $internestartdate=$row['EDSH_INTERNET_START_DATE'];
            $internetenddate=$row['EDSH_INTERNET_END_DATE'];
            $ssid=$row['EDSH_SSID'];
            $pwd=$row['EDSH_PWD'];
            $cableserail=$row['EDSH_CABLE_BOX_SERIAL_NO'];
            $modem=$row['EDSH_MODEM_SERIAL_NO'];
            $basicgroup=$row['EDSH_BASIC_GROUP'];
            $addchnnl=$row['EDSH_ADDTNL_CH'];
            $comments=$row['EDSH_COMMENTS'];
            $loginid=$row['ULD_LOGINID'];
            $timestamp=$row['EDSH_TIMESTAMP'];
            if($appldate==null){$appldate='';}
            if($cablestartdate==null){$cablestartdate='';}
            if($cabelenddate==null){$cabelenddate='';}
            if($internestartdate==null){$internestartdate='';}
            if($internetenddate==null){$internetenddate='';}
            if($ssid==null){$ssid='';}
            if($pwd==null){$pwd='';}
            if($cableserail==null){$cableserail='';}
            if($modem==null){$modem='';}
            if($basicgroup==null){$basicgroup='';}
            if($addchnnl==null){$addchnnl='';}
            if($comments==null){$comments='';}
            $BTDTL_SEARCH_tr .='<tr><td>'.$unitno.'</td><td>'.$ecndata.'</td><td>'.$accountno.'</td><td>'.$appldate.'</td><td>'.$cablestartdate.'</td><td>'.$cabelenddate.'</td><td>'.$internestartdate.'</td><td>'.$internetenddate.'</td><td>'.$ssid.'</td><td>'.$pwd.'</td><td>'.$cableserail.'</td><td>'.$modem.'</td><td>'.$basicgroup.'</td><td>'.$addchnnl.'</td><td>'.$comments.'</td><td>'.$loginid.'</td><td>'.$timestamp.'</td></tr>';
        }
        $BTDTL_SEARCH_tr.='</tbody></table>';
        return $BTDTL_SEARCH_tr;
    }
}

