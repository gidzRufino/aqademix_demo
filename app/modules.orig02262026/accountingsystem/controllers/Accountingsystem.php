<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of scanController
 *
 * @author genesis
 */
class accountingsystem extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('accountingsystem_model');
    	
    }
    
    function index()
    {
        $data['asTransactions'] = $this->getASTransaction();
        $data['cashEquivalents'] = $this->getAccountTitlesById(5);
        $data['category'] = $this->getCategory();
        $data['mainCat']    = $this->getCategory('0');
        $data['accountTitles'] = $this->getAccountTitles();
        $data['modules'] = 'accountingsystem';
        $data['main_content'] = 'default';
        echo Modules::run('templates/canteen_content', $data);
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }
    
    function deleteASTrans()
    {
        $je_num = $this->post('je_num');
        if($this->accountingsystem_model->deleteASTrans($je_num)):
           echo 'Successfully Deleted';
        else:
           echo 'Sorry Something went Wrong';
        endif;
    }
    
    function getTransactionByDate($startDate, $endDate)
    {
        $data['dateFrom'] = $startDate;
        $data['dateTo'] = $endDate;
        $data['asTransactions'] = $this->accountingsystem_model->getTransactionByDate($startDate, $endDate);
        $this->load->view('je_details', $data);
    }
    
    function getTransactionPerType($type)
    {
        $transaction = $this->accountingsystem_model->getTransactionPerType($type);
        return $transaction;
    }
    
    function getASTransaction()
    {
        $transaction = $this->accountingsystem_model->getASTransaction();
        return $transaction;
    }
    
    function saveASTransaction()
    {
        $count = count(json_decode($this->post('items')));
        $final = json_decode($this->post('items'));
        $column = array();
        
        for ($x = 0; $x < $count; $x++) {
            
            $items = explode('_', $final[$x]);
            
            $details = array(
                'as_coa_id'             => $items[0],
                'as_je_num'             => $this->post('je'),
                'as_trans_description'  => $this->post('desc'),
                'as_trans_date'         => $this->post('transDate'),
                'as_trans_amount'       => $items[1],
                'as_trans_type'         => $items[2]
            );
            
            array_push($column, $details);
        }
        
        if($this->accountingsystem_model->saveASTransaction($column)):
            echo json_encode(array('status' => TRUE));
        else:
            echo json_encode(array('status' => FALSE));
        endif;
    }
    
    function saveExpense()
    {
        $exp_date = $this->post('exp_date');
        $particulars = $this->post('exp_particulars');
        $accountTitle = $this->post('exp_account_title');
        $bank = $this->post('exp_account_bank');
        $amount = $this->post('exp_amount');
        
        $details = array(
            'exp_date'          => $exp_date,
            'exp_particulars'   => $particulars,
            'exp_account_title' => $accountTitle,
            'exp_bank'          => $bank,
            'exp_amount'        => $amount,
            'exp_trans_code'    => date('ymdgis')
        );
        
        if($this->accountingsystem_model->saveExpense($details)):
            echo 'Successfully Saved';
        else:
            echo 'Sorry Something Went Wrong';
        endif;
    }
            
    function getAccountTitlesByID($id)
    {
        $accounts = $this->accountingsystem_model->getAccountTitlesByID($id);
        return $accounts;
    }
    
    function savePurchaseRequest()
    {
        $dateRequested = $this->post('pr_date');
        $dateNeeded = $this->post('pr_date_needed');
        $pr_request_by = $this->post('pr_request_by');
        $pr_requestingDepartment = $this->post('pr_requestingDepartment');
        $data = $this->post('data');
        $count = count(json_decode($data));
        $final = json_decode($data);
        $column = array();
        $transCode = date('Ymdgis');
        
        for ($x = 0; $x < $count; $x++):
            $items = explode('_', $final[$x]);
        
            $details = array(
                'as_item'       => $items[0],
                'as_item_desc'  => $items[1]
            );
            
            $item_id = $this->accountingsystem_model->saveItems($details, $items[0]);
            
            $arrayPushDetails = array(
                'pr_item_id'    => $item_id,
                'pr_quantity'   => $items[2],
                'amount'        => $items[3],
                'pr_trans_code' => $transCode,
                'pr_request_by' => $pr_request_by,
                'pr_department' => $pr_requestingDepartment,
                'pr_date_requested' => $dateRequested,
                'pr_date_needed'    => $dateNeeded    
            );
            
            
            array_push($column, $arrayPushDetails);
            
        endfor;
        
        $success = $this->accountingsystem_model->savePRTransactions($column);
        if($success):
            echo 'Purchase Request Successfully Submitted';
        else:
            echo 'Sorry Something went wrong';
        endif;
            
        
    }
    
    function fetchExpense($coa_id)
    {
        $expense = $this->accountingsystem_model->fetchExpense($coa_id);
        return $expense;
    }
    
    function createJournalEntry($coa_id, $description, $amount, $type, $date = NULL)
    {
        $details = array(
            'as_coa_id'     => $coa_id,
            'as_je_num'     => 1,
            'as_trans_description' => $description,
            'as_trans_date' => ($date==NULL?date('Y-m-d'):$date),
            'as_trans_amount'   => $amount,
            'as_trans_type'     => $type
        );
        
        $this->accountingsystem_model->createJournalEntry($details);
        return;
    }
    
    function showCatInReport()
    {
        $id = $this->post('id');
        $value = $this->post('value');
        $array = array('cat_show' => $value);
        if($this->accountingsystem_model->showCatInReport($id, $array)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function showInReport()
    {
        $id = $this->post('id');
        $value = $this->post('value');
        $column = $this->post('column');
        $array = array($column => $value);
        if($this->accountingsystem_model->showInReport($id, $array)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function fetchRevenueByAccount($account_id, $school_year)
    {
        $revenue = Modules::run('finance/generateCollectiblesByASItem', $account_id, $school_year);
//        foreach ($revenue->result() as $r):
//            echo $r->t_amount.'<br />';
//        endforeach;
        return $revenue;
    }
    
    function fetchRevenue($account_id, $school_year)
    {
        $revenue = $this->accountingsystem_model->fetchRevenue($account_id, $school_year);
//        foreach ($revenue->result() as $r):
//            echo $r->t_amount.'<br />';
//        endforeach;
        return $revenue;
    }
    
    function getCategoryByParent($parent_id)
    {
        $categories = $this->accountingsystem_model->getCategoryByParent($parent_id);
        return $categories;
    }
    
    function reports($school_year=NULL)
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $data['school_year'] = ($school_year==NULL?$this->session->school_year:$school_year);
        $data['ro_year'] = Modules::run('college/getROYear');
        $data['settings'] = Modules::run('main/getSet');
        $data['modules'] = 'accountingsystem';
        if(file_exists(APPPATH.'modules/accountingsystem/views/'. strtolower($settings->short_name).'_reports.php')):
            $data['main_content'] = strtolower($settings->short_name).'_reports.php';
        else:    
            $data['main_content'] = 'reports';
        endif;
        echo Modules::run('templates/canteen_content', $data);
    }
    
    function getAccountTitleById($id)
    {
        $id = $this->accountingsystem_model->getAccountTitleById($id);
        return $id;
    }
            
    function editPayrollItems()
    {
        $accountTitle = $this->post('accountTitle');
        $debitTo = $this->post('debitTo');
        $creditTo = $this->post('creditTo');
        $item= $this->post('payItemId');
        
        $details = array(
            'pp_debit_to'  => $debitTo,
            'pp_credit_to' => $creditTo,
            'pp_act_to' => $accountTitle
        );
        
        $success = $this->accountingsystem_model->editPayrollItems($item, $details);
        if($success):
            echo 'Successfully Updated';
        else:
            echo 'Something went Wrong';
        endif;
        
    }
            
    function editFinanceItems()
    {
        $accountTitle = $this->post('accountTitle');
        $debitTo = $this->post('debitTo');
        $creditTo = $this->post('creditTo');
        $item= $this->post('finItemId');
        
        $details = array(
            'debit_to'  => $debitTo,
            'credit_to' => $creditTo,
            'as_account_id' => $accountTitle
        );
        
        $success = $this->accountingsystem_model->editFinanceItems($item, $details);
        if($success):
            echo 'Successfully Updated';
        else:
            echo 'Something went Wrong';
        endif;
        
    }
    
    function settings()
    {   
        $this->load->library('pagination');
        $base_url = base_url('accountingsystem/settings/');
        $result = $this->accountingsystem_model->getAccountTitles(NULL, NULL, NULL);
        $config['base_url'] = $base_url;
        $config['total_rows'] = $result->num_rows();
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
       // echo $config['per_page'];
        $page = $this->accountingsystem_model->getAccountTitles(NULL, $config['per_page'], $this->uri->segment(3));
        $data['accountTitles'] = $page->result();
        
        $data['employees'] = $this->accountingsystem_model->getEmployees();
        $data['titles'] = $this->getAccountTitles();
        $data['finItems'] = Modules::run('finance/getFinanceItems');
        $data['category'] = $this->getCategory();
        $data['mainCat']    = $this->getCategory('0');
        $data['modules'] = 'accountingsystem';
        $data['main_content'] = 'settings';
        echo Modules::run('templates/canteen_content', $data);
    }
    
    function getAccountTitles($cat_id=NULL)
    {
        $accountTitles = $this->accountingsystem_model->getAccountTitles($cat_id,NULL, NULL);
        return $accountTitles->result();
    }
    
    function addAccount()
    {
        $accountCode = $this->post('code');
        $accountName = $this->post('account');
        $category = $this->post('category');
        $accountType = $this->post('accountType');
        $details = array(
            'coa_code'      => $accountCode,
            'coa_name'      => $accountName,
            'coa_cat_id'    => $category,
            'account_type'  => $accountType
        );
        
        $result = $this->accountingsystem_model->addAccount($details);
        if($result->status):
            echo json_encode(array('status'=>TRUE, 'id' => $result->id));
        else:
            echo json_encode(array('status'=>FALSE));
        endif;
    }
    
    function getCategory($cat_id = NULL)
    {
        $category = $this->accountingsystem_model->getCategory($cat_id);
        return $category;
    }
    
    
    function addCategory()
    {
        $cat = $this->post('category');
        $parentCat = $this->post('parent');
        if($parentCat!=0):
            $hasChild = 1;
        else:
            $hasChild = 0;
        endif;
        
        $details = array(
           'cat_name'       => $cat,
           'cat_parent_id'  => $parentCat,
        );
        
        $result = $this->accountingsystem_model->addCategory($details);
        
        if($result->status):
            echo json_encode(array('status'=>TRUE, 'id' => $result->id));
        else:
            echo json_encode(array('status'=>FALSE));
        endif;
    }
    
}
