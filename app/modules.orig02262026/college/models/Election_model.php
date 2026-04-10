<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Settings_model
 *
 * @author genru
 */
class Election_model extends CI_Model {
    //put your code here
    
    function closeElection($value)
    {
        $this->db->where('es_id', 1);
        $this->db->update('election_settings', array('election_is_close' => $value, 'result_is_open'=>($value==0?0:'')));
    }
    
    function updateTotalVotes()
    {
        $this->db->where('es_id', 1);
        $q = $this->db->get('election_settings');
        
        $totalVotes = $q->row()->total_votes;
        
        $this->db->where('es_id', 1);
        $this->db->update('election_settings', array('total_votes' => $totalVotes + 1));
    }
    
    function openResult($value)
    {
        $this->db->where('es_id', 1);
        $this->db->update('election_settings', array('result_is_open' => $value));
    }
    
    function getElectionSettings()
    {
        $q = $this->db->get('election_settings');
        return $q->row();
    }

    function getVotes($pos_id, $can_id)
    {
        if($can_id!=NULL):
            $this->db->where('v_can_id', $can_id);
        endif;
            $this->db->where('v_pos_id', $pos_id);
        $q = $this->db->get('election_casted_votes');
        return $q;
    }
    function castVotes($details)
    {
        $this->db->insert('election_casted_votes', $details);
        return;
    }
    
    function updateVoterStatus($st_id)
    {
        $this->db->where('rv_st_id', $st_id);
        $this->db->update('election_registered_voters', array('voted_already' => 1));
    }
    
    function checkIfVoted($rfid)
    {
        $this->db->where('rv_rfid', $rfid);
        $q = $this->db->get('election_registered_voters');
        if($q->num_rows()>0):
            $this->db->where('rv_st_id', $q->row()->rv_st_id);
            $this->db->where('voted_already', 1);
            $q1 = $this->db->get('election_registered_voters');
            if($q1->num_rows()>0):
                return json_encode(array('status' => TRUE, 'msg' => 'Student has already cast Votes'));
            else:
                return json_encode(array('status' => FALSE, 'msg' => 'Student is already registered'));
            endif;
        else:
            return json_encode(array('status' => FALSE));
        endif;
    }
    
    function isRegistered($st_id)
    {
        $this->db->where('rv_st_id', $st_id);
        $q = $this->db->get('election_registered_voters');
        if($q->num_rows()>0):
            $this->db->where('rv_st_id', $st_id);
            $this->db->where('voted_already', 1);
            $q1 = $this->db->get('election_registered_voters');
            if($q1->num_rows()>0):
                return json_encode(array('status' => FALSE,'msg' => 'Student has already cast Votes'));
            else:
                return json_encode(array('status' => TRUE,'msg' => 'Student is already registered'));
            endif;
        else:    
            return json_encode(array('status' => FALSE, 'msg' => 'Student is not registered'));
        endif;
    }
    
    function registerVoter($details, $id)
    {
        $this->db->where('rv_st_id', $id);
        $q = $this->db->get('election_registered_voters');
        if($q->num_rows()>0):
            $this->db->where('rv_st_id', $id);
            $this->db->where('voted_already', 1);
            $q1 = $this->db->get('election_registered_voters');
            if($q1->num_rows()>0):
                return json_encode(array('msg' => 'Student had already cast Votes'));
            else:
                return json_encode(array('msg' => 'Student is already registered'));
            endif;
        else:
            $this->db->insert('election_registered_voters', $details);
            return json_encode(array('msg' => 'Student is successfully registered'));
        endif;
    }
    
    function removeCandidate($can_id)
    {
        $this->db->where('ec_id', $can_id);
        if($this->db->delete('election_candidates')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getBasicInfoBySTID($user_id)
    {
        $this->db->where('profile_students.st_id', $user_id);
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_c_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id','left');
        $query = $this->db->get('profile_students');
        return $query->row();
    }
    
    function getCandidateList($pos_id)
    {   
        $this->db->where('ec_pos_id', $pos_id);
        $q = $this->db->get('election_candidates');
        return $q->result();
    }
            
    function addCandidate($details, $st_id)
    {
        $this->db->where('ec_st_id', $st_id);
        $q = $this->db->get('election_candidates');
        if($q->num_rows()>0):
            return FALSE;
        else:
            $this->db->insert('election_candidates', $details);
            return TRUE;
        endif;
    }
    
    function getCandidatePosition()
    {
        $q = $this->db->get('election_position');
        return $q->result();
    }
    
    function searchStudent($value)
    {
        $this->db->select('*');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_c_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id','left');
        $this->db->like('lastname', $value, 'both');
        $this->db->order_by('lastname');
        $this->db->order_by('firstname');
        $this->db->group_by('profile.user_id');
        $this->db->where('school_year', $this->session->userdata('school_year'));
        
        $q = $this->db->get();
        return $q->result();
    }
    
    function scanStudent($value)
    {
        $this->db->select('*');
        $this->db->select('profile.user_id as pid');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_c_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id','left');
        $this->db->where('rfid', $value);
        $this->db->where('school_year', $this->session->userdata('school_year'));
        
        $q = $this->db->get();
        return $q->row();
    }
    
}
