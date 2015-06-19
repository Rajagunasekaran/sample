<?php
error_reporting(0);
class Mdl_ocbc_model_entry_search_update extends CI_Model
{
    public function getAllModels_Details($timeZoneFormat)
    {
        $MODEL_SRC_modelselect_query ="SELECT BTM.BTM_ID,BTM.BTM_DATA,BTM.BTM_OBSOLETE,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BTM.BTM_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BTM_TIME_STAMP FROM BANK_TRANSFER_MODELS BTM,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=BTM.ULD_ID ORDER BY BTM_DATA ASC";
        $resultset=$this->db->query($MODEL_SRC_modelselect_query);
        return $resultset->result();
    }
    public function ModelnameUpdation($UserStamp,$modelname,$Rowid,$Option)
    {
        if($Option=='Model')
        {
            $MODEL_SRC_updatequery="UPDATE BANK_TRANSFER_MODELS SET BTM_DATA='$modelname',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$UserStamp') WHERE BTM_ID=".$Rowid;
        }
        if($Option=='Obsolete')
        {
            $MODEL_SRC_updatequery="UPDATE BANK_TRANSFER_MODELS SET BTM_OBSOLETE='$modelname',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$UserStamp') WHERE BTM_ID=".$Rowid;
        }
        $resultset=$this->db->query($MODEL_SRC_updatequery);
        return $resultset;
    }
    public function ModelnameDeletion($UserStamp,$Rowid)
    {
        $this->db->select("BTM_ID");
        $this->db->from('BANK_TRANSFER');
        $this->db->where("BTM_ID=".$Rowid);
        $id=$this->db->get()->row()->BTM_ID;
        $returnmessage;
        if($id!='')
        {
            $MODEL_SRC_updatequery="UPDATE BANK_TRANSFER_MODELS SET BTM_OBSOLETE='X',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$UserStamp') WHERE BTM_ID=".$Rowid;
            $this->db->query($MODEL_SRC_updatequery);
            $returnmessage='UPDATED';
        }
        return $returnmessage;
    }
    public function NewModelnameInsert($UserStamp,$modelname)
    {
        $UserStamp="'".$UserStamp."'";
        $modelname="'".$modelname."'";
        $modelinsertquery="INSERT INTO BANK_TRANSFER_MODELS(BTM_DATA,ULD_ID) VALUES(".$modelname.",(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID=".$UserStamp."))";
        $result=$this->db->query($modelinsertquery);
        return $result;
    }
    public function PDF_AllModels_Details($timeZoneFormat)
    {
        $MODEL_SRC_modelselect_query ="SELECT BTM.BTM_ID,BTM.BTM_DATA,BTM.BTM_OBSOLETE,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(BTM.BTM_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS BTM_TIME_STAMP FROM BANK_TRANSFER_MODELS BTM,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=BTM.ULD_ID ORDER BY BTM_DATA ASC";
        $resultset=$this->db->query($MODEL_SRC_modelselect_query);
        $Model_data='<br>
        <table width="1000px" id="USU_tble_htmltable" border="1" style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult">
        <sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/>
        <thead bgcolor="#6495ed" style="color:white">
        <tr>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:300px">MODEL NAME</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">OBSOLETE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:200px">USERSTAMP</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:200px">TIMESTAMP</th>
        </tr>
        </thead>
        <tbody>';
        foreach ($resultset->result_array() as $key => $value)
        {
            $Model_data.='<tr>';
            $Model_data.='<td>'.$value['BTM_DATA'].'</td>';
            $Model_data.='<td style="text-align:center;">'.$value['BTM_OBSOLETE'].'</td>';
            $Model_data.='<td style="text-align:center;">'.$value['ULD_LOGINID'].'</td>';
            $Model_data.='<td style="text-align:center;">'.$value['BTM_TIME_STAMP'].'</td>';
            $Model_data.='</tr>';
        }
        $Model_data.='</body></table>';
        return $Model_data;
    }
}