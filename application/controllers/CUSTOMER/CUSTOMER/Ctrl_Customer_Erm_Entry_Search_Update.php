<?php
error_reporting(0);
//require_once 'google/appengine/api/mail/Message.php';
//use google\appengine\api\mail\Message;
Class Ctrl_Customer_Erm_Entry_Search_Update extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_erm_entry_search_update');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function Index()
    {
        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Erm_Entry_Search_Update');
    }
    public function ERM_InitialDataLoad()
    {
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $nationality = $this->Mdl_eilib_common_function->getNationality();
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Occupation= $this->Mdl_eilib_common_function->getOccupationList();
        $values=array($nationality,$ErrorMessage,$Occupation);
        echo json_encode($values);
    }
    public function ERM_Entry_Save()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $displayname=$this->Mdl_eilib_common_function->Get_MailDisplayName('ERM');
        $Emailtemplate=$this->Mdl_eilib_common_function->getProfileEmailId('ERM');
        $splitMailid=explode('@',$Emailtemplate[0]);
        $username=strtoupper($splitMailid[0]);
        $Create_confirm=$this->Mdl_customer_erm_entry_search_update->ERM_EntrySave($UserStamp,$username,$displayname,$Emailtemplate);
//        $mydate=getdate(date("U"));
//        $month=strtoupper($mydate[month]);
//        $sysdate="$mydate[mday]-$month-$mydate[year]";
//        $emailsubject="NEW ERM LEED -[".$sysdate."]";
        echo json_encode($Create_confirm[1]);
    }
    public function ERM_SRC_InitialDataLoad()
    {
        $SearchOption=$this->Mdl_customer_erm_entry_search_update->getSearchOption();
        $nationality = $this->Mdl_eilib_common_function->getNationality();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Occupation= $this->Mdl_eilib_common_function->getOccupationList();
        $values=array($SearchOption,$nationality,$ErrorMessage,$Occupation);
        echo json_encode($values);
    }
    public function ERM_Entry_Update()
    {
        $Create_confirm=$this->Mdl_customer_erm_entry_search_update->ERM_EntrySave();
        echo json_encode($Create_confirm);
    }
    public function CustomerName()
    {
        $Customername=$this->Mdl_customer_erm_entry_search_update->getCustomernames();
        echo json_encode($Customername);
    }
    public function CustomerContact()
    {
        $Contactno=$this->Mdl_customer_erm_entry_search_update->getCustomerContact();
        echo json_encode($Contactno);
    }
    public function Userstamp()
    {
        $UserStamp=$this->Mdl_customer_erm_entry_search_update->getUserstamp();
        echo json_encode($UserStamp);
    }
    public function ERM_SearchOption()
    {
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $Option=$_POST['Option'];
        $Data1=$_POST['Data1'];
        $Data2=$_POST['Data2'];
        $UserStamp=$this->Mdl_customer_erm_entry_search_update->getAllDatas($Option,$Data1,$Data2,$timeZoneFormat);
        echo json_encode($UserStamp);
    }
    public function ERM_Deletion_Details()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $Rowid=$_POST['Rowid'];
        $Create_confirm=$this->Mdl_eilib_common_function->DeleteRecord(80,$Rowid,$UserStamp);
        print_r($Create_confirm);
    }
    public function ERM_Updation_Details()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $Rowid=$_POST['RowId'];
        $Name=$_POST['Name'];
        $Rent=$_POST['Rent'];
        $Movedate=$_POST['Movingdate'];
        $Min_stay=$this->db->escape_like_str($_POST['Minstay']);
        $Occupation=$_POST['Occupation'];
        $Nation=$_POST['Nation'];
        $Guests=$this->db->escape_like_str($_POST['Guests']);
        $age=$this->db->escape_like_str($_POST['Age']);
        $Contactno=$_POST['Contactno'];
        $Emailid=$_POST['Emailid'];
        $Comments=$this->db->escape_like_str($_POST['Comments']);
        $displayname=$this->Mdl_eilib_common_function->Get_MailDisplayName('ERM');
        $Emailtemplate=$this->Mdl_eilib_common_function->getProfileEmailId('ERM');
        $splitMailid=explode('@',$Emailtemplate[0]);
        $username=strtoupper($splitMailid[0]);
        $Create_confirm=$this->Mdl_customer_erm_entry_search_update->ERM_Update_Record($displayname,$Emailtemplate,$Rowid,$Name,$Rent,$Movedate,$Min_stay,$Occupation,$Nation,$Guests,$age,$Contactno,$Emailid,$Comments,$UserStamp,$timeZoneFormat,$username);
        $Returnvalues=array($Create_confirm[0],$Create_confirm[1],$Create_confirm[2]);
        $message=$Create_confirm[3];
        $mydate=getdate(date("U"));
        $month=strtoupper($mydate[month]);
        $sysdate="$mydate[mday]-$month-$mydate[year]";
        $emailsubject="NEW ERM LEED -[".$sysdate."]";
        echo json_encode($Returnvalues);
    }
    public function ERMPdfCreation()
    {
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $Option=$_GET['Searchoption'];
        $Data1=$_GET['Frominput'];
        $Data2=$_GET['Toinput'];
        $header=$_GET['Header'];
        $PDFDetails=$this->Mdl_customer_erm_entry_search_update->getpdfdetails($Option,$Data1,$Data2,$timeZoneFormat);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$header.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($PDFDetails);
        $pdf->Output('ERM LEEDS.pdf', 'D');
    }

}