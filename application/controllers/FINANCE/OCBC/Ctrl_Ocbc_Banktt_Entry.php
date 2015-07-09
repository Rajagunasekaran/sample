<?php
class Ctrl_Ocbc_Banktt_Entry extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/OCBC/Mdl_Ocbc_Banktt_Entry');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index()
    {
        $this->load->view('FINANCE/OCBC/Vw_Ocbc_Banktt_Entry');
    }
    public function Initialdata()
    {
        $query=$this->Mdl_Ocbc_Banktt_Entry->Initial_data();
        echo json_encode($query);
    }
    public function Customername(){
        $unitno= $this->input->post('unitno');
        $query=$this->Mdl_Ocbc_Banktt_Entry->Customer_name($unitno);
        echo json_encode($query);
    }
    public function Banktt_Entry_Save()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $Confirmmessage=$this->Mdl_Ocbc_Banktt_Entry->Banktt_EntrySave($UserStamp);
        echo json_encode($Confirmmessage[0]);
    }
}