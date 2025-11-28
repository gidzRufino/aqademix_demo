<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of pod_module
 *
 */

class pod_model extends CI_Model {

    function attendance_list($start, $end)
    {
        $this->db->select('date');
        $this->db->select('att_st_id');
        $this->db->select('attendance_sheet.time_in as at_time_in');
        $this->db->select('attendance_sheet.att_id as att_id');
        $this->db->select('attendance_sheet.time_in_pm as at_time_in_pm');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('section.time_in as st_time_in');
        $this->db->select('section.time_in_pm as st_time_in_pm');
        $this->db->select('section.section as section');
        $this->db->select('grade_level.grade_id as grade_id');
        $this->db->select('grade_level.level as level');
        // $this->db->select('count(*) as counts');
        $this->db->from('attendance_sheet');
        $this->db->join('profile_students_admission', 'attendance_sheet.att_st_id = profile_students_admission.st_id', 'left');
        $this->db->join('section', 'profile_students_admission.section_id = section.section_id','left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
        // $this->db->group_by('lastname');
        $this->db->where('attendance_sheet.date >=', $start);
        $this->db->where('attendance_sheet.date <', $end);
        $query = $this->db->get();
        return $query->result();
    }

    function grade_level()
    {
        $this->db->select('*');
        $this->db->from('grade_level');
        $query = $this->db->get();
        return $query->result();
    }

   function quarter()
   {
      $this->db->select('*');
      $this->db->from('settings_quarter');
      $query = $this->db->get();
      return $query->result();
   }

   function st_profile($id)
   {
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
      $this->db->join('section', 'profile_students_admission.section_id = section.section_id','left');
      $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
      $this->db->where('profile_students_admission.st_id', $id);
      $query = $this->db->get();
      return $query->row();
   }

   function e_profile($id)
   {
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
      $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id','left');
      $this->db->where('profile_employee.employee_id', $id);
      $query = $this->db->get();
      return $query->row();
   }

   function st_summary($st_id, $from, $to)
   {
        $this->db->select('*');
        $this->db->select('l_st_id, COUNT(l_st_id) as total');
        $this->db->from('tardy');
        $this->db->group_by('tardy.l_st_id');
        $this->db->where('tardy.l_st_id', $st_id);
        $this->db->where('l_date >=', $from);
        $this->db->where('l_date <=', $to);
        $query = $this->db->get();
        return $query->row();
   }

   function adviser($sid) // section id
   {
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
      $this->db->join('advisory', 'profile_employee.employee_id = advisory.faculty_id', 'left');
      $this->db->where('advisory.section_id', $sid);
      $query = $this->db->get();
      return $query->row();
   }

   function account_tardy($st_id)
   {
      $this->db->select('*');
      $this->db->from('tardy');
      $this->db->where('tardy.l_st_id', $st_id);
      $this->db->where('tardy.l_status <=', 3);
      $this->db->or_where('tardy.l_status', 5);
      $this->db->order_by('tardy.l_date', 'asc');
      $query = $this->db->get();
      return $query->result();
   }

    function etardy_today()
   {
      $today = date('Y-m-d');
      $this->db->select('*');
      $this->db->from('tardy');
      $this->db->join('profile_employee', 'tardy.l_st_id = profile_employee.employee_id', 'left');
      $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id','left');
      $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
      $this->db->where('tardy.l_date', $today);
      $this->db->where('tardy.l_account_type', 1); // employee
      $this->db->where('tardy.l_status <=', 3);
      $query = $this->db->get();
      return $query->result();
   }

   function tardy_today()
   {
      $today = date('Y-m-d');
      $this->db->select('*');
      $this->db->from('tardy');
      $this->db->join('profile_students_admission', 'tardy.l_st_id = profile_students_admission.st_id', 'left');
      $this->db->join('section', 'profile_students_admission.section_id = section.section_id','left');
      $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
      $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
      $this->db->where('tardy.l_date', $today);
      $this->db->where('tardy.l_account_type', 0); // student
      $this->db->where('tardy.l_status <=', 3);
      $this->db->where('grade_level.grade_id >', 1);
      $this->db->where('grade_level.grade_id <', 14);
      $query = $this->db->get();
      return $query->result();
   } 

   function all_time($from, $to)
   {
      $today = date('Y-m-d');
      $this->db->select('*');
      $this->db->select('l_st_id, COUNT(l_st_id) as total');
      $this->db->from('tardy');
      $this->db->join('profile_students_admission', 'tardy.l_st_id = profile_students_admission.st_id', 'left');
      $this->db->join('section', 'profile_students_admission.section_id = section.section_id','left');
      $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
      $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
      $this->db->group_by('tardy.l_st_id');
      $this->db->order_by('total', 'desc');
      // $this->db->where('tardy.l_date', $today);
      $this->db->where('tardy.l_status <=', 3);
      $this->db->where('l_date >=', $from);
      $this->db->where('l_date <=', $to);
      $this->db->where('grade_level.grade_id >', 1);
      $this->db->where('grade_level.grade_id <', 14);
      // $this->db->where('total >=', 3);
      $query = $this->db->get();
      return $query->result();
   }

   function all_time_hs($from, $to)
   {
      $today = date('Y-m-d');
      $this->db->select('*');
      $this->db->select('l_st_id, COUNT(l_st_id) as total');
      $this->db->from('tardy');
      $this->db->join('profile_students_admission', 'tardy.l_st_id = profile_students_admission.st_id', 'left');
      $this->db->join('section', 'profile_students_admission.section_id = section.section_id','left');
      $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
      $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
      $this->db->group_by('tardy.l_st_id');
      $this->db->order_by('total', 'desc');
      // $this->db->where('tardy.l_date', $today);
      $this->db->where('tardy.l_status <=', 3);
      $this->db->where('l_date >=', $from);
      $this->db->where('l_date <=', $to);
      $this->db->where('grade_level.grade_id >', 7);
      $this->db->where('grade_level.grade_id <', 14);
      // $this->db->where('total >=', 3);
      $query = $this->db->get();
      return $query->result();
   }

    function all_time_gs($from, $to)
   {
      $today = date('Y-m-d');
      $this->db->select('*');
      $this->db->select('l_st_id, COUNT(l_st_id) as total');
      $this->db->from('tardy');
      $this->db->join('profile_students_admission', 'tardy.l_st_id = profile_students_admission.st_id', 'left');
      $this->db->join('section', 'profile_students_admission.section_id = section.section_id','left');
      $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
      $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
      $this->db->group_by('tardy.l_st_id');
      $this->db->order_by('total', 'desc');
      // $this->db->where('tardy.l_date', $today);
      $this->db->where('tardy.l_status <=', 3);
      $this->db->where('l_date >=', $from);
      $this->db->where('l_date <=', $to);
      $this->db->where('grade_level.grade_id >', 1);
      $this->db->where('grade_level.grade_id <', 8);
      // $this->db->where('total >=', 3);
      $query = $this->db->get();
      return $query->result();
   }

   function all_time_gid($gid, $from, $to)
   {
      $today = date('Y-m-d');
      $this->db->select('*');
      $this->db->select('l_st_id, COUNT(l_st_id) as total');
      $this->db->from('tardy');
      $this->db->join('profile_students_admission', 'tardy.l_st_id = profile_students_admission.st_id', 'left');
      $this->db->join('section', 'profile_students_admission.section_id = section.section_id','left');
      $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
      $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
      $this->db->group_by('tardy.l_st_id');
      $this->db->order_by('total', 'desc');
      $this->db->where('tardy.l_status <=', 3);
      $this->db->where('l_date >=', $from);
      $this->db->where('l_date <=', $to);
      $this->db->where('grade_level.grade_id', $gid);
      
      $query = $this->db->get();
      return $query->result();
   }

    function save_tardy($data)
    {
        $this->db->insert('tardy', $data);
        return $this->db->insert_id();
    }

    function update_tardy($data, $id)
    {
      $this->db->where('l_id', $id);
      $this->db->update('tardy', $data);
      return;
    }

    function searchEmployeeAccounts($value, $year)
    {
        if($value!=""):
            if($year!=NULL):
                $this->db = $this->eskwela->db($year);
                $this->db->select('profile_employee.employee_id as emp_id');
                $this->db->select('profile.user_id as uid');
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->from('profile_employee');
                $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
                $this->db->like('lastname', $value);
                $this->db->or_like('firstname', $value);
                $this->db->order_by('lastname', 'ASC');
                $this->db->limit(10);
                $this->db->where('account_type!=', 5);
                $query = $this->db->get();
                return $query->result();
            else:
                $year = $this->session->userdata('school_year');
                $this->db = $this->eskwela->db($year);
                $this->db->select('profile_employee.employee_id as emp_id');
                $this->db->select('profile.user_id as uid');
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->from('profile_employee');
                $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
                $this->db->like('lastname', $value);
                $this->db->or_like('firstname', $value);
                $this->db->order_by('lastname', 'ASC');
                $this->db->limit(10);
                $this->db->where('account_type!=', 5);
                $query = $this->db->get();
                return $query->result();
            endif;      
        else:   
            $this->db->select('profile_employee.employee_id as emp_id');
            $this->db->select('profile.user_id as uid');
            $this->db->select('lastname');
            $this->db->select('firstname');
            $this->db->select('middlename');
            $this->db->from('profile_employee');
            $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
            $this->db->order_by('lastname', 'ASC');
            $this->db->limit(10);
            
            $this->db->where('account_type!=', 5);

            $query = $this->db->get();
            return $query->result();
        endif;
    
    }

   //  function save_entrance_out($ent, $ltrans_id)
   // {
   //    $this->db->where('en_id', $ltrans_id);
   //    $this->db->update('lib_entrance', $ent);
   //    return;
   // } 98 -> 192

   // function update_book_info($items, $bk_id)
   // {
   //    $this->db->where('bk_id', $bk_id);
   //    $this->db->update('lib_book', $items);
   //    return;
   // }
            
}
