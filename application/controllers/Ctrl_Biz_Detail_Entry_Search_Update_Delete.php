<?php
include "GET_USERSTAMP.php";
include 'GET_CONFIG.php';
$USERSTAMP=$UserStamp;
class Ctrl_Biz_Detail_Entry_Search_Update_Delete extends CI_Controller{
// initial form
    public function index()
    {
        $this->load->view('EXPENSE/Vw_Biz_Detail_Entry_Search_Update_Delete');
    }
    public function BDTL_INPUT_expense_err_invoice(){
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_expense_err_invoice() ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_all_exp_types_unitno(){
        $BDTL_INPUT_all_expense_types=$this->input->post('BDTL_INPUT_all_expense_types');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_all_exp_types_unitno($BDTL_INPUT_all_expense_types) ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_get_SDate_EDate()
    {
        $unitselectedlist=$this->input->post('unitselectedlist');
         $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_get_SDate_EDate($unitselectedlist) ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_airconservicedby_check()
    {
        $BDTL_INPUT_newaircon=$this->input->post('BDTL_INPUT_newaircon');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_airconservicedby_check($BDTL_INPUT_newaircon) ;
        echo ($result);
    }
    public function Cal_service(){
        $this->load->library('Google');
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->model('Eilib/Calender');
        // FUNCTION TO CALL AND GET THE CALENDAR SERVICE
        $cal= $this->Calender->createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        return $cal;
    }
    public function BDTL_INPUT_save()
    {
        global $USERSTAMP;
        $calid=$this->Cal_service();
        $BDTL_INPUT_tb_newaircon=$this->input->post('BDTL_INPUT_tb_newaircon');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BDTL_INPUT_save($USERSTAMP,$BDTL_INPUT_tb_newaircon,$calid) ;
        echo JSON_encode($result);
    }
 //SEARCH AND UPDATE FORM
    public function BTDTL_SEARCH_expensetypes(){
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_expensetypes() ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_expense_searchby(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_search_option=$this->input->post('BTDTL_SEARCH_search_option');
        $BTDTL_SEARCH_lb_expense_types=$this->input->post('BTDTL_SEARCH_lb_expense_types');
        $BTDTL_SEARCH_flag_searchby=$this->input->post('BTDTL_SEARCH_flag_searchby');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_expense_searchby($BTDTL_SEARCH_search_option,$BTDTL_SEARCH_lb_expense_types,$BTDTL_SEARCH_flag_searchby,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_comments_autocomplete(){
        $searchoptions=$this->input->post('searchoptions');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_comments_autocomplete($searchoptions) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_flex_aircon(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_ariconunitno=$this->input->post('BTDTL_SEARCH_lb_ariconunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_flex_aircon($BTDTL_SEARCH_lb_ariconunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_flex_aircon1(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_ariconunitno=$this->input->post('BTDTL_SEARCH_lb_ariconservicedbyunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_flex_aircon($BTDTL_SEARCH_lb_ariconunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_carpark(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_carno=$this->input->post('BTDTL_SEARCH_lb_carno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_carpark($BTDTL_SEARCH_lb_carno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_carpark1(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_carparkunitno=$this->input->post('BTDTL_SEARCH_lb_carparkunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_carpark($BTDTL_SEARCH_lb_carparkunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_digital(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_digitalacctno=$this->input->post('BTDTL_SEARCH_lb_digitalacctno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_digital($BTDTL_SEARCH_lb_digitalacctno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_digital1(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_digitalvoiceno=$this->input->post('BTDTL_SEARCH_lb_digitalvoiceno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_digital($BTDTL_SEARCH_lb_digitalvoiceno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_digital2(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_digitalinvoiceto=$this->input->post('BTDTL_SEARCH_lb_digitalinvoiceto');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_digital($BTDTL_SEARCH_lb_digitalinvoiceto,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_digital3(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_digitalunitno=$this->input->post('BTDTL_SEARCH_lb_digitalunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_digital($BTDTL_SEARCH_lb_digitalunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_electricity(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_electricityinvoiceto=$this->input->post('BTDTL_SEARCH_lb_electricityinvoiceto');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_electricity($BTDTL_SEARCH_lb_electricityinvoiceto,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_electricity1(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_electricityunitno=$this->input->post('BTDTL_SEARCH_lb_electricityunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_electricity($BTDTL_SEARCH_lb_electricityunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_lb_starhubunitno=$this->input->post('BTDTL_SEARCH_lb_starhubunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub("",$BTDTL_SEARCH_lb_starhubunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub1(){
        global $timeZoneFormat;
        $BTDTL_SEARCH_flag=$this->input->post('BTDTL_SEARCH_flag');
        $BTDTL_SEARCH_lb_starhubacctno=$this->input->post('BTDTL_SEARCH_lb_starhubacctno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $this->load->model('Mdl_biz_detail_entry_search_update_delete');
        $result = $this->Mdl_biz_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_flag,$BTDTL_SEARCH_lb_starhubacctno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
}