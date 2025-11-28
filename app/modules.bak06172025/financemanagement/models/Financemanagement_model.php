<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
//===========================================
// by: cyrus y. rufino 
// Canaan Software Solutions 2014
//===========================================
class financemanagement_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }

    function getMenu($position_id)
    {
        $this->db->select('*');
        $this->db->from('user_groups');
        $this->db->where('position_id', $position_id);
        $query = $this->db->get();
        return $query->row();
    }
    
    

    function school_settings()
    {
        $this->db->select('*');
        $this->db->from('settings');
        $query = $this->db->get();
        return $query->row();
    }

    function getPlanDescription($user_id)
    {
        $this->db->select('*');
        // $sy_id = 2;
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('fin_accounts', 'profile_students.st_id = fin_accounts.stud_id', 'left');
        $this->db->join('fin_plan', 'fin_plan.plan_id = fin_accounts.plan_id', 'left');
        // $this->db->where('fin_accounts.sy_id', $sy_id);
        $this->db->where('profile_students.st_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    function getPlanDescription_sy($user_id, $sy_id)
    {
        $year = Modules::run('financemanagement/yearConverter', $sy_id);
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('fin_accounts', 'profile_students.st_id = fin_accounts.stud_id', 'left');
        $this->db->join('fin_plan', 'fin_plan.plan_id = fin_accounts.plan_id', 'left');
        $this->db->where('fin_accounts.sy_id', $sy_id);
        $this->db->where('profile_students.st_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    function getstudentaccount($user_id, $sy_id)
    {
         if ($sy_id == 2){
            $sy = 2014;
        }else if ($sy_id == 3){
            $sy = 2015;
        }else if ($sy_id == 4){
            $sy = 2016;
        }else if ($sy_id == 5){
            $sy = 2017;
        }else if ($sy_id == 6){
            $sy = 2018;
        }else{
            $sy = NULL;
        }
        
        $this->db = $this->eskwela->db($sy);
        $this->db->select('*');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'profile_students_admission.section_id = section.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        if($sy==NULL):
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_admission.school_year', $sy);
        endif;
        
        $this->db->where('profile_students.st_id', $user_id);
        $query = $this->db->get();
        return $query->row();
    }

    function test_getPlanDescription()
    {
        $user_id = '20143380019';
        $sy_id = '3';
        $this->db->select('*');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('fin_accounts', 'profile_students.st_id = fin_accounts.stud_id', 'left');
        $this->db->join('fin_plan', 'fin_plan.plan_id = fin_accounts.plan_id', 'left');
        $this->db->where('fin_accounts.sy_id', $sy_id);
        $this->db->where('profile_students.st_id', $user_id);

        $query = $this->db->get();
        return $query->result();
    }
    

    function showfinHistoryPerStudent()
    {
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $this->db->join('profile_students', 'fin_transaction.stud_id = profile_students.st_id', 'left');
        // $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        // $this->db->join('fin_accounts', 'profile_students.st_id = fin_accounts.stud_id', 'left');
        $this->db->join('fin_detail','fin_transaction.trans_id = fin_detail.trans_id', 'left');
        $this->db->join('fin_items', 'fin_detail.item_id = fin_items.item_id', 'left');
        // $this->db->join('fin_department', 'fin_items.dept_id = fin_department.dept_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function showfinHistoryPerStudents($user_id, $sy_id)
    {
        $year = Modules::run('financemanagement/yearConverter', $sy_id);
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $this->db->join('profile_students', 'fin_transaction.stud_id = profile_students.st_id', 'left');
        // $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        // $this->db->join('fin_accounts', 'profile_students.st_id = fin_accounts.stud_id', 'left');
        $this->db->join('fin_detail','fin_transaction.trans_id = fin_detail.trans_id', 'left');
        $this->db->join('fin_items', 'fin_detail.item_id = fin_items.item_id', 'left');
        // $this->db->join('fin_department', 'fin_items.dept_id = fin_department.dept_id', 'left');
        $this->db->where('fin_transaction.stud_id', $user_id);
        $this->db->where('fin_transaction.sy_id', $sy_id);
        $query = $this->db->get();
        return $query->result();
    }

    function show_trans_detail($trans_id)
    {
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $this->db->join('fin_detail', 'fin_detail.trans_id = fin_transaction.trans_id', 'left');
        $this->db->join('fin_items', 'fin_items.item_id = fin_detail.item_id', 'left');

        $this->db->where('fin_transaction.trans_id', $trans_id);
        $query = $this->db->get();
        return $query->row(); 
    }

    function show_details()
    {
        $this->db->select('*');
        // $this->db->from('fin_transaction');
        $this->db->from('fin_detail');
        $this->db->join('fin_items', 'fin_items.item_id = fin_detail.item_id', 'left');
        $query = $this->db->get();
        return $query->result(); 
    }

    function show_trans_details()
    {
        $this->db->select('*');
        $this->db->from('fin_detail');
        $this->db->join('fin_transaction', 'fin_detail.trans_id = fin_transaction.trans_id', 'left');
        $this->db->join('fin_items', 'fin_items.item_id = fin_detail.item_id', 'left');
        $query = $this->db->get();
        return $query->result(); 
    }

    function showtransactiondetails()
    {
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $this->db->join('profile_students', 'fin_transaction.stud_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }


    function showfinTransaction($sy_id)
    {
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $this->db->join('fin_accounts', 'fin_transaction.stud_id = fin_accounts.stud_id', 'left');
        $this->db->join('fin_sy', 'fin_accounts.sy_id = fin_sy.sy_id', 'left');
        $this->db->where('fin_transaction.sy_id', $sy_id);
        $this->db->where('fin_accounts.sy_id', $sy_id);
        $query = $this->db->get();
        return $query->result();
    }

    function showsetsy()
    {
        $id = 1; // default school year
        $this->db->select('*');
        $this->db->from('fin_settings');
        $query = $this->db->get();
        return $query->row();
    }
    
    function showtransactions()
    {
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $query = $this->db->get();
        return $query->result();
    }

    function showtransaction($start, $end)
    {
        // $start = '08-01-2014';
        // $end = '10-23-2014';
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $this->db->where("tDate between'".$start."'and'".$end."'");
        $query = $this->db->get();
        return $query->result();
    }

    function showtransactionsy($sy_id)
    {
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $this->db->where('fin_transaction.sy_id', $sy_id);
        $query = $this->db->get();
        return $query->result();
    }

    function showgradelevel()
    {
        $this->db->select('*');   
        $this->db->from('grade_level');
        $query = $this->db->get();
        return $query->result();   
    }

    function show_account_info()
    {
        $this->db->select('*');
        $this->db->from('fin_accounts');
        $this->db->join('fin_plan', 'fin_accounts.plan_id = fin_plan.plan_id', 'left');
        $this->db->join('profile_students', 'fin_accounts.stud_id = profile_students.st_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        // $this->db->join('section', 'profile_students.section_id = section.section_id', 'left');
        // $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $query = $this->db->get();
        return $query->result();   
    }

    
    function showaccountcharges()
    {
        $charge = 0;
        $this->db->select('*');
        $this->db->from('fin_detail');
        $this->db->join('fin_transaction', 'fin_transaction.trans_id = fin_detail.trans_id', 'left');
        $this->db->join('profile_students', 'fin_transaction.stud_id = profile_students.st_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        // $this->db->join('section', 'profile_students.section_id = section.section_id', 'left');
        // $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('fin_detail.charge_credit', $charge);
        $query = $this->db->get();
        return $query->result();
    
    }


    function showaccounts()
    {
        $this->db->select('*');
        $this->db->from('fin_accounts');
        $this->db->join('fin_plan', 'fin_accounts.plan_id = fin_plan.plan_id', 'left');
        $this->db->join('profile_students', 'fin_accounts.stud_id = profile_students.st_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        // $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        // $this->db->join('section', 'profile_students.section_id = section.section_id', 'left');
        // $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $query = $this->db->get();
        return $query->result();   
    }


    function showfinAccounts()
    {
        $this->db->select('*');
        $this->db->from('fin_accounts');
        $this->db->join('fin_plan', 'fin_accounts.plan_id = fin_plan.plan_id', 'left');
        $this->db->join('profile_students', 'fin_accounts.stud_id = profile_students.st_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        // $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        // $this->db->join('section', 'profile_students.section_id = section.section_id', 'left');
        // $this->db->join('grade_level', 'section.grade_level_id= grade_level.grade_id', 'left');
        // $this->db->join('profile_parents', 'profile_students.user_id = profile_parents.user_id', 'left');

        $query = $this->db->get();
        return $query->result();
    }

    function showfinAccountz($sy_id)
    {
         if ($sy_id == 2){
            $sy = 2014;
        }else if ($sy_id == 3){
            $sy = 2015;
        }else if ($sy_id == 4){
            $sy = 2016;
        }else if ($sy_id == 5){
            $sy = 2017;
        }else if ($sy_id == 6){
            $sy = 2018;
        }

        $this->db->select('*');
        $this->db->from('fin_accounts');
        $this->db->join('fin_plan', 'fin_accounts.plan_id = fin_plan.plan_id', 'left');
        $this->db->join('profile_students', 'fin_accounts.stud_id = profile_students.st_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        // $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        // $this->db->join('section', 'profile_students.section_id = section.section_id', 'left');
        // $this->db->join('grade_level', 'section.grade_level_id= grade_level.grade_id', 'left');
        // $this->db->join('profile_parents', 'profile_students.user_id = profile_parents.user_id', 'left');
        $this->db->where('profile_students_admission.school_year', $sy);
        $this->db->where('fin_accounts.sy_id', $sy_id);
        $query = $this->db->get();
        return $query->result();
    }


    function checkfinAccounts($user_id, $year=NULL)
    {
        
        $this->db->select('*');
        $this->db->from('fin_accounts');
        $this->db->where('fin_accounts.stud_id', $user_id);
        // $this->db->where('fin_accounts.sy_id', $sy_id);
        $query = $this->db->get();
        if($query->num_rows()==0):
            if($year!=NULL):
                $this->db = $this->eskwela->db($year-1);
                $this->db->select('*');
                $this->db->from('fin_accounts');
                $this->db->where('fin_accounts.stud_id', $user_id);
                // $this->db->where('fin_accounts.sy_id', $sy_id);
                $query = $this->db->get();
            endif;
        endif;
        return $query->result();
    }

    function showfinAccount($sy_id)
    {
        if ($sy_id == 2){
            $sy = 2014;
        }else if ($sy_id == 3){
            $sy = 2015;
        }else if ($sy_id == 4){
            $sy = 2016;
        }else if ($sy_id == 5){
            $sy = 2017;
        }else if ($sy_id == 6){
            $sy = 2018;
        }
        $this->db = $this->eskwela->db($sy);
        $this->db->select('*');
        $this->db->from('fin_accounts');
        $this->db->join('fin_plan', 'fin_accounts.plan_id = fin_plan.plan_id', 'left');
        $this->db->join('profile_students', 'fin_accounts.stud_id = profile_students.st_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        // $this->db->join('section', 'profile_students.section_id = section.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id= grade_level.grade_id', 'left');
        // $this->db->join('profile_parents', 'profile_students.user_id = profile_parents.user_id', 'left');
        $this->db->where('profile_students_admission.school_year', $sy);
        $this->db->where('fin_accounts.sy_id', $sy_id);
        $query = $this->db->get();
        return $query->result();
    }

    function showfinParentAccount($sy_id, $pid)
    {
        if ($sy_id == 2014){
            $sy = 2;
        }else if ($sy_id == 2015){
            $sy = 3;
        }else if ($sy_id == 2016){
            $sy = 4;
        }else if ($sy_id == 2017){
            $sy = 5;
        }else if ($sy_id == 2018){
            $sy = 6;
        }

        $this->db->select('*');
        $this->db->from('fin_accounts');
        $this->db->join('fin_plan', 'fin_accounts.plan_id = fin_plan.plan_id', 'left');
        $this->db->join('profile_students', 'fin_accounts.stud_id = profile_students.st_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        // $this->db->join('section', 'profile_students.section_id = section.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id= grade_level.grade_id', 'left');
        // $this->db->join('profile_parents', 'profile_students.user_id = profile_parents.user_id', 'left');
        $this->db->where('profile_students_admission.school_year', $sy_id);
        $this->db->where('fin_accounts.sy_id', $sy);
        $this->db->where('profile_students.parent_id', $pid);
        $query = $this->db->get();
        return $query->result();
    }

    function get_parent_mother()
    {
     $this->db->select('*');
        $this->db->from('profile_parents');
        $this->db->join('profile', 'profile_parents.mother_id = profile.user_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $query = $this->db->get();
        return $query->result();   
    }

    function get_parent_father()
    {
     $this->db->select('*');
        $this->db->from('profile_parents');
        $this->db->join('profile', 'profile_parents.father_id = profile.user_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $query = $this->db->get();
        return $query->result();   
    }

    function show_accounts_summary()
    {
        $this->db->select('*');
        $this->db->from('fin_initial');
        $this->db->join('fin_accounts', 'fin_initial.level_id = grade_level.grade_id', 'left');
        // $this->db->join('fin_accounts', 'fin_accounts.stud_id = profile_students.user_id', 'left');
        // $this->db->join('fin_initial', 'profile_students.grade_level_id = fin_initial.level_id', 'left');
        
        // $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function show_cc()
    {
        $this->db->select('*');
        $this->db->from('fin_detail');
        $this->db->join('fin_transaction', 'fin_transaction.trans_id = fin_detail.trans_id', 'left');
        // $this->db->join('fin_accounts', 'fin_transaction.stud_id = fin_accounts.stud_id', 'left');
        // $this->db->join('profile_students', 'fin_transaction.stud_id = profile_students.user_id', 'left');
        // $this->db->join('grade_level', 'grade_level.grade_id = profile_students.grade_level_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function show_added_charge()
    {
        $this->db->select('*');
        $this->db->from('fin_extra');
        $query = $this->db->get();
        return $query->result();
    }


    function showfinInit()
    {
        $this->db->select('*');
        $this->db->from('fin_initial');
        $query = $this->db->get();
        return $query->result();
    }

    function showfinInitsy($sy_id)
    {
        $this->db->select('*');
        $this->db->from('fin_initial');
        $this->db->where('fin_initial.sy_id', $sy_id);
        $query = $this->db->get();
        return $query->result();
    }

    function showfinProfile()
    {
        $this->db->select('*');
        $this->db->from('profile_students');
        $query = $this->db->get();
        return $query->result();
    }

    function getInitPlan($eid)
    {
        $this->db->select('*');
        $this->db->from('fin_initial'); 
        $this->db->join('grade_level', 'grade_level.grade_id = fin_initial.level_id', 'left');
        $this->db->join('fin_items', 'fin_items.item_id = fin_initial.item_id', 'left');
        $this->db->join('fin_schedule', 'fin_schedule.schedule_id = fin_initial.schedule_id', 'left');
        $this->db->join('fin_sy', 'fin_sy.sy_id = fin_initial.sy_id', 'left');
        $this->db->join('fin_plan', 'fin_plan.plan_id = fin_initial.plan_id', 'left');

        $this->db->where('fin_initial.init_id', $eid);
        $query = $this->db->get();
        return $query->result();
    }

    function show_itemized_soa($user_id)
    {
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $this->db->join('fin_detail', 'fin_detail.trans_id = fin_transaction.trans_id', 'left');
        $this->db->join('fin_items', 'fin_items.item_id = fin_detail.item_id', 'left');

        $this->db->where('fin_transaction.stud_id', $user_id);
        $query = $this->db->get();
        return $query->result(); 
    }

    function show_itemized_soa_sy($user_id, $sy_id) 
    {
        // $sy_id = '1';
        // $user_id='201444120057';
        $this->db->select('*');
        $this->db->from('fin_transaction');
        $this->db->join('fin_detail', 'fin_detail.trans_id = fin_transaction.trans_id', 'left');
        $this->db->join('fin_items', 'fin_items.item_id = fin_detail.item_id', 'left');
        $this->db->where('fin_transaction.sy_id', $sy_id);
        $this->db->where('fin_transaction.stud_id', $user_id);
        $query = $this->db->get();
        return $query->result(); 
    }

    function getfinGradeLevel()
    {
        $this->db->select('*');
        $this->db->from('grade_level');
        $query = $this->db->get();
        return $query->result();
    }

    function showfinPlan()
    {
        $this->db->select('*');
        $this->db->from('fin_plan');
        $query = $this->db->get();
        return $query->result();   
    }

    function showfinFrequency()
    {
        $this->db->select('*');
        $this->db->from('fin_schedule');
        $query = $this->db->get();
        return $query->result();
    }

    function showfinSY()
    {
        $this->db->select('*');
        $this->db->from('fin_sy');
        $query = $this->db->get();
        return $query->result();
    }

    function get_sy($sy_id)
    {
        $this->db->select('*');
        $this->db->from('fin_sy');
        $this->db->where('fin_sy.sy_id', $sy_id);
        $query = $this->db->get();
        return $query->row();
    }
    // function showfinDeptCat()
    // {
    //     $this->db->select('*');    
    //     $this->db->from('fin_department');   
    //     $this->db->join('fin_category', 'fin_department.dept_id = fin_category.dept_id');
    //     $query = $this->db->get();
    //     return $query->result();
    // }
    function itemlist()
    {
        $this->db->select('*');
        $this->db->from('fin_items');
        $query = $this->db->get();
        return $query->result();
    }

    function showfinItems()
    {
        $this->db->select('*');
        $this->db->from('fin_items');
        $this->db->join('fin_department', 'fin_items.dept_id = fin_department.dept_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function showfinDept()
    {
        $this->db->select('*');
        $this->db->from('fin_department');
        $query = $this->db->get();
        return $query->result();
    }

    function editAccountPlan($data, $accounts_id)
    {
        $this->db->where('accounts_id', $accounts_id);
        $this->db->update('fin_accounts', $data);
        return;
    }

    function editplan($data, $plan_id)
    {
        $this->db->where('plan_id', $plan_id);
        $this->db->update('fin_plan', $data);
        return;
    }

    function edititems($data, $item_id)
    {
        $this->db->where('item_id', $item_id);
        $this->db->update('fin_items', $data);
        return;
    }

    function editdepartment($data, $dept_id)
    {
        $this->db->where('dept_id', $dept_id);
        $this->db->update('fin_department', $data);
        return;
    }

    function editItemPlan($items, $initID)
    {
        $this->db->where('init_id', $initID);
        $this->db->update('fin_initial', $items);
        return;
    }

    function delItemPlan($initID)
    {
        $this->db->where('init_id', $initID);
        $this->db->delete('fin_initial');

        return;
    }

    function void_transaction($vtrans_id)
    {
        $this->db->where('trans_id', $vtrans_id);
        $this->db->delete('fin_transaction');

        return;
    }

    function void_transaction_detials($void_detail_id)
    {
        $this->db->where('detail_id', $void_detail_id);
        $this->db->delete('fin_detail');
        return;
    }
    
    function showfinCateg($deptID)
    {
        $this->db->select('*');
        $this->db->from('fin_category');
        $this->db->where('fin_category.dept_id', $deptID);
        $query = $this->db->get();
        return $query->result();        
    }


    function showfinInitialPerLevel()
    {
        $year = $this->session->userdata('school_year');
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->from('fin_initial');
        $this->db->join('grade_level', 'fin_initial.level_id = grade_level.grade_id', 'left');
        $this->db->join('fin_items', 'fin_initial.item_id = fin_items.item_id', 'left');
        $this->db->join('fin_schedule', 'fin_initial.schedule_id = fin_schedule.schedule_id', 'left');
        $this->db->join('fin_sy', 'fin_initial.sy_id = fin_sy.sy_id', 'left');
        $this->db->join('fin_plan', 'fin_initial.plan_id = fin_plan.plan_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function showfinInitialperyear($sy_id)
    {
        $year = $this->session->userdata('school_year');
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->from('fin_initial');
        $this->db->join('grade_level', 'fin_initial.level_id = grade_level.grade_id', 'left');
        $this->db->join('fin_items', 'fin_initial.item_id = fin_items.item_id', 'left');
        $this->db->join('fin_schedule', 'fin_initial.schedule_id = fin_schedule.schedule_id', 'left');
        $this->db->join('fin_sy', 'fin_initial.sy_id = fin_sy.sy_id', 'left');
        $this->db->join('fin_plan', 'fin_initial.plan_id = fin_plan.plan_id', 'left');
        $this->db->where('fin_initial.sy_id', $sy_id);
        $query = $this->db->get();
        return $query->result();
    }

    function saveAccountPlan($stud_id, $plan_id, $sy_id)
    {
        $data = array(
            'stud_id' => $stud_id,
            'plan_id' => $plan_id,
            'sy_id' => $sy_id,
        );
        $this->db->insert('fin_accounts', $data);

        return $this->db->insert_id();

    }

    function saveRecalc($stud_id, $sy_id, $balance)
    {
        $data = array(
            'stud_id' => $stud_id,
            'sy_id' => $sy_id,
            'balance' => $balance,
        );
        $this->db->insert('fin_account_summary', $data);

        return $this->db->insert_id();
    }


    function saveLogs($logDate, $logaccount, $logremarks)
    {
        $data = array(
            'date_time' => $logDate,
            'account_id' => $logaccount,
            'remarks' => $logremarks,
        );
        $this->db->insert('fin_logs', $data);

        return $this->db->insert_id();

    }

    function saveAddCharge($ac_transID, $ac_itemID, $ac_amount, $ac_cc, $sy_id)
    {
        $data = array(
            'trans_id' => $ac_transID,
            'item_id' => $ac_itemID,
            'd_charge' => $ac_amount,
            'charge_credit'  => $ac_cc,
            'sy_id' => $sy_id,
        );
        $this->db->insert('fin_detail', $data);

        return $this->db->insert_id();
    }

    function savefinPlan($plan_desc)
    {
        $data = array(
            'plan_description' => $plan_desc,
        );
        $this->db->insert('fin_plan', $data);
    }

    function saveNewDepartment($dept_name)
    {
        $data = array(
            'dept_description' => $dept_name,
        );
        $this->db->insert('fin_department', $data);

        return $this->db->insert_id();
    }

    function savePayTransaction($trans_ID, $ref_number, $stud_id, $tdate, $tcashier, $tcharges, $tcredits, $tremarks, $sy_id)
    {

      $data = array(
            'trans_id' => $trans_ID, 
            'ref_number' => $ref_number,
            'stud_id' => $stud_id,
            'tdate' => $tdate,
            'cashier_id' => $tcashier,
            'tcharge' => $tcharges,
            'tcredit' => $tcredits,
            'tremarks' => $tremarks,            
            'sy_id' => $sy_id,
        );
      
        $this->db->insert('fin_transaction', $data);

        return $this->db->insert_id();

    }

    function save_extra_charge($stud_id, $ac_itemID, $ac_amount)
    {

        $data = array(
            'stud_id' => $stud_id,
            'item_id' => $ac_itemID,
            'amount' => $ac_amount,
        );

        $this->db->insert('fin_extra', $data);

        return $this->db->insert_id();
    }

    function saveNewItem($item_description, $dept_id)
    {
        $data = array(
            'item_description' => $item_description,
            'dept_id' => $dept_id,
        );
        $this->db->insert('fin_items', $data);

        return $this->db->insert_id();
    }

    function saveFinInitial($level_id, $item_id, $item_amount, $sched_id, $sy_id, $imp_date, $ch_cr, $it_plan)
    {
        $data = array(
            'level_id' => $level_id, 
            'item_id' => $item_id, 
            'item_amount' => $item_amount, 
            'schedule_id' => $sched_id, 
            'sy_id' => $sy_id, 
            'implement_date' => $imp_date, 
            'ch_cr' => $ch_cr,
            'plan_id' => $it_plan,
        );
        $this->db->insert('fin_initial', $data);

        return $this->db->insert_id();
    }

    function saveTransactionDetail($detail_transID, $item_ID, $fin_amount, $charge_credit, $sy_id)
    {
        $data = array(
            'trans_id' => $detail_transID,
            'item_id' => $item_ID,
            'd_credit' => $fin_amount,
            'charge_credit' => $charge_credit,
            'sy_id' => $sy_id,
        );
        $this->db->insert('fin_detail', $data);
        return $this->db->insert_id();
    }

    function show_fin_extra($user_id)
    {
        $this->db->select('*');
        $this->db->select('SUM(d_charge) as total_charge');
        $this->db->select('SUM(d_credit) as total_credit');
        $this->db->from('fin_detail');
        $this->db->join('fin_transaction', 'fin_detail.trans_id = fin_transaction.trans_id', 'left');
        // $this->db->join('fin_extra', 'fin_detail.item_id = fin_extra.item_id', 'left');
        $this->db->join('fin_items', 'fin_detail.item_id = fin_items.item_id', 'left');
        $this->db->group_by('fin_items.item_id');
        $this->db->where('fin_transaction.stud_id', $user_id);        
        $query = $this->db->get();
        return $query->result();
    }

    function show_fin_extra_sy($user_id, $sy_id) 
    {
        $year = Modules::run('financemanagement/yearConverter', $sy_id);
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('SUM(d_charge) as total_charge');
        $this->db->select('SUM(d_credit) as total_credit');
        $this->db->from('fin_detail');
        $this->db->join('fin_transaction', 'fin_detail.trans_id = fin_transaction.trans_id', 'left');
        // $this->db->join('fin_extra', 'fin_detail.item_id = fin_extra.item_id', 'left');
        $this->db->join('fin_items', 'fin_detail.item_id = fin_items.item_id', 'left');
        $this->db->group_by('fin_items.item_id');
        $this->db->where('fin_transaction.stud_id', $user_id);        
        $this->db->where('fin_transaction.sy_id', $sy_id);  
        $query = $this->db->get();
        return $query->result();
    }


    function test()
    {
        $this->db->select('*');
        $this->db->select('SUM(amount) as tot_amount');
        $this->db->from('fin_extra');        
        // $this->db->join('fin_items', 'fin_extra.item_id = fin_items.item_id', 'left');
        $this->db->group_by('fin_items.item_id');
        $query = $this->db->get();
        return $query->result();
    }


    function showFinExtra()
    {
        // $this->db->select('fin_transaction.stud_id', 'fin_transaction.trans_id', 'fin_detail.item_id', 'fin_detail.d_charge', 'fin_detail.d_credit', 'fin_details.sy_id', 'fin_items.item_description');
        $this->db->select('*');
        $this->db->select('SUM(d_charge) as total_charge');
        $this->db->select('SUM(d_credit) as total_credit');
        $this->db->from('fin_detail');
        $this->db->join('fin_transaction', 'fin_detail.trans_id = fin_transaction.trans_id', 'left');
        // $this->db->join('fin_extra', 'fin_detail.item_id = fin_extra.item_id', 'left');
        $this->db->join('fin_items', 'fin_detail.item_id = fin_items.item_id', 'left');
        $this->db->group_by('fin_detail.item_id','fin_transaction.stud_id');
        $query = $this->db->get();
        return $query->result();
    }
     
    function show_extra()
    {
        $this->db->select('*');
        $this->db->select('SUM(d_charge) as total_charge');
        $this->db->select('SUM(d_credit) as total_credit');
        $this->db->from('fin_detail');
        $this->db->join('fin_transaction', 'fin_detail.trans_id = fin_transaction.trans_id', 'left');
        $this->db->join('fin_items', 'fin_detail.item_id = fin_items.item_id', 'left');
        $this->db->group_by('fin_items.item_id');

        $query = $this->db->get();
        return $query->result();
    }    

    function saveTransactionDiscount($trans_id, $discount_amount)
    {
        $discount = array(
            'trans_id' => $trans_id,
            'discount_amount' => $discount_amount,
        );
        $this->db->insert('fin_discount', $discount);

        return $this->db->insert_id();
    }

    function saveTransaction($trans_id, $ref_number, $sysgen_ref, $stud_id, $fdate, $cashier_id, $fdebit, $fcredit)
    {
        $data = array(
            'fin_trans_id' => $trans_id,
            'fin_ref_number' => $ref_number,
            'fin_sysgen_ref' => $sysgen_ref,
            'fin_stud_id' => $stud_id,
            'fin_date' => $fdate,
            'fin_cashier_id' => $cashier_id,
            'fin_debit' => $fdebit,
            'fin_credit' => $fcredit,
        );

    }    
}

?>