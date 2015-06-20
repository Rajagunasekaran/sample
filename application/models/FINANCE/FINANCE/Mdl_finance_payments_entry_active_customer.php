<?php
class Mdl_finance_payments_entry_active_customer extends CI_Model {
   public function FinanceEntrySave($unit,$customerid,$lp,$paymenttype,$amount,$forperiod,$paiddate,$Comments,$flag,$UserStamp)
   {
    $unitnos;$Customerids;$lps;$paymentypes;$amounts;$periods;$paiddates;$comments;$flags;
     for($i=0;$i<count($unit);$i++)
     {
         if($i==0)
         {
             $unitnos=$unit[$i];
             $Customerids=$customerid[$i];
             $lps=$lp[$i];
             $paymenttypes=$paymenttype[$i];
             $amounts=$amount[$i];
             $periods=$forperiod[$i];
             $paiddates=date('Y-m-d',strtotime($paiddate[$i]));
             $comments=$this->db->escape_like_str($Comments[$i]);
             $flags=$flag[$i];
         }
         else
         {
             $unitnos=$unitnos.','.$unit[$i];
             $Customerids=$Customerids.','.$customerid[$i];
             $lps=$lps.','.$lp[$i];
             $paymenttypes=$paymenttypes.','.$paymenttype[$i];
             $amounts=$amounts.','.$amount[$i];
             $periods=$periods.','.$forperiod[$i];
             $paiddates=$paiddates.','.date('Y-m-d',strtotime($paiddate[$i]));
             $comments=$comments.'^^'.$this->db->escape_like_str($Comments[$i]);
             $flags=$flags.','.$flag[$i];
         }
     }
       $FIN_ENTRY_query="CALL SP_PAYMENT_DETAIL_INSERT('$unitnos','$Customerids','$paymenttypes','$lps','$amounts','$periods','$paiddates','$flags','$comments','$UserStamp',null,@OUTPUT_FINAL_MESSAGE)";
       $this->db->query($FIN_ENTRY_query);
       $Confirm_query = 'SELECT @OUTPUT_FINAL_MESSAGE AS CONFIRM';
       $Confirm_result = $this->db->query($Confirm_query);
       $Confirm_Meessage=$Confirm_result->row()->CONFIRM;
       $this->db->query("COMMIT");
       return $Confirm_Meessage;
   }
   public function getSearchOption()
   {
       $this->db->select('PCN_ID,PCN_DATA');
       $this->db->from('PAYMENT_CONFIGURATION');
       $this->db->order_by("PCN_DATA", "ASC");
       $this->db->where('CGN_ID=58');
       $query = $this->db->get();
       return $query->result();
   }
    public function getUnitCustomer($unit)
    {
        $this->db->select('C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME');
        $this->db->from('CUSTOMER_ENTRY_DETAILS CED,CUSTOMER C,UNIT U');
        $this->db->order_by("CUSTOMER_FIRST_NAME", "ASC");
        $this->db->where('C.CUSTOMER_ID=CED.CUSTOMER_ID AND U.UNIT_ID=CED.UNIT_ID AND U.UNIT_NO='.$unit);
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
   public function getSearchResults($Option,$unit,$customer,$Fromdate,$Todate,$fromamount,$toamount,$UserStamp,$timeZoneFormat)
   {
       if($Option==2)
       {
            $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$unit',null,null,null,null,'$Option','$UserStamp',@FINALTABLENAME)";
            $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND U.UNIT_NO='.$unit.' AND RD.ULD_ID=ULD.ULD_ID ORDER BY RD.PD_ID';
       }
       if($Option==3)
       {
           $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$unit','$customer',null,null,null,'$Option','$UserStamp',@FINALTABLENAME)";
           $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND RD.ULD_ID=ULD.ULD_ID ORDER BY C.CUSTOMER_FIRST_NAME,RD.PD_ID';
       }
       if($Option==4)
       {
           $SplittedFromPeriod=explode('-',$Fromdate);
           $string1 = $SplittedFromPeriod[0];
           $month_number1 = date("n",strtotime($string1));
           $Fromperiod=$SplittedFromPeriod[1].'-'.$month_number1.'-01';

           $SplittedToPeriod=explode('-',$Todate);
           $string2 = $SplittedToPeriod[0];
           $month_number2 = date("n",strtotime($string2));
           $Toperiod=$SplittedToPeriod[1].'-'.$month_number2.'-04';
           $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$Fromperiod','$Toperiod',null,null,null,'$Option','$UserStamp',@FINALTABLENAME)";
           $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND RD.ULD_ID=ULD.ULD_ID ORDER BY U.UNIT_NO,C.CUSTOMER_FIRST_NAME,PD_FOR_PERIOD';
       }
       if($Option==5)
       {
           $fromdate=date('Y-m-d',strtotime($Fromdate));
           $todate=date('Y-m-d',strtotime($Todate));
           $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$fromdate','$todate',null,null,null,'$Option','$UserStamp',@FINALTABLENAME)";
           $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND RD.ULD_ID=ULD.ULD_ID ORDER BY U.UNIT_NO,C.CUSTOMER_FIRST_NAME,PD_FOR_PERIOD';
       }
       if($Option==6)
       {
           $SplittedFromPeriod=explode('-',$Fromdate);
           $string1 = $SplittedFromPeriod[0];
           $month_number1 = date("n",strtotime($string1));
           $Fromperiod=$SplittedFromPeriod[1].'-'.$month_number1.'-01';

           $SplittedToPeriod=explode('-',$Todate);
           $string2 = $SplittedToPeriod[0];
           $month_number2 = date("n",strtotime($string2));
           $Toperiod=$SplittedToPeriod[1].'-'.$month_number2.'-04';
           $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$unit','$Fromperiod','$Toperiod','$fromamount','$toamount','$Option','$UserStamp',@FINALTABLENAME)";
           $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND RD.ULD_ID=ULD.ULD_ID ORDER BY U.UNIT_NO,C.CUSTOMER_FIRST_NAME,PD_FOR_PERIOD';
       }
       $this->db->query($temptablequery);
       $outparm_query = 'SELECT @FINALTABLENAME AS TEMP_TABLE';
       $outparm_result = $this->db->query($outparm_query);
       $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
       $Selectquery=str_replace('TEMP_PAYMENT_FEE_DETAIL',$csrc_tablename,$FIN_SRC_searchquery);
       $resultset=$this->db->query($Selectquery);
       $this->db->query('DROP TABLE IF EXISTS '.$csrc_tablename);
       return $resultset->result();
   }
   public function getPaymentRowDetails($Rowid)
   {
       $SelectQuery='SELECT PD.CUSTOMER_ID,PD.PD_ID,U.UNIT_NO,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,PP.PP_DATA,PD.PD_AMOUNT,PD.PD_HIGHLIGHT_FLAG,DATE_FORMAT(PD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(PD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,PD.PD_COMMENTS FROM PAYMENT_DETAILS PD,UNIT U,CUSTOMER C,PAYMENT_PROFILE PP WHERE PD_ID='.$Rowid.' AND U.UNIT_ID=PD.UNIT_ID AND C.CUSTOMER_ID=PD.CUSTOMER_ID AND PP.PP_ID=PD.PP_ID';
       $resultset=$this->db->query($SelectQuery);
       return $resultset->result();
   }
    public function getPaymentRowLPDetails($customerid,$unit)
    {
        $SelectQuery='SELECT CED.CUSTOMER_ID,CED.CED_REC_VER,CLP.CLP_STARTDATE,CLP.CLP_ENDDATE,CLP.CLP_PRETERMINATE_DATE FROM CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED WHERE CLP.CUSTOMER_ID='.$customerid.' AND CLP.CLP_GUEST_CARD IS NULL AND CED.CUSTOMER_ID=CLP.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='.$unit.') ORDER BY CED.CED_REC_VER';
        $resultset=$this->db->query($SelectQuery);
        return $resultset->result();
    }
    public function Payment_Updation($UserStamp)
    {
      $pdid=$_POST['UD_Payment_id'];
      $unit=$_POST['UD_Payment_Unit'];
      $customer=$_POST['UD_Payment_Customer'];
      $LP=$_POST['UD_Payment_Leaseperiod'];
      $paymenttype=$_POST['UD_Payment_Paymenttype'];
      $amount=$_POST['UD_Payment_Amount'];
      $period=$_POST['UD_Payment_Forperiod'];
      $paiddate=date('Y-m-d',strtotime($_POST['UD_Payment_Paiddate']));
      $comments=$this->db->escape_like_str($_POST['UD_Payment_Comments']);
      $flag=$_POST['UD_Payment_Amountflag'];
       if($flag=='on'){$paymentflag='X';}else{$paymentflag='';}

       $UpdateQuery="CALL SP_PAYMENT_DETAIL_UPDATE('$pdid','$unit','$customer','$paymenttype','$LP','$amount','$period','$paiddate','$paymentflag','$comments','$UserStamp',@ERRORMSG)";
        $this->db->query($UpdateQuery);
        $Confirm_query = 'SELECT @ERRORMSG AS CONFIRM';
        $Confirm_result = $this->db->query($Confirm_query);
        $Confirm_Meessage=$Confirm_result->row()->CONFIRM;
        $this->db->query("COMMIT");
        return $Confirm_Meessage;
    }
    public function payment_extract_details($unit,$customer,$UserStamp,$timeZoneFormat)
    {
        $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$unit','$customer',null,null,null,'3','$UserStamp',@FINALTABLENAME)";
        $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND RD.ULD_ID=ULD.ULD_ID ORDER BY C.CUSTOMER_FIRST_NAME,PD_FOR_PERIOD';
        $this->db->query($temptablequery);
        $outparm_query = 'SELECT @FINALTABLENAME AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
        $Selectquery=str_replace('TEMP_PAYMENT_FEE_DETAIL',$csrc_tablename,$FIN_SRC_searchquery);
        $resultset=$this->db->query($Selectquery);
        $paymentnumrows=$this->db->affected_rows();
        $this->db->query('DROP TABLE IF EXISTS '.$csrc_tablename);
        $FIN_ACT_folresult=$this->db->query("SELECT DDC_DATA FROM DEPOSIT_DEDUCTION_CONFIGURATION WHERE CGN_ID=30");
        $folderid=$FIN_ACT_folresult->row()->DDC_DATA;
        $Currentyear=date('Y');
        $SSname='EI_DEPOSIT_DEDUCTIONS_'.$Currentyear;
        $this->load->library('Google');
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $service = $this->Mdl_eilib_common_function->get_service_document();
        $children1 = $service->children->listChildren($folderid);
        $filearray1=$children1->getItems();
        $SSexistflag=0;
        $Sexistflag=0;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        foreach ($filearray1 as $child1)
        {
            $fileid=$service->files->get($child1->getId())->id;
            $filename=$service->files->get($child1->getId())->title;
            if($filename==$SSname)
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
            $SSfileid=$this->Mdl_eilib_common_function->NewSpreadsheetCreation($service, $SSname, 'PAYMENT_DETAILS', $folderid);
            $this->db->query("UPDATE FILE_PROFILE SET FP_FILE_ID='$SSfileid' WHERE FP_ID=1");
        }
        $ssheaders='UNIT,CUSTOMER NAME,PAYMENT AMOUNT,DEPOSIT,PROCESSING FEE,CLEANINGFEE,DEPOSIT REFUND,FORPERIOD,PAIDDATE,COMMENTS,TIMESTAMP,USERSTAMP';
        $PaymentExtractList = array('Extract'=>11,'header'=>$ssheaders,"Rows"=>$paymentnumrows,"Fileid"=>$SSfileid);
         $i = 0;
        foreach ($resultset->result_array() as $key => $value) {
            $key = 'Paymentdata'.$i;
            $unit=$value['UNIT_NO'];
            $customer=$value['CUSTOMER_FIRST_NAME'].' '.$value['CUSTOMER_LAST_NAME'];
            $payment=$value['PD_PAYMENT'];
            $amountflag=$value['PD_HIGHLIGHT_FLAG'];
            $deposit=$value['PD_DEPOSIT'];
            $process=$value['PD_PROCESSING_FEE'];
            $clean=$value['PD_CLEANING_FEE'];
            $drefund=$value['PD_DEPOSIT_REFUND'];
            $forperiod=$value['PD_FOR_PERIOD'];
            $paiddate=$value['PD_PAID_DATE'];
            $comments=$value['PD_COMMENTS'];
            $Userstamp=$value['ULD_lOGINID'];
            $timestamp=$value['PD_TIMESTAMP'];
            $Paymentid=$value['PP_ID'];
            $paymentrecords=$unit.'!~'.$customer.'!~'.$amountflag.'!~'.$Paymentid.'!~'.$payment.'!~'.$deposit.'!~'.$process.'!~'.$clean.'!~'.$drefund.'!~'.$forperiod.'!~'.$paiddate.'!~'.$comments.'!~'.$timestamp.'!~'.$Userstamp;
            $PaymentExtractList[$key] = $paymentrecords;
            $i++;
        }
        $SSResponse=$this->Mdl_eilib_common_function->Func_curl($PaymentExtractList);
        return $SSResponse;
    }
    public function Func_curl($data)
    {
        $url = "https://script.google.com/macros/s/AKfycbyHPUsdw6HUVwm4ihnupskKosYuta4sPkCcc8n60tKorKopUKM/exec";
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
    public function payment_pdf_details($Option,$inputone,$inputtwo,$inputthree,$inputfour,$inoutfive,$UserStamp,$timeZoneFormat)
    {
        if($Option==2)
        {
            $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$inputone',null,null,null,null,'$Option','$UserStamp',@FINALTABLENAME)";
            $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND U.UNIT_NO='.$inputone.' AND RD.ULD_ID=ULD.ULD_ID ORDER BY RD.PD_ID';
        }
        if($Option==3)
        {
            $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$inputone','$inputtwo',null,null,null,'$Option','$UserStamp',@FINALTABLENAME)";
            $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND RD.ULD_ID=ULD.ULD_ID ORDER BY C.CUSTOMER_FIRST_NAME,RD.PD_ID';
        }
        if($Option==4)
        {
            $SplittedFromPeriod=explode('-',$inputone);
            $string1 = $SplittedFromPeriod[0];
            $month_number1 = date("n",strtotime($string1));
            $Fromperiod=$SplittedFromPeriod[1].'-'.$month_number1.'-01';

            $SplittedToPeriod=explode('-',$inputtwo);
            $string2 = $SplittedToPeriod[0];
            $month_number2 = date("n",strtotime($string2));
            $Toperiod=$SplittedToPeriod[1].'-'.$month_number2.'-04';
            $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$Fromperiod','$Toperiod',null,null,null,'$Option','$UserStamp',@FINALTABLENAME)";
            $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND RD.ULD_ID=ULD.ULD_ID ORDER BY U.UNIT_NO,C.CUSTOMER_FIRST_NAME,PD_FOR_PERIOD';
        }
        if($Option==5)
        {
            $fromdate=date('Y-m-d',strtotime($inputone));
            $todate=date('Y-m-d',strtotime($inputtwo));
            $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$fromdate','$todate',null,null,null,'$Option','$UserStamp',@FINALTABLENAME)";
            $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND RD.ULD_ID=ULD.ULD_ID ORDER BY U.UNIT_NO,C.CUSTOMER_FIRST_NAME,PD_FOR_PERIOD';
        }
        if($Option==6)
        {
            $SplittedFromPeriod=explode('-',$inputtwo);
            $string1 = $SplittedFromPeriod[0];
            $month_number1 = date("n",strtotime($string1));
            $Fromperiod=$SplittedFromPeriod[1].'-'.$month_number1.'-01';

            $SplittedToPeriod=explode('-',$inputthree);
            $string2 = $SplittedToPeriod[0];
            $month_number2 = date("n",strtotime($string2));
            $Toperiod=$SplittedToPeriod[1].'-'.$month_number2.'-04';
            $temptablequery="CALL SP_PAYMENT_SEARCH_TEMP_TABLE('$inputone','$Fromperiod','$Toperiod','$inputfour','$inoutfive','$Option','$UserStamp',@FINALTABLENAME)";
            $FIN_SRC_searchquery='SELECT RD.PP_ID,RD.PD_ID,U.UNIT_NO,RD.CUSTOMER_ID,RD.CED_REC_VER,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,RUFD.PD_PAYMENT,RD.PD_HIGHLIGHT_FLAG,RUFD.PD_DEPOSIT,RUFD.PD_PROCESSING_FEE,RUFD.PD_CLEANING_FEE,RUFD.PD_DEPOSIT_REFUND,DATE_FORMAT(RD.PD_FOR_PERIOD,"%M-%Y") AS PD_FOR_PERIOD,DATE_FORMAT(RD.PD_PAID_DATE,"%d-%m-%Y") AS PD_PAID_DATE,RD.PD_COMMENTS,ULD.ULD_lOGINID,DATE_FORMAT(CONVERT_TZ(RD.PD_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS PD_TIMESTAMP FROM TEMP_PAYMENT_FEE_DETAIL RUFD,PAYMENT_DETAILS RD ,UNIT U,CUSTOMER C,USER_LOGIN_DETAILS ULD WHERE RUFD.PD_ID=RD.PD_ID AND C.CUSTOMER_ID=RD.CUSTOMER_ID AND RD.CUSTOMER_ID=RUFD.CUSTOMER_ID AND RD.UNIT_ID=U.UNIT_ID AND RUFD.UNIT_ID=RD.UNIT_ID AND RD.ULD_ID=ULD.ULD_ID ORDER BY U.UNIT_NO,C.CUSTOMER_FIRST_NAME,PD_FOR_PERIOD';
        }
        $this->db->query($temptablequery);
        $outparm_query = 'SELECT @FINALTABLENAME AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
        $Selectquery=str_replace('TEMP_PAYMENT_FEE_DETAIL',$csrc_tablename,$FIN_SRC_searchquery);
        $resultset=$this->db->query($Selectquery);
        $Payment_data='<br>
        <table width="2500px" id="USU_tble_htmltable" border="1" style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult">
        <sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/>
        <thead bgcolor="#6495ed" style="color:white">
        <tr>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">UNIT</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:200px">CUSTOMER NAME</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">PAYMENT</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">DEPOSIT</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">PROCESSING FEE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">CLEANING FEE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">DEPOSIT REFUND</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">FOR PERIOD</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">PAID DATE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:250px">COMMENTS</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px">USERSTAMP</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px">TIMESTAMP</th>
        </tr>
        </thead>
        <tbody>';
        foreach ($resultset->result_array() as $key => $value)
        {
            $Payment_data.='<tr>';
            $Payment_data.='<td style="text-align:center;">'.$value['UNIT_NO'].'</td>';
            $Payment_data.='<td>'.$value['CUSTOMER_FIRST_NAME'].' '.$value['CUSTOMER_LAST_NAME'].'</td>';
            if($value['PD_HIGHLIGHT_FLAG']=='X')
            {
                $Payment_data .= '<td style="text-align:center;color:red;font-size:13px;font-weight:bold">' . $value['PD_PAYMENT'] . '</td>';
                $Payment_data .= '<td style="text-align:center;color:red;font-size:13px;font-weight:bold">' . $value['PD_DEPOSIT'] . '</td>';
                $Payment_data .= '<td style="text-align:center;color:red;font-size:13px;font-weight:bold">' . $value['PD_PROCESSING_FEE'] . '</td>';
                $Payment_data .= '<td style="text-align:center;color:red;font-size:13px;font-weight:bold">' . $value['PD_CLEANING_FEE'] . '</td>';
                $Payment_data .= '<td style="text-align:center;color:red;font-size:13px;font-weight:bold">' . $value['PD_DEPOSIT_REFUND'] . '</td>';
            }
            else
            {
                $Payment_data .= '<td style="text-align:center;">' . $value['PD_PAYMENT'] . '</td>';
                $Payment_data .= '<td style="text-align:center;">' . $value['PD_DEPOSIT'] . '</td>';
                $Payment_data .= '<td style="text-align:center;">' . $value['PD_PROCESSING_FEE'] . '</td>';
                $Payment_data .= '<td style="text-align:center;">' . $value['PD_CLEANING_FEE'] . '</td>';
                $Payment_data .= '<td style="text-align:center;">' . $value['PD_DEPOSIT_REFUND'] . '</td>';
            }
            $Payment_data.='<td>'.$value['PD_FOR_PERIOD'].'</td>';
            $Payment_data.='<td style="text-align:center;">'.$value['PD_PAID_DATE'].'</td>';
            $Payment_data.='<td >'.$value['PD_COMMENTS'].'</td>';
            $Payment_data.='<td >'.$value['ULD_lOGINID'].'</td>';
            $Payment_data.='<td >'.$value['PD_TIMESTAMP'].'</td>';
            $Payment_data.='</tr>';
        }
        $Payment_data.='</body></table>';
        $this->db->query('DROP TABLE IF EXISTS '.$csrc_tablename);
        return $Payment_data;
    }
}