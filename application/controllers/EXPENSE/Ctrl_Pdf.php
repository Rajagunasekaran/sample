<?php
class Ctrl_Pdf extends CI_Controller{

    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function pdfexport()
    {
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $this->load->library('pdf');
        $data='';
        $PDLY_SEARCH_lb_babysearchoptionmatch= $this->input->post('PDLY_SEARCH_lb_babysearchoption');
        $PDLY_SEARCH_lbl_flextableheader=$this->input->post('PDLY_SEARCH_hdn_flextableheader');
        $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
        $PDLY_SEARCH_hdn_expensetype=$this->input->post('PDLY_SEARCH_hdn_expensetype');
        if(($PDLY_SEARCH_lb_babysearchoptionmatch==56)||($PDLY_SEARCH_lb_babysearchoptionmatch==62)||($PDLY_SEARCH_lb_babysearchoptionmatch==73)||($PDLY_SEARCH_lb_babysearchoptionmatch==67))
        {
            $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments=$this->input->post('PDLY_SEARCH_tb_searchabycmt');
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory="";
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $this->load->model('EXPENSE/Mdl_pdf');
            $data=$this->Mdl_pdf->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory,$timeZoneFormat);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==52)||($PDLY_SEARCH_lb_babysearchoptionmatch==58)||($PDLY_SEARCH_lb_babysearchoptionmatch==69))
        {
              $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory=$this->input->post('PDLY_SEARCH_lb_babyexpansecategory');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $this->load->model('EXPENSE/Mdl_pdf');
            $data=$this->Mdl_pdf->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory,$timeZoneFormat);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==51)||($PDLY_SEARCH_lb_babysearchoptionmatch==57)||($PDLY_SEARCH_lb_babysearchoptionmatch==68)||($PDLY_SEARCH_lb_babysearchoptionmatch==65))
        {
            $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount=$this->input->post('PDLY_SEARCH_tb_fromamount');
            $PDLY_SEARCH_toamount=$this->input->post('PDLY_SEARCH_tb_toamount');;
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory="";
            $this->load->model('EXPENSE/Mdl_pdf');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $data=$this->Mdl_pdf->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory,$timeZoneFormat);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==53)||($PDLY_SEARCH_lb_babysearchoptionmatch==59)||($PDLY_SEARCH_lb_babysearchoptionmatch==70)||($PDLY_SEARCH_lb_babysearchoptionmatch==63)||($PDLY_SEARCH_lb_babysearchoptionmatch==66)||($PDLY_SEARCH_lb_babysearchoptionmatch==64))
        {
           $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory="";
            $this->load->model('EXPENSE/Mdl_pdf');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $data=$this->Mdl_pdf->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory,$timeZoneFormat);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==55)||($PDLY_SEARCH_lb_babysearchoptionmatch==61)||($PDLY_SEARCH_lb_babysearchoptionmatch==72))
        {
            $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom="";
            $PDLY_SEARCH_invfromcomt=$this->input->post('PDLY_SEARCH_tb_searchbyinvfrom');
            $PDLY_SEARCH_babycategory="";
            $this->load->model('EXPENSE/Mdl_pdf');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $data=$this->Mdl_pdf->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory,$timeZoneFormat);

        }
        else if(($PDLY_SEARCH_lb_babysearchoptionmatch==54)||($PDLY_SEARCH_lb_babysearchoptionmatch==60)||($PDLY_SEARCH_lb_babysearchoptionmatch==71))
        {
            $PDLY_SEARCH_typelistvalue=$this->input->post('PDLY_SEARCH_lb_typelist');
            $PDLY_SEARCH_startdate=$this->input->post('PDLY_SEARCH_db_startdate');
            $PDLY_SEARCH_enddate=$this->input->post('PDLY_SEARCH_db_enddate');
            $PDLY_SEARCH_searchcomments="";
            $PDLY_SEARCH_fromamount="";
            $PDLY_SEARCH_toamount="";
            $PDLY_SEARCH_babysearchoption=$this->input->post('PDLY_SEARCH_lb_babysearchoption');
            $PDLY_SEARCH_invitemcom=$this->input->post('PDLY_SEARCH_tb_searchbyinvitem');
            $PDLY_SEARCH_invfromcomt="";
            $PDLY_SEARCH_babycategory="";
            $this->load->model('EXPENSE/Mdl_pdf');
            $PDLY_SEARCH_startdate=date('Y-m-d',strtotime($PDLY_SEARCH_startdate));
            $PDLY_SEARCH_enddate=date('Y-m-d',strtotime($PDLY_SEARCH_enddate));
            $PDLY_SEARCH_searchcomments=$this->db->escape_like_str($PDLY_SEARCH_searchcomments);
            $PDLY_SEARCH_invitemcom=$this->db->escape_like_str($PDLY_SEARCH_invitemcom);
            $PDLY_SEARCH_invfromcomt=$this->db->escape_like_str($PDLY_SEARCH_invfromcomt);
            $data=$this->Mdl_pdf->Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory,$timeZoneFormat);

        }

        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.'EXPENSE'.' '.$PDLY_SEARCH_hdn_expensetype.'-'.$PDLY_SEARCH_lbl_flextableheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>'); // Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
        $pdf->WriteHTML($data); // write the HTML into the PDF
        $pdf->Output('EXPENSE'.' '.$PDLY_SEARCH_hdn_expensetype.'-'.$PDLY_SEARCH_lbl_flextableheader.'.pdf', 'd');

    }
    public function pdfexportbizexpense(){
        $this->load->library('pdf');
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $this->load->database();
        $BDLY_SRC_expensetype=$this->input->post('expensetypetext');
        $BDLY_SRC_lb_unitno=$this->input->post('BDLY_SRC_lb_unitno');
        $BDLY_SRC_lb_invoiceto=$this->input->post('BDLY_SRC_lb_invoiceto');
        $BDLY_SRC_comments=$this->input->post('BDLY_SRC_comments');
        $BDLY_SRC_tb_fromamnt=$this->input->post('BDLY_SRC_tb_fromamnt');
        $BDLY_SRC_tb_toamnt=$this->input->post('BDLY_SRC_tb_toamnt');
        $BDLY_SRC_servicedue=$this->input->post('BDLY_SRC_servicedue');
        $BDLY_SRC_lb_cleanername=$this->input->post('BDLY_SRC_lb_cleanername');
        $BDLY_SRC_tb_durationamt=$this->input->post('BDLY_SRC_tb_durationamt');
        $BDLY_SRC_startdate=$this->input->post('startdate');
        $BDLY_SRC_enddate=$this->input->post('enddate');
        $BDLY_SRC_invoicefrom=$this->input->post('BDLY_SRC_invoicefrom');
        $BDLY_SRC_lb_accountno=$this->input->post('BDLY_SRC_lb_accountno');
        $BDLY_SRC_lb_cusname=$this->input->post('BDLY_SRC_lb_cusname');
        $BDLY_SRC_lb_Digvoiceno=$this->input->post('BDLY_SRC_lb_Digvoiceno');
        $BDLY_SRC_lb_cardno=$this->input->post('BDLY_SRC_lb_cardno');
        $BDLY_SRC_lb_carno=$this->input->post('BDLY_SRC_lb_carno');
        $BDLY_SRC_lb_serviceby=$this->input->post('BDLY_SRC_lb_serviceby');
        $BDLY_SRC_invoiceitem=$this->input->post('BDLY_SRC_invoiceitem');
        $BDLY_SRC_lb_category=$this->input->post('BDLY_SRC_lb_category');
        $pdfheader=$this->input->post('pdfheader');
        $this->load->model('EXPENSE/Mdl_pdf');
        $data=$this->Mdl_pdf->BDLY_SRC_getAnyTypeExpData($USERSTAMP,$timeZoneFormat,$BDLY_SRC_lb_unitno,$BDLY_SRC_lb_invoiceto,$BDLY_SRC_comments,$BDLY_SRC_comments,$BDLY_SRC_tb_fromamnt,$BDLY_SRC_tb_toamnt,$BDLY_SRC_servicedue,$BDLY_SRC_lb_cleanername,$BDLY_SRC_tb_durationamt,$BDLY_SRC_startdate,$BDLY_SRC_enddate,$BDLY_SRC_invoicefrom,$BDLY_SRC_lb_accountno,$BDLY_SRC_lb_cusname,$BDLY_SRC_lb_Digvoiceno,$BDLY_SRC_lb_cardno,$BDLY_SRC_lb_carno,$BDLY_SRC_lb_serviceby,$BDLY_SRC_invoiceitem,$BDLY_SRC_lb_category);
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.'BIZ DAILY'.' '.$BDLY_SRC_expensetype.'-'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>'); // Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
        $pdf->WriteHTML($data); // write the HTML into the PDF
        $pdf->Output('BIZ DAILY'.' '.$BDLY_SRC_expensetype.'-'.$pdfheader.'.pdf', 'd');
    }
    public function pdfexportbizdetailexpense(){
        $this->load->library('pdf');
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $this->load->database();
        $Expensetype=$this->input->get('Expensetype');
        $expensetypetext=$this->input->get('expensetypetext');
        $BTDTL_SEARCH_lb_searchoptions=$this->input->get('BTDTL_SEARCH_lb_searchoptions');
        $searchvalue=$this->input->get('searchvalue');
        $startdate=$this->input->get('startdate');
        $labelheadername=$this->input->get('labelheadername');
        $BTDTL_SEARCH_parentfunc_flex=$this->input->get('BTDTL_SEARCH_parentfunc_flex');
        if($Expensetype==16)
        {
            $this->load->model('EXPENSE/Mdl_pdf');
            $data=$this->Mdl_pdf->BTDTL_SEARCH_flex_aircon($searchvalue,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat);
        }
        if($Expensetype==17)
        {
            $this->load->model('EXPENSE/Mdl_pdf');
            $data=$this->Mdl_pdf->BTDTL_SEARCH_show_carpark($searchvalue,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat);
        }
        if($Expensetype==15)
        {
            $this->load->model('EXPENSE/Mdl_pdf');
            $data=$this->Mdl_pdf->BTDTL_SEARCH_show_digital($searchvalue,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat);
        }
        if($Expensetype==13)
        {
            $this->load->model('EXPENSE/Mdl_pdf');
            $data=$this->Mdl_pdf->BTDTL_SEARCH_show_electricity($searchvalue,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat);
        }
        if($Expensetype==14)
        {
            $this->load->model('EXPENSE/Mdl_pdf');
            $data=$this->Mdl_pdf->BTDTL_SEARCH_show_starhub($startdate,$searchvalue,$BTDTL_SEARCH_lb_searchoptions,$BTDTL_SEARCH_parentfunc_flex,$timeZoneFormat);
        }
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.'BIZ DETAIL'.' '.$expensetypetext.'-'.$labelheadername.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>'); // Add a footer for good measure <img src="https://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
        $pdf->WriteHTML($data); // write the HTML into the PDF
        $pdf->Output('BIZ DETAIL'.' '.$expensetypetext.'-'.$labelheadername.'.pdf', 'd');
    }
}

