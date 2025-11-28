<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payroll
 *
 * @author genru
 */
class Payroll extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('payroll_model');
        $this->load->model('hr_model');
        $this->load->library('pdf');
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
    
    public function index()
    {
        $data['modules'] = 'hr';
        $data['main_content'] = 'payroll/default';
        echo Modules::run('templates/college_content', $data);
    }
    
    function saveShifts()
    {
        $group_id = $this->post('group_id');
        $shift_id = $this->post('shift_id');
        
        $current_shift_id = $this->payroll_model->getShiftId($group_id);
        $current_group_id = $this->payroll_model->getGroupId($shift_id);
        
        $saveShiftDetails = array(
            'shift_id' => $shift_id
        );
        
        $this->payroll_model->saveShifts($saveShiftDetails, $group_id);
        
        $secondShiftDetails = array(
            'shift_id' => $current_shift_id
        );
        
        $data = $this->payroll_model->saveShifts($secondShiftDetails, $current_group_id, $current_shift_id);
        
        $json = array(
           'group_id' => $current_group_id,
           'ps_from'  => date('g:i:s a', strtotime($data->ps_from)),
           'ps_to'  => date('g:i:s a', strtotime($data->ps_to)),
        );
        
        echo json_encode($json);
        
    }
    
    function getPayrollShift()
    {
        $payrollShift = $this->payroll_model->getPayrollShift();
        return $payrollShift;
    }
    
    function getRawTimeShifting()
    {
        $timeShift = $this->payroll_model->getRawTimeShifting();
        return $timeShift;
    }
    
    function getTimeShifting($user_id)
    {
        $timeShift = $this->payroll_model->getTimeShifting($user_id);
        return $timeShift;
    }
    
    function saveShiftGroup()
    {
        $user_id = $this->post('user_id');
        $groupings = $this->post('groupings');
        
        $details = array(
           'time_group_id' => $groupings  
        );
        
        $this->payroll_model->saveShiftGroup($details, $user_id);
    }
    
    function getShiftGroupings()
    {
        $groupings = $this->payroll_model->getShiftGroupings();
        return $groupings;
    }
    
    
    function payrollToExcel($startDate, $endDate, $pc_code = NULL)
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        
        
        $data['getPayrollReport'] = $this->payroll_model->getPayrollReport();
        
        
        $this->load->library('excel');
        $this->load->helper('download');
        
        $sdateItems = explode('-', $startDate );
        $dateItems = explode('-', $endDate);
        $data['startD'] = $sdateItems[2];
        $data['endD'] = $dateItems[2];
        
        $data['paymentSchedule'] = $this->hr_model->getPaymentSchedule();
        $data['defaultDeductions'] = $this->payroll_model->getDefaultDeductions();
        $data['hrdb'] = Modules::load('hr/hrdbprocess/');
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['pc_code'] = $pc_code;
        
        
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        
        if(file_exists(APPPATH.'modules/hr/views/payroll/'. strtolower($settings->short_name).'_payrollToExcel.php')):
            $this->load->view('payroll/'. strtolower($settings->short_name).'_payrollToExcel', $data);
        else:    
            $this->load->view('payroll/payrollToExcel', $data);
        endif;
        
        $filename='payroll.xls'; //save our workbook as this file name
       // $filename=$settings->short_name.'_'.$sy.'_'.$s->course_id.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    public function printPayroll($startDate, $endDate, $pc_code = NULL)
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        
        $sdateItems = explode('-', $startDate );
        $dateItems = explode('-', $endDate);
        $data['startD'] = $sdateItems[2];
        $data['endD'] = $dateItems[2];
        
        $data['paymentSchedule'] = $this->hr_model->getPaymentSchedule();
        $data['defaultDeductions'] = $this->payroll_model->getDefaultDeductions();
        $data['hrdb'] = Modules::load('hr/hrdbprocess/');
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        
        
        $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m', strtotime($startDate)), 10)), date('Y', strtotime($startDate)), 'first');
        $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m', strtotime($endDate)), 10)), date('Y', strtotime($endDate)), 'last');
//            $firstDayName = date('D',  strtotime('first Day of '.date("F", mktime(0, 0, 0, segment_4, 10)).' '.date('Y', strtotime($startDate))));
        $data['hrdb'] = Modules::load('hr/hrdbprocess/');

        //calculation of the Basic Pay and the benefits
        $data['workdays'] = $data['hrdb']->getWorkdays($startDate, $endDate, TRUE);

        $data['daysInAMonth'] = $data['hrdb']->getWorkdays(date('Y-m', strtotime($startDate)).'-0'.$firstDay, date('Y-m', strtotime($endDate)).'-'.$lastDay, TRUE);
        
        $data['getPayrollReport'] = $this->payroll_model->getPayrollReport();
        $data['pc_code'] = $pc_code;
        if(file_exists(APPPATH.'modules/hr/views/payroll/'. strtolower($settings->short_name).'_printPayroll.php')):
            $this->load->view('payroll/'. strtolower($settings->short_name).'_printPayroll', $data);
        else:    
            $this->load->view('payroll/printPayroll', $data);
        endif;
    }
    
    function checkTransaction($profile_id, $pc_code)
    {
        $trans = $this->payroll_model->checkTransaction($profile_id, $pc_code);
        return $trans;
    }
    
    function getPayrollProfile($em_id)
    {
        $profile = $this->payroll_model->getPayrollProfile($em_id);
        return $profile;
    }
    
    function releasePayroll()
    {
        $em_id = $this->post('em_id');
        $pc_code = $this->post('pc_code');
        $netPay = $this->post('netPay');
        
        $payrollProfile = $this->getPayrollProfile($em_id);
        
        $details = array(
            'ptrans_status'         => 1,
            'ptrans_date_release'   => date('Y-m-d G:i:s')
        );
        $saved = $this->payroll_model->releasePayroll($details, $em_id, $pc_code);
        if($saved):
            Modules::run('accountingsystem/createJournalEntry', $payrollProfile->pp_act_to, 'Net Payroll of employee '.$em_id, $netPay, 1);
            Modules::run('accountingsystem/createJournalEntry', $payrollProfile->pp_debit_to, 'Net Payroll of employee '.$em_id, $netPay, 0);
            echo 'Successfully Posted';
        else: 
            echo 'Sorry something went wrong';
        endif;
        
        
    }
    
    function approvePayroll()
    {
        $em_id = $this->post('em_id');
        $netPay = $this->post('netPay');
        $pc_code = $this->post('pc_code');
        
        $details = array(
            'ptrans_profile_id'     => $em_id,
            'ptrans_pay_code'       => $pc_code,
            'ptrans_amount'         => $netPay,
            'ptrans_timestamp'      => date('Y-m-d G:i:s')
        );
        
        $saved = $this->payroll_model->approvePayroll($details, $em_id, $pc_code);
        if($saved):
            return TRUE;
        else: 
            return FALSE;
        endif;
    }
    
    function generatePayrollProfile()
    {
        $this->payroll_model->generatePayrollProfile();
        return;
    }
    
    function getStatBen($sg_id, $statBen_id)
    {
        $stats = $this->payroll_model->getStatBen($sg_id, $statBen_id);
        return $stats;
    }
    
    function setStatBen()
    {
        $salary = $this->post('salary_grade');
        $statBen = $this->post('statBen');
        $amount = $this->post('amount');
        $ddDate = $this->post('ddDate');
        
        $details = array(
            'stat_item_id'  => $statBen,
            'stat_sg_id'    => $salary,
            'stat_amount'   => $amount,
            'stat_ded_sched'=> $ddDate
        );
        
        $saved = $this->payroll_model->setStatBen($details, $statBen, $salary);
        if($saved):
            echo 'Successfully Set';
        else:
            echo 'Sorry Something went wrong';
        endif;
    }
    
    function addPayrollItems()
    {
        $itemName = $this->post('itemName');
        $itemType = $this->post('itemType');
        $itemCat = $this->post('itemCat');
        
        $details = array(
           'pi_item_name'   => $itemName,
           'pi_item_type'   => $itemType,
           'pi_item_cat'    => $itemCat
        );
        
        $saved = $this->payroll_model->addPayrollItems($details, $itemName);
        if($saved):
            echo 'Successfully Added';
        else:
            echo 'Items already exists';
        endif;
    }
    
    function getPayrollItems($cat = NULL)
    {
        $items = $this->payroll_model->getPayrollItems($cat);
        return $items;
    }
    
    function settings()
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $data['defaultDeductions'] = $this->payroll_model->getDefaultDeductions();
        $data['salaryGrade'] = $this->hr_model->getSalaryGrade();
        $data['hrdb'] = Modules::load('hr/hrdbprocess/');
        $data['modules'] = 'hr';
        
        if(file_exists(APPPATH.'modules/hr/views/payroll/'. strtolower($settings->short_name).'_settings.php')):
            $data['main_content'] = 'payroll/'. strtolower($settings->short_name).'_settings';
        else:    
            $data['main_content'] = 'payroll/settings';
        endif;
            
        echo Modules::run('templates/college_content', $data);
    }
    
    function saveSG()
    {
        $em_id = $this->post('em_id');
        $salary = $this->post('salary_grade');
        
        $details = array(
            'pp_em_id'  => $em_id,
            'pp_sg_id'  => $salary
        );
        
        $sg = $this->payroll_model->saveSG($details, $em_id);
        return $sg;
    }
    
    function generatePayrollReport($pc_code = NULL)
    {   
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        
        $startDate = $this->post('fromDate');
        $endDate = $this->post('toDate');
        $sdateItems = explode('-', $startDate );
        $dateItems = explode('-', $endDate);
        $data['startD'] = $sdateItems[2];
        $data['endD'] = $dateItems[2];
        
        $data['paymentSchedule'] = $this->hr_model->getPaymentSchedule();
        $data['defaultDeductions'] = $this->payroll_model->getDefaultDeductions();
        $data['hrdb'] = Modules::load('hr/hrdbprocess/');
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['getPayrollReport'] = $this->payroll_model->getPayrollReport();
        foreach($data['getPayrollReport'] as $pr):
             foreach($data['defaultDeductions'] as $deductions): 
                $statBen = Modules::run('hr/payroll/getStatBen', $pr->pg_id, $deductions->pi_item_id);
                if($statBen!=NULL):
                    if($statBen->stat_ded_sched>=$data['startD'] && $statBen->stat_ded_sched <=$data['endD']):
                        $statAmount = $statBen->stat_amount;
                    else:
                        $statAmount = 0;
                    endif;
                else:
                    $statAmount = 0;
                endif;
                Modules::run('hr/payroll/setPayrollCharges',$pr->employee_id, $deductions->pi_item_id, $statAmount, $pc_code) ;
            endforeach;
        endforeach;
        $data['pc_code'] = $pc_code;
        if(file_exists(APPPATH.'modules/hr/views/payroll/'. strtolower($settings->short_name).'_payroll_report_table.php')):
            $this->load->view('payroll/'. strtolower($settings->short_name).'_payroll_report_table', $data);
        else:    
            $this->load->view('payroll/payroll_report_table', $data);
        endif;
        
    }
    
    public function addDeduction()
    {
        $em_id = $this->post('em_id');
        $pc_code = $this->post('pc_code');
        $amount = $this->post('amount');
        $item_id = $this->post('item_id');
        $this->setPayrollCharges($em_id, $item_id, $amount, $pc_code);
    }
    
    public function getPayrollCharges($pc_code, $profile_id=NULL)
    {
        $charges = $this->payroll_model->getPayrollCharges($pc_code, $profile_id);
        return $charges;
    }
    
    public function getPayrollChargesByItem($item_id, $pc_code, $profile_id=NULL)
    {
        $charges = $this->payroll_model->getPayrollChargesByItem($item_id, $pc_code, $profile_id);
        return $charges;
    }
    
    public function getTotalPayrollChargesByItem($item_id, $pc_code)
    {
        $charges = $this->payroll_model->getTotalPayrollChargesByItem($item_id, $pc_code);
        return $charges;
    }
    
    public function setPayrollCharges($profile_id, $item_id, $pc_amount, $pc_code)
    {
        if($pc_amount!=0):
            $details = array(
                'pc_profile_id' => $profile_id,
                'pc_amount'     => $pc_amount,
                'pc_code'       => $pc_code,
                'pc_item_id'    => $item_id
            );
            $this->payroll_model->setPayrollCharges($details, $profile_id, $item_id, $pc_code);
        else:
            $this->payroll_model->deletePayrollCharges($profile_id, $item_id, $pc_code);
        endif;
    }
    
    public function setPayrollPeriod()
    {
        $fromDate = $this->post('fromDate');
        $toDate = $this->post('toDate');
        $pc_code = $this->post('pc_code');
        
        $details = array(
           'per_from'   => $fromDate,
            'per_to'    => $toDate,
            'per_code'  => $pc_code
        );
        
        $saved = $this->payroll_model->setPayrollPeriod($fromDate, $toDate, $details);
        if($saved):
            echo 'Payroll Successfully Set';
        else:
            echo 'Payroll Period has already been set';
        endif;
    }
    
    public function create() 
    {
        $data['payrollPeriod'] = $this->payroll_model->getPayrollPeriod();
        $data['modules'] = 'hr';
        $data['main_content'] = 'payroll/create';
        echo Modules::run('templates/canteen_content', $data);
    }
    
    
}
