<?php
class Mdl_staff_detail_entry_search_update_delete extends CI_Model{
    //FUNCTION FOR GETTING STAFF NAME
    Public function getstaffname($STAFF_ENTRY_searchby)
    {
        if($STAFF_ENTRY_searchby=="STAFF ENTRY"){
            $this->db->select('EMP_ID,CONCAT(EMP_FIRST_NAME,"_",EMP_LAST_NAME) AS STDTL_INPUT_names_concat',FALSE);
            $this->db->order_by("EMP_FIRST_NAME", "ASC");
            $this->db->from('EMPLOYEE_DETAILS');
            $this->db->where('EMP_ID NOT IN (SELECT EMP_ID FROM EXPENSE_DETAIL_STAFF_SALARY) AND ECN_ID=74');
            $query = $this->db->get();
            $result1 = $query->result();
            $resultset=array($result1);
            return $result1;
        }
        else{
            $this->db->select("ECN_ID,ECN_DATA");
            $this->db->order_by("ECN_DATA", "ASC");
            $this->db->from('EXPENSE_CONFIGURATION');
            $this->db->where('ECN_ID IN (90,93,86,87,88,79)');
            $query = $this->db->get();
            return $query->result_array();
        }
    }
    //SAVE PART FUNCTION
    public function save_models($USERSTAMP,$STDTL_INPUT_radioemployid,$STDTL_INPUT_employeenameid,$STDTL_INPUT_cpfnumber,$STDTL_INPUT_cpfamount,$STDTL_INPUT_levyamount,$STDTL_INPUT_salaryamount,$STDTL_INPUT_comments){
          if($STDTL_INPUT_cpfnumber==''){
              $STDTL_INPUT_cpfnumber='null';
          }
          else{
              $STDTL_INPUT_cpfnumber="'$STDTL_INPUT_cpfnumber'";
          }
          if($STDTL_INPUT_cpfamount==''){
              $STDTL_INPUT_cpfamount='null';
          }
          else{
              $STDTL_INPUT_cpfamount="'$STDTL_INPUT_cpfamount'";
          }
          if($STDTL_INPUT_levyamount==''){
              $STDTL_INPUT_levyamount='null';
          }
          else{
              $STDTL_INPUT_levyamount="'$STDTL_INPUT_levyamount'";
          }
          if($STDTL_INPUT_salaryamount==''){
              $STDTL_INPUT_salaryamount='null';
          }
          else{
              $STDTL_INPUT_salaryamount="'$STDTL_INPUT_salaryamount'";
          }
          if($STDTL_INPUT_comments==''){
              $STDTL_INPUT_comments='null';
          }
          else{
              $STDTL_INPUT_comments="'$STDTL_INPUT_comments'";
          }
          if($STDTL_INPUT_radioemployid=='')
          {
              $STDTL_INPUT_employeenameid=$STDTL_INPUT_employeenameid;
          }
          else
          {
              $STDTL_INPUT_employeenameid=$STDTL_INPUT_radioemployid;
          }
          $insertquery = "INSERT INTO EXPENSE_DETAIL_STAFF_SALARY(ULD_ID,EMP_ID,EDSS_CPF_NUMBER,EDSS_CPF_AMOUNT,EDSS_LEVY_AMOUNT,EDSS_SALARY_AMOUNT,EDSS_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),$STDTL_INPUT_employeenameid,$STDTL_INPUT_cpfnumber,$STDTL_INPUT_cpfamount,$STDTL_INPUT_levyamount,$STDTL_INPUT_salaryamount,$STDTL_INPUT_comments)";
          $this->db->query($insertquery);
          if ($this->db->affected_rows() > 0) {
            return true;
          }
          else {
            return false;
          }
    }
    //FUNCTION FOR ALREADY EXIT
    public function cpfno_exists($STDTL_INPUT_Cpfno)
    {
        $STDTL_INPUT_already = "SELECT EDSS_ID FROM EXPENSE_DETAIL_STAFF_SALARY WHERE EDSS_CPF_NUMBER='$STDTL_INPUT_Cpfno' ";
        $this->db->query($STDTL_INPUT_already);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
    //FUNCTION FOR GETTING CPF ND EMP NAME
    Public function getempcpfno()
    {
        //CPF NUMBER
        $this->db->select("EDSS_CPF_NUMBER");
        $this->db->order_by("EDSS_CPF_NUMBER", "ASC");
        $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EMPLOYEE_DETAILS ED');
        $this->db->where('EDSS.EMP_ID=ED.EMP_ID AND EDSS_CPF_NUMBER IS NOT NULL');
        $cpf_no = $this->db->get();
        $STDTL_SEARCH_cpfnumber_array=$cpf_no->result();
        //EMP NAME
        $this->db->distinct();
        $this->db->select("ED.EMP_FIRST_NAME AS EMP_FIRST_NAME,ED.EMP_LAST_NAME AS EMP_LAST_NAME");
        $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EMPLOYEE_DETAILS ED');
        $this->db->where('EDSS.EMP_ID=ED.EMP_ID');
        $this->db->order_by("ED.EMP_FIRST_NAME", "ASC");
        $emp_name = $this->db->get();
        $STDTL_SEARCH_empname_array=array();
        foreach ($emp_name->result_array() as $row)
        {
            $EMP_firstname=$row["EMP_FIRST_NAME"];
            $EMP_lastname=$row["EMP_LAST_NAME"];
            $STDTL_SEARCH_empname_array[]=($EMP_firstname."_".$EMP_lastname);
        }
        return $arrayvalues=array($STDTL_SEARCH_cpfnumber_array,$STDTL_SEARCH_empname_array);
    }
    public function fetch_data($STDTL_SEARCH_staffexpense_selectquery,$STDTL_SEARCH_cpfnumber,$STDTL_SEARCH_cpffrom_form,$STDTL_SEARCH_cpfto_form,$STDTL_SEARCH_staffcommentstxt,$emp_first_name,$emp_last_name)
    {
       if($STDTL_SEARCH_staffexpense_selectquery==93){
        $this->db->select("ED.EMP_ID,EDSS.EDSS_ID AS empno,ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME,EDSS.EDSS_CPF_NUMBER AS cpfnumber,EDSS.EDSS_CPF_AMOUNT AS cpfamount,EDSS.EDSS_LEVY_AMOUNT AS levyamount,EDSS.EDSS_SALARY_AMOUNT AS salaryamount,EDSS.EDSS_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EDSS.EDSS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
        $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EMPLOYEE_DETAILS ED,USER_LOGIN_DETAILS ULD');
        $this->db->where("EDSS.EDSS_CPF_NUMBER='$STDTL_SEARCH_cpfnumber' AND  EDSS.EMP_ID=ED.EMP_ID AND ULD.ULD_ID=EDSS.ULD_ID");
        $this->db->order_by("EDSS.EMP_ID", "ASC");
        $query = $this->db->get();
        return $query->result();
        }
        else if($STDTL_SEARCH_staffexpense_selectquery==86  || $STDTL_SEARCH_staffexpense_selectquery==88){
         $this->db->select("ED.EMP_ID,EDSS.EDSS_ID AS empno,ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME,EDSS.EDSS_CPF_NUMBER AS cpfnumber,EDSS.EDSS_CPF_AMOUNT AS cpfamount,EDSS.EDSS_LEVY_AMOUNT AS levyamount,EDSS.EDSS_SALARY_AMOUNT AS salaryamount,EDSS.EDSS_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EDSS.EDSS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
         $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EMPLOYEE_DETAILS ED,USER_LOGIN_DETAILS ULD');
         $this->db->where("EDSS_CPF_AMOUNT between '$STDTL_SEARCH_cpffrom_form' and '$STDTL_SEARCH_cpfto_form' and EDSS.EMP_ID=ED.EMP_ID  AND ULD.ULD_ID=EDSS.ULD_ID");
         $this->db->order_by("ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME, EDSS.EMP_ID", "ASC");
         $query = $this->db->get();
         return $query->result();
        }
        else if($STDTL_SEARCH_staffexpense_selectquery==87){
            $this->db->select("ED.EMP_ID,EDSS.EDSS_ID AS empno,ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME,EDSS.EDSS_CPF_NUMBER AS cpfnumber,EDSS.EDSS_CPF_AMOUNT AS cpfamount,EDSS.EDSS_LEVY_AMOUNT AS levyamount,EDSS.EDSS_SALARY_AMOUNT AS salaryamount,EDSS.EDSS_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EDSS.EDSS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EMPLOYEE_DETAILS ED,USER_LOGIN_DETAILS ULD');
            $this->db->where("EDSS_LEVY_AMOUNT between '$STDTL_SEARCH_cpffrom_form' and '$STDTL_SEARCH_cpfto_form' and EDSS.EMP_ID=ED.EMP_ID  AND ULD.ULD_ID=EDSS.ULD_ID");
            $this->db->order_by("ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME, EDSS.EMP_ID", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDTL_SEARCH_staffexpense_selectquery==88){
            $this->db->select("ED.EMP_ID,EDSS.EDSS_ID AS empno,ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME,EDSS.EDSS_CPF_NUMBER AS cpfnumber,EDSS.EDSS_CPF_AMOUNT AS cpfamount,EDSS.EDSS_LEVY_AMOUNT AS levyamount,EDSS.EDSS_SALARY_AMOUNT AS salaryamount,EDSS.EDSS_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EDSS.EDSS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EMPLOYEE_DETAILS ED,USER_LOGIN_DETAILS ULD');
            $this->db->where("EDSS_SALARY_AMOUNT between '$STDTL_SEARCH_cpffrom_form' and '$STDTL_SEARCH_cpfto_form' and EDSS.EMP_ID=ED.EMP_ID  AND ULD.ULD_ID=EDSS.ULD_ID");
            $this->db->order_by("ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME, EDSS.EMP_ID", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDTL_SEARCH_staffexpense_selectquery==90){
            $this->db->select("ED.EMP_ID,EDSS.EDSS_ID AS empno,ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME,EDSS.EDSS_CPF_NUMBER AS cpfnumber,EDSS.EDSS_CPF_AMOUNT AS cpfamount,EDSS.EDSS_LEVY_AMOUNT AS levyamount,EDSS.EDSS_SALARY_AMOUNT AS salaryamount,EDSS.EDSS_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EDSS.EDSS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EMPLOYEE_DETAILS ED,USER_LOGIN_DETAILS ULD');
            $this->db->where("ED.EMP_FIRST_NAME='$emp_first_name' AND  ED.EMP_LAST_NAME='$emp_last_name' AND EDSS.EMP_ID=ED.EMP_ID AND ULD.ULD_ID=EDSS.ULD_ID");
            $this->db->order_by("EDSS.EMP_ID", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDTL_SEARCH_staffexpense_selectquery==79){
            $this->db->select("ED.EMP_ID,EDSS.EDSS_ID AS empno,ED.EMP_FIRST_NAME,ED.EMP_LAST_NAME,EDSS.EDSS_CPF_NUMBER AS cpfnumber,EDSS.EDSS_CPF_AMOUNT AS cpfamount,EDSS.EDSS_LEVY_AMOUNT AS levyamount,EDSS.EDSS_SALARY_AMOUNT AS salaryamount,EDSS.EDSS_COMMENTS AS comments,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EDSS.EDSS_TIMESTAMP,'+00:00','+08:00'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EMPLOYEE_DETAILS ED,USER_LOGIN_DETAILS ULD');
            $this->db->where("EDSS.EDSS_COMMENTS='$STDTL_SEARCH_staffcommentstxt'AND EDSS.EMP_ID=ED.EMP_ID AND ULD.ULD_ID=EDSS.ULD_ID");
            $this->db->order_by("EDSS.EMP_ID", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
    }
    public  function Staff_Detail_pdf($STDTL_SEARCH_staffexpense_selectquery,$STDTL_SEARCH_cpfnumber,$STDTL_SEARCH_cpffrom_form,$STDTL_SEARCH_cpfto_form,$STDTL_SEARCH_staffcommentstxt,$emp_first_name,$emp_last_name){
        $values_array=$this->fetch_data($STDTL_SEARCH_staffexpense_selectquery,$STDTL_SEARCH_cpfnumber,$STDTL_SEARCH_cpffrom_form,$STDTL_SEARCH_cpfto_form,$STDTL_SEARCH_staffcommentstxt,$emp_first_name,$emp_last_name);
        $ET_SRC_UPD_DEL_table_header='<table id="STDTL_SEARCH_tble_htmltable" border="1"  cellspacing="0" class="srcresult" style="width:1500px;border-collapse: collapse;" ><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;"><tr><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">EMPLOYEE NAME</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:20px">CPF NUMBER</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:20px">CPF AMOUNT</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:20px">LEVY AMOUNT</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:20px">SALARY AMOUNT</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:190px">COMMENTS</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;;width:130px">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">TIMESTAMP</th></tr></thead><tbody>';
        for($j=0;$j<count($values_array);$j++){
            $STDTL_SEARCH_values=$values_array[$j];
            $STDTL_SEARCH_firstname=$values_array[$j]->EMP_FIRST_NAME;
            $STDTL_SEARCH_lastname=$values_array[$j]->EMP_LAST_NAME;
            $STDTL_SEARCH_cpfno=$values_array[$j]->cpfnumber;
            if(($STDTL_SEARCH_cpfno==null)||($STDTL_SEARCH_cpfno=='undefined'))
            {
                $STDTL_SEARCH_cpfno='';
            }
            $STDTL_SEARCH_cpfamount=$values_array[$j]->cpfamount;
            if(($STDTL_SEARCH_cpfamount==null)||($STDTL_SEARCH_cpfamount=='undefined'))
            {
                $STDTL_SEARCH_cpfamount='';
            }
            $STDTL_SEARCH_levyamount=$values_array[$j]->levyamount;
            if(($STDTL_SEARCH_levyamount==null)||($STDTL_SEARCH_levyamount=='undefined'))
            {
                $STDTL_SEARCH_levyamount='';
            }
            $STDTL_SEARCH_comments=$values_array[$j]->comments;
            if(($STDTL_SEARCH_comments==null)||($STDTL_SEARCH_comments=='undefined'))
            {
                $STDTL_SEARCH_comments='';
            }
            $STDTL_INPUT_names_concat=$STDTL_SEARCH_firstname.' '.$STDTL_SEARCH_lastname;
            $ET_SRC_UPD_DEL_table_header.='<tr><td>'.$STDTL_INPUT_names_concat.'</td><td >'.$STDTL_SEARCH_cpfno.'</td><td >'.$STDTL_SEARCH_cpfamount.'</td><td >'.$STDTL_SEARCH_levyamount.'</td><td >'.$STDTL_SEARCH_values->salaryamount.'</td><td >'.$STDTL_SEARCH_comments.'</td><td>'.$STDTL_SEARCH_values->userstamp.'</td><td>'.$STDTL_SEARCH_values->timestamp.'</td></tr>';
        }
        $ET_SRC_UPD_DEL_table_header.='</tbody></table>';
        return $ET_SRC_UPD_DEL_table_header;
    }
    //INLINE SUBJECT UPDATE
    public  function update_data($USERSTAMP,$id,$STDTL_SEARCH_cpfnumber,$STDTL_SEARCH_cpfamount,$STDTL_SEARCH_levyamount,$STDTL_SEARCH_salaryamount,$STDTL_SEARCH_comments)
    {
        if($STDTL_SEARCH_cpfnumber==''){
            $STDTL_SEARCH_cpfnumber='null';
        }
        else{
            $STDTL_SEARCH_cpfnumber="'$STDTL_SEARCH_cpfnumber'";
        }
        if($STDTL_SEARCH_cpfamount==''){
            $STDTL_SEARCH_cpfamount='null';
        }
        else{
            $STDTL_SEARCH_cpfamount="'$STDTL_SEARCH_cpfamount'";
        }
        if($STDTL_SEARCH_levyamount==''){
            $STDTL_SEARCH_levyamount='null';
        }
        else{
            $STDTL_SEARCH_levyamount="'$STDTL_SEARCH_levyamount'";
        }
        if($STDTL_SEARCH_salaryamount==''){
            $STDTL_SEARCH_salaryamount='null';
        }
        else{
            $STDTL_SEARCH_salaryamount="'$STDTL_SEARCH_salaryamount'";
        }
        if($STDTL_SEARCH_comments==''){
            $STDTL_SEARCH_comments='null';
        }
        else{
            $STDTL_SEARCH_comments="'$STDTL_SEARCH_comments'";
        }
        $updatequery = "UPDATE EXPENSE_DETAIL_STAFF_SALARY SET EDSS_CPF_NUMBER=$STDTL_SEARCH_cpfnumber,EDSS_CPF_AMOUNT=$STDTL_SEARCH_cpfamount,EDSS_LEVY_AMOUNT=$STDTL_SEARCH_levyamount,EDSS_SALARY_AMOUNT=$STDTL_SEARCH_salaryamount,EDSS_COMMENTS=$STDTL_SEARCH_comments,ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP') WHERE EDSS_ID='$id'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
    public function deleteoption($USERSTAMP,$rowid)
    {
        $deletestmt = "CALL SP_CONFIG_CHECK_TRANSACTION(41,$rowid,@DELETION_FLAG)";
        $this->db->query($deletestmt);
        $STDTL_SEARCH_delete_flag = 'SELECT @DELETION_FLAG as DELETION_FLAG';
        $query = $this->db->query($STDTL_SEARCH_delete_flag);
        $successflag=$query->result();
        return $successflag;
    }
    //SINGLE ROW DELETION PROCESS CALLING EILIB  FUNCTION
    public function DeleteRecord($USERSTAMP,$rowid)
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $deleteflag=$this->Mdl_eilib_common_function->DeleteRecord(41,$rowid,$USERSTAMP);
        return $deleteflag;
    }
    //FUNCTION FOR ALREADY EXIT
    public function updcpfno_exists($tdvalue)
    {
        $EP_ENTRY_alreadyemailid = "SELECT EDSS_ID FROM EXPENSE_DETAIL_STAFF_SALARY WHERE EDSS_CPF_NUMBER='$tdvalue' ";
        $this->db->query($EP_ENTRY_alreadyemailid);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
    public function STDTL_SEARCH_comments(){
        $this->db->select("EDSS.EDSS_COMMENTS");
        $this->db->from("EXPENSE_DETAIL_STAFF_SALARY EDSS,EMPLOYEE_DETAILS ED");
        $this->db->where("EDSS.EMP_ID=ED.EMP_ID AND EDSS.EDSS_COMMENTS IS NOT NULL");
        $this->db->order_by("EDSS.EDSS_COMMENTS", "ASC");
        $STDTL_SEARCH_COMMENTS = $this->db->get();
        foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
        {
            $STDTL_SEARCH_autocomplete[]=$row['EDSS_COMMENTS'];
        }
        return $STDTL_SEARCH_autocomplete;
    }
}