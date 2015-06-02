<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$UserStamp=$UserStamp;
Class Ctrl_Customer_Creation extends CI_Controller
{
    public function Index()
    {
        $this->load->view('CUSTOMER/Vw_Customer_Creation');
    }
    public function Customer_Initaildatas()
    {
        $this->load->model('Eilib/Common_function');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $unit = $this->Common_function->getAllActiveUnits();
        $nationality = $this->Common_function->getNationality();
        $EmailList= $this->Common_function->getEmailId($formname);
        $Option= $this->Common_function->getOption();
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $Timelist=$this->Common_function->getTimeList();
        $proratedlabel=$this->Common_function->CUST_getProratedWaivedValue();
        $Values=array($unit,$nationality,$EmailList,$Option,$ErrorMessage,$Timelist,$proratedlabel);
        echo json_encode($Values);
    }
    public function CustomerRoomTypeLoad()
    {
        $this->load->model('Eilib/Common_function');
        $unit=$_REQUEST['Unit'];
        $RoomType=$this->Common_function->getUnitRoomType($unit);
        $UnitDates=$this->Common_function->getUnit_Start_EndDate($unit);
        $CustomerStartDate=$this->Common_function->getCustomerStartDate();
        $Values=array($RoomType,$UnitDates,$CustomerStartDate);
        echo json_encode($Values);
    }
    public function UnitCardNumbers()
    {
        $this->load->model('Eilib/Common_function');
        $unit=$_REQUEST['Unit'];
        $CardNumbers=$this->Common_function->CUST_getunitCardNo($unit);
        echo json_encode($CardNumbers);
    }
    public function CustomerCreationSave()
    {
        global $UserStamp;
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->library('Google');
        $Startdate=$_POST['CCRE_Startdate'];
        $Enddate=$_POST['CCRE_Enddate'];
        $this->load->model('Eilib/Common_function');
        $Leaseperiod=$this->Common_function->getLeasePeriod($Startdate,$Enddate);
        $Quoters=$this->Common_function->quarterCalc(new DateTime(date('Y-m-d',strtotime($Startdate))), new DateTime(date('Y-m-d',strtotime($Enddate))));
        $service=$this->Common_function->get_service($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        $this->load->model('CUSTOMER/Mdl_customercreation');
        $Create_confirm=$this->Mdl_customercreation->Customer_Creation_Save($UserStamp,$Leaseperiod,$Quoters,$service);
        if($Create_confirm[0]==1)
        {
            $this->load->library('Google');
            $this->load->model('Eilib/Calender');
            $cal= $this->Calender->createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
            $this->Calender->CUST_customercalendercreation($cal,$Create_confirm[1],$Create_confirm[2],$Create_confirm[3],$Create_confirm[4],$Create_confirm[5],$Create_confirm[6],$Create_confirm[7],$Create_confirm[8],$Create_confirm[9],$Create_confirm[10],$Create_confirm[11],$Create_confirm[12],$Create_confirm[13],$Create_confirm[14],$Create_confirm[15],'');
             echo json_encode($Create_confirm[0]);
        }
        else
        {
            echo($Create_confirm[0]);
        }
    }

    public function Prorated_check()
    {
        $Startdate=$_POST['SD'];
        $Enddate=$_POST['ED'];
        $this->load->model('Eilib/Common_function');
        $Prorated=$this->Common_function->CUST_chkProrated($Startdate,$Enddate);
        echo $Prorated;
    }

}