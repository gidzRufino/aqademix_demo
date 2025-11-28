<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
class Settings_model extends CI_Model {

    //put your code here

    function getMenu() {
        $q = $this->db->get('c_menu');
        return $q->result();
    }

    function checkAccess($user_id) {
        $this->db->where('cma_user_id', $user_id);
        $q = $this->db->get('c_menu_access');
        if ($q->num_rows() > 0):
            return $q->row();
        else:
            return FALSE;
        endif;
    }

    function saveAccess($user_id, $details) {
        $this->db->where('cma_user_id', $user_id);
        $q = $this->db->get('c_menu_access');
        if ($q->num_rows() > 0):
            $this->db->where('cma_user_id', $user_id);
            $this->db->update('c_menu_access', $details);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
        else:
            $this->db->insert('c_menu_access', $details);
        endif;

        return TRUE;
    }

}
