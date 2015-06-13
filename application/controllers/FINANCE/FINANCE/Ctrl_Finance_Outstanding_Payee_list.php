<?php
error_reporting(0);
Class Ctrl_Finance_Outstanding_Payee_list extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/FINANCE/Mdl_finance_outstanding_payee_list');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function Index()
    {
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Outstanding_Payee_list');
    }
    public function ProfileEmailId()
    {
        $Emaillist = $this->Mdl_eilib_common_function->getProfileEmailId('OPL&ACTIVE CC');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Returnvalues=array($Emaillist,$ErrorMessage);
        echo json_encode($Returnvalues);
    }
    public function FIN_OPL_opllist()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $Emailid=$_POST['FIN_OPL_lb_mailid'];
        $Forperiod=$_POST['FIN_OPL_db_period'];
        $confirm_message=$this->Mdl_finance_outstanding_payee_list->OPL_list_creation($UserStamp);
        echo json_encode($confirm_message);
    }

}