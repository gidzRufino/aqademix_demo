<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of attendance
 *
 * @author genesis
 */

class daily_lesson_log_model extends CI_Model{
    
    function getDllSections()
    {
        $q = $this->db->get('dll_sections');
        return $q->result();
    }
    
    function getDllRemarks($dll_id)
    {
        $this->db->where('rem_dll_id', $dll_id);
        $q = $this->db->get('dll_remarks');
        return $q;
    }
    
    function getComments($dll_id)
    {
        $this->db->where('com_dll_id', $dll_id);
        $q = $this->db->get('dll_comments');
        return $q;
    }
    
    function updateDllRemarks($a, $p, $ap, $d, $b,$total, $dll_id)
    {
        $array=array(
            'a' => $a,
            'p' => $p,
            'ap' => $ap,
            'd' => $d,
            'b' => $b,
            'total' => $total,
            'rem_dll_id' => $dll_id,
        );
        
//        $this->db->where('rem_dll_id', $dll_id);
//        $q = $this->db->get('dll_remarks');
//        if($q->num_rows>0):
//            $this->db->where('rem_dll_id', $dll_id);
//            $this->db->update('dll_remarks', $array);
//        else:
//            $this->db->insert('dll_remarks', $array);
//        endif;
    }
    
   function updateDll($id, $details)
   {
       $array = array(
           'dll_assess_id' => $details
       );
       
       $this->db->where('dll_id', $id);
       $this->db->update('dll', $array);
   }
    
    function deleteItem($item, $id)
    {
        switch ($item):
            case 'reference':
                $this->db->where('ref_id', $id);
                $this->db->delete('dll_references');
            break;    
            case 'materials':
                $this->db->where('mat_id', $id);
                $this->db->delete('dll_materials_used');
            break;    
            case 'activities':
                $this->db->where('act_id', $id);
                $this->db->delete('dll_activities');
                
            break;    
            case 'dll':
                $this->db->where('dll_id', $id);
                $this->db->delete('dll');
                
            break;    
        endswitch;
        
        return;
    }
    
    function checkDLL($id)
    {
        $details = array(
            'checked' => 1
        );
        $this->db->where('dll_id', $id);
        $this->db->update('dll', $details);
        
        $this->db->where('dll_id', $id);
        $q = $this->db->get('dll');
        return $q->row(); 
        
    }
    
    
    function getDLLbyID($id)
    {
        $details = array(
            'dll_submitted' => date('Y-m-d')
        );
        $this->db->where('dll_id', $id);
        $this->db->update('dll', $details);
        
        $this->db->where('dll_id', $id);
        $q = $this->db->get('dll');
        return $q->row(); 
        
    }
    
    function getActivities($dll_id)
    {
        $this->db->where('act_dll_id', $dll_id);
        $q = $this->db->get('dll_activities');
        return $q->result();
    }
    
    function getReferences($dll_id)
    {
        $this->db->join('dll_refmat_type','dll_references.ref_type_id = dll_refmat_type.type_id','left');
        $this->db->where('ref_dll_id', $dll_id);
        $this->db->order_by('type_id', 'ASC');
        $q = $this->db->get('dll_references');
        return $q->result();
    }
    
    function getMaterialUsed($dll_id)
    {
        $this->db->join('dll_refmat_type','dll_materials_used.mat_type_id = dll_refmat_type.type_id','left');
        $this->db->where('mat_dll_id', $dll_id);
        $this->db->order_by('type_id', 'ASC');
        $q = $this->db->get('dll_materials_used');
        return $q->result();
    }
    
    function submittedDLL($from, $to, $status)
    {
        
        $this->db->join('dll_lessons', 'dll.dll_id = dll_lessons.less_dll_id','left');
        $this->db->join('section', 'dll.dll_section_id = section.section_id','left');
        $this->db->join('subjects', 'dll.dll_sub_id = subjects.subject_id','left');
        $this->db->join('profile_employee', 'dll.t_id = profile_employee.employee_id', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->where("dll_date between '" . $from . "' and'" . $to . "'");
        $this->db->where("dll_submitted !=", '0000-00-00');
        if($status!=NULL):
            $this->db->where("checked", $status);
        endif;
        $this->db->group_by('t_id');
        $q = $this->db->get('dll');
        return $q;
    }
    
    function getDLLwSection($t_id, $from, $to)
    {
        $this->db->join('dll_lessons', 'dll.dll_id = dll_lessons.less_dll_id','left');
        $this->db->join('section', 'dll.dll_section_id = section.section_id','left');
        $this->db->join('subjects', 'dll.dll_sub_id = subjects.subject_id','left');
        if($t_id!=NULL):
            $this->db->where('t_id', $t_id);
        else:
            $this->db->join('profile_employee', 'dll.t_id = profile_employee.employee_id', 'left');
            $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        endif;
        if($from!=NULL):
            $this->db->where("dll_date between '" . $from . "' and'" . $to . "'");
        endif;
        $this->db->where('school_year', $this->session->userdata('school_year'));
        $this->db->order_by('dll_date', 'ASC');
        $q = $this->db->get('dll');
        
        return $q;
        
    }
    
    
    function getDLL($t_id, $from, $to)
    {
        $this->db->join('dll_lessons', 'dll.dll_id = dll_lessons.less_dll_id','left');
        $this->db->join('subjects', 'dll.dll_sub_id = subjects.subject_id','left');
        if($t_id!=NULL):
            $this->db->where('t_id', $t_id);
        else:
            $this->db->join('profile_employee', 'dll.t_id = profile_employee.employee_id', 'left');
            $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        endif;
        if($from!=NULL):
            $this->db->where("dll_date between '" . $from . "' and'" . $to . "'");
        endif;
        $this->db->where('school_year', $this->session->userdata('school_year'));
        $this->db->order_by('dll_date', 'ASC');
        $q = $this->db->get('dll');
        
        return $q;
        
    }
    
    function getRefMat()
    {
        $query = $this->db->get('dll_refmat_type');
        return $query->result();
    }
    
    function saveMaterial($details)
    {
        $this->db->insert('dll_materials_used', $details);
        $mat_id = $this->db->insert_id();
        
        $this->db->join('dll_refmat_type', 'dll_materials_used.mat_type_id = dll_refmat_type.type_id');
        $this->db->where('mat_id', $mat_id);
        $q = $this->db->get('dll_materials_used');
        return $q->row();
    }
    
    function saveReference($details)
    {
        $this->db->insert('dll_references', $details);
        $mat_id = $this->db->insert_id();
        
        $this->db->join('dll_refmat_type', 'dll_references.ref_type_id = dll_refmat_type.type_id');
        $this->db->where('ref_id', $mat_id);
        $q = $this->db->get('dll_references');
        return $q->row();
    }
    
    function saveActivities($details)
    {
        $this->db->insert('dll_activities', $details);
        $mat_id = $this->db->insert_id();
        
        $this->db->where('act_id', $mat_id);
        $q = $this->db->get('dll_activities');
        return $q->row();
    }
    
    function saveComment($details, $dll_id)
    {
        $this->db->where('com_dll_id', $dll_id);
        $q = $this->db->get('dll_comments');
        if($q->num_rows()>0):
            $this->db->where('com_dll_id', $dll_id);
            $this->db->update('dll_comments', $details);
        else:
            $this->db->insert('dll_comments', $details);
        endif;
    }
    
    function saveDLL($details)
    {
        $this->db->insert('dll', $details);
        return $this->db->insert_id();
    }
    
    function saveLesson($details)
    {
        $this->db->insert('dll_lessons', $details);
        return $this->db->insert_id();
    }
    
}