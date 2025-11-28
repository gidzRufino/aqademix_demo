<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class web_sync_model extends CI_Model{
    
    function insertDataSync($query)
    {
        if($this->db->query($query)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getData()
    {
        $this->db->select('id');
        $this->db->select('run_script');
        $this->db->limit(30); 
        $this->db->order_by('id', 'ASC');
        return $this->db->get('websync_controller');
    }
    
    
    function checkData($table, $pk, $pk_value)
    { 
        $this->db->where($pk, $pk_value);
        $query = $this->db->get($table);
        if($query->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function updateNumType($num_of_updates, $type_id)
    {
        $this->db->where('type_id', $type_id);
        $this->db->update('update_types', $num_of_updates);
        return TRUE;
    }
    
    function checkUpdateType($type_id)
    {
        $this->db->select('*');
        $this->db->from('update_types');
        $this->db->where('type_id', $type_id);
        $query = $this->db->get();
        return $query->row();
    }
    function checkUpdates()
    {
       $this->db->limit(30); 
       $this->db->where('type', 3);
       $query = $this->db->get('updated_tables');
       if($query->num_rows()>0):$this->db->limit(30); 
            $this->db->limit(30); 
            $this->db->where('type', 3);
            $query2 = $this->db->get('updated_tables');
            return $query2;
       else:
            $this->db->limit(30); 
            $query2 = $this->db->get('updated_tables');
            return $query2;
       endif;
       
    }
    
    function insertTables($details)
    {
        $this->db->insert('updated_tables', $details);
        return;
    }
    
    
    function getCreatedData($table, $primary_key, $pk_value)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($primary_key, $pk_value);
        $query = $this->db->get();
        return $query->row();
    }
    
    function insertSyncData($details, $table)
    {
        if($this->db->insert($table, $details)):
           return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function updateSyncData($tableFields, $table, $primary_key, $pk_value)
    {
        $this->db->where($primary_key, $pk_value);
        if($this->db->update($table, $tableFields)):
           return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function deleteSyncData($primary_key,$pk_value, $table)
    {
        $this->db->where($primary_key, $pk_value);
        if($this->db->delete($table)):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
    
    function emptyTable($id)
    {
        $this->db->where('id', $id);
        if($this->db->delete('websync_controller')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
        
    function getInitialUpdates($table)
    {
        $query = $this->db->get($table);
        return $query;
    }
    
    function getContactUpdates()
    {
        $this->db->select('*');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('mother_tongue', 'profile_students.mother_tongue_id = mother_tongue.mt_id', 'left');
        $this->db->join('ethnic_group', 'profile.ethnic_group_id = ethnic_group.eg_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        $query = $this->db->get();
        
        return $query;
    }
}