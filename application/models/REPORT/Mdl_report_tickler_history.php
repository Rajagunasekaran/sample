<?php
class Mdl_report_tickler_history extends CI_Model{
    public function customername_autocomplete($USERSTAMP,$ErrorMessage)
    {

        $TH_temptblname = $this->Mdl_report_tickler_history->CallTicklerSP($USERSTAMP) ;
        $this->db->select('DISTINCT CONCAT(CUSTOMER_FIRST_NAME," ",CUSTOMER_LAST_NAME) AS CUSTOMERNAME',FALSE);
        $this->db->order_by("CUSTOMER_FIRST_NAME", "ASC");
        $this->db->from($TH_temptblname);
        $STDTL_SEARCH_COMMENTS = $this->db->get();
        foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
        {
            $STDTL_SEARCH_autocomplete[]=$row['CUSTOMERNAME'];
        }
        if($TH_temptblname!=null){
            $drop_query = "DROP TABLE ".$TH_temptblname;
            $this->db->query($drop_query);
        }
        if ($STDTL_SEARCH_autocomplete!='null')
        {
            return $result[]=array($STDTL_SEARCH_autocomplete,$ErrorMessage);
        }
    }
    public function CallTicklerSP($USERSTAMP)
    {
        $callquery="CALL SP_CUSTOMER_TICKLER_DATA('".$USERSTAMP."',@CUSTOMER_TICKLER_HISTORY_TMPTBL)";
        $this->db->query($callquery);
        $TH_rs_query = 'SELECT @CUSTOMER_TICKLER_HISTORY_TMPTBL AS TEMP_TABLE';
        $outparm_result = $this->db->query($TH_rs_query);
        $TH_temptblname=$outparm_result->row()->TEMP_TABLE;
        return $TH_temptblname;
    }
    //FETCHING DATA
    public function fetch_data($USERSTAMP)
    {
        $TH_temptblname = $this->Mdl_report_tickler_history->CallTicklerSP($USERSTAMP) ;
        $TH_fname=$_POST['cust_first_name'];
        $TH_lname=$_POST['cust_last_name'];
        $this->db->select("CUSTOMER_ID AS customerid,UPDATION_DELETION AS upddel,TABLE_NAME AS tablename,TH_OLD_VALUE AS oldvalue,TH_NEW_VALUE AS newvalue,TH_USERSTAMP AS userstamp,DATE_FORMAT(CONVERT_TZ(TH_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
        $this->db->from($TH_temptblname);
        $this->db->where("CUSTOMER_FIRST_NAME='$TH_fname' AND CUSTOMER_LAST_NAME='$TH_lname'");
        $this->db->order_by("TH_TIMESTAMP", "ASC");
        $query = $this->db->get();
        if($TH_temptblname!=null){
            $drop_query = "DROP TABLE ".$TH_temptblname;
            $this->db->query($drop_query);
        }
        return $query->result();
    }
}