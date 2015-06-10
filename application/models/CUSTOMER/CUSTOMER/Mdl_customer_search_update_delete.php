<?php
error_reporting(0);
class Mdl_customer_search_update_delete extends CI_Model
{
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
    public function SelectCustomerResults($customerid,$leaseperiod)
    {
        $temptablequery="CALL SP_CUSTOMER_SEARCH_TEMP_FEE_DETAIL('$customerid','kumar.r@ssomens.com',@CUSTOMER_SEARCH_FEE_TEMPTBLNAME)";
        $this->db->query($temptablequery);
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
    public function getRoomtypeData($roomtypeid,$lp)
    {
        $this->db->select('URTD.URTD_ROOM_TYPE');
        $this->db->from('UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER_ENTRY_DETAILS CED');
        $this->db->where('CED.UASD_ID='.$roomtypeid.' AND UASD.UASD_ID=CED.UASD_ID AND(UASD.URTD_ID=URTD.URTD_ID) and CED.CED_REC_VER='.$lp);
        $query = $this->db->get();
        return $query->result();
    }
    public function getSearchRecverdetails($unit,$customerid,$LP)
    {
        $temptablequery="CALL SP_CUSTOMER_SEARCH_PREVIOUS_RECVER_START_ENADATE('$customerid','$LP','$unit','kumar.r@ssomens.com',@CUSTOMER_SEARCH_PREVIOUS_RECVER_TMPTBL)";
        $this->db->query($temptablequery);
        $outparm_query = 'SELECT @CUSTOMER_SEARCH_PREVIOUS_RECVER_TMPTBL AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
        $CSRC_customerflextable_query ="SELECT *FROM ".$csrc_tablename;
        $resultset=$this->db->query($CSRC_customerflextable_query);
        $this->db->query('DROP TABLE IF EXISTS '.$csrc_tablename);
        return $resultset->result();;
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
            $S_starttime = $_POST['CCRE_SRC_SDStarttime'];
            $S_endtime = $_POST['CCRE_SRC_SDEndtime'];
            $Enddate = date('Y-m-d', strtotime($_POST['CCRE_SRC_Enddate']));
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
            for ($i = 0; $i < count($Card); $i++) {
                if ($i == 0) {
                    $acesscard = $Card[$i] . ',' . date('Y-m-d', strtotime($CustomerSDdates[$i]));
                    $Accesscarddates = $Card[$i] . ',' . date('Y-m-d', strtotime($CustomerSDdates[$i])) . ',' . date('Y-m-d', strtotime($CustomerEDdates[$i]));
                } else {
                    $acesscard = $acesscard . ',' . $Card[$i] . ',' . date('Y-m-d', strtotime($CustomerSDdates[$i]));
                    $Accesscarddates = $Accesscarddates . ',' . $Card[$i] . ',' . date('Y-m-d', strtotime($CustomerSDdates[$i])) . ',' . date('Y-m-d', strtotime($CustomerEDdates[$i]));
                }
            }
            $Customerid = $_POST['CCRE_SRC_customerid'];
            $Cedrecver=$_POST['CCRE_SRC_Recver'];
            $Update_query = "CALL SP_CUSTOMER_SEARCH_UPDATE('$Customerid','$FirstName','$Lastname','$CompanyName','$CompanyAddress',
           '$CompanyPostalCode','$Officeno',$Uint,$Cedrecver,'$RoomType','$S_starttime','$S_endtime','$E_starttime','$E_endtime',
           '$Leaseperiod','$Quoters','$processwaived','$Prorated','$NoticePeriod','$NoticePeriodDate','$Rent','$DepositFee','$ProcessingFee','$Fixedaircon_fee','$Quaterlyfee','$ElectricitycapFee','$CheckOutCleanFee','$Curtain_DrycleanFee',
           '$UserStamp','$Startdate','$Enddate','$Nationality','$Mobile','$IntlMobile','$Emailid','$PassportNo','$PassportDate','$DOB','$EpNo','$EPDate','$Comments','$acesscard','$Accesscarddates',@SUCCESS_FLAG)";
            $this->db->query($Update_query);
            $Confirm_query = 'SELECT @SUCCESS_FLAG AS CONFIRM';
            $Confirm_result = $this->db->query($Confirm_query);
            $Confirm_Meessage =$Confirm_result->row()->CONFIRM;
            //FILEUPLOAD
            $filetempname = $_FILES['CC_fileupload']['tmp_name'];
            $filename = $_FILES['CC_fileupload']['name'];
            $filename = $Uint . '-' . $Customerid . '-' . $FirstName . ' ' . $Lastname;
            $mimetype = 'application/pdf';
            $CCoption = $_POST['CCRE_SRC_Option'];
            $Sendmailid = $_POST['CCRE_SRC_MailList'];
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $service = $this->Mdl_eilib_common_function->get_service_document();
            if ($filetempname != '' && $Confirm_Meessage == 1) {
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
                    } else {
                        $UnitFolder = $UnitFolderid[0];
                    }
                    if ($UnitFolder != '') {
                        $customerfoldername = $Customerid . '-' . $FirstName . ' ' . $Lastname;
                        $CustomerFolder = $this->Mdl_eilib_common_function->Customer_FolderCreation($service, $customerfoldername, 'PersonalDetails', $UnitFolder);
                    }
                }

                $Fileidinsertquery="CALL SP_INSERT_UPDATE_CUSTOMER_FILE_DIRECTORY($Uint,'$UnitFolder',$Customerid,'$CustomerFolder','$UserStamp',@SUCCESS_MESSAGE)";
                $result=$this->db->query($Fileidinsertquery);
                $this->Mdl_eilib_common_function->Customer_FileUpload($service, $filename, 'PersonalDetails', $CustomerFolder, $mimetype, $filetempname);
            }
            if ($Confirm_Meessage == 1) {
                $this->load->model('EILIB/Mdl_eilib_calender');
                $cal = $this->Mdl_eilib_calender->createCalendarService();
//                $this->Mdl_eilib_calender->CUST_customercalendercreation($cal, $Customerid, $StartDate, $S_starttime, $S_endtime, $EndDate, $E_starttime, $E_endtime, $FirstName, $Lastname, $Mobile, $IntlMobile, $Officeno, $Emailid, $Uint, $RoomType, '');
                if ($CCoption == 4 || $CCoption == 5 || $CCoption == 6) {
                    $Invoiceandcontractid = $this->Mdl_eilib_common_function->CUST_invoice_contractreplacetext();
                    $Docowner = $this->Mdl_eilib_common_function->CUST_documentowner($UserStamp);
                    $Emailtemplate = $this->Mdl_eilib_common_function->CUST_emailsubandmessages();
                    $mail_username = explode('@', $Sendmailid);
                    $Username = strtoupper($mail_username[0]);
                    $this->load->model('EILIB/Mdl_eilib_invoice_contract');
                    if ($CCoption == 4) {
                        $InvoiceId = $this->Mdl_eilib_invoice_contract->CUST_invoice($UserStamp, $service, $Uint, $Name, $CompanyName, $Invoiceandcontractid[9], $Invoiceandcontractid[0], $Invoiceandcontractid[1], $Rent, $ProcessingFee, $DepositFee, $StartDate, $EndDate, $RoomType, $Leaseperiod, $InvProrated, $Sendmailid, $Docowner, 'CREATION', $Invwaived, $Customerid);
                        $subcontent = $Uint . '-' . $Name . '-' . $InvoiceId[3];
                        $Messcontent = $Uint . '-' . $Name;
                        $Emailsub = $Emailtemplate[2]['subject'];
                        $Messagebody = $Emailtemplate[2]['message'];
                        $Emailsub = str_replace('[UNIT NO- CUSTOMER_NAME - INVOICE_NO]', $subcontent, $Emailsub);
                        $Messagebody = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Messagebody);
                        $Messagebody = str_replace('[MAILID_USERNAME]', $Username, $Messagebody);
                        $Messagebody = $Messagebody . '<br><br>INVOICE :' . $InvoiceId[2];
                        $Displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('INVOICE');
                        $ReturnValue = array($Confirm_Meessage,$Emailsub, $Messagebody, $Displayname);
                        return $ReturnValue;
                    } else if ($CCoption == 5) {
                        $ContractId = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $Uint, $Startdate, $Enddate, $CompanyName, $Name, $NoticePeriod, $PassportNo, $PassportDate, $EpNo, $EPDate, $NoticePeriodDate, $Leaseperiod, $Cont_cardno, $Rent, $InvQuaterlyfee, $InvFixedaircon_fee, $InvElectricitycapFee, $InvCurtain_DrycleanFee, $InvCheckOutCleanFee, $InvProcessingFee, $InvDepositFee, $Invwaived, $RoomType, $InvProrated, 'CREATION', $Sendmailid, $Docowner);
                        $Messcontent = $Uint . '-' . $Name;
                        $Emailsub = $Emailtemplate[1]['subject'];
                        $Messagebody = $Emailtemplate[1]['message'];
                        $Emailsub = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Emailsub);
                        $Messagebody = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Messagebody);
                        $Messagebody = str_replace('[MAILID_USERNAME]', $Username, $Messagebody);
                        $Messagebody = $Messagebody . '<br><br>CONTRACT :' . $ContractId[2];
                        $Displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('CONTRACT');
                        $ReturnValue = array($Confirm_Meessage,$Emailsub, $Messagebody, $Displayname);
                        return $ReturnValue;
                    } else if ($CCoption == 6) {
                        $InvoiceId = $this->Mdl_eilib_invoice_contract->CUST_invoice($UserStamp, $service, $Uint, $Name, $CompanyName, $Invoiceandcontractid[9], $Invoiceandcontractid[0], $Invoiceandcontractid[1], $Rent, $ProcessingFee, $DepositFee, $StartDate, $EndDate, $RoomType, $Leaseperiod, $InvProrated, $Sendmailid, $Docowner, 'CREATION', $Invwaived, $Customerid);
                        $ContractId = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $Uint, $Startdate, $Enddate, $CompanyName, $Name, $NoticePeriod, $PassportNo, $PassportDate, $EpNo, $EPDate, $NoticePeriodDate, $Leaseperiod, $Cont_cardno, $Rent, $InvQuaterlyfee, $InvFixedaircon_fee, $InvElectricitycapFee, $InvCurtain_DrycleanFee, $InvCheckOutCleanFee, $InvProcessingFee, $InvDepositFee, $Invwaived, $RoomType, $InvProrated, 'CREATION', $Sendmailid, $Docowner);
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
                        $ReturnValue = array($Confirm_Meessage,$Emailsub, $Messagebody, $Displayname);
                        return $ReturnValue;
                    }
                    $this->db->query('COMMIT');
                }
                else
                {
                    $this->db->query('COMMIT');
                    $ReturnValue = array($Confirm_Meessage);
                    return $ReturnValue;
                }
            } else {
                $ReturnValue = array($Confirm_Meessage);
                return $ReturnValue;
            }
        }
        catch (Exception $e)
        {
            $this->db->query('ROLLBACK');
            $ReturnValue = array($e->getMessage());
            return $ReturnValue;

        }
     }
}