<?php
error_reporting(0);
Class Ctrl_Customer_Creation extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_creation');
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('EILIB/Mdl_eilib_quarter_calc');
    }
    public function Index()
    {
        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Creation');
    }
    public function Customer_Initaildatas()
    {
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $unit = $this->Mdl_eilib_common_function->getAllActiveUnits();
        $nationality = $this->Mdl_eilib_common_function->getNationality();
        $EmailList= $this->Mdl_eilib_common_function->getEmailId($formname);
        $Option= $this->Mdl_eilib_common_function->getOption();
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Timelist=$this->Mdl_eilib_common_function->getTimeList();
        $proratedlabel=$this->Mdl_eilib_common_function->CUST_getProratedWaivedValue();
        $Values=array($unit,$nationality,$EmailList,$Option,$ErrorMessage,$Timelist,$proratedlabel);
        echo json_encode($Values);
    }
    public function CustomerRoomTypeLoad()
    {
        $unit=$_REQUEST['Unit'];
        $RoomType=$this->Mdl_eilib_common_function->getUnitRoomType($unit);
        $UnitDates=$this->Mdl_eilib_common_function->getUnit_Start_EndDate($unit);
        $CustomerStartDate=$this->Mdl_eilib_common_function->getCustomerStartDate();
        $Values=array($RoomType,$UnitDates,$CustomerStartDate);
        echo json_encode($Values);
    }
    public function UnitCardNumbers()
    {
        $unit=$_REQUEST['Unit'];
        $CardNumbers=$this->Mdl_eilib_common_function->CUST_getunitCardNo($unit);
        echo json_encode($CardNumbers);
    }
    public function CustomerCreationSave()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->load->library('Google');
        $Startdate=$_POST['CCRE_Startdate'];
        $Enddate=$_POST['CCRE_Enddate'];
        $Leaseperiod=$this->Mdl_eilib_common_function->getLeasePeriod($Startdate,$Enddate);
        $Q_Startdate=date('Y-m-d',strtotime($Startdate));
        $Q_Enddate=date('Y-m-d',strtotime($Enddate));
        $Quoters=$this->Mdl_eilib_quarter_calc->quarterCalc(new DateTime($Q_Startdate),new DateTime($Q_Enddate));
        $Create_confirm=$this->Mdl_customer_creation->Customer_Creation_Save($UserStamp,$Leaseperiod,$Quoters);
        echo json_encode($Create_confirm);
    }

    public function Prorated_check()
    {
        $Startdate=$_POST['SD'];
        $Enddate=$_POST['ED'];
        $Prorated=$this->Mdl_eilib_common_function->CUST_chkProrated($Startdate,$Enddate);
        echo $Prorated;
    }
}