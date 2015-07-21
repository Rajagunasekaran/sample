<?php
Class Mdl_biz_expense_daily_entry_search_update_delete extends CI_Model {
    public function initialvalues($ErrorMessage)
    {
        $BDLY_INPUT_unittable=[];
        $BDLY_INPUT_pettycash=[];
        $BDLY_INPUT_customer=[];
        $BDLY_INPUT_customerentrydetails=[];
        $BDLY_INPUT_detailairconservice=[];
        $BDLY_INPUT_detailcarpark=[];
        $BDLY_INPUT_detaildigitalvoice=[];
        $BDLY_INPUT_detailstarhub=[];
        $BDLY_INPUT_detailelecticity=[];
        $BDLY_INPUT_housekeepingunit=[];
        $BDLY_INPUT_expanse_array=[];
        $BDLY_INPUT_errorarray=[];

        //EXPENSE CONFIGURATIONTABLE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID IN (41,18,20,27,77,83)");
        $query = $this->db->get();
//        $bizarray=array();
        foreach ($query->result_array() as $row)
        {
            $BDLY_INPUT_expanse_id=[];
            $BDLY_INPUT_expanse_date=[];
            $BDLY_INPUT_expanse_id[] = $row["ECN_ID"];
            $BDLY_INPUT_expanse_date[]=$row["ECN_DATA"];
            $bizarrayexpenseid[]=$BDLY_INPUT_expanse_id;
            $bixarrayexpensedata[]=$BDLY_INPUT_expanse_date;

        }
        $BDLY_INPUT_expanse_val=array('BDLY_INPUT_expanse_id'=>$bizarrayexpenseid,'BDLY_INPUT_expanse_date'=>$bixarrayexpensedata);
        $BDLY_INPUT_expanse_array=$BDLY_INPUT_expanse_val;

        //UNIT TABLE
        $this->db->select("UNIT_ID");
        $this->db->from("UNIT");
        $BDLY_INPUT_unittablequery = $this->db->get();
        foreach ($BDLY_INPUT_unittablequery->result_array() as $row)
        {
            $BDLY_INPUT_unittabledata[] = $row["UNIT_ID"];
        }
        $BDLY_INPUT_unittable=($BDLY_INPUT_unittabledata);

        //CUSTOMER TABLE
        $this->db->select("CUSTOMER_ID");
        $this->db->from("CUSTOMER");
        $BDLY_INPUT_customerquery = $this->db->get();
        foreach ($BDLY_INPUT_customerquery->result_array() as $row)
        {
            $BDLY_INPUT_customerdata[] = $row["CUSTOMER_ID"];
        }
        $BDLY_INPUT_customer=($BDLY_INPUT_customerdata);

        //CUSTOMER ENTRY DETAILS
        $this->db->select("CED_ID");
        $this->db->from("CUSTOMER_ENTRY_DETAILS");
        $BDLY_INPUT_customerentrydetailsquery = $this->db->get();
        foreach ($BDLY_INPUT_customerentrydetailsquery->result_array() as $row)
        {
            $BDLY_INPUT_customerentrydetailsdata[] = $row["CED_ID"];
        }
        $BDLY_INPUT_customerentrydetails=($BDLY_INPUT_customerentrydetailsdata);

        //AIRCON SERVICE
        $this->db->select("EDAS_ID");
        $this->db->from("EXPENSE_DETAIL_AIRCON_SERVICE");
        $BDLY_INPUT_detailairconservicequery = $this->db->get();
        foreach ($BDLY_INPUT_detailairconservicequery->result_array() as $row)
        {
            $BDLY_INPUT_detailairconservicedata[] = $row["EDAS_ID"];
        }
        $BDLY_INPUT_detailairconservice=$BDLY_INPUT_detailairconservicedata;

        //EXPENSE DETAILS CARPARK
        $this->db->select("EDCP_ID");
        $this->db->from("EXPENSE_DETAIL_CARPARK");
        $BDLY_INPUT_detailcarparkquery = $this->db->get();
        foreach ($BDLY_INPUT_detailcarparkquery->result_array() as $row)
        {
            $BDLY_INPUT_detailcarparkdata[] = $row["EDCP_ID"];
        }
        $BDLY_INPUT_detailcarpark=($BDLY_INPUT_detailcarparkdata);

        //CHECK EXPENSE_DETAIL_DIGITAL_VOICE TABLE//
        $this->db->select("EDDV_ID");
        $this->db->from("EXPENSE_DETAIL_DIGITAL_VOICE");
        $BDLY_INPUT_detaildigitalvoicequery = $this->db->get();
        foreach ($BDLY_INPUT_detaildigitalvoicequery->result_array() as $row)
        {
            $BDLY_INPUT_detaildigitalvoicedata[] = $row["EDDV_ID"];
        }
        $BDLY_INPUT_detaildigitalvoice=($BDLY_INPUT_detaildigitalvoicedata);

        //CHECK EXPENSE_DETAIL_STARHUB TABLE//
        $this->db->select("EDSH_ID");
        $this->db->from("EXPENSE_DETAIL_STARHUB");
        $BDLY_INPUT_detailstarhubquery = $this->db->get();
        foreach ($BDLY_INPUT_detailstarhubquery->result_array() as $row)
        {
            $BDLY_INPUT_detailstarhubdata[] = $row["EDSH_ID"];
        }
        $BDLY_INPUT_detailstarhub=($BDLY_INPUT_detailstarhubdata);

        //CHECK EXPENSE_DETAIL_ELECTRICITY TABLE//
        $this->db->select("EDE_ID");
        $this->db->from("EXPENSE_DETAIL_ELECTRICITY");
        $BDLY_INPUT_detailelecticityquery = $this->db->get();
        foreach ($BDLY_INPUT_detailelecticityquery->result_array() as $row)
        {
            $BDLY_INPUT_detailelecticitydata[] = $row["EDE_ID"];
        }
        $BDLY_INPUT_detailelecticity=($BDLY_INPUT_detailelecticitydata);

        //EMPLOYEE DETAILS TABLE//
        $this->db->select("EMP_ID");
        $this->db->from("EMPLOYEE_DETAILS");
        $BDLY_INPUT_empdetails = $this->db->get();
        foreach ($BDLY_INPUT_empdetails->result_array() as $row)
        {
            $BDLY_INPUT_empdetailsdata[] = $row["EMP_ID"];
        }
        $BDLY_INPUT_empdetailsarry=($BDLY_INPUT_empdetailsdata);


        $BDLY_INPUT_expanse_arrayvalues=array("BDLY_INPUT_empdetailsarry"=>$BDLY_INPUT_empdetailsarry,"BDLY_INPUT_tableerrmsgarr"=>$ErrorMessage,"BDLY_INPUT_detailstarhub"=>$BDLY_INPUT_detailstarhub,"BDLY_INPUT_detailelecticity"=>$BDLY_INPUT_detailelecticity,"BDLY_INPUT_detailairconservice"=>$BDLY_INPUT_detailairconservice,"BDLY_INPUT_detailcarpark"=>$BDLY_INPUT_detailcarpark,"BDLY_INPUT_detaildigitalvoice"=>$BDLY_INPUT_detaildigitalvoice, "BDLY_INPUT_unittable"=>$BDLY_INPUT_unittable,"BDLY_INPUT_customer"=>$BDLY_INPUT_customer,"BDLY_INPUT_customerentrydetails"=>$BDLY_INPUT_customerentrydetails,"BDLY_INPUT_expanse_array"=>$BDLY_INPUT_expanse_array);
        $BDLY_INPUT_errorarray=($BDLY_INPUT_expanse_arrayvalues);

       return $BDLY_INPUT_errorarray;

    }

    public function BDLY_INPUT_checkexistunit($BDLY_INPUT_unitval)
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $HKPunitflag=$this->Mdl_eilib_common_function->CheckHKPUnitnoExists($BDLY_INPUT_unitval);
        $Unitnoflag=$this->Mdl_eilib_common_function->CheckUnitnoExists($BDLY_INPUT_unitval);
        if($HKPunitflag==true || $Unitnoflag==true)
        {
            return true;
        }
        else{
            return false;
        }
    }
    //GET THE UNIT NUMBER//
    public function BDLY_INPUT_get_unitno($BDLY_INPUT_type)
    {

      $BDLY_INPUT_unitno_array=[];
      $BDLY_INPUT_unit_autocomplete=[];
      $BDLY_INPUT_select_unitno=[];
      $BDLY_INPUT_select_unitno[9]="SELECT DISTINCT U.UNIT_NO FROM UNIT U,EXPENSE_DETAIL_AIRCON_SERVICE AIRCONDTL WHERE (U.UNIT_ID=AIRCONDTL.UNIT_ID) ORDER BY U.UNIT_NO ASC";
      $BDLY_INPUT_select_unitno[8]="SELECT DISTINCT U.UNIT_NO FROM UNIT U,EXPENSE_DETAIL_CARPARK CARPARKDTL WHERE (U.UNIT_ID=CARPARKDTL.UNIT_ID) ORDER BY U.UNIT_NO ASC";
      $BDLY_INPUT_select_unitno[5]="SELECT DISTINCT U.UNIT_NO FROM UNIT U,EXPENSE_DETAIL_DIGITAL_VOICE DIGITALDTL WHERE (U.UNIT_ID=DIGITALDTL.UNIT_ID) ORDER BY U.UNIT_NO ASC";
      $BDLY_INPUT_select_unitno[1]="SELECT DISTINCT U.UNIT_NO FROM UNIT U,EXPENSE_DETAIL_ELECTRICITY EDE WHERE (U.UNIT_ID=EDE.UNIT_ID) ORDER BY U.UNIT_NO ASC";
      $BDLY_INPUT_select_unitno[2]="SELECT DISTINCT U.UNIT_NO FROM UNIT U,EXPENSE_DETAIL_STARHUB EDSH WHERE (U.UNIT_ID=EDSH.UNIT_ID) ORDER BY U.UNIT_NO ASC";
      if(($BDLY_INPUT_type==4)||($BDLY_INPUT_type==6)||($BDLY_INPUT_type==7)||( $BDLY_INPUT_type==3))
      {
         $BDLY_INPUT_select_unitno[$BDLY_INPUT_type]="SELECT DISTINCT UNIT_NO FROM UNIT ORDER BY UNIT_NO ASC";
      }
        $BDLY_INPUT_unitno_rs=$this->db->query($BDLY_INPUT_select_unitno[$BDLY_INPUT_type]);
        foreach ($BDLY_INPUT_unitno_rs->result_array() as $row)
        {
            $BDLY_INPUT_unitno_array[]=$row['UNIT_NO'];
        }

        $this->db->select("EU_INVOICE_FROM");
        $this->db->from("EXPENSE_UNIT");
        $BDLY_getinvoicefrom = $this->db->get();
        foreach ($BDLY_getinvoicefrom->result_array() as $row)
        {
            $BDLY_INPUT_unit_autocomplete[]=$row['EU_INVOICE_FROM'];
        }
        return [$BDLY_INPUT_unitno_array,$BDLY_INPUT_unit_autocomplete];
  }
    //GET THE PETTY CASH BALANCE//
    public function BDLY_INPUT_get_balance(){
        $BDLY_INPUT_select_pettybalance=$this->db->query("SELECT EPC_BALANCE,EPC_DATE FROM EXPENSE_PETTY_CASH ORDER BY EPC_ID DESC");
        if ($BDLY_INPUT_select_pettybalance->num_rows() > 0)
        {
            $row = $BDLY_INPUT_select_pettybalance->row();
            $BDLY_INPUT_opening_blns = $row->EPC_BALANCE;
            $BDLY_INPUT_pettydate=$row->EPC_DATE;
        }
        if($BDLY_INPUT_opening_blns==null || $BDLY_INPUT_opening_blns=="")
        {
            $BDLY_INPUT_opening_blns='0.00';
        }
        else
        {
            $BDLY_INPUT_opening_blns=$BDLY_INPUT_opening_blns;
        }
        $BDLY_INPUT_opening_blnsarry[]=$BDLY_INPUT_opening_blns;
        $BDLY_INPUT_opening_blnsarry[]=$BDLY_INPUT_pettydate;

    return $BDLY_INPUT_opening_blnsarry;
  }
    //FUNCTION TO GET THE CLEANER NAME//
    public function BDLY_INPUT_get_cleanername(){
        $BDLY_INPUT_cleanername=[];
        $BDLY_INPUT_selectcleanername=$this->db->query("SELECT DISTINCT ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME,ED.EMP_ID FROM EMPLOYEE_DETAILS ED,EXPENSE_CONFIGURATION EXPCONFIG WHERE (EXPCONFIG.ECN_ID=ED.ECN_ID) AND (EXPCONFIG.ECN_ID=75) ORDER BY ED.EMP_FIRST_NAME ASC");
        foreach ($BDLY_INPUT_selectcleanername->result_array() as $row)
        {
            $BDLY_INPUT_firstname=$row['EMP_FIRST_NAME'];
            $BDLY_INPUT_lastname=$row['EMP_LAST_NAME'];
            $BDLY_INPUT_empid=$row['EMP_ID'];
            $BDLY_INPUT_cleanername[]=(object)['BDLY_INPUT_cleanername'=>$BDLY_INPUT_firstname.' '.$BDLY_INPUT_lastname,'BDLY_INPUT_empid'=>$BDLY_INPUT_empid];
        }
        return $BDLY_INPUT_cleanername;
    }
    //GET ALL UNIT NO//
    public function BDLY_INPUT_get_allunitno()
    {
        $BDLY_INPUT_BDLY_INPUT_allunitArray=[];
        $BDLY_INPUT_getallunitfromunit=$this->db->query("SELECT UNIT_NO from UNIT");
        foreach ($BDLY_INPUT_getallunitfromunit->result_array() as $row)
        {
            $BDLY_INPUT_allUNITNUMBER[]=$row['UNIT_NO'];
        }
//        $BDLY_INPUT_BDLY_INPUT_allunitArray[]=$BDLY_INPUT_allUNITNUMBER;
        $BDLY_INPUT_getallunitfromhku=$this->db->query("SELECT DISTINCT EHU.EHKU_UNIT_NO  from EXPENSE_HOUSEKEEPING_UNIT EHU ,EXPENSE_HOUSEKEEPING_PAYMENT EHP WHERE EHU.EHKU_ID = EHP.EHKU_ID ");
        foreach ($BDLY_INPUT_getallunitfromhku->result_array() as $row)
        {
            $BDLY_INPUT_allUNITNUMBERhku[]=$row['EHKU_UNIT_NO'];
        }
        $BDLY_INPUT_BDLY_INPUT_allunitArray=array_merge($BDLY_INPUT_allUNITNUMBER,$BDLY_INPUT_allUNITNUMBERhku);

        return $BDLY_INPUT_BDLY_INPUT_allunitArray;
    }
    //GET THE VALUES FOR LOADING IN THE FORM//
    public function BDLY_INPUT_get_values($BDLY_INPUT_unitno,$BDLY_INPUT_type)
    {
     $BDLY_INPUT_values_array=[];
    if($BDLY_INPUT_type==9)
    {
        $BDLY_INPUT_select_serviceby=$this->db->query("SELECT AIRCONDTL.EDAS_ID,EAS.EASB_DATA FROM EXPENSE_DETAIL_AIRCON_SERVICE AIRCONDTL,UNIT U,EXPENSE_AIRCON_SERVICE_BY EAS WHERE (U.UNIT_ID=AIRCONDTL.UNIT_ID) AND U.UNIT_NO='$BDLY_INPUT_unitno' and (EAS.EASB_ID=AIRCONDTL.EASB_ID) ORDER BY AIRCONDTL.EDAS_REC_VER DESC");
        $BDLY_INPUT_serviceby_rs= $BDLY_INPUT_select_serviceby->row()->EASB_DATA;
        $BDLY_INPUT_edasid= $BDLY_INPUT_select_serviceby->row()->EDAS_ID;
        $BDLY_INPUT_values_array[]=(object)['BDLY_INPUT_airconserviceby'=>$BDLY_INPUT_serviceby_rs,'BDLY_INPUT_edasid'=>$BDLY_INPUT_edasid];
      }
    if($BDLY_INPUT_type==8)
    {
        $BDLY_INPUT_select_carno=$this->db->query("SELECT EDCP_CAR_NO,EDCP_ID FROM EXPENSE_DETAIL_CARPARK CARPARKDTL,UNIT U WHERE (U.UNIT_ID=CARPARKDTL.UNIT_ID) AND U.UNIT_NO='$BDLY_INPUT_unitno' ORDER BY CARPARKDTL.EDCP_REC_VER DESC");
        $BDLY_INPUT_carno_rs= $BDLY_INPUT_select_carno->row()->EDCP_CAR_NO;
        $BDLY_INPUT_carno_id= $BDLY_INPUT_select_carno->row()->EDCP_ID;
        $BDLY_INPUT_values_array[]=(object)['BDLY_INPUT_carno_data'=>$BDLY_INPUT_carno_rs,'BDLY_INPUT_carno_id'=>$BDLY_INPUT_carno_id];
    }
    if($BDLY_INPUT_type==5)
    {
        $BDLY_INPUT_select_digivoice=$this->db->query("SELECT EDDV.UNIT_ID,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO FROM EXPENSE_DETAIL_DIGITAL_VOICE EDDV LEFT JOIN EXPENSE_CONFIGURATION EC ON (EDDV.ECN_ID=EC.ECN_ID),UNIT U WHERE (U.UNIT_NO='$BDLY_INPUT_unitno') AND (EDDV.UNIT_ID=U.UNIT_ID) ORDER BY EDDV.EDDV_REC_VER DESC");
        foreach ($BDLY_INPUT_select_digivoice->result_array() as $row)
        {
            $BDLY_INPUT_invoiceto=$row['ECN_DATA'];
            $BDLY_INPUT_digital_voiceno=$row['EDDV_DIGITAL_VOICE_NO'];
            $BDLY_INPUT_digital_accno=$row['EDDV_DIGITAL_ACCOUNT_NO'];
        }
        if($BDLY_INPUT_invoiceto==null)
            $BDLY_INPUT_invoiceto='';
        $BDLY_INPUT_values_array=array($BDLY_INPUT_invoiceto,$BDLY_INPUT_digital_voiceno,$BDLY_INPUT_digital_accno);
    }
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $BDLY_INPUT_getsedate=$this->Mdl_eilib_common_function->GetUnitSdEdInvdate($BDLY_INPUT_unitno);

        $BDLY_INPUT_values_array[]=$BDLY_INPUT_getsedate;

       return $BDLY_INPUT_values_array;
  }
    //GET THE PAYMENT  VALUES//
   public  function BDLY_INPUT_get_invoiceto($BDLY_INPUT_unit)
    {
      $BDLY_INPUT_select_invoieto=$this->db->query("SELECT EC.ECN_DATA,EDE.ECN_ID FROM EXPENSE_DETAIL_ELECTRICITY EDE,EXPENSE_CONFIGURATION EC ,UNIT U WHERE (EDE.UNIT_ID =U.UNIT_ID) AND (EC.ECN_ID=EDE.ECN_ID)AND(U.UNIT_NO='$BDLY_INPUT_unit') ORDER BY EDE.EDE_REC_VER DESC");
        foreach ($BDLY_INPUT_select_invoieto->result_array() as $row)
        {
            $BDLY_INPUT_invoiceto=$row['ECN_DATA'];
            $BDLY_INPUT_invoicetoid=$row['ECN_ID'];
        }
//    $BDLY_INPUT_elect_values_array=[];
        $BDLY_INPUT_elect_values_array[]=$BDLY_INPUT_invoiceto;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $BDLY_INPUT_getsedate=$this->Mdl_eilib_common_function->GetUnitSdEdInvdate($BDLY_INPUT_unit);
        $BDLY_INPUT_elect_values_array[]=$BDLY_INPUT_getsedate;
        $BDLY_INPUT_elect_values_array[]=$BDLY_INPUT_invoicetoid;
    return $BDLY_INPUT_elect_values_array;
  }
    //GET THE ACCESS CARD VALUE//
    public function BDLY_INPUT_checkcardno($BDLY_INPUT_cardno)
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $BDLY_INPUT_cardexist=$this->Mdl_eilib_common_function->Check_ExistsCard($BDLY_INPUT_cardno);
      return $BDLY_INPUT_cardexist;
    }

    //GET THE CATEGORY FROM EXPENSE_CONFIGURATION//
    public function BDLY_INPUT_get_category($BDLY_INPUT_uexp_unit)
     {
      $BDLY_INPUT_namearray=[];
      $BDLY_INPUT_select_customername =$this->db->query("SELECT DISTINCT CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS CNAME,CED.CUSTOMER_ID FROM CUSTOMER C,CUSTOMER_ENTRY_DETAILS CED,UNIT U WHERE (CED.CUSTOMER_ID=C.CUSTOMER_ID) AND (U.UNIT_NO='$BDLY_INPUT_uexp_unit') AND (CED.UNIT_ID=U.UNIT_ID) ORDER BY C.CUSTOMER_FIRST_NAME ASC");
         $BDLY_INPUT_custname=[];
         $BDLY_INPUT_custid=[];
         foreach ($BDLY_INPUT_select_customername->result_array() as $row)
         {
             $BDLY_INPUT_custname=$row['CNAME'];
             $BDLY_INPUT_custid=$row['CUSTOMER_ID'];
             $BDLY_INPUT_namearray[]=(object)['BDLY_INPUT_custname'=>$BDLY_INPUT_custname,'BDLY_INPUT_custid'=>$BDLY_INPUT_custid];
         }
         $BDLY_INPUT_unitexp_values=[];
         $BDLY_INPUT_unitexp_values[]=$BDLY_INPUT_namearray;
         $this->load->model('EILIB/Mdl_eilib_common_function');
         $BDLY_INPUT_getsedate=$this->Mdl_eilib_common_function->GetUnitSdEdInvdate($BDLY_INPUT_uexp_unit);
         $BDLY_INPUT_unitexp_values[]=$BDLY_INPUT_getsedate;
         return $BDLY_INPUT_unitexp_values;
     }
//FUNCTION TO GET STAR HUB VALUES//
  public function BDLY_INPUT_get_accno($BDLY_INPUT_star_unitt)
  {

     $BDLY_INPUT_starhubinvoicetovalues = $this->db->query("SELECT EC.ECN_DATA,EDSH.ECN_ID,EDSH.EDSH_ACCOUNT_NO FROM EXPENSE_DETAIL_STARHUB EDSH LEFT JOIN EXPENSE_CONFIGURATION EC ON (EDSH.ECN_ID=EC.ECN_ID) WHERE (EDSH.UNIT_ID =(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='$BDLY_INPUT_star_unitt'))  ORDER BY EDSH.EDSH_REC_VER DESC");
      foreach ($BDLY_INPUT_starhubinvoicetovalues->result_array() as $row)
      {
          $BDLY_INPUT_invoiceto=$row['ECN_DATA'];
          $BDLY_INPUT_accno=$row['EDSH_ACCOUNT_NO'];
          $BDLY_INPUT_starhubecnid=$row['ECN_ID'];
      }
      $BDLY_INPUT_starhub_values=array($BDLY_INPUT_accno,$BDLY_INPUT_invoiceto,$BDLY_INPUT_starhubecnid);
      $this->load->model('EILIB/Mdl_eilib_common_function');
      $BDLY_INPUT_getsedate=$this->Mdl_eilib_common_function->GetUnitSdEdInvdate($BDLY_INPUT_star_unitt);
      $BDLY_INPUT_starhub_values[]=$BDLY_INPUT_getsedate;
    return $BDLY_INPUT_starhub_values;
  }
    //SAVE ALL  FORM DATA IN THE TABLE//
    public function BDLY_INPUT_save_values($USERSTAMP)
    {
      $BDLY_INPUT_refresh=[];
      $BDLY_INPUT_exptype=$_POST['BDLY_INPUT_lb_selectexptype'];
      $BDLY_INPUT_unitno=$_POST['BDLY_INPUT_lb_unitno'];
      //AIRCON SERVICES SAVING PART//
      if($BDLY_INPUT_exptype==9){
         $BDLY_INPUT_serviceby=$_POST['BDLY_INPUT_tb_serviceby'];
          $BDLY_INPUT_invoicedate=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_air_date']));
          $BDLY_INPUT_comments=$this->db->escape_like_str($_POST['BDLY_INPUT_ta_aircon_comments']);
          if($BDLY_INPUT_comments=="")//COMMENTS
          {  $BDLY_INPUT_comments='null';
          }
          else
          {
              $BDLY_INPUT_comments="'$BDLY_INPUT_comments'";
          }
          $BDLY_INPUT_airconid=trim($_POST['BDLY_INPUT_hidden_edasid']);
          $BDLY_INPUT_insert_aircon=$this->db->query("INSERT INTO EXPENSE_AIRCON_SERVICE(EDAS_ID,EAS_DATE,EAS_COMMENTS,ULD_ID)values('$BDLY_INPUT_airconid','$BDLY_INPUT_invoicedate',$BDLY_INPUT_comments,(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'))");
      }
      //CAR PARK SAVING PART//
      if($BDLY_INPUT_exptype==8){
          $BDLY_INPUT_carno=$_POST['BDLY_INPUT_tb_carno'];
          $BDLY_INPUT_cp_invoicedate=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_cp_invoicedate']));
          $BDLY_INPUT_cp_invoiceamt=$_POST['BDLY_INPUT_tb_cp_invoiceamt'];
          $BDLY_INPUT_cp_fromdate=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_cp_fromdate']));
          $BDLY_INPUT_cp_todate=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_cp_todate']));
          $BDLY_INPUT_cp_comments=$this->db->escape_like_str($_POST['BDLY_INPUT_ta_cp_comments']);
          $BDLY_INPUT_edcpid=$_POST['BDLY_INPUT_hidden_edcpid'];
          if($BDLY_INPUT_cp_comments=="")//COMMENTS
          { $BDLY_INPUT_cp_comments='null';}else{
              $BDLY_INPUT_cp_comments="'$BDLY_INPUT_cp_comments'";}

          $BDLY_INPUT_insert_carpark = $this->db->query("INSERT INTO EXPENSE_CARPARK (ULD_ID,EDCP_ID,ECP_INVOICE_DATE,ECP_FROM_PERIOD,ECP_TO_PERIOD,ECP_AMOUNT,ECP_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$BDLY_INPUT_edcpid','$BDLY_INPUT_cp_invoicedate','$BDLY_INPUT_cp_fromdate','$BDLY_INPUT_cp_todate','$BDLY_INPUT_cp_invoiceamt',$BDLY_INPUT_cp_comments)");

       }
       //PURCHASE NEW ACCESS CARD SAVING PART//
      if($BDLY_INPUT_exptype==6){
          $BDLY_INPUT_access_cardno=$_POST['BDLY_INPUT_tb_access_cardno'];
          $BDLY_INPUT_access_date=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_access_date']));
          $BDLY_INPUT_access_invoiceamt=$_POST['BDLY_INPUT_tb_access_invoiceamt'];
          $BDLY_INPUT_access_comments=$this->db->escape_like_str($_POST['BDLY_INPUT_ta_access_comments']);
          if($BDLY_INPUT_access_comments=="")//COMMENTS
          { $BDLY_INPUT_access_comments='null';}else{
              $BDLY_INPUT_access_comments="'$BDLY_INPUT_access_comments'";
          }

          $BDLY_INPUT_insert_card=$this->db->query("CALL SP_BIZDLY_PURCHASE_NEW_CARD_INSERT('$BDLY_INPUT_unitno','$BDLY_INPUT_access_cardno','$BDLY_INPUT_access_date','$BDLY_INPUT_access_invoiceamt',$BDLY_INPUT_access_comments,'$USERSTAMP',@FLAG_INSERT)");
      }
      //PETTY CASH SAVING PART//
      if($BDLY_INPUT_exptype==10)
      {
          $BDLY_INPUT_petty_cashin=$_POST['BDLY_INPUT_tb_petty_cashin'];
          $BDLY_INPUT_petty_date=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_petty_date']));
          $BDLY_INPUT_petty_cashout=$_POST['BDLY_INPUT_tb_petty_cashout'];
          if($BDLY_INPUT_petty_cashout==''){
              $BDLY_INPUT_petty_cashout='null';
          }
          else{
              $BDLY_INPUT_petty_cashout="'$BDLY_INPUT_petty_cashout'";
          }
          if($BDLY_INPUT_petty_cashin==''){
              $BDLY_INPUT_petty_cashin='null';
          }
          else{
              $BDLY_INPUT_petty_cashin="'$BDLY_INPUT_petty_cashin'";
          }
          $BDLY_INPUT_petty_comments=$this->db->escape_like_str($_POST['BDLY_INPUT_ta_petty_comments']);
          $BDLY_INPUT_petty_invoiceitem=$_POST['BDLY_INPUT_ta_petty_invoiceitem'];
          if($BDLY_INPUT_petty_invoiceitem!='')
              $BDLY_INPUT_petty_invoiceitem=$this->db->escape_like_str($BDLY_INPUT_petty_invoiceitem);
        if($BDLY_INPUT_petty_comments=="")//COMMENTS
        { $BDLY_INPUT_petty_comments='null';}else{
            $BDLY_INPUT_petty_comments="'$BDLY_INPUT_petty_comments'";}
      $BDLY_INPUT_pettysave_stmt=$this->db->query("CALL SP_BIZDLY_PETTY_CASH_INSERT('$USERSTAMP','$BDLY_INPUT_petty_date',$BDLY_INPUT_petty_cashin,$BDLY_INPUT_petty_cashout,'$BDLY_INPUT_petty_invoiceitem',$BDLY_INPUT_petty_comments,@FLAG_INSERT)");
      $BDLY_INPUT_refresh=$this->BDLY_INPUT_get_balance();
      }
      //MOVING IN AND OUT SAVING PART//
      if($BDLY_INPUT_exptype==7){
          $BDLY_INPUT_moving_date=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_mov_date']));
          $BDLY_INPUT_moving_invoiceamt=$_POST['BDLY_INPUT_tb_mov_invoiceamt'];
          $BDLY_INPUT_moving_comments=$this->db->escape_like_str($_POST['BDLY_INPUT_ta_mov_comments']);
          if($BDLY_INPUT_moving_comments=="")//COMMENTS
          { $BDLY_INPUT_moving_comments='null';}else{
              $BDLY_INPUT_moving_comments="'$BDLY_INPUT_moving_comments'";}
          $BDLY_INPUT_insert_moving = $this->db->query("INSERT INTO EXPENSE_MOVING_IN_AND_OUT (ULD_ID,UNIT_ID,EMIO_INVOICE_DATE,EMIO_AMOUNT,EMIO_COMMENTS) VALUES ((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),(SELECT UNIT_ID FROM UNIT U WHERE U.UNIT_NO='$BDLY_INPUT_unitno'),'$BDLY_INPUT_moving_date','$BDLY_INPUT_moving_invoiceamt',$BDLY_INPUT_moving_comments)");
      }
      //UNIT EXPENSE SAVING PART//
      if($BDLY_INPUT_exptype==3){
          $BDLY_INPUT_unitnovalue=$_POST['BDLY_INPUT_hidden_customerid'];
          $BDLY_INPUT_unitnovalue=$_POST['BDLY_INPUT_lb_uexp_unit'];
          $BDLY_INPUT_categoryvalue=$_POST['BDLY_INPUT_lb_uexp_category'];
          $BDLY_INPUT_customervalue=$_POST['BDLY_INPUT_lb_uexp_customer'];
          $BDLY_INPUT_customerid=$_POST['BDLY_INPUT_tb_uexp_hideradioid'];
          $BDLY_INPUT_invoicedatevalue=$_POST['BDLY_INPUT_db_uexp_invoicedate'];
          $BDLY_INPUT_amountvalue=$_POST['BDLY_INPUT_tb_uexp_amount'];
          $BDLY_INPUT_invoiceitemvalue=$_POST['BDLY_INPUT_tb_uexp_invoiceitem'];
          $BDLY_INPUT_invoicefromvalue=$_POST['BDLY_INPUT_tb_uexp_invoicefrom'];
          $BDLY_INPUT_commentsvalue=$_POST['BDLY_INPUT_ta_uexpcomments'];
          $BDLY_INPUT_comments_split=''; $BDLY_INPUT_invfrom_split='';$BDLY_INPUT_invitem_split='';
          $BDLY_INPUT_unitnovalue_split='';$BDLY_INPUT_categoryvalue_split='';$BDLY_INPUT_customervalue_split='';
          $BDLY_INPUT_customerid_split='';$BDLY_INPUT_invoicedatevalue_split='';$BDLY_INPUT_amountvalue_split='';

          if((is_array($BDLY_INPUT_commentsvalue))==true){
              for($i=0;$i<count($BDLY_INPUT_invoicefromvalue);$i++)
              {
            if($BDLY_INPUT_commentsvalue[$i]=='')
            {
                if($i==0)
                    $BDLY_INPUT_comments_split =' ';
                  else
                      $BDLY_INPUT_comments_split .='^^'.' '; }
              else
              {
                if($i==0){
                    $BDLY_INPUT_comments_split =$this->db->escape_like_str($BDLY_INPUT_commentsvalue[$i]);
                }
                else{
                    $BDLY_INPUT_comments_split .='^^'.$this->db->escape_like_str($BDLY_INPUT_commentsvalue[$i]);
                }
              }
              if($i==0){
                  $BDLY_INPUT_invitem_split =$this->db->escape_like_str($BDLY_INPUT_invoiceitemvalue[$i]);
                  $BDLY_INPUT_invfrom_split =$this->db->escape_like_str($BDLY_INPUT_invoicefromvalue[$i]);
                  $BDLY_INPUT_unitnovalue_split=$BDLY_INPUT_unitnovalue[$i];
                  $BDLY_INPUT_categoryvalue_split=$BDLY_INPUT_categoryvalue[$i];
                  $BDLY_INPUT_customervalue_split=$BDLY_INPUT_customervalue[$i];
                  if($BDLY_INPUT_categoryvalue[$i]!=23)
                  {
                      $BDLY_INPUT_customerid_split='';
                  }
                  else{
                      $BDLY_INPUT_customerid_split=$BDLY_INPUT_customerid[$i];
                  }
                  $BDLY_INPUT_invoicedatevalue_split=date('Y-m-d',strtotime($BDLY_INPUT_invoicedatevalue[$i]));
                  $BDLY_INPUT_amountvalue_split=$BDLY_INPUT_amountvalue[$i];
              }
              else{
                  $BDLY_INPUT_invitem_split .='^^'.$this->db->escape_like_str($BDLY_INPUT_invoiceitemvalue[$i]);
                  $BDLY_INPUT_invfrom_split .='^^'.$this->db->escape_like_str($BDLY_INPUT_invoicefromvalue[$i]);
                  $BDLY_INPUT_unitnovalue_split.=','.$BDLY_INPUT_unitnovalue[$i];
                  $BDLY_INPUT_categoryvalue_split.=','.$BDLY_INPUT_categoryvalue[$i];
                  $BDLY_INPUT_customervalue_split.=','.$BDLY_INPUT_customervalue[$i];
                  if($BDLY_INPUT_categoryvalue[$i]!=23)
                  {
                      $BDLY_INPUT_customerid_split.=','.'';
                  }
                  else{
                  $BDLY_INPUT_customerid_split.=','.$BDLY_INPUT_customerid[$i];
                  }
                  $BDLY_INPUT_invoicedatevalue_split.=','.date('Y-m-d',strtotime($BDLY_INPUT_invoicedatevalue[$i]));
                  $BDLY_INPUT_amountvalue_split.=','.$BDLY_INPUT_amountvalue[$i];
              }
            }
          }
          else
          {
              if($BDLY_INPUT_commentsvalue=='')
                  $BDLY_INPUT_comments_split=' ';
              else
                  $BDLY_INPUT_comments_split=$this->db->escape_like_str($BDLY_INPUT_commentsvalue);
              if($BDLY_INPUT_customerid=='')
                  $BDLY_INPUT_customerid_split=' ';
              $BDLY_INPUT_invoicedatevalue_split=date('Y-m-d',strtotime($BDLY_INPUT_invoicedatevalue));
              $BDLY_INPUT_invitem_split=$this->db->escape_like_str($BDLY_INPUT_invoiceitemvalue);
              $BDLY_INPUT_invfrom_split=$this->db->escape_like_str($BDLY_INPUT_invoicefromvalue);
              $BDLY_INPUT_unitnovalue_split=$BDLY_INPUT_unitnovalue;
              $BDLY_INPUT_categoryvalue_split=$BDLY_INPUT_categoryvalue;
              $BDLY_INPUT_customervalue_split=$BDLY_INPUT_customervalue;
              $BDLY_INPUT_customerid_split=$BDLY_INPUT_customerid;
              $BDLY_INPUT_amountvalue_split=$BDLY_INPUT_amountvalue;
          }
          $BDLY_INPUT_unit_insertquery= $this->db->query("CALL SP_BIZDLY_UNIT_INSERT('$BDLY_INPUT_unitnovalue_split','$BDLY_INPUT_categoryvalue_split','$BDLY_INPUT_customerid_split','$BDLY_INPUT_invoicedatevalue_split','$BDLY_INPUT_amountvalue_split','$BDLY_INPUT_invitem_split','$BDLY_INPUT_invfrom_split','$BDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)");

      }
      //HOUSEKEEPING PAYMENT SAVING PART//
      if($BDLY_INPUT_exptype==12){
          $BDLY_INPUT_tb_payunitnonew='';
          $BDLY_INPUT_tb_payunitnoold='';
          if(isset($_POST['BDLY_INPUT_tb_pay_unitno'])) {
              $BDLY_INPUT_tb_payunitnoold = $_POST['BDLY_INPUT_tb_pay_unitno'];
          }
          if(isset($_POST['BDLY_INPUT_tb_pay_unitnocheck']))
          {
              $BDLY_INPUT_tb_payunitnonew=$_POST['BDLY_INPUT_tb_pay_unitnocheck'];
          }
          $BDLY_INPUT_tb_payunitno='';
          if($BDLY_INPUT_tb_payunitnoold=='')
          {
              $BDLY_INPUT_tb_payunitno=$BDLY_INPUT_tb_payunitnonew;
          }
          if($BDLY_INPUT_tb_payunitnonew=='')
          {
              $BDLY_INPUT_tb_payunitno=$BDLY_INPUT_tb_payunitnoold;
          }
          $BDLY_INPUT_tb_payinvoiceamt=$_POST['BDLY_INPUT_tb_pay_invoiceamt'];
          $BDLY_INPUT_tb_payforperiod=$_POST['BDLY_INPUT_tb_pay_forperiod'];
          $BDLY_INPUT_period=date("Y-m-01", strtotime($BDLY_INPUT_tb_payforperiod));

          $BDLY_INPUT_tb_paypaiddate=date("Y-m-d", strtotime($_POST['BDLY_INPUT_tb_pay_paiddate']));
          $BDLY_INPUT_ta_paycomments = $_POST['BDLY_INPUT_ta_pay_comments'];
          if($BDLY_INPUT_ta_paycomments!='') {
              $BDLY_INPUT_ta_paycomments = $this->db->escape_like_str($BDLY_INPUT_ta_paycomments);
              $BDLY_INPUT_ta_paycomments = "'$BDLY_INPUT_ta_paycomments'";
          }
          else
              $BDLY_INPUT_ta_paycomments="''";
          $BDLY_INPUT_hkp_savequery=$this->db->query("CALL SP_BIZDLY_HOUSEKEEPING_PAYMENT_INSERT('$BDLY_INPUT_tb_payunitno','$BDLY_INPUT_period','$BDLY_INPUT_tb_paypaiddate','$BDLY_INPUT_tb_payinvoiceamt',$BDLY_INPUT_ta_paycomments,'$USERSTAMP',@FLAG_INSERT)");
          $BDLY_INPUT_refresh=$this->BDLY_INPUT_get_allunitno();
         }
      //HOUSEKEEPING SAVING PART//
      if($BDLY_INPUT_exptype==11){
          $BDLY_INPUT_lb_housecleanername=$_POST['BDLY_INPUT_lb_house_cleanername'];
          $BDLY_INPUT_tb_housedate=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_house_date']));
          $BDLY_INPUT_tb_househours=$_POST['BDLY_INPUT_tb_house_hours'];
          $BDLY_INPUT_tb_housemin=$_POST['BDLY_INPUT_tb_house_min'];
          $BDLY_INPUT_ta_housedesc=$_POST['BDLY_INPUT_ta_house_desc'];
          if(isset($_POST['BDLY_INPUT_radio_hkname']))
          {
              $BDLY_INPUT_radio_hkname=$_POST['BDLY_INPUT_radio_hkname'];
          }
          $BDLY_INPUT_cleanerid=$_POST['BDLY_INPUT_hidden_edeid'];
            if($BDLY_INPUT_ta_housedesc!='')
              $BDLY_INPUT_ta_housedesc=$this->db->escape_like_str($BDLY_INPUT_ta_housedesc);

      if($BDLY_INPUT_tb_househours!=""&&$BDLY_INPUT_tb_housemin!="")
      {
          $BDLY_INPUT_duration=$BDLY_INPUT_tb_househours.'.'.$BDLY_INPUT_tb_housemin;
      }
      if($BDLY_INPUT_tb_househours!=""&&$BDLY_INPUT_tb_housemin=="")
      {
          $BDLY_INPUT_duration=$BDLY_INPUT_tb_househours.".".'00';
      }
      if($BDLY_INPUT_tb_househours==""&&$BDLY_INPUT_tb_housemin!="")
      {
          $BDLY_INPUT_duration='00'.".".$BDLY_INPUT_tb_housemin;
      }
      $BDLY_INPUT_hksavequery =$this->db->query("INSERT INTO EXPENSE_HOUSEKEEPING(ULD_ID,EHK_WORK_DATE,EHK_DURATION,EHK_DESCRIPTION,EMP_ID) VALUES ((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$BDLY_INPUT_tb_housedate','$BDLY_INPUT_duration','$BDLY_INPUT_ta_housedesc','$BDLY_INPUT_cleanerid')");
    }
      //FACILITY USE SAVING PART//
      if($BDLY_INPUT_exptype==4){
         $BDLY_INPUT_tb_payunitno=$_POST['BDLY_INPUT_lb_unitno'];
         $BDLY_INPUT_tb_facinvoicedate=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_fac_invoicedate']));
         $BDLY_INPUT_tb_facdepositamt=$_POST['BDLY_INPUT_tb_fac_depositamt'];
         $BDLY_INPUT_tb_facinvoiceamt=$_POST['BDLY_INPUT_tb_fac_invoiceamt'];
         $DLY_INPUT_ta_faccomments=$this->db->escape_like_str($_POST['BDLY_INPUT_ta_fac_comments']);
          if($BDLY_INPUT_tb_facdepositamt=="" || $BDLY_INPUT_tb_facdepositamt=='undefined')
          {
              $BDLY_INPUT_tb_facdepositamt='null';
          }
          else
          {
              $BDLY_INPUT_tb_facdepositamt="'$BDLY_INPUT_tb_facdepositamt'";
          }
          if($BDLY_INPUT_tb_facinvoiceamt=="" || $BDLY_INPUT_tb_facinvoiceamt=='undefined')
          {
              $BDLY_INPUT_tb_facinvoiceamt='null';
          }
          else{
              $BDLY_INPUT_tb_facinvoiceamt="'$BDLY_INPUT_tb_facinvoiceamt'";
          }
          if($DLY_INPUT_ta_faccomments=="")//COMMENTS
          {
              $DLY_INPUT_ta_faccomments='null';
          }
          else{
              $DLY_INPUT_ta_faccomments="'$DLY_INPUT_ta_faccomments'";
          }
          $BDLY_INPUT_facility_insertquery =$this->db->query("INSERT INTO EXPENSE_FACILITY_USE(ULD_ID,UNIT_ID,EFU_INVOICE_DATE,EFU_COMMENTS,EFU_AMOUNT,EFU_DEPOSIT) VALUES ((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),(SELECT UNIT_ID FROM UNIT U WHERE U.UNIT_NO='$BDLY_INPUT_tb_payunitno'),'$BDLY_INPUT_tb_facinvoicedate',$DLY_INPUT_ta_faccomments,$BDLY_INPUT_tb_facinvoiceamt,$BDLY_INPUT_tb_facdepositamt)");
      }
      //DIGITAL VOICE SAVING PART//
      if($BDLY_INPUT_exptype==5){
          $BDLY_INPUT_tb_digi_invoiceto='';
          $BDLY_INPUT_tb_digitovoice='';
          $BDLY_INPUT_tb_gigunitno=$_POST['BDLY_INPUT_lb_unitno'];
          $BDLY_INPUT_tb_digiinvoicedate=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_digi_invoicedate']));
          $BDLY_INPUT_tb_digifromdate=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_digi_fromdate']));
          $BDLY_INPUT_tb_digitodate=date('Y-m-d',strtotime($_POST['BDLY_INPUT_tb_digi_todate']));
          if(isset($_POST['BDLY_INPUT_lb_digi_invoiceto']))
          {
          $BDLY_INPUT_tb_digitovoice=$_POST['BDLY_INPUT_lb_digi_invoiceto'];
          }
          $BDLY_INPUT_tb_digiinvoiceamt=$_POST['BDLY_INPUT_tb_digi_invoiceamt'];
          $BDLY_INPUT_ta_digicomments=$_POST['BDLY_INPUT_ta_digi_comments'];
          if($BDLY_INPUT_ta_digicomments!='')
              $BDLY_INPUT_ta_digicomments=$this->db->escape_like_str($BDLY_INPUT_ta_digicomments);
          if(isset($_POST['BDLY_INPUT_tb_digi_invoiceto'])) {
              $BDLY_INPUT_tb_digi_invoiceto = $_POST['BDLY_INPUT_tb_digi_invoiceto'];
          }
      if($BDLY_INPUT_tb_digi_invoiceto=='')
        $BDLY_INPUT_digitalsavequery =$this->db->query("CALL SP_BIZDLY_DIGITAL_VOICE_INSERT('$BDLY_INPUT_tb_gigunitno','$BDLY_INPUT_tb_digitovoice','$BDLY_INPUT_tb_digiinvoicedate','$BDLY_INPUT_tb_digifromdate','$BDLY_INPUT_tb_digitodate','$BDLY_INPUT_tb_digiinvoiceamt','$BDLY_INPUT_ta_digicomments','$USERSTAMP',@FLAG_INSERT)");
      else
      $BDLY_INPUT_digitalsavequery = $this->db->query("CALL SP_BIZDLY_DIGITAL_VOICE_INSERT('$BDLY_INPUT_tb_gigunitno',(SELECT ECN_ID FROM EXPENSE_CONFIGURATION WHERE ECN_DATA='$BDLY_INPUT_tb_digi_invoiceto' AND CGN_ID=27),'$BDLY_INPUT_tb_digiinvoicedate','$BDLY_INPUT_tb_digifromdate','$BDLY_INPUT_tb_digitodate','$BDLY_INPUT_tb_digiinvoiceamt','$BDLY_INPUT_ta_digicomments','$USERSTAMP',@FLAG_INSERT)");
      }
      //ELECTRICITY SAVE FUNCTION//
      if($BDLY_INPUT_exptype==1){
          $BDLY_INPUT_electunit=$_POST['BDLY_INPUT_lb_elect_unit'];
          $BDLY_INPUT_invoiceto=$_POST['BDLY_INPUT_lb_elect_payment'];
          $BDLY_INPUT_invoicedate=$_POST['BDLY_INPUT_db_invoicedate'];
          $BDLY_INPUT_elect_amount=$_POST['BDLY_INPUT_hidden_amt_elec'];
          $BDLY_INPUT_fromperiod=$_POST['BDLY_INPUT_db_fromperiod'];
          $BDLY_INPUT_toperiod=$_POST['BDLY_INPUT_db_toperiod'];
          $BDLY_INPUT_elect_payment=$_POST['BDLY_INPUT_lb_elect_payment'];
          $BDLY_INPUT_comments=$_POST['BDLY_INPUT_ta_comments'];
          $BDLY_INPUT_comments_split=[];
          $BDLY_INPUT_fromperiod_split=[];
          $BDLY_INPUT_invoicedate_split=[];
          $BDLY_INPUT_toperiod_split=[];
          $BDLY_INPUT_electunit_split=[];
          $BDLY_INPUT_invoiceto_split=[];
          $BDLY_INPUT_elect_amount_split=[];
          $BDLY_INPUT_elect_payment_split=[];
          if((is_array($BDLY_INPUT_comments))==true){
              for($i=0;$i<count($BDLY_INPUT_comments);$i++)
             {
                if($BDLY_INPUT_comments[$i]==''){
                if($i==0)
                    $BDLY_INPUT_comments_split =' ';
                  else
                      $BDLY_INPUT_comments_split .='^^'.' ';
                }
              else{
                if($i==0)
                {
                   $BDLY_INPUT_comments_split =$this->db->escape_like_str($BDLY_INPUT_comments[$i]);
                }
                else
                {
                  $BDLY_INPUT_comments_split .='^^'.$this->db->escape_like_str($BDLY_INPUT_comments[$i]);
                }
              }
           if($i==0)
           {
               $BDLY_INPUT_electunit_split=$BDLY_INPUT_electunit[$i];
               $BDLY_INPUT_invoiceto_split=$BDLY_INPUT_invoiceto[$i];
               $BDLY_INPUT_invoicedate_split=date('Y-m-d',strtotime($BDLY_INPUT_invoicedate[$i]));
               $BDLY_INPUT_fromperiod_split=date('Y-m-d',strtotime($BDLY_INPUT_fromperiod[$i]));
               $BDLY_INPUT_toperiod_split=date('Y-m-d',strtotime($BDLY_INPUT_toperiod[$i]));
               $BDLY_INPUT_elect_amount_split=$BDLY_INPUT_elect_amount[$i];
               $BDLY_INPUT_elect_payment_split=$BDLY_INPUT_elect_payment[$i];
           }
           else{
               $BDLY_INPUT_electunit_split.=','.$BDLY_INPUT_electunit[$i];
               $BDLY_INPUT_invoiceto_split.=','.$BDLY_INPUT_invoiceto[$i];
               $BDLY_INPUT_invoicedate_split.=','.date('Y-m-d',strtotime($BDLY_INPUT_invoicedate[$i]));
               $BDLY_INPUT_fromperiod_split.=','.date('Y-m-d',strtotime($BDLY_INPUT_fromperiod[$i]));
               $BDLY_INPUT_toperiod_split.=','.date('Y-m-d',strtotime($BDLY_INPUT_toperiod[$i]));
               $BDLY_INPUT_elect_amount_split.=','.$BDLY_INPUT_elect_amount[$i];
               $BDLY_INPUT_elect_payment_split.=','.$BDLY_INPUT_elect_payment[$i];
           }
        }}
          else
          {
              if($BDLY_INPUT_comments=='')
                  $BDLY_INPUT_comments_split=' ';
              else
              {
              $BDLY_INPUT_comments_split=$this->db->escape_like_str($BDLY_INPUT_comments);
              $BDLY_INPUT_invoicedate_split=date('Y-m-d',strtotime($BDLY_INPUT_invoicedate));
              $BDLY_INPUT_fromperiod_split=date('Y-m-d',strtotime($BDLY_INPUT_fromperiod));
              $BDLY_INPUT_toperiod_split=date('Y-m-d',strtotime($BDLY_INPUT_toperiod));
              $BDLY_INPUT_electunit_split=$BDLY_INPUT_electunit;
              $BDLY_INPUT_invoiceto_split=$BDLY_INPUT_invoiceto;
              $BDLY_INPUT_elect_amount_split=$BDLY_INPUT_elect_amount;
              $BDLY_INPUT_elect_payment_split=$BDLY_INPUT_elect_payment;
              }
          }
          $BDLY_INPUT_insertinto_electricity_withoutcomment =$this->db->query("CALL SP_BIZDLY_ELECTRICITY_INSERT('$BDLY_INPUT_electunit_split','$BDLY_INPUT_invoicedate_split','$BDLY_INPUT_fromperiod_split','$BDLY_INPUT_toperiod_split','$BDLY_INPUT_invoiceto_split','$BDLY_INPUT_elect_amount_split','$BDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)");

      }
      //STAR HUB SAVING PART//
      if($BDLY_INPUT_exptype==2){
          $BDLY_INPUT_unitnovalue=$_POST['BDLY_INPUT_lb_star_unit'];
          $BDLY_INPUT_accnovalue=$_POST['BDLY_INPUT_tb_star_accno'];
          $BDLY_INPUT_invoicetovalue=$_POST['BDLY_INPUT_hidden_star_ecnid'];
          $BDLY_INPUT_invoicedatevalue=$_POST['BDLY_INPUT_db_star_invoicedate'];
          $BDLY_INPUT_amountvalue=$_POST['BDLY_INPUT_tb_star_amount'];
          $BDLY_INPUT_fromdatevalue=$_POST['BDLY_INPUT_db_star_fromperiod'];
          $BDLY_INPUT_todatevalue=$_POST['BDLY_INPUT_db_star_toperiod'];
          $BDLY_INPUT_commentsvalue=$_POST['BDLY_INPUT_ta_star_comments'];
          $BDLY_INPUT_comments_split='';
          $BDLY_INPUT_unitnovalue_split='';$BDLY_INPUT_accnovalue_split='';$BDLY_INPUT_invoicetovalue_split='';
          $BDLY_INPUT_invoicedatevalue_split='';$BDLY_INPUT_amountvalue_split='';$BDLY_INPUT_fromdatevalue_split='';
          $BDLY_INPUT_todatevalue_split='';

          if((is_array($BDLY_INPUT_commentsvalue))==true){
              for($i=0;$i<count($BDLY_INPUT_commentsvalue);$i++)
        {
            if($BDLY_INPUT_commentsvalue[$i]==''){
            if($i==0)
                $BDLY_INPUT_comments_split .=' ';
              else
                  $BDLY_INPUT_comments_split .='^^'.' ';
            }
          else{
            if($i==0)
                $BDLY_INPUT_comments_split .=$this->db->escape_like_str($BDLY_INPUT_commentsvalue[$i]);
            else
              $BDLY_INPUT_comments_split .='^^'.$this->db->escape_like_str($BDLY_INPUT_commentsvalue[$i]);
          }
            if($i==0)
            {
                $BDLY_INPUT_unitnovalue_split= $BDLY_INPUT_unitnovalue[$i];
                $BDLY_INPUT_accnovalue_split=$BDLY_INPUT_accnovalue[$i];
                $BDLY_INPUT_invoicetovalue_split=$BDLY_INPUT_invoicetovalue[$i];
                $BDLY_INPUT_invoicedatevalue_split=date('Y-m-d',strtotime($BDLY_INPUT_invoicedatevalue[$i]));
                $BDLY_INPUT_amountvalue_split=$BDLY_INPUT_amountvalue[$i];
                $BDLY_INPUT_fromdatevalue_split=date('Y-m-d',strtotime($BDLY_INPUT_fromdatevalue[$i]));
                $BDLY_INPUT_todatevalue_split=date('Y-m-d',strtotime($BDLY_INPUT_todatevalue[$i]));
            }
            else{
                $BDLY_INPUT_unitnovalue_split.=','.$BDLY_INPUT_unitnovalue[$i];
                $BDLY_INPUT_accnovalue_split.=','.$BDLY_INPUT_accnovalue[$i];
                $BDLY_INPUT_invoicetovalue_split.=','.$BDLY_INPUT_invoicetovalue[$i];
                $BDLY_INPUT_invoicedatevalue_split.=','.date('Y-m-d',strtotime($BDLY_INPUT_invoicedatevalue[$i]));
                $BDLY_INPUT_amountvalue_split.=','.$BDLY_INPUT_amountvalue[$i];
                $BDLY_INPUT_fromdatevalue_split.=','.date('Y-m-d',strtotime($BDLY_INPUT_fromdatevalue[$i]));
                $BDLY_INPUT_todatevalue_split.=','.date('Y-m-d',strtotime($BDLY_INPUT_todatevalue[$i]));
            }

        }}
          else
          {
              if($BDLY_INPUT_commentsvalue=='')
                  $BDLY_INPUT_comments_split=' ';
              else
                 $BDLY_INPUT_comments_split=$this->db->escape_like_str($BDLY_INPUT_commentsvalue);
                $BDLY_INPUT_unitnovalue_split= $BDLY_INPUT_unitnovalue;
                $BDLY_INPUT_accnovalue_split=$BDLY_INPUT_accnovalue;
                $BDLY_INPUT_invoicetovalue_split=$BDLY_INPUT_invoicetovalue;
                $BDLY_INPUT_invoicedatevalue_split=date('Y-m-d',strtotime($BDLY_INPUT_invoicedatevalue));
                $BDLY_INPUT_amountvalue_split=$BDLY_INPUT_amountvalue;
                $BDLY_INPUT_fromdatevalue_split=date('Y-m-d',strtotime($BDLY_INPUT_fromdatevalue));
                $BDLY_INPUT_todatevalue_split=date('Y-m-d',strtotime($BDLY_INPUT_todatevalue));
          }
          $BDLY_INPUT_starhub_insert=$this->db->query("CALL SP_BIZDLY_STARHUB_INSERT('$BDLY_INPUT_unitnovalue_split','$BDLY_INPUT_invoicetovalue_split','$BDLY_INPUT_invoicedatevalue_split','$BDLY_INPUT_fromdatevalue_split','$BDLY_INPUT_todatevalue_split','$BDLY_INPUT_amountvalue_split','$BDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)");

    }
      if(($BDLY_INPUT_exptype==9)||($BDLY_INPUT_exptype==8)||($BDLY_INPUT_exptype==7)||($BDLY_INPUT_exptype==11)||($BDLY_INPUT_exptype==4)){
          $BDLY_INPUT_flag=1;
      }else
      {
          $PDLY_INPUT_rs_flag = 'SELECT @FLAG_INSERT as FLAG_INSERT';
          $query = $this->db->query($PDLY_INPUT_rs_flag);
          $BDLY_INPUT_flag= $query->row()->FLAG_INSERT;
    }
      if($BDLY_INPUT_exptype==5)
          $BDLY_INPUT_refresh=$this->BDLY_INPUT_get_values($BDLY_INPUT_tb_gigunitno,$BDLY_INPUT_exptype);
      if(($BDLY_INPUT_exptype==2)||($BDLY_INPUT_exptype==3)||($BDLY_INPUT_exptype==1))
          $BDLY_INPUT_refresh=$this->BDLY_INPUT_get_unitno($BDLY_INPUT_exptype);
      return [$BDLY_INPUT_refresh,$BDLY_INPUT_flag];
  }

    //SEARCH AND UPDATE FORM
    /*-------------------------------GET INITIAL VALUE EXPENSE TYPE,UNIT EXP CATEGORY,ERROR MESSAGES--------------------------------------*/

    public function BDLY_SRC_getInitialvalue(){
        $BDLY_SRC_unitexp_catg_array=[];
        $BDLY_SRC_arr_errmsg_tablecount=[];
        //GET UNIT EXPENSE CATEGORY
        $BDLY_SRC_unitexp_catg_array=$this->BDLY_SRC_getUnitexp_catg("","",1);
           //GET BIZ DAILY TYPE OF EXPENSE LIST
        $get_BizDaily_exptype_query =$this->db->query("SELECT ECN_ID,ECN_DATA FROM EXPENSE_CONFIGURATION WHERE CGN_ID IN(18) ORDER BY ECN_DATA ASC");
        $BizDaily_explist_array=[];
        foreach ($get_BizDaily_exptype_query->result_array() as $row)
        {
            $BizDaily_explist_array[]=[$row["ECN_ID"],$row["ECN_DATA"]];
        }
        //GET ERR MESSAGES
        $BIZDLY_SRC_errmsgids="2,7,8,9,10,18,22,45,50,51,106,107,401,170,109,108,114,315,111,112,117,118,113,119,115,110,116,122,123,124,125,130,134,144,148,178,179,180,181,182,183,184,185,186,204,205,206,207,208,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,245,246,312,313,410,409,408,407,406,405,404,422,421,420,419,418,417,416,415,414,413,412,411,423,424,425,426,427,428,429,430,431,432,433,434,435,436,437,438,439,445,462";
        $errcode =[];$errmsg =[];
        $errquery=$this->db->query("SELECT EMC_ID,EMC_DATA FROM ERROR_MESSAGE_CONFIGURATION WHERE EMC_ID IN($BIZDLY_SRC_errmsgids) ORDER BY EMC_ID ASC");
        foreach ($errquery->result_array() as $row)
        {
            $errcode[]=$row["EMC_ID"];
            $errmsg[]=$row["EMC_DATA"];
        }
        $finalerrmsg=(object)["errorcode"=>$errcode,"errormsg"=>$errmsg];
    //CHECK DIALY,DETAIL AIRCON TABLE
        $BIZDLY_SRC_cnt_tblename=array(1=>['EXPENSE_AIRCON_SERVICE'],2=>['EXPENSE_DETAIL_AIRCON_SERVICE'],3=>['EXPENSE_CARPARK'],4=>['EXPENSE_DETAIL_CARPARK'],5=>['EXPENSE_DIGITAL_VOICE'],6=>['EXPENSE_DETAIL_DIGITAL_VOICE'],7=>['EXPENSE_STARHUB'],8=>['EXPENSE_DETAIL_STARHUB'],9=>['EXPENSE_ELECTRICITY'],10=>['EXPENSE_DETAIL_ELECTRICITY'],11=>['EXPENSE_UNIT'],12=>['EXPENSE_FACILITY_USE'],13=>['EXPENSE_MOVING_IN_AND_OUT'],14=>['EXPENSE_PETTY_CASH'],15=>['EXPENSE_HOUSEKEEPING'],16=>['EXPENSE_HOUSEKEEPING_PAYMENT']);
        for($i=1;$i<=16;$i++){
            $BIZDLY_SRC_rs_expensetble =$this->db->query("SELECT COUNT(*) as TABLECOUNT FROM ".$BIZDLY_SRC_cnt_tblename[$i][0]);
            $BDLY_SRC_arr_errmsg_tablecount[]= $BIZDLY_SRC_rs_expensetble->row()->TABLECOUNT;
        }
    $BDLY_SRC_fininitialvalue=array("explist"=>$BizDaily_explist_array,"unitcat"=>$BDLY_SRC_unitexp_catg_array,"errormsg"=>$finalerrmsg,"BIZDLY_SRC_chk_exptble"=>$BDLY_SRC_arr_errmsg_tablecount);
    return $BDLY_SRC_fininitialvalue;
    }
    /*------------------------------------------To GET UNIT EXP CATEGORY------------------------------------------------------*/
    public function BDLY_SRC_getUnitexp_catg($BDLY_SRC_startdate,$BDLY_SRC_enddate,$BDLY_SRC_chkcat){
        if($BDLY_SRC_chkcat!=1)
        {
            $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
            $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
            $BDLY_SRC_unitexp_categry_query = $this->db->query("SELECT DISTINCT EU.ECN_ID, EC.ECN_DATA FROM EXPENSE_UNIT EU,EXPENSE_CONFIGURATION EC,VW_ACTIVE_UNIT U WHERE EU.ECN_ID=EC.ECN_ID AND U.UNIT_ID=EU.UNIT_ID AND EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EC.CGN_ID=20 ORDER BY EC.ECN_DATA ASC");
        }
        else
        {
            $BDLY_SRC_unitexp_categry_query = $this->db->query("SELECT ECN_ID,ECN_DATA FROM EXPENSE_CONFIGURATION WHERE ECN_ID IN(22,23,24) ORDER BY ECN_DATA ASC");
        }
    $BDLY_SRC_unitexp_catg_array=[];
        foreach ($BDLY_SRC_unitexp_categry_query->result_array() as $row)
        {
            $BDLY_SRC_unitexp_catg_array[]=(object)[$row["ECN_ID"],$row["ECN_DATA"]];
        }

    return $BDLY_SRC_unitexp_catg_array;
  }

  public function BDLY_SRC_getSearchOptions($selectedexpense,$USERSTAMP){
    //GROUPING SEARCH OPTIONS
$Expense_Seacrh_opt_key = array(1=>"159,160,161,162,163,164,165,166,191",2=>"178,179,180,181,182,183,184,191",3=>"185,186,187,188,189,190,191",4=>"167,168,169,170,191",5=>"151,152,153,154,155,156,157,158,191",6=>"174,175,176,177,191",7=>"171,172,173,191",8=>"127,128,129,130,131,132,191",9=>"124,125,126,191,197",10=>"136,137,138,139,140",11=>"141,142,143,144,145",12=>"146,147,148,149,150,198");
$Expenseinecnid=$Expense_Seacrh_opt_key[$selectedexpense];
$BDLY_SRC_Search_opt_query=$this->db->query("SELECT ECN_ID, ECN_DATA FROM EXPENSE_CONFIGURATION WHERE CGN_ID=40 AND ECN_ID IN ($Expenseinecnid) ORDER BY ECN_DATA ASC");
       $BDLY_SRC_Searchoption_array=[];
      foreach ($BDLY_SRC_Search_opt_query->result_array() as $row)
      {
          $BDLY_SRC_Searchoption_array[]=(object)['key'=>$row["ECN_ID"],'value'=>$row["ECN_DATA"]];
      }
      $BDLY_SRC_hkunitnoarray=[];
    //get houskeeping unit no
    if($selectedexpense==12)
    {
        $BDLY_SRC_hkunitnoarray=$this->BDLY_SRC_getUnitList("12","150","","",$USERSTAMP);
    }
    $BDLY_SRC_srchoptnunit=array("srcoption"=>$BDLY_SRC_Searchoption_array,"hkpunitno"=>$BDLY_SRC_hkunitnoarray);
    return $BDLY_SRC_srchoptnunit;
}
  /*------------------------------------------TO GET UNIT NO BASED THE DATE RANGE OR GET HOUSEKPEEING UNIT NO--------------------------------------------------------*/
public function BDLY_SRC_getUnitList($selectedexpense,$selectedSearchopt,$startdate,$endate,$USERSTAMP){
    $BDLY_SRC_tmptbl_hkpsrch='';
    if($selectedexpense==12)
    {
        $BDLY_SRC_tmptbl_hkpsrch= $this->BDLY_SRC_callhkpaymentsp($USERSTAMP);
    }
    $BDLY_SRC_getunitno_query=array(1=>[],2=>[],3=>[],4=>[],5=>[],6=>[],7=>[],8=>[],9=>[],10=>[],11=>[],12=>[]);
    if($startdate!=""&&$endate!=""&&$selectedSearchopt!="")
    {
        $startdate=date('Y-m-d',strtotime($startdate));
        $endate=date('Y-m-d',strtotime($endate));
        /*ELECTRICITY UNIT NO*/$BDLY_SRC_getunitno_query['1']['191']="SELECT DISTINCT U.UNIT_ID, U.UNIT_NO FROM UNIT U,EXPENSE_ELECTRICITY EE,EXPENSE_DETAIL_ELECTRICITY EDE WHERE U.UNIT_ID=EDE.UNIT_ID AND EDE.EDE_ID=EE.EDE_ID AND EE.EE_INVOICE_DATE BETWEEN '$startdate' AND '$endate' ORDER BY U.UNIT_NO ASC";
      /*STARHUB UNIT NO*/$BDLY_SRC_getunitno_query['2']['191']="SELECT DISTINCT U.UNIT_ID,U.UNIT_NO FROM UNIT U, EXPENSE_STARHUB ESH,EXPENSE_DETAIL_STARHUB EDS WHERE U.UNIT_ID=EDS.UNIT_ID AND ESH.EDSH_ID=EDS.EDSH_ID AND ESH.ESH_INVOICE_DATE BETWEEN '$startdate' AND '$endate' ORDER BY U.UNIT_NO ASC";
      /*UNIT EXP UNIT NO*/$BDLY_SRC_getunitno_query['3']['191']="SELECT DISTINCT U.UNIT_ID,U.UNIT_NO FROM UNIT U, EXPENSE_UNIT EU WHERE U.UNIT_ID=EU.UNIT_ID AND EU.EU_INVOICE_DATE BETWEEN '$startdate' AND '$endate' ORDER BY U.UNIT_NO ASC";
      /*FACILITY USE UNIT NO*/$BDLY_SRC_getunitno_query['4']['191']="SELECT DISTINCT U.UNIT_ID,U.UNIT_NO FROM UNIT U, EXPENSE_FACILITY_USE EFU WHERE U.UNIT_ID=EFU.UNIT_ID AND EFU.EFU_INVOICE_DATE BETWEEN '$startdate' AND '$endate' ORDER BY U.UNIT_NO ASC";
      /*DIGITAL VOICE UNIT NO*/$BDLY_SRC_getunitno_query['5']['191']="SELECT DISTINCT U.UNIT_ID,U.UNIT_NO FROM UNIT U, EXPENSE_DIGITAL_VOICE EDV,EXPENSE_DETAIL_DIGITAL_VOICE EDDV WHERE U.UNIT_ID=EDDV.UNIT_ID AND EDDV.EDDV_ID=EDV.EDDV_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$startdate' AND '$endate' ORDER BY U.UNIT_NO ASC";
      /*PURCHASE CARD UNIT NO*/$BDLY_SRC_getunitno_query['6']['191']="SELECT DISTINCT U.UNIT_ID, U.UNIT_NO FROM UNIT U, EXPENSE_PURCHASE_NEW_CARD EPNC WHERE U.UNIT_ID=EPNC.UNIT_ID  AND EPNC.EPNC_INVOICE_DATE BETWEEN '$startdate' AND '$endate' ORDER BY U.UNIT_NO ASC";
      /*MOVING IN OUT UNIT NO*/$BDLY_SRC_getunitno_query['7']['191']="SELECT DISTINCT U.UNIT_ID, U.UNIT_NO FROM UNIT U, EXPENSE_MOVING_IN_AND_OUT  EMIO WHERE U.UNIT_ID= EMIO.UNIT_ID AND EMIO.EMIO_INVOICE_DATE BETWEEN '$startdate' AND '$endate' ORDER BY U.UNIT_NO ASC";
      /*CAR PARK UNIT NO*/$BDLY_SRC_getunitno_query['8']['191']="SELECT DISTINCT U.UNIT_ID, U.UNIT_NO FROM UNIT U, EXPENSE_CARPARK ECP,EXPENSE_DETAIL_CARPARK EDCP WHERE U.UNIT_ID= EDCP.UNIT_ID AND EDCP.EDCP_ID=ECP.EDCP_ID  AND ECP.ECP_INVOICE_DATE BETWEEN '$startdate' AND '$endate' ORDER BY U.UNIT_NO ASC";
      /*AIRCON SERVICE UNIT NO*/$BDLY_SRC_getunitno_query['9']['191']="SELECT DISTINCT U.UNIT_ID,U.UNIT_NO FROM UNIT U,EXPENSE_AIRCON_SERVICE EAS,EXPENSE_DETAIL_AIRCON_SERVICE EDAS WHERE U.UNIT_ID= EDAS.UNIT_ID AND EDAS.EDAS_ID=EAS.EDAS_ID AND EAS.EAS_DATE BETWEEN '$startdate' AND '$endate' ORDER BY U.UNIT_NO ASC";
      /*HOUSE KEEPING PAYMENT UNIT NO*/$BDLY_SRC_getunitno_query['12']['150']="SELECT DISTINCT UNIT_ID,UNIT_NO FROM $BDLY_SRC_tmptbl_hkpsrch WHERE EHKP_PAID_DATE BETWEEN '$startdate' AND '$endate'  ORDER BY UNIT_NO ASC";
    }
    else
    {
        /*HOUSE KEEPING PAYMENT UNIT NO*/$BDLY_SRC_getunitno_query['12']['150']="SELECT DISTINCT UNIT_ID,UNIT_NO FROM $BDLY_SRC_tmptbl_hkpsrch  ORDER BY UNIT_NO ASC";
    }
    $BDLY_SRC_unitarray=[];
    $execute_statement = $this->db->query($BDLY_SRC_getunitno_query[$selectedexpense][$selectedSearchopt]);
    foreach ($execute_statement->result_array() as $row)
    {
        if($startdate==""&&$endate=="")
        {
            $BDLY_SRC_unitarray[]=(object)['value'=>$row["UNIT_NO"]];
        }
        else
        {
            $BDLY_SRC_unitarray[]=(object)['key'=>$row["UNIT_ID"],'value'=>$row["UNIT_NO"]];
         }
    }
    $this->BDLY_SRC_drophkpaymentsptemptable($BDLY_SRC_tmptbl_hkpsrch);
    return $BDLY_SRC_unitarray;
  }

    /*------------------------------------------TO CALL HOUSE KEEPING PAYMENT SP--------------------------------------------------------*/
  public  function BDLY_SRC_callhkpaymentsp($USERSTAMP)
  {
      $BDLY_SRC_HKunitnospquery=$this->db->query("CALL SP_BIZDLY_HOUSE_KEEPING_PAYMENT_SRCH_DTLS('$USERSTAMP',@TEMP_TBLE_HKPSRCH)");
      $BDLY_SRC_rs_temptble=$this->db->query('SELECT @TEMP_TBLE_HKPSRCH AS TEMP_TBLE_HKPSRCH');
      $TEMP_tablename=$BDLY_SRC_rs_temptble->row()->TEMP_TBLE_HKPSRCH;
      return $TEMP_tablename;
  }
    /*------------------------------------------TO DROP HOUSE KEEPING PAYMENT TEMP TABLE--------------------------------------------------------*/
    public function BDLY_SRC_drophkpaymentsptemptable($BDLY_SRC_drptmptbl_hkpsrch)
    {
        if($BDLY_SRC_drptmptbl_hkpsrch!='')
      $this->db->query('DROP TABLE IF EXISTS '.$BDLY_SRC_drptmptbl_hkpsrch);
    }
    /*------------------------------------------TO GET DATA TABLE HEADER WIDTH--------------------------------------------------------*/
    public  function BDLY_SRC_getHeaderWidth($BDLY_SRC_exptype,$BDLY_SRC_OPTION)
    {
        $BDLY_SRC_finalheader=[];
        $BDLY_SRC_headerwidth=["SNO"=>"30","USERSTAMP"=>"170","CATEGORY<em>*</em>"=>"40","TIMESTAMP"=>"140","UNIT NO"=>"40",'CARD NUMBER<em>*</em>'=>"50","CAR NO"=>"60",
            "INVOICE DATE<em>*</em>"=>"75","INVOICE AMOUNT<em>*</em>"=>"10","COMMENTS"=>"500","PAID DATE<em>*</em>"=>"75","FOR PERIOD<em>*</em>"=>"75",
            "INVOICE ITEMS<em>*</em>"=>"250","INVOICE FROM<em>*</em>"=>"150","INVOICE TO"=>"120","ACCOUNT NO"=>"80",
            "FROM PERIOD<em>*</em>"=>"75","TO PERIOD<em>*</em>"=>"75","AIRCON SERVICE BY"=>"250","TOTAL AMOUNT"=>"120","UNIT NO<em>*</em>"=>"40","CUSTOMER"=>"250","CLEANER NAME"=>"90",
            "WORK DATE<em>*</em>"=>"90","DURATION<em>*</em>"=>"70","DESCRIPTION<em>*</em>"=>"600","DIGITAL VOICE NO"=>"150","DEPOSIT"=>"80","DEPOSIT REFUND"=>"150",
            "INVOICE AMOUNT"=>"150","TOTAL DURATION"=>"100","INVOICE DATE"=>"75","CASH IN"=>"60",'CASH OUT'=>'60','CURRENT BALANCE'=>"130"];
        $BDLY_SRC_headerwidthlen=count(array_keys($BDLY_SRC_headerwidth));
        $BDLY_SRC_tablewidth=["1"=>"2000","2"=>"2000","3"=>"2250","4"=>"1500","5"=>"2000","6"=>"1700","7"=>"1500","8"=>"2000","9"=>"1800","10"=>"1800","11"=>"1500","12"=>"1700"];
        if($BDLY_SRC_OPTION==142||$BDLY_SRC_OPTION==198)
        {
            if($BDLY_SRC_OPTION==142)
            {
                $BDLY_SRC_GridHeaders=[11=>['TOTAL DURATION','TOTAL AMOUNT']];
                $BDLY_SRC_tablewidth=["11"=>"100"];
            }
            if($BDLY_SRC_OPTION==198)
            {
                $BDLY_SRC_GridHeaders=[12=>['SNO','UNIT NO<em>*</em>','USERSTAMP','TIMESTAMP']];
                $BDLY_SRC_tablewidth=["12"=>"800"];
            }
        }
        else
        {
            $BDLY_SRC_GridHeaders=[1=>['SNO','UNIT NO','INVOICE TO','INVOICE DATE<em>*</em>','FROM PERIOD<em>*</em>','TO PERIOD<em>*</em>','DEPOSIT','DEPOSIT REFUND','INVOICE AMOUNT','COMMENTS','USERSTAMP','TIMESTAMP'],
                2=>['SNO','UNIT NO','INVOICE TO','ACCOUNT NO','INVOICE DATE<em>*</em>','FROM PERIOD<em>*</em>','TO PERIOD<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                3=>['SNO','UNIT NO','CATEGORY<em>*</em>','CUSTOMER','INVOICE DATE<em>*</em>','INVOICE ITEMS<em>*</em>','INVOICE FROM<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                4=>['SNO','UNIT NO','INVOICE DATE<em>*</em>','DEPOSIT','INVOICE AMOUNT','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                5=>['SNO','UNIT NO','INVOICE TO','DIGITAL VOICE NO','ACCOUNT NO','INVOICE DATE<em>*</em>','FROM PERIOD<em>*</em>','TO PERIOD<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP','TIMESTAMP'],
                6=>['SNO','UNIT NO','CARD NUMBER<em>*</em>','INVOICE DATE<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                7=>['SNO','UNIT NO','INVOICE DATE<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP','TIMESTAMP'],
                8=>['SNO','UNIT NO','CAR NO','INVOICE DATE<em>*</em>','FROM PERIOD<em>*</em>','TO PERIOD<em>*</em>','INVOICE AMOUNT<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                9=>['SNO','UNIT NO','AIRCON SERVICE BY','INVOICE DATE<em>*</em>','COMMENTS','USERSTAMP','TIMESTAMP'],
                10=>['SNO','INVOICE DATE','CASH IN','CASH OUT','CURRENT BALANCE','INVOICE ITEMS<em>*</em>','COMMENTS','USERSTAMP', 'TIMESTAMP'],
                11=>['SNO','CLEANER NAME','WORK DATE<em>*</em>','DURATION<em>*</em>','DESCRIPTION<em>*</em>','USERSTAMP','TIMESTAMP'],
                12=>['SNO','UNIT NO','INVOICE AMOUNT<em>*</em>','FOR PERIOD<em>*</em>','PAID DATE<em>*</em>','COMMENTS','USERSTAMP','TIMESTAMP']];
        }
        for($i=0;$i<count($BDLY_SRC_GridHeaders[$BDLY_SRC_exptype]);$i++)
        {
            if($BDLY_SRC_headerwidth[$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i]]&&$BDLY_SRC_headerwidth[$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i]]!='undefined')
            {
                $str=$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i].'^'.$BDLY_SRC_headerwidth[$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i]];
                $BDLY_SRC_finalheader[]=$str;
            }
            else
            {
                $BDLY_SRC_finalheader[]=$BDLY_SRC_GridHeaders[$BDLY_SRC_exptype][$i];
            }
        }
        $BDLY_SRC_finalwidth=(object)["headerwidth"=>$BDLY_SRC_finalheader,"tablewidth"=>$BDLY_SRC_tablewidth[$BDLY_SRC_exptype]];
        return $BDLY_SRC_finalwidth;
    }
    /*------------------------------------------WILL FETCH RESULT FROM DB AND WILL SHOW IN DATA TABLE -----------------------------------------------------*/
    public function BDLY_SRC_getAnyTypeExpData($USERSTAMP,$timeZoneFormat,$BDLY_SRC_lb_unitno,$BDLY_SRC_lb_invoiceto,$BDLY_SRC_comments,$BDLY_SRC_comments,$BDLY_SRC_tb_fromamnt,$BDLY_SRC_tb_toamnt,$BDLY_SRC_servicedue,$BDLY_SRC_lb_cleanername,$BDLY_SRC_tb_durationamt,$BDLY_SRC_startdate,$BDLY_SRC_enddate,$BDLY_SRC_invoicefrom,$BDLY_SRC_lb_accountno,$BDLY_SRC_lb_cusname,$BDLY_SRC_lb_Digvoiceno,$BDLY_SRC_lb_cardno,$BDLY_SRC_lb_carno,$BDLY_SRC_lb_serviceby,$BDLY_SRC_invoiceitem,$BDLY_SRC_lb_category){
        $BDLY_SRC_lb_ExpenseList_val=$_POST['BDLY_SRC_lb_ExpenseList'];
        $BDLY_SRC_lb_serachopt=$_POST['BDLY_SRC_lb_serachopt'];
        $BDLY_SRC_tmptbl_hkpsrch='';

        $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
        $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $BDLY_SRC_invoiceitemssrcvalue=$this->Mdl_eilib_common_function->jsspecialchars($BDLY_SRC_invoiceitem);
        $BDLY_SRC_commentssrcvalue=$this->Mdl_eilib_common_function->jsspecialchars($BDLY_SRC_comments);
        $BDLY_SRC_invfromsrcvalue=$this->Mdl_eilib_common_function->jsspecialchars($BDLY_SRC_invoicefrom);
        $BDLY_SRC_temptabledropQuery=[1=>[],2=>[],3=>[],4=>[],5=>[],6=>[],7=>[],8=>[],9=>[],10=>[],11=>[],12=>[]];
        $BDLY_SRC_SelectQuery=[1=>[],2=>[],3=>[],4=>[],5=>[],6=>[],7=>[],8=>[],9=>[],10=>[],11=>[],12=>[]];
        //Data Table Header Caption
        $BDLY_SRC_GridHeaders=$this->BDLY_SRC_getHeaderWidth($BDLY_SRC_lb_ExpenseList_val,$BDLY_SRC_lb_serachopt);
        $BDLY_SRC_TableWidth=$BDLY_SRC_GridHeaders->tablewidth;
        $BDLY_SRC_GridHeaders=$BDLY_SRC_GridHeaders->headerwidth;
    // Data Table cloumn type
       $BDLY_SRC_GridColumnTypes=[1=>['lable','unit','lable','date','sdate','edate','optionalamnt1','optionalamnt2','optionalamnt3','textarea','lable','lable'],
                              2=>['lable','unit','lable','lable','date','sdate','edate','amount','textarea','lable','lable'],
                              3=>['lable','unit','unit_category_lb','cus_name_lb','date','textarea','textbox','amount','textarea','lable', 'lable'],
                              4=>['lable','unit','date','optionalamnt1','optionalamnt2','textarea','lable', 'lable'],
                              5=>['lable','unit','lable','lable','lable','date','sdate','edate','amount','textarea','lable','lable'],
                              6=>['lable','unit','access_card','date','amount','textarea','lable', 'lable'],
                              7=>['lable','unit','date','amount','textarea','lable','lable'],
                              8=>['lable','unit','lable','date','sdate','edate','amount','textarea','lable', 'lable'],
                              9=>['lable','unit','lable','date','textarea','lable','lable'],
                              10=>['lable','lable','lable','lable','lable','textarea','textarea','lable', 'lable'],
                              11=>['lable','lable','ndate','duration','textarea','lable','lable'],
                              12=>['lable','hfp_unit_lb','amount','month','ndate','textarea','lable','v']];
    if($BDLY_SRC_lb_serachopt==198)
    {
        $BDLY_SRC_GridColumnTypes=array(12=>['lable','unittextbox','lable','lable']);
    }
    if($BDLY_SRC_lb_ExpenseList_val==12)
    {
        $BDLY_SRC_tmptbl_hkpsrch=$this->BDLY_SRC_callhkpaymentsp($USERSTAMP);
    }
    if($BDLY_SRC_lb_ExpenseList_val==1||$BDLY_SRC_lb_serachopt==142)
    {
        if($BDLY_SRC_lb_serachopt==191)
        $BDLY_SRC_sp_thirdval="'$BDLY_SRC_lb_unitno'";
      if($BDLY_SRC_lb_serachopt==165)
        $BDLY_SRC_sp_thirdval="'$BDLY_SRC_lb_invoiceto'";
      if($BDLY_SRC_lb_serachopt==159)
        $BDLY_SRC_sp_thirdval="'$BDLY_SRC_commentssrcvalue'";
      if($BDLY_SRC_lb_serachopt==160||$BDLY_SRC_lb_serachopt==161||$BDLY_SRC_lb_serachopt==163){
          $BDLY_SRC_sp_thirdval="'$BDLY_SRC_tb_fromamnt'";
          $BDLY_SRC_sp_fourthval="'$BDLY_SRC_tb_toamnt'";}
      if($BDLY_SRC_lb_serachopt==162||$BDLY_SRC_lb_serachopt==164||$BDLY_SRC_lb_serachopt==166)
        $BDLY_SRC_sp_thirdval='null';
      if($BDLY_SRC_lb_serachopt==162||$BDLY_SRC_lb_serachopt==164||$BDLY_SRC_lb_serachopt==166||$BDLY_SRC_lb_serachopt==191||$BDLY_SRC_lb_serachopt==165||$BDLY_SRC_lb_serachopt==159)
        $BDLY_SRC_sp_fourthval='null';
        if($BDLY_SRC_lb_serachopt==142){
            $BDLY_SRC_hkpforperiod =date("Y-m-01", strtotime($BDLY_SRC_servicedue));
            $BDLY_SRC_electtempstmt=$this->db->query("CALL SP_BIZDLY_HOUSEKEEPING_DURATION_AMOUNT_SRCH('$BDLY_SRC_lb_cleanername','$BDLY_SRC_hkpforperiod','$BDLY_SRC_tb_durationamt','$USERSTAMP',@TEMPTABLE_ELECTRICITY)");
        }
        else
        {
            $BDLY_SRC_electtempstmt=$this->db->query("CALL SP_TEMP_BIZDLY_ELECTRICITY_SEARCH('$BDLY_SRC_startdate','$BDLY_SRC_enddate',$BDLY_SRC_sp_thirdval,$BDLY_SRC_sp_fourthval,'$BDLY_SRC_lb_serachopt','$USERSTAMP',@TEMPTABLE_ELECTRICITY)");
        }
        $BDLY_SRC_dynatemp_stmt=$this->db->query('SELECT @TEMPTABLE_ELECTRICITY AS TEMPTABLE_ELECTRICITY');
        $BDLY_SRC_electemp_name=$BDLY_SRC_dynatemp_stmt->row()->TEMPTABLE_ELECTRICITY;
    }
         $BDLY_SRC_Expdataobject=[];
        $BDLY_SRC_Expdataobject[]=$BDLY_SRC_GridHeaders;
        $BDLY_SRC_Expdataobject[]=$BDLY_SRC_GridColumnTypes[$BDLY_SRC_lb_ExpenseList_val];
    //ELECTRICITY--1
    if($BDLY_SRC_lb_ExpenseList_val==1)
    {
        //UNIT NO SEARCH OPTION ID-191
      $BDLY_SRC_SelectQuery['1']['191'] = "SELECT EE_ID,EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_INVOICE_DATE ASC";
      //INVOICE TO SEARCH OPTION ID-165
        $BDLY_SRC_SelectQuery['1']['165'] = "SELECT EE_ID,EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_UNITNO,EE_INVOICE_DATE ASC";
      //INVOICE DATE SEARCH OPTION ID-164
        $BDLY_SRC_SelectQuery['1']['164'] = "SELECT EE_ID,EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_INVOICE_DATE,EE_UNITNO ASC";
       //COMMENTS SEARCH OPTION ID-159
        $BDLY_SRC_SelectQuery['1']['159'] = "SELECT EE_ID,EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_UNITNO,EE_INVOICE_DATE ASC";
      //FROM PERIOD SEARCH OPTION ID-162
        $BDLY_SRC_SelectQuery['1']['162'] = "SELECT EE_ID,EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_FROM_PERIOD,EE_UNITNO,EE_INVOICE_DATE ASC";
      //TO PERIOD SEARCH OPTION ID-166
        $BDLY_SRC_SelectQuery['1']['166'] = "SELECT EE_ID,EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y'),DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y'),EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EE_TIMESTAMP FROM $BDLY_SRC_electemp_name ORDER BY EE_TO_PERIOD,EE_UNITNO,EE_INVOICE_DATE ASC";
    }
    //------------------------------------------------------------STARHUB=2-----------------------------------------------------------------------------------//
    /*ACCOUNT NO SEARCH*/$BDLY_SRC_SelectQuery['2']['178'] = "SELECT ESH.ESH_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDSH.EDSH_ACCOUNT_NO='$BDLY_SRC_lb_accountno' ORDER BY U.UNIT_NO,ESH_INVOICE_DATE ASC";
    /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['2']['179'] = "SELECT ESH.ESH_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND ESH_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,ESH_INVOICE_DATE ASC";
    /*FROM PERIOD SEARCH*/$BDLY_SRC_SelectQuery['2']['180'] = "SELECT ESH.ESH_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_FROM_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ESH_FROM_PERIOD,U.UNIT_NO ASC";
    /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['2']['182'] = "SELECT ESH.ESH_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ESH_INVOICE_DATE,U.UNIT_NO ASC";
    /*INVOICE TO SEARCH*/$BDLY_SRC_SelectQuery['2']['183'] = "SELECT ESH.ESH_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDSH.ECN_ID='$BDLY_SRC_lb_invoiceto' ORDER BY U.UNIT_NO,ESH_INVOICE_DATE ASC";
    /*TO PERIOD SEARCH*/$BDLY_SRC_SelectQuery['2']['184'] = "SELECT ESH.ESH_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_TO_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ESH_TO_PERIOD,U.UNIT_NO ASC";
    /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['2']['191'] = "SELECT ESH.ESH_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,ESH_INVOICE_DATE ASC";
    //----------------------------------------------------------UNIT EXPENSE=3---------------------------------------------------------------------------------//
    /*CATEGORY SEARCH*/
    $CUSTOMER_TYPE=$BDLY_SRC_lb_category==23?true:false;
    if($CUSTOMER_TYPE) //CUSTOMER TYPE
        $BDLY_SRC_SelectQuery['3']['186'] = "SELECT EU.EU_ID,U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT AS U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND EU.ECN_ID ='$BDLY_SRC_lb_category' AND EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.CUSTOMER_ID='$BDLY_SRC_lb_cusname' ORDER BY U.UNIT_NO ASC";
    else if($BDLY_SRC_lb_ExpenseList_val==3) // NON CUSTOMER
            $BDLY_SRC_SelectQuery['3']['186'] = "SELECT EU.EU_ID,U.UNIT_NO,EC.ECN_DATA,NULL AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND EU.ECN_ID ='$BDLY_SRC_lb_category' AND EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.CUSTOMER_ID IS NULL ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
    /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['3']['188'] = "SELECT EU.EU_ID,U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EU.EU_INVOICE_DATE,U.UNIT_NO ASC";
    /*INVOICE ITEM SEARCH*/$BDLY_SRC_SelectQuery['3']['189'] = "SELECT EU.EU_ID,U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.EU_INVOICE_ITEMS='$BDLY_SRC_invoiceitemssrcvalue' ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC ";
    /*INVOICE FROM*/$BDLY_SRC_SelectQuery['3']['190'] = "SELECT EU.EU_ID,U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.EU_INVOICE_FROM='$BDLY_SRC_invfromsrcvalue' ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
    /*COMMENTS*/$BDLY_SRC_SelectQuery['3']['185'] = "SELECT EU.EU_ID,U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.EU_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
    /*UNIT NO*/$BDLY_SRC_SelectQuery['3']['191'] = "SELECT EU.EU_ID,U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
    /*-----------------------------------------------------------------------FACILITY USE=4----------------------------------------------------------------------*/
    /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['4']['167'] =  "SELECT EFU.EFU_ID,U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM  EXPENSE_FACILITY_USE EFU JOIN VW_ACTIVE_UNIT U  ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU.EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EFU.EFU_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EFU.EFU_INVOICE_DATE ASC";
    /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['4']['170'] =  "SELECT EFU.EFU_ID,U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_FACILITY_USE EFU ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EFU.EFU_INVOICE_DATE ASC";
    /*UNIT NO*/$BDLY_SRC_SelectQuery['4']['191'] =  "SELECT EFU.EFU_ID,U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM UNIT U JOIN EXPENSE_FACILITY_USE EFU ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,EFU.EFU_INVOICE_DATE ASC";
   /*----------------------------------------------------------------------DIGITAL VOICE=5--------------------------------------------------------------------------*/
    /*ACCOUNT NO*/$BDLY_SRC_SelectQuery['5']['151'] = "SELECT EDV.EDV_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDDV.EDDV_DIGITAL_ACCOUNT_NO='$BDLY_SRC_lb_accountno' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
    /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['5']['153'] = "SELECT EDV.EDV_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDV.EDV_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
    /*DIGITAL VOICE NO*/$BDLY_SRC_SelectQuery['5']['154'] = "SELECT EDV.EDV_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDDV.EDDV_DIGITAL_VOICE_NO='$BDLY_SRC_lb_Digvoiceno' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
    /*FROM PERIOD*/$BDLY_SRC_SelectQuery['5']['155'] = "SELECT EDV.EDV_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_FROM_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDV.EDV_FROM_PERIOD,U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
    /*INVOICE DATE*/$BDLY_SRC_SelectQuery['5']['156'] = "SELECT EDV.EDV_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDV.EDV_INVOICE_DATE,U.UNIT_NO ASC";
    /*INVOICE TO*/$BDLY_SRC_SelectQuery['5']['157'] = "SELECT EDV.EDV_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EC.ECN_ID='$BDLY_SRC_lb_invoiceto' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
    /*TO PERIOD*/$BDLY_SRC_SelectQuery['5']['158'] = "SELECT EDV.EDV_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_TO_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDV.EDV_TO_PERIOD,U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
    /*UNIT NO*/$BDLY_SRC_SelectQuery['5']['191'] = "SELECT EDV.EDV_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDDV.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
    /*----------------------------------------------------------PURCHASE NEW ACCESS CARD=6-------------------------------------------------------------------------------*/
    /*CARD NO*/$BDLY_SRC_SelectQuery['6']['174'] = "SELECT EPC.EPNC_ID,U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN VW_ACTIVE_UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.EPNC_NUMBER='$BDLY_SRC_lb_cardno' ORDER BY U.UNIT_NO,EPC.EPNC_INVOICE_DATE ASC";
    /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['6']['175'] = "SELECT EPC.EPNC_ID,U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN VW_ACTIVE_UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.EPNC_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EPC.EPNC_INVOICE_DATE ASC";
    /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['6']['177'] = "SELECT EPC.EPNC_ID,U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN VW_ACTIVE_UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EPC.EPNC_INVOICE_DATE,U.UNIT_NO ASC";
    /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['6']['191'] = "SELECT EPC.EPNC_ID,U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.UNIT_ID ='$BDLY_SRC_lb_unitno' ORDER BY EPC.EPNC_INVOICE_DATE ASC";
    /*----------------------------------------------------------MOVING IN OUT=7-------------------------------------------------------------------------------------*/
    /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['7']['171'] = "SELECT M.EMIO_ID,U.UNIT_NO,DATE_FORMAT(M.EMIO_INVOICE_DATE,'%d-%m-%Y') AS COMMENTSDATE,M.EMIO_AMOUNT,M.EMIO_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(M.EMIO_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS MOVING_TIMESTAMP FROM EXPENSE_MOVING_IN_AND_OUT M JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=M.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=M.ULD_ID AND M.EMIO_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND M.EMIO_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,M.EMIO_INVOICE_DATE ASC";
    /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['7']['173'] = "SELECT M.EMIO_ID,U.UNIT_NO,DATE_FORMAT(M.EMIO_INVOICE_DATE,'%d-%m-%Y') AS COMMENTSDATE,M.EMIO_AMOUNT,M.EMIO_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(M.EMIO_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS MOVING_TIMESTAMP FROM EXPENSE_MOVING_IN_AND_OUT M JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=M.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=M.ULD_ID AND M.EMIO_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY M.EMIO_INVOICE_DATE,U.UNIT_NO ASC";
    /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['7']['191'] = "SELECT M.EMIO_ID,U.UNIT_NO,DATE_FORMAT(M.EMIO_INVOICE_DATE,'%d-%m-%Y') AS COMMENTSDATE,M.EMIO_AMOUNT,M.EMIO_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(M.EMIO_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS MOVING_TIMESTAMP FROM EXPENSE_MOVING_IN_AND_OUT M JOIN UNIT U ON U.UNIT_ID=M.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=M.ULD_ID AND M.EMIO_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,M.EMIO_INVOICE_DATE ASC";
    /*------------------------------------------------------------CAR PARK=8------------------------------------------------------------------------------------------*/
    /*CAR NO SEARCH*/$BDLY_SRC_SelectQuery['8']['127'] = "SELECT ECP.ECP_PARK_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDCP.EDCP_CAR_NO='$BDLY_SRC_lb_carno' ORDER BY U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
    /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['8']['128'] = "SELECT ECP.ECP_PARK_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND ECP.ECP_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
    /*FROM PERIOD SEARCH*/$BDLY_SRC_SelectQuery['8']['129'] = "SELECT ECP.ECP_PARK_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_FROM_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ECP.ECP_FROM_PERIOD,U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
    /*TO PERIOD SEARCH*/$BDLY_SRC_SelectQuery['8']['130'] = "SELECT ECP.ECP_PARK_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_TO_PERIOD BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ECP.ECP_TO_PERIOD,U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
    /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['8']['131'] = "SELECT ECP.ECP_PARK_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ECP.ECP_INVOICE_DATE,U.UNIT_NO ASC";
    /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['8']['191'] = "SELECT ECP.ECP_PARK_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDCP.UNIT_ID ='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
    /*-----------------------------------------------------------AIRCON SERVICE=9-------------------------------------------------------------------------------------------------*/
    /*AIRCON SERVICE BY SEARCH*/$BDLY_SRC_SelectQuery['9']['124'] = "SELECT EAS.EAS_ID,U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN VW_ACTIVE_UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EASB.EASB_DATA='$BDLY_SRC_lb_serviceby' ORDER BY U.UNIT_NO,EAS.EAS_DATE ASC";
    /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['9']['125'] = "SELECT EAS.EAS_ID,U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN VW_ACTIVE_UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EAS.EAS_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY U.UNIT_NO,EAS.EAS_DATE ASC";
    /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['9']['126'] = "SELECT EAS.EAS_ID,U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN VW_ACTIVE_UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EAS.EAS_DATE,U.UNIT_NO ASC";
    /*UNIT NO SEARCH*/$BDLY_SRC_SelectQuery['9']['191'] = "SELECT EAS.EAS_ID,U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_lb_unitno' ORDER BY U.UNIT_NO,EAS.EAS_DATE ASC";
    /*AIRCON DUE SEARCH*/if($BDLY_SRC_lb_serachopt==197){
            $BDLY_SRC_Aircon_DueDatefromdate =date("Y-m-01", strtotime($BDLY_SRC_servicedue));
            $BDLY_SRC_Aircon_DueDatetodate =date("Y-m-t", strtotime($BDLY_SRC_servicedue));
            $BDLY_SRC_SelectQuery['9']['197'] = "SELECT EAS.EAS_ID,U.UNIT_NO,EASB.EASB_DATA,DATE_FORMAT(EAS_DATE,'%d-%m-%Y') AS AIRCONDATE,EAS.EAS_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EAS.EAS_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS AIRCON_TIMESTAMP FROM EXPENSE_DETAIL_AIRCON_SERVICE EDAS JOIN EXPENSE_AIRCON_SERVICE EAS ON EDAS.EDAS_ID=EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON EASB.EASB_ID=EDAS.EASB_ID JOIN VW_ACTIVE_UNIT U ON EDAS.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EAS.ULD_ID AND EAS.EAS_DATE BETWEEN SUBDATE('$BDLY_SRC_Aircon_DueDatefromdate',INTERVAL 3 MONTH) AND SUBDATE('$BDLY_SRC_Aircon_DueDatetodate',INTERVAL 3 MONTH) ORDER BY EAS.EAS_DATE,U.UNIT_NO ASC";
    }
    /*-------------------------------------------------------------PETTY CASH=10----------------------------------------------------------------------------*/
    /*INVOICE DATE SEARCH*/$BDLY_SRC_SelectQuery['10']['136'] = "SELECT EPC.EPC_ID,DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EPC.EPC_DATE ASC";
    /*INVOICE ITEM*/$BDLY_SRC_SelectQuery['10']['139'] = "SELECT EPC.EPC_ID,DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate'  AND EPC.EPC_INVOICE_ITEMS='$BDLY_SRC_invoiceitemssrcvalue' ORDER BY EPC.EPC_DATE ASC";
    /*COMMENTS SEARCH*/$BDLY_SRC_SelectQuery['10']['140'] = "SELECT EPC.EPC_ID,DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.EPC_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY EPC.EPC_DATE ASC";
    /*------------------------------------------------------------HOUSE KEEPING=11----------------------------------------------------------------------------*/
    /*EMP NAME SEARCH*/$BDLY_SRC_SelectQuery['11']['141'] = "SELECT EHK.EHK_ID,CONCAT(ED.EMP_FIRST_NAME,' ',ED.EMP_LAST_NAME) AS NAME ,DATE_FORMAT(EHK.EHK_WORK_DATE,'%d-%m-%Y') AS DATE,EHK.EHK_DURATION,EHK.EHK_DESCRIPTION,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHK.EHK_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHK_TIMESTAMP FROM EXPENSE_HOUSEKEEPING EHK JOIN EMPLOYEE_DETAILS ED ON ED.EMP_ID=EHK.EMP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHK.ULD_ID AND EHK.EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHK.EMP_ID='$BDLY_SRC_lb_cleanername' ORDER BY EHK.EHK_WORK_DATE ASC";
    if($BDLY_SRC_lb_serachopt==142)
    {
        /*FOR PERIOD DURATION SEARCH*/$BDLY_SRC_SelectQuery['11']['142'] = "SELECT DURATION,AMOUNT FROM $BDLY_SRC_electemp_name";
    }
    // SELECT DURATION,AMOUNT FROM TEMP_HOUSEKEEPING_DURATION_AMOUNT
    /*DESCRIPTION SEARCH*/$BDLY_SRC_SelectQuery['11']['143'] = "SELECT EHK.EHK_ID,CONCAT(ED.EMP_FIRST_NAME,' ',ED.EMP_LAST_NAME) AS NAME ,DATE_FORMAT(EHK.EHK_WORK_DATE,'%d-%m-%Y') AS DATE,EHK.EHK_DURATION,EHK.EHK_DESCRIPTION,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHK.EHK_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHK_TIMESTAMP FROM EXPENSE_HOUSEKEEPING EHK JOIN EMPLOYEE_DETAILS ED ON ED.EMP_ID=EHK.EMP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHK.ULD_ID AND EHK.EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHK.EHK_DESCRIPTION ='$BDLY_SRC_commentssrcvalue' ORDER BY EHK.EHK_WORK_DATE ASC";
    /*WORK DATE SEARCH*/$BDLY_SRC_SelectQuery['11']['145'] = "SELECT EHK.EHK_ID,CONCAT(ED.EMP_FIRST_NAME,' ',ED.EMP_LAST_NAME) AS NAME ,DATE_FORMAT(EHK.EHK_WORK_DATE,'%d-%m-%Y') AS DATE,EHK.EHK_DURATION,EHK.EHK_DESCRIPTION,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHK.EHK_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHK_TIMESTAMP FROM EXPENSE_HOUSEKEEPING EHK JOIN EMPLOYEE_DETAILS ED ON ED.EMP_ID=EHK.EMP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHK.ULD_ID AND EHK.EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EHK.EHK_WORK_DATE ASC";
    /*DURATION SEARCH*/if($BDLY_SRC_lb_serachopt==144)
        {
            $BDLY_SRC_fromduration=$_POST['BDLY_SRC_fromduration'];
            $BDLY_SRC_toduration=$_POST['BDLY_SRC_toduration'];
            $BDLY_SRC_SelectQuery['11']['144']="SELECT EHK.EHK_ID,CONCAT(ED.EMP_FIRST_NAME,' ',ED.EMP_LAST_NAME) AS NAME ,DATE_FORMAT(EHK.EHK_WORK_DATE,'%d-%m-%Y') AS DATE,EHK.EHK_DURATION,EHK.EHK_DESCRIPTION,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHK.EHK_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHK_TIMESTAMP FROM EXPENSE_HOUSEKEEPING EHK JOIN EMPLOYEE_DETAILS ED ON ED.EMP_ID=EHK.EMP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHK.ULD_ID AND EHK.EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHK.EHK_DURATION BETWEEN '$BDLY_SRC_fromduration' AND '$BDLY_SRC_toduration' ORDER BY EHK.EHK_DURATION,EHK.EHK_WORK_DATE ASC";
    }
    /*---------------------------------------------------------------HOUSEKEEPING PAYMENT=12-----------------------------------------------------------------*/
    /*COMMENTS SEARCH*/  $BDLY_SRC_SelectQuery['12']['146'] = "SELECT EHKP.EHKP_ID,UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,EHKP.EHKP_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM $BDLY_SRC_tmptbl_hkpsrch EHKP WHERE EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHKP.EHKP_COMMENTS='$BDLY_SRC_commentssrcvalue' ORDER BY UNIT_NO,EHKP.EHKP_PAID_DATE ASC";
    /*FOR PERIOD SEARCH*/if($BDLY_SRC_lb_serachopt==147)
        {
             $BDLY_SRC_startforperiodfromdate =date("Y-m-01", strtotime($_POST['BDLY_SRC_startforperiod']));
            $BDLY_SRC_startforperiodtodate =date("Y-m-t", strtotime($_POST['BDLY_SRC_endforperiod']));
            $BDLY_SRC_SelectQuery['12']['147'] = "SELECT EHKP.EHKP_ID,UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,EHKP.EHKP_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM $BDLY_SRC_tmptbl_hkpsrch EHKP WHERE EHKP.EHKP_FOR_PERIOD BETWEEN '$BDLY_SRC_startforperiodfromdate' AND '$BDLY_SRC_startforperiodtodate' ORDER BY EHKP.EHKP_FOR_PERIOD,UNIT_NO ASC";
        }
    /*PAID DATE SEARCH*/ $BDLY_SRC_SelectQuery['12']['149'] = "SELECT EHKP.EHKP_ID,UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,EHKP.EHKP_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM $BDLY_SRC_tmptbl_hkpsrch EHKP WHERE EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EHKP.EHKP_PAID_DATE,UNIT_NO ASC";
    /*UNIT NO SEARCH*/ $BDLY_SRC_SelectQuery['12']['198'] = "SELECT EHKU.EHKU_ID,EHKU_UNIT_NO,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHKU.EHKU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKU_TIMESTAMP FROM EXPENSE_HOUSEKEEPING_UNIT EHKU,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EHKU.ULD_ID ORDER BY EHKU_UNIT_NO ASC";
    /*WITH UNIT NO SEARCH*/ if($BDLY_SRC_lb_ExpenseList_val==12 && $BDLY_SRC_lb_serachopt==150){
            $BDLY_SRC_Merged_UnitNo=$_POST['BDLY_SRC_lb_unitno'];
            $BDLY_SRC_Sep_Unit_Id=explode(" ",$BDLY_SRC_Merged_UnitNo);
            if (strlen(strstr($BDLY_SRC_Merged_UnitNo,"HKUNIT"))>0)
                $BDLY_SRC_SelectQuery['12']['150'] = "SELECT EHKP.EHKP_ID,EHKU.EHKU_UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM EXPENSE_HOUSEKEEPING_PAYMENT EHKP JOIN EXPENSE_HOUSEKEEPING_UNIT AS EHKU ON EHKP.EHKU_ID = EHKU.EHKU_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHKP.ULD_ID AND EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHKU.EHKU_ID='$BDLY_SRC_Sep_Unit_Id[0]' ORDER BY EHKP.EHKP_PAID_DATE ASC";
            else
                $BDLY_SRC_SelectQuery['12']['150'] = "SELECT EHKP.EHKP_ID,U.UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM EXPENSE_HOUSEKEEPING_PAYMENT EHKP JOIN UNIT U ON EHKP.UNIT_ID = U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EHKP.ULD_ID AND EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND U.UNIT_ID='$BDLY_SRC_Sep_Unit_Id[0]' ORDER BY EHKP.EHKP_PAID_DATE ASC";
    }
    /*********************************************************************All type amount search******************************************************************/
    if (isset($_POST['BDLY_SRC_tb_fromamnt'])) {
        $BDLY_SRC_tb_fromamnt=$_POST['BDLY_SRC_tb_fromamnt'];
        if($BDLY_SRC_lb_ExpenseList_val==1)//ELECTRICITY
        {
            //INVOICE AMOUNT SEARCH OPTION ID-163
            $BDLY_SRC_SelectQuery['1']['163'] = "SELECT EE_ID,EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y') AS EE_FROM_PERIOD,DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y') AS EE_TO_PERIOD,EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') FROM $BDLY_SRC_electemp_name ORDER BY EE_INVOICE_AMOUNT,EE_UNITNO,EE_INVOICE_DATE ASC";
        //DEPOSIT AMOUNT SEARCH OPTION ID-160
            $BDLY_SRC_SelectQuery['1']['160'] = "SELECT EE_ID,EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y') AS EE_FROM_PERIOD,DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y') AS EE_TO_PERIOD,EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') FROM $BDLY_SRC_electemp_name ORDER BY EE_DEPOSIT,EE_UNITNO,EE_INVOICE_DATE ASC";
        //DEPOSIT REFUND AMOUNT SEARCH OPTION ID-161
            $BDLY_SRC_SelectQuery['1']['161'] = "SELECT EE_ID,EE_UNITNO,EE_INVOICE_TO,DATE_FORMAT(EE_INVOICE_DATE,'%d-%m-%Y'),DATE_FORMAT(EE_FROM_PERIOD,'%d-%m-%Y') AS EE_FROM_PERIOD,DATE_FORMAT(EE_TO_PERIOD,'%d-%m-%Y') AS EE_TO_PERIOD,EE_DEPOSIT,EE_DEPOSIT_REFUND,EE_INVOICE_AMOUNT,EE_COMMENTS,EE_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EE_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') FROM $BDLY_SRC_electemp_name ORDER BY EE_DEPOSIT_REFUND,EE_UNITNO,EE_INVOICE_DATE ASC";
      }
        /*STARHUB AMNT*/$BDLY_SRC_SelectQuery['2']['181'] = "SELECT ESH.ESH_ID,U.UNIT_NO,EC.ECN_DATA,EDSH.EDSH_ACCOUNT_NO,DATE_FORMAT(ESH.ESH_INVOICE_DATE,'%d-%m-%Y') AS STARHUBINVOICEDATE,DATE_FORMAT(ESH.ESH_FROM_PERIOD,'%d-%m-%Y') AS STARHUBFROMPERIOD,DATE_FORMAT(ESH.ESH_TO_PERIOD,'%d-%m-%Y') AS STARHUBTOPERIOD,ESH.ESH_AMOUNT,ESH.ESH_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ESH.ESH_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS STARHUB_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_STARHUB EDSH ON U.UNIT_ID=EDSH.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDSH.ECN_ID JOIN EXPENSE_STARHUB ESH ON ESH.EDSH_ID=EDSH.EDSH_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ESH.ULD_ID AND ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND ESH.ESH_AMOUNT BETWEEN '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY ESH_AMOUNT,U.UNIT_NO,ESH_INVOICE_DATE ASC ";
      /*UNIT EXPENSE AMNT*/$BDLY_SRC_SelectQuery['3']['187'] = "SELECT EU.EU_ID,U.UNIT_NO,EC.ECN_DATA,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME,DATE_FORMAT(EU.EU_INVOICE_DATE,'%d-%m-%Y'),EU.EU_INVOICE_ITEMS,EU.EU_INVOICE_FROM,EU.EU_AMOUNT,EU.EU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EU.EU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EU_TIMESTAMP  FROM EXPENSE_UNIT AS EU JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EU.UNIT_ID LEFT JOIN CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID JOIN EXPENSE_CONFIGURATION EC ON EU.ECN_ID=EC.ECN_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EU.ULD_ID AND  EU.EU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EU.EU_AMOUNT BETWEEN '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EU.EU_AMOUNT,U.UNIT_NO,EU.EU_INVOICE_DATE ASC";
      /*FACILITY USE DEPOSIT AMNT*/$BDLY_SRC_SelectQuery['4']['168'] = "SELECT EFU.EFU_ID,U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_FACILITY_USE EFU ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EFU.EFU_DEPOSIT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EFU.EFU_DEPOSIT,U.UNIT_NO,EFU.EFU_INVOICE_DATE ASC";
      /*FACILITY USE INVOICE AMNT*/$BDLY_SRC_SelectQuery['4']['169'] = "SELECT EFU.EFU_ID,U.UNIT_NO,DATE_FORMAT(EFU.EFU_INVOICE_DATE,'%d-%m-%Y') AS FACILITYINVOICEDATE,EFU.EFU_DEPOSIT,EFU.EFU_AMOUNT,EFU.EFU_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EFU.EFU_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS FACILITY_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_FACILITY_USE EFU ON U.UNIT_ID=EFU.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EFU.ULD_ID AND EFU_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EFU.EFU_AMOUNT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EFU.EFU_AMOUNT,U.UNIT_NO,EFU.EFU_INVOICE_DATE ASC";
      /*DIGITAL VOICE*/$BDLY_SRC_SelectQuery['5']['152'] = "SELECT EDV.EDV_ID,U.UNIT_NO,EC.ECN_DATA,EDDV.EDDV_DIGITAL_VOICE_NO,EDDV.EDDV_DIGITAL_ACCOUNT_NO,DATE_FORMAT(EDV.EDV_INVOICE_DATE,'%d-%m-%Y') AS DIGI_INV_DATE,DATE_FORMAT(EDV.EDV_FROM_PERIOD,'%d-%m-%Y') AS DIGI_FROM_PERIOD,DATE_FORMAT(EDV.EDV_TO_PERIOD,'%d-%m-%Y') AS DIGI_TO_PERIOD,EDV.EDV_AMOUNT,EDV.EDV_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EDV.EDV_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS DIGITAL_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_DIGITAL_VOICE EDDV ON U.UNIT_ID=EDDV.UNIT_ID JOIN EXPENSE_CONFIGURATION EC ON EC.ECN_ID=EDDV.ECN_ID JOIN EXPENSE_DIGITAL_VOICE EDV ON EDV.EDDV_ID=EDDV.EDDV_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EDV.ULD_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EDV.EDV_AMOUNT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EDV.EDV_AMOUNT,U.UNIT_NO,EDV.EDV_INVOICE_DATE ASC";
      /*PURCHASE CARD AMNT*/$BDLY_SRC_SelectQuery['6']['176'] = "SELECT EPC.EPNC_ID,U.UNIT_NO,EPC.EPNC_NUMBER,DATE_FORMAT(EPC.EPNC_INVOICE_DATE,'%d-%m-%Y') AS PURCAHSESDATE,EPC.EPNC_AMOUNT,EPC.EPNC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPNC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS PURCHASE_TIMESTAMP FROM EXPENSE_PURCHASE_NEW_CARD EPC JOIN VW_ACTIVE_UNIT U ON EPC.UNIT_ID=U.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC.EPNC_AMOUNT BETWEEN '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EPC.EPNC_AMOUNT,U.UNIT_NO,EPC.EPNC_INVOICE_DATE ASC";
      /*MOVING IN OUT AMNT*/$BDLY_SRC_SelectQuery['7']['172'] = "SELECT M.EMIO_ID,U.UNIT_NO,DATE_FORMAT(M.EMIO_INVOICE_DATE,'%d-%m-%Y') AS COMMENTSDATE,M.EMIO_AMOUNT,M.EMIO_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(M.EMIO_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS MOVING_TIMESTAMP FROM EXPENSE_MOVING_IN_AND_OUT M JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=M.UNIT_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=M.ULD_ID AND  M.EMIO_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate'AND M.EMIO_AMOUNT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY M.EMIO_AMOUNT,U.UNIT_NO,M.EMIO_INVOICE_DATE ASC";
      /*CAR PARK AMNT*/$BDLY_SRC_SelectQuery['8']['132'] = "SELECT ECP.ECP_PARK_ID,U.UNIT_NO,EDCP.EDCP_CAR_NO,DATE_FORMAT(ECP.ECP_INVOICE_DATE,'%d-%m-%Y') AS CARPARKINVOICEDATE,DATE_FORMAT(ECP.ECP_FROM_PERIOD,'%d-%m-%Y') AS CARPARKFROMPERIOD,DATE_FORMAT(ECP.ECP_TO_PERIOD,'%d-%m-%Y') AS CARPARKTOPERIOD,ECP.ECP_AMOUNT,ECP.ECP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ECP.ECP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CARPARK_TIMESTAMP FROM VW_ACTIVE_UNIT U JOIN EXPENSE_DETAIL_CARPARK EDCP ON U.UNIT_ID=EDCP.UNIT_ID JOIN EXPENSE_CARPARK ECP ON EDCP.EDCP_ID=ECP.EDCP_ID,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=ECP.ULD_ID AND ECP.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND ECP.ECP_AMOUNT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY ECP.ECP_AMOUNT,U.UNIT_NO,ECP.ECP_INVOICE_DATE ASC";
      /*PETTY CASH CASH IN AMT*/$BDLY_SRC_SelectQuery['10']['137'] = "SELECT EPC.EPC_ID,DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC_CASH_IN  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EPC_CASH_IN,EPC.EPC_DATE ASC";
      /*PETTY CASH CASH OUT AMT*/$BDLY_SRC_SelectQuery['10']['138'] = "SELECT EPC.EPC_ID,DATE_FORMAT(EPC.EPC_DATE,'%d-%m-%Y') AS DATE,EPC.EPC_CASH_IN,EPC.EPC_CASH_OUT,EPC.EPC_BALANCE,EPC.EPC_INVOICE_ITEMS,EPC.EPC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EPC.EPC_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS TIMESTAMP FROM EXPENSE_PETTY_CASH EPC ,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=EPC.ULD_ID AND  EPC.EPC_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EPC_CASH_OUT  BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EPC_CASH_OUT,EPC.EPC_DATE ASC";
      /*HOUSE KEEPING PAYMENT AMNT*/$BDLY_SRC_SelectQuery['12']['148'] ="SELECT EHKP.EHKP_ID,UNIT_NO,EHKP.EHKP_AMOUNT,DATE_FORMAT(EHKP.EHKP_FOR_PERIOD,'%M-%Y'),DATE_FORMAT(EHKP.EHKP_PAID_DATE,'%d-%m-%Y') AS DATE,EHKP.EHKP_COMMENTS,EHKP.EHKP_USERSTAMP,DATE_FORMAT(CONVERT_TZ(EHKP.EHKP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS EHKP_TIMESTAMP FROM $BDLY_SRC_tmptbl_hkpsrch EHKP WHERE  EHKP.EHKP_PAID_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' AND EHKP.EHKP_AMOUNT BETWEEN  '$BDLY_SRC_tb_fromamnt' AND '$BDLY_SRC_tb_toamnt' ORDER BY EHKP.EHKP_AMOUNT,UNIT_NO,EHKP.EHKP_PAID_DATE ASC";
    }
    $execute_statement = $this->db->query($BDLY_SRC_SelectQuery[$BDLY_SRC_lb_ExpenseList_val][$BDLY_SRC_lb_serachopt]);
        $headerarrdata=array();
        foreach ($execute_statement->list_fields() as $field)
        {
            $headerarrdata[] = $field;
        }
        foreach ($execute_statement->result_array() as $row)
        {
        $rowarray =[];$Totalcolumns=count($BDLY_SRC_GridHeaders);
          for($x=0; $x<$Totalcolumns; $x++){
                if($BDLY_SRC_lb_serachopt==142&&$x==2){
                    $rowarray[]=number_format($row[$headerarrdata[$x]],2);
                }
                else
                {
                    $rowarray[]=$row[$headerarrdata[$x]];
                }
            }
      $BDLY_SRC_Expdataobject[]=$rowarray;
        }
    if(($BDLY_SRC_lb_ExpenseList_val==1)||($BDLY_SRC_lb_serachopt==142))
    {
        $this->BDLY_SRC_drophkpaymentsptemptable($BDLY_SRC_electemp_name);
    }
    $unit_start_end_date_query = $this->db->query("SELECT U.UNIT_NO,UD.UD_START_DATE,UD.UD_END_DATE FROM UNIT_DETAILS UD JOIN UNIT U ON U.UNIT_ID=UD.UNIT_ID ORDER BY U.UNIT_NO ASC");
    $unit_start_end_date_obj=[];
    foreach ($unit_start_end_date_query->result_array() as $row)
    {
        $unit_start_end_date_obj['UNITNO'.$row['UNIT_NO']]=[$row['UD_START_DATE'],$row['UD_END_DATE']];
    }

    $this->BDLY_SRC_drophkpaymentsptemptable($BDLY_SRC_tmptbl_hkpsrch);
    $BDLY_SRC_arr_unitcmts=[];

    if($BDLY_SRC_lb_ExpenseList_val==3)
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $BDLY_SRC_arr_unitcmts=$this->Mdl_eilib_common_function->BDLY_getinvoicefrom();
    }

    return [$BDLY_SRC_Expdataobject,$unit_start_end_date_obj,$BDLY_SRC_TableWidth,$BDLY_SRC_arr_unitcmts];
}

 public  function BDLY_SRC_get_cleanername($BDLY_SRC_startdate,$BDLY_SRC_enddate,$selectedSearchopt)
    {
        if($selectedSearchopt==142)
        {
            $BDLY_SRC_startdate=date('Y-m-01',strtotime($BDLY_SRC_startdate));
            $BDLY_SRC_enddate=date('Y-m-t',strtotime($BDLY_SRC_startdate));
            $BDLY_SRC_cleanername_query =$this->db->query("SELECT EMP_ID,CONCAT(EMP_FIRST_NAME,' ',EMP_LAST_NAME) AS NAME  FROM EMPLOYEE_DETAILS WHERE EMP_ID IN (SELECT EMP_ID FROM EXPENSE_HOUSEKEEPING WHERE EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate') ORDER BY NAME");
    }
        else
        {
            $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
            $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
            $BDLY_SRC_cleanername_query =$this->db->query("SELECT EMP_ID,CONCAT(EMP_FIRST_NAME,' ',EMP_LAST_NAME) AS NAME  FROM EMPLOYEE_DETAILS WHERE EMP_ID IN (SELECT EMP_ID FROM EXPENSE_HOUSEKEEPING WHERE EHK_WORK_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate') ORDER BY NAME");
        }
    $BDLY_SRC_cleanername_array=[];
        foreach ($BDLY_SRC_cleanername_query->result_array() as $row)
        {
            $BDLY_SRC_cleanername_array[]=(object)['key'=>$row['EMP_ID'],'value'=>$row['NAME']];
        }
    return $this->BDLY_SRC_detect_repeated_name($BDLY_SRC_cleanername_array);
    }
    /*------------------------------------------BINDING ID WITH OPTION FOR REPEATED NAME-------------------------------------------*/
    public function BDLY_SRC_detect_repeated_name($BDLY_SRC_cusname_array){
        $BDLY_SRC_Modified_cusname_array=[];
    $total_cusname_count=count($BDLY_SRC_cusname_array);
    for ($x=0; $x<$total_cusname_count; $x++){
            $next_value=$x+1;
            $previous_value=$x-1;
            $BDLY_SRC_cusname_with_id =['key'=>$BDLY_SRC_cusname_array[$x]->key,'value'=>$BDLY_SRC_cusname_array[$x]->value.' '.$BDLY_SRC_cusname_array[$x]->key];
            $BDLY_SRC_cusname_without_id= ['key'=>$BDLY_SRC_cusname_array[$x]->key,'value'=>$BDLY_SRC_cusname_array[$x]->value];
      if($x==$total_cusname_count-1 && count($BDLY_SRC_Modified_cusname_array)<$total_cusname_count)
          $BDLY_SRC_Modified_cusname_array[]=$BDLY_SRC_cusname_without_id;
        else
        {
            if($x>0){
                if($BDLY_SRC_cusname_array[$x]->value == $BDLY_SRC_cusname_array[$previous_value]->value)
              $BDLY_SRC_Modified_cusname_array[]=$BDLY_SRC_cusname_with_id;
              else if($x!=$total_cusname_count-1){
                    if($BDLY_SRC_cusname_array[$x]->value == $BDLY_SRC_cusname_array[$next_value]->value)
                  $BDLY_SRC_Modified_cusname_array[]=$BDLY_SRC_cusname_with_id;
                  else
                    $BDLY_SRC_Modified_cusname_array[]=$BDLY_SRC_cusname_without_id;
                    }
          }
            if($x==0 && count($BDLY_SRC_Modified_cusname_array)<1){
                if($BDLY_SRC_cusname_array[$x]->value == $BDLY_SRC_cusname_array[$next_value]->value)
              $BDLY_SRC_Modified_cusname_array[]=$BDLY_SRC_cusname_with_id;
              else
                $BDLY_SRC_Modified_cusname_array[]=$BDLY_SRC_cusname_without_id;
                }
        }
    }
    return $BDLY_SRC_Modified_cusname_array;
  }

    /*------------------------------------------TO GET CUSTOMER NAME--------------------------------------------------------*/
    public function BDLY_SRC_get_cusname($unitno,$startdate,$enddate){
    if($startdate!='')
    {
        $startdate=date('Y-m-d',strtotime($startdate));
        $enddate=date('Y-m-d',strtotime($enddate));
      $BDLY_SRC_unitexp_categry_query ="SELECT DISTINCT  EU.CUSTOMER_ID ,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME FROM EXPENSE_UNIT EU JOIN  CUSTOMER C ON C.CUSTOMER_ID=EU.CUSTOMER_ID WHERE EU.EU_INVOICE_DATE BETWEEN '$startdate' AND '$enddate' AND EU.ECN_ID =23 ORDER BY NAME ASC, EU.CUSTOMER_ID";
    }
    else
    {
      $BDLY_SRC_unitexp_categry_query ="SELECT  DISTINCT CED.CUSTOMER_ID ,CONCAT(C.CUSTOMER_FIRST_NAME,' ',C.CUSTOMER_LAST_NAME) AS NAME, CED.UNIT_ID FROM CUSTOMER_ENTRY_DETAILS CED JOIN CUSTOMER C ON C.CUSTOMER_ID=CED.CUSTOMER_ID JOIN UNIT U ON U.UNIT_ID=CED.UNIT_ID  WHERE U.UNIT_NO='$unitno' ORDER BY NAME ASC, CED.CUSTOMER_ID";
    }
    $BDLY_SRC_cusname_array=[];
   $execute_statement = $this->db->query($BDLY_SRC_unitexp_categry_query);
        foreach ($execute_statement->result_array() as $row)
        {
          $BDLY_SRC_cusname_array[]=(object)['key'=>$row['CUSTOMER_ID'],'value'=>$row['NAME']];
        }
    return $this->BDLY_SRC_detect_repeated_name($BDLY_SRC_cusname_array);
  }

    public function BDLY_SRC_get_autocomplete($USERSTAMP){
        $selectedexpense= $_POST['BDLY_SRC_lb_ExpenseList'];
        $selectedSearchopt=$_POST['BDLY_SRC_lb_serachopt'];
        $startdate=$_POST['BDLY_SRC_startdate'];
        $startdate=date('Y-m-d',strtotime($startdate));
        $endate=$_POST['BDLY_SRC_enddate'];
        $endate=date('Y-m-d',strtotime($endate));
        $BDLY_SRC_tmptbl_hkpsrch='';
    $BDLY_SRC_Autocomp_query=[1=>[],2=>[],3=>[],4=>[],5=>[],6=>[],7=>[],8=>[],9=>[],10=>[],11=>[],12=>[]];
    /*ELECTRICITY COMMENTS*/$BDLY_SRC_Autocomp_query['1']['159']="SELECT DISTINCT EE.EE_COMMENTS FROM EXPENSE_ELECTRICITY EE,EXPENSE_DETAIL_ELECTRICITY EDE,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EDE.UNIT_ID AND EE.EE_COMMENTS IS NOT NULL AND EDE.EDE_ID=EE.EDE_ID AND EE.EE_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*STARHUB COMMENTS*/$BDLY_SRC_Autocomp_query['2']['179']="SELECT DISTINCT ESH.ESH_COMMENTS FROM EXPENSE_STARHUB ESH,EXPENSE_DETAIL_STARHUB EDS,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EDS.UNIT_ID AND EDS.EDSH_ID=ESH.EDSH_ID AND ESH.ESH_COMMENTS IS NOT NULL AND ESH.ESH_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*UNIT EXP INVOICE ITEM*/$BDLY_SRC_Autocomp_query['3']['189']="SELECT DISTINCT EU.EU_INVOICE_ITEMS FROM EXPENSE_UNIT EU,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EU.UNIT_ID AND EU.EU_INVOICE_ITEMS IS NOT NULL AND EU.EU_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*UNIT EXP INVOICE FROM*/$BDLY_SRC_Autocomp_query['3']['190']="SELECT DISTINCT EU.EU_INVOICE_FROM FROM EXPENSE_UNIT EU,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EU.UNIT_ID AND EU.EU_INVOICE_FROM IS NOT NULL AND EU.EU_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*UNIT EXP COMMENTS*/$BDLY_SRC_Autocomp_query['3']['185']="SELECT DISTINCT EU.EU_COMMENTS FROM EXPENSE_UNIT EU,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EU.UNIT_ID AND EU.EU_COMMENTS IS NOT NULL AND EU.EU_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*FACILITY USE COMMENTS*/$BDLY_SRC_Autocomp_query['4']['167']="SELECT DISTINCT EFU.EFU_COMMENTS FROM EXPENSE_FACILITY_USE EFU,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EFU.UNIT_ID AND EFU.EFU_COMMENTS IS NOT NULL AND EFU.EFU_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*DIGITAL VOICE COMMENTS*/$BDLY_SRC_Autocomp_query['5']['153']="SELECT DISTINCT EDV.EDV_COMMENTS FROM EXPENSE_DIGITAL_VOICE EDV,EXPENSE_DETAIL_DIGITAL_VOICE EDDV,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EDDV.UNIT_ID AND EDDV.EDDV_ID=EDV.EDDV_ID AND EDV.EDV_COMMENTS IS NOT NULL AND EDV.EDV_COMMENTS!='' AND EDV.EDV_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*PURCHASE CARD COMMENTS*/$BDLY_SRC_Autocomp_query['6']['175']="SELECT DISTINCT EPNC.EPNC_COMMENTS FROM EXPENSE_PURCHASE_NEW_CARD EPNC,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EPNC.UNIT_ID AND EPNC.EPNC_COMMENTS IS NOT NULL AND EPNC.EPNC_COMMENTS!='' AND EPNC.EPNC_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*MOVING IN OUT COMMENTS*/$BDLY_SRC_Autocomp_query['7']['171']="SELECT DISTINCT EMIO.EMIO_COMMENTS FROM EXPENSE_MOVING_IN_AND_OUT  EMIO,VW_ACTIVE_UNIT U WHERE U.UNIT_ID= EMIO.UNIT_ID AND EMIO.EMIO_COMMENTS IS NOT NULL AND EMIO.EMIO_COMMENTS!='' AND EMIO.EMIO_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*CAR PARK COMMENTS*/$BDLY_SRC_Autocomp_query['8']['128']="SELECT DISTINCT ECP.ECP_COMMENTS FROM EXPENSE_CARPARK ECP,EXPENSE_DETAIL_CARPARK EDCP,VW_ACTIVE_UNIT U WHERE U.UNIT_ID= EDCP.UNIT_ID AND EDCP.EDCP_ID=ECP.EDCP_ID AND ECP.ECP_COMMENTS IS NOT NULL AND ECP.ECP_COMMENTS!='' AND ECP.ECP_INVOICE_DATE BETWEEN '$startdate' AND '$endate'";
    /*AIRCON SERVICE COMMENTS*/$BDLY_SRC_Autocomp_query['9']['125']="SELECT DISTINCT EAS.EAS_COMMENTS FROM EXPENSE_AIRCON_SERVICE EAS,EXPENSE_DETAIL_AIRCON_SERVICE EDAS,VW_ACTIVE_UNIT U WHERE U.UNIT_ID= EDAS.UNIT_ID AND EDAS.EDAS_ID=EAS.EDAS_ID AND EAS.EAS_COMMENTS IS NOT NULL AND EAS.EAS_COMMENTS!='' AND EAS.EAS_DATE BETWEEN '$startdate' AND '$endate'";
    /*PETTY CASH INVOICE ITEMS*/$BDLY_SRC_Autocomp_query['10']['139']="SELECT DISTINCT EPC_INVOICE_ITEMS FROM EXPENSE_PETTY_CASH WHERE EPC_INVOICE_ITEMS IS NOT NULL AND EPC_INVOICE_ITEMS!='' AND EPC_DATE BETWEEN '$startdate' AND '$endate'";
    /*PETTY CASH COMMENTS*/$BDLY_SRC_Autocomp_query['10']['140']="SELECT DISTINCT EPC_COMMENTS FROM EXPENSE_PETTY_CASH WHERE EPC_COMMENTS IS NOT NULL AND EPC_COMMENTS!='' AND EPC_DATE BETWEEN '$startdate' AND '$endate'";
    /*HOUSE KEEPING COMMENTS*/$BDLY_SRC_Autocomp_query['11']['143']="SELECT DISTINCT EHK_DESCRIPTION  FROM EXPENSE_HOUSEKEEPING WHERE EHK_DESCRIPTION  IS NOT NULL AND EHK_DESCRIPTION !='' AND EHK_WORK_DATE BETWEEN '$startdate' AND '$endate'";
    if($selectedexpense==12)
    {
        $BDLY_SRC_tmptbl_hkpsrch= $this->BDLY_SRC_callhkpaymentsp($USERSTAMP);
    }
    /*HOUSE KEEPING PAYMENT COMMENTS*/$BDLY_SRC_Autocomp_query['12']['146']="SELECT DISTINCT EHKP_COMMENTS  FROM $BDLY_SRC_tmptbl_hkpsrch WHERE EHKP_COMMENTS  IS NOT NULL AND EHKP_COMMENTS !='' AND EHKP_PAID_DATE BETWEEN '$startdate' AND '$endate'";
    $BDLY_SRC_Autocomp_array=[];
    $execute_statement = $this->db->query($BDLY_SRC_Autocomp_query[$selectedexpense][$selectedSearchopt]);
        $headerarrdata=array();
        foreach ($execute_statement->list_fields() as $field)
        {
            $headerarrdata[] = $field;
        }
        foreach ($execute_statement->result_array() as $row)
        {
        $BDLY_SRC_Autocomp_array[]=$row[$headerarrdata[0]];
        }
      $this->BDLY_SRC_drophkpaymentsptemptable($BDLY_SRC_tmptbl_hkpsrch);
    return $BDLY_SRC_Autocomp_array;
    }
    /*------------------------------------------TO GET DIGITAL VOICE N STARHUB ACCOUNT NO--------------------------------------------------------*/
  public  function BDLY_SRC_get_accountno($selectedexpense,$BDLY_SRC_startdate,$BDLY_SRC_enddate){
      $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
      $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
        if($selectedexpense==2)
      $BDLY_SRC_accountno_query = "SELECT DISTINCT EDSH.EDSH_ACCOUNT_NO FROM EXPENSE_STARHUB ES JOIN EXPENSE_DETAIL_STARHUB EDSH ON ES.EDSH_ID=EDSH.EDSH_ID,VW_ACTIVE_UNIT U WHERE EDSH.UNIT_ID=U.UNIT_ID AND ES.ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDSH.EDSH_ACCOUNT_NO";
    else
      $BDLY_SRC_accountno_query = "SELECT  DISTINCT EDDV.EDDV_DIGITAL_ACCOUNT_NO FROM  EXPENSE_DETAIL_DIGITAL_VOICE EDDV JOIN EXPENSE_DIGITAL_VOICE EDV  ON EDV.EDDV_ID=EDDV.EDDV_ID,VW_ACTIVE_UNIT U WHERE EDDV.UNIT_ID=U.UNIT_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDDV.EDDV_DIGITAL_ACCOUNT_NO";
    $BDLY_SRC_accountno_array=[];
    $execute_statement = $this->db->query($BDLY_SRC_accountno_query);
      $headerarrdata=array();
      foreach ($execute_statement->list_fields() as $field)
      {
          $headerarrdata[] = $field;
      }
    foreach ($execute_statement->result_array() as $row)
    {
        $BDLY_SRC_accountno_array[]=['value'=>$row[$headerarrdata[0]]];
    }
    return $BDLY_SRC_accountno_array;
  }
    /*------------------------------------------TO GET DIGITAL INVOICE TO LIST--------------------------------------------------------*/
    public function BDLY_SRC_invoiceto($selectedexpense,$selectedSearchopt,$BDLY_SRC_startdate,$BDLY_SRC_enddate){
        $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
        $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
        $BDLY_SRC_InvoiceToQuery=[1=>[],2=>[],3=>[],4=>[],5=>[],6=>[],7=>[],8=>[],9=>[],10=>[],11=>[],12=>[]];
    /*ELECTRICITY INVOICE TO*/$BDLY_SRC_InvoiceToQuery['1']['165']="SELECT DISTINCT EC.ECN_ID,EC.ECN_DATA FROM  EXPENSE_CONFIGURATION EC,EXPENSE_DETAIL_ELECTRICITY EDE,EXPENSE_ELECTRICITY EE,VW_ACTIVE_UNIT U WHERE EC.ECN_ID=EDE.ECN_ID AND U.UNIT_ID=EDE.UNIT_ID AND EDE.EDE_ID=EE.EDE_ID AND EE.EE_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ECN_DATA ASC";
    /*STARHUB INVOICE TO*/$BDLY_SRC_InvoiceToQuery['2']['183']="SELECT DISTINCT EC.ECN_ID,EC.ECN_DATA FROM  EXPENSE_CONFIGURATION EC,EXPENSE_DETAIL_STARHUB EDS,EXPENSE_STARHUB ES,VW_ACTIVE_UNIT U WHERE EC.ECN_ID=EDS.ECN_ID AND U.UNIT_ID=EDS.UNIT_ID AND EDS.EDSH_ID=ES.EDSH_ID AND ES.ESH_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ECN_DATA ASC";
    /*DIGITAL VOICE INVOICE TO*/$BDLY_SRC_InvoiceToQuery['5']['157']="SELECT DISTINCT EC.ECN_ID,EC.ECN_DATA FROM  EXPENSE_CONFIGURATION EC,EXPENSE_DETAIL_DIGITAL_VOICE EDDV,EXPENSE_DIGITAL_VOICE EDV,VW_ACTIVE_UNIT U WHERE EC.ECN_ID=EDDV.ECN_ID AND U.UNIT_ID=EDDV.UNIT_ID AND EDDV.EDDV_ID=EDV.EDDV_ID AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY ECN_DATA ASC";
    $BDLY_SRC_InvocieToarray=[];
    $execute_statement = $this->db->query($BDLY_SRC_InvoiceToQuery[$selectedexpense][$selectedSearchopt]);
        foreach ($execute_statement->result_array() as $row)
        {
        $BDLY_SRC_InvocieToarray[]=['key'=>$row['ECN_ID'],'value'=>$row['ECN_DATA']];
        }
    return $BDLY_SRC_InvocieToarray;
  }
    /*------------------------------------------TO GET PURCHASE CARD NO------------------------------------------------------*/
    public function BDLY_SRC_getPurchase_card($BDLY_SRC_startdate,$BDLY_SRC_enddate){
        $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
        $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
        $BDLY_SRC_purchasecardno_query = "SELECT DISTINCT EPNC.EPNC_NUMBER FROM EXPENSE_PURCHASE_NEW_CARD EPNC,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EPNC.UNIT_ID AND EPNC.EPNC_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EPNC_NUMBER ASC ";
        $BDLY_SRC_unitexp_catg_array=[];
        $execute_statement = $this->db->query($BDLY_SRC_purchasecardno_query);
    foreach ($execute_statement->result_array() as $row)
    {
        $BDLY_SRC_unitexp_catg_array[]=['key'=>$row['EPNC_NUMBER'],'value'=>$row['EPNC_NUMBER']];
    }
    return $BDLY_SRC_unitexp_catg_array;
  }
    /*------------------------------------------TO GET CAR NO LIST--------------------------------------------------------*/
    public function BDLY_SRC_getCarNoList($BDLY_SRC_startdate,$BDLY_SRC_enddate){
        $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
        $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
        $BDLY_SRC_SelectServiceByQuery= "SELECT DISTINCT EDCP_CAR_NO  FROM EXPENSE_CARPARK EC JOIN  EXPENSE_DETAIL_CARPARK EDC ON EDC.EDCP_ID=EC.EDCP_ID AND EC.ECP_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDCP_CAR_NO ASC";
        $BDLY_SRC_servicebyarray=[];
        $execute_statement = $this->db->query($BDLY_SRC_SelectServiceByQuery);
        foreach ($execute_statement->result_array() as $row)
        {
        $BDLY_SRC_servicebyarray[]=['key'=>$row['EDCP_CAR_NO']];
        }
    return $BDLY_SRC_servicebyarray;
  }
    /*------------------------------------------TO GET SERVICE BY LIST------------------------------------------------------*/
    public function BDLY_SRC_getServiceByList($BDLY_SRC_startdate,$BDLY_SRC_enddate){
        $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
        $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
        $BDLY_SRC_SelectServiceByQuery= "SELECT DISTINCT EASB.EASB_DATA FROM  EXPENSE_AIRCON_SERVICE EAS JOIN EXPENSE_DETAIL_AIRCON_SERVICE EDAS ON EDAS.EDAS_ID = EAS.EDAS_ID JOIN EXPENSE_AIRCON_SERVICE_BY EASB ON  EASB.EASB_ID = EDAS.EASB_ID JOIN VW_ACTIVE_UNIT U ON U.UNIT_ID=EDAS.UNIT_ID AND EAS.EAS_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate'  ORDER BY EASB.EASB_DATA ASC";
    $BDLY_SRC_servicebyarray=[];
    $execute_statement = $this->db->query($BDLY_SRC_SelectServiceByQuery);
        foreach ($execute_statement->result_array() as $row)
        {
        $BDLY_SRC_servicebyarray[]=['key'=>$row['EASB_DATA']];
        }
    return $BDLY_SRC_servicebyarray;
  }
    /*------------------------------------------GET DIGITAL VOICE NO TO LIST---------------------------------------------------------*/
    public function BDLY_SRC_getDigitalVoiceNo($BDLY_SRC_startdate,$BDLY_SRC_enddate)
    {
        $BDLY_SRC_startdate=date('Y-m-d',strtotime($BDLY_SRC_startdate));
        $BDLY_SRC_enddate=date('Y-m-d',strtotime($BDLY_SRC_enddate));
    $BDLY_SRC_digvoicenoquery="SELECT DISTINCT EDDV.EDDV_DIGITAL_VOICE_NO FROM EXPENSE_DIGITAL_VOICE EDV,EXPENSE_DETAIL_DIGITAL_VOICE EDDV,VW_ACTIVE_UNIT U WHERE U.UNIT_ID=EDDV.UNIT_ID AND EDDV.EDDV_ID=EDV.EDDV_ID AND EDDV.EDDV_DIGITAL_VOICE_NO IS NOT NULL AND EDDV.EDDV_DIGITAL_VOICE_NO!='' AND EDV.EDV_INVOICE_DATE BETWEEN '$BDLY_SRC_startdate' AND '$BDLY_SRC_enddate' ORDER BY EDDV.EDDV_DIGITAL_VOICE_NO ASC";
    $BDLY_SRC_digvoicenoarray=[];
    $execute_statement = $this->db->query($BDLY_SRC_digvoicenoquery);
        foreach ($execute_statement->result_array() as $row)
        {
        $BDLY_SRC_digvoicenoarray[]=['key'=>$row['EDDV_DIGITAL_VOICE_NO']];
        }
    return $BDLY_SRC_digvoicenoarray;
  }
    /*------------------------------------------WILL CHK FOR EXISTING ACCESS CARD OR UNIT NO -----------------------------------------------------*/
   public  function BDLY_SRC_check_access_cardOrUnitno($BDLY_SCR_DT_access_cardrunit,$BDLY_SRC_selectedexptype){
        $BDLY_SRC_CHKcardorunitflag="";
        if($BDLY_SRC_selectedexptype==6)
        {
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $BDLY_SRC_CHKcardorunitflag=$this->Mdl_eilib_common_function->Check_ExistsCard($BDLY_SCR_DT_access_cardrunit);
        }
        else
        {
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $CheckHKPUnitnoExists=$this->Mdl_eilib_common_function->CheckHKPUnitnoExists($BDLY_SCR_DT_access_cardrunit);
            $CheckUnitnoExists=$this->Mdl_eilib_common_function->CheckUnitnoExists($BDLY_SCR_DT_access_cardrunit);
            if (($CheckHKPUnitnoExists==true) || ($CheckUnitnoExists==true))
            {
                $BDLY_SRC_CHKcardorunitflag=true;
            }
            else
            {
                $BDLY_SRC_CHKcardorunitflag=false;
            }
        }
        return $BDLY_SRC_CHKcardorunitflag;
    }
    /*------------------------------------------EILIB FUNCTION TO GET UNIT SDATE,EDATE AND INVDATE -----------------------------------------------------*/
    public function BDLY_SRC_getUnitDate($BDLY_SRC_unitno){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $BDLY_SRC_unitdate=$this->Mdl_eilib_common_function->GetUnitSdEdInvdate($BDLY_SRC_unitno);
        return $BDLY_SRC_unitdate;
    }
    /*------------------------------------------WILL UPDATE DATA TABLE ROW IN DB -------------------------------------------------*/
    public function BDLY_SRC_UpdaterowData($BDLY_new_values,$BDLY_old_values,$expense,$selectedSearchopt,$USERSTAMP){
        $BDLY_SRC_commenttype=[1=>9,2=>8,3=>8,4=>5,5=>9,6=>5,7=>4,8=>7,9=>4,10=>6,11=>4,12=>5];
    if($selectedSearchopt!=198)
    {
        $BDLY_SRC_commentvalue=$BDLY_new_values[$BDLY_SRC_commenttype[$expense]];
        $BDLY_SRC_commentvalue=$this->db->escape_like_str($BDLY_SRC_commentvalue);
      if($BDLY_SRC_commentvalue=="")//COMMENTS
      {  $BDLY_SRC_commentvalue="null";
      }else{
          $BDLY_SRC_commentvalue="'$BDLY_SRC_commentvalue'";}
    }
    $updatequery='';
    $BDLY_SRC_updateflag=0;
    switch ($expense)
    {
        case 1:
        {
            $EELC_AMOUNT="";$EELC_AMTID=0;
        if($BDLY_new_values[6]!="")
        {
            $EELC_AMOUNT=$BDLY_new_values[6];
            $EELC_AMTID=135;
        }
        else if($BDLY_new_values[7]!=""){
            $EELC_AMOUNT=$BDLY_new_values[7];
            $EELC_AMTID=134;
        } else {
            $EELC_AMOUNT=$BDLY_new_values[8];
            $EELC_AMTID=133;
        }
            $BDLY_new_values3=date('Y-m-d',strtotime($BDLY_new_values[3]));
            $BDLY_new_values4=date('Y-m-d',strtotime($BDLY_new_values[4]));
            $BDLY_new_values5=date('Y-m-d',strtotime($BDLY_new_values[5]));
        $updatequery ="CALL SP_BIZDLY_ELECTRICITY_UPDATE('$BDLY_new_values[0]','$BDLY_new_values3','$BDLY_new_values4','$BDLY_new_values5','$EELC_AMTID','$EELC_AMOUNT',$BDLY_SRC_commentvalue,'$USERSTAMP',@UPDATE_FLAG)";
        break;
            }
        case 2: {
            $BDLY_new_values4=date('Y-m-d',strtotime($BDLY_new_values[4]));
            $BDLY_new_values5=date('Y-m-d',strtotime($BDLY_new_values[5]));
            $BDLY_new_values6=date('Y-m-d',strtotime($BDLY_new_values[6]));
            $updatequery= "CALL SP_BIZDLY_STARHUB_UPDATE('$BDLY_new_values[0]','$BDLY_new_values4','$BDLY_new_values5','$BDLY_new_values6','$BDLY_new_values[7]',$BDLY_SRC_commentvalue,'$USERSTAMP',@UPDATE_FLAG)";
        break;
      }
        case 3:{
            if($BDLY_new_values[3]==''){$BDLY_new_values3='null';}else{$BDLY_new_values3="'$BDLY_new_values[3]'";}
            $BDLY_new_values4=date('Y-m-d',strtotime($BDLY_new_values[4]));
            $BDLY_new_values5=$this->db->escape_like_str($BDLY_new_values[5]);
            $BDLY_new_values6=$this->db->escape_like_str($BDLY_new_values[6]);
            if($BDLY_new_values5=='' || $BDLY_new_values6=='')
            {
                $BDLY_new_values5='null';
                $BDLY_new_values6='null';
            }else{
                $BDLY_new_values5="'$BDLY_new_values5'";
                $BDLY_new_values6="'$BDLY_new_values6'";
            }
          $updatequery = "UPDATE EXPENSE_UNIT SET ECN_ID='$BDLY_new_values[2]',CUSTOMER_ID=$BDLY_new_values3,EU_INVOICE_DATE='$BDLY_new_values4',EU_AMOUNT='$BDLY_new_values[7]',EU_INVOICE_ITEMS=$BDLY_new_values5,EU_INVOICE_FROM=$BDLY_new_values6,EU_COMMENTS=$BDLY_SRC_commentvalue,ULD_ID=((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP')) WHERE EU_ID='$BDLY_new_values[0]'";
        break;
      }
        case 4: {
            $EFU_DEPOSIT= $BDLY_new_values[3]==""?'null':"'$BDLY_new_values[3]'";
            $EFU_AMOUNT= $BDLY_new_values[4]==""?'null':"'$BDLY_new_values[4]'";
            $BDLY_new_values2=date('Y-m-d',strtotime($BDLY_new_values[2]));
        $updatequery = "UPDATE EXPENSE_FACILITY_USE SET EFU_INVOICE_DATE='$BDLY_new_values2',EFU_DEPOSIT=$EFU_DEPOSIT,EFU_AMOUNT=$EFU_AMOUNT,EFU_COMMENTS=$BDLY_SRC_commentvalue,ULD_ID=((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP')) WHERE EFU_ID='$BDLY_new_values[0]'";
        break;
      }
        case 5:
        {   $BDLY_new_values5=date('Y-m-d',strtotime($BDLY_new_values[5]));
            $BDLY_new_values6=date('Y-m-d',strtotime($BDLY_new_values[6]));
            $BDLY_new_values7=date('Y-m-d',strtotime($BDLY_new_values[7]));
            $updatequery = "UPDATE EXPENSE_DIGITAL_VOICE SET EDV_INVOICE_DATE='$BDLY_new_values5',EDV_FROM_PERIOD='$BDLY_new_values6',EDV_TO_PERIOD='$BDLY_new_values7',EDV_AMOUNT='$BDLY_new_values[8]',EDV_COMMENTS=$BDLY_SRC_commentvalue,ULD_ID=((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP')) WHERE EDV_ID='$BDLY_new_values[0]'";
        break;
        }
        case 6:
        {
            $BDLY_new_values3=date('Y-m-d',strtotime($BDLY_new_values[3]));
            $updatequery= "CALL SP_BIZDLY_PURCHASE_NEW_CARD_UPDATE('$BDLY_new_values[0]','$BDLY_new_values[2]','$BDLY_new_values3','$BDLY_new_values[4]',$BDLY_SRC_commentvalue,'$USERSTAMP',@UPDATE_FLAG)";
        break;
        }
        case 7:
        {$BDLY_new_values2=date('Y-m-d',strtotime($BDLY_new_values[2]));
            $updatequery = "UPDATE EXPENSE_MOVING_IN_AND_OUT SET ULD_ID=((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP')),EMIO_INVOICE_DATE='$BDLY_new_values2',EMIO_AMOUNT='$BDLY_new_values[3]',EMIO_COMMENTS=$BDLY_SRC_commentvalue WHERE EMIO_ID='$BDLY_new_values[0]'";
        break;
        }
        case 8:
        { $BDLY_new_values3=date('Y-m-d',strtotime($BDLY_new_values[3]));
            $BDLY_new_values4=date('Y-m-d',strtotime($BDLY_new_values[4]));
            $BDLY_new_values5=date('Y-m-d',strtotime($BDLY_new_values[5]));
            $updatequery= "UPDATE EXPENSE_CARPARK SET ECP_INVOICE_DATE='$BDLY_new_values3',ECP_FROM_PERIOD='$BDLY_new_values4',ECP_TO_PERIOD='$BDLY_new_values5',ECP_AMOUNT='$BDLY_new_values[6]',ECP_COMMENTS=$BDLY_SRC_commentvalue,ULD_ID=((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP')) WHERE ECP_PARK_ID='$BDLY_new_values[0]'";
        break;
        }
        case 9:
        { $BDLY_new_values3=date('Y-m-d',strtotime($BDLY_new_values[3]));
            $updatequery= "UPDATE EXPENSE_AIRCON_SERVICE SET ULD_ID=((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP')),EAS_DATE='$BDLY_new_values3',EAS_COMMENTS=$BDLY_SRC_commentvalue WHERE EAS_ID='$BDLY_new_values[0]'";
        break;
        }
        case 10:
        {$BDLY_new_values5=$this->db->escape_like_str($BDLY_new_values[5]);
            $updatequery = "UPDATE EXPENSE_PETTY_CASH SET EPC_INVOICE_ITEMS='$BDLY_new_values5',EPC_COMMENTS=$BDLY_SRC_commentvalue,ULD_ID=((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP')) WHERE EPC_ID='$BDLY_new_values[0]'";
        break;
        }
        case 11:
        {$BDLY_new_values2=date('Y-m-d',strtotime($BDLY_new_values[2]));
            $updatequery = "UPDATE EXPENSE_HOUSEKEEPING SET ULD_ID=((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP')),EHK_WORK_DATE='$BDLY_new_values2',EHK_DURATION='$BDLY_new_values[3]',EHK_DESCRIPTION=$BDLY_SRC_commentvalue WHERE EHK_ID='$BDLY_new_values[0]'";
        break;
        }
        case '12':{
            if($selectedSearchopt==198)
            {
                $updatequery = "UPDATE EXPENSE_HOUSEKEEPING_UNIT SET EHKU_UNIT_NO='$BDLY_new_values[1]' ,ULD_ID=((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP')) WHERE EHKU_ID='$BDLY_new_values[0]'";
        }
            else
            {
                $BIZDLY_hkpforperiodfrom=date('Y-m-01',strtotime($BDLY_new_values[3]));
                $BDLY_new_values4=date('Y-m-d',strtotime($BDLY_new_values[4]));
          $BIZDLY_unitno=explode(',',$BDLY_new_values[1]);
          $updatequery = "CALL SP_BIZDLY_HOUSEKEEPING_PAYMENT_UPDATE('$BDLY_new_values[0]','$BIZDLY_unitno[0]','$BIZDLY_hkpforperiodfrom','$BDLY_new_values4','$BDLY_new_values[2]',$BDLY_SRC_commentvalue,'$USERSTAMP',@UPDATE_FLAG)";
          }
            break;
        }
    }

    $this->db->query($updatequery);
    $BDLY_SRC_updateflag=1;
    if($expense=='6'||($expense=='12'&&$selectedSearchopt!=198) || $expense=='1' || $expense=='2')
    {
        $BDLY_SRC_updateflag=0;
        $updateflag_query="SELECT @UPDATE_FLAG as UPDATE_FLAG";
        $updateflag_rs=$this->db->query($updateflag_query);
        $updateflag=$updateflag_rs->row()->UPDATE_FLAG;
        $BDLY_SRC_updateflag=$updateflag;
    }
    return $BDLY_SRC_updateflag;
  }

    /*------------------------------------------WILL DELETE  DATA TABLE VALUE ROW BY ROW IN DB -------------------------------------------------*/
    public function  BDLY_SRC_DeleteRowData($BDLY_Delete_key,$selectedexpense,$USERSTAMP){
        $delquery='';
        $BDLY_SRC_tableid=["1"=>"52","2"=>"53","3"=>"51","4"=>"55","5"=>"54","6"=>"59","7"=>"57","8"=>"56","9"=>"58","10"=>"60","11"=>"61","12"=>"62"];
    if($selectedexpense==6)
    {
        $delquery=$this->db->query("CALL SP_BIZDLY_PURCHASE_NEW_CARD_DELETE('$BDLY_SRC_tableid[$selectedexpense]','$BDLY_Delete_key','$USERSTAMP',@DELETION_FLAG)");
        $BDLY_SRC_getresult= $this->db->query("SELECT @DELETION_FLAG as DELETION_FLAG");
        $BDLY_SRC_chkdelflag=$BDLY_SRC_getresult->row()->DELETION_FLAG;
    }
    else
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $BDLY_SRC_chkdelflag=$this->Mdl_eilib_common_function->DeleteRecord($BDLY_SRC_tableid[$selectedexpense],$BDLY_Delete_key,$USERSTAMP);
    }
    return $BDLY_SRC_chkdelflag;
  }
}
