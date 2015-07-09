<?php
class Ctrl_Ocbc_Banktt_Search_Update extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_banktt_entry');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index()
    {
        $this->load->view('FINANCE/OCBC/Vw_Ocbc_Banktt_Search_Update');
    }
    public function Banktt_initialdatas()
    {
        $Searchoption=$this->Mdl_ocbc_banktt_entry->Banktt_Search_Option();
        $unit = $this->Mdl_ocbc_banktt_entry->Banktt_Unit();
        $modelnames=$this->Mdl_ocbc_banktt_entry->get_ModelNames();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $values=array($Searchoption,$ErrorMessage,$unit,$modelnames);
        echo json_encode($values);
    }
    public function Banktt_customer()
    {
        $unit=$_POST['Unit'];
        $customer=$this->Mdl_ocbc_banktt_entry->get_Banktt_Csutomer($unit);
        echo json_encode($customer);
    }
    public function Banktt_getAccname()
    {
        $accname=$this->Mdl_ocbc_banktt_entry->get_Accountnames();
        echo json_encode($accname);
    }
    //FETCH THE DATA FOR UPDATE FORM
    public function Banktt_Update_FetchData()
    {
        $primaryId=$_POST['id'];
        $SearchResultsUpdate=$this->Mdl_ocbc_banktt_entry->get_UpdateFormData($primaryId);
        echo json_encode($SearchResultsUpdate);
    }
    public function Banktt_Search_Details()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $option=$_POST['Option'];
        $unit=$_POST['Unit'];
        $customer=$_POST['Customer'];
        $SearchResults=$this->Mdl_ocbc_banktt_entry->get_SearchResults($option,$UserStamp,$timeZoneFormat,$unit,$customer);
        echo json_encode($SearchResults);
    }
    public function Banktt_Update_Save()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $Confirm_message=$this->Mdl_ocbc_banktt_entry->getBanktt_UpdateSave($UserStamp);
        echo json_encode($Confirm_message[0]);
    }
    public function BankttPdfCreation()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $option=$_GET['Searchoption'];
        $unit=$_GET['Frominput'];
        $customer=$_GET['Todate'];
        $header=$_GET['Header'];
        $SearchResults=$this->Mdl_ocbc_banktt_entry->Banktt_PDF_SearchResults($option,$UserStamp,$timeZoneFormat,$unit,$customer);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$header.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($SearchResults);
        $pdf->Output('BANK TT DETAILS.pdf', 'D');
    }
}