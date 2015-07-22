<?php
class Ctrl_Staff_Employee_Entry_Search_Update_Delete extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('EXPENSE/STAFF/Mdl_staff_employee_entry_search_update_delete');
    }
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('EXPENSE/STAFF/Vw_Staff_Employee_Entry_Search_Update_Delete');
    }
    //FUNCTION FOR INITIAL DATA
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $query=$this->Mdl_staff_employee_entry_search_update_delete->Initialdata($ErrorMessage);
        echo json_encode($query);
    }
    //FUNCTION FOR SAVE PART
    public function EMP_ENTRY_save()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_employee_entry_search_update_delete->EMP_ENTRY_insert($USERSTAMP,$this->input->post('EMP_ENTRY_email'),$this->input->post('EMP_ENTRY_comments'),$this->input->post('EMP_ENTRY_radio_null'),$this->input->post('submenu')) ;
        echo JSON_encode($result);
    }
    //FUNCTION FOR INITIAL DATA FOR SEARCH FORM
    public function EMPSRC_UPD_DEL_searchoptionresult(){
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
//        $this->load->model('Mdl_staff_employee_entry_search_update_delete');
        $query=$this->Mdl_staff_employee_entry_search_update_delete->EMPSRC_UPD_DEL_searchoptionresult($ErrorMessage);
        echo json_encode($query);
    }
    //FUNCTION FOR FETCH DATA
    public function fetchdata()
    {
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $result = $this->Mdl_staff_employee_entry_search_update_delete->fetch_data($timeZoneFormat,$this->input->post('EMPSRC_UPD_DEL_lb_designation_listbox'),$this->input->post('emp_first_name'),$this->input->post('emp_last_name'),$this->input->post('EMPSRC_UPD_DEL_ta_mobile'),$this->input->post('EMPSRC_UPD_DEL_lb_employeename_listbox'),$this->input->post('EMPSRC_UPD_DEL_lb_searchoption'),$this->input->post('EMPSRC_UPD_DEL_ta_email'),$this->input->post('EMPSRC_UPD_DEL_ta_comments')) ;
        echo JSON_encode($result);
    }
    public  function EMPLOYEE_pdf(){

        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $this->load->library('pdf');
        $pdfresult='';
        $pdfresult=$this->Mdl_staff_employee_entry_search_update_delete->Employee_pdf($timeZoneFormat,$_GET['EMPSRC_UPD_DEL_lb_designation_listbox'],$_GET['emp_first_name'],$_GET['emp_last_name'],$_GET['EMPSRC_UPD_DEL_ta_mobile'],$_GET['EMPSRC_UPD_DEL_lb_employeename_listbox'],$_GET['EMPSRC_UPD_DEL_lb_searchoption'],$_GET['EMPSRC_UPD_DEL_ta_email'],$_GET['EMPSRC_UPD_DEL_ta_comments']);
        $header=$_GET['header'];
        $pdfheader=$header;//'TICKLER HISTORY FOR CUSTOMER:'.$TH_fname.' '.$TH_lname;
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
    }
    //PDLY_SEARCH_lb_comments
    public function EMPSRC_UPD_DEL_comments()
    {
        $this->load->model('EXPENSE/STAFF/Mdl_staff_employee_entry_search_update_delete');
        $data=$this->Mdl_staff_employee_entry_search_update_delete->EMPSRC_UPD_DEL_comments($this->input->post('EMPSRC_UPD_DEL_lb_searchoption'));
        echo json_encode($data);
    }
    //FUNCTION FOR GET CARD NO ND UNIT NO DATA
    public function EMPSRC_UPD_DEL_getcardnoandunitno(){
        $query=$this->Mdl_staff_employee_entry_search_update_delete->EMPSRC_UPD_DEL_getcardnoandunitno($this->input->post('EMPSRC_UPD_DEL_id'));
        echo json_encode($query);
    }
    //FUNCTION FOR SAVE PART
    public function EMPSRC_UPD_DEL_update()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();

        $result = $this->Mdl_staff_employee_entry_search_update_delete->EMPSRC_UPD_DEL_update($USERSTAMP,$this->input->post('EMPSRC_UPD_DEL_email'),$this->input->post('EMPSRC_UPD_DEL_comments'),$this->input->post('EMP_ENTRY_radio_null'),$this->input->post('submenu'),$this->input->post('EMPSRC_UPD_DEL_id')) ;
        echo JSON_encode($result);
    }
    //DELETE OPTION
    public function deleteoption(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_employee_entry_search_update_delete->deleteoption($USERSTAMP,$this->input->post('EMPSRC_UPD_DEL_deleteid')) ;
        echo JSON_encode($result);
    }
}