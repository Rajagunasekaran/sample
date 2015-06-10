<?php
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
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
        $this->load->library('Google');
        $CSV_Records=$this->Mdl_configuration_trigger->getCSVfileRecords();
        echo json_encode($CSV_Records);
    }
    public function Monthlypaymentreminder()
    {
        try {
            $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
            $this->load->model('CONFIGURATION/Mdl_configuration_trigger');
            $data = $this->Mdl_configuration_trigger->getMonthlyPaymentReminder();
            $Displayname = $data[0];
            $EmailSubject = $data[1];
            $EmailBody = $data[2];
            for ($i = 0; $i < count($data[3]); $i++) {
                $EmailSubject = str_replace('[CURRENT_MONTH]', '', $EmailSubject);
                $EmailBody = str_replace('[CUSTOMER_NAME]', $data[3][$i], $EmailBody);
                $EmailBody = str_replace('[UNIT-NO]', $data[6][$i], $EmailBody);
                $EmailBody = str_replace('[RENTAL_AMOUNT]', $data[4][$i], $EmailBody);
                $message1 = new Message();
                $message1->setSender($Displayname . '<' . $UserStamp . '>');
                $message1->addTo($data[5][$i]);
                $message1->setSubject($EmailSubject);
                $message1->setHtmlBody($EmailBody);
                $message1->send();
            }
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