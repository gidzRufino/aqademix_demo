<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of schedule_model
 *
 * @author genesis
 */
class Finance_model_lc extends CI_Model {
    //put your code here
    

    function getSpecificFinanceItems()// lifeCollege
    {
        $this->db->where('item_id between 1 and 4 ');
        $this->db->order_by('item_id', 'ASC');
        $q = $this->db->get('c_finance_items');
        return $q->result();
    }    
    
    function hasCollectionPerItem($account_id,$from, $to, $item_id)
    {
        $this->db->select('t_type');
        $this->db->select('ref_number');
        $this->db->select('t_charge_id');
        $this->db->select('t_amount');
        $this->db->join('profile_students', 'c_finance_transactions.t_st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        if($account_id!=NULL):
            $this->db->where('t_st_id', $account_id);
        endif;
        $this->db->where("t_date between'".($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
        $this->db->where('t_charge_id', $item_id);
        $this->db->where('t_type <=', 1);
        $this->db->where('t_receipt_type', 0);
        $this->db->group_by('ref_number');
        $q = $this->db->get('c_finance_transactions');
        if($q->num_rows()>0):
            return $q->row();
        else:
            return FALSE;
        endif;
    }
    
    function getCollection($from, $to, $report_type, $sum = NULL)
    {
        if($sum):
            $this->db->select('*');
            $this->db->select('t_amount');
        endif;
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->join('profile_students', 'c_finance_transactions.t_st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->where("t_date between'".($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
        if($report_type!=NULL):
            switch ($report_type):
                case 1:
                    $this->db->where('item_id', 1);
                break;
                case 2:
                    $this->db->where('item_id between 2 and 4 ');
                break;
                case 3:
                    $this->db->where('t_receipt_type', 1);
                break; 
                default:
                    $this->db->where('t_receipt_type', 0);
                break;    
            endswitch;
        else:
            $this->db->where('t_receipt_type', 0);
        endif;    
        $this->db->where('t_type <=', 1);
        $this->db->group_by('ref_number');
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function getDiscountsByItemId($st_id, $sem, $school_year, $item_id)
    {
        $this->db->where('disc_st_id', $st_id);
        $this->db->where('disc_school_year', $school_year);
        ($item_id==NULL?"":$this->db->where('disc_item_id', $item_id));
        $this->db->join('c_finance_items', 'c_finance_discounts.disc_item_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_discounts');
        return $q->row();
    }
    
    function getTransactionByMonth($st_id, $item_id, $month, $type)
    {
        if($month > 12):
            $year = date('Y')+1;
            $month = $month - 12;
        else:
            $year = date('Y');
        endif;
        if($month < 10):
            $month = '0'.$month;
        endif;
        
        
        $this->db->select('SUM(t_amount) as amount');
        $this->db->where('t_st_id', $st_id);
        $this->db->where('c_finance_items.item_id', $item_id);
        $this->db->where('t_type', ($type==NULL?0:$type));
        $this->db->where("t_date between'".date($year.'-'.$month.'-01') . "' and'" . date($year.'-'.$month.'-31') . "'");
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_transactions');
        return $q->row();
    }
    function getAllStudents($limit, $offset, $grade_id, $section, $year=NULL)
    {
        //$this->db->cache_on();
        if($year==NULL):
            $year = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students_admission.status as stats');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->select('profile.user_id as u_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','inner');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students_admission.school_year', $year);
        
        if($grade_id!=Null && $grade_id!=0){
            $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        }
        if($section!=Null){
            $this->db->where('profile_students_admission.section_id', $section);
        }
        $this->db->where('account_type', 5);
        $this->db->where('profile_students_admission.status', 1);
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        //

        if($limit!=""||$offset=""){
                $this->db->limit($limit, $offset);	
        }
		
        $query = $this->db->get();
        return $query;
    }
    
    function getBasicStudent($st_id, $school_year)
    {
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id','left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students.st_id', $st_id);
        if($school_year!=NULL):
            $this->db->where('profile_students_admission.school_year', $school_year);
        endif;
        $query = $this->db->get('profile_students');
        return $query->row();
    }
    
    function getStudentPerSection($section, $school_year)
    {
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_students.st_id as stid');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id','left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('section.section_id', $section);
        $this->db->order_by('lastname','ASC');
        $this->db->order_by('firstname','ASC');
        $this->db->order_by('middlename','ASC');
        if($school_year!=NULL):
            $this->db->where('profile_students_admission.school_year', $school_year);
        endif;
        $query = $this->db->get('profile_students');
        return $query->result();
    }
}
