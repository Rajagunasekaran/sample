<?php

class Ctrl_Report_Tickler_History extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('REPORT/Mdl_report_tickler_history');
    }
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('REPORT/Vw_Report_Tickler_History');
    }
    //FUNCTIONFOR SAVE PART
    public function TH_customername_autocomplete()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $result = $this->Mdl_report_tickler_history->customername_autocomplete($USERSTAMP,$ErrorMessage) ;
        echo JSON_encode($result);
    }
    // fetch data
    public function fetchdata()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $data=$this->Mdl_report_tickler_history->fetch_data($USERSTAMP);
        echo json_encode($data);
    }
}