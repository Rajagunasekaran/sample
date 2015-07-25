<?php
//******************************************Card Assign********************************************//
//VER 0.01-SD:04/05/2015 ED:07/05/2015,initial version BY RAJA
//*******************************************************************************************************//
class Mdl_access_card_card_assign extends CI_Model{
    public function Initial_data($ErrorMessage){
        $this->db->select('UNIT_ID,UNIT_NO,CED_REC_VER,CUSTOMER_ID,CUSTOMERNAME,DATE_FORMAT(CLP_STARTDATE,"%d-%m-%Y") as CLP_STARTDATE,DATE_FORMAT(CLP_ENDDATE,"%d-%m-%Y") as CLP_ENDDATE,DATE_FORMAT(CLP_PRETERMINATE_DATE,"%d-%m-%Y") as CLP_PRETERMINATE_DATE');
        $this->db->from('VW_CARDASSIGN');
        $this->db->order_by('UNIT_NO');
        $this->db->order_by('CUSTOMERNAME');
        $this->db->order_by('CED_REC_VER');
        $query = $this->db->get();
        $result1 = $query->result();
        $resultset=array($result1,$ErrorMessage);
        return $resultset;
    }
    public function Customer_details($CA_recver,$CA_unit,$CA_cust_id,$USERSTAMP){
        $flag=0;
        $prev_recver='';
        $CA_custid=$CA_cust_id;
        $this->db->select('CLP.UASD_ID');
        $this->db->from('CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED');
        $this->db->where('CLP.CUSTOMER_ID='.$CA_custid.' AND CED.CED_REC_VER='.($CA_recver-1).' and CLP.CUSTOMER_ID=CED.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND CED.CED_PRETERMINATE IS NOT NULL AND CLP.UASD_ID IS NULL AND CLP.CED_REC_VER IN (SELECT CED_REC_VER  FROM VW_CARDASSIGN WHERE CUSTOMER_ID='.$CA_custid.')');
        $query = $this->db->get();
        $resultrow = $query->result();
        if(count($resultrow)>=1){
            $flag=1;
            $prev_recver=$CA_recver-1;
        }
        if($flag==1){
            $this->db->select('CLP.UASD_ID');
            $this->db->from('CUSTOMER_LP_DETAILS CLP,CUSTOMER_ENTRY_DETAILS CED');
            $this->db->where('CLP.CUSTOMER_ID='.$CA_custid.' AND CED.CED_REC_VER='.($prev_recver-1).' and CLP.CUSTOMER_ID=CED.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND CED.CED_PRETERMINATE IS NOT NULL AND CLP.UASD_ID IS NULL and CLP.CED_REC_VER in (SELECT CED_REC_VER  FROM VW_CARDASSIGN WHERE CUSTOMER_ID='.$CA_custid.')');
            $query = $this->db->get();
            $resultrow1 = $query->result();
            if(count($resultrow1)>=1){
                $prev_recver=$prev_recver-1;
            }
        }
        $CA_today_date=date('Y-M-d');
        $this->db->select('URTD.URTD_ROOM_TYPE');
        $this->db->from('UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD,CUSTOMER_ENTRY_DETAILS CED');
        $this->db->where('(CED.CUSTOMER_ID='.$CA_custid.') AND (CED.CED_REC_VER='.$CA_recver.') AND (UASD.UASD_ID=CED.UASD_ID) AND (UASD.URTD_ID=URTD.URTD_ID)');
        $roomtype = $this->db->get();
        $CA_roomtype = $roomtype->row()->URTD_ROOM_TYPE;
        $callquery="CALL SP_CUSTOMER_CARD_ASSIGN_TEMP_FEE_DETAIL(".$CA_custid.",'".$USERSTAMP."',@CARD_FEETMPTBLNAM)";
        $this->db->query($callquery);
        $outparm_query = 'SELECT @CARD_FEETMPTBLNAM AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $tablename=$outparm_result->row()->TEMP_TABLE;
        $this->db->select();
        $this->db->from('CUSTOMER_ENTRY_DETAILS CED,NATIONALITY_CONFIGURATION NC,UNIT U');
        $this->db->join('CUSTOMER_COMPANY_DETAILS CCD', 'CED.CUSTOMER_ID=CCD.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_LP_DETAILS CLP', 'CED.CUSTOMER_ID=CLP.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_ACCESS_CARD_DETAILS CACD', 'CLP.CUSTOMER_ID=CACD.CUSTOMER_ID AND CLP.UASD_ID=CACD.UASD_ID' , 'left');
        $this->db->join('UNIT_ACCESS_STAMP_DETAILS UASD', 'CLP.UASD_ID=UASD.UASD_ID AND CACD.UASD_ID=UASD.UASD_ID' , 'left');
        $this->db->join($tablename.' CF', 'CED.CUSTOMER_ID=CF.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER C', 'CED.CUSTOMER_ID=C.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_PERSONAL_DETAILS CPD', 'CED.CUSTOMER_ID=CPD.CUSTOMER_ID' , 'left');
        $this->db->where('U.UNIT_ID=CED.UNIT_ID AND CLP.CUSTOMER_ID=CED.CUSTOMER_ID AND CLP.CED_REC_VER=CED.CED_REC_VER AND CLP.CLP_TERMINATE IS NULL AND CACD.CACD_VALID_TILL IS NULL AND (CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='.$CA_custid.') AND (CPD.NC_ID=NC.NC_ID) AND (CED.CED_REC_VER=CF.CUSTOMER_VER) AND (CED.CED_REC_VER='.$CA_recver.') AND CED.CED_REC_VER=CLP.CED_REC_VER');
        $this->db->order_by('CED.CED_REC_VER');
        $query = $this->db->get();
        $CA_guest_array=[];
        $CA_cardno='';
        foreach ($query->result_array() as $row)
        {
            $CA_cardno2 = $row["UASD_ACCESS_CARD"];
            if($CA_cardno2!=null){
                $CA_guestcardno = $row["CLP_GUEST_CARD"];
                if($CA_guestcardno!='X'){
                    $CA_cardno = $row["UASD_ACCESS_CARD"];
                    $CA_startdate = $row["CLP_STARTDATE"];
                    $CA_enddate = $row["CLP_ENDDATE"];
                }
                else {
                    $CA_cardno1 = $row["UASD_ACCESS_CARD"];
                    $CA_guest_array[]=$CA_cardno1;
                }
            }
            else{
                $CA_startdate = $row["CLP_STARTDATE"];
                $CA_enddate = $row["CLP_ENDDATE"];
            }
            $CA_company = $row["CCD_COMPANY_NAME"];
            $CA_firstname = $row["CUSTOMER_FIRST_NAME"];
            $CA_lastname = $row["CUSTOMER_LAST_NAME"];
            $CA_deposit = $row["CC_DEPOSIT"];
            $CA_rental = $row["CC_PAYMENT_AMOUNT"];
            $CA_electricitycap = $row["CC_ELECTRICITY_CAP"];
            $CA_airconfixedfee = $row["CC_AIRCON_FIXED_FEE"];
            $CA_airconquartelyfee = $row["CC_AIRCON_QUARTERLY_FEE"];
            $CA_epno = $row["CPD_EP_NO"];
            $CA_epdate = $row["CPD_EP_DATE"];
            $CA_passportno = $row["CPD_PASSPORT_NO"];
            $CA_passportdate = $row["CPD_PASSPORT_DATE"];
            $CA_drycleanfee = $row["CC_DRYCLEAN_FEE"];
            $CA_processingfee = $row["CC_PROCESSING_FEE"];
            $CA_checkoutcleaningfee = $row["CC_CHECKOUT_CLEANING_FEE"];
            $CA_noticeperiod = $row["CED_NOTICE_PERIOD"];
            $CA_noticedate = $row["CED_NOTICE_START_DATE"];
            $CA_nationality = $row["NC_DATA"];
            $CA_dob= $row["CPD_DOB"];
            $CA_lease=$row["CED_LEASE_PERIOD"];
            $CA_mobile = $row["CPD_MOBILE"];
            $CA_mobile1 = $row["CPD_INTL_MOBILE"];
            $CA_officeno = $row["CCD_OFFICE_NO"];
            $CA_email = $row["CPD_EMAIL"];
            $CA_extension= $row["CED_EXTENSION"];
            $CA_redver = $row["CED_REC_VER"];
            $CA_canceldate = $row["CED_CANCEL_DATE"];
            $CA_comments = $row["CPD_COMMENTS"];
            $CA_QUARTERS=$row["CED_QUARTERS"];
        }
        $CA_alldetails_array=array('firstname'=>$CA_firstname,'lastname'=>$CA_lastname,'email'=>$CA_email,'mobile1'=>$CA_mobile,'mobile2'=>$CA_mobile1,'officeno'=>$CA_officeno,'dob'=>$CA_dob,'passportno'=>$CA_passportno,'passportdate'=>$CA_passportdate,'epno'=>$CA_epno,'epdate'=>$CA_epdate,'roomtype'=>$CA_roomtype,'cardno'=>$CA_cardno,'startdate'=>$CA_startdate,'enddate'=>$CA_enddate,'lease'=>$CA_lease,'QUARTERS'=>$CA_QUARTERS,'noticeperiod'=>$CA_noticeperiod,'noticedate'=>$CA_noticedate,'electricitycap'=>$CA_electricitycap,'drycleanfee'=>$CA_drycleanfee,'checkoutcleaningfee'=>$CA_checkoutcleaningfee,'deposit'=>$CA_deposit,'rental'=>$CA_rental,'processingfee'=>$CA_processingfee,'comments'=>$CA_comments,'company'=>$CA_company,'nationality'=>$CA_nationality,'airconfixedfee'=>$CA_airconfixedfee,'airconquartelyfee'=>$CA_airconquartelyfee);
        $CA_guest_array=array_values(array_unique($CA_guest_array));
        $CA_available_cards=$this->CA_show_availablecards($CA_unit,$CA_firstname,$CA_lastname,$CA_recver,$CA_custid);
        $CA_alldata_array=array($CA_alldetails_array,$CA_guest_array,$CA_available_cards,$flag,$prev_recver);
        $drop_query = "DROP TABLE ".$tablename;
        $this->db->query($drop_query);
        return ($CA_alldata_array);
    }
    public function CA_show_availablecards($CA_unit,$CA_firstname,$CA_lastname,$CA_recver,$CA_custid){
        $CA_returnarray=[];
        $CA_cust_cardarray=[];
        $CA_avail_cardarray=[];
        $CA_customername=$CA_firstname.' '.$CA_lastname;
        $CA_customername1=$CA_firstname.'_'.$CA_lastname;
        $CA_customername1=str_replace(' ',"__",$CA_customername1);
        $this->db->select();
        $this->db->distinct();
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS UASD');
        $this->db->join('CUSTOMER_LP_DETAILS CLP', 'UASD.UASD_ID=CLP.UASD_ID' , 'left');
        $this->db->join('CUSTOMER C', 'CLP.CUSTOMER_ID=C.CUSTOMER_ID' , 'left');
        $this->db->join('CUSTOMER_ACCESS_CARD_DETAILS CACD', 'CLP.CUSTOMER_ID=CACD.CUSTOMER_ID AND UASD.UASD_ID=CACD.UASD_ID' , 'left');
        $this->db->where('(CLP.CUSTOMER_ID='.$CA_custid.') AND (CLP.CLP_TERMINATE IS NULL) AND CACD.ACN_ID IS NULL AND CLP.CED_REC_VER='.$CA_recver);
        $this->db->group_by('UASD_ACCESS_CARD');
        $this->db->order_by('CLP_GUEST_CARD');
        $CA_cust_access_card_rs = $this->db->get();
        $CA_cardno='';
        foreach ($CA_cust_access_card_rs->result_array() as $row)
        {
            $CA_cardno = $row["UASD_ACCESS_CARD"];
            $first_name=$row["CUSTOMER_FIRST_NAME"];
            $second_name=$row["CUSTOMER_LAST_NAME"];
            $guest_card=$row["CLP_GUEST_CARD"];
            $first_name=str_replace(' ',"__",$first_name);
            $second_name=str_replace(' ',"__",$second_name);
            if($CA_cardno=="")continue;
            else
            {
                if($guest_card!='X'){
                    $CA_cust_cardarray[]=$CA_cardno.'/'.$first_name.'_'.$second_name;
                }
                else{
                    $CA_cust_cardarray[]=$CA_cardno.'/'."GUEST";
                }
            }
        }
        $this->db->select('UASD_ACCESS_CARD');
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS');
        $this->db->where('UNIT_ID IN (SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='.$CA_unit.') AND UASD_ACCESS_INVENTORY="X" AND UASD_ACCESS_CARD IS NOT NULL');
        $this->db->order_by('UASD_ACCESS_CARD');
        $CA_access_card = $this->db->get();
        foreach ($CA_access_card->result_array() as $row)
        {
            $CA_avail_cardarray[]=$row["UASD_ACCESS_CARD"];
        }
        if(count($CA_cust_cardarray)==0){
            $CA_cardlbl_array=[];
            for($i=0;$i<count($CA_avail_cardarray);$i++)
            {
                if($i==0)
                {
                    $CA_cardlbl_array[]=$CA_customername1;
                }
                else if($i>0)
                {
                    $CA_cardlbl_array[]="GUEST ".$i;
                }
                if($i>2)break;
            }
        }
        else {
            $CA_total_card_lenth=count($CA_cust_cardarray)+count($CA_avail_cardarray);
            $CA_cardlbl_array=[];
            for($k=0;$k<$CA_total_card_lenth;$k++)
            {
                if($k==0)
                {
                    $CA_cardlbl_array[]=$CA_customername1;
                }
                else if($k>0)
                {
                    $CA_cardlbl_array[]="GUEST".$k;
                }
                if($k>2)break;
            }
        }
        $CA_returnarray=[$CA_cust_cardarray,$CA_avail_cardarray,$CA_cardlbl_array];
        return $CA_returnarray;
    }
    public function Cardassign_save($CA_custid,$CA_recver,$CA_comment,$CA_unitno,$CA_fname,$CA_lname,$CA_card_value,$CA_startdate,$CA_enddate,$CA_cardclick,$CA_card_no,$CA_namelist,$USERSTAMP){
        $CA_todaydate=date('Y-m-d');
        if($CA_startdate > $CA_todaydate){
            $CA_startdate_new=$CA_startdate;
        }
        else{
            $CA_startdate_new=$CA_todaydate;
        }
        $CA_userstamp=$USERSTAMP;
        $CA_accesscard="";
        $CA_guestcard="";
        $CA_cust_name=strtoupper($CA_fname."_".$CA_lname);
        $CA_cust_name=str_replace(' ',"__",$CA_cust_name);
        if($CA_card_no!=""){
            if((is_array($CA_card_no))==true){
                $old_card_array=$CA_card_no;
            }
            else
            {
                $old_card_array=$CA_card_no;
            }
        }
        if($CA_cardclick!="NULL")
        {
            if((is_array($CA_namelist))==true){
                $CA_cardlist_box=($CA_namelist);
            }
            else
            {
                $CA_cardlist_box=$CA_namelist;
            }
            $new_card_array=[];
            $cust_card='';
            $guest_card=[];
            $g_card=[];
            $guest1='undefined';$guest2='undefined';$guest3='undefined';
            for($i=0;$i<count($CA_cardlist_box);$i++){
                if($CA_cardlist_box[$i]=="")continue;
                $card=explode('/',$CA_cardlist_box[$i]);
                if($card[1]==$CA_cust_name){
                    if($CA_accesscard=="")
                    {
                        $CA_accesscard=$card[0];
                        $CA_guestcard=$card[0].','.' ';
                    }
                    else
                    {
                        $CA_accesscard=$CA_accesscard.','.$card[0];
                        $CA_guestcard=$CA_guestcard.','.$card[0].', ';
                    }
                    $cust_card=($card[0]);
                }
                else
                {
                    if(count($old_card_array)!=0){
                        if($card[1]=="GUEST1"){
                            $guest1 =$card[0];
                        }
                        if($card[1]=="GUEST2"){
                            $guest2=$card[0];
                        }
                        if($card[1]=="GUEST3"){
                            $guest3=$card[0];
                        }
                    }
                    else{
                        $guest_card[]=($card[0]);            
                    }
                    if($CA_accesscard=="")
                    {
                        $CA_accesscard=$card[0];
                        $CA_guestcard=$card[0].',X';
                    }
                    else
                    {
                        $CA_accesscard=$CA_accesscard.','.$card[0];
                        $CA_guestcard=$CA_guestcard.','.$card[0].',X';
                    }
                    $g_card[]=($card[0]);
                }
            }
            $new_array=[];
            $new_array[]=($cust_card);
            for($i=0;$i<count($g_card);$i++){
                $new_array[]=($g_card[$i]);
            }
            if(count($old_card_array)!=0){
                if($guest1=='undefined')$guest1=' ';
                if($guest2=='undefined')$guest2=' ';
                if($guest3=='undefined')$guest3=' ';
                    $guest_card[]=($guest1);
                if(count($old_card_array)==3)
                    $guest_card[]=($guest2);
                if(count($old_card_array)==4)
                    $guest_card[]=($guest2);
                    $guest_card[]=($guest3);
            }
            $new_card_array[]=($cust_card);
            for($i=0;$i<count($guest_card);$i++){
                $new_card_array[]=($guest_card[$i]);
            }
            if(count($old_card_array) > count($new_array)){
                $new_card_array=$new_card_array;
            }
            else{
                $new_card_array=$new_array;
            }
        }
        if($CA_comment!=''){
            $CA_comment=$this->db->escape_like_str($CA_comment);
        }
        if(count($old_card_array!=0)){
            $card='';
        }
        else{
            $card=' ';
        }
        if($CA_cardclick!="NULL"){
            if(count($new_card_array)>=count($old_card_array))
            {
                for($j=0;$j<count($new_card_array);$j++)
                {
                    $keyindex=array_key_exists($j,$old_card_array);
                    if($keyindex!=1){
                        $old_card_array[$j]=' ';
                    }
                    $card.=$old_card_array[$j].','.$new_card_array[$j];
                    if($j==count($new_card_array)-1)break;
                    {
                        $card.=',';
                    }
                }
            }
        }
        if($CA_cardclick=='CARD')
        {
            $CA_save_stmt="CALL SP_CUSTOMER_CARDASSIGN_INSERT(".$CA_custid.",".$CA_unitno.",".$CA_recver.",'".$card."','".$CA_startdate_new."','".$CA_guestcard."','".$CA_startdate_new."','".$CA_enddate."','".$CA_comment."','".$CA_userstamp."',@card_flag)";
        }
        else
        {
            $CA_save_stmt="CALL SP_CUSTOMER_CARDASSIGN_INSERT(".$CA_custid.",".$CA_unitno.",".$CA_recver.",' ','".$CA_startdate_new."',' ','".$CA_startdate_new."','".$CA_enddate."','".$CA_comment."','".$CA_userstamp."',@card_flag)";
        }
        $this->db->query($CA_save_stmt);
        $outparm_query = 'SELECT @card_flag AS card_flag';
        $outparm_result = $this->db->query($outparm_query);
        $card_flag=$outparm_result->row()->card_flag;
        return $card_flag;
    }
}