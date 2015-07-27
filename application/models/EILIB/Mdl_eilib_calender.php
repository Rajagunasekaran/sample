<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-021
 * Date: 13/5/15
 * Time: 10:25 AM
 */
//******************************************CALENDER********************************************//
//DONE BY:SARADAMBAL
//VER 5.8 -SD:04/06/2015 ED:04/06/2015,CHANGED FUNCTION FOR GETTING CAL SERVICE
//VER 5.5-SD:03/06/2015 ED:03/06/2015,CHANGED FILE NAME
//VER 0.01-SD:14/05/2015 ED:20/02/2015,COMPLETED CALENDER CALCULATION
//*******************************************************************************************************//
class Mdl_eilib_calender  extends CI_Model {
    //TIME CONVERSION
    public function CalenderTime_Convertion($startdate,$startdate_starttime,$startdate_endtime){
        if($startdate!=''&&$startdate_starttime!=''&&$startdate_endtime!='') {
            $splitStart = explode(':', $startdate_starttime);
            $startdate_starttime = $splitStart[0] . ':' . $splitStart[1];
            $splitEnd = explode(':', $startdate_endtime);
            $startdate_endtime = $splitEnd[0] . ':' . $splitEnd[1];
        }
        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime($startdate.'T'.$startdate_starttime.':00.000+08:00');
        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($startdate.'T'.$startdate_endtime.':00.000+08:00');
        return array($start,$end);
    }
//COMMON FUNCTION TO CREATE CALENDAR ID
    public function createCalendarService(){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $arrClientId= $this->Mdl_eilib_common_function->getCalendarIdCilentIdService();
        $drive = new Google_Client();
        $drive->setClientId($arrClientId[0]);
        $drive->setClientSecret($arrClientId[1]);
        $drive->setRedirectUri($arrClientId[2]);
        $drive->setScopes(array($arrClientId[3],$arrClientId[4]));
        $drive->setAccessType('online');
        $authUrl = $drive->createAuthUrl();
        $refresh_token= $arrClientId[5];
        $drive->refreshToken($refresh_token);
        $cal = new Google_Service_Calendar($drive);
        return $cal;
    }
//FUNCTION TO GET CALENDAR ID
    function GetEICalendarId()
    {
        $this->db->select('CCN_DATA');
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CGN_ID',75);
        $URSRC_select_calenderid=$this->db->get();
        foreach($URSRC_select_calenderid->result_array() as $row){
            $calendarId=$row["CCN_DATA"];
        }
        return $calendarId;
    }
//CALENDAR EVENT CREATION FOR STARHUB N UNIT FORM
    public  function  StarHubUnit_CreateCalEvent($cal,$startdate,$startdate_starttime,$startdate_endtime,$enddate,$enddate_starttime,$enddate_endtime,$TypeOfExp,$unitno,$accountno,$starteventtype,$endeventtype,$eiornonei,$rent)
    {
        try{
            $calId=$this->GetEICalendarId();
            if($eiornonei=="X")
            {$eiornonei="EI";}
            else
            {$eiornonei="NON EI";}
            if($TypeOfExp=="STARHUB")
            {
                $calseventtitle=$TypeOfExp." ".$unitno." - ".$starteventtype;//title of start event
                $calseventdesc=$unitno." - ".$accountno." - ".$starteventtype;//description of start event
                $calseventloc=$unitno." - ".$accountno;//location of start event
            }
            else//UNIT
            {
                $calseventtitle=$unitno." - "."LEASE ".$starteventtype;//title of start event
                $calseventdesc=$unitno." - ".$eiornonei." - "."RENT :".$rent;//description of start event
                $calseventloc=$unitno." - ".$eiornonei;//location of start event
            }
            $event = new Google_Service_Calendar_Event();
            $startEndCal= $this->CalenderTime_Convertion($startdate,$startdate_starttime,$startdate_endtime);
            $event->setStart($startEndCal[0]);
            $event->setEnd($startEndCal[1]);
            $event->setDescription($calseventdesc);
            $event->setLocation($calseventloc);
            $event->setSummary($calseventtitle);
            $cal->events->insert($calId, $event);
            if($TypeOfExp=="STARHUB")
            {
                $calseventtitle=$TypeOfExp." ".$unitno." - ".$endeventtype;//title of start event
                $calseventdesc=$unitno." - ".$accountno." - ".$endeventtype;//description of start event
                $calseventloc=$unitno." - ".$accountno;//location of start event
            }
            else//UNIT
            {
                $calseventtitle=$unitno." - "."LEASE ".$endeventtype;//title of start event
                $calseventdesc=$unitno." - ".$eiornonei." - "."RENT :".$rent;//description of start event
                $calseventloc=$unitno." - ".$eiornonei;//location of start event
            }
            $startEndCal= $this->CalenderTime_Convertion($enddate,$enddate_starttime,$enddate_endtime);
            $event->setStart($startEndCal[0]);
            $event->setEnd($startEndCal[1]);
            $event->setDescription($calseventdesc);
            $event->setLocation($calseventloc);
            $event->setSummary($calseventtitle);
            $cal->events->insert($calId, $event);
            return 1;
        }
        catch(Exception $ex){
            return $ex->getMessage();
        }
    }
//FUNCTION TO DELETE CALENDER EVENTS FOR STAR HUB
    public function StarHubUnit_DeleteCalEvent($cal,$unitno,$startdate,$start_time_in,$start_time_out,$enddate,$end_time_in,$end_time_out,$formname)
    {
        try {
            $calId = $this->GetEICalendarId();
            $startevents = $this->CalenderTime_Convertion($startdate, $start_time_in, $start_time_out);
            $optDate = array('timeMax' => $startdate . 'T' . $start_time_out . '+08:00', 'timeMin' => $startdate . 'T' . $start_time_in . '+08:00');
            $events = $cal->events->listEvents($calId, $optDate);
            foreach ($events->getItems() as $event) {
                $summaryStarUnit = $event->getDescription();
                if (preg_match("/-/", (String)$summaryStarUnit) == 1) {
                    $start_desc = explode(' - ', $event->getDescription());
                    if (($start_desc[1] != 'undefined' && (preg_match("/EI/", (String)$start_desc[1]) == 1) && $formname == "UNIT") || ($formname == "INTERNET") || ($formname == "CABLE")) {
                        if (($start_desc[0] == $unitno && $formname == "UNIT") || ($start_desc[0] == $unitno && preg_match("/$formname/", (String)$start_desc[2]) == 1)) {
                            $cal->events->delete($calId, $event->getId());
                        }
                    }
                }
            }
            $optDate = array('timeMax' => $enddate . 'T' . $end_time_out . '+08:00', 'timeMin' => $enddate . 'T' . $end_time_in . '+08:00');
            $events = $cal->events->listEvents($calId, $optDate);
            foreach ($events->getItems() as $event) {
                $summaryStarUnit = $event->getDescription();
                if (preg_match("/-/", (String)$summaryStarUnit) == 1) {

                    $start_desc = explode(' - ', $event->getDescription());
                    if (($start_desc[1] != 'undefined' && (preg_match("/EI/", (String)$start_desc[1]) == 1) && $formname == "UNIT") || ($formname == "INTERNET") || ($formname == "CABLE")) {
                        if (($start_desc[0] == $unitno && $formname == "UNIT") || ($start_desc[0] == $unitno && preg_match("/$formname/", (String)$start_desc[2]) == 1)) {
                            $cal->events->delete($calId, $event->getId());
                        }
                    }
                }
            }
            return 1;
        }
        catch(Exception $ex){
            return $ex->getMessage();
        }
    }
//COMMON FUNCTION FOR CONCATING THE STARHUB AND UNIT
    function getConcateOfDescLoc($TypeOfExp,$unitno,$endeventtype,$accountno,$eiornonei,$rent){
        if($TypeOfExp=="STARHUB")
        {
            $calseventtitle=$TypeOfExp." ".$unitno." - ".$endeventtype;//title of start event
            $calseventdesc=$unitno." - ".$accountno." - ".$endeventtype;//description of start event
            $calseventloc=$unitno." - ".$accountno;//location of start event
        }
        else//UNIT
        {
            $calseventtitle=$unitno." - "."LEASE ".$endeventtype;//title of start event
            $calseventdesc=$unitno." - ".$eiornonei." - "."RENT :".$rent;//description of start event
            $calseventloc=$unitno." - ".$eiornonei;//location of start event
        }
        return array($calseventtitle,$calseventdesc,$calseventloc);
    }
//FUNCTION TO CREATE CALENDAR EVENT FOR CUSTOMER WITH ATTACHMENT
    public function  CUST_customercalendercreation($fileDoc,$calPrimary,$custid,$startdate,$startdate_starttime,$startdate_endtime,$enddate,$enddate_starttime,$enddate_endtime,$firstname,$lastname,$mobile,$intmobile,$office,$customermailid,$unit,$roomtype,$unitrmtype)
    {
        try{
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $attachments=[];
            for($j=0;$j<count($fileDoc)&&count($fileDoc)>0;$j++){
                $servicedoc= $this->Mdl_eilib_common_function->get_service_document();
                $file = $servicedoc->files->get($fileDoc[$j]);
                $attachments[]= array(
                    'fileUrl' => $file->alternateLink,
                    'mimeType' => $file->mimeType,
                    'title' => $file->title
                );}
            $calId=$this->GetEICalendarId();
            $initialsdate=$startdate;
            $initialedate=$enddate;
            $calendername= $firstname.' '.$lastname;
            $contactno="";
            $contactaddr="";
            if($mobile!=null)
            {$contactno=$mobile;}
            else if($intmobile!=null)
            {$contactno=$intmobile;}
            else if($office!=null)
            {$contactno=$office;}
            if($contactno!=null && $contactno!="")
            {
                $contactaddr=$custid." "."EMAIL :".$customermailid.",CONTACT NO :".$contactno;
            }
            else
            {
                $contactaddr=$custid." "."EMAIL :".$customermailid;
            }
            if($unitrmtype!="")
            {
                $details =$unit. " " . $calendername . " " .$unitrmtype." ". "CHECKIN";
            }
            else
            {
                $details =$unit. " " . $calendername . " " . "CHECKIN";
            }
            $details1 =$unit. " " .$roomtype ;
            if($initialsdate!="")
            {
                $event = new Google_Service_Calendar_Event();
                $startevents=$this->CalenderTime_Convertion($startdate, $startdate_starttime, $startdate_endtime);
                $event->setStart($startevents[0]);
                $event->setEnd($startevents[1]);
                $event->setDescription($contactaddr);
                $event->setLocation($details1);
                $event->setSummary($details);
                if(count($fileDoc)>0) {
                    $event->setAttachments($attachments);
                    $createdEvent = $calPrimary->events->insert($calId, $event, array('supportsAttachments' => TRUE));  // to create a event
                }else{
                    $createdEvent = $calPrimary->events->insert($calId, $event);
                }}
            $endevents=$this->CalenderTime_Convertion($enddate,$enddate_starttime,$enddate_endtime);
            $detailsend =$unit. " " . $calendername . " " . "CHECKOUT";
            $detailsend1 =$unit. " " .$roomtype ;
            if($initialedate!="")
            {
                $event = new Google_Service_Calendar_Event();
                $event->setStart($endevents[0]);
                $event->setEnd($endevents[1]);
                $event->setDescription($contactaddr);
                $event->setLocation($detailsend1);
                $event->setSummary($detailsend);
//                if(count($fileDoc)>0) {
//                    $event->setAttachments($attachments);
//                    $createdEvent = $calPrimary->events->insert($calId, $event,array('supportsAttachments' => TRUE)); // to create a event
//                }else{
                    $createdEvent = $calPrimary->events->insert($calId, $event);
//                }
            }
            return 1;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
//FUNCTION TO CREATE CALENDAR EVENT FOR CUSTOMER
    public function  CUST_customercalendercreation1($calPrimary,$custid,$startdate,$startdate_starttime,$startdate_endtime,$enddate,$enddate_starttime,$enddate_endtime,$firstname,$lastname,$mobile,$intmobile,$office,$customermailid,$unit,$roomtype,$unitrmtype)
    {
        try{
        $calId=$this->GetEICalendarId();
        $initialsdate=$startdate;
        $initialedate=$enddate;
        $calendername= $firstname.' '.$lastname;
        $contactno="";
        $contactaddr="";
        if($mobile!=null)
        {$contactno=$mobile;}
        else if($intmobile!=null)
        {$contactno=$intmobile;}
        else if($office!=null)
        {$contactno=$office;}
        if($contactno!=null && $contactno!="")
        {
            $contactaddr=$custid." "."EMAIL :".$customermailid.",CONTACT NO :".$contactno;
        }
        else
        {
            $contactaddr=$custid." "."EMAIL :".$customermailid;
        }
        if($unitrmtype!="")
        {
            $details =$unit. " " . $calendername . " " .$unitrmtype." ". "CHECKIN";
        }
        else
        {
            $details =$unit. " " . $calendername . " " . "CHECKIN";
        }
        $details1 =$unit. " " .$roomtype ;
        if($initialsdate!="")
        {
            $event = new Google_Service_Calendar_Event();
            $startevents=$this->CalenderTime_Convertion($startdate, $startdate_starttime, $startdate_endtime);
            $event->setStart($startevents[0]);
            $event->setEnd($startevents[1]);
            $event->setDescription($contactaddr);
            $event->setLocation($details1);
            $event->setSummary($details);
            $createdEvent = $calPrimary->events->insert($calId, $event); // to create a event
        }
        $endevents=$this->CalenderTime_Convertion($enddate,$enddate_starttime,$enddate_endtime);
        $detailsend =$unit. " " . $calendername . " " . "CHECKOUT";
        $detailsend1 =$unit. " " .$roomtype ;
        if($initialedate!="")
        {
            $event = new Google_Service_Calendar_Event();
            $event->setStart($endevents[0]);
            $event->setEnd($endevents[1]);
            $event->setDescription($contactaddr);
            $event->setLocation($detailsend1);
            $event->setSummary($detailsend);
            $createdEvent = $calPrimary->events->insert($calId, $event); // to create a event
        }
            return 1;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
///FUNCTION TO DELETE CALENDER EVENTS
    public function CUST_customercalenderdeletion($calPrimary,$custid,$startdate,$start_time_in,$start_time_out,$enddate,$end_time_in,$end_time_out,$formname)
    {
        try{
            $calId=$this->GetEICalendarId();
            if($formname=='UNCANCEL')
            {
                $eventsCheckOut = $calPrimary->events->listEvents($calId);
                foreach ($eventsCheckOut->getItems() as $event) {
                    $summaryStarUnit=$event->getDescription();
                    if(preg_match("/$custid/",$summaryStarUnit)==1){
                        if((intval(explode(' ',$event->getDescription())[0])==$custid && $startdate==(explode('T',$event->getstart()->dateTime)[0])) || (intval(explode(' ',$event->getDescription())[0])==$custid && $enddate==(explode('T',$event->getend()->dateTime)[0]))){
                            $calPrimary->events->delete($calId, $event->getId());}
                    }}
            }
            else{
                $optDate= array('timeMax' => $startdate.'T'.$start_time_out.'+08:00','timeMin' => $startdate.'T'.$start_time_in.'+08:00');
                $eventsCheckOut = $calPrimary->events->listEvents($calId,$optDate);
                foreach ($eventsCheckOut->getItems() as $event) {
                    if(intval(explode(' ',$event->getDescription())[0])==$custid ){
                        $calPrimary->events->delete($calId, $event->getId());}
                }
                $optDate= array('timeMax' => $enddate.'T'.$end_time_out.'+08:00','timeMin' => $enddate.'T'.$end_time_in.'+08:00');
                $eventsEnddate = $calPrimary->events->listEvents($calId,$optDate);
                foreach ($eventsEnddate->getItems() as $event) {
                    if(intval(explode(' ',$event->getDescription())[0])==$custid ){
                        $calPrimary->events->delete($calId, $event->getId());}
                }
            }
            return 1;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
    //FUNCTION TO DELETE CC CALENDER EVENTS
    public function CUST_CREATION_customercalenderdeletion($calPrimary,$custid,$calevents)
    {
        $calId=$this->GetEICalendarId();
        try{
            for($k=0;$k<count($calevents);$k++)
            {
                $Events = explode(',', $calevents[$k]);
                $optDate = array('timeMax' => $Events[0] . 'T' . $Events[2] . ':00.000+08:00', 'timeMin' => $Events[0] . 'T' . $Events[1] . ':00.000+08:00');
                $eventsCheckOut = $calPrimary->events->listEvents($calId, $optDate);
                foreach ($eventsCheckOut->getItems() as $event)
                {
                    if (intval(explode(' ', $event->getDescription())[0]) == $custid)
                    {
                        $calPrimary->events->delete($calId, $event->getId());
                    }
                }
            }
            return 1;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
//FUNCTION TO DELETE CALENDER EVENTS FOR CUSTOMER TERMINATION N EXTENSION
    public function CUST_customerTermcalenderdeletion($calPrimary,$custid,$startdate,$start_time_in,$start_time_out,$enddate,$end_time_in,$end_time_out,$formname)
    {
        try{
            $calId=$this->GetEICalendarId();
            $optDate= array('timeMax' => $startdate.'T'.$start_time_out.'.000+08:00','timeMin' => $startdate.'T'.$start_time_in.'.000+08:00');
            $events = $calPrimary->events->listEvents($calId,$optDate);
            foreach ($events->getItems() as $event) {
                $matchSummary=(String)$event->getSummary();
                if(intval(explode(' ',$event->getDescription())[0])==$custid && preg_match("/CHECKIN/",(String)$matchSummary)==1)
                    $calPrimary->events->delete($calId, $event->getId());
            }
            //CHECKOUT DELETION
            $optDate= array('timeMax' => $enddate.'T'.$end_time_out.'.000+08:00','timeMin' => $enddate.'T'.$end_time_in.'.000+08:00');
            $eventsCheckOut = $calPrimary->events->listEvents($calId,$optDate);
            foreach ($eventsCheckOut->getItems() as $event) {
                $matchSummary=(String)$event->getSummary();
                if(intval(explode(' ',$event->getDescription())[0])==$custid && preg_match("/CHECKOUT/",(String)$matchSummary)==1){
                    $calPrimary->events->delete($calId, $event->getId());}
            }
            return 1;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }
    //FUNCTION TO DELETE EXISTING EVENT N CREATE CURRENT CALENDAR EVENT DTS FOR EXTENSION N TERMINATION
    public function CTermExtn_Calevent($calPrimary,$CTermExtn_custid,$CTermExtn_recver,$ctermformname,$successflag,$fileDoc)
    {
        try {
            $CTermExtn_custfirstname = "";
            $CTermExtn_custlastname = "";
            $CTermExtn_calevntchk_flag = 0;
            $CTermExtn_prevunitno = [];
            $CTermExtn_prevroomtype = [];
            $CTermExtn_caleventcount = 0;
            $sql = "CALL SP_CUSTOMER_MIN_MAX_RV(" . $CTermExtn_custid . ",@MIN_LP,@MAX_LP)";
            $this->db->query($sql);
            $this->db->select('@MIN_LP AS MIN,@MAX_LP AS MAX', FALSE);
            $cterm_minlp = $this->db->get()->row()->MIN;
            if ($ctermformname == "EXTENSION") {
                $this->db->select('CED_REC_VER');
                $this->db->from('VW_EXTENSION_CUSTOMER');
                $this->db->where('CUSTOMER_ID=' . $CTermExtn_custid);
                $recObj = $this->db->get()->row();
                $CTermExtn_recver = $recObj->CED_REC_VER;
            }
            $i = 0;
            $queryCustomer = $this->db->query("SELECT  C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CED.CED_REC_VER,CTD.CLP_GUEST_CARD,CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,CTD.CLP_PRETERMINATE_DATE,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CCD.CCD_OFFICE_NO,CPD.CPD_EMAIL,U.UNIT_NO,URTD.URTD_ROOM_TYPE,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME, CTPD.CTP_DATA AS CED_ED_ETIME FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE CTPA ON CED.CED_SD_STIME = CTPA.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPB ON CED.CED_SD_ETIME = CTPB.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPC ON CED.CED_ED_STIME = CTPC.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPD ON CED.CED_ED_ETIME = CTPD.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CTD,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U,CUSTOMER C WHERE  CED.UNIT_ID=U.UNIT_ID AND (CED.CUSTOMER_ID=" . $CTermExtn_custid . ")AND (CTD.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CTD.CED_REC_VER) AND (CTD.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS  NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)  AND (C.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CTD.CUSTOMER_ID=C.CUSTOMER_ID) AND CED.CED_REC_VER>=" . $cterm_minlp . " AND CTD.CLP_GUEST_CARD IS NULL ORDER BY CED.CED_REC_VER, CTD.CLP_GUEST_CARD ASC");
            $result = $queryCustomer->result_array();
            $resultcount=$this->db->affected_rows();
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $servicedoc= $this->Mdl_eilib_common_function->get_service_document();
            for ($s = 0; $s < $resultcount; $s++) {
                $CTermExtn_caleventcount = $CTermExtn_caleventcount + 1;
                $CTermExtn_gstcard = $result[$s]["CLP_GUEST_CARD"];
                if ($CTermExtn_gstcard == null) {
                    $CTermExtn_custfirstname = $result[$s]["CUSTOMER_FIRST_NAME"];
                    $CTermExtn_custlastname = $result[$s]["CUSTOMER_LAST_NAME"];
                    $CTermExtn_stdate = $result[$s]["CLP_STARTDATE"];
                    $CTermExtn_stdate1 = $result[$s]["CLP_STARTDATE"];//get time--date
                    $CTermExtn_eddate = $result[$s]["CLP_ENDDATE"];
                    $CTermExtn_eddate1 = $result[$s]["CLP_ENDDATE"];//get time with date
                    $CTermExtn_ptddate = $result[$s]["CLP_PRETERMINATE_DATE"];
                    $CTermExtn_start_time_in = $result[$s]["CED_SD_STIME"];
                    $CTermExtn_start_time_out = $result[$s]["CED_SD_ETIME"];
                    $CTermExtn_end_time_in = $result[$s]["CED_ED_STIME"];
                    $CTermExtn_end_time_out = $result[$s]["CED_ED_ETIME"];
                    $CTermExtn_recversion = $result[$s]["CED_REC_VER"];
                    $finalResult[] = array('sddate' => $result[$s]['CLP_STARTDATE'], 'sdtimein' => $result[$s]['CED_SD_STIME'], 'sdtimeout' => $result[$s]['CED_SD_ETIME'], 'eddate' => $result[$s]['CLP_STARTDATE'], 'edtimein' => $result[$s]['CLP_STARTDATE'], 'edtimeout' => $result[$s]['CLP_STARTDATE']);
                }
                if ($CTermExtn_ptddate != null) {
                    $CTermExtn_ptddate1 = $result[$s]["CLP_PRETERMINATE_DATE"];//.getTime();
                } else {
                    $CTermExtn_ptddate1 = $CTermExtn_eddate1;
                }
                if (($CTermExtn_ptddate != null && ($ctermformname == "TERMINATION" && $CTermExtn_recversion <= $CTermExtn_recver && $successflag == 1))) {
                }
                if (($CTermExtn_ptddate != null && ($ctermformname == "TERMINATION" && $successflag == 0)) || ($CTermExtn_ptddate != null && ($ctermformname == "TERMINATION" && $CTermExtn_recversion <= $CTermExtn_recver && $successflag == 1)) || ($CTermExtn_ptddate != null && $ctermformname == "EXTENSION")) {
                    $CTermExtn_eddate = $CTermExtn_ptddate;
                }
                //call cal event delete function from eilib

                $cal_del_flag=$this->CUST_customerTermcalenderdeletion($calPrimary, $CTermExtn_custid, $CTermExtn_stdate, $CTermExtn_start_time_in, $CTermExtn_start_time_out, $CTermExtn_eddate, $CTermExtn_end_time_in, $CTermExtn_end_time_out, "");
                $CTermExtn_custunittype = "";
                $CTermExtn_mobile = $result[$s]["CPD_MOBILE"];
                $CTermExtn_intmoblie = $result[$s]["CPD_INTL_MOBILE"];
                $CTermExtn_office = $result[$s]["CCD_OFFICE_NO"];
                $CTermExtn_emailid = $result[$s]["CPD_EMAIL"];
                $CTermExtn_unitno = $result[$s]["UNIT_NO"];
                $CTermExtn_roomtype = $result[$s]["URTD_ROOM_TYPE"];
                $date1 = new DateTime("now");
                $date2 = new DateTime("tomorrow");

                if (new DateTime($CTermExtn_ptddate1) > new DateTime($CTermExtn_stdate1))//new Date(Utilities.formatDate(new Date(CTermExtn_ptddate1),TimeZone, 'yyyy/MM/dd 00:00:00'))<=new Date(Utilities.formatDate(new Date(CTermExtn_eddate1),TimeZone, 'yyyy/MM/dd 00:00:00')))
                {
                    $CTermExtn_prevunitno [] = $result[$s]["UNIT_NO"];
                    $CTermExtn_prevroomtype[] = $result[$s]["URTD_ROOM_TYPE"];
                    if ($CTermExtn_caleventcount > 1) {
                        if ($CTermExtn_unitno != $CTermExtn_prevunitno[$i - 1] && $CTermExtn_prevunitno[$i - 1] != "undefined") {
                            $CTermExtn_custunittype = "DIFF UNIT";
                        } else {
                            if ($CTermExtn_roomtype != $CTermExtn_prevroomtype[$i - 1] && $CTermExtn_prevroomtype[$i - 1] != "undefined") {
                                $CTermExtn_custunittype = "DIFF RM";
                            } else {
                                $CTermExtn_stdate = "";
                                $CTermExtn_start_time_in = "";
                                $CTermExtn_start_time_out = "";
                            }
                        }
                    }
                    $folderIdCustomer=$this->Mdl_eilib_calender->getcustomerfileid($servicedoc,$CTermExtn_custid);
                    if ($CTermExtn_recversion == $CTermExtn_recver) {
                        $this->CUST_customercalendercreation($folderIdCustomer,$calPrimary, $CTermExtn_custid, $CTermExtn_stdate, $CTermExtn_start_time_in, $CTermExtn_start_time_out, $CTermExtn_eddate, $CTermExtn_end_time_in, $CTermExtn_end_time_out, $CTermExtn_custfirstname, $CTermExtn_custlastname, $CTermExtn_mobile, $CTermExtn_intmoblie, $CTermExtn_office, $CTermExtn_emailid, $CTermExtn_unitno, $CTermExtn_roomtype, $CTermExtn_custunittype);
                        $CTermExtn_calevntchk_flag = 1;
                    }
                    if ($CTermExtn_calevntchk_flag == 0) {
                        $this->CUST_customercalendercreation($folderIdCustomer,$calPrimary, $CTermExtn_custid, $CTermExtn_stdate, $CTermExtn_start_time_in, $CTermExtn_start_time_out, "", "", "", $CTermExtn_custfirstname, $CTermExtn_custlastname, $CTermExtn_mobile, $CTermExtn_intmoblie, $CTermExtn_office, $CTermExtn_emailid, $CTermExtn_unitno, $CTermExtn_roomtype, $CTermExtn_custunittype);
                    }
                }
                $i = $i + 1;
            }
            return 1;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
    //FUNCTION TO GET EVENTS BEFORE UPDATE TABLE
    public function CTermExtn_GetCalevent($CTermExtn_custid)
    {
        $sql = "CALL SP_CUSTOMER_MIN_MAX_RV(".$CTermExtn_custid.",@MIN_LP,@MAX_LP)";
        $this->db->query($sql);
        $this->db->select('@MIN_LP AS MIN,@MAX_LP AS MAX', FALSE);
        $minLP = $this->db->get()->row()->MIN;
        $queryCustomer=$this->db->query("SELECT  C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CED.CED_REC_VER,CTD.CLP_GUEST_CARD,CTD.CLP_STARTDATE,IF(CTD.CLP_PRETERMINATE_DATE IS NULL,CTD.CLP_ENDDATE ,CTD.CLP_PRETERMINATE_DATE) AS ENDDATE,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CCD.CCD_OFFICE_NO,CPD.CPD_EMAIL,U.UNIT_NO,URTD.URTD_ROOM_TYPE,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME, CTPD.CTP_DATA AS CED_ED_ETIME FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE CTPA ON CED.CED_SD_STIME = CTPA.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPB ON CED.CED_SD_ETIME = CTPB.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPC ON CED.CED_ED_STIME = CTPC.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPD ON CED.CED_ED_ETIME = CTPD.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CTD,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U,CUSTOMER C WHERE  CED.UNIT_ID=U.UNIT_ID AND (CED.CUSTOMER_ID=".$CTermExtn_custid.")AND (CTD.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CTD.CED_REC_VER) AND (CTD.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS  NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)  AND (C.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CTD.CUSTOMER_ID=C.CUSTOMER_ID) AND CED.CED_REC_VER>=".$minLP." AND CTD.CLP_GUEST_CARD IS NULL ORDER BY CED.CED_REC_VER, CTD.CLP_GUEST_CARD ASC");
        $result =$queryCustomer->result_array();
        $resultcount=$this->db->affected_rows();
        for ($s=0;$s<$resultcount;$s++)
        {
            $finalResult[]=array('sddate'=>$result[$s]['CLP_STARTDATE'],'sdtimein'=>$result[$s]['CED_SD_STIME'],'sdtimeout'=>$result[$s]['CED_SD_ETIME'],'eddate'=>$result[$s]['ENDDATE'],'edtimein'=>$result[$s]['CED_SD_STIME'],'edtimeout'=>$result[$s]['CED_SD_ETIME']);
        }
        return $finalResult;
    }
    public function getCustomerfolderid($Customerid){
        $result=[];
        $selectquery="SELECT CUFD_CUSTOMER_FOLDER_ID FROM  CUSTOMER_FILE_DIRECTORY WHERE  CUSTOMER_ID='$Customerid' ";
        $resultset=$this->db->query($selectquery);
        foreach ($resultset->result_array() as $key=>$val)
        {
            $result[]=$val['CUFD_CUSTOMER_FOLDER_ID'];
        }

        return $result;
    }
    //function get all upload file
    public function getcustomerfileid($service,$Customerid){
        $cust_folder_id=$this->getCustomerfolderid($Customerid);
        $emp_uploadfilenamelist=array();
        for($i=0;$i<count($cust_folder_id);$i++){
            $children1 = $service->children->listChildren($cust_folder_id[$i]);
            $filearray1=$children1->getItems();
            foreach ($filearray1 as $child1) {
                $file = $service->files->get($child1->getId());
                $MIME_type= $file->getMimeType();
                if($MIME_type=='application/pdf')
                    $emp_uploadfilenamelist[]=($child1->getId());
            }

        }

        return $emp_uploadfilenamelist;
    }
}