<?php
class Mdl_staff_daily_entry_search_update_delete extends CI_Model{
    public function Initial_data($ErrorMessage)
    {
        $this->db->select('ECN_ID,ECN_DATA');
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('CGN_ID IN (26,23)');
        $this->db->order_by('ECN_ID');
        $query = $this->db->get();
        $result1 = $query->result();
        $this->db->select('DISTINCT CONCAT(ED.EMP_FIRST_NAME," ",ED.EMP_LAST_NAME) AS EMPLOYEE_NAME,ED.EMP_ID,EDSS.EDSS_ID,EDSS.EDSS_CPF_NUMBER,EDSS.EDSS_LEVY_AMOUNT,EDSS.EDSS_SALARY_AMOUNT,EDSS.EDSS_CPF_AMOUNT',FALSE);
        $this->db->from('EMPLOYEE_DETAILS ED,EXPENSE_DETAIL_STAFF_SALARY EDSS');
        $this->db->where('ED.EMP_ID=EDSS.EMP_ID');
        $query = $this->db->get();
        $result2 = $query->result();
        $this->db->select('EMP_ID');
        $this->db->from('EMPLOYEE_DETAILS');
        $query = $this->db->get();
        $result3 = $query->result();
        return $result[]=array($result1,$result2,$result3,$ErrorMessage);
    }
    //FUNCTION FOR SAVE PART
    public function STDLY_INPUT_insert($USERSTAMP){
        $STDLY_INPUT_lbtypeofexpense=$_POST['staffdly_lb_type'];
        if($STDLY_INPUT_lbtypeofexpense==39)
        {
            $STDLY_INPUT_commision_date=$_POST['staffdly_invdate'];
            $STDLY_INPUT_commision_date = date('Y-m-d',strtotime($STDLY_INPUT_commision_date));
            $STDLY_INPUT_commision_amount=$_POST['staffdly_tb_comisnamt'];
            $STDLY_INPUT_comments=$_POST['staffdly_ta_agentcomments'];
            if($STDLY_INPUT_comments==''){
                $STDLY_INPUT_comments='null';
            }
            else{
                $STDLY_INPUT_comments="'$STDLY_INPUT_comments'";
            }
            $insertquery = "INSERT INTO EXPENSE_AGENT(ULD_ID,EA_DATE,EA_COMM_AMOUNT,EA_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$STDLY_INPUT_commision_date','$STDLY_INPUT_commision_amount',$STDLY_INPUT_comments)";
            $this->db->query($insertquery);
            if ($this->db->affected_rows() > 0) {
                return 1;
            }
            else {
                return 0;
            }
        }
       else if($STDLY_INPUT_lbtypeofexpense==40){
            $STDLY_INPUT_paid_date=$_POST['staffdly_paiddate'];
            $STDLY_INPUT_paid_date = date('Y-m-d',strtotime($STDLY_INPUT_paid_date));
            $STDLY_INPUT_from_period=$_POST['staffdly_fromdate'];
            $STDLY_INPUT_from_period = date('Y-m-d',strtotime($STDLY_INPUT_from_period));
            $STDLY_INPUT_to_period=$_POST['staffdly_todate'];
            $STDLY_INPUT_to_period = date('Y-m-d',strtotime($STDLY_INPUT_to_period));
            $STDLY_INPUT_cpfamount = $_POST['staffdly_tb_newcpfamt'];
            $salarycpfamtoptradio=(isset($_POST['salarycpfamtopt']));
            $salarysalaryoptradio=(isset($_POST['salarysalaryopt']));
            $STDLY_INPUT_levyradio =(isset($_POST["salarylevyamtopt"]));
            $STDLY_INPUT_hidencpfamount= $_POST['staffdly_tb_curcpfamt'];
            if($salarycpfamtoptradio==true)
            {
                if($STDLY_INPUT_cpfamount=='')
                {
                    $STDLY_INPUT_cpfamount="'$STDLY_INPUT_cpfamount'";
                }
                else
                {
                    $STDLY_INPUT_cpfamount="'$STDLY_INPUT_hidencpfamount'";
                }
            }
            else
            {
                $STDLY_INPUT_cpfamount='null';
            }
            $STDLY_INPUT_levyamount = $_POST['staffdly_tb_newlevyamt'];
            $STDLY_INPUT_hidenlevyamount = $_POST['staffdly_tb_curlevyamt'];
            if($STDLY_INPUT_levyradio==true)
            {
                if($STDLY_INPUT_levyamount!='' )
                {
                    $STDLY_INPUT_levyamount="'$STDLY_INPUT_levyamount'";
                }
                else
                {
                    $STDLY_INPUT_levyamount="'$STDLY_INPUT_hidenlevyamount'";
                }
            }
            else
            {
                $STDLY_INPUT_levyamount='null';
            }
            $STDLY_INPUT_salaryamount = $_POST['staffdly_tb_newsalary'];
            $STDLY_INPUT_hidensalaryamount = $_POST['staffdly_tb_cursalary'];
            if($salarysalaryoptradio==true) {
                if($STDLY_INPUT_salaryamount!='')
                {
                    $STDLY_INPUT_salaryamount="'$STDLY_INPUT_salaryamount'";
                }
                else {
                    $STDLY_INPUT_salaryamount = "'$STDLY_INPUT_hidensalaryamount'";
                }
            }
            else
            {
                $STDLY_INPUT_salaryamount='null';
            }
            $STDLY_INPUT_comments=$_POST['staffdly_ta_salarycomments'];
            if($STDLY_INPUT_comments==''){
                $STDLY_INPUT_comments='null';
            }
            else{
                $STDLY_INPUT_comments="'$STDLY_INPUT_comments'";
            }
            $STDLY_INPUT_radio_employee=(isset($_POST["staffdly_rd_employee"]));
            if($STDLY_INPUT_radio_employee=='' || $STDLY_INPUT_radio_employee=='undefined')
            {
                $STDLY_INPUT_edssid=$_POST['staffdly_hidden_edssid'];
            }
            else{
                $STDLY_INPUT_edssid=$STDLY_INPUT_radio_employee;
            }
            $insertquery = "CALL SP_STAFFDLY_STAFF_SALARY_INSERT('$STDLY_INPUT_edssid','$STDLY_INPUT_paid_date','$STDLY_INPUT_from_period','$STDLY_INPUT_to_period','$STDLY_INPUT_cpfamount',$STDLY_INPUT_levyamount,$STDLY_INPUT_salaryamount,$STDLY_INPUT_comments,'$USERSTAMP',@SUCCESS_MSG)";
            $query = $this->db->query($insertquery);
            $successflag="SELECT @SUCCESS_MSG as SUCCESS_MSG";
            $successflagresult=$this->db->query($successflag);
            $flagresult=$successflagresult->row()->SUCCESS_MSG;
            return  $flagresult;
       }
    }
    //FUNCTION FOR SAVE staff PART
    public function STDLY_INPUT_insertstaff($USERSTAMP){
        $STDLY_INPUT_expenselist=$_POST['STDLY_INPUT_lb_category'];
        $STDLY_INPUT_invoiceDate=$_POST['STDLY_INPUT_db_invdate'];
        $STDLY_INPUT_in_items=$_POST['STDLY_INPUT_ta_invitem'];
        $STDLY_INPUT_invoiceAmount=$_POST['STDLY_INPUT_lb_incamtrp'];
        $PDLY_INPUT_inv_from=$_POST['STDLY_INPUT_tb_invfrom'];
        $STDLY_INPUT_comments=$_POST['STDLY_INPUT_tb_comments'];
        $STDLY_INPUT_lbtypeofexpense = $_POST['staffdly_lb_type'];
        $STDLY_INPUT_comments_split='';$STDLY_INPUT_invfrom_split='';$STDLY_INPUT_invitem_split='';
        $STDLY_INPUT_ctrylist=''; $STDLY_INPUT_amountsplit='';$STDLY_INPUT_datesplit='';
        if((is_array($PDLY_INPUT_inv_from))==true){
            for($i=0;$i<count($PDLY_INPUT_inv_from);$i++){
                  if($STDLY_INPUT_comments[$i] == ' '){
                      if($i==0)
                          $STDLY_INPUT_comments_split .=' ';
                           else
                            $STDLY_INPUT_comments_split .='^^'.' ';
                  }
                  else{
                      if($i==0){
                          $STDLY_INPUT_comments_split.=$this->db->escape_like_str($STDLY_INPUT_comments[$i]);
                      }
                      else{
                          $STDLY_INPUT_comments_split.='^^'.$this->db->escape_like_str($STDLY_INPUT_comments[$i]);
                      }
                  }
                if($i==0){
                    $STDLY_INPUT_invitem_split.=$this->db->escape_like_str($STDLY_INPUT_in_items[$i]);
                    $STDLY_INPUT_invfrom_split.=$this->db->escape_like_str($PDLY_INPUT_inv_from[$i]);
                    $STDLY_INPUT_datesplit=date('Y-m-d',strtotime($STDLY_INPUT_invoiceDate[$i]));
                    $STDLY_INPUT_ctrylist=$STDLY_INPUT_expenselist[$i];
                    $STDLY_INPUT_amountsplit=$STDLY_INPUT_invoiceAmount[$i];
                }
                else {
                    $STDLY_INPUT_invitem_split .= '^^' . $this->db->escape_like_str($STDLY_INPUT_in_items[$i]);
                    $STDLY_INPUT_invfrom_split .= '^^' . $this->db->escape_like_str($PDLY_INPUT_inv_from[$i]);
                    $STDLY_INPUT_datesplit .= "," . date('Y-m-d', strtotime($STDLY_INPUT_invoiceDate[$i]));
                    $STDLY_INPUT_ctrylist .= "," . $STDLY_INPUT_expenselist[$i];
                    $STDLY_INPUT_amountsplit .= "," . $STDLY_INPUT_invoiceAmount[$i];
                }
            }
        }
        else
        {
            if($STDLY_INPUT_comments==''){
                $STDLY_INPUT_comments_split='';}
            else{
                $STDLY_INPUT_comments_split=$this->db->escape_like_str($STDLY_INPUT_comments);
                $STDLY_INPUT_datesplit=date('Y-m-d',strtotime($STDLY_INPUT_invoiceDate));
            $STDLY_INPUT_invfrom_split=$this->db->escape_like_str($PDLY_INPUT_inv_from);
            $STDLY_INPUT_invitem_split=$this->db->escape_like_str($STDLY_INPUT_in_items);
            $STDLY_INPUT_ctrylist=$STDLY_INPUT_expenselist;
            $STDLY_INPUT_amountsplit=$STDLY_INPUT_invoiceAmount;
            }
        }
        $insertquery = "CALL SP_STAFFDLY_STAFF_INSERT('$STDLY_INPUT_ctrylist','$STDLY_INPUT_datesplit','$STDLY_INPUT_amountsplit','$STDLY_INPUT_invitem_split','$STDLY_INPUT_invfrom_split','$STDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)";
        $this->db->query($insertquery);
        $successflag="SELECT @FLAG_INSERT as FLAG_INSERT";
        $successflagresult=$this->db->query($successflag);
        $flagresult=$successflagresult->row()->FLAG_INSERT;
        return $flagresult;
    }
    //GET DATA BY AGENT SEARCH......................
    public function STDLY_SEARCH_searchby_agent()
    {
        $this->db->select('ECN_ID,ECN_DATA');
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('CGN_ID IN (26,23)');
        $this->db->order_by('ECN_ID');
        $query = $this->db->get();
        $result1 = $query->result();
        $this->db->select('ECN_ID,ECN_DATA');
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('ECN_ID BETWEEN 76 AND 93 OR CGN_ID IN (23,26)');
        $this->db->order_by('ECN_ID');
        $query = $this->db->get();
        $result2 = $query->result();
        $this->db->select('EDSS_CPF_NUMBER');
        $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS');
        $this->db->where('ESS.EDSS_ID=EDSS.EDSS_ID AND EDSS_CPF_NUMBER IS NOT NULL ');
        $this->db->order_by('EDSS_CPF_NUMBER');
        $query = $this->db->get();
        $result3 = $query->result();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $Errormessagelist=$this->Mdl_eilib_common_function->getErrorMessageList('45,106,107,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,169,170,315,377,378,379,401');
        return $result[]=array($result1,$result2,$result3,$Errormessagelist);
    }
    public function fetch_data()
    {
        $STDLY_SEARCH_searchoptio=$_POST['STDLY_SEARCH_searchoptio'];
        if($STDLY_SEARCH_searchoptio==78)
        {
        $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
        $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
        $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
        $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
        $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
        $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
        $this->db->select("EA.EA_ID,DATE_FORMAT(EA.EA_DATE,'%d-%m-%Y') AS DATE,EA.EA_COMM_AMOUNT AS AMNT,EA.EA_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EA.EA_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
        $this->db->from('EXPENSE_AGENT EA,USER_LOGIN_DETAILS ULD');
        $this->db->where("ULD.ULD_ID=EA.ULD_ID AND (EA_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (EA_COMM_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
        $this->db->order_by("DATE", "ASC");
        $query = $this->db->get();
        return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==76){
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $this->db->select("EA.EA_ID,DATE_FORMAT(EA.EA_DATE,'%d-%m-%Y') AS DATE,EA.EA_COMM_AMOUNT AS AMNT,EA.EA_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EA.EA_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_AGENT EA,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=EA.ULD_ID AND (EA_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
            $this->db->order_by("DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==77){
           $STDLY_SEARCH_searchcomments=$_POST['STDLY_SEARCH_searchcomments'];
           $this->db->select("EA.EA_ID,DATE_FORMAT(EA.EA_DATE,'%d-%m-%Y') AS DATE,EA.EA_COMM_AMOUNT AS AMNT,EA.EA_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EA.EA_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_AGENT EA,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=EA.ULD_ID AND EA_COMMENTS ='$STDLY_SEARCH_searchcomments' ");
           $this->db->order_by("DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
    }
    public function Staff_Daily_pdf(){
        $STDLY_SEARCH_listoption=$_GET['STDLY_SEARCH_listoption'];
        if($STDLY_SEARCH_listoption==39) {
            $STDLY_SEARCH_searchoptio = $_GET['STDLY_SEARCH_searchoptio'];
            if ($STDLY_SEARCH_searchoptio == 78) {
                $STDLY_SEARCH_startdate = $_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d', strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate = $_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d', strtotime($STDLY_SEARCH_enddate));
                $STDLY_SEARCH_fromamount = $_GET['STDLY_SEARCH_fromamount'];
                $STDLY_SEARCH_toamount = $_GET['STDLY_SEARCH_toamount'];
                $this->db->select("EA.EA_ID,DATE_FORMAT(EA.EA_DATE,'%d-%m-%Y') AS DATE,EA.EA_COMM_AMOUNT AS AMNT,EA.EA_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EA.EA_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EXPENSE_AGENT EA,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=EA.ULD_ID AND (EA_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (EA_COMM_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
                $this->db->order_by("DATE", "ASC");
                $query = $this->db->get();
                $values_array = $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 76) {
                $STDLY_SEARCH_startdate = $_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d', strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate = $_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d', strtotime($STDLY_SEARCH_enddate));
                $this->db->select("EA.EA_ID,DATE_FORMAT(EA.EA_DATE,'%d-%m-%Y') AS DATE,EA.EA_COMM_AMOUNT AS AMNT,EA.EA_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EA.EA_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EXPENSE_AGENT EA,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=EA.ULD_ID AND (EA_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
                $this->db->order_by("DATE", "ASC");
                $query = $this->db->get();
                $values_array = $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 77) {
                $STDLY_SEARCH_searchcomments = $_GET['STDLY_SEARCH_searchcomments'];
                $this->db->select("EA.EA_ID,DATE_FORMAT(EA.EA_DATE,'%d-%m-%Y') AS DATE,EA.EA_COMM_AMOUNT AS AMNT,EA.EA_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EA.EA_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EXPENSE_AGENT EA,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=EA.ULD_ID AND EA_COMMENTS ='$STDLY_SEARCH_searchcomments' ");
                $this->db->order_by("DATE", "ASC");
                $query = $this->db->get();
                $values_array = $query->result();
            }
            $STDLY_SEARCH_table_value = '<table id="STDLY_SEARCH_tbl_htmltable" border="1"  cellspacing="0" class="srcresult"  style="width:3000px;border-collapse: collapse;"><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;"><tr><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:75px">AGENT DATE</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:60px">COMMISSION AMOUNT</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:300px;">COMMENTS</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:200px;">USERSTAMP</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px;" >TIMESTAMP</th></tr></thead><tbody>';
            for ($j = 0; $j < count($values_array); $j++) {
                $STDLY_SEARCH_date = $values_array[$j]->DATE;
                $STDLY_SEARCH_agentcommamount = $values_array[$j]->AMNT;
                $STDLY_SEARCH_agentcomments = $values_array[$j]->COMMENTS;
                if (($STDLY_SEARCH_agentcomments == null) || ($STDLY_SEARCH_agentcomments == 'undefined')) {
                    $STDLY_SEARCH_agentcomments = '';
                }
                $STDLY_SEARCH_agentuserstamp = $values_array[$j]->userstamp;
                $STDLY_SEARCH_agenttimestamp = $values_array[$j]->timestamp;
                $id = $values_array[$j]->EA_ID;
                $STDLY_SEARCH_table_value .= '<tr><td >' . $STDLY_SEARCH_date . '</td><td >' . $STDLY_SEARCH_agentcommamount . '</td><td>' . $STDLY_SEARCH_agentcomments . '</td><td>' . $STDLY_SEARCH_agentuserstamp . '</td><td>' . $STDLY_SEARCH_agenttimestamp . '</td></tr>';
            }
            $STDLY_SEARCH_table_value .= '</tbody></table>';
            return $STDLY_SEARCH_table_value;
        }
        else if($STDLY_SEARCH_listoption==40) {
            $STDLY_SEARCH_searchoptio = $_GET['STDLY_SEARCH_searchoptio'];
            if ($STDLY_SEARCH_searchoptio == 86) {
                $STDLY_SEARCH_startdate = $_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d', strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate = $_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d', strtotime($STDLY_SEARCH_enddate));
                $STDLY_SEARCH_fromamount = $_GET['STDLY_SEARCH_fromamount'];
                $STDLY_SEARCH_toamount = $_GET['STDLY_SEARCH_toamount'];
                $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ESS.ESS_CPF_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 87)//LEVY
            {
                $STDLY_SEARCH_startdate = $_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d', strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate = $_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d', strtotime($STDLY_SEARCH_enddate));
                $STDLY_SEARCH_fromamount = $_GET['STDLY_SEARCH_fromamount'];
                $STDLY_SEARCH_toamount = $_GET['STDLY_SEARCH_toamount'];
                $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ESS.ESS_LEVY_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
                $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 88)//SALARY
            {
                $STDLY_SEARCH_startdate = $_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d', strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate = $_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d', strtotime($STDLY_SEARCH_enddate));
                $STDLY_SEARCH_fromamount = $_GET['STDLY_SEARCH_fromamount'];
                $STDLY_SEARCH_toamount = $_GET['STDLY_SEARCH_toamount'];
                $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ESS.ESS_SALARY_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
                $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 91)//SALARY
            {
                $STDLY_SEARCH_startdate = $_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d', strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate = $_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d', strtotime($STDLY_SEARCH_enddate));
                $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_FROM_PERIOD BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
                $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 92)//SALARY
            {
                $STDLY_SEARCH_startdate = $_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d', strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate = $_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d', strtotime($STDLY_SEARCH_enddate));
                $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_TO_PERIOD BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
                $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 89)//SALARY
            {
                $STDLY_SEARCH_startdate = $_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d', strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate = $_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d', strtotime($STDLY_SEARCH_enddate));
                $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
                $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 93)//CPF NUMBER
            {
                $STDLY_SEARCH_selectedcpfno = $_GET['STDLY_SEARCH_selectedcpfno'];
                $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPFESS,ESS.ESS_LEVY_AMOUNT AS LEVYESS,ESS.ESS_SALARY_AMOUNT AS SALARYESS,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (EDSS.EDSS_CPF_NUMBER ='$STDLY_SEARCH_selectedcpfno')");
                $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 85)//CPF NUMBER
            {
                $STDLY_SEARCH_searchcomments = $this->db->escape_like_str($_POST['STDLY_SEARCH_searchcomments']);
                $query = $this->db->query("SELECT ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER  AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y')  AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPFESS,ESS.ESS_LEVY_AMOUNT AS LEVYESS,ESS.ESS_SALARY_AMOUNT AS SALARYESS,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'),'%d-%m-%Y %T') AS timestamp FROM EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_SALARY_COMMENTS='$STDLY_SEARCH_searchcomments') ORDER BY ESS.ESS_INVOICE_DATE ASC");

                $values_array= $query->result();
            }
            else if ($STDLY_SEARCH_searchoptio == 90) {
                $STDLY_SEARCH_splitempname = explode('_', $_GET['STDLY_SEARCH_selectedemployee']);
                $STDLY_SEARCH_firstname = $STDLY_SEARCH_splitempname[0];
                $STDLY_SEARCH_lastname = $STDLY_SEARCH_splitempname[1];
                $query = $this->db->query("SELECT ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER  AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y')  AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPFESS,ESS.ESS_LEVY_AMOUNT AS LEVYESS,ESS.ESS_SALARY_AMOUNT AS SALARYESS,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'),'%d-%m-%Y %T') AS timestamp FROM EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (EMPDTL.EMP_FIRST_NAME='$STDLY_SEARCH_firstname' AND EMPDTL.EMP_LAST_NAME ='$STDLY_SEARCH_lastname') ORDER BY ESS.ESS_INVOICE_DATE ASC");
                $values_array= $query->result();
            }
            $STDLY_SEARCH_table_value='<table id="STDLY_SEARCH_tbl_salaryhtmltable" border="1"  cellspacing="0" class="srcresult" style="width:1500px;border-collapse: collapse;" ><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;"><tr><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:90px">FIRST NAME</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:90px">LAST NAME</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px;">INVOICE DATE</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:160px;">FROM PERIOD</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:160px;">TO PERIOD</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:80px;">CPF NUMBER</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:80px;">CPF AMOUNT</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:80px;">LEVY AMOUNT</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:80px;">SALARY AMOUNT</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:320px;">COMMENTS</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:160px;">USERSTAMP</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:160px;">TIMESTAMP</th></tr></thead><tbody>';
            for($j=0;$j<count($values_array);$j++){
            $STDLY_SEARCH_cpfamount=$values_array[$j]->CPF;
                if(($STDLY_SEARCH_cpfamount==null)||($STDLY_SEARCH_cpfamount=='undefined'))
                {
                    $STDLY_SEARCH_cpfamount='';
                }
                $STDLY_SEARCH_levyamount=$values_array[$j]->LEVY;
                if(($STDLY_SEARCH_levyamount==null)||($STDLY_SEARCH_levyamount=='undefined'))
                {
                    $STDLY_SEARCH_levyamount='';
                }
                $STDLY_SEARCH_salaryamount=$values_array[$j]->SALARY;
                $FIRST=$values_array[$j]->FIRST;
                if(($FIRST==null)||($FIRST=='undefined'))
                {
                    $FIRST='';
                }
                $LAST=$values_array[$j]->LAST;
                if(($LAST==null)||($LAST=='undefined'))
                {
                    $LAST='';
                }
                $CPFNO=$values_array[$j]->CPFNO;
                if(($CPFNO==null)||($CPFNO=='undefined'))
                {
                    $CPFNO='';
                }
                $INVOICE=$values_array[$j]->INVOICE;
                $to_pereoid=$values_array[$j]->TOPERIOD;
                $from_pereoid=$values_array[$j]->FROMPERIOD;
                $comments=$values_array[$j]->COMMENTS;
                if(($comments==null)||($comments=='undefined'))
                {
                    $comments='';
                }
                $userstamp=$values_array[$j]->USERSTAMP;
                $timestamp=$values_array[$j]->timestamp;
                $STDLY_SEARCH_salary=$values_array[$j]->SALARYESS;
                $STDLY_SEARCH_cpf=$values_array[$j]->CPFESS;
                $STDLY_SEARCH_levy=$values_array[$j]->LEVYESS;
                $id=$values_array[$j]->ESS_ID;
                $STDLY_SEARCH_table_value.='<tr><td>'.$FIRST.'</td><td>'.$LAST.'</td><td>'.$INVOICE.'</td><td>'.$from_pereoid.'</td><td>'.$to_pereoid.'</td><td>'.$CPFNO.'</td><td>'.$STDLY_SEARCH_cpfamount.'</td><td>'.$STDLY_SEARCH_levyamount.'</td><td>'.$STDLY_SEARCH_salaryamount.'</td><td>'.$comments.'</td><td>'.$userstamp.'</td><td nowrap>'.$timestamp.'</td></tr>';
            }
            $STDLY_SEARCH_table_value.='</tbody></table>';
            return $STDLY_SEARCH_table_value;
        }
        else if($STDLY_SEARCH_listoption==41){
            $STDLY_SEARCH_searchoptio=$_GET['STDLY_SEARCH_searchoptio'];
            if($STDLY_SEARCH_searchoptio==80){
                $STDLY_SEARCH_staffexpansecategory1=$_GET['STDLY_SEARCH_staffexpansecategory'];
                $STDLY_SEARCH_staffexpansecategory=str_replace("^","&",$STDLY_SEARCH_staffexpansecategory1);
                $STDLY_SEARCH_startdate=$_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate=$_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
                $STDLY_SEARCH_fromamount=$_GET['STDLY_SEARCH_fromamount'];
                $STDLY_SEARCH_toamount=$_GET['STDLY_SEARCH_toamount'];
                $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (EXPCONFIG.ECN_DATA='$STDLY_SEARCH_staffexpansecategory') AND (EXPCONFIG.ECN_ID=ES.ECN_ID)");
                $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if($STDLY_SEARCH_searchoptio==84)
            {
                $STDLY_SEARCH_staffexpansecategory=$_GET['STDLY_SEARCH_staffexpansecategory'];
                $STDLY_SEARCH_startdate=$_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate=$_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
                $STDLY_SEARCH_fromamount=$_GET['STDLY_SEARCH_fromamount'];
                $STDLY_SEARCH_toamount=$_GET['STDLY_SEARCH_toamount'];
                $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ES.ES_INVOICE_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount') AND (EXPCONFIG.ECN_ID=ES.ECN_ID)");
                $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if($STDLY_SEARCH_searchoptio==81)
            {
                $STDLY_SEARCH_staffexpansecategory=$_GET['STDLY_SEARCH_staffexpansecategory'];
                $STDLY_SEARCH_startdate=$_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate=$_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
                $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')  AND (EXPCONFIG.ECN_ID=ES.ECN_ID)");
                $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if($STDLY_SEARCH_searchoptio==82)
            {
                $STDLY_SEARCH_staffexpansecategory=$_GET['STDLY_SEARCH_staffexpansecategory'];
                $STDLY_SEARCH_startdate=$_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate=$_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
                $STDLY_SEARCH_invfromcomt=$_GET['STDLY_SEARCH_invfromcomt'];
                $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')  AND (EXPCONFIG.ECN_ID=ES.ECN_ID) AND (ES.ES_INVOICE_FROM='$STDLY_SEARCH_invfromcomt') ");
                $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if($STDLY_SEARCH_searchoptio==83)
            {
                $STDLY_SEARCH_staffexpansecategory=$_GET['STDLY_SEARCH_staffexpansecategory'];
                $STDLY_SEARCH_startdate=$_GET['STDLY_SEARCH_startdate'];
                $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
                $STDLY_SEARCH_enddate=$_GET['STDLY_SEARCH_enddate'];
                $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
                $STDLY_SEARCH_invitemcom=$_GET['STDLY_SEARCH_invitemcom'];
                $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')  AND (EXPCONFIG.ECN_ID=ES.ECN_ID) AND (ES.ES_INVOICE_ITEMS='$STDLY_SEARCH_invitemcom') ");
                $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            else if($STDLY_SEARCH_searchoptio==79)
            {
                $STDLY_SEARCH_searchcomments=$_GET['STDLY_SEARCH_searchcomments'];
                $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
                $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
                $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (EXPCONFIG.ECN_ID=ES.ECN_ID) AND (ES.ES_COMMENTS='$STDLY_SEARCH_searchcomments') ");
                $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
                $query = $this->db->get();
                $values_array= $query->result();
            }
            $STDLY_SEARCH_table_value='<table id="STDLY_SEARCH_tbl_staffhtmltable" border="1"  cellspacing="0" class="srcresult" style="width:1500px;border-collapse: collapse;" ><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;"><tr><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:170px;">STAFF EXPENSE</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:105px;">INVOICE DATE</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:65px;">INVOICE AMOUNT</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px;">INVOICE ITEMS</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px;">INVOICE FROM</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:200px;">COMMENTS</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px;">USERSTAMP</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:160px;">TIMESTAMP</th></tr></thead><tbody>';
            for($j=0;$j<count($values_array);$j++){
                 $STDLY_SEARCH_values=$values_array[$j];
                 $STDLY_SEARCH_amount=$values_array[$j]->STDLY_SEARCH_amount;
                 $STDLY_SEARCH_comments=$values_array[$j]->COMMENTS;
                 if(($STDLY_SEARCH_comments==null)||($STDLY_SEARCH_comments=='undefined')){
                    $STDLY_SEARCH_comments='';
                 }
                 $STDLY_SEARCH_userstamp=$values_array[$j]->USERSTAMP;
                 $STDLY_SEARC_timestamp=$values_array[$j]->timestamp;
                 $STDLY_SEARCH_table_value.='<tr><td >'.$STDLY_SEARCH_values->STDLY_SEARCH_type.'</td><td >'.$STDLY_SEARCH_values->STDLY_SEARCH_date.'</td><td >'.$STDLY_SEARCH_amount.'</td><td>'.$STDLY_SEARCH_values->STDLY_SEARCH_items.'</td><td>'.$STDLY_SEARCH_values->STDLY_SEARCH_from.'</td><td>'.$STDLY_SEARCH_comments.'</td><td>'.$STDLY_SEARCH_userstamp.'</td><td>'.$STDLY_SEARC_timestamp.'</td></tr>';
            }
            $STDLY_SEARCH_table_value.='</tbody></table>';
            return $STDLY_SEARCH_table_value;
        }
    }
    public function STDLY_SEARCH_comments($USERSTAMP,$STDLY_SEARCH_sec_searchoption,$STDLY_SEARCH_startdate,$STDLY_SEARCH_enddate)
    {
        $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
        $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
        $STDTL_SEARCH_autocomplete=[];
        if($STDLY_SEARCH_sec_searchoption==77){
            $this->db->distinct();
            $this->db->select("EA_COMMENTS");
            $this->db->from("EXPENSE_AGENT");
            $this->db->where("EA_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND EA_COMMENTS IS NOT NULL ");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['EA_COMMENTS'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
        elseif($STDLY_SEARCH_sec_searchoption==85){
            $this->db->distinct();
            $this->db->select("ESS_SALARY_COMMENTS");
            $this->db->from("EXPENSE_STAFF_SALARY");
            $this->db->where("ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND ESS_SALARY_COMMENTS IS NOT NULL");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['ESS_SALARY_COMMENTS'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
        elseif($STDLY_SEARCH_sec_searchoption==82)//INVOICE FORM -STAFF
        {
            $this->db->distinct();
            $this->db->select("ES_INVOICE_FROM");
            $this->db->from("EXPENSE_STAFF");
            $this->db->where("ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND ES_INVOICE_FROM IS NOT NULL");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['ES_INVOICE_FROM'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
        elseif($STDLY_SEARCH_sec_searchoption==83)//INVOICE FORM -STAFF
        {
            $this->db->distinct();
            $this->db->select("ES_INVOICE_ITEMS");
            $this->db->from("EXPENSE_STAFF");
            $this->db->where("ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND ES_INVOICE_ITEMS IS NOT NULL");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['ES_INVOICE_ITEMS'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
        elseif($STDLY_SEARCH_sec_searchoption==79)//INVOICE FORM -COMMENTS
        {
            $this->db->distinct();
            $this->db->select("ES_COMMENTS");
            $this->db->from("EXPENSE_STAFF");
            $this->db->where("ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND ES_COMMENTS IS NOT NULL");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['ES_COMMENTS'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
    }
    //GET DATA FOR SALARY SEARCH OPTIONS.................................FROM SALARY ENTRY...........
    public function fetch_salarydata()
    {
        $STDLY_SEARCH_searchoptio=$_POST['STDLY_SEARCH_searchoptio'];
        if($STDLY_SEARCH_searchoptio==86)
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ESS.ESS_CPF_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==87)//LEVY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ESS.ESS_LEVY_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==88)//SALARY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ESS.ESS_SALARY_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==91)//SALARY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_FROM_PERIOD BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==92)//SALARY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_TO_PERIOD BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==89)//SALARY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==93)//CPF NUMBER
        {
            $STDLY_SEARCH_selectedcpfno=$_POST['STDLY_SEARCH_selectedcpfno'];
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPFESS,ESS.ESS_LEVY_AMOUNT AS LEVYESS,ESS.ESS_SALARY_AMOUNT AS SALARYESS,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (EDSS.EDSS_CPF_NUMBER ='$STDLY_SEARCH_selectedcpfno')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==85)//CPF NUMBER
        {
            $STDLY_SEARCH_searchcomments=$this->db->escape_like_str($_POST['STDLY_SEARCH_searchcomments']);
            $query = $this->db->query("SELECT ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER  AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y')  AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPFESS,ESS.ESS_LEVY_AMOUNT AS LEVYESS,ESS.ESS_SALARY_AMOUNT AS SALARYESS,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'),'%d-%m-%Y %T') AS timestamp FROM EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_SALARY_COMMENTS='$STDLY_SEARCH_searchcomments') ORDER BY ESS.ESS_INVOICE_DATE ASC");

            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==90)
        {
            $STDLY_SEARCH_splitempname = explode('_',$_POST['STDLY_SEARCH_selectedemployee']);
            $STDLY_SEARCH_firstname = $STDLY_SEARCH_splitempname[0];
            $STDLY_SEARCH_lastname = $STDLY_SEARCH_splitempname[1];
            $query = $this->db->query("SELECT ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER  AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y')  AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPFESS,ESS.ESS_LEVY_AMOUNT AS LEVYESS,ESS.ESS_SALARY_AMOUNT AS SALARYESS,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+08:00'),'%d-%m-%Y %T') AS timestamp FROM EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (EMPDTL.EMP_FIRST_NAME='$STDLY_SEARCH_firstname' AND EMPDTL.EMP_LAST_NAME ='$STDLY_SEARCH_lastname') ORDER BY ESS.ESS_INVOICE_DATE ASC");

            return $query->result();
        }
    }
    //INLINE SUBJECT UPDATE
    public  function update_agentdata($USERSTAMP,$primaryid,$agentdate,$agentcomments,$agentamount)
    {
        $STDLY_SEARCH_lbtypeofexpense=$_POST['STDLY_SEARCH_typelist'];
            $STDLY_SEARCH_date = date('Y-m-d',strtotime($agentdate));
            if($agentcomments==''){
                $agentcomments='null';
            }
            else{
                $agentcomments=$this->db->escape_like_str($agentcomments);
                $agentcomments="'$agentcomments'";
            }
            $updatequery = "UPDATE EXPENSE_AGENT SET EA_DATE='$STDLY_SEARCH_date',EA_COMM_AMOUNT='$agentamount',EA_COMMENTS=$agentcomments,ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP') WHERE EA_ID='$primaryid'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    public function  update_staff($USERSTAMP,$STDLY_SEARCH_lbstaffexpense,$STDLY_SEARCH_dbinvoicedate,$STDLY_SEARCH_staff_fullamount,$STDLY_SEARCH_tbinvoiceitems,$STDLY_SEARCH_tbinvoicefrom,$STDLY_SEARCH_tbcomments,$id)
    {
        if ($STDLY_SEARCH_tbcomments == '') {
            $STDLY_SEARCH_tbcomments = 'null';
        } else {
            $STDLY_SEARCH_tbcomments = "'$STDLY_SEARCH_tbcomments'";
        }
        $updatequery = "UPDATE EXPENSE_STAFF SET ES_INVOICE_DATE='$STDLY_SEARCH_dbinvoicedate',ES_INVOICE_AMOUNT='$STDLY_SEARCH_staff_fullamount',ES_INVOICE_ITEMS='$STDLY_SEARCH_tbinvoiceitems',ES_INVOICE_FROM='$STDLY_SEARCH_tbinvoicefrom',ES_COMMENTS=$STDLY_SEARCH_tbcomments,ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),ECN_ID=(SELECT ECN_ID FROM EXPENSE_CONFIGURATION WHERE ECN_DATA='$STDLY_SEARCH_lbstaffexpense' AND CGN_ID=26) WHERE ES_ID='$id'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return 'true';
        } else {
            return 'false';
        }
    }
    //GET DATA FOR SALARY SEARCH OPTIONS.................................FROM SALARY ENTRY...........
    public function fetch_staffsalarydata()
    {
        $STDLY_SEARCH_searchoptio=$_POST['STDLY_SEARCH_searchoptio'];
        if($STDLY_SEARCH_searchoptio==80)
        {
            $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
            $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (EXPCONFIG.ECN_DATA='$STDLY_SEARCH_staffexpansecategory') AND (EXPCONFIG.ECN_ID=ES.ECN_ID)");
            $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
       else if($STDLY_SEARCH_searchoptio==84)
        {
            $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
            $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ES.ES_INVOICE_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount') AND (EXPCONFIG.ECN_ID=ES.ECN_ID)");
            $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
       else if($STDLY_SEARCH_searchoptio==81)
       {
           $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
           $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
           $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
           $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
           $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
           $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')  AND (EXPCONFIG.ECN_ID=ES.ECN_ID)");
           $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
       else if($STDLY_SEARCH_searchoptio==82)
       {
           $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
           $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
           $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
           $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
           $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
           $STDLY_SEARCH_invfromcomt=$_POST['STDLY_SEARCH_invfromcomt'];
           $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')  AND (EXPCONFIG.ECN_ID=ES.ECN_ID) AND (ES.ES_INVOICE_FROM='$STDLY_SEARCH_invfromcomt') ");
           $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
       else if($STDLY_SEARCH_searchoptio==83)
       {
           $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
           $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
           $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
           $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
           $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
           $STDLY_SEARCH_invitemcom=$_POST['STDLY_SEARCH_invitemcom'];
           $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')  AND (EXPCONFIG.ECN_ID=ES.ECN_ID) AND (ES.ES_INVOICE_ITEMS='$STDLY_SEARCH_invitemcom') ");
           $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
       else if($STDLY_SEARCH_searchoptio==79)
       {
           $STDLY_SEARCH_searchcomments=$_POST['STDLY_SEARCH_searchcomments'];
           $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (EXPCONFIG.ECN_ID=ES.ECN_ID) AND (ES.ES_COMMENTS='$STDLY_SEARCH_searchcomments') ");
           $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
    }
    public function STDLY_SEARCH_getempcpfno()
    {
        $searchoption=$_POST['searchoption'];
        if($searchoption==93) {
            $this->db->distinct();
            $this->db->select('EDSS_CPF_NUMBER', FALSE);
            $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS');
            $this->db->where("(ESS.EDSS_ID=EDSS.EDSS_ID) AND EDSS_CPF_NUMBER IS NOT NULL");
            $this->db->order_by("EDSS_CPF_NUMBER", "ASC");
            $query = $this->db->get();
            $result1 = $query->result();
            $resultset = array($result1);
            return $result1;
        }
        elseif($searchoption==90)
        {
            $STDLY_SEARCH_employeeNameArray = [];
            $STDLY_SEARCH_employee_Name_List=[];
            $STDLY_SEARCH_employee_Name_List1=[];
            $STDLY_SEARCH_emp_fname='';$STDLY_SEARCH_epm_lname='';
            $STDLY_SEARCH_selectEmployeeName = "SELECT ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME FROM EMPLOYEE_DETAILS ED WHERE ED.EMP_ID IN (SELECT EMP_ID FROM EXPENSE_DETAIL_STAFF_SALARY) ORDER BY ED.EMP_FIRST_NAME ASC";
            $STDLY_SEARCH_employeeName = $this->db->query($STDLY_SEARCH_selectEmployeeName);
            foreach($STDLY_SEARCH_employeeName->result_array() as $row){
                $STDLY_SEARCH_emp_fname = $row["EMP_FIRST_NAME"];
                $STDLY_SEARCH_epm_lname = $row["EMP_LAST_NAME"];
                $STDLY_SEARCH_employee_Name_List[]=$STDLY_SEARCH_emp_fname.'_'.$STDLY_SEARCH_epm_lname;
                $STDLY_SEARCH_employee_Name_List1[]= $STDLY_SEARCH_emp_fname.' '.$STDLY_SEARCH_epm_lname;
            }
            return [$STDLY_SEARCH_employee_Name_List,$STDLY_SEARCH_employee_Name_List1];
        }
    }
    //SINGLE ROW DELETION PROCESS CALLING EILIB  FUNCTION
    public function DeleteRecord($USERSTAMP,$rowid,$STDLY_SEARCH_typelist,$STDLY_SEARCH_srchoption,$startdate,$enddate)
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $STDLY_SEARCH_twodimen=[39=>['EXPENSE_AGENT',44],40=>['EXPENSE_STAFF_SALARY',42],41=>['EXPENSE_STAFF',43]];
        $STDLY_SEARCH_deleteid=$rowid;
        $STDLY_SEARCH_flag_delete=$this->Mdl_eilib_common_function->DeleteRecord($STDLY_SEARCH_twodimen[$STDLY_SEARCH_typelist][1],$STDLY_SEARCH_deleteid,$USERSTAMP);
        $STDLY_INPUT_arr_comments=[];
        if(($STDLY_SEARCH_srchoption==77)||($STDLY_SEARCH_srchoption==85)||($STDLY_SEARCH_srchoption==79)||($STDLY_SEARCH_srchoption==82)||($STDLY_SEARCH_srchoption==83))
            $STDLY_INPUT_arr_comments=$this->STDLY_SEARCH_comments($USERSTAMP,$STDLY_SEARCH_srchoption,$startdate,$enddate);
        return [$STDLY_SEARCH_flag_delete,$STDLY_INPUT_arr_comments];
    }
    //FUNCTION FOR SAVE staff PART
    public function STDLY_salaryupdate($USERSTAMP){
        $STDLY_SEARCH_id=$_POST['id'];
        $STDLY_SEARCH_empname =$_POST['STDLY_SEARCH_lb_namelist'];
        $STDLY_SEARCH_comments = $_POST['STDLY_SEARCH_ta_salarycommentsbox'];
        $STDLY_SEARCH_paiddate =date('Y-m-d',strtotime($_POST['STDLY_SEARCH_db_paiddate']));
        $STDLY_SEARCH_cpfradio= (isset($_POST['STDLY_SEARCH_radio_cpfamt']));
        $STDLY_SEARCH_levyradio= (isset($_POST['STDLY_SEARCH_radio_levyamt']));
        $STDLY_SEARCH_salaryradio=(isset($_POST['STDLY_SEARCH_radio_slramt']));
        $STDLY_SEARCH_fromperiod =date('Y-m-d',strtotime($_POST['STDLY_SEARCH_db_fromdate']));
        $STDLY_SEARCH_toperiod = date('Y-m-d',strtotime($_POST['STDLY_SEARCH_db_todate']));
        $STDLY_SEARCH_hidenlevyamount = $_POST['STDLY_SEARCH_tb_gethiddenelevy'];
        $STDLY_SEARCH_hidensalaryamount = $_POST['STDLY_SEARCH_tb_gethiddenesal'];
        $STDLY_SEARCH_hidencpfamount = $_POST['STDLY_SEARCH_tb_gethiddenecpf'];
        $STDLY_SEARCH_cpfamount = $_POST['STDLY_SEARCH_tb_hidecpf1'];
        $STDLY_SEARCH_searchoption=$_POST['STDLY_SEARCH_lb_salarysearchoption'];
        $STDLY_SEARCH_lb_salarysearchoption=$_POST['STDLY_SEARCH_lb_salarysearchoption'];
        if($STDLY_SEARCH_comments=="")//COMMENTS
        {  $STDLY_SEARCH_comments='null';}else{
            $STDLY_SEARCH_comments=$this->db->escape_like_str($STDLY_SEARCH_comments);
            $STDLY_SEARCH_comments="'$STDLY_SEARCH_comments'";}
        if($STDLY_SEARCH_cpfradio==true)
        {
            if(($STDLY_SEARCH_cpfamount=='undefined')||($STDLY_SEARCH_cpfamount==""))
            {
                $STDLY_SEARCH_cpfamount="'$STDLY_SEARCH_hidencpfamount'";
            }
            else{
                $STDLY_SEARCH_cpfamount="'$STDLY_SEARCH_cpfamount'";
            }
        }
        else
        {
            $STDLY_SEARCH_cpfamount='null';
        }
        $STDLY_SEARCH_levyamount = $_POST['STDLY_SEARCH_tb_hidelevy1'];
        if($STDLY_SEARCH_levyradio==true)
        {
            if(($STDLY_SEARCH_levyamount=='undefined')||($STDLY_SEARCH_levyamount==""))
            {
                $STDLY_SEARCH_levyamount="'$STDLY_SEARCH_hidenlevyamount'";
            }
            else{
                $STDLY_SEARCH_levyamount="'$STDLY_SEARCH_levyamount'";
            }

        }
        else
        {
            $STDLY_SEARCH_levyamount='null';
        }
        $STDLY_SEARCH_salaryamount = $_POST['STDLY_SEARCH_tb_hidesal1'];
        if($STDLY_SEARCH_salaryradio==true)
        {
            if(($STDLY_SEARCH_salaryamount=='undefined')||($STDLY_SEARCH_salaryamount=="")) {
                $STDLY_SEARCH_salaryamount = "'$STDLY_SEARCH_hidensalaryamount'";
            }
            else{
                $STDLY_SEARCH_salaryamount="'$STDLY_SEARCH_salaryamount'";
            }
        }
        else{
            $STDLY_SEARCH_salaryamount='null';
        }
        $insertquery = "CALL SP_STAFFDLY_STAFF_SALARY_UPDATE('$STDLY_SEARCH_id','$STDLY_SEARCH_paiddate','$STDLY_SEARCH_fromperiod','$STDLY_SEARCH_toperiod',$STDLY_SEARCH_cpfamount,$STDLY_SEARCH_levyamount,$STDLY_SEARCH_salaryamount,$STDLY_SEARCH_comments,'$USERSTAMP',@SUCCESS_MSG)";
        $query = $this->db->query($insertquery);
        $FLAG= $this->db->query('SELECT @SUCCESS_MSG as SUCCESSMSG');
        $finalFLAG = $FLAG->row()->SUCCESSMSG;
        $STDLY_SEARCH_db_startdate=$_POST['STDLY_SEARCH_db_startdate'];
        $STDLY_SEARCH_db_enddate=$_POST['STDLY_SEARCH_db_enddate'];
        $STDLY_INPUT_arr_comments=[];
        if(($STDLY_SEARCH_lb_salarysearchoption==77)||($STDLY_SEARCH_lb_salarysearchoption==85)||($STDLY_SEARCH_lb_salarysearchoption==79)||($STDLY_SEARCH_lb_salarysearchoption==82)||($STDLY_SEARCH_lb_salarysearchoption==83))
            $STDLY_INPUT_arr_comments=$this->STDLY_SEARCH_comments($USERSTAMP,$STDLY_SEARCH_lb_salarysearchoption,$STDLY_SEARCH_db_startdate,$STDLY_SEARCH_db_enddate);
        return [$STDLY_INPUT_arr_comments,$finalFLAG];
    }
}