<?php
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
class Mdl_active_customer_list extends CI_Model
{
    public function CC_Active_List($UserStamp)
    {
        set_time_limit(0);
        $currentmonth=date("Ymd");
        $period=date('F Y', strtotime($currentmonth));
        $activecclist = "CALL SP_ACTIVE_CUSTOMERLIST('$period','$UserStamp',@TEMP_OPL_ACTIVECUSTOMER_TABLE,@TEMP_OPL_SORTEDACTIVECUSTOMER_TABLE)";
        $this->db->query($activecclist);
        $outparm_query = 'SELECT @TEMP_OPL_ACTIVECUSTOMER_TABLE AS TEMP_TABLE1,@TEMP_OPL_SORTEDACTIVECUSTOMER_TABLE AS TEMP_TABLE2';
        $outparm_result = $this->db->query($outparm_query);
        $activelisttablename = $outparm_result->row()->TEMP_TABLE1;
        $sortactivelisttablename = $outparm_result->row()->TEMP_TABLE2;
        $FIN_Active_listquery = "SELECT *FROM $activelisttablename ORDER BY UNIT_NO,CUSTOMERNAME";
        $result1 = $this->db->query($FIN_Active_listquery);
        $numrows = $this->db->affected_rows();
        $FIN_Active_sortlistquery = "SELECT *FROM $sortactivelisttablename ORDER BY ENDDATE ASC";
        $sortresult = $this->db->query($FIN_Active_sortlistquery);
        $sortnumrows = $this->db->affected_rows();
        $headerdata = 'UNIT,CUSTOMER,STARTDATE,ENDDATE,RENT,DEPOSIT,PROCESSING FEE,TERMINATE,PRE TERMINATE,PRE TERMINATE DATE,COMMENTS';
        $FIN_ACT_folresult = $this->db->query("SELECT PCN_DATA FROM PAYMENT_CONFIGURATION WHERE CGN_ID=49");
        $folderid = $FIN_ACT_folresult->row()->PCN_DATA;
        $this->load->library('Google');
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $EmailDisplayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('ACTIVE_CC_LIST');
        $Sendmailid=$this->Mdl_eilib_common_function->getProfileEmailId('ACTIVE_CC_TRIGGER');
        $service = $this->Mdl_eilib_common_function->get_service_document();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $SS_name = 'ACTIVE CUST LIST' . '-' . date("dmY");
        $FILEID = $this->Mdl_eilib_common_function->NewSpreadsheetCreationwithurl($service, $SS_name, 'CUSTOMER_DETAILS', $folderid);
        $ActiveCustomerList = array('ACtiveflag' => 10, 'header' => $headerdata, "Rows" => $numrows, "period" => $period, "SortRows" => $sortnumrows, "Fileid" => $FILEID[0]);
        $i = 0;
        foreach ($result1->result_array() as $key => $value) {
            $key = 'data' . $i;
            $unit = $value["UNIT_NO"];
            $customername = $value["CUSTOMERNAME"];
            $Startdate = $value["STARTDATE"];
            $Enddate = $value["ENDDATE"];
            $Payment = $value["PAYMENT_AMOUNT"];
            $Deposit = $value["DEPOSIT"];
            $ProcessingFee = $value['PROCESSING_FEE'];
            $Terminate = $value['CLP_TERMINATE'];
            $Preterminate = $value['PRETERMINATE'];
            $Preterminatedate = $value['PRETERMINATEDATE'];
            $Comments = $value['COMMENTS'];
            $data = $unit . '!~' . $customername . '!~' . $Startdate . '!~' . $Enddate . '!~' . $Payment . '!~' . $Deposit . '!~' . $ProcessingFee . '!~' . $Terminate . '!~' . $Preterminate . '!~' . $Preterminatedate . '!~' . $Comments;
            $ActiveCustomerList[$key] = $data;
            $i++;
        }
        $i = 0;
        foreach ($sortresult->result_array() as $key => $value) {
            $key = 'sortdata' . $i;
            $unit = $value["UNIT_NO"];
            $customername = $value["CUSTOMERNAME"];
            $Startdate = $value["STARTDATE"];
            $Enddate = $value["ENDDATE"];
            $Payment = $value["PAYMENT_AMOUNT"];
            $Deposit = $value["DEPOSIT"];
            $ProcessingFee = $value['PROCESSING_FEE'];
            $Terminate = $value['CLP_TERMINATE'];
            $Preterminate = $value['PRETERMINATE'];
            $Preterminatedate = $value['PRETERMINATEDATE'];
            $Comments = $value['COMMENTS'];
            $data = $unit . '!~' . $customername . '!~' . $Startdate . '!~' . $Enddate . '!~' . $Payment . '!~' . $Deposit . '!~' . $ProcessingFee . '!~' . $Terminate . '!~' . $Preterminate . '!~' . $Preterminatedate . '!~' . $Comments;
            $ActiveCustomerList[$key] = $data;
            $i++;
        }
        $this->db->query('DROP TABLE IF EXISTS ' . $activelisttablename);
        $this->db->query('DROP TABLE IF EXISTS ' . $sortactivelisttablename);
        $Returnvalue = $this->Mdl_eilib_common_function->Func_curl($ActiveCustomerList);
        $subject = 'ACTIVE CUST LIST-' . date("dmY");
        $MailidSplit = explode('@', $Sendmailid[0]);
        $Username = strtoupper($MailidSplit[0]);
        $mailbody = "HELLO  " . $Username;
        $mailbody = $mailbody . '' . '<br><br>, PLEASE FIND ATTACHED THE CURRENT : ' . $FILEID[1];
        $message1 = new Message();
        $message1->setSender($EmailDisplayname.'<'.$UserStamp.'>');
        $message1->addTo($Sendmailid[0]);
        $message1->addCC($Sendmailid[1]);
        $message1->setSubject($subject);
        $message1->setHtmlBody($mailbody);
        $message1->send();
    }
}