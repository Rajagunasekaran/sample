<?php
class Mdl_customer_termination extends CI_Model
{
    public function Customer_Termination($UserStamp)
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $ATERM_tddate=$this->Mdl_eilib_common_function->gettimezone24HRS();
        $this->Mdl_eilib_common_function->Trigger_Run_Time('CUSTOMER TERMINATION',$UserStamp);
        $ATERM_spcallstmt="CALL SP_CUSTOMER_AUTO_TERMINATION('$ATERM_tddate','$UserStamp')";
        $this->db->query($ATERM_spcallstmt);
    }
}