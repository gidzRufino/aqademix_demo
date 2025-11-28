<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of chat_system
 *
 * @author genesis
 */
class Election extends MX_Controller {
    //put your code here
    //Global variable  
    
   public function __construct() {
        parent::__construct();
        $this->load->model('chat_system_model');
        //$this->load->library('pagination');
    }
    
    
    public function index()
    {
        $data['modules'] = 'election';
        $data['main_content'] = 'default';
        echo Modules::run('templates/college', $data);
    }
    

}
