<?php
Class Ctrl_Customer_Termination extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('TRIGGER/Mdl_customer_termination');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }

    public function Index()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->Mdl_customer_termination->Customer_Termination($UserStamp);
    }
}