<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-021
 * Date: 11/5/15
 * Time: 10:57 AM
 */
//******************************************PRORATED CALCULATION********************************************//
//DONE BY:SARADAMBAL
//VER 5.5-SD:03/06/2015 ED:03/06/2015,CHANGED FILE NAME
//VER 0.01-SD:14/05/2015 ED:14/02/2015,COMPLETED PRORATED CALCULATION
//*******************************************************************************************************//
class Mdl_eilib_prorated_calc extends CI_Model {
//FUNCTION TO GET PRORATED AMOUNT USING CHECK IN DATE
    public function sMonthProratedCalc($check_in_date,$rentPerMonth)
    {
        $rentPerMonth=floatval($rentPerMonth);
        $Checkindate = intval(date("d",strtotime($check_in_date)));
        $LastMonth =date("Y-m-t", strtotime($check_in_date));
        if($Checkindate >1)
        {
            $Tdays = intval(date("d",strtotime($LastMonth)));
            $Proratedfull1 = ((($Tdays - $Checkindate) +1) * 12/365 * $rentPerMonth);
            $proratedfixed1 = number_format(floatval($Proratedfull1),2,'.','');
            $Proratedfull2= ((($Tdays - $Checkindate) +1)/$Tdays) * $rentPerMonth;
            $proratedfixed2 = number_format(floatval($Proratedfull2),2,'.','');
            if(floatval($proratedfixed1) > floatval($proratedfixed2))
            {
                return $proratedfixed1; // prorated rent calculation
            }
            else
            {
                return $proratedfixed2;
            }
        }
        else
        {
            return 0;
        }
    }
//FUNCTION TO GET PRORATED AMOUNT USING CHECK OUT DATE
    public   function eMonthProratedCalc($check_out_date,$rentPerMonth)
    {
        $rentPerMonth=floatval($rentPerMonth);
        $CheckOutdate = intval(date("d", strtotime($check_out_date)));
        $LastMonth =date("Y-m-t", strtotime($check_out_date));
        if($CheckOutdate >1)
        {
            $Tdays = intval(date("d",strtotime($LastMonth)));
            $Proratedfull1 = (($CheckOutdate -1) * 12/365 * $rentPerMonth);
            $proratedfixed1 = number_format(floatval($Proratedfull1),2,'.','');
            $Proratedfull2= (($CheckOutdate -1)/$Tdays) * $rentPerMonth;
            $proratedfixed2 = number_format(floatval($Proratedfull2),2,'.','');
            if(floatval($proratedfixed1) > floatval($proratedfixed2))
            {
                return $proratedfixed1; // prorated rent calculation
            }
            else
            {
                return $proratedfixed2;
            }
        }
        else
        {
            return 0;
        }
    }
//FUNCTION TO GET PRORATED AMOUNT USING CHECK OUT AND CHECK IN DATE
    function wMonthProratedCalc($check_in_date,$check_out_date,$rentPerMonth)
    {
        $rentPerMonth=floatval($rentPerMonth);
        $CheckIndate = intval(date("d", strtotime($check_in_date)));
        $CheckOutdate = intval(date("d", strtotime($check_out_date)));
        $LastMonth =date("Y-m-t", strtotime($check_out_date));
        $Tdays = intval(date("d",strtotime($LastMonth)));
        $Proratedfull1 = (($CheckOutdate - $CheckIndate) * 12/365 * $rentPerMonth);
        $proratedfixed1 = number_format(floatval($Proratedfull1),2,'.','');
        $Proratedfull2= (($CheckOutdate -$CheckIndate)/$Tdays) * $rentPerMonth;
        $proratedfixed2 = number_format(floatval($Proratedfull2),2,'.','');
        if(floatval($proratedfixed1) > floatval($proratedfixed2))
        {
            return $proratedfixed1; // prorated rent calculation
        }
        else
        {
            return $proratedfixed2;
        }
    }
}