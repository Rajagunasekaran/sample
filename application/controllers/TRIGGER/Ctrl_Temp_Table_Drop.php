<?php
Class Ctrl_Temp_Table_Drop extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('TRIGGER/Mdl_temp_table_drop');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }

    public function Index()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->Mdl_temp_table_drop->getTempTableDrop($UserStamp);
    }
}