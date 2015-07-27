<?php
//******************************************Unit Termination********************************************//
//VER 0.01-SD:21/05/2015 ED:21/05/2015,initial version BY RAJA
//*******************************************************************************************************//
class Mdl_unit_termination extends CI_Model{
    public function Initial_data(){
        $this->db->select('UNIT_NO');
        $this->db->from('UNIT');
        $this->db->where('UNIT_ID IN (SELECT UNIT_ID FROM UNIT_DETAILS WHERE UD_OBSOLETE IS NULL)');
        $query1 = $this->db->get();
        $result1=[];
        foreach($query1->result_array() as $row){
            $result1[]=$row['UNIT_NO'];
        }
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList('15,31,32,324');
        $UT_result=(object)["UT_errormsg"=>$ErrorMessage,"UT_unitno"=>$result1];
        return $UT_result;
    }
    public function UT_unit_details($UT_unitnumber,$UT_flag_selectcheck,$UT_comments,$UserStamp){
        if($UT_flag_selectcheck=='UT_flag_select')
        {
            $UT_unitno_select="SELECT * FROM UNIT WHERE UNIT_NO=".$UT_unitnumber;
            $UT_unitno_rs=$this->db->query($UT_unitno_select);
            $UT_unitno='';
            if($UT_unitno_rs->num_rows() > 0)
            {
                $UT_unitno=$UT_unitno_rs->row()->UNIT_ID;
            }
            $UT_unitdetails="SELECT UD_START_DATE,UD_END_DATE,UD_PAYMENT,UD_COMMENTS FROM UNIT_DETAILS WHERE UNIT_ID=".$UT_unitno;
            $UT_unitdetails_rs=$this->db->query($UT_unitdetails);
            $UT_array_unitdetails='';
            foreach($UT_unitdetails_rs->result_array() as $row)
            {
                $UT_startdate = $row["UD_START_DATE"];
                $UT_enddate =$row["UD_END_DATE"];
                $UT_rental = $row["UD_PAYMENT"];
                $UT_comments = $row["UD_COMMENTS"];
                $UT_array_unitdetails=(object)["UT_sdate"=>$UT_startdate,"UT_edate"=>$UT_enddate,"UT_rent"=>$UT_rental,"UT_comment"=>$UT_comments];
            }
            return $UT_array_unitdetails;
        }
        else if($UT_flag_selectcheck=='UT_flag_check')
        {
            if($UT_comments!="")//COMMENTS
            {
                $UT_comments=$this->db->escape_like_str($UT_comments);
            }
            $UT_flag_customer='';
            $UT_unitno_sp="CALL SP_UNIT_TERMINATION(".$UT_unitnumber.",'".$UserStamp."','".$UT_comments."',@FLAG)";
            $this->db->query($UT_unitno_sp);
            $UT_unitflag_select=$this->db->query("SELECT @FLAG AS FLAG");
            $UT_flag_customer=$UT_unitflag_select->row()->FLAG;
            $UT_UPDCODE_unitno_refresh=$this->Initial_data();
            $UT_UPDCODE_unitno_refresh_arr=$UT_UPDCODE_unitno_refresh->UT_unitno;
            $UT_UPDCODE_object=(object)["UT_UPDCODE_obj_flag"=>$UT_flag_customer,"UT_UPDCODE_unitno_obj"=>$UT_UPDCODE_unitno_refresh_arr];
            return $UT_UPDCODE_object;
        }
    }
}