<?php
Class Ctrl_Monthly_Payment_Reminder extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('TRIGGER/Mdl_monthly_payment_reminder');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }

    public function Index()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->Mdl_monthly_payment_reminder->getMonthlyPaymentReminder($UserStamp);
    }
}