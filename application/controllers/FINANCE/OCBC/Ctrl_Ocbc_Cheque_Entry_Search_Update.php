<?php
error_reporting(0);
Class Ctrl_Ocbc_Cheque_Entry_Search_Update extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_cheque_entry_search_update');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function Index()
    {
        $this->load->view('FINANCE/OCBC/Vw_Ocbc_Cheque_Entry_Search_Update');
    }
    public function Cheque_Entry_InitialDataLoad()
    {
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    public function Cheque_Entry_Save()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $ConfirmMessage= $this->Mdl_ocbc_cheque_entry_search_update->Cheque_Entry_FormData_Save($UserStamp);
        echo json_encode($ConfirmMessage);
    }
    public  function Cheque_Search_InitialDataLoad()
    {
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Searchoption= $this->Mdl_ocbc_cheque_entry_search_update->getSearchOption();
        $Chequestatus=$this->Mdl_ocbc_cheque_entry_search_update->getChequeStatus();
        $returnvalues=array($ErrorMessage,$Searchoption,$Chequestatus);
        echo json_encode($returnvalues);
    }
    public function Cheque_SearchOption()
    {
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $Option=$_POST['Option'];
        $Data1=$_POST['Data1'];
        $Data2=$_POST['Data2'];
        $Allrecords=$this->Mdl_ocbc_cheque_entry_search_update->getAllDatas($Option,$Data1,$Data2,$timeZoneFormat);
        echo json_encode($Allrecords);
    }
    public function ChequeNo()
    {
        $AllChequeno=$this->Mdl_ocbc_cheque_entry_search_update->getChequeNo();
        echo json_encode($AllChequeno);
    }
    public function ChequeUnit()
    {
        $AllChequeunit=$this->Mdl_ocbc_cheque_entry_search_update->getChequeUnit();
        echo json_encode($AllChequeunit);
    }
    public function Cheque_Updation_Details()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $chequedate=$_POST['cheque_date'];
        $chequeno=$_POST['cheque_no'];
        $chequeto=$_POST['cheque_to'];
        $chequefor=$_POST['check_for'];
        $checkamount=$_POST['check_amount'];
        $checkunit=$_POST['unit'];
        $checkstatus=$_POST['status'];
        $checquedebiteddate=$_POST['debiteddate'];
        $comments=$_POST['comments'];
        $Rowid=$_POST['ID'];
        $confirmmessage=$this->Mdl_ocbc_cheque_entry_search_update->getUpdation_Details($Rowid,$chequedate,$chequeno,$chequeto,$chequefor,$checkamount,$checkunit,$checkstatus,$checquedebiteddate,$comments,$UserStamp,$timeZoneFormat);
        echo json_encode($confirmmessage);
    }
    public function ChequePdfCreation()
    {
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $Option=$_GET['Searchoption'];
        $Data1=$_GET['Frominput'];
        $Data2=$_GET['Todate'];
        $header=$_GET['Header'];
        $Allrecords=$this->Mdl_ocbc_cheque_entry_search_update->ChequePDFCreation($Option,$Data1,$Data2,$timeZoneFormat);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$header.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($Allrecords);
        $pdf->Output('CHEQUE DETAILS.pdf', 'D');
    }
}