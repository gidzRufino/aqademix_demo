<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Finance_ccsa extends MX_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
        $this->load->model('finance_model_ccsa');
        $this->load->model('finance_model');
	$this->load->library('pagination');
        $this->load->library('Pdf');
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
    
    function cancelReceipt()
    {
        $receiptNumber = $this->post('receiptNumber');
        if($this->finance_model_ccsa->cancelReceipt($receiptNumber)):
            echo 'Successfully Cancelled';
        else:
            echo 'Sorry Something Went Wrong';
        endif;
    }
    
    //Books Summary
    function loadFinanceDetails($grade_id=NULL, $school_year = NULL)
    {
        $this->load->library('excel');
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getNumberFormat('General');
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        
        
        $this->excel->getActiveSheet()->setCellValue('A1', 'Lastname');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Firstname');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Book Charges');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Book Discount');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Book Payment');
        
        $students = Modules::run('registrar/getAllStudentsForExternal', $grade_id, NULL, NULL, 1);
        
        $totalPayment = 0;
        $totalBookPayment = 0;
        $totalBookDiscount = 0;
        $countColumn = 3;
        $bookC = 0;
        
        foreach ($students->result() as $st):
            
            $plan = Modules::run('finance/getPlanByCourse', $grade_id, 0);
            $charges = Modules::run('finance/financeChargesByPlan',0, $school_year, 0, $plan->fin_plan_id );
            foreach ($charges as $c):
                switch ($c->item_id):
                    case 3:
                        $bookC = $c->amount;
                    break;   
                endswitch;
            endforeach;
            $bookP = Modules::run('finance/getIndividualTransactionByItemId', $st->st_id, 0, $school_year, 3);
            $bookD = Modules::run('finance/getIndividualTransactionByItemId', $st->st_id, 0, $school_year, 3, 2);
        
            if($bookP->num_rows()!=0):
                foreach ($bookP->result() as $chrg):
                        $totalBookPayment += $chrg->t_amount;
                endforeach;
            else:
                $totalBookPayment = 0;
            endif;
            
            if($bookD->num_rows()!=0):
                foreach ($bookD->result() as $td):
                        $totalBookDiscount += $td->t_amount;
                endforeach;
            else:
                $totalBookDiscount = 0;
            endif;
        
            //$overAllPayment += $totalPayment;
            $countColumn++;
            $this->excel->getActiveSheet()->setCellValue('A'.$countColumn, strtoupper($st->lastname));
            $this->excel->getActiveSheet()->setCellValue('B'.$countColumn, strtoupper($st->firstname));
            $this->excel->getActiveSheet()->setCellValue('C'.$countColumn, strtoupper($bookC));
            $this->excel->getActiveSheet()->setCellValue('D'.$countColumn, strtoupper($totalBookDiscount));
            $this->excel->getActiveSheet()->setCellValue('E'.$countColumn, strtoupper($totalBookPayment));
            
            $totalPayment = 0;
            $bookC = 0;
            $totalBookDiscount = 0;
            $totalBookPayment = 0;
            $grade_level = $st->level;
        endforeach;
        
        $this->excel->getActiveSheet()->setTitle($grade_level);
        
        $filename=$grade_level.' Book Summary.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    
    function searchFundTransferAccount($value, $year=NULL)
    {
        $student = $this->finance_model_ccsa->searchFundTransferAccount($value, $year);
        echo '<ul>';
        foreach ($student as $s):
        ?>
                <li style="font-size:18px;" onclick="$('#searchTransferName').hide(), $('#searchTransferBox').val('<?php echo $s->firstname.' '.$s->lastname ?>'), $('#transferSTID').val('<?php echo $s->st_id ?>'), $('#transferNameTo').val('<?php echo strtoupper($s->lastname.', '.$s->firstname) ?>')" ><?php echo strtoupper($s->lastname.', '.$s->firstname) ?></li>   
        <?php        
        endforeach;
        echo '</ul>';
        
    }
    
    function processFundTransfer()
    {
        $transfer_trans_id = $this->post('transfer_trans_id');
        $transferAmountFrom = $this->post('transferAmountFrom');
        $transferedAmount = $this->post('transferedAmount');
        $transferItemFrom = $this->post('transferItemFrom');
        $transferItemTo = $this->post('transferItemTo');
        $transferReceiptType = $this->post('transferReceiptType');
        $transferRefNumber = $this->post('transferRefNumber');
        $transferSchoolYear = $this->post('transferSchoolYear');
        $transferSchoolYearTo = $this->post('transferSchoolYearTo');
        $transferSTID = $this->post('transferSTID');
        $transferSTIDFrom = $this->post('transferSTIDFrom');
        $transferItemNameFrom = $this->post('transferItemNameFrom');
        $transferItemNameTo = $this->post('transferItemNameTo');
        $transferPaymentType = $this->post('transferPaymentType');
        $transferNameFrom = $this->post('transferNameFrom');
        $transferNameTo = $this->post('transferNameTo');
        
        
        if($transferSTID==$transferSTIDFrom):
            $remarksFrom = 'FT to: [ Amount: '.$transferedAmount.'Php; Item : '.$transferItemNameTo.' ]';
            $remarksTo = 'FT from: [ Amount: '.$transferedAmount.'Php; Item : '.$transferItemNameFrom;
        else:
            $remarksFrom = 'FT to: [ Amount: '.$transferedAmount.'Php; Item : '.$transferItemNameTo.'; Account Name: '.$transferNameTo ;
            $remarksTo = 'FT from: [ Amount: '.$transferedAmount.'Php; Item : '.$transferItemNameFrom.'; Account Name: '.$transferNameFrom ;
            
        endif;
        
        $fundRemaining = $transferAmountFrom - $transferedAmount;
        
        $remainingFundUpdate = array(
            't_amount'      => $fundRemaining,
            't_remarks'     => $remarksFrom
        );
        
        $transferTransactionDetails = array(
            'ref_number'    => $transferRefNumber,
            't_st_id'       => $transferSTID,
            't_em_id'       => $this->session->employee_id,
            't_amount'      => $transferedAmount,
            't_charge_id'   => $transferItemTo,
            't_type'        => $transferPaymentType,
            't_date'        => date('Y-m-d'),
            't_school_year' => $transferSchoolYearTo,
            't_receipt_type'=> $transferReceiptType,
            't_remarks'     => $remarksTo
        );
        
        if($this->finance_model_ccsa->updateFundTransfer($remainingFundUpdate, $transfer_trans_id, $transferSchoolYear)):
            
            $result = $this->finance_model_ccsa->saveTransaction($transferTransactionDetails, $transferSchoolYearTo);
            if(!$result):
                    echo 'Funds Transferred Error Occured To';
            else:
                
                $transferDetails = array(
                    'fft_st_id_from'    => $transferSTIDFrom,
                    'fft_st_id_to'      => $transferSTID,
                    'fft_item_id_from'  => $transferItemFrom,
                    'fft_item_id_to'    => $transferItemTo,
                    'fft_amount'        => $transferedAmount,
                    'fft_transferred_by'=> $this->session->employee_id,
                    'fft_trans_id'      => $result,
                    'fft_datetime'      => date('Y-m-d G:i:s')
                );
            
                if($this->finance_model_ccsa->saveTransferFunds($transferDetails, $transferSchoolYear)):
                    echo 'Funds Transferred Successfully';
                else:
                    echo 'Funds Transferred Error Occured in Transferred Log';
                endif;
                
            endif;
        else:
             echo 'Funds Transferred Error Occured From';
        endif;
    }
            
    
    function prepareFundTransfer()
    {
        $school_year = $this->post('school_year');
        $trans_id = $this->post('trans_id');
        
        $data['school_year'] = $school_year;
        $data['name'] =  $this->post('name');
        $data['st_id'] =  $this->post('st_id');
        $data['fin_items'] = $this->finance_model->getFinItems();
        $data['transaction'] = $this->finance_model->loadFinanceTransaction($trans_id, $school_year);
        $this->load->view('fundTransfer', $data);
    }
    
    
    public function saveRO()
    {
        $settings = Modules::run('main/getSet');
        $grade_id = $this->input->post('grade_id');
        $section_id = $this->input->post('section_id');
        $st_id = $this->input->post('st_id');
        $school_year = $this->input->post('school_year');
        
        $profile = $this->finance_model_ccsa->getPreviousRecord('profile', 'user_id', $st_id,  $school_year, $settings );
        $profile_students = $this->finance_model_ccsa->getPreviousRecord('profile_students','user_id',$profile->user_id, $school_year, $settings);
        $profile_address = $this->finance_model_ccsa->getPreviousRecord('profile_address_info','address_id',$profile->add_id, $school_year, $settings);
        $profile_contact = $this->finance_model_ccsa->getPreviousRecord('profile_contact_details','contact_id',$profile->contact_id, $school_year, $settings);
        $profile_parents = $this->finance_model_ccsa->getPreviousRecord('profile_parents','parent_id',$profile->user_id, $school_year, $settings);
        //$bdate = $this->finance_model_ccsa->getPreviousRecord('calendar','cal_id',$profile->bdate_id, $school_year, $settings);
        
        //print_r($profile_parents);
        if($profile_parents->guardian==0):
            $f_profile = $this->finance_model_ccsa->getPreviousRecord('profile','user_id',$profile_parents->father_id, $school_year, $settings);
            $m_profile = $this->finance_model_ccsa->getPreviousRecord('profile','user_id',$profile_parents->mother_id, $school_year, $settings);
        else:
            $g_profile = $this->finance_model_ccsa->getPreviousRecord('profile','user_id',$profile_parents->guardian, $school_year, $settings);
        endif;
        
        //$date = strtr($bdate->cal_date, '-', '/');
        //$date = date('Y-m-d', strtotime($date));
        $sy = $school_year+1;
        if(!empty($profile)):
            $this->finance_model_ccsa->insertData($profile, 'profile', NULL, NULL, $sy);
            $this->finance_model_ccsa->insertData($profile_students, 'profile_students', NULL, NULL, $sy);
            //$this->finance_model_ccsa->insertData($profile_parents, 'profile_parents');
            $parent_details = array(
                'parent_id'             => $profile->user_id,
                'father_id'             => $profile_parents->father_id,
                'mother_id'             => $profile_parents->mother_id,
                'f_office_name'         => $profile_parents->f_office_name,
                'f_office_address_id'   => $profile_parents->f_office_address_id,
                'm_office_name'         => $profile_parents->m_office_name,
                'm_office_address_id'   => $profile_parents->m_office_address_id,
                'ice_name'              => $profile_parents->ice_name,
                'ice_contact'           => $profile_parents->ice_contact
                
            );
            
            $this->finance_model_ccsa->insertData($parent_details, 'profile_parents', NULL, NULL, $sy);
            
            $this->finance_model_ccsa->insertData($m_profile, 'profile', NULL, NULL, $sy);
            $this->finance_model_ccsa->insertData($f_profile, 'profile', NULL, NULL, $sy);
            //$dateItems = explode('-', $bdate->cal_date);
            $bCal = array(
                'cal_id'    => $bdate->cal_id,
                'cal_date'  => $date
            );
            
            Modules::run('calendar/saveCalendar', $bCal, $bdate->cal_id);
            
            $date_id = Modules::run('calendar/saveDate', date('Y-m-d'));
            
            Modules::run('main/detect_column', 'esk_profile_students_admission', 'st_type');
            
            $admission = array(
                'school_year'       => $sy,
                'date_admitted'     => date('Y-m-d G:i:s'),
                'user_id'           => $profile->user_id,
                'grade_level_id'    => $grade_id,
                'section_id'        => $section_id,
                'status'            => 2,
                'school_last_attend'    => strtoupper($settings->set_school_name),
                'sla_address'       => strtoupper($settings->set_school_address),
                'st_id'             => $profile_students->st_id,
                'st_type'           => 1
            );
            
            $this->finance_model_ccsa->insertData($profile_address, 'profile_address_info','address_id',$profile->add_id, NULL, NULL, $sy);
            $this->finance_model_ccsa->insertData($profile_contact, 'profile_contact_details','contact_id',$profile->contact_id, NULL, NULL, $sy);
            
            if($this->finance_model_ccsa->saveStudentAdmission($admission, $profile->user_id, $sy)):
                
                Modules::run('main/logActivity','REGISTRAR',  $this->session->userdata('name').' has Roll Over Student '. strtoupper($profile->firstname.' '.$profile->lastname), $this->session->userdata('employee_id'), $sy);
                echo 'Successfully Saved';
            else:
                echo 'Student is Already on the list';
            endif;
        endif; 
        
    }
    
    
    public function saveROTransaction()
    {
        $school_year = $this->post('school_year');
        $user_id = $this->post('user_id');
        $grade_id = $this->post('grade_id');
        $semester = $this->post('sem');
        $or_num = $this->post('or_num');
        $st_id = $this->post('st_id');
        $transaction = $this->post('items');
        $transDate = $this->post('transDate');
        $receipt = $this->post('receipt');
        $t_remarks = $this->post('t_remarks');
        $transType = $this->post('transType');
        $chequeNumber = $this->post('chequeNumber');
        $bank = $this->post('bank');
        $count = count(json_decode($transaction));
        $final = json_decode($transaction);
        $column = array();
        $success = 0;
        
        $this->setROFinanceAccount($grade_id, $user_id, $school_year);
        
        for ($x = 0; $x < $count; $x++) {
            
            $items = explode('_', $final[$x]);
            
            $details = array(
                'ref_number'        => $or_num,
                't_st_id'           => $st_id,
                't_em_id'           => $this->session->userdata('employee_id'),
                't_amount'          => $items[1],
                't_charge_id'       => $items[0],
                't_type'            => $transType,
                'bank_id'           => $bank,
                'tr_cheque_num'     => $chequeNumber,
                't_date'            => $transDate,
                't_sem'             => $semester,
                't_school_year'     => $school_year, 
                't_receipt_type'    => $receipt,
                't_remarks'         => $t_remarks
            );
            
            //array_push($column, $details);
            $result = $this->finance_model_ccsa->saveTransaction($details, ($school_year));
            if(!$result):
            else:
                $success++;
                $this->addExtraFinanceCharges($items[0], $semester, $items[1], ($school_year), $user_id);
                Modules::run('web_sync/updateSyncController', 'c_finance_transactions', 'trans_id', $result, 'create', 6);
                Modules::run('main/logActivity','FINANCE',  $this->session->userdata('name').' has added a transaction with reference #'.$or_num.'.', $this->session->userdata('employee_id'), $school_year);
            endif;
        }
        
            if($success==$count):
                echo 'Successfully Saved';
            endif;
            
        
    }
    
    private function addExtraFinanceCharges($item, $sem, $amount, $sy, $user_id)
    {
        $charge = array(
            'extra_st_id' => $user_id,
            'extra_item_id'    => $item,
            'extra_amount'  => $amount,
            'extra_sem' => $sem,
            'extra_school_year'     => $sy
        );
        $result = $this->finance_model_ccsa->addExtraFinanceCharges($charge, $sy);
        Modules::run('main/logActivity','FINANCE',  $this->session->userdata('name').' has added an Extra Charge with item id #'.$item.'.', $this->session->userdata('employee_id'), $sy);
        return;
    }
    
    
    function setROFinanceAccount($grade_id, $user_id, $school_year)
    {
        $plan = Modules::run('finance/getPlanByCourse',$grade_id, 0);
        
        $finDetails = array(
            'fin_st_id'         => $user_id,
            'fin_term_id'       => 0,
            'fin_plan_id'       => $plan->fin_plan_id,
            'fin_school_year'   => $school_year,
        );
        
        $this->finance_model_ccsa->setFinanceAccount($finDetails, $user_id, $plan->fin_plan_id, $school_year, $sem);
        
        //Modules::run('college/updateEnrollmentStatus', $st_id, $this->session->userdata('school_year'), $sem, 1);  
        
        return;
    }
    
    function getStudents($grade_id, $school_year=NULL)
    {
        $result = $this->finance_model_ccsa->getStudents($grade_id,$school_year);
        return $result;
    }
    
    function getRevenue($school_year=NULL)
    {
        $data['gradeLevel'] = Modules::run('registrar/getGradeLevel');
        $data['modules'] = 'finance';
        $data['school_year'] = $school_year;
        $data['main_content'] = 'pisd_collectible';
        echo Modules::run('templates/canteen_content', $data);
    }
    
    function getIndividualDiscountPerLevel($level_id, $item_id=NULL)
    {
        $data['discounts'] = $this->finance_model_ccsa->getIndividualDiscountPerLevel($level_id,$item_id);
        $this->load->view('reports/pisd_discountList', $data);
    }
    
    function getDiscountPerLevelDetails($level_id, $item_id, $date, $school_year = NULL)
    {
        $discounts = $this->finance_model_ccsa->getDiscountPerLevelDetails($level_id, $item_id, $date, ($school_year==NULL?$this->session->school_year:$school_year));
        foreach ($discounts->result() as $r):
            echo $r->t_charge_id.' '. strtoupper($r->t_amount.' '.$r->lastname.', '.$r->firstname).'<br />';
        
            $total += $r->t_amount;
        endforeach;
        echo $total;
        //return $discounts;
    }
    
    function getDiscountPerLevel($level_id, $item_id, $date, $school_year = NULL)
    {
        $discounts = $this->finance_model_ccsa->getDiscountPerLevel($level_id, $item_id, $date,($school_year==NULL?$this->session->school_year:$school_year));
        
        return $discounts;
    }
    
    function getExtraFinanceCharges($st_id, $sem, $school_year, $item_id=NULL)
    {
        $charges = $this->finance_model_ccsa->getExtraFinanceCharges($st_id, $sem, $school_year, $item_id);
        return $charges;
    }
    
    function getTotalDue($user_id, $student, $plan)
    {
        $totalAmount = 0;
         $totalExtra = 0;
         $totalPayment = 0;
         $totalDiscount = 0;
         $totalDue = 0;
         $overallDue = 0;
         $overAllDue = 0;
         $totalBalance = 0;
         $totalOtherBalance = 0;
         $overAllBalance = 0;
         $otherBalance = 0;
         $color = 'alert-info';
         foreach ($charges as $c):
            $discount = Modules::run('finance/billing/getTransactionByCategory', $student->uid, 0,$student->school_year,$c->category_id,2);
            $totalDiscount += $discount->amount;

             $charge = Modules::run('finance/getChargesByCategory', $c->category_id, 0,$student->school_year, $plan->fin_plan_id);
             $amount = $charge->row()->amount;
             if($c->category_id != 1):
                $totalAmount += $amount;
                 if($c->category_id == 0):
                     $extraCharges = Modules::run('finance/getExtraFinanceCharges',$user_id, 0, $student->school_year);
                    if($extraCharges->num_rows()>0):
                        foreach ($extraCharges->result() as $ec):
                            $totalExtra += $ec->extra_amount;
                        endforeach;
                    endif;
                 endif;

                 $payment = Modules::run('finance/billing/getTransactionByCategory', $student->uid, 0, $student->school_year, $c->category_id);
                 $totalPayment += $payment->amount;
                 $columnTotal = ($amount+$totalExtra) - ($payment->amount+$discount->amount);
                 $totalOtherBalance += $columnTotal;
                 $overAllBalance +=$totalOtherBalance;

                 switch (TRUE):
                     case $columnTotal==0:
                         $color = 'alert-success'; 
                     break;    
                     case $columnTotal>0:
                         $color = 'alert-info'; 
                     break; 
                     case $totalOtherBalance<=0:
                         $color = 'alert-success';
                     break;
                 endswitch;
                 //echo $totalDiscount;
            $overAllDue += $columnTotal;
            if($c->category_id==0):
                $mcharges = Modules::run('finance/finance_pisd/financeChargesByPlan',0, $this->session->userdata('school_year'), 0, $plan->fin_plan_id );
                foreach ($mcharges as $mcharge):
                    if($mcharge->category_id==0):
                        $totalMCharges += $mcharge->amount;
                        $mChargeAmount = $mcharge->amount;
                        $inxcharges = Modules::run('finance/finance_pisd/inExtraCharges', $user_id, $mcharge->item_id);
                        foreach ($inxcharges as $inxc):
                            $inxcharge += $inxc->extra_amount;
                        endforeach;
                        if(!$inxcharges):
                        else:
                            $mChargeAmount = $mChargeAmount+$inxcharge;
                        endif;
                        $mdiscount = Modules::run('finance/billing/getTransactionByCategory', $student->uid, 0,$student->school_year,$mcharge->category_id,2);
                        $mtotalDiscount = $mdiscount->amount;
                        $mPayments = Modules::run('finance/finance_pisd/getTransactionByItemId', $student->uid, NULL,$this->session->userdata('school_year'), $mcharge->item_id);
                        foreach ($mPayments->result() as $mp):
                            $totalMpayments += $mp->t_amount;
                        endforeach;
                    endif;
                     $overAllMPayments += $totalMpayments;
                     $totalMpayments = 0;
                endforeach;
                $prevItemID = 0;
                $extraC = Modules::run('finance/getExtraFinanceCharges',$user_id, 0, $student->school_year);
                if($extraC->num_rows()>0):
                    foreach ($extraC->result() as $exc):
                        $incharges = Modules::run('finance/finance_pisd/inCharges', $exc->item_id, $plan->fin_plan_id);
                        if(!$incharges):
                            $mxPayments = Modules::run('finance/finance_pisd/getTransactionByItemId', $student->uid, NULL,$this->session->userdata('school_year'), $exc->item_id);
                            foreach ($mxPayments->result() as $mxp):
                                $totalMxpayments += $mxp->t_amount;
                            endforeach;

                        $overAllDue +=($exc->extra_amount-$totalMxpayments);
                            if($exc->item_id!=$prevItemID):
                                $totalMxpayments = 0; 
                            endif;
                            $prevItemID = $exc->item_id;
                        endif;
                    endforeach;
                    //echo $totalMxpayments;


                endif;
            endif;
            else:

                $tfdiscount = Modules::run('finance/billing/getTransactionByCategory', $student->uid, 0, $student->school_year, $c->category_id, 2);
                $tfdiscounts = $tfdiscount->amount;
                $amount = ($tfdiscounts!=0?($tfdiscounts>=$amount)?$amount:$amount-$tfdiscounts:$amount);
                $partialPayment = 0;
                $totalAmount += $amount;
                $payment = Modules::run('finance/billing/getTransactionByCategory', $student->uid, 0, $student->school_year, $c->category_id);
                $totalTFPayment = $payment->amount;

                $startMonth = 6;
                $totalMonth = 12;
                $currentMonth = abs(date('m'));
                //$currentMonth = 12;
                switch ($btype):
                    case 1:
                        $monthPassed = $currentMonth - $startMonth;
                        $monthlyFee = $amount/10;
                        $numMonth = $monthPassed;
                        $addMonth = 0;
                    break;    
                    case 2:
                        $monthPassed = $currentMonth - $startMonth;
                        $monthPassed = $monthPassed+3;
                        $monthlyFee = $amount/4;
                        $numMonth = 4;
                        $addMonth = 2;

                    break;    
                    case 3:
                        $monthPassed = $currentMonth - $startMonth;
                        $monthPassed = $monthPassed+5;
                        $monthlyFee = $amount/2;
                        $numMonth = 2;
                        $addMonth = 4;
                    break;    
                endswitch;
                $tfpayment = 0;
                $atfpayment = 0;
                $ptfpayment = 0;
                $previousBalance = 0;
                $overAllTFCharges = 0;
                //$totalTFPayment = $totalTFPayment/$monthlyFee;
                for($i = 1; $i<=$totalMonth; $i++):

                    $monthNums = (($i+6)+$addMonth);
                    $monthNum = ($monthNums>12?$monthNums-12:$monthNums);
                    $monthNum = ($monthNum < 10?'0'.$monthNum:$monthNum);

                    $discount = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, $monthNums, 2);
                    $discounts = $discount->amount;

                    $atpayment = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, ($monthNums+1));
                    $atfpayment = $atpayment->amount;

                    $ptpayment = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, ($monthNums-1));
                    $ptfpayment = $ptpayment->amount;

                    $tpayment = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, $monthNums);
                    $tfpayment = $tpayment->amount;

                    $expectedPayment = ($monthlyFee * $i);
                    $overAllTFCharges = $monthlyFee * 10;
                    $totalBalance = $totalTFPayment;
                    $totalBalance = $expectedPayment - $totalBalance;

                    if($tfpayment==0):
                        $tfpayment = 0;
                        if($totalTFPayment>$expectedPayment):
                           $tfpayment = $monthlyFee;
                        else:
                            if($atfpayment!=0): //advance Pyament
                                if($expectedPayment == $totalTFPayment):
                                    $tfpayment = $monthlyFee;
                                elseif($totalTFPayment > $expectedPayment):
                                    $tfpayment = $totalTFPayment - $monthlyFee;
                                endif;

                            else:
                                if($ptfpayment!=0): // has Previous Payment

                                    if(($monthlyFee - $totalBalance)>0):
                                        $tfpayment = $monthlyFee - $totalBalance;
                                    else:
                                        $tfpayment = 0;
                                    endif;
                                    if($expectedPayment == $totalTFPayment):
                                        $tfpayment = $monthlyFee;
                                    endif;
                                else:

                                    if(($monthlyFee - $totalBalance)>0):
                                        if(($overAllTFCharges-$totalTFPayment)>$monthlyFee):

                                            //$tfpayment = $totalTFPayment - ($expectedPayment-$monthlyFee);
                                            if($totalTFPayment>$expectedPayment):

                                            else:
                                                $tfpayment = $monthlyFee-$totalBalance;
                                                //
                                            endif;
                                        else:
                                            if($expectedPayment == $totalTFPayment):
                                                $tfpayment = $monthlyFee;
                                            elseif($expectedPayment>$totalTFPayment):
                                                //echo $totalBalance.' | '.($i+6).' | '.($overAllTFCharges-$totalTFPayment).'<br />';
                                                $tfpayment = $monthlyFee - $totalBalance;
                                            else:    
                                                $tfpayment = $expectedPayment - $totalTFPayment;
                                            endif;
                                        endif;
                                    else:
                                        $tfpayment = 0;
                                    endif;
                                endif;
                            endif;
                        endif;
                    else:
                       if(($i+6)>7):
                           if($totalTFPayment>$expectedPayment):
                                 $tfpayment = $monthlyFee;

                            else:

                                if($ptfpayment!=0): // has Previous Payment
                                    //echo $monthlyFee - ($expectedPayment-$totalTFPayment); 

                                    if(($monthlyFee - $totalBalance)>0):
                                        $tfpayment = $monthlyFee - $totalBalance;
                                    else:
                                        $tfpayment = 0;
                                    endif;
                                else:
                                    if(($monthlyFee - $totalBalance)>0):
                                        if(($overAllTFCharges-$totalTFPayment)>$monthlyFee):
                                            $tfpayment = $totalTFPayment - ($expectedPayment-$monthlyFee);
                                        else:
                                            if($expectedPayment == $totalTFPayment):
                                                $tfpayment = $monthlyFee;
                                            else:    
                                                $tfpayment = $expectedPayment - $totalTFPayment;
                                            endif;
                                        endif;
                                    else:
                                        $tfpayment = 0;
                                    endif;
                                endif;
                                if($expectedPayment == $totalTFPayment):
                                    $tfpayment = $monthlyFee; 
                                endif;

                            endif; 

                       else: //first month
                            if($totalTFPayment>$expectedPayment):
                                $tfpayment = $monthlyFee;
                            elseif($expectedPayment == $totalTFPayment):
                                $tfpayment = $monthlyFee;
                            else:
                                $tfpayment = 0;
                            endif;


                       endif;
                    endif;

                        $totalDue = ($i+6)<=$currentMonth?$monthlyFee-$tfpayment:0;

                        if($totalDiscount>=$totalAmount || $totalDiscount==$overAllTFCharges):
                            $totalDue = 0;
                        endif;
                        $color = ($i+6)<$currentMonth?$totalDue>0?'alert-danger':'alert-success':'alert-info';
                        $color = ($i+6)<=$currentMonth?$totalDue==0?'alert-success':'alert-info':'alert-info';
                        $overAllDue += $totalDue;
                        $totalTFDue += $totalDue;
                       // echo $totalDiscount+$tfpayment.'<br />';
                endfor;

            endif;
                
        endforeach; 
    }
    
    function inCharges($item_id, $plan_id)
    {
        $inCharges = $this->finance_model_ccsa->inCharges($item_id, $plan_id);
        return $inCharges;
    }
    
    function inExtraCharges($user_id, $item_id)
    {
        $inCharges = $this->finance_model_ccsa->inExtraCharges($user_id, $item_id);
        return $inCharges;
    }
    
    function financeChargesByPlan($isGroup=NULL, $school_year, $sem, $plan=NULL)
    {
        $charges = $this->finance_model_ccsa->financeChargesByPlan($school_year, $sem, $plan, $isGroup);
        return $charges;
    }
    
    public function getTransactionByItemId($st_id, $sem, $school_year, $item_id=NULL, $type=NULL, $order = NULL, $isGroup=NULL)
    {
        $transaction = $this->finance_model_ccsa->getTransactionByItemId($st_id, $sem, $school_year, $item_id, $type, $order,$isGroup);
        return $transaction;
    }
    
    function printSOA($option, $secIn = NULL)
    {
        
        if($option==0):
            $data['student'] = $this->finance_model_ccsa->getBasicStudent( base64_decode($secIn), $this->session->school_year);
        else:
            $data['students'] = $this->finance_model_ccsa->getStudentPerSection($secIn, $this->session->school_year);
        endif;
        $this->load->view($option==0?'reports/pisd_printSOAIndividual':'reports/pisd_printSOASection', $data);
    }
    
  
   
   
}
