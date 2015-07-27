<?php
//******************************************Unit Create Search Update********************************************//
//VER 0.04-SD:19/05/2015 ED:20/05/2015,did update part for unit search update without calendar updation BY RAJA
//VER 0.03-SD:18/05/2015 ED:19/05/2015,did the form design and validation for unit search update BY RAJA
//VER 0.02-SD:15/05/2015 ED:16/05/2015,did save part for unit creation without calendar creation BY RAJA
//VER 0.01-SD:13/05/2015 ED:15/05/2015,completed form design and validation for unit creation BY RAJA
//*******************************************************************************************************//
class Ctrl_Unit_Creation_Search_Update extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('UNIT/Mdl_unit_creation_search_update');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('UNIT/Vw_Unit_Creation_Search_Update');
    }
    public function Cal_service(){
        $this->load->library('Google');
        $this->load->model('EILIB/Mdl_eilib_calender');
        $cal= $this->Mdl_eilib_calender->createCalendarService();
        return $cal;
    }
    public function Initialdata(){
        $flag= $this->input->post('flag');
        $query=$this->Mdl_unit_creation_search_update->Initial_data($flag);
        echo json_encode($query);
    }
    public function Check_existinginput(){
        $source= $this->input->post('source');
        $chkinput= $this->input->post('chkinput');
        $query=$this->Mdl_unit_creation_search_update->Check_existing_input($source,$chkinput);
        echo json_encode($query);
    }
    public function Unitsaveprocess(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $calndr=$this->Cal_service();
        $UC_nonei= $this->input->post('UC_cb_nonEI');
        $UC_newroomtype = $this->input->post('UC_tb_newroomtype');
        $UC_newstamptype = $this->input->post('UC_tb_newstamptype');
        $UC_oldroomtype = $this->input->post('UC_lb_roomtype');
        $UC_oldstamptype = $this->input->post('UC_lb_stamptype');
        $query=$this->Mdl_unit_creation_search_update->Unit_saveprocess($UC_nonei,$UC_newroomtype,$UC_newstamptype,$UC_oldroomtype,$UC_oldstamptype,$USERSTAMP,$calndr);
        echo json_encode($query);
    }

    //--------------------------------------------UNIT SEARCH AND UPDATE FUNCTIONS---------------------------------------------//
    public function USU_Initialdata(){
        $query=$this->Mdl_unit_creation_search_update->Usu_initial_data();
        echo json_encode($query);
    }
    public function USU_Searchbyoption(){
        $option = $this->input->post('option');
        $USU_parentfunc_load = $this->input->post('USU_parentfunc_load');
        $USU_not_load_lb = $this->input->post('USU_not_load_lb');
        $resultquery=$this->Mdl_unit_creation_search_update->Usu_searchby_option($option,$USU_parentfunc_load,$USU_not_load_lb);
        echo json_encode($resultquery);
    }
    public function USU_AlreadyExists(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $inventory_unitno = $this->input->post('inventory_unitno');
        $typeofcard = $this->input->post('typeofcard');
        $flag_card_unitno = $this->input->post('flag_card_unitno');
        $USU_parent_func = $this->input->post('USU_parent_func');
        $resultquery=$this->Mdl_unit_creation_search_update->USU_already_exists($inventory_unitno,$typeofcard,$flag_card_unitno,$USU_parent_func,$USERSTAMP);
        echo json_encode($resultquery);
    }
    public function USU_flexttable(){
        $timeZoneFrmt= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $USU_all_searchby='';
        $USU_parent_updation='';
        $USU_unit_searchby = $this->input->post('USU_lb_searchby');
        $USU_dutyamt_fromamt = $this->input->post('USU_tb_dutyamt_fromamt');
        $USU_dutyamt_toamt = $this->input->post('USU_tb_dutyamt_toamt');
        $USU_payment_frmamt = $this->input->post('USU_tb_payment_fromamt');
        $USU_payment_toamt = $this->input->post('USU_tb_payment_toamt');
        $USU_frmdate = $this->input->post('USU_db_fromdate');
        $USU_enddate = $this->input->post('USU_db_todate');
        $USU_unino=$this->input->post('USU_lb_unitno');
        $USU_roomtype=$this->input->post('USU_lb_roomtyps');
        $USU_accesscard = $this->input->post('USU_lb_cardno');
        if($USU_unino!='SELECT' && $USU_unino!='' && $USU_unino!='null'){
            $USU_all_searchby=$USU_unino;
        }
        elseif($USU_roomtype!='SELECT' && $USU_roomtype!='' && $USU_roomtype!='null'){
            $USU_all_searchby=$USU_roomtype;
        }
        $resultquery=$this->Mdl_unit_creation_search_update->Usu_flext_table($USU_unit_searchby,$USU_dutyamt_fromamt,$USU_dutyamt_toamt,$USU_payment_frmamt,$USU_payment_toamt,$USU_frmdate,$USU_enddate,$USU_all_searchby,$USU_accesscard,$USU_parent_updation,$timeZoneFrmt,$USERSTAMP);
        echo json_encode($resultquery);
    }
    public function USU_roomstamp_unitno(){
        $USU_unitno=$this->input->post("unitstamp_unitno");
        $resquery=$this->Mdl_unit_creation_search_update->USU_roomstampunitno($USU_unitno);
        echo json_encode($resquery);
    }
    public function USU_func_update(){
        $timeZoneFrmt= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $USU_form_values=$this->input->post("USU_obj_formvalues");
        $USU_obj_rowvalue=$this->input->post("USU_obj_rowvalue");
        $USU_obj_flex=$this->input->post("USU_obj_flex");
        $USU_upd_selectoption_unit= $USU_form_values['USU_lb_selectoption_unit'];
        $calndr='';
        if (($USU_upd_selectoption_unit == 3) || ($USU_upd_selectoption_unit == 4) || ($USU_upd_selectoption_unit == 6) || ($USU_upd_selectoption_unit == 7)) {
            $calndr=$this->Cal_service();
        }
        $USU_upd_unitid_stampid = $USU_form_values['USU_radio_flex'];
        $USU_upd_startdate_update = $USU_form_values['USU_db_startdate_update'];
        $USU_upd_unitno = $USU_form_values['USU_tb_unitno'];
        $USU_upd_enddate_update = $USU_form_values['USU_db_enddate_update'];
        $USU_upd_unitdeposit = $USU_form_values['USU_tb_unitdeposit'];
        $USU_upd_obsolete = $USU_form_values['USU_hidden_obsolete'];
        $USU_upd_unitpayment = $USU_form_values['USU_tb_unitreltal'];
        $USU_upd_accnoid = $USU_form_values['USU_tb_accnoid'];
        $USU_upd_accname = $USU_form_values['USU_tb_accname'];
        $USU_upd_bankcodeid = $USU_form_values['USU_tb_bankcodeid'];
        $USU_upd_branchcode = $USU_form_values['USU_tb_branchcode'];
        $USU_upd_nonei = $USU_form_values['USU_cb_nonei'];
        $USU_upd_bankaddr = $USU_form_values['USU_tb_bankaddr'];
        $USU_upd_comments = $USU_form_values['USU_ta_comments'];
        $USU_upd_roomtype = $USU_form_values['USU_tb_sep_roomtype'];
        $USU_update_stamptype = $USU_form_values['USU_tb_sep_stamptype'];
        $USU_upd_lb_stamptype = $USU_form_values['USU_lb_stamptype'];
        $USU_upd_access = $USU_form_values['USU_tb_access'];
        $USU_upd_access_comments = $USU_form_values['USU_ta_accesscomment'];
        $USU_upd_accunitno = $USU_form_values['USU_tb_accunitno'];
        $USU_sep_upd_roomtype = $USU_form_values['USU_tb_sep_roomtype'];
        $USU_sep_update_stamptype = $USU_form_values['USU_tb_sep_stamptype'];
        $USU_upd_lost = $USU_form_values['USU_cb_lost'];
        $USU_upd_inventory = $USU_form_values['USU_cb_inventory'];
        $USU_update_lb_roomtype = $USU_form_values['USU_lb_roomtype'];
        $USU_upd_tb_stampamt = $USU_form_values['USU_tb_stampamt'];
        $USU_update_lb_stampdate = $USU_form_values['USU_db_stampdate'];
        $USU_upd_typeofcard = $USU_form_values['USU_typeofCard'];
        $USU_cb_inventory=$USU_form_values['USU_cb_inventory'];
        $USU_cb_lost=$USU_form_values['USU_cb_lost'];
        $USU_all_searchby='';
        $USU_unit_searchby = $USU_obj_flex['USU_lb_searchby'];
        $USU_dutyamt_fromamt = $USU_obj_flex['USU_tb_dutyamt_fromamt'];
        $USU_dutyamt_toamt = $USU_obj_flex['USU_tb_dutyamt_toamt'];
        $USU_payment_frmamt = $USU_obj_flex['USU_tb_payment_fromamt'];
        $USU_payment_toamt = $USU_obj_flex['USU_tb_payment_toamt'];
        $USU_frmdate = $USU_obj_flex['USU_db_fromdate'];
        $USU_enddate = $USU_obj_flex['USU_db_todate'];
        $USU_unino=$USU_obj_flex['USU_lb_unitno'];
        $USU_roomtype=$USU_obj_flex['USU_lb_roomtyps'];
        $USU_accesscard = $USU_obj_flex['USU_lb_cardno'];
        $USU_parent_updation = $USU_obj_flex['USU_parent_updation'];
        if($USU_parent_updation!=''){
            $USU_parent_updation=$USU_parent_updation;
        }
        else{
            $USU_parent_updation='';
        }
        if($USU_unino!='SELECT' && $USU_unino!=''){
            $USU_all_searchby=$USU_unino;
        }
        elseif($USU_roomtype!='SELECT' && $USU_roomtype!=''){
            $USU_all_searchby=$USU_roomtype;
        }
        $resltquery=$this->Mdl_unit_creation_search_update->USU_funcupdate($USU_upd_selectoption_unit,$USU_upd_unitid_stampid,$USU_upd_startdate_update
            ,$USU_upd_unitno,$USU_upd_enddate_update,$USU_upd_unitdeposit,$USU_upd_obsolete,$USU_upd_unitpayment,$USU_upd_accnoid,$USU_upd_accname
            ,$USU_upd_bankcodeid,$USU_upd_branchcode,$USU_upd_nonei,$USU_upd_bankaddr,$USU_upd_comments,$USU_upd_roomtype,$USU_update_stamptype
            ,$USU_upd_lb_stamptype,$USU_upd_access,$USU_upd_access_comments,$USU_upd_accunitno,$USU_sep_upd_roomtype,$USU_sep_update_stamptype
            ,$USU_upd_lost,$USU_upd_inventory,$USU_update_lb_roomtype,$USU_upd_tb_stampamt,$USU_update_lb_stampdate,$USU_upd_typeofcard,$USU_cb_inventory
            ,$USU_cb_lost,$USU_obj_rowvalue,$USU_unit_searchby,$USU_dutyamt_fromamt,$USU_dutyamt_toamt,$USU_payment_frmamt,$USU_payment_toamt,$USU_frmdate
            ,$USU_enddate,$USU_all_searchby,$USU_accesscard,$USU_parent_updation,$timeZoneFrmt,$USERSTAMP,$calndr);
        echo json_encode($resltquery);
    }
    public function USU_flexttablepdf(){
        $timeZoneFrmt= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->load->library('pdf');
        $USU_all_searchby='';
        $USU_parent_updation='';
        $USU_unit_searchby = $this->input->get('USU_lb_searchby');
        $USU_dutyamt_fromamt = $this->input->get('USU_tb_dutyamt_fromamt');
        $USU_dutyamt_toamt = $this->input->get('USU_tb_dutyamt_toamt');
        $USU_payment_frmamt = $this->input->get('USU_tb_payment_fromamt');
        $USU_payment_toamt = $this->input->get('USU_tb_payment_toamt');
        $USU_frmdate = $this->input->get('USU_db_fromdate');
        $USU_enddate = $this->input->get('USU_db_todate');
        $USU_unino=$this->input->get('USU_lb_unitno');
        $USU_roomtype=$this->input->get('USU_lb_roomtyps');
        $USU_accesscard = $this->input->get('USU_lb_cardno');
        $USU_typeofcard = $this->input->get('USU_lb_typeofcard');
        if($USU_unino!='SELECT' && $USU_unino!='' && $USU_unino!='null'){
            $USU_all_searchby=$USU_unino;
        }
        elseif($USU_roomtype!='SELECT' && $USU_roomtype!='' && $USU_roomtype!='null'){
            $USU_all_searchby=$USU_roomtype;
        }
        $pdfresult='';
        $pdfresult=$this->Mdl_unit_creation_search_update->Usu_flext_table_pdf($USU_unit_searchby,$USU_dutyamt_fromamt,$USU_dutyamt_toamt,$USU_payment_frmamt,$USU_payment_toamt,$USU_frmdate,$USU_enddate,$USU_all_searchby,$USU_accesscard,$USU_parent_updation,$timeZoneFrmt,$USERSTAMP);
        $pdfheader='';
        if($USU_unit_searchby==1){$pdfheader='ACCESS CARD DETAILS FOR THE '.$USU_typeofcard.' CARD: '.$USU_accesscard;}
        elseif($USU_unit_searchby==2){$pdfheader='STAMP DUTY AMOUNT DETAIL BETWEEN '.$USU_dutyamt_fromamt.' AND '.$USU_dutyamt_toamt;}
        elseif($USU_unit_searchby==3){$pdfheader='UNIT DETAILS - END DATE BETWEEN '.$USU_frmdate.' AND '.$USU_enddate;}
        elseif($USU_unit_searchby==4){$pdfheader='UNIT PAYMENT AMOUNT DETAIL BETWEEN '.$USU_payment_frmamt.' AND '.$USU_payment_toamt;}
        elseif($USU_unit_searchby==5){$pdfheader='LIST OF ROOM TYPE';}
        elseif($USU_unit_searchby==6){$pdfheader='UNIT DETAILS - START DATE BETWEEN '.$USU_frmdate.' AND '.$USU_enddate;}
        elseif($USU_unit_searchby==7){$pdfheader='UNIT DETAILS FOR THE UNIT NUMBER '.$USU_unino;}
        elseif($USU_unit_searchby==8){$pdfheader='LIST OF STAMP TYPE';}
        elseif($USU_unit_searchby==9){$pdfheader='ACCESS CARD DETAILS FOR THE ROOM TYPE: '.$USU_roomtype;}
        $pdf = $this->pdf->load();
        if($USU_unit_searchby==5 || $USU_unit_searchby==8){
            $pdf=new mPDF('utf-8','A4');
        }
        elseif($USU_unit_searchby==7){
            $pdf=new mPDF('utf-8',array(400,250));
        }
        else{
            $pdf=new mPDF('utf-8',array(380,200));
        }
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
    }
}