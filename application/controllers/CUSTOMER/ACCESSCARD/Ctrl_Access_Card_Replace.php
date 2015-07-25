<?php
//******************************************Card Replace********************************************//
//VER 0.01-SD:07/05/2015 ED:08/05/2015,initial version BY RAJA
//*******************************************************************************************************//
class Ctrl_Access_Card_Replace extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/ACCESS CARD/Mdl_access_card_replace');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('CUSTOMER/ACCESS CARD/Vw_Access_Card_Replace');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);

        $result=$this->Mdl_access_card_replace->Initial_data($ErrorMessage);
        echo json_encode($result);
    }
    public function Avialablecard(){
        $unitno= $this->input->post('unitno');
        $cardarray=$this->Mdl_access_card_replace->Avialable_card($unitno);
        echo json_encode($cardarray);
    }
    public function Replacecardsave(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $CR_custid=$this->input->post('CR_cust_id');
        $CR_currentcard=$this->input->post('CR_lb_curcard');
        $CR_newcard=$this->input->post('CR_lb_newcard');
        $CR_reason=$this->input->post('CR_lb_reason');
        $CR_comments=$this->input->post('CR_ta_comments');
        $CR_unit_no=$this->input->post('CR_lb_unitno');
        $savearray=$this->Mdl_access_card_replace->Replacecard_save($CR_custid,$CR_currentcard,$CR_newcard,$CR_reason,$CR_comments,$CR_unit_no,$USERSTAMP);
        echo json_encode($savearray);
    }
}