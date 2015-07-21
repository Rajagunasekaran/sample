<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 20/5/15
 * Time: 3:45 PM
 */

class Mdl_customer_cancel_uncancel extends CI_Model {

    public function CCAN_getcustomer(){
        $CCAN_cust_values='';
        $CCAN_select_cust_values=$this->db->query("SELECT * FROM VW_CANCEL_CUSTOMER UNION SELECT * FROM VW_UNCANCEL_CUSTOMER");
        if($CCAN_select_cust_values->num_rows() > 0){
          $CCAN_cust_values='true';
        }
        else{
          $CCAN_cust_values='false';
        }
        $CCAN_select_err_msg='44,90,248,328,330,401,458';
        $this->load->model("EILIB/Mdl_eilib_common_function");
        $CCAN_errorAarray=$this->Mdl_eilib_common_function->getErrorMessageList($CCAN_select_err_msg);
        $CCAN_initial_values_array=array();
        $CCAN_initial_values=(object)['CCAN_error_msg'=>$CCAN_errorAarray,'CCAN_cust_values'=>$CCAN_cust_values];
        $CCAN_initial_values_array=[$CCAN_initial_values];
        return $CCAN_initial_values_array;
    }
            //*************FUNCTION TO RETURN UNIT NO  *************************//
    public  function CCAN_getcustomer_details($CCAN_select_type){
        return $this->CCAN_allcustomerdetails($CCAN_select_type);
    }
    public function CCAN_allcustomerdetails($CCAN_select_type){

        $CCAN_customer_array =array();
        if($CCAN_select_type=="CANCEL CUSTOMER"){
           $CCAN_allcancelunit="SELECT UNIT_NO,CUSTOMER_ID,CUSTOMERNAME,CED_REC_VER FROM VW_CANCEL_CUSTOMER ORDER BY UNIT_NO ASC,CUSTOMERNAME ASC";
        }
        else{
          $CCAN_allcancelunit="SELECT UNIT_NO,CUSTOMER_ID,CUSTOMERNAME,CED_REC_VER FROM VW_UNCANCEL_CUSTOMER ORDER BY UNIT_NO ASC,CUSTOMERNAME ASC";
        }
        $CCAN_customerresult = $this->db->query($CCAN_allcancelunit);
        foreach($CCAN_customerresult->result_array() as $row){
            $CCAN_customer_array[]=(object)['unit'=>$row["UNIT_NO"],'customerid'=>$row["CUSTOMER_ID"],'name'=>$row["CUSTOMERNAME"],'recver'=>$row["CED_REC_VER"]];
        }
        return $CCAN_customer_array;
    }

    //*************************** FUNCTION TO GET CUSTOMER DETAIL'S*****************************************************//
    public function CCAN_get_customervalues($id,$CCAN_select_type,$CCAN_recver,$USERSTAMP){
        $CCAN_custid=$id;
        $CCAN_guest_array=array();
        $CCAN_select_roomtype=$this->db->query('SELECT URTD.URTD_ROOM_TYPE FROM UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER_ENTRY_DETAILS CED WHERE (CED.CUSTOMER_ID='.$CCAN_custid.') AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID) AND(CED.CED_REC_VER='.$CCAN_recver.')');
        $CCAN_roomtype = $CCAN_select_roomtype->row()->URTD_ROOM_TYPE;
        $callquery="CALL SP_CUSTOMER_CANCEL_TEMP_FEE_DETAIL(".$CCAN_custid.",'".$USERSTAMP."',@CCAN_FEETMPTBLNAM)";
        $this->db->query($callquery);
        $CCAN_feetemptbl_query = 'SELECT @CCAN_FEETMPTBLNAM AS TEMP_TABLE';
        $outparm_result = $this->db->query($CCAN_feetemptbl_query);
        $CCAN_temptblname=$outparm_result->row()->TEMP_TABLE;
        if($CCAN_select_type=="CANCEL CUSTOMER"){
            $this->db->select();
            $this->db->from('CUSTOMER_ENTRY_DETAILS CED,NATIONALITY_CONFIGURATION NC ,UNIT U');
            $this->db->join('CUSTOMER_COMPANY_DETAILS CCD',' CED.CUSTOMER_ID=CCD.CUSTOMER_ID','left');
            $this->db->join('CUSTOMER_LP_DETAILS CLP','CED.CUSTOMER_ID=CLP.CUSTOMER_ID','left');
            $this->db->join('CUSTOMER_ACCESS_CARD_DETAILS CACD','CED.CUSTOMER_ID=CACD.CUSTOMER_ID AND CLP.UASD_ID=CACD.UASD_ID','left');
            $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD','UASD.UASD_ID=CACD.UASD_ID','left');
            $this->db->join($CCAN_temptblname.' CF','CED.CUSTOMER_ID=CF.CUSTOMER_ID','left');
            $this->db->join('CUSTOMER C','CED.CUSTOMER_ID=C.CUSTOMER_ID','left');
            $this->db->join('CUSTOMER_PERSONAL_DETAILS CPD','CED.CUSTOMER_ID=CPD.CUSTOMER_ID','left');
            $this->db->where('(CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='.$CCAN_custid.') and (CPD.NC_ID=NC.NC_ID) and (CLP.CLP_TERMINATE IS NULL) and  (CED.CED_REC_VER=CF.CUSTOMER_VER)  and (CED.CED_REC_VER='.$CCAN_recver.') AND CED.CED_REC_VER=CLP.CED_REC_VER');
            $this->db->order_by('CED.CED_REC_VER');
            $CCAN_alldata=$this->db->get();

        }
        if($CCAN_select_type=="UNCANCEL CUSTOMER"){
            //            $this->db->select();
            //            $this->db->from('CUSTOMER_ENTRY_DETAILS CED,NATIONALITY_CONFIGURATION NC ,UNIT U');
            //            $this->db->join('CUSTOMER_COMPANY_DETAILS CCD',' CED.CUSTOMER_ID=CCD.CUSTOMER_ID','left');
            //            $this->db->join('CUSTOMER_LP_DETAILS CLP','CED.CUSTOMER_ID=CLP.CUSTOMER_ID','left');
            //            $this->db->join('CUSTOMER_ACCESS_CARD_DETAILS CACD','CED.CUSTOMER_ID=CACD.CUSTOMER_ID AND CACD.ACN_ID is null AND CLP.UASD_ID=CACD.UASD_ID','left');
            //            $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD','UASD.UASD_ID=CACD.UASD_ID','left');
            //            $this->db->join($CCAN_temptblname.' CF','CED.CUSTOMER_ID=CF.CUSTOMER_ID','left');
            //            $this->db->join('CUSTOMER C','CED.CUSTOMER_ID=C.CUSTOMER_ID','left');
            //            $this->db->join('CUSTOMER_PERSONAL_DETAILS CPD','CED.CUSTOMER_ID=CPD.CUSTOMER_ID','left');
            //            $this->db->where('(CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='.$CCAN_custid.') and (CPD.NC_ID=NC.NC_ID) and CLP.CLP_TERMINATE IS NULL  and  (CED.CED_REC_VER=CF.CUSTOMER_VER) and (CED.CED_CANCEL_DATE is not null)  and(CED.CED_REC_VER='.$CCAN_recver.') AND CED.CED_REC_VER=CLP.CED_REC_VER');
            //           $this->db->order_by('CED.CED_REC_VER');
            $CCAN_alldata=("SELECT  * FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD on CED.CUSTOMER_ID=CCD.CUSTOMER_ID left join CUSTOMER_LP_DETAILS CLP on CED.CUSTOMER_ID=CLP.CUSTOMER_ID left join CUSTOMER_ACCESS_CARD_DETAILS CACD on CED.CUSTOMER_ID=CACD.CUSTOMER_ID and (CLP.UASD_ID=CACD.UASD_ID) AND CACD.ACN_ID IS NULL left join UNIT_ACCESS_STAMP_DETAILS UASD on  (UASD.UASD_ID=CACD.UASD_ID) left join ".$CCAN_temptblname." CF on  CED.CUSTOMER_ID=CF.CUSTOMER_ID left join CUSTOMER C on CED.CUSTOMER_ID=C.CUSTOMER_ID left join  CUSTOMER_PERSONAL_DETAILS CPD on CED.CUSTOMER_ID=CPD.CUSTOMER_ID ,NATIONALITY_CONFIGURATION NC ,UNIT U  where   (CED.UNIT_ID=U.UNIT_ID)AND (CED.CUSTOMER_ID=".$CCAN_custid.") and(CPD.NC_ID=NC.NC_ID)and(CLP.CLP_TERMINATE is null) and (CED.CED_CANCEL_DATE is not null) and  (CED.CED_REC_VER=CF.CUSTOMER_VER)  and(CED.CED_REC_VER=".$CCAN_recver.") AND CED.CED_REC_VER=CLP.CED_REC_VER  order by CED.CED_REC_VER ");
            $CCAN_alldata=$this->db->query($CCAN_alldata);

        }
        $CCAN_cardno='';
        foreach($CCAN_alldata->result_array() as $row){
              $CCAN_cardno2 = $row["UASD_ACCESS_CARD"];
              if($CCAN_cardno2!=null){
                 $CCAN_guest = $row["CLP_GUEST_CARD"];
                 if($CCAN_guest!='X'){
                    $CCAN_cardno = $row["UASD_ACCESS_CARD"];
                    $CCAN_startdate = $row["CLP_STARTDATE"];
                    $CCAN_enddate = $row["CLP_ENDDATE"];
                 }
                 else{
                    $CCAN_cardno1 = $row["UASD_ACCESS_CARD"];
                    $CCAN_guest_array[]=($CCAN_cardno1);
                 }
              }
              else{
                 $CCAN_startdate = $row["CLP_STARTDATE"];
                 $CCAN_enddate = $row["CLP_ENDDATE"];
              }
              $CCAN_company = $row["CCD_COMPANY_NAME"];
              $CCAN_firstname = $row["CUSTOMER_FIRST_NAME"];
              $CCAN_lastname = $row["CUSTOMER_LAST_NAME"];
              $CCAN_deposit = $row["CC_DEPOSIT"];
              $CCAN_rental = $row["CC_PAYMENT_AMOUNT"];
              $CCAN_electricitycap = $row["CC_ELECTRICITY_CAP"];
              $CCAN_airconfixedfee = $row["CC_AIRCON_FIXED_FEE"];
              $CCAN_airconquartelyfee = $row["CC_AIRCON_QUARTERLY_FEE"];
              $CCAN_epno = $row["CPD_EP_NO"];
              $CCAN_epdate = $row["CPD_EP_DATE"];
              $CCAN_passportno = $row["CPD_PASSPORT_NO"];
              $CCAN_passportdate = $row["CPD_PASSPORT_DATE"];
              $CCAN_drycleanfee = $row["CC_DRYCLEAN_FEE"];
              $CCAN_processingfee = $row["CC_PROCESSING_FEE"];
              $CCAN_checkoutcleaningfee = $row["CC_CHECKOUT_CLEANING_FEE"];
              $CCAN_noticeperiod = $row["CED_NOTICE_PERIOD"];
              $CCAN_noticedate = $row["CED_NOTICE_START_DATE"];
              $CCAN_nationality = $row["NC_DATA"];
              $CCAN_dob= $row["CPD_DOB"];
              $CCAN_lease=$row["CED_LEASE_PERIOD"];
              $CCAN_mobile = $row["CPD_MOBILE"];
              $CCAN_mobile1 = $row["CPD_INTL_MOBILE"];
              $CCAN_officeno = $row["CCD_OFFICE_NO"];
              $CCAN_email = $row["CPD_EMAIL"];
              $CCAN_extension= $row["CED_EXTENSION"];
              $CCAN_redver = $row["CED_REC_VER"];
              $CCAN_canceldate = $row["CED_CANCEL_DATE"];
              $CCAN_comments = $row["CPD_COMMENTS"];
              $CCAN_QUARTERS=$row["CED_QUARTERS"];
        }
        $values_array=(object)['firstname'=>$CCAN_firstname,'lastname'=>$CCAN_lastname,'email'=>$CCAN_email,'mobile1'=>$CCAN_mobile,'mobile2'=>$CCAN_mobile1,'officeno'=>$CCAN_officeno,'dob'=>$CCAN_dob,'passportno'=>$CCAN_passportno,'passportdate'=>$CCAN_passportdate,'epno'=>$CCAN_epno,'epdate'=>$CCAN_epdate,'roomtype'=>$CCAN_roomtype,'cardno'=>$CCAN_cardno,'startdate'=>$CCAN_startdate,'enddate'=>$CCAN_enddate,'lease'=>$CCAN_lease,'QUARTERS'=>$CCAN_QUARTERS,'noticeperiod'=>$CCAN_noticeperiod,'noticedate'=>$CCAN_noticedate,'electricitycap'=>$CCAN_electricitycap,'drycleanfee'=>$CCAN_drycleanfee,'checkoutcleaningfee'=>$CCAN_checkoutcleaningfee,'deposit'=>$CCAN_deposit,'rental'=>$CCAN_rental,'processingfee'=>$CCAN_processingfee,'comments'=>$CCAN_comments,'company'=>$CCAN_company,'nationality'=>$CCAN_nationality,'airconfixedfee'=>$CCAN_airconfixedfee,'airconquartelyfee'=>$CCAN_airconquartelyfee];
        $CCAN_guest_array=array_values(array_unique($CCAN_guest_array));
        $CCAN_data_array=array();
        $CCAN_data_array[]=($values_array);
        $CCAN_data_array[]=($CCAN_guest_array);
        $drop_query = "DROP TABLE ".$CCAN_temptblname;
        $this->db->query($drop_query);
        return $CCAN_data_array;
    }

//    Function to cancel customer
  public function CCAN_cancel($UserStamp,$custid,$recver,$CCAN_unitnumber,$CCAN_tb_firstname,$CCAN_tb_lastname,$CCAN_ta_comments,$cal_service){
      try{
          $cal_flag='';
          $this->load->model('EILIB/Mdl_eilib_calender');
          $CCAN_unit_value=$CCAN_unitnumber;
          $CCAN_firstname = $CCAN_tb_firstname;
          $CCAN_lastname  = $CCAN_tb_lastname;
          $CCAN_comments_fetch = $CCAN_ta_comments;
          $card_array=array();
          $CCAN_custid=$custid;
          $CCAN_rec_ver=$recver;
          $CCAN_userStamp=$UserStamp;
          if($CCAN_comments_fetch!=''){
             $CCAN_comments_fetch=$this->db->escape_like_str($CCAN_comments_fetch);
          }
          $type="CANCEL";
          $this->db->query('SET AUTOCOMMIT=0');
          $this->db->query('START TRANSACTION');
         $CCAN_save=("CALL SP_CUSTOMER_CANCEL_INSERT(".$CCAN_custid.",".$CCAN_rec_ver.",'".$UserStamp."','".$CCAN_comments_fetch."',@cancel_temptable1,@cancel_temptable2,@cancel_flag,@SAVE_POINT)");
         $this->db->query($CCAN_save);
         $CCAN_getresult=("SELECT @cancel_temptable1 as cancel_temptable1,@cancel_temptable2 as cancel_temptable2,@cancel_flag as cancel_flag,@SAVE_POINT as SAVE_POINT");
         $CCAN_getresult_rs = $this->db->query($CCAN_getresult);
         $CCAN_temptable1=$CCAN_getresult_rs->row()->cancel_temptable1;
         $CCAN_temptable2=$CCAN_getresult_rs->row()->cancel_temptable2;
         $CCAN_chkcancelflag=$CCAN_getresult_rs->row()->cancel_flag;
          $save_point=$CCAN_getresult_rs->row()->SAVE_POINT;
         if($CCAN_chkcancelflag==1){ //change $CCAN_chkcancelflag==0 for roll back check
            $CCAN_customerevent=$this->db->query("SELECT CED.CUSTOMER_ID, b.CTP_DATA as CED_SD_STIME, c.CTP_DATA as CED_SD_ETIME, d.CTP_DATA as CED_ED_STIME ,e.CTP_DATA as CED_ED_ETIME ,CLP.CLP_STARTDATE,CLP.CLP_ENDDATE FROM CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE b ON CED.CED_SD_STIME = b.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE c ON CED.CED_SD_ETIME = c.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE d ON CED.CED_ED_STIME = d.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE e ON CED.CED_ED_ETIME = e.CTP_ID ,CUSTOMER_LP_DETAILS CLP  WHERE    (CED.CUSTOMER_ID=".$CCAN_custid.")AND (CLP.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CLP.CED_REC_VER) AND (CLP.CLP_GUEST_CARD IS NULL) and CED.CED_REC_VER>=".$CCAN_rec_ver." AND CLP.CLP_TERMINATE IS NULL");
             foreach( $CCAN_customerevent->result_array() as $row){
                 $CCAN_checkin_date = $row["CLP_STARTDATE"];
                 $CCAN_checkout_date = $row["CLP_ENDDATE"];
                 $CCAN_start_time_in=$row["CED_SD_STIME"];
                 $CCAN_start_time_out=$row["CED_SD_ETIME"];
                 $CCAN_end_time_in=$row["CED_ED_STIME"];
                 $CCAN_end_time_out=$row["CED_ED_ETIME"];
               $cal_flag=$this->Mdl_eilib_calender->CUST_customercalenderdeletion($cal_service,$CCAN_custid,$CCAN_checkin_date,$CCAN_start_time_in,$CCAN_start_time_out,$CCAN_checkout_date,$CCAN_end_time_in,$CCAN_end_time_out,'');
             }
         }
         else{
             $this->db->trans_savepoint_rollback($save_point);
         }
          if($cal_flag==1){ //change $cal_flag==0 for roll back check
              $this->db->trans_savepoint_release($save_point) ;
          }
          else{
              $this->db->trans_savepoint_rollback($save_point);
          }
          if($CCAN_temptable1!=null){
          $this->DropTempTable($CCAN_temptable1);
          }
          if($CCAN_temptable1!=null){
          $this->DropTempTable($CCAN_temptable2);
          }
          $final_value=[$CCAN_chkcancelflag,$cal_flag];
          return $final_value;
      }
      catch(Exception $err){
          $this->db->trans_savepoint_rollback($save_point);
          if($CCAN_temptable1!=null){
              $this->DropTempTable($CCAN_temptable1);
          }
          if($CCAN_temptable1!=null){
              $this->DropTempTable($CCAN_temptable2);
          }
       }
  }
    //Function to Uncancel customer
  public function CCAN_uncancel($UserStamp,$custid,$recver,$CCAN_unitnumber,$CCAN_tb_firstname,$CCAN_tb_lastname,$CCAN_ta_comments,$cal_service,$CCAN_tb_roomtype){
        $cal_flag='';
        try{
            $CCAN_unit_value=$CCAN_unitnumber;
            $CCAN_firstname = $CCAN_tb_firstname;
            $CCAN_lastname  = $CCAN_tb_lastname;
            $CCAN_comments_fetch = $CCAN_ta_comments;
            $CCAN_roomType=$CCAN_tb_roomtype;
            $CCAN_custid=$custid;
            $CCAN_rec_ver=$recver;
            $CCAN_userStamp=$UserStamp;
            $CCAN_customerevent="SELECT  URTD.URTD_ROOM_TYPE,U.UNIT_NO,CPD.CPD_EMAIL,CCD.CCD_OFFICE_NO,CLP.CLP_STARTDATE,CLP.CLP_ENDDATE,CED.CED_REC_VER,CED.CED_CANCEL_DATE,CED.CUSTOMER_ID, b.CTP_DATA as CED_SD_STIME, c.CTP_DATA as CED_SD_ETIME, d.CTP_DATA as CED_ED_STIME ,e.CTP_DATA as CED_ED_ETIME,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE b ON CED.CED_SD_STIME = b.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE c ON CED.CED_SD_ETIME = c.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE d ON CED.CED_ED_STIME = d.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE e ON CED.CED_ED_ETIME = e.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CLP,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U  WHERE  CED.UNIT_ID=U.UNIT_ID AND (CED.CUSTOMER_ID=".$CCAN_custid.")AND (CLP.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CLP.CED_REC_VER) AND (CLP.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS  NOT NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)and CED.CED_REC_VER>=".$CCAN_rec_ver." order by CED.CED_REC_VER";
            $CCAN_custeventrs = $this->db->query($CCAN_customerevent);
            $count=0;
            $type='UNCANCEL';
            $lease_period_array=array();
            $quaters_array=array();
            $recver_array=array();
            $cancel_date_array=array();
            $unit_no_array=array();
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $this->load->model('EILIB/Mdl_eilib_calender');
            $this->load->model('EILIB/Mdl_eilib_quarter_calc');
            foreach($CCAN_custeventrs->result_array() as $row){
               $CCAN_checkin_date = $row["CLP_STARTDATE"];
               $CCAN_checkout_date = $row["CLP_ENDDATE"];
               $recver=$row["CED_REC_VER"];
               $CCAN_Leaseperiod=$this->Mdl_eilib_common_function->getLeasePeriod($CCAN_checkin_date,$CCAN_checkout_date);
               $CCAN_quators=$this->Mdl_eilib_quarter_calc->quarterCalc(new DateTime($CCAN_checkin_date), new DateTime($CCAN_checkout_date));
               $lease_period_array[]=($CCAN_Leaseperiod);
               $quaters_array[]=($CCAN_quators);
               $recver_array[]=($recver);
            }
            $lease_quaters='';
            for($k=0;$k<count($recver_array);$k++){
                $lease_quaters.=$recver_array[$k].',&'.$lease_period_array[$k].',&'.$quaters_array[$k];
                   if($k==count($recver_array)-1)break;
                         $lease_quaters.=',&';
            }
            if($CCAN_comments_fetch!=''){
                $CCAN_comments_fetch=$this->db->escape_like_str($CCAN_comments_fetch);
            }
            $this->db->query('SET AUTOCOMMIT=0');
            $this->db->query('START TRANSACTION');
            $CCAN_save=("CALL SP_CUSTOMER_UNCANCEL_INSERT(".$CCAN_custid.",".$CCAN_rec_ver.",'".$CCAN_comments_fetch."','".$lease_quaters."','".$UserStamp."',@uncancel_temptable1,@uncancel_temptable2,@uncancel_temptable3,@uncancel_temptable4,@uncancel_flag,@SAVE_POINT)");
            $this->db->query($CCAN_save);
            $CCAN_getresult= ("SELECT @uncancel_temptable1 as uncancel_temptable1,@uncancel_temptable2 as uncancel_temptable2,@uncancel_temptable3 as uncancel_temptable3,@uncancel_temptable4 as uncancel_temptable4,@uncancel_flag as uncancel_flag,@SAVE_POINT as savepoint");
            $CCAN_getresult_rs=$this->db->query($CCAN_getresult);
            $CCAN_uncancel_temptable1=$CCAN_getresult_rs->row()->uncancel_temptable1;
            $CCAN_uncancel_temptable2=$CCAN_getresult_rs->row()->uncancel_temptable2;
            $CCAN_uncancel_temptable3=$CCAN_getresult_rs->row()->uncancel_temptable3;
            $CCAN_uncancel_temptable4=$CCAN_getresult_rs->row()->uncancel_temptable4;
            $CCAN_chkuncancelflag=$CCAN_getresult_rs->row()->uncancel_flag;
            $savepoint=$CCAN_getresult_rs->row()->savepoint;
            if($CCAN_chkuncancelflag==1){ //change $CCAN_chkuncancelflag==0 for roll back check
                 $CCAN_customerevent="SELECT  URTD.URTD_ROOM_TYPE,U.UNIT_NO,CPD.CPD_EMAIL,CCD.CCD_OFFICE_NO,CLP.CLP_STARTDATE,CLP.CLP_ENDDATE,CED.CED_REC_VER,CED.CED_CANCEL_DATE,CED.CUSTOMER_ID, b.CTP_DATA as CED_SD_STIME, c.CTP_DATA as CED_SD_ETIME, d.CTP_DATA as CED_ED_STIME ,e.CTP_DATA as CED_ED_ETIME,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE b ON CED.CED_SD_STIME = b.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE c ON CED.CED_SD_ETIME = c.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE d ON CED.CED_ED_STIME = d.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE e ON CED.CED_ED_ETIME = e.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CLP,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U  WHERE  CED.UNIT_ID=U.UNIT_ID AND (CED.CUSTOMER_ID=".$CCAN_custid.")AND (CLP.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CLP.CED_REC_VER) AND (CLP.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)and CED.CED_REC_VER>=".$CCAN_rec_ver." order by CED.CED_REC_VER";
                 $CCAN_custeventrs=$this->db->query($CCAN_customerevent);
                 $count=0;
                 $type='UNCANCEL';
                 $cancel_date_array=array();
                 $unit_no_array=array();
                 foreach($CCAN_custeventrs->result_array() as $row){
                    $count++;
                    $CCAN_checkin_date = $row["CLP_STARTDATE"];
                    $CCAN_checkout_date = $row["CLP_ENDDATE"];
                    $recver=$row["CED_REC_VER"];
                    $CCAN_CANCEL_date=$row["CED_CANCEL_DATE"];
                    $cancel_date_array[]=($CCAN_CANCEL_date);
                    $CCAN_start_time_in=$row["CED_SD_STIME"];
                    $CCAN_start_time_out=$row["CED_SD_ETIME"];
                    $CCAN_end_time_in=$row["CED_ED_STIME"];
                    $CCAN_end_time_out=$row["CED_ED_ETIME"];
                    $CCAN_mobile=$row["CPD_MOBILE"];
                    $CCAN_intmoblie=$row["CPD_INTL_MOBILE"];
                    $CCAN_office=$row["CCD_OFFICE_NO"];
                    $CCAN_emailid=$row["CPD_EMAIL"];
                    $CCAN_unitno=$row["UNIT_NO"];
                    $unit_no_array[]=($CCAN_unitno);
                    $CCAN_roomtype=$row["URTD_ROOM_TYPE"];
                    if($CCAN_unitno==$CCAN_unit_value && $CCAN_roomtype==$CCAN_roomType){
                       if($count==1){
                         $cal_flag=$this->Mdl_eilib_calender->CUST_customercalendercreation('',$cal_service,$CCAN_custid,$CCAN_checkin_date,$CCAN_start_time_in,$CCAN_start_time_out,$CCAN_checkout_date,$CCAN_end_time_in,$CCAN_end_time_out,$CCAN_firstname,$CCAN_lastname,$CCAN_mobile,$CCAN_intmoblie,$CCAN_office,$CCAN_emailid,$CCAN_unitno,$CCAN_roomtype,"");
                         $cal_flag= $this->Mdl_eilib_calender->CUST_customercalenderdeletion($cal_service,$CCAN_custid,'','','',$CCAN_checkout_date,$CCAN_end_time_in,$CCAN_end_time_out,$type);
                       }
                       else{
                         $cal_flag=$this->Mdl_eilib_calender->CUST_customercalendercreation('',$cal_service,$CCAN_custid,$CCAN_checkin_date,$CCAN_start_time_in,$CCAN_start_time_out,$CCAN_checkout_date,$CCAN_end_time_in,$CCAN_end_time_out,$CCAN_firstname,$CCAN_lastname,$CCAN_mobile,$CCAN_intmoblie,$CCAN_office,$CCAN_emailid,$CCAN_unitno,$CCAN_roomtype,"");
                          $this->Mdl_eilib_calender->CUST_customercalenderdeletion($cal_service,$CCAN_custid,'','','',$CCAN_checkout_date,$CCAN_end_time_in,$CCAN_end_time_out,$type);
                       }
                    }
                    if($CCAN_roomtype!=$CCAN_roomType&&$CCAN_unitno==$CCAN_unit_value){
                       $CCAN_custunittype="DIFF RM";
                       $this->Mdl_eilib_calender->CUST_customercalenderdeletion($cal_service,$CCAN_custid,$CCAN_checkin_date,$CCAN_start_time_in,$CCAN_start_time_out,'','','',$type);
                       $this->Mdl_eilib_calender->CUST_customercalendercreation('',$cal_service,$CCAN_custid,$CCAN_checkin_date,$CCAN_start_time_in,$CCAN_start_time_out,$CCAN_checkout_date,$CCAN_end_time_in,$CCAN_end_time_out,$CCAN_firstname,$CCAN_lastname,$CCAN_mobile,$CCAN_intmoblie,$CCAN_office,$CCAN_emailid,$CCAN_unitno,$CCAN_roomtype,$CCAN_custunittype);
                    }
                    if($CCAN_unitno!=$CCAN_unit_value){
                       $CCAN_custunittype="DIFF UNIT";
                        $this->Mdl_eilib_calender->CUST_customercalenderdeletion($cal_service,$CCAN_custid,$CCAN_checkin_date,$CCAN_start_time_in,$CCAN_start_time_out,'','','',$type);
                       $cal_flag=$this->Mdl_eilib_calender->CUST_customercalendercreation('',$cal_service,$CCAN_custid,$CCAN_checkin_date,$CCAN_start_time_in,$CCAN_start_time_out,$CCAN_checkout_date,$CCAN_end_time_in,$CCAN_end_time_out,$CCAN_firstname,$CCAN_lastname,$CCAN_mobile,$CCAN_intmoblie,$CCAN_office,$CCAN_emailid,$CCAN_unitno,$CCAN_roomtype,$CCAN_custunittype);
                    }
                 }
                 if($count==1){
                   $cal_flag=$this->Mdl_eilib_calender->CUST_customercalendercreation('',$cal_service,$CCAN_custid,'','','',$CCAN_checkout_date,$CCAN_end_time_in,$CCAN_end_time_out,$CCAN_firstname,$CCAN_lastname,$CCAN_mobile,$CCAN_intmoblie,$CCAN_office,$CCAN_emailid,$CCAN_unitno,$CCAN_roomtype,'');
                 }

            }
            else{
                $this->db->trans_savepoint_rollback($savepoint);
            }
            if($CCAN_uncancel_temptable1!=null){
               $this->DropTempTable($CCAN_uncancel_temptable1);
            }
            if($CCAN_uncancel_temptable2!=null){
              $this->DropTempTable($CCAN_uncancel_temptable2);
            }
            if($CCAN_uncancel_temptable3!=null){
              $this->DropTempTable($CCAN_uncancel_temptable3);
            }
            if($CCAN_uncancel_temptable4!=null){
              $this->DropTempTable($CCAN_uncancel_temptable4);
            }
            if($cal_flag==1){ //change $cal_flag==0 for roll back check
                $this->db->trans_savepoint_release($savepoint) ;
            }
            else{
                $this->db->trans_savepoint_rollback($savepoint);
            }
            $final_value=[$CCAN_chkuncancelflag,$cal_flag];
            return $final_value;

        }
        catch(Exception $err){
            $this->db->trans_savepoint_rollback($savepoint);
            if($CCAN_uncancel_temptable1!=null){
                $this->DropTempTable($CCAN_uncancel_temptable1);
            }
            if($CCAN_uncancel_temptable2!=null){
                $this->DropTempTable($CCAN_uncancel_temptable2);
            }
            if($CCAN_uncancel_temptable3!=null){
                $this->DropTempTable($CCAN_uncancel_temptable3);
            }
            if($CCAN_uncancel_temptable4!=null){
                $this->DropTempTable($CCAN_uncancel_temptable4);
            }
            return $err->getMessage();
        }
  }

  function DropTempTable($CCAN_uncancel_temptable){
      $drop_query = "DROP TABLE ".$CCAN_uncancel_temptable;
      $this->db->query($drop_query);
  }
} 