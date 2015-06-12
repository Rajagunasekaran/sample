<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 29-05-2015
 * Time: 05:13 PM
 */

class Ctrl_Report_Report extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('REPORT/Mdl_report_report');
    }
    //LOAD FORM
    public function index(){
        $this->load->view('REPORT/Vw_Report_Report');
    }
//FUNCTION TO GET ERR MSG
    public function REP_getdomain_err(){
          $final_value=$this->Mdl_report_report->REP_getdomain_err();
          echo json_encode($final_value);
    }
    //FUNCTION TO GET SRCH OPTION
    public function  REP_func_load_searchby_option(){
        $final_value=$this->Mdl_report_report->REP_func_load_searchby_option($this->input->post('REP_report_optionfetch'));
        echo json_encode($final_value);
    }
    //FUNCTION FOR SS PART
        public function  REP_ss_getdatas(){

            //7--customer active,6--employee card,32--ERM LEEDS,28--expenseunit
            $reportNameVal=$_POST['reportNameVal'];
            $reportNameText=$_POST['categoryName'];
            $emailId=$_POST['emailId'];
            $categoryName=$_POST['reportNameText'];
            $month=$_POST['month'];
//            $reportNameVal=31;
//            $reportNameText="EXPIRY LIST";
//            $emailId="saradagaya@gmail.com";
//
//            $categoryName="EXPIRY";
//            $month="";
           $data= $this->Mdl_report_report->getDataAppendSS($reportNameVal,$reportNameText,$emailId,$categoryName,$month);
//        $final_value=$this->Mdl_report_report->REP_func_load_searchby_option($this->input->post('REP_report_optionfetch'));
            echo $data;
    }
}
