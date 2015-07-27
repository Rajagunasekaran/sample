<?php
//******************************************Unit Termination********************************************//
//VER 0.01-SD:21/05/2015 ED:21/05/2015,initial version BY RAJA
//*******************************************************************************************************//
class Ctrl_Unit_Termination extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('UNIT/Mdl_unit_termination');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('UNIT/Vw_Unit_Termination');
    }
    public function Initialdata(){
        $query=$this->Mdl_unit_termination->Initial_data();
        echo json_encode($query);
    }
    public function UT_unitdetails(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $unitnumber=$this->input->post("UT_unitnumber");
        $flag_select=$this->input->post("UT_flag_select");
        $comments=$this->input->post("UT_comments");
        $unitdetails=$this->Mdl_unit_termination->UT_unit_details($unitnumber,$flag_select,$comments,$USERSTAMP);
        echo json_encode($unitdetails);
    }
}