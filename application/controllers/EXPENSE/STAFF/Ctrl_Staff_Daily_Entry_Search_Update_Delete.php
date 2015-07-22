<?php
class Ctrl_Staff_Daily_Entry_Search_Update_Delete extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('EXPENSE/STAFF/Mdl_staff_daily_entry_search_update_delete');
    }
    public function index(){
        $this->load->view('EXPENSE/STAFF/Vw_Staff_Daily_Entry_Search_Update_Delete');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $query=$this->Mdl_staff_daily_entry_search_update_delete->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    //FUNCTIONFOR SAVE PART
    public function STDLY_INPUT_savedata()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_INPUT_insert($USERSTAMP) ;
        echo $result;
    }
    //FUNCTIONFOR SAVE PART
    public function STDLY_INPUT_savestaff()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_INPUT_insertstaff($USERSTAMP) ;
        echo ($result);
    }
    public function STDLY_SEARCH_searchbyagentcommission(){
        $query=$this->Mdl_staff_daily_entry_search_update_delete->STDLY_SEARCH_searchby_agent();
        echo json_encode($query);
    }
    // fetch data
    public function fetchdata()
    {
        $data=$this->Mdl_staff_daily_entry_search_update_delete->fetch_data();
        echo json_encode($data);
    }
    public function Staff_Daily_pdf(){
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $this->load->library('pdf');
        $pdfresult='';
        $STDLY_SEARCH_listoption=$_GET['STDLY_SEARCH_listoption'];
        $pdfresult = $this->Mdl_staff_daily_entry_search_update_delete->Staff_Daily_pdf();//$timeZoneFormat,$_GET['EMPSRC_UPD_DEL_lb_designation_listbox'],$_GET['emp_first_name'],$_GET['emp_last_name'],$_GET['EMPSRC_UPD_DEL_ta_mobile'],$_GET['EMPSRC_UPD_DEL_lb_employeename_listbox'],$_GET['EMPSRC_UPD_DEL_lb_searchoption'],$_GET['EMPSRC_UPD_DEL_ta_email'],$_GET['EMPSRC_UPD_DEL_ta_comments']);
        $header=$_GET['header'];
        $header= str_replace("^","&",$header);
        $pdfheader=$header;//'TICKLER HISTORY FOR CUSTOMER:'.$TH_fname.' '.$TH_lname;
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4-L');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
        $data=$this->Mdl_staff_daily_entry_search_update_delete->Staff_Daily_pdf();
        echo json_encode($data);

    }
    // fetch data
    public function fetch_salary_data()
    {
        $data=$this->Mdl_staff_daily_entry_search_update_delete->fetch_salarydata();
        echo json_encode($data);
    }

    public function STDLY_SEARCH_func_comments()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $STDLY_SEARCH_startdate=$this->input->post('STDLY_SEARCH_startdate');
        $STDLY_SEARCH_enddate=$this->input->post('STDLY_SEARCH_enddate');
        $this->load->database();
        $data=$this->Mdl_staff_daily_entry_search_update_delete->STDLY_SEARCH_comments($USERSTAMP,$this->input->post('STDLY_SEARCH_sec_searchoption'),$STDLY_SEARCH_startdate,$STDLY_SEARCH_enddate);
        echo json_encode($data);
    }
    //FUNCTION FOR AGENT UPDATE PART
    public function agentcommissionupdate()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $primaryid=$this->input->post('id');
        $agentdate=$this->input->post('agentdate');
        $agentcomments=$this->input->post('STDLY_SEARCH_comments');
        $agentamount=$this->input->post('STDTL_SEARCH_agentcommissionamt');
        $result = $this->Mdl_staff_daily_entry_search_update_delete->update_agentdata($USERSTAMP,$primaryid,$agentdate,$agentcomments,$agentamount) ;
        echo ($result);
    }
    //FUNCTION FOR STAFF UPDATE
    public  function update_staff(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $STDLY_SEARCH_lbstaffexpense = $this->input->post('STDLY_SEARCH_lbstaffexpense');
        $STDLY_SEARCH_dbinvoicedate = $this->input->post('STDLY_SEARCH_dbinvoicedate');
        $STDLY_SEARCH_dbinvoicedate = date('Y-m-d', strtotime($STDLY_SEARCH_dbinvoicedate));
        $STDLY_SEARCH_staff_fullamount = $this->input->post('STDLY_SEARCH_staff_fullamount');
        $STDLY_SEARCH_tbinvoiceitems = $this->input->post('STDLY_SEARCH_tbinvoiceitems');
        $STDLY_SEARCH_tbinvoicefrom = $this->input->post('STDLY_SEARCH_tbinvoicefrom');
        $STDLY_SEARCH_tbcomments = $this->input->post('STDLY_SEARCH_tbcomments');
        $id=$this->input->post('id');
        $result = $this->Mdl_staff_daily_entry_search_update_delete->update_staff($USERSTAMP,$STDLY_SEARCH_lbstaffexpense,$STDLY_SEARCH_dbinvoicedate,$STDLY_SEARCH_staff_fullamount,$STDLY_SEARCH_tbinvoiceitems,$STDLY_SEARCH_tbinvoicefrom,$STDLY_SEARCH_tbcomments,$id) ;
        echo ($result);
    }
    //FUNCTION FOR SALARY UPDATE PART
    public function STDLY_salaryupdate()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_salaryupdate($USERSTAMP) ;
        echo json_encode($result);
    }
    // fetch data
    public function STDLY_SEARCH_sendallstaffdata()
    {
        $data=$this->Mdl_staff_daily_entry_search_update_delete->fetch_staffsalarydata();
        echo json_encode($data);
    }
    //FUNCTION FOR GET EMP ND CPF NO
    public function STDLY_SEARCH_loadcpfno(){
        $Values = $this->Mdl_staff_daily_entry_search_update_delete->STDLY_SEARCH_getempcpfno();
        echo json_encode($Values);
    }
    //FUNCTION FOR DELETE CONFORM
    public function deleteconformoption(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $rowid=$this->input->post('rowid');
        $STDLY_SEARCH_typelist=$this->input->post('STDLY_SEARCH_typelist');
        $STDLY_SEARCH_srchoption=$this->input->post('STDLY_SEARCH_srchoption');
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $result = $this->Mdl_staff_daily_entry_search_update_delete->DeleteRecord($USERSTAMP,$rowid,$STDLY_SEARCH_typelist,$STDLY_SEARCH_srchoption,$startdate,$enddate) ;
        echo JSON_encode($result);
    }
}