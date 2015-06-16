<?php
Class Ctrl_Active_Customer_List extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('TRIGGER/Mdl_active_customer_list');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }

    public function Index()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->Mdl_active_customer_list->CC_Active_List($UserStamp);
    }
}