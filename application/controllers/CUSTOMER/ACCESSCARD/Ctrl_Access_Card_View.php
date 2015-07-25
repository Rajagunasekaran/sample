<?php
//******************************************View All Card********************************************//
//VER 0.01-SD:09/05/2015 ED:12/05/2015,initial version BY RAJA
//*******************************************************************************************************//
class Ctrl_Access_Card_View extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/ACCESS CARD/Mdl_access_card_view');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('CUSTOMER/ACCESS CARD/Vw_Access_Card_View');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $query=$this->Mdl_access_card_view->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    public function Cardnodetails(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $unitno= $this->input->post('unitno');
        $cardno= $this->input->post('cardno');
        $option= $this->input->post('option');
        $cardquery=$this->Mdl_access_card_view->Cardno_details($unitno,$cardno,$option,$USERSTAMP);
        echo json_encode($cardquery);
    }
    public function Customerid(){
        $custname= $this->input->post('CV_name');
        $custquery=$this->Mdl_access_card_view->Customer_id($custname);
        echo json_encode($custquery);
    }
    public function Customervalues(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $custid= $this->input->post('CV_cid');
        $custdtlquery=$this->Mdl_access_card_view->Customer_values($custid,$USERSTAMP);
        echo json_encode($custdtlquery);
    }
    public function Pdfcreation(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->load->library('pdf');
        $pdfresult='';
        $custname= $this->input->get('custname');
        $custid= $this->input->get('custnameid');
        $unitno= $this->input->get('unitno');
        $cardno= $this->input->get('cardno');
        $option= $this->input->get('option');
        $pdfresult=$this->Mdl_access_card_view->Pdf_creation($custid,$unitno,$cardno,$option,$USERSTAMP);
        $pdfheader='';
        if($option==18){$pdfheader='ACCESS CARD DETAIL FOR CARD NO '.$cardno;}
        else if($option==21){$pdfheader='ACCESS CARD DETAIL FOR CUSTOMER '.$custname;}
        else if($option==31){$pdfheader='ACCESS CARD DETAILS FOR THE UNIT NUMBER '.$unitno;}
        else if($option==40){$pdfheader='ACCESS CARD DETAILS FOR ALL UNITS';}
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
    }
}