<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Hrdbprocess extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('hr_model');
        $this->load->model('payroll_model');
    }
    
    function getPayrollTimes($emp_id, $dateFrom, $dateTo, $time_group_id)
    {
        $timeInCompute = 0;
        $timeOutCompute = 0;
        $timeInPMCompute = 0;
        $timeOutPMCompute = 0;
        $totalUndertimePm = 0;
        $totalUndertime = 0;
        $days = 0;
        $records = $this->hr_model->searchDtrbyDate($dateFrom, $dateTo, $emp_id);
        foreach ($records as $row)
        {
            $days++;  
                if($row->time_in!=""){
                    if(mb_strlen($row->time_in)<=3):
                       $time_in = date("g:i a", strtotime("0".$row->time_in));
                       $forUnderIn = date("g:i:s", strtotime("0".$row->time_in));
                    else:
                        $time_in = date("g:i a", strtotime($row->time_in));
                       $forUnderIn = date("g:i:s", strtotime($row->time_in)); 
                    endif;
                     
                     $timeInCompute = $row->time_in;
                    
                }else{
                    $time_in = "";
                    $forUnderIn = "";
                }
                
                if($row->time_out!=""){
                    if(mb_strlen($row->time_out)<=3):
                        $time_out = date("g:i a", strtotime('0'.$row->time_out));
                    else:
                        $time_out = date("g:i a", strtotime($row->time_out));
                    endif;
                    $timeOutCompute = $row->time_out;
                }else{
                    $time_out = "";
                }
                
                if($row->time_in_pm!=""){
                        $time_in_pm = date("g:i a", strtotime($row->time_in_pm));
                      $timeInPMCompute = $row->time_in_pm;  
                }else{
                    $time_in_pm = "";
                }
                if($row->time_out_pm!=""){
                        $time_out_pm = date("g:i a", strtotime($row->time_out_pm));
                        $timeOutPMCompute = $row->time_out_pm;
                       $forUnderPMOut = date("g:i:s", strtotime($row->time_out_pm));
                }else{
                    $time_out_pm = "";
                    $forUnderPMOut = "";
                    
                    
                }
                $officialTime = Modules::run('hr/hrdbprocess/getTimeShift', $time_group_id);
                $officialTimeInAm = ($officialTime?$officialTime->ps_from:'08:00:00');
                $officialTimeOutAm = ($officialTime?$officialTime->ps_to:'12:00:00');

                $officialTimeInPm = ($officialTime?$officialTime->ps_from_pm:'13:00:00');
                $officialTimeOutPm = ($officialTime?$officialTime->ps_to_pm:'17:00:00');


                
                if($timeInCompute!=0):// In AM
                    $tardyAm = ((strtotime($time_in) - strtotime($officialTimeInAm)))<= 0?0:(strtotime($time_in) - strtotime($officialTimeInAm))/60;
                else:
                    $tardyAm = 4*60;
                endif;
                if($timeOutCompute!=0):
                    $undertimeAm = ((strtotime($officialTimeOutAm) - strtotime($time_out)))<= 0?0:(strtotime($officialTimeOutAm) - strtotime($time_out))/60;
                    $totalUndertime = $tardyAm + $undertimeAm;
                else:
                    if($timeOutPMCompute==0):
                        $totalUndertime = 4*60;
                    else:
                        $totalUndertime = $tardyAm;
                    endif;
                endif;

                if($timeInPMCompute!=0):
                    $tardyPm = ((strtotime($time_in_pm) - strtotime($officialTimeInPm)))<= 0?0:(strtotime($time_in_pm) - strtotime($officialTimeInPm))/60;
                else:
                    if($timeOutPMCompute!=0):
                        $undertimePM =  (strtotime($officialTimeOutPm) - strtotime($time_out_pm)) <= 0?0:(strtotime($officialTimeOutPm) - strtotime($time_out_pm))/60;
                        $totalUndertimePm = $undertimePM;
                    else:
                        $totalUndertimePm = 4*60;
                    endif;
                endif;

               // $totalUndertimeTardy = ($tardyAm + $undertimeAm)+($tardyPm+$undertimePm);
                $totalUndertimeTardy += $totalUndertime+$totalUndertimePm;
                
                unset($undertimeAm);
                unset($undertimePM);
                unset($totalUndertime);
                unset($totalUndertimePm);
                $timeInCompute = 0;
                $timeInPMCompute = 0;
                $timeOutCompute = 0;
                $timeOutPMCompute = 0;
            
        }
        
        
        return json_encode(array('undertime' => $totalUndertimeTardy, 'present'=> $days));
    }
    
    function getTimeShift($time_group_id = NULL)
    {
        $timeShift = $this->hr_model->getTimeShift($time_group_id);
        return $timeShift;
    }
    
    function getUndertime($time_id, $time, $option)
    {
        $timeClock = $this->hr_model->getTime($time_id);
        $tc = ($option=='in'?'ps_from':'ps_to');
        if($option=='in'):
            $timeDiff = strtotime($time) - strtotime($timeClock->$tc);
        else:
            if($time!=""):
                $timeDiff = strtotime($timeClock->$tc) - strtotime($time);
            else:
                $timeDiff = 240*60;
            endif;
        endif;
        $undertime = $timeDiff/60;
        return ($undertime<=0?0:$undertime);
        //return $time;
    }
    
    function loanDeductionProcess($user_id)
    {
       $od_id = 0;
       $ca_total = 0;
       
       $myLoans = Modules::run('hr/getPersonalLoanRequest', $user_id);
       if(!$myLoans):
           $finalAmount = '';
           $credit_amount = '';
           $trans_id = '';
       else:
           foreach ($myLoans->result() as $ll): 
                switch ($ll->odp_id):
                    case 1:
                        break;
                    case 2:
                        $credit_amount = $ll->charge/$ll->no_terms;
                        $trans_id = $ll->od_trans_id;
                        break;
                    case 3:
                        break;
                    case 4:
                        break;
                    case 5:
                        $credit_amount = $ll->charge;
                        $trans_id = $ll->od_trans_id;
                        break;
                endswitch;
                $ca_total += $credit_amount;
                $od_id[] = $trans_id;
            endforeach;
       endif;
        
        
        $array = array(
            'od_id'         => $od_id,
            'TotalAmount'   => $finalAmount,
            'creditAmount'  => $ca_total
        );
        return json_encode($array);
        
    }
    
    function getOtherDeductions()
    {
        $data['payment_terms'] = Modules::run('hr/getOdTerms');
        $data['other_deductions'] = $this->hr_model->getOtherDeductions();
        $this->load->view('payroll/other_deductions', $data);
    }
    
    function saveCourse($coursedata, $course=NULL){
        $course = $this->hr_model->saveCourse($coursedata, $course);
        return $course;
    }
     
    function saveCollege($collegedata, $college=NULL){
        $college = $this->hr_model->saveCollege($collegedata, $course);
        return $college;
    }
     
    function saveEmploymentDetails($hrStatus){
         $this->hr_model->saveEmploymentDetails($hrStatus);
    }
     
    function saveAccounts($accounts){
         $this->hr_model->saveAccounts($accounts);
    }
    
    function updateAccounts($uname, $data)
    {
        $this->hr_model->updateAccount($uname, $data);
    } 
    function saveAcademeInfo($details)
    {
        $this->hr_model->saveAcademeInfo($details);
    }
    
    function getListOfDepartmentsPositions()
    {
        $data['department']     = $this->hr_model->getDepartment();
        $this->load->view('departments_positions', $data);
    }
    
    function getPaymentSchedule($get=NULL)
    {
        if($get==NULL):
            //$data['paymentSchedule'] = $this->hr_model->getPaymentSchedule();
            $data['time_settings']    = Modules::run('hr/payroll/getRawTimeShifting');
            $this->load->view('payroll/payment_schedule', $data);
        else:
//            $paymentSchedule = $this->hr_model->getPaymentSchedule();
//            return $paymentSchedule;
        endif;
    }
    
    function getSalaryGrade()
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $data['defaultDeductions'] = $this->payroll_model->getDefaultDeductions();
        $data['salaryGrade'] = $this->hr_model->getSalaryGrade();
        
        if(file_exists(APPPATH.'modules/hr/views/payroll/'. strtolower($settings->short_name).'_salary_grade.php')):
            $this->load->view('payroll/'. strtolower($settings->short_name).'_salary_grade', $data);
        else:
            $this->load->view('payroll/salary_grade', $data);
        endif;
    }
    
    function getPayrollInfo($user_id)
    {
        //$data['employeeSalary'] = $this->hr_model->getSalaryGradeByEmployee($user_id);
        $data['payrollInfo'] = $this->hr_model->getPayrollInfo($user_id);
        $data['user_id'] = $user_id;
        $data['salaryGrade'] = $this->hr_model->getSalaryGrade();
        $this->load->view('payroll/payroll_info', $data);
    }
    
    function getIndividualPaySlip($user_id, $start, $end)
    {
        
    }
    
    function getBasicDTR($user_id, $start, $end)
    {
        $getDTRRecords = $this->hr_model->getDTRRecords($user_id, $start, $end);
        $finalTotalAm = 0;
        $finalTotalPm = 0;
        $finalTardyAm = 0;
        $finalTardyPm = 0;
        $finalUnderAm = 0;
        $finalUnderPm = 0;
        $timeInAM = 0;
        $timeOutAM =0;
        $timeInPM = 0;
        $timeOutPM =0;
        $x = 0;
        foreach($getDTRRecords as $row){
            $x++;
            $timeInAM = $row->time_in;
            $timeOutAM =$row->time_out;
            $timeInPM = $row->time_in_pm;
            $timeOutPM =$row->time_out_pm;
            $totalAm = $this->getHoursWork($timeInAM, $timeOutAM, 'AM');
            $totalPm = $this->getHoursWork($timeInPM, $timeOutPM, 'PM');
            
            $finalTotalAm = $finalTotalAm + $totalAm['totalTime'];
            $finalTotalPm = $finalTotalPm + $totalPm['totalTime'];
            $finalTardyAm = $finalTardyAm + $totalAm['tardy'];
            $finalTardyPm = $finalTardyPm + $totalPm['tardy'];
            $finalUnderAm = $finalUnderAm + $totalAm['undertime'];
            $finalUnderPm = $finalUnderPm + $totalPm['undertime'];
        }
//        $totalAm = $this->getNumberOfHoursWork($timeInAM, $timeOutAM, 'AM');
//        $totalPm = $this->getNumberOfHoursWork($timeInPM, $timeOutPM, 'PM');
        $totalDailyHours = $finalTotalAm + $finalTotalPm;
        //echo 'total='.$totalDailyHours.'<br>';
        $finalTardy = $finalTardyAm + $finalTardyPm;
        $finalUndertime = $finalUnderAm + $finalUnderPm;
        $totalTimeDeduction = $finalTardy + $finalUndertime;
        
        $total = array(
            'totalDeduction' => round($totalTimeDeduction, 2),
            'totalDaysWorked' => $x,
        );
        
        return $total;
        //echo $timeInAM;
        
    }
    
    function getManHours($timeIn, $timeOut, $date)
    {
        $date = date_create($date);
        $settings = Modules::run('main/getSet');

    if(file_exists(APPPATH.'modules/hr/controllers/'. ucfirst($settings->short_name).'_hr.php')):    
        $data = Modules::run('hr/'.strtolower($settings->short_name.'_hr').'/getManHours',$timeIn, $timeOut, $date);
    else:    
        $timeStart = strtotime(date_format($date, 'Y-m-d'). date('H:i:s', strtotime($timeIn)));
        $timeEnd = strtotime(date_format($date, 'Y-m-d'). date('H:i:s', strtotime($timeOut)));

        $timeDiff = $timeEnd - $timeStart;


        $totalTime = ($timeDiff/3600);
        $hours = round($totalTime, 0, PHP_ROUND_HALF_DOWN);
        if($hours>4):
            //$hours = $hours;
            $hours = 4;
        endif;
        $minutes = ($timeDiff % 3600)/60;
        if($minutes<0):
            $minutes = 0;
        endif;
        if($hours<0):
            $hours = 0;
        endif;
        $data = array(
            'totalTime' => $hours,
            'minutes' => $minutes,
            'start' => $timeStart,
            'end' => $timeEnd,
        );
      
    endif;    
    
        return json_encode($data);  
    }
    
    
    function getNumberOfSchooDays($from, $to){
        $numDay = 0;
        $numOfDays = ((strtotime($from) - strtotime($to))/(60*60*24) * -1) + 1;  
        for($x=1; $x <= $numOfDays;$x++){
            $day = strval($x);
            if(strlen($day) == 1){
                $day = '0'.$day;
            }
            $Date = substr($from, -4).'/'.$from[0].$from[1].'/'.$day;
            $thisDate = date('Y/m/d', strtotime($Date. ' + 0 days'));
            $dayName = date('l', strtotime($thisDate));
            if($dayName == 'Saturday' || $dayName == 'Sunday'){
                $n = "";
            }else{
                $numDay++;
            }
        }
        return $numDay;
    }
    
    
    function get_weekdays($m,$y) {
        $lastday = date("t",mktime(0,0,0,$m,1,$y));
        $weekdays=0;
        for($d=29;$d<=$lastday;$d++) {
            $wd = date("w",mktime(0,0,0,$m,$d,$y));
            if($wd > 0 && $wd < 6) $weekdays++;
            }
        return $weekdays+20;
    }
    
    function getWorkdays($date1, $date2, $workSat = FALSE, $patron = NULL) {
        if (!defined('SATURDAY')) define('SATURDAY', 6);
        if (!defined('SUNDAY')) define('SUNDAY', 0);
        // Array of all public festivities
        $holiday = Modules::run('calendar/getHolidays', date('Y-m', strtotime($date1)));
        $i = 0;
        foreach ($holiday as $day):
            $i++;
            $publicHolidays[] = date('m-d', strtotime($day->event_date));
        endforeach;
        // The Patron day (if any) is added to public festivities
        if ($patron) {
          $publicHolidays[] = $patron;
        }
        /*
         * Array of all Easter Mondays in the given interval
         */
        $yearStart = date('Y', strtotime($date1));
        $yearEnd   = date('Y', strtotime($date2));
        for ($i = $yearStart; $i <= $yearEnd; $i++) {
          $easter = date('Y-m-d', easter_date($i));
          list($y, $m, $g) = explode("-", $easter);
          $monday = mktime(0,0,0, date($m), date($g)+1, date($y));
          $easterMondays[] = $monday;
        }
        $start = strtotime($date1);
        $end   = strtotime($date2);
        $workdays = 0;
        for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
          $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
          $mmgg = date('m-d', $i);
          if ($day != SUNDAY &&
            !in_array($mmgg, $publicHolidays) &&
            !in_array($i, $easterMondays) &&
            !($day == SATURDAY && $workSat == FALSE)) {
              $workdays++;
          }
        }
        return intval($workdays);
      }
        
   function count_workdays($date1,$date2){
        $firstdate = strtotime($date1);
        $lastdate = strtotime($date2);
        $firstday = date('w',$firstdate);
        $lastday = date('w',$lastdate);
        $totaldays = intval(($lastdate-$firstdate)/86400)+1;

        //check for one week only
        if ($totaldays<=7 && $firstday<=$lastday){
             $workdays = $lastday-$firstday+1;
             //check for weekend
             if ($firstday==0){
                     $workdays = $workdays-1;
                    }
             if ($lastday==6){
                     $workdays = $workdays-1;
                    }

        }else { //more than one week

                     //workdays of first week
                    if ($firstday==0){
                            //so we don't count weekend
                            $firstweek = 6; 
                         }else {
                            $firstweek = 7-$firstday;
                         }
                    $totalfw = 7-$firstday;

                    //workdays of last week
                    if ($lastday==7){
                         //so we don't count sat, sun=0 so it won't be counted anyway
                         $lastweek = 7;
                         }else {
                         $lastweek = $lastday;
                         }
                    $totallw = $lastday+1;

                    //check for any mid-weeks 
                    if (($totalfw+$totallw)>=$totaldays){
                         $midweeks = 0;
                         } else { //count midweeks
                         $midweeks = (($totaldays-$totalfw-$totallw)/7)*5;
                         }

                    //total num of workdays
                    $workdays = $firstweek+$midweeks+$lastweek;

                }

        /*
        check for and subtract and holidays etc. here
        ...
        */

        return ($workdays);
        } //end funtion count_workdays() 
}
