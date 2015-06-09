<?php
class Ctrl_Personal_Daily_Entry_Search_Update_Delete extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EXPENSE/PERSONAL/Mdl_personal_daily_entry_search_update_delete');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
// initial form
    public function index()
    {
        $this->load->view('EXPENSE/PERSONAL/Vw_Personal_Daily_Entry_Search_Update_Delete');
    }
// fetch data
    public function commondata()
    {
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $this->load->database();
        $data=$this->Mdl_personal_daily_entry_search_update_delete->common_data($ErrorMessage);
        echo json_encode($data);
    }
// CAR EXPENSE SAVE FUNCTION
    public function carexpensesave()
    {
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_personal_daily_entry_search_update_delete->carexpenseinsert($USERSTAMP) ;
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }
// CAR LOAN SAVE FUNCTION
    public function carloansave()
    {
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_personal_daily_entry_search_update_delete->carloaninsert($USERSTAMP) ;
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }

//BABY AND PERSONAL SAVE FUNCTION
    public function babypersonalsave()
    {
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $result = $this->Mdl_personal_daily_entry_search_update_delete->babypersonalinsert($USERSTAMP) ;
        echo JSON_encode($result);
    }

 // search updte fetch data
    public function srchupdatecommondata()
    {
        $this->load->database();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $data=$this->Mdl_personal_daily_entry_search_update_delete->srchupdte_common_data($ErrorMessage);
        echo json_encode($data);
    }
    //PDLY_SEARCH_lb_babysearchoptionvalue
    public function PDLY_SEARCH_lb_babysearchoptionvalue()
    {
        $this->load->database();
        $categorydata= $this->input->post('categorydata');
        $data=$this->Mdl_personal_daily_entry_search_update_delete->PDLY_SEARCH_lb_babysearchoptionvalue($categorydata);
        echo json_encode($data);
    }
    //PDLY_SEARCH_lb_comments
    public function PDLY_SEARCH_lb_comments()
    {
        $this->load->database();
        $PDLY_SEARCH_lb_typelistvalue= $this->input->post('PDLY_SEARCH_lb_typelistvalue');
        $PDLY_SEARCH_lb_getstartvaluevalue= $this->input->post('PDLY_SEARCH_lb_getstartvaluevalue');
        $PDLY_SEARCH_lb_getstartvaluevalue=date('Y-m-d',strtotime($PDLY_SEARCH_lb_getstartvaluevalue));
        $PDLY_SEARCH_lb_getendvaluevalue= $this->input->post('PDLY_SEARCH_lb_getendvaluevalue');
        $PDLY_SEARCH_lb_getendvaluevalue=date('Y-m-d',strtotime($PDLY_SEARCH_lb_getendvaluevalue));
        $data=$this->Mdl_personal_daily_entry_search_update_delete->PDLY_SEARCH_lb_comments($PDLY_SEARCH_lb_typelistvalue,$PDLY_SEARCH_lb_getstartvaluevalue,$PDLY_SEARCH_lb_getendvaluevalue);
        echo json_encode($data);
    }
    //PDLY_SEARCH_lb_invoicefrom
    public function PDLY_SEARCH_lb_invoicefrom()
    {
        $this->load->database();
        $PDLY_SEARCH_lb_typelistvalue= $this->input->post('PDLY_SEARCH_lb_typelistvalue');
        $PDLY_SEARCH_lb_babysearchoptionvalue=$this->input->post('PDLY_SEARCH_lb_babysearchoptionvalue');
        $PDLY_SEARCH_lb_getstartvaluevalue= $this->input->post('PDLY_SEARCH_lb_getstartvaluevalue');
        $PDLY_SEARCH_lb_getstartvaluevalue=date('Y-m-d',strtotime($PDLY_SEARCH_lb_getstartvaluevalue));
        $PDLY_SEARCH_lb_getendvaluevalue= $this->input->post('PDLY_SEARCH_lb_getendvaluevalue');
        $PDLY_SEARCH_lb_getendvaluevalue=date('Y-m-d',strtotime($PDLY_SEARCH_lb_getendvaluevalue));
        $data=$this->Mdl_personal_daily_entry_search_update_delete->PDLY_SEARCH_lb_invoicefrom($PDLY_SEARCH_lb_typelistvalue,$PDLY_SEARCH_lb_getstartvaluevalue,$PDLY_SEARCH_lb_getendvaluevalue,$PDLY_SEARCH_lb_babysearchoptionvalue);
        echo json_encode($data);
    }
    //PDLY_SEARCH_lb_invoiceitems
    public function PDLY_SEARCH_lb_invoiceitems()
    {
        $this->load->database();
        $PDLY_SEARCH_lb_typelistvalue= $this->input->post('PDLY_SEARCH_lb_typelistvalue');
        $PDLY_SEARCH_lb_babysearchoptionvalue=$this->input->post('PDLY_SEARCH_lb_babysearchoptionvalue');
        $PDLY_SEARCH_lb_getstartvaluevalue= $this->input->post('PDLY_SEARCH_lb_getstartvaluevalue');
        $PDLY_SEARCH_lb_getstartvaluevalue=date('Y-m-d',strtotime($PDLY_SEARCH_lb_getstartvaluevalue));
        $PDLY_SEARCH_lb_getendvaluevalue= $this->input->post('PDLY_SEARCH_lb_getendvaluevalue');
        $PDLY_SEARCH_lb_getendvaluevalue=date('Y-m-d',strtotime($PDLY_SEARCH_lb_getendvaluevalue));
        $data=$this->Mdl_personal_daily_entry_search_update_delete->PDLY_SEARCH_lb_invoiceitems($PDLY_SEARCH_lb_typelistvalue,$PDLY_SEARCH_lb_getstartvaluevalue,$PDLY_SEARCH_lb_getendvaluevalue,$PDLY_SEARCH_lb_babysearchoptionvalue);
        echo json_encode($data);
    }
    //PDLY_SEARCH_searchbybaby
    public function PDLY_SEARCH_searchbybaby()
    {
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();        
        $this->load->database();
        $PDLY_SEARCH_typelistvalue= $this->input->post('PDLY_SEARCH_typelistvalue');
        $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_startdate');
        $PDLY_SEARCH_enddate= $this->input->post('PDLY_SEARCH_enddate');
        $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_babysearchoption');
        $PDLY_SEARCH_fromamount= $this->input->post('PDLY_SEARCH_fromamount');
        $PDLY_SEARCH_toamount= $this->input->post('PDLY_SEARCH_toamount');
        $PDLY_SEARCH_searchcomments= $this->input->post('PDLY_SEARCH_searchcomments');
        $PDLY_SEARCH_invitemcom= $this->input->post('PDLY_SEARCH_invitemcom');
        $PDLY_SEARCH_invfromcomt= $this->input->post('PDLY_SEARCH_invfromcomt');
        $PDLY_SEARCH_babycategory= $this->input->post('PDLY_SEARCH_babycategory');
        $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
        $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
        $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
        $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
        $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
        $data=$this->Mdl_personal_daily_entry_search_update_delete->PDLY_SEARCH_searchbybaby($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory,$timeZoneFormat);
        echo json_encode($data);
    }
    //EXPENSE BABY UPDATEFUNCTION
    public function expensebabyupdate(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $ebid= $this->input->post('rowid');
        $babycategory= $this->input->post('babycategory');
        $babycategory=$this->db->escape_like_str($babycategory);
        $babyinvdate= $this->input->post('babyinvdate');
        $babyinvdate=date('Y-m-d',strtotime($babyinvdate));
        $babyinamt= $this->input->post('babyinamt');
        $babyinfromt= $this->input->post('babyinfromt');
        $babyinfromt=$this->db->escape_like_str($babyinfromt);
        $babyinvitem= $this->input->post('babyinvitem');
        $babyinvitem=$this->db->escape_like_str($babyinvitem);
        $babycomment= $this->input->post('babycomment');
        $babycomment=$this->db->escape_like_str($babycomment);
        $result = $this->Mdl_personal_daily_entry_search_update_delete->expensebabyupdate($ebid,$babycategory,$babyinvdate,$babyinamt,$babyinfromt,$babyinvitem,$babycomment,$USERSTAMP) ;
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }
    //EXPENSE CAR UPDATEFUNCTION
    public function expensecarupdate(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $ecid= $this->input->post('rowid');
        $carcategory= $this->input->post('carcategory');
        $carcategory=$this->db->escape_like_str($carcategory);
        $carinvdate= $this->input->post('carinvdate');
        $carinvdate=date('Y-m-d',strtotime($carinvdate));
        $carinamt= $this->input->post('carinamt');
        $carinfromt= $this->input->post('carinfromt');
        $carinfromt=$this->db->escape_like_str($carinfromt);
        $carinvitem= $this->input->post('carinvitem');
        $carinvitem=$this->db->escape_like_str($carinvitem);
        $carcomment= $this->input->post('carcomment');
        $carcomment=$this->db->escape_like_str($carcomment);
        $result = $this->Mdl_personal_daily_entry_search_update_delete->expensecarupdate($ecid,$carcategory,$carinvdate,$carinamt,$carinfromt,$carinvitem,$carcomment,$USERSTAMP) ;
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }
    //EXPENSE PERSONAL UPDATEFUNCTION
    public function expensepersonalupdate(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $epid= $this->input->post('rowid');
        $personalcategory= $this->input->post('personalcategory');
        $personalcategory=$this->db->escape_like_str($personalcategory);
        $personalinvdate= $this->input->post('personalinvdate');
        $personalinvdate=date('Y-m-d',strtotime($personalinvdate));
        $personalinamt= $this->input->post('personalinamt');
        $personalinfromt= $this->input->post('personalinfromt');
        $personalinfromt=$this->db->escape_like_str($personalinfromt);
        $personalinvitem= $this->input->post('personalinvitem');
        $personalinvitem=$this->db->escape_like_str($personalinvitem);
        $personalcomment= $this->input->post('personalcomment');
        $personalcomment=$this->db->escape_like_str($personalcomment);
        $result = $this->Mdl_personal_daily_entry_search_update_delete->expensepersonalupdate($epid,$personalcategory,$personalinvdate,$personalinamt,$personalinfromt,$personalinvitem,$personalcomment,$USERSTAMP) ;
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }
    //EXPENSE CAR LOAN UPDATEFUNCTION
    public function expensecarloanupdate(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $eclid= $this->input->post('rowid');
        $eclpaiddate= $this->input->post('eclpaiddate');
        $eclpaiddate=date('Y-m-d',strtotime($eclpaiddate));
        $eclfromperiod= $this->input->post('eclfromperiod');
        $eclfromperiod=date('Y-m-d',strtotime($eclfromperiod));
        $ecltopaid= $this->input->post('ecltopaid');
        $ecltopaid=date('Y-m-d',strtotime($ecltopaid));
        $eclamount= $this->input->post('eclamount');
        $eclcomments= $this->input->post('eclcomments');
        $eclcomments=$this->db->escape_like_str($eclcomments);
        $result = $this->Mdl_personal_daily_entry_search_update_delete->expensecarloanupdate($eclid,$eclpaiddate,$eclfromperiod,$ecltopaid,$eclamount,$eclcomments,$USERSTAMP) ;
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }
    //DELETE OPTION
    public function deleteoption(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $PDLY_rowid= $this->input->post('PDLY_rowid');
        $startdate= $this->input->post('startdate');
        $startdate=date('Y-m-d',strtotime($startdate));
        $enddate= $this->input->post('enddate');
        $enddate=date('Y-m-d',strtotime($enddate));
        $PDLY_SEARCH_lb_typelistvalue= $this->input->post('PDLY_SEARCH_lb_typelistvalue');
        $PDLY_SEARCH_lb_babysearchoptionvalue= $this->input->post('PDLY_SEARCH_lb_babysearchoptionvalue');
        $result = $this->Mdl_personal_daily_entry_search_update_delete->deleteoption($PDLY_rowid,$startdate,$enddate,$PDLY_SEARCH_lb_typelistvalue,$PDLY_SEARCH_lb_babysearchoptionvalue,$USERSTAMP) ;
        echo ($result);
    }

}