<?php




class Mdl_access_rights_search_update extends CI_Model{
    public  function URSRC_loadintialvalue($UserStamp){
        $URSRC_userrights_array=array();
        $this->db->select('URC_DATA');
        $this->db->from('USER_RIGHTS_CONFIGURATION URC','BASIC_ROLE_PROFILE BRP','ROLE_CREATION RC','USER_LOGIN_DETAILS ULD','USER_ACCESS UA');
        $this->db->join('BASIC_ROLE_PROFILE BRP', 'BRP.BRP_BR_ID=URC.URC_ID');
        $this->db->join('ROLE_CREATION RC',' RC.URC_ID=BRP.URC_ID');
        $this->db->join('USER_ACCESS UA','RC.RC_ID=UA.RC_ID');
        $this->db->join('USER_LOGIN_DETAILS ULD','ULD.ULD_ID=UA.ULD_ID');
        $this->db->where('ULD.ULD_LOGINID',$UserStamp);
        $this->db->order_by('URC_DATA');
        $query = $this->db->get();
        foreach ($query->result_array() as $row){

            $URSRC_userrights_array[]=$row['URC_DATA'];
        }
        $URSRC_basicroles_array=array();
        $this->db->select('URC_DATA');
        $this->db->from('USER_RIGHTS_CONFIGURATION');
        $this->db->where('CGN_ID','43');
        $this->db->order_by('URC_DATA ASC');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_basicroles_array[]=$row['URC_DATA'];
        }
        $this->db->select('URC_DATA');
        $this->db->from('USER_RIGHTS_CONFIGURATION URC');
        $this->db->join('ROLE_CREATION RC','RC.URC_ID=URC.URC_ID');
        $this->db->join('USER_ACCESS UA','RC.RC_ID=UA.RC_ID');
        $this->db->join('USER_LOGIN_DETAILS ULD','ULD.ULD_ID=UA.ULD_ID');
        $this->db->where('ULD.ULD_LOGINID',$UserStamp);
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_basicrole=$row['URC_DATA'];
        }
        $URSRC_basicroleid_array=array();
        $this->db->select('BRP_BR_ID');
        $this->db->from('USER_RIGHTS_CONFIGURATION URC');
        $this->db->join('BASIC_ROLE_PROFILE BRP','URC.URC_ID=BRP.URC_ID');
        $this->db->where('URC.URC_DATA',$URSRC_basicrole);
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_basicroleid_array[]=$row['BRP_BR_ID'];
        }

        $URSRC_basicrole_profile_array=array();
        for($i=0;$i<count($URSRC_basicroleid_array);$i++){
            $this->db->select('URC_DATA');
            $this->db->from('USER_RIGHTS_CONFIGURATION URC');
            $this->db->join('BASIC_ROLE_PROFILE BRP','BRP.BRP_BR_ID=URC.URC_ID');
            $this->db->where('BRP.BRP_BR_ID',$URSRC_basicroleid_array[$i]);
            $this->db->order_by('URC_DATA ASC');
            $query = $this->db->get();
            foreach($query->result_array() as $row){
                $URSRC_basicrole_profile_array[]=$row['URC_DATA'];
            }
        }
        $URSRC_basicrole_profile_array=array_values(array_unique($URSRC_basicrole_profile_array));

        $URSRC_role_array=array();
        $this->db->select('RC_NAME');
        $this->db->from('ROLE_CREATION');
        $this->db->order_by('RC_NAME');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_role_array[]=$row['RC_NAME'];
        }

        $URSRC_logindetails_array=array();
        $this->db->select('*');
        $this->db->from('VW_ACCESS_RIGHTS_TERMINATE_LOGINID');
        $query = $this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_logindetails_array[]=$row['ULD_LOGINID'];
        }
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList('36,354,360,361,362,363,364,365,366,367,370,371,372,373,374,376,401,454,455,458,465');
        $URSRC_initial_values=(object)['URSRC_userrights'=>$URSRC_userrights_array,'URSRC_role_array'=>$URSRC_role_array,'URSRC_loginid_array'=>$URSRC_logindetails_array,'URSRC_errorAarray'=>$ErrorMessage,'URSRC_basicroles_array'=>$URSRC_basicroles_array,'URSRC_basicrole'=>$URSRC_basicrole,'URSRC_basicrole_profile_array'=>$URSRC_basicrole_profile_array,'UserStamp'=>$UserStamp];
        return $URSRC_initial_values;
    }
    public function URSRC_check_role($role){

        $this->db->select();
        $this->db->from('ROLE_CREATION');
        $this->db->where('RC_NAME', $role);
        $row=$this->db->count_all_results();
        $x=$row;
        if($x > 0)
        {
            $URSRC_already_exist_flag=1;
        }
        else{
            $URSRC_already_exist_flag=0;
        }
        return ($URSRC_already_exist_flag);

    }
    public function URSRC_check_basicrolemenu($basicrole){
        $role=str_replace("_"," ",$basicrole);
        $this->db->like('URC_DATA',$role);
        $this->db->from('BASIC_MENU_PROFILE BMP');
        $this->db->join('USER_RIGHTS_CONFIGURATION URC','URC.URC_ID=BMP.URC_ID');
        $row=$this->db->count_all_results();
        $x=$row;
        if($x > 0)
        {
            $URSRC_check_basicrole_menu=0;//TRUE
        }
        else{
            $URSRC_check_basicrole_menu=1;//FALSE
        }
        return ($URSRC_check_basicrole_menu);
    }
    public function URSRC_check_loginid($login_id){

        $this->db->select();
        $this->db->from('USER_LOGIN_DETAILS');
        $this->db->where('ULD_LOGINID',$login_id);
        $row=$this->db->count_all_results();
        $x=$row;
        if($x > 0)
        {
            $URSRC_already_exist_flag=1;//TRUE
        }
        else{
            $URSRC_already_exist_flag=0;//FALSE
        }

    $URSRC_role_array=$this->URSRC_get_roles();
    $URSRC_final_array=[$URSRC_already_exist_flag,$URSRC_role_array];
    return $URSRC_final_array;
    }
    //Function to get custom roles
    public  function URSRC_get_roles(){
        $URSRC_role_array=array();
        $this->db->select();
        $this->db->from('ROLE_CREATION');
        $this->db->order_by('RC_NAME');
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_role_array[] =$row['RC_NAME'];

        }
        return $URSRC_role_array;
    }
    public  function URSRC_get_loginid(){
        $URSRC_loginid_array=array();
        $this->db->select();
        $this->db->from('VW_ACCESS_RIGHTS_TERMINATE_LOGINID');
        $this->db->order_by('ULD_LOGINID');
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_loginid_array[]=$row['ULD_LOGINID'];
        }
        return $URSRC_loginid_array;
    }
    public function URSRC_get_logindetails($loginid){

        $URSRC_details_array=array();
        $this->db->select();
        $this->db->from("USER_LOGIN_DETAILS ULD");
        $this->db->join("USER_ACCESS UA","ULD.ULD_ID=UA.ULD_ID");
        $this->db->join("ROLE_CREATION RC","RC.RC_ID=UA.RC_ID");
        $this->db->join("USER_RIGHTS_CONFIGURATION URC","URC.URC_ID=RC.URC_ID");
        $this->db->where("ULD_LOGINID='$loginid' and UA.UA_REC_VER=(select max(UA_REC_VER) from USER_ACCESS UA,USER_LOGIN_DETAILS ULD where ULD.ULD_ID=UA.ULD_ID and ULD_LOGINID='$loginid' and UA_JOIN is not null)");
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_details_array[]=date('d-m-Y',strtotime($row['UA_JOIN_DATE']));
            $URSRC_details_array[]=$row['RC_NAME'];
        }
        $URSRC_role_array=$this->URSRC_get_roles();
        $URSRC_loginid_details_array=[$URSRC_details_array,$URSRC_role_array];
        return $URSRC_loginid_details_array;
    }
    public function URSRC_getmenu_folder($basicrole,$service) {
        $URSRC_basicrole=str_replace("_"," ",$basicrole);
        $URSRC_finalmenu=array();
        $URSRC_main_main=array();
        $URSRC_first_submenu=array();
        $URSRC_second_sub_menu=array();
        $URSRC_fp_id_array=array();
        $i=0;
        $main_menu_query= $this->db->query("SELECT DISTINCT MP_MNAME FROM MENU_PROFILE MP,BASIC_MENU_PROFILE BMP,USER_RIGHTS_CONFIGURATION URC where BMP.MP_ID=MP.MP_ID and BMP.URC_ID=URC.URC_ID and URC.URC_DATA='$URSRC_basicrole' ORDER BY MP_MNAME ASC");
        foreach ($main_menu_query->result_array() as $row)//main menu loop
        {
            $URSRC_main_main[]=$row["MP_MNAME"];
            $URSRC_submenu_array =array();
            $sub_menu_query=$this->db->query("SELECT DISTINCT MP_MSUB FROM MENU_PROFILE MP,BASIC_MENU_PROFILE BMP,USER_RIGHTS_CONFIGURATION URC where BMP.MP_ID=MP.MP_ID and BMP.URC_ID=URC.URC_ID and URC.URC_DATA='$URSRC_basicrole' and MP.MP_MNAME='".$URSRC_main_main[$i]."' AND MP.MP_MSUB IS NOT NULL ORDER BY MP.MP_MSUB ASC");
            $j=0;
            $URSRC_submenu=array();
            foreach($sub_menu_query->result_array() as $row1)//sub menu loop
            {
                $URSRC_submenu[]=$row1["MP_MSUB"];
                if($URSRC_submenu[$j]!=''){
                   $URSRC_select_mpid=$this->db->query("SELECT MP.MP_ID,MP.FP_ID FROM MENU_PROFILE MP,BASIC_MENU_PROFILE BMP,USER_RIGHTS_CONFIGURATION URC where BMP.MP_ID=MP.MP_ID and BMP.URC_ID=URC.URC_ID and URC.URC_DATA='$URSRC_basicrole' and MP_MNAME='".$URSRC_main_main[$i]."'  AND MP_MSUB='".$URSRC_submenu[$j]."'");
                   $m=0;
                   foreach($URSRC_select_mpid->result_array() as $row2){
                       if($m!=0)
                        break;
                       $mp_id=$row2['MP_ID'];
                       $fp_id=$row2['FP_ID'];
                       if($fp_id!=null){
                           $fp_id=$fp_id;
                           $URSRC_fp_id_array[]=($fp_id);
                       }
                       else{
                          $fp_id="";
                       }
                       $final_submenu=$URSRC_submenu[$j]."_".$mp_id."_".$fp_id;
                       $URSRC_submenu_array[]=($final_submenu);
                       $m++;
                   }
                }
                $URSRC_sub_submenu_array =array();
                $URSRC_sub_submenu=array();
                $URSRC_select_sub_submenu=$this->db->query("SELECT DISTINCT MP_MSUBMENU FROM MENU_PROFILE MP,BASIC_MENU_PROFILE BMP,USER_RIGHTS_CONFIGURATION URC where BMP.MP_ID=MP.MP_ID and BMP.URC_ID=URC.URC_ID and URC.URC_DATA='$URSRC_basicrole' and MP.MP_MNAME='".$URSRC_main_main[$i]."' AND  MP.MP_MSUB='".$URSRC_submenu[$j]."' AND MP.MP_MSUBMENU IS NOT NULL ORDER BY MP_MSUBMENU ASC");
                $h=0;
                foreach($URSRC_select_sub_submenu->result_array() as $row3)//sun sub menu loop
                {
                    $URSRC_sub_submenu[]=$row3["MP_MSUBMENU"];
                    if($URSRC_sub_submenu[$h]!=""){
                      $select_mpid=$this->db->query("SELECT MP.MP_ID,MP.FP_ID FROM MENU_PROFILE MP,BASIC_MENU_PROFILE BMP,USER_RIGHTS_CONFIGURATION URC where BMP.MP_ID=MP.MP_ID and BMP.URC_ID=URC.URC_ID and URC.URC_DATA='$URSRC_basicrole' and MP.MP_MNAME='".$URSRC_main_main[$i]."' AND  MP.MP_MSUB='".$URSRC_submenu[$j]."' AND MP.MP_MSUBMENU='".$URSRC_sub_submenu[$h]."'");
                       foreach($select_mpid->result_array() as $row4){
                           $mp_id=$row4["MP_ID"];
                           $fp_id=$row4["FP_ID"];
                           if($fp_id!=null){
                               $fp_id=$fp_id;
                               $separate_fpid=explode(',',$fp_id);
                               for($k=0;$k<count($separate_fpid);$k++){
                                $URSRC_fp_id_array[]=($separate_fpid[$k]);
                               }
                           }else{
                               $fp_id="";
                           }
                           $URSRC_final_sub_submenu=$URSRC_sub_submenu[$h]."_".$mp_id."_".$fp_id;
                           $URSRC_sub_submenu_array[]=($URSRC_final_sub_submenu);
                       }

                    }
                    $h++;
                }//sub sub menu loop end
                $URSRC_second_sub_menu[]=($URSRC_sub_submenu_array);
                $j++;
            }//sub menu loop end
            $URSRC_first_submenu[]=($URSRC_submenu_array);
            $i++;
        }//main menu loop end
        $URSRC_fp_id_array=array_values(array_unique($URSRC_fp_id_array));
        $URSRC_mainfolder=array();
        $URSRC_finalfolder=array();
        $URSRC_file_array=array();
        $URSRC_folder_id_array=array();
        for($l=0;$l<count($URSRC_fp_id_array);$l++){
            $URSRC_select_folder=$this->db->query("SELECT DISTINCT FP_FOLDER_ID FROM FILE_PROFILE WHERE FP_FILE_FLAG IS NULL and FP_ID='".$URSRC_fp_id_array[$l]."' ORDER BY FP_FOLDER_ID ASC");
            foreach($URSRC_select_folder->result_array() as $folder_row){
              $URSRC_folder_id_array[]=$folder_row['FP_FOLDER_ID'];
            }
        }
        $URSRC_folder_id_array=array_values(array_unique($URSRC_folder_id_array));
        $folder_name='';
        $file_name='';
        for($j=0;$j<count($URSRC_folder_id_array);$j++){

            $this->db->select();
            $this->db->from("FILE_PROFILE");
            $this->db->where('FP_FOLDER_ID',$URSRC_folder_id_array[$j]);
            $query=$this->db->get();
            $fp_id=$query->row()->FP_ID;
            $folder_name=$this->printFile($service,$URSRC_folder_id_array[$j]);
            $URSRC_folder_name=$folder_name[0];
            $docflag=$folder_name[1];
            if($docflag==0)break;
                $URSRC_mainfolder[]=($URSRC_folder_name."_".$fp_id);
        }
        if($docflag!=0){
            for($i=0;$i<count($URSRC_folder_id_array);$i++){
                $URSRC_file=array();
                $URSRC_select_file=$this->db->query("SELECT DISTINCT FP_FILE_ID FROM FILE_PROFILE WHERE FP_FOLDER_ID='".$URSRC_folder_id_array[$i]."' and FP_FILE_ID is not null ORDER BY FP_FILE_ID ASC");
                foreach($URSRC_select_file->result_array() as $row){
                      $URSRC_file_id=$row["FP_FILE_ID"];
                      if($URSRC_file_id!=""){
                          $file_name=$this->printFile($service,$URSRC_file_id);
                          $URSRC_file_name=$file_name[0];
                          $docflag=$file_name[1];
                      }
                    if($URSRC_file_id!=""){
                          $URSRC_select_fpid=$this->db->query("SELECT FP_ID FROM FILE_PROFILE WHERE FP_FOLDER_ID='".$URSRC_folder_id_array[$i]."' AND FP_FILE_ID='".$URSRC_file_id."'");
                          foreach($URSRC_select_fpid->result_array() as $row){
                                $fp_id=$row["FP_ID"];
                                if($URSRC_file_id!=null){
                                  $final_filename=$URSRC_file_name."&&".$fp_id;
                                }
                                $URSRC_file[]=($final_filename);
                          }
                    }
                }
                $URSRC_file_array[]=($URSRC_file);
            }
        }
        $URSRC_finalfolder=[$URSRC_mainfolder,$URSRC_file_array];
        $URSRC_finalmenu=[$URSRC_main_main,$URSRC_first_submenu,$URSRC_second_sub_menu];
        $URSRC_basicroleid_array=array();
        $this->db->select();
        $this->db->from('USER_RIGHTS_CONFIGURATION URC');
        $this->db->join('BASIC_ROLE_PROFILE BRP','URC.URC_ID=BRP.URC_ID');
        $this->db->where('URC.URC_DATA',$basicrole);
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_basicroleid_array[]=$row["BRP_BR_ID"];
        }
        $URSRC_basicrole_profile_array=array();
        for($i=0;$i<count($URSRC_basicroleid_array);$i++){
            $this->db->select();
            $this->db->from('USER_RIGHTS_CONFIGURATION URC');
            $this->db->join('BASIC_ROLE_PROFILE BRP','URC.URC_ID=BRP.URC_ID');
            $this->db->where('BRP.BRP_BR_ID',$URSRC_basicroleid_array[$i]);
            $query=$this->db->get();
            foreach($query->result_array() as $row){
              $URSRC_basicrole_profile_array[]=$row["URC_DATA"];
            }
        }
        $URSRC_basicrole_profile_array=array_values(array_unique($URSRC_basicrole_profile_array));
        sort($URSRC_basicrole_profile_array);
        $URSRC_values_array=array();
        $URSRC_values=(object)['URSRC_multi_array'=>$URSRC_finalmenu,'URSRC_folder_array'=>$URSRC_finalfolder,'URSRC_basicrole_profile_array'=>$URSRC_basicrole_profile_array,'docflag'=>$docflag];
        $URSRC_values_array[]=($URSRC_values);
        return $URSRC_values_array;
    }
    public function URSRC_getmenubasic_folder1() {

        $URSRC_finalmenu=array();
        $URSRC_main_main=array();
        $URSRC_first_submenu=array();
        $URSRC_second_sub_menu=array();
        $URSRC_fp_id_array=array();
        $i=0;
        $main_menu_query= $this->db->query("SELECT DISTINCT MP_MNAME FROM MENU_PROFILE MP ORDER BY MP_MNAME ASC");
        foreach ($main_menu_query->result_array() as $row)//main menu loop
        {
            $URSRC_main_main[]=$row["MP_MNAME"];
            $URSRC_submenu_array =array();
            $sub_menu_query=$this->db->query("SELECT  MP_MSUB, MP.MP_ID FROM MENU_PROFILE MP WHERE MP.MP_MNAME='".$URSRC_main_main[$i]."' AND MP.MP_MSUB IS NOT NULL GROUP BY MP_MSUB ORDER BY MP.MP_MSUB ASC ");
            $j=0;
            $URSRC_submenu=array();
            foreach($sub_menu_query->result_array() as $row1)//sub menu loop
            {
                $URSRC_submenu[]=$row1["MP_MSUB"];
                if($URSRC_submenu[$j]!=''){
                    $URSRC_select_mpid=$this->db->query("SELECT  MP.MP_ID FROM MENU_PROFILE MP WHERE MP.MP_MNAME='".$URSRC_main_main[$i]."' AND  MP_MSUB='".$URSRC_submenu[$j]."' and MP.MP_MSUB IS NOT NULL GROUP BY MP_MSUB ORDER BY MP.MP_MSUB ASC ");
                    foreach($URSRC_select_mpid->result_array() as $row2){
                        $mp_id=$row2['MP_ID'];
                        $final_submenu=$URSRC_submenu[$j]."_".$mp_id;
                        $URSRC_submenu_array[]=($final_submenu);
                    }

                }
                $URSRC_sub_submenu_array =array();
                $URSRC_sub_submenu=array();
                $URSRC_select_sub_submenu=$this->db->query("SELECT MP.MP_ID, MP_MSUBMENU FROM MENU_PROFILE MP WHERE MP.MP_MNAME='".$URSRC_main_main[$i]."' AND  MP.MP_MSUB='".$URSRC_submenu[$j]."' AND MP.MP_MSUBMENU IS NOT NULL  ORDER BY MP_MSUBMENU ASC");
                $h=0;
                foreach($URSRC_select_sub_submenu->result_array() as $row3)//sun sub menu loop
                {
                    $URSRC_sub_submenu[]=$row3["MP_MSUBMENU"];
                    if($URSRC_sub_submenu[$h]!=""){
                        $select_mpid=$this->db->query("SELECT MP.MP_ID, MP_MSUBMENU FROM MENU_PROFILE MP WHERE MP.MP_MNAME='".$URSRC_main_main[$i]."' AND  MP.MP_MSUB='".$URSRC_submenu[$j]."' AND MP.MP_MSUBMENU='".$URSRC_sub_submenu[$h]."' AND MP.MP_MSUBMENU IS NOT NULL  ORDER BY MP_MSUBMENU ASC");
                        foreach($select_mpid->result_array() as $row4){
                            $mp_id=$row4["MP_ID"];
                            $URSRC_final_sub_submenu=$URSRC_sub_submenu[$h]."_".$mp_id;
                            $URSRC_sub_submenu_array[]=($URSRC_final_sub_submenu);
                        }
                    }
                    $h++;
                }//sub sub menu loop end
                $URSRC_second_sub_menu[]=($URSRC_sub_submenu_array);
                $j++;
            }//sub menu loop end
            $URSRC_first_submenu[]=($URSRC_submenu_array);
            $i++;
        }//main menu loop end
        $URSRC_finalmenu=[$URSRC_main_main,$URSRC_first_submenu,$URSRC_second_sub_menu];
        return $URSRC_finalmenu;
    }
    //FUNTION TO GET FOLDER AND FILE  NAME
    function printFile($service, $fileId) {
        $docflag=1;
        $folder_name='';
        try {
            $file = $service->files->get($fileId);
           $folder_name= $file->getTitle();
        }
        catch (Exception $e) {
            $docflag=0;
        }
        $final_value=[$folder_name,$docflag];
        return $final_value;
    }
    //Function to get custom role details
    public function URSRC_get_roledetails($custome_role,$service){

        $URSRC_roledetails_array='';
        $this->db->select();
        $this->db->from('USER_RIGHTS_CONFIGURATION URC');
        $this->db->join('ROLE_CREATION RC','URC.URC_ID=RC.URC_ID');
        $this->db->where('RC_NAME',$custome_role);
        $this->db->order_by('URC_DATA');
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_roledetails_array=$row['URC_DATA'];
        }
        $URSRC_menu_folder=$this->URSRC_getmenu_folder($URSRC_roledetails_array,$service);
        $URSRC_usermenudetails_array=array();
        $URSRC_main_menu=array();
        $URSRC_sub_menu=array();
        $this->db->select();
        $this->db->from('ROLE_CREATION RC');
        $this->db->join('USER_MENU_DETAILS  UMD','UMD.RC_ID=RC.RC_ID');
        $this->db->join('MENU_PROFILE MP','MP.MP_ID=UMD.MP_ID');
        $this->db->where('RC_NAME',$custome_role);
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_usermenudetails_array[]=$row['MP_ID'];
        }
        $URSRC_fileid_array=array();
        $this->db->select();
        $this->db->from('ROLE_CREATION RC');
        $this->db->join('USER_FILE_DETAILS UFD','UFD.RC_ID=RC.RC_ID');
        $this->db->where('RC_NAME',$custome_role);
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_fileid_array[]=$row['FP_ID'];
        }
        $final_value=[$URSRC_roledetails_array,$URSRC_usermenudetails_array,$URSRC_fileid_array,$URSRC_menu_folder];
        return $final_value;
    }
    public function URSRC_get_customrole(){
       $URSRC_role_array=$this->URSRC_get_roles();
       return $URSRC_role_array;

    }
    //FUNCTION to get basic role menus
    public function URSRC_loadbasicrole_menu($basicrole,$URSRC_basic_role,$service){

        $basicrole=str_replace("_"," ",$basicrole);
        $URSRC_basicrole_menu_array=array();
        $this->db->select();
        $this->db->from('USER_RIGHTS_CONFIGURATION URC');
        $this->db->join('BASIC_MENU_PROFILE BMP','URC.URC_ID=BMP.URC_ID');
        $this->db->where('URC.URC_DATA',$basicrole);
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_basicrole_menu_array[]=$row['MP_ID'];
        }
        $URSRC_basicroleid_array=array();
        $this->db->select();
        $this->db->from('USER_RIGHTS_CONFIGURATION URC');
        $this->db->join('BASIC_ROLE_PROFILE BRP','URC.URC_ID=BRP.URC_ID');
        $this->db->where('URC.URC_DATA',$basicrole);
        $query=$this->db->get();
        foreach($query->result_array() as $row){
            $URSRC_basicroleid_array[]=$row["BRP_BR_ID"];
        }
        $URSRC_basicrole_array=array();
        for($i=0;$i<count($URSRC_basicroleid_array);$i++){
            $this->db->select();
            $this->db->from('USER_RIGHTS_CONFIGURATION URC');
            $this->db->join('BASIC_ROLE_PROFILE BRP','URC.URC_ID=BRP.URC_ID');
            $this->db->where('BRP.URC_ID',$URSRC_basicroleid_array[$i]);
            $query=$this->db->get();
            foreach($query->result_array() as $row){
                $URSRC_basicrole_array[]=$row["URC_DATA"];
            }
        }
        $URSRC_basicrole_array=array_values(array_unique($URSRC_basicrole_array));
        $URSRC_basicrole_values=(object)['URSRC_basicrole_menu'=>$URSRC_basicrole_menu_array,'URSRC_basicrole_array'=>$URSRC_basicrole_array];
        $URSRC_basicrole_values_array=array();
        $URSRC_basicrole_values_array[]=($URSRC_basicrole_values);
        $URSRC_basic_menu=$this->URSRC_getmenubasic_folder1();
        $URSRC_basicrole_values_array[]=($URSRC_basic_menu);
        return $URSRC_basicrole_values_array;
    }
     //Role creation save and update & Basic role menu creation save and update
    public function URSRC_role_creation_save($URSRC_mainradiobutton,$URSRC_menu,$URSRC_submenu,$URSRC_sub_submenu,$basicroles,$customrole,$customerrole_upd,$URSRC_radio_basicroles,$URSRC_cb_basicroles,$UserStamp,$service){
        $URSRC_sharedocflag=0;
        try{

            //      URSRC_conn.setAutoCommit(false);
            $URSRC_sub_submenu_array=array();
            $submenu_array=array();
            $menu_array=array();
            $URSRC_sub_submenu_array=array();
            $submenu_array=array();
            $menu_array=array();
            $sub_menu_menus=array();
            $URSRC_mainradiobutton=str_replace("_"," ",$URSRC_mainradiobutton);
            $length=count($URSRC_submenu);
            $sub_menu1_length=count($URSRC_sub_submenu);
            $URSRC_checkbox_basicrole=$URSRC_cb_basicroles;
            $URSRC_checkbox_basicrole=str_replace("_"," ",$URSRC_checkbox_basicrole);
            $URSRC_rd_basicrole=$URSRC_radio_basicroles;
            $URSRC_rd_basicrole=str_replace("_"," ",$URSRC_rd_basicrole);
            $submenu_array=$URSRC_submenu;
            $menu_array=$URSRC_menu;
            $flag=0;
            $menu_files=array();
            for($j=0;$j<count($menu_array);$j++){
                if(preg_match('/%%/',$menu_array[$j]))
                {
                    $sub=explode('%%',$menu_array[$j]);
                    $menu_files[]=($sub[0]);
                }
            }
            $sub_menu_files=array();
            for($i=0;$i<$length;$i++){
                if (!(preg_match('/&&/',$URSRC_submenu[$i])))
                {
                    if(preg_match('/%%/',$URSRC_submenu[$i])){
                        $sub=explode('%%',$URSRC_submenu[$i]);
                        $menu_files[]=($sub[0]);
                    }
                    else{
                        $URSRC_sub_submenu_array[]=$URSRC_submenu[$i];
                    }
                }
            }
            if($sub_menu1_length!=0){
                for($j=0;$j<$sub_menu1_length;$j++){
                    $URSRC_sub_submenu_array[]=$URSRC_sub_submenu[$j];
                }
            }
            $URSRC_menuid='';
            for($j=0;$j<count($URSRC_sub_submenu_array);$j++){
                if($j==0){
                    $URSRC_menuid=$URSRC_sub_submenu_array[$j];
                }
                else{
                    $URSRC_menuid=$URSRC_menuid .",".$URSRC_sub_submenu_array[$j];
                }
            }
            $fileid='';
            $menu_files=array_values(array_unique($menu_files));
            for($i=0;$i<count($menu_files);$i++){
                if($i==0){
                    $fileid=$menu_files[$i];
                }
                else{
                    $fileid=$fileid.','.$menu_files[$i];
                }
            }
            if(count($menu_files)==0){
                $fileid='null';
            }
            else{
                $fileid="'".$fileid."'";
            }
            $schema_name='';
            $this->load->model('EILIB/Mdl_eilib_common_function');
            if($URSRC_mainradiobutton=="ROLE CREATION"){
                $URSRC_basicrole=str_replace("_"," ",$basicroles);
                $URSRC_customrolename=$customrole;
                $URSRC_rolecreation=("CALL SP_ROLE_CREATION_INSERT('".$URSRC_customrolename."','".$URSRC_basicrole."','".$URSRC_menuid."',".$fileid.",'".$UserStamp."','".$schema_name."',@ROLE_CRTNINSRTFLAG)");
                $this->db->query($URSRC_rolecreation);
                $URSRC_flag_rolecrinsrtselect=('SELECT @ROLE_CRTNINSRTFLAG AS ROLE_CRTNINSRTFLAG');
                $URSRC_flag_rolecrinsrtselect_rs = $this->db->query($URSRC_flag_rolecrinsrtselect);
                $URSRC_flag_rolecrinsrtinsert=$URSRC_flag_rolecrinsrtselect_rs->row()->ROLE_CRTNINSRTFLAG;
                return $URSRC_flag_rolecrinsrtinsert;
            }
            else if($URSRC_mainradiobutton=="BASIC ROLE MENU CREATION"||$URSRC_mainradiobutton=="BASIC ROLE MENU SEARCH UPDATE"){
                $URSRC_radio_basicrole=str_replace("_"," ",$URSRC_radio_basicroles);
                $URSRC_checkbox_basicrole=$URSRC_cb_basicroles;
                $URSRC_checkbox_basicrole_array='';
                for($i=0;$i<count($URSRC_checkbox_basicrole);$i++){
                    if($i==0){
                        $URSRC_checkbox_basicrole_array=str_replace("_"," ",$URSRC_checkbox_basicrole[$i]);
                    }
                    else{
                        $URSRC_checkbox_basicrole_array=$URSRC_checkbox_basicrole_array.','.str_replace("_"," ",$URSRC_checkbox_basicrole[$i]);
                    }
                }
                if($URSRC_mainradiobutton=="BASIC ROLE MENU CREATION"){
                    $URSRC_basicrole_menu_creation=("CALL SP_USER_RIGHTS_BASIC_PROFILE_SAVE ('".$UserStamp."','".$URSRC_radio_basicrole."','".$URSRC_checkbox_basicrole_array."', '".$URSRC_menuid."',@BASIC_PROFILESAVEFLAG)");
                    $this->db->query($URSRC_basicrole_menu_creation);
                    $URSRC_flag_bscprfsveselect=("SELECT @BASIC_PROFILESAVEFLAG as BASIC_PROFILESAVEFLAG");
                    $URSRC_flag_bscprfsveselect_rs = $this->db->query($URSRC_flag_bscprfsveselect);
                    $URSRC_flag_bscprfsveinsert=$URSRC_flag_bscprfsveselect_rs->row()->BASIC_PROFILESAVEFLAG;
                    return $URSRC_flag_bscprfsveinsert;
                }
                else if($URSRC_mainradiobutton=="BASIC ROLE MENU SEARCH UPDATE"){
                     $URSRC_basicrole_menu_update=("CALL SP_USER_RIGHTS_BASIC_PROFILE_UPDATE ('".$UserStamp."','".$URSRC_radio_basicrole."','".$URSRC_checkbox_basicrole_array."', '".$URSRC_menuid."',@BASIC_PRFUPDATE,@BASICROLE_TEMPTABLEDROP,@SAVE_POINT)");
                     $this->db->query($URSRC_basicrole_menu_update);
                     $URSRC_flag_bscprfupdselect="SELECT @BASIC_PRFUPDATE as BASIC_PRFUPDATE,@BASICROLE_TEMPTABLEDROP as BASICROLE_TEMPTABLEDROP,@SAVE_POINT as SAVE_POINT";
                     $URSRC_flag_bscprfupdrs=$this->db->query($URSRC_flag_bscprfupdselect);
                     $URSRC_flag_bscprfupdinsert=$URSRC_flag_bscprfupdrs->row()->BASIC_PRFUPDATE;
                     $URSRC_temptble_bscprfupdinsert=$URSRC_flag_bscprfupdrs->row()->BASICROLE_TEMPTABLEDROP;
                     $save_point=$URSRC_flag_bscprfupdrs->row()->SAVE_POINT;
                     if($URSRC_flag_bscprfupdinsert==1){
                       $URSRC_sharedocflag=$this->URSRC_updateSharedDocuments("",'',$URSRC_radio_basicrole,$service);
                         if($URSRC_sharedocflag==0){
                             $this->db->trans_savepoint_rollback($save_point);
                         }
                         $this->db->trans_savepoint_release($save_point) ;
                     }
                    else{
                        $this->db->trans_savepoint_rollback($save_point);
                    }
                    $drop_query = "DROP TABLE ".$URSRC_temptble_bscprfupdinsert;
                    $this->db->query($drop_query);
                    return $URSRC_flag_bscprfupdinsert;
                }
            }
            else{
                $URSRC_customrolename=$customerrole_upd;
                $URSRC_basicrole=str_replace("_"," ",$basicroles);
                $URSRC_rolecreation_update=("CALL SP_ROLE_CREATION_UPDATE('".$URSRC_customrolename."','".$URSRC_basicrole."','".$URSRC_menuid."',".$fileid.",'".$UserStamp."','".$schema_name."',@ROLE_CREATIONUPDATE,@ROLE_TEMPTABLEDROP,@SAVE_POINT)");//,@TEMP_OUT_REMOVE_MENU,@TEMP_OUT_INSERT_FILE,@TEMP_OUT_REMOVE_FILE,@REVOKE_TEMP_PM_TABLE,@REVOKE_TEMP_PM_UNIQUE_TABLE,@REVOKE_TEMP_PM_SP_TABLE,@GRANT_TEMP_PM_TABLE,@GRANT_TEMP_PM_UNIQUE_TABLE,@GRANT_TEMP_PM_SP_TABLE)");
                $this->db->query($URSRC_rolecreation_update);
                $URSRC_flag_rolecreselect=("SELECT @ROLE_CREATIONUPDATE as ROLE_CREATIONUPDATE,@ROLE_TEMPTABLEDROP as ROLE_TEMPTABLEDROP,@SAVE_POINT as SAVE_POINT");//,@TEMP_OUT_REMOVE_MENU,@TEMP_OUT_INSERT_FILE,@TEMP_OUT_REMOVE_FILE,@REVOKE_TEMP_PM_TABLE,@REVOKE_TEMP_PM_UNIQUE_TABLE,@REVOKE_TEMP_PM_SP_TABLE,@GRANT_TEMP_PM_TABLE,@GRANT_TEMP_PM_UNIQUE_TABLE,@GRANT_TEMP_PM_SP_TABLE";
                $URSRC_flag_rolecreselect_rs = $this->db->query($URSRC_flag_rolecreselect);
                $URSRC_flag_rolecreinsert=$URSRC_flag_rolecreselect_rs->row()->ROLE_CREATIONUPDATE;
                $URSRC_temptble_bscprfupdinsert=$URSRC_flag_rolecreselect_rs->row()->ROLE_TEMPTABLEDROP;
                $save_point=$URSRC_flag_rolecreselect_rs->row()->SAVE_POINT;
                if($URSRC_flag_rolecreinsert==1){
                  $URSRC_sharedocflag=$this->URSRC_updateSharedDocuments($URSRC_customrolename,'','',$service);
                    if($URSRC_sharedocflag==0){
                        $this->db->trans_savepoint_rollback($save_point);
                    }
                    $this->db->trans_savepoint_release($save_point) ;
                }
                else{
                    $this->db->trans_savepoint_rollback($save_point);
                }
                if($URSRC_temptble_bscprfupdinsert!=null){
                    $drop_query = "DROP TABLE ".$URSRC_temptble_bscprfupdinsert;
                    $this->db->query($drop_query);
                }
                $final_flag=[$URSRC_flag_rolecreinsert,$URSRC_sharedocflag];
                return $final_flag;
            }
        }
        catch(Exception $e)
        {
            ////            Logger.log("SCRIPT EXCEPTION:"+err)
            //            //      if(URSRC_conn.isClosed()){OpenConnection(URSRC_conn);}
            //            //      if(err=='This Connection is closed')
            //            //      {OpenConnection(URSRC_conn);}
            $this->db->trans_savepoint_rollback($save_point);
////      URSRC_RoleupdateDroptemptable(URSRC_conn,URSRC_temptble_bscprfupdinsert);
              if($URSRC_sharedocflag==1)
              {
                  if($URSRC_radio_basicrole!=""&&$URSRC_radio_basicrole!='undefined')
                      $this->URSRC_updateSharedDocuments($URSRC_customrolename,'',$URSRC_radio_basicrole,$service);
                  else
                      $this->URSRC_updateSharedDocuments($URSRC_customrolename,'','',$service);
              }
              $this->db->trans_commit();
////      URSRC_conn.close();
////      return (Logger.getLog())
        }
    }

    public function URSRC_login_creation_save($URSRC_mainradiobutton,$URSRC_tb_joindate,$URSRC_custom_role,$URSRC_tb_loginid,$USERSTAMP,$service){
        $URSRC_sharedocflag='';$URSRC_sharecalflag='';$URSRC_sharesiteflag=0;
        try{
          $URSRC_temptable='';
          $URSRC_temptable1='';
          $URSRC_temptable2='';
          $loginid='';
          $URSRC_joindate = date('Y-m-d',strtotime($URSRC_tb_joindate));
          $URSRC_custom_role=str_replace("_"," ",$URSRC_custom_role);
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $this->db->query('SET AUTOCOMMIT=0');
            $this->db->query('START TRANSACTION');
                  //      URSRC_conn.setAutoCommit(false);
              if($URSRC_mainradiobutton=="LOGIN CREATION"){
                  $URSRC_loginid=$URSRC_tb_loginid;
                  $loginid=$URSRC_loginid;
                  $login_creation_insert = "CALL SP_LOGIN_CREATION_INSERT('$URSRC_loginid','$URSRC_custom_role','$URSRC_joindate','$USERSTAMP',@TEMPTABLE,@LOGIN_CREATIONFLAG,@SAVE_POINT)";
                  $this->db->query($login_creation_insert);
                  $temptable=('SELECT @TEMPTABLE AS TEMPTABLE');
                  $flag=('SELECT @LOGIN_CREATIONFLAG as FLAG');
                  $savepoint=('SELECT @SAVE_POINT as SAVE_POINT');
                  $query1 = $this->db->query($temptable);
                  $query2 = $this->db->query($flag);
                  $query3=$this->db->query($savepoint);
                  $temp_tablename=$query1->row()->TEMPTABLE;
                  $URSRC_flag_lgncreinsert=$query2->row()->FLAG;
                  $save_point=$query3->row()->SAVE_POINT;
                  if($URSRC_flag_lgncreinsert==1){
                      $URSRC_sharedocflag= $this->Mdl_eilib_common_function->URSRC_shareDocuments($URSRC_custom_role,$URSRC_loginid,$service);
                      if($URSRC_sharedocflag==1){
                         $URSRC_sharecalflag=$this->Mdl_eilib_common_function->USRC_shareUnSharecalender($URSRC_loginid,'writer',$service);
                          if($URSRC_sharecalflag==0){
                              $this->db->trans_savepoint_rollback($save_point);
//                              $this->db->trans_rollback();
                              $this->Mdl_eilib_common_function->URSRC_unshareDocuments($URSRC_custom_role,$URSRC_loginid,$service);
                          }
                     }
                     else{
                         $this->db->trans_savepoint_rollback($save_point);
//                          $this->db->trans_rollback();
                          $this->Mdl_eilib_common_function->URSRC_unshareDocuments($URSRC_custom_role,$URSRC_loginid,$service);
                     }
                      $this->db->trans_savepoint_release($save_point) ;

                  }
                  else{
                      $this->db->trans_savepoint_rollback($save_point);
                  }
                  if($URSRC_temptable!=null){
                      $drop_query = "DROP TABLE ".$temp_tablename;
                      $this->db->query($drop_query);
                  }
//                  $this->db->trans_commit();
                  $final_flag=[$URSRC_flag_lgncreinsert,$URSRC_sharedocflag,$URSRC_sharecalflag];
                  return $final_flag;
              }
              else{
                  $URSRC_sharecalflag=1;
                  $URSRC_loginid=$_POST['URSRC_lb_loginid'];
                  $loginid=$URSRC_loginid;
                  $URSRC_role_name=$_POST['URSRC_old_rolename'];
                  $URSRC_logincreation_update=("CALL SP_LOGIN_UPDATE('".$URSRC_loginid."','".$URSRC_custom_role."','".$URSRC_joindate."','".$USERSTAMP."',@TEMPTABLE1,@TEMPTABLE2,@LOGIN_UPDATEFLAG,@SAVE_POINT)");
                  $this->db->query($URSRC_logincreation_update);
                  $URSRC_flag_lgnupdselect="SELECT @TEMPTABLE1 as TEMPTABLE1 ,@TEMPTABLE2 as TEMPTABLE2,@LOGIN_UPDATEFLAG as LOGIN_UPDATEFLAG,@SAVE_POINT as SAVE_POINT";
                  $URSRC_flag_lgnupdrs=$this->db->query($URSRC_flag_lgnupdselect);
                  $URSRC_flag_lgnupdinsert=$URSRC_flag_lgnupdrs->row()->LOGIN_UPDATEFLAG;
                  $URSRC_temptable1=$URSRC_flag_lgnupdrs->row()->TEMPTABLE1;
                  $URSRC_temptable2=$URSRC_flag_lgnupdrs->row()->TEMPTABLE2;
                  $save_point=$URSRC_flag_lgnupdrs->row()->SAVE_POINT;
                  if($URSRC_flag_lgnupdinsert==1){
                        if($URSRC_role_name!==$URSRC_custom_role){
                            $URSRC_sharedocflag=$this->URSRC_updateSharedDocuments($URSRC_custom_role,$URSRC_loginid,'',$service);
                            if($URSRC_sharedocflag==0){
                                $this->db->trans_savepoint_rollback($save_point);
//                                $this->db->trans_rollback();
                            }
                        }
                      $this->db->trans_savepoint_release($save_point) ;
                  }
                  else{

                      $this->db->trans_savepoint_rollback($save_point);
                  }
                  if($URSRC_temptable1!=null&&$URSRC_temptable1!='undefined'){
                    $drop_query = "DROP TABLE ".$URSRC_temptable1;
                    $this->db->query($drop_query);
                  }
                  if($URSRC_temptable2!=null&&$URSRC_temptable2!='undefined'){
                    $drop_query = "DROP TABLE ".$URSRC_temptable2;
                    $this->db->query($drop_query);
                  }
//                  $this->db->trans_commit();
                  $final_flag=[$URSRC_flag_lgnupdinsert,$URSRC_sharedocflag,$URSRC_sharecalflag];
                  return $final_flag;
              }
          }
          catch(Exception $e){
            //        Logger.log("SCRIPT EXCEPTION:"+err)
            //      URSRC_conn.rollback();
              $this->db->trans_savepoint_rollback($save_point);
//                $this->db->trans_rollback();
            //      if(radiobutton=="LOGIN CREATION"){
            //          if(URSRC_temptable!='null'){
            //              eilib.DropTempTable(URSRC_conn,URSRC_temptable)
            //        }
            //          if(URSRC_sharedocflag==1)
            //          {
            //              URSRC_unshareDocuments(URSRC_conn,custom_role,loginid);
            //          }
            //          if(URSRC_sharesiteflag==1)
            //          {
            //              URSRC_removeViewer(URSRC_conn,loginid)
            //        }
            //          if(URSRC_sharecalflag==1)
            //          {
            //              USRC_shareUnSharecalender(URSRC_conn,loginid,'none');
            //          }
            //      }
            //      else{
            //          if(URSRC_temptable1!=null&&URSRC_temptable1!=undefined){
            //              eilib.DropTempTable(URSRC_conn,URSRC_temptable1);}
            //          if(URSRC_temptable2!=null&&URSRC_temptable2!=undefined){
            //              eilib.DropTempTable(URSRC_conn,URSRC_temptable2) ;}
            //          if(URSRC_sharedocflag==1)
            //          {
            //              URSRC_updateSharedDocuments(URSRC_conn,URSRC_custom_role,URSRC_loginid,'')
            //        }
            //      }
            //      return (Logger.getLog());
                return $e->getMessage();
            }

    }
     //Function to get file MIME type
    function get_MIME_type($service, $fileId) {
        try {
            $file = $service->files->get($fileId);
            $MIME_type= $file->getMimeType();
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
        return $MIME_type;
    }
    //FUNCTION TO SHARE DOCUMENTS WHEN ROLE UPDATED IN LOGIN ID UPDATION N ROLE UPDATION
    function URSRC_updateSharedDocuments($URSRC_customrolename,$LOGINID,$basicrole,$service){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $URSRC_sharedocflag='';
        try{
            $URSRC_fileid_array=array();
            $URSRC_loginid_array=array();
            $URSRC_folderid_array=array();
            $URSRC_fileid=array();
            $URSRC_loginid_array1=array();
            if ($basicrole!=""){
                $this->db->select();
                $this->db->from('USER_FILE_DETAILS UFD');
                $this->db->join('ROLE_CREATION  RC','UFD.RC_ID=RC.RC_ID');
                $this->db->join('USER_RIGHTS_CONFIGURATION URC','RC.URC_ID=URC.URC_ID');
                $this->db->join('FILE_PROFILE FP','FP.FP_ID=UFD.FP_ID');
                $this->db->where('URC.URC_DATA',$basicrole);
                $URSRC_select_fileid=$this->db->get();
            }
            else{
                $this->db->select();
                $this->db->from('USER_FILE_DETAILS UFD');
                $this->db->join('ROLE_CREATION  RC','UFD.RC_ID=RC.RC_ID');
                $this->db->join('FILE_PROFILE FP','FP.FP_ID=UFD.FP_ID');
                $this->db->where('RC_NAME',$URSRC_customrolename);
                $URSRC_select_fileid=$this->db->get();
            }
            foreach($URSRC_select_fileid->result_array() as $row){
                $fileid=$row["FP_FILE_ID"];
                $folderid=$row["FP_FOLDER_ID"];
                if($fileid!=null){
                $URSRC_fileid_array[]=($fileid);
                $URSRC_folderid_array[]=($folderid);
                $URSRC_fileid[]=($fileid);
                }
                if($fileid==null ||$fileid!=null){
                $URSRC_fileid_array[]=$row["FP_FOLDER_ID"];
                }
            }
            $URSRC_fileid_array=array_values(array_unique($URSRC_fileid_array));
            $URSRC_folderid_array=array_values(array_unique($URSRC_folderid_array));
            if ($basicrole!=""){
                $this->db->select();
                $this->db->from('USER_RIGHTS_CONFIGURATION URC');
                $this->db->join('ROLE_CREATION RC','RC.URC_ID=URC.URC_ID');
                $this->db->join('USER_ACCESS UA','UA.RC_ID=RC.RC_ID');
                $this->db->join('USER_LOGIN_DETAILS ULD','ULD.ULD_ID=UA.ULD_ID');
                $this->db->where('URC.URC_DATA="'.$basicrole.'" AND ULD.ULD_LOGINID NOT IN (SELECT ULD_LOGINID FROM VW_ACCESS_RIGHTS_REJOIN_LOGINID)');
                $URSRC_selected_loginid=$this->db->get();
            }
            else{
                $this->db->select();
                $this->db->from('USER_ACCESS UA');
                $this->db->join('ROLE_CREATION RC','UA.RC_ID=RC.RC_ID');
                $this->db->join('USER_LOGIN_DETAILS ULD','ULD.ULD_ID=UA.ULD_ID');
                $this->db->where('RC_NAME="'.$URSRC_customrolename.'" AND ULD.ULD_LOGINID NOT IN (SELECT ULD_LOGINID FROM VW_ACCESS_RIGHTS_REJOIN_LOGINID)');
                $URSRC_selected_loginid=$this->db->get();
            }
            foreach($URSRC_selected_loginid->result_array() as $row){
                    $URSRC_loginid_array[]=($row["ULD_LOGINID"]);
            }
            $URSRC_loginid_array=array_values(array_unique($URSRC_loginid_array));
            $URSRC_all_fileid_array=array();
            $this->db->select();
            $this->db->from('FILE_PROFILE');
            $this->db->where('FP_FILE_FLAG is null');
            $URSRC_select_allfiles=$this->db->get();
            foreach($URSRC_select_allfiles->result_array() as $row){
                $fileid=$row['FP_FILE_ID'];
                if($fileid!=null){
                    $URSRC_all_fileid_array[]=($fileid);
                }
                if($fileid==null || $fileid!=null){
                    $URSRC_all_fileid_array[]=$row["FP_FOLDER_ID"];
                }
            }
           $URSRC_all_fileid_array=array_values(array_unique($URSRC_all_fileid_array));
           $URSRC_diff_array= array();
           $URSRC_diff_array=array_diff($URSRC_all_fileid_array,$URSRC_fileid_array);//;getDifferenceArray($URSRC_fileid,$allid_array);
           $URSRC_diff_array=array_values($URSRC_diff_array);
           $URSRC_new_fileid_array=array();
            //OLD FOLDER /FILE LL BE REMOVED FROM ALL THE FOLDERS/FILES
           if($LOGINID==''){
                for($j=0;$j<count($URSRC_loginid_array);$j++){
                   for($i=0;$i<count($URSRC_diff_array);$i++){
                        $Folder_editor1=$this->Mdl_eilib_common_function->URSRC_GetAllEditors($service,$URSRC_diff_array[$i]);
                        if(count($Folder_editor1)==0){
                            $URSRC_sharedocflag=0;
                            break;
                        }
                        else $URSRC_sharedocflag=1;
                        for($k=0;$k<count($Folder_editor1);$k++){
                            if($Folder_editor1[$k]=='')continue;
                            if($URSRC_loginid_array[$j]==$Folder_editor1[$k]){
                                $URSRC_sharedocflag=$this->URSRC_RemoveEditor($service,$URSRC_diff_array[$i],$URSRC_loginid_array[$j]);
                            }
                        }
                   }
                }
           }
           else{
               for($i=0;$i<count($URSRC_diff_array);$i++){
                   $Folder_editor1=$this->Mdl_eilib_common_function->URSRC_GetAllEditors($service,$URSRC_diff_array[$i]);
                   $Folder_editor1=$this->Mdl_eilib_common_function->URSRC_GetAllEditors($service,$URSRC_diff_array[$i]);
                   if(count($Folder_editor1)==0){
                      $URSRC_sharedocflag=0;
                      break;
                   }
                   else $URSRC_sharedocflag=1;
                    for($k=0;$k<count($Folder_editor1);$k++){
                          if($Folder_editor1[$k]=='')continue;
                          if($LOGINID==$Folder_editor1[$k]){
                             $URSRC_sharedocflag=$this->URSRC_RemoveEditor($service,$URSRC_diff_array[$i],$LOGINID);
                          }
                    }
               }
           }
          //GET CURRENT FOLDER OR FILE FOR THE SELECTED ROLE FOR THE LOGIN ID
          //IF ROLE UPDATED
          if($LOGINID==''){
            for($k=0;$k<count($URSRC_fileid_array);$k++){
                $Folder_editor=$this->Mdl_eilib_common_function->URSRC_GetAllEditors($service,$URSRC_fileid_array[$k]);
                for($l=0;$l<count($Folder_editor);$l++){
                        for($m=0;$m<count($URSRC_loginid_array);$m++){
                            if($Folder_editor[$l]=='')continue;
                    if($URSRC_loginid_array[$m]==$Folder_editor[$l]){
                                $URSRC_new_fileid_array[]=($URSRC_fileid_array[$k]);
                    }
                  }
                }
            }
          }
          else{
             for($k=0;$k<count($URSRC_fileid_array);$k++){
                 $Folder_editor=$this->Mdl_eilib_common_function->URSRC_GetAllEditors($service,$URSRC_fileid_array[$k]);
                 //GET FOLDER/FILE IF CURRENT FOLDER/FILE SHARED TO LOGIN ID
                 for($l=0;$l<count($Folder_editor);$l++){
                    if($Folder_editor[$l]=='')continue;
                    if($LOGINID==$Folder_editor[$l]){
                        $URSRC_new_fileid_array[]=($URSRC_fileid_array[$k]);
                    }
                 }
             }
          }
          $URSRC_new_fileid_array=array_values(array_unique($URSRC_new_fileid_array));

          //GET FOLDER/FILE IF CURRENT FOLDER/FILE NOT SHARED TO LOGIN ID
          $URSRC_new_diff_array= array();
          $URSRC_new_diff_array=array_diff($URSRC_fileid_array,$URSRC_new_fileid_array);//;getDifferenceArray($URSRC_fileid,$allid_array);
          $URSRC_new_diff_array=array_values($URSRC_new_diff_array);

    //IF ROLE UPDATED
    if($LOGINID==''){
        for($j=0;$j<count($URSRC_loginid_array);$j++){
            for($m=0;$m<count($URSRC_new_diff_array);$m++){
//                var filename=DriveApp.getFolderById(URSRC_new_diff_array[m]).getName()
                $shar_Folder=$this->Mdl_eilib_common_function->URSRC_AddEditor($service,$URSRC_new_diff_array[$m],$URSRC_loginid_array[$j]);
//          var shar_Folder=DriveApp.getFolderById(URSRC_new_diff_array[m]).addEditor(URSRC_loginid_array[j]);
        }
      }
    }
    else{
        for($m=0;$m<count($URSRC_new_diff_array);$m++){
//            var filename=DriveApp.getFolderById(URSRC_new_diff_array[m]).getName()
            $shar_Folder=$this->Mdl_eilib_common_function->URSRC_AddEditor($service,$URSRC_new_diff_array[$m],$LOGINID);

//            var shar_Folder=DriveApp.getFolderById(URSRC_new_diff_array[m]).addEditor(LOGINID);
      }
    }
    $allid_array=array();
    if(count($URSRC_folderid_array)!=0){
        $folder=$URSRC_folderid_array[0];
        $allid_array=$this->URSRC_getAllFiles($service,$folder);//TO GET FOLDER FILES
    }
    $URSRC_new_diff_array1=array();
        if(count($URSRC_fileid)!=0){
            $URSRC_new_diff_array1=array_diff($allid_array,$URSRC_fileid);//;getDifferenceArray($URSRC_fileid,$allid_array);
            $URSRC_new_diff_array1=array_values($URSRC_new_diff_array1);

        //IF LOGIN ID ROLE N DATE UPDATED
        if($LOGINID!=''){
            for($k=0;$k<count($URSRC_new_diff_array1);$k++){
//                var file_type=DriveApp.getFileById(URSRC_new_diff_array1[k]).getMimeType();
         $filefoldeditors=$this->Mdl_eilib_common_function->URSRC_GetAllEditors($service,$URSRC_new_diff_array1[$k]);//URSRC_GetAllEditors(file_type,URSRC_new_diff_array1[k]);
          for($l=0;$l<count($filefoldeditors);$l++){
                    if($filefoldeditors[$l]=='')continue;
            if($LOGINID==$filefoldeditors[$l]){
                $this->URSRC_RemoveEditor($service,$URSRC_new_diff_array1[$k],$LOGINID);

            }
          }
        }
        }
        else{
            for($k=0;$k<count($URSRC_new_diff_array1);$k++){
          $foldereditors=$this->Mdl_eilib_common_function->URSRC_GetAllEditors($service,$URSRC_new_diff_array1[$k]);
          for($l=0;$l<count($foldereditors);$l++){
                    for($m=0;$m<count($URSRC_loginid_array);$m++){
                        if($foldereditors[$l]=='')continue;
              if($URSRC_loginid_array[$m]==$foldereditors[$l]){
                  $this->URSRC_RemoveEditor($service,$URSRC_new_diff_array1[$k],$URSRC_loginid_array[$m]);

              }
            }
          }
        }
        }
    }
  }

catch(Exception $e){
    $URSRC_sharedocflag=0;
}
return $URSRC_sharedocflag;
    }
    public  function URSRC_RemoveEditor($service,$fileid,$URSRC_loginid){
        $URSRC_sharedocflag='';
        try {
            $permissions = $service->permissions->listPermissions($fileid);
            $return_value= $permissions->getItems();
            $permission_id='';
            foreach ($return_value as $key => $value) {
                if ($value->emailAddress==$URSRC_loginid) {
                    $permission_id=$value->id;
                }
            }
            if($permission_id!=''){
                try {
                    $service->permissions->delete($fileid, $permission_id);
                } catch (Exception $e) {

                }
            }
            $URSRC_sharedocflag=1;

        } catch (Exception $e) {
//        print "An error occurred: " . $e->getMessage();
            $URSRC_sharedocflag=0;
        }
       return $URSRC_sharedocflag;

    }
    public function URSRC_GetAllFiles($service,$folderid){
        $children1 = $service->children->listChildren($folderid);
        $filearray1=$children1->getItems();
        $emp_uploadfilenamelist=array();
        foreach ($filearray1 as $child1) {
            $emp_uploadfilenamelist[]=($child1->getId());
        }
        return $emp_uploadfilenamelist;
    }

}