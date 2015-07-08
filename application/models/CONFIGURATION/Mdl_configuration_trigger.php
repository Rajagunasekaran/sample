<?php
error_reporting(0);
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
class Mdl_configuration_trigger extends CI_Model {
    public function getCSVfileRecords($UserStamp)
    {
        $this->db->select("OCN_DATA");
        $this->db->from('OCBC_CONFIGURATION');
        $this->db->where('CGN_ID=29');
        $query = $this->db->get()->row()->OCN_DATA;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $CSVMailid=$this->Mdl_eilib_common_function->getProfileEmailId('CSV');
        $tomailid=$CSVMailid[0];
        $ccmailid=$CSVMailid[1];
        $maintainmailid=$CSVMailid[2];
        $service = $this->Mdl_eilib_common_function->get_service_document();
        $children1 = $service->children->listChildren($query);
        $filearray1=$children1->getItems();
        foreach ($filearray1 as $child1)
        {
            $fileid=$service->files->get($child1->getId())->id;

            $filename=$service->files->get($child1->getId())->title;
            $data = $service->files->get($fileid);
            $url=$data->downloadUrl;
            $data=$this->downloadFile($service,$url);
            $data = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $data));
            break;
        }
        $monthname=explode('.',$filename);
        $year=substr($monthname[0],0,4);
        $month=substr($monthname[0],4,2);
        $selectedmonthcsv=$monthname[0].'%';
        $month_name=date('M', strtotime($month . '01'));
        $CSVMonthname=$month_name.'-'.$year;
        /************************OCBC TABLE RECORDS************************************/
        $updatedrecordquery="SELECT OBR_TRANSACTION_DESC_DETAILS,OBR_CLIENT_REFERENCE,OBR_REF_ID,OBR_BANK_REFERENCE,OBR_POST_DATE FROM OCBC_BANK_RECORDS WHERE OBR_REF_ID LIKE '$selectedmonthcsv' ORDER BY OBR_REF_ID ASC";
        $resultset=$this->db->query($updatedrecordquery);
        $CSV_DB_Records=array();
        $AfterDBRecords=array();
        foreach ($resultset-> result_array() as $val)
        {
            $postdate = str_replace(str_split('-'), '', $val['OBR_POST_DATE']);
            $csvrow_Refid=$val['OBR_REF_ID'].'!~'.$postdate.'_'.$val['OBR_CLIENT_REFERENCE'].'_'.$val['OBR_TRANSACTION_DESC_DETAILS'].'_'.$val['OBR_BANK_REFERENCE'];
            $csvnewrowfindkey=$postdate.'_'.$val['OBR_CLIENT_REFERENCE'].'_'.$val['OBR_TRANSACTION_DESC_DETAILS'].'_'.$val['OBR_BANK_REFERENCE'];
            array_push($CSV_DB_Records,$csvrow_Refid);
            array_push($AfterDBRecords,$csvnewrowfindkey);
        }
        $DBcount=count($CSV_DB_Records);

        /************************END OF OCBC TABLE RECORDS************************************/
        /************************CSV FILE RECORDS***************************************/
        $CSV_File_comparisionRecords=array();
        $CSV_Files_Records=array();
        for($h=0;$h<count($data);$h++)
        {
            $CSV_array = $data[$h];
            if ($CSV_array != '' && $CSV_array != null && $CSV_array[11]!='')
            {
                $csv_compdate= $CSV_array[11].'_'.$CSV_array[16].'_'.$CSV_array[17].'_'.$CSV_array[18];
                array_push($CSV_File_comparisionRecords,$csv_compdate);
                $csvRecordsobj=$CSV_array[0].','.$CSV_array[1].','.$CSV_array[2].','.$CSV_array[3].','.$CSV_array[4].','.$CSV_array[5].','.$CSV_array[6].','.$CSV_array[7].','.$CSV_array[8].','.$CSV_array[9].','.$CSV_array[10].','.$CSV_array[11].','.$CSV_array[12].','.$CSV_array[13].','.$CSV_array[14].','.$CSV_array[15].','.$CSV_array[16].','.$CSV_array[17].','.$CSV_array[18].','.$CSV_array[19];
                array_push($CSV_Files_Records,$csvRecordsobj);
            }
        }
        $CSVcount=count($CSV_File_comparisionRecords);
        /***************************END OF CSV FILE RECORDS***************************************/
        /****************************ARRAY COMPARISION ******************************************/
        $REF_id=array();
        $CSV_Old_Records=array();
        $CSV_dup_oldRecords=array();
        for($i=0;$i<count($CSV_DB_Records);$i++)
        {
            $splitrefid=explode('!~',$CSV_DB_Records[$i]);
            array_push($REF_id,$splitrefid[1]);
            for($j=0;$j<count($CSV_File_comparisionRecords);$j++)
            {
                if($splitrefid[1]==$CSV_File_comparisionRecords[$j])
                {
                    $Refidconcat=$splitrefid[0].','.$CSV_Files_Records[$j];
                    $array2=explode(',',$CSV_Files_Records[$j]);
                    array_push($CSV_dup_oldRecords,$splitrefid[0].'!~'.$array2[11].'_'.$array2[16].'_'.$array2[17].'_'.$array2[18]);
                    array_push($CSV_Old_Records,$Refidconcat);
                }
            }
        }
        $CSV_Old_RecordsBC=count($CSV_Old_Records);
        $CSV_Old_Records=array_unique($CSV_Old_Records);
        $Old_rcordsCount=count($CSV_Old_Records);
        $updationdata=array();
        if($Old_rcordsCount==$DBcount)
        {
            for($k=0;$k<count($CSV_Old_Records);$k++)
            {
                $UpdateRecordsplit=explode(',',$CSV_Old_Records[$k]);
                $valuedate=$this->DateConversion($UpdateRecordsplit[13]);
                $oldrecordupdatequery="UPDATE OCBC_BANK_RECORDS SET OBR_VALUE_DATE='$valuedate',OBR_LAST_BALANCE='$UpdateRecordsplit[6]',OBR_NO_OF_CREDITS='$UpdateRecordsplit[7]',OBR_NO_OF_DEBITS='$UpdateRecordsplit[9]',OBR_OLD_BALANCE='$UpdateRecordsplit[10]',OBR_CLOSING_BALANCE='$UpdateRecordsplit[5]',OBR_D_AMOUNT='$UpdateRecordsplit[11]' WHERE OBR_REF_ID='$UpdateRecordsplit[0]'";
                $this->db->query($oldrecordupdatequery);
                array_push($updationdata,$oldrecordupdatequery);
            }
            $c=0;
            $newcsvfilerecords=array();
            $oldcsvcount=$DBcount+1;
            for($h=0;$h<count($CSV_Files_Records);$h++)
            {
                $array2=explode(',',$CSV_Files_Records[$h]);
                $reference_id=$monthname[0].''.$oldcsvcount;
                $clientrefe=$array2[16];
                if($clientrefe=='000000000001')
                {
                    $clientrefe=1;
                }
                $CSV_newRecord=$array2[11].'_'.$clientrefe.'_'.$array2[17].'_'.$array2[18];
                if(!in_array($CSV_newRecord,$AfterDBRecords))
                {
                    $csvRecordsobject=$reference_id.'!~'.$array2[0].'!~'.$array2[1].'!~'.$array2[2].'!~'.$array2[3].'!~'.$array2[4].'!~'.$array2[5].'!~'.$array2[6].'!~'.$array2[7].'!~'.$array2[8].'!~'.$array2[9].'!~'.$array2[10].'!~'.$array2[11].'!~'.$array2[12].'!~'.$array2[13].'!~'.$array2[14].'!~'.$array2[15].'!~'.$clientrefe.'!~'.$array2[17].'!~'.$array2[18].'!~'.$array2[19];
                    array_push($newcsvfilerecords,$csvRecordsobject);
                    $oldcsvcount++;
                }
                $c++;
            }
        }
        else
        {
            if($Old_rcordsCount!=$DBcount)
            {
                $dups = array();
                foreach(array_count_values($CSV_File_comparisionRecords) as $val => $c)
                    if($c > 1) $dups[] = $val;
                $duplicateRecords=count($dups);
                $csverrorbodymessage="The Following CSV Records Duplicates in CSV File     ";
                $duplicaterows=array();
                for($b=0;$b<count($dups);$b++)
                {
                    for ($a = 0; $a < count($CSV_Files_Records); $a++)
                    {
                        $CSV_array = explode(',',$CSV_Files_Records[$a]);
                        $csv_compdate = $CSV_array[11] . '_' . $CSV_array[16] . '_' . $CSV_array[17] . '_' . $CSV_array[18];
                        if ($csv_compdate == $dups[$b])
                        {
                            $csverrorbodymessage=$csverrorbodymessage.'<br><br>'.$CSV_Files_Records[$a];
                        }
                    }
                }
            }
            if($Old_rcordsCount<$DBcount)
            {
                $Missedrefid='';
                $csvmissedrecord=array_diff($CSV_DB_Records,$CSV_dup_oldRecords);
                $keyvalue=array_keys($csvmissedrecord);
                for($h=0;$h<count($keyvalue);$h++)
                {
                    $datasplit=explode('!~',$csvmissedrecord[$keyvalue[$h]]);
                    if($h==0)
                    {
                        $Missedrefid="'".$datasplit[0]."'";
                    }
                    else
                    {$Missedrefid=$Missedrefid.",'".$datasplit[0]."'";}
                }
                $errquery= "SELECT OCB.OCN_DATA AS ACCOUNT,OCA.OCN_DATA AS CURRENCY,OBR.OBR_OPENING_BALANCE,OBR.OBR_CLOSING_BALANCE,OBR.OBR_PREVIOUS_BALANCE,OBR.OBR_LAST_BALANCE,OBR.OBR_NO_OF_CREDITS,OBR.OBR_TRANS_DATE,OBR.OBR_NO_OF_DEBITS,OBR.OBR_OLD_BALANCE,OBR.OBR_D_AMOUNT,OBR.OBR_POST_DATE,OBR.OBR_VALUE_DATE,OBR.OBR_DEBIT_AMOUNT,OBR.OBR_CREDIT_AMOUNT,OCN.OCN_DATA,OBR.OBR_CLIENT_REFERENCE,OBR.OBR_TRANSACTION_DESC_DETAILS,OBR.OBR_BANK_REFERENCE,OBR.OBR_TRX_TYPE FROM OCBC_CONFIGURATION OCN,OCBC_BANK_RECORDS OBR LEFT JOIN OCBC_CONFIGURATION OCA ON OBR.OBR_CURRENCY=OCA.OCN_ID LEFT JOIN OCBC_CONFIGURATION OCB ON OBR.OBR_ACCOUNT_NUMBER=OCB.OCN_ID  WHERE OBR.OCN_ID=OCN.OCN_ID AND  OBR.OBR_REF_ID IN($Missedrefid) ORDER BY OBR.OBR_REF_ID ASC";
                $resultset=$this->db->query($errquery);

                $missing_csverrorbodymessage="The Following DB CSV Records Wrong or Missing in CSV File Compare to Previous Day CSV File    ";
                foreach ($resultset-> result_array() as $val)
                {
                    $error=$val['ACCOUNT'].','.$val['CURRENCY'].','.$val['OBR_OPENING_BALANCE'].','.$val['OBR_CLOSING_BALANCE'].','.$val['OBR_PREVIOUS_BALANCE'].','.$val['OBR_LAST_BALANCE'].','.$val['OBR_NO_OF_CREDITS'].','.$val['OBR_TRANS_DATE'].','.$val['OBR_NO_OF_DEBITS'].','.$val['OBR_OLD_BALANCE'].','.$val['OBR_D_AMOUNT'].','.$val['OBR_POST_DATE'].','.$val['OBR_VALUE_DATE'].','.$val['OBR_DEBIT_AMOUNT'].','.$val['OBR_CREDIT_AMOUNT'].','.$val['OBR_CLIENT_REFERENCE'].','.$val['OBR_TRANSACTION_DESC_DETAILS'].','.$val['OBR_BANK_REFERENCE'].','.$val['OBR_TRX_TYPE'];
                    $missing_csverrorbodymessage=$missing_csverrorbodymessage.'<br><br>'.$error;
                }
            }
            if(count($dups)!=0){$mesgbody=$csverrorbodymessage;}
            else{$mesgbody=$missing_csverrorbodymessage;}
            $mesg_body='<body><br><h> ' . $mesgbody . '</h><br><br>';
            $Subject="WARNING MESSAGE";
            $this->Warningmailpart($Subject,$mesg_body,'CSV',$UserStamp,$maintainmailid);
            echo 'success';
            exit;
        }
        if(count($newcsvfilerecords)!=0)
        {
            $csvlength=1;
            $date_array=array();
            $Ref_array=array();
            $debit_array=array();
            $credit_array=array();
            $mailrecord_array=array();
            $newdatearray=array();
            $creditcount=0;
            $debitcount=0;
            $timestamp=array();
            $csv_timstamp=date("Y-m-d H:i:s");;
            for($csv=0;$csv<count($newcsvfilerecords);$csv++)
            {
                $mailflag=1;
                $CSV_array=explode('!~',$newcsvfilerecords[$csv]);
                $transdate=$this->DateConversion($CSV_array[8]);
                $postdate=$this->DateConversion($CSV_array[12]);
                $valuedate=$this->DateConversion($CSV_array[13]);
                $refid=$CSV_array[0];
                $debitamt=$CSV_array[14];
                if($debitamt!="0.00" && $debitamt!=0 && $debitamt!=" " && $debitamt!="")
                {
                    $debitcount++;
                }
                array_push($debit_array,$debitamt);
                $creditamt=$CSV_array[15];
                if($creditamt!="0.00" && $creditamt!=0 && $creditamt!=" " && $creditamt!="")
                {
                    $creditcount++;
                }
                array_push($credit_array,$creditamt);
                $concat=$CSV_array[17].'-'.$CSV_array[18].'-'.$CSV_array[19];
                $csvmailrecord=$debitamt.','.$creditamt.','.$concat;
                array_push($mailrecord_array,$csvmailrecord);
                array_push($Ref_array,$concat);
                array_push($newdatearray,$CSV_array[13]);
                $creditamt=$creditamt;
                $debitamt=$debitamt;
                $bankreff=$CSV_array[17];
                if($bankreff=='000000000001')
                {
                    $bankreff=1;
                }
                if($bankreff!="" && $bankreff!=1)
                {
                    $bankreff=$this->db->escape_like_str($bankreff);
                }
                $transaction_details=$CSV_array[18];
                if($transaction_details!="")
                {
                    $transaction_details=$this->db->escape_like_str($transaction_details);
                }
                $bankreference=$CSV_array[19];
                if($bankreference!="")
                {
                    $bankreference=$this->db->escape_like_str($bankreference);
                }
                if($creditamt==" " || $creditamt=="")
                {
                    $creditamt=null;
                }
                if($debitamt==" " || $debitamt=="")
                {
                    $debitamt=null;
                }
                if($CSV_array[10]=="" || $CSV_array[10]==" ")
                {
                    $csv_oldbal=0;
                }
                else
                {
                    $csv_oldbal=$CSV_array[10];
                }
                $OCBC_CSV_insertquery="INSERT INTO OCBC_BANK_RECORDS(OBR_ACCOUNT_NUMBER,OBR_CURRENCY,OBR_PREVIOUS_BALANCE,OBR_OPENING_BALANCE,OBR_CLOSING_BALANCE,OBR_LAST_BALANCE,OBR_NO_OF_CREDITS,OBR_TRANS_DATE,OBR_NO_OF_DEBITS,OBR_OLD_BALANCE,OBR_D_AMOUNT,OBR_POST_DATE,OBR_VALUE_DATE,OBR_DEBIT_AMOUNT,OBR_CREDIT_AMOUNT,OCN_ID,OBR_CLIENT_REFERENCE,OBR_TRANSACTION_DESC_DETAILS,OBR_BANK_REFERENCE,OBR_TRX_TYPE,OBR_REF_ID,ULD_ID,OBR_TIMESTAMP) VALUES( (SELECT OCN_ID FROM OCBC_CONFIGURATION WHERE OCN_DATA= '$CSV_array[1]'),(SELECT OCN_ID FROM OCBC_CONFIGURATION WHERE OCN_DATA= '$CSV_array[2]' ),'$CSV_array[3]', '$CSV_array[4]', '$CSV_array[5]', '$CSV_array[6]', '$CSV_array[7]','$transdate', '$CSV_array[9]', '$csv_oldbal', '$CSV_array[11]', '$postdate', '$valuedate','$debitamt', '$creditamt',(SELECT OCN_ID FROM OCBC_CONFIGURATION WHERE OCN_DATA='$CSV_array[16]'), '$bankreff','$transaction_details','$bankreference','$CSV_array[20]','$CSV_array[0]',(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$UserStamp'),'$csv_timstamp')";
                $this->db->query($OCBC_CSV_insertquery);
            }
            if($mailflag==1)
            {
                $CSVcount=count($CSV_Files_Records);
                $outparm_query = "SELECT CSV_ID FROM CSV_CONFIGURATION WHERE CSV_MONTH='$CSVMonthname'";
                $outparm_result = $this->db->query($outparm_query);
                $CSVMONTHID = $outparm_result->row()->CSV_ID;
                $sortnumrows=$this->db->affected_rows();
                if($sortnumrows!=1)
                {
                    $OCBC_CSV_count_insertquery = "INSERT INTO CSV_CONFIGURATION(CSV_MONTH,CSV_COUNT,ULD_ID) VALUES('$CSVMonthname',$CSVcount,(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$UserStamp'))";
                }
                else
                {
                    $OCBC_CSV_count_insertquery = "UPDATE CSV_CONFIGURATION SET CSV_COUNT=$CSVcount,ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$UserStamp') WHERE CSV_ID='$CSVMONTHID'";
                }
                    $this->db->query($OCBC_CSV_count_insertquery);
                for($ar=0;$ar<count($newdatearray);$ar++)
                {
                    $value_date=$this->Dateconversionnewdateformat($newdatearray[$ar]);
                    array_push($date_array,$value_date);
                }
                $final_count=array();
                $current = null;
                $cnt = 0;
                for ($i = 0; $i < count($date_array); $i++)
                {
                    if ($date_array[$i] != $current) {
                        if ($cnt > 0)
                        {
                            array_push($final_count, $cnt);
                        }
                        $current = $date_array[$i];
                        $cnt = 1;
                    }
                    else
                    {
                        $cnt++;
                    }
                }
                if ($cnt > 0) {
                    array_push($final_count,$cnt);
                }
            }
            //************MAIL PART*****************//
            //MAIL SENDING PART
            $totalcount=$creditcount+$debitcount;
            $unique=array_unique($date_array);
            $key_value=array_keys($unique);
            $uniquedate=array();
            for($s=0;$s<count($key_value);$s++)
            {
                array_push($uniquedate,$unique[$key_value[$s]]);
            }
            for($i=0;$i<count($uniquedate);$i++)
            {
                if($i==0){$Header=$uniquedate[$i];}else{$Header=$Header.','.$uniquedate[$i];}

            }
            $unique=$this->make_unique($date_array, '');
            $d=$Header." = ".$totalcount." ( ".$creditcount." - CREDIT(S) ,".$debitcount." - DEBIT(S) ) NEW RECORDS UPDATED SUCCESSFULLY";
            $message = '<body><br><h> '.$d.'</h><br><br><table border="1"  width="800">';
            $message.='<tr bgcolor="#6495ed" style="color:white" align="center" >';
            $message.='<td width=12%><h3>DATE</h3></td><td width=9%><h3>CREDIT</h3></td><td width=9%><h3>DEBIT</h3></td><td width=50%><h3>BANK REFERENCE</h3></td></tr>';
            $sum=0;
            for($v=0;$v<count($final_count);$v++)
            {
                $limit=$sum+$final_count[$v];
                for($b=$sum;$b<$limit;$b++)
                {
                    $data=explode(',',$mailrecord_array[$b]);
                    if($data[1]=="0.00" || $data[1]==0)
                    {
                        $creditamount="";
                    }
                    else
                    {
                        $creditamount=$data[1];
                    }
                    if($data[0]=="0.00" || $data[0]==0)
                    {
                        $debitamount="";
                    }
                    else
                    {
                        $debitamount=$data[0];
                    }
                    if($b==$sum)
                    {
                        if($b!=0)
                        {
                            $message.='<tr align="center" ><td align="center" style="font-weight:bold;border-top:2px solid blue;" width=12% rowspan='.$final_count[$v].'>'.$uniquedate[$v].'</td><td width=9% style="border-top:2px solid blue;">'.$creditamount.'</td><td width=9% style="border-top:2px solid blue;">'.$debitamount.'</td><td width=50% style="border-top:2px solid blue;">'.$data[2].'</td></tr>';
                        }
                        else
                        {
                            $message.='<tr align="center" ><td align="center" style="font-weight:bold;" width=12% rowspan='.$final_count[$v].'>'.$uniquedate[$v].'</td><td width=9% >'.$creditamount.'</td><td width=9%>'.$debitamount.'</td><td width=50% >'.$data[2].'</td></tr>';
                        }
                    }
                    else
                    {
                        $message.='<tr align="center" ><td width=9%>'.$creditamount.'</td><td width=9%>'.$debitamount.'</td><td width=50%>'.$data[2].'</td></tr>';
                    }
                }
                $sum=$sum+$final_count[$v];
            }
            $message.='</table></body>';
            $subjectmess='DATABASE UPDATED-['.$Header.']';
            $this->Confirmmailpart($subjectmess,$message,'CSV',$UserStamp,$tomailid,$ccmailid);
            $this->Warningmailpart($subjectmess,$d,'CSV',$UserStamp,$maintainmailid);
            echo 'success';
            exit;
        }
        else
        {
            $Subject="CONFIRMATION";
            $message="NEW DATA NOT AVAILABLE IN CSV FILE";
            $this->Warningmailpart($Subject,$message,'CSV',$UserStamp,$maintainmailid);
            echo 'success';
            exit;
        }
    }
    public function Confirmmailpart($Emailsub,$Messagebody,$Displayname,$UserStamp,$tomailid,$ccmailid)
    {
        $message1 = new Message();
        $message1->setSender($Displayname . '<' . $UserStamp . '>');
        $message1->addTo($tomailid);
        $message1->addCC($ccmailid);
        $message1->setSubject($Emailsub);
        $message1->setHtmlBody($Messagebody);
        $message1->send();
    }
    public function Warningmailpart($mailsub,$mailbody,$EmailDisplayname,$UserStamp,$CSVMailid)
    {
        $message1 = new Message();
        $message1->setSender($EmailDisplayname . '<' . $UserStamp . '>');
        $message1->addTo($CSVMailid);
        $message1->setSubject($mailsub);
        $message1->setHtmlBody($mailbody);
        $message1->send();
    }
    public function getTriggerConfiguration()
    {
        $Selectquery="SELECT TC_ID,TC_DATA FROM TRIGGER_CONFIGURATION WHERE CGN_ID=31 ORDER BY TC_DATA ASC";
        $resultset=$this->db->query($Selectquery);
        return $resultset->result();
    }
    function downloadFile($service, $downloadUrl)
    {
        if ($downloadUrl) {
            $request = new Google_Http_Request($downloadUrl, 'GET', null, null);
            $httpRequest = $service->getClient()->getAuth()->authenticatedRequest($request);
            if ($httpRequest->getResponseHttpCode() == 200) {
                return $httpRequest->getResponseBody();
            } else {
                echo "errr";
                return null;
            }
        } else {
            echo "empty";
            return null;
        }
    }
    function DateConversion($input)
    {
        $year=substr($input,0,4);
        $month=substr($input,4,2);
        $day=substr($input,6,2);
        return $year.'-'.$month.'-'.$day;
    }
    function Dateconversionnewdateformat($input)
    {

        $year=substr($input,0,4);
        $month=substr($input,4,2);
        $day=substr($input,6,2);
        return $day.'-'.$month.'-'.$year;
    }
    function make_unique($array, $ignore)
    {
        while($values = each($array))
        {
            if(!in_array($values[1], $ignore))
            {
                $dupes = array_keys($array, $values[1]);
                unset($dupes[0]);
                foreach($dupes as $rmv)
                {
                    unset($array[$rmv]);
                }
            }
        }
        return $array;
    }
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

    public function getNonPaymentReminder($UserStamp)
    {
        $currentmonth=date("Ymd");
        $CURRENT_MONTH=date('F-Y', strtotime($currentmonth));
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $PAYMENT_reminderdisplayname=$this->Mdl_eilib_common_function->Get_MailDisplayName("NON PAYMENT REMINDER");
        $Reminder_emailtempquery="SELECT *FROM EMAIL_TEMPLATE_DETAILS WHERE ET_ID=1";
        $resultset=$this->db->query($Reminder_emailtempquery);
        foreach ($resultset->result_array() as $key=>$val)
        {
            $Emailsubject=$val['ETD_EMAIL_SUBJECT'];
            $Emailbody=$val['ETD_EMAIL_BODY'];
        }
        $PAYMENT_reminderquery="SELECT DISTINCT CUSTOMERNAME,CUSTOMER_ID,CPD_EMAIL,UNIT_NO,CED_REC_VER,CLP_STARTDATE,PAYMENT,DATE_FORMAT(CLP_STARTDATE,'%M-%Y') AS STARTDATE FROM VW_PAYMENT_CURRENT_ACTIVE_CUSTOMER WHERE CLP_ENDDATE>CURDATE() AND CLP_STARTDATE<=CURDATE()AND(CLP_PRETERMINATE_DATE IS NULL OR CLP_PRETERMINATE_DATE>CURDATE()) AND UNIT_NO=1118";
        $resultset=$this->db->query($PAYMENT_reminderquery);
        $nonpayment=array();
        $curr_monthpaid=array();
        foreach ($resultset->result_array() as $key=>$val)
        {
            $Paid_Forperiod="";
            $PAYMENT_remindercustomername=$val['CUSTOMERNAME'];
            $PAYMENT_remindercustomermailid=$val['CPD_EMAIL'];
            $PAYMENT_remindercustomerid=$val['CUSTOMER_ID'];
            $PAYMENT_remindercustomerrent=$val['PAYMENT'];
            $PAYMENT_remindercustomerrecver=$val['CED_REC_VER'];
            $PAYMENT_remindercustomerunit=$val['UNIT_NO'];
            $PAYMENT_remindercustomerstartdate=$val['CLP_STARTDATE'];
            $Customerstartdate=$val['STARTDATE'];
            $subject1=$Emailsubject;
            $customername=str_replace('[CUSTOMER_NAME]',$PAYMENT_remindercustomername,$Emailbody);
            $unitno=str_replace('[UNIT-NO]',$PAYMENT_remindercustomerunit,$customername);
            $unitno=str_replace('[RENTAL_AMOUNT]',$PAYMENT_remindercustomerrent,$unitno);
            $message = '<body><br><h> '.$unitno.'</h><br><br><table border="1" width="300" hieght="20"><tr  bgcolor="#6495ed" style="color:white"  align="center" ><td width=25%><h3>FORPERIOD</h3></td></tr></table></body>';
            $PAYMENT_Paidquery="SELECT PD_FOR_PERIOD,DATE_FORMAT(PD_FOR_PERIOD,'%M-%Y') AS PD_FORPERIOD FROM PAYMENT_DETAILS WHERE CUSTOMER_ID='$PAYMENT_remindercustomerid' AND PP_ID=1 AND CED_REC_VER='$PAYMENT_remindercustomerrecver' ORDER BY PD_FOR_PERIOD DESC LIMIT 1";
            $PAYMENT_Paidresult=$this->db->query($PAYMENT_Paidquery);
            $numrows=$this->db->affected_rows();
            if($numrows!=0)
            {
                foreach ($PAYMENT_Paidresult->result_array() as $key => $value)
                 {
                    $lastforperiod = $value['PD_FOR_PERIOD'];
                    $Paid_Forperiod = $value['PD_FORPERIOD'];
                 }
            }
            else
            {
                $Paid_Forperiod="";
            }
            if($CURRENT_MONTH==$Paid_Forperiod)
            {
                array_push($nonpayment,$Paid_Forperiod);
            }
            else
            {
//                if($Paid_Forperiod=='' || $Paid_Forperiod==null)
//                {
                    $message .= '<body><table border="1"width="300" hieght="20" color="white" ><tr align="center"  ><td width=25%>'.$Paid_Forperiod.'</td></tr></table></body>';
//                    Remindermailpart($subject1,$message,$PAYMENT_reminderdisplayname,$UserStamp,$PAYMENT_remindercustomerid)
//                 }
//                array_push($curr_monthpaid,$Paid_Forperiod);
            }
        }
//        print_r($nonpayment);
        print_r($curr_monthpaid);
        exit;
    }
    public function getPurgeDocument()
    {
        $durationquery = "SELECT TC_DATA FROM TRIGGER_CONFIGURATION WHERE CGN_ID=74";
        $durationresult = $this->db->query($durationquery);
        foreach ($durationresult->result_array() as $key => $val) {
            $No_of_days = $val['TC_DATA'];
        }
        $fileprofileQuery = "SELECT FP_FOLDER_ID FROM FILE_PROFILE WHERE FP_ID=6";
        $fileprofileresult = $this->db->query($fileprofileQuery);
        $fileid_array = array();
        foreach ($fileprofileresult->result_array() as $key => $val) {
            array_push($fileid_array, $val['FP_FOLDER_ID']);
        }
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $service = $this->Mdl_eilib_common_function->get_service_document();
        for ($i = 0; $i< count($fileid_array); $i++)
        {
            $children1 = $service->children->listChildren($fileid_array[$i]);
            $filearray1=$children1->getItems();
            foreach ($filearray1 as $child1)
            {
                $fileid=$service->files->get($child1->getId())->id;
                $filename=$service->files->get($child1->getId())->title;
                $data = $service->files->get($fileid);
                $date1 = date("Y-m-d");
                $docdate=$data->createdDate;
                $date2=substr($docdate,0,10);
                $date1 = date_create($date1);
                $date2 = date_create($date2);
                $diff = date_diff($date1,$date2);
                $DIFF=$diff->format("%a");
                if($DIFF <= $No_of_days)
                {
                  $this->Mdl_eilib_common_function->DeleteFile($service, $fileid);
                }
            }
            return 1;
      }
    }
    public function getCustomerExpiryXWeek($UserStamp){

//        try
//        {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $CWEXP_weekBefore=1;
        $CWEXP_select_emaildata="SELECT * from EMAIL_TEMPLATE_DETAILS WHERE ET_ID=10";
        $CWEXP_emaildata_rs=$this->db->query($CWEXP_select_emaildata);
        foreach($CWEXP_emaildata_rs->result_array() as $row){
            $CWEXP_subject_db=$row["ETD_EMAIL_SUBJECT"];
            $CWEXP_message_db=$row["ETD_EMAIL_BODY"];
        }
        $CWEXP_select_emaildata="SELECT * from EMAIL_TEMPLATE_DETAILS WHERE ET_ID=12";
        $CWEXP_emaildata_rs=$this->db->query($CWEXP_select_emaildata);
        foreach($CWEXP_emaildata_rs->result_array() as $row){
            $CWEXP_subject_db1=$row["ETD_EMAIL_SUBJECT"];
            $CWEXP_message_db1=$row["ETD_EMAIL_BODY"];
        }
        $CWEXP_check_week_flag=0;
//           $CWEXP_check_weekly_expiry_list;
        $CEXP_temptable_query=("CALL SP_CUSTOMER_WEEKLY_EXPIRY_ONE_WEEK('".$UserStamp."',@CEXP_WEEKLYFEETMPTBLNAM)");
        $this->db->query($CEXP_temptable_query);
        $CEXP_beforefeetemptbl_query="SELECT @CEXP_WEEKLYFEETMPTBLNAM AS TEMP_TABLE";
        $CEXP_beforefeetemptblres=$this->db->query($CEXP_beforefeetemptbl_query);
        $CEXP_weeklytemptblname=$CEXP_beforefeetemptblres->row()->TEMP_TABLE;
        $CEXP_select_customerdetails="SELECT * FROM ".$CEXP_weeklytemptblname;
        $CWEXP_customerdetails_result=$this->db->query($CEXP_select_customerdetails);
        $count_rows= $CWEXP_customerdetails_result->num_rows();
        if($count_rows>0) {
            foreach ($CWEXP_customerdetails_result->result_array() as $row) {
                $CWEXP_unitno = $row["UNITNO"];
                $CWEXP_firstname = $row["CUSTOMERFIRSTNAME"];
                $CWEXP_lastname = $row["CUSTOMERLASTNAME"];
                $CWEXP_rental = $row["PAYMENT"];
                $CWEXP_emailid = $row["EMAILID"];
                $CWEXP_mail_username = explode('@', $CWEXP_emailid);
                $CWEXP_cust_name = $CWEXP_firstname . ' ' . $CWEXP_lastname;
                $CWEXP_enddate = $row["ENDDATE"];
                $CWEXP_ptddate = $row["PRETERMINATEDATE"];
                $unitcustomer = $CWEXP_unitno . "-" . $CWEXP_cust_name;
                $subjectdb = str_replace('[UNIT NO - CUSTOMER NAME]', $unitcustomer, $CWEXP_subject_db1);
                $subjectmail = str_replace('X', $CWEXP_weekBefore, $subjectdb);
                if ($CWEXP_ptddate == null) {
                    $CWEXP_newdate = date('d-m-Y', strtotime($CWEXP_enddate));
                } else {
                    $CWEXP_newdate = date('d-m-Y', strtotime($CWEXP_ptddate));
                }
                $CWEXP_subject = str_replace("'X'", $CWEXP_weekBefore, $CWEXP_subject_db);
                $message = str_replace("[MAILID_USERNAME]", strtoupper($CWEXP_mail_username[0]), $CWEXP_message_db1);
                $message1 = str_replace('[CHECK_OUT_DATE]', $CWEXP_newdate, $message);
                $CWEXP_check_week_flag = 1;
                $CWEXP_emailmessage = '<body><br><h>' . $message1 . '</h><br><br><table border="1" style="color:white" width="700"><tr  bgcolor="#498af3" align="center"><td width=25% ><h3>UNIT</h3></td><td width=25%><h3>CUSTOMER NAME</h3></td><td width=25%><h3>END DATE</h3></td><td width=25%><h3>RENT</h3></td></tr></table></body>';
                $CWEXP_emailmessage .= '<body><table border="1" width="700" ><tr align="center"><td width=25%>' . $CWEXP_unitno . '</td><td width=25%>' . $CWEXP_cust_name . '</td><td width=25%>' . $CWEXP_newdate . '</td><td width=25%>' . $CWEXP_rental . '</td></tr></table></body>';
                $displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName("CUSTOMER_EXPIRY");
                $this->Expirymailpart($CWEXP_emailid, $subjectdb, $CWEXP_emailmessage, $displayname, $UserStamp);
            }
            $drop_query = "DROP TABLE " . $CEXP_weeklytemptblname;
            $this->db->query($drop_query);
            return 1;

        }
        else{
            return 0;
        }


    }
    public function Expirymailpart($CWEXP_emailid,$CWEXP_subject,$CWEXP_emailmessage,$displayname,$UserStamp)
    {
        $message1 = new Message();
        $message1->setSender($displayname.'<'.$UserStamp.'>');
        $message1->addTo($CWEXP_emailid);
        $message1->setSubject($CWEXP_subject);
        $message1->setHtmlBody($CWEXP_emailmessage);
        $message1->send();
    }
}