<?php

class Ctrl_Customer_Extension extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_extension');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){

        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Extension');
    }
    public function CEXTN_getCommonvalues(){
        $formname=$_POST['Formname'];
        $errorlist=$_POST['ErrorList'];
        $unit = $this->Mdl_customer_extension->CEXTN_getExtnUnitNo();
        $nationality = $this->Mdl_eilib_common_function->getNationality();
        $EmailList= $this->Mdl_eilib_common_function->getProfileEmailId($formname);
        $Option= $this->Mdl_eilib_common_function->getOption();
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Timelist=$this->Mdl_eilib_common_function->getTimeList();
        $proratedlabel=$this->Mdl_eilib_common_function->CUST_getProratedWaivedValue();
        $AllUnit =$this->Mdl_eilib_common_function->getAllActiveUnits();
        $Values=array($unit,$nationality,$EmailList,$Option,$ErrorMessage,$Timelist,$proratedlabel,$AllUnit);
        echo json_encode($Values);
    }
    public function CEXTN_getCustomerNameId_result(){
        $CEXTN_lb_unitno=$_POST['unitno'];
        $customer_IdName = $this->Mdl_customer_extension->CEXTN_getCustomerNameId($CEXTN_lb_unitno);
        echo json_encode($customer_IdName);
    }
    public function  CEXTN_getCustomerdtls_result(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $CEXTN_unitno=$_POST['unitno'];
        $CEXTN_custid=$_POST['customerId'];
        $customer_finaldetls = $this->Mdl_customer_extension->CEXTN_getCustomerdtls($CEXTN_custid,$CEXTN_unitno,$UserStamp);
        echo json_encode($customer_finaldetls);
    }
    public function CEXTN_getRoomType(){
        $CEXTN_rmtype=$this->Mdl_customer_extension->CEXTN_getRoomType($this->input->post('unitno'),$this->input->post('rmtype'));
        echo json_encode($CEXTN_rmtype);
    }
    public  function CEXTN_getdiffunitCardNo(){
        $final_value=$this->Mdl_customer_extension->CEXTN_getdiffunitCardNo($this->input->post('unitno'),$this->input->post('CEXTN_tb_firstname'),$this->input->post('CEXTN_tb_lastname'));
        echo json_encode($final_value);
    }
    public  function CEXTN_chkProrated(){
        $final_value=$this->Mdl_customer_extension->CEXTN_chkProrated($this->input->post('CEXTN_db_chkindate'),$this->input->post('CEXTN_db_chkoutdate'));
        echo json_encode($final_value);
    }
    public function CEXTN_SaveDetails(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $this->load->library('Google');
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_extension');
        $final_value=$this->Mdl_customer_extension->CEXTN_SaveDetails($UserStamp);
        echo json_encode($final_value);
    }

}