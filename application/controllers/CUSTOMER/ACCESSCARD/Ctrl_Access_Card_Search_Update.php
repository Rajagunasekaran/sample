<?php
//******************************************Card Search Update********************************************//
//VER 0.01-SD:08/05/2015 ED:09/05/2015,initial version BY RAJA
//*******************************************************************************************************//
class Ctrl_Access_Card_Search_Update extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/ACCESS CARD/Mdl_access_card_search_update');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('CUSTOMER/ACCESS CARD/Vw_Access_Card_Search_Update');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $query=$this->Mdl_access_card_search_update->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    public function Accesscardupdate(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $CSU_custid=$this->input->post('CSU_cust_id');
        $CSU_currentcard=$this->input->post('CSU_lb_curcard');
        $CSU_reason=$this->input->post('CSU_lb_reason');
        $CSU_comments=$this->input->post('CSU_ta_comments');
        $returnflag=$this->Mdl_access_card_search_update->Accesscard_update($CSU_custid,$CSU_currentcard,$CSU_reason,$CSU_comments,$USERSTAMP);
        echo json_encode($returnflag);
    }
}
