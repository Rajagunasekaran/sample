<?php
//******************************************charts********************************************//
//VER 0.02-SD:27/04/2015 ED:28/04/2015,did db part BY RAJA
//VER 0.01-SD:24/04/2015 ED:25/04/2015,completed form design and validation BY RAJA
//*******************************************************************************************************//
class Mdl_report_charts extends CI_Model {
    public function Initial_data($ErrorMessage){
        $this->db->select('CGN_ID,CGN_TYPE');
        $this->db->from('CONFIGURATION');
        $this->db->where('CGN_ID IN (62,63,64,65)');
        $this->db->order_by('CGN_TYPE');
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('UNIT_NO');
        $this->db->from('VW_ACTIVE_UNIT');
        $this->db->where('UD_NON_EI IS NULL');
        $this->db->order_by('UNIT_NO','ASC');
        $query = $this->db->get();
        $result2 = $query->result();
        return $result[]=array($result1,$result2,$ErrorMessage);
    }
    public function Subchart_data($nameval){
        $chartopt_key=array(62=>"9,10,11,12,13",63=>"14,15,16,17,18",64=>"19,20,21,22",65=>"23,24,25,26,27");
        $this->db->select('RCN_ID,RCN_DATA');
        $this->db->from('REPORT_CONFIGURATION');
        $this->db->where('RCN_ID IN ('.$chartopt_key[$nameval].')');
        $this->db->order_by('RCN_DATA');
        $query = $this->db->get();
        $subchartres = $query->result();
        return $subchartres;
    }
    public function Expense_input_data($unitno,$fromdate,$todate,$srch_data,$flag,$USERSTAMP){
        $UserStamp=$USERSTAMP;
        $chart_flex_twodimens_arr=[];
        if($flag=='chart_flag_daterange_allunit'){
            $chart_dateamt_unitno=array(
                9=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_BIZ_EXPENSE_ALLUNIT','UNITNO^CARPARK^DIGITAL VOICE^ELECTRICITY^FACILITY USE^MOVING IN AND OUT^STARHUB^UNIT EXPENSE',"SP_CHARTS_BIZ_EXPENSE_ALLUNIT('".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                10=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_BIZ_EXPENSE_ALLUNIT','UNITNO^CARPARK^DIGITAL VOICE^ELECTRICITY^FACILITY USE^MOVE IN OUT^STARHUB^UNIT EXPENSE',"SP_CHARTS_BIZ_EXPENSE_ALLUNIT('".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                11=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_EXPENSE_ALLUNIT','UNITNO^ELECTRICITY',"SP_CHARTS_SINGLE_EXPENSE_ALL_UNIT('".$fromdate."','".$todate."','EXPENSE_DETAIL_ELECTRICITY','EXPENSE_ELECTRICITY','EE.EE_AMOUNT','EE.EE_INVOICE_DATE','EDE_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                12=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_EXPENSE_ALLUNIT','UNITNO^STARHUB',"SP_CHARTS_SINGLE_EXPENSE_ALL_UNIT('".$fromdate."','".$todate."','EXPENSE_DETAIL_STARHUB','EXPENSE_STARHUB','EE.ESH_AMOUNT','EE.ESH_INVOICE_DATE','EDSH_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                13=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_EXPENSE_ALLUNIT','UNITNO^UNIT EXPENSE',"SP_CHARTS_SINGLE_EXPENSE_ALL_UNIT('".$fromdate."','".$todate."','','EXPENSE_UNIT','EXP.EU_AMOUNT','EXP.EU_INVOICE_DATE','EU_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                19=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_PERSONAL_EXPENSE','MONTH^BABY EXPENSE',"SP_CHARTS_SINGLE_PERSONAL_EXPENSE('".$fromdate."','".$todate."','EXPENSE_BABY','EB_AMOUNT','EB_INVOICE_DATE','EB_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                20=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_PERSONAL_EXPENSE','MONTH^CAR EXPENSE',"SP_CHARTS_SINGLE_PERSONAL_EXPENSE('".$fromdate."','".$todate."','EXPENSE_CAR','EC_AMOUNT','EC_INVOICE_DATE','EC_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                23=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_PERSONAL_EXPENSE','MONTH^AGENT',"SP_CHARTS_SINGLE_PERSONAL_EXPENSE('".$fromdate."','".$todate."','EXPENSE_AGENT','EA_COMM_AMOUNT','EA_DATE','EA_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                24=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_PERSONAL_EXPENSE','MONTH^SALARY',"SP_CHARTS_SINGLE_PERSONAL_EXPENSE('".$fromdate."','".$todate."','EXPENSE_STAFF_SALARY','ESS_SALARY_AMOUNT','ESS_INVOICE_DATE','ESS_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                25=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_PERSONAL_EXPENSE','MONTH^STAFF',"SP_CHARTS_SINGLE_PERSONAL_EXPENSE('".$fromdate."','".$todate."','EXPENSE_STAFF','ES_INVOICE_AMOUNT','ES_INVOICE_DATE','ES_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                26=>['MONTH-YEAR,AGENT COMMISSION,SALARY ENTRY,STAFF EXPENSE','TEMP_CHARTS_STAFF_EXPENSE','MONTH^AGENT COMMISSION^SALARY ENTRY^STAFF EXPENSE',"SP_CHARTS_STAFF_EXPENSE('".$fromdate."' ,'".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                27=>['MONTH-YEAR,AGENT COMMISSION,SALARY ENTRY,STAFF EXPENSE','TEMP_CHARTS_STAFF_EXPENSE','MONTH^AGENT COMMISSION^SALARY ENTRY^STAFF EXPENSE',"SP_CHARTS_STAFF_EXPENSE('".$fromdate."' ,'".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                15=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_GROSS_REVEUE_ALLUNIT','UNITNO^GROSS REVENUE',"SP_CHARTS_GROSS_REVENUE_ALLUNIT('".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                14=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_BIZ_NET_REVENUE_ALLUNIT','UNITNO^GROSS REVENUE^TOTAL RENTAL BIZ^NET REVENUE^UNIT RENTAL^TOTAL BIZ',"SP_CHARTS_BIZ_NET_REVENUE_ALLUNIT('".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                17=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_PERSONAL_NET_REVENUE','MONTH^GROSS REVENUE^RENTAL AND EXPENSE^NET REVENUE^UNIT RENTAL^BIZ^STAFF^PERSONAL',"SP_CHARTS_PERSONAL_NET_REVENUE('".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                16=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_GROSS_REVENUE_AND_NET_REVENUE','MONTH^GROSS REVENUE^RENTAL AND EXPENSE^NET REVENUE^UNIT RENTAL^BIZ^STAFF^PERSONAL',"SP_CHARTS_GROSS_REVENUE_AND_NET_REVENUE('".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                21=>['MONTH-YEAR,BABY_EXPENSES,CAR_EXPENSES,CAR_LOAN,PERSONAL_EXPENSES','TEMP_CHARTS_PERSONAL_EXPENSE','MONTH^BABY^CAR^CAR LOAN^PERSONAL EXPENSE',"SP_CHARTS_PERSONAL_EXPENSE('".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                22=>['MONTH-YEAR,BABY_EXPENSES,CAR_EXPENSES,CAR_LOAN,PERSONAL_EXPENSES','TEMP_CHARTS_PERSONAL_EXPENSE','MONTH^BABY^CAR^CAR LOAN^PERSONAL EXPENSE',"SP_CHARTS_PERSONAL_EXPENSE('".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                18=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_UNIT_GROSS_NET_REVENUE_ALLUNIT','UNIT NUMBER^GROSS REVENUE^TOTAL RENTAL BIZ^NET REVENUE^UNIT RENTAL^TOTAL BIZ',"SP_CHARTS_UNIT_GROSS_NET_REVENUE_ALLUNIT('".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"]
            );
        }
        else{
            $chart_dateamt_unitno=array(
                11=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_EXPENSE_PERUNIT','MONTH^ELECTRICITY',"SP_CHARTS_SINGLE_EXPENSE_PERUNIT(".$unitno.",'".$fromdate."','".$todate."','EXPENSE_DETAIL_ELECTRICITY','EXPENSE_ELECTRICITY','EE.EE_AMOUNT','EE.EE_INVOICE_DATE','EDE_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                12=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_EXPENSE_PERUNIT','MONTH^STARHUB',"SP_CHARTS_SINGLE_EXPENSE_PERUNIT(".$unitno.",'".$fromdate."','".$todate."','EXPENSE_DETAIL_STARHUB','EXPENSE_STARHUB','EE.ESH_AMOUNT','EE.ESH_INVOICE_DATE','EDSH_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                13=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_SINGLE_EXPENSE_PERUNIT','MONTH^UNIT EXPENSE',"SP_CHARTS_SINGLE_EXPENSE_PERUNIT(".$unitno.",'".$fromdate."','".$todate."','EXPENSE_DETAIL_ELECTRICITY','EXPENSE_UNIT','EXP.EU_AMOUNT','EXP.EU_INVOICE_DATE','EU_ID','".$UserStamp."',@TEMP_TABLE_CHART)"],
                26=>['MONTH-YEAR,AGENT COMMISSION,SALARY ENTRY,STAFF EXPENSE','TEMP_CHARTS_STAFF_EXPENSE','AGENT COMMISSION^SALARY ENTRY^STAFF EXPENSE',"SP_CHARTS_STAFF_EXPENSE(".$fromdate.",".$todate.",'".$UserStamp."',@TEMP_TABLE_CHART)"],
                9=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_BIZ_EXPENSE_PERUNIT','MONTH^CARPARK^DIGITAL VOICE^ELECTRICITY^FACILITY USE^MOVING IN AND OUT^STARHUB^UNIT EXPENSE',"SP_CHARTS_BIZ_EXPENSE_PERUNIT(".$unitno.",'".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                15=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_GROSS_REVEUE_PERUNIT','MONTH^GROSS REVENUE',"SP_CHARTS_GROSS_REVENUE_PERUNIT(".$unitno.",'".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                14=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_BIZ_NET_REVENUE_PERUNIT','MONTH^GROSS REVENUE^TOTAL RENTAL BIZ^NET REVENUE^UNIT RENTAL^TOTAL BIZ',"SP_CHARTS_BIZ_NET_REVENUE_PERUNIT(".$unitno.",'".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"],
                18=>['UNIT_NO,INVOICE_DATE,AMOUNT','TEMP_CHARTS_UNIT_GROSS_NET_REVENUE_PERUNIT','MONTH^GROSS REVENUE^TOTAL RENTAL BIZ^NET REVENUE^UNIT RENTAL^TOTAL BIZ',"SP_CHARTS_UNIT_GROSS_AND_NET_REVENUE_PERUNIT(".$unitno.",'".$fromdate."','".$todate."','".$UserStamp."',@TEMP_TABLE_CHART)"]
            );
        }
        $callquery="CALL ".$chart_dateamt_unitno[$srch_data][3]."";
        $this->db->query($callquery);
        $outparm_query = 'SELECT @TEMP_TABLE_CHART AS TEMP_TABLE';
        $outparm_result = $this->db->query($outparm_query);
        $chart_tablename=$outparm_result->row()->TEMP_TABLE;
        $table_result = $this->db->get($chart_tablename);
        // for table fields
        $resultheader=$this->db->list_fields($chart_tablename);
        foreach($resultheader as $fields)
        {
            $headerarrdata[] = $fields;
        }
        // for dt header
        $chart_tbleheader=explode('^',$chart_dateamt_unitno[$srch_data][2]);
        $chart_flex_twodimens_arr=array($chart_tbleheader);
        // for temp table result array
        foreach ($table_result->result_array() as $row)
        {
            $chart_flex_arr=[];
            $chart_totalcolumns=count($chart_tbleheader);
            for($x=0; $x<$chart_totalcolumns; $x++)
            {
                if($x==0){
                    $chart_flex_arr[]=$row[$headerarrdata[$x]];
                }
                else{
                    $chart_flex_arr[]=floatval($row[$headerarrdata[$x]]);
                }
            }
            $chart_flex_twodimens_arr[]=$chart_flex_arr;
        }
        $drop_query = "DROP TABLE ".$chart_tablename;
        $this->db->query($drop_query);
        return $chart_flex_twodimens_arr;
    }
}
