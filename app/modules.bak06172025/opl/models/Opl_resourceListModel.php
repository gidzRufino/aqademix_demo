<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opl
 *
 * @author genesisrufino
 */
class Opl_resourcelistModel extends MX_Controller {
    //put your code here
    

    function addResources($details,$school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if($this->db->insert('opl_resourcelist', $details)):
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }


    function getResources(){
        
        return $this->db->get('opl_resourcelist')->result();
        
    }














}