<?php
//******************************************View All Card********************************************//
//VER 0.01-SD:09/05/2015 ED:12/05/2015,initial version BY RAJA
//*******************************************************************************************************//
class Mdl_access_card_view extends CI_Model{
    public function Initial_data($ErrorMessage){
        $this->db->select('UNIT_NO');
        $this->db->from('UNIT');
        $this->db->order_by('UNIT_NO');
        $query1 = $this->db->get();
        $result1=[];
        foreach($query1->result_array() as $row){
            $result1[]=$row['UNIT_NO'];
        }
        $this->db->select('UASD.UASD_ACCESS_CARD');
        $this->db->from('UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U');
        $this->db->where('U.UNIT_ID=UASD.UNIT_ID AND UASD.UASD_ACCESS_CARD IS NOT NULL');
        $this->db->order_by('UASD.UASD_ACCESS_CARD');
        $query2 = $this->db->get();
        $result2=[];
        foreach($query2->result_array() as $row){
            $result2[]=$row['UASD_ACCESS_CARD'];
        }
        $this->db->select('CONCAT(`CCN_ID`,"_",`CCN_DATA`) AS DATA',FALSE);
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CCN_ID IN (18,21,31,40)');
        $this->db->order_by('CCN_DATA');
        $query3 = $this->db->get();
        $result3=[];
        foreach($query3->result_array() as $row){
            $result3[]=$row['DATA'];
        }
        $this->db->select('DISTINCT CONCAT(C.CUSTOMER_FIRST_NAME," "," ",C.CUSTOMER_LAST_NAME) AS CUSTOMERNAME',FALSE);
        $this->db->from('CUSTOMER C');
        $this->db->group_by('C.CUSTOMER_FIRST_NAME');
        $this->db->group_by('C.CUSTOMER_ID');
        $query4 = $this->db->get();
        $result4=[];
        foreach($query4->result_array() as $row){
            if($row['CUSTOMERNAME']!=null){
                $result4[]=$row['CUSTOMERNAME'];
            }
        }
        $resultset=array($result1,$result2,$result3,$ErrorMessage,$result4);
        return $resultset;
    }
    public function Cardno_details($unitno,$cardno,$option,$USERSTAMP){
        if($option==18)
        {
            $card_tablename='';$card_flag='';
            $this->db->query("CALL SP_ACCESS_CARD_STATUS('".$cardno."','".$USERSTAMP."',@CARDSTATUSTMPTBLNAM,@CARDFLAG)");
            $cardoutparm_query = 'SELECT @CARDSTATUSTMPTBLNAM AS CARD_TEMP_TABLE,@CARDFLAG AS CARDFLAG';
            $cardoutparm_result = $this->db->query($cardoutparm_query);
            $card_tablename=$cardoutparm_result->row()->CARD_TEMP_TABLE;
            $card_flag=$cardoutparm_result->row()->CARDFLAG;
            $cardtable_result = $this->db->get($card_tablename);
            // for temp table result array
            $CV_carddetails_array=array();
            foreach ($cardtable_result->result_array() as $row)
            {
                $CV_access_unitno=$row["UNITNO"];
                $CV_access_active=$row["ACTIVE_ACCESS_CARD"];
                if($CV_access_active==null){ $CV_access_active="";}
                $CV_access_inventory=$row["INVENTORY_ACCESS_CARD"];
                if($CV_access_inventory==null){ $CV_access_inventory="";}
                $CV_access_lost=$row["LOST_ACCESS_CARD"];
                if($CV_access_lost==null){ $CV_access_lost="";}
                $CV_access_reason=$row["ACCESS_REASON"];
                if($CV_access_reason==null){$CV_access_reason="";}
                $CV_access_comment=$row["ACCESS_COMMENTS"];
                if($CV_access_comment==null){$CV_access_comment="";}
                $CV_carddetails_array[]=(object)['unitno'=>$CV_access_unitno,'active'=>$CV_access_active,'inventory'=>$CV_access_inventory,'lost'=>$CV_access_lost,'reason'=>$CV_access_reason,'comments'=>$CV_access_comment];
            }
            $CV_finalcarddetails_array=array($CV_carddetails_array,$card_flag);
            $drop_query = "DROP TABLE ".$card_tablename;
            $this->db->query($drop_query);
            return $CV_finalcarddetails_array;
        }
        elseif($option==31){
            $unit_tablename='';$unit_flag='';
            $this->db->query("CALL SP_ACCESS_CARD_SEARCH_BY_UNIT(".$unitno.",'".$USERSTAMP."',@BYUNITTMPTBLNAM,@ACCESSSEARCHSUCCESSMSG)");
            $unitoutparm_query = 'SELECT @BYUNITTMPTBLNAM AS UNIT_TEMP_TABLE,@ACCESSSEARCHSUCCESSMSG AS UNITFLAG';
            $unitoutparm_result = $this->db->query($unitoutparm_query);
            $unit_tablename=$unitoutparm_result->row()->UNIT_TEMP_TABLE;
            $unit_flag=$unitoutparm_result->row()->UNITFLAG;
            $unittable_result = $this->db->get($unit_tablename);
            $CV_finalarray=[];
            $CV_lostcard_array=[];
            $CV_lostcard1_array=[];
            $CV_activecard_array=[];
            $CV_inventorycard_array=[];
            $CV_reason_array=[];
            foreach ($unittable_result->result_array() as $row)
            {
                $CV_access_active=$row["ACTIVE_CARD"];
                if($CV_access_active!=null){ $CV_activecard_array[]=($CV_access_active);}
                $CV_access_inventory=$row["INVENTORY_CARD"];
                if($CV_access_inventory!=null){$CV_inventorycard_array[]=($CV_access_inventory);}
                $CV_access_customer_lost=$row["CUSTOMER_OLD_CARD"];
                if($CV_access_customer_lost!=null){ $CV_lostcard_array[]=($CV_access_customer_lost);}
                $CV_access_employee_lost=$row["EMPLOYEE_LOST_CARD"];
                if($CV_access_employee_lost!=null){ $CV_lostcard1_array[]=($CV_access_employee_lost);}
                $CV_access_reason=$row["REASON"];
                if($CV_access_reason!=null){$CV_reason_array[]=($CV_access_reason);}
            }
            if(count($CV_lostcard1_array)!=0){
                $CV_lostcard_array[]=($CV_lostcard1_array);
            }
            if(count($CV_activecard_array)!=0 || count($CV_inventorycard_array)!=0 || count($CV_lostcard_array)!=0 || count($CV_reason_array)!=0){
                $CV_finalarray=[$CV_activecard_array,$CV_inventorycard_array,$CV_lostcard_array,$CV_reason_array];
            }
            $CV_final_array=array($CV_finalarray,$unit_flag);
            $drop_query = "DROP TABLE ".$unit_tablename;
            $this->db->query($drop_query);
            return $CV_final_array;
        }
        elseif($option==40){
            $allunit_tablename='';$allunit_flag='';
            $this->db->query("CALL SP_ACCESS_CARD_SEARCH_BY_ALL_UNIT('".$USERSTAMP."',@BYALLUNITTMPTBLNAM,@FLAG)");
            $allunitoutparm_query = 'SELECT @BYALLUNITTMPTBLNAM AS ALLUNIT_TEMP_TABLE,@FLAG AS ALLUNITFLAG';
            $allunitoutparm_result = $this->db->query($allunitoutparm_query);
            $allunit_tablename=$allunitoutparm_result->row()->ALLUNIT_TEMP_TABLE;
            $allunit_flag=$allunitoutparm_result->row()->ALLUNITFLAG;
            $allunittable_result = $this->db->query('SELECT * FROM '.$allunit_tablename.' ORDER BY UNITNO');
            $CV_carddetails=[];
            foreach ($allunittable_result->result_array() as $row){
                $CV_access_unitno=$row["UNITNO"];
                $CV_access_active=$row["ACTIVE_CARD"];
                if($CV_access_active==null){$CV_access_active='';}
                $CV_access_inventory=$row["INVENTORY_CARD"];
                if($CV_access_inventory==null){ $CV_access_inventory='';}
                $CV_access_customer_lost=$row["CUSTOMER_LOST_CARD"];
                if($CV_access_customer_lost==null){ $CV_access_customer_lost='';}
                $CV_access_employee_lost=$row["EMPLOYEE_LOST_CARD"];
                if($CV_access_employee_lost==null){ $CV_access_employee_lost='';}
                $CV_access_reason=$row["REASON"];
                if($CV_access_reason==null){$CV_access_reason='';}
                $CV_carddetails[]=(object)['unitno'=>$CV_access_unitno,'active'=>$CV_access_active,'inventory'=>$CV_access_inventory,'customer_lost'=>$CV_access_customer_lost,'employee_lost'=>$CV_access_employee_lost,'reason'=>$CV_access_reason];
            }
            $CV_final_array=array($CV_carddetails,$allunit_flag);
            $drop_query = "DROP TABLE ".$allunit_tablename;
            $this->db->query($drop_query);
            return $CV_final_array;
        }
    }
    public function Customer_id($custname){
        $CV_firstname='';
        $CV_lastname='';
        $CV_customername=explode('  ',$custname);
        $CV_firstname=$CV_customername[0];
        $CV_lastname=$CV_customername[1];
        $CV_custid=[];
        $this->db->select('C.CUSTOMER_ID');
        $this->db->from('CUSTOMER C');
        $this->db->where('C.CUSTOMER_FIRST_NAME="'.$CV_firstname.'" AND C.CUSTOMER_LAST_NAME="'.$CV_lastname.'"');
        $this->db->order_by('C.CUSTOMER_ID');
        $cusdidqry = $this->db->get();
        foreach ($cusdidqry->result_array() as $row){
            $CV_custid[]=$row["CUSTOMER_ID"];
        }
        return $CV_custid;
    }
    public function Customer_values($custid,$USERSTAMP){
        $cust_tablename='';$cust_flag='';
        $this->db->query("CALL SP_ACCESS_CARD_SEARCH_BY_CUSTOMER('".$custid."','".$USERSTAMP."',@BYCUSTOMERTMPTBLNAM,@FLAG_MESSAGE)");
        $custoutparm_query = 'SELECT @BYCUSTOMERTMPTBLNAM AS CUST_TEMP_TABLE,@FLAG_MESSAGE AS CUSTFLAG';
        $custoutparm_result = $this->db->query($custoutparm_query);
        $cust_tablename=$custoutparm_result->row()->CUST_TEMP_TABLE;
        $cust_flag=$custoutparm_result->row()->CUSTFLAG;
        $this->db->select();
        $this->db->from($cust_tablename);
        $this->db->order_by('UNITNO');
        $custtable_result = $this->db->get();
        $CV_return_array=[];
        foreach ($custtable_result->result_array() as $row){
            $CV_access_unitno=$row["UNITNO"];
            $CV_access_active=$row["ACTIVE_CARD"];
            if($CV_access_active==null){ $CV_access_active="";}
            $CV_access_lost=$row["OLD_CARD"];
            if($CV_access_lost==null){ $CV_access_lost="";}
            $CV_access_reason=$row["REASON"];
            if($CV_access_reason==null){$CV_access_reason="";}
            $CV_access_comment=$row["COMMENTS"];
            if($CV_access_comment==null){$CV_access_comment="";}
            $CV_cust_carddetails=(object)['unitno'=>$CV_access_unitno,'active'=>$CV_access_active,'lost'=>$CV_access_lost,'reason'=>$CV_access_reason,'comments'=>$CV_access_comment];
            $CV_return_array[]=($CV_cust_carddetails);
        }
        $CV_final_custarray=array($CV_return_array,$cust_flag);
        $drop_query = "DROP TABLE ".$cust_tablename;
        $this->db->query($drop_query);
        return $CV_final_custarray;
    }
    public function Pdf_creation($custid,$unitno,$cardno,$option,$USERSTAMP){
        if($option==18)
        {
            $card_tablename='';
            $this->db->query("CALL SP_ACCESS_CARD_STATUS('".$cardno."','".$USERSTAMP."',@CARDSTATUSTMPTBLNAM,@CARDFLAG)");
            $cardoutparm_query = 'SELECT @CARDSTATUSTMPTBLNAM AS CARD_TEMP_TABLE';
            $cardoutparm_result = $this->db->query($cardoutparm_query);
            $card_tablename=$cardoutparm_result->row()->CARD_TEMP_TABLE;
            $cardtable_result = $this->db->get($card_tablename);
            $table_header='';
            $table_header='<br><table width="1000px" id="CV_tbl_cardnohtmltable" border="1" style="border-collapse: collapse;" cellspacing="0"><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead><tr><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">UNIT NO</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">ACTIVE CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">NON ACTIVE CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">OLD CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">ACCESS REASON</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:300px;">COMMENTS</th></tr></thead><tbody>';
            foreach ($cardtable_result->result_array() as $row)
            {
                $CV_access_unitno=$row["UNITNO"];
                $CV_access_active=$row["ACTIVE_ACCESS_CARD"];
                if($CV_access_active==null){ $CV_access_active="";}
                $CV_access_inventory=$row["INVENTORY_ACCESS_CARD"];
                if($CV_access_inventory==null){ $CV_access_inventory="";}
                $CV_access_lost=$row["LOST_ACCESS_CARD"];
                if($CV_access_lost==null){ $CV_access_lost="";}
                $CV_access_reason=$row["ACCESS_REASON"];
                if($CV_access_reason==null){$CV_access_reason="";}
                $CV_access_comment=$row["ACCESS_COMMENTS"];
                if($CV_access_comment==null){$CV_access_comment="";}
                $table_header.='<tr><td style="text-align:center;">'.$CV_access_unitno.'</td><td>'.$CV_access_active.'</td><td style="text-align:center;">'.$CV_access_inventory.'</td><td>'.$CV_access_lost.'</td><td style="text-align:center;">'.$CV_access_reason.'</td><td>'.$CV_access_comment.'</td></tr>';
            }
            $table_header.='</tbody></table>';
            $drop_query = "DROP TABLE ".$card_tablename;
            $this->db->query($drop_query);
            return $table_header;
        }
        elseif($option==31){
            $unit_tablename='';
            $this->db->query("CALL SP_ACCESS_CARD_SEARCH_BY_UNIT(".$unitno.",'".$USERSTAMP."',@BYUNITTMPTBLNAM,@ACCESSSEARCHSUCCESSMSG)");
            $unitoutparm_query = 'SELECT @BYUNITTMPTBLNAM AS UNIT_TEMP_TABLE';
            $unitoutparm_result = $this->db->query($unitoutparm_query);
            $unit_tablename=$unitoutparm_result->row()->UNIT_TEMP_TABLE;
            $unittable_result = $this->db->get($unit_tablename);
            $CV_lostcard_array=[];
            $CV_lostcard1_array=[];
            $CV_activecard_array=[];
            $CV_inventorycard_array=[];
            $CV_reason_array=[];
            $table_header='';
            $table_header='<br><table width="1000px" id="CV_tbl_unitnohtmltable" border="1" style="border-collapse: collapse;" cellspacing="0"><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead><tr><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">ACTIVE CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">NON ACTIVE CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">OLD CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">ACCESS REASON</th></tr></thead><tbody>';
            foreach ($unittable_result->result_array() as $row)
            {
                $CV_access_active=$row["ACTIVE_CARD"];
                if($CV_access_active!=null){ $CV_activecard_array[]=($CV_access_active);}
                $CV_access_inventory=$row["INVENTORY_CARD"];
                if($CV_access_inventory!=null){$CV_inventorycard_array[]=($CV_access_inventory);}
                $CV_access_customer_lost=$row["CUSTOMER_OLD_CARD"];
                if($CV_access_customer_lost!=null){ $CV_lostcard_array[]=($CV_access_customer_lost);}
                $CV_access_employee_lost=$row["EMPLOYEE_LOST_CARD"];
                if($CV_access_employee_lost!=null){ $CV_lostcard1_array[]=($CV_access_employee_lost);}
                $CV_access_reason=$row["REASON"];
                if($CV_access_reason!=null){$CV_reason_array[]=($CV_access_reason);}
            }
            $CV_merged_lostcard_array=array();
            if(count($CV_lostcard1_array)!=0){
                $CV_merged_lostcard_array=array_merge($CV_lostcard_array,$CV_lostcard1_array);
            }
            else{
                $CV_merged_lostcard_array=$CV_lostcard_array;
            }
            if(count($CV_activecard_array)!=0 || count($CV_inventorycard_array)!=0 || count($CV_merged_lostcard_array)!=0 || count($CV_reason_array)!=0){
                $cv_active_len=count($CV_activecard_array);
                $cv_inventory_len=count($CV_inventorycard_array);
                $cv_lost_len=count($CV_merged_lostcard_array);
                $len=max($cv_active_len,$cv_inventory_len,$cv_lost_len);
                for($i=0;$i<$len;$i++){
                    $activeindex=array_key_exists($i,$CV_activecard_array);
                    if($activeindex!=1){
                        $active_card='';
                    }
                    else{
                        $active_card=$CV_activecard_array[$i];
                    }
                    $nonactiveindex=array_key_exists($i,$CV_inventorycard_array);
                    if($nonactiveindex!=1){
                        $inventory_card='';
                    }
                    else{
                        $inventory_card=$CV_inventorycard_array[$i];
                    }
                    $lostindex=array_key_exists($i,$CV_merged_lostcard_array);
                    if($lostindex!=1){
                        $lost_card='';
                    }
                    else{
                        $lost_card=$CV_merged_lostcard_array[$i];
                    }
                    $reasonindex=array_key_exists($i,$CV_reason_array);
                    if($reasonindex!=1){
                        $reason='';
                    }
                    else{
                        $reason=$CV_reason_array[$i];
                    }
                    $table_header.='<tr><td>'.$active_card.'</td><td style="text-align:center;">'.$inventory_card.'</td><td>'.$lost_card.'</td><td style="text-align:center;">'.$reason.'</td></tr>';
                }
                $table_header.='</tbody></table>';
            }
            $drop_query = "DROP TABLE ".$unit_tablename;
            $this->db->query($drop_query);
            return $table_header;
        }
        elseif($option==40){
            $allunit_tablename='';
            $this->db->query("CALL SP_ACCESS_CARD_SEARCH_BY_ALL_UNIT('".$USERSTAMP."',@BYALLUNITTMPTBLNAM,@FLAG)");
            $allunitoutparm_query = 'SELECT @BYALLUNITTMPTBLNAM AS ALLUNIT_TEMP_TABLE';
            $allunitoutparm_result = $this->db->query($allunitoutparm_query);
            $allunit_tablename=$allunitoutparm_result->row()->ALLUNIT_TEMP_TABLE;
            $allunittable_result = $this->db->query('SELECT * FROM '.$allunit_tablename.' ORDER BY UNITNO');
            $table_header='';
            $table_header='<br><table width="1000px" id="CV_tbl_allunithtmltable" border="1" style="border-collapse: collapse;" cellspacing="0"><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead><tr><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">UNIT NO</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">ACTIVE CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">NON ACTIVE CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">CUSTOMER LOST CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">LOST CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">ACCESS REASON</th></tr></thead><tbody>';
            foreach ($allunittable_result->result_array() as $row){
                $CV_access_unitno=$row["UNITNO"];
                $CV_access_active=$row["ACTIVE_CARD"];
                if($CV_access_active==null){$CV_access_active='';}
                $CV_access_inventory=$row["INVENTORY_CARD"];
                if($CV_access_inventory==null){ $CV_access_inventory='';}
                $CV_access_customer_lost=$row["CUSTOMER_LOST_CARD"];
                if($CV_access_customer_lost==null){ $CV_access_customer_lost='';}
                $CV_access_employee_lost=$row["EMPLOYEE_LOST_CARD"];
                if($CV_access_employee_lost==null){ $CV_access_employee_lost='';}
                $CV_access_reason=$row["REASON"];
                if($CV_access_reason==null){$CV_access_reason='';}
                $table_header.='<tr><td style="text-align:center;">'.$CV_access_unitno.'</td><td>'.$CV_access_active.'</td><td style="text-align:center;">'.$CV_access_inventory.'</td><td>'.$CV_access_customer_lost.'</td><td style="text-align:center;">'.$CV_access_employee_lost.'</td><td style="text-align:center;">'.$CV_access_reason.'</td></tr>';
            }
            $table_header.='</tbody></table>';
            $drop_query = "DROP TABLE ".$allunit_tablename;
            $this->db->query($drop_query);
            return $table_header;
        }
        elseif($option==21){
            $cust_tablename='';
            $this->db->query("CALL SP_ACCESS_CARD_SEARCH_BY_CUSTOMER('".$custid."','".$USERSTAMP."',@BYCUSTOMERTMPTBLNAM,@FLAG_MESSAGE)");
            $custoutparm_query = 'SELECT @BYCUSTOMERTMPTBLNAM AS CUST_TEMP_TABLE,@FLAG_MESSAGE AS CUSTFLAG';
            $custoutparm_result = $this->db->query($custoutparm_query);
            $cust_tablename=$custoutparm_result->row()->CUST_TEMP_TABLE;
            $this->db->select();
            $this->db->from($cust_tablename);
            $this->db->order_by('UNITNO');
            $custtable_result = $this->db->get();
            $table_header='';
            $table_header='<br><table width="1000px" id="CV_tbl_custhtmltable" border="1" style="border-collapse: collapse;" cellspacing="0"><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead><tr><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">UNIT NO</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">ACTIVE CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">OLD CARDS</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">ACCESS REASON</th><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:300px;">ACCESS COMMENTS</th></tr></thead><tbody>';
            foreach ($custtable_result->result_array() as $row){
                $CV_access_unitno=$row["UNITNO"];
                $CV_access_active=$row["ACTIVE_CARD"];
                if($CV_access_active==null){ $CV_access_active="";}
                $CV_access_lost=$row["OLD_CARD"];
                if($CV_access_lost==null){ $CV_access_lost="";}
                $CV_access_reason=$row["REASON"];
                if($CV_access_reason==null){$CV_access_reason="";}
                $CV_access_comment=$row["COMMENTS"];
                if($CV_access_comment==null){$CV_access_comment="";}
                $table_header.='<tr><td style="text-align:center;">'.$CV_access_unitno.'</td><td>'.$CV_access_active.'</td><td style="text-align:center;">'.$CV_access_lost.'</td><td style="text-align:center;">'.$CV_access_reason.'</td><td>'.$CV_access_comment.'</td></tr>';
            }
            $table_header.='</tbody></table>';
            $drop_query = "DROP TABLE ".$cust_tablename;
            $this->db->query($drop_query);
            return $table_header;
        }
    }
}