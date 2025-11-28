<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opl_models
 *
 * @author genesisrufino
 */
class Opl_model extends MX_Controller {
    //put your code here
    
    function getDiscussionDetails($discuss_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->join('profile_employee', 'opl_discussion.dis_author_id = profile_employee.employee_id');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id');
        $this->db->where('dis_sys_code', $discuss_id);
        return $this->db->get('opl_discussion')->row();
        
    }
    
    function getPost()
    {
        $this->db->join('profile_employee', 'opl_posts.op_owner_id = profile_employee.employee_id');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id');
        $this->db->order_by('op_timestamp','DESC');
        $this->db->limit(10);
        $post = $this->db->get('opl_posts');
        return $post->result();
    }
    
    function submitPost($details, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if($this->db->insert('opl_posts', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function addDiscussion($discussionDetails, $code, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if($code==NULL):
            if($this->db->insert('opl_discussion', $discussionDetails)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $this->db->where('dis_sys_code', $code);
            if($this->db->update('opl_discussion', $discussionDetails)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function sendComment($details)
    {
        if($this->db->insert('opl_comments', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getTaskDetails($task_code, $school_year, $isStudent = NULL)
    {
        
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('task_auto_id', $task_code);
        ($isStudent!=NULL?$this->db->where('task_start_time <=', date('Y-m-d G:i:s')):'');
        $this->db->join('profile_employee', 'opl_tasks.task_author_id = profile_employee.employee_id','left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id','left');
        $this->db->join('opl_task_type', 'opl_tasks.task_type = opl_task_type.tt_id','left');
        $this->db->order_by('task_start_time','DESC');
        $q = $this->db->get('opl_tasks');
        return $q->row();
    }
    
    function getUnitDetails($code, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->join('subjects','opl_units.ou_subject_id = subjects.subject_id','left');
        $this->db->where('ou_opl_code', $code);
        $q = $this->db->get('opl_units');
        return $q->row();
    }
    
    
    function getUnits($grade_level, $subject, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('ou_subject_id', $subject);
        $this->db->where('ou_grade_level_id', $grade_level);
        $q = $this->db->get('opl_units');
        return $q->result();
    }
    
    function saveUnit($details, $unitTitle, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('ou_unit_title', $unitTitle);
        $q = $this->db->get('opl_units')->num_rows();
        if($q == 0):
            if($this->db->insert('opl_units', $details)):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            else:
                return 0;
            endif;
        else:
            return 2;
        endif;
    }
    
    function getTask($grade_level, $section, $subject, $school_year, $isStudent = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('task_grade_id', $grade_level);
        $this->db->where('task_section_id', $section);
        $this->db->where('task_subject_id', $subject);
        ($isStudent!=NULL?$this->db->where('task_start_time <=', date('Y-m-d G:i:s')):'');
        ($isStudent!=NULL?$this->db->where('task_end_time >', date('Y-m-d G:i:s')):'');
        $this->db->join('profile_employee', 'opl_tasks.task_author_id = profile_employee.employee_id','left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id','left');
        $this->db->join('opl_task_type', 'opl_tasks.task_type = opl_task_type.tt_id','left');
        $this->db->order_by('task_start_time','DESC');
        $this->db->limit(15);
        $q = $this->db->get('opl_tasks');
        return $q->result();
    }
    
    function addTask($details, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if($this->db->insert('opl_tasks', $details)):
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
}
