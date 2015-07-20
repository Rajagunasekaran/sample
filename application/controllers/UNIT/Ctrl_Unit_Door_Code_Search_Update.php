<?php
class Ctrl_Unit_Door_Code_Search_Update extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('UNIT/Mdl_unit_door_code_search_update');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('UNIT/Vw_Unit_Door_Code_Search_Update');
    }
    public function Initialdata(){
        $query=$this->Mdl_unit_door_code_search_update->Initial_data();
        echo json_encode($query);
    }
    public function DCSU_logindetails(){
        $timeZoneFrmt= $this->Mdl_eilib_common_function->getTimezone();
        $unitnumber=$this->input->post("DCSU_unitnumber");
        $flag=$this->input->post("DCSU_flag");
        $logindetails=$this->Mdl_unit_door_code_search_update->DCSU_login_details($unitnumber,$flag,$timeZoneFrmt);
        echo json_encode($logindetails);
    }
    public function DCSU_updateDoorcode(){
        $timeZoneFrmt= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $loginid=$this->input->post("DCSU_login_id");
        $unitnumber=$this->input->post("DCSU_unitnumber");
        $doorcode=$this->input->post("DCSU_doorcode");
        $weblogin=$this->input->post("DCSU_weblogin");
        $webpass=$this->input->post("DCSU_webpass");
        $loginrs=$this->Mdl_unit_door_code_search_update->DCSU_update_Doorcode($loginid,$unitnumber,$doorcode,$weblogin,$webpass,$USERSTAMP,$timeZoneFrmt);
        echo json_encode($loginrs);
    }
    public function DCSU_ExistsDoorcode(){
        $DCSU_doorcode=$this->input->post("val");
        $DCSU_flag_doorCodeLogin=$this->input->post("flag");
        $DCSU_arr=$this->Mdl_eilib_common_function->Check_ExistsDoorcodeLogin($DCSU_doorcode, $DCSU_flag_doorCodeLogin);
        echo json_encode($DCSU_arr);
    }
    public function DCSU_tablepdf(){
        $timeZoneFrmt= $this->Mdl_eilib_common_function->getTimezone();
        $unitno=$this->input->get("DCSUunitno");
        $pdfresult=$this->Mdl_unit_door_code_search_update->DCSU_table_pdf($unitno,$timeZoneFrmt);
        $pdfheader='DOOR CODE LOGIN DETAILS FOR THE UNIT NUMBER '.$unitno;
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
    }
}