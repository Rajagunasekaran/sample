<?php
Class Mdl_personal_daily_entry_search_update_delete extends CI_Model {

    public function common_data($ErrorMessage)
    {
        //EXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=22");
        $this->db->order_by("ECN_DATA", "asc");
        $expensetypeqry = $this->db->get();
        $expensetype=$expensetypeqry->result();

        // PERSONALEXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=24");
        $this->db->order_by("ECN_DATA", "asc");
        $perexpypeqry = $this->db->get();
        $perexpype=$perexpypeqry->result();

        //BABY EXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=25");
        $this->db->order_by("ECN_DATA", "asc");
        $babyexptypeqry = $this->db->get();
        $babyexptype=$babyexptypeqry->result();

        //CAR EXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=21");
        $this->db->order_by("ECN_DATA", "asc");
        $carexptypeqry = $this->db->get();
        $carexptype=$carexptypeqry->result();

        //AUTOCOMPLETE FUNCTION FOR INVOICE FROM
        $this->db->select("EP_INVOICE_FROM");
        $this->db->from("EXPENSE_PERSONAL");
        $invoicefrom = $this->db->get();
        $personalinvoicefrom=$invoicefrom->result();

        return $arrayvalues=array($expensetype,$perexpype,$babyexptype,$carexptype,$ErrorMessage,$personalinvoicefrom);
    }
    // CAR EXPENSE INSERT FUNCTION
    public function carexpenseinsert($USERSTAMP){

        $invdate=$_POST['PCE_tb_invdate'];
        $invdate=date('Y-m-d',strtotime($invdate));
        $ecnid=$_POST['PCE_lb_ctry'];
        $ec_amount=$_POST['PCE_tb_invamt'];
        $ec_invoiceitesm=$this->db->escape_like_str($_POST['PCE_ta_invitems']);
        $ec_invoicefrom=$this->db->escape_like_str($_POST['PCE_tb_invfrom']);
        $ec_comments=$this->db->escape_like_str($_POST['PCE_ta_comments']);

        $insertquery = "INSERT INTO EXPENSE_CAR(ULD_ID,ECN_ID,EC_INVOICE_DATE,EC_AMOUNT,EC_INVOICE_ITEMS,EC_INVOICE_FROM,EC_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$ecnid','$invdate','$ec_amount','$ec_invoiceitesm','$ec_invoicefrom','$ec_comments')";

        $this->db->query($insertquery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    // CAR LOAN INSERT FUNCTION
    public function carloaninsert($USERSTAMP){

        $paiddate=$_POST['PCLE_tb_paiddte'];
        $paiddate=date('Y-m-d',strtotime($paiddate));
        $fromperiod=$_POST['PCLE_tb_fromperiod'];
        $fromperiod=date('Y-m-d',strtotime($fromperiod));
        $toperiod=$_POST['PCLE_ta_toperiod'];
        $toperiod=date('Y-m-d',strtotime($toperiod));
        $invoiceamt=$_POST['PCLE_tb_invamt'];
        $invoice_comments=$this->db->escape_like_str($_POST['PCLE_ta_comments']);

        $insertquery = "INSERT INTO EXPENSE_CAR_LOAN(ULD_ID,ECL_PAID_DATE,ECL_FROM_PERIOD,ECL_TO_PERIOD,ECL_AMOUNT,ECL_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$paiddate','$fromperiod','$toperiod','$invoiceamt','$invoice_comments')";

        $this->db->query($insertquery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    //BABY AND PERSONAL SAVE FUNCTION
    public function babypersonalinsert($USERSTAMP){
        $PDLY_INPUT_typelistdb=$_POST['PE_lb_expensetype'];
        $PDLY_INPUT_expenselist=$_POST['PDLY_INPUT_lb_category'];
        $PDLY_INPUT_invoiceDate=$_POST['PDLY_INPUT_db_invdate'];
        $PDLY_INPUT_in_items=$_POST['PDLY_INPUT_ta_invitem'];
        $PDLY_INPUT_invoiceAmount=$_POST['PDLY_INPUT_tb_incamtrp'];
        $PDLY_INPUT_inv_from=$_POST['PDLY_INPUT_tb_invfrom'];
        $PDLY_INPUT_comments=$_POST['PDLY_INPUT_tb_comments'];
        $PDLY_INPUT_comments_split='';$PDLY_INPUT_invfrom_split='';$PDLY_INPUT_invitem_split='';
        $PDLY_INPUT_amountsplit='';$PDLY_INPUT_datesplit='';$PDLY_INPUT_ctrylist='';

         if((is_array($PDLY_INPUT_inv_from))==true){
         for($i=0;$i<count($PDLY_INPUT_inv_from);$i++)
         {
          if($PDLY_INPUT_comments[$i]=='')
          {
              if($i==0)
                  $PDLY_INPUT_comments_split.=' ';
                else
                    $PDLY_INPUT_comments_split.='^^'.' ';
          }
          else
          {
              if($i==0){
                  $PDLY_INPUT_comments_split.=$this->db->escape_like_str($PDLY_INPUT_comments[$i]);
              }
              else{
                  $PDLY_INPUT_comments_split.='^^'.$this->db->escape_like_str($PDLY_INPUT_comments[$i]);
              }
          }
        if($i==0)
        {
          $PDLY_INPUT_invitem_split.=$this->db->escape_like_str($PDLY_INPUT_in_items[$i]);
          $PDLY_INPUT_invfrom_split.=$this->db->escape_like_str($PDLY_INPUT_inv_from[$i]);
          $PDLY_INPUT_amountsplit=$PDLY_INPUT_invoiceAmount[$i];
          $PDLY_INPUT_datesplit=date('Y-m-d',strtotime($PDLY_INPUT_invoiceDate[$i]));
          $PDLY_INPUT_ctrylist=$PDLY_INPUT_expenselist[$i];
        }
        else
        {
          $PDLY_INPUT_invitem_split.='^^'.$this->db->escape_like_str($PDLY_INPUT_in_items[$i]);
          $PDLY_INPUT_invfrom_split.='^^'.$this->db->escape_like_str($PDLY_INPUT_inv_from[$i]);
          $PDLY_INPUT_amountsplit.=",".$PDLY_INPUT_invoiceAmount[$i];
          $PDLY_INPUT_datesplit.=",".date('Y-m-d',strtotime($PDLY_INPUT_invoiceDate[$i]));
          $PDLY_INPUT_ctrylist.=",".$PDLY_INPUT_expenselist[$i];
        }
        }
        }
        else
        {
            if($PDLY_INPUT_comments=='')
                $PDLY_INPUT_comments_split='';
            else
            {
                $PDLY_INPUT_comments_split=$this->db->escape_like_str($PDLY_INPUT_comments);
                $PDLY_INPUT_invfrom_split=$this->db->escape_like_str($PDLY_INPUT_inv_from);
                $PDLY_INPUT_invitem_split=$this->db->escape_like_str($PDLY_INPUT_in_items);
                $PDLY_INPUT_datesplit=date('Y-m-d',strtotime($PDLY_INPUT_invoiceDate));
                $PDLY_INPUT_amountsplit=$PDLY_INPUT_invoiceAmount;
                $PDLY_INPUT_ctrylist=$PDLY_INPUT_expenselist;

            }
        }
        if($PDLY_INPUT_typelistdb==36)
        {
            $PDLY_INPUT_callquery = "CALL SP_PERSONALBABY_INSERT('$PDLY_INPUT_ctrylist','$PDLY_INPUT_datesplit','$PDLY_INPUT_amountsplit','$PDLY_INPUT_invitem_split','$PDLY_INPUT_invfrom_split','$PDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)";
        }
        elseif($PDLY_INPUT_typelistdb==37)
        {
            $PDLY_INPUT_callquery = "CALL SP_PERSONAL_INSERT('$PDLY_INPUT_ctrylist','$PDLY_INPUT_datesplit','$PDLY_INPUT_amountsplit','$PDLY_INPUT_invitem_split','$PDLY_INPUT_invfrom_split','$PDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)";
        }
        $this->db->query($PDLY_INPUT_callquery);
        $PDLY_INPUT_rs_flag = 'SELECT @FLAG_INSERT as FLAG_INSERT';
        $query = $this->db->query($PDLY_INPUT_rs_flag);
        return $query->result();

    }

//UPDATE FORM FETCH DATA
    public function srchupdte_common_data($ErrorMessage)
    {
        //CAR EXPENSE  CATEGORY  DATA LOADING//
        $this->db->distinct();
        $this->db->select("ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION EXPCONFIG");
        $this->db->join('EXPENSE_CAR EXPCAR','EXPCONFIG.ECN_ID=EXPCAR.ECN_ID');
        $this->db->order_by("ECN_DATA", "asc");
        $PDLY_SEARCH_carexpensecategory_selectquery = $this->db->get();
        $PDLY_SEARCH_carexpensecategArray=$PDLY_SEARCH_carexpensecategory_selectquery->result();

        //BABY  CATEGORY  DATA LOADING//
        $this->db->distinct();
        $this->db->select("ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION EXPCONFIG");
        $this->db->join('EXPENSE_BABY EXPBABY',"EXPCONFIG.ECN_ID=EXPBABY.ECN_ID");
        $this->db->order_by("ECN_DATA", "asc");
        $PDLY_SEARCH_babyexpensecategory_selectquery = $this->db->get();
        $PDLY_SEARCH_babyexpensecategArray=$PDLY_SEARCH_babyexpensecategory_selectquery->result();

        ////PERSONAL  CATEGORY  DATA LOADING//
        $this->db->distinct();
        $this->db->select("ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION EXPCONFIG");
        $this->db->join('EXPENSE_PERSONAL EXPPERSONAL',"EXPCONFIG.ECN_ID=EXPPERSONAL.ECN_ID");
        $this->db->order_by("ECN_DATA", "asc");
        $PDLY_SEARCH_personalexpensecategory_selectquery = $this->db->get();
        $PDLY_SEARCH_personalexpensecategArray=$PDLY_SEARCH_personalexpensecategory_selectquery->result();

        $this->db->select("EB_ID");
        $this->db->from("EXPENSE_BABY");
        $PDLY_SEARCH_expensebabyquery = $this->db->get();
        $PDLY_SEARCH_expensebabyArray=$PDLY_SEARCH_expensebabyquery->result();

        $this->db->select("ECL_ID");
        $this->db->from("EXPENSE_CAR_LOAN");
        $PDLY_SEARCH_expensecarloanquery = $this->db->get();
        $PDLY_SEARCH_expensecarloanArray=$PDLY_SEARCH_expensecarloanquery->result();

        $this->db->select("EC_ID");
        $this->db->from("EXPENSE_CAR");
        $PDLY_SEARCH_expensecarquery = $this->db->get();
        $PDLY_SEARCH_expensecarArray=$PDLY_SEARCH_expensecarquery->result();

        $this->db->select("EP_ID,EP_INVOICE_FROM");
        $this->db->from("EXPENSE_PERSONAL");
        $PDLY_SEARCH_expensepersonalquery = $this->db->get();
        $PDLY_SEARCH_expensepersonalArray=$PDLY_SEARCH_expensepersonalquery->result();

        $this->db->distinct();
        $this->db->select("ECN_ID, ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where('ECN_ID BETWEEN 51 AND 73');
        $this->db->or_where('CGN_ID=22');
        $this->db->order_by("ECN_ID", "asc");
        $PDLY_SEARCH_selectTypeofexpensee = $this->db->get();
        $PDLY_SEARCH_personalexp_Array=$PDLY_SEARCH_selectTypeofexpensee->result();

        // PERSONALEXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=24");
        $this->db->order_by("ECN_DATA", "asc");
        $perexpypeqry = $this->db->get();
        $perexpype=$perexpypeqry->result();

        //BABY EXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=25");
        $this->db->order_by("ECN_DATA", "asc");
        $babyexptypeqry = $this->db->get();
        $babyexptype=$babyexptypeqry->result();

        //CAR EXPENSE TYPE
        $this->db->select("ECN_ID,ECN_DATA");
        $this->db->from("EXPENSE_CONFIGURATION");
        $this->db->where("CGN_ID=21");
        $this->db->order_by("ECN_DATA", "asc");
        $carexptypeqry = $this->db->get();
        $carexptype=$carexptypeqry->result();

        //AUTOCOMPLETE FUNCTION FOR INVOICE FROM
        $this->db->select("EP_INVOICE_FROM");
        $this->db->from("EXPENSE_PERSONAL");
        $invoicefrom = $this->db->get();
        $personalinvoicefrom=$invoicefrom->result();

        return $arrayvalues=array($PDLY_SEARCH_expensepersonalArray,$PDLY_SEARCH_expensebabyArray,$PDLY_SEARCH_expensecarArray,$PDLY_SEARCH_expensecarloanArray,$PDLY_SEARCH_babyexpensecategArray,$PDLY_SEARCH_carexpensecategArray,$PDLY_SEARCH_personalexpensecategArray,$ErrorMessage,$PDLY_SEARCH_personalexp_Array,$babyexptype,$carexptype,$perexpype,$personalinvoicefrom);
    }
    public function PDLY_SEARCH_lb_babysearchoptionvalue($categorydata){
        $categoryoption=$categorydata;
        if($categoryoption==52)
        {
            $this->db->distinct();
            $this->db->select("ECN_DATA");
            $this->db->from("EXPENSE_CONFIGURATION EXPCONFIG");
            $this->db->join('EXPENSE_BABY EXPBABY',"EXPCONFIG.ECN_ID=EXPBABY.ECN_ID");
            $this->db->order_by("ECN_DATA", "asc");
            $PDLY_SEARCH_babycategory = $this->db->get();
            $PDLY_SEARCH_babyexpensecategArray=$PDLY_SEARCH_babycategory->result();
        }
        if($categoryoption==58)
        {
            $this->db->distinct();
            $this->db->select("ECN_DATA");
            $this->db->from("EXPENSE_CONFIGURATION EXPCONFIG");
            $this->db->join('EXPENSE_CAR EXPCAR',"EXPCONFIG.ECN_ID=EXPCAR.ECN_ID");
            $this->db->order_by("ECN_DATA", "asc");
            $PDLY_SEARCH_babycategory = $this->db->get();
            $PDLY_SEARCH_babyexpensecategArray=$PDLY_SEARCH_babycategory->result();
        }
        if($categoryoption==69)
        {
            $this->db->distinct();
            $this->db->select("ECN_DATA");
            $this->db->from("EXPENSE_CONFIGURATION EXPCONFIG");
            $this->db->join('EXPENSE_PERSONAL EXPPERSONAL',"EXPCONFIG.ECN_ID=EXPPERSONAL.ECN_ID");
            $this->db->order_by("ECN_DATA", "asc");
            $PDLY_SEARCH_babycategory = $this->db->get();
            $PDLY_SEARCH_babyexpensecategArray=$PDLY_SEARCH_babycategory->result();
        }
        return $PDLY_SEARCH_babyexpensecategArray;
    }
    public function PDLY_SEARCH_lb_comments($PDLY_SEARCH_lb_typelistvalue,$PDLY_SEARCH_lb_getstartvaluevalue,$PDLY_SEARCH_lb_getendvaluevalue){
        $PDLY_SEARCH_lb=$PDLY_SEARCH_lb_typelistvalue;
        $startdate=$PDLY_SEARCH_lb_getstartvaluevalue;
        $enddate=$PDLY_SEARCH_lb_getendvaluevalue;
        if($PDLY_SEARCH_lb==36)
        {
            $this->db->distinct();
            $this->db->select("EB_COMMENTS");
            $this->db->from("EXPENSE_BABY");
            $this->db->where('EB_INVOICE_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
            $this->db->where('EB_COMMENTS IS NOT NULL');
            $PDLY_SEARCH_expbabycmtquery = $this->db->get();
            $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
        }
        if($PDLY_SEARCH_lb==35)
        {
            $this->db->distinct();
            $this->db->select("EC_COMMENTS");
            $this->db->from("EXPENSE_CAR");
            $this->db->where('EC_INVOICE_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
            $this->db->where('EC_COMMENTS IS NOT NULL');
            $PDLY_SEARCH_expbabycmtquery = $this->db->get();
            $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
        }
        if($PDLY_SEARCH_lb==37)
        {
            $this->db->distinct();
            $this->db->select("EP_COMMENTS");
            $this->db->from("EXPENSE_PERSONAL");
            $this->db->where('EP_INVOICE_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
            $this->db->where('EP_COMMENTS IS NOT NULL');
            $PDLY_SEARCH_expbabycmtquery = $this->db->get();
            $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
        }
        if($PDLY_SEARCH_lb==38)
        {
            $this->db->distinct();
            $this->db->select("ECL_COMMENTS");
            $this->db->from("EXPENSE_CAR_LOAN");
            $this->db->where('ECL_PAID_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
            $this->db->where('ECL_COMMENTS IS NOT NULL');
            $PDLY_SEARCH_expbabycmtquery = $this->db->get();
            $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
        }
        return $dataArray;
    }
    public function PDLY_SEARCH_lb_invoicefrom($PDLY_SEARCH_lb_typelistvalue,$PDLY_SEARCH_lb_getstartvaluevalue,$PDLY_SEARCH_lb_getendvaluevalue,$PDLY_SEARCH_lb_babysearchoptionvalue){
        $PDLY_SEARCH_lb=$PDLY_SEARCH_lb_typelistvalue;
        $$PDLY_SEARCH_lb_babysearchoptionvalue=$PDLY_SEARCH_lb_babysearchoptionvalue;
        $startdate=$PDLY_SEARCH_lb_getstartvaluevalue;
        $enddate=$PDLY_SEARCH_lb_getendvaluevalue;
        if($PDLY_SEARCH_lb==36)
        {
            if($PDLY_SEARCH_lb_babysearchoptionvalue==55)
            {
                $this->db->distinct();
                $this->db->select("EB_INVOICE_FROM");
                $this->db->from("EXPENSE_BABY");
                $this->db->where('EB_INVOICE_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
                $this->db->where('EB_INVOICE_FROM IS NOT NULL');
                $PDLY_SEARCH_expbabycmtquery = $this->db->get();
                $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
            }
        }
        if($PDLY_SEARCH_lb==35)
        {
            if($PDLY_SEARCH_lb_babysearchoptionvalue==61)
            {
                $this->db->distinct();
                $this->db->select("EC_INVOICE_FROM");
                $this->db->from("EXPENSE_CAR");
                $this->db->where('EC_INVOICE_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
                $this->db->where('EC_INVOICE_FROM IS NOT NULL');
                $PDLY_SEARCH_expbabycmtquery = $this->db->get();
                $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
            }
        }
        if($PDLY_SEARCH_lb==37)
        {
            if($PDLY_SEARCH_lb_babysearchoptionvalue==72)
            {
                $this->db->distinct();
                $this->db->select("EP_INVOICE_FROM");
                $this->db->from("EXPENSE_PERSONAL");
                $this->db->where('EP_INVOICE_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
                $this->db->where('EP_INVOICE_FROM IS NOT NULL');
                $PDLY_SEARCH_expbabycmtquery = $this->db->get();
                $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
            }
        }

        return $dataArray;
    }
    public function PDLY_SEARCH_lb_invoiceitems($PDLY_SEARCH_lb_typelistvalue,$PDLY_SEARCH_lb_getstartvaluevalue,$PDLY_SEARCH_lb_getendvaluevalue,$PDLY_SEARCH_lb_babysearchoptionvalue){
        $PDLY_SEARCH_lb=$PDLY_SEARCH_lb_typelistvalue;
        $$PDLY_SEARCH_lb_babysearchoptionvalue=$PDLY_SEARCH_lb_babysearchoptionvalue;
        $startdate=$PDLY_SEARCH_lb_getstartvaluevalue;
        $enddate=$PDLY_SEARCH_lb_getendvaluevalue;
        if($PDLY_SEARCH_lb==36)
        {
            if($PDLY_SEARCH_lb_babysearchoptionvalue==54)
            {
                $this->db->distinct();
                $this->db->select("EB_INVOICE_ITEMS");
                $this->db->from("EXPENSE_BABY");
                $this->db->where('EB_INVOICE_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
                $this->db->where('EB_INVOICE_ITEMS IS NOT NULL');
                $PDLY_SEARCH_expbabycmtquery = $this->db->get();
                $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
            }
        }
        if($PDLY_SEARCH_lb==35)
        {
            if($PDLY_SEARCH_lb_babysearchoptionvalue==60)
            {
                $this->db->distinct();
                $this->db->select("EC_INVOICE_ITEMS");
                $this->db->from("EXPENSE_CAR");
                $this->db->where('EC_INVOICE_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
                $this->db->where('EC_INVOICE_ITEMS IS NOT NULL');
                $PDLY_SEARCH_expbabycmtquery = $this->db->get();
                $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
            }
        }
        if($PDLY_SEARCH_lb==37)
        {
            if($PDLY_SEARCH_lb_babysearchoptionvalue==71)
            {
                $this->db->distinct();
                $this->db->select("EP_INVOICE_ITEMS");
                $this->db->from("EXPENSE_PERSONAL");
                $this->db->where('EP_INVOICE_DATE BETWEEN "'.$startdate.'" AND "'.$enddate.'"');
                $this->db->where('EP_INVOICE_ITEMS IS NOT NULL');
                $PDLY_SEARCH_expbabycmtquery = $this->db->get();
                $dataArray=$PDLY_SEARCH_expbabycmtquery->result();
            }
        }

        return $dataArray;
    }

    public function PDLY_SEARCH_searchbybaby($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory,$timeZoneFormat)
    {
        if($PDLY_SEARCH_typelistvalue==36)
        {

            $PDLY_SEARCH_selectquery[56]=$this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_COMMENTS="'.$PDLY_SEARCH_searchcomments.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[52] =$this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_DATA="'.$PDLY_SEARCH_babycategory.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID)ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[51] = $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_AMOUNT BETWEEN "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[53] = $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_ID=EXPBABY.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[55]= $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID,  DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_INVOICE_FROM="'.$PDLY_SEARCH_invfromcomt.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[54] = $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T")  AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_INVOICE_ITEMS="'.$PDLY_SEARCH_invitemcom.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
        }
        if($PDLY_SEARCH_typelistvalue==35)
        {
            $PDLY_SEARCH_selectquery[62] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_COMMENTS ="'.$PDLY_SEARCH_searchcomments.'") AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[58] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_DATA="'.$PDLY_SEARCH_babycategory.'") AND (EXPCONFIG.ECN_ID=EXPCAR.ECN_ID)ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[57] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" )AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_AMOUNT BETWEEN  "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'") AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[59] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_ID=EXPCAR.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[61] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_INVOICE_FROM="'.$PDLY_SEARCH_invfromcomt.'") AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[60] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_INVOICE_ITEMS="'.$PDLY_SEARCH_invitemcom.'")AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
        }
        if($PDLY_SEARCH_typelistvalue==37)
        {
            $PDLY_SEARCH_selectquery[73] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_COMMENTS="'.$PDLY_SEARCH_searchcomments.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[69] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_DATA="'.$PDLY_SEARCH_babycategory.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID)ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[68] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_AMOUNT BETWEEN "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[70] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_ID=EXPPERSONAL.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[72] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_INVOICE_FROM="'.$PDLY_SEARCH_invfromcomt.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
            $PDLY_SEARCH_selectquery[71] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_INVOICE_ITEMS="'.$PDLY_SEARCH_invitemcom.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
        }
        if($PDLY_SEARCH_typelistvalue==38)
        {
            $PDLY_SEARCH_selectquery[65] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_PAID_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (ECL_AMOUNT BETWEEN "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'")ORDER BY ECL_PAID_DATE ASC');
            $PDLY_SEARCH_selectquery[67] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_PAID_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (ECL_COMMENTS="'.$PDLY_SEARCH_searchcomments.'")ORDER BY ECL_PAID_DATE ASC');
            $PDLY_SEARCH_selectquery[63] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_PAID_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") ORDER BY ECL_PAID_DATE ASC');
            $PDLY_SEARCH_selectquery[66] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_FROM_PERIOD BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") ORDER BY ECL_PAID_DATE ASC');
            $PDLY_SEARCH_selectquery[64] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,'.$timeZoneFormat.'), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_TO_PERIOD BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") ORDER BY ECL_PAID_DATE ASC');
        }

        return $PDLY_SEARCH_selectquery[$PDLY_SEARCH_babysearchoption]->result();
    }
    // EXPENSE BABY UPDATE PART
    public  function expensebabyupdate($ebid,$babycategory,$babyinvdate,$babyinamt,$babyinfromt,$babyinvitem,$babycomment,$USERSTAMP)
    {
        $updatequery = "UPDATE EXPENSE_BABY SET EB_INVOICE_DATE='$babyinvdate',EB_AMOUNT='$babyinamt',EB_INVOICE_ITEMS='$babyinvitem',EB_INVOICE_FROM='$babyinfromt',EB_COMMENTS='$babycomment',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),ECN_ID=(SELECT ECN_ID FROM EXPENSE_CONFIGURATION WHERE ECN_DATA='$babycategory' AND CGN_ID=25) WHERE EB_ID='$ebid'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    // EXPENSE CAR UPDATE PART
    public  function expensecarupdate($ecid,$carcategory,$carinvdate,$carinamt,$carinfromt,$carinvitem,$carcomment,$USERSTAMP)
    {

        $updatequery = "UPDATE EXPENSE_CAR SET EC_INVOICE_DATE='$carinvdate',EC_AMOUNT='$carinamt',EC_INVOICE_ITEMS='$carinvitem',EC_INVOICE_FROM='$carinfromt',EC_COMMENTS='$carcomment',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),ECN_ID=(SELECT ECN_ID FROM EXPENSE_CONFIGURATION WHERE ECN_DATA='$carcategory' AND CGN_ID=21) WHERE EC_ID='$ecid'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    // EXPENSE PERSONAL UPDATE PART
    public  function expensepersonalupdate($epid,$personalcategory,$personalinvdate,$personalinamt,$personalinfromt,$personalinvitem,$personalcomment,$USERSTAMP)
    {
        $updatequery = "UPDATE EXPENSE_PERSONAL SET EP_INVOICE_DATE='$personalinvdate',EP_AMOUNT='$personalinamt',EP_INVOICE_ITEMS='$personalinvitem',EP_INVOICE_FROM='$personalinfromt',EP_COMMENTS='$personalcomment',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),ECN_ID=(SELECT ECN_ID FROM EXPENSE_CONFIGURATION WHERE ECN_DATA='$personalcategory' AND CGN_ID=24) WHERE EP_ID='$epid'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    // EXPENSE CARLOAN UPDATE PART
    public  function expensecarloanupdate($eclid,$eclpaiddate,$eclfromperiod,$ecltopaid,$eclamount,$eclcomments,$USERSTAMP)
    {
        if(strtotime($eclfromperiod)>strtotime($eclpaiddate))
        {
            $eclfromperiod=$eclpaiddate;
        }
        else{
            $eclfromperiod=$eclfromperiod;
        }
        if(strtotime($ecltopaid)>strtotime($eclpaiddate))
        {
            $ecltopaid=$eclpaiddate;
        }
        else{
            $ecltopaid=$ecltopaid;
        }
        $updatequery = "UPDATE EXPENSE_CAR_LOAN SET ECL_PAID_DATE='$eclpaiddate',ECL_FROM_PERIOD='$eclfromperiod',ECL_TO_PERIOD='$ecltopaid',ECL_AMOUNT='$eclamount',ECL_COMMENTS='$eclcomments',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP') WHERE ECL_ID='$eclid'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    public function deleteoption($PDLY_rowid,$startdate,$enddate,$PDLY_SEARCH_lb_typelistvalue,$PDLY_SEARCH_lb_babysearchoptionvalue,$USERSTAMP)
    {
        $PDLY_SEARCH_twodimen=array(36=>['EXPENSE_BABY',66],37=>['EXPENSE_PERSONAL',64],35=>['EXPENSE_CAR',65],38=>['EXPENSE_CAR_LOAN',67]);
        $tableid=$PDLY_SEARCH_twodimen[$PDLY_SEARCH_lb_typelistvalue][1];
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $deleteflag=$this->Mdl_eilib_common_function->DeleteRecord($tableid,$PDLY_rowid,$USERSTAMP);
        return $deleteflag;
    }

}