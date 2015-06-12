<?php
class Mdl_unit_door_code_search_update extends CI_Model{
    public function Initial_data(){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList('2,18,22,324,396,401,463,464,466,467');
        $result1=$this->Mdl_eilib_common_function->GetActiveUnit();
        $UT_result=(object)["DCSU_errorarray"=>$ErrorMessage,"DCSU_unitno"=>$result1];
        return $UT_result;
    }
    public function DCSU_login_details($DCSU_unitnumber,$DCSU_flag,$timeZoneFormat){
        $DCSU_unitno_select="SELECT * FROM UNIT WHERE UNIT_NO=".$DCSU_unitnumber;
        $DCSU_unitno_rs=$this->db->query($DCSU_unitno_select);
        $DCSU_unitno='';
        if($DCSU_unitno_rs->num_rows()>0)
        {
            $DCSU_unitno=$DCSU_unitno_rs->row()->UNIT_ID;
        }
        $DCSU_login_select="SELECT ULDTL.ULDTL_ID,ULDTL.ULDTL_DOORCODE,ULDTL.ULDTL_WEBLOGIN,ULDTL.ULDTL_WEBPWD,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ULDTL.ULDTL_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT_LOGIN_DETAILS ULDTL,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=ULDTL.ULD_ID AND UNIT_ID=".$DCSU_unitno;
        $DCSU_login_rs=$this->db->query($DCSU_login_select);
        $DCSU_array_login='';
        if($DCSU_login_rs->num_rows()>0)
        {
            foreach($DCSU_login_rs->result_array() as $row){
                $DCSU_id = $row["ULDTL_ID"];
                $DCSU_doorcode = $row["ULDTL_DOORCODE"];
                $DCSU_weblogin = $row["ULDTL_WEBLOGIN"];
                $DCSU_webpass = $row["ULDTL_WEBPWD"];
                $DCSU_userstamp = $row["ULD_LOGINID"];
                $DCSU_timestamp = $row["TIMESTAMP"];
                if($DCSU_doorcode==null)
                    $DCSU_doorcode='';
                if($DCSU_weblogin==null)
                    $DCSU_weblogin='';
                if($DCSU_webpass==null)
                    $DCSU_webpass='';
                $DCSU_array_login=(object)["DCSU_id"=>$DCSU_id,"DCSU_doorcode"=>$DCSU_doorcode,"DCSU_weblog"=>$DCSU_weblogin,"DCSU_webpass"=>$DCSU_webpass,"DCSU_user"=>$DCSU_userstamp,"DCSU_time"=>$DCSU_timestamp,"DCSU_flg"=>$DCSU_flag];
            }
        }
        return $DCSU_array_login;
    }
    public function DCSU_update_Doorcode($DCSU_login_id,$DCSU_unitnumber,$DCSU_doorcode,$DCSU_weblogin,$DCSU_webpass,$UserStamp,$timeZoneFormat){
        if($DCSU_weblogin!=''){
            $DCSU_weblogin=$this->db->escape_like_str($DCSU_weblogin);
        }
        $DCSU_creatstmtLogin ="CALL SP_UNIT_LOGIN_DOORCODE_UPDATE(".$DCSU_unitnumber.",'".$DCSU_doorcode."','".$DCSU_weblogin."','".$DCSU_webpass."','".$UserStamp."',@FLAG)";
        $this->db->query($DCSU_creatstmtLogin);
        $DCSU_flag_rs=$this->db->query("SELECT @FLAG AS FLAG");
        $DCSU_flag=$DCSU_flag_rs->row()->FLAG;
        $DCSU_refresh=$this->DCSU_login_details($DCSU_unitnumber,$DCSU_flag,$timeZoneFormat);
        return $DCSU_refresh;
    }
    public function DCSU_table_pdf($DCSU_unitnumber,$timeZoneFormat){
        $DCSU_unitno_select="SELECT * FROM UNIT WHERE UNIT_NO=".$DCSU_unitnumber;
        $DCSU_unitno_rs=$this->db->query($DCSU_unitno_select);
        $DCSU_unitno='';
        if($DCSU_unitno_rs->num_rows()>0)
        {
            $DCSU_unitno=$DCSU_unitno_rs->row()->UNIT_ID;
        }
        $DCSU_login_select="SELECT ULDTL.ULDTL_ID,ULDTL.ULDTL_DOORCODE,ULDTL.ULDTL_WEBLOGIN,ULDTL.ULDTL_WEBPWD,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ULDTL.ULDTL_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT_LOGIN_DETAILS ULDTL,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=ULDTL.ULD_ID AND UNIT_ID=".$DCSU_unitno;
        $DCSU_login_rs=$this->db->query($DCSU_login_select);
        $DCSU_table_login='<br><table width="1000px" id="DCSU_tble_htmltable" border="1" style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult"><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead bgcolor="#6495ed" style="color:white;"><tr><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">DOOR CODE </th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:130px">WEB LOGIN</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">WEB PASSWORD</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:300px">USERSTAMP</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:150px">TIMESTAMP</th></tr></thead><tbody>';
        if($DCSU_login_rs->num_rows()>0)
        {
            foreach($DCSU_login_rs->result_array() as $row){
                $DCSU_doorcode = $row["ULDTL_DOORCODE"];
                $DCSU_weblogin = $row["ULDTL_WEBLOGIN"];
                $DCSU_webpass = $row["ULDTL_WEBPWD"];
                $DCSU_userstamp = $row["ULD_LOGINID"];
                $DCSU_timestamp = $row["TIMESTAMP"];
                if($DCSU_doorcode==null)
                    $DCSU_doorcode='';
                if($DCSU_weblogin==null)
                    $DCSU_weblogin='';
                if($DCSU_webpass==null)
                    $DCSU_webpass='';
                $DCSU_table_login.='<tr><td style="text-align: center" class="data">'.$DCSU_doorcode.'</td><td class="data" style="text-align: center">'.$DCSU_weblogin.'</td><td class="data" style="text-align: center">'.$DCSU_webpass.'</td><td>'.$DCSU_userstamp.'</td><td style="text-align: center">'.$DCSU_timestamp.'</td></tr>';
            }
        }
        $DCSU_table_login.='</tbody></table>';
        return $DCSU_table_login;
    }
}