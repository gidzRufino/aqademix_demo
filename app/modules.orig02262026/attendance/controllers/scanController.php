<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of scanController
 *
 * @author genesis
 */
class scanController extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('attendance_model');
    	
    }
    
    function checkIfFirstScan($id)
    {
        $result = $this->attendance_model->attendanceCheck($id);
        if($result->num_rows()==0){
            return TRUE;
            
        }else{
            return FALSE;
        }
    }
    
}

?>
