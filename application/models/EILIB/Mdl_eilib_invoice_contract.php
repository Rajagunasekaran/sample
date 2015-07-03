<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-021
 * Date: 18/5/15
 * Time: 7:54 PM
 */
//******************************************INVOICE AND CONTRACT********************************************//
//DONE BY:SARADAMBAL
//VER 7.1-SD:06-06-2015 ED:06-06-2015,CHANGES IN RETURN VALUES FOR INVOICE AND CONTRACT
//VER 5.5-SD:03/06/2015 ED:03/06/2015,CHANGED FILE NAME AND UPDATED URL FOR CONTRACT
//VER 0.01-SD:22/05/2015 ED:06/02/2015,COMPLETED INVOICE AND CONTRACT
//*******************************************************************************************************//
//include "./application/controllers/GET_USERSTAMP.php";
//require_once 'google/appengine/api/mail/Message.php';
//use \google\appengine\api\mail\Message;
class Mdl_eilib_invoice_contract extends CI_Model{
//COMMON FUNCTION TO CREATE CALENDAR ID
    public function createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token){
//create start event
        $drive = new Google_Client();
        $drive->setClientId($ClientId);
        $drive->setClientSecret($ClientSecret);
        $drive->setRedirectUri($RedirectUri);
        $drive->setScopes(array($DriveScopes,$CalenderScopes));
        $drive->setAccessType('online');
        $authUrl = $drive->createAuthUrl();
        $access_token=$drive->getAccessToken();
        $refresh_token=$Refresh_Token;
        $drive->refreshToken($refresh_token);
        $service = new Google_Service_Drive($drive);
        return $service;
    }
//SET DOC OWNER FUNCTIONS
    public function SetDocOwner($service,$docid,$docowner,$semailid)
    {
        $editorfile= $this->URSRC_GetAllEditors($service,$docid);
        for($j=0;$j<count($editorfile);$j++)
        {
            if($editorfile[$j]=="")continue;
            if($editorfile[$j]!=$semailid)
            {
                try {
                    $this->URSRC_RemoveEditor($service,$docid,$editorfile[$j]);
                } catch (Exception $e) {
                    echo  $e->getMessage();
                }
            }
        }
        if($docowner!=$semailid)
        {
            try {
                $this->URSRC_AddEditor($service,$docid,$semailid);
            } catch (Exception $e) {
                echo  $e->getMessage();

            }
        }
        try{
            $this->SetDocOwnerGivenId($service,$docid,$docowner);

        }
        catch(Exception $e){
            echo  $e->getMessage();

        }
    }
//SET THE DOC OWNER
    public   function CUST_SetDocOwner($service,$docid,$docowner,$semailid)
    {
        $editorfile= $this->URSRC_GetAllEditors($service,$docid);
        for($j=0;$j<count($editorfile);$j++)
        {
            if($editorfile[$j]=="")continue;
            if($editorfile[$j]!=$semailid)
            {
                try {
                    $this->URSRC_RemoveEditor($service,$docid,$editorfile[$j]);
                } catch (Exception $e) {
                }
            }
        }
        if($docowner!=$semailid)
        {
            try {
                $this->URSRC_AddEditor($service,$docid,$semailid);
            } catch (Exception $e) {
            }
        }
        $this-> SetDocOwnerGivenId($service,$docid,$docowner);
    }
//FUNCTION TO REMOVE EDITORS IF SESSION ID NOT OWNER OR EDITOR
    public function RemoveEditors($service,$docid,$email_fetch,$docowner,$UserStamp)
    {
        $this-> SetDocOwnerGivenId($service,$docid,$docowner);
        if(($email_fetch!=$UserStamp)&&($docowner!=$UserStamp))
        {
            try {
                $this->URSRC_RemoveEditor($service,$docid,$email_fetch);
            } catch (Exception $e) {
            }
        }
    }
//***********UNSHARE FILE**********************/
    public  function CUST_UNSHARE_FILE($service,$fileid)
    {
        $editorfile= $this->URSRC_GetAllEditors($service,$fileid);
        for($j=0;$j<count($editorfile);$j++)
        {
            if($editorfile[$j]=="")continue;
            try {
                $this->URSRC_RemoveEditor($service,$fileid,$editorfile[$j]);
            } catch (Exception $e) {
            }
        }
        try {
            $service->files->trash($fileid);
        } catch (Exception $e) {
        }
    }
//GET ALL EDITORS
    public function URSRC_GetAllEditors($service,$fileid){
        try {
            $permission_id=array();
            $emailadrress=array();
            $role_array=array();
            $permissions = $service->permissions->listPermissions($fileid);
            $return_value= $permissions->getItems();
            foreach ($return_value as $key => $value) {
                $permission_id[]=$value->id;
                $emailadrress[]=$value->emailAddress;
                $role_array[]=$value->role;
            }
        } catch (Exception $e) {
            $emailadrress=array();
        }
        return $emailadrress;
    }
//GET TEMPLATE FOLDER ID
    public  function getTemplatesFolderId()
    {
        $this->db->select("FP_FOLDER_ID");
        $this->db->from('FILE_PROFILE');
        $this->db->where('FP_ID=1');
        return $this->db->get()->row()->FP_FOLDER_ID;
    }
//FUNCTION TO CALCULATE PRORATED RENT
    public function proratedmonthcalculation($startDate, $endDate)
    {
        $return =[];
        $end =[];
        $start = $startDate;
        $i=0;
        if (strtotime($startDate) <= strtotime($endDate))
        {
            while (strtotime($start) <= strtotime($endDate))
            {
                $start = date('Y-m-d', strtotime($startDate.'+'.$i.' days'));
                if($i==0)
                    $return[] = $start;
                else if(date('Y-m-d', strtotime($startDate.'+'.$i.' days'))==date('Y-m-01', strtotime($startDate.'+'.$i.' days'))&& date('Y-m-d', strtotime($startDate.'+'.$i.' days'))<= date('Y-m-d', strtotime($endDate)))
                    $return[] = $start;
                if( date('Y-m-d', strtotime($startDate.'+'.$i.' days'))==date('Y-m-t',strtotime($startDate.'+'.$i.' days'))	)
                    $end[] = $start;
                else if( date('Y-m-d', strtotime($startDate.'+'.$i.' days'))==date('Y-m-d',strtotime($endDate))	){
                    $end[] = $endDate;
                    break;}
                $i++;
            }
        }
        return [$return,$end];
    }
    public  function proratedmonthcalculation1($startdate,$enddate) {
        $startdateString = strtotime ($startdate);
        $enddateString = strtotime ($enddate);
        $s_day=date("d", $startdateString);
        $s_month=date("m", $startdateString);
        $s_year=date("Y", $startdateString);
        $e_day=date("d", $enddateString);
        $e_month=date("m", $enddateString);
        $e_year=date("Y", $enddateString);
        $startdate_oneMonth=strtotime($startdate);
        $startdate_oneMonth = strtotime ("+1 month",$startdate_oneMonth);
        $newstartdate= date("Y-m-d",$startdate_oneMonth);
        $startdate_array=[];
        $enddate_array=[];
        if(($e_month!=$s_month)||($e_year!=$s_year))
        {
            $startdates=$startdate;
            for($i=0;$i<100;$i++)
            {
                $dateStringCheckin=strtotime($startdate);
                $startdate_oneMonth = strtotime ("+".$i." month",$dateStringCheckin);
                $startdates= date("Y-m-d",$startdate_oneMonth);
                if($startdates<=$enddate)
                {
                    if($s_day!=1 && $i==0)
                    {
                        $startdate_array[]= date("Y-m-d",strtotime($startdate));
                    }else{$startdate_array[]=$startdates;}
                    $monthenddate = strtotime ("+".($i+1)." month",$dateStringCheckin);
                    $monthenddate= date("Y-m-d",$monthenddate);
                    $month_enddateString=strtotime($monthenddate);
                    $startdate_oneDay = strtotime ("-1 day",$month_enddateString);
                    $month_enddate= date("Y-m-d",$startdate_oneDay);
                    if($e_month!=date("m", strtotime($month_enddate)) || $e_year!=date("Y", strtotime($month_enddate)))
                    {
                        $MonthMinusDay = strtotime ("-1 day",strtotime($monthenddate));
                        $month_enddate= date("Y-m-d",$startdate_oneDay);
                        $date = new DateTime();
                        $date->setDate($s_year,(intval($s_month)+$i+1),date("d", strtotime($MonthMinusDay)));
                        $enddate_array[]=$date->format('Y-m-d') ;
                    }
                    else{$enddate_array[]=$enddate;}
                }
                else
                {
                    break;
                }
            }
        }
        else
        {
            $startdate_array[] =date("Y-m-d",strtotime($startdate));
            $enddate_array[] =date("Y-m-d",strtotime($enddate));
        }
        $return_array=[$startdate_array,$enddate_array];
        return $return_array;
    }
//FUNCTION TO CALCULATE NON PRORATED RENT
    public function nonproratedmonthcalculation($startDate, $endDate)
    {
        $return =[];
        $end =[];
        $start = $startDate;
        $i=0;
        $minusDay='';
        if (strtotime($startDate) <= strtotime($endDate))
        {
            while (strtotime($start) <= strtotime($endDate))
            {
                $start = date('Y-m-d', strtotime($startDate.'+'.$i.' days'));
                if($i==0){
                    $return[] = date('Y-m-d', strtotime($startDate));
                    $minusDay=date('Y-m-d',(strtotime('next month',strtotime($startDate))));
                    $end[]=date('Y-m-d', strtotime($minusDay.'-1'.' days'));
                }
                else if(strtotime($endDate)>=strtotime($minusDay) && date('Y-m-d', strtotime($start))==date('Y-m-'.date('d',strtotime($minusDay)), strtotime($start))){
                    $return []= date('Y-m-d', strtotime($minusDay));
                    $minusDay=date('Y-m-d',(strtotime('next month',strtotime($minusDay))));
                    if(strtotime($minusDay)<=strtotime($endDate))
                        $end[]=date('Y-m-d', strtotime($minusDay.'-1'.' days'));
                    else
                        $end[]=date('Y-m-d', strtotime($endDate));
                }
                $i++;
            }
        }
        return [$return,$end];
    }
    public  function nonproratedmonthcalculation1($startdate,$enddate)
    {
        $startdateString = strtotime ($startdate);
        $enddateString = strtotime ($enddate);
        $s_day=date("d", $startdateString);
        $s_month=date("m", $startdateString);
        $s_year=date("Y", $startdateString);
        $e_day=date("d", $enddateString);
        $e_month=date("m", $enddateString);
        $e_year=date("Y", $enddateString);
        $dateStringCheckin=strtotime($startdate);
        $startdate_oneMonth = strtotime ("+1 month",$dateStringCheckin);
        $newstartdate= date("Y-m-d",$startdate_oneMonth);
        $startdate_array=[];
        $enddate_array=[];
        $startdates=$startdate;
        for($i=0;$i<100;$i++)
        {
            $dateStringCheckin=strtotime($startdate);
            $startdate_oneMonth = strtotime ("+".$i." month",$dateStringCheckin);
            $startdates= date("Y-m-d",$startdate_oneMonth);
            if($startdates<=$enddate)
            {
                if($s_day!=1 && $i==0)
                {
                    $startdate_array[]=date("Y-m-d", strtotime($startdate));
                }
                else
                {
                    $startdate_array[]=$startdates;
                }
                $dateStringCheckin=strtotime($startdate);
                $startdate_oneMonth = strtotime ("+".(intval($i))." month",$dateStringCheckin);
                $monthenddate= date("Y-m-d",$startdate_oneMonth);
                if($monthenddate<$enddate)
                {
                    $MonthMinusDay = strtotime ("-1 day",strtotime($monthenddate));
                    $date = new DateTime();
                    $date->setDate($s_year,(intval($s_month)+$i),date("d", strtotime($MonthMinusDay)));
                    $enddate_array[]=$date->format('Y-m-d') ;
                }
                else
                {
                    $enddate_array[]=$enddate;
                }
            }
            else
            {
                break;
            }
        }
        $return_array=[$startdate_array,$enddate_array];
        return $return_array;
    }
//FUNCTION TO REMOVE EDITORS FOR INVOICE N CONTRACT
    public function InvAndConRemoveEditors($service,$invdocid,$contdocid,$email_fetch,$docowner,$UserStamp)
    {
        $this->SetDocOwnerGivenId($service,$invdocid,$docowner);
        $this->SetDocOwnerGivenId($service,$contdocid,$docowner);
        if(($email_fetch!=$UserStamp)&&($docowner!=$UserStamp))
        {
            $URSRC_sharedocflag=$this->URSRC_RemoveEditor($service,$invdocid,$email_fetch);
            $URSRC_sharedocflag=$this->URSRC_RemoveEditor($service,$contdocid,$email_fetch);
        }
    }
//REMOVE EDITORS
    public  function URSRC_RemoveEditor($service,$fileid,$URSRC_loginid){
        $URSRC_sharedocflag='';
        try {
            $permissions = $service->permissions->listPermissions($fileid);
            $return_value= $permissions->getItems();
            $permission_id='';
            foreach ($return_value as $key => $value) {
                if ($value->emailAddress==$URSRC_loginid) {
                    $permission_id=$value->id;
                }
            }
            if($permission_id!=''){
                try {
                    $service->permissions->delete($fileid, $permission_id);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
            $URSRC_sharedocflag=1;
        } catch (Exception $e) {
            $URSRC_sharedocflag=0;
        }
        return $URSRC_sharedocflag;
    }
//ADD EDITORS
    public  function URSRC_AddEditor($service,$fileid,$URSRC_loginid){
        $value=$URSRC_loginid;
        $type='user';
        $role='writer';
        $email=$URSRC_loginid;
        $newPermission = new Google_Service_Drive_Permission();
        $newPermission->setValue($value);
        $newPermission->setType($type);
        $newPermission->setRole($role);
        $newPermission->setEmailAddress($email);
        try {
            $service->permissions->insert($fileid, $newPermission);
        } catch (Exception $e) {
        }
    }
//GET ALL FILES FROM FOLDER
    public function URSRC_GetAllFiles($service,$folderid){
        $children1 = $service->children->listChildren($folderid);
        $filearray1=$children1->getItems();
        $emp_uploadfilenamelist=array();
        foreach ($filearray1 as $child1) {
            $emp_uploadfilenamelist[]=($child1->getId());
        }
        return $emp_uploadfilenamelist;
    }

    public  function insertFile($service, $title, $description, $parentId, $mimeType, $filedata) {
        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($title);
        $file->setDescription($description);
        $file->setMimeType($mimeType);
        // Set the parent folder.
        if ($parentId != null) {
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
        }
        try {
            $createdFile = $service->files->insert($file, array(
                'data' =>$filedata,
                'mimeType' =>'application/vnd.openxmlformats-officedocument.wordprocessingml.document',//$mimeType,
                'uploadType'=>'media'
            ));
            return $createdFile->getId();//$createdFile->getId();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function printFile($service, $fileId,$parentId,$title) {
        try {
            $file = $service->files->get($fileId);
            $description=$file->getDescription();
            $mimeType=$file->getMimeType();
            $filecontent=$this->downloadFile($service, $file);
            $newfile=$this->insertFile($service, $title, $description, $parentId, $mimeType, $filecontent);
            return $newfile;
        } catch (Exception $e) {
            return 0;
        }
    }
    public function downloadFile($service, $file) {
        $downloadUrl = $file->getExportLinks()['application/vnd.openxmlformats-officedocument.wordprocessingml.document'];//$file->getDownloadUrl();
        if ($downloadUrl) {
            $request = new Google_Http_Request($downloadUrl, 'GET', null, null);
            $httpRequest = $service->getClient()->getAuth()->authenticatedRequest($request);
            if ($httpRequest->getResponseHttpCode() == 200) {
                return $httpRequest->getResponseBody();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
//CUSTOMER CONTRACT
    public   function CUST_contract($service,$unitno,$checkindate,$checkoutdate,$companyname,$customername,$noticeperiod,$passportno,$passportdate,$epno,$epdate,$noticedate,$lp,$cardno,$rent,$airquartfee,$airfixedfee,$electcap,$dryclean,$chkoutfee,$procfee,$deposit,$waived,$roomtype,$rent_check,$formname,$sendmailid,$docowner,$parentId) {
        try {$ntc_date1='';$DEPOSITword='';            $response='';$newfile='';
            $todaydatestring =  date("d-M-Y");$flagProratedRentCkout=0;
            $flag_paraAlign='';$flag_paraAlign_sec=''; $flag_paraAlign_thrd=''; $flag_paraAlign_four=''; $flag_paraAlign_five='';$noepcontlineno='';
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $this->load->model('EILIB/Mdl_eilib_currency_to_word');
            $this->load->model('EILIB/Mdl_eilib_prorated_calc');
            $fileid= $this->Mdl_eilib_common_function->CUST_FileId_invoiceTem();
            $url= $this->Mdl_eilib_common_function->getUrlAccessGasScript();
            $cust_config_array=$this->CUST_invoice_contractreplacetext();
            if($deposit!='null' )
                $DEPOSITword=$this->Mdl_eilib_currency_to_word->currency_To_Word($deposit);
            $webloginfetch=$this->Mdl_eilib_common_function->CUST_GetLogindtls($unitno);
            $cust_config_array_concate=$cust_config_array[0];
            for($s=1;$s<count($cust_config_array);$s++){
                $cust_config_array_concate.='^~^'.$cust_config_array[$s];
            }
            $rentstring = $rent;//.toString();
            if($rentstring!='null' )
                $RENTword= $this->Mdl_eilib_currency_to_word->currency_To_Word($rentstring);
            $quartaircon_fetch=$airquartfee;
            $fixedaircon_fetch=$airfixedfee;
            $electricity=$electcap;
            if($electricity=='null')
            {
                $elec_fetch="00.00";
            }
            else
            {
                $elec_fetch=$electricity;
            }
            $dryclean=$dryclean;
            if($dryclean=='null')
            {
                $dryclean_fetch="00.00";
            }
            else
            {
                $dryclean_fetch=$dryclean;
            }
            $checkout=$chkoutfee;
            if($checkout=='null')
            {
                $checkoutfee_fetch="00.00";
            }
            else
            {
                $checkoutfee_fetch=$checkout;
            }
            if($procfee =='null')
            {
                $PROCESSno="00.00";
                $PROCESSword = "  ";
            }
            else
            {
                $PROCESSno= $procfee;
                $prostring =  $PROCESSno;//.toString();
                $PROCESSword= $this->Mdl_eilib_currency_to_word->currency_To_Word($prostring);
            }
            if($deposit == 'null')
            {
                $DEPOSITno="00.00";
                $DEPOSITEword="  ";
            }
            else
            {
                $DEPOSITno=$deposit;
                $depstring =$DEPOSITno;//.toString();
                $DEPOSITEword= $this->Mdl_eilib_currency_to_word->currency_To_Word($depstring);
            }
            $todaydat =date('d/m/Y');
            $check_in_dated_lastmonth=strtotime($checkindate);
            $check_in_date= date("Y-m-d",$check_in_dated_lastmonth);
            $check_in_dated=date("d-M-Y",$check_in_dated_lastmonth);
            $datecheckedin = intval(date("d", $check_in_dated_lastmonth));
            $check_out_dated_lastmonth=strtotime($checkoutdate);
            $check_out_date= date("Y-m-d",$check_out_dated_lastmonth);
            $cexdd=date("d-M-Y",$check_out_dated_lastmonth);
            $datecheckedin = intval(date("d", $check_out_dated_lastmonth));
            $LastMonthformat=date("t-M-Y",$check_in_dated_lastmonth);
            if( $noticedate!="")
            {            $dateStringNotice=strtotime($noticedate);
                $ntc_date1=date("d/m/Y",$dateStringNotice);
                $noticeSt=$cust_config_array[11];
                $noticeSt=$noticeSt;
            }
            else
            {
                $noticeSt=" ";
            }
            if ($webloginfetch!='')
            {
                (strpos($webloginfetch,"T1")===false)?$indext1=-1:$indext1=strpos($webloginfetch,"T1");
                (strpos($webloginfetch,"T2")===false)?$indext2=-1:$indext2=strpos($webloginfetch,"YT2ar");
            }
            if(($indext1>=0)||($indext2>=0))
            {
                if($indext1>=0)
                {
                    $address1value=$cust_config_array[12];
                }
                else if($indext2>=0)
                {
                    $address1value=$cust_config_array[13];
                }
            }
            else
            {
                $address1value=$cust_config_array[14];
            }
            if($waived == "true")
            {
                $waived = "(WAIVED)";
            }
            else
            {
                $waived = " ";
            }
            if($cardno == "")
            {
                $cardno= "        ";
            }
            else
            {
                $cardno=$cardno;
            }
            if($fixedaircon_fetch!='null')
            {
                $fixedstmtfetch=$cust_config_array[16];
                $fixedstmtfetch=str_replace("AIRFIXED",$fixedaircon_fetch,$fixedstmtfetch);
                $fixedstmtfetch= $fixedstmtfetch;
            }
            else if($quartaircon_fetch!='null')
            {
                $quartstmtfetch=$cust_config_array[15];
                $quartstmtfetch=str_replace("AIRQ",$quartaircon_fetch,$quartstmtfetch);
                $fixedstmtfetch= $quartstmtfetch;
            }
            else
            {
                $fixedstmtfetch= "$00.00";
            }
            $finalep_pass = "";
            if(($epno =="") && ($passportno ==""))
            {
                $epno="";
                $passportno="";
                $finalep_pass ="";
                $noepcontlineno=$cust_config_array[19];
            }
            else if($epno =="")
            {
                $epno="";
                $finalep_pass ="PASSPORT NO: ".$passportno;
            }
            else if($passportno=="")
            {
                $passportno="";
                $finalep_pass ="EP NO: ".$epno;
            }
            if(($epno != "") && ($passportno !=""))
            {$finalep_pass = "EP NO: ".$epno;
            }
            if($passportdate=="")
            {
                $passportdate="";
            }
            if($epdate=="")
            {
                $epdate="";
            }
            if($noticeperiod=='null')
            {
                $noticeperiod="";
            }
            if($passportdate!="")
            {
                $passport_dated_lastmonth=strtotime($passportdate);
                $passportdate= date("d/m/Y",$passport_dated_lastmonth);
            }
            if($epdate!="")
            {
                $EP_lastmonth=strtotime($epdate);
                $epdate= date("d/m/Y",$EP_lastmonth);
            }
            if($noticeperiod=="")
            {
                $notI= "";
            }
            else
            {
                $notI= $noticeperiod;
            }
            $pro_lbl=$cust_config_array[17];//get prorated label
            $pro_rated_lineno=intval($cust_config_array[18]);//get prorated label line no
            $prlbl1  =str_replace("checkin",$check_in_dated,$pro_lbl) ;
            $prlbl2  =str_replace("prochkout",$LastMonthformat,$prlbl1) ;
//CHECK LESS THAN A MONTH OR GREATER THAN A MONTH
            $rent_check=$rent_check;
            strpos($lp,"Year")===false?$yearchk=-1:$yearchk=strpos($lp,"Year");
            strpos($lp,"Months")===false?$monthschk=-1:$monthschk=strpos($lp,"Months");
            strpos($lp,"Month")===false?$monthchk=-1:$monthchk=strpos($lp,"Month");
            strpos($lp,"Day")===false?$daychk=-1:$daychk=strpos($lp,"Day");
            if($formname=="EXTENSION")
            {
                if((($yearchk>0)||($monthschk>0)||(($monthchk>0)&&($daychk>0)))&&($rent_check=='true'))//greater than a month,prorated
                {
                    $proratedrent=$this->Mdl_eilib_prorated_calc->sMonthProratedCalc($check_in_date,$rent);
                    if($proratedrent!=0)
                    {
                        $flagProratedRentCkout=$proratedrent.'^~^'.$LastMonthformat;
                    }
                    else
                    {
                        $flagProratedRentCkout=1;
                    }
                }
                else if((($yearchk>0)||($monthschk>0)||(($monthchk>0)&&($daychk>0)))&&($rent_check=='false'))//greater than a month,non prorated
                {
                    $flag_paraAlign_sec=0;
                }
                else if(((($yearchk<0)&&($monthschk<0)&&($daychk>0)&&($monthchk<0))||(($yearchk<0)&&($monthschk<0)&&($daychk<0)&&($monthchk>0)))&&($rent_check=='true'))//less than a month,prorated
                {
                    if((date("Y", $check_in_dated_lastmonth)==date("Y", $check_out_dated_lastmonth))&&(date("m", $check_in_dated_lastmonth)==date("m", $check_out_dated_lastmonth)))
                    {
                        $proratedrent=$this->Mdl_eilib_prorated_calc->wMonthProratedCalc($check_in_date,$check_out_date,$rent);
                        if($proratedrent!='0.00')
                        {
                            $flagProratedRentCkout=$proratedrent.'^~^'.$cexdd;$LastMonthformat=$cexdd;
                        }
                        else
                        {
                            $flagProratedRentCkout=1;
                        }
                    }
                    else if((date("Y", $check_in_dated_lastmonth)==date("Y", $check_out_dated_lastmonth))||(date("m", $check_in_dated_lastmonth)==date("m", $check_out_dated_lastmonth)))
                    {
                        $proratedsmonth=$this->Mdl_eilib_prorated_calc->sMonthProratedCalc($check_in_date,$rent);
                        $proratedemonth=$this->Mdl_eilib_prorated_calc->eMonthProratedCalc($check_out_date,$rent);
                        $proratedrent= number_format((floatval($proratedsmonth)+floatval($proratedemonth)),2,'.','');
//                        $proratedrent=sprintf("%01.2f", (floatval($proratedsmonth)+floatval($proratedemonth)));
                        if($proratedrent!='0.00')
                        {
                            $flagProratedRentCkout=$proratedrent.'^~^'.$cexdd;
                        }
                        else
                        {
                            $flagProratedRentCkout=1;
                        }
                    }
                }
            }
            else
            {
                $prlbl1= str_replace("checkin",$check_in_dated, $pro_lbl);
                $prlbl2= str_replace("prochkout",$LastMonthformat, $prlbl1);
                //LESS THAN EQUAL TO A MONTH
                if(((($yearchk<0)&&($monthschk<0)&&($daychk>0)&&($monthchk<0))||(($yearchk<0)&&($monthschk<0)&&($daychk<0)&&($monthchk>0))))
                {
                    if($rent_check=='false')
                    {
                        $flagProratedRentCkout=1;
                    }
                }
                //GREATER THAN A MONTH
                else
                {
                    $proratedrent= $this->Mdl_eilib_prorated_calc->sMonthProratedCalc($check_in_date,$rent);
                    if($proratedrent!=0)
                        if($proratedrent!=0)
                        {
                            if($rent_check=='true')
                            {
                                $flagProratedRentCkout=$proratedrent.'^~^0';
                            }
                            else if($rent_check=='false')
                            {
                                $flagProratedRentCkout=1;
                            }
                        }
                        else
                        {
                            $flagProratedRentCkout=1;
                        }
                }}
            $url= $this->Mdl_eilib_common_function->getUrlAccessGasScript();
            $title= "CONTRACT"."-"." ".$unitno." ". "-". " ".$customername;
            $newfile= $this->printFile($service,$cust_config_array[10],$parentId,$title);
            $file = new Google_Service_Drive_DriveFile();
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
            $service->files->patch($newfile, $file);
            $file = $service->files->get($newfile);
            $data = array('flagProratedRentCkout'=>$flagProratedRentCkout,'pro_rated_lineno'=>$pro_rated_lineno,'prlbl1'=>$prlbl1,'prlbl2'=>$prlbl2,'LastMonthformat'=>$LastMonthformat,'DEPOSITEword'=>$DEPOSITEword,'ntc_date1'=>$ntc_date1,'todaydat'=>$todaydat,'todaydatestring'=>$todaydatestring,'finalep_pass'=>$finalep_pass,
                'LastMonthformat'=>$LastMonthformat,'flag_paraAlign'=>$flag_paraAlign,'flag_paraAlign_sec'=>$flag_paraAlign_sec,'flag_paraAlign_thrd'=>$flag_paraAlign_thrd,'flag_paraAlign_four'=>$flag_paraAlign_four,'flag_paraAlign_five'=>$flag_paraAlign_five,
                'cexdd'=>$cexdd,'check_in_dated'=>$check_in_dated,'noticeSt'=>$noticeSt,'address1value'=>$address1value,'cardno'=>$cardno,'fixedstmtfetch'=>$fixedstmtfetch,'noepcontlineno'=>$noepcontlineno,'elec_fetch'=>$elec_fetch,'dryclean_fetch'=>$dryclean_fetch,
                'checkoutfee_fetch'=>$checkoutfee_fetch,'PROCESSno'=>$PROCESSno,'DEPOSITno'=>$DEPOSITno,'elec_fetch'=> $elec_fetch,'dryclean_fetch'=> $dryclean_fetch,'checkoutfee_fetch'=> $checkoutfee_fetch,'PROCESSno'=> $PROCESSno,'DEPOSITno'=> $DEPOSITno,'weblogin'=>$webloginfetch,'flag'=>1,'cust_config_array' => $newfile, 'RENTword' => $RENTword, 'PROCESSword' => $PROCESSword,'DEPOSITword'=>$DEPOSITword, 'proratedrent' => "shld present in word", 'proratedsmonth' => "2014-09-09"
            , 'proratedemonth' => "2014-09-09", 'unitno' => $unitno, 'checkindate' => $checkindate, 'checkoutdate' => $checkoutdate, 'companyname' => $companyname, 'customername' => $customername, 'noticeperiod' => $noticeperiod,
                'passportno'=>   $passportno,'passportdate'=>$passportdate,'epno'=>$epno,'epdate'=>$epdate,'noticedate'=>$noticedate,'lp'=>$lp,'cardno'=>$cardno,'rent'=>$rent,
                'airquartfee'=>$airquartfee,'airfixedfee'=>$airfixedfee,'electcap'=>$electcap,'dryclean'=>$dryclean,'chkoutfee'=>$chkoutfee,'procfee'=>$procfee,
                'deposit'=>$deposit,'waived'=>$waived,'roomtype'=>$roomtype,'rent_check'=>$rent_check,'formname'=>$formname,
                'targetFolderId'=>"TEST" );
            $ch = curl_init();
            $data=http_build_query($data);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
            $response = curl_exec($ch);
            curl_close($ch);
            if(strpos($response,"SCRIPT ERROR")===false){
                $this->CUST_SetDocOwner($service,$response,$docowner,$sendmailid);
                return [1,$newfile,$file->alternateLink];}
            else{
                return [0,$newfile,$file->alternateLink,$response];
            }
        } catch (Exception $ex) {
            return [0,$newfile,"",$ex->getMessage()];
        }
    }
//GET INVOICE ID ,CONTRACT ID ,SERIAL NO,INVOIC DATE
    public function CUST_invoice_contractreplacetext()
    {
        $this->db->select("CCN_DATA");
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CCN_ID IN(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,35,37,43)');
        $result=array();
        foreach ($this->db->get()->result_array() as $key=>$val)
        {
            $result[]=$val['CCN_DATA'];
        }
        return $result;
    }
//DOCUMENT OWNER
    public  function SetDocOwnerGivenId($service,$fileid,$URSRC_loginid){
        $value=$URSRC_loginid;
        $type='user';
        $role='owner';
        $email=$URSRC_loginid;
        $newPermission = new Google_Service_Drive_Permission();
        $newPermission->setValue($value);
        $newPermission->setType($type);
        $newPermission->setRole($role);
        $newPermission->setEmailAddress($email);
        try {
            $service->permissions->insert($fileid, $newPermission);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
//FUNCTION TO CREATE INVOICE
    public  function CUST_invoice($UserStamp,$service,$unit,$customername,$companyname,$invoiceid,$invoicesno,$invoicedate,$rent,$process,$deposit,$sdate,$edate,$roomtype,$Leaseperiod,$rentcheck,$sendmailid,$docowner,$formname,$waived,$custid,$parentId)
    {
        try {
            $sum='';$proratedrentflag='';$length='';$newfile='test';
            $invoiceidcode=$invoiceid;
            $Slno=intval($invoicesno);
            $Sdate=$invoicedate;
            $tenant_fetch=$customername;
            $unit_fetch=$unit;
            $company_fetch=$companyname;
            if($company_fetch==null||$company_fetch=="")
            { $company_fetch=' ';}
            $checkin_fetch=$sdate;
            $checkout_fetch=$edate;
            $deposit=$deposit;
            if($deposit==null||$deposit=='')
            {  $A3='00.00';  }  else  {    $A3=$deposit;  }
            $process=$process;
            if($process==""||$waived!="" ||$process=='null')
            {$A4='00.00';}else{$A4=$process;}
            $A5=$rent;
            $lease_fetch=$Leaseperiod;
            $SdateD = $Sdate;
            $sysdate =date('d-m-Y');
            $todaydatc = date('Y-m-d');// Utilities.formatDate(new Date(sysdate), TimeZone, "yyyy/MM/dd");
            $todaysDate=date('Ymd',strtotime($todaydatc));
            $todaydat = date('d-m-Y');//Utilities.formatDate(new Date(), TimeZone, "dd/MM/yyyy");
            $todaydatR =date('m-d-Y');// Utilities.formatDate(new Date(), TimeZone, "MM/dd/yyyy");
            $this->load->model('EILIB/Mdl_eilib_common_function');
            if(strtotime($SdateD) == strtotime("today"))
            {
                $Slno=$Slno+1;
                if(0<=$Slno && $Slno<=9){
                    $Slno= (String)("00".$Slno);
                }
                else if(10<=$Slno && $Slno<=99){
                    $Slno= "0".$Slno;
                }
                $this->Mdl_eilib_common_function->CUST_invoicesearialnoupdation($Slno,$UserStamp);
            }
            else
            {
                $Slno = 1;
                if($Slno==1){
                    $Slno= (String)("00".$Slno);
                }
                $todaydatc = date("d/m/Y");// Utilities.formatDate(new Date(sysdate), TimeZone, "dd/MM/yyyy");
                $cc_invoicedate = date("Y/m/d");//  Utilities.formatDate(new Date(sysdate), TimeZone, "yyyy/MM/dd");
                $this->Mdl_eilib_common_function->CUST_invoiceserialandinvoicedateupdation($Slno, $cc_invoicedate,$UserStamp);
            }
            $todaydatestring =  date("d-M-Y");
            $pc = floatval($A3); // processing cost to float
            $ren = floatval($A5); // rent amount to float
            $das = floatval($A4); // deposite amount to float
            $check_in_dated_minus=strtotime($checkin_fetch);
            $check_in_date= date("Y-m-d",$check_in_dated_minus);
            $dateStringCheckin=strtotime($check_in_date);
            $check_in_date1= date("d/M/Y",$dateStringCheckin);
            $check_out_dated_lastmonth=strtotime($checkout_fetch);
            $check_out_date= date("Y-m-d",$check_out_dated_lastmonth);
            $check_out_date1= date("d/M/Y",$check_out_dated_lastmonth);
            $curr_date = 0;
            $curr_month = intval(date("m", $check_in_dated_minus));
            $curr_month++;
            $curr_year = intval(date("Y", $check_in_dated_minus));
            $cdate1="";
            $cdate2="";
            strpos($lease_fetch,"Year")===false?$yearchk=-1:$yearchk=strpos($lease_fetch,"Year");
            strpos($lease_fetch,"Months")===false?$monthschk=-1:$monthschk=strpos($lease_fetch,"Months");
            strpos($lease_fetch,"Month")===false?$monthchk=-1:$monthchk=strpos($lease_fetch,"Month");
            strpos($lease_fetch,"Day")===false?$daychk=-1:$daychk=strpos($lease_fetch,"Day");
            $check_in_dated_lastmonth = strtotime ("+1 month",$dateStringCheckin);
            $LastMonth= date("Y-m-d",$check_in_dated_lastmonth);
            $rent_check=$rentcheck;
            $this->load->model('EILIB/Mdl_eilib_invoice_contract');
            $nonPror_monthCal=    $this->Mdl_eilib_invoice_contract->nonproratedmonthcalculation($check_in_date,$check_out_date);
            $prorated_monthCal=    $this->Mdl_eilib_invoice_contract->proratedmonthcalculation($check_in_date,$check_out_date);
            $Pror_monthCal_concate_start='';$Pror_monthCal_concate_end='';
            $this->load->model('EILIB/Mdl_eilib_prorated_calc');
            $proratedrent=$this->Mdl_eilib_prorated_calc->wMonthProratedCalc($check_in_date,$check_out_date,$rent);
            $proratedsmonth=$this->Mdl_eilib_prorated_calc->sMonthProratedCalc($check_in_date,$rent);
            $proratedemonth=$this->Mdl_eilib_prorated_calc->eMonthProratedCalc($check_out_date,$rent);
            $month_calculation=$this->nonproratedmonthcalculation(  $check_in_date,  $check_out_date);
            $startdate_array=  $month_calculation[0];
            $enddate_array=  $month_calculation[1];
            $arrCheckDateAmtConcate="";$singlemonth='';$reminingmonths='';

            if(  $formname=="CREATION" ||   $formname=="RECHECKIN")
            {
                if((  $yearchk>0)||(  $monthschk>0)||((  $monthchk>0)&&(  $daychk>0)))
                {
                    if(  $rent_check=='false')
                    {
                        $proratedrentflag=1;
                        $month_calculation=$this->nonproratedmonthcalculation(  $check_in_date,  $check_out_date);
                        $startdate_array=  $month_calculation[0];
                        $enddate_array=  $month_calculation[1];
                        $length=  count($startdate_array);
                    }
                    else{
                        $proratedrentflag=2;
                        $month_calculation=$this->proratedmonthcalculation($check_in_date,$check_out_date);
                        $startdate_array=$month_calculation[0];
                        $enddate_array=$month_calculation[1];
                        $length=count($startdate_array);
                    }
                }
                else
                {
                    $length=1;
                    $proratedrentflag=0;
                    $cdate1=$check_in_date1;
                    $cdate2=$check_out_date1;
                    $sum1 = $das+$pc+floatval($A5);
                    $sum = number_format($sum1,2,'.','');
                }
            }
            else if( $formname=="EXTENSION")//extension....
            {
                if((( $yearchk>0)||( $monthschk>0)||(( $monthchk>0)&&( $daychk>0)))&&( $rent_check=='true'))//greater than a month-rent check true
                {
                    $proratedrentflag=2;
                    $month_calculation=$this->proratedmonthcalculation( $check_in_date, $check_out_date);
                    $startdate_array= $month_calculation[0];
                    $enddate_array= $month_calculation[1];
                    $length=count( $startdate_array);
                }
                else if((( $yearchk>0)||( $monthschk>0)||(( $monthchk>0)&&( $daychk>0)))&&( $rent_check=='false'))//greater than a month-rent check false
                {
                    $proratedrentflag=1;
                    $month_calculation=$this->nonproratedmonthcalculation( $check_in_date, $check_out_date);
                    $startdate_array= $month_calculation[0];
                    $enddate_array= $month_calculation[1];
                    $length=count($startdate_array);
                    print_r($month_calculation);
                }
                else if(((( $yearchk<0)&&( $monthschk<0)&&( $daychk>0)&&( $monthchk<0))||(( $yearchk<0)&&( $monthschk<0)&&( $daychk<0)&&( $monthchk>0)))&&( $rent_check=='true'))//less than or equal to a month
                {
                    $length=1;
                    $proratedrentflag=0;
                    $cdate1= $check_in_date1;
                    $cdate2= $check_out_date1;
                    if((date("Y", strtotime($checkin_fetch))==date("Y", strtotime($checkout_fetch))) &&(date("m", strtotime($checkin_fetch))==date("m", strtotime($checkout_fetch))))
                    {
                        $proratedrent=$this->Mdl_eilib_prorated_calc->wMonthProratedCalc($check_in_date,$check_out_date,$A5);
                        $sum1 = $das+$pc+floatval($proratedrent);
                        $sum = number_format($sum1,2,'.','');
                    }
                    else if((date("Y", strtotime($checkin_fetch))!=date("Y", strtotime($checkout_fetch))) ||(date("m", strtotime($checkin_fetch))!=date("m", strtotime($checkout_fetch))))
                    {
                        $proratedsmonth=$this->Mdl_eilib_prorated_calc->sMonthProratedCalc($check_in_date,$A5);
                        $proratedemonth=$this->Mdl_eilib_prorated_calc->eMonthProratedCalc($check_out_date,$A5);
                        $proratedrent = number_format(floatval($proratedsmonth)+floatval($proratedemonth),2,'.','');
                        $A5=$proratedrent;
                        if($proratedrent!='0.00')
                        {
                            $sum1 = $das+$pc+floatval($proratedrent);
                            $sum = number_format($sum1,2,'.','');            }
                        else
                        {
                            $sum1 = $das+$pc+$ren;
                            $sum = number_format($sum1,2,'.','');            }
                    }
                }
            }
            if($proratedrentflag==2)  /////////rent check true greater than month PRORATED
            {
                $sumamount=$das+$pc;
                $reminingmonths=0;
                for($i=0;$i<$length;$i++)
                {
                    $startdate=$startdate_array[$i];
                    $enddate=$enddate_array[$i];
                    if(intval(date("d", strtotime($startdate)))!=1 && $i==0){$amount=$this->Mdl_eilib_prorated_calc->sMonthProratedCalc($check_in_date,$A5);}else{$amount=$A5;}
                    if($i==$length-1)
                    {
                        $date = new DateTime();
                        $date->setDate(date("Y", strtotime($enddate)),(intval(date("m", strtotime($enddate)))+1),date("d", strtotime($enddate)));
                        $finaldate=$date->format('Y-m-d');
                        if(date("d", strtotime($enddate))==date("d", strtotime($finaldate))-1)
                        {$amount=$A5;}else{$amount=$this->Mdl_eilib_prorated_calc->eMonthProratedCalc($check_out_date,$A5);}
                    }
                    $checkdate1= date("d/M/Y",strtotime($startdate));
                    $checkdate2= date("d/M/Y",strtotime($enddate));
                    if($i==0)
                        $arrCheckDateAmtConcate.= $amount.'^^'.$checkdate1.'^^'.$checkdate2;
                    else
                        $arrCheckDateAmtConcate.= '^~^'.$amount.'^^'.$checkdate1.'^^'.$checkdate2;
                    if($i==0)
                    {
                        $singlemonth= number_format(floatval($sumamount)+floatval($amount),2,'.','');

                    }
                    else
                    {
                        $reminingmonths=floatval($reminingmonths)+floatval($amount);
                        $reminingmonths= number_format($reminingmonths,2,'.','');
                    }
                }
            }
            if($proratedrentflag==1)   ////NONPRORATED
            {
                $sumamount=$das+$pc;
                $reminingmonths=0;
                for($i=0;$i<$length;$i++)
                {
                    $startdate=$startdate_array[$i];
                    $enddate=$enddate_array[$i];
                    $amount=$A5;
                    if($i==$length-1)
                    {
                        if(date('Y',strtotime($startdate))==date('Y',strtotime($enddate)) &&date('m',strtotime($startdate))==date('m',strtotime($enddate)))
                        {
                            $amount=$this->Mdl_eilib_prorated_calc->wMonthProratedCalc($startdate,$enddate,$A5);
                        }
                        else if(date('Y',strtotime($startdate))!=date('Y',strtotime($enddate)) ||date('m',strtotime($startdate))!=date('m',strtotime($enddate)))
                        {
                            $proratedsmonth=$this->Mdl_eilib_prorated_calc->sMonthProratedCalc($startdate,$A5);
                            $proratedemonth=$this->Mdl_eilib_prorated_calc->eMonthProratedCalc($enddate,$A5);
                            $amount=number_format(floatval($proratedsmonth)+floatval($proratedemonth),2,'.','');
                        }
                    }
                    $checkdate1= date("d/M/Y",strtotime($startdate));
                    $checkdate2=date("d/M/Y",strtotime($enddate));
                    if($i==0)
                        $arrCheckDateAmtConcate.= $amount.'^^'.$checkdate1.'^^'.$checkdate2;
                    else
                        $arrCheckDateAmtConcate.= '^~^'.$amount.'^^'.$checkdate1.'^^'.$checkdate2;
                    $sum = number_format($sumamount,2,'.','');
                    if($i==0)
                    {
                        $singlemonth= number_format(floatval($sumamount)+floatval($amount),2,'.','');
                    }
                    else
                    {
                        $reminingmonths= number_format(floatval($reminingmonths)+floatval($amount),2,'.','');
                    }
                }
            }
            if($formname=="EXTENSION")
            {
                $replaceSum=$sum;
            }
            else
            {
                $pcanddep=floatval($das)+floatval($pc)+floatval($A5);
                $replaceSum=  number_format($pcanddep,2,'.','');
            }
            if($company_fetch==" ")
            {
                $companyTemp="company/";
            }
            else
            {
                $companyTemp="company";
            }
            if($proratedrentflag==0){
                $arrCheckDateAmtConcate.= $A5.'^^'.$cdate1.'^^'.$cdate2;
                $reminingmonths=$replaceSum;
            }
            $title="INVOICE"."   -"." ".$unit." ". "-". " ".$tenant_fetch."_INV".$todaysDate.''.$Slno;
            $newfile= $this->printFile($service,$invoiceid,$parentId,$title);
            $file = new Google_Service_Drive_DriveFile();
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
            $service->files->patch($newfile, $file);
            $file = $service->files->get($newfile);
            $data = array('arrCheckDateAmtConcate'=>$arrCheckDateAmtConcate,'singlemonth'=>$singlemonth,'reminingmonths'=>$reminingmonths, 'companyTemp'=>$companyTemp, 'replaceSum'=>$replaceSum, 'todaydat'=>$todaydat,'todaydatestring'=>$todaydatestring,'A3'=>$A3,'A4'=>$A4,'das'=>$das,'pc'=>$pc,'A5'=>$A5,'sum'=>$sum,'cdate1'=>$cdate1,'cdate2'=>$cdate2,'todaysDate'=>$todaysDate,'Slno'=>$Slno,'tenant_fetch' => $tenant_fetch,'length'=>$length,'proratedrentflag'=>$proratedrentflag,
                'nonPror_monthCal'=>$nonPror_monthCal,'flag'=>2,'prorated_monthCal' => $prorated_monthCal, 'proratedrent' => $proratedrent, 'proratedsmonth' => $proratedsmonth,'proratedemonth'=>$proratedemonth,
                'unit' => $unit, 'customername' => $customername
            , 'companyname' =>$company_fetch, 'invoiceid' => $newfile,'invoicesno' => $invoicesno, 'invoicedate' => $invoicedate,
                'rent' => $rent, 'process' => $process, 'deposit' => $deposit,'sdate'=>$sdate,'edate'=>$edate,'roomtype'=>$roomtype,
                'Leaseperiod'=>$Leaseperiod,'Leaseperiod'=>$Leaseperiod,'rentcheck'=>$rentcheck,'docowner'=>$docowner,'formname'=>$formname,
                'waived'=>$waived,'custid'=>$custid );
            $url= $this->Mdl_eilib_common_function->getUrlAccessGasScript();
            $ch = curl_init();
            $data=http_build_query($data);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
            $response = curl_exec($ch);
            curl_close($ch);
            if(strpos($response,"SCRIPT ERROR")===false){
                $this->CUST_SetDocOwner($service,$response,$docowner,$sendmailid);
                return [1,$newfile,$file->alternateLink,"INV".$todaysDate.$Slno];}
            else{
                return [0,$newfile,$file->alternateLink,$response];
            }
        }
        catch(Exception $e) {
            return [0,$newfile,"",$e->getMessage()];
        }
    }
//MAIL PART FOR CONTRACT AND INVOICE
    public function mailInvoiceContract($sender,$reciver,$subject,$body,$fileData,$title){
        try
        {
            $image_data=$fileData;
            $image_content_id=$title;
            $message = new Message();
            $message->setSender($sender);
            $message->addTo($reciver);
            $message->setSubject($subject);
            $message->setTextBody($body);
            $message->addAttachment($title.'.docx', $image_data, $image_content_id);
            $message->send();
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
        }
    }
}