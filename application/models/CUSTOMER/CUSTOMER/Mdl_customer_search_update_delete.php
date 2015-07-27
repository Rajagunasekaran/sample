<?php
//error_reporting(0);
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
//require 'application/PHPMailer-master/PHPMailerAutoload.php';
class Mdl_customer_search_update_delete extends CI_Model
{
    public function getMaximumDate($cusId){
        $queryPersonal=$this->db->query('select IF(CLP_PRETERMINATE_DATE IS NOT NULL,CLP_PRETERMINATE_DATE,CLP_ENDDATE)AS ENDDATE FROM CUSTOMER_LP_DETAILS CLP,VW_SUB_CUSTOMER VW WHERE CLP.CUSTOMER_ID=VW.CUSTOMERID AND CLP.CED_REC_VER=VW.REC_VER AND CUSTOMER_ID='.$cusId.'');
        return $queryPersonal->result_array();
    }
    public function getPersonalDetails($cusId){
        $queryPersonal=$this->db->query('SELECT CUST.CUSTOMER_FIRST_NAME,CUST.CUSTOMER_LAST_NAME,C.CPD_MOBILE,C.CPD_INTL_MOBILE,CCD.CCD_OFFICE_NO,C.CPD_EMAIL FROM CUSTOMER_PERSONAL_DETAILS C,CUSTOMER CUST left join CUSTOMER_COMPANY_DETAILS CCD on  CUST.CUSTOMER_ID = CCD.CUSTOMER_ID WHERE CUST.CUSTOMER_ID ='.$cusId.' AND  CUST.CUSTOMER_ID = C.CUSTOMER_ID');
        return $queryPersonal->result_array();
    }
    public function getSearchOption()
    {
        $this->db->select('CCN_ID,CCN_DATA');
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->order_by("CCN_DATA", "ASC");
        $this->db->where('CGN_ID=33');
        $query = $this->db->get();
        return $query->result();
    }
    public function getCustomernames()
    {
        $this->db->select('CUSTOMER_FIRST_NAME,CUSTOMER_LAST_NAME');
        $this->db->from('CUSTOMER');
        $this->db->order_by("CUSTOMER_FIRST_NAME", "ASC");
        $query = $this->db->get();
        return $query->result();
    }
    public function getCustomerCompanyNames()
    {
        $this->db->select('CCD_COMPANY_NAME');
        $this->db->from('CUSTOMER_COMPANY_DETAILS');
        $this->db->order_by("CCD_COMPANY_NAME", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getCustomerCardNos()
    {
        $this->db->select('UASD_ACCESS_CARD');
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS');
        $this->db->where('UASD_ACCESS_CARD IS NOT NULL');
        $this->db->order_by("UASD_ACCESS_CARD", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllRoomtypes()
    {
        $this->db->select('URTD_ROOM_TYPE,URTD_ID');
        $this->db->from('UNIT_ROOM_TYPE_DETAILS');
        $this->db->order_by("URTD_ROOM_TYPE", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllEmail()
    {
        $this->db->select('CPD_EMAIL');
        $this->db->from('CUSTOMER_PERSONAL_DETAILS');
        $this->db->order_by("CPD_EMAIL", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllEPnumbers()
    {
        $this->db->select('CPD_EP_NO');
        $this->db->from('CUSTOMER_PERSONAL_DETAILS');
        $this->db->order_by("CPD_EP_NO", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllPassPortnumbers()
    {
        $this->db->select('CPD_PASSPORT_NO');
        $this->db->from('CUSTOMER_PERSONAL_DETAILS');
        $this->db->order_by("CPD_PASSPORT_NO", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllMobileNumbers()
    {
        $this->db->select('CPD_MOBILE');
        $this->db->from('CUSTOMER_PERSONAL_DETAILS');
        $this->db->order_by("CPD_MOBILE", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllIntlMobileNumbers()
    {
        $this->db->select('CPD_INTL_MOBILE');
        $this->db->from('CUSTOMER_PERSONAL_DETAILS');
        $this->db->order_by("CPD_INTL_MOBILE", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllOfficeNumbers()
    {
        $this->db->select('CCD_OFFICE_NO');
        $this->db->from('CUSTOMER_COMPANY_DETAILS');
        $this->db->order_by("CCD_OFFICE_NO", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllComments()
    {
        $this->db->select('CPD_COMMENTS');
        $this->db->from('CUSTOMER_PERSONAL_DETAILS');
        $this->db->order_by("CPD_COMMENTS", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getSearchResults($searchoption,$data1,$data2,$userstamp,$timeZoneFormat)
    {
        if($searchoption==21)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==18)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==19)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==22)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1','$data2','$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==27)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==30)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1','$data2','$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==31)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==33)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==24)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==25)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==29)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==26)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==32)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==28)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==20)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==23)
        {
            $fromdate=date('Y-m-d',strtotime($data1));
            $todate=date('Y-m-d',strtotime($data2));
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$fromdate','$todate','$searchoption','$userstamp',@TABLENAME)";
        }
        elseif($searchoption==34)
        {
            $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_TABLE('$data1',null,'$searchoption','$userstamp',@TABLENAME)";
        }
        $this->db->query($temptablequery);
        $outparm_query = 'SELECT @TABLENAME AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
        $CSRC_customerflextable_query ='SELECT DISTINCT CTD.CLP_TERMINATE,CED.CED_PRORATED,CED.CED_PRETERMINATE,U.UNIT_NO,CED.CED_PROCESSING_WAIVED,C.CUSTOMER_ID,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CCD.CCD_COMPANY_NAME,CCD.CCD_COMPANY_ADDR,CCD.CCD_POSTAL_CODE,CCD.CCD_OFFICE_NO,CED.UASD_ID,CED.CED_REC_VER,CED.CED_SD_STIME,CED.CED_SD_ETIME,CED.CED_ED_STIME,CED.CED_ED_ETIME,CED.CED_LEASE_PERIOD,CED.CED_QUARTERS,CED.CED_RECHECKIN,CED.CED_EXTENSION,CED.CED_PROCESSING_WAIVED,CED.CED_PRETERMINATE,CED.CED_NOTICE_PERIOD,DATE_FORMAT(CED.CED_NOTICE_START_DATE,"%d-%m-%Y")AS CED_NOTICE_START_DATE,DATE_FORMAT(CED.CED_CANCEL_DATE,"%d-%m-%Y")AS CED_CANCEL_DATE,CF.CC_DEPOSIT,CF.CC_PAYMENT_AMOUNT,CF.CC_DEPOSIT,CF.CC_ELECTRICITY_CAP,CF.CC_AIRCON_FIXED_FEE,CF.CC_AIRCON_QUARTERLY_FEE,CF.CC_DRYCLEAN_FEE,CF.CC_PROCESSING_FEE,CF.CC_CHECKOUT_CLEANING_FEE,CF.CC_ROOM_TYPE,DATE_FORMAT(CTD.CLP_STARTDATE,"%d-%m-%Y")AS CLP_STARTDATE,DATE_FORMAT(CTD.CLP_ENDDATE,"%d-%m-%Y")AS CLP_ENDDATE,CTD.CLP_TERMINATE,DATE_FORMAT(CTD.CLP_PRETERMINATE_DATE,"%d-%m-%Y")AS CLP_PRETERMINATE_DATE,CTD.CLP_GUEST_CARD,UASD.UASD_ACCESS_CARD,NC.NC_DATA,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CPD.CPD_EMAIL,CPD.CPD_PASSPORT_NO,CPD.CPD_PASSPORT_DATE,CPD.CPD_EP_NO,CPD.CPD_EP_DATE,DATE_FORMAT(CPD.CPD_DOB,"%d-%m-%Y")AS CPD_DOB,CPD.CPD_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(CTD.CLP_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS CLP_TIMESTAMP
              FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD on CED.CUSTOMER_ID=CCD.CUSTOMER_ID left join CUSTOMER_LP_DETAILS CTD on CED.CUSTOMER_ID=CTD.CUSTOMER_ID left join CUSTOMER_ACCESS_CARD_DETAILS CACD on CED.CUSTOMER_ID=CACD.CUSTOMER_ID and (CTD.UASD_ID=CACD.UASD_ID)left join UNIT_ACCESS_STAMP_DETAILS UASD on  (UASD.UASD_ID=CACD.UASD_ID) left join CUSTOMER_TEMPTABLE CF on  CED.CUSTOMER_ID=CF.CUSTOMER_ID left join CUSTOMER C on CED.CUSTOMER_ID=C.CUSTOMER_ID left join  CUSTOMER_PERSONAL_DETAILS CPD on CED.CUSTOMER_ID=CPD.CUSTOMER_ID ,NATIONALITY_CONFIGURATION NC ,UNIT U,USER_LOGIN_DETAILS ULD
              WHERE  (CED.UNIT_ID=U.UNIT_ID) and(CPD.NC_ID=NC.NC_ID) and  (CED.CED_REC_VER=CF.CUSTOMER_REC_VER) AND CED.CED_REC_VER=CTD.CED_REC_VER AND ULD.ULD_ID=CTD.ULD_ID AND ULD.ULD_ID=CTD.ULD_ID
              ORDER BY C.CUSTOMER_ID,CED.CED_REC_VER,CACD.CACD_GUEST_CARD';
        $Selectquery=str_replace('CUSTOMER_TEMPTABLE',$csrc_tablename,$CSRC_customerflextable_query);
        $resultset=$this->db->query($Selectquery);
        $this->db->query('DROP TABLE IF EXISTS '.$csrc_tablename);
        return $resultset->result();
    }
    public function SelectCustomerResults($customerid,$leaseperiod,$UserStamp)
    {
        $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_FEE_DETAIL('$customerid','$UserStamp',@CUSTOMER_SEARCH_FEE_TEMPTBLNAME)";
        $this->db->query($temptablequery);
//        echo $temptablequery;
        $outparm_query = 'SELECT @CUSTOMER_SEARCH_FEE_TEMPTBLNAME AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
        $CSRC_customerflextable_query ='SELECT DISTINCT
             CED.CED_PROCESSING_WAIVED,CED.CED_PRORATED,U.UNIT_NO,C.CUSTOMER_ID,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,
             CCD.CCD_COMPANY_NAME,CCD.CCD_COMPANY_ADDR,CCD.CCD_POSTAL_CODE,CCD.CCD_OFFICE_NO,CED.UASD_ID,CED.CED_REC_VER,
             CED.CED_LEASE_PERIOD,CED.CED_QUARTERS,CED.CED_RECHECKIN,CED.CED_EXTENSION,CED.CED_PRETERMINATE,
             CTD.CLP_PRETERMINATE_DATE,CED.CED_NOTICE_PERIOD,DATE_FORMAT(CED.CED_NOTICE_START_DATE,"%d-%m-%Y")AS CED_NOTICE_START_DATE,
             CED.CED_CANCEL_DATE,CF.CC_DEPOSIT,CF.CC_PAYMENT_AMOUNT,CF.CC_DEPOSIT,CF.CC_ELECTRICITY_CAP,CF.CC_AIRCON_FIXED_FEE,
             CF.CC_AIRCON_QUARTERLY_FEE,CF.CC_DRYCLEAN_FEE,CF.CC_PROCESSING_FEE,CF.CC_CHECKOUT_CLEANING_FEE,CF.CC_ROOM_TYPE,
             DATE_FORMAT(CTD.CLP_STARTDATE,"%d-%m-%Y")AS STARTDATE,DATE_FORMAT(CTD.CLP_ENDDATE,"%d-%m-%Y") AS ENDDATE,
             CTD.CLP_TERMINATE,DATE_FORMAT(CTD.CLP_PRETERMINATE_DATE,"%d-%m-%Y")AS CLP_PRETERMINATE_DATE,CTD.CLP_GUEST_CARD,
             UASD.UASD_ACCESS_CARD,NC.NC_DATA,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CPD.CPD_EMAIL,CPD.CPD_PASSPORT_NO,
             CPD.CPD_PASSPORT_DATE,CPD.CPD_EP_NO,CPD.CPD_EP_DATE,DATE_FORMAT(CPD.CPD_DOB,"%d-%m-%Y")AS CPD_DOB,CPD.CPD_COMMENTS,ULD.ULD_LOGINID,
             CTD.CLP_TIMESTAMP,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME,
             CTPD.CTP_DATA AS CED_ED_ETIME
          FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE CTPA ON CED.CED_SD_STIME = CTPA.CTP_ID LEFT JOIN
            CUSTOMER_TIME_PROFILE CTPB ON CED.CED_SD_ETIME = CTPB.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPC ON
            CED.CED_ED_STIME = CTPC.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPD ON CED.CED_ED_ETIME = CTPD.CTP_ID LEFT JOIN
            CUSTOMER_COMPANY_DETAILS CCD on CED.CUSTOMER_ID=CCD.CUSTOMER_ID left join CUSTOMER_LP_DETAILS CTD on
            CED.CUSTOMER_ID=CTD.CUSTOMER_ID left join CUSTOMER_ACCESS_CARD_DETAILS CACD on CED.CUSTOMER_ID=CACD.CUSTOMER_ID
            and (CTD.UASD_ID=CACD.UASD_ID)left join UNIT_ACCESS_STAMP_DETAILS UASD on  (UASD.UASD_ID=CACD.UASD_ID)
            left join '.$csrc_tablename.' CF on  CED.CUSTOMER_ID=CF.CUSTOMER_ID left join CUSTOMER C on
            CED.CUSTOMER_ID=C.CUSTOMER_ID left join  CUSTOMER_PERSONAL_DETAILS CPD on CED.CUSTOMER_ID=CPD.CUSTOMER_ID,
            NATIONALITY_CONFIGURATION NC ,UNIT U,USER_LOGIN_DETAILS ULD
          WHERE (CED.UNIT_ID=U.UNIT_ID) and(CPD.NC_ID=NC.NC_ID) and  (CED.CED_REC_VER=CF.CUSTOMER_VER) AND
            CED.CED_REC_VER='.$leaseperiod.' AND C.CUSTOMER_ID='.$customerid.' AND ((CACD.ACN_ID BETWEEN 1 AND 4) OR
            CACD.ACN_ID IS NULL) AND CED.CED_REC_VER=CTD.CED_REC_VER AND CTD.ULD_ID=ULD.ULD_ID
          ORDER BY C.CUSTOMER_ID,CED.CED_REC_VER,CACD.CACD_GUEST_CARD';
        $resultset=$this->db->query($CSRC_customerflextable_query);
        $this->db->query('DROP TABLE IF EXISTS '.$csrc_tablename);
        return $resultset->result();
    }
    public function getUploadfileDetails($Unit,$Customerid)
    {
        $Customerfolderselect="SELECT  CUFD_CUSTOMER_FOLDER_ID FROM CUSTOMER_FILE_DIRECTORY CFD,UNIT_FOLDER_DIRECTORY UFD WHERE CFD.CUSTOMER_ID='$Customerid' AND UFD.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$Unit')AND CFD.UFD_ID=UFD.UFD_ID";
//        echo $Customerfolderselect;
        $customerfolderid="";
        $outparm_result = $this->db->query($Customerfolderselect);
        if($outparm_result->num_rows>0 && $outparm_result->num_rows!="")
            $customerfolderid=$outparm_result->row()->CUFD_CUSTOMER_FOLDER_ID;
        if($customerfolderid!='')
        {
            $customernameselectquery = "SELECT CONCAT(CUSTOMER_FIRST_NAME,' ',CUSTOMER_LAST_NAME) AS CUSTOMERNAME FROM CUSTOMER WHERE CUSTOMER_ID='$Customerid'";
            $customername_result = $this->db->query($customernameselectquery);
            $customerfilename = $customername_result->row()->CUSTOMERNAME;
            $customeruploadfilename = $Unit . '-' . $Customerid . '-' . $customerfilename;
            $service = $this->Mdl_eilib_common_function->get_service_document();
            $children1 = $service->children->listChildren($customerfolderid);
            $filearray1 = $children1->getItems();
            $filenameandlink = array();
            foreach ($filearray1 as $child1) {
                $fileid = $service->files->get($child1->getId())->id;
                $filename = $service->files->get($child1->getId())->title;
                $filename = $service->files->get($child1->getId())->title;
                $url = $service->files->get($child1->getId())->alternateLink;
                $data = $url . "######" . $fileid."######".$filename;
                array_push($filenameandlink, $data);
            }
        }
        else
        {
            $filenameandlink='';
        }
        return $filenameandlink;
    }
    public function getRoomtypeData($roomtypeid,$lp)
    {
        $this->db->select('URTD.URTD_ROOM_TYPE');
        $this->db->from('UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER_ENTRY_DETAILS CED');
        $this->db->where('CED.UASD_ID='.$roomtypeid.' AND UASD.UASD_ID=CED.UASD_ID AND(UASD.URTD_ID=URTD.URTD_ID) and CED.CED_REC_VER='.$lp);
        $query = $this->db->get();
        return $query->result();
    }
    public function getSearchRecverdetails($unit,$customerid,$LP,$UserStamp)
    {
        $temptablequery="CALL SP_CUSTOMER_SEARCH_PREVIOUS_RECVER_START_ENADATE('$customerid','$LP','$unit','$UserStamp',@CUSTOMER_SEARCH_PREVIOUS_RECVER_TMPTBL)";
        $this->db->query($temptablequery);
        $outparm_query = 'SELECT @CUSTOMER_SEARCH_PREVIOUS_RECVER_TMPTBL AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
        $CSRC_customerflextable_query ="SELECT *FROM ".$csrc_tablename;
        $resultset=$this->db->query($CSRC_customerflextable_query);
        $this->db->query('DROP TABLE IF EXISTS '.$csrc_tablename);
        return $resultset->result();
    }
    public function Customer_Search_Update($UserStamp,$Leaseperiod,$Quoters)
    {
        try {
            $FirstName = $_POST['CCRE_SRC_FirstName'];
            $Lastname = $_POST['CCRE_SRC_LastName'];
            $Name=$FirstName.' '.$Lastname;
            $CompanyName = $_POST['CCRE_SRC_CompanyName'];
            $CompanyAddress = $_POST['CCRE_SRC_CompanyAddress'];
            $CompanyPostalCode = $_POST['CCRE_SRC_CompanyPostalCode'];
            $Emailid = $_POST['CCRE_SRC_Emailid'];
            $Mobile = $_POST['CCRE_SRC_Mobile'];
            $IntlMobile = $_POST['CCRE_SRC_IntlMobile'];
            $Officeno = $_POST['CCRE_SRC_Officeno'];
            $DOB = $_POST['CCRE_SRC_DOB'];
            if ($DOB != '') {
                $DOB = date('Y-m-d', strtotime($DOB));
            }
            $Nationality = $_POST['CCRE_SRC_Nationality'];
            $PassportNo = $_POST['CCRE_SRC_PassportNo'];
            $PassportDate = $_POST['CCRE_SRC_PassportDate'];
            if ($PassportDate != '') {
                $PassportDate = date('Y-m-d', strtotime($PassportDate));
            }
            $EpNo = $_POST['CCRE_SRC_EpNo'];
            $EPDate = $_POST['CCRE_SRC_EPDate'];
            if ($EPDate != '') {
                $EPDate = date('Y-m-d', strtotime($EPDate));
            }
            $Uint = $_POST['CCRE_SRC_UnitNo'];
            $RoomType = $_POST['CCRE_SRC_RoomType'];
            $Startdate = date('Y-m-d', strtotime($_POST['CCRE_SRC_Startdate']));
            $Start_date=$_POST['CCRE_SRC_Startdate'];
            $S_starttime = $_POST['CCRE_SRC_SDStarttime'];
            $S_endtime = $_POST['CCRE_SRC_SDEndtime'];
            $Enddate = date('Y-m-d', strtotime($_POST['CCRE_SRC_Enddate']));
            $End_date=$_POST['CCRE_SRC_Enddate'];
            $E_starttime = $_POST['CCRE_SRC_EDStarttime'];
            $E_endtime = $_POST['CCRE_SRC_EDEndtime'];
            $NoticePeriod = $_POST['CCRE_SRC_NoticePeriod'];
            $NoticePeriodDate = $_POST['CCRE_SRC_NoticePeriodDate'];
            if ($NoticePeriodDate != '') {
                $NoticePeriodDate = date('Y-m-d', strtotime($NoticePeriodDate));
            }
            $Quaterlyfee = $_POST['CCRE_SRC_Quarterly_fee'];if($Quaterlyfee==''){$InvQuaterlyfee='null';}else{$InvQuaterlyfee=$Quaterlyfee;}
            $Fixedaircon_fee = $_POST['CCRE_SRC_Fixedaircon_fee'];if($Fixedaircon_fee==''){$InvFixedaircon_fee='null';}else{$InvFixedaircon_fee=$Fixedaircon_fee;}
            $ElectricitycapFee = $_POST['CCRE_SRC_ElectricitycapFee'];if($ElectricitycapFee==''){$InvElectricitycapFee='null';}else{$InvElectricitycapFee=$ElectricitycapFee;}
            $Curtain_DrycleanFee = $_POST['CCRE_SRC_Curtain_DrycleanFee'];if($Curtain_DrycleanFee==''){$InvCurtain_DrycleanFee='null';}else{$InvCurtain_DrycleanFee=$Curtain_DrycleanFee;}
            $CheckOutCleanFee = $_POST['CCRE_SRC_CheckOutCleanFee'];if($CheckOutCleanFee==''){$InvCheckOutCleanFee='null';}else{$InvCheckOutCleanFee=$CheckOutCleanFee;}
            $DepositFee = $_POST['CCRE_SRC_DepositFee'];if($DepositFee==''){$InvDepositFee='null';}else{$InvDepositFee=$DepositFee;}
            $Rent = $_POST['CCRE_SRC_Rent'];
            $ProcessingFee = $_POST['CCRE_SRC_ProcessingFee'];if($ProcessingFee==''){$InvProcessingFee='null';}else{$InvProcessingFee=$ProcessingFee;}
            $Comments = $_POST['CCRE_SRC_Comments'];
            $waived = $_POST['CCRE_process_waived'];
            if ($waived == 'on') {
                $processwaived = 'X';
                $Invwaived='true';
            } else {
                $processwaived = '';
                $Invwaived='false';
            }
            $prorated = $_POST['CCRE_Rent_Prorated'];
            if ($prorated == 'on') {
                $Prorated = 'X';
                $InvProrated='true';
            } else {
                $Prorated = '';
                $InvProrated='false';
            }
            $CustomerSDdates = $_POST['CSRC_StartDate'];
            $CustomerEDdates = $_POST['CSRC_EndDate'];
            $Card = $_POST['CSRC_card'];
            $acesscard = '';
            $Accesscarddates = '';
            $Cont_cardno='';
            for ($i = 0; $i < count($Card); $i++) {
                if ($i == 0) {
                    $Cont_cardno=$Card[$i];
                    $acesscard = $Card[$i] . ',' . date('Y-m-d', strtotime($CustomerSDdates[$i]));
                    $Accesscarddates = $Card[$i] . ',' . date('Y-m-d', strtotime($CustomerSDdates[$i])) . ',' . date('Y-m-d', strtotime($CustomerEDdates[$i]));
                } else {
                    $acesscard = $acesscard . ',' . $Card[$i] . ',' . date('Y-m-d', strtotime($CustomerSDdates[$i]));
                    $Accesscarddates = $Accesscarddates . ',' . $Card[$i] . ',' . date('Y-m-d', strtotime($CustomerSDdates[$i])) . ',' . date('Y-m-d', strtotime($CustomerEDdates[$i]));
                }
            }
            $Customerid = $_POST['CCRE_SRC_customerid'];
            $Cedrecver=$_POST['CCRE_SRC_Recver'];
            $this->db->query('SET AUTOCOMMIT=0');
            $this->db->query('START TRANSACTION');
            $Update_query = "CALL SP_CUSTOMER_SEARCH_UPDATE('$Customerid','$FirstName','$Lastname','$CompanyName','$CompanyAddress',
           '$CompanyPostalCode','$Officeno',$Uint,$Cedrecver,'$RoomType','$S_starttime','$S_endtime','$E_starttime','$E_endtime',
           '$Leaseperiod','$Quoters','$processwaived','$Prorated','$NoticePeriod','$NoticePeriodDate','$Rent','$DepositFee','$ProcessingFee','$Fixedaircon_fee','$Quaterlyfee','$ElectricitycapFee','$CheckOutCleanFee','$Curtain_DrycleanFee',
           '$UserStamp','$Startdate','$Enddate','$Nationality','$Mobile','$IntlMobile','$Emailid','$PassportNo','$PassportDate','$DOB','$EpNo','$EPDate','$Comments','$acesscard','$Accesscarddates',@SUCCESS_FLAG,@CC_UPDATE_SAVEPOINT)";
            $this->db->query($Update_query);
//            return $Update_query;
            $Confirm_query = 'SELECT @SUCCESS_FLAG AS CONFIRM';
            $Confirm_result = $this->db->query($Confirm_query);
            $Confirm_Meessage =$Confirm_result->row()->CONFIRM;
            $Confirm_result_savepoint = $this->db->query('SELECT @CC_UPDATE_SAVEPOINT AS CCUPDATE_SAVEPOINT');
            $Confirm_savepoint =$Confirm_result_savepoint->row()->CCUPDATE_SAVEPOINT;
//            $this->db->trans_savepoint_release($Confirm_savepoint) ;
            //FILEUPLOAD
            $filetempname = $_FILES['CSRC_fileupload']['tmp_name'];
            $filename = $_FILES['CSRC_fileupload']['name'];
            $filename = $Uint . '-' . $Customerid . '-' . $FirstName . ' ' . $Lastname;
            $mimetype = 'application/pdf';
            $CCoption = $_POST['CCRE_SRC_Option'];
            $Sendmailid = $_POST['CCRE_SRC_MailList'];
            $Customerflag = $_POST['CCRE_SRC_Calflag'];
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $service = $this->Mdl_eilib_common_function->get_service_document();
            $Fileupload='';
            $UnitFolderrollback = '';
            $CustomerFolderback = '';
            if (($filetempname != '' && $Confirm_Meessage==1) || ($CCoption!=3 && $Confirm_Meessage==1))
            {
                $Targetfolderid=$this->Mdl_eilib_common_function->CUST_TargetFolderId();
                $UnitFolderid=$this->Mdl_eilib_common_function->getUnitfolderId($Uint,$Customerid);
                $unitcount=count($UnitFolderid);
                if($unitcount!=0 && $UnitFolderid[0]!='' && $UnitFolderid[1]!='')
                {
                    $UnitFolder= $UnitFolderid[0];
                    $CustomerFolder=$UnitFolderid[1];
                }
                else
                {
                    if ($unitcount == 0) {
                        $UnitFolder = $this->Mdl_eilib_common_function->Customer_FolderCreation($service, $Uint, 'PersonalDetails', $Targetfolderid);
                        $UnitFolderrollback = $UnitFolder;
                    } else {
                        $UnitFolder = $UnitFolderid[0];
                    }
                    if ($UnitFolder != '') {
                        $customerfoldername = $Customerid . '-' . $FirstName . ' ' . $Lastname;
                        $CustomerFolder = $this->Mdl_eilib_common_function->Customer_FolderCreation($service, $customerfoldername, 'PersonalDetails', $UnitFolder);
                        $CustomerFolderback = $CustomerFolder;
                    }
                }
                $Fileidinsertquery="CALL SP_INSERT_UPDATE_CUSTOMER_FILE_DIRECTORY($Uint,'$UnitFolder',$Customerid,'$CustomerFolder','$UserStamp',@SUCCESS_MESSAGE)";
                $result=$this->db->query($Fileidinsertquery);
                if($filetempname!='')
                {
                    $this->Mdl_eilib_common_function->Customer_FileUpload($service, $filename, 'PersonalDetails', $CustomerFolder, $mimetype, $filetempname);
                }
            }
            if ($Confirm_Meessage == 1)
            {
                if($Customerflag==1)
                {
                    $this->load->model('EILIB/Mdl_eilib_calender');
                    $calId = $this->Mdl_eilib_calender->GetEICalendarId();
                    $cal = $this->Mdl_eilib_calender->createCalendarService();
                    $calevents=$this->CAL_DEL_CREATE($Customerid);
                    $caldelresponse=$this->CUST_customercalenderdeletion_StartDate($calId,$cal,$calevents[0],$Customerid);
                    $calcreateresponse=$this->CUST_customercalendercreation_StartDate($service,$calId,$cal,$calevents[1],$Customerid,$FirstName,$Lastname,$Mobile,$IntlMobile,$Officeno,$Emailid,$Uint,$RoomType);
                }
                else
                {
                    $caldelresponse=1;
                    $calcreateresponse=1;
                }
                if (($CCoption == 4 || $CCoption == 5 || $CCoption == 6) && $caldelresponse==1 && $calcreateresponse==1)
                {
                    $Invoiceandcontractid = $this->Mdl_eilib_common_function->CUST_invoice_contractreplacetext();
                    $Docowner = $this->Mdl_eilib_common_function->CUST_documentowner($UserStamp);
                    $Emailtemplate = $this->Mdl_eilib_common_function->CUST_emailsubandmessages();
                    $mail_username = explode('@', $Sendmailid);
                    $Username = strtoupper($mail_username[0]);
                    $this->load->model('EILIB/Mdl_eilib_invoice_contract');
                    if ($CCoption == 4) {
                        $InvoiceId = $this->Mdl_eilib_invoice_contract->CUST_invoice($UserStamp, $service, $Uint, $Name, $CompanyName, $Invoiceandcontractid[9], $Invoiceandcontractid[0], $Invoiceandcontractid[1], $Rent, $ProcessingFee, $DepositFee, $Start_date, $End_date, $RoomType, $Leaseperiod, $InvProrated, $Sendmailid, $Docowner, 'CREATION', $Invwaived, $Customerid,$CustomerFolder);
                        if($InvoiceId[0]==1)
                        {
                            $subcontent = $Uint . '-' . $Name . '-' . $InvoiceId[3];
                            $Messcontent = $Uint . '-' . $Name;
                            $Emailsub = $Emailtemplate[2]['subject'];
                            $Messagebody = $Emailtemplate[2]['message'];
                            $Emailsub = str_replace('[UNIT NO- CUSTOMER_NAME - INVOICE_NO]', $subcontent, $Emailsub);
                            $Messagebody = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Messagebody);
                            $Messagebody = str_replace('[MAILID_USERNAME]', $Username, $Messagebody);
                            $Messagebody = $Messagebody . '<br><br>INVOICE :' . $InvoiceId[2];
                            $Displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('INVOICE');
                            $this->CustomerUpdatemailpart($Confirm_Meessage, $Emailsub, $Messagebody, $Displayname, $Sendmailid, $UserStamp);
                            $this->db->trans_savepoint_release($Confirm_savepoint) ;
                            echo $InvoiceId[0];
                            exit;
                        }
                        else
                        {
                            $this->db->trans_savepoint_rollback($Confirm_savepoint) ;
                            if($Customerflag==1) {
                                $calevents = $this->CAL_DEL_CREATE($Customerid);
                                $caldelresponse = $this->CUST_customercalenderdeletion_StartDate($calId, $cal, $calevents[0], $Customerid);
                                $getPersonalDetails = $this->getPersonalDetails($Customerid);
                                $calcreateresponse = $this->CUST_customercalendercreation_StartDate($service,$calId, $cal, $calevents[1], $Customerid, $getPersonalDetails[0]["CUSTOMER_FIRST_NAME"], $getPersonalDetails[0]["CUSTOMER_LAST_NAME"], $getPersonalDetails[0]["CPD_MOBILE"], $getPersonalDetails[0]["CPD_INTL_MOBILE"], $getPersonalDetails[0]["CCD_OFFICE_NO"], $getPersonalDetails[0]["CPD_EMAIL"], $Uint, $RoomType);

                            }
                            if ($UnitFolderrollback != '') {
                                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolderrollback);
                            }
                            if ($CustomerFolderback != '') {
                                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolderback);
                            }
                            echo $InvoiceId[3];
                            exit;
                        }
                    } else if ($CCoption == 5) {
                        $ContractId = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $Uint, $Start_date, $End_date, $CompanyName, $Name, $NoticePeriod, $PassportNo, $PassportDate, $EpNo, $EPDate, $NoticePeriodDate, $Leaseperiod, $Cont_cardno, $Rent, $InvQuaterlyfee, $InvFixedaircon_fee, $InvElectricitycapFee, $InvCurtain_DrycleanFee, $InvCheckOutCleanFee, $InvProcessingFee, $InvDepositFee, $Invwaived, $RoomType, $InvProrated, 'CREATION', $Sendmailid, $Docowner,$CustomerFolder);
                        if($ContractId[0]==1)
                        {
                            $Messcontent = $Uint . '-' . $Name;
                            $Emailsub = $Emailtemplate[1]['subject'];
                            $Messagebody = $Emailtemplate[1]['message'];
                            $Emailsub = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Emailsub);
                            $Messagebody = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Messagebody);
                            $Messagebody = str_replace('[MAILID_USERNAME]', $Username, $Messagebody);
                            $Messagebody = $Messagebody . '<br><br>CONTRACT :' . $ContractId[2];
                            $Displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('CONTRACT');
                            $this->CustomerUpdatemailpart($Confirm_Meessage, $Emailsub, $Messagebody, $Displayname, $Sendmailid, $UserStamp);
                            $this->db->trans_savepoint_release($Confirm_savepoint) ;
                            echo $ContractId[0];
                            exit;
                        }else{
                            $this->db->trans_savepoint_rollback($Confirm_savepoint) ;
                            if($Customerflag==1) {
                                $calevents = $this->CAL_DEL_CREATE($Customerid);
                                $caldelresponse = $this->CUST_customercalenderdeletion_StartDate($calId, $cal, $calevents[0], $Customerid);
                                $getPersonalDetails = $this->getPersonalDetails($Customerid);
                                $calcreateresponse = $this->CUST_customercalendercreation_StartDate($service,$calId, $cal, $calevents[1], $Customerid, $getPersonalDetails[0]["CUSTOMER_FIRST_NAME"], $getPersonalDetails[0]["CUSTOMER_LAST_NAME"], $getPersonalDetails[0]["CPD_MOBILE"], $getPersonalDetails[0]["CPD_INTL_MOBILE"], $getPersonalDetails[0]["CCD_OFFICE_NO"], $getPersonalDetails[0]["CPD_EMAIL"], $Uint, $RoomType);
                            }
                            if ($UnitFolderrollback != '') {
                                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolderrollback);
                            }
                            if ($CustomerFolderback != '') {
                                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolderback);
                            }
                            echo $ContractId[3];
                            exit;
                        }
                    } else if ($CCoption == 6) {
                        $InvoiceId = $this->Mdl_eilib_invoice_contract->CUST_invoice($UserStamp, $service, $Uint, $Name, $CompanyName, $Invoiceandcontractid[9], $Invoiceandcontractid[0], $Invoiceandcontractid[1], $Rent, $ProcessingFee, $DepositFee, $Start_date, $End_date, $RoomType, $Leaseperiod, $InvProrated, $Sendmailid, $Docowner, 'CREATION', $Invwaived, $Customerid,$CustomerFolder);
                        $ContractId = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $Uint, $Start_date, $End_date, $CompanyName, $Name, $NoticePeriod, $PassportNo, $PassportDate, $EpNo, $EPDate, $NoticePeriodDate, $Leaseperiod, $Cont_cardno, $Rent, $InvQuaterlyfee, $InvFixedaircon_fee, $InvElectricitycapFee, $InvCurtain_DrycleanFee, $InvCheckOutCleanFee, $InvProcessingFee, $InvDepositFee, $Invwaived, $RoomType, $InvProrated, 'CREATION', $Sendmailid, $Docowner,$CustomerFolder);
                        if($InvoiceId[0]==1 && $ContractId[0]==1)
                        {
                            $subcontent = $Uint . '-' . $Name . '-' . $InvoiceId[3];
                            $Messcontent = $Uint . '-' . $Name;
                            $Emailsub = $Emailtemplate[0]['subject'];
                            $Messagebody = $Emailtemplate[0]['message'];
                            $Emailsub = str_replace('[UNIT NO - CUSTOMER NAME - INVOICE NO]', $subcontent, $Emailsub);
                            $Messagebody = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Messagebody);
                            $Messagebody = str_replace('[MAILID_USERNAME]', $Username, $Messagebody);
                            $Messagebody = $Messagebody . '<br><br>INVOICE :' . $InvoiceId[2];
                            $Messagebody = $Messagebody . '<br><br>CONTRACT :' . $ContractId[2];
                            $Displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('INVOICE_N_CONTRACT');
                            $this->CustomerUpdatemailpart($Confirm_Meessage, $Emailsub, $Messagebody, $Displayname, $Sendmailid, $UserStamp);
                            $this->db->trans_savepoint_release($Confirm_savepoint) ;
                            echo $InvoiceId[0];
                            exit;
                        }else{
                            $this->db->trans_savepoint_rollback($Confirm_savepoint) ;
                            if($Customerflag==1) {
                                $calevents = $this->CAL_DEL_CREATE($Customerid);
                                $caldelresponse = $this->CUST_customercalenderdeletion_StartDate($calId, $cal, $calevents[0], $Customerid);
                                $getPersonalDetails = $this->getPersonalDetails($Customerid);
                                $calcreateresponse = $this->CUST_customercalendercreation_StartDate($service,$calId, $cal, $calevents[1], $Customerid, $getPersonalDetails[0]["CUSTOMER_FIRST_NAME"], $getPersonalDetails[0]["CUSTOMER_LAST_NAME"], $getPersonalDetails[0]["CPD_MOBILE"], $getPersonalDetails[0]["CPD_INTL_MOBILE"], $getPersonalDetails[0]["CCD_OFFICE_NO"], $getPersonalDetails[0]["CPD_EMAIL"], $Uint, $RoomType);
                            }
                            if ($UnitFolderrollback != '') {
                                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolderrollback);
                            }
                            if ($CustomerFolderback != '') {
                                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolderback);
                            }
                            if($InvoiceId[0] == 0){
                                echo $InvoiceId[3];
                                exit;}
                            if($ContractId[0] == 0){
                                echo $ContractId[3];
                                exit;}exit;
                        }
                    }
                }
                else
                {
                    if ($caldelresponse==1 && $calcreateresponse==1) {
                        $this->db->trans_savepoint_release($Confirm_savepoint) ;
                        echo $Confirm_Meessage;
                        exit;
                    } else {
                        $this->db->trans_savepoint_rollback($Confirm_savepoint);
                        if($Customerflag==1) {
                            $calevents = $this->CAL_DEL_CREATE($Customerid);
                            $caldelresponse = $this->CUST_customercalenderdeletion_StartDate($calId, $cal, $calevents[0], $Customerid);
                            $getPersonalDetails = $this->getPersonalDetails($Customerid);
                            $calcreateresponse = $this->CUST_customercalendercreation_StartDate($service,$calId, $cal, $calevents[1], $Customerid, $getPersonalDetails[0]["CUSTOMER_FIRST_NAME"], $getPersonalDetails[0]["CUSTOMER_LAST_NAME"], $getPersonalDetails[0]["CPD_MOBILE"], $getPersonalDetails[0]["CPD_INTL_MOBILE"], $getPersonalDetails[0]["CCD_OFFICE_NO"], $getPersonalDetails[0]["CPD_EMAIL"], $Uint, $RoomType);
                        }
                        echo 0;
                        exit;
                    }

                }
            }
            else
            {
                $this->db->trans_savepoint_rollback($Confirm_savepoint);
                if ($UnitFolderrollback != '') {
                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolderrollback);
                }
                if ($CustomerFolderback != '') {
                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolderback);
                }
                echo 0;
                exit;
            }
        }
        catch (Exception $e)
        {
            $this->db->trans_savepoint_rollback($Confirm_savepoint);
            $calevents=$this->CAL_DEL_CREATE($Customerid);
            if($Customerflag==1) {
                $calevents=$this->CAL_DEL_CREATE($Customerid);
                $caldelresponse = $this->CUST_customercalenderdeletion_StartDate($calId, $cal, $calevents[0], $Customerid);
                $getPersonalDetails=$this->getPersonalDetails($Customerid);
                $calcreateresponse = $this->CUST_customercalendercreation_StartDate($calId, $cal, $calevents[1], $Customerid, $getPersonalDetails[0]["CUSTOMER_FIRST_NAME"], $getPersonalDetails[0]["CUSTOMER_LAST_NAME"], $getPersonalDetails[0]["CPD_MOBILE"], $getPersonalDetails[0]["CPD_INTL_MOBILE"], $getPersonalDetails[0]["CCD_OFFICE_NO"], $getPersonalDetails[0]["CPD_EMAIL"], $Uint, $RoomType);
            }
            if ($UnitFolderrollback != '') {
                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolderrollback);
            }
            if ($CustomerFolderback != '') {
                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolderback);
            }
            return 0;
            exit;
        }
    }
    public function CustomerUpdatemailpart($Confirm_Meessage,$Emailsub,$Messagebody,$Displayname,$Docowner,$UserStamp)
    {
        $message1 = new Message();
        $message1->setSender($Displayname.'<'.$UserStamp.'>');
        $message1->addTo($Docowner);
        $message1->setSubject($Emailsub);
        $message1->setHtmlBody($Messagebody);
        $message1->send();
        echo $Confirm_Meessage;
        exit;
    }
//    public function CustomerUpdatemailpart($Confirm_Meessage,$Emailsub,$Messagebody,$Displayname,$Sendmailid,$UserStamp)
//    {
//        $mail = new PHPMailer;
//        $mail->isSMTP();
//        $mail->Host = 'smtp.gmail.com';
//        $mail->SMTPAuth = true;
//        $mail->Username = 'safiyullah84@gmail.com';
//        $mail->Password = 'safi984151';
//        $mail->SMTPSecure = 'tls';
//        $mail->Port = 587;
//        $mail->FromName = $Displayname;
//        $mail->addAddress($Sendmailid);
//        $mail->WordWrap = 50;
//        $mail->isHTML(true);
//        $mail->Subject = $Emailsub;
//        $mail->Body = $Messagebody;
//        $mail->Send();
//        echo $Confirm_Meessage;
//        exit;
//    }
    public function CAL_DEL_CREATE($CSRC_customerid)
    {
        $Selectquery="CALL SP_CUSTOMER_MIN_MAX_RV('$CSRC_customerid',@MIN_LP,@MAX_LP)";
        $this->db->query($Selectquery);
        $outparm_result = $this->db->query('SELECT @MIN_LP,@MAX_LP');
        foreach ($outparm_result->result_array() as $key=>$val)
        {
            $CSRC_MINRV=$val['@MIN_LP'];if($CSRC_MINRV==null){$CSRC_MINRV=1;}
            $CSRC_MAXRV=$val['@MAX_LP'];
        }
        $CSRC_caldetailsquery="SELECT C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CED.CED_REC_VER,CTD.CLP_GUEST_CARD,CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,CTD.CLP_PRETERMINATE_DATE,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CCD.CCD_OFFICE_NO,CPD.CPD_EMAIL,U.UNIT_NO,URTD.URTD_ROOM_TYPE,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME, CTPD.CTP_DATA AS CED_ED_ETIME FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE CTPA ON CED.CED_SD_STIME = CTPA.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPB ON CED.CED_SD_ETIME = CTPB.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPC ON CED.CED_ED_STIME = CTPC.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPD ON CED.CED_ED_ETIME = CTPD.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CTD,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U,CUSTOMER C WHERE  CED.UNIT_ID=U.UNIT_ID AND CED.CUSTOMER_ID=".$CSRC_customerid." AND (CTD.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CTD.CED_REC_VER) AND (CTD.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS  NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)  AND (C.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CTD.CUSTOMER_ID=C.CUSTOMER_ID) AND (CED.CED_REC_VER BETWEEN ".$CSRC_MINRV." AND ".$CSRC_MAXRV.") AND CTD.CLP_GUEST_CARD IS NULL ORDER BY CED.CED_REC_VER, CTD.CLP_GUEST_CARD ASC";
        $CSRC_caldetailsresult=$this->db->query($CSRC_caldetailsquery);
        $calevents_array=array();
        foreach ($CSRC_caldetailsresult->result_array() as $key=>$val)
        {
            $CSRC_calunit=$val['UNIT_NO'];
            $CSRC_calsddate=$val['CLP_STARTDATE'];
            $CSRC_caleddate=$val['CLP_ENDDATE'];
            $CSRC_cal_ptddate=$val['CLP_PRETERMINATE_DATE'];
            $CSRC_SD_start_time_in=$val['CED_SD_STIME'];
            $CSRC_SD_start_time_out=$val['CED_SD_ETIME'];
            $CSRC_ED_end_time_in=$val['CED_ED_STIME'];
            $CSRC_ED_end_time_out=$val['CED_ED_ETIME'];
            $CSRC_calroomtype=$val['URTD_ROOM_TYPE'];
            if($CSRC_cal_ptddate!=null)
            {
                $CSRC_caleddate=$CSRC_cal_ptddate;
            }
            $startdateevents=$CSRC_calunit.'!~'.$CSRC_calroomtype.'!~'.$CSRC_calsddate.'!~'.$CSRC_SD_start_time_in.'!~'.$CSRC_SD_start_time_out;
            $enddateevents=$CSRC_calunit.'!~'.$CSRC_calroomtype.'!~'.$CSRC_caleddate.'!~'.$CSRC_ED_end_time_in.'!~'.$CSRC_ED_end_time_out;
            array_push($calevents_array,$startdateevents);
            array_push($calevents_array,$enddateevents);
        }
        $DELETE_finalcaleventsarray=array();
        $CREATE_finalcaleventsarray=array();
        for($j=0;$j<count($calevents_array);$j++)
        {
            $c_eventdetails=$calevents_array[$j];
            $eventdetails=explode('!~',$c_eventdetails);
            if($j==0 || $j==count($calevents_array)-1)
            {
                if($j==0)
                {
                    $roomstatus='';
                    $eventstatus="CHECKIN";
                    $createevents=$eventdetails[0].','.$eventdetails[1].','.$eventdetails[2].','.$eventdetails[3].','.$eventdetails[4].','.$eventstatus;
                    $deleteevents=$eventdetails[2].','.$eventdetails[3].','.$eventdetails[4];
                    array_push($CREATE_finalcaleventsarray,$createevents);
                    array_push($DELETE_finalcaleventsarray,$deleteevents);
                }
                else
                {
                    $roomstatus='';
                    $eventstatus="CHECKOUT";
                    $createevents=$eventdetails[0].','.$eventdetails[1].','.$eventdetails[2].','.$eventdetails[3].','.$eventdetails[4].','.$eventstatus;
                    $deleteevents=$eventdetails[2].','.$eventdetails[3].','.$eventdetails[4];
                    array_push($CREATE_finalcaleventsarray,$createevents);
                    array_push($DELETE_finalcaleventsarray,$deleteevents);
                }
            }
            else
            {
                $p_eventdetails=$calevents_array[$j-1];
                $preeventdetails=explode('!~',$p_eventdetails);
                if($preeventdetails[0]==$eventdetails[0] && $preeventdetails[1]!=$eventdetails[1])
                {
                    $roomstatus='DIFF RM';
                    $eventstatus="CHECKIN";
                    $createevents=$eventdetails[0].','.$eventdetails[1].','.$eventdetails[2].','.$eventdetails[3].','.$eventdetails[4].','.$eventstatus;
                    $deleteevents=$eventdetails[2].','.$eventdetails[3].','.$eventdetails[4];
                    array_push($CREATE_finalcaleventsarray,$createevents);
                    array_push($DELETE_finalcaleventsarray,$deleteevents);
                }
                if($preeventdetails[0]!=$eventdetails[0])
                {
                    $roomstatus='DIFF UNIT';
                    $eventstatus="CHECKIN";
                    $createevents=$eventdetails[0].','.$eventdetails[1].','.$eventdetails[2].','.$eventdetails[3].','.$eventdetails[4].','.$eventstatus;
                    $deleteevents=$eventdetails[2].','.$eventdetails[3].','.$eventdetails[4];
                    array_push($CREATE_finalcaleventsarray,$createevents);
                    array_push($DELETE_finalcaleventsarray,$deleteevents);
                }
            }
        }
        $returnevents=array($DELETE_finalcaleventsarray,$CREATE_finalcaleventsarray);
        return $returnevents;
    }
    public function CalenderTime_Convertion($startdate,$startdate_starttime,$startdate_endtime){
        if($startdate!=''&&$startdate_starttime!=''&&$startdate_endtime!='') {
            $splitStart = explode(':', $startdate_starttime);
            $startdate_starttime = $splitStart[0] . ':' . $splitStart[1];
            $splitEnd = explode(':', $startdate_endtime);
            $startdate_endtime = $splitEnd[0] . ':' . $splitEnd[1];
        }
        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime($startdate.'T'.$startdate_starttime.':00.000+08:00');
        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($startdate.'T'.$startdate_endtime.':00.000+08:00');
        return array($start,$end);
    }
    public function  CUST_customercalendercreation_StartDate($servicedoc,$calId,$calPrimary,$calevents,$custid,$firstname,$lastname,$mobile,$intmobile,$office,$customermailid,$unit,$unitrmtype)
    {
        try{
            $folderIdCustomer=$this->Mdl_eilib_calender->getcustomerfileid($servicedoc,$custid);
            for($k=0;$k<count($calevents);$k++)
            {
                $attachments=[];
                $Events=explode(',',$calevents[$k]);
                if($Events[5]=="CHECKIN"){
                    for($j=0;$j<count($folderIdCustomer)&&count($folderIdCustomer)>0;$j++){
                        $servicedoc= $this->Mdl_eilib_common_function->get_service_document();
                        $file = $servicedoc->files->get($folderIdCustomer[$j]);
                        $attachments[]= array(
                            'fileUrl' => $file->alternateLink,
                            'mimeType' => $file->mimeType,
                            'title' => $file->title
                        );}}
                $initialsdate = $Events[2];
                $calendername = $firstname . ' ' . $lastname;
                $contactno = "";
                $contactaddr = "";
                if ($mobile != null) {
                    $contactno = $mobile;
                } else if ($intmobile != null) {
                    $contactno = $intmobile;
                } else if ($office != null) {
                    $contactno = $office;
                }
                if ($contactno != null && $contactno != "") {
                    $contactaddr = $custid . " " . "EMAIL :" . $customermailid . ",CONTACT NO :" . $contactno;
                } else {
                    $contactaddr = $custid . " " . "EMAIL :" . $customermailid;
                }
                if ($Events[1] != "") {
                    $details = $Events[0] . " " . $calendername . " " . $Events[1] . " " . $Events[5];
                } else {
                    $details = $Events[0] . " " . $calendername . " " . $Events[5];
                }
                $details1 = $Events[0] . " " . $Events[1];
                if ($initialsdate != "") {
                    $event = new Google_Service_Calendar_Event();
                    $startevents = $this->CalenderTime_Convertion($Events[2], $Events[3], $Events[4]);
                    $event->setStart($startevents[0]);
                    $event->setEnd($startevents[1]);
                    $event->setDescription($contactaddr);
                    $event->setLocation($details1);
                    $event->setSummary($details);
                    if(count($folderIdCustomer)>0 && $Events[5]=="CHECKIN") {
                        $event->setAttachments($attachments);
                        $createdEvent = $calPrimary->events->insert($calId, $event,array('supportsAttachments' => TRUE)); // to create a event
                    }else{
                        $createdEvent = $calPrimary->events->insert($calId, $event);
                    }
                }
            }
            return 1;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
    ///FUNCTION TO DELETE CALENDER EVENTS
    public function CUST_customercalenderdeletion_StartDate($calId,$calPrimary,$calevents,$custid)
    {
        try{
            for($k=0;$k<count($calevents);$k++)
            {
                $Events = explode(',', $calevents[$k]);
                $optDate = array('timeMax' => $Events[0] . 'T' . $Events[2] . '+08:00', 'timeMin' => $Events[0] . 'T' . $Events[1] . '+08:00');
                $eventsCheckOut = $calPrimary->events->listEvents($calId, $optDate);
                foreach ($eventsCheckOut->getItems() as $event) {
                    if (intval(explode(' ', $event->getDescription())[0]) == $custid)
                    {
                        $calPrimary->events->delete($calId, $event->getId());
                    }
                }
            }
            return 1;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function getCustomerRecordDelete($Customerid,$UserStamp)
    {
        $this->load->library('Google');
        $this->load->model('EILIB/Mdl_eilib_calender');
        $cal = $this->Mdl_eilib_calender->createCalendarService();
        $calender_deletequery = "SELECT CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME, CTPD.CTP_DATA AS CED_ED_ETIME FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE CTPA ON CED.CED_SD_STIME = CTPA.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPB ON CED.CED_SD_ETIME = CTPB.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPC ON CED.CED_ED_STIME = CTPC.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPD ON CED.CED_ED_ETIME = CTPD.CTP_ID,CUSTOMER_LP_DETAILS CTD WHERE CED.CUSTOMER_ID=CTD.CUSTOMER_ID AND CED.CUSTOMER_ID=" . $Customerid;
        $calender_deleteresult = $this->db->query($calender_deletequery);
        foreach ($calender_deleteresult->result_array() as $key => $value) {
            $CSRC_oldstartdate = $value['CLP_STARTDATE'];
            $CSRC_oldsstarttime = $value['CED_SD_STIME'];
            $CSRC_oldsendtime = $value['CED_SD_ETIME'];
            $CSRC_oldenddate = $value['CLP_ENDDATE'];
            $CSRC_oldestarttime = $value['CED_ED_STIME'];
            $CSRC_oldeendtime = $value['CED_ED_ETIME'];
        }
        $customersearch_tick_query = "CALL SP_CUSTOMER_SEARCH_TICKLER_DELETION('$Customerid','$UserStamp',@CUSTOMER_SEARCH_DELETION,@FLAG,@SAVE_POINT_CUST_DELETE)";
        $this->db->query($customersearch_tick_query);
        $customerdelete_getresult = $this->db->query("SELECT @CUSTOMER_SEARCH_DELETION,@FLAG,@SAVE_POINT_CUST_DELETE");
        foreach ($customerdelete_getresult->result_array() as $key => $val) {
            $customerdeletion_temptable = $val['@CUSTOMER_SEARCH_DELETION'];
            $customerdeletion_flag = $val['@FLAG'];
            $customerdeletion_savepoint = $val['@SAVE_POINT_CUST_DELETE'];
        }
        $this->db->query('DROP TABLE IF EXISTS ' .$customerdeletion_temptable);
        if($customerdeletion_flag == 1)
        {
            $Calresponse = $this->Mdl_eilib_calender->CUST_customercalenderdeletion($cal, $Customerid, $CSRC_oldstartdate, $CSRC_oldsstarttime, $CSRC_oldsendtime, $CSRC_oldenddate, $CSRC_oldestarttime, $CSRC_oldeendtime,' ');
        }
        else
        {
            $this->db->trans_savepoint_rollback($customerdeletion_savepoint);
        }
        $this->db->trans_savepoint_release($customerdeletion_savepoint) ;
        return $Calresponse;
    }
}

