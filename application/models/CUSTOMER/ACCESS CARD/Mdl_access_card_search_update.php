<?php
//******************************************Card Search Update********************************************//
//VER 0.01-SD:08/05/2015 ED:09/05/2015,initial version BY RAJA
//*******************************************************************************************************//
class Mdl_access_card_search_update extends CI_Model{
    public function Initial_data($ErrorMessage){
        $this->db->select();
        $this->db->from('ACCESS_CONFIGURATION');
        $this->db->where('ACN_ID BETWEEN 1 AND 3');
        $this->db->order_by('ACN_DATA');
        $query = $this->db->get();
        $result1=[];
        foreach($query->result_array() as $row){
            $result1[]=$row['ACN_DATA'];
        }
        $allcust_details=$this->Customer_details();
        $resultset=array($result1,$allcust_details,$ErrorMessage);
        return $resultset;
    }
    public function Customer_details(){
        $this->db->select('U.UNIT_NO,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,C.CUSTOMER_ID,UASD.UASD_ACCESS_CARD,CACD.CACD_VALID_FROM,CACD.CACD_VALID_TILL,AC.ACN_DATA ,CPD.CPD_COMMENTS');
        $this->db->distinct();
        $this->db->from('UNIT U,CUSTOMER C,UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER_ACCESS_CARD_DETAILS CACD,CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED,ACCESS_CONFIGURATION AC,CUSTOMER_PERSONAL_DETAILS CPD');
        $this->db->where('U.UNIT_ID=UASD.UNIT_ID AND C.CUSTOMER_ID=CED.CUSTOMER_ID AND U.UNIT_ID=CED.UNIT_ID AND CED.CUSTOMER_ID=CLP.CUSTOMER_ID AND CED.CED_REC_VER=CLP.CED_REC_VER AND CED.CUSTOMER_ID=CACD.CUSTOMER_ID AND CLP.CLP_TERMINATE IS NULL AND UASD.UASD_ID=CACD.UASD_ID AND AC.ACN_ID=CACD.ACN_ID AND CED.CUSTOMER_ID=CPD.CUSTOMER_ID AND C.CUSTOMER_ID NOT IN (SELECT CUSTOMERID FROM VW_TERMINATION_TERMINATED_CUSTOMER) AND CACD.ACN_ID BETWEEN 1 AND 3');
        $this->db->order_by('U.UNIT_NO','ASC');
        $this->db->order_by('C.CUSTOMER_FIRST_NAME','ASC');
        $custdetails = $this->db->get();
        $CR_customer_array=array();
        foreach($custdetails->result_array() as $row){
            $CR_firstname=$row["CUSTOMER_FIRST_NAME"];
            $CR_lastname=$row["CUSTOMER_LAST_NAME"];
            $CR_customername=$CR_firstname."_".$CR_lastname;
            $CR_customer_array[]=(object)['unit'=>$row["UNIT_NO"],'customerid'=>$row["CUSTOMER_ID"],'name'=>$CR_customername,'cardno'=>$row["UASD_ACCESS_CARD"],'comments'=>$row["CPD_COMMENTS"],'validfrom'=>$row["CACD_VALID_FROM"],'validtill'=>$row["CACD_VALID_TILL"],'reason'=>$row["ACN_DATA"]];
        }
        return $CR_customer_array;
    }
    public function Accesscard_update($CSU_custid,$CSU_currentcard,$CSU_reason,$CSU_comments,$CR_UserStamp){
        if($CSU_comments!=''){
            $CSU_comments=$this->db->escape_like_str($CSU_comments);
        }
        $CSU_update_stmt="CALL SP_ACCESS_CARD_UPDATE(".$CSU_custid.",".$CSU_currentcard.",'".$CSU_reason."','".$CSU_comments."','".$CR_UserStamp."',@replace_search_flag)";
        $this->db->query($CSU_update_stmt);
        $outparm_query = 'SELECT @replace_search_flag AS replace_search_flag';
        $outparm_result = $this->db->query($outparm_query);
        $update_flag=$outparm_result->row()->replace_search_flag;
        $allcust_details=$this->Customer_details();
        $resultarray=array($update_flag,$allcust_details);
        return $resultarray;
    }
}