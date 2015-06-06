<?php
error_reporting(0);
class Mdl_customer_erm_entry_search_update extends CI_Model
{
    public function ERM_EntrySave($UserStamp,$username)
    {
      $Customername=$_POST['ERM_Entry_Customername'];
      $Rent=$_POST['ERM_Entry_Rent'];
      $MovingDate=$_POST['ERM_Entry_MovingDate'];
      $MovingDate=date('Y-m-d',strtotime($MovingDate));
      $Minimumstay=$this->db->escape_like_str($_POST['ERM_Entry_Minimumstay']);
      $Occupation_Data=$_POST['ERM_Entry_Occupation'];
      if($Occupation_Data=='OTHERS')
      {$Occupation=$_POST['ERM_Entry_Others'];}
      else{$Occupation=$_POST['ERM_Entry_Occupation'];}
      $Nationality=$this->db->escape_like_str($_POST['ERM_Entry_Nationality']);
      if($Nationality=='SELECT'){$Nationality='';}
      $Numberofguests=$this->db->escape_like_str($_POST['ERM_Entry_Numberofguests']);
      $Age=$this->db->escape_like_str($_POST['ERM_Entry_Age']);
      $Contactno=$_POST['ERM_Entry_Contactno'];
      $Mailid=$_POST['ERM_Entry_Emailid'];
      $Comments=$this->db->escape_like_str($_POST['ERM_Entry_Comments']);
      $CallQuery="CALL SP_ERM_INSERT('$Customername','$Rent','$MovingDate','$Minimumstay','$Occupation','$Nationality','$Numberofguests','$Age','$Contactno','$Mailid','$Comments','$UserStamp',@ERM_SUCCESSFLAG)";
      $this->db->query($CallQuery);
      $ERM_Entry_flag = 'SELECT @ERM_SUCCESSFLAG as FLAG_INSERT';
      $query = $this->db->query($ERM_Entry_flag);
      $Confirm_Meessage=$query->row()->FLAG_INSERT;
      $dataarray=array($Customername,$Rent,$_POST['ERM_Entry_MovingDate'],$_POST['ERM_Entry_Minimumstay'],$Occupation,$_POST['ERM_Entry_Nationality'],$_POST['ERM_Entry_Numberofguests'],$_POST['ERM_Entry_Age'],$Contactno,$Mailid,$_POST['ERM_Entry_Comments']);
      $subject="HELLO ".','."<font color='gray'></font><font color='#498af3'><b>.$username.</b> </font><br>PLEASE FIND ATTACHED NEW LEED DETAILS FROM ERM: <br>";
      $message = '<body><br><h> '.$subject.'</h><br</body>';
      $head_array=array('CUSTOMER NAME','RENT','MOVING DATE','MIN STAY','OCCUPATION','NATIONALITY','NO OF GUESTS','AGE','CONTACT','EMAIL','COMMENTS');
      if($Confirm_Meessage==1)
      {
          for($i=0;$i<count($head_array);$i++)
          {
            $value=$dataarray[$i];
            if($value=="" || $value==null)continue;
            $message .= '<body><table border="1"width="500" ><tr align="left" ><td width=40%>'.$head_array[$i].'</td><td width=60%>'.$value.'</td></tr></table></body>';
          }
      }
      $this->db->query("COMMIT");
      $returnarray=array($message,$Confirm_Meessage);
      return $returnarray;
    }
    public function getSearchOption()
    {
        $this->db->select('ERMCN_ID,ERMCN_DATA');
        $this->db->from('ERM_CONFIGURATION');
        $this->db->order_by("ERMCN_DATA", "ASC");
        $query = $this->db->get();
        return $query->result();
    }
    public function getCustomernames()
    {
        $this->db->select('ERM_CUST_NAME');
        $this->db->from('ERM_ENTRY_DETAILS');
        $this->db->order_by("ERM_CUST_NAME", "ASC");
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getCustomerContact()
    {
        $this->db->select('ERM_CONTACT_NO');
        $this->db->from('ERM_ENTRY_DETAILS');
        $this->db->order_by("ERM_CONTACT_NO", "ASC");
        $query = $this->db->get();
        return $query->result();
    }
    public function getUserstamp()
    {
        $this->db->select('ULD.ULD_LOGINID');
        $this->db->from('USER_LOGIN_DETAILS ULD,ERM_ENTRY_DETAILS ERM');
        $this->db->order_by("ULD.ULD_LOGINID", "ASC");
        $this->db->where('ERM.ULD_ID=ULD.ULD_ID');
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllDatas($Option,$Data1,$Data2,$timeZoneFormat)
    {
        if($Option==6)
        {
        $query=$this->db->query('SELECT ERM.ERM_ID,NC.NC_DATA,ERM.ERM_CUST_NAME,ERM.ERM_RENT,DATE_FORMAT(CONVERT_TZ(ERM.ERM_MOVING_DATE,'.$timeZoneFormat.'),"%d-%m-%Y") AS MOVING_DATE,ERM.ERM_MIN_STAY,EOD.ERMO_DATA,ERM.ERM_NO_OF_GUESTS,ERM.ERM_AGE,ERM.ERM_CONTACT_NO,ERM.ERM_EMAIL_ID,ERM.ERM_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ERM.ERM_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS ERM_TIME_STAMP FROM ERM_ENTRY_DETAILS ERM left join NATIONALITY_CONFIGURATION NC ON ERM.NC_ID=NC.NC_ID left join ERM_OCCUPATION_DETAILS EOD ON ERM.ERMO_ID=EOD.ERMO_ID left join USER_LOGIN_DETAILS ULD on ERM.ULD_ID=ULD.ULD_ID WHERE ULD.ULD_LOGINID="'.$Data1.'" ORDER BY ERM.ERM_MOVING_DATE,ERM.ERM_CUST_NAME');
        }
        elseif($Option==5)
        {
        $fromdate=date('Y-m-d',strtotime($Data1));
        $todate=date('Y-m-d',strtotime($Data2));
        $query=$this->db->query('SELECT ERM.ERM_ID,NC.NC_DATA,ERM.ERM_CUST_NAME,ERM.ERM_RENT,DATE_FORMAT(CONVERT_TZ(ERM.ERM_MOVING_DATE,'.$timeZoneFormat.'),"%d-%m-%Y") AS MOVING_DATE,ERM.ERM_MIN_STAY,EOD.ERMO_DATA,ERM.ERM_NO_OF_GUESTS,ERM.ERM_AGE,ERM.ERM_CONTACT_NO,ERM.ERM_EMAIL_ID,ERM.ERM_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ERM.ERM_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS ERM_TIME_STAMP FROM ERM_ENTRY_DETAILS ERM left join NATIONALITY_CONFIGURATION NC ON ERM.NC_ID=NC.NC_ID left join ERM_OCCUPATION_DETAILS EOD ON ERM.ERMO_ID=EOD.ERMO_ID left join USER_LOGIN_DETAILS ULD on ERM.ULD_ID=ULD.ULD_ID WHERE ERM.ERM_TIMESTAMP BETWEEN "'.$fromdate.'" AND "'.$todate.'" ORDER BY ERM.ERM_TIMESTAMP,ERM.ERM_CUST_NAME');
        }
        elseif($Option==4)
        {
        $query=$this->db->query('SELECT ERM.ERM_ID,NC.NC_DATA,ERM.ERM_CUST_NAME,ERM.ERM_RENT,DATE_FORMAT(CONVERT_TZ(ERM.ERM_MOVING_DATE,'.$timeZoneFormat.'),"%d-%m-%Y") AS MOVING_DATE,ERM.ERM_MIN_STAY,EOD.ERMO_DATA,ERM.ERM_NO_OF_GUESTS,ERM.ERM_AGE,ERM.ERM_CONTACT_NO,ERM.ERM_EMAIL_ID,ERM.ERM_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ERM.ERM_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS ERM_TIME_STAMP FROM ERM_ENTRY_DETAILS ERM left join NATIONALITY_CONFIGURATION NC ON ERM.NC_ID=NC.NC_ID left join ERM_OCCUPATION_DETAILS EOD ON ERM.ERMO_ID=EOD.ERMO_ID left join USER_LOGIN_DETAILS ULD on ERM.ULD_ID=ULD.ULD_ID WHERE NC_DATA="'.$Data1.'" ORDER BY ERM.ERM_MOVING_DATE,ERM.ERM_CUST_NAME');
        }
        elseif($Option==3)
        {
            $query=$this->db->query('SELECT ERM.ERM_ID,NC.NC_DATA,ERM.ERM_CUST_NAME,ERM.ERM_RENT,DATE_FORMAT(CONVERT_TZ(ERM.ERM_MOVING_DATE,'.$timeZoneFormat.'),"%d-%m-%Y") AS MOVING_DATE,ERM.ERM_MIN_STAY,EOD.ERMO_DATA,ERM.ERM_NO_OF_GUESTS,ERM.ERM_AGE,ERM.ERM_CONTACT_NO,ERM.ERM_EMAIL_ID,ERM.ERM_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ERM.ERM_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS ERM_TIME_STAMP FROM ERM_ENTRY_DETAILS ERM left join NATIONALITY_CONFIGURATION NC ON ERM.NC_ID=NC.NC_ID left join ERM_OCCUPATION_DETAILS EOD ON ERM.ERMO_ID=EOD.ERMO_ID left join USER_LOGIN_DETAILS ULD on ERM.ULD_ID=ULD.ULD_ID WHERE ERM.ERM_CONTACT_NO="'.$Data1.'" ORDER BY ERM.ERM_MOVING_DATE,ERM.ERM_CUST_NAME');
        }
        elseif($Option==2)
        {
            $query=$this->db->query('SELECT ERM.ERM_ID,NC.NC_DATA,ERM.ERM_CUST_NAME,ERM.ERM_RENT,DATE_FORMAT(CONVERT_TZ(ERM.ERM_MOVING_DATE,'.$timeZoneFormat.'),"%d-%m-%Y") AS MOVING_DATE,ERM.ERM_MIN_STAY,EOD.ERMO_DATA,ERM.ERM_NO_OF_GUESTS,ERM.ERM_AGE,ERM.ERM_CONTACT_NO,ERM.ERM_EMAIL_ID,ERM.ERM_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ERM.ERM_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS ERM_TIME_STAMP FROM ERM_ENTRY_DETAILS ERM left join NATIONALITY_CONFIGURATION NC ON ERM.NC_ID=NC.NC_ID left join ERM_OCCUPATION_DETAILS EOD ON ERM.ERMO_ID=EOD.ERMO_ID left join USER_LOGIN_DETAILS ULD on ERM.ULD_ID=ULD.ULD_ID WHERE ERM.ERM_CUST_NAME="'.$Data1.'" ORDER BY ERM.ERM_MOVING_DATE ASC');
        }
        elseif($Option==1)
        {
            $query=$this->db->query('SELECT ERM.ERM_ID,NC.NC_DATA,ERM.ERM_CUST_NAME,ERM.ERM_RENT,DATE_FORMAT(CONVERT_TZ(ERM.ERM_MOVING_DATE,'.$timeZoneFormat.'),"%d-%m-%Y") AS MOVING_DATE,ERM.ERM_MIN_STAY,EOD.ERMO_DATA,ERM.ERM_NO_OF_GUESTS,ERM.ERM_AGE,ERM.ERM_CONTACT_NO,ERM.ERM_EMAIL_ID,ERM.ERM_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(ERM.ERM_TIMESTAMP,'.$timeZoneFormat.'),"%d-%m-%Y %T") AS ERM_TIME_STAMP FROM ERM_ENTRY_DETAILS ERM left join NATIONALITY_CONFIGURATION NC ON ERM.NC_ID=NC.NC_ID left join ERM_OCCUPATION_DETAILS EOD ON ERM.ERMO_ID=EOD.ERMO_ID left join USER_LOGIN_DETAILS ULD on ERM.ULD_ID=ULD.ULD_ID WHERE ERM.ERM_RENT BETWEEN '.$Data1.' AND '.$Data2.' ORDER BY ERM.ERM_MOVING_DATE,ERM.ERM_CUST_NAME');
        }
        return $query->result();
    }
    public function ERM_Update_Record($Rowid,$Name,$Rent,$Movedate,$Minstay,$Occupation,$Nation,$Guests,$Custage,$Contactno,$Emailid,$Comment,$UserStamp,$timeZoneFormat,$username)
    {
        $Min_stay=$this->db->escape_like_str($Minstay);
        $Guest=$this->db->escape_like_str($Guests);
        $age=$this->db->escape_like_str($Custage);
        $Comments=$this->db->escape_like_str($Comment);
        $Movedate=date('Y-m-d',strtotime($Movedate));
        $CallQuery="CALL SP_ERM_UPDATE('$Occupation',$Rowid,'$Name','$Rent','$Movedate','$Min_stay','$Nation','$Guest','$age','$Contactno','$Emailid','$Comments','$UserStamp',@ERM_SUCCESSFLAG)";
        $this->db->query($CallQuery);
        $ERM_Entry_flag = 'SELECT @ERM_SUCCESSFLAG as FLAG_INSERT';
        $query = $this->db->query($ERM_Entry_flag);
        $Confirm_Meessage=$query->row()->FLAG_INSERT;
        $this->db->query("COMMIT");
        $Timestamp;
        if($Confirm_Meessage==1)
        {
            $SelectQuery="SELECT DATE_FORMAT(CONVERT_TZ(ERM_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS ERM_TIME_STAMP FROM ERM_ENTRY_DETAILS WHERE ERM_ID=".$Rowid;
            $query = $this->db->query($SelectQuery);
            $Timestamp=$query->row()->ERM_TIME_STAMP;
        }
        $Movedate=date('d-m-Y',strtotime($Movedate));
        $dataarray=array($Name,$Rent,$Movedate,$Minstay,$Occupation,$Nation,$Guests,$Custage,$Contactno,$Emailid,$Comment);
        $head_array=array('CUSTOMER NAME','RENT','MOVING DATE','MIN STAY','OCCUPATION','NATIONALITY','NO OF GUESTS','AGE','CONTACT','EMAIL','COMMENTS');
        $subject="HELLO ".','."<font color='gray'></font><font color='#498af3'><b>.$username.</b> </font><br>PLEASE FIND ATTACHED NEW LEED DETAILS FROM ERM: <br>";
        $message = '<body><br><h> '.$subject.'</h><br</body>';
        if($Confirm_Meessage==1)
        {
            for($i=0;$i<count($head_array);$i++)
            {
                $value=$dataarray[$i];
                if($value=="" || $value==null)continue;
                $message .= '<body><table border="1"width="500" ><tr align="left" ><td width=40%>'.$head_array[$i].'</td><td width=60%>'.$value.'</td></tr></table></body>';
            }
        }
        $Return_values=array($Confirm_Meessage,$Timestamp,$UserStamp,$message);
        return $Return_values;
    }
}