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
class Student_model extends MX_Controller {
    //put your code here
    
    function saveResponse($details, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if($this->db->insert('opl_task_submitted', $details)):
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function createResponse($details, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if($this->db->insert('opl_task_submitted', $details)):
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getSubjectList($grade_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('grade_level_id', $grade_id);
        $this->db->join('subjects','subjects_settings.sub_id = subjects.subject_id','left');
        return $this->db->get('subjects_settings')->result();
    }
    
}
