<?php
error_reporting(0);
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
//require_once 'PHPMailer-master/PHPMailerAutoload.php';
class Mdl_customer_creation_uat extends CI_Model
{
     private $uat;
 function __construct() {
 parent::__construct();
 $this->uat = $this->load->database('uat', TRUE);
 }
 public function test(){
 $query = $this->uat->query('SELECT * FROM LCE_CHECKLIST');
 print_r($query->result());exit;
 return $query->result();
}
    public function Customer_Creation_Save($UserStamp,$Leaseperiod,$Quoters)
    {
        try {
            $FirstName = $_POST['CCRE_FirstName'];
            $Lastname = $_POST['CCRE_LastName'];
            $CompanyName = $_POST['CCRE_CompanyName'];
            $CompanyAddress = $_POST['CCRE_CompanyAddress'];
            $CompanyPostalCode = $_POST['CCRE_CompanyPostalCode'];
            $Emailid = $_POST['CCRE_Emailid'];
            $Mobile = $_POST['CCRE_Mobile'];
            $IntlMobile = $_POST['CCRE_IntlMobile'];
            $Officeno = $_POST['CCRE_Officeno'];
            $DOB = $_POST['CCRE_DOB'];
            if ($DOB != '') {
                $DOB = date('Y-m-d', strtotime($_POST['CCRE_DOB']));
            }
            $Nationality = $_POST['CCRE_Nationality'];
            $PassportNo = $_POST['CCRE_PassportNo'];
            $PassportDate = $_POST['CCRE_PassportDate'];
            if ($PassportDate != '') {
                $PassportDate = date('Y-m-d', strtotime($_POST['CCRE_PassportDate']));
            }
            $EpNo = $_POST['CCRE_EpNo'];
            $EPDate = $_POST['CCRE_EPDate'];
            if ($EPDate != '') {
                $EPDate = date('Y-m-d', strtotime($_POST['CCRE_EPDate']));
            }
            $Uint = $_POST['CCRE_UnitNo'];
            $RoomType = $_POST['CCRE_RoomType'];
            $Startdate = $_POST['CCRE_Startdate'];
            $S_starttime = $_POST['CCRE_SDStarttime'];
            $S_endtime = $_POST['CCRE_SDEndtime'];
            $Enddate = $_POST['CCRE_Enddate'];
            $E_starttime = $_POST['CCRE_EDStarttime'];
            $E_endtime = $_POST['CCRE_EDEndtime'];
            $NoticePeriod = $_POST['CCRE_NoticePeriod'];
            $NoticePeriodDate = $_POST['CCRE_NoticePeriodDate'];
            if ($NoticePeriodDate != '') {
                $NoticePeriodDate = date('Y-m-d', strtotime($_POST['CCRE_NoticePeriodDate']));
            }
            $Quaterlyfee = $_POST['CCRE_Quarterly_fee'];
            if ($Quaterlyfee == '') {
                $InvQuaterlyfee = 'null';
            } else {
                $InvQuaterlyfee = $Quaterlyfee;
            }
            $Fixedaircon_fee = $_POST['CCRE_Fixedaircon_fee'];
            if ($Fixedaircon_fee == '') {
                $InvFixedaircon_fee = 'null';
            } else {
                $InvFixedaircon_fee = $Fixedaircon_fee;
            }
            $ElectricitycapFee = $_POST['CCRE_ElectricitycapFee'];
            if ($ElectricitycapFee == '') {
                $InvElectricitycapFee = 'null';
            } else {
                $InvElectricitycapFee = $ElectricitycapFee;
            }
            $Curtain_DrycleanFee = $_POST['CCRE_Curtain_DrycleanFee'];
            if ($Curtain_DrycleanFee == '') {
                $InvCurtain_DrycleanFee = 'null';
            } else {
                $InvCurtain_DrycleanFee = $Curtain_DrycleanFee;
            }
            $CheckOutCleanFee = $_POST['CCRE_CheckOutCleanFee'];
            if ($CheckOutCleanFee == '') {
                $InvCheckOutCleanFee = 'null';
            } else {
                $InvCheckOutCleanFee = $CheckOutCleanFee;
            }
            $DepositFee = $_POST['CCRE_DepositFee'];
            if ($DepositFee == '') {
                $InvDepositFee = 'null';
            } else {
                $InvDepositFee = $DepositFee;
            }
            $Rent = $_POST['CCRE_Rent'];
            $ProcessingFee = $_POST['CCRE_ProcessingFee'];
            if ($ProcessingFee == '') {
                $InvProcessingFee = 'null';
            } else {
                $InvProcessingFee = $ProcessingFee;
            }
            $Comments = $this->uat->escape_like_str($_POST['CCRE_Comments']);
            $CardArray = $_POST['temptex'];
            $Option = $_POST['AccessCard'];
            $waived = $_POST['CCRE_process_waived'];
            if ($waived == 'on') {
                $processwaived = 'X';
                $Invwaived = 'true';
            } else {
                $processwaived = '';
                $Invwaived = 'false';
            }
            $prorated = $_POST['CCRE_Rent_Prorated'];
            if ($prorated == 'on') {
                $Prorated = 'X';
                $InvProrated = 'true';
            } else {
                $Prorated = '';
                $InvProrated = 'false';
            }
            $Name = $FirstName . ' ' . $Lastname;
            $Emailid = $_POST['CCRE_Emailid'];
            $CCoption = $_POST['CCRE_Option'];
            $Sendmailid = $_POST['CCRE_MailList'];
            if ($Option == 'Cardnumber') {
                $cardlist = '';
                for ($i = 0; $i < count($CardArray); $i++) {
                    if ($CardArray[$i] != '') {
                        if ($cardlist == '') {
                            $cardlist = $CardArray[$i];
                        } else {
                            $cardlist = $cardlist . ',' . $CardArray[$i];
                        }
                    }
                }
                $cardnames = explode(',', $cardlist);
                $counting = count($cardnames);
                $cardno = '';
                $accesscard = '';

                for ($k = 0; $k < $counting; $k++) {
                    $cardnamessplit = explode('/', $cardnames[$k]);
                    if ($cardnamessplit[1] == $Name) {
                        $Cont_cardno = $cardnamessplit[0];
                        if ($accesscard == '') {
                            $accesscard = $cardnamessplit[0] . ', ';
                            $cardno = $cardnamessplit[0];

                        } else {
                            $accesscard = $accesscard . ',' . $cardnamessplit[0] . ', ';
                            $cardno = $cardno . ',' . $cardnamessplit[0];

                        }
                    } else {
                        if ($accesscard == '') {
                            $accesscard = $cardnamessplit[0] . ',X';
                            $cardno = $cardnamessplit[0];
                        } else {
                            $accesscard = $accesscard . ',' . $cardnamessplit[0] . ',X';
                            $cardno = $cardno . ',' . $cardnamessplit[0];
                        }
                    }
                }
            } else {
                $cardno = '';
                $accesscard = '';
            }
            $CCRE_quators = $Quoters;
            $StartDate = date('Y-m-d', strtotime($Startdate));
            $EndDate = date('Y-m-d', strtotime($Enddate));
            $this->uat->query('SET AUTOCOMMIT=0');
            $this->uat->query('START TRANSACTION');
            $CallQuery = "CALL SP_CUSTOMER_CREATION_INSERT(1,null,'$FirstName','$Lastname','$CompanyName','$CompanyAddress','$CompanyPostalCode','$Officeno',$Uint,'$RoomType','$S_starttime','$S_endtime','$E_starttime','$E_endtime','$Leaseperiod',$CCRE_quators,'$processwaived','$Prorated','$NoticePeriod','$NoticePeriodDate',$Rent,'$DepositFee','$ProcessingFee','$Fixedaircon_fee','$Quaterlyfee','$ElectricitycapFee','$CheckOutCleanFee','$Curtain_DrycleanFee','$cardno','$StartDate','$UserStamp','$StartDate','$EndDate','$accesscard','$Nationality','$Mobile','$IntlMobile','$Emailid','$PassportNo','$PassportDate','$DOB','$EpNo','$EPDate','$Comments',@CUSTOMER_CREATION_TEMPTBLNAME,@CUSTOMER_SUCCESSFLAG,@SAVE_POINT_NAME)";

            $this->uat->query($CallQuery);
            $outparm_query = $this->uat->query('SELECT @CUSTOMER_CREATION_TEMPTBLNAME AS TEMP_TABLE,@CUSTOMER_SUCCESSFLAG AS CONFIRM,@SAVE_POINT_NAME AS SAVEPOINT_NAME');
            foreach ($outparm_query->result_array() as $key=>$val)
            {
                $temptable=$val['TEMP_TABLE'];
                $Confirm_Meessage=$val['CONFIRM'];
                $savepoint=$val['SAVEPOINT_NAME'];
            }
            if ($Confirm_Meessage == 1)
            {
                $Customerid_query = 'SELECT CUSTOMER_ID FROM CUSTOMER ORDER BY CUSTOMER_ID DESC LIMIT 1';
                $Customer_result = $this->uat->query($Customerid_query);
                $Customerid = $Customer_result->row()->CUSTOMER_ID;
                $filetempname = $_FILES['CC_fileupload']['tmp_name'];
                $filename = $_FILES['CC_fileupload']['name'];
                $filename = $Uint . '-' . $Customerid . '-' . $FirstName . ' ' . $Lastname;
                $mimetype = 'application/pdf';
                $this->load->model('EILIB/Mdl_eilib_common_function');
                $service = $this->Mdl_eilib_common_function->get_service_document();
                $Fileupload = '';
                $UnitFolderrollback = '';
                $CustomerFolderback = '';
                if (($filetempname != '' && $Confirm_Meessage == 1) || ($CCoption != 3 && $Confirm_Meessage == 1))
                {
                    $Targetfolderid = $this->Mdl_eilib_common_function->CUST_TargetFolderId();
                    $UnitFolderid = $this->Mdl_eilib_common_function->getUnitfolderId($Uint, $Customerid);
                    $unitcount = count($UnitFolderid);
                    if ($unitcount == 0) {
                        $UnitFolder = $this->Mdl_eilib_common_function->Customer_FolderCreation($service, $Uint, 'PersonalDetails', $Targetfolderid);
                        $UnitFolderrollback = $UnitFolder;
                    } else {
                        $UnitFolder = $UnitFolderid[0];
                    }
                    if ($UnitFolder != '') {
                        $customerfoldername = $Customerid . '-' . $FirstName . ' ' . $Lastname;
                        $CustomerFolder = $this->Mdl_eilib_common_function->Customer_FolderCreation($service, $customerfoldername, 'PersonalDetails', $UnitFolder);
                        $CustomerFolderback = $CustomerFolder;
                    }
                    if ($filetempname != '')
                    {
                        $Fileupload = $this->Mdl_eilib_common_function->Customer_FileUpload($service, $filename, 'PersonalDetails', $CustomerFolder, $mimetype, $filetempname);
                    }
                    if ($CustomerFolder != '') {
                        $Fileidinsertquery = "CALL SP_INSERT_UPDATE_CUSTOMER_FILE_DIRECTORY($Uint,'$UnitFolder',$Customerid,'$CustomerFolder','$UserStamp',@SUCCESS_MESSAGE)";
                        $result = $this->uat->query($Fileidinsertquery);
                        $outparm_result = $this->uat->query("SELECT @SUCCESS_MESSAGE AS SUCCESS");
                        $Fileresponse = $outparm_result->row()->SUCCESS;
                    }
                }
                if ($Confirm_Meessage == 1 )
                {
                    $this->load->model('EILIB/Mdl_eilib_calender');
                    $cal = $this->Mdl_eilib_calender->createCalendarService();
                    $cal_startevents = $StartDate . ',' . $S_starttime . ',' . $S_endtime;
                    $cal_endevents = $EndDate . ',' . $E_starttime . ',' . $E_endtime;
                    $cal_arry = array();
                    array_push($cal_arry, $cal_startevents, $cal_endevents);
                    $calresponse = $this->Mdl_eilib_calender->CUST_customercalendercreation($Fileupload,$cal, $Customerid, $StartDate, $S_starttime, $S_endtime, $EndDate, $E_starttime, $E_endtime, $FirstName, $Lastname, $Mobile, $IntlMobile, $Officeno, $Emailid, $Uint, $RoomType, '');
                    if (($CCoption == 4 || $CCoption == 5 || $CCoption == 6) && $calresponse == 1)
                    {
                        $Invoiceandcontractid = $this->Mdl_eilib_common_function->CUST_invoice_contractreplacetext();
                        $Docowner = $this->Mdl_eilib_common_function->CUST_documentowner($UserStamp);
                        $Emailtemplate = $this->Mdl_eilib_common_function->CUST_emailsubandmessages();
                        $mail_username = explode('@', $Sendmailid);
                        $Username = strtoupper($mail_username[0]);
                        $this->load->model('EILIB/Mdl_eilib_invoice_contract');
                        if ($CCoption == 4) {
                            $InvoiceId = $this->Mdl_eilib_invoice_contract->CUST_invoice($UserStamp, $service, $Uint, $Name, $CompanyName, $Invoiceandcontractid[9], $Invoiceandcontractid[0], $Invoiceandcontractid[1], $Rent, $ProcessingFee, $DepositFee, $StartDate, $EndDate, $RoomType, $Leaseperiod, $Prorated, $Sendmailid, $Docowner, 'CREATION', $processwaived, $Customerid, $CustomerFolder);
                            if ($InvoiceId[0] == 1) {
                                $this->InvoiceCreation($InvoiceId, $Emailtemplate, $Username, $Confirm_Meessage, $Uint, $Name, $Sendmailid, $UserStamp);
                                $this->uat->trans_savepoint_release($savepoint) ;
                                echo $InvoiceId[0];
                                exit;
                            } else {
                                $this->uat->trans_savepoint_rollback($savepoint);
                                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                                $returnmessage = $this->Mdl_eilib_calender->CUST_CREATION_customercalenderdeletion($cal, $Customerid, $cal_arry);
                                if ($UnitFolderrollback != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolderrollback);
                                }
                                if ($CustomerFolderback != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolderback);
                                }
                                echo $InvoiceId[4];
                                exit;
                            }
                        } else if ($CCoption == 5) {
                            $ContractId = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $Uint, $Startdate, $Enddate, $CompanyName, $Name, $NoticePeriod, $PassportNo, $PassportDate, $EpNo, $EPDate, $NoticePeriodDate, $Leaseperiod, $Cont_cardno, $Rent, $InvQuaterlyfee, $InvFixedaircon_fee, $InvElectricitycapFee, $InvCurtain_DrycleanFee, $InvCheckOutCleanFee, $InvProcessingFee, $InvDepositFee, $Invwaived, $RoomType, $InvProrated, 'CREATION', $Sendmailid, $Docowner, $CustomerFolder);
                            if ($ContractId[0] == 1) {
                                $this->ContractCreation($ContractId, $Emailtemplate, $Username, $Confirm_Meessage, $Uint, $Name, $Sendmailid, $UserStamp);
                                $this->uat->trans_savepoint_release($savepoint) ;
                                echo $Confirm_Meessage;
                                exit;
                            } else {
                                $this->uat->trans_savepoint_rollback($savepoint);
                                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                                $returnmessage = $this->Mdl_eilib_calender->CUST_CREATION_customercalenderdeletion($cal, $Customerid, $cal_arry);
                                if ($UnitFolderrollback != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolderrollback);
                                }
                                if ($CustomerFolderback != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolderback);
                                }
                                echo $ContractId[3];
                                exit;
                            }

                        } else if ($CCoption == 6) {
                            print_r($service);
                            $InvoiceId = $this->Mdl_eilib_invoice_contract->CUST_invoice($UserStamp, $service, $Uint, $Name, $CompanyName, $Invoiceandcontractid[9], $Invoiceandcontractid[0], $Invoiceandcontractid[1], $Rent, $ProcessingFee, $DepositFee, $StartDate, $EndDate, $RoomType, $Leaseperiod, $Prorated, $Sendmailid, $Docowner, 'CREATION', $processwaived, $Customerid, $CustomerFolder);
                            $ContractId = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $Uint, $Startdate, $Enddate, $CompanyName, $Name, $NoticePeriod, $PassportNo, $PassportDate, $EpNo, $EPDate, $NoticePeriodDate, $Leaseperiod, $Cont_cardno, $Rent, $InvQuaterlyfee, $InvFixedaircon_fee, $InvElectricitycapFee, $InvCurtain_DrycleanFee, $InvCheckOutCleanFee, $InvProcessingFee, $InvDepositFee, $Invwaived, $RoomType, $InvProrated, 'CREATION', $Sendmailid, $Docowner, $CustomerFolder);
                            if ($InvoiceId[0] == 1 && $ContractId[0] == 1) {
                                $this->uat->trans_savepoint_release($savepoint) ;
                                $this->InvoiceandContract($InvoiceId, $ContractId, $Emailtemplate, $Username, $Confirm_Meessage, $Uint, $Name, $Sendmailid, $UserStamp);
                                echo $Confirm_Meessage;
                                exit;
                            } else {
//                                 echo $savepoint;
                                $this->uat->trans_savepoint_rollback($savepoint);
                                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                                $returnmessage = $this->Mdl_eilib_calender->CUST_CREATION_customercalenderdeletion($cal, $Customerid, $cal_arry);
                                if ($UnitFolderrollback != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolderrollback);
                                }
                                if ($CustomerFolderback != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolderback);
                                }
                                echo 0;
                                exit;
                            }
                        }
                    }
                    else
                    {
                        if ($calresponse == 1) {
                            $this->uat->trans_savepoint_release($savepoint) ;
                            echo $Confirm_Meessage;
                            exit;
                        }
                        else
                        {
                            $this->uat->trans_savepoint_rollback($savepoint);
                            $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                            $returnmessage = $this->Mdl_eilib_calender->CUST_CREATION_customercalenderdeletion($cal, $Customerid, $cal_arry);
                            echo $Confirm_Meessage;
                            exit;
                        }
                    }
                }
                else
                {
                    $this->uat->trans_savepoint_rollback($savepoint);
                    $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                    echo $Confirm_Meessage;
                    exit;
                }
            }
            else
            {   $this->uat->trans_savepoint_rollback($savepoint);
                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                echo 0;
                exit;
            }
        }

        catch (Exception $e)
        {
            $this->uat->trans_rollback();
            $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
            $returnmessage = $this->Mdl_eilib_calender->CUST_CREATION_customercalenderdeletion($cal, $Customerid, $cal_arry);
            if ($UnitFolderrollback != '') {
                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $UnitFolderrollback);
            }
            if ($CustomerFolderback != '') {
                $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $CustomerFolderback);
            }
            echo $e->getMessage();
            exit;
        }
    }
//    public function Customercreationmailpart($Confirm_Meessage,$Emailsub,$Messagebody,$Displayname,$Sendmailid,$UserStamp)
//    {
//        $mail = new PHPMailer;
//        $mail->isSMTP();
//        $mail->Host = 'smtp.gmail.com';
//        $mail->SMTPAuth = true;
//        $mail->Username = 'safiyullah84@gmail.com';
//        $mail->Password = 'safi984151';
//        $mail->SMTPSecure = 'tls';
//        $mail->Port = 587;
//        $mail->FromName = $Displayname;
//        $mail->addAddress("saradambal.munusamy@ssomens.com");
//        $mail->WordWrap = 50;
//        $mail->isHTML(true);
//        $mail->Subject = $Emailsub;
//        $mail->Body = $Messagebody;
//        $mail->Send();
//    }
//
    public function Customercreationmailpart($Confirm_Meessage,$Emailsub,$Messagebody,$Displayname,$Sendmailid,$UserStamp)
    {
        $message1 = new Message();
        $message1->setSender($Displayname.'<'.$UserStamp.'>');
        $message1->addTo($Sendmailid);
        $message1->setSubject($Emailsub);
        $message1->setHtmlBody($Messagebody);
        $message1->send();
//        $this->db->trans_commit();
        return $Confirm_Meessage;
    }
    public function InvoiceCreation($InvoiceId,$Emailtemplate,$Username,$Confirm_Meessage,$Uint,$Name,$Docowner,$UserStamp)
    {
        $subcontent = $Uint . '-' . $Name . '-' . $InvoiceId[3];
        $Messcontent = $Uint . '-' . $Name;
        $Emailsub = $Emailtemplate[2]['subject'];
        $Messagebody = $Emailtemplate[2]['message'];
        $Emailsub = str_replace('[UNIT NO- CUSTOMER_NAME - INVOICE_NO]', $subcontent, $Emailsub);
        $Messagebody = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Messagebody);
        $Messagebody = str_replace('[MAILID_USERNAME]', $Username, $Messagebody);
        $Messagebody = $Messagebody . '<br><br>INVOICE :' . $InvoiceId[2];
        $Displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('INVOICE');
        $this->Customercreationmailpart($Confirm_Meessage,$Emailsub,$Messagebody,$Displayname,$Docowner,$UserStamp);
    }
    public function ContractCreation($ContractId,$Emailtemplate,$Username,$Confirm_Meessage,$Uint,$Name,$Docowner,$UserStamp)
    {
        $Messcontent = $Uint . '-' . $Name;
        $Emailsub = $Emailtemplate[1]['subject'];
        $Messagebody = $Emailtemplate[1]['message'];
        $Emailsub = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Emailsub);
        $Messagebody = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Messagebody);
        $Messagebody = str_replace('[MAILID_USERNAME]', $Username, $Messagebody);
        $Messagebody = $Messagebody . '<br><br>CONTRACT :' . $ContractId[2];
        $Displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('CONTRACT');
        $this->Customercreationmailpart($Confirm_Meessage,$Emailsub,$Messagebody,$Displayname,$Docowner,$UserStamp);
    }
    public function InvoiceandContract($InvoiceId,$ContractId,$Emailtemplate,$Username,$Confirm_Meessage,$Uint,$Name,$Docowner,$UserStamp)
    {
        $subcontent = $Uint . '-' . $Name . '-' . $InvoiceId[3];
        $Messcontent = $Uint . '-' . $Name;
        $Emailsub = $Emailtemplate[0]['subject'];
        $Messagebody = $Emailtemplate[0]['message'];
        $Emailsub = str_replace('[UNIT NO - CUSTOMER NAME - INVOICE NO]', $subcontent, $Emailsub);
        $Messagebody = str_replace('[UNIT NO - CUSTOMER_NAME]', $Messcontent, $Messagebody);
        $Messagebody = str_replace('[MAILID_USERNAME]', $Username, $Messagebody);
        $Messagebody = $Messagebody . '<br><br>INVOICE :' . $InvoiceId[2];
        $Messagebody = $Messagebody . '<br><br>CONTRACT :' . $ContractId[2];
        $Displayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('INVOICE_N_CONTRACT');
        $this->Customercreationmailpart($Confirm_Meessage,$Emailsub,$Messagebody,$Displayname,$Docowner,$UserStamp);
    }
    public function getRecheckinCustomer($unit)
    {
        $this->uat->select("CUSTOMER_ID,CUSTOMERNAME,CED_REC_VER");
        $this->uat->order_by("CUSTOMERNAME", "ASC");
        $this->uat->from('VW_RECHECKIN_CUSTOMER');
        $this->uat->where("UNIT_NO=".$unit);
        $this->uat->distinct();
        $query = $this->uat->get();
        return $query->result();
    }
    public function getRecheckinCustomer_PersonalDetails($customerid,$Recver)
    {
        $CRCHK_detailsquery='SELECT C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CCD.CCD_COMPANY_NAME,CCD.CCD_COMPANY_ADDR,CCD.CCD_POSTAL_CODE,CCD.CCD_OFFICE_NO,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CPD.CPD_PASSPORT_NO,DATE_FORMAT(CPD.CPD_PASSPORT_DATE,"%d-%m-%Y") AS CPD_PASSPORT_DATE,DATE_FORMAT(CPD.CPD_DOB,"%d-%m-%Y") AS CPD_DOB,CPD.CPD_EMAIL,NC.NC_DATA,C.CUSTOMER_ID,CPD.CPD_COMMENTS,CPD.CPD_EP_NO,DATE_FORMAT(CPD.CPD_EP_DATE,"%d-%m-%Y") AS CPD_EP_DATE from CUSTOMER_ENTRY_DETAILS CED left join CUSTOMER_COMPANY_DETAILS CCD on CED.CUSTOMER_ID=CCD.CUSTOMER_ID left join CUSTOMER C on CED.CUSTOMER_ID=C.CUSTOMER_ID left join CUSTOMER_PERSONAL_DETAILS CPD on CED.CUSTOMER_ID=CPD.CUSTOMER_ID ,NATIONALITY_CONFIGURATION NC where (C.CUSTOMER_ID='.$customerid.') AND (CPD.NC_ID=NC.NC_ID) AND CED.CED_REC_VER='.$Recver;
        $resultset=$this->uat->query($CRCHK_detailsquery);
        return $resultset->result();
    }
    public function getRecheckin_Enddates($customerid,$Recver)
    {
        $CRCHK_Enddatequery='SELECT CLP_ENDDATE,CLP_PRETERMINATE_DATE FROM CUSTOMER_LP_DETAILS WHERE CUSTOMER_ID='.$customerid.' AND CED_REC_VER='.$Recver.' AND CLP_GUEST_CARD IS NULL';
        $resultset=$this->uat->query($CRCHK_Enddatequery);
        return $resultset->result();
    }
    public function Customer_Recheckin_Save($UserStamp,$Leaseperiod,$Quoters)
    {
        try {
            $Customerid = $_POST['CCRE_CustomerId'];
            $FirstName = $_POST['CCRE_FirstName'];
            $Lastname = $_POST['CCRE_LastName'];
            $CompanyName = $_POST['CCRE_CompanyName'];
            $CompanyAddress = $_POST['CCRE_CompanyAddress'];
            $CompanyPostalCode = $_POST['CCRE_CompanyPostalCode'];
            $Emailid = $_POST['CCRE_Emailid'];
            $Mobile = $_POST['CCRE_Mobile'];
            $IntlMobile = $_POST['CCRE_IntlMobile'];
            $Officeno = $_POST['CCRE_Officeno'];
            $DOB = $_POST['CCRE_DOB'];
            if($DOB!='') {
                $DOB = date('Y-m-d', strtotime($_POST['CCRE_DOB']));
            }
            $Nationality = $_POST['CCRE_Nationality'];
            $PassportNo = $_POST['CCRE_PassportNo'];
            $PassportDate = $_POST['CCRE_PassportDate'];
            if($PassportDate!='') {
                $PassportDate = date('Y-m-d', strtotime($_POST['CCRE_PassportDate']));
            }
            $EpNo = $_POST['CCRE_EpNo'];
            $EPDate = $_POST['CCRE_EPDate'];
            if($EPDate!='') {
                $EPDate = date('Y-m-d', strtotime($_POST['CCRE_EPDate']));
            }
            $Uint = $_POST['CCRE_UnitNo'];
            $RoomType = $_POST['CCRE_RoomType'];
            $Startdate = $_POST['CCRE_Startdate'];
            $S_starttime = $_POST['CCRE_SDStarttime'];
            $S_endtime = $_POST['CCRE_SDEndtime'];
            $Enddate = $_POST['CCRE_Enddate'];
            $E_starttime = $_POST['CCRE_EDStarttime'];
            $E_endtime = $_POST['CCRE_EDEndtime'];
            $NoticePeriod = $_POST['CCRE_NoticePeriod'];
            $NoticePeriodDate = $_POST['CCRE_NoticePeriodDate'];
            if($NoticePeriodDate!='') {
                $NoticePeriodDate = date('Y-m-d', strtotime($_POST['CCRE_NoticePeriodDate']));
            }
            $Quaterlyfee = $_POST['CCRE_Quarterly_fee'];if($Quaterlyfee==''){$InvQuaterlyfee='null';}else{$InvQuaterlyfee=$Quaterlyfee;}
            $Fixedaircon_fee = $_POST['CCRE_Fixedaircon_fee'];if($Fixedaircon_fee==''){$InvFixedaircon_fee='null';}else{$InvFixedaircon_fee=$Fixedaircon_fee;}
            $ElectricitycapFee = $_POST['CCRE_ElectricitycapFee'];if($ElectricitycapFee==''){$InvElectricitycapFee='null';}else{$InvElectricitycapFee=$ElectricitycapFee;}
            $Curtain_DrycleanFee = $_POST['CCRE_Curtain_DrycleanFee'];if($Curtain_DrycleanFee==''){$InvCurtain_DrycleanFee='null';}else{$InvCurtain_DrycleanFee=$Curtain_DrycleanFee;}
            $CheckOutCleanFee = $_POST['CCRE_CheckOutCleanFee'];if($CheckOutCleanFee==''){$InvCheckOutCleanFee='null';}else{$InvCheckOutCleanFee=$CheckOutCleanFee;}
            $DepositFee = $_POST['CCRE_DepositFee'];if($DepositFee==''){$InvDepositFee='null';}else{$InvDepositFee=$DepositFee;}
            $Rent = $_POST['CCRE_Rent'];
            $ProcessingFee = $_POST['CCRE_ProcessingFee'];if($ProcessingFee==''){$InvProcessingFee='null';}else{$InvProcessingFee=$ProcessingFee;}

            $Comments = $this->uat->escape_like_str($_POST['CCRE_Comments']);
            $CardArray = $_POST['temptex'];
            $Option = $_POST['AccessCard'];
            $waived = $_POST['CCRE_process_waived'];
            if ($waived == 'on') {
                $processwaived = 'X';
                $Invwaived='true';
            } else {
                $processwaived = '';
                $Invwaived='false';
            }
            $prorated = $_POST['CCRE_Rent_Prorated'];
            if ($prorated == 'on') {
                $Prorated = 'X';
                $InvProrated='true';
            } else {
                $Prorated = '';
                $InvProrated='false';
            }
            $Name = $FirstName . ' ' . $Lastname;
            if ($Option == 'Cardnumber') {
                $cardlist = '';
                for ($i = 0; $i < count($CardArray); $i++) {
                    if ($CardArray[$i] != '') {
                        if ($cardlist == '') {
                            $cardlist = $CardArray[$i];
                        } else {
                            $cardlist = $cardlist . ',' . $CardArray[$i];
                        }
                    }
                }
                $cardnames = explode(',', $cardlist);
                $counting = count($cardnames);
                $cardno = '';
                $accesscard = '';
                for ($k = 0; $k < $counting; $k++) {
                    $cardnamessplit = explode('/', $cardnames[$k]);
                    if ($cardnamessplit[1] == $Name) {
                        $Cont_cardno=$cardnamessplit[0];
                        if ($accesscard == '') {
                            $accesscard = $cardnamessplit[0] . ', ';
                            $cardno = $cardnamessplit[0];

                        } else {
                            $accesscard = $accesscard . ',' . $cardnamessplit[0] . ', ';
                            $cardno = $cardno . ',' . $cardnamessplit[0];
                        }
                    } else {
                        if ($accesscard == '') {
                            $accesscard = $cardnamessplit[0] . ',X';
                            $cardno = $cardnamessplit[0];
                        } else {
                            $accesscard = $accesscard . ',' . $cardnamessplit[0] . ',X';
                            $cardno = $cardno . ',' . $cardnamessplit[0];
                        }
                    }
                }
            } else {
                $cardno = '';
                $accesscard = '';
            }
            $CCRE_quators = $Quoters;
            $StartDate = date('Y-m-d', strtotime($Startdate));
            $EndDate = date('Y-m-d', strtotime($Enddate));
            $Emailid = $_POST['CCRE_Emailid'];
            $CCoption = $_POST['CCRE_Option'];
            $Sendmailid = $_POST['CCRE_MailList'];
            $this->uat->query('SET AUTOCOMMIT=0');
            $this->uat->query('START TRANSACTION');
            $CallQuery = "CALL SP_CUSTOMER_CREATION_INSERT(2,'$Customerid','$FirstName','$Lastname','$CompanyName','$CompanyAddress','$CompanyPostalCode','$Officeno',$Uint,'$RoomType','$S_starttime','$S_endtime','$E_starttime','$E_endtime','$Leaseperiod',$CCRE_quators,'$processwaived','$Prorated','$NoticePeriod','$NoticePeriodDate',$Rent,'$DepositFee','$ProcessingFee','$Fixedaircon_fee','$Quaterlyfee','$ElectricitycapFee','$CheckOutCleanFee','$Curtain_DrycleanFee','$cardno','$StartDate','$UserStamp','$StartDate','$EndDate','$accesscard','$Nationality','$Mobile','$IntlMobile','$Emailid','$PassportNo','$PassportDate','$DOB','$EpNo','$EPDate','$Comments',@CUSTOMER_CREATION_TEMPTBLNAME,@CUSTOMER_SUCCESSFLAG,SAVE_POINT_NAME)";
            $this->uat->query($CallQuery);
            $outparm_query = $this->uat->query('SELECT @CUSTOMER_CREATION_TEMPTBLNAME AS TEMP_TABLE,@CUSTOMER_SUCCESSFLAG AS CONFIRM,@SAVE_POINT_NAME AS SAVEPOINT_NAME');
            foreach ($outparm_query->result_array() as $key=>$val)
            {
                $temptable=$val['TEMP_TABLE'];
                $Confirm_Meessage=$val['CONFIRM'];
                $savepoint=$val['SAVEPOINT_NAME'];
            }
            if ($Confirm_Meessage == 1) {
                return 'tet';
                //FILE UPLOAD
                $filetempname = $_FILES['CC_fileupload']['tmp_name'];
                $filename = $_FILES['CC_fileupload']['name'];
                $filename = $Uint . '-' . $Customerid . '-' . $FirstName . ' ' . $Lastname;
                $mimetype = 'application/pdf';
                $this->load->model('EILIB/Mdl_eilib_common_function');
                $service = $this->Mdl_eilib_common_function->get_service_document();
                $Fileupload = '';
                $unitfileid = '';
                $customerfileid = '';
                if (($filetempname != '' && $Confirm_Meessage == 1) || ($CCoption != 3 && $Confirm_Meessage == 1)) {
                    $Targetfolderid = $this->Mdl_eilib_common_function->CUST_TargetFolderId();
                    $UnitFolderid = $this->Mdl_eilib_common_function->getUnitfolderId($Uint, $Customerid);
                    $unitcount = count($UnitFolderid);
                    if ($unitcount == 0) {
                        $UnitFolder = $this->Mdl_eilib_common_function->Customer_FolderCreation($service, $Uint, 'PersonalDetails', $Targetfolderid);
                        $unitfileid = $UnitFolder;
                    } else {
                        $UnitFolder = $UnitFolderid[0];
                    }
                    if ($UnitFolder != '') {
                        $customerfoldername = $Customerid . '-' . $FirstName . ' ' . $Lastname;
                        $CustomerFolder = $this->Mdl_eilib_common_function->Customer_FolderCreation($service, $customerfoldername, 'PersonalDetails', $UnitFolder);
                        $customerfileid = $CustomerFolder;
                    } else {
                        $CustomerFolder = $UnitFolderid[0];
                    }
                    if ($filetempname != '') {
                        $Fileupload = $this->Mdl_eilib_common_function->Customer_FileUpload($service, $filename, 'PersonalDetails', $CustomerFolder, $mimetype, $filetempname);
                    }
                    if ($customerfileid != '') {
                        $Fileidinsertquery = "CALL SP_INSERT_UPDATE_CUSTOMER_FILE_DIRECTORY($Uint,'$UnitFolder',$Customerid,'$CustomerFolder','$UserStamp',@SUCCESS_MESSAGE)";
                        $result = $this->uat->query($Fileidinsertquery);
                    }
                }return $Confirm_Meessage.'test';
                if ($Confirm_Meessage == 1)
                {
                    $this->load->model('EILIB/Mdl_eilib_calender');
                    $cal = $this->Mdl_eilib_calender->createCalendarService();return 'test';
                    $cal_startevents = $StartDate . ',' . $S_starttime . ',' . $S_endtime;
                    $cal_endevents = $EndDate . ',' . $E_starttime . ',' . $E_endtime;
                    $cal_arry = array();
                    array_push($cal_arry, $cal_startevents, $cal_endevents);
                    $calresponse = $this->Mdl_eilib_calender->CUST_customercalendercreation($Fileupload,$cal, $Customerid, $StartDate, $S_starttime, $S_endtime, $EndDate, $E_starttime, $E_endtime, $FirstName, $Lastname, $Mobile, $IntlMobile, $Officeno, $Emailid, $Uint, $RoomType, '');
                    if (($CCoption == 4 || $CCoption == 5 || $CCoption == 6) && $calresponse == 1) {
                        $Invoiceandcontractid = $this->Mdl_eilib_common_function->CUST_invoice_contractreplacetext();
                        $Docowner = $this->Mdl_eilib_common_function->CUST_documentowner($UserStamp);
                        $Emailtemplate = $this->Mdl_eilib_common_function->CUST_emailsubandmessages();
                        $mail_username = explode('@', $Sendmailid);
                        $Username = strtoupper($mail_username[0]);
                        $this->load->model('EILIB/Mdl_eilib_invoice_contract');
                        if ($CCoption == 4) {
                            $InvoiceId = $this->Mdl_eilib_invoice_contract->CUST_invoice($UserStamp, $service, $Uint, $Name, $CompanyName, $Invoiceandcontractid[9], $Invoiceandcontractid[0], $Invoiceandcontractid[1], $Rent, $ProcessingFee, $DepositFee, $StartDate, $EndDate, $RoomType, $Leaseperiod, $Prorated, $Sendmailid, $Docowner, 'CREATION', $processwaived, $Customerid, $CustomerFolder);
                            if ($InvoiceId[0] == 1) {
                                $this->uat->trans_savepoint_release($savepoint) ;
                                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                                $this->InvoiceCreation($InvoiceId, $Emailtemplate, $Username, $Confirm_Meessage, $Uint, $Name, $Sendmailid, $UserStamp);
                                echo $InvoiceId[0];
                                exit;
                            } else {
                                $this->uat->trans_savepoint_rollback($savepoint);
                                $returnmessage = $this->Mdl_eilib_calender->CUST_CREATION_customercalenderdeletion($cal, $Customerid, $cal_arry);
                                if ($Fileupload != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $Fileupload);
                                }
                                if ($unitfileid != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $unitfileid);
                                }
                                if ($customerfileid != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $customerfileid);
                                }
                                if ($InvoiceId[1] != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $InvoiceId[1]);
                                }
                                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                                echo $Confirm_Meessage;
                                exit;
                            }
                        } else if ($CCoption == 5) {
                            $ContractId = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $Uint, $Startdate, $Enddate, $CompanyName, $Name, $NoticePeriod, $PassportNo, $PassportDate, $EpNo, $EPDate, $NoticePeriodDate, $Leaseperiod, $Cont_cardno, $Rent, $InvQuaterlyfee, $InvFixedaircon_fee, $InvElectricitycapFee, $InvCurtain_DrycleanFee, $InvCheckOutCleanFee, $InvProcessingFee, $InvDepositFee, $Invwaived, $RoomType, $InvProrated, 'CREATION', $Sendmailid, $Docowner, $CustomerFolder);
                            if ($ContractId[0] == 1) {
                                $this->uat->trans_savepoint_release($savepoint) ;
                                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                                $this->ContractCreation($ContractId, $Emailtemplate, $Username, $Confirm_Meessage, $Uint, $Name, $Sendmailid, $UserStamp);
                                echo $ContractId[0];
                                exit;
                            } else {
                                $this->uat->trans_savepoint_rollback($savepoint);
                                $returnmessage = $this->Mdl_eilib_calender->CUST_CREATION_customercalenderdeletion($cal, $Customerid, $cal_arry);
                                if ($Fileupload != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $Fileupload);
                                }
                                if ($unitfileid != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $unitfileid);
                                }
                                if ($customerfileid != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $customerfileid);
                                }
                                if ($ContractId[1] != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $ContractId[1]);
                                }
                                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                                echo $Confirm_Meessage;
                                exit;
                            }
                        } else if ($CCoption == 6) {
                            $InvoiceId = $this->Mdl_eilib_invoice_contract->CUST_invoice($UserStamp, $service, $Uint, $Name, $CompanyName, $Invoiceandcontractid[9], $Invoiceandcontractid[0], $Invoiceandcontractid[1], $Rent, $ProcessingFee, $DepositFee, $StartDate, $EndDate, $RoomType, $Leaseperiod, $Prorated, $Sendmailid, $Docowner, 'CREATION', $processwaived, $Customerid, $CustomerFolder);
                            $ContractId = $this->Mdl_eilib_invoice_contract->CUST_contract($service, $Uint, $Startdate, $Enddate, $CompanyName, $Name, $NoticePeriod, $PassportNo, $PassportDate, $EpNo, $EPDate, $NoticePeriodDate, $Leaseperiod, $Cont_cardno, $Rent, $InvQuaterlyfee, $InvFixedaircon_fee, $InvElectricitycapFee, $InvCurtain_DrycleanFee, $InvCheckOutCleanFee, $InvProcessingFee, $InvDepositFee, $Invwaived, $RoomType, $InvProrated, 'CREATION', $Sendmailid, $Docowner, $CustomerFolder);
                            if ($InvoiceId[0] == 1 && $ContractId[0] == 1) {
                                $this->uat->trans_savepoint_release($savepoint) ;
                                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                                $this->InvoiceandContract($InvoiceId, $ContractId, $Emailtemplate, $Username, $Confirm_Meessage, $Uint, $Name, $Sendmailid, $UserStamp);
                                echo $Confirm_Meessage;
                                exit;
                            } else {
                                $this->uat->trans_savepoint_rollback($savepoint);
                                $returnmessage = $this->Mdl_eilib_calender->CUST_CREATION_customercalenderdeletion($cal, $Customerid, $cal_arry);
                                if ($Fileupload != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $Fileupload);
                                }
                                if ($unitfileid != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $unitfileid);
                                }
                                if ($customerfileid != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $customerfileid);
                                }
                                if ($ContractId[1] != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $ContractId[1]);
                                }
                                if ($InvoiceId[1] != '') {
                                    $this->Mdl_eilib_invoice_contract->CUST_UNSHARE_FILE($service, $InvoiceId[1]);
                                }
                                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                                echo $Confirm_Meessage;
                                exit;
                            }
                        }
                    } else {
                        if ($calresponse == 1) {
                            $this->uat->trans_savepoint_release($savepoint) ;
                            $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                            echo $Confirm_Meessage;
                            exit;
                        } else {
                            $this->uat->trans_savepoint_rollback($savepoint);
                            $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                            echo $Confirm_Meessage;
                            exit;
                        }
                    }
                }
                else
                {
                    $this->uat->trans_savepoint_rollback($savepoint);
                    $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                    echo $Confirm_Meessage;
                    exit;
                }
            }
            else
            {
                $this->uat->trans_savepoint_rollback($savepoint);
                $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
                echo $Confirm_Meessage;
                exit;
            }
        }
        catch (Exception $e)
        {
            $this->uat->query('DROP TABLE IF EXISTS ' . $temptable);
            $this->uat->trans_savepoint_rollback($savepoint);
            echo $e->getMessage();
            exit;
        }
    }
}