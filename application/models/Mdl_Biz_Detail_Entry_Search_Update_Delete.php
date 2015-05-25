<?php
Class Mdl_biz_detail_entry_search_update_delete extends CI_Model {

    public function BDTL_INPUT_expense_err_invoice()
    {
    $BDTL_INPUT_biz_expense_type_array = [];
    $BDTL_INPUT_bizexp_invoiceto_array = [];
    $BDTL_INPUT_arr_aircon=[];
    $this->load->model('Eilib/Common_function');
    $BDTL_INPUT_biz_detail_error_array=$this->Common_function->GetErrorMessageList('1,2,103,105,238,248,400,458');
    $BDTL_INPUT_check_unitflag=false;
    $this->db->select("UNIT_ID");
    $this->db->from("UNIT");
    $BDTL_INPUT_checkunit_rs= $this->db->get();
    foreach ($BDTL_INPUT_checkunit_rs->result_array() as $row)
        $BDTL_INPUT_check_unitflag=true;
    if($BDTL_INPUT_check_unitflag==true){
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("ECN_ID IN (16,17,15,13,14,19,20,21,200)");
        $this->db->order_by("ECN_DATA", "asc");
        $BDTL_INPUT_type_rs = $this->db->get();
        foreach ($BDTL_INPUT_type_rs->result_array() as $row)
        {
            if($row['ECN_ID']==200)
            $BDTL_INPUT_configmonth=$row['ECN_DATA'];
        else if(($row['ECN_ID']==19)||($row['ECN_ID']==20)||($row['ECN_ID']==21))
                $BDTL_INPUT_bizexp_invoiceto_array[]=["BDTL_INPUT_expensetypes_id"=>$row['ECN_ID'],"BDTL_INPUT_expensetypes_data"=>$row['ECN_DATA']];
        else{
                $BDTL_INPUT_biz_expense_type_array[]=["BDTL_INPUT_expensetypes_id"=>$row['ECN_ID'],"BDTL_INPUT_expensetypes_data"=>$row['ECN_DATA']];
        }}
        $BDTL_INPUT_arr_aircon=$this->BDTL_INPUT_aircon_list();
    }
    $BDTL_INPUT_result=[];
        $BDTL_INPUT_result=["BDTL_INPUT_error"=>$BDTL_INPUT_biz_detail_error_array,"BDTL_INPUT_expense"=>$BDTL_INPUT_biz_expense_type_array,"BDTL_INPUT_invoice"=>$BDTL_INPUT_bizexp_invoiceto_array,"BDTL_INPUT_obj_unitflag"=>$BDTL_INPUT_check_unitflag,"BDTL_INPUT_obj_aircon"=>$BDTL_INPUT_arr_aircon,"BDTL_INPUT_obj_configmonth"=>$BDTL_INPUT_configmonth];
    return $BDTL_INPUT_result;
  }
    /*----------------------------------------------CODING TO GET AIRCON SERVICED BY DATA LIST-------------------------------------------------*/
    public function BDTL_INPUT_aircon_list()
    {
        $BDTL_INPUT_aircon_data_array = [];
        $this->db->select("EASB_DATA");
        $this->db->from("EXPENSE_AIRCON_SERVICE_BY");
        $this->db->where('EASB_DATA IS NOT NULL');
        $this->db->order_by("EASB_DATA", "asc");
        $BDTL_INPUT_aircon_datas_rs = $this->db->get();
        foreach ($BDTL_INPUT_aircon_datas_rs->result_array() as $row)
        {
            $BDTL_INPUT_aircon_data_array[]=$row["EASB_DATA"];
        }
        return $BDTL_INPUT_aircon_data_array;
    }
    /*-----------------------------------------CODING TO GET UNIT NO FROM UNIT TABLE------------------------------------------------------------------*/
    public function BDTL_INPUT_all_exp_types_unitno($BDTL_INPUT_all_expense_types)
    {
      $BDTL_INPUT_bizexp_alltypes='';
      $BDTL_INPUT_bizexp_unitno_array = [];
      $BDTL_INPUT_twodimen=[16=>['EDAS_ID','EXPENSE_DETAIL_AIRCON_SERVICE'],17=>['EDCP_ID','EXPENSE_DETAIL_CARPARK'],15=>['EDDV_ID','EXPENSE_DETAIL_DIGITAL_VOICE'],
                             13=>['EDE_ID','EXPENSE_DETAIL_ELECTRICITY'],14=>['EDSH_ID','EXPENSE_DETAIL_STARHUB']];
    $BDTL_INPUT_expunitnumbers = "SELECT UNIT_ID,UNIT_NO FROM UNIT WHERE UNIT_ID NOT IN (SELECT UNIT_ID FROM ".$BDTL_INPUT_twodimen[$BDTL_INPUT_all_expense_types][1].") ORDER BY UNIT_NO ASC";
    $BDTL_INPUT_expense_unitno_rs = $this->db->query($BDTL_INPUT_expunitnumbers);
    foreach($BDTL_INPUT_expense_unitno_rs->result_array() as $row)
    {
        $BDTL_INPUT_bizexp_unitno_array[]=["BDTL_INPUT_obj_unitid"=>$row['UNIT_ID'],"BDTL_INPUT_obj_unitno"=>$row['UNIT_NO']];
    }
    return $BDTL_INPUT_bizexp_unitno_array;
   }
    //FUNCTION TO GET UNIT SDATE AND EDATE
    public function BDTL_INPUT_get_SDate_EDate($BDTL_INPUT_unitno)
    {
        $this->load->model('Eilib/Common_function');
        $BDTL_INPUT_getDate=$this->Common_function->GetUnitSdEdate($BDTL_INPUT_unitno);
      return  $BDTL_INPUT_getDate;
    }
    /*------------------------------------CODING TO CHECK AIRCONSERVICE BY IN TABLE------------------------------------------------------*/
    public function BDTL_INPUT_airconservicedby_check($BDTL_INPUT_alreadyexists)
    {
      $BDTL_INPUT_airconservicedby_array = [];
      $this->load->model('Eilib/Common_function');
      $BDTL_INPUT_flag=$this->Common_function->Check_ExistsAirconservicedby($BDTL_INPUT_alreadyexists);
      return $BDTL_INPUT_flag;
   }
    /*--------------------------------------FUNCTION TO CHECK WHETHER THE DATA INSERTED OR NOT---------------------------------------*/
    public function BDTL_INPUT_getmaxprimaryid($BDTL_INPUT_profile_names){
       $BDTL_INPUT_twodimen=[17=>['EDCP_ID','EXPENSE_DETAIL_CARPARK'],15=>['EDDV_ID','EXPENSE_DETAIL_DIGITAL_VOICE'],
                             13=>['EDE_ID','EXPENSE_DETAIL_ELECTRICITY'],14=>['EDSH_ID','EXPENSE_DETAIL_STARHUB']];
        $id=$BDTL_INPUT_twodimen[$BDTL_INPUT_profile_names][0];
        $from=$BDTL_INPUT_twodimen[$BDTL_INPUT_profile_names][1];
        $BDTL_INPUT_select="SELECT MAX($id) AS PRIMARY_ID FROM $from";
        $BDTL_INPUT_rs_primaryid=$this->db->query($BDTL_INPUT_select);
        $BDTL_INPUT_primaryid=$BDTL_INPUT_rs_primaryid->row()->PRIMARY_ID;
        return $BDTL_INPUT_primaryid;
  }
    /*-----------------------------CODING TO SAVE THE AIRCON DETAIL,CARPARK,ELECTRICITY,DIGITAL VOICE,STARHUB IN DATABASE----------------------------------------------------------*/
    public function BDTL_INPUT_save($USERSTAMP,$BDTL_INPUT_tb_newaircon,$calid)
     {
          $BDTL_INPUT_aircon_list_ref=[];
          $BDTL_INPUT_expensetypes =$_POST['BDTL_INPUT_lb_expense_type'];
          $BDTL_INPUT_unitno =$_POST['BDTL_INPUT_lb_unitno_list'];
          $BDTL_INPUT_unitnoaircon =$_POST['BDTL_INPUT_hidden_unitno'];
          $BDTL_INPUT_aircon_oldservice = $_POST['BDTL_INPUT_lb_airconservicedby'];
          $BDTL_INPUT_aircon_newservice = $BDTL_INPUT_tb_newaircon;
          $BDTL_INPUT_aircon_comments=$_POST['BDTL_INPUT_ta_aircon_comments'];
          $BDTL_INPUT_aircon_comments=$this->db->escape_like_str($BDTL_INPUT_aircon_comments);
          $BDTL_INPUT_carno= $_POST['BDTL_INPUT_tb_exp_carno'];
          $BDTL_INPUT_car_comments= $_POST['BDTL_INPUT_ta_carpark_comments'];
          $BDTL_INPUT_digital_invoiceto= $_POST['BDTL_INPUT_lb_digital_invoiceto'];
          $BDTL_INPUT_digital_voice= $_POST['BDTL_INPUT_tb_exp_digivoiceno'];
          $BDTL_INPUT_digital_acctno= $_POST['BDTL_INPUT_tb_exp_digiaccno'];
          $BDTL_INPUT_digital_comments=$_POST['BDTL_INPUT_ta_digitalvoice_comments'];
          $BDTL_INPUT_electricity_invoice= $_POST['BDTL_INPUT_lb_bizdetail_electricity_invoiceto'];
          $BDTL_INPUT_electricity_comments=$_POST['BDTL_INPUT_ta_ectricity_comments'];
          $BDTL_INPUT_starhub_invoiceto= $_POST['BDTL_INPUT_lb_starhub_invoiceto'];
          $BDTL_INPUT_starhub_acctno= $_POST['BDTL_INPUT_tb_starhub_account_no'];
          $BDTL_INPUT_starhub_appldate= $_POST['BDTL_INPUT_db_appl_date'];
          $BDTL_INPUT_starhub_cable_startdate= $_POST['BDTL_INPUT_db_cable_startdate'];
          $BDTL_INPUT_starhub_cable_enddate= $_POST['BDTL_INPUT_db_cable_enddate'];
          $BDTL_INPUT_starhub_internet_startdate= $_POST['BDTL_INPUT_db_internet_startdate'];
          $BDTL_INPUT_starhub_internet_enddate= $_POST['BDTL_INPUT_db_internet_enddate'];
          $BDTL_INPUT_starhub_ssid=$_POST['BDTL_INPUT_tb_ssid'];
          $BDTL_INPUT_starhub_pwd=$_POST['BDTL_INPUT_tb_pwd'];
          $BDTL_INPUT_starhub_cable_serialno=$_POST['BDTL_INPUT_tb_cablebox_sno'];
          $BDTL_INPUT_starhub_modem_serialno=$_POST['BDTL_INPUT_tb_modem_sno'];
          $BDTL_INPUT_starhub_basicgroup=$_POST['BDTL_INPUT_ta_basic_group'];
          $BDTL_INPUT_starhub_addtnlch=$_POST['BDTL_INPUT_ta_addtl_ch'];
          $BDTL_INPUT_starhub_comments=$_POST['BDTL_INPUT_ta_starhub_comments'];
          if($BDTL_INPUT_expensetypes!=16)
        $BDTL_INPUT_primaryid_before=$this->BDTL_INPUT_getmaxprimaryid($BDTL_INPUT_expensetypes);
        $BDTL_INPUT_aircon_finalservice ='';
         $BDTL_INPUT_starhub_cablestartdate_shtime='';
         $BDTL_INPUT_starhub_cableenddate_shtime='';
         $BDTL_INPUT_starhub_internetstartdate_shtime='';
         $BDTL_INPUT_starhub_internetenddate_shtime='';
      if(($BDTL_INPUT_aircon_newservice!='')&&($BDTL_INPUT_aircon_newservice!='undefined'))
          $BDTL_INPUT_aircon_finalservice=$BDTL_INPUT_aircon_newservice;
      else
          $BDTL_INPUT_aircon_finalservice=$BDTL_INPUT_aircon_oldservice;

      if($BDTL_INPUT_digital_invoiceto=='SELECT')
      {
          $BDTL_INPUT_digital_invoiceto='null';
      }
      else
          $BDTL_INPUT_digital_invoiceto="'$BDTL_INPUT_digital_invoiceto'";

      if($BDTL_INPUT_electricity_invoice=='SELECT')
          $BDTL_INPUT_electricity_invoice='null';
      else
          $BDTL_INPUT_electricity_invoice="'$BDTL_INPUT_electricity_invoice'";

      if(($BDTL_INPUT_starhub_invoiceto=='SELECT')||($BDTL_INPUT_starhub_invoiceto==''))
      {
          $BDTL_INPUT_starhub_invoiceto='null';
          $BDTL_INPUT_starhub_ecnid='null';
      }
      else
          $BDTL_INPUT_starhub_invoiceto="'$BDTL_INPUT_starhub_invoiceto'";

      if($BDTL_INPUT_starhub_appldate=="")
          $BDTL_INPUT_starhub_appldate='null';
      else
      {
          $BDTL_INPUT_starhub_appldate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_appldate));
        $BDTL_INPUT_starhub_appldate="'$BDTL_INPUT_starhub_appldate'";
      }
      if($BDTL_INPUT_starhub_cable_startdate=="")
          $BDTL_INPUT_starhub_cable_startdate='null';
      else
      {
          $BDTL_INPUT_starhub_cablestartdate_shtime=date('Y-m-d',strtotime($BDTL_INPUT_starhub_cable_startdate));
          $BDTL_INPUT_starhub_cable_startdate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_cable_startdate));
        $BDTL_INPUT_starhub_cable_startdate="'$BDTL_INPUT_starhub_cable_startdate'";
      }
      if($BDTL_INPUT_starhub_cable_enddate=="")
          $BDTL_INPUT_starhub_cable_enddate='null';
      else
      {
          $BDTL_INPUT_starhub_cableenddate_shtime=date('Y-m-d',strtotime($BDTL_INPUT_starhub_cable_enddate));
          $BDTL_INPUT_starhub_cable_enddate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_cable_enddate));
        $BDTL_INPUT_starhub_cable_enddate="'$BDTL_INPUT_starhub_cable_enddate'";
      }
      if($BDTL_INPUT_starhub_internet_startdate=="")
          $BDTL_INPUT_starhub_internet_startdate='null';
      else
      {
          $BDTL_INPUT_starhub_internetstartdate_shtime=date('Y-m-d',strtotime($BDTL_INPUT_starhub_internet_startdate));
          $BDTL_INPUT_starhub_internet_startdate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_internet_startdate));
        $BDTL_INPUT_starhub_internet_startdate="'$BDTL_INPUT_starhub_internet_startdate'";
      }
      if($BDTL_INPUT_starhub_internet_enddate=="")
          $BDTL_INPUT_starhub_internet_enddate='null';
      else
      {
          $BDTL_INPUT_starhub_internetenddate_shtime=date('Y-m-d',strtotime($BDTL_INPUT_starhub_internet_enddate));
          $BDTL_INPUT_starhub_internet_enddate = date('Y-m-d',strtotime($BDTL_INPUT_starhub_internet_enddate));
        $BDTL_INPUT_starhub_internet_enddate="'$BDTL_INPUT_starhub_internet_enddate'";
      }
      /*-----------------------------------INSERT CODING FOR AIRCON----------------------------------------*/
      if($BDTL_INPUT_expensetypes==16)
      {
          $BDTL_INPUT_aircon_sp =$this->db->query("CALL SP_BIZDTL_AIRCON_SERVICE_BY_INSERT('$BDTL_INPUT_unitnoaircon','$BDTL_INPUT_aircon_finalservice','$BDTL_INPUT_aircon_comments','$USERSTAMP',@FLAG)");
          $BDTL_INPUT_flag_rs=$this->db->query("SELECT @FLAG as FLAG");
          $BDTL_INPUT_saveflag=$BDTL_INPUT_flag_rs->row()->FLAG;
          $BDTL_INPUT_aircon_list_ref=$this->BDTL_INPUT_aircon_list();
      }
      /*-----------------------------------INSERT CODING FOR CARPARK----------------------------------------*/
      else if($BDTL_INPUT_expensetypes==17)
      {
          if($BDTL_INPUT_car_comments=="")//COMMENTS
          {
              $BDTL_INPUT_car_comments='null';
          }else{
              $BDTL_INPUT_car_comments=$this->db->escape_like_str($BDTL_INPUT_car_comments);
              $BDTL_INPUT_car_comments="'$BDTL_INPUT_car_comments'";
          }
          $BDTL_INPUT_carpark_insert =$this->db->query("INSERT INTO EXPENSE_DETAIL_CARPARK(ULD_ID,UNIT_ID,EDCP_REC_VER,EDCP_CAR_NO,EDCP_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$BDTL_INPUT_unitno','1','$BDTL_INPUT_carno',$BDTL_INPUT_car_comments)");
      }
      /*-----------------------------------INSERT CODING FOR DIGITAL VOICE----------------------------------------*/
      else if($BDTL_INPUT_expensetypes==15)
      {
          if($BDTL_INPUT_digital_comments=="")//COMMENTS
          {
              $BDTL_INPUT_digital_comments='null';
          }else{
              $BDTL_INPUT_digital_comments=$this->db->escape_like_str($BDTL_INPUT_digital_comments);
              $BDTL_INPUT_digital_comments="'$BDTL_INPUT_digital_comments'";
          }

        $BDTL_INPUT_insert_digitalvoice = $this->db->query("INSERT INTO EXPENSE_DETAIL_DIGITAL_VOICE(UNIT_ID,ECN_ID,EDDV_REC_VER,EDDV_DIGITAL_VOICE_NO,EDDV_DIGITAL_ACCOUNT_NO,EDDV_COMMENTS,ULD_ID) VALUES('$BDTL_INPUT_unitno',$BDTL_INPUT_digital_invoiceto,'1','$BDTL_INPUT_digital_voice','$BDTL_INPUT_digital_acctno',$BDTL_INPUT_digital_comments,(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'))");
      }
      /*-----------------------------------INSERT CODING FOR ELECTRICITY----------------------------------------*/
      else if($BDTL_INPUT_expensetypes==13)
      {
          if($BDTL_INPUT_electricity_comments=="")//COMMENTS
          {
              $BDTL_INPUT_electricity_comments='null';
          }else{
              $BDTL_INPUT_electricity_comments=$this->db->escape_like_str($BDTL_INPUT_electricity_comments);
              $BDTL_INPUT_electricity_comments="'$BDTL_INPUT_electricity_comments'";
          }
          $BDTL_INPUT_insert_electricity = $this->db->query("INSERT INTO EXPENSE_DETAIL_ELECTRICITY(ULD_ID,UNIT_ID,EDE_REC_VER,ECN_ID,EDE_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$BDTL_INPUT_unitno','1',$BDTL_INPUT_electricity_invoice,$BDTL_INPUT_electricity_comments)");
      }
      /*-----------------------------------INSERT CODING FOR STARHUB----------------------------------------*/
      else if($BDTL_INPUT_expensetypes==14)
      {
        if($BDTL_INPUT_starhub_ssid=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_ssid='null';
        }else{
            $BDTL_INPUT_starhub_ssid=$this->db->escape_like_str($BDTL_INPUT_starhub_ssid);
            $BDTL_INPUT_starhub_ssid="'$BDTL_INPUT_starhub_ssid'";
        }
        if($BDTL_INPUT_starhub_pwd=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_pwd='null';}else{
            $BDTL_INPUT_starhub_pwd=$this->db->escape_like_str($BDTL_INPUT_starhub_pwd);
            $BDTL_INPUT_starhub_pwd="'$BDTL_INPUT_starhub_pwd'";
        }
        if($BDTL_INPUT_starhub_cable_serialno=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_cable_serialno='null';}else{
            $BDTL_INPUT_starhub_cable_serialno=$this->db->escape_like_str($BDTL_INPUT_starhub_cable_serialno);
            $BDTL_INPUT_starhub_cable_serialno="'$BDTL_INPUT_starhub_cable_serialno'";
        }
        if($BDTL_INPUT_starhub_comments=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_comments='null';}else{
            $BDTL_INPUT_starhub_comments=$this->db->escape_like_str($BDTL_INPUT_starhub_comments);
            $BDTL_INPUT_starhub_comments="'$BDTL_INPUT_starhub_comments'";
        }
        if($BDTL_INPUT_starhub_addtnlch=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_addtnlch='null';}else{
            $BDTL_INPUT_starhub_addtnlch=$this->db->escape_like_str($BDTL_INPUT_starhub_addtnlch);
            $BDTL_INPUT_starhub_addtnlch="'$BDTL_INPUT_starhub_addtnlch'";
        }
        if($BDTL_INPUT_starhub_modem_serialno=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_modem_serialno='null';}else{
            $BDTL_INPUT_starhub_modem_serialno=$this->db->escape_like_str($BDTL_INPUT_starhub_modem_serialno);
            $BDTL_INPUT_starhub_modem_serialno="'$BDTL_INPUT_starhub_modem_serialno'";
        }
        if($BDTL_INPUT_starhub_basicgroup=="")//COMMENTS
        {
            $BDTL_INPUT_starhub_basicgroup='null';}else{
            $BDTL_INPUT_starhub_basicgroup=$this->db->escape_like_str($BDTL_INPUT_starhub_basicgroup);
            $BDTL_INPUT_starhub_basicgroup="'$BDTL_INPUT_starhub_basicgroup'";
        }
        $BDTL_INPUT_insert_starhub =$this->db->query("INSERT INTO EXPENSE_DETAIL_STARHUB(UNIT_ID,ECN_ID,EDSH_REC_VER,EDSH_ACCOUNT_NO,EDSH_APPL_DATE,EDSH_CABLE_START_DATE,EDSH_CABLE_END_DATE,EDSH_INTERNET_START_DATE,EDSH_INTERNET_END_DATE,EDSH_SSID,EDSH_PWD,EDSH_CABLE_BOX_SERIAL_NO,EDSH_MODEM_SERIAL_NO,EDSH_BASIC_GROUP,EDSH_ADDTNL_CH,EDSH_COMMENTS,ULD_ID) VALUES('$BDTL_INPUT_unitno',$BDTL_INPUT_starhub_invoiceto,'1','$BDTL_INPUT_starhub_acctno',$BDTL_INPUT_starhub_appldate,$BDTL_INPUT_starhub_cable_startdate,$BDTL_INPUT_starhub_cable_enddate,$BDTL_INPUT_starhub_internet_startdate,$BDTL_INPUT_starhub_internet_enddate,$BDTL_INPUT_starhub_ssid,$BDTL_INPUT_starhub_pwd,$BDTL_INPUT_starhub_cable_serialno,$BDTL_INPUT_starhub_modem_serialno,$BDTL_INPUT_starhub_basicgroup,$BDTL_INPUT_starhub_addtnlch,$BDTL_INPUT_starhub_comments,(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'))");

        /*-------------------------------CREATING CALENDAR EVENT FUNCTION FOR STARHUB------------------------*/
          $this->load->model('Eilib/Common_function');
          $this->load->model('Eilib/Calender');
          $BDTL_INPUT_sh_arr=$this->Common_function->getStarHubUnitCalTime();
          $BDTL_INPUT_sh_starttime=$BDTL_INPUT_sh_arr[0]['ECN_DATA'];
          $BDTL_INPUT_sh_endtime=$BDTL_INPUT_sh_arr[1]['ECN_DATA'];

        if(($BDTL_INPUT_starhub_cablestartdate_shtime!='')&&($BDTL_INPUT_starhub_cableenddate_shtime!='')&&($BDTL_INPUT_starhub_cablestartdate_shtime!='undefined')&&($BDTL_INPUT_starhub_cableenddate_shtime!='undefined'))
        {
            $this->Calender->StarHubUnit_CreateCalEvent($calid,$BDTL_INPUT_starhub_cablestartdate_shtime,$BDTL_INPUT_sh_starttime,$BDTL_INPUT_sh_endtime,$BDTL_INPUT_starhub_cableenddate_shtime,$BDTL_INPUT_sh_starttime,$BDTL_INPUT_sh_endtime,'STARHUB',$BDTL_INPUT_unitnoaircon,$BDTL_INPUT_starhub_acctno,'CABLE START DATE','CABLE END DATE','','');
        }
        if(($BDTL_INPUT_starhub_internetstartdate_shtime!='')&&($BDTL_INPUT_starhub_internetenddate_shtime!='')&&($BDTL_INPUT_starhub_internetstartdate_shtime!='undefined')&&($BDTL_INPUT_starhub_internetenddate_shtime!='undefined'))
        {
            $this->Calender->StarHubUnit_CreateCalEvent($calid,$BDTL_INPUT_starhub_internetstartdate_shtime,$BDTL_INPUT_sh_starttime,$BDTL_INPUT_sh_endtime,$BDTL_INPUT_starhub_internetenddate_shtime,$BDTL_INPUT_sh_starttime,$BDTL_INPUT_sh_endtime,'STARHUB',$BDTL_INPUT_unitnoaircon,$BDTL_INPUT_starhub_acctno,'INTERNET START DATE','INTERNET END DATE','','');
        }
      }

      return [$BDTL_INPUT_aircon_list_ref,1];
    }
 // SEARCH AND UPDATE FORM STARTS
    public function BTDTL_SEARCH_expensetypes()
    {
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("ECN_ID IN (16,17,15,13,14,196,19,20,21,193,194,100,101,195,102,103,106,107,108,109,104,105,110,111,112,113,114,115,116,117,118,119,120,121,122,123,191,200)");
        $this->db->order_by("ECN_DATA", "asc");
        $BTDTL_SEARCH_bizdetail_search_expense_type_query = $this->db->get();
        $BTDTL_SEARCH_expense_type_array = [];
        $BTDTL_SEARCH_arr_invoiceto=[];
        $BTDTL_SEARCH_arr_starhubid=[];  $BTDTL_SEARCH_aircon_configmon=[];
        foreach($BTDTL_SEARCH_bizdetail_search_expense_type_query->result_array() as $row)
        {
            if(($row['ECN_ID']==196)||($row['ECN_ID']==200))
            $BTDTL_SEARCH_aircon_configmon[]=$row['ECN_DATA'];
            else if(($row['ECN_ID']==19)||($row['ECN_ID']==20)||($row['ECN_ID']==21))
            $BTDTL_SEARCH_arr_invoiceto[]=["BTDTL_SEARCH_expensetypes_id"=>$row['ECN_ID'],"BTDTL_SEARCH_expensetypes_data"=>$row['ECN_DATA']];
            else if(($row['ECN_ID']==193)||($row['ECN_ID']==194))
            $BTDTL_SEARCH_arr_starhubid[]=$row['ECN_DATA'];
            else{
            $BTDTL_SEARCH_expensetypes_id = $row['ECN_ID'];
            $BTDTL_SEARCH_expensetypes_data =$row['ECN_DATA'];
            $BTDTL_SEARCH_expensetypes_object=["BTDTL_SEARCH_expensetypes_id"=>$BTDTL_SEARCH_expensetypes_id,"BTDTL_SEARCH_expensetypes_data"=>$BTDTL_SEARCH_expensetypes_data];
            $BTDTL_SEARCH_expense_type_array[]=$BTDTL_SEARCH_expensetypes_object;
            }
        }
        $this->load->model('Eilib/Common_function');
        $BTDTL_SEARCH_errormsg_array=$this->Common_function->GetErrorMessageList('1,2,224,174,18,176,236,184,180,182,179,185,197,199,195,191,201,200,203,202,178,193,189,187,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,107,106,170,175,177,181,183,186,188,190,192,194,196,198,103,315,204,205,206,207,208,335,369,401,458');
        $BTDTL_SEARCH_notable_flag=false;
        $BTDTL_SEARCH_notable_select = "SELECT UNIT_ID FROM EXPENSE_DETAIL_STARHUB UNION SELECT UNIT_ID FROM  EXPENSE_DETAIL_ELECTRICITY UNION SELECT UNIT_ID FROM EXPENSE_DETAIL_DIGITAL_VOICE UNION SELECT UNIT_ID FROM EXPENSE_DETAIL_AIRCON_SERVICE UNION SELECT UNIT_ID FROM EXPENSE_DETAIL_CARPARK";
        $BTDTL_SEARCH_notable_rs = $this->db->query($BTDTL_SEARCH_notable_select);
        foreach($BTDTL_SEARCH_notable_rs->result_array() as $row)
        {
            $BTDTL_SEARCH_notable_flag=true;
        }
       $BTDTL_SEARCH_flag_aircon=false; $BTDTL_SEARCH_flag_carpark=false;$BTDTL_SEARCH_flag_digital=false; $BTDTL_SEARCH_flag_electricity=false; $BTDTL_SEARCH_flag_starhub=false;
        $this->db->select("EDAS_ID");
        $this->db->from("EXPENSE_DETAIL_AIRCON_SERVICE");
        $BTDTL_SEARCH_select_flag = $this->db->get();
        foreach($BTDTL_SEARCH_select_flag->result_array() as $row){
            $BTDTL_SEARCH_flag_aircon=true;}
        $this->db->select('EDCP_ID');
        $this->db->from("EXPENSE_DETAIL_CARPARK");
        $BTDTL_SEARCH_select_flag = $this->db->get();
        foreach($BTDTL_SEARCH_select_flag->result_array() as $row){
            $BTDTL_SEARCH_flag_carpark=true;}
        $this->db->select('EDE_ID');
        $this->db->from("EXPENSE_DETAIL_ELECTRICITY");
        $BTDTL_SEARCH_select_flag = $this->db->get();
        foreach($BTDTL_SEARCH_select_flag->result_array() as $row){
            $BTDTL_SEARCH_flag_electricity=true;}
        $this->db->select('EDDV_ID');
        $this->db->from("EXPENSE_DETAIL_DIGITAL_VOICE");
        $BTDTL_SEARCH_select_flag = $this->db->get();
        foreach($BTDTL_SEARCH_select_flag->result_array() as $row){
            $BTDTL_SEARCH_flag_digital=true;}
        $this->db->select('EDSH_ID');
        $this->db->from("EXPENSE_DETAIL_STARHUB");
        $BTDTL_SEARCH_select_flag = $this->db->get();
        foreach($BTDTL_SEARCH_select_flag->result_array() as $row){
            $BTDTL_SEARCH_flag_starhub=true;}
        return ["BTDTL_SEARCH_expense"=>$BTDTL_SEARCH_expense_type_array,"BTDTL_SEARCH_errormsg"=>$BTDTL_SEARCH_errormsg_array,"BTDTL_SEARCH_aircon_errmsg"=>$BTDTL_SEARCH_aircon_configmon,"BTDTL_SEARCH_notable_obj"=>$BTDTL_SEARCH_notable_flag,"BTDTL_SEARCH_obj_invoiceto"=>$BTDTL_SEARCH_arr_invoiceto,"BTDTL_SEARCH_obj_starhubid"=>$BTDTL_SEARCH_arr_starhubid,"BTDTL_SEARCH_aircondetail_obj"=>$BTDTL_SEARCH_flag_aircon,"BTDTL_SEARCH_cardetail_obj"=>$BTDTL_SEARCH_flag_carpark,"BTDTL_SEARCH_elecdetail_obj"=>$BTDTL_SEARCH_flag_electricity,"BTDTL_SEARCH_digitaldetail_obj"=>$BTDTL_SEARCH_flag_digital,"BTDTL_SEARCH_stardetail_obj"=>$BTDTL_SEARCH_flag_starhub];
  }
    /*---------------------------------FUNCTION FOR SEARCH BY AIRCON,CARPARK,ELECTRICITY,STARHUB,DIGITALVOICE-----------------*/
    public function BTDTL_SEARCH_expense_searchby($BTDTL_SEARCH_search_option,$BTDTL_SEARCH_expense_types,$BTDTL_SEARCH_flag_searchby,$timezoneformat)
    {
      $BTDTL_SEARCH_searcharray=[];
      $BTDTL_SEARCH_id=[];
      $BTDTL_SEARCH_data=[];
      if($BTDTL_SEARCH_search_option==191)//UNIT NO
      {
          if($BTDTL_SEARCH_expense_types==16)//AIRCON SERVICES
          {
              $BTDTL_SEARCH_airconunitno_selectquery = "SELECT DISTINCT U.UNIT_NO FROM UNIT U,EXPENSE_DETAIL_AIRCON_SERVICE EDAS WHERE (U.UNIT_ID=EDAS.UNIT_ID) ORDER BY U.UNIT_NO ASC";
              $BTDTL_SEARCH_unitno_rs =$this->db->query($BTDTL_SEARCH_airconunitno_selectquery);
          }
          else if($BTDTL_SEARCH_expense_types==17)//CARPARK
          {
              $BTDTL_SEARCH_carparkunitno_selectquery = "SELECT UNIT_NO FROM UNIT WHERE UNIT_ID IN (SELECT DISTINCT UNIT_ID FROM EXPENSE_DETAIL_CARPARK) ORDER BY UNIT_NO ASC";
              $BTDTL_SEARCH_unitno_rs =$this->db->query($BTDTL_SEARCH_carparkunitno_selectquery);
          }
          else if($BTDTL_SEARCH_expense_types==15)//DIGITAL VOICE
          {
              $BTDTL_SEARCH_digitalunitno_selectquery = "SELECT UNIT_NO FROM UNIT WHERE UNIT_ID IN (SELECT DISTINCT UNIT_ID FROM EXPENSE_DETAIL_DIGITAL_VOICE) ORDER BY UNIT_NO ASC";
              $BTDTL_SEARCH_unitno_rs =$this->db->query($BTDTL_SEARCH_digitalunitno_selectquery);
          }
          else if($BTDTL_SEARCH_expense_types==13)//ELECTRICITY
          {
              $BTDTL_SEARCH_electricityunitno_selectquery = "SELECT UNIT_NO FROM UNIT WHERE UNIT_ID IN (SELECT DISTINCT UNIT_ID FROM EXPENSE_DETAIL_ELECTRICITY) ORDER BY UNIT_NO ASC";
              $BTDTL_SEARCH_unitno_rs =$this->db->query($BTDTL_SEARCH_electricityunitno_selectquery);
          }
          else if($BTDTL_SEARCH_expense_types==14)//STARHUB
          {
              $BTDTL_SEARCH_starhubunitno_selectquery = "SELECT UNIT_NO FROM UNIT WHERE UNIT_ID IN (SELECT DISTINCT UNIT_ID FROM EXPENSE_DETAIL_STARHUB) ORDER BY UNIT_NO ASC";
              $BTDTL_SEARCH_unitno_rs =$this->db->query($BTDTL_SEARCH_starhubunitno_selectquery);
          }
          foreach($BTDTL_SEARCH_unitno_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row['UNIT_NO'];
          }
      }
      else if(($BTDTL_SEARCH_search_option==101)||($BTDTL_SEARCH_search_option==108)||($BTDTL_SEARCH_search_option==103)||($BTDTL_SEARCH_search_option==104)||($BTDTL_SEARCH_search_option==122)||($BTDTL_SEARCH_search_option==110)||($BTDTL_SEARCH_search_option==111)||($BTDTL_SEARCH_search_option==112)||($BTDTL_SEARCH_search_option==115)||($BTDTL_SEARCH_search_option==114)||($BTDTL_SEARCH_search_option==117)||($BTDTL_SEARCH_search_option==116))
      {
          $BTDTL_SEARCH_searcharray='BTDTL_SEARCH_empty';
      }
      else if($BTDTL_SEARCH_search_option==100)//-AIRCON SERVICED BY
      {
          $BTDTL_SEARCH_data=[];
          $BTDTL_SEARCH_airconserviced_selectquery = "SELECT EASB.EASB_ID,EASB.EASB_DATA,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EASB.EASB_TIMESTAMP,$timezoneformat),'%d-%m-%Y %T') AS EASB_TIMESTAMP FROM EXPENSE_AIRCON_SERVICE_BY EASB,USER_LOGIN_DETAILS ULD WHERE EASB.ULD_ID=ULD.ULD_ID AND EASB_DATA!='' ORDER BY EASB_DATA ASC";
          $BTDTL_SEARCH_airconservicedby_rs = $this->db->query($BTDTL_SEARCH_airconserviced_selectquery);
          foreach($BTDTL_SEARCH_airconservicedby_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_airconid=$row["EASB_ID"];
              $BTDTL_SEARCH_arr=[];
              $BTDTL_SEARCH_arr[]=$row["EASB_DATA"];
              $BTDTL_SEARCH_arr[]=$row["ULD_LOGINID"];
              $BTDTL_SEARCH_arr[]=$row["EASB_TIMESTAMP"];
              $BTDTL_SEARCH_id[]=$BTDTL_SEARCH_airconid;
        $BTDTL_SEARCH_data[]=$BTDTL_SEARCH_arr;
        $BTDTL_SEARCH_searcharray[]=["BTDTL_SEARCH_obj_id"=>$row["EASB_ID"],"BTDTL_SEARCH_obj_data"=>$row["EASB_DATA"]];
      }
          $BTDTL_SEARCH_data[]=$BTDTL_SEARCH_flag_searchby;
    }
      else if($BTDTL_SEARCH_search_option==195)//AIRCON SERVICED WITH UNIT
      {
          $BTDTL_SEARCH_airconserviced_selectquery = "SELECT DISTINCT EASB_DATA FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS,EXPENSE_AIRCON_SERVICE_BY EASB,VW_ACTIVE_UNIT VAU WHERE EDAS.EASB_ID=EASB.EASB_ID AND VAU.UNIT_ID=EDAS.UNIT_ID ORDER BY EASB.EASB_DATA ASC";
          $BTDTL_SEARCH_airconservicedby_rs = $this->db->query($BTDTL_SEARCH_airconserviced_selectquery);
          foreach($BTDTL_SEARCH_airconservicedby_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row["EASB_DATA"];
          }
      }
      else if($BTDTL_SEARCH_search_option==102)//CAR NO
      {
          $BTDTL_SEARCH_select_carpark_carno = "SELECT DISTINCT EDCP_CAR_NO FROM EXPENSE_DETAIL_CARPARK EDC,VW_ACTIVE_UNIT VAU WHERE EDCP_CAR_NO IS NOT NULL AND EDCP_CAR_NO!=''AND EDC.UNIT_ID=VAU.UNIT_ID ORDER BY EDCP_CAR_NO ASC";
          $BTDTL_SEARCH_select_carno_rs = $this->db->query($BTDTL_SEARCH_select_carpark_carno);
          foreach($BTDTL_SEARCH_select_carno_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row['EDCP_CAR_NO'];
          }
      }
      else if($BTDTL_SEARCH_search_option==123)//STARHUB ACCOUNT NO
      {
          $BTDTL_SEARCH_accno_selectquery = "SELECT DISTINCT EDSH_ACCOUNT_NO FROM EXPENSE_DETAIL_STARHUB EDS,VW_ACTIVE_UNIT VAU WHERE EDSH_ACCOUNT_NO IS NOT NULL AND EDSH_ACCOUNT_NO!=''AND EDS.UNIT_ID=VAU.UNIT_ID ORDER BY EDSH_ACCOUNT_NO ASC";
          $BTDTL_SEARCH_accountno_rs = $this->db->query($BTDTL_SEARCH_accno_selectquery);
          foreach($BTDTL_SEARCH_accountno_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row["EDSH_ACCOUNT_NO"];
          }
      }
      else if($BTDTL_SEARCH_search_option==109)//DIGITAL ACCOUNT NO
      {
          $BTDTL_SEARCH_select_digitalacctno = "SELECT DISTINCT EDDV_DIGITAL_ACCOUNT_NO FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV,VW_ACTIVE_UNIT VAU WHERE EDDV_DIGITAL_ACCOUNT_NO IS NOT NULL AND EDDV_DIGITAL_ACCOUNT_NO!='' AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY EDDV_DIGITAL_ACCOUNT_NO ASC";
          $BTDTL_SEARCH_digitalacctno_rs = $this->db->query($BTDTL_SEARCH_select_digitalacctno);
          foreach($BTDTL_SEARCH_digitalacctno_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row["EDDV_DIGITAL_ACCOUNT_NO"];
          }
      }
      else if(($BTDTL_SEARCH_search_option==107)||($BTDTL_SEARCH_search_option==105)||($BTDTL_SEARCH_search_option==118))
      {
          $BTDTL_SEARCH_searcharray='BTDTL_SEARCH_empty';
      }
      else if($BTDTL_SEARCH_search_option==106)//DIGITAL VOICE NO
      {
          $BTDTL_SEARCH_digitalvoiceno_selectquery = "SELECT DISTINCT EDDV_DIGITAL_VOICE_NO FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV,VW_ACTIVE_UNIT VAU WHERE EDDV_DIGITAL_VOICE_NO IS NOT NULL AND EDDV_DIGITAL_VOICE_NO!='' AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY EDDV_DIGITAL_VOICE_NO";
          $BTDTL_SEARCH_digitalvoiceno_rs = $this->db->query($BTDTL_SEARCH_digitalvoiceno_selectquery);
          foreach($BTDTL_SEARCH_digitalvoiceno_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row["EDDV_DIGITAL_VOICE_NO"];
          }
      }
      else if($BTDTL_SEARCH_search_option==113)//STARHUB CABLE BOX SERIAL NO
      {
          $BTDTL_SEARCH_starhubcableboxno_selectquery = "SELECT DISTINCT EDSH_CABLE_BOX_SERIAL_NO FROM EXPENSE_DETAIL_STARHUB EDSH,VW_ACTIVE_UNIT VAU WHERE EDSH_CABLE_BOX_SERIAL_NO IS NOT NULL AND EDSH_CABLE_BOX_SERIAL_NO!='' AND EDSH.UNIT_ID=VAU.UNIT_ID ORDER BY EDSH_CABLE_BOX_SERIAL_NO ASC";
          $BTDTL_SEARCH_starhubcableboxno_rs = $this->db->query($BTDTL_SEARCH_starhubcableboxno_selectquery);
          foreach($BTDTL_SEARCH_starhubcableboxno_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row["EDSH_CABLE_BOX_SERIAL_NO"];
          }
      }
      else if($BTDTL_SEARCH_search_option==119)//STARHUB MODEM SERIAL NO
      {
          $BTDTL_SEARCH_modelserialno_selectquery = "SELECT DISTINCT EDSH_MODEM_SERIAL_NO FROM EXPENSE_DETAIL_STARHUB EDSH,VW_ACTIVE_UNIT VAU WHERE EDSH_MODEM_SERIAL_NO IS NOT NULL AND EDSH_MODEM_SERIAL_NO!='' AND EDSH.UNIT_ID=VAU.UNIT_ID ORDER BY EDSH_MODEM_SERIAL_NO ASC";
          $BTDTL_SEARCH_modelserialno_rs = $this->db->query($BTDTL_SEARCH_modelserialno_selectquery);
          foreach($BTDTL_SEARCH_modelserialno_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row["EDSH_MODEM_SERIAL_NO"];
          }
      }
      else if($BTDTL_SEARCH_search_option==121)//STARHUB PWD
      {
          $BTDTL_SEARCH_starhubpwd_selectquery = "SELECT DISTINCT EDSH_PWD FROM EXPENSE_DETAIL_STARHUB EDSH,VW_ACTIVE_UNIT VAU WHERE EDSH_PWD IS NOT NULL AND EDSH_PWD!='' AND EDSH.UNIT_ID=VAU.UNIT_ID ORDER BY EDSH_PWD ASC";
          $BTDTL_SEARCH_starhubpwd_rs = $this->db->query($BTDTL_SEARCH_starhubpwd_selectquery);
          foreach($BTDTL_SEARCH_starhubpwd_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row["EDSH_PWD"];
          }
      }
      else if($BTDTL_SEARCH_search_option==120)//STARHUB SSID
      {
          $BTDTL_SEARCH_starhubssid_selectquery = "SELECT DISTINCT EDSH_SSID FROM EXPENSE_DETAIL_STARHUB EDSH,VW_ACTIVE_UNIT VAU WHERE EDSH_SSID IS NOT NULL AND EDSH_SSID!='' AND EDSH.UNIT_ID=VAU.UNIT_ID ORDER BY EDSH_SSID ASC";
          $BTDTL_SEARCH_starhubssid_rs = $this->db->query($BTDTL_SEARCH_starhubssid_selectquery);
          foreach($BTDTL_SEARCH_starhubssid_rs->result_array() as $row)
          {
              $BTDTL_SEARCH_searcharray[]=$row["EDSH_SSID"];
          }
      }
      $BTDTL_SEARCH_final=["BTDTL_SEARCH_searchvalue"=>$BTDTL_SEARCH_searcharray,"BTDTL_SEARCH_parentfunction"=>$BTDTL_SEARCH_flag_searchby,"BTDTL_SEARCH_search_flag"=>$BTDTL_SEARCH_search_option,"BTDTL_SEARCH_id"=>$BTDTL_SEARCH_id,"BTDTL_SEARCH_aircondata"=>$BTDTL_SEARCH_data];
    return $BTDTL_SEARCH_final;
  }
    /*----------------------------------------FUNCTION FOR AUTOCOMPLETE FOR COMMENTS--------------------------------------------*/
    public function BTDTL_SEARCH_comments_autocomplete($BTDTL_SEARCH_expense_searchoptions)
    {
      $BTDTL_SEARCH_dataArray=[];
      $BTDTL_SEARCH_twodim_expense=[101=>['EXPENSE_DETAIL_AIRCON_SERVICE','EDAS_COMMENTS'],103=>['EXPENSE_DETAIL_CARPARK','EDCP_COMMENTS'],108=>['EXPENSE_DETAIL_DIGITAL_VOICE','EDDV_COMMENTS']
                                     ,104=>['EXPENSE_DETAIL_ELECTRICITY','EDE_COMMENTS'],122=>['EXPENSE_DETAIL_STARHUB','EDSH_COMMENTS'],110=>['EXPENSE_DETAIL_STARHUB','EDSH_ADDTNL_CH'],112=>['EXPENSE_DETAIL_STARHUB','EDSH_BASIC_GROUP']];
       $BTDTL_SEARCH_rs = $this->db->query("SELECT ".$BTDTL_SEARCH_twodim_expense[$BTDTL_SEARCH_expense_searchoptions][1]." FROM ".$BTDTL_SEARCH_twodim_expense[$BTDTL_SEARCH_expense_searchoptions][0]." WHERE UNIT_ID IN(SELECT UNIT_ID FROM VW_ACTIVE_UNIT)");
        foreach($BTDTL_SEARCH_rs->result_array() as $row){
        if($row[$BTDTL_SEARCH_twodim_expense[$BTDTL_SEARCH_expense_searchoptions][1]]!=null)
        $BTDTL_SEARCH_dataArray[]=$row[$BTDTL_SEARCH_twodim_expense[$BTDTL_SEARCH_expense_searchoptions][1]];
    }
    $BTDTL_SEARCH_final_comments=["BTDTL_SEARCH_flag_comments"=>$BTDTL_SEARCH_expense_searchoptions,"BTDTL_SEARCH_searchvalue_comments"=>$BTDTL_SEARCH_dataArray];
    return $BTDTL_SEARCH_final_comments;
  }
    /*------------------------------------FUNCTION FOR FETCHING FLEX TABLE FOR AIRCON-------------------------------------------------*/
    public function BTDTL_SEARCH_flex_aircon($BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
    {
     $BTDTL_SEARCH_array=[];
    $BTDTL_SEARCH_id=[];
    if($BTDTL_SEARCH_searchby==101)//SEARCH BY AIRCON COMMENTS
    {
        $BTDTL_SEARCH_searchval=$this->db->escape_like_str($BTDTL_SEARCH_searchval);
        $BTDTL_SEARCH_search_aircon = "SELECT EDAS.EDAS_ID,U.UNIT_ID,U.UNIT_NO,EASB.EASB_DATA,EDAS.EDAS_REC_VER,EDAS.EDAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDAS.EDAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_AIRCON_SERVICE_BY EASB, EXPENSE_DETAIL_AIRCON_SERVICE EDAS,UNIT U,VW_ACTIVE_UNIT VAU,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDAS.ULD_ID AND EDAS.UNIT_ID=U.UNIT_ID AND EDAS.UNIT_ID=VAU.UNIT_ID AND EDAS.EDAS_COMMENTS='$BTDTL_SEARCH_searchval' AND EDAS.EASB_ID=EASB.EASB_ID  ORDER BY EDAS.EDAS_COMMENTS,U.UNIT_NO";
    }
    else if($BTDTL_SEARCH_searchby==195)//SEARCH BY AIRCON SERVICED BY UNIT
    {
        $BTDTL_SEARCH_search_aircon = "SELECT EDAS.EDAS_ID,U.UNIT_ID,U.UNIT_NO,EASB.EASB_DATA,EDAS.EDAS_REC_VER,EDAS.EDAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDAS.EDAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS,EXPENSE_AIRCON_SERVICE_BY EASB,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDAS.ULD_ID AND EASB.EASB_ID=EDAS.EASB_ID AND U.UNIT_ID=EDAS.UNIT_ID AND EDAS.UNIT_ID=VAU.UNIT_ID AND EASB.EASB_DATA='$BTDTL_SEARCH_searchval' ORDER BY U.UNIT_NO,EASB.EASB_DATA";
    }
    else if($BTDTL_SEARCH_searchby==191)//SEARCH BY UNIT NO
    {
        $BTDTL_SEARCH_search_aircon = "SELECT EDAS.EDAS_ID,U.UNIT_ID,U.UNIT_NO,EASB.EASB_DATA,EDAS.EDAS_REC_VER,EDAS.EDAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDAS.EDAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS, EXPENSE_AIRCON_SERVICE_BY EASB, UNIT U ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDAS.ULD_ID AND U.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$BTDTL_SEARCH_searchval') AND  EDAS.EASB_ID=EASB.EASB_ID AND U.UNIT_ID=EDAS.UNIT_ID ORDER BY U.UNIT_NO ASC";
    }
    $BTDTL_SEARCH_aircon_rs= $this->db->query($BTDTL_SEARCH_search_aircon);
    foreach($BTDTL_SEARCH_aircon_rs->result_array() as $row)
    {
        $arr=[];
        $BTDTL_SEARCH_aircon_autoid = $row['EDAS_ID'].'_'.$row['UNIT_ID'];
        $BTDTL_SEARCH_aircon_unitno = $row['UNIT_NO'];
        $BTDTL_SEARCH_aircon_data = $row['EASB_DATA'];
        $BTDTL_SEARCH_aircon_comments = $row['EDAS_COMMENTS'];
        $BTDTL_SEARCH_aircon_userstamp = $row['ULD_LOGINID'];
        $BTDTL_SEARCH_aircon_timestamp = $row['TIMESTAMP'];
        $BTDTL_SEARCH_id[]=$BTDTL_SEARCH_aircon_autoid;
        $arr[]=$BTDTL_SEARCH_aircon_unitno;
        $arr[]=$BTDTL_SEARCH_aircon_data;
        $arr[]=$BTDTL_SEARCH_aircon_comments;
        $arr[]=$BTDTL_SEARCH_aircon_userstamp;
        $arr[]=$BTDTL_SEARCH_aircon_timestamp;
      $BTDTL_SEARCH_array[]=$arr;
    }
    $BTDTL_SEARCH_array[]=$BTDTL_SEARCH_parentfunc;
    $BTDTL_SEARCH_result=["BTDTL_SEARCH_expenseflex"=>$BTDTL_SEARCH_array,"BTDTL_SEARCH_id"=>$BTDTL_SEARCH_id];
    return $BTDTL_SEARCH_result;
  }
    /*-----------------------------------------------FUNCTION FOR CARPARK SHOWING FLEX TABLE--------------------------------------------------*/
  public  function BTDTL_SEARCH_show_carpark($BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
  {
   $BTDTL_SEARCH_array=[];
   $BTDTL_SEARCH_id=[];
    if($BTDTL_SEARCH_searchby==102){//CAR NO
       $BTDTL_SEARCH_search_carpark = "SELECT EDCP.EDCP_ID,U.UNIT_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,EDCP.EDCP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDCP.EDCP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT U, EXPENSE_DETAIL_CARPARK EDCP,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDCP.ULD_ID AND U.UNIT_ID= EDCP.UNIT_ID AND EDCP.EDCP_CAR_NO ='$BTDTL_SEARCH_searchval' AND EDCP.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO, EDCP.EDCP_CAR_NO";
    }
    else if($BTDTL_SEARCH_searchby==103){//CARPARK COMMENTS
        $BTDTL_SEARCH_searchval=$this->db->escape_like_str($BTDTL_SEARCH_searchval);
       $BTDTL_SEARCH_search_carpark = "SELECT EDCP.EDCP_ID,U.UNIT_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,EDCP.EDCP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDCP.EDCP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT U, EXPENSE_DETAIL_CARPARK EDCP,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDCP.ULD_ID AND U.UNIT_ID=EDCP.UNIT_ID AND EDCP.EDCP_COMMENTS='$BTDTL_SEARCH_searchval' AND EDCP.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDCP.EDCP_COMMENTS";
    }
    else if($BTDTL_SEARCH_searchby==191)//UNIT No
    {
       $BTDTL_SEARCH_search_carpark = "SELECT EDCP.EDCP_ID,U.UNIT_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,EDCP.EDCP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDCP.EDCP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT U, EXPENSE_DETAIL_CARPARK EDCP ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDCP.ULD_ID AND U.UNIT_ID= (SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$BTDTL_SEARCH_searchval') AND U.UNIT_ID=EDCP.UNIT_ID ORDER BY U.UNIT_NO ASC";
    }
   $BTDTL_SEARCH_carpark_rs = $this->db->query($BTDTL_SEARCH_search_carpark);
   foreach($BTDTL_SEARCH_carpark_rs->result_array() as $row)
    {
       $BTDTL_SEARCH_caraprk_autoid = $row['EDCP_ID'].'_'.$row['UNIT_ID'];
       $BTDTL_SEARCH_arr=[];
        $BTDTL_SEARCH_arr[]=$row['UNIT_NO'];
        $BTDTL_SEARCH_arr[]=$row['EDCP_CAR_NO'];
        $BTDTL_SEARCH_arr[]=$row['EDCP_COMMENTS'];
        $BTDTL_SEARCH_arr[]=$row['ULD_LOGINID'];
        $BTDTL_SEARCH_arr[]=$row['TIMESTAMP'];
        $BTDTL_SEARCH_array[]=$BTDTL_SEARCH_arr;
        $BTDTL_SEARCH_id[]=$BTDTL_SEARCH_caraprk_autoid;
    }
    $BTDTL_SEARCH_array[]=$BTDTL_SEARCH_parentfunc;
   $BTDTL_SEARCH_result=["BTDTL_SEARCH_expenseflex"=>$BTDTL_SEARCH_array,"BTDTL_SEARCH_id"=>$BTDTL_SEARCH_id];
    return $BTDTL_SEARCH_result;
  }
    /*---------------------------------------FUNCTION FOR DIGITAL SHOWING FLEX TABLE-----------------------------------------------------------*/
  public  function BTDTL_SEARCH_show_digital($BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
  {
    $BTDTL_SEARCH_array=[];
    $BTDTL_SEARCH_id=[];
    if($BTDTL_SEARCH_searchby==109)//SEARCH BY DIGITAL ACCOUNT NO
    {
        $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV LEFT JOIN EXPENSE_CONFIGURATION EC ON EDDV.ECN_ID=EC.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.EDDV_DIGITAL_ACCOUNT_NO='$BTDTL_SEARCH_searchval' AND EDDV.UNIT_ID=U.UNIT_ID  AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO";
    }
    else if($BTDTL_SEARCH_searchby==108)//SEARCH BY DIGITAL COMMENTS
    {
        $BTDTL_SEARCH_searchval=$this->db->escape_like_sr($BTDTL_SEARCH_searchval);
        $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV LEFT JOIN EXPENSE_CONFIGURATION EC ON EDDV.ECN_ID=EC.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.EDDV_COMMENTS='$BTDTL_SEARCH_searchval' AND EDDV.UNIT_ID=U.UNIT_ID  AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDDV.EDDV_COMMENTS";
    }
    else if($BTDTL_SEARCH_searchby==107)//SEARCH BY DIGITAL INVOICE TO
    {
        $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_CONFIGURATION EC,UNIT U,EXPENSE_DETAIL_DIGITAL_VOICE EDDV,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.ECN_ID ='$BTDTL_SEARCH_searchval' AND EDDV.UNIT_ID=U.UNIT_ID AND EDDV.ECN_ID=EC.ECN_ID AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EC.ECN_DATA";
    }
    else if($BTDTL_SEARCH_searchby==106)//SEARCH BY DIGITAL VOICE NO
    {
        $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV LEFT JOIN EXPENSE_CONFIGURATION EC ON EDDV.ECN_ID=EC.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.EDDV_DIGITAL_VOICE_NO='$BTDTL_SEARCH_searchval' AND EDDV.UNIT_ID=U.UNIT_ID AND EDDV.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDDV.EDDV_DIGITAL_VOICE_NO";
    }
    else if($BTDTL_SEARCH_searchby==191)//SEARCH BY UNIT NO
    {
        $BTDTL_SEARCH_select_digital = "SELECT EDDV.EDDV_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,EDDV.EDDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDDV.EDDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV LEFT JOIN EXPENSE_CONFIGURATION EC ON EDDV.ECN_ID=EC.ECN_ID,UNIT U ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDDV.ULD_ID AND EDDV.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO ='$BTDTL_SEARCH_searchval') AND EDDV.UNIT_ID=U.UNIT_ID ORDER BY U.UNIT_NO ASC";
    }
    $BTDTL_SEARCH_digital_rs=$this->db->query($BTDTL_SEARCH_select_digital);
    foreach($BTDTL_SEARCH_digital_rs->result_array() as $row)
    {
        $BTDTL_SEARCH_arr=[];
        $BTDTL_SEARCH_digital_autoid = $row['EDDV_ID'].'_'.$row['UNIT_ID'];
        $BTDTL_SEARCH_arr[]=$row['UNIT_NO'];
        $BTDTL_SEARCH_arr[]=$row['ECN_DATA'];
        $BTDTL_SEARCH_arr[]=$row['EDDV_DIGITAL_VOICE_NO'];
        $BTDTL_SEARCH_arr[]=$row['EDDV_DIGITAL_ACCOUNT_NO'];
        $BTDTL_SEARCH_arr[]=$row['EDDV_COMMENTS'];
        $BTDTL_SEARCH_arr[]=$row['ULD_LOGINID'];
        $BTDTL_SEARCH_arr[]=$row['TIMESTAMP'];
        $BTDTL_SEARCH_array[]=$BTDTL_SEARCH_arr;
        $BTDTL_SEARCH_id[]=$BTDTL_SEARCH_digital_autoid;
    }
    $BTDTL_SEARCH_array[]=$BTDTL_SEARCH_parentfunc;
    $BTDTL_SEARCH_result=["BTDTL_SEARCH_expenseflex"=>$BTDTL_SEARCH_array,"BTDTL_SEARCH_id"=>$BTDTL_SEARCH_id];
    return $BTDTL_SEARCH_result;
  }
    /*--------------------------------------------FETCHING ELECTRICITY FOR LOADING FLEX TABLE--------------------------------------------------*/
  public   function BTDTL_SEARCH_show_electricity($BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
  {
     $BTDTL_SEARCH_array=[];
    $BTDTL_SEARCH_id=[];
    if($BTDTL_SEARCH_searchby==104)//SEARCH BY ELECTRICITY COMMENTS
    {
        $BTDTL_SEARCH_searchval=$this->db->escape_like_str($BTDTL_SEARCH_searchval);
        $BTDTL_SEARCH_select_electricity="SELECT EDE.EDE_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDE.EDE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDE.EDE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP  FROM EXPENSE_DETAIL_ELECTRICITY EDE,EXPENSE_CONFIGURATION EC,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDE.ULD_ID AND EDE.EDE_COMMENTS='$BTDTL_SEARCH_searchval' AND EDE.ECN_ID=EC.ECN_ID AND EDE.UNIT_ID=U.UNIT_ID AND EDE.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EDE.EDE_COMMENTS";
    }
    else if($BTDTL_SEARCH_searchby==105)//SEARCH BY ELECTRICITY INVOICE TO
    {
        $BTDTL_SEARCH_select_electricity="SELECT EDE.EDE_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDE.EDE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDE.EDE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP  FROM EXPENSE_DETAIL_ELECTRICITY EDE,EXPENSE_CONFIGURATION EC,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDE.ULD_ID AND EDE.ECN_ID ='$BTDTL_SEARCH_searchval' AND EDE.ECN_ID=EC.ECN_ID AND EDE.UNIT_ID=U.UNIT_ID AND EDE.UNIT_ID=VAU.UNIT_ID ORDER BY U.UNIT_NO,EC.ECN_DATA";
    }
    else if($BTDTL_SEARCH_searchby==191)//SEARCH BY UNIT NO
    {
        $BTDTL_SEARCH_select_electricity ="SELECT EDE.EDE_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDE.EDE_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDE.EDE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP  FROM EXPENSE_DETAIL_ELECTRICITY EDE,EXPENSE_CONFIGURATION EC,UNIT U,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EDE.ULD_ID AND EDE.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$BTDTL_SEARCH_searchval') AND EDE.ECN_ID=EC.ECN_ID AND EDE.UNIT_ID=U.UNIT_ID ORDER BY U.UNIT_NO ASC";
    }
    $BTDTL_SEARCH_electricity_rs=$this->db->query($BTDTL_SEARCH_select_electricity);
    foreach($BTDTL_SEARCH_electricity_rs->result_array() as $row)
    {
        $BTDTL_SEARCH_electricity_autoid = $row['EDE_ID'].'_'.$row['UNIT_ID'];
        $BTDTL_SEARCH_arr=[];
        $BTDTL_SEARCH_arr[]=$row['UNIT_NO'];
        $BTDTL_SEARCH_arr[]=$row['ECN_DATA'];
        $BTDTL_SEARCH_arr[]=$row['EDE_COMMENTS'];
        $BTDTL_SEARCH_arr[]=$row['ULD_LOGINID'];
        $BTDTL_SEARCH_arr[]=$row['TIMESTAMP'];
        $BTDTL_SEARCH_array[]=$BTDTL_SEARCH_arr;
        $BTDTL_SEARCH_id[]=$BTDTL_SEARCH_electricity_autoid;
    }
      $BTDTL_SEARCH_array[]=$BTDTL_SEARCH_parentfunc;
    $BTDTL_SEARCH_result=["BTDTL_SEARCH_expenseflex"=>$BTDTL_SEARCH_array,"BTDTL_SEARCH_id"=>$BTDTL_SEARCH_id];
    return $BTDTL_SEARCH_result;
  }
    /*---------------------------------------------FUNCTION FOR STARHUB SHOWING FLEX TABLE-----------------------------------------------------------*/
  public  function BTDTL_SEARCH_show_starhub($BTDTL_SEARCH_date,$BTDTL_SEARCH_searchval,$BTDTL_SEARCH_searchby,$BTDTL_SEARCH_parentfunc,$timeZoneFormat)
  {
    if($BTDTL_SEARCH_date==null)
        $BTDTL_SEARCH_date='';
      else
          $BTDTL_SEARCH_date=date('Y-m-d',strtotime($BTDTL_SEARCH_date));
    $BTDTL_SEARCH_array=[];
    $BTDTL_SEARCH_id=[];
    if($BTDTL_SEARCH_searchby==123)//SEARCH BY STARTHUB ACCOUNT NO
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID, UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_ACCOUNT_NO='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_ACCOUNT_NO";
    }
    else if($BTDTL_SEARCH_searchby==113)//SEARCH BY STARTHUB CABLE BOX SERIAL NO
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_CABLE_BOX_SERIAL_NO='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_CABLE_BOX_SERIAL_NO";
    }
    else if($BTDTL_SEARCH_searchby==118)//SEARCH BY STARTHUB INVOICE TO
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM VW_ACTIVE_UNIT VAU,UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.ECN_ID='$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EC.ECN_DATA";
    }
    else if($BTDTL_SEARCH_searchby==119)//SEARCH BY STARTHUB MODEM SERIAL NO
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU  ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_MODEM_SERIAL_NO='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_MODEM_SERIAL_NO";
    }
    else if($BTDTL_SEARCH_searchby==121)//SEARCH BY STARTHUB PWD
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU  ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_PWD='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_PWD";
    }
    else if($BTDTL_SEARCH_searchby==120)//SEARCH BY STARTHUB SSID
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU  ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND EDSH.EDSH_SSID='$BTDTL_SEARCH_searchval' AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_SSID";
    }
    else if($BTDTL_SEARCH_searchby==191)//SEARCH BY UNIT NO
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND  EDSH.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$BTDTL_SEARCH_searchval') AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO";
    }
    else if($BTDTL_SEARCH_searchby==111)//SEARCH BY STARTHUB APPL DATE
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_APPL_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_APPL_DATE";
    }
    else if($BTDTL_SEARCH_searchby==115)//SEARCH BY STARTHUB CABLE START DATE
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_CABLE_START_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_CABLE_START_DATE";
    }
    else if($BTDTL_SEARCH_searchby==114)//SEARCH BY STARTHUB CABLE END DATE
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_CABLE_END_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_CABLE_END_DATE";
    }
    else if($BTDTL_SEARCH_searchby==117)//SEARCH BY STARTHUB INTERNET START DATE
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_INTERNET_START_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_INTERNET_START_DATE";
    }
    else if($BTDTL_SEARCH_searchby==116)//SEARCH BY STARTHUB INTERNET END DATE
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID,UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_INTERNET_END_DATE BETWEEN '$BTDTL_SEARCH_date' AND '$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_INTERNET_END_DATE";
    }
    else if($BTDTL_SEARCH_searchby==122)//SEARCH BY STARTHUB COMMENTS
    {
        $BTDTL_SEARCH_searchval=$this->db->escape_like_str($BTDTL_SEARCH_searchval);
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID, UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_COMMENTS='$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_COMMENTS";
    }
    else if($BTDTL_SEARCH_searchby==112)//SEARCH BY STARTHUB BASIC GROUP
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID, UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND  EDSH.EDSH_BASIC_GROUP='$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_BASIC_GROUP";
    }
    else if($BTDTL_SEARCH_searchby==110)//SEARCH BY STARTHUB ADDTNL CH
    {
        $BTDTL_SEARCH_select_starhub = "SELECT UD.UD_START_DATE,UD.UD_END_DATE,EDSH.EDSH_ID,U.UNIT_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(EDSH.EDSH_APPL_DATE,'%d-%m-%Y') AS EDSH_APPL_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_START_DATE,'%d-%m-%Y') AS EDSH_CABLE_START_DATE,DATE_FORMAT(EDSH.EDSH_CABLE_END_DATE,'%d-%m-%Y') AS EDSH_CABLE_END_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_START_DATE,'%d-%m-%Y') AS EDSH_INTERNET_START_DATE,DATE_FORMAT(EDSH.EDSH_INTERNET_END_DATE,'%d-%m-%Y') AS EDSH_INTERNET_END_DATE,EDSH.EDSH_SSID,EDSH.EDSH_PWD,EDSH.EDSH_CABLE_BOX_SERIAL_NO,EDSH.EDSH_MODEM_SERIAL_NO,EDSH.EDSH_BASIC_GROUP,EDSH.EDSH_ADDTNL_CH,EDSH.EDSH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDSH.EDSH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EDSH_TIMESTAMP FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID, UNIT U,VW_ACTIVE_UNIT VAU ,USER_LOGIN_DETAILS ULD,UNIT_DETAILS UD WHERE ULD.ULD_ID=EDSH.ULD_ID AND U.UNIT_ID=EDSH.UNIT_ID AND EDSH.EDSH_ADDTNL_CH='$BTDTL_SEARCH_searchval' AND EDSH.UNIT_ID=VAU.UNIT_ID AND U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO,EDSH.EDSH_ADDTNL_CH";
    } 
    $BTDTL_SEARCH_starhub_rs = $this->db->query($BTDTL_SEARCH_select_starhub);
    foreach($BTDTL_SEARCH_starhub_rs->result_array() as $row)
    {
        $BTDTL_SEARCH_starhub_autoid = $row['EDSH_ID'].'_'.$row['UNIT_ID'].'_'.$row['UD_START_DATE'].'_'.$row['UD_END_DATE'];
        $BTDTL_SEARCH_arr=[];
        $BTDTL_SEARCH_arr[]=$row['UNIT_NO'];
        $BTDTL_SEARCH_arr[]=$row['ECN_DATA'];
        $BTDTL_SEARCH_arr[]=$row["EDSH_ACCOUNT_NO"];
        $BTDTL_SEARCH_arr[]=$row['EDSH_APPL_DATE'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_CABLE_START_DATE'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_CABLE_END_DATE'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_INTERNET_START_DATE'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_INTERNET_END_DATE'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_SSID'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_PWD'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_CABLE_BOX_SERIAL_NO'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_MODEM_SERIAL_NO'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_BASIC_GROUP'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_ADDTNL_CH'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_COMMENTS'];
        $BTDTL_SEARCH_arr[]=$row['ULD_LOGINID'];
        $BTDTL_SEARCH_arr[]=$row['EDSH_TIMESTAMP'];
        $BTDTL_SEARCH_array[]=$BTDTL_SEARCH_arr;
        $BTDTL_SEARCH_id[]=$BTDTL_SEARCH_starhub_autoid;
    }
    $BTDTL_SEARCH_array[]=$BTDTL_SEARCH_parentfunc;
    $BTDTL_SEARCH_result=["BTDTL_SEARCH_expenseflex"=>$BTDTL_SEARCH_array,"BTDTL_SEARCH_id"=>$BTDTL_SEARCH_id];
    return $BTDTL_SEARCH_result;
  }
}