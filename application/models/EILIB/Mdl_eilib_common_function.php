<?php
/**
* Created by PhpStorm.
* User: SSOMENS-021
* Date: 8/5/15
* Time: 5:59 PM
*/
//******************************************COMMON FUNCTION********************************************//
//VER 5.9-SD:05/06/2015 ED:05/06/2015,ADDED CUSTOMER FILE UPLOAD TARGET FOLDER FUNCTION DONE BY KUMAR.R
//VER 5.9-SD:05/06/2015 ED:05/06/2015,ADDED NEW SS CREATION,FILE DELETE,FILE UPLOAD,CRUL FUNCTIONS DONE BY KUMAR.R
//DONE BY:SARADAMBAL
//VER 5.8 -SD:04/06/2015 ED:04/06/2015,ADDED FUNCTION TO GET USERSTAMP AND REMOVED PARAMS FOR SERVICE DOCUMENT
//VER 5.5-SD:03/06/2015 ED:03/06/2015,REMOVED QUARTER CALCULATION
//VER 0.02-SD:02/06/2015 ED:02/06/2015,GET THE LOGO & CALENDAR IMAGE PATH AND THEN GET THE SERVICE ID
//VER 0.01-SD:08/05/2015 ED:09/05/2015,COMPLETED COMMON FUNCTION
//*******************************************************************************************************//
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;
class Mdl_eilib_common_function extends CI_Model {
    //GET SESSION USERSTAMP
 public function getSessionUserStamp(){
    $user = UserService::getCurrentUser();
    $UserStamp=$user->getEmail();
    return $UserStamp;
}
    //SS creation
    public  function NewSpreadsheetCreationwithurl($service, $title, $description, $parentId) {
        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($title);
        $file->setDescription($description);
        $file->setMimeType('application/vnd.google-apps.spreadsheet');
        if ($parentId != null) {
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
        }
        try {
            $createdFile = $service->files->insert($file, array(
                'mimeType' => 'application/vnd.google-apps.spreadsheet',//$mimeType,
                'convert' => TRUE,
                'uploadType'=>'resumable'
            ));
            $fileid=$createdFile->getId();
            $data = $service->files->get($createdFile->getId());
            $url=$data->defaultOpenWithLink;
            $returnvalue=array($fileid,$url);
            return $returnvalue;
        }
        catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }
    //CUSTOMER FILE UPLOAD TARGET FOLDER
    public function getFileUploadfolder()
    {
        $this->db->select("CCN_DATA");
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CGN_ID=96');
        return $this->db->get()->row()->CCN_DATA;
    }
    //FUNCTION GET UNIT FOLDER ID
    public function getUnitfolderId($Uint,$Customerid)
    {
        $selectquery="SELECT UNIT_ID,UFD_FOLDERID,CUSTOMER_ID,CUFD_CUSTOMER_FOLDER_ID FROM UNIT_FOLDER_DIRECTORY U LEFT JOIN CUSTOMER_FILE_DIRECTORY C ON U.UFD_ID=C.UFD_ID AND CUSTOMER_ID='$Customerid' WHERE UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$Uint')";
        $resultset=$this->db->query($selectquery);
        foreach ($resultset->result_array() as $key=>$val)
        {
            $result[]=$val['UFD_FOLDERID'];
            $result[]=$val['CUFD_CUSTOMER_FOLDER_ID'];
        }
        return $result;
    }
//FUNCTION TO GET BANK_TRANSFER_MODELS
public function getRecheckinCustomerUnit()
{
    $this->db->select("UNIT_NO");
    $this->db->order_by("UNIT_NO", "ASC");
    $this->db->from('VW_RECHECKIN_CUSTOMER');
    $this->db->distinct();
    $query = $this->db->get();
    return $query->result();
}
Public function getBankTransferModels()
{
$this->db->select("BTM_ID,BTM_DATA");
$this->db->order_by("BTM_DATA", "ASC");
$this->db->from('BANK_TRANSFER_MODELS');
$queryBankModel = $this->db->get();
return $queryBankModel->result_array();
}
//FUNCTION TO GET ID FOR GIVEN USERSTAMP
Public function getUserStampId($UserStamp){
$this->db->select("ULD_ID");
$this->db->from('USER_LOGIN_DETAILS');
$this->db->where('ULD_LOGINID',$UserStamp);
$queryLoginId = $this->db->get();
return $queryLoginId->result_array();
}
Public function getAllActiveUnits()
{
$this->db->select("UNIT_NO");
$this->db->order_by("UNIT_NO", "ASC");
$this->db->from('VW_ACTIVE_UNIT');
$query = $this->db->get();
return $query->result();
}
Public function getAllUnits()
{
$this->db->select("UNIT_NO");
$this->db->order_by("UNIT_NO", "ASC");
$this->db->from('UNIT');
$query = $this->db->get();
return $query->result();
}
Public function getNationality()
{
$this->db->select("NC_DATA");
$this->db->order_by("NC_DATA", "ASC");
$this->db->from('NATIONALITY_CONFIGURATION');
$query = $this->db->get();
return $query->result();
}
Public function getEmailId($formname)
{
if($formname=='CustomerCreation')
{
$formid=1;
}
$this->db->select("EL_EMAIL_ID");
$this->db->order_by("EL_EMAIL_ID", "ASC");
$this->db->from('EMAIL_LIST');
$this->db->where('EP_ID='.$formid);
$query = $this->db->get();
return $query->result();
}
Public function getOption()
{
$this->db->select("CCN_ID,CCN_DATA");
$this->db->order_by("CCN_DATA", "ASC");
$this->db->from('CUSTOMER_CONFIGURATION');
$this->db->where('CGN_ID=3');
$query = $this->db->get();
return $query->result();
}
Public function getErrorMessageList($errormessage)
{
$this->db->select("EMC_ID,EMC_DATA");
$this->db->order_by("EMC_ID", "ASC");
$this->db->from('ERROR_MESSAGE_CONFIGURATION');
$this->db->where('EMC_ID IN('.$errormessage.')');
$query = $this->db->get();
return $query->result();
}
public function getTimeList()
{
$this->db->select("DATE_FORMAT(CTP_DATA, '%H:%i')AS TIME");
$this->db->from('CUSTOMER_TIME_PROFILE');
$query = $this->db->get();
return $query->result();
}
public function getUnitRoomType($unit)
{
$this->db->select("URTD.URTD_ID,URTD.URTD_ROOM_TYPE");
$this->db->from('UNIT_ROOM_TYPE_DETAILS URTD,UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U');
$this->db->where('URTD.URTD_ID=UASD.URTD_ID AND U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_NO='.$unit);
$query = $this->db->get();
return $query->result();
}
public function getUnit_Start_EndDate($unit)
{
$this->db->select("UD_START_DATE,UD_END_DATE");
$this->db->from('UNIT_DETAILS UD,UNIT U');
$this->db->where('U.UNIT_ID=UD.UNIT_ID AND U.UNIT_NO='.$unit);
$query = $this->db->get();
return $query->result();
}
public function getCustomerStartDate()
{
$this->db->select("CCN_DATA");
$this->db->from('CUSTOMER_CONFIGURATION');
$this->db->where('CGN_ID=76');
$query = $this->db->get();
return $query->result();
}
public function CUST_getunitCardNo($unit)
{
$this->db->select("UASD.UASD_ACCESS_CARD");
$this->db->from('UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U');
$this->db->where('U.UNIT_ID=UASD.UNIT_ID AND UASD.UASD_ACCESS_INVENTORY IS NOT NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL AND U.UNIT_NO='.$unit);
$this->db->order_by("UASD.UASD_ACCESS_CARD", "ASC");
$query = $this->db->get();
return $query->result();
}
public function CUST_getProratedWaivedValue()
{
$this->db->select("CCN_DATA");
$this->db->from('CUSTOMER_CONFIGURATION');
$this->db->where('CCN_ID IN(7,8)');
$this->db->order_by("CCN_ID", "ASC");
$query = $this->db->get();
return $query->result();
}
public function getOccupationList()
{
$this->db->select("ERMO_DATA");
$this->db->from('ERM_OCCUPATION_DETAILS');
$this->db->order_by("ERMO_DATA", "ASC");
$query = $this->db->get();
return $query->result();
}
Public function getPaymenttype()
{
$this->db->select("PP_ID,PP_DATA");
$this->db->order_by("PP_DATA", "ASC");
$this->db->from('PAYMENT_PROFILE');
$query = $this->db->get();
return $query->result();
}
public function getActive_Customer($unit)
{
$this->db->select("CUSTOMER_ID,CUSTOMERNAME");
$this->db->order_by("CUSTOMERNAME", "ASC");
$this->db->from('VW_PAYMENT_CURRENT_ACTIVE_CUSTOMER');
$this->db->where("UNIT_NO=".$unit);
$this->db->distinct();
$query = $this->db->get();
return $query->result();
}
public function getActive_Customer_LP($unit,$customer)
{
$this->db->select("CED_REC_VER,CLP_STARTDATE,CLP_ENDDATE,CLP_PRETERMINATE_DATE");
$this->db->order_by("CED_REC_VER", "ASC");
$this->db->from('VW_CURRENT_ACTIVE_CUSTOMER');
$this->db->where("UNIT_NO=".$unit." AND CUSTOMER_ID=".$customer);
$this->db->distinct();
$query = $this->db->get();
return $query->result();
}
//FUNCTION TO CHECK UNIT NO EXISTS OR NOT
public function CheckUnitnoExists($BDLY_INPUT_unitval)
{
$CheckUnitnoExists ="SELECT * FROM UNIT WHERE UNIT_NO=".$BDLY_INPUT_unitval;
$this->db->query($CheckUnitnoExists);
if ($this->db->affected_rows() > 0) {
    $Unitnoflag= true;
}
else
{
    $Unitnoflag= false;
}
return $Unitnoflag;
}
//FUNCTION TO CHECK TRANSACTION OF A RECORD
public  function ChkTransactionBeforeDelete($tableid,$rowid)
{
$this->db->query("CALL SP_CHK_TRANSACTION('$tableid','$rowid',@DELETION_FLAG)");
$this->db->select('@DELETION_FLAG as DELETION_FLAG', FALSE);
return $this->db->get()->result_array();
}
//FUNCTION TO GET UNIT SDATE AND EDATE AND INVDATE ADDING AND SUBTR USING CONFIG MONTH
public  function GetUnitSdEdInvdate($unitno)
{
    $BDLY_INPUT_sp_stmt="CALL SP_CONFIG_SDATE_EDATE((SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$unitno'),@SDATE,@EDATE,@INVDATE)";
    $this->db->query($BDLY_INPUT_sp_stmt);

    $BDLY_INPUT_sp_rs = 'SELECT @SDATE,@EDATE,@INVDATE';
    $query = $this->db->query($BDLY_INPUT_sp_rs);
    foreach ($query->result_array() as $row)
    {
        $BDLY_INPUT_getsdate=$row['@SDATE'];
        $BDLY_INPUT_getedate=$row['@EDATE'];
        $BDLY_INPUT_invdate=$row['@INVDATE'];
    }

    $BDLY_INPUT_unitdate=array("unitsdate"=>$BDLY_INPUT_getsdate,"unitedate"=>$BDLY_INPUT_getedate,"invdate"=>$BDLY_INPUT_invdate);
    return $BDLY_INPUT_unitdate;
}
//FUNCTION TO CHECK HOUSE KEEPING UNIT NO EXISTS OR NOT
public function CheckHKPUnitnoExists($BDLY_INPUT_unitval)
{
    $CheckHKPUnitnoExists = "SELECT EHKU_UNIT_NO FROM EXPENSE_HOUSEKEEPING_UNIT WHERE EHKU_UNIT_NO='$BDLY_INPUT_unitval'";
    $this->db->query($CheckHKPUnitnoExists);
    if ($this->db->affected_rows() > 0) {
        $HKPunitflag= true;
    }
    else{
        $HKPunitflag= false;
    }
    return $HKPunitflag;
}
//FUNCTION TO DELETE A RECORD
public  function DeleteRecord($tableid,$rowid,$USERSTAMP)
{
    $deletestmt = "CALL SP_SINGLE_TABLE_ROW_DELETION('$tableid','$rowid','$USERSTAMP',@DELETION_FLAG)";
    $this->db->query($deletestmt);
    $PDLY_INPUT_rs_flag = 'SELECT @DELETION_FLAG';
    $query = $this->db->query($PDLY_INPUT_rs_flag);
    foreach ($query->result_array() as $row)
    {
        $deleteflag=$row['@DELETION_FLAG'];
    }
    return $deleteflag;
}

//FUNCTION TO GET CALENDAR EVENT TIME FOR STARHUB N UNIT
public function getStarHubUnitCalTime()
{
$this->db->select("ECN_DATA");
$this->db->from('EXPENSE_CONFIGURATION');
$this->db->where('ECN_ID IN (193,194)');
return $this->db->get()->result_array();
}
//FUNCTION TO GET ACTIVE UNIT NO
public   function GetActiveUnit()
{
$this->db->select("UNIT_NO");
$this->db->order_by("UNIT_NO", "ASC");
$this->db->from('VW_ACTIVE_UNIT');
return $this->db->get()->result_array();
}
//FUNCTION TO CHECK AIRCON SERVICED BY
public function Check_ExistsAirconservicedby($airconservice)
{
$flag='false';
$this->db->select("EASB_DATA");
$this->db->from('EXPENSE_AIRCON_SERVICE_BY');
$this->db->where('EASB_DATA',$airconservice);
$query = $this->db->get();
if($query->num_rows() > 0)
{
$flag='true';
}
return $flag;
}
//FUNCTION TO CHECK ROOM TYPE EXISTS IN UNIT
public function Check_ExistsRmType($rmtype)
{
$flag='false';
$this->db->select("URTD_ROOM_TYPE");
$this->db->from('UNIT_ROOM_TYPE_DETAILS');
$this->db->where('URTD_ROOM_TYPE',$rmtype);
$query = $this->db->get();
if($query->num_rows() > 0)
{
$flag='true';
}
return $flag;
}
//FUNCTION TO CHECK STAMP DUTY TYPE EXISTS IN UNIT
public function Check_ExistsStampduty($stmpduty)
{
$flag='false';
$this->db->select("USDT_DATA");
$this->db->from('UNIT_STAMP_DUTY_TYPE');
$this->db->where('USDT_DATA',$stmpduty);
$query = $this->db->get();
if($query->num_rows() > 0)
{
$flag='true';
}
return $flag;
}
//FUNCTION TO CHECK CARD EXISTS IN UNIT
public   function Check_ExistsCard($cardno)
{
$this->db->select("UASD_ID");
$this->db->from('UNIT_ACCESS_STAMP_DETAILS');
$this->db->where('UASD_ACCESS_CARD',$cardno);
$query = $this->db->get();
($query->num_rows() > 0?$flag='true':$flag='false');
return $flag;
}
//GET UNIT START DATE N END DATE
public function GetUnitSdEdate($unitno)
{
$this->db->select("UD_START_DATE AS unitsdate,UD_END_DATE AS unitedate");
$this->db->from('UNIT_DETAILS UD,UNIT U');
$this->db->where('U.UNIT_ID=UD.UNIT_ID AND U.UNIT_NO='.$unitno);
return $this->db->get()->first_row('array');
//    $row = $query->first_row('array')
}
//GET PRORATE LABEL
public function CUST_GetProratelbl()
{
$this->db->select("CCN_DATA");
$this->db->from('CUSTOMER_CONFIGURATION');
$this->db->where('CGN_ID=39');
return $this->db->get()->row()->CCN_DATA;
}
//GET PRORATE LABEL LINE NO
public  function CUST_GetProrateLineno()
{
$this->db->select("CCN_DATA");
$this->db->from('CUSTOMER_CONFIGURATION');
$this->db->where('CGN_ID=50');
return $this->db->get()->row()->CCN_DATA;
}
//GET UNIT LOGIN DETAILS
public function CUST_GetLogindtls($unitno)
{
$this->db->select("ULDTL_WEBLOGIN");
$this->db->from('UNIT_LOGIN_DETAILS');
$this->db->where("UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$unitno')");
return $this->db->get()->row()->ULDTL_WEBLOGIN;
}
//GET INVOICE ID ,CONTRACT ID ,SERIAL NO,INVOIC DATE
public function CUST_invoice_contractreplacetext()
{
$this->db->select("CCN_DATA");
$this->db->from('CUSTOMER_CONFIGURATION');
$this->db->where('CCN_ID IN(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,35,37,43)');
$result=array();
foreach ($this->db->get()->result_array() as $key=>$val)
{
$result[]=$val['CCN_DATA'];
}
return $result;
}
//GET DOCUMENT OWNER
public function CUST_documentowner($UserStamp)
{
strtolower($UserStamp);
if (strpos(strtolower($UserStamp), "expatsint") == true) {
$docid=3;
}
else if(strpos(strtolower($UserStamp), "gmail") == true)
{
$docid=7;
}
else if(strpos(strtolower($UserStamp), "ssomens") == true)
{
$docid=8;
}
$this->db->select("EL_EMAIL_ID");
$this->db->from('EMAIL_LIST');
$this->db->where("EP_ID",$docid);
return $this->db->get()->row()->EL_EMAIL_ID;
}
//INVOICE AND CONTRACT EMAIL SUB AND BODY OF MESSAGE
public  function CUST_emailsubandmessages()
{
$this->db->select("ETD_EMAIL_SUBJECT AS subject,ETD_EMAIL_BODY AS message");
$this->db->order_by("ET_ID", "ASC");
$this->db->from('EMAIL_TEMPLATE_DETAILS');
$this->db->where("ET_ID IN(2,5,8)");
return $this->db->get()->result_array();
}
//INVOICE SERIALNO UPDATION
public function CUST_invoicesearialnoupdation($Slno,$UserStamp)
{
$this->db->select("ULD_ID");
$this->db->from('USER_LOGIN_DETAILS');
$this->db->where('ULD_LOGINID',$UserStamp);
$login=$this->db->get()->row()->ULD_ID;
$data = array(
'CCN_DATA' => $Slno,
'ULD_ID'=>$login
);
$this->db->where('CGN_ID', 1);
$this->db->update('CUSTOMER_CONFIGURATION', $data);
}
//INVOICE DATE SERIAL
public  function CUST_invoiceserialandinvoicedateupdation($Slno,$cc_invoicedate,$UserStamp)
{
$this->db->select("ULD_ID");
$this->db->from('USER_LOGIN_DETAILS');
$this->db->where('ULD_LOGINID',$UserStamp);
$login=$this->db->get()->row()->ULD_ID;
$data = array(
'CCN_DATA' => $Slno,
'ULD_ID'=>$login
);
$this->db->where('CGN_ID', 1);
$this->db->update('CUSTOMER_CONFIGURATION', $data);
$data = array(
'CCN_DATA' => $cc_invoicedate,
'ULD_ID'=>$login
);
$this->db->where('CGN_ID', 2);
$this->db->update('CUSTOMER_CONFIGURATION', $data);
}
//FUNCTION TO GET CALENDER ID
public function CUST_getCalenderId()
{
$this->db->select("CCN_DATA");
$this->db->from('CUSTOMER_CONFIGURATION');
$this->db->where("CCN_ID=9");
return $this->db->get()->row()->CCN_DATA;
}
//FUNCTION TO GET FOLDER ID TO PLACE CONTRACT OR INVOICE
public  function CUST_TargetFolderId()
{
$this->db->select("CCN_DATA");
$this->db->from('CUSTOMER_CONFIGURATION');
$this->db->where("CGN_ID=47");
return $this->db->get()->row()->CCN_DATA;
}
//FUNCTION TO GET ROOM TYPE FOR THE UNIT
public function CUST_getRoomType($unitno,$roomtype)
{
$this->db->select("URTD.URTD_ROOM_TYPE AS TYPE");
$this->db->from('UNIT_ROOM_TYPE_DETAILS URTD,UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U');
$this->db->where('URTD.URTD_ID=UASD.URTD_ID AND U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_NO='.$unitno);
$this->db->order_by("URTD.URTD_ROOM_TYPE", "ASC");
$result=array();
foreach ($this->db->get()->result_array() as $key=>$val)
{
if($val['TYPE']!=$roomtype)
$result[]=$val['TYPE'];
}
return $result;
}
//FUNCTION TO GET INVENTORY CARD NOS
    public function CUST_getunitCardNo_FirstLast($unit,$firstname,$lastname)
    {
        $this->db->select("UASD.UASD_ACCESS_CARD AS CARD");
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U');
        $this->db->where('U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_NO="'.$unit.'" AND UASD.UASD_ACCESS_INVENTORY IS NOT NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL');
        $this->db->order_by("UASD.UASD_ACCESS_CARD", "ASC");
        $resultCardNo=array();$resultCardLabel=array();
        foreach ($this->db->get()->result_array() as $key=>$val)
        {
            $resultCardNo[]=$val['CARD'];
            if($key<=3)
            {
                if($key==0)
                {
                    $resultCardLabel[]=$firstname." ".$lastname;
                }
                else
                {
                    $resultCardLabel[]="GUEST ".$key;
                }
            }
        }
        return array($resultCardNo,$resultCardLabel);
    }
//FUNCTION TO GET CALENDAR TO TIME
public function CUST_CalTotime($endtime)
{
$this->db->select("DATE_FORMAT(CTP_DATA, '%H:%i') AS DATE");
$this->db->from('CUSTOMER_TIME_PROFILE');
$resultTime=array();$timearray=array();
foreach ($this->db->get()->result_array() as $key=>$val)
{
$resultTime[]=$val['DATE'];
}
foreach ($resultTime as $key=>$val)
{
if($endtime==$val)
{
$endtime_status=$key;
break;
}
}
if($endtime=="23:30")
{
$timearray[]="23:59";
}
else if($endtime=="23:00")
{
$timearray[]="23:30";
$timearray[]="23:59";
}
else
{
$length=$endtime_status+2;
for($j=$endtime_status+1;$j<=$length;$j++)
{
$timearray[]=$resultTime[$j];
}
}
return $resultTime;
}
//FUNCTION TO GET CALENDAR FROM TIME
public function CUST_getCalendarTime()
{
$this->db->select("DATE_FORMAT(CTP_DATA, '%H:%i') AS DATE");
$this->db->from('CUSTOMER_TIME_PROFILE');
$timearray=array();
foreach ($this->db->get()->result_array() as $key=>$val)
{
if($val['DATE']=="23:59")continue;
$timearray [] =$val['DATE'];
}
return $timearray;
}
//FUNCTION TO GET PROFILE MAIL IDS
public   function getProfileEmailId($formname)
{
$formid=0;
if($formname=="CREATION_UAT")//CUSTOMER CREATION UAT
{
$formid=24;
}
if($formname=="CREATION")//CUSTOMER CREATION
{
$formid=1;
}
if($formname=="RECHECKIN")//CUSTOMER RECHECK IN
{
$formid=13;
}
if($formname=="EXTENSION")//CUSTOMER EXTENSION
{
$formid=14;
}
if($formname=="DD")//DEPOSIT EXTRACT PDF
{
$formid=15;
}
if($formname=="EXPIRY")//EXPIRY LIST
{
$formid=16;
}
if($formname=="OPL&ACTIVE CC")//OPL&ACTIVE CC LIST
{
$formid=17;
}
if($formname=="REPORT")//REPORT
{
$formid=20;
}
$mail_query = "SELECT DISTINCT EL_EMAIL_ID FROM EMAIL_LIST WHERE EP_ID=".$formid." ORDER BY EL_EMAIL_ID ASC";
if($formname=="CSV"||$formname=="ERM"||$formname=="ACTIVE_CC_TRIGGER"||$formname=="BANKTT"||$formname=="DROPTABLE")
{
if($formname=="CSV")
{
$formid="4,5,6";
}
if($formname=="ERM")
{
$formid="9,10";
}
if($formname=="ACTIVE_CC_TRIGGER")
{
$formid="18,19";
}
if($formname=="BANKTT")
{
$formid="11,12";
}
if($formname=="DROPTABLE")
{
$formid="22,23";
}
$mail_query="SELECT EL_EMAIL_ID FROM EMAIL_LIST WHERE EP_ID IN(".$formid.") ORDER BY EP_ID ASC";
}
$result = $this->db->query($mail_query);
$resultMail=array();
foreach ($result->result_array() as $key=>$val)
{
$resultMail[]=$val['EL_EMAIL_ID'];
}
return $resultMail;
}
//FUNCTION TO GET CONTRACT/INVOICE OPTION VALUE
public  function CUST_getOptionValue()
{
$this->db->select("CCN_ID AS optionid,CCN_DATA AS optionname");
$this->db->from('CUSTOMER_CONFIGURATION');
$this->db->where('CGN_ID=3');
$this->db->order_by("CCN_DATA", "ASC");
$this->db->get()->result_array();
}
//CHECK FOR ALREADY EXISTS FOR DOOR CODE AND WEB LOGIN
public function Check_ExistsDoorcodeLogin($value,$flag)
{
$this->db->select("ULDTL_ID");
$this->db->from('UNIT_LOGIN_DETAILS');
if($flag=='UNIT_tb_doorcode')
$this->db->where('ULDTL_DOORCODE',$value);
else if($flag=='UNIT_tb_weblogin')
$this->db->where('ULDTL_WEBLOGIN',$value);
$query=$this->db->get();
($query->num_rows() > 0?$flagCount=0:$flagCount=1);
return array($flagCount,$flag);
}
//GET THE INVOICE FROM THE EXPENSE UNIT TABLE//
public  function BDLY_getinvoicefrom()
{
$this->db->select("EU_INVOICE_FROM");
$this->db->from('EXPENSE_UNIT');
$this->db->where('EU_INVOICE_FROM IS NOT NULL');
$result=array();
foreach ($this->db->get()->result_array() as $key=>$val)
{
$result[]=$val['EU_INVOICE_FROM'];
}
return $result;
}
//FUNCTION TO GET MAIL DISPLAY NAME
public function Get_MailDisplayName($s){
switch($s)
{
case 'BANK_TT':
return 'BANK TT';
break;
case 'ERM':
return 'ERM';
break;
case 'ACTIVE_CC_LIST':
return 'ACTIVE CC LIST';
break;
case 'CUSTOMER_EXPIRY':
return 'CUSTOMER EXPIRY LIST';
break;
case 'OUTSTANDING_PAYEES':
return 'OUTSTANDING PAYEES LIST';
break;
case 'NON_PAYMENT_REMINDER':
return 'NON PAYMENT REMINDER';
break;
case 'NON_PAYMENT_NON_INTIMATED_CC':
return 'NON PAYMENT_NON INTIMATED CC LIST';
break;
case 'MONTHLY_PAYMENT_NON_INTIMATED_CC':
return 'MONTHLY PAYMENT_NON INTIMATED CC LIST';
break;
case 'DEPOSIT_DEDUCTION':
return 'DEPOSIT DEDUCTION';
break;
case 'INVOICE':
return 'INVOICE';
break;
case 'CONTRACT':
return 'CONTRACT';
break;
case 'INVOICE_N_CONTRACT':
return 'INVOICE N CONTRACT';
break;
case 'MONTHLY_PAYMENT_REMINDER':
return 'MONTHLY PAYMENT REMINDER';
break;
case 'DROP_TEMP_TABLE':
return 'TEMPORARY TABLE LIST';
break;
}
}
//FUNCTION TO GET CURRENT TIMEZONE IN 24 HRS FORMAT
public  function gettimezone24HRS()
{
date_default_timezone_set('Asia/Singapore');
$date = new DateTime();
return date_format($date, 'd-m-Y H:i:s');
}
    //Lease Period Calculation
    public  function getLeasePeriod($startDate, $endDate){
        $output = '';
        $endDate=strtotime ("+1 day",strtotime($endDate));
        $endDate= date('Y-m-d',$endDate);
        $dateEnd=intval(date('d',strtotime($endDate)));
        $dateStart=intval(date('d',strtotime($startDate)));
        $dateEndMon=intval(date('m',strtotime($endDate)));
        $dateStartMon=intval(date('m',strtotime($startDate)));
        $dateEndY=intval(date('Y',strtotime($endDate)));
        $dateStartY=intval(date('Y',strtotime($startDate)));
        $dateLast=intval(date('t',strtotime($endDate)));
        $EndStrMonth=strtotime($endDate);
        $dateLastMinusMonth=intval(date('t',strtotime ("-1 month",$EndStrMonth)));
        // edate.setDate( edate.getDate()+1);
        $years=(((($dateEnd-$dateStart)<0 ? -1:0)
                +(($dateEndMon)-($dateStartMon)))< 0 ? -1 : 0)+($dateEndY- $dateStartY);

        $months=(((($dateEnd-$dateStart)<0 ? -1:0)+(($dateEndMon)-($dateStartMon)))< 0 ?12:0)+(($dateEnd-$dateStart)<0 ? -1:0)+(($dateEndMon)-($dateStartMon));
        if(date('m',strtotime($endDate))!=1.0)
        {
            $days=(($dateEnd-$dateStart)< 0 ?$dateLastMinusMonth:0)+($dateEnd-$dateStart);
        }
        else
        {
            $days=(($dateEnd-$dateStart)< 0 ?$dateLast:0)+($dateEnd-$dateStart);
        }
        $output .= ( $years == 0 ? '' : (', ' . $years . ' Year' . ( $years == 1 ? '' : 's')));
        $output .= ( $months == 0 ? '' : (', ' .  $months . ' Month' . ( $months == 1 ? '' : 's')));
        $output .= ( $days == 0 ? '' : (', ' .  $days . ' Day' . ( $days == 1 ? '' : 's')));
        if(strpos($output,",")===false)
            return $output;
        else{
            $countLP=explode(',',$output);
            ($countLP[0]=='')?$output=preg_replace('/,/', "", $output, 1):$output=$output; return $output;}
    }
////Lease Period Calculation
//    public function getLeasePeriod($Startdate,$Enddate)
//    {
//        $datetime1 = new DateTime($Startdate);
//        $datetime2 = new DateTime($Enddate);
//        $difference = $datetime1->diff($datetime2);
//        if($difference->y==0 && $difference->m==0 ){$Leaseperiod=$difference->d.' Days';}
//        elseif($difference->y==0){$Leaseperiod=$difference->m.'Months '.$difference->d.' Days';}
//        elseif($difference->y==0 && $difference->d==0 ){$Leaseperiod=$difference->m.' Months';}
//        elseif($difference->m==0 && $difference->d==0 ){$Leaseperiod=$difference->y.' Years';}
//        elseif($difference->d==0 ){$Leaseperiod=$difference->y.' Years '.$difference->m.' Months';}
//        elseif($difference->m==0 ){$Leaseperiod=$difference->y.' Years '.$difference->d.' Days';}
//        else{$Leaseperiod=$difference->y.' Years '.$difference->m.' Months '.$difference->d.' Days';}
//        if($difference->y==0 && $difference->m==0 && intval($datetime1->format('d'))==1 && date("Y-m-d",strtotime($Enddate)) ==date("Y-m-t",strtotime($Enddate)) ){$Leaseperiod='1 Month';}
//        return $Leaseperiod;
//    }
//FUNCTION TO CHK PRORATED OR NOT 14
public function CUST_chkProrated($db_chkindate,$db_chkoutdate)
{
$chkin =date("Y-m-d",strtotime($db_chkindate)); // to convert check in date
$chkout=date("Y-m-d",strtotime($db_chkoutdate)); // to convert check out date
if($db_chkoutdate=="")
{
$chkproflag=false;
}
else
{
$Leaseperiod  = $this->getLeasePeriod($chkin,$chkout);
strpos($Leaseperiod,"Year")==false?$yearchk=-1:$yearchk=strpos($Leaseperiod,"Year");
strpos($Leaseperiod,"Months")==false?$monthschk=-1:$monthschk=strpos($Leaseperiod,"Months");
strpos($Leaseperiod,"Month")==false?$monthchk=-1:$monthchk=strpos($Leaseperiod,"Month");
strpos($Leaseperiod,"Day")==false?$daychk=-1:$daychk=strpos($Leaseperiod,"Day");
if(($yearchk>0)||($monthschk>0)||(($monthchk>0)&&($daychk>0)))
{

$chkproflag='true';
}
else if((($yearchk<0)&&($monthschk<0)&&($daychk>0)&&($monthchk<0))||(($yearchk<0)&&($monthschk<0)&&($daychk<0)&&($monthchk>0)))
{
$chkproflag='false';
}
}
return $chkproflag;
}
//GET TIMEZONE
public function getTimezone()
{
return ("'+00:00','+08:00'");
}
//FUNCTION TO GET THE URL TO USE GAS SCRIPT
public  function getUrlAccessGasScript()
{
    $this->db->select("URC_DATA");
    $this->db->from('USER_RIGHTS_CONFIGURATION');
    $this->db->where('URC_ID=7');
    return $this->db->get()->row()->URC_DATA;
}
//FUNCTION TO GET THE CLIENT,TOKEN ID
public  function getCalendarIdCilentIdService()
{
    $result=array();
    $this->db->select("URC_DATA");
    $this->db->from('USER_RIGHTS_CONFIGURATION');
    $this->db->where('URC_ID IN(8,9,10,11,12,13,16,17)');
    foreach ($this->db->get()->result_array() as $key=>$val)
    {
        $result[]=$val['URC_DATA'];
    }
    return $result;
}
//FUNCTION TO LOGO AND CALENDAR
public  function getLogoCalendar()
{
    $result=array();
    $this->db->select("URC_DATA");
    $this->db->from('USER_RIGHTS_CONFIGURATION');
    $this->db->where('URC_ID IN(14,15)');
    foreach ($this->db->get()->result_array() as $key=>$val)
    {
        $result[]=$val['URC_DATA'];
    }
    return $result;
}
//FUNCTION TO GET EVENTS BEFORE UPDATE TABLE
    public  function CTermExtn_GetCalevent($CTermExtn_custid)
    {
        $sql = "CALL SP_CUSTOMER_MIN_MAX_RV(".$CTermExtn_custid.",@MIN_LP,@MAX_LP)";
        $this->db->query($sql);
        $this->db->select('@MIN_LP AS MIN,@MAX_LP AS MAX', FALSE);
        $minLP = $this->db->get()->row()->MIN;
        $queryCustomer=$this->db->query("SELECT  C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CED.CED_REC_VER,CTD.CLP_GUEST_CARD,CTD.CLP_STARTDATE,IF(CTD.CLP_PRETERMINATE_DATE IS NULL,CTD.CLP_ENDDATE ,CTD.CLP_PRETERMINATE_DATE) AS ENDDATE,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CCD.CCD_OFFICE_NO,CPD.CPD_EMAIL,U.UNIT_NO,URTD.URTD_ROOM_TYPE,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME, CTPD.CTP_DATA AS CED_ED_ETIME FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE CTPA ON CED.CED_SD_STIME = CTPA.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPB ON CED.CED_SD_ETIME = CTPB.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPC ON CED.CED_ED_STIME = CTPC.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPD ON CED.CED_ED_ETIME = CTPD.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CTD,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U,CUSTOMER C WHERE  CED.UNIT_ID=U.UNIT_ID AND (CED.CUSTOMER_ID=".$CTermExtn_custid.")AND (CTD.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CTD.CED_REC_VER) AND (CTD.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS  NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)  AND (C.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CTD.CUSTOMER_ID=C.CUSTOMER_ID) AND CED.CED_REC_VER>=".$minLP." AND CTD.CLP_GUEST_CARD IS NULL ORDER BY CED.CED_REC_VER, CTD.CLP_GUEST_CARD ASC");
        $result []=$queryCustomer->row_array();
        for ($s=0;$s<count($result);$s++)
        {
            $finalResult[]=array('sddate'=>$result[$s]['CLP_STARTDATE'],'sdtimein'=>$result[$s]['CED_SD_STIME'],'sdtimeout'=>$result[$s]['CED_SD_ETIME'],'eddate'=>$result[$s]['ENDDATE'],'edtimein'=>$result[$s]['CED_ED_STIME'],'edtimeout'=>$result[$s]['CED_ED_ETIME']);

        }
        return $finalResult;
    }
//FUNCTION TO SHARE DOCS FOR THE LOGIN ID
function URSRC_shareDocuments($URSRC_custom_role,$URSRC_loginid,$service){
$URSRC_sharedocflag='';
try{
    $URSRC_usermenu_array=array();
    $URSRC_fileid_array=array();
    $URSRC_folderid_array=array();
    $URSRC_new_folder_array=array();
    $URSRC_fileid=array();
    if($URSRC_custom_role==""){
        $this->db->select();
        $this->db->from('USER_FILE_DETAILS UFD');
        $this->db->join('FILE_PROFILE  FP','UFD.FP_ID=FP.FP_ID');
        $this->db->where('UFD.RC_ID=(select RC_ID from ROLE_CREATION where RC_NAME=(SELECT RC.RC_NAME FROM USER_ACCESS UA,USER_LOGIN_DETAILS ULD,ROLE_CREATION RC WHERE RC.RC_ID=UA.RC_ID AND ULD.ULD_ID=UA.ULD_ID AND ULD_LOGINID="'.$URSRC_loginid.'" AND UA.UA_REC_VER=(SELECT MAX(UA.UA_REC_VER) FROM USER_ACCESS UA,USER_LOGIN_DETAILS ULD,ROLE_CREATION RC WHERE RC.RC_ID=UA.RC_ID AND ULD.ULD_ID=UA.ULD_ID AND ULD_LOGINID="'.$URSRC_loginid.'")))');
        $URSRC_select_files=$this->db->get();
    }else{
        $this->db->select();
        $this->db->from('USER_FILE_DETAILS UFD');
        $this->db->join('FILE_PROFILE  FP','UFD.FP_ID=FP.FP_ID');
        $this->db->where('UFD.RC_ID=(select RC_ID from ROLE_CREATION where RC_NAME="'.$URSRC_custom_role.'")');
        $URSRC_select_files=$this->db->get();
    }
    foreach($URSRC_select_files->result_array() as $row){
        $fileid=$row['FP_FILE_ID'];
        $folderid=$row['FP_FOLDER_ID'];
        if($fileid!=null){
            $URSRC_fileid_array[]=($fileid);
            $URSRC_folderid_array[]=($folderid);
            $URSRC_fileid[]=($fileid);
        }
        if($fileid==null ||$fileid!=null){
            $URSRC_fileid_array[]=($row["FP_FOLDER_ID"]);
        }
        if($fileid==null){
            $URSRC_new_folder_array[]=($row["FP_FOLDER_ID"]);
        }
    }
    $URSRC_fileid_array=array_values(array_unique($URSRC_fileid_array));
    $URSRC_folderid_array=array_values(array_unique($URSRC_folderid_array));
    $URSRC_all_fileid_array=array();
    $this->db->select();
    $this->db->from('FILE_PROFILE');
    $this->db->where('FP_FILE_FLAG is null');
    $URSRC_select_allfiles=$this->db->get();
    foreach($URSRC_select_allfiles->result_array() as $row){
        $fileid=$row['FP_FILE_ID'];
        if($fileid!=null){
            $URSRC_all_fileid_array[]=($fileid);
        }
        if($fileid==null || $fileid!=null){
            $URSRC_all_fileid_array[]=$row["FP_FOLDER_ID"];
        }
    }
    $URSRC_all_fileid_array=array_values(array_unique($URSRC_all_fileid_array));
    $service=$this->get_service_document();
    for($i=0;$i<count($URSRC_all_fileid_array);$i++){
//            $file_type=$this->get_MIME_type($service,$URSRC_all_fileid_array[$i]);//DriveApp.getFileById(URSRC_all_fileid_array[i]).getMimeType();
        $Folder_editor1=$this->URSRC_GetAllEditors($service,$URSRC_all_fileid_array[$i]);
        if(count($Folder_editor1)==0){
            $URSRC_sharedocflag=0;
            break;
        }
        else $URSRC_sharedocflag=1;
        for($j=0;$j<count($Folder_editor1);$j++){
            if($URSRC_loginid==$Folder_editor1[$j])
            {
                $URSRC_sharedocflag=$this->URSRC_RemoveEditor($service,$URSRC_all_fileid_array[$i],$URSRC_loginid);
            }
        }
    }
    for($i=0;$i<count($URSRC_fileid_array);$i++)
    {
        $shar_Folder=$this->URSRC_AddEditor($service,$URSRC_fileid_array[$i],$URSRC_loginid);//DriveApp.getFolderById(URSRC_fileid_array[i]).addEditor(URSRC_loginid);
    }
    $get_files_array=array();
    for($a=0;$a<count($URSRC_new_folder_array);$a++){
        $get_files=$this->URSRC_GetAllFiles($service,$URSRC_new_folder_array[$a]);
        for($h=0;$h<count($get_files);$h++){
            $get_files_array[]=($get_files[$h]);
        }
    }
    for($h=0;$h<count($get_files_array);$h++){
//$file_type=$this->get_MIME_type($service,$get_files_array[$h]);
        $new_fileeditors=$this->URSRC_GetAllEditors($service,$get_files_array[$h]);
        for($j=0;$j<count($new_fileeditors);$j++){
            if($URSRC_loginid==$new_fileeditors[$j]){
                $this->URSRC_RemoveEditor($service,$get_files_array[$j],$URSRC_loginid);
            }
        }
    }
    $allid_array=array();
    if(count($URSRC_folderid_array)!=0){
        $folder=$URSRC_folderid_array[0];
        $allid_array=$this->URSRC_getAllFiles($service,$folder);//TO GET FOLDER FILES
    }
    $URSRC_new_diff_array=array();
    if(count($URSRC_fileid)!=0){
        $URSRC_new_diff_array=array_diff($allid_array,$allid_array);//;getDifferenceArray($URSRC_fileid,$allid_array);
        $URSRC_new_diff_array=array_values($URSRC_new_diff_array);
        for($k=0;$k< count($URSRC_new_diff_array);$k++){
//            $file_type=$this->get_MIME_type($service,$URSRC_new_diff_array[$k]);
            $foldereditors=$this->URSRC_GetAllEditors($service,$URSRC_new_diff_array[$k]);
            for($l=0;$l<count($foldereditors);$l++){
                if($foldereditors[$l]=='')continue;
                if($URSRC_loginid==$foldereditors[$l])
                {
                    $this->URSRC_RemoveEditor($service,$URSRC_new_diff_array[$k],$URSRC_loginid);
                }
            }
        }
    }
}
catch(Exception $e){
    $URSRC_sharedocflag=0;
}
return $URSRC_sharedocflag;
}
//FUNCTION TO UNSHARE DOCS
public function URSRC_unshareDocuments($URSRC_custom_role,$URSRC_loginid,$service){
$URSRC_sharedocflag='';
try{
    $URSRC_fileid_array=array();
    $URSRC_old_fileid_array=array();
    if($URSRC_custom_role==""){
        $this->db->select();
        $this->db->from('USER_FILE_DETAILS UFD');
        $this->db->join('FILE_PROFILE FP','FP.FP_ID=UFD.FP_ID');
        $this->db->where('UFD.RC_ID=(select RC_ID from ROLE_CREATION where RC_NAME=(SELECT RC.RC_NAME FROM USER_ACCESS UA,USER_LOGIN_DETAILS ULD,ROLE_CREATION RC WHERE RC.RC_ID=UA.RC_ID AND ULD.ULD_ID=UA.ULD_ID AND ULD_LOGINID="'.$URSRC_loginid.'" AND UA.UA_REC_VER=(SELECT MAX(UA.UA_REC_VER) FROM USER_ACCESS UA,USER_LOGIN_DETAILS ULD,ROLE_CREATION RC WHERE RC.RC_ID=UA.RC_ID AND ULD.ULD_ID=UA.ULD_ID AND ULD_LOGINID="'.$URSRC_loginid.'")))');
        $URSRC_select_files=$this->db->get();
    }else{
        $this->db->select();
        $this->db->from('USER_FILE_DETAILS UFD');
        $this->db->join('FILE_PROFILE FP','FP.FP_ID=UFD.FP_ID');
        $this->db->where('UFD.RC_ID=(select RC_ID from ROLE_CREATION where RC_NAME="'.$URSRC_custom_role.'")');
        $URSRC_select_files=$this->db->get();
    }
    foreach($URSRC_select_files->result_array() as $row){
        $fileid=$row["FP_FILE_ID"];
        $folderid=$row["FP_FOLDER_ID"];
        if($fileid!=null){
            $URSRC_fileid_array[]=($fileid);
        }
        if($fileid==null ||$fileid!=null){
            $URSRC_fileid_array[]=($row["FP_FOLDER_ID"]);
        }
    }
    $service=$this->get_service_document();
    for($i=0;$i<count($URSRC_fileid_array);$i++)
    {
        $Folder_editor1=$this->URSRC_GetAllEditors($service,$URSRC_fileid_array[$i]);
        for($j=0;$j<count($Folder_editor1);$j++){
            if($URSRC_loginid==$Folder_editor1[$j])
            {
                $this->URSRC_RemoveEditor($service,$URSRC_fileid_array[$i],$URSRC_loginid);
                $URSRC_sharedocflag=1;
            }
        }
    }
}
catch(Exception $e){
    $URSRC_sharedocflag=0;
}
return $URSRC_sharedocflag;
}
//FUNCTION TO GET THE DOCUMENT SERVICE
    public function get_service_document(){
        $ClientId=  $this->getCalendarIdCilentIdService();
        $drive = new Google_Client();
        $drive->setClientId($ClientId[0]);
        $drive->setClientSecret($ClientId[1]);
        $drive->setRedirectUri($ClientId[2]);
        $drive->setScopes(array($ClientId[3],$ClientId[4]));
        $drive->setAccessType('online');
        $authUrl = $drive->createAuthUrl();
        $refresh_token= $ClientId[5];
        $drive->refreshToken($refresh_token);
        $service = new Google_Service_Drive($drive);
        return $service;
    }
public function URSRC_GetAllEditors($service,$fileid){

try {
    $permission_id=array();
    $emailadrress=array();
    $role_array=array();
    $permissions = $service->permissions->listPermissions($fileid);
    $return_value= $permissions->getItems();
    foreach ($return_value as $key => $value) {
        $permission_id[]=$value->id;
        $emailadrress[]=$value->emailAddress;
        $role_array[]=$value->role;
    }
} catch (Exception $e) {
    $emailadrress=array();
}
return $emailadrress;
}
public  function URSRC_RemoveEditor($service,$fileid,$URSRC_loginid){
$URSRC_sharedocflag='';
try {
$permissions = $service->permissions->listPermissions($fileid);
$return_value= $permissions->getItems();
$permission_id='';
foreach ($return_value as $key => $value) {
    if ($value->emailAddress==$URSRC_loginid) {
        $permission_id=$value->id;
    }
}
if($permission_id!=''){
    try {
        $service->permissions->delete($fileid, $permission_id);
//        $ss_flag=1;
    } catch (Exception $e) {
//        $ss_flag=0;
    }
}
$URSRC_sharedocflag=1;
}
catch (Exception $e) {
$URSRC_sharedocflag=0;
}
return $URSRC_sharedocflag;

}
//ADD EDITORS
public  function URSRC_AddEditor($service,$fileid,$URSRC_loginid){
$value=$URSRC_loginid;
$type='user';
$role='writer';
$email=$URSRC_loginid;
$newPermission = new Google_Service_Drive_Permission();
$newPermission->setValue($value);
$newPermission->setType($type);
$newPermission->setRole($role);
$newPermission->setEmailAddress($email);
try {
    $service->permissions->insert($fileid, $newPermission);
} catch (Exception $e) {
}
}
//get all files using folder id
public function URSRC_GetAllFiles($service,$folderid){
$children1 = $service->children->listChildren($folderid);
$filearray1=$children1->getItems();
$emp_uploadfilenamelist=array();
foreach ($filearray1 as $child1) {
    $emp_uploadfilenamelist[]=($child1->getId());
}
return $emp_uploadfilenamelist;
}
//FUNCTION TO SHARE/UNSHARE CALENDAR
    function USRC_shareUnSharecalender($URSRC_loginid,$role,$service){
        $this->load->model('EILIB/Mdl_eilib_calender');
        $calendarId=$this->Mdl_eilib_calender->GetEICalendarId();
        try{
            $cal = $this->Mdl_eilib_calender->createCalendarService();
            $rule = new Google_Service_Calendar_AclRule();
            $scope = new Google_Service_Calendar_AclRuleScope();
            $scope->setType("user");
            $scope->setValue($URSRC_loginid);
            $rule->setScope($scope);
            $rule->setRole($role);
            $createdRule = $cal->acl->insert($calendarId, $rule);
            return 1;
        }
        catch(Exception $e){
            return 0;
        }
    }
//FUNCTION TO FILE ID TO GET TITLE
public  function CUST_FileId_invoiceTem()
{
    $this->db->select("CCN_DATA");
    $this->db->from('CUSTOMER_CONFIGURATION');
    $this->db->where("CCN_ID=11");
    return $this->db->get()->row()->CCN_DATA;
}
    //**************GET LEASE PERIOD DETAILS ******************//
public function getActive_Customer_Recver_Dates($unit,$customer,$Recever)
{
    $LPselectquery="SELECT CLP.CLP_STARTDATE,CLP.CLP_ENDDATE,CLP.CLP_PRETERMINATE_DATE FROM CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED,UNIT U WHERE CED.CUSTOMER_ID=CLP.CUSTOMER_ID AND CED.UNIT_ID = U.UNIT_ID AND CLP.CED_REC_VER = CED.CED_REC_VER AND CED.CUSTOMER_ID='$customer' AND CED.CED_REC_VER='$Recever' AND U.UNIT_NO='$unit'";
    $resultset=$this->db->query($LPselectquery);
    return $resultset->result();
}
    //********NEW SPREADSHEET CREATION*************//
    public  function NewSpreadsheetCreation($service, $title, $description, $parentId) {
        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($title);
        $file->setDescription($description);
        $file->setMimeType('application/vnd.google-apps.spreadsheet');
        if ($parentId != null) {
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
        }
        try {
            $createdFile = $service->files->insert($file, array(
                'mimeType' => 'application/vnd.google-apps.spreadsheet',//$mimeType,
                'convert' => TRUE,
                'uploadType'=>'resumable'
            ));
            return $createdFile->getId();
        }
        catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }
    //*************CUSTOMER FILE UPLOAD **************//
    public function Customer_FileUpload($service, $title, $description, $parentId,$mimeType,$uploadfilename)
    {
        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($title);
        $file->setDescription($description);
        $file->setMimeType($mimeType);
        if ($parentId != null) {
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
        }
        try
        {
            $data =file_get_contents($uploadfilename);
            $createdFile = $service->files->insert($file, array(
                'data' => $data,
                'mimeType' => 'application/pdf',
                'uploadType' => 'media',
            ));
            $fileid = $createdFile->getId();
        }
        catch (Exception $e)
        {
            $file_flag=0;
        }
        return $fileid;
    }
    //**************CRUL CALLING FUNCTION***************//
    public function Func_curl($data)
    {
        $url =$this->getUrlAccessGasScript();
        $ch = curl_init();
        $data = http_build_query($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        try {
            $response = curl_exec($ch);
            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        curl_close($ch);
    }
    //Customer folder creation
    public function Customer_FolderCreation($service, $title, $description, $parentId)
    {

        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($title);
        $file->setDescription($description);
        $file->setMimeType('application/vnd.google-apps.folder');
        if ($parentId != null) {
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
        }
        try
        {
            $createdFile = $service->files->insert($file, array(
                'mimeType' => 'application/vnd.google-apps.folder',
            ));
            return $createdFile->id;
        }
        catch (Exception $e)
        {
            return 0;
        }
    }
    //*****************FILE DELETE***********************//
    function DeleteFile($service, $fileId) {
        try {
            $service->files->delete($fileId);
            return 1;
        }
        catch (Exception $e) {
            return 0;
        }
    }
    /***********GET INSTANCE AND SCHEMA*****************/
    public function getSchemaName()
    {
        $CI =& get_instance();
        $CI->load->database();
        return $CI->db->database;
    }
    public  function getInstanceName()
    {
        $CI =& get_instance();
        $CI->load->database();
        return $CI->db->hostname;
    }
    //ESCAPE SPECIAL CHARACTERS
    public function jsspecialchars($string){
        $string = preg_replace("/\r*\n/","\\n",$string);
        $string = preg_replace("/\//","\\\/",$string);
        $string = preg_replace("/\"/","\\\"",$string);
        $string = preg_replace("/'/","\'",$string);
        return $string;
    }
}
