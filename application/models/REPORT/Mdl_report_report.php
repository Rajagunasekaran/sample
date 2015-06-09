<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 29-05-2015
 * Time: 05:14 PM
 */

class Mdl_report_report extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
public function getDataAppendSS($reportNameVal,$reportNameText,$emailId,$categoryName,$month){
    $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
    $this->load->library('Google');
    $service = $this->Mdl_eilib_common_function->get_service_document();
//    print_r( $service);exit;
    $this->db->select("RCN_DATA");
    $this->db->from('REPORT_CONFIGURATION');
    $this->db->where("CGN_ID=48");
    $folderId = $this->db->get()->row()->RCN_DATA;
    $SSfileid = $this->Mdl_eilib_common_function->NewSpreadsheetCreation($service, $reportNameText, 'PAYMENT_DETAILS', $folderId);
    $arrQuery=[$reportNameVal=>["SELECT DISTINCT U.UNIT_NO AS UNIT_NO,ULD.ULDTL_DOORCODE AS DOOR_CODE,ULD.ULDTL_WEBLOGIN AS WEB_LOGIN,ULD.ULDTL_WEBPWD AS WEB_PASSWORD,EDSH.EDSH_SSID AS SSID,EDSH.EDSH_PWD AS PWD,USLD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ULD.ULDTL_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T') AS TIMESTAMP FROM UNIT_LOGIN_DETAILS ULD,UNIT U,USER_LOGIN_DETAILS USLD,EXPENSE_DETAIL_STARHUB EDSH WHERE USLD.ULD_ID=ULD.ULD_ID AND ULD.UNIT_ID=U.UNIT_ID AND U.UNIT_ID=EDSH.UNIT_ID ORDER BY U.UNIT_NO ASC",
        'UNIT_NO^^DOOR_CODE^^WEB_LOGIN^^WEB_PASSWORD^^SSID^^PWD^^USERSTAMP^^TIMESTAMP'],
        ""];
    $resultset=$this->db->query($arrQuery[$reportNameVal][0]);
    $splitHeader=explode('^^',$arrQuery[$reportNameVal][1]);
    $concatArray='';
    $arrDatass=[];
echo $SSfileid;
    $arrDatass = array('sheetId'=>$SSfileid,'header'=>str_replace('_'," ",$arrQuery[$reportNameVal][1]),"Fileid"=>$SSfileid,'flag'=>3);

    foreach ($resultset->result_array() as $key => $value) {
        foreach($splitHeader as $keyCol => $column){
            if($keyCol==0)
                $concatArray=$value[$splitHeader[$keyCol]];
            else
                $concatArray.='^~^'.$value[$splitHeader[$keyCol]];
       }
        $arrDatass["data".$key] = $concatArray;
    }
    $url ="https://script.google.com/macros/s/AKfycbyv58HZU2XsR2kbCMWZjNzMWSmOwoE7xsg_fesXktGk4Kj574u1/exec";
    $ch = curl_init();
    $data = http_build_query($arrDatass );
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
    try {
        $response = curl_exec($ch);
        return '**'.$response;
    } catch (Exception $e) {
        return $e->getMessage();
    }
    curl_close($ch);
    return $response;
}
    public function REP_getdomain_err(){
        $REP_searchoptions_dataid=array();
        $this->db->select('CGN_ID,CGN_TYPE');
        $this->db->from('CONFIGURATION');
        $this->db->where('CGN_ID IN(59,60,61,73,82)');
        $this->db->order_by('CGN_TYPE ASC');
        $REP_select_catagotyreport_name=$this->db->get();
//        $REP_select_catagotyreport_name="SELECT CGN_ID,CGN_TYPE FROM CONFIGURATION WHERE CGN_ID IN(59,60,61,73,82) ORDER BY CGN_TYPE ASC";
//        $REP_catagoryreport_name_stmt=REP_conn.createStatement();
//        $REP_catagoryreport_name_rs=REP_catagoryreport_name_stmt.executeQuery( REP_select_catagotyreport_name);
        foreach($REP_select_catagotyreport_name->result_array() as $row) {
            $REP_searchoptions_id = $row['CGN_ID'];
            $REP_searchoptions_data = $row['CGN_TYPE'];
            $REP_searchoptions_object = (object)["REP_searchoption_id" => $REP_searchoptions_id, "REP_searchoption_data" => $REP_searchoptions_data];
            $REP_searchoptions_dataid[]=$REP_searchoptions_object;
        }

        //REPORT NAME
        $REP_report_name_arraydataid=array();
        $this->db->select('RCN_ID,RCN_DATA');
        $this->db->from('REPORT_CONFIGURATION');
        $this->db->where('RCN_INITIALIZE_FLAG','X');
        $this->db->order_by('RCN_DATA ASC');
        $REP_select_report_name=$this->db->get();
          //        $REP_select_report_name="SELECT RCN_ID,RCN_DATA FROM REPORT_CONFIGURATION WHERE RCN_INITIALIZE_FLAG='X' ORDER BY RCN_DATA ASC";
          //        $REP_report_name_rs=REP_report_name_stmt.executeQuery( REP_select_report_name);
        foreach($REP_select_report_name->result_array() as $row)
        {
            $REP_reportname_id=$row['RCN_ID'];
            $REP_reportname_data=$row['RCN_DATA'];
            $REP_reportname_object=(object)["REP_reportnames_id"=>$REP_reportname_id,"REP_reportnames_data"=>$REP_reportname_data];
            $REP_report_name_arraydataid[]=($REP_reportname_object);
        }
              //        REP_report_name_rs.close();
              //        REP_report_name_stmt.close();
        //EMAIL ID
        $REP_emailid_array=array();
        $REP_emailid_array= $this->Mdl_eilib_common_function->getProfileEmailId('REPORT');
               //        $REP_emailid_array=eilib.getProfileEmailId(REP_conn,"REPORT")
    //RETRIEVE MESSAGE FOR REPORT RECORD FROM ERROR TABLE
        $REP_errmsgids="282,341,395,459";
        $REP_errorMsg_array=array();
        $REP_errorMsg_array=$this->Mdl_eilib_common_function->getErrorMessageList($REP_errmsgids);
        $REP_result=(object)["REP_catagoryreportname"=>$REP_searchoptions_dataid,"REP_reportname"=>$REP_report_name_arraydataid,"REP_emailid"=>$REP_emailid_array,"REP_errormsg"=>$REP_errorMsg_array];
          //    REP_conn.close();
        return $REP_result;
    }
    //FUNCTION FOR ALL SEARCH BY CATAGORY REPORT
    function REP_func_load_searchby_option($REP_report_optionfetch){
        $REP_loaddata_arrdataid=array();
        $REP_selectquery=array();
        $REP_selectquery[59]='1,2,3,4,5,30';$REP_selectquery[60]='6';$REP_selectquery[61]='7,8,31';$REP_selectquery[73]='28';$REP_selectquery[82]='32';
        $this->db->select('RCN_ID,RCN_DATA');
        $this->db->from('REPORT_CONFIGURATION');
        $this->db->where('RCN_ID',$REP_selectquery[$REP_report_optionfetch]);
        $this->db->order_by('RCN_DATA');
        $REP_separate_rs=$this->db->get();

//      $REP_reportconfig="SELECT RCN_ID,RCN_DATA FROM REPORT_CONFIGURATION WHERE RCN_ID IN ("+REP_selectquery[REP_report_optionfetch]+") ORDER BY RCN_DATA ASC";
//       $REP_separate_rs=REP_stmt.executeQuery(REP_reportconfig);
        foreach($REP_separate_rs->result_array() as $row){
           $REP_seperatereportname_id=$row['RCN_ID'];
           $REP_seperatereportname_data=$row['RCN_DATA'];
           $REP_seperatereportname_object=(object)["REP_seperatereportnames_id"=>$REP_seperatereportname_id,"REP_seperatereportnames_data"=>$REP_seperatereportname_data];
           $REP_loaddata_arrdataid[]=($REP_seperatereportname_object);
        }
        $REP_result_obj=(object)["REP_loaddata_searchby"=>$REP_loaddata_arrdataid,"REP_flag"=>$REP_report_optionfetch];
//    REP_separate_rs.close();
//    REP_stmt.close();
//    REP_conn.close();
        return $REP_result_obj;
    }

}