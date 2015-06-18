<?php
require_once 'google/appengine/api/mail/Message.php';
use \google\appengine\api\mail\Message;
class Mdl_finance_extract_deposit_pdf extends CI_Model{
    public function GetAllFilesName($service,$folderid){
        try{
            $children1 = $service->children->listChildren($folderid);
            $filenamelist=array();
            foreach ($children1->getItems() as $child) {
                if($service->files->get($child->getId())->getExplicitlyTrashed()==1)continue;
                $fileid=$service->files->get($child->getId())->id;
                $filename=$service->files->get($child->getId())->title;
                $filenamelist[]=['id'=>$fileid,'title'=>$filename];
            }
            return $filenamelist;
        }
        catch(Exception $ex){
            $filenamelisterr=0;
            return $filenamelisterr;
        }
    }
    //GET THE SHEET AND MONTH PRESENT IN THE SELECTED  SHEET  NAME
    public function Initial_data($service){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList('263,264,265,266,267,268,269,270,271,282,381,449,452,459,468');
        $srtemailarray= $this->Mdl_eilib_common_function->getProfileEmailId('DD');
        $DDE_month_array =[];
        $DDE_month_exequery ="SELECT DDC_DATA FROM DEPOSIT_DEDUCTION_CONFIGURATION WHERE CGN_ID=30";
        $DDE_errormsg_rs = $this->db->query($DDE_month_exequery);
        $DDE_folderid=$DDE_errormsg_rs->row()->DDC_DATA;
        $curdate=date('M-Y');
        $date=explode('-',$curdate);
        $DDE_currentdateyear=$date[1];
        $DDE_currentmonth=$date[0];
        $DDE_ssname_currentyear='EI_DEPOSIT_DEDUCTIONS_'.$DDE_currentdateyear;
        $DDE_getfiles = $this->GetAllFilesName($service,$DDE_folderid);
        if($DDE_getfiles==0){return ['Get_access'];}
        $DDE_flag_ss=0;
        $DDE_currentfile_id='';
        for($i=0;$i<count($DDE_getfiles);$i++){
            $DDE_oldfile=$DDE_getfiles[$i]['title'];
            $DDE_oldfile_id=$DDE_getfiles[$i]['id'];
            if($DDE_oldfile==$DDE_ssname_currentyear){
                $DDE_currentfile_id=$DDE_oldfile_id;
                $DDE_flag_ss=1;
            }
        }
        if($DDE_flag_ss==0){
            return ['DDE_flag_noss'=>'DDE_flag_noss','DDE_errorAarray'=>$ErrorMessage];
        }
        $shturl=$DDE_currentfile_id;
        $data=array('DDE_flag'=>1,'DDE_currentfile_id'=>$DDE_currentfile_id);
        $sheetarray=array();
        $sheetarray=$this->Mdl_eilib_common_function->Func_curl($data);
        $sheetarray=json_decode($sheetarray,true);
        $montharray=[];
        for($i=0;$i<count($sheetarray);$i++){
            if($sheetarray[$i]!=''){
                $flag=1;
                $montharray[]=($sheetarray[$i]);
            }
        }
        $montharray=array_reverse($montharray);
        $montherrmsg=(object)['montharray'=>$montharray,'DDE_errorAarray'=>$ErrorMessage,'srtemailarray'=>$srtemailarray,'shturl'=>$shturl];
        return $montherrmsg;
    }
    public function DDE_getsheet_unit($month,$shturl){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $data1=array('DDE_flag'=>2,'shturl'=>$shturl,'selectedsheet'=>$month);
        $unitarray=array();
        $unitarray=$this->Mdl_eilib_common_function->Func_curl($data1);
        $unitarray=json_decode($unitarray,true);
        $unitarray=array_values(array_unique($unitarray));
        sort($unitarray);
        return $unitarray;
    }
    public function DDE_customer_name($unitno,$month,$shturl){
        $sendcustname=[]; $DDE_same_name=[];
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $data2=array('DDE_flag'=>3,'shturl'=>$shturl,'selectedunit'=>$unitno,'selectedsheet'=>$month);
        $custarray=array();
        $custarray=$this->Mdl_eilib_common_function->Func_curl($data2);
        $custarray=json_decode($custarray,true);
        $custarray=array_values(array_unique($custarray));
        sort($custarray);
        for($i=0;$i<count($custarray);$i++){
            if(strpos($custarray[$i],'_')>0){
                if (explode('_', $custarray[$i])[1] != '') {
                    $sendcustname[] = (explode('_', $custarray[$i])[0]);
                }
            }
            else{
                $sendcustname[]=($custarray[$i]);
            }
            $DDE_same_name[]=($custarray[$i]);
        }
        return [$sendcustname,$DDE_same_name];
    }
    public function DDE_get_custid($unitno,$month,$name,$shturl){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $data3=array('DDE_flag'=>4,'shturl'=>$shturl,'selectedunit'=>$unitno,'selectedname'=>$name,'selectedsheet'=>$month);
        $custidarray=array();
        $custidarray=$this->Mdl_eilib_common_function->Func_curl($data3);
        $custidarray=json_decode($custidarray,true);
        if($custidarray[0]!="")
        {
            $custidarray=$custidarray;
        } else
        {
            $custidarray="0";
        }
        return $custidarray;
    }
    public function DDE_Dep_Exct_recversion($getid,$unitno,$month,$name,$shturl,$nocustid){
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $data4=array('DDE_flag'=>5,'shturl'=>$shturl,'selectedunit'=>$unitno,'selectedname'=>$name,'selectedsheet'=>$month,
            'getid'=>$getid,'nocustid'=>$nocustid);
        $recverarray=array();
        $recverarray=$this->Mdl_eilib_common_function->Func_curl($data4);
        $recverarray=json_decode($recverarray,true);
        return $recverarray;
    }
    public function DDE_Dep_Exctsubmit($shturl,$selectedunit,$customername,$checkarray,$selectedsheet,$customermail,$customeridname,$UserStamp){
        $check_array='';
        for($k=0;$k<count($checkarray);$k++){
            if($k==0){
                $check_array=$checkarray[$k];
            }
            else{
                $check_array=$check_array.'^^'.$checkarray[$k];
            }
        }
        $sub_exequery ="SELECT ETD .ETD_EMAIL_SUBJECT,ETD. ETD_EMAIL_BODY FROM  EMAIL_TEMPLATE_DETAILS ETD ,EMAIL_TEMPLATE ET WHERE (ET .ET_ID=ETD .ET_ID) AND ET_EMAIL_SCRIPT='DEPOSIT DEDUCTION'";
        $sub_rs = $this->db->query($sub_exequery);
            $subject_db=$sub_rs->row()->ETD_EMAIL_SUBJECT;
            $message_db=$sub_rs->row()->ETD_EMAIL_BODY;
        $rcontent = $customername." - ".$selectedunit;
        $subject =str_replace('[UNIT_NO - CUSTOMER_NAME]',$rcontent,$subject_db);
        $body =str_replace('[UNIT_NO-  CUSTOMER_NAME]',$rcontent,$message_db);
        $emailindex = strstr($customermail,'@',true);
        $eusername = strtoupper($emailindex);
        $body = str_replace('[MAILID_USERNAME]',$eusername,$body);
        $data5=array('DDE_flag'=>6,'shturl'=>$shturl,'selectedunit'=>$selectedunit,'customername'=>$customername,'checkarray'=>$check_array,
            'selectedsheet'=>$selectedsheet,'customeridname'=>$customeridname);
        $submit_array=array();$submitarray=[];
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $submit_array=$this->Mdl_eilib_common_function->Func_curl($data5);
        $submitarray=json_decode($submit_array,true);
        $EmailDisplayname=$this->Mdl_eilib_common_function->Get_MailDisplayName('DEPOSIT_DEDUCTION');
        $pdfheader=$selectedunit.'-'.$customername;
        try {
            $message = new Message();
            $message->setSender($EmailDisplayname.'<'.$UserStamp.'>');
            $message->addTo($customermail);
            $message->setSubject($subject);
            $message->setTextBody($body);
            for ($i = 0; $i < count($submitarray); $i++) {
                $data = implode(array_map("chr", $submitarray[$i]));
                $message->addAttachment($pdfheader . '.pdf', $data);
            }
            $message->send();
            return 'DDC_flag_extract';
        }
        catch (InvalidArgumentException $e) {
            return $e->getMessage();
        }
    }
}