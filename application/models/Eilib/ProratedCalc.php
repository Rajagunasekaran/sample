<?php
/**
* Created by PhpStorm.
* User: SSOMENS-021
* Date: 11/5/15
* Time: 10:57 AM
*/
//******************************************PRORATED CALCULATION********************************************//
//DONE BY:SARADAMBAL
//VER 0.01-SD:14/05/2015 ED:14/02/2015,COMPLETED PRORATED CALCULATION
//*******************************************************************************************************//
class ProratedCalc extends CI_Model {
//FUNCTION TO GET PRORATED AMOUNT USING CHECK IN DATE
public function sMonthProratedCalc($check_in_date,$rentPerMonth)
{
$rentPerMonth=floatval($rentPerMonth);
$check_in_date=strtotime($check_in_date);
$Checkindate = intval(date("d", $check_in_date));
$timestamp = strtotime ("+1 month",$check_in_date);
$nextMonth  =  date("Y-m-d",$timestamp);
$LastMonth =date("Y-m-t", strtotime($nextMonth));
if($Checkindate >1)
{
$Tdays = intval(date("d",strtotime($LastMonth)));
$Proratedfull1 = ((($Tdays - $Checkindate) +1) * 12/365 * $rentPerMonth);
$proratedfixed1 =  sprintf('%0.2f', $Proratedfull1);
$Proratedfull2= ((($Tdays - $Checkindate) +1)/$Tdays) * $rentPerMonth;
$proratedfixed2 = sprintf('%0.2f', $Proratedfull2);
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
$check_out_date=strtotime($check_out_date);
$CheckOutdate = intval(date("d", $check_out_date));
$timestamp = strtotime ("+1 month",$check_out_date);
$nextMonthCheckout  =  date("Y-m-d",$timestamp);
$LastMonth =date("Y-m-t", strtotime($nextMonthCheckout));
if($CheckOutdate >1)
{
    $Tdays = intval(date("d",strtotime($LastMonth)));
    $Proratedfull1 = (($CheckOutdate -1) * 12/365 * $rentPerMonth);
    $proratedfixed1 =  sprintf('%0.2f', $Proratedfull1);
    $Proratedfull2= (($CheckOutdate -1)/$Tdays) * $rentPerMonth;
    $proratedfixed2 = sprintf('%0.2f', $Proratedfull2);
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
$check_out_date=strtotime($check_out_date);
$CheckIndate = intval(date("d", strtotime($check_in_date)));
$CheckOutdate = intval(date("d", strtotime($check_out_date)));
$timestamp = strtotime ("+1 month",$check_out_date);
$nextMonthCheckout  =  date("Y-m-d",$timestamp);
$LastMonth =date("Y-m-t", strtotime($nextMonthCheckout));
$Tdays = intval(date("d",strtotime($LastMonth)));
$Proratedfull1 = (($CheckOutdate -$CheckIndate) * 12/365 * $rentPerMonth);
$proratedfixed1 =  sprintf('%0.2f', $Proratedfull1);
$Proratedfull2= (($CheckOutdate -$CheckIndate)/$Tdays) * $rentPerMonth;
$proratedfixed2 = sprintf('%0.2f', $Proratedfull2);
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