<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-021
 * Date: 03-06-2015
 * Time: 16:35
 */
//******************************************INVOICE AND CONTRACT********************************************//
//DONE BY:SARADAMBAL
//VER 5.5-SD:03/06/2015 ED:03/06/2015,COMPLETED QUARTERCALCULATION
//*******************************************************************************************************//
class Mdl_eilib_quarter_calc extends CI_Model {
public function quarterCalc(DateTime $startdate,DateTime $enddate)
{
    $getbyquartcalcUserProperty = "";
    $getsquartcalcUserProperty = "";
    $getequartcalcUserProperty = "";
    if($startdate>$enddate){
        return('0');
    }
    else{
        $s_year=intval($startdate->format('Y'));
        $s_month=intval($startdate->format('m'));
        $s_date=intval($startdate->format('d'));

        $e_year=intval($enddate->format('Y'));
        $e_month=intval($enddate->format('m'));
        $e_date=intval($enddate->format('d'));

        $date = new DateTime();
        $date->setDate($s_year,$s_month,$s_date);
        $finaldate=$date->format('Y-m-d');
        $dateStart= date("Y-m-t",strtotime($finaldate));
        $s_lastdate_Day =intval(date("d", strtotime($dateStart)));

        $btw_year=$e_year-$s_year;

        $by_quarters=0;
        $s_quarters=0;
        $e_quarters=0;
        if($btw_year<=1){
            $by_quat = 0;
            $getbyquartcalcUserProperty=$by_quat;
        }
        else if($btw_year>1){
            $by_quat = ($btw_year-1)*4;
            $getbyquartcalcUserProperty=$by_quat;
        }

        if($btw_year==0){
            $btw_month=$e_month-$s_month;
            if($btw_month==0){
                if((($s_year%4)==0&&($s_year%100)!=0)||(($s_year%400)==0)){//leap year

                    if(1<=$s_month && $s_month<=3){
                        $m_days=$e_date-$s_date;
                        $s_year_quarter=$m_days/91;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }}
                else{
                    if(1<=$s_month && $s_month<=3){
                        $m_days=$e_date-$s_date;
                        $s_year_quarter=$m_days/90;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }}
                if(4<=$s_month && $s_month<=6){
                    $m_days=$e_date-$s_date;
                    $s_year_quarter=$m_days/91;
                    $e_year_quarter=0;
                    $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                }
                else if(7<=$s_month && $s_month<=9){
                    $m_days=$e_date-$s_date;
                    $s_year_quarter=$m_days/92;
                    $e_year_quarter=0;
                    $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                }
                else if(10<=$s_month && $s_month<=12){
                    $m_days=$e_date-$s_date;
                    $s_year_quarter=$m_days/92;
                    $e_year_quarter=0;
                    $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                }}
            else if($btw_month>0){
                if((($s_year%4)==0&&($s_year%100)!=0)||(($s_year%400)==0)){//leap year
                    if($s_month==1){
                        if($btw_month==1){//FEB
                            $s_lastdate= $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days+$e_date)/91;
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==2){//MAR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days+29+$e_date)/91;
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==3){//APR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+29+31)/91)+($e_date/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==4){//MAY
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+29+31)/91)+((30+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==5){//JUN
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+29+31)/91)+((30+31+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==6){//JUL
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+29+31)/91)+1+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==7){//AUG
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+29+31)/91)+1+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==8){//SEP
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+29+31)/91)+1+((31+31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==9){//OCT
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+29+31)/91)+2+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==10){//NOV
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+29+31)/91)+2+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==11){//DEC
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+29+31)/91)+2+((31+30+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                    }
                    else if($s_month==2){
                        if($btw_month==1){//MAR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days+$e_date)/91;
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==2){//APR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/91)+($e_date/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==3){//MAY
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/91)+((30+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==4){//JUN
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/91)+((30+31+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==5){//JUL
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/91)+1+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==6){//AUG
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/91)+1+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==7){//SEP
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/91)+1+((31+31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==8){//OCT
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/91)+2+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==9){//NOV
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/91)+2+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==10){//DEC
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/91)+2+((31+30+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }}
                    else if($s_month==3){
                        if($btw_month==1){//APR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/91)+($e_date/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==2){//MAY
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/91)+((30+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==3){//JUN
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/91)+((30+31+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==4){//JUL
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/91)+1+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==5){//AUG
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/91)+1+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==6){//SEP
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/91)+1+((31+31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==7){//OCT
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/91)+2+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==8){//NOV
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/91)+2+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==9){//DEC
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/91)+2+((31+30+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                    }
                }
                else{
                    if($s_month==1){
                        if($btw_month==1){//FEB
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days+$e_date)/90;
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==2){//MAR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days+28+$e_date)/90;
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==3){//APR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+28+31)/90)+($e_date/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==4){//MAY
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+28+31)/90)+((30+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==5){//JUN
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+28+31)/90)+((30+31+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==6){//JUL
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+28+31)/90)+1+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==7){//AUG
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+28+31)/90)+1+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==8){//SEP
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+28+31)/90)+1+((31+31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==9){//OCT
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+28+31)/90)+2+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==10){//NOV
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+28+31)/90)+2+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;}
                        else if($btw_month==11){//DEC
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+28+31)/90)+2+((31+30+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                    }
                    else if($s_month==2){
                        if($btw_month==1){//MAR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days+$e_date)/90;
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==2){//APR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/90)+($e_date/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==3){//MAY
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/90)+((30+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==4){//JUN
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/90)+((30+31+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==5){//JUL
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/90)+1+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==6){//AUG
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/90)+1+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==7){//SEP
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/90)+1+((31+31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==8){//OCT
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/90)+2+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==9){//NOV
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/90)+2+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==10){//DEC
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=(($m_days+31)/90)+2+((31+30+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                    }
                    else if($s_month==3){
                        if($btw_month==1){//APR
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/90)+($e_date/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==2){//MAY
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/90)+((30+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==3){//JUN
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/90)+((30+31+$e_date)/91);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==4){//JUL
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/90)+1+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==5){//AUG
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/90)+1+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==6){//SEP
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/90)+1+((31+31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==7){//OCT
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/90)+2+($e_date/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==8){//NOV
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/90)+2+((31+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                        else if($btw_month==9){//DEC
                            $s_lastdate = $s_lastdate_Day;
                            $m_days=$s_lastdate-$s_date+1;
                            $s_year_quarter=($m_days/90)+2+((31+30+$e_date)/92);
                            $e_year_quarter=0;
                            $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                        }
                    }
                }
                if($s_month==4){
                    if($btw_month==1){//MAY
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days+$e_date)/91;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==2){//JUN
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days+31+$e_date)/91;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==3){//JUL
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+31+30)/91)+($e_date/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==4){//AUG
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+31+30)/91)+((31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==5){//SEP
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+31+30)/91)+((31+31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==6){//OCT
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+31+30)/91)+1+($e_date/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==7){//NOV
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+31+30)/91)+1+((31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==8){//DEC
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+31+30)/91)+1+((31+30+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                }
                else if($s_month==5){
                    if($btw_month==1){//JUN
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days+$e_date)/91;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==2){//JUL
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+30)/91)+($e_date/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==3){//AUG
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+30)/91)+((31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==4){//SEP
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+30)/91)+((31+31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==5){//OCT
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+30)/91)+1+($e_date/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==6){//NOV
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+30)/91)+1+((31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==7){//DEC
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+30)/91)+1+((31+30+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                }
                else if($s_month==6){
                    if($btw_month==1){//JUL
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days/91)+($e_date/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==2){//AUG
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days/91)+((31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==3){//SEP
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days/91)+((31+31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==4){//OCT
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days/91)+1+($e_date/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==5){//NOV
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days/91)+1+((31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==6){//DEC
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days/91)+1+((31+30+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                }
                else if($s_month==7){
                    if($btw_month==1){//AUG
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days+$e_date)/92;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==2){//SEP
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days+31+$e_date)/92;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==3){//OCT
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+31+30)/92)+($e_date/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==4){//NOV
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+31+30)/92)+((31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==5){//DEC
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+31+30)/92)+((31+30+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                }
                else if($s_month==8){
                    if($btw_month==1){//SEP
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days+$e_date)/92;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==2){//OCT
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+30)/92)+($e_date/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==3){//NOV
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+30)/92)+((31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==4){//DEC
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=(($m_days+30)/92)+((31+30+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                }
                else if($s_month==9){
                    if($btw_month==1){//OCT
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days/92)+($e_date/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==2){//NOV
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days/92)+((31+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==3){//DEC
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days/92)+((31+30+$e_date)/92);
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                }
                else if($s_month==10){
                    if($btw_month==1){//NOV
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days+$e_date)/92;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                    else if($btw_month==2){//DEC
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days+30+$e_date)/92;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                }
                else if($s_month==11){
                    if($btw_month==1){//DEC
                        $s_lastdate = $s_lastdate_Day;
                        $m_days=$s_lastdate-$s_date+1;
                        $s_year_quarter=($m_days+$e_date)/92;
                        $e_year_quarter=0;
                        $getsquartcalcUserProperty=$s_year_quarter;$getequartcalcUserProperty=$e_year_quarter;
                    }
                }
            }
        }


        else if($btw_year>0) {
            //START DATE QUARTER CALCULATION
            if ((($s_year % 4) == 0 && ($s_year % 100) != 0) || (($s_year % 400) == 0)) {//leap year
                if ($s_month == 1) {
                    $s_lastdate = $s_lastdate_Day;
                    $m_days = $s_lastdate - $s_date + 1;
                    $s_year_quarter = (($m_days + 29 + 31) / 91) + 3;
                    $getsquartcalcUserProperty=$s_year_quarter;              }
                else if ($s_month == 2) {
                    $s_lastdate = $s_lastdate_Day;
                    $m_days = $s_lastdate - $s_date + 1;
                    $s_year_quarter = (($m_days + 31) / 91) + 3;
                    $getsquartcalcUserProperty=$s_year_quarter;
                }
                else if ($s_month == 3) {
                    $s_lastdate = $s_lastdate_Day;
                    $m_days = $s_lastdate - $s_date + 1;
                    $s_year_quarter = ($m_days / 91) + 3;
                    $getsquartcalcUserProperty=$s_year_quarter;
                }
            }
            else {
                if ($s_month == 1) {
                    $s_lastdate = $s_lastdate_Day;
                    $m_days = $s_lastdate - $s_date + 1;
                    $s_year_quarter = floatval(($m_days + 28 + 31) / 90) + 3;
                    $getsquartcalcUserProperty=$s_year_quarter;
                }
                else if ($s_month == 2) {
                    $s_lastdate = $s_lastdate_Day;
                    $m_days = $s_lastdate - $s_date + 1;
                    $s_year_quarter = (($m_days + 31) / 90) + 3;
                    $getsquartcalcUserProperty=$s_year_quarter;
                }
                else if ($s_month == 3) {
                    $s_lastdate = $s_lastdate_Day;
                    $m_days = $s_lastdate - $s_date + 1;
                    $s_year_quarter = ($m_days / 90) + 3;
                    $getsquartcalcUserProperty=$s_year_quarter;
                }
            }
            if ($s_month == 4) {
                $s_lastdate = $s_lastdate_Day;
                $m_days = $s_lastdate - $s_date + 1;
                $s_year_quarter = (($m_days + 31 + 30) / 91) + 2;
                $getsquartcalcUserProperty=$s_year_quarter;
            }
            else if ($s_month == 5) {
                $s_lastdate = $s_lastdate_Day;
                $m_days = $s_lastdate - $s_date + 1;
                $s_year_quarter = (($m_days + 30) / 91) + 2;
                $getsquartcalcUserProperty=$s_year_quarter;
            }
            else if ($s_month == 6) {
                $s_lastdate = $s_lastdate_Day;
                $m_days = $s_lastdate - $s_date + 1;
                $s_year_quarter = ($m_days / 91) + 2;
                $getsquartcalcUserProperty=$s_year_quarter;
            }
            else if ($s_month == 7) {
                $s_lastdate = $s_lastdate_Day;
                $m_days = $s_lastdate - $s_date + 1;
                $s_year_quarter = (($m_days + 31 + 30) / 92) + 1;
                $getsquartcalcUserProperty=$s_year_quarter;
            }
            else if ($s_month == 8) {
                $s_lastdate = $s_lastdate_Day;
                $m_days = $s_lastdate - $s_date + 1;
                $s_year_quarter = (($m_days + 30) / 92) + 1;
                $getsquartcalcUserProperty=$s_year_quarter;
            }
            else if ($s_month == 9) {
                $s_lastdate = $s_lastdate_Day;
                $m_days = $s_lastdate - $s_date + 1;
                $s_year_quarter = ($m_days / 92) + 1;
                $getsquartcalcUserProperty=$s_year_quarter;
            }
            else if ($s_month == 10) {
                $s_lastdate = $s_lastdate_Day;
                $m_days = $s_lastdate - $s_date + 1;
                $s_year_quarter = ($m_days + 30 + 31) / 92;
                $getsquartcalcUserProperty=$s_year_quarter;
            }
            else if ($s_month == 11) {
                $s_lastdate = $s_lastdate_Day;
                $m_days = $s_lastdate - $s_date + 1;
                $s_year_quarter = ($m_days + 31) / 92;
                $getsquartcalcUserProperty=$s_year_quarter;
            }
            else if ($s_month == 12) {
                $s_lastdate = $s_lastdate_Day;
                $m_days = $s_lastdate - $s_date + 1;
                $s_year_quarter = $m_days / 92;
                $getsquartcalcUserProperty=$s_year_quarter;
            }


            //END DATE QUARTER CALCULATION
            if ((($e_year % 4) == 0 && ($e_year % 100) != 0) || (($e_year % 400) == 0)) {//leap year
                if ($e_month == 1) {
                    $e_year_quarter = $e_date / 91;
                    $getequartcalcUserProperty=$e_year_quarter;
                }
                else if ($e_month == 2) {
                    $e_year_quarter = (31 + $e_date) / 91;
                    $getequartcalcUserProperty=$e_year_quarter;                }
                else if ($e_month == 3) {
                    $e_year_quarter = (31 + 29 + $e_date) / 91;
                    $getequartcalcUserProperty=$e_year_quarter;                }
            }
            else {
                if ($e_month == 1) {
                    $e_year_quarter = $e_date / 90;
                    $getequartcalcUserProperty=$e_year_quarter;                }
                else if ($e_month == 2) {
                    $e_year_quarter = (31 + $e_date) / 90;
                    $getequartcalcUserProperty=$e_year_quarter;                }
                else if ($e_month == 3) {
                    $e_year_quarter = (31 + 28 + $e_date) / 90;
                    $getequartcalcUserProperty=$e_year_quarter;                }
            }
            if ($e_month == 4) {
                $e_year_quarter = ($e_date / 91) + 1;
                $getequartcalcUserProperty=$e_year_quarter;            }
            else if ($e_month == 5) {
                $e_year_quarter = ((30 + $e_date) / 91) + 1;
                $getequartcalcUserProperty=$e_year_quarter;            }
            else if ($e_month == 6) {
                $e_year_quarter = ((30 + 31 + $e_date) / 91) + 1;
                $getequartcalcUserProperty=$e_year_quarter;            }
            else if ($e_month == 7) {
                $e_year_quarter = ($e_date / 92) + 2;
                $getequartcalcUserProperty=$e_year_quarter;            }
            else if ($e_month == 8) {
                $e_year_quarter = ((31 + $e_date) / 92) + 2;
                $getequartcalcUserProperty=$e_year_quarter;            }
            else if ($e_month == 9) {
                $e_year_quarter = ((31 + 31 + $e_date) / 92) + 2;
                $getequartcalcUserProperty=$e_year_quarter;            }
            else if ($e_month == 10) {
                $e_year_quarter = ($e_date / 92) + 3;
                $getequartcalcUserProperty=$e_year_quarter;            }
            else if ($e_month == 11) {
                $e_year_quarter = ((31 + $e_date) / 92) + 3;
                $getequartcalcUserProperty=$e_year_quarter;            }
            else if ($e_month == 12) {
                $e_year_quarter = ((31 + 30 + $e_date) / 92) + 3;
                $getequartcalcUserProperty=$e_year_quarter;            }
        }
        $quarters=floatval($getbyquartcalcUserProperty)+floatval($getsquartcalcUserProperty)+floatval($getequartcalcUserProperty);
        $quarters=number_format($quarters,2,'.','');
        return $quarters;
    }
}
}
