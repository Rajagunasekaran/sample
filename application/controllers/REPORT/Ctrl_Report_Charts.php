<?php
//******************************************charts********************************************//
//VER 0.02-SD:27/04/2015 ED:28/04/2015,did db part BY RAJA
//VER 0.01-SD:24/04/2015 ED:25/04/2015,completed form design and validation BY RAJA
//*******************************************************************************************************//
class Ctrl_Report_Charts extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('REPORT/Mdl_report_charts');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('REPORT/Vw_Report_Charts');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $query=$this->Mdl_report_charts->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    public function Subchartdata(){
        $nameval=$this->input->post('nameval');
        $query=$this->Mdl_report_charts->Subchart_data($nameval);
        echo json_encode($query);
    }
    public function Expense_inputdata(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $unitno=$this->input->post('unitno');
        $fromdate=$this->input->post('fromdate');
        $todate=$this->input->post('todate');
        $srch_data=$this->input->post('srch_data');
        $flag=$this->input->post('flag');
        $query=$this->Mdl_report_charts->Expense_input_data($unitno,$fromdate,$todate,$srch_data,$flag,$USERSTAMP);
        echo json_encode($query);
    }
}