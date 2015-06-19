<?php
error_reporting(0);
Class Ctrl_Finance_Payment_Search_Update extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/FINANCE/Mdl_finance_payments_entry_active_customer');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function Index()
    {
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Payment_Search_Update');
    }
    public function InitialDataLoad()
    {
        $unit = $this->Mdl_eilib_common_function->getAllUnits();
        $paymenttype=$this->Mdl_eilib_common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $searchOption=$this->Mdl_finance_payments_entry_active_customer->getSearchOption();
        $ReturnValues=array($unit,$paymenttype,$ErrorMessage,$searchOption);
        echo json_encode($ReturnValues);
    }
    public function PaymentsearchData()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
         $SearchOption=$_POST['Option'];
         $unit=$_POST['Unit'];
         $Customer=$_POST['Customer'];
         $Fromdate=$_POST['FromDate'];
         $Todate=$_POST['Todate'];
         $fromamount=$_POST['Fromamount'];
         $toamount=$_POST['Toamount'];
         $searchResults=$this->Mdl_finance_payments_entry_active_customer->getSearchResults($SearchOption,$unit,$Customer,$Fromdate,$Todate,$fromamount,$toamount,$UserStamp,$timeZoneFormat);
         echo json_encode($searchResults);
    }
    public function UnitCustomer()
    {
        $unit=$_POST['Unit'];
        $searchResults=$this->Mdl_finance_payments_entry_active_customer->getUnitCustomer($unit);
        echo json_encode($searchResults);
    }
    public function PaymentsearchRowDetails()
    {
       $unit=$_POST['Unit'];
       $customerid=$_POST['Customerid'];
       $Rowid=$_POST['Rowid'];
       $Recver=$_POST['Recversion'];
       $searchResults=$this->Mdl_finance_payments_entry_active_customer->getPaymentRowDetails($Rowid);
       $LPsearchResults=$this->Mdl_finance_payments_entry_active_customer->getPaymentRowLPDetails($customerid,$unit);
       $Returnvalues=array($searchResults,$LPsearchResults,$Recver);
       echo json_encode($Returnvalues);
    }
    public function PaymentUpdationDetails()
    {
        $SearchOption=$_POST['Option'];
        $unit=$_POST['Unit'];
        $Customer=$_POST['Customer'];
        $Fromdate=$_POST['FromDate'];
        $Todate=$_POST['Todate'];
        $fromamount=$_POST['Fromamount'];
        $toamount=$_POST['Toamount'];
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $Create_confirm=$this->Mdl_finance_payments_entry_active_customer->Payment_Updation($UserStamp);
        $searchResults=$this->Mdl_finance_payments_entry_active_customer->getSearchResults($SearchOption,$unit,$Customer,$Fromdate,$Todate,$fromamount,$toamount,$UserStamp,$timeZoneFormat);
        $return_array=array($Create_confirm,$searchResults);
        echo json_encode($return_array);
    }
    public function PaymentsDetails()
    {
        $SearchOption=$_POST['Option'];
        $unit=$_POST['Unit'];
        $Customer=$_POST['Customer'];
        $Fromdate=$_POST['FromDate'];
        $Todate=$_POST['Todate'];
        $fromamount=$_POST['Fromamount'];
        $toamount=$_POST['Toamount'];
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $Rowid=$_POST['Rowid'];
        $Create_confirm=$this->Mdl_eilib_common_function->DeleteRecord(18,$Rowid,$UserStamp);
        $searchResults=$this->Mdl_finance_payments_entry_active_customer->getSearchResults($SearchOption,$unit,$Customer,$Fromdate,$Todate,$fromamount,$toamount,$UserStamp,$timeZoneFormat);
        $return_array=array($Create_confirm,$searchResults);
        echo json_encode($return_array);
    }
    public function PaymentsExtractDetails()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $unit=$_POST['Unit'];
        $Customer=$_POST['Customer'];
        $searchResults=$this->Mdl_finance_payments_entry_active_customer->payment_extract_details($unit,$Customer,$UserStamp,$timeZoneFormat);
        echo json_encode($searchResults);
    }
    public function PaymentPdfCreation()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $SearchOption=$_GET['SearchOption'];
        $header=$_GET['header'];
        $inputone=$_GET['inputone'];
        $inputwo=$_GET['inputtwo'];
        $inputthree=$_GET['inputthree'];
        $inputfour=$_GET['inputfour'];
        $inputfive=$_GET['inputfive'];
        $searchpdfResults=$this->Mdl_finance_payments_entry_active_customer->payment_pdf_details($SearchOption,$inputone,$inputwo,$inputthree,$inputfour,$inputfive,$UserStamp,$timeZoneFormat);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$header.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($searchpdfResults);
        $pdf->Output("PAYMENT DETAILS".'.pdf', 'D');
    }
}