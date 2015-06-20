<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 26/5/15
 * Time: 4:30 PM
 */

class Mdl_customer_expiry_list extends CI_Model{


    public function CEXP_get_initial_values(){
        $CEXP_errorAarray=array();
        $CEXP_select_err_msg="80,81,82,83,84,85,86,87,88,89,282,256";
        $this->load->model("EILIB/Mdl_eilib_common_function");
        $CEXP_errorAarray=$this->Mdl_eilib_common_function->getErrorMessageList($CEXP_select_err_msg);
        $this->db->select();
        $this->db->from('CUSTOMER');
        $CEXP_select_customer=$this->db->get();
        $CEXP_custAarray=array();
        foreach($CEXP_select_customer->result_array() as $row){
           $CEXP_custAarray[]=$row["CUSTOMER_ID"];
        }
        $CEXP_max_date_array=array();
        $CEXP_select_max_date="SELECT MAX(CLP_ENDDATE) as CLP_ENDDATE FROM CUSTOMER_LP_DETAILS";
        $CEXP_select_maxdate_rs=$this->db->query($CEXP_select_max_date);
        foreach($CEXP_select_maxdate_rs->result_array() as $row){
           $CEXP_max_date_array[]=($row["CLP_ENDDATE"]);
        }
       //-----------------CODING TO GET EMAIL LIST FROM DATABASE----------------------------//
       $CWEXP_email_array=$this->Mdl_eilib_common_function->getProfileEmailId('EXPIRY');
       $CEXP_initial_values_array=array();
       $CEXP_initial_values=(object)['CEXP_error_msg'=>$CEXP_errorAarray,'CEXP_emailid'=>$CWEXP_email_array,'CEXP_custAarray'=>$CEXP_custAarray,'CEXP_max_date_array'=>$CEXP_max_date_array];
       $CEXP_initial_values_array[]=($CEXP_initial_values);
       return $CEXP_initial_values_array;

    }
    //FUNCTION TO GET CUSTOMER DATA'S FROM DATABASE---------------------
    public function CEXP_get_customer_details($fromdate,$todate,$radiovalue,$UserStamp,$timeZoneFormat){
        $CEXP_fromdate=date('Y-m-d',strtotime($fromdate));
        $CEXP_todate=date('Y-m-d',strtotime($todate));
        $CEXP_check_radio_value=$radiovalue;
        $CEXP_cust_id_array=[];
        $CEXP_final_expiry_result=array();
        //TO CHECK EQUAL DATE
        if($CEXP_check_radio_value=="EQUAL"){
            $CEXP_temptable_query=("CALL SP_CUSTOMER_EXPIRY('1','".$CEXP_fromdate."',NULL,'".$UserStamp."',@CEXP_EQUALFEETMPTBLNAM)");
            $this->db->query($CEXP_temptable_query);
            $CEXP_equalfeetemptbl_query="SELECT @CEXP_EQUALFEETMPTBLNAM AS TEMP_TABLE";
            $outparm_result = $this->db->query($CEXP_equalfeetemptbl_query);
            $CEXP_equaltemptblname=$outparm_result->row()->TEMP_TABLE;
            $this->db->select("UNITNO,CUSTOMERFIRSTNAME,CUSTOMERLASTNAME,STARTDATE,ENDDATE,DEPOSIT,PAYMENT,PROCESSINGFEE,ROOMTYPE,EXTENSIONFLAG,RECHECKINGFLAG,COMMENTS,PRETERMINATEDATE,USERSTAMP,DATE_FORMAT(CONVERT_TZ(EXPIRY_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS EXPIRY_TIMESTAMP");
            $this->db->from("$CEXP_equaltemptblname");
            $CEXP_expirylist_rs=$this->db->get();
            $tablename=$CEXP_equaltemptblname;

        }
        //TO CHECK ON OR BEFORE DATE
        if($CEXP_check_radio_value=="BEFORE"){

            $CEXP_temptable_query=("CALL SP_CUSTOMER_EXPIRY('2','".$CEXP_fromdate."',NULL,'".$UserStamp."',@CEXP_BEFOREFEETMPTBLNAM)");
            $this->db->query($CEXP_temptable_query);
            $CEXP_beforefeetemptbl_query="SELECT @CEXP_BEFOREFEETMPTBLNAM AS TEMP_TABLE";
            $CEXP_beforefeetemptblres=$this->db->query($CEXP_beforefeetemptbl_query);
            $CEXP_beforetemptblname=$CEXP_beforefeetemptblres->row()->TEMP_TABLE;
            $this->db->select("UNITNO,CUSTOMERFIRSTNAME,CUSTOMERLASTNAME,STARTDATE,ENDDATE,DEPOSIT,PAYMENT,PROCESSINGFEE,ROOMTYPE,EXTENSIONFLAG,RECHECKINGFLAG,COMMENTS,PRETERMINATEDATE,USERSTAMP,DATE_FORMAT(CONVERT_TZ(EXPIRY_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS EXPIRY_TIMESTAMP");
            $this->db->from("$CEXP_beforetemptblname");
            $CEXP_expirylist_rs=$this->db->get();
            $tablename=$CEXP_beforetemptblname;
        }
        //TO CHECK BETWEEN DATE
        if($CEXP_check_radio_value=="BETWEEN"){

            $CEXP_temptable_query=("CALL SP_CUSTOMER_EXPIRY('3','".$CEXP_fromdate."','".$CEXP_todate."','".$UserStamp."',@CEXP_BETWEENFEETMPTBLNAM)");
            $this->db->query($CEXP_temptable_query);
            $CEXP_betweenfeetemptbl_query="SELECT @CEXP_BETWEENFEETMPTBLNAM as TEMP_TABLE";
            $CEXP_betweenfeetemptblres=$this->db->query($CEXP_betweenfeetemptbl_query);
            $CEXP_betweentemptblname=$CEXP_betweenfeetemptblres->row()->TEMP_TABLE;
            $this->db->select("UNITNO,CUSTOMERFIRSTNAME,CUSTOMERLASTNAME,STARTDATE,ENDDATE,DEPOSIT,PAYMENT,PROCESSINGFEE,ROOMTYPE,EXTENSIONFLAG,RECHECKINGFLAG,COMMENTS,PRETERMINATEDATE,USERSTAMP,DATE_FORMAT(CONVERT_TZ(EXPIRY_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS EXPIRY_TIMESTAMP");
            $this->db->from("$CEXP_betweentemptblname");
            $CEXP_expirylist_rs=$this->db->get();
             $tablename=$CEXP_betweentemptblname;
        }

       foreach($CEXP_expirylist_rs->result_array() as $row)
        {
            $CEXP_unitno = $row["UNITNO"];
            $CEXP_firstname = $row["CUSTOMERFIRSTNAME"];
            $CEXP_lastname = $row["CUSTOMERLASTNAME"];
            $CEXP_startdate = $row["STARTDATE"];
            $CEXP_enddate = $row["ENDDATE"];
            $CEXP_deposit = $row["DEPOSIT"];
            if($CEXP_deposit==null){ $CEXP_deposit=""; }
            $CEXP_rental = $row["PAYMENT"];
            $CEXP_processingfee = $row["PROCESSINGFEE"];
            if($CEXP_processingfee==null){ $CEXP_processingfee=""; }
            $CEXP_roomtype = $row["ROOMTYPE"];
            $CEXP_extension= $row["EXTENSIONFLAG"];
            if($CEXP_extension==null){ $CEXP_extension=""; }
            $CEXP_rechk = $row["RECHECKINGFLAG"];
            if($CEXP_rechk==null){ $CEXP_rechk=""; }
            $CEXP_comments = $row["COMMENTS"];
            if($CEXP_comments==null){ $CEXP_comments=""; }
            $CEXP_userstamp = $row["USERSTAMP"];
            $CEXP_timestamp = ($row["EXPIRY_TIMESTAMP"]);
            $CEXP_preterminatedate = $row["PRETERMINATEDATE"];
            if($CEXP_preterminatedate==null){ $CEXP_preterminatedate=""; }
            $CEXP_expiry_result=(object)['unitno'=>$CEXP_unitno,'firstname'=>$CEXP_firstname,'lastname'=>$CEXP_lastname,'roomtype'=>$CEXP_roomtype,'extension'=>$CEXP_extension,'rechecking'=>$CEXP_rechk,'rental'=>$CEXP_rental,'comments'=>$CEXP_comments,'userstamp'=>$CEXP_userstamp,'timestamp'=>$CEXP_timestamp,'startdate'=>$CEXP_startdate,'enddate'=>$CEXP_enddate,'preterminatedate'=>$CEXP_preterminatedate,'deposit'=>$CEXP_deposit];
            $CEXP_final_expiry_result[]=($CEXP_expiry_result);
        }
        $drop_query = "DROP TABLE ".$tablename;
        $this->db->query($drop_query);
        return $CEXP_final_expiry_result;
    }
    //FUNCTION TO SEND WEEKLY CUSTOMER EXPIRY LIST-----------//
    public  function CWEXP_get_customerdetails($CWEXP_weekBefore,$CWEXP_email_id,$UserStamp,$timeZoneFormat){
        $CWEXP_weekBefore=$CWEXP_weekBefore;
        $CWEXP_email_id=$CWEXP_email_id;
        $CWEXP_mail_username=explode('@',$CWEXP_email_id);//CWEXP_email_id.split('@');
        $CWEXP_select_emaildata="SELECT * from EMAIL_TEMPLATE_DETAILS WHERE ET_ID=3";
        $CWEXP_emaildata_rs=$this->db->query($CWEXP_select_emaildata);//CWEXP_emaildata_stmt.executeQuery(CWEXP_select_emaildata);
        foreach($CWEXP_emaildata_rs->result_array() as $row){
            $CWEXP_subject_db=$row["ETD_EMAIL_SUBJECT"];
            $CWEXP_message_db=$row["ETD_EMAIL_BODY"];
        }
        $CWEXP_subject=str_replace('[WEEKS_AHEAD]', $CWEXP_weekBefore,$CWEXP_subject_db);//CWEXP_subject_db.replace("[WEEKS_AHEAD]", CWEXP_weekBefore);
        $CWEXP_message=str_replace('[WEEK_AHEAD]', $CWEXP_weekBefore,$CWEXP_message_db);//CWEXP_message_db.replace("'[WEEK_AHEAD]'",CWEXP_weekBefore);
        if($CWEXP_weekBefore==1){
            $CWEXP_subject=str_replace("WEEKS", 'WEEK',$CWEXP_subject);//CWEXP_subject.replace("WEEKS", 'WEEK');
            $CWEXP_message=str_replace("WEEKS", 'WEEK',$CWEXP_message);//CWEXP_message.replace("WEEKS", 'WEEK');
        }
        $CWEXP_message=str_replace('[MAILID_USERNAME]',strtoupper($CWEXP_mail_username[0]),$CWEXP_message);//.replace('[MAILID_USERNAME]',CWEXP_mail_username[0].toUpperCase());
        $CWEXP_emailmessage = '<body>'.'<br>'.'<h> '.$CWEXP_message.' </h>'.'<br>'.'<br>'.'<table border="1" style="color:white" width="700">'.'<tr  bgcolor="#498af3" align="center">'.'<td width=25% ><h3>UNIT NO</h3></td>'.'<td width=25%><h3>CUSTOMER NAME</h3></td>'.'<td width=25%><h3>END DATE</h3></td>'.'<td width=25%><h3>RENT</h3></td>'.'</tr>'.'</table>'.'</body>';
        $CWEXP_check_week_flag=0;
        $CWEXP_check_weekly_expiry_list='';
        $CEXP_temptable_query=("CALL SP_CUSTOMER_WEEKLY_EXPIRY('".$CWEXP_weekBefore."','".$UserStamp."',@CEXP_WEEKLYFEETMPTBLNAM)");
        $this->db->query($CEXP_temptable_query);
        $CEXP_beforefeetemptbl_query="SELECT @CEXP_WEEKLYFEETMPTBLNAM AS TEMP_TABLE";
        $CEXP_beforefeetemptblres=$this->db->query($CEXP_beforefeetemptbl_query);
        $CEXP_weeklytemptblname=$CEXP_beforefeetemptblres->row()->TEMP_TABLE;
        $CEXP_select_customerdetails="SELECT * FROM ".$CEXP_weeklytemptblname."";
        $CWEXP_customerdetails_result=$this->db->query($CEXP_select_customerdetails);
        foreach($CWEXP_customerdetails_result->result_array() as $row){
            $CWEXP_unitno = $row["UNITNO"];
            $CWEXP_firstname = $row["CUSTOMERFIRSTNAME"];
            $CWEXP_lastname = $row["CUSTOMERLASTNAME"];
            $CWEXP_rental = $row["PAYMENT"];
            $CWEXP_cust_name=$CWEXP_firstname.' '.$CWEXP_lastname;
            $CWEXP_enddate = $row["ENDDATE"];
            $CWEXP_ptddate=$row["PRETERMINATEDATE"];
            if($CWEXP_ptddate==null){
                $CWEXP_newdate=date('d-m-Y',strtotime($CWEXP_enddate));
            }
            else{
                $CWEXP_newdate=date('d-m-Y',strtotime($CWEXP_ptddate));
            }
            $CWEXP_check_week_flag=1;
            $CWEXP_emailmessage .= '<body><table border="1" width="700" ><tr align="center"><td width=25%>'.$CWEXP_unitno.'</td>'.'<td width=25%>'.$CWEXP_cust_name.'</td><td width=25%>'.$CWEXP_newdate.'</td><td width=25%>'.$CWEXP_rental.'</td>'.'</tr>'.'</table>'.'</body>';
        }
        $this->CEXP_droptemptable($CEXP_weeklytemptblname);
        $final_array=[$CWEXP_check_week_flag,$CWEXP_emailmessage,$CWEXP_subject];
        return $final_array;
//        if($CWEXP_check_week_flag==0){
//            $CWEXP_check_weekly_expiry_list='false';
//            return $CWEXP_check_weekly_expiry_list;
//        }
//        else{
//            //           $displayname=eilib.Get_MailDisplayName('CUSTOMER_EXPIRY')
//            //           MailApp.sendEmail(CWEXP_email_id,CWEXP_subject,CWEXP_emailmessage,{name:displayname,htmlBody:CWEXP_emailmessage});
//             $CWEXP_check_weekly_expiry_list='true';
//             return $CWEXP_check_weekly_expiry_list;
//        }
    }
    function CEXP_droptemptable($tablename){
        $drop_query = "DROP TABLE ".$tablename;
        $this->db->query($drop_query);
    }
    function Customer_Expiry_List_pdf($fromdate,$todate,$radiovalue,$UserStamp,$timeZoneFormat){

        $values=$this->CEXP_get_customer_details($fromdate,$todate,$radiovalue,$UserStamp,$timeZoneFormat);
        $values_array=$values;
        $CEXP_table_value='<table id="CEXP_tbl_htmltable" border="1"  cellspacing="0" class="srcresult" style="width:3000px" style="border-collapse: collapse;"><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;"><tr><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">UNIT NO</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">FIRST NAME</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">LAST NAME</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:80px" >START DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:80px">END DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:80px">PRETERMINATE DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold; width:130px">ROOM TYPE</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">EXTENSION</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">RE CHECKIN</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">RENT</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">DEPOSIT</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:500px">COMMENTS</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th style="width:180px" style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        for($j=0;$j<count($values);$j++){
            $CEXP_values=$values[$j];
            $unitno=$CEXP_values->unitno;
            $CEXP_startdate=$CEXP_values->startdate;
            $CEXP_startdate=date('d-m-Y',strtotime($CEXP_startdate));
            $CEXP_enddate=$CEXP_values->enddate;
            $CEXP_enddate=date('d-m-Y',strtotime($CEXP_enddate));
            $CEXP_preterminatedate=$CEXP_values->preterminatedate;
            if($CEXP_preterminatedate!=""){
                $CEXP_preterminatedate=date('d-m-Y',strtotime($CEXP_preterminatedate));
            }
            $CEXP_table_value.='<tr ><td nowarp>'.$unitno.'</td><td nowrap>'.$CEXP_values->firstname.'</td><td nowrap>'.$CEXP_values->lastname.'</td><td nowrap align="center" >'.$CEXP_startdate.'</td><td nowrap align="center">'.$CEXP_enddate.'</td><td nowrap align="center">'.$CEXP_preterminatedate.'</td><td nowrap align="center">'.$CEXP_values->roomtype.'</td><td nowrap align="center">'.$CEXP_values->extension.'</td><td>'.$CEXP_values->rechecking.'</td><td nowrap align="center">'.$CEXP_values->rental.'</td><td nowrap align="center">'.$CEXP_values->deposit.'</td><td>'.$CEXP_values->comments.'</td><td nowrap align="center">'.$CEXP_values->userstamp.'</td><td nowrap align="center">'.$CEXP_values->timestamp.'</td></tr>';
        }
        $CEXP_table_value.='</tbody></table>';
        return $CEXP_table_value;
    }
} 