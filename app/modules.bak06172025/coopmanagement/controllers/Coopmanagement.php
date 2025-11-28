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
class Coopmanagement extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('coopmanagement_model');
        $this->load->library('pdf');
        if(!$this->session->has_userdata('is_logged_in') || !$this->session->is_logged_in){
            header('Location: '.base_url());
            exit;
        }
        set_time_limit(300);
        
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
    
    function importShareCapForm()
    {
        $data['modules'] = 'coopmanagement';
        $data['main_content'] = 'fileUploadForm';
        echo Modules::run('templates/main_content', $data);
    }
    
    function importFileData()
    {
        //load library phpExcel
        $this->load->library("excel");
        //here i used microsoft excel 2007
        $data['error'] = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads';
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = '*';
        $config['max_size'] = '10000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {

            $file_data = $this->upload->data();
            $file_path = 'uploads/' . $file_data['file_name'];
            switch ($file_data['file_ext']):
                case '.xls':
                case '.XLS':
                    $objReader = PHPExcel_IOFactory::createReader('Excel5');
                    break;
                case '.xlsx':
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                    break;
            endswitch;
            //set to read only
            $objReader->setReadDataOnly(true);
            //load excel file
            $objPHPExcel = $objReader->load($file_path);

            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $transactionType = $this->post('typeOfFile');

            $num_rows = $objWorksheet->getHighestRow();
            //$num_rows = 5;
            $i = 1;
            ?>

            <?php
            $added = 0;
            for ($st = 2; $st <= ($num_rows); $st++) {
                
                $fullname = $objWorksheet->getCellByColumnAndRow(1, $st)->getValue();
                $fullNameItems = explode(',', $fullname);
                
                $lastname = $fullNameItems[0];
                $firstname = $fullNameItems[1];
                
                $numWords = str_word_count($firstname);
                
                if($numWords >= 2):
                    $lastWord = strrchr($firstname, ' ');
                    if(strlen(trim($lastWord))==1):
                        $firstname = str_replace($lastWord, '', $firstname);
                    else:
                        $firstname = $firstname;
                    endif;
                endif;
                
                $exist = $this->coopmanagement_model->nameCheck(trim($lastname), trim($firstname));
                
                if($transactionType==0):
                    $share = $objWorksheet->getCellByColumnAndRow(3, $st)->getValue();
                    if($exist):
                        $added++;
                        $this->saveCoopTransaction($exist->cad_profile_id, $exist->cad_account_no, 'SCD-'.date('ymdgis'), 2, $share, '', 1, '', '');
                        $this->updateAccountInfo('cad_share_capital', $share, $exist->cad_account_no);
                    else:
                        $notRegistered = array('fullname' => $fullname, 'from_type' => 'Share Capital Update');
                        $this->coopmanagement_model->notRegistered($notRegistered);
                    endif;
                else:
                    if($exist):
                        $added++;
                        $principal = $objWorksheet->getCellByColumnAndRow(5, $st)->getValue();
                        $terms = $objWorksheet->getCellByColumnAndRow(3, $st)->getValue();
                        $dateApplied = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(2,$st)->getValue()));
                        $maturityDate = date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(4,$st)->getValue()));
                        $loanType = $objWorksheet->getCellByColumnAndRow(12, $st)->getValue();
                        
                        
                        Modules::run('coopmanagement/loans/calculateAmortization',$exist->cad_profile_id, $exist->cad_account_no, $principal, $terms, $loanType, $dateApplied, $maturityDate);
                    else:
                        $notRegistered = array('fullname' => $fullname, 'from_type' => 'Loan List Update');
                        $this->coopmanagement_model->notRegistered($notRegistered);
                    endif;
                endif;    
                
                unset($lastWord);
            }
            echo 'There are '.$added.' added records to the system';
            
        }

    }
    
    function getAccountInfoByUserId($user_id)
    {
        $accountInfo = $this->coopmanagement_model->getAccountInfoByUserId($user_id);
        return $accountInfo;
    }
    
    function searchCoMaker($value)
    {
        $members = $this->coopmanagement_model->searchMembers($value);
        echo '<ul>';
        foreach ($members as $s):
        ?>
            <li style="font-size:18px;" onclick="$('#searchCoName').hide(), $('#searchCoMaker').val('<?php echo $s->firstname.' '.$s->lastname ?>'), $('#comakerNames').val('<?php echo $s->firstname.' '.$s->lastname ?>'), ($('#comakerID_1').val()==''?$('#comakerID_1').val('<?php echo $s->cad_account_no ?>'):$('#comakerID_2').val('<?php echo $s->cad_account_no ?>'))" ><?php echo strtoupper($s->lastname.', '.$s->firstname) ?></li>   
        <?php        
        endforeach;
        echo '</ul>';
    }
    
    public function updateAccountInfo($column, $value, $accountNumber)
    {
        if($this->coopmanagement_model->updateAccountInfo($column, $value, $accountNumber)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    public function saveTransaction()
    {
        $items              = $this->post('items');
        $loanReferenceNumber= $this->post('loanReferenceNumber');
        $profile_id         = $this->post('profile_id');
        $accountNumber      = $this->post('accountNumber');
        $payType            = $this->post('payType');
        $cheque             = $this->post('cheque');
        $bank               = $this->post('bank');
        $remarks            = $this->post('t_remarks');
        $or_number          = $this->post('or_num');       
        
        
        $count = count(json_decode($items));
        $final = json_decode($items);
        
        $success = 0;
        for ($x = 0; $x < $count; $x++) {
            $item = explode('_', $final[$x]);
            
            $trans      = $item[2];
            $amount     = $item[1];
            $transType  = $item[0];
            $gl_type    = 1;
            
            $transaction = $this->saveCoopTransaction($profile_id, $accountNumber, $trans, $transType, $amount, $loanReferenceNumber, $gl_type, $payType, $bank, $cheque, $remarks, $or_number);
            
            if(!$transaction):
            else:
                switch ($item[0]):
                    case 1:
                        $column = 'cad_savings';
                        $value = $amount;
                        $this->updateAccountInfo($column, $value, $accountNumber);
                    break;    
                    case 2:    
                        $column = 'cad_share_capital';
                        $value = $amount;
                        $this->updateAccountInfo($column, $value, $accountNumber);
                        
                    break;    
                    case 3:
                        $amortization = Modules::run('coopmanagement/loans/getAmortizationTable', $loanReferenceNumber);
                        $weeklyAmort = Modules::run('coopmanagement/loans/getLoanDetails', $loanReferenceNumber);
                        $loanPayment = $amount;
                        foreach($amortization as $amort):
                            if($amort->lad_status==0):
                                if($loanPayment < $weeklyAmort->ld_weekly_amortization):
                                    $loanPaymentDetails = array(
                                        'lad_status'    => 0,
                                        'lad_payment'   => $transaction
                                    );

                                    $this->coopmanagement_model->updateLoanAmortization($loanPaymentDetails, $amort->lad_id);
                                    if($this->post('is_overide')!=1):
                                        $interestPerWeek = ($weeklyAmort->ld_principal_amount * $weeklyAmort->clt_interest) * ($weeklyAmort->ld_terms) / ($weeklyAmort->ld_terms * 4);
                                        $interestPayment = $interestPerWeek;
                                        $remainingBalance = $loanPayment - $interestPayment;

                                        $this->updateCoopTransaction($transaction, $remainingBalance, $interestPayment);
                                    endif;
                                    
                                    break 1;
                                else:
                                    $loanPayment = $loanPayment - $weeklyAmort->ld_weekly_amortization;
                                    $loanPaymentDetails = array(
                                        'lad_status'    => 1,
                                        'lad_payment'   => $transaction
                                    );

                                    $this->coopmanagement_model->updateLoanAmortization($loanPaymentDetails, $amort->lad_id);
                                endif;
                            endif;    

                        endforeach;
                    break;    
                endswitch;
            $success++;     
            endif;          
        }
        if($success==$count):
             echo 'Successfully Saved';
        endif;
        //print_r($transaction);
    }
    
    public function updateCoopTransaction($trans_id, $remainingBalance, $interest)
    {
        $this->coopmanagement_model->updateCoopTransaction($trans_id, $remainingBalance, $interest);
        return;
    }
    
    public function saveCoopTransaction($profile_id, $accountNumber, $trans, $transType, $amount, $loanReferenceNumber, $gl_type,$payType, $bank=0, $cheque=NULL, $remarks=NULL, $or_number=NULL)
    {
        $details = array(
            'cft_profile_id'    => $profile_id,
            'cft_account_no'    => $accountNumber,
            'cft_trans_num'     => $trans,
            'cft_or_number'     => $or_number,
            'cft_trans_amount'  => $amount,
            'cft_lrn'           => $loanReferenceNumber,
            'cft_trans_type'    => $transType,
            'cft_gl_type'       => $gl_type,
            'cft_trans_date'    => date('Y-m-d g:i:s'),
            'cft_remarks'       => $remarks,
            'cft_payment_type'  => $payType,
            'cft_bank_id'       => $bank,
            'cft_cheque_num'    => $cheque,
            'cft_teller_id'     => $this->session->employee_id
        );
        
        $transactionResult = $this->coopmanagement_model->saveCoopTransaction($details);
        
        return $transactionResult;
    }
    
    public function loadReferenceNumber()
    {
        echo date('ymdgis');
    }
    
    public function index()
    {
        $data['modules'] = 'coopmanagement';
        $data['main_content'] = 'default';
        echo Modules::run('templates/main_content', $data);
    }
    
    public function getTransactionType()
    {
        $transaction = $this->coopmanagement_model->getTransactionType();
        return $transaction;
    }
    
    public function membersProfile($id=NULL)
    {
        $data['id'] = base64_decode($id);
        $this->load->view('profileInfo', $data);
    }


    public function members($id=NULL)
    {
        $data['id'] = $id;
        $data['modules'] = 'coopmanagement';
        $data['main_content'] = 'profileManagement';
        echo Modules::run('templates/main_content', $data); 
    }
    
    public function getTotalMembers($shareCap=NULL, $option=NULL)
    {
        $members = $this->coopmanagement_model->getTotalMembers($shareCap,$option);
        return $members;
    }
    
    public function addCreditCommittee()
    {
        $user_id = $this->post('user_id');
        $is_credit_comittee = $this->post('is_credit_comittee');
        
        $details = array(
            'is_approver' => $is_credit_comittee,
        );
        
        if($this->coopmanagement_model->addCreditCommittee($details, $user_id)):
            echo 'Successfully Added';
        else:
            echo 'Something went Wrong';
        endif;
    }
    
    public function personToReview()
    {
        $person = $this->coopmanagement_model->personToReview();
        return $person;
        
    }
    
    
    public function decodeAccount($accountNumber)
    {
        $account = str_split($accountNumber, 4);
        $accountNum = $account[0].' '.$account[1].' '.$account[2].' '.$account[3];
        
        return $accountNum;
         
    }
    
    function getAccountInfoByAccountNumber($accountNumber)
    {
        
        $basicInfo = $this->coopmanagement_model->getAccountInfoByAccountNumber($accountNumber);
        return $basicInfo;
    }
    
    function getAccountInfo($user_id)
    {
        
        $basicInfo = $this->coopmanagement_model->getBasicInfo($user_id);
        return $basicInfo;
    }
    
    function ifAccountExist($user_id)
    {
        $exist = $this->coopmanagement_model->ifAccountExist($user_id);
        return $exist;
    }
    
    public function addAccountDetails($user_id)
    {
        $basicInfo = $this->coopmanagement_model->getBasicInfo($user_id);
        
        $yearRegistered = strrev(date('Y', strtotime($basicInfo->date_hired)));
        $monthday = date('md', strtotime($basicInfo->date_hired));
        if($user_id<10):
            $userid = '000'.$user_id;
        elseif($user_id>=10&&$user_id<100):
            $userid = '00'.$user_id;
        elseif($user_id>=100&&$user_id<1000):
            $userid = '0'.$user_id;
        elseif($user_id>=1000&&$user_id<10000):
            $userid = $user_id;
        else:
            $userid = $user_id;
        endif;
        
        $accountNumber = '1102'.$yearRegistered.$monthday.$userid;
        
        $accountDetails = array(
            'cad_profile_id'    => $user_id,
            'cad_account_no'    => $accountNumber
        );
        
        $success = $this->coopmanagement_model->addAccountDetails($accountDetails, $user_id);
        if($success):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    
    function searchMembers($value)
    {
        $members = $this->coopmanagement_model->searchMembers($value);
        echo '<ul>';
        foreach ($members as $s):
        ?>
                <li style="font-size:18px;" onclick="$('#searchName').hide(), $('#searchBox').val('<?php echo $s->firstname.' '.$s->lastname ?>'), $('#coop_account_user_id').val('<?php echo $s->user_id ?>'), $('#is_credit_comittee').val('1')" ><?php echo strtoupper($s->lastname.', '.$s->firstname) ?></li>   
        <?php        
        endforeach;
        echo '</ul>';
    }
    
    function generateAccount()
    {
        $employees = Modules::run('hr/getEmployees');
        $added = 0;
        foreach($employees->result() as $emp):
            if($this->addAccountDetails($emp->user_id)):
                $added++;
            endif;
        endforeach;
        
        echo 'Successfully Added '+$added+' Accounts';
    }
    
    function getImportedAmortizationDate($d, $a)
    {
        $todate = date('Y-m-d', strtotime("+$a week",strtotime($d)));
            
        $date = new DateTime($todate);
        $date->modify('next Saturday');
        return $date;
    }
    
    function getAmortizationDate($d, $a)
    {
        $todate = date('Y-m-d', strtotime("+$a week",strtotime($d)));
            
        $date = new DateTime($todate);
        $date->modify('next Saturday');
        return $date;
    }
    
}
