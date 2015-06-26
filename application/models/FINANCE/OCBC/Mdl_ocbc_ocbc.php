<?php
class Mdl_ocbc_ocbc extends CI_Model
{
    Public function getOCBCData($Period)
    {
        $SplittedPeriod=explode('-',$Period);
        $string = $SplittedPeriod[0];
        $month_number = date("n",strtotime($string));
        if($month_number<10)
        { $month_number='0'.$month_number; }
        $Forperiod=$SplittedPeriod[1].'-'.$month_number.'%';
        $SelectQuery="SELECT OBR.OBR_ID,OCA.OCN_DATA AS CURRENCY,OCB.OCN_DATA AS ACCOUNT,OBR.OBR_OPENING_BALANCE,OBR.OBR_CLOSING_BALANCE,OBR.OBR_PREVIOUS_BALANCE,OBR.OBR_LAST_BALANCE,OBR.OBR_OLD_BALANCE,OBR.OBR_NO_OF_CREDITS,OBR.OBR_NO_OF_DEBITS,DATE_FORMAT(OBR.OBR_POST_DATE,'%d-%m-%Y')AS OBR_POST_DATE,DATE_FORMAT(OBR.OBR_TRANS_DATE,'%d-%m-%Y')AS OBR_TRANS_DATE,DATE_FORMAT(OBR.OBR_VALUE_DATE,'%d-%m-%Y')AS OBR_VALUE_DATE,OBR.OBR_D_AMOUNT,OBR.OBR_DEBIT_AMOUNT,OBR.OBR_CREDIT_AMOUNT,OCN.OCN_DATA,OBR.OBR_CLIENT_REFERENCE,OBR.OBR_TRANSACTION_DESC_DETAILS,OBR.OBR_BANK_REFERENCE,OBR.OBR_TRX_TYPE,OBR.OBR_REFERENCE FROM OCBC_CONFIGURATION OCN,OCBC_BANK_RECORDS OBR LEFT JOIN OCBC_CONFIGURATION OCA ON OBR.OBR_CURRENCY=OCA.OCN_ID LEFT JOIN OCBC_CONFIGURATION OCB ON OBR.OBR_ACCOUNT_NUMBER=OCB.OCN_ID  WHERE OBR.OCN_ID=OCN.OCN_ID AND((OBR.OBR_POST_DATE LIKE '$Forperiod' AND OBR.OBR_TRANS_DATE LIKE '$Forperiod') OR (OBR.OBR_POST_DATE LIKE '$Forperiod' AND OBR.OBR_VALUE_DATE LIKE '$Forperiod')OR(OBR.OBR_TRANS_DATE LIKE '$Forperiod' AND OBR.OBR_VALUE_DATE LIKE '$Forperiod')) ORDER BY OBR.OBR_VALUE_DATE,OBR_REF_ID";
        $resultset=$this->db->query($SelectQuery);
        return $resultset->result();
    }
    public function RecordSave($unit,$customerid,$recver,$payment,$amount,$period,$comments,$flag,$id,$UserStamp)
    {
      $CallQuery="CALL SP_OCBC_PAYMENT_DETAIL_INSERT('$unit','$customerid','$recver','$payment','$amount','$flag','$period','$comments','$UserStamp','$id',@FINAL_MESSAGE)";
      $this->db->query($CallQuery);
      $outparm_query = 'SELECT @FINAL_MESSAGE AS TEMP_TABLE';
      $outparm_result = $this->db->query($outparm_query);
      $Confirm_Meessage=$outparm_result->row()->TEMP_TABLE;
      return $Confirm_Meessage;
    }
    public function CSV_FileRecordsCount($Period)
    {
        $SplittedPeriod=explode('-',$Period);
        $string = $SplittedPeriod[0];
        $result = substr($string, 0, 3);
        $CSVMonthname=$result.'-'.$SplittedPeriod[1];
        $outparm_query = "SELECT CSV_COUNT FROM CSV_CONFIGURATION WHERE CSV_MONTH='$CSVMonthname'";
        $outparm_result = $this->db->query($outparm_query);
        $sortnumrows=$this->db->affected_rows();
        if($sortnumrows!=0) {
            $CSVMONTHcount = $outparm_result->row()->CSV_COUNT;
            return $CSVMONTHcount;
        }
        else{
            return 0;
        }
    }
    function downloadFile($service, $downloadUrl)
    {
        if ($downloadUrl) {
            $request = new Google_Http_Request($downloadUrl, 'GET', null, null);
            $httpRequest = $service->getClient()->getAuth()->authenticatedRequest($request);
            if ($httpRequest->getResponseHttpCode() == 200) {
                return $httpRequest->getResponseBody();
            } else {
                echo "errr";
                return null;
            }
        } else {
            echo "empty";
            return null;
        }
    }
    public function OCBC_PDF_Creation($Period)
    {
        $SplittedPeriod=explode('-',$Period);
        $string = $SplittedPeriod[0];
        $month_number = date("n",strtotime($string));
        if($month_number<10)
        { $month_number='0'.$month_number; }
        $Forperiod=$SplittedPeriod[1].'-'.$month_number.'%';
        $SelectQuery="SELECT OBR.OBR_ID,OCA.OCN_DATA AS CURRENCY,OCB.OCN_DATA AS ACCOUNT,OBR.OBR_OPENING_BALANCE,OBR.OBR_CLOSING_BALANCE,OBR.OBR_PREVIOUS_BALANCE,OBR.OBR_LAST_BALANCE,OBR.OBR_OLD_BALANCE,OBR.OBR_NO_OF_CREDITS,OBR.OBR_NO_OF_DEBITS,DATE_FORMAT(OBR.OBR_POST_DATE,'%d-%m-%Y')AS OBR_POST_DATE,DATE_FORMAT(OBR.OBR_TRANS_DATE,'%d-%m-%Y')AS OBR_TRANS_DATE,DATE_FORMAT(OBR.OBR_VALUE_DATE,'%d-%m-%Y')AS OBR_VALUE_DATE,OBR.OBR_D_AMOUNT,OBR.OBR_DEBIT_AMOUNT,OBR.OBR_CREDIT_AMOUNT,OCN.OCN_DATA,OBR.OBR_CLIENT_REFERENCE,OBR.OBR_TRANSACTION_DESC_DETAILS,OBR.OBR_BANK_REFERENCE,OBR.OBR_TRX_TYPE,OBR.OBR_REFERENCE FROM OCBC_CONFIGURATION OCN,OCBC_BANK_RECORDS OBR LEFT JOIN OCBC_CONFIGURATION OCA ON OBR.OBR_CURRENCY=OCA.OCN_ID LEFT JOIN OCBC_CONFIGURATION OCB ON OBR.OBR_ACCOUNT_NUMBER=OCB.OCN_ID  WHERE OBR.OCN_ID=OCN.OCN_ID AND((OBR.OBR_POST_DATE LIKE '$Forperiod' AND OBR.OBR_TRANS_DATE LIKE '$Forperiod') OR (OBR.OBR_POST_DATE LIKE '$Forperiod' AND OBR.OBR_VALUE_DATE LIKE '$Forperiod')OR(OBR.OBR_TRANS_DATE LIKE '$Forperiod' AND OBR.OBR_VALUE_DATE LIKE '$Forperiod')) ORDER BY OBR.OBR_VALUE_DATE,OBR_REF_ID";
        $resultset=$this->db->query($SelectQuery);
        $Payment_data='<br>
        <table width="3000px" id="USU_tble_htmltable" border="1" style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult">
        <sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/>
        <thead bgcolor="#6495ed" style="color:white">
        <tr>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">ACCOUNT NUMBER</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">CURRENCY</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">PREVIOUS BALANCE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">OPENING BALANCE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">CLOSING BALANCE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">LAST BALANCE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">NO OF CREDITS</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">TRANS DATE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">NO OF DEBITS</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">OLD BALANCE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">D.AMOUNT</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">POST DATE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">VALUE DATE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">DEBIT AMOUNT</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">CREDIT AMOUNT</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">TRX CODE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:200px">CLIENT REFERENCE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:200px">TRANSACTION DESC DETAILS</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:200px">BANK REFERENCE</th>
           <th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;width:100px">TRX TYPE</th>
        </tr>
        </thead>
        <tbody>';
        foreach ($resultset->result_array() as $key => $value)
        {
            $Payment_data .= '<tr>';
            $Payment_data .= '<td style="text-align:center;">' . $value['ACCOUNT'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['CURRENCY'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_PREVIOUS_BALANCE'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_OPENING_BALANCE'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_CLOSING_BALANCE'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_LAST_BALANCE'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_NO_OF_CREDITS'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_TRANS_DATE'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_NO_OF_DEBITS'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_OLD_BALANCE'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_D_AMOUNT'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_POST_DATE'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_VALUE_DATE'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_DEBIT_AMOUNT'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_CREDIT_AMOUNT'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OCN_DATA'] . '</td>';
            $Payment_data .= '<td>' . $value['OBR_CLIENT_REFERENCE'] . '</td>';
            $Payment_data .= '<td>' . $value['OBR_TRANSACTION_DESC_DETAILS'] . '</td>';
            $Payment_data .= '<td>' . $value['OBR_BANK_REFERENCE'] . '</td>';
            $Payment_data .= '<td style="text-align:center;">' . $value['OBR_TRX_TYPE'] . '</td>';
            $Payment_data .= '</tr>';
        }
        $Payment_data.='</body></table>';
        return $Payment_data;
    }
}