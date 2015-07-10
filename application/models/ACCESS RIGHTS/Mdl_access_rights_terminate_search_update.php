<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 15/5/15
 * Time: 11:13 AM
 */

class Mdl_access_rights_terminate_search_update  extends CI_Model{

    public function URT_SRC_errormsg_loginid($URT_SRC_source){

        $URT_SRC_errorarray =array();
        $USRC_arr_loginid =array();
        $USRC_arr_uldid =array();
        $URT_SRC_data_uld_tble=false;
        $URT_SRC_customrole_array=array();
        $this->db->select();
        $this->db->from('USER_LOGIN_DETAILS');
        $row=$this->db->count_all_results();
        if($row>0){
            $URT_SRC_data_uld_tble=true;
        }
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $URT_SRC_errormsg_query = "349,350,351,352,353,354,355,401,454,455,458,465";
        $URT_SRC_errorarray=$this->Mdl_eilib_common_function->getErrorMessageList($URT_SRC_errormsg_query);
        if(($URT_SRC_source=='URT_SRC_radio_loginterminate')||($URT_SRC_source=='URT_SRC_radio_rejoin')){
           if($URT_SRC_source=='URT_SRC_radio_loginterminate'){
                $this->db->select();
                $this->db->from('VW_ACCESS_RIGHTS_TERMINATE_LOGINID');
                $this->db->where('URC_DATA!="SUPER ADMIN"');
                $this->db->order_by('ULD_LOGINID');
           }
           else if($URT_SRC_source=='URT_SRC_radio_rejoin'){
              $this->db->select();
              $this->db->from('VW_ACCESS_RIGHTS_REJOIN_LOGINID');
              $this->db->order_by('ULD_LOGINID');
           }
           $URT_SRC_select_loginid=$this->db->get();
           foreach($URT_SRC_select_loginid->result_array() as $row){
              $USRC_arr_loginid[]=$row['ULD_LOGINID'];
           }
        }
        else if($URT_SRC_source=='URT_SRC_radio_optsrcupd'){
             $this->db->select();
             $this->db->from('VW_ACCESS_RIGHTS_REJOIN_LOGINID');
             $this->db->order_by('ULD_LOGINID');
             $URT_SRC_select_loginid=$this->db->get();
             foreach($URT_SRC_select_loginid->result_array() as $row)
             {
              $USRC_arr_loginid[]=$row['ULD_LOGINID'];
             }
        }
        $this->db->select();
        $this->db->from('ROLE_CREATION');
        $this->db->order_by('RC_NAME');
        $URT_SRC_select_customrole_menu=$this->db->get();
        foreach($URT_SRC_select_customrole_menu->result_array() as $row){
         $URT_SRC_customrole_array[]=$row["RC_NAME"];
        }
        $URT_SRC_result=(object)["URT_SRC_obj_errmsg"=>$URT_SRC_errorarray,"URT_SRC_obj_loginid"=>$USRC_arr_loginid,"URT_SRC_obj_source"=>$URT_SRC_source,"URT_SRC_obj_flg_login"=>$URT_SRC_data_uld_tble,"URT_SRC_customerole"=>$URT_SRC_customrole_array];
        return $URT_SRC_result;
    }
    public function URT_SRC_func_enddate($URT_SRC_lb_loginid,$URT_SRC_recdver,$URT_SRC_flag_srcupd,$URT_SRC_flg_reverlen){

        if($URT_SRC_flag_srcupd=='URT_SRC_check_enddate'){
            $this->db->select( 'UA_JOIN_DATE,UA_REASON,UA_END_DATE,UA_JOIN');
            $this->db->from('USER_ACCESS UA');
            $this->db->where("UA.ULD_ID =(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_lb_loginid."') AND UA.UA_REC_VER=(SELECT MAX(UA_REC_VER) FROM USER_ACCESS WHERE ULD_ID=UA.ULD_ID)");
        }
        else if($URT_SRC_flag_srcupd=='URT_SRC_check_rejoindate'){
            $this->db->select('UA_JOIN_DATE,UA_REASON,UA_END_DATE,UA_JOIN');
            $this->db->from('USER_ACCESS UA');
            $this->db->where("UA.ULD_ID =(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_lb_loginid."') AND UA.UA_REC_VER=(SELECT MAX(UA_REC_VER) FROM USER_ACCESS WHERE ULD_ID=UA.ULD_ID)");
        }
        else if($URT_SRC_flag_srcupd=='URT_SRC_srcupd'){
            $this->db->select( 'UA_JOIN_DATE,UA_REASON,UA_END_DATE,UA_JOIN');
            $this->db->from('USER_ACCESS UA');
            $this->db->where("UA.ULD_ID =(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_lb_loginid."') AND UA.UA_REC_VER=".$URT_SRC_recdver."");
        }
        $URT_SRC_select_enddate=$this->db->get();
        foreach($URT_SRC_select_enddate->result_array() as $row){
            $URT_SRC_joindate=$row["UA_JOIN_DATE"];
            $URT_SRC_reason=$row["UA_REASON"];
            $URT_SRC_enddate=$row["UA_END_DATE"];
            $URT_SRC_join=$row["UA_JOIN"];
        }
        if($URT_SRC_flg_reverlen=='URT_SRC_recvrsion_more'){
            $URT_SRC_recdver=($URT_SRC_recdver)+1;
            $this->db->select( 'UA_JOIN_DATE');
            $this->db->from('USER_ACCESS UA');
            $this->db->where("UA.ULD_ID =(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_lb_loginid."') AND UA.UA_REC_VER=".$URT_SRC_recdver."");
            $URT_SRC_select_next_jdate=$this->db->get();
            $row_count=$this->db->count_all_results();
            if($row_count>0){
                 foreach($URT_SRC_select_next_jdate->result_array() as $row){
                   $URT_SRC_next_jdate=$row['UA_JOIN_DATE'];
                 }
            }
            else
             $URT_SRC_next_jdate='URT_SRC_nomore_recver';
             $URT_SRC_result=(object)["URT_SRC_obj_next_jdate"=>$URT_SRC_next_jdate,"URT_SRC_obj_joindate"=>$URT_SRC_joindate,"URT_SRC_obj_endate"=>$URT_SRC_enddate,"URT_SRC_obj_reason"=>$URT_SRC_reason,"URT_SRC_obj_srcupd"=>$URT_SRC_flag_srcupd];
        }
        else
          $URT_SRC_result=(object)["URT_SRC_obj_joindate"=>$URT_SRC_joindate,"URT_SRC_obj_endate"=>$URT_SRC_enddate,"URT_SRC_obj_reason"=>$URT_SRC_reason,"URT_SRC_obj_srcupd"=>$URT_SRC_flag_srcupd];

        return $URT_SRC_result;
    }
    /*-------------------------------------------FUNCTION TO GET LOGIN ID REC VER-----------------------------*/
    function URT_SRC_func_recordversion($URT_SRC_lb_loginid_rec,$URT_SRC_flag_recver,$URT_SRC_recvrsion_one) {
        $this->db->select( 'UA_REC_VER');
        $this->db->from('USER_ACCESS UA');
        $this->db->where("ULD_ID =(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_lb_loginid_rec."') AND UA_TERMINATE='X'");
        $URT_SRC_select_rec=$this->db->get();
        $URT_SRC_recordversion=array();
        foreach($URT_SRC_select_rec->result_array() as $row){
            $URT_SRC_recordversion[]=$row['UA_REC_VER'];
        }
        if(count($URT_SRC_recordversion)==1){

           $URT_SRC_upd_val=$this->URT_SRC_func_enddate($URT_SRC_lb_loginid_rec,$URT_SRC_recordversion[0],'URT_SRC_srcupd','URT_SRC_recvrsion_one');
      $URT_SRC_upd_val=(object)["URT_SRC_obj_endate"=>$URT_SRC_upd_val->URT_SRC_obj_endate,"URT_SRC_obj_reason"=>$URT_SRC_upd_val->URT_SRC_obj_reason,"URT_SRC_obj_srcupd"=>$URT_SRC_upd_val->URT_SRC_obj_srcupd,"URT_SRC_obj_recordversion"=>$URT_SRC_recordversion,"URT_SRC_obj_joindate"=>$URT_SRC_upd_val->URT_SRC_obj_joindate];
    }
        else{
           $URT_SRC_upd_val=(object)["URT_SRC_obj_recordversion"=>$URT_SRC_recordversion,"URT_SRC_obj_srcupd"=>$URT_SRC_flag_recver];
      }
       return  $URT_SRC_upd_val;
    }

    /*-------------------------------------------FUNCTION TO TERMINATE LOGIN DETAILS-----------------------------*/
    function URT_SRC_func_terminate($URT_SRC_emailid,$URT_SRC_enddate,$URT_SRC_reason,$URT_SRC_flg_terminate,$UserStamp,$service){
        try{
                  $URSRC_sharedocflag=0;$URSRC_sharecalflag=0;$URSRC_sharesiteflag=0;
                  $URT_SRC_enddate = date('Y-m-d',strtotime($URT_SRC_enddate));


                  //      URT_SRC_conn.setAutoCommit(false);
                  $this->db->select('UA_ID,UA_REASON');
                  $this->db->from('USER_ACCESS');
                  $this->db->where(" ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_emailid."') AND UA_REC_VER=(SELECT MAX(UA_REC_VER) FROM USER_ACCESS where ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_emailid."'))");
                  $URT_SRC_select_terminate=$this->db->get();

                  foreach($URT_SRC_select_terminate->result_array() as $row)
                  {
                      $URT_SRC_userpro_id=$row['UA_ID'];
                      $URT_SRC_old_reason=$row['UA_REASON'];
                  }
            $this->db->query('SET AUTOCOMMIT=0');
            $this->db->query('START TRANSACTION');
                  $URT_SRC_insert_terminate ="CALL SP_LOGIN_TERMINATE_SAVE('".$URT_SRC_emailid."','".$URT_SRC_enddate."','".$URT_SRC_reason."','".$UserStamp."',@TERM_FLAG,@TEMPTBL_OUT_LOGINID,@SAVE_POINT)";

          $URT_SRC_sucess_flag=0;
                $this->db->query($URT_SRC_insert_terminate);
                $URT_SRC_flag_lgnterminateselect="SELECT @TERM_FLAG as TERM_FLAG ,@TEMPTBL_OUT_LOGINID as TEMPTBL_OUT_LOGINID ,@SAVE_POINT as SAVE_POINT";
                $URT_SRC_flag_lgnterminaters=$this->db->query($URT_SRC_flag_lgnterminateselect);
                $URT_SRC_sucess_flag=$URT_SRC_flag_lgnterminaters->row()->TERM_FLAG;
                $URT_SRC_terminatetemplogidtbl=$URT_SRC_flag_lgnterminaters->row()->TEMPTBL_OUT_LOGINID;
            $save_point=$URT_SRC_flag_lgnterminaters->row()->SAVE_POINT;

          if($URT_SRC_sucess_flag==1)
          {
              $this->load->model('EILIB/Mdl_eilib_common_function');
              /*---------------------------------UNSHARE THE FILE & FOLDER---------------------------------------------*/
              $URSRC_sharedocflag=$this->Mdl_eilib_common_function->URSRC_unshareDocuments("",$URT_SRC_emailid,$service);
              if($URSRC_sharedocflag==1){
            //********************** UNSHARE CALENDAR
                  $URSRC_sharecalflag=$this->Mdl_eilib_common_function->USRC_shareUnSharecalender($URT_SRC_emailid,'none',$service);
                  if($URSRC_sharecalflag==0){
                      $this->db->trans_savepoint_rollback($save_point);
//                      $this->db->trans_rollback();
                      $this->Mdl_eilib_common_function->URSRC_shareDocuments("",$URT_SRC_emailid,$service);
                  }
              }
              else{
                  $this->db->trans_savepoint_rollback($save_point);

//                  $this->db->trans_rollback();
                  $this->Mdl_eilib_common_function->URSRC_shareDocuments("",$URT_SRC_emailid,$service);
              }
              $this->db->trans_savepoint_release($save_point) ;

          }
            else{
                $this->db->trans_savepoint_rollback($save_point);
            }

          $URT_SRC_success_flag=array();
          $URT_SRC_success_flag=[$URT_SRC_flg_terminate,$URT_SRC_sucess_flag,$URSRC_sharedocflag,$URSRC_sharecalflag];
//                $this->db->trans_commit();
          if($URT_SRC_terminatetemplogidtbl!=null&&$URT_SRC_terminatetemplogidtbl!='undefined'){
              $drop_query = "DROP TABLE ".$URT_SRC_terminatetemplogidtbl;
              $this->db->query($drop_query);
          }
          return $URT_SRC_success_flag;
    }catch(Exception $e)
        {
            $this->db->trans_savepoint_rollback($save_point);
//            $this->db->trans_rollback();
//            Logger.log("SCRIPT EXCEPTION:"+err)
//      URT_SRC_conn.rollback();
//      if(URT_SRC_terminatetemplogidtbl!=null&&URT_SRC_terminatetemplogidtbl!=undefined){
//          eilib.DropTempTable(URT_SRC_conn,URT_SRC_terminatetemplogidtbl);}
//      //********************** RESHARE CALENDAR
//      if(URSRC_sharecalflag==1){
//          USRC_shareUnSharecalender(URT_SRC_conn,URT_SRC_emailid,'writer');
//      }
//      //********************** RESHARE SITE
//      if(sitermoveflag==1){
//          URSRC_addViewer(URT_SRC_conn,URT_SRC_emailid);}
//      //************RESHARE DOCS
//      if(URSRC_sharedocflag==1){
//          URSRC_shareDocuments(URT_SRC_conn,"",URT_SRC_emailid)};
//      URT_SRC_conn.commit();
//      URT_SRC_conn.close();
//      return Logger.getLog();
    }
    }
/*-------------------------------------------FUNCTION TO UPDATE LOGIN DETAILS-----------------------------*/
function URT_SRC_func_update($URT_SRC_upd_loginid,$URT_SRC_upd_recver,$URT_SRC_upd_edate,$URT_SRC_upd_reason,$URT_SRC_flg_updation,$UserStamp) {
    $URT_SRC_upd_enddate = date('Y-m-d',strtotime($URT_SRC_upd_edate));
    $URT_SRC_sucess_flag=0;
    if ($URT_SRC_upd_recver==null||$URT_SRC_upd_recver=="SELECT")
    {
        $URT_SRC_update_terminate =" UPDATE USER_ACCESS SET UA_END_DATE='".$URT_SRC_upd_enddate."',UA_REASON='".$URT_SRC_upd_reason."',UA_USERSTAMP='".$UserStamp."' WHERE ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_upd_loginid."') AND UA_REC_VER=1";
    }
    else
    {
        $URT_SRC_update_terminate =" UPDATE USER_ACCESS SET UA_END_DATE='".$URT_SRC_upd_enddate."',UA_REASON='".$URT_SRC_upd_reason."',UA_USERSTAMP='".$UserStamp."' WHERE ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_upd_loginid."') AND UA_REC_VER=".$URT_SRC_upd_recver."";
    }
    $this->db->query($URT_SRC_update_terminate);
    if ($this->db->affected_rows() > 0) {
        $URT_SRC_sucess_flag=1;
    }
    else {
        $URT_SRC_sucess_flag=0;
    }

    $URT_SRC_success_flag=array();
    $URT_SRC_success_flag=[$URT_SRC_flg_updation,$URT_SRC_sucess_flag];
return $URT_SRC_success_flag;
}
//
/*-------------------------------------------FUNCTION TO REJOIN LOGIN DETAILS-----------------------------*/
function URT_SRC_func_rejoin($URT_SRC_upd_emailid,$URT_SRC_upd_rejoindate,$URT_SRC_upd_customrole,$URT_SRC_flg_rejoin,$UserStamp,$service) {
    try{
            $URSRC_sharedocflag=0;$URSRC_sharecalflag=0;$URSRC_sharesiteflag=0;
             $URT_SRC_temptable='';
//      URT_SRC_conn.setAutoCommit(false);
        $URT_SRC_upd_rejoindate = date('Y-m-d',strtotime($URT_SRC_upd_rejoindate));
  $URT_SRC_upd_customrole=str_replace("_"," ",$URT_SRC_upd_customrole);
  $URT_SRC_select_rejoin_id="SELECT UA_ID,RC_ID,MAX(UA.UA_REC_VER) as UA_REC_VER,ULD_ID FROM USER_ACCESS UA WHERE UA.ULD_ID =(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$URT_SRC_upd_emailid."')";
        $URT_SRC_rs_rejoin_id=$this->db->query($URT_SRC_select_rejoin_id);
  foreach($URT_SRC_rs_rejoin_id->result_array() as $row)
  {
      $URT_SRC_autoinc_id=$row['UA_ID'];
      $URT_SRC_userpro_maxrec=$row['UA_REC_VER'];
      $URT_SRC_userpro_uldid=$row['ULD_ID'];
  }
  $URT_SRC_select_rc_id="SELECT RC_ID FROM ROLE_CREATION where RC_NAME='".$URT_SRC_upd_customrole."'";
 $URT_SRC_rs_rc_id=$this->db->query($URT_SRC_select_rc_id);
  foreach($URT_SRC_rs_rc_id->result_array() as $row){
      $URT_SRC_rc_id=$row['RC_ID'];
    }
        $this->db->query('SET AUTOCOMMIT=0');
        $this->db->query('START TRANSACTION');

  $URT_SRC_select_rejoin="CALL SP_LOGIN_CREATION_INSERT('".$URT_SRC_upd_emailid."','".$URT_SRC_upd_customrole."','".$URT_SRC_upd_rejoindate."','".$UserStamp."',@TEMPTABLE,@LOGIN_CREATIONFLAG,@SAVE_POINT)";
        $this->db->query($URT_SRC_select_rejoin);

  $URT_SRC_flag_rejoinselect="SELECT @TEMPTABLE as TEMPTABLE,@LOGIN_CREATIONFLAG as REJOIN_FLAG,@SAVE_POINT as SAVE_POINT";
  $URT_SRC_flag_rejoincrers=$this->db->query($URT_SRC_flag_rejoinselect);
    $URT_SRC_flag_lgncreinsert=$URT_SRC_flag_rejoincrers->row()->REJOIN_FLAG;
    $URT_SRC_temptable=$URT_SRC_flag_rejoincrers->row()->TEMPTABLE;
        $save_point=$URT_SRC_flag_rejoincrers->row()->SAVE_POINT;

        if($URT_SRC_flag_lgncreinsert==1){
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $URSRC_sharedocflag= $this->Mdl_eilib_common_function->URSRC_shareDocuments($URT_SRC_upd_customrole,$URT_SRC_upd_emailid,$service);
            if($URSRC_sharedocflag==1){
                //URSRC_sharesiteflag=URSRC_addViewer(URSRC_conn,URSRC_loginid)
                $URSRC_sharecalflag=$this->Mdl_eilib_common_function->USRC_shareUnSharecalender($URT_SRC_upd_emailid,'writer',$service);
                if($URSRC_sharecalflag==0){
                    $this->db->trans_savepoint_rollback($save_point);
//                    $this->db->trans_rollback();
                    $this->Mdl_eilib_common_function->URSRC_unshareDocuments($URT_SRC_upd_customrole,$URT_SRC_upd_emailid,$service);
                }
            }
            else{
                $this->db->trans_savepoint_rollback($save_point);
//                $this->db->trans_rollback();
                $this->Mdl_eilib_common_function->URSRC_unshareDocuments($URT_SRC_upd_customrole,$URT_SRC_upd_emailid,$service);

            }
            $this->db->trans_savepoint_release($save_point) ;
        }
        else{
            $this->db->trans_savepoint_rollback($save_point);

        }
  if($URT_SRC_temptable!='null'){
      $drop_query = "DROP TABLE ".$URT_SRC_temptable;
      $this->db->query($drop_query);
  }
//    $this->db->trans_commit();
  $URT_SRC_success_flag=array();
  $URT_SRC_success_flag=[$URT_SRC_flg_rejoin,$URT_SRC_flag_lgncreinsert,$URSRC_sharedocflag,$URSRC_sharecalflag];
  return $URT_SRC_success_flag;
}catch(Exception $e)
    {
//            Logger.log("SCRIPT EXCEPTION:"+err)
        $this->db->trans_savepoint_rollback($save_point);
//  $this->db->trans_rollback();
//      if(URT_SRC_temptable!='null'){
//          eilib.DropTempTable(URT_SRC_conn,URT_SRC_temptable)
//      }
//      if(URSRC_sharedocflag==1)
//      {
//          URSRC_unshareDocuments(URT_SRC_conn,URT_SRC_upd_customrole,URT_SRC_upd_emailid)
//      }
//      if(URSRC_sharesiteflag==1)
//      {
//          URSRC_removeViewer(URT_SRC_conn,URT_SRC_upd_emailid)
//      }
//      if(URSRC_sharecalflag==1)
//      {
//          USRC_shareUnSharecalender(URT_SRC_conn,URT_SRC_upd_emailid,'none');
//      }
//      URT_SRC_conn.commit();
//      URT_SRC_conn.close();
//      return Logger.getLog();
//    }
}
    }


} 