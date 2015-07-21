<?php
error_reporting(0);
//require 'application/PHPMailer-master/PHPMailerAutoload.php';
require_once 'google/appengine/api/mail/Message.php';
use \google\appengine\api\mail\Message;
class Mdl_Customer_Extension extends CI_Model{
    //FUNCTION TO GET ALL EXTENSION UNIT NOS
    public  function CEXTN_getExtnUnitNo()
    {
        $CEXTN_extndtsarray =array();
        $this->db->select("UNIT_NO");
        $this->db->from('VW_EXTENSION_CUSTOMER');
        $this->db->order_by('UNIT_NO');
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $CEXTN_extndtsarray[]=$row['UNIT_NO'];
        }
        return $CEXTN_extndtsarray;
    }
    //FUNCTION TO GET CUSTOMER NAME N CUSTOMER ID
    public function CEXTN_getCustomerNameId($CEXTN_lb_unitno){
        $CEXTN_extndtsarray =array();
        $CEXTN_customeridarray =array();
        $CEXTN_customernamearray=array();
        $this->db->select("CUSTOMER_ID,CUSTOMERNAME");
        $this->db->from('VW_EXTENSION_CUSTOMER');
        $this->db->where('UNIT_NO=', $CEXTN_lb_unitno);
        $this->db->order_by('CUSTOMERNAME');
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $CEXTN_customeridarray[]=$row['CUSTOMER_ID'];
            $CEXTN_customernamearray[]=$row['CUSTOMERNAME'];
        }
        $CEXTN_extndtsarray=array($CEXTN_customeridarray,$CEXTN_customernamearray);
        return $CEXTN_extndtsarray;
    }
    //FUNCTION TO GET CUSTOMER DETAILS FOR THE SELECTED CUSTOMER ID
    public function CEXTN_getCustomerdtls($CEXTN_custid,$CEXTN_unitno,$UserStamp){
        $CEXTN_feedtl_CallQuery="CALL SP_CUSTOMER_EXTENSION_TEMP_FEE_DETAIL($CEXTN_custid,'$UserStamp',@EXTN_FEETMPTBLNAM)";
        $this->db->query($CEXTN_feedtl_CallQuery);
        $outparm_query = 'SELECT @EXTN_FEETMPTBLNAM AS CEXTN_FEE_TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $CExtntblname=$outparm_result->row()->CEXTN_FEE_TEMP_TABLE;
        //READ CUST MIN RV
        $CEXTN_rv_CallQuery="CALL SP_CUSTOMER_MIN_MAX_RV($CEXTN_custid,@MIN_LP,@MAX_LP)";
        $this->db->query($CEXTN_rv_CallQuery);
        $CEXTN_minrv_query = 'SELECT @MIN_LP as MIN_LP';
        $CEXTN_minrv_result= $this->db->query($CEXTN_minrv_query);
        $CExtnminlpval=$CEXTN_minrv_result->row()->MIN_LP;
        $this->db->select('CED.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CCD.CCD_COMPANY_NAME,CCD.CCD_COMPANY_ADDR,CCD.CCD_POSTAL_CODE,CPD.CPD_EMAIL,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CCD.CCD_OFFICE_NO,CPD.CPD_DOB,NC.NC_DATA,CPD.CPD_PASSPORT_NO,CPD.CPD_PASSPORT_DATE,CPD.CPD_EP_NO,CPD.CPD_EP_DATE,URTD.URTD_ROOM_TYPE,UASD.UASD_ACCESS_CARD,CTD.CLP_ENDDATE,EF.CC_AIRCON_QUARTERLY_FEE,EF.CC_AIRCON_FIXED_FEE,EF.CC_DEPOSIT,EF.CC_PAYMENT_AMOUNT,EF.CC_PROCESSING_FEE,EF.CC_ELECTRICITY_CAP,EF.CC_DRYCLEAN_FEE,EF.CC_CHECKOUT_CLEANING_FEE,CED.CED_PRORATED,CED.CED_PROCESSING_WAIVED,CED.CED_NOTICE_START_DATE,CED.CED_NOTICE_PERIOD,CPD.CPD_COMMENTS,CTD.CLP_PRETERMINATE_DATE,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME, CTPD.CTP_DATA AS CED_ED_ETIME');
        $this->db->from('CUSTOMER_ENTRY_DETAILS CED,NATIONALITY_CONFIGURATION NC,UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U,UNIT_ROOM_TYPE_DETAILS URTD,VW_EXTENSION_CUSTOMER TEC');
        $this->db->join('CUSTOMER_TIME_PROFILE CTPA', 'CED.CED_SD_STIME = CTPA.CTP_ID' , 'left');
        $this->db->join('CUSTOMER_TIME_PROFILE CTPB', 'CED.CED_SD_ETIME = CTPB.CTP_ID' , 'left');
        $this->db->join('CUSTOMER_TIME_PROFILE CTPC', 'CED.CED_ED_STIME = CTPC.CTP_ID' , 'left');
        $this->db->join('CUSTOMER_TIME_PROFILE CTPD', 'CED.CED_ED_ETIME = CTPD.CTP_ID' , 'left');
        $this->db->join('CUSTOMER_COMPANY_DETAILS CCD', 'CED.CUSTOMER_ID=CCD.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_PERSONAL_DETAILS CPD', 'CED.CUSTOMER_ID=CPD.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER C', 'CED.CUSTOMER_ID=C.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_LP_DETAILS CTD', 'CED.CUSTOMER_ID=CTD.CUSTOMER_ID' , 'left');
        $this->db->join($CExtntblname.' EF', 'CED.CUSTOMER_ID=EF.CUSTOMER_ID' , 'left');
        $this->db->where('TEC.CUSTOMER_ID=CTD.CUSTOMER_ID AND CPD.NC_ID=NC.NC_ID AND UASD.UASD_ID=CED.UASD_ID AND UASD.URTD_ID=URTD.URTD_ID AND U.UNIT_ID=UASD.UNIT_ID AND CED.UNIT_ID=U.UNIT_ID AND CTD.CED_REC_VER=CED.CED_REC_VER AND C.CUSTOMER_ID='.$CEXTN_custid." AND CED.CED_REC_VER =TEC.CED_REC_VER AND CED.CED_REC_VER=EF.CUSTOMER_VER AND CTD.CLP_TERMINATE IS NULL AND CTD.CLP_GUEST_CARD IS NULL AND U.UNIT_NO=".$CEXTN_unitno);
        $this->db->order_by('CED.CED_REC_VER');
        $CEXTN_custdtls_query = $this->db->get();
        foreach($CEXTN_custdtls_query->result_array() as $row){
            $CEXTN_currentcheckoutdate="";
            $CEXTN_customerrecver=$row["CED_REC_VER"];
            $CEXTN_customerrecver=intval($CEXTN_customerrecver)+1;
            $this->db->select("CLP_STARTDATE");
            $this->db->from('CUSTOMER_LP_DETAILS');
            $this->db->where('CUSTOMER_ID='.$CEXTN_custid.' AND CED_REC_VER='.$CEXTN_customerrecver.' AND IF (CLP_PRETERMINATE_DATE IS NOT NULL ,CLP_PRETERMINATE_DATE>CURDATE(),CLP_ENDDATE>CURDATE())');
            $CEXTN_custrvquery=$this->db->get();
            foreach($CEXTN_custrvquery->result_array() as $CEXTN_custrvres){
                $CEXTN_currentcheckoutdate=$CEXTN_custrvres['CLP_STARTDATE'];
            }
            $CEXTN_firstname=$row["CUSTOMER_FIRST_NAME"];
            $CEXTN_lastname=$row["CUSTOMER_LAST_NAME"];
            $CEXTN_compname=$row["CCD_COMPANY_NAME"];
            if($CEXTN_compname==null){
                $CEXTN_compname="";
            }
            $CEXTN_compaddr=$row["CCD_COMPANY_ADDR"];
            if($CEXTN_compaddr==null){
                $CEXTN_compaddr="";
            }
            $CEXTN_comppostcode=$row["CCD_POSTAL_CODE"];
            if($CEXTN_comppostcode==null){
                $CEXTN_comppostcode="";
            }
            $CEXTN_email=$row["CPD_EMAIL"];
            $CEXTN_mobile=$row["CPD_MOBILE"];
            if($CEXTN_mobile==null){
                $CEXTN_mobile="";
            }
            $CEXTN_intlmobile=$row["CPD_INTL_MOBILE"];
            if($CEXTN_intlmobile==null){
                $CEXTN_intlmobile="";
            }
            $CEXTN_compofficeno=$row["CCD_OFFICE_NO"];
            if($CEXTN_compofficeno==null){
                $CEXTN_compofficeno="";
            }
            $CEXTN_dob=$row["CPD_DOB"];
            if($CEXTN_dob==null){
                $CEXTN_dob="";
            }
            $CEXTN_nation=$row["NC_DATA"];
            $CEXTN_passno=$row["CPD_PASSPORT_NO"];
            if($CEXTN_passno==null){
                $CEXTN_passno="";
            }
            $CEXTN_passdate=$row["CPD_PASSPORT_DATE"];
            if($CEXTN_passdate==null){
                $CEXTN_passdate="";
            }
            $CEXTN_epno=$row["CPD_EP_NO"];
            if($CEXTN_epno==null){
                $CEXTN_epno="";
            }
            $CEXTN_epdate=$row["CPD_EP_DATE"];
            if($CEXTN_epdate==null){
                $CEXTN_epdate="";
            }
            $CEXTN_rmtype=$row["URTD_ROOM_TYPE"];
            $CEXTN_custcard=$row["UASD_ACCESS_CARD"];
            //GET PREV CHECK IN DATE
            $CEXTN_prev_chkindate_query = 'SELECT CLP_STARTDATE FROM CUSTOMER_LP_DETAILS CTD,CUSTOMER_ENTRY_DETAILS CED WHERE CED.CED_REC_VER=CTD.CED_REC_VER AND CED.CUSTOMER_ID = CTD.CUSTOMER_ID AND CED.CED_REC_VER=(SELECT CED_REC_VER FROM CUSTOMER_LP_DETAILS WHERE CUSTOMER_ID='.$CEXTN_custid.' AND CLP_TERMINATE IS NULL AND IF(CLP_PRETERMINATE_DATE IS NOT NULL,CLP_STARTDATE<CLP_PRETERMINATE_DATE,CLP_STARTDATE<CLP_ENDDATE) AND CED_REC_VER='.$CExtnminlpval.' AND CLP_GUEST_CARD IS NULL) AND CED.CUSTOMER_ID='.$CEXTN_custid.' AND CTD.CLP_GUEST_CARD IS NULL';
            $CEXTN_prev_chkindate_result= $this->db->query($CEXTN_prev_chkindate_query);

            foreach($CEXTN_prev_chkindate_result->result_array() as $CEXTN_prev_chkindate_res){
                $CEXTN_chkindate=$CEXTN_prev_chkindate_res['CLP_STARTDATE'];
            }
            $CEXTN_chkoutdate=$row["CLP_ENDDATE"];
            $CEXTN_airconfee="";
            $CEXTN_airconquartelyfee = $row["CC_AIRCON_QUARTERLY_FEE"];
            if($CEXTN_airconquartelyfee==null){
                $CEXTN_airconquartelyfee="";
            }
            $CEXTN_airconfixedfee = $row["CC_AIRCON_FIXED_FEE"];
            if($CEXTN_airconfixedfee==null){
                $CEXTN_airconfixedfee="";
            }
            $CEXTN_deposit = $row["CC_DEPOSIT"];
            if($CEXTN_deposit==null){
                $CEXTN_deposit="";
            }
            $CEXTN_rental = $row["CC_PAYMENT_AMOUNT"];
            $CEXTN_processingfee = $row["CC_PROCESSING_FEE"];
            if($CEXTN_processingfee==null){
                $CEXTN_processingfee="";
            }
            $CEXTN_electricitycap = $row["CC_ELECTRICITY_CAP"];
            if($CEXTN_electricitycap==null){
                $CEXTN_electricitycap="";
            }
            $CEXTN_drycleanfee = $row["CC_DRYCLEAN_FEE"];
            if($CEXTN_drycleanfee==null){
                $CEXTN_drycleanfee="";
            }
            $CEXTN_checkoutcleaningfee = $row["CC_CHECKOUT_CLEANING_FEE"];
            if($CEXTN_checkoutcleaningfee==null){
                $CEXTN_checkoutcleaningfee="";
            }
            $CEXTN_prorated = $row["CED_PRORATED"];
            if($CEXTN_prorated==null){
                $CEXTN_prorated="";
            }
            $CEXTN_waived = $row["CED_PROCESSING_WAIVED"];
            if($CEXTN_waived==null){
                $CEXTN_waived="";
            }
            $CEXTN_noticedate= $row["CED_NOTICE_START_DATE"];
            if($CEXTN_noticedate==null){
                $CEXTN_noticedate="";
            }
            $CEXTN_stfrmtime=$row["CED_SD_STIME"];
            $CEXTN_sttotime=$row["CED_SD_ETIME"];
            $CEXTN_edfrmtime=$row["CED_ED_STIME"];
            $CEXTN_edtotime=$row["CED_ED_ETIME"];
            $CEXTN_noticeperiod=$row["CED_NOTICE_PERIOD"];
            $CEXTN_comments=$row["CPD_COMMENTS"];
            if($CEXTN_comments==null){
                $CEXTN_comments="";
            }
            if($CEXTN_noticeperiod==null){
                $CEXTN_noticeperiod="";
            }
            $CEXTN_preterminatedate = $row["CLP_PRETERMINATE_DATE"];
            if($CEXTN_preterminatedate==null){
                $CEXTN_preterminatedate="";
            }
            $CEXTN_custdtls=array("cust_firstname"=>$CEXTN_firstname,"cust_lastname"=>$CEXTN_lastname,"cust_compname"=>$CEXTN_compname,"cust_compaddr"=>$CEXTN_compaddr,"cust_comppostcode"=>$CEXTN_comppostcode,"cust_email"=>$CEXTN_email,"cust_mobile"=>$CEXTN_mobile,"cust_intlmobile"=>$CEXTN_intlmobile,"cust_officeno"=>$CEXTN_compofficeno,"cust_dob"=>$CEXTN_dob,"cust_nation"=>$CEXTN_nation,"cust_passno"=>$CEXTN_passno,"cust_passdate"=>$CEXTN_passdate,"cust_epno"=>$CEXTN_epno,"cust_epdate"=>$CEXTN_epdate,"cust_rmtype"=>$CEXTN_rmtype,"cust_chkindate"=>$CEXTN_chkindate,"cust_chkoutdate"=>$CEXTN_chkoutdate,"cust_airconquarterfee"=>$CEXTN_airconquartelyfee,"cust_airconfixedfee"=>$CEXTN_airconfixedfee,"cust_deposit"=>$CEXTN_deposit,"cust_rental"=>$CEXTN_rental,"cust_procfee"=>$CEXTN_processingfee,"cust_electcapfee"=>$CEXTN_electricitycap,"cust_dryclean"=>$CEXTN_drycleanfee,"cust_chkoutfee"=>$CEXTN_checkoutcleaningfee,"cust_prorated"=>$CEXTN_prorated,"cust_waived"=>$CEXTN_waived,"cust_noticedate"=>$CEXTN_noticedate,"cust_stfrmtime"=>$CEXTN_stfrmtime,"cust_sttotime"=>$CEXTN_sttotime,"cust_edfrmtime"=>$CEXTN_edfrmtime,"cust_edtotime"=>$CEXTN_edtotime,"cust_noticeperiod"=>$CEXTN_noticeperiod,"cust_preterminatedate"=>$CEXTN_preterminatedate,"cust_comts"=>$CEXTN_comments);
        }
        //GET CUSTOMER CARDS
        $CEXTN_cardarray =array();
        $CEXTN_custcardquery= "SELECT UASD.UASD_ACCESS_CARD,CTD.CLP_GUEST_CARD,CTD.CLP_PRETERMINATE_DATE FROM UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U,CUSTOMER C,CUSTOMER_ENTRY_DETAILS CED,CUSTOMER_LP_DETAILS CTD,CUSTOMER_ACCESS_CARD_DETAILS CACD,VW_EXTENSION_CUSTOMER TEC WHERE TEC.CUSTOMER_ID=CTD.CUSTOMER_ID AND CED.CED_REC_VER =TEC.CED_REC_VER AND CACD.CUSTOMER_ID=CTD.CUSTOMER_ID AND CTD.UASD_ID=CACD.UASD_ID AND CACD.ACN_ID IS NULL AND UASD.UASD_ID=CACD.UASD_ID AND UASD.UASD_ID=CTD.UASD_ID AND CED.CED_REC_VER=CTD.CED_REC_VER AND CTD.CLP_TERMINATE IS NULL AND C.CUSTOMER_ID=CED.CUSTOMER_ID AND C.CUSTOMER_ID=CTD.CUSTOMER_ID AND CED.CUSTOMER_ID=CTD.CUSTOMER_ID AND U.UNIT_ID=CED.UNIT_ID  AND C.CUSTOMER_ID=".$CEXTN_custid." AND CTD.UASD_ID IS NOT NULL AND UASD.UASD_ACCESS_CARD IS NOT NULL AND U.UNIT_NO=".$CEXTN_unitno." ORDER BY CTD.CLP_GUEST_CARD ASC";
        $CEXTN_custcardres = $this->db->query($CEXTN_custcardquery);
        foreach($CEXTN_custcardres->result_array() as $row){
            $CEXTN_cgstcard=$row["CLP_GUEST_CARD"];
            $CEXTN_cptddate=$row["CLP_PRETERMINATE_DATE"];
            $CEXTN_custcard=$row["UASD_ACCESS_CARD"];
            if(($CEXTN_cptddate==null&&$CEXTN_cgstcard!=null)||($CEXTN_cgstcard==null)){
                $CEXTN_cardarray[]=($CEXTN_custcard);
            }
        }
        $drop_query = "DROP TABLE ".$CExtntblname;
        $this->db->query($drop_query);
        $CEXTN_diffunittno=array();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $CEXTN_unitdate=$this->Mdl_eilib_common_function->GetUnitSdEdate($CEXTN_unitno);//call function to get unit start n end date
        $CEXTN_unitsdate=$CEXTN_unitdate['unitsdate'];//get unit start date
        $CEXTN_unitedate=$CEXTN_unitdate['unitedate'];//get unit end date
        $CEXTN_diffunittno=$this->CEXTN_getdiffUnitNo($CEXTN_unitno);
        $CEXTN_finaldtls=array("currentcheckoutdate"=>$CEXTN_currentcheckoutdate,"custdtls"=>$CEXTN_custdtls,"cardarray"=>$CEXTN_cardarray,"unitno"=>$CEXTN_diffunittno,"unitsdate"=>$CEXTN_unitsdate,"unitedate"=>$CEXTN_unitedate);
        return $CEXTN_finaldtls;
    }
    //FUNCTION TO GET UNIT NO EXCEPT SELECTED UNIT NO
    function CEXTN_getdiffUnitNo($CEXTN_unitno){
        $CEXTN_unoarray =array();
        $CEXTN_unoquery= "SELECT UNIT_NO FROM VW_ACTIVE_UNIT ORDER BY UNIT_NO ASC";
        $CEXTN_unores = $this->db->query($CEXTN_unoquery);
        foreach($CEXTN_unores->result_array() as $row){
            $unitno=$row["UNIT_NO"];
            if($CEXTN_unitno!=$unitno)
            {
                $CEXTN_unoarray[]=($unitno);
            }
        }
        return $CEXTN_unoarray;
    }
    //FUNCTION TO GET ROOM TYPE FOR SAME UNIT
    function CEXTN_getRoomType($CEXTN_unitno,$CEXTN_roomtype){
        $CEXTN_roomtypearray =array();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $CEXTN_roomtypearray=$this->Mdl_eilib_common_function->CUST_getRoomType($CEXTN_unitno,$CEXTN_roomtype);
        $unitdate=$this->Mdl_eilib_common_function->GetUnitSdEdate($CEXTN_unitno);//call function to get unit start n end date
        $CEXTN_unitsdate=$unitdate['unitsdate'];//get unit start date
        $CEXTN_unitedate=$unitdate['unitedate'];//get unit end date
        $CEXTN_rmtypenunitdate=(object)["unitsdate"=>$CEXTN_unitsdate,"unitedate"=>$CEXTN_unitedate,"roomtype"=>$CEXTN_roomtypearray];
        return $CEXTN_rmtypenunitdate;
    }
    //FUNCTION TO GET CARD NOS
    function CEXTN_getdiffunitCardNo($CEXTN_unit,$CEXTN_firstname,$CEXTN_lastname){

        $CEXTN_cardnoresult=array();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $CEXTN_cardnoresult=$this->Mdl_eilib_common_function->CUST_getunitCardNo_FirstLast($CEXTN_unit,$CEXTN_firstname,$CEXTN_lastname);
        return $CEXTN_cardnoresult;
    }
    //FUNCTION TO CHK PRORATED OR NOT
    function CEXTN_chkProrated($CEXTN_db_chkindate,$CEXTN_db_chkoutdate){
        $CEXTN_chkproflag="";
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $CEXTN_chkproflag=$this->Mdl_eilib_common_function->CUST_chkProrated($CEXTN_db_chkindate,$CEXTN_db_chkoutdate);
        return $CEXTN_chkproflag;
    }
    //FUNCTION TO SAVE CUSTOMER DETAILS
    function CEXTN_SaveDetails($UserStamp){
        try
        {
            $CEXTN_formname="EXTENSION";
            $CEXTN_sameamntflag="";
            $CEXTN_lb_emailid=$_POST["CEXTN_lb_emailid"];
            $CEXTN_hidden_custid=$_POST["CEXTN_hidden_custid"];
            $CEXTN_lb_unitno=$_POST["CEXTN_lb_unitno"];
            $CEXTN_lb_custname=$_POST["CEXTN_lb_custname"];
            $CEXTN_tb_firstname=$_POST["CEXTN_tb_firstname"];
            $CEXTN_tb_lastname=$_POST["CEXTN_tb_lastname"];
            $CEXTN_customename=$CEXTN_lb_custname;
            $CEXTN_continvoicecustomename=$CEXTN_tb_firstname." ".$CEXTN_tb_lastname;
            $CEXTN_tb_contrpassno='';
            $CEXTN_tb_contrepno='';$CEXTN_tb_contrepdate='';
            $CEXTN_tb_contrpassdate='';
            $CEXTN_tb_contrnoticedate='';
            $CEXTN_tb_contrcompname='';
            //COMPANY DETAILS
            $CEXTN_tb_compname=$_POST["CEXTN_tb_compname"];
            $CEXTN_tb_contrcompname=$CEXTN_tb_compname;//company name for contract
            if($CEXTN_tb_compname=="")
            {  $CEXTN_tb_compname='null';  }else{$CEXTN_tb_compname="'$CEXTN_tb_compname'";}
            $CEXTN_tb_compaddr=$_POST["CEXTN_tb_compaddr"];
            if($CEXTN_tb_compaddr=="")
            {  $CEXTN_tb_compaddr='null';  }else{$CEXTN_tb_compaddr="'$CEXTN_tb_compaddr'";}
            $CEXTN_tb_comppostcode=$_POST["CEXTN_tb_comppostcode"];
            if($CEXTN_tb_comppostcode=="")
            {  $CEXTN_tb_comppostcode='null';  }else{$CEXTN_tb_comppostcode="'$CEXTN_tb_comppostcode'";}
            $CEXTN_tb_officeno=$_POST["CEXTN_tb_officeno"];
            if($CEXTN_tb_officeno=="")
            {  $CEXTN_tb_officeno='null';  }else{$CEXTN_tb_officeno="'$CEXTN_tb_officeno'";}
            //PERSONAL DETAILS
            $CEXTN_tb_emailid=$_POST["CEXTN_tb_emailid"];//($_POST["CEXTN_tb_emailid).toString().toLowerCase();
            $CEXTN_tb_mobileno=$_POST["CEXTN_tb_mobileno"];
            if($CEXTN_tb_mobileno=="")
            {  $CEXTN_tb_mobileno='null';  }else{$CEXTN_tb_mobileno="'$CEXTN_tb_mobileno'";}
            $CEXTN_tb_intmobileno=$_POST["CEXTN_tb_intmobileno"];
            if($CEXTN_tb_intmobileno=="")
            {  $CEXTN_tb_intmobileno='null';  }else{$CEXTN_tb_intmobileno="'$CEXTN_tb_intmobileno'";}
            $CEXTN_db_dob=$_POST["CEXTN_db_dob"];
            if($CEXTN_db_dob==""){
                $CEXTN_db_dob='null';
            }
            else{
                $CEXTN_db_dob=date('Y-m-d',strtotime($CEXTN_db_dob));
                $CEXTN_db_dob="'$CEXTN_db_dob'";
            }
            $CEXTN_tb_nation=$_POST["CEXTN_tb_nation"];
            $CEXTN_tb_passno=$_POST["CEXTN_tb_passno"];
            $CEXTN_tb_contrpassno=$CEXTN_tb_passno;//passport no for contract
            if($CEXTN_tb_passno=="")
            {  $CEXTN_tb_passno='null';}else{$CEXTN_tb_passno="'$CEXTN_tb_passno'";}
            $CEXTN_db_passdate=$_POST["CEXTN_db_passdate"];
            $CEXTN_tb_contrpassdate=$CEXTN_db_passdate;//passport date for contract
            if($CEXTN_db_passdate==""){
                $CEXTN_db_passdate='null';
            }
            else{
                $CEXTN_db_passdate=date('Y-m-d',strtotime($CEXTN_db_passdate));
                $CEXTN_db_passdate="'$CEXTN_db_passdate'";
            }
            $CEXTN_tb_epno=$_POST["CEXTN_tb_epno"];
            $CEXTN_tb_contrepno=$CEXTN_tb_epno;//ep no for contract
            if($CEXTN_tb_epno==""){
                $CEXTN_tb_epno='null';
            }else{
                $CEXTN_tb_epno="'$CEXTN_tb_epno'";}
            $CEXTN_db_epdate=$_POST["CEXTN_db_epdate"];
            $CEXTN_tb_contrepdate=$CEXTN_db_epdate;////ep date for contract
            if($CEXTN_db_epdate==""){  $CEXTN_db_epdate='null';
            }
            else{
                $CEXTN_db_epdate=date('Y-m-d',strtotime($CEXTN_db_epdate));
                $CEXTN_db_epdate="'$CEXTN_db_epdate'";
            }
            $CEXTN_ta_comments=$_POST["CEXTN_ta_comments"];
            if($CEXTN_ta_comments!=""){
                $CEXTN_ta_comments=$this->db->escape_like_str($CEXTN_ta_comments);
            }
            //UNIT OPTION
            $CEXTN_radio_unit=$_POST["CEXTN_radio_unit"];
            //SAME UNIT N SAME ROOM
            $CEXTN_tb_sameunitsamermuno=$_POST["CEXTN_tb_sameunitsamermuno"];
            $CEXTN_tb_sameunitsamermrmtype=$_POST["CEXTN_tb_sameunitsamermrmtype"];
            //SAME UNIT N DIFFERENT ROOM
            $CEXTN_tb_sameunitdiffrmuno=$_POST["CEXTN_tb_sameunitdiffrmuno"];
            $CEXTN_lb_sameunitdiffrmrmtype=$_POST["CEXTN_lb_sameunitdiffrmrmtype"];
            $CEXTN_tb_sameunitdiffrmcustcard=$_POST["CEXTN_tb_sameunitdiffrmcustcard"];
            //DIFFERENT UNIT
            $CEXTN_lb_diffunituno=$_POST["CEXTN_lb_diffunituno"];
            $CEXTN_lb_diffunitrmtype=$_POST["CEXTN_lb_diffunitrmtype"];
            $CEXTN_radio_difunitcard=$_POST["CEXTN_radio_difunitcard"];
            //ENTRY DETAILS
            $CEXTN_db_prevchkindate=$_POST["CEXTN_db_prevchkindate"];
            $CEXTN_hidden_prechkinfromtime=$_POST["CEXTN_hidden_prechkinfromtime"];
            $CEXTN_hidden_prechkintotime=$_POST["CEXTN_hidden_prechkintotime"];
            $CEXTN_db_chkindate=date('Y-m-d',strtotime($_POST["CEXTN_db_chkindate"]));//eilib.SqlDateFormat($_POST["CEXTN_db_chkindate"]);
            $CEXTN_hidden_chkinfromtime=$_POST["CEXTN_hidden_chkinfromtime"];
            $CEXTN_hidden_chkintotime=$_POST["CEXTN_hidden_chkintotime"];
            $CEXTN_lb_chkinfromtime=$_POST["CEXTN_lb_chkinfromtime"];
            $CEXTN_lb_chkintotime=$_POST["CEXTN_lb_chkintotime"];
            $CEXTN_db_chkoutdate=date('Y-m-d',strtotime($_POST["CEXTN_db_chkoutdate"]));//eilib.SqlDateFormat($_POST["CEXTN_db_chkoutdate"]);
            $CEXTN_lb_chkoutfromtime=$_POST["CEXTN_lb_chkoutfromtime"];
            $CEXTN_lb_chkouttotime=$_POST["CEXTN_lb_chkouttotime"];
            $CEXTN_tb_noticeperiod=$_POST["CEXTN_tb_noticeperiod"];
            $CEXTN_contractnoticeperiod=$CEXTN_tb_noticeperiod;
            if($CEXTN_tb_noticeperiod=="")
            {    $CEXTN_tb_noticeperiod='null';  }else{$CEXTN_tb_noticeperiod="'$CEXTN_tb_noticeperiod'";}

            $CEXTN_db_noticeperioddate=$_POST["CEXTN_db_noticeperioddate"];
            $CEXTN_tb_contrnoticedate=$CEXTN_db_noticeperioddate;//notice date for contract
            if($CEXTN_tb_contrnoticedate=='undefined'){$CEXTN_tb_contrnoticedate="";}
            if($CEXTN_db_noticeperioddate==""||$CEXTN_db_noticeperioddate=='undefined'){
                $CEXTN_db_noticeperioddate='null';
            }
            else{
                $CEXTN_db_noticeperioddate=date('Y-m-d',strtotime($CEXTN_db_noticeperioddate));
                $CEXTN_db_noticeperioddate="'$CEXTN_db_noticeperioddate'";
            }
            $CEXTN_cb_sameamtprorated=$_POST["CEXTN_cb_sameamtprorated"];
            $CEXTN_cb_sameamtwaived=$_POST["CEXTN_cb_sameamtwaived"];
            $CEXTN_cb_diffamtprorated=$_POST["CEXTN_cb_diffamtprorated"];
            $CEXTN_cb_diffamtwaived=$_POST["CEXTN_cb_diffamtwaived"];
            //FEE DETAILS
            $CEXTN_radio_airconfee=$_POST["CEXTN_radio_airconfee"];
            $CEXTN_radio_amt=$_POST["CEXTN_radio_amt"];
            $CEXTN_tb_airquarterfee=$_POST["CEXTN_tb_airquarterfee"];
            $CEXTN_tb_fixedairfee=$_POST["CEXTN_tb_fixedairfee"];
            //CHECK AIRCON FEE
            if($CEXTN_radio_airconfee=="CEXTN_radio_quartairconfee"){
                if($CEXTN_tb_airquarterfee==""){
                    $CEXTN_tb_airquarterfee='null';
                }
                $CEXTN_tb_fixedairfee='null';
            }
            else{
                $CEXTN_tb_airquarterfee='null';
                if($CEXTN_tb_fixedairfee==""){
                    $CEXTN_tb_fixedairfee='null';
                }
            }
            $CEXTN_tb_electcapfee=$_POST["CEXTN_tb_electcapfee"];
            if($CEXTN_tb_electcapfee==""){
                $CEXTN_tb_electcapfee='null';
            }
            else{
                $CEXTN_tb_electcapfee="'$CEXTN_tb_electcapfee'";
            }
            $CEXTN_tb_curtaindryfee=$_POST["CEXTN_tb_curtaindryfee"];
            if($CEXTN_tb_curtaindryfee==""){
                $CEXTN_tb_curtaindryfee='null';
            }
            else{
                $CEXTN_tb_curtaindryfee="'$CEXTN_tb_curtaindryfee'";
            }
            $CEXTN_tb_chkoutcleanfee=$_POST["CEXTN_tb_chkoutcleanfee"];
            if($CEXTN_tb_chkoutcleanfee==""){
                $CEXTN_tb_chkoutcleanfee='null';
            }
            else{
                $CEXTN_tb_chkoutcleanfee="'$CEXTN_tb_chkoutcleanfee'";
            }
            //SAME AMOUNT
            $CEXTN_tb_sameamtdep=$_POST["CEXTN_tb_sameamtdep"];
            $CEXTN_tb_sameamtrent=$_POST["CEXTN_tb_sameamtrent"];
            $CEXTN_tb_sameamtprocost=$_POST["CEXTN_tb_sameamtprocost"];
            if($CEXTN_tb_sameamtprocost==''){
                $CEXTN_tb_sameamtprocost='null';
            }
            else{
                $CEXTN_tb_sameamtprocost="'$CEXTN_tb_sameamtprocost'";
            }
            //DIFFERENT AMOUNT
            $CEXTN_tb_diffamtdep=$_POST["CEXTN_tb_diffamtdep"];
            if($CEXTN_tb_diffamtdep==""){
                $CEXTN_tb_diffamtdep=null;
            }
            $CEXTN_tb_diffamtrent=$_POST["CEXTN_tb_diffamtrent"];
            $CEXTN_tb_diffamtprocost=$_POST["CEXTN_tb_diffamtprocost"];
            if($CEXTN_tb_diffamtprocost==""){
                $CEXTN_tb_diffamtprocost=null;
            }
            //TO READ CUST ID
            $CEXTN_radiocustid=$_POST["CEXTN_radiocustid"];
            //TO READ CARD NOS
            $CEXTN_cb_diffunitcard=$_POST["CEXTN_cb_diffunitcard"];
            $CEXTN_lb_diffunitcard=$_POST["CEXTN_lb_diffunitcard"];
            $CEXTN_tb_diffunitcard=$_POST["CEXTN_tb_diffunitcard"];
            //PRORATED OR WAIVED VALUE
            $CEXTN_hidden_sameamtprorated=$_POST["CEXTN_hidden_sameamtprorated"];
            $CEXTN_hidden_sameamtwaived=$_POST["CEXTN_hidden_sameamtwaived"];
            $CEXTN_hidden_diffamtprorated=$_POST["CEXTN_hidden_diffamtprorated"];
            $CEXTN_hidden_diffamtwaived=$_POST["CEXTN_hidden_diffamtwaived"];
            //QUATORS N LEASE PERIOD CALC
            $CEXTN_sdate=$CEXTN_db_chkindate;
            $CEXTN_edate=$CEXTN_db_chkoutdate;
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $this->load->model('EILIB/Mdl_eilib_quarter_calc');
            $CEXTN_Leaseperiod=$this->Mdl_eilib_common_function->getLeasePeriod($CEXTN_sdate,$CEXTN_edate);
            $CEXTN_quators=$this->Mdl_eilib_quarter_calc->quarterCalc(new DateTime($CEXTN_sdate), new DateTime($CEXTN_edate));

            //SET UNIT NO N ROOM TYPE
            $CEXTN_unitno="";
            $CEXTN_roomtype="";
            $CEXTN_waivedvalue="";
            $CEXTN_proratedvalue="";
            $CEXTN_rentamt="";
            $CEXTN_depositamt="";
            $CEXTN_profeeamt="";
            $CEXTN_chkoutcleanamt="";
            $CEXTN_drycleanamt="";
            $CEXTN_electamt="";
            $CEXTN_quartamt="";
            $CEXTN_fixedamt="";
            $CEXTN_chksameunit="";
            $CEXTN_card_array=array();
            $CEXTN_card_lbl=array();
            $CEXTN_accesscard="";
            $CEXTN_guestcard="";
            if($CEXTN_radio_unit=="CEXTN_radio_diffunit"){
                $CEXTN_unitno=$CEXTN_lb_diffunituno;
                $CEXTN_roomtype=$CEXTN_lb_diffunitrmtype;
                $CEXTN_chksameunit="";
            }
            else{
                $CEXTN_unitno=$CEXTN_lb_unitno;
                $CEXTN_chksameunit='X';
            }
            if($CEXTN_chksameunit==""){
                $CEXTN_chksameunit='null';
            }
            else{
                $CEXTN_chksameunit="'$CEXTN_chksameunit'";
            }
            if($CEXTN_radio_unit=="CEXTN_radio_sameunit"){
                $CEXTN_roomtype=$CEXTN_tb_sameunitsamermrmtype;
                $CEXTN_lb_chkinfromtime=$CEXTN_hidden_chkinfromtime;
                $CEXTN_lb_chkintotime=$CEXTN_hidden_chkintotime;
                $CEXTN_card_array= $_POST["CEXTN_tb_sameunitsamermcustcard"];//getcardno
                $CEXTN_card_lbl=$_POST["CEXTN_hidden_sameunitsamermcustcard"];//get customer label
            }
            if($CEXTN_radio_unit=="CEXTN_radio_sameunitdiffroom"){
                $CEXTN_roomtype=$CEXTN_lb_sameunitdiffrmrmtype;
                $CEXTN_card_array= $_POST["CEXTN_tb_sameunitdiffrmcustcard"];//get customer card
                $CEXTN_card_lbl=$_POST["CEXTN_hidden_sameunitdiffrmcustcard"];//get customer label
            }
            $CEXTN_rent_check="";
            //CHECK SAME OR DIFF AMOUNT
            if($CEXTN_radio_amt=="CEXTN_radio_sameamt"){
                $CEXTN_waivedvalue=$CEXTN_hidden_sameamtwaived;
                $CEXTN_proratedvalue=$CEXTN_hidden_sameamtprorated;
                $CEXTN_rent_check=$CEXTN_hidden_sameamtprorated;
                $CEXTN_rentamt=$CEXTN_tb_sameamtrent;
                $CEXTN_depositamt=$CEXTN_tb_sameamtdep;
                $CEXTN_depositamt='null';
                if($CEXTN_waivedvalue!=""){
                    $CEXTN_profeeamt=$CEXTN_tb_sameamtprocost;
                }
                else{
                    $CEXTN_profeeamt='null';
                }
                $CEXTN_sameamntflag="'X'";
            }
            else{
                $CEXTN_waivedvalue=$CEXTN_hidden_diffamtwaived;
                $CEXTN_proratedvalue=$CEXTN_hidden_diffamtprorated;
                $CEXTN_rent_check=$CEXTN_hidden_diffamtprorated;
                $CEXTN_rentamt=$CEXTN_tb_diffamtrent;
                $CEXTN_depositamt=$CEXTN_tb_diffamtdep;
                if($CEXTN_depositamt==""){
                    $CEXTN_depositamt='null';
                }
                $CEXTN_profeeamt=$CEXTN_tb_diffamtprocost;
                if($CEXTN_profeeamt==""){
                    $CEXTN_profeeamt='null';
                }
                $CEXTN_sameamntflag='null';
            }
            //GET CARD NOS
            $accessflag=0;
            if($CEXTN_card_array==''){
                $accessflag=1;
            }
            if($CEXTN_radio_unit=="CEXTN_radio_diffunit"&&$CEXTN_radio_difunitcard=="CEXTN_radio_difunitcardno"){
                $CEXTN_card_array=$CEXTN_cb_diffunitcard;
                $card_lbl=$_POST["CEXTN_slctcustlbl"];
                $CEXTN_find=strlen(strstr($card_lbl,','));
                if($CEXTN_find>0){
                    $finalarray=explode(",",$card_lbl);//card_lbl.split(",")
                    for($i=0;$i<count($finalarray);$i++)
                    {
                        $CEXTN_card_lbl[]=($finalarray[$i]);
                    }
                }
                else{
                    $CEXTN_card_lbl=$card_lbl;
                }
            }
            $CEXTN_customercard="";
            if(count($CEXTN_card_array)>0)//!='undefined')
            {
                if(count($CEXTN_card_array)>1){
                    $accessflag=0;
                    for($i=0;$i<count($CEXTN_card_array);$i++){
                        if($CEXTN_card_array[$i]=="")continue;
                        $CEXTN_cardnos=$CEXTN_card_array[$i];
                        $CEXTN_cardlbl=str_replace(" ","_",$CEXTN_card_lbl[$i]);//CEXTN_card_lbl[i].replace(/ /g,"_");
                        $CEXTN_customename=str_replace(" ","_",$CEXTN_customename);//$CEXTN_customename.replace(/ /g,"_");
                        if($CEXTN_cardlbl==$CEXTN_customename){
                            if($CEXTN_accesscard==""){
                                $CEXTN_accesscard=$CEXTN_cardnos;
                                $CEXTN_customercard=$CEXTN_cardnos;
                                $CEXTN_guestcard=$CEXTN_cardnos.","." ";
                            }
                            else{
                                $CEXTN_accesscard=$CEXTN_accesscard.",".$CEXTN_cardnos;
                                $CEXTN_guestcard=$CEXTN_guestcard.",".$CEXTN_cardnos.", ";
                                $CEXTN_customercard=$CEXTN_cardnos;
                            }
                        }
                        else{
                            if($CEXTN_accesscard=="")
                            {
                                $CEXTN_guestcard=$CEXTN_cardnos.",X";
                                $CEXTN_accesscard=$CEXTN_cardnos;
                            }
                            else
                            {
                                $CEXTN_accesscard=$CEXTN_accesscard.",".$CEXTN_cardnos;
                                $CEXTN_guestcard=$CEXTN_guestcard.",".$CEXTN_cardnos.",X";
                            }
                        }
                    }
                }
                else
                {
                    $accessflag=1;
                    $CEXTN_accesscard=$CEXTN_card_array[0];
                    $CEXTN_customercard=$CEXTN_card_array[0];
                    $CEXTN_guestcard=$CEXTN_card_array[0].", ";
                }
            }
            else
            {
                $CEXTN_accesscard="";
                $CEXTN_guestcard=$CEXTN_accesscard.", ";
            }
            //CALENDAR DATE N TIME
            $CEXTN_prevchkoutdate=date('Y-m-d',strtotime($CEXTN_db_chkindate));//eilib.SqlDateFormat(CEXTN_db_chkindate);
            $CEXTN_prevchkoutdatefromtime=$CEXTN_hidden_chkinfromtime;
            $CEXTN_prevchkoutdatetotime=$CEXTN_hidden_chkintotime;
            $CEXTN_prevchkinfromtime=$CEXTN_hidden_prechkinfromtime;
            $CEXTN_prevchkintotime=$CEXTN_hidden_prechkintotime;
            //CALL SAVE SP
            $CEXTN_CALEVENTS=array();
            $this->db->query('SET AUTOCOMMIT=0');
            $this->db->query('START TRANSACTION');
            $CEXTN_save="CALL SP_CUSTOMER_EXTENSION_INSERT($CEXTN_hidden_custid,$CEXTN_tb_compname,$CEXTN_tb_compaddr,$CEXTN_tb_comppostcode,$CEXTN_tb_officeno,'$CEXTN_unitno',$CEXTN_chksameunit,'$CEXTN_roomtype','$CEXTN_lb_chkinfromtime','$CEXTN_lb_chkintotime','$CEXTN_lb_chkoutfromtime','$CEXTN_lb_chkouttotime','$CEXTN_Leaseperiod','$CEXTN_quators','$CEXTN_waivedvalue','$CEXTN_proratedvalue',$CEXTN_tb_noticeperiod,$CEXTN_db_noticeperioddate,'$CEXTN_rentamt',$CEXTN_depositamt,$CEXTN_profeeamt,$CEXTN_tb_fixedairfee,$CEXTN_tb_airquarterfee,$CEXTN_tb_electcapfee,$CEXTN_tb_chkoutcleanfee,$CEXTN_tb_curtaindryfee,'$CEXTN_accesscard','$CEXTN_db_chkindate','$UserStamp','$CEXTN_db_chkindate','$CEXTN_db_chkoutdate','$CEXTN_guestcard','$CEXTN_tb_nation',$CEXTN_tb_mobileno,$CEXTN_tb_intmobileno,'$CEXTN_tb_emailid',$CEXTN_tb_passno,$CEXTN_db_passdate,$CEXTN_db_dob,$CEXTN_tb_epno,$CEXTN_db_epdate,'$CEXTN_ta_comments',$CEXTN_sameamntflag,'$CEXTN_tb_firstname','$CEXTN_tb_lastname',@EXTNFLAG,@TEMP_OUT_EXT_CARNOTBLNAME,@TEMP_OUT_EXTN_CLPDTLSTTBLNAME,@TEMP_OUT_EXTN_FEEDTLTBLNAME,@PAY_CHK_MSG,@SAVE_POINT_NAME)";
            $this->db->query($CEXTN_save);
            $CEXTN_finalarr=$this->CEXTN_ReturnFlagGetExtnFormTempTables();
            $CEXTN_saveflag=$CEXTN_finalarr[0];
            $savepoint=$CEXTN_finalarr[3];
            if($CEXTN_saveflag==1){
                $fileid='';
                $filetempname = $_FILES['CEXTN_fileupload']['tmp_name'];
                $filename = $CEXTN_unitno . '-' . $CEXTN_hidden_custid . '-' . $CEXTN_tb_firstname . ' ' . $CEXTN_tb_lastname;
                $mimetype = 'application/pdf';
                $this->load->model('EILIB/Mdl_eilib_common_function');
                $service = $this->Mdl_eilib_common_function->get_service_document();
                $Targetfolderid=$this->Mdl_eilib_common_function->CUST_TargetFolderId();
                $UnitFolderid=$this->Mdl_eilib_common_function->getUnitfolderId($CEXTN_unitno,$CEXTN_hidden_custid);
                $unitcount=count($UnitFolderid);
                $ext_flag=0;
                $extunitfolder=0;
                $extcustfolder=0;
                if($unitcount!=0 && $UnitFolderid[0]!='' && $UnitFolderid[1]!='')
                {
                    $UnitFolder= $UnitFolderid[0];
                    $CustomerFolder=$UnitFolderid[1];
                    $ext_flag=1;
                }
                else
                {
                    if ($unitcount == 0) {
                        $extunitfolder=1;
                        $UnitFolder = $this->Mdl_eilib_common_function->Customer_FolderCreation($service, $CEXTN_unitno, 'PersonalDetails', $Targetfolderid);
                    } else {
                        $UnitFolder = $UnitFolderid[0];
                    }
                    if ($UnitFolder != '') {
                        $extcustfolder=1;
                        $customerfoldername = $CEXTN_hidden_custid . '-' . $CEXTN_tb_firstname . ' ' . $CEXTN_tb_lastname;
                        $CustomerFolder = $this->Mdl_eilib_common_function->Customer_FolderCreation($service, $customerfoldername, 'PersonalDetails', $UnitFolder);
                    }
                }
                if($CustomerFolder!='' &&$ext_flag==0 ) {
                    $Fileidinsertquery = "CALL SP_INSERT_UPDATE_CUSTOMER_FILE_DIRECTORY($CEXTN_unitno,'$UnitFolder',$CEXTN_hidden_custid,'$CustomerFolder','$UserStamp',@SUCCESS_MESSAGE)";
                    $result = $this->db->query($Fileidinsertquery);
                }
                if ($filetempname != '')
                {
                    $fileid=$this->Mdl_eilib_common_function->Customer_FileUpload($service, $filename, 'PersonalDetails', $CustomerFolder, $mimetype, $filetempname);

                }
                $this->load->model('EILIB/Mdl_eilib_calender');
                $cal_service=$this->Mdl_eilib_calender->createCalendarService();
                $CEXTN_TargetFolderId=$this->Mdl_eilib_common_function->CUST_TargetFolderId();//GET TARGER FOLDER ID
                $docowner=$this->Mdl_eilib_common_function->CUST_documentowner($UserStamp);//get doc owner
                $CEXTN_CALEVENTS=$this->Mdl_eilib_calender->CTermExtn_GetCalevent($CEXTN_hidden_custid);
                //CALL CALENDAR EVENT FUNCTION FROM EILIB
                $cal_flag=$this->Mdl_eilib_calender->CTermExtn_Calevent($cal_service,$CEXTN_hidden_custid,"",$CEXTN_formname,"",$fileid);
                if($cal_flag==1) {
                    $cust_config_array = array();
                    $cust_config_array = $this->Mdl_eilib_common_function->CUST_invoice_contractreplacetext();
                    $CEXTN_invoiceid = $cust_config_array[9];
                    $CEXTN_invoicesno = $cust_config_array[0];
                    $CEXTN_invoicedate = $cust_config_array[1];
                    if ($CEXTN_rent_check != "") {
                        $CEXTN_rent_check = 'true';
                    } else {
                        $CEXTN_rent_check = 'false';
                    }
                    $Emailtemplate=$this->Mdl_eilib_common_function->CUST_emailsubandmessages();
                    $mail_username=explode('@',$CEXTN_lb_emailid);
                    $Username=strtoupper($mail_username[0]);
                    //CONTRACT N INVOICE
                    $service = $this->Mdl_eilib_common_function->get_service_document();
                    $this->load->model('EILIB/Mdl_eilib_invoice_contract');
                    //same amount
                    if ($CEXTN_radio_amt == "CEXTN_radio_sameamt") {
                        $contract = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $CEXTN_unitno, $CEXTN_db_chkindate, $CEXTN_db_chkoutdate, $CEXTN_tb_contrcompname, $CEXTN_continvoicecustomename, $CEXTN_contractnoticeperiod, $CEXTN_tb_contrpassno, $CEXTN_tb_contrpassdate, $CEXTN_tb_contrepno, $CEXTN_tb_contrepdate, $CEXTN_tb_contrnoticedate, $CEXTN_Leaseperiod, $CEXTN_customercard, $CEXTN_rentamt, $CEXTN_tb_airquarterfee, $CEXTN_tb_fixedairfee, $CEXTN_tb_electcapfee, $CEXTN_tb_curtaindryfee, $CEXTN_tb_chkoutcleanfee, $CEXTN_profeeamt, $CEXTN_depositamt, $CEXTN_waivedvalue, $CEXTN_roomtype, $CEXTN_rent_check, "EXTENSION", $CEXTN_lb_emailid, $docowner,$CustomerFolder);
                        if($contract[0]==0){
                            if($contract[1]!='undefined')
                                $res=$this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service,$contract[1]);
                            $this->db->trans_savepoint_rollback($savepoint);
                            for($ijk=0;$ijk<count($CEXTN_CALEVENTS);$ijk++){
                                $this->Mdl_eilib_calender->CUST_customerTermcalenderdeletion($cal_service,$CEXTN_hidden_custid,$CEXTN_CALEVENTS[$ijk]['sddate'],$CEXTN_CALEVENTS[$ijk]['sdtimein'],$CEXTN_CALEVENTS[$ijk]['sdtimeout'],$CEXTN_CALEVENTS[$ijk]['eddate'],$CEXTN_CALEVENTS[$ijk]['edtimein'],$CEXTN_CALEVENTS[$ijk]['edtimeout'],"");
                            }
                            $cal_flag=$this->Mdl_eilib_calender->CTermExtn_Calevent($cal_service,$CEXTN_hidden_custid,"",$CEXTN_formname,"");
                            if($fileid!=''){
                                $res=$this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service,$fileid);
                            }
                            if($extunitfolder==1 && $extcustfolder==1) {
                                if ($UnitFolder != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolder);
                                }
                                if ($CustomerFolder != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolder);
                                }
                            }
                            $CEXTN_saveflag=$contract[3];
                        }
                        else{
                            $Messcontent=$CEXTN_unitno.'-'.$CEXTN_continvoicecustomename;
                            $Emailsub=$Emailtemplate[1]['subject'];
                            $Messagebody=$Emailtemplate[1]['message'];
                            $Emailsub =str_replace('[UNIT NO - CUSTOMER_NAME]',$Messcontent,$Emailsub);
                            $Messagebody =str_replace('[UNIT NO - CUSTOMER_NAME]',$Messcontent,$Messagebody);
                            $Messagebody=str_replace('[MAILID_USERNAME]',$Username,$Messagebody);
                            $Messagebody=$Messagebody.'<br><br>CONTRACT :'.$contract[2];
                            $Displayname=$this->Mdl_eilib_common_function->Get_MailDisplayName('CONTRACT');
                            $this->mailpart($Emailsub,$Messagebody,$Displayname,$UserStamp,$CEXTN_lb_emailid);
                        }
                    }
                    //diff amount
                    else {
                        $contract = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $CEXTN_unitno, $CEXTN_db_chkindate, $CEXTN_db_chkoutdate, $CEXTN_tb_contrcompname, $CEXTN_continvoicecustomename, $CEXTN_contractnoticeperiod, $CEXTN_tb_contrpassno, $CEXTN_tb_contrpassdate, $CEXTN_tb_contrepno, $CEXTN_tb_contrepdate, $CEXTN_tb_contrnoticedate, $CEXTN_Leaseperiod, $CEXTN_customercard, $CEXTN_rentamt, $CEXTN_tb_airquarterfee, $CEXTN_tb_fixedairfee, $CEXTN_tb_electcapfee, $CEXTN_tb_curtaindryfee, $CEXTN_tb_chkoutcleanfee, $CEXTN_profeeamt, $CEXTN_depositamt, $CEXTN_waivedvalue, $CEXTN_roomtype, $CEXTN_rent_check, "EXTENSION", $CEXTN_lb_emailid, $docowner,$CustomerFolder);
                        if($contract[0]==1) {
                            if ($CEXTN_depositamt == 'null') {
                                $CEXTN_depositamt = '';
                            }
                            if ($CEXTN_profeeamt == 'null') {
                                $CEXTN_profeeamt = '';
                            }
                            $InvoiceId = $this->Mdl_eilib_invoice_contract->CUST_invoice($UserStamp, $service, $CEXTN_unitno, $CEXTN_continvoicecustomename, $CEXTN_tb_contrcompname, $CEXTN_invoiceid, $CEXTN_invoicesno, $CEXTN_invoicedate, $CEXTN_rentamt, $CEXTN_profeeamt, $CEXTN_depositamt, $CEXTN_db_chkindate, $CEXTN_db_chkoutdate, $CEXTN_roomtype, $CEXTN_Leaseperiod, $CEXTN_rent_check, $CEXTN_lb_emailid, $docowner, 'EXTENSION', $CEXTN_waivedvalue, $CEXTN_hidden_custid,$CustomerFolder);
                            if($InvoiceId[0]==1) {
                                $subcontent = $CEXTN_unitno . '-' . $CEXTN_continvoicecustomename . '-' . $InvoiceId[3];
                                $Messcontent = $CEXTN_unitno . '-' . $CEXTN_continvoicecustomename;
                                $Emailsub = $Emailtemplate[0]['subject'];
                                $Messagebody = $Emailtemplate[0]['message'];
                                $Emailsub = str_replace('[UNIT NO - CUSTOMER NAME - INVOICE NO]', $subcontent, $Emailsub);
                                $Messagebody = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Messagebody);
                                $Messagebody = str_replace('[MAILID_USERNAME]', $Username, $Messagebody);
                                $Messagebody = $Messagebody . '<br><br>INVOICE :' . $InvoiceId[2];
                                $Messagebody = $Messagebody . '<br><br>CONTRACT :' . $contract[2];
                                $Displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('INVOICE_N_CONTRACT');
                                $this->mailpart($Emailsub,$Messagebody,$Displayname,$UserStamp,$CEXTN_lb_emailid);
                            }
                            else{
                                if($contract[1]!='undefined')
                                    $res=$this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service,$contract[1]);
                                if($InvoiceId[1]!='undefined')
                                    $res=$this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service,$InvoiceId[1]);
                                $this->db->trans_savepoint_rollback($savepoint);
                                for($ijk=0;$ijk<count($CEXTN_CALEVENTS);$ijk++){
                                    $this->Mdl_eilib_calender->CUST_customerTermcalenderdeletion($cal_service,$CEXTN_hidden_custid,$CEXTN_CALEVENTS[$ijk]['sddate'],$CEXTN_CALEVENTS[$ijk]['sdtimein'],$CEXTN_CALEVENTS[$ijk]['sdtimeout'],$CEXTN_CALEVENTS[$ijk]['eddate'],$CEXTN_CALEVENTS[$ijk]['edtimein'],$CEXTN_CALEVENTS[$ijk]['edtimeout'],"");
                                }
                                $cal_flag=$this->Mdl_eilib_calender->CTermExtn_Calevent($cal_service,$CEXTN_hidden_custid,"",$CEXTN_formname,"");
                                if($extunitfolder==1 && $extcustfolder==1) {
                                    if ($UnitFolder != '') {
                                        $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolder);
                                    }
                                    if ($CustomerFolder != '') {
                                        $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolder);
                                    }
                                }
                                $CEXTN_saveflag=$InvoiceId[3];
                            }
                        }
                        else{
                            if($contract[1]!='undefined')
                                $res=$this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service,$contract[1]);
                            $this->db->trans_savepoint_rollback($savepoint);
                            for($ijk=0;$ijk<count($CEXTN_CALEVENTS);$ijk++){
                                $this->Mdl_eilib_calender->CUST_customerTermcalenderdeletion($cal_service,$CEXTN_hidden_custid,$CEXTN_CALEVENTS[$ijk]['sddate'],$CEXTN_CALEVENTS[$ijk]['sdtimein'],$CEXTN_CALEVENTS[$ijk]['sdtimeout'],$CEXTN_CALEVENTS[$ijk]['eddate'],$CEXTN_CALEVENTS[$ijk]['edtimein'],$CEXTN_CALEVENTS[$ijk]['edtimeout'],"");
                            }
                            $cal_flag=$this->Mdl_eilib_calender->CTermExtn_Calevent($cal_service,$CEXTN_hidden_custid,"",$CEXTN_formname,"");
                            if($fileid!=''){
                                $res=$this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service,$fileid);
                            }
                            if($extunitfolder==1 && $extcustfolder==1) {
                                if ($UnitFolder != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolder);
                                }
                                if ($CustomerFolder != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolder);
                                }
                            }
                            $CEXTN_saveflag=$contract[3];
                        }
                    }
                }
                else{
                    $this->db->trans_savepoint_rollback($savepoint);
                    for($ijk=0;$ijk<count($CEXTN_CALEVENTS);$ijk++){
                        $sdate= $CEXTN_CALEVENTS[$ijk]['sddate'];
                        $sdtimein=$CEXTN_CALEVENTS[$ijk]['sdtimein'];
                        $sdtimeout=$CEXTN_CALEVENTS[$ijk]['sdtimeout'];
                        $eddate=$CEXTN_CALEVENTS[$ijk]['eddate'];
                        $edtimein=$CEXTN_CALEVENTS[$ijk]['edtimein'];
                        $edtimeout=$CEXTN_CALEVENTS[$ijk]['edtimeout'];
                        $del_flag=$this->Mdl_eilib_calender->CUST_customerTermcalenderdeletion($cal_service,$CEXTN_hidden_custid,$sdate,$sdtimein,$sdtimeout,$eddate,$edtimein,$edtimeout,"");
                    }
                    $cal_flag=$this->Mdl_eilib_calender->CTermExtn_Calevent($cal_service,$CEXTN_hidden_custid,"",$CEXTN_formname,"",'');
                    if($fileid!=''){
                        $res=$this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service,$fileid);
                    }
                    if($extunitfolder==1 && $extcustfolder==1) {
                        if ($UnitFolder != '') {
                            $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolder);
                        }
                        if ($CustomerFolder != '') {
                            $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolder);
                        }
                    }
                    $CEXTN_saveflag=0;
                }
                $this->db->trans_savepoint_release($savepoint);
            }
            else{
                $this->db->trans_savepoint_rollback($savepoint);
            }
            $this->CEXTN_DropTempTables($CEXTN_finalarr[1]);
            return [$CEXTN_saveflag,$CEXTN_finalarr[2],$cal_flag];
        }
        catch(Exception $err)
        {
            $this->db->trans_savepoint_rollback($savepoint);
        }
    }

//    FUNCTION TO GET FLAG N TEMP TABLES
    function CEXTN_ReturnFlagGetExtnFormTempTables(){
        $CEXTN_Temptablearray=array();
        $saveflag_query="SELECT @EXTNFLAG as EXTNFLAG,@TEMP_OUT_EXT_CARNOTBLNAME as TEMP_OUT_EXT_CARNOTBLNAME,@TEMP_OUT_EXTN_CLPDTLSTTBLNAME as TEMP_OUT_EXTN_CLPDTLSTTBLNAME,@TEMP_OUT_EXTN_FEEDTLTBLNAME as TEMP_OUT_EXTN_FEEDTLTBLNAME,@PAY_CHK_MSG as PAY_CHK_MSG,@SAVE_POINT_NAME as SAVE_POINT";
        $saveflag_rs=$this->db->query($saveflag_query);
        $CEXTN_saveflag=0;
        $CEXTN_paymsg=null;
        $CEXTN_saveflag=$saveflag_rs->row()->EXTNFLAG;//saveflag_rs.getString(1);
        if($saveflag_rs->row()->TEMP_OUT_EXT_CARNOTBLNAME!=null&&$saveflag_rs->row()->TEMP_OUT_EXT_CARNOTBLNAME!='undefined'&&$saveflag_rs->row()->TEMP_OUT_EXT_CARNOTBLNAME!="")
        {
            $CEXTN_Temptablearray[]=($saveflag_rs->row()->TEMP_OUT_EXT_CARNOTBLNAME);
        }
        if($saveflag_rs->row()->TEMP_OUT_EXTN_CLPDTLSTTBLNAME!=null&&$saveflag_rs->row()->TEMP_OUT_EXTN_CLPDTLSTTBLNAME!='undefined'&&$saveflag_rs->row()->TEMP_OUT_EXTN_CLPDTLSTTBLNAME!="")
        {
            $CEXTN_Temptablearray[]=($saveflag_rs->row()->TEMP_OUT_EXTN_CLPDTLSTTBLNAME);
        }
        if($saveflag_rs->row()->TEMP_OUT_EXTN_FEEDTLTBLNAME!=null&&$saveflag_rs->row()->TEMP_OUT_EXTN_FEEDTLTBLNAME!='undefined'&&$saveflag_rs->row()->TEMP_OUT_EXTN_FEEDTLTBLNAME!="")
        {
            $CEXTN_Temptablearray[]=($saveflag_rs->row()->TEMP_OUT_EXTN_FEEDTLTBLNAME);
        }
        $CEXTN_paymsg=$saveflag_rs->row()->PAY_CHK_MSG;
        $CEXTN_savepoint=$saveflag_rs->row()->SAVE_POINT;
        $CEXTN_finalflagtemparray=[$CEXTN_saveflag,$CEXTN_Temptablearray,$CEXTN_paymsg,$CEXTN_savepoint];
        return $CEXTN_finalflagtemparray;
    }
    //    FUNCTION TO DROP TEMP TABLES
    function CEXTN_DropTempTables($CEXTN_Temptablearray){
        for($t=0;$t<count($CEXTN_Temptablearray);$t++){
            $drop_query = "DROP TABLE ".$CEXTN_Temptablearray[$t];
            $this->db->query($drop_query);
        }
    }
    public function mailpart($mailsub,$mailbody,$Displayname,$UserStamp,$Sendmailid)
    {
        $message1 = new Message();
        $message1->setSender($Displayname.'<'.$UserStamp.'>');
        $message1->addTo($Sendmailid);
        $message1->setSubject($mailsub);
        $message1->setHtmlBody($mailbody);
        $message1->send();

    }
}