<?php
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
class Mdl_temp_table_drop extends CI_Model
{
    public function getTempTableDrop($trg_UserStamp)
    {
        $temptableflag=0;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $emaillistarray = $this->Mdl_eilib_common_function->getProfileEmailId('DROPTABLE');
        $name = $emaillistarray[0];
        $cclist = $emaillistarray[1];
        $username = explode('@', $name);
        $mailusername = strtoupper($username[0]);
        $emailtempquery = "SELECT *FROM EMAIL_TEMPLATE_DETAILS WHERE ET_ID=14";
        $emailtempresult = $this->db->query($emailtempquery);
        foreach ($emailtempresult->result_array() as $key => $value)
        {
            $emailsub = $value["ETD_EMAIL_SUBJECT"];
            $subject = $value["ETD_EMAIL_BODY"];
        }
        $currentmonth = date("Ymd");
        $CURRENT_MONTH = date('d-F-Y', strtotime($currentmonth));
        $InstanceName=$this->Mdl_eilib_common_function->getInstanceName();
        $schema_name=$this->Mdl_eilib_common_function->getSchemaName();
        $emailsub = str_replace('CURRENTDATE', $CURRENT_MONTH, $emailsub);
        $emailsub = str_replace('INSTANCENAME', $InstanceName, $emailsub);
        $emailsub = str_replace('SCHEMANAME', $schema_name, $emailsub);
        $emailsub = strtoupper($emailsub);
        $subject = str_replace('CURRENTDATE', $CURRENT_MONTH, $subject);
        $subject = str_replace('[INSTANCENAME]', $InstanceName, $subject);
        $subject = str_replace('[SCHEMANAME]', $schema_name, $subject);
        $subject = strtoupper($subject);
        $message = '<body><br><h> ' . $subject . '</h><br><br><table border="1" width="500" hieght="20"><tr  bgcolor="#6495ed" style="color:white"  align="center" ><td width=25%><h3>TEMP TABLE NAME(S)</h3></td></tr></table></body>';
        $this->db->query("CALL SP_DROP_PROD_TEMP_TABLE('$schema_name','$trg_UserStamp',@FINALTABLE)");
        $temtable_result = $this->db->query("SELECT @FINALTABLE AS TEMPTABLE");
        $TEMPLTABLE = $temtable_result->row()->TEMPTABLE;
        $temptableresult = $this->db->query("SELECT *FROM " . $TEMPLTABLE);
        foreach ($emailtempresult->result_array() as $key => $value) {
            $temptableflag = 1;
            $message .= '<body><table border="1" width="500" ><tr align="left" ><td align="center" width=40%>'.$value['DROPTABLENAME'].'</td></tr></table></body>';
        }
        if($temptableflag==1)
        {
            $EmailDisplayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('DROP_TEMP_TABLE');
            $this->db->query('DROP TABLE IF EXISTS ' . $TEMPLTABLE);
            $message1 = new Message();
            $message1->setSender($EmailDisplayname.'<'.$trg_UserStamp.'>');
            $message1->addTo($name);
            $message1->addCC($cclist);
            $message1->setSubject($emailsub);
            $message1->setHtmlBody($message);
            $message1->send();
        }
    }
}