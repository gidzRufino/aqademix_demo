<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Hrdbprocess extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('hr_model');
    }
    
    function saveCourse($coursedata){
        $course = $this->hr_model->saveCourse($coursedata);
        return $course;
    }
     
    function saveCollege($collegedata){
        $college = $this->hr_model->saveCollege($collegedata);
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
    
    function getPaymentSchedule()
    {
        $data['paymentSchedule'] = $this->hr_model->getPaymentSchedule();
        $this->load->view('payroll/payment_schedule', $data);
    }
    
    function getSalaryGrade()
    {
        $data['salaryGrade'] = $this->hr_model->getSalaryGrade();
        $this->load->view('payroll/salary_grade', $data);
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
    
    function calculateAMHours($timeInHour, $timeInMin, $timeOutHour, $timeOutMin)
    {
        $settings = Modules::run('main/getSet');
        $schoolHourTime = $timeHourIn= substr($settings->time_in, 0, 1);
        $schoolMinTime = $timeHourIn= substr($settings->time_in, 1, 2);
        $totalTime = 0;
        
        if($timeInHour!=0):
            if($timeInHour==$schoolHourTime && $timeInMin==0):
                $myTimeInHour  = $timeInHour-7;
                $myTimeInMin = $timeInMin;
            else:
                $myTimeInHour = $timeInHour;
                $myTimeInMin = $timeInMin;
            endif;

            $myTimeOutHour = $timeOutHour;
            $myTimeOutMin = $timeOutMin;


            if($myTimeInHour < $schoolHourTime): // if employee is early
                $myTimeInHour = 8;
                if($myTimeOutHour < 12): //Out before Lunch
                    if($myTimeOutHour==0):
                        $undertime = $myTimeOutMin/60;
                        $totalTime = ($myTimeOutHour - $myTimeInHour)+$undertime;
                    else:
                        $undertime = $myTimeOutMin/60;
                        $totalTime = ($myTimeOutHour - $myTimeInHour)+$undertime;
                    endif;

                else:
                    //if out is beyond 12pm
                    if($myTimeOutHour==0 || $myTimeOutHour>=12):
                        $totalTime = (12 - $myTimeInHour);
                    else:
                        $totalTime = ($myTimeOutHour - $myTimeInHour);
                    endif;
                endif;
            else: // if employee is late
                    $tardy = $timeInMin/60;
                    if($timeOutHour!=0):
                        if($myTimeOutHour < 12): //Out before Lunch
                            $undertime = $myTimeOutMin/60;
                            $totalTime = ($myTimeOutHour - $myTimeInHour)+$undertime;

                        else:
                        //if out is beyond 12pm
                            if($myTimeOutHour>=12):
                                $totalTime = (12 - $myTimeInHour);
                            else:
                                $totalTime = ($myTimeOutHour - $myTimeInHour);
                            endif;
                        endif;

                    else:
                          $totalTime = (12 - $myTimeInHour)-$tardy;
                    endif;

            endif;
        else:
            $totalTime = 0;
        endif;
        
        $total = array(
            'tardy'     => $tardy,
            'undertime' => $undertime,
            'total'     => $totalTime
        );
        
        return $total;
        
    }
    function calculatePMHours($timeInHour, $timeInMin, $timeOutHour, $timeOutMin)
    {
        $settings = Modules::run('main/getSet');
        $schoolHourTime = $timeHourIn= substr($settings->time_in, 0, 1);
        $schoolMinTime = $timeHourIn= substr($settings->time_in, 1, 2);
        $totalTime = 0;
        
        if($timeInHour==$schoolHourTime && $timeInMin==0):
            $myTimeInHour  = $timeInHour-12;
            $myTimeInMin = $timeInMin;
        else:
            $myTimeInHour = $timeInHour;
            $myTimeInMin = $timeInMin;
        endif;
        
        $myTimeOutHour = $timeOutHour;
        $myTimeOutMin = $timeOutMin;
        
        
        if($myTimeInHour < 13): // if employee is early
            $myTimeInHour = 13;
            if($myTimeOutHour < 17): //Out before 5
                if($myTimeOutHour==0):
                    $undertime = $myTimeOutMin/60;
                    $totalTime = ($myTimeOutHour - $myTimeInHour)+$undertime;
                else:
                    $undertime = $myTimeOutMin/60;
                    $totalTime = ($myTimeOutHour - $myTimeInHour)+$undertime;
                endif;
                
            else:
                //if out is beyond 5
                if($myTimeOutHour==0 || $myTimeOutHour>=17):
                    $totalTime = (17 - $myTimeInHour);
                else:
                    $totalTime = ($myTimeOutHour - $myTimeInHour);
                endif;
            endif;
        else: // if employee is late
                $tardy = $timeInMin/60;
                if($timeOutHour!=0):
                    if($myTimeOutHour < 17): //Out before Lunch
                        $undertime = $myTimeOutMin/60;
                        $totalTime = ($myTimeOutHour - $myTimeInHour)+$undertime;

                    else:
                    //if out is beyond 5pm
                        if($myTimeOutHour>=17):
                            $totalTime = (17 - $myTimeInHour)-$tardy;
                        else:
                            $totalTime = ($myTimeOutHour - $myTimeInHour);
                        endif;
                    endif;

                else:
                      $totalTime = (17 - $myTimeInHour)-$tardy;
                endif;
            
        endif;
        $total = array(
            'tardy'     => $tardy,
            'undertime' => $undertime,
            'total'     => $totalTime
        );
        
        return $total;
        //return $totalTime;
        
    }
    
    function getHoursWork($timeIn, $timeOut, $ampm)
    {
        $finalunder = 0;
        $timeMinOver = 0;   
        $timeMinEarly = 0;
        $timeMinIn = substr($timeIn, 2, 2);
        $timeHourIn= substr($timeIn, 0, 2);
        if($timeHourIn>24):
            $timeHourIn = substr($timeIn, 0, 1);
            $timeMinIn = substr($timeIn, 1, 2);
        endif;
        $timeMinOut = substr($timeOut, 2, 2);
        $timeHourOut= substr($timeOut, 0, 2);
        $mainHour = 4;
        $finaltardy = 0;
        
        if($ampm=='AM'):
            $totalTime = $this->calculateAMHours($timeHourIn, $timeMinIn, $timeHourOut, $timeMinOut);
        else:
            $totalTime = $this->calculatePMHours($timeHourIn, $timeMinIn, $timeHourOut, $timeMinOut);
        endif;
        
        
        $data = array(
            'totalTime' => $totalTime['total'],
            'undertime' => $totalTime['undertime'],
            'tardy' => $totalTime['tardy'],
        );
        
        return $data;
    }
    
    function getNumberOfHoursWork($timeIn, $timeOut)
    {
        $finalunder = 0;
        $timeMinOver = 0;   
        $timeMinEarly = 0;
        $timeMinIn = substr($timeIn, 2, 2);
        $timeHourIn= substr($timeIn, 0, 2);
        $timeMinOut = substr($timeOut, 2, 2);
        $timeHourOut= substr($timeOut, 0, 2);
        $mainHour = 4;
        $finaltardy = 0;
        
        if($timeHourIn < 13){
            $timeInHour = 8;
            $timeInMin = 0;
            $timeOutHour = 12;
            $timeOutMin   = 0;
            $break = 1;
        }else{
            $timeInHour = 13;
            $timeInMin = 0;
            $timeOutHour = 17;
            $timeOutMin   = 0;
        }
        if($timeMinIn>$timeInMin){
            $timeMinEarly = $timeMinIn/60;
            $timeMinEarly = 1 - $timeMinEarly;
        }else{
            $timeMinEarly = 0;
        }        

        if($timeMinOut>$timeOutMin){
            $timeMinOver = $timeMinOut/60;
        }else{
            $timeMinOver = 0;
        }
        
        $timeMinus = $timeMinEarly + $timeMinOver;
        
        if($timeHourIn < 13){
            //In before 12 out 
            if($timeHourIn < $timeInHour){ // if employee is early
                $timeHourIn = 8;
                if($timeHourOut < 13):
                    if(abs($timeMinOut)==0){
                       $finalunder = 1;
                   }else{
                       $finalunder = $timeMinOut/60;
                       $finalunder = 1 - $finalunder;
                   } 
                   $totalTime = ($timeHourOut - abs($timeHourIn)+1)-$finalunder;
                   // $totalTime = 'Yes';
                endif;
                
                //scans out between 1 - 4:59pm
                if($timeHourOut >= 13 && $timeHourOut < 17):
                   if(abs($timeMinOut)==0){
                       $finalunder = 1;
                   }else{
                       $finalunder = $timeMinOut/60;
                       $finalunder = 1 - $finalunder;
                   } 
                   $totalTime = (($timeHourOut - abs($timeHourIn)+1)- $break)-$finalunder;
                endif;
                
            }else{ // if employee is late

             
              //late by the number of Hours
              $hourTardy = $timeHourIn - $timeInHour;
              if($hourTardy==1){
                  $finaltardy = $hourTardy - 1;
              }
              if(abs($timeMinIn)>0)
                {
                    $minTardy = $timeMinIn/60;
                    $minTardy = 1 - $minTardy;
                }else{
                    $minTardy = 0;
                }
              
              
              //scans out between 1 - 4:59pm
              if($timeHourOut >= 13 && $timeHourOut < 17):
                   if(abs($timeMinOut)==0){
                       $finalunder = 1;
                   }else{
                       $finalunder = $timeMinOut/60;
                       $finalunder = 1 - $finalunder;
                   } 
                   $totalTime = (($timeHourOut - abs($timeHourIn)+1)- $break)-$finalunder+$finaltardy;
                   //$totalTime = 'Yes';
              else:
                   $totalTime = ((($timeHourOut - abs($timeHourIn))- $break) - $finalunder) - ($minTardy);
              endif;
           }
        }else{ // if scans in between 1 - 5pm
            //late by the number of Hours
              $hourTardy = $timeHourIn - $timeInHour;
              //late by the number of mins
              $minTardy = $timeMinIn/60;

              //Total Tardiness
              $finaltardy = $hourTardy + $minTardy;
              
              if($timeHourOut >= 13 && $timeHourOut < 17):
                   if(abs($timeMinOut)==0){
                       $finalunder = 1;
                   }else{
                       $finalunder = $timeMinOut/60;
                       $finalunder = 1 - $finalunder;
                   } 
                   $totalTime = ($timeHourOut - abs($timeHourIn)+1)-$finalunder;
                   //$totalTime = 'Yes';
             else:
                   $totalTime = $timeHourOut - abs($timeHourIn);
             endif;
        }   
       
        $data = array(
            'early'     => $timeHourIn,
            'over'     => $timeHourOut,
            'tardy'     => $finaltardy,
            'undertime' => $finalunder,
            'totalTime' => $totalTime
        );
     
        return $data;   
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
                         $firstweek = 5; 
                         }else {
                         $firstweek = 6-$firstday;
                         }
                    $totalfw = 7-$firstday;

                    //workdays of last week
                    if ($lastday==6){
                         //so we don't count sat, sun=0 so it won't be counted anyway
                         $lastweek = 5;
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
