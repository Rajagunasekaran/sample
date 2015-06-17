<?php
class Ctrl_Biz_Expense_Detail_Entry_Search_Update_Delete extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EXPENSE/BIZEXPENSE/Mdl_biz_expense_detail_entry_search_update_delete');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
// initial form
    public function index()
    {
        $this->load->view('EXPENSE/BIZEXPENSE/Vw_Biz_Expense_Detail_Entry_Search_Update_Delete');
    }
    public function BDTL_INPUT_expense_err_invoice(){
        
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BDTL_INPUT_expense_err_invoice() ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_all_exp_types_unitno(){
        $BDTL_INPUT_all_expense_types=$this->input->post('BDTL_INPUT_all_expense_types');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BDTL_INPUT_all_exp_types_unitno($BDTL_INPUT_all_expense_types) ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_get_SDate_EDate()
    {
        $unitselectedlist=$this->input->post('unitselectedlist');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BDTL_INPUT_get_SDate_EDate($unitselectedlist) ;
        echo JSON_encode($result);
    }
    public function BDTL_INPUT_airconservicedby_check()
    {
        $BDTL_INPUT_newaircon=$this->input->post('BDTL_INPUT_newaircon');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BDTL_INPUT_airconservicedby_check($BDTL_INPUT_newaircon) ;
        echo ($result);
    }
    public function Cal_service(){
        $this->load->library('Google');
        $this->load->model('EILIB/Mdl_eilib_calender');
        $cal= $this->Mdl_eilib_calender->createCalendarService();
        return $cal;
    }
    public function BDTL_INPUT_save()
    {
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $calid=$this->Cal_service();
        $BDTL_INPUT_tb_newaircon=$this->input->post('BDTL_INPUT_tb_newaircon');
        $BDTL_INPUT_aircon_oldservice = $this->input->post('BDTL_INPUT_lb_airconservicedby');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BDTL_INPUT_save($USERSTAMP,$BDTL_INPUT_tb_newaircon,$calid,$BDTL_INPUT_aircon_oldservice) ;
        echo JSON_encode($result);
    }
 //SEARCH AND UPDATE FORM
    public function BTDTL_SEARCH_expensetypes(){
        
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_expensetypes() ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_expense_searchby(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_search_option=$this->input->post('BTDTL_SEARCH_search_option');
        $BTDTL_SEARCH_lb_expense_types=$this->input->post('BTDTL_SEARCH_lb_expense_types');
        $BTDTL_SEARCH_flag_searchby=$this->input->post('BTDTL_SEARCH_flag_searchby');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_expense_searchby($BTDTL_SEARCH_search_option,$BTDTL_SEARCH_lb_expense_types,$BTDTL_SEARCH_flag_searchby,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_comments_autocomplete(){
        $searchoptions=$this->input->post('searchoptions');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_comments_autocomplete($searchoptions) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_flex_aircon(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_ariconunitno=$this->input->post('BTDTL_SEARCH_lb_ariconunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_flex_aircon($BTDTL_SEARCH_lb_ariconunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_flex_aircon1(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_ariconunitno=$this->input->post('BTDTL_SEARCH_lb_ariconservicedbyunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_flex_aircon($BTDTL_SEARCH_lb_ariconunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_flex_aircon2(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_ta_airconcomments=$this->input->post('BTDTL_SEARCH_ta_airconcomments');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_flex_aircon($BTDTL_SEARCH_ta_airconcomments,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_carpark(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_carno=$this->input->post('BTDTL_SEARCH_lb_carno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_carpark($BTDTL_SEARCH_lb_carno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_carpark1(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_carparkunitno=$this->input->post('BTDTL_SEARCH_lb_carparkunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_carpark($BTDTL_SEARCH_lb_carparkunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_carpark2(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_ta_carparkcomments=$this->input->post('BTDTL_SEARCH_ta_carparkcomments');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_carpark($BTDTL_SEARCH_ta_carparkcomments,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_digital(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_digitalacctno=$this->input->post('BTDTL_SEARCH_lb_digitalacctno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_digital($BTDTL_SEARCH_lb_digitalacctno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_digital1(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_digitalvoiceno=$this->input->post('BTDTL_SEARCH_lb_digitalvoiceno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_digital($BTDTL_SEARCH_lb_digitalvoiceno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_digital2(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_digitalinvoiceto=$this->input->post('BTDTL_SEARCH_lb_digitalinvoiceto');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_digital($BTDTL_SEARCH_lb_digitalinvoiceto,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_digital3(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_digitalunitno=$this->input->post('BTDTL_SEARCH_lb_digitalunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_digital($BTDTL_SEARCH_lb_digitalunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_digital4(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_ta_digitalcomments=$this->input->post('BTDTL_SEARCH_ta_digitalcomments');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_digital($BTDTL_SEARCH_ta_digitalcomments,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_electricity(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_electricityinvoiceto=$this->input->post('BTDTL_SEARCH_lb_electricityinvoiceto');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_electricity($BTDTL_SEARCH_lb_electricityinvoiceto,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_electricity1(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_electricityunitno=$this->input->post('BTDTL_SEARCH_lb_electricityunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_electricity($BTDTL_SEARCH_lb_electricityunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_electricity2(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_ta_electricitycomments=$this->input->post('BTDTL_SEARCH_ta_electricitycomments');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_electricity($BTDTL_SEARCH_ta_electricitycomments,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_lb_starhubunitno=$this->input->post('BTDTL_SEARCH_lb_starhubunitno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub("",$BTDTL_SEARCH_lb_starhubunitno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub1(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_flag=$this->input->post('BTDTL_SEARCH_flag');
        $BTDTL_SEARCH_lb_starhubacctno=$this->input->post('BTDTL_SEARCH_lb_starhubacctno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_flag,$BTDTL_SEARCH_lb_starhubacctno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub2(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_emptyflag=$this->input->post('BTDTL_SEARCH_emptyflag');
        $BTDTL_SEARCH_lb_starhubinvoiceto=$this->input->post('BTDTL_SEARCH_lb_starhubinvoiceto');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_emptyflag,$BTDTL_SEARCH_lb_starhubinvoiceto,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub3(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_emptyflag=$this->input->post('BTDTL_SEARCH_emptyflag');
        $BTDTL_SEARCH_lb_starhubssid=$this->input->post('BTDTL_SEARCH_lb_starhubssid');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_emptyflag,$BTDTL_SEARCH_lb_starhubssid,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub4(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_emptyflag=$this->input->post('BTDTL_SEARCH_emptyflag');
        $BTDTL_SEARCH_lb_starhubpwd=$this->input->post('BTDTL_SEARCH_lb_starhubpwd');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_emptyflag,$BTDTL_SEARCH_lb_starhubpwd,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub5(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_emptyflag=$this->input->post('BTDTL_SEARCH_emptyflag');
        $BTDTL_SEARCH_lb_starhubmodem=$this->input->post('BTDTL_SEARCH_lb_starhubmodem');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_emptyflag,$BTDTL_SEARCH_lb_starhubmodem,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub6(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_emptyflag=$this->input->post('BTDTL_SEARCH_emptyflag');
        $BTDTL_SEARCH_lb_starhub_cableserialno=$this->input->post('BTDTL_SEARCH_lb_starhub_cableserialno');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_emptyflag,$BTDTL_SEARCH_lb_starhub_cableserialno,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub7(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_emptyflag=$this->input->post('BTDTL_SEARCH_emptyflag');
        $BTDTL_SEARCH_ta_starhubaddtnlch=$this->input->post('BTDTL_SEARCH_ta_starhubaddtnlch');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_emptyflag,$BTDTL_SEARCH_ta_starhubaddtnlch,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub8(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_emptyflag=$this->input->post('BTDTL_SEARCH_emptyflag');
        $BTDTL_SEARCH_ta_starhubbasic=$this->input->post('BTDTL_SEARCH_ta_starhubbasic');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_emptyflag,$BTDTL_SEARCH_ta_starhubbasic,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub9(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_emptyflag=$this->input->post('BTDTL_SEARCH_emptyflag');
        $BTDTL_SEARCH_ta_starhubcomments=$this->input->post('BTDTL_SEARCH_ta_starhubcomments');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_emptyflag,$BTDTL_SEARCH_ta_starhubcomments,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub10(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_starhubappl_startdate=$this->input->post('BTDTL_SEARCH_starhubappl_startdate');
        $BTDTL_SEARCH_starhubappl_enddate=$this->input->post('BTDTL_SEARCH_starhubappl_enddate');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_starhubappl_startdate,$BTDTL_SEARCH_starhubappl_enddate,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub11(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_cable_startdate=$this->input->post('BTDTL_SEARCH_cable_startdate');
        $BTDTL_SEARCH_cable_enddate=$this->input->post('BTDTL_SEARCH_cable_enddate');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_cable_startdate,$BTDTL_SEARCH_cable_enddate,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function BTDTL_SEARCH_show_starhub12(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $BTDTL_SEARCH_internet_startdate=$this->input->post('BTDTL_SEARCH_internet_startdate');
        $BTDTL_SEARCH_internet_enddatee=$this->input->post('BTDTL_SEARCH_internet_enddate');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->post('BTDTL_SEARCH_parentfunc_flex');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_internet_startdate,$BTDTL_SEARCH_internet_enddatee,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat) ;
        echo JSON_encode($result);
    }
    public function airconserviceupdate(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $primaryid=$this->input->post('primaryid');
        $unitid=$this->input->post('unitid');
        $airconserviceby=$this->input->post('airconserviceby');
        $aircomments=$this->input->post('aircomments');
        $serviceby=$this->input->post('serviceby');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_lb_expense_type=$this->input->post('BTDTL_SEARCH_lb_expense_type');
        $searchvalue=$this->input->post('searchvalue');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->airconserviceupdate($primaryid,$unitid,$airconserviceby,$aircomments,$serviceby,$USERSTAMP,$timeZoneFormat,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_lb_expense_type,$searchvalue) ;
        echo JSON_encode($result);
    }
    public function carparkupdate(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $primaryid=$this->input->post('primaryid');
        $unitid=$this->input->post('unitid');
        $carno=$this->input->post('carno');
        $carparkcomments=$this->input->post('carparkcomments');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_lb_expense_type=$this->input->post('BTDTL_SEARCH_lb_expense_type');
        $searchvalue=$this->input->post('searchvalue');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->carparkupdate($primaryid,$unitid,$carno,$carparkcomments,$USERSTAMP,$timeZoneFormat,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_lb_expense_type,$searchvalue) ;
        echo JSON_encode($result);
    }
    public function digitalvoiceupdate(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $primaryid=$this->input->post('primaryid');
        $unitid=$this->input->post('unitid');
        $invoiceto=$this->input->post('invoiceto');
        $invoiceno=$this->input->post('invoiceno');
        $acctno=$this->input->post('acctno');
        $comments=$this->input->post('comments');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_lb_expense_type=$this->input->post('BTDTL_SEARCH_lb_expense_type');
        $searchvalue=$this->input->post('searchvalue');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->digitalvoiceupdate($primaryid,$unitid,$invoiceto,$invoiceno,$acctno,$comments,$USERSTAMP,$timeZoneFormat,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_lb_expense_type,$searchvalue) ;
        echo JSON_encode($result);
    }
    public function electricityupdate(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $primaryid=$this->input->post('primaryid');
        $unitid=$this->input->post('unitid');
        $invoiceto=$this->input->post('invoiceto');
        $electcomments=$this->input->post('electcomments');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_lb_expense_type=$this->input->post('BTDTL_SEARCH_lb_expense_type');
        $searchvalue=$this->input->post('searchvalue');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->electricityupdate($primaryid,$unitid,$invoiceto,$electcomments,$USERSTAMP,$timeZoneFormat,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_lb_expense_type,$searchvalue) ;
        echo JSON_encode($result);
    }
    public function starhubupdate(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $primaryid=$this->input->post('primaryid');
        $unitid=$this->input->post('unitid');
        $unitno=$this->input->post('unitno');
        $appldate=$this->input->post('appldate');
        $acctno=$this->input->post('acctno');
        $invoiceto=$this->input->post('invoiceto');
        $cablestartdte=$this->input->post('cablestartdte');
        $cableenddate=$this->input->post('cableenddate');
        $internetstartdte=$this->input->post('internetstartdte');
        $internetenddate=$this->input->post('internetenddate');
        $ssid=$this->input->post('ssid');
        $pwd=$this->input->post('pwd');
        $cablebox=$this->input->post('cablebox');
        $modemno=$this->input->post('modemno');
        $basicgroup=$this->input->post('basicgroup');
        $addchnnl=$this->input->post('addchnnl');
        $comments=$this->input->post('comments');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_lb_expense_type=$this->input->post('BTDTL_SEARCH_lb_expense_type');
        $searchvalue=$this->input->post('searchvalue');
        $startdate=$this->input->post('startdate');
        $BTDTL_SEARCH_starhubid=$this->input->post('BTDTL_SEARCH_starhubid');
        $calid=$this->Cal_service();
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->starhubupdate($primaryid,$unitid,$unitno,$appldate,$acctno,$invoiceto,$cablestartdte,$cableenddate,$internetstartdte,$internetenddate,$ssid,$pwd,$cablebox,$modemno,$basicgroup,$addchnnl,$comments,$USERSTAMP,$timeZoneFormat,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_lb_expense_type,$searchvalue,$startdate,$BTDTL_SEARCH_starhubid,$calid) ;
        echo JSON_encode($result);
    }
    public function checktransaction()
    {
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $primaryid=$this->input->post('rowid');
        $unitid=$this->input->post('unitid');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_lb_expense_type=$this->input->post('BTDTL_SEARCH_lb_expense_type');
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->checktransaction($primaryid,$unitid,$USERSTAMP,$timeZoneFormat,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_lb_expense_type) ;
        echo json_encode($result);
    }
    public function deletefunction(){
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $primaryid=$this->input->post('rowid');
        $unitid=$this->input->post('unitid');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->post('BTDTL_SEARCH_lb_searchoptions');
        $BTDTL_SEARCH_lb_expense_type=$this->input->post('BTDTL_SEARCH_lb_expense_type');
        $searchvalue=$this->input->post('searchvalue');
        $startdate=$this->input->post('startdate');
        $BTDTL_SEARCH_starhubid=$this->input->post('BTDTL_SEARCH_starhubid');
        $BTDTL_SEARCH_obj=$this->input->post('BTDTL_SEARCH_obj');
        $calid=$this->Cal_service();
        $result = $this->Mdl_biz_expense_detail_entry_search_update_delete->deletefunction($primaryid,$unitid,$USERSTAMP,$timeZoneFormat,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_lb_expense_type,$searchvalue,$startdate,$BTDTL_SEARCH_starhubid,$calid,$BTDTL_SEARCH_obj) ;
        echo json_encode($result);
    }
}