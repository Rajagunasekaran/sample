<?php
Class Ctrl_Ocbc_Ocbc extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_ocbc');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function Index()
    {
        $this->load->view('FINANCE/OCBC/Vw_Ocbc_Ocbc');
    }
    public function Fin_OCBC_Submit()
    {
        $Period=$_POST['Period'];
        $this->load->library('Google');
        $unit = $this->Mdl_eilib_common_function->getAllActiveUnits();
        $paymenttype=$this->Mdl_eilib_common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $SubmittedData=$this->Mdl_ocbc_ocbc->getOCBCData($Period);
        $CSVCOUNT=$this->Mdl_ocbc_ocbc->CSV_FileRecordsCount($Period);
        $values=array($SubmittedData,$unit,$paymenttype,$ErrorMessage,$CSVCOUNT);
        echo json_encode($values);
    }
    public function ActiveCustomer()
    {
        $unit=$_POST['UNIT'];
        $Customer = $this->Mdl_eilib_common_function->getActive_Customer($unit);
        echo json_encode($Customer);
    }
    public function ActiveCustomerLeasePeriod()
    {
        $unit=$_POST['UNIT'];
        $customer=$_POST['CUSTOMERID'];
        $Customer = $this->Mdl_eilib_common_function->getActive_Customer_LP($unit,$customer);
        echo json_encode($Customer);
    }
    public function OCBC_Record_Save()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $unit=$_POST['UNIT'];
        $customerid=$_POST['CUSTOMERID'];
        $recver=$_POST['LP'];
        $payment=$_POST['PAYMENT'];
        $amount=$_POST['AMOUNT'];
        $period=$_POST['FORPERIOD'];
        $comments=$_POST['COMMENTS'];
        $comments=$this->db->escape_like_str($comments);
        $flag=$_POST['FLAG'];
        $id=$_POST['ID'];
        $Result = $this->Mdl_ocbc_ocbc->RecordSave($unit,$customerid,$recver,$payment,$amount,$period,$comments,$flag,$id,$UserStamp);
        echo json_encode($Result);
    }
    public function OCBCPdfCreation()
    {
        $Period=$_GET['Period'];
        $SubmittedData=$this->Mdl_ocbc_ocbc->OCBC_PDF_Creation($Period);
        $header='OCBC RECORDS-'.strtoupper($Period);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$header.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($SubmittedData);
        $pdf->Output($header.'.pdf', 'D');
    }
}