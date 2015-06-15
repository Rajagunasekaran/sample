<?php
error_reporting(0);
class Mdl_finance_payments_entry_terminated_customer extends CI_Model {
    public function FIN_payment_Customer($UserStamp)
    {
        $termtemptablequery="CALL SP_PAYMENT_ENTRY_TERMINATED_CUSTOMER('$UserStamp',@PAYMENT_ENTRY_TERMINATED_CUSTOMER)";
        $this->db->query($termtemptablequery);
        $outparm_query = 'SELECT @PAYMENT_ENTRY_TERMINATED_CUSTOMER AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $TEMP_tablename=$outparm_result->row()->TEMP_TABLE;
        $Selectquery="SELECT UNIT_NO,CUSTOMER_ID,CUSTOMER_FIRST_NAME,CUSTOMER_LAST_NAME,CED_REC_VER,CLP_STARTDATE,CLP_ENDDATE FROM  $TEMP_tablename  ORDER BY UNIT_NO,CUSTOMER_FIRST_NAME";
        $resultset=$this->db->query($Selectquery);
        $this->db->query('DROP TABLE IF EXISTS '.$TEMP_tablename);
        return $resultset->result();
    }
    public function FIN_Payment_EntrySave($UserStamp)
    {
        try
        {
            $unit=$_POST['FIN_TER_Payment_Unit'];
            $customer=$_POST['FIN_TER_Payment_Customer'];
            $LP=$_POST['FIN_TER_Payment_Leaseperiod'];
            $Paymenttype=$_POST['FIN_TER_Payment_Paymenttype'];
            $Amount=$_POST['FIN_TER_Payment_Amount'];
            $Period=$_POST['FIN_TER_Payment_Forperiod'];
            $paiddate=date('Y-m-d',strtotime($_POST['FIN_TER_Payment_Paiddate']));
            $comments=$this->db->escape_like_str($_POST['FIN_TER_Payment_Comments']);
            $customerid=$_POST['FIN_Payment_id'];
            $flag=$_POST['FIN_TER_Payment_Amountflag'];
            if($flag=='on'){$amountflag='X';}else{$amountflag='';}
            $FIN_TERM_ENTRY_query="CALL SP_PAYMENT_DETAIL_INSERT('$unit','$customerid','$Paymenttype','$LP','$Amount','$Period','$paiddate','$amountflag','$comments','$UserStamp',null,@OUTPUT_FINAL_MESSAGE)";
            $this->db->query($FIN_TERM_ENTRY_query);
            $outparm_query = 'SELECT @OUTPUT_FINAL_MESSAGE AS MESSAGE';
            $outparm_result = $this->db->query($outparm_query);
            $Confirmmrssage=$outparm_result->row()->MESSAGE;
            $this->db->query("COMMIT");
            return $Confirmmrssage;
        }
        catch (\InvalidArgumentException $e)
        {
            echo $e;
        }
    }
}