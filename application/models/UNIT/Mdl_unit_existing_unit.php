<?php
//******************************************Existing Unit********************************************//
//VER 0.02-SD:25/05/2015 ED:25/05/2015,did save part BY RAJA
//VER 0.01-SD:22/05/2015 ED:23/05/2015,completed form design and validation BY RAJA
//*******************************************************************************************************//
class Mdl_unit_existing_unit extends CI_Model{
    public function Initial_data($EU_unitno,$EU_flag_unitno_err_roomstamp){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $EU_TB_roombox=[];
        $EU_TB_stampbox=[];
        $EU_arr_nonactive=[];
        $ErrorMessage='';
        $EU_unitnoarr='';
        if($EU_flag_unitno_err_roomstamp=='EU_flag_unitno_errormsg'){
            $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList('2,8,10,3,14,30,308,316,324,399,401,463,464,466,467');
            $EU_unitnoarr=$this->Mdl_eilib_common_function->GetActiveUnit();
            $EU_select_nonactive = "SELECT * FROM VW_NON_ACTIVE_UNIT ORDER BY UNIT_NO ASC";
            $EU_rs_nonactive = $this->db->query($EU_select_nonactive);
            foreach($EU_rs_nonactive->result_array() as $row)
            {
                $EU_arr_nonactive[]=($row["UNIT_NO"]);
            }
        }
        else if(($EU_flag_unitno_err_roomstamp=='EU_flag_roomstamp')||($EU_flag_unitno_err_roomstamp=='EU_flag_deposit_roomstamp')||($EU_flag_unitno_err_roomstamp=='EU_flag_roomtype')||($EU_flag_unitno_err_roomstamp=='EU_flag_stamptype')){
            $EU_select_query_room_type = "SELECT URTD_ROOM_TYPE FROM UNIT_ROOM_TYPE_DETAILS WHERE URTD_ROOM_TYPE IS NOT NULL AND URTD_ID NOT IN(SELECT distinct URTD_ID FROM UNIT_ACCESS_STAMP_DETAILS WHERE UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO=".$EU_unitno.") AND URTD_ID IS NOT NULL) ORDER BY URTD_ROOM_TYPE ASC";
            $EU_roomtype_rs = $this->db->query($EU_select_query_room_type);
            foreach($EU_roomtype_rs->result_array() as $row)
            {
                $EU_all_room_type = $row["URTD_ROOM_TYPE"];
                $EU_TB_roombox[]=($EU_all_room_type);
            }
            $EU_select_query_stamp_type="SELECT USDT_DATA FROM UNIT_STAMP_DUTY_TYPE WHERE USDT_DATA IS NOT NULL AND USDT_ID NOT IN(SELECT distinct USDT_ID FROM UNIT_ACCESS_STAMP_DETAILS WHERE UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO=".$EU_unitno.") AND USDT_ID IS NOT NULL) ORDER BY USDT_DATA ASC";
            $EU_stamptype_rs =$this->db->query($EU_select_query_stamp_type);
            foreach($EU_stamptype_rs->result_array() as $row)
            {
                $EU_all_stamp_type = $row["USDT_DATA"];
                $EU_TB_stampbox[]=($EU_all_stamp_type);
            }
        }
        $EU_result=(object)["EU_errarray"=>$ErrorMessage,"EU_roomtype"=>$EU_TB_roombox,"EU_stamp"=>$EU_TB_stampbox,"EU_unitno"=>$EU_unitnoarr,"EU_nonactive"=>$EU_arr_nonactive,"EU_unitno_flag"=>$EU_unitno,"EU_unitno_err_roomstamp_flag"=>$EU_flag_unitno_err_roomstamp];
        return [$EU_result];
    }
    public function EU_already_exists($EU_alreadyexist,$EU_source){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $EU_flag=[];
        if($EU_source=="EU_tb_accesscard"){
            $EU_flag=$this->Mdl_eilib_common_function->Check_ExistsCard($EU_alreadyexist);
        }
        else if($EU_source=="EU_tb_newroomtype"){
          $UC_chkroomtype='';
          $UC_chkroomtype=$this->db->escape_like_str($EU_alreadyexist);
          $EU_flag=$this->Mdl_eilib_common_function->Check_ExistsRmType($UC_chkroomtype);
        }
        else if($EU_source=="EU_tb_newstamptype"){
            $UC_chkstamptype='';
            $UC_chkstamptype=$this->db->escape_like_str($EU_alreadyexist);
            $EU_flag=$this->Mdl_eilib_common_function->Check_ExistsStampduty($UC_chkstamptype);
        }
        else if(($EU_source=="UNIT_tb_doorcode")||($EU_source=="UNIT_tb_weblogin")){
            $EU_flag[0]=1;
            $EU_flag=$this->Mdl_eilib_common_function->Check_ExistsDoorcodeLogin($EU_alreadyexist,$EU_source);
        }
        return $EU_flag;
    }
    public function Login_acct_others($EU_unitnumber,$EU_source){
        $EU_unitno_select="SELECT * FROM UNIT WHERE UNIT_NO=".$EU_unitnumber;
        $EU_unitno_rs=$this->db->query($EU_unitno_select);
        $EU_unitno=$EU_unitno_rs->row()->UNIT_ID;
        if($EU_source=='EU_radio_doorloginpswd')
        {
            $EU_doorcode=null; $EU_weblogin=null; $EU_webpass=null;
            $EU_login_select="SELECT * FROM UNIT_LOGIN_DETAILS WHERE UNIT_ID=".$EU_unitno;
            $EU_login_rs=$this->db->query($EU_login_select);
            $EU_array_login='';
            foreach($EU_login_rs->result_array() as $row)
            {
                $EU_doorcode = $row["ULDTL_DOORCODE"];
                $EU_weblogin = $row["ULDTL_WEBLOGIN"];
                $EU_webpass = $row["ULDTL_WEBPWD"];
            }
            $EU_array_login=(object)["EU_dcode"=>$EU_doorcode,"EU_weblogin"=>$EU_weblogin,"EU_webpass"=>$EU_webpass];
            return $EU_array_login;
        }
        else if($EU_source=='EU_radio_acctdetails')
        {
            $EU_array_acct=[];
            $EU_acctno=null; $EU_acctname=null; $EU_bankcode=null; $EU_branchcode=null; $EU_bankaddrs=null;
            $EU_radio_select="SELECT * FROM UNIT_ACCOUNT_DETAILS WHERE UNIT_ID=".$EU_unitno;
            $EU_radio_rs=$this->db->query($EU_radio_select);
            foreach($EU_radio_rs->result_array() as $row)
            {
                $EU_acctno = $row["UACD_ACC_NO"];
                $EU_acctname = $row["UACD_ACC_NAME"];
                $EU_bankcode = $row["UACD_BANK_CODE"];
                $EU_branchcode = $row["UACD_BRANCH_CODE"];
                $EU_bankaddrs = $row["UACD_BANK_ADDRESS"];
            }
            $EU_array_acct=(object)["EU_acctnum"=>$EU_acctno,"EU_acctname"=>$EU_acctname,"EU_bankcode"=>$EU_bankcode,"EU_branchcode"=>$EU_branchcode,"EU_bankaddress"=>$EU_bankaddrs];
            return $EU_array_acct;
        }
        else if($EU_source=='EU_radio_others')
        {
            $EU_others_select="SELECT * FROM UNIT_DETAILS WHERE UNIT_ID=".$EU_unitno;
            $EU_others_rs=$this->db->query($EU_others_select);
            $EU_deposit='';
            foreach($EU_others_rs->result_array() as $row)
            {
                $EU_deposit = $row["UD_DEPOSIT"];
                if($EU_deposit==null){
                    $EU_deposit='';
                }
            }
            $EU_deposit_roomstamp=$this->Initial_data($EU_unitnumber,'EU_flag_deposit_roomstamp');
            return [$EU_deposit_roomstamp[0],$EU_deposit];
        }
    }
    public function EU_update_Form($EU_unitnumber,$EU_flag,$EU_doorcode,$EU_weblogin,$EU_webpass,$EU_accntnumber,$EU_accntname,
                                   $EU_bankcode,$EU_branchcode,$EU_bankaddrs,$EU_unitdeposite,$EU_accesscard,$EU_oldroomtype,$EU_newroomtype,$EU_stampdutydate,$EU_oldstamptype,
                                   $EU_newstamptype,$EU_stampamount,$EU_comments,$UserStamp){
        $EU_finalroomtype='';
        $EU_finalstamptype='';
        if($EU_newroomtype!=''){
            $EU_finalroomtype =$EU_newroomtype;
        }
        elseif($EU_oldroomtype!=''){
            $EU_finalroomtype =$EU_oldroomtype;
        }
        if($EU_newstamptype!=''){
            $EU_finalstamptype =$EU_newstamptype;
        }
        elseif($EU_oldstamptype!=''){
            $EU_finalstamptype =$EU_oldstamptype;
        }
        if(($EU_finalroomtype=='SELECT')||($EU_finalroomtype=='')){
            $EU_finalroomtype='null';
        }
        else{
            $EU_finalroomtype=$this->db->escape_like_str($EU_finalroomtype);
            $EU_finalroomtype="'".$EU_finalroomtype."'";
        }
        if(($EU_finalstamptype=='SELECT')||($EU_finalstamptype=='')){
            $EU_finalstamptype='null';
        }
        else{
            $EU_finalstamptype=$this->db->escape_like_str($EU_finalstamptype);
            $EU_finalstamptype="'".$EU_finalstamptype."'";
        }
        if($EU_stampdutydate==""){
            $EU_stampdutydate='null';
        }
        else
        {
            $EU_stampdate_string = explode("-",$EU_stampdutydate);
            $EU_stampdutydate=$EU_stampdate_string[2].'-'.$EU_stampdate_string[1].'-'.$EU_stampdate_string[0];
            $EU_stampdutydate="'".$EU_stampdutydate."'";
        }
        $EU_alreadyexist_flag_card='';$EU_alreadyexist_flag_stamp='';$EU_alreadyexist_flag_room='';
        if($EU_unitdeposite==''){
            $EU_unitdeposite='null';
        }
        if($EU_stampamount==''){
            $EU_stampamount='null';
        }
        if(($EU_newroomtype!='')&&($EU_newroomtype!='')){
            $EU_alreadyexist_flag_room=$this->EU_already_exists($EU_newroomtype,'EU_tb_newroomtype');
        }
        if(($EU_newstamptype!='')&&($EU_newstamptype!='')){
            $EU_alreadyexist_flag_stamp=$this->EU_already_exists($EU_newstamptype,'EU_tb_newstamptype');
        }
        if($EU_accesscard==''){
            $EU_accesscard='null';
        }
        else{
            $EU_alreadyexist_flag_card=$this->EU_already_exists($EU_accesscard,'EU_tb_accesscard');
        }
        if(($EU_alreadyexist_flag_card=='true')||($EU_alreadyexist_flag_stamp=='true')||($EU_alreadyexist_flag_room=='true')){
            $EU_alreadyexist_flag=true;
            return ["EU_obj_flag_existing"=>$EU_alreadyexist_flag];
        }
        if($EU_comments!=''){
            $EU_comments=$this->db->escape_like_str($EU_comments);
        }
        if($EU_accntname!=''){
            $EU_accntname=$this->db->escape_like_str($EU_accntname);
        }
        if($EU_bankaddrs!=''){
            $EU_bankaddrs=$this->db->escape_like_str($EU_bankaddrs);
        }
        if($EU_weblogin!=''){
            $EU_weblogin=$this->db->escape_like_str($EU_weblogin);
        }
        if($EU_flag=='EU_doorlogpwd')
        {
            $EU_creatstmtLogin ="CALL SP_EXISTING_UNIT_LOGIN_DETAILS_INSERT(".$EU_unitnumber.",'".$EU_doorcode."','".$EU_weblogin."','".$EU_webpass."','".$UserStamp."',@FLAG)";
            $this->db->query($EU_creatstmtLogin);
        }
        if($EU_flag=='EU_acctdetails')
        {
            $EU_creatstmtAccount ="CALL SP_EXISTING_UNIT_ACCOUNT_DETAILS_INSERT(".$EU_unitnumber.",'".$EU_accntnumber."','".$EU_accntname."','".$EU_bankcode."','".$EU_branchcode."','".$EU_bankaddrs."','".$UserStamp."',@FLAG)";
            $this->db->query($EU_creatstmtAccount);
        }
        if($EU_flag=='EU_others')
        {
            $EU_creatstmtAccessStamp ="CALL SP_EXISTING_UNIT_ACCESS_STAMP_DETAILS_INSERT(".$EU_unitnumber.",".$EU_accesscard.",".$EU_finalroomtype.",".$EU_stampdutydate.",".$EU_finalstamptype.",".$EU_stampamount.",'".$UserStamp."',".$EU_unitdeposite.",'".$EU_comments."',@FLAG)";
            $this->db->query($EU_creatstmtAccessStamp);
        }
        $EU_flag_rs=$this->db->query("SELECT @FLAG AS FLAG");
        if($EU_flag_rs->row()->FLAG==0){
            $EU_obj_final= ["EU_obj_flag"=>0];
        }
        else{
            $EU_obj_final= ["EU_obj_flag"=>1,"EU_obj_no"=>$EU_unitnumber,"EU_obj_flag_existing"=>false];
        }
        return $EU_obj_final;
    }
}