<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Finance_lc extends MX_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
        $this->load->model('finance_model_lc');
	$this->load->library('pagination');
        $this->load->library('Pdf');
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
    
    public function hasCollection($account_id, $from=NULL, $to=NULL, $item_id =NULL)
    {
        $collection = $this->finance_model_lc->hasCollectionPerItem($account_id,$from, $to, $item_id);
        return $collection;
    }
    
    public function saveRO()
    {
        $settings = Modules::run('main/getSet');
        $grade_id = $this->input->post('grade_id');
        $section_id = $this->input->post('section_id');
        $st_id = $this->input->post('st_id');
        $school_year = $this->input->post('school_year');
        
        $profile = $this->finance_model_pisd->getPreviousRecord('profile', 'user_id', $st_id,  $school_year, $settings );
        $profile_students = $this->finance_model_pisd->getPreviousRecord('profile_students','user_id',$profile->user_id, $school_year, $settings);
        $profile_address = $this->finance_model_pisd->getPreviousRecord('profile_address_info','address_id',$profile->add_id, $school_year, $settings);
        $profile_contact = $this->finance_model_pisd->getPreviousRecord('profile_contact_details','contact_id',$profile->contact_id, $school_year, $settings);
        $profile_parents = $this->finance_model_pisd->getPreviousRecord('profile_parents','parent_id',$profile->user_id, $school_year, $settings);
        //$bdate = $this->finance_model_pisd->getPreviousRecord('calendar','cal_id',$profile->bdate_id, $school_year, $settings);
        
        //print_r($profile_parents);
        if($profile_parents->guardian==0):
            $f_profile = $this->finance_model_pisd->getPreviousRecord('profile','user_id',$profile_parents->father_id, $school_year, $settings);
            $m_profile = $this->finance_model_pisd->getPreviousRecord('profile','user_id',$profile_parents->mother_id, $school_year, $settings);
        else:
            $g_profile = $this->finance_model_pisd->getPreviousRecord('profile','user_id',$profile_parents->guardian, $school_year, $settings);
        endif;
        
        //$date = strtr($bdate->cal_date, '-', '/');
        //$date = date('Y-m-d', strtotime($date));
        $sy = $school_year+1;
        if(!empty($profile)):
            $this->finance_model_pisd->insertData($profile, 'profile', NULL, NULL, $sy);
            $this->finance_model_pisd->insertData($profile_students, 'profile_students', NULL, NULL, $sy);
            //$this->finance_model_pisd->insertData($profile_parents, 'profile_parents');
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
            
            $this->finance_model_pisd->insertData($parent_details, 'profile_parents', NULL, NULL, $sy);
            
            $this->finance_model_pisd->insertData($m_profile, 'profile', NULL, NULL, $sy);
            $this->finance_model_pisd->insertData($f_profile, 'profile', NULL, NULL, $sy);
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
            
            $this->finance_model_pisd->insertData($profile_address, 'profile_address_info','address_id',$profile->add_id, NULL, NULL, $sy);
            $this->finance_model_pisd->insertData($profile_contact, 'profile_contact_details','contact_id',$profile->contact_id, NULL, NULL, $sy);
            
            if($this->finance_model_pisd->saveStudentAdmission($admission, $profile->user_id, $sy)):
                
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
            $result = $this->finance_model_pisd->saveTransaction($details, ($school_year));
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
    
        
    public function collectionReport($from=NULL, $to=NULL, $report_type=NULL)
    {
        $settings = Modules::run('main/getSet');
        $data['ro_year'] = Modules::run('registrar/getROYear');
        $data['collection'] = $this->finance_model_lc->getCollection($from, $to, $report_type);
        $data['financeItems'] = $this->finance_model_lc->getSpecificFinanceItems();
        $data['modules'] = 'finance';
        $data['main_content'] = 'lc_sales';
        
        echo Modules::run('templates/canteen_content', $data);
    }
    
    function getItemDetails()
    {
        $st_id      = $this->post('st_id');
        $item_id    = $this->post('item_id');
        
        $student = Modules::run('registrar/getSingleStudent', $st_id, $this->session->userdata('school_year'));
        $plan= Modules::run('finance/getPlanByCourse',$student->grade_id, 0);
        $charges = Modules::run('finance/financeChargesByPlan',1, $this->session->userdata('school_year'), 0, $plan->fin_plan_id );
        //$transaction = Modules::run('finance/getTransactionByItemId', $st_id, 0, $this->session->school_year, $item_id);
        $transaction = Modules::run('finance/getTransaction', $student->uid, 0, $student->school_year);
        $payment = Modules::run('finance/getTransaction', $student->uid, 0, $student->school_year);
        foreach($payment->result() as $p):
            if($p->t_type<2):
                $totalP += $p->t_amount;
            endif;
            if($p->t_type==2):
                $totalD += $p->t_amount;
            endif;
        endforeach;
        $paymentTotal = 0;
        $totalCharge = 0;
        
        $discounts = $this->finance_model_lc->getDiscountsByItemId($st_id, 0, $student->school_year, $item_id);
        $discount = ($discounts->disc_amount>0?$discounts->disc_amount:0);
        
        $extraCharges = Modules::run('finance/getExtraFinanceCharges',$student->us_id, 0, $student->school_year, $item_id);
        $totalExtra = Modules::run('finance/getExtraFinanceCharges',$student->us_id, 0, $student->school_year);
        foreach ($totalExtra->result() as $te):
            $totalExtraCharges += $te->extra_amount;
            $extraPayment = Modules::run('finance/getTransactionByItemId', $student->uid, 0, $this->session->school_year, $te->extra_item_id);
            $totalExtraPay +=$extraPayment->row()->t_amount;
        endforeach;
        
        if($extraCharges->row()->extra_amount>0):
            $extraCharge = $extraCharges->row()->extra_amount;
            $totalCharge = $totalCharge + $extraCharge;
        else:
            $extraCharge = 0;
        endif;
        
        foreach ($charges as $c):
            $overAllCharges += $c->amount;
            if($c->item_id==$item_id):
                $totalCharge += $c->amount;
            endif;
            $payments = Modules::run('finance/billing/getTransactionByCategory', $student->uid, 0, $student->school_year, $c->category_id);
            $paymentTotal += $payments->amount;
        endforeach;
        
         
        
        
        ?>
        <tr>
            <td></td>
            <td>-</td>
            <td>Total Charge</td>
            <td>-</td>
            <td style="width:20%; text-align: right;"><?php echo number_format($totalCharge,2,'.',',') ?></td>
        </tr>
        <?php
            $i = 1;
            if($transaction->num_rows()>0):
                $balance = 0;
                foreach ($transaction->result() as $tr):
                    $i++;
                    if($tr->item_id==$item_id):
                    $desc = $tr->item_description ;
                    $totalCharge = ($totalCharge - $tr->t_amount);
                        if($tr->t_type==2):
                            ?>
                            <tr >
                                <td style="width:20%;"><?php echo $discounts->t_date ?></td>
                                <td style="width:10%;"></td>
                                <td style="width:40%;"><?php echo $tr->item_description ?></td>
                                <td style="width:20%; text-align: right;"><?php echo '( '.number_format($tr->t_amount, 2, '.',',').' )'?></td>
                                <td style="width:20%; text-align: right;"><?php echo number_format(($totalCharge), 2, '.',',')?></td>
                                <td style="width:20%; text-align: right;"><?php echo $discounts->disc_remarks ?></td>
                            </tr>
                            <?php
                        else:    
                            ?>
                                    <tr data-toggle="context" data-target="#otherMenu" onmouseover="$('#delete_trans_type').val('<?php echo $tr->t_type ?>'),$('#delete_trans_id').val('<?php echo $tr->trans_id ?>'), $('#delete_item_id').val('<?php echo $tr->t_charge_id ?>')" >
                                        <td style="width:20%;"><?php echo $tr->t_date ?></td>
                                        <td id="td_trans_<?php echo $tr->trans_id ?>" 
                                            delete_remarks="Payment Transaction voided: [Amount :<?php echo number_format($tr->t_amount, 2, '.',',') ?>, Date: <?php echo date('F d, Y', strtotime($tr->t_date)) ?>]" style="width:10%;"><?php echo $tr->ref_number ?></td>
                                        <td style="width:40%;"><?php echo $tr->item_description ?></td>
                                        <td style="width:20%; text-align: right;"><?php echo number_format($tr->t_amount, 2, '.',',')?></td>
                                        <td style="width:20%; text-align: right;"><?php echo number_format(($totalCharge), 2, '.',',')?></td>
                                        <td style="width:20%; text-align: right;"><?php echo $tr->t_remarks ?></td>
                                    </tr>
                            <?php
                    
                        endif;
                    endif;
                endforeach;
        ?>
                <tr >
                    <th colspan="4" style="width:20%; text-align: left;"><?php echo $desc ?> Balance</th>
                    
                    <th style="width:20%; text-align: right;"><?php echo number_format(($totalCharge), 2, '.',',')?></th>
                </tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr>
                    <th colspan="4" style="width:20%; text-align: left;">Outstanding Balance</th>
                    
                    <!--<th style="width:20%; text-align: right;"><?php echo number_format($totalP+$totalD, 2, '.',',')?></th>-->
                    <th style="width:20%; text-align: right;"><?php echo number_format(($overAllCharges+$totalExtraCharges)-($totalP+$totalD), 2, '.',',')?></th>
                </tr>
        <?php        
            endif;
            ?>
        <?php
    }
    
    public function getTransactionByMonth($st_id, $item_id, $month, $type = NULL)
    {
        $transaction = $this->finance_model_lc->getTransactionByMonth($st_id, $item_id, $month, $type);
        return $transaction;
    }
    
    function getSOADetails()
    {
        $data['st_id']      = $this->post('st_id');
        $data['user_id']    = $this->post('user_id');
        $student = Modules::run('registrar/getSingleStudent', $this->post('st_id'), $this->session->userdata('school_year'));
        $data['student'] = $student;
        $plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0);
        $data['charges'] = Modules::run('finance/financeChargesByPlan',0, $this->session->userdata('school_year'), 0, $plan->fin_plan_id );
        
        $this->load->view('lc_soaDetails', $data);
        
    }
    
    public function checkBilling($student, $btype=NULL)
    {
        if($student->u_id==""):
            $user_id = $student->us_id;
        else:
            $user_id = $student->u_id;
        endif;
        
        $data['user_id'] = $user_id;
        $data['plan'] = Modules::run('finance/getPlanByCourse',$student->grade_id, 0);
        $data['charges'] = Modules::run('finance/financeChargesByPlan',1, $this->session->userdata('school_year'), 0, $data['plan']->fin_plan_id );
        $data['student'] = $student;
        $data['btype'] = $btype;
        
        
        $this->load->view('lc_statementOfAccount', $data);
        
    }
    
    
    function generateBilling($grade_level, $section, $month, $offset, $limit)
    {
        $settings = Modules::run('main/getSet');
        $data['month'] = $month;
        $data['monthName'] = date('F', strtotime(date('Y').'-'.$month.'-01'));
        $data['students'] =$this->finance_model_lc->getAllStudents($limit, $offset, $grade_level, $section);
        $data['settings'] = $settings;
        
        if(file_exists(APPPATH.'modules/finance/views/reports/'. strtolower($settings->short_name).'_printBilling.php')):
            $this->load->view('finance/reports/'. strtolower($settings->short_name).'_printBilling', $data);
        else:
            $this->load->view('finance/reports/printBilling', $data);
        endif;
    }
    
    function printSOA($option, $secIn = NULL)
    {
        if($option==0):
            $data['student'] = $this->finance_model_lc->getBasicStudent( base64_decode($secIn), $this->session->school_year);
        else:
            $data['students'] = $this->finance_model_lc->getStudentPerSection($secIn, $this->session->school_year);
        endif;
        $this->load->view($option==0?'reports/pisd_printSOAIndividual':'reports/pisd_printSOASection', $data);
    }
    
  
   
   
}
