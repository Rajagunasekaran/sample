<?php
class Ctrl_Ocbc_Model_Entry_Search_Update extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/OCBC/Mdl_ocbc_model_entry_search_update');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index()
    {
        $this->load->view('FINANCE/OCBC/Vw_Ocbc_Model_Entry_Search_Update');
    }
    public function Model_initialdatas()
    {
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Allmodels=$this->Mdl_eilib_common_function->getBankTransferModels();
        $AllmodelDetails=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
        $values=array($ErrorMessage,$Allmodels,$AllmodelDetails);
        echo json_encode($values);
    }
    public function ModelnameUpdate()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $modelname=$_POST['Data'];
        $Rowid=$_POST['Rowid'];
        $Option=$_POST['Option'];
        $Confirmmessage=$this->Mdl_ocbc_model_entry_search_update->ModelnameUpdation($UserStamp,$modelname,$Rowid,$Option);
        $Allmodels=$this->Mdl_eilib_common_function->getBankTransferModels();
        $Allmodelsdetails=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
        $returnvalue=array($Allmodels,$Allmodelsdetails);
        echo json_encode($returnvalue);
    }
    public function ModelnameDelete()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $Rowid=$_POST['Data'];
        $Confirm_message=$this->Mdl_ocbc_model_entry_search_update->ModelnameDeletion($UserStamp,$Rowid);
        if($Confirm_message!='UPDATED')
        {
            $Allmodels=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
            $Create_confirm=$this->Mdl_eilib_common_function->DeleteRecord(73,$Rowid,$UserStamp);
        }
        else
        {
            $Allmodels=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
        }
        $values=array($Allmodels,$Confirm_message);
        echo json_encode($values);
    }
    public function ModelnameInsert()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $modelname=$_POST['Data'];
        $Confirm_message=$this->Mdl_ocbc_model_entry_search_update->NewModelnameInsert($UserStamp,$modelname);
        $Allmodels=$this->Mdl_ocbc_model_entry_search_update->getAllModels_Details($timeZoneFormat);
        $Values=array($Confirm_message,$Allmodels);
        echo json_encode($Values);
    }
    public function ModelPdfCreation()
    {
        $header=$_GET['Header'];
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $AllmodelDetails=$this->Mdl_ocbc_model_entry_search_update->PDF_AllModels_Details($timeZoneFormat);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf=new mPDF('utf-8','A4');
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$header.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($AllmodelDetails);
        $pdf->Output($header.'.pdf', 'D');
    }
}