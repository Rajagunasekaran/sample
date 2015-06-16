<?php
error_reporting(0);
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
class Mdl_monthly_payment_reminder extends CI_Model
{
    public function getMonthlyPaymentReminder($UserStamp)
    {
        $currentmonth=date("Ymd");
        $current_month=strtoupper(date('F Y', strtotime($currentmonth)));
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $PAYMENT_reminderdisplayname=$this->Mdl_eilib_common_function->Get_MailDisplayName("MONTHLY_PAYMENT_REMINDER");
        $Reminder_emailtempquery="SELECT *FROM EMAIL_TEMPLATE_DETAILS WHERE ET_ID=11";
        $resultset=$this->db->query($Reminder_emailtempquery);
        foreach ($resultset->result_array() as $key=>$val)
        {
            $Emailsubject=$val['ETD_EMAIL_SUBJECT'];
            $Emailbody=$val['ETD_EMAIL_BODY'];
        }
        $PAYMENT_reminderquery="SELECT DISTINCT CUSTOMERNAME,PAYMENT,CPD_EMAIL,UNIT_NO FROM VW_PAYMENT_CURRENT_ACTIVE_CUSTOMER WHERE CLP_ENDDATE>CURDATE() AND CLP_STARTDATE<=CURDATE()AND(CLP_PRETERMINATE_DATE IS NULL OR CLP_PRETERMINATE_DATE>CURDATE())";
        $resultset=$this->db->query($PAYMENT_reminderquery);
        $PaymentRemainder=array();
        foreach ($resultset->result_array() as $key=>$val)
        {
            $customer=$val['CUSTOMERNAME'];
            $payment=$val['PAYMENT'];
            $email=$val['CPD_EMAIL'];
            $unit=$val['UNIT_NO'];
            $EmailSubject = str_replace('[CURRENT_MONTH]',$current_month, $Emailsubject);
            $EmailBody = str_replace("'[CUSTOMER_NAME]'", $customer, $Emailbody);
            $EmailBody = str_replace('[UNIT-NO]', $unit, $EmailBody);
            $EmailBody = str_replace('[RENTAL_AMOUNT]', $payment, $EmailBody);
            $EmailBody = str_replace('[CURRENT MONTH]', $current_month, $EmailBody);
            array_push($PaymentRemainder,$EmailSubject,$EmailBody);
            $this->Remindermailpart($EmailSubject,$EmailBody,$PAYMENT_reminderdisplayname,$UserStamp,$email);
        }
    }
    public function Remindermailpart($mailsub,$mailbody,$EmailDisplayname,$UserStamp,$Mailid)
    {
        $message1 = new Message();
        $message1->setSender($EmailDisplayname.'<'.$UserStamp.'>');
        $message1->addTo($Mailid);
        $message1->setSubject($mailsub);
        $message1->setHtmlBody($mailbody);
        $message1->send();
    }

}