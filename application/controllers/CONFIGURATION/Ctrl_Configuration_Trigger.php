<?php
Class Ctrl_Configuration_Trigger extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('CONFIGURATION/Mdl_configuration_trigger');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function Index()
    {
    $this->load->view('CONFIGURATION/Vw_Configuration_Trigger');
    }
    public function TriggerConfiguration()
    {
        $data = $this->Mdl_configuration_trigger->getTriggerConfiguration();
        echo json_encode($data);
    }
    public function CSV_Updation()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp($UserStamp);
        $this->load->library('Google');
        $CSV_Records=$this->Mdl_configuration_trigger->getCSVfileRecords();
        echo json_encode($CSV_Records);
    }
    public function Monthlypaymentreminder()
    {
        try {
            $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
            $this->load->model('CONFIGURATION/Mdl_configuration_trigger');
            $data = $this->Mdl_configuration_trigger->getMonthlyPaymentReminder($UserStamp);
            echo json_encode('SUCCESS');
        }
        catch (Exception $e)
        {
            echo $e->getMessage();

        }
    }
   public function Nonpaymentreminder()
    {
        $data = $this->Mdl_configuration_trigger->getNonPaymentReminder();
    }

}