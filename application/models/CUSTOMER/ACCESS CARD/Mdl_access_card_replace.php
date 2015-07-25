<?php
//******************************************Card Replace********************************************//
//VER 0.01-SD:07/05/2015 ED:08/05/2015,initial version BY RAJA
//*******************************************************************************************************//
class Mdl_access_card_replace extends CI_Model{
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
        $this->db->select('U.UNIT_NO,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,C.CUSTOMER_ID,UASD.UASD_ACCESS_CARD,CPD.CPD_COMMENTS');
        $this->db->from('UNIT U,UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER C,CUSTOMER_ACCESS_CARD_DETAILS CACD,CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED,CUSTOMER_PERSONAL_DETAILS CPD');
        $this->db->where('CED.CUSTOMER_ID=CPD.CUSTOMER_ID AND U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_ID=CED.UNIT_ID AND CED.CUSTOMER_ID=CLP.CUSTOMER_ID AND CED.CED_REC_VER=CLP.CED_REC_VER AND CED.CUSTOMER_ID=CACD.CUSTOMER_ID AND  C.CUSTOMER_ID=CED.CUSTOMER_ID and CLP.CLP_TERMINATE IS NULL AND CACD.ACN_ID IS NULL AND UASD.UASD_ID=CACD.UASD_ID AND CLP.UASD_ID=CACD.UASD_ID  AND CED_CANCEL_DATE IS NULL AND CLP.CLP_STARTDATE<=CURDATE() AND IF(CLP.CLP_PRETERMINATE_DATE IS NOT NULL,CLP.CLP_PRETERMINATE_DATE>CURDATE(),CLP.CLP_ENDDATE>CURDATE()) AND C.CUSTOMER_ID NOT IN(SELECT CUSTOMERID FROM  VW_TERMINATION_TERMINATED_CUSTOMER)');
        $this->db->order_by('U.UNIT_NO');
        $this->db->order_by('C.CUSTOMER_FIRST_NAME');
        $custdetails = $this->db->get();
        $CR_customer_array=array();
        foreach($custdetails->result_array() as $row){
            $CR_firstname=$row["CUSTOMER_FIRST_NAME"];
            $CR_lastname=$row["CUSTOMER_LAST_NAME"];
            $CR_customername=$CR_firstname."_".$CR_lastname;
            $CR_customer_array[]=(object)['unit'=>$row["UNIT_NO"],'customerid'=>$row["CUSTOMER_ID"],'name'=>$CR_customername,'cardno'=>$row["UASD_ACCESS_CARD"],'comments'=>$row["CPD_COMMENTS"]];
        }
        return $CR_customer_array;
    }
    public function Avialable_card($unitno){
        $this->db->select('UASD.UASD_ACCESS_CARD');
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U');
        $this->db->where('U.UNIT_ID=UASD.UNIT_ID AND UASD.UASD_ACCESS_INVENTORY="X" AND U.UNIT_NO='.$unitno);
        $this->db->order_by('UASD_ACCESS_CARD','ASC');
        $cards = $this->db->get();
        $resultcard=array();
        foreach($cards->result_array() as $row){
            $resultcard[]=$row['UASD_ACCESS_CARD'];
        }
        return $resultcard;
    }
    public function Replacecard_save($CR_custid,$CR_currentcard,$CR_newcard,$CR_reason,$CR_comments,$CR_unit_no,$CR_UserStamp){
        $CR_valid_till=date('Y-m-d');
        if($CR_comments!=''){
            $CR_comments=$this->db->escape_like_str($CR_comments);
        }
        $CR_save_stmt="CALL SP_REPLACE_ACCESS_CARD_UPDATE(".$CR_custid.",".$CR_currentcard.",".$CR_newcard.",'".$CR_reason."','".$CR_comments."','".$CR_UserStamp."',@replace_flag)";
        $this->db->query($CR_save_stmt);
        $outparm_query = 'SELECT @replace_flag AS replace_flag';
        $outparm_result = $this->db->query($outparm_query);
        $replace_flag=$outparm_result->row()->replace_flag;
        $allcust_details=$this->Customer_details();
        $resultarray=array($replace_flag,$allcust_details);
        return $resultarray;
    }
}