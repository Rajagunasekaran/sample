<?php
error_reporting(0);
class Mdl_ocbc_banktt_entry extends CI_Model {
    public function Initial_data()
    {
        $this->db->select('BCN_DATA');
        $this->db->from('BANKTT_CONFIGURATION');
        $this->db->where('CGN_ID=69');
        $this->db->order_by('BCN_DATA');
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('BTM_DATA');
        $this->db->from('BANK_TRANSFER_MODELS');
        $this->db->where('BTM_OBSOLETE IS NULL');
        $this->db->order_by('BTM_DATA');
        $query = $this->db->get();
        $result2 = $query->result();

        $this->db->select('UNIT_NO');
        $this->db->from('UNIT');
        $this->db->order_by('UNIT_NO');
        $query = $this->db->get();
        $result3 = $query->result();

        $this->db->select('BCN_DATA');
        $this->db->from('BANKTT_CONFIGURATION');
        $this->db->where('CGN_ID=71');
        $this->db->order_by('BCN_DATA');
        $query = $this->db->get();
        $result4 = $query->result();

        $this->db->select('EMC_DATA');
        $this->db->from('ERROR_MESSAGE_CONFIGURATION');
        $this->db->where('EMC_ID IN (1,2,3,6,247,248,400)');
        $query = $this->db->get();
        $result5 = $query->result();

        return $result[]=array($result1,$result2,$result3,$result4,$result5);
    }
    public function Customer_name($unit)
    {
        $this->db->select('DISTINCT C.CUSTOMER_ID,CONCAT(CUSTOMER_FIRST_NAME," ",CUSTOMER_LAST_NAME) AS CUSTOMER_NAME',FALSE);
        $this->db->from('UNIT U,CUSTOMER_ENTRY_DETAILS CED,CUSTOMER C');
        $this->db->where('C.CUSTOMER_ID=CED.CUSTOMER_ID AND CED.UNIT_ID=U.UNIT_ID AND U.UNIT_NO='.$unit);
        $this->db->order_by('C.CUSTOMER_FIRST_NAME','ASC');
        $query = $this->db->get();
        $customers = $query->result();
        return $customers;
    }
    public function Banktt_EntrySave($UserStamp)
    {
        $type=$_POST['banktt_lb_transtype'];
        $date=date('Y-m-d',strtotime($_POST['banktt_date']));
        $model=$_POST['banktt_lb_model'];if($model=='SELECT'){$model='';}
        $accname=$_POST['banktt_tb_accname'];
        $accno=$_POST['banktt_tb_accno'];
        $amount=$_POST['banktt_tb_amt'];
        $unit=$_POST['banktt_lb_unit'];if($unit=="SELECT"){$unit="";}
        $customername=$_POST['banktt_lb_customer'];if($customername=="SELECT"){$customername="";}
        $customerid=$_POST['temp_customerid'];
        $bankttcode=$_POST['banktt_tb_bankcode'];
        $banktt_branchcode=$_POST['banktt_tb_branchcode'];
        $bankaddress=$this->db->escape_like_str($_POST['banktt_ta_address']);
        $swiftcode=$_POST['banktt_tb_swiftcode'];
        $chargesto=$_POST['banktt_lb_chargeto'];if($chargesto=="SELECT"){$chargesto="";}
        $customerref=$this->db->escape_like_str($_POST['banktt_tb_custref']);
        $invdetails=$this->db->escape_like_str($_POST['banktt_ta_invdetails']);
        $comments=$this->db->escape_like_str($_POST['banktt_ta_comments']);
        $configdatas=$type.',ENTERED'.','.$chargesto;
        $CallQuery="CALL SP_BANK_TT_INSERT('$configdatas','$model','$unit','$customerid','$date','$amount','$accname','$accno','$bankttcode','$banktt_branchcode','$bankaddress','$swiftcode','$customerref','$invdetails','$comments','$UserStamp',@BANK_SUCCESSFLAG)";
        $this->db->query($CallQuery);
        $outparm_query = 'SELECT @BANK_SUCCESSFLAG AS MESSAGE';
        $outparm_result = $this->db->query($outparm_query);
        $Confirmmrssage=$outparm_result->row()->MESSAGE;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $Sendmailid=$this->Mdl_eilib_common_function->getProfileEmailId('BANKTT');
        $Displayname=$this->Mdl_eilib_common_function->Get_MailDisplayName('BANK_TT');
        $username=explode('@',$Sendmailid);
        $mailusername=strtoupper($username[0]);
        $headerarray=['DATE','TRANSACTION TYPE','MODEL NAME','ACC NAME','ACC NO','AMOUNT','UNIT','CUSTOMER','BANK CODE','BRANCH CODE','BANK ADDRESS','SWIFT CODE','CHARGES TO','CUST REF','INV DETAILS','COMMENTS'];
        $dataarray=[$_POST['banktt_date'],$type,$model,$accname,$accno,$amount,$unit,$customername,$bankttcode,$banktt_branchcode,$bankaddress,$swiftcode,$chargesto,$customerref,$invdetails,$comments];
        $subject="HELLO ".','."<font color='gray'></font><font color='#498af3'><b>".$mailusername."</b> </font><br>PLEASE FIND ATTACHED NEW TRANSACTION DETAILS FROM BANK TT: <br>";
        $message = '<body><br><h> '.$subject.'</h><br></body>';
        for($i=0;$i<count($dataarray);$i++)
         {
         $value=$dataarray[$i];
            if($value!=null){$value=str_replace('_',' ',$value);}
            if($value=="" || $value=="SELECT" || $value==null)continue;
            $message.= '<body><table border="1"width="600" ><tr align="left" ><td width=40%>'.$headerarray[$i].'</td><td width=60%>'.$value.'</td></tr></table></body>';
         }
        $emailsubject="BANK TRANSFER";
        $returnvalues=array($Confirmmrssage,$emailsubject,$message,$Displayname,$Sendmailid);
        $this->db->query("COMMIT");
        return $returnvalues;
    }
    public function Banktt_Search_Option()
    {
        $this->db->select('BCN_ID,BCN_DATA,CGN_ID');
        $this->db->from('BANKTT_CONFIGURATION');
        $this->db->order_by('BCN_DATA');
        $query = $this->db->get();
        return $query->result();
    }
    public function Banktt_Unit()
    {
        $selectquery="SELECT DISTINCT U.UNIT_ID,U.UNIT_NO FROM UNIT U,BANK_TRANSFER_DETAIL BTD WHERE U.UNIT_ID=BTD.UNIT_ID ORDER BY UNIT_NO ASC";
        $resultset=$this->db->query($selectquery);
        return $resultset->result();
    }
    public function get_Banktt_Csutomer($unit)
    {
        $CustomerselectQuery="SELECT DISTINCT C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME FROM CUSTOMER C,BANK_TRANSFER_DETAIL BTD,UNIT U WHERE C.CUSTOMER_ID=BTD.CUSTOMER_ID AND U.UNIT_ID=BTD.UNIT_ID AND U.UNIT_NO=".$unit." ORDER BY CUSTOMER_FIRST_NAME ASC";
        $resultset=$this->db->query($CustomerselectQuery);
        return $resultset->result();
    }
    public function get_ModelNames()
    {
        $selectquery="SELECT BTM_DATA FROM BANK_TRANSFER_MODELS WHERE BTM_OBSOLETE IS NULL ORDER BY BTM_DATA ASC";
        $resultset=$this->db->query($selectquery);
        return $resultset->result();
    }
    public function get_Accountnames()
    {
        $selectquery="SELECT DISTINCT BT_ACC_NAME FROM BANK_TRANSFER WHERE BT_ACC_NAME IS NOT NULL ORDER BY BT_ACC_NAME ASC";
        $resultset=$this->db->query($selectquery);
        return $resultset->result();
    }
    public function get_SearchResults($Option,$UserStamp,$timeZoneFormat,$unit,$customer)
    {
        if($Option==1)
        {
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit',null,'$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
           $BANKTT_SRC_QUERY="SELECT BT.BT_ID,TBST.BANK_TRANSFER_TYPE,TBST.TRANSACTION_STATUS,TBST.BANK_TRANSFER_CHARGES_TO,TBST.BANK_TRANSFER_CREATED_BY,U.UNIT_NO,CONCAT(C.CUSTOMER_FIRST_NAME,' ',CUSTOMER_LAST_NAME)AS CUSTOMERNAME,DATE_FORMAT(CONVERT_TZ(BT.BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,BT.BT_AMOUNT,BT.BT_ACC_NAME,BT.BT_ACC_NO,BT.BT_BANK_CODE,BT.BT_BRANCH_CODE,BT.BT_BANK_ADDRESS,BT.BT_SWIFT_CODE,BT.BT_CUST_REF,BT.BT_INV_DETAILS,DATE_FORMAT(CONVERT_TZ(BT.BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT.BT_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT.BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANK_TRANSFER BT,BANK_TRANSFER_DETAIL BTD,UNIT U,CUSTOMER C,TEMP_BANKTTSEARCHTABLE TBST,USER_LOGIN_DETAILS ULD WHERE BT.BT_ID=BTD.BT_ID AND U.UNIT_ID=BTD.UNIT_ID AND C.CUSTOMER_ID=BTD.CUSTOMER_ID AND TBST.BT_ID=BTD.BT_ID AND ULD.ULD_ID=BT.ULD_ID";
        }
        if($Option==2)
        {
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit','$customer','$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
            $BANKTT_SRC_QUERY="SELECT BT.BT_ID,TBST.BANK_TRANSFER_TYPE,TBST.TRANSACTION_STATUS,TBST.BANK_TRANSFER_CHARGES_TO,TBST.BANK_TRANSFER_CREATED_BY,U.UNIT_NO,CONCAT(C.CUSTOMER_FIRST_NAME,' ',CUSTOMER_LAST_NAME)AS CUSTOMERNAME,DATE_FORMAT(CONVERT_TZ(BT.BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,BT.BT_AMOUNT,BT.BT_ACC_NAME,BT.BT_ACC_NO,BT.BT_BANK_CODE,BT.BT_BRANCH_CODE,BT.BT_BANK_ADDRESS,BT.BT_SWIFT_CODE,BT.BT_CUST_REF,BT.BT_INV_DETAILS,DATE_FORMAT(CONVERT_TZ(BT.BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT.BT_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT.BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANK_TRANSFER BT,BANK_TRANSFER_DETAIL BTD,UNIT U,CUSTOMER C,TEMP_BANKTTSEARCHTABLE TBST,USER_LOGIN_DETAILS ULD WHERE BT.BT_ID=BTD.BT_ID AND U.UNIT_ID=BTD.UNIT_ID AND C.CUSTOMER_ID=BTD.CUSTOMER_ID AND TBST.BT_ID=BTD.BT_ID AND ULD.ULD_ID=BT.ULD_ID";
        }
        if($Option==3)
        {
            $fromdate=date('Y-m-d',strtotime($unit));
            $todate=date('Y-m-d',strtotime($customer));
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$fromdate','$todate','$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
            $BANKTT_SRC_QUERY="SELECT BT_ID,BANK_TRANSFER_TYPE,DATE_FORMAT(CONVERT_TZ(BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,UNIT_NO,CUSTOMERNAME,BT_ACC_NO,BT_ACC_NAME,BT_AMOUNT,TRANSACTION_STATUS,DATE_FORMAT(CONVERT_TZ(BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT_BANK_CODE,BT_BRANCH_CODE,BT_BANK_ADDRESS,BT_SWIFT_CODE,BANK_TRANSFER_CHARGES_TO,BT_CUST_REF,BT_INV_DETAILS,BANK_TRANSFER_CREATED_BY,BT_COMMENTS,ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANKTT_SEARCH_TABLE ORDER BY BT_DATE ASC";
        }
        if($Option==4)
        {
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit',null,'$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
            $BANKTT_SRC_QUERY="SELECT BT.BT_ID,TBST.BANK_TRANSFER_TYPE,TBST.TRANSACTION_STATUS,TBST.BANK_TRANSFER_CHARGES_TO,TBST.BANK_TRANSFER_CREATED_BY,U.UNIT_NO,CONCAT(C.CUSTOMER_FIRST_NAME,' ',CUSTOMER_LAST_NAME)AS CUSTOMERNAME,DATE_FORMAT(CONVERT_TZ(BT.BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,BT.BT_AMOUNT,BT.BT_ACC_NAME,BT.BT_ACC_NO,BT.BT_BANK_CODE,BT.BT_BRANCH_CODE,BT.BT_BANK_ADDRESS,BT.BT_SWIFT_CODE,BT.BT_CUST_REF,BT.BT_INV_DETAILS,DATE_FORMAT(CONVERT_TZ(BT.BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT.BT_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT.BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANK_TRANSFER BT,BANK_TRANSFER_DETAIL BTD,UNIT U,CUSTOMER C,TEMP_BANKTTSEARCHTABLE TBST,USER_LOGIN_DETAILS ULD WHERE BT.BT_ID=BTD.BT_ID AND U.UNIT_ID=BTD.UNIT_ID AND C.CUSTOMER_ID=BTD.CUSTOMER_ID AND TBST.BT_ID=BTD.BT_ID AND ULD.ULD_ID=BT.ULD_ID";
        }
        if($Option==5)
        {
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit','$customer','$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
            $BANKTT_SRC_QUERY="SELECT BT_ID,BANK_TRANSFER_TYPE,DATE_FORMAT(CONVERT_TZ(BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,UNIT_NO,CUSTOMERNAME,BT_ACC_NO,BT_ACC_NAME,BT_AMOUNT,TRANSACTION_STATUS,DATE_FORMAT(CONVERT_TZ(BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT_BANK_CODE,BT_BRANCH_CODE,BT_BANK_ADDRESS,BT_SWIFT_CODE,BANK_TRANSFER_CHARGES_TO,BT_CUST_REF,BT_INV_DETAILS,BANK_TRANSFER_CREATED_BY,BT_COMMENTS,ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANKTT_SEARCH_TABLE ORDER BY BT_DATE ASC";
        }
        if($Option==6)
        {
            $BANKTT_SRC_QUERY="SELECT BT_ID,BANK_TRANSFER_TYPE,DATE_FORMAT(CONVERT_TZ(BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,UNIT_NO,CUSTOMERNAME,BT_ACC_NO,BT_ACC_NAME,BT_AMOUNT,TRANSACTION_STATUS,DATE_FORMAT(CONVERT_TZ(BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT_BANK_CODE,BT_BRANCH_CODE,BT_BANK_ADDRESS,BT_SWIFT_CODE,BANK_TRANSFER_CHARGES_TO,BT_CUST_REF,BT_INV_DETAILS,BANK_TRANSFER_CREATED_BY,BT_COMMENTS,ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANKTT_SEARCH_TABLE ORDER BY BT_DATE ASC";
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit',null,'$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
        }
        $this->db->query($BANKTT_TEMPTABLEQUERY);
        if($Option==3 || $Option==5 || $Option==6)
        {
            $outparm_query = 'SELECT @BANKTT_TEMP_TABLE_NAME AS TEMP_TABLE';
            $outparm_result = $this->db->query($outparm_query);
            $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
            $BANKTT_SRC_QUERY=str_replace('BANKTT_SEARCH_TABLE',$csrc_tablename,$BANKTT_SRC_QUERY);
        }
        else
        {
            $outparm_query = 'SELECT @BANKTT_SEARCH_TEMPTBLNAME AS TEMP_TABLE';
            $outparm_result = $this->db->query($outparm_query);
            $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
            $BANKTT_SRC_QUERY=str_replace('TEMP_BANKTTSEARCHTABLE',$csrc_tablename,$BANKTT_SRC_QUERY);
        }
        $resultset=$this->db->query($BANKTT_SRC_QUERY);
        $this->db->query('DROP TABLE IF EXISTS '.$csrc_tablename);
        return $resultset->result();
    }
    public function getBanktt_UpdateSave($UserStamp)
    {
        $id=$_POST['Temp_Bt_id'];
        $type=$_POST['Banktt_SRC_TTtype'];
        $date=date('Y-m-d',strtotime($_POST['Banktt_SRC_Date']));
        $model=$_POST['Banktt_SRC_Modelnames'];if($model=='SELECT'){$model='';}
        $accname=$_POST['Banktt_SRC_Accname'];
        $accno=$_POST['Banktt_SRC_Accno'];
        $amount=$_POST['Banktt_SRC_Amount'];
        $unit=$_POST['Banktt_SRC_Unit'];if($unit=="SELECT"){$unit="";}
        $customername=$_POST['Banktt_SRC_Customername'];if($customername=="SELECT"){$customername="";}
        $customerid=$_POST['temp_customerid'];
        $bankttcode=$_POST['Banktt_SRC_Bankcode'];
        $banktt_branchcode=$_POST['Banktt_SRC_Branchcode'];
        $bankaddress=$this->db->escape_like_str($_POST['Banktt_SRC_BankAddress']);
        $swiftcode=$_POST['Banktt_SRC_Swiftcode'];
        $chargesto=$_POST['Banktt_SRC_Chargesto'];if($chargesto=="SELECT"){$chargesto='';}
        $customerref=$this->db->escape_like_str($_POST['Banktt_SRC_Customerref']);
        $invdetails=$this->db->escape_like_str($_POST['Banktt_SRC_Invdetails']);
        $createdby=$_POST['Banktt_SRC_Createdby'];if($createdby=='SELECT'){$createdby='';}
        $comments=$this->db->escape_like_str($_POST['Banktt_SRC_Comments']);
        $status=$_POST['Banktt_SRC_Status'];
        if($_POST['Banktt_SRC_Debitedon']!='')
        {
        $debitedon=date('Y-m-d',strtotime($_POST['Banktt_SRC_Debitedon']));
        }
        else
        {
            $debitedon='';
        }
        if($chargesto!='' && $createdby!=''){$configdatas=$status.','.$createdby.','.$chargesto;}
        else if($chargesto!=''){$configdatas=$status.','.$chargesto;}
        else if($createdby!=''){$configdatas=$status.','.$createdby;}
        else{$configdatas=$status;}
        $BANKTT_SRC_updatequery="CALL SP_BANK_TT_UPDATE($id,'$configdatas','$model','$date',$amount,'$accname','$accno','$bankttcode','$banktt_branchcode','$bankaddress','$swiftcode','$customerref','$invdetails','$debitedon','$comments','$UserStamp',@BANK_SUCCESSFLAG)";
        $this->db->query($BANKTT_SRC_updatequery);
        $outparm_query = 'SELECT @BANK_SUCCESSFLAG AS MESSAGE';
        $outparm_result = $this->db->query($outparm_query);
        $Confirm_mrssage=$outparm_result->row()->MESSAGE;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $Sendmailid=$this->Mdl_eilib_common_function->getProfileEmailId('BANKTT');
        $Displayname=$this->Mdl_eilib_common_function->Get_MailDisplayName('BANK_TT');
        $username=explode('@',$Sendmailid);
        $mailusername=strtoupper($username[0]);
        $headerarray=['DATE','TRANSACTION TYPE','MODEL NAME','ACC NAME','ACC NO','AMOUNT','UNIT','CUSTOMER','STATUS','DEBITED/REJECTED DATE','BANK CODE','BRANCH CODE','BANK ADDRESS','SWIFT CODE','CHARGES TO','CUST REF','INV DETAILS','DONE BY','COMMENTS'];
        $dataarray=[$_POST['Banktt_SRC_Date'],$type,$model,$accname,$accno,$amount,$unit,$customername,$status,$debitedon,$bankttcode,$banktt_branchcode,$_POST['Banktt_SRC_BankAddress'],$swiftcode,$chargesto,$_POST['Banktt_SRC_Customerref'],$_POST['Banktt_SRC_Invdetails'],$createdby,$_POST['Banktt_SRC_Comments']];
        $subject="HELLO".','."<font color='gray'></font><font color='#498af3'><b>".$mailusername."</b> </font><br>PLEASE FIND ATTACHED NEW TRANSACTION DETAILS FROM BANK TT: <br>";
        $message = '<body><br><h> '.$subject.'</h><br></body>';
        for($i=0;$i<count($dataarray);$i++)
        {
         $value=$dataarray[$i];
         if($customername!=null){$customername=str_replace('_',' ',$customername);}
         if($value=="" || $value=="SELECT" || $value==null)continue;
         if($value!='REJECTED')
         {
          $message.= '<body><table border="1"width="600" ><tr align="left" ><td width=40%>'.$headerarray[$i].'</td><td width=60%>'.$value.'</td></tr></table></body>';
         }
         else
         {
          $message.= '<body><table border="1"width="600" ><tr align="left" ><td width=40%>'.$headerarray[$i].'</td><td width=60%><span style="background-color:#FF0000">'.$value.'</span></td></tr></table></body>';
         }
         }
         if($status!='REJECTED')
         {
          $emailsubject="BANK TRANSFER";
          }
         else
         {
        $emailsubject="BANK TRANSFER-REJECTED";
         }
        $returnvalues=array($Confirm_mrssage,$emailsubject,$message,$Displayname,$Sendmailid);
        $this->db->query("COMMIT");
        return $returnvalues;
    }
    public function Banktt_PDF_SearchResults($Option,$UserStamp,$timeZoneFormat,$unit,$customer)
    {
        if($Option==1)
        {
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit',null,'$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
            $BANKTT_SRC_QUERY="SELECT BT.BT_ID,TBST.BANK_TRANSFER_TYPE,TBST.TRANSACTION_STATUS,TBST.BANK_TRANSFER_CHARGES_TO,TBST.BANK_TRANSFER_CREATED_BY,U.UNIT_NO,CONCAT(C.CUSTOMER_FIRST_NAME,' ',CUSTOMER_LAST_NAME)AS CUSTOMERNAME,DATE_FORMAT(CONVERT_TZ(BT.BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,BT.BT_AMOUNT,BT.BT_ACC_NAME,BT.BT_ACC_NO,BT.BT_BANK_CODE,BT.BT_BRANCH_CODE,BT.BT_BANK_ADDRESS,BT.BT_SWIFT_CODE,BT.BT_CUST_REF,BT.BT_INV_DETAILS,DATE_FORMAT(CONVERT_TZ(BT.BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT.BT_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT.BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANK_TRANSFER BT,BANK_TRANSFER_DETAIL BTD,UNIT U,CUSTOMER C,TEMP_BANKTTSEARCHTABLE TBST,USER_LOGIN_DETAILS ULD WHERE BT.BT_ID=BTD.BT_ID AND U.UNIT_ID=BTD.UNIT_ID AND C.CUSTOMER_ID=BTD.CUSTOMER_ID AND TBST.BT_ID=BTD.BT_ID AND ULD.ULD_ID=BT.ULD_ID";
        }
        if($Option==2)
        {
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit','$customer','$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
            $BANKTT_SRC_QUERY="SELECT BT.BT_ID,TBST.BANK_TRANSFER_TYPE,TBST.TRANSACTION_STATUS,TBST.BANK_TRANSFER_CHARGES_TO,TBST.BANK_TRANSFER_CREATED_BY,U.UNIT_NO,CONCAT(C.CUSTOMER_FIRST_NAME,' ',CUSTOMER_LAST_NAME)AS CUSTOMERNAME,DATE_FORMAT(CONVERT_TZ(BT.BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,BT.BT_AMOUNT,BT.BT_ACC_NAME,BT.BT_ACC_NO,BT.BT_BANK_CODE,BT.BT_BRANCH_CODE,BT.BT_BANK_ADDRESS,BT.BT_SWIFT_CODE,BT.BT_CUST_REF,BT.BT_INV_DETAILS,DATE_FORMAT(CONVERT_TZ(BT.BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT.BT_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT.BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANK_TRANSFER BT,BANK_TRANSFER_DETAIL BTD,UNIT U,CUSTOMER C,TEMP_BANKTTSEARCHTABLE TBST,USER_LOGIN_DETAILS ULD WHERE BT.BT_ID=BTD.BT_ID AND U.UNIT_ID=BTD.UNIT_ID AND C.CUSTOMER_ID=BTD.CUSTOMER_ID AND TBST.BT_ID=BTD.BT_ID AND ULD.ULD_ID=BT.ULD_ID";
        }
        if($Option==3)
        {
            $fromdate=date('Y-m-d',strtotime($unit));
            $todate=date('Y-m-d',strtotime($customer));
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$fromdate','$todate','$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
            $BANKTT_SRC_QUERY="SELECT BT_ID,BANK_TRANSFER_TYPE,DATE_FORMAT(CONVERT_TZ(BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,UNIT_NO,CUSTOMERNAME,BT_ACC_NO,BT_ACC_NAME,BT_AMOUNT,TRANSACTION_STATUS,DATE_FORMAT(CONVERT_TZ(BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT_BANK_CODE,BT_BRANCH_CODE,BT_BANK_ADDRESS,BT_SWIFT_CODE,BANK_TRANSFER_CHARGES_TO,BT_CUST_REF,BT_INV_DETAILS,BANK_TRANSFER_CREATED_BY,BT_COMMENTS,ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANKTT_SEARCH_TABLE ORDER BY BT_DATE ASC";
        }
        if($Option==4)
        {
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit',null,'$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
            $BANKTT_SRC_QUERY="SELECT BT.BT_ID,TBST.BANK_TRANSFER_TYPE,TBST.TRANSACTION_STATUS,TBST.BANK_TRANSFER_CHARGES_TO,TBST.BANK_TRANSFER_CREATED_BY,U.UNIT_NO,CONCAT(C.CUSTOMER_FIRST_NAME,' ',CUSTOMER_LAST_NAME)AS CUSTOMERNAME,DATE_FORMAT(CONVERT_TZ(BT.BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,BT.BT_AMOUNT,BT.BT_ACC_NAME,BT.BT_ACC_NO,BT.BT_BANK_CODE,BT.BT_BRANCH_CODE,BT.BT_BANK_ADDRESS,BT.BT_SWIFT_CODE,BT.BT_CUST_REF,BT.BT_INV_DETAILS,DATE_FORMAT(CONVERT_TZ(BT.BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT.BT_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT.BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANK_TRANSFER BT,BANK_TRANSFER_DETAIL BTD,UNIT U,CUSTOMER C,TEMP_BANKTTSEARCHTABLE TBST,USER_LOGIN_DETAILS ULD WHERE BT.BT_ID=BTD.BT_ID AND U.UNIT_ID=BTD.UNIT_ID AND C.CUSTOMER_ID=BTD.CUSTOMER_ID AND TBST.BT_ID=BTD.BT_ID AND ULD.ULD_ID=BT.ULD_ID";
        }
        if($Option==5)
        {
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit','$customer','$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
            $BANKTT_SRC_QUERY="SELECT BT_ID,BANK_TRANSFER_TYPE,DATE_FORMAT(CONVERT_TZ(BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,UNIT_NO,CUSTOMERNAME,BT_ACC_NO,BT_ACC_NAME,BT_AMOUNT,TRANSACTION_STATUS,DATE_FORMAT(CONVERT_TZ(BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT_BANK_CODE,BT_BRANCH_CODE,BT_BANK_ADDRESS,BT_SWIFT_CODE,BANK_TRANSFER_CHARGES_TO,BT_CUST_REF,BT_INV_DETAILS,BANK_TRANSFER_CREATED_BY,BT_COMMENTS,ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANKTT_SEARCH_TABLE ORDER BY BT_DATE ASC";
        }
        if($Option==6)
        {
            $BANKTT_SRC_QUERY="SELECT BT_ID,BANK_TRANSFER_TYPE,DATE_FORMAT(CONVERT_TZ(BT_DATE,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DATE,UNIT_NO,CUSTOMERNAME,BT_ACC_NO,BT_ACC_NAME,BT_AMOUNT,TRANSACTION_STATUS,DATE_FORMAT(CONVERT_TZ(BT_DEBITED_ON,".$timeZoneFormat."),'%d-%m-%Y') AS BT_DEBITED_ON,BT_BANK_CODE,BT_BRANCH_CODE,BT_BANK_ADDRESS,BT_SWIFT_CODE,BANK_TRANSFER_CHARGES_TO,BT_CUST_REF,BT_INV_DETAILS,BANK_TRANSFER_CREATED_BY,BT_COMMENTS,ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BT_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BT_TIME_STAMP FROM BANKTT_SEARCH_TABLE ORDER BY BT_DATE ASC";
            $BANKTT_TEMPTABLEQUERY="CALL SP_TEMP_TABLE_BANKTT('$unit',null,'$Option','$UserStamp',@BANKTT_SEARCH_TEMPTBLNAME,@BANKTT_TEMP_TABLE_NAME)";
        }
        $this->db->query($BANKTT_TEMPTABLEQUERY);
        if($Option==3 || $Option==5 || $Option==6)
        {
            $outparm_query = 'SELECT @BANKTT_TEMP_TABLE_NAME AS TEMP_TABLE';
            $outparm_result = $this->db->query($outparm_query);
            $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
            $BANKTT_SRC_QUERY=str_replace('BANKTT_SEARCH_TABLE',$csrc_tablename,$BANKTT_SRC_QUERY);
        }
        else
        {
            $outparm_query = 'SELECT @BANKTT_SEARCH_TEMPTBLNAME AS TEMP_TABLE';
            $outparm_result = $this->db->query($outparm_query);
            $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
            $BANKTT_SRC_QUERY=str_replace('TEMP_BANKTTSEARCHTABLE',$csrc_tablename,$BANKTT_SRC_QUERY);
        }
        $resultset=$this->db->query($BANKTT_SRC_QUERY);
        $this->db->query('DROP TABLE IF EXISTS '.$csrc_tablename);
        $BankTT_data='<br>
        <table width="2500px" id="USU_tble_htmltable" border="1" style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult">
        <sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/>
        <thead bgcolor="#6495ed" style="color:white">
        <tr>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">TRANSACTION TYPE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:200px">DATE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">ACCOUNT NAME</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">ACCOUNT NO</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">AMOUNT</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">UNIT</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">CUSTOMER</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">STATUS</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">DEBITED / REJECTED DATE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px">BANK CODE</th>

           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px">BRANCH CODE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">BANK ADDRESS</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">SWIFT CODE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">CHARGES TO</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">CUST REF</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">INV DETAILSS</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">COMMENTS</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px">CREATED BY</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px">USERSTAMP</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px">TIMESTAMP</th>
        </tr>
        </thead>
        <tbody>';
        foreach ($resultset->result_array() as $key => $value)
        {
            $BankTT_data.='<tr>';
            $BankTT_data.='<td style="text-align:center;">'.$value['BANK_TRANSFER_TYPE'].'</td>';
            $BankTT_data.='<td  style="text-align:center;">'.$value['BT_DATE'].'</td>';
            $BankTT_data.='<td>' . $value['BT_ACC_NAME'] . '</td>';
            $BankTT_data.='<td>' . $value['BT_ACC_NO'] . '</td>';
            $BankTT_data.='<td style="text-align:center;">' . $value['BT_AMOUNT'] . '</td>';
            $BankTT_data.='<td>' . $value['UNIT_NO'] . '</td>';
            $BankTT_data.='<td>' . $value['CUSTOMERNAME'] . '</td>';
            $BankTT_data.='<td style="text-align:center;">' . $value['TRANSACTION_STATUS'] . '</td>';
            $BankTT_data.='<td  style="text-align:center;">'.$value['BT_DEBITED_ON'].'</td>';
            $BankTT_data.='<td  style="text-align:center;">'.$value['BT_BANK_CODE'].'</td>';
            $BankTT_data.='<td  style="text-align:center;">'.$value['BT_BRANCH_CODE'].'</td>';

            $BankTT_data.='<td>'.$value['BT_BANK_ADDRESS'].'</td>';
            $BankTT_data.='<td style="text-align:center;">'.$value['BT_SWIFT_CODE'].'</td>';
            $BankTT_data.='<td  style="text-align:center;">'.$value['BANK_TRANSFER_CHARGES_TO'].'</td>';
            $BankTT_data.='<td>' . $value['BT_CUST_REF'] . '</td>';
            $BankTT_data.='<td>' . $value['BT_INV_DETAILS'] .'</td>';
            $BankTT_data.='<td>' . $value['BT_COMMENTS'] . '</td>';
            $BankTT_data.='<td style="text-align:center;">' . $value['CREATED_BY'] . '</td>';
            $BankTT_data.='<td style="text-align:center;">' . $value['ULD_LOGINID'] . '</td>';
            $BankTT_data.='<td  style="text-align:center;">'.$value['BT_TIME_STAMP'].'</td>';
            $BankTT_data.='</tr>';
        }
        $BankTT_data.='</body></table>';
        return $BankTT_data;
    }
}