<?php
/**
* Created by PhpStorm.
* User: SSOMENS-022
* Date: 29-05-2015
* Time: 05:14 PM
*/
//require 'application/PHPMailer-master/PHPMailerAutoload.php';
require_once 'google/appengine/api/mail/Message.php';
use \google\appengine\api\mail\Message;
class Mdl_report_report extends CI_Model {
function __construct() {
    parent::__construct();
    $this->load->model('EILIB/Mdl_eilib_common_function');
}
public function getDataAppendSS($reportNameVal,$reportNameText,$emailId,$categoryName,$month){
//    set_time_limit(0);
    $this->load->model('EILIB/Mdl_eilib_invoice_contract');
    $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
    $this->load->library('Google');
    $service = $this->Mdl_eilib_common_function->get_service_document();
    //GET PRORATE LABEL LINE NO
    $this->db->select("RCN_DATA");
    $this->db->from('REPORT_CONFIGURATION');
    $this->db->where('CGN_ID=48');
    $folderid= $this->db->get()->row()->RCN_DATA;
    $children1 = $service->children->listChildren($folderid);
    $filearray1=$children1->getItems();
    $SSexistflag=0;
    //UNIT,EMP,CUS,EXP,ERM
  //  $REP_selectquery[59]='1,2,3,4,5,30';$REP_selectquery[60]='6';$REP_selectquery[61]='7,8,31';$REP_selectquery[73]='28';$REP_selectquery[82]='32';
    $arrHeaderSS=[1=>[$reportNameText,$categoryName],2=>[$categoryName,$categoryName],3=>[$reportNameText,$categoryName],4=>[$reportNameText,$categoryName],5=>[$reportNameText,$categoryName],30=>[$reportNameText,$categoryName],
    6=>[$categoryName,$categoryName],7=>[$categoryName,$categoryName],8=>[$categoryName.' '.date('Y',strtotime("today")),date('F', strtotime('today'))],31=>[$categoryName,$categoryName],28=>[$categoryName.'-'.strtotime("today"),date('F Y', strtotime('today'))],32=>[$categoryName.' '.date('Y',strtotime("today")),date('F', strtotime('today'))]];
    $ssNameChk=$arrHeaderSS[$reportNameVal][0]; $ssSheetName=$arrHeaderSS[$reportNameVal][1];
    foreach ($filearray1 as $child1)
    {
        $fileid=$service->files->get($child1->getId())->id;
        $filename=$service->files->get($child1->getId())->title;
        if($filename==$ssNameChk)
        {
            $SSexistflag=1;
            $SSfileid=$fileid;
            break;
        }
    }
    if($SSexistflag==1)
    {
        $SSfileid=$SSfileid;
    }
    else
    {
        $SSfileid=$this->Mdl_eilib_common_function->NewSpreadsheetCreation($service, $ssNameChk, $ssNameChk, $folderid);
    }
    $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
    $tempTable='';$REP_utstrdte='';$REP_utenddte='';
    if($month!=''){
        $splitmonth=strtotime($month);
        $REP_utstrdte= date("Y-m-01", $splitmonth);
        $REP_utenddte= date("Y-m-t", $splitmonth);
        //$REP_utstrdte="2013-07-09";$REP_utenddte="2013-09-09";
   }
    $arrCallQuery=[7=>["CALL SP_REPORT_CURRENT_ACTIVE_CUSTOMER('$UserStamp',@TEMP_TABLE)"],8=>["CALL SP_CUSTOMER_CURRENT_MONTH_EXPIRY('$UserStamp',@TEMP_TABLE)"],
        31=>["CALL SP_ALL_CUSTOMER_SEARCH_TEMP_FEE_DETAIL('$UserStamp',@TEMP_TABLE)"]];
    if($reportNameVal==7||$reportNameVal==8||$reportNameVal==31){
        $this->db->query($arrCallQuery[$reportNameVal][0]);
$this->db->select('@TEMP_TABLE AS TEMP_TABLE', FALSE);
    $tempTable=$this->db->get()->row()->TEMP_TABLE;}
    $arrQuery=[1=>["SELECT DISTINCT U.UNIT_NO AS UNIT_NO,ULD.ULDTL_DOORCODE AS DOOR_CODE,ULD.ULDTL_WEBLOGIN AS WEB_LOGIN,ULD.ULDTL_WEBPWD AS WEB_PASSWORD,EDSH.EDSH_SSID AS SSID,EDSH.EDSH_PWD AS PWD,USLD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ULD.ULDTL_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT_LOGIN_DETAILS ULD,UNIT U,USER_LOGIN_DETAILS USLD,EXPENSE_DETAIL_STARHUB EDSH WHERE USLD.ULD_ID=ULD.ULD_ID AND ULD.UNIT_ID=U.UNIT_ID AND U.UNIT_ID=EDSH.UNIT_ID ORDER BY U.UNIT_NO ASC",
        'UNIT_NO^^DOOR_CODE^^WEB_LOGIN^^WEB_PASSWORD^^SSID^^PWD^^USERSTAMP^^TIMESTAMP',"50^^100^^150^^120^^200^^200^^220^^180"],
        7=>["SELECT CONCAT(CUSTOMER_FIRST_NAME,' ',CUSTOMER_LAST_NAME) AS CUSTOMER_NAME,UNIT_NO,LEASE_PERIOD,CED_RECHECKIN,CED_EXTENSION,CED_PRETERMINATE,CC_PAYMENT_AMOUNT,CC_DEPOSIT,CC_PROCESSING_FEE,CC_AIRCON_FIXED_FEE,CC_ELECTRICITY_CAP,CC_DRYCLEAN_FEE,CC_AIRCON_QUARTERLY_FEE,CC_CHECKOUT_CLEANING_FEE,DATE_FORMAT(CLP_STARTDATE,'%d/%m/%Y') AS CLP_STARTDATE,DATE_FORMAT(CLP_ENDDATE,'%d/%m/%Y') AS CLP_ENDDATE,DATE_FORMAT(CLP_PRETERMINATE_DATE,'%d/%m/%Y') AS CLP_PRETERMINATE_DATE,CLP_TERMINATE FROM ".$tempTable." ORDER BY UNIT_NO",
            'CUSTOMER_NAME^^UNIT_NO^^LEASE_PERIOD^^CED_RECHECKIN^^CED_EXTENSION^^CED_PRETERMINATE^^CC_PAYMENT_AMOUNT^^CC_DEPOSIT^^CC_PROCESSING_FEE^^CC_AIRCON_FIXED_FEE^^CC_ELECTRICITY_CAP^^CC_DRYCLEAN_FEE^^CC_AIRCON_QUARTERLY_FEE^^CC_CHECKOUT_CLEANING_FEE^^CLP_STARTDATE^^CLP_ENDDATE^^CLP_PRETERMINATE_DATE^^CLP_TERMINATE',
        '200^^60^^130^^130^^130^^160^^160^^160^^160^^160^^160^^160^^160^^130^^130^^130^^130^^130^^130^^130'],
        6=>["SELECT CONCAT (ED.EMP_FIRST_NAME,' ' ,ED.EMP_LAST_NAME ,' ' ,UASD.UASD_ACCESS_CARD ) AS EMPLOYEE_NAME_ACCESS_CARD FROM EMPLOYEE_DETAILS ED,UNIT_ACCESS_STAMP_DETAILS UASD,EMPLOYEE_CARD_DETAILS ECD WHERE ED.EMP_ID=ECD.EMP_ID
AND ECD.UASD_ID=UASD.UASD_ID ORDER BY ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME","EMPLOYEE_NAME_ACCESS_CARD","400"],
        32=>["SELECT ERM.ERM_CUST_NAME AS CUSTOMER_NAME,ERM.ERM_RENT AS RENT,DATE_FORMAT(ERM.ERM_MOVING_DATE,'%d/%m/%Y') AS MOVING_DATE,ERM.ERM_MIN_STAY AS MINIMUM_STAY,EOD.ERMO_DATA AS ERM_DATA,NC.NC_DATA AS NATIONALITY_CONFIGURATION,ERM.ERM_NO_OF_GUESTS AS NO_OF_GUESTS,ERM.ERM_AGE AS AGE,ERM.ERM_CONTACT_NO AS CONTACT_NO,ERM.ERM_EMAIL_ID AS EMAIL_ID,ERM.ERM_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ERM.ERM_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM ERM_ENTRY_DETAILS ERM left join NATIONALITY_CONFIGURATION NC ON ERM.NC_ID=NC.NC_ID left join ERM_OCCUPATION_DETAILS EOD ON ERM.ERMO_ID=EOD.ERMO_ID left join USER_LOGIN_DETAILS ULD on ERM.ULD_ID=ULD.ULD_ID WHERE ERM.ERM_MOVING_DATE BETWEEN '$REP_utstrdte' AND '$REP_utenddte' ORDER BY ERM.ERM_CUST_NAME ASC",
            "CUSTOMER_NAME^^RENT^^MOVING_DATE^^MINIMUM_STAY^^ERM_DATA^^NATIONALITY_CONFIGURATION^^NO_OF_GUESTS^^AGE^^CONTACT_NO^^EMAIL_ID^^COMMENTS^^USERSTAMP^^TIMESTAMP"
        ,"200^^50^^120^^125^^130^^170^^110^^50^^110^^140^^500^^200^^130"]
        ,
        2=>["SELECT DISTINCT U.UNIT_NO AS UNIT_NO,ULD.ULDTL_DOORCODE AS DOOR_CODE,ULD.ULDTL_WEBLOGIN AS WEB_LOGIN,ULD.ULDTL_WEBPWD AS WEB_PASSWORD,EDSH.EDSH_SSID AS SSID,EDSH.EDSH_PWD AS PWD,USLD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ULD.ULDTL_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT_LOGIN_DETAILS ULD,UNIT U,USER_LOGIN_DETAILS USLD,EXPENSE_DETAIL_STARHUB EDSH WHERE USLD.ULD_ID=ULD.ULD_ID AND ULD.UNIT_ID=U.UNIT_ID AND U.UNIT_ID=EDSH.UNIT_ID ORDER BY U.UNIT_NO ASC",
            "UNIT_NO^^DOOR_CODE^^WEB_LOGIN^^WEB_PASSWORD^^SSID^^PWD^^USERSTAMP^^TIMESTAMP","60^^100^^100^^120^^100^^100^^220^^130"]
        ,
        28=>["SELECT U.UNIT_NO AS UNIT_NO,EC.ECN_DATA AS CATEGORY,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS CUSTOMER_NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d/%m/%Y') AS INVOICE_DATE,EU.EU_AMOUNT AS INVOICE_AMOUNT,EU.EU_INVOICE_ITEMS AS INVOICE_ITEMS,EU.EU_INVOICE_FROM  AS INVOICE_FROM,EU.EU_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP  FROM USER_LOGIN_DETAILS ULD,EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID WHERE EU.ULD_ID=ULD.ULD_ID AND EU.EU_INVOICE_DATE BETWEEN '$REP_utstrdte' AND '$REP_utenddte' ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC",
            "UNIT_NO^^CATEGORY^^CUSTOMER_NAME^^INVOICE_DATE^^INVOICE_AMOUNT^^INVOICE_ITEMS^^INVOICE_FROM^^COMMENTS^^USERSTAMP^^TIMESTAMP"
            ,"70^^150^^200^^110^^110^^200^^270^^230^^220^^130"]
        ,
        4=>["SELECT U.UNIT_NO AS UNIT_NO,DATE_FORMAT(UD_START_DATE,'%d/%m/%Y') AS START_DATE,DATE_FORMAT(UD_END_DATE,'%d/%m/%Y') AS END_DATE FROM UNIT U,VW_ACTIVE_UNIT VAU,UNIT_DETAILS UD WHERE UD_OBSOLETE IS NULL AND U.UNIT_ID=UD.UNIT_ID AND VAU.UNIT_ID=U.UNIT_ID AND UD.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO",
            "UNIT_NO^^START_DATE^^END_DATE","60^^150^^150"]	 ,
        8=>["SELECT TCCME.UNITNO AS UNIT_NO,CONCAT(TCCME.CUSTOMERFIRSTNAME,' ',TCCME.CUSTOMERLASTNAME) AS CUSTOMER_NAME,DATE_FORMAT(TCCME.STARTDATE,'%d/%m/%Y') AS START_DATE,TCCME.LEASEPERIOD AS LEASE_PERIOD,DATE_FORMAT(TCCME.ENDDATE,'%d/%m/%Y') AS END_DATE,DATE_FORMAT(TCCME.PRETERMINATEDATE,'%d/%m/%Y') AS PRETERMINATE DATE,TCCME.ROOMTYPE AS ROOM_TYPE,TCCME.EXTENSIONFLAG AS EXTENSION_FLAG,TCCME.RECHECKINGFLAG AS RECHECKING_FLAG,TCCME.PAYMENT AS PAYMENT,TCCME.DEPOSIT AS DEPOSIT,TCCME.PROCESSINGFEE AS PROCESSING_FEE,TCCME.COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(TCCME.EXPIRY_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM ".$tempTable." TCCME,USER_LOGIN_DETAILS ULD WHERE TCCME.ULD_ID=ULD.ULD_ID ORDER BY TCCME.UNITNO",
            "UNIT_NO^^CUSTOMER_NAME^^START_DATE^^LEASE_PERIOD^^END_DATE^^PRETERMINATE_DATE^^ROOM_TYPE^^EXTENSION_FLAG^^RECHECKING_FLAG^^PAYMENT^^DEPOSIT^^PROCESSING_FEE^^COMMENTS^^USERSTAMP^^TIMESTAMP",
        "80^^200^^100^^120^^100^^150^^100^^120^^150^^100^^100^^140^^400^^220^^190"]
        ,5=>["SELECT U.UNIT_NO AS UNIT_NO,DATE_FORMAT(UD_START_DATE,'%d/%m/%Y') AS START_DATE,DATE_FORMAT(UD_END_DATE,'%d/%m/%Y') AS END_DATE FROM UNIT U,UNIT_DETAILS UD WHERE UD_OBSOLETE ='X' AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO",
            "UNIT_NO^^START_DATE^^END_DATE","60^^150^^150" ]
        ,3=>["SELECT U.UNIT_NO AS UNIT_NO,ULD.ULDTL_DOORCODE AS DOOR_CODE,ULD.ULDTL_WEBLOGIN AS WEB_LOGIN,ULD.ULDTL_WEBPWD AS WEB_PASSWORD,USLD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ULD.ULDTL_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT_LOGIN_DETAILS ULD,UNIT U,USER_LOGIN_DETAILS USLD WHERE ULD.UNIT_ID=U.UNIT_ID AND USLD.ULD_ID=ULD.ULD_ID ORDER BY U.UNIT_NO ASC",
            "UNIT_NO^^DOOR_CODE^^WEB_LOGIN^^WEB_PASSWORD^^USERSTAMP^^TIMESTAMP","60^^100^^100^^120^^200^^130"]
        ,30=>["SELECT U.UNIT_NO AS UNIT_NO,DATE_FORMAT(UD.UD_START_DATE,'%d/%m/%Y') AS START_DATE,DATE_FORMAT(UD.UD_END_DATE,'%d/%m/%Y') AS END_DATE FROM UNIT U,UNIT_DETAILS UD WHERE UD.UD_END_DATE<CURDATE() AND UD.UD_OBSOLETE IS NULL AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO ASC",
            "UNIT_NO^^START_DATE^^END_DATE","60^^150^^150"]
        ,31=>["SELECT DISTINCT U.UNIT_NO AS UNIT_NO,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS CUSTOMER_NAME,DATE_FORMAT (CTD.CLP_STARTDATE,'%d/%m/%Y') AS START_DATE,DATE_FORMAT(CTD.CLP_ENDDATE,'%d/%m/%Y') AS END_DATE,CED.CED_REC_VER AS REC_VER,CED. CED_LEASE_PERIOD AS LEASE_PERIOD,UASD.UASD_ACCESS_CARD AS ACCESS_CARD,CTD.CLP_GUEST_CARD AS GUEST_CARD,CTD.CLP_TERMINATE AS TERMINATE,CED.CED_PRETERMINATE AS PRETERMINATE,CED.CED_EXTENSION AS EXTENSION, CED.CED_RECHECKIN AS RECHECKIN, CED.CED_PRORATED AS PRORATED, CED.CED_PROCESSING_WAIVED AS PROCESSING_WAIVED,CED.CED_PRETERMINATE AS PRETERMINATE_DATE,DATE_FORMAT(CED.CED_NOTICE_START_DATE,'%d/%m/%Y') AS NOTICESTARTDATE, DATE_FORMAT(CED.CED_CANCEL_DATE,'%d/%m/%Y') AS CANCEL_DATE,CF.CC_DEPOSIT AS DEPOSIT,CF.CC_ELECTRICITY_CAP AS ELECTRICITY_CAP,CF.CC_PAYMENT_AMOUNT AS PAYMENT_AMOUNT, CF.CC_AIRCON_FIXED_FEE AS AIRCON_FIXED_FEE,CF.CC_AIRCON_QUARTERLY_FEE AS AIRCON_QUARTERLY_FEE,CF.CC_DRYCLEAN_FEE AS DRYCLEAN_FEE,CF.CC_PROCESSING_FEE AS PROCESSING_FEE,CF.CC_CHECKOUT_CLEANING_FEE AS CHECKOUT_CLEANING_FEE, DATE_FORMAT(CPD.CPD_DOB,'%d/%m/%Y') AS DATE_OF_BIRTH, DATE_FORMAT(CPD.CPD_PASSPORT_DATE,'%d/%m/%Y') AS PASSPORT_DATE,DATE_FORMAT(CPD.CPD_EP_DATE,'%d/%m/%Y') AS EP_DATE, CPD.CPD_COMMENTS AS COMMENTS FROM CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD on CED.CUSTOMER_ID=CCD.CUSTOMER_ID left join CUSTOMER_LP_DETAILS CTD on CED.CUSTOMER_ID=CTD.CUSTOMER_ID left join CUSTOMER_ACCESS_CARD_DETAILS CACD on CED.CUSTOMER_ID=CACD.CUSTOMER_ID and (CTD.UASD_ID=CACD.UASD_ID)left join UNIT_ACCESS_STAMP_DETAILS UASD on (UASD.UASD_ID=CACD.UASD_ID) left join ".$tempTable." CF on CED.CUSTOMER_ID=CF.CUSTOMER_ID left join CUSTOMER C on CED.CUSTOMER_ID=C.CUSTOMER_ID left join CUSTOMER_PERSONAL_DETAILS CPD on CED.CUSTOMER_ID=CPD.CUSTOMER_ID ,NATIONALITY_CONFIGURATION NC ,UNIT U,USER_LOGIN_DETAILS ULD where (CED.UNIT_ID=U.UNIT_ID) and(CPD.NC_ID=NC.NC_ID) and (CED.CED_REC_VER=CF.CUSTOMER_VER) AND CED.CED_REC_VER=CTD.CED_REC_VER AND ULD.ULD_ID=CTD.ULD_ID AND ULD.ULD_ID=CTD.ULD_ID AND U.UNIT_NO='0422' order by U.UNIT_NO,CUSTOMER_NAME,CED.CED_REC_VER ASC",
            "UNIT_NO^^CUSTOMER_NAME^^START_DATE^^END_DATE^^REC_VER^^LEASE_PERIOD^^ACCESS_CARD^^GUEST_CARD^^TERMINATE^^PRETERMINATE^^EXTENSION^^RECHECKIN^^PRORATED^^PROCESSING_WAIVED^^PRETERMINATE_DATE^^NOTICESTARTDATE^^CANCEL_DATE^^DEPOSIT^^ELECTRICITY_CAP^^PAYMENT_AMOUNT^^AIRCON_FIXED_FEE^^AIRCON_QUARTERLY_FEE^^DRYCLEAN_FEE^^PROCESSING_FEE^^CHECKOUT_CLEANING_FEE^^DATE_OF_BIRTH^^PASSPORT_DATE^^EP_DATE^^COMMENTS"
        ,"70^^200^^100^^100^^70^^120^^130^^130^^100^^120^^100^^110^^100^^160^^170^^150^^110^^80^^120^^120^^150^^200^^110^^120^^150^^130^^120^^80^^400"]];
    $resultset=$this->db->query($arrQuery[$reportNameVal][0]);
    $splitHeader=explode('^^',$arrQuery[$reportNameVal][1]);
    $concatArray='';
    $arrDatass=[];
    if($resultset->num_rows()==0)
        return 0;
    $arrDatass = array('sheetFlag'=>$SSexistflag,'sheet'=>$ssSheetName,'sheetId'=>$SSfileid,'header'=>str_replace('_'," ",$arrQuery[$reportNameVal][1]),"Fileid"=>$SSfileid,'width'=>$arrQuery[$reportNameVal][2],'flag'=>12,'numsrow'=>$resultset->num_rows());
    foreach ($resultset->result_array() as $key => $value) {
        foreach($splitHeader as $keyCol => $column){
            if($keyCol==0)
                $concatArray=$value[$splitHeader[$keyCol]];
            else
                $concatArray.='^~^'.$value[$splitHeader[$keyCol]];
        }
        $arrDatass["data".$key] = $concatArray;
    }
    $url= $this->Mdl_eilib_common_function->getUrlAccessGasScript();
//    $url ="https://script.google.com/macros/s/AKfycbyv58HZU2XsR2kbCMWZjNzMWSmOwoE7xsg_fesXktGk4Kj574u1/exec";
    $ch = curl_init();
    $data = http_build_query($arrDatass );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
    try {
        $response = curl_exec($ch);
        curl_close($ch);
        $this->db->select("ETD_EMAIL_SUBJECT,ETD_EMAIL_BODY");
        $this->db->from('EMAIL_TEMPLATE_DETAILS');
        $this->db->where('ETD_ID',13);
        foreach($this->db->get()->result_array() as $row) {
            $mailsub = $row['ETD_EMAIL_SUBJECT'];
            $mailBody = $row['ETD_EMAIL_BODY'];
        }
        $mailsub=str_replace("[REPORT NAME]",$reportNameText,$mailsub);
        $mailbody=str_replace("[MAILID_USERNAME]",$emailId,$mailBody);
        $mailbody=$mailbody.': '.$response;
        try {
            $docowner = $this->Mdl_eilib_common_function->CUST_documentowner($UserStamp);
            $service = $this->Mdl_eilib_common_function->get_service_document();
            $this->Mdl_eilib_invoice_contract->SetDocOwner($service, $SSfileid, $docowner, $emailId);
            $this->Mdl_eilib_invoice_contract->RemoveEditors($service, $SSfileid, $emailId, $docowner, $UserStamp);
        }
        catch(Exception $e){
            return 2;
        }
     $this->mailpart($mailsub,$mailbody,$mailsub,$UserStamp,$emailId);
        return 1;
    } catch (Exception $e) {
        return 0;
    }
}
public function REP_getdomain_err(){
    $REP_searchoptions_dataid=array();
    $this->db->select('CGN_ID,CGN_TYPE');
    $this->db->from('CONFIGURATION');
    $this->db->where('CGN_ID IN(59,60,61,73,82)');
    $this->db->order_by('CGN_TYPE ASC');
    $REP_select_catagotyreport_name=$this->db->get();
    foreach($REP_select_catagotyreport_name->result_array() as $row) {
        $REP_searchoptions_id = $row['CGN_ID'];
        $REP_searchoptions_data = $row['CGN_TYPE'];
        $REP_searchoptions_object = (object)["REP_searchoption_id" => $REP_searchoptions_id, "REP_searchoption_data" => $REP_searchoptions_data];
        $REP_searchoptions_dataid[]=$REP_searchoptions_object;
    }
    //REPORT NAME
    $REP_report_name_arraydataid=array();
    $this->db->select('RCN_ID,RCN_DATA');
    $this->db->from('REPORT_CONFIGURATION');
    $this->db->where('RCN_INITIALIZE_FLAG','X');
    $this->db->order_by('RCN_DATA ASC');
    $REP_select_report_name=$this->db->get();
    foreach($REP_select_report_name->result_array() as $row)
    {
        $REP_reportname_id=$row['RCN_ID'];
        $REP_reportname_data=$row['RCN_DATA'];
        $REP_reportname_object=(object)["REP_reportnames_id"=>$REP_reportname_id,"REP_reportnames_data"=>$REP_reportname_data];
        $REP_report_name_arraydataid[]=($REP_reportname_object);
    }
    //EMAIL ID
    $REP_emailid_array=array();
    $REP_emailid_array= $this->Mdl_eilib_common_function->getProfileEmailId('REPORT');
    //RETRIEVE MESSAGE FOR REPORT RECORD FROM ERROR TABLE
    $REP_errmsgids="282,341,395,459";
    $REP_errorMsg_array=array();
    $REP_errorMsg_array=$this->Mdl_eilib_common_function->getErrorMessageList($REP_errmsgids);
    $REP_result=(object)["REP_catagoryreportname"=>$REP_searchoptions_dataid,"REP_reportname"=>$REP_report_name_arraydataid,"REP_emailid"=>$REP_emailid_array,"REP_errormsg"=>$REP_errorMsg_array];
    return $REP_result;
}
//FUNCTION FOR ALL SEARCH BY CATAGORY REPORT
function REP_func_load_searchby_option($REP_report_optionfetch){
    $REP_loaddata_arrdataid=array();
    $REP_selectquery=array();
    //UNIT,EMP,CUS,EXP,ERM
    $REP_selectquery[59]='1,2,3,4,5,30';$REP_selectquery[60]='6';$REP_selectquery[61]='7,8,31';$REP_selectquery[73]='28';$REP_selectquery[82]='32';
    $this->db->select('RCN_ID,RCN_DATA');
    $this->db->from('REPORT_CONFIGURATION');
    $this->db->where('RCN_ID IN ('.$REP_selectquery[$REP_report_optionfetch].')');
    $this->db->order_by('RCN_DATA');
    $REP_separate_rs=$this->db->get();
    foreach($REP_separate_rs->result_array() as $row){
        $REP_seperatereportname_id=$row['RCN_ID'];
        $REP_seperatereportname_data=$row['RCN_DATA'];
        $REP_seperatereportname_object=(object)["REP_seperatereportnames_id"=>$REP_seperatereportname_id,"REP_seperatereportnames_data"=>$REP_seperatereportname_data];
        $REP_loaddata_arrdataid[]=($REP_seperatereportname_object);
    }
    $REP_result_obj=(object)["REP_loaddata_searchby"=>$REP_loaddata_arrdataid,"REP_flag"=>$REP_report_optionfetch];
    return $REP_result_obj;
}
public function mailpart($mailsub,$mailbody,$Displayname,$UserStamp,$Sendmailid)
{
        try {
            $message1 = new Message();
            $message1->setSender($Displayname . '<' . $UserStamp . '>');
            $message1->addTo($Sendmailid);
            $message1->setSubject($mailsub);
            $message1->setHtmlBody($mailbody);
            $message1->send();
            return 1;
        }
        catch(Exception $e){
            return 0;
        }
//    $mail = new PHPMailer;
//    $mail->isSMTP();
//    $mail->Host = 'smtp.gmail.com';
//    $mail->SMTPAuth = true;
//    $mail->Username = 'safiyullah84@gmail.com';
//    $mail->Password = 'safi984151';
//    $mail->SMTPSecure = 'tls';
//    $mail->Port = 587;
//    $mail->FromName = $Displayname;
//    $mail->addAddress('saradambal.munusamy@ssomens.com');
//    $mail->WordWrap = 50;
//    $mail->isHTML(true);
//    $mail->Subject = $mailsub;
//    $mail->Body = $mailbody;
//    $mail->Send();
//    if (!$mail->Send()) {
//        return "Message could not be sent";
//    } else {
//        return 'success';
//
//    }
}
}
