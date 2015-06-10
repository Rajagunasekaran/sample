<?php
error_reporting(0);
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
Class Ctrl_Customer_Search_Update_Delete extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_search_update_delete');
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $this->load->model('EILIB/Mdl_eilib_quarter_calc');
    }
    public function Index()
    {
        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Search_Update_Delete');
    }
    public function CC_SRC_InitialDataLoad()
    {
        $SearchOption=$this->Mdl_customer_search_update_delete->getSearchOption();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $nationality = $this->Mdl_eilib_common_function->getNationality();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $units = $this->Mdl_eilib_common_function->getAllUnits();
        $Timelist=$this->Mdl_eilib_common_function->getTimeList();
        $formname=$_REQUEST['Formname'];
        $EmailList= $this->Mdl_eilib_common_function->getEmailId($formname);
        $Option= $this->Mdl_eilib_common_function->getOption();
        $proratedlabel=$this->Mdl_eilib_common_function->CUST_getProratedWaivedValue();
        $values=array($SearchOption,$nationality,$ErrorMessage,$units,$Timelist,$EmailList,$Option,$proratedlabel);
        echo json_encode($values);
    }
    public function CustomerName()
    {
        $Customername=$this->Mdl_customer_search_update_delete->getCustomernames();
        echo json_encode($Customername);
    }
    public function CustomerCompnameName()
    {
        $Customercompanyname=$this->Mdl_customer_search_update_delete->getCustomerCompanyNames();
        echo json_encode($Customercompanyname);
    }
    public function CustomerCardNos()
    {
        $CustomerCard=$this->Mdl_customer_search_update_delete->getCustomerCardNos();
        echo json_encode($CustomerCard);
    }
    public function AllUnits()
    {
        $units = $this->Mdl_eilib_common_function->getAllUnits();
        echo json_encode($units);
    }
    public function AllRoomtype()
    {
        $Roomtype = $this->Mdl_customer_search_update_delete->getAllRoomtypes();
        echo json_encode($Roomtype);
    }
    public function AllEmails()
    {
        $Email = $this->Mdl_customer_search_update_delete->getAllEmail();
        echo json_encode($Email);
    }
    public function AllEPNumbers()
    {
        $Epnumber = $this->Mdl_customer_search_update_delete->getAllEPnumbers();
        echo json_encode($Epnumber);
    }
    public function AllPassPortNumbers()
    {
        $Passport = $this->Mdl_customer_search_update_delete->getAllPassPortnumbers();
        echo json_encode($Passport);
    }
    public function AllMobileNumbers()
    {
        $Mobile = $this->Mdl_customer_search_update_delete->getAllMobileNumbers();
        echo json_encode($Mobile);
    }
    public function AllIntMobileNumbers()
    {
        $IntlMobile = $this->Mdl_customer_search_update_delete->getAllIntlMobileNumbers();
        echo json_encode($IntlMobile);
    }
    public function AllOfficeNumbers()
    {
        $OfficeMobile = $this->Mdl_customer_search_update_delete->getAllOfficeNumbers();
        echo json_encode($OfficeMobile);
    }
    public function AllComments()
    {
        $OfficeMobile = $this->Mdl_customer_search_update_delete->getAllComments();
        echo json_encode($OfficeMobile);
    }
    public function SearchDataResults()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $searchoption=$_POST['SearchOption'];
        $data1=$_POST['data1'];
        $data2=$_POST['data2'];
        $Resultset=$this->Mdl_customer_search_update_delete->getSearchResults($searchoption,$data1,$data2,$UserStamp,$timeZoneFormat);
        echo json_encode($Resultset);
    }
    public function SelectCustomerResults()
    {
        $customerid=$_POST['customerid'];
        $leaseperiod=$_POST['LP'];
        $unit=$_POST['Unit'];
        $RecverDetails=$this->Mdl_customer_search_update_delete->getSearchRecverdetails($unit,$customerid,$leaseperiod);
        $Resultset=$this->Mdl_customer_search_update_delete->SelectCustomerResults($customerid,$leaseperiod);
        $RoomType=$this->Mdl_eilib_common_function->getUnitRoomType($unit);
        $UnitDates=$this->Mdl_eilib_common_function->getUnit_Start_EndDate($unit);
        $unit = $this->Mdl_eilib_common_function->getAllActiveUnits();
        $CustomerStartDate=$this->Mdl_eilib_common_function->getCustomerStartDate();
        $ReturnValues=array($Resultset,$RoomType,$RecverDetails,$UnitDates,$unit,$CustomerStartDate);
        echo json_encode($ReturnValues);
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
    public function CustomerDetailsUpdate()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $Startdate=$_POST['CCRE_SRC_Startdate'];
        $Enddate=$_POST['CCRE_SRC_Enddate'];
        $Sendmailid = $_POST['CCRE_SRC_MailList'];
        $this->load->library('Google');
        $Leaseperiod=$this->Mdl_eilib_common_function->getLeasePeriod($Startdate,$Enddate);
        $Quoters=$this->Mdl_eilib_quarter_calc->quarterCalc(new DateTime(date('Y-m-d',strtotime($Startdate))), new DateTime(date('Y-m-d',strtotime($Enddate))));
        $Create_confirm=$this->Mdl_customer_search_update_delete->Customer_Search_Update($UserStamp,$Leaseperiod,$Quoters);
        $CCoption = $_POST['CCRE_SRC_Option'];
        if($Create_confirm[0]==1)
        {
            if($CCoption!=3)
            {
            $message1 = new Message();
            $message1->setSender($Create_confirm[3].'<'.$UserStamp.'>');
            $message1->addTo($Sendmailid);
            $message1->setSubject($Create_confirm[1]);
            $message1->setHtmlBody($Create_confirm[2]);
            $message1->send();
            }

        }
        print_r($Create_confirm[0]);
    }
    public function Prorated_check()
    {
        $Startdate=$_POST['SD'];
        $Enddate=$_POST['ED'];
        $Prorated=$this->Mdl_eilib_common_function->CUST_chkProrated($Startdate,$Enddate);
        echo $Prorated;
    }

}