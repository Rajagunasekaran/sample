<?php
class Ctrl_Finance_Extract_Deposit_Pdf extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/FINANCE/Mdl_finance_extract_deposit_pdf');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Extract_Deposit_Pdf');
    }
    public function Call_service(){
        $this->load->library('Google');
        $service = $this->Mdl_eilib_common_function->get_service_document();
        return $service;
    }
    public function Initialdata(){
        $timeZoneFrmt= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $service=$this->Call_service();
        $query=$this->Mdl_finance_extract_deposit_pdf->Initial_data($service);
        echo json_encode($query);
    }
    public function DDE_getsheetunit(){
        $month=$this->input->post('month');
        $shturl=$this->input->post('shturl');
        $getunitquery=$this->Mdl_finance_extract_deposit_pdf->DDE_getsheet_unit($month,$shturl);
        echo json_encode($getunitquery);
    }
    public function DDE_customername(){
        $unitno=$this->input->post('unit');
        $month=$this->input->post('month');
        $shturl=$this->input->post('shturl');
        $getcustquery=$this->Mdl_finance_extract_deposit_pdf->DDE_customer_name($unitno,$month,$shturl);
        echo json_encode($getcustquery);
    }
    public function DDE_getcustid(){
        $unitno=$this->input->post('DDE_unit');
        $month=$this->input->post('DDE_month');
        $name=$this->input->post('name');
        $shturl=$this->input->post('shturl');
        $getcustidquery=$this->Mdl_finance_extract_deposit_pdf->DDE_get_custid($unitno,$month,$name,$shturl);
        echo json_encode($getcustidquery);
    }
    public function DDE_Dep_Exct_recversionfun(){
        $getid=$this->input->post('DDE_namesplit');
        $unitno=$this->input->post('DDE_unit');
        $month=$this->input->post('DDE_month');
        $name=$this->input->post('DDE_name');
        $shturl=$this->input->post('shturl');
        $nocustid=$this->input->post('nocustid');
        $getcustidquery=$this->Mdl_finance_extract_deposit_pdf->DDE_Dep_Exct_recversion($getid,$unitno,$month,$name,$shturl,$nocustid);
        echo json_encode($getcustidquery);
    }
    public function DDE_Dep_Exct_submit(){
        $selectedunit=$this->input->post('DDE_lb_unitselect');
        $customername=$this->input->post('DDE_lb_customerselect');
        $customernameid=$this->input->post('DDE_customer_id_name');
        $shturl=$this->input->post('shturl');
        $chkboxinc=$this->input->post('DDE_chk_checkboxinc');
        if($customernameid!=''){
            $customername=$customernameid;
        }
        if($chkboxinc!=''){
            if(is_array($chkboxinc)==true){
                $checkarray=$chkboxinc;
            }
            else
            {
                $checkarray=$chkboxinc;
            }
        }
        else{
            $checkarray[]=$this->input->post('DDE_tb_recdate');
        }
        $selectedsheet=$this->input->post('DDE_lb_monthselect');
        $customermail=$this->input->post('DDE_LB_Emaillist');
        $customeridname=$this->input->post('DDE_customer_id_name');
        $getcustidquery=$this->Mdl_finance_extract_deposit_pdf->DDE_Dep_Exctsubmit($shturl,$selectedunit,$customername,$checkarray,$selectedsheet,$customermail,$customeridname);
//        echo json_encode($getcustidquery);
        echo $string = implode(array_map("chr", $getcustidquery));
//        $pdfheader=$selectedunit.'-'.$customername;
//        $this->load->library('pdf');
//        $pdf = $this->pdf->load();
//        $pdf=new mPDF('utf-8','A4');
//        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
//        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
//        $pdf->WriteHTML($getcustidquery);
//        $pdf->Output($pdfheader.'.pdf', 'D');
    }
}